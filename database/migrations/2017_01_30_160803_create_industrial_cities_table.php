<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustrialCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industrial_cities', function (Blueprint $table) {
            $table->increments('id');

            $table->string('id_ciudad_origen');
            $table->string('nombre_ciudad_origen');
            $table->string('frecuencia_origen')->nullable();

            $table->string('id_ciudad_destino');
            $table->string('nombre_ciudad_destino');
            $table->string('frecuencia_destino')->nullable();

            $table->string('tiempo_entrega_comercial');
            $table->string('tipo_trayecto')->nullable();
            $table->string('restriccion_fisica')->nullable();
            $table->string('tarifa_kilo');

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
        //
    }
}
