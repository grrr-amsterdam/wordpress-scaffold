<?php

namespace Grrr\Acf\FlexibleContent;

class Blocks {
    public static function render() {
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
