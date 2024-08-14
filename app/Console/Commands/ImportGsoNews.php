<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Story;
use App\Models\Button;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StoryController;

class ImportGsoNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-gso-news';

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

        $storyController = new StoryController();
        $local_stories = Story::where('entity_id', 1)->get();

        $see_more = [
            'en' => 'See More',
            'es' => 'Ver Más',
            'fr' => 'Voir Plus',
        ];
        $languages = array_keys($see_more);
        $count = 0;

        foreach ($languages as $language) {
            $response = Http::get(env('MEETING_GUIDE_API_BASE') . $language)->json();

            foreach ($response['news'] as $remote_story) {
                $count++;

                $datetime = new Carbon($remote_story['datetime']);

                if ($story = $local_stories
                    ->where('created_at', $datetime)
                    ->where('language', $language)
                    ->first()
                ) {
                    $this->info('Updating ' . $remote_story['title']);

                    $story->update([
                         'title' => $remote_story['title'],
                         'description' => $remote_story['content'],
                         'language' => $language,
                         'start_at' => $datetime,
                         'end_at' => $datetime->copy()->addMonths(1),
                         'count' => $count,
                     ]);

                    $button = $story->buttons->first();

                    if ($remote_story['button_url']) {
                        $story->buttons()->update([
                            'title' => $remote_story['button_text'] ?? $see_more[$language],
                            'link' => $remote_story['button_url'],
                        ]);
                    } elseif ($button) {
                        $button->delete();
                    }

                } else {

                    $this->info('Adding story ' . $remote_story['title']);

                    $story = Story::create([
                        'entity_id' => 1,
                        'title' => $remote_story['title'],
                        'description' => $remote_story['content'],
                        'type' => 'announcement',
                        'reference' => $storyController->reference(),
                        'language' => $language,
                        'start_at' => $datetime,
                        'end_at' => $datetime->copy()->addMonths(1),
                        'created_at' => $datetime,
                        'user_id' => 1,
                        'count' => $count,
                    ]);

                    if ($remote_story['button_url']) {
                        $story->buttons()->create([
                            'title' => $remote_story['button_text'] ?? $see_more[$language],
                            'link' => $remote_story['button_url'],
                            'style' => 'primary',
                        ]);
                    }
                }

            }
        }

        Controller::updateJson(1);

    }
}
