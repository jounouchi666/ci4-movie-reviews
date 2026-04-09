<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\Exceptions\TMDbApiException;
use App\Repositories\ExternalApi\Interface\MovieClientInterface;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class TMDbRequestExecutor
{
    public function __construct(
        private MovieClientInterface $movieClient
    ) {}

    /**
     * GETリクエスト実行
     * エラーハンドリング付きラッパー
     *
     * @param  string $url
     * @return array
     */
    public function get(string $url, array $query = []): array
    {
        try {
            return $this->movieClient->get($url, $query);
        } catch (HTTPException $e) {
            throw new TMDbApiException(
                "TMDb API Error: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}