<?php

namespace Component;

class Contact extends \DigitalUnited\Components\Component
{

    protected function getDefaultParams()
    {
        [];
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
