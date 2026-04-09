// URL
const BASE_URL = document.getElementById('api-config').dataset.url;
export const SEARCH_URL = '/api/movie/search';

const headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-API-Version': '1.0'
};

/**
 * APIClientを構築
 *
 * @param {string} baseUrl - APIサーバーのURL
 * @param {object} [defaultHeaders] - デフォルトのヘッダー
 *
 * @returns {{get: function}} - クライアントが提供するメソッド
 */
const createClient = (baseUrl, defaultHeaders = {}) => {
    /**
     * URLを構築
     *
     * @param {string} path - パス
     * @param {object} [query] - クエリパラメータ
 *
     * @returns {string} - 作成したURL
     */
    const buildUrl = (path, query) =>
        !query || Object.keys(query).length === 0
            ? `${baseUrl}${path}`
            : `${baseUrl}${path}?${new URLSearchParams(query).toString()}`;

    /**
     * APIの呼び出し
     *
     * @param {string} path - パス
     * @param {{ method: string, query: object, headers: object, body: object }} options - オプション
 *
     * @returns {Promise<object>} - API呼び出しの結果
     */
    const request = async (path, { method = 'GET', query, headers, body, ...rest } = {}) => {
        const url = buildUrl(path, query);

        const res = await fetch(url, {
            method,
            headers: {
                ...defaultHeaders,
                ...headers
            },
            body: body ? JSON.stringify(body) : undefined,
            ...rest
        });

        // ログイン画面へのリダイレクト
        if (res.redirected) {
            throw {
                status: 302,
                message: 'Redirecct detected',
                redurectUrl: res.url
            };
        }

        let data;
        try {
            data = await res.json();
        } catch {
            data = null;
        }
        
        if (!res.ok) {
            throw {
                status: res.status,
                message: res.statusText,
                data
            };
        }

        return data;
    }

    return {
        get: (path, options) => request(path, { ...options, method: 'GET' })
    };
}

export const apiClient = createClient(BASE_URL, headers);