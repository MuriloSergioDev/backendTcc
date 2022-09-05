<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bloco_id' => 1,
            'titulo' => $this->faker->numberBetween(0, 150),
            'backgroundColor' => $this->faker->hexColor()
        ];
    }
}
