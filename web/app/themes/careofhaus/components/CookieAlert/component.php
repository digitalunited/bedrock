<?php
namespace Component;

class CookieAlert extends \DigitalUnited\Components\Component
{

    public function getDefaultParams()
    {
        return [
            'text' => __('component.cookie.alert.text', 'components'),
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $cookiePageUrl = get_field('page_cookie', 'option');

        $link = new \DigitalUnited\Components\Link($cookiePageUrl);
        $text = get_field('cookie_notice_text', 'option');

        $data['text'] = $text ? $text : $link->title;
        $data['link'] = $link;

        return $data;
    }
}
