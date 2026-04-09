/**
 * フォーム内のsubmitボタンの活性/非活性化をトグルする
 *
 * @param {HTMLFormElement} form フォーム
 */
export function formSubmitToggler(form) {
    const submit = form.querySelector('[type="submit"]');
    if (!submit) return;

    function toggle() {
        if (form.checkValidity()) {
            submit.removeAttribute('disabled');
        } else {
            submit.setAttribute('disabled', true);
        }
    }

    // イベントを仕込む
    form.addEventListener('input', toggle);
    form.addEventListener('change', toggle);
    // 初期状態の表示を反映
    toggle();
}