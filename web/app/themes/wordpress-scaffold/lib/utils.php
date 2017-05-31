<?php

namespace Grrr\Utils;

use Roots\Sage\Assets;

/**
 * SVG helper
 *
 * Usage: Utils\svg('arrow-down', ['class' => 'test', 'data-foo' => 'bar']);
 */
function svg($id, $args = []) {
    if (!func_num_args()) {
        return $this;
    }
    // keep spaces, due to Safari 10 bug
    $template = '<svg%s> <use xlink:href="%s#%s"/> </svg>';
    $attributes = '';
    foreach ($args as $key => $value) {
        $attributes .= " {$key}=\"{$value}\"";
    }
    $sprite = Assets\asset_path('images/icons.svg');
    return sprintf($template, $attributes, $sprite, $id);
}

/**
 * Get body class
 */
function get_body_class() {
    switch (true) {
        case is_admin_bar_showing():
            return 'has-admin-bar';
        case is_front_page():
            return 'is-front-page';
        default:
            return '';
    }
}

/**
 * Get image source
 */
function get_image_src($size, $post_id = null) {
    if (!$size) {
        return;
    }
    $image_id = get_post_thumbnail_id($post_id);
    return wp_get_attachment_image_src($image_id, $size)[0];
}

/**
 * Get image alt
 */
function get_image_alt($post_id = null) {
    $image_id = get_post_thumbnail_id($post_id);
    return get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

/**
* Get a value from $_POST / $_GET
* if unavailable, take a default value
*
* @param string $key Value key
* @param mixed $default_value (optional)
* @return mixed Value
*/
function get_value($key, $default_value = false) {
    if (!isset($key) || empty($key) || !is_string($key))
        return false;

    $ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));

    if (is_string($ret))
        return stripslashes(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret))));

    return $ret;
}

/*
    Create Nice Url
 */
function nice_url( $url ) {
    if (empty($url)) {
        return;
    }
    $aUrl = parse_url( $url );
    return $aUrl['host'];
}

/*
    Create e-mail link
 */
function create_email_link($mailto, $attr = null) {
    return '<a href="mailto:' . $mailto . '">' . $mailto . '</a>';
}

/*
    Create site link
 */
function create_site_link($url, $attr = null) {
    $nice_url = nice_url($url);
    return '<a href="' . $url . '">' . $nice_url . '</a>';
}

/*
    Get referrer from this site
 */
function get_site_referrer() {

    // if referrer doesn't exists return false
    if (!isset ($_SERVER['HTTP_REFERER'])) {
        return false;
    }

    // parse referrer
    $aUrl = parse_url ($_SERVER['HTTP_REFERER']);

    // check if referrer is same site, return false
    if( $aUrl['host'] != $_SERVER['HTTP_HOST'] ) {
        return false;
    }

    // if referrer is same page, return false
    if( $aUrl['path'] == $_SERVER['REQUEST_URI'] ) {
        return false;
    }

    // else return referrer path
    return $aUrl['path'];
}

/*
    Prepend content if value exists
 */
function prepend( $value = '', $prepend) {
    if ( !empty( $value ) ) {
        return $prepend . $value;
    }
}

/*
    Append content if value exists
 */
function append( $value = '', $append) {
    if ( !empty( $value ) ) {
        return $value . $append;
    }
}

/*
    Wrap content if value exists
 */
function wrap( $value = '', $prepend, $append) {
    if ( !empty( $value ) ) {
        return $prepend . $value . $append;
    }
}

/*
    Wrap link if link exist
 */
function try_wrap_link( $text, $link = '', $aAttr = array() ) {
    $attr = '';
    // return text of link
    if ( empty( $link ) ) {
        return $text;
    }
    // create html attributes
    if ($aAttr) {
        $attr = attr_to_string($aAttr);
    }
    // return link with html attributes
    return '<a ' . $attr . ' href="' . $link . '">' . $text  . '</a>';
}

/*
    Attribute array to string
*/
function attr_to_string( $aAttr ) {
    $attr = '';
    foreach ( $aAttr as $name => $value ) {
        $attr .= " $name=" . '"' . $value . '"';
    }
    return $attr;
}
