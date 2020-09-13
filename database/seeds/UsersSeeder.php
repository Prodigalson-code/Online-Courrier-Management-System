<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'type'=>'admin',
            'password' => bcrypt('admin1234')
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'type'=>'manager',
            'password' => bcrypt('manager1234')
        ]);

        User::create([
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'type'=>'agent',
            'password' => bcrypt('agent1234')
        ]);
    }
}
