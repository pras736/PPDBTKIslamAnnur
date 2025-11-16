<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->foreignId('id_kelas')->nullable()->after('id_akun')->constrained('kelas', 'id_kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->dropForeign(['id_kelas']);
            $table->dropColumn('id_kelas');
        });
    }
};
