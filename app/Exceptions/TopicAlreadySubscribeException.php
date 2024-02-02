<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class TopicAlreadySubscribeException extends Exception
{
    public function __construct($message = "Already subscribed to this topic", $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }
}
