<?php namespace Grrr\Acf\Options;

class Pages {

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
        acf_add_options_page([
            'page_title'    => 'Thema Opties',
            'menu_title'    => 'Thema Opties',
            'menu_slug'     => 'theme-options',
            'redirect'      => true
        ]);
    }

    private function _add_sub_pages() {
        acf_add_options_sub_page([
            'page_title'    => 'Footer',
            'menu_title'    => 'Footer',
            'menu_slug'     => 'theme-options-footer',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title' => 'Klantenvertellen.nl',
            'menu_title' => 'Klantenvertellen.nl',
            'menu_slug' => 'theme-options-klantenvertellen',
            'parent_slug' => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Offerte aanvragen',
            'menu_title'    => 'Offerte aanvragen',
            'menu_slug'     => 'theme-options-quotation',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Onze werkwijze',
            'menu_title'    => 'Onze werkwijze',
            'menu_slug'     => 'theme-options-our-process',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Unique Selling Points',
            'menu_title'    => 'Unique Selling Points',
            'menu_slug'     => 'theme-options-usps',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => '———',
            'menu_title'    => '———',
            'menu_slug'     => 'theme-options-seperator-1',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Pagina\'s',
            'menu_title'    => 'Pagina\'s',
            'menu_slug'     => 'theme-options-pages',
            'parent_slug'   => 'theme-options'
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Snippets',
            'menu_title'    => 'Snippets',
            'menu_slug'     => 'theme-options-snippets',
            'parent_slug'   => 'theme-options'
        ]);
    }

}
