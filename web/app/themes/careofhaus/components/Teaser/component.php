<?php
namespace Component;

class Teaser extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.teaser', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/teaser.png',
            'admin_enqueue_js' => array(get_template_directory_uri() . '/components/Icon/_enableSelect2onVCSelect.js'),
            'admin_enqueue_css' => array(get_template_directory_uri() . '/dist/style.css'),
            'params' => [
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.theme', 'components'),
                    'param_name' => 'theme',
                    'value' => [
                        __('admin.text.color.brand', 'components') => 'theme--brand',
                        __('admin.text.color.brand.accent.blue', 'components') => 'theme--blue',
                    ],
                    'std' => 'theme--brand',
                ],
                [
                    'type' => 'textfield',
                    'heading' => __('admin.text.headline', 'components'),
                    'param_name' => 'heading',
                ],
                [
                    'type' => 'checkbox',
                    'heading' => __('admin.text.show.icon', 'components'),
                    'param_name' => 'show_icon',
                    'value' => [
                        __('admin.text.yes', 'components') => 'show-icon',
                    ],
                    'std' => true,
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.icon', 'components'),
                    'param_name' => 'icon',
                    'value' => $this->loadIconFieldChoices(),
                ],
                [
                    'type' => 'vc_link',
                    'admin_label' => false,
                    'heading' => __('admin.text.link', 'components'),
                    'param_name' => 'link',
                ],
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['link'] = $this->getLink();

        return $data;
    }

    protected function getLink()
    {
        return new \DigitalUnited\Components\Link($this->param('link'));
    }

    protected function getWrapperElementType()
    {
        return 'a';
    }

    protected function getWrapperAttributes()
    {
        $link = $this->getLink();

        return ['href' => $link->url];
    }

    public function loadIconFieldChoices()
    {
        $options = [];

        $iconsFile = get_template_directory() . '/dist/selection.json';
        if (!file_exists($iconsFile)) {
            return $options;
        }

        $json_data = file_get_contents($iconsFile);
        $json_data = json_decode($json_data, true);

        if (is_array($json_data)) {
            foreach ($json_data['icons'] as $icon) {
                $options[$icon['properties']['name']] = $icon['properties']['name'];
            }
        }

        return $options;
    }
}
