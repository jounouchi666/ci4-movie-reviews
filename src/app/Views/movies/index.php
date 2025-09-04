<main>
    <ul>
        <?php foreach ($movies as $movie): ?>
            <li>
                <div><?= esc($title) ?></div>
                <div><?= esc($year) ?></div>
                <div><?= esc($rating) ?></div>
                <div><?= esc($genre) ?></div>
            </li>
        <?php endforeach ?>
    </ul>
</main>