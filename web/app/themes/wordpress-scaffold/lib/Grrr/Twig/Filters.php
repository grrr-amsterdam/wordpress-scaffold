<?php

namespace Grrr\Twig;

use Timber;
use Garp\Functional as f;

class Filters {

    const FUNCTION_MAPPER = [
        'dropcap' => 'add_dropcap',
        'slugify' => 'make_slug',
    ];

    public function __construct() {
        add_filter('timber/twig', [$this, 'add_filters']);
    }

    public function add_dropcap(string $html, string $class): string {
        return preg_replace(
            "@<p>\s*((?:<[^<>]+>\s*)*)([^<>\s])@",
            "<p>$1<span class=\"{$class}\">$2</span>",
            $html,
            1
        );
    }

    public function make_slug(string $string): string {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public function add_filters(\Twig_Environment $twig) {
        $twig->addExtension(new \Twig_Extension_StringLoader());
        foreach (self::FUNCTION_MAPPER as $caller => $function) {
            $twig->addFilter(new \Twig_SimpleFilter($caller, [$this, $function]));
        }
        return $twig;
    }

};
