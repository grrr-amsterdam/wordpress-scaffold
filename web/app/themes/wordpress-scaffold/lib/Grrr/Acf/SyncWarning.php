<?php namespace Grrr\Acf;

use Garp\Functional as f;

class SyncWarning {

    /**
     * Note: we're not checking on `deleted` for now, since it will not
     * be 'available for sync'.
     */
    const CHANGE_CHECKS = ['modified'];

    private $_json_directories = [];

    public function __construct() {
        $this->_json_directories = [
            get_stylesheet_directory() . '/acf-json',
        ];
    }

    public function register() {
        if (!is_admin()) {
            return;
        }
        if (!defined('ACF_SYNC_WARNING') || !ACF_SYNC_WARNING) {
            return;
        }
        add_filter('admin_init', [$this, 'check_groups']);
    }

    public function check_groups() {
        $groups = acf_get_field_groups();
        if (empty($groups)) {
            return;
        }

        // Check for groups that have not been imported or have been modified.
        $modified = f\contains('modified', static::CHANGE_CHECKS)
            ? f\filter(function($group) {
                $local = f\prop('local', $group);
                $private = f\prop('private', $group);
                $modified = f\prop('modified', $group);

                if ($private || $local !== 'json') {
                    return false;
                } elseif (!f\prop('ID', $group)) {
                    return true;
                } elseif ($modified && $modified > get_post_modified_time('U', true, f\prop('ID', $group), true)) {
                    return true;
                }
                return false;
            }, $groups)
            : [];

        // Check for groups that have been deleted.
        $deleted = f\contains('deleted', static::CHANGE_CHECKS)
            ? f\filter(function($group) {
                return f\filter(function($directory) use ($group) {
                    $file = rtrim($directory, '/') . '/' . f\prop('key', $group) . '.json';
                    return !is_file($file);
                }, $this->_json_directories);
            }, $groups)
            : [];

        if (empty($modified) && empty($deleted)) {
            return;
        }

        add_action('admin_notices', [$this, 'show_warning']);
    }

    public function show_warning() {
        echo '
            <div class="notice notice-error">
                <p><strong>Advanced Custom Fields has unsynced groups.</strong><br/> <a href="' . site_url() . '/wp-admin/edit.php?post_type=acf-field-group&post_status=sync">Sync now</a> before overwriting any groups.</p>
            </div>
        ';
    }

}
