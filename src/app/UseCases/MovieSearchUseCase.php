<?php

namespace App\UseCases;

use App\DTO\MovieSearchResultDTO;
use App\Repositories\ExternalApi\Interface\MovieSearchRepositoryInterface;
use App\Services\MovieCacheService;

class MovieSearchUseCase
{
    public function __construct(
        private MovieSearchRepositoryInterface $movieSearchRepository,
        private MovieCacheService $movieCacheService
    ) {}

    public function execute(string $query, int $page = 1): MovieSearchResultDTO
    {
        $movieSearchResult = $this->movieSearchRepository->search($query, $page);

        // キャッシュに保存
        foreach ($movieSearchResult->results as $result) {
            $this->movieCacheService->save($result);
        }

        return $movieSearchResult;
    }
}