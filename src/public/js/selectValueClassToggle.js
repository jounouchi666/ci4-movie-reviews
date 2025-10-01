/**
 * <select> の値に応じてクラスを付与・削除する
 *
 * @param {HTMLSelectElement|NodeList|HTMLElement[]} elements - 対象の select 要素
 * @param {string|string[]} className - 付与するクラス（複数可）
 * @param {function(string): boolean} [isActive] - true を返したときだけクラス付与（デフォルト: value !== ''）
 */
export function selectValueClassToggle(elements, className, isActive = value => value !== '') {
    const classes = Array.isArray(className) ? className : [className];
    const iteratorElements = elements instanceof Element ? [elements] : Array.from(elements);

    function toggleClass(el) {
        if (isActive(el.value)) {
            el.classList.add(...classes);
        } else {
            el.classList.remove(...classes);
        }
    }

    iteratorElements.forEach(element => {
        // 初期状態に反映
        toggleClass(element);

        // イベント付与
        element.addEventListener('change', () => toggleClass(element));
    })
}