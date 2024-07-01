<?php

namespace App\Http\Controllers;

use App\Api\Methods\ApiMethodInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController
{
    public function index(Request $request): JsonResponse
    {
        $apiMethodName = $request->input('method');
        $httpMethod = Str::lower($request->getMethod());
        $apiMethodClass = config('api.' . $httpMethod . '.' . $apiMethodName);

        if (is_null($apiMethodClass)) {
            return new JsonResponse(['error' => 'method not found'], 404);
        }
        /** @var ApiMethodInterface $handler */
        $handler = new $apiMethodClass();
        $apiRequest = $handler->getApiRequest($request);

        return $handler->execute($apiRequest);
    }
}
