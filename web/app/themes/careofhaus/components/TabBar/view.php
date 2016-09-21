<div class="component-tabbar__more">
    <nav class="navigation navigation--mobile" role="navigation">
        <?php
        if (has_nav_menu('mobile_navigation')) :
            wp_nav_menu([
                'theme_location' => 'mobile_navigation',
            ]);
        endif;
        ?>
    </nav>
</div>
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
