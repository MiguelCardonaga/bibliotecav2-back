<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombre'          => 'required|string|max:65',
            'email'           => 'required|email|max:65|unique:usuarios,email',
            'telefono'        => 'nullable|string|max:65',
            'fecha_registro'  => 'nullable|date',
            'estado'          => 'nullable|string|in:activo,inactivo',
        ];
    }
}