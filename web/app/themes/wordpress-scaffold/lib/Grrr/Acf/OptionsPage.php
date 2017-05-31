<?php

namespace Grrr\Acf;

class OptionsPage {

    public static function init() {
        if (!function_exists('acf_add_options_page') ||
            !function_exists('acf_add_options_sub_page')) {
            return;
        }
        $this->main_page();
        $this->sub_pages();
    }

    private function main_page() {
        acf_add_options_page(array(
            'page_title'    => 'Theme Options',
            'menu_title'    => 'Theme Options',
            'menu_slug'     => 'theme-options',
            'redirect'      => true
        ));
    }

    private function sub_pages() {
        acf_add_options_sub_page(array(
            'page_title'    => 'Address & Contact',
            'menu_title'    => 'Address & Contact',
            'menu_slug'     => 'theme-options-contact',
            'parent_slug'   => 'theme-options'
        ));
    }

}
