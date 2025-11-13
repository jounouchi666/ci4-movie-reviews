<div 
    class="alert
    <?= esc($type ?? 'alert-info') ?> w-100 d-flex align-items-center<?= $isset($class) ? ' ' . esc($class) : '' ?>"
>
    <?php if (!empty($icon)): ?>
        <?= $icon ?>
    <?php endif ?>
    <div><?= esc($message ?? '') ?></div>
</div>