<?php

namespace Grrr\Acf\FlexibleContent;

class Blocks {

    public function __construct() {
        if (!function_exists('have_rows')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
    }

    public function render() {
        if (have_rows('flexible_content')) {
            echo '<div class="flexible-content">';
            while (have_rows('flexible_content')) {
                the_row();
                $this->_render_row();
            }
            echo '</div>';
        }
    }

    protected function _render_row() {
        $layout = str_replace('_', '-', get_row_layout());
        get_template_part("templates/flexible-content/{$layout}");
    }

}
