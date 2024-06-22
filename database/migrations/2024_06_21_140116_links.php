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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained();
            $table->string('title');
            $table->string('target');
            $table->foreignId('user_id')->constrained();
            $table->smallInteger('order')->unsigned()->nullable();
            $table->string('language', 2);
            $table->timestamps();
        });

        Schema::table('entities', function (Blueprint $table) {
            $table->string('banner_dark')->nullable()->after('banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');

        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('banner_dark');
        });
    }
};
