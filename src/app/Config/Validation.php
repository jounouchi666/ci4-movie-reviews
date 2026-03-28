<?php

namespace Config;

use App\Validation\CustomRules;
use App\Validation\ValidationRules;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    // editフォームなど（moviesテーブルへのsave時に使用）
    public $movie = [
        'title' => [
            'rules' => 'required|min_length[1]|max_length[255]',
            'label' => 'タイトル',
            'errors' => [
                'required'   => 'タイトルは必須です。',
                'min_length' => 'タイトルは1文字以上で入力してください。',
                'max_length' => 'タイトルは255文字以内で入力してください。',
            ],
        ],
        'year' => [
            'rules' => 'required|integer|greater_than_equal_to[1900]',
            'label' => '公開年',
            'errors' => [
                'required'               => '公開年は必須です。',
                'integer'                => '公開年は数字で入力してください。',
                'greater_than_equal_to'  => '公開年は1900年以降である必要があります。',
            ],
        ],
        'genre' => [
            'rules' => 'required|max_length[100]',
            'label' => 'ジャンル',
            'errors' => [
                'required'   => 'ジャンルは必須です。',
                'max_length' => 'ジャンルは100文字以内で入力してください。',
            ],
        ],
        'rating' => [
            'rules' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'label' => '評価',
            'errors' => [
                'required'              => '評価を選択してください（★1～5）。',
                'integer'               => '評価は数値で入力してください。',
                'greater_than_equal_to' => '評価は★1以上で入力してください。',
                'less_than_equal_to'    => '評価は★5以下で入力してください。',
            ],
        ],
        'review' => [
            'rules' => 'permit_empty|max_length[2000]',
            'label' => 'レビュー',
            'errors' => [
                'max_length' => 'レビューは2000文字以内で入力してください。',
            ],
        ],
    ];

    // フィルター用
    public $movieFilter = [
        'title' => [
            'rules' => 'permit_empty|max_length[255]',
            'label' => 'タイトル',
            'errors' => [
                'max_length' => 'タイトルは255文字以内で入力してください。',
            ],
        ],
        'year_exact' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1900]',
            'label' => '公開年（指定）',
            'errors' => [
                'integer'               => '公開年は数字で入力してください。',
                'greater_than_equal_to' => '公開年は1900年以降である必要があります。',
            ],
        ],
        'year_min' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1900]|checkRange[year_max]',
            'label' => '公開年（最小）',
            'errors' => [
                'integer'               => '公開年は数字で入力してください。',
                'greater_than_equal_to' => '公開年の最小値は1900年以降である必要があります。',
                'checkRange'            => '公開年の最小値は最大値以下である必要があります。',
            ],
        ],
        'year_max' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1900]',
            'label' => '公開年（最大）',
            'errors' => [
                'integer'               => '公開年は数字で入力してください。',
                'greater_than_equal_to' => '公開年の最大値は1900年以降である必要があります。',
            ],
        ],
        'genre' => [
            'rules' => 'permit_empty|max_length[100]',
            'label' => 'ジャンル',
            'errors' => [
                'max_length' => 'ジャンルは100文字以内で入力してください。',
            ],
        ],
        'rating_exact' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'label' => '評価（指定）',
            'errors' => [
                'integer'               => '評価は★1～5で入力してください。',
                'greater_than_equal_to' => '評価は★1以上で入力してください。',
                'less_than_equal_to'    => '評価は★5以下で入力してください。',
            ],
        ],
        'rating_min' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]|checkRange[rating_max]',
            'label' => '評価（最小）',
            'errors' => [
                'integer'               => '評価は★1～5で入力してください。',
                'greater_than_equal_to' => '評価の最小値は★1以上で入力してください。',
                'less_than_equal_to'    => '評価の最小値は★5以下で入力してください。',
                'checkRange'            => '評価の最小値は最大値以下である必要があります。',
            ],
        ],
        'rating_max' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'label' => '評価（最大）',
            'errors' => [
                'integer'               => '評価は★1～5で入力してください。',
                'greater_than_equal_to' => '評価の最大値は★1以上で入力してください。',
                'less_than_equal_to'    => '評価の最大値は★5以下で入力してください。',
            ],
        ],
    ];

    // 映画検索用
    public $searchMovies = [
        'title' => [
            'rules' => 'required|min_length[1]|max_length[255]',
            'label' => 'タイトル',
            'errors' => [
                'required'   => 'タイトルは必須です。',
                'min_length' => 'タイトルは1文字以上で入力してください。',
                'max_length' => 'タイトルは255文字以内で入力してください。',
            ],
        ],
    ];
}