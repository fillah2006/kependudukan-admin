<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penduduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nik',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'phone',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke data kematian (jika ada)
     */
    public function kematian(): HasOne
    {
        return $this->hasOne(Kematian::class);
    }

    /**
     * Accessor untuk nama lengkap
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Accessor untuk usia
     */
    public function getUsiaAttribute(): int
    {
        return $this->birthday->age;
    }

    /**
     * Accessor untuk jenis kelamin lengkap
     */
    public function getGenderLabelAttribute(): string
    {
        return $this->gender == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Accessor untuk status hidup/mati
     */
    public function getStatusHidupAttribute(): string
    {
        return $this->kematian ? 'Meninggal' : 'Hidup';
    }

    /**
     * Accessor untuk badge warna status
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->kematian
            ? '<span class="badge bg-danger">Meninggal</span>'
            : '<span class="badge bg-success">Hidup</span>';
    }

    /**
     * Scope untuk penduduk yang masih hidup
     */
    public function scopeHidup($query)
    {
        return $query->whereDoesntHave('kematian');
    }

    /**
     * Scope untuk penduduk yang sudah meninggal
     */
    public function scopeMeninggal($query)
    {
        return $query->whereHas('kematian');
    }

    /**
     * Scope untuk search nama atau NIK
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
              ->orWhere('last_name', 'LIKE', "%$search%")
              ->orWhere('nik', 'LIKE', "%$search%");
        });
    }

    /**
     * Scope untuk filter gender
     */
    public function scopeFilterGender($query, $gender)
    {
        if ($gender) {
            return $query->where('gender', $gender);
        }
        return $query;
    }

    /**
     * Cek apakah penduduk masih hidup
     */
    public function isHidup(): bool
    {
        return !$this->kematian;
    }

    /**
     * Cek apakah penduduk sudah meninggal
     */
    public function isMeninggal(): bool
    {
        return !$this->isHidup();
    }

    /**
     * Format phone number
     */
    public function getPhoneFormattedAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        // Format: +62 812-3456-7890
        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (strlen($phone) > 10) {
            return '+62 ' . substr($phone, 1, 3) . '-' . substr($phone, 4, 4) . '-' . substr($phone, 8);
        }

        return $this->phone;
    }

    /**
     * Get data for dropdown/select options (hanya yang hidup)
     */
    public static function getHidupForDropdown()
    {
        return self::hidup()
            ->orderBy('first_name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => "{$item->nama_lengkap} (NIK: {$item->nik})"];
            });
    }

    /**
     * Get statistics data
     */
    public static function getStatistics(): array
    {
        $total = self::count();
        $male = self::where('gender', 'L')->count();
        $female = self::where('gender', 'P')->count();
        $hidup = self::hidup()->count();
        $meninggal = self::meninggal()->count();

        return [
            'total' => $total,
            'male' => $male,
            'female' => $female,
            'hidup' => $hidup,
            'meninggal' => $meninggal,
            'percentage_male' => $total > 0 ? round(($male / $total) * 100, 2) : 0,
            'percentage_female' => $total > 0 ? round(($female / $total) * 100, 2) : 0,
            'percentage_hidup' => $total > 0 ? round(($hidup / $total) * 100, 2) : 0,
            'percentage_meninggal' => $total > 0 ? round(($meninggal / $total) * 100, 2) : 0,
        ];
    }
}
