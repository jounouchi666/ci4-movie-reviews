<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegisterController;
use App\Validation\ValidationRules;

/**
 * Shield標準コントローラーの拡張
 */
class RegisterController extends ShieldRegisterController
{
    /**
     * App\Validation\ValidationRulesを使用するようにオーバーライド
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }
}