<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrestamoStoreRequest;
use App\Http\Requests\PrestamoDevolverRequest;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrestamoController extends Controller
{
     // GET /api/prestamos
    public function index(Request $request)
    {
        $q = Prestamo::query()
            ->with(['libro:id,titulo','usuario:id,nombre,email'])
            ->orderByDesc('id');

        // filtros opcionales:
        if ($uid = $request->query('usuario_id')) $q->where('usuario_id', $uid);
        if ($lid = $request->query('libro_id')) $q->where('libro_id', $lid);
        if ($estado = $request->query('estado')) $q->where('estado', $estado);

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

    // POST /api/prestamos
    public function store(PrestamoStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $usuario = Usuario::find($request->usuario_id);
            $libro   = Libro::find($request->libro_id);

            // Regla 1: no prestar si no hay stock
            if (($libro->stock_disponible ?? 0) <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay stock disponible de este libro'
                ], 422);
            }

            // Regla 2: un usuario no puede tener > 3 préstamos activos
            // Consideramos activos: 'pendiente' o 'activo' (ajusta según tu semántica)
            $activos = Prestamo::where('usuario_id', $usuario->id)
                ->whereIn('estado', ['pendiente','activo'])
                ->count();

            if ($activos >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario ya tiene 3 préstamos activos'
                ], 422);
            }

            // Crear préstamo
            $prestamo = Prestamo::create([
                'usuario_id' => $usuario->id,
                'libro_id'   => $libro->id,
                'fecha_prestamo' => $request->input('fecha_prestamo', now()->toDateString()),
                'fecha_devolucion_estimada' => $request->input('fecha_devolucion_estimada', now()->addDays(15)->toDateString()),
                'estado' => 'activo',
            ]);

            // Descontar stock
            $libro->decrement('stock_disponible');

            return response()->json(['success' => true, 'data' => $prestamo], 201);
        });
    }

    // PUT /api/prestamos/{id}/devolver
    public function devolver(PrestamoDevolverRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $prestamo = Prestamo::find($id);
            if (!$prestamo) {
                return response()->json(['success' => false, 'message' => 'Préstamo no encontrado'], 404);
            }

            if ($prestamo->estado === 'devuelto') {
                return response()->json(['success' => false, 'message' => 'El préstamo ya está devuelto'], 422);
            }

            $prestamo->update([
                'fecha_devolucion_real' => $request->input('fecha_devolucion_real', now()->toDateString()),
                'estado' => 'devuelto',
            ]);

            // Regla: al devolver, reponer stock del libro
            $prestamo->libro()->update([
                'stock_disponible' => DB::raw('stock_disponible + 1')
            ]);

            return response()->json(['success' => true, 'data' => $prestamo]);
        });
    }
}
