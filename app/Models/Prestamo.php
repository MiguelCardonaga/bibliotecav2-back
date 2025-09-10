<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{

    use HasFactory;


   public $timestamps = false;
    protected $table = 'prestamos';

    protected $fillable = [
        'usuario_id','libro_id',
        'fecha_prestamo','fecha_devolucion_estimada','fecha_devolucion_real',
        'estado'
    ];

    protected $casts = [
        'usuario_id'               => 'integer',
        'libro_id'                 => 'integer',
        'fecha_prestamo'           => 'date',
        'fecha_devolucion_estimada'=> 'date',
        'fecha_devolucion_real'    => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
    
}
