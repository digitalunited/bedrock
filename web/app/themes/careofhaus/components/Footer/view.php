<div class="component-footer__top">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <nav class="navigation navigation--footer" role="navigation">
                    <?php
                    if (has_nav_menu('footer_navigation')) :
                        wp_nav_menu([
                            'theme_location' => 'footer_navigation'
                        ]);
                    endif;
                    ?>
                </nav>
            </div>
            <div class="col-xs-6">
            </div>
            <div class="col-xs-12 component-footer__meta">
                <h1 class="text-center">Footer</h1>
            </div>
        </div>
    </div>
</div>

<a class="component-footer__bottom to-the-top" href="#top">
    <div class="container">
        <span>
            <i class="icon icon-long-arrow-up"></i><?= __('to.the.top', 'components'); ?>
        </span>
    </div>
</a>
