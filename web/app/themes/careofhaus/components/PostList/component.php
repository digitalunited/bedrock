<?php
namespace Component;

class PostList extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [
            'hits' => [],
            'next_button' => '',
            'prev_button' => '',
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['hits'] = $this->getPostList();
        $data['next_button'] = $this->getNextButton();
        $data['prev_button'] = $this->getPrevButton();

        return $data;
    }

    public function getPostList()
    {
        global $wp_query;

        return array_map(function ($post) {
            return new Post([
                'post' => $post,
                'seen' => true,
            ]);
        }, $wp_query->posts);
    }

    private function getNextButton()
    {
        $title = __('post.list.next.page.button', 'components');
        $aTag = get_next_posts_link($title);

        if ($aTag) {
            return $this->aTagToButton($aTag);
        }
    }

    private function aTagToButton($aTag)
    {
        $link = new \DigitalUnited\Components\Link([
            'url' => $this->extractHrefFromDomElement($aTag),
            'title' => $this->extractTitleFromDomElement($aTag),
        ]);

        return new Button([
            'link' => $link,
            'text' => __('post.list.load.more.button', 'components'),
        ]);
    }

    private function extractHrefFromDomElement($domElement)
    {
        $pattern = "/href=[\'']([^'\']+)/";
        if (preg_match($pattern, $domElement, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function extractTitleFromDomElement($domElement)
    {
        $pattern = '/>([^<]+)</';
        if (preg_match($pattern, $domElement, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function getPrevButton()
    {
        $title = __('post.list.prev.page.button', 'components');
        $aTag = get_previous_posts_link($title);

        if ($aTag) {
            return $this->aTagToButton($aTag);
        }
    }

    public function getErrorMessage()
    {
        return __('post.list.no.posts.message', 'components');
    }
}
