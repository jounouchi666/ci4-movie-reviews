<?php

namespace App\DTO;

final class MovieSearchResultDTO
{
    public function __construct(
        public int $page,
        public array $results,
        public int $totalPages,
        public int $totalResults
    ) {}
}