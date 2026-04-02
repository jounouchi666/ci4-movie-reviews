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
            [
                '<span class="placeholder col-2 me-1"></span>',
                '<span class="placeholder col-3 me-1"></span>',
                '<span class="placeholder col-2"></span>'
            ],
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
     * オブジェクトとして出力
     */
    toObject() {
        return {
            id: this.#id,
            title: this.#title,
            releaseYear: this.#releaseYear,
            genre: this.#genre,
            posterPath: this.#posterPath,
            posterUrl: this.#posterUrl,
            overview: this.#overview,
            isSkeleton: this.#isSkeleton
        };
    }
}

export default Movie;