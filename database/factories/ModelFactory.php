<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(servientrega\User::class, function (Faker\Generator $faker) {
    static $password;
    $first_name = $faker->name;
    $last_name = $faker->lastName;
    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'slug' => str_slug($first_name . $last_name )
    ];
});
