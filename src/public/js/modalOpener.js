/**
 * モーダルを開く
 * @param {HTMLElement} modal 
 */
export function openModal(modal) {
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}


/**
 * エラーフラグを持っていたらモーダルを開く
 * @param {HTMLElement} modal 
 */
export function openModalByError(modal) {
    const hasError = modal.dataset.hasError === 'true'; // データ属性が文字列で来るので注意
    if (hasError) {
        openModal(modal);
    }
}