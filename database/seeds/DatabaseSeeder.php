<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
       /*$this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(FieldTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);*/
    }
}
