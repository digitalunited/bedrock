<?php

//-------------------------------------------------------------------------------
//  Custom Post Type
//-------------------------------------------------------------------------------
function register_contact_post_type()
{
    // Register Contact post type
    $labels = [
        'name' => __('post-type.contact.name', 'components'),
        'singular_name' => __('post-type.contact.name.singular', 'components'),
        'add_new' => __('post-type.contact.add_new', 'components'),
        'add_new_item' => __('post-type.contact.add_new_item', 'components'),
        'all_items' => __('post-type.contact.all_items', 'components'),
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
        'taxonomies' => array('contact_department'),
        'rewrite' => ['slug' => 'kontakter', 'with_front' => true],
        'query_var' => true,
        'supports' => ['title', 'revisions', 'page-attributes'],
        'menu_icon' => 'dashicons-groups'
    ];
    register_post_type('contact', $args);

    $labels = array(
        'name' => __('taxonomy.contact_department.name', 'components'),
        'singular_name' => __('taxonomy.contact_department.name.singular', 'components'),
        'all_items' => __('taxonomy.contact_department.all_items', 'components'),
        'edit_item' => __('taxonomy.contact_department.edit_item', 'components'),
        'update_item' => __('taxonomy.contact_department.update_item', 'components'),
        'add_new_item' => __('taxonomy.contact_department.add_new_item', 'components'),
        'new_item_name' => __('taxonomy.contact_department.new_item_name', 'components'),
        'menu_name' => __('taxonomy.contact_department.menu_name', 'components'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'menu_position' => 1,
    );
    register_taxonomy('contact_department', 'contact', $args);

    add_filter('manage_edit-contact_columns', 'add_new_gallery_columns');
    function add_new_gallery_columns($defaults)
    {
        unset($defaults['date']);
        $defaults['department'] = 'Department';

        return $defaults;
    }
}

add_action('init', 'register_contact_post_type');

add_action('manage_contact_posts_custom_column', 'contact_table_content', 10, 2);
function contact_table_content($column_name, $post_id)
{
    if ($column_name == 'department') {
        $department = wp_get_post_terms($post_id, 'contact_department', ['fields' => 'names']);
        echo $department ? implode(', ', $department) : '';
    }
}
