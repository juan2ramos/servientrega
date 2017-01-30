<?php

namespace servientrega\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use servientrega\Modules\Shipping\ShippingFactory;


class ShippingController extends Controller
{

    public function calcPrice(Request $request)
    {
        if ($this->validation($request)->fails())
            return ['success' => 'false', 'message' => trans('messages.weightIsNot')];

        $shipping = ShippingFactory::create($this->typeShipping($request->all()), $request->all());
        return ['success' => true, 'data' => $shipping->getInfoLading()];
    }

    private function validation($request)
    {

        return Validator::make($request->all(), [
            'cantidad' => 'required',
            "valor" => "required",
            "id_ciudad_origen" => "required",
            "id_ciudad_destino" => "required",
            "peso_fisico" => "required",
            "packing.largo" => "required",
            "packing.ancho" => "required",
            "packing.alto" => "required",
            "packing.cantidad" => "required",
            "cantidad" => "required"
        ]);


    }

    /**
     * @param $data
     * @return string
     */
    private function typeShipping($data)
    {
        /* Por ahora solo vamos a trabajar con mercancia premier */
        return 'premier';
        $weight = $data['peso_fisico'];

        if ($weight > 3 || $weight < 12)
            return 'premier';
        return 'industrial';
    }
}
