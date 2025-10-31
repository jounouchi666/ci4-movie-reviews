/**
 * 要素の上にオーバーフロー表示するローディングスピナーを扱うクラス
 */
export default class OverflowSpinner {
    #wrapper;
    #spinner;

    /**
     * 
     * @param {HTMLElement} wrapper スピナーを内包する要素（.spinner-wrapper）
     */
    constructor(wrapper) {
        this.#wrapper = wrapper;
        this.#spinner = this.#wrapper.querySelector('.spinner-border');
        this.#spinner.style.display = 'none';
    };

    
    /**
     * スピナー表示開始
     */
    start() {
        this.#wrapper.querySelectorAll(':not(.spinner-border)').forEach(el => el.style.opacity = 0.5);
        if (this.#spinner) this.#spinner.style.display = 'inline-block';
    }


    /**
     * スピナー表示終了
     */
    end() {
        this.#wrapper.querySelectorAll(':not(.spinner-border)').forEach(el => el.style.opacity = 1);
        if (this.#spinner) this.#spinner.style.display = 'none'
    }
};