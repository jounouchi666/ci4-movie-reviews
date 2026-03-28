<?php

namespace Config;

use App\Repositories\ExternalApi\Interface\MovieClientInterface;
use App\Repositories\ExternalApi\Interface\MovieGenreRepositoryInterface;
use App\Repositories\ExternalApi\Interface\MovieSearchRepositoryInterface;
use App\Repositories\ExternalApi\TMDb\MovieGenreCacheService;
use App\Repositories\ExternalApi\TMDb\MovieGenreRepository;
use App\Repositories\ExternalApi\TMDb\MovieSearchRepository;
use App\Repositories\ExternalApi\TMDb\TMDbClient;
use App\Repositories\ExternalApi\TMDb\TMDbMovieSearchMapper;
use App\Repositories\ExternalApi\TMDb\TMDbRequestExecutor;
use App\UseCases\MovieSearchUseCase;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

        
    /**
     * movieClient
     * 映画取得API接続用クライアント
     *
     * @param  bool $getShared
     * @return MovieClientInterface
     */
    public static function movieClient($getShared = true): MovieClientInterface
    {
        if ($getShared) {
            return static::getSharedInstance('movieClient');
        }

        return new TMDbClient();
    }

    /**
     * tmdbRequestExecutor
     * TMDbリクエスト実行モジュール
     *
     * @param  bool $getShared
     * @return TMDbRequestExecutor
     */
    public static function tmdbRequestExecutor($getShared = true): TMDbRequestExecutor
    {
        if ($getShared) {
            return static::getSharedInstance('tmdbRequestExecutor');
        }

        return new TMDbRequestExecutor(
            static::movieClient()
        );
    }

    /**
     * movieGenreCacheService
     * 映画ジャンルキャッシュサービス
     *
     * @param  bool $getShared
     * @return MovieGenreCacheService
     */
    public static function movieGenreCacheService($getShared = true): MovieGenreCacheService
    {
        if ($getShared) {
            return static::getSharedInstance('movieGenreCacheService');
        }

        return new MovieGenreCacheService(
            static::movieGenreRepository()
        );
    }
    
    /**
     * tmdbMovieSearchMapper
     * 返却用DTOを組み立てるサービス
     *
     * @param  bool $getShared
     * @return TMDbMovieSearchMapper
     */
    public static function tmdbMovieSearchMapper($getShared = true): TMDbMovieSearchMapper
    {
        if ($getShared) {
            return static::getSharedInstance('tmdbMovieSearchMapper');
        }

        return new TMDbMovieSearchMapper();
    }

    /**
     * movieGenreRepository
     * 映画ジャンル用リポジトリ―
     *
     * @param  bool $getShared
     * @return MovieGenreRepositoryInterface
     */
    public static function movieGenreRepository($getShared = true): MovieGenreRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('movieGenreRepository');
        }

        return new MovieGenreRepository(
            static::tmdbRequestExecutor()
        );
    }

    /**
     * movieSearchRepository
     * 映画検索用リポジトリ―
     *
     * @param  bool $getShared
     * @return MovieSearchRepositoryInterface
     */
    public static function movieSearchRepository($getShared = true): MovieSearchRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('movieSearchRepository');
        }

        return new MovieSearchRepository(
            static::tmdbMovieSearchMapper(),
            static::movieGenreCacheService(),
            static::tmdbRequestExecutor()
        );
    }
    
    /**
     * movieSearchUseCase
     *
     * @param  bool $getShared
     * @return MovieSearchUseCase
     */
    public static function movieSearchUseCase($getShared = true): MovieSearchUseCase
    {
        if ($getShared) {
            return static::getSharedInstance('movieSearchUseCase');
        }
        
        return new MovieSearchUseCase(
            static::movieSearchRepository()
        );
    }
}
