import { cleanQueryParam } from "./cleanQueryParam.js";
import { initInputNumberRange } from "./initInputNumberRange.js";
import { initToggleVisibility } from "./initToggleVisibility.js";
import { selectValueClassToggle } from "./selectValueClassToggle.js";

document.addEventListener('DOMContentLoaded', () => {
    // 表示切替ラジオボタンの初期化
    initToggleVisibility();


    // 公開年範囲指定のmin/maxを可変にする
    const date = new Date();
    const thisYear = date.getFullYear();
    const MIN_YEAR = 1900;

    const yearTypeRangeGroup = document.getElementById('year_type-range-group');
    if (yearTypeRangeGroup) {
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
    }
    

    // GETリクエスト時の空パラメータを送信しないようにする
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', cleanQueryParam);
    }


    // 評価選択セレクトボックスの色を可変に設定
    const ratingSelects = document.querySelectorAll('.rating-select');
    selectValueClassToggle(ratingSelects, 'text-warning');
})