<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Libro;
use App\Models\Autor;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        $libros = Libro::factory()->count(20)->create();

        $autorIds = Autor::pluck('id')->all();
      foreach ($libros as $libro) {
    $cantidad = rand(1, min(3, count($autorIds)));
    $seleccion = collect($autorIds)->random($cantidad)->values();

    $attachData = [];
    foreach ($seleccion as $idx => $autorId) {
        $attachData[$autorId] = ['orden_autor' => $idx + 1];
    }

    $libro->autores()->attach($attachData);
    }

}
}

