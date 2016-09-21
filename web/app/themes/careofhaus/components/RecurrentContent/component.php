<?php
namespace Component;

class RecurrentContent extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {

        return [
            'name' => __('component.name.recurrent.content', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/recurrent_content.png',
            'params' => [
                [
                    'type' => 'dropdown',
                    'heading' => __('post-type.recurrent.content.choose', 'components'),
                    'param_name' => 'post_id',
                    'value' => $this->getRecurrentContentPosts(),
                    'std' => '',
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
        $data['content'] = $this->getRecurrentContent($this->param('post_id'));

        return $data;
    }

    protected function getWrapperElementType()
    {
        return 'div';
    }

    protected function getWrapperAttributes()
    {
        return [];
    }

    private function getRecurrentContent($post_id)
    {
        $recurrent_content_post = get_post($post_id);

        if (!$recurrent_content_post) {
            return '';
        }

        return $recurrent_content_post->post_content;
    }

    private function getRecurrentContentPosts()
    {
        $args = array(
            'numberposts' => -1,
            'orderby' => 'post_title',
            'order' => 'ASC',
            'post_type' => 'recurrent_content',
            'post_status' => 'publish',
        );
        $posts_array = get_posts($args);

        $return = [];

        foreach ($posts_array as $post) {
            if ($post->post_status == 'publish') {
                $return[$post->post_title] = $post->ID;
            }
        }

        return $return;
    }
}
