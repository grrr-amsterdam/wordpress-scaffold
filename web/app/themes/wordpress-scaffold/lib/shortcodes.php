<?php

namespace Grrr\Shortcodes;

function confetti_shortcode($attributes){
	return
    ?>
    <div class="confetti-block js-confetti">
        <div class="block-content"></div>
    </div>
    <?php
}
add_shortcode('confetti', __NAMESPACE__ . '\\confetti_shortcode');
