<?php namespace Grrr\Acf\Options;

class Theme {

    const SLUG = 'theme-options';

    public function register() {
        $this->_add_main_page();
        $this->_add_sub_pages();
    }

    private function _add_main_page() {
        acf_add_options_page([
            'page_title'    => 'Theme Options',
            'menu_title'    => 'Theme Options',
            'menu_slug'     => static::SLUG,
            'icon_url'      => 'dashicons-admin-settings',
            'redirect'      => true,
        ]);
    }

    private function _add_sub_pages() {
        acf_add_options_sub_page([
            'page_title'    => 'Footer',
            'menu_title'    => 'Footer',
            'menu_slug'     => static::SLUG . '-footer',
            'parent_slug'   => static::SLUG,
        ]);

        acf_add_options_sub_page([
            'page_title'    => '———',
            'menu_title'    => '———',
            'menu_slug'     => static::SLUG . '-seperator-1',
            'parent_slug'   => static::SLUG,
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Pages',
            'menu_title'    => 'Pages',
            'menu_slug'     => static::SLUG . '-pages',
            'parent_slug'   => static::SLUG,
        ]);

        acf_add_options_sub_page([
            'page_title'    => 'Snippets',
            'menu_title'    => 'Snippets',
            'menu_slug'     => static::SLUG . '-snippets',
            'parent_slug'   => static::SLUG,
        ]);
    }

}
