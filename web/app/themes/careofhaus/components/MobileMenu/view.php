<div class="nav-controls lvl-1" data-lvl="1">
    <a href="#" class="mobile-back" id="mobile-back"><span class="icon icon-chevron-left"></span> <?= __('mobile-menu.back', 'components') ?>
    </a>
    <div class="site-logo">
        <a href="<?= esc_url(home_url('/')); ?>">
            <?= file_get_contents(get_stylesheet_directory() . "/dist/logo.svg"); ?>
        </a>
    </div>
    <a href="#" class="toggle-navigation" id="toggle-navigation">
        <span class="helper helper--open"><?= __('menu', 'components') ?></span>
        <span class="helper helper--close"><?= __('close', 'components') ?></span>
        <span class="icon icon-hamburger"></span>
        <span class="sr-only"><?= __('mobile-menu.toggle', 'components') ?></span>
    </a>
</div>
<nav class="main-nav">
    <div class="inner">
        <div class="lvl-1" id="counter" data-lvl="1">
            <?php if (has_nav_menu('mobile_hamburger_navigation')) {
                wp_nav_menu([
                    'depth' => 5,
                    'theme_location' => 'mobile_hamburger_navigation',
                    'walker' => new \mobile_navwalker()
                ]);
            }
            ?>
            <!--          <div class="extra-links">-->
            <!--            <a class="search link--icon"><i class="icon icon-search"></i>--><? //= __('search', 'components') ?><!--</a>-->
            <!--            <a class="login link--icon"><i class="icon icon-lock"></i>--><? //= __('login', 'components') ?><!--</a>-->
            <!--            <form class="search-wrapper">-->
            <!--              <input type="search" name="search" id="search" class="form-control" placeholder="Sök på...">-->
            <!--              <a class="btn btn--top">Sök</a>-->
            <!--            </form>-->
            <!--          </div>-->
        </div>
    </div>
</nav>
