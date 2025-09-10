<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LibroStoreRequest;
use App\Http\Requests\LibroUpdateRequest;
use App\Models\Libro;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    
    public function index(Request $request)
    {
        $q = Libro::query()->with(['autores' => fn($q) => $q->orderBy('libro_autor.orden_autor')]);

        if ($t = $request->query('titulo')) {
            $q->where('titulo', 'ILIKE', "%{$t}%");
        }
        if ($anio = $request->query('anio')) {
            $q->publicadoEn((int)$anio);
        }
        if ($autor = $request->query('autor')) {
            $q->deAutor($autor); 
        }

        $perPage = (int)($request->query('per_page', 10));
        $pag = $q->paginate($perPage);

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

    
    public function show($id)
    {
        $libro = Libro::with(['autores' => fn($q) => $q->orderBy('libro_autor.orden_autor')])->find($id);
        if (!$libro) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
        }
        return response()->json(['success' => true, 'data' => $libro]);
    }

    
    public function store(LibroStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $libro = Libro::create($request->only([
                'titulo','isbn','anio_publicacion','numero_paginas','descripcion','stock_disponible'
            ]));

          
            if ($request->filled('autores')) {
                $attach = [];
                foreach ($request->input('autores') as $a) {
                    $attach[$a['id']] = ['orden_autor' => $a['orden_autor'] ?? 1];
                }
                $libro->autores()->attach($attach);
            }

            return response()->json(['success' => true, 'data' => $libro], 201);
        });
    }

   
    public function update(LibroUpdateRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $libro = Libro::find($id);
            if (!$libro) {
                return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
            }

            $libro->update($request->only([
                'titulo','isbn','anio_publicacion','numero_paginas','descripcion','stock_disponible'
            ]));

            if ($request->has('autores')) {
                
                $sync = [];
                foreach ($request->input('autores', []) as $a) {
                    $sync[$a['id']] = ['orden_autor' => $a['orden_autor'] ?? 1];
                }
                $libro->autores()->sync($sync);
            }

            return response()->json(['success' => true, 'data' => $libro]);
        });
    }

   
    public function destroy($id)
    {
        $libro = Libro::find($id);
        if (!$libro) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
        }
        $libro->delete(); 
        return response()->json(['success' => true, 'message' => 'Libro eliminado']);
    }
}
