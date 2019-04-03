<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'name' => 'sponge bob',
                'phone' => '00000000',
                'service_id' => '1',
                'address' => 'mon adreese'
            ],
            [
                'name' => 'mr crabs',
                'phone' => '00000000',
                'service_id' => '2',
                'address' => 'mon adreese'
            ],
            [
                'name' => 'patrick the star',
                'phone' => '00000000',
                'service_id' => '3',
                'address' => 'mon adreese'
            ],
            [
                'name' => 'pearl scrabes',
                'phone' => '00000000',
                'service_id' => '4',
                'address' => 'mon adreese'
            ],
        ];

        foreach ($employees as $key => $employee) {
            Employee::create($employee);
        }
    }
}
