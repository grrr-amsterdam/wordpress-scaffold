<?php namespace Grrr\Acf;

use Garp\Functional as f;

class WysiwygToolbars {

    public function register() {
        /*
        add_filter('acf/fields/wysiwyg/toolbars', [$this, 'adjust_toolbars'], 1);
        */
    }

    /**
     * Adjust the TinyMCE toolbars used in ACF. See `Grrr\Utils\AdminEditor` for
     * global options and adjustments.
     * See https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
     */
    public function adjust_toolbars($toolbars) {

        // Remove `wp_more` to make room for `styleselect`.
        $toolbars['Full'][1] = f\omit([10], $toolbars['Full'][1]);

        // Add `styleselect` after regular `formatselect`.
        $toolbars['Full'][1] = f\merge_at('styleselect', 1, $toolbars['Full'][1]);

        return $toolbars;
    }

}
