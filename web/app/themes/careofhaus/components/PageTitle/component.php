<?php
namespace Component;

class PageTitle extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        return [
            'title' => '',
            'background_image' => ''
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['title'] = $this->param('title') ? $this->param('title') : get_the_title(get_the_id());
        if (!empty($this->param('background_image'))) {
            $data['background_image'] = $this->param('background_image');
        }
        else {
            if ((is_home() || is_archive()) || is_single()) {
                $data['title'] = __('Blog', 'components');
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_option('page_for_posts')), 'full');
            }
            else {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            }

            if ($image) {
                $data['background_image'] = $image[0];
            }
            else {
                $data['background_image'] = get_template_directory_uri() . '/dist/PageTitle/std-header.jpg';
            }
        }

        return $data;
    }

}
