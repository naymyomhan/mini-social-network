<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserAlreadyReactedException extends Exception
{
    public function __construct($message = "Already make reaction", $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }
}
