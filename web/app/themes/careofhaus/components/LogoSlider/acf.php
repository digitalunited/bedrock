<?php
if (function_exists('register_field_group')):

    register_field_group(array(
        'key' => 'group_54ddd589262bb',
        'title' => 'LogoSlider',
        'fields' => array(
            array(
                'key' => 'field_54ddd58975cca',
                'label' => 'Url',
                'name' => 'url',
                'prefix' => '',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_54ddd58975d1e',
                'label' => 'Bild',
                'name' => 'image',
                'prefix' => '',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'logo_slider',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));

endif;
