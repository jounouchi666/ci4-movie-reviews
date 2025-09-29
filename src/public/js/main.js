import { initInputNumberRange } from "./initInputNumberRange.js";
import { initToggleVisibility } from "./initToggleVisibility.js";

document.addEventListener('DOMContentLoaded', () => {
    // 表示切替ラジオボタンの初期化
    initToggleVisibility();


    // 公開年範囲指定のmin/maxを可変にする
    const date = new Date();
    const thisYear = date.getFullYear();
    const MIN_YEAR = 1900;

    const yearTypeRangeGroup = document.getElementById('year_type-range-group');
    const yearMinInput = yearTypeRangeGroup.querySelector('.range-min');
    const yearMaxInput = yearTypeRangeGroup.querySelector('.range-max');
    
    initInputNumberRange(yearMinInput, yearMaxInput, MIN_YEAR, thisYear);

    //ページロード時に現在値を反映
    if (yearMinInput !== '') {
        yearMinInput.dispatchEvent(new Event('input'));
    }
    if (yearMaxInput !== '') {
        yearMaxInput.dispatchEvent(new Event('input'));
    }
})