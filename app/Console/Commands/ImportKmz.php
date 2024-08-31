<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Exception;
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

        $areas = Entity::whereNotNull('area')->whereNull('district')->whereNotNull('map_id')->get();

        foreach ($areas as $area) {

            // download kmz file
            try {
                $xml = self::downloadKmz($area->map_id);
            } catch (Exception $e) {
                $this->error('could not download kmz file for ' . $area->name() . ': ' . $e->getMessage());
                continue;
            }

            // load styles
            $styles = [];
            foreach ($xml->Document->Style as $style) {
                $styles['#' . $style->attributes()['id']] = '#' . substr($style->PolyStyle->color->__toString(), 6, 2). substr($style->PolyStyle->color->__toString(), 4, 2). substr($style->PolyStyle->color->__toString(), 2, 2);
            }

            $colors = [];
            foreach ($xml->Document->StyleMap as $styleMap) {
                $colors['#' . $styleMap->attributes()['id']] = $styles[$styleMap->Pair->styleUrl->__toString()];
            }

            // parse file
            $districts = [];
            foreach ($xml->Document->Folder as $layer) {
                $import = stristr($layer->name, 'district');
                $language = stristr($layer->name, 'French') ? 'fr' : (stristr($layer->name, 'Spanish') ? 'es' : 'en');

                foreach ($layer->Placemark as $placemark) {

                    // skip if not a polygon
                    if (!isset($placemark->Polygon->outerBoundaryIs->LinearRing->coordinates)) {
                        $this->error('skipping ' . $placemark->name . ' because it is not a polygon');
                        continue;
                    }

                    // skip if not a district
                    if (!$import && !stristr($placemark->name, 'district')) {
                        $this->error('skipping ' . $placemark->name . ' because it is not a district');
                        continue;
                    }

                    // parse district name
                    list($district, $name) = self::parseDistrictName($placemark->name);

                    // add district
                    $districts[] = [
                        'area' => $area,
                        'district' => $district,
                        'name' => $name,
                        'language' => $language,
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
            $this->info('parsed ' . count($districts) . ' districts for ' . $area->name());

            continue;

            // save polygons to database
            foreach ($districts as $district) {
                $entity = Entity::where('area', $district['area'])
                    ->where('district', $district['district'])
                    ->first();
                if ($entity) {
                    $entity->update([
                        'name' => $district['name'],
                        'color' => $district['color'],
                        'language' => $district['language'],
                        'boundary' => DB::raw("ST_GeomFromText('" . $district['boundary'] . "')")
                    ]);
                    $this->info('updated ' . $entity->name());
                } else {
                    $entity = Entity::create([
                        'area' => $district['area'],
                        'district' => $district['district'],
                        'name' => $district['name'],
                        'language' => $district['language'],
                        'color' => $district['color'],
                        'boundary' => DB::raw("ST_GeomFromText('" . $district['boundary'] . "')")
                    ]);
                    $this->info('created ' . $district['name']);
                }
                Controller::updateJson($entity->id);
            }
        }

        // update json files
        Controller::updateMapJson();
    }

    private static function downloadKmz($map_id)
    {
        // fetch file with latest polygons
        $file = Http::get('https://www.google.com/maps/d/kml?mid=' . $map_id);


        // save file locally
        Storage::put('temp.kmz', $file->body());


        // unzip file
        $zip = new ZipArchive();
        $opened = $zip->open(storage_path('app/temp.kmz'));
        if ($opened === true) {
            $zip->extractTo(storage_path('app/temp'));
            $zip->close();
        } else {
            throw new Exception('Could not open kmz file');
        }

        // read file
        $file = Storage::get('temp/doc.kml');
        $xml = simplexml_load_string($file);

        // clean up
        Storage::delete('temp.kmz');
        Storage::deleteDirectory('temp');

        return $xml;
    }

    private static function parseDistrictName($placemarkName)
    {
        $placemarkName = trim($placemarkName);

        // remove District prefix (e.g. District 1: Downtown)
        if (str_starts_with($placemarkName, 'District ')) {
            $placemarkName = substr($placemarkName, 0, 9);
        }

        $districtParts = array_map('trim', explode(':', $placemarkName, 2));
        if (count($districtParts) === 1) {
            return [$districtParts[0], null];
        }
        return $districtParts;
    }
}
