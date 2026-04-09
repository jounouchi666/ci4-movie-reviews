/**
 * 指定した要素を一定時間後にフェードアウトさせて削除する
 *
 * @param {HTMLElement} element 対象の要素
 * @param {number} duration 消えるまでの時間（ミリ秒）
 */
export function autoSlideUp(element, delay = 3000) {
    if (!element) return;
    
    setTimeout(() => {
        const height = element.scrollHeight + 'px';
        element.style.height = height;
        element.offsetHeight;

        element.classList.add('slide-up-hide');
        element.addEventListener('transitionend', () => element.remove(), {once: true});
    }, delay);
}