<?php

use Illuminate\Database\Seeder;
use servientrega\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([

            'first_name'  => 'Juan',
            'last_name' => 'Ramos',
            'email' => 'juan2ramos@gmail.com',
            'password' => bcrypt('123456'),
            'slug' => 'juan_ramos',
            'api_token' => str_random(60),
        ]);
    }
}
