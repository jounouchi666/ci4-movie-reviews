<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MovieReview</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <?= $this->renderSection('pageStyles') ?>
    <link rel="stylesheet" href="<?= base_url('css/style.css')?>">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
    <body>
        <div id="container">
            <?= view('templates/header', ['filters' => $filters ?? []]) ?>

            <?= $this->renderSection('main') ?>

            <?= view('templates/footer') ?>
        </div>

        <?= $this->renderSection('pageScripts') ?>
        <script type="module" src="<?= base_url('js/main.js') ?>"></script>
    </body>
</html>