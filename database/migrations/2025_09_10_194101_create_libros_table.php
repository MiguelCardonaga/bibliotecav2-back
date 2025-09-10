<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 65);
            $table->text('isbn')->nullable();
            $table->integer('anio_publicacion')->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('stock_disponible')->default(0);
        });
    }
    public function down(): void {
        Schema::dropIfExists('libros');
    }
};

