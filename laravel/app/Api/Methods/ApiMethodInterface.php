<?php

namespace App\Api\Methods;

use App\Api\Requests\ApiRequestInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ApiMethodInterface
{
    public function getApiRequest(Request $request): ApiRequestInterface;

    public function execute(ApiRequestInterface $request): JsonResponse;
}
