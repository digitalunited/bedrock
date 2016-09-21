<?php
$activeMenuItemsIds = $component->getActiveMenuItemIds();
$activeMenuItemsTitle = $component->getActiveMenuItemTitle();
$menuitems = $component->getMenu();
if (isset($menuitems) && is_array($menuitems)) {
    ?>
    <div class="container">
        <div class="navigation-select visible-xs">
            <?= (end($activeMenuItemsTitle)); ?>
            <span class="icon icon-round-arrow-down"></span>
        </div>
        <nav class="navigation" role="navigation">
            <ul>
                <?php foreach ($menuitems as $menuitem) {
                    $active = in_array($menuitem['id'], $activeMenuItemsIds) ? ' active' : ''; ?>
                    <li class="submenu-item<?= $active ?>"><a
                            href="<?= $menuitem['url'] ?>"><span><?= $menuitem['title'] ?></span></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
<?php } ?>

