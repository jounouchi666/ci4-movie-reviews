<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\DTO\MovieSearchResultDTO;
use App\Repositories\ExternalApi\Interface\MovieSearchRepositoryInterface;
use App\Repositories\ExternalApi\TMDb\TMDbRequestExecutor;

/**
 * TMDbを使用した映画検索の実装
 */
class MovieSearchRepository implements MovieSearchRepositoryInterface
{
    public function __construct(
        private TMDbMovieSearchMapper $TMDbMovieSearchMapper,
        private MovieGenreCacheService $movieGenreCacheService,
        private TMDbRequestExecutor $tmdbRequestExecutor
    ) {}

    /**
     * search
     *
     * @param  array $query
     * @return MovieSearchResultDTO
     */
    public function search(array $query = ''): MovieSearchResultDTO
    {
        $config = Config('TMDb');

        return $this->TMDbMovieSearchMapper->toDTO(
            $this->tmdbRequestExecutor->get(
                $config->searchUrl,
                [
                    'query' => $query,
                    'language' => $config->language
                ]
            ),
            $this->movieGenreCacheService->getGenreMap()
        );
    }
}