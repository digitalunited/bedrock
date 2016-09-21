<?php
namespace Component;

class ImageSlider extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.imageslider', 'components'),
            'show_settings_on_create' => true,
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/image_slider.png',
            'params' => [
                [
                    'type' => 'attach_images',
                    'admin_label' => false,
                    'heading' => __('admin.text.imageslider.images', 'components'),
                    'param_name' => 'image_ids',
                ],
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        return $data;
    }

    public function getImageUrls()
    {
        $image_ids = explode(',', $this->param('image_ids'));

        $return = [];
        foreach ($image_ids as $image_id) {
            $image = wp_get_attachment_image_src($image_id, 'large');
            $return[] = $image[0];
        }

        return $return;
    }
}
