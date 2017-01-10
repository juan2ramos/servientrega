<?php

namespace servientrega\Modules\Shipping;

class Premier extends Shipping
{
    public function __construct($data)
    {
        $this->data = $data;
        parent::__construct();
    }

    protected function calculatePrice()
    {
        $priceKilo = $this->priceInitialKilo();
        $landigMinimal = env('LADING_MINIMAL');
        $priceLadingFixedTotal = ($priceKilo > $landigMinimal) ? $priceKilo : $landigMinimal;
        return $this->ladingTotal($priceLadingFixedTotal);
    }

    private function ladingTotal($priceLadingFixedTotal)
    {
        return $this->calculateValueLadigVariableTotal() + $priceLadingFixedTotal;
    }
    private function calculateValueLadigVariableTotal(){

        $priceDeclared = $this->data['valor'];
        $declaredMinimumValue = env('DECLARED_MINIMUM_VALUE');
        $priceLadigVariable = env('PRICE_LADIG_VARIABLE_MINIMUM');

        $priceDeclaredTotal = ($priceDeclared > $declaredMinimumValue)?$priceDeclared:$declaredMinimumValue;
        $valueLadigVariable = $priceDeclaredTotal * env('FEE');

        return ($valueLadigVariable >$priceLadigVariable)?$valueLadigVariable : $priceLadigVariable;
    }
}
