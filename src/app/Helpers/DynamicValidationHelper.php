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
                if (is_array($rules[$field]) && isset($rules[$field]['rules'])) { // 配列形式のルール
                    $rules[$field]['rules'] .= '|' . $rule;
                } elseif (is_string($rule[$field])) { // 文字列形式のルール
                    $rules[$field] .= '|' . $rule;
                } else {
                    $rules[$field] = [ // 例外：配列形式のルールだがrulesがないなど
                        'rules' => $rule,
                    ];
                }
            } else {
                $rule[$field] = $rule;
            }
        }

        // エラーメッセージのマージ
        foreach ($fieldErrors as $field => $error) {
            // _errors定義用
            if (!isset($errors[$field])) {
                $errors[$field] = [];
            }
            $errors[$field] = array_merge($errors[$field], $error);

            // rules配列のerrors用
            if (isset($rules[$field])) {
                if (!isset($rules[$field]['errors'])) {
                    $rules[$field]['errors'] = [];
                }
                $rules[$field]['errors'] = array_merge($rules[$field]['errors'], $error);
            }
        }

        return [$rules, $errors];
    }
    
    /**
     * ルールの取得
     *
     * @param  string $group 既存のValidationルールグループ名（例: 'movie'）
     * @return array
     */
    public static function getRules(string $group): array
    {
        $config = config(Validation::class);

        $rules = $config->{$group} ?? [];
        $errors = $config->{$group . '_errors'} ?? [];

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