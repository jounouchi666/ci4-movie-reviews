<?php

namespace App\Helpers;

/**
 * クエリパラメータを扱うヘルパークラス
 */
class QueryHelper
{    
    /**
     * クエリパラメータを取得する
     *
     * @param  Request $request フォームリクエスト
     * @param  array $keys 取得したい値のキー
     * @return array 取得したパラメータの配列
     */
    public static function getParam($request, $keys = []): array
    {
        return $request->getGet($keys);
    }

    
    /**
     * ルートにクエリパラメータを付与する
     *
     * @param  string $route ルート
     * @param  array $params 付与するパラメータ
     * @return string クエリパラメータを付与したルート
     */
    public static function buildUrl($route, $params = []): string
    {
        return $params ? $route . '?' . http_build_query($params) : $route;
    }
}