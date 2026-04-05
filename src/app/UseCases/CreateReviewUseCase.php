<?php

namespace App\UseCases;

use App\Exceptions\MovieNotFoundException;
use App\Exceptions\NoPermissionException;
use App\Models\MovieModel;
use App\Services\MovieCacheService;

class CreateReviewUseCase
{
    public function __construct(
        private MovieCacheService $movieCacheService
    ) {}

    public function execute(array $data)
    {
        $id = $data['id'] ?? null;
        $movieId = $data['movie_id'];
        $userId = user_id();

        $saveData = [
            'user_id' => $userId,
            'rating' => $data['rating'],
            'review' => $data['review']
        ];
        !is_null($id) ?: $saveData['id'] = $id;

        if ($movieId) {
            /** @var \App\DTO\MovieSearchItemResultDTO $movie */
            $movie = $this->movieCacheService->get($movieId);
            if (!$movie) {
                throw new MovieNotFoundException($movieId);
            }

            $saveData['tmdb_id'] = $movieId;
            $saveData['title'] = $movie->title;
            $saveData['year'] = substr($movie->releaseDate, 0, 4);
            $saveData['genre'] = implode(',', array_map(fn($g) => $g->name, $movie->genre));
            $saveData['poster_path'] = $movie->posterPath;
        } else {
            $saveData['title'] = $data['title'];
            $saveData['year'] = $data['year'];
            $saveData['genre'] = $data['genre'];
        }

        $model = model(MovieModel::class);

        if (!empty($id) && ! $model->ownedByUser($id, $userId)) {
            throw new NoPermissionException('権限がありません');
        }

        // 保存
        $model->save($saveData);
    }
}