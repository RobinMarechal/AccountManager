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
$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    $value = $faker->randomFloat(2, -30, 30);
    $to = NULL;
    $from = NULL;

    if($value < 0)
        $to = $faker->name;
    else
        $from = $faker->name;

    return [
        'date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $faker->dateTimeThisMonth->format('Y-m-d H:i:s')),
        'value' => $value,
        'description' => $faker->sentence(rand(0, 10)),
        'title' => $faker->sentence((rand(0, 3))),
        'to' => $to,
        'from' => $from,
        'credit_card' => (rand(0,10) == 0) ? 0 : 1, 
    ];
});

$factory->define(App\Transfert::class, function (Faker\Generator $faker)
{
    $value = $faker->randomFloat(2, -30, 30);
    $to = NULL;
    $from = NULL;

    if($value < 0)
        $to = $faker->name;
    else
        $from = $faker->name;

    return [
        'value' => $value,
        'from' => $from,
        'to' => $to,
        'day' => rand(1, 28),
        'title' => $faker->sentence(rand(0,3)),
        'description' => $faker->sentence(rand(0,10))
    ];
});

