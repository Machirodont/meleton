<?php
declare(strict_types=1);

namespace App\Api\Methods;

use App\Api\Requests\ApiRequestInterface;
use App\Api\Requests\ConvertApiRequest;
use App\Services\RateCalculator\RatesCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class ConvertApiMethod implements ApiMethodInterface
{
    public function __construct(
        private RatesCalculator $ratesCalculator,
    ) {
    }

    public function getApiRequest(Request $request): ConvertApiRequest
    {
        $request->validate([
            'currency_from' => 'required|size:3',
            'currency_to' => 'required|size:3',
            'value' => 'required|numeric|min:0.1',
        ]);

        return new ConvertApiRequest(
            (string)$request->post('currency_from'),
            (string)$request->post('currency_to'),
            (float)$request->post('value'),
        );
    }

    public function execute(ConvertApiRequest|ApiRequestInterface $request): JsonResponse
    {
        $convertedValue = $this->ratesCalculator->calculate($request);

        $precision = $request->currencyFrom === RatesCalculator::BASE_CURRENCY ? 10 : 2;

        return new JsonResponse([
            'status' => 'success',
            'code' => 200,
            'data' => [
                'currency_from' => $request->currencyFrom,
                'currency_to' => $request->currencyTo,
                'value' => $request->value,
                'converted_value' => round($convertedValue, $precision),
                'rate' => $this->ratesCalculator->getRate($request),
            ],
        ]);
    }
}
