<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use App\Entities\User;

/**
 * UserModel（ShieldのUserModelの拡張）
 */
class UserModel extends ShieldUserModel
{
    protected $returnType = User::class;

    protected $allowedFields = ['icon_path'];

    public function __construct()
    {
        parent::__construct();

        // 継承元のallowedFieldsをマージ
        $parentFields = get_class_vars(get_parent_class($this))['allowedFields'];
        $this->allowedFields = array_merge($parentFields, $this->allowedFields);
    }
}