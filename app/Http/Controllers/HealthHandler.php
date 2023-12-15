<?php

namespace App\Http\Controllers;

use Predis\Client;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class HealthHandler extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'message' => 'Alive and kicking!',
            'time' => now()->toDateTimeString()
        ]);
    }

    public function liveness(): JsonResponse
    {
        $redisStatus = $this->testRedisConnection();
        $mysqlStatus = $this->testPostgresConnection();
        $mongoDbStatus = $this->testMongoDBConnection();

        return response()->json([
            'redis' => $redisStatus,
            'postgres' => $mysqlStatus,
            'mongodb' => $mongoDbStatus,
        ]);
    }

    public function testRedisConnection()
    {
        $connection = 'redis';

        try {
            Redis::ping();
            return [
                'alive' => true,
            ];
        } catch (\Throwable $e) {
            return [
                'alive' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function testPostgresConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function testMongoDBConnection(): bool
    {
        try {
            $mongoHost = gethostbyname('customer_manager_mongo');
            return filter_var($mongoHost, FILTER_VALIDATE_IP) !== false;
        } catch (\Exception $e) {
            return false;
        }   
    }
}