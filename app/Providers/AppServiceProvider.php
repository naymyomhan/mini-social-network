<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data, $message = 'Request Successful', $status = 200) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => $message,
            ], $status);
        });

        Response::macro('error', function ($error, $message = 'Request fail!', $status = 500) {
            return response()->json([
                'status' => 'error',
                'error' => $error,
                'message' => $message,
            ], $status);
        });
    }
}
