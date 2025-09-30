/**
 * GETリクエスト時の空パラメータを送信しないようにする
 *
 * @param {SubmitEvent} e フォーム送信イベント
 */
export function cleanQueryParam(e) {
    e.preventDefault();

    const form = e.currentTarget;

    const formData = new FormData(form);
    const params = new URLSearchParams();

    // 値が空のパラメータを削除
    for (const [key, value] of formData.entries()) {
        const input = form.querySelector(`[name='${CSS.escape(key)}']`);
        if (!input) continue;

        if (input.type === 'radio' && input.classList.contains('toggle-input')) {
            if (hasValueToggleVisibilityRadio(key)) {
                params.append(key, value);
            }
        } else {
            if (value !== '') {
                params.append(key, value);
            }
        }
    }

    const action = form.getAttribute('action') || location.pathname;
    const queryStr = params.toString();

    window.location.href = action + (queryStr ? '?' + queryStr : '');
}


/**
 * 指定されたnameを持つ .toggle-input ラジオが選択されていて、
 * そのターゲットに入力値がある場合のみ true を返す
 *
 * @param {string} key ラジオのname
 * @returns {boolean}
 */
function hasValueToggleVisibilityRadio(key) {
    const checked = document.querySelectorAll(`.toggle-input[name='${CSS.escape(key)}']:checked`);
    if (checked.length === 0) return false;

    return Array.from(checked).some(radio => {
        if (!radio.dataset.toggleTarget) return false;

        const targets = document.querySelectorAll(radio.dataset.toggleTarget);
        return Array.from(targets).some(hasValueInTarget);
    })
}


/**
 * 対象要素内に値が入っているか判定
 *
 * @param {HTMLElement} target
 * @returns {boolean}
 */
function hasValueInTarget(target) {   
    return (
        // input
        Array.from(target.getElementsByTagName('input')).some(input =>
            (['text', 'number'].includes(input.type) && input.value.trim() !== '') ||
            (['checkbox', 'radio'].includes(input.type) && input.checked)
        ) ||

        // textarea
        Array.from(target.getElementsByTagName('textarea')).some(textarea => textarea.value.trim() !== '') ||

        // セレクトボックス
        Array.from(target.getElementsByTagName('select')).some(select => select.value !== '')
    );
}