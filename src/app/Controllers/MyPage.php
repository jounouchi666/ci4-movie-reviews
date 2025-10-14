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
        return $this->renderUserPage($currentUser->id);
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
     * @param  @param int $userId ユーザーID
     * @return string view
     */
    private function renderUserPage($userId)
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
            'movies' => $movies['movies'],
            'pager' => $movies['pager'],
        ]);
    }
}