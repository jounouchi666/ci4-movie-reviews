<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieSearchResultDTO;

class TMDbMovieSearchMapper
{
    public function __construct(
        private TMDbMovieSearchItemMapper $tmdbMovieSearchItemMapper,
    ) {}

    public function toDTO(array $response, array $genreMap): MovieSearchResultDTO
    {
        return new MovieSearchResultDTO(
            page:           $response['page'] ?? 1,
            results:        $this->tmdbMovieSearchItemMapper->mapFromGenreIdsFromArray($response['results'] ?? [], $genreMap),
            totalPages:     $response['total_pages'] ?? 0,
            totalResults:   $response['total_results'] ?? 0
        );
    }
}