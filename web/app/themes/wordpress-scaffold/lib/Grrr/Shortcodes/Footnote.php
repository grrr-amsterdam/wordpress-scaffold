<?php namespace Grrr\Shortcodes;

use Timber;

class Footnote {

    protected $type = 'footnote';

    public function register() {
        add_shortcode($this->type, [$this, 'render']);
    }

    public function render($attributes, $content) {
        $partial = Timber::fetch('lib/Grrr/Shortcodes/templates/footnote.twig', [
            'id' => $attributes['id'],
        ]);
        return trim($partial);
    }

}
