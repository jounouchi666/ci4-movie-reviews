<?php

namespace App\Helpers;

use Config\Validation;

/**
 * 【Controller用】既存ルールにフィールド単位で追加ルール・エラーメッセージを付与して返す
 */
class DynamicValidationHelper
{
    /**
     * 既存ルールにフィールド単位で追加ルール・エラーメッセージを付与して返す
     *
     * @param string $group 既存のValidationルールグループ名（例: 'movie'）
     * @param array $fieldRules ['field名' => '追加ルール文字列']
     * @param array $fieldErrors ['field名' => ['ルール名' => 'メッセージ']]
     * @return array [$rules, $errors]
     */
    public static function buildRules(string $group, array $fieldRule = [], array $fieldErrors = []): array
    {
        $config = config(Validation::class);

        $rules = $config->{$group} ?? [];
        $errors = $config->{$group . '_errors'} ?? [];

        // 追加ルールのマージ
        foreach ($fieldRule as $field => $rule) {
            if (isset($rules[$field])) {
                $rules[$field] .= '|' . $rule;
            } else {
                $rules[$field] = $rule;
            }
        }

        // エラーメッセージのマージ
        foreach ($fieldErrors as $field => $error) {
            if (!isset($errors[$field])) {
                $errors[$field] = [];
            }
            $errors[$field] = array_merge($errors[$field], $error);
        }

        return [$rules, $errors];
    }

    /**
     * 「>=今年」を表すルール文字列を返す
     *
     * @return string 例：less_than_equal_to[2025]
     */
    public static function lteThisYearRule(): string
    {
        return 'less_than_equal_to[' . date('Y') . ']';
    }

    /**
     * lteThisYearRule()に対応するメッセージを返す
     *
     * @param string $fieldLabel フィールドの名称
     * @return array 例：['less_than_equal_to' => '公開年の最大値は2025年以下で入力してください。']
     */
    public static function lteThisYearMessage($fieldLabel): array
    {
        return ['less_than_equal_to' => $fieldLabel . 'の最大値は' . date('Y') . '年以下で入力してください。'];
    }
}