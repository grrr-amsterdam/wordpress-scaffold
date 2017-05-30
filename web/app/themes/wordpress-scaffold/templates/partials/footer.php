<?php

use Roots\Sage\Assets;
use Grrr\Utils;

?>
<footer class="footer" role="contentinfo">
    <div class="footer__inner">
        <?php if (has_nav_menu('primary_navigation')):
            wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'link_before' => '<span>',
                'link_after' => '</span>',
            ]);
        endif; ?>
    </div>
</footer>
