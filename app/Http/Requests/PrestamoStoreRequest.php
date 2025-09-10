<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'usuario_id' => 'required|integer|exists:usuarios,id',
            'libro_id' => 'required|integer|exists:libros,id',
            'fecha_prestamo' => 'nullable|date',
            'fecha_devolucion_estimada' => 'required|date|after_or_equal:fecha_prestamo',
        ];
    }
}

