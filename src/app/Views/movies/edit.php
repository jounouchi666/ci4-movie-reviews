<?php $this->extend('templates/layout') ?>

<?php $this->section('main') ?>

<?php
    use App\Helpers\QueryHelper;
    use App\Helpers\FormValidationHelper;
?>
<main class="container py-3">
    <h1 class="h2 mb-3"><?= esc($config['title']) ?></h1>

    <!-- 検索 -->
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#movie-search-modal">映画を検索</button>
    <div id="movie-search-modal" class="modal fade slide-up" tabindex="-1" aria-labelledby="movie-search-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="movie-search-modal-label" class="modal-title fs-5">映画を検索</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-md">
                        <form id="movie-search-form" class="d-flex justify-content-center">
                            <div class="input-group mw-xl">
                                <input class="form-control" type="text" name="title" minlength="1" maxlength="255" placeholder="タイトルを入力" required>
                                <button class="btn btn-primary" type="submit">検索</button>
                            </div>
                        </form>

                        <div id="movie-search-results" class="w-100">
                            <div style="display: none;" class="spinner-wrapper w-100">
                                <div class="h-120px w-100 d-inline-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-secondary top-0 bottom-0 start-0 end-0 m-auto" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <p class="total-results mt-4 d-flex justify-content-end"></p>
                        
                            <div class="mt-3 flex-1">
                                <ul class="p-0 results"></ul>
                            </div>
                        </div>

                        <div class="modal-footer moviesearch-pagination d-flex flex-column align-items-center">
                            <ul class="pagination">
                                <li class="page-item page-prev disabled">
                                    <button class="page-link" disabled=true>
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </button>
                                </li>
                                <li class="page-item page-next">
                                    <button class="page-link">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </button>
                                </li>
                            </ul>
                            <p class="page-per-totalpages"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="movie-search-detail-modal" class="modal fade slide-up" tabindex="-1" aria-labelledby="movie-search-detail-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-md-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="back-link d-flex align-items-center gap-1 link-secondary link-offset-2 fs-5" href="#movie-search-modal" data-bs-toggle="modal">
                        <i class="bi bi-chevron-left fs-6"></i>
                        一覧に戻る
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="container-md">
                        <div id="movie-search-detail" class="w-100 mb-3">
                            <h3 class="h2">タイトル<span class="h3">（YYYY年公開）</span></h3>
                            <div class="movie-genres h5">
                                <span class="badge bg-primary">カテゴリA</span>
                                <span class="badge bg-primary">カテゴリB</span>
                                <span class="badge bg-primary">カテゴリC</span>
                            </div>

                            <div class="mt-2">
                                <img src="<?= base_url(DEFAULT_POSTER_IMAGE)?>" alt="ポスター" class="poster-image" loading="lazy">
                            </div>

                            <div class="mt-3">
                                <h4 class="h4">あらすじ</h4>
                                <p class="mb-0 d-inline-block text-truncate w-100">あらすじ文章</p>
                            </div>
                        </div>

                        <div class="modal-footer px-0 d-flex justify-content-center">
                            <button class="mx-0 btn btn-success w-100 mw-xl">適用</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= form_open(route_to('save'), ['class' => 'mt-3 d-flex flex-column gap-3', 'method' => 'post']) ?>
        <?= csrf_field() ?>

        <?php if ($mode === 'edit'):  ?>
            <!-- ID -->
            <input
                type="hidden"
                name="id"
                value="<?= isset($movie->id) ? esc($movie->id) : '' ?>"
            >
        <?php endif ?>

        <?php $errors = new FormValidationHelper(session()->getFlashdata('error') ?? []); ?>
        <?php if ($errors->hasAny()): ?>
            <?= view('components/alerts/danger') ?>
        <?php endif ?>

        <!-- タイトル -->
        <div>
            <label class="form-label" for="title">タイトル</label>
            <input
                id="title"
                class="<?= $errors->getInputClass('title', ['form-control', 'mt-1']) ?>"
                type="text"
                name="title"
                value="<?= old('title', $movie->title ?? '') ?>"
                required
            >
            
            <?= $errors->render('title') ?>
        </div>
        
        <!-- 公開年 -->
        <div>
            <label class="form-label" for="year">公開年</label>
            <input
                id="year"
                class="<?= $errors->getInputClass('year', ['form-control', 'mt-1']) ?>"
                type="number"
                name="year"
                min="1900"
                max="<?= date('Y') ?>"
                value="<?= old('year', $movie->year ?? '') ?>"
                required
            >

            <?= $errors->render('year') ?>
        </div>

        <!-- ジャンル -->
        <div>
            <label class="form-label" for="genre">ジャンル</label>
            <input
                id="genre"
                class="<?= $errors->getInputClass('genre', ['form-control', 'mt-1']) ?>"
                type="text"
                name="genre"
                value="<?= old('genre', $movie->genre ?? '') ?>"
                required
            >

            <?= $errors->render('genre') ?>
        </div>

        <!-- 評価 -->
        <div>
            <label class="form-label" for="rating">評価</label>
            <select id="rating" class="<?= $errors->getInputClass('rating', ['form-select', 'mt-1', 'rating-select']) ?>" name="rating" required>
                <option class="text-muted" value="">--評価を選択--</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option
                        class="text-warning"
                        value="<?= $i ?>"
                        <?= old('rating', $movie->rating ?? '') == $i ? 'selected' : '' ?>
                    ><?= str_repeat('★', $i) ?></option>
                <?php endfor ?>
            </select>

            <?= $errors->render('rating') ?>
        </div>

        <!-- レビュー -->
        <div>
            <label class="form-label" for="review">レビュー</label>
            <textarea 
                id="review" 
                class="<?= $errors->getInputClass('review', ['form-control', 'mt-1']) ?>"
                name="review" 
            ><?= old('review', $movie->review ?? '') ?></textarea>

            <?= $errors->render('review') ?>
        </div>

        <div class="row d-flex justify-content-center align-items-center gap-3 gap-md-1">
            <div class="col-12 col-md-3">
                <input class="btn btn-success w-100" type="submit" value="<?= $config['submit'] ?>">
            </div>
            <a class="col-12 col-md-auto text-center" href="<?= site_url(QueryHelper::buildUrl($config['back_url'], $filters)) ?>"><?= $config['back_text'] ?></a>
        </div>
        
    <?= form_close() ?>

    
</main>

<?php $this->endSection() ?>