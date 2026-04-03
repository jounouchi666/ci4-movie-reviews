import { createEditFormController } from "./MovieSearch/applyDetail.js";
import { initMovieSearch } from "./MovieSearch/initMovieSearch.js";
import { hideModal } from "./uiErrorController.js";

export function initEdit() {
    const movieEditForm = document.getElementById('movie-edit-form');
        
    /**
     * フォームのコントローラーを生成
     *
     * @param {HTMLFormElement} movieEditForm 
     * @returns {null|Object} 
     */
    const buildController = movieEditForm => {
        if (!movieEditForm) return null;

        const movieIdEl = movieEditForm.querySelector('input[name="movie_id"]');
        const titleEl = movieEditForm.querySelector('input[name="title"]');
        const yearEl = movieEditForm.querySelector('input[name="year"]');
        const genreEl = movieEditForm.querySelector('input[name="genre"]');

        return createEditFormController({movieIdEl, titleEl, yearEl, genreEl});
    }

    const editFormController = buildController(movieEditForm);
    const clearButton = document.querySelector('.edit__clear-form');
    if (clearButton && editFormController) {
        clearButton.addEventListener('click', editFormController.clear);
    }

    /**
     * onApplyを生成
     * 
     * @param {HTMLElement} modal 映画検索結果詳細モーダル 
     * @returns {Movie => void} onApply
     */
    const createOnApply = modal => movie => {
        editFormController.apply({
            movieId: movie.id,
            title: movie.title,
            year: movie.releaseYear ?? '',
            genre: movie.genreNames
        });
        hideModal(modal);
    }
   
    const movieSearchModal = document.getElementById('movie-search-modal');
    // 映画検索の初期化
    if (movieSearchModal) {
        const movieSearchFormEl = document.getElementById('movie-search-form');
        const movieSearchResultsWrapperEl = document.getElementById('movie-search-results');
        const movieSearchResultsEl = movieSearchResultsWrapperEl.querySelector('.movie-search__results');
        const movieSerachTotalEl = movieSearchResultsWrapperEl.querySelector('.movie-search__total');
        const movieSearchPaginationEl = document.querySelector('.movie-search__pagination');
        const movieSearchSpinnerEl = movieSearchModal.querySelector('.spinner-wrapper');
        const movieSearchDetailModal = document.getElementById('movie-search-detail-modal');

        const onApply = createOnApply(movieSearchDetailModal)

        initMovieSearch(
            movieSearchFormEl,
            movieSearchResultsEl,
            movieSerachTotalEl,
            movieSearchPaginationEl,
            movieSearchSpinnerEl,
            movieSearchDetailModal,
            onApply,
        );
    }
}