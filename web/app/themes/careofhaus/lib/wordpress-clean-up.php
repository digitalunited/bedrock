<?php

// Changes the footer text inside WordPress Admin.
function replace_footer_admin() {
  echo '<span id="footer-thankyou">Developed and designed by <a href="http://www.careofhaus.se" target="_blank">Care of Haus</a></span>';
}

add_filter('admin_footer_text', 'replace_footer_admin');

// Removes unnecessary items from the admin bar
function remove_nodes($wp_admin_bar) {
  $wp_admin_bar->remove_node('wp-logo');
  $wp_admin_bar->remove_node('search');
  $wp_admin_bar->remove_node('themes');
  $wp_admin_bar->remove_node('customize');
  $wp_admin_bar->remove_node('view-site');
  $wp_admin_bar->remove_node('dashboard');
  $wp_admin_bar->remove_node('appearance');
  $wp_admin_bar->remove_node('menus');
  $wp_admin_bar->remove_node('new-user');
}

add_action('admin_bar_menu', 'remove_nodes', 999);

// Remove the update notice for users
function remove_updates() {
  remove_action('admin_notices', 'update_nag', 3);
}

add_action('admin_menu', 'remove_updates', 999);

// Changes the url of the WordPress logo when your logged out.
function change_login_url() {
  return get_bloginfo('url');
}

add_filter('login_headerurl', 'change_login_url');

function change_login_title() {
  return get_bloginfo('name');
}

add_filter('login_headertitle', 'change_login_title');

// Remove the rest API from WordPress
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

// Remove visual composer scripts
function remove_visual_composer_script() {
  wp_deregister_script('wpb_composer_front_js');
}

add_action('wp_enqueue_scripts', 'remove_visual_composer_script');

// Load GravityForm scripts in footer
add_filter('gform_init_scripts_footer', '__return_true');

add_filter('gform_cdata_open', 'wrap_gform_cdata_open');
function wrap_gform_cdata_open($content = '') {
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';

  return $content;
}

add_filter('gform_cdata_close', 'wrap_gform_cdata_close');
function wrap_gform_cdata_close($content = '') {
  $content = ' }, false );';

  return $content;
}
