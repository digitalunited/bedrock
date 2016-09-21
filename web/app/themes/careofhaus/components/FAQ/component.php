<?php

namespace Component;

class FAQ extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        return [];
    }

    protected function sanetizeDataForRendering($data)
    {
        return $data;
    }

    public function main()
    {
        require_once('cpt.php');
    }
}
