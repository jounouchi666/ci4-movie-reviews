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
        <a href="<?= site_url(QueryHelper::buildUrl('movies/' , $filters)) ?>">一覧に戻る</a>
    </div>
</main>