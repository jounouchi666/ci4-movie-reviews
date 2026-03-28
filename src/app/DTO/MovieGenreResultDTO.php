<?php

namespace App\DTO;

final class MovieGenreResultDTO
{
    public function __construct(
        public int $id,
        public string $name
    ) {}
}