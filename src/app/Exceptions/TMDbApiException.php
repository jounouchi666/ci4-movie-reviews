<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class TMDbApiException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}