<?php
namespace Component;

class Slider extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.slider', 'components'),
            'params' => [
                [
                    "type" => "dropdown",
                    "admin_label" => true,
                    "heading" => __("admin.text.slide.category", "components"),
                    "param_name" => "slide_category",
                    "value" => $this->getSlideTerms(),
                    "description" => __("admin.text.choose.slide.category", "components"),
                ],
                [
                    "type" => "checkbox",
                    "admin_label" => true,
                    "heading" => __("admin.text.slide.show_dots", "components"),
                    "param_name" => "show_dots",
                    "value" => ''
                ],
                [
                    "type" => "checkbox",
                    "admin_label" => true,
                    "heading" => __("admin.text.slide.show_arrows", "components"),
                    "param_name" => "show_arrows",
                    "value" => ''
                ],
            ],
        ];
    }

    public function main()
    {
        require_once('cpt.php');
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['slides'] = $this->getSlides();

        return $data;
    }

    protected function getSlideTerms()
    {
        $return = ['Välj en kampanjyta' => ''];

        global $wpdb;

        $sql = "SELECT * FROM wp_terms";
        $sql .= " JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id";
        $sql .= " WHERE wp_term_taxonomy.taxonomy = 'slider_category'";

        $results = $wpdb->get_results($sql);

        foreach ($results as $result) {
            $return[$result->name] = $result->slug;
        }

        return $return;
    }

    private function getSlides()
    {
        $args = [
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'post_type' => 'slider',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'slider_category',
                    'field' => 'id',
                    'terms' => $this->param('slide_category')
                ]
            ]
        ];

        return get_posts($args);
    }

    protected function getExtraWrapperClasses()
    {
        $classes = [];
        if (!empty($this->param('show_dots'))) {
            $classes[] = 'show-dots';
        };
        if (!empty($this->param('show_arrows'))) {
            $classes[] = 'show-arrows';
        };

        return $classes;
    }

}
