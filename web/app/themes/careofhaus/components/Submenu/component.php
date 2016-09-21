<?php
namespace Component;

class SubMenu extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return ['children' => []];
    }

    private function _get_children($parent_id, $items, $depth = true)
    {
        $itemList = array();
        foreach ((array) $items as $item) {
            if ($item->menu_item_parent == $parent_id) {
                $itemList[] = $item;
                if ($depth) {
                    if ($children = $this->_get_children($item->ID, $items)) {
                        $itemList = array_merge($itemList, $children);
                    }
                }
            }
        }

        return $itemList;
    }

    public function getMenu()
    {
        $arrSelected = $this->getActiveMenuItems();
        if (!$arrSelected) {
            return false;
        }

        $selectedHeaderPostID = $this->_getTopParentID($arrSelected);
        $children = $this->_get_children($selectedHeaderPostID, wp_get_nav_menu_items('Primary Menu'));

        return array_map(function ($child) {
            return [
                'url' => $child->url,
                'title' => $child->title,
                'id' => $child->ID,
            ];
        }, $children);
    }

    private function _getTopParentID($arrPosts)
    {
        $tmp = [];
        foreach ($arrPosts as $menuItem) {
            $tmp[] = (isset($menuItem->menu_item_parent) && $menuItem->menu_item_parent != '0') ? $menuItem->menu_item_parent : $menuItem->ID;
        }
        $mainMenuActiveID = array_unique($tmp);
        if (count($mainMenuActiveID) > 1) {
            return false;
        }

        return $mainMenuActiveID[0];
    }

    public function getActiveMenuItems()
    {
        $post = get_post();
        if (!$post) {
            return false;
        }
        $active = wp_get_nav_menu_items('Primary Menu', [
            'posts_per_page' => -1,
            'meta_key' => '_menu_item_object_id',
            'meta_value' => $post->ID,
        ]);

        if (empty($active)) {
            // we did not find our parent in the top menu ..
            // find grandfather or his parent....
            $active = $this->getActiveMenuParent($post);
        }

        return isset($active) ? $active : false;
    }

    public function getActiveMenuItemIds()
    {
        $posts = $this->getActiveMenuItems();
        $return = [];
        foreach ($posts as $post) {
            $return[] = $post->ID;
        }

        return $return;
    }

    public function getActiveMenuItemTitle()
    {
        $posts = $this->getActiveMenuItems();
        $return = [];
        foreach ($posts as $post) {
            $return[] = $post->title;
        }

        return $return;
    }

    private function getActiveMenuParent($childPost = false)
    {
        if (!$childPost) {
            $childPost = get_post();
        }

        if ($childPost->post_parent === 0) {
            return false;
        }

        $activeParent = wp_get_nav_menu_items('Primary Menu', [
            'posts_per_page' => -1,
            'meta_key' => '_menu_item_object_id',
            'meta_value' => $childPost->post_parent,
        ]);

        if (empty($activeParent)) {
            $post = get_post($childPost->post_parent);

            return $this->getActiveMenuParent($post);
        }

        return $activeParent;
    }
}
