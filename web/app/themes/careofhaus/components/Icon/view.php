<?php if ($link->url) { ?>
<a href="<?= $link->url ?>">
    <?php } ?>
    <span class="icon icon-<?= $icon ?> <?= $color ?>"></span>
    <?php if ($subtitle) { ?>
        <p><?= $subtitle ?></p>
    <?php } ?>
    <?php if ($link->url) { ?>
</a>
<?php } ?>

