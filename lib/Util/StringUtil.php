<?php namespace Grrr\Root\Util;

class StringUtil {

    /**
     * Interpolate strings with variables
     *
     * @param string $str The string
     * @param array $vars The variables
     * @return string The interpolated string
     */
    static public function interpolate($str, array $vars) {
        $keys = array_keys($vars);
        $vals = array_values($vars);
        // surround keys by "%"
        array_walk(
            $keys, function (&$s) {
                $s = '%' . $s . '%';
            }
        );
        $str = str_replace($keys, $vals, $str);
        return $str;
    }

}
