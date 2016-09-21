<?php

//-------------------------------------------------------------------------------
//  Custom Post Type
//-------------------------------------------------------------------------------
function register_slider_post_type_and_taxonomies()
{
    // Register Slider post type
    $labels = [
        'name' => __('post-type.slider.name', 'components'),
        'singular_name' => __('post-type.slider.name.singular', 'components'),
        'add_new' => __('post-type.slider.add_new', 'components'),
        'add_new_item' => __('post-type.slider.add_new_item', 'components'),
        'all_items' => __('post-type.slider.all_items', 'components'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'has_archive' => false,
        'show_in_menu' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => 'dashicons-images-alt2'
    ];
    register_post_type('slider', $args);

    // Register slider category taxonomy
    $labels = array(
        'name' => __('taxonomy.slider_category.name', 'components'),
        'singular_name' => __('taxonomy.slider.name.singular', 'components'),
        'add_new' => __('taxonomy.slider.add_new', 'components'),
        'add_new_item' => __('taxonomy.slider.add_new_item', 'components'),
        'all_items' => __('taxonomy.slider.all_items', 'components'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'menu_position' => 1,
        'public' => false,
        'show_ui' => true,
    );
    register_taxonomy('slider_category', 'slider', $args);
}

add_action('init', 'register_slider_post_type_and_taxonomies');




