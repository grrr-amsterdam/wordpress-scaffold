<?php

use Roots\Sage\Assets;
use Grrr\Utils;

?>
<header class="site-header" role="banner">
    <div class="site-header__inner">
        <a class="site-header__logo" href="<?= esc_url(home_url('/')); ?>">
            <?php require(Assets\asset_path('images/site-logo.svg', false)) ?>
        </a>
        <nav class="site-header__nav-primary">
            <?php if (has_nav_menu('primary_navigation')):
                wp_nav_menu([
                    'theme_location' => 'primary_navigation',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                ]);
            endif; ?>
        </nav>
    </div>
</header>
