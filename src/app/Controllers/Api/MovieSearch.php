<?php

namespace App\Controllers\Api;

use App\UseCases\MovieSearchUseCase;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;

/**
 * MoviesSearchコントローラー
 */
class MovieSearch extends ResourceController
{
    private MovieSearchUseCase $movieSearchUseCase;

    public function __construct()
    {
        $this->movieSearchUseCase = Services::movieSearchUseCase();
    }

    /**
     * 検索
     *
     * @return ResponseInterface
     */
    public function search(): ResponseInterface
    {
        /** @var \CodeIgniter\HTTP\IncomingRequest $request */
        $request = $this->request;
        $query = $request->getGet();

        if (!$this->validateData($query, 'searchMovies')) {
            $errors = $this->validator->getErrors();
            return $this->failValidationErrors($errors);
        }

        $data = $this->movieSearchUseCase->execute($query['title']);
        
        return $this->respond($data, 200);
    }
}
