<?php

namespace Config;

use \CodeIgniter\Config\BaseConfig;

class TMDb extends BaseConfig
{
    // APIToken
    public $apiToken = '';

    // Config
    public $timeout = 5;
    public $language = 'ja-JP';

    // URL
    public $baseUrl = 'https://api.themoviedb.org/3';
    public $searchUrl = '';
    public $movieDetailsUrl = '';
    public $genreUrl = '';
    public $imageBaseUrl = 'http://image.tmdb.org/t/p';

    public function __construct()
    {
        parent::__construct();

        $this->apiToken = env('TMDb.api_token') ?? $this->apiToken;

        $this->searchUrl = $this->baseUrl . '/search/movie';
        $this->genreUrl = $this->baseUrl . '/genre/movie/list';
        $this->movieDetailsUrl = $this->baseUrl . '/movie';
    }
}