<?php
namespace Component;

class FAQList extends \DigitalUnited\Components\VcComponent
{
    public $classes;

    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.faq.list.name', 'components'),
            'icon' => 'icon-wpb-toggle-small-expand',
            'params' => [
                [
                    "type" => "dropdown",
                    "heading" => __('admin.component.faq.categories', 'components'),
                    "param_name" => "faq_category",
                    "value" => $this->getFAQCategories(),
                ],
                [
                    "type" => "textfield",
                    "heading" => __('component.faq.max.entries.per.category', 'components'),
                    "param_name" => "max_posts_per_category",
                    "admin_label" => true,
                    "value" => '5',
                ],
            ]
        ];
    }

    private function getFAQCategories()
    {
        global $wpdb;

        $categories = $wpdb->get_results($wpdb->prepare(
            "SELECT term_id, $wpdb->terms.name FROM $wpdb->terms INNER JOIN $wpdb->term_taxonomy USING (term_id) WHERE taxonomy = %s"
            , 'faq_category'));

        $return = array_map(function ($category) {
            return [
                'id' => $category->term_id,
                'name' => $category->name
            ];
        }, $categories);
        unset($categories);

        return $return;
    }

    private function getQuestions()
    {
        $term_id = $this->param('faq_category');
        $limit = $this->param('max_posts_per_category');
        $args = [
            'post_type' => 'faq',
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'order' => 'DESC',
            'orderby' => 'menu_order',
            'tax_query' => [
                [
                    'taxonomy' => 'faq_category',
                    'field' => 'term_id',
                    'terms' => $term_id
                ]
            ]
        ];
        $questions = new \WP_Query($args);

        return $questions->posts;
    }

    private function getCategoryName($term_id)
    {
        $term = get_term($term_id);

        return $term->name;
    }

    public function sanetizeDataForRendering($data)
    {
        $data['faq_posts'] = $this->getQuestions();
        $data['faq_category_name'] = $this->getCategoryName($this->param('faq_category'));

        return $data;
    }
}
