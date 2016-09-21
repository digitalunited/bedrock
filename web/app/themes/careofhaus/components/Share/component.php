<?php
namespace Component;

class Share extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        return [];
    }

    protected function sanetizeDataForRendering($data)
    {

        $data['shareLinks'] = $this->getShareLinks();

        return $data;
    }

    private function getShareLinks()
    {
        $currentUrl = $this->getCurrentPageUrl();

        return [
            [
                'name' => 'facebook',
                'prettyName' => __('component.share.facebook', 'components'),
                'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $currentUrl
            ],
            [
                'name' => 'twitter',
                'prettyName' => __('component.share.twitter', 'components'),
                'url' => 'https://twitter.com/home?status=' . $currentUrl
            ],
            [
                'name' => 'google-plus',
                'prettyName' => __('component.share.google-plus', 'components'),
                'url' => 'https://plus.google.com/share?url=' . $currentUrl
            ],
            [
                'name' => 'linkedin',
                'prettyName' => __('component.share.linkedin', 'components'),
                'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $currentUrl
            ],
        ];
    }

    private function getCurrentPageUrl()
    {
        global $wp;

        return add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request));
    }
}

