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
        Schema::create('murids', function (Blueprint $table) {
            $table->id('id_murid');
            $table->foreignId('id_akun')->constrained('akuns', 'id_akun')->onDelete('cascade');
            $table->enum('status_siswa', ['pendaftar', 'terdaftar'])->default('pendaftar');
            
            // Data Identitas Anak
            $table->string('no_induk_sekolah', 50)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('nik_anak', 20)->nullable();
            $table->string('no_akte', 30)->nullable();
            $table->string('nama_lengkap', 150);
            $table->string('nama_panggilan', 50)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 50)->nullable();
            $table->string('kewarganegaraan', 50)->nullable();
            $table->string('hobi', 100)->nullable();
            $table->string('cita_cita', 100)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->float('lingkar_kepala')->nullable();
            $table->string('imunisasi', 255)->nullable();
            
            // Data Alamat
            $table->string('alamat_jalan', 255)->nullable();
            $table->string('alamat_kelurahan', 100)->nullable();
            $table->string('alamat_kecamatan', 100)->nullable();
            $table->string('alamat_kota', 100)->nullable();
            $table->string('alamat_provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('jarak_sekolah', 50)->nullable();
            
            // Kontak
            $table->string('telp_ayah', 20)->nullable();
            $table->string('telp_ibu', 20)->nullable();
            
            // Data Ayah
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nik_ayah', 20)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            
            // Data Ibu
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nik_ibu', 20)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murids');
    }
};
