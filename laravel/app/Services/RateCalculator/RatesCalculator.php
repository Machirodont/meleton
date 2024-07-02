<?php

declare(strict_types=1);

namespace App\Services\RateCalculator;

use App\Api\Requests\ConvertApiRequest;
use Exception;

class RatesCalculator
{
    public const BASE_CURRENCY = 'BTC';

    public function __construct(
        private readonly RatesRepository $ratesRepository,
    ) {
    }

    public function calculate(ConvertApiRequest $request): float
    {
        $dealDirection = $this->getDealDirection($request->currencyFrom, $request->currencyTo);
        if ($dealDirection === DealDirectionEnum::Buy) {
            return $request->value / $this->getRate($request);
        }

        return $request->value * $this->getRate($request);
    }

    public function getAllRates(): array
    {
        $basicRates = $this->ratesRepository->getAllRates();
        $ratesResponse = [];
        foreach ($basicRates as $currencyCode => $rate) {
            $ratesResponse[$currencyCode] = [
                'buy' => round($this->calculateRateWithCommission($rate, DealDirectionEnum::Buy), 2),
                'sell' => round($this->calculateRateWithCommission($rate, DealDirectionEnum::Sell), 2),
            ];
        }

        return $ratesResponse;
    }

    public function calculateRateWithCommission(float $rate, DealDirectionEnum $dealDirection): float
    {
        if ($dealDirection === DealDirectionEnum::Buy) {
            return $rate / (1 - $this->getCommission());
        }
        if ($dealDirection === DealDirectionEnum::Sell) {
            return $rate * (1 - $this->getCommission());
        }

        return $rate;
    }

    public function getDealDirection(string $currencyFrom, string $currencyTo): DealDirectionEnum
    {
        if ($currencyFrom === self::BASE_CURRENCY && $currencyTo !== self::BASE_CURRENCY) {
            return DealDirectionEnum::Sell;
        }
        if ($currencyTo === self::BASE_CURRENCY && $currencyFrom !== self::BASE_CURRENCY) {
            return DealDirectionEnum::Buy;
        }
        throw new Exception('One of the currency must be ' . self::BASE_CURRENCY);
    }

    public function getRate(ConvertApiRequest $request): float
    {
        $secondaryCurrencyCode = $request->currencyFrom === self::BASE_CURRENCY
            ? $request->currencyTo
            : $request->currencyFrom;
        $baseRate = $this->ratesRepository->getRate($secondaryCurrencyCode);

        if ($baseRate === null) {
            throw new Exception('Currency not found');
        }

        $dealDirection = $this->getDealDirection($request->currencyFrom, $request->currencyTo);

        return $this->calculateRateWithCommission($baseRate, $dealDirection);
    }

    public function getCommission(): float
    {
        return (float)config('exchanger.commission_percent') * 0.01;
    }
}
