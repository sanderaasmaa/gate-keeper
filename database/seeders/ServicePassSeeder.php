<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_passes')->insert([
            [
                'name' => 'Gym 10x',
                'service_id' => 1,
                'repetitions' => 10,
                'expiry_days' => 99999,
            ],
            [
                'name' => 'Gym 1x',
                'service_id' => 1,
                'repetitions' => 1,
                'expiry_days' => 99999,
            ],
            [
                'name' => 'Gym 10 days',
                'service_id' => 1,
                'repetitions' => 99999,
                'expiry_days' => 10,
            ],
            [
                'name' => 'Gym 365 days',
                'service_id' => 1,
                'repetitions' => 99999,
                'expiry_days' => 365,
            ]
        ]);
    }
}
