<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        // Crear la tabla 'users' con las columnas especificadas
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->string('name'); // Columna para el nombre del usuario
            $table->string('email')->unique(); // Columna para el email del usuario, debe ser único
            $table->string('password'); // Columna para la contraseña del usuario
            $table->enum('role', ['admin', 'doctor', 'patient']); // Columna para el rol del usuario, con valores posibles
            $table->timestamps(); // Columnas para 'created_at' y 'updated_at'
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar la tabla 'users' si existe
        Schema::dropIfExists('users');
    }
}
