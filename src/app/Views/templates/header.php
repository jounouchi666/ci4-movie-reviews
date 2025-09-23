<?php
    use App\Helpers\QueryHelper;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieReview</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css')?>">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container">
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