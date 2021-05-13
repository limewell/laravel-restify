<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('restify_api_response')) {
    /**
     * @param array $args
     * @param int $status
     * @return JsonResponse
     */
    function restify_api_response(array $args, int $status = 200): JsonResponse
    {
        extract($args);
        return response()->json([
            'data' => $data ?? [],
            'success' => $success ?? true,
            'message' => $message ?? null,
            'meta' => $meta ?? null,
            'errors' => $errors ?? null,
        ], $status);
    }
}
