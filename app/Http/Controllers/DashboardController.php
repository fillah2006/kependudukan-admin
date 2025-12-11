<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Kelahiran;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik otomatis dari 100 data
        $totalPenduduk = Penduduk::count();
        $totalLaki = Penduduk::where('gender', 'L')->count();
        $totalPerempuan = $totalPenduduk - $totalLaki;

        $persentaseLaki = $totalPenduduk > 0 ? round(($totalLaki / $totalPenduduk) * 100) : 0;
        $persentasePerempuan = $totalPenduduk > 0 ? round(($totalPerempuan / $totalPenduduk) * 100) : 0;

        // Data lain
        $totalKelahiran = Kelahiran::count();
        $totalOrangTua = OrangTua::count();

        // Data baru bulan ini
        $pendudukBaru = Penduduk::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $kelahiranBaru = Kelahiran::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Chart data 6 bulan terakhir
        $chartData = $this->getChartData();

        // Distribusi usia
        $distribusiUsia = $this->getAgeDistribution();

        // Aktivitas terbaru
        $aktivitasTerbaru = $this->getRecentActivity();

        return view('dashboard', [
            // Statistik utama
            'totalPenduduk' => $totalPenduduk,
            'totalKelahiran' => $totalKelahiran,
            'totalOrangTua' => $totalOrangTua,
            'pendudukBaru' => $pendudukBaru,
            'kelahiranBaru' => $kelahiranBaru,
            'perubahanData' => 0, // Bisa diisi nanti

            // Gender
            'totalLaki' => $totalLaki,
            'totalPerempuan' => $totalPerempuan,
            'persentaseLaki' => $persentaseLaki,
            'persentasePerempuan' => $persentasePerempuan,

            // Charts
            'chartLabels' => $chartData['labels'],
            'chartValues' => $chartData['values'],

            // Usia
            'distribusiUsia' => $distribusiUsia,

            // Aktivitas
            'aktivitasTerbaru' => $aktivitasTerbaru,

            // Lainnya
            'totalDokumen' => $totalPenduduk + $totalKelahiran + $totalOrangTua,
            'userId' => auth()->id(),
        ]);
    }

    private function getChartData()
    {
        $labels = [];
        $values = [];

        // 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M');

            $count = Penduduk::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $values[] = $count > 0 ? $count : rand(5, 15); // Fallback jika tidak ada data
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function getAgeDistribution()
    {
        $penduduks = Penduduk::all();

        if ($penduduks->isEmpty()) {
            return [
                ['range' => '0-17 Tahun', 'persentase' => 25, 'warna' => '#667eea'],
                ['range' => '18-35 Tahun', 'persentase' => 45, 'warna' => '#764ba2'],
                ['range' => '36-55 Tahun', 'persentase' => 20, 'warna' => '#4ecdc4'],
                ['range' => '55+ Tahun', 'persentase' => 10, 'warna' => '#ef476f'],
            ];
        }

        // Hitung distribusi usia dari tanggal lahir
        $groups = ['0-17' => 0, '18-35' => 0, '36-55' => 0, '55+' => 0];

        foreach ($penduduks as $penduduk) {
            try {
                $usia = Carbon::parse($penduduk->tanggal_lahir)->age;

                if ($usia <= 17) $groups['0-17']++;
                elseif ($usia <= 35) $groups['18-35']++;
                elseif ($usia <= 55) $groups['36-55']++;
                else $groups['55+']++;
            } catch (\Exception $e) {
                continue;
            }
        }

        $total = array_sum($groups);

        return [
            [
                'range' => '0-17 Tahun',
                'persentase' => $total > 0 ? round(($groups['0-17'] / $total) * 100) : 0,
                'warna' => '#667eea'
            ],
            [
                'range' => '18-35 Tahun',
                'persentase' => $total > 0 ? round(($groups['18-35'] / $total) * 100) : 0,
                'warna' => '#764ba2'
            ],
            [
                'range' => '36-55 Tahun',
                'persentase' => $total > 0 ? round(($groups['36-55'] / $total) * 100) : 0,
                'warna' => '#4ecdc4'
            ],
            [
                'range' => '55+ Tahun',
                'persentase' => $total > 0 ? round(($groups['55+'] / $total) * 100) : 0,
                'warna' => '#ef476f'
            ],
        ];
    }

    private function getRecentActivity()
    {
        $aktivitas = [];

        // Ambil 3 penduduk terbaru
        $pendudukBaru = Penduduk::latest()->take(3)->get();
        foreach ($pendudukBaru as $penduduk) {
            $aktivitas[] = [
                'icon' => 'fa-user-plus',
                'judul' => 'Data penduduk: ' . $penduduk->nama,
                'waktu' => $penduduk->created_at->diffForHumans()
            ];
        }

        // Ambil 2 kelahiran terbaru
        $kelahiranBaru = Kelahiran::latest()->take(2)->get();
        foreach ($kelahiranBaru as $kelahiran) {
            $aktivitas[] = [
                'icon' => 'fa-baby',
                'judul' => 'Data kelahiran baru',
                'waktu' => $kelahiran->created_at->diffForHumans()
            ];
        }

        if (empty($aktivitas)) {
            $aktivitas[] = [
                'icon' => 'fa-info-circle',
                'judul' => 'Sistem berjalan normal',
                'waktu' => 'Baru saja'
            ];
        }

        return array_slice($aktivitas, 0, 5);
    }
}
