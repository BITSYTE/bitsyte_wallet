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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Device;
use App\Models\User;

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: 'secret',
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Wallet::class, function (Faker\Generator $faker) {

    return [
        'token' => $faker->uuid,
        'name' => $faker->unique()->safeEmail,
        'user_id' => factory(User::class)->lazy(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Device::class, function (Faker\Generator $faker) {

    return [
        'device_id' => $faker->uuid,
        'type' => $faker->word,
        'version' => '8.0',
        'user_id' => factory(User::class)->lazy(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Address::class, function (Faker\Generator $faker) {

    return [
        'private' => $faker->uuid,
        'public' => $faker->uuid,
        'address' => $faker->uuid,
        'wif' => $faker->uuid,
        'user_id' => factory(User::class)->lazy(),
        'wallet_id' => factory(\App\Models\Wallet::class)->lazy(),
    ];
});