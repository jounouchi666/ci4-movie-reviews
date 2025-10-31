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