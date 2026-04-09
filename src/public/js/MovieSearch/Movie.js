class Movie
{
    #id;
    #title = '';
    #releaseYear;
    #genre = [];
    #posterPath = null;
    #posterUrl;
    #overview = null;

    #isSkeleton = false;

    constructor (id, title, releaseYear, genre, posterPath, posterUrl, overview) {
        this.#id = id;
        this.#title = title;
        this.#releaseYear = releaseYear;
        this.#genre = genre;
        this.#posterPath = posterPath;
        this.#posterUrl = posterUrl;
        this.#overview = overview;
    }

    /**
     * 検索結果のオブジェクトから生成
     * 
     * @param {{id, title, release_date, genre, poster_path, poster_url, overview}} movie 
     */
    static fromSearchResponse({id, title, release_date, genre, poster_path, poster_url, overview}) {
        const releaseYear = release_date
            ? release_date.slice(0, 4)
            : null;

        return new this(id, title, releaseYear, genre, poster_path, poster_url, overview);
    }
    
    /**
     * スケルトン用のファクトリー
     *
     * @static
     * @returns {Movie} 
     */
    static createSkeleton() {
        const instance = new this(
            null,
            '<span class="placeholder col-8"></span>',
            '<span class="placeholder col-3"></span>',
            {
                0: '<span class="placeholder col-2 me-1"></span>',
                1: '<span class="placeholder col-3 me-1"></span>',
                2: '<span class="placeholder col-2"></span>'
            },
            null,
            '',
            '<span class="placeholder col-10"></span><span class="placeholder col-9"></span>'
        );

        instance.#isSkeleton = true;

        return instance;
    }

    /**
     * Getter
     */
    get id() {return this.#id}
    get title() {return this.#title}
    get releaseYear() {return this.#releaseYear}
    get genre() {return this.#genre}
    get posterPath(){return this.#posterPath}
    get posterUrl() {return this.#posterUrl}
    get overview() {return this.#overview}
    get isSkeleton() {return this.#isSkeleton}
    
    
    /**
     * 公開年を文字列で出力
     */
    get releaseYearString() {
        return this.releaseYear ? `${this.releaseYear}年公開` : '公開日未定';
    }

    /**
     * ジャンル名の配列を出力
     */
    get genreNames() {
        return Object.values(this.#genre).map(g => g.name);
    }
}

export default Movie;