<?php

namespace App\Validation;

class CustomRules
{
    /**
     * min < max をチェックする
     *
     * @param string $value 入力値（min側）
     * @param string $params 比較対象カラム名 (max側)
     * @param array  $data フォーム全体の値
     * @return bool
     */
    public function checkRange($value, $params, $data): bool
    {
        if (empty($value) || empty($data[$params])) return true;
        return (int)$value <= (int)$data[$params];
    }
}