<?php

namespace App\Entities;

use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

class Movie extends Entity
{
    protected $attributes = [
        'id' => null,
        'tmdb_id' => null,
        'user_id' => null,
        'title' => null,
        'year' => null,
        'genre' => null,
        'poster_path' => null,
        'rating' => null,
        'review' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $datamap = [];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];


    /**
     * ポスターのパスを返す
     * 登録されていなければデフォルトイメージを返す
     * 
     * @return string
     */
    public function getPosterPath(): string {
        $imageBaseUrl = Config('TMDb')->imageBaseUrl;
        return "{$imageBaseUrl}/original/{$this->attributes['poster_path']}" ?? base_url(DEFAULT_POSTER_IMAGE);
    }


    /**
     * 関連するUserEntityを返す
     *
     * @return \App\Entities\User|null
     */
    public function getUser(): ?User
    {
        if (!$this->hasUserId()) {
            return null;
        }

        $userModel = model(UserModel::class);
        return $userModel->find($this->attributes['user_id']);
    }


    /**
     * 関連するUserのusernameを返す
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        $user = $this->getUser();

        return $user->username;
    }


    /**
     * 関連するUserのicon_pathを返す
     *
     * @return string|null
     */
    public function getIconPath(): ?string
    {
        $user = $this->getUser();

        return $user?->getIconUrl();
    }


    /**
     * userIdの有無を返す
     *
     * @return bool 存在すればtrue
     */
    private function hasUserId(): bool
    {
        if (empty($this->attributes['user_id'])) {
            return false;
        }
        return true;
    }
}