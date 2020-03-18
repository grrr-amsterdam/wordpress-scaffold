<?php
/*
Plugin Name:  Disable Admin Mails
Plugin URI:   https://grrr.nl/
Description:  Disable common admin mails for non-production environments.
Version:      1.0.0
Author:       GRRR
Author URI:   https://grrr.nl/
License:      MIT License
*/

if (WP_ENV !== 'production') {
    add_filter('wp_new_user_notification_email_admin', '__return_false');
    add_filter('wp_password_change_notification_email', '__return_false');
    add_filter('send_site_admin_email_change_email', '__return_false');
}
