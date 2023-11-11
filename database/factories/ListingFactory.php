<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Listing;
use App\Models\State;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Listing::class, function (Faker $faker) {
    $category = Category::inRandomOrder()->first();
    $sub_category = $category->children()->inRandomOrder()->first();
    $sub_category_id = $sub_category ? $sub_category->id : null;
    $user = User::inRandomOrder()->first();
    $state = State::inRandomOrder()->first();
    $area = $state->areas()->inRandomOrder()->first();
    $area_id = $area ? $area->id : null;

    return [
        'type' => rand(1, 5),
        'title' => $faker->sentence(rand(4, 7)),
        'slug' => uniqid(),
        'description' => $faker->paragraphs(rand(3, 5), true),
        'category_id' => $category->id,
        'sub_category_id' => $sub_category_id,
        'user_id' => $user->id,
        'state_id' => $state->id,
        'area_id' => $area_id,
        'address' => $faker->address,
        'price' => ceil(rand(100, 4000) / 100) * 100,
        'currency_id' => 1,
    ];
});
