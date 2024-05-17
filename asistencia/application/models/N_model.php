<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class N_model extends CI_Model{
    function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');  
    }

    public function login($usuario){
      $sql = "SELECT 	u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo, u.id_nivel, u.usuario_email, 
              u.usuario_password,u.estado, n.nom_nivel,DATE_FORMAT(u.fin_funciones,'%Y-%m-%d') as fin_funcion, u.foto FROM users u
              left join nivel n on n.id_nivel=u.id_nivel
              WHERE u.estado='2' and u.usuario_codigo = '" . $usuario . "'";
      $query = $this->db->query($sql)->result_array();
      return $query;
    }
  }
?>
