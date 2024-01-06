<?php

namespace App\Exceptions;

use Exception;

class RegistrationFailException extends Exception
{
    public function __construct($message = "Registration fail", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
