<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categoria;
use App\Proyecto;
use Faker\Generator as Faker;

$factory->define(Proyecto::class, function (Faker $faker) {
    $total=Categoria::count();
    return [
        'nombre' => $faker->jobTitle,
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'descripcion'=> $faker->text($maxNbChars=50),
        //'foto' => $faker->imageUrl($width=600, $height=430, 'business'),
        'foto' => 'placeholder.png',
        'categoria_id'=> $faker->numberBetween(1,$total)
    ];
});
