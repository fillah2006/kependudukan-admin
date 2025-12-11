<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kematian extends Model
{
    // HAPUS: use SoftDeletes; // ← Hapus ini karena data kematian sebaiknya permanen

    protected $table = 'kematians';

    protected $fillable = [
        'penduduk_id',
        'tanggal_kematian',
        'tempat_kematian',
        'penyebab_kematian',
        'keterangan_penyebab',
        'dimakamkan_di',
        'tanggal_pemakaman',
        'status_pencatatan',
        'catatan_tambahan',
        'surat_kematian_no',
        'surat_kematian_tanggal',
        'dilaporkan_oleh',
    ];

    protected $casts = [
        'tanggal_kematian' => 'date',
        'tanggal_pemakaman' => 'date',
        'surat_kematian_tanggal' => 'date',
    ];

    protected $appends = ['penyebab_kematian_label'];

    // Relasi ke Penduduk
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    // Relasi ke User yang melaporkan
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh');
    }

    // Accessor untuk label penyebab kematian
    public function getPenyebabKematianLabelAttribute(): string
    {
        $labels = [
            'sakit_biasa' => 'Sakit Biasa',
            'kecelakaan' => 'Kecelakaan',
            'bunuh_diri' => 'Bunuh Diri',
            'pembunuhan' => 'Pembunuhan',
            'lainnya' => 'Lainnya',
        ];

        return $labels[$this->penyebab_kematian] ?? 'Tidak Diketahui';
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->whereHas('penduduk', function($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
              ->orWhere('last_name', 'LIKE', "%$search%")
              ->orWhere('nik', 'LIKE', "%$search%");
        })->orWhere('tempat_kematian', 'LIKE', "%$search%")
          ->orWhere('dimakamkan_di', 'LIKE', "%$search%")
          ->orWhere('surat_kematian_no', 'LIKE', "%$search%");
    }

    // Scope untuk filter bulan
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_kematian', date('m'))
                    ->whereYear('tanggal_kematian', date('Y'));
    }

    // Cek apakah penduduk sudah tercatat meninggal
    public static function isPendudukMeninggal($pendudukId): bool
    {
        return self::where('penduduk_id', $pendudukId)->exists();
    }
}
