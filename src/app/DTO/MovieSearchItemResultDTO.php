<?php

namespace App\DTO;

use JsonSerializable;

final class MovieSearchItemResultDTO implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $title,
        public string $originalTitle,
        public array $genre,
        public string $overview,
        public ?string $posterPath,
        public string $posterUrl,
        public ?string $backdropPath,
        public bool $adult,
        public string $releaseDate,
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'original_title' => $this->originalTitle,
            'genre' => $this->genre,
            'overview' => $this->overview,
            'poster_path' => $this->posterPath,
            'poster_url' => $this->posterUrl,
            'backdrop_path' => $this->backdropPath,
            'adult' => $this->adult,
            'release_date' => $this->releaseDate
        ];
    }
}