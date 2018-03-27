<?php

use Roots\Sage\Assets;

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="dns-prefetch" href="https://s3-eu-west-1.amazonaws.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">

    <link rel="preload" href="<?= Assets\asset_path('scripts/main.js') ?>" as="script">

    <?php /*
    <link rel="preload" href="<?= Assets\asset_path('fonts/fugue_regular-webfont.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= Assets\asset_path('fonts/harbour-bold-webfont.woff2') ?>" as="font" type="font/woff2" crossorigin>
    */ ?>

    <?php wp_head(); ?>

    <script>
        /* Modernizr */
        <?php
        require_once(Assets\asset_path('scripts/modernizr.js', false)); echo "\n";
        ?>

        /* LoadJS */
        <?php
        require_once(Assets\asset_path('scripts/vendor/loadJS.js', false)); echo "\n";
        ?>

        /* Load JavaScript if browser cuts the mustard, and babel-polyfill when needed */
        var cutsMustard = 'querySelector' in document && 'addEventListener' in window;
        var cutsEdge = 'Symbol' in window && 'WeakMap' in window;
        if (cutsMustard && cutsEdge) {
            loadJS('<?= Assets\asset_path('scripts/main.js') ?>');
        } else if (cutsMustard) {
            loadJS('<?= Assets\asset_path('scripts/vendor/babel-polyfill.js') ?>', function() {
                loadJS('<?= Assets\asset_path('scripts/main.js') ?>');
            });
        } else {
            var doc = document.documentElement;
            var reJS = new RegExp('(^|\\s)js(\\s|$)');
            doc.className = doc.className.replace(reJS, '$1no-js$2');
        }

        /* SVG for Everybody (polyfill svg `use` with external source) */
        function svgSupportsExternalSource() {
            var newerIEUA = /\bTrident\/[567]\b|\bMSIE (?:9|10)\.0\b/, webkitUA = /\bAppleWebKit\/(\d+)\b/, olderEdgeUA = /\bEdge\/12\.(\d+)\b/;
            return newerIEUA.test(navigator.userAgent) || (navigator.userAgent.match(olderEdgeUA) || [])[1] < 10547 || (navigator.userAgent.match(webkitUA) || [])[1] < 537 ? false : true;
        }
        if (!svgSupportsExternalSource()) {
            loadJS('<?= Assets\asset_path('scripts/vendor/svg4everybody.min.js') ?>', function() {
                svg4everybody({
                    nosvg: false,
                    polyfill: true
                });
            });
        }
    </script>
</head>
