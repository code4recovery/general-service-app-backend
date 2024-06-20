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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('area')->nullable();
            $table->unsignedInteger('district')->nullable();
            $table->string('name');
            $table->string('banner')->nullable();
            $table->string('website')->nullable();
            $table->string('language', 2)->nullable();
            $table->timestamps();
        });

        Schema::create('entity_user', function (Blueprint $table) {
            $table->foreignId('entity_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 7)->unique();
            $table->foreignId('entity_id')->constrained();
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->date('start_at');
            $table->date('end_at');
            $table->foreignId('user_id')->constrained();
            $table->smallInteger('order')->unsigned()->nullable();
            $table->string('language', 2);
            $table->timestamps();
        });

        Schema::create('buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained();
            $table->string('title');
            $table->string('link');
            $table->string('style');
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
        Schema::dropIfExists('entity_user');
        Schema::dropIfExists('entities');
    }
};
