<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $attributes = [
        'icon_path' => null,
    ];


    /**
     * プロフィール画像のURLを返す
     * NULLならデフォルトアイコン
     *
     * @return string URL
     */
    public function getIconUrl(): string
    {
        if (!empty($this->attributes['icon_path'])) {
            base_url($this->attributes['icon_path']);
        }

        return base_url('/img/default_icon.png');
    }
}