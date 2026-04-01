<?php

namespace App\Repositories\ExternalApi\Interface;

use App\DTO\MovieSearchResultDTO;

interface MovieSearchRepositoryInterface
{
    public function search(string $query, int $page): MovieSearchResultDTO;
}