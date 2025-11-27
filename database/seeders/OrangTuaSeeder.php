<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrangTuaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 100) as $index) {

            DB::table('orang_tua')->insert([
                'nama'          => $faker->name,
                'nik'           => $this->generateNik(),
                'tempat_lahir'  => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '1990-12-31'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat'        => $faker->address,
                'agama'         => $faker->randomElement([
                                        'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'
                                   ]),
                'pekerjaan'     => $faker->randomElement([
                                        'Petani', 'Guru', 'Karyawan', 'Wiraswasta', 'Nelayan', 'PNS'
                                   ]),
                'pendidikan'    => $faker->randomElement([
                                        'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'
                                   ]),
                'no_telepon'    => $this->generatePhone(),
                'status'        => $faker->randomElement(['hidup', 'meninggal']),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    private function generateNik()
    {
        // pastikan 16 digit unik
        return str_pad(mt_rand(1000000000000000, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }

    private function generatePhone()
    {
        // aman, max 13 digit
        return '08' . rand(1000000000, 9999999999);
    }
}
