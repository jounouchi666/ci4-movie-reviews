<?php

namespace App\Helpers;

use App\Entities\Movie;

/**
 * MovieViewで扱う値を取得するヘルパークラス
 */
class MovieViewHelper
{    
    /**
     * モードによって値を取得する
     *
     * @param  string $mode create or edit 
     * @param  Movie $movie
     * @return array コンフィグ
     */
    public static function getModeConfig($mode, $movie = null): array
    {
        return [
            'create' => [
                'title' => '新規登録',
                'submit' => '登録',
                'back_url' => route_to('index'),
                'back_text' => '一覧に戻る'
            ],
            'edit' => [
                'title' => '編集',
                'submit' => '更新',
                'back_url' => isset($movie->id) ? route_to('show', $movie->id) : route_to('index'),
                'back_text' => '詳細に戻る'
            ],
        ][$mode];
    }
}