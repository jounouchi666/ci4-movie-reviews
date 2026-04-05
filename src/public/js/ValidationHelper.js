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
     * is-invalid、is-validクラスを削除
     * @param {HTMLElement} el HTMLエレメント
     */
    static cleanValidState(el) {
        el.classList.remove('is-valid', 'is-invalid');
    }


    /**
     * バリデーションメッセージ用の<ul>を生成
     * @param {string|array} messages バリデーションメッセージ
     * @return {HTMLElement} <ul class="invalid-feedback"><li>{メッセージ}<li></ul>
     */
    static createInvalidFeedback(messages) {
        messages = Array.isArray(messages) ? messages : [messages];
        const ul = document.createElement('ul');
        ul.classList.add('invalid-feedback', 'list-unstyled');
        messages.forEach(message => {
            const li = document.createElement('li');
            li.innerText = message;
            ul.append(li);
        })
        return ul;
    }


    /**
     * 指定要素の兄弟の末尾にエラーメッセージを表示
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
        el.parentElement.append(newFeedback);
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