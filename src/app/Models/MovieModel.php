<?php

namespace App\Models;

use App\Entities\Movie;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/**
 * MovieModel
 */
class MovieModel extends Model
{
    protected $table = 'movies';
    protected $returnType = Movie::class;
    protected $allowedFields = [
        'title',
        'user_id',
        'tmdb_id',
        'year',
        'genre',
        'poster_path',
        'rating',
        'review',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    

    /**
     * レコードの単一取得
     *
     * @param  int $id ID指定
     * @return Movie|null レコード（無ければNULL）
     */
    public function getMovieById($id): ?Movie
    {
        return $this->find($id);
    }


    /**
     * レコードの全件取得
     *
     * @param  array|null $order ['column', 'direction']
     * @return Movie[]|null レコード（無ければnull）
     */
    public function getMovies($order = null): array
    {
        $builder = $this->builder();
        $this->joinUserInfo($builder);
        $movies = $builder->get()->getResult(Movie::class);

        return empty($order) ? $movies : $this->sort($movies, $order);
    }

        
    /**
     * レコードを絞り込んで取得する
     *
     * @param  array $conditions [カラム名]
     * @return Movie[]|null 絞り込み済みレコード（無ければnull）
     */
    public function filter($conditions): array
    {
        $builder = $this->builder();
        // ユーザーID
        if (!empty($conditions['user_id'])) {
            $builder->where('user_id', $conditions['user_id']);
        }

        // title
        if (!empty($conditions['title'])) {
            $builder->like('title', $conditions['title']);
        };

        // year
        if (isset($conditions['year_exact'])) {
            $builder->where('year', $conditions['year_exact']);
        } else {
            // year範囲指定
            if (isset($conditions['year_min'])) {
                $builder->where('year >=', $conditions['year_min']);
            };
            if (isset($conditions['year_max'])) {
                $builder->where('year <=', $conditions['year_max']);
            };
        };

        // genre
        if (!empty($conditions['genre'])) {
            $builder->where('genre', $conditions['genre']);
        };

        // rating
        if (isset($conditions['rating_exact'])) {
            $builder->where('rating', $conditions['rating_exact']);
        } else {
            // rating範囲指定
            if (isset($conditions['rating_min'])) {
                $builder->where('rating >=', $conditions['rating_min']);
            };
            if (isset($conditions['rating_max'])) {
                $builder->where('rating <=', $conditions['rating_max']);
            };
        };

        $this->joinUserInfo($builder);
        $movies = $builder->get()->getResult(Movie::class);

        // ソートして返す
        return isset($conditions['order']) ? $this->sort($movies, $conditions['order']) : $movies;
    }


    /**
     * 【ページネーション付き】レコードの取得
     *
     * @param  array|null $order ['column', 'direction']
     * @param int $perPage 1ページに含める件数
     * @return Movie[] レコード（ページネーション付き）
     */
    public function getMoviesPaginated($order = null, $perPage = 10): array
    {
        $movies = $this->getMovies($order);

        return  $this->paginateArray($movies, $perPage);
    }


    /**
     * 【ページネーション付き】レコードを絞り込んで取得する
     *
     * @param  array $conditions [カラム名]
     * @param int $perPage 1ページに含める件数
     * @return Movie[] 絞り込み済みレコード（ページネーション付き）
     */
    public function filterPaginated($conditions, $perPage = 10): array
    {
        $movies = $this->filter($conditions);

        return  $this->paginateArray($movies, $perPage);
    }

    
    /**
     * クエリビルダーとUserテーブルを結合する
     *
     * @param BaseBuilder $builder クエリビルダー
     * @param string|array $columns Userテーブルのカラム
     * @return BaseBuilder JOIN済みのクエリビルダー
     */
    private function joinUserInfo($builder, $columns = ['username']): BaseBuilder
    {
        $colsArray = is_array($columns) ? $columns : [$columns];
        $userCols = array_map(fn($col) => 'users.' . $col, $colsArray);

        return $builder->select('movies.*,'. implode(',', $userCols))
                       ->join('users', 'users.id = movies.user_id');
    }

    
    /**
     * moviesをソートする
     *
     * @param  movie[] $movies
     * @param  array $order ['column', 'direction']
     * @return movie[]
     */
    protected function sort($movies, $order = null): array
    {
        $column = $order['column'] ?? null;
        $direction = ($order['direction'] ?? 'asc') === 'asc' ? 1 : -1;

        $allowedColumns = ['title', 'year', 'genre', 'rating', 'updated_at']; // 許されしカラム達
        if ($column && in_array($column, $allowedColumns)) {
            usort($movies, function($a, $b) use ($column, $direction) {
                // 数値比較用
                if (in_array($column, ['year', 'rating'])) {
                    return ($a->$column <=> $b->$column) * $direction;
                }
                // 文字列系比較用
                return strcmp($a->$column, $b->$column) * $direction;
            });
        }

        return $movies;
    }


    /**
     * moviesをページネーション用に分割する
     *
     * @param  Movie[] $movies
     * @param  int $perPage 1ページに含める件数
     * @return array{movies: Movie[], pager: Pager}
     */
    protected function paginateArray($movies, $perPage = 10): array
    {
        // ページ分割
        $page = max(1, (int)service('request')->getGet('page'));
        $total = count($movies);
        $offset = ($page - 1) * $perPage;

        $dataPage = array_slice($movies, $offset, $perPage);

        // CI4のPagerと同じ仕組みでリンクを作成
        $pager = service('pager');
        $pager->setPath(uri_string());
        $pager->makeLinks($page, $perPage, $total);

        return [
            'movies' => $dataPage,
            'pager' => $pager,
        ];
    }

    
    /**
     * userIdがレコードのuser_idと一致するか確認する
     *
     * @param  int $id movieのid
     * @param  int $userId ユーザーID
     * @return bool $userId === user_idならtrue
     */
    public function ownedByUser($id, $userId): bool
    {
        $record = $this->select('id')
                       ->where('id', $id)
                       ->where('user_id', $userId)
                       ->first();
        
        return $record !== null;
    }
}