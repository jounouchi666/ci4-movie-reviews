<?php
    use App\Helpers\QueryHelper;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieReview</title>

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div>
                <a href=<?= route_to('index') ?>>
                    <span></span>
                    <span>MovieReview</span>
                </a>
            </div>

            <div>
                <a href="<?= site_url(QueryHelper::buildUrl(route_to('create'), $filters)) ?>">新規投稿</a>
                <a href="<?= site_url(QueryHelper::buildUrl(route_to('index'), $filters)) ?>">一覧</a>
            </div>
        </nav>
    </header>