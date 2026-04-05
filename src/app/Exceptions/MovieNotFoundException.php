<?php

namespace App\Exceptions;

use Exception;

final class MovieNotFoundException extends Exception
{
    public function __construct(string $movieId)
    {
        return parent::__construct("映画(ID:{$movieId})が見つかりません。");
    }
}