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
     * @return array|null レコード
     */
    public function getMovies($id = false): ?array
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->find($id);
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
        
        // ソート
        $allowedColumns = ['title', 'year', 'genre', 'rating']; // 許されしカラム達
        if (!empty($conditions['order']) && in_array($conditions['order']['column'], $allowedColumns)) {
            $builder->orderBy(
                $conditions['order']['column'],
                strtoupper($conditions['order']['direction']) ?? 'ASC'
            );
        }

        return $builder->get()->getResultArray();
    }
    
    /**
     * データを保存する
     *
     * @param  array $data 保存するデータ
     * @return bool 成功/失敗をboolで返す
     */
    public function store($data): bool
    {
        return $this->save([
            'title' => $data['title'],
            'year' => $data['year'],
            'genre' => $data['genre'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);
    }
    
    /**
     * データを更新する
     *
     * @param  int $id
     * @param  array $data 保存するデータ
     * @return bool 成功/失敗をboolで返す
     */
    public function updateMovie($id, $data): bool
    {
        return $this->update($id, [
            'title' => $data['title'],
            'year' => $data['year'],
            'genre' => $data['genre'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);
    }

    /**
     * データを削除する
     *
     * @param  int|array $id
     * @return bool 成功/失敗をboolで返す
     */
    public function deleteMovie($id): bool
    {
        return $this->delete($id);
    }
}