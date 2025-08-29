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
     * 保存（新規登録/更新兼用）
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
        $model->save($data);

        return redirect()->to('/movies')->with('message', '登録しました');
    }
    
    /**
     * 削除
     *
     * @param int $id ID
     * @return RedirectResponse リダイレクト
     */
    public function delete($id): RedirectResponse
    {
        // 削除
        $model = model(MovieModel::class);
        $model->delete($id);

        return redirect()->to('/movies')->with('message', '削除しました');
    }
}