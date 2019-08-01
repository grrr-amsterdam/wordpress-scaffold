<?php namespace Grrr\Utils\AdminEditor;

use Grrr\Utils\Assets;
use Garp\Functional as f;

/**
 * Adjust WordPress editor.
 */
function adjust_editor(array $settings) {
    /**
     * Updated tags in the format dropdown.
     * See: https://www.tiny.cloud/docs/configure/editor-appearance/#block_formats
     */
    $settings['block_formats'] = ''
        . 'Paragraph=p;'
        . 'Heading 2=h2;'
        . 'Heading 3=h3;'
        . 'Heading 4=h4;'
        . 'Preformatted=pre;';

    /**
     * Add custom style formats to the style dropdown. It's also possible to
     * extend the existing `style_formats`.
     * Note that you'll need to enable the `mce_buttons` hook below, and for ACF
     * adjust `Grrr\Acf\WysiwygToolbars`.
     * See: https://www.tiny.cloud/docs/configure/editor-appearance/#style_formats
     */
    $style_formats = [
        [
            'title' => 'Intro text',
            'block' => 'p',
            'classes' => 'intro',
            'wrapper' => false,
        ],
        [
            'title' => 'Small text',
            'block' => 'p',
            'classes' => 'small',
            'wrapper' => false,
        ],
    ];
    /*
    $settings['style_formats'] = json_encode($style_formats);
    */

    /**
     * Add additional valid tags, and prevent them from being stripped.
     * See: https://www.tiny.cloud/docs/configure/content-filtering/#extended_valid_elements
     */
    /*
    $settings['extended_valid_elements'] = 'link[*]';
    */

    return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\adjust_editor');

/**
 * Callback function to insert 'styleselect' into the $buttons array for
 * the default TinyMCE editor. To adjust it for the ACF editor, go to
 * `Grrr\Acf\WysiwygToolbars`.
 * See: https://codex.wordpress.org/TinyMCE_Custom_Styles
 */
function adjust_editor_buttons($buttons) {
    $buttons = f\merge_at('styleselect', 1, $buttons);
	return $buttons;
}
/*
add_filter('mce_buttons', __NAMESPACE__ . '\\adjust_editor_buttons');
*/

/**
* Overrides the function user_can_richedit and only checks the user preferences
* instead of doing UA sniffing.
* See: https://benjaminhorn.io/code/wordpress-visual-editor-not-visible-because-of-user-agent-sniffing/
*/
function user_can_richedit_custom() {
    global $wp_rich_edit;
    if (get_user_option('rich_editing') == 'true' || !is_user_logged_in()) {
        $wp_rich_edit = true;
        return true;
    }
    $wp_rich_edit = false;
    return false;
}
add_filter('user_can_richedit', __NAMESPACE__ . '\\user_can_richedit_custom');
