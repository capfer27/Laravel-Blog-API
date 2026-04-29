<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse {

    /**
     * Successfully Response
     */

    protected function successResponse(mixed $data, int $httpCode = 200): JsonResponse 
    {
        return response()->json([
            'success' => true,
            'code' => (string) $httpCode,
            'data' => $data
        ], $httpCode);
    }

    protected function errorResponse(int $httpCode, string $message = '', ?array $errorFields = null): JsonResponse 
    {
        $response = [
            'success' => false,
            'code' => (string) $httpCode,
            'data' => [],
        ];

        if ($errorFields) {
            $response['data']['errorFields'] = $errorFields;
        } else if ($message) {
            $response['data']['message'] = $message;
        }

        return response()->json($response, $httpCode);
    }

    /**
     * Standard Success Response
     */
    protected function successResponseV2($data = [], string $code = 'SUCCESS', int $statusCode = 200): JsonResponse
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
    protected function errorResponseV2(string $code, $errorFields = [], int $statusCode = 400): JsonResponse
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