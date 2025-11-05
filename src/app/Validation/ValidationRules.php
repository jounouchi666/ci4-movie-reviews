<?php

namespace App\Validation;

use CodeIgniter\Shield\Validation\ValidationRules as ShieldValidationRules;

/**
 * Shield標準ルールの拡張
 */
class ValidationRules extends ShieldValidationRules
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * register用のルールを返す
     */
    public function getRegistrationRules(): array
    {
        $setting = setting('Validation.registration');
        if ($setting !== null) {
            return $setting;
        }

        $usernameRules = $this->config->usernameValidationRules;

        $emailRules = $this->config->emailValidationRules;
        $emailRules['rules'][] = sprintf(
            'is_unique[%s.secret]',
            $this->tables['identities'],
        );

        $passwordRules = $this->getPasswordRules();
        $passwordRules['rules'][] = 'strong_password[]';

        return [
            'username'         => $usernameRules,
            'email'            => $emailRules,
            'password'         => $passwordRules,
            'password_confirm' => $this->getPasswordConfirmRules(),
        ];
    }

    /**
     * プロフィール編集用のルールを返す
     */
    public function getEditProfileRules(): array
    {
        $usernameRules = [
            'username' => $this->getPermitEmpty($this->config->usernameValidationRules),
        ];

        $status_message = [
            'rules' => [
                'permit_empty',
                'max_length[255]',
            ],
            'label' => 'ステータスメッセージ',
            'errors' => [
                'max_length' => 'ステータスメッセージは255文字以内で入力してください。',
            ]
        ];

        $icon = [
            'rules' => [
                'permit_empty',
                'is_image[icon]',
                'mime_in[icon,image/jpg,image/jpeg,image/png]',
                'max_size[icon,2048]',
            ],
            'label' => 'アイコン',
            'errors' =>  [
                'is_image' => 'アップロードされたファイルは画像ではありません',
                'mime_in' => 'JPGまたはPNG形式の画像をアップロードしてください',
                'max_size' => '画像サイズは2MB以下にしてください',
            ],
        ];

        return [
            ...$usernameRules,
            'status_message'    => $status_message,
            'icon'              => $icon,
        ];
    }


    /**
     * 編集用のルールを返す
     * 必須入力を空白許可に変更する
     */
    public function getPermitEmpty($baseRule): array
    {
        // 空白許可化
        $rules = array_filter($baseRule['rules'], fn($rule) => $rule !== 'required');
        array_unshift($rules, 'permit_empty');
        
        return [
            ...$baseRule,
            'rules' => $rules,
        ];
    }
}