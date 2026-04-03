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
                <div class="modal-body h-100 d-flex flex-column p-0">
                    <div class="container-md p-3 flex-shrink-0">
                        <form id="movie-search-form" class="d-flex justify-content-center" autocomplete="off">
                            <div class="input-group mw-xl">
                                <input class="form-control" type="text" name="title" maxlength="255" placeholder="タイトルを入力" aria-label="映画タイトル" required>
                                <button class="btn btn-primary" type="submit">検索</button>
                            </div>
                        </form>

                        <div id="movie-search-results" class="position-relative flex-grow-1 overflow-auto mh-212px">
                            <div class="spinner-wrapper position-absolute w-100 h-100 z-3 d-none d-flex justify-content-center align-items-center bg-white bg-opacity-50">
                                <div class="spinner-border text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <p class="movie-search__total mt-4 d-flex justify-content-end"></p>
                        
                            <div class="mt-3 flex-1">
                                <ul class="p-0 movie-search__results"></ul>
                            </div>
                        </div>

                        <div class="modal-footer movie-search__pagination d-flex flex-column align-items-center">
                            <ul class="pagination">
                                <li class="page-item movie-search__page-prev disabled">
                                    <button class="page-link" disabled>
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </button>
                                </li>
                                <li class="page-item movie-search__page-next disabled">
                                    <button class="page-link" disabled>
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
                        <div id="movie-search-detail" class="movie-detail__detail w-100 mb-3"></div>

                        <div class="modal-footer px-0 d-flex justify-content-center movie-detail__apply">
                            <button class="mx-0 btn btn-success w-100 mw-xl apply-button">適用</button>
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