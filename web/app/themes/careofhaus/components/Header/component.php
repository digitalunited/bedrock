<?php
namespace Component;

class Header extends \DigitalUnited\Components\Component
{
    protected function getDefaultParams()
    {
        return [];
    }

    protected function sanetizeDataForRendering($data)
    {
        $data['languages'] = $this->getLanguages();

        return $data;
    }

    protected function getWrapperElementType()
    {
        return 'header';
    }

    protected function getWrapperAttributes()
    {
        return ['role' => 'banner'];
    }

    function getLanguages()
    {

        $args = [
            'orderby' => 'id',
            'order' => 'desc',
            'skip_missing' => 0
        ];

        $languages = apply_filters('wpml_active_languages', null, $args);

        return $languages;
    }
}
