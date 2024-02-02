<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTraits
{
    public function success($message = 'Request successful', $data = [], $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($message = 'Fatal error', $code = Response::HTTP_INTERNAL_SERVER_ERROR, $errors = [],)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
