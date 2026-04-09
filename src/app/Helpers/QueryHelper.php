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
    public static function getParam($request, $keys = null): array
    {
        // 全て取得
        if (is_Null($keys)) {
            // 空白のパラメータは除去
            return array_filter($request->getGet(), function($param) {
                return $param !== '';
            });
        }
        
        // 指定したものを全て取得
        $params = [];
        foreach ($keys as $key) {
            $params[$key] = $request->getGet($key);
        }
        return $params;
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