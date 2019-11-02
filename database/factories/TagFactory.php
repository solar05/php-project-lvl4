<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Task_Manager\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
