<?php
declare(strict_types=1);

namespace App\Services\RateCalculator;

enum DealDirectionEnum: string
{
    case Buy = 'buy';

    case Sell = 'sell';
}
