<?php

use Grrr\Utils;
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <?php get_template_part('templates/partials/head'); ?>
    <body class="<?= Utils\get_body_class(); ?>">
        <?php get_template_part('templates/partials/tracking/google-tag-manager'); ?>

        <?php
        do_action('get_header');
        get_template_part('templates/partials/site-header');
        ?>

        <div class="wrapper" role="document">
            <main>
                <?php include Wrapper\template_path(); ?>
            </main>

            <?php if (Setup\display_sidebar()) : ?>
            <aside class="sidebar">
                <?php include Wrapper\sidebar_path(); ?>
            </aside>
            <?php endif; ?>
        </div>

        <?php
        do_action('get_footer');
        get_template_part('templates/partials/site-footer');
        wp_footer();
        ?>

        <!--[if IE]>
        <div class="browser-warning">
            <?php _e('You are using a <strong>strongly outdated</strong> browser. Please <a href="http://outdatedbrowser.com/" target="_blank">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
        <![endif]-->
    </body>
</html>

<!--

<?= APPLICATION_VERSION ?>

<?= get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds

-->
