/**
 * エラーフラグを持っていたらモーダルを開く
 * @param {HTMLElement} modal
 */
export function openModalByError(modal) {
    whenHasError(modal, openModal, modal);
}


/**
 * エラーフラグを持っていたらタブを開く
 * @param {HTMLElement} navTabs
 */
export function selectTabWithError(navTabs) {
    navTabs.querySelectorAll('.nav-item .nav-link').forEach(triggerEl => {
        whenHasError(triggerEl, selectTab, triggerEl);
    });
}


/**
 * エラーフラグを持っていたらリストグループを開く
 * @param {HTMLElement} listGroup
 */
export function selectListGroupWithError(listGroup) {
    listGroup.querySelectorAll('.list-group-item').forEach(triggerEl => {
        whenHasError(triggerEl, selectTab, triggerEl);
    });
}


/**
 * モーダルを開く
 * @param {HTMLElement} modal 
 */
export function openModal(modal) {
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}


/**
 * タブを開く
 * @param {HTMLElement} triggerEl
 */
export function selectTab(triggerEl) {
    const bsTabTrigger = new bootstrap.Tab(triggerEl);
    bsTabTrigger.show();
}


/**
 * モーダルを閉じる
 * @param {HTMLElement} modal 
 */
export function hideModal(modal) {
    const bsModal = bootstrap.Modal.getInstance(modal);
    bsModal.hide();
}


/**
 * エラーフラグを持っていたらコールバックを実行する
 * @param {HTMLElement} trigger data-has-error属性を持つトリガー
 * @param {function} callback エラー時に実行するコールバック
 * @param {...any} args コールバックに渡す引数
 */
export function whenHasError(trigger, callback, ...args) {
    const hasError = trigger.dataset.hasError === 'true'; // データ属性が文字列で来るので注意
    if (hasError) { 
        callback(...args);
    }
}