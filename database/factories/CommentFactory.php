<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model\Comment;
use App\Model\Status;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(),
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'status_id' => function () {
            return factory(Status::class)->create();
        },
    ];
});
