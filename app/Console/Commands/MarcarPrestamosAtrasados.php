<?php

// app/Console/Commands/MarcarPrestamosAtrasados.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use Carbon\Carbon;

class MarcarPrestamosAtrasados extends Command
{
    protected $signature = 'prestamos:marcar-atrasados';
    protected $description = 'Marca como atrasados los préstamos con más de 15 días sin devolución';

    public function handle(): int
    {
        $hoy = Carbon::today();

        $count = Prestamo::whereIn('estado', ['pendiente','activo'])
            ->whereDate('fecha_devolucion_estimada', '<', $hoy)
            ->update(['estado' => 'atrasado']);

        $this->info("Marcados como atrasados: {$count}");
        return self::SUCCESS;
    }
}

