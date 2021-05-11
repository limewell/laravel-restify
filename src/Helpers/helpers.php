<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('restify_api_response')) {
    function restify_api_response(array $args, $status = 200): JsonResponse
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
