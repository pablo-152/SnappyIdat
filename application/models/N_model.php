<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class n_model extends CI_Model{
    function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');  
    }

    public function login($usuario){  
      $sql = "SELECT 	u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo, u.id_nivel, u.usuario_email, 
              u.usuario_password,u.estado, n.nom_nivel,DATE_FORMAT(u.fin_funciones,'%Y-%m-%d') as fin_funcion, u.foto,
              IFNULL((SELECT SUBSTRING(se.cod_sede,-1) FROM usuario_sede ue 
              LEFT JOIN sede se ON se.id_sede=ue.id_sede 
              LEFT JOIN empresa em ON em.id_empresa=se.id_empresa 
              WHERE ue.id_usuario=u.id_usuario AND ue.estado=2 AND em.id_empresa=7 AND se.aparece_menu=1 AND se.estado=2
              ORDER BY se.cod_sede ASC LIMIT 1),'No') AS cod_sede_la,
              (SELECT GROUP_CONCAT(ue.id_empresa) FROM usuario_empresa ue
              WHERE ue.id_usuario=u.id_usuario) AS empresas_usuario
              FROM users u
              left join nivel n on n.id_nivel=u.id_nivel
              WHERE u.tipo=1 AND u.estado=2 AND u.usuario_codigo='$usuario'"; 
      $query = $this->db->query($sql)->result_array();
      return $query;
    }

    //NO BORRAR ESTOS PF
    public function login_con_id($id_usuario){  
      $sql = "SELECT u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo, u.id_nivel, u.usuario_email, 
              u.usuario_password,u.estado, n.nom_nivel,DATE_FORMAT(u.fin_funciones,'%Y-%m-%d') as fin_funcion, u.foto,
              IFNULL((SELECT SUBSTRING(se.cod_sede,-1) FROM usuario_sede ue 
              LEFT JOIN sede se ON se.id_sede=ue.id_sede 
              LEFT JOIN empresa em ON em.id_empresa=se.id_empresa 
              WHERE ue.id_usuario=u.id_usuario AND ue.estado=2 AND em.id_empresa=7 AND se.aparece_menu=1 AND se.estado=2
              ORDER BY se.cod_sede ASC LIMIT 1),'No') AS cod_sede_la,
              (SELECT GROUP_CONCAT(ue.id_empresa) FROM usuario_empresa ue
              WHERE ue.id_usuario=u.id_usuario) AS empresas_usuario
              FROM users u
              left join nivel n on n.id_nivel=u.id_nivel
              WHERE u.id_usuario=$id_usuario"; 
      $query = $this->db->query($sql)->result_array();
      return $query;
    }

    public function gettipoacceso($usuario){

      $sql="select us.CODUSER,t.Tipo_acceso, t.DescAcceso
                  from Usuario_Sistema us 
                  inner join tipoacceso t on t.codi_sistema=us.Codi_Sistema and t.Tipo_acceso=us.Tipo_Acceso
                  where us.Codi_Sistema='0030' and us.CODUSER='".$usuario."'";

        $query = $this->db->query($sql)->result_array();
      if(count($query) > 0){

      }
      return $query;
    }
      
  }
?>
