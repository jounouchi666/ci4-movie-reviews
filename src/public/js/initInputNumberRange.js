/**
 * min/max 入力を連動させる
 * @param {HTMLInputElement} minInput - 最小値入力
 * @param {HTMLInputElement} maxInput - 最大値入力
 * @param {number|null} absMin - 絶対的な最小値（nullなら制限なし）
 * @param {number|null} absMax - 絶対的な最大値（nullなら制限なし）
 */
export function initInputNumberRange(minInput, maxInput, absMin = null, absMax = null) {
    minInput.addEventListener('input', function() {
        // absMin < min < absMaxとして更新
        const tempMin = this.value !== '' ? Number(this.value) : absMin ?? -Infinity;
        const effectiveMin = absMax !== null ? Math.min(tempMin, absMax) : tempMin;
        maxInput.min = effectiveMin;
    })
    maxInput.addEventListener('input', function() {
        // absMin < max < absMaxとして更新
        const tempMax = this.value !== '' ? Number(this.value) : absMax ?? Infinity;
        const effectiveMax = absMin !== null ? Math.max(tempMax, absMin) : tempMax;
        minInput.max = effectiveMax;
    })
}