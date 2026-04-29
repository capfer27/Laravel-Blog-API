<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse {

    /**
     * Standard Success Response
     */
    protected function successResponse(mixed $data = [], string $code = 'SUCCESS', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'code'    => $code,
            'data'    => $data,
        ], $statusCode);
    }

    /**
     * Standard Error Response
     */
    protected function errorResponse(string $code, array $errorFields = [], int $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'code'    => $code,
            'data'    => [],
        ];

        if (!empty($errorFields)) {
            $response['errorFields'] = $errorFields;
        }

        return response()->json($response, $statusCode);
    }

}