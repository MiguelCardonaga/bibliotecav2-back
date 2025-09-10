<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\LibroAutor;


class Autor extends Model
{

    use HasFactory;


   public $timestamps = false;
    protected $table = 'autores';

    protected $fillable = [
        'nombre','apellido','fecha_nacimiento','nacionalidad','biografia'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'libro_autor', 'autor_id', 'libro_id')
            ->using(LibroAutor::class)
            ->withPivot('orden_autor')
            ->orderBy('libro_autor.orden_autor');
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () => "{$this->nombre} {$this->apellido}");
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, "UTF-8")
        );
    }

    protected function apellido(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, "UTF-8")
        );
    }

    protected static function booted()
{
    static::deleting(function ($autor) {
        if ($autor->libros()->exists()) {
            throw new \Exception('No se puede eliminar un autor con libros asociados.');
        }
    });
}

    
}
