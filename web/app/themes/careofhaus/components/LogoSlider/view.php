<div class="logo-wrapper">
    <?php foreach ($slides as $slide) { ?>
        <div>
            <?php if ($slide->url) { ?>
            <a href="<?= $slide->url ?>" target="_blank"><span
                    class="sr-only"><?= __('components.logoslider.view.heading', 'components') ?></span>
                <?php } ?>
                <div class="item-bg-image lazyload" data-bgset="<?= $slide->srcset ?>"></div>

                <?php if ($slide->url) { ?>
            </a>
        <?php } ?>
        </div>
    <?php } ?>
</div>
