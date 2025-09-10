<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|string|max:65',
            'isbn' => 'sometimes|nullable|string',
            'anio_publicacion' => 'sometimes|nullable|integer',
            'numero_paginas' => 'sometimes|nullable|integer|min:1',
            'descripcion' => 'sometimes|nullable|string',
            'stock_disponible' => 'sometimes|integer|min:0',
    
            'autores' => 'sometimes|array',
            'autores.*.id' => 'required|integer|exists:autores,id',
            'autores.*.orden_autor' => 'nullable|integer|min:1',
        ];
    }
}

