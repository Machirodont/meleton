<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Api\Methods\ApiMethodInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $handler = App::make($apiMethodClass);

        try {
            $apiRequest = $handler->getApiRequest($request);

            return $handler->execute($apiRequest);
        } catch (\Exception $e) {
            return new JsonResponse([
                'code' => $e->getCode(),
                'error' => $e->getMessage(),
                'status' => 'error',
            ], 403);
        }
    }
}
