<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\OrangTua;

class KelahiranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // 🇮🇩 Nama Indonesia

        // Ambil seluruh orang tua
        $ayahList = OrangTua::where('jenis_kelamin', 'L')->get();
        $ibuList  = OrangTua::where('jenis_kelamin', 'P')->get();

        // Jika salah satu kosong → buat minimal dummy agar Seeder tidak error
        if ($ayahList->isEmpty()) {
            $ayahList = collect([OrangTua::factory()->create(['jenis_kelamin' => 'L'])]);
        }
        if ($ibuList->isEmpty()) {
            $ibuList = collect([OrangTua::factory()->create(['jenis_kelamin' => 'P'])]);
        }

        foreach (range(1, 100) as $index) {

            // Ambil ayah & ibu acak
            $ayah = $ayahList->random();
            $ibu  = $ibuList->random();

            // Tentukan jenis kelamin bayi
            $jenisKelamin = $faker->randomElement(['L', 'P']);

            // Nama bayi Indonesia (firstName berdasarkan gender)
            $namaBayi = $jenisKelamin === 'L'
                        ? $faker->firstNameMale()
                        : $faker->firstNameFemale();

            // Insert ke tabel kelahiran
            DB::table('kelahiran')->insert([
                'nama_bayi'     => $namaBayi,
                'tanggal_lahir' => $faker->date('Y-m-d', 'now'),
                'jenis_kelamin' => $jenisKelamin,
                'nama_ayah'     => $ayah->nama,
                'nama_ibu'      => $ibu->nama,
                'tempat_lahir'  => $faker->city,
                'berat_badan'   => $faker->randomFloat(2, 2.5, 4.5),
                'panjang_badan' => $faker->randomFloat(2, 45, 55),
                'alamat'        => $ayah->alamat, // alamat ikut orang tua
                'no_akte'       => $faker->unique()->numerify('AKTE-########'),
                'orangtua_id'   => $ayah->id, // relasi ke ayah (atau bisa ibu)
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
