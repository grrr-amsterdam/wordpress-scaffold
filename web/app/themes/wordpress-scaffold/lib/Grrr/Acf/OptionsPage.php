<?php

namespace Grrr\Acf;

class OptionsPage {

    public function __construct() {
        if (!function_exists('acf_add_options_page') ||
            !function_exists('acf_add_options_sub_page')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
    }

    public function init() {
        $this->_add_main_page();
        $this->_add_sub_pages();
    }

    private function _add_main_page() {
        acf_add_options_page(array(
            'page_title'    => 'Theme Options',
            'menu_title'    => 'Theme Options',
            'menu_slug'     => 'theme-options',
            'redirect'      => true
        ));
    }

    private function _add_sub_pages() {
        acf_add_options_sub_page(array(
            'page_title'    => 'Address & Contact',
            'menu_title'    => 'Address & Contact',
            'menu_slug'     => 'theme-options-contact',
            'parent_slug'   => 'theme-options'
        ));
    }

}
