<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\Repositories\ExternalApi\Interface\MovieGenreRepositoryInterface;
use App\Repositories\ExternalApi\TMDb\TMDbRequestExecutor;

class MovieGenreRepository implements MovieGenreRepositoryInterface
{
    public function __construct(
        private TMDbRequestExecutor $tmdbRequestExecutor
    ) {}

    /**
     * ジャンルマップを取得
     *
     * @return array
     */
    public function getGenre(): array
    {
        $config = Config('TMDb');
        
        $data = $this->tmdbRequestExecutor->get(
            $config->genreUrl,
            [
                'language' => $config->language
            ]
        );

        $genres = [];
        foreach ($data['genres'] as $genre) {
            $genres[$genre['id']] = $genre['name'];
        }

        return $genres;
    }
}