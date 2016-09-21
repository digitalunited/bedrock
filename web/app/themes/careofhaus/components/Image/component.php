<?php
namespace Component;

use \CoH\ResponsiveImage;
use HtmlGenerator\HtmlTag;

class Image extends \DigitalUnited\Components\VcComponent
{
    /*
     * Vc mapping array
     * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
     */
    protected function getComponentConfig()
    {
        return [
            'name' => __('component.name.image', 'components'),
            'icon' => get_stylesheet_directory_uri() . '/dist/icons/image.png',
            'params' => [
                [
                    "type" => "attach_image",
                    "heading" => __("admin.text.image", "components"),
                    "admin_label" => false,
                    "param_name" => "image_id",
                    "value" => "",
                    "description" => ""
                ],
                [
                    "type" => "dropdown",
                    "heading" => __("admin.text.image.size", "components"),
                    "admin_label" => true,
                    "param_name" => "size",
                    "value" => [
                        __('admin.text.size.fullwidth', 'components') => 'standard',
                        __('admin.text.size.small', 'components') => 'small',
                    ],
                    "std" => 'standard',
                ],
                [
                    "type" => "dropdown",
                    "heading" => __("admin.text.position", "components"),
                    "admin_label" => true,
                    "param_name" => "position",
                    "value" => [
                        __('admin.text.position.left', 'components') => 'left',
                        __('admin.text.position.center', 'components') => 'center',
                        __('admin.text.position.right', 'components') => 'right',
                    ],
                    "std" => 'center',
                    "dependency" => [
                        "element" => "size",
                        "value" => "small",
                    ],
                ],
                [
                    "type" => "textfield",
                    "admin_label" => true,
                    "heading" => __("admin.text.image.text", "components"),
                    "param_name" => "text",
                    "dependency" => [
                        "element" => "theme",
                        "value" => "standard",
                    ],
                ],
                [
                    "type" => "textfield",
                    "admin_label" => true,
                    "heading" => __("admin.text.image.subtitle", "components"),
                    "param_name" => "subtitle",
                    "dependency" => [
                        "element" => "theme",
                        "value" => "standard",
                    ],
                ],
                ResponsiveImage::getVcParamAspectRatio(),
                [
                    "type" => "dropdown",
                    "heading" => __("admin.text.theme", "components"),
                    "admin_label" => true,
                    "param_name" => "theme",
                    "value" => [
                        __('admin.text.standard', 'components') => 'standard',
                        __('admin.text.theme.round', 'components') => 'round',
                    ],
                    "std" => 'standard',
                    "description" => __('admin.text.theme.desc', 'components'),
                ],
                [
                    "type" => "vc_link",
                    "admin_label" => false,
                    "heading" => __("admin.text.link", "components"),
                    "param_name" => "link",
                    "value" => "",
                    "description" => __("admin.text.field.may.be.blank", "components"),
                ],
            ],
        ];
    }

    protected function sanetizeDataForRendering($data)
    {
        $missing_image_pictureURL = get_template_directory_uri() . '/dist/Image/image-placeholder.png';
        $missing_image_picture = "<img class='missing-image' src='{$missing_image_pictureURL}' width='100%' alt='noimage'>";

        $data['image'] = $data['image_id'] ? $this->getImage() : $missing_image_picture;
        $data['link'] = new \DigitalUnited\Components\Link($data['link']);

        if (!empty($data['text']) && !empty($data['image_id'])) {
            $data['image'] = $this->getAddTextToImage($data['image']);
        }

        return $data;
    }

    protected function getImage()
    {
        $imgId = $this->param('image_id');
        $ratio = $this->param('ratio');

        return ResponsiveImage::render([
            'imgId' => $imgId,
            'output' => 'img',
            'ratio' => $ratio,
        ]);
    }

    protected function getAddTextToImage(HtmlTag $respImgObject)
    {
        $textContainer = HtmlTag::createElement('div');
        $textContainer->set('class', 'img-text');

        $h3 = $textContainer->addElement('h3');
        $h3->text($this->param('text'));

        if ($this->param('subtitle')) {
            $h3->addElement('br');
            $h3->addElement('small')->text($this->param('subtitle'));
        };

        $respImgObject->addElement($textContainer);

        return $respImgObject;
    }

    protected function getExtraWrapperClasses()
    {
        return [$this->param('size'), $this->param('position')];
    }

}
