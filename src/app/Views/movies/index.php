<?php use App\Helpers\QueryHelper; ?>
<main>
    <div>
        <a href="<?= site_url(QueryHelper::buildUrl(route_to('create'), $filters)) ?>">新規登録</a>
    </div>

    <div class="column-contents">
        <div class="column-content">
            <table id="movies-table">
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>公開年</th>
                        <th>ジャンル</th>
                        <th>評価</th>
                        <th>レビュー</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $movie): ?>
                        <tr data-movie-id=<?= $movie['id'] ?>>
                            <td>
                                <a href="<?= site_url(QueryHelper::buildUrl(route_to('show', $movie['id']), $filters)) ?>"><?= esc($movie['title']) ?></a>
                            </td>
                            <td><?= esc($movie['year']) ?>年</td>
                            <td><?= esc($movie['genre']) ?></td>
                            <td><?= str_repeat('★', $movie['rating']) ?></td>
                            <td><?= esc($movie['review']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="column-content">
            <form id="search-form" action=<?= route_to('index') ?> method="get">

                <fieldset class="search-form-search">
                    <legend>絞り込み</legend>

                    <!-- タイトル -->
                    <div class="search-content search-title">
                        <input type="text" name="title" value="<?= esc($filters['title'] ?? '') ?>" placeholder="タイトル">
                    </div>
                    

                    <!-- 公開年 -->
                    <div class="search-content search-year_type">
                        <input id="year_type-exact" type="radio" name="year_type" value="exact" 
                            <?= !isset($filters['year_type']) || $filters['year_type'] === 'exact' ? 'checked' : '' ?>
                        >
                        <label for="year_type-exact">単一指定</label>
                        <input id="year_type-range" type="radio" name="year_type" value="range" 
                            <?= isset($filters['year_type']) && $filters['year_type'] === 'range' ? 'checked' : '' ?>
                        >
                        <label for="year_type-range">範囲指定</label>
                    </div>
                    
                    <div class="search-content search-year_exact">
                        <input type="number" name="year_exact" value="<?= esc($filters['year_exact'] ?? '') ?>" placeholder="公開年">
                    </div>

                    <div class="search-content search-year_range">
                        <input type="number" name="year_min" value="<?= esc($filters['year_min'] ?? '') ?>" placeholder="公開年（下限）">
                        <span>～</span>
                        <input type="number" name="year_max" value="<?= esc($filters['year_max'] ?? '') ?>" placeholder="公開年（上限）">
                    </div>
                    

                    <!-- ジャンル -->
                    <div class="search-content search-genre">
                        <input type="text" name="genre" value="<?= esc($filters['genre'] ?? '') ?>" placeholder="ジャンル">
                    </div>


                    <!-- 評価 -->
                    <div class="search-content search-rating-type">
                        <input id="rating_type-exact" type="radio" name="rating_type" value="exact"
                            <?= !isset($filters['rating_type']) || $filters['rating_type'] === 'exact' ? 'checked' : '' ?>
                        >
                        <label for="rating_type-exact">単一指定</label>
                        <input id="rating_type-range" type="radio" name="rating_type" value="range"
                            <?= isset($filters['rating_type']) && $filters['rating_type'] === 'range' ? 'checked' : '' ?>
                        >
                        <label for="rating_type-range">範囲指定</label>
                    </div>
                    
                    <div class="search-content search-rating_exact">
                        <select name="rating_exact">
                            <option value="">-- 評価 --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_exact']) && $filters['rating_exact'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                    
                    <div class="search-content search-rating_range">
                        <select name="rating_min">
                            <option value="">-- 評価（下限） --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_min']) && $filters['rating_min'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>
                        <span>～</span>
                        <select name="rating_max">
                            <option value="">-- 評価（上限） --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_max']) && $filters['rating_max'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </fieldset>
                
                               
                <fieldset class="search-form-sort">
                    <legend>並べ替え</legend>

                    <div class="sort-content">
                        <select name="order[column]">
                            <option value="title" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'title' ? 'selected' : '' ?>>タイトル</option>
                            <option value="year" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'year' ? 'selected' : '' ?>>公開年</option>
                            <option value="genre" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'genre' ? 'selected' : '' ?>>ジャンル</option>
                            <option value="rating" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'rating' ? 'selected' : '' ?>>評価</option>
                        </select>

                        <select name="order[direction]">
                            <option value="asc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'asc' ? 'selected' : '' ?>>昇順</option>
                            <option value="desc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'desc' ? 'selected' : '' ?>>降順</option>
                        </select>
                    </div>
                </fieldset>
                

                <fieldset class="search-form-nav">
                    <input type="submit" value="検索">
                    <a class="button" href=<?= route_to('index') ?>>クリア</a>
                </fieldset>
            </form>
        </div>
    </div>
</main>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }
    h1 {
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .rating {
        font-weight: bold;
    }

    .column-contents {
        display: flex;
        gap: 16px;
    }
</style>