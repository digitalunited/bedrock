<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?= get_stylesheet_directory_uri(); ?>/favicon.ico?1">
  <?php wp_head(); ?>
  <?php if (is_admin_bar_showing()) { ?>
    <style>
      /* Pushes down the menu under the admin bar. */
      @media (min-width: 782px) {
        .component-sidebarmenu, .component-header {
          border-top: 32px solid #222 !important;
        }
      }
      @media (max-width: 782px) {
        .component-sidebarmenu, .component-header {
          border-top: 46px solid #222 !important;
        }
      }
    </style>
  <?php } ?>
</head>
