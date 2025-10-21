<?php

namespace App\Controllers;

use App\Helpers\QueryHelper;
use App\Models\MovieModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Shield\Models\UserModel;

class MyPage extends BaseController
{
    /**
     * ログインユーザーのユーザーページ
     *
     * @return string view
     */
    public function index()
    {
        $currentUser = auth()->user();
        return $this->renderUserPage($currentUser->id, 'auth');
    }


    /**
     * 他ユーザーのユーザーページ
     *
     * @return string view
     */
    public function show($userId)
    {
        return $this->renderUserPage($userId);
    }


    /**
     * ユーザーページをレンダリングする
     *
     * @param  int $userId ユーザーID
     * @param  string $mode 
     * @return string view
     */
    private function renderUserPage($userId, $mode = 'show')
    {
        helper('form');

        $userModel = model(UserModel::class);
        $user = $userModel->find($userId);

        if (is_null($user)) {
            throw new PageNotFoundException('ユーザーがみつかりませんでした');
        }

        $filters = QueryHelper::getParam($this->request);
        $filters['user_id'] = $userId;
        $filters['order'] ?? $filters['order'] = ['column' => 'updated_at', 'direction' => 'desc'];
        
        $movieModel = model(MovieModel::class);
        $perPage = 12;
        $movies = $movieModel->filterPaginated($filters, $perPage);

        return view('myPage/index', [
            'user' => $user,
            'mode' => $mode,
            'filters' => $filters,
            'movies' => $movies['movies'],
            'pager' => $movies['pager'],
        ]);
    }
}