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
        Schema::table('entities', function (Blueprint $table) {
            $table->string('map_id', 255)->nullable();
            $table->string('timezone', 255)->default('America/Los_Angeles');
        });

        Schema::table('buttons', function (Blueprint $table) {
            $table->string('type', 255)->default('link');
            $table->string('link', 255)->nullable()->change();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('timezone', 255)->nullable();
            $table->string('formatted_address', 255)->nullable();
            $table->string('conference_url', 255)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('map_id');
            $table->dropColumn('timezone');
        });

        Schema::table('buttons', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->dropColumn('timezone');
            $table->dropColumn('formatted_address');
            $table->dropColumn('conference_url');
            $table->dropColumn('notes');
            $table->dropColumn('order');
        });
    }
};
