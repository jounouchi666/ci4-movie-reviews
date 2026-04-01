
/**
 * ローディングスピナーを扱うクラス
 */
export default class LoadingSpinner {
    #wrapper;
    #spinner;

    /**
     * 
     * @param {HTMLElement} wrapper スピナーを内包する要素（.spinner-wrapper）
     */
    constructor(wrapper) {
        this.#wrapper = wrapper;
        this.#spinner = this.#wrapper.querySelector('.spinner-border');
        this.end();
    };

    
    /**
     * スピナー表示開始
     */
    start() {
        if (this.#wrapper) this.#wrapper.classList.remove('d-none');
    }


    /**
     * スピナー表示終了
     */
    end() {
        if (this.#wrapper) this.#wrapper.classList.add('d-none');
    }
};