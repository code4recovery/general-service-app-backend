<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ImportKmz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-kmz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // fetch file with latest polygons
        $file = Http::get('https://www.google.com/maps/d/kml?mid=' . env('GOOGLE_MY_MAP_ID'));
        $this->info('fetched map ' . env('GOOGLE_MY_MAP_ID'));

        // save file locally
        Storage::put('temp.kmz', $file->body());
        $this->info('saved temp.kmz');

        // unzip file
        $zip = new ZipArchive();
        $opened = $zip->open(storage_path('app/temp.kmz'));
        if ($opened === true) {
            $zip->extractTo(storage_path('app/temp'));
            $zip->close();
            $this->info('unzipped temp file');
        } else {
            $this->error('Failed to open temp file');
            exit;
        }

        // read file
        $file = Storage::get('temp/doc.kml');
        $xml = simplexml_load_string($file);

        // clean up
        Storage::delete('temp.kmz');
        Storage::deleteDirectory('temp');
        $this->info("cleaned up");

        // load styles
        $styles = [];
        foreach ($xml->Document->Style as $style) {
            $styles['#' . $style->attributes()['id']] = '#' . substr($style->PolyStyle->color->__toString(), 0, 6);
        }

        $colors = [];
        foreach ($xml->Document->StyleMap as $styleMap) {
            $colors['#' . $styleMap->attributes()['id']] = $styles[$styleMap->Pair->styleUrl->__toString()];
        }

        // parse file
        $districts = [];
        foreach ($xml->Document->Folder as $folder) {
            $area = explode(' ', $folder->name)[0];
            foreach ($folder->Placemark as $placemark) {
                list($district, $name) = explode(' ', $placemark->name);
                $districts[] = [
                    'area' => $area,
                    'district' => $district,
                    'name' => $name,
                    'color' => $colors[$placemark->styleUrl->__toString()],
                    'boundary' => 'POLYGON((' . join(',', array_map(
                        function ($coordinates) {
                            list($lng, $lat) = explode(',', $coordinates);
                            return $lng . ' ' . $lat;
                        },
                        array_filter(
                            array_map(
                                'trim',
                                explode("\n", $placemark->Polygon->outerBoundaryIs->LinearRing->coordinates)
                            )
                        )
                    )) . '))'
                ];
            }
        }
        $this->info('parsed ' . count($districts) . ' districts');

        // save polygons to database
        foreach ($districts as $district) {
            $entity = Entity::where('area', $district['area'])
                ->where('district', $district['district'])
                ->first();
            if ($entity) {
                $entity->update([
                    'color' => $district['color'],
                    'boundary' => DB::raw("ST_GeomFromText('" . $district['boundary'] . "')")
                ]);
                $this->info('updated ' . $entity->name());
            }
        }

        // update json files
        Controller::updateMapJson();
    }
}
