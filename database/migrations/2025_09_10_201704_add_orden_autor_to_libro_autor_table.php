<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void {
        Schema::table('libro_autor', function (Blueprint $table) {
            $table->unsignedInteger('orden_autor')->default(1);
        });
    }
    public function down(): void {
        Schema::table('libro_autor', function (Blueprint $table) {
            $table->dropColumn('orden_autor');
        });
    }
};
