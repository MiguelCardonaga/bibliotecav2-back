<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('id'); // /api/usuarios/{id}
        return [
            'nombre'          => 'sometimes|string|max:65',
            'email'           => 'sometimes|email|max:65|unique:usuarios,email,'.$id,
            'telefono'        => 'sometimes|nullable|string|max:65',
            'fecha_registro'  => 'sometimes|nullable|date',
            'estado'          => 'sometimes|nullable|string|in:activo,inactivo',
        ];
    }
}
