<?php
// Register options page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Temainställningar',
        'menu_title' => 'CoH Theme',
        'capability' => 'manage_options'
    ]);
}
