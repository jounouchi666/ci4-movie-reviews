<?php use App\Helpers\QueryHelper; ?>
<main>
    <li>
        <div><?= esc($movie['title']) ?></div>
    </li>
    <li>
        <div><?= esc($movie['year']) ?>年</div>
    </li>
    <li>
        <div><?= esc($movie['genre']) ?></div>
    </li>
    <li>
        <div><?= esc(str_repeat('★', $movie['rating'])) ?></div>
    </li>
    <li>
        <div><?= esc($movie['review']) ?></div>
    </li>

    <div class="nav">
        <a href="<?= site_url(QueryHelper::buildUrl(route_to('index'), $filters)) ?>">一覧に戻る</a>
        <a href="<?= site_url(QueryHelper::buildUrl(route_to('edit', $movie['id']), $filters)) ?>">修正</a>
        <form action=<?= QueryHelper::buildUrl(route_to('delete', $movie['id']), $filters) ?> method="post">
            <input type="submit" value="削除">
        </form>
    </div>
</main>