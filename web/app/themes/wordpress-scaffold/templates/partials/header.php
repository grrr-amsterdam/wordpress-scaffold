<?php

use Roots\Sage\Assets;
use Grrr\Utils;

?>
<header class="header" role="banner">
    <div class="header__inner">
        <a class="header__logo" href="<?= esc_url(home_url('/')); ?>">
            <?php require(Assets\asset_import('images/site-logo.svg')) ?>
        </a>
        <nav class="header__nav-primary">
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
