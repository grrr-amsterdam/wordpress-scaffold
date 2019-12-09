<?php namespace Grrr\Plugins;

/**
 * Adjust settings for Better Search Replace.
 *
 * @author Koen Schaft <koen@grrr.nl>
 */
final class BetterSearchReplace {

    public function register() {
        add_filter('bsr_capability', [$this, 'adjust_capability_check']);
    }

    /**
     * Overwrite permission config, since this defaults to `install_plugins`.
     * This capability is turned off for environments other than `development`.
     */
    function adjust_capability_check() {
        return 'manage_options';
    }

}
