<?php

namespace servientrega\Modules\Shipping;


use Illuminate\Http\Response;

abstract class Shipping
{
    protected $data;
    protected $typeRoute;
    protected $lading;
    protected $infoRoute;
    protected $matrizPrice = [];

    /**
     * @return array
     */
    public function getInfoLading()
    {
        return [
          'precio' => $this->lading,
          'tipo_trayecto' => $this->infoRoute['tipo_trayecto'],
          'id_ciudad_origen' => $this->infoRoute['id_ciudad_origen'],
          'id_ciudad_destino' => $this->infoRoute['id_ciudad_destino']
        ];
    }

    protected function checkWeight($factor)
    {
        $packing = $this->data['packing'];

        $volume = ($packing['largo'] * $packing['ancho'] * $packing['alto'] * $factor) / 1000000;
        $minimumWeight = env('PESOMINIMO', 3);
        $weight = ($volume > $minimumWeight) ? $volume : $minimumWeight;

        return ($this->data['peso_fisico'] > $weight) ? $this->data['peso_fisico'] : $weight;
    }


    protected function  priceLadingVariable()
    {
        $priceDeclaredMinimum = env('VALORDECLARADOMINIMO', 5000);
        $priceLadingMinimum = env('VALORFLEREVARIABLEMINIMO', 300);

        $priceDeclared = ($priceDeclaredMinimum > $this->data['valor']) ? $priceDeclaredMinimum : $this->data['valor'];
        $priceLadingVariable = $priceDeclared * env('TASADEMANEJO',0.01);

        return ($priceLadingVariable > $priceLadingMinimum) ? $priceLadingVariable : $priceLadingMinimum;
    }


}
