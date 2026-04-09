<?php

namespace App\Repositories\ExternalApi\Interface;

interface MovieClientInterface
{
    /**
     * GETリクエスト実行
     *
     * @param  string $url
     * @return array
     */
    public function get(string $url, array $query = []): array;
}