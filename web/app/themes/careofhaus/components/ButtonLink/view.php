<a href="<?= $link->url ?>" class="btn--link <?= $arrow_position ?>" title="<?= $link->title ?>"
    target="<?= $link->target ?>" role="button">
    <?= $arrow_position == 'arrow--rightside' ? $text : '' ?><span
        class="icon <?= $arrow ?>"></span><?= $arrow_position == 'arrow--leftside' ? $text : '' ?>
</a>
