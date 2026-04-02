class DangerAlert
{
    #message = '';

    #alert = null;

    #icon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
        </svg>`

    constructor(message) {
        this.#message = message;
        this.alert = this.#createElement(this.#message);
    }

    /**
     * アラートDOMを生成
     */
    #createElement(message) {
        const wrapperEl = document.createElement('div');
        wrapperEl.classList.add('alert', 'alert-danger', 'w-100', 'd-flex', 'align-items-center');

        const messageEl = document.createElement('div');
        messageEl.innerText = message;

        wrapperEl.insertAdjacentHTML('afterbegin', this.#icon);
        wrapperEl.append(messageEl);
        
        return wrapperEl;
    }

    /**
     * 指定した要素の下にアラートを表示
     *
     * @param {HTMLElement} parentEl 
     */
    show(parentEl) {
        parentEl.append(this.#alert);
    }

    /** 
     * 生成したアラートを削除
     */
    remove() { 
        if (this.#alert === null) return;

        this.#alert.remove()
        this.#alert = null;
    }
}