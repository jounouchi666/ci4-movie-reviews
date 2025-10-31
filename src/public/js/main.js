import { autoSlideUp } from "./autoSlideUp.js";
import { cleanQueryParam } from "./cleanQueryParam.js";
import { formSubmitToggler } from "./FormSubmitToggler.js";
import { initImagePreview } from "./initImagePreview.js";
import { initInputNumberRange } from "./initInputNumberRange.js";
import { initToggleVisibility } from "./initToggleVisibility.js";
import OverflowSpinner from "./OverflowSpinner.js";
import { selectValueClassToggle } from "./selectValueClassToggle.js";
import ValidationHelper from "./validationHelper.js";

document.addEventListener('DOMContentLoaded', () => {
    // フラッシュメッセージの自動フェードアウト
    const flashSuccess = document.querySelectorAll('.flash-success');
    flashSuccess.forEach(el => autoSlideUp(el));


    // フォーム内のsubmitボタンの活性/非活性化
    const forms = Array.from(document.getElementsByTagName('form'));
    if (forms) {
        forms.forEach(form => formSubmitToggler(form));
    }


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


    // 画像ファイルのプレビュー機能
    document.querySelectorAll('.image-preview').forEach(input => {
        const previewTarget = document.getElementById(input.dataset.previewTarget);
        console.log(previewTarget);
        if (!previewTarget) return;

        // スピナー
        const spinnerWrapper = previewTarget.closest('.spinner-wrapper');
        const spinner = new OverflowSpinner(spinnerWrapper);

        initImagePreview(
            input,
            loadingResult => {
                if (loadingResult.state === 'error') {
                    ValidationHelper.toggleInvalid(input);
                    ValidationHelper.addInvalidFeedback(loadingResult.message, input);
                } else if (loadingResult.state === 'done') {
                    ValidationHelper.toggleValid(input);
                    ValidationHelper.removeInvalidFeedback(input);
                }
            },
            spinner
        );
    });
})