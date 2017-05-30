<?php

namespace Grrr\FlexibleContent\Blocks;

class Blocks {
    private $block_count = 0;

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
        set_query_var('block_count', $this->block_count);
        $this->block_count++;

        $layout = str_replace('_', '-', get_row_layout());
        get_template_part("templates/flexible-content/{$layout}");
    }
}

function render() {
    $flexible_content = new Blocks;
    $flexible_content->render();
}

/**
 * Get block layout, returning the row--{size} and the content--{size} class.
 */
function get_block_layout() {
    $classes = array();
    $block_layout_mapping = array(
        'content_size' => 'content',
        'row_size_top' => 'row-top',
	    'row_size_bottom' => 'row-bottom'
    );
    foreach($block_layout_mapping as $field_name => $class) {
        if (get_sub_field($field_name) && get_sub_field($field_name) !== 'none') {
            $classes[] = $class . '--' . get_sub_field($field_name);
        }
    }
    if (!empty($classes)) {
        return implode(' ', $classes);
    }
}
function the_block_layout() {
    echo get_block_layout();
}
