<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class)->create(['email' => 'joe@example.com', 'password' => 'password']);
        $user->assignRole(\App\Role::superadmin());
    }
}
