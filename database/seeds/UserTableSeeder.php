<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Role::where('name', 'super-admin')->first();
        //$role_com = Role::where('name', 'commercial')->first();

        $admin = new User();
        $admin->first_name = 'maze runner';
        $admin->last_name = 'saikick';
        $admin->username = 'saikick maze runner';
        $admin->email = 'dev@segoor.com';
        //$admin->image = 'profileimg.png';
        $admin->password = bcrypt('segoor');
        $admin->save();
        $admin->roles()->attach($super_admin);

        /*$com = new User();
        $com->first_name = 'stick brown';
        $com->last_name = 'doe';
        $com->username = 'doe stick brown';
        $com->email = 'com@cocorepublik.com';
        $com->image = 'profileimg.png';
        $com->password = bcrypt('republik');
        $com->save();
        $com->roles()->attach($role_com);*/
    }
}
