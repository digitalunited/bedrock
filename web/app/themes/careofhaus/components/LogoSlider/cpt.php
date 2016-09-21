<?php

//-------------------------------------------------------------------------------
//  Custom Post Type
//-------------------------------------------------------------------------------

add_action('init', function () {
    $labels = [
        'name' => __('post.type.name.logo.slides', 'components'),
        'singular_name' => __('post.type.name.logo.slides.singular', 'components'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'has_archive' => false,
        'show_in_menu' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'logo_slider', 'with_front' => true],
        'query_var' => true,
        'supports' => ['title', 'revisions', 'page-attributes'],
        'menu_icon' => 'dashicons-images-alt'
    ];

    register_post_type('logo_slider', $args);
});

//-------------------------------------------------------------------------------
//  Custom Columns
//-------------------------------------------------------------------------------

add_filter('manage_edit-logo_slider_columns', function ($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('admin.text.title', 'components'),
        'url' => __('admin.text.url', 'components'),
        'order' => __('admin.text.order', 'components'),
        'thumbnail' => __('admin.text.logo', 'components'),
        'date' => __('admin.text.date', 'components'),
    );

    return $columns;
});

add_action('manage_logo_slider_posts_custom_column', function ($column, $post_id) {
    global $post;

    switch ($column) {
        case 'thumbnail':
            echo wp_get_attachment_image(get_field('image', $post_id), [60, 200]);
            break;
        case 'url':
            echo get_field('url', $post_id);
            break;
        case 'order':
            echo $post->menu_order;
            break;
    }
}, 10, 2);

add_filter("manage_edit-logo_slider_sortable_columns", function ($columns) {
    $columns['order'] = 'order';

    return $columns;
});

