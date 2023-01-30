<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
   
    $price = $faker->randomNumber(2);
   
    return [
        'name' => $faker->name,
        'code' => $faker->unique()->randomNumber(4),
        'price'=>$price,
        'description' => $faker->text
        
       
    ];
});
