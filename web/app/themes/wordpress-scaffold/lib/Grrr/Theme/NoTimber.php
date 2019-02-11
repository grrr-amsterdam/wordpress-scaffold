<?php namespace Grrr\Theme;

class NoTimber {

    public function register() {
    	add_action('admin_notices', function() {
    		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin <a href="' . esc_url(admin_url('plugins.php#timber')) . '">here</a>.</p></div>';
    	});
    	add_filter('template_include', function($template) {
    		return get_stylesheet_directory() . '/static/no-timber.html';
    	});
    }

}
