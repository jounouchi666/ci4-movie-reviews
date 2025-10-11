<?php

namespace App\Helpers;

/**
 * 【View用】認可状態を扱うヘルパークラス
 */
class ViewAuthHelper
{
    /**
     * ログイン中かどうかを返す
     *
     * @return bool ログイン中ならtrue
     */
    public static function isLogin(): bool
    {
        return auth()->loggedIn();
    }


    /**
     * ログインユーザーのものかどうかを返す
     *
     * @param  $model user_idを持つモデルインスタンス
     * @return bool ログインユーザーのものならtrue
     */
    public static function isLoginUser($model): bool
    {
        if (!self::isLogin()) {
            return false;
        }

        $userId = is_array($model) ? $model['user_id'] : $model->user_id;
        return auth()->user()->id === (int) $userId;
    }
}