<?php

namespace Roots\Sage\Init;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('components', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus


  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');


  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);


  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style(Assets\asset_path('editor-style.css'));
}

add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
      'name' => __('Footer', 'components'),
      'id' => 'sidebar-footer',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
  ]);
}

add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');
