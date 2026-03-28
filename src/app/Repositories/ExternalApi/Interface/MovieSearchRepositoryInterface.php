<?php

namespace App\Repositories\ExternalApi\Interface;

use App\DTO\MovieSearchResultDTO;

interface MovieSearchRepositoryInterface
{
    public function search(array $query): MovieSearchResultDTO;
}