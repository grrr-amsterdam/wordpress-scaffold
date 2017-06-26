<?php

use Grrr\Utils;
use Grrr\PostTypes\Example;
use Grrr\Acf\FlexibleContent;

$examples = (new Example)->get_posts(10);

?>
<article>
    <header>
        <h1><?php bloginfo() ?></h1>
        <?= Utils\svg('arrow'); ?>
    </header>
    <section>
        <?php foreach ($examples as $post): setup_postdata($post);
            get_template_part('templates/partials/example-preview');
        endforeach; wp_reset_postdata(); ?>
    </section>
</article>

<?php try {
    (new FlexibleContent\Blocks)->render();
} catch(\Exception $e) {
    // Let if fail silently
} ?>
