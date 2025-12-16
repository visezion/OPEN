<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SystemTracker
{
    public static function trackFunction(string $name, callable $callback, array $params = [])
    {
        $start = microtime(true);
        try {
            $result = $callback();
            $status = 'success';
            $message = null;
        } catch (\Throwable $e) {
            $result = null;
            $status = 'error';
            $message = $e->getMessage();
        }
        $end = microtime(true);
        $executionTime = $end - $start;

        $safeParams = [];
        foreach ($params as $key => $value) {
            $safeParams[$key] = is_scalar($value) || is_null($value) ? $value : 'non_scalar';
        }

        try {
            DB::table('function_logs')->insert([
                'name' => $name,
                'status' => $status,
                'execution_time' => $executionTime,
                'parameters' => json_encode($safeParams),
                'message' => $message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $ignored) {
        }

        if ($status === 'error') {
            throw $e;
        }

        return $result;
    }
}
