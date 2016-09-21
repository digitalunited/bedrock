<?php
namespace Component;

class GoogleMaps extends \DigitalUnited\Components\Component
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
            \vc_map_update('vc_gmaps', [
                'name' => __('component.name.google.maps', 'components'),
                "description" => __("admin.text.google.maps.desc", "components"),
                'category' => __('component.category.additional', 'components'),
                'icon' => get_stylesheet_directory_uri() . '/dist/icons/google_maps.png',
                "params" => [
                    [
                        'type' => 'textarea_safe',
                        'heading' => __('admin.text.google.maps.iframe.link', 'components'),
                        'param_name' => 'link',
                        'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6304.829986131271!2d-122.4746968033092!3d37.80374752160443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808586e6302615a1%3A0x86bd130251757c00!2sStorey+Ave%2C+San+Francisco%2C+CA+94129!5e0!3m2!1sen!2sus!4v1435826432051" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
                        'description' => sprintf(__('Visit %s to create your map (Step by step: 1) Find location 2) Click the cog symbol in the lower right corner and select "Share or embed map" 3) On modal window select "Embed map" 4) Copy iframe code and paste it).'), '<a href="https://www.google.com/maps" target="_blank">' . __('Google maps', 'js_composer') . '</a>'),
                    ],
                    [
                        'type' => 'textfield',
                        'heading' => __('admin.text.google.maps.height', 'components'),
                        'param_name' => 'size',
                        'admin_label' => true,
                        'description' => __('Enter map height (in pixels or leave empty for responsive map).', 'components'),
                    ],
                ],
            ]);
        }
    }
}
