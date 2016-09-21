<?php
/*
 * Overrides vc_text module
 */
namespace Component;

class GravityForms extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [
            'id' => 0,
            'display_title' => false,
            'display_description' => false,
            'display_inactive' => false,
            'ajax' => true,
            'tabindex' => -1,
            'field_values' => false,
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $this->checkId();

        return $data;
    }

    public function main()
    {
        add_filter('gform_tabindex', '__return_false');
        add_filter('gform_confirmation_anchor', '__return_true');
        add_action('init', array(&$this, 'remapVc'));
    }

    private function checkId()
    {
        if (empty($this->param('id'))) {
            throw new \Exception('Param id is not set for usage of GravityForm shortcode');
        }
    }

    public function remapVc()
    {
        if (function_exists('vc_map_update')) {
            \vc_map_update('gravityform', [
                'name' => __('component.name.gravityforms', 'components'),
                'description' => __('admin.text.gravityforms.desc', 'components'),
                'category' => __('component.category.additional', 'components'),
            ]);
        }
    }
}
