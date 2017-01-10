<?php

namespace servientrega\Modules\Shipping;

class Industrial extends Shipping
{
    public function __construct($data)
    {
        $this->data = $data;
        parent::__construct();
    }
    protected function calculatePrice(){

    }
}
