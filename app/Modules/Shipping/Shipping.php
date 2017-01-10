<?php

namespace servientrega\Modules\Shipping;


use Illuminate\Http\Response;
use servientrega\Entities\City;

abstract class Shipping
{
    protected $data;
    protected $ladig;
    protected $infoTrip;
    protected $weightInvoice;


    public function __construct()
    {
        $this->weightInvoice();
        $this->ladig = [
            'precio' => $this->calculatePrice(),
            'tipo_trayecto' => $this->infoTrip->tipo_trayecto
        ];
    }

    public function weightInvoice()
    {
        $weightVolumetric = $this->calcWeightVolumetric();
        $weight = $this->data['peso_fisico'] * $this->data['cantidad'];

        $this->weightInvoice = ($weightVolumetric > $weight) ? $weightVolumetric : $weight;
    }

    private function calcWeightVolumetric()
    {
        return $this->data['packing']['largo'] * $this->data['packing']['ancho'] *
            $this->data['packing']['alto'] * $this->data['packing']['cantidad'] * 222;
    }

    protected function priceInitialKilo()
    {
        $infoTrip = City::whereRaw(
            'id_ciudad_origen = ' . $this->data['id_ciudad_origen'] .
            ' and id_ciudad_destino = ' . $this->data['id_ciudad_destino']
        )->firstorFail();
        $this->infoTrip = $infoTrip;
        return $this->calculatePriceInitialKilo();
    }

    private function calculatePriceInitialKilo()
    {
        /*
         * Valor de test,
         * */
        return 20000;
    }


    /**
     * @return mixed
     */
    public function getInfoLadig()
    {

        return $this->ladig;
    }


}
