<?php

namespace servientrega\Modules\Shipping;

use servientrega\Entities\IndustrialCities;

class Industrial extends Shipping
{

    private  $factor;
    private  $weightMinimum;
    public function __construct($data)
    {
        $this->data = $data;
        $this->loadMatrizPrice();
        $this->infoRoute();
        $this->calculate();
        $this->factor = env('FACTORPREMIER',400);
        $this->weightMinimum = env('PESOMINIMOINDUSTRIAL',222);
    }

    private function infoRoute()
    {
        $this->infoRoute = IndustrialCities::whereRaw(
            'id_ciudad_origen = ' . $this->data['id_ciudad_origen'] .
            ' and id_ciudad_destino = ' . $this->data['id_ciudad_destino']
        )->firstorFail();
    }
    private function calculate()
    {
        $weight = $this->checkWeight($this->factor);
        $weightTotal = ($weight > $this->weightMinimum)?$weight:$this->weightMinimum;
        $price = $this->infoRoute->tarifa_kilo *  $weightTotal;

        $priceMatrizMinimum = $this->matrizPrice
        [strtolower(str_replace(" ", "_", $this->infoRoute->tipo_trayecto))];

        $price = ($priceMatrizMinimum > $price) ? $priceMatrizMinimum:$price;

        $this->lading = $this->priceLadingVariable() + $price;
    }

    private function loadMatrizPrice()
    {
        $this->matrizPrice['nacional'] = env('NACIONALINDUSTRIAL', 8150);
        $this->matrizPrice['zonal'] = env('ZONALINDUSTRIAL', 3500);
        $this->matrizPrice['urbano'] = env('URBANOINDUSTRIAL', 3550);
        $this->matrizPrice['trayecto_especial'] = env('TRAYECTOESPECIALINDUSTRIAL', 3550);
    }
}
