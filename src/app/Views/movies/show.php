<?php use App\Helpers\QueryHelper; ?>
<main class="container py-3">
    <div>
        <h1><?= esc($movie['title']) ?><span class="h3">（<?= esc($movie['year']) ?>年公開）</span></h1>
        <div class="h4">
            <span class="badge bg-primary"><?= esc($movie['genre']) ?></span>
        </div>
    </div>
    
    <div>
        <img src="" alt="ポスター">
    </div>

    <hr>

    <div>
        <h2>評価</h2>
        <p class="text-warning h4"><?= esc(str_repeat('★', $movie['rating'])) ?></p>
        <p><?= esc($movie['review']) ?></p>
    </div>

    <hr class="mt-5">

    <div class="row d-flex justify-content-center align-items-center gap-2 gap-md-1">
        <div class="col-12 col-md-3">
            <a class="btn btn-primary w-100" href="<?= site_url(QueryHelper::buildUrl(route_to('edit', $movie['id']), $filters)) ?>">修正</a>
        </div>
        <div class="col-12 col-md-3">
            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete-modal">削除</button>
        </div>
        <a class="col-12 col-md-auto text-center" href="<?= site_url(QueryHelper::buildUrl(route_to('index'), $filters)) ?>">一覧に戻る</a>
    </div>

    <div id="delete-modal" class="modal fade slide-up" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="delete-modal-label" class="modal-title fs-5">投稿の削除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>投稿を削除しますか？</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">いいえ</button>
                    <form action=<?= QueryHelper::buildUrl(route_to('delete', $movie['id']), $filters) ?> method="post">
                        <input class="btn btn-danger" type="submit" value="はい">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>