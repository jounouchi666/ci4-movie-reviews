import { applyDetail } from "./applyDetail.js";

/**
 * 映画カードを生成
 *
 * @param {string} movieSearchDetailWrapperEl
 * @param {{Movie}} movie
 * @returns {string} 
 */
export function showMovieDetail (movieSearchDetailWrapperEl, movie) {
    const detailWrapperEl = movieSearchDetailWrapperEl.querySelector('.movie-detail__detail');

    /**
     * 映画詳細を生成
     *
     * @param {Movie} movie 
     * @returns {string} 
     */
    const createMovieDetail = movie => {
        const {title, releaseYear, genreNames, posterUrl, overview} = movie;
        return `
            <h3 class="h2">${title}<span class="h3">（${releaseYear}年公開）</span></h3>

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
     * Apply処理
     */
    const handleApply = e => {
        applyDetail(movie);
    }

    detailWrapperEl.innerHTML = createMovieDetail(movie);
    const applyButton = movieSearchDetailWrapperEl.querySelector('.movie-detail__apply .apply-button');
    applyButton.addEventListener('click', handleApply);
}