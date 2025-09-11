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
        'genre' => 'required',
        'rating' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[5]',
        'review' => 'permit_empty|max_length[2000]',
    ];

    // フィルター用
    public $movieFilter = [
        'title' => 'permit_empty|max_length[255]',
        'year_exact' => 'permit_empty|integer|greater_than_equal_to[1900]',
        'year_min' => 'permit_empty|integer|greater_than_equal_to[1900]|checkRange[year_max]',
        'year_max' => 'permit_empty|integer|greater_than_equal_to[1900]',
        'genre' => 'permit_empty|max_length[100]',
        'rating_exact' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[5]',
        'rating_min' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[5]|checkRange[rating_max]',
        'rating_max' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[5]',
    ];
}