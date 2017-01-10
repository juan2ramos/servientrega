<?php

namespace servientrega\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use servientrega\Modules\Shipping\ShippingFactory;


class ShippingController extends Controller
{

    public function calcPrice(Request $request)
    {
        if ($this->validation($request))
            return ['success' => 'false', 'message' => trans('messages.weightIsNot')];

        $shipping = ShippingFactory::create($this->typeShipping($request->all()), $request->all());
        return ['success' => true , 'price' => $shipping->getInfoLadig()];
    }

    private function validation($request)
    {

        $this->validate($request, [
            'cantidad' => 'required'
        ]);
    }

    private function typeShipping($data)
    {

        $weight = $data['peso_fisico'];

        if ($weight > 3 || $weight < 12)
            return 'premier';
        return 'industrial';
    }


}
