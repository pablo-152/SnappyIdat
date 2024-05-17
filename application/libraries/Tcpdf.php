<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TCPDF
{
    public function __construct()
    {
        require_once APPPATH.'third_party/tcpdf/tcpdf.php';
    }
}
