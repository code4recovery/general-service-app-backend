<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('stories')->update(['type' => 'news']);
        Schema::dropIfExists('login_tokens');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
