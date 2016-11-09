<?php

namespace App\Services;

use Swap\Builder;

class Currency
{
    public function __construct()
    {
        $this->swap = (new Builder())
            ->add('fixer')
            ->build();
    }

    public function today()
    {
        $results = \Cache::remember('exchange-rate', 5, function() {
            return [
                ['label' => 'GBP/HRK', 'rate' => $this->swap->latest('GBP/HRK')->getValue()],
                ['label' => 'EUR/HRK', 'rate' => $this->swap->latest('EUR/HRK')->getValue()],
                ['label' => 'USD/HRK', 'rate' => $this->swap->latest('USD/HRK')->getValue()],
            ];
        });

        return $results;
    }
}
