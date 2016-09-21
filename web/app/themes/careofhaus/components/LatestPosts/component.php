<?php
namespace Component;

class LatestPosts extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */

    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.latest.post', 'components'),
            'icon' => 'vc_icon-vc-gitem-post-date',
            'params' => [
                [
                    'type' => 'dropdown',
                    'heading' => __('admin.text.latest.post.type', 'components'),
                    'param_name' => 'post_type',
                    'value' => [
                        __('admin.post.type.posts', 'components') => 'post',
                        __('admin.post.type.events', 'components') => 'event',
                    ],
                    'std' => 'post'
                ],
                [
                    'type' => 'textfield',
                    'heading' => __('admin.text.limit', 'components'),
                    'param_name' => 'limit',
                    'value' => '2',
                ],
            ]
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['posts'] = $this->getLatestPosts();

        return $data;
    }

    private function getLatestPosts()
    {
        $posts = wp_get_recent_posts(
            [
                'numberposts' => $this->param('limit'),
                'post_status' => 'publish',
                'post_type' => $this->param('post_type'),
            ]
        );

        return array_map(function ($post) {
            return new Post([
                'post' => (object) $post,
                'view' => $this->param('post_type') == 'post' ? 'list' : 'eventlist'
            ]);
        }, $posts);
    }
}
