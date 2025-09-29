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
        if (value !== '') params.append(key, value);
    }

    const action = form.getAttribute('action') || location.pathname;
    const queryStr = params.toString();

    window.location.href = action + (queryStr ? '?' + queryStr : '');
}