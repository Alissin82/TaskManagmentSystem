<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Returns a JSON response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function apiResponse(string $message, mixed $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Returns a success response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(string $message = 'عملیات با موفقیت انجام شد', mixed $data = [], int $statusCode = 200): JsonResponse
    {
        return $this->apiResponse($message, $data, $statusCode);
    }

    /**
     * Returns a failure response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function failureResponse(string $message = 'عملیات انجام نشد', mixed $data = [], int $statusCode = 400): JsonResponse
    {
        return $this->apiResponse($message, $data, $statusCode);
    }
}
