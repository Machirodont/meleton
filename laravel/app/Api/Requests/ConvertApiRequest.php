<?php
declare(strict_types=1);

namespace App\Api\Requests;

class ConvertApiRequest implements ApiRequestInterface
{
    public function __construct(
        public string $currencyFrom,
        public string $currencyTo,
        public float $value,
    ) {
    }
}
