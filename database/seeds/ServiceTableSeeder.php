<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Tollerie',
                'description' => 'Allume cigare'
            ],
            [
                'name' => 'Mecanique',
                'description' => 'RK7 / RCD'
            ],
            [
                'name' => 'Electricité',
                'description' => 'Essuie Glace AV'
            ],
            [
                'name' => 'Electronique',
                'description' => 'Essuie Glace AR'
            ],
        ];

        foreach ($services as $key => $service) {
            Service::create($service);
        }
    }
}
