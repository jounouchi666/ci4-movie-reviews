<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        // ====大量データ用 ※日本語非対応====
        // $NUMBER_OF_RECORDS = 50;
        // $faker = Factory::create('ja_JP');

        // $data = [];
        // for ($i = 0; $i < $NUMBER_OF_RECORDS; $i++) {
        //     $data[] = [
        //         'user_id' => $faker->numberBetween(1, 5),
        //         'title' => $faker->words(3, true),
        //         'year' => $faker->numberBetween(1900, 2025),
        //         'genre' => $faker->word,
        //         'rating' => $faker->numberBetween(1, 5),
        //         'review' => $faker->text(50)
        //     ];
        // }

        // ====日本語データ====
        $data = [
            [
                "user_id" => 1,
                "tmdb_id" => 27205,
                "title" => "インセプション",
                "year" => 2010,
                "genre" => "SF",
                "poster_path" => "qzb0slJerd5bQgJxteJ5oAmfp09.jpg",
                "rating" => 5,
                "review" => "複雑なストーリーだが映像と音楽が圧倒的。何度も観たくなる。"
            ],
            [
                "user_id" => 1,
                "tmdb_id" => 372058,
                "title" => "君の名は。",
                "year" => 2016,
                "genre" => "アニメーション / ロマンス",
                "poster_path" => "yLglTwyFOUZt5fNKm0PWL1PK5gm.jpg",
                "rating" => 4,
                "review" => "映像美と音楽が素晴らしい。ややご都合主義に感じる部分も。"
            ],
            [
                "user_id" => 2,
                "tmdb_id" => 278,
                "title" => "ショーシャンクの空に",
                "year" => 1994,
                "genre" => "ドラマ",
                "poster_path" => "xQY1yhixcSSfKRhdlhzwN8Mra6q.jpg",
                "rating" => 5,
                "review" => "感動の名作。最後の爽快感が最高。"
            ],
            [
                "user_id" => 2,
                "tmdb_id" => 329,
                "title" => "ジュラシック・パーク",
                "year" => 1993,
                "genre" => "アドベンチャー / SF",
                "poster_path" => "1pKyHaQjzhBJk5qMCO0ATrRlXJr.jpg",
                "rating" => 4,
                "review" => "迫力ある恐竜描写に圧倒される。ストーリーはシンプル。"
            ],
            [
                "user_id" => 3,
                "tmdb_id" => 597,
                "title" => "タイタニック",
                "year" => 1997,
                "genre" => "ロマンス / ドラマ",
                "poster_path" => "ofhCnW6i7mQIiLSSucBHqZQ7XT7.jpg",
                "rating" => 5,
                "review" => "壮大なスケールと切ない物語。何度観ても泣ける。"
            ],
            [
                "user_id" => 3,
                "tmdb_id" => 2671,
                "title" => "リング",
                "year" => 1998,
                "genre" => "ホラー",
                "poster_path" => "6KWX8jRZHtfXLGGViKAcUW41ZXs.jpg",
                "rating" => 3,
                "review" => "雰囲気は怖いが展開がやや古臭く感じる。"
            ],
            [
                "user_id" => 4,
                "tmdb_id" => 24428,
                "title" => "アベンジャーズ",
                "year" => 2012,
                "genre" => "アクション / ヒーロー",
                "poster_path" => "l1SWn7SdwvAowNfC4ojV2B9LDgs.jpg",
                "rating" => 4,
                "review" => "ヒーロー集合のワクワク感が最高。ストーリーは浅め。"
            ],
            [
                "user_id" => 4,
                "tmdb_id" => 129,
                "title" => "千と千尋の神隠し",
                "year" => 2001,
                "genre" => "アニメーション / ファンタジー",
                "poster_path" => "8TEs6twIANAc2qiU8m17JO8Ujcx.jpg",
                "rating" => 5,
                "review" => "独特の世界観とキャラクターに引き込まれる。ジブリの最高傑作。"
            ],
            [
                "user_id" => 5,
                "tmdb_id" => 475557,
                "title" => "ジョーカー",
                "year" => 2019,
                "genre" => "サスペンス / ドラマ",
                "poster_path" => "j9ArCk5Za4Hw32WnRtiCPtmDcxZ.jpg",
                "rating" => 4,
                "review" => "重苦しいが演技が圧倒的。観た後に考えさせられる作品。"
            ],
            [
                "user_id" => 5,
                "tmdb_id" => 9799,
                "title" => "ワイルド・スピード",
                "year" => 2001,
                "genre" => "アクション",
                "poster_path" => "bJKAddC1NEpBiCgFsI3qMc8rZly.jpg",
                "rating" => 3,
                "review" => "カーアクションは爽快だが、内容は薄い。"
            ]
        ];

        // 開発用：テーブル初期化
        $this->db->table('movies')->truncate();

        $this->db->table('movies')->insertBatch($data);
    }
}