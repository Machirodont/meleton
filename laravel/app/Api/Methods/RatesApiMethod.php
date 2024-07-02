<?php
declare(strict_types=1);

namespace App\Api\Methods;

use App\Api\Requests\ApiRequestInterface;
use App\Api\Requests\RatesApiRequest;
use App\Services\RateCalculator\RatesCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class RatesApiMethod implements ApiMethodInterface
{
    public function __construct(
        private RatesCalculator $ratesCalculator
    ) {
    }

    public function getApiRequest(Request $request): RatesApiRequest
    {
        return new RatesApiRequest();
    }

    public function execute(RatesApiRequest|ApiRequestInterface $request): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'code' => 200,
            'data' => $this->ratesCalculator->getAllRates()
        ]);
    }
}
