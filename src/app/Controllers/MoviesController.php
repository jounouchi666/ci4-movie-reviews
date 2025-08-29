<?php

namespace App\Controllers;

use App\Models\MovieModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Moviesコントローラー
 */
class Movies extends BaseController
{    
    /**
     * 保存
     *
     * @return RedirectResponse リダイレクト
     */
    public function store(): RedirectResponse
    {
        // バリデーション
        if (! $this->validate('movie')) {
            $error = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('error', $error);
        };

        // 保存
        $data = $this->request->getPost();
        $model = model(MovieModel::class);
        $model->insert($data);

        return redirect()->to('/movies')->with('message', '登録しました');
    }
}