<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/partials/page', 'header'); ?>
    <?php get_template_part('templates/content/content', 'page'); ?>
<?php endwhile; ?>
