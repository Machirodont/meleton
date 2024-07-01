<?php

namespace App\Api\Methods;

use App\Api\Requests\ApiRequestInterface;
use App\Api\Requests\RatesApiRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatesApiMethod implements ApiMethodInterface
{
    public function getApiRequest(Request $request): RatesApiRequest
    {
        return new RatesApiRequest();
    }

    public function execute(RatesApiRequest|ApiRequestInterface $request): JsonResponse
    {
        return new JsonResponse(['data' => 'data']);
    }
}
