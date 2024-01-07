<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PostUploadFailException extends Exception
{
    public function __construct($message = "Create new post failed", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
