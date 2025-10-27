<?php

namespace App\Entities;

use App\Traits\UserIconTrait;
use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    use UserIconTrait;

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
        $path = $this->attributes['icon_path'] ?? null;
        if (!empty($path)) {
            return base_url(USER_ICON_DIR . $path);
        }

        return base_url(DEFAULT_USER_ICON_PATH);
    }


    /**
     * プロフィール画像（サムネイルサイズ）のURLを返す
     * NULLならデフォルトアイコン
     *
     * @param int|string $width リサイズファイルの横幅
     * @return string URL
     */
    public function getThumbUrl($width = null): string
    {
        // サムネイルを取得
        $fileName = $this->attributes['icon_path'] ?? null;
        if (!is_null($width)&& !empty($fileName)) {
            $thumbFile = $this->getResizedFileName($fileName, $width);
            if (file_exists(self::ICON_DIR . $thumbFile)) {
                return base_url(USER_ICON_DIR . $thumbFile);
            }
        }

        return $this->getIconUrl();
    }


    /**
     * 登録済みのサムネイルURL一覧を返す
     *
     * @return array [width => URL]
     */
    public function getThumbUrls(): array
    {
        $urls = [];
        foreach (self::THUMB_SIZES as $size) {
            $urls[$size] = $this->getThumbUrl($size);
        }
        return $urls;
    }
}