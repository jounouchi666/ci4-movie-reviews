<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieSearchItemResultDTO;
use App\DTO\MovieSearchResultDTO;
use App\Repositories\ExternalApi\Interface\MovieSearchRepositoryInterface;
use App\Repositories\ExternalApi\TMDb\TMDbRequestExecutor;

/**
 * TMDbを使用した映画検索の実装
 */
class MovieSearchRepository implements MovieSearchRepositoryInterface
{
    public function __construct(
        private TMDbMovieSearchMapper $tmdbMovieSearchMapper,
        private TMDbMovieSearchItemMapper $tmdbMovieSearchItemMapper,
        private MovieGenreCacheService $movieGenreCacheService,
        private TMDbRequestExecutor $tmdbRequestExecutor
    ) {}

    /**
     * search
     *
     * @param  array $query
     * @return MovieSearchResultDTO
     */
    public function search(string $query = '', int $page = 1): MovieSearchResultDTO
    {
        $config = Config('TMDb');

        return $this->tmdbMovieSearchMapper->toDTO(
            $this->tmdbRequestExecutor->get(
                $config->searchUrl,
                [
                    'query' => $query,
                    'page' => $page,
                    'language' => $config->language
                ]
            ),
            $this->movieGenreCacheService->getGenreMap()
        );
    }

    public function getDetails(string $movieId): MovieSearchItemResultDTO
    {
        $config = Config('TMDb');

        return $this->tmdbMovieSearchItemMapper->toDTOFromObjects(
            $this->tmdbRequestExecutor->get(
                "{$config->movieDetailsUrl}/{$movieId}",
                [
                    'language' => $config->language
                ]
            )
        );
    }
}