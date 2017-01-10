<?php

namespace servientrega\Modules\Shipping;


class ShippingFactory
{

    public static function create($type, $data) {

        switch($type) {
            case 'premier':
                return new Premier($data);
                break;
            case 'industrial':
                return new Industrial($data);
                break;
        }
    }


}
