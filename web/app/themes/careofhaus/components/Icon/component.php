<?php

namespace Component;

class Icon extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.icon', 'components'),
            'classes' => 'icon-component',
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/icon.png',
            'admin_enqueue_js' => array(get_stylesheet_directory_uri() . '/components/Icon/_enableSelect2onVCSelect.js'),
            'admin_enqueue_css' => array(get_stylesheet_directory_uri() . '/dist/style.css'),
            'params' => [
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.icon', 'components'),
                    'param_name' => 'icon',
                    'value' => $this->loadIconFieldChoices(),
                    'admin_label' => false,
                ],
                [
                    'type' => 'textfield',
                    'heading' => __('admin.text.subtitle', 'components'),
                    'param_name' => 'subtitle',
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
                    'heading' => __('admin.text.color', 'components'),
                    'admin_label' => true,
                    'param_name' => 'color',
                    'value' => [
                        __('admin.text.color.brand', 'components') => 'color--brand',
                        __('admin.text.color.brand-darker', 'components') => 'color--brand-primary-darker',
                        __('admin.text.color.gray', 'components') => 'color--gray',
                        __('admin.text.color.white', 'components') => 'color--white',
                    ],
                    'std' => 'color--brand',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.heading.align', 'components'),
                    'admin_label' => true,
                    'param_name' => 'align',
                    'value' => [
                        __('admin.text.align.left', 'components') => 'align-left',
                        __('admin.text.align.center', 'components') => 'align-center',
                        __('admin.text.align.right', 'components') => 'align-right',
                    ],
                    'std' => 'align-center',
                ],
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.size', 'components'),
                    'admin_label' => true,
                    'param_name' => 'size',
                    'value' => [
                        __('admin.text.size.small', 'components') => 'small',
                        __('admin.text.size.medium', 'components') => 'medium',
                        __('admin.text.size.large', 'components') => 'large',
                    ],
                    'std' => 'small-hexagon',
                ],
            ],

        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['link'] = new \DigitalUnited\Components\Link($data['link']);

        return $data;
    }

    public function loadIconFieldChoices()
    {
        $options = [];

        $iconsFile = get_stylesheet_directory() . '/dist/selection.json';
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

    protected function getExtraWrapperClasses()
    {
        return [$this->param('align'), $this->param('size'), $this->param('show_hexagon') ? 'show-hexagon' : '', $this->param('bg_color')];
    }

}
