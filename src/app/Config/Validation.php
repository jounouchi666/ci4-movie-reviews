<?php

namespace Config;

use App\Validation\CustomRules;
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
        'title' => 'required|min_length[1]|max_length[255]',
        'year' => 'required|integer|greater_than_equal_to[1900]',
        'genre' => 'required|max_length[100]',
        'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'review' => 'permit_empty|max_length[2000]',
    ];

    // フィルター用
    public $movieFilter = [
        'title' => 'permit_empty|max_length[255]',
        'year_exact' => 'permit_empty|integer|greater_than_equal_to[1900]',
        'year_min' => 'permit_empty|integer|greater_than_equal_to[1900]|checkRange[year_max]',
        'year_max' => 'permit_empty|integer|greater_than_equal_to[1900]',
        'genre' => 'permit_empty|max_length[100]',
        'rating_exact' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'rating_min' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]|checkRange[rating_max]',
        'rating_max' => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
    ];

    // ユーザープロフィール
    public $userProfile = [
        'status_message' => 'permit_empty|max_length[255]',
        'icon' => 'is_image[icon]|mime_in[icon,image/jpg,image/jpeg,image/png]|max_size[icon,2048]',
    ];

    // --------------------------------------------------------------------
    // カスタムメッセージ
    // --------------------------------------------------------------------

    // editフォームなど
    public $movie_errors = [
        'title' => [
            'required' => 'タイトルは必須です。',
            'min_length' => 'タイトルは1文字以上で入力してください。',
            'max_length' => 'タイトルは255文字以内で入力してください。',
        ],
        'year' => [
            'required' => '公開年は必須です。',
            'integer' => '公開年は数字で入力してください。',
            'greater_than_equal_to' => '公開年は1900年以降である必要があります。',
        ],
        'genre' => [
            'required' => 'ジャンルは必須です。',
            'max_length' => 'ジャンルは100文字以内で入力してください。',
        ],
        'rating' => [
            'required' => '評価を選択してください（★1～5）。',
            'greater_than_equal_to' => '評価は★1以上で入力してください。',
            'less_than_equal_to' => '評価は★5以下で入力してください。',
        ],
        'review' => [
            'max_length' => 'レビューは2000文字以内で入力してください。',
        ],
    ];

    // フィルター用
    public $movieFilter_errors = [
        'title' => [
            'max_length' => 'タイトルは255文字以内で入力してください。',
        ],
        'year_exact' => [
            'integer' => '公開年は数字で入力してください。',
            'greater_than_equal_to' => '公開年は1900年以降である必要があります。',
        ],
        'year_min' => [
            'integer' => '公開年は数字で入力してください。',
            'greater_than_equal_to' => '公開年の最小値は1900年以降である必要があります。',
            'checkRange' => '公開年の最小値は最大値以下である必要があります。',
        ],
        'year_max' => [
            'integer' => '公開年は数字で入力してください。',
            'greater_than_equal_to' => '公開年の最大値は1900年以降である必要があります。',
        ],
        'genre' => [
            'max_length' => 'ジャンルは100文字以内で入力してください。',
        ],
        'rating_exact' => [
            'integer' => '評価は★1～5で入力してください。',
            'greater_than_equal_to' => '評価は★1以上で入力してください。',
            'less_than_equal_to' => '評価は★5以下で入力してください。',
        ],
        'rating_min' => [
            'integer' => '評価は★1～5で入力してください。',
            'greater_than_equal_to' => '評価の最小値は★1以上で入力してください。',
            'less_than_equal_to' => '評価の最小値は★5以下で入力してください。',
            'checkRange' => '評価の最小値は最大値以下である必要があります。',
        ],
        'rating_max' => [
            'integer' => '評価は★1～5で入力してください。',
            'greater_than_equal_to' => '評価の最大値は★1以上で入力してください。',
            'less_than_equal_to' => '評価の最大値は★5以下で入力してください。',
        ]
    ];

    // ユーザープロフィール
    public $userProfile_errors = [
        'status_message' => [
            'max_length[255]' => 'ステータスメッセージは255文字以内で入力してください。',
        ],
        'icon' => [
            'is_image' => 'アップロードされたファイルは画像ではありません',
            'mime_in' => 'JPGまたはPNG形式の画像をアップロードしてください',
            'max_size' => '画像サイズは2MB以下にしてください',
        ],
    ];
}