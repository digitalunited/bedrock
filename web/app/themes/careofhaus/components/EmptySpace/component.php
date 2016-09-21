<?php
namespace Component;

class EmptySpace extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        return [];
    }

    public function main()
    {
        add_action('init', array(&$this, 'remapVc'));
    }

    public function remapVc()
    {
        if (function_exists('vc_map_update')) {
            \vc_map_update('vc_empty_space', [
                'name' => __('component.name.empty.space', 'components'),
                'description' => __('admin.desc.empty.space', 'components'),
                'category' => __('component.category.content', 'components'),
                'icon' => get_stylesheet_directory_uri() . '/dist/icons/empty_space.png',
                'weight' => 92,
                'params' => [
                    [
                        'type' => 'textfield',
                        'heading' => __('component.empty.space.height', 'components'),
                        'param_name' => 'height',
                        'value' => '20px',
                        'admin_label' => true,
                        'description' => __('component.desc.empty.space', 'components'),
                    ],
                    [
                        'type' => 'textfield',
                        'heading' => __('extra.class.name', 'components'),
                        'param_name' => 'el_class',
                        'description' => __('extra.class.name.desc', 'components'),
                    ],
                ],
            ]);
        }
    }
}
