<?= $this->extend('templates/layout') ?>

<?= $this->section('main') ?>

<?php

use App\Helpers\FormValidationHelper;
use App\Helpers\ViewDateHelper;
?>

<main class="container py-3">
    <?php if (session('message')): ?>
        <div class="alert alert-success flash-success d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div><?= esc(session('message')) ?></div>
        </div>
    <?php endif ?>
    
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <picture class="mb-3">
                        <source class="rounded-circle border shadow-sm profile-icon" media="(max-width: 768px)" srcset="<?= $user->thumb_urls[100] ?>">
                        <img class="rounded-circle border shadow-sm profile-icon" src="<?= $user->thumb_urls[120] ?>" alt="<?= $user->username ?>のアイコン" loading="lazy">    
                    </picture>

                    <h2 class="h4 mb-1"><?= esc($user->username) ?></h2>

                    <p class="text-muted text-start mb-3">
                        <?= esc($user->status_message) ?>
                    </p>

                    <?php if ($mode === 'auth'): ?>
                        <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#profile-modal">プロフィール編集</button>
                    <?php endif ?>
                </div>
            </div>

            <?php if ($mode === 'auth'): ?>
                <?php $errors = new FormValidationHelper(session()->getFlashdata('errors') ?? []); ?>

                <div
                    id="profile-modal"
                    class="modal fade slide-up"
                    tabindex="-1"
                    aria-labelledby="profile-modal-label"
                    data-has-error="<?= $errors->whenHasErrors('true', 'false') ?>"
                >
                    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="profile-modal-label" class="modal-title fs-5">プロフィールの編集</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= 
                                    form_open(route_to('userProfileUpdate'),[
                                        'method' => 'post',
                                        'enctype' => 'multipart/form-data',
                                        'id' => 'userProfileUpdateForm',
                                        'class' => 'w-100 d-flex flex-column align-items-center'
                                    ])
                                ?>
                                    <?= csrf_field() ?>

                                    <?php if ($errors->hasAny()): ?>
                                        <div class="alert alert-danger w-100 d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>   
                                            <div>入力内容に誤りがあります。修正してください。</div>
                                        </div>
                                    <?php endif ?>

                                    <div class="mb-4 w-100">
                                        <label  class="form-label text-align-start" for="userIconInput">ユーザーアイコン</label>
                                        <div class="mb-3 d-inline-block w-100 mx-auto position-relative spinner-wrapper">
                                            <img
                                                src="<?= $user->thumb_urls[120] ?>"
                                                alt="<?= $user->username ?>のアイコン"
                                                id="preview-user-icon"
                                                class="rounded-circle border shadow-sm profile-icon"
                                                loading="lazy"
                                            >
                                            <div style="display: none;" class="spinner-border text-secondary position-absolute top-0 bottom-0 start-0 end-0 m-auto" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <input
                                            id="userIconInput"
                                            class="<?= $errors->getInputClass('icon') ?> form-control form-control-sm image-preview"
                                            type="file"
                                            name="icon"
                                            accept="image/jpg, image/jpeg, image/png"
                                            data-preview-target="preview-user-icon"
                                        >
                                        <?= $errors->render('icon') ?>
                                    </div>

                                    <div class="form-floating mb-4 w-100">
                                        <input
                                            type="text"
                                            class="<?= $errors->getInputClass('username') ?> form-control"
                                            id="floatingUsernameInput"
                                            name="username"
                                            inputmode="text"
                                            autocomplete="username"
                                            placeholder="<?= lang('Auth.username') ?>"
                                            value="<?= old('username', $user->username) ?>"
                                            minlength="3"
                                            maxlength="30"
                                        >
                                        <label for="floatingUsernameInput">ユーザー名</label>
                                        <?= $errors->render('username') ?>
                                    </div>
                                
                                    <div class="form-floating mb-4 w-100">
                                        <textarea
                                            class="<?= $errors->getInputClass('status_message') ?> form-control fixed-textarea"
                                            id="floatingStatusMessageInput"
                                            name="status_message"
                                            inputmode="text"
                                            maxlength="255"
                                            autocomplete="status_message"
                                            placeholder="ステータスメッセージ"
                                        ><?= old('status_message', $user->status_message ?? '') ?></textarea>
                                        <label for="floatingStatusMessageInput">ステータスメッセージ</label>
                                        <?= $errors->render('status_message') ?>
                                    </div>
                                <?= form_close() ?>
                            </div>
                            <div class="modal-footer">
                                <input class="btn btn-success" type="submit" form="userProfileUpdateForm" value="保存">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
                    <li class="card topic shadow-sm rounded col-12 col-sm-6 col-md-4 w-100" data-movie-id=<?= $movie->id ?>>
                        <div class="card-body">
                            <div>
                                <span class="badge bg-primary mb-1"><?= esc($movie->genre) ?></span>    
                            </div>
                            <a class="d-inline-block h3 card-title text-decoration-none text-body stretched-link text-truncate w-100" href="<?= route_to('show', $movie->id) ?>"><?= esc($movie->title) ?></a>
                            <div><?= esc($movie->year) ?>年</div>
                            <p class="text-warning mb-0"><?= str_repeat('★', $movie->rating) ?></p>
                            <p class="d-inline-block mb-0 text-truncate w-100"><?= esc($movie->review) ?></p>
                            <p class="text-muted fst-italic mb-0">
                                <?= $movie->updated_at ? ViewDateHelper::toStringUS(strtotime($movie->updated_at)) : '' ?>
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