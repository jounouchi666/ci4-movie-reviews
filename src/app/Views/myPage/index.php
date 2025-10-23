<?= $this->extend('templates/layout') ?>

<?= $this->section('main') ?>

<?php
    use App\Helpers\ViewDateHelper;
?>

<main class="container py-3">
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <img src="https://placehold.co/120x120" alt="ユーザーアイコン" class="rounded-circle mb-3 profile-icon">

                    <h2 class="h4 mb-1"><?= esc($user->username) ?></h2>

                    <span class="badge bg-success mb-2"><?= esc($user->status) ?></span>

                    <p class="text-muted mb-3">
                    <?= esc($user->status_message) ?>
                    </p>

                    <?php if ($mode === 'auth'): ?>
                        <a href="#" class="btn btn-outline-primary btn-sm w-100">プロフィール編集</a>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <h3 class="h4 mb-3 border-bottom pb-2">投稿一覧</h3>

            <div class="mb-2">
                <?php $route = $mode === 'auth' ? route_to('userIndex') : route_to('user', $user->id);?>
                <?= form_open($route, ['method' => 'get', 'class' => 'd-flex justify-content-end']); ?>
                    <div class="input-group w-auto">
                        <select id="order-column" class="form-select w-auto" name="order[column]">
                            <option value="updated_at" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'updated_at' ? 'selected' : '' ?>>投稿日</option>
                            <option value="title" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'title' ? 'selected' : '' ?>>タイトル</option>
                            <option value="year" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'year' ? 'selected' : '' ?>>公開年</option>
                            <option value="genre" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'genre' ? 'selected' : '' ?>>ジャンル</option>
                            <option value="rating" <?= isset($filters['order']['column']) && $filters['order']['column'] === 'rating' ? 'selected' : '' ?>>評価</option>
                        </select>
                        <select id="order-direction" class="form-select w-auto" name="order[direction]">
                            <option value="desc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'desc' ? 'selected' : '' ?>>降順</option>
                            <option value="asc" <?= isset($filters['order']['direction']) && $filters['order']['direction'] === 'asc' ? 'selected' : '' ?>>昇順</option>
                        </select>
                    </div>
                    <button class="btn btn-primary ms-1" type="submit">並べ替える</button>
                 <?= form_close() ?>
            </div>

            <ul class="list-unstyled movies-grid order-2">
                <?php if (!$movies): ?>
                    <p class="text-muted">投稿はまだありません。</p>
                <?php endif ?>

                <?php foreach ($movies as $movie): ?>
                    <li class="card topic shadow-sm rounded col-12 col-sm-6 col-md-4 w-100" data-movie-id=<?= $movie['id'] ?>>
                        <div class="card-body">
                            <div>
                                <span class="badge bg-primary mb-1"><?= esc($movie['genre']) ?></span>    
                            </div>
                            <a class="d-inline-block h3 card-title text-decoration-none text-body stretched-link text-truncate w-100" href="<?= route_to('show', $movie['id']) ?>"><?= esc($movie['title']) ?></a>
                            <div><?= esc($movie['year']) ?>年</div>
                            <p class="text-warning mb-0"><?= str_repeat('★', $movie['rating']) ?></p>
                            <p class="d-inline-block mb-0 text-truncate w-100"><?= esc($movie['review']) ?></p>
                            <p class="text-muted fst-italic mb-0">
                                <?= $movie['updated_at'] ? ViewDateHelper::toStringUS(strtotime($movie['updated_at'])) : '' ?>
                        </p>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>

            <div class="order-3 d-flex justify-content-center align-items-center"><?= $pager->links('default', 'bootstrap') ?></div>

        </div>
    </div>
</main>

<?= $this->endSection() ?>