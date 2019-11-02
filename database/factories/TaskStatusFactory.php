<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Task_Manager\TaskStatus;
use Faker\Generator as Faker;

$factory->define(TaskStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
