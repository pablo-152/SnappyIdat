<?php



class Model_Examen extends CI_Model {



    public function __construct() {



    parent::__construct();

    $this->db2 = $this->load->database('db2', true);
    $this->load->database();
    date_default_timezone_set("America/Lima");



  }







  function lista_area_carrera($dato)



  {



    $sql = "SELECT e.nom_examen,e.estado as estado_examen, e.estado_contenido,p.*,a.nombre as nombre_area,a.id_area,a.orden 



    FROM pregunta_admision p 



    left join area_carrera a on a.id_area=p.id_area



    left join examen_ifv e on e.id_examen=p.id_examen



    where p.estado='2' AND e.estado=2 and e.estado_contenido=1



    GROUP by a.nombre ORDER BY a.orden ASC";

    



    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function listhistorial_examenifv($dato)



  {



    $sql = "SELECT * FROM historial_examenifv WHERE id_postulante='".$dato['id_postulante']."'";



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







  function lista_pregunta_carrera_cadena($dato)



  {



    $sql = "SELECT e.nom_examen,e.estado as estado_examen, e.estado_contenido,p.*,a.nombre as nombre_area FROM pregunta_admision p 



    left join area_carrera a on a.id_area=p.id_area



    left join examen_ifv e on e.id_examen=p.id_examen



    where p.estado='2' and a.id_area='".$dato['id_area']."' AND e.estado=2 and e.estado_contenido=1 and p.id_pregunta not in ".$dato['cadena']."";







    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function lista_respuesta($dato)



  {



    $sql = "SELECT * from respuesta_admision where estado=2 and id_area='".$dato['id_area']."'";



    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function get_config(){



    $sql = "SELECT * from config where descrip_config='examen_admision'";



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }







  function resultado_examen_ifv($dato)



  {



    $sql = "SELECT * from resultado_examen_ifv where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }







  function get_id_postulante($dato)



  {



    $sql = "SELECT p.*,c.nombre as nom_carrera from postulantes p



    left join carrera c on c.id_carrera=p.id_carrera



    where p.codigo='".$dato['codigo']."' and p.estado='30'";



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }







  function examen_activo(){



    $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite,'%d-%m-%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados,'%d-%m-%Y') as fecha_resultados



    from examen_ifv e 



    where e.estado=2 and e.estado_contenido=1";







    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function get_id_postulante_2($dato)



  {



    $sql = "SELECT p.*,c.nombre as nom_carrera from postulantes p



    left join carrera c on c.id_carrera=p.id_carrera



    where p.id_postulante='".$dato['id_postulante']."' and p.estado='30'";



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }







  function get_resultado_examen1($dato)



  {



    $sql = "SELECT * from resultado_examen_ifv where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";

    



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }







  function get_resultado_examen($dato)



  {



    $sql = "SELECT e.*,Date_format(e.tiempo_ini,'%H:%i:%s') as tiempo_inicial,ADDTIME(e.tiempo_ini, '04:00:00') as limite from resultado_examen_ifv e where e.id_postulante='".$dato['id_postulante']."' and e.id_examen='".$dato['id_examen']."'";



    $query = $this->db->query($sql)->result_Array();



    return $query;



  }



  







  function insert_tiempo_ini_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "INSERT INTO resultado_examen_ifv (id_postulante,id_examen,tiempo_ini, estado, fec_reg, user_reg) 



            values ('".$dato['id_postulante']."','".$dato['id_examen']."',DATE_sub(NOW(), INTERVAL 1 HOUR),'30', DATE_sub(NOW(), INTERVAL 1 HOUR),".$id_usuario.")";



    $this->db->query($sql);



  }







  function insert_resultado_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "INSERT INTO resultado_examen_ifv (id_postulante,id_examen,puntaje,pg1, estado, fec_act, user_act) 



            values ('".$dato['id_postulante']."','".$dato['id_examen']."','".$dato['puntaje']."','".$dato['pagina']."','30', DATE_sub(NOW(), INTERVAL 1 HOUR),".$id_usuario.")";



    $this->db->query($sql);



  }







  function update_resultado_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg1='".$dato['pagina']."',fec_reg=DATE_sub(NOW(), INTERVAL 1 HOUR),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado2_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg2='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    //echo $sql;



    $this->db->query($sql);



  }







  function update_resultado3_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg3='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado4_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg4='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado5_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg5='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado6_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg6='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado7_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set puntaje='".$dato['puntaje']."',pg7='".$dato['pagina']."',fec_reg=NOW(),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $this->db->query($sql);



  }







  function update_resultado8_examen($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE resultado_examen_ifv set estado='31',puntaje='".$dato['puntaje']."',fec_termino=DATE_sub(NOW(), INTERVAL 1 HOUR),pg8='".$dato['pagina']."',fec_reg=DATE_sub(NOW(), INTERVAL 1 HOUR),user_reg='$id_usuario'  where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $sql2 = "UPDATE postulantes set estado='31',fec_act=DATE_sub(NOW(), INTERVAL 1 HOUR),user_act='$id_usuario'  where id_postulante='".$dato['id_postulante']."'";



    $sql3 = "DELETE FROM pregunta_exonerada  where id_postulante='".$dato['id_postulante']."'";



    $sql4 = "DELETE FROM historial_examenifv  where id_postulante='".$dato['id_postulante']."'";



    $sql5 = "UPDATE pos_exam set estado_pe='31' where idpos_pe='".$dato['id_postulante']."' and idexa_pe='".$dato['id_examen']."'";



    $this->db->query($sql);



    $this->db->query($sql2);



    $this->db2->query($sql3);



    $this->db2->query($sql4);



    $this->db->query($sql5);



  }







  function insert_pregunta_exonerada($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "INSERT INTO pregunta_exonerada (id_pregunta,pregunta,id_postulante,img,pg,fec_reg,user_reg) 



            values ('".$dato['id_pregunta']."','".$dato['pregunta']."','".$dato['id_postulante']."','".$dato['img']."','".$dato['pg']."',NOW(),".$id_usuario.")";



    $this->db2->query($sql);



  }







  function lista_pregunta_exonerada($dato)



  {



    $sql = "SELECT * from pregunta_exonerada where id_postulante='".$dato['id_postulante']."' and pg='".$dato['pg']."' ";



    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function lista_pregunta_exonerada_principal($dato)



  {



    $sql = "SELECT * from pregunta_exonerada where id_postulante='".$dato['id_postulante']."' ";



    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }







  function bloqueo_tiempo_limite($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE postulantes set estado='33'  where id_postulante='".$dato['id_postulante']."'";



    $sql2 = "UPDATE resultado_examen_ifv set estado='33',fec_termino=DATE_sub(NOW(), INTERVAL 1 HOUR) where id_postulante='".$dato['id_postulante']."' and id_examen='".$dato['id_examen']."'";



    $sql3 = "UPDATE pos_exam set estado_pe='33'  where idpos_pe='".$dato['id_postulante']."' and idexa_pe='".$dato['id_examen']."'";


    $sql4 = "DELETE FROM pregunta_exonerada  where id_postulante='".$dato['id_postulante']."'";



    $sql5 = "DELETE FROM historial_examenifv  where id_postulante='".$dato['id_postulante']."'";


    $this->db->query($sql);



    $this->db->query($sql2);



    $this->db->query($sql3);
    $this->db2->query($sql4);
    $this->db2->query($sql5);



  }







  function lista_historial($dato)



  {



    $sql = "SELECT * from historial_examenifv where id_postulante='".$dato['id_postulante']."' ";



    $query = $this->db2->query($sql)->result_Array();



    return $query;



  }











  function insert_historial($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "INSERT INTO historial_examenifv (id_postulante,pagina,user_reg) 



            values ('".$dato['id_postulante']."','".$dato['pagina']."',".$id_usuario.")";



    $this->db2->query($sql);



  }







  function update_historial($dato)



  {



    $id_usuario= $_SESSION['usuario'][0]['id_postulante'];







    $sql = "UPDATE historial_examenifv set pagina='".$dato['pagina']."'  where id_postulante='".$dato['id_postulante']."'";







    $this->db2->query($sql);



  }



  



}