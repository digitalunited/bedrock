<?php
global $post;
$post_type = $post->post_type && $post->post_type != 'post'
    ? $post->post_type
    : '';

?>
<?php
$args = array(
    'title_li' => '<h4>' . __('categories', 'components') . '</h4>',
    'show_option_none' => __('no.categories', 'components')
);

if ($post_type) {
    $args['taxonomy'] = $post_type . '-category';
}

wp_list_categories($args);
?>
<h4><?= __('sidebar.yearly.archive.headline', 'components') ?></h4>
<?php
wp_get_archives(['post_type' => $post_type]);
?>
