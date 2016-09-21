<?php

namespace Component;

class Ingress extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.ingress', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/ingress.png',
            'category' => __('component.category.content', 'components'),
            'weight' => 97,
            'params' => [
                [
                    'type' => 'textarea',
                    'admin_label' => false,
                    'heading' => __('admin.text.text', 'components'),
                    'param_name' => 'text',
                    'value' => '',
                ],
                [
                    'type' => 'dropdown',
                    'holder' => '',
                    'heading' => __('admin.text.align', 'components'),
                    'admin_label' => true,
                    'param_name' => 'align',
                    'value' => [
                        __('admin.text.align.left', 'components') => 'lead-left',
                        __('admin.text.align.center', 'components') => 'lead-center',
                        __('admin.text.align.right', 'components') => 'lead-right',
                    ],
                    'std' => 'lead-center',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.color', 'components'),
                    'admin_label' => true,
                    'param_name' => 'color',
                    'value' => [
                        __('admin.text.color.brand.light', 'components') => 'color--brand-light',
                        __('admin.text.color.brand', 'components') => 'color--brand',
                        __('admin.text.color.white', 'components') => 'color--white',
                    ],
                    'std' => 'color--brand',
                ],
            ],
        ];
    }
}
