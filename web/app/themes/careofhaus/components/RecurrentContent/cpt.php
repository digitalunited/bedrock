<?php

//-------------------------------------------------------------------------------
//  Custom Post Type
//-------------------------------------------------------------------------------
function register_recureent_content_post_type()
{
    // Register Static Content post type
    $labels = [
        'name' => __('post-type.recurrent.content.name', 'components'),
        'all_items' => __('post-type.recurrent.content.all.items', 'components'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'has_archive' => false,
        'show_in_menu' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => false,
        'menu_icon' => 'dashicons-update'
    ];
    register_post_type('recurrent_content', $args);
}

add_action('init', 'register_recureent_content_post_type');


