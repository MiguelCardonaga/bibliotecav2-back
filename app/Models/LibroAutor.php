<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LibroAutor extends Pivot
{
    protected $table = 'libro_autor';
    public $timestamps = false;      // la pivote no tiene timestamps
    public $incrementing = false;    // PK compuesta (libro_id, autor_id)

    protected $fillable = ['libro_id', 'autor_id', 'orden_autor'];

    protected $casts = [
        'libro_id'    => 'integer',
        'autor_id'    => 'integer',
        'orden_autor' => 'integer',
    ];
}
