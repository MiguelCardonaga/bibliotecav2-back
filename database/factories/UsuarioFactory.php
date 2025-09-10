<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */

use App\Models\Usuario;


class UsuarioFactory extends Factory
{
     protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombre' => substr($this->faker->name(), 0, 65),
            'email' => substr($this->faker->unique()->safeEmail(), 0, 65),
            'telefono' => substr($this->faker->phoneNumber(), 0, 65),
            'fecha_registro' => now(),
            'estado' => $this->faker->randomElement(['activo','inactivo']),
        ];
    }
}
