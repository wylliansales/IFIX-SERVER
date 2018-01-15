<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'activated' => random_int(0,1),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Sector::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\Models\Category::class, function (Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\Models\Status::class, function (Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\Models\Attendant::class, function (Faker $faker){
    return [
        'user_id' => random_int(1,100),
        'coordinator' => random_int(0,1)
    ];
});

$factory->define(App\Models\Administrator::class, function (Faker $faker){
    return [
        'user_id' => random_int(1,100),
    ];
});

$factory->define(App\Models\Equipment::class, function (Faker $faker){
    return [
        'sector_id' => random_int(1,1000),
        'category_id' => random_int(1,100),
        'code' => random_int(100000000,999999999),
        'description' => $faker->sentence
    ];
});

$factory->define(App\Models\Department::class, function (Faker $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\Models\Request::class, function (Faker $faker){
    return [
        'department_id' => random_int(1, 10),
        'user_id' => random_int(1, 100),
        'subject_matter' => str_random(10),
        'description' => $faker->sentence(),
    ];
});

