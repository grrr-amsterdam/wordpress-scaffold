<?php namespace Grrr\Shortcodes;

use Timber;

class Footnote {

    protected $_type = 'footnote';

    public function register() {
        add_shortcode($this->_type, [$this, 'shortcode']);
    }

    public function shortcode($attributes, $content) {
        $partial = Timber::fetch('lib/Grrr/Shortcodes/templates/footnote.twig', [
            'id' => $attributes['id'],
        ]);
        return trim($partial);
    }

}
