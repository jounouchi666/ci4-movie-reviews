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
        <form class="col-12 col-md-3" action=<?= QueryHelper::buildUrl(route_to('delete', $movie['id']), $filters) ?> method="post">
            <input class="btn btn-danger w-100" type="submit" value="削除">
        </form>
        <a class="col-12 col-md-auto text-center" href="<?= site_url(QueryHelper::buildUrl(route_to('index'), $filters)) ?>">一覧に戻る</a>
    </div>
</main>