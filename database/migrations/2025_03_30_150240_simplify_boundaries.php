<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('entities', function (Blueprint $table) {
            $table->geometry('boundary_simplified', subtype: 'polygon')->nullable()->after('boundary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('boundary_simplified');
        });

    }
};
