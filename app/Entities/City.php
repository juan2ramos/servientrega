<?php

namespace servientrega\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['id_ciudad_origen','dane_ciudad_origen','nombre_ciudad_origen',
        'frecuencia_origen','id_ciudad_destino','dane_ciudad_destino','nombre_ciudad_destino',
        'frecuencia_destino','tiempo_entrega_comercial','tipo_trayecto','restriccion_fisica'];

}
