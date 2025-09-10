<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */

use App\Models\Libro;


class LibroFactory extends Factory
{
   protected $model = Libro::class;

    public function definition(): array
    {
        return [
            'titulo' => substr($this->faker->sentence(3), 0, 65),
            'isbn' => $this->faker->isbn13(),
            'anio_publicacion' => $this->faker->numberBetween(1950, now()->year),
            'numero_paginas' => $this->faker->numberBetween(100, 900),
            'descripcion' => $this->faker->paragraph(),
            'stock_disponible' => $this->faker->numberBetween(0, 20),
        ];
    }
}
