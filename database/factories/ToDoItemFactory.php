<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ToDoItem;
use App\ToDoList;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(ToDoItem::class, function (Faker $faker) {
    return [
        'list_id' => function() {
            return factory(ToDoList::class)->create()->id;
        },
        'description' => $faker->words(6, true),
        'completed_at' => null,
        'archived_at' => null,
    ];
});

$factory->state(ToDoItem::class, 'completed', [
    'completed_at' => Carbon::now()->subDay()
]);

$factory->state(ToDoItem::class, 'archived', [
    'archived_at' => Carbon::now()->subDay()
]);
