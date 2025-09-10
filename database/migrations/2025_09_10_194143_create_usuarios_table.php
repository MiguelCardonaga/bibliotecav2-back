<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 65);
            $table->string('email', 65)->unique()->nullable(false);
            $table->string('telefono', 65)->nullable();
            $table->timestamp('fecha_registro')->nullable();
            $table->string('estado', 65)->nullable(); 
        });
    }
    public function down(): void {
        Schema::dropIfExists('usuarios');
    }
};
