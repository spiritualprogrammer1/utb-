<?php

use Illuminate\Database\Seeder;
use App\Field;

class FieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = [
            [
                'name' => 'Allume cigare',
                'description' => 'Allume cigare'
            ],
            [
                'name' => 'RK7 / RCD',
                'description' => 'RK7 / RCD'
            ],
            [
                'name' => 'Essuie Glace AV',
                'description' => 'Essuie Glace AV'
            ],
            [
                'name' => 'Essuie Glace AR',
                'description' => 'Essuie Glace AR'
            ],
            [
                'name' => 'Retro ext/int',
                'description' => 'Retro ext/int'
            ],
            [
                'name' => 'Cric / Manivelle',
                'description' => 'Cric / Manivelle'
            ],
            [
                'name' => 'Roue secours',
                'description' => ' Roue secours'
            ],
            [
                'name' => 'Trousse',
                'description' => 'Trousse'
            ],
            [
                'name' => 'Enjoliveurs',
                'description' => 'Enjoliveurs'
            ],
        ];

        foreach ($fields as $key => $field) {
            Field::create($field);
        }
    }
}
