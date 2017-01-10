<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');

            $table->string('id_ciudad_origen');
            $table->string('dane_ciudad_origen');
            $table->string('nombre_ciudad_origen');
            $table->string('frecuencia_origen')->nullable();

            $table->string('id_ciudad_destino');
            $table->string('dane_ciudad_destino');
            $table->string('nombre_ciudad_destino');
            $table->string('frecuencia_destino')->nullable();

            $table->string('tiempo_entrega_comercial');
            $table->string('tipo_trayecto');
            $table->string('restriccion_fisica')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
