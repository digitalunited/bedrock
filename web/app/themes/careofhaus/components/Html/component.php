<?php
namespace Component;

class Html extends \DigitalUnited\Components\Component
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
            \vc_map_update('vc_raw_html', [
                'name' => __('component.name.html', 'components'),
                'description' => __('admin.text.html.desc', 'components'),
                'category' => __('component.category.additional', 'components'),
                'icon' => get_stylesheet_directory_uri() . '/dist/icons/html.png',
                'params' => [
                    [
                        'type' => 'textarea_raw_html',
                        'holder' => 'div',
                        'heading' => __('Raw HTML', 'js_composer'),
                        'param_name' => 'content',
                        'value' => base64_encode('<p>I am raw html block.<br/>Click edit button to change this html</p>'),
                        'description' => __('Enter your HTML content.', 'js_composer'),
                    ],
                ]
            ]);
        }
    }
}
