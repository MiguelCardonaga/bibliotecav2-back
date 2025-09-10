<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autor>
 */
use App\Models\Autor;


class AutorFactory extends Factory
{
   protected $model = Autor::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date(),
            'nacionalidad' => $this->faker->country(),
            'biografia' => $this->faker->paragraph(),
        ];
    }
}
