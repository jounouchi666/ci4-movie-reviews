<?php

namespace App\Services;

use App\DTO\MovieSearchItemResultDTO;
use App\Repositories\ExternalApi\TMDb\MovieSearchRepository;
use Config\Services;

class MovieCacheService
{
    public function __construct(
        private MovieSearchRepository $movieSearchRepository
    ) {}

    /**
     * 映画詳細を取得
     * 1時間有効のキャッシュ
     *
     * @return array
     */
    public function get(string $movieId): MovieSearchItemResultDTO
    {
        $key = 'movie_' . $movieId;

        /** @var \CodeIgniter\Cache\Handlers\BaseHandler $cache */
        $cache = Services::cache();
        return $cache->remember(
            $key,
            3600, # 1h,
            fn () => $this->movieSearchRepository->getDetails($movieId)
        );
    }

    /**
     * 映画詳細を取得
     * 1時間有効のキャッシュ
     *
     * @return array
     */
    public function save(MovieSearchItemResultDTO $movie): bool
    {
        $key = 'movie_' . $movie->id;

        $cache = Services::cache();
        return $cache->save(
            $key,
            $movie,
            3600 # 1h
        );
    }
}