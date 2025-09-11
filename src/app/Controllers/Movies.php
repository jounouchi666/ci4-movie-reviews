<?php

namespace App\Controllers;

use App\Helpers\MovieViewHelper;
use App\Helpers\QueryHelper;
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
        
        $filters = QueryHelper::getParam($this->request);

        // バリデーション
        if (! $this->validate('movieFilter')) {
            $errors = $this->validator->getErrors();

            return view('templates/header')
                . view('movies/index', [
                    'movies' => $model->getMovies(false, $filters['order'] ?? null), // 全件取得する
                    'filters' => $filters,
                    'errors' => $errors,
                    ])
                . view('templates/footer');
        }

        // フィルターの有無に応じてレコード取得
        $movies = !empty($filters)
            ? $model->filter($filters)
            : $model->getMovies(false, $filters['order'] ?? null);

        return view('templates/header')
            . view('movies/index', [
                'movies' => $movies,
                'filters' => $filters,
                'errors' => [],
                ])
            . view('templates/footer');
    }

    
    /**
     * 詳細表示
     *
     * @param  @param int $id ID
     * @return string view
     */
    public function show($id = null): string
    {
        $model = model(MovieModel::class);
        
        $movie = $model->getMovies($id);
        if (is_null($movie)) {
            throw new PageNotFoundException('投稿がみつかりませんでした');
        }
        return view('templates/header')
            . view('movies/show', [
                'movie' => $movie,
                'filters' => QueryHelper::getParam($this->request)
                ])
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
        helper('form');
        
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
            . view('movies/edit', [
                'movie' => $movie,
                'mode' => $mode,
                'config' => MovieViewHelper::getModeConfig($mode, $movie),
                'filters' => QueryHelper::getParam($this->request)
                ])
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


        $filters = QueryHelper::getParam($this->request);
        return redirect()->to(QueryHelper::buildUrl('/movies', $filters))
                         ->with('message', '登録しました');
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

        $filters = QueryHelper::getParam($this->request);
        return redirect()->to(QueryHelper::buildUrl('/movies', $filters))
                         ->with('message', '削除しました');
    }
}
