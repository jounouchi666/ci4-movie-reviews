<?= $this->extend('templates/layout') ?>

<?= $this->section('main') ?>

<?php

use App\Helpers\FormValidationHelper;
use App\Helpers\ViewDateHelper;

$profileEditKeys = ['icon', 'username', 'status_message'];
$emailEditKeys = ['email', 'current_password_for_email'];
$passwordEditKeys = ['current_password_for_password', 'password', 'password_confirm'];

?>

<main class="container py-3">
    <?php if (session('message')): ?>
        <?= view('components/alerts/success', ['message' => session('message')]) ?>
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

                                <ul id="profileEditTabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button id="profile-tab" class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-tab-pane">プロフィール</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="account-tab" class="nav-link" data-bs-toggle="tab" data-bs-target="#account-tab-pane">会員情報</button>
                                    </li>
                                </ul>

                                <div id="profileEditTabContent" class="tab-content">

                                    <div
                                        id="profile-tab-pane"
                                        class="tab-pane fade show active"
                                        role="tabpanel"
                                        aria-labelledby="profile-tab"
                                        tabindex="0"
                                        data-has-error="<?= $errors->whenHasErrorsIn($profileEditKeys, 'true', 'false') ?>"
                                    >
                                        <?= 
                                            form_open(route_to('userProfileUpdate'),[
                                                'method' => 'post',
                                                'enctype' => 'multipart/form-data',
                                                'id' => 'userProfileUpdateForm',
                                                'class' => 'mt-4 w-100 d-flex flex-column align-items-center'
                                            ])
                                        ?>
                                            <?= csrf_field() ?>

                                            <?php if ($errors->hasError($profileEditKeys)): ?>
                                                <?= view('components/alerts/danger') ?>
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
                                                    class="<?= $errors->getInputClass('icon', ['form-control', 'form-control-sm', 'image-preview']) ?>"
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
                                                    class="<?= $errors->getInputClass('username', ['form-control']) ?>"
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
                                                    class="<?= $errors->getInputClass('status_message', ['form-control', 'fixed-textarea']) ?>"
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

                                            <input class="ms-auto d-inline-block btn btn-success" type="submit" value="プロフィールを変更">    
                                            
                                        <?= form_close() ?>
                                    </div>

                                    <div
                                        id="account-tab-pane"
                                        class="tab-pane fade"
                                        role="tabpanel"
                                        aria-labelledby="account-tab"
                                        tabindex="0"
                                        data-has-error="<?= $errors->whenHasErrorsIn([...$emailEditKeys, ...$passwordEditKeys], 'true', 'false') ?>"
                                    >
                                        <div class="mt-4">
                                            <div class="btn-group mb-4 w-100" role="group">
                                                <input
                                                    id="btnradio-email"
                                                    class="btn-check"
                                                    name="account-edit-radio"
                                                    type="radio"
                                                    data-target="email-form"
                                                    data-has-error="<?= $errors->whenHasErrorsIn($emailEditKeys, 'true', 'false') ?>"
                                                    autocomplete="off"
                                                    checked
                                                >
                                                <label class="btn btn-outline-primary w-50" for="btnradio-email">メールアドレスを変更</label>
                                                <input
                                                    id="btnradio-password"
                                                    class="btn-check"
                                                    name="account-edit-radio"
                                                    type="radio"
                                                    data-target="password-form"
                                                    data-has-error="<?= $errors->whenHasErrorsIn($passwordEditKeys, 'true', 'false') ?>"
                                                    autocomplete="off"
                                                >
                                                <label class="btn btn-outline-primary w-50" for="btnradio-password">パスワードを変更</label>
                                                </button>
                                            </div>

                                            <?= 
                                                form_open(route_to('userEmailUpdate'), [
                                                    'method' => 'post',
                                                    'id' => 'email-form',
                                                    'class' => 'd-flex flex-column align-items-center account-form w-100'
                                                ])
                                            ?>
                                                <?= csrf_field() ?>

                                                <?php if ($errors->hasError($emailEditKeys)): ?>
                                                    <?= view('components/alerts/danger') ?>
                                                <?php endif ?>

                                                <div class="form-floating mb-4 w-100">
                                                    <input
                                                        id="newEmail"
                                                        class="<?= $errors->getInputClass('email', ['form-control']) ?>"
                                                        type="email"
                                                        name="email"
                                                        inputmode="email"
                                                        autocomplete="email"
                                                        placeholder="新しいメールアドレス"
                                                        value="<?= old('email') ?>"
                                                        required
                                                    >
                                                    <label for="newEmail">新しいメールアドレス</label>
                                                    <?= $errors->render('email') ?>
                                                </div>

                                                <div class="form-floating mb-4 w-100">
                                                    <input
                                                        id="currentPasswordForEmail"
                                                        class="<?= $errors->getInputClass('current_password_for_email', ['form-control']) ?>"
                                                        type="password"
                                                        name="current_password_for_email"
                                                        inputmode="text"
                                                        autocomplete="current_password_for_email"
                                                        placeholder="現在のパスワード"
                                                        required
                                                    >
                                                    <label for="currentPasswordForEmail">現在のパスワード</label>
                                                    <?= $errors->render('current_password_for_email') ?>
                                                </div>

                                                <button class="ms-auto d-inline-block btn btn-success" type="submit">メールアドレスを変更</button>
                                            
                                            <?= form_close() ?>

                                            <?= 
                                                form_open(route_to('userPasswordUpdate'), [
                                                    'method' => 'post',
                                                    'id' => 'password-form',
                                                    'class' => 'd-flex flex-column align-items-center account-form w-100 d-none'
                                                ])
                                            ?>
                                                <?= csrf_field() ?>

                                                <?php if ($errors->hasError($passwordEditKeys)): ?>
                                                    <?= view('components/alerts/danger') ?>
                                                <?php endif ?>

                                                <div class="form-floating mb-4 w-100">
                                                    <input
                                                        id="current_password_for_password"
                                                        class="<?= $errors->getInputClass('current_password_for_password', ['form-control']) ?>"
                                                        type="password"
                                                        name="current_password_for_password"
                                                        inputmode="text"
                                                        autocomplete="current_password_for_password"
                                                        placeholder="現在のパスワード"
                                                        required
                                                    >
                                                    <label for="current_password_for_password">現在のパスワード</label>
                                                    <?= $errors->render('current_password_for_password') ?>
                                                </div>

                                                <div class="form-floating mb-2 w-100">
                                                    <input
                                                        id="password"
                                                        class="<?= $errors->getInputClass('password', ['form-control']) ?>"
                                                        type="password"
                                                        name="password"
                                                        inputmode="text"
                                                        autocomplete="password"
                                                        placeholder="新しいパスワード"
                                                        required
                                                    >
                                                    <label for="password">新しいパスワード</label>
                                                    <?= $errors->render('password') ?>
                                                </div>

                                                <div class="form-floating mb-4 w-100">
                                                    <input
                                                        id="passwordConfirm"
                                                        class="<?= $errors->getInputClass('password_confirm', ['form-control']) ?>"
                                                        type="password"
                                                        name="password_confirm"
                                                        inputmode="text"
                                                        autocomplete="password_confirm"
                                                        placeholder="新しいパスワード（再入力）"
                                                        required
                                                    >
                                                    <label for="passwordConfirm">新しいパスワード（再入力）</label>
                                                    <?= $errors->render('password_confirm') ?>
                                                </div>

                                                <button class="ms-auto d-inline-block btn btn-success" type="submit">パスワードを変更</button>

                                            <?= form_close() ?>
                                            <script>
                                                document.querySelectorAll('#account-tab-pane .btn-check').forEach(input => {
                                                input.addEventListener('click', e => {
                                                    const target = input.dataset.target;
                                                    input.checked = true;
                                                    document.querySelectorAll('#account-tab-pane .account-form').forEach(form => {
                                                    form.classList.toggle('d-none', form.id !== target);
                                                    });
                                                });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>

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