<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $attributes = [
        'icon_path' => null,
    ];
}