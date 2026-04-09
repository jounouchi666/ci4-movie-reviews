<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieSearchItemResultDTO;

class TMDbMovieSearchItemMapper
{
    public function __construct(
        private TMDbMovieGenreMapper $tmdbMovieGenreMapper,
    ) {}

    public function toDTOFromIds(array $movie, array $genreMap): MovieSearchItemResultDTO
    {
        $movieArray = $this->toArray($movie);

        return new MovieSearchItemResultDTO(
            id:             $movieArray['id'],
            title:          $movieArray['title'],
            originalTitle:  $movieArray['original_title'],
            genre:          $this->tmdbMovieGenreMapper->fromIds($movieArray['genres'], $genreMap),
            overview:       $movieArray['overview'],
            posterPath:     $movieArray['poster_path'],
            posterUrl:      $movieArray['poster_url'],
            backdropPath:   $movieArray['backdrop_path'],
            adult:          $movieArray['adult'],
            releaseDate:    $movieArray['release_date']
        );
    }

    public function toDTOFromObjects($movie): MovieSearchItemResultDTO
    {
        $movieArray = $this->toArray($movie);

        return new MovieSearchItemResultDTO(
            id:             $movieArray['id'],
            title:          $movieArray['title'],
            originalTitle:  $movieArray['original_title'],
            genre:          $this->tmdbMovieGenreMapper->fromObjects($movieArray['genres']),
            overview:       $movieArray['overview'],
            posterPath:     $movieArray['poster_path'],
            posterUrl:      $movieArray['poster_url'],
            backdropPath:   $movieArray['backdrop_path'],
            adult:          $movieArray['adult'],
            releaseDate:    $movieArray['release_date']
        );
    }

    public function mapFromGenreIdsFromArray(array $movies, array $genreMap): array
    {
        return array_map(fn ($movie) => $this->toDTOFromIds($movie, $genreMap), $movies);
    }

    /**
     * MovieSearchItemResultDTOに適した値を持つ配列を生成
     */
    private function toArray(array $movie): array
    {
        $imageBaseUrl = Config('TMDb')->imageBaseUrl;

        return [
            'id' =>             $movie['id'] ?? '',
            'title' =>          $movie['title'] ?? '',
            'original_title' => $movie['original_title'] ?? '',
            'genres' =>         $movie['genre_ids'] ?? [],
            'overview' =>       $movie['overview'] ?? '',
            'poster_path' =>    $movie['poster_path'],
            'poster_url' =>     !empty($movie['poster_path'])
                                ? "{$imageBaseUrl}/original/{$movie['poster_path']}"
                                : base_url(DEFAULT_POSTER_IMAGE),
            'backdrop_path' =>  !empty($movie['backdrop_path'])
                                ? "{$imageBaseUrl}/original/{$movie['backdrop_path']}"
                                : null,
            'adult' =>          $movie['adult'] ?? false,
            'release_date' =>   $movie['release_date'] ?? ''
        ];
    }
}