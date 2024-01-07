<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class FileUploadFailException extends Exception
{
    public function __construct($message = "File upload failed", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
