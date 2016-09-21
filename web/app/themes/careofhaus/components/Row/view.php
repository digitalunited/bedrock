<?php if ('vc_row' === $row_type) { ?>
<section id="<?= $row_id ?>" class="section <?= $section_color ? ' ' . $section_color : '' ?><?= $column_padding ? ' ' . $column_padding : '' ?><?= $margin_top ? ' ' . $margin_top : '' ?><?= $margin_bottom ? ' ' . $margin_bottom : '' ?><?= $full_height ? ' ' . $full_height : '' ?>">
    <div class="<?= $container_type_class ?> <?= $section_bg_image ? ' du-resp-div-bg lazyload cover' : '' ?><?= $section_bg_color ? ' ' . $section_bg_color : '' ?><?= $section_bg_image_fixed ? ' ' . $section_bg_image_fixed : '' ?>" data-bgset="<?= $srcset ?>">
        <?php } ?>

        <?php if ($container_type_class === 'container-fluid-full') { ?>
        <div class="container">
            <?php } ?>

            <div class="<?= $row_css_class ?>">
                <?= $content ?>
            </div><!-- row -->

            <?php if ($container_type_class === 'container-fluid-full') { ?>
        </div><!-- container -->
    <?php } ?>

        <?php if ('vc_row' === $row_type) { ?>
    </div><!-- container -->
</section><!-- section -->
<?php } ?>
