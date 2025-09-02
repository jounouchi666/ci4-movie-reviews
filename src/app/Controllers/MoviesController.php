<?php

namespace App\Controllers;

use App\Models\MovieModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Moviesコントローラー
 */
class Movies extends BaseController
{    
    /**
     * 一覧表示
     *
     * @return string view
     */
    public function index(): string
    {
        $model = model(MovieModel::class);
        
        $filter = $this->request->getGet();
        if (!empty($filter)) {
            $movies = $model->filter($filter);
        } else {
            $movies = $model->getMovies();
        }

        return view('templates/header')
            . view('movies/index', ['movies' => $movies])
            . view('templates/footer');
    }

    /**
     * 新規登録/編集画面
     * 
     * @param int|false $id レビューID（省略で新規登録表示）
     * @return string view
     */
    public function edit($id = null): string
    {
        $model = model(MovieModel::class);
    
        if ($id) {
            $movie = $model->getMovies($id);
            if (is_null($movie)) {
                throw new PageNotFoundException('投稿がみつかりませんでした');
            }
            $mode = 'edit';
        } else {
            $movie = null;
            $mode = 'create';
        }

        return view('templates/header')
            . view('movies/edit', ['movie' => $movie, 'mode' => $mode])
            . view('templates/footer');
    }


    /**
     * 保存（新規登録/更新兼用）
     *
     * @return RedirectResponse リダイレクト
     */
    public function save(): RedirectResponse
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