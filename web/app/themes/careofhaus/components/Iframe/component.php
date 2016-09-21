<?php
namespace Component;

class Iframe extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.iframe', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/html.png',
            'params' => [
                [
                    'type' => 'textfield',
                    'holder' => '',
                    'admin_label' => false,
                    'class' => '',
                    'heading' => __('admin.text.url', 'components'),
                    'param_name' => 'iframeurl',
                    'value' => '',
                ],
                [
                    'type' => 'textfield',
                    'holder' => '',
                    'class' => '',
                    'heading' => __('admin.text.height.px', 'components'),
                    'admin_label' => false,
                    'param_name' => 'height',
                    'value' => '',
                    'description' => ''
                ],
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['height'] = $this->sanetizeHeight($data['height']);

        return $data;
    }

    protected function sanetizeHeight($heightInSomeFormat)
    {
        return preg_replace('/[^0-9]/', '', $heightInSomeFormat);
    }
}
