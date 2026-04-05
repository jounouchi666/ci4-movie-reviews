<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\Repositories\ExternalApi\Interface\MovieGenreRepositoryInterface;
use Config\Services;

class MovieGenreCacheService
{
    public function __construct(
        private MovieGenreRepositoryInterface $movieGenreRepository
    ) {}

    /**
     * ジャンルマップを取得
     * 24時間有効のキャッシュ
     *
     * @return array
     */
    public function getGenreMap(): array
    {
        $key = 'tmdb_genre_' . config('TMDb')->language ?? 'ja_JP';

        /** @var \CodeIgniter\Cache\Handlers\BaseHandler $cache */
        $cache = Services::cache();
        return $cache->remember(
            $key,
            86400, # 24h,
            fn () => $this->movieGenreRepository->getGenre()
        );
    }
}