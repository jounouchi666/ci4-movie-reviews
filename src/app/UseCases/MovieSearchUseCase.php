<?php

namespace App\UseCases;

use App\DTO\MovieSearchResultDTO;
use App\Repositories\ExternalApi\Interface\MovieSearchRepositoryInterface;

class MovieSearchUseCase
{
    public function __construct(
        private MovieSearchRepositoryInterface $movieSearchRepository
    ) {}

    public function execute(string $query, int $page = 1): MovieSearchResultDTO
    {
        return $this->movieSearchRepository->search($query, $page);
    }
}