<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // 管理者ユーザー
        $admin = new User([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'password',
        ]);
        $userModel->save($admin);
        $admin = $userModel->findById($userModel->getInsertID());
        $admin->addGroup('admin');

        // 一般ユーザー
        for ($i = 1; $i <= 5; $i++) {
            $user = new User([
                'username' => "user{$i}",
                'email'    => "user{$i}@example.com",
                'password' => 'password',
            ]);

            $userModel->save($user);
            $newUser = $userModel->findById($userModel->getInsertID());
            $newUser->addGroup('user');
        }
    }
}