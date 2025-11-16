<?php

namespace App\Helpers;

/**
 * 【View用】バリデーションエラーを扱うヘルパークラス
 */
class FormValidationHelper
{    
    protected $errors;
    
    /**
     * コンストラクタ
     *
     * @param  array $errors
     */
    public function __construct(array $errors) {
        $this->errors = $errors;
    }
    
    /**
     * エラーが存在するかどうか返す
     *
     * @return bool 1つでもエラーがあればtrue
     */
    public function hasAny(): bool
    {
        return !empty($this->errors);
    }
    
    /**
     * 指定したキーがエラーかどうかを返す
     *
     * @param  string|array $key キー
     * @return bool 1つでもエラーならtrue
     */
    public function hasError(string|array $key): bool
    {
        $keys = is_array($key) ? $key : [$key];
        foreach ($keys as $k) {
            if (!empty($this->errors[$k])) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 指定したキーのエラー時用クラスを取得する
     *
     * @param  string $key キー
     * @param  string|array $default デフォルトのクラス文字列 or 配列
     * @return string クラス文字列
     */
    public function getInputClass(string $key, string|array $default = ''): string {
        // クラス名
        $ERROR_CLASS = 'is-invalid';

        // 文字列化
        $class = is_array($default) ? implode(' ', $default) : $default; 

        if ($this->hasError($key)) {
            return $class . ' ' . $ERROR_CLASS;
        }
        return $class;
    }

    /**
     * 指定したキーのエラーメッセージを取得する
     *
     * @param  string $key キー
     * @return string エラーメッセージ（エラーが無ければ空文字）
     */
    public function getErrorMessage(string $key): string
    {
        return $this->errors[$key] ?? '';
    }

    /**
     * 指定したキーのエラーメッセージをレンダリングする
     *
     * @param  string $key キー
     * @return string エラーメッセージのDOM（エラーが無ければ空文字）
     */
    public function render(string $key): string
    {
        $message = $this->getErrorMessage($key);
        return $this->hasError($key)
            ? '<div class="invalid-feedback">' . esc($message) . '</div>'
            : '';
    }

    /**
     * フォームにバリデーションエラーがあるかどうかで返す値を切り替える
     *
     * @param  string|array $then バリデーションエラーがある場合に返す値
     * @param  string|array $else バリデーションエラーがない場合に返す値。省略時は空文字
     * @return string 評価結果の文字列
     */
    public function whenHasErrors(string|array $then, string|array $else = ''): string {
        $value = $this->hasAny() ? $then : $else;
        return is_array($value) ? implode(' ', $value) : $value;
    }

    /**
     * 指定したキーの中でバリデーションエラーがあるかどうかで返す値を切り替える
     *
     * @param  string|array $key キー
     * @param  string|array $then バリデーションエラーがある場合に返す値
     * @param  string|array $else バリデーションエラーがない場合に返す値。省略時は空文字
     * @return string 評価結果の文字列
     */
    public function whenHasErrorsIn(string|array $key, string|array $then, string|array $else = ''): string {
        $value = $this->hasError($key) ? $then : $else;
        return is_array($value) ? implode(' ', $value) : $value;
    }
}