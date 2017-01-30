<?php

namespace servientrega\Modules\Shipping;
use servientrega\Entities\City;
class Premier extends Shipping
{
    private $factor ;
    public function __construct($data)
    {
        $this->data = $data;
        $this->factor = env('FACTORPREMIER',222);
        $this->loadMatrizPrice();
        $this->infoRoute();
        $this->calculate();
    }

    private function calculate()
    {
        $this->lading = $this->priceLadingVariable() + $this->priceLadingFixedTotal();
    }
    private function infoRoute()
    {
        $this->infoRoute = City::whereRaw(
            'id_ciudad_origen = ' . $this->data['id_ciudad_origen'] .
            ' and id_ciudad_destino = ' . $this->data['id_ciudad_destino']
        )->firstorFail();
    }
    private function priceLadingFixedTotal()
    {

        $weightTotal = $this->checkWeight($this->factor);
        $priceAdditionalKilo = ($weightTotal > 12) ?
            $this->priceAdditionalKiloTotal($weightTotal, env('MAXKILOPREMIER',12)) : 0;

        $priceLadingGross = $this->priceInitialKilo($weightTotal) + $priceAdditionalKilo;
        $minimumLadingt = env('VALORFLETEMINIMO',300);
        return ($priceLadingGross > $minimumLadingt ) ? $priceLadingGross : $minimumLadingt ;
    }

    private function priceInitialKilo($weightTotal)
    {
        return $this->matrizPrice
        [$this->getIdWeight($weightTotal)]
        [strtolower(str_replace(" ", "_", $this->infoRoute->tipo_trayecto))];
    }
    private function priceAdditionalKiloTotal($weightTotal, $maxKilo)
    {
        return ($weightTotal - $maxKilo) *
            $this->matrizPrice[2] [strtolower(str_replace(" ", "_", $this->infoRoute->tipo_trayecto))];
    }

    private function getIdWeight($weight)
    {
        return ($weight <= 3) ? 0 : 1 ;
    }

    private function loadMatrizPrice()
    {
        $this->matrizPrice[0]['nacional'] = env('NACIONAL1', 8200);
        $this->matrizPrice[1]['nacional'] = env('NACIONAL2', 13900);
        $this->matrizPrice[2]['nacional'] = env('NACIONAL3', 2600);
        $this->matrizPrice[0]['zonal'] = env('ZONAL1', 5800);
        $this->matrizPrice[1]['zonal'] = env('ZONAL2', 9800);
        $this->matrizPrice[2]['zonal'] = env('ZONAL3', 2100);
        $this->matrizPrice[0]['urbano'] = env('URBANO1', 4900);
        $this->matrizPrice[1]['urbano'] = env('URBANO2', 8400);
        $this->matrizPrice[2]['urbano'] = env('URBANO3', 1800);
        $this->matrizPrice[0]['trayecto_especial'] = env('ESPECIAL1', 15800);
        $this->matrizPrice[1]['trayecto_especial'] = env('ESPECIAL2', 26800);
        $this->matrizPrice[2]['trayecto_especial'] = env('ESPECIAL3', 5700);
    }


}
