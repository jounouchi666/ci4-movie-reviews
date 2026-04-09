<?php

namespace App\Helpers;

/**
 * 【View用】日付表記の文字列を扱うヘルパークラス
 */
class ViewDateHelper
{
    /**
     * 月の文字列表記配列を返す
     *
     * @return array 月一覧
     */
    public static function getMonthStrings(): array
    {
        return [
            'short' => [
                1  => 'Jan',
                2  => 'Feb',
                3  => 'Mar',
                4  => 'Apr',
                5  => 'May',
                6  => 'Jun',
                7  => 'Jul',
                8  => 'Aug',
                9  => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec',
            ],
            'full' => [
                1  => 'January',
                2  => 'February',
                3  => 'March',
                4  => 'April',
                5  => 'May',
                6  => 'June',
                7  => 'July',
                8  => 'August',
                9  => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December',
            ]
        ];
    }


    /**
     * 日付をUS表記に変換する
     *
     * @param int $timestamp UNIXタイムスタンプ
     * @param string $mode 'short' or 'full' getMonthStrings()の配列準拠
     * @return string US表記の日付
     */
    public static function toStringUS($timestamp, $mode = 'short'): string
    {
        $year = date('Y', $timestamp);
        $month = date('n', $timestamp);
        $day = date('j', $timestamp);

        // 月の英語表記化
        $monthStrings = self::getMonthStrings();
        $mode = in_array($mode, $monthStrings) ? $mode : 'short';
        $monthEN = $monthStrings[$mode][$month];

        return "{$monthEN} {$day}, {$year}";
    }
}