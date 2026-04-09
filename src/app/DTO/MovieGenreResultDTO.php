<?php

namespace App\DTO;

use JsonSerializable;

final class MovieGenreResultDTO implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $name
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}