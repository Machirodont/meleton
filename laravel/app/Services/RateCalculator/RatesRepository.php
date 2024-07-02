<?php
declare(strict_types=1);

namespace App\Services\RateCalculator;

use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class RatesRepository
{
    public const CACHE_KEY = 'rates_cache';

    public const CACHE_TTL_SEC = 60 * 15;

    public function getRate(string $currencyCode): ?float
    {
        return isset($this->getAllRates()[$currencyCode]) ? $this->getAllRates()[$currencyCode] : null;
    }

    public function getAllRates(): array
    {
        $courses = Cache::get(self::CACHE_KEY);
        if ($courses === null) {
            throw new Exception('Rates data is not loaded', 501);
        }

        return $courses;
    }

    /**
     * @param array<string, float> $rates
     * @return void
     */
    public function save(array $rates): void
    {
        Cache::set(self::CACHE_KEY, $rates, self::CACHE_TTL_SEC);
    }
}
