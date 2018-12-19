<?php

namespace Grrr\Twig;

use Grrr\Utils;
use Grrr\Utils\Assets;

class Functions {

    const FUNCTION_MAPPER = [
        'asset' => 'get_asset_path',
        'option' => 'get_acf_option',
        'snippet' => 'get_acf_snippet',
        'page' => 'get_acf_page',
        'source' => 'get_source',
        'svg' => 'get_svg',
    ];

    public function __construct() {
        add_filter('timber/twig', [$this, 'add_functions']);
    }

    public function get_asset_path(string $filepath) {
        return Assets\asset_path($filepath);
    }

    public function get_acf_option(string $name, string $prefix) {
        return get_field(str_replace(' ', '_', "{$prefix}_{$name}"), 'option');
    }

    public function get_acf_snippet(string $name) {
        return get_field(str_replace(' ', '_', "snippets_{$name}"), 'option');
    }

    public function get_acf_page(string $name) {
        return get_field(str_replace(' ', '_', "pages_{$name}"), 'option');
    }

    public function get_source(string $filepath) {
        return file_get_contents(Assets\asset_path($filepath, false));
    }

    public function get_svg(string $id, array $arguments = []) {
        return Utils\svg($id, $arguments);
    }

    public function add_functions(\Twig_Environment $twig) {
        foreach (self::FUNCTION_MAPPER as $function => $blabla) {
            $twig->addFunction(new \Timber\Twig_Function($function, [$this, $blabla]));
        }
        return $twig;
    }

};
