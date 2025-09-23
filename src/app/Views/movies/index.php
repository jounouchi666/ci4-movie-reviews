<?php
    use App\Helpers\QueryHelper;
    use App\Helpers\FormValidationHelper;
?>
<main class="container py-3">
    <h1 class="h2">レビュー一覧</h1>
    <div class="column-contents">
        <ul class="column-content container mt-2 list-unstyled movies-grid">
            <?php foreach ($movies as $movie): ?>
                <li class="card topic shadow-sm rounded col-12 col-sm-6 col-md-4 w-100" data-movie-id=<?= $movie['id'] ?>>
                    <div class="card-body">
                        <div>
                            <span class="badge bg-primary mb-1"><?= esc($movie['genre']) ?></span>    
                        </div>
                        <a class="h3 card-title text-decoration-none text-body stretched-link" href="<?= site_url(QueryHelper::buildUrl(route_to('show', $movie['id']), $filters)) ?>"><?= esc($movie['title']) ?></a>
                        <div><?= esc($movie['year']) ?>年</div>
                        <p class="text-warning mb-0"><?= str_repeat('★', $movie['rating']) ?></p>
                        <p class="d-inline-block mb-0 text-truncate w-100"><?= esc($movie['review']) ?></p>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>

        <div class="column-content">
            <form id="search-form" action=<?= route_to('index') ?> method="get">

                <?php $errors = new FormValidationHelper(session()->getFlashdata('error') ?? []); ?>

                <?php if ($errors->hasAny()): ?>
                    <div class="alert">入力内容に誤りがあります。修正してください。</div>
                <?php endif ?>

                <fieldset class="search-form-search">
                    <legend>絞り込み</legend>

                    <!-- タイトル -->
                    <div class="search-content search-title">
                        <input 
                            class="<?= $errors->getInputClass('title') ?>"
                            type="text"
                            name="title" 
                            value="<?= esc($filters['title'] ?? '') ?>"
                            placeholder="タイトル"
                        >

                        <?= $errors->render('title') ?>
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
                        <input
                            class="<?= $errors->getInputClass('year_exact') ?>"
                            type="number"
                            name="year_exact"
                            value="<?= esc($filters['year_exact'] ?? '') ?>"
                            placeholder="公開年"
                        >
                    </div>

                   <?= $errors->render('year_exact') ?>

                    <div class="search-content search-year_range">
                        <input
                            class="<?= $errors->getInputClass('year_min') ?>"
                            type="number"
                            name="year_min"
                            value="<?= esc($filters['year_min'] ?? '') ?>"
                            placeholder="公開年（下限）"
                        >
                        
                        <?= $errors->render('year_min') ?>

                        <span>～</span>

                        <input
                            class="<?= $errors->getInputClass('year_max') ?>"
                            type="number"
                            name="year_max"
                            value="<?= esc($filters['year_max'] ?? '') ?>"
                            placeholder="公開年（上限）"
                        >

                        <?= $errors->render('year_max') ?>
                    </div>
                    

                    <!-- ジャンル -->
                    <div class="search-content search-genre">
                        <input
                            class="<?= $errors->getInputClass('genre') ?>"
                            type="text"
                            name="genre"
                            value="<?= esc($filters['genre'] ?? '') ?>"
                            placeholder="ジャンル"
                        >

                        <?= $errors->render('genre') ?>
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
                        <select class="<?= $errors->getInputClass('rating_exact') ?>" name="rating_exact">
                            <option value="">-- 評価 --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_exact']) && $filters['rating_exact'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>

                        <?= $errors->render('rating_exact') ?>
                    </div>
                    
                    <div class="search-content search-rating_range">
                        <select class="<?= $errors->getInputClass('rating_min') ?>" name="rating_min">
                            <option value="">-- 評価（下限） --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_min']) && $filters['rating_min'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>

                        <?= $errors->render('rating_min') ?>
                        
                        <span>～</span>

                        <select class="<?= $errors->getInputClass('rating_max') ?>" name="rating_max">
                            <option value="">-- 評価（上限） --</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"
                                    <?= isset($filters['rating_max']) && $filters['rating_max'] == $i ? 'selected' : '' ?>
                                ><?= str_repeat('★', $i) ?></option>
                            <?php endfor ?>
                        </select>

                        <?= $errors->render('rating_max') ?>
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