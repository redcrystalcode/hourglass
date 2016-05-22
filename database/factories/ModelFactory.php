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
/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factory;

$factory->define(\Hourglass\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(\Hourglass\Models\Job::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(3),
        'number' => $faker->bothify('######?'),
        'description' => $faker->paragraph(3),
        'customer' => $faker->company,
        'location_id' => 1,
    ];
});


