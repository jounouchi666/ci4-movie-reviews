<?php

namespace App\Controllers;

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
        $userModel = model(UserModel::class);
        $user = $userModel->find($userId);

        if (is_null($user)) {
            throw new PageNotFoundException('ユーザーがみつかりませんでした');
        }

        $movieModel = model(MovieModel::class);
        $perPage = 12;
        $movies = $movieModel->getMoviesPaginated($perPage); // 仮で全件

        return view('myPage/index', [
            'user' => $user,
            'mode' => $mode,
            'movies' => $movies['movies'],
            'pager' => $movies['pager'],
        ]);
    }
}