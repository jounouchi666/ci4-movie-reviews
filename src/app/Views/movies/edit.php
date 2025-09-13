<?php
    use App\Helpers\QueryHelper;
    use App\Helpers\FormValidationHelper;
?>
<main>
    <h1><?= esc($config['title']) ?></h1>

    <?= form_open(route_to('save'), ['class' => 'edit-form', 'method' => 'post']) ?>
        <?= csrf_field() ?>

        <?php if ($mode === 'edit'):  ?>
            <!-- ID -->
            <input
                type="hidden"
                name="id"
                value="<?= isset($movie['id']) ? esc($movie['id']) : '' ?>"
            >
        <?php endif ?>

        <?php $errors = new FormValidationHelper(session()->getFlashdata('error') ?? []); ?>
        <?php if ($errors->hasAny()): ?>
            <div class="alert">入力内容に誤りがあります。修正してください。</div>
        <?php endif ?>

        <!-- タイトル -->
        <div class="edit-form-content edit-form-title">
            <label for="title">タイトル</label>
            <input
                id="title"
                class="<?= $errors->getInputClass('title') ?>"
                type="text"
                name="title"
                value="<?= old('title', $movie['title'] ?? '') ?>"
                placeholder="タイトル"
                required
            >
            
            <?= $errors->render('title') ?>
        </div>
        
        <!-- 公開年 -->
        <div class="edit-form-content edit-form-year">
            <label for="year">公開年</label>
            <input
                id="year"
                class="<?= $errors->getInputClass('year') ?>"
                type="number"
                name="year"
                min="1900"
                max="<?= date('Y') ?>"
                value="<?= old('year', $movie['year'] ?? '') ?>"
                placeholder="公開年"
                required
            >

            <?= $errors->render('year') ?>
        </div>

        <!-- ジャンル -->
        <div class="edit-form-content edit-form-genre">
            <label for="genre">ジャンル</label>
            <input
                id="genre"
                class="<?= $errors->getInputClass('genre') ?>"
                type="text"
                name="genre"
                value="<?= old('genre', $movie['genre'] ?? '') ?>"
                placeholder="ジャンル"
                required
            >

            <?= $errors->render('genre') ?>
        </div>

        <!-- 評価 -->
        <div class="edit-form-content edit-form-rating">
            <label for="rating">評価</label>
            <select id="rating" class="<?= $errors->getInputClass('rating') ?>" name="rating" required>
                <option value="">-- 評価 --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option
                        value="<?= $i ?>"
                        <?= old('rating', $movie['rating'] ?? '') == $i ? 'selected' : '' ?>
                    ><?= str_repeat('★', $i) ?></option>
                <?php endfor ?>
            </select>

            <?= $errors->render('rating') ?>
        </div>

        <!-- レビュー -->
        <div class="edit-form-content edit-form-review">
            <label for="review">レビュー</label>
            <textarea 
                id="review" 
                class="<?= $errors->getInputClass('review') ?>"
                name="review" 
                required
            ><?= old('review', $movie['review'] ?? '') ?></textarea>

            <?= $errors->render('review') ?>
        </div>

        <input type="submit" value="<?= $config['submit'] ?>">
    <?= form_close() ?>

    <a href="<?= site_url(QueryHelper::buildUrl($config['back_url'], $filters)) ?>"><?= $config['back_text'] ?></a>
</main>