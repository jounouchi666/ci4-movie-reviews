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
    const controller = {
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
            controller.unlock();
            [movieIdEl, titleEl, yearEl, genreEl].forEach(el => el.value = '');

        },
        /**
         * 操作不可にする
         */
        lock: () => {
            [movieIdEl, titleEl, yearEl, genreEl].forEach(el => el.disabled = true);
        },
        /**
         * 操作可にする
         */
        unlock: () => {
            [movieIdEl, titleEl, yearEl, genreEl].forEach(el => el.disabled = false);
        }
    }

    return controller;
};