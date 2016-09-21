<?php
/*
 * Overrides vc_text module
 */
namespace Component;

class Row extends \DigitalUnited\Components\Component
{
    static protected $sectionNumber = 1;

    protected function getDefaultParams()
    {
        return [
            'row_type' => 'vc_row',
            'section_bg_image' => '',
            'section_bg_image_fixed' => '',
            'section_bg_color' => '',
            'section_color' => '',
            'column_padding' => '',
            'margin_top' => 'margin-top--none',
            'margin_bottom' => 'margin-bottom--medium',
            'container_type_class' => 'container',
            'full_height' => ''
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $row_class = \vc_manager()->settings()->get('row_css_class') ?: 'vc_row-fluid';
        $data['row_css_class'] = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ($data['row_type'] === 'vc_row_inner' ? 'vc_inner ' : '') . $row_class, $data['row_type']);

        $data['row_id'] = $this->getrowid();
        $data['content'] = wpb_js_remove_wpautop($data['content']);
        $data['srcset'] = $this->getImageSrcset();

        return $data;
    }

    private function getRowId()
    {
        return 'section-' . self::$sectionNumber++;
    }

    public function main()
    {
        add_action('init', array(&$this, 'remapVc'));
        $this->overrideVcShortcode();
    }

    public function remapVc()
    {
        if (function_exists('vc_map_update')) {
            \vc_map_update('vc_row', [
                'name' => __('component.name.row', 'components'),
                'description' => __('admin.row.desc', 'components'),
                'category' => __('component.category.content', 'components'),
                'weight' => 99,
                'icon' => get_stylesheet_directory_uri() . '/dist/icons/row.png',
                'params' => [
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.container.type', 'components'),
                        'param_name' => 'container_type_class',
                        'group' => __('admin.text.tab.general', 'components'),
                        'value' => [
                            __('admin.text.section.type.container', 'components') => 'container',
                            __('admin.text.section.type.container.fluid.full', 'components') => 'container-fluid-full',
                            __('admin.text.section.type.container.fluid', 'components') => 'container-fluid',
                        ],
                        'std' => 'container',
                    ],
                    [
                        'type' => 'checkbox',
                        'heading' => __('admin.text.section.full.height', 'components'),
                        'param_name' => 'full_height',
                        'group' => __('admin.text.tab.general', 'components'),
                        'value' => [
                            __('admin.text.section.full.height.yes', 'components') => 'full-height',
                        ],
                        'std' => false,
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.bg.section.color', 'components'),
                        'param_name' => 'section_bg_color',
                        'group' => __('admin.text.tab.background', 'components'),
                        'value' => [
                            __('admin.text.bg.color.transparent', 'components') => 'section-bg--transparent',
                            __('admin.text.bg.color.white', 'components') => 'section-bg--white',
                            __('admin.text.bg.color.gray', 'components') => 'section-bg--gray',
                            __('admin.text.bg.color.brand', 'components') => 'section-bg--brand',
                        ],
                        'std' => 'section-bg--transparent',
                    ],
                    [
                        'type' => 'attach_image',
                        'heading' => __('admin.text.background.image', 'components'),
                        'param_name' => 'section_bg_image',
                        'group' => __('admin.text.tab.background', 'components'),
                    ],
                    [
                        'type' => 'checkbox',
                        'heading' => __('admin.text.background.image.fixed', 'components'),
                        'param_name' => 'section_bg_image_fixed',
                        'group' => __('admin.text.tab.background', 'components'),
                        'value' => [
                            __('admin.text.yes', 'components') => 'bg-fixed',
                        ],
                        'std' => false,
                        'dependency' => [
                            'element' => 'section_bg_image',
                            'not_empty' => true,
                        ],
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.section.color', 'components'),
                        'param_name' => 'section_color',
                        'group' => __('admin.text.tab.background', 'components'),
                        'value' => [
                            __('admin.text.color.standard', 'components') => 'section-color--standard',
                            __('admin.text.color.white', 'components') => 'section-color--white',
                        ],
                        'std' => 'section-color--standard'
                    ],
                    [
                        'type' => 'checkbox',
                        'heading' => __('admin.text.column.padding', 'components'),
                        'param_name' => 'column_padding',
                        'group' => __('admin.text.tab.marginals', 'components'),
                        'value' => [
                            __('admin.text.no.column.padding', 'components') => 'no-column-padding',
                        ],
                        'std' => false,
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.margin.top', 'components'),
                        'param_name' => 'margin_top',
                        'group' => __('admin.text.tab.marginals', 'components'),
                        'value' => [
                            __('admin.text.margin.top.none', 'components') => 'margin-top--none',
                            __('admin.text.margin.top.small', 'components') => 'margin-top--small',
                            __('admin.text.margin.top.medium', 'components') => 'margin-top--medium',
                            __('admin.text.margin.top.large', 'components') => 'margin-top--large',
                        ],
                        'std' => 'margin-top--none',
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.margin.bottom', 'components'),
                        'param_name' => 'margin_bottom',
                        'group' => __('admin.text.tab.marginals', 'components'),
                        'value' => [
                            __('admin.text.margin.bottom.none', 'components') => 'margin-bottom--none',
                            __('admin.text.margin.bottom.small', 'components') => 'margin-bottom--small',
                            __('admin.text.margin.bottom.medium', 'components') => 'margin-bottom--medium',
                            __('admin.text.margin.bottom.large', 'components') => 'margin-bottom--large',
                        ],
                        'std' => 'margin-bottom--medium',
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.responsive.class', 'components'),
                        'param_name' => 'responsive_class',
                        'group' => __('admin.text.tab.responsive', 'components'),
                        'description' => __('admin.text.tab.responsive.desc', 'components'),
                        'value' => [
                            __('admin.text.responsive.class.visible.all', 'components') => '',
                            __('admin.text.responsive.class.hidden.phones', 'components') => 'hidden-xs',
                            __('admin.text.responsive.class.hidden.tablets', 'components') => 'hidden-sm',
                            __('admin.text.responsive.class.hidden.desktop', 'components') => 'hidden-md',
                            __('admin.text.responsive.class.hidden.large.desktop', 'components') => 'hidden-lg',
                            __('admin.text.responsive.class.visible.phones', 'components') => 'visible-xs',
                            __('admin.text.responsive.class.visible.tablets', 'components') => 'visible-sm',
                            __('admin.text.responsive.class.visible.desktop', 'components') => 'visible-md',
                            __('admin.text.responsive.class.visible.large.desktop', 'components') => 'visible-lg',
                        ],
                        'std' => '',
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('admin.text.animations', 'components'),
                        'param_name' => 'animations',
                        'group' => __('admin.text.tab.animations', 'components'),
                        'description' => __('admin.text.tab.animations.desc', 'components'),
                        'value' => [
                            __('admin.text.animation.none', 'components') => '',
                            __('admin.text.animation.fade.in', 'components') => 'fade-in',
                        ],
                        'std' => '',
                    ],
                ],
            ]);

            \vc_map_update('vc_row_inner', [
                'params' => []
            ]);
        }
    }

    private function overrideVcShortcode()
    {
        add_shortcode('vc_row', function ($atts, $content) {
            $atts['row_type'] = 'vc_row';

            return (new self($atts, $content))->render();
        });

        add_shortcode('vc_row_inner', function ($atts, $content) {
            $atts['row_type'] = 'vc_row_inner';

            return (new self($atts, $content))->render();
        });
    }

    private function getImageSrcset()
    {
        $image_id = $this->param('section_bg_image');
        $srcset = $image_id ? \DigitalUnited\ResponsiveImage::render([
            'imgId' => $image_id,
            'output' => 'srcset',
        ]) : '';

        return $srcset;
    }

    protected function getExtraWrapperClasses()
    {
        return [$this->param('responsive_class'), $this->param('animations')];
    }
}
