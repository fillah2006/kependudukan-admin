<?php

namespace Database\Seeders;

use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class KematianSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Nonaktifkan foreign key constraints untuk menghindari error
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Hapus data kematian lama jika ada
        Kematian::truncate();

        // Ambil semua penduduk yang masih hidup
        $penduduks = Penduduk::hidup()->get();

        // Jika tidak ada penduduk, buat dummy penduduk dulu
        if ($penduduks->isEmpty()) {
            $this->createDummyPenduduk();
            $penduduks = Penduduk::hidup()->get();
        }

        // Batasi jumlah penduduk yang akan dijadikan data kematian (maks 100)
        $penduduks = $penduduks->take(100);

        // Daftar tempat kematian di Indonesia
        $tempatKematian = [
            'RSUD Dr. Soetomo Surabaya',
            'RSUP Dr. Sardjito Yogyakarta',
            'RSUP Dr. Hasan Sadikin Bandung',
            'RSUP Dr. Kariadi Semarang',
            'RSUP Dr. Wahidin Sudirohusodo Makassar',
            'RSUP Dr. M. Djamil Padang',
            'RS Harapan Kita Jakarta',
            'RS Dr. Cipto Mangunkusumo Jakarta',
            'RS Pusat Otak Nasional Jakarta',
            'RS Umum Daerah Kota Depok',
            'RS Umum Daerah Tangerang',
            'RS Umum Daerah Bekasi',
            'RS Umum Daerah Bogor',
            'RS Umum Daerah Bandung',
            'RS Umum Daerah Surabaya',
            'RS Umum Daerah Semarang',
            'RS Umum Daerah Yogyakarta',
            'RS Umum Daerah Malang',
            'RS Umum Daerah Denpasar',
            'RS Umum Daerah Medan',
            'RS Umum Daerah Palembang',
            'RS Umum Daerah Makassar',
            'RS Umum Daerah Banjarmasin',
            'RS Umum Daerah Samarinda',
            'RS Umum Daerah Manado',
            'Rumah Pribadi',
            'Jalan Raya',
            'Tempat Kerja',
            'Puskesmas',
            'Klinik Pratama',
        ];

        // Daftar tempat pemakaman di Indonesia
        $tempatPemakaman = [
            'TPU Umum Tanah Kusir Jakarta',
            'TPU Umum Karet Bivak Jakarta',
            'TPU Umum Jeruk Purut Jakarta',
            'TPU Umum Menteng Pulo Jakarta',
            'TPU Umum Pondok Rangon Jakarta',
            'TPU Umum Giritama Bandung',
            'TPU Umum Pandu Bandung',
            'TPU Umum Cikutra Bandung',
            'TPU Umum Ngemplak Surabaya',
            'TPU Umum Keputih Surabaya',
            'TPU Umum Tambak Osowilangon Surabaya',
            'TPU Umum Sidosermo Surabaya',
            'TPU Umum Manguharjo Madiun',
            'TPU Umum Tegalrejo Yogyakarta',
            'TPU Umum Karang Anyar Yogyakarta',
            'TPU Umum Tlogosari Semarang',
            'TPU Umum Manyaran Semarang',
            'TPU Umum Kerkhof Medan',
            'TPU Umum Sirandorung Medan',
            'TPU Umum Angsoka Denpasar',
            'TPU Umum Ubung Kaja Denpasar',
            'TPU Umum Suwung Denpasar',
            'TPU Umum Sudiang Makassar',
            'TPU Umum Tamalate Makassar',
            'Makam Keluarga',
            'Makam Pribadi',
            'TPU Desa',
            'TPU Kecamatan',
        ];

        // Penyebab kematian
        $penyebabKematian = ['sakit_biasa', 'kecelakaan', 'bunuh_diri', 'pembunuhan', 'lainnya'];
        $penyebabLabels = [
            'sakit_biasa' => [
                'Penyakit Jantung Koroner',
                'Stroke',
                'Diabetes Melitus',
                'Hipertensi',
                'Pneumonia',
                'Tuberkulosis',
                'Gagal Ginjal',
                'Kanker Paru-paru',
                'Kanker Payudara',
                'Sirosis Hati',
                'Sepsis',
                'COVID-19',
                'Demam Berdarah Dengue',
                'Malaria',
                'Tifus',
            ],
            'kecelakaan' => [
                'Kecelakaan Lalu Lintas',
                'Kecelakaan Kerja',
                'Tenggelam',
                'Jatuh dari Ketinggian',
                'Kecelakaan Transportasi Umum',
                'Kecelakaan Sepeda Motor',
                'Kecelakaan Mobil',
            ],
            'bunuh_diri' => [
                'Overdosis Obat',
                'Gantung Diri',
                'Racun',
                'Lompat dari Ketinggian',
            ],
            'pembunuhan' => [
                'Penusukan',
                'Penembakan',
                'Pengeroyokan',
                'Pembacokan',
            ],
            'lainnya' => [
                'Usia Tua',
                'Gagal Organ Multipel',
                'Penyakit Tidak Diketahui',
                'Bencana Alam',
            ]
        ];

        $dataKematian = [];

        foreach ($penduduks as $index => $penduduk) {
            // Tentukan tanggal kematian (dalam 2 tahun terakhir)
            $tanggalKematian = Carbon::now()->subDays(rand(1, 730));

            // Tentukan penyebab kematian
            $penyebab = $penyebabKematian[array_rand($penyebabKematian)];
            $keteranganPenyebab = $penyebabLabels[$penyebab][array_rand($penyebabLabels[$penyebab])];

            // Hitung usia saat meninggal
            $usiaSaatMeninggal = $penduduk->birthday->diffInYears($tanggalKematian);

            // Tentukan status pencatatan (90% permanen, 10% sementara)
            $statusPencatatan = rand(1, 10) <= 9 ? 'permanen' : 'sementara';

            // Generate nomor surat kematian (70% punya surat)
            $punyaSurat = rand(1, 10) <= 7;
            $suratKematianNo = $punyaSurat ? 'SK-' . date('Y') . '-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT) : null;
            $suratKematianTanggal = $punyaSurat ? $tanggalKematian->copy()->addDays(rand(1, 7)) : null;

            // Tentukan tanggal pemakaman (1-7 hari setelah kematian)
            $tanggalPemakaman = $tanggalKematian->copy()->addDays(rand(1, 7));

            $dataKematian[] = [
                'penduduk_id' => $penduduk->id,
                'tanggal_kematian' => $tanggalKematian->format('Y-m-d'),
                'tempat_kematian' => $tempatKematian[array_rand($tempatKematian)],
                'penyebab_kematian' => $penyebab,
                'keterangan_penyebab' => $keteranganPenyebab,
                'dimakamkan_di' => $tempatPemakaman[array_rand($tempatPemakaman)],
                'tanggal_pemakaman' => $tanggalPemakaman->format('Y-m-d'),
                'status_pencatatan' => $statusPencatatan,
                'catatan_tambahan' => rand(1, 3) === 1 ? $faker->sentence(10) : null,
                'surat_kematian_no' => $suratKematianNo,
                'surat_kematian_tanggal' => $suratKematianTanggal ? $suratKematianTanggal->format('Y-m-d') : null,
                'dilaporkan_oleh' => 1, // User ID 1 (admin)
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Update untuk progress bar
            if (($index + 1) % 10 === 0) {
                echo "Memproses data kematian ke-" . ($index + 1) . "\n";
            }
        }

        // Insert data ke database dengan chunk untuk menghindari memory limit
        $chunks = array_chunk($dataKematian, 25);
        foreach ($chunks as $chunk) {
            Kematian::insert($chunk);
        }

        echo "Berhasil membuat " . count($dataKematian) . " data kematian dummy!\n";

        // Aktifkan kembali foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function createDummyPenduduk(): void
    {
        $faker = Faker::create('id_ID');

        echo "Membuat dummy penduduk terlebih dahulu...\n";

        $penduduks = [];

        // Daftar nama Indonesia lengkap
        $namaIndo = [
            // Laki-laki
            ['first_name' => 'Ahmad', 'last_name' => 'Hidayat', 'gender' => 'L'],
            ['first_name' => 'Budi', 'last_name' => 'Santoso', 'gender' => 'L'],
            ['first_name' => 'Cahyo', 'last_name' => 'Prabowo', 'gender' => 'L'],
            ['first_name' => 'Dedi', 'last_name' => 'Wijaya', 'gender' => 'L'],
            ['first_name' => 'Eko', 'last_name' => 'Prasetyo', 'gender' => 'L'],
            ['first_name' => 'Fajar', 'last_name' => 'Nugroho', 'gender' => 'L'],
            ['first_name' => 'Gunawan', 'last_name' => 'Setiawan', 'gender' => 'L'],
            ['first_name' => 'Hendra', 'last_name' => 'Kurniawan', 'gender' => 'L'],
            ['first_name' => 'Iwan', 'last_name' => 'Saputra', 'gender' => 'L'],
            ['first_name' => 'Joko', 'last_name' => 'Wibowo', 'gender' => 'L'],
            ['first_name' => 'Kurniawan', 'last_name' => 'Hartono', 'gender' => 'L'],
            ['first_name' => 'Lukman', 'last_name' => 'Hakim', 'gender' => 'L'],
            ['first_name' => 'Mulyadi', 'last_name' => 'Siregar', 'gender' => 'L'],
            ['first_name' => 'Nugroho', 'last_name' => 'Sihombing', 'gender' => 'L'],
            ['first_name' => 'Oki', 'last_name' => 'Maulana', 'gender' => 'L'],
            ['first_name' => 'Purnomo', 'last_name' => 'Simanjuntak', 'gender' => 'L'],
            ['first_name' => 'Rudi', 'last_name' => 'Hutagalung', 'gender' => 'L'],
            ['first_name' => 'Slamet', 'last_name' => 'Sihotang', 'gender' => 'L'],
            ['first_name' => 'Tono', 'last_name' => 'Panggabean', 'gender' => 'L'],
            ['first_name' => 'Umar', 'last_name' => 'Sembiring', 'gender' => 'L'],
            ['first_name' => 'Wahyudi', 'last_name' => 'Situmorang', 'gender' => 'L'],
            ['first_name' => 'Yanto', 'last_name' => 'Manurung', 'gender' => 'L'],
            ['first_name' => 'Zainal', 'last_name' => 'Napitupulu', 'gender' => 'L'],
            ['first_name' => 'Ade', 'last_name' => 'Sinaga', 'gender' => 'L'],
            ['first_name' => 'Bambang', 'last_name' => 'Sirait', 'gender' => 'L'],

            // Perempuan
            ['first_name' => 'Ani', 'last_name' => 'Wulandari', 'gender' => 'P'],
            ['first_name' => 'Bunga', 'last_name' => 'Putri', 'gender' => 'P'],
            ['first_name' => 'Cindy', 'last_name' => 'Anggraini', 'gender' => 'P'],
            ['first_name' => 'Dewi', 'last_name' => 'Kartika', 'gender' => 'P'],
            ['first_name' => 'Eka', 'last_name' => 'Permatasari', 'gender' => 'P'],
            ['first_name' => 'Fitri', 'last_name' => 'Nurhayati', 'gender' => 'P'],
            ['first_name' => 'Gita', 'last_name' => 'Maharani', 'gender' => 'P'],
            ['first_name' => 'Hana', 'last_name' => 'Puspita', 'gender' => 'P'],
            ['first_name' => 'Indah', 'last_name' => 'Sari', 'gender' => 'P'],
            ['first_name' => 'Juli', 'last_name' => 'Astuti', 'gender' => 'P'],
            ['first_name' => 'Kartika', 'last_name' => 'Wardani', 'gender' => 'P'],
            ['first_name' => 'Lina', 'last_name' => 'Hasanah', 'gender' => 'P'],
            ['first_name' => 'Maya', 'last_name' => 'Rahayu', 'gender' => 'P'],
            ['first_name' => 'Nina', 'last_name' => 'Susanti', 'gender' => 'P'],
            ['first_name' => 'Ovi', 'last_name' => 'Handayani', 'gender' => 'P'],
            ['first_name' => 'Putri', 'last_name' => 'Utami', 'gender' => 'P'],
            ['first_name' => 'Rani', 'last_name' => 'Wijayanti', 'gender' => 'P'],
            ['first_name' => 'Sari', 'last_name' => 'Damayanti', 'gender' => 'P'],
            ['first_name' => 'Tika', 'last_name' => 'Pratiwi', 'gender' => 'P'],
            ['first_name' => 'Umi', 'last_name' => 'Kusuma', 'gender' => 'P'],
            ['first_name' => 'Widi', 'last_name' => 'Ardianti', 'gender' => 'P'],
            ['first_name' => 'Yuni', 'last_name' => 'Kurniasih', 'gender' => 'P'],
            ['first_name' => 'Zahra', 'last_name' => 'Firdaus', 'gender' => 'P'],
            ['first_name' => 'Amelia', 'last_name' => 'Nurjanah', 'gender' => 'P'],
            ['first_name' => 'Bella', 'last_name' => 'Rahmawati', 'gender' => 'P'],
        ];

        for ($i = 0; $i < 100; $i++) {
            $nama = $namaIndo[$i % count($namaIndo)];
            $tanggalLahir = Carbon::now()->subYears(rand(20, 80))->subDays(rand(1, 365));

            $penduduks[] = [
                'nik' => $faker->unique()->numerify('320101##########'),
                'first_name' => $nama['first_name'],
                'last_name' => $nama['last_name'],
                'birthday' => $tanggalLahir->format('Y-m-d'),
                'gender' => $nama['gender'],
                'phone' => rand(0, 1) ? $faker->numerify('08##########') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $chunks = array_chunk($penduduks, 25);
        foreach ($chunks as $chunk) {
            Penduduk::insert($chunk);
        }

        echo "Berhasil membuat 100 dummy penduduk!\n";
    }
}
