<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PASSWORD
{
    public function __construct()
    {
        require_once APPPATH.'third_party/password_compatibility_library.php';
    }
}
