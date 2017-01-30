<?php

namespace servientrega\Modules\Shipping;
use servientrega\Entities\City;
class Premier extends Shipping
{

    public function __construct($data)
    {
        $this->data = $data;
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
        $priceAdditionalKilo = ($this->data['peso_fisico'] > 12) ?
            $this->priceAdditionalKiloTotal(env('FACTORPREMIER',222),env('MAXKILOPREMIER',12)) : 0;

        $priceLadingGross = $this->priceInitialKilo() + $priceAdditionalKilo;
        $minimumLadingt = env('VALORFLETEMINIMO',300);
        return ($priceLadingGross > $minimumLadingt ) ? $priceLadingGross : $minimumLadingt ;
    }

    protected function priceInitialKilo()
    {
        return $this->matrizPrice
        [$this->getIdWeight($this->data['peso_fisico'])]
        [strtolower(str_replace(" ", "_", $this->infoRoute->tipo_trayecto))];
    }

    private function getIdWeight($weight)
    {
        return ($weight <= 3) ? 0 : (($weight >= 4 && $weight <= 12) ? 1 : 2);
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
