<?php
namespace Component;

class Text extends \DigitalUnited\Components\Component
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
            \vc_map_update('vc_column_text', [
                'name' => __('component.name.text', 'components'),
                'description' => __('admin.text.desc', 'components'),
                'category' => __('component.category.content', 'components'),
                'weight' => 96,
                'icon' => get_stylesheet_directory_uri() . '/dist/icons/text.png',
                'params' => [
                    [
                        'type' => 'textarea_html',
                        'holder' => 'div',
                        'heading' => __('Text', 'js_composer'),
                        'param_name' => 'content',
                        'value' => __('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer')
                    ]
                ],
            ]);
        }
    }
}
