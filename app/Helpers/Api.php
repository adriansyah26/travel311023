<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Carbon;

class Api
{
    public static function json($data = [], int $code = 200, string $message = null, bool $is_success = true, array $extraData = [])
    {
        $time = now();

        return response()->json([
            'version' => '1.0',
            'datetime' => $time?->toIso8601String(),
            'timestamp' => $time?->timestamp,
            'status' => $is_success ? 'success' : 'error',
            'code' => $code ?? 200,
            'message' => $message ?? ($is_success ? 'OK' : 'error'),
            'data' => $data ?? [],
            'errors' => null,
            ...$extraData,
        ])->setStatusCode($code);
    }
}
