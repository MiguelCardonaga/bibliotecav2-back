<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // GET /api/usuarios?nombre=&email=&estado=&per_page=
    public function index(Request $request)
    {
        $q = Usuario::query()->orderBy('id', 'desc');

        if ($v = $request->query('nombre')) {
            $q->where('nombre', 'ILIKE', "%{$v}%");
        }
        if ($v = $request->query('email')) {
            $q->where('email', 'ILIKE', "%{$v}%");
        }
        if ($v = $request->query('estado')) {
            $q->where('estado', $v);
        }

        $pag = $q->paginate((int)$request->query('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $pag->items(),
            'meta' => [
                'current_page' => $pag->currentPage(),
                'per_page'     => $pag->perPage(),
                'total'        => $pag->total(),
                'last_page'    => $pag->lastPage(),
            ]
        ]);
    }

    // GET /api/usuarios/{id}
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['success' => true, 'data' => $usuario]);
    }

    // POST /api/usuarios
    public function store(UsuarioStoreRequest $request)
    {
        $usuario = Usuario::create($request->only([
            'nombre','email','telefono','fecha_registro','estado'
        ]));

        return response()->json(['success' => true, 'data' => $usuario], 201);
    }

    // PUT /api/usuarios/{id}
    public function update(UsuarioUpdateRequest $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        $usuario->update($request->only([
            'nombre','email','telefono','fecha_registro','estado'
        ]));

        return response()->json(['success' => true, 'data' => $usuario]);
    }

    // DELETE /api/usuarios/{id} (borrado duro)
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }
        $usuario->delete();

        return response()->json(['success' => true, 'message' => 'Usuario eliminado']);
    }
}
