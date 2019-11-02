<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Task_Manager\Task;
use Task_Manager\User;
use Task_Manager\TaskStatus;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'status_id' => function () {
            return factory(TaskStatus::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'assigned_to_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
