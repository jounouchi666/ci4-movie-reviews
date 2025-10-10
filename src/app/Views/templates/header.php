<?php
    use App\Helpers\QueryHelper;
?>

<header class="container my-2">
    <nav class="row align-items-center py-2">
        <div class="col-md">
            <a class="text-decoration-none d-inline-flex align-items-center mb-3 mb-md-0" href=<?= route_to('index') ?>>
                <span width="50"></span>
                <span class="h2 font-weight-bold mb-0">MovieReview</span>
            </a>
        </div>

        <div id="nav-buttons" class="col-md-auto d-flex align-items-center gap-2">
            <a class="btn btn-primary" href="<?= site_url(QueryHelper::buildUrl(route_to('create'), $filters)) ?>">新規投稿</a>
            <a class="text-decoration-none" href="<?= site_url(QueryHelper::buildUrl(route_to('index'), $filters)) ?>">一覧</a>
        </div>
    </nav>
</header>