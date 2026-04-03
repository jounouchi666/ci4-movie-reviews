/**
 * 映画詳細を生成し表示
 *
 * @param {HTMLElement} movieSearchDetailModalEl
 * @param {{Movie}} movie
 * @param {movie => void} onApply
 */
export function showMovieDetail (movieSearchDetailModalEl, movie, onApply) {
    const detailModalEl = movieSearchDetailModalEl.querySelector('.movie-detail__detail');

    /**
     * 映画詳細を生成
     *
     * @param {Movie} movie 
     * @returns {string} 
     */
    const createMovieDetail = movie => {
        const {title, releaseYearString, genreNames, posterUrl, overview} = movie;
        return `
            <h3 class="h2">${title}<span class="h3">（${releaseYearString}）</span></h3>

            <div class="movie-genres h5">
                ${genreNames.map(genre => `<span class="badge bg-primary">${genre}</span>`).join('')}
            </div>

            <div class="mt-2">
                <img src="${posterUrl}" alt="${title}のポスター" class="poster-image" loading="lazy">
            </div>

            <div class="mt-3">
                <h4 class="h4">あらすじ</h4>
                <p class="mb-0 d-inline-block w-100">${overview}</p>
            </div>`
    }

    /**
     * Applyイベントハンドラ
     */
    const handleApply = e => {
        onApply(movie);
    }

    detailModalEl.innerHTML = createMovieDetail(movie);
    const applyButton = movieSearchDetailModalEl.querySelector('.movie-detail__apply .apply-button');
    applyButton.addEventListener('click', handleApply);
}