<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Usuario extends Model
{

    use HasFactory;


    public $timestamps = false;
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre','email','telefono','fecha_registro','estado'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'usuario_id');
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? mb_strtolower(trim($value), 'UTF-8') : null
        );
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_convert_case(trim($value), MB_CASE_TITLE, "UTF-8")
        );
    }
}
