/**
 * EditFormControllerを生成
 *
 * @param {{
 *  movieIdEl: HTMLInputElement,
 *  titleEl: HTMLInputElement,
 *  yearEl: : HTMLInputElement,
 *  genreEl: : HTMLInputElement
 * }}
 * @returns {{
 *  apply: ({ movieId, title, year, genre }) => void,
 *  clear: () => void;
 * }} 
 */
export const createEditFormController = ({movieIdEl, titleEl, yearEl, genreEl}) => {
    return {
        /**
         * フォームにデータを反映
         * @param {{
         *  movieId: number,
         *  title: string,
         *  year: number,
         *  genre: string|[string]
         * }} 
         */
        apply: ({movieId, title, year, genre}) => {
            genre = Array.isArray(genre) ? genre : [genre];

            movieIdEl.value = movieId;
            titleEl.value = title;
            yearEl.value = year;
            genreEl.value = genre.join(',');
        },
        /**
         * フォームの映画情報部分をクリア
         */
        clear: () => {
            movieIdEl.value = '';
            titleEl.value = '';
            yearEl.value = '';
            genreEl.value = '';
        }
    }
};