<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('api_response')) {
    function api_response(array $args, $status = 200): JsonResponse
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
