<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kematians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduks')->onDelete('cascade');
            $table->date('tanggal_kematian');
            $table->string('tempat_kematian');
            $table->enum('penyebab_kematian', [
                'sakit_biasa',
                'kecelakaan',
                'bunuh_diri',
                'pembunuhan',
                'lainnya'
            ]);
            $table->text('keterangan_penyebab')->nullable();
            $table->string('dimakamkan_di');
            $table->date('tanggal_pemakaman');
            $table->enum('status_pencatatan', ['sementara', 'permanen'])->default('sementara');
            $table->text('catatan_tambahan')->nullable();
            $table->string('surat_kematian_no')->nullable();
            $table->date('surat_kematian_tanggal')->nullable();
            $table->foreignId('dilaporkan_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kematians');
    }
};
