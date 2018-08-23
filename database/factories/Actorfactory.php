<?php

use Faker\Generator as Faker;

$factory->define(App\Actor::class, function (Faker $faker) {
    return [
        'nombres' =>$faker->text($maxNbChars = 30) ,
        'apellidos' =>$faker->text($maxNbChars = 30) ,
    ];
});

