/**
 * Bootstrap用のバリデーションを扱うヘルパークラス
 */
export default class ValidationHelper {
    /**
     * is-valid クラスを付与して、is-invalidを削除
     * @param {HTMLElement} el HTMLエレメント
     */
    static toggleValid(el) {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }


    /**
     * is-invalid クラスを付与して、is-validを削除
     * @param {HTMLElement} el HTMLエレメント
     */
    static toggleInvalid(el) {
        el.classList.remove('is-valid');
        el.classList.add('is-invalid');
    }


    /**
     * バリデーションメッセージ用の<div>を生成
     * @param {string} message バリデーションメッセージ
     * @return {HTMLElement} <div class="invalid-feedback">{メッセージ}</div>
     */
    static createInvalidFeedback(message) {
        const div = document.createElement('div');
        div.classList.add('invalid-feedback');
        div.innerText = message;
        return div;
    }


    /**
     * 指定要素の直後にエラーメッセージを表示
     * @param {string} message メッセージ内容
     * @param {HTMLElement} el 対象要素
     * @param {boolean} replace 既存メッセージを置き換えるか
     */
    static addInvalidFeedback(message, el, replace = true) {
        // 既存メッセージを削除する場合
        if (replace) {
            this.removeInvalidFeedback(el);
        }

        // 新しいメッセージを追加
        const newFeedback = this.createInvalidFeedback(message);
        el.after(newFeedback);
    }


    /**
     * エラーメッセージを削除する
     * @param {HTMLElement} el 対象要素
     */
    static removeInvalidFeedback(el) {
        const old = el.parentElement.querySelector('.invalid-feedback');
        if (old) old.remove();
    }
}