<?php

//-------------------------------------------------------------------------------
//  Custom Post Type
//-------------------------------------------------------------------------------
function register_faq_post_type()
{
    // Register Contact post type
    $labels = [
        'name' => __('post-type.faq.name', 'components'),
        'singular_name' => __('post-type.faq.name.singular', 'components'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'has_archive' => true,
        'show_in_menu' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'taxonomies' => array('faq_category'),
        'query_var' => true,
        'supports' => ['title', 'editor', 'revisions', 'page-attributes'],
        'menu_icon' => 'dashicons-groups'
    ];
    register_post_type('faq', $args);

    $args = array(
        'hierarchical' => true,
        'menu_position' => 1,
    );
    register_taxonomy('faq_category', 'faq', $args);

    add_filter('manage_edit-faq_columns', 'add_new_faq_columns');

    function add_new_faq_columns($defaults)
    {
        $defaults['faq_category'] = __('component.faq.faq_category.name', 'components');

        return $defaults;
    }
}

add_action('init', 'register_faq_post_type');

add_action('manage_faq_posts_custom_column', 'faq_table_content', 10, 2);
function faq_table_content($column_name, $post_id)
{
    if ($column_name == 'faq_category') {
        $faq_category = wp_get_post_terms($post_id, 'faq_category', ['fields' => 'names']);
        echo $faq_category ? implode(', ', $faq_category) : '';
    }
}
