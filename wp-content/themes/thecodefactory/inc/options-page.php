<?php
if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'parent_slug'   => 'themes.php',
        'capability'    => 'manage_options',
    ));
}