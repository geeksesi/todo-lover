<?php

use Faker\Generator as Faker;
use Geeksesi\TodoLover\Models\Label;
use Illuminate\Support\Str;

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

$factory->define(Label::class, function (Faker $faker) {
    return [
        "title" => Str::random(10),
    ];
});
