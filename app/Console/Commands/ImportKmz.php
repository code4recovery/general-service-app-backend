<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        // fetch file with live polygons
        $file = Http::get('https://www.google.com/maps/d/kml?mid=' . env('GOOGLE_MY_MAP_ID'));
        $this->info("Fetched file");

        // save file locally
        Storage::put('temp.kmz', $file->body());
        $this->info('Saved temp.kmz');

        // unzip file
        $zip = new ZipArchive();
        $opened = $zip->open(storage_path('app/temp.kmz'));
        if ($opened === true) {
            $zip->extractTo(storage_path('app/temp'));
            $zip->close();
            $this->info('Opened temp file');
        } else {
            $this->error('Failed to open temp file');
            exit;
        }

        // read file
        $file = Storage::get('temp/doc.kml');
        $xml = simplexml_load_string($file);
        $this->info(print_r($xml, true));

        // clean up
        Storage::delete('temp.kmz');
        Storage::deleteDirectory('temp');
        $this->info("cleaned up");

        // todo parse file
        // save polygons to database
    }
}
