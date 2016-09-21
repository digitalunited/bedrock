<div class="container">
    <h5><?= __('component.share.heading', 'components') ?></h5>
    <ul>
        <?php foreach ($shareLinks as $link) { ?>
            <li>
                <a href="<?= $link['url'] ?>" target="_blank"><i
                        class="icon icon-<?= $link['name'] ?>"></i><span><?= $link['prettyName'] ?></span></a>
            </li>
        <?php } ?>
    </ul>
</div>
