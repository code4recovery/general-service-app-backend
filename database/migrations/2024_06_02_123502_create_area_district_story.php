<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->unique();
            $table->string('name');
            $table->string('website');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->unsignedInteger('number');
            $table->string('name');
            $table->string('website')->nullable();
            $table->timestamps();
        });

        Schema::create('district_user', function (Blueprint $table) {
            $table->foreignId('district_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained();
            $table->string('title');
            $table->string('link');
            $table->enum('style', ['primary', 'secondary']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buttons');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('district_user');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('areas');
    }
};
