<?php

namespace servientrega\Modules\Shipping;


use Illuminate\Http\Response;
use servientrega\Entities\City;

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
        return $this->lading;
    }

    protected function infoRoute()
    {
        $this->infoRoute = City::whereRaw(
            'id_ciudad_origen = ' . $this->data['id_ciudad_origen'] .
            ' and id_ciudad_destino = ' . $this->data['id_ciudad_destino']
        )->firstorFail();
    }

    protected function priceAdditionalKiloTotal($factor, $maxKilo)
    {

        return $this->checkWeight($factor) * $this->priceAdditionalKilo($maxKilo);

    }

    private function priceAdditionalKilo($maxKilo)
    {

;
        return ($this->data['peso_fisico'] - $maxKilo) *
            $this->matrizPrice[2] [strtolower(str_replace(" ", "_", $this->infoRoute->tipo_trayecto))];;
    }

    private function checkWeight($factor)
    {
        $packing = $this->data['packing'];
        $volume = ($packing['largo'] * $packing['ancho'] * $packing['alto'] * $factor) / 1000000;
        $minimumWeight = env('PESOMINIMO', 3);

        $weight = ($volume > $minimumWeight) ? $volume : $minimumWeight;
        return ($this->data['peso_fisico'] > $weight) ? $this->data['peso_fisico'] : $weight;
    }


    protected function priceLadingVariable()
    {
        $priceDeclaredMinimum = env('VALORDECLARADOMINIMO', 5000);
        $priceLadingMinimum = env('VALORFLEREVARIABLEMINIMO', 300);

        $priceDeclared = ($priceDeclaredMinimum > $this->data['valor']) ? $priceDeclaredMinimum : $this->data['valor'];
        $priceLadingVariable = $priceDeclared * env('TASADEMANEJO',0.01);

        return ($priceLadingVariable > $priceLadingMinimum) ? $priceLadingVariable : $priceLadingMinimum;
    }


}
