<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */

use App\Models\Prestamo;
use App\Models\Usuario;
use App\Models\Libro;


class PrestamoFactory extends Factory
{
    protected $model = Prestamo::class;

    public function definition(): array
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-2 months', 'now');
        $fechaEstimada = (clone $fechaPrestamo)->modify('+15 days');

        $estados = ['pendiente','activo','devuelto','atrasado','cancelado'];
        $estado = $this->faker->randomElement($estados);

        $fechaReal = null;
        if (in_array($estado, ['devuelto','atrasado','cancelado'])) {
            $fechaReal = $this->faker->boolean()
                ? (clone $fechaEstimada)->modify('-'.rand(0,5).' days')
                : (clone $fechaEstimada)->modify('+'.rand(1,10).' days');
        }

        return [
            'usuario_id' => Usuario::inRandomOrder()->value('id') ?? Usuario::factory(),
            'libro_id' => Libro::inRandomOrder()->value('id') ?? Libro::factory(),
            'fecha_prestamo' => $fechaPrestamo,
            'fecha_devolucion_estimada' => $fechaEstimada,
            'fecha_devolucion_real' => $fechaReal,
            'estado' => $estado,
        ];
    }
}
