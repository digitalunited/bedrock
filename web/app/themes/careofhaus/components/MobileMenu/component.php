<?php
namespace Component;

class MobileMenu extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [];
    }

    protected function sanetizeDataForRendering($data)
    {
        return $data;
    }

    public function main()
    {
        register_nav_menus([
            'mobile_hamburger_navigation' => 'Mobile Hamburger Navigation'
        ]);

        require_once('mobile_navwalker.php');
    }
}
