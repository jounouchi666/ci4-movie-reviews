import Movie from "./Movie.js";

/**
 * 検索結果を編集画面に反映
 *
 * @export
 * @param {HTMLFormElement} formEl 
 * @param {Movie} movie 
 */
export function applyDetail (formEl, movie) {
    const movieIdEl = formEl.querySelector('input[name="movie_id"]');
    const titleEl = formEl.querySelector('input[name="title"]');
    const yearEl = formEl.querySelector('input[name="year"]');
    const genreEl = formEl.querySelector('input[name="genre"]');
    
    const {id, title, releaseYear, genreNames} = movie;
    movieIdEl.value = id;
    titleEl.value = title;
    yearEl.value = releaseYear;
    genreEl.value = genreNames.join(',');
}