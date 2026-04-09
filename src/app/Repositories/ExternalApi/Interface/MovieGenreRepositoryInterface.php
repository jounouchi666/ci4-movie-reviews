<?php

namespace App\Repositories\ExternalApi\Interface;

interface MovieGenreRepositoryInterface
{
    /**
     * ジャンルマップを取得
     *
     * @return array
     */
    public function getGenre(): array;
}