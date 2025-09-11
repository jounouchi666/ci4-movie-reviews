<?php use App\Helpers\QueryHelper; ?>
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

        <?php $errors = session()->getFlashdata('error'); ?>

        <!-- タイトル -->
        <div class="edit-form-content edit-form-title">
            <label for="title">タイトル</label>
            <input
                id="title"
                type="text"
                name="title"
                value="<?= old('title', $movie['title'] ?? '') ?>"
                placeholder="タイトル"
                required
            >
            
            <?php if (!empty($errors['title'])): ?>
                <div class="error-message"><?= $errors['title'] ?></div>
            <?php endif ?>
        </div>
        
        <!-- 公開年 -->
        <div class="edit-form-content edit-form-year">
            <label for="year">公開年</label>
            <input
                id="year"
                type="number"
                name="year"
                min="1900"
                max="<?= date('Y') ?>"
                value="<?= old('year', $movie['year'] ?? '') ?>"
                placeholder="公開年"
                required
            >

            <?php if (!empty($errors['year'])): ?>
                <div class="error-message"><?= $errors['year'] ?></div>
            <?php endif ?>
        </div>

        <!-- ジャンル -->
        <div class="edit-form-content edit-form-genre">
            <label for="genre">ジャンル</label>
            <input
                id="genre"
                type="text"
                name="genre"
                value="<?= old('genre', $movie['genre'] ?? '') ?>"
                placeholder="ジャンル"
                required
            >

            <?php if (!empty($errors['genre'])): ?>
                <div class="error-message"><?= $errors['genre'] ?></div>
            <?php endif ?>
        </div>

        <!-- 評価 -->
        <div class="edit-form-content edit-form-rating">
            <label for="rating">評価</label>
            <select id="rating" name="rating" required>
                <option value="">-- 評価 --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option
                        value="<?= $i ?>"
                        <?= old('rating', $movie['rating'] ?? '') == $i ? 'selected' : '' ?>
                    ><?= str_repeat('★', $i) ?></option>
                <?php endfor ?>
            </select>

            <?php if (!empty($errors['rating'])): ?>
                <div class="error-message"><?= $errors['rating'] ?></div>
            <?php endif ?>
        </div>

        <!-- レビュー -->
        <div class="edit-form-content edit-form-review">
            <label for="review">レビュー</label>
            <textarea id="review" name="review" required><?= old('review', $movie['review'] ?? '') ?></textarea>

            <?php if (!empty($errors['review'])): ?>
                <div class="error-message"><?= $errors['review'] ?></div>
            <?php endif ?>
        </div>

        <input type="submit" value="<?= $config['submit'] ?>">
    <?= form_close() ?>

    <a href="<?= site_url(QueryHelper::buildUrl($config['back_url'], $filters)) ?>"><?= $config['back_text'] ?></a>
</main>