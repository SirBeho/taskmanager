<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id'=>User::inRandomOrder()->first()->id,
            'nombre'=>fake()->city(),
            'descripcion'=>fake()->text($maxNbChars = 100),
            'estado'=>fake()->randomElement(['1', '2'])
        ];
    }
}
