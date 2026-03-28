<?php

namespace App\DTO;

final class MovieSearchItemResultDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $originalTitle,
        public array $genre,
        public string $overview,
        public ?string $posterPath,
        public ?string $backdropPath,
        public bool $adult,
        public string $releaseDate,
    ) {}
}