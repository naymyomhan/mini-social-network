<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UpdateProfileFailException extends Exception
{
    public function __construct($message = "Profile update fail", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
