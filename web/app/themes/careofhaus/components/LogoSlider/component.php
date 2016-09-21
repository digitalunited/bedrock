<?php
namespace Component;

class LogoSlider extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.logoslider', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/image_slider.png',
            'params' => []
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['slides'] = $this->getSlides();

        return $data;
    }

    public function main()
    {
        require_once('cpt.php');
        require_once('acf.php');
    }

    protected function getSlides()
    {
        $args = [
            'post_type' => 'logo_slider',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
        ];

        $category = $this->getCategory();
        if ($category) {
            $args['buissnes_area'] = $category;
        }

        $slides = get_posts($args);

        $return = [];

        foreach ($slides as $slide) {
            $image_id = get_field('image', $slide->ID, true);
            if ($image_id) {
                $srcset = \DigitalUnited\ResponsiveImage::render([
                    'imgId' => $image_id,
                    'output' => 'srcset',
                ]);

                $return[] = (object) [
                    'title' => $slide->post_title,
                    'url' => get_field('url', $slide->ID, true),
                    'srcset' => $srcset,
                ];
            }
        }

        return $return;
    }

    private function getCategory()
    {
        $cat = $this->param('category');
        if (!$cat || $cat == 'all') {
            return false;
        }

        return $cat;

        return get_term_by('slug', $cat, 'buissnes_area');
    }
}
