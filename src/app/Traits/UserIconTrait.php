<?php

namespace App\Traits;

/**
 * ユーザーアイコン関連の共通機能
 */
trait UserIconTrait
{
    // サムネイルサイズ
    protected const THUMB_SIZES = [120, 100];

    // ユーザーアイコンのディレクトリ
    protected const ICON_DIR = FCPATH . USER_ICON_DIR;

    /**
     * リサイズファイル名を取得する
     *
     * @param string $fileName ファイル名
     * @param int|string $width リサイズファイルの横幅
     * @return string ファイル名
     */
    protected function getResizedFileName($fileName, $width): string
    {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $base = pathinfo($fileName, PATHINFO_FILENAME);
        return $base . '_' . $width . '.' . $ext;
    }
}