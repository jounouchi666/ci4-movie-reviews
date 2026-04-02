import { searchMovie } from "../api/searchMovie.js";
import LoadingSpinner from "../LoadingSpinner.js";
import ValidationHelper from "../validationHelper.js";
import Movie from "./Movie.js";

/**
 * Ajax映画検索init
 *
 * @export
 * @param {HTMLFormElement} searchFormEl 
 * @param {HTMLUListElement} resultsEl 
 * @param {HTMLElement} totalResultsEl 
 * @param {HTMLElement} paginationEl 
 * @param {HTMLElement} spinnerWrapper 
 */
export function initMovieSearch(searchFormEl, resultsEl, totalResultsEl, paginationEl, spinnerWrapper) {
    const state = {
        isLoading: false,
        loadingUse: null, 
        hasSearched: false,
        title: '',
        currentTitle: '',
        movies: [],
        page: 1,
        totalPages: 1,
        totalResults: 0,
        error: null,
        validationErrors: null
    };
    
    const spinner = new LoadingSpinner(spinnerWrapper);

    /**
     * Submit
     * 
     * @param {SubmitEvent} e 
     */
    const handleSubmit = e => {
        e.preventDefault();

        if (state.isLoading || !state.title.trim()) return;
        onSearch(state.title);
    }

    /**
     * TitleInput
     * 
     * @param {InputEvent} e 
     */
    const handleTitleInput = e => 
        state.title = e.target.value;

    /**
     * Pagination PrevButton
     * 
     * @param {InputEvent} e  
     */
    const handlePrevButton = e => {
        if (checkIsFirstPage() || state.isLoading) return;
        onPagination(state.page - 1)
    }

    /**
     * Pagination NextButton
     * 
     * @param {InputEvent} e 
     */
    const handleNextButton = e => {
        if (checkIsLastPage() || state.isLoading) return;
        onPagination(state.page + 1)
    }





    /**
     * イベントバインド
     *
     * @export
     * @param {{ 
     *  searchFormEl: HTMLFormElement,
     *  titleInputEl: InputEvent,
     *  prevButtonEl: InputEvent,
     *  nextButtonEl: InputEvent
     * }}
     */
    const bindEvent = (
        { searchFormEl, titleInputEl, prevButtonEl, nextButtonEl },
    ) => {
        searchFormEl.addEventListener('submit', handleSubmit);

        titleInputEl.addEventListener('input', handleTitleInput);

        prevButtonEl.addEventListener('click', handlePrevButton);
            
        nextButtonEl.addEventListener('click', handleNextButton);
    }

    const titleInputEl = searchFormEl.querySelector('input[name="title"]');
    const prevButtonEl = paginationEl.querySelector('.movie-search__page-prev');
    const nextButtonEl = paginationEl.querySelector('.movie-search__page-next');
    bindEvent(
        { searchFormEl, titleInputEl, prevButtonEl, nextButtonEl }
    );





    /**
     * 検索
     *
     * @async
     * @param {string} targetTitle
     */
    const onSearch = async (targetTitle) => {
        state.currentTitle = targetTitle;
        loadMovies(targetTitle, 1);
    }

    /**
     * ページネーション
     *
     * @param {number} targetPage 
     */
    const onPagination = (targetPage) => {
        if (targetPage < 1 || targetPage > state.totalPages) return;
        loadMovies(state.currentTitle, targetPage);
    }
    
    /**
     * 映画読み込み
     *
     * @async
     * @param {string} targetTitle 
     * @param {number} targetPage 
     */
    const loadMovies = async (targetTitle, targetPage) => {
        try {
            state.error = null;
            state.validationErrors = null;

            scrollTop();
            
            startLoading();

            const data = await fetchMovies(targetTitle, targetPage);

            state.hasSearched = true;
            applyMovies(data);
        } catch (e) {
            handleError(e);
        } finally {
            endLoading();
            renderResults();
        }
    }

    /**
     * 映画検索APIを呼び出す
     * @param {string} title 
     * @param {number} page 
     */
    const fetchMovies = async (title, page) => {
        return await searchMovie(title, page);
    };

    /**
     * Stateへの反映
     * @param {object} data 
     */
    const applyMovies = data => {
        state.page = data.page;
        state.movies = data.results;
        state.totalPages = data.total_pages;
        state.totalResults = data.total_results;
    };

    /**
     * エラーハンドリング
     * @param {error} e 
     */
    const handleError = e => {
        switch (e.status) {
            case 302:
            case 401:
                window.location.href = e.redirectUrl;
                break;
            case 400:
                state.validationErrors = e.data.messages;
                break;
            default:
                state.error = '読み込み失敗';
        };
    }

    /**
     * ロード開始処理
     */
    const startLoading = () => {
        state.isLoading = true;

        // 画面操作禁止化処理

        if (!state.hasSearched) {
            state.loadingUse = 'spinner';
            spinner.start();
            return;
        }

        // スケルトン開始
    }

    /**
     * ロード終了処理
     */
    const endLoading = () => {
        state.isLoading = false;

        // 画面操作許可化処理

        switch (state.loadingUse) {
            case 'spinner': 
                spinner.end();
                break;
            case 'skeleton':
                ;
                break;
            default: break;
        }
        
    }
    
    /**
     * エラーの存在確認
     *
     * @returns {boolean} 
     */
    const hasError = () => state.error !== null || state.validationErrors !== null;

    /**
     * 最初のページか確認
     *
     * @returns {boolean} 
     */
    const checkIsFirstPage = () => state.page === 1;
    
    /**
     * 最後のページか確認
     *
     * @returns {boolean} 
     */
    const checkIsLastPage = () => state.page === state.totalPages;





    /**
     * 更新結果の反映
     */
    const renderResults = () => {
        // ローディング中、またはエラーがある場合は非表示
        const showContent = !state.isLoading && !hasError();

        toggleVisibility(showContent);
        
        if (state.validationErrors) {
            renderSearchFormValidationError();
            return;
        }

        if (state.error) {
            return;
        }

        // コンテンツ描画
        updateTotalResults(state.totalResults);
        updateMovieList(state.movies);
        updatePaginationUI(state.page, state.totalPages);
    };

    
    /**
     * 検索結果のバリデーションエラー状態を描画
     */
    const renderSearchFormValidationError = () => {
        ValidationHelper.cleanValidState(titleInputEl);
        ValidationHelper.removeInvalidFeedback(titleInputEl);

        const errors = state.validationErrors?.title ?? [];
        if (!errors || errors.length === 0) {
            return;
        }
        ValidationHelper.toggleInvalid(titleInputEl);
        ValidationHelper.addInvalidFeedback(errors, titleInputEl);
    }

    /**
     * コンテンツの表示非表示切り替え
     * @param {boolean} showContent 
     */
    const toggleVisibility = showContent => {
        [totalResultsEl, resultsEl, paginationEl].forEach(el =>
            el?.classList.toggle('hidden', !showContent)
        );
    };

    /**
     * 指定したエレメント箇所にスクロール
     */
    const scrollTop = () => {
        const modalBody = document.querySelector('#movie-search-modal .modal-body');
        modalBody.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    /**
     * 検索結果の件数を更新
     *
     * @param {number} totalResultsCount
     */
    const updateTotalResults = totalResults => {
        totalResultsEl.innerText = state.hasSearched && !hasError()
            ? `検索結果：${totalResults}件`
            : '';
    };

    /**
     * 映画検索結果を更新
     *
     * @param {Object} movies
     */
    const updateMovieList = movies => {
        const movieList = movies.length === 0
            ? '<li class="list-unstyled"><p>検索結果がありません</p></li>'
            : movies.map(createMovieItem).join('');
        resultsEl.innerHTML = movieList;
    };

    const updateToSkeleton = count => {
        
    }

    /**
     * 映画アイテム生成
     * 
     * @param {object} movie 
     * @returns 
     */
    const createMovieItem = ({id, title, release_date, genre, poster_path, poster_url, overview}) => {
        const releaseYear = release_date
            ? `${release_date.slice(0, 4)}年公開`
            : '公開日未定';

        const movieInstance = new Movie(id, title, releaseYear, genre, poster_path, poster_url, overview);
        return createMovieCard(movieInstance);
    };


    const createSkeltonItem = () => {
        const movie = Movie.createSkeleton();
        return createMovieCard(movie);
    }
    
    /**
     * 映画カードを生成
     *
     * @param {{Movie}} movie
     * @returns {string} 
     */
    const createMovieCard = movie => {
        const {id, title, releaseYear, genre, posterUrl, overview } = movie.toObject();
        return `
            <li id="movie-${id}" class="p-0 card shadow-sm rounded w-100">
                <div class="card-body d-flex align-items-stretch gap-3 w-100">

                    <div class="card-thumb shrink-0">
                        <img src="${posterUrl}" alt="ポスター" class="w-100 h-100 d-block object-fit-cover" loading="lazy">
                    </div>

                    <div class="card-text w-100">

                        <div class="movie-genres mb-1">
                            ${Object.values(genre).map(g => `<span class="badge bg-primary">${g.name}</span>`).join('')}
                        </div>

                        <a
                            class="mb-0 d-inline-block text-truncate h4 card-title text-decoration-none text-body stretched-link w-100"
                            href="#movie-search-detail-modal"
                            data-bs-toggle="modal"
                        >
                            ${title}
                        </a>

                        <p class="mb-2">${releaseYear}</p>
                        
                        <p class="mb-0 d-inline-block text-truncate w-100">${overview}</p>
                    </div>
                </div>
            </li>`;
    }

    /**
     * ページネーションのUIを更新
     */
    const pagePerTotalPages = paginationEl.querySelector('.page-per-totalpages');
    const updatePaginationUI = (page, totalPages) => {
        const isFirstPage = page === 1;
        const isLastPage = page === totalPages;

        prevButtonEl.classList.toggle('disabled', isFirstPage);
        nextButtonEl.classList.toggle('disabled', isLastPage);
        prevButtonEl.querySelector('button.page-link').disabled = isFirstPage;
        nextButtonEl.querySelector('button.page-link').disabled = isLastPage;

        pagePerTotalPages.innerText = state.hasSearched && !hasError()
            ? `${page}/${totalPages}`
            : '';
    };
}