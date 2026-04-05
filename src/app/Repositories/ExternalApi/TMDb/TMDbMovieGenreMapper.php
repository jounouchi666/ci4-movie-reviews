<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieGenreResultDTO;

class TMDbMovieGenreMapper
{
    public function fromId(int $genreId, array $genreMap): MovieGenreResultDTO
    {
        return new MovieGenreResultDTO(
            id:     $genreId,
            name:   $genreMap[$genreId] ?? ''
        );
    }

    public function fromIds(?array $genreIds, array $genreMap): array
    {
        return array_map(fn ($genreId) => $this->fromId($genreId, $genreMap), $genreIds ?? []);
    }

    public function fromObject(array $genre): MovieGenreResultDTO
    {
        return new MovieGenreResultDTO(
            id:     $genre['id'],
            name:   $genre['name']
        );
    }

    public function fromObjects(?array $genres): array
    {
        return array_map(fn ($genre) => $this->fromObjects($genre), $genres ?? []);
    }
}