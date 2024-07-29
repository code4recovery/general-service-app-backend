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
            $table->string('district', 255)->nullable()->change();
            $table->string('name', 255)->nullable()->change();
        });

        $entities = DB::table('entities')->whereNotNull('district')->get();
        foreach ($entities as $entity) {
            $entity->district = str_pad($entity->district, 2, '0', STR_PAD_LEFT);
            DB::table('entities')->where('id', $entity->id)->update([
                'district' => $entity->district,
            ]);
        }

        Schema::table('stories', function (Blueprint $table) {
            $table->longText('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->unsignedInteger('district', 5)->nullable()->change();
            $table->string('name', 255)->change();
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
};
