<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log time before execution
        $startTime = microtime(true);

        // execute request
        $response = $next($request);
        $allParams = request_params_to_json(request()->all());

        // Log time after execution
        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2);


        // 记录请求信息到数据库
        if($response->getStatusCode() == 200){
            $today = now()->format('Ymd');
            $tableName = 'log_' . $today;
            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->string('request_method', 10,);
                    $table->string('request_uri', 1024);
                    $table->string('request_params', 1024);
                    $table->string('http_code', 10);
                    $table->decimal('execution_time');
                    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                });
            }
            //Insert data
            if (Schema::hasTable($tableName)) {
                DB::table($tableName)->insert([
                    'request_method' => $request->method(),
                    'request_uri' => $request->path(),
                    'request_params' => $allParams,
                    'http_code' => $response->getStatusCode(),
                    'execution_time' => $executionTime
                ]);
            }
        }


        return $response;
    }
}
