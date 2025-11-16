<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum role dari 'murid' menjadi 'wali'
        DB::statement("ALTER TABLE akuns MODIFY COLUMN role ENUM('admin', 'guru', 'wali') DEFAULT 'wali'");
        
        // Update data yang sudah ada: role 'murid' menjadi 'wali'
        DB::table('akuns')->where('role', 'murid')->update(['role' => 'wali']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update kembali ke 'murid'
        DB::table('akuns')->where('role', 'wali')->update(['role' => 'murid']);
        DB::statement("ALTER TABLE akuns MODIFY COLUMN role ENUM('admin', 'guru', 'murid') DEFAULT 'murid'");
    }
};
