<?php

namespace App\Api\Methods;

use App\Api\Requests\ApiRequestInterface;
use App\Api\Requests\ConvertApiRequest;
use App\Api\Requests\RatesApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConvertApiMethod implements ApiMethodInterface
{
    public function getApiRequest(Request $request): ConvertApiRequest
    {

        return new ConvertApiRequest(
            $request->post('currency_from'),
            $request->post('currency_to'),
            $request->post('value'),
        );
    }

    public function execute(ConvertApiRequest|ApiRequestInterface $request): JsonResponse
    {
        return new JsonResponse(['data' => 'data']);
    }
}
