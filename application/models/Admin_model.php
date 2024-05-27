<?php
class Admin_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->db1 = $this->load->database('db1', true);
    $this->load->database();
    date_default_timezone_set("America/Lima");
  }

  function get_list_menus_usuario($id_usuario)
  {
    $sql = "SELECT mg.id_modulo_grupo,mg.nom_modulo_grupo,mg.nom_grupomenu,mm.id_modulo_mae
            FROM modulo_grupo mg
            left JOIN modulo_mae mm ON mm.id_modulo_mae=mg.id_menu_mae
            WHERE (SELECT COUNT(*) FROM modulo_sub_subgrupo_xnivel mssgn 
            WHERE mssgn.id_modulo_grupo=mg.id_modulo_grupo AND mssgn.id_usuario=$id_usuario)>0 OR 
            (SELECT COUNT(*) FROM modulo_subgrupo_xnivel msgn 
            WHERE msgn.id_modulo_grupo=mg.id_modulo_grupo AND msgn.id_usuario=$id_usuario)>0";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  
  function get_list_modulo($id_usuario)
  {
    $sql = "SELECT ms.id_modulo_subgrupo,ms.id_modulo_grupo,ms.nom_subgrupo,ms.nom_menu
            FROM modulo_subgrupo ms
            LEFT JOIN modulo_subgrupo_xnivel msgn ON msgn.id_modulo_subgrupo=ms.id_modulo_subgrupo AND ms.estado=2
            WHERE msgn.id_usuario=$id_usuario OR (SELECT COUNT(*) FROM modulo_sub_subgrupo_xnivel mssgn 
            WHERE mssgn.id_usuario=$id_usuario AND mssgn.id_modulo_subgrupo=ms.id_modulo_subgrupo)>0";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_submodulo($id_usuario)
  {
    $sql = "SELECT s.id_modulo_sub_subgrupo_n,ms.nom_subgrupo,m.nom_submenu,m.nom_sub_subgrupo 
            FROM modulo_sub_subgrupo_xnivel s 
            LEFT JOIN modulo_sub_subgrupo m on m.id_modulo_sub_subgrupo=s.id_modulo_sub_subgrupo
            LEFT JOIN modulo_subgrupo ms on ms.id_modulo_subgrupo=s.id_modulo_subgrupo
            WHERE s.id_usuario=$id_usuario";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_empresa_usuario($id_usuario)
  {
    $sql = "SELECT * FROM usuario_empresa WHERE id_usuario=$id_usuario AND estado=2";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

}