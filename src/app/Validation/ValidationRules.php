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
        $usernameRules['rules'][] = 'required';
        $usernameRules['errors']['required'] = 'ユーザー名は必須です。';

        $emailRules = $this->config->emailValidationRules;
        $emailRules['rules'][] = 'required';
        $emailRules['errors']['required'] = 'メールアドレスは必須です。';

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
        $usernameRules = $this->getEditUsernameRules();

        $status_message = [
            'rules' => 'permit_empty|max_length[255]',
            'label' => 'ステータスメッセージ',
            'errors' => [
                'max_length' => 'ステータスメッセージは255文字以内で入力してください。',
            ]
        ];

        $icon = [
            'rules' => 'is_image[icon]|mime_in[icon,image/jpg,image/jpeg,image/png]|max_size[icon,2048]',
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
     * ユーザー名編集用のルールを返す
     */
    public function getEditUsernameRules(): array
    {
        $usernameRules = $this->config->usernameValidationRules;
        array_unshift($usernameRules['rules'], 'permit_empty');
        return ['username' => $usernameRules];
    }
}