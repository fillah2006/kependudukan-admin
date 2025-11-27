<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 100) as $index) {

            DB::table('penduduks')->insert([
                'nik'        => $this->generateNik(),
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'birthday'   => $faker->date('Y-m-d', '2005-12-31'),
                'gender'     => $faker->randomElement(['L', 'P']),
                'phone'      => $this->generatePhone(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateNik()
    {
        return str_pad(mt_rand(1000000000000000, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }

    /**
     * Generate nomor telepon max 15 karakter
     */
    private function generatePhone()
    {
        // Format contoh: 081234567890 (12 digit)
        return '08' . rand(1000000000, 9999999999);
    }
}
