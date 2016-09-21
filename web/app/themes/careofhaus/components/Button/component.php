<?php
namespace Component;

class Button extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.button', 'components'),
            'category' => __('component.category.buttons', 'components'),
            'weight' => 94,
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/button.png',
            'params' => [
                [
                    'type' => 'textfield',
                    'admin_label' => true,
                    'heading' => __('admin.text.button.text', 'components'),
                    'param_name' => 'text',
                    'value' => __('admin.text.link.here', 'components'),
                ],
                [
                    'type' => 'vc_link',
                    'admin_label' => false,
                    'heading' => __('admin.text.link', 'components'),
                    'param_name' => 'link',
                    'value' => '',
                    'description' => __('admin.text.field.may.be.blank', 'components'),
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.position', 'components'),
                    'admin_label' => false,
                    'param_name' => 'theme',
                    'value' => [
                        __('admin.text.left', 'components') => 'align-left',
                        __('admin.text.center', 'components') => 'align-center',
                        __('admin.text.right', 'components') => 'align-right',
                    ],
                    'std' => 'align-center',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.color', 'components'),
                    'admin_label' => true,
                    'param_name' => 'color',
                    'value' => [
                        __('admin.text.color.brand.accent.blue', 'components') => 'btn--blue',
                        __('admin.text.color.brand', 'components') => 'btn--brand',
                    ],
                    'std' => 'btn--blue',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.animations', 'components'),
                    'param_name' => 'animations',
                    'group' => __('admin.text.tab.animations', 'components'),
                    'description' => __('admin.text.tab.animations.desc', 'components'),
                    'value' => [
                        __('admin.text.animation.none', 'components') => '',
                        __('admin.text.animation.fade.in', 'components') => 'fade-in',
                    ],
                    'std' => '',
                ],
            ],
        ];
    }

    protected function SanetizeDataForRendering($data)
    {
        $link = new \DigitalUnited\Components\Link($data['link']);
        $data['text'] = $data['text'] ? $data['text'] : $link->title;
        $data['link'] = new \DigitalUnited\Components\Link($data['link']);

        return $data;
    }

    protected function getExtraWrapperClasses()
    {
        return [$this->param('animations')];
    }
}
