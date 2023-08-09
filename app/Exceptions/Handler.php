<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        //params
        $allParams = request()->all();
        if (!empty($allParams)) {
            if (is_array($allParams)) {
                $allParams = json_encode($allParams);
            }
        } else {
            $allParams = json_encode((object)[]);
        }
        //uri
        $requestUri = request()->path();
        //Create table
        $today = now()->format('Ymd');
        $tableName = 'errors_' . $today;
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('error_type', 255);
                $table->string('request_method', 255);
                $table->string('request_uri', 255);
                $table->string('request_params', 255);
                $table->text('message');
                $table->string('file', 255);
                $table->integer('line');
                $table->text('trace');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });
        }
        //Insert data
        if (Schema::hasTable($tableName)) {
            DB::table($tableName)->insert([
                'error_type' => get_class($exception),
                'request_method' => request()->method(),
                'request_uri' => $requestUri,
                'request_params' => $allParams,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
        if (config('app.debug')) {
            return parent::render($request, $exception);
        } else {
            if (get_class($exception) == 'Error') {
                $res = message_error(1, 'Internal Server Error');
                return response()->json($res, 500);
            } else {
                return parent::render($request, $exception);
            }
        }
    }
}
