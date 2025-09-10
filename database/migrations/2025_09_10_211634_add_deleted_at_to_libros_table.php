<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('libros', function (Blueprint $table) {
            $table->softDeletes(); // crea columna nullable "deleted_at" TIMESTAMP
        });
    }
    public function down(): void {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropSoftDeletes(); // elimina "deleted_at"
        });
    }
};

