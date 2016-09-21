<?php

namespace Roots\Sage\Assets;

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/dist/styles/main.css
 *
 * Enqueue scripts in the following order:
 * 1. /theme/dist/scripts/modernizr.js
 * 2. /theme/dist/scripts/main.js
 */

class JsonManifest
{
  private $manifest;

  public function __construct($manifest_path)
  {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get()
  {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null)
  {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }

    return $collection;
  }
}

function asset_path($filename)
{
  $dist_path = get_stylesheet_directory_uri() . DIST_DIR;
  $directory = dirname($filename) !== '.' ? dirname($filename) . '/' : '';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_stylesheet_directory() . DIST_DIR . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

function assets()
{
  wp_enqueue_style('sage_css', asset_path('main.css'), false, null);

  wp_enqueue_script('sage_js', asset_path('main.js'), ['jquery'], null, true);
  wp_localize_script('sage_js', 'urls', [
      'ajaxurl' => admin_url('admin-ajax.php'),
  ]);
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
