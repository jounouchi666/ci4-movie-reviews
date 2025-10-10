<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * MovieModel
 */
class MovieModel extends Model
{
    protected $table = 'movies';
    protected $allowedFields = [
        'title',
        'user_id',
        'year',
        'genre',
        'rating',
        'review',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    

    /**
     * レコードの取得
     *
     * @param  int|false $id ID指定 or 省略で全件取得
     * @param  array|null $order ['column', 'direction']
     * @return array|null レコード
     */
    public function getMovies($id = false, $order = null): ?array
    {
        $movies = $id ? $this->find($id) : $this->findAll();

        if ($id || empty($order)) {
            return $movies;
        }

        return $this->sort($movies, $order);
    }

        
    /**
     * レコードを絞り込んで取得する
     *
     * @param  array $conditions [カラム名]
     * @return array
     */
    public function filter($conditions): array
    {
        $builder = $this->builder();
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
        
        $movies = $builder->get()->getResultArray();

        // ソートして返す
        return isset($conditions['order']) ? $this->sort($movies, $conditions['order']) : $movies;
    }

    
    /**
     * moviesをソートする
     *
     * @param  array $movies
     * @param  array $order ['column', 'direction']
     * @return array
     */
    protected function sort($movies, $order = null): array
    {
        $column = $order['column'] ?? null;
        $direction = ($order['direction'] ?? 'asc') === 'asc' ? 1 : -1;

        $allowedColumns = ['title', 'year', 'genre', 'rating']; // 許されしカラム達
        if ($column && in_array($column, $allowedColumns)) {
            usort($movies, function($a, $b) use ($column, $direction) {
                // 数値比較用
                if (in_array($column, ['year', 'rating'])) {
                    return ($a[$column] <=> $b[$column]) * $direction;
                }
                // 文字列系比較用
                return strcmp($a[$column], $b[$column]) * $direction;
            });
        }

        return $movies;
    }
}