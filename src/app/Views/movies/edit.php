<?php $this->extend('templates/layout') ?>

<?php $this->section('main') ?>

<?php
    use App\Helpers\QueryHelper;
    use App\Helpers\FormValidationHelper;
?>
<main class="container py-3">
    <h1 class="h2 mb-3"><?= esc($config['title']) ?></h1>

    <?= form_open(route_to('save'), ['class' => 'd-flex flex-column gap-3', 'method' => 'post']) ?>
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