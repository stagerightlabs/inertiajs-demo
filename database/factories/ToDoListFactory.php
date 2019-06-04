<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\ToDoList;
use Faker\Generator as Faker;

$factory->define(ToDoList::class, function (Faker $faker) {
    return [
        'name' => $faker->words(6, true),
        'user_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
