<?php

namespace App\DTO;

use JsonSerializable;

final class MovieSearchResultDTO implements JsonSerializable
{
    public function __construct(
        public int $page,
        public array $results,
        public int $totalPages,
        public int $totalResults
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'page' => $this->page,
            'results' => $this->results,
            'total_pages' => $this->totalPages,
            'total_results' => $this->totalResults
        ];
    }
}