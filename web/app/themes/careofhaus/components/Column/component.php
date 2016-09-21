<?php
/*
 * Fixes column module
 */
namespace Component;

class Column extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [];
    }

    public function main()
    {
        add_action('init', array(&$this, 'remapVcColumn'));
    }

    public function remapVcColumn()
    {
        if (class_exists('WPBMap')) {
            $vcColumn = \WPBMap::getShortCode('vc_column');

            $vcColumn['params'][] = [
                'type' => 'dropdown',
                'heading' => __('admin.text.bg.column.color', 'components'),
                'param_name' => 'column_bg_color',
                'group' => __('admin.text.tab.background', 'components'),
                'value' => [
                    __('admin.text.bg.color.transparent', 'components') => 'transparent',
                    __('admin.text.bg.color.white', 'components') => 'column-bg--white',
                    __('admin.text.bg.color.gray', 'components') => 'column-bg--gray',
                    __('admin.text.bg.color.brand', 'components') => 'column-bg--brand',
                ],
                'std' => 'transparent',
            ];

            //VC doesn't like even the thought of you changing the shortcode base, and errors out, so we unset it.
            unset($vcColumn['base']);
        }
        if (function_exists('vc_map_update')) {
            vc_map_update('vc_column', $vcColumn);
        }
    }
}
