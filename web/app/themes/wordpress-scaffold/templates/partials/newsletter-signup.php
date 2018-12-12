<?php

use Grrr\Utils;

$action = get_rest_url(null, 'grrr/v1/newsletter/subscribe');

?>
<form class="newsletter-signup" data-enhancer="newsletterSignup" action="<?= $action ?>" method="post" target="_blank" aria-label="Sign up for our newsletter">
    <label for="newsletter-signup-email">
        Your e-mail address
    </label>
    <input type="email" value="" name="email" placeholder="Your e-mail address" id="newsletter-signup-email" required>
    <!-- Simple honeypot -->
    <div style="position: absolute; left: -5000px;" aria-hidden="true">
        <input type="text" name="random_input" tabindex="-1" value="">
    </div>
    <button type="submit">
        Sign up
    </button>
    <span role="alert" id="newsletter-signup-alert" aria-hidden="true"></span>
</form>
