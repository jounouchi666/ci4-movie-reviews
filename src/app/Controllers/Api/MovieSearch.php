<?php

namespace App\Controllers\Api;

/**
 * MoviesSearchコントローラー
 */
class MovieSearch extends \App\Controllers\BaseController
{    
    /**
     * 検索
     *
     * @return string JSON
     */
    public function search()
    {
        $query = $this->request->getGet('query');
    }
}
