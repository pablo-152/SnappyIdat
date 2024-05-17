<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class N_teamleader extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }


    function get_solicitado(){
        $sql = "select * from users where id_nivel in (1,2,5) and estado=2  order by usuario_codigo";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
 
  function get_row_t(){
   $sql = "select * from tipo where estado=2 order by nom_tipo";
    $query = $this->db->query($sql)->result_Array();
     return $query; 
  }

   Public function getsubtipo($id_tipo){
       $query = $this->db->query("SELECT * from subtipo  WHERE id_tipo='$id_tipo' and estado=2"); 
       return $query->result_array();
     }
 
 
   Public function get_sub_tipo($id_tipo, $id_subtipo){
    $query = $this->db->query("SELECT * from subtipo  WHERE id_tipo='$id_tipo' and id_subtipo='$id_subtipo' and estado=2");
       return $query->result_array();
     }

    Public function sub_redes($id_tipo, $id_subtipo){
    $query = $this->db->query("SELECT * from subtipo where id_tipo='$id_tipo' and id_subtipo=$id_subtipo and estado=2");
       return $query->result_array();
     }

    public function proyecto_fec_termino($id_proyecto){
     $sql = "SELECT fec_termino from proyecto where id_proyecto='".$id_proyecto."'";
    $query = $this->db->query($sql);
    if($query->num_rows()==0){ return -1; }
    return $query->row()->fec_termino;
  }

     public function proyecto_cod($id_proyecto){
     $sql = "SELECT cod_proyecto  from proyecto where id_proyecto='".$id_proyecto."'";  
     $query = $this->db->query($sql);
     if($query->num_rows()==0){ return -1; }
     return $query->row()->cod_proyecto;
  }


    function query_calendar($cod_proyecto){
     $sql = "SELECT * from calendar_agenda where cod_proyecto='".$cod_proyecto."'";
     $query = $this->db->query($sql)->result_Array();
     return $query; 
      }

    function query_redes($cod_proyecto){
     $sql = "SELECT * from calendar_redes where cod_proyecto='".$cod_proyecto."'";
     $query = $this->db->query($sql)->result_Array();
     return $query;
    }




    function update_proyecto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['foto']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'foto';
        //$config['file_name'] = "proyecto".$fecha."_".rand(1,200).".".$ext;
        $config['upload_path'] = './archivo/';/// ruta del fileserver para almacenar el documento  idusuario randun fecha
        $config['file_name'] = $dato['id_proyecto']."_".rand(1,50).".".$ext;
        $ruta = 'archivo/'.$config['file_name'];
        if (!file_exists($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, true);
          chmod($config['upload_path'], 0777);
        }
        $config['allowed_types'] = "png|jpg|jpeg|gif|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
          $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $fec_act=date('Y-m-d H:i:s');
        
        $semana=date('W');
        $fec_agenda=$dato['fec_agenda'];

        $anio2=substr($dato['fec_agenda'],2,2);
        $mes=substr($dato['fec_agenda'],3,2);
        $dia=substr($dato['fec_agenda'],0,2);

        $sql = "UPDATE proyecto set id_solicitante='".$dato['id_solicitante']."', id_tipo='".$dato['id_tipo']."', 
        id_subtipo='".$dato['id_subtipo']."', s_artes='".$dato['s_artes']."', s_redes='".$dato['s_redes']."', 
        prioridad='".$dato['prioridad']."', descripcion='".$dato['descripcion']."', fec_agenda='$fec_agenda', 
        proy_obs='".$dato['proy_obs']."', id_asignado='".$dato['id_asignado']."', status='".$dato['status']."', 
        fec_act = NOW(), user_act='".$id_usuario."'
        WHERE id_proyecto =".$dato['id_proyecto']." ";
        $this->db->query($sql);
       
      if ($path!=""){
          $sql1="UPDATE proyecto set imagen='".$ruta."', fec_subi='".$fec_act."', id_useri='".$id_usuario."'
          where id_proyecto=".$dato['id_proyecto']."";
          $this->db->query($sql1);
      }

      if ($dato['status']==4){
        $sql2= "UPDATE proyecto set id_userpr='".$dato['id_userpr']."', fec_pendr='".$fec_act."' where id_proyecto=".$dato['id_proyecto']." ";
        $this->db->query($sql2);
      }

      if ($dato['status']==5){
        $sql3= "UPDATE proyecto set fec_termino=NOW(), user_termino='".$id_usuario."', semanat=$semana 
        where id_proyecto=".$dato['id_proyecto']." ";
        $this->db->query($sql3);
      }

      if($dato['fec_agenda']!=""){
        $sql4= "UPDATE proyecto set fec_agenda='".$dato['fec_agenda']."' where id_proyecto=".$dato['id_proyecto']." ";
        $this->db->query($sql4);
        
        if($dato['s_artes']>0){
            if($dato['totalRows_ca']>0){
                $sql5 = "UPDATE calendar_agenda set descripcion='".$dato['descripcion']."', inicio='".$dato['fec_agenda']."',
                        fin='".$dato['fec_agenda']."', anio='".$anio2."', mes='".$mes."',  nom_mes='".$dato['nom_mes']."',
                        dia='".$dia."', nom_dia='".$dato['nom_dia']."', color='".$dato['color']."',
                        fec_act='".$fec_act."', user_act='".$id_usuario."' where cod_proyecto='".$dato['cod_proyecto']."'";
                $this->db->query($sql5);
            }
            else{     
                $sql5 = "INSERT into calendar_agenda (cod_proyecto, descripcion, inicio, fin, anio, mes, nom_mes, dia, nom_dia, 
                        color, estado, fec_reg, user_reg) 
                        values ('".$dato['cod_proyecto']."', '".$dato['descripcion']."','".$dato['fec_agenda']."', 
                        '".$dato['fec_agenda']."', '".$anio2."', '".$mes."', '".$dato['nom_mes']."', '".$dia."', 
                        '".$dato['nom_dia']."', '".$dato['color']."', 2, NOW(), '".$id_usuario."')";
                $this->db->query($sql5);
            }
        }

        if($dato['s_redes'] >0){
            if($dato['totalRows_cr']>0){
                $sql6 = "UPDATE calendar_redes set descripcion='".$dato['descripcion']."', inicio='".$dato['fec_agenda']."', 
                        fin='".$dato['fec_agenda']."', anio='".$anio2."', mes='".$mes."',  nom_mes='".$dato['nom_mes']."',
                        dia='".$dia."', nom_dia='".$dato['nom_dia']."', color='".$dato['color']."',
                        fec_act='".$fec_act."', user_act='".$id_usuario."' where cod_proyecto='".$dato['cod_proyecto']."'";
                $this->db->query($sql6);
            }
            else{     
                $sql6 = "INSERT into calendar_redes (cod_proyecto, descripcion, inicio, fin, anio, mes, nom_mes, dia, nom_dia, 
                        color, estado, fec_reg, user_reg) 
                        values ('".$dato['cod_proyecto']."', '".$dato['descripcion']."','".$dato['fec_agenda']."', 
                        '".$dato['fec_agenda']."', '".$anio2."', '".$mes."', '".$dato['nom_mes']."', '".$dia."', 
                        '".$dato['nom_dia']."', '".$dato['color']."', 2, NOW(), '".$id_usuario."')";
                $this->db->query($sql6);
            }
        }
      }
      else
      {
          $sql7= "UPDATE proyecto set fec_agenda='' where id_proyecto=".$dato['id_proyecto']." ";
          $this->db->query($sql7);

          $sql4 = "delete from calendar_agenda where cod_proyecto='".$dato['cod_proyecto']."' ";
          $this->db->query($sql4);

          $sql5 = "delete from calendar_redes where cod_proyecto='".$dato['cod_proyecto']."' ";
          $this->db->query($sql5);
      }

      $this->db->query($sql);

    }

    function get_list_proyecto_busqueda($dato){
      $sql = "SELECT p.*, sp.nom_statusp, sp.color, t.nom_tipo, st.nom_subtipo, 
              u.usuario_nombres as nombre_solicitado, u.usuario_codigo as ucodigo_solicitado, 
              ua.usuario_nombres as nombre_asignado, ua.usuario_codigo as ucodigo_asignado,
              DATE_FORMAT(fec_solicitante,'%d/%m/%Y') as fec_solicitante,
              DATE_FORMAT(fec_agenda,'%d/%m/%Y') as fec_agenda,
              DATE_FORMAT(fec_termino,'%d/%m/%Y %H:%i:%s') as fec_termino 
              FROM proyecto p
              LEFT JOIN statusp sp on p.status=sp.id_statusp
              LEFT JOIN tipo t on p.id_tipo=t.id_tipo
              LEFT JOIN subtipo st on p.id_subtipo=st.id_subtipo
              LEFT JOIN users u on u.id_usuario=p.id_solicitante
              LEFT JOIN users ua on ua.id_usuario=p.id_asignado
              WHERE p.anio='".$dato['anio']."'
              ORDER BY p.prioridad";

      $query = $this->db->query($sql)->result_Array();
      return $query;
  }

  function get_row_s(){
    $sql = "SELECT * FROM statusp WHERE estado=1 AND id_statusp NOT IN (7,8,10) ORDER BY nom_statusp ASC";
    $query = $this->db->query($sql)->result_Array();
    $numero_filas=$this->db->query($sql)->num_rows();
   return $query;
   }
}
?>
