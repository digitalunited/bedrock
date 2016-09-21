<?php
namespace Component;

class ButtonLink extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.link.button', 'components'),
            'category' => __('component.category.buttons', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/link.png',
            'weight' => 93,
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
                    'class' => '',
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
                    'std' => 'align-left',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.arrow', 'components'),
                    'admin_label' => false,
                    'param_name' => 'arrow',
                    'value' => [
                        __('admin.text.right.arrow', 'components') => 'icon-round-arrow-right',
                        __('admin.text.left.arrow', 'components') => 'icon-round-arrow-left',
                    ],
                    'std' => 'icon-round-arrow-right',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.arrow.position', 'components'),
                    'admin_label' => false,
                    'param_name' => 'arrow_position',
                    'value' => [
                        __('admin.text.left', 'components') => 'arrow--leftside',
                        __('admin.text.right', 'components') => 'arrow--rightside',
                    ],
                    'std' => 'arrow--leftside',
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
        return ['component-button'];
    }
}
