<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(), //Str::random(10),
            'price' => $this->faker->numberBetween(10, 100),
            'count' => $this->faker->numberBetween(1, 7),
        ];
    }
}
