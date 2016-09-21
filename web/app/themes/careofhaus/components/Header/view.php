<div class="component-header__banner">
    <div class="site-logo site-logo--left">
        <a href="<?= esc_url(home_url('/')); ?>">
            <h3>Site logo</h3>
        </a>
    </div>
    <h1 class="text-center">Header</h1>

    <?php /*
 Custom WPML Switcher
    <div class="language-switcher">
        <?php
        if (!empty($languages)) {
            foreach ($languages as $language) {
                if (!$language['active'])
                {
                    echo '<a href="' . $language['url'] . '">';
                    echo '<span class="icon icon-flag"></span>' . $language['translated_name'];
                    echo '</a>';
                }
            }
        }
        ?>
    </div>
    */
    ?>
</div>

<div class="component-header__navigation">
    <div class="container">
        <nav class="navigation navigation--primary" role="navigation">
            <?php
            if (has_nav_menu('primary_navigation')) :
                wp_nav_menu([
                    'depth' => 1,
                    'theme_location' => 'primary_navigation',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                ]);
            endif;
            ?>
        </nav>
        <nav class="navigation navigation--secondary" role="navigation">
            <?php
            if (has_nav_menu('secondary_navigation')) :
                wp_nav_menu([
                    'theme_location' => 'secondary_navigation',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                ]);
            endif;
            ?>
        </nav>
    </div>
</div>
