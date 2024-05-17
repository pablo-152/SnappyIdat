<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('utf8ize'))
{
    function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
}

if ( ! function_exists('get_sesion'))
{
    function get_sesion($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(mt_rand(33, 126));
        }
        return md5($random);
    }

}
/*
if (!function_exists('utf8ize')) {
    function utf8ize(&$input) {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                utf8ize($value);
            }
            unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));
            foreach ($vars as $var) {
                utf8ize($input->$var);
            }
        }
    }
}

*/