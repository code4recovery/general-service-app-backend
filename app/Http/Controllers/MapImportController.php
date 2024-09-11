<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use ZipArchive;

class MapImportController extends Controller
{
    //
    public function index()
    {
        $areas = Entity::whereNotNull('area')->where('district', null)->whereNotNull('map_id')->get()->map(function ($area) {
            return [
                'name' => $area->name,
                'url' => URL::to('/import/' . $area->area),
            ];
        });
        return response()->json($areas);
    }

    public function import()
    {

        $area = Entity::where('area', request('area'))->whereNull('district')->first();

        if (!$area) {
            return response()->json(['error' => 'Area not found'], 404);
        }

        if (!$area->map_id) {
            return response()->json(['error' => 'Area does not have a map_id'], 404);
        }

        try {
            $xml = self::downloadKmz($area->map_id);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not download kmz file: ' . $e->getMessage()], 500);
        }

        // load styles
        $styles = [];
        foreach ($xml->Document->Style as $style) {
            if (!isset($style->PolyStyle->color)) {
                continue;
            }
            $styles['#' . $style->attributes()['id']] = '#' . substr($style->PolyStyle->color->__toString(), 6, 2) . substr($style->PolyStyle->color->__toString(), 4, 2) . substr($style->PolyStyle->color->__toString(), 2, 2);
        }

        $colors = [];
        foreach ($xml->Document->StyleMap as $styleMap) {
            if (!isset($styleMap->Pair->styleUrl) || !isset($styles[$styleMap->Pair->styleUrl->__toString()])) {
                continue;
            }
            $colors['#' . $styleMap->attributes()['id']] = $styles[$styleMap->Pair->styleUrl->__toString()];
        }

        // parse file
        $districts = [];
        $counter = 0;

        foreach ($xml->Document->Folder as $layer) {
            $import = stristr($layer->name, 'district');
            $language = stristr($layer->name, 'French') ? 'fr' : (stristr($layer->name, 'Spanish') ? 'es' : 'en');

            foreach ($layer->Placemark as $placemark) {

                // skip if not a polygon
                if (!isset($placemark->Polygon->outerBoundaryIs->LinearRing->coordinates)) {
                    // $this->error('skipping ' . $placemark->name . ' because it is not a polygon');
                    continue;
                }

                // skip if not a district
                if (!$import && !stristr($placemark->name, 'district')) {
                    // $this->error('skipping ' . $placemark->name . ' because it is not a district');
                    continue;
                }

                // parse district name
                list($district, $name) = self::parseDistrictName($placemark->name);

                // parse district description
                $description = $placemark->description;
                foreach ($placemark->ExtendedData->Data as $data) {
                    if ($data['name'] == 'description') {
                        $description = $data->value;
                    }
                }
                list($description, $website) = self::parseDistrictDescription($description);

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
                    )) . '))',
                    'order' => $counter++,
                    'description' => $description,
                    'website' => $website,
                ];
            }
        }

        $log = [];

        $areaHasDistricts = Entity::where('area', $area->area)->whereNotNull('district')->count() > 0;

        // save polygons to database
        foreach ($districts as $district) {
            $entity = Entity::where('area', $area->area)
                ->where('district', $district['district'])
                ->first();
            if ($entity) {
                $entity->update([
                    // 'name' => $district['name'],
                    // 'language' => $district['language'],
                    'color' => $district['color'],
                    'boundary' => DB::raw("ST_GeomFromText('" . $district['boundary'] . "')"),
                    'order' => $district['order'],
                    'description' => $district['description'],
                    'website' => $district['website'],
                ]);
                $log[] = 'updated ' . $entity->name();
                Controller::updateJson($entity->id);
            } else if (!$areaHasDistricts) {
                $entity = Entity::create([
                    'area' => $area->area,
                    'district' => $district['district'],
                    'name' => $district['name'],
                    'language' => $district['language'],
                    'color' => $district['color'],
                    'boundary' => DB::raw("ST_GeomFromText('" . $district['boundary'] . "')"),
                    'order' => $district['order'],
                    'description' => $district['description'],
                    'website' => $district['website'],
                ]);
                $log[] = 'created area: ' . $area->area . ' district: ' . $district['district'] . ' name: ' . $district['name'];
                Controller::updateJson($entity->id);
            } else {
                $log[] = 'skipped adding area: ' . $area->area . ' district: ' . $district['district'] . ' name: ' . $district['name'];
            }
        }

        Controller::updateMapJson();

        return response()->json($log);
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
            $placemarkName = substr($placemarkName, 9);
        }

        $districtParts = array_map('trim', explode(':', $placemarkName, 2));
        if (count($districtParts) === 1) {
            return [$districtParts[0], null];
        }

        return $districtParts;
    }

    private static function parseDistrictDescription($placemarkDescription)
    {
        $description = null;
        $website = null;

        $description_lines = array_values(array_filter(array_map('trim', explode('<br>', $placemarkDescription))));
        $number_of_lines = count($description_lines);

        if ($number_of_lines) {

            $lastRow = $description_lines[$number_of_lines - 1];

            if (filter_var($lastRow, FILTER_VALIDATE_URL)) {
                $website = array_pop($description_lines);
            }

            if (count($description_lines)) {
                $description = implode("\n", $description_lines);
            }
        }


        return [$description, $website];
    }


}
