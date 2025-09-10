<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\LibroAutor;

class Libro extends Model
{

    use HasFactory, SoftDeletes;


     public $timestamps = false;
    protected $table = 'libros';
    

    protected $fillable = [
        'titulo','isbn','anio_publicacion','numero_paginas','descripcion','stock_disponible'
    ];

    protected $casts = [
        'anio_publicacion'  => 'integer',
        'numero_paginas'    => 'integer',
        'stock_disponible'  => 'integer',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'libro_autor', 'libro_id', 'autor_id')
            ->using(LibroAutor::class)
            ->withPivot('orden_autor')
            ->orderBy('libro_autor.orden_autor');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'libro_id');
    }

    protected function titulo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, "UTF-8")
        );
    }


    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->where('stock_disponible', '>', 0);
    }

    public function scopePublicadoEn(Builder $query, int $anio): Builder
    {
        return $query->where('anio_publicacion', $anio);
    }

   
    public function scopeDeAutor(Builder $query, $autor): Builder
    {
        return $query->whereHas('autores', function (Builder $q) use ($autor) {
            if (is_numeric($autor)) {
                $q->where('autores.id', (int) $autor);
            } else {
                $texto = trim($autor);
                $q->where(function ($w) use ($texto) {
                    $w->where('autores.nombre', 'ILIKE', "%{$texto}%")
                      ->orWhere('autores.apellido', 'ILIKE', "%{$texto}%");
                });
            }
        });
    }
}
