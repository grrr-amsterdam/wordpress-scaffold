<?php namespace Grrr\Twig;

use Garp\Functional as f;
use Grrr\PostTypes\PostTypeRegistry;
use Grrr\Theme;
use Grrr\Utils;
use Grrr\Utils\Assets;
use Timber;

class Functions {

    const FUNCTION_MAPPER = [
        'archive_link'      => 'get_archive_link',
        'asset'             => 'get_asset_path',
        'env'               => 'get_env',
        'option'            => 'get_acf_option',
        'page'              => 'get_acf_page',
        'posts'             => 'get_posts',
        'snippet'           => 'get_acf_snippet',
        'source'            => 'get_source',
        'structured_data'   => 'get_structured_data',
        'svg'               => 'get_svg',
    ];

    public function register() {
        add_filter('timber/twig', [$this, 'add_functions']);
    }

    public function get_archive_link(string $postType) {
        return get_post_type_archive_link($postType);
    }

    public function get_asset_path(string $filepath) {
        return Assets\asset_path($filepath);
    }

    public function get_env(string $key) {
        return f\prop($key, Theme\Setup::ENV_MAPPER);
    }

    public function get_acf_option(string $name, string $prefix) {
        if (!function_exists('get_field')) {
            return;
        }
        return get_field(str_replace(' ', '_', "{$prefix}_{$name}"), 'option');
    }

    public function get_acf_snippet(string $name) {
        if (!function_exists('get_field')) {
            return;
        }
        return get_field(str_replace(' ', '_', "snippets_{$name}"), 'option');
    }

    public function get_acf_page(string $name) {
        if (!function_exists('get_field')) {
            return;
        }
        return get_field(str_replace(' ', '_', "pages_{$name}"), 'option');
    }

    public function get_posts(string $type, ...$args) {
        $class = PostTypeRegistry::create_class($type)
            ->get_posts(...$args);
    }

    public function get_source(string $filepath) {
        return file_get_contents(Assets\asset_path($filepath, false));
    }

    public function get_structured_data(Timber\Post $post, ...$args) {
        return PostTypeRegistry::create_class($post->type)
            ->get_structured_data($post, ...$args);
    }

    public function get_svg(string $id, array $arguments = []) {
        return Utils\svg($id, $arguments);
    }

    public function add_functions(\Twig_Environment $twig) {
        foreach (self::FUNCTION_MAPPER as $caller => $function) {
            $twig->addFunction(new Timber\Twig_Function($caller, [$this, $function]));
        }
        return $twig;
    }

};
