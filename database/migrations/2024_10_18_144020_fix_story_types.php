<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\StoryController;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // make sure all story types are valid
        $storyController = new StoryController();
        $types = array_keys($storyController->types);
        DB::table('stories')->whereNotIn('type', $types)->update(['type' => $types[0]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
