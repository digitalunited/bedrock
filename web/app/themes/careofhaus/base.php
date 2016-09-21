<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

<!--[if lt IE 10]>
<div class="alert alert-warning">
    <?= __('You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'roots'); ?>
</div>
<![endif]-->

<?= (new \Component\CookieAlert())->render() ?>

<?php
do_action('get_header');
echo (new \Component\Header())->render();
?>
<?php
if (!empty(get_field('show_slider_in_header', $post->ID, true))) {
    $slideCategory = get_field('slider_category_id', $post->ID, true);
    if (!empty($slideCategory)) {
        $slider = new \Component\Slider([
            'slide_category' => $slideCategory,
            'show_arrows' => !empty(get_field('show_arrows', $post->ID, true)),
            'show_dots' => !empty(get_field('show_dots', $post->ID, true)),
        ]);
        echo $slider->render();
    }
}
?>
<div class="wrap" role="document">
    <div class="content">
        <main class="main" role="main">
            <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
    </div><!-- /.content -->
</div><!-- /.wrap -->
<?php
echo (new \Component\Footer())->render();
wp_footer();
?>
</body>
</html>
