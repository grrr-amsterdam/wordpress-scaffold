<?php namespace Grrr\Theme;

class NoTimber {

    public function register() {
    	add_action('admin_notices', [$this, 'show_admin_notice']);
    	add_filter('template_include', [$this, 'show_site_notice']);
    }

    public function show_admin_notice() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin <a href="' . esc_url(admin_url('plugins.php#timber')) . '">here</a>.</p></div>';
    }

    public function show_site_notice($template) {
        echo '<!doctype html>
            <html lang="en">
                <head>
                    <title>Timber not activated.</title>
                </head>
                <body>
                    <h1>Timber not activated.</h1>
                </body>
            </html>';
        return;
    }

}
