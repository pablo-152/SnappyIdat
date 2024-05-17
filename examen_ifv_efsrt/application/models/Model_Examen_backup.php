<?php
class Model_Examen extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->db2 = $this->load->database('db2', true);
    $this->load->database();
    date_default_timezone_set("America/Lima");
  }

  function get_postulante($dato)
  {
    $sql = "SELECT p.*,c.nombre as nom_carrera from postulantes_efsrt p
      left join carrera c on c.id_carrera=p.id_carrera
      where p.codigo='".$dato['codigo']."' and p.estado in ('30','56')";
      $query = $this->db->query($sql)->result_Array();
      return $query;
  }

  function get_id_postulante($dato)
  {
    $sql = "SELECT p.*,c.nombre as nom_carrera from postulantes_efsrt p
      left join carrera c on c.id_carrera=p.id_carrera
      where p.id_postulante='".$dato['id_postulante']."'";
      $query = $this->db->query($sql)->result_Array();
      return $query;
  }

  function get_id_examen($dato)
  {
    //$sql = "SELECT * from examen_efsrt_ifv where id_examen='".$dato['id_examen']."'";
    $sql="SELECT e.*,DATE_FORMAT(e.fec_limite,'%d-%m-%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados,'%d-%m-%Y') as fecha_resultados,
    DATE_FORMAT(e.fec_limite,'%Y-%m-%d') as fec_examen,
    (SELECT group_concat(distinct p.id_carrera) FROM examen_carrera_efsrt_ifv p WHERE p.id_examen=e.id_examen and p.estado=2) as examen_carrera
    from examen_efsrt_ifv e 
    where e.id_examen='".$dato['id_examen']."'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function examen_activo(){
    $hoy=date('Y-m-d');
    $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite,'%d-%m-%Y') as fecha_limite,DATE_FORMAT(e.fec_limite,'%Y-%m-%d') as fec_examen,
    DATE_FORMAT(e.fec_resultados,'%d-%m-%Y') as fecha_resultados,
    (SELECT group_concat(distinct p.id_carrera) FROM examen_carrera_efsrt_ifv p WHERE p.id_examen=e.id_examen and p.estado=2) as examen_carrera
    from examen_efsrt_ifv e 
    where e.estado=2 and e.estado_contenido=1 and DATE_FORMAT(e.fec_limite,'%Y-%m-%d')='$hoy'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_carrera_examen_efsrt($dato){
      $sql ="SELECT p.* FROM pregunta_admision_efsrt p 
      WHERE p.estado=2 and p.id_examen='".$dato['id_examen']."' and p.id_carrera in (".$dato['id_carrera'].") ORDER BY RAND() limit 10";
      $query = $this->db2->query($sql)->result_Array();
      return $query;
  }

  function get_id_preguntas($dato)
  {
    $sql = "SELECT group_concat(distinct id_pregunta) as preguntas from pregunta_admision_efsrt where 
    WHERE estado=2 and id_examen='".$dato['id_examen']."' and id_carrera in (".$dato['get_examen'][0]['examen_carrera'].")";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_respuesta($dato)
  {
    $sql = "SELECT * from respuesta_admision_efsrt where estado=2 and id_pregunta in (".$dato['get_id_pregunta'][0]['preguntas'].")";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_resultado_examen($dato)
  {
    $sql = "SELECT e.*,Date_format(e.tiempo_ini,'%H:%i:%s') as tiempo_inicial,ADDTIME(e.tiempo_ini, '00:30:00') as limite
    from resultado_examen_efsrt_ifv e where e.id_postulante='".$dato['id_postulante']."' and e.id_examen='".$dato['id_examen']."' and e.fec_examen='".$dato['fec_examen']."'
    and e.id_carrera='".$dato['id_carrera']."' and estado!=1";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function bloqueo_tiempo_limite($dato)
  {
    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];
    $sql = "UPDATE postulantes_efsrt set estado='33',fec_act=NOW() where id_postulante='".$dato['id_postulante']."' ";
    $this->db->query($sql);
    $sql = "UPDATE resultado_examen_efsrt_ifv set estado='33',fec_termino=NOW() where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and id_carrera='".$dato['id_carrera']."' and estado!=1";
    $this->db2->query($sql);
    $sql = "UPDATE pos_exam_efsrt set estado_pe='33',fec_act=NOW(),user_act=$id_usuario,hora_fin=NOW() where idpos_pe='".$dato['codigo']."' and idexa_pe='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and estado_pe<>1";
    $this->db2->query($sql);
    $sql = "DELETE FROM pregunta_exonerada_efsrt where id_postulante='".$dato['id_postulante']."'";
    $this->db2->query($sql);
  }

  function bloqueo_tiempo_limite_2($dato)
  {
    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];
    $sql = "UPDATE postulantes_efsrt set estado='33',fec_act=NOW() where id_postulante='".$dato['id_postulante']."' ";
    $this->db->query($sql);
    $sql = "UPDATE resultado_examen_efsrt_ifv set estado='33',fec_termino=NOW() where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and id_carrera='".$dato['id_carrera']."' and estado!=1";
    $this->db2->query($sql);
    $sql = "UPDATE pos_exam_efsrt set estado_pe='33',fec_act=NOW(),user_act=$id_usuario,hora_ini=NOW(),hora_fin=NOW() where idpos_pe='".$dato['codigo']."' and idexa_pe='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and estado_pe<>1";
    $this->db2->query($sql);
    $sql = "DELETE FROM pregunta_exonerada_efsrt where id_postulante='".$dato['id_postulante']."'";
    $this->db2->query($sql);
  }

  function lista_pregunta_exonerada($dato)
  {
    $sql = "SELECT * from pregunta_exonerada_efsrt where id_postulante='".$dato['id_postulante']."'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_id_preguntas_exonerada($dato)
  {
    $sql = "SELECT group_concat(distinct id_pregunta) as preguntas from pregunta_exonerada_efsrt where id_postulante='".$dato['id_postulante']."'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }


  function lista_pregunta_carrera($dato)
  {
    $sql = "SELECT e.nom_examen,e.estado as estado_examen, e.estado_contenido,p.*,a.nombre as nombre_area 
    FROM pregunta_admision p 
    left join area_carrera a on a.id_area=p.id_area
    left join examen_ifv e on e.id_examen=p.id_examen
    where p.estado='2' and a.id_area='".$dato['id_area']."' AND e.estado=2 and e.estado_contenido=1 ";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_config(){
    $sql = "SELECT * from config where descrip_config='examen_admision_efsrt'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_tiempo_ini_examen($dato)
  {
    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];
    $sql = "INSERT INTO resultado_examen_efsrt_ifv (id_postulante,cod_postulante,id_examen,fec_examen,id_carrera,tiempo_ini, estado, fec_reg, user_reg)
            values ('".$dato['id_postulante']."','".$dato['codigo']."','".$dato['id_examen']."','".$dato['fec_examen']."','".$dato['id_carrera']."',NOW(),'56', NOW(),".$id_usuario.")";
    $this->db2->query($sql);
    $sql2 = "UPDATE postulantes_efsrt set estado='56',fec_act=NOW() where id_postulante='".$dato['id_postulante']."' and id_carrera='".$dato['id_carrera']."' and id_examen='".$dato['id_examen']."'
    and fec_examen='".$dato['fec_examen']."'";
    $this->db->query($sql2);
    $sql = "UPDATE pos_exam_efsrt set hora_ini=NOW(),fec_act=NOW(),user_act=$id_usuario where idpos_pe='".$dato['codigo']."' and idexa_pe='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and estado_pe<>1";
    $this->db2->query($sql);
  }

  function get_id_postulante_2($dato)
  {
    $sql = "SELECT p.*,c.nombre as nom_carrera from postulantes p
    left join carrera c on c.id_carrera=p.id_carrera
    where p.id_postulante='".$dato['id_postulante']."' and p.estado='56'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_pregunta_exonerada($dato)
  {
    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];
    $sql = "INSERT INTO pregunta_exonerada_efsrt (id_pregunta,pregunta,id_postulante,img,fec_reg,user_reg) 
            values ('".$dato['id_pregunta']."','".$dato['pregunta']."','".$dato['id_postulante']."','".$dato['img']."',NOW(),".$id_usuario.")";
    $this->db2->query($sql);
  }

  function resultado_examen_ifv($dato)
  {
    $sql = "SELECT * from resultado_examen_efsrt_ifv where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and estado=56";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function insert_resultado_examen($dato)
  {
    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];
    $sql = "UPDATE resultado_examen_efsrt_ifv SET estado=31,puntaje='".$dato['puntaje']."',fec_termino=NOW(), fec_act=NOW(),user_act=$id_usuario
    where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."' and fec_examen='".$dato['fec_examen']."' and id_carrera='".$dato['id_carrera']."' and estado=56";    
    $this->db2->query($sql);
    $sql = "UPDATE postulantes_efsrt set estado='31',fec_act=NOW(),user_act='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'
    and fec_examen='".$dato['fec_examen']."'";
    $this->db->query($sql);
    $sql = "DELETE FROM pregunta_exonerada_efsrt  where id_postulante='".$dato['id_postulante']."'";
    $this->db2->query($sql);
    $sql = "DELETE FROM historial_examen_efsrt_ifv  where id_postulante='".$dato['id_postulante']."'";
    $this->db2->query($sql);
    $sql = "UPDATE pos_exam_efsrt set estado_pe='31',hora_ini='".$dato['hora_fin']."',hora_fin=NOW(),fec_act=NOW(),user_act=$id_usuario where idpos_pe='".$dato['codigo']."' and idexa_pe='".$dato['id_examen']."' 
    and fec_examen='".$dato['fec_examen']."' and estado_pe<>1";
    $this->db2->query($sql);
  }

  function consulta_tiempo_examen($dato){
    $sql = "SELECT * FROM pos_exam_efsrt where idpos_pe='".$dato['codigo']."' and idexa_pe='".$dato['id_examen']."' and fec_examen='".$dato['fec_examen']."' and estado_pe<>1";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

}