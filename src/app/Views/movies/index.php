<?php
    use App\Helpers\QueryHelper;
    use App\Helpers\FormValidationHelper;
?>
<main class="container py-3">
    <h1 class="h2">レビュー一覧</h1>
    <div class="d-flex flex-column gap-3">
        <ul class="list-unstyled movies-grid order-2">
            <?php foreach ($movies as $movie): ?>
                <li class="card topic shadow-sm rounded col-12 col-sm-6 col-md-4 w-100" data-movie-id=<?= $movie['id'] ?>>
                    <div class="card-body">
                        <div>
                            <span class="badge bg-primary mb-1"><?= esc($movie['genre']) ?></span>    
                        </div>
                        <a class="d-inline-block h3 card-title text-decoration-none text-body stretched-link text-truncate w-100" href="<?= site_url(QueryHelper::buildUrl(route_to('show', $movie['id']), $filters)) ?>"><?= esc($movie['title']) ?></a>
                        <div><?= esc($movie['year']) ?>年</div>
                        <p class="text-warning mb-0"><?= str_repeat('★', $movie['rating']) ?></p>
                        <p class="d-inline-block mb-0 text-truncate w-100"><?= esc($movie['review']) ?></p>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>

        <div id="search-form-accordion" class="accordion order-1">
            <?php $errors = new FormValidationHelper($validationErrors); ?>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button <?= $errors->whenHasErrors('', 'collapsed') ?>"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#search-form-wrapper"
                        aria-expanded="<?= $errors->whenHasErrors('true', 'false') ?>"
                        aria-controls="search-form-wrapper"
                    >
                        検索条件
                    </button>
                </h2>
                <div
                    id="search-form-wrapper"
                    class="accordion-collapse collapse <?= $errors->whenHasErrors('show') ?>"
                    data-bs-parent="#search-form-accordion"
                >
                    <div class="accordion-body">
                        <?= form_open(route_to('index'), ['id' => 'search-form', 'method' => 'get']) ?>

                            <?php if ($errors->hasAny()): ?>
                                <div class="alert alert-danger">入力内容に誤りがあります。修正してください。</div>
                            <?php endif ?>

                            <div class="row">
                                <fieldset class="search-form-search col-12 col-md-8">
                                    <legend class="h5">絞り込み</legend>

                                    <div class="d-flex flex-column gap-3">

                                        <!-- タイトル -->
                                        <div>
                                            <label class="form-label" for="title">タイトル</label>
                                            <input 
                                                class="<?= $errors->getInputClass('title') ?> form-control"
                                                type="text"
                                                name="title" 
                                                value="<?= esc($filters['title'] ?? '') ?>"
                                            >
                                            <?= $errors->render('title') ?>
                                        </div>

                                        <!-- 公開年 -->
                                        <div>
                                            <label class="form-label" for="year_type-exact">公開年</label>
                                            <div class="d-flex gap-2 mb-1">
                                                <div class="form-check">
                                                    <input
                                                        id="year_type-exact"
                                                        class="form-check-input toggle-input"
                                                        type="radio"
                                                        name="year_type"
                                                        value="exact"
                                                        data-toggle-target="#year_type-exact-group"
                                                        <?= !isset($filters['year_type']) || $filters['year_type'] === 'exact' ? 'checked' : '' ?>
                                                    >
                                                    <label class="form-check-label" for="year_type-exact">単一指定</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        id="year_type-range"
                                                        class="form-check-input toggle-input"
                                                        type="radio"
                                                        name="year_type"
                                                        value="range"
                                                        data-toggle-target="#year_type-range-group"
                                                        <?= isset($filters['year_type']) && $filters['year_type'] === 'range' ? 'checked' : '' ?>
                                                    >
                                                    <label class="form-check-label" for="year_type-range">範囲指定</label>
                                                </div>
                                            </div>

                                            <div id="year_type-exact-group">
                                                <input
                                                    id="year-exact"
                                                    class="<?= $errors->getInputClass('year_exact') ?> form-control"
                                                    type="number"
                                                    name="year_exact"
                                                    min="1900"
                                                    max="<?= date('Y') ?>"
                                                    value="<?= esc($filters['year_exact'] ?? '') ?>"
                                                >
                                                <?= $errors->render('year_exact') ?>
                                            </div>

                                            <div id="year_type-range-group">
                                                <div class="input-group">
                                                    <input
                                                        class="<?= $errors->getInputClass('year_min') ?> form-control range-min"
                                                        type="number"
                                                        name="year_min"
                                                        min="1900"
                                                        max="<?= date('Y') ?>"
                                                        value="<?= esc($filters['year_min'] ?? '') ?>"
                                                        placeholder="下限"
                                                    >
                                                    <?= $errors->render('year_min') ?>
                                                    
                                                    <span class="input-group-text">～</span>

                                                    <input
                                                        class="<?= $errors->getInputClass('year_max') ?> form-control range-max"
                                                        type="number"
                                                        name="year_max"
                                                        min="1900"
                                                        max="<?= date('Y') ?>"
                                                        value="<?= esc($filters['year_max'] ?? '') ?>"
                                                        placeholder="上限"
                                                    >
                                                </div>
                                                <?= $errors->render('year_max') ?>
                                            </div>
                                        </div>
                                        
                                        <!-- ジャンル -->
                                        <div>
                                            <label class="form-label" for="genre">ジャンル</label>
                                            <input
                                                id="genre"
                                                class="<?= $errors->getInputClass('genre') ?> form-control"
                                                type="text"
                                                name="genre"
                                                value="<?= esc($filters['genre'] ?? '') ?>"
                                            >
                                            <?= $errors->render('genre') ?>
                                        </div>

                                        <!-- 評価 -->
                                        <div>
                                            <label class="form-label" for="rating-type-exact">評価</label>
                                            <div class="d-flex gap-2 mb-1">
                                                <div class="form-check">
                                                    <input
                                                        id="rating_type-exact"
                                                        class="form-check-input toggle-input"
                                                        type="radio"
                                                        name="rating_type"
                                                        value="exact"
                                                        data-toggle-target="#rating_type-exact-group"
                                                        <?= !isset($filters['rating_type']) || $filters['rating_type'] === 'exact' ? 'checked' : '' ?>
                                                    >
                                                    <label class="form-check-label" for="rating_type-exact">単一指定</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        id="rating_type-range"
                                                        class="form-check-input toggle-input"
                                                        type="radio"
                                                        name="rating_type"
                                                        value="range"
                                                        data-toggle-target="#rating_type-range-group"
                                                        <?= isset($filters['rating_type']) && $filters['rating_type'] === 'range' ? 'checked' : '' ?>
                                                    >
                                                    <label class="form-check-label" for="rating_type-range">範囲指定</label>
                                                </div>
                                            </div>
                                            
                                            <div id="rating_type-exact-group">
                                                <select id="rating-exact" class="<?= $errors->getInputClass('rating_exact') ?> form-select rating-select" name="rating_exact">
                                                    <option value=""></option>
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <option class="text-warning" value="<?= $i ?>"
                                                            <?= isset($filters['rating_exact']) && $filters['rating_exact'] == $i ? 'selected' : '' ?>
                                                        ><?= str_repeat('★', $i) ?></option>
                                                    <?php endfor ?>
                                                </select>
                                                <?= $errors->render('rating_exact') ?>
                                            </div>
                                            
                                            <div id="rating_type-range-group">
                                                <div class="input-group">
                                                    <select id="rating-min" class="<?= $errors->getInputClass('rating_min') ?> form-select rating-select" name="rating_min">
                                                        <option class="text-muted" value="">-- 下限 --</option>
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <option class="text-warning" value="<?= $i ?>"
                                                                <?= isset($filters['rating_min']) && $filters['rating_min'] == $i ? 'selected' : '' ?>
                                                            ><?= str_repeat('★', $i) ?></option>
                                                        <?php endfor ?>
                                                    </select>

                                                    <?= $errors->render('rating_min') ?>
                                                    
                                                    <span class="input-group-text">～</span>

                                                    <select class="<?= $errors->getInputClass('rating_max') ?> form-select rating-select" name="rating_max">
                                                        <option class="text-muted" value="">-- 上限 --</option>
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <option class="text-warning" value="<?= $i ?>"
                                                                <?= isset($filters['rating_max']) && $filters['rating_max'] == $i ? 'selected' : '' ?>
                                                            ><?= str_repeat('★', $i) ?></option>
                                                        <?php endfor ?>
                                                    </select>
                                                </div>
                                                <?= $errors->render('rating_max') ?>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <hr class="d-md-none mt-4 mb-3">
                                            
                                <fieldset class="search-form-sort col-12 col-md-4">
                                    <legend class="h5">並べ替え</legend>

                                    <div class="d-flex flex-column gap-3">
                                        <div>
                                            <label class="form-label" for="order-column">並べ替え基準</label>
                                            <select id="order-column" class="form-select" name="order[column]">
                                                <option value="title" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'title' ? 'selected' : '' ?>>タイトル</option>
                                                <option value="year" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'year' ? 'selected' : '' ?>>公開年</option>
                                                <option value="genre" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'genre' ? 'selected' : '' ?>>ジャンル</option>
                                                <option value="rating" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'rating' ? 'selected' : '' ?>>評価</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="form-label" for="order-direction">昇順 / 降順</label>
                                            <select id="order-direction" class="form-select" name="order[direction]">
                                                <option value="asc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'asc' ? 'selected' : '' ?>>昇順</option>
                                                <option value="desc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'desc' ? 'selected' : '' ?>>降順</option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            
                                <hr class="my-3">

                                <fieldset class="row d-flex justify-content-center align-items-center gap-3 gap-md-1">
                                    <div class="col-12 col-md-3">
                                        <input class="btn btn-primary w-100" type="submit" value="検索">
                                    </div>
                                    <a class="col-12 col-md-auto text-center" href=<?= route_to('index') ?>>クリア</a>
                                </fieldset>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>