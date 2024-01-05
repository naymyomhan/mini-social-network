<?php

namespace App\Exceptions;

use Exception;

class RegistrationFailException extends Exception
{
    public static function registrationFail(string $message = "Something went wrong"): RegistrationFailException
    {
        return new self(message: $message, code: 500);
    }
}
