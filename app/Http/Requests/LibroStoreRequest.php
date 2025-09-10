<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:65',
            'isbn' => 'nullable|string',
            'anio_publicacion' => 'nullable|integer',
            'numero_paginas' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string',
            'stock_disponible' => 'nullable|integer|min:0',
            //esta spueden ir o no ir
            'autores' => 'sometimes|array',
            'autores.*.id' => 'required|integer|exists:autores,id',
            'autores.*.orden_autor' => 'nullable|integer|min:1',
        ];
    }
}

