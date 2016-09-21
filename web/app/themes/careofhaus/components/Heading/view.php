<?php if ($link->url) { ?>
<a href="<?= $link->url ?>" title="<?= $link->title ?>" target="<?= $link->target ?>">
    <?php } ?>

    <<?= $tag ?> class="<?= $size ?> <?= $color ?> <?= $weight ?>" <?= $max_width ? 'style="max-width: ' . $max_width . ';"' : '' ?>>
    <?= $heading ?>
</<?= $tag ?>>

<?php if ($link->url) { ?>
    </a>
<?php } ?>
