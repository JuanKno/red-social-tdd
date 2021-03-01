<?php

use App\User;
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
        User::truncate();
        User::create([
            'name' => 'Usuario de prueba',
            'email' => 'prueba@prueba.com',
            'password' => bcrypt('secret')
        ]);
    }
}
