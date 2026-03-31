import { apiClient, SEARCH_URL } from "./apiClient.js";

/**
 * 映画を検索
 * @param {string} title - 検索したい映画のタイトル
 * @param {number} [page=1] - 検索結果の一覧ページ番号
 * @returns {Promise<object>} 検索結果
 */
const createSearchMovie = url => async (title, page = 1) => {
    const query = {
        title,
        page
    }
    return await apiClient.get(url, { query });
}

export const searchMovie = createSearchMovie(SEARCH_URL);