<?php

namespace App\Exceptions;

use Exception;

class SubmissionProcessException extends Exception
{
    protected $message = 'Submission processing error.';

    public function __construct($message = null, $code = 500, Exception $previous = null)
    {
        if ($message !== null) {
            $this->message = $message;
        }
        parent::__construct($this->message, $code, $previous);
    }
}
