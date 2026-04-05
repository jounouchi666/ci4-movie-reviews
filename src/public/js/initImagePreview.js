import LoadingSpinner from "./LoadingSpinner.js";
import ValidationHelper from "./validationHelper.js";

/**
 * 画像ファイルをプレビューする機能を設定する関数
 * ロード中にスピナーを表示する
 *
 * @param {HTMLInputElement} input ファイルインプット
 * @param {HTMLImageElement} previewTarget 画像を展開するimgタグ
 */
export function initImagePrevieWithSpinner(input, previewTarget) {
    if (!previewTarget) return;
    
    // スピナー
    const spinnerWrapper = previewTarget.parentElement.querySelector('.spinner-wrapper');
    const spinner = new LoadingSpinner(spinnerWrapper);

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
}


/**
 * 画像ファイルをプレビューする機能を設定する関数
 *
 * @param {HTMLInputElement} input ファイルインプット
 * @param {function|null} callback {string: state, string: message} を引数にとる選択結果を通知するコールバック
 * @param {Object|null} loadingObject {start(), end()} を持つロード中オブジェクト
 */
export function initImagePreview(input, callback = null, loadingObject = null) {
    const previewEl = document.getElementById(input.dataset.previewTarget);
    if (!previewEl) {
        callback?.({
            state: 'done',
            message: 'プレビュー要素がありません'
        });
        return;
    }
    
    // 初期srcの保持
    const originalSrc = previewEl.src;

    input.addEventListener('change', () => {
        const file = input.files?.[0];

        // 未選択時
        if (!file) {
            input.classList.remove('is-invalid', 'is-valid');
            previewEl.src = originalSrc;
            callback?.({
                state: 'empty',
                message: 'ファイルが選択されていません'
            });
            return;
        }

        // 画像ファイルチェック
        const allowedTypes = ['image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            input.value = '';
            previewEl.src = originalSrc;
            callback?.({
                state: 'error',
                message: '画像ファイルを選択してください'
            });
            return;
        }

        const reader = new FileReader();
        
        // ロード開始/終了時処理
        if (loadingObject) reader.addEventListener('loadstart', () => loadingObject.start());
        if (loadingObject) reader.addEventListener('loadend', () => loadingObject.end());

        // エラー時
        reader.onerror = () => {
            previewEl.src = originalSrc;
            callback?.({
                state: 'error',
                message: 'ファイルの読み込みに失敗しました'
            });
        };

        // 成功時
        reader.onload = e => {
            previewEl.src = e.target.result;
            callback?.({
                state: 'done',
                message: 'ファイルを読み込みました'
            });
        };

        reader.readAsDataURL(file);
    });
}