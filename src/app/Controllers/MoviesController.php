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
        $movies = $model->getMovies();

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
    public function create($id = false): string
    {
        $model = model(MovieModel::class);
    
        if ($id === false) {
            $movie = [];
        } else {
            $movie = $model->getMovies($id);
            if (is_null($movie)) {
                throw new PageNotFoundException('投稿がみつかりませんでした');
            }
        }

        return view('templates/header')
            . view('movies/edit', ['movie' => $movie])
            . view('templates/footer');
    }


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