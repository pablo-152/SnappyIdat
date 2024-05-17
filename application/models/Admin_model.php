<?php
class Admin_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->db1 = $this->load->database('db1', true);
    $this->db2 = $this->load->database('db2', true);
    $this->db3 = $this->load->database('db3', true);
    $this->db5 = $this->load->database('db5', true);
    $this->db6 = $this->load->database('db6', true);
    $this->load->database();
    date_default_timezone_set("America/Lima");
  }

  function get_list_nav_sede()
  {
    $sql = "SELECT * FROM sede WHERE id_empresa=1 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_estado()
  {
    $sql = "SELECT * FROM status WHERE estado=1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_anio_general()
  {
    $sql = "SELECT id_anio,nom_anio FROM anio 
                WHERE estado=1 
                ORDER BY nom_anio DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_mes_general($id_mes = null)
  {
    if (isset($id_mes) && $id_mes > 0) {
      $sql = "SELECT * FROM mes 
                  WHERE id_mes=$id_mes";
    } else {
      $sql = "SELECT id_mes,cod_mes,nom_mes FROM mes 
                  WHERE estado=1 
                  ORDER BY id_mes ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_tipo_festivo()
  {
    $sql = "select * from tipo_fecha where estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_camb_clave($id_user)
  {
    if (isset($id_user) && $id_user > 0) {
      $sql = "select u.*, n.nom_nivel from users u left join nivel n on n.id_nivel=u.id_nivel
            where id_usuario=" . $id_user;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_anio()
  {
    $sql = "SELECT id_anio,nom_anio FROM anio 
              WHERE nom_anio>=2017 AND estado=1 
              ORDER BY nom_anio DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_clave($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $sql = "update users set usuario_password='" . $dato['user_password_hash'] . "', fec_act='$fecha', user_act='" . $dato['id_usuario'] . "' where id_usuario =" . $dato['id_usuario'] . "";
    //echo $sql;
    $this->db->query($sql);
  }

  function get_confg_foto()
  {
    $sql = "select * from fintranet";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa()
  {
    $sql = "SELECT se.*, s.nom_status from empresa se
            LEFT JOIN status s on se.estado=s.id_status
            WHERE se.estado=2
            ORDER BY cod_empresa ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_secretaria()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT em.id_empresa,em.cod_empresa FROM usuario_empresa ue
            LEFT JOIN empresa em ON em.id_empresa=ue.id_empresa
            WHERE ue.estado=2 AND ue.id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_sede()
  {
    $sql = "SELECT se.*, s.nom_status,em.empresa,em.nom_empresa,em.cod_empresa, 
            CASE WHEN se.rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte from sede se
            LEFT JOIN status s on se.estado=s.id_status
            LEFT JOIN empresa em on se.id_empresa=em.id_empresa
            WHERE se.estado=2
            ORDER BY cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_registro_sede_empresa($id_registro)
  {
    if (isset($id_registro) && $id_registro > 0) {
      $sql = "SELECT s.*,se.cod_sede from registro_mail_sede s
      left join sede se on se.id_sede=s.id_sede
      where s.id_registro =" . $id_registro;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_registro_producto($id_registro)
  {
    if (isset($id_registro) && $id_registro > 0) {
      $sql = "SELECT s.*,se.nom_producto_interes from registro_mail_producto s
      left join producto_interes se on se.id_producto_interes=s.id_producto_interes
      where s.id_registro =" . $id_registro;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_sede_empresa($id_empresa)
  {
    $sql = "SELECT se.*, s.nom_status,em.empresa,em.nom_empresa,em.cod_empresa, 
            CASE WHEN se.rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte from sede se
            LEFT JOIN status s on se.estado=s.id_status
            LEFT JOIN empresa em on se.id_empresa=em.id_empresa
            WHERE se.id_empresa='$id_empresa'
            ORDER BY cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_empresa($id_empresa)
  {
    $sql = "SELECT * FROM empresa 
              WHERE id_empresa=$id_empresa";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_empresa($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "insert into empresa (rep_redes, nom_empresa, cod_empresa, orden_empresa, observaciones_empresa, color1_empresa, color2_empresa, 
    estado, fec_reg, user_reg) 
    values ('" . $dato['rep_redes'] . "','" . $dato['nom_empresa'] . "','" . $dato['cod_empresa'] . "','" . $dato['orden_empresa'] . "',
    '" . $dato['observaciones_empresa'] . "','" . $dato['color1_empresa'] . "','" . $dato['color2_empresa'] . "','" . $dato['id_status'] . "', 
    '" . $fecha . "'," . $id_usuario . ")";
    $this->db->query($sql);
  }

  function update_empresa($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "update empresa set rep_redes='" . $dato['rep_redes'] . "', nom_empresa='" . $dato['nom_empresa'] . "', cod_empresa='" . $dato['cod_empresa'] . "',
    orden_empresa='" . $dato['orden_empresa'] . "', observaciones_empresa='" . $dato['observaciones_empresa'] . "', 
    color1_empresa='" . $dato['color1_empresa'] . "', color2_empresa='" . $dato['color2_empresa'] . "', estado='" . $dato['id_status'] . "', 
    fec_act='" . $fecha . "', user_act=" . $id_usuario . "  where id_empresa='" . $dato['id_empresa'] . "'";
    $this->db->query($sql);
  }

  function get_list_festivo()
  {
    $sql = "select se.*, s.nom_status, tf.nom_tipo_fecha from calendar_festivo se
            left join tipo_fecha tf on se.id_tipo_fecha=tf.id_tipo_fecha
            left join status s on se.estado=s.id_status";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  /*
    function get_id_empresa($id_empresa){
      if(isset($id_empresa) && $id_empresa > 0){
        $sql = "select * from empresa where id_empresa =".$id_empresa;
      }
      $query = $this->db->query($sql)->result_Array();
      return $query;
    }

    function insert_empresa($dato){
      $fecha=date('Y-m-d H:i:s');
      $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

      $sql="insert into empresa (rep_redes, nom_empresa, cod_empresa, orden_empresa, observaciones_empresa, color1_empresa, color2_empresa, 
      estado, fec_reg, user_reg) 
      values ('". $dato['rep_redes']."','". $dato['nom_empresa']."','". $dato['cod_empresa']."','". $dato['orden_empresa']."',
      '". $dato['observaciones_empresa']."','". $dato['color1_empresa']."','". $dato['color2_empresa']."','". $dato['id_status']."', 
      '".$fecha."',".$id_usuario.")";
      $this->db->query($sql);
    }

    function update_empresa($dato){
      $fecha=date('Y-m-d H:i:s');
      $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

      $sql="update empresa set rep_redes='". $dato['rep_redes']."', nom_empresa='". $dato['nom_empresa']."', cod_empresa='". $dato['cod_empresa']."',
      orden_empresa='". $dato['orden_empresa']."', observaciones_empresa='". $dato['observaciones_empresa']."', 
      color1_empresa='". $dato['color1_empresa']."', color2_empresa='". $dato['color2_empresa']."', estado='". $dato['id_status']."', 
      fec_act='".$fecha."', user_act=".$id_usuario."  where id_empresa='". $dato['id_empresa']."'";
      $this->db->query($sql);
    }*/

  function get_id_intranet($id_intranet)
  {
    if (isset($id_intranet) && $id_intranet > 0) {
      $sql = "select * from fintranet where id_fintranet =" . $id_intranet;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_foto($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $path = $_FILES['productImage']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);


    $mi_archivo = 'productImage';
    $config['upload_path'] = 'C:/xampp/htdocs/new_snappy/fotos/';/// ruta del fileserver para almacenar el documento
    $config['file_name'] = "bt" . "_" . rand(1, 12) . "." . $ext;

    $ruta = $config['file_name'];

    $config['allowed_types'] = "png|jpg|pdf";
    $config['max_size'] = "0";
    $config['max_width'] = "0";
    $config['max_height'] = "0";
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload($mi_archivo)) {
      $data['uploadError'] = $this->upload->display_errors();
    }
    $data['uploadSuccess'] = $this->upload->data();

    $sql = " insert into fintranet (nom_fintranet, foto, estado, fec_reg, user_reg) values ('" . $dato['nom_fintranet'] . "','" . $ruta . "', '1', '" . $fecha . "'," . $id_usuario . ")";
    //echo $sql;
    $this->db->query($sql);
  }

  function get_row_asignadot()
  {
    $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_asignado()
  {
    $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=2) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_entramitet()
  {
    $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=3";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_entramite()
  {
    $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=3) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_pendientet()
  {
    $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=4";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_pendiente()
  {
    $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=4) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_tp2()
  {
    $anio = date('Y');
    $semana = date('W');

    $sql = "SELECT SUM( s_artes ) as artest, SUM( s_redes ) AS redest, COUNT(0) AS total , u.usuario_codigo, u.artes, 
                u.redes from users u
                left join (select * from proyecto where semanat=$semana and YEAR(fec_termino)=$anio and status in (5, 6, 7)) p on 
                p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_tp()
  {
    $anio = date('Y');
    $semana = date('W');
    $sql = "SELECT SUM( s_artes ) AS artest, SUM( s_redes ) AS redest, COUNT(0) AS total , u.usuario_codigo, u.artes, 
                u.redes from users u
                left join (select * from proyecto where semanat=$semana and YEAR(fec_termino)=$anio and status in (5, 6, 7)) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_empresa_proyecto()
  {
    $sql = "SELECT ue.*,em.cod_empresa FROM proyecto_empresa ue
            LEFT JOIN empresa em on em.id_empresa=ue.id_empresa
            WHERE ue.estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_sede_proyecto()
  {
    $sql = "SELECT us.*,se.cod_sede FROM proyecto_sede us
            LEFT JOIN sede se on se.id_sede=us.id_sede
            WHERE us.estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_p($id_estatus = null)
  {
    $anio = date('Y');
    $semana = date('W');
    if (isset($id_estatus) && $id_estatus < 6 && $id_estatus > 0) {
      $parte = "";
      if ($id_estatus == 5) {
        $parte = "AND p.semana=$semana";
      }
      $sql = "SELECT p.*, sp.nom_statusp, sp.color, t.nom_tipo, st.nom_subtipo, u.usuario_nombres as nombre_solicitado, 
              u.usuario_codigo as ucodigo_solicitado, ua.usuario_nombres as nombre_asignado, 
              ua.usuario_codigo as ucodigo_asignado,DATE_FORMAT(p.fec_agenda,'%d/%m/%Y') as fecha_agenda,
              DATE_FORMAT(p.fec_solicitante,'%d/%m/%Y') as fecha_solicitante,
              DATE_FORMAT(p.fec_termino,'%d/%m/%Y') as fecha_termino,em.cod_empresa,
              (SELECT group_concat(distinct se.cod_sede)  as cadenaa
              FROM proyecto_sede ps
              left join sede se on se.id_sede=ps.id_sede
              WHERE ps.id_proyecto=p.id_proyecto and ps.estado=2) as cod_sede
              from proyecto p
              LEFT JOIN statusp sp on p.status=sp.id_statusp
              LEFT JOIN tipo t on p.id_tipo=t.id_tipo
              LEFT JOIN subtipo st on p.id_subtipo=st.id_subtipo
              LEFT JOIN users u on u.id_usuario=p.id_solicitante
              LEFT JOIN users ua on ua.id_usuario=p.id_asignado
              left join empresa em on em.id_empresa=p.id_empresa
              WHERE p.status ='$id_estatus' $parte
              ORDER BY p.prioridad ASC,p.cod_proyecto ASC";
    } else {
      $sql = "SELECT p.*, sp.nom_statusp, sp.color, t.nom_tipo, st.nom_subtipo, u.usuario_nombres as nombre_solicitado, 
              u.usuario_codigo as ucodigo_solicitado, ua.usuario_nombres as nombre_asignado,
              ua.usuario_codigo as ucodigo_asignado,DATE_FORMAT(p.fec_agenda,'%d/%m/%Y') as fecha_agenda,
              DATE_FORMAT(p.fec_solicitante,'%d/%m/%Y') as fecha_solicitante,
              DATE_FORMAT(p.fec_termino,'%d/%m/%Y') as fecha_termino,em.cod_empresa,
              (SELECT group_concat(distinct se.cod_sede)  as cadenaa
              FROM proyecto_sede ps
              left join sede se on se.id_sede=ps.id_sede
              WHERE ps.id_proyecto=p.id_proyecto and ps.estado=2) as cod_sede
              from proyecto p
              LEFT JOIN statusp sp on p.status=sp.id_statusp
              LEFT JOIN tipo t on p.id_tipo=t.id_tipo
              LEFT JOIN subtipo st on p.id_subtipo=st.id_subtipo
              LEFT JOIN users u on u.id_usuario=p.id_solicitante
              LEFT JOIN users ua on ua.id_usuario=p.id_asignado
              left join empresa em on em.id_empresa=p.id_empresa
              WHERE /*p.anio=$anio and */ p.status in (1,2,3,4)
              ORDER BY p.prioridad ASC,p.cod_proyecto ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_solicitado()
  {
    $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
            FROM users u
            left join (select * from proyecto where status=1) p on p.id_asignado=u.id_usuario 
            where u.id_nivel in (2,3,4) and u.estado=2
            GROUP BY u.id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_solicitadot()
  {
    $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_solicitado()
  {
    //$sql = "SELECT * FROM users";
    $sql = "SELECT * FROM users WHERE id_nivel IN (1,2,5) AND estado=2 ORDER BY usuario_codigo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_solicitante_c_historico($dato)
  {
    //$sql = "SELECT * FROM users";
    $sql = "SELECT * FROM users WHERE id_nivel IN (1,2,5) " . $dato['soli'] . " ORDER BY usuario_codigo ASC";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_row_t()
  {
    $sql = "SELECT * FROM tipo where estado=2 order by nom_tipo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_empresa()
  {
    $sql = "SELECT * FROM empresa WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_empresa_xcod($dato)
  {
    $sql = "SELECT * FROM empresa WHERE cod_empresa='" . $dato['cod_empresa'] . "' and  estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_sede($id_empresa)
  {
    $sql = "SELECT * FROM sede WHERE estado=2 AND id_empresa=$id_empresa";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_tipo()
  {
    $sql = "SELECT * FROM tipo WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_subtipo($id_tipo, $id_empresa)
  {
    $sql = "SELECT * FROM subtipo WHERE estado=2 AND id_tipo=$id_tipo AND id_empresa=$id_empresa";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_usuario()
  {
    $sql = "SELECT * FROM users WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_estado_proyecto()
  {
    $sql = "SELECT * FROM statusp WHERE estado=1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function getsubtipo($id_tipo, $id_empresa)
  {
    $sql = "SELECT * FROM subtipo  
            WHERE id_tipo='$id_tipo' AND id_empresa='$id_empresa' AND estado=2 ORDER BY nom_subtipo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function getsubtipo_xempresa($dato)
  {
    $sql = "SELECT * from subtipo  WHERE id_tipo='" . $dato['id_tipo'] . "' and id_empresa in " . $dato['empresas'] . " and estado=2 order by nom_subtipo ASC";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  public function get_sub_tipo($id_tipo, $id_subtipo)
  {
    $query = $this->db->query("SELECT * from subtipo  WHERE id_tipo='$id_tipo' and id_subtipo='$id_subtipo' and estado=2");
    return $query->result_array();
  }

  public function sub_redes($id_tipo, $id_subtipo)
  {
    $query = $this->db->query("SELECT * from subtipo where id_tipo='$id_tipo' and id_subtipo=$id_subtipo and estado=2");
    return $query->result_array();
  }



  function ultimo_cod_proyecto($anio)
  {
    $sql = "SELECT cod_proyecto FROM proyecto where anio='" . $anio . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function get_colorestatus()
  {
    $sql = "SELECT color  from statusp where id_statusp=1";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) {
      return -1;
    }
    return $query->row()->color;
  }

  function get_id_empresa_proyecto($id_proyecto)
  {
    $sql = "SELECT * FROM proyecto_empresa WHERE id_proyecto=$id_proyecto AND estado=2";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_sede_proyecto($id_proyecto)
  {
    $sql = "SELECT * FROM proyecto_sede WHERE id_proyecto=$id_proyecto AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_una_sede($id_empresa)
  {
    $sql = "SELECT * FROM sede 
              WHERE id_empresa=$id_empresa AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_proyecto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];

    if ($id_nivel == 1 || $id_nivel == 2 || $id_nivel == 4 || $id_nivel == 6) {
      $sql = "INSERT INTO proyecto (cod_proyecto,semana,id_solicitante,fec_solicitante,id_tipo,id_subtipo,s_artes,s_redes,prioridad,descripcion,
        proy_obs,anio,mes,dia,id_empresa,copy,status,fec_reg,user_reg) 
        VALUES ('" . $dato['cod_proyecto'] . "','" . $dato['semana'] . "','" . $dato['id_solicitante'] . "',NOW(),'" . $dato['id_tipo'] . "',
        '" . $dato['id_subtipo'] . "','" . $dato['s_artes'] . "','" . $dato['s_redes'] . "','" . $dato['prioridad'] . "','" . $dato['descripcion'] . "',
        '" . $dato['proy_obs'] . "','" . $dato['anio'] . "','" . $dato['mes'] . "','" . $dato['dia'] . "','" . $dato['id_empresa'] . "','" . $dato['copy'] . "',1,
        NOW(),'" . $dato['user_reg'] . "' )";
    } else {
      $sql = "INSERT INTO proyecto (cod_proyecto,semana,id_solicitante,fec_solicitante,id_tipo,id_subtipo,s_artes,s_redes,prioridad,descripcion,
            proy_obs,anio,mes,dia,id_empresa,status,fec_reg,user_reg) 
            VALUES ('" . $dato['cod_proyecto'] . "','" . $dato['semana'] . "','" . $dato['id_solicitante'] . "',NOW(),'" . $dato['id_tipo'] . "',
            '" . $dato['id_subtipo'] . "','" . $dato['s_artes'] . "','" . $dato['s_redes'] . "','" . $dato['prioridad'] . "','" . $dato['descripcion'] . "',
            '" . $dato['proy_obs'] . "','" . $dato['anio'] . "','" . $dato['mes'] . "','" . $dato['dia'] . "','" . $dato['id_empresa'] . "',1,
            NOW(),'" . $dato['user_reg'] . "' )";
    }


    $this->db->query($sql);

    $fec_agenda = $dato['fec_agenda'];

    $fechaComoEntero = strtotime($dato['fec_agenda']);

    if ($fec_agenda != "") {
      $anio2 = substr($fec_agenda, 0, 4);
      //$mes=substr($_POST['fec_agenda'],5,2);
      //$dia=substr($_POST['fec_agenda'],8,2);
      $mes = date("m", $fechaComoEntero);
      $dia = date("d", $fechaComoEntero);

      $sql5 = "UPDATE proyecto set fec_agenda='" . $fec_agenda . "' where cod_proyecto='" . $dato['cod_proyecto'] . "'";
      $this->db->query($sql5);

      if ($dato['s_artes'] > 0) {
        $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                      inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,duplicado,estado,fec_reg,user_reg) 
                      VALUES ((SELECT id_proyecto FROM proyecto WHERE cod_proyecto='" . $dato['cod_proyecto'] . "'),
                      'Proyecto','" . $dato['cod_proyecto'] . "','" . $dato['descripcion'] . "',
                      '" . $fec_agenda . "', '" . $fec_agenda . "', '" . $anio2 . "', '" . $mes . "', 
                      '" . $dato['nom_mes'] . "','" . $dia . "','" . $dato['nom_dia'] . "', 
                      '" . $dato['color'] . "',0,2,NOW(),$id_usuario)";

        $this->db->query($sql1);
      }

      if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34 || $dato['id_tipo'] == 22) {
        $sql2 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                      inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,estado,fec_reg,user_reg) 
                      VALUES ((SELECT id_proyecto FROM proyecto WHERE cod_proyecto='" . $dato['cod_proyecto'] . "'),
                      'Proyecto','" . $dato['cod_proyecto'] . "', '" . $dato['descripcion'] . "',
                      '" . $fec_agenda . "', '" . $fec_agenda . "', '" . $anio2 . "', '" . $mes . "', 
                      '" . $dato['nom_mes'] . "','" . $dia . "', '" . $dato['nom_dia'] . "', '" . $dato['color'] . "', '" . $dato['s_redes'] . "',0,
                      2, NOW(),$id_usuario)";

        $this->db->query($sql2);
      }
    }
  }

  function insert_proyecto_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO proyecto_sede (id_proyecto,id_sede,estado,fec_reg,user_reg) 
        VALUES ((SELECT id_proyecto FROM proyecto WHERE cod_proyecto='" . $dato['cod_proyecto'] . "'),
        '" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  public function proyecto_fec_termino($id_proyecto)
  {
    $sql = "SELECT fec_termino from proyecto where id_proyecto='" . $id_proyecto . "'";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) {
      return -1;
    }
    return $query->row()->fec_termino;
  }


  public function proyecto_cod($id_proyecto)
  {
    $sql = "SELECT cod_proyecto  from proyecto where id_proyecto='" . $id_proyecto . "'";
    $query = $this->db->query($sql);
    if ($query->num_rows() == 0) {
      return -1;
    }
    return $query->row()->cod_proyecto;
  }


  function query_calendar($dato)
  {
    $sql = "SELECT * FROM calendar_agenda WHERE id_secundario='" . $dato['id_proyecto'] . "' AND
            tipo_calendar='Proyecto'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function query_redes($dato)
  {
    $sql = "SELECT * FROM calendar_redes WHERE id_secundario='" . $dato['id_proyecto'] . "' AND
            tipo_calendar='Proyecto'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  public function get_color($status)
  {
    $sql = "SELECT color  from statusp where id_statusp='" . $status . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  function update_proyecto($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
    $path = $_FILES['foto']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $mi_archivo = 'foto';
    // $config['file_name'] = "proyecto".$fecha."_".rand(1,200).".".$ext;
    $config['upload_path'] = './archivo/';/// ruta del fileserver para almacenar el documento  idusuario randun fecha
    $config['file_name'] = $dato['id_proyecto'] . "_" . rand(1, 50) . "." . $ext;

    if (!file_exists($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, true);
      chmod($config['upload_path'], 0777);
    }

    $ruta = 'archivo/' . $config['file_name'];

    $config['allowed_types'] = "png|jpg|jpeg|gif|pdf";
    $config['max_size'] = "0";
    $config['max_width'] = "0";
    $config['max_height'] = "0";
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload($mi_archivo)) {
      $data['uploadError'] = $this->upload->display_errors();
    }
    $data['uploadSuccess'] = $this->upload->data();

    $fec_act = date('Y-m-d H:i:s');
    $semana = date('W');

    $anio2 = substr($dato['fec_agenda'], 0, 4);
    $mes = substr($dato['fec_agenda'], 5, 2);
    $dia = substr($dato['fec_agenda'], 8, 2);

    if ($id_nivel == 1 || $id_nivel == 2 || $id_nivel == 4 || $id_nivel == 6) {
      $sql = "UPDATE proyecto set id_solicitante='" . $dato['id_solicitante'] . "',id_tipo='" . $dato['id_tipo'] . "',
              id_subtipo='" . $dato['id_subtipo'] . "',s_artes='" . $dato['s_artes'] . "',
              s_redes='" . $dato['s_redes'] . "',prioridad='" . $dato['prioridad'] . "',status='" . $dato['status'] . "',
              descripcion='" . $dato['descripcion'] . "',proy_obs='" . $dato['proy_obs'] . "',
              copy='" . $dato['copy'] . "',hora='" . $dato['hora'] . "',
              publicidad_pagada='" . $dato['publicidad_pagada'] . "',id_asignado='" . $dato['id_asignado'] . "',
              id_empresa='" . $dato['id_empresa'] . "', fec_act ='" . $fec_act . "',id_userpr='" . $dato['id_userpr'] . "'
              WHERE id_proyecto =" . $dato['id_proyecto'] . "";
    } else {
      $sql = "UPDATE proyecto set id_solicitante='" . $dato['id_solicitante'] . "',id_tipo='" . $dato['id_tipo'] . "',
              id_subtipo='" . $dato['id_subtipo'] . "',s_artes='" . $dato['s_artes'] . "',
              s_redes='" . $dato['s_redes'] . "',prioridad='" . $dato['prioridad'] . "',status='" . $dato['status'] . "',
              descripcion='" . $dato['descripcion'] . "',proy_obs='" . $dato['proy_obs'] . "',
              hora='" . $dato['hora'] . "',publicidad_pagada='" . $dato['publicidad_pagada'] . "',
              id_asignado='" . $dato['id_asignado'] . "',id_empresa='" . $dato['id_empresa'] . "',
              fec_act ='" . $fec_act . "',id_userpr='" . $dato['id_userpr'] . "'
              WHERE id_proyecto =" . $dato['id_proyecto'] . "";
    }

    $this->db->query($sql);

    // imagen='".$ruta."',
    //    fec_agenda='".$dato['fec_agenda']."'      

    if ($path != "") {
      $sql1 = "UPDATE proyecto set imagen='" . $ruta . "', fec_subi='" . $fec_act . "', id_useri='" . $id_usuario . "'
                where id_proyecto=" . $dato['id_proyecto'] . "";
      $this->db->query($sql1);
    }

    if ($dato['status'] == 4) {
      $sql2 = "UPDATE proyecto set id_userpr='" . $dato['id_userpr'] . "', fec_pendr='" . $fec_act . "' 
                where id_proyecto=" . $dato['id_proyecto'] . " ";
      $this->db->query($sql2);
    }

    if ($dato['status'] == 5) {
      $sql3 = "UPDATE proyecto SET fec_termino=NOW(), user_termino='" . $id_usuario . "', 
                semanat='" . $semana . "' 
                where id_proyecto=" . $dato['id_proyecto'] . " ";
      $this->db->query($sql3);
    }

    if ($dato['fec_agenda'] != "") {
      $sql4 = "UPDATE proyecto SET fec_agenda='" . $dato['fec_agenda'] . "' 
              WHERE id_proyecto=" . $dato['id_proyecto'] . " ";
      $this->db->query($sql4);

      if ($dato['s_artes'] > 0) {
        if ($dato['totalRows_ca'] > 0) {
          $sql5 = "UPDATE calendar_agenda SET descripcion='" . $dato['descripcion'] . "',
                      inicio='" . $dato['fec_agenda'] . "',fin='" . $dato['fec_agenda'] . "', 
                      anio='" . $anio2 . "', mes='" . $mes . "',  nom_mes='" . $dato['nom_mes'] . "',
                      dia='" . $dia . "', nom_dia='" . $dato['nom_dia'] . "', color='" . $dato['color'] . "',
                      fec_act='" . $fec_act . "', user_act=$id_usuario
                      WHERE id_secundario='" . $dato['id_proyecto'] . "' AND tipo_calendar='Proyecto' and duplicado=0";
          $this->db->query($sql5);
        } else {
          $sql5 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,
                      descripcion,inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,duplicado,estado,fec_reg,user_reg) 
                      VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
                      '" . $dato['descripcion'] . "','" . $dato['fec_agenda'] . "','" . $dato['fec_agenda'] . "', 
                      '" . $anio2 . "', '" . $mes . "', '" . $dato['nom_mes'] . "', '" . $dia . "', 
                      '" . $dato['nom_dia'] . "', '" . $dato['color'] . "',0, 2, NOW(),$id_usuario)";
          $this->db->query($sql5);
        }
      }
      if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34 || $dato['id_tipo'] == 22) {
        if ($dato['totalRows_cr'] > 0) {
          $sql6 = "UPDATE calendar_redes SET descripcion='" . $dato['descripcion'] . "',
                      inicio='" . $dato['fec_agenda'] . "',fin='" . $dato['fec_agenda'] . "', 
                      anio='" . $anio2 . "', mes='" . $mes . "',  nom_mes='" . $dato['nom_mes'] . "',
                      dia='" . $dia . "', nom_dia='" . $dato['nom_dia'] . "', color='" . $dato['color'] . "',
                      fec_act='" . $fec_act . "', user_act=$id_usuario
                      WHERE id_secundario='" . $dato['id_proyecto'] . "' AND tipo_calendar='Proyecto' AND duplicado=0";
          $this->db->query($sql6);
        } else {
          $sql6 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                      inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,duplicado, estado, fec_reg, user_reg) 
                      VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
                      '" . $dato['descripcion'] . "','" . $dato['fec_agenda'] . "','" . $dato['fec_agenda'] . "', 
                      '" . $anio2 . "', '" . $mes . "', '" . $dato['nom_mes'] . "', '" . $dia . "', 
                      '" . $dato['nom_dia'] . "', '" . $dato['color'] . "',0, 2, NOW(), '" . $id_usuario . "')";
          $this->db->query($sql6);
        }
      }
    } else {
      $sql7 = "UPDATE proyecto SET fec_agenda='' WHERE id_proyecto=" . $dato['id_proyecto'] . " ";
      $this->db->query($sql7);

      $sql4 = "DELETE FROM calendar_agenda WHERE id_secundario='" . $dato['id_proyecto'] . "' AND 
                tipo_calendar='Proyecto' and duplicado=0";
      $this->db->query($sql4);

      $sql5 = "DELETE FROM calendar_redes WHERE id_secundario='" . $dato['id_proyecto'] . "' AND
                tipo_calendar='Proyecto' and duplicado=0";
      $this->db->query($sql5);
    }

    $this->db->query($sql);
  }

  function reiniciar_proyecto_empresa($dato)
  {
    $sql = "DELETE FROM proyecto_empresa WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
    $this->db->query($sql);
  }

  function reiniciar_proyecto_sede($dato)
  {
    $sql = "DELETE FROM proyecto_sede WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
    $this->db->query($sql);
  }

  function update_proyecto_empresa($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO proyecto_empresa (id_proyecto,id_empresa,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_proyecto'] . "','" . $dato['id_empresa'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function update_proyecto_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO proyecto_sede (id_proyecto,id_sede,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_proyecto'] . "','" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function get_id_proyecto($id_proyecto)
  {
    if (isset($id_proyecto) && $id_proyecto > 0) {
      $sql = "SELECT *,fec_solicitante AS fecha,DATE_FORMAT(fec_solicitante,'%d/%m/%Y') as fec_solicitante
                  FROM proyecto 
                  WHERE id_proyecto=" . $id_proyecto;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_disenador_proyecto($dato)
  {
    $sql = "UPDATE proyecto SET id_asignado='" . $dato['id_disenador'] . "'
            WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
    $this->db->query($sql);
  }

  function insert_temporal_proyecto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO temporal_proyecto (id_usuario,prioridad,empresa,sede,tipo,subtipo,descripcion,asignado,agenda,estado) 
          VALUES ($id_usuario,'" . $dato['v_prioridad'] . "','" . $dato['v_empresa'] . "','" . $dato['v_sede'] . "','" . $dato['v_tipo'] . "',
          '" . $dato['v_subtipo'] . "','" . $dato['v_descripcion'] . "','" . $dato['v_asignado'] . "','" . $dato['v_agenda'] . "','" . $dato['v_estado'] . "')";

    $this->db->query($sql);
  }

  function get_list_temporal_proyecto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "SELECT * FROM temporal_proyecto WHERE id_usuario=" . $id_usuario;

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_temporal_proyecto_correcto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM temporal_proyecto WHERE prioridad=0 AND empresa=0 AND sede=0 AND tipo=0 AND 
            subtipo=0 AND descripcion=0 AND asignado=0 AND agenda=0 AND estado=0 AND id_usuario=" . $id_usuario;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_temporal_proyecto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "DELETE FROM temporal_proyecto WHERE id_usuario=$id_usuario";

    $this->db->query($sql);
  }

  function importar_proyectos($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34) {
      $superior = "fec_agenda,";
      $inferior = "'" . $dato['fec_agenda'] . "',";
    } else {
      $superior = "";
      $inferior = "";
    }

    $sql = "INSERT INTO proyecto (cod_proyecto,prioridad,id_tipo,id_subtipo,descripcion,proy_obs,s_artes,$superior
          id_solicitante,anio,mes,dia,id_asignado,id_empresa,status,snappys,fec_reg,user_reg,fec_solicitante,s_redes) 
          VALUES ('" . $dato['cod_proyecto'] . "','" . $dato['prioridad'] . "','" . $dato['id_tipo'] . "',
          '" . $dato['id_subtipo'] . "','" . $dato['descripcion'] . "','" . $dato['proy_obs'] . "',
          '" . $dato['s_artes'] . "',$inferior $id_usuario,'" . $dato['anio'] . "','" . $dato['mes'] . "','" . $dato['dia'] . "',
          '" . $dato['id_asignado'] . "','" . $dato['id_empresa'] . "','" . $dato['status'] . "','" . $dato['snappys'] . "', 
          NOW(),$id_usuario,NOW(), '" . $dato['s_redes'] . "')";

    $this->db->query($sql);
  }

  function importar_proyectos_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if ($dato['id_tipo'] != 15 && $dato['id_tipo'] != 20 && $dato['id_tipo'] != 34) {
      if ($dato['id_sede'] != 0 && $dato['id_sede'] != "") {
        $sql = "INSERT INTO proyecto_sede (id_proyecto,id_sede,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_proyecto'] . "','" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
      }
    }

    if ($dato['s_artes'] > 0) {
      $anio2 = substr($dato['fec_agenda'], 0, 4);
      $mes = substr($dato['fec_agenda'], 5, 2);
      $dia = substr($dato['fec_agenda'], 8, 2);

      $sql2 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
                '" . $dato['descripcion'] . "','" . $dato['fec_agenda'] . "', '" . $dato['fec_agenda'] . "','" . $anio2 . "',
                '" . $mes . "','" . $dato['nom_mes'] . "','" . $dia . "','" . $dato['nom_dia'] . "','" . $dato['color'] . "',2,
                NOW(),$id_usuario)";
      $this->db->query($sql2);
    }

    if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34 || $dato['id_tipo'] == 22) {
      $anio2 = substr($dato['fec_agenda'], 0, 4);
      $mes = substr($dato['fec_agenda'], 5, 2);
      $dia = substr($dato['fec_agenda'], 8, 2);

      $sql5 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,cod_proyecto,descripcion,
              inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,estado,fec_reg,user_reg) 
              VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
              '" . $dato['descripcion'] . "','" . $dato['fec_agenda'] . "', '" . $dato['fec_agenda'] . "','" . $anio2 . "',
              '" . $mes . "','" . $dato['nom_mes'] . "','" . $dia . "', '" . $dato['nom_dia'] . "', '" . $dato['color'] . "', 
              2, NOW(),$id_usuario)";
      $this->db->query($sql5);
    }
  }

  function importar_proyectos_duplicado($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    $anio2 = substr($dato['duplicado'], 0, 4);
    $mes = substr($dato['duplicado'], 5, 2);
    $dia = substr($dato['duplicado'], 8, 2);

    $dato['iniciosf1'] = strtotime($dato['duplicado']);
    $fechaComoEntero = strtotime($dato['duplicado']);
    $dato['mes'] = date("m", $fechaComoEntero);
    $dato['dia'] = date("d", $fechaComoEntero);
    $dato['nom_dia'] = $dias[date('w', $dato['iniciosf1'])];
    $dato['nom_mes'] = $meses[date('n', $dato['iniciosf1']) - 1];

    if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34 || $dato['id_tipo'] == 22) {
      $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,id_subtipo,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
                '" . $dato['descripcion'] . "','" . $dato['duplicado'] . "','" . $dato['duplicado'] . "','" . $anio2 . "',
                '" . $mes . "','" . $dato['nom_mes'] . "','" . $dia . "','" . $dato['nom_dia'] . "','" . $dato['color'] . "', 
                3,'" . $dato['n_duplicado'] . "','" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),
                $id_usuario)";
      $this->db->query($sql1);

      $sql2 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,id_subtipo,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
                '" . $dato['descripcion'] . "','" . $dato['duplicado'] . "','" . $dato['duplicado'] . "','" . $anio2 . "',
                '" . $mes . "','" . $dato['nom_mes'] . "','" . $dia . "','" . $dato['nom_dia'] . "','" . $dato['color'] . "', 
                3,'" . $dato['n_duplicado'] . "','" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),
                $id_usuario)";
      $this->db->query($sql2);
    } else {
      $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
            inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,id_subtipo,estado,
            fec_reg,user_reg) 
            VALUES ('" . $dato['id_proyecto'] . "','Proyecto','" . $dato['cod_proyecto'] . "',
            '" . $dato['descripcion'] . "','" . $dato['duplicado'] . "', '" . $dato['duplicado'] . "','" . $anio2 . "',
            '" . $mes . "','" . $dato['nom_mes'] . "','" . $dia . "','" . $dato['nom_dia'] . "','" . $dato['color'] . "', 
            3,'" . $dato['n_duplicado'] . "','" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),
            $id_usuario)";
      $this->db->query($sql1);
    }
  }

  function ultimo_id_proyecto()
  {
    $sql = "SELECT id_proyecto FROM proyecto
            ORDER BY id_proyecto DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_duplicado_proyecto($id_proyecto)
  {
    $sql = "SELECT id_calendar_agenda FROM calendar_agenda 
            WHERE id_secundario=$id_proyecto AND tipo_calendar='Proyecto' AND duplicado>0";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function agregar_duplicado_proyecto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $fec_agenda = $dato['fec_agenda'];
    $anio2 = substr($_POST['fec_agendad'], 0, 4);
    $mes = substr($_POST['fec_agendad'], 5, 2);
    $dia = substr($_POST['fec_agendad'], 8, 2);

    if ($dato['id_tipo'] == 15 || $dato['id_tipo'] == 20 || $dato['id_tipo'] == 34 || $dato['id_tipo'] == 22) {
      $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
              inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,
              id_subtipo,estado,fec_reg,user_reg) 
              SELECT id_proyecto,'Proyecto',cod_proyecto,descripcion,'" . $dato['fec_agenda'] . "',
              '" . $dato['fec_agenda'] . "','" . $anio2 . "', '" . $mes . "', '" . $dato['nom_mes'] . "','" . $dia . "',
              '" . $dato['nom_dia'] . "','" . $dato['color'] . "','" . $dato['s_redes'] . "','" . $dato['duplicado'] . "',
              '" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),$id_usuario
              FROM proyecto 
              WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
      $this->db->query($sql1);

      $sql2 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,cod_proyecto,descripcion,
                inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,
                id_subtipo,estado,fec_reg,user_reg) 
                SELECT id_proyecto,'Proyecto',cod_proyecto,descripcion,'" . $dato['fec_agenda'] . "',
                '" . $dato['fec_agenda'] . "','" . $anio2 . "', '" . $mes . "', '" . $dato['nom_mes'] . "','" . $dia . "',
                '" . $dato['nom_dia'] . "','" . $dato['color'] . "','" . $dato['s_redes'] . "','" . $dato['duplicado'] . "',
                '" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),$id_usuario 
                FROM proyecto 
                WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
      $this->db->query($sql2);
    } else {
      $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,cod_proyecto,descripcion,
              inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,snappy_redes,duplicado,id_tipo,
              id_subtipo,estado,fec_reg,user_reg) 
              SELECT id_proyecto,'Proyecto',cod_proyecto,descripcion,'" . $dato['fec_agenda'] . "',
              '" . $dato['fec_agenda'] . "','" . $anio2 . "', '" . $mes . "', '" . $dato['nom_mes'] . "','" . $dia . "',
              '" . $dato['nom_dia'] . "','" . $dato['color'] . "','" . $dato['s_redes'] . "','" . $dato['duplicado'] . "',
              '" . $dato['id_tipo'] . "','" . $dato['id_subtipo'] . "',2,NOW(),$id_usuario 
              FROM proyecto 
              WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
      $this->db->query($sql1);
    }
  }

  public function edit_sub_tipo()
  {
    $query = $this->db->query("SELECT * from subtipo order by nom_subtipo");
    return $query->result_array();
  }
  function get_row_s()
  {
    $sql = "SELECT * from statusp where estado=1 ORDER BY nom_statusp ASC";
    $query = $this->db->query($sql)->result_Array();
    $numero_filas = $this->db->query($sql)->num_rows();
    return $query;
  }
  function get_usuario_subtipo()
  {
    $sql = "SELECT * FROM users WHERE id_nivel NOT IN (6) AND estado=2 ORDER BY usuario_codigo";
    $query = $this->db->query($sql)->result_Array();
    //$numero_filas=$this->db->query($sql)->num_rows();
    return $query;
  }
  function get_usuario_subtipo1()
  {
    $sql = "SELECT * FROM users WHERE id_nivel IN (2,3) AND estado=2 ORDER BY usuario_codigo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_evento($id_estatus)
  {
    $empresas_usuario = $_SESSION['usuario'][0]['empresas_usuario'];

    $parte = "";
    if ($id_estatus == 0) {
      $parte = "AND ev.id_estadoe IN (1,5)";
    }

    $sql = "SELECT ev.id_evento,ev.cod_evento,ev.nom_evento,ev.id_estadoe,
            DATE_FORMAT(ev.fec_agenda,'%d/%m/%Y') as fecha_agenda,
            DATE_FORMAT(ev.hora_evento,'%H:%i') as h_evento,DATE_FORMAT(ev.fec_ini,'%d/%m/%Y') as fecha_ini,
            DATE_FORMAT(ev.fec_fin,'%d/%m/%Y') as fecha_fin,ev.autorizaciones,
            CONCAT(ev.fec_agenda,' ',ev.hora_evento) AS fec_agenda,ev.fec_ini,ev.fec_fin,
            CASE WHEN ev.tipo_link>0 THEN CONCAT('https://snappy.org.pe/',em.cod_empresa,
            ev.tipo_link) ELSE '' END AS link,ev.informe,ev.obs_evento,ev.hora_evento,ee.nom_estadoe,
            em.cod_empresa,se.cod_sede,
            CASE WHEN ev.informe=1 THEN 'Si' ELSE '' END AS c_informe,
            (SELECT COUNT(*) FROM historial_registro_mail hr 
            WHERE hr.id_evento=ev.id_evento AND hr.estado NOT IN (35,54)) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail hr 
            WHERE hr.id_evento=ev.id_evento AND hr.estado NOT IN (35,54) AND contactado=1) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail hr 
            WHERE hr.id_evento=ev.id_evento AND hr.estado NOT IN (35,54) AND asiste=1) AS asistes,
            (SELECT COUNT(*) FROM historial_registro_mail hr 
            WHERE hr.id_evento=ev.id_evento AND hr.estado NOT IN (35,54) AND no_asiste=1) AS no_asistes,
            (SELECT COUNT(*) FROM historial_registro_mail hr 
            WHERE hr.id_evento=ev.id_evento AND hr.estado=15) AS matriculados,ee.color,ob.nom_objetivo
            FROM evento ev
            LEFT JOIN estadoe ee ON ee.id_estadoe=ev.id_estadoe
            LEFT JOIN empresa em ON em.id_empresa=ev.id_empresa
            LEFT JOIN sede se ON se.id_sede=ev.id_sede
            LEFT JOIN objetivo ob ON ob.id_objetivo=ev.id_objetivo
            WHERE ev.id_empresa IN ($empresas_usuario) AND ev.estado=2 $parte
            ORDER BY CONCAT(ev.fec_agenda,' ',ev.hora_evento) DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_detalle_evento($id_evento)
  {
    /*CASE WHEN rm.id_empresa=9 THEN pr.nom_producto_interes ELSE 
              (SELECT group_concat(DISTINCT pi.nom_producto_interes) FROM registro_mail_producto r
              LEFT JOIN producto_interes pi on r.id_producto_interes=pi.id_producto_interes 
              WHERE hr.id_registro=r.id_registro and r.estado=2) END AS productosf*/
    $sql = "SELECT rm.id_registro,rm.cod_registro,ev.nom_evento,em.cod_empresa,rm.nombres_apellidos,
            rm.correo,rm.contacto1,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
            sg.color AS col_status,sg.nom_status AS nom_status,
            CASE WHEN ev.tipo_link=3 THEN pr.abreviatura ELSE pr.nom_producto_interes END AS productosf,
            hr.id_evento
            FROM historial_registro_mail hr
            LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
            LEFT JOIN evento ev ON ev.id_evento=hr.id_evento
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN status_general sg ON sg.id_status_general=hr.estado  
            LEFT JOIN producto_interes pr ON pr.id_producto_interes=hr.id_producto_interes
            WHERE hr.id_evento=$id_evento AND hr.estado NOT IN (35)
            ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function excel_list_detalle_evento($id_evento)
  {
    $sql = "SELECT rm.cod_registro,ir.nom_informe,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
            CASE WHEN MONTH(rm.fecha_inicial)=1 THEN CONCAT('Ene-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=2 THEN CONCAT('Feb-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=3 THEN CONCAT('Mar-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=4 THEN CONCAT('Abr-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=5 THEN CONCAT('May-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=6 THEN CONCAT('Jun-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=7 THEN CONCAT('Jul-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=8 THEN CONCAT('Ago-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=9 THEN CONCAT('Set-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=10 THEN CONCAT('Oct-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=11 THEN CONCAT('Nov-',YEAR(rm.fecha_inicial)) 
            WHEN MONTH(rm.fecha_inicial)=12 THEN CONCAT('Dic-',YEAR(rm.fecha_inicial)) 
            ELSE '' END AS mes_anio,rm.nombres_apellidos,rm.dni,rm.contacto1,
            de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,rm.contacto2,rm.correo,
            rm.facebook,em.cod_empresa,se.cod_sede,rm.id_registro,ac.nom_accion AS nom_accion_h,
            DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,us.usuario_codigo,
            sg.nom_status AS nom_status_h,hr.comentario AS comentario_h,rm.duplicado,
            CASE WHEN ev.tipo_link=3 THEN pi.abreviatura ELSE pi.nom_producto_interes END AS productosf
            FROM historial_registro_mail hr
            LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
            LEFT JOIN informe ir ON ir.id_informe=rm.id_informe
            LEFT JOIN departamento de ON de.id_departamento=rm.id_departamento
            LEFT JOIN provincia pr ON pr.id_provincia=rm.id_provincia
            LEFT JOIN distrito di ON di.id_distrito=rm.id_distrito
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN sede se ON se.id_sede=rm.id_sede
            LEFT JOIN accion ac ON ac.id_accion=hr.id_accion  
            LEFT JOIN users us ON us.id_usuario=hr.user_reg
            LEFT JOIN status_general sg ON sg.id_status_general=hr.estado  
            LEFT JOIN producto_interes pi ON pi.id_producto_interes=hr.id_producto_interes
            LEFT JOIN evento ev ON ev.id_evento=hr.id_evento
            WHERE hr.id_evento=$id_evento AND hr.estado NOT IN (35)
            ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_evento()
  {
    $sql = "SELECT * FROM empresa WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_sede_evento()
  {
    $sql = "SELECT * FROM sede WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_usuario_evento()
  {
    $sql = "SELECT * FROM users WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_sede_evento($id_empresa)
  {
    $sql = "SELECT * FROM sede 
            WHERE estado=2 AND id_empresa=$id_empresa";
    /*AND id_sede NOT IN (SELECT id_sede FROM evento WHERE id_empresa=$id_empresa AND estado=2 AND id_estadoe=1)*/
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function ultimo_cod_evento($anio)
  {
    $sql = "SELECT cod_evento FROM evento WHERE YEAR(fec_reg)='" . $anio . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_insert_evento($dato)
  {
    $sql = "SELECT id_evento FROM evento 
            WHERE estado=2 AND id_estadoe=1 AND id_empresa='" . $dato['id_empresa'] . "' AND 
            tipo_link='" . $dato['tipo_link'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO evento (cod_evento,nom_evento,fec_agenda,hora_evento,fec_ini,fec_fin,id_empresa,
            id_sede,tipo_link,informe,autorizaciones,obs_evento,id_objetivo,id_estadoe,estado,fec_reg,
            user_reg) 
            VALUES ('" . $dato['cod_evento'] . "','" . $dato['nom_evento'] . "','" . $dato['fec_agenda'] . "',
            '" . $dato['hora_evento'] . "','" . $dato['fec_ini'] . "','" . $dato['fec_fin'] . "',
            '" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "','" . $dato['tipo_link'] . "',
            '" . $dato['informe'] . "','" . $dato['autorizaciones'] . "','" . $dato['obs_evento'] . "',
            '" . $dato['id_objetivo'] . "','" . $dato['id_estadoe'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function get_id_evento($id_evento)
  {
    $sql = "SELECT ev.*,en.imagen,DATE_FORMAT(ev.fec_agenda,'%d/%m/%Y') as fecha_agenda,
            DATE_FORMAT(ev.fec_agenda,'%d-%m-%Y') as fecha_agenda_operativa,
            DATE_FORMAT(ev.fec_ini,'%d/%m/%Y') as fecha_ini,
            DATE_FORMAT(ev.fec_fin,'%d/%m/%Y') as fecha_fin,en.cod_empresa,se.cod_sede,
            ee.nom_estadoe,us.usuario_codigo,CASE WHEN ev.tipo_link=3 
            THEN CONCAT('https://snappy.org.pe/',en.cod_empresa,'0')
            WHEN ev.tipo_link>0 
            THEN CONCAT('https://snappy.org.pe/',en.cod_empresa,ev.tipo_link) ELSE '' END AS link
            FROM evento ev
            LEFT JOIN empresa en ON en.id_empresa=ev.id_empresa
            LEFT JOIN sede se ON se.id_sede=ev.id_sede
            LEFT JOIN estadoe ee ON ee.id_estadoe=ev.id_estadoe
            LEFT JOIN users us ON us.id_usuario=ev.user_reg
            WHERE ev.id_evento=" . $id_evento;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_update_evento($dato)
  {
    $sql = "SELECT id_evento FROM evento 
            WHERE estado=2 AND id_estadoe=1 AND id_empresa='" . $dato['id_empresa'] . "' AND 
            tipo_link='" . $dato['tipo_link'] . "' AND id_evento NOT IN ('" . $dato['id_evento'] . "')";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE evento SET nom_evento='" . $dato['nom_evento'] . "',fec_agenda='" . $dato['fec_agenda'] . "',
            hora_evento='" . $dato['hora_evento'] . "',fec_ini='" . $dato['fec_ini'] . "',
            fec_fin='" . $dato['fec_fin'] . "',id_empresa='" . $dato['id_empresa'] . "',
            id_sede='" . $dato['id_sede'] . "',tipo_link='" . $dato['tipo_link'] . "',informe='" . $dato['informe'] . "',
            autorizaciones='" . $dato['autorizaciones'] . "',obs_evento='" . $dato['obs_evento'] . "',
            id_objetivo='" . $dato['id_objetivo'] . "',id_estadoe='" . $dato['id_estadoe'] . "',fec_act=NOW(),
            user_act=$id_usuario
            WHERE id_evento =" . $dato['id_evento'] . " ";
    $this->db->query($sql);
  }

  function get_list_evento_7_despues($id_evento, $fecha_evento)
  {
    /*$sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_evento',interval 1 day)
            AND DATE_ADD('$fecha_evento',interval 7 day))) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_ADD('$fecha_evento',interval 1 day)
            AND DATE_ADD('$fecha_evento',interval 7 day))) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND asiste=1 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_evento',interval 1 day)
            AND DATE_ADD('$fecha_evento',interval 7 day))) AS asistes,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND no_asiste=1 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_evento',interval 1 day)
            AND DATE_ADD('$fecha_evento',interval 7 day))) AS no_asistes,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_evento',interval 1 day)
            AND DATE_ADD('$fecha_evento',interval 7 day))) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";*/
    $sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND fecha_accion>CURDATE()) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND fecha_accion>CURDATE()) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND asiste=1 AND fecha_accion>CURDATE()) AS asistes,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND no_asiste=1 AND fecha_accion>CURDATE()) AS no_asistes,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND fecha_accion>CURDATE()) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_evento_hoy($id_evento, $fecha_evento)
  {
    $sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND DATE(fecha_accion)='$fecha_evento') AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND DATE(fec_contactado)='$fecha_evento') AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND DATE(fecha_accion)='$fecha_evento') AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_evento_1_antes($id_evento, $fecha_evento)
  {
    $sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND DATE(fecha_accion)=DATE_SUB('$fecha_evento',interval 1 day)) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND DATE(fec_contactado)=DATE_SUB('$fecha_evento',interval 1 day)) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND DATE(fecha_accion)=DATE_SUB('$fecha_evento',interval 1 day)) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_evento_7_antes($id_evento, $fecha_evento)
  {
    $sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_evento',interval 7 day) 
            AND DATE_SUB('$fecha_evento',interval 2 day))) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_SUB('$fecha_evento',interval 7 day) 
            AND DATE_SUB('$fecha_evento',interval 2 day))) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_evento',interval 7 day) 
            AND DATE_SUB('$fecha_evento',interval 2 day))) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_evento_14_antes($id_evento, $fecha_evento)
  {
    /*$sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_evento',interval 14 day) 
            AND DATE_SUB('$fecha_evento',interval 8 day))) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_SUB('$fecha_evento',interval 14 day) 
            AND DATE_SUB('$fecha_evento',interval 8 day))) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_evento',interval 14 day) 
            AND DATE_SUB('$fecha_evento',interval 8 day))) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";*/
    $sql = "SELECT (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND DATE_SUB(fecha_accion,interval 7 day)<CURDATE()) AS registrados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND DATE_SUB(fecha_accion,interval 7 day)<CURDATE()) AS contactados,
            (SELECT COUNT(*) FROM historial_registro_mail
            WHERE id_evento=ev.id_evento AND estado=57 AND DATE_SUB(fecha_accion,interval 7 day)<CURDATE()) AS sin_revisar
            FROM evento ev
            WHERE ev.id_evento=$id_evento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_evento($dato)
  {
    $sql = "SELECT * FROM evento WHERE nom_evento='" . $dato['nom_evento'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_producto_interes($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND id_sede='" . $dato['id_sede'] . "' AND 
            nom_producto_interes='" . $dato['nom_producto_interes'] . "' AND formulario=1 AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_importar_evento($dato)
  {
    if ($dato['correo'] != "" && $dato['contacto1'] == "") {
      $sql = "SELECT hr.* FROM historial_registro_mail hr
              LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
              WHERE hr.id_evento='" . $dato['id_evento'] . "' AND hr.estado!=35 AND 
              rm.correo='" . $dato['correo'] . "'";
    } elseif ($dato['correo'] == "" && $dato['contacto1'] != "") {
      $sql = "SELECT hr.* FROM historial_registro_mail hr
              LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
              WHERE hr.id_evento='" . $dato['id_evento'] . "' AND hr.estado!=35 AND 
              rm.contacto1='" . $dato['contacto1'] . "'";
    } else {
      $sql = "SELECT hr.* FROM historial_registro_mail hr
              LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
              WHERE hr.id_evento='" . $dato['id_evento'] . "' AND hr.estado!=35 AND 
              rm.correo='" . $dato['correo'] . "' AND rm.contacto1='" . $dato['contacto1'] . "'";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_temporal_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO temporal_evento (id_usuario,v_evento,v_registro,v_nombres,v_nombres_inv,v_numerico_dni,v_cantidad_dni,
          v_correo_contacto1,v_correo_inv,v_numerico,v_cantidad,v_inicial,v_producto,v_fec_reg) 
          VALUES ($id_usuario,'" . $dato['v_evento'] . "','" . $dato['v_registro'] . "','" . $dato['v_nombres'] . "','" . $dato['v_nombres_inv'] . "',
          '" . $dato['v_numerico_dni'] . "','" . $dato['v_cantidad_dni'] . "','" . $dato['v_correo_contacto1'] . "','" . $dato['v_correo_inv'] . "',
          '" . $dato['v_numerico'] . "','" . $dato['v_cantidad'] . "','" . $dato['v_inicial'] . "','" . $dato['v_producto'] . "','" . $dato['v_fec_reg'] . "')";
    $this->db->query($sql);
  }

  function get_list_temporal_evento()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM temporal_evento WHERE id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_temporal_evento_correcto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM temporal_evento WHERE v_evento=0 AND v_registro=0 AND v_nombres=0 AND v_nombres_inv=0 AND v_numerico_dni=0 AND 
            v_cantidad_dni=0 AND v_correo_contacto1=0 AND v_correo_inv=0 AND v_numerico=0 AND v_cantidad=0 AND v_inicial=0 AND v_producto=0 AND 
            v_fec_reg=0 AND id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_historial_registro_mail_evento($dato)
  {
    if ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } else {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND
              correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function ultimo_cod_registro_mail($anio)
  {
    $sql = "SELECT cod_registro FROM registro_mail WHERE YEAR(fec_reg)='" . $anio . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function importar_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail (cod_registro,id_informe,nombres_apellidos,dni,contacto1,
          correo,id_empresa,id_sede,fecha_inicial,observacion,importacion_evento,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['cod_registro'] . "',14,'" . $dato['nombres_apellidos'] . "',
          '" . $dato['dni'] . "','" . $dato['contacto1'] . "','" . $dato['correo'] . "','" . $dato['id_empresa'] . "',
          '" . $dato['id_sede'] . "','" . $dato['fec_reg'] . "','" . $dato['nom_evento'] . "',1,1,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function ultimo_id_registro_mail()
  {
    $sql = "SELECT * FROM registro_mail ORDER BY id_registro DESC LIMIT 1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function importar_detalle_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO historial_registro_mail (id_registro,id_evento,comentario,observacion,fecha_accion,id_accion,
          importacion_evento,estado,fec_reg,user_reg)
          VALUES ('" . $dato['id_registro'] . "','" . $dato['id_evento'] . "','" . $dato['nom_evento'] . "','" . $dato['nom_evento'] . "',
          '" . $dato['fec_reg'] . "',12,1,57,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function valida_importar_detalle_evento_grado($dato)
  {
    $sql = "SELECT * FROM registro_mail_producto WHERE id_registro='" . $dato['id_registro'] . "' AND 
            id_producto_interes='" . $dato['id_producto_interes'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function importar_detalle_evento_grado($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['id_producto_interes'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function delete_temporal_evento()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "DELETE FROM temporal_evento WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
  }
  //-------------------------------------INSCRIPCIONES-----------------------------------
  function get_list_inscripcion($id_estatus = null)
  {
    if (isset($id_estatus) && $id_estatus == 0) {
      $sql = "SELECT i.*, ei.nom_estadoi,ev.nom_evento,ev.id_empresa,em.cod_empresa,po.nom_producto_interes,
      DATE_FORMAT(i.fec_reg,'%d/%m/%Y') as fecha_registro,de.nombre_departamento,pr.nombre_provincia,co.nom_conversatorio
      from inscripcion i
      LEFT JOIN estadoi ei on ei.id_estadoi=i.id_estadoi
      LEFT JOIN evento ev on ev.id_evento=i.id_evento
      LEFT JOIN departamento de on de.id_departamento=i.id_departamento
      LEFT JOIN provincia pr on pr.id_provincia=i.id_provincia
      LEFT JOIN producto_interes po on po.id_producto_interes=i.id_grado_escuela
      LEFT JOIN conversatorio co on co.id_conversatorio=i.id_conversatorio
      LEFT JOIN empresa em ON em.id_empresa=ev.id_empresa
      WHERE ev.id_estadoe=1 AND ev.estado=2 AND i.id_estadoi NOT IN (1) ORDER BY i.id_inscripcion DESC";
    } else {
      $sql = "SELECT i.*, ei.nom_estadoi,ev.nom_evento,ev.id_empresa,em.cod_empresa,po.nom_producto_interes,
      DATE_FORMAT(i.fec_reg,'%d/%m/%Y') as fecha_registro,de.nombre_departamento,pr.nombre_provincia,co.nom_conversatorio
      from inscripcion i
      LEFT JOIN estadoi ei on ei.id_estadoi=i.id_estadoi
      LEFT JOIN evento ev on ev.id_evento=i.id_evento
      LEFT JOIN departamento de on de.id_departamento=i.id_departamento
      LEFT JOIN provincia pr on pr.id_provincia=i.id_provincia
      LEFT JOIN producto_interes po on po.id_producto_interes=i.id_grado_escuela
      LEFT JOIN conversatorio co on co.id_conversatorio=i.id_conversatorio
      LEFT JOIN empresa em ON em.id_empresa=ev.id_empresa
      WHERE i.id_estadoi IN (1,2,3,4,5) ORDER BY i.id_inscripcion DESC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_estadoe()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $condicion = "";
    if ($id_usuario != 1 && $id_usuario != 5 && $id_usuario != 7) {
      $condicion = "AND id_estadoe!=2";
    }
    $sql = "SELECT * FROM estadoe WHERE estado=2 $condicion";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_estadoi()
  {
    $sql = "SELECT * from estadoi where estado=2 ORDER BY nom_estadoi ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_conversatorio()
  {
    $sql = "SELECT * FROM conversatorio WHERE estado=1 ORDER BY nom_conversatorio ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_inscripcion($id_inscripcion)
  {
    $sql = "SELECT ic.*,ev.nom_evento,ev.fec_agenda,em.id_empresa,em.cod_empresa FROM inscripcion ic
            LEFT JOIN evento ev ON ev.id_evento=ic.id_evento
            LEFT JOIN empresa em ON em.id_empresa=ev.id_empresa
            WHERE ic.id_inscripcion=$id_inscripcion";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_grado_escuela()
  {
    $sql = "SELECT * from anio_grado_escuela ORDER BY nom_anio_escuela ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_inscripcion($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE inscripcion SET nombres='" . $dato['nombres'] . "',alumno='" . $dato['alumno'] . "',correo='" . $dato['correo'] . "',
              celular='" . $dato['celular'] . "',dni='" . $dato['dni'] . "',id_grado_escuela='" . $dato['id_grado_escuela'] . "',
              id_conversatorio='" . $dato['id_conversatorio'] . "',id_estadoi='" . $dato['id_estadoi'] . "',observaciones='" . $dato['observaciones'] . "',
              fec_act=NOW(),user_act=$id_usuario
              WHERE id_inscripcion =" . $dato['id_inscripcion'] . " ";
    $this->db->query($sql);
    if ($dato['id_estadoi'] == 3) {
      $sql2 = "UPDATE inscripcion SET contactado=1,fec_contactado=NOW() WHERE id_inscripcion =" . $dato['id_inscripcion'] . "";
      $this->db->query($sql2);
    }
    if ($dato['id_estadoi'] == 4) {
      $sql3 = "UPDATE inscripcion SET asiste=1 WHERE id_inscripcion =" . $dato['id_inscripcion'] . "";
      $this->db->query($sql3);
    }
    if ($dato['id_estadoi'] == 5) {
      $sql4 = "UPDATE inscripcion SET no_asiste=1 WHERE id_inscripcion =" . $dato['id_inscripcion'] . "";
      $this->db->query($sql4);
    }
  }

  /**------------------------------------------------------ */
  function get_datos_comercial()
  {
    $sql = "SELECT status_sin_definir,interese_sin_definir FROM datos_comercial";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_datos_comercial()
  {
    $sql = "TRUNCATE TABLE datos_comercial";
    $this->db->query($sql);

    $sql2 = "INSERT INTO datos_comercial (status_sin_definir,interese_sin_definir) 
            VALUES ((SELECT COUNT(1) FROM max_historico_mail_2 
            WHERE estado=14 AND id_empresa>0),
            (SELECT COUNT(1) FROM max_historico_mail_2
            WHERE nom_productos='Sin Definir' AND estado!=35 AND id_empresa>0))";
    $this->db->query($sql2);
  }

  function get_list_registro_activo($dato)
  {
    /*(SELECT COUNT(1) FROM historial_registro_mail hi 
    WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND 
    hi.estado!=35) AS dp,*/
    $sql = "SELECT rm.duplicado,rm.id_registro,rm.cod_registro,
          DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
          rm.nombres_apellidos,rm.dni,rm.contacto1,em.cod_empresa,se.cod_sede,
          ac.nom_accion AS nom_accion_h,
          DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
          sg.nom_status AS nom_status_h,
          CASE WHEN rm.id_evento>0 THEN 'Evento' ELSE 
          (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) 
          END AS usuario_codigo,hr.comentario AS comentario_h,
          0 AS dp,hr.nom_productos AS productosf,
          CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
          CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
          FROM registro_mail rm
          LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
          LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
          LEFT JOIN sede se ON rm.id_sede=se.id_sede
          LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
          LEFT JOIN accion ac on hr.id_accion=ac.id_accion
          LEFT JOIN users us ON rm.user_reg=us.id_usuario
          LEFT JOIN status_general sg on hr.estado=sg.id_status_general
          LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
          WHERE rm.contacto1!='' AND hr.estado IN (11,13,14,16,58,59,60) AND 
          rm.id_empresa IN " . $dato['cadena'] . " AND (SELECT COUNT(1) FROM historial_registro_mail hi 
          WHERE hi.id_registro=rm.id_registro AND hi.estado=16)<5 /*AND YEAR(rm.fec_reg)=" . $dato['anio'] . "*/
          ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function excel_registro_activo($dato)
  {
    /*(SELECT COUNT(1) FROM historial_registro_mail hi 
    WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp,*/
    $sql = "SELECT rm.cod_registro,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,rm.fecha_inicial,
          CASE WHEN MONTH(rm.fecha_inicial)=1 THEN CONCAT('Ene-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=2 THEN CONCAT('Feb-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=3 THEN 
          CONCAT('Mar-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=4 THEN CONCAT('Abr-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=5 THEN CONCAT('May-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=6 THEN 
          CONCAT('Jun-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=7 THEN CONCAT('Jul-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=8 THEN CONCAT('Ago-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=9 THEN 
          CONCAT('Set-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=10 THEN CONCAT('Oct-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=11 THEN CONCAT('Nov-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=12 THEN 
          CONCAT('Dic-',YEAR(rm.fecha_inicial)) ELSE '' END AS mes_anio,rm.nombres_apellidos,rm.dni,rm.contacto1,
          de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,rm.contacto2,rm.correo,rm.facebook,em.cod_empresa,
          se.cod_sede,ac.nom_accion AS nom_accion_h,DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
          CASE WHEN rm.id_evento>0 THEN 'Evento' ELSE (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) END AS usuario_codigo,
          sg.nom_status AS nom_status_h,hr.comentario AS comentario_h,rm.duplicado,0 AS dp,DATE(rm.fecha_inicial) AS fecha_mes_anio,
          hr.nom_productos AS productosf,CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
          CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
          FROM registro_mail rm 
          LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
          LEFT JOIN departamento de ON de.id_departamento=rm.id_departamento
          LEFT JOIN provincia pr ON pr.id_provincia=rm.id_provincia
          LEFT JOIN distrito di ON di.id_distrito=rm.id_distrito
          LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
          LEFT JOIN sede se ON se.id_sede=rm.id_sede
          LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
          LEFT JOIN accion ac on hr.id_accion=ac.id_accion
          LEFT JOIN users us ON rm.user_reg=us.id_usuario
          LEFT JOIN status_general sg on hr.estado=sg.id_status_general
          LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
          WHERE rm.contacto1!='' AND hr.estado IN (11,13,14,16,58,59,60) AND 
          rm.id_empresa IN " . $dato['cadena'] . " AND 
          (SELECT COUNT(1) FROM historial_registro_mail hi WHERE hi.id_registro=rm.id_registro 
          AND hi.estado=16)<5 /*AND YEAR(rm.fec_reg)=" . $dato['anio'] . "*/
          ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_registro_todo($dato)
  {
    if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) {
      /*(SELECT COUNT(1) FROM historial_registro_mail hi 
      WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp,*/
      $sql = "SELECT rm.duplicado,rm.id_registro,rm.cod_registro,
            DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
            rm.nombres_apellidos,rm.dni,rm.contacto1,em.cod_empresa,se.cod_sede,
            ac.nom_accion AS nom_accion_h,
            DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
            sg.nom_status AS nom_status_h,CASE WHEN rm.id_evento>0 THEN 'Evento' 
            ELSE (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) 
            END AS usuario_codigo,hr.comentario AS comentario_h,
            0 AS dp,hr.nom_productos AS productosf,
            CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
            CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
            FROM registro_mail rm 
            LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN sede se ON rm.id_sede=se.id_sede
            LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
            LEFT JOIN accion ac on hr.id_accion=ac.id_accion
            LEFT JOIN users us ON rm.user_reg=us.id_usuario
            LEFT JOIN status_general sg on hr.estado=sg.id_status_general
            LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
            WHERE hr.estado in (0,10,11,13,14,15,16,17,18,19,38,54,57,58,59,60,61,62) AND 
            rm.id_empresa in " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
            ORDER BY rm.cod_registro DESC";
    } else {
      /*(SELECT COUNT(1) FROM historial_registro_mail hi 
      WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp*/
      $sql = "SELECT rm.duplicado,rm.id_registro,rm.cod_registro,
            DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
            rm.nombres_apellidos,rm.dni,rm.contacto1,em.cod_empresa,se.cod_sede,
            ac.nom_accion AS nom_accion_h,
            DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
            sg.nom_status AS nom_status_h,CASE WHEN rm.id_evento>0 THEN 'Evento' 
            ELSE (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) 
            END AS usuario_codigo,hr.comentario AS comentario_h,
            0 AS dp,hr.nom_productos AS productosf,
            CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
            CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
            FROM registro_mail rm 
            LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN sede se ON rm.id_sede=se.id_sede
            LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
            LEFT JOIN accion ac on hr.id_accion=ac.id_accion
            LEFT JOIN users us ON rm.user_reg=us.id_usuario
            LEFT JOIN status_general sg on hr.estado=sg.id_status_general
            LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
            WHERE hr.estado in (0,10,11,13,14,15,16,17,18,19,38,57,58,59,60,62) AND 
            rm.id_empresa in " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
            ORDER BY rm.cod_registro DESC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function excel_registro_todo($dato)
  {
    if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) {
      /*(SELECT COUNT(1) FROM historial_registro_mail hi 
      WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp,*/
      $sql = "SELECT rm.cod_registro,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,rm.fecha_inicial,
            CASE WHEN MONTH(rm.fecha_inicial)=1 THEN CONCAT('Ene-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=2 THEN CONCAT('Feb-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=3 THEN 
            CONCAT('Mar-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=4 THEN CONCAT('Abr-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=5 THEN CONCAT('May-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=6 THEN 
            CONCAT('Jun-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=7 THEN CONCAT('Jul-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=8 THEN CONCAT('Ago-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=9 THEN 
            CONCAT('Set-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=10 THEN CONCAT('Oct-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=11 THEN CONCAT('Nov-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=12 THEN 
            CONCAT('Dic-',YEAR(rm.fecha_inicial)) ELSE '' END AS mes_anio,rm.nombres_apellidos,rm.dni,rm.contacto1,
            de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,rm.contacto2,rm.correo,rm.facebook,em.cod_empresa,
            se.cod_sede,ac.nom_accion AS nom_accion_h,DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
            CASE WHEN rm.id_evento>0 THEN 'Evento' ELSE (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) END AS usuario_codigo,
            sg.nom_status AS nom_status_h,hr.comentario AS comentario_h,rm.duplicado,0 AS dp,DATE(rm.fecha_inicial) AS fecha_mes_anio,
            hr.nom_productos AS productosf,CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
            CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
            FROM registro_mail rm 
            LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
            LEFT JOIN departamento de ON de.id_departamento=rm.id_departamento
            LEFT JOIN provincia pr ON pr.id_provincia=rm.id_provincia
            LEFT JOIN distrito di ON di.id_distrito=rm.id_distrito
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN sede se ON se.id_sede=rm.id_sede
            LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
            LEFT JOIN accion ac on hr.id_accion=ac.id_accion
            LEFT JOIN users us ON hr.user_reg=us.id_usuario
            LEFT JOIN status_general sg on hr.estado=sg.id_status_general
            LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
            WHERE hr.estado in (0,10,11,13,14,15,16,17,18,19,38,54,57,58,59,60,61,62) AND 
            rm.id_empresa in " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
            ORDER BY rm.cod_registro DESC";
    } else {
      /*(SELECT COUNT(1) FROM historial_registro_mail hi 
      WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp,*/
      $sql = "SELECT rm.cod_registro,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,rm.fecha_inicial,
            CASE WHEN MONTH(rm.fecha_inicial)=1 THEN CONCAT('Ene-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=2 THEN CONCAT('Feb-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=3 THEN 
            CONCAT('Mar-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=4 THEN CONCAT('Abr-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=5 THEN CONCAT('May-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=6 THEN 
            CONCAT('Jun-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=7 THEN CONCAT('Jul-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=8 THEN CONCAT('Ago-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=9 THEN 
            CONCAT('Set-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=10 THEN CONCAT('Oct-',YEAR(rm.fecha_inicial))
            WHEN MONTH(rm.fecha_inicial)=11 THEN CONCAT('Nov-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=12 THEN 
            CONCAT('Dic-',YEAR(rm.fecha_inicial)) ELSE '' END AS mes_anio,rm.nombres_apellidos,rm.dni,rm.contacto1,
            de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,rm.contacto2,rm.correo,rm.facebook,em.cod_empresa,
            se.cod_sede,ac.nom_accion AS nom_accion_h,DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
            CASE WHEN rm.id_evento>0 THEN 'Evento' ELSE (CASE WHEN us.usuario_codigo!='' THEN us.usuario_codigo ELSE 'Web' END) END AS usuario_codigo,
            sg.nom_status AS nom_status_h,hr.comentario AS comentario_h,rm.duplicado,0 AS dp,DATE(rm.fecha_inicial) AS fecha_mes_anio,
            hr.nom_productos AS productosf,CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
            CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
            FROM registro_mail rm 
            LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
            LEFT JOIN departamento de ON de.id_departamento=rm.id_departamento
            LEFT JOIN provincia pr ON pr.id_provincia=rm.id_provincia
            LEFT JOIN distrito di ON di.id_distrito=rm.id_distrito
            LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
            LEFT JOIN sede se ON se.id_sede=rm.id_sede
            LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
            LEFT JOIN accion ac on hr.id_accion=ac.id_accion
            LEFT JOIN users us ON hr.user_reg=us.id_usuario
            LEFT JOIN status_general sg on hr.estado=sg.id_status_general
            LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
            WHERE hr.estado in (0,10,11,13,14,15,16,17,18,19,38,57,58,59,60,62) AND 
            rm.id_empresa in " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
            ORDER BY rm.cod_registro DESC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_registro_secretaria($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    /*(SELECT COUNT(1) FROM historial_registro_mail hi 
    WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp*/
    $sql = "SELECT rm.duplicado,rm.id_registro,rm.cod_registro,
          DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
          rm.nombres_apellidos,rm.dni,rm.contacto1,em.cod_empresa,se.cod_sede,
          hr.nom_productos AS productosf,ac.nom_accion AS nom_accion_h,
          DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
          us.usuario_codigo,sg.nom_status AS nom_status_h,
          hr.comentario AS comentario_h,
          0 AS dp,
          CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
          CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
          FROM registro_mail rm
          LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
          LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
          LEFT JOIN sede se ON se.id_sede=rm.id_sede
          LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
          LEFT JOIN accion ac on hr.id_accion=ac.id_accion
          LEFT JOIN users us ON hr.user_reg=us.id_usuario
          LEFT JOIN status_general sg on hr.estado=sg.id_status_general
          LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
          WHERE rm.user_reg=$id_usuario AND rm.id_empresa IN " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
          ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function excel_registro_secretaria($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    /*(SELECT COUNT(1) FROM historial_registro_mail hi 
    WHERE hi.id_registro=rm.id_registro AND hi.web=1 AND hi.estado!=35) AS dp,*/
    $sql = "SELECT rm.cod_registro,DATE_FORMAT(rm.fecha_inicial, '%d/%m/%Y') AS fec_inicial,rm.fecha_inicial,
          CASE WHEN MONTH(rm.fecha_inicial)=1 THEN CONCAT('Ene-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=2 THEN CONCAT('Feb-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=3 THEN 
          CONCAT('Mar-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=4 THEN CONCAT('Abr-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=5 THEN CONCAT('May-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=6 THEN 
          CONCAT('Jun-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=7 THEN CONCAT('Jul-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=8 THEN CONCAT('Ago-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=9 THEN 
          CONCAT('Set-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=10 THEN CONCAT('Oct-',YEAR(rm.fecha_inicial))
          WHEN MONTH(rm.fecha_inicial)=11 THEN CONCAT('Nov-',YEAR(rm.fecha_inicial)) WHEN MONTH(rm.fecha_inicial)=12 THEN 
          CONCAT('Dic-',YEAR(rm.fecha_inicial)) ELSE '' END AS mes_anio,rm.nombres_apellidos,rm.dni,rm.contacto1,
          de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,rm.contacto2,rm.correo,rm.facebook,em.cod_empresa,
          se.cod_sede,hr.nom_productos AS productosf,ac.nom_accion AS nom_accion_h,DATE_FORMAT(hr.fecha_accion, '%d/%m/%Y') AS fecha_status_h,
          us.usuario_codigo,sg.nom_status AS nom_status_h,hr.comentario AS comentario_h,rm.duplicado,0 AS dp,
          CASE WHEN rm.id_informe=0 THEN 'Sin Definir' ELSE fi.nom_informe END AS nom_informe,
          CASE WHEN uh.usuario_codigo!='' THEN uh.usuario_codigo ELSE 'Web' END AS usuario_historico
          FROM registro_mail rm 
          LEFT JOIN informe fi ON fi.id_informe=rm.id_informe
          LEFT JOIN departamento de ON de.id_departamento=rm.id_departamento
          LEFT JOIN provincia pr ON pr.id_provincia=rm.id_provincia
          LEFT JOIN distrito di ON di.id_distrito=rm.id_distrito
          LEFT JOIN empresa em ON em.id_empresa=rm.id_empresa
          LEFT JOIN sede se ON se.id_sede=rm.id_sede
          LEFT JOIN max_historico_mail hr on rm.id_registro=hr.id_registro
          LEFT JOIN accion ac on hr.id_accion=ac.id_accion
          LEFT JOIN users us ON hr.user_reg=us.id_usuario
          LEFT JOIN status_general sg on hr.estado=sg.id_status_general
          LEFT JOIN users uh ON uh.id_usuario=hr.user_reg
          WHERE rm.user_reg=$id_usuario AND rm.id_empresa IN " . $dato['cadena'] . " AND YEAR(rm.fec_reg)=" . $dato['anio'] . "
          ORDER BY rm.cod_registro DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_correo_registro($correo)
  {
    $sql = "SELECT rm.id_registro,hr.comentario FROM registro_mail rm
            LEFT JOIN max_historico_mail hr ON hr.id_registro=rm.id_registro
            WHERE rm.correo='$correo'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_registro_mail_mailing($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,id_accion,fecha_accion,h_mailing,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario'] . "','" . $dato['observacion'] . "',2,'" . $dato['fecha_accion'] . "',1,62,NOW(),
          $id_usuario)";
    $this->db->query($sql);
  }

  function get_list_historial_registro($id_registro)
  {
    $sql = "SELECT r.*,s.nom_status,a.nom_accion, DATE_FORMAT(r.fec_reg, '%d/%m/%Y') as fecha_registro,im.nom_informe,
            DATE_FORMAT(r.fecha_accion, '%d/%m/%Y') as fec_accion,u.usuario_nombres,u.usuario_apater,u.usuario_codigo
            FROM historial_registro_mail r
            LEFT JOIN status_general s on s.id_status_general=r.estado
            LEFT JOIN accion a on a.id_accion=r.id_accion
            LEFT JOIN users u on u.id_usuario=r.user_reg
            LEFT JOIN informe im ON im.id_informe=r.id_tipo
            WHERE r.id_registro=$id_registro and r.estado<>35 ORDER BY r.id_historial DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_registro($id_registro)
  {
    $sql = "SELECT r.*,u.usuario_codigo AS cod_user_actu,i.nom_informe,e.cod_empresa,se.cod_sede,
          p.nombre_departamento,v.nombre_provincia,t.nombre_distrito,us.usuario_codigo,
          DATE_FORMAT(r.fecha_inicial, '%Y-%m-%d') as fec_inicial,hr.comentario as ultimo_comentario,sh.nom_status
          FROM registro_mail r 
          LEFT JOIN informe i ON i.id_informe=r.id_informe
          LEFT JOIN status_general s ON s.id_status_general=r.estado
          LEFT JOIN empresa e ON e.id_empresa=r.id_empresa
          LEFT JOIN sede se ON se.id_sede=r.id_sede
          LEFT JOIN departamento p ON p.id_departamento=r.id_departamento
          LEFT JOIN provincia v ON v.id_provincia=r.id_provincia
          LEFT JOIN distrito t ON t.id_distrito=r.id_distrito
          LEFT JOIN users u ON u.id_usuario=r.user_act
          LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=r.id_registro
          LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial     
          LEFT JOIN users us ON us.id_usuario=hr.user_reg         
          LEFT JOIN status_general sh on sh.id_status_general=hr.estado
          WHERE r.id_registro ='$id_registro'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_registro_mail_sede($id_registro)
  {
    $sql = "SELECT rm.*,se.cod_sede FROM registro_mail rm
            LEFT JOIN sede se ON se.id_sede=rm.id_sede
            WHERE rm.estado=2 AND rm.id_registro=$id_registro";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_registro_mail_producto($id_registro)
  {
    $sql = "SELECT rp.*,pr.nom_producto_interes FROM registro_mail_producto rp
            LEFT JOIN producto_interes pr ON pr.id_producto_interes=rp.id_producto_interes
            WHERE rp.estado=2 AND rp.id_registro=$id_registro";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_sede($id_empresa)
  {
    $sql = "SELECT * FROM sede WHERE estado=2 AND id_empresa =" . $id_empresa;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_estado_mail()
  {
    $sql = "SELECT * from status_general where id_status_mae=4 AND estado=2 ORDER BY nom_status ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_accion()
  {
    $sql = "SELECT * FROM accion WHERE estado=2 AND id_modulo=1 ORDER BY nom_accion ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_informe()
  {
    $sql = "SELECT * FROM informe 
              WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_informe_secretaria()
  {
    $sql = "SELECT * FROM informe WHERE id_informe IN (1,2,3,4,5) AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_departamento()
  {
    $sql = "SELECT * FROM departamento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_provincia()
  {
    $sql = "SELECT * FROM provincia";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_provincia_editar($id_departamento)
  {
    $sql = "SELECT * FROM provincia where id_departamento='$id_departamento'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_distrito_editar($id_departamento, $id_provincia)
  {
    $sql = "SELECT * from distrito where id_provincia='$id_provincia' and id_departamento='$id_departamento' and  estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function get_list_distrito()
  {
    $sql = "SELECT * from distrito where estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function departamento_provincia($departamento)
  {
    $query = $this->db->query("SELECT id_provincia,id_departamento,nombre_provincia from provincia where id_departamento='$departamento' ORDER BY nombre_provincia ASC");
    return $query->result_array();
  }

  function provincia_distrito($provincia)
  {
    $query = $this->db->query("SELECT id_distrito,id_provincia,nombre_distrito from distrito where id_provincia='$provincia' ORDER BY nombre_distrito ASC");
    return $query->result_array();
  }

  function empresa_sede_combo($empresa)
  {
    $query = $this->db->query("SELECT id_sede,id_empresa,cod_sede FROM sede WHERE estado=2 AND id_empresa='$empresa'");
    return $query->result_array();
  }

  function get_list_empresa_sede_producto($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND 
            id_sede='" . $dato['id_sede'] . "' AND estado=2 ORDER BY nom_producto_interes ASC";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_sede_producto0($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND 
            id_sede='" . $dato['id_sede'] . "' AND estado=2 ORDER BY nom_producto_interes ASC LIMIT 0,6";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_sede_producto10($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND 
            id_sede='" . $dato['id_sede'] . "' AND estado=2 ORDER BY nom_producto_interes ASC LIMIT 6,6";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function get_list_empresa_sede_producto20($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND 
            id_sede='" . $dato['id_sede'] . "' AND estado=2 ORDER BY nom_producto_interes ASC LIMIT 12,6";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function get_list_empresa_sede_producto30($dato)
  {
    $sql = "SELECT * FROM producto_interes WHERE id_empresa='" . $dato['id_empresa'] . "' AND 
            id_sede='" . $dato['id_sede'] . "' AND estado=2 ORDER BY nom_producto_interes ASC LIMIT 18,6";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function ultimo_registro_mail()
  {
    $sql = "SELECT * FROM registro_mail ORDER BY id_registro DESC LIMIT 1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_insert_registro_mail($dato)
  {
    if ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND id_empresa='" . $dato['id_empresa'] . "' 
              AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND id_empresa='" . $dato['id_empresa'] . "' 
              AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' 
              AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } else {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND
              correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail (cod_registro,id_informe,fecha_inicial,nombres_apellidos,dni,id_departamento,
          id_provincia,id_distrito,contacto1,contacto2,correo,facebook,id_empresa,id_sede,mailing,
          mensaje,observacion,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['cod_registro'] . "','" . $dato['id_informe'] . "',NOW(),
          '" . $dato['nombres_apellidos'] . "','" . $dato['dni'] . "','" . $dato['id_departamento'] . "','" . $dato['id_provincia'] . "',
          '" . $dato['id_distrito'] . "','" . $dato['contacto1'] . "','" . $dato['contacto2'] . "','" . $dato['correo'] . "',
          '" . $dato['facebook'] . "','" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "','" . $dato['mailing'] . "',
          '" . $dato['mensaje'] . "','" . $dato['observacion'] . "',1,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function primer_insert_historial_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if ($dato['observacion'] != "" && $dato['mensaje'] != "") {
      $sql = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,fecha_accion,estado,fec_reg,
            user_reg)
            VALUES ('" . $dato['id_registro'] . "','" . $dato['observacion'] . "','" . $dato['observacion'] . "',NOW(),'" . $dato['estado'] . "',
            NOW(),$id_usuario)";
      $this->db->query($sql);
    }
    $sql2 = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,fecha_accion,id_accion,estado,fec_reg,
    user_reg)
    VALUES ('" . $dato['id_registro'] . "','" . $dato['observacion'] . "','" . $dato['mensaje'] . "',NOW(),1,14,NOW(),$id_usuario)";
    $this->db->query($sql2);
  }

  function insert_registro_mail_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
        VALUES ('" . $dato['id_registro'] . "','" . $dato['id_producto_interes'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function insert_registro_mail_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO registro_mail_sede (id_registro,id_sede,estado,fec_reg,user_reg) 
        VALUES ((SELECT id_registro FROM registro_mail WHERE cod_registro='" . $dato['cod_registro'] . "' AND estado='14'),
        '" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function get_id_sede_registro($id_registro)
  {
    $sql = "SELECT * FROM registro_mail_sede WHERE id_registro=$id_registro AND estado=2";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  function reiniciar_registro_sede_general($dato)
  {
    //$sql="UPDATE registro_mail_sede SET estado=1 WHERE id_registro='".$dato['id_registro']."'";
    $sql = "DELETE FROM registro_mail_sede WHERE id_registro='" . $dato['id_registro'] . "'";

    $this->db->query($sql);
  }

  function agregar_registro_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO registro_mail_sede (id_registro,id_sede,estado,fec_reg,user_reg) 
        VALUES ('" . $dato['id_registro'] . "','" . $dato['new_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function agregar_registro_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
        VALUES ('" . $dato['id_registro'] . "','" . $dato['id_producto_interes'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function update_registro_mail_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE registro_mail_sede SET
        (id_registro,id_sede,estado,fec_reg,user_reg) 
        VALUES ((SELECT id_registro FROM registro_mail WHERE cod_registro='" . $dato['cod_registro'] . "' AND estado='14'),
        '" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  /** */
  function get_id_producto_registro($id_registro)
  {
    $sql = "SELECT * FROM registro_mail_producto WHERE id_registro=$id_registro AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function reiniciar_registro_producto($dato)
  {
    $sql = "UPDATE registro_mail_producto SET estado=1 WHERE id_registro='" . $dato['id_registro'] . "'";

    $this->db->query($sql);
  }

  function limpiar_registro_producto($dato)
  {
    $sql = "DELETE FROM registro_mail_producto WHERE id_registro='" . $dato['id_registro'] . "'";
    $this->db->query($sql);
  }

  function update_registro_mail_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE registro_mail_producto SET
        (id_registro,id_producto,estado,fec_reg,user_reg) 
        VALUES ((SELECT id_registro FROM registro_mail WHERE cod_registro='" . $dato['cod_registro'] . "' AND estado='14'),
        '" . $dato['id_producto'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function get_list_accion_registro_mail()
  {
    $sql = "SELECT * FROM accion WHERE estado=2 AND id_modulo=1 AND id_accion NOT IN (1,2,12) ORDER BY nom_accion ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_accion_status($dato)
  {
    if ($dato['id_accion'] == 1) {
      $sql = "SELECT * FROM status_general WHERE id_status_general IN (14) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 2) {
      $sql = "SELECT * FROM status_general WHERE id_status_general IN (62) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 3) {
      $sql = "SELECT * FROM status_general WHERE id_status_general IN (11,13,16) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 4) {
      $sql = "SELECT * FROM status_general WHERE id_status_general IN (11,14,13,16) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 5) {
      $sql = "SELECT * FROM status_general WHERE id_status_general IN (10,17,19,38) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 11) {
      $sql = "SELECT * FROM status_general WHERE id_status_general in (54,61) ORDER BY nom_status ASC";
    } elseif ($dato['id_accion'] == 13) {
      $sql = "SELECT * FROM status_general WHERE id_status_general in (15) ORDER BY nom_status ASC";
    } else {
      $sql = "SELECT * FROM status_general WHERE id_status_mae IN (4) ORDER BY nom_status ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_historial_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,id_tipo,id_accion,fecha_accion,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario1'] . "','" . $dato['observacion'] . "','" . $dato['id_tipo'] . "',
          '" . $dato['id_accion'] . "','" . $dato['fecha_accion'] . "','" . $dato['id_status'] . "',NOW(),$id_usuario)";
    $this->db->query($sql);

    if ($dato['ultimo_comentario'] != $dato['comentario1']) {
      $sql2 = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,id_accion,fecha_accion,estado,
          fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario1'] . "','" . $dato['comentario1'] . "','" . $dato['id_accion'] . "',
          '" . $dato['fecha_accion'] . "','" . $dato['id_status'] . "',NOW(),$id_usuario)";
      $this->db->query($sql2);
    }
    //-------------PARA EL EVENTO (NO BORRAR NI TOCAR)--------------------
    if ($dato['id_accion'] == 3 && $dato['id_status'] == 16) {
      $sql6 = "UPDATE registro_mail SET fecha_evento='" . $dato['fecha_accion'] . "' 
            WHERE id_registro='" . $dato['id_registro'] . "'";
      $this->db->query($sql6);
    } else {
      $sql7 = "UPDATE registro_mail SET fecha_evento=''
            WHERE id_registro='" . $dato['id_registro'] . "'";
      $this->db->query($sql7);
    }
  }

  function insert_registro_mail_agenda($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT into calendar_agenda (cod_proyecto, descripcion, inicio, fin, anio, mes, nom_mes, dia, 
          nom_dia, color, estado, fec_reg, user_reg) 
          values ('" . $dato['cod_proyecto'] . "','" . $dato['descripcion'] . "','" . $dato['inicio'] . "', 
          '" . $dato['fin'] . "','" . $dato['anio'] . "','" . $dato['mes'] . "','" . $dato['nom_mes'] . "',
          '" . $dato['dia'] . "','" . $dato['nom_dia'] . "', '" . $dato['color'] . "', 2, NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function get_id_informe($id_informe)
  {
    $sql = "SELECT * from informe where id_informe=$id_informe";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function reiniciar_registro_sede($dato)
  {
    $sql = "UPDATE registro_mail_sede SET estado=1 WHERE id_registro='" . $dato['id_registro'] . "'";
    $this->db->query($sql);
  }

  function update_registro_sede($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO registro_mail_sede (id_registro,id_sede,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['id_sede'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function update_registro_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
        VALUES ('" . $dato['id_registro'] . "','" . $dato['id_producto'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function valida_update_registro_mail($dato)
  {
    if ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND id_registro!='" . $dato['id_registro'] . "' AND estado=1";
    } else {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND
              correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND id_registro!='" . $dato['id_registro'] . "' AND 
              estado=1";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE registro_mail SET nombres_apellidos='" . $dato['nombres_apellidos'] . "',
          dni='" . $dato['dni'] . "',id_departamento='" . $dato['id_departamento'] . "',
          id_provincia='" . $dato['id_provincia'] . "',id_distrito='" . $dato['id_distrito'] . "',
          contacto1='" . $dato['contacto1'] . "', contacto2='" . $dato['contacto2'] . "',correo='" . $dato['correo'] . "',
          facebook='" . $dato['facebook'] . "',mailing='" . $dato['mailing'] . "',id_empresa='" . $dato['id_empresa'] . "',
          id_informe='" . $dato['id_informe'] . "',fec_act=NOW(),user_act=$id_usuario,
          id_sede='" . $dato['id_sede'] . "'
          WHERE id_registro='" . $dato['id_registro'] . "'";
    $this->db->query($sql);
  }

  function delete_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO historial_registro_mail (id_registro,estado,fec_eli,user_eli) VALUES ('" . $dato['id_registro'] . "',35,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function delete_registro_mail_agenda($dato)
  {
    $sql = "DELETE FROM calendar_agenda WHERE cod_proyecto='" . $dato['cod_proyecto'] . "'";
    $this->db->query($sql);
  }

  function update_registro_mail_agenda($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE calendar_agenda SET descripcion='" . $dato['descripcion'] . "',inicio='" . $dato['inicio'] . "', 
          fin='" . $dato['fin'] . "',anio='" . $dato['anio'] . "',mes='" . $dato['mes'] . "', 
          nom_mes='" . $dato['nom_mes'] . "',dia='" . $dato['dia'] . "',nom_dia='" . $dato['nom_dia'] . "', 
          color='" . $dato['color'] . "',fec_act=NOW(),user_act=$id_usuario
          WHERE cod_proyecto='" . $dato['cod_proyecto'] . "'";
    $this->db->query($sql);
  }

  function insert_duplicado_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT  INTO registro_mail (cod_registro,id_informe,fecha_inicial,nombres_apellidos,id_departamento,
    id_provincia, id_distrito, contacto1, contacto2, correo, facebook, mailing,producto,
    mensaje, observacion, estado, fecha_status, id_accion,fecha_accion, observacion_duplicado,id_origen,
    origen, fec_reg,user_reg) 
    values ('" . $dato['cod_registro'] . "','" . $dato['id_informe'] . "',NOW(),
    '" . $dato['nombres_apellidos'] . "','" . $dato['id_departamento'] . "','" . $dato['id_provincia'] . "',
    '" . $dato['id_distrito'] . "','" . $dato['contacto1'] . "','" . $dato['contacto2'] . "','" . $dato['correo'] . "',
    '" . $dato['facebook'] . "','" . $dato['mailing'] . "','" . $dato['producto'] . "','" . $dato['mensaje'] . "',
    '" . $dato['observacion'] . "','" . $dato['id_status'] . "','" . $dato['fecha_status'] . "',
    '" . $dato['id_accion'] . "','" . $dato['fecha_accion'] . "','" . $dato['observacion_duplicado'] . "','" . $dato['id_origen'] . "',
    '" . $dato['origen'] . "',NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function get_cant_registro_mail()
  {
    $anio = date('Y');
    $sql = "SELECT * from registro_mail WHERE YEAR(fec_reg)=$anio";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function get_cant_registro_ticket()
  {
    $sql = "SELECT cod_ticket FROM ticket  order by(cod_ticket) desc limit 1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_informe()
  {
    $sql = "SELECT * FROM informe WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_departamento()
  {
    $sql = "SELECT * FROM departamento";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_provincia($id_departamento)
  {
    $sql = "SELECT * FROM provincia WHERE id_departamento='$id_departamento'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_distrito($id_provincia)
  {
    $sql = "SELECT * FROM distrito WHERE id_provincia='$id_provincia'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_solo_provincia()
  {
    $sql = "SELECT * FROM provincia";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_solo_distrito()
  {
    $sql = "SELECT * FROM distrito";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_solo_sede()
  {
    $sql = "SELECT * FROM sede WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function buscar_solo_producto_interes()
  {
    $sql = "SELECT * FROM producto_interes WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_importar_registro_mail($dato)
  {
    if ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND 
              estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
      $sql = "SELECT * FROM registro_mail WHERE contacto1='" . $dato['contacto1'] . "' AND correo='" . $dato['correo'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    } else {
      $sql = "SELECT * FROM registro_mail WHERE dni='" . $dato['dni'] . "' AND contacto1='" . $dato['contacto1'] . "' AND
              correo='" . $dato['correo'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=1";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_temporal_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO temporal_registro_mail (id_usuario,v_registro,v_informe,v_fecha_inicial,v_nombres_apellidos,v_nombres_apellidos_inv,
          v_numerico_dni,v_cantidad_dni,v_nom_producto_interes,v_contacto1,v_numerico,v_cantidad,v_inicial,v_nombre_departamento,
          v_nombre_provincia,v_nombre_distrito,v_correo,v_correo_inv,v_cod_empresa,v_cod_sede,v_comentario) 
          VALUES ($id_usuario,'" . $dato['v_registro'] . "','" . $dato['v_informe'] . "','" . $dato['v_fecha_inicial'] . "','" . $dato['v_nombres_apellidos'] . "',
          '" . $dato['v_nombres_apellidos_inv'] . "','" . $dato['v_numerico_dni'] . "','" . $dato['v_cantidad_dni'] . "',
          '" . $dato['v_nom_producto_interes'] . "','" . $dato['v_contacto1'] . "','" . $dato['v_numerico'] . "','" . $dato['v_cantidad'] . "',
          '" . $dato['v_inicial'] . "','" . $dato['v_nombre_departamento'] . "','" . $dato['v_nombre_provincia'] . "','" . $dato['v_nombre_distrito'] . "',
          '" . $dato['v_correo'] . "','" . $dato['v_correo_inv'] . "','" . $dato['v_cod_empresa'] . "','" . $dato['v_cod_sede'] . "','" . $dato['v_comentario'] . "')";
    $this->db->query($sql);
  }

  function get_list_temporal_registro_mail()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM temporal_registro_mail WHERE id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_temporal_registro_mail_correcto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM temporal_registro_mail WHERE v_registro=0 AND v_informe=0 AND v_fecha_inicial=0 AND v_nombres_apellidos=0 AND 
            v_nombres_apellidos_inv=0 AND v_numerico_dni=0 AND v_cantidad_dni=0 AND v_nom_producto_interes=0 AND v_contacto1=0 AND 
            v_numerico=0 AND v_cantidad=0 AND v_inicial=0 AND v_nombre_departamento=0 AND v_nombre_provincia=0 AND v_nombre_distrito=0 AND 
            v_correo=0 AND v_correo_inv=0 AND v_cod_empresa=0 AND v_cod_sede=0 AND v_comentario=0 AND id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_temporal_registro_mail()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "DELETE FROM temporal_registro_mail WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
  }

  function importar_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail (cod_registro,id_informe,fecha_inicial,nombres_apellidos,dni,id_departamento,id_provincia,id_distrito,
          contacto1,contacto2,correo,facebook,id_empresa,id_sede,observacion,mensaje,importacion_comercial,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['cod_registro'] . "','" . $dato['id_informe'] . "','" . $dato['fecha_inicial'] . "','" . addslashes($dato['nombres_apellidos']) . "',
          '" . $dato['dni'] . "','" . $dato['id_departamento'] . "','" . $dato['id_provincia'] . "','" . $dato['id_distrito'] . "','" . $dato['contacto1'] . "',
          '" . $dato['contacto2'] . "','" . $dato['correo'] . "','" . $dato['facebook'] . "','" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "',
          '" . $dato['comentario'] . "','" . $dato['observacion'] . "',1,1,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function primer_importar_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if ($dato['comentario'] != "" && $dato['observacion'] != "") {
      $sql = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,fecha_accion,id_accion,importacion_comercial,estado,fec_reg,
            user_reg)
            VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario'] . "','" . $dato['comentario'] . "',NOW(),1,1,14,NOW(),$id_usuario)";
      $this->db->query($sql);
    }
    $sql2 = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,fecha_accion,estado,fec_reg,
          user_reg)
          VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario'] . "','" . $dato['observacion'] . "',NOW(),14,
          NOW(),$id_usuario)";
    $this->db->query($sql2);
  }

  function valida_imp_registro_mail_producto($dato)
  {
    $sql = "SELECT * FROM registro_mail_producto WHERE id_registro='" . $dato['id_registro'] . "' AND id_producto_interes='" . $dato['id_producto_interes'] . "' AND
            estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function imp_registro_mail_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['id_producto_interes'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function get_list_producto_interes()
  {
    $sql = "SELECT pn.*,em.cod_empresa,se.cod_sede,DATE_FORMAT(pn.fecha_inicio,'%d/%m/%Y') as fec_inicio,
            DATE_FORMAT(pn.fecha_fin,'%d/%m/%Y') as fec_fin,CASE WHEN pn.total=1 THEN 'Si' ELSE 'No' END AS totales,
            CASE WHEN pn.formulario=1 THEN 'Si' ELSE 'No' END AS formularios,es.nom_status,es.orden
            FROM producto_interes pn
            LEFT JOIN empresa em on em.id_empresa=pn.id_empresa
            LEFT JOIN sede se on se.id_sede=pn.id_sede
            LEFT JOIN status es on es.id_status=pn.estado
            ORDER BY em.cod_empresa ASC,se.cod_sede ASC,pn.nom_producto_interes ASC,es.orden ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  //---------------------------------------------PROYECTO--------------------------------------------
  function get_list_empresa_sede_uno($dato)
  {
    $sql = "SELECT * FROM sede WHERE id_empresa='" . $dato['empresas'] . "' AND estado=2 
            ORDER BY cod_sede ASC";

    $query = $this->db->query($sql)->result_Array();

    return $query;
  }

  //NO BORRAR ES DEL MODULO USUARIO
  function get_list_empresa_sede_varios($dato)
  {
    $sql = "SELECT * FROM sede WHERE id_empresa IN (" . $dato['empresas'] . ") AND estado=2 
            ORDER BY cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();

    return $query;
  }
  //---------------------------------------------MAILING----------------------------------------------------
  function get_list_mailing_activo()
  {
    $sql = "SELECT i.id_registro,i.cod_registro,fi.nom_informe,
              DATE_FORMAT(i.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
              i.nombres_apellidos,ac.nom_accion,e.cod_empresa,i.mensaje,
              sg.nom_status,i.fecha_inicial AS orden,
              i.correo
              FROM registro_mail i
              LEFT JOIN status_general sg ON sg.id_status_general=i.estado
              LEFT JOIN distrito d ON d.id_distrito=i.id_distrito
              LEFT JOIN informe fi ON fi.id_informe=i.id_informe
              LEFT JOIN empresa e ON e.id_empresa=i.id_empresa
              LEFT JOIN sede s ON s.id_sede=i.id_sede
              LEFT JOIN accion ac ON ac.id_accion=i.id_accion
              LEFT JOIN producto_interes ps ON ps.id_producto_interes=i.producto
              WHERE i.estado IN (11,13,14,16,18) AND i.mailing='' AND i.correo!=''
              GROUP BY i.contacto1 
              ORDER BY i.fecha_inicial DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_mailing_inactivo()
  {
    $sql = "SELECT i.id_registro,i.cod_registro,fi.nom_informe,
            DATE_FORMAT(i.fecha_inicial, '%d/%m/%Y') AS fec_inicial,
            i.nombres_apellidos,ac.nom_accion,e.cod_empresa,i.mensaje,
            sg.nom_status,i.fecha_inicial AS orden,
            i.correo
            from registro_mail i
            left join status_general sg on sg.id_status_general=i.estado
            left join distrito d on d.id_distrito=i.id_distrito
            left join informe fi on fi.id_informe=i.id_informe
            left join empresa e on e.id_empresa=i.id_empresa
            left join sede s on s.id_sede=i.id_sede
            left join accion ac on ac.id_accion=i.id_accion
            left join producto_interes ps on ps.id_producto_interes=i.producto
            WHERE i.estado in (10,15,17,19) AND i.mailing='' 
            GROUP BY i.contacto1 
            ORDER BY i.fecha_inicial DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_mailing($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO mailing (fecha_envio,observaciones,fec_reg,user_reg,estado) 
            VALUES ('" . $dato['fecha_envio'] . "','" . $dato['observaciones'] . "',
            DATE_ADD(NOW(), INTERVAL 2 HOUR),$id_usuario,1)";
    $this->db->query($sql);
  }

  function ultimo_id_mailing()
  {
    $sql = "SELECT id_mailing FROM mailing 
            ORDER BY id_mailing DESC
            LIMIT 1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_mailing_detalle($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO mailing_detalle (id_mailing,id_registro,fec_reg,user_reg,estado) 
            VALUES ('" . $dato['id_mailing'] . "','" . $dato['id_registro'] . "',
            DATE_ADD(NOW(), INTERVAL 2 HOUR),$id_usuario,1)";
    $this->db->query($sql);

    $sql2 = "INSERT INTO historial_registro_mail (id_registro,observacion,id_accion,
            fecha_accion,fec_reg,user_reg) 
            VALUES ('" . $dato['id_registro'] . "','" . $dato['observaciones'] . "',2,
            DATE_ADD(NOW(), INTERVAL 2 HOUR),DATE_ADD(NOW(), INTERVAL 2 HOUR),$id_usuario)";
    $this->db->query($sql2);
  }

  function valida_duplicado_email($dato)
  {
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];

    $sql = "SELECT * from historial_registro_mail where id_registro ='" . $dato['id_registro'] . "' and observacion='" . $dato['observacion'] . "' and estado='" . $dato['id_status'] . "' and id_accion='" . $dato['id_accion'] . "'";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_duplicado_email_comentario($dato)
  {
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];

    $sql = "SELECT * from historial_registro_mail where id_registro ='" . $dato['id_registro'] . "' and observacion='" . $dato['observacion'] . "'";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_anio_proyecto()
  {
    $sql = "SELECT anio FROM proyecto GROUP BY anio";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_historial_mail($id_historial)
  {
    $sql = "SELECT * FROM historial_registro_mail 
            WHERE id_historial ='$id_historial'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_duplicado_email_upd($dato)
  {
    $sql = "SELECT * FROM historial_registro_mail WHERE id_registro ='" . $dato['id_registro'] . "' AND observacion='" . $dato['observacion'] . "' 
            AND estado='" . $dato['id_status'] . "' AND id_accion='" . $dato['id_accion'] . "' AND id_historial<>'" . $dato['id_historial'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_duplicado_email_comentario_upd($dato)
  {
    $sql = "SELECT * FROM historial_registro_mail WHERE id_registro ='" . $dato['id_registro'] . "' AND observacion='" . $dato['observacion'] . "' 
            AND id_historial<>'" . $dato['id_historial'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_historial_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE historial_registro_mail SET comentario='" . $dato['comentario'] . "',observacion='" . $dato['observacion'] . "',
            id_tipo='" . $dato['id_tipo'] . "',id_accion='" . $dato['id_accion'] . "',fecha_accion='" . $dato['fecha_accion'] . "',
            estado='" . $dato['id_status'] . "',fec_act=NOW(),user_act=$id_usuario
            WHERE id_historial='" . $dato['id_historial'] . "'";
    $this->db->query($sql);
    if ($dato['ultimo_comentario'] != $dato['comentario']) {
      $sql2 = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,id_accion,fecha_accion,estado,
          fec_reg,user_reg) 
          VALUES ('" . $dato['id_registro'] . "','" . $dato['comentario'] . "','" . $dato['comentario'] . "','" . $dato['id_accion'] . "',
          '" . $dato['fecha_accion'] . "','" . $dato['id_status'] . "',NOW(),$id_usuario)";
      $this->db->query($sql2);
    }
  }

  function update_historial_registro_mail_evento($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE historial_registro_mail SET estado='" . $dato['id_status'] . "',fec_act=NOW(),user_act=$id_usuario
            WHERE id_historial='" . $dato['id_historial'] . "'";
    $this->db->query($sql);
    if ($dato['id_status'] == 58) {
      $sql2 = "UPDATE historial_registro_mail SET contactado=1,fec_contactado=NOW()
            WHERE id_historial='" . $dato['id_historial'] . "'";
      $this->db->query($sql2);
    }
    if ($dato['id_status'] == 59) {
      $sql2 = "UPDATE historial_registro_mail SET asiste=1
            WHERE id_historial='" . $dato['id_historial'] . "'";
      $this->db->query($sql2);
    }
    if ($dato['id_status'] == 60) {
      $sql2 = "UPDATE historial_registro_mail SET no_asiste=1
            WHERE id_historial='" . $dato['id_historial'] . "'";
      $this->db->query($sql2);
    }
  }

  function delete_historial_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $fecha = date('Y-m-d H:i:s');

    $sql = "UPDATE historial_registro_mail  SET estado='35',fec_eli='$fecha',user_eli='$id_usuario' where
    id_historial='" . $dato['id_historial'] . "' ";

    $this->db->query($sql);
  }

  function get_list_duplicados($id_proyecto)
  {
    $sql = "SELECT ca.id_calendar_agenda,cr.id_calendar_redes,ca.inicio,
            DATE_FORMAT(ca.inicio,'%d/%m/%Y') as fecha_inicio,ca.snappy_redes,ti.nom_tipo,st.nom_subtipo
            FROM calendar_agenda ca
            LEFT JOIN calendar_redes cr ON ca.id_secundario=cr.id_secundario AND ca.tipo_calendar=ca.tipo_calendar AND ca.duplicado=cr.duplicado
            LEFT JOIN tipo ti ON ca.id_tipo=ti.id_tipo
            LEFT JOIN subtipo st ON ca.id_subtipo=st.id_subtipo
            WHERE ca.id_secundario=$id_proyecto AND ca.tipo_calendar='Proyecto' AND ca.estado=2 AND 
            ca.duplicado>0
            ORDER BY ca.inicio ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_duplicado($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE calendar_agenda SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
            WHERE id_calendar_agenda='" . $dato['id_calendar_agenda'] . "'";
    $this->db->query($sql);
    if ($dato['id_calendar_redes'] !== NULL) {
      $sql2 = "UPDATE calendar_redes SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
            WHERE id_calendar_redes='" . $dato['id_calendar_redes'] . "'";
      $this->db->query($sql2);
    }
  }
  //---------------------------------------------------ESTADOS BANCARIOS-----------------------------------
  function get_list_estado_bancario($id_estado_bancario = null)
  {
    if (isset($id_estado_bancario) && $id_estado_bancario > 0) {
      $sql = "SELECT es.*,em.id_empresa,em.nom_empresa,st.nom_status,
              CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
              WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
              WHEN es.mes='05' THEN CONCAT('May/',es.anio) WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
              WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
              WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
              WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
              ELSE '' END AS inicio
              FROM estado_bancario es
              LEFT JOIN empresa em ON em.id_empresa=es.id_empresa
              LEFT JOIN status st ON st.id_status=es.estado
              WHERE es.id_estado_bancario=$id_estado_bancario";
    } else {
      $sql = "SELECT es.id_estado_bancario,em.nom_empresa,es.cuenta_bancaria,
              CASE WHEN es.mes='01' THEN CONCAT('Ene/',es.anio) 
              WHEN es.mes='02' THEN CONCAT('Feb/',es.anio)
              WHEN es.mes='03' THEN CONCAT('Mar/',es.anio) 
              WHEN es.mes='04' THEN CONCAT('Abr/',es.anio)
              WHEN es.mes='05' THEN CONCAT('May/',es.anio) 
              WHEN es.mes='06' THEN CONCAT('Jun/',es.anio)
              WHEN es.mes='07' THEN CONCAT('Jul/',es.anio) 
              WHEN es.mes='08' THEN CONCAT('Ago/',es.anio)
              WHEN es.mes='09' THEN CONCAT('Sep/',es.anio) 
              WHEN es.mes='10' THEN CONCAT('Oct/',es.anio)
              WHEN es.mes='11' THEN CONCAT('Nov/',es.anio) 
              WHEN es.mes='12' THEN CONCAT('Dic/',es.anio)
              ELSE '' END AS inicio,
              (SELECT de.movimiento_pdf FROM detalle_estado_bancario de
              WHERE de.id_estado_bancario=es.id_estado_bancario AND 
              CASE WHEN MONTH(NOW())=1 THEN de.mes='12' AND de.anio=YEAR(NOW())-1
              ELSE de.mes=MONTH(NOW())-1 AND de.anio=YEAR(NOW()) END AND de.estado=1
              ORDER BY de.id_detalle DESC
              LIMIT 1) AS movimiento_pdf,
              (SELECT de.movimiento_excel FROM detalle_estado_bancario de
              WHERE de.id_estado_bancario=es.id_estado_bancario AND 
              CASE WHEN MONTH(NOW())=1 THEN de.mes='12' AND de.anio=YEAR(NOW())-1
              ELSE de.mes=MONTH(NOW())-1 AND de.anio=YEAR(NOW()) END AND de.estado=1
              ORDER BY de.id_detalle DESC
              LIMIT 1) AS movimiento_excel,
              (SELECT de.saldo_bbva FROM detalle_estado_bancario de
              WHERE de.id_estado_bancario=es.id_estado_bancario AND 
              CASE WHEN MONTH(NOW())=1 THEN de.mes='12' AND de.anio=YEAR(NOW())-1
              ELSE de.mes=MONTH(NOW())-1 AND de.anio=YEAR(NOW()) END AND de.estado=1
              ORDER BY de.id_detalle DESC
              LIMIT 1) AS saldo_bbva,
              st.nom_status,es.mes,es.anio,es.observaciones
              FROM estado_bancario es
              LEFT JOIN empresa em ON es.id_empresa=em.id_empresa
              LEFT JOIN status st ON st.id_status=es.estado
              WHERE es.estado NOT IN (4) AND es.id_estado_bancario NOT IN (5)
              ORDER BY em.nom_empresa ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE estado_bancario SET estado=1 WHERE id_empresa='" . $dato['id_empresa'] . "'";
    $this->db->query($sql);

    $sql2 = "INSERT INTO estado_bancario (id_empresa,cuenta_bancaria,estado,fec_reg,user_reg)
            VALUES ('" . $dato['id_empresa'] . "','" . $dato['cuenta_bancaria'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql2);
  }

  function ultimo_id_estado_bancario()
  {
    $sql = "SELECT id_estado_bancario FROM estado_bancario ORDER BY id_estado_bancario DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_detalle_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO detalle_estado_bancario (id_estado_bancario,mes,anio,estado,fec_reg,
            user_reg)
            VALUES ('" . $dato['id_estado_bancario'] . "','" . $dato['mes_detalle'] . "',
            '" . $dato['anio_detalle'] . "',1,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE estado_bancario SET estado='" . $dato['estado'] . "',observaciones='" . $dato['observaciones'] . "',mes='" . $dato['mes'] . "',anio='" . $dato['anio'] . "',fec_act=NOW(),
            user_act=$id_usuario
            WHERE id_estado_bancario='" . $dato['id_estado_bancario'] . "'";
    $this->db->query($sql);
  }

  function delete_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE estado_bancario SET estado=4,fec_eli=NOW(),
            user_eli=$id_usuario
            WHERE id_estado_bancario='" . $dato['id_estado_bancario'] . "'";
    $this->db->query($sql);
  }
  //--------------------------------------------DETALLE ESTADOS BANCARIOS-----------------------------------
  function get_list_mes_anio_combo($id_estado_bancario)
  {
    $sql = "SELECT mes,anio,CASE WHEN mes='01' THEN CONCAT('Ene/',SUBSTRING(anio,-2,2)) 
            WHEN mes='02' THEN CONCAT('Feb/',SUBSTRING(anio,-2,2))
            WHEN mes='03' THEN CONCAT('Mar/',SUBSTRING(anio,-2,2)) 
            WHEN mes='04' THEN CONCAT('Abr/',SUBSTRING(anio,-2,2))
            WHEN mes='05' THEN CONCAT('May/',SUBSTRING(anio,-2,2)) 
            WHEN mes='06' THEN CONCAT('Jun/',SUBSTRING(anio,-2,2))
            WHEN mes='07' THEN CONCAT('Jul/',SUBSTRING(anio,-2,2)) 
            WHEN mes='08' THEN CONCAT('Ago/',SUBSTRING(anio,-2,2))
            WHEN mes='09' THEN CONCAT('Sep/',SUBSTRING(anio,-2,2)) 
            WHEN mes='10' THEN CONCAT('Oct/',SUBSTRING(anio,-2,2))
            WHEN mes='11' THEN CONCAT('Nov/',SUBSTRING(anio,-2,2)) 
            WHEN mes='12' THEN CONCAT('Dic/',SUBSTRING(anio,-2,2)) END AS mes_anio
            FROM detalle_estado_bancario
            WHERE id_estado_bancario=$id_estado_bancario AND estado=1
            ORDER BY anio DESC,mes DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_detalle_estado_bancario($id_estado_bancario)
  {
    $anio = date('Y');
    $sql = "SELECT de.*,CASE WHEN de.mes='01' THEN CONCAT('Ene/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='02' THEN CONCAT('Feb/',SUBSTRING(de.anio,-2,2))
            WHEN de.mes='03' THEN CONCAT('Mar/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='04' THEN CONCAT('Abr/',SUBSTRING(de.anio,-2,2))
            WHEN de.mes='05' THEN CONCAT('May/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='06' THEN CONCAT('Jun/',SUBSTRING(de.anio,-2,2))
            WHEN de.mes='07' THEN CONCAT('Jul/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='08' THEN CONCAT('Ago/',SUBSTRING(de.anio,-2,2))
            WHEN de.mes='09' THEN CONCAT('Sep/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='10' THEN CONCAT('Oct/',SUBSTRING(de.anio,-2,2))
            WHEN de.mes='11' THEN CONCAT('Nov/',SUBSTRING(de.anio,-2,2)) 
            WHEN de.mes='12' THEN CONCAT('Dic/',SUBSTRING(de.anio,-2,2)) END AS mes_anio,
            CASE WHEN de.movimiento_pdf!='' THEN 'Cargado' ELSE 'Pendiente' END AS v_pdf,
            CASE WHEN de.movimiento_pdf!='' THEN '#92D050' ELSE '#C00000' END AS c_pdf,
            CASE WHEN de.movimiento_excel!='' THEN 'Cargado' ELSE 'Pendiente' END AS v_excel,
            CASE WHEN de.movimiento_excel!='' THEN '#92D050' ELSE '#C00000' END AS c_excel,
            CASE WHEN de.resumen_anual!='' THEN 'Cargado' ELSE 'Pendiente' END AS v_anual,
            CASE WHEN de.resumen_anual!='' THEN '#92D050' ELSE '#C00000' END AS c_anual,
            /*CASE WHEN de.movimiento_pdf='' THEN 'Pendiente' ELSE 'Cargado' END AS v_pdf,
            CASE WHEN de.movimiento_pdf='' THEN '#C00000' ELSE '#92D050' END AS c_pdf,
            CASE WHEN de.movimiento_excel='' THEN 'Pendiente' ELSE 'Cargado' END AS v_excel,
            CASE WHEN de.movimiento_excel='' THEN '#C00000' ELSE '#92D050' END AS c_excel,
            CASE WHEN de.resumen_anual='' THEN 'Pendiente' ELSE 'Cargado' END AS v_anual,
            CASE WHEN de.resumen_anual='' THEN '#C00000' ELSE '#92D050' END AS c_anual,*/
            CASE WHEN de.revisado=1 THEN 'Si' ELSE 'No' END AS revisado,
            us.usuario_codigo AS user_rev,DATE_FORMAT(de.fec_rev,'%d/%m/%Y') AS fec_rev
            FROM detalle_estado_bancario de
            LEFT JOIN users us ON us.id_usuario=de.user_rev
            WHERE de.id_estado_bancario=$id_estado_bancario AND de.estado=1 /*and de.anio in ('$anio')*/
            ORDER BY de.anio DESC,de.mes DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_detalle_estado_bancario($id_detalle)
  {
    $sql = "SELECT de.*,me.nom_mes FROM detalle_estado_bancario de 
            LEFT JOIN mes me ON me.cod_mes=de.mes
            WHERE de.id_detalle=$id_detalle";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_BankAccount($nom_estado_bancario)
  {
    $sql = "SELECT * FROM BankAccount WHERE StatusId=0 AND Name LIKE '%$nom_estado_bancario'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_estado_bancario_mes_anio($Id, $fec_inicio, $fec_fin)
  {
    $sql = "exec dbo.GetBankStatementMovements $Id,'$fec_inicio','$fec_fin'";

    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_estado_bancario_mes_anio_snappy($Id, $fec_inicio, $fec_fin)
  {
    $sql = "SELECT *  
        FROM(  
        SELECT  
        NULL AS AccountingPaymentId,  
        NULL AS SystemMoneyTransferId,  
        cppr.Id AS ClientProductPurchaseRegistryId,  
        'ING' AS MovementType,  
        i.PaymentDate AS 'Date',  
        i.PaymentDate AS MovementDate,  
        i.PaidAmount AS AmountValue,  
        i.PaidAmount AS RealAmount,  
        CASE   
          WHEN cppr.OperationNumber IS NOT NULL THEN cppr.OperationNumber  
          ELSE i.MovementNumber   
        END AS OperationNumber,  
        CONCAT(eh.Code, ' - ', cli.InternalStudentId, ' | ', i.Reference) AS Description,  
        i.MovementNumber AS Reference,
      CONCAT('ING', '-', i.MovementNumber, '-', (CASE WHEN cppr.OperationNumber IS NOT NULL THEN cppr.OperationNumber ELSE i.MovementNumber END)) AS Verificar
        FROM BankPaymentImportItem i  
        JOIN BankPaymentImport bpi ON bpi.Id = i.BankPaymentImportId  
        LEFT JOIN ClientProductPurchaseRegistry cppr ON cppr.Id = i.ClientProductPurchaseRegistryId  
        LEFT JOIN Client cli ON cli.Id = cppr.ClientId  
        LEFT JOIN EnterpriseHeadquarter eh ON eh.Id = cli.EnterpriseHeadquarterId  
        WHERE  
        bpi.BankAccountId = $Id AND  
        i.PaymentDate >= '$fec_inicio' AND  
        i.PaymentDate < '$fec_fin' AND  
        i.IsProcessed = convert(bit, 1)  
      
        UNION  
      
        SELECT  
        NULL AS AccountingPaymentId,  
        NULL AS SystemMoneyTransferId,  
        c.Id AS ClientProductPurchaseRegistryId,  
        CASE  
          WHEN c.PaymentStatusId = 1 THEN 'ING'  
          ELSE 'DEV'  
        END AS MovementType,  
        ISNULL(BankAccountPaymentDate, c.PaymentDate) AS 'Date',  
        ISNULL(BankAccountPaymentDate, c.PaymentDate) AS MovementDate,  
        CASE  
          WHEN c.PaymentStatusId = 4 AND   
          (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) > 0  
          THEN (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) * -1  
          ELSE(c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0))  
        END AS AmountValue,  
        (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) AS RealAmount,  
        c.OperationNumber AS OperationNumber,  
        CONCAT(eh.Code, ' - ', cli.InternalStudentId, ' | ', c.ElectronicReceiptNumber, ' - ', c.Description) AS Description,  
        NULL AS Reference,
      CONCAT((CASE WHEN c.PaymentStatusId = 1 THEN 'ING' ELSE 'DEV' END), '-', null, '-', c.OperationNumber) AS Verificar  
        FROM ClientProductPurchaseRegistry c  
        JOIN Client cli ON cli.Id = c.ClientId  
        JOIN EnterpriseHeadquarter eh ON eh.Id = cli.EnterpriseHeadquarterId  
        WHERE  
        c.BankAccountId = $Id AND  
        c.PaymentStatusId IN (1,4) AND  
        c.BankAccountPaymentDate BETWEEN '$fec_inicio' AND '$fec_fin'  
          
      
        UNION  
      
        SELECT  
        ap.Id AS AccountingPaymentId,  
        NULL AS SystemMoneyTransferId,  
        NULL AS ClientProductPurchaseRegistryId,  
        'GST' AS MovementType,  
        ap.PaymentDate AS 'Date',  
        ap.PaymentDate AS MovementDate,  
        ap.Amount AS AmountValue,  
        ap.Amount * -1 AS RealAmount,  
        ap.OperationNumber AS OperationNumber,  
        ap.Description AS Description,  
        ap.CostNumber AS Reference,
      CONCAT('GST','-',ap.CostNumber,'-',ap.OperationNumber) AS Verificar  
        FROM AccountingPayment ap  
        WHERE   
        ap.AccountingPaymentStatusId = 0 AND  
        ap.BankAccountId = $Id AND  
        ap.PaymentDate >= '$fec_inicio' AND  
        ap.PaymentDate < '$fec_fin'  
      
        UNION  
      
        SELECT  
        NULL AS AccountingPaymentId,  
        st.Id AS SystemMoneyTransferId,  
        NULL AS ClientProductPurchaseRegistryId,  
        'TRF' AS MovementType,  
        st.[Date] AS 'Date',  
        st.[Date] AS MovementDate,  
        st.Amount AS AmountValue,  
        CASE  
          WHEN st.SourceBankAccountId = $Id  
          THEN st.Amount * -1  
          ELSE st.Amount  
        END AS RealAmount,  
        st.OperationNumber AS OperationNumber,  
        st.Observations AS Description,  
        NULL AS Reference,
      CONCAT('TRF', '-',null,'-',st.OperationNumber) AS Verificar
        FROM SystemMoneyTransfer st  
        WHERE  
        (st.SourceBankAccountId = $Id OR st.DestinationBankAccountId = $Id) AND  
        st.[Date] >= '$fec_inicio' AND  
        st.[Date] < '$fec_fin' 
        ) results  
        ORDER BY  
        CASE   
          WHEN results.OperationNumber IS NOT NULL THEN results.OperationNumber   
          ELSE 99999999 END ASC,   
        results.MovementDate
    ";
    //echo $sql."<br><br>";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_saldo_arpay($Id, $fec_inicio)
  {
    $sql = "exec dbo.GetBankAccountBalance $Id,'$fec_inicio'";

    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_saldo_snappy($id_estado_bancario, $Id, $fec_inicio)
  {
    $sql = "SELECT b.*,sum(RealAmount),sum(RealAmount)+((SELECT saldo_real FROM detalle_estado_bancario WHERE id_estado_bancario='1' ORDER BY anio ASC,mes asc LIMIT 1)) as saldo 
    from getbankstatementmovements_snappy b where b.BankAccountId='$Id' and 
    (SELECT COUNT(*) FROM estado_bancario_fecha e WHERE e.MovementType=b.MovementType AND e.Reference=b.Reference AND e.OperationNumber=b.OperationNumber)=0 and date_format(b.MovementDate,'%Y-%m-%d') BETWEEN '01-01-2021' AND '$fec_inicio'";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_mes_detalle_estado_bancario($dato)
  {
    $sql = "SELECT * FROM detalle_estado_bancario WHERE estado=1 AND id_estado_bancario='" . $dato['id_estado_bancario'] . "' AND 
            mes='" . $dato['mes'] . "' AND anio='" . $dato['anio'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_mes_detalle_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO detalle_estado_bancario (id_estado_bancario,mes,anio,estado,fec_reg,user_reg) VALUES('" . $dato['id_estado_bancario'] . "',
            '" . $dato['mes'] . "','" . $dato['anio'] . "',1,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_detalle_estado_bancario($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $parte = "";
    if ($dato['revisado'] == 1) {
      $parte = ",user_rev=$id_usuario,fec_rev=NOW()";
    }
    $sql = "UPDATE detalle_estado_bancario SET movimiento_pdf='" . $dato['movimiento_pdf'] . "',movimiento_excel='" . $dato['movimiento_excel'] . "',
            nom_pdf='" . $dato['nom_pdf'] . "',nom_excel='" . $dato['nom_excel'] . "',saldo_bbva='" . $dato['saldo_bbva'] . "',revisado='" . $dato['revisado'] . "',
            saldo_real='" . $dato['saldo_real'] . "',resumen_anual='" . $dato['resumen_anual'] . "',nom_resumen_anual='" . $dato['nom_resumen_anual'] . "',
            fec_act=NOW(),user_act=$id_usuario $parte
            WHERE id_detalle='" . $dato['id_detalle'] . "'";
    $this->db->query($sql);
  }

  function valida_update_resumen_anual($dato)
  {
    $sql = "SELECT movimiento_pdf,movimiento_excel,saldo_bbva,saldo_real 
            FROM detalle_estado_bancario 
            WHERE estado=1 AND id_estado_bancario='" . $dato['id_estado_bancario'] . "' AND anio='" . $dato['anio'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_resumen_anual($dato)
  {
    $sql = "UPDATE detalle_estado_bancario SET resumen_anual='" . $dato['resumen_anual'] . "',nom_resumen_anual='" . $dato['nom_resumen_anual'] . "'
            WHERE id_estado_bancario='" . $dato['id_estado_bancario'] . "' AND estado=1 AND anio='" . $dato['anio'] . "'";
    $this->db->query($sql);
  }

  function delete_archivo_estado_bancario($id_detalle, $orden)
  {
    if ($orden == 1) {
      $sql = "UPDATE detalle_estado_bancario SET movimiento_pdf=''
              WHERE id_detalle=$id_detalle";
    } elseif ($orden == 2) {
      $sql = "UPDATE detalle_estado_bancario SET movimiento_excel=''
              WHERE id_detalle=$id_detalle";
    } else {
      $sql = "UPDATE detalle_estado_bancario SET resumen_anual=''
              WHERE id_detalle=$id_detalle";
    }
    $this->db->query($sql);
  }

  function get_list_total_pinteres($dato)
  {
    $condicion = "";
    if ($dato['id_empresa'] == 4) {
      if ($dato['pri'] == 1) {
        $condicion = "and pn.id_producto_interes in (23,25,27,29,31,33) ";
      } else {
        $condicion = "and pn.id_producto_interes in (24,26,28,30,32) ";
      }
    }
    $condicion2 = "";
    $condicion3 = "";
    if ($dato['id_empresa'] == 5) {
      if ($dato['pri'] == 1) {
        $condicion2 = "and rm.id_sede=7 ";
        $condicion3 = "and pn.id_sede=7 ";
      } else {
        $condicion2 = "and rm.id_sede=8 ";
        $condicion3 = "and pn.id_sede=8 ";
      }
    }
    $sql = "SELECT pn.*,em.cod_empresa,

            (SELECT count(*) FROM registro_mail rm
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
            WHERE hr.estado=14 AND rm.id_empresa='" . $dato['id_empresa'] . "' and  (SELECT concat(',',group_concat(distinct rp.id_producto_interes),',') FROM registro_mail_producto rp WHERE rp.id_registro=rm.id_registro and rp.estado=2) like concat('%,',pn.id_producto_interes,',%')) as total_reg_SD,

            (SELECT count(*) FROM registro_mail rm
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
            WHERE hr.estado=13 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 and 
            (SELECT concat(',',group_concat(distinct rp.id_producto_interes),',') FROM registro_mail_producto rp WHERE rp.id_registro=rm.id_registro and rp.estado=2) 
            like concat('%,',pn.id_producto_interes,',%')) as total_reg_IM,

            (SELECT count(*) FROM registro_mail rm
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
            WHERE hr.estado=11 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 and  (SELECT concat(',',group_concat(distinct rp.id_producto_interes),',') FROM registro_mail_producto rp WHERE rp.id_registro=rm.id_registro and rp.estado=2) like concat('%,',pn.id_producto_interes,',%')) as total_reg_SI,

            (SELECT count(*) FROM registro_mail rm
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
            WHERE hr.estado=15 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 and  (SELECT concat(',',group_concat(distinct rp.id_producto_interes),',') FROM registro_mail_producto rp WHERE rp.id_registro=rm.id_registro and rp.estado=2) like concat('%,',pn.id_producto_interes,',%')) as total_reg_MT,

            (SELECT count(*) FROM registro_mail rm
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
            WHERE hr.estado=19 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 and  (SELECT concat(',',group_concat(distinct rp.id_producto_interes),',') FROM registro_mail_producto rp WHERE rp.id_registro=rm.id_registro and rp.estado=2) like concat('%,',pn.id_producto_interes,',%')) as total_reg_EX

            /*(SELECT count(*) FROM registro_mail rm 
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
             LEFT JOIN registro_mail_producto rp ON rm.id_registro=rp.id_registro 
             left join producto_interes pi on rp.id_producto_interes=pi.id_producto_interes and pi.estado=2
            WHERE hr.estado=14 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 AND rp.id_producto_interes=62) as total_reg_SD_SD,

            (SELECT count(*) FROM registro_mail rm 
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
             LEFT JOIN registro_mail_producto rp ON rm.id_registro=rp.id_registro 
             left join producto_interes pi on rp.id_producto_interes=pi.id_producto_interes and pi.estado=2
            WHERE hr.estado=13 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 AND rp.id_producto_interes=62) as total_reg_IM_SD,

            (SELECT count(*) FROM registro_mail rm 
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
             LEFT JOIN registro_mail_producto rp ON rm.id_registro=rp.id_registro 
             left join producto_interes pi on rp.id_producto_interes=pi.id_producto_interes and pi.estado=2
            WHERE hr.estado=11 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 AND rp.id_producto_interes=62) as total_reg_SI_SD,

            (SELECT count(*) FROM registro_mail rm 
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
             LEFT JOIN registro_mail_producto rp ON rm.id_registro=rp.id_registro 
             left join producto_interes pi on rp.id_producto_interes=pi.id_producto_interes and pi.estado=2
            WHERE hr.estado=15 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 AND rp.id_producto_interes=62) as total_reg_MT_SD,

            (SELECT count(*) FROM registro_mail rm 
            left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial
            left join status_general sg on hr.estado=sg.id_status_general
             LEFT JOIN registro_mail_producto rp ON rm.id_registro=rp.id_registro 
             left join producto_interes pi on rp.id_producto_interes=pi.id_producto_interes and pi.estado=2
            WHERE hr.estado=19 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion2 AND rp.id_producto_interes=62) as total_reg_EX_SD*/

            FROM producto_interes pn
            LEFT JOIN empresa em on em.id_empresa=pn.id_empresa
            WHERE pn.id_empresa='" . $dato['id_empresa'] . "' $condicion $condicion3 and pn.total=1 AND pn.estado=2 /*or pn.id_producto_interes=62*/
            ORDER BY pn.orden_producto_interes ASC";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_total_prueba($dato)
  {
    $sql = "SELECT COUNT(*) as cantidad_p FROM registro_mail rm
            LEFT JOIN v_ultimo_id_historial_dcomercial hr on rm.id_registro=hr.id_registro
            LEFT JOIN status_general sg on hr.estado=sg.id_status_general
            LEFT JOIN v_productos_registro_dcomercial pp on rm.id_registro=pp.id_registro 
            WHERE rm.id_empresa='" . $dato['id_empresa'] . "' AND hr.estado=14 AND 
            pp.productos LIKE CONCAT('%,',(select group_concat(distinct id_producto_interes) from producto_interes where id_empresa='" . $dato['id_empresa'] . "'),',%')";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_empresa_usuario($id_usuario)
  {
    $sql = "SELECT id_empresa FROM usuario_empresa WHERE id_usuario=$id_usuario AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_total_cabecera_comercial($id_sede)
  {
    $sql = "SELECT COUNT(*) AS Total FROM max_historico_mail hr
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_cabecera_comercial($id_sede)
  {
    $sql = "SELECT pi.id_producto_interes,pi.nom_producto_interes,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=14 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Sin_Definir,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=13 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Interese_Moderado,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=11 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Super_Interese,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=15 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Matriculado,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=19 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Excluido
            FROM producto_interes pi
            WHERE pi.id_sede=$id_sede AND pi.estado=2
            ORDER BY pi.nom_producto_interes ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_total_cabecera_comercial_ls($id_sede, $nombre)
  {
    $sql = "SELECT COUNT(*) AS Total FROM max_historico_mail hr
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.nom_productos LIKE '%$nombre%'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_cabecera_comercial_ls($id_sede, $nombre)
  {
    $sql = "SELECT pi.id_producto_interes,pi.nom_producto_interes,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=14 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Sin_Definir,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=13 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Interese_Moderado,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=11 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Super_Interese,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=15 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Matriculado,
            (SELECT COUNT(*) FROM max_historico_mail hr 
            LEFT JOIN registro_mail re ON re.id_registro=hr.id_registro
            WHERE re.id_sede=$id_sede AND hr.estado=19 AND (hr.productos=pi.id_producto_interes OR hr.productos LIKE CONCAT(pi.id_producto_interes,',%') OR 
            hr.productos LIKE CONCAT('%,',pi.id_producto_interes,',%') OR hr.productos LIKE CONCAT('%,',pi.id_producto_interes))) AS Excluido
            FROM producto_interes pi
            WHERE pi.id_sede=$id_sede AND pi.estado=2 AND pi.nom_producto_interes LIKE '% $nombre'
            ORDER BY pi.nom_producto_interes ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_total_pinteres_otro($dato)
  {
    /*$sql = "SELECT pn.*,em.cod_empresa,(SELECT COUNT(*) FROM registro_mail_producto r
              LEFT JOIN registro_mail rm on rm.id_registro=r.id_registro
              WHERE r.id_producto_interes=pn.id_producto_interes and rm.estado=14) as total_reg_SD,
              (SELECT COUNT(*) FROM registro_mail_producto r
              LEFT JOIN registro_mail rm on rm.id_registro=r.id_registro
              WHERE r.id_producto_interes=pn.id_producto_interes and rm.estado=13) as total_reg_IM,
              (SELECT COUNT(*) FROM registro_mail_producto r
              LEFT JOIN registro_mail rm on rm.id_registro=r.id_registro
              WHERE r.id_producto_interes=pn.id_producto_interes and rm.estado=11) as total_reg_SI,
              (SELECT COUNT(*) FROM registro_mail_producto r
              LEFT JOIN registro_mail rm on rm.id_registro=r.id_registro
              WHERE r.id_producto_interes=pn.id_producto_interes and rm.estado=15) as total_reg_MT,
              (SELECT COUNT(*) FROM registro_mail_producto r
              LEFT JOIN registro_mail rm on rm.id_registro=r.id_registro
              WHERE r.id_producto_interes=pn.id_producto_interes and rm.estado=19) as total_reg_EX
              FROM producto_interes pn
              LEFT JOIN empresa em on em.id_empresa=pn.id_empresa
              WHERE pn.id_empresa='".$dato['id_empresa']."' and pn.total <> 1
              ORDER BY nom_producto_interes ASC";*/
    $sql = "SELECT pn.*,em.cod_empresa,(SELECT COUNT(*) FROM registro_mail rm
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=rm.id_registro
                LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial
                LEFT JOIN registro_mail_producto rp ON rp.id_registro=h.id_registro AND rp.estado=2
                WHERE hr.estado=14 AND rm.id_empresa='" . $dato['id_empresa'] . "' AND rp.id_producto_interes=pn.id_producto_interes) as total_reg_SD,
                (SELECT COUNT(*) FROM registro_mail rm
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=rm.id_registro
                LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial
                LEFT JOIN registro_mail_producto rp ON rp.id_registro=h.id_registro AND rp.estado=2
                WHERE hr.estado=13 AND rm.id_empresa='" . $dato['id_empresa'] . "' AND rp.id_producto_interes=pn.id_producto_interes) as total_reg_IM,
                (SELECT COUNT(*) FROM registro_mail rm
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=rm.id_registro
                LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial
                LEFT JOIN registro_mail_producto rp ON rp.id_registro=h.id_registro AND rp.estado=2
                WHERE hr.estado=11 AND rm.id_empresa='" . $dato['id_empresa'] . "' AND rp.id_producto_interes=pn.id_producto_interes) as total_reg_SI,
                (SELECT COUNT(*) FROM registro_mail rm
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=rm.id_registro
                LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial
                LEFT JOIN registro_mail_producto rp ON rp.id_registro=h.id_registro AND rp.estado=2
                WHERE hr.estado=15 AND rm.id_empresa='" . $dato['id_empresa'] . "' AND rp.id_producto_interes=pn.id_producto_interes) as total_reg_MT,
                (SELECT COUNT(*) FROM registro_mail rm
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 GROUP BY id_registro) h ON h.id_registro=rm.id_registro
                LEFT JOIN historial_registro_mail hr ON hr.id_historial=h.id_ultimo_historial
                LEFT JOIN registro_mail_producto rp ON rp.id_registro=h.id_registro AND rp.estado=2
                WHERE hr.estado=19 AND rm.id_empresa='" . $dato['id_empresa'] . "' AND rp.id_producto_interes=pn.id_producto_interes) as total_reg_EX
                FROM producto_interes pn
                LEFT JOIN empresa em on em.id_empresa=pn.id_empresa
                WHERE pn.id_empresa='" . $dato['id_empresa'] . "' AND pn.total<>1 AND pn.estado=2
                ORDER BY nom_producto_interes ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_totalmat_pinteres($dato)
  {

    if ($dato['id_empresa'] == 2 || $dato['id_empresa'] == 3 || $dato['id_empresa'] == 6 || $dato['id_empresa'] == 9) {
      $sql = "SELECT t.* FROM registro_mail t 
              LEFT JOIN  (SELECT max(id_historial) as id_ultimo_historial,id_registro FROM historial_registro_mail WHERE estado<>35 group by id_registro) h on h.id_registro=t.id_registro              
              LEFT JOIN  historial_registro_mail hr on hr.id_historial=h.id_ultimo_historial    
              LEFT JOIN  status_general sh on sh.id_status_general=hr.estado
              WHERE t.id_empresa='" . $dato['id_empresa'] . "' AND hr.estado=15";
    }
    if ($dato['id_empresa'] == 4) {
      $condicion = "";
      if ($dato['pri'] == 1) {
        $condicion = "and rp.id_producto_interes in (23,25,27,29,31,33) ";
      } else {
        $condicion = "and rp.id_producto_interes in (24,26,28,30,32) ";
      }
      $sql = "SELECT rm.*
			        FROM registro_mail rm              
              left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial  
              LEFT JOIN status_general sh on sh.id_status_general=hr.estado
              left JOIN registro_mail_producto rp on rm.id_registro=rp.id_registro and rp.estado=2
              WHERE hr.estado=15 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion";
    }
    if ($dato['id_empresa'] == 5) {
      $condicion = "";
      if ($dato['pri'] == 1) {
        $condicion = "and rm.id_sede=7 ";
      } else {
        $condicion = "and rm.id_sede=8 ";
      }
      $sql = "SELECT rm.*
			        FROM registro_mail rm              
              left join historial_registro_mail hr on (SELECT MAX(h.id_historial) FROM historial_registro_mail h WHERE h.estado<>35 and rm.id_registro=h.id_registro)=hr.id_historial  
              LEFT JOIN status_general sh on sh.id_status_general=hr.estado
              WHERE hr.estado=15 AND rm.id_empresa='" . $dato['id_empresa'] . "' $condicion";
    }


    $query = $this->db->query($sql)->result_Array();
    return $query;
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

  function get_list_submenus_usuario($nivel)
  {
    $sql = "SELECT msg.*,ms.nom_subgrupo,ms.nom_menu,m.nom_sub_subgrupo,m.nom_submenu FROM modulo_sub_subgrupo_xnivel msg 
    LEFT JOIN modulo_sub_subgrupo m on m.id_modulo_sub_subgrupo=msg.id_modulo_sub_subgrupo
    left JOIN modulo_subgrupo ms on ms.id_modulo_subgrupo=msg.id_modulo_subgrupo
    WHERE msg.id_nivel='" . $nivel . "'";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_empresa_usuario($id_usuario)
  {
    $sql = "SELECT * FROM usuario_empresa WHERE id_usuario=$id_usuario AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function list_subtipo_fbweb($dato)
  {
    $sql = "SELECT * from subtipo  WHERE  id_tipo='" . $dato['id_tipo'] . "' and id_empresa='" . $dato['empresas'] . "' order by nom_subtipo";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function list_subtipo_fbweb_activos($dato)
  {
    $sql = "SELECT * from subtipo  WHERE  id_tipo='" . $dato['id_tipo'] . "' and id_empresa='" . $dato['empresas'] . "' " . $dato['subtipo'] . " order by nom_subtipo";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  //--------------------------------------------BASE DE DATOS-------------------------------------------------
  function get_list_base_datos($tipo = null)
  {
    $parte = "";
    if ($tipo == 1) {
      $parte = "bd.estado=2";
    } else {
      $parte = "bd.estado NOT IN (4)";
    }

    $sql = "SELECT bd.*,em.cod_empresa,se.cod_sede,es.nom_status,DATE_FORMAT(bd.fec_reg,'%d-%m-%Y') AS fecha, 
            us.usuario_codigo,es.color
            FROM base_datos bd
            LEFT JOIN empresa em ON em.id_empresa=bd.id_empresa
            LEFT JOIN sede se ON se.id_sede=bd.id_sede
            LEFT JOIN status es ON es.id_status=bd.estado
            LEFT JOIN users us ON us.id_usuario=bd.user_reg
            WHERE $parte
            ORDER BY em.cod_empresa ASC,se.cod_sede ASC,bd.nom_base_datos ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_base_datos($id_base_datos)
  {
    $sql = "SELECT * FROM base_datos 
            WHERE id_base_datos=$id_base_datos";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_base_datos_num_todo()
  {
    $sql = "SELECT * FROM base_datos_num WHERE estado=1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_sede($id_empresa)
  {
    $sql = "SELECT * FROM sede WHERE id_empresa=$id_empresa AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_base_datos($dato)
  {
    $sql = "SELECT * FROM base_datos WHERE id_empresa='" . $dato['id_empresa'] . "' AND id_sede='" . $dato['id_sede'] . "' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_temporal_bd_num($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO base_datos_temporal (id_usuario,numerico,cantidad,inicial) 
            VALUES ($id_usuario,'" . $dato['numerico'] . "','" . $dato['cantidad'] . "','" . $dato['inicial'] . "')";
    $this->db->query($sql);
  }

  function get_list_temporal_bd_num_correcto()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM base_datos_temporal WHERE numerico=0 AND cantidad=0 AND inicial=0 AND id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_temporal_bd_num()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT * FROM base_datos_temporal WHERE id_usuario=$id_usuario";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_cantidad_base_datos()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "SELECT id_base_datos FROM base_datos";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_base_datos($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO base_datos (id_empresa,id_sede,nom_base_datos,num_subido,archivo,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "','" . $dato['nom_base_datos'] . "',
            '" . $dato['num_subido'] . "','" . $dato['archivo'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function ultimo_id_base_datos()
  {
    $sql = "SELECT * FROM base_datos WHERE estado=2 ORDER BY id_base_datos DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_bd_num($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO base_datos_num (id_base_datos,numero,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['id_base_datos'] . "','" . $dato['numero'] . "',1,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function delete_temporal_bd_num()
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "DELETE FROM base_datos_temporal WHERE id_usuario=$id_usuario";

    $this->db->query($sql);
  }

  function get_list_base_datos_num($id_base_datos)
  {
    $sql = "SELECT * FROM base_datos_num WHERE id_base_datos=$id_base_datos AND estado=1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_archivo_base_datos($id_base_datos)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE base_datos SET archivo='' WHERE id_base_datos=$id_base_datos";
    $this->db->query($sql);

    $sql2 = "UPDATE base_datos_num SET estado=2,fec_eli=NOW(),user_eli=$id_usuario WHERE id_base_datos=$id_base_datos";
    $this->db->query($sql2);
  }

  function update_base_datos_sin_archivo($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "UPDATE base_datos SET id_empresa='" . $dato['id_empresa'] . "',id_sede='" . $dato['id_sede'] . "',
            nom_base_datos='" . $dato['nom_base_datos'] . "',estado='" . $dato['estado'] . "',user_act=$id_usuario,
            fec_act=NOW()
            WHERE id_base_datos='" . $dato['id_base_datos'] . "'";

    $this->db->query($sql);
  }

  function update_base_datos($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE base_datos SET id_empresa='" . $dato['id_empresa'] . "',id_sede='" . $dato['id_sede'] . "',
            nom_base_datos='" . $dato['nom_base_datos'] . "',num_subido='" . $dato['num_subido'] . "',
            archivo='" . $dato['archivo'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
            WHERE id_base_datos='" . $dato['id_base_datos'] . "'";
    $this->db->query($sql);
  }
  //---------------------------------------------MENSAJE-------------------------------------------------
  function get_list_mensaje($mes_anio)
  {
    $sql = "SELECT m.id_mensaje,em.cod_empresa,se.cod_sede,'' AS tipo,m.motivo,bd.nom_base_datos,'' AS codigo,
            m.numero,CASE WHEN m.id_base_datos!=0 THEN (SELECT COUNT(0) FROM mensaje_detalle md
            WHERE md.id_mensaje=m.id_mensaje AND md.estado=2) ELSE 1 END AS envios,
            m.envios,u.usuario_codigo,DATE_FORMAT(m.fec_reg,'%d/%m/%Y') AS fecha,
            DATE_FORMAT(m.fec_reg,'%H:%i:%s') AS hora,m.mensaje,m.id_base_datos,s.nom_status
            FROM mensaje m
            LEFT JOIN base_datos bd ON bd.id_base_datos=m.id_base_datos
            LEFT JOIN empresa em ON em.id_empresa=bd.id_empresa
            LEFT JOIN sede se ON se.id_sede=bd.id_sede
            LEFT JOIN users u ON u.id_usuario=m.user_reg
            LEFT JOIN status s ON m.estado=s.id_status
            WHERE MONTH(m.fec_reg)=" . substr($mes_anio, 0, 2) . " AND 
            YEAR(m.fec_reg)=" . substr($mes_anio, -4) . " AND m.estado=2 
            ORDER BY m.id_mensaje DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function mensajes_comprados()
  {
    $sql = "SELECT SUM(cantidad) AS total FROM compra_mensaje WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function mensajes_enviados()
  {
    $sql = "SELECT SUM(envios) AS total FROM mensaje WHERE estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_mes_anio()
  {
    $sql = "SELECT CONCAT(me.cod_mes,an.nom_anio) AS cod_mes_anio,
            CONCAT(SUBSTRING(me.nom_mes,1,3),'/',SUBSTRING(an.nom_anio,-2)) AS mes_anio
            FROM mes me
            CROSS JOIN anio an
            ORDER BY an.nom_anio DESC,me.cod_mes DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_mensaje_detalle($id_mensaje)
  {
    $sql = "SELECT * FROM mensaje_detalle WHERE id_mensaje=$id_mensaje";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_bd_mensaje($id_base_datos = null)
  {
    if (isset($id_base_datos) && $id_base_datos > 0) {
      $sql = "SELECT *,(SELECT COUNT(*) FROM base_datos_num WHERE estado=1 AND id_base_datos=$id_base_datos) 
              AS cantidad_numeros 
              FROM base_datos 
              WHERE id_base_datos=$id_base_datos";
    } else {
      $sql = "SELECT bd.id_base_datos,CONCAT('(',em.cod_empresa,') ',se.cod_sede,' - ',bd.nom_base_datos) AS nom_base_datos
              FROM base_datos bd
              LEFT JOIN empresa em ON em.id_empresa=bd.id_empresa
              LEFT JOIN sede se ON se.id_sede=bd.id_sede
              WHERE bd.estado=2
              ORDER BY nom_base_datos ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_bd_num_mensaje($id_base_datos = null)
  {
    $sql = "SELECT * FROM base_datos_num WHERE estado=1 AND id_base_datos=$id_base_datos";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function ultimo_mensaje()
  {
    $sql = "SELECT * FROM mensaje WHERE estado=2 ORDER BY id_mensaje DESC LIMIT 1";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_mensaje($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "INSERT INTO mensaje (numero,id_base_datos,motivo,mensaje,envios,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['numero'] . "','" . $dato['id_base_datos'] . "','" . $dato['motivo'] . "',
            '" . $dato['mensaje'] . "','" . $dato['envios'] . "',2,NOW(),$id_usuario)";

    $this->db->query($sql);
  }

  function insert_mensaje_detalle($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO mensaje_detalle (id_mensaje,numero,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['id_mensaje'] . "','" . $dato['numero'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function duplicar_registro_mail($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail (cod_registro,id_informe,fecha_inicial,nombres_apellidos,dni,id_departamento,
          id_provincia,id_distrito,contacto1,contacto2,correo,facebook,id_empresa,id_origen,fecha_evento,id_accion,fecha_accion,fecha_status,web,id_sede,mailing,duplicado,
          mensaje,observacion,estado,fec_reg,user_reg) 
          SELECT cod_registro,id_informe,fecha_inicial,nombres_apellidos,dni,id_departamento,
          id_provincia,id_distrito,contacto1,contacto2,correo,facebook,id_empresa,id_origen,fecha_evento,id_accion,fecha_accion,fecha_status,web,id_sede,mailing,1,
          mensaje,observacion,estado,NOW(),$id_usuario from registro_mail where id_registro='" . $dato['id_registro'] . "'";
    $this->db->query($sql);
  }

  function duplicar_mail_producto($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
          SELECT '" . $dato['id_registro_d'] . "',id_producto_interes,estado,NOW(),$id_usuario FROM registro_mail_producto WHERE id_registro='" . $dato['id_registro'] . "'";
    $this->db->query($sql);

    $sql2 = "INSERT INTO historial_registro_mail (id_registro,comentario,observacion,id_accion,fecha_accion,estado,fec_reg,
          user_reg)
          SELECT '" . $dato['id_registro_d'] . "',comentario,observacion,id_accion,fecha_accion,estado,
          NOW(),user_reg FROM historial_registro_mail WHERE id_registro='" . $dato['id_registro'] . "' AND estado <> '35'";
    $this->db->query($sql2);
  }
  //-----------------------------ARPAY ONLINE-------------------------
  function get_list_arpay_online($id_arpay = null)
  {
    if (isset($id_arpay) && $id_arpay > 0) {
      $sql = "SELECT * FROM arpay_online WHERE id_arpay=$id_arpay";
    } else {
      $sql = "SELECT * FROM arpay_online WHERE estado=2";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_arpay_online($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE arpay_online SET nom_arpay='" . $dato['nom_arpay'] . "',descripcion_arpay='" . $dato['descripcion_arpay'] . "',fec_act=NOW(),user_act=$id_usuario
          WHERE id_arpay='" . $dato['id_arpay'] . "'";
    $this->db->query($sql);
  }
  //-----------------------------BALANCE REAL-------------------------
  function get_id_cod_empresa($empresa)
  {
    $sql = "SELECT * FROM empresa WHERE cod_empresa='$empresa' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_balance()
  {
    $sql = "SELECT cod_empresa,imagen,nom_empresa FROM empresa 
            WHERE balance=1 AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_anio_balance($fecha_inicio)
  {
    $anio = date('Y');
    $sql = "SELECT * FROM anio WHERE estado=1 AND nom_anio BETWEEN $fecha_inicio AND $anio ORDER BY nom_anio DESC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function total_cierre_caja($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=1) AS Enero,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=2) AS Febrero,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=3) AS Marzo,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=4) AS Abril,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=5) AS Mayo,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=6) AS Junio,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=7) AS Julio,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=8) AS Agosto,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=9) AS Septiembre,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=10) AS Octubre,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=11) AS Noviembre,
            (SELECT ISNULL(SUM(AutomaticAmount),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=12) AS Diciembre,
            ISNULL(SUM(AutomaticAmount),0) AS Total 
            FROM Cashout 
            WHERE YEAR(CreationDate)=$anio";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ca_ene.AutomaticAmount),0) FROM Cashout ca_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ca_ene.EnterpriseHeadquarterId
            WHERE YEAR(ca_ene.CreationDate)=$anio AND MONTH(ca_ene.CreationDate)=1 AND en_ene.Code LIKE '" . $empresa . "%') AS Enero,
            (SELECT ISNULL(SUM(ca_feb.AutomaticAmount),0) FROM Cashout ca_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ca_feb.EnterpriseHeadquarterId
            WHERE YEAR(ca_feb.CreationDate)=$anio AND MONTH(ca_feb.CreationDate)=2 AND en_feb.Code LIKE '" . $empresa . "%') AS Febrero,
            (SELECT ISNULL(SUM(ca_mar.AutomaticAmount),0) FROM Cashout ca_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ca_mar.EnterpriseHeadquarterId
            WHERE YEAR(ca_mar.CreationDate)=$anio AND MONTH(ca_mar.CreationDate)=3 AND en_mar.Code LIKE '" . $empresa . "%') AS Marzo,
            (SELECT ISNULL(SUM(ca_abr.AutomaticAmount),0) FROM Cashout ca_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ca_abr.EnterpriseHeadquarterId
            WHERE YEAR(ca_abr.CreationDate)=$anio AND MONTH(ca_abr.CreationDate)=4 AND en_abr.Code LIKE '" . $empresa . "%') AS Abril,
            (SELECT ISNULL(SUM(ca_may.AutomaticAmount),0) FROM Cashout ca_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ca_may.EnterpriseHeadquarterId
            WHERE YEAR(ca_may.CreationDate)=$anio AND MONTH(ca_may.CreationDate)=5 AND en_may.Code LIKE '" . $empresa . "%') AS Mayo,
            (SELECT ISNULL(SUM(ca_jun.AutomaticAmount),0) FROM Cashout ca_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ca_jun.EnterpriseHeadquarterId
            WHERE YEAR(ca_jun.CreationDate)=$anio AND MONTH(ca_jun.CreationDate)=6 AND en_jun.Code LIKE '" . $empresa . "%') AS Junio,
            (SELECT ISNULL(SUM(ca_jul.AutomaticAmount),0) FROM Cashout ca_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ca_jul.EnterpriseHeadquarterId
            WHERE YEAR(ca_jul.CreationDate)=$anio AND MONTH(ca_jul.CreationDate)=7 AND en_jul.Code LIKE '" . $empresa . "%') AS Julio,
            (SELECT ISNULL(SUM(ca_ago.AutomaticAmount),0) FROM Cashout ca_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ca_ago.EnterpriseHeadquarterId
            WHERE YEAR(ca_ago.CreationDate)=$anio AND MONTH(ca_ago.CreationDate)=8 AND en_ago.Code LIKE '" . $empresa . "%') AS Agosto,
            (SELECT ISNULL(SUM(ca_sep.AutomaticAmount),0) FROM Cashout ca_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ca_sep.EnterpriseHeadquarterId
            WHERE YEAR(ca_sep.CreationDate)=$anio AND MONTH(ca_sep.CreationDate)=9 AND en_sep.Code LIKE '" . $empresa . "%') AS Septiembre,
            (SELECT ISNULL(SUM(ca_oct.AutomaticAmount),0) FROM Cashout ca_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ca_oct.EnterpriseHeadquarterId
            WHERE YEAR(ca_oct.CreationDate)=$anio AND MONTH(ca_oct.CreationDate)=10 AND en_oct.Code LIKE '" . $empresa . "%') AS Octubre,
            (SELECT ISNULL(SUM(ca_nov.AutomaticAmount),0) FROM Cashout ca_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ca_nov.EnterpriseHeadquarterId
            WHERE YEAR(ca_nov.CreationDate)=$anio AND MONTH(ca_nov.CreationDate)=11 AND en_nov.Code LIKE '" . $empresa . "%') AS Noviembre,
            (SELECT ISNULL(SUM(ca_dic.AutomaticAmount),0) FROM Cashout ca_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ca_dic.EnterpriseHeadquarterId
            WHERE YEAR(ca_dic.CreationDate)=$anio AND MONTH(ca_dic.CreationDate)=12 AND en_dic.Code LIKE '" . $empresa . "%') AS Diciembre,
            ISNULL(SUM(ca.AutomaticAmount),0) AS Total 
            FROM Cashout ca 
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ca.EnterpriseHeadquarterId
            WHERE YEAR(ca.CreationDate)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_cierre_caja_recibo($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=1) AS Enero,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=2) AS Febrero,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=3) AS Marzo,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=4) AS Abril,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=5) AS Mayo,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=6) AS Junio,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=7) AS Julio,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=8) AS Agosto,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=9) AS Septiembre,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=10) AS Octubre,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=11) AS Noviembre,
            (SELECT ISNULL(SUM(Income),0) FROM Cashout 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=12) AS Diciembre,
            ISNULL(SUM(Income),0) AS Total 
            FROM Cashout 
            WHERE YEAR(CreationDate)=$anio";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ca_ene.Income),0) FROM Cashout ca_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ca_ene.EnterpriseHeadquarterId
            WHERE YEAR(ca_ene.CreationDate)=$anio AND MONTH(ca_ene.CreationDate)=1 AND en_ene.Code LIKE '" . $empresa . "%') AS Enero,
            (SELECT ISNULL(SUM(ca_feb.Income),0) FROM Cashout ca_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ca_feb.EnterpriseHeadquarterId
            WHERE YEAR(ca_feb.CreationDate)=$anio AND MONTH(ca_feb.CreationDate)=2 AND en_feb.Code LIKE '" . $empresa . "%') AS Febrero,
            (SELECT ISNULL(SUM(ca_mar.Income),0) FROM Cashout ca_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ca_mar.EnterpriseHeadquarterId
            WHERE YEAR(ca_mar.CreationDate)=$anio AND MONTH(ca_mar.CreationDate)=3 AND en_mar.Code LIKE '" . $empresa . "%') AS Marzo,
            (SELECT ISNULL(SUM(ca_abr.Income),0) FROM Cashout ca_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ca_abr.EnterpriseHeadquarterId
            WHERE YEAR(ca_abr.CreationDate)=$anio AND MONTH(ca_abr.CreationDate)=4 AND en_abr.Code LIKE '" . $empresa . "%') AS Abril,
            (SELECT ISNULL(SUM(ca_may.Income),0) FROM Cashout ca_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ca_may.EnterpriseHeadquarterId
            WHERE YEAR(ca_may.CreationDate)=$anio AND MONTH(ca_may.CreationDate)=5 AND en_may.Code LIKE '" . $empresa . "%') AS Mayo,
            (SELECT ISNULL(SUM(ca_jun.Income),0) FROM Cashout ca_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ca_jun.EnterpriseHeadquarterId
            WHERE YEAR(ca_jun.CreationDate)=$anio AND MONTH(ca_jun.CreationDate)=6 AND en_jun.Code LIKE '" . $empresa . "%') AS Junio,
            (SELECT ISNULL(SUM(ca_jul.Income),0) FROM Cashout ca_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ca_jul.EnterpriseHeadquarterId
            WHERE YEAR(ca_jul.CreationDate)=$anio AND MONTH(ca_jul.CreationDate)=7 AND en_jul.Code LIKE '" . $empresa . "%') AS Julio,
            (SELECT ISNULL(SUM(ca_ago.Income),0) FROM Cashout ca_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ca_ago.EnterpriseHeadquarterId
            WHERE YEAR(ca_ago.CreationDate)=$anio AND MONTH(ca_ago.CreationDate)=8 AND en_ago.Code LIKE '" . $empresa . "%') AS Agosto,
            (SELECT ISNULL(SUM(ca_sep.Income),0) FROM Cashout ca_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ca_sep.EnterpriseHeadquarterId
            WHERE YEAR(ca_sep.CreationDate)=$anio AND MONTH(ca_sep.CreationDate)=9 AND en_sep.Code LIKE '" . $empresa . "%') AS Septiembre,
            (SELECT ISNULL(SUM(ca_oct.Income),0) FROM Cashout ca_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ca_oct.EnterpriseHeadquarterId
            WHERE YEAR(ca_oct.CreationDate)=$anio AND MONTH(ca_oct.CreationDate)=10 AND en_oct.Code LIKE '" . $empresa . "%') AS Octubre,
            (SELECT ISNULL(SUM(ca_nov.Income),0) FROM Cashout ca_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ca_nov.EnterpriseHeadquarterId
            WHERE YEAR(ca_nov.CreationDate)=$anio AND MONTH(ca_nov.CreationDate)=11 AND en_nov.Code LIKE '" . $empresa . "%') AS Noviembre,
            (SELECT ISNULL(SUM(ca_dic.Income),0) FROM Cashout ca_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ca_dic.EnterpriseHeadquarterId
            WHERE YEAR(ca_dic.CreationDate)=$anio AND MONTH(ca_dic.CreationDate)=12 AND en_dic.Code LIKE '" . $empresa . "%') AS Diciembre,
            ISNULL(SUM(ca.Income),0) AS Total 
            FROM Cashout ca 
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ca.EnterpriseHeadquarterId
            WHERE YEAR(ca.CreationDate)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_cierre_caja_devolucion($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=1 AND PaymentStatusId=4) AS Enero,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=2 AND PaymentStatusId=4) AS Febrero,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=3 AND PaymentStatusId=4) AS Marzo,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=4 AND PaymentStatusId=4) AS Abril,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=5 AND PaymentStatusId=4) AS Mayo,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=6 AND PaymentStatusId=4) AS Junio,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=7 AND PaymentStatusId=4) AS Julio,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=8 AND PaymentStatusId=4) AS Agosto,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=9 AND PaymentStatusId=4) AS Septiembre,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=10 AND PaymentStatusId=4) AS Octubre,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=11 AND PaymentStatusId=4) AS Noviembre,
            (SELECT ISNULL(SUM(Cost),0) FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=12 AND PaymentStatusId=4) AS Diciembre,
            ISNULL(SUM(Cost),0) AS Total 
            FROM CashoutIncome 
            WHERE YEAR(PaymentDate)=$anio AND PaymentStatusId=4";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ca_ene.Cost),0) AS Total FROM CashoutIncome ca_ene
            LEFT JOIN Client cl_ene ON cl_ene.Id=ca_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(ca_ene.PaymentDate)=$anio AND MONTH(ca_ene.PaymentDate)=1 AND ca_ene.PaymentStatusId=4 AND en_ene.Code LIKE '" . $empresa . "%') AS Enero,
            (SELECT ISNULL(SUM(ca_feb.Cost),0) AS Total FROM CashoutIncome ca_feb
            LEFT JOIN Client cl_feb ON cl_feb.Id=ca_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(ca_feb.PaymentDate)=$anio AND MONTH(ca_feb.PaymentDate)=2 AND ca_feb.PaymentStatusId=4 AND en_feb.Code LIKE '" . $empresa . "%') AS Febrero,
            (SELECT ISNULL(SUM(ca_mar.Cost),0) AS Total FROM CashoutIncome ca_mar
            LEFT JOIN Client cl_mar ON cl_mar.Id=ca_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(ca_mar.PaymentDate)=$anio AND MONTH(ca_mar.PaymentDate)=3 AND ca_mar.PaymentStatusId=4 AND en_mar.Code LIKE '" . $empresa . "%') AS Marzo,
            (SELECT ISNULL(SUM(ca_abr.Cost),0) AS Total FROM CashoutIncome ca_abr
            LEFT JOIN Client cl_abr ON cl_abr.Id=ca_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(ca_abr.PaymentDate)=$anio AND MONTH(ca_abr.PaymentDate)=4 AND ca_abr.PaymentStatusId=4 AND en_abr.Code LIKE '" . $empresa . "%') AS Abril,
            (SELECT ISNULL(SUM(ca_may.Cost),0) AS Total FROM CashoutIncome ca_may
            LEFT JOIN Client cl_may ON cl_may.Id=ca_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(ca_may.PaymentDate)=$anio AND MONTH(ca_may.PaymentDate)=5 AND ca_may.PaymentStatusId=4 AND en_may.Code LIKE '" . $empresa . "%') AS Mayo,
            (SELECT ISNULL(SUM(ca_jun.Cost),0) AS Total FROM CashoutIncome ca_jun
            LEFT JOIN Client cl_jun ON cl_jun.Id=ca_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(ca_jun.PaymentDate)=$anio AND MONTH(ca_jun.PaymentDate)=6 AND ca_jun.PaymentStatusId=4 AND en_jun.Code LIKE '" . $empresa . "%') AS Junio,
            (SELECT ISNULL(SUM(ca_jul.Cost),0) AS Total FROM CashoutIncome ca_jul
            LEFT JOIN Client cl_jul ON cl_jul.Id=ca_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(ca_jul.PaymentDate)=$anio AND MONTH(ca_jul.PaymentDate)=7 AND ca_jul.PaymentStatusId=4 AND en_jul.Code LIKE '" . $empresa . "%') AS Julio,
            (SELECT ISNULL(SUM(ca_ago.Cost),0) AS Total FROM CashoutIncome ca_ago
            LEFT JOIN Client cl_ago ON cl_ago.Id=ca_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(ca_ago.PaymentDate)=$anio AND MONTH(ca_ago.PaymentDate)=8 AND ca_ago.PaymentStatusId=4 AND en_ago.Code LIKE '" . $empresa . "%') AS Agosto,
            (SELECT ISNULL(SUM(ca_sep.Cost),0) AS Total FROM CashoutIncome ca_sep
            LEFT JOIN Client cl_sep ON cl_sep.Id=ca_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(ca_sep.PaymentDate)=$anio AND MONTH(ca_sep.PaymentDate)=9 AND ca_sep.PaymentStatusId=4 AND en_sep.Code LIKE '" . $empresa . "%') AS Septiembre,
            (SELECT ISNULL(SUM(ca_oct.Cost),0) AS Total FROM CashoutIncome ca_oct
            LEFT JOIN Client cl_oct ON cl_oct.Id=ca_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(ca_oct.PaymentDate)=$anio AND MONTH(ca_oct.PaymentDate)=10 AND ca_oct.PaymentStatusId=4 AND en_oct.Code LIKE '" . $empresa . "%') AS Octubre,
            (SELECT ISNULL(SUM(ca_nov.Cost),0) AS Total FROM CashoutIncome ca_nov
            LEFT JOIN Client cl_nov ON cl_nov.Id=ca_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(ca_nov.PaymentDate)=$anio AND MONTH(ca_nov.PaymentDate)=11 AND ca_nov.PaymentStatusId=4 AND en_nov.Code LIKE '" . $empresa . "%') AS Noviembre,
            (SELECT ISNULL(SUM(ca_dic.Cost),0) AS Total FROM CashoutIncome ca_dic
            LEFT JOIN Client cl_dic ON cl_dic.Id=ca_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(ca_dic.PaymentDate)=$anio AND MONTH(ca_dic.PaymentDate)=12 AND ca_dic.PaymentStatusId=4 AND en_dic.Code LIKE '" . $empresa . "%') AS Diciembre,
            ISNULL(SUM(ca.Cost),0) AS Total 
            FROM CashoutIncome ca
            LEFT JOIN Client cl ON cl.Id=ca.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(ca.PaymentDate)=$anio AND ca.PaymentStatusId=4 AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_cierre_caja_bbva_doc_sunat($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(PaidAmount),0) AS Total FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=1 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Enero,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=2 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Febrero,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=3 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Marzo,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=4 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Abril,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=5 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Mayo,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=6 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Junio,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=7 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Julio,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=8 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Agosto,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=9 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Septiembre,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=10 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Octubre,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=11 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Noviembre,
            (SELECT ISNULL(SUM(PaidAmount),0) FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=12 AND ClientProductPurchaseRegistryId IS NOT NULL) AS Diciembre,
            ISNULL(SUM(PaidAmount),0) AS Total FROM BankPaymentImportItem 
            WHERE YEAR(PaymentDate)=$anio AND ClientProductPurchaseRegistryId IS NOT NULL";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ba_ene.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_ene
            LEFT JOIN ClientProductPurchaseRegistry cl_ene ON cl_ene.Id=ba_ene.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_ene ON ci_ene.Id=cl_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ci_ene.EnterpriseHeadquarterId
            WHERE YEAR(ba_ene.PaymentDate)=$anio AND MONTH(ba_ene.PaymentDate)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND ba_ene.ClientProductPurchaseRegistryId IS NOT NULL) AS Enero,
            (SELECT ISNULL(SUM(ba_feb.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_feb
            LEFT JOIN ClientProductPurchaseRegistry cl_feb ON cl_feb.Id=ba_feb.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_feb ON ci_feb.Id=cl_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ci_feb.EnterpriseHeadquarterId
            WHERE YEAR(ba_feb.PaymentDate)=$anio AND MONTH(ba_feb.PaymentDate)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND ba_feb.ClientProductPurchaseRegistryId IS NOT NULL) AS Febrero,
            (SELECT ISNULL(SUM(ba_mar.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_mar
            LEFT JOIN ClientProductPurchaseRegistry cl_mar ON cl_mar.Id=ba_mar.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_mar ON ci_mar.Id=cl_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ci_mar.EnterpriseHeadquarterId
            WHERE YEAR(ba_mar.PaymentDate)=$anio AND MONTH(ba_mar.PaymentDate)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND ba_mar.ClientProductPurchaseRegistryId IS NOT NULL) AS Marzo,
            (SELECT ISNULL(SUM(ba_abr.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_abr
            LEFT JOIN ClientProductPurchaseRegistry cl_abr ON cl_abr.Id=ba_abr.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_abr ON ci_abr.Id=cl_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ci_abr.EnterpriseHeadquarterId
            WHERE YEAR(ba_abr.PaymentDate)=$anio AND MONTH(ba_abr.PaymentDate)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND ba_abr.ClientProductPurchaseRegistryId IS NOT NULL) AS Abril,
            (SELECT ISNULL(SUM(ba_may.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_may
            LEFT JOIN ClientProductPurchaseRegistry cl_may ON cl_may.Id=ba_may.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_may ON ci_may.Id=cl_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ci_may.EnterpriseHeadquarterId
            WHERE YEAR(ba_may.PaymentDate)=$anio AND MONTH(ba_may.PaymentDate)=5 AND en_may.Code LIKE '" . $empresa . "%' AND ba_may.ClientProductPurchaseRegistryId IS NOT NULL) AS Mayo,
            (SELECT ISNULL(SUM(ba_jun.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_jun
            LEFT JOIN ClientProductPurchaseRegistry cl_jun ON cl_jun.Id=ba_jun.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_jun ON ci_jun.Id=cl_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ci_jun.EnterpriseHeadquarterId
            WHERE YEAR(ba_jun.PaymentDate)=$anio AND MONTH(ba_jun.PaymentDate)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND ba_jun.ClientProductPurchaseRegistryId IS NOT NULL) AS Junio,
            (SELECT ISNULL(SUM(ba_jul.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_jul
            LEFT JOIN ClientProductPurchaseRegistry cl_jul ON cl_jul.Id=ba_jul.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_jul ON ci_jul.Id=cl_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ci_jul.EnterpriseHeadquarterId
            WHERE YEAR(ba_jul.PaymentDate)=$anio AND MONTH(ba_jul.PaymentDate)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND ba_jul.ClientProductPurchaseRegistryId IS NOT NULL) AS Julio,
            (SELECT ISNULL(SUM(ba_ago.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_ago
            LEFT JOIN ClientProductPurchaseRegistry cl_ago ON cl_ago.Id=ba_ago.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_ago ON ci_ago.Id=cl_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ci_ago.EnterpriseHeadquarterId
            WHERE YEAR(ba_ago.PaymentDate)=$anio AND MONTH(ba_ago.PaymentDate)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND ba_ago.ClientProductPurchaseRegistryId IS NOT NULL) AS Agosto,
            (SELECT ISNULL(SUM(ba_sep.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_sep
            LEFT JOIN ClientProductPurchaseRegistry cl_sep ON cl_sep.Id=ba_sep.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_sep ON ci_sep.Id=cl_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ci_sep.EnterpriseHeadquarterId
            WHERE YEAR(ba_sep.PaymentDate)=$anio AND MONTH(ba_sep.PaymentDate)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND ba_sep.ClientProductPurchaseRegistryId IS NOT NULL) AS Septiembre,
            (SELECT ISNULL(SUM(ba_oct.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_oct
            LEFT JOIN ClientProductPurchaseRegistry cl_oct ON cl_oct.Id=ba_oct.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_oct ON ci_oct.Id=cl_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ci_oct.EnterpriseHeadquarterId
            WHERE YEAR(ba_oct.PaymentDate)=$anio AND MONTH(ba_oct.PaymentDate)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND ba_oct.ClientProductPurchaseRegistryId IS NOT NULL) AS Octubre,
            (SELECT ISNULL(SUM(ba_nov.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_nov
            LEFT JOIN ClientProductPurchaseRegistry cl_nov ON cl_nov.Id=ba_nov.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_nov ON ci_nov.Id=cl_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ci_nov.EnterpriseHeadquarterId
            WHERE YEAR(ba_nov.PaymentDate)=$anio AND MONTH(ba_nov.PaymentDate)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND ba_nov.ClientProductPurchaseRegistryId IS NOT NULL) AS Noviembre,
            (SELECT ISNULL(SUM(ba_dic.PaidAmount),0) AS Total FROM BankPaymentImportItem ba_dic
            LEFT JOIN ClientProductPurchaseRegistry cl_dic ON cl_dic.Id=ba_dic.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci_dic ON ci_dic.Id=cl_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ci_dic.EnterpriseHeadquarterId
            WHERE YEAR(ba_dic.PaymentDate)=$anio AND MONTH(ba_dic.PaymentDate)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND ba_dic.ClientProductPurchaseRegistryId IS NOT NULL) AS Diciembre,
            ISNULL(SUM(ba.PaidAmount),0) AS Total 
            FROM BankPaymentImportItem ba 
            LEFT JOIN ClientProductPurchaseRegistry cl ON cl.Id=ba.ClientProductPurchaseRegistryId
            LEFT JOIN Client ci ON ci.Id=cl.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ci.EnterpriseHeadquarterId
            WHERE YEAR(ba.PaymentDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ba.ClientProductPurchaseRegistryId IS NOT NULL";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_gastos_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT Name,(SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN CostType ct_ene ON ct_ene.Id=ap_ene.CostTypeId
            WHERE CASE WHEN ap_ene.ReceiptDate IS NULL THEN YEAR(ap_ene.PaymentDate) ELSE YEAR(ap_ene.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ene.ReceiptDate IS NULL THEN MONTH(ap_ene.PaymentDate) ELSE MONTH(ap_ene.ReceiptDate) END=1 AND 
            ct_ene.ParentCostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN CostType ct_feb ON ct_feb.Id=ap_feb.CostTypeId
            WHERE CASE WHEN ap_feb.ReceiptDate IS NULL THEN YEAR(ap_feb.PaymentDate) ELSE YEAR(ap_feb.ReceiptDate) END=$anio AND 
            CASE WHEN ap_feb.ReceiptDate IS NULL THEN MONTH(ap_feb.PaymentDate) ELSE MONTH(ap_feb.ReceiptDate) END=2 AND 
            ct_feb.ParentCostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN CostType ct_mar ON ct_mar.Id=ap_mar.CostTypeId
            WHERE CASE WHEN ap_mar.ReceiptDate IS NULL THEN YEAR(ap_mar.PaymentDate) ELSE YEAR(ap_mar.ReceiptDate) END=$anio AND 
            CASE WHEN ap_mar.ReceiptDate IS NULL THEN MONTH(ap_mar.PaymentDate) ELSE MONTH(ap_mar.ReceiptDate) END=3 AND 
            ct_mar.ParentCostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN CostType ct_abr ON ct_abr.Id=ap_abr.CostTypeId
            WHERE CASE WHEN ap_abr.ReceiptDate IS NULL THEN YEAR(ap_abr.PaymentDate) ELSE YEAR(ap_abr.ReceiptDate) END=$anio AND 
            CASE WHEN ap_abr.ReceiptDate IS NULL THEN MONTH(ap_abr.PaymentDate) ELSE MONTH(ap_abr.ReceiptDate) END=4 AND 
            ct_abr.ParentCostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN CostType ct_may ON ct_may.Id=ap_may.CostTypeId
            WHERE CASE WHEN ap_may.ReceiptDate IS NULL THEN YEAR(ap_may.PaymentDate) ELSE YEAR(ap_may.ReceiptDate) END=$anio AND 
            CASE WHEN ap_may.ReceiptDate IS NULL THEN MONTH(ap_may.PaymentDate) ELSE MONTH(ap_may.ReceiptDate) END=5 AND 
            ct_may.ParentCostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN CostType ct_jun ON ct_jun.Id=ap_jun.CostTypeId
            WHERE CASE WHEN ap_jun.ReceiptDate IS NULL THEN YEAR(ap_jun.PaymentDate) ELSE YEAR(ap_jun.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jun.ReceiptDate IS NULL THEN MONTH(ap_jun.PaymentDate) ELSE MONTH(ap_jun.ReceiptDate) END=6 AND 
            ct_jun.ParentCostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN CostType ct_jul ON ct_jul.Id=ap_jul.CostTypeId
            WHERE CASE WHEN ap_jul.ReceiptDate IS NULL THEN YEAR(ap_jul.PaymentDate) ELSE YEAR(ap_jul.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jul.ReceiptDate IS NULL THEN MONTH(ap_jul.PaymentDate) ELSE MONTH(ap_jul.ReceiptDate) END=7 AND 
            ct_jul.ParentCostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN CostType ct_ago ON ct_ago.Id=ap_ago.CostTypeId
            WHERE CASE WHEN ap_ago.ReceiptDate IS NULL THEN YEAR(ap_ago.PaymentDate) ELSE YEAR(ap_ago.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ago.ReceiptDate IS NULL THEN MONTH(ap_ago.PaymentDate) ELSE MONTH(ap_ago.ReceiptDate) END=8 AND ct_ago.ParentCostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN CostType ct_sep ON ct_sep.Id=ap_sep.CostTypeId
            WHERE CASE WHEN ap_sep.ReceiptDate IS NULL THEN YEAR(ap_sep.PaymentDate) ELSE YEAR(ap_sep.ReceiptDate) END=$anio AND 
            CASE WHEN ap_sep.ReceiptDate IS NULL THEN MONTH(ap_sep.PaymentDate) ELSE MONTH(ap_sep.ReceiptDate) END=9 AND 
            ct_sep.ParentCostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN CostType ct_oct ON ct_oct.Id=ap_oct.CostTypeId
            WHERE CASE WHEN ap_oct.ReceiptDate IS NULL THEN YEAR(ap_oct.PaymentDate) ELSE YEAR(ap_oct.ReceiptDate) END=$anio AND 
            CASE WHEN ap_oct.ReceiptDate IS NULL THEN MONTH(ap_oct.PaymentDate) ELSE MONTH(ap_oct.ReceiptDate) END=10 AND 
            ct_oct.ParentCostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN CostType ct_nov ON ct_nov.Id=ap_nov.CostTypeId
            WHERE CASE WHEN ap_nov.ReceiptDate IS NULL THEN YEAR(ap_nov.PaymentDate) ELSE YEAR(ap_nov.ReceiptDate) END=$anio AND 
            CASE WHEN ap_nov.ReceiptDate IS NULL THEN MONTH(ap_nov.PaymentDate) ELSE MONTH(ap_nov.ReceiptDate) END=11 AND 
            ct_nov.ParentCostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN CostType ct_dic ON ct_dic.Id=ap_dic.CostTypeId
            WHERE CASE WHEN ap_dic.ReceiptDate IS NULL THEN YEAR(ap_dic.PaymentDate) ELSE YEAR(ap_dic.ReceiptDate) END=$anio AND 
            CASE WHEN ap_dic.ReceiptDate IS NULL THEN MONTH(ap_dic.PaymentDate) ELSE MONTH(ap_dic.ReceiptDate) END=12 AND 
            ct_dic.ParentCostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            LEFT JOIN CostType ct ON ct.Id=ap.CostTypeId
            WHERE CASE WHEN ap.ReceiptDate IS NULL THEN YEAR(ap.PaymentDate) ELSE YEAR(ap.ReceiptDate) END=$anio AND 
            ct.ParentCostTypeId=co.Id) AS Total
            FROM CostType co
            WHERE co.ParentCostTypeId IS NULL AND co.StatusId=0 ORDER BY Name ASC";
    } else {
      $sql = "SELECT Name,(SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN CostType ct_ene ON ct_ene.Id=ap_ene.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_ene.ReceiptDate IS NULL THEN YEAR(ap_ene.PaymentDate) ELSE YEAR(ap_ene.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ene.ReceiptDate IS NULL THEN MONTH(ap_ene.PaymentDate) ELSE MONTH(ap_ene.ReceiptDate) END=1 AND 
            en_ene.Code LIKE '" . $empresa . "%' AND ct_ene.ParentCostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN CostType ct_feb ON ct_feb.Id=ap_feb.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_feb.ReceiptDate IS NULL THEN YEAR(ap_feb.PaymentDate) ELSE YEAR(ap_feb.ReceiptDate) END=$anio AND 
            CASE WHEN ap_feb.ReceiptDate IS NULL THEN MONTH(ap_feb.PaymentDate) ELSE MONTH(ap_feb.ReceiptDate) END=2 AND 
            en_feb.Code LIKE '" . $empresa . "%' AND ct_feb.ParentCostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN CostType ct_mar ON ct_mar.Id=ap_mar.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_mar.ReceiptDate IS NULL THEN YEAR(ap_mar.PaymentDate) ELSE YEAR(ap_mar.ReceiptDate) END=$anio AND 
            CASE WHEN ap_mar.ReceiptDate IS NULL THEN MONTH(ap_mar.PaymentDate) ELSE MONTH(ap_mar.ReceiptDate) END=3 AND 
            en_mar.Code LIKE '" . $empresa . "%' AND ct_mar.ParentCostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN CostType ct_abr ON ct_abr.Id=ap_abr.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_abr.ReceiptDate IS NULL THEN YEAR(ap_abr.PaymentDate) ELSE YEAR(ap_abr.ReceiptDate) END=$anio AND 
            CASE WHEN ap_abr.ReceiptDate IS NULL THEN MONTH(ap_abr.PaymentDate) ELSE MONTH(ap_abr.ReceiptDate) END=4 AND 
            en_abr.Code LIKE '" . $empresa . "%' AND ct_abr.ParentCostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN CostType ct_may ON ct_may.Id=ap_may.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_may.ReceiptDate IS NULL THEN YEAR(ap_may.PaymentDate) ELSE YEAR(ap_may.ReceiptDate) END=$anio AND 
            CASE WHEN ap_may.ReceiptDate IS NULL THEN MONTH(ap_may.PaymentDate) ELSE MONTH(ap_may.ReceiptDate) END=5 AND 
            en_may.Code LIKE '" . $empresa . "%' AND ct_may.ParentCostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN CostType ct_jun ON ct_jun.Id=ap_jun.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_jun.ReceiptDate IS NULL THEN YEAR(ap_jun.PaymentDate) ELSE YEAR(ap_jun.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jun.ReceiptDate IS NULL THEN MONTH(ap_jun.PaymentDate) ELSE MONTH(ap_jun.ReceiptDate) END=6 AND 
            en_jun.Code LIKE '" . $empresa . "%' AND ct_jun.ParentCostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN CostType ct_jul ON ct_jul.Id=ap_jul.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_jul.ReceiptDate IS NULL THEN YEAR(ap_jul.PaymentDate) ELSE YEAR(ap_jul.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jul.ReceiptDate IS NULL THEN MONTH(ap_jul.PaymentDate) ELSE MONTH(ap_jul.ReceiptDate) END=7 AND 
            en_jul.Code LIKE '" . $empresa . "%' AND ct_jul.ParentCostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN CostType ct_ago ON ct_ago.Id=ap_ago.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_ago.ReceiptDate IS NULL THEN YEAR(ap_ago.PaymentDate) ELSE YEAR(ap_ago.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ago.ReceiptDate IS NULL THEN MONTH(ap_ago.PaymentDate) ELSE MONTH(ap_ago.ReceiptDate) END=8 AND 
            en_ago.Code LIKE '" . $empresa . "%' AND ct_ago.ParentCostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN CostType ct_sep ON ct_sep.Id=ap_sep.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_sep.ReceiptDate IS NULL THEN YEAR(ap_sep.PaymentDate) ELSE YEAR(ap_sep.ReceiptDate) END=$anio AND 
            CASE WHEN ap_sep.ReceiptDate IS NULL THEN MONTH(ap_sep.PaymentDate) ELSE MONTH(ap_sep.ReceiptDate) END=9 AND 
            en_sep.Code LIKE '" . $empresa . "%' AND ct_sep.ParentCostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN CostType ct_oct ON ct_oct.Id=ap_oct.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_oct.ReceiptDate IS NULL THEN YEAR(ap_oct.PaymentDate) ELSE YEAR(ap_oct.ReceiptDate) END=$anio AND 
            CASE WHEN ap_oct.ReceiptDate IS NULL THEN MONTH(ap_oct.PaymentDate) ELSE MONTH(ap_oct.ReceiptDate) END=10 AND 
            en_oct.Code LIKE '" . $empresa . "%' AND ct_oct.ParentCostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN CostType ct_nov ON ct_nov.Id=ap_nov.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_nov.ReceiptDate IS NULL THEN YEAR(ap_nov.PaymentDate) ELSE YEAR(ap_nov.ReceiptDate) END=$anio AND 
            CASE WHEN ap_nov.ReceiptDate IS NULL THEN MONTH(ap_nov.PaymentDate) ELSE MONTH(ap_nov.ReceiptDate) END=11 AND 
            en_nov.Code LIKE '" . $empresa . "%' AND ct_nov.ParentCostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN CostType ct_dic ON ct_dic.Id=ap_dic.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_dic.ReceiptDate IS NULL THEN YEAR(ap_dic.PaymentDate) ELSE YEAR(ap_dic.ReceiptDate) END=$anio AND 
            CASE WHEN ap_dic.ReceiptDate IS NULL THEN MONTH(ap_dic.PaymentDate) ELSE MONTH(ap_dic.ReceiptDate) END=12 AND
            en_dic.Code LIKE '" . $empresa . "%' AND ct_dic.ParentCostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            LEFT JOIN CostType ct ON ct.Id=ap.CostTypeId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE CASE WHEN ap.ReceiptDate IS NULL THEN YEAR(ap.PaymentDate) ELSE YEAR(ap.ReceiptDate) END=$anio AND 
            en.Code LIKE '" . $empresa . "%' AND ct.ParentCostTypeId=co.Id) AS Total
            FROM CostType co
            WHERE co.ParentCostTypeId IS NULL AND co.StatusId=0 ORDER BY Name ASC";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_gastos_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            WHERE CASE WHEN ap_ene.ReceiptDate IS NULL THEN YEAR(ap_ene.PaymentDate) ELSE YEAR(ap_ene.ReceiptDate) END=$anio AND
            CASE WHEN ap_ene.ReceiptDate IS NULL THEN MONTH(ap_ene.PaymentDate) ELSE MONTH(ap_ene.ReceiptDate) END=1) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            WHERE CASE WHEN ap_feb.ReceiptDate IS NULL THEN YEAR(ap_feb.PaymentDate) ELSE YEAR(ap_feb.ReceiptDate) END=$anio AND
            CASE WHEN ap_feb.ReceiptDate IS NULL THEN MONTH(ap_feb.PaymentDate) ELSE MONTH(ap_feb.ReceiptDate) END=2) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            WHERE CASE WHEN ap_mar.ReceiptDate IS NULL THEN YEAR(ap_mar.PaymentDate) ELSE YEAR(ap_mar.ReceiptDate) END=$anio AND
            CASE WHEN ap_mar.ReceiptDate IS NULL THEN MONTH(ap_mar.PaymentDate) ELSE MONTH(ap_mar.ReceiptDate) END=3) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            WHERE CASE WHEN ap_abr.ReceiptDate IS NULL THEN YEAR(ap_abr.PaymentDate) ELSE YEAR(ap_abr.ReceiptDate) END=$anio AND
            CASE WHEN ap_abr.ReceiptDate IS NULL THEN MONTH(ap_abr.PaymentDate) ELSE MONTH(ap_abr.ReceiptDate) END=4) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            WHERE CASE WHEN ap_may.ReceiptDate IS NULL THEN YEAR(ap_may.PaymentDate) ELSE YEAR(ap_may.ReceiptDate) END=$anio AND
            CASE WHEN ap_may.ReceiptDate IS NULL THEN MONTH(ap_may.PaymentDate) ELSE MONTH(ap_may.ReceiptDate) END=5) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            WHERE CASE WHEN ap_jun.ReceiptDate IS NULL THEN YEAR(ap_jun.PaymentDate) ELSE YEAR(ap_jun.ReceiptDate) END=$anio AND
            CASE WHEN ap_jun.ReceiptDate IS NULL THEN MONTH(ap_jun.PaymentDate) ELSE MONTH(ap_jun.ReceiptDate) END=6) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            WHERE CASE WHEN ap_jul.ReceiptDate IS NULL THEN YEAR(ap_jul.PaymentDate) ELSE YEAR(ap_jul.ReceiptDate) END=$anio AND
            CASE WHEN ap_jul.ReceiptDate IS NULL THEN MONTH(ap_jul.PaymentDate) ELSE MONTH(ap_jul.ReceiptDate) END=7) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            WHERE CASE WHEN ap_ago.ReceiptDate IS NULL THEN YEAR(ap_ago.PaymentDate) ELSE YEAR(ap_ago.ReceiptDate) END=$anio AND
            CASE WHEN ap_ago.ReceiptDate IS NULL THEN MONTH(ap_ago.PaymentDate) ELSE MONTH(ap_ago.ReceiptDate) END=8) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            WHERE CASE WHEN ap_sep.ReceiptDate IS NULL THEN YEAR(ap_sep.PaymentDate) ELSE YEAR(ap_sep.ReceiptDate) END=$anio AND
            CASE WHEN ap_sep.ReceiptDate IS NULL THEN MONTH(ap_sep.PaymentDate) ELSE MONTH(ap_sep.ReceiptDate) END=9) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            WHERE CASE WHEN ap_oct.ReceiptDate IS NULL THEN YEAR(ap_oct.PaymentDate) ELSE YEAR(ap_oct.ReceiptDate) END=$anio AND
            CASE WHEN ap_oct.ReceiptDate IS NULL THEN MONTH(ap_oct.PaymentDate) ELSE MONTH(ap_oct.ReceiptDate) END=10) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            WHERE CASE WHEN ap_nov.ReceiptDate IS NULL THEN YEAR(ap_nov.PaymentDate) ELSE YEAR(ap_nov.ReceiptDate) END=$anio AND
            CASE WHEN ap_nov.ReceiptDate IS NULL THEN MONTH(ap_nov.PaymentDate) ELSE MONTH(ap_nov.ReceiptDate) END=11) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            WHERE CASE WHEN ap_dic.ReceiptDate IS NULL THEN YEAR(ap_dic.PaymentDate) ELSE YEAR(ap_dic.ReceiptDate) END=$anio AND
            CASE WHEN ap_dic.ReceiptDate IS NULL THEN MONTH(ap_dic.PaymentDate) ELSE MONTH(ap_dic.ReceiptDate) END=12) AS Diciembre,
            ISNULL(SUM(ap.Amount),0) AS Total 
            FROM AccountingPayment ap
            WHERE CASE WHEN ap.ReceiptDate IS NULL THEN YEAR(ap.PaymentDate) ELSE YEAR(ap.ReceiptDate) END=$anio";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_ene.ReceiptDate IS NULL THEN YEAR(ap_ene.PaymentDate) ELSE YEAR(ap_ene.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ene.ReceiptDate IS NULL THEN MONTH(ap_ene.PaymentDate) ELSE MONTH(ap_ene.ReceiptDate) END=1 AND 
            en_ene.Code LIKE '" . $empresa . "%') AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_feb.ReceiptDate IS NULL THEN YEAR(ap_feb.PaymentDate) ELSE YEAR(ap_feb.ReceiptDate) END=$anio AND 
            CASE WHEN ap_feb.ReceiptDate IS NULL THEN MONTH(ap_feb.PaymentDate) ELSE MONTH(ap_feb.ReceiptDate) END=2 AND 
            en_feb.Code LIKE '" . $empresa . "%') AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_mar.ReceiptDate IS NULL THEN YEAR(ap_mar.PaymentDate) ELSE YEAR(ap_mar.ReceiptDate) END=$anio AND 
            CASE WHEN ap_mar.ReceiptDate IS NULL THEN MONTH(ap_mar.PaymentDate) ELSE MONTH(ap_mar.ReceiptDate) END=3 AND 
            en_mar.Code LIKE '" . $empresa . "%') AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_abr.ReceiptDate IS NULL THEN YEAR(ap_abr.PaymentDate) ELSE YEAR(ap_abr.ReceiptDate) END=$anio AND 
            CASE WHEN ap_abr.ReceiptDate IS NULL THEN MONTH(ap_abr.PaymentDate) ELSE MONTH(ap_abr.ReceiptDate) END=4 AND 
            en_abr.Code LIKE '" . $empresa . "%') AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_may.ReceiptDate IS NULL THEN YEAR(ap_may.PaymentDate) ELSE YEAR(ap_may.ReceiptDate) END=$anio AND 
            CASE WHEN ap_may.ReceiptDate IS NULL THEN MONTH(ap_may.PaymentDate) ELSE MONTH(ap_may.ReceiptDate) END=5 AND 
            en_may.Code LIKE '" . $empresa . "%') AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_jun.ReceiptDate IS NULL THEN YEAR(ap_jun.PaymentDate) ELSE YEAR(ap_jun.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jun.ReceiptDate IS NULL THEN MONTH(ap_jun.PaymentDate) ELSE MONTH(ap_jun.ReceiptDate) END=6 AND 
            en_jun.Code LIKE '" . $empresa . "%') AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_jul.ReceiptDate IS NULL THEN YEAR(ap_jul.PaymentDate) ELSE YEAR(ap_jul.ReceiptDate) END=$anio AND 
            CASE WHEN ap_jul.ReceiptDate IS NULL THEN MONTH(ap_jul.PaymentDate) ELSE MONTH(ap_jul.ReceiptDate) END=7 AND 
            en_jul.Code LIKE '" . $empresa . "%') AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_ago.ReceiptDate IS NULL THEN YEAR(ap_ago.PaymentDate) ELSE YEAR(ap_ago.ReceiptDate) END=$anio AND 
            CASE WHEN ap_ago.ReceiptDate IS NULL THEN MONTH(ap_ago.PaymentDate) ELSE MONTH(ap_ago.ReceiptDate) END=8 AND 
            en_ago.Code LIKE '" . $empresa . "%') AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_sep.ReceiptDate IS NULL THEN YEAR(ap_sep.PaymentDate) ELSE YEAR(ap_sep.ReceiptDate) END=$anio AND 
            CASE WHEN ap_sep.ReceiptDate IS NULL THEN MONTH(ap_sep.PaymentDate) ELSE MONTH(ap_sep.ReceiptDate) END=9 AND 
            en_sep.Code LIKE '" . $empresa . "%') AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_oct.ReceiptDate IS NULL THEN YEAR(ap_oct.PaymentDate) ELSE YEAR(ap_oct.ReceiptDate) END=$anio AND 
            CASE WHEN ap_oct.ReceiptDate IS NULL THEN MONTH(ap_oct.PaymentDate) ELSE MONTH(ap_oct.ReceiptDate) END=10 AND 
            en_oct.Code LIKE '" . $empresa . "%') AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_nov.ReceiptDate IS NULL THEN YEAR(ap_nov.PaymentDate) ELSE YEAR(ap_nov.ReceiptDate) END=$anio AND 
            CASE WHEN ap_nov.ReceiptDate IS NULL THEN MONTH(ap_nov.PaymentDate) ELSE MONTH(ap_nov.ReceiptDate) END=11 AND 
            en_nov.Code LIKE '" . $empresa . "%') AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE CASE WHEN ap_dic.ReceiptDate IS NULL THEN YEAR(ap_dic.PaymentDate) ELSE YEAR(ap_dic.ReceiptDate) END=$anio AND 
            CASE WHEN ap_dic.ReceiptDate IS NULL THEN MONTH(ap_dic.PaymentDate) ELSE MONTH(ap_dic.ReceiptDate) END=12 AND 
            en_dic.Code LIKE '" . $empresa . "%') AS Diciembre,ISNULL(SUM(ap.Amount),0) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE CASE WHEN ap.ReceiptDate IS NULL THEN YEAR(ap.PaymentDate) ELSE YEAR(ap.ReceiptDate) END=$anio AND 
            en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_impuestos_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT Name,(SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND ap_ene.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_ene.Amount),0) FROM CostRegistry cr_ene
            WHERE YEAR(cr_ene.AccountingDate)=$anio AND MONTH(cr_ene.AccountingDate)=1 AND cr_ene.CostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND ap_feb.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_feb.Amount),0) FROM CostRegistry cr_feb
            WHERE YEAR(cr_feb.AccountingDate)=$anio AND MONTH(cr_feb.AccountingDate)=2 AND cr_feb.CostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND ap_mar.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_mar.Amount),0) FROM CostRegistry cr_mar
            WHERE YEAR(cr_mar.AccountingDate)=$anio AND MONTH(cr_mar.AccountingDate)=3 AND cr_mar.CostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND ap_abr.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_abr.Amount),0) FROM CostRegistry cr_abr
            WHERE YEAR(cr_abr.AccountingDate)=$anio AND MONTH(cr_abr.AccountingDate)=4 AND cr_abr.CostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND ap_may.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_may.Amount),0) FROM CostRegistry cr_may
            WHERE YEAR(cr_may.AccountingDate)=$anio AND MONTH(cr_may.AccountingDate)=5 AND cr_may.CostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND ap_jun.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_jun.Amount),0) FROM CostRegistry cr_jun
            WHERE YEAR(cr_jun.AccountingDate)=$anio AND MONTH(cr_jun.AccountingDate)=6 AND cr_jun.CostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND ap_jul.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_jul.Amount),0) FROM CostRegistry cr_jul
            WHERE YEAR(cr_jul.AccountingDate)=$anio AND MONTH(cr_jul.AccountingDate)=7 AND cr_jul.CostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND ap_ago.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_ago.Amount),0) FROM CostRegistry cr_ago
            WHERE YEAR(cr_ago.AccountingDate)=$anio AND MONTH(cr_ago.AccountingDate)=8 AND cr_ago.CostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND ap_sep.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_sep.Amount),0) FROM CostRegistry cr_sep
            WHERE YEAR(cr_sep.AccountingDate)=$anio AND MONTH(cr_sep.AccountingDate)=9 AND cr_sep.CostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND ap_oct.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_oct.Amount),0) FROM CostRegistry cr_oct
            WHERE YEAR(cr_oct.AccountingDate)=$anio AND MONTH(cr_oct.AccountingDate)=10 AND cr_oct.CostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND ap_nov.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_nov.Amount),0) FROM CostRegistry cr_nov
            WHERE YEAR(cr_nov.AccountingDate)=$anio AND MONTH(cr_nov.AccountingDate)=11 AND cr_nov.CostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND ap_dic.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_dic.Amount),0) FROM CostRegistry cr_dic
            WHERE YEAR(cr_dic.AccountingDate)=$anio AND MONTH(cr_dic.AccountingDate)=12 AND cr_dic.CostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            WHERE YEAR(ap.AccountingDate)=$anio AND ap.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr.Amount),0) FROM CostRegistry cr
            WHERE YEAR(cr.AccountingDate)=$anio AND cr.CostTypeId=co.Id) AS Total
            FROM CostType co
            WHERE co.Id IN (143,147) ORDER BY Name ASC";
    } else {
      $sql = "SELECT Name,(SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND ap_ene.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_ene.Amount),0) FROM CostRegistry cr_ene
            LEFT JOIN EnterpriseHeadquarter en_cr_ene ON en_cr_ene.Id=cr_ene.EnterpriseHeadquarterId
            WHERE YEAR(cr_ene.AccountingDate)=$anio AND MONTH(cr_ene.AccountingDate)=1 AND en_cr_ene.Code LIKE '" . $empresa . "%' AND cr_ene.CostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND ap_feb.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_feb.Amount),0) FROM CostRegistry cr_feb
            LEFT JOIN EnterpriseHeadquarter en_cr_feb ON en_cr_feb.Id=cr_feb.EnterpriseHeadquarterId
            WHERE YEAR(cr_feb.AccountingDate)=$anio AND MONTH(cr_feb.AccountingDate)=2 AND en_cr_feb.Code LIKE '" . $empresa . "%' AND cr_feb.CostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND ap_mar.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_mar.Amount),0) FROM CostRegistry cr_mar
            LEFT JOIN EnterpriseHeadquarter en_cr_mar ON en_cr_mar.Id=cr_mar.EnterpriseHeadquarterId
            WHERE YEAR(cr_mar.AccountingDate)=$anio AND MONTH(cr_mar.AccountingDate)=3 AND en_cr_mar.Code LIKE '" . $empresa . "%' AND cr_mar.CostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND ap_abr.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_abr.Amount),0) FROM CostRegistry cr_abr
            LEFT JOIN EnterpriseHeadquarter en_cr_abr ON en_cr_abr.Id=cr_abr.EnterpriseHeadquarterId
            WHERE YEAR(cr_abr.AccountingDate)=$anio AND MONTH(cr_abr.AccountingDate)=4 AND en_cr_abr.Code LIKE '" . $empresa . "%' AND cr_abr.CostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND en_may.Code LIKE '" . $empresa . "%' AND ap_may.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_may.Amount),0) FROM CostRegistry cr_may
            LEFT JOIN EnterpriseHeadquarter en_cr_may ON en_cr_may.Id=cr_may.EnterpriseHeadquarterId
            WHERE YEAR(cr_may.AccountingDate)=$anio AND MONTH(cr_may.AccountingDate)=5 AND en_cr_may.Code LIKE '" . $empresa . "%' AND cr_may.CostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND ap_jun.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_jun.Amount),0) FROM CostRegistry cr_jun
            LEFT JOIN EnterpriseHeadquarter en_cr_jun ON en_cr_jun.Id=cr_jun.EnterpriseHeadquarterId
            WHERE YEAR(cr_jun.AccountingDate)=$anio AND MONTH(cr_jun.AccountingDate)=6 AND en_cr_jun.Code LIKE '" . $empresa . "%' AND cr_jun.CostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND ap_jul.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_jul.Amount),0) FROM CostRegistry cr_jul
            LEFT JOIN EnterpriseHeadquarter en_cr_jul ON en_cr_jul.Id=cr_jul.EnterpriseHeadquarterId
            WHERE YEAR(cr_jul.AccountingDate)=$anio AND MONTH(cr_jul.AccountingDate)=7 AND en_cr_jul.Code LIKE '" . $empresa . "%' AND cr_jul.CostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND ap_ago.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_ago.Amount),0) FROM CostRegistry cr_ago
            LEFT JOIN EnterpriseHeadquarter en_cr_ago ON en_cr_ago.Id=cr_ago.EnterpriseHeadquarterId
            WHERE YEAR(cr_ago.AccountingDate)=$anio AND MONTH(cr_ago.AccountingDate)=8 AND en_cr_ago.Code LIKE '" . $empresa . "%' AND cr_ago.CostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND ap_sep.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_sep.Amount),0) FROM CostRegistry cr_sep
            LEFT JOIN EnterpriseHeadquarter en_cr_sep ON en_cr_sep.Id=cr_sep.EnterpriseHeadquarterId
            WHERE YEAR(cr_sep.AccountingDate)=$anio AND MONTH(cr_sep.AccountingDate)=9 AND en_cr_sep.Code LIKE '" . $empresa . "%' AND cr_sep.CostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND ap_oct.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_oct.Amount),0) FROM CostRegistry cr_oct
            LEFT JOIN EnterpriseHeadquarter en_cr_oct ON en_cr_oct.Id=cr_oct.EnterpriseHeadquarterId
            WHERE YEAR(cr_oct.AccountingDate)=$anio AND MONTH(cr_oct.AccountingDate)=10 AND en_cr_oct.Code LIKE '" . $empresa . "%' AND cr_oct.CostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND ap_nov.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_nov.Amount),0) FROM CostRegistry cr_nov
            LEFT JOIN EnterpriseHeadquarter en_cr_nov ON en_cr_nov.Id=cr_nov.EnterpriseHeadquarterId
            WHERE YEAR(cr_nov.AccountingDate)=$anio AND MONTH(cr_nov.AccountingDate)=11 AND en_cr_nov.Code LIKE '" . $empresa . "%' AND cr_nov.CostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND ap_dic.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr_dic.Amount),0) FROM CostRegistry cr_dic
            LEFT JOIN EnterpriseHeadquarter en_cr_dic ON en_cr_dic.Id=cr_dic.EnterpriseHeadquarterId
            WHERE YEAR(cr_dic.AccountingDate)=$anio AND MONTH(cr_dic.AccountingDate)=12 AND en_cr_dic.Code LIKE '" . $empresa . "%' AND cr_dic.CostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(ap.AccountingDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ap.CostTypeId=co.Id)+
            (SELECT ISNULL(SUM(cr.Amount),0) FROM CostRegistry cr
            LEFT JOIN EnterpriseHeadquarter en_cr ON en_cr.Id=cr.EnterpriseHeadquarterId
            WHERE YEAR(cr.AccountingDate)=$anio AND en_cr.Code LIKE '" . $empresa . "%' AND cr.CostTypeId=co.Id) AS Total
            FROM CostType co
            WHERE co.Id IN (143,147) ORDER BY Name ASC";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_impuestos_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND ap_ene.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_ene.Amount),0) FROM CostRegistry cr_ene
            WHERE YEAR(cr_ene.AccountingDate)=$anio AND MONTH(cr_ene.AccountingDate)=1 AND cr_ene.CostTypeId IN (143,147)) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND ap_feb.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_feb.Amount),0) FROM CostRegistry cr_feb
            WHERE YEAR(cr_feb.AccountingDate)=$anio AND MONTH(cr_feb.AccountingDate)=2 AND cr_feb.CostTypeId IN (143,147)) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND ap_mar.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_mar.Amount),0) FROM CostRegistry cr_mar
            WHERE YEAR(cr_mar.AccountingDate)=$anio AND MONTH(cr_mar.AccountingDate)=3 AND cr_mar.CostTypeId IN (143,147)) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND ap_abr.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_abr.Amount),0) FROM CostRegistry cr_abr
            WHERE YEAR(cr_abr.AccountingDate)=$anio AND MONTH(cr_abr.AccountingDate)=4 AND cr_abr.CostTypeId IN (143,147)) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND ap_may.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_may.Amount),0) FROM CostRegistry cr_may
            WHERE YEAR(cr_may.AccountingDate)=$anio AND MONTH(cr_may.AccountingDate)=5 AND cr_may.CostTypeId IN (143,147)) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND ap_jun.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_jun.Amount),0) FROM CostRegistry cr_jun
            WHERE YEAR(cr_jun.AccountingDate)=$anio AND MONTH(cr_jun.AccountingDate)=6 AND cr_jun.CostTypeId IN (143,147)) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND ap_jul.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_jul.Amount),0) FROM CostRegistry cr_jul
            WHERE YEAR(cr_jul.AccountingDate)=$anio AND MONTH(cr_jul.AccountingDate)=7 AND cr_jul.CostTypeId IN (143,147)) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND ap_ago.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_ago.Amount),0) FROM CostRegistry cr_ago
            WHERE YEAR(cr_ago.AccountingDate)=$anio AND MONTH(cr_ago.AccountingDate)=8 AND cr_ago.CostTypeId IN (143,147)) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND ap_sep.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_sep.Amount),0) FROM CostRegistry cr_sep
            WHERE YEAR(cr_sep.AccountingDate)=$anio AND MONTH(cr_sep.AccountingDate)=9 AND cr_sep.CostTypeId IN (143,147)) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND ap_oct.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_oct.Amount),0) FROM CostRegistry cr_oct
            WHERE YEAR(cr_oct.AccountingDate)=$anio AND MONTH(cr_oct.AccountingDate)=10 AND cr_oct.CostTypeId IN (143,147)) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND ap_nov.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_nov.Amount),0) FROM CostRegistry cr_nov
            WHERE YEAR(cr_nov.AccountingDate)=$anio AND MONTH(cr_nov.AccountingDate)=11 AND cr_nov.CostTypeId IN (143,147)) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND ap_dic.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_dic.Amount),0) FROM CostRegistry cr_dic
            WHERE YEAR(cr_dic.AccountingDate)=$anio AND MONTH(cr_dic.AccountingDate)=12 AND cr_dic.CostTypeId IN (143,147)) AS Diciembre,
            ISNULL(SUM(ap.Amount),0)+(SELECT ISNULL(SUM(cr.Amount),0) FROM CostRegistry cr
            WHERE YEAR(AccountingDate)=$anio AND cr.CostTypeId IN (143,147)) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN CostType ct ON ct.Id=ap.CostTypeId AND ct.Id IN (143,147)
            WHERE YEAR(ap.AccountingDate)=$anio AND ap.CostTypeId IN (143,147)";
    } else {
      $sql = "SELECT (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND ap_ene.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_ene.Amount),0) FROM CostRegistry cr_ene
            LEFT JOIN EnterpriseHeadquarter en_cr_ene ON en_cr_ene.Id=cr_ene.EnterpriseHeadquarterId
            WHERE YEAR(cr_ene.AccountingDate)=$anio AND MONTH(cr_ene.AccountingDate)=1 AND en_cr_ene.Code LIKE '" . $empresa . "%' AND cr_ene.CostTypeId IN (143,147)) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND ap_feb.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_feb.Amount),0) FROM CostRegistry cr_feb
            LEFT JOIN EnterpriseHeadquarter en_cr_feb ON en_cr_feb.Id=cr_feb.EnterpriseHeadquarterId
            WHERE YEAR(cr_feb.AccountingDate)=$anio AND MONTH(cr_feb.AccountingDate)=2 AND en_cr_feb.Code LIKE '" . $empresa . "%' AND cr_feb.CostTypeId IN (143,147)) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND ap_mar.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_mar.Amount),0) FROM CostRegistry cr_mar
            LEFT JOIN EnterpriseHeadquarter en_cr_mar ON en_cr_mar.Id=cr_mar.EnterpriseHeadquarterId
            WHERE YEAR(cr_mar.AccountingDate)=$anio AND MONTH(cr_mar.AccountingDate)=3 AND en_cr_mar.Code LIKE '" . $empresa . "%' AND cr_mar.CostTypeId IN (143,147)) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND ap_abr.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_abr.Amount),0) FROM CostRegistry cr_abr
            LEFT JOIN EnterpriseHeadquarter en_cr_abr ON en_cr_abr.Id=cr_abr.EnterpriseHeadquarterId
            WHERE YEAR(cr_abr.AccountingDate)=$anio AND MONTH(cr_abr.AccountingDate)=4 AND en_cr_abr.Code LIKE '" . $empresa . "%' AND cr_abr.CostTypeId IN (143,147)) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND en_may.Code LIKE '" . $empresa . "%' AND ap_may.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_may.Amount),0) FROM CostRegistry cr_may
            LEFT JOIN EnterpriseHeadquarter en_cr_may ON en_cr_may.Id=cr_may.EnterpriseHeadquarterId
            WHERE YEAR(cr_may.AccountingDate)=$anio AND MONTH(cr_may.AccountingDate)=5 AND en_cr_may.Code LIKE '" . $empresa . "%' AND cr_may.CostTypeId IN (143,147)) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND ap_jun.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_jun.Amount),0) FROM CostRegistry cr_jun
            LEFT JOIN EnterpriseHeadquarter en_cr_jun ON en_cr_jun.Id=cr_jun.EnterpriseHeadquarterId
            WHERE YEAR(cr_jun.AccountingDate)=$anio AND MONTH(cr_jun.AccountingDate)=6 AND en_cr_jun.Code LIKE '" . $empresa . "%' AND cr_jun.CostTypeId IN (143,147)) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND ap_jul.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_jul.Amount),0) FROM CostRegistry cr_jul
            LEFT JOIN EnterpriseHeadquarter en_cr_jul ON en_cr_jul.Id=cr_jul.EnterpriseHeadquarterId
            WHERE YEAR(cr_jul.AccountingDate)=$anio AND MONTH(cr_jul.AccountingDate)=7 AND en_cr_jul.Code LIKE '" . $empresa . "%' AND cr_jul.CostTypeId IN (143,147)) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND ap_ago.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_ago.Amount),0) FROM CostRegistry cr_ago
            LEFT JOIN EnterpriseHeadquarter en_cr_ago ON en_cr_ago.Id=cr_ago.EnterpriseHeadquarterId
            WHERE YEAR(cr_ago.AccountingDate)=$anio AND MONTH(cr_ago.AccountingDate)=8 AND en_cr_ago.Code LIKE '" . $empresa . "%' AND cr_ago.CostTypeId IN (143,147)) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND ap_sep.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_sep.Amount),0) FROM CostRegistry cr_sep
            LEFT JOIN EnterpriseHeadquarter en_cr_sep ON en_cr_sep.Id=cr_sep.EnterpriseHeadquarterId
            WHERE YEAR(cr_sep.AccountingDate)=$anio AND MONTH(cr_sep.AccountingDate)=9 AND en_cr_sep.Code LIKE '" . $empresa . "%' AND cr_sep.CostTypeId IN (143,147)) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND ap_oct.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_oct.Amount),0) FROM CostRegistry cr_oct
            LEFT JOIN EnterpriseHeadquarter en_cr_oct ON en_cr_oct.Id=cr_oct.EnterpriseHeadquarterId
            WHERE YEAR(cr_oct.AccountingDate)=$anio AND MONTH(cr_oct.AccountingDate)=10 AND en_cr_oct.Code LIKE '" . $empresa . "%' AND cr_oct.CostTypeId IN (143,147)) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND ap_nov.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_nov.Amount),0) FROM CostRegistry cr_nov
            LEFT JOIN EnterpriseHeadquarter en_cr_nov ON en_cr_nov.Id=cr_nov.EnterpriseHeadquarterId
            WHERE YEAR(cr_nov.AccountingDate)=$anio AND MONTH(cr_nov.AccountingDate)=11 AND en_cr_nov.Code LIKE '" . $empresa . "%' AND cr_nov.CostTypeId IN (143,147)) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND ap_dic.CostTypeId IN (143,147))+
            (SELECT ISNULL(SUM(cr_dic.Amount),0) FROM CostRegistry cr_dic
            LEFT JOIN EnterpriseHeadquarter en_cr_dic ON en_cr_dic.Id=cr_dic.EnterpriseHeadquarterId
            WHERE YEAR(cr_dic.AccountingDate)=$anio AND MONTH(cr_dic.AccountingDate)=12 AND en_cr_dic.Code LIKE '" . $empresa . "%' AND cr_dic.CostTypeId IN (143,147)) AS Diciembre,
            ISNULL(SUM(ap.Amount),0)+(SELECT ISNULL(SUM(cr.Amount),0) FROM CostRegistry cr
            LEFT JOIN EnterpriseHeadquarter en_cr ON en_cr.Id=cr.EnterpriseHeadquarterId
            WHERE YEAR(AccountingDate)=$anio AND en_cr.Code LIKE '" . $empresa . "%' AND cr.CostTypeId IN (143,147)) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN CostType ct ON ct.Id=ap.CostTypeId AND ct.Id IN (143,147)
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(ap.AccountingDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ap.CostTypeId IN (143,147)";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_aumentos_arpay_online($empresa, $anio)
  {
    $sql = "SELECT ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=1 AND OperationTypeId IN (3,7)),0) AS Enero,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=2 AND OperationTypeId IN (3,7)),0) AS Febrero,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=3 AND OperationTypeId IN (3,7)),0) AS Marzo,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=4 AND OperationTypeId IN (3,7)),0) AS Abril,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=5 AND OperationTypeId IN (3,7)),0) AS Mayo,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=6 AND OperationTypeId IN (3,7)),0) AS Junio,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=7 AND OperationTypeId IN (3,7)),0) AS Julio,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=8 AND OperationTypeId IN (3,7)),0) AS Agosto,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=9 AND OperationTypeId IN (3,7)),0) AS Septiembre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=10 AND OperationTypeId IN (3,7)),0) AS Octubre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=11 AND OperationTypeId IN (3,7)),0) AS Noviembre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=12 AND OperationTypeId IN (3,7)),0) AS Diciembre,
          ISNULL(SUM(Amount),0) AS Total
          FROM SystemMoneyTransfer 
          WHERE YEAR(Date)=$anio AND OperationTypeId IN (3,7)";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_salidas_arpay_online($empresa, $anio)
  {
    $sql = "SELECT ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=1 AND OperationTypeId IN (2,6)),0) AS Enero,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=2 AND OperationTypeId IN (2,6)),0) AS Febrero,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=3 AND OperationTypeId IN (2,6)),0) AS Marzo,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=4 AND OperationTypeId IN (2,6)),0) AS Abril,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=5 AND OperationTypeId IN (2,6)),0) AS Mayo,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=6 AND OperationTypeId IN (2,6)),0) AS Junio,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=7 AND OperationTypeId IN (2,6)),0) AS Julio,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=8 AND OperationTypeId IN (2,6)),0) AS Agosto,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=9 AND OperationTypeId IN (2,6)),0) AS Septiembre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=10 AND OperationTypeId IN (2,6)),0) AS Octubre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=11 AND OperationTypeId IN (2,6)),0) AS Noviembre,
          ISNULL((SELECT SUM(Amount) FROM SystemMoneyTransfer WHERE YEAR(Date)=$anio AND MONTH(Date)=12 AND OperationTypeId IN (2,6)),0) AS Diciembre,
          ISNULL(SUM(Amount),0) AS Total
          FROM SystemMoneyTransfer 
          WHERE YEAR(Date)=$anio AND OperationTypeId IN (2,6)";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_gastos_personales_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=1 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=1 AND CostTypeId IN (20,49)),0) AS Enero,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=2 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=2 AND CostTypeId IN (20,49)),0) AS Febrero,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=3 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=3 AND CostTypeId IN (20,49)),0) AS Marzo,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=4 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=4 AND CostTypeId IN (20,49)),0) AS Abril,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=5 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=5 AND CostTypeId IN (20,49)),0) AS Mayo,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=6 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=6 AND CostTypeId IN (20,49)),0) AS Junio,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=7 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=7 AND CostTypeId IN (20,49)),0) AS Julio,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=8 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=8 AND CostTypeId IN (20,49)),0) AS Agosto,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=9 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=9 AND CostTypeId IN (20,49)),0) AS Septiembre,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=10 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=10 AND CostTypeId IN (20,49)),0) AS Octubre,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=11 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=11 AND CostTypeId IN (20,49)),0) AS Noviembre,
            ISNULL((SELECT SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND MONTH(CreationDate)=12 AND CostTypeId IN (20,49)),0) FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND MONTH(PaymentDate)=12 AND CostTypeId IN (20,49)),0) AS Diciembre,
            ISNULL(SUM(Amount)+ISNULL((SELECT SUM(Amount) FROM CostRegistry 
            WHERE YEAR(CreationDate)=$anio AND CostTypeId IN (20,49)),0),0) AS Total FROM AccountingPayment 
            WHERE YEAR(PaymentDate)=$anio AND CostTypeId IN (20,49)";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ap_ene.Amount)+ISNULL((SELECT SUM(cr_ene.Amount) FROM CostRegistry cr_ene
            LEFT JOIN EnterpriseHeadquarter en_cr_ene ON en_cr_ene.Id=cr_ene.EnterpriseHeadquarterId
            WHERE YEAR(cr_ene.CreationDate)=$anio AND MONTH(cr_ene.CreationDate)=1 AND en_cr_ene.Code LIKE '" . $empresa . "%' AND cr_ene.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE YEAR(ap_ene.PaymentDate)=$anio AND MONTH(ap_ene.PaymentDate)=1 AND en_ene.Code LIKE'" . $empresa . "' AND ap_ene.CostTypeId IN (20,49)),0) AS Enero,
            ISNULL((SELECT SUM(ap_feb.Amount)+ISNULL((SELECT SUM(cr_feb.Amount) FROM CostRegistry cr_feb
            LEFT JOIN EnterpriseHeadquarter en_cr_feb ON en_cr_feb.Id=cr_feb.EnterpriseHeadquarterId
            WHERE YEAR(cr_feb.CreationDate)=$anio AND MONTH(cr_feb.CreationDate)=1 AND en_cr_feb.Code LIKE '" . $empresa . "%' AND cr_feb.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE YEAR(ap_feb.PaymentDate)=$anio AND MONTH(ap_feb.PaymentDate)=1 AND en_feb.Code LIKE'" . $empresa . "' AND ap_feb.CostTypeId IN (20,49)),0) AS Febrero,
            ISNULL((SELECT SUM(ap_mar.Amount)+ISNULL((SELECT SUM(cr_mar.Amount) FROM CostRegistry cr_mar
            LEFT JOIN EnterpriseHeadquarter en_cr_mar ON en_cr_mar.Id=cr_mar.EnterpriseHeadquarterId
            WHERE YEAR(cr_mar.CreationDate)=$anio AND MONTH(cr_mar.CreationDate)=1 AND en_cr_mar.Code LIKE '" . $empresa . "%' AND cr_mar.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE YEAR(ap_mar.PaymentDate)=$anio AND MONTH(ap_mar.PaymentDate)=1 AND en_mar.Code LIKE'" . $empresa . "' AND ap_mar.CostTypeId IN (20,49)),0) AS Marzo,
            ISNULL((SELECT SUM(ap_abr.Amount)+ISNULL((SELECT SUM(cr_abr.Amount) FROM CostRegistry cr_abr
            LEFT JOIN EnterpriseHeadquarter en_cr_abr ON en_cr_abr.Id=cr_abr.EnterpriseHeadquarterId
            WHERE YEAR(cr_abr.CreationDate)=$anio AND MONTH(cr_abr.CreationDate)=1 AND en_cr_abr.Code LIKE '" . $empresa . "%' AND cr_abr.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE YEAR(ap_abr.PaymentDate)=$anio AND MONTH(ap_abr.PaymentDate)=1 AND en_abr.Code LIKE'" . $empresa . "' AND ap_abr.CostTypeId IN (20,49)),0) AS Abril,
            ISNULL((SELECT SUM(ap_may.Amount)+ISNULL((SELECT SUM(cr_may.Amount) FROM CostRegistry cr_may
            LEFT JOIN EnterpriseHeadquarter en_cr_may ON en_cr_may.Id=cr_may.EnterpriseHeadquarterId
            WHERE YEAR(cr_may.CreationDate)=$anio AND MONTH(cr_may.CreationDate)=1 AND en_cr_may.Code LIKE '" . $empresa . "%' AND cr_may.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE YEAR(ap_may.PaymentDate)=$anio AND MONTH(ap_may.PaymentDate)=1 AND en_may.Code LIKE'" . $empresa . "' AND ap_may.CostTypeId IN (20,49)),0) AS Mayo,
            ISNULL((SELECT SUM(ap_jun.Amount)+ISNULL((SELECT SUM(cr_jun.Amount) FROM CostRegistry cr_jun
            LEFT JOIN EnterpriseHeadquarter en_cr_jun ON en_cr_jun.Id=cr_jun.EnterpriseHeadquarterId
            WHERE YEAR(cr_jun.CreationDate)=$anio AND MONTH(cr_jun.CreationDate)=1 AND en_cr_jun.Code LIKE '" . $empresa . "%' AND cr_jun.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE YEAR(ap_jun.PaymentDate)=$anio AND MONTH(ap_jun.PaymentDate)=1 AND en_jun.Code LIKE'" . $empresa . "' AND ap_jun.CostTypeId IN (20,49)),0) AS Junio,
            ISNULL((SELECT SUM(ap_jul.Amount)+ISNULL((SELECT SUM(cr_jul.Amount) FROM CostRegistry cr_jul
            LEFT JOIN EnterpriseHeadquarter en_cr_jul ON en_cr_jul.Id=cr_jul.EnterpriseHeadquarterId
            WHERE YEAR(cr_jul.CreationDate)=$anio AND MONTH(cr_jul.CreationDate)=1 AND en_cr_jul.Code LIKE '" . $empresa . "%' AND cr_jul.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE YEAR(ap_jul.PaymentDate)=$anio AND MONTH(ap_jul.PaymentDate)=1 AND en_jul.Code LIKE'" . $empresa . "' AND ap_jul.CostTypeId IN (20,49)),0) AS Julio,
            ISNULL((SELECT SUM(ap_ago.Amount)+ISNULL((SELECT SUM(cr_ago.Amount) FROM CostRegistry cr_ago
            LEFT JOIN EnterpriseHeadquarter en_cr_ago ON en_cr_ago.Id=cr_ago.EnterpriseHeadquarterId
            WHERE YEAR(cr_ago.CreationDate)=$anio AND MONTH(cr_ago.CreationDate)=1 AND en_cr_ago.Code LIKE '" . $empresa . "%' AND cr_ago.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE YEAR(ap_ago.PaymentDate)=$anio AND MONTH(ap_ago.PaymentDate)=1 AND en_ago.Code LIKE'" . $empresa . "' AND ap_ago.CostTypeId IN (20,49)),0) AS Agosto,
            ISNULL((SELECT SUM(ap_sep.Amount)+ISNULL((SELECT SUM(cr_sep.Amount) FROM CostRegistry cr_sep
            LEFT JOIN EnterpriseHeadquarter en_cr_sep ON en_cr_sep.Id=cr_sep.EnterpriseHeadquarterId
            WHERE YEAR(cr_sep.CreationDate)=$anio AND MONTH(cr_sep.CreationDate)=1 AND en_cr_sep.Code LIKE '" . $empresa . "%' AND cr_sep.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE YEAR(ap_sep.PaymentDate)=$anio AND MONTH(ap_sep.PaymentDate)=1 AND en_sep.Code LIKE'" . $empresa . "' AND ap_sep.CostTypeId IN (20,49)),0) AS Septiembre,
            ISNULL((SELECT SUM(ap_oct.Amount)+ISNULL((SELECT SUM(cr_oct.Amount) FROM CostRegistry cr_oct
            LEFT JOIN EnterpriseHeadquarter en_cr_oct ON en_cr_oct.Id=cr_oct.EnterpriseHeadquarterId
            WHERE YEAR(cr_oct.CreationDate)=$anio AND MONTH(cr_oct.CreationDate)=1 AND en_cr_oct.Code LIKE '" . $empresa . "%' AND cr_oct.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE YEAR(ap_oct.PaymentDate)=$anio AND MONTH(ap_oct.PaymentDate)=1 AND en_oct.Code LIKE'" . $empresa . "' AND ap_oct.CostTypeId IN (20,49)),0) AS Octubre,
            ISNULL((SELECT SUM(ap_nov.Amount)+ISNULL((SELECT SUM(cr_nov.Amount) FROM CostRegistry cr_nov
            LEFT JOIN EnterpriseHeadquarter en_cr_nov ON en_cr_nov.Id=cr_nov.EnterpriseHeadquarterId
            WHERE YEAR(cr_nov.CreationDate)=$anio AND MONTH(cr_nov.CreationDate)=1 AND en_cr_nov.Code LIKE '" . $empresa . "%' AND cr_nov.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE YEAR(ap_nov.PaymentDate)=$anio AND MONTH(ap_nov.PaymentDate)=1 AND en_nov.Code LIKE'" . $empresa . "' AND ap_nov.CostTypeId IN (20,49)),0) AS Noviembre,
            ISNULL((SELECT SUM(ap_dic.Amount)+ISNULL((SELECT SUM(cr_dic.Amount) FROM CostRegistry cr_dic
            LEFT JOIN EnterpriseHeadquarter en_cr_dic ON en_cr_dic.Id=cr_dic.EnterpriseHeadquarterId
            WHERE YEAR(cr_dic.CreationDate)=$anio AND MONTH(cr_dic.CreationDate)=1 AND en_cr_dic.Code LIKE '" . $empresa . "%' AND cr_dic.CostTypeId IN (20,49)),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE YEAR(ap_dic.PaymentDate)=$anio AND MONTH(ap_dic.PaymentDate)=1 AND en_dic.Code LIKE'" . $empresa . "' AND ap_dic.CostTypeId IN (20,49)),0) AS Diciembre,
            ISNULL(SUM(ap.Amount)+ISNULL((SELECT SUM(cr.Amount) FROM CostRegistry cr
            LEFT JOIN EnterpriseHeadquarter en_cr ON en_cr.Id=cr.EnterpriseHeadquarterId
            WHERE YEAR(cr.CreationDate)=$anio AND en_cr.Code LIKE '" . $empresa . "%' AND cr.CostTypeId IN (20,49)),0),0) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(ap.PaymentDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ap.CostTypeId IN (20,49);";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_cuentas_por_cobrar_arpay_online($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.Cost) FROM Invoice iv_ene 
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1 AND cp_ene.PaymentStatusId=2),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.Cost) FROM Invoice iv_feb 
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2 AND cp_feb.PaymentStatusId=2),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.Cost) FROM Invoice iv_mar 
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3 AND cp_mar.PaymentStatusId=2),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.Cost) FROM Invoice iv_abr 
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4 AND cp_abr.PaymentStatusId=2),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.Cost) FROM Invoice iv_may 
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5 AND cp_may.PaymentStatusId=2),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.Cost) FROM Invoice iv_jun 
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6 AND cp_jun.PaymentStatusId=2),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.Cost) FROM Invoice iv_jul 
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7 AND cp_jul.PaymentStatusId=2),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.Cost) FROM Invoice iv_ago 
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8 AND cp_ago.PaymentStatusId=2),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.Cost) FROM Invoice iv_sep 
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9 AND cp_sep.PaymentStatusId=2),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.Cost) FROM Invoice iv_oct 
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10 AND cp_oct.PaymentStatusId=2),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.Cost) FROM Invoice iv_nov 
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11 AND cp_nov.PaymentStatusId=2),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.Cost) FROM Invoice iv_dic 
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId 
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12 AND cp_dic.PaymentStatusId=2),0) AS Diciembre,
            ISNULL(SUM(cp.Cost),0) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            WHERE YEAR(iv.Date)=$anio AND cp.PaymentStatusId=2";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.Cost) FROM Invoice iv_ene 
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND cp_ene.PaymentStatusId=2),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.Cost) FROM Invoice iv_feb 
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND cp_feb.PaymentStatusId=2),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.Cost) FROM Invoice iv_mar 
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND cp_mar.PaymentStatusId=2),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.Cost) FROM Invoice iv_abr 
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND cp_abr.PaymentStatusId=2),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.Cost) FROM Invoice iv_may 
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5 AND en_may.Code LIKE '" . $empresa . "%' AND cp_may.PaymentStatusId=2),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.Cost) FROM Invoice iv_jun 
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND cp_jun.PaymentStatusId=2),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.Cost) FROM Invoice iv_jul 
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND cp_jul.PaymentStatusId=2),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.Cost) FROM Invoice iv_ago 
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND cp_ago.PaymentStatusId=2),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.Cost) FROM Invoice iv_sep 
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND cp_sep.PaymentStatusId=2),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.Cost) FROM Invoice iv_oct 
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND cp_oct.PaymentStatusId=2),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.Cost) FROM Invoice iv_nov 
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND cp_nov.PaymentStatusId=2),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.Cost) FROM Invoice iv_dic 
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND cp_dic.PaymentStatusId=2),0) AS Diciembre,
            ISNULL(SUM(cp.Cost),0) AS Total 
            FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(iv.Date)=$anio AND en.Code LIKE '" . $empresa . "%' AND cp.PaymentStatusId=2";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_acumulado_arpay_online($empresa)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.Cost) FROM Invoice iv_ene 
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_ene.Date)=1 AND cp_ene.PaymentStatusId=2),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.Cost) FROM Invoice iv_feb 
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_feb.Date)=2 AND cp_feb.PaymentStatusId=2),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.Cost) FROM Invoice iv_mar 
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_mar.Date)=3 AND cp_mar.PaymentStatusId=2),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.Cost) FROM Invoice iv_abr 
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_abr.Date)=4 AND cp_abr.PaymentStatusId=2),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.Cost) FROM Invoice iv_may 
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_may.Date)=5 AND cp_may.PaymentStatusId=2),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.Cost) FROM Invoice iv_jun 
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_jun.Date)=6 AND cp_jun.PaymentStatusId=2),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.Cost) FROM Invoice iv_jul 
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_jul.Date)=7 AND cp_jul.PaymentStatusId=2),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.Cost) FROM Invoice iv_ago 
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_ago.Date)=8 AND cp_ago.PaymentStatusId=2),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.Cost) FROM Invoice iv_sep 
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_sep.Date)=9 AND cp_sep.PaymentStatusId=2),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.Cost) FROM Invoice iv_oct 
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_oct.Date)=10 AND cp_oct.PaymentStatusId=2),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.Cost) FROM Invoice iv_nov 
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_nov.Date)=11 AND cp_nov.PaymentStatusId=2),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.Cost) FROM Invoice iv_dic 
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId 
            WHERE MONTH(iv_dic.Date)=12 AND cp_dic.PaymentStatusId=2),0) AS Diciembre,
            ISNULL(SUM(cp.Cost),0) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            WHERE cp.PaymentStatusId=2";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.Cost) FROM Invoice iv_ene 
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE MONTH(iv_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND cp_ene.PaymentStatusId=2),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.Cost) FROM Invoice iv_feb 
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE MONTH(iv_feb.Date)=1 AND en_feb.Code LIKE '" . $empresa . "%' AND cp_feb.PaymentStatusId=2),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.Cost) FROM Invoice iv_mar 
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE MONTH(iv_mar.Date)=1 AND en_mar.Code LIKE '" . $empresa . "%' AND cp_mar.PaymentStatusId=2),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.Cost) FROM Invoice iv_abr 
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE MONTH(iv_abr.Date)=1 AND en_abr.Code LIKE '" . $empresa . "%' AND cp_abr.PaymentStatusId=2),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.Cost) FROM Invoice iv_may 
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE MONTH(iv_may.Date)=1 AND en_may.Code LIKE '" . $empresa . "%' AND cp_may.PaymentStatusId=2),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.Cost) FROM Invoice iv_jun 
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE MONTH(iv_jun.Date)=1 AND en_jun.Code LIKE '" . $empresa . "%' AND cp_jun.PaymentStatusId=2),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.Cost) FROM Invoice iv_jul 
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE MONTH(iv_jul.Date)=1 AND en_jul.Code LIKE '" . $empresa . "%' AND cp_jul.PaymentStatusId=2),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.Cost) FROM Invoice iv_ago 
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE MONTH(iv_ago.Date)=1 AND en_ago.Code LIKE '" . $empresa . "%' AND cp_ago.PaymentStatusId=2),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.Cost) FROM Invoice iv_sep 
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE MONTH(iv_sep.Date)=1 AND en_sep.Code LIKE '" . $empresa . "%' AND cp_sep.PaymentStatusId=2),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.Cost) FROM Invoice iv_oct 
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE MONTH(iv_oct.Date)=1 AND en_oct.Code LIKE '" . $empresa . "%' AND cp_oct.PaymentStatusId=2),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.Cost) FROM Invoice iv_nov 
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE MONTH(iv_nov.Date)=1 AND en_nov.Code LIKE '" . $empresa . "%' AND cp_nov.PaymentStatusId=2),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.Cost) FROM Invoice iv_dic 
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE MONTH(iv_dic.Date)=1 AND en_dic.Code LIKE '" . $empresa . "%' AND cp_dic.PaymentStatusId=2),0) AS Diciembre,
            ISNULL(SUM(cp.Cost),0) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE en.Code LIKE '" . $empresa . "%' AND cp.PaymentStatusId=2";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }
  //---------------------------------BALANCE OFICIAL------------------------------------
  function total_boletas_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Invoice iv_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Invoice iv_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Invoice iv_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Invoice iv_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Invoice iv_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Invoice iv_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Invoice iv_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Invoice iv_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Invoice iv_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Invoice iv_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Invoice iv_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Invoice iv_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            WHERE YEAR(iv.Date)=$anio";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Invoice iv_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%'),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Invoice iv_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2 AND en_feb.Code LIKE '" . $empresa . "%'),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Invoice iv_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3 AND en_mar.Code LIKE '" . $empresa . "%'),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Invoice iv_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4 AND en_abr.Code LIKE '" . $empresa . "%'),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Invoice iv_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5 AND en_may.Code LIKE '" . $empresa . "%'),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Invoice iv_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6 AND en_jun.Code LIKE '" . $empresa . "%'),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Invoice iv_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7 AND en_jul.Code LIKE '" . $empresa . "%'),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Invoice iv_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8 AND en_ago.Code LIKE '" . $empresa . "%'),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Invoice iv_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9 AND en_sep.Code LIKE '" . $empresa . "%'),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Invoice iv_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10 AND en_oct.Code LIKE '" . $empresa . "%'),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Invoice iv_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11 AND en_nov.Code LIKE '" . $empresa . "%'),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Invoice iv_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12 AND en_dic.Code LIKE '" . $empresa . "%'),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(iv.Date)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function resumen_boletas_balance_oficial($empresa, $anio, $mes)
  {
    if ($empresa == "GL") {
      $parte = "";
    } else {
      $parte = "AND en_feb.Code LIKE '$empresa%'";
    }
    $sql = "SELECT 'Boleta' as Tipo_Comprobante, iv.Date as Fecha_Doc, pst.Description as Estado_Pago, 
              ptt.Description as Tipo_Pago, concat(invs.Code, ' - 0000', iv.InvoiceNumber) as Nro_Doc,
			        per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId, 
              (Cost-ISNULL(TotalDiscount,0)) as Monto, pit.Name, cp.Description,invst.Description as Estado
			        FROM Invoice iv
			        LEFT JOIN InvoiceSeries invs on invs.Id=iv.InvoiceSeriesId
			        LEFT JOIN InvoiceStatusTranslation invst on invst.InvoiceStatusId=iv.InvoiceStatusId and invst.Language='es-PE'
              LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
              LEFT JOIN ProductItem pit on pit.Id=cp.ProductItemId
              LEFT JOIN PaymentStatusTranslation pst on pst.PaymentStatusId=cp.PaymentStatusId
              LEFT JOIN PaymentTypeTranslation ptt on ptt.PaymentTypeId=cp.PaymentTypeId and ptt.Language='es-PE'
              LEFT JOIN Client cli ON cli.Id=cp.ClientId
              LEFT JOIN Person per ON per.Id=cli.PersonId
              LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cli.EnterpriseHeadquarterId
              WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$mes $parte
			        ORDER BY iv.Date desc, iv.InvoiceNumber desc, per.FatherSurname";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_cuentas_por_cobrar_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Invoice iv_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1 AND cp_ene.PaymentStatusId=2),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Invoice iv_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2 AND cp_feb.PaymentStatusId=2),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Invoice iv_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3 AND cp_mar.PaymentStatusId=2),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Invoice iv_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4 AND cp_abr.PaymentStatusId=2),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Invoice iv_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5 AND cp_may.PaymentStatusId=2),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Invoice iv_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6 AND cp_jun.PaymentStatusId=2),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Invoice iv_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7 AND cp_jul.PaymentStatusId=2),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Invoice iv_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8 AND cp_ago.PaymentStatusId=2),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Invoice iv_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9 AND cp_sep.PaymentStatusId=2),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Invoice iv_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10 AND cp_oct.PaymentStatusId=2),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Invoice iv_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11 AND cp_nov.PaymentStatusId=2),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Invoice iv_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12 AND cp_dic.PaymentStatusId=2),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            WHERE YEAR(iv.Date)=$anio AND cp.PaymentStatusId=2";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Invoice iv_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(iv_ene.Date)=$anio AND MONTH(iv_ene.Date)=1 AND cp_ene.PaymentStatusId=2 AND en_ene.Code LIKE '" . $empresa . "%'),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Invoice iv_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=iv_feb.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(iv_feb.Date)=$anio AND MONTH(iv_feb.Date)=2 AND cp_feb.PaymentStatusId=2 AND en_feb.Code LIKE '" . $empresa . "%'),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Invoice iv_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=iv_mar.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(iv_mar.Date)=$anio AND MONTH(iv_mar.Date)=3 AND cp_mar.PaymentStatusId=2 AND en_mar.Code LIKE '" . $empresa . "%'),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Invoice iv_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=iv_abr.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(iv_abr.Date)=$anio AND MONTH(iv_abr.Date)=4 AND cp_abr.PaymentStatusId=2 AND en_abr.Code LIKE '" . $empresa . "%'),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Invoice iv_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=iv_may.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(iv_may.Date)=$anio AND MONTH(iv_may.Date)=5 AND cp_may.PaymentStatusId=2 AND en_may.Code LIKE '" . $empresa . "%'),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Invoice iv_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=iv_jun.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(iv_jun.Date)=$anio AND MONTH(iv_jun.Date)=6 AND cp_jun.PaymentStatusId=2 AND en_jun.Code LIKE '" . $empresa . "%'),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Invoice iv_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=iv_jul.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(iv_jul.Date)=$anio AND MONTH(iv_jul.Date)=7 AND cp_jul.PaymentStatusId=2 AND en_jul.Code LIKE '" . $empresa . "%'),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Invoice iv_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=iv_ago.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(iv_ago.Date)=$anio AND MONTH(iv_ago.Date)=8 AND cp_ago.PaymentStatusId=2 AND en_ago.Code LIKE '" . $empresa . "%'),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Invoice iv_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=iv_sep.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(iv_sep.Date)=$anio AND MONTH(iv_sep.Date)=9 AND cp_sep.PaymentStatusId=2 AND en_sep.Code LIKE '" . $empresa . "%'),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Invoice iv_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=iv_oct.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(iv_oct.Date)=$anio AND MONTH(iv_oct.Date)=10 AND cp_oct.PaymentStatusId=2 AND en_oct.Code LIKE '" . $empresa . "%'),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Invoice iv_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=iv_nov.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(iv_nov.Date)=$anio AND MONTH(iv_nov.Date)=11 AND cp_nov.PaymentStatusId=2 AND en_nov.Code LIKE '" . $empresa . "%'),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Invoice iv_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=iv_dic.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(iv_dic.Date)=$anio AND MONTH(iv_dic.Date)=12 AND cp_dic.PaymentStatusId=2 AND en_dic.Code LIKE '" . $empresa . "%'),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(iv.Date)=$anio AND cp.PaymentStatusId=2 AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function resumen_cuentas_por_cobrar_balance_oficial($empresa, $anio, $mes)
  {
    if ($empresa == "GL") {
      $parte = "";
    } else {
      $parte = "AND en_feb.Code LIKE '$empresa%'";
    }
    $sql = "SELECT 'Cuentas Por Cobrar' as Tipo_Comprobante, iv.Date as Fecha_Doc, pst.Description as Estado_Pago, 
              ptt.Description as Tipo_Pago, concat(invs.Code, ' - 0000', iv.InvoiceNumber) as Nro_Doc,
              per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId, 
              (Cost-ISNULL(TotalDiscount,0)) as Monto, pit.Name, cp.Description,invst.Description as Estado
              FROM Invoice iv
              LEFT JOIN InvoiceSeries invs on invs.Id=iv.InvoiceSeriesId
              LEFT JOIN InvoiceStatusTranslation invst on invst.InvoiceStatusId=iv.InvoiceStatusId and invst.Language='es-PE'
              LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
              LEFT JOIN ProductItem pit on pit.Id=cp.ProductItemId
              LEFT JOIN PaymentStatusTranslation pst on pst.PaymentStatusId=cp.PaymentStatusId
              LEFT JOIN PaymentTypeTranslation ptt on ptt.PaymentTypeId=cp.PaymentTypeId and ptt.Language='es-PE'
              LEFT JOIN Client cli ON cli.Id=cp.ClientId
              LEFT JOIN Person per ON per.Id=cli.PersonId
              LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cli.EnterpriseHeadquarterId
              WHERE YEAR(iv.Date)=$anio AND cp.PaymentStatusId=2 AND MONTH(iv.Date)=$mes $parte
              ORDER BY iv.Date desc, iv.InvoiceNumber desc, per.FatherSurname";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_facturas_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Bill bi_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=bi_ene.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_ene.Date)=$anio AND MONTH(bi_ene.Date)=1),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Bill bi_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=bi_feb.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_feb.Date)=$anio AND MONTH(bi_feb.Date)=2),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Bill bi_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=bi_mar.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_mar.Date)=$anio AND MONTH(bi_mar.Date)=3),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Bill bi_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=bi_abr.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_abr.Date)=$anio AND MONTH(bi_abr.Date)=4),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Bill bi_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=bi_may.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_may.Date)=$anio AND MONTH(bi_may.Date)=5),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Bill bi_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=bi_jun.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_jun.Date)=$anio AND MONTH(bi_jun.Date)=6),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Bill bi_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=bi_jul.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_jul.Date)=$anio AND MONTH(bi_jul.Date)=7),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Bill bi_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=bi_ago.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_ago.Date)=$anio AND MONTH(bi_ago.Date)=8),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Bill bi_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=bi_sep.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_sep.Date)=$anio AND MONTH(bi_sep.Date)=9),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Bill bi_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=bi_oct.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_oct.Date)=$anio AND MONTH(bi_oct.Date)=10),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Bill bi_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=bi_nov.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_nov.Date)=$anio AND MONTH(bi_nov.Date)=11),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Bill bi_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=bi_dic.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi_dic.Date)=$anio AND MONTH(bi_dic.Date)=12),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Bill bi
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=bi.ClientProductPurchaseRegistryId 
            WHERE YEAR(bi.Date)=$anio";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM Bill bi_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=bi_ene.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(bi_ene.Date)=$anio AND MONTH(bi_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%'),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM Bill bi_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=bi_feb.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(bi_feb.Date)=$anio AND MONTH(bi_feb.Date)=2 AND en_feb.Code LIKE '" . $empresa . "%'),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM Bill bi_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=bi_mar.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(bi_mar.Date)=$anio AND MONTH(bi_mar.Date)=3 AND en_mar.Code LIKE '" . $empresa . "%'),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM Bill bi_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=bi_abr.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(bi_abr.Date)=$anio AND MONTH(bi_abr.Date)=4 AND en_abr.Code LIKE '" . $empresa . "%'),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM Bill bi_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=bi_may.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(bi_may.Date)=$anio AND MONTH(bi_may.Date)=5 AND en_may.Code LIKE '" . $empresa . "%'),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM Bill bi_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=bi_jun.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(bi_jun.Date)=$anio AND MONTH(bi_jun.Date)=6 AND en_jun.Code LIKE '" . $empresa . "%'),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM Bill bi_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=bi_jul.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(bi_jul.Date)=$anio AND MONTH(bi_jul.Date)=7 AND en_jul.Code LIKE '" . $empresa . "%'),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM Bill bi_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=bi_ago.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(bi_ago.Date)=$anio AND MONTH(bi_ago.Date)=8 AND en_ago.Code LIKE '" . $empresa . "%'),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM Bill bi_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=bi_sep.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(bi_sep.Date)=$anio AND MONTH(bi_sep.Date)=9 AND en_sep.Code LIKE '" . $empresa . "%'),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM Bill bi_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=bi_oct.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(bi_oct.Date)=$anio AND MONTH(bi_oct.Date)=10 AND en_oct.Code LIKE '" . $empresa . "%'),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM Bill bi_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=bi_nov.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(bi_nov.Date)=$anio AND MONTH(bi_nov.Date)=11 AND en_nov.Code LIKE '" . $empresa . "%'),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM Bill bi_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=bi_dic.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(bi_dic.Date)=$anio AND MONTH(bi_dic.Date)=12 AND en_dic.Code LIKE '" . $empresa . "%'),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM Bill bi
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=bi.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(bi.Date)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function resumen_facturas_balance_oficial($empresa, $anio, $mes)
  {
    if ($empresa == "GL") {
      $parte = "";
    } else {
      $parte = "AND enterprise.Code LIKE '$empresa%'";
    }
    $sql = "SELECT 'Factura' as Tipo_Comprobante, iv.Date as Fecha_Doc, pst.Description as Estado_Pago, 
            ptt.Description as Tipo_Pago, concat(invs.Code, ' - 0000', iv.BillNumber) as Nro_Doc,
            per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId, 
            (Cost-ISNULL(TotalDiscount,0)) as Monto, pit.Name, cp.Description,invst.Description as Estado, 
            cp.SunatName as Razon_Social, cp.SunatRUC as RUC, cp.SunatAddress as Direccion
            FROM Bill iv
            LEFT JOIN BillSeries invs on invs.Id=iv.BillSeriesId
            LEFT JOIN BillStatusTranslation invst on invst.BillStatusId=iv.BillStatusId and invst.Language='es-PE'
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN ProductItem pit on pit.Id=cp.ProductItemId
            LEFT JOIN PaymentStatusTranslation pst on pst.PaymentStatusId=cp.PaymentStatusId
            LEFT JOIN PaymentTypeTranslation ptt on ptt.PaymentTypeId=cp.PaymentTypeId and ptt.Language='es-PE'
            LEFT JOIN Client cli ON cli.Id=cp.ClientId
            LEFT JOIN Person per ON per.Id=cli.PersonId
            LEFT JOIN EnterpriseHeadquarter enterprise ON enterprise.Id=cli.EnterpriseHeadquarterId
            WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$mes $parte
            ORDER BY iv.Date desc, iv.BillNumber desc, per.FatherSurname";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_notas_debito_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.PenaltyAmountPaid) FROM DebitNote dn_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=dn_ene.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_ene.Date)=$anio AND MONTH(dn_ene.Date)=1),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.PenaltyAmountPaid) FROM DebitNote dn_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=dn_feb.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_feb.Date)=$anio AND MONTH(dn_feb.Date)=2),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.PenaltyAmountPaid) FROM DebitNote dn_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=dn_mar.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_mar.Date)=$anio AND MONTH(dn_mar.Date)=3),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.PenaltyAmountPaid) FROM DebitNote dn_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=dn_abr.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_abr.Date)=$anio AND MONTH(dn_abr.Date)=4),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.PenaltyAmountPaid) FROM DebitNote dn_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=dn_may.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_may.Date)=$anio AND MONTH(dn_may.Date)=5),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.PenaltyAmountPaid) FROM DebitNote dn_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=dn_jun.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_jun.Date)=$anio AND MONTH(dn_jun.Date)=6),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.PenaltyAmountPaid) FROM DebitNote dn_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=dn_jul.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_jul.Date)=$anio AND MONTH(dn_jul.Date)=7),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.PenaltyAmountPaid) FROM DebitNote dn_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=dn_ago.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_ago.Date)=$anio AND MONTH(dn_ago.Date)=8),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.PenaltyAmountPaid) FROM DebitNote dn_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=dn_sep.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_sep.Date)=$anio AND MONTH(dn_sep.Date)=9),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.PenaltyAmountPaid) FROM DebitNote dn_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=dn_oct.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_oct.Date)=$anio AND MONTH(dn_oct.Date)=10),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.PenaltyAmountPaid) FROM DebitNote dn_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=dn_nov.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_nov.Date)=$anio AND MONTH(dn_nov.Date)=11),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.PenaltyAmountPaid) FROM DebitNote dn_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=dn_dic.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn_dic.Date)=$anio AND MONTH(dn_dic.Date)=12),0) AS Diciembre,
            SUM(cp.PenaltyAmountPaid) AS Total FROM DebitNote dn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=dn.ClientProductPurchaseRegistryId 
            WHERE YEAR(dn.Date)=$anio";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(cp_ene.PenaltyAmountPaid) FROM DebitNote dn_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=dn_ene.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(dn_ene.Date)=$anio AND MONTH(dn_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%'),0) AS Enero,
            ISNULL((SELECT SUM(cp_feb.PenaltyAmountPaid) FROM DebitNote dn_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=dn_feb.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(dn_feb.Date)=$anio AND MONTH(dn_feb.Date)=2 AND en_feb.Code LIKE '" . $empresa . "%'),0) AS Febrero,
            ISNULL((SELECT SUM(cp_mar.PenaltyAmountPaid) FROM DebitNote dn_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=dn_mar.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(dn_mar.Date)=$anio AND MONTH(dn_mar.Date)=3 AND en_mar.Code LIKE '" . $empresa . "%'),0) AS Marzo,
            ISNULL((SELECT SUM(cp_abr.PenaltyAmountPaid) FROM DebitNote dn_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=dn_abr.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(dn_abr.Date)=$anio AND MONTH(dn_abr.Date)=4 AND en_abr.Code LIKE '" . $empresa . "%'),0) AS Abril,
            ISNULL((SELECT SUM(cp_may.PenaltyAmountPaid) FROM DebitNote dn_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=dn_may.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(dn_may.Date)=$anio AND MONTH(dn_may.Date)=5 AND en_may.Code LIKE '" . $empresa . "%'),0) AS Mayo,
            ISNULL((SELECT SUM(cp_jun.PenaltyAmountPaid) FROM DebitNote dn_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=dn_jun.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(dn_jun.Date)=$anio AND MONTH(dn_jun.Date)=6 AND en_jun.Code LIKE '" . $empresa . "%'),0) AS Junio,
            ISNULL((SELECT SUM(cp_jul.PenaltyAmountPaid) FROM DebitNote dn_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=dn_jul.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(dn_jul.Date)=$anio AND MONTH(dn_jul.Date)=7 AND en_jul.Code LIKE '" . $empresa . "%'),0) AS Julio,
            ISNULL((SELECT SUM(cp_ago.PenaltyAmountPaid) FROM DebitNote dn_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=dn_ago.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(dn_ago.Date)=$anio AND MONTH(dn_ago.Date)=8 AND en_ago.Code LIKE '" . $empresa . "%'),0) AS Agosto,
            ISNULL((SELECT SUM(cp_sep.PenaltyAmountPaid) FROM DebitNote dn_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=dn_sep.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(dn_sep.Date)=$anio AND MONTH(dn_sep.Date)=9 AND en_sep.Code LIKE '" . $empresa . "%'),0) AS Septiembre,
            ISNULL((SELECT SUM(cp_oct.PenaltyAmountPaid) FROM DebitNote dn_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=dn_oct.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(dn_oct.Date)=$anio AND MONTH(dn_oct.Date)=10 AND en_oct.Code LIKE '" . $empresa . "%'),0) AS Octubre,
            ISNULL((SELECT SUM(cp_nov.PenaltyAmountPaid) FROM DebitNote dn_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=dn_nov.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(dn_nov.Date)=$anio AND MONTH(dn_nov.Date)=11 AND en_nov.Code LIKE '" . $empresa . "%'),0) AS Noviembre,
            ISNULL((SELECT SUM(cp_dic.PenaltyAmountPaid) FROM DebitNote dn_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=dn_dic.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(dn_dic.Date)=$anio AND MONTH(dn_dic.Date)=12 AND en_dic.Code LIKE '" . $empresa . "%'),0) AS Diciembre,
            SUM(cp.PenaltyAmountPaid) AS Total FROM DebitNote dn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=dn.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(dn.Date)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function resumen_notas_debito_balance_oficial($empresa, $anio, $mes)
  {
    /*
      if ($empresa == "GL") {
        $parte = "";
      } else {
        $parte = "AND en.Code LIKE '$empresa%'";
      }
      $sql = "SELECT 'Nota de Débito' AS Tipo_Comprobante,dn.Date AS Fecha_Doc,ptt.Description AS Tipo_Pago,
              per.FatherSurname, per.MotherSurname, per.FirstName, cl.InternalStudentId AS Codigo,
              pit.Name as Tipo, cp.Description, ISNULL(PenaltyAmountPaid,0) AS Monto,
              CONCAT(invs.Code, ' - 0000', dn.DebitNoteNumber) AS Nro_Doc,invst.Description as Estado,
              en.Name AS Empresa,cp.Id,CONCAT(invs.Code, ' - 0000',
              (CASE WHEN ISNULL(iv.InvoiceNumber, '')='' THEN bi.BillNumber ELSE iv.InvoiceNumber END)) AS Doc_Afect
              FROM DebitNote dn
              LEFT JOIN ClientProductPurchaseRegistry cp ON dn.ClientProductPurchaseRegistryId=cp.Id
              LEFT JOIN PaymentTypeTranslation ptt ON ptt.PaymentTypeId=cp.PaymentTypeId AND ptt.Language='es-PE'
              LEFT JOIN Client cl ON cp.ClientId=cl.Id
              LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
              LEFT JOIN Person per ON cl.PersonId=per.Id
              LEFT JOIN ProductItem pit ON cp.ProductItemId=pit.Id
              LEFT JOIN DebitNoteSeries invs ON dn.DebitNoteSeriesId=invs.Id
              LEFT JOIN DebitNoteStatusTranslation invst ON dn.DebitNoteStatusId=invst.DebitNoteStatusId AND invst.Language='es-PE'
              LEFT JOIN (SELECT ClientProductPurchaseRegistryId,InvoiceNumber FROM Invoice
              GROUP BY ClientProductPurchaseRegistryId,InvoiceNumber) iv ON dn.ClientProductPurchaseRegistryId=iv.ClientProductPurchaseRegistryId
              LEFT JOIN Bill bi ON dn.ClientProductPurchaseRegistryId=bi.ClientProductPurchaseRegistryId
              WHERE YEAR(dn.Date)=$anio AND MONTH(dn.Date)=$mes $parte
              ORDER BY dn.Date DESC, dn.DebitNoteNumber DESC, per.FatherSurname ASC";
    */
    if ($empresa == "GL") {
      $parte = "";
    } else {
      $parte = "AND enterprise.Code LIKE '$empresa%'";
    }
    $sql = "SELECT cp.Id, 'Nota de Débito' as Tipo_Comprobante, iv.Date as Fecha_Doc, ptt.Description as
              Tipo_Pago, per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId as Codigo,
              pit.Name as Tipo, cp.Description, ISNULL(PenaltyAmountPaid,0) as Monto, 
              concat(invs.Code, ' - 0000', iv.DebitNoteNumber) as Nro_Doc, invst.Description as Estado,
              enterprise.Name as Empresa, concat(invs.Code, ' - 0000', 
              (case when ISNULL(bol.InvoiceNumber, '')='' then fact.BillNumber else bol.InvoiceNumber end))
              as Doc_Afect
              FROM DebitNote iv
              LEFT JOIN DebitNoteSeries invs on invs.Id=iv.DebitNoteSeriesId
              LEFT JOIN DebitNoteStatusTranslation invst on invst.DebitNoteStatusId=iv.DebitNoteStatusId and invst.Language='es-PE'
              LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
              LEFT JOIN ProductItem pit on pit.Id=cp.ProductItemId
              LEFT JOIN PaymentStatusTranslation pst on pst.PaymentStatusId=cp.PaymentStatusId
              LEFT JOIN PaymentTypeTranslation ptt on ptt.PaymentTypeId=cp.PaymentTypeId and ptt.Language='es-PE'
              LEFT JOIN Client cli ON cli.Id=cp.ClientId
              LEFT JOIN Person per ON per.Id=cli.PersonId
              LEFT JOIN Invoice bol on bol.ClientProductPurchaseRegistryId=iv.ClientProductPurchaseRegistryId
              LEFT JOIN Bill fact on fact.ClientProductPurchaseRegistryId=iv.ClientProductPurchaseRegistryId
              LEFT JOIN EnterpriseHeadquarter enterprise ON enterprise.Id=cli.EnterpriseHeadquarterId
              WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$mes $parte
              ORDER BY iv.Date desc, iv.DebitNoteNumber desc, per.FatherSurname";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_notas_credito_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM CreditNote cn_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=cn_ene.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_ene.Date)=$anio AND MONTH(cn_ene.Date)=1 AND cn_ene.CreditNoteStatusId=1),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM CreditNote cn_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=cn_feb.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_feb.Date)=$anio AND MONTH(cn_feb.Date)=2 AND cn_feb.CreditNoteStatusId=1),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM CreditNote cn_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=cn_mar.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_mar.Date)=$anio AND MONTH(cn_mar.Date)=3 AND cn_mar.CreditNoteStatusId=1),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM CreditNote cn_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=cn_abr.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_abr.Date)=$anio AND MONTH(cn_abr.Date)=4 AND cn_abr.CreditNoteStatusId=1),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM CreditNote cn_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=cn_may.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_may.Date)=$anio AND MONTH(cn_may.Date)=5 AND cn_may.CreditNoteStatusId=1),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM CreditNote cn_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=cn_jun.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_jun.Date)=$anio AND MONTH(cn_jun.Date)=6 AND cn_jun.CreditNoteStatusId=1),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM CreditNote cn_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=cn_jul.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_jul.Date)=$anio AND MONTH(cn_jul.Date)=7 AND cn_jul.CreditNoteStatusId=1),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM CreditNote cn_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=cn_ago.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_ago.Date)=$anio AND MONTH(cn_ago.Date)=8 AND cn_ago.CreditNoteStatusId=1),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM CreditNote cn_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=cn_sep.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_sep.Date)=$anio AND MONTH(cn_sep.Date)=9 AND cn_sep.CreditNoteStatusId=1),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM CreditNote cn_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=cn_oct.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_oct.Date)=$anio AND MONTH(cn_oct.Date)=10 AND cn_oct.CreditNoteStatusId=1),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM CreditNote cn_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=cn_nov.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_nov.Date)=$anio AND MONTH(cn_nov.Date)=11 AND cn_nov.CreditNoteStatusId=1),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM CreditNote cn_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=cn_dic.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn_dic.Date)=$anio AND MONTH(cn_dic.Date)=12 AND cn_dic.CreditNoteStatusId=1),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM CreditNote cn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=cn.ClientProductPurchaseRegistryId 
            WHERE YEAR(cn.Date)=$anio AND cn.CreditNoteStatusId=1";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)) FROM CreditNote cn_ene
            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=cn_ene.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
            WHERE YEAR(cn_ene.Date)=$anio AND MONTH(cn_ene.Date)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND 
            cn_ene.CreditNoteStatusId=1),0) AS Enero,
            ISNULL((SELECT SUM(ISNULL(cp_feb.Cost,0)-ISNULL(cp_feb.TotalDiscount,0)) FROM CreditNote cn_feb
            LEFT JOIN ClientProductPurchaseRegistry cp_feb ON cp_feb.Id=cn_feb.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_feb ON cl_feb.Id=cp_feb.ClientId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=cl_feb.EnterpriseHeadquarterId
            WHERE YEAR(cn_feb.Date)=$anio AND MONTH(cn_feb.Date)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND 
            cn_feb.CreditNoteStatusId=1),0) AS Febrero,
            ISNULL((SELECT SUM(ISNULL(cp_mar.Cost,0)-ISNULL(cp_mar.TotalDiscount,0)) FROM CreditNote cn_mar
            LEFT JOIN ClientProductPurchaseRegistry cp_mar ON cp_mar.Id=cn_mar.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_mar ON cl_mar.Id=cp_mar.ClientId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=cl_mar.EnterpriseHeadquarterId
            WHERE YEAR(cn_mar.Date)=$anio AND MONTH(cn_mar.Date)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND 
            cn_mar.CreditNoteStatusId=1),0) AS Marzo,
            ISNULL((SELECT SUM(ISNULL(cp_abr.Cost,0)-ISNULL(cp_abr.TotalDiscount,0)) FROM CreditNote cn_abr
            LEFT JOIN ClientProductPurchaseRegistry cp_abr ON cp_abr.Id=cn_abr.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_abr ON cl_abr.Id=cp_abr.ClientId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=cl_abr.EnterpriseHeadquarterId
            WHERE YEAR(cn_abr.Date)=$anio AND MONTH(cn_abr.Date)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND 
            cn_abr.CreditNoteStatusId=1),0) AS Abril,
            ISNULL((SELECT SUM(ISNULL(cp_may.Cost,0)-ISNULL(cp_may.TotalDiscount,0)) FROM CreditNote cn_may
            LEFT JOIN ClientProductPurchaseRegistry cp_may ON cp_may.Id=cn_may.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_may ON cl_may.Id=cp_may.ClientId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=cl_may.EnterpriseHeadquarterId
            WHERE YEAR(cn_may.Date)=$anio AND MONTH(cn_may.Date)=5 AND en_may.Code LIKE '" . $empresa . "%' AND 
            cn_may.CreditNoteStatusId=1),0) AS Mayo,
            ISNULL((SELECT SUM(ISNULL(cp_jun.Cost,0)-ISNULL(cp_jun.TotalDiscount,0)) FROM CreditNote cn_jun
            LEFT JOIN ClientProductPurchaseRegistry cp_jun ON cp_jun.Id=cn_jun.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jun ON cl_jun.Id=cp_jun.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=cl_jun.EnterpriseHeadquarterId
            WHERE YEAR(cn_jun.Date)=$anio AND MONTH(cn_jun.Date)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND 
            cn_jun.CreditNoteStatusId=1),0) AS Junio,
            ISNULL((SELECT SUM(ISNULL(cp_jul.Cost,0)-ISNULL(cp_jul.TotalDiscount,0)) FROM CreditNote cn_jul
            LEFT JOIN ClientProductPurchaseRegistry cp_jul ON cp_jul.Id=cn_jul.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_jul ON cl_jul.Id=cp_jul.ClientId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=cl_jul.EnterpriseHeadquarterId
            WHERE YEAR(cn_jul.Date)=$anio AND MONTH(cn_jul.Date)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND 
            cn_jul.CreditNoteStatusId=1),0) AS Julio,
            ISNULL((SELECT SUM(ISNULL(cp_ago.Cost,0)-ISNULL(cp_ago.TotalDiscount,0)) FROM CreditNote cn_ago
            LEFT JOIN ClientProductPurchaseRegistry cp_ago ON cp_ago.Id=cn_ago.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_ago ON cl_ago.Id=cp_ago.ClientId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=cl_ago.EnterpriseHeadquarterId
            WHERE YEAR(cn_ago.Date)=$anio AND MONTH(cn_ago.Date)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND 
            cn_ago.CreditNoteStatusId=1),0) AS Agosto,
            ISNULL((SELECT SUM(ISNULL(cp_sep.Cost,0)-ISNULL(cp_sep.TotalDiscount,0)) FROM CreditNote cn_sep
            LEFT JOIN ClientProductPurchaseRegistry cp_sep ON cp_sep.Id=cn_sep.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_sep ON cl_sep.Id=cp_sep.ClientId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=cl_sep.EnterpriseHeadquarterId
            WHERE YEAR(cn_sep.Date)=$anio AND MONTH(cn_sep.Date)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND 
            cn_sep.CreditNoteStatusId=1),0) AS Septiembre,
            ISNULL((SELECT SUM(ISNULL(cp_oct.Cost,0)-ISNULL(cp_oct.TotalDiscount,0)) FROM CreditNote cn_oct
            LEFT JOIN ClientProductPurchaseRegistry cp_oct ON cp_oct.Id=cn_oct.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_oct ON cl_oct.Id=cp_oct.ClientId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=cl_oct.EnterpriseHeadquarterId
            WHERE YEAR(cn_oct.Date)=$anio AND MONTH(cn_oct.Date)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND 
            cn_oct.CreditNoteStatusId=1),0) AS Octubre,
            ISNULL((SELECT SUM(ISNULL(cp_nov.Cost,0)-ISNULL(cp_nov.TotalDiscount,0)) FROM CreditNote cn_nov
            LEFT JOIN ClientProductPurchaseRegistry cp_nov ON cp_nov.Id=cn_nov.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_nov ON cl_nov.Id=cp_nov.ClientId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=cl_nov.EnterpriseHeadquarterId
            WHERE YEAR(cn_nov.Date)=$anio AND MONTH(cn_nov.Date)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND 
            cn_nov.CreditNoteStatusId=1),0) AS Noviembre,
            ISNULL((SELECT SUM(ISNULL(cp_dic.Cost,0)-ISNULL(cp_dic.TotalDiscount,0)) FROM CreditNote cn_dic
            LEFT JOIN ClientProductPurchaseRegistry cp_dic ON cp_dic.Id=cn_dic.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl_dic ON cl_dic.Id=cp_dic.ClientId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=cl_dic.EnterpriseHeadquarterId
            WHERE YEAR(cn_dic.Date)=$anio AND MONTH(cn_dic.Date)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND 
            cn_dic.CreditNoteStatusId=1),0) AS Diciembre,
            SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)) AS Total FROM CreditNote cn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=cn.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(cn.Date)=$anio AND en.Code LIKE '" . $empresa . "%'";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function resumen_notas_credito_balance_oficial($empresa, $anio, $mes)
  {
    if ($empresa == "GL") {
      $parte = "";
    } else {
      $parte = "AND enterprise.Code LIKE '$empresa%'";
    }
    $sql = "SELECT cp.Id, 'Nota de Crédito' as Tipo_Comprobante, iv.Date as Fecha_Doc, ptt.Description as
              Tipo_Pago, per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId as Codigo,
              pit.Name as Tipo, cp.Description, (ISNULL(Cost,0)-ISNULL(TotalDiscount,0)) as Monto, 
              concat(invs.Code, ' - 0000', iv.CreditNoteNumber) as Nro_Doc, invst.Description as Estado,
              enterprise.Name as Empresa, concat(invs.Code, ' - 0000', 
              (case when ISNULL(bol.InvoiceNumber, '')='' then fact.BillNumber else bol.InvoiceNumber end))
              as Doc_Afect
              FROM CreditNote iv
              LEFT JOIN CreditNoteSeries invs on invs.Id=iv.CreditNoteSeriesId
              LEFT JOIN CreditNoteStatusTranslation invst on invst.CreditNoteStatusId=iv.CreditNoteStatusId and invst.Language='es-PE'
              LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
              LEFT JOIN ProductItem pit on pit.Id=cp.ProductItemId
              LEFT JOIN PaymentStatusTranslation pst on pst.PaymentStatusId=cp.PaymentStatusId
              LEFT JOIN PaymentTypeTranslation ptt on ptt.PaymentTypeId=cp.PaymentTypeId and ptt.Language='es-PE'
              LEFT JOIN Client cli ON cli.Id=cp.ClientId
              LEFT JOIN Person per ON per.Id=cli.PersonId
              LEFT JOIN Invoice bol on bol.ClientProductPurchaseRegistryId=iv.ClientProductPurchaseRegistryId
              LEFT JOIN Bill fact on fact.ClientProductPurchaseRegistryId=iv.ClientProductPurchaseRegistryId
              LEFT JOIN EnterpriseHeadquarter enterprise ON enterprise.Id=cli.EnterpriseHeadquarterId
              WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$mes $parte
              ORDER BY iv.Date desc, iv.CreditNoteNumber desc, per.FatherSurname";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_gastos_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT rt.Description,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=1 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Enero,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=2 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Febrero,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=3 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Marzo,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=4 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Abril,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=5 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Mayo,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=6 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Junio,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=7 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Julio,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=8 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Agosto,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=9 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Septiembre,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=10 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Octubre,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=11 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Noviembre,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE MONTH(AccountingDate)=12 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Diciembre,
            ISNULL((SELECT SUM(Amount) FROM AccountingPayment WHERE YEAR(AccountingDate)=$anio AND ReceiptTypeId=rt.ReceiptTypeId),0) AS Total
            FROM ReceiptTypeTranslation rt 
            WHERE rt.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12) ORDER BY rt.Description ASC";
    } else {
      $sql = "SELECT rt.Description,
            ISNULL((SELECT SUM(ap_ene.Amount) FROM AccountingPayment ap_ene 
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE MONTH(ap_ene.AccountingDate)=1 AND YEAR(ap_ene.AccountingDate)=$anio AND en_ene.Code LIKE '" . $empresa . "%' AND ap_ene.ReceiptTypeId=rt.ReceiptTypeId),0) AS Enero,
            ISNULL((SELECT SUM(ap_feb.Amount) FROM AccountingPayment ap_feb 
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE MONTH(ap_feb.AccountingDate)=2 AND YEAR(ap_feb.AccountingDate)=$anio AND en_feb.Code LIKE '" . $empresa . "%' AND ap_feb.ReceiptTypeId=rt.ReceiptTypeId),0) AS Febrero,
            ISNULL((SELECT SUM(ap_mar.Amount) FROM AccountingPayment ap_mar 
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE MONTH(ap_mar.AccountingDate)=3 AND YEAR(ap_mar.AccountingDate)=$anio AND en_mar.Code LIKE '" . $empresa . "%' AND ap_mar.ReceiptTypeId=rt.ReceiptTypeId),0) AS Marzo,
            ISNULL((SELECT SUM(ap_abr.Amount) FROM AccountingPayment ap_abr 
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE MONTH(ap_abr.AccountingDate)=4 AND YEAR(ap_abr.AccountingDate)=$anio AND en_abr.Code LIKE '" . $empresa . "%' AND ap_abr.ReceiptTypeId=rt.ReceiptTypeId),0) AS Abril,
            ISNULL((SELECT SUM(ap_may.Amount) FROM AccountingPayment ap_may 
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE MONTH(ap_may.AccountingDate)=5 AND YEAR(ap_may.AccountingDate)=$anio AND en_may.Code LIKE '" . $empresa . "%' AND ap_may.ReceiptTypeId=rt.ReceiptTypeId),0) AS Mayo,
            ISNULL((SELECT SUM(ap_jun.Amount) FROM AccountingPayment ap_jun 
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE MONTH(ap_jun.AccountingDate)=6 AND YEAR(ap_jun.AccountingDate)=$anio AND en_jun.Code LIKE '" . $empresa . "%' AND ap_jun.ReceiptTypeId=rt.ReceiptTypeId),0) AS Junio,
            ISNULL((SELECT SUM(ap_jul.Amount) FROM AccountingPayment ap_jul 
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE MONTH(ap_jul.AccountingDate)=7 AND YEAR(ap_jul.AccountingDate)=$anio AND en_jul.Code LIKE '" . $empresa . "%' AND ap_jul.ReceiptTypeId=rt.ReceiptTypeId),0) AS Julio,
            ISNULL((SELECT SUM(ap_ago.Amount) FROM AccountingPayment ap_ago 
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE MONTH(ap_ago.AccountingDate)=8 AND YEAR(ap_ago.AccountingDate)=$anio AND en_ago.Code LIKE '" . $empresa . "%' AND ap_ago.ReceiptTypeId=rt.ReceiptTypeId),0) AS Agosto,
            ISNULL((SELECT SUM(ap_sep.Amount) FROM AccountingPayment ap_sep 
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE MONTH(ap_sep.AccountingDate)=9 AND YEAR(ap_sep.AccountingDate)=$anio AND en_sep.Code LIKE '" . $empresa . "%' AND ap_sep.ReceiptTypeId=rt.ReceiptTypeId),0) AS Septiembre,
            ISNULL((SELECT SUM(ap_oct.Amount) FROM AccountingPayment ap_oct 
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE MONTH(ap_oct.AccountingDate)=10 AND YEAR(ap_oct.AccountingDate)=$anio AND en_oct.Code LIKE '" . $empresa . "%' AND ap_oct.ReceiptTypeId=rt.ReceiptTypeId),0) AS Octubre,
            ISNULL((SELECT SUM(ap_nov.Amount) FROM AccountingPayment ap_nov 
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE MONTH(ap_nov.AccountingDate)=11 AND YEAR(ap_nov.AccountingDate)=$anio AND en_nov.Code LIKE '" . $empresa . "%' AND ap_nov.ReceiptTypeId=rt.ReceiptTypeId),0) AS Noviembre,
            ISNULL((SELECT SUM(ap_dic.Amount) FROM AccountingPayment ap_dic 
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE MONTH(ap_dic.AccountingDate)=12 AND YEAR(ap_dic.AccountingDate)=$anio AND en_dic.Code LIKE '" . $empresa . "%' AND ap_dic.ReceiptTypeId=rt.ReceiptTypeId),0) AS Diciembre,
            ISNULL((SELECT SUM(ap.Amount) FROM AccountingPayment ap 
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(ap.AccountingDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ap.ReceiptTypeId=rt.ReceiptTypeId),0) AS Total
            FROM ReceiptTypeTranslation rt 
            WHERE rt.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12) ORDER BY rt.Description ASC";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_gastos_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(ap_ene.Amount) FROM AccountingPayment ap_ene
            LEFT JOIN ReceiptTypeTranslation rt_ene ON rt_ene.ReceiptTypeId=ap_ene.ReceiptTypeId
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND ap_ene.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Enero,
            ISNULL((SELECT SUM(ap_feb.Amount) FROM AccountingPayment ap_feb
            LEFT JOIN ReceiptTypeTranslation rt_feb ON rt_feb.ReceiptTypeId=ap_feb.ReceiptTypeId
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND ap_feb.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Febrero,
            ISNULL((SELECT SUM(ap_mar.Amount) FROM AccountingPayment ap_mar
            LEFT JOIN ReceiptTypeTranslation rt_mar ON rt_mar.ReceiptTypeId=ap_mar.ReceiptTypeId
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND ap_mar.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Marzo,
            ISNULL((SELECT SUM(ap_abr.Amount) FROM AccountingPayment ap_abr
            LEFT JOIN ReceiptTypeTranslation rt_abr ON rt_abr.ReceiptTypeId=ap_abr.ReceiptTypeId
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND ap_abr.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Abril,
            ISNULL((SELECT SUM(ap_may.Amount) FROM AccountingPayment ap_may
            LEFT JOIN ReceiptTypeTranslation rt_may ON rt_may.ReceiptTypeId=ap_may.ReceiptTypeId
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND ap_may.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Mayo,
            ISNULL((SELECT SUM(ap_jun.Amount) FROM AccountingPayment ap_jun
            LEFT JOIN ReceiptTypeTranslation rt_jun ON rt_jun.ReceiptTypeId=ap_jun.ReceiptTypeId
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND ap_jun.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Junio,
            ISNULL((SELECT SUM(ap_jul.Amount) FROM AccountingPayment ap_jul
            LEFT JOIN ReceiptTypeTranslation rt_jul ON rt_jul.ReceiptTypeId=ap_jul.ReceiptTypeId
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND ap_jul.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Julio,
            ISNULL((SELECT SUM(ap_ago.Amount) FROM AccountingPayment ap_ago
            LEFT JOIN ReceiptTypeTranslation rt_ago ON rt_ago.ReceiptTypeId=ap_ago.ReceiptTypeId
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND ap_ago.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Agosto,
            ISNULL((SELECT SUM(ap_sep.Amount) FROM AccountingPayment ap_sep
            LEFT JOIN ReceiptTypeTranslation rt_sep ON rt_sep.ReceiptTypeId=ap_sep.ReceiptTypeId
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND ap_sep.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Septiembre,
            ISNULL((SELECT SUM(ap_oct.Amount) FROM AccountingPayment ap_oct
            LEFT JOIN ReceiptTypeTranslation rt_oct ON rt_oct.ReceiptTypeId=ap_oct.ReceiptTypeId
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND ap_oct.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Octubre,
            ISNULL((SELECT SUM(ap_nov.Amount) FROM AccountingPayment ap_nov
            LEFT JOIN ReceiptTypeTranslation rt_nov ON rt_nov.ReceiptTypeId=ap_nov.ReceiptTypeId
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND ap_nov.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Noviembre,
            ISNULL((SELECT SUM(ap_dic.Amount) FROM AccountingPayment ap_dic
            LEFT JOIN ReceiptTypeTranslation rt_dic ON rt_dic.ReceiptTypeId=ap_dic.ReceiptTypeId
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND ap_dic.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Diciembre,
            ISNULL(SUM(ap.Amount),0) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN ReceiptTypeTranslation rt ON rt.ReceiptTypeId=ap.ReceiptTypeId
            WHERE YEAR(AccountingDate)=$anio AND ap.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ap_ene.Amount) FROM AccountingPayment ap_ene
            LEFT JOIN ReceiptTypeTranslation rt_ene ON rt_ene.ReceiptTypeId=ap_ene.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE YEAR(ap_ene.AccountingDate)=$anio AND MONTH(ap_ene.AccountingDate)=1 AND en_ene.Code LIKE '" . $empresa . "%' AND ap_ene.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Enero,
            ISNULL((SELECT SUM(ap_feb.Amount) FROM AccountingPayment ap_feb
            LEFT JOIN ReceiptTypeTranslation rt_feb ON rt_feb.ReceiptTypeId=ap_feb.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE YEAR(ap_feb.AccountingDate)=$anio AND MONTH(ap_feb.AccountingDate)=2 AND en_feb.Code LIKE '" . $empresa . "%' AND ap_feb.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Febrero,
            ISNULL((SELECT SUM(ap_mar.Amount) FROM AccountingPayment ap_mar
            LEFT JOIN ReceiptTypeTranslation rt_mar ON rt_mar.ReceiptTypeId=ap_mar.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE YEAR(ap_mar.AccountingDate)=$anio AND MONTH(ap_mar.AccountingDate)=3 AND en_mar.Code LIKE '" . $empresa . "%' AND ap_mar.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Marzo,
            ISNULL((SELECT SUM(ap_abr.Amount) FROM AccountingPayment ap_abr
            LEFT JOIN ReceiptTypeTranslation rt_abr ON rt_abr.ReceiptTypeId=ap_abr.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE YEAR(ap_abr.AccountingDate)=$anio AND MONTH(ap_abr.AccountingDate)=4 AND en_abr.Code LIKE '" . $empresa . "%' AND ap_abr.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Abril,
            ISNULL((SELECT SUM(ap_may.Amount) FROM AccountingPayment ap_may
            LEFT JOIN ReceiptTypeTranslation rt_may ON rt_may.ReceiptTypeId=ap_may.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE YEAR(ap_may.AccountingDate)=$anio AND MONTH(ap_may.AccountingDate)=5 AND en_may.Code LIKE '" . $empresa . "%' AND ap_may.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Mayo,
            ISNULL((SELECT SUM(ap_jun.Amount) FROM AccountingPayment ap_jun
            LEFT JOIN ReceiptTypeTranslation rt_jun ON rt_jun.ReceiptTypeId=ap_jun.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE YEAR(ap_jun.AccountingDate)=$anio AND MONTH(ap_jun.AccountingDate)=6 AND en_jun.Code LIKE '" . $empresa . "%' AND ap_jun.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Junio,
            ISNULL((SELECT SUM(ap_jul.Amount) FROM AccountingPayment ap_jul
            LEFT JOIN ReceiptTypeTranslation rt_jul ON rt_jul.ReceiptTypeId=ap_jul.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE YEAR(ap_jul.AccountingDate)=$anio AND MONTH(ap_jul.AccountingDate)=7 AND en_jul.Code LIKE '" . $empresa . "%' AND ap_jul.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Julio,
            ISNULL((SELECT SUM(ap_ago.Amount) FROM AccountingPayment ap_ago
            LEFT JOIN ReceiptTypeTranslation rt_ago ON rt_ago.ReceiptTypeId=ap_ago.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE YEAR(ap_ago.AccountingDate)=$anio AND MONTH(ap_ago.AccountingDate)=8 AND en_ago.Code LIKE '" . $empresa . "%' AND ap_ago.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Agosto,
            ISNULL((SELECT SUM(ap_sep.Amount) FROM AccountingPayment ap_sep
            LEFT JOIN ReceiptTypeTranslation rt_sep ON rt_sep.ReceiptTypeId=ap_sep.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE YEAR(ap_sep.AccountingDate)=$anio AND MONTH(ap_sep.AccountingDate)=9 AND en_sep.Code LIKE '" . $empresa . "%' AND ap_sep.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Septiembre,
            ISNULL((SELECT SUM(ap_oct.Amount) FROM AccountingPayment ap_oct
            LEFT JOIN ReceiptTypeTranslation rt_oct ON rt_oct.ReceiptTypeId=ap_oct.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE YEAR(ap_oct.AccountingDate)=$anio AND MONTH(ap_oct.AccountingDate)=10 AND en_oct.Code LIKE '" . $empresa . "%' AND ap_oct.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Octubre,
            ISNULL((SELECT SUM(ap_nov.Amount) FROM AccountingPayment ap_nov
            LEFT JOIN ReceiptTypeTranslation rt_nov ON rt_nov.ReceiptTypeId=ap_nov.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE YEAR(ap_nov.AccountingDate)=$anio AND MONTH(ap_nov.AccountingDate)=11 AND en_nov.Code LIKE '" . $empresa . "%' AND ap_nov.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Noviembre,
            ISNULL((SELECT SUM(ap_dic.Amount) FROM AccountingPayment ap_dic
            LEFT JOIN ReceiptTypeTranslation rt_dic ON rt_dic.ReceiptTypeId=ap_dic.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE YEAR(ap_dic.AccountingDate)=$anio AND MONTH(ap_dic.AccountingDate)=12 AND en_dic.Code LIKE '" . $empresa . "%' AND ap_dic.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)),0) AS Diciembre,
            ISNULL(SUM(ap.Amount),0) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN ReceiptTypeTranslation rt ON rt.ReceiptTypeId=ap.ReceiptTypeId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(AccountingDate)=$anio AND en.Code LIKE '" . $empresa . "%' AND ap.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12)";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function total_impuestos_balance_oficial($empresa, $anio)
  {
    if ($empresa == "GL") {
      $sql = "SELECT ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=1 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Enero,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=2 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Febrero,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=3 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Marzo,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=4 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Abril,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=5 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Mayo,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=6 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Junio,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=7 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Julio,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=8 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Agosto,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=9 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Septiembre,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=10 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Octubre,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=11 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Noviembre,
            ISNULL((SELECT SUM(Amount) AS Total FROM AccountingPayment 
            WHERE MONTH(AccountingDate)=12 AND YEAR(AccountingDate)=$anio AND ReceiptTypeId=13),0) AS Diciembre,
            ISNULL(SUM(Amount),0) AS Total 
            FROM AccountingPayment 
            WHERE YEAR(AccountingDate)=$anio AND ReceiptTypeId=13";
    } else {
      $sql = "SELECT ISNULL((SELECT SUM(ap_ene.Amount) AS Total FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE en_ene.Code LIKE '" . $empresa . "%' AND MONTH(ap_ene.AccountingDate)=1 AND YEAR(ap_ene.AccountingDate)=$anio AND ap_ene.ReceiptTypeId=13),0) AS Enero,
            ISNULL((SELECT SUM(ap_feb.Amount) AS Total FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE en_feb.Code LIKE '" . $empresa . "%' AND MONTH(ap_feb.AccountingDate)=2 AND YEAR(ap_feb.AccountingDate)=$anio AND ap_feb.ReceiptTypeId=13),0) AS Febrero,
            ISNULL((SELECT SUM(ap_mar.Amount) AS Total FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE en_mar.Code LIKE '" . $empresa . "%' AND MONTH(ap_mar.AccountingDate)=3 AND YEAR(ap_mar.AccountingDate)=$anio AND ap_mar.ReceiptTypeId=13),0) AS Marzo,
            ISNULL((SELECT SUM(ap_abr.Amount) AS Total FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE en_abr.Code LIKE '" . $empresa . "%' AND MONTH(ap_abr.AccountingDate)=4 AND YEAR(ap_abr.AccountingDate)=$anio AND ap_abr.ReceiptTypeId=13),0) AS Abril,
            ISNULL((SELECT SUM(ap_may.Amount) AS Total FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE en_may.Code LIKE '" . $empresa . "%' AND MONTH(ap_may.AccountingDate)=5 AND YEAR(ap_may.AccountingDate)=$anio AND ap_may.ReceiptTypeId=13),0) AS Mayo,
            ISNULL((SELECT SUM(ap_jun.Amount) AS Total FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE en_jun.Code LIKE '" . $empresa . "%' AND MONTH(ap_jun.AccountingDate)=6 AND YEAR(ap_jun.AccountingDate)=$anio AND ap_jun.ReceiptTypeId=13),0) AS Junio,
            ISNULL((SELECT SUM(ap_jul.Amount) AS Total FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE en_jul.Code LIKE '" . $empresa . "%' AND MONTH(ap_jul.AccountingDate)=7 AND YEAR(ap_jul.AccountingDate)=$anio AND ap_jul.ReceiptTypeId=13),0) AS Julio,
            ISNULL((SELECT SUM(ap_ago.Amount) AS Total FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE en_ago.Code LIKE '" . $empresa . "%' AND MONTH(ap_ago.AccountingDate)=8 AND YEAR(ap_ago.AccountingDate)=$anio AND ap_ago.ReceiptTypeId=13),0) AS Agosto,
            ISNULL((SELECT SUM(ap_sep.Amount) AS Total FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE en_sep.Code LIKE '" . $empresa . "%' AND MONTH(ap_sep.AccountingDate)=9 AND YEAR(ap_sep.AccountingDate)=$anio AND ap_sep.ReceiptTypeId=13),0) AS Septiembre,
            ISNULL((SELECT SUM(ap_oct.Amount) AS Total FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE en_oct.Code LIKE '" . $empresa . "%' AND MONTH(ap_oct.AccountingDate)=10 AND YEAR(ap_oct.AccountingDate)=$anio AND ap_oct.ReceiptTypeId=13),0) AS Octubre,
            ISNULL((SELECT SUM(ap_nov.Amount) AS Total FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE en_nov.Code LIKE '" . $empresa . "%' AND MONTH(ap_nov.AccountingDate)=11 AND YEAR(ap_nov.AccountingDate)=$anio AND ap_nov.ReceiptTypeId=13),0) AS Noviembre,
            ISNULL((SELECT SUM(ap_dic.Amount) AS Total FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE en_dic.Code LIKE '" . $empresa . "%' AND MONTH(ap_dic.AccountingDate)=12 AND YEAR(ap_dic.AccountingDate)=$anio AND ap_dic.ReceiptTypeId=13),0) AS Diciembre,
            ISNULL(SUM(ap.Amount),0) AS Total 
            FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE en.Code LIKE '" . $empresa . "%' AND YEAR(ap.AccountingDate)=$anio AND ap.ReceiptTypeId=13";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }
  //------------------------------RUBROS-------------------------------
  function get_list_rubro()
  {
    $sql = "SELECT ct.Id,ct.Name,st.Description FROM CostType ct
            LEFT JOIN StatusTranslation st ON st.StatusId=ct.StatusId
            WHERE ISNUMERIC(ct.ParentCostTypeId)=0 AND ct.StatusId=0 ORDER BY ct.Name ASC";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }
  //------------------------------SUBRUBROS-------------------------------
  function get_list_estado_sql()
  {
    $sql = "SELECT * FROM StatusTranslation";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_id_subrubro($id_subrubro = null)
  {
    if (isset($id_subrubro) && $id_subrubro > 0) {
      $sql = "SELECT * FROM subrubro WHERE id_subrubro=$id_subrubro";
    } else {
      $sql = "SELECT id_subrubro,id_empresa,id_tipo_documento,obliga_documento,informe,ruc,obliga_datos FROM subrubro WHERE estado=2";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_subrubro($id_subrubro = null)
  {
    if (isset($id_subrubro) && $id_subrubro > 0) {
      $sql = "SELECT * FROM CostType WHERE Id=$id_subrubro";
    } else {
      $sql = "SELECT co.Id,ct.Name AS Rubro,co.Name,st.Description FROM CostType co
              LEFT JOIN CostType ct ON ct.Id=co.ParentCostTypeId
              LEFT JOIN StatusTranslation st ON st.StatusId=co.StatusId
              WHERE ISNUMERIC(ct.ParentCostTypeId)=0 AND ct.StatusId=0 ORDER BY ct.Name ASC";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_tipo_documento()
  {
    $sql = "SELECT * FROM ReceiptTypeTranslation WHERE ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) ORDER BY Description ASC";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_subrubro()
  {
    $sql = "SELECT * FROM empresa WHERE estado=2 AND cd_empresa!='' ORDER BY cd_empresa ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_subrubro($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO subrubro (id_subrubro,id_empresa,id_tipo_documento,obliga_documento,informe,obliga_datos,ruc,estado,fec_reg,user_reg)
          VALUES ('" . $dato['id'] . "','" . $dato['id_empresa'] . "','" . $dato['id_tipo_documento'] . "','" . $dato['obliga_documento'] . "',
          '" . $dato['informe'] . "','" . $dato['obliga_datos'] . "','" . $dato['ruc'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_subrubro($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE subrubro SET id_empresa='" . $dato['id_empresa'] . "',id_tipo_documento='" . $dato['id_tipo_documento'] . "',
          obliga_documento='" . $dato['obliga_documento'] . "',informe='" . $dato['informe'] . "',obliga_datos='" . $dato['obliga_datos'] . "',ruc='" . $dato['ruc'] . "',
          fec_act=NOW(),user_act=$id_usuario
          WHERE id_subrubro='" . $dato['id_subrubro'] . "'";
    $this->db->query($sql);
  }
  //--------------------------------GASTOS--------------------------------
  function get_list_gastos_sunat($Id, $tipo, $anio)
  {
    if (isset($Id) && $Id > 0) {
      $sql = "SELECT ga.*,CASE WHEN MONTH(ga.Mes_Anio)=1 THEN CONCAT('ene-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=2 THEN CONCAT('feb-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=3 THEN 
            CONCAT('mar-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=4 THEN CONCAT('abr-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=5 THEN CONCAT('may-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=6 THEN 
            CONCAT('jun-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=7 THEN CONCAT('jul-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=8 THEN CONCAT('ago-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=9 THEN 
            CONCAT('set-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=10 THEN CONCAT('oct-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=11 THEN CONCAT('nov-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=12 THEN 
            CONCAT('dic-',YEAR(ga.Mes_Anio)) ELSE '' END AS Mes_Anio_Doc
            FROM gastos_sunat_arpay ga
            WHERE ga.Id=$Id";
    } else {
      $parte = "";
      if ($tipo == 1) {
        $parte = "AND ga.CostTypeId NOT IN (71,121) AND ((su.obliga_documento=1 AND 
                  (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE gs.documento END)='') OR 
                  (su.obliga_datos=1 AND ((CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
                  (CASE WHEN gs.fecha_pago='0000-00-00' THEN '' ELSE DATE_FORMAT(gs.fecha_pago,'%d-%m-%Y') END) END)='' OR 
                  (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
                  (CASE WHEN ga.Ruc_Proveedor!='' THEN ga.Ruc_Proveedor WHEN su.ruc!='' THEN su.ruc WHEN gs.ruc_beneficiario!='' 
                  THEN gs.ruc_beneficiario ELSE '' END) END)='')))";
      }
      $sql = "SELECT ga.Fecha_Documento AS Fecha_Orden,em.cd_empresa AS Empresa,
              CASE WHEN MONTH(ga.Mes_Anio)=1 THEN CONCAT('ene-',YEAR(ga.Mes_Anio))
              WHEN MONTH(ga.Mes_Anio)=2 THEN CONCAT('feb-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=3 THEN 
              CONCAT('mar-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=4 THEN CONCAT('abr-',YEAR(ga.Mes_Anio))
              WHEN MONTH(ga.Mes_Anio)=5 THEN CONCAT('may-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=6 THEN 
              CONCAT('jun-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=7 THEN CONCAT('jul-',YEAR(ga.Mes_Anio))
              WHEN MONTH(ga.Mes_Anio)=8 THEN CONCAT('ago-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=9 THEN 
              CONCAT('set-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=10 THEN CONCAT('oct-',YEAR(ga.Mes_Anio))
              WHEN MONTH(ga.Mes_Anio)=11 THEN CONCAT('nov-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=12 THEN 
              CONCAT('dic-',YEAR(ga.Mes_Anio)) ELSE '' END AS Mes_Anio,ga.Tipo_Pago,ga.Pedido,ga.Rubro,ga.Subrubro,
              ga.Descripcion,DATE_FORMAT(ga.Fecha_Documento,'%d-%m-%Y') AS Fecha_Emision,
              CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
              (CASE WHEN gs.fecha_pago='0000-00-00' THEN '' ELSE DATE_FORMAT(gs.fecha_pago,'%d-%m-%Y') END) END AS Fecha_Pago,
              DATE_FORMAT(ga.Fecha_Creacion,'%d-%m-%Y') AS Fecha_Arpay,ga.Operacion,ga.Monto,ga.Tipo_Documento,
              gs.documento AS Documento,ga.Id,ga.CostTypeId,su.obliga_documento,su.obliga_datos,
              CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
              (CASE WHEN ga.Ruc_Proveedor!='' THEN ga.Ruc_Proveedor WHEN su.ruc!='' THEN su.ruc WHEN gs.ruc_beneficiario 
              THEN gs.ruc_beneficiario ELSE '' END) END AS Ruc_Beneficiario
              FROM gastos_sunat_arpay ga
              LEFT JOIN empresa em ON em.cod_empresa=SUBSTRING(ga.Cod_Empresa_Factura,1,2)
              LEFT JOIN gastos_sunat gs ON gs.id_gasto=ga.Id
              LEFT JOIN subrubro su ON su.id_subrubro=ga.CostTypeId
              WHERE YEAR(ga.Fecha_Entrega)=$anio $parte
              ORDER BY ga.Fecha_Documento ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_ruc_beneficiario()
  {
    $sql = "SELECT * FROM supplier_arpay 
            WHERE Id IN (76,82,97)";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_gastos_sunat($id_gasto = null)
  {
    if (isset($id_gasto) && $id_gasto > 0) {
      $sql = "SELECT * FROM gastos_sunat WHERE id_gasto=$id_gasto";
    } else {
      $sql = "SELECT *,DATE_FORMAT(fecha_pago,'%d-%m-%Y') AS fec_pago,DATE_FORMAT(fec_reg,'%d-%m-%Y') AS Fecha_Snappy 
              FROM gastos_sunat 
              WHERE estado=2";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_subrubro($id_subrubro)
  {
    $sql = "SELECT * FROM subrubro WHERE id_subrubro=$id_subrubro";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_gastos_sunat($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO gastos_sunat (id_gasto,fecha_pago,ruc_beneficiario,documento,validar_documento,no_declarado,
          estado,fec_reg,user_reg)
          VALUES ('" . $dato['id'] . "','" . $dato['fecha_pago'] . "','" . $dato['ruc_beneficiario'] . "','" . $dato['documento'] . "',
          '" . $dato['validar_documento'] . "','" . $dato['no_declarado'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_gastos_sunat($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE gastos_sunat SET fecha_pago='" . $dato['fecha_pago'] . "',ruc_beneficiario='" . $dato['ruc_beneficiario'] . "',
          documento='" . $dato['documento'] . "',validar_documento='" . $dato['validar_documento'] . "',
          no_declarado='" . $dato['no_declarado'] . "',fec_act=NOW(),user_act=$id_usuario
          WHERE id_gasto='" . $dato['id_gasto'] . "'";
    $this->db->query($sql);
  }

  function excel_gastos_sunat($tipo, $anio)
  {
    $parte = "";
    if ($tipo == 1) {
      $parte = "AND ga.CostTypeId NOT IN (71,121) AND ((su.obliga_documento=1 AND 
                (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE gs.documento END)='') OR 
                (su.obliga_datos=1 AND ((CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
                (CASE WHEN gs.fecha_pago='0000-00-00' THEN '' ELSE DATE_FORMAT(gs.fecha_pago,'%d-%m-%Y') END) END)='' OR 
                (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
                (CASE WHEN ga.Ruc_Proveedor!='' THEN ga.Ruc_Proveedor WHEN su.ruc!='' THEN su.ruc WHEN gs.ruc_beneficiario 
                THEN gs.ruc_beneficiario ELSE '' END) END)='')))";
    }
    $sql = "SELECT ga.Id,CASE WHEN MONTH(ga.Mes_Anio)=1 THEN CONCAT('ene-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=2 THEN CONCAT('feb-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=3 THEN 
            CONCAT('mar-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=4 THEN CONCAT('abr-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=5 THEN CONCAT('may-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=6 THEN 
            CONCAT('jun-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=7 THEN CONCAT('jul-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=8 THEN CONCAT('ago-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=9 THEN 
            CONCAT('set-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=10 THEN CONCAT('oct-',YEAR(ga.Mes_Anio))
            WHEN MONTH(ga.Mes_Anio)=11 THEN CONCAT('nov-',YEAR(ga.Mes_Anio)) WHEN MONTH(ga.Mes_Anio)=12 THEN 
            CONCAT('dic-',YEAR(ga.Mes_Anio)) ELSE '' END AS Mes_Anio,ga.Pedido,ga.Tipo,ga.Empresa_Factura,
            ga.Gasto_Empresa,ga.Rubro,ga.Subrubro,ga.Descripcion,ga.Monto,ga.Tipo_Solicitante,ga.Solicitante,
            ga.Estado,ga.Aprobado_Por,ga.Fecha_Entrega,ga.Tipo_Documento,ga.Fecha_Documento,ga.Numero_Recibo,
            ga.Tipo_Pago,ga.Cuenta_Bancaria,CASE WHEN gs.documento!='' THEN 'Si'
            ELSE 'No' END AS Documento,ga.Caja,ga.Sin_Contabilizar,ga.Total_Asignado,ga.Centro_Costo,
            ga.Revisado,ga.Gasto_Deducible,ga.Empresa,ga.CostTypeId,su.obliga_documento,su.obliga_datos,
            CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
            (CASE WHEN gs.fecha_pago='0000-00-00' THEN '' ELSE DATE_FORMAT(gs.fecha_pago,'%d-%m-%Y') END) END AS Fecha_Pago,
            CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
            (CASE WHEN ga.Ruc_Proveedor!='' THEN ga.Ruc_Proveedor WHEN su.ruc!='' THEN su.ruc WHEN gs.ruc_beneficiario 
            THEN gs.ruc_beneficiario ELSE '' END) END AS Ruc_Beneficiario,CASE WHEN gs.no_declarado=1 THEN 'No' 
            ELSE 'Si' END AS v_no_declarado
            FROM gastos_sunat_arpay ga
            LEFT JOIN gastos_sunat gs ON gs.id_gasto=ga.Id
            LEFT JOIN subrubro su ON su.id_subrubro=ga.CostTypeId
            WHERE YEAR(ga.Fecha_Entrega)=$anio $parte
            ORDER BY ga.Fecha_Documento ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_cantidad_gastos_sunat_pendientes()
  {
    $sql = "SELECT COUNT(*) AS cantidad 
            FROM gastos_sunat_arpay ga
            LEFT JOIN empresa em ON em.cod_empresa=SUBSTRING(ga.Empresa_Factura,1,2)
            LEFT JOIN gastos_sunat gs ON gs.id_gasto=ga.Id
            LEFT JOIN subrubro su ON su.id_subrubro=ga.CostTypeId
            WHERE ga.CostTypeId NOT IN (71,121) AND ((su.obliga_documento=1 AND 
            (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE gs.documento END)='') OR 
            (su.obliga_datos=1 AND ((CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
            (CASE WHEN gs.fecha_pago='0000-00-00' THEN '' ELSE DATE_FORMAT(gs.fecha_pago,'%d-%m-%Y') END) END)='' OR 
            (CASE WHEN (SELECT COUNT(*) FROM gastos_sunat gu WHERE gu.id_gasto=ga.Id)=0 THEN '' ELSE 
            (CASE WHEN ga.Ruc_Proveedor!='' THEN ga.Ruc_Proveedor WHEN su.ruc!='' THEN su.ruc WHEN gs.ruc_beneficiario 
            THEN gs.ruc_beneficiario ELSE '' END) END)='')))
            ORDER BY ga.Fecha_Documento ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  //-------------------------INFORME GASTOS--------------------------------
  function combo_empresa_con_ruc()
  {
    $sql = "SELECT * FROM empresa WHERE estado=2 AND cd_empresa!='' ORDER BY cd_empresa ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_subrubro_informe_sunat($id_empresa)
  {
    $sql = "SELECT * FROM subrubro WHERE estado=2 AND informe=1 AND (id_empresa LIKE '%,$id_empresa,%' OR id_empresa LIKE '$id_empresa,%' OR 
            id_empresa LIKE '%,$id_empresa' OR id_empresa=$id_empresa)";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_informe_gastos_sunat($dato)
  {
    /*$sql = "SELECT co.Id,cs.Name AS Rubro,co.Name AS Subrubro,
            (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterId
            WHERE MONTH(ap_ene.ReceiptDate)=1 AND YEAR(ap_ene.ReceiptDate)='".$dato['nom_anio']."' AND ap_ene.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_ene.Code LIKE '".$dato['cod_empresa']."%' AND ap_ene.CostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterId
            WHERE MONTH(ap_feb.ReceiptDate)=2 AND YEAR(ap_feb.ReceiptDate)='".$dato['nom_anio']."' AND ap_feb.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_feb.Code LIKE '".$dato['cod_empresa']."%' AND ap_feb.CostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterId
            WHERE MONTH(ap_mar.ReceiptDate)=3 AND YEAR(ap_mar.ReceiptDate)='".$dato['nom_anio']."' AND ap_mar.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_mar.Code LIKE '".$dato['cod_empresa']."%' AND ap_mar.CostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterId
            WHERE MONTH(ap_abr.ReceiptDate)=4 AND YEAR(ap_abr.ReceiptDate)='".$dato['nom_anio']."' AND ap_abr.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_abr.Code LIKE '".$dato['cod_empresa']."%' AND ap_abr.CostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterId
            WHERE MONTH(ap_may.ReceiptDate)=5 AND YEAR(ap_may.ReceiptDate)='".$dato['nom_anio']."' AND ap_may.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_may.Code LIKE '".$dato['cod_empresa']."%' AND ap_may.CostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterId
            WHERE MONTH(ap_jun.ReceiptDate)=6 AND YEAR(ap_jun.ReceiptDate)='".$dato['nom_anio']."' AND ap_jun.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_jun.Code LIKE '".$dato['cod_empresa']."%' AND ap_jun.CostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterId
            WHERE MONTH(ap_jul.ReceiptDate)=7 AND YEAR(ap_jul.ReceiptDate)='".$dato['nom_anio']."' AND ap_jul.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_jul.Code LIKE '".$dato['cod_empresa']."%' AND ap_jul.CostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterId
            WHERE MONTH(ap_ago.ReceiptDate)=8 AND YEAR(ap_ago.ReceiptDate)='".$dato['nom_anio']."' AND ap_ago.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_ago.Code LIKE '".$dato['cod_empresa']."%' AND ap_ago.CostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterId
            WHERE MONTH(ap_sep.ReceiptDate)=9 AND YEAR(ap_sep.ReceiptDate)='".$dato['nom_anio']."' AND ap_sep.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_sep.Code LIKE '".$dato['cod_empresa']."%' AND ap_sep.CostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterId
            WHERE MONTH(ap_oct.ReceiptDate)=10 AND YEAR(ap_oct.ReceiptDate)='".$dato['nom_anio']."' AND ap_oct.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_oct.Code LIKE '".$dato['cod_empresa']."%' AND ap_oct.CostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterId
            WHERE MONTH(ap_nov.ReceiptDate)=11 AND YEAR(ap_nov.ReceiptDate)='".$dato['nom_anio']."' AND ap_nov.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_nov.Code LIKE '".$dato['cod_empresa']."%' AND ap_nov.CostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterId
            WHERE MONTH(ap_dic.ReceiptDate)=12 AND YEAR(ap_dic.ReceiptDate)='".$dato['nom_anio']."' AND ap_dic.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_dic.Code LIKE '".$dato['cod_empresa']."%' AND ap_dic.CostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE YEAR(ap.ReceiptDate)='".$dato['nom_anio']."' AND ap.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND en.Code LIKE '".$dato['cod_empresa']."%' AND 
            ap.CostTypeId=co.Id) AS Total
            FROM CostType co
            LEFT JOIN CostType cs ON cs.Id=co.ParentCostTypeId
            WHERE co.Id IN (".$dato['consulta_subrubro'].") ORDER BY cs.Name ASC,co.Name ASC";*/
    $sql = "SELECT co.Id,cs.Name AS Rubro,co.Name AS Subrubro,
            (SELECT ISNULL(SUM(ap_ene.Amount),0) FROM AccountingPayment ap_ene
            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=ap_ene.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_ene.AccountingDate)=1 AND YEAR(ap_ene.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_ene.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_ene.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_ene.CostTypeId=co.Id) AS Enero,
            (SELECT ISNULL(SUM(ap_feb.Amount),0) FROM AccountingPayment ap_feb
            LEFT JOIN EnterpriseHeadquarter en_feb ON en_feb.Id=ap_feb.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_feb.AccountingDate)=2 AND YEAR(ap_feb.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_feb.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_feb.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_feb.CostTypeId=co.Id) AS Febrero,
            (SELECT ISNULL(SUM(ap_mar.Amount),0) FROM AccountingPayment ap_mar
            LEFT JOIN EnterpriseHeadquarter en_mar ON en_mar.Id=ap_mar.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_mar.AccountingDate)=3 AND YEAR(ap_mar.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_mar.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_mar.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_mar.CostTypeId=co.Id) AS Marzo,
            (SELECT ISNULL(SUM(ap_abr.Amount),0) FROM AccountingPayment ap_abr
            LEFT JOIN EnterpriseHeadquarter en_abr ON en_abr.Id=ap_abr.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_abr.AccountingDate)=4 AND YEAR(ap_abr.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_abr.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_abr.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_abr.CostTypeId=co.Id) AS Abril,
            (SELECT ISNULL(SUM(ap_may.Amount),0) FROM AccountingPayment ap_may
            LEFT JOIN EnterpriseHeadquarter en_may ON en_may.Id=ap_may.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_may.AccountingDate)=5 AND YEAR(ap_may.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_may.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_may.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_may.CostTypeId=co.Id) AS Mayo,
            (SELECT ISNULL(SUM(ap_jun.Amount),0) FROM AccountingPayment ap_jun
            LEFT JOIN EnterpriseHeadquarter en_jun ON en_jun.Id=ap_jun.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_jun.AccountingDate)=6 AND YEAR(ap_jun.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_jun.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_jun.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_jun.CostTypeId=co.Id) AS Junio,
            (SELECT ISNULL(SUM(ap_jul.Amount),0) FROM AccountingPayment ap_jul
            LEFT JOIN EnterpriseHeadquarter en_jul ON en_jul.Id=ap_jul.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_jul.AccountingDate)=7 AND YEAR(ap_jul.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_jul.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_jul.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_jul.CostTypeId=co.Id) AS Julio,
            (SELECT ISNULL(SUM(ap_ago.Amount),0) FROM AccountingPayment ap_ago
            LEFT JOIN EnterpriseHeadquarter en_ago ON en_ago.Id=ap_ago.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_ago.AccountingDate)=8 AND YEAR(ap_ago.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_ago.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_ago.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_ago.CostTypeId=co.Id) AS Agosto,
            (SELECT ISNULL(SUM(ap_sep.Amount),0) FROM AccountingPayment ap_sep
            LEFT JOIN EnterpriseHeadquarter en_sep ON en_sep.Id=ap_sep.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_sep.AccountingDate)=9 AND YEAR(ap_sep.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_sep.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_sep.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_sep.CostTypeId=co.Id) AS Septiembre,
            (SELECT ISNULL(SUM(ap_oct.Amount),0) FROM AccountingPayment ap_oct
            LEFT JOIN EnterpriseHeadquarter en_oct ON en_oct.Id=ap_oct.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_oct.AccountingDate)=10 AND YEAR(ap_oct.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_oct.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_oct.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_oct.CostTypeId=co.Id) AS Octubre,
            (SELECT ISNULL(SUM(ap_nov.Amount),0) FROM AccountingPayment ap_nov
            LEFT JOIN EnterpriseHeadquarter en_nov ON en_nov.Id=ap_nov.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_nov.AccountingDate)=11 AND YEAR(ap_nov.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_nov.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_nov.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_nov.CostTypeId=co.Id) AS Noviembre,
            (SELECT ISNULL(SUM(ap_dic.Amount),0) FROM AccountingPayment ap_dic
            LEFT JOIN EnterpriseHeadquarter en_dic ON en_dic.Id=ap_dic.EnterpriseHeadquarterIdInvoiceName
            WHERE MONTH(ap_dic.AccountingDate)=12 AND YEAR(ap_dic.AccountingDate)='" . $dato['nom_anio'] . "' AND ap_dic.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND 
            en_dic.Code LIKE '" . $dato['cod_empresa'] . "%' AND ap_dic.CostTypeId=co.Id) AS Diciembre,
            (SELECT ISNULL(SUM(ap.Amount),0) FROM AccountingPayment ap
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterIdInvoiceName
            WHERE YEAR(ap.AccountingDate)='" . $dato['nom_anio'] . "' AND ap.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND en.Code LIKE '" . $dato['cod_empresa'] . "%' AND 
            ap.CostTypeId=co.Id) AS Total
            FROM CostType co
            LEFT JOIN CostType cs ON cs.Id=co.ParentCostTypeId
            WHERE co.Id IN (" . $dato['consulta_subrubro'] . ") ORDER BY cs.Name ASC,co.Name ASC";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_empresa_sunat()
  {
    $sql = "SELECT * FROM empresa WHERE estado=2 AND cd_empresa!='' AND rep_sunat=1 ORDER BY cd_empresa ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_boletas_cobradas($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)),0) AS total 
            FROM Invoice iv
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$id_mes AND cp.PaymentStatusId=1 AND 
            en.Code LIKE '$cod_empresa%'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_boletas_por_cobrar($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)),0) AS total 
              FROM Invoice iv
              LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=iv.ClientProductPurchaseRegistryId
              LEFT JOIN Client cl ON cl.Id=cp.ClientId
              LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
              WHERE YEAR(iv.Date)=$anio AND MONTH(iv.Date)=$id_mes AND cp.PaymentStatusId=2 AND 
              en.Code LIKE '$cod_empresa%'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_facturas($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)),0) AS total 
            FROM Bill bi
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=bi.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(bi.Date)=$anio AND MONTH(bi.Date)=$id_mes AND en.Code LIKE '$cod_empresa%'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_notas_debito($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(cp.PenaltyAmountPaid),0) AS total 
            FROM DebitNote dn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=dn.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(dn.Date)=$anio AND MONTH(dn.Date)=$id_mes AND en.Code LIKE '$cod_empresa%'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_notas_credito($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp.Cost,0)-ISNULL(cp.TotalDiscount,0)),0) AS total 
            FROM CreditNote cn
            LEFT JOIN ClientProductPurchaseRegistry cp ON cp.Id=cn.ClientProductPurchaseRegistryId 
            LEFT JOIN Client cl ON cl.Id=cp.ClientId
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=cl.EnterpriseHeadquarterId
            WHERE YEAR(cn.Date)=$anio AND MONTH(cn.Date)=$id_mes AND cn.CreditNoteStatusId=1 AND 
            en.Code LIKE '$cod_empresa%'";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_informe_sunat_list_gastos($cod_empresa, $id_mes, $anio)
  {
    $sql = "SELECT rt.Description,
            (SELECT COUNT(*) FROM AccountingPayment ap 
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE MONTH(ap.AccountingDate)=$id_mes AND YEAR(ap.AccountingDate)=$anio AND 
            en.Code LIKE '$cod_empresa%' AND ap.ReceiptTypeId=rt.ReceiptTypeId) AS cantidad,
            ISNULL((SELECT SUM(ap.Amount) FROM AccountingPayment ap 
            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
            WHERE MONTH(ap.AccountingDate)=$id_mes AND YEAR(ap.AccountingDate)=$anio AND 
            en.Code LIKE '$cod_empresa%' AND ap.ReceiptTypeId=rt.ReceiptTypeId),0) AS monto
            FROM ReceiptTypeTranslation rt
            WHERE rt.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) 
            ORDER BY rt.Description ASC";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }
  //--------------------------------------------BASE DE DATOS ALUMNOS------------------------------------------
  function list_empresa_informebd()
  {
    $sql = "SELECT s.id_sede,s.id_empresa,e.cod_empresa,e.color 
    from sede s 
    LEFT JOIN empresa e on e.id_empresa=s.id_empresa 
    where s.b_datos=1 and s.estado=2 GROUP by s.id_empresa ORDER BY e.cod_empresa ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_sede_informebd()
  {
    $sql = "SELECT s.id_sede,s.cod_sede,s.id_empresa,e.cod_empresa,e.color,
    (SELECT COUNT(*) FROM alumnos_arpay a WHERE a.asignado=1 and a.id_sede=s.id_sede and a.estado=2) as asignados,
    ((select count(*) from alumnos_arpay_temporal t where t.sede=s.id_sede and t.estado=2)-(SELECT COUNT(*) FROM alumnos_arpay a WHERE a.asignado=1 and a.id_sede=s.id_sede and a.estado=2)) as sin_asignar
    FROM sede s
    LEFT JOIN empresa e on e.id_empresa=s.id_empresa 
    WHERE s.b_datos=1 and s.estado=2 ORDER BY s.cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_sede_activos()
  {
    $sql = "SELECT group_concat(distinct id_sede) as cadena FROM sede WHERE estado=2 and b_datos=1 ORDER BY cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }


  function list_alumno_bd($empresa)
  {

    $sql = "exec GetReportDatabase $empresa";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function list_alumno_temporal($dato)
  {
    $sql = "SELECT a.*,s.cod_sede FROM alumnos_arpay_temporal a 
    LEFT JOIN sede s on a.sede=s.id_sede
    WHERE a.estado=2 and (select count(*) from alumnos_arpay t where t.id_alumno_arpay=a.InternalStudentId and t.alum_apater=a.FatherSurname and
    t.alum_amater=a.MotherSurname and t.alum_nom=a.FirstName and t.sede_arpay=a.sede and t.estado=2)=0 and a.sede in (" . $dato['sedes'] . ")";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_alumno_asignados($empresa_arpay)
  {
    $sql = "SELECT id_alumno,id_alumno_arpay,estado from alumnos_arpay where estado=2 and empresa_arpay='" . $empresa_arpay . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_alumno_asignados_general()
  {
    $sql = "SELECT a.*,s.cod_sede,
    CASE WHEN a.ch_dni=1 THEN 'Si' ELSE 'No' END AS v_dni,
      CASE WHEN a.ch_certificadoe=1 THEN 'Si' ELSE 'No' END AS v_certificadoe,
      CASE WHEN a.ch_foto=1 THEN 'Si' ELSE 'No' END AS v_foto,
      CASE WHEN a.ch_doc=1 THEN 'Si' ELSE 'No' END AS v_doc
    from alumnos_arpay a 
    left join sede s on a.id_sede=s.id_sede
    where a.estado=2 ";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function cantidad_asignacion_alumnobd()
  {
    $sql = "SELECT a.*,(SELECT COUNT(*) FROM alumnos_arpay b WHERE b.estado=2 and b.asignado=1 and a.folder=b.folder) as  cantidad from alumnos_arpay a 
      where a.estado=2 and a.asignado=1 GROUP by a.folder";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function ultima_cantidad_alumnos_asignados()
  {
    $sql = "SELECT count(*) as ultima_cantidad FROM alumnos_arpay h where h.folder=(SELECT a.folder from alumnos_arpay a where a.estado=2 and a.asignado=1  GROUP by a.folder DESC LIMIT 1)";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_sede_alumnobd($dato)
  {

    $sql = "SELECT * FROM sede WHERE estado=2 and b_datos=1 ORDER BY cod_sede ASC";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function asignar_folder_bd($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT into alumnos_arpay (id_alumno_arpay,sede_arpay,empresa_arpay,
      alum_nom,alum_apater,alum_amater,
      dni_alumno,grado,seccion,codigo,estado_arpay,anio,
      folder, tipo_folder, cod_folder, correlativo, id_sede,asignado, 
      estado, fec_reg, user_reg)

      SELECT InternalStudentId,sede,empresa,FirstName,FatherSurname,MotherSurname,IdentityCardNumber,Grade,Class,InternalStudentId,StudentStatus,'" . $dato['anio'] . "',
      '" . $dato['folder'] . "','" . $dato['tipo_folder'] . "','" . $dato['cod_folder'] . "','" . $dato['correlativo'] . "','" . $dato['id_sede'] . "',1,2,NOW()," . $id_usuario . "
      FROM alumnos_arpay_temporal where id_alumno_arpay_temporal='" . $dato['id_alumno_arpay_temporal'] . "' and estado=2";
    $this->db->query($sql);
  }

  function get_id_sede_xid($id_sede)
  {
    $sql = "SELECT * FROM sede where id_sede=$id_sede";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_alumno_BD($id_alumno)
  {
    $sql = "SELECT * from alumnos_arpay where id_alumno=" . $id_alumno;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function validar_documentacion($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE alumnos_arpay SET ch_dni='" . $dato['dni'] . "',ch_certificadoe='" . $dato['certificadoe'] . "', ch_foto='" . $dato['foto'] . "',ch_doc='" . $dato['doc'] . "',fec_act='" . $fecha . "', user_act=$id_usuario WHERE id_alumno='" . $dato['id_alumno'] . "'";

    $this->db->query($sql);
  }

  function valida_asignar_folder($dato)
  {
    $sql = "SELECT * FROM alumnos_arpay where estado=2 and asignado=1 and folder='" . $dato['folder'] . "' and tipo_folder='" . $dato['tipo_folder'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_informe_alumnos_bd()
  {

    $sql = "SELECT a.folder,e.cod_empresa,s.cod_sede,a.anio,
    (SELECT d.correlativo FROM alumnos_arpay d where d.folder=a.folder and a.id_sede=d.id_sede and a.anio=d.anio and d.estado=2 and d.asignado=1 order by d.correlativo asc limit 1 ) as del,
    (SELECT d.correlativo FROM alumnos_arpay d where d.folder=a.folder and a.id_sede=d.id_sede and a.anio=d.anio and d.estado=2 and d.asignado=1 order by d.correlativo desc  limit 1 ) as al,
    CASE WHEN (SELECT count(*) FROM alumnos_arpay c WHERE c.folder=a.folder and c.estado=2 and c.asignado=1)=50 THEN 'Completo' ELSE 'Incompleto' END AS estado_g,
    (SELECT COUNT(*) FROM alumnos_arpay dc where dc.folder=a.folder AND a.id_sede=dc.id_sede and a.anio=dc.anio AND dc.estado=2 AND dc.asignado=1 and dc.ch_dni=1) as dni,
    (SELECT COUNT(*) FROM alumnos_arpay dc where dc.folder=a.folder AND a.id_sede=dc.id_sede and a.anio=dc.anio AND dc.estado=2 AND dc.asignado=1 and dc.ch_certificadoe=1) as ces,
    (SELECT COUNT(*) FROM alumnos_arpay dc where dc.folder=a.folder AND a.id_sede=dc.id_sede and a.anio=dc.anio AND dc.estado=2 AND dc.asignado=1 and dc.ch_foto=1) as foto,
    (SELECT COUNT(*) FROM alumnos_arpay dc where dc.folder=a.folder AND a.id_sede=dc.id_sede and a.anio=dc.anio AND dc.estado=2 AND dc.asignado=1 and dc.ch_doc=1) as doc
    FROM alumnos_arpay a 
    LEFT JOIN sede s on s.id_sede=a.id_sede
    LEFT JOIN empresa e on e.id_empresa=s.id_empresa
    WHERE a.asignado=1 and a.estado=2
    GROUP BY a.folder,s.cod_sede,a.anio";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_detalle_folder($lado, $folder)
  {
    $sql = "SELECT a.*,e.cod_empresa,s.cod_sede,
    case when a.ch_dni=1 then 'Si' else 'No' end as dni,
    case when a.ch_certificadoe=1 then 'Si' else 'No' end as certificado,
    case when a.ch_foto=1 then 'Si' else 'No' end as cfoto,
    case when a.ch_doc=1 then 'Si' else 'No' end as doc
    
    FROM alumnos_arpay a 
    LEFT JOIN sede s on s.id_sede=a.id_sede
    LEFT JOIN empresa e on e.id_empresa=s.id_empresa
    WHERE a.asignado=1 and a.estado=2 and a.folder=$folder and a.tipo_folder='$lado'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function list_detalle_folder_primer_ultimo($lado, $folder)
  {
    $sql = "SELECT (SELECT c.correlativo FROM alumnos_arpay c WHERE a.asignado=1 and a.estado=2 and a.folder=c.folder and a.tipo_folder=c.tipo_folder ORDER BY c.correlativo ASC LIMIT 1) as primer,
    (SELECT c.correlativo FROM alumnos_arpay c WHERE a.asignado=1 and a.estado=2 and a.folder=c.folder and a.tipo_folder=c.tipo_folder ORDER BY c.correlativo DESC LIMIT 1) as ultimo,
    s.cod_sede

    FROM alumnos_arpay a
    LEFT JOIN sede s on s.id_sede=a.id_sede
        WHERE a.asignado=1 and a.estado=2 and a.folder=$folder and a.tipo_folder='$lado' GROUP BY primer,ultimo";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  //--------------------------------------------ALUMNOS COMERCIAL-------------------------------------------------
  function get_list_sede_comercial($id_empresa)
  {
    $sql = "SELECT * FROM sede WHERE id_empresa=$id_empresa ORDER BY cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_alumno_comercial($sede, $tipo)
  {
    if ($sede == 'BL1') {
      $empresa = 4;
    } elseif ($sede == 'LL1') {
      $empresa = 7;
    } else {
      $empresa = 5;
    }

    if ($tipo == 1) {
      $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
              per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
              END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
              FROM Matriculation oldMat  
              JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
              JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
              WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
              ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
              (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
              WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
              ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
              INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
              WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
              ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
              FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
              (SELECT COUNT(*) FROM Student.StudentDocument st 
              WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1 AND st.DocumentFilePath!='') AS Cantidad_Subida,
              (SELECT COUNT(*) FROM Student.StudentDocument st 
              WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1) AS Cantidad_Obligatorio,
              CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' ELSE cc.Name END AS Seccion,
              mst.Description AS MatriculationStatusName
              FROM Client cli
              JOIN Person per ON per.Id = cli.PersonId  
              LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
              WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
              LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
              LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
              LEFT JOIN Course c ON c.Id = pi.CourseId  
              LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
              LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
              WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
              ORDER BY ccs2.Id DESC)  
              LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
              LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
              WHERE cli.EnterpriseHeadquarterId = $empresa AND cli.InternalStudentId IS NOT NULL AND cli.StudentStatusId=5 AND YEAR(mat.StartDate)=2022
              ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";
    } else {
      $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
              per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
              END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
              FROM Matriculation oldMat  
              JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
              JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
              WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
              ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
              (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
              WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
              ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
              INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
              WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
              ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
              FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
              (SELECT COUNT(*) FROM Student.StudentDocument st 
              WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1 AND st.DocumentFilePath!='') AS Cantidad_Subida,
              (SELECT COUNT(*) FROM Student.StudentDocument st 
              WHERE st.ClientId=cli.Id AND st.DocumentTemplateFilledRequired=1) AS Cantidad_Obligatorio,
              CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' ELSE cc.Name END AS Seccion,
              mst.Description AS MatriculationStatusName
              FROM Client cli
              JOIN Person per ON per.Id = cli.PersonId  
              LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
              WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
              LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
              LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
              LEFT JOIN Course c ON c.Id = pi.CourseId  
              LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
              LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
              WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
              ORDER BY ccs2.Id DESC)  
              LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
              LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
              WHERE cli.EnterpriseHeadquarterId = $empresa AND cli.InternalStudentId IS NOT NULL AND cli.StudentStatusId=5 AND YEAR(mat.StartDate)=2022
              ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";
    }
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_cod_sede($sede)
  {
    $sql = "SELECT se.*,em.imagen FROM sede se
            LEFT JOIN empresa em ON em.id_empresa=se.id_empresa
            WHERE se.estado=2 AND se.cod_sede='$sede'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_alumno_comercial($id_alumno)
  {
    $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombres,
            per.IdentityCardNumber AS Documento,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
            END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
            FROM Matriculation oldMat  
            JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
            JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
            WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
            ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
            (SELECT TOP 1 FORMAT(PurchaseDate,'dd/MM/yyyy') FROM ClientProductPurchaseRegistry 
            WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
            ClientProductPurchaseRegistry.Description='Matricula') AS Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
            INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
            WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
            ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,per.BirthDate AS Fecha_Cumpleanos,
            FORMAT(per.BirthDate,'dd/MM/yyyy') AS Cumpleanos,
            CONCAT(per.FatherSurname,' ',per.MotherSurname,', ',per.FirstName) AS Nombre_Completo,per.MobilePhone AS Celular
            FROM Client cli
            JOIN Person per ON per.Id = cli.PersonId  
            LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
            WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
            LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
            LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
            LEFT JOIN Course c ON c.Id = pi.CourseId  
            LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
            LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
            WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
            ORDER BY ccs2.Id DESC)  
            LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
            LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
            WHERE cli.Id=$id_alumno";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_documento_alumno_comercial($id_alumno)
  {
    $sql = "SELECT st.Id,st.Name,st.Year,ap.Name AS Usuario_Entrega,FORMAT(st.DeliveryDate,'dd/MM/yyyy HH:mm') AS Fecha_Entrega,
            CASE WHEN st.DocumentTemplateFilledRequired=1 THEN 'Si' ELSE 'No' END AS Obligatorio_Documento,st.DocumentFilePath
            FROM Student.StudentDocument st
            LEFT JOIN AspNetUsers ap ON ap.Id=st.DeliveredBy
            WHERE st.ClientId=$id_alumno";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }

  function get_list_pago_alumno_comercial($id_alumno)
  {
    $sql = "SELECT prod.Name AS 'Producto',pst.Description AS 'Estado',cppr.Description AS 'Descripcion',cppr.PaymentDueDate AS 'Fecha_VP',
            cppr.Cost AS 'Monto',cppr.TotalDiscount AS 'Descuento',cppr.PenaltyAmountPaid AS 'Penalidad',(ISNULL(cppr.Cost,0)-
            ISNULL(cppr.TotalDiscount,0)+ISNULL(cppr.PenaltyAmountPaid,0)) AS 'SubTotal'
            FROM ClientProductPurchaseRegistry cppr,Client cli,Person p,EnterpriseHeadquarter eh,Headquarter he,Product prod,ProductItem prodItem,  
            PaymentStatusTranslation pst   
            WHERE cli.Id=$id_alumno AND cppr.PaymentStatusId IN (1,2,3) AND cppr.ClientId = cli.Id AND cli.PersonId = p.Id AND cli.EnterpriseHeadquarterId = eh.Id AND 
            eh.HeadquarterId = he.Id AND cppr.ProductId = prod.Id AND cppr.ProductItemId = prodItem.Id AND cppr.PaymentStatusId = pst.PaymentStatusId AND 
            pst.[Language] = 'es-PE'  
            ORDER BY prod.Name, cli.InternalStudentId";
    $query = $this->db2->query($sql)->result_Array();
    return $query;
  }
  //-----------------------------------------HISTORIAL REGISTRO MAIL - EVENTO------------------------------------------------
  function get_list_accion_evento()
  {
    $sql = "SELECT * FROM accion WHERE id_accion=12 ORDER BY nom_accion ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_status_evento()
  {
    $sql = "SELECT * FROM status_general WHERE id_status_general IN (15,54,57,58,59,60) AND estado=2 ORDER BY nom_status ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_centro_custo()
  {
    $sql = "SELECT se.*,s.nom_status FROM Centro_Custo_Rubro se
            LEFT JOIN status s on se.estado=s.id_status
            where tipo_ccr='Centro_Custo'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function insert_centro_custo($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "insert into Centro_Custo_Rubro (nom_ccr,tipo_ccr, estado, fec_reg, user_reg) 
    values ('" . $dato['nom_tipo'] . "','Centro_Custo','" . $dato['id_status'] . "', 
    '" . $fecha . "'," . $id_usuario . ")";
    $this->db->query($sql);
  }
  function get_list_estado_mae($dato)
  {
    $sql = "select * from status_general where id_status_mae='" . $dato['id_status_mae'] . "' and estado=2 ORDER BY nom_status ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function update_centro_custo($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "update Centro_Custo_Rubro set nom_ccr='" . $dato['nom_tipo'] . "', estado='" . $dato['id_status'] . "', 
    fec_act='" . $fecha . "', user_act=" . $id_usuario . "  where id_ccr='" . $dato['id_tipo'] . "'";
    $this->db->query($sql);
  }
  function get_id_centro_custo($id_tipo)
  {
    if (isset($id_tipo) && $id_tipo > 0) {
      $sql = "select * from Centro_Custo_Rubro where id_ccr =" . $id_tipo;
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  /*-----------------------*/
  function get_list_rubro_contabilidade()
  {
    $sql = "SELECT se.*,s.nom_status FROM Centro_Custo_Rubro se
            LEFT JOIN status s on se.estado=s.id_status
            where tipo_ccr='Rubro'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function insert_rubro_contabilidade($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "insert into Centro_Custo_Rubro (nom_ccr,tipo_ccr, estado, fec_reg, user_reg) 
    values ('" . $dato['nom_tipo'] . "','Rubro','" . $dato['id_status'] . "', 
    '" . $fecha . "'," . $id_usuario . ")";
    $this->db->query($sql);
  }

  function update_rubro_contabilidade($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

    $sql = "update Centro_Custo_Rubro set nom_ccr='" . $dato['nom_tipo'] . "', estado='" . $dato['id_status'] . "', 
    fec_act='" . $fecha . "', user_act=" . $id_usuario . "  where id_ccr='" . $dato['id_tipo'] . "'";
    $this->db->query($sql);
  }

  //-----------------------------------------Documentos PDF------------------------------------------------
  function get_list_documento_pdf()
  {
    $sql = "SELECT d.id_documento_pdf,d.referencia,d.nombre_documento_pdf,d.link_documento_pdf,d.documento,
                s.nom_status,(CASE d.archivo WHEN 1 THEN 'Sí' ELSE 'No' END) AS archivo,e.cod_empresa,se.cod_sede,s.color
                FROM documento_pdf d
                left join status s on d.estado=s.id_status
                left join empresa e on e.id_empresa=d.id_empresa
                left join sede se on se.id_sede=d.id_sede
                WHERE d.estado in (1,2,3)
                ORDER BY s.nom_status ASC,e.cod_empresa ASC,se.cod_sede ASC,d.nombre_documento_pdf ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_insert_documentos_pdf($dato)
  {
    $sql = "SELECT * FROM documento_pdf 
              WHERE referencia='" . $dato['referencia'] . "' AND id_empresa='" . $dato['id_empresa'] . "' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_documentos_pdf($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO documento_pdf (referencia,nombre_documento_pdf,link_documento_pdf,documento, 
                id_empresa,id_sede,estado,fec_reg,user_reg,archivo) 
                VALUES ('" . $dato['referencia'] . "','" . $dato['nombre_documento_pdf'] . "','" . $dato['link_documento_pdf'] . "',
                '" . $dato['documento'] . "','" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "',
                2,NOW(),$id_usuario,1)";
    $this->db->query($sql);
  }

  function get_id_documento_pdf($id_documento_pdf)
  {
    $sql = "SELECT * FROM documento_pdf WHERE estado in (1,2,3) and id_documento_pdf=$id_documento_pdf";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_update_documentos_pdf($dato)
  {
    $sql = "SELECT * FROM documento_pdf 
              WHERE id_documento_pdf!='" . $dato['id_documento_pdf'] . "' AND referencia='" . $dato['referencia'] . "' AND 
              id_empresa='" . $dato['id_empresa'] . "' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_documentos_PDF($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE documento_pdf SET referencia='" . $dato['referencia'] . "',nombre_documento_pdf='" . $dato['nombre_documento_pdf'] . "', 
              link_documento_pdf='" . $dato['link_documento_pdf'] . "',documento='" . $dato['documento'] . "',archivo=1,
              id_empresa='" . $dato['id_empresa'] . "',id_sede='" . $dato['id_sede'] . "',estado='" . $dato['estado'] . "',
              fec_act=NOW(),user_act=$id_usuario
              WHERE id_documento_pdf='" . $dato['id_documento_pdf'] . "'";
    $this->db->query($sql);
  }

  function get_id_comuimg($id_comuimg)
  {
    $sql = "SELECT * from documento_pdf where id_documento_pdf =$id_comuimg";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function delete_archivo_documento_pdf($id_comuimg)
  {
    $sql = "UPDATE documento_pdf set documento='',archivo='' WHERE id_documento_pdf=$id_comuimg";
    $this->db->query($sql);
  }

  function get_docu_comuimg($dato)
  {
    $sql = "SELECT documento from documento_pdf where id_documento_pdf ='" . $dato['id_documento_pdf'] . "' ";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_codigo_inventario($dato)
  {
    $fecha = date('Y-m-d H:i:s');
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    unlink('./' . $dato['documento']);
    $sql = "update documento_pdf set estado='4',
      fec_eli='" . $fecha . "', user_eli=" . $id_usuario . "  where id_documento_pdf='" . $dato['id_documento_pdf'] . "'";
    $this->db->query($sql);

  }

  function get_list_sede_xempresa($dato)
  {
    $sql = "SELECT * FROM sede WHERE estado=2 AND id_empresa='" . $dato['id_empresa'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  //------------------------------------RECOMENDADOS-----------------------------------------------
  function get_list_recomendados($id_recomendado = null)
  {
    if (isset($id_recomendado) && $id_recomendado > 0) {
      $sql = "SELECT *,DATE_FORMAT(registro,'%d/%m/%Y %H:%i') AS registro FROM recomendados
                  WHERE id_recomendado=$id_recomendado";
    } else {
      $sql = "SELECT *,DATE_FORMAT(registro,'%d/%m/%Y %H:%i') AS registro FROM recomendados";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_recomendados($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE recomendados SET validado1='" . $dato['validado1'] . "',estado_r='" . $dato['estado_r'] . "',
              validado2='" . $dato['validado2'] . "',fec_act=NOW(),user_act=$id_usuario
              WHERE id_recomendado='" . $dato['id_recomendado'] . "'";
    $this->db->query($sql);
  }

  function get_correo_matriculados($tipo, $dni_alumno)
  {
    $sql = "SELECT * FROM matriculados_$tipo WHERE Dni='$dni_alumno'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_texto_sms()
  {
    $sql = "SELECT * FROM config WHERE id_config=5";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_configurar_sms($dato)
  {
    $sql = "UPDATE config SET observaciones='" . $dato['texto_sms'] . "'
              WHERE id_config=5";
    $this->db->query($sql);
  }

  function get_list_fecha_estado_bancario($dato)
  {
    $sql = "SELECT * FROM estado_bancario_fecha WHERE estado=2 and MovementType='" . $dato['MovementType'] . "' 
    and Reference='" . $dato['Reference'] . "' and OperationNumber='" . $dato['OperationNumber'] . "' and id_estado_bancario='" . $dato['id_estado_bancario'] . "' ";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_estado_bancario_fecha($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO estado_bancario_fecha (MovementType,Reference,OperationNumber,MovementDate,AmountValue,RealAmount,Description,
            mes_anio,id_estado_bancario,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['MovementType'] . "','" . $dato['Reference'] . "',
            '" . $dato['OperationNumber'] . "','" . $dato['MovementDate'] . "','" . $dato['AmountValue'] . "','" . $dato['RealAmount'] . "','" . $dato['Description'] . "','" . $dato['mes_anio'] . "','" . $dato['id_estado_bancario'] . "',
            '2',NOW(),$id_usuario)";
    //echo $sql;
    $this->db->query($sql);
  }

  function update_estado_bancario_fecha($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE estado_bancario_fecha SET mes_anio='" . $dato['mes_anio'] . "',MovementDate='" . $dato['MovementDate'] . "',AmountValue='" . $dato['AmountValue'] . "',
    RealAmount='" . $dato['RealAmount'] . "',Description='" . $dato['Description'] . "',fec_act=NOW(),user_act=$id_usuario 
    WHERE MovementType='" . $dato['MovementType'] . "' and Reference='" . $dato['Reference'] . "' and OperationNumber='" . $dato['OperationNumber'] . "'
    and id_estado_bancario='" . $dato['id_estado_bancario'] . "' and estado=2";
    $this->db->query($sql);
  }

  function get_list_estado_bancario_fecha($id_estado_bancario)
  {
    $sql = "SELECT *,concat(MovementType,'-',Reference,'-',OperationNumber) as verificar,
    case 
    when month(MovementDate)='01' then 'Ene' 
    when month(MovementDate)='02' then 'Feb' 
    when month(MovementDate)='03' then 'Mar' 
    when month(MovementDate)='04' then 'Abr' 
    when month(MovementDate)='05' then 'May' 
    when month(MovementDate)='06' then 'Jun' 
    when month(MovementDate)='07' then 'Jul' 
    when month(MovementDate)='08' then 'Ago' 
    when month(MovementDate)='09' then 'Sep' 
    when month(MovementDate)='10' then 'Oct' 
    when month(MovementDate)='11' then 'Nov' 
    when month(MovementDate)='12' then 'Dic'  end as desc_mes,SUBSTR(year(MovementDate), 3, 2) as anio
     FROM estado_bancario_fecha WHERE estado=2 and id_estado_bancario='$id_estado_bancario'";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_saldo_snappy2($id_estado_bancario, $dato)
  {
    $dato['anio'] = date('Y');
    $sql = "SELECT de.* FROM detalle_estado_bancario de
    WHERE de.id_estado_bancario=$id_estado_bancario AND de.estado=1 and de.mes='" . $dato['mes_actual'] . "' and de.anio='" . $dato['anio'] . "'";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_saldo_snappy_restante_1($id_estado_bancario, $Id, $dato)
  {
    $sql = "SELECT b.*,sum(RealAmount) as saldo 
    from getbankstatementmovements_snappy b where b.BankAccountId='$Id' and 
    (SELECT COUNT(*) FROM estado_bancario_fecha e WHERE e.MovementType=b.MovementType AND e.Reference=b.Reference AND e.OperationNumber=b.OperationNumber)=0 and date_format(b.MovementDate,'%Y-%m-%d') BETWEEN '" . $dato['desde'] . "' AND '" . $dato['hasta'] . "'";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_saldo_snappy_restante_2($id_estado_bancario, $dato)
  {
    $sql = "SELECT b.*,sum(RealAmount) as saldo 
    from estado_bancario_fecha b where b.id_estado_bancario='$id_estado_bancario' and b.mes_anio in (" . $dato['cadena'] . ")";
    //echo $sql;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  public function getsubtipo2($dato)
  {
    $sql = "SELECT * FROM subtipo  
            WHERE id_tipo='" . $dato['id_tipo'] . "' AND estado=2 ORDER BY nom_subtipo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  //--------------------------------------------BASE DE DATOS-------------------------------------------------
  function get_list_compra_mensaje($id_compra = null)
  {
    if (isset($id_compra) && $id_compra > 0) {
      $sql = "SELECT * FROM compra_mensaje 
              WHERE id_compra=$id_compra";
    } else {
      $sql = "SELECT cm.id_compra,cm.fecha,DATE_FORMAT(cm.fecha,'%d-%m-%Y') AS fecha_compra,cm.monto,cm.cantidad,
              DATE_FORMAT(cm.fec_reg,'%d-%m-%Y') AS fecha_registro,ue.usuario_codigo AS usuario_registro,
              st.nom_status,st.color 
              FROM compra_mensaje cm
              LEFT JOIN users ue ON ue.id_usuario=cm.user_reg
              LEFT JOIN status st ON st.id_status=cm.estado
              WHERE cm.estado NOT IN (4)
              ORDER BY cm.fecha DESC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_compra_mensaje($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO compra_mensaje (fecha,monto,cantidad,estado,fec_reg,user_reg) 
              VALUES ('" . $dato['fecha'] . "','" . $dato['monto'] . "','" . $dato['cantidad'] . "',2,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_compra_mensaje($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE compra_mensaje SET fecha='" . $dato['fecha'] . "',monto='" . $dato['monto'] . "',cantidad='" . $dato['cantidad'] . "',
              estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
              WHERE id_compra='" . $dato['id_compra'] . "'";
    $this->db->query($sql);
  }

  function delete_compra_mensaje($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE compra_mensaje SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
              WHERE id_compra='" . $dato['id_compra'] . "'";
    $this->db->query($sql);
  }
  //-----------------------------------CIERRES DE CAJA-------------------------------------
  function get_list_cierre_caja($tipo)
  {
    if ($tipo == 1) {
      $parte_i = "AND MONTH(ci.fecha)=MONTH(CURDATE()) AND YEAR(ci.fecha)=YEAR(CURDATE())";
      $parte_e = "AND MONTH(ce.fecha)=MONTH(CURDATE()) AND YEAR(ce.fecha)=YEAR(CURDATE())";
    } elseif ($tipo == 2) {
      $parte_i = "";
      $parte_e = "";
    } else {
      $parte_i = "AND ci.cofre=''";
      $parte_e = "AND ce.cofre=''";
    }

    $sql = "SELECT ci.id_cierre_caja,ci.fecha,se.cod_sede,um.usuario_codigo AS cod_vendedor,
              DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,ci.saldo_automatico,ci.monto_entregado,
              ci.productos,(ci.saldo_automatico-ci.monto_entregado) AS diferencia,
              un.usuario_codigo AS cod_entrega,CASE WHEN ci.cerrada=0 AND ci.estado=2 THEN '' 
              ELSE DATE_FORMAT(ci.fec_reg,'%d-%m-%Y') END AS fecha_registro,
              ur.usuario_codigo AS cod_registro,ci.cofre,ci.cerrada,
              CASE WHEN ci.estado=4 THEN '#C00000'
              WHEN ci.cerrada=0 THEN '#FF8000' 
              WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado>0 THEN '#0070C0'
              WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado=0 THEN '#92D050' 
              WHEN ci.cerrada=1 AND ci.cofre!='' THEN '#92D050'
              ELSE '' END AS color_estado,
              CASE WHEN ci.estado=4 THEN 'Anulada'
              WHEN ci.cerrada=0 THEN 'Pendiente' 
              WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado>0 THEN 'Cerrada'
              WHEN ci.cerrada=1 AND ci.cofre='' AND ci.monto_entregado=0 THEN 'Cerrado' 
              WHEN ci.cerrada=1 AND ci.cofre!='' THEN 'Asignada'
              ELSE '' END AS nom_estado,ci.estado,7 AS id_empresa,ci.fecha AS mes_anio
              FROM cierre_caja ci
              LEFT JOIN sede se ON se.id_sede=ci.id_sede
              LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
              LEFT JOIN users un ON un.id_usuario=ci.id_entrega
              LEFT JOIN users ur ON ur.id_usuario=ci.user_reg
              WHERE ci.estado NOT IN (4) $parte_i
              UNION
              SELECT ce.id_cierre_caja,ce.fecha,se.cod_sede,um.usuario_codigo AS cod_vendedor,
              DATE_FORMAT(ce.fecha,'%d-%m-%Y') AS caja,ce.saldo_automatico,ce.monto_entregado,
              ce.productos,(ce.saldo_automatico-ce.monto_entregado) AS diferencia,
              un.usuario_codigo AS cod_entrega,CASE WHEN ce.cerrada=0 AND ce.estado=2 THEN '' 
              ELSE DATE_FORMAT(ce.fec_reg,'%d-%m-%Y') END AS fecha_registro,
              ur.usuario_codigo AS cod_registro,ce.cofre,ce.cerrada,
              CASE WHEN ce.estado=4 THEN '#C00000'
              WHEN ce.cerrada=0 THEN '#FF8000' 
              WHEN ce.cerrada=1 AND ce.cofre='' AND ce.monto_entregado>0 THEN '#0070C0'
              WHEN ce.cerrada=1 AND ce.cofre='' AND ce.monto_entregado=0 THEN '#92D050' 
              WHEN ce.cerrada=1 AND ce.cofre!='' THEN '#92D050'
              ELSE '' END AS color_estado,
              CASE WHEN ce.estado=4 THEN 'Anulada'
              WHEN ce.cerrada=0 THEN 'Pendiente' 
              WHEN ce.cerrada=1 AND ce.cofre='' AND ce.monto_entregado>0 THEN 'Cerrada'
              WHEN ce.cerrada=1 AND ce.cofre='' AND ce.monto_entregado=0 THEN 'Cerrado' 
              WHEN ce.cerrada=1 AND ce.cofre!='' THEN 'Asignada'
              ELSE '' END AS nom_estado,ce.estado,ce.id_empresa,ce.fecha AS mes_anio
              FROM cierre_caja_empresa ce
              LEFT JOIN sede se ON se.id_sede=ce.id_sede
              LEFT JOIN users um ON um.id_usuario=ce.id_vendedor
              LEFT JOIN users un ON un.id_usuario=ce.id_entrega
              LEFT JOIN users ur ON ur.id_usuario=ce.user_reg
              WHERE ce.estado NOT IN (4) $parte_e
              ORDER BY fecha ASC,cod_sede ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_cofre_cierre_caja($dato)
  {
    if ($dato['id_empresa'] == "7") {
      $tabla = "cierre_caja";
    } else {
      $tabla = "cierre_caja_empresa";
    }
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE $tabla SET cofre='" . $dato['cofre'] . "',fec_act=NOW(),user_act=$id_usuario
              WHERE id_cierre_caja='" . $dato['id_cierre_caja'] . "'";
    $this->db->query($sql);
  }

  function get_id_cierre_caja($id_cierre_caja, $id_empresa)
  {
    if ($id_empresa == 3) {
      $sql = "SELECT ci.*,DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,
                DATE_FORMAT(ci.fec_reg,'%d-%m-%Y %H:%i') AS fecha_cierre,
                DATE_FORMAT(ci.fec_reg,'%H:%i') AS hora,um.usuario_codigo AS cod_vendedor,
                un.usuario_codigo AS cod_entrega,se.cod_sede,se.observaciones_sede AS nom_sede,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS ingresos,
                0.00 AS egresos,
                IFNULL((SELECT COUNT(1) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS recibos,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=2 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS total_recibos,
                IFNULL((SELECT COUNT(*) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=4 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS devoluciones,
                IFNULL((SELECT SUM(pa.monto-pa.descuento+pa.penalidad) FROM pago_matricula_alumno_bl pa 
                WHERE DATE(pa.fec_pago)=ci.fecha AND pa.estado_pago=4 AND pa.id_tipo_pago=1 AND 
                pa.estado=2),0) AS total_devoluciones,
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia
                FROM cierre_caja_empresa ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                WHERE ci.id_cierre_caja=$id_cierre_caja";
    } else if ($id_empresa == 6) {
      $sql = "SELECT ci.*,DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,
                DATE_FORMAT(ci.fec_reg,'%d-%m-%Y %H:%i') AS fecha_cierre,
                DATE_FORMAT(ci.fec_reg,'%H:%i') AS hora,um.usuario_codigo AS cod_vendedor,
                un.usuario_codigo AS cod_entrega,se.cod_sede,se.observaciones_sede AS nom_sede,
                IFNULL((SELECT SUM(vd.cantidad*(vd.precio-vd.descuento)) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.id_empresa=6),0) AS ingresos,
                IFNULL((SELECT SUM(vd.cantidad*(vd.precio-vd.descuento)) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha 
                AND ve.id_empresa=6),0) AS egresos,
                IFNULL((SELECT COUNT(*) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.id_empresa=6),0) AS recibos,
                IFNULL((SELECT SUM(vd.cantidad*(vd.precio-vd.descuento)) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.id_empresa=6),0) AS total_recibos,
                IFNULL((SELECT COUNT(*) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha 
                AND ve.id_empresa=6),0) AS devoluciones,
                IFNULL((SELECT SUM(vd.cantidad*(vd.precio-vd.descuento)) FROM venta_empresa_detalle vd 
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha 
                AND ve.id_empresa=6),0) AS total_devoluciones,
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia
                FROM cierre_caja_empresa ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                WHERE ci.id_cierre_caja=$id_cierre_caja";
    } else {
      $sql = "SELECT ci.*,DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,DATE_FORMAT(ci.fec_reg,'%d-%m-%Y %H:%i') AS fecha_cierre,
                DATE_FORMAT(ci.fec_reg,'%H:%i') AS hora,um.usuario_codigo AS cod_vendedor,un.usuario_codigo AS cod_entrega,
                se.cod_sede,se.observaciones_sede AS nom_sede,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=ci.id_sede),0) AS ingresos,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=ci.id_sede),0) AS egresos,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS recibos,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS total_recibos,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=2 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS boletas,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=2 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS total_boletas,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=3 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS facturas,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=3 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=ci.id_sede),0) AS total_facturas,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=ci.id_sede),0) AS devoluciones,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=ci.id_sede),0) AS total_devoluciones,
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia,7 AS id_empresa
                FROM cierre_caja ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                WHERE ci.id_cierre_caja=$id_cierre_caja";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_ingreso_cierre_caja($id_sede, $fecha, $id_vendedor)
  {
    $sql = "SELECT CASE WHEN al.id_empresa=2 THEN tl.Codigo 
              WHEN al.id_empresa=3 THEN tb.cod_alum
              WHEN al.id_empresa=4 THEN ts.Codigo 
              WHEN al.id_empresa=6 THEN tf.Codigo ELSE '' END AS Codigo,
              CASE WHEN al.id_empresa=2 THEN tl.Apellido_Paterno 
              WHEN al.id_empresa=3 THEN tb.alum_apater
              WHEN al.id_empresa=4 THEN ts.Apellido_Paterno 
              WHEN al.id_empresa=6 THEN tf.Apellido_Paterno ELSE '' END AS Apellido_Paterno,
              CASE WHEN al.id_empresa=2 THEN tl.Apellido_Materno 
              WHEN al.id_empresa=3 THEN tb.alum_amater
              WHEN al.id_empresa=4 THEN ts.Apellido_Materno 
              WHEN al.id_empresa=6 THEN tf.Apellido_Materno ELSE '' END AS Apellido_Materno,
              CASE WHEN al.id_empresa=2 THEN tl.Nombre 
              WHEN al.id_empresa=3 THEN tb.alum_nom
              WHEN al.id_empresa=4 THEN ts.Nombre 
              WHEN al.id_empresa=6 THEN tf.Nombre ELSE '' END AS Nombre,
              vd.cod_producto,vd.precio,vd.cantidad,(vd.precio*vd.cantidad) AS total,
              ve.cod_venta,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,
              us.usuario_codigo
              FROM venta_detalle vd
              LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
              LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
              LEFT JOIN todos_ll tl ON tl.Id=ve.id_alumno
              LEFT JOIN alumno tb ON tb.id_alumno=ve.id_alumno
              LEFT JOIN todos_ls ts ON ts.Id=ve.id_alumno
              LEFT JOIN todos_l20 tf ON tf.Id=ve.id_alumno
              LEFT JOIN users us ON us.id_usuario=ve.user_reg
              WHERE al.id_sede=$id_sede AND DATE(ve.fec_reg)='$fecha' AND 
              ve.user_reg=$id_vendedor AND ve.estado=2 AND ve.estado_venta=1
              ORDER BY Codigo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_egreso_cierre_caja($id_sede, $fecha, $id_vendedor)
  {
    $sql = "SELECT CASE WHEN al.id_empresa=2 THEN tl.Codigo 
              WHEN al.id_empresa=3 THEN tb.cod_alum
              WHEN al.id_empresa=4 THEN ts.Codigo 
              WHEN al.id_empresa=6 THEN tf.Codigo ELSE '' END AS Codigo,
              CASE WHEN al.id_empresa=2 THEN tl.Apellido_Paterno 
              WHEN al.id_empresa=3 THEN tb.alum_apater
              WHEN al.id_empresa=4 THEN ts.Apellido_Paterno 
              WHEN al.id_empresa=6 THEN tf.Apellido_Paterno ELSE '' END AS Apellido_Paterno,
              CASE WHEN al.id_empresa=2 THEN tl.Apellido_Materno 
              WHEN al.id_empresa=3 THEN tb.alum_amater
              WHEN al.id_empresa=4 THEN ts.Apellido_Materno 
              WHEN al.id_empresa=6 THEN tf.Apellido_Materno ELSE '' END AS Apellido_Materno,
              CASE WHEN al.id_empresa=2 THEN tl.Nombre 
              WHEN al.id_empresa=3 THEN tb.alum_nom
              WHEN al.id_empresa=4 THEN ts.Nombre 
              WHEN al.id_empresa=6 THEN tf.Nombre ELSE '' END AS Nombre,
              vd.cod_producto,vd.precio,vd.cantidad,(vd.precio*vd.cantidad) AS total,
              ve.cod_venta,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,
              us.usuario_codigo
              FROM venta_detalle vd
              LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
              LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
              LEFT JOIN todos_ll tl ON tl.Id=ve.id_alumno
              LEFT JOIN alumno tb ON tb.id_alumno=ve.id_alumno
              LEFT JOIN todos_ls ts ON ts.Id=ve.id_alumno
              LEFT JOIN todos_l20 tf ON tf.Id=ve.id_alumno
              LEFT JOIN users us ON us.id_usuario=ve.user_reg
              WHERE al.id_sede=$id_sede AND DATE(ve.fec_reg)='$fecha' AND 
              ve.user_reg=$id_vendedor AND ve.estado=2 AND ve.estado_venta=3
              ORDER BY Codigo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_busqueda_centro_contadores($cter)
  {
    $where = '';
    if ($cter == 1) {
      $where = "WHERE (SELECT ch.estado FROM centro_historial ch 
      WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro 
      ORDER BY ch.fec_reg DESC LIMIT 1)=50";
    } elseif ($cter == 2) {
      $where = "WHERE ce.val_a<NOW() AND (SELECT ch.estado FROM centro_historial ch 
      WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro 
      ORDER BY ch.fec_reg DESC LIMIT 1) in (48,55)";
    }
    $sql = "SELECT ce.*,DATE_FORMAT(ce.fecha_firma,'%d/%m/%Y') as fec_firma,DATE_FORMAT(ce.val_de,'%d/%m/%Y') as inicio,
          DATE_FORMAT(ce.val_a,'%d/%m/%Y') as fin, (SELECT COUNT(*) FROM centro_direccion cd WHERE 
          cd.id_centro=ce.id_centro and cd.estado=2) as CP,
          CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
          THEN (SELECT g.direccion FROM v_grupo_direccion_ifv g 
          LEFT JOIN departamento d on d.id_departamento=g.departamento
          WHERE g.id_centro=ce.id_centro) ELSE '' END as direcciond,
          CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
          THEN (SELECT d.nombre_departamento FROM v_grupo_direccion_ifv g 
          LEFT JOIN departamento d on d.id_departamento=g.departamento
          WHERE g.id_centro=ce.id_centro) ELSE '' END as departamentod,

          CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
          THEN (SELECT p.nombre_provincia FROM v_grupo_direccion_ifv g 
          LEFT JOIN provincia p on p.id_provincia=g.provincia
          WHERE g.id_centro=ce.id_centro) ELSE '' END as provinciad,

          CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
          THEN (SELECT di.nombre_distrito FROM v_grupo_direccion_ifv g 
          LEFT JOIN distrito di on di.id_distrito=g.distrito
          WHERE g.id_centro=ce.id_centro) ELSE '' END as distritod,
          (SELECT ch.estado FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro 
          ORDER BY ch.fec_reg DESC LIMIT 1) AS id_statush,
          (SELECT sg.nom_status FROM centro_historial ch 
          LEFT JOIN status_general sg on sg.id_status_general=ch.estado 
          WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as nom_status,
          CASE WHEN ce.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
          (SELECT ch.comentario FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro =ce.id_centro 
          ORDER BY ch.fec_reg DESC LIMIT 1) AS ucomentario,
          (SELECT aaa.nom_accion FROM centro_historial ch 
           LEFT JOIN accion aaa on ch.id_accion=aaa.id_accion
           WHERE ch.estado<>1 AND ch.id_centro =ce.id_centro 
          ORDER BY ch.fec_reg DESC LIMIT 1) AS uaccion,us.usuario_codigo
          FROM centro ce
          LEFT JOIN users us ON us.id_usuario=ce.user_reg
          $where                               
          ORDER BY nom_status DESC";

    $query = $this->db->query($sql)->result_Array();
    return $query;
  }
  function get_list_tipo_obs()
  {
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];

    $sql = "SELECT * FROM tipo_observacion
          where estado=2 ORDER BY nom_tipo";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_usuario_obs()
  {
    $sql = "SELECT u.id_usuario,n.nom_nivel,u.id_nivel,u.estado,s.nom_status,
  DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i') AS ultimo_ingreso,u.usuario_codigo,u.codigo,
  u.usuario_apater,u.usuario_amater,u.usuario_nombres,u.codigo_gllg,u.ini_funciones,u.fin_funciones,
  h.fec_ingreso AS ultimo_ingreso_excel,
  DATE_FORMAT(u.ini_funciones,'%d/%m/%Y') AS inicio_funcion,
  DATE_FORMAT(u.fin_funciones,'%d/%m/%Y') AS fin_funcion
  from users u 
  left join nivel n on u.id_nivel=n.id_nivel
  left join status s on u.estado=s.id_status
  left join hingreso_ultimo h on h.id_usuario=u.id_usuario
  where u.id_nivel!=6 and u.id_nivel in (12)   and u.estado=2 or u.id_usuario in (1,7)
  group by u.id_usuario  
  ORDER BY u.usuario_codigo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  //-------------------------------------------------ASISTENCIA COLABORADOR----------------------------------
  function get_list_registro_ingreso_c($fec_in, $fec_fi)
  {
    $sql = "SELECT distinct ri.id_registro_ingreso,ri.ingreso AS orden,
            CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
            CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
            CASE WHEN (ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) and
            RIGHT(ri.codigo,1)!='C')
            THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,
    (CASE WHEN hr.observacion IS NULL  THEN 'No' ELSE 'Sí' END) AS obs,
            CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
            WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
            WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
            WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
            CASE WHEN ri.salida>0 THEN 'Salida' ELSE 
            (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END) END AS nom_estado_reporte,
            us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN 
            (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
            WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) 
            WHEN ri.estado_reporte=2 THEN 'A hora' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,
            CASE WHEN RIGHT(ri.codigo,1)='C' THEN td.Cargo 
            WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
            THEN 'Invitado' ELSE 'Alumno' END AS nom_tipo_acceso,
            CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
            ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
            (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
            ELSE ue.usuario_codigo END AS usuario_registro
            FROM registro_ingreso_ls ri
            LEFT JOIN historial_registro_ingreso_ls hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
            LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
            LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
            LEFT JOIN todos_ls td ON td.Id=ri.id_alumno AND td.Tipo=2
            LEFT JOIN colaborador c on c.codigo_glla = ri.codigo
            WHERE ri.estado=2 AND CONVERT(varchar,ri.ingreso,23) BETWEEN '$fec_in' AND '$fec_fi' AND 
            ri.codigo LIKE '%C%' and c.id_empresa=1
            ORDER BY ri.ingreso DESC";
    $query = $this->db5->query($sql)->result_Array();
    return $query;
  }

  function excel_registro_ingreso_c($fec_in, $fec_fi)
  {
    $sql = "SELECT distinct ri.id_registro_ingreso,ri.ingreso AS orden,
            CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
            CONVERT(char(5),ri.hora_salida,108) AS hora_salida,
            CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
            CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
            THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,
            (CASE WHEN hr.observacion IS NULL  THEN 'No' ELSE 'Sí' END) AS obs,
            --hr.observacion as obs_historial, <-- esta comentando por poder poner el distinct
            '' as obs_historial,
            CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
            WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
            WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
            WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
            CASE WHEN ri.salida>0 THEN 'Salida' ELSE 
            (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END) END AS nom_estado_reporte,
            us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN 
            (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
            WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) 
            WHEN ri.estado_reporte=2 THEN 'A hora' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,
            CASE WHEN RIGHT(ri.codigo,1)='C' THEN td.Cargo 
            WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
            THEN 'Invitado' ELSE 'Alumno' END AS nom_tipo_acceso,
            CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
            ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
            (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
            ELSE ue.usuario_codigo END AS usuario_registro
            FROM registro_ingreso_ls ri
            LEFT JOIN historial_registro_ingreso_ls hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
            LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
            LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
            LEFT JOIN todos_ls td ON td.Id=ri.id_alumno AND td.Tipo=2
            LEFT JOIN colaborador c on c.codigo_glla = ri.codigo
            WHERE ri.estado=2 AND CONVERT(varchar,ri.ingreso,23) BETWEEN '$fec_in' AND '$fec_fi' AND 
            ri.codigo LIKE '%C%' and c.id_empresa=1
            ORDER BY ri.ingreso DESC";
    $query = $this->db5->query($sql)->result_Array();
    return $query;
  }
  //-----------------------------------OBJETIVO-------------------------------------
  function get_list_objetivo($id_objetivo = null)
  {
    if (isset($id_objetivo) && $id_objetivo > 0) {
      $sql = "SELECT * FROM objetivo 
                    WHERE id_objetivo=$id_objetivo";
    } else {
      $sql = "SELECT ob.id_objetivo,ob.nom_objetivo,st.nom_status,st.color
                    FROM objetivo ob
                    LEFT JOIN status st ON st.id_status=ob.estado
                    WHERE ob.estado NOT IN (4)
                    ORDER BY ob.nom_objetivo ASC";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_objetivo_combo()
  {
    $sql = "SELECT id_objetivo,nom_objetivo FROM objetivo
                WHERE estado=2
                ORDER BY nom_objetivo ASC";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_insert_objetivo($dato)
  {
    $sql = "SELECT id_objetivo FROM objetivo
                WHERE nom_objetivo='" . $dato['nom_objetivo'] . "' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_objetivo($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO objetivo (nom_objetivo,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['nom_objetivo'] . "','" . $dato['estado'] . "',
                NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function valida_update_objetivo($dato)
  {
    $sql = "SELECT id_objetivo FROM objetivo
                WHERE nom_objetivo='" . $dato['nom_objetivo'] . "' AND estado=2 AND 
                id_objetivo!='" . $dato['id_objetivo'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function update_objetivo($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE objetivo SET nom_objetivo='" . $dato['nom_objetivo'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_objetivo='" . $dato['id_objetivo'] . "'";
    $this->db->query($sql);
  }

  function delete_objetivo($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE objetivo SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_objetivo='" . $dato['id_objetivo'] . "'";
    $this->db->query($sql);
  }

  function delete_registro_ingreso_lista($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE registro_ingreso_ls SET estado=4,fec_eli=GETDATE(),user_eli=$id_usuario
                WHERE id_registro_ingreso='" . $dato['id_registro_ingreso'] . "'";
    $this->db5->query($sql);
  }
  //-----------------------------------PUBLICIDAD-------------------------------------
  function get_list_publicidad($id_proyecto = null)
  {
    if (isset($id_proyecto) && $id_proyecto > 0) {
      $sql = "SELECT * FROM publicidad 
                    WHERE id_proyecto=$id_proyecto";
    } else {
      $sql = "SELECT pr.id_proyecto,em.cod_empresa,cod_proyecto,ti.nom_tipo,st.nom_subtipo,
                    pr.descripcion,CASE WHEN SUBSTRING(pr.fec_agenda,1,1)!='0' THEN 
                    DATE_FORMAT(pr.fec_agenda,'%d/%m/%Y') ELSE '' END AS agenda,pu.campania,
                    CASE WHEN pu.tipo=1 THEN 'Whatsapp' WHEN pu.tipo=2 THEN 'Mensaje' 
                    WHEN pu.tipo=3 THEN 'Me Gusta' WHEN pu.tipo=4 THEN 'Otro' ELSE '' END AS tipo,
                    CASE WHEN SUBSTRING(pu.del_dia,1,1)!='0' THEN DATE_FORMAT(pu.del_dia,'%d/%m/%Y') 
                    ELSE '' END AS del_dia,
                    CASE WHEN SUBSTRING(pu.hasta,1,1)!='0' THEN DATE_FORMAT(pu.hasta,'%d/%m/%Y') 
                    ELSE '' END AS hasta,TIMESTAMPDIFF(DAY, pu.del_dia, pu.hasta) AS dias,pu.alcance,
                    pu.interacciones,CASE WHEN pu.monto>0 THEN CONCAT('$ ',pu.monto) ELSE '' END AS monto,
                    pu.monto AS monto_excel
                    FROM proyecto pr
                    LEFT JOIN empresa em ON pr.id_empresa=em.id_empresa
                    LEFT JOIN tipo ti ON pr.id_tipo=ti.id_tipo
                    LEFT JOIN subtipo st ON pr.id_subtipo=st.id_subtipo
                    LEFT JOIN publicidad pu ON pr.id_proyecto=pu.id_proyecto
                    WHERE pr.publicidad_pagada=1";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_publicidad($dato)
  {
    $sql = "SELECT id FROM publicidad 
                WHERE id_proyecto='" . $dato['id_proyecto'] . "' AND estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_publicidad($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO publicidad (id_proyecto,campania,tipo,del_dia,hasta,alcance,interacciones,monto,
                estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES ('" . $dato['id_proyecto'] . "','" . $dato['campania'] . "','" . $dato['tipo'] . "',
                '" . $dato['del_dia'] . "','" . $dato['hasta'] . "','" . $dato['alcance'] . "',
                '" . $dato['interacciones'] . "','" . $dato['monto'] . "',2,NOW(),$id_usuario,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_publicidad($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE publicidad SET campania='" . $dato['campania'] . "',
                tipo='" . $dato['tipo'] . "',del_dia='" . $dato['del_dia'] . "',hasta='" . $dato['hasta'] . "',
                alcance='" . $dato['alcance'] . "',interacciones='" . $dato['interacciones'] . "',
                monto='" . $dato['monto'] . "',fec_act=NOW(),user_act=$id_usuario  
                WHERE id_proyecto='" . $dato['id_proyecto'] . "'";
    $this->db->query($sql);
  }
  //-----------------------------------RRHH CONFIGURACIÓN-------------------------------------
  function get_list_rrhh_configuracion($id = null)
  {
    if (isset($id)) {
      $sql = "SELECT * FROM rrhh_configuracion 
                    WHERE id=$id";
    } else {
      $sql = "SELECT id,nombre,monto,CASE WHEN tipo_descuento=1 THEN '%' 
                    WHEN tipo_descuento=2 THEN 'Fijo' ELSE '' END AS tipo_descuento
                    FROM rrhh_configuracion
                    WHERE estado=2";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function valida_rrhh_configuracion($id = null, $dato = null)
  {
    $parte = "";
    if (isset($id)) {
      $parte = " AND id!=$id";
    }
    $sql = "SELECT id FROM rrhh_configuracion 
                WHERE nombre='" . $dato['nombre'] . "' AND tipo_descuento='" . $dato['tipo_descuento'] . "' AND 
                monto='" . $dato['monto'] . "' AND estado=2 $parte";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_rrhh_configuracion($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO rrhh_configuracion (nombre,tipo_descuento,monto,estado,fec_reg,user_reg,fec_act,
                user_act) 
                VALUES ('" . $dato['nombre'] . "','" . $dato['tipo_descuento'] . "','" . $dato['monto'] . "',2,NOW(),
                $id_usuario,NOW(),$id_usuario)";
    $this->db->query($sql);
  }

  function update_rrhh_configuracion($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE rrhh_configuracion SET nombre='" . $dato['nombre'] . "',
              tipo_descuento='" . $dato['tipo_descuento'] . "',monto='" . $dato['monto'] . "',fec_act=NOW(),
              user_act=$id_usuario
              WHERE id='" . $dato['id'] . "'";
    $this->db->query($sql);
  }

  function delete_rrhh_configuracion($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE rrhh_configuracion SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
              WHERE id='" . $dato['id'] . "'";
    $this->db->query($sql);
  }
  //-----------------------------------PLANILLA-------------------------------------
  function get_datos_sede($id_sede)
  {
    $sql = "SELECT * FROM sede 
              WHERE id_sede=$id_sede";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_planilla($id = null, $id_sede = null)
  {
    if (isset($id)) {
      $sql = "SELECT ps.id,ps.id_sede,me.nom_mes AS mes,ps.anio,
                  DATE_FORMAT(ps.fec_reg,'%d-%m-%Y') AS fecha,us.usuario_codigo AS usuario
                  FROM planilla_sede ps
                  LEFT JOIN mes me ON ps.mes=me.cod_mes
                  LEFT JOIN users us ON ps.user_reg=us.id_usuario
                  WHERE ps.id=$id";
    } else {
      $sql = "SELECT ps.id,me.nom_mes AS mes,ps.anio,
                  DATE_FORMAT(ps.fec_reg,'%d-%m-%Y') AS fecha,us.usuario_codigo AS usuario
                  FROM planilla_sede ps
                  LEFT JOIN mes me ON ps.mes=me.cod_mes
                  LEFT JOIN users us ON ps.user_reg=us.id_usuario
                  WHERE ps.id_sede=$id_sede AND ps.estado=2";
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_list_colaborador_planilla($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    /*$sql = "SELECT cc.id_contrato,co.apellido_paterno,apellido_materno,co.nombres,co.codigo_gll,pe.nom_perfil,
            tc.nombre AS nom_contrato,
            CASE WHEN tc.nombre='Recibo Honorarios' THEN 
              CASE WHEN (SELECT COUNT(1) FROM temporal_planilla tp
              WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador AND 
              tp.tipo IN (4,5))>0 THEN
                (SELECT CONCAT('S/. ',SUM(tp.monto)*cc.sueldo1) FROM temporal_planilla tp
                WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador 
                AND tp.tipo IN (4,5)) 
              ELSE CONCAT('S/. ',cc.sueldo1) END
            ELSE CONCAT('S/. ',cc.sueldo1) END AS sueldo_bruto,
            CASE WHEN tc.nombre IN ('Planilla AFP Habitat','Planilla AFP Integra','Planilla AFP Prima',
            'Planilla AFP Profuturo','Planilla ONP') THEN 
              CONCAT('S/. ',cc.sueldo1) 
            ELSE '' END AS planilla,
            CASE WHEN (SELECT COUNT(1) FROM temporal_planilla tp
            WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador AND tp.tipo=1)>0 THEN
              (SELECT CONCAT('S/. ',SUM(tp.monto)) FROM temporal_planilla tp
              WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador 
              AND tp.tipo=1) 
            ELSE '' END AS incentivo,
            CASE WHEN (SELECT COUNT(1) FROM temporal_planilla tp
            WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador AND tp.tipo=2)>0 THEN
              (SELECT CONCAT('S/. ',SUM(tp.monto)) FROM temporal_planilla tp
              WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador 
              AND tp.tipo=2) 
            ELSE '' END AS deduccion,
            CASE WHEN (SELECT COUNT(1) FROM temporal_planilla tp
              WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador AND tp.tipo=3)>0 THEN 
              (SELECT CONCAT('S/. ',tp.monto) FROM temporal_planilla tp
              WHERE tp.id_usuario=$id_usuario AND tp.id_colaborador=cc.id_colaborador AND tp.tipo=3
              ORDER BY tp.id DESC
              LIMIT 1) 
            ELSE '' END AS falta,
            CASE WHEN tc.nombre='Planilla ONP' THEN 
              (CASE WHEN (SELECT COUNT(1) FROM contribucion_rrhh cr
              WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)>0 THEN
                (CASE WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)=1 THEN 
                  CONCAT('S/. ',ROUND((SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)*cc.sueldo1/100,2))
                WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)=2 THEN 
                  CONCAT('S/. ',(SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2))
                ELSE '' END)
              ELSE '' END)
            ELSE '' END AS onp,
            CASE WHEN tc.nombre IN ('Planilla AFP Habitat','Planilla AFP Integra','Planilla AFP Prima','Planilla AFP Profuturo') THEN 
              (CASE WHEN (SELECT COUNT(1) FROM contribucion_rrhh cr
              WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)>0 THEN
                (CASE WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)=1 THEN 
                  CONCAT('S/. ',ROUND((SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)*cc.sueldo1/100,2))
                WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2)=2 THEN 
                  CONCAT('S/. ',(SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=1 AND cr.estado=2))
                ELSE '' END)
              ELSE '' END)
            ELSE '' END AS afp_aporte,
            CASE WHEN tc.nombre IN ('Planilla AFP Habitat','Planilla AFP Integra','Planilla AFP Prima','Planilla AFP Profuturo') THEN 
              (CASE WHEN (SELECT COUNT(1) FROM contribucion_rrhh cr
              WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=2 AND cr.estado=2)>0 THEN
                (CASE WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=2 AND cr.estado=2)=1 THEN 
                  CONCAT('S/. ',ROUND((SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=2 AND cr.estado=2)*cc.sueldo1/100,2))
                WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=2 AND cr.estado=2)=2 THEN 
                  CONCAT('S/. ',(SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=2 AND cr.estado=2))
                ELSE '' END)
              ELSE '' END)
            ELSE '' END AS prima_seguro,
            CASE WHEN tc.nombre IN ('Planilla AFP Habitat','Planilla AFP Integra','Planilla AFP Prima','Planilla AFP Profuturo') THEN 
              (CASE WHEN (SELECT COUNT(1) FROM contribucion_rrhh cr
              WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=3 AND cr.estado=2)>0 THEN
                (CASE WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=3 AND cr.estado=2)=1 THEN 
                  CONCAT('S/. ',ROUND((SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=3 AND cr.estado=2)*cc.sueldo1/100,2))
                WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=3 AND cr.estado=2)=2 THEN 
                  CONCAT('S/. ',(SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=3 AND cr.estado=2))
                ELSE '' END)
              ELSE '' END)
            ELSE '' END AS afp_comision,
            CASE WHEN tc.nombre IN ('Planilla AFP Habitat','Planilla AFP Integra','Planilla AFP Prima','Planilla AFP Profuturo','Planilla ONP') THEN 
              (CASE WHEN (SELECT COUNT(1) FROM contribucion_rrhh cr
              WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=4 AND cr.estado=2)>0 THEN
                (CASE WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=4 AND cr.estado=2)=1 THEN 
                  CONCAT('S/. ',ROUND((SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=4 AND cr.estado=2)*cc.sueldo1/100,2))
                WHEN (SELECT cr.tipo_descuento FROM contribucion_rrhh cr
                WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=4 AND cr.estado=2)=2 THEN 
                  CONCAT('S/. ',(SELECT cr.monto FROM contribucion_rrhh cr
                  WHERE cr.id_tipo_contrato=cc.id_tipo_contrato1 AND cr.tipo_contribucion=4 AND cr.estado=2))
                ELSE '' END)
              ELSE '' END)
            ELSE '' END AS essalud
            FROM contrato_colaborador cc
            LEFT JOIN colaborador co ON cc.id_colaborador=co.id_colaborador
            LEFT JOIN tipo_contrato_rrhh tc ON cc.id_tipo_contrato1=tc.id
            LEFT JOIN perfil pe ON co.id_perfil=pe.id_perfil
            WHERE co.id_sede=".$dato['id_sede']." AND co.fecha_validacion IS NOT NULL AND co.estado=2 AND 
            (CASE WHEN SUBSTRING(cc.fin_funciones,1,1)='2' THEN
            '".$dato['anio']."-".$dato['mes']."-01' BETWEEN cc.inicio_funciones AND cc.fin_funciones 
            ELSE cc.inicio_funciones<='".$dato['anio']."-".$dato['mes']."-01' END) AND cc.id_tipo_contrato1>0 AND 
            cc.estado_contrato=2 AND cc.estado=2";*/

      $sql = "SELECT cc.id_contrato,co.apellido_paterno,apellido_materno,co.nombres,co.codigo_gll,pe.nom_perfil,
            tc.nombre AS nom_contrato,
            CONCAT('S/. ',sueldo_bruto_planilla(cc.id_contrato,$id_usuario)) AS sueldo_bruto,
            CONCAT('S/. ',planilla(cc.id_contrato)) AS planilla,
            CONCAT('S/. ',otros_planilla(cc.id_contrato,$id_usuario,1)) AS incentivo,
            CONCAT('S/. ',otros_planilla(cc.id_contrato,$id_usuario,2)) AS deduccion,
            CONCAT('S/. ',otros_planilla(cc.id_contrato,$id_usuario,3)) AS falta,
            CONCAT('S/. ',onp_planilla(cc.id_contrato)) AS onp,
            CONCAT('S/. ',afp_aporte_planilla(cc.id_contrato)) AS afp_aporte,
            CONCAT('S/. ',prima_seguro_planilla(cc.id_contrato)) AS prima_seguro,
            CONCAT('S/. ',afp_comision_planilla(cc.id_contrato)) AS afp_comision,
            CONCAT('S/. ',essalud_planilla(cc.id_contrato)) AS essalud,
            CONCAT('S/. ',( sueldo_bruto_planilla(cc.id_contrato,$id_usuario)+
            otros_planilla(cc.id_contrato,$id_usuario,1)-otros_planilla(cc.id_contrato,$id_usuario,2)-
            otros_planilla(cc.id_contrato,$id_usuario,3)-onp_planilla(cc.id_contrato)-
            afp_aporte_planilla(cc.id_contrato)-prima_seguro_planilla(cc.id_contrato)-
            afp_comision_planilla(cc.id_contrato)-essalud_planilla(cc.id_contrato) )) AS liquido_pagar
            FROM contrato_colaborador cc
            LEFT JOIN colaborador co ON cc.id_colaborador=co.id_colaborador
            LEFT JOIN tipo_contrato_rrhh tc ON cc.id_tipo_contrato1=tc.id
            LEFT JOIN perfil pe ON co.id_perfil=pe.id_perfil
            WHERE co.id_sede=".$dato['id_sede']." AND co.fecha_validacion IS NOT NULL AND co.estado=2 AND 
            (CASE WHEN SUBSTRING(cc.fin_funciones,1,1)='2' THEN
            '".$dato['anio']."-".$dato['mes']."-01' BETWEEN cc.inicio_funciones AND cc.fin_funciones 
            ELSE cc.inicio_funciones<='".$dato['anio']."-".$dato['mes']."-01' END) AND cc.id_tipo_contrato1>0 AND 
            cc.estado_contrato=2 AND cc.estado=2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_id_contrato_colaborador($id_contrato){
    $sql = "SELECT cc.*,tc.nombre AS nom_contrato 
            FROM contrato_colaborador cc
            LEFT JOIN tipo_contrato_rrhh tc ON cc.id_tipo_contrato1=tc.id
            WHERE cc.id_contrato=$id_contrato";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function delete_modal_temporal_planilla($id=null,$id_colaborador=null){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if(isset($id)){
      $sql = "DELETE FROM temporal_modal_planilla
              WHERE id=$id";
    }else{
      $sql = "DELETE FROM temporal_modal_planilla
              WHERE id_usuario=$id_usuario AND id_colaborador=$id_colaborador";
    }
    $this->db->query($sql);
  }
  
  function get_list_temporal_modal_planilla($id=null,$dato=null){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if (isset($id)) {
      $sql = "SELECT * FROM temporal_modal_planilla
              WHERE id=$id";
    }else{
      $sql = "SELECT * FROM temporal_modal_planilla
              WHERE id_usuario=$id_usuario AND id_colaborador=".$dato['id_colaborador']." AND 
              tipo=".$dato['tipo'];
    }
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_temporal_modal_planilla($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO temporal_modal_planilla (id_usuario,id_colaborador,tipo,descripcion,monto) 
            VALUES ($id_usuario,'".$dato['id_colaborador']."','".$dato['tipo']."','".$dato['descripcion']."',
            '".$dato['monto']."')";
    $this->db->query($sql);
  }

  function insert_temporal_planilla($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO temporal_planilla (id_usuario,id_colaborador,tipo,descripcion,monto) 
            VALUES ($id_usuario,'".$dato['id_colaborador']."','".$dato['tipo']."','".$dato['descripcion']."',
            '".$dato['monto']."')";
    $this->db->query($sql);
  }

  function insert_select_temporal_planilla($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO temporal_planilla (id_usuario,id_colaborador,tipo,descripcion,monto) 
            SELECT id_usuario,id_colaborador,tipo,descripcion,monto FROM temporal_modal_planilla
            WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
    $sql = "DELETE FROM temporal_modal_planilla
            WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
  }

  function delete_temporal_planilla(){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "DELETE FROM temporal_planilla
            WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
    $sql = "DELETE FROM temporal_modal_planilla
        WHERE id_usuario=$id_usuario";
    $this->db->query($sql);
  }

  function valida_planilla($id = null, $dato = null){
    $parte = "";
    if (isset($id)) {
      $parte = " AND id!=$id";
    }
    $sql = "SELECT id FROM planilla_sede
                WHERE id_sede='" . $dato['id_sede'] . "' AND mes='" . $dato['mes'] . "' AND 
                anio='" . $dato['anio'] . "' AND estado=2 $parte";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function insert_planilla($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "INSERT INTO planilla_sede (id_sede,mes,anio,estado,fec_reg,user_reg,fec_act,user_act) 
              VALUES ('" . $dato['id_sede'] . "','" . $dato['mes'] . "','" . $dato['anio'] . "',2,NOW(),$id_usuario,NOW(),
              $id_usuario)";
    $this->db->query($sql);
  }

  function delete_planilla($dato)
  {
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $sql = "UPDATE planilla_sede SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
            WHERE id='" . $dato['id'] . "'";
    $this->db->query($sql);
  }

  //-----------------------------------PLANILLA-------------------------------------
  function get_list_archivo($tipo){
    $parte = "";
    if ($tipo == 1) {
      $parte = "AND RIGHT(tf.Codigo, 2) != '''C'";
    }else if ($tipo == 2) {
      $parte = "AND RIGHT(tf.Codigo, 2) = '''C'";
    }else{
      $parte = "AND da.estado=4 AND da.id_empresa =1";
    }
    $sql = "SELECT de.id_detalle, em.cod_empresa, se.cod_sede, da.cod_documento, da.nom_documento, tf.Codigo, de.archivo, de.id_alumno,
            CASE WHEN da.id_empresa IN (3,11) THEN al.alum_nom 
            WHEN da.id_empresa = 5 THEN au.alum_nom
            WHEN da.id_empresa = 6 THEN tf.Nombre 
            WHEN da.id_empresa = 2 THEN tl.Nombre
            WHEN da.id_empresa = 4 THEN ts.Nombre ELSE '' END AS nombre,
            CASE WHEN da.id_empresa IN (3,11) THEN al.alum_apater 
            WHEN da.id_empresa = 5 THEN au.alum_apater
            WHEN da.id_empresa = 6 THEN tf.Apellido_Paterno 
            WHEN da.id_empresa = 2 THEN tl.Apellido_Paterno
            WHEN da.id_empresa = 4 THEN ts.Apellido_Paterno ELSE '' END AS apellido_paterno,
            CASE WHEN da.id_empresa IN (3,11) THEN al.alum_amater 
            WHEN da.id_empresa = 5 THEN au.alum_amater
            WHEN da.id_empresa = 6 THEN tf.Apellido_Materno 
            WHEN da.id_empresa = 2 THEN tl.Apellido_Materno
            WHEN da.id_empresa = 4 THEN ts.Apellido_Materno ELSE '' END AS apellido_materno,
            CASE WHEN aog.estado = 3 THEN 'Rechazado'
            ELSE 'Pendiente' END AS nom_estado,
            CASE WHEN aog.estado = 3 THEN '#C70039'
            ELSE '#FF8000' END AS color_estado,
            CONCAT((SELECT url_config FROM config WHERE id_config = 1), de.archivo) AS archivo,
            CASE WHEN vd.fecha IS NULL THEN '' ELSE vd.fecha END AS fecha, us.usuario_codigo AS usuario
            FROM detalle_alumno_empresa de
            LEFT JOIN documento_alumno_empresa da ON de.id_documento = da.id_documento AND da.estado = 2
            LEFT JOIN empresa em ON da.id_empresa = em.id_empresa
            LEFT JOIN sede se ON da.id_sede = se.id_sede
            LEFT JOIN alumno al ON de.id_alumno = al.id_alumno
            LEFT JOIN alumnos au ON de.id_alumno = au.id_alumno
            LEFT JOIN todos_l20 tf ON de.id_alumno = tf.Id
            LEFT JOIN todos_ll tl ON de.id_alumno = tl.Id
            LEFT JOIN todos_ls ts ON de.id_alumno = ts.Id
            LEFT JOIN validacion_documento vd ON de.id_detalle = vd.id_detalle AND vd.estado_v = 1
            LEFT JOIN alumno_observaciones_general aog ON de.id_detalle = aog.id_detalle
            LEFT JOIN users us ON vd.usuario = us.id_usuario
            WHERE de.archivo != '' AND da.estado = 2 AND de.estado = 2 AND vd.id_detalle IS NULL ". $parte;
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function validar_archivo($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    $query = $this->db->query("SELECT id_detalle FROM alumno_observaciones_general WHERE id_detalle = '" . $dato['id_detalle'] . "'");
    $dato_ex = $query->row_array();
    
    if ($dato_ex){
      $sql_1 = "UPDATE alumno_observaciones_general SET estado = 2, fec_act = NOW(), user_act = $id_usuario
                  WHERE id_detalle = '" . $dato['id_detalle'] . "'";
      $this->db->query($sql_1);

      $sql_2 = "INSERT INTO validacion_documento (codigo_documento, id_detalle, id_postulante, archivo, fecha, usuario, estado_v, estado, fec_reg, user_reg, fec_act, user_act)
                VALUES ('" . $dato['codigo_documento'] . "','" . $dato['id_detalle'] . "',0,'" . $dato['archivo'] . "', CURDATE(), $id_usuario, 1, 2, NOW(), $id_usuario, NOW(), $id_usuario)";
      $this->db->query($sql_2);

    }else{
       $sql = "INSERT INTO validacion_documento (codigo_documento, id_detalle, id_postulante, archivo, fecha, usuario, estado_v, estado, fec_reg, user_reg, fec_act, user_act)
                VALUES ('" . $dato['codigo_documento'] . "','" . $dato['id_detalle'] . "',0,'" . $dato['archivo'] . "', CURDATE(), $id_usuario, 1, 2, NOW(), $id_usuario, NOW(), $id_usuario)";
        $this->db->query($sql);
    }
  }

  function insert_rechazar_archivo($dato){
    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    if ($dato['id_empresa'] == 5){
      $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_sede,id_alumno,id_tipo,observacion,fecha_obs,usuario_obs,observacion_archivo,id_detalle,estado,fec_reg,user_reg)
            VALUES ('" . $dato['id_empresa'] . "','" . $dato['id_sede'] . "','" . $dato['id_alumno'] . "','" . $dato['id_tipo'] . "','" . $dato['observacion'] . "'
            ,CURDATE(),$id_usuario,'" . $dato['archivo'] . "','" . $dato['id_detalle'] . "',3,NOW(),$id_usuario)";
    }else{
    $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_sede,id_alumno,id_tipo,observacion,fecha_obs,usuario_obs,observacion_archivo,id_detalle,estado,fec_reg,user_reg)
            VALUES ('" . $dato['id_empresa'] . "',0,'" . $dato['id_alumno'] . "','" . $dato['id_tipo'] . "','" . $dato['observacion'] . "'
            ,CURDATE(),$id_usuario,'" . $dato['archivo'] . "','" . $dato['id_detalle'] . "',3,NOW(),$id_usuario)";
    }
    $this->db->query($sql);
  }

  function ultimo_cod_archivo($anio){
    $sql = "SELECT codigo_documento FROM validacion_documento WHERE YEAR(fecha)='" . $anio . "' AND estado = 2";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_alumno($dato){
    $sql = "SELECT id_empresa FROM todos_l20 WHERE Id='" . $dato['id_alumno'] . "'";
    $query = $this->db->query($sql)->result_Array();
    return $query;
  }

  function get_archivo_detalle($id_detalle) {
    $sql = "SELECT archivo FROM detalle_alumno_empresa WHERE id_detalle = $id_detalle";
    $query = $this->db->query($sql)->row_array();
    return $query;
  }

  function get_list_archivo_busqueda($anio, $id_empresa, $tipo){
    if ($tipo == '1') {
      $sql = "SELECT de.id_detalle, em.cod_empresa, se.cod_sede, da.cod_documento, da.nom_documento, tf.Codigo, de.archivo, de.id_alumno,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_nom 
              WHEN da.id_empresa = 5 THEN au.alum_nom
              WHEN da.id_empresa = 6 THEN tf.Nombre 
              WHEN da.id_empresa = 2 THEN tl.Nombre
              WHEN da.id_empresa = 4 THEN ts.Nombre ELSE '' END AS nombre,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_apater 
              WHEN da.id_empresa = 5 THEN au.alum_apater
              WHEN da.id_empresa = 6 THEN tf.Apellido_Paterno 
              WHEN da.id_empresa = 2 THEN tl.Apellido_Paterno
              WHEN da.id_empresa = 4 THEN ts.Apellido_Paterno ELSE '' END AS apellido_paterno,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_amater 
              WHEN da.id_empresa = 5 THEN au.alum_amater
              WHEN da.id_empresa = 6 THEN tf.Apellido_Materno 
              WHEN da.id_empresa = 2 THEN tl.Apellido_Materno
              WHEN da.id_empresa = 4 THEN ts.Apellido_Materno ELSE '' END AS apellido_materno,
              CASE WHEN vd.estado = 2 THEN 'Validado'
              WHEN aog.estado = 3 THEN 'Rechazado'
              ELSE 'Pendiente' END AS nom_estado,
              CASE WHEN vd.estado = 2 THEN '#92D050'
              WHEN aog.estado = 3 THEN '#C70039'
              ELSE '#FF8000' END AS color_estado,
              CONCAT((SELECT url_config FROM config WHERE id_config = 1), de.archivo) AS archivo,
              CASE WHEN vd.fecha IS NULL THEN '' ELSE vd.fecha END AS fecha, us.usuario_codigo AS usuario
              FROM detalle_alumno_empresa de
              LEFT JOIN documento_alumno_empresa da ON de.id_documento = da.id_documento AND da.estado = 2
              LEFT JOIN empresa em ON da.id_empresa = em.id_empresa
              LEFT JOIN sede se ON da.id_sede = se.id_sede
              LEFT JOIN alumno al ON de.id_alumno = al.id_alumno
              LEFT JOIN alumnos au ON de.id_alumno = au.id_alumno
              LEFT JOIN todos_l20 tf ON de.id_alumno = tf.Id
              LEFT JOIN todos_ll tl ON de.id_alumno = tl.Id
              LEFT JOIN todos_ls ts ON de.id_alumno = ts.Id
              LEFT JOIN validacion_documento vd ON de.id_detalle = vd.id_detalle AND vd.estado_v = 1
              LEFT JOIN alumno_observaciones_general aog ON de.id_detalle = aog.id_detalle
              LEFT JOIN users us ON vd.usuario = us.id_usuario
              WHERE de.archivo != '' AND da.estado = 2 AND de.estado = 2 AND YEAR(de.fec_reg) = $anio AND de.id_empresa = $id_empresa
              AND RIGHT(tf.Codigo, 2) != '''C'";

        $query = $this->db->query($sql)->result_Array();
        return $query;

    } elseif ($tipo == '2') {
      $sql = "SELECT de.id_detalle, em.cod_empresa, se.cod_sede, da.cod_documento, da.nom_documento, tf.Codigo, de.archivo, de.id_alumno,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_nom 
              WHEN da.id_empresa = 5 THEN au.alum_nom
              WHEN da.id_empresa = 6 THEN tf.Nombre 
              WHEN da.id_empresa = 2 THEN tl.Nombre
              WHEN da.id_empresa = 4 THEN ts.Nombre ELSE '' END AS nombre,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_apater 
              WHEN da.id_empresa = 5 THEN au.alum_apater
              WHEN da.id_empresa = 6 THEN tf.Apellido_Paterno 
              WHEN da.id_empresa = 2 THEN tl.Apellido_Paterno
              WHEN da.id_empresa = 4 THEN ts.Apellido_Paterno ELSE '' END AS apellido_paterno,
              CASE WHEN da.id_empresa IN (3,11) THEN al.alum_amater 
              WHEN da.id_empresa = 5 THEN au.alum_amater
              WHEN da.id_empresa = 6 THEN tf.Apellido_Materno 
              WHEN da.id_empresa = 2 THEN tl.Apellido_Materno
              WHEN da.id_empresa = 4 THEN ts.Apellido_Materno ELSE '' END AS apellido_materno,
              CASE WHEN vd.estado = 2 THEN 'Validado'
              WHEN aog.estado = 3 THEN 'Rechazado'
              ELSE 'Pendiente' END AS nom_estado,
              CASE WHEN vd.estado = 2 THEN '#92D050'
              WHEN aog.estado = 3 THEN '#C70039'
              ELSE '#FF8000' END AS color_estado,
              CONCAT((SELECT url_config FROM config WHERE id_config = 1), de.archivo) AS archivo,
              CASE WHEN vd.fecha IS NULL THEN '' ELSE vd.fecha END AS fecha, us.usuario_codigo AS usuario
              FROM detalle_alumno_empresa de
              LEFT JOIN documento_alumno_empresa da ON de.id_documento = da.id_documento AND da.estado = 2
              LEFT JOIN empresa em ON da.id_empresa = em.id_empresa
              LEFT JOIN sede se ON da.id_sede = se.id_sede
              LEFT JOIN alumno al ON de.id_alumno = al.id_alumno
              LEFT JOIN alumnos au ON de.id_alumno = au.id_alumno
              LEFT JOIN todos_l20 tf ON de.id_alumno = tf.Id
              LEFT JOIN todos_ll tl ON de.id_alumno = tl.Id
              LEFT JOIN todos_ls ts ON de.id_alumno = ts.Id
              LEFT JOIN validacion_documento vd ON de.id_detalle = vd.id_detalle AND vd.estado_v = 1
              LEFT JOIN alumno_observaciones_general aog ON de.id_detalle = aog.id_detalle
              LEFT JOIN users us ON vd.usuario = us.id_usuario
              WHERE de.archivo != '' AND da.estado = 2 AND de.estado = 2 AND YEAR(de.fec_reg) = $anio AND de.id_empresa = $id_empresa
              AND RIGHT(tf.Codigo, 2) = '''C'";

          $query = $this->db->query($sql)->result_Array();
          return $query;

    } elseif ($tipo == '3') {
      $sql = "SELECT de.id_detalle as id_detalle, em.cod_empresa, se.cod_sede, de.cod_documento, dp.nom_documento,
                      ad.codigo_admision, de.archivo AS archivo, de.id_postulante as id_postulante,de.id_documento,de.flag_doc as flag_doc,
                      ad.alum_nombre_admision AS nombre,
                      ad.alum_apepat_admision AS apellido_paterno,
                      ad.alum_apemat_admision AS apellido_materno,
                      CASE WHEN de.flag_doc = 3 THEN 'Rechazado'
                          WHEN de.flag_doc = 2 THEN 'Validado'
                          ELSE 'Pendiente' END AS nom_estado,
                      CASE WHEN de.flag_doc = 3 THEN '#C70039'
                          WHEN de.flag_doc = 2 THEN '#92D050'
                          ELSE '#FF8000' END AS color_estado,
                      CASE WHEN de.fec_subido IS NULL THEN '' ELSE CONVERT(VARCHAR, de.fec_subido, 120) END AS fecha,
                      us.usuario_codigo AS usuario
                FROM detalle_postulante_empresa de 
                LEFT JOIN documento_postulante_empresa dp ON de.id_documento = dp.id_documento AND dp.estado = 2
                LEFT JOIN empresa em ON de.id_empresa = em.id_empresa
                LEFT JOIN sede se ON de.id_sede = se.id_sede
                LEFT JOIN admision ad ON de.id_postulante = ad.id_admision
                LEFT JOIN users us ON de.user_subido = us.id_usuario
                WHERE de.archivo != '' AND de.estado = 2 AND YEAR(de.fec_reg) = $anio AND de.id_empresa = $id_empresa";

          $query = $this->db6->query($sql)->result_Array();
          return $query;
    }
  }


// ---------------------- lISTA DE FOTOCHECKS DE GLOBALLEADERS --------------------------------------

    function get_list_fotocheck($tipo){
        $parte = " f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if($tipo==1){
            $parte = "f.esta_fotocheck NOT IN (2,3,99)";
        }
        $sql = "SELECT f.*,DATE_FORMAT(f.Fecha_Pago_Fotocheck, '%d/%m/%Y') as Pago_Fotocheck,tl.id_colaborador,
                tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll, tl.codigo_glla,
                DATE_FORMAT(f.fecha_envio, '%d/%m/%Y') as fecha_envio,
                f.usuario_encomienda,f.cargo_envio,
                DATE_FORMAT(f.fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,f.usuario_foto,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_encomienda=us.id_usuario) as usuario_codigo,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_foto=us.id_usuario) as usuario_foto,
                (SELECT car.cod_cargo FROM cargo car 
                WHERE car.id_cargo=f.cargo_envio) as cargo_envio,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN 'Foto Rec' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN 'Impreso'
                WHEN f.esta_fotocheck=2 THEN 'Enviado' 
                WHEN f.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN '#92D050' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN '#F18A00'
                WHEN f.esta_fotocheck=2 THEN '#0070c0' 
                WHEN f.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck,
                f.esta_fotocheck AS estado_fotocheck
                FROM fotocheck_gl f
                LEFT JOIN colaborador tl ON f.Id=tl.id_colaborador
                WHERE $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
        //echo $query;
        return $query;
    }

    function get_id_fotocheck($id_fotocheck){
        $sql = "SELECT fo.*,CASE WHEN fo.esta_fotocheck=1 THEN 'Foto Rec' WHEN fo.esta_fotocheck=2 THEN 'Enviado' 
                WHEN fo.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN fo.esta_fotocheck=1 THEN '#92D050' WHEN fo.esta_fotocheck=2 THEN '#0070c0' 
                WHEN fo.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck, 
                DATE_FORMAT(fo.fecha_recepcion, '%d/%m/%Y') AS fecha_recepcion,
                DATE_FORMAT(fo.fecha_recepcion_2, '%d/%m/%Y') AS fecha_recepcion_2,
                DATE_FORMAT(fo.fecha_recepcion_3, '%d/%m/%Y') AS fecha_recepcion_3,
                DATE_FORMAT(fo.fecha_envio, '%d/%m/%Y') AS fecha_envio,
                uf.usuario_codigo AS usuario_foto,
                DATE_FORMAT(fo.fecha_anulado, '%d/%m/%Y') AS fecha_anulado,
                ua.usuario_codigo AS usuario_anulado,ud.usuario_codigo AS usuario_foto_2,
                ut.usuario_codigo AS usuario_foto_3,ue.usuario_codigo AS usuario_encomienda,
                ca.cod_cargo AS cargo_envio,
                SUBSTRING_INDEX(foto_fotocheck,'/',-1) AS nom_foto_fotocheck,
                SUBSTRING_INDEX(foto_fotocheck_2,'/',-1) AS nom_foto_fotocheck_2,
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3
                ,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll,tl.codigo_glla,
                YEAR(fo.fecha_fotocheck) AS anio_fotocheck,MONTH(fo.fecha_fotocheck) AS mes_fotocheck,
                case when length(concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno)) > 18 then 
                concat(tl.Apellido_Paterno,' ',substring(tl.Apellido_Materno,1,1),'.')else concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno) end as apellidos,
                IF(LENGTH(tl.nombres) > 20, CONCAT(SUBSTRING(tl.nombres, 1, 20),'.'),tl.nombres) AS Nombre_corto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio
                FROM fotocheck_gl fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN colaborador tl ON tl.id_colaborador=fo.Id
                WHERE fo.id_fotocheck=$id_fotocheck";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_documento_colaborador($cod_documento){
        $sql = "SELECT id_documento FROM documento_colaborador_empresa 
                WHERE id_empresa=1 AND cod_documento='$cod_documento' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_foto_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $estado = "";
        if($dato['n_foto']==1){
            $foto_fotocheck = "foto_fotocheck";
            $usuario_foto = "usuario_foto";
            $fecha_recepcion = "fecha_recepcion";
        }else{
            if($dato['n_foto']==2){
                $estado="esta_fotocheck=1,";
            }
            $foto_fotocheck = "foto_fotocheck_".$dato['n_foto'];
            $usuario_foto = "usuario_foto_".$dato['n_foto'];
            $fecha_recepcion = "fecha_recepcion_".$dato['n_foto'];
        }
        $sql = "UPDATE fotocheck_gl SET $foto_fotocheck='".$dato[$foto_fotocheck]."',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function get_detalle_colaborador_empresa($id_colaborador,$id_documento){
        $sql = "SELECT id_detalle FROM detalle_colaborador_empresa 
                WHERE id_colaborador=$id_colaborador AND id_documento=$id_documento AND estado=2
                ORDER BY id_detalle DESC";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_colaborador_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        echo $sql;
        $this->db->query($sql);
    }

    function valida_fotocheck_completo($id_fotocheck){
        $sql = "SELECT id_fotocheck FROM fotocheck_gl 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_fotocheck_completo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_gl SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function impresion_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_gl SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function anular_envio($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE fotocheck_gl SET esta_fotocheck=3,obs_anulado='".$dato['obs_anulado']."',usuario_anulado=$id_usuario,fecha_anulado=NOW(),user_act=$id_usuario 
        WHERE id_fotocheck='".$dato['id_fotocheck']."'";

        $this->db->query($sql);
    }

    function get_id_user(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM users where id_usuario='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cargo_x_id($id_usuario_de){
        $sql = "SELECT * FROM (SELECT * FROM cargo where id_usuario_de=$id_usuario_de ORDER BY cod_cargo DESC LIMIT 10) AS cargo ORDER BY cod_cargo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function update_envio_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_gl SET fecha_envio='".$dato['fecha_envio']."',
                    usuario_encomienda='".$dato['usuario_encomienda']."',
                    cargo_envio='".$dato['cargo_envio']."',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function get_list_archivo_postulante(){ 
      $sql = "SELECT de.id_detalle as id_detalle, em.cod_empresa, se.cod_sede, de.cod_documento, dp.nom_documento,
                    ad.codigo_admision, de.archivo AS archivo, de.id_postulante as id_postulante,de.id_documento,de.flag_doc as flag_doc,
                    ad.alum_nombre_admision AS nombre,
                    ad.alum_apepat_admision AS apellido_paterno,
                    ad.alum_apemat_admision AS apellido_materno,
                    CASE WHEN de.flag_doc = 3 THEN 'Rechazado'
                        ELSE 'Pendiente' END AS nom_estado,
                    CASE WHEN de.flag_doc = 3 THEN '#C70039'
                        ELSE '#FF8000' END AS color_estado,
                    CASE WHEN de.fec_subido IS NULL THEN '' ELSE CONVERT(VARCHAR, de.fec_subido, 120) END AS fecha,
                    us.usuario_codigo AS usuario
              FROM detalle_postulante_empresa de 
              LEFT JOIN documento_postulante_empresa dp ON de.id_documento = dp.id_documento AND dp.estado = 2
              LEFT JOIN empresa em ON de.id_empresa = em.id_empresa
              LEFT JOIN sede se ON de.id_sede = se.id_sede
              LEFT JOIN admision ad ON de.id_postulante = ad.id_admision
              LEFT JOIN users us ON de.user_subido = us.id_usuario
              WHERE de.archivo != '' AND de.estado = 2 AND (de.flag_doc != 2 OR de.flag_doc IS NULL)";
      $query = $this->db6->query($sql)->result_Array();
      return $query; 
    }

    function validar_archivo_postulante($dato){
      $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
      $query = $this->db6->query("SELECT id_postulante FROM postulante_observaciones_general WHERE id_postulante = '" . $dato['id_postulante'] . "'");
      $dato_ex = $query->row_array();
      
      if ($dato_ex){
        $sql_1 = "UPDATE postulante_observaciones_general SET estado = 2, fec_act = GETDATE(), user_act = $id_usuario
                    WHERE id_postulante = '" . $dato['id_postulante'] . "'";
        $this->db6->query($sql_1);

        $sql_2 = "INSERT INTO validacion_documento (codigo_documento, id_detalle, id_postulante, archivo, fecha, usuario, estado_v, estado, fec_reg, user_reg, fec_act, user_act)
                  VALUES ('" . $dato['codigo_documento'] . "','" . $dato['id_detalle'] . "',1,'" . $dato['archivo'] . "', CURDATE(), $id_usuario, 1, 2, NOW(), $id_usuario, NOW(), $id_usuario)";
        $this->db->query($sql_2);

        $sql_3 = "UPDATE detalle_postulante_empresa SET flag_doc = 2, fec_act = GETDATE(), user_act = $id_usuario
                    WHERE id_detalle = '" . $dato['id_detalle'] . "'";
        $this->db6->query($sql_3);

      }else{
        $sql = "INSERT INTO validacion_documento (codigo_documento, id_detalle, id_postulante, archivo, fecha, usuario, estado_v, estado, fec_reg, user_reg, fec_act, user_act)
                  VALUES ('" . $dato['codigo_documento'] . "','" . $dato['id_detalle'] . "',1,'" . $dato['archivo'] . "', CURDATE(), $id_usuario, 1, 2, NOW(), $id_usuario, NOW(), $id_usuario)";
          $this->db->query($sql);

        $sql_2 = "UPDATE detalle_postulante_empresa SET flag_doc = 2, fec_act = GETDATE(), user_act = $id_usuario
                  WHERE id_detalle = '" . $dato['id_detalle'] . "'";
          $this->db6->query($sql_2);
      }
    }

    function get_archivo_postulante($id_postulante,$id_detalle,$id_documento) {
      $sql = "SELECT archivo FROM detalle_postulante_empresa WHERE id_postulante = $id_postulante AND id_documento = $id_documento AND id_detalle = $id_detalle";
      $query = $this->db6->query($sql)->row_array();
      return $query;
    }

    function insert_rechazar_archivo_postulante($dato){
      $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
      $sql = "INSERT INTO postulante_observaciones_general (id_postulante,id_tipo_observacion,observacion,fecha_obs,usuario_obs,observacion_archivo,estado,fec_reg,user_reg,id_empresa,id_sede)
              VALUES ('" . $dato['id_admision'] . "','" . $dato['id_tipo'] . "','" . $dato['observacion'] . "',GETDATE(),$id_usuario,'" . $dato['observacion_archivo'] . "',3,GETDATE(),$id_usuario,6,9)";
      $this->db6->query($sql);

      $sql_2 = "UPDATE detalle_postulante_empresa SET flag_doc = 3, fec_act = GETDATE(), user_act = $id_usuario
                WHERE id_detalle = '" . $dato['id_detalle'] . "'";
      $this->db6->query($sql_2);

      $sql_est= "UPDATE admision SET estado2= 45 WHERE id_admision='".$dato['id_admision']."' ";
      $this->db6->query($sql_est); 
    }
}