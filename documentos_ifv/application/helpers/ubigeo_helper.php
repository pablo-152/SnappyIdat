<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_departamentos'))
{
    function get_departamentos() {
        $CI =& get_instance();
        $CI->load->model('Admin_model');
        $departamentos = $CI->Admin_model->raw("SELECT DISTINCT ubigeo_dep,departamento FROM DISTRITO_EPSG ORDER BY ubigeo_dep", true);
        return $departamentos;
    }
}

if ( ! function_exists('get_provincias'))
{
    function get_provincias($CODDPTO=null) {
        $CI =& get_instance();
        $CI->load->model('Admin_model');
        $query = "SELECT DISTINCT ubigeo_pro,provincia FROM DISTRITO_EPSG";
        if (!is_null($CODDPTO)) {
            $query = $query." WHERE ubigeo_dep='".$CODDPTO."'";
        }
        $provincias = $CI->Admin_model->raw($query." ORDER BY provincia", true);
        return $provincias;
    }
}

if ( ! function_exists('get_distritos'))
{
    function get_distritos($CODDPTO=null, $CODPROV=null) {
        $CI =& get_instance();
        $CI->load->model('Admin_model');
        $query = "SELECT ubigeo,distrito FROM DISTRITO_EPSG";
        if (!is_null($CODDPTO) and !is_null($CODPROV)) {
            $query = $query." WHERE ubigeo_dep='".$CODDPTO."' AND ubigeo_pro='".$CODPROV."'";
        }
        $distritos = $CI->Admin_model->raw($query." ORDER BY distrito", true);
        return $distritos;
    }
}


