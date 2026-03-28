<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieGenreResultDTO;
use App\DTO\MovieSearchItemResultDTO;
use App\DTO\MovieSearchResultDTO;

class TMDbMovieSearchMapper
{
    public function toDTO(array $response, array $genreMap): MovieSearchResultDTO
    {
        $imageBaseUrl = config('tmdb.image_base_url');

        $movies = array_map(fn ($movie) => new MovieSearchItemResultDTO(
                id:             $movie['id'] ?? '',
                title:          $movie['title'] ?? '',
                originalTitle:  $movie['original_title'] ?? '',
                genre:          array_map(fn($genreId) => new MovieGenreResultDTO(
                                        id:     $genreId,
                                        name:   $genreMap[$genreId] ?? ''
                                    ),
                                    $movie['genre_ids'] ?? []
                                ),
                overview:       $movie['overview'] ?? '',
                posterPath:     !empty($movie['poster_path'])
                                    ? "{$imageBaseUrl}/original/{$movie['poster_path']}"
                                    : null,
                backdropPath:   !empty($movie['backdrop_path'])
                                    ? "{$imageBaseUrl}/original/{$movie['backdrop_path']}"
                                    : null,
                adult:          $movie['adult'] ?? false,
                releaseDate:    $movie['release_date'] ?? ''
        ), $response['results'] ?? []);
        
        return new MovieSearchResultDTO(
            page:           $response['page'] ?? 1,
            results:        $movies,
            totalPages:     $response['total_pages'] ?? 0,
            totalResults:   $response['total_results'] ?? 0
        );
    }
}