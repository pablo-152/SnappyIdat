<?php
class Model_IFV extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('db2', true);
        $this->db3 = $this->load->database('db3', true);
        $this->db4 = $this->load->database('db4', true);
        $this->db5 = $this->load->database('db5', true);
        $this->db6 = $this->load->database('db6', true);
        $this->load->database();
        date_default_timezone_set("America/Lima");
    }

    public function filter($table, $field = null, $filter = null, $as_array = false, $order_by = null)
    {
        if ($field != null) {
            $this->db->select($field);
        }
        $query = $this->db->get_where($table, $filter);
        if (is_string($order_by)) {
            $this->db->order_by($order_by);
        }
        if ($as_array) {
            return $query->result_array();
        }
        return $query->result();
    }

    function get_list_nav_sede()
    {
        $sql = "SELECT * FROM sede 
                WHERE id_empresa=6 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_status()
    {
        $sql = "SELECT * FROM status 
                WHERE estado=1 ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_doc()
    {
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_empresa=6 AND estado=2 ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_documento_doc()
    {
        $sql = "SELECT * FROM documento_alumno_empresa WHERE id_empresa=6 AND estado=2 ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }



    function insert_detalledocs($data)
    {
        $sql = "INSERT INTO detalle_documentos_bl (id_alumno,id_documento,id_empresa,id_sede,cod_documento,nom_grado,obligatorio,digital,nom_documento,descripcion_documento,aplicar_todos,estado,fec_reg,user_reg) 
        SELECT " . $data['id_matriculado'] . " as id_alumno," . $data['id_documento'] . " as id_documento,id_empresa,id_sede,cod_documento,nom_grado,obligatorio,digital,nom_documento,descripcion_documento,aplicar_todos documento_alumno_empresa,2 as estado,NOW() as fec_reg,5 as user_reg
        FROM documento_alumno_empresa WHERE id_documento=" . $data['id_documento'] . " and id_empresa=3 and estado=2";
        $this->db->query($sql);
    }


    function get_list_estado()
    {
        $sql = "SELECT * FROM status WHERE estado=1 ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function Model_IFV()
    {
        $sql = "select * from fintranet where estado=1 and id_empresa=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    public function buscar_nomre_elemento($vnombre)
    {
        $sql = "SELECT desc_cod_elemento FROM cod_elemento WHERE estado=1 and nom_cod_elemento='$vnombre'";
        $consulta = $this->db->query($sql)->row('desc_cod_elemento');
        return $consulta;
    }
    function verificar_lista($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "select * from postulantes where estado='2'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function list_postulantes()
    {
        $sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,DATE_FORMAT(r.fec_termino,'%d-%m-%Y') as fecha_termino,r.puntaje,DATE_FORMAT(p.fec_inscripcion,'%d-%m-%Y') as fecha_inscripcion,DATE_FORMAT(p.fec_envio,'%d-%m-%Y') as fecha_envio,s.nom_status,
        Date_format(r.fec_termino,'%h:%i:%s'),Date_format(r.tiempo_ini,'%h:%i:%s'),TIMEDIFF(r.tiempo_ini, r.fec_termino) as minutos_t
        from postulantes p
        left join carrera c on c.id_carrera=p.id_carrera
        left join status_general s on s.id_status_general=p.estado
        left join resultado_examen_ifv r on r.id_postulante=p.id_postulante
        where p.estado in (29,30)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_postulantes_activos()
    {
        /*$sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,
                r.puntaje,r.puntaje,round((r.puntaje/16)) as puntaje_arpay,DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,
                DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.color AS col_status,s.nom_status,DATE_FORMAT(r.fec_termino,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%h:%i:%s'),DATE_FORMAT(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,TIMEDIFF(r.fec_termino, r.tiempo_ini) as minutos_t
                FROM postulantes p
                LEFT JOIN carrera c on c.id_carrera=p.id_carrera
                LEFT JOIN status_general s on s.id_status_general=p.estado
                LEFT JOIN resultado_examen_ifv r on r.id_postulante=p.id_postulante
                WHERE p.estado IN (29,30,56)";
        $query = $this->db->query($sql)->result_Array();
        return $query;*/
        $sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,
                DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.color AS col_status,s.nom_status
                FROM postulantes p
                LEFT JOIN carrera c on c.id_carrera=p.id_carrera
                LEFT JOIN status_general s on s.id_status_general=p.estado
                WHERE p.estado IN (29,30,56)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_resultado_examen_postulantes_activos()
    {
        $sql = "SELECT r.id_postulante,DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,r.fec_termino,r.tiempo_ini,
                r.puntaje,round((r.puntaje/16)) as puntaje_arpay,
                DATE_FORMAT(r.fec_termino,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,
                TIMEDIFF(r.fec_termino, r.tiempo_ini) as minutos_t
                FROM resultado_examen_ifv r where r.estado=31";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    //$sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,r.puntaje,DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.nom_status,
    //Date_format(r.fec_termino,'%H:%i:%s'),Date_format(r.tiempo_ini,'%H:%i:%s'),Date_format(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,TIMEDIFF(r.tiempo_ini, r.fec_termino) as minutos_t
    function list_postulantes_terminado()
    {
        $sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,
                DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,
                DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.color AS col_status,s.nom_status
                from postulantes p
                left join carrera c on c.id_carrera=p.id_carrera
                left join status_general s on s.id_status_general=p.estado
                where p.estado=31 ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_postulantes_todos()
    {
        /*$sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,r.fec_termino,DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,
                r.puntaje,round((r.puntaje/16)) as puntaje_arpay,DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,
                DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.color AS col_status,s.nom_status,Date_format(r.fec_termino,'%H:%i:%s'),
                Date_format(r.tiempo_ini,'%H:%i:%s'),r.tiempo_ini,Date_format(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,
                TIMEDIFF(r.fec_termino,r.tiempo_ini) as minutos_t
                from postulantes p
                left join carrera c on c.id_carrera=p.id_carrera
                left join status_general s on s.id_status_general=p.estado
                left join resultado_examen_ifv r on r.id_postulante=p.id_postulante
                where p.estado in (29,30,31,32,33,56) ";*/
        $sql = "SELECT p.*,c.nombre as nom_carrera,p.estado as estado_postulante,
        DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') as fecha_inscripcion,
        DATE_FORMAT(p.fec_envio,'%d/%m/%Y') as fecha_envio,s.color AS col_status,s.nom_status
        from postulantes p
        left join carrera c on c.id_carrera=p.id_carrera
        left join status_general s on s.id_status_general=p.estado
        where p.estado in (29,30,31,32,33,56,64) ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_comuimg($dato)
    {
        $sql1 = "UPDATE comunicaion_img SET estado=4 WHERE id_comuimg='" . $dato['id_comuimg'] . "'";
        $this->db->query($sql1);
    }

    function insert_lista_postulantes($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into postulantes (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado, fec_reg)
                values ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['id_carrera'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "',29,NOW())";

        $this->db->query($sql);
    }

    function insert_lista_postulantes_preguardar($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into postulantes_preguardar (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado,user_reg, fec_reg)
                values ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['id_carrera'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "',29,'$id_usuario',NOW())";

        $this->db->query($sql);
    }

    function insert_select_postulantes_preguardar()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulantes (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado, fec_reg)
                SELECT codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,'29',NOW() FROM postulantes_preguardar WHERE user_reg='$id_usuario'";
        //echo $sql;
        $this->db->query($sql);
    }

    function insert_lista_postulantes_temporal($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into postulantes_temporal (tipo_error,codigo,interese,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,user_reg)
                values ( '" . $dato['tipo_error'] . "','" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "','$id_usuario')";

        $this->db->query($sql);
    }

    function insert_postulantes_mail_temporal($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into postulantes_temporal_email (codigo,interese,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,user_reg)
                values ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','$id_usuario')";

        $this->db->query($sql);
    }

    function insert_postulantes_numcod_temporal($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into postulantes_temporal_num_cod (codigo,interese,nr_documento,user_reg)
                values ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['nr_documento'] . "','$id_usuario')";

        $this->db->query($sql);
    }

    function valida_lista_postulante_temporal_general()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_temporal where user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_lista_postulante_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_temporal where tipo_error='1' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function limpiar_postulante_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE from postulantes_temporal where user_reg='$id_usuario'";
        $sql2 = "DELETE from postulantes_preguardar where user_reg='$id_usuario'";
        $this->db->query($sql);
        $this->db->query($sql2);
    }


    /*function limpiar_postulante_email_temporal()
    { 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="DELETE from postulantes_temporal_email where user_reg='$id_usuario'";
        $this->db->query($sql);
    }

    function limpiar_postulante_numcod_temporal()
    { 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="DELETE from postulantes_temporal_num_cod where user_reg='$id_usuario'";
        $this->db->query($sql);
    }*/

    function valida_postulante_email_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_temporal where tipo_error='2' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_postulante_num_cod_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_temporal where tipo_error='3' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_postulante_nom_carrera()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_temporal where tipo_error='4' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_codcarrera($dato)
    {
        $sql = "SELECT * from carrera where codigo='" . $dato['codigo'] . "' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_codpostulante($dato)
    {
        $sql = "SELECT * from postulantes where codigo='" . $dato['codigo'] . "' and estado in (29,30,31,32,33) ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_reg_codpostulante_preguardar($dato)
    {
        $sql = "SELECT * from postulantes_preguardar where codigo='" . $dato['codigo'] . "' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_id_carrera($dato)
    {
        $sql = "SELECT id_carrera from carrera where nombre like '%" . $dato['interese'] . "%' and estado=2 ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_carrera($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "insert into carrera (id_especialidad,codigo, nombre,estado,fec_reg,user_reg) 
                values ('" . $dato['id_especialidad'] . "',
                '" . $dato['codigo'] . "',
                '" . $dato['nombre'] . "',
                '" . $dato['estado'] . "',
                NOW()," . $id_usuario . ")";
        $this->db->query($sql);
    }

    function list_carrera()
    {
        $sql = "SELECT c.*,s.nom_status from carrera c
                LEFT JOIN status s on c.estado=s.id_status
                WHERE c.estado in (1,2,3)
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_carrera_modulo($id_carrera)
    {
        $sql = "SELECT * FROM carrera where id_carrera='$id_carrera' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cant_area_carrera()
    {
        $sql = "SELECT * FROM area_carrera WHERE estado=2";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_carrera_area()
    {
        $sql = "SELECT c.*, s.nom_status,cr.nombre as carrera 
        from area_carrera c
        inner join carrera cr on c.id_carrera =cr.id_carrera
        left join status s on c.estado=s.id_status
        where c.estado in (1,2,3) ORDER BY carrera,c.nombre ASC";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function list_detalle_pregunta($id_examen)
    {
        /*$sql ="SELECT p.id_examen,c.nombre as nom_carrera, p.id_area,a.nombre as nom_area,a.orden,count(p.id_examen) AS cantidad 
        from pregunta_admision p 
        LEFT join area_carrera a on a.id_area=p.id_area
        left join carrera c on c.id_carrera=a.id_carrera
        where p.estado='2' and p.id_examen='$id_examen'
        group by p.id_examen,p.id_area";

        $query = $this->db4->query($sql)->result_Array();
        return $query;*/
        $sql = "SELECT p.id_examen, p.id_area,count(p.id_examen) AS cantidad 
        from pregunta_admision p 
        where p.estado='2' and p.id_examen='$id_examen'
        group by p.id_examen,p.id_area";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_listar_carrera()
    {
        $sql = "select * from carrera where estado=2 ORDER BY nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_postulante($dato)
    {
        $sql = "SELECT p.*,DATE_FORMAT(p.fec_inscripcion, '%Y-%m-%d') as fecha_inscripcion from postulantes p where p.id_postulante ='" . $dato['id_postulante'] . "' ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_postulante_xcodigo($dato)
    {
        $sql = "SELECT p.*,DATE_FORMAT(p.fec_inscripcion, '%Y-%m-%d') as fecha_inscripcion from postulantes p where p.codigo ='" . $dato['codigo'] . "' ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_postulante_resultado_examen($dato)
    {
        $sql = "SELECT * from resultado_examen_ifv where id_postulante ='" . $dato['id_postulante'] . "' and estado=2 ";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_update_postulante($dato)
    {
        $sql = "SELECT * from postulantes where nr_documento ='" . $dato['nr_documento'] . "' and estado in (29,30,31,32,33,56) and id_postulante<>'" . $dato['id_postulante'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_postulante($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE postulantes set nr_documento='" . $dato['nr_documento'] . "',celular='" . $dato['celular'] . "',nombres='" . $dato['nombres'] . "',apellido_pat='" . $dato['apellido_pat'] . "',apellido_mat='" . $dato['apellido_mat'] . "',email='" . $dato['email'] . "',fec_inscripcion='" . $dato['fec_inscripcion'] . "',interese='" . $dato['interese'] . "',id_carrera='" . $dato['id_carrera'] . "',grupo='" . $dato['grupo'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act='$id_usuario'  where id_postulante='" . $dato['id_postulante'] . "'";
        $this->db->query($sql);
    }

    function list_examen_adm()
    {
        $sql = "SELECT p.*,DATE_FORMAT(p.fec_inscripcion,'%d-%m-%Y') as fecha_inscripcion,DATE_FORMAT(p.fec_envio,'%d-%m-%Y') as fecha_envio,s.nom_status
        from postulantes p
        left join status_general s on s.id_status_general=p.estado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_carrera_area($id_area)
    {
        $sql = "SELECT a.*,cr.nombre AS carrera,cr.codigo AS cod_carrera,a.codigo AS cod_area 
        FROM area_carrera a
        LEFT JOIN carrera cr ON a.id_carrera =cr.id_carrera
        WHERE a.id_area='$id_area' ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_pregunta_admision($dato)
    {
        $sql = "SELECT * from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' 
        and estado=2  and pregunta='" . $dato['pregunta'] . "' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_pregunta_admision($dato)
    {
        $sql = "SELECT * from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' and estado=2 ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_pregunta($dato)
    {
        $sql = "SELECT * from pregunta_admision where id_examen='" . $dato['id_examen'] . "' and estado=2";
        //echo $sql;
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function insert_pregunta_admision($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $id_area = $dato['id_area'];
        $id_examen = $dato['id_examen'];
        $path = $_FILES['img']['name'];
        $size1 = $_FILES['img']['size'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img';
        //$config['upload_path'] = './examen/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './IFV_Examen_Admision/' . $id_area . '-' . $id_examen . '/examen';
        $nombre = "exam" . $fecha . "_" . rand(1, 200);
        $config['file_name'] = $nombre . "." . $ext;


        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'IFV_Examen_Admision/' . $id_area . '-' . $id_examen . '/examen' . '/' . $config['file_name'];

        $config['allowed_types'] = "png";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path != "") {
            $sql = "INSERT INTO pregunta_admision (
                id_area,
                id_examen,
                orden,
                pregunta,
                img,
                estado,
                user_reg,
                fec_reg
                ) 
                VALUES (
                '" . $dato['id_area'] . "',
                '" . $dato['id_examen'] . "',
                '" . $dato['orden'] . "',
                '" . $dato['pregunta'] . "',
                '" . $ruta . "',
                '2',
                " . $id_usuario . ",
                NOW())";
        } else {
            $sql = "INSERT INTO pregunta_admision (
                id_area,
                id_examen,
                orden,
                pregunta,
                estado,
                user_reg,
                fec_reg
                ) 
                VALUES (
                '" . $dato['id_area'] . "',
                '" . $dato['id_examen'] . "',
                '" . $dato['orden'] . "',
                '" . $dato['pregunta'] . "',
                '2',
                " . $id_usuario . ",
                NOW())";
        }
        $this->db4->query($sql);

        $sql2 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta, estado, fec_reg, user_reg) 
            values ((SELECT id_pregunta from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "'  order by id_pregunta desc limit 1),
            '" . $dato['id_area'] . "','" . $dato['alternativa1'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql2);

        $sql3 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta, estado, fec_reg, user_reg) 
            values ((SELECT id_pregunta from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
            '" . $dato['id_area'] . "','" . $dato['alternativa2'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql3);

        $sql4 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta, estado, fec_reg, user_reg) 
            values ((SELECT id_pregunta from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
            '" . $dato['id_area'] . "','" . $dato['alternativa3'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql4);

        $sql5 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta, estado, fec_reg, user_reg) 
            values ((SELECT id_pregunta from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
            '" . $dato['id_area'] . "','" . $dato['alternativa4'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql5);

        $sql6 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta,correcto, estado, fec_reg, user_reg) 
            values ((SELECT id_pregunta from pregunta_admision where id_area='" . $dato['id_area'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
            '" . $dato['id_area'] . "','" . $dato['alternativa5'] . "','1','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql6);
    }

    function list_preguntas_admision($id_area, $id_examen)
    {
        $sql = "SELECT * FROM pregunta_admision WHERE id_area='$id_area' and id_examen='$id_examen' and estado='2' ORDER BY orden ASC";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_id_pregunta_admision($dato)
    {
        $sql = "SELECT p.*
        FROM pregunta_admision p 
        WHERE p.id_pregunta='" . $dato['id_pregunta'] . "' ";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_id_respuesta_admision($dato)
    {
        $sql = "SELECT * from respuesta_admision where estado=2 and id_pregunta='" . $dato['id_pregunta'] . "' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function update_pregunta_admision($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $id_area = $dato['id_area'];
        $path = $_FILES['img']['name'];
        $size1 = $_FILES['img']['size'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img';
        //$config['upload_path'] = './examen/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './IFV_Examen_Admision/' . $id_area . '/examen';
        $nombre = "exam" . $fecha . "_" . rand(1, 200);
        $config['file_name'] = $nombre . "." . $ext;


        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'IFV_Examen_Admision/' . $id_area . '/examen' . '/' . $config['file_name'];

        $config['allowed_types'] = "png";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path != "") {
            $sql = "UPDATE pregunta_admision SET 
                orden='" . $dato['orden'] . "',
                pregunta='" . $dato['pregunta'] . "',
                img='" . $ruta . "',
                user_act=" . $id_usuario . ",
                fec_act=NOW() WHERE id_pregunta='" . $dato['id_pregunta'] . "' ";
        } else {
            $sql = "UPDATE pregunta_admision SET
                orden='" . $dato['orden'] . "',
                pregunta='" . $dato['pregunta'] . "',
                user_act=" . $id_usuario . ",
                fec_act=NOW() WHERE id_pregunta='" . $dato['id_pregunta'] . "' ";
        }
        $this->db4->query($sql);

        $sql2 = "UPDATE respuesta_admision SET desc_respuesta='" . $dato['alternativa1'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta1'] . "";
        $this->db4->query($sql2);

        $sql3 = "UPDATE respuesta_admision SET desc_respuesta='" . $dato['alternativa2'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta2'] . "";
        $this->db4->query($sql3);

        $sql4 = "UPDATE respuesta_admision SET desc_respuesta='" . $dato['alternativa3'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta3'] . "";
        $this->db4->query($sql4);

        $sql5 = "UPDATE respuesta_admision SET desc_respuesta='" . $dato['alternativa4'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta4'] . "";
        $this->db4->query($sql5);

        $sql6 = "UPDATE respuesta_admision SET desc_respuesta='" . $dato['alternativa5'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta5'] . "";
        $this->db4->query($sql6);
    }

    function delete_pregunta_admision($id_pregunta)
    {
        $fecha = date('Y-m-d H:i:s');
        $id_user = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE pregunta_admision set estado='4', fec_eli= NOW(),user_eli=" . $id_user . " where id_pregunta='" . $id_pregunta . "'";
        $sql2 = " UPDATE respuesta_admision set estado='4', fec_eli= NOW(),user_eli=" . $id_user . " where id_pregunta='" . $id_pregunta . "' ";

        $this->db->query($sql);
        $this->db->query($sql2);
    }

    function update_envio_invitacion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d H:i:s');
        $sql = "UPDATE postulantes set estado='30',fec_envio=NOW()  where id_postulante='" . $dato['id_postulante'] . "'";
        $this->db->query($sql);

        $sql2 = "DELETE FROM historial_examenifv  where id_postulante='" . $dato['id_postulante'] . "'";
        $this->db4->query($sql2);

        $sql3 = "DELETE FROM resultado_examen_ifv where id_postulante='" . $dato['id_postulante'] . "'";
        $this->db4->query($sql3);

        $sql4 = "DELETE FROM pregunta_exonerada where id_postulante='" . $dato['id_postulante'] . "'";
        $this->db4->query($sql4);

        $sql5 = "INSERT into pos_exam (idpos_pe,idexa_pe,estado_pe,fec_reg,user_reg) value ('" . $dato['id_postulante'] . "','" . $dato['id_examen'] . "','30','$fecha','$id_usuario')";
        $this->db4->query($sql5);
    }

    function get_list_estado_postulante()
    {
        $sql = "SELECT * from status_general where id_status_mae=5";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_carrera($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE carrera set id_especialidad='" . $dato['id_especialidad'] . "',codigo='" . $dato['codigo'] . "',
                nombre='" . $dato['nombre'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_actu='$id_usuario' 
                where id_carrera='" . $dato['id_carrera'] . "'";

        $this->db->query($sql);
    }

    function delete_carrera($id_carrera)
    {
        $id_user = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE carrera set estado='4', fec_eli= NOW(),user_eli=" . $id_user . " where id_carrera='" . $id_carrera . "'";


        $this->db->query($sql);
    }

    function delete_resultado_examen_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "DELETE FROM resultado_examen_ifv  WHERE id_postulante='" . $dato['id_postulante'] . "'";
        $sql2 = "DELETE FROM pregunta_exonerada  WHERE id_postulante='" . $dato['id_postulante'] . "'";
        $sql3 = "DELETE FROM historial_examenifv  WHERE id_postulante='" . $dato['id_postulante'] . "'";

        $this->db4->query($sql);
        $this->db4->query($sql2);
        $this->db4->query($sql3);
    }
    //-----------------------PDFIFV----------------------//
    function list_comu_img()
    {
        $sql = "SELECT ci.*,CONCAT(u.usuario_nombres,' ',u.usuario_apater) as creado_por,
                date_format(ci.inicio_comuimg, '%d/%m/%Y') as inicio,date_format(ci.fin_comuimg, '%d/%m/%Y') as fin,
                date_format(ci.fec_reg, '%d/%m/%Y') as fec_reg,s.nom_status,
                CASE WHEN ci.flag_referencia=0 THEN 'Resultados IFV' WHEN ci.flag_referencia=1 THEN 'Triptico' ELSE ''
                END AS tipo
                from comunicaion_img ci
                left join users u on u.id_usuario=ci.user_reg
                left join statusav s on s.id_statusav=ci.estado
                where ci.tipo_comuimg=1 AND ci.estado NOT IN (4)
                ORDER BY ci.inicio_comuimg DESC,s.nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function list_total_web_ifv()
    {

        $sql = "SELECT 
        ci.*,CONCAT(u.usuario_nombres,' ',u.usuario_apater) as creado_por,
        date_format(ci.inicio_comuimg, '%d/%m/%Y') as inicio,
        date_format(ci.fin_comuimg, '%d/%m/%Y') as fin,
        date_format(ci.fec_reg, '%d/%m/%Y') as fec_reg
        ,s.nom_status,
        CASE 
        WHEN ci.flag_referencia=0 THEN 'Resultados IFV'
        WHEN ci.flag_referencia=1 THEN 'Triptico' 
        WHEN ci.flag_referencia=3 THEN 'Reglamento Interno' 
        WHEN ci.flag_referencia=2 THEN 'Imagen' 
        ELSE '' END AS tipo
        from comunicaion_img ci
        left join users u on u.id_usuario=ci.user_reg
        left join statusav s on s.id_statusav=ci.estado
        where ci.tipo_comuimg IN (1,2,3) AND ci.estado NOT IN (4)
        ORDER BY ci.inicio_comuimg DESC,s.nom_status ASC";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_registro($id_comuimg)
    {
        $sql = "SELECT * from comunicaion_img where id_comuimg =$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_registro_activo()
    {
        $sql = "SELECT * from comunicaion_img 
              where estado=1 and tipo_comuimg=1 limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_registro_activo_reglamento()
    {
        $sql = "SELECT * from comunicaion_img 
              where estado=1 and tipo_comuimg=3 limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_registro_activo_web()
    {
        $sql = "SELECT * from comunicaion_img 
              where estado=1 and tipo_comuimg=2 limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_web_img()
    {
        $sql = "SELECT 
        ci.*,CONCAT(u.usuario_nombres,' ',u.usuario_apater) as creado_por,
        date_format(ci.inicio_comuimg, '%d/%m/%Y') as inicio_comuimg,
        date_format(ci.fin_comuimg, '%d/%m/%Y') as fin_comuimg,
        date_format(ci.fec_reg, '%d/%m/%Y') as fec_reg,  s.nom_status
        from comunicaion_img ci
        left join users u on u.id_usuario=ci.user_reg
        left join statusav s on s.id_statusav=ci.estado
        where tipo_comuimg=2";


        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_comuimg($dato)
    {
        /*$sql1="CALL UpdateEstadoInactivo()";
        $this->db->query($sql1);
        $sql = "CALL Insert_CI_Adminsion('".$dato['refe_comuimg']."','".$dato['img_comuimg']."',
                '".$dato['inicio_comuimg']."','".$dato['fin_comuimg']."','".$dato['estado']."',
                NOW(),'$id_usuario')";*/

        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO comunicaion_img (refe_comuimg,img_comuimg,inicio_comuimg,fin_comuimg,estado,tipo_comuimg,cod_referencia,flag_referencia,fec_reg,user_reg)
                VALUES ('" . $dato['refe_comuimg'] . "','" . $dato['img_comuimg'] . "','" . $dato['inicio_comuimg'] . "','" . $dato['fin_comuimg'] . "','" . $dato['estado'] . "',1,
                '" . $dato['cod_referencia'] . "','" . $dato['flag_referencia'] . "',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insertar_webimg($dato)
    {
        $fecha = date('Y-m-d');
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img_comuimg';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './imgweb';
        $config['file_name'] = "comu_web" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'imgweb/' . $config['file_name'];

        $config['allowed_types'] = "jpg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        $sql1 = "CALL UpdateEstadoInactivoWeb()";
        $this->db->query($sql1);

        if ($path != "") {

            $sql = "call Insert_CI_Web
            (
                '" . $dato['refe_comuimg'] . "',
                '$ruta',
                '" . $dato['inicio_comuimg'] . "',
                '" . $dato['fin_comuimg'] . "',

                '',
                '" . $dato['flag_referencia'] . "',

                '" . $dato['estado'] . "',
                NOW(),
                '$id_usuario'
            )";
        } else {
            $sql = "call Insert_CI_Web
            (
                '" . $dato['refe_comuimg'] . "',
                '',
                '" . $dato['inicio_comuimg'] . "',
                '" . $dato['fin_comuimg'] . "',

                '',
                '" . $dato['flag_referencia'] . "',

                '" . $dato['estado'] . "',
                NOW(),
                '$id_usuario'
            )";
        }
        $this->db->query($sql);
    }

    function update_comuimg($dato)
    {
        /*if($dato['estado']==1){
            $sql1 = "CALL UpdateEstadoInactivo()";
            $this->db->query($sql1);
        }
        $sql = "call Update_CI_Adminsion_Cimg('".$dato['refe_comuimg']."','".$dato['img_comuimg']."',
                '".$dato['inicio_comuimg']."','".$dato['fin_comuimg']."','".$dato['estado']."',
                NOW(),'$id_usuario','".$dato['id_comuimg']."')";*/
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE comunicaion_img SET 
                tipo_comuimg =1,
        
                refe_comuimg='" . $dato['refe_comuimg'] . "',
                img_comuimg='" . $dato['img_comuimg'] . "',
                inicio_comuimg='" . $dato['inicio_comuimg'] . "',
                fin_comuimg='" . $dato['fin_comuimg'] . "',
                flag_referencia='" . $dato['flag_referencia'] . "',
                cod_referencia='" . $dato['cod_referencia'] . "',
                refe_comuimg='" . $dato['refe_comuimg'] . "',
                estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_comuimg='" . $dato['id_comuimg'] . "'";
        $this->db->query($sql);
    }

    function valida_comuimg($dato)
    {
        $val = "";
        if ($dato['mod'] == 2) {
            $val = " and id_comuimg!='" . $dato['id_comuimg'] . "' ";
        }


        if ($dato['flag_referencia'] == 1) {
            $carrera = " and cod_referencia='" . $dato['cod_referencia'] . "' ";
        } elseif ($dato['flag_referencia'] == 0) {
            $carrera = "";
        }


        $sql = "
    
            SELECT * FROM 
            comunicaion_img 
            WHERE 
            (inicio_comuimg between '" . $dato['inicio_comuimg'] . "' 
            and '" . $dato['fin_comuimg'] . "' 
            and estado=1  " . $val . " 
            and tipo_comuimg=1
            and  flag_referencia='" . $dato['flag_referencia'] . "'
            " . $carrera . "
            ) 
            
            or 
            (fin_comuimg between '" . $dato['inicio_comuimg'] . "' 
            and '" . $dato['fin_comuimg'] . "' 
            and estado=1 " . $val . "
            and tipo_comuimg=1
            and flag_referencia='" . $dato['flag_referencia'] . "'
            " . $carrera . ");
                
        ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_webimg($dato)
    {
        $fecha = date('Y-m-d');
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img_comuimg';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './imgweb/';
        $config['file_name'] = "comu_web" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'imgweb/' . $config['file_name'];

        $config['allowed_types'] = "jpg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($dato['estado'] == 1) {
            $sql1 = "CALL UpdateEstadoInactivoWeb()";
            $this->db->query($sql1);
        }

        if ($path != "") {
            $sql = "
            call Update_CI_Web_Cimg
            (
                '" . $dato['refe_comuimg'] . "',
                '$ruta',
                '" . $dato['inicio_comuimg'] . "',
                '" . $dato['fin_comuimg'] . "',
                '" . $dato['estado'] . "',
                NOW(),
                '$id_usuario',
                '" . $dato['id_comuimg'] . "'
            )";
        } else {
            $sql = "call Update_CI_Web_Simg
            (
                '" . $dato['refe_comuimg'] . "',
                '" . $dato['inicio_comuimg'] . "',
                '" . $dato['fin_comuimg'] . "',
                '" . $dato['estado'] . "',
                NOW(),
                '$id_usuario',
                '" . $dato['id_comuimg'] . "'
            )";
        }
        $this->db->query($sql);
    }
    //---------------------------------------------------CENTROS---------------------------------------------
    function get_list_centro()
    {
        /*$sql="SELECT ce.*,st.nom_status,DATE_FORMAT(ce.fecha_firma,'%d/%m/%Y') as fec_firma,DATE_FORMAT(ce.val_de,'%d/%m/%Y') as inicio,DATE_FORMAT(ce.val_a,'%d/%m/%Y') as fin, (SELECT COUNT(*) FROM centro_direccion cd WHERE cd.id_centro=ce.id_centro and cd.estado=2) as CP
        FROM centro ce
        LEFT JOIN status_general st on st.id_status_general=ce.estado
                    where ce.estado in (49,50,51,53)";*/
        $sql = "SELECT ce.*,DATE_FORMAT(ce.fecha_firma,'%d/%m/%Y') as fec_firma,DATE_FORMAT(ce.val_de,'%d/%m/%Y') as inicio,DATE_FORMAT(ce.val_a,'%d/%m/%Y') as fin, 
        (SELECT COUNT(*) FROM centro_direccion cd WHERE cd.id_centro=ce.id_centro and cd.estado=2) as CP,
        CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
        THEN (SELECT d.nombre_departamento FROM v_grupo_direccion_ifv g LEFT JOIN departamento d on d.id_departamento=g.departamento
                        where g.id_centro=ce.id_centro) ELSE '' END as departamentod,
        CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
         THEN (SELECT p.nombre_provincia FROM v_grupo_direccion_ifv g LEFT JOIN provincia p on p.id_provincia=g.provincia
                        where g.id_centro=ce.id_centro) ELSE '' END as provinciad,
        CASE WHEN (SELECT COUNT(*) FROM v_grupo_direccion_ifv g where g.id_centro=ce.id_centro)=1 
        THEN (SELECT di.nombre_distrito FROM v_grupo_direccion_ifv g LEFT JOIN distrito di on di.id_distrito=g.distrito
                        where g.id_centro=ce.id_centro) ELSE '' END as distritod,

                        (SELECT ch.estado FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as id_statush,
                        (SELECT sg.nom_status FROM centro_historial ch LEFT JOIN status_general sg on sg.id_status_general=ch.estado WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as nom_status
                        
                FROM centro ce where (SELECT ch.estado FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) in (49,50,51,53);";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_centro_referencia()
    {
        $sql = "SELECT * FROM centro";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_carrera_ciclo($id_carrera)
    {
        $sql = "SELECT * FROM asignacion_ciclo WHERE estado!=4 AND id_carrera=$id_carrera";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_carrera_modulo($id_carrera)
    {
        $sql = "SELECT * FROM asignacion_modulo WHERE estado!=4 AND id_carrera=$id_carrera";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_provincia($dato)
    {
        $sql = "SELECT * FROM provincia WHERE estado=2 AND id_departamento='" . $dato['id_departamento'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_distrito($dato)
    {
        $sql = "SELECT * FROM distrito WHERE estado=2 AND id_departamento='" . $dato['id_departamento'] . "'
              AND id_provincia='" . $dato['id_provincia'] . "'";
        echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO centro (cod_centro,referencia,nom_comercial,empresa,ruc,persona,celular_pprin,correo_pprin,web,
        fecha_firma,val_de,val_a,firmasf,observaciones_admin,observaciones,estado,fec_reg,
        user_reg) 
        VALUES ('" . $dato['cod_centro'] . "','" . $dato['referencia'] . "','" . $dato['nom_comercial'] . "',
        '" . $dato['empresa'] . "','" . $dato['ruc'] . "','" . $dato['persona'] . "','" . $dato['celular'] . "','" . $dato['correo'] . "','" . $dato['web'] . "',
        '" . $dato['fecha_firma'] . "','" . $dato['val_de'] . "','" . $dato['val_a'] . "','" . $dato['firmasf'] . "',
        '" . $dato['observaciones_admin'] . "','" . $dato['observaciones'] . "',
        '" . $dato['estado'] . "',NOW(),$id_usuario)";
        $this->db->query($sql);

        //$fecha=date('Y-m-d H:i:s');
        $fecha = date('Y-m-d');
        $sql2 = "INSERT INTO centro_historial (id_centro,estado,comentario,id_accion,fecha_accion,fec_reg,
        user_reg) 
        VALUES ((SELECT c.id_centro FROM centro c WHERE c.cod_centro='" . $dato['cod_centro'] . "' and c.estado<>1),'" . $dato['estado'] . "','" . $dato['observaciones'] . "',1,'$fecha',NOW(),$id_usuario)";

        $this->db->query($sql2);
    }

    function get_idcentro_xcodigo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT id_centro FROM centro where cod_centro='" . $dato['cod_centro'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_especialidad_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        /*$sql6 = "INSERT INTO centro_direccion (direccion,departamento,provincia,distrito,cp,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['direccion']."','".$dato['departamento']."','".$dato['provincia']."','".$dato['distrito']."','".$dato['cp']."',2,
                NOW(),$id_usuario)";

        $this->db->query($sql6);*/

        $sql0 = "INSERT INTO centro_especialidad (id_centro,id_especialidad,id_producto,cantidad,total,estado,
                fec_reg,user_reg) 
                SELECT '" . $dato['id_centro'] . "',id_especialidad,id_producto,cantidad,total,2,NOW(),$id_usuario FROM centro_especialidad_temporal where
                 user_reg='$id_usuario'";



        $sql1 = "UPDATE centro set fecha_firma='" . $dato['fecha_firma'] . "',documento='" . $dato['documento'] . "',
        observaciones_admin='" . $dato['observaciones_admin'] . "',val_de='" . $dato['val_de'] . "',val_a='" . $dato['val_a'] . "' where id_centro='" . $dato['id_centro'] . "'";

        $sql2 = "DELETE FROM centro_especialidad_temporal WHERE user_reg='$id_usuario'";


        $sql3 = "DELETE FROM centro_espec_gene_temporal WHERE user_reg='$id_usuario'";

        $sql4 = "INSERT INTO centro_direccion (id_centro,direccion,departamento,provincia,distrito,contacto_dir,celular_dir,correo_dir,cp,estado,
                fec_reg,user_reg) 
                SELECT '" . $dato['id_centro'] . "',direccion,departamento,provincia,distrito,contacto_dir,celular_dir,correo_dir,cp,2,NOW(),$id_usuario FROM centro_direccion_temporal where
                 user_reg='$id_usuario'";
        $sql5 = "DELETE FROM centro_direccion_temporal WHERE user_reg='$id_usuario'";

        $this->db->query($sql0);
        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->query($sql5);
    }

    function insert_especialidad_centro_sinultimodireccion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];



        $sql0 = "INSERT INTO centro_especialidad (id_centro,id_especialidad,id_producto,cantidad,total,estado,
                fec_reg,user_reg) 
                SELECT '" . $dato['id_centro'] . "',id_especialidad,id_producto,cantidad,total,2,NOW(),$id_usuario FROM centro_especialidad_temporal where
                 user_reg='$id_usuario'";



        $sql1 = "UPDATE centro set fecha_firma='" . $dato['fecha_firma'] . "',documento='" . $dato['documento'] . "',
        observaciones_admin='" . $dato['observaciones_admin'] . "',val_de='" . $dato['val_de'] . "',val_a='" . $dato['val_a'] . "' where id_centro='" . $dato['id_centro'] . "'";

        $sql2 = "DELETE FROM centro_especialidad_temporal WHERE user_reg='$id_usuario'";


        $sql3 = "DELETE FROM centro_espec_gene_temporal WHERE user_reg='$id_usuario'";

        $sql4 = "INSERT INTO centro_direccion (id_centro,direccion,departamento,provincia,distrito,cp,contacto_dir,celular_dir,tel_fijo,correo_dir,estado,
                fec_reg,user_reg) 
                SELECT '" . $dato['id_centro'] . "',direccion,departamento,provincia,distrito,cp,contacto_dir,celular_dir,tel_fijo,correo_dir,2,NOW(),$id_usuario FROM centro_direccion_temporal where
                 user_reg='$id_usuario'";
        echo $sql4;
        $sql5 = "DELETE FROM centro_direccion_temporal WHERE user_reg='$id_usuario'";

        $this->db->query($sql0);
        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->query($sql5);
    }

    function insert_direccion_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO centro_direccion (id_centro,direccion,departamento,provincia,distrito,cp,contacto_dir,celular_dir,tel_fijo,correo_dir,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_centro'] . "',
                '" . $dato['direccion'] . "','" . $dato['departamento'] . "',
                '" . $dato['provincia'] . "','" . $dato['distrito'] . "','" . $dato['cp'] . "','" . $dato['contacto_dir'] . "','" . $dato['celular_dir'] . "','" . $dato['tel_fijo'] . "','" . $dato['correo_dir'] . "',2,
                NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function insert_centro_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO centro_especialidad (id_centro,id_especialidad,id_producto,estado,
                fec_reg,user_reg) 
                VALUES ((SELECT id_centro FROM centro WHERE cod_centro='" . $dato['cod_centro'] . "' and estado=2),
                '" . $dato['id_especialidad'] . "','" . $dato['id_producto'] . "',2,
                NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function preinsert_centro_especialidad_total($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO centro_especialidad_temporal (id_especialidad,id_producto,total,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['especialidad'] . "',0,'" . $dato['total'] . "',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function preinsert_centro_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO centro_especialidad_temporal (id_especialidad,id_producto,cantidad,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_especialidad'] . "','" . $dato['id_producto'] . "','" . $dato['cantidad'] . "',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_preinsert_direccion_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT * FROM centro_direccion_temporal WHERE user_reg='$id_usuario' and direccion='" . $dato['direccion'] . "' and 
        departamento='" . $dato['departamento'] . "' and provincia='" . $dato['provincia'] . "' and distrito='" . $dato['distrito'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_direccion_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT * FROM centro_direccion WHERE id_centro='" . $dato['id_centro'] . "' and direccion='" . $dato['direccion'] . "' and 
        departamento='" . $dato['departamento'] . "' and provincia='" . $dato['provincia'] . "' and distrito='" . $dato['distrito'] . "' and estado=2";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_direccion_temporal($id_direccion_temporal)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql1 = "DELETE FROM centro_direccion_temporal WHERE id_direccion_temporal='$id_direccion_temporal'";
        $this->db->query($sql1);
    }

    function delete_direccion($id_centro_direccion)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql1 = "update centro_direccion set estado=4 WHERE id_centro_direccion='$id_centro_direccion'";

        $this->db->query($sql1);
    }

    function preinsert_direccion_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO centro_direccion_temporal (direccion,departamento,provincia,distrito,cp,contacto_dir,celular_dir,tel_fijo,correo_dir,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['direccion'] . "','" . $dato['departamento'] . "','" . $dato['provincia'] . "','" . $dato['distrito'] . "','" . $dato['cp'] . "','" . $dato['contacto_dir'] . "','" . $dato['celular_dir'] . "','" . $dato['tel_fijo'] . "','" . $dato['correo_dir'] . "',2,
                NOW(),$id_usuario)";

        $this->db->query($sql);
    }


    function limpiar_temporal_centro()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        /*if(isset($dato['total'][0]['documento']) && $dato['total'][0]['documento']!=""){
            var_dump($dato['total'][0]['documento']);
            unlink($dato['total'][0]['documento']);
        }*/

        $sql1 = "DELETE FROM centro_especialidad_temporal WHERE user_reg='$id_usuario'";
        $sql2 = "DELETE FROM centro_espec_gene_temporal WHERE user_reg='$id_usuario'";
        $sql3 = "DELETE FROM centro_direccion_temporal WHERE user_reg='$id_usuario'";

        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->query($sql3);
    }

    function limpiar_temporal_especialidad_centro()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        /*if(isset($dato['total'][0]['documento']) && $dato['total'][0]['documento']!=""){
            var_dump($dato['total'][0]['documento']);
            unlink($dato['total'][0]['documento']);
        }*/

        $sql1 = "DELETE FROM centro_especialidad_temporal WHERE user_reg='$id_usuario'";
        $sql2 = "DELETE FROM centro_espec_gene_temporal WHERE user_reg='$id_usuario'";

        $this->db->query($sql1);
        $this->db->query($sql2);
    }

    function get_list_pre_centro_especialidad()
    {
        $sql = "SELECT * FROM centro_especialidad_temporal";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pre_centro_especialidad_total()
    {
        $sql = "SELECT * FROM centro_especialidad_temporal WHERE total!=''";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function preinsert_general_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('d-m-Y');
        $path = $_FILES['documento']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'documento';
        $config['upload_path'] = './centro/';
        $nombre = "centro_" . $fecha . "_" . rand(1, 200);
        $config['file_name'] = $nombre . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'centro/' . $config['file_name'];

        $config['allowed_types'] = "jpeg|png|jpg|pdf|gif";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path != "") {
            $sql = "INSERT INTO centro_espec_gene_temporal (fecha_firma,documento,observaciones_admin,
                val_de,val_a,firmasf,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['fecha_firma'] . "','" . $ruta . "','" . $dato['observaciones_admin'] . "',
                '" . $dato['val_de'] . "','" . $dato['val_a'] . "','" . $dato['firmasf'] . "',2,
                NOW(),$id_usuario)";
        } else {
            $sql = "INSERT INTO centro_espec_gene_temporal (fecha_firma,documento,observaciones_admin,
            val_de,val_a,firmasf,estado,fec_reg,user_reg) 
            VALUES ('" . $dato['fecha_firma'] . "','" . $dato['documento'] . "','" . $dato['observaciones_admin'] . "',
            '" . $dato['val_de'] . "','" . $dato['val_a'] . "','" . $dato['firmasf'] . "',2,
            NOW(),$id_usuario)";
        }


        $this->db->query($sql);
    }

    function update_general_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('d-m-Y');
        $path = $_FILES['documentoe']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'documentoe';
        $config['upload_path'] = './centro/';
        $nombre = "centro_" . $fecha . "_" . rand(1, 200);
        $config['file_name'] = $nombre . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'centro/' . $config['file_name'];

        $config['allowed_types'] = "jpeg|png|jpg|pdf|gif";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path != "") {
            $sql = "UPDATE centro set fecha_firma='" . $dato['fecha_firma'] . "', documento='$ruta',
            observaciones_admin='" . $dato['observaciones_admin'] . "',val_de='" . $dato['val_de'] . "',val_a='" . $dato['val_a'] . "',firmasf='" . $dato['firmasf'] . "' where id_centro='" . $dato['id_centro'] . "'";
        } else {
            $sql = "UPDATE centro set fecha_firma='" . $dato['fecha_firma'] . "',
            observaciones_admin='" . $dato['observaciones_admin'] . "',val_de='" . $dato['val_de'] . "',val_a='" . $dato['val_a'] . "',firmasf='" . $dato['firmasf'] . "' where id_centro='" . $dato['id_centro'] . "'";
        }


        $this->db->query($sql);
    }

    function get_list_centro_especialidad($id_centro)
    {
        $sql = "SELECT * FROM centro_especialidad WHERE id_centro=$id_centro";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_centro_especialidad_total($id_centro)
    {
        $sql = "SELECT * FROM centro_especialidad WHERE id_centro=$id_centro AND total!=''";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function limpiar_centro_especialidad($dato)
    {
        $sql2 = "DELETE FROM centro_especialidad WHERE id_centro='" . $dato['id_centro'] . "'";
        $this->db->query($sql2);
    }

    function update_centro_especialidad_total($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO centro_especialidad (id_especialidad,id_producto,id_centro,total,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['especialidad'] . "',0,'" . $dato['id_centro'] . "','" . $dato['total'] . "',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_centro_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO centro_especialidad (id_especialidad,id_producto,id_centro,cantidad,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_especialidad'] . "','" . $dato['id_producto'] . "','" . $dato['id_centro'] . "','" . $dato['cantidad'] . "',2,
                NOW(),$id_usuario)";

        $this->db->query($sql);

        $sql2 = "UPDATE centro_historial SET estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario WHERE id_centro_historial='" . $dato['id_ultimo_historial'] . "'";

        $this->db->query($sql2);
    }

    function update_centro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE centro SET referencia='" . $dato['referencia'] . "',nom_comercial='" . $dato['nom_comercial'] . "',
        empresa='" . $dato['empresa'] . "',ruc='" . $dato['ruc'] . "',persona='" . $dato['persona'] . "',celular_pprin='" . $dato['celular'] . "',correo_pprin='" . $dato['correo'] . "',
        web='" . $dato['web'] . "',observaciones='" . $dato['observaciones'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario 
            WHERE id_centro='" . $dato['id_centro'] . "'";

        $this->db->query($sql);

        $sql2 = "UPDATE centro_historial SET estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario WHERE id_centro_historial='" . $dato['id_ultimo_historial'] . "'";

        $this->db->query($sql2);
    }

    function list_preguardado_centro_especialidad()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT * FROM centro_especialidad_temporal WHERE user_reg=$id_usuario";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_preguardado_general_centro_especialidad()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT c.*,DATE_FORMAT(c.fecha_firma,'%Y-%m-%d') as fec_firma FROM centro_espec_gene_temporal c WHERE c.user_reg=$id_usuario";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_registros_centro()
    {
        $anio = date('Y');
        $sql = "SELECT * FROM centro WHERE YEAR(fec_reg)=$anio";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_centro($id_centro)
    {
        $sql = "SELECT c.*,DATE_FORMAT(c.fecha_firma,'%Y-%m-%d') as fec_firma,
        (SELECT ch.id_centro_historial FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro=c.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as id_ultimo_h,
        (SELECT ch.estado FROM centro_historial ch WHERE ch.estado<>1 AND ch.id_centro=c.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as id_statush,
        (SELECT sg.nom_status FROM centro_historial ch LEFT JOIN status_general sg on sg.id_status_general=ch.estado WHERE ch.estado<>1 AND ch.id_centro=c.id_centro ORDER BY ch.fec_reg DESC LIMIT 1) as nom_status,
        DATE_FORMAT(c.fec_reg,'%d/%m/%Y') as fecha_registro,u.usuario_codigo
        FROM centro c 
        left join users u on c.user_reg=u.id_usuario
        WHERE c.id_centro=$id_centro";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_direccion_centro($id_centro)
    {

        $sql = "SELECT c.*,d.nombre_departamento,p.nombre_provincia,ds.nombre_distrito from centro_direccion c
        left JOIN departamento d on d.id_departamento=c.departamento
        LEFT JOIN provincia p on p.id_provincia=c.provincia
        LEFT JOIN distrito ds on ds.id_distrito=c.distrito
                where c.id_centro='$id_centro' and c.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_direccion_centro_cp($id_centro)
    {

        $sql = "SELECT c.*,d.nombre_departamento,p.nombre_provincia,ds.nombre_distrito from centro_direccion c
        left JOIN departamento d on d.id_departamento=c.departamento
        LEFT JOIN provincia p on p.id_provincia=c.provincia
        LEFT JOIN distrito ds on ds.id_distrito=c.distrito
                where c.id_centro='$id_centro' and c.estado=2 and c.cp=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_centro($id_centro)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE centro SET estado=4,fec_eli= NOW(),user_eli=$id_usuario 
            WHERE id_centro=$id_centro";

        $sql2 = " UPDATE centro_direccion SET estado=4,fec_eli= NOW(),user_eli=$id_usuario 
            WHERE id_centro=$id_centro";

        $sql3 = " UPDATE centro_especialidad SET estado=4,fec_eli= NOW(),user_eli=$id_usuario 
    WHERE id_centro=$id_centro";

        $this->db->query($sql);
        $this->db->query($sql3);
    }
    //---------------------------------------------ASIGNACIÓN DE CICLO---------------------------------------------
    function get_list_asignacion_ciclo()
    {
        $sql = "SELECT ac.*,ca.codigo,st.nom_status FROM asignacion_ciclo ac
            LEFT JOIN carrera ca on ca.id_carrera=ac.id_carrera
            LEFT JOIN status st on st.id_status=ac.estado
            WHERE ac.estado!=4";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_asignacion_ciclo($dato)
    {
        $sql = "SELECT * FROM asignacion_ciclo WHERE id_carrera='" . $dato['id_carrera'] . "' AND 
            ciclo='" . $dato['ciclo'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_asignacion_ciclo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO asignacion_ciclo (id_carrera,ciclo,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_carrera'] . "','" . $dato['ciclo'] . "',2,NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function get_id_asignacion_ciclo($id_asignacion_ciclo)
    {
        $sql = "SELECT * FROM asignacion_ciclo WHERE id_asignacion_ciclo=$id_asignacion_ciclo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_asignacion_ciclo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE asignacion_ciclo SET id_carrera='" . $dato['id_carrera'] . "',ciclo='" . $dato['ciclo'] . "',
            estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario 
            WHERE id_asignacion_ciclo='" . $dato['id_asignacion_ciclo'] . "'";

        $this->db->query($sql);
    }

    function delete_asignacion_ciclo($id_asignacion_ciclo)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE asignacion_ciclo SET estado=4,fec_eli= NOW(),user_eli=$id_usuario 
            WHERE id_asignacion_ciclo=$id_asignacion_ciclo";

        $this->db->query($sql);
    }
    //---------------------------------------------ASIGNACIÓN DE MODULO---------------------------------------------
    function get_list_asignacion_modulo()
    {
        $sql = "SELECT ac.*,ca.codigo,st.nom_status FROM asignacion_modulo ac
            LEFT JOIN carrera ca on ca.id_carrera=ac.id_carrera
            LEFT JOIN status st on st.id_status=ac.estado
            WHERE ac.estado!=4";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_asignacion_modulo($dato)
    {
        $sql = "SELECT * FROM asignacion_modulo WHERE id_carrera='" . $dato['id_carrera'] . "' AND 
            modulo='" . $dato['modulo'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_asignacion_modulo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO asignacion_modulo (id_carrera,modulo,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_carrera'] . "','" . $dato['modulo'] . "',2,NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function get_id_asignacion_modulo($id_asignacion_modulo)
    {
        $sql = "SELECT * FROM asignacion_modulo WHERE id_asignacion_modulo=$id_asignacion_modulo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_asignacion_modulo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE asignacion_modulo SET id_carrera='" . $dato['id_carrera'] . "',modulo='" . $dato['modulo'] . "',
            estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario 
            WHERE id_asignacion_modulo='" . $dato['id_asignacion_modulo'] . "'";

        $this->db->query($sql);
    }

    function delete_asignacion_modulo($id_asignacion_modulo)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE asignacion_modulo SET estado=4,fec_eli= NOW(),user_eli=$id_usuario 
            WHERE id_asignacion_modulo=$id_asignacion_modulo";

        $this->db->query($sql);
    }

    function insert_examen_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "insert into examen_ifv (nom_examen,fec_limite,fec_resultados,estado,fec_reg,user_reg) 
                values ('" . $dato['nom_examen'] . "',
                '" . $dato['fec_limite'] . "',
                '" . $dato['fec_resultados'] . "',
                '2',
                NOW()," . $id_usuario . ")";
        $this->db4->query($sql);
    }

    function list_examen_ifv()
    {
        $sql = "SELECT count(e.id_examen) AS cantidad,e.*,DATE_FORMAT(e.fec_limite,'%d/%m/%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados,'%d/%m/%Y') as fecha_resultados,
        case when e.estado=2 then 'Activo' when e.estado=3 then 'Inactivo' end as nom_status
        from examen_ifv e 
        left JOIN pregunta_admision p on p.id_examen=e.id_examen AND p.estado=2
        where e.estado in (2,3)
        group by e.id_examen";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }
    function list_examen_ifv2()
    {
        /*$sql = "SELECT count(e.id_examen) AS cantidad,e.id_examen,e.nom_examen,e.fec_limite,DATE_FORMAT(e.fec_limite,'%d/%m/%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados,'%d/%m/%Y') as fecha_resultados,count(pe.id_pe) as 'Enviados',
        count(case when pe.estado_pe = '30' then pe.id_pe end) as 'Sin Iniciar',
        count(case when pe.estado_pe = '33' then pe.id_pe end) as 'Sin Concluir',
        count(case when pe.estado_pe = '31' then pe.id_pe end) as 'Concluido',
        s.nom_status
        from examen_ifv e
        left join pos_exam pe on e.id_examen = pe.idexa_pe     
        left join status_general eg on  eg.id_status_general = pe.id_pe
        left join status s on s.id_status=e.estado
        where e.estado in (2,3)
        group by e.id_examen ORDER BY e.fec_limite DESC";

        $query = $this->db->query($sql)->result_Array();
        return $query;*/
        $sql = "SELECT count(e.id_examen) AS cantidad,e.id_examen,e.nom_examen,e.fec_limite,DATE_FORMAT(e.fec_limite,'%d/%m/%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados,'%d/%m/%Y') as fecha_resultados,count(pe.id_pe) as 'Enviados',
        count(case when pe.estado_pe = '30' then pe.id_pe end) as 'Sin Iniciar',
        count(case when pe.estado_pe = '33' then pe.id_pe end) as 'Sin Concluir',
        count(case when pe.estado_pe = '31' then pe.id_pe end) as 'Concluido',
        case when e.estado=2 then 'Activo' when e.estado=3 then 'Inactivo' end as nom_status
        from examen_ifv e
        left join pos_exam pe on e.id_examen = pe.idexa_pe
        where e.estado in (2,3)
        group by e.id_examen ORDER BY e.fec_limite DESC";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function list_examen_ifv3()
    {
        $sql = "SELECT re.id_examen,
        SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(re.fec_termino,tiempo_ini)))/count(pe.id_pe)) as Tiempo 
        ,sum(re.puntaje)/count(pe.id_pe) as Evaluacion
        from resultado_examen_ifv re
        left join pos_exam pe on re.id_examen = pe.idexa_pe and pe.estado_pe=31
        where estado = 31
        group by id_examen";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }


    function get_id_examen_ifv($id_examen)
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%Y-%m-%d') as fecha_limite,DATE_FORMAT(e.fec_resultados, '%Y-%m-%d') as fecha_resultados 
        FROM examen_ifv e where e.id_examen='$id_examen' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_examen_activo()
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%d/%m/%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados, '%d/%m/%Y') as fecha_resultados 
        FROM examen_ifv e where e.estado=2 and e.estado_contenido=1 ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_examen_activo_update($dato)
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%d/%m/%Y') as fecha_limite,DATE_FORMAT(e.fec_resultados, '%d/%m/%Y') as fecha_resultados 
        FROM examen_ifv e where e.estado=2 and e.estado_contenido=1 and id_examen<>'" . $dato['id_examen'] . "'";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function update_examen_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE examen_ifv set nom_examen='" . $dato['nom_examen'] . "',fec_limite='" . $dato['fec_limite'] . "',fec_resultados='" . $dato['fec_resultados'] . "',
        estado='" . $dato['estado'] . "',fec_act=NOW(),user_act='$id_usuario'  where id_examen='" . $dato['id_examen'] . "'";
        $this->db4->query($sql);
    }

    function update_examen_estado_contenido($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE examen_ifv set estado_contenido='" . $dato['estado_contenido'] . "'  where id_examen='" . $dato['id_examen'] . "'";
        $this->db4->query($sql);
    }

    function insert_examen_duplicado_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT into examen_ifv (nom_examen,fec_limite,fec_resultados,estado,estado_contenido,fec_reg,user_reg) 
                values ('" . $dato['nom_examen'] . "',
                '" . $dato['fec_limite'] . "',
                '" . $dato['fec_resultados'] . "',
                '2','1',
                NOW()," . $id_usuario . ")";
        $this->db4->query($sql);
    }

    function duplicar_examen_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO pregunta_admision (id_area,id_examen,pregunta,orden,img,estado,fec_reg,user_reg,id_pregunta_a) 
        SELECT id_area,'" . $dato['id_examen_nuevo'] . "',pregunta,orden,img,estado,NOW(),user_reg,id_pregunta FROM pregunta_admision where id_examen='" . $dato['id_examen_1'] . "' and estado=2";
        $this->db4->query($sql);
    }


    function copiar_preguntas_examen_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql2 = "INSERT INTO respuesta_admision (id_pregunta,id_area,desc_respuesta,correcto,estado,fec_reg,user_reg)
        SELECT p.id_pregunta,r.id_area,r.desc_respuesta,r.correcto,r.estado,NOW(),1 from respuesta_admision r
        left join pregunta_admision p on p.id_pregunta_a=r.id_pregunta
        WHERE r.estado=2 and p.id_examen='" . $dato['id_examen_nuevo'] . "'";
        $this->db4->query($sql2);
    }

    function ultimo_examen_ifv()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT id_examen from examen_ifv  order by id_examen desc limit 1";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function cargarpdf()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $path = $_FILES['img_comuimg_i']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'img_comuimg';
        $config['upload_path'] = './resultadoifv';
        $config['file_name'] = "resultados." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'resultadoifv' . '/' . $config['file_name'];

        $config['allowed_types'] = "PDF|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();
    }
    function cargarimg()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'img_comuimg';
        $config['upload_path'] = './imagenWeb';
        $config['file_name'] = "web." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'imagenWeb' . '/' . $config['file_name'];

        $config['allowed_types'] = "jpg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();
    }

    function get_list_especialidad()
    {
        $sql = "SELECT e.*,te.nom_tipo_especialidad FROM especialidad e
                LEFT JOIN tipo_especialidad te on te.id_tipo_especialidad=e.id_tipo_especialidad
                WHERE e.estado=2 and te.estado=2 ORDER BY e.nom_especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_especialidad_combo()
    {
        $sql = "SELECT id_especialidad,nom_especialidad,abreviatura 
                FROM especialidad 
                WHERE estado=2 
                ORDER BY nom_especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_especialidad_centro($id_centro)
    {
        $sql = "SELECT e.*,te.nom_tipo_especialidad,ce.id_centro_especialidad FROM especialidad e
        left join tipo_especialidad te on te.id_tipo_especialidad=e.id_tipo_especialidad
        LEFT JOIN centro_especialidad ce ON ce.id_especialidad=e.id_especialidad AND ce.id_centro=$id_centro AND ce.total!=''
        where e.estado=2 and te.estado=2 ORDER BY e.id_especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_direccion_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT c.*,d.nombre_departamento,p.nombre_provincia,ds.nombre_distrito from centro_direccion_temporal c
        left JOIN departamento d on d.id_departamento=c.departamento
        LEFT JOIN provincia p on p.id_provincia=c.provincia
        LEFT JOIN distrito ds on ds.id_distrito=c.distrito
                where c.user_reg='$id_usuario' ORDER BY c.id_direccion_temporal ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_direccion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT c.*,d.nombre_departamento,p.nombre_provincia,ds.nombre_distrito from centro_direccion c
        left JOIN departamento d on d.id_departamento=c.departamento
        LEFT JOIN provincia p on p.id_provincia=c.provincia
        LEFT JOIN distrito ds on ds.id_distrito=c.distrito
                where c.id_centro='" . $dato['id_centro'] . "' and c.estado=2 ORDER BY c.id_centro_direccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_especialidad()
    {
        $sql = "SELECT * from producto_especialidad where estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_preguardado_producto_especialidad()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT e.*,ce.id_especialidad_temporal from producto_especialidad e
        left join centro_especialidad_temporal ce on ce.id_producto=e.id_producto and ce.user_reg='$id_usuario'
        where e.estado='2' ORDER BY e.id_producto ASC";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_guardado_producto_especialidad($id_centro)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT e.*,ce.id_centro_especialidad from producto_especialidad e
        left join centro_especialidad ce on ce.id_producto=e.id_producto and ce.id_centro='$id_centro'
        where e.estado='2' ORDER BY e.id_producto ASC";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_centro_direccion($dato)
    {
        $sql = "SELECT * FROM centro_direccion where id_centro_direccion='" . $dato['id_centro_direccion'] . "' ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_centro_direccion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE centro_direccion set direccion='" . $dato['direccion'] . "',departamento='" . $dato['departamento'] . "',provincia='" . $dato['provincia'] . "',distrito='" . $dato['distrito'] . "',cp='" . $dato['cp'] . "',contacto_dir='" . $dato['contacto_dir'] . "',
        celular_dir='" . $dato['celular_dir'] . "',tel_fijo='" . $dato['tel_fijo'] . "',correo_dir='" . $dato['correo_dir'] . "',
        fec_act=NOW(),user_act='$id_usuario'  where id_centro_direccion='" . $dato['id_centro_direccion'] . "'";
        $this->db->query($sql);
    }

    function get_busqueda_centro($dato)
    {
        if ($dato['parametro'] == 1) {
            $estado = "(48,49,50,51,52,55)";
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

                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=5)>0 THEN 'Sí' ELSE 'No' END AS especialida_et,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=6)>0 THEN 'Sí' ELSE 'No' END AS especialida_ft,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=7)>0 THEN 'Sí' ELSE 'No' END AS especialida_ae,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=8)>0 THEN 'Sí' ELSE 'No' END AS especialida_cf,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=9)>0 THEN 'Sí' ELSE 'No' END AS especialida_ds,

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
                    WHERE (SELECT ch.estado FROM centro_historial ch 
                    WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro 
                    ORDER BY ch.fec_reg DESC LIMIT 1) in $estado";
        } else {
            $estado = "(48,50,55)";
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

                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=5)>0 THEN 'Sí' ELSE 'No' END AS especialida_et,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=6)>0 THEN 'Sí' ELSE 'No' END AS especialida_ft,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=7)>0 THEN 'Sí' ELSE 'No' END AS especialida_ae,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=8)>0 THEN 'Sí' ELSE 'No' END AS especialida_cf,
                    CASE WHEN (SELECT COUNT(ced.id_especialidad) FROM centro_especialidad ced 
                    WHERE ce.id_centro=ced.id_centro AND ced.id_especialidad=9)>0 THEN 'Sí' ELSE 'No' END AS especialida_ds,

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
                    WHERE (SELECT ch.estado FROM centro_historial ch 
                    WHERE ch.estado<>1 AND ch.id_centro=ce.id_centro 
                    ORDER BY ch.fec_reg DESC LIMIT 1) in $estado ORDER BY nom_status DESC";
        }
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

    function update_estado_centro_xdireccion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE centro set estado='" . $dato['estado'] . "' where id_centro='" . $dato['id_centro'] . "'";
        $this->db->query($sql);

        $sql2 = "UPDATE centro_historial SET estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario WHERE id_centro_historial='" . $dato['id_ultimo_historial'] . "'";
        echo $sql2;
        $this->db->query($sql2);
    }

    function get_id_centro_archivo($id_centro)
    {
        $sql = "SELECT * from centro where id_centro=" . $id_centro . "";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_centro_archivo($id_centro)
    {
        $sql = "update centro set documento='' WHERE id_centro=$id_centro";
        $this->db->query($sql);
    }

    function get_list_documentos_centro($id_centro)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from centro_documento d
        where d.estado=2 and d.id_centro=$id_centro ORDER BY d.id_centro_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_centro_archivo($dato)
    {
        $sql = "SELECT * FROM centro_documento WHERE id_centro='" . $dato['id_centro'] . "' AND estado=2 and nombre='" . $dato['nombre'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_centro_archivo2($dato)
    {
        $sql = "SELECT * FROM centro_documento WHERE id_centro='" . $dato['id_centro'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_archivo_centro($dato)
    {

        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');

        $path = $_FILES['archivo']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'archivo';
        $config['upload_path'] = './centro_documento/' . $dato['referencia'] . '/';
        $config['file_name'] = "centro" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'centro_documento/' . $dato['referencia'] . '/' . $config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|xls|xlsx|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        $sql = "INSERT INTO centro_documento (id_centro,nombre,archivo,estado,fec_reg, user_reg) 
                VALUES ('" . $dato['id_centro'] . "','" . $dato['nombre'] . "','" . $ruta . "',2,NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function get_id_documento_historial_centro($id_historial)
    {
        $sql = "SELECT * from centro_documento where id_centro_documento=" . $id_historial . "";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_centro_documento_historial($id_historial)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE centro_documento set estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_centro_documento=$id_historial";
        $this->db->query($sql);
    }

    function get_list_accion_centro()
    {
        $sql = "SELECT * from accion where estado=2 and id_modulo=2 ORDER BY nom_accion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_centro_historial($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO centro_historial (id_centro,fecha_accion,id_accion,observacion,comentario,estado, fec_reg,user_reg)
                values ( '" . $dato['id_centro'] . "', '" . $dato['fecha_accion'] . "','" . $dato['id_accion'] . "','" . $dato['observacion'] . "','" . $dato['comentario'] . "','" . $dato['id_status'] . "',NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function get_list_centro_historial($id_centro)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT h.*,a.nom_accion,u.usuario_codigo,Date_format(h.fecha_accion,'%d/%m/%Y') as fec_accion,
        s.nom_status
        from centro_historial h
        left join accion a on a.id_accion=h.id_accion
        left join status_general s on s.id_status_general=h.estado
        left join users u on u.id_usuario=h.user_reg
        where h.estado<>1 and h.id_centro=$id_centro  ORDER BY h.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_centro_historial($id_centro_historial)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE centro_historial set estado=1,fec_eli=NOW(),user_eli=$id_usuario WHERE id_centro_historial=$id_centro_historial";
        $this->db->query($sql);
    }

    function get_id_historial_centro($id_centro_historial)
    {
        $sql = "SELECT h.* FROM centro_historial h 
        where h.id_centro_historial='$id_centro_historial' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_centro_historial($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE centro_historial SET fecha_accion='" . $dato['fecha_accion'] . "',comentario='" . $dato['comentario'] . "',
        observacion='" . $dato['observacion'] . "',id_accion='" . $dato['id_accion'] . "',estado='" . $dato['id_status'] . "',fec_act= NOW(),user_act=$id_usuario 
            WHERE id_centro_historial='" . $dato['id_centro_historial'] . "'";

        $this->db->query($sql);
    }

    function valida_agregar_accion_centro($dato)
    {
        $sql = "SELECT * from centro_historial where id_centro='" . $dato['id_centro'] . "' and estado<>1 and id_accion='" . $dato['id_accion'] . "' and estado='" . $dato['id_status'] . "' and observacion='" . $dato['observacion'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_agregar_accion_centro_2($dato)
    {
        $sql = "SELECT * from centro_historial where id_centro='" . $dato['id_centro'] . "' and estado<>1 and comentario='" . $dato['comentario'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_agregar_accion_centro_e($dato)
    {
        $sql = "SELECT * from centro_historial where id_centro='" . $dato['id_centro'] . "' and estado<>1 and id_accion='" . $dato['id_accion'] . "' and estado='" . $dato['id_status'] . "' and observacion='" . $dato['observacion'] . "' and id_centro_historial<>'" . $dato['id_centro_historial'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_agregar_accion_centro_2e($dato)
    {
        $sql = "SELECT * from centro_historial where id_centro='" . $dato['id_centro'] . "' and estado<>1 and comentario='" . $dato['comentario'] . "' and id_centro_historial<>'" . $dato['id_centro_historial'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //--------------------------------REGISTROS---------------------------
    function get_list_registro_fv($id_registro = null)
    {
        if (isset($id_registro) && $id_registro > 0) {
            $sql = "SELECT re.*,DATE_FORMAT(re.fec_revisado,'%d-%m-%Y %H:%i:%s') AS f_rev,CASE WHEN re.segundo_estado=1 
                    THEN 'Registrado' WHEN re.segundo_estado=2 THEN 'Enviado' WHEN re.segundo_estado=3 THEN 'Confirmado' 
                    ELSE '' END AS seg_estado,us.usuario_codigo AS u_rev 
                    FROM registro_fv re
                    LEFT JOIN users us ON us.id_usuario=re.user_revisado
                    WHERE re.id_registro=$id_registro";
        } else {
            $sql = "SELECT re.*,CASE WHEN re.tipo=1 THEN 'Actas' WHEN re.tipo=2 THEN 'Nominas' WHEN re.tipo=3 THEN 'Titulación' ELSE '' END AS nom_tipo,
                    CONCAT(me.nom_mes,'-',re.ref_anio,'-',(CASE WHEN re.ref_lugar=1 THEN 'Chincha' WHEN re.ref_lugar=2 THEN 'Lima' ELSE '' END)) AS referencia,
                    DATE_FORMAT(re.fecha_envio,'%d-%m-%Y') AS fec_envio,CASE WHEN re.segundo_estado=1 THEN 'Registrado' WHEN re.segundo_estado=2 THEN 'Enviado' 
                    WHEN re.segundo_estado=3 THEN 'Confirmado' ELSE '' END AS segundo_estado,CASE WHEN re.tabla_alumno_arpay='' THEN 'No' ELSE 'Si' END AS t_archivo,
                    CASE WHEN re.registro_apuntes='' THEN 'No' ELSE 'Si' END AS r_archivo,CASE WHEN re.documento_enviado='' THEN 'No' ELSE 'Si' END AS de_archivo,
                    CASE WHEN re.documento_recibido='' THEN 'No' ELSE 'Si' END AS dr_archivo,CASE WHEN re.primer_estado=0 THEN 'Pendiente' ELSE 'Revisado'
                    END AS primer_estado,es.nom_especialidad
                    FROM registro_fv re
                    LEFT JOIN mes me ON me.cod_mes=re.ref_mes
                    LEFT JOIN especialidad es ON es.id_especialidad=re.id_especialidad
                    WHERE re.estado=2 ORDER BY re.tipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio()
    {
        $sql = "SELECT id_anio,nom_anio FROM anio 
                WHERE estado=1 
                ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_mes()
    {
        $sql = "SELECT cod_mes,nom_mes FROM mes WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO registro_fv (tipo,ref_mes,ref_anio,ref_lugar,id_especialidad,grupo,fecha_envio,n_alumnos,producto,tabla_alumno_arpay,
                registro_apuntes,documento_enviado,documento_recibido,primer_estado,segundo_estado,estado,fec_reg,user_reg)
                VALUES ('" . $dato['tipo'] . "', '" . $dato['ref_mes'] . "','" . $dato['ref_anio'] . "','" . $dato['ref_lugar'] . "','" . $dato['id_especialidad'] . "',
                '" . $dato['grupo'] . "','" . $dato['fecha_envio'] . "', '" . $dato['n_alumnos'] . "','" . $dato['producto'] . "','" . $dato['tabla_alumno_arpay'] . "',
                '" . $dato['registro_apuntes'] . "','" . $dato['documento_enviado'] . "','" . $dato['documento_recibido'] . "','" . $dato['primer_estado'] . "',
                '" . $dato['segundo_estado'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
        /*$sql = "INSERT INTO registro_fv (tipo,ref_mes,ref_anio,ref_lugar,grupo,fecha_envio,n_alumnos,producto,observaciones,tabla_alumno_arpay,
                registro_apuntes,documento_enviado,documento_recibido,segundo_estado,estado,fec_reg,user_reg)
                VALUES ('".$dato['tipo']."', '".$dato['ref_mes']."','".$dato['ref_anio']."','".$dato['ref_lugar']."','".$dato['grupo']."',
                '".$dato['fecha_envio']."', '".$dato['n_alumnos']."','".$dato['producto']."','".$dato['observaciones']."',
                '".$dato['tabla_alumno_arpay']."','".$dato['registro_apuntes']."','".$dato['documento_enviado']."',
                '".$dato['documento_recibido']."','".$dato['segundo_estado']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
        if($dato['primer_estado']==1){
            $sql2 = "UPDATE registro_fv SET primer_estado='".$dato['primer_estado']."',fec_revisado=NOW(),user_revisado=$id_usuario
                    WHERE id_registro=(SELECT id_registro FROM registro_fv WHERE estado=2 ORDER BY id_registro DESC LIMIT 1)";
            $this->db->query($sql2);
        }*/
    }

    function delete_registro($id_registro)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_fv SET estado=1,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_registro=$id_registro";
        $this->db->query($sql);
    }

    function update_registro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_fv SET tipo='" . $dato['tipo'] . "',ref_mes='" . $dato['ref_mes'] . "',ref_anio='" . $dato['ref_anio'] . "',
                ref_lugar='" . $dato['ref_lugar'] . "',id_especialidad='" . $dato['id_especialidad'] . "',grupo='" . $dato['grupo'] . "',
                fecha_envio='" . $dato['fecha_envio'] . "',n_alumnos='" . $dato['n_alumnos'] . "',producto='" . $dato['producto'] . "',
                observaciones='" . $dato['observaciones'] . "',tabla_alumno_arpay='" . $dato['tabla_alumno_arpay'] . "',
                registro_apuntes='" . $dato['registro_apuntes'] . "',documento_enviado='" . $dato['documento_enviado'] . "',
                documento_recibido='" . $dato['documento_recibido'] . "',segundo_estado='" . $dato['segundo_estado'] . "',fec_act=NOW(),
                user_act=$id_usuario 
                WHERE id_registro='" . $dato['id_registro'] . "'";
        $this->db->query($sql);
        if ($dato['primer_estado'] == 1) {
            $sql2 = "UPDATE registro_fv SET primer_estado='" . $dato['primer_estado'] . "',fec_revisado=NOW(),user_revisado=$id_usuario
                    WHERE id_registro='" . $dato['id_registro'] . "'";
            $this->db->query($sql2);
        } else {
            $sql2 = "UPDATE registro_fv SET primer_estado='" . $dato['primer_estado'] . "',fec_revisado=NULL,user_revisado=0
                    WHERE id_registro='" . $dato['id_registro'] . "'";
            $this->db->query($sql2);
        }
    }

    function list_tipo_especialidad()
    {
        $sql = "SELECT e.* from tipo_especialidad e  where e.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_especialidad($dato)
    {
        $sql = "SELECT e.* from especialidad e where e.estado=2 and id_tipo_especialidad='" . $dato['id_tipo_especialidad'] . "'
        and nom_especialidad='" . $dato['nom_especialidad'] . "' and abreviatura='" . $dato['abreviatura'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cantidad_especialidad()
    {
        $sql = "SELECT e.* from especialidad e ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_upd_especialidad($dato)
    {
        $sql = "SELECT e.* from especialidad e where e.estado=2 and id_tipo_especialidad='" . $dato['id_tipo_especialidad'] . "'
        and nom_especialidad='" . $dato['nom_especialidad'] . "' and abreviatura='" . $dato['abreviatura'] . "'
        and id_especialidad<>'" . $dato['id_especialidad'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_producto_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_especialidad (id_tipo_especialidad,id_especialidad,nom_producto,
                estado,fec_reg,user_reg)
                VALUES ('" . $dato['id_tipo_especialidad'] . "', (select r.id_especialidad from especialidad r where cod_especialidad='" . $dato['cod_especialidad'] . "' and r.estado=2),'" . $dato['nom_producto'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_producto_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE producto_especialidad set estado='1',
        fec_eli=NOW(),user_eli='$id_usuario' where id_especialidad='" . $dato['id_especialidad'] . "' and
        id_tipo_especialidad='" . $dato['id_tipo_especialidad'] . "' and nom_producto='" . $dato['nom_producto'] . "'";
        $this->db->query($sql);
    }
    function valida_reg_producto_especialidad($dato)
    {
        $sql = "SELECT e.* from producto_especialidad e where e.estado=2 and id_tipo_especialidad='" . $dato['id_tipo_especialidad'] . "'
        and id_especialidad='" . $dato['id_especialidad'] . "' and nom_producto='" . $dato['nom_producto'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_historial_comunicacion($id_historial_archivo)
    {
        $sql = "SELECT * FROM comunicaion_img WHERE id_historial_archivo=$id_historial_archivo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_archivo_comunicacion($id_comuimg)
    {
        $sql = "UPDATE comunicaion_img set img_comuimg='' WHERE id_comuimg=$id_comuimg";
        $this->db->query($sql);
    }

    function insertar_reglamento($dato)
    {


        $sql1 = "UPDATE comunicaion_img set estado=3 where estado=1 and tipo_comuimg=3";
        $this->db->query($sql1);


        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        if ($dato['path'] != "") {
            $sql = "INSERT INTO 
            comunicaion_img
            (
                flag_referencia,
                refe_comuimg,
                img_comuimg,
                inicio_comuimg,
                fin_comuimg,
                estado,
                tipo_comuimg,
                fec_reg,user_reg)
                values (
                3,
                '" . $dato['referencia'] . "',
                '" . $dato['ruta'] . "',
                '" . $dato['inicio'] . "',
                '" . $dato['fin'] . "',
                1,
                3,
                NOW(),
                $id_usuario
            )";
        } else {
            $sql = "INSERT INTO 
            comunicaion_img 
            (
                flag_referencia
                refe_comuimg,
                inicio_comuimg,
                fin_comuimg,
                estado,
                tipo_comuimg,
                fec_reg,
                user_reg)
                values (
                3,
                '" . $dato['referencia'] . "',
                '" . $dato['inicio'] . "',
                '" . $dato['fin'] . "',
                1,
                3,
                NOW(),
                '" . $id_usuario . "'
            )";
        }
        $this->db->query($sql);
    }

    function cargarpdf_reglamento()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'archivo';
        $config['upload_path'] = './reglamento';
        $config['file_name'] = "reglamento." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'reglamento' . '/' . $config['file_name'];

        $config['allowed_types'] = "PDF|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();
    }

    function list_reglamento($id_comuimg = null)
    {
        if (isset($id_comuimg) && $id_comuimg > 0) {
            $sql = "SELECT 
            ci.*,
            CONCAT(u.usuario_nombres,' ',u.usuario_apater) as creado_por,
            s.nom_status
            from comunicaion_img ci
            left join users u on u.id_usuario=ci.user_reg
            left join statusav s on s.id_statusav=ci.estado
            where ci.id_comuimg=$id_comuimg";
        } else {
            $sql = "SELECT ci.*,CONCAT(u.usuario_nombres,' ',u.usuario_apater) as creado_por,
            date_format(ci.inicio_comuimg, '%d/%m/%Y') as inicio_comuimg,date_format(ci.fin_comuimg, '%d/%m/%Y') as fin_comuimg,
            date_format(ci.fec_reg, '%d/%m/%Y') as fec_reg,s.nom_status
            from comunicaion_img ci
            left join users u on u.id_usuario=ci.user_reg
            left join statusav s on s.id_statusav=ci.estado
            where ci.tipo_comuimg=3
            ORDER BY ci.inicio_comuimg DESC,s.nom_status ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_reglamento($dato)
    {
        $fecha = date('Y-m-d');
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img_comuimg';
        $config['upload_path'] = './reglamento/';
        $config['file_name'] = "reglamento" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'reglamento/' . $config['file_name'];

        $config['allowed_types'] = "PDF|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();


        //solo debe hacer uno solo activo para reglamento

        if ($dato['estado'] == 1) {
            $sql1 = "
            UPDATE comunicaion_img set 
            estado=3
             where estado=1 and 
            tipo_comuimg=3
            ";
            $this->db->query($sql1);
        }

        if ($path != "") {

            $sql = "UPDATE comunicaion_img set 
            flag_referencia  = 3,
            cod_referencia=0,
            tipo_comuimg=3,
            refe_comuimg='" . $dato['referencia'] . "',
            img_comuimg='" . $ruta . "',
            inicio_comuimg='" . $dato['inicio'] . "',
            fin_comuimg='" . $dato['fin'] . "',
            estado='1',
            user_act=$id_usuario,
            fec_act=NOW()
            where
            id_comuimg=" . $dato['id_comuimg'];
        } else {
            $sql = "UPDATE comunicaion_img set
            flag_referencia  = 3, 
            cod_referencia=0,
            tipo_comuimg=3,
            refe_comuimg='" . $dato['referencia'] . "',
            inicio_comuimg='" . $dato['inicio'] . "',
            fin_comuimg='" . $dato['fin'] . "',
            estado='1',
            user_act=$id_usuario,fec_act=NOW()
            where
            id_comuimg=" . $dato['id_comuimg'];
        }
        $this->db->query($sql);



        return $config['file_name'];
    }
    //---------------------------------------GRUPO C---------------------------------------------------------
    function get_list_grupo_c($tipo)
    {
        $parte = "";
        if ($tipo == 1) {
            /*$parte = "AND gc.estado_grupo not in (4) AND 
                    (abs(TIMESTAMPDIFF(DAY,gc.fin_clase,CURDATE()))>=42 OR 
                    abs(TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase))<=42)";
            $parte = "AND gc.estado_grupo NOT IN (4) AND 
                    (gc.fin_clase>=CURDATE() OR (gc.fin_clase<=CURDATE() AND
                    TIMESTAMPDIFF(DAY,gc.fin_clase,CURDATE())<=42)) AND
                    (gc.inicio_clase<=CURDATE() OR (gc.inicio_clase>=CURDATE() AND
                    TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase)>=42))";*/
            $parte = "AND gc.estado_grupo NOT IN (2,4,5,6) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 28 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 28 DAY)";
        }

        /*(SELECT COUNT(1) FROM todos_l20 ma 
        WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND 
        ma.Matricula='Asistiendo' AND ma.Alumno='Matriculado') AS matriculados,
        (SELECT COUNT(1) FROM todos_l20 ma 
        WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND 
        ma.Matricula='Promovido' AND ma.Alumno='Matriculado') AS promovidos
        (SELECT COUNT(1) FROM todos_l20 ma 
        WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND
        ma.Matricula='Retirado' AND ma.Alumno='Retirado') AS retirados,*/
        if ($tipo == 1) {
            $sql = "SELECT gc.id_grupo,gc.cod_grupo,gc.grupo,es.nom_especialidad,mo.modulo,ci.ciclo,gc.id_turno,
                gc.id_seccion,sa.descripcion AS nom_salon,ho.nom_turno,es.abreviatura,
                DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS ini_clases,DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clases,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND ag.alumno='Matriculado') AS matriculados,gc.id_salon,sa.capacidad,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Promovido' AND ag.alumno='Matriculado') AS promovidos,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Retirado' AND ag.alumno='Retirado') AS retirados,
                doc_subidos_grupo(gc.id_grupo) AS docs, 
                CASE WHEN gc.salir_matriculados=1 THEN 'Si' ELSE 'No' END AS s_matriculados,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Matricula='Cancelado') AS pago_matricula,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Cuota_1='Cancelado') AS pago_cuota,  
                md.nom_maestro_detalle AS nom_estado_grupo, md.color_maestro_detalle as colorgrupo,
                gc.estado_grupo,gc.inicio_clase,
                TIMESTAMPDIFF(DAY,CURDATE(),gc.fin_clase) AS diferencia_dias,
                sa.disponible,gc.fin_clase,gc.inicio_campania,gc.primer_examen,gc.segundo_examen,gc.tercer_examen,
                gc.cuarto_examen,gc.quinto_examen,gc.matricula_regular_ini,gc.matricula_regular_fin,
                gc.matricula_extemporanea_ini,gc.matricula_extemporanea_fin, WEEKOFYEAR(gc.inicio_clase) as semana
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN salon sa ON sa.id_salon=gc.id_salon
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                LEFT JOIN maestro_detalle md ON md.id_maestro_detalle =gc.estado_grupo
                WHERE gc.estado=2 $parte
                ORDER BY gc.inicio_clase ASC,es.nom_especialidad ASC,ci.ciclo ASC,tu.nom_turno ASC";
        } elseif ($tipo == 3) {
            $sql = "SELECT gc.id_grupo,gc.cod_grupo,gc.grupo,es.nom_especialidad,mo.modulo,ci.ciclo,gc.id_turno,
                gc.id_seccion,sa.descripcion AS nom_salon,ho.nom_turno,es.abreviatura,
                DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS ini_clases,DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clases,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND ag.alumno='Matriculado') AS matriculados,gc.id_salon,sa.capacidad,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Promovido' AND ag.alumno='Matriculado') AS promovidos,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Retirado' AND ag.alumno='Retirado') AS retirados,
                doc_subidos_grupo(gc.id_grupo) AS docs, 
                CASE WHEN gc.salir_matriculados=1 THEN 'Si' ELSE 'No' END AS s_matriculados,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Matricula='Cancelado') AS pago_matricula,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Cuota_1='Cancelado') AS pago_cuota,  
                md.nom_maestro_detalle AS nom_estado_grupo, md.color_maestro_detalle as colorgrupo,
                gc.estado_grupo,gc.inicio_clase,
                TIMESTAMPDIFF(DAY,CURDATE(),gc.fin_clase) AS diferencia_dias,
                sa.disponible,gc.fin_clase,gc.inicio_campania,gc.primer_examen,gc.segundo_examen,gc.tercer_examen,
                gc.cuarto_examen,gc.quinto_examen,gc.matricula_regular_ini,gc.matricula_regular_fin,
                gc.matricula_extemporanea_ini,gc.matricula_extemporanea_fin, WEEKOFYEAR(gc.inicio_clase) as semana
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN salon sa ON sa.id_salon=gc.id_salon
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                LEFT JOIN maestro_detalle md ON md.id_maestro_detalle =gc.estado_grupo
                WHERE gc.estado=2 and gc.estado_grupo=5
                ORDER BY gc.inicio_clase ASC,es.nom_especialidad ASC,ci.ciclo ASC,tu.nom_turno ASC";
        } elseif ($tipo == 2) {
            $sql = "SELECT gc.id_grupo,gc.cod_grupo,gc.grupo,es.nom_especialidad,mo.modulo,ci.ciclo,gc.id_turno,
                gc.id_seccion,sa.descripcion AS nom_salon,ho.nom_turno,es.abreviatura,
                DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS ini_clases,DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clases,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND ag.alumno='Matriculado') AS matriculados,gc.id_salon,sa.capacidad,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Promovido' AND ag.alumno='Matriculado') AS promovidos,
                (SELECT COUNT(1) FROM alumno_grupo ag
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Retirado' AND ag.alumno='Retirado') AS retirados,
                doc_subidos_grupo(gc.id_grupo) AS docs, 
                CASE WHEN gc.salir_matriculados=1 THEN 'Si' ELSE 'No' END AS s_matriculados,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Matricula='Cancelado') AS pago_matricula,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                LEFT JOIN todos_l20 td ON td.Id=ag.id_alumno AND td.Tipo=1
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND 
                ag.alumno='Matriculado' AND td.Estado_Cuota_1='Cancelado') AS pago_cuota,  
                md.nom_maestro_detalle AS nom_estado_grupo, md.color_maestro_detalle as colorgrupo,
                gc.estado_grupo,gc.inicio_clase,
                TIMESTAMPDIFF(DAY,CURDATE(),gc.fin_clase) AS diferencia_dias,
                sa.disponible,gc.fin_clase,gc.inicio_campania,gc.primer_examen,gc.segundo_examen,gc.tercer_examen,
                gc.cuarto_examen,gc.quinto_examen,gc.matricula_regular_ini,gc.matricula_regular_fin,
                gc.matricula_extemporanea_ini,gc.matricula_extemporanea_fin, WEEKOFYEAR(gc.inicio_clase) as semana
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN salon sa ON sa.id_salon=gc.id_salon
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN maestro_detalle md ON md.id_maestro_detalle =gc.estado_grupo
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE gc.estado=2
                ORDER BY gc.inicio_clase ASC,es.nom_especialidad ASC,ci.ciclo ASC,tu.nom_turno ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grupo_c_total()
    {
        $sql = "SELECT (SELECT SUM(promovidos) FROM vista_grupo_matriculados_promovidos) AS total_promovidos, 
                (SELECT SUM(matriculados) FROM vista_grupo_matriculados_promovidos) AS total_matriculados";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_matriculados_c_total()
    {
        $sql = "SELECT (SELECT COUNT(*) FROM todos_l20 WHERE Matricula='Promovido' AND Alumno='Matriculado') as total_a_promovidos, 
            (SELECT COUNT(*) FROM todos_l20 WHERE Alumno='Matriculado' AND todos_l20.Matricula='Asistiendo') as total_a_matriculados";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_modulo_disponible($id_especialidad)
    {
        $sql = "SELECT * FROM modulo WHERE id_especialidad=$id_especialidad AND estado=2
                ORDER BY modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_ciclo_disponible($id_especialidad, $id_modulo)
    {
        $sql = "SELECT * FROM ciclo WHERE id_especialidad=$id_especialidad AND id_modulo=$id_modulo AND estado=2
                ORDER BY ciclo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function traer_detalle_grupo_c($grupo, $id_especialidad, $id_modulo)
    {
        $sql = "SELECT s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13,s14,s15,s16,s17,s18,s19,s20,mas1,c_matriculados_1,c_proyeccion,
                c_postulados,c_rechazados,c_admitidos,c_matriculados_2
                FROM detalle_grupo_calendarizacion 
                WHERE grupo='$grupo' AND id_especialidad=$id_especialidad AND id_modulo=$id_modulo AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grupo_c($dato)
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion 
                WHERE cod_grupo='" . $dato['cod_grupo'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grupo_c_2($dato)
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion 
                WHERE grupo='" . $dato['grupo'] . "' AND id_especialidad='" . $dato['id_especialidad'] . "' AND 
                id_modulo='" . $dato['id_modulo'] . "' AND id_ciclo='" . $dato['id_ciclo'] . "' AND 
                id_turno='" . $dato['id_turno'] . "' AND id_seccion='" . $dato['id_seccion'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_grupo_c()
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha_hoy = date('Y-m-d');
        if ($dato['inicio_clase'] > $fecha_hoy) {
            $estado_grupo = 1;
        } elseif ($fecha_hoy >= $dato['inicio_clase'] && $fecha_hoy <= $dato['fin_clase']) {
            $estado_grupo = 3;
        } elseif ($fecha_hoy > $dato['fin_clase']) {
            $estado_grupo = 5;
        }

        /*$path1 = $_FILES['horario_grupo']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        $config['upload_path'] = './Grupo_Horario/';
        
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre="Documento_".date('d-m-Y')."_".rand(10,199);
        $ruta="";
        if($path1!=""){
            $ruta='./Grupo_Horario/'.$nombre.".".$ext1;
            if (!empty($_FILES['horario_grupo']['name'])){
                $config['upload_path'] = './Grupo_Horario/';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = $nombre.".".$ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('horario_grupo')){
                    $documento = $this->upload->data();
                }else{
                    echo $this->upload->display_errors();
                }
            }
        }*/
        //horario_grupo,horario_pdf,  '$ruta','".$dato['horario_pdf']."',
        $sql = "INSERT INTO grupo_calendarizacion (cod_grupo,grupo,id_especialidad,id_modulo,
                id_ciclo,anio_inicio,semana_inicio,inicio_clase,fin_clase,id_turno,id_seccion,id_salon,inicio_campania,
                primer_examen,segundo_examen,tercer_examen,cuarto_examen,quinto_examen,
                matricula_regular_ini,matricula_regular_fin,matricula_extemporanea_ini,
                matricula_extemporanea_fin,estado,estado_grupo,fec_reg,
                user_reg) 
                VALUES('" . $dato['cod_grupo'] . "','" . $dato['grupo'] . "','" . $dato['id_especialidad'] . "',
                '" . $dato['id_modulo'] . "','" . $dato['id_ciclo'] . "','" . $dato['anio'] . "','" . $dato['semana_inicio'] . "','" . $dato['inicio_clase'] . "',
                '" . $dato['fin_clase'] . "','" . $dato['id_turno'] . "','" . $dato['id_seccion'] . "',
                '" . $dato['id_salon'] . "','" . $dato['inicio_campania'] . "','" . $dato['primer_examen'] . "',
                '" . $dato['segundo_examen'] . "','" . $dato['tercer_examen'] . "',
                '" . $dato['cuarto_examen'] . "','" . $dato['quinto_examen'] . "',
                '" . $dato['matricula_regular_ini'] . "','" . $dato['matricula_regular_fin'] . "',
                '" . $dato['matricula_extemporanea_ini'] . "','" . $dato['matricula_extemporanea_fin'] . "',
                2,$estado_grupo,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_grupo()
    {
        $sql = "SELECT id_grupo,inicio_clase,id_turno,TIMESTAMPDIFF(DAY,inicio_clase,fin_clase) AS dias
                FROM grupo_calendarizacion 
                ORDER BY id_grupo DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_grupo_c_inicial($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO documento_grupo (tipo,nom_documento,id_grupo,estado_d,estado,
                fec_reg,user_reg) 
                VALUES(1,'" . utf8_decode('Horario Tamaño 1410 x 410') . "','" . $dato['id_grupo'] . "',1,2,NOW(),
                $id_usuario)";
        $this->db->query($sql);

        $sql1 = "INSERT INTO documento_grupo (tipo,nom_documento,id_grupo,estado_d,estado,
                fec_reg,user_reg) 
                VALUES(2,'" . utf8_decode('Horario Tamaño 387 x 575') . "','" . $dato['id_grupo'] . "',1,2,NOW(),
                $id_usuario)";
        $this->db->query($sql1);

        $sql2 = "INSERT INTO documento_grupo (tipo,nom_documento,id_grupo,estado_d,estado,
                fec_reg,user_reg) 
                VALUES(3,'Horario Académico','" . $dato['id_grupo'] . "',1,2,NOW(),
                $id_usuario)";
        $this->db->query($sql2);

        $sql3 = "INSERT INTO documento_grupo (tipo,nom_documento,id_grupo,estado_d,estado,
                fec_reg,user_reg) 
                VALUES(4,'Horario EFSRT','" . $dato['id_grupo'] . "',1,2,NOW(),
                $id_usuario)";
        $this->db->query($sql3);
    }

    function get_id_grupo_c($id_grupo)
    {
        $sql = "SELECT gc.*,es.nom_especialidad,mo.modulo,ci.ciclo,ho.nom_turno,
                DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS inicio,
                DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS termino,
                CASE WHEN gc.salir_matriculados=1 THEN 'Si' ELSE 'No' END AS s_matriculados,
                CONCAT(DATE_FORMAT(ho.desde,'%H'),'h',DATE_FORMAT(ho.desde,'%i'),' a ',
                DATE_FORMAT(ho.hasta,'%H'),'h',DATE_FORMAT(ho.hasta,'%i')) AS horario_clase,
                (SELECT COUNT(1) FROM grupo_horario gh 
                WHERE gh.id_grupo=gc.id_grupo AND gh.estado=2) AS dias_clase,
                (SELECT SUM(gh.horas) FROM grupo_horario gh 
                WHERE gh.id_grupo=gc.id_grupo AND gh.estado=2) AS horas_clase,
                TIMESTAMPDIFF(DAY,inicio_clase,fin_clase) AS dias
                FROM grupo_calendarizacion gc
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno 
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE gc.id_grupo=$id_grupo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_asociar_alumno($id_alumno = null)
    {
        if (isset($id_alumno) && $id_alumno > 0) {
            $sql = "SELECT  * FROM todos_l20 
                    WHERE Id=$id_alumno";
        } else {
            $sql = "SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Dni,Codigo,Matricula,Alumno
                    FROM todos_l20 
                    WHERE Tipo=1 AND Id NOT IN (SELECT id_alumno FROM alumno_grupo) and (Matricula='Asistiendo' or Alumno='Matriculado')";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_asociar_alumno($id_alumno)
    {
        $sql = "SELECT id FROM alumno_grupo WHERE id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_dias_marcaciones_alumno($id_alumno)
    {
        $sql = "SELECT COUNT(1) AS cantidad 
                FROM registro_asistencia 
                WHERE id_alumno='$id_alumno' AND fecha>='" . date('Y-m-d') . "'";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function valida_todos_dias_marcaciones_alumno($id_alumno)
    {
        $sql = "SELECT fecha FROM registro_asistencia 
                WHERE id_alumno='$id_alumno'
                ORDER BY fecha DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function insert_asociar_alumno_cabecera($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_grupo (id_grupo,id_alumno,apellido_paterno,apellido_materno,
                nombres,dni,codigo,matricula,alumno,fecha_cumpleanos) 
                VALUES ('" . $dato['id_grupo'] . "','" . $dato['id_alumno'] . "',
                '" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['dni'] . "','" . $dato['codigo'] . "',
                '" . $dato['matricula'] . "','" . $dato['alumno'] . "','" . $dato['fecha_cumpleanos'] . "')";
        $this->db->query($sql);
    }

    function insert_asociar_alumno_marcaciones($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO registro_asistencia (id_alumno,fecha,desde,hasta,tolerancia,id_turno,especialidad,id_grupo,grupo,modulo,seccion,codigo,apater,amater,
        nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
        estado_asistencia,laborable,
        estado,fec_reg,user_reg) 
        VALUES ('" . $dato['id_alumno'] . "','" . $dato['fecha'] . "','" . $dato['desde'] . "','" . $dato['hasta'] . "','" . $dato['tolerancia'] . "','" . $dato['id_turno'] . "',
        '" . $dato['especialidad'] . "','" . $dato['id_grupo'] . "','" . $dato['grupo'] . "','" . $dato['modulo'] . "','" . $dato['seccion'] . "','" . $dato['codigo'] . "',
        '" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
        '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
        '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
        2,GETDATE(),0)";
        $this->db5->query($sql);
    }

    function insert_dia_marcaciones_docente_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        if ($dato['ch_m'] == 1) {
            $sql = "INSERT INTO registro_asistencia_docente (id_empresa,id_docente,id_horario,fecha,desde,hasta,tolerancia,id_turno,
                codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
                estado_asistencia,laborable,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['id_colaborador'] . "','" . $dato['id_horario'] . "','" . $dato['fecha'] . "','" . $dato['ingreso_m'] . "','" . $dato['salida_m'] . "','30','1',
                '" . $dato['codigo'] . "','" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
                '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
                2,GETDATE(),0)";
            $this->db5->query($sql);
        }
        if ($dato['ch_alm'] == 1) {
            $sql = "INSERT INTO registro_asistencia_docente (id_empresa,id_docente,id_horario,fecha,desde,hasta,tolerancia,id_turno,
                codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
                estado_asistencia,laborable,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['id_colaborador'] . "','" . $dato['id_horario'] . "','" . $dato['fecha'] . "','" . $dato['ingreso_alm'] . "','" . $dato['salida_alm'] . "','30','2',
                '" . $dato['codigo'] . "','" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
                '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
                2,GETDATE(),0)";
            $this->db5->query($sql);
        }
        if ($dato['ch_t'] == 1) {
            $sql = "INSERT INTO registro_asistencia_docente (id_empresa,id_docente,id_horario,fecha,desde,hasta,tolerancia,id_turno,
                codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
                estado_asistencia,laborable,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['id_colaborador'] . "','" . $dato['id_horario'] . "','" . $dato['fecha'] . "','" . $dato['ingreso_t'] . "','" . $dato['salida_t'] . "','30','3',
                '" . $dato['codigo'] . "','" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
                '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
                2,GETDATE(),0)";
            $this->db5->query($sql);
        }
        if ($dato['ch_c'] == 1) {
            $sql = "INSERT INTO registro_asistencia_docente (id_empresa,id_docente,id_horario,fecha,desde,hasta,tolerancia,id_turno,
                codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
                estado_asistencia,laborable,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['id_colaborador'] . "','" . $dato['id_horario'] . "','" . $dato['fecha'] . "','" . $dato['ingreso_c'] . "','" . $dato['salida_c'] . "','30','4',
                '" . $dato['codigo'] . "','" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
                '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
                2,GETDATE(),0)";
            $this->db5->query($sql);
        }
        if ($dato['ch_n'] == 1) {
            $sql = "INSERT INTO registro_asistencia_docente (id_empresa,id_docente,id_horario,fecha,desde,hasta,tolerancia,id_turno,
                codigo,apater,amater,
                nombres,estado_ingreso,estado_reporte,user_autorizado,flag_sabado,flag_domingo,flag_festivo,
                estado_asistencia,laborable,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['id_colaborador'] . "','" . $dato['id_horario'] . "','" . $dato['fecha'] . "','" . $dato['ingreso_n'] . "','" . $dato['salida_n'] . "','30','5',
                '" . $dato['codigo'] . "','" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "',
                '" . $dato['nombres'] . "','" . $dato['estado_ingreso'] . "','0','0','" . $dato['flag_sabado'] . "','" . $dato['flag_domingo'] . "','" . $dato['flag_festivo'] . "',
                '" . $dato['estado_asistencia'] . "','" . $dato['laborable'] . "',
                2,GETDATE(),0)";
            $this->db5->query($sql);
        }
    }

    /*function get_list_alumno_grupo_c($grupo,$especialidad,$id_seccion){
        $sql = "SELECT td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,td.Codigo,td.Matricula,td.Alumno,td.Dni,
                (SELECT COUNT(1) FROM documento_alumno_empresa da 
                WHERE da.id_empresa=6 AND da.obligatorio=1 AND da.estado=2) AS documentos_obligatorios,
                (SELECT COUNT(1) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.obligatorio=1 AND da.estado=2 AND 
                de.id_alumno=td.Id AND de.archivo!='' AND de.estado=2) AS documentos_subidos
                FROM todos_l20 td
                WHERE td.Tipo=1 AND td.Grupo='$grupo' AND Especialidad='$especialidad' AND 
                td.Seccion='$id_seccion' AND td.Alumno='Matriculado' AND td.Matricula='Asistiendo'
                ORDER BY td.Apellido_Paterno ASC,td.Apellido_Materno ASC,td.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_alumno_grupo_c($id_grupo, $especialidad)
    {
        $sql = "SELECT cod_grupo,grupo,abreviatura,nom_especialidad,modulo,ho.nom_turno,ciclo,id_seccion,id,
                (SELECT COUNT(1) FROM alumno_grupo ag 
                WHERE ag.id_grupo=gc.id_grupo AND ag.matricula='Asistiendo' AND ag.alumno='Matriculado') AS matriculado,
                apellido_paterno AS Apellido_Paterno,apellido_materno AS Apellido_Materno,
                nombres AS Nombre,dni AS Dni,codigo AS Codigo,matricula AS Matricula,
                alumno AS Alumno,
                documentos_obligatorios_fv('$especialidad') AS documentos_obligatorios,
                documentos_subidos_fv('$especialidad',id_alumno) AS documentos_subidos/*,
                '-' as referencia,'-' as grupo_r,'-' as seccion_r,'-' as turno_r,'-' as modulo_r,'-' as ciclo_r*/
                FROM alumno_grupo a
                left join grupo_calendarizacion gc on a.id_grupo = gc.id_grupo
                left join especialidad e on gc.id_especialidad=e.id_especialidad
                left join modulo m on gc.id_modulo=m.id_modulo
                left join turno t on gc.id_turno=t.id_turno
                left join ciclo c on gc.id_ciclo=c.id_ciclo
                left join hora ho ON ho.id_hora=t.id_hora
                WHERE a.id_grupo=$id_grupo AND matricula='Asistiendo' AND alumno='Matriculado'
                ORDER BY apellido_paterno ASC,apellido_materno ASC,nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grupo_traslado()
    {
        $sql = "SELECT gc.id_grupo,
                CONCAT(gc.grupo,' - ',es.nom_especialidad,' - ',mo.modulo,' - ',ho.nom_turno,' - ',gc.id_seccion) AS grupo
                FROM grupo_calendarizacion gc
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE gc.estado=2 AND gc.estado_grupo NOT IN (2,4,5,6) AND
                NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 28 DAY) AND
                NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 28 DAY)
                GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno,gc.id_seccion
                ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC,gc.id_seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_asociar_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_grupo SET id_grupo='" . $dato['id_grupo'] . "' 
                WHERE id='" . $dato['id'] . "'";
        $this->db->query($sql);
    }

    function delete_asociar_grupo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_grupo SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id='" . $dato['id'] . "'";
        $this->db->query($sql);
    }

    function get_list_documento_grupo_c($id_grupo)
    {
        $sql = "SELECT dg.id_documento,dg.nom_documento,CASE WHEN dg.estado_d=1 THEN 'Pendiente' 
                WHEN dg.estado_d=2 THEN 'Subido' ELSE '' END AS nom_estado,
                dg.archivo,SUBSTRING_INDEX(dg.archivo,'/',-1) AS nom_archivo,
                DATE_FORMAT(dg.fecha,'%d-%m-%Y') AS fecha,us.usuario_codigo AS usuario
                FROM documento_grupo dg
                LEFT JOIN users us ON us.id_usuario=dg.usuario
                WHERE dg.id_grupo=$id_grupo AND dg.estado=2
                ORDER BY dg.nom_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_grupo (nom_documento,id_grupo,estado_d,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['nom_documento'] . "','" . $dato['id_grupo'] . "',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_grupo_c_ids()
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_grupo($id_documento)
    {
        $sql = "SELECT * FROM documento_grupo 
                WHERE id_documento=$id_documento";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_grupo SET archivo='" . $dato['archivo'] . "',estado_d=2,
                fecha=NOW(),usuario=$id_usuario,fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }

    function delete_documento_grupo_c($dato)
    {
        $sql = "UPDATE documento_grupo SET archivo='',estado_d=1,fecha=NULL,usuario=0
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }

    function get_list_horario_grupo($id_grupo)
    {
        $sql = "SELECT gh.id_horario,gh.fecha AS orden,gh.semana,
                CASE WHEN MONTH(gh.fecha)=1 THEN CONCAT(DAY(gh.fecha),'-ene')
                WHEN MONTH(gh.fecha)=2 THEN CONCAT(DAY(gh.fecha),'-feb')
                WHEN MONTH(gh.fecha)=3 THEN CONCAT(DAY(gh.fecha),'-mar')
                WHEN MONTH(gh.fecha)=4 THEN CONCAT(DAY(gh.fecha),'-abr')
                WHEN MONTH(gh.fecha)=5 THEN CONCAT(DAY(gh.fecha),'-may')
                WHEN MONTH(gh.fecha)=6 THEN CONCAT(DAY(gh.fecha),'-jun')
                WHEN MONTH(gh.fecha)=7 THEN CONCAT(DAY(gh.fecha),'-jul')
                WHEN MONTH(gh.fecha)=8 THEN CONCAT(DAY(gh.fecha),'-ago')
                WHEN MONTH(gh.fecha)=9 THEN CONCAT(DAY(gh.fecha),'-sep')
                WHEN MONTH(gh.fecha)=10 THEN CONCAT(DAY(gh.fecha),'-oct')
                WHEN MONTH(gh.fecha)=11 THEN CONCAT(DAY(gh.fecha),'-nov')
                WHEN MONTH(gh.fecha)=12 THEN CONCAT(DAY(gh.fecha),'-dic')
                ELSE '' END AS fecha_corta,
                DATE_FORMAT(gh.fecha,'%d/%m/%Y') AS fecha,
                ho.nom_turno,CASE WHEN DATE_FORMAT(gh.fecha,'%W')='Monday' THEN 'Lunes' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Tuesday' THEN 'Martes' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Wednesday' THEN 'Miércoles' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Thursday' THEN 'Jueves' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Friday' THEN 'Viernes' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Saturday' THEN 'Sábado' 
                WHEN DATE_FORMAT(gh.fecha,'%W')='Sunday' THEN 'Domingo' 
                ELSE '' END dia,
                CONCAT(DATE_FORMAT(gh.desde,'%H'),'h',DATE_FORMAT(gh.desde,'%i')) AS desde,
                CONCAT(DATE_FORMAT(gh.hasta,'%H'),'h',DATE_FORMAT(gh.hasta,'%i')) AS hasta,
                gh.desde AS desde_horario,gh.hasta AS hasta_horario,gh.tolerancia,
                eh.nom_estado,gh.horas,gh.id_turno
                FROM grupo_horario gh
                LEFT JOIN grupo_calendarizacion gr ON gr.id_grupo=gh.id_grupo
                LEFT JOIN turno tu ON gh.id_turno=tu.id_turno
                left join hora ho on tu.id_hora=ho.id_hora
                LEFT JOIN estado_horario eh ON eh.id_estado=gh.estado_h
                WHERE gh.id_grupo=$id_grupo
                ORDER BY gh.fecha ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_horario_grupo($id_horario)
    {
        $sql = "SELECT * FROM grupo_horario 
                WHERE id_horario=$id_horario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado_horario()
    {
        $sql = "SELECT * FROM estado_horario 
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_horario_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_horario SET estado_h='" . $dato['estado_h'] . "',
                horas='" . $dato['horas'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_horario='" . $dato['id_horario'] . "'";
        $this->db->query($sql);
    }

    function get_list_asistencia_grupo_c($grupo, $especialidad, $id_seccion, $inicio, $fin)
    {
        $sql = "SELECT ri.codigo,ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno IN (SELECT Id FROM todos_l20 
                WHERE Tipo=1 AND Grupo='$grupo' AND Especialidad='$especialidad' AND Seccion='$id_seccion') AND 
                DATE(ri.ingreso) BETWEEN '$inicio' AND '$fin' 
                ORDER BY ri.ingreso DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_retirado_grupo_c($id_grupo, $especialidad)
    {
        $sql = "SELECT id AS Id,apellido_paterno AS Apellido_Paterno,apellido_materno AS Apellido_Materno,
                nombres AS Nombre,dni AS Dni,codigo AS Codigo,matricula AS Matricula,
                alumno AS Alumno,
                documentos_obligatorios_fv('$especialidad') AS documentos_obligatorios,
                documentos_subidos_fv('$especialidad',id_alumno) AS documentos_subidos
                FROM alumno_grupo
                WHERE id_grupo=$id_grupo AND alumno='Retirado' AND estado=2
                ORDER BY apellido_paterno ASC,apellido_materno ASC,nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad_didactica_grupo_c($id_especialidad)
    {
        $sql = "SELECT ud.id_unidad_didactica,ud.cod_unidad_didactica,ud.nom_unidad_didactica,ud.creditos,
                ud.puntaje_minimo,ud.ciclo_academico,mo.modulo,co.nom_competencia
                FROM unidad_didactica ud
                LEFT JOIN modulo mo ON mo.id_modulo=ud.id_modulo
                LEFT JOIN competencia co ON co.id_competencia=ud.id_competencia
                WHERE ud.id_especialidad=$id_especialidad AND ud.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_grupo_c($id_grupo)
    {
        $sql = "SELECT gr.id_observacion,gr.id_tipo,
                CASE WHEN gr.id_tipo=1 THEN 'Alumnos' 
                WHEN gr.id_tipo=2 THEN 'Traslados'
                WHEN gr.id_tipo=3 THEN 'Documentos'
                WHEN gr.id_tipo=4 THEN 'Horario'
                WHEN gr.id_tipo=5 THEN 'Asistencia'
                WHEN gr.id_tipo=6 THEN 'Retirados'
                WHEN gr.id_tipo=7 THEN 'Unidades Didácticas'
                WHEN gr.id_tipo=8 THEN 'Evaluaciones'
                WHEN gr.id_tipo=9 THEN 'EFSRT'
                WHEN gr.id_tipo=10 THEN 'Comercial'
                WHEN gr.id_tipo=11 THEN 'Generales'
                ELSE '' END AS nom_tipo,
                DATE_FORMAT(gr.fecha,'%d-%m-%Y') AS fecha,
                us.usuario_codigo AS usuario,gr.observacion,
                gr.fecha AS orden
                FROM grupo_observaciones gr
                LEFT JOIN users us ON us.id_usuario=gr.usuario
                WHERE gr.id_grupo=$id_grupo AND gr.estado=2
                ORDER BY gr.fecha DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO grupo_observaciones (id_grupo,id_tipo,fecha,usuario,observacion,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_grupo'] . "','" . $dato['id_tipo'] . "','" . $dato['fecha'] . "',
                '" . $dato['usuario'] . "','" . $dato['observacion'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_observacion_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_observaciones SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db->query($sql);
    }

    function get_id_grupo_calendario($id_grupo = null, $id_especialidad = null, $id_modulo = null)
    {
        $sql = "SELECT * FROM detalle_grupo_calendarizacion 
        WHERE grupo='" . $id_grupo . "' 
        AND id_especialidad='" . $id_especialidad . "' 
        AND id_modulo='" . $id_modulo . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_grupo_c($dato)
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion 
                WHERE cod_grupo='" . $dato['cod_grupo'] . "' AND estado=2 AND 
                id_grupo!='" . $dato['id_grupo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_grupo_c_2($dato)
    {
        $sql = "SELECT id_grupo FROM grupo_calendarizacion 
                WHERE grupo='" . $dato['grupo'] . "' AND id_especialidad='" . $dato['id_especialidad'] . "' AND 
                id_modulo='" . $dato['id_modulo'] . "' AND id_ciclo='" . $dato['id_ciclo'] . "' AND 
                id_turno='" . $dato['id_turno'] . "' AND id_seccion='" . $dato['id_seccion'] . "' AND estado=2 AND
                id_grupo!='" . $dato['id_grupo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_estado_grupo_c($grupo, $especialidad, $id_seccion)
    {
        $sql = "SELECT COUNT(1) FROM todos_l20 
                WHERE Tipo=1 AND Grupo='$grupo' AND Especialidad='$especialidad' AND Seccion='$id_seccion' AND
                Alumno='Matriculado'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        /*$path1 = $_FILES['horario_grupo']['name'];
        $path2 = $_FILES['horario_grupo_cel']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
        $config['upload_path'] = './Grupo_Horario/';
        
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre="Documento_".date('d-m-Y')."_".rand(10,199);
        $ruta=$dato['get_id'][0]['horario_grupo'];
        $ruta2=$dato['get_id'][0]['horario_grupo_cel'];
        if($path1!=""){
            $ruta='./Grupo_Horario/'.$nombre.".".$ext1;
            if (!empty($_FILES['horario_grupo']['name'])){
                $config['upload_path'] = './Grupo_Horario/';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = $nombre.".".$ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('horario_grupo')){
                    $documento = $this->upload->data();
                }else{
                    echo $this->upload->display_errors();
                }
            }
            if(isset($dato['get_id'][0]['horario_grupo']) && $dato['get_id'][0]['horario_grupo']!=""){
                if (file_exists($dato['get_id'][0]['horario_grupo'])) {
                    unlink($dato['get_id'][0]['horario_grupo']);
                }
            } 
        }

        if($path2!=""){
            $ruta2='./Grupo_Horario/'.$nombre."1.".$ext2;
            if (!empty($_FILES['horario_grupo_cel']['name'])){
                $config['upload_path'] = './Grupo_Horario/';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = $nombre."1.".$ext2;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('horario_grupo_cel')){
                    $documento = $this->upload->data();
                }else{
                    echo $this->upload->display_errors();
                }
            }
            if(isset($dato['get_id'][0]['horario_grupo_cel']) && $dato['get_id'][0]['horario_grupo_cel']!=""){
                if (file_exists($dato['get_id'][0]['horario_grupo_cel'])) {
                    unlink($dato['get_id'][0]['horario_grupo_cel']);
                }
            } 
        }*/
        //horario_grupo='$ruta',horario_grupo_cel='$ruta2',horario_pdf='".$dato['horario_pdf']."',
        if ($dato['estado_grupo'] != 0) {
            $sql = "UPDATE grupo_calendarizacion SET cod_grupo='" . $dato['cod_grupo'] . "',
                    grupo='" . $dato['grupo'] . "',id_especialidad='" . $dato['id_especialidad'] . "',
                    id_modulo='" . $dato['id_modulo'] . "',id_ciclo='" . $dato['id_ciclo'] . "',
                    inicio_clase='" . $dato['inicio_clase'] . "',fin_clase='" . $dato['fin_clase'] . "',
                    id_turno='" . $dato['id_turno'] . "',id_seccion='" . $dato['id_seccion'] . "',
                    id_salon='" . $dato['id_salon'] . "',salir_matriculados='" . $dato['salir_matriculados'] . "',
                    estado_grupo='" . $dato['estado_grupo'] . "',fec_act=NOW(),user_act=$id_usuario
                    WHERE id_grupo='" . $dato['id_grupo'] . "'";
        } else {

            $fecha_hoy = date('Y-m-d');
            if ($dato['inicio_clase'] > $fecha_hoy) {
                $estado_grupo = 1;
            } elseif ($fecha_hoy >= $dato['inicio_clase'] && $fecha_hoy <= $dato['fin_clase']) {
                $estado_grupo = 3;
            } elseif ($fecha_hoy > $dato['fin_clase']) {
                $estado_grupo = 5;
            }

            $sql = "UPDATE grupo_calendarizacion SET cod_grupo='" . $dato['cod_grupo'] . "',
                    grupo='" . $dato['grupo'] . "',id_especialidad='" . $dato['id_especialidad'] . "',
                    id_modulo='" . $dato['id_modulo'] . "',id_ciclo='" . $dato['id_ciclo'] . "',
                    inicio_clase='" . $dato['inicio_clase'] . "',fin_clase='" . $dato['fin_clase'] . "',
                    anio_inicio='" . $dato['anio'] . "',semana_inicio='" . $dato['semana_inicio'] . "',
                    id_turno='" . $dato['id_turno'] . "',id_seccion='" . $dato['id_seccion'] . "',
                    id_salon='" . $dato['id_salon'] . "',salir_matriculados='" . $dato['salir_matriculados'] . "',
                    estado_grupo='" . $estado_grupo . "',fec_act=NOW(),user_act=$id_usuario
                    WHERE id_grupo='" . $dato['id_grupo'] . "'";
        }
        $this->db->query($sql);
    }

    function delete_grupo_horario($dato)
    {
        $sql = "DELETE FROM grupo_horario 
                WHERE id_grupo='" . $dato['id_grupo'] . "'";
        $this->db->query($sql);
    }

    function delete_detalle_grupo_c($dato)
    {
        $sql = "DELETE FROM detalle_grupo_calendarizacion 
                WHERE grupo='" . $dato['grupo'] . "' 
                AND id_especialidad='" . $dato['id_especialidad'] . "' 
                AND id_modulo='" . $dato['id_modulo'] . "'";
        $this->db->query($sql);
    }

    function insert_detalle_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_grupo_calendarizacion (grupo,id_especialidad,id_modulo,s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13,
                s14,s15,s16,s17,s18,s19,s20,mas1,c_matriculados_1,c_proyeccion,c_postulados,c_rechazados,c_admitidos,c_matriculados_2,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['grupo'] . "','" . $dato['id_especialidad'] . "','" . $dato['id_modulo'] . "','" . $dato['s1'] . "','" . $dato['s2'] . "',
                '" . $dato['s3'] . "','" . $dato['s4'] . "','" . $dato['s5'] . "','" . $dato['s6'] . "','" . $dato['s7'] . "','" . $dato['s8'] . "',
                '" . $dato['s9'] . "','" . $dato['s10'] . "','" . $dato['s11'] . "','" . $dato['s12'] . "','" . $dato['s13'] . "','" . $dato['s14'] . "',
                '" . $dato['s15'] . "','" . $dato['s16'] . "','" . $dato['s17'] . "','" . $dato['s18'] . "','" . $dato['s19'] . "','" . $dato['s20'] . "',
                '" . $dato['mas1'] . "','" . $dato['c_matriculados_1'] . "','" . $dato['c_proyeccion'] . "','" . $dato['c_postulados'] . "',
                '" . $dato['c_rechazados'] . "','" . $dato['c_admitidos'] . "','" . $dato['c_matriculados_2'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_festivo_grupo_c_horario($fecha)
    {
        $sql = "SELECT id_calendar_festivo FROM calendar_festivo 
                WHERE id_empresa=6 AND DATE(inicio)='$fecha' AND id_tipo_fecha=5 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grupo_c_horario($id_grupo)
    {
        $sql = "SELECT id_horario FROM grupo_horario
                WHERE id_grupo=$id_grupo AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_grupo_c_horario($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO grupo_horario (id_grupo,fecha,desde,hasta,tolerancia,id_turno,semana,estado_h,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_grupo'] . "','" . $dato['fecha'] . "','" . $dato['desde'] . "','" . $dato['hasta'] . "','" . $dato['tolerancia'] . "',
                '" . $dato['id_turno'] . "','" . $dato['semana'] . "',
                '" . $dato['estado_h'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_grupo_horario($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_calendarizacion SET id_horario='" . $dato['id_horario'] . "' 
                WHERE id_grupo='" . $dato['id_grupo'] . "'";
        $this->db->query($sql);
    }

    function update_grupo_profesor($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_calendarizacion SET id_profesor='" . $dato['id_profesor'] . "'
                WHERE id_grupo='" . $dato['id_grupo'] . "'";
        $this->db->query($sql);
    }

    function delete_grupo_c($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_calendarizacion SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_grupo='" . $dato['id_grupo'] . "'";
        $this->db->query($sql);
        $sql2 = "DELETE FROM alumno_grupo WHERE id_grupo=" . $dato['id_grupo'];
        $this->db->query($sql2);
        $sql3 = "DELETE FROM registro_asistencia WHERE id_grupo=" . $dato['id_grupo'];
        $this->db->query($sql3);
    }
    //---------------------------------------INFORME C---------------------------------------------------------
    function get_list_informe_c($anio)
    {
        $sql = "SELECT es.abreviatura,es.nom_especialidad,es.color,
                (SELECT WEEK(gi.inicio_clase) as semana FROM grupo_calendarizacion gi 
                WHERE gi.id_especialidad=es.id_especialidad AND YEAR(gi.inicio_clase)=$anio ORDER BY semana ASC LIMIT 1) AS inicio_clase,
                (SELECT WEEK(gf.fin_clase) as semana  FROM grupo_calendarizacion gf 
                WHERE gf.id_especialidad=es.id_especialidad AND YEAR(gf.fin_clase)=$anio ORDER BY semana  DESC LIMIT 1) AS fin_clase
                FROM especialidad es
                WHERE es.estado=2 
                ORDER BY es.abreviatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    /*function get_list_informe_c(){ 
        $sql = "SELECT es.abreviatura,DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS inicio_clase,DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clase,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Alumno='Matriculado' AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad) AS matriculados,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Alumno NOT IN ('Matriculado','Retirado') AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad) AS sin_matricular,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Alumno='Retirado' AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad) AS retirados
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad 
                WHERE gc.estado_grupo=1 AND gc.estado=2 
                ORDER BY es.abreviatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function get_list_cuadro_c($anio)
    {
        $sql = "SELECT es.abreviatura,(SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND SUBSTRING(ma.Grupo,1,2)=$anio AND ma.Matricula='Asistiendo' AND ma.Alumno='Matriculado' AND 
                ma.Especialidad=es.nom_especialidad) AS matriculados, 
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND SUBSTRING(ma.Grupo,1,2)=$anio AND ma.Matricula!='Asistiendo' AND ma.Alumno!='Matriculado' AND 
                ma.Especialidad=es.nom_especialidad) AS sin_matricular 
                FROM especialidad es 
                WHERE es.estado=2 ORDER BY es.abreviatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //------------------------------------MATRICULADOS-----------------------------------------------
    function get_list_matriculados($tipo)
    {
        $where = "";
        $todo = "";
        $parte = "";
        $left = "";
        if ($tipo == 1) {
            $where = "WHERE ag.alumno='Matriculado' AND tl.matricula='Asistiendo'";
        } elseif ($tipo == 2) {
            $where = "WHERE tl.Tipo=1";
        } elseif ($tipo == 3) {
            $parte = "tl.Fecha_Fin_Arpay,(SELECT ar.id_alumno_retirado FROM alumno_retirado ar 
            WHERE ar.Id=tl.Id AND ar.id_empresa=6 AND ar.estado=2) AS id_alumno_retirado,";
            //$where="WHERE tl.Alumno='Retirado' AND tl.Matricula='Retirado' AND tl.Grupo>=22/1 and tl.TIPO=1";
            $where = "WHERE ag.alumno='Retirado' AND ag.matricula='Retirado' AND gc.grupo>=22/1";
        } elseif ($tipo == 4) {
            $where = "WHERE ag.alumno='Matriculado' AND ag.matricula='Promovido'";
        }

        $sql = "SELECT tl.Id,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,
                es.nom_especialidad AS Especialidad,max(gc.grupo) AS Grupo,max(ho.nom_turno) AS Turno,
                max(mo.modulo) AS Modulo,max(ci.ciclo) AS Ciclo,max(gc.id_seccion) AS Seccion,tl.Matricula,
                tl.Alumno,tl.Celular,tl.Email,$parte
                CASE WHEN tl.Pago_Pendiente=0 THEN 'Al Día' 
                WHEN tl.Pago_Pendiente=1 THEN 'Pendiente 1' 
                WHEN tl.Pago_Pendiente=2 THEN 'Pendiente 2' ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,CASE WHEN tl.Pago_Pendiente=0 THEN '#92D050' 
                WHEN tl.Pago_Pendiente=1 THEN '#7F7F7F' 
                WHEN tl.Pago_Pendiente=2 THEN '#F8CBAD' ELSE '#C00000' END AS color_pago_pendiente,
                fotocheck_matriculados(tl.Id) AS v_fotocheck
                FROM todos_l20 tl
                LEFT JOIN alumno_grupo ag ON tl.Id=ag.id_alumno
                LEFT JOIN grupo_calendarizacion gc ON ag.id_grupo=gc.id_grupo
                LEFT JOIN especialidad es ON gc.id_especialidad=es.id_especialidad
                LEFT JOIN modulo mo ON gc.id_modulo=mo.id_modulo
                LEFT JOIN ciclo ci ON gc.id_ciclo=ci.id_ciclo
                LEFT JOIN turno tu ON gc.id_turno=tu.id_turno
                LEFT JOIN hora ho ON tu.id_hora=ho.id_hora
                $where
                group by tl.id";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_matriculados_excel($tipo)
    {
        $where = "";
        $todo = "";
        $parte = "";
        $left = "";
        if ($tipo == 1) {
            $where = " WHERE tl.Alumno='Matriculado' AND tl.Matricula='Asistiendo' and tl.TIPO=1";
        } elseif ($tipo == 2) {
            $where = "WHERE tl.Tipo=1";
        } elseif ($tipo == 3) {
            $parte = "(SELECT ar.id_alumno_retirado FROM alumno_retirado ar 
            WHERE ar.Id=tl.Id AND ar.id_empresa=6 AND ar.estado=2) AS id_alumno_retirado,";
            $where = " WHERE tl.Alumno='Retirado' AND tl.Matricula='Retirado' AND tl.Grupo>=22/1 and tl.TIPO=1";
        } elseif ($tipo == 4) {
            $where = " WHERE tl.Alumno='Matriculado' AND tl.Matricula='Promovido' and tl.TIPO=1";
        }

        /*tl.Especialidad,tl.Grupo,tl.Turno,tl.Modulo,
                (SELECT ci.ciclo FROM ciclo ci 
                LEFT JOIN grupo_calendarizacion gc ON gc.id_ciclo=ci.id_ciclo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                WHERE gc.grupo=tl.Grupo AND es.nom_especialidad=tl.Especialidad AND 
                mo.modulo=tl.Modulo AND gc.id_seccion=tl.Seccion
                LIMIT 1) AS Ciclo,tl.Seccion,*/
        $sql = "SELECT tl.Id,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,
                es.nom_especialidad AS Especialidad,gc.grupo AS Grupo,ho.nom_turno AS Turno,
                mo.modulo AS Modulo,ci.ciclo AS Ciclo,gc.id_seccion AS Seccion,tl.Matricula,
                tl.Alumno,tl.Celular,tl.Email,tl.Dni,tl.Email_Corporativo as Email_Corp,$parte
                CASE WHEN tl.Pago_Pendiente=0 THEN 'Al Día' 
                WHEN tl.Pago_Pendiente=1 THEN 'Pendiente 1' 
                WHEN tl.Pago_Pendiente=2 THEN 'Pendiente 2' ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,CASE WHEN tl.Pago_Pendiente=0 THEN '#92D050' 
                WHEN tl.Pago_Pendiente=1 THEN '#7F7F7F' 
                WHEN tl.Pago_Pendiente=2 THEN '#F8CBAD' ELSE '#C00000' END AS color_pago_pendiente,
                fotocheck_matriculados(tl.Id) AS v_fotocheck, comentariog, cie.correo as Correo_Institucional
                FROM todos_l20 tl
                LEFT JOIN alumno_grupo ag ON ag.id_alumno=tl.Id
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                LEFT JOIN correo_inst_empresa cie ON cie.id_alumno=tl.Id AND cie.id_empresa=6
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno 
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                $where";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function truncate_matriculados()
    {
        $sql = "TRUNCATE TABLE todos_l20";
        $this->db->query($sql);
    }

    function get_list_matriculados_arpay()
    {
        $sql = "SELECT results.Id,results.IdentityCardNumber,results.Email,results.CareerGroupText,results.FirstName,results.MotherSurname,  
                results.FatherSurname,results.InternalStudentId,results.CareerName,results.CareerShifts,results.Module,  
                results.MatriculationStatus,results.StudentStatus,results.Fecha_Cumpleanos,results.MobilePhone,results.Seccion,results.Pago_Pendiente,
                results.Documento_Pendiente,results.Observation,results.Fotocheck,results.Documento_Foto,results.Usuario_Foto,results.Fecha_Foto,
                results.Documento_Dni,results.Usuario_Dni,results.Fecha_Dni,results.Observaciones_Arpay,results.Motivo_Arpay,results.Fecha_Fin_Arpay
                FROM (SELECT c.Id,p.IdentityCardNumber,p.Email,cg.[Name] AS CareerGroupText,p.FirstName AS FirstName,p.MotherSurname AS MotherSurname,  
                p.FatherSurname AS FatherSurname,c.InternalStudentId AS InternalStudentId,ct.[Description] AS CareerName,    
                (SELECT STRING_AGG(results.Txt, ', ') FROM (SELECT DISTINCT CASE WHEN st.ShiftId = 0 THEN 'MN' WHEN st.ShiftId = 1 THEN 'TR' WHEN st.ShiftId = 2 
                THEN 'NC' ELSE 'ON' END AS Txt  FROM University.StudentMatriculation stuMat  
                JOIN University.TeachingUnitDateShift tuds ON tuds.Id = stuMat.TeachingUnitDateShiftId
                JOIN University.TeachingUnit teachUnits ON teachUnits.Id = tuds.TeachingUnitId
                JOIN University.Module module ON module.Id = teachUnits.ModuleId  
                JOIN University.ShiftTranslation st ON st.ShiftId = tuds.ShiftId AND st.[Language] = 'es-PE'  
                WHERE stuMat.ClientId = c.Id AND module.CareerId = m.CareerId AND stuMat.UniversityMatriculationId = sm.UniversityMatriculationId) results) AS CareerShifts,  
                (SELECT CASE WHEN res.Txt IS NULL THEN NULL ELSE CONCAT('M', res.Txt) END  
                FROM (SELECT MAX(module.OrderNumber) AS Txt  
                FROM University.StudentMatriculation stuMat  
                JOIN University.TeachingUnitDateShift tuds ON tuds.Id = stuMat.TeachingUnitDateShiftId   
                JOIN University.TeachingUnit t ON t.Id = tuds.TeachingUnitId  
                JOIN University.Module module ON module.Id = tu.ModuleId  
                WHERE stuMat.ClientId = c.Id AND module.CareerId = m.CareerId) res) AS Module,  
                CASE WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1) THEN 'Asistiendo'  
                WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1) THEN (SELECT TOP 1 sutMatStat.Description FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1)  
                WHEN sm.StudentMatriculationStatusId = 3 THEN sms.Description  
                ELSE 'Retirado' END AS MatriculationStatus,  
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN c.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.[Description] END AS StudentStatus,FORMAT(p.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,p.MobilePhone,
                (SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm 
                LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                WHERE stm.ClientId=c.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=c.Id AND cp.PaymentStatusId=2 AND cp.Description LIKE 'Cuota%' AND cp.PaymentDueDate<=GETDATE()) AS Pago_Pendiente,(SELECT COUNT(*) FROM Student.StudentDocument stdo
                WHERE stdo.ClientId=c.Id AND stdo.DocumentTemplateFilledRequired=1 AND stdo.IsValidated=0) AS Documento_Pendiente,sm.Observation,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cppr 
                WHERE cppr.Description IN ('Fotocheck','Fotocheck (Alumnos)') AND cppr.PaymentStatusId=1 AND cppr.ClientId=c.Id) AS Fotocheck,
                (SELECT TOP 1 sd.DocumentFilePath FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='1 Foto digital'
                ORDER BY sd.Id DESC) AS Documento_Foto,
                (SELECT TOP 1 au.Name FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='1 Foto digital'
                ORDER BY sd.Id DESC) AS Usuario_Foto,
                (SELECT TOP 1 FORMAT(sd.DeliveryDate,'yyyy-MM-dd') AS Fecha_Entrega FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='1 Foto digital'
                ORDER BY sd.Id DESC) AS Fecha_Foto,
                (SELECT TOP 1 sd.DocumentFilePath FROM Student.StudentDocument sd 
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='DNI (Alumno/a)'
                ORDER BY sd.Id DESC) AS Documento_Dni,
                (SELECT TOP 1 au.Name FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='DNI (Alumno/a)'
                ORDER BY sd.Id DESC) AS Usuario_Dni,
                (SELECT TOP 1 FORMAT(sd.DeliveryDate,'yyyy-MM-dd') AS Fecha_Entrega FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='DNI (Alumno/a)'
                ORDER BY sd.Id DESC) AS Fecha_Dni,
                (SELECT TOP 1 stuMat.Observation FROM University.StudentMatriculation stuMat 
                LEFT JOIN University.StudentMatriculationStatusReason usmsr on stuMat.StudentMatriculationStatusReasonId=usmsr.Id
                where stuMat.ClientId=c.Id and stuMat.StudentMatriculationStatusId=7 order by stuMat.RetiredDate DESC) as Observaciones_Arpay,
                (SELECT TOP 1 usmsr.Description FROM University.StudentMatriculation stuMat 
                LEFT JOIN University.StudentMatriculationStatusReason usmsr on stuMat.StudentMatriculationStatusReasonId=usmsr.Id
                where stuMat.ClientId=c.Id and stuMat.StudentMatriculationStatusId=7 order by stuMat.RetiredDate DESC) as Motivo_Arpay,
                (SELECT TOP 1 FORMAT(stuMat.RetiredDate,'yyyy-MM-dd') FROM University.StudentMatriculation stuMat 
                LEFT JOIN University.StudentMatriculationStatusReason usmsr on stuMat.StudentMatriculationStatusReasonId=usmsr.Id
                where stuMat.ClientId=c.Id and stuMat.StudentMatriculationStatusId=7 order by stuMat.RetiredDate DESC) as Fecha_Fin_Arpay
                FROM Client c  
                JOIN Person p ON p.Id = c.PersonId  
                LEFT JOIN University.CareerGroup cg ON cg.Id = c.CareerGroupId  
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = c.Id ORDER BY Id DESC)  
                LEFT JOIN University.TeachingUnitDateShift tudf ON tudf.Id = sm.TeachingUnitDateShiftId  
                LEFT JOIN University.TeachingUnit tu ON tu.Id = tudf.TeachingUnitId  
                LEFT JOIN University.Module m ON m.Id = tu.ModuleId   
                LEFT JOIN University.CareerTranslation ct ON ct.CareerId = m.CareerId  
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = c.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE c.EnterpriseHeadquarterId = 10 AND ct.[Language] = 'es-PE' AND ct.Description NOT LIKE '%L14%' AND
                (c.StatusId IS NULL OR c.StatusId <> 2 OR '' = 1)) results  
                LEFT JOIN Student.StudentDocument sd ON sd.ClientId = results.Id  
                GROUP BY results.Id,results.IdentityCardNumber,results.Email,results.CareerGroupText,results.FirstName,results.MotherSurname,results.FatherSurname,  
                results.InternalStudentId,results.CareerName,results.CareerShifts,results.Module,results.MatriculationStatus,
                results.StudentStatus,results.Fecha_Cumpleanos,results.MobilePhone,results.Seccion,results.Pago_Pendiente,results.Documento_Pendiente,results.Observation,
                results.Fotocheck,results.Documento_Foto,results.Usuario_Foto,results.Fecha_Foto,results.Documento_Dni,results.Usuario_Dni,results.Fecha_Dni,
                results.Observaciones_Arpay,results.Motivo_Arpay,results.Fecha_Fin_Arpay
                ORDER BY results.FatherSurname ASC, results.MotherSurname ASC, results.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function insert_todos_l20_matriculados($dato)
    {
        $sql = "INSERT INTO todos_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                Codigo,Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Fecha_Cumpleanos,Celular,Pago_Pendiente,
                Documento_Pendiente,Observacion,Motivo_Arpay,Observaciones_Arpay,Fecha_Fin_Arpay,Fotocheck,Documento_Foto,
                Usuario_Foto,Fecha_Foto,Documento_Dni,Usuario_Dni,Fecha_Dni) 
                VALUES (1,'" . $dato['Id'] . "','" . $dato['IdentityCardNumber'] . "','" . $dato['Email'] . "','" . $dato['FatherSurname'] . "',
                '" . $dato['MotherSurname'] . "','" . $dato['FirstName'] . "','" . $dato['InternalStudentId'] . "','" . $dato['CareerGroupText'] . "',
                '" . substr($dato['CareerName'], 0, -6) . "','" . $dato['CareerShifts'] . "','" . $dato['Module'] . "','" . $dato['Seccion'] . "',
                '" . $dato['MatriculationStatus'] . "','" . $dato['StudentStatus'] . "','" . $dato['Fecha_Cumpleanos'] . "',
                '" . $dato['MobilePhone'] . "','" . $dato['Pago_Pendiente'] . "','" . $dato['Documento_Pendiente'] . "','" . $dato['Observation'] . "',
                '" . $dato['Motivo_Arpay'] . "','" . $dato['Observaciones_Arpay'] . "','" . $dato['Fecha_Fin_Arpay'] . "','" . $dato['Fotocheck'] . "',
                '" . $dato['Documento_Foto'] . "','" . $dato['Usuario_Foto'] . "','" . $dato['Fecha_Foto'] . "','" . $dato['Documento_Dni'] . "',
                '" . $dato['Usuario_Dni'] . "','" . $dato['Fecha_Dni'] . "')";
        $this->db->query($sql);
    }

    function get_list_colaboradores_arpay()
    {
        $sql = "SELECT em.EmployeeId,pe.IdentityCardNumber,pe.Email,pe.FatherSurname,pe.MotherSurname,pe.FirstName,ep.InternalEmployeeId,
                FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,pe.MobilePhone,er.Description AS Cargo, ep.CorporateEmail AS Email_Corporativo
                FROM EmployeeEnterpriseActivity em
                LEFT JOIN Employee ep ON ep.Id=em.EmployeeId
                LEFT JOIN Person pe ON pe.Id=ep.PersonId
                LEFT JOIN EmployeeRoleTranslation er ON er.EmployeeRoleId=em.EmployeeRoleId
                WHERE em.EnterpriseHeadquarterId IN (10,13) AND em.EndDate IS NULL
                ORDER BY pe.FatherSurname ASC,pe.MotherSurname ASC,pe.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function insert_todos_l20_colaboradores($dato)
    {
        $sql = "INSERT INTO todos_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                Codigo,Fecha_Cumpleanos,Celular,Cargo,Email_Corporativo)
                VALUES (2,'" . $dato['EmployeeId'] . "','" . $dato['IdentityCardNumber'] . "','" . $dato['Email'] . "','" . $dato['FatherSurname'] . "',
                '" . $dato['MotherSurname'] . "','" . $dato['FirstName'] . "','" . addslashes($dato['Codigo']) . "','" . $dato['Fecha_Cumpleanos'] . "',
                '" . $dato['MobilePhone'] . "','" . $dato['Cargo'] . "','" . $dato['Email_Corporativo'] . "')";
        $this->db->query($sql);
    }

    function get_list_matriculadosnulosst($tipo)
    {
        $where = "";
        $todo = "";
        $left = "";
        if ($tipo == 1) {
            $where = " WHERE todos_l20.Alumno='Matriculado' AND todos_l20.Matricula='Asistiendo' AND todos_l20.Tipo=1 AND (todos_l20.Turno='' OR todos_l20.Seccion='')";
            //$tabla = "matriculados_l20";
            //$where=" WHERE (select count(*) from alumno_retirado t where t.Id=matriculados_l20.Id and t.estado=2)=0 AND Tipo=1";
            //$fotocheck=",(SELECT count(*) FROM pago_arpay_fv p where p.codigo=matriculados_l20.codigo and p.grupo=matriculados_l20.grupo and p.Tipo=1 AND p.id_producto=9937) as fotocheck";
        } elseif ($tipo == 2) {
            $where = "WHERE todos_l20.Tipo=1 AND (todos_l20.Turno='' OR todos_l20.Seccion='')";
            //$tabla = "todos_l20";
            //$todo=", a.Alumno as Alumno_Retirado,a.Matricula as Matricula_Retirado,m.Pago_Pendiente,m.Documento_Pendiente";
            /*$left="left join alumno_retirado a on todos_l20.Id=a.Id and a.estado=2
                   left join matriculados_l20 m on todos_l20.Id=m.Id";*/
            //$fotocheck=",(SELECT count(*) FROM pago_arpay_fv p where p.codigo=todos_l20.codigo and p.grupo=todos_l20.grupo and p.Tipo=1 AND p.id_producto=9937) as fotocheck";
        } elseif ($tipo == 3) {
            $where = " WHERE todos_l20.Alumno='Retirado' AND todos_l20.Matricula='Retirado'";
            //$tabla = "alumno_retirado";
            //$todo=",m.Pago_Pendiente,m.Documento_Pendiente";
            //$left="left join matriculados_l20 m on alumno_retirado.Id=m.Id"; 
            //$fotocheck=",(SELECT count(*) FROM pago_arpay_fv p where p.codigo=alumno_retirado.codigo and p.grupo=alumno_retirado.grupo and p.Tipo=1 AND p.id_producto=9937) as fotocheck";
        } elseif ($tipo == 4) {
            $where = " WHERE todos_l20.Alumno='Matriculado' AND todos_l20.Matricula='Promovido'";
        }
        /*$sql = "SELECT $tabla.*, ss.color as col_status $todo $fotocheck
                FROM $tabla 
                LEFT JOIN status_general ss on ss.nom_status = $tabla.Alumno
                $left
                $where
                ORDER BY $tabla.Apellido_Paterno ASC,$tabla.Apellido_Materno ASC,$tabla.Nombre ASC";*/

        $sql = "SELECT todos_l20.*, ss.color as col_status, a.Alumno as Alumno_Retirado,a.Matricula as Matricula_Retirado,
                CASE WHEN todos_l20.Pago_Pendiente=0 THEN 'Al Día' WHEN todos_l20.Pago_Pendiente=1 THEN 'Pendiente 1' 
                WHEN todos_l20.Pago_Pendiente=2 THEN 'Pendiente 2' ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,CASE WHEN todos_l20.Pago_Pendiente=0 THEN '#92D050' WHEN todos_l20.Pago_Pendiente=1 THEN '#7F7F7F' 
                WHEN todos_l20.Pago_Pendiente=2 THEN '#F8CBAD' ELSE '#C00000' END AS color_pago_pendiente,
                (SELECT COUNT(*) FROM todos_l20 WHERE todos_l20.Pago_Pendiente=0 and todos_l20.Alumno='Matriculado' and todos_l20.Matricula='Asistiendo') AS total_aldia,
                (SELECT COUNT(*) FROM todos_l20 WHERE todos_l20.Pago_Pendiente=1 and todos_l20.Alumno='Matriculado' and todos_l20.Matricula='Asistiendo') AS total_p1,
                (SELECT COUNT(*) FROM todos_l20 WHERE todos_l20.Pago_Pendiente=2 and todos_l20.Alumno='Matriculado' and todos_l20.Matricula='Asistiendo') AS total_p2,
                (SELECT COUNT(*) FROM todos_l20 WHERE todos_l20.Pago_Pendiente>=3 and todos_l20.Alumno='Matriculado' and todos_l20.Matricula='Asistiendo') AS total_p3,
                CASE WHEN todos_l20.Fotocheck>0 THEN 'Si' ELSE 'No' END AS v_fotocheck,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2) AS link_foto
                FROM todos_l20
                LEFT JOIN status_general ss on ss.nom_status = todos_l20.Alumno
                LEFT JOIN alumno_retirado a on todos_l20.Id=a.Id and a.estado=2
                $where
                ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_matriculados($id_alumno)
    {
        $sql = "SELECT tl.*,
                CONCAT(tl.Apellido_Paterno,' ',tl.Apellido_Materno,', ',tl.Nombre) AS Nombre_Completo,
                DATE_FORMAT(tl.Fecha_Cumpleanos,'%d/%m/%Y') AS Cumpleanos,
                CASE 
                    WHEN se.sexo=1 THEN 'Femenino' 
                    WHEN se.sexo=2 THEN 'Masculino' ELSE '' END AS nom_sexo,
                di.nombre_distrito, 
                cp.institucion, 
                cie.correo as Correo_Institucional,
                es.nom_especialidad AS Especialidad,
                mo.modulo AS Modulo,ho.nom_turno AS Turno,
                TIMESTAMPDIFF(YEAR, tl.Fecha_Cumpleanos, CURDATE()) AS edad, comentariog
                FROM todos_l20 tl
                LEFT JOIN sexo_empresa se ON se.id_alumno=tl.Id AND se.id_empresa=6
                LEFT JOIN colegio_prov_empresa cpe ON cpe.id_alumno=tl.Id AND cpe.id_empresa=6
                LEFT JOIN colegio_prov cp ON cp.id=cpe.id_colegio_prov
                LEFT JOIN distrito di ON di.id_distrito=cp.distrito
                LEFT JOIN correo_inst_empresa cie ON cie.id_alumno=tl.Id AND cie.id_empresa=6
                LEFT JOIN alumno_grupo ag ON ag.id_alumno=tl.Id
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno 
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE tl.Id=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_sexo($id_alumno)
    {
        $sql = "SELECT * FROM sexo_empresa 
                WHERE id_empresa=6 AND id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_sexo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO sexo_empresa (id_empresa,id_alumno,sexo)
                VALUES (6,'" . $dato['id_alumno'] . "','" . $dato['sexo'] . "')";
        $this->db->query($sql);
    }

    function update_sexo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE sexo_empresa SET sexo='" . $dato['sexo'] . "'
                WHERE id_sexo='" . $dato['id_sexo'] . "'";
        $this->db->query($sql);
    }

    function get_list_parentesco()
    {
        $sql = "SELECT * FROM parentesco 
                ORDER BY nom_parentesco ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tutor($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tutores_empresa (id_alumno,id_empresa,id_parentesco,apellido_paterno,
                apellido_materno,nombre,celular,email,no_mailing,estado,fec_reg,user_reg)
                VALUES ('" . $dato['id_alumno'] . "',6,'" . $dato['id_parentesco'] . "',
                '" . $dato['apellido_paterno'] . "','" . $dato['apellido_materno'] . "','" . $dato['nombre'] . "',
                '" . $dato['celular'] . "','" . $dato['email'] . "','" . $dato['no_mailing'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_tutor($id_tutor = null, $id_alumno = null)
    {
        if (isset($id_tutor) && $id_tutor > 0) {
            $sql = "SELECT * FROM tutores_empresa
                    WHERE id_tutor=$id_tutor";
        } else {
            $sql = "SELECT te.id_tutor,pa.nom_parentesco,CONCAT(te.nombre,' ',te.apellido_paterno,' ',
                    te.apellido_materno) AS nom_tutor,te.celular,te.email,te.no_mailing
                    FROM tutores_empresa te
                    LEFT JOIN parentesco pa ON te.id_parentesco=pa.id_parentesco
                    WHERE te.id_alumno=$id_alumno AND te.id_empresa=6 AND te.estado=2
                    ORDER BY te.id_tutor ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tutor($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tutores_empresa SET id_parentesco='" . $dato['id_parentesco'] . "',
                apellido_paterno='" . $dato['apellido_paterno'] . "',
                apellido_materno='" . $dato['apellido_materno'] . "',nombre='" . $dato['nombre'] . "',
                celular='" . $dato['celular'] . "',email='" . $dato['email'] . "',
                no_mailing='" . $dato['no_mailing'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_tutor='" . $dato['id_tutor'] . "'";
        $this->db->query($sql);
    }

    function delete_tutor($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tutores_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_tutor='" . $dato['id_tutor'] . "'";
        $this->db->query($sql);
    }

    function valida_colegio_prov_empresa($id_alumno)
    {
        $sql = "SELECT * FROM colegio_prov_empresa 
                WHERE id_empresa=6 AND id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_colegio_prov_empresa($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colegio_prov_empresa (id_alumno,id_colegio_prov,id_empresa)
                VALUES ('" . $dato['id_alumno'] . "','" . $dato['id_colegio_prov'] . "',6)";
        $this->db->query($sql);
    }

    function update_colegio_prov_empresa($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colegio_prov_empresa SET id_colegio_prov='" . $dato['id_colegio_prov'] . "'
                WHERE id='" . $dato['id_colegio_prov_empresa'] . "'";
        $this->db->query($sql);
    }

    function valida_correo_inst_empresa($id_alumno)
    {
        $sql = "SELECT * FROM correo_inst_empresa 
                WHERE id_empresa=6 AND id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_correo_inst_empresa($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO correo_inst_empresa (id_alumno,correo,id_empresa)
                VALUES ('" . $dato['id_alumno'] . "','" . $dato['correo_inst'] . "',6)";
        $this->db->query($sql);
    }

    function update_correo_inst_empresa($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE correo_inst_empresa SET correo='" . $dato['correo_inst'] . "'
                WHERE id='" . $dato['id_correo_inst_empresa'] . "'";
        $this->db->query($sql);
    }

    function get_datos_arpay_matriculados($id_alumno)
    {
        $sql = "SELECT (SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Matricula 1' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Monto_Matricula_1,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd')
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Matricula 1' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Fecha_Matricula_1,
                (SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Cuota 1' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Monto_Cuota_1,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd')
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Cuota 1' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Fecha_Cuota_1,
                (SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Matricula 2' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Monto_Matricula_2,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd')
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Matricula 2' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Fecha_Matricula_2,
                (SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)
                FROM ClientProductPurchaseRegistry cp 
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Cuota 6' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Monto_Cuota_6,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd')
                FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cl.Id AND cp.Description='Cuota 6' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2022
                ORDER BY cp.Id DESC) AS Fecha_Cuota_6
                FROM Client cl
                WHERE cl.Id=$id_alumno";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function get_list_foto_matriculados($id_alumno = null)
    {
        $sql = "SELECT de.id_detalle,SUBSTRING_INDEX(de.archivo,'/',-1) AS nom_archivo,de.archivo
                FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND 
                de.archivo!='' AND de.estado=2
                ORDER BY de.anio DESC,de.id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function get_todo_foto_matriculados($id_alumno){ 
        $sql = "SELECT id_foto FROM foto_matriculados
                WHERE id_empresa=6 AND id_alumno=$id_alumno 
                ORDER BY id_foto DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_foto_matriculados($id_foto){ 
        $sql = "SELECT * FROM foto_matriculados WHERE id_foto=$id_foto";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_foto_matriculados_c($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO foto_matriculados (id_empresa,id_alumno,foto,estado,fec_reg,user_reg)
                VALUES (6,'".$dato['id_alumno']."','".$dato['foto']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_foto_matriculados($dato){
        $sql = "UPDATE foto_matriculados SET estado=4
                WHERE id_foto='".$dato['id_foto']."'";
        $this->db->query($sql);
    }*/

    function get_dni_alumno_recomendados()
    {
        $sql = "SELECT dni_alumno FROM recomendados";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso_matriculados_modulo($dato)
    {
        /*$sql = "SELECT ri.codigo,ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno='".$dato['id_alumno']."' and ri.modulo='".$dato['modulo']."'
                ORDER BY ri.ingreso DESC"; 
               //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;*/

        $sql = "SELECT ri.codigo,ri.ingreso AS orden,CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno='" . $dato['id_alumno'] . "' and ri.modulo='" . $dato['modulo'] . "' and RIGHT(ri.codigo,1)<>'C'
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso_matriculados($id_alumno)
    {
        $sql = "SELECT ri.codigo,ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_alumno
                ORDER BY ri.ingreso DESC";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();

        /*$sql = "SELECT ri.codigo,ri.ingreso AS orden,CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_alumno and RIGHT(ri.codigo,1)<>'C'
                ORDER BY ri.ingreso DESC"; 
        $query = $this->db5->query($sql)->result_Array();*/
        return $query;
    }
    //------------------------------------REGISTRO INGRESO-----------------------------------------------
    function get_list_registro_ingreso($id_registro_ingreso = null)
    {
        if (isset($id_registro_ingreso) && $id_registro_ingreso > 0) {
            $sql = "SELECT * FROM registro_ingreso 
                    WHERE id_registro_ingreso=$id_registro_ingreso";
        } else {
            $sql = "SELECT ri.*,ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
            DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
            CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
            THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
            WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
            WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
            CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
            CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
            WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
            WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,CASE WHEN ri.user_reg=0 THEN 
            (SELECT usuario_codigo FROM users WHERE id_usuario=60) ELSE ue.usuario_codigo END AS usuario_registro,
            CASE WHEN SUBSTRING(ri.codigo,-1,1)='C' THEN td.Cargo WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
            THEN 'Invitado' ELSE 'Alumno' END AS nom_tipo_acceso,td.Tipo AS Tipo_Acceso,
            CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) THEN CONCAT(ri.nombres,' ',ri.codigo)
            ELSE ri.nombres END AS nombre,es.abreviatura
            FROM registro_ingreso ri
            LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
            LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
            LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
            LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
            LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
            WHERE ri.estado=2
            ORDER BY ri.ingreso DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso_p($fec_in, $fec_fi, $codigo)
    {
        /*if($tipo==1){
            $parte = "AND ri.codigo NOT LIKE '%C%' 
                    AND ri.codigo NOT IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        }else{
            $parte = "AND ri.codigo IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        }*/
        /*$sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
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
                CASE WHEN SUBSTRING(ri.codigo,-1,1)='C' THEN td.Cargo 
                WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
                THEN 'Invitado' ELSE 'Alumno' END AS nom_tipo_acceso,
                CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
                ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
                (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
                ELSE ue.usuario_codigo END AS usuario_registro
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND DATE(ri.ingreso) BETWEEN '$fec_in' AND '$fec_fi' $parte
                ORDER BY ri.ingreso DESC";
        $query = $this->db->query($sql)->result_Array();*/
        /*$sql = "SELECT  ri.id_registro_ingreso,ri.ingreso AS orden, 
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
                CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
                WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
                WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.salida=2 THEN 'No Registrado'
                WHEN ri.salida=1 THEN 'Salida'
                ELSE (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
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
                ELSE ue.usuario_codigo END AS usuario_registro,ri.estado_asistencia,ri.laborable,ri.especialidad,ri.seccion
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND CONVERT(varchar,ri.ingreso,23) BETWEEN '$fec_in' AND '$fec_fi' $parte
                ORDER BY ri.ingreso DESC";*/
        $sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden, 
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,'' AS obs,
                '' tipo_desc,
                CASE WHEN ri.salida=2 THEN 'No Registrado'
                WHEN ri.salida=1 THEN 'Salida'
                ELSE (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
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
                ELSE ue.usuario_codigo END AS usuario_registro,ri.estado_asistencia,ri.laborable,ri.especialidad,ri.seccion
                FROM registro_ingreso ri /*registro_asistencia*/
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON ri.id_alumno=td.Id AND td.Tipo=2
                LEFT JOIN especialidad es ON ri.especialidad=es.nom_especialidad AND es.estado=2
                WHERE ri.id_alumno=$codigo and ri.estado=2 AND CONVERT(varchar,ri.ingreso,23) BETWEEN '$fec_in' AND '$fec_fi'
                ORDER BY ri.ingreso DESC";
        //echo($sql);
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function excel_registro_ingreso($fec_in, $fec_fi, $tipo)
    {
        if ($tipo == 1) {
            $parte = "AND ri.codigo NOT LIKE '%C%' 
                    AND ri.codigo NOT IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        } else {
            $parte = "AND ri.codigo IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        }
        /*
        $sql = "SELECT * FROM vista_registro_ingreso 
                WHERE DATE(ingreso) BETWEEN '$fec_in' AND '$fec_fi' $parte";
        $query = $this->db->query($sql)->result_Array();        
        */
        $sql = "SELECT  ri.id_registro_ingreso,ri.ingreso AS orden,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.hora_salida,108) AS hora_salida,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
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
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND CONVERT(varchar,ri.ingreso,23) BETWEEN '$fec_in' AND '$fec_fi' $parte
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial_registro_ingreso($id_registro_ingreso)
    {
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE_FORMAT(fec_reg,'%d/%m/%Y') AS Fecha
                FROM historial_registro_ingreso 
                WHERE estado=2 AND id_registro_ingreso=$id_registro_ingreso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_registro_ingreso_lista($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso SET estado=4,fec_eli=GETDATE(),user_eli=$id_usuario
                WHERE id_registro_ingreso='" . $dato['id_registro_ingreso'] . "'";
        $this->db5->query($sql);
    }
    //-----------------------------------------------INFORME PAGOS------------------------------------------
    function get_list_grafico_pagos()
    {
        $sql = "SELECT es.id_especialidad,es.abreviatura,es.color,(SELECT COUNT(*) FROM pago_arpay_fv pa
                LEFT JOIN producto_arpay_fv pr ON pr.Id=pa.id_producto
                LEFT JOIN producto_snappy_fv ps ON ps.Id=pr.Id
                WHERE pa.Tipo=2 AND pa.Fecha_Vencimiento<=CURDATE() AND (ps.id_especialidad LIKE CONCAT(es.id_especialidad,',%') OR
                ps.id_especialidad LIKE CONCAT('%,',es.id_especialidad,',%') OR ps.id_especialidad LIKE CONCAT('%,',es.id_especialidad) OR
                ps.id_especialidad=es.id_especialidad)) AS cantidad,
                (SELECT IFNULL(SUM(pa.Total),0) FROM pago_arpay_fv pa
                LEFT JOIN producto_arpay_fv pr ON pr.Id=pa.id_producto
                LEFT JOIN producto_snappy_fv ps ON ps.Id=pr.Id
                WHERE pa.Tipo=2 AND pa.Fecha_Vencimiento<=CURDATE() AND (ps.id_especialidad LIKE CONCAT(es.id_especialidad,',%') OR
                ps.id_especialidad LIKE CONCAT('%,',es.id_especialidad,',%') OR ps.id_especialidad LIKE CONCAT('%,',es.id_especialidad) OR
                ps.id_especialidad=es.id_especialidad)) AS monto
                FROM especialidad es 
                WHERE es.id_especialidad IN (5,6,7,8,9,10)
                ORDER BY es.estado ASC,es.abreviatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grafico_excel($id_especialidad)
    {
        $sql = "SELECT pa.Apellido_Paterno,pa.Apellido_Materno,pa.Nombre,pa.Codigo,pa.Grupo,pa.Seccion,pa.Producto,pa.Descripcion,
                pa.Fecha_Vencimiento,pa.Total,pa.Estado
                FROM pago_arpay_fv pa 
                LEFT JOIN producto_arpay_fv pr ON pr.Id=pa.id_producto 
                LEFT JOIN producto_snappy_fv ps ON ps.Id=pr.Id 
                WHERE pa.Tipo=2 AND pa.Fecha_Vencimiento<=CURDATE() AND (ps.id_especialidad LIKE CONCAT($id_especialidad,',%') OR 
                ps.id_especialidad LIKE CONCAT('%,',$id_especialidad,',%') OR ps.id_especialidad LIKE CONCAT('%,',$id_especialidad) OR 
                ps.id_especialidad=$id_especialidad)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function get_list_productos(){
        $anio_actual = date('Y');
        $StartDate = "$anio_actual-01-01";
        $EndDate = "$anio_actual-12-31";
        $EnterpriseHeadquarterId = 10;
        $sql = "SELECT t1.Id AS ProductId,t1.SchoolYear AS SchoolYear,t1.Name AS Name,SUM(t1.TotalPeopleToBePaid) AS 'TotalPeopleToBePaid',   
                SUM(t1.TotalToBePaid) AS 'TotalToBePaid',SUM(t1.TotalPeoplePaid) AS 'TotalPeoplePaid',SUM(t1.Cost) AS Cost,  
                SUM(t1.Discount) AS Discount,SUM(t1.PenaltyAmountPaid) AS PenaltyAmountPaid,SUM(t1.TotalPaid) AS TotalPaid  
                FROM 
                (SELECT prod.Id,prod.SchoolYear,prod.Name,0 AS TotalPeopleToBePaid,0 AS TotalToBePaid,0 AS TotalPeoplePaid,   
                SUM(ISNULL(cppr.Cost,0)) AS Cost,SUM(ISNULL(cppr.TotalDiscount,0)) AS Discount,
                SUM(ISNULL(cppr.PenaltyAmountPaid,0)) AS PenaltyAmountPaid,SUM(cppr.Cost - ISNULL(cppr.TotalDiscount,0) + ISNULL(cppr.PenaltyAmountPaid,0)) as TotalPaid  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                WHERE cppr.PaymentStatusId IN (1,4) AND prod.EnterpriseHeadquarterId = $EnterpriseHeadquarterId AND cppr.PaymentDate >= '$StartDate' AND  
                cppr.PaymentDate <= '$EndDate'  
                GROUP BY prod.Id, prod.SchoolYear, prod.Name  
                UNION ALL  
                SELECT prod.Id,prod.SchoolYear,prod.Name, 0 AS TotalPeopleToBePaid,0 AS TotalToBePaid,Count(prod.Id) AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 AS TotalPaid  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                WHERE cppr.PaymentStatusId IN (1,4) AND prod.EnterpriseHeadquarterId = $EnterpriseHeadquarterId AND cppr.PaymentDate >= '$StartDate' AND  
                cppr.PaymentDate <= '$EndDate'  
                GROUP BY prod.Id, prod.SchoolYear, prod.Name  
                UNION ALL  
                SELECT prod1.Id,prod1.SchoolYear,prod1.Name,0 AS TotalPeopleToBePaid,SUM(cppr1.Cost) AS TotalToBePaid,0 AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 as TotalPaid  
                FROM ClientProductPurchaseRegistry cppr1  
                JOIN Product prod1 ON prod1.Id = cppr1.ProductId  
                WHERE cppr1.ProductId = prod1.Id AND cppr1.PaymentStatusId = 2 AND prod1.EnterpriseHeadquarterId = $EnterpriseHeadquarterId   
                GROUP BY prod1.Id, prod1.SchoolYear, prod1.Name  
                UNION ALL  
                SELECT prod1.Id,prod1.SchoolYear,prod1.Name,Count(prod1.Id) AS TotalPeopleToBePaid,0 AS TotalToBePaid,0 AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 as TotalPaid  
                FROM ClientProductPurchaseRegistry cppr1  
                JOIN Product prod1 ON prod1.Id = cppr1.ProductId  
                WHERE cppr1.PaymentStatusId = 2 AND prod1.EnterpriseHeadquarterId = $EnterpriseHeadquarterId  
                GROUP BY prod1.Id, prod1.SchoolYear, prod1.Name) t1  
                GROUP BY t1.Id, t1.SchoolYear, t1.Name  
                ORDER BY t1.Name ASC, t1.SchoolYear";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_productos_pagos($tipo)
    {
        $anio = date('Y');
        if ($_SESSION['usuario'][0]['id_nivel'] == 12 || $_SESSION['usuario'][0]['id_nivel'] == 15) {
            $parte = "WHERE ps.informe=1";
            $segunda_parte = "";
            if ($tipo == 1) {
                $segunda_parte = "AND pa.estado='Activo' AND pa.anio=$anio";
            } else if ($tipo == 2) {
                $segunda_parte = "AND tp.nom_tipo_producto='Matriculas y Pensiones' AND pa.nom_producto LIKE '%(L20)' AND pa.anio=$anio";
            }
        } else {
            $parte = "";
            $segunda_parte = "";
            if ($tipo == 1) {
                $segunda_parte = "WHERE pa.estado='Activo' AND pa.anio=$anio";
            } else if ($tipo == 2) {
                $segunda_parte = "WHERE tp.nom_tipo_producto='Matriculas y Pensiones' AND pa.nom_producto LIKE '%(L20)' AND pa.anio=$anio";
            }
        }

        $sql = "SELECT pa.*,tp.nom_tipo_producto
                FROM producto_arpay_fv pa 
                LEFT JOIN producto_snappy_fv ps ON ps.Id=pa.Id
                LEFT JOIN tipo_producto tp ON tp.id_tipo_producto=ps.tipo
                $parte $segunda_parte ORDER BY pa.anio ASC,tp.nom_tipo_producto ASC,pa.nom_producto";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function get_list_pagos_cancelados($id_producto){
        $anio_actual = date('Y');
        $StartDate = "$anio_actual-01-01";
        $EndDate = "$anio_actual-12-31";
        $sql = "SELECT eh.Name AS 'Enterprise',he.Name AS 'Headquarter',cli.InternalStudentId AS 'InternalStudentId',
                p.FirstName,p.FatherSurname,p.MotherSurname,prod.Name AS 'ProductName',prodItem.Name AS 'ItemName',
                cppr.Description AS 'Description',pst.Description AS 'PaymentStatus',cppr.Cost,cppr.TotalDiscount,
                cppr.PenaltyAmountPaid,FORMAT(cppr.PaymentDate,'dd-MM-yyyy') AS PaymentDate,
                'ElectronicReceiptNumber' = CASE WHEN cppr.ManualReceiptSerieId IS NOT NULL THEN 
                (SELECT TOP 1 CONCAT(  
                LEFT(purchaseSerie.CBT,   
                LEN(purchaseSerie.CBT)-2),'/',   
                RIGHT(purchaseSerie.CBT, LEN(purchaseSerie.CBT)-2),   
                ' '+purchaseSerie.Letter+' ', purchaseReceipt.ReceiptNumber)   
                FROM ClientProductPurchaseRegistry purchase  
                JOIN ManualRegistryReceiptSerie purchaseSerie ON purchaseSerie.Id = purchase.ManualReceiptSerieId  
                JOIN ManualReceipt purchaseReceipt ON purchaseReceipt.Id = purchase.ManualReceiptId  
                WHERE purchase.ManualReceiptSerieId = cppr.ManualReceiptSerieId  
                AND purchase.ManualReceiptId = cppr.ManualReceiptId)  
                ELSE cppr.ElectronicReceiptNumber END,'PaymentEmployeeName' = (SELECT Username FROM AspNetUsers WHERE Id = cppr. PaymentEmployeeId),
                (ISNULL(cppr.Cost,0)+ISNULL(cppr.PenaltyAmountPaid,0)-ISNULL(cppr.TotalDiscount,0)) AS Total,
                ucg.Name as Grupo,(SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                WHERE stm.ClientId=cli.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN cli.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.[Description] END AS StudentStatus
                FROM ClientProductPurchaseRegistry cppr
                inner join Client cli on cppr.ClientId = cli.Id
                inner join Person p on cli.PersonId = p.Id
                inner join EnterpriseHeadquarter eh on cli.EnterpriseHeadquarterId = eh.Id
                inner join Headquarter he on eh.HeadquarterId = he.Id
                inner join Product prod on cppr.ProductId = prod.Id
                inner join ProductItem prodItem on cppr.ProductItemId = prodItem.Id
                inner join PaymentStatusTranslation pst on cppr.PaymentStatusId = pst.PaymentStatusId AND pst.[Language] = 'es-PE'
                left join University.CareerGroup ucg on ucg.id=cli.CareerGroupId  
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = cli.Id ORDER BY Id DESC)
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = cli.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE cppr.ProductId = $id_producto AND cppr.PaymentStatusId IN (1,4) AND cppr.PaymentDate >= '$StartDate' AND 
                cppr.PaymentDate <= '$EndDate' 
                ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_pagos_cancelados($id_producto)
    {
        $sql = "SELECT pa.*,DATE_FORMAT(pa.Fecha_Pago,'%d-%m-%Y') AS Fec_Pago,
                DATE_FORMAT(pa.Fecha_Vencimiento,'%d-%m-%Y') AS Fec_Vencimiento,
                td.Modulo
                FROM pago_arpay_fv pa
                LEFT JOIN todos_l20 td ON td.Codigo=pa.Codigo
                WHERE pa.Tipo=1 AND pa.id_producto=$id_producto
                ORDER BY pa.Apellido_Paterno ASC,pa.Apellido_Materno ASC,pa.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function get_list_pagos_vencidos($id_producto){
        $sql = "SELECT eh.Name AS 'Enterprise',he.Name AS 'Headquarter',cli.InternalStudentId AS 'InternalStudentId',p.FirstName,
                p.FatherSurname,p.MotherSurname,prod.Name AS 'ProductName',prodItem.Name AS 'ItemName',cppr.Description AS 'Description',
                pst.Description AS 'PaymentStatus',cppr.Cost,cppr.TotalDiscount,cppr.PurchaseDate,
                'PurchaseEmployeeName' = (SELECT Username FROM AspNetUsers 
                WHERE Id = cppr.PurchaseEmployeeId),(ISNULL(cppr.Cost,0)-ISNULL(cppr.TotalDiscount,0)) AS Total,
                ucg.Name as Grupo,(SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                WHERE stm.ClientId=cli.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN cli.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.[Description] END AS StudentStatus
                FROM ClientProductPurchaseRegistry cppr
                inner join Client cli on cppr.ClientId = cli.Id
                inner join Person p on cli.PersonId = p.Id
                inner join EnterpriseHeadquarter eh on cli.EnterpriseHeadquarterId = eh.Id
                inner join Headquarter he on eh.HeadquarterId = he.Id
                inner join Product prod on cppr.ProductId = prod.Id
                inner join ProductItem prodItem on cppr.ProductItemId = prodItem.Id
                inner join PaymentStatusTranslation pst on cppr.PaymentStatusId = pst.PaymentStatusId AND pst.[Language] = 'es-PE'
                left join University.CareerGroup ucg on ucg.id=cli.CareerGroupId 
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = cli.Id ORDER BY Id DESC)
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = cli.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE cppr.ProductId = $id_producto AND cppr.PaymentStatusId = 2 AND cppr.PaymentDueDate<=GETDATE()
                ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_pagos_vencidos($id_producto)
    {
        $sql = "SELECT pa.*,DATE_FORMAT(pa.Fecha_Vencimiento,'%d-%m-%Y') AS Fec_Vencimiento,
                td.Modulo 
                FROM pago_arpay_fv pa
                LEFT JOIN todos_l20 td ON td.Codigo=pa.Codigo
                WHERE pa.Tipo=2 AND pa.id_producto=$id_producto AND pa.Fecha_Vencimiento<=CURDATE()
                ORDER BY pa.Apellido_Paterno ASC,pa.Apellido_Materno ASC,pa.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function get_list_pagos_pendientes($id_producto){
        $sql = "SELECT eh.Name AS 'Enterprise',he.Name AS 'Headquarter',cli.InternalStudentId AS 'InternalStudentId',p.FirstName,
                p.FatherSurname,p.MotherSurname,prod.Name AS 'ProductName',prodItem.Name AS 'ItemName',cppr.Description AS 'Description',
                pst.Description AS 'PaymentStatus',cppr.Cost,cppr.TotalDiscount,cppr.PurchaseDate,
                'PurchaseEmployeeName' = (SELECT Username FROM AspNetUsers 
                WHERE Id = cppr.PurchaseEmployeeId),(ISNULL(cppr.Cost,0)-ISNULL(cppr.TotalDiscount,0)) AS Total,
                ucg.Name as Grupo,(SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                WHERE stm.ClientId=cli.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN cli.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.[Description] END AS StudentStatus
                FROM ClientProductPurchaseRegistry cppr
                inner join Client cli on cppr.ClientId = cli.Id
                inner join Person p on cli.PersonId = p.Id
                inner join EnterpriseHeadquarter eh on cli.EnterpriseHeadquarterId = eh.Id
                inner join Headquarter he on eh.HeadquarterId = he.Id
                inner join Product prod on cppr.ProductId = prod.Id
                inner join ProductItem prodItem on cppr.ProductItemId = prodItem.Id
                inner join PaymentStatusTranslation pst on cppr.PaymentStatusId = pst.PaymentStatusId AND pst.[Language] = 'es-PE'
                left join University.CareerGroup ucg on ucg.id=cli.CareerGroupId 
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = cli.Id ORDER BY Id DESC)
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = cli.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE cppr.ProductId = $id_producto AND cppr.PaymentStatusId = 2
                ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_pagos_pendientes($id_producto)
    {
        $sql = "SELECT pa.*,DATE_FORMAT(pa.Fecha_Vencimiento,'%d-%m-%Y') AS Fec_Vencimiento,
                td.Modulo
                FROM pago_arpay_fv pa
                LEFT JOIN todos_l20 td ON td.Codigo=pa.Codigo
                WHERE pa.Tipo=2 AND pa.id_producto=$id_producto
                ORDER BY pa.Apellido_Paterno ASC,pa.Apellido_Materno ASC,pa.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pagos_todos($id_producto)
    {
        $sql = "SELECT pa.*,DATE_FORMAT(pa.Fecha_Vencimiento,'%d-%m-%Y') AS Fec_Vencimiento,
                td.Modulo
                FROM pago_arpay_fv pa
                LEFT JOIN todos_l20 td ON td.Codigo=pa.Codigo
                WHERE pa.id_producto=$id_producto
                ORDER BY pa.Apellido_Paterno ASC,pa.Apellido_Materno ASC,pa.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------SOLICITUD-----------------------------------------
    function get_list_solicitud()
    {
        $inicio = "2022-01-01";
        $fin = date('Y') . "-12-31";
        $sql = "SELECT cli.Id,cli.InternalStudentId AS 'Codigo',p.IdentityCardNumber AS 'N_Doc',p.FatherSurname AS 'Apellido_Paterno',
                p.MotherSurname AS 'Apellido_Materno',p.FirstName AS 'Nombres',prod.Name AS 'Producto',
                ISNULL(cppr.Cost,0) AS Monto,ISNULL(cppr.TotalDiscount,0) AS Descuento,ISNULL(cppr.PenaltyAmountPaid,0) AS Penalidad,
                (ISNULL(cppr.Cost,0)-ISNULL(cppr.TotalDiscount,0)+ISNULL(cppr.PenaltyAmountPaid,0)) AS SubTotal,
                'Recibo'=CASE WHEN cppr.ManualReceiptSerieId IS NOT NULL THEN (SELECT TOP 1 CONCAT(LEFT(purchaseSerie.CBT,
                LEN(purchaseSerie.CBT)-2),'/',RIGHT(purchaseSerie.CBT, LEN(purchaseSerie.CBT)-2),' '+purchaseSerie.Letter+' ',purchaseReceipt.ReceiptNumber)   
                FROM ClientProductPurchaseRegistry purchase JOIN ManualRegistryReceiptSerie purchaseSerie ON purchaseSerie.Id = purchase.ManualReceiptSerieId  
                JOIN ManualReceipt purchaseReceipt ON purchaseReceipt.Id=purchase.ManualReceiptId WHERE purchase.ManualReceiptSerieId=cppr.ManualReceiptSerieId  
                AND purchase.ManualReceiptId=cppr.ManualReceiptId) ELSE cppr.ElectronicReceiptNumber END,FORMAT(cppr.PaymentDate,'dd-MM-yyyy') AS 'Fecha_Pago',
                pst.Description AS 'Estado' 
                FROM ClientProductPurchaseRegistry cppr,Client cli,Person p,EnterpriseHeadquarter eh,Headquarter he,Product prod,ProductItem prodItem,
                PaymentStatusTranslation pst  
                WHERE cppr.ProductId=9910 AND cppr.PaymentStatusId IN (1,4) AND cppr.PaymentDate>='$inicio' AND cppr.PaymentDate<='$fin' AND 
                cppr.ClientId=cli.Id AND cli.PersonId=p.Id AND cli.EnterpriseHeadquarterId=eh.Id AND eh.HeadquarterId=he.Id AND cppr.ProductId=prod.Id AND 
                cppr.ProductItemId=prodItem.Id AND cppr.PaymentStatusId=pst.PaymentStatusId AND pst.[Language]='es-PE'  
                ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function get_id_alumno($id_alumno)
    {
        $sql = "SELECT cl.Id,cl.InternalStudentId AS 'Codigo',pe.FatherSurname AS 'Apellido_Paterno',pe.MotherSurname AS 'Apellido_Materno',
                pe.FirstName AS 'Nombres'
                FROM Client cl
                LEFT JOIN Person pe ON pe.Id=cl.PersonId
                WHERE cl.Id=$id_alumno";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function get_list_fase()
    {
        $sql = "SELECT * FROM fase_solicitud WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-------------------------------------------------LISTA BIBLIOTECA----------------------------------
    function get_list_biblioteca($id_biblioteca = null)
    {
        if (isset($id_biblioteca) && $id_biblioteca > 0) {
            $sql = "SELECT bi.*,CASE WHEN bi.estado_b=1 THEN 'Disponible' 
            WHEN bi.estado_b=2 THEN 'Solicitado'
            WHEN bi.estado_b=3 THEN 'Perdido' END 
            AS nom_estado
             
            FROM biblioteca bi
                    WHERE bi.id_biblioteca=$id_biblioteca";
        } else {
            $sql = "SELECT bi.*,es.nom_especialidad,mo.modulo AS nom_modulo,ci.ciclo AS nom_ciclo,
                    CASE WHEN bi.estado_b=1 THEN 'Disponible' 
                    WHEN bi.estado_b=2 THEN 'Solicitado'
                    WHEN bi.estado_b=3 THEN 'Perdido' ELSE '' END 
                    AS nom_estado,
                    (select count(*) from biblioteca_acciones a where bi.id_biblioteca=a.id_biblioteca and a.estado=2) as cant_requerido
                    FROM biblioteca bi
                    LEFT JOIN especialidad es ON bi.id_especialidad=es.id_especialidad
                    LEFT JOIN modulo mo ON mo.id_modulo=bi.id_modulo
                    LEFT JOIN ciclo ci ON ci.id_ciclo=bi.id_ciclo
                    WHERE bi.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function biblioteca_especialidad_modulo($id_especialidad)
    {
        $sql = "SELECT id_modulo,modulo AS nom_modulo FROM modulo 
                WHERE id_especialidad=$id_especialidad AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function biblioteca_modulo_ciclo($id_especialidad, $id_modulo)
    {
        $sql = "SELECT id_ciclo,ciclo AS nom_ciclo FROM ciclo 
                WHERE id_especialidad=$id_especialidad AND id_modulo=$id_modulo AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad_didactica_biblioteca($id_especialidad = null)
    {
        if (isset($id_especialidad) && $id_especialidad > 0) {
            if ($id_especialidad == 5) {
                $id_especialidad = 6;
            } elseif ($id_especialidad == 6) {
                $id_especialidad = 7;
            } elseif ($id_especialidad == 7) {
                $id_especialidad = 5;
            } elseif ($id_especialidad == 8) {
                $id_especialidad = 3;
            } elseif ($id_especialidad == 9) {
                $id_especialidad = 4;
            } else {
                $id_especialidad = 99;
            }
            $sql = "SELECT ud.Id AS id_unidad_didactica,ud.Name AS nom_unidad_didactica 
                    FROM University.TeachingUnit ud
                    LEFT JOIN University.Module mo ON mo.Id=ud.ModuleId
                    LEFT JOIN University.CareerTranslation ct ON ct.CareerId=mo.CareerId
                    WHERE ct.CareerId=$id_especialidad ORDER BY ud.Name ASC";
        } else {
            $sql = "SELECT ud.Id AS id_unidad_didactica,ud.Name AS nom_unidad_didactica 
                    FROM University.TeachingUnit ud
                    LEFT JOIN University.Module mo ON mo.Id=ud.ModuleId
                    LEFT JOIN University.CareerTranslation ct ON ct.CareerId=mo.CareerId
                    ORDER BY ud.Name ASC";
        }
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_biblioteca()
    {
        $anio = date('Y');
        $sql = "SELECT id_biblioteca FROM biblioteca WHERE YEAR(fec_reg)=$anio";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_lista_biblioteca($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO biblioteca (cod_biblioteca,estado_b,id_especialidad,id_modulo,id_ciclo,id_unidad_didactica,
                titulo,subtitulo,autor,editorial,anio,cantidad,tipo,fecha_compra,monto,observaciones,cod_barra,estado,fec_reg,
                user_reg) 
                VALUES('" . $dato['cod_biblioteca'] . "',1,'" . $dato['id_especialidad'] . "','" . $dato['id_modulo'] . "',
                '" . $dato['id_ciclo'] . "','" . $dato['id_unidad_didactica'] . "','" . $dato['titulo'] . "','" . $dato['subtitulo'] . "',
                '" . $dato['autor'] . "','" . $dato['editorial'] . "','" . $dato['anio'] . "','" . $dato['cantidad'] . "',
                '" . $dato['tipo'] . "','" . $dato['fecha_compra'] . "','" . $dato['monto'] . "','" . $dato['observaciones'] . "','" . $dato['cod_barra'] . "',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_lista_biblioteca($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE biblioteca SET id_especialidad='" . $dato['id_especialidad'] . "',id_modulo='" . $dato['id_modulo'] . "',
                id_ciclo='" . $dato['id_ciclo'] . "',id_unidad_didactica='" . $dato['id_unidad_didactica'] . "',
                titulo='" . $dato['titulo'] . "',subtitulo='" . $dato['subtitulo'] . "',autor='" . $dato['autor'] . "',
                editorial='" . $dato['editorial'] . "',anio='" . $dato['anio'] . "',cantidad='" . $dato['cantidad'] . "',
                tipo='" . $dato['tipo'] . "',fecha_compra='" . $dato['fecha_compra'] . "',monto='" . $dato['monto'] . "',
                observaciones='" . $dato['observaciones'] . "',cod_barra='" . $dato['cod_barra'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_biblioteca='" . $dato['id_biblioteca'] . "'";
        $this->db->query($sql);
    }

    function delete_lista_biblioteca($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE biblioteca SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_biblioteca='" . $dato['id_biblioteca'] . "'";
        $this->db->query($sql);
    }
    //------------------------------------------HISTÓRICO EXTRANET---------------------------------------------
    /*function get_list_historico_extranet($fec_inicio,$fec_fin){
        $sql = "SELECT ap.UserName AS Usuario,CONCAT(ap.FatherSurname,' ',ap.MotherSurname,', ',ap.FirstName)
                AS Nombre_Apellido, FORMAT(ha.login,'dd-MM-yyyy') AS dUltimo_Acceso, ha.login AS orden_tabla,
                FORMAT(ha.logout,'dd-MM-yyyy') AS dLogout, ap.FatherSurname, ap.MotherSurname, ap.FirstName,
                FORMAT(ha.login,'HH:mm') AS hUltimo_Acceso,FORMAT(ha.logout,'HH:mm') AS hLogout,
                FORMAT(ha.login,'dd-MM-yyyy') AS Fecha_Excel, att.Description as tipo_acceso,
                '' as especialidad, '' as grupo, ap.DNI as documento
                FROM Hacces ha
                LEFT JOIN AspNetUsers ap ON ap.Id COLLATE MODERN_SPANISH_CI_AS=ha.UserId COLLATE MODERN_SPANISH_CI_AS
                LEFT JOIN AccessTypeTranslation att ON att.AccessTypeId COLLATE MODERN_SPANISH_CI_AS=ap.AccessType COLLATE MODERN_SPANISH_CI_AS
                WHERE att.id in (2,3) AND FORMAT(ha.login,'yyyy-MM-dd') BETWEEN '$fec_inicio' AND '$fec_fin'
                ORDER BY ha.login DESC";
        $query = $this->db3->query($sql)->result_Array();
        return $query;
    }*/

    function busqueda_libro_cod($cod_libro)
    {
        $sql = "SELECT bi.*,es.nom_especialidad,mo.modulo AS nom_modulo,ci.ciclo AS nom_ciclo,
            
            CASE WHEN bi.estado_b=1 THEN 'Disponible' 
            WHEN bi.estado_b=2 THEN 'Solicitado'
            WHEN bi.estado_b=3 THEN 'Perdido' END AS nom_estado
            FROM biblioteca bi
            LEFT JOIN especialidad es ON es.id_especialidad=bi.id_especialidad
            LEFT JOIN modulo mo ON mo.id_modulo=bi.id_modulo
            LEFT JOIN ciclo ci ON ci.id_ciclo=bi.id_ciclo
            WHERE bi.estado=2 and bi.cod_barra='$cod_libro'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_alumno_temporal_libreria($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_temporal_libreria (InternalStudentId,accion,nombres,apater,amater,especialidad,estado,fec_reg,user_reg) 
                VALUES('" . $dato['InternalStudentId'] . "','" . $dato['accion'] . "','" . $dato['FirstName'] . "','" . $dato['FatherSurname'] . "','" . $dato['MotherSurname'] . "','" . $dato['CareerName'] . "',1,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_alumno_temporal_libreria()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql1 = "DELETE FROM alumno_temporal_libreria WHERE user_reg='$id_usuario'";

        $this->db->query($sql1);
    }

    function consulta_alumno_temporal_libreria()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT t.*,u.usuario_codigo as usuario,Date_format(NOW(),'%d/%m/%Y')  as fecha FROM alumno_temporal_libreria t 
        left join users u on t.user_reg=u.id_usuario
        WHERE t.user_reg='$id_usuario' AND t.estado=1";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function consulta_alumno_temporal_libreria_reg($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT t.*,u.usuario_codigo as usuario,Date_format(NOW(),'%d/%m/%Y')  as fecha FROM alumno_temporal_libreria t 
        left join users u on t.user_reg=u.id_usuario
        WHERE t.user_reg='$id_usuario' AND t.estado=1 and t.accion='" . $dato['accion'] . "'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_accion_biblioteca($dato)
    {
        $sql = "SELECT e.* from biblioteca e where e.id_biblioteca='" . $dato['id_biblioteca'] . "' and e.estado_b=1 and e.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function consulta_disponibilidad_libro($dato)
    {
        $sql = "SELECT e.* from biblioteca e where e.id_biblioteca='" . $dato['id_biblioteca'] . "' and e.estado_b<>1 and e.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_accion_biblioteca($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        if ($dato['accion'] == 1) {
            $sql = "INSERT biblioteca_acciones (cod_accion,InternalStudentId,nombres,apater,amater,especialidad,id_biblioteca,accion,estado,fec_reg,user_reg)
        
                SELECT '" . $dato['cod_accion'] . "',InternalStudentId,nombres,apater,amater,especialidad,'" . $dato['id_biblioteca'] . "','" . $dato['accion'] . "',2,NOW(),$id_usuario FROM alumno_temporal_libreria
                WHERE user_reg='$id_usuario'";
            $this->db->query($sql);

            $sql2 = "UPDATE biblioteca SET estado_b=2,fec_act=NOW(),user_act=$id_usuario WHERE id_biblioteca='" . $dato['id_biblioteca'] . "'";
            $this->db->query($sql2);
        }
        if ($dato['accion'] == 2) {
            $sql = "INSERT biblioteca_acciones (cod_accion,InternalStudentId,nombres,apater,amater,especialidad,id_biblioteca,accion,estado,fec_reg,user_reg)
        
                SELECT '" . $dato['cod_accion'] . "',InternalStudentId,nombres,apater,amater,especialidad,'" . $dato['id_biblioteca'] . "','" . $dato['accion'] . "',2,NOW(),$id_usuario FROM alumno_temporal_libreria
                WHERE user_reg='$id_usuario'";
            $this->db->query($sql);

            $sql2 = "UPDATE biblioteca SET estado_b=1,fec_act=NOW(),user_act=$id_usuario WHERE id_biblioteca='" . $dato['id_biblioteca'] . "'";
            $this->db->query($sql2);
        }
        if ($dato['accion'] == 3) {
            $sql = "INSERT biblioteca_acciones (cod_accion,InternalStudentId,nombres,apater,amater,especialidad,id_biblioteca,accion,estado,fec_reg,user_reg)
        
                SELECT '" . $dato['cod_accion'] . "',InternalStudentId,nombres,apater,amater,especialidad,'" . $dato['id_biblioteca'] . "','" . $dato['accion'] . "',2,NOW(),$id_usuario FROM alumno_temporal_libreria
                WHERE user_reg='$id_usuario'";
            $this->db->query($sql);

            $sql2 = "UPDATE biblioteca SET estado_b=3,fec_act=NOW(),user_act=$id_usuario WHERE id_biblioteca='" . $dato['id_biblioteca'] . "'";
            $this->db->query($sql2);
        }

        $sql1 = "DELETE FROM alumno_temporal_libreria WHERE user_reg='$id_usuario'";

        $this->db->query($sql1);
    }

    function cantidad_biblioteca_acciones()
    {
        $sql = "SELECT e.* from biblioteca_acciones e ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_historico_biblioteca()
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_reg,'%d-%m-%Y') as fecha,b.cod_barra as cod_biblioteca,b.titulo,b.subtitulo,u.usuario_codigo,b.editorial,
        CASE 
        WHEN e.accion=1 THEN 'Solicitado'
        WHEN e.accion=2 THEN 'Por Devolver'
        WHEN e.accion=3 THEN 'Perdido' END as nom_accion
        
        from biblioteca_acciones e 
        left join biblioteca b on e.id_biblioteca=b.id_biblioteca
        left join users u on e.user_reg=u.id_usuario
        where e.estado=2";
        /*$sql = "SELECT b.*,
        case when b.estado_b=2 then (select u.usuario_codigo
                                        from biblioteca_acciones h 
                                        left join users u on h.user_reg=u.id_usuario
                                        where b.id_biblioteca=h.id_blioteca ORDER by h.fec_reg DESC LIMIT 1) as usuario_codigo
        
         FROM biblioteca b where b.estado=2";*/
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_dashboard_historico_biblioteca()
    {
        $sql = "SELECT (select count(*) from biblioteca b where estado=2 and estado_b=1) as disponible,
        (select count(*) from biblioteca where estado=2 and estado_b=2) as por_devolver,
        (select count(*) from biblioteca where estado=2 and estado_b=3) as perdido
        /*(select count(*) from biblioteca where estado=2 and estado_b=3) as perdido*/";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_users_administrador()
    {
        $sql = "SELECT * from users where estado=2 and id_nivel in (1,6,7)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //------------------------------------------LISTA ADMISIÓN---------------------------------------------
    function get_list_admision()
    {
        $sql = "SELECT ca.Id,ct.Description AS Especialidad,cg.Name AS Grupo,pe.IdentityCardNumber,pe.FatherSurname,pe.MotherSurname,
                pe.FirstName,FORMAT(ca.CreationDate,'dd-MM-yyyy HH:mm') AS Fecha_Inscripcion,
                CASE WHEN ap.Name='Sistema' THEN 'Web' ELSE ap.Name END AS Creado_Por,pe.Email
                FROM University.CareerApplication ca
                LEFT JOIN Client cl ON cl.Id=ca.ClientId
                LEFT JOIN Person pe ON pe.Id=cl.PersonId
                LEFT JOIN University.CareerTranslation ct ON ct.CareerId=ca.CareerId
                LEFT JOIN University.CareerGroup cg ON cg.Id=ca.CareerGroupId
                LEFT JOIN AspNetUsers ap ON ap.Id=ca.CreatedBy
                WHERE ca.ApprovalStatusId=0
                ORDER BY ca.Id DESC";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------SALÓN------------------------------------------
    function get_list_salon($id_salon = null)
    {
        if (isset($id_salon) && $id_salon > 0) {
            $sql = "SELECT * FROM salon WHERE id_salon=$id_salon";
        } else {
            $sql = "SELECT sa.*,CASE WHEN sa.ae=1 THEN 'Si' ELSE 'No' END AS ae,
                    CASE WHEN sa.cf=1 THEN 'Si' ELSE 'No' END AS cf,CASE WHEN sa.ds=1 THEN 'Si' ELSE 'No' END AS ds,
                    CASE WHEN sa.aforoind=1 THEN 'Dobles' WHEN sa.aforoind=2 THEN 'Individuales' ELSE '' END AS aforoindf,
                    CASE WHEN sa.et=1 THEN 'Si' ELSE 'No' END AS et,CASE WHEN sa.ft=1 THEN 'Si' ELSE 'No' END AS ft,
                    CASE WHEN sa.estado_salon=1 THEN 'Activo' WHEN sa.estado_salon=2 THEN 'Inactivo' 
                    WHEN sa.estado_salon=3 THEN 'Clausurado' ELSE '' END AS estado_salon,ts.nom_tipo_salon
                    FROM salon sa
                    LEFT JOIN tipo_salon ts ON ts.id_tipo_salon=sa.id_tipo_salon
                    WHERE sa.estado=2
                    ORDER BY sa.planta ASC,sa.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_salon($id_especialidad)
    {
        if ($id_especialidad == 5) {
            $parte = "AND et=1";
        } elseif ($id_especialidad == 6) {
            $parte = "AND ft=1";
        } elseif ($id_especialidad == 7) {
            $parte = "AND ae=1";
        } elseif ($id_especialidad == 8) {
            $parte = "AND cf=1";
        } elseif ($id_especialidad == 9) {
            $parte = "AND ds=1";
        }
        $sql = "SELECT id_salon,descripcion AS nom_salon 
                FROM salon 
                WHERE estado=2 $parte
                ORDER BY nom_salon ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_salon()
    {
        $sql = "SELECT * FROM tipo_salon ORDER BY nom_tipo_salon ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_salon($dato)
    {
        $sql = "SELECT * FROM salon 
                WHERE referencia='" . $dato['referencia'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_salon($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO salon (planta,referencia,id_tipo_salon,descripcion,ae,cf,ds,et,ft,capacidad,disponible,
                pintura,chapa,pizarra,proyector,puerta,tacho,cortina,iluminacion,mueble,mesa_profesor,enchufe,
                computadora,silla_profesor,observaciones,estado_salon,estado,fec_reg,user_reg,fec_act,user_act,carpetatp,
                aforoind,aforodbl,carpetacant) 
                VALUES('" . $dato['planta'] . "','" . $dato['referencia'] . "','" . $dato['id_tipo_salon'] . "',
                '" . $dato['descripcion'] . "','" . $dato['ae'] . "','" . $dato['cf'] . "','" . $dato['ds'] . "','" . $dato['et'] . "',
                '" . $dato['ft'] . "','" . $dato['capacidad'] . "','" . $dato['disponible'] . "','" . $dato['pintura'] . "',
                '" . $dato['chapa'] . "','" . $dato['pizarra'] . "','" . $dato['proyector'] . "','" . $dato['puerta'] . "',
                '" . $dato['tacho'] . "','" . $dato['cortina'] . "','" . $dato['iluminacion'] . "','" . $dato['mueble'] . "',
                '" . $dato['mesa_profesor'] . "','" . $dato['enchufe'] . "','" . $dato['computadora'] . "',
                '" . $dato['silla_profesor'] . "','" . $dato['observaciones'] . "',1,2,NOW(),$id_usuario,NOW(),$id_usuario,
                '" . $dato['carpetatp'] . "','" . $dato['aforoind'] . "','" . $dato['aforodbl'] . "','" . $dato['carpetacant'] . "')";
        $this->db->query($sql);
    }

    function valida_update_salon($dato)
    {
        $sql = "SELECT * FROM salon WHERE referencia='" . $dato['referencia'] . "' AND 
                estado=2 AND id_salon!='" . $dato['id_salon'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_salon($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon SET planta='" . $dato['planta'] . "',referencia='" . $dato['referencia'] . "',
                id_tipo_salon='" . $dato['id_tipo_salon'] . "',descripcion='" . $dato['descripcion'] . "',
                ae='" . $dato['ae'] . "',cf='" . $dato['cf'] . "',ds='" . $dato['ds'] . "',et='" . $dato['et'] . "',ft='" . $dato['ft'] . "',
                capacidad='" . $dato['capacidad'] . "',disponible='" . $dato['disponible'] . "',pintura='" . $dato['pintura'] . "',
                chapa='" . $dato['chapa'] . "',pizarra='" . $dato['pizarra'] . "',proyector='" . $dato['proyector'] . "',
                puerta='" . $dato['puerta'] . "',tacho='" . $dato['tacho'] . "',cortina='" . $dato['cortina'] . "',
                iluminacion='" . $dato['iluminacion'] . "',mueble='" . $dato['mueble'] . "',mesa_profesor='" . $dato['mesa_profesor'] . "',
                enchufe='" . $dato['enchufe'] . "',computadora='" . $dato['computadora'] . "',silla_profesor='" . $dato['silla_profesor'] . "',
                observaciones='" . $dato['observaciones'] . "',estado_salon='" . $dato['estado_salon'] . "',
                carpetatp='" . $dato['carpetatp'] . "',aforoind='" . $dato['aforoind'] . "',
                aforodbl='" . $dato['aforodbl'] . "',carpetacant='" . $dato['carpetacant'] . "',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_salon='" . $dato['id_salon'] . "'";
        $this->db->query($sql);
    }

    function delete_salon($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_salon='" . $dato['id_salon'] . "'";
        $this->db->query($sql);
    }
    //-----------------------------------------------RRHH------------------------------------------
    function get_list_rrhh($Id = null)
    {
        if (isset($Id) && $Id > 0) {
            $sql = "SELECT *,CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre) AS Nombre_Completo 
                    FROM todos_l20 
                    WHERE Id=$Id";
        } else {
            $sql = "SELECT td.*,DATE_FORMAT(td.Fecha_Cumpleanos,'%d/%m/%Y') AS Fecha_Nacimiento,
                    CASE WHEN (SELECT COUNT(*) FROM foto_docentes fd 
                    WHERE fd.id_empresa=6 AND fd.id_docente=td.Id AND fd.estado=2)>0 THEN 'Si' ELSE 'No' END AS foto
                    FROM todos_l20 td
                    WHERE td.Tipo=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_rrhh_registrados($id_rrhh = null)
    {
        if (isset($id_rrhh) && $id_rrhh > 0) {
            $sql = "SELECT * FROM rrhh WHERE id_rrhh=$id_rrhh";
        } else {
            $sql = "SELECT *,CASE WHEN ae=1 THEN 'Si' ELSE 'No' END AS ae,
                CASE WHEN cf=1 THEN 'Si' ELSE 'No' END AS cf,CASE WHEN ds=1 THEN 'Si' ELSE 'No' END AS ds,
                CASE WHEN et=1 THEN 'Si' ELSE 'No' END AS et,CASE WHEN ft=1 THEN 'Si' ELSE 'No' END AS ft
                FROM rrhh
                WHERE estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_rrhh($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO rrhh (EmployeeId,ae,cf,ds,et,ft,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['EmployeeId'] . "','" . $dato['ae'] . "','" . $dato['cf'] . "',
                '" . $dato['ds'] . "','" . $dato['et'] . "','" . $dato['ft'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_rrhh($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE rrhh SET ae='" . $dato['ae'] . "',cf='" . $dato['cf'] . "',ds='" . $dato['ds'] . "',et='" . $dato['et'] . "',
                ft='" . $dato['ft'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_rrhh='" . $dato['id_rrhh'] . "'";
        $this->db->query($sql);
    }

    function get_list_foto_docentes($id_docente)
    {
        $sql = "SELECT fm.*,DATE_FORMAT(fm.fec_reg,'%d/%m/%Y') AS fecha,us.usuario_codigo
                FROM foto_docentes fm
                LEFT JOIN users us ON us.id_usuario=fm.user_reg
                WHERE fm.id_docente=$id_docente ORDER BY fm.id_foto DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_foto_docentes($id_foto)
    {
        $sql = "SELECT * FROM foto_docentes WHERE id_foto=$id_foto";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_foto_docentes($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO foto_docentes (id_empresa,id_docente,foto,estado,fec_reg,user_reg)
                VALUES (6,'" . $dato['id_docente'] . "','" . $dato['foto'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    //--------------Asistencia--------------------------
    function get_list_registro_ingreso_a($id_registro_ingreso = null)
    {
        if (isset($id_registro_ingreso) && $id_registro_ingreso > 0) {
            $sql = "SELECT * FROM registro_ingreso WHERE id_registro_ingreso=$id_registro_ingreso";
        } else {
            $sql = "SELECT ri.*,DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,CASE WHEN ri.estado_ingreso=1 THEN 'Puntual'
                    WHEN ri.estado_ingreso=2 THEN 'Retrasado' WHEN ri.estado_ingreso=3 THEN 'Denegado' ELSE '' END AS estado_ing,
                    es.abreviatura,CASE WHEN SUBSTRING(ri.codigo,-1,1)='C' THEN 'Colaborador' ELSE 'Alumno' END AS nom_tipo_acceso,
                    CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) THEN CONCAT(ri.nombres,' ',ri.codigo)
                    ELSE ri.nombres END AS nombre,CONCAT(ri.apater,' ',ri.amater) AS apellidos
                    FROM registro_ingreso ri
                    LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                    WHERE ri.estado=2 AND DATE(ri.ingreso)=CURDATE() ORDER BY ri.ingreso DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_historial_registro_ingreso($codigo_alumno)
    {
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE(fec_reg)  as Fecha
                FROM historial_registro_ingreso 
                WHERE estado=2 AND codigo='" . addslashes($codigo_alumno) . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_alumnos_ingresados()
    {
        $sql = "SELECT id_alumno FROM registro_ingreso 
                WHERE estado=2 AND DATE(ingreso)=CURDATE() AND estado_ingreso NOT IN (3)
                GROUP BY id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_alumnos_sin_salida()
    {
        $sql = "SELECT ri.id_registro_ingreso FROM registro_ingreso ri
                LEFT JOIN matriculados_l20 ma ON ma.Id=ri.id_alumno
                WHERE ma.Tipo IN (2,3) AND ri.salida=0 AND DATE(ri.ingreso)=CURDATE() AND ri.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_total_matriculados()
    {
        $sql = "SELECT *,CASE WHEN Tipo IN (1,2) THEN CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre,' - ',Codigoa) 
                ELSE CONCAT(Nombre,' - ',Codigoa) END AS nombres 
                FROM matriculados_l20";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_matriculado($codigo_alumno)
    {
        $sql = "SELECT ma.*,CONCAT(ma.Apellido_Paterno,' ',ma.Apellido_Materno) AS apellidos,
                CONCAT(ma.Nombre,' ',ma.Apellido_Paterno,' ',ma.Apellido_Materno) AS nombres,
                es.abreviatura,ma.especialidad,
                (SELECT COUNT(*) FROM documento_alumno_empresa da 
                WHERE da.id_empresa=6 AND da.estado=2 AND (da.obligatorio=1 || (da.obligatorio=2 && TIMESTAMPDIFF(YEAR, td.Fecha_Cumpleanos, CURDATE())>4) || 
                (da.obligatorio=3 && TIMESTAMPDIFF(YEAR, td.Fecha_Cumpleanos, CURDATE())<18))) AS documentos_obligatorios,
                (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE de.id_alumno=td.Id AND de.estado=2 AND de.archivo!='' AND
                da.id_empresa=6 AND da.estado=2 AND (da.obligatorio=1 || (da.obligatorio=2 && TIMESTAMPDIFF(YEAR, td.Fecha_Cumpleanos, CURDATE())>4) || 
                (da.obligatorio=3 && TIMESTAMPDIFF(YEAR, td.Fecha_Cumpleanos, CURDATE())<18))) AS documentos_subidos,
                CASE WHEN td.Documento_Foto!='' THEN 1 ELSE 0 END AS Primer_Documento,CASE WHEN td.Documento_Dni!='' THEN 1 ELSE 0 END AS Segundo_Documento,
                td.Fotocheck
                FROM matriculados_l20 ma 
                LEFT JOIN especialidad es ON es.nom_especialidad=ma.Especialidad AND es.estado=2
                LEFT JOIN todos_l20 td ON td.Id=ma.Id
                WHERE ma.Codigoa='" . addslashes($codigo_alumno) . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_matriculado_promovido($codigo_alumno)
    {
        $sql = "SELECT Id FROM todos_l20 
                WHERE Tipo=1 AND Codigo='" . addslashes($codigo_alumno) . "' AND Matricula='Promovido' AND 
                Alumno='Matriculado'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_foto_matriculado($id_alumno, $tipo)
    {
        if ($tipo == 1) {
            $sql = "SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.archivo!='' AND de.estado=2";
        } else {
            $sql = "SELECT * FROM foto_docentes WHERE id_docente='$id_alumno' AND foto!=''";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_registro_ingreso($dato)
    {
        $sql = "SELECT * FROM registro_ingreso 
                WHERE id_alumno='" . $dato['id_alumno'] . "' AND estado=2 AND DATE(ingreso)=CURDATE()";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function traer_duplicidad_registro_ingreso($dato)
    {
        $sql = "SELECT * FROM registro_ingreso 
                WHERE id_alumno='" . $dato['id_alumno'] . "' AND estado=2 AND duplicidad=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_duplicidad_registro_ingreso($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso SET duplicidad=0 
                WHERE id_alumno='" . $dato['id_alumno'] . "'";
        $this->db->query($sql);
    }

    function insert_registro_ingreso($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,estado_reporte,user_autorizado,estado,fec_reg,user_reg,reg_automatico,duplicidad) 
                VALUES('" . $dato['id_alumno'] . "',NOW(),'" . $dato['especialidad'] . "','" . $dato['grupo'] . "',
                '" . $dato['modulo'] . "','" . $dato['grado'] . "','" . $dato['seccion'] . "','" . addslashes($dato['codigo']) . "','" . $dato['apater'] . "',
                '" . $dato['amater'] . "','" . $dato['nombres'] . "',1,'" . $dato['estado_reporte'] . "',
                '" . $dato['user_autorizado'] . "',2,NOW(),$id_usuario,'" . $dato['reg_automatico'] . "',
                '" . $dato['duplicidad'] . "')";
        $this->db->query($sql);
    }

    function get_foto_matriculado($id_alumno, $tipo)
    {
        if ($tipo == 1) {
            $sql = "SELECT de.archivo AS foto FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.estado=2
                    ORDER BY de.id_detalle DESC";
        } else {
            $sql = "SELECT * FROM foto_docentes WHERE id_docente='$id_alumno' ORDER BY id_foto DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro_ingreso_modal($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,no_tarjeta,estado,fec_reg,user_reg,reg_automatico) 
                VALUES('" . $dato['id_alumno'] . "',NOW(),'" . $dato['especialidad'] . "','" . $dato['grupo'] . "',
                '" . $dato['modulo'] . "','" . $dato['grado'] . "','" . $dato['seccion'] . "','" . addslashes($dato['codigo']) . "','" . $dato['apater'] . "',
                '" . $dato['amater'] . "','" . $dato['nombres'] . "',1,1,2,NOW(),$id_usuario,'" . $dato['reg_automatico'] . "')";
        $this->db->query($sql);
    }

    function ultimo_id_registro_ingreso()
    {
        $sql = "SELECT id_registro_ingreso FROM registro_ingreso ORDER BY id_registro_ingreso DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_historial_registro_ingreso($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_registro_ingreso (id_registro_ingreso,tipo,codigo,observacion,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_registro_ingreso'] . "','" . $dato['tipo'] . "','" . addslashes($dato['codigo']) . "',
                '" . $dato['observacion'] . "',NOW(),NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_registro_ingreso($id_alumno)
    {
        $sql = "SELECT id_registro_ingreso,TIMESTAMPDIFF(MINUTE,TIME(ingreso),DATE_ADD(TIME(NOW()),INTERVAL 2 HOUR)) AS minutos 
                FROM registro_ingreso
                WHERE id_alumno=$id_alumno AND DATE(ingreso)=CURDATE() AND salida=0
                ORDER BY id_registro_ingreso DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_registro_ingreso($dato)
    {
        $sql = "UPDATE registro_ingreso SET salida=1,hora_salida=DATE_ADD(TIME(NOW()),INTERVAL 2 HOUR)
                WHERE id_registro_ingreso='" . $dato['id_registro_ingreso'] . "'";
        $this->db->query($sql);
    }

    function delete_registro_ingreso($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_registro_ingreso='" . $dato['id_registro_ingreso'] . "'";
        $this->db->query($sql);
    }

    function get_clave_asistencia($clave_admin)
    {
        $sql = "SELECT id_usuario FROM users WHERE clave_asistencia='$clave_admin'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_salida()
    {
        $sql = "SELECT id_registro_ingreso,DATE_FORMAT(ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(nombres,' ',codigo) ELSE nombres END AS nombre,
                CONCAT(apater,' ',amater) AS apellidos 
                FROM registro_ingreso 
                WHERE salida=0 AND DATE(ingreso)=CURDATE() AND estado=2
                ORDER BY ingreso DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_registro_salida($dato)
    {
        $sql = "UPDATE registro_ingreso SET salida=1,hora_salida='23:59:00'
                WHERE id_registro_ingreso='" . $dato['id_registro_ingreso'] . "'";
        $this->db->query($sql);
    }
    //-------------------------------FIN ASISTENCIA--------------------------------
    function get_list_motivo($id_motivo = null)
    {
        if (isset($id_motivo) && $id_motivo > 0) {
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE id_motivo=$id_motivo";
        } else {
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_alumno_retirado($id_alumno)
    {
        $sql = "SELECT a.*,u.usuario_codigo,DATE_FORMAT(a.fec_reg,'%d/%m/%Y %H:%i %p') as fecha_actualizacion
                FROM alumno_retirado a 
                LEFT JOIN users u on a.user_reg=u.id_usuario
                WHERE a.id_empresa=6 AND a.Id='$id_alumno'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_retirado($id_alumno_retirado = null)
    {
        if (isset($id_alumno_retirado) && $id_alumno_retirado > 0) {
            $sql = "SELECT id_alumno_retirado,obs_retiro,Codigo FROM alumno_retirado 
                    WHERE id_alumno_retirado=$id_alumno_retirado";
        } else {
            $sql = "SELECT * FROM alumno_retirado 
                    WHERE id_empresa=6 AND estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_obs_motivo_retiro($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET obs_retiro='" . $dato['obs_retiro'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_alumno_retirado='" . $dato['id_alumno_retirado'] . "'";
        $this->db->query($sql);
    }

    function insert_retiro_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_retirado (id_empresa,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,
                Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Fecha_Cumpleanos,Celular,
                fecha_nasiste,id_motivo,otro_motivo,fut,fecha_fut,tkt_boleta,pago_pendiente,monto,contacto,
                fecha_contacto,hora_contacto,resumen,p_reincorporacion,obs_retiro,estado,fec_reg,user_reg)
                SELECT 6,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Grupo,Especialidad,
                Turno,Modulo,Seccion,'Retirado','Retirado',Fecha_Cumpleanos,Celular,'" . $dato['fecha_nasiste'] . "',
                '" . $dato['id_motivo'] . "','" . $dato['otro_motivo'] . "','" . $dato['fut'] . "','" . $dato['fecha_fut'] . "',
                '" . $dato['tkt_boleta'] . "','" . $dato['pago_pendiente'] . "','" . $dato['monto'] . "','" . $dato['contacto'] . "',
                '" . $dato['fecha_contacto'] . "','" . $dato['hora_contacto'] . "','" . $dato['resumen'] . "',
                '" . $dato['p_reincorporacion'] . "','" . $dato['obs_retiro'] . "',2,NOW(),$id_usuario 
                FROM todos_l20 
                WHERE Id='" . $dato['id_alumno'] . "' ";
        $this->db->query($sql);
    }

    function update_retiro_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET fecha_nasiste='" . $dato['fecha_nasiste'] . "',
                id_motivo='" . $dato['id_motivo'] . "',otro_motivo='" . $dato['otro_motivo'] . "',fut='" . $dato['fut'] . "',
                fecha_fut='" . $dato['fecha_fut'] . "',tkt_boleta='" . $dato['tkt_boleta'] . "',
                pago_pendiente='" . $dato['pago_pendiente'] . "',monto='" . $dato['monto'] . "',contacto='" . $dato['contacto'] . "',
                fecha_contacto='" . $dato['fecha_contacto'] . "',hora_contacto='" . $dato['hora_contacto'] . "',
                resumen='" . $dato['resumen'] . "',p_reincorporacion='" . $dato['p_reincorporacion'] . "',
                obs_retiro='" . $dato['obs_retiro'] . "',aprobado=0,fec_act=NOW(),user_act=$id_usuario
                WHERE Id='" . $dato['id_alumno'] . "' AND estado=2";
        $this->db->query($sql);
    }

    function update_estado_alumno_retirado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET aprobado='" . $dato['aprobacion'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE Id='" . $dato['id_alumno'] . "' and estado=2";
        $this->db->query($sql);
    }

    function get_list_documento_alumno($id_alumno)
    {
        $sql = "SELECT dd.id_detalle,CASE WHEN da.obligatorio=0 THEN 'No' 
                WHEN da.obligatorio=1 THEN 'Si' WHEN da.obligatorio=2 
                THEN 'Mayores de 4 (>4)' WHEN da.obligatorio=3 
                THEN 'Menores de 18 (<18)' ELSE '' END AS v_obligatorio,
                dd.anio,da.cod_documento,
                CONCAT(da.nom_documento,' - ',da.descripcion_documento) AS 
                nom_documento,dd.archivo,
                CASE WHEN da.cod_documento='D31' THEN 
                (CASE WHEN (SELECT COUNT(*) FROM documento_firma df 
                WHERE df.id_alumno=dd.id_alumno AND df.id_empresa=6 AND 
                df.estado_d=3 AND df.estado=2)>0 THEN 'Firmado' ELSE 'Pendiente' END)
                ELSE SUBSTRING_INDEX(dd.archivo,'/',-1) END AS nom_archivo,
                us.usuario_codigo AS usuario_subido,
                DATE_FORMAT(dd.fec_subido,'%d-%m-%Y') AS fec_subido
                FROM detalle_alumno_empresa dd
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=dd.id_documento
                LEFT JOIN users us ON us.id_usuario=dd.user_subido
                WHERE dd.id_alumno=$id_alumno AND dd.id_empresa=6 AND dd.estado=2
                ORDER BY dd.anio DESC,da.obligatorio DESC,da.cod_documento ASC,
                da.nom_documento ASC,da.descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_has_year($id_alumno, $edad)
    {
        $parte = "";
        if ($edad > 17) {
            $parte = "AND de.nom_documento NOT LIKE '%menor%'";
        }
        $sql = "SELECT de.id_documento,de.cod_documento,de.nom_documento,de.descripcion_documento,
                de.id_detalle,de.archivo,us.usuario_codigo,DATE_FORMAT(de.fec_subido,'%d/%m/%Y') AS fec_subido,
                CASE WHEN de.obligatorio=0 THEN 'No' WHEN de.obligatorio=1 THEN 'Si'
                WHEN de.obligatorio=2 THEN 'Mayores de 4 (>4)' WHEN de.obligatorio=3 THEN 'Menores de 18 (<18)' 
                END AS v_obligatorio
                FROM detalle_alumno_empresa de
                LEFT JOIN users us ON us.id_usuario=de.user_subido
                WHERE de.id_empresa=6 AND de.estado=2 AND de.id_alumno=$id_alumno AND de.estado=2 AND year!='' $parte
                ORDER BY v_obligatorio DESC,de.archivo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_documento()
    {
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                ORDER BY id_documento DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_documento_todos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT Id FROM todos_l20
                WHERE Tipo=1 AND Alumno='Matriculado'
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC,Codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_documento_todos($dato)
    {
        $sql = "SELECT * FROM detalle_alumno_empresa 
                WHERE id_alumno='" . $dato['id_alumno'] . "' AND
                id_documento='" . $dato['id_documento'] . "' AND id_empresa=6 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_todos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,anio,
                estado,fec_reg,user_reg)
                VALUES ('" . $dato['id_alumno'] . "','" . $dato['id_documento'] . "',6,
                '" . $dato['anio'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_documento_duplicado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_empresa,cod_documento,nom_grado,nom_documento,descripcion_documento,
                obligatorio,digital,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_alumno'] . "',6,'" . $dato['cod_documento'] . "','" . $dato['id_especialidad'] . "','" . $dato['nom_documento'] . "',
                '" . $dato['descripcion_documento'] . "','" . $dato['obligatorio'] . "','" . $dato['digital'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    function get_id_last_documento()
    {
        $sql = "SELECT id_documento FROM documento_alumno_empresa ORDER BY id_documento DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*SELECT COUNT(*) FROM documento_alumno_empresa da 
    WHERE da.id_empresa=2 AND (da.obligatorio=1 || (da.obligatorio=2 && TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>4) || (da.obligatorio=3 && 
    TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())<18)) AND da.nom_grado IN ('Todos','4 Años')*/

    function get_list_documento_alumno_arpay($id_alumno)
    {
        $sql = "SELECT sd.Id,sd.Name AS Nom_Documento,sd.DocumentFilePath AS Documento_Subido,au.Name AS Usuario_Entrega,
                FORMAT(sd.DeliveryDate,'dd-MM-yyyy') AS Fecha_Entrega
                FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=$id_alumno";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_alumno_arpay($id_documento)
    {
        $sql = "SELECT DocumentFilePath AS Documento_Subido FROM Student.StudentDocument
                WHERE Id=$id_documento";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,archivo,user_subido,fec_subido,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_alumno'] . "','" . $dato['id_documento'] . "','" . $dato['archivo'] . "',$id_usuario,NOW(),2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_detalle_alumno_empresa($id_detalle)
    {
        $sql = "SELECT * FROM detalle_alumno_empresa 
                WHERE id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET archivo='" . $dato['archivo'] . "',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='" . $dato['id_detalle'] . "'";
        $this->db->query($sql);
    }

    function delete_documento_alumno($dato)
    {
        $sql = "UPDATE detalle_alumno_empresa SET archivo='',fec_subido=NULL,user_subido=0
                WHERE id_detalle='" . $dato['id_detalle'] . "'";
        $this->db->query($sql);
    }

    function get_list_pago_arpay_matriculados($id_alumno)
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

    function get_list_pago_snappy_matriculados($id_alumno, $estado)
    {
        $parte = "";
        if ($estado == 2) {
            $parte = "AND ve.pendiente=1";
        }
        $sql = "SELECT ve.id_venta,ve.cod_venta,
                (SELECT GROUP_CONCAT(pv.nom_sistema SEPARATOR ', ') 
                FROM venta_empresa_detalle vd
                LEFT JOIN producto_venta pv ON pv.cod_producto=vd.cod_producto AND pv.estado=2
                WHERE vd.id_venta=ve.id_venta) AS productos,
                (SELECT SUM(vd.precio-vd.descuento) FROM venta_empresa_detalle vd
                WHERE vd.id_venta=ve.id_venta) AS monto,
                DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha,
                CASE WHEN ve.pendiente=1 THEN 'Pendiente' ELSE 'Pagado' END AS nom_estado,
                ve.pendiente
                FROM venta_empresa ve
                WHERE ve.id_alumno=$id_alumno $parte AND ve.estado=2
                ORDER BY ve.cod_venta ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_pago_automatizado()
    {
        $sql = "SELECT id_producto,nom_sistema 
                FROM producto_venta
                WHERE pago_automatizado=1 AND estado=2
                ORDER BY nom_sistema ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_pago_snappy($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta_empresa (cod_venta,id_empresa,id_alumno,pendiente,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['cod_venta'] . "',6,'" . $dato['id_alumno'] . "',1,2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function insert_detalle_pago_snappy($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta_empresa_detalle (id_venta,cod_producto,precio,descuento,
                cantidad,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_venta'] . "','" . $dato['cod_producto'] . "','" . $dato['precio'] . "',
                '" . $dato['descuento'] . "',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_detalle_producto_pago_automatizado($id_venta)
    {
        $sql = "SELECT precio,descuento,cantidad FROM venta_empresa_detalle 
                WHERE id_venta=$id_venta";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_snappy($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE venta_empresa SET id_tipo_pago='" . $dato['id_tipo_pago'] . "',
                monto_entregado='" . $dato['monto_entregado'] . "',cambio='" . $dato['cambio'] . "',
                pendiente=0,fec_act=NOW(),user_act=$id_usuario
                WHERE id_venta='" . $dato['id_venta'] . "'";
        $this->db->query($sql);
    }

    function get_list_sms_matriculados($celular)
    {
        $sql = "SELECT md.fec_reg AS orden,DATE_FORMAT(md.fec_reg,'%d-%m-%Y') AS fecha,
                us.usuario_codigo AS usuario,me.mensaje
                FROM mensaje_detalle md
                LEFT JOIN users us ON us.id_usuario=md.user_reg
                LEFT JOIN mensaje me ON me.id_mensaje=md.id_mensaje 
                WHERE md.numero=$celular
                ORDER BY md.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_alumno($id_alumno = null, $id_observacion = null)
    {
        if (isset($id_observacion) && $id_observacion > 0) {
            $sql = "SELECT * FROM alumno_observaciones_general 
                    WHERE id_observacion=$id_observacion";
        } else {
            $sql = "SELECT ao.id_observacion,DATE_FORMAT(ao.fecha_obs,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                    us.usuario_codigo AS usuario,ao.observacion,ao.fecha_obs AS orden, observacion_archivo
                    FROM alumno_observaciones_general ao
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=ao.id_tipo
                    LEFT JOIN users us ON us.id_usuario=ao.usuario_obs
                    WHERE ao.id_alumno=$id_alumno AND ao.id_empresa=6 AND ao.estado=2
                    ORDER BY ao.fecha_obs DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_obs($tipo_usuario = null)
    {
        if (isset($tipo_usuario) && $tipo_usuario > 0) {
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 and tipo_usuario=$tipo_usuario
                    ORDER BY nom_tipo";
        } else {
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 
                    ORDER BY nom_tipo";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_observacion()
    {
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                /*WHERE id_usuario IN (1,7,10,45,60,64,70,76,82,85,133,197,269) AND estado=2*/
                WHERE id_usuario IN (1,7,9,10) AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_alumno($dato)
    {
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=6 AND id_alumno='" . $dato['id_alumno'] . "' AND 
                id_tipo='" . $dato['id_tipo'] . "' AND observacion='" . $dato['observacion'] . "' AND 
                fecha_obs='" . $dato['fecha'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_alumno,id_tipo,observacion,
                fecha_obs,usuario_obs,estado,fec_reg,user_reg, observacion_archivo) 
                VALUES (6,'" . $dato['id_alumno'] . "','" . $dato['id_tipo'] . "','" . $dato['observacion'] . "',
                '" . $dato['fecha'] . "','" . $dato['usuario'] . "',2,NOW(),$id_usuario,
                '" . $dato['observacion_archivo'] . "')";
        $this->db->query($sql);
    }

    function valida_update_observacion_alumno($dato)
    {
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=6 AND id_alumno='" . $dato['id_alumno'] . "' AND 
                id_tipo='" . $dato['id_tipo'] . "' AND observacion='" . $dato['observacion'] . "' AND 
                fecha_obs='" . $dato['fecha'] . "' AND estado=2 AND 
                id_observacion!='" . $dato['id_observacion'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET id_tipo='" . $dato['id_tipo'] . "',
                fecha_obs='" . $dato['fecha'] . "',usuario_obs='" . $dato['usuario'] . "',
                observacion='" . $dato['observacion'] . "',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db->query($sql);
    }

    function delete_observacion_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db->query($sql);
    }
    //-----------------------------------------------PRODUCTO------------------------------------------
    function get_lista_producto($tipo)
    {
        $anio = date('Y');
        $parte = "";
        if ($tipo == 1) {
            $parte = "WHERE estado='Activo' AND anio=$anio";
        }

        $sql = "SELECT * FROM producto_arpay_fv
                $parte
                ORDER BY anio ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto($id_producto = null)
    {
        if (isset($id_producto) && $id_producto > 0) {
            $sql = "SELECT pr.*,ps.cancelado FROM producto_arpay_fv pr
                    LEFT JOIN producto_snappy_fv ps ON ps.Id=pr.Id
                    WHERE pr.Id=$id_producto";
        } else {
            $sql = "SELECT * FROM producto_arpay_fv
                    ORDER BY anio ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_snappy($id_producto = null)
    {
        if (isset($id_producto) && $id_producto > 0) {
            $sql = "SELECT ps.*,pa.anio,pa.nom_producto,pa.estado 
                    FROM producto_snappy_fv ps
                    LEFT JOIN producto_arpay_fv pa ON pa.Id=ps.Id
                    WHERE ps.id_producto=$id_producto";
        } else {
            $sql = "SELECT ps.id_producto,ps.Id,CASE WHEN ps.informe=0 THEN 'No' ELSE 'Si' END AS v_informe,
                    CASE WHEN ps.cancelado=0 THEN 'No' ELSE 'Si' END AS v_cancelado,tp.nom_tipo_producto,ps.id_especialidad
                    FROM producto_snappy_fv ps
                    LEFT JOIN tipo_producto tp ON tp.id_tipo_producto=ps.tipo
                    WHERE ps.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_producto()
    {
        $sql = "SELECT id_tipo_producto,nom_tipo_producto FROM tipo_producto
                WHERE estado=2 AND id_empresa=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_producto($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_snappy_fv (Id,informe,tipo,cancelado,id_especialidad,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_producto'] . "','" . $dato['informe'] . "','" . $dato['tipo'] . "',
                '" . $dato['cancelado'] . "','" . $dato['id_especialidad'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_producto($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_snappy_fv SET informe='" . $dato['informe'] . "',tipo='" . $dato['tipo'] . "',
                cancelado='" . $dato['cancelado'] . "',id_especialidad='" . $dato['id_especialidad'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_producto='" . $dato['id_producto'] . "'";
        $this->db->query($sql);
    }
    //-----------------------------------------------DOCUMENTO------------------------------------------
    function get_list_documento($id_documento = null)
    {
        if (isset($id_documento) && $id_documento > 0) {
            $sql = "SELECT * FROM documento_alumno_empresa 
                    WHERE id_documento=$id_documento";
        } else {
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    CASE WHEN do.nom_grado=0 THEN 'Todos' ELSE es.nom_especialidad END AS nom_especialidad,
                    st.nom_status,CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_alumno_empresa do
                    LEFT JOIN especialidad es ON es.id_especialidad=do.nom_grado
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=6 AND do.estado!=4
                    ORDER BY do.nom_documento ASC,do.descripcion_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_documento_combo()
    {
        $sql = "SELECT id_documento,nom_documento FROM documento_alumno_empresa
                WHERE id_empresa=6 AND estado!=4
                ORDER BY nom_documento ASC,descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_documento($dato)
    {
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=6 AND cod_documento='" . $dato['cod_documento'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_alumno_empresa (id_empresa,cod_documento,nom_grado,nom_documento,
                descripcion_documento,obligatorio,digital,aplicar_todos,departamento,aparece_doc,validacion,
                estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['cod_documento'] . "','" . $dato['id_especialidad'] . "',
                '" . $dato['nom_documento'] . "','" . $dato['descripcion_documento'] . "','" . $dato['obligatorio'] . "',
                '" . $dato['digital'] . "','" . $dato['aplicar_todos'] . "','" . $dato['departamento'] . "',
                '" . $dato['aparece_doc'] . "','" . $dato['validacion'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_documento_todos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_documento='" . $dato['id_documento'] . "' AND id_alumno='" . $dato['id_alumno'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento_todos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET cod_documento='" . $dato['cod_documento'] . "',nom_grado='" . $dato['id_especialidad'] . "',nom_documento='" . $dato['nom_documento'] . "',
        descripcion_documento='" . $dato['descripcion_documento'] . "',digital='" . $dato['digital'] . "',obligatorio='" . $dato['v_obligatorio'] . "',aplicar_todos='" . $dato['aplicar_todos'] . "',
        fec_act=NOW(),user_act=$id_usuario 
        WHERE id_documento='" . $dato['id_documento'] . "' and id_alumno='" . $dato['id_alumno'] . "' AND estado=2";
        $this->db->query($sql);
    }

    function update_documento_todos_doade($dato)
    {
        $sql = "UPDATE detalle_alumno_empresa SET id_empresa=6, cod_documento=(Select cod_documento from documento_alumno_empresa where id_documento='" . $dato['id_documento'] . "' AND estado=2),nom_grado=(Select nom_grado from documento_alumno_empresa where id_documento='" . $dato['id_documento'] . "' AND estado=2),
                nom_documento=(Select nom_documento from documento_alumno_empresa where id_documento='" . $dato['id_documento'] . "' AND estado=2),
                descripcion_documento=(Select descripcion_documento from documento_alumno_empresa where id_documento='" . $dato['id_documento'] . "' AND estado=2),
                departamento='" . $dato['departamento'] . "',aparece_doc='" . $dato['aparece_doc'] . "',
                obligatorio=(Select obligatorio from documento_alumno_empresa where id_documento='" . $dato['id_documento'] . "' AND estado=2),
                aplicar_todos=1 WHERE id_alumno='" . $dato['id_alumno'] . "' AND id_documento='" . $dato['id_documento'] . "' AND estado=2";
        $this->db->query($sql);
    }


    function valida_update_documento($dato)
    {
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=6 AND cod_documento='" . $dato['cod_documento'] . "' AND estado=2 AND 
                id_documento!='" . $dato['id_documento'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET cod_documento='" . $dato['cod_documento'] . "',
                nom_grado='" . $dato['id_especialidad'] . "',nom_documento='" . $dato['nom_documento'] . "',
                descripcion_documento='" . $dato['descripcion_documento'] . "',
                obligatorio='" . $dato['obligatorio'] . "',digital='" . $dato['digital'] . "',
                aplicar_todos='" . $dato['aplicar_todos'] . "',
                departamento='" . $dato['departamento'] . "',aparece_doc='" . $dato['aparece_doc'] . "',
                validacion='" . $dato['validacion'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }

    function delete_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }
    //------------------------------------ADMISIÓN-----------------------------------------------
    function get_list_salir_matriculados()
    {
        $sql = "SELECT gc.grupo,es.nom_especialidad,
                CASE WHEN ho.nom_turno='Mañana' THEN 'MN' 
                WHEN ho.nom_turno='Tarde' THEN 'TR' ELSE '' END AS nom_turno 
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad 
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno 
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora 
                WHERE gc.salir_matriculados=1 AND gc.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_modulo_admision($tipo)
    { //,$condicion 
        $parte = "";
        if ($tipo == 1) {
            /*if($condicion==""){
                $parte = "";
            }else{
                $parte = "WHERE $condicion";
            }*/
            $parte = "WHERE aa.Grupo IN (SELECT grupo FROM grupo_calendarizacion
                    WHERE salir_matriculados=1 AND estado=2
                    GROUP BY grupo)";
        }
        /*(SELECT COUNT(*) FROM documento_alumno_empresa da 
                WHERE da.id_empresa=6 AND da.obligatorio=1) AS documentos_obligatorios,
                (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.obligatorio=1 AND da.estado=2 AND de.id_alumno=aa.ClientId AND de.archivo!='' AND 
                de.estado=2) AS documentos_subidos, */
        $sql = "SELECT aa.Apellido_Paterno,aa.Apellido_Materno,aa.Nombre,aa.Codigo,es.abreviatura,aa.Grupo,tl.Seccion,aa.Matricula,
                aa.Alumno,DATE_FORMAT(aa.Fecha_Matricula,'%d-%m-%Y') AS Fec_Matricula,aa.Monto_Matricula,
                DATE_FORMAT(aa.Fecha_Cuota_1,'%d-%m-%Y') AS Fec_Cuota_1,aa.Monto_Cuota_1,aa.Estado_Matricula,aa.Estado_Cuota_1,
                aa.ClientId,aa.Celular,aa.Email,CASE WHEN (SELECT COUNT(*) FROM documento_firma df 
                WHERE df.id_alumno=aa.ClientId AND df.id_empresa=6 AND SUBSTRING(YEAR(df.fecha_firma),-2)=SUBSTRING(aa.Grupo,1,2) AND 
                df.estado=2)>0 THEN 'Si' ELSE 'No' END AS v_contrato,
                (SELECT DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') FROM documento_firma df 
                WHERE df.id_alumno=aa.ClientId AND df.id_empresa=6 AND SUBSTRING(YEAR(df.fecha_firma),-2)=SUBSTRING(aa.Grupo,1,2) AND 
                df.estado=2 
                ORDER BY df.id_documento_firma DESC 
                LIMIT 1) AS fecha_firma,(CASE WHEN aa.turno='MN' THEN 'Mañana' 
                WHEN aa.turno='TR' THEN 'Tarde' END) as Turno,tl.Dni
                FROM alumno_admision_fv aa
                LEFT JOIN todos_l20 tl ON aa.ClientId=tl.id and aa.codigo=tl.codigo
                LEFT JOIN especialidad es ON es.nom_especialidad=aa.Especialidad AND es.estado=2
                $parte
                ORDER BY aa.Apellido_Paterno ASC,aa.Apellido_Materno ASC,aa.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //------------------------------------C ADMISIÓN-----------------------------------------------
    /*function get_list_modulo_c_admision(){ 
        $sql = "SELECT Grupo FROM todos_l20 
                WHERE Tipo=1 AND Grupo!='' GROUP BY Grupo
                ORDER BY Grupo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function get_list_grupo_admision($id_grupo = null)
    {
        if (isset($id_grupo) && $id_grupo > 0) {
            $sql = "SELECT id_grupo,grupo,esp_grupo,mod_grupo,tur_grupo,inicio_grupo,
            fin_grupo,obs_grupo,estado
            FROM grupo_admision
            WHERE id_grupo=$id_grupo ";
        } else {
            $sql = "SELECT id_grupo,grupo,es.abreviatura as 'esp_grupo',m.nom_confgen as 'mod_grupo',
            t.nom_confgen as 'tur_grupo',CONVERT(VARCHAR, inicio_grupo, 103) as 'inicio_grupo', 
            CONVERT(VARCHAR, fin_grupo, 103) as 'fin_grupo',e.nom_confgen as 'estado',e.color, obs_grupo
            FROM grupo_admision ga
            left join especialidad es on ga.esp_grupo = es.id_especialidad and es.estado=2
            left join configuracion_general m on ga.mod_grupo = m.id_confgen and m.id_confgen_confmae=8
            left join configuracion_general t on ga.tur_grupo = t.id_confgen and t.id_confgen_confmae=3
            left join configuracion_general e on ga.estado = e.id_confgen and e.id_confgen_confmae=9";
        }
        //echo($sql);
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grupo_fromulario($dato, $valida)
    {
        $var = '';
        if ($valida == 2) {
            $var = " and id_grupo <> '" . $dato['id_grupo'] . "' ";
        }
        $sql = "SELECT id_grupo from grupo_admision where grupo='" . $dato['grupo'] . "' and 
                esp_grupo='" . $dato['esp_grupo'] . "' and mod_grupo='" . $dato['mod_grupo'] . "' and
                tur_grupo='" . $dato['tur_grupo'] . "' $var";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function insert_c_admision($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO grupo_admision (grupo,esp_grupo,mod_grupo,tur_grupo,inicio_grupo,fin_grupo,obs_grupo,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['grupo'] . "','" . $dato['esp_grupo'] . "','" . $dato['mod_grupo'] . "','" . $dato['tur_grupo'] . "','" . $dato['inicio_grupo'] . "',
                '" . $dato['fin_grupo'] . "','" . $dato['obs_grupo'] . "','" . $dato['estado'] . "',getdate(),$id_usuario)";
        $this->db6->query($sql);
    }

    function update_c_admision($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grupo_admision 
                SET 
                grupo='" . $dato['grupo'] . "',esp_grupo='" . $dato['esp_grupo'] . "',mod_grupo='" . $dato['mod_grupo'] . "',
                tur_grupo='" . $dato['tur_grupo'] . "',inicio_grupo='" . $dato['inicio_grupo'] . "',fin_grupo='" . $dato['fin_grupo'] . "',
                obs_grupo='" . $dato['obs_grupo'] . "',estado='" . $dato['estado'] . "',
                fec_act=getdate(),user_act=$id_usuario
                WHERE id_grupo='" . $dato['id_grupo'] . "'";
        $this->db6->query($sql);
    }
    //------------------------------------INVITADOS-----------------------------------------------
    function get_list_invitado($id_invitado = null)
    {
        if (isset($id_invitado) && $id_invitado > 0) {
            $sql = "SELECT * FROM invitado WHERE id_invitado=$id_invitado";
        } else {
            $sql = "SELECT iv.id_invitado,DATE_FORMAT(iv.fecha,'%d-%m-%Y') AS fecha,iv.persona,iv.dni,iv.inst_empresa,
                    CONCAT('Invitado ',iv.invitado) AS invitado, us.usuario_codigo as user_cod
                    FROM invitado iv
                    LEFT JOIN users us ON us.id_usuario=iv.user_reg
                    WHERE iv.estado NOT IN (4)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_invitado_combo()
    {
        $sql = "SELECT CONCAT(Nombre,' ',Codigo) AS nom_invitado,Codigo
                FROM matriculados_l20 
                WHERE Tipo=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_invitado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO invitado (fecha,persona,dni,inst_empresa,invitado,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['fecha'] . "','" . $dato['persona'] . "','" . $dato['dni'] . "','" . $dato['inst_empresa'] . "',
                '" . $dato['invitado'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_invitado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE invitado SET fecha='" . $dato['fecha'] . "',persona='" . $dato['persona'] . "',dni='" . $dato['dni'] . "',
                inst_empresa='" . $dato['inst_empresa'] . "',invitado='" . $dato['invitado'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_invitado='" . $dato['id_invitado'] . "'";
        $this->db->query($sql);
    }

    function delete_invitado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE invitado SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_invitado='" . $dato['id_invitado'] . "'";
        $this->db->query($sql);
    }
    //---------------------------------------------FOTOCHECK ALUMNOS-------------------------------------------
    function get_cargo_x_id($id_usuario_de)
    {
        $sql = "SELECT * FROM (SELECT * FROM cargo where id_usuario_de=$id_usuario_de ORDER BY cod_cargo DESC LIMIT 10) AS cargo ORDER BY cod_cargo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_envio_fotocheck($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck SET fecha_envio='" . $dato['fecha_envio'] . "',
                    usuario_encomienda='" . $dato['usuario_encomienda'] . "',
                    cargo_envio='" . $dato['cargo_envio'] . "',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    function get_id_matriculado_fotocheck($id_matriculado)
    {
        $sql = "SELECT tl.*,f.foto_fotocheck_2 as foto_fotocheck_2, year(f.fecha_fotocheck) as anio_fotocheck, month(f.fecha_fotocheck) as mes_fotocheck 
        FROM todos_l20 tl
        LEFT JOIN fotocheck f ON f.Id=tl.Id
        where tl.Id=$id_matriculado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_user()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM users where id_usuario='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_fotocheck($id_fotocheck)
    {
        /*$sql = "SELECT *,CASE WHEN esta_fotocheck=1 THEN 'Foto Rec' WHEN esta_fotocheck=2 THEN 'Enviado' 
                WHEN esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN esta_fotocheck=1 THEN '#92D050' WHEN esta_fotocheck=2 THEN '#0070c0' 
                WHEN esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck, DATE_FORMAT(fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,
                DATE_FORMAT(fecha_recepcion_2, '%d/%m/%Y') as fecha_recepcion_2,DATE_FORMAT(fecha_recepcion_3, '%d/%m/%Y') as fecha_recepcion_3,
                DATE_FORMAT(fecha_envio, '%d/%m/%Y') as fecha_envio, (SELECT usuario_codigo FROM users us WHERE us.id_usuario=usuario_foto) as usuario_foto,
                DATE_FORMAT(fecha_anulado, '%d/%m/%Y') as fecha_anulado,(SELECT usuario_codigo FROM users us WHERE us.id_usuario=usuario_anulado) as usuario_anulado,
                (SELECT usuario_codigo FROM users us WHERE us.id_usuario=usuario_foto_2) as usuario_foto_2,
                (SELECT usuario_codigo FROM users us WHERE us.id_usuario=usuario_foto_3) as usuario_foto_3,
                (SELECT usuario_codigo FROM users us WHERE us.id_usuario=usuario_encomienda) as usuario_encomienda,
                (SELECT cod_cargo FROM cargo car WHERE car.id_cargo=cargo_envio) as cargo_envio,
                SUBSTRING_INDEX(foto_fotocheck,'/',-1) AS nom_foto_fotocheck,
                SUBSTRING_INDEX(foto_fotocheck_2,'/',-1) AS nom_foto_fotocheck_2,
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3
                FROM fotocheck where Id='$id_matriculado' ";*/
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
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3,
                tl.Especialidad,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,
                YEAR(fo.fecha_fotocheck) AS anio_fotocheck,MONTH(fo.fecha_fotocheck) AS mes_fotocheck,
                case when length(concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno)) > 18 then 
                concat(tl.Apellido_Paterno,' ',substring(tl.Apellido_Materno,1,1),'.')else concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno) end as apellidos,
                IF(LENGTH(tl.nombre) > 20, CONCAT(SUBSTRING(tl.nombre, 1, 20),'.'),tl.nombre) AS Nombre_corto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio
                FROM fotocheck fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN todos_l20 tl ON tl.Id=fo.Id
                WHERE fo.id_fotocheck=$id_fotocheck";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_foto_fotocheck($id_fotocheck, $op)
    {
        if ($op == 1) {
            $sql = "UPDATE fotocheck SET foto_fotocheck='',usuario_foto='',fecha_recepcion='' 
                    WHERE id_fotocheck='$id_fotocheck' ";
        } else {
            $sql = "UPDATE fotocheck SET foto_fotocheck_$op='',usuario_foto_$op='',fecha_recepcion_$op='' 
                    WHERE id_fotocheck='$id_fotocheck' ";
        }
        /*$sql='';
        $cantidad--;
        if ($op==1)    {
            $sql = "UPDATE fotocheck SET foto_fotocheck='',usuario_foto='',fecha_recepcion='',nom_foto_fotocheck='',total_subidos='$cantidad' where Id='$id_matriculado' ";
        }
        if ($op==2)    {
            $sql = "UPDATE fotocheck SET foto_fotocheck_2='',usuario_foto_2='',fecha_recepcion_2='', nom_foto_fotocheck_2='', esta_fotocheck=0,total_subidos='$cantidad' where Id='$id_matriculado' ";
        }
        if ($op==3)    {
            $sql = "UPDATE fotocheck SET foto_fotocheck_3='',usuario_foto_3='',fecha_recepcion_3='', nom_foto_fotocheck_3='',total_subidos='$cantidad' where Id='$id_matriculado' ";
        }      */
        $this->db->query($sql);
    }

    function update_foto_fotocheck($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $estado = "";
        if ($dato['n_foto'] == 1) {
            $foto_fotocheck = "foto_fotocheck";
            $usuario_foto = "usuario_foto";
            $fecha_recepcion = "fecha_recepcion";
        } else {
            if ($dato['n_foto'] == 2) {
                $estado = "esta_fotocheck=1,";
            }
            $foto_fotocheck = "foto_fotocheck_" . $dato['n_foto'];
            $usuario_foto = "usuario_foto_" . $dato['n_foto'];
            $fecha_recepcion = "fecha_recepcion_" . $dato['n_foto'];
        }
        $sql = "UPDATE fotocheck SET $foto_fotocheck='" . $dato[$foto_fotocheck] . "',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    function valida_fotocheck_completo($id_fotocheck)
    {
        $sql = "SELECT id_fotocheck FROM fotocheck 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_fotocheck_completo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    /*function insert_foto_fotocheck($id_matriculado=null,$cantidad){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $path = str_replace(' ','_',$_FILES['foto_fotocheck']['name']);
        $path2 = str_replace(' ','_',$_FILES['foto_fotocheck_2']['name']);
        $path3 = str_replace(' ','_',$_FILES['foto_fotocheck_3']['name']);


        
        
        if($path!=""){   
            $config['upload_path'] = './documento_alumno_fv/44/'.$id_matriculado;
            //$config['file_name'] = $path;
    
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_fv/', 0777);
                chmod('./documento_alumno_fv/44', 0777);
                chmod('./documento_alumno_fv/44/'.$id_matriculado, 0777);
            }  

            //$config['upload_path'] = './documento_alumno_fv/44/'.$id_matriculado;
            $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|pdf";
            $config['max_size'] = "0";
            $config['max_width'] = "0";
            $config['max_height'] = "0";
            $config['file_name'] = $path;
            $ruta = "documento_alumno_fv/44/".$id_matriculado."/".$config['file_name']; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_fotocheck')) {
                $data['uploadError'] = $this->upload->display_errors();
            }else{
                echo $this->upload->display_errors();
            }   
            if(isset($dato['total'][0]['foto_fotocheck']) && $dato['total'][0]['foto_fotocheck']!=""){
                if (file_exists($dato['total'][0]['foto_fotocheck'])) {
                    unlink($dato['total'][0]['foto_fotocheck']);
                }
            }    
        }

        if($path2!=""){    
            $config['upload_path'] = './documento_alumno_fv/31/'.$id_matriculado;
            //$config['file_name'] = $path;
    
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_fv/', 0777);
                chmod('./documento_alumno_fv/31', 0777);
                chmod('./documento_alumno_fv/31/'.$id_matriculado, 0777);
            }                      
            //$config['upload_path'] = './documento_alumno_fv/31/'.$id_matriculado;
            $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|pdf";
            $config['max_size'] = "0";
            $config['max_width'] = "0";
            $config['max_height'] = "0";
            $config['file_name'] = $path2;
            $ruta2 = "documento_alumno_fv/31/".$id_matriculado."/".$config['file_name']; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_fotocheck_2')) {
                $data['uploadError'] = $this->upload->display_errors();
            }else{
                echo $this->upload->display_errors();
            }   
            if(isset($dato['total'][0]['foto_fotocheck_2']) && $dato['total'][0]['foto_fotocheck_2']!=""){
                if (file_exists($dato['total'][0]['foto_fotocheck_2'])) {
                    unlink($dato['total'][0]['foto_fotocheck_2']);
                }
            }    
        }

        if($path3!=""){  
            $config['upload_path'] = './documento_alumno_fv/0/'.$id_matriculado;
            //$config['file_name'] = $path;
    
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_fv/', 0777);
                chmod('./documento_alumno_fv/0', 0777);
                chmod('./documento_alumno_fv/0/'.$id_matriculado, 0777);
            }              
            //$config['upload_path'] = './fotocheck_matriculadosifv/';
            $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|pdf";
            $config['max_size'] = "0";
            $config['max_width'] = "0";
            $config['max_height'] = "0";
            $config['file_name'] = $path3;
            $ruta3 = "documento_alumno_fv/0/".$id_matriculado."/".$config['file_name']; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_fotocheck_3')) {
                $data['uploadError'] = $this->upload->display_errors();
            }else{
                echo $this->upload->display_errors();
            }   
            if(isset($dato['total'][0]['foto_fotocheck_3']) && $dato['total'][0]['foto_fotocheck_3']!=""){
                if (file_exists($dato['total'][0]['foto_fotocheck_3'])) {
                    unlink($dato['total'][0]['foto_fotocheck_3']);
                }
            }    
        }
        $estado="";
        $doc="";
        $nom="";
        $doc2="";
        $nom2="";
        $doc3="";
        $nom3="";
        $d00i="";
        $d00v="";
        $d01i="";
        $d01v="";
        $d01fi="";
        $d01fv="";    
        $cantidad1=0;    
        $cantidad2=0;
        $cantidad3=0;
        if ($path!=""){
            $doc="foto_fotocheck='".$ruta."',fecha_recepcion=NOW(),usuario_foto=$id_usuario,";
            $partes=explode("/", $ruta);
            $nom="nom_foto_fotocheck='".$partes[3]."',";
            $d00i="archivo,";
            $d00v="'".$ruta."',";
            $sql2 = "INSERT INTO detalle_alumno_empresa ($d00i id_alumno,id_empresa,cod_documento,nom_documento,user_subido,fec_subido,estado,user_reg,fec_reg) 
                    VALUES ($d00v $id_matriculado,6,'D00','Foto Sistema',$id_usuario,NOW(),2,$id_usuario,NOW())";
            $this->db->query($sql2);   
            $cantidad1=1;       
        }
        if($path2!=""){
            $doc2="foto_fotocheck_2='".$ruta2."',fecha_recepcion_2=NOW(),usuario_foto_2=$id_usuario,";
            $partes=explode("/", $ruta2);
            $nom2="nom_foto_fotocheck_2='".$partes[3]."',";
            $d01i="archivo,";
            $d01v="'".$ruta2."',";
            $estado="esta_fotocheck=1,";
            
            $sql3 = "INSERT INTO detalle_alumno_empresa ($d01i id_alumno,id_empresa,cod_documento,nom_documento,user_subido,fec_subido,estado,user_reg,fec_reg) 
                    VALUES ($d01v $id_matriculado,6,'D01','Foto Fotocheck',$id_usuario,NOW(),2,$id_usuario,NOW())";   
            $this->db->query($sql3);   
            $cantidad2=1; 
            
        }
        if($path3!=""){
            $doc3="foto_fotocheck_3='".$ruta3."',fecha_recepcion_3=NOW(),usuario_foto_3=$id_usuario,";
            $partes=explode("/", $ruta3);
            $nom3="nom_foto_fotocheck_3='".$partes[3]."',";
            $d01fi="archivo,";
            $d01fv="'".$ruta3."',";
            $sql4 = "INSERT INTO detalle_alumno_empresa ($d01fi id_alumno,id_empresa,cod_documento,nom_documento,user_subido,fec_subido,estado,user_reg,fec_reg) 
                    VALUES ($d01fv $id_matriculado,6,'D01','Foto (con Fecha)',$id_usuario,NOW(),2,$id_usuario,NOW())";
            $this->db->query($sql4); 
            $cantidad3=1; 
        }
        $cantidad_total=$cantidad1+$cantidad2+$cantidad3;
        $cantidad+=$cantidad_total;
        $cargas_completas="";
        if ($cantidad=3){ 
            $cargas_completas="fecha_fotocheck=NOW(),";
        }

        $data['uploadSuccess'] = $this->upload->data();
        $sql = "UPDATE fotocheck SET $doc $doc2 $doc3 $nom $nom2 $nom3 $estado $cargas_completas total_subidos=$cantidad, fec_act=NOW(),
                user_act=$id_usuario WHERE Id='".$id_matriculado."'";                
        $this->db->query($sql);
    }*/

    /*function update_foto_fotocheck($id_matriculado=null,$data){
        $foto_fotocheck="";
        $usuario_foto="";
        $fecha_recepcion="";
        if ($data['op']==1){
            $foto_fotocheck="foto_fotocheck";
            $usuario_foto="usuario_foto";
            $fecha_recepcion="fecha_recepcion";
        }
        if ($data['op']==2){
            $foto_fotocheck="foto_fotocheck_2";
            $usuario_foto="usuario_foto_2";
            $fecha_recepcion="fecha_recepcion_2";
        }
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck SET $foto_fotocheck='".$data['archivo']."',$usuario_foto='".$data['user_subido']."',$fecha_recepcion='".$data['fec_subido']."',esta_fotocheck=1,fec_act=NOW(),
                user_act=$id_usuario WHERE Id='".$id_matriculado."'";
     
        $this->db->query($sql);
    }*/

    function anular_envio($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck SET esta_fotocheck=3,obs_anulado='" . $dato['obs_anulado'] . "',usuario_anulado=$id_usuario,fecha_anulado=NOW(),user_act=$id_usuario 
        WHERE Id='" . $dato['id_matriculado'] . "'";

        $this->db->query($sql);
    }

    function impresion_fotocheck($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    function get_fotocheck_tmp2()
    {
        $sql = "SELECT * FROM tmp2_fotocheck t2 LEFT JOIN todos_l20 tl on tl.Id=t2.Id";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //---------------------------------------------DOC ALUMNOS-------------------------------------------
    /*function get_list_todos_alumno($tipo){
        $parte = "";
        if($tipo==0){$parte = "AND Grupo IN (SELECT grupo FROM grupo_admision WHERE estado=1) AND 
            Matricula IN ('Asistiendo','Promovido') ";}
        if($tipo==1){
            $parte = "AND Grupo IN (SELECT grupo FROM grupo_admision WHERE estado=1) AND 
                    Matricula IN ('Asistiendo','Promovido') AND Fotocheck>0";
        }
        if($tipo==2){$parte = "";}
            $sql= "WITH FotocheckData AS (
                SELECT
                    de.id_alumno,
                    COUNT(*) AS fotocheck_count,
                    MAX(de.archivo) AS archivo_foto
                FROM
                    detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento = de.id_documento
                WHERE
                    da.id_empresa = 6
                    AND da.cod_documento = 'D00'
                    AND de.archivo != ''
                    AND de.estado = 2
                GROUP BY
                    de.id_alumno
            )
            SELECT
                tl.id_matriculado,
                tl.Id,
                tl.Apellido_Paterno,
                tl.Apellido_Materno,
                tl.Nombre,
                tl.Codigo,
                tl.Grupo,
                tl.Turno,
                tl.Modulo,
                tl.Seccion,
                tl.Matricula,
                tl.Alumno,
                tl.Documento_Pendiente,
                tl.Especialidad,
                DATE_FORMAT(tl.Fecha_Cumpleanos, '%d/%m/%Y') AS fecha_nacimiento,
                TIMESTAMPDIFF(YEAR, tl.Fecha_Cumpleanos, CURDATE()) AS edad,
                es.abreviatura,
                CASE
                    se.sexo
                    WHEN 1 THEN 'Femenino'
                    WHEN 2 THEN 'Masculino'
                    ELSE 'Desconocido'
                END AS sexo,
                CASE
                    WHEN tl.Pago_Pendiente = 0 THEN 'Al Día'
                    WHEN tl.Pago_Pendiente = 1 THEN 'Pendiente 1'
                    WHEN tl.Pago_Pendiente = 2 THEN 'Pendiente 2'
                    ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,
                CASE
                    WHEN tl.Pago_Pendiente = 0 THEN '#92D050'
                    WHEN tl.Pago_Pendiente = 1 THEN '#7F7F7F'
                    WHEN tl.Pago_Pendiente = 2 THEN '#F8CBAD'
                    ELSE '#C00000'
                END AS color_pago_pendiente,
                CASE
                    WHEN tl.Fotocheck > 0 THEN 'Si'
                    ELSE 'No'
                END AS v_fotocheck,
                CASE
                    WHEN fd.fotocheck_count > 0 THEN 'Si'
                    ELSE 'No'
                END AS foto,
                fd.id_alumno AS id_foto,
                fd.archivo_foto AS link_foto,
                tl.Celular,
                tl.Email,
                tl.Id,
                cpv.institucion,
                dp.nombre_departamento,
                pp.nombre_provincia,
                dv.nombre_distrito
            FROM
                todos_l20 tl
                LEFT JOIN FotocheckData fd ON tl.Id = fd.id_alumno
                LEFT JOIN especialidad es ON tl.Especialidad = es.nom_especialidad
                AND es.estado = 2
                LEFT JOIN sexo_empresa se ON tl.Id = se.id_alumno
                LEFT JOIN colegio_prov_empresa cp ON tl.Id = cp.id_alumno
                LEFT JOIN colegio_prov cpv ON cp.id_colegio_prov = cpv.id
                LEFT JOIN departamento dp ON cpv.departamento = dp.id_departamento
                LEFT JOIN provincia pp ON cpv.provincia = pp.id_provincia
                LEFT JOIN distrito dv ON cpv.distrito = dv.id_distrito
            WHERE
                tl.Alumno = 'Matriculado' $parte
            ORDER BY
                tl.Grupo ASC,
                tl.Turno ASC,
                tl.Modulo ASC,
                tl.Seccion ASC,
                tl.Apellido_Paterno ASC,
                tl.Apellido_Materno ASC,
                tl.Nombre ASC
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }*/
    function get_list_todos_alumno()
    {
        $sql = "SELECT a.Apellido_Paterno,a.Apellido_Materno,a.Nombre,a.Codigo,a.Especialidad,a.Grupo,
                a.Turno,a.Modulo,
                ciclo_fv(a.Grupo,a.Especialidad,a.Modulo,a.Seccion) AS Ciclo,a.Seccion,a.Matricula,
                a.Alumno,'' AS documentos_obligatorios,'' AS documentos_subidos,
                CASE WHEN (foto_fv(a.Id))>0 THEN 'Si' ELSE 'No' END AS foto,
                FLOOR(DATEDIFF(CURDATE(), a.Fecha_Cumpleanos) / 365) AS edad,
                a.Dni,a.Fecha_Cumpleanos,'' AS link_foto
                FROM todos_l20 a
                WHERE a.Tipo=1 AND a.Matricula='Asistiendo' AND a.Alumno='Matriculado'";

        /*$sql = "SELECT a.Apellido_Paterno,a.Apellido_Materno,a.Nombre,a.Codigo,a.Especialidad,a.Grupo,
                a.Turno,a.Modulo,
                ciclo_fv(a.Grupo,a.Especialidad,a.Modulo,a.Seccion) AS Ciclo,a.Seccion,a.Matricula,
                a.Alumno,'' AS documentos_obligatorios,'' AS documentos_subidos,
                CASE WHEN (foto_fv(a.Id))>0 THEN 'Si' ELSE 'No' END AS foto,
                FLOOR(DATEDIFF(CURDATE(), a.Fecha_Cumpleanos) / 365) AS edad,
                a.Dni,a.Fecha_Cumpleanos,'' AS link_foto,c.grupo as desc_grupo
                FROM todos_l20 a
                left join alumno_grupo b on a.Id=b.id_alumno and b.estado=2
                left join grupo_calendarizacion c on b.id_grupo=c.id_grupo
                WHERE a.Tipo=1 AND a.Matricula='Asistiendo' AND a.Alumno='Matriculado'";*/

        /*$sql = "SELECT a.id,a.apellido_paterno AS Apellido_Paterno,a.apellido_materno AS Apellido_Materno,
        a.nombres AS Nombre,a.dni AS Dni,a.codigo AS Codigo,a.matricula AS Matricula,
        a.alumno AS Alumno,
        documentos_obligatorios_fv(c.nom_especialidad) AS documentos_obligatorios,
        documentos_subidos_fv(c.nom_especialidad,a.id_alumno) AS documentos_subidos,
        c.nom_especialidad as Especialidad,b.grupo as Grupo,e.nom_turno as Turno,f.modulo as Modulo,
        g.ciclo as Ciclo,b.id_seccion as Seccion, a.fecha_cumpleanos,
        FLOOR(DATEDIFF(CURDATE(), a.fecha_cumpleanos) / 365) AS edad,
        CASE WHEN (foto_fv(a.id_alumno))>0 THEN 'Si' ELSE 'No' END AS foto,'' AS link_foto,'' as Dni

        FROM alumno_grupo a
        left join grupo_calendarizacion b on a.id_grupo=b.id_grupo
        left join especialidad c on b.id_especialidad=c.id_especialidad
        left join turno d on b.id_turno=d.id_turno
        left join hora e on d.id_hora=e.id_hora
        left join modulo f on b.id_modulo=f.id_modulo
        left join ciclo g on b.id_ciclo=g.id_ciclo
        ORDER BY a.apellido_paterno ASC,a.apellido_materno ASC,a.nombres ASC";*/

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------------ALUMNOS OBS-------------------------------------------
    function get_list_alumno_obs()
    {
        $sql = "SELECT tl2.Apellido_Paterno,tl2.Apellido_Materno,tl2.Nombre,tl2.Codigo,e.nom_empresa,
                DATE_FORMAT(aog.fec_reg, '%d-%m-%Y') AS fecha_registro,aog.observacion AS Comentario,
                u.usuario_codigo,aog.id_empresa,tl2.Especialidad,tl2.Grupo
                FROM alumno_observaciones_general aog
                LEFT JOIN todos_l20 tl2 ON tl2.Id=aog.id_alumno
                LEFT JOIN empresa e ON e.id_empresa=aog.id_empresa
                LEFT JOIN users u ON u.id_usuario=aog.user_reg
                WHERE aog.id_empresa = 6 AND aog.estado = 2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_pendiente_fotocheck()
    {
        $sql = "SELECT * FROM todos_l20 tl
                WHERE tl.tipo=1 AND tl.Grupo IN (SELECT gc.grupo FROM grupo_calendarizacion gc WHERE gc.estado=2 GROUP BY gc.grupo) AND tl.Fotocheck=0 
                AND tl.Matricula IN ('Asistiendo','Promovido') AND tl.Alumno='Matriculado' 
                AND tl.Especialidad IN (SELECT es.nom_especialidad FROM especialidad es WHERE es.estado=2)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_fotocheck($tipo)
    {
        $parte = "AND f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if ($tipo == 1) {
            $parte = "AND f.esta_fotocheck NOT IN (2,3,99)";
        }
        $sql = "SELECT f.*,DATE_FORMAT(f.Fecha_Pago_Fotocheck, '%d/%m/%Y') as Pago_Fotocheck,tl.Id,
                tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,tl.Grupo,tl.Turno,tl.Modulo,
                tl.Seccion,tl.Matricula,tl.Alumno,DATE_FORMAT(f.fecha_envio, '%d/%m/%Y') as fecha_envio,
                f.usuario_encomienda,f.cargo_envio,
                DATE_FORMAT(f.fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,f.usuario_foto,
                (SELECT es.abreviatura FROM especialidad es 
                WHERE tl.Especialidad=es.nom_especialidad AND es.estado=2) as abreviatura,
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
                FROM fotocheck f
                LEFT JOIN todos_l20 tl ON f.Id=tl.Id
                WHERE tl.Alumno='Matriculado' $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_documento_alumno($cod_documento)
    {
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                WHERE id_empresa=6 AND cod_documento='$cod_documento' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_detalle_alumno_empresa($id_alumno, $id_documento)
    {
        $sql = "SELECT id_detalle FROM detalle_alumno_empresa 
                WHERE id_alumno=$id_alumno AND id_documento=$id_documento AND estado=2
                ORDER BY id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_fecha_fotocheck($id_matriculado)
    {
        $sql = "UPDATE fotocheck SET fecha_fotocheck=NOW() WHERE Id=$id_matriculado";
        $this->db->query($sql);
    }

    function get_list_archivos_fotocheck($id_matriculado, $tipo)
    {
        $parte = "";
        if ($tipo = 0) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND archivo!='' AND (de.cod_documento='D01' AND d.nom_documento='Foto Fotocheck') OR de.cod_documento='D00' OR (de.cod_documento='D01' AND d.nom_documento='Foto (con Fecha)' ";
        }
        if ($tipo == 1) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.id_documento=44 AND archivo!=''";
        }
        if ($tipo == 2) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.id_documento=31 AND archivo!=''";
        }
        if ($tipo == 3) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.id_documento=44 
            ORDER BY de.fec_subido ASC LIMIT 1";
        }
        if ($tipo == 4) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.id_documento=31
            ORDER BY de.fec_subido ASC LIMIT 1";
        }
        if ($tipo == 5) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.cod_documento='D01' AND de.id_documento=0 ";
        }
        if ($tipo == 6) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.cod_documento='D01' AND de.id_documento=0 AND de.archivo!='' ";
        }
        if ($tipo == 7) {
            $parte = "AND Matricula IN ('Asistiendo','Promovido') AND de.id_documento=0 AND de.cod_documento='D01'
            ORDER BY de.fec_subido ASC LIMIT 1";
        }
        $sql = "SELECT DATE_FORMAT(f.Fecha_Pago_Fotocheck, '%d/%m/%Y') as Fecha_Pago_Fotocheck,tl.Id,de.fec_subido,de.user_subido,
                DATE_FORMAT(f.fecha_envio, '%d/%m/%Y') as fecha_envio,f.usuario_encomienda,f.cargo_envio,
                DATE_FORMAT(f.fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,f.usuario_foto,do.nom_documento,de.archivo,
                (SELECT us.usuario_codigo FROM users us WHERE f.usuario_encomienda=us.id_usuario) as usuario_codigo,
                (SELECT us.usuario_codigo FROM users us WHERE f.usuario_foto=us.id_usuario) as usuario_foto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=f.cargo_envio) as cargo_envio
                FROM todos_l20 tl  
                LEFT JOIN fotocheck f ON tl.Id=f.Id                
                LEFT JOIN detalle_alumno_empresa de ON f.Id=de.id_alumno AND de.estado=2
                LEFT JOIN documento_alumno_empresa do ON do.id_documento=de.id_documento 
                WHERE Alumno='Matriculado' AND de.id_alumno=$id_matriculado AND de.id_empresa=6 $parte
                ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_doc_alumnos()
    {
        $sql = "SELECT id_documento,cod_documento FROM documento_alumno_empresa
                WHERE id_empresa=6 AND estado!=4
                ORDER BY cod_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_all_detalle_doc_alumnos()
    {
        $sql = "SELECT
        us.usuario_codigo,
        da.fec_subido,
        da.id_alumno as Id,
        da.cod_documento as cod_documento
        FROM
            detalle_alumno_empresa da
            LEFT JOIN users us ON us.id_usuario = da.user_subido
        WHERE
        da.estado = 2
        AND da.cod_documento IS NOT NULL";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_doc_alumnos($id_alumno, $id_documento)
    {
        $sql = "SELECT us.usuario_codigo,da.fec_subido
                FROM detalle_alumno_empresa da
                LEFT JOIN users us ON us.id_usuario=da.user_subido
                WHERE da.id_alumno=$id_alumno AND da.id_documento='$id_documento' AND da.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_actualizar_envio($dato)
    {
        $sql = "SELECT * FROM alumnos_arpay where estado=2 ";
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
    //-----------------------------------------------SOPORTE DOCS------------------------------------------
    function get_list_soporte_doc($id_soporte_doc = null)
    {
        if (isset($id_soporte_doc) && $id_soporte_doc > 0) {
            $sql = "SELECT * FROM soporte_doc WHERE id_soporte_doc=$id_soporte_doc";
        } else {
            $sql = "SELECT so.id_soporte_doc,em.cod_empresa,so.descripcion,SUBSTRING_INDEX(so.documento,'/',-1) AS nom_documento,
                    CASE WHEN so.documento!='' THEN CONCAT('" . base_url() . "',SUBSTRING_INDEX(so.documento,'/',-1)) ELSE '' END AS link,
                    CASE WHEN so.documento!='' THEN CONCAT('" . base_url() . "',so.documento) ELSE '' END AS href,us.usuario_codigo,
                    DATE_FORMAT(so.fec_act,'%d-%m-%Y') AS fecha,CASE WHEN so.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    CASE WHEN so.visible=1 THEN 'Si' ELSE 'No' END AS visible,st.nom_status,so.documento
                    FROM soporte_doc so
                    LEFT JOIN empresa em ON em.id_empresa=so.id_empresa
                    LEFT JOIN users us ON us.id_usuario=so.user_act
                    LEFT JOIN status st ON st.id_status=so.estado
                    WHERE so.id_empresa=6 AND so.estado!=4
                    ORDER BY em.cod_empresa ASC,so.descripcion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_documento_recibido($t)
    {
        if ($t == 1) {
            $sql = "SELECT d.*,concat(t.Apellido_Paterno,' ',t.Apellido_Materno,' ',t.Nombre) as alumno,d.Especialidad,
            case 
            when d.estado=2 then 'Recibido' end as desc_estado,
            date_format(d.fec_reg,'%d/%m/%Y') as fecha_registro,
            date_format(d.fec_act,'%d/%m/%Y') as fecha_actualizacion,u.usuario_codigo,
            case when d.id_motivo=1 then 'Documento Ilegible'
            when d.id_motivo=2 then 'Documento Incompleto'
            when d.id_motivo=3 then 'Otros' end as desc_motivo
            FROM todos_l20_doc_cargado d 
            left join todos_l20 t on d.Dni=t.Dni and d.Codigo=t.Codigo and t.Tipo=1              
            left join users u on d.user_act=u.id_usuario
            WHERE d.estado=2 and d.id_empresa=6";
        } else {
            $sql = "SELECT d.*,concat(t.Apellido_Paterno,' ',t.Apellido_Materno,' ',t.Nombre) as alumno,d.Especialidad,
            case 
            when d.estado=2 then 'Recibido'
            when d.estado=3 then 'Anulado'
            when d.estado=4 then 'Tramitado' end as desc_estado,
            date_format(d.fec_reg,'%d/%m/%Y') as fecha_registro,
            date_format(d.fec_act,'%d/%m/%Y') as fecha_actualizacion,u.usuario_codigo,
            case when d.id_motivo=1 then 'Documento Ilegible'
            when d.id_motivo=2 then 'Documento Incompleto'
            when d.id_motivo=3 then 'Otros' end as desc_motivo
            FROM todos_l20_doc_cargado d
            left join todos_l20 t on d.Dni=t.Dni and d.Codigo=t.Codigo and t.Tipo=1
            left join users u on d.user_act=u.id_usuario
            WHERE d.estado in (2,3,4) and d.id_empresa=6";
        }

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_documento_recibido($id_doc_cargado)
    {
        $sql = "SELECT * FROM todos_l20_doc_cargado WHERE id_doc_cargado=$id_doc_cargado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_documento_cargado($dato)
    {
        $fecha = date('Y-m-d H:i:s');
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE todos_l20_doc_cargado SET estado='" . $dato['estado'] . "',id_motivo='" . $dato['id_motivo'] . "',user_act='" . $id_usuario . "',fec_act='$fecha' WHERE id_doc_cargado='" . $dato['id_doc_cargado'] . "'";
        $this->db->query($sql);
    }

    function update_documento_cargado_anular($dato)
    {
        $fecha = date('Y-m-d H:i:s');
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE todos_l20_doc_cargado SET estado='3',id_motivo='" . $dato['id_motivo'] . "',user_act='" . $id_usuario . "',fec_act='$fecha' WHERE id_doc_cargado='" . $dato['id_doc_cargado'] . "'";
        $this->db->query($sql);
    }

    function get_config($descrip_config)
    {
        $sql = "SELECT * from config where descrip_config='$descrip_config'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------------POSTULANTES EFSRT-------------------------------------------
    function list_resultado_examen_postulantes_Efsrt_activos()
    {
        $sql = "SELECT r.id_postulante,DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,r.fec_termino,r.tiempo_ini,
                r.puntaje,round((r.puntaje)) as puntaje_arpay,
                DATE_FORMAT(r.fec_termino,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,
                TIMEDIFF(r.fec_termino, r.tiempo_ini) as minutos_t,concat(r.id_postulante,'-',r.id_examen,'-',r.fec_examen) as cadena
                FROM resultado_examen_efsrt_ifv r where r.estado in (31,33)";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_list_postulantes_efsrt_activos()
    {
        $sql = "SELECT p.id_postulante,p.codigo,p.grupo,c.nom_especialidad AS nom_carrera,p.nr_documento,
                c.abreviatura,CONCAT(p.apellido_pat,' ',p.apellido_mat,' ',p.nombres) AS nom_alumno,
                CASE WHEN p.fec_inscripcion='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') END AS fecha_inscripcion,
                p.email,p.celular,s.color AS col_status,s.nom_status,
                CASE WHEN p.fec_envio='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_envio,'%d/%m/%Y') END AS fecha_envio,
                p.estado AS estado_postulante,p.apellido_pat,p.apellido_mat,p.nombres,p.id_examen,
                concat(p.id_postulante,'-',p.id_examen,'-',p.fec_examen) as cadena,p.observaciones
                FROM postulantes_efsrt p
                LEFT JOIN especialidad c on c.id_especialidad=p.id_carrera
                LEFT JOIN status_general s on s.id_status_general=p.estado
                WHERE p.estado IN (29,30,56)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_postulantes_efsrt_terminado()
    {
        $sql = "SELECT p.id_postulante,p.codigo,p.grupo,c.nom_especialidad AS nom_carrera,p.nr_documento,
                c.abreviatura,p.apellido_pat,p.apellido_mat,p.nombres,
                CONCAT(p.apellido_pat,' ',p.apellido_mat,' ',p.nombres) AS nom_alumno,
                CASE WHEN p.fec_inscripcion='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') END AS fecha_inscripcion,
                p.email,p.celular,s.color AS col_status,s.nom_status,
                CASE WHEN p.fec_envio='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_envio,'%d/%m/%Y') END AS fecha_envio,
                p.estado AS estado_postulante,p.id_examen,
                concat(p.id_postulante,'-',p.id_examen,'-',p.fec_examen) as cadena,p.observaciones
                FROM postulantes_efsrt p
                LEFT JOIN especialidad c on c.id_especialidad=p.id_carrera
                LEFT JOIN status_general s on s.id_status_general=p.estado
                WHERE p.estado=31";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_postulantes_efsrt_todos()
    {
        $sql = "SELECT p.id_postulante,p.codigo,p.grupo,c.nom_especialidad AS nom_carrera,p.nr_documento,
                c.abreviatura,p.apellido_pat,p.apellido_mat,p.nombres,
                CONCAT(p.apellido_pat,' ',p.apellido_mat,' ',p.nombres) AS nom_alumno,
                CASE WHEN p.fec_inscripcion='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_inscripcion,'%d/%m/%Y') END AS fecha_inscripcion,
                p.email,p.celular,s.color AS col_status,s.nom_status,
                CASE WHEN p.fec_envio='0000-00-00 00:00:00' THEN '' 
                ELSE DATE_FORMAT(p.fec_envio,'%d/%m/%Y') END AS fecha_envio,
                p.estado AS estado_postulante,p.id_examen,
                concat(p.id_postulante,'-',p.id_examen,'-',p.fec_examen) as cadena,p.observaciones
                FROM postulantes_efsrt p
                LEFT JOIN especialidad c on c.id_especialidad=p.id_carrera
                LEFT JOIN status_general s on s.id_status_general=p.estado
                WHERE p.estado IN (29,30,31,32,33,56,4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_cod_postulante_efsrt($dato)
    {
        $sql = "SELECT * FROM postulantes_efsrt
                WHERE codigo='" . $dato['codigo'] . "' AND estado IN (29,30,31,32,33) ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_cod_postulante_efsrt_preguardar($dato)
    {
        $sql = "SELECT * FROM postulantes_efsrt_preguardar 
                WHERE codigo='" . $dato['codigo'] . "' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_lista_postulantes_efsrt_temporal($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulantes_efsrt_temporal (tipo_error,codigo,interese,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,user_reg)
                values ( '" . $dato['tipo_error'] . "','" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "','$id_usuario')";

        $this->db->query($sql);
    }

    function insert_lista_postulantes_efsrt_preguardar($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulantes_efsrt_preguardar (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado,user_reg, fec_reg)
                values ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['id_carrera'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "',29,'$id_usuario',NOW())";

        $this->db->query($sql);
    }

    function valida_lista_postulante_efsrt_temporal_general()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_efsrt_temporal where user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_lista_postulante_efsrt_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_efsrt_temporal where tipo_error='1' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_postulante_efsrt_email_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_efsrt_temporal where tipo_error='2' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_postulante_efsrt_num_cod_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * from postulantes_efsrt_temporal where tipo_error='3' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_postulante_efsrt_nom_carrera()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM postulantes_efsrt_temporal where tipo_error='4' and user_reg='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function limpiar_postulante_efsrt_temporal()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM postulantes_efsrt_temporal where user_reg='$id_usuario'";
        $sql2 = "DELETE FROM postulantes_preguardar where user_reg='$id_usuario'";
        $this->db->query($sql);
        $this->db->query($sql2);
    }

    function insert_select_postulantes_efsrt_preguardar()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulantes_efsrt (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado, fec_reg)
                SELECT codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,'29',NOW() 
                FROM postulantes_efsrt_preguardar 
                WHERE user_reg='$id_usuario'";
        $this->db->query($sql);
    }

    function insert_lista_postulantes_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulantes_efsrt (codigo,interese,id_carrera,nr_documento,apellido_pat,apellido_mat,nombres,fec_inscripcion,email,grupo,celular,estado, fec_reg)
                VALUES ( '" . $dato['codigo'] . "', '" . $dato['interese'] . "','" . $dato['id_carrera'] . "','" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "', 
                '" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "', '" . $dato['fec_inscripcion'] . "','" . $dato['email'] . "','" . $dato['grupo'] . "','" . $dato['celular'] . "',29,NOW() )";
        $this->db->query($sql);
    }

    function get_id_postulante_efsrt($id_postulante)
    {
        $sql = "SELECT a.*,DATE_FORMAT(a.fec_inscripcion,'%Y-%m-%d') AS fecha_inscripcion,b.Id
                FROM postulantes_efsrt a
                left join todos_l20 b on a.codigo=b.Codigo
                WHERE a.id_postulante=$id_postulante";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_envio_invitacion_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE postulantes_efsrt SET estado=1 where codigo='" . $dato['codigo'] . "' and estado!='1'";
        $this->db->query($sql);

        $sql = "INSERT INTO postulantes_efsrt (id_examen,fec_examen,fec_envio,hora_inicio,estado,interese,id_carrera,codigo,nr_documento,
        apellido_pat,apellido_mat,nombres,grupo,email,celular) 
        VALUES('" . $dato['id_examen'] . "','" . $dato['fecha_examen2'] . "',NOW(),'" . $dato['hora_inicio'] . "',30,'" . $dato['carrera'] . "','" . $dato['id_carrera'] . "','" . $dato['codigo'] . "',
        '" . $dato['nr_documento'] . "','" . $dato['apellido_pat'] . "','" . $dato['apellido_mat'] . "','" . $dato['nombres'] . "','" . $dato['grupo'] . "','" . $dato['email'] . "','" . $dato['celular'] . "')";
        $this->db->query($sql);

        //$sql = "DELETE FROM historial_examen_efsrt_ifv WHERE id_postulante='".$dato['codigo']."'";
        //$this->db4->query($sql);

        $sql = "UPDATE resultado_examen_efsrt_ifv SET estado=1 WHERE cod_postulante='" . $dato['codigo'] . "' and estado!='1' and id_examen='" . $dato['id_examen'] . "'
        and fec_examen='" . $dato['fecha_examen2'] . "'";
        $this->db4->query($sql);

        $sql = "DELETE FROM pregunta_exonerada_efsrt WHERE id_postulante='" . $dato['codigo'] . "'";
        $this->db4->query($sql);

        $sql = "UPDATE pos_exam_efsrt SET estado_pe=1 where idpos_pe='" . $dato['codigo'] . "' and idexa_pe='" . $dato['id_examen'] . "' 
        and fec_examen='" . $dato['fecha_examen2'] . "' and estado_pe!=1";
        $this->db4->query($sql);

        $sql = "INSERT INTO pos_exam_efsrt (idpos_pe,idexa_pe,fec_examen,hora_inicio, hora_final,estado_pe,fec_reg,user_reg) 
                VALUES ('" . $dato['codigo'] . "','" . $dato['id_examen'] . "','" . $dato['fecha_examen2'] . "','" . $dato['hora_inicio'] . "',ADDTIME('" . $dato['hora_inicio'] . ':00' . "', '00:30:00'),30,NOW(),'$id_usuario')";
        $this->db4->query($sql);
    }

    function get_id_postulante_resultado_examen_efsrt($id_postulante)
    {
        $sql = "SELECT * FROM resultado_examen_efsrt_ifv 
                WHERE id_postulante=$id_postulante AND estado=2 ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_examen_efsrt_activo()
    {
        $hoy = date('Y-m-d');
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%d/%m/%Y') AS fecha_limite,DATE_FORMAT(e.fec_resultados, '%d/%m/%Y') AS fecha_resultados,
                DATE_FORMAT(e.fec_limite, '%Y-%m-%d') AS fec_limite2,
                (SELECT group_concat(distinct p.id_carrera) FROM examen_carrera_efsrt_ifv p WHERE p.id_examen=e.id_examen and p.estado=2) as examen_carrera
                FROM examen_efsrt_ifv e
                WHERE e.estado=2 AND e.estado_contenido=1 and DATE_FORMAT(e.fec_limite, '%Y-%m-%d')='$hoy' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_update_postulante_efsrt($dato)
    {
        $sql = "SELECT * FROM postulantes_efsrt 
                WHERE nr_documento ='" . $dato['nr_documento'] . "' AND estado IN (29,30,31,32,33,56) AND id_postulante<>'" . $dato['id_postulante'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_postulante_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        /*$sql = "UPDATE postulantes_efsrt SET nr_documento='".$dato['nr_documento']."',celular='".$dato['celular']."',nombres='".$dato['nombres']."',
                apellido_pat='".$dato['apellido_pat']."',apellido_mat='".$dato['apellido_mat']."',email='".$dato['email']."',
                fec_inscripcion='".$dato['fec_inscripcion']."',interese='".$dato['interese']."',id_carrera='".$dato['id_carrera']."',
                grupo='".$dato['grupo']."',estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_postulante='".$dato['id_postulante']."'";*/
        $sql = "UPDATE postulantes_efsrt SET email='" . $dato['email'] . "',
                hora_inicio='" . $dato['hora_inicio'] . "',estado='" . $dato['estado'] . "',
                observaciones='" . $dato['observaciones'] . "',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_postulante='" . $dato['id_postulante'] . "'";
        $this->db->query($sql);
    }
    //--------------------------------------------------------EXAMEN EFSRT--------------------------------------
    function actu_estado_examen_efsrt_ifv()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE examen_efsrt_ifv SET estado=3,fec_act=NOW(),user_act=$id_usuario
                WHERE fec_limite <= CURDATE() AND estado=2 AND estado_contenido=1";
        $this->db->query($sql);
    }

    function get_list_examen_efsrt_ifv()
    {
        $sql = "SELECT count(e.id_examen) AS cantidad,e.*,DATE_FORMAT(e.fec_limite,'%d/%m/%Y') AS fecha_limite,
                DATE_FORMAT(e.fec_resultados,'%d/%m/%Y') AS fecha_resultados,
                case when e.estado=2 then 'Activo' when e.estado=3 then 'Inactivo' end as nom_status
                FROM examen_efsrt_ifv e 
                LEFT JOIN pregunta_admision_efsrt p on p.id_examen=e.id_examen AND p.estado=2
                WHERE e.estado in (2,3)
                GROUP BY e.id_examen";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_list_examen_efsrt_ifv2($parametro)
    {
        $estado = " e.estado in (2,3)";
        if ($parametro == 1) {
            $estado = " e.estado in (2)";
        }
        $sql = "SELECT count(e.id_examen) AS cantidad,e.id_examen,e.nom_examen,e.fec_limite,
                DATE_FORMAT(e.fec_limite,'%d/%m/%Y') as fecha_limite,
                DATE_FORMAT(e.fec_resultados,'%d/%m/%Y') as fecha_resultados,
                (select count(*) from pos_exam_efsrt pe 
                where e.id_examen=pe.idexa_pe and pe.estado_pe<>1 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d')) as 'Enviados',
                (select count(*) from pos_exam_efsrt pe 
                where e.id_examen=pe.idexa_pe and pe.estado_pe=30 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d')) as 'Sin Iniciar',
                (select count(*) from pos_exam_efsrt pe 
                where e.id_examen=pe.idexa_pe and pe.estado_pe=33 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d')) as 'Sin Concluir',
                (select count(*) from pos_exam_efsrt pe 
                where e.id_examen=pe.idexa_pe and pe.estado_pe=31 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d')) as 'Concluido',
                round((select sum(pe.puntaje) from resultado_examen_efsrt_ifv pe 
                where e.id_examen=pe.id_examen and pe.estado=31 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d'))/(select count(*) 
                from resultado_examen_efsrt_ifv pe 
                where e.id_examen=pe.id_examen and pe.estado=31 and 
                pe.fec_examen=DATE_FORMAT(e.fec_limite,'%Y-%m-%d'))) as promedio,
                case when e.estado=2 then 'Activo' when e.estado=3 then 'Inactivo' end as nom_status,
                e.estado_contenido,case when e.estado_contenido=1 then 'Completado' 
                when e.estado_contenido=0 then 'Incompleto' end as desc_estado_contenido
                FROM examen_efsrt_ifv e
                where $estado
                group by e.id_examen ORDER BY e.fec_limite DESC";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_list_examen_efsrt_ifv3()
    {
        $sql = "SELECT re.id_examen,SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(re.fec_termino,tiempo_ini)))/count(pe.id_pe)) as Tiempo 
                ,sum(re.puntaje)/count(pe.id_pe) as Evaluacion
                FROM resultado_examen_efsrt_ifv re
                LEFT JOIN pos_exam_efsrt pe on re.id_examen = pe.idexa_pe and estado_pe=31
                where estado = 31
                group by id_examen";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function insert_examen_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO examen_efsrt_ifv (cod_examen,nom_examen,fec_limite,fec_resultados,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['cod_examen'] . "','" . $dato['nom_examen'] . "','" . $dato['fec_limite'] . "','" . $dato['fec_resultados'] . "',2,NOW(),
                $id_usuario)";
        $this->db4->query($sql);
    }

    function get_id_examen_efsrt_ifv($id_examen)
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%Y-%m-%d') as fecha_limite,DATE_FORMAT(e.fec_resultados, '%Y-%m-%d') as fecha_resultados,
                (SELECT group_concat(distinct d.id_carrera ORDER by d.id_carrera ASC) FROM examen_carrera_efsrt_ifv d WHERE d.id_examen=e.id_examen and d.estado=2) as carrera
                FROM examen_efsrt_ifv e 
                WHERE e.id_examen=$id_examen";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_examen_efsrt_activo_update($dato)
    {
        $sql = "SELECT e.*,DATE_FORMAT(e.fec_limite, '%d/%m/%Y') AS fecha_limite,
                DATE_FORMAT(e.fec_resultados, '%d/%m/%Y') as fecha_resultados 
                FROM examen_efsrt_ifv e 
                WHERE e.estado=2 and e.estado_contenido=1 and id_examen<>'" . $dato['id_examen'] . "'";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function update_examen_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE examen_efsrt_ifv SET nom_examen='" . $dato['nom_examen'] . "',fec_limite='" . $dato['fec_limite'] . "',
                fec_resultados='" . $dato['fec_resultados'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario  
                WHERE id_examen='" . $dato['id_examen'] . "'";
        $this->db4->query($sql);
    }

    function get_preguntas_examen_copia($dato)
    {
        $sql = "SELECT group_concat(distinct id_pregunta) as preguntas FROM pregunta_admision_efsrt where id_examen=(select c.id_examen from examen_efsrt_ifv c where c.cod_examen='" . $dato['cod_examen'] . "') and estado=2";

        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function insert_examen_efsrt_duplicado_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO examen_efsrt_ifv (cod_examen,nom_examen,fec_limite,fec_resultados,estado,estado_contenido,fec_reg,user_reg) 
        VALUES ('" . $dato['cod_examen'] . "','" . $dato['nom_examen'] . "','" . $dato['fec_limite'] . "','" . $dato['fec_resultados'] . "',3,'" . $dato['estado_contenido'] . "',NOW(),$id_usuario)";

        $this->db4->query($sql);

        $sql = "INSERT INTO examen_carrera_efsrt_ifv (id_examen,id_carrera,estado,fec_reg,user_reg) 
            select (select c.id_examen from examen_efsrt_ifv c where c.cod_examen='" . $dato['cod_examen'] . "'),
            p.id_carrera,2,NOW(),$id_usuario from examen_carrera_efsrt_ifv p 
            where p.id_examen='" . $dato['id_examen_1'] . "' and p.estado=2";
        $this->db4->query($sql);

        $sql = "INSERT INTO pregunta_admision_efsrt (id_carrera,id_examen,pregunta,orden,img,estado,fec_reg,user_reg,id_pregunta_a) 
                SELECT id_carrera,(select c.id_examen from examen_efsrt_ifv c where c.cod_examen='" . $dato['cod_examen'] . "'),
                pregunta,orden,img,estado,NOW(),$id_usuario,id_pregunta 
                FROM pregunta_admision_efsrt 
                WHERE id_examen='" . $dato['id_examen_1'] . "' AND estado=2";
        $this->db4->query($sql);

        $sql2 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_area,desc_respuesta,correcto,estado,fec_reg,user_reg)
                SELECT p.id_pregunta,r.id_area,r.desc_respuesta,r.correcto,r.estado,NOW(),1 FROM respuesta_admision_efsrt r
                LEFT JOIN pregunta_admision_efsrt p on p.id_pregunta_a=r.id_pregunta
                WHERE r.estado=2 and p.id_examen=(select c.id_examen from examen_efsrt_ifv c where c.cod_examen='" . $dato['cod_examen'] . "')";
        $this->db4->query($sql2);
    }

    function insert_respuesta_examen_efsrt_duplicado_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta,correcto,estado,fec_reg,user_reg)
                SELECT id_pregunta,id_carrera,desc_respuesta,correcto,estado,NOW(),$id_usuario 
                FROM respuesta_admision_efsrt
                WHERE estado=2 and id_pregunta in (" . $dato['pregunta'][0]['preguntas'] . ")";
        echo $sql;
        $this->db4->query($sql);
    }

    function ultimo_examen_efsrt_ifv()
    {
        $sql = "SELECT id_examen FROM examen_efsrt_ifv  
                ORDER BY id_examen DESC LIMIT 1";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function duplicar_examen_efsrt_ifv($dato)
    {
        $sql = "INSERT INTO pregunta_admision_efsrt (id_area,id_examen,pregunta,orden,img,estado,fec_reg,user_reg,id_pregunta_a) 
                SELECT id_area,'" . $dato['id_examen_nuevo'] . "',pregunta,orden,img,estado,NOW(),user_reg,id_pregunta 
                FROM pregunta_admision_efsrt 
                WHERE id_examen='" . $dato['id_examen_1'] . "' AND estado=2";
        $this->db4->query($sql);
    }

    function copiar_preguntas_examen_efsrt_ifv($dato)
    {
        $sql2 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_area,desc_respuesta,correcto,estado,fec_reg,user_reg)
                    SELECT p.id_pregunta,r.id_area,r.desc_respuesta,r.correcto,r.estado,NOW(),1 FROM respuesta_admision_efsrt r
                    LEFT JOIN pregunta_admision_efsrt p on p.id_pregunta_a=r.id_pregunta
                    WHERE r.estado=2 and p.id_examen='" . $dato['id_examen_nuevo'] . "'";
        $this->db4->query($sql2);
    }

    function get_list_detalle_pregunta_efsrt($id_examen)
    {
        $sql = "SELECT p.id_examen, p.id_area,count(p.id_examen) AS cantidad 
                FROM pregunta_admision_efsrt p
                where p.estado='2' and p.id_examen='$id_examen'
                group by p.id_examen,p.id_area";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_list_preguntas_admision_efsrt($id_carrera, $id_examen)
    {
        $sql = "SELECT * FROM pregunta_admision_efsrt 
                WHERE id_carrera='$id_carrera' and id_examen='$id_examen' and estado='2' 
                ORDER BY orden ASC";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_pregunta_admision_efsrt($dato)
    {
        $sql = "SELECT * from pregunta_admision_efsrt 
                where id_carrera='" . $dato['id_carrera'] . "' and id_examen='" . $dato['id_examen'] . "' and estado=2 ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function insert_pregunta_admision_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        //$id_area=$dato['id_area'];
        //$id_examen=$dato['id_examen'];
        /*$path = $_FILES['img']['name'];
        $size1 = $_FILES['img']['size'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img';
        $config['upload_path'] = './IFV_Examen_Admision_EFSRT/'.$id_area.'-'.$id_examen.'/examen';
        $nombre="exam".$fecha."_".rand(1,200);
        $config['file_name'] = $nombre.".".$ext;


        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'IFV_Examen_Admision_EFSRT/'.$id_area.'-'.$id_examen.'/examen'.'/'.$config['file_name'];

        $config['allowed_types'] = "png";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();*/

        //
        $path1 = $_FILES['img']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);

        $config['upload_path'] =  './IFV_Examen_Admision_EFSRT/examen';
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre = "exam" . $fecha . "_" . rand(1, 200);
        $ruta = "";
        if ($path1 != "") {
            $ruta = "IFV_Examen_Admision_EFSRT/examen/" . $nombre . "." . $ext1;
            if (!empty($_FILES['img']['name'])) {
                $config['upload_path'] = './IFV_Examen_Admision_EFSRT/examen/';
                $config['allowed_types'] = 'png|jpg|jpeg|pdf';
                $config['file_name'] = $nombre . "." . $ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img')) {
                    $img = $this->upload->data();
                } else {
                    echo $this->upload->display_errors();
                }
            }
        }
        $sql = "INSERT INTO pregunta_admision_efsrt (id_carrera,id_examen,orden,pregunta,img,estado,user_reg,fec_reg) 
        VALUES ('" . $dato['id_carrera'] . "','" . $dato['id_examen'] . "','" . $dato['orden'] . "','" . $dato['pregunta'] . "',
        '" . $ruta . "',2,$id_usuario,NOW())";

        $this->db4->query($sql);

        $sql2 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta, estado, fec_reg, user_reg) 
        values ((SELECT id_pregunta from pregunta_admision_efsrt where id_carrera='" . $dato['id_carrera'] . "' and id_examen='" . $dato['id_examen'] . "'  order by id_pregunta desc limit 1),
        '" . $dato['id_carrera'] . "','" . $dato['alternativa1'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql2);

        $sql3 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta, estado, fec_reg, user_reg) 
        values ((SELECT id_pregunta from pregunta_admision_efsrt where id_carrera='" . $dato['id_carrera'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
        '" . $dato['id_carrera'] . "','" . $dato['alternativa2'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql3);

        $sql4 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta, estado, fec_reg, user_reg) 
        values ((SELECT id_pregunta from pregunta_admision_efsrt where id_carrera='" . $dato['id_carrera'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
        '" . $dato['id_carrera'] . "','" . $dato['alternativa3'] . "','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql4);

        /*$sql5 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta, estado, fec_reg, user_reg) 
        values ((SELECT id_pregunta from pregunta_admision_efsrt where id_carrera='".$dato['id_carrera']."' and id_examen='".$dato['id_examen']."' order by id_pregunta desc limit 1),
        '".$dato['id_carrera']."','".$dato['alternativa4']."','2', NOW(),".$id_usuario.")";
        $this->db4->query($sql5);*/

        $sql6 = "INSERT INTO respuesta_admision_efsrt (id_pregunta,id_carrera,desc_respuesta,correcto, estado, fec_reg, user_reg) 
        values ((SELECT id_pregunta from pregunta_admision_efsrt where id_carrera='" . $dato['id_carrera'] . "' and id_examen='" . $dato['id_examen'] . "' order by id_pregunta desc limit 1),
        '" . $dato['id_carrera'] . "','" . $dato['alternativa5'] . "','1','2', NOW()," . $id_usuario . ")";
        $this->db4->query($sql6);
    }

    function valida_cant_pregunta_efsrt($dato)
    {
        $sql = "SELECT * from pregunta_admision_efsrt 
                where id_examen='" . $dato['id_examen'] . "' and estado=2";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function update_examen_efsrt_estado_contenido($dato)
    {
        $sql = "UPDATE examen_efsrt_ifv set estado_contenido='" . $dato['estado_contenido'] . "' where id_examen='" . $dato['id_examen'] . "'";
        $this->db4->query($sql);
    }

    function get_id_pregunta_efsrt_admision($dato)
    {
        $sql = "SELECT p.*
        FROM pregunta_admision_efsrt p 
        WHERE p.id_pregunta='" . $dato['id_pregunta'] . "' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_id_respuesta_admision_efsrt($dato)
    {
        $sql = "SELECT * from respuesta_admision_efsrt where estado=2 and id_pregunta='" . $dato['id_pregunta'] . "' ";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function delete_pregunta_efsrt_admision($id_pregunta)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE pregunta_admision_efsrt set estado='4', fec_eli= NOW(),user_eli=$id_usuario
                where id_pregunta='" . $id_pregunta . "'";
        $sql2 = " UPDATE respuesta_admision_efsrt set estado='4', fec_eli= NOW(),user_eli=$id_usuario
                where id_pregunta='" . $id_pregunta . "' ";
        $this->db4->query($sql);
        $this->db4->query($sql2);
    }


    function update_pregunta_admision_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $path1 = $_FILES['imge']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);

        $config['upload_path'] =  './IFV_Examen_Admision_EFSRT/examen';
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre = "exam" . $fecha . "_" . rand(1, 200);
        $ruta = $dato['get_id'][0]['img'];
        if ($path1 != "") {
            $ruta = "IFV_Examen_Admision_EFSRT/examen/" . $nombre . "." . $ext1;
            if (!empty($_FILES['imge']['name'])) {
                $config['upload_path'] = './IFV_Examen_Admision_EFSRT/examen/';
                $config['allowed_types'] = 'png|jpg|jpeg|pdf';
                $config['file_name'] = $nombre . "." . $ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imge')) {
                    $imge = $this->upload->data();
                } else {
                    echo $this->upload->display_errors();
                }
            }
        }
        $sql = "UPDATE pregunta_admision_efsrt SET orden='" . $dato['orden'] . "',
        pregunta='" . $dato['pregunta'] . "',img='" . $ruta . "',user_act=" . $id_usuario . ",
        fec_act=NOW() WHERE id_pregunta='" . $dato['id_pregunta'] . "' ";

        $this->db4->query($sql);

        $sql2 = "UPDATE respuesta_admision_efsrt SET desc_respuesta='" . $dato['alternativa1'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta1'] . "";
        $this->db4->query($sql2);

        $sql3 = "UPDATE respuesta_admision_efsrt SET desc_respuesta='" . $dato['alternativa2'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta2'] . "";
        $this->db4->query($sql3);

        $sql4 = "UPDATE respuesta_admision_efsrt SET desc_respuesta='" . $dato['alternativa3'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta3'] . "";
        $this->db4->query($sql4);

        /*$sql5 = "UPDATE respuesta_admision_efsrt SET desc_respuesta='".$dato['alternativa4']."', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=".$dato['id_respuesta4']."";
        $this->db4->query($sql5);*/

        $sql6 = "UPDATE respuesta_admision_efsrt SET desc_respuesta='" . $dato['alternativa5'] . "', fec_act=NOW(),user_act='$id_usuario' WHERE id_respuesta=" . $dato['id_respuesta5'] . "";
        $this->db4->query($sql6);
    }
    //-----------------------------------------------C CONTRATO------------------------------------------
    function get_list_c_contrato($id_c_contrato = null)
    {
        if (isset($id_c_contrato) && $id_c_contrato > 0) {
            $sql = "SELECT c.*,tc.alumno,SUBSTRING_INDEX(c.documento,'/',-1) AS nom_documento
                    FROM c_contrato c
                    LEFT JOIN tipo_contrato tc ON tc.id_tipo=c.tipo
                    WHERE c.id_c_contrato=$id_c_contrato";
        } else {
            $sql = "SELECT c.id_c_contrato,CASE WHEN tc.alumno=1 THEN CONCAT(tc.nom_tipo,' - Trámites') 
                    WHEN tc.alumno=2 THEN CONCAT(tc.nom_tipo,' - EFSRT') ELSE tc.nom_tipo END AS tipo,
                    c.referencia,CASE WHEN SUBSTRING(c.mes_anio,1,2)='01' 
                    THEN CONCAT('Ene/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='02' 
                    THEN CONCAT('Feb/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='03' 
                    THEN CONCAT('Mar/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='04' 
                    THEN CONCAT('Abr/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='05' 
                    THEN CONCAT('May/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='06' 
                    THEN CONCAT('Jun/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='07' 
                    THEN CONCAT('Jul/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='08' 
                    THEN CONCAT('Ago/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='09' 
                    THEN CONCAT('Set/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='10' 
                    THEN CONCAT('Oct/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='11' 
                    THEN CONCAT('Nov/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='12' THEN 
                    CONCAT('Dic/',SUBSTRING(c.mes_anio,-4,4)) ELSE '' END AS mes_anio,c.descripcion,c.asunto,
                    c.texto_correo,c.documento,st.nom_status,st.color,(SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=2 AND df.estado=2) AS enviados,
                    (SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=3 AND df.estado=2) AS firmados,
                    0 AS por_firmar
                    FROM c_contrato c
                    LEFT JOIN tipo_contrato tc ON tc.id_tipo=c.tipo
                    LEFT JOIN status st ON st.id_status=c.estado
                    WHERE c.id_empresa=6 AND c.estado IN (2,3)
                    ORDER BY c.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_combo_c_contrato()
    {
        $sql = "SELECT * FROM c_contrato 
                WHERE id_empresa=6 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_c_contrato()
    {
        $sql = "SELECT id_c_contrato FROM c_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO c_contrato (id_empresa,tipo,referencia,mes_anio,
                fecha_envio,descripcion,asunto,enviar,id_grupo,id_especialidad,
                id_turno,id_modulo,id_seccion_fv,alumnos,texto_correo,sms,
                texto_sms,documento,estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['tipo'] . "','" . $dato['referencia'] . "',
                '" . $dato['mes_anio'] . "','" . $dato['fecha_envio'] . "',
                '" . $dato['descripcion'] . "','" . $dato['asunto'] . "','" . $dato['enviar'] . "',
                '" . $dato['id_grupo'] . "','" . $dato['id_especialidad'] . "','" . $dato['id_turno'] . "',
                '" . $dato['id_modulo'] . "','" . $dato['id_seccion'] . "','" . $dato['alumnos'] . "',
                '" . $dato['texto_correo'] . "','" . $dato['sms'] . "','" . $dato['texto_sms'] . "',
                '" . $dato['documento'] . "',3,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET tipo='" . $dato['tipo'] . "',
                referencia='" . $dato['referencia'] . "',mes_anio='" . $dato['mes_anio'] . "',
                fecha_envio='" . $dato['fecha_envio'] . "',descripcion='" . $dato['descripcion'] . "',
                asunto='" . $dato['asunto'] . "',enviar='" . $dato['enviar'] . "',
                id_grupo='" . $dato['id_grupo'] . "',id_especialidad='" . $dato['id_especialidad'] . "',
                id_turno='" . $dato['id_turno'] . "',id_modulo='" . $dato['id_modulo'] . "',
                id_seccion_fv='" . $dato['id_seccion'] . "',alumnos='" . $dato['alumnos'] . "',
                texto_correo='" . $dato['texto_correo'] . "',sms='" . $dato['sms'] . "',
                texto_sms='" . $dato['texto_sms'] . "',documento='" . $dato['documento'] . "',
                estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_c_contrato='" . $dato['id_c_contrato'] . "'";
        $this->db->query($sql);
    }

    function delete_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_c_contrato='" . $dato['id_c_contrato'] . "'";
        $this->db->query($sql);
    }

    function get_list_alumno_contrato($alumno)
    {
        if ($alumno == 1) {
            $sql = "SELECT Id AS id_alumno,
                    CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre,' - ',Codigo) AS nom_alumno
                    FROM nuevos_fv
                    WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18
                    ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC";
        } else {
            $sql = "SELECT Id AS id_alumno,
                    CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre,' - ',Codigo) AS nom_alumno
                    FROM todos_l20 
                    WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                    TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18
                    ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grupo_contrato($alumno)
    {
        if ($alumno == 1) {
            $sql = "SELECT Grupo FROM nuevos_fv
                    WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo!=''
                    GROUP BY Grupo 
                    ORDER BY Grupo ASC";
        } else {
            $sql = "SELECT Grupo FROM todos_l20 
                    WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                    TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo!=''
                    GROUP BY Grupo 
                    ORDER BY Grupo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_especialidad_contrato($grupo, $alumno)
    {
        if ($alumno == 1) {
            $sql = "SELECT Especialidad FROM nuevos_fv
                    WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                    Especialidad!=''
                    GROUP BY Especialidad 
                    ORDER BY Especialidad ASC";
        } else {
            $sql = "SELECT Especialidad FROM todos_l20
                    WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                    TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                    Especialidad!=''
                    GROUP BY Especialidad 
                    ORDER BY Especialidad ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_turno_contrato($grupo, $especialidad, $alumno)
    {
        if ($alumno == 1) {
            $sql = "SELECT Turno FROM nuevos_fv 
                    WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                    Especialidad='$especialidad' AND Turno!=''
                    GROUP BY Turno 
                    ORDER BY Turno ASC";
        } else {
            $sql = "SELECT Turno FROM todos_l20 
                    WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                    TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                    Especialidad='$especialidad' AND Turno!=''
                    GROUP BY Turno 
                    ORDER BY Turno ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_modulo_contrato($grupo, $especialidad, $turno, $alumno)
    {
        $sql = "SELECT Modulo FROM todos_l20 
                WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                Especialidad='$especialidad' AND Turno='$turno' AND Modulo!=''
                GROUP BY Modulo 
                ORDER BY Modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_contrato($grupo, $especialidad, $turno, $modulo, $alumno)
    {
        $sql = "SELECT Seccion FROM todos_l20 
                WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 AND Grupo='$grupo' AND 
                Especialidad='$especialidad' AND Turno='$turno' AND Modulo='$modulo' AND Seccion!=''
                GROUP BY Seccion 
                ORDER BY Seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------CONTRATO------------------------------------------
    function get_list_contrato($tipo)
    {
        $parte = "";
        if ($tipo == 1) {
            $parte = "AND df.estado_d=2";
        }
        $sql = "SELECT df.id_documento_firma,df.fecha_envio,df.fecha_firma,
                df.id_alumno,df.cod_alumno,df.apater_alumno,df.amater_alumno,
                df.nom_alumno,df.email_alumno,df.celular_alumno,
                DATE_FORMAT(df.fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(df.fecha_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                DATE_FORMAT(df.fecha_firma,'%H:%i') AS hora_firma,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' 
                WHEN df.estado_d=3 THEN 'Firmado'
                WHEN df.estado_d=4 THEN 'Validado' END AS nom_status,
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000'
                WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status,co.referencia,
                CASE WHEN df.arpay=1 THEN 'Si' ELSE 'No' END v_arpay,df.estado_d,df.arpay
                FROM documento_firma df
                LEFT JOIN nuevos_fv nf ON nf.Id=df.id_alumno
                LEFT JOIN c_contrato co ON co.id_c_contrato=df.id_contrato
                WHERE df.efsrt=0 AND df.id_empresa=6 AND df.estado=2 $parte
                ORDER BY nf.Apellido_Paterno ASC,nf.Apellido_Materno ASC,nf.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function truncate_tables_contrato()
    {
        $sql = "TRUNCATE TABLE nuevos_fv";
        $this->db->query($sql);
    }

    function get_list_nuevos_fv_arpay()
    {
        $sql = "SELECT ca.ClientId AS Id,ca.Id AS Codigo,pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno,
                pe.FirstName AS Nombre,pe.Email,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,pe.MobilePhone AS Celular,
                pe.IdentityCardNumber AS Dni,ct.Description AS Especialidad,cg.Name AS Grupo,st.Description AS Turno
                FROM University.CareerApplication ca
                LEFT JOIN Client cl ON cl.Id=ca.ClientId
                LEFT JOIN Person pe ON pe.Id=cl.PersonId
                LEFT JOIN University.CareerTranslation ct ON ct.CareerId=ca.CareerId
                LEFT JOIN University.CareerGroup cg ON cg.Id=ca.CareerGroupId
                LEFT JOIN University.ShiftTranslation st ON st.ShiftId=ca.ShiftId
                WHERE ca.ApprovalStatusId=0 AND (SELECT car.RequirementMandatory FROM University.CareerApplicationRequirement car 
                WHERE car.CareerApplicationId=ca.Id AND car.CareerRequirementId IN (57,58,59,60,61))=1
                ORDER BY pe.FatherSurname,pe.MotherSurname,pe.FirstName,cl.InternalStudentId";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function insert_nuevos_fv($dato)
    {
        $sql = "INSERT INTO nuevos_fv (Id,Codigo,Apellido_Paterno,Apellido_Materno,Nombre,Email,Fecha_Cumpleanos,Celular,Dni,
                Especialidad,Grupo,Turno) 
                VALUES ('" . $dato['Id'] . "','" . $dato['Codigo'] . "','" . $dato['Apellido_Paterno'] . "','" . $dato['Apellido_Materno'] . "',
                '" . $dato['Nombre'] . "','" . $dato['Email'] . "','" . $dato['Fecha_Cumpleanos'] . "','" . $dato['Celular'] . "','" . $dato['Dni'] . "',
                '" . substr($dato['Especialidad'], 0, -6) . "','" . $dato['Grupo'] . "','" . $dato['Turno'] . "')";
        $this->db->query($sql);
    }

    function get_contratos_activos()
    {
        $sql = "SELECT cc.*,tc.fecha_envio AS v_fecha_envio 
                FROM c_contrato cc
                LEFT JOIN tipo_contrato tc ON tc.id_tipo=cc.tipo
                WHERE cc.id_empresa=6 AND tc.alumno=1 AND cc.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_nuevos_fv($id_alumno)
    {
        $sql = "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,
                Celular AS celular_alumno,Grupo AS grupo_alumno,
                Especialidad AS especialidad_alumno,Turno AS turno_alumno 
                FROM nuevos_fv 
                WHERE Id=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_contrato_tipo_1($id_grupo, $id_especialidad, $id_turno)
    {
        $parte_grupo = "";
        $parte_especialidad = "";
        $parte_turno = "";
        if ($id_grupo != "0") {
            $parte_grupo = "AND Grupo='" . $id_grupo . "'";
        }
        if ($id_especialidad != "0") {
            $parte_especialidad = "AND Especialidad='" . $id_especialidad . "'";
        }
        if ($id_turno != "0") {
            $parte_turno = "AND Turno='" . $id_turno . "'";
        }

        $sql = "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,Celular AS celular_alumno,
                Grupo AS grupo_alumno,Especialidad AS especialidad_alumno,Turno AS turno_alumno
                FROM nuevos_fv
                WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 $parte_grupo $parte_especialidad $parte_turno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_envio_correo_contrato($Id, $Codigo, $id_contrato)
    {
        // AND estado_d!=1
        $sql = "SELECT id_documento_firma FROM documento_firma 
                WHERE id_alumno=$Id AND cod_alumno='$Codigo' AND id_empresa=6 AND enviado=1 AND 
                id_contrato=$id_contrato AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_firma($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,email_alumno,
                celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,id_empresa,enviado,fecha_envio,id_contrato,
                estado_d,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_alumno'] . "','" . $dato['cod_alumno'] . "','" . $dato['apater_alumno'] . "',
                '" . $dato['amater_alumno'] . "','" . $dato['nom_alumno'] . "','" . $dato['email_alumno'] . "',
                '" . $dato['celular_alumno'] . "','" . $dato['grupo_alumno'] . "','" . $dato['especialidad_alumno'] . "',
                '" . $dato['turno_alumno'] . "',6,1,NOW(),'" . $dato['id_contrato'] . "',
                2,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_documento_firma()
    {
        $sql = "SELECT id_documento_firma FROM documento_firma
                ORDER BY id_documento_firma DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_contrato($id_documento_firma)
    {
        $sql = "SELECT *,CONCAT(apater_alumno,' ',amater_alumno,', ',nom_alumno) AS alumno 
                FROM documento_firma 
                WHERE id_documento_firma=$id_documento_firma";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_email_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET email_alumno='" . $dato['email_alumno'] . "'
                WHERE id_documento_firma='" . $dato['id_documento_firma'] . "'";
        $this->db->query($sql);
    }

    function update_documento_firma($dato)
    {
        $sql = "UPDATE documento_firma SET fecha_envio=NOW()
                WHERE id_documento_firma='" . $dato['id_documento_firma'] . "'";
        $this->db->query($sql);
    }

    function validar_arpay_documento_firma($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET arpay=1
                WHERE id_documento_firma='" . $dato['id_documento_firma'] . "'";
        $this->db->query($sql);
    }

    function delete_documento_firma($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET estado_d=1
                WHERE id_documento_firma='" . $dato['id_documento_firma'] . "'";
        $this->db->query($sql);
    }
    //--------------------------------------------------UNIFORME------------------------------------
    function get_list_uniformes($tipo)
    {
        $where = "";
        $todo = "";
        $left = "";
        if ($tipo == 1) {
            $where = " WHERE todos_l20.Alumno='Matriculado' AND todos_l20.Matricula in('Asistiendo','Promovido')";
        } elseif ($tipo == 2) {
            $where = "WHERE todos_l20.Tipo=1";
        }
        $sql = "SELECT todos_l20.*,ss.color as col_status, a.Alumno as Alumno_Retirado,a.Matricula as Matricula_Retirado,
                a.contacto as contacto,a.fecha_contacto as fecha_contacto,a.hora_contacto as hora_contacto,
                CASE WHEN todos_l20.Pago_Pendiente=0 THEN 'Al Día' WHEN todos_l20.Pago_Pendiente=1 THEN 'Pendiente 1' 
                WHEN todos_l20.Pago_Pendiente=2 THEN 'Pendiente 2' ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,CASE WHEN todos_l20.Pago_Pendiente=0 THEN '#92D050' WHEN todos_l20.Pago_Pendiente=1 THEN '#7F7F7F' 
                WHEN todos_l20.Pago_Pendiente=2 THEN '#F8CBAD' ELSE '#C00000' END AS color_pago_pendiente,
                
                CASE WHEN todos_l20.Fotocheck>0 THEN 'Si' ELSE 'No' END AS v_fotocheck,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=todos_l20.Id AND de.archivo!='' AND de.estado=2) AS link_foto,
                (SELECT COUNT(*) FROM documento_alumno_empresa da 
                WHERE da.id_empresa=6 AND da.estado=2 AND (da.obligatorio=1 || (da.obligatorio=2 && TIMESTAMPDIFF(YEAR, todos_l20.Fecha_Cumpleanos, CURDATE())>4) || 
                (da.obligatorio=3 && TIMESTAMPDIFF(YEAR, todos_l20.Fecha_Cumpleanos, CURDATE())<18))) AS documentos_obligatorios,
                (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE de.id_alumno=todos_l20.Id AND de.estado=2 AND de.archivo!='' AND
                da.id_empresa=6 AND da.estado=2 AND (da.obligatorio=1 || (da.obligatorio=2 && TIMESTAMPDIFF(YEAR, todos_l20.Fecha_Cumpleanos, CURDATE())>4) || 
                (da.obligatorio=3 && TIMESTAMPDIFF(YEAR, todos_l20.Fecha_Cumpleanos, CURDATE())<18))) AS documentos_subidos
                FROM todos_l20
                LEFT JOIN status_general ss on ss.nom_status = todos_l20.Alumno
                LEFT JOIN alumno_retirado a on todos_l20.Id=a.Id and a.estado=2
                $where";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function list_usuarios_profesor()
    {
        $sql = "SELECT * FROM users where id_nivel=14 AND estado =2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_status()
    {
        $sql = "SELECT * from status where id_status in (1,2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario()
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

    function get_list_horario_fv($id_horario = null)
    {
        if (isset($id_horario) && $id_horario > 0) {
            $sql = "SELECT * FROM horario WHERE id_horario=$id_horario";
        } else {
            $sql = "SELECT h.*,es.nom_especialidad, m.modulo, t.nom_turno,th.nom_tipo_horario,date_format(h.del_dia,'%d/%m/%Y') as del_dia,date_format(h.hasta,'%d/%m/%Y') as hasta,
            g.grupo as desc_grupo
                    FROM horario h
                    LEFT JOIN especialidad es ON es.id_especialidad=h.id_especialidad
                    left join modulo m on h.id_modulo=m.id_modulo
                    left join turno t on h.id_turno=t.id_turno
                    left join tipo_horario th on h.id_tipo_horario=th.id_tipo_horario
                    left join grupo_calendarizacion g on h.grupo=g.id_grupo
                    WHERE h.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_horario()
    {
        $sql = "SELECT id_tipo_horario,nom_tipo_horario FROM tipo_horario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_horario($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_horario!='" . $dato['id_horario'] . "'";
        }
        $sql = "SELECT * FROM horario where id_especialidad='" . $dato['id_especialidad'] . "' and grupo='" . $dato['grupo'] . "' and id_modulo='" . $dato['id_modulo'] . "'
        and id_turno='" . $dato['id_turno'] . "' and id_tipo_horario='" . $dato['id_tipo_horario'] . "' and ch_semana='" . $dato['ch_semana'] . "' and semana='" . $dato['semana'] . "' 
        and del_dia='" . $dato['del_dia'] . "' and hasta='" . $dato['hasta'] . "' $v";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horario($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO horario (id_especialidad,grupo,id_modulo,id_turno,id_tipo_horario,ch_semana,semana,del_dia,hasta,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_especialidad'] . "','" . $dato['grupo'] . "','" . $dato['id_modulo'] . "','" . $dato['id_turno'] . "','" . $dato['id_tipo_horario'] . "',
                '" . $dato['ch_semana'] . "','" . $dato['semana'] . "','" . $dato['del_dia'] . "','" . $dato['hasta'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_horario($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario SET id_especialidad='" . $dato['id_especialidad'] . "',grupo='" . $dato['grupo'] . "',id_modulo='" . $dato['id_modulo'] . "',id_turno='" . $dato['id_turno'] . "',
        id_tipo_horario='" . $dato['id_tipo_horario'] . "',ch_semana='" . $dato['ch_semana'] . "',semana='" . $dato['semana'] . "',del_dia='" . $dato['del_dia'] . "',hasta='" . $dato['hasta'] . "',
        fec_act=NOW(),user_act=$id_usuario WHERE id_horario='" . $dato['id_horario'] . "'";
        $this->db->query($sql);
    }

    function delete_horario($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario SET estado=1,fec_eli=NOW(),user_eli=$id_usuario WHERE id_horario='" . $dato['id_horario'] . "'";
        $this->db->query($sql);
    }

    function get_list_hora_xturno($dato)
    {
        $sql = "SELECT *,DATE_FORMAT(desde,'%H:%i %p') as desde,DATE_FORMAT(hasta,'%H:%i %p') as hasta  FROM hora where estado=2 and id_turno='" . $dato['get_id'][0]['id_turno'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad_didactica_xespecialidad($id_especialidad)
    {
        $sql = "SELECT * FROM unidad_didactica WHERE id_especialidad=$id_especialidad and estado=2";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_horario_detalle($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_horario_detalle!='" . $dato['id_horario_detalle'] . "'";
        }
        $sql = "SELECT * FROM horario_detalle WHERE id_horario='" . $dato['id_horario'] . "' and id_hora='" . $dato['id_hora'] . "' and id_unidad_didactica='" . $dato['id_unidad_didactica'] . "'
        and id_profesor='" . $dato['id_profesor'] . "' and id_salon='" . $dato['id_salon'] . "' and estado=2 $v";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horario_detalle($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO horario_detalle (id_horario,id_hora,id_unidad_didactica,id_profesor,id_salon,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_horario'] . "','" . $dato['id_hora'] . "','" . $dato['id_unidad_didactica'] . "','" . $dato['id_profesor'] . "','" . $dato['id_salon'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_horario_detalle($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario_detalle SET id_hora='" . $dato['id_hora'] . "',id_unidad_didactica='" . $dato['id_unidad_didactica'] . "',id_profesor='" . $dato['id_profesor'] . "',id_salon='" . $dato['id_salon'] . "',
        fec_act=NOW(),user_act=$id_usuario WHERE id_horario_detalle='" . $dato['id_horario_detalle'] . "'";
        $this->db->query($sql);
    }

    function list_horario_detalle($id_horario)
    {

        $sql = "SELECT a.*,DATE_FORMAT(b.desde,'%H:%i %p') as desde,DATE_FORMAT(b.hasta,'%H:%i %p') as hasta,c.nom_unidad_didactica,d.referencia,d.descripcion
        FROM horario_detalle a 
        left join hora b on a.id_hora=b.id_hora
        left join unidad_didactica c on a.id_unidad_didactica=c.id_unidad_didactica
        left join salon d on a.id_salon=d.id_salon
        WHERE a.id_horario='$id_horario' and a.estado=2";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_horario_detalle($id_horario_detalle)
    {

        $sql = "SELECT d.*,h.id_especialidad,h.id_turno FROM horario_detalle d 
        left join horario h on d.id_horario=h.id_horario
        WHERE d.id_horario_detalle='$id_horario_detalle'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_horario_detalle($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario_detalle SET estado='1',fec_eli=NOW(),user_eli=$id_usuario WHERE id_horario_detalle='" . $dato['id_horario_detalle'] . "'";
        $this->db->query($sql);
    }
    //----------------------------------------------------------HORA-------------------------------------
    function get_list_hora($id_hora = null)
    {
        if (isset($id_hora) && $id_hora > 0) {
            $sql = "SELECT * FROM hora 
                    WHERE id_hora=$id_hora";
        } else {
            $sql = "SELECT h.id_hora,es.nom_especialidad,h.nom_turno,
                    DATE_FORMAT(h.desde,'%H:%i:%s %p') AS desde,
                    DATE_FORMAT(h.hasta,'%H:%i:%s %p') AS hasta,h.tolerancia
                    FROM hora h
                    LEFT JOIN especialidad es ON es.id_especialidad=h.id_especialidad
                    WHERE h.estado=2
                    ORDER BY es.nom_especialidad ASC,h.nom_turno ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_hora_combo($id_especialidad)
    {
        $sql = "SELECT id_hora,CONCAT(nom_turno,' ',
                DATE_FORMAT(desde,'%H:%i:%s %p'),' - ',DATE_FORMAT(hasta,'%H:%i:%s %p')) AS nom_hora
                FROM hora
                WHERE id_especialidad=$id_especialidad
                ORDER BY nom_turno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_hora($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO hora (id_especialidad,nom_turno,desde,hasta,tolerancia,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_especialidad'] . "','" . $dato['nom_turno'] . "','" . $dato['desde'] . "',
                '" . $dato['hasta'] . "','" . $dato['tolerancia'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_hora($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE hora SET id_especialidad='" . $dato['id_especialidad'] . "',
                nom_turno='" . $dato['nom_turno'] . "',desde='" . $dato['desde'] . "',
                hasta='" . $dato['hasta'] . "',tolerancia='" . $dato['tolerancia'] . "',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_hora='" . $dato['id_hora'] . "'";
        $this->db->query($sql);
    }

    function delete_hora($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE hora SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_hora='" . $dato['id_hora'] . "'";
        $this->db->query($sql);
    }

    function busca_grupo_xespecialidad($id_especialidad)
    {

        $sql = "SELECT gc.*,DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS ini_clases,
                DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clases,es.nom_especialidad,
                mo.modulo,ci.ciclo,CASE WHEN gc.estado_grupo=1 THEN 'Activo' WHEN gc.estado_grupo=2 THEN 'Inactivo' ELSE 'Terminado' 
                END AS nom_estado_grupo,tu.nom_turno,
                CASE WHEN gc.estado_grupo=1 THEN '#92D050' WHEN gc.estado_grupo=2 THEN '#C00000' ELSE '#DEEBF7' 
                END AS color_estado_grupo,  
                (SELECT COUNT(*) FROM todos_l20 ma WHERE ma.Tipo=1 AND ma.Matricula='Asistiendo' AND ma.Alumno='Matriculado' AND
                ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad) AS matriculados,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Alumno NOT IN ('Matriculado','Retirado' AND ma.Especialidad=es.nom_especialidad) AND 
                ma.Grupo=gc.grupo) AS por_matricular,
                (SELECT COUNT(*) FROM todos_l20 ma WHERE ma.Tipo=1 AND ma.Matricula='Retirado' AND ma.Alumno='Retirado' AND 
                ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad) AS retirados,
                (SELECT COUNT(*) FROM todos_l20 ma WHERE ma.Tipo=1 AND ma.Matricula='Promovido' 
                AND ma.Especialidad=es.nom_especialidad AND ma.Alumno='Matriculado' and ma.Grupo=gc.grupo) AS promovidos        
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                WHERE gc.estado=2 and gc.id_especialidad='$id_especialidad' AND (gc.estado_grupo=1 OR (DATE_ADD(gc.fin_clase, INTERVAL 60 DAY)>=CURDATE() AND gc.estado_grupo=3))
                ORDER BY nom_estado_grupo ASC,gc.grupo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_comunimg()
    {
        $sql = "SELECT * FROM comunicaion_img";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_turno_xid($dato)
    {
        $sql = "SELECT id_turno,nom_turno FROM turno WHERE estado=2 and id_turno in (" . $dato['id_turno'] . ")";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //----motivo contactenos
    function get_list_motivo_contactenos($id_motivo = null)
    {
        if (isset($id_motivo) && $id_motivo > 0) {
            $sql = "SELECT * FROM motivo_contactenos where id_motivo='$id_motivo'";
        } else {
            $sql = "SELECT a.*,t.nom_tipo
            FROM motivo_contactenos a 
            left join tipo_motivo_contactanos t on a.tipo=t.id_tipo
            where a.estado=2 ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_motivo_contactenos($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_motivo!='" . $dato['id_motivo'] . "'";
        }
        $sql = "SELECT * FROM motivo_contactenos where tipo='" . $dato['tipo'] . "' and titulo='" . $dato['titulo'] . "' and para='" . $dato['para'] . "' and estado=2 $v";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_motivo_contactenos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO motivo_contactenos (tipo,titulo,para,usuarios,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['tipo'] . "','" . $dato['titulo'] . "','" . $dato['para'] . "','" . $dato['usuarios'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_motivo_contactenos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE motivo_contactenos SET tipo='" . $dato['tipo'] . "',titulo='" . $dato['titulo'] . "',para='" . $dato['para'] . "',
                usuarios='" . $dato['usuarios'] . "',fec_act=NOW(),user_act=$id_usuario WHERE id_motivo='" . $dato['id_motivo'] . "'";
        $this->db->query($sql);
    }

    function delete_motivo_contactenos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE motivo_contactenos SET estado='1',fec_eli=NOW(),user_eli=$id_usuario WHERE id_motivo='" . $dato['id_motivo'] . "'";
        $this->db->query($sql);
    }
    //---------------------------------WEB IFV----------------------------
    function get_list_web_ifv($tipo)
    {
        $parte = "";
        if ($tipo == 1) $parte = "AND ci.estado in (1,5)";
        if ($tipo == 2) $parte = "AND ci.estado NOT IN (4)";
        if ($tipo == 3) $parte = "AND ci.estado=5";

        $sql = "SELECT ci.id_comuimg,ci.inicio_comuimg,ci.refe_comuimg,u.usuario_codigo AS creado_por,
                DATE_FORMAT(ci.inicio_comuimg, '%d/%m/%Y') AS inicio,DATE_FORMAT(ci.fin_comuimg, '%d/%m/%Y') AS fin,
                DATE_FORMAT(ci.fec_reg, '%d/%m/%Y') AS fec_reg,s.nom_status,s.color,
                CASE WHEN ci.flag_referencia=0 THEN 'Resultados IFV'
                WHEN ci.flag_referencia=1 THEN 'Triptico' 
                WHEN ci.flag_referencia=3 THEN 'Reglamento Interno' 
                WHEN ci.flag_referencia=2 THEN 'Imagen' 
                ELSE '' END AS tipo,ci.img_comuimg
                FROM comunicaion_img ci
                LEFT JOIN users u on u.id_usuario=ci.user_reg
                LEFT JOIN statusav s on s.id_statusav=ci.estado
                WHERE ci.id_comuimg>0 $parte
                ORDER BY s.nom_status ASC,ci.inicio_comuimg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_missing_types($id = null)
    {
        $adicional = "";
        if ($id != null) {
            $adicional = "OR comunicaion_img.flag_referencia = $id";
        }
        $sql = "SELECT 
        flags.flag_referencia AS id,
        CASE
            WHEN flags.flag_referencia = 0 THEN 'Resultados IFV'
            WHEN flags.flag_referencia = 1 THEN 'Triptico'
            WHEN flags.flag_referencia = 3 THEN 'Reglamento Interno'
            WHEN flags.flag_referencia = 2 THEN 'Imagen'
            ELSE ''
        END AS tipo
        FROM 
        (
            SELECT 0 AS flag_referencia UNION
            SELECT 1 AS flag_referencia UNION
            SELECT 3 AS flag_referencia UNION
            SELECT 2 AS flag_referencia
        ) AS flags
        LEFT JOIN comunicaion_img ON flags.flag_referencia = comunicaion_img.flag_referencia AND comunicaion_img.estado IN (1,5)
        WHERE 
        comunicaion_img.flag_referencia IS NULL $adicional";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_web_ifv($dato)
    {
        if ($dato['flag_referencia'] == 1) {
            $carrera = "AND cod_referencia='" . $dato['cod_referencia'] . "'";
        } else {
            $carrera = "";
        }

        $sql = "SELECT * FROM comunicaion_img 
                WHERE (inicio_comuimg BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND 
                estado=1 AND tipo_comuimg=1 AND flag_referencia='" . $dato['flag_referencia'] . "' $carrera) 
                OR 
                (fin_comuimg BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND
                estado IN (1,5) AND tipo_comuimg=1 AND flag_referencia='" . $dato['flag_referencia'] . "' $carrera)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cambiar_imagen_web_ifv($dato)
    {
        $sql = "SELECT * FROM comunicaion_img 
                WHERE (CURDATE() BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND estado=1) 
                OR 
                (CURDATE() BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND estado=1)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_web_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO comunicaion_img (flag_referencia,refe_comuimg,cod_referencia,inicio_comuimg,fin_comuimg,
                img_comuimg,estado,fec_reg,user_reg)
                VALUES ('" . $dato['flag_referencia'] . "','" . $dato['refe_comuimg'] . "','" . $dato['cod_referencia'] . "',
                '" . $dato['inicio_comuimg'] . "','" . $dato['fin_comuimg'] . "','" . $dato['img_comuimg'] . "'," . $dato['estado'] . ",NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_id_comuimg($id_comuimg)
    {
        $sql = "SELECT *,SUBSTRING_INDEX(img_comuimg,'/',-1) AS nom_documento  
                FROM comunicaion_img 
                WHERE id_comuimg=$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_obscimg($id_comuimg)
    {
        $sql = "SELECT *,SUBSTRING_INDEX(observacion_archivo,'/',-1) AS nom_documento  
                FROM observacion_colaborador 
                WHERE id_observacion =$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_obsaimg($id_comuimg)
    {
        $sql = "SELECT *,SUBSTRING_INDEX(observacion_archivo,'/',-1) AS nom_documento  
                FROM alumno_observaciones_general 
                WHERE id_observacion =$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_statusva()
    {
        $sql = "SELECT * FROM statusav 
                WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_web_ifv($dato)
    {
        if ($dato['flag_referencia'] == 1) {
            $carrera = "AND cod_referencia='" . $dato['cod_referencia'] . "'";
        } else {
            $carrera = "";
        }

        $sql = "SELECT * FROM comunicaion_img 
                WHERE id_comuimg!='" . $dato['id_comuimg'] . "' AND 
                (inicio_comuimg BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND 
                estado IN (1,5) AND tipo_comuimg=1 AND flag_referencia='" . $dato['flag_referencia'] . "' $carrera) 
                OR 
                (fin_comuimg BETWEEN '" . $dato['inicio_comuimg'] . "' AND '" . $dato['fin_comuimg'] . "' AND
                estado IN (1,5) AND tipo_comuimg=1 AND flag_referencia='" . $dato['flag_referencia'] . "' $carrera)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_web_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE comunicaion_img SET flag_referencia='" . $dato['flag_referencia'] . "',
                refe_comuimg='" . $dato['refe_comuimg'] . "',cod_referencia='" . $dato['cod_referencia'] . "',
                inicio_comuimg='" . $dato['inicio_comuimg'] . "',fin_comuimg='" . $dato['fin_comuimg'] . "',
                img_comuimg='" . $dato['img_comuimg'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_comuimg='" . $dato['id_comuimg'] . "'";
        $this->db->query($sql);
    }

    function update_state_web_ifv($state, $id)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE comunicaion_img SET estado=$state,fec_act=NOW(),user_act=$id_usuario
                WHERE id_comuimg=$id";
        $this->db->query($sql);
    }

    function delete_web_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE comunicaion_img SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_comuimg='" . $dato['id_comuimg'] . "'";
        $this->db->query($sql);
    }
    //----------------------------------------------------------ESPECIALIDAD-------------------------------------
    function list_especialidad($id_especialidad = null)
    {
        if (isset($id_especialidad) && $id_especialidad > 0) {
            $sql = "SELECT *,CASE WHEN licenciamiento=1 THEN 'L14' WHEN licenciamiento=2 THEN 'L20' ELSE '' 
                    END AS nom_licenciamiento 
                    FROM especialidad 
                    WHERE id_especialidad=$id_especialidad";
        } else {
            $sql = "SELECT e.*,CASE WHEN e.licenciamiento=1 THEN 'L14' WHEN e.licenciamiento=2 THEN 'L20' ELSE '' 
                    END AS nom_licenciamiento,st.nom_status,st.color
                    FROM especialidad e 
                    LEFT JOIN status st ON st.id_status=e.estado
                    WHERE e.estado=2
                    ORDER BY e.abreviatura ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_especialidad($dato)
    {
        $sql = "SELECT * FROM especialidad 
                WHERE abreviatura='" . $dato['abreviatura'] . "' AND nom_especialidad='" . $dato['nom_especialidad'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO especialidad (licenciamiento,abreviatura,nom_especialidad,nmodulo,
                estado,fec_reg,user_reg)
                VALUES ('" . $dato['licenciamiento'] . "','" . $dato['abreviatura'] . "', '" . $dato['nom_especialidad'] . "',
                '" . $dato['nmodulo'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_especialidad($dato)
    {
        $sql = "SELECT * FROM especialidad 
                WHERE abreviatura='" . $dato['abreviatura'] . "' AND nom_especialidad='" . $dato['nom_especialidad'] . "' AND
                id_especialidad!='" . $dato['id_especialidad'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE especialidad set licenciamiento='" . $dato['licenciamiento'] . "',
                abreviatura='" . $dato['abreviatura'] . "',nom_especialidad='" . $dato['nom_especialidad'] . "',
                nmodulo='" . $dato['nmodulo'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_especialidad='" . $dato['id_especialidad'] . "'";
        $this->db->query($sql);
    }

    function delete_especialidad($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE especialidad SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_especialidad='" . $dato['id_especialidad'] . "'";
        $this->db->query($sql);
    }

    function get_list_area($id_especialidad)
    {
        $sql = "SELECT ac.id_area,ac.codigo,ac.nombre,ac.orden,st.nom_status,st.color
                FROM area_carrera ac
                LEFT JOIN status st ON st.id_status=ac.estado
                WHERE ac.id_especialidad=$id_especialidad AND ac.estado NOT IN (4)
                ORDER BY st.nom_status ASC,ac.codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_area($dato)
    {
        $sql = "SELECT * FROM area_carrera 
                    WHERE id_especialidad='" . $dato['id_especialidad'] . "' AND codigo='" . $dato['codigo'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_area($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO area_carrera (id_especialidad,codigo,nombre,orden,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_especialidad'] . "','" . $dato['codigo'] . "','" . $dato['nombre'] . "',
                '" . $dato['orden'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_area($id_area)
    {
        $sql = "SELECT * FROM area_carrera 
                WHERE id_area=$id_area";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_area($dato)
    {
        $sql = "SELECT * FROM area_carrera 
                WHERE id_especialidad='" . $dato['id_especialidad'] . "' AND codigo='" . $dato['codigo'] . "' AND estado=2 AND 
                id_area!='" . $dato['id_area'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_area($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE area_carrera SET codigo='" . $dato['codigo'] . "',nombre='" . $dato['nombre'] . "',
                orden='" . $dato['orden'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),user_act='$id_usuario'  
                WHERE id_area='" . $dato['id_area'] . "'";
        $this->db->query($sql);
    }

    function delete_area($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE area_carrera SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_area='" . $dato['id_area'] . "'";
        $this->db->query($sql);

        $sql2 = "UPDATE pregunta_admision SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                where id_area='" . $dato['id_area'] . "'";
        $this->db->query($sql2);

        $sql3 = "UPDATE respuesta_admision SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                where id_area='" . $dato['id_area'] . "'";
        $this->db->query($sql3);
    }

    function get_list_modulo($id_especialidad)
    {
        $sql = "SELECT mo.id_modulo,mo.modulo,st.nom_status,st.color
                FROM modulo mo
                LEFT JOIN status st ON st.id_status=mo.estado
                WHERE mo.id_especialidad=$id_especialidad AND mo.estado NOT IN (4)
                ORDER BY st.nom_status ASC,mo.modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_modulo($id_especialidad)
    {
        $sql = "SELECT id_modulo,modulo
                FROM modulo
                WHERE id_especialidad=$id_especialidad AND estado=2
                ORDER BY modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_modulo($dato)
    {
        $sql = "SELECT * FROM modulo 
                WHERE id_especialidad='" . $dato['id_especialidad'] . "' AND modulo='" . $dato['modulo'] . "' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_modulo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO modulo (id_especialidad,modulo,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_especialidad'] . "','" . $dato['modulo'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_modulo($id_modulo)
    {
        $sql = "SELECT * FROM modulo 
                WHERE id_modulo=$id_modulo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_modulo($dato)
    {
        $sql = "SELECT * FROM modulo 
                WHERE id_especialidad='" . $dato['id_especialidad'] . "' AND modulo='" . $dato['modulo'] . "' AND 
                estado=2 AND id_modulo!='" . $dato['id_modulo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_modulo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE modulo SET modulo='" . $dato['modulo'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_modulo='" . $dato['id_modulo'] . "'";
        $this->db->query($sql);
    }

    function delete_modulo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE modulo SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_modulo='" . $dato['id_modulo'] . "'";
        $this->db->query($sql);
    }

    function get_list_ciclo($id_especialidad)
    {
        $sql = "SELECT ci.id_ciclo,ci.ciclo,mo.modulo,st.nom_status,st.color
                FROM ciclo ci
                LEFT JOIN modulo mo ON mo.id_modulo=ci.id_modulo
                LEFT JOIN status st ON st.id_status=ci.estado
                WHERE ci.id_especialidad=$id_especialidad AND ci.estado NOT IN (4)
                ORDER BY st.nom_status ASC,mo.modulo ASC,ci.ciclo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_ciclo($id_modulo)
    {
        $sql = "SELECT id_ciclo,ciclo
                FROM ciclo
                WHERE id_modulo=$id_modulo AND estado=2
                ORDER BY ciclo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_ciclo($dato)
    {
        $sql = "SELECT * FROM ciclo 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND ciclo='" . $dato['ciclo'] . "' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_ciclo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO ciclo (id_especialidad,id_modulo,ciclo,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_especialidad'] . "','" . $dato['id_modulo'] . "','" . $dato['ciclo'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_ciclo($id_ciclo)
    {
        $sql = "SELECT * FROM ciclo 
                WHERE id_ciclo=$id_ciclo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_ciclo($dato)
    {
        $sql = "SELECT * FROM ciclo 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND ciclo='" . $dato['ciclo'] . "' AND 
                estado=2 AND id_ciclo!='" . $dato['id_ciclo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_ciclo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE ciclo SET id_modulo='" . $dato['id_modulo'] . "',ciclo='" . $dato['ciclo'] . "',
                estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_ciclo='" . $dato['id_ciclo'] . "'";
        $this->db->query($sql);
    }

    function delete_ciclo($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE ciclo SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_ciclo='" . $dato['id_ciclo'] . "'";
        $this->db->query($sql);
    }

    function get_list_turno($id_especialidad)
    {
        $sql = "SELECT tu.id_turno,ho.nom_turno,DATE_FORMAT(ho.desde,'%H:%i:%s %p') AS desde,
                DATE_FORMAT(ho.hasta,'%H:%i:%s %p') AS hasta,ho.tolerancia,st.nom_status,st.color
                FROM turno tu
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                LEFT JOIN status st ON st.id_status=tu.estado
                WHERE tu.id_especialidad=$id_especialidad AND tu.estado NOT IN (4)
                ORDER BY st.nom_status ASC,ho.nom_turno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_turno($id_especialidad)
    {
        $sql = "SELECT tu.id_turno,CONCAT(ho.nom_turno,' ',
                DATE_FORMAT(ho.desde,'%H:%i:%s %p'),' - ',DATE_FORMAT(ho.hasta,'%H:%i:%s %p')) AS nom_turno 
                FROM turno tu
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE tu.id_especialidad=$id_especialidad AND tu.estado=2
                ORDER BY ho.nom_turno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_todo_turno()
    {
        $sql = "SELECT id_turno,nom_turno,id_especialidad 
                FROM turno 
                WHERE estado=2
                ORDER BY nom_turno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_turno($dato)
    {
        $sql = "SELECT tu.id_turno FROM turno tu
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE tu.id_especialidad='" . $dato['id_especialidad'] . "' AND ho.nom_turno='" . $dato['nom_turno'] . "' AND 
                tu.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_turno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO turno (id_especialidad,id_hora,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_especialidad'] . "','" . $dato['id_hora'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_turno($id_turno)
    {
        $sql = "SELECT a.*,b.desde,b.hasta,b.tolerancia
        FROM turno a
        left join hora b on a.id_hora=b.id_hora
                WHERE a.id_turno=$id_turno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_turno($dato)
    {
        $sql = "SELECT * FROM turno 
                WHERE id_especialidad='" . $dato['id_especialidad'] . "' AND nom_turno='" . $dato['nom_turno'] . "' AND 
                estado=2 AND id_turno!='" . $dato['id_turno'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_turno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE turno SET nom_turno='" . $dato['nom_turno'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_turno='" . $dato['id_turno'] . "'";
        $this->db->query($sql);
    }

    function delete_turno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE turno SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_turno='" . $dato['id_turno'] . "'";
        $this->db->query($sql);
    }

    function get_list_unidad_didactica($id_especialidad)
    {
        $sql = "SELECT ud.id_unidad_didactica,ud.cod_unidad_didactica,ud.nom_unidad_didactica,ud.creditos,
                ud.puntaje_minimo,ud.ciclo_academico,mo.modulo,co.nom_competencia,st.nom_status,st.color
                FROM unidad_didactica ud
                LEFT JOIN modulo mo ON mo.id_modulo=ud.id_modulo
                LEFT JOIN competencia co ON co.id_competencia=ud.id_competencia
                LEFT JOIN status st ON st.id_status=ud.estado
                WHERE ud.id_especialidad=$id_especialidad AND ud.estado NOT IN (4)
                ORDER BY st.nom_status ASC,mo.modulo ASC,ud.cod_unidad_didactica ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad_didactica_combo($id_especialidad)
    {
        $sql = "SELECT id_unidad_didactica,CONCAT('(',cod_unidad_didactica,') ',nom_unidad_didactica) 
                AS nom_unidad_didactica 
                FROM unidad_didactica 
                WHERE id_especialidad=$id_especialidad AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad_didactica_inactivo($id_especialidad)
    {
        $sql = "SELECT id_unidad_didactica,CONCAT('(',cod_unidad_didactica,') ',nom_unidad_didactica) 
                AS nom_unidad_didactica 
                FROM unidad_didactica 
                WHERE id_especialidad=$id_especialidad AND estado=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_competencia()
    {
        $sql = "SELECT * FROM competencia ORDER BY nom_competencia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_unidad_didactica($dato)
    {
        $sql = "SELECT * FROM unidad_didactica 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND cod_unidad_didactica='" . $dato['cod_unidad_didactica'] . "' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_unidad_didactica($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO unidad_didactica (id_especialidad,id_modulo,id_competencia,cod_unidad_didactica,
                nom_unidad_didactica,creditos,puntaje_minimo,ciclo_academico,id_precedencia,id_reemplazo,id_profesor,
                estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_especialidad'] . "','" . $dato['id_modulo'] . "','" . $dato['id_competencia'] . "',
                '" . $dato['cod_unidad_didactica'] . "','" . addslashes($dato['nom_unidad_didactica']) . "','" . $dato['creditos'] . "',
                '" . $dato['puntaje_minimo'] . "','" . $dato['ciclo_academico'] . "','" . $dato['id_precedencia'] . "',
                '" . $dato['id_reemplazo'] . "','" . $dato['id_profesor'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_unidad_didactica($id_unidad_didactica)
    {
        $sql = "SELECT * FROM unidad_didactica 
                WHERE id_unidad_didactica=$id_unidad_didactica";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_unidad_didactica($dato)
    {
        $sql = "SELECT * FROM unidad_didactica 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND cod_unidad_didactica='" . $dato['cod_unidad_didactica'] . "' AND 
                estado=2 AND id_unidad_didactica!='" . $dato['id_unidad_didactica'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_unidad_didactica($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE unidad_didactica SET id_modulo='" . $dato['id_modulo'] . "',id_competencia='" . $dato['id_competencia'] . "',
                cod_unidad_didactica='" . $dato['cod_unidad_didactica'] . "',nom_unidad_didactica='" . addslashes($dato['nom_unidad_didactica']) . "',
                creditos='" . $dato['creditos'] . "',puntaje_minimo='" . $dato['puntaje_minimo'] . "',
                ciclo_academico='" . $dato['ciclo_academico'] . "',id_precedencia='" . $dato['id_precedencia'] . "',
                id_reemplazo='" . $dato['id_reemplazo'] . "',id_profesor='" . $dato['id_profesor'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_unidad_didactica='" . $dato['id_unidad_didactica'] . "'";
        $this->db->query($sql);
    }

    function delete_unidad_didactica($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE unidad_didactica SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_unidad_didactica='" . $dato['id_unidad_didactica'] . "'";
        $this->db->query($sql);
    }

    function get_list_horas_efsrt($id_especialidad)
    {
        $sql = "SELECT ef.id,mo.modulo,ef.horas,st.nom_status,st.color
        FROM
        horas_efsrt ef
        LEFT JOIN modulo mo ON mo.id_modulo = ef.id_modulo
        LEFT JOIN status st ON st.id_status = ef.estado
        WHERE
        mo.id_especialidad = $id_especialidad
        AND ef.estado NOT IN (4)
        ORDER BY ef.id ASC,st.nom_status ASC,mo.modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_horas($dato)
    {
        $sql = "SELECT * FROM horas_efsrt 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horas($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO horas_efsrt (id_modulo,horas,estado,fec_reg,user_reg) 
                VALUES('" . $dato['id_modulo'] . "','" . $dato['horas'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_horas($id)
    {
        $sql = "SELECT ef.*, mo.id_especialidad from horas_efsrt ef LEFT JOIN modulo mo ON mo.id_modulo = ef.id_modulo WHERE id = $id";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_horas($dato)
    {
        $sql = "SELECT * FROM horas_efsrt 
                WHERE id_modulo='" . $dato['id_modulo'] . "' AND 
                estado=2 AND id!='" . $dato['id_horas'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_horas($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horas_efsrt SET id_modulo='" . $dato['id_modulo'] . "',horas='" . $dato['horas'] . "',
                estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id='" . $dato['id_horas'] . "'";
        $this->db->query($sql);
    }

    function delete_horas($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horas_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id='" . $dato['id_horas'] . "'";
        $this->db->query($sql);
    }
    //----------------------------------------COLABORADORES------------------------------------------
    function get_list_colaborador($tipo)
    {
        $parte = "";
        if ($tipo == 1) {
            $parte = "AND co.estado=2";
        } else {
            $parte = "AND co.estado NOT IN (4)";
        }

        $sql = "SELECT co.id_colaborador,CASE WHEN co.foto!='' THEN 'Si' ELSE 'No' END ft, 
                co.apellido_paterno,co.apellido_materno,co.nombres,co.nickname,co.codigo_gll,
                co.correo_personal,co.celular,CASE WHEN co.cv!='' THEN 'Si' ELSE 'No' END AS cv,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN 'Si' ELSE 'No' END AS ct,co.foto,co.dni,
                co.correo_corporativo,co.direccion,de.nombre_departamento,
                pr.nombre_provincia,di.nombre_distrito,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT DATE_FORMAT(cc.inicio_funciones,'%d-%m-%Y') 
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS inicio_funciones,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN cc.fin_funciones IS NULL OR cc.fin_funciones='' OR 
                cc.fin_funciones='0000-00-00' THEN '' ELSE DATE_FORMAT(cc.fin_funciones,'%d-%m-%Y') END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS fin_funciones,co.nickname,co.usuario,
                st.nom_status,co.observaciones,CASE WHEN co.archivo_dni!='' THEN 'Si'
                ELSE 'No' END AS doc,pe.nom_perfil AS perfil,
                CASE WHEN SUBSTRING(co.fec_nacimiento,1,1)!='0' THEN 
                DATE_FORMAT(co.fec_nacimiento,'%d-%m-%Y') ELSE '' END AS fec_nacimiento,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2 AND 
                cc.archivo!='')>0 THEN 'Si' ELSE 'No' END AS ct_firmado
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                LEFT JOIN status st ON st.id_status=co.estado
                LEFT JOIN perfil pe ON pe.id_perfil=co.id_perfil
                WHERE co.id_empresa=6 $parte
                ORDER BY co.apellido_paterno ASC,co.apellido_materno ASC,co.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_profesor()
    {
        $sql = "SELECT id_colaborador,CONCAT(apellido_paterno,' ',apellido_materno,', ',nombres) AS nom_colaborador 
                FROM colaborador 
                WHERE id_perfil=1 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_perfil()
    {
        $sql = "SELECT * FROM perfil 
                WHERE id_empresa=6 AND estado=2
                ORDER BY nom_perfil ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_departamento()
    {
        $sql = "SELECT * FROM departamento 
                ORDER BY nombre_departamento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_provincia($id_departamento)
    {
        $sql = "SELECT * FROM provincia 
                WHERE id_departamento=$id_departamento 
                ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distrito($id_provincia)
    {
        $sql = "SELECT * FROM distrito 
                WHERE id_provincia=$id_provincia 
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_colaborador()
    {
        $sql = "SELECT id_colaborador FROM colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_usuario_colaborador($dato)
    {
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='" . $dato['usuario'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla = $dato['codigo_gll'] . "'C";
        if ($dato['fec_nacimiento'] == '' or $dato['fec_nacimiento'] == '0000-00-00') {
            $dato['fec_nacimiento'] = 'NULL';
        } else {
            $dato['fec_nacimiento'] = "'" . $dato['fec_nacimiento'] . "'";
        }

        $sql = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll, codigo_glla,nickname,usuario,password,
                password_desencriptado,foto,observaciones, fec_nacimiento,estado,fec_reg,user_reg)
                VALUES (6,'" . $dato['id_perfil'] . "', '" . $dato['apellido_paterno'] . "',
                '" . $dato['apellido_materno'] . "', '" . $dato['nombres'] . "','" . $dato['dni'] . "',
                '" . $dato['correo_personal'] . "', '" . $dato['correo_corporativo'] . "',
                '" . $dato['celular'] . "', '" . $dato['direccion'] . "', '" . $dato['id_departamento'] . "',
                '" . $dato['id_provincia'] . "', '" . $dato['id_distrito'] . "', '" . $dato['codigo_gll'] . "',
                '" . addslashes($codigo_glla) . "','" . $dato['nickname'] . "','" . $dato['usuario'] . "', 
                '" . $dato['password'] . "','" . $dato['password_desencriptado'] . "',
                '" . $dato['foto'] . "','" . $dato['observaciones'] . "'," . $dato['fec_nacimiento'] . ",2,NOW(),
                $id_usuario)";
        $this->db->query($sql);

        $codigo_glla = $dato['codigo_gll'] . "''C";
        $sql2 = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll, codigo_glla,nickname,usuario,password,
                password_desencriptado,foto,observaciones, fec_nacimiento,estado,fec_reg,user_reg)
                VALUES (6,'" . $dato['id_perfil'] . "', '" . $dato['apellido_paterno'] . "',
                '" . $dato['apellido_materno'] . "', '" . $dato['nombres'] . "','" . $dato['dni'] . "',
                '" . $dato['correo_personal'] . "', '" . $dato['correo_corporativo'] . "',
                '" . $dato['celular'] . "', '" . $dato['direccion'] . "', '" . $dato['id_departamento'] . "',
                '" . $dato['id_provincia'] . "', '" . $dato['id_distrito'] . "', '" . $dato['codigo_gll'] . "',
                '" . $codigo_glla . "','" . $dato['nickname'] . "','" . $dato['usuario'] . "',
                '" . $dato['password'] . "','" . $dato['password_desencriptado'] . "',
                '" . $dato['foto'] . "','" . $dato['observaciones'] . "'," . $dato['fec_nacimiento'] . ",2,
                getdate(),$id_usuario)";
        $this->db5->query($sql2);
    }

    function ultimo_id_colaborador()
    {
        $sql = "SELECT id_colaborador FROM colaborador
                ORDER BY id_colaborador DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_users_colaborador($dato)
    {
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND id_externo='" . $dato['id_externo'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_usuario_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO users (tipo,id_externo,usuario_codigo,usuario_password,password_desencriptado,
                estado,fec_reg,user_reg)
                VALUES (2,'" . $dato['id_externo'] . "','" . $dato['usuario'] . "','" . $dato['password'] . "',
                '" . $dato['password_desencriptado'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_colaborador($id_colaborador)
    {
        $sql = "SELECT co.*,
                SUBSTRING_INDEX(co.foto, '/', -1) AS nom_documento,
                CONCAT(
                    co.apellido_paterno,
                    ' ',
                    co.apellido_materno,
                    ', ',
                    co.nombres
                ) AS Nombre_Completo,
                pe.nom_perfil,
                de.nombre_departamento,
                pr.nombre_provincia, 
                di.nombre_distrito,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT DATE_FORMAT(cc.inicio_funciones,'%d/%m/%Y') 
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS i_funciones,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.fin_funciones,1,1)!='0' THEN 
                DATE_FORMAT(cc.fin_funciones,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS f_funciones,
                SUBSTRING_INDEX(co.archivo_dni, '/', -1) AS nom_dni,
                SUBSTRING_INDEX(co.cv, '/', -1) AS nom_cv,'' AS banco,'' AS cuenta
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento = co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia = co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito = co.id_distrito
                LEFT JOIN perfil pe ON co.id_perfil = pe.id_perfil
                WHERE co.id_colaborador = $id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_usuario_colaborador($dato)
    {
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='" . $dato['usuario'] . "' AND estado=2 AND
                id_externo !='" . $dato['id_colaborador'] . "'";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla = $dato['codigo_gll'] . "'C";
        $parte = "";
        if ($dato['password'] != "") {
            $parte = "password='" . $dato['password'] . "',password_desencriptado='" . $dato['password_desencriptado'] . "',";
        }

        if ($dato['fec_nacimiento'] == '' or $dato['fec_nacimiento'] == '0000-00-00') {
            $dato['fec_nacimiento'] = 'NULL';
        } else {
            $dato['fec_nacimiento'] = "'" . $dato['fec_nacimiento'] . "'";
        }

        $sql = "UPDATE colaborador SET id_perfil='" . $dato['id_perfil'] . "',
                apellido_paterno='" . $dato['apellido_paterno'] . "',
                apellido_materno='" . $dato['apellido_materno'] . "',nombres='" . $dato['nombres'] . "',
                dni='" . $dato['dni'] . "',correo_personal='" . $dato['correo_personal'] . "',
                correo_corporativo='" . $dato['correo_corporativo'] . "',celular='" . $dato['celular'] . "',
                direccion='" . $dato['direccion'] . "',id_departamento='" . $dato['id_departamento'] . "',
                id_provincia='" . $dato['id_provincia'] . "',id_distrito='" . $dato['id_distrito'] . "',
                codigo_gll='" . $dato['codigo_gll'] . "',nickname='" . $dato['nickname'] . "',
                usuario='" . $dato['usuario'] . "',$parte foto='" . $dato['foto'] . "',
                observaciones='" . $dato['observaciones'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),
                user_act=$id_usuario, fec_nacimiento=" . $dato['fec_nacimiento'] . ",
                codigo_glla='" . addslashes($codigo_glla) . "'
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db->query($sql);

        $codigo_glla = $dato['codigo_gll'] . "''C";

        $sql2 = "UPDATE colaborador SET id_perfil='" . $dato['id_perfil'] . "',
                apellido_paterno='" . $dato['apellido_paterno'] . "',
                apellido_materno='" . $dato['apellido_materno'] . "',nombres='" . $dato['nombres'] . "',
                dni='" . $dato['dni'] . "',correo_personal='" . $dato['correo_personal'] . "',
                correo_corporativo='" . $dato['correo_corporativo'] . "',celular='" . $dato['celular'] . "',
                direccion='" . $dato['direccion'] . "',id_departamento='" . $dato['id_departamento'] . "',
                id_provincia='" . $dato['id_provincia'] . "',id_distrito='" . $dato['id_distrito'] . "',
                codigo_gll='" . $dato['codigo_gll'] . "',nickname='" . $dato['nickname'] . "',
                usuario='" . $dato['usuario'] . "',$parte foto='" . $dato['foto'] . "',
                observaciones='" . $dato['observaciones'] . "',estado='" . $dato['estado'] . "',fec_act=getdate(),
                user_act=$id_usuario, fec_nacimiento=" . $dato['fec_nacimiento'] . ",
                codigo_glla='" . $codigo_glla . "'
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db5->query($sql2);
    }

    function update_usuario_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $parte = "";
        if ($dato['password'] != "") {
            $parte = "usuario_password='" . $dato['password'] . "',password_desencriptado='" . $dato['password_desencriptado'] . "',";
        }

        $sql = "UPDATE users SET usuario_codigo='" . $dato['usuario'] . "',$parte fec_act=NOW(),
                user_act=$id_usuario
                WHERE tipo=2 AND id_externo='" . $dato['id_externo'] . "'";
        $this->db->query($sql);
    }

    function delete_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db->query($sql);
        $sql2 = "UPDATE colaborador SET estado=4,fec_eli=getdate(),user_eli=$id_usuario 
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db5->query($sql2);
    }

    function update_cv_colaborador($dato)
    {
        $sql = "UPDATE colaborador SET archivo_dni='" . $dato['archivo_dni'] . "',cv='" . $dato['cv'] . "'
                WHERE id_colaborador ='" . $dato['id_colaborador'] . "'";
        $this->db->query($sql);
    }

    function get_list_contrato_colaborador($id_colaborador)
    {
        $sql = "SELECT cc.id_contrato,cc.nom_contrato,cc.referencia,cc.inicio_funciones,
                cc.fin_funciones,cc.sueldo1,cc.sueldo2,cc.estado_contrato,
                DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,
                CASE WHEN cc.archivo!='' THEN 'Si' ELSE 'No' END AS v_archivo,
                DATE_FORMAT(cc.fec_reg,'%d-%m-%Y') AS fec_registro,us.usuario_codigo AS user_registro,
                st.nom_status,st.color,cc.archivo,a.nom_perfil
                FROM contrato_colaborador cc
                LEFT JOIN users us ON us.id_usuario=cc.user_reg
                LEFT JOIN status st ON st.id_status=cc.estado_contrato
                left join perfil a on cc.id_perfil=a.id_perfil
                WHERE cc.id_colaborador=$id_colaborador AND cc.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_cant_contrato_colaborador($id_colaborador)
    {
        $sql = "SELECT count(*)+1 as cantidad
                FROM contrato_colaborador 
                WHERE id_colaborador=$id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_contrato_colaborador($dato)
    {
        $sql = "SELECT * FROM contrato_colaborador WHERE id_colaborador='" . $dato['id_colaborador'] . "' 
        AND estado=2 and estado_contrato=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_contrato_colaborador()
    {
        $sql = "SELECT id_contrato FROM contrato_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_contrato_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO contrato_colaborador (id_colaborador,referencia,id_perfil,inicio_funciones,
                fin_funciones,id_tipo_contrato1,sueldo1,id_tipo_contrato2,sueldo2,estado_contrato,archivo,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_colaborador'] . "','" . $dato['referencia'] . "','" . $dato['id_perfil'] . "',
                '" . $dato['inicio_funciones'] . "','" . $dato['fin_funciones'] . "','" . $dato['id_tipo_contrato1'] . "',
                '" . $dato['sueldo1'] . "','" . $dato['id_tipo_contrato2'] . "','" . $dato['sueldo2'] . "','" . $dato['estado_contrato'] . "',
                '" . $dato['archivo'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_contrato_colaborador($id_contrato)
    {
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE id_contrato=$id_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_contrato_colaborador($dato)
    {
        $sql = "SELECT * FROM contrato_colaborador WHERE id_colaborador='" . $dato['id_colaborador'] . "' 
        AND estado=2 and estado_contrato=2 and id_contrato!='" . $dato['id_contrato'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_contrato_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contrato_colaborador SET id_perfil='" . $dato['id_perfil'] . "',inicio_funciones='" . $dato['inicio_funciones'] . "',
                fin_funciones='" . $dato['fin_funciones'] . "',id_tipo_contrato1='" . $dato['id_tipo_contrato1'] . "',sueldo1='" . $dato['sueldo1'] . "',
                id_tipo_contrato2='" . $dato['id_tipo_contrato2'] . "',sueldo2='" . $dato['sueldo2'] . "',archivo='" . $dato['archivo'] . "',
                estado_contrato='" . $dato['estado_contrato'] . "',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_contrato='" . $dato['id_contrato'] . "'";
        $this->db->query($sql);
    }

    function delete_contrato_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE contrato_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_contrato='" . $dato['id_contrato'] . "'";
        $this->db->query($sql);
    }

    function get_list_pago_colaborador($id_colaborador)
    {
        $sql = "SELECT pc.id_pago,pc.id_banco AS nom_banco,pc.cuenta_bancaria,st.nom_status,
                st.color
                FROM pago_colaborador pc
                LEFT JOIN status st ON st.id_status=pc.estado
                WHERE pc.id_colaborador=$id_colaborador AND pc.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_pago_colaborador($dato)
    {
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='" . $dato['id_banco'] . "' AND cuenta_bancaria='" . $dato['cuenta_bancaria'] . "' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_pago_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO pago_colaborador (id_colaborador,id_banco,cuenta_bancaria,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_colaborador'] . "','" . $dato['id_banco'] . "',
                '" . $dato['cuenta_bancaria'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_pago_colaborador($id_pago)
    {
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_pago_colaborador($dato)
    {
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='" . $dato['id_banco'] . "' AND cuenta_bancaria='" . $dato['cuenta_bancaria'] . "' AND 
                estado=2 AND id_pago!='" . $dato['id_pago'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_colaborador SET id_banco='" . $dato['id_banco'] . "',
                cuenta_bancaria='" . $dato['cuenta_bancaria'] . "',
                estado='" . $dato['estado'] . "',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_pago='" . $dato['id_pago'] . "'";
        $this->db->query($sql);
    }

    function delete_pago_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE pago_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_pago='" . $dato['id_pago'] . "'";
        $this->db->query($sql);
    }

    function get_list_horario_colaborador($id_colaborador, $limit = null)
    {
        $parte = "";
        if ($limit != null) {
            $parte = "limit 1";
        }
        $sql = "SELECT dia,nom_dia,id_contrato,
                CONCAT(DATE_FORMAT(hora_entrada,'%H'),'h',
                DATE_FORMAT(hora_entrada,'%i')) AS hora_entrada,
                CONCAT(DATE_FORMAT(hora_salida,'%H'),'h',
                DATE_FORMAT(hora_salida,'%i')) AS hora_salida,
                CASE WHEN no_aplica=1 THEN 'No Aplica' ELSE
                CONCAT(DATE_FORMAT(hora_descanso_e,'%H'),'h',
                DATE_FORMAT(hora_descanso_e,'%i')) END AS hora_descanso_e,
                CASE WHEN no_aplica=1 THEN 'No Aplica' ELSE
                CONCAT(DATE_FORMAT(hora_descanso_s,'%H'),'h',
                DATE_FORMAT(hora_descanso_s,'%i')) END AS hora_descanso_s,
                no_aplica,
                DATE_FORMAT(hora_entrada,'%H:%i') AS entrada,
                DATE_FORMAT(hora_salida,'%H:%i') AS salida,
                DATE_FORMAT(hora_descanso_e,'%H:%i') AS descanso_e,
                DATE_FORMAT(hora_descanso_s,'%H:%i') AS descanso_s
                FROM colaborador_horario
                WHERE id_colaborador=$id_colaborador AND estado=2 $parte";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function truncate_horario_dia($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM colaborador_horario 
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db->query($sql);
    }

    function insert_horario_dia($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colaborador_horario (id_contrato,id_colaborador,dia,nom_dia,hora_entrada,hora_salida,
                hora_descanso_e,hora_descanso_s,no_aplica,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_contrato'] . "','" . $dato['id_colaborador'] . "','" . $dato['dia'] . "','" . $dato['nom_dia'] . "',
                '" . $dato['hora_entrada'] . "','" . $dato['hora_salida'] . "','" . $dato['hora_descanso_e'] . "',
                '" . $dato['hora_descanso_s'] . "','" . $dato['no_aplica'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_asistencia_colaborador($id_colaborador)
    {
        /*$sql = "SELECT ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' 
                END AS tipo_desc,CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' 
                WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,ri.codigo
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_colaborador
                ORDER BY ri.ingreso DESC"; */
        $sql = "SELECT ri.ingreso AS orden,CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' 
                END AS tipo_desc,CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' 
                WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,ri.codigo
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_colaborador
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_colaborador($id_colaborador)
    {
        $sql = "SELECT oc.id_observacion,DATE_FORMAT(oc.fecha,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                us.usuario_codigo AS usuario,oc.observacion,oc.fecha AS orden, observacion_archivo
                FROM observacion_colaborador oc
                LEFT JOIN tipo_observacion ti ON ti.id_tipo=oc.id_tipo
                LEFT JOIN users us ON us.id_usuario=oc.usuario
                WHERE oc.id_colaborador=$id_colaborador AND oc.estado=2
                ORDER BY oc.fecha DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_colaborador($dato)
    {
        $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT * FROM observacion_colaborador 
                WHERE id_tipo='" . $dato['id_tipo'] . "' AND fecha='" . $dato['fecha'] . "' AND 
                observacion='" . $dato['observacion'] . "' AND id_colaborador='" . $dato['id_colaborador'] . "' 
                AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO observacion_colaborador (id_colaborador,id_tipo,fecha,usuario,observacion,
                estado,fec_reg,user_reg, observacion_archivo, id_empresa) 
                VALUES ('" . $dato['id_colaborador'] . "','" . $dato['id_tipo'] . "','" . $dato['fecha'] . "',
                '" . $dato['usuario'] . "','" . $dato['observacion'] . "',2,NOW(),$id_usuario,
                '" . $dato['observacion_archivo'] . "',6)";
        $this->db->query($sql);
    }

    function delete_observacion_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE observacion_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db->query($sql);
    }
    //---------------------------------RETIRADOS----------------------------
    function get_list_retirados()
    {
        $sql = "SELECT ar.id_alumno_retirado,ar.Id,ar.Apellido_Paterno,ar.Apellido_Materno,ar.Nombre,ar.Codigo,
                DATE_FORMAT(ar.fecha_nasiste,'%d-%m-%Y') AS fecha_no_asiste,mr.nom_motivo,
                CASE WHEN ar.fut=1 THEN 'Si' WHEN ar.fut=2 THEN 'No' ELSE '' END AS fut,ar.tkt_boleta,
                DATE_FORMAT(ar.fecha_fut,'%d-%m-%Y') AS fecha_fut,CASE WHEN ar.pago_pendiente=1 THEN 'Si' 
                WHEN ar.pago_pendiente=2 THEN 'No' END AS pago_pendiente,
                CASE WHEN ar.monto!='' THEN CONCAT('s./ ',ar.monto) ELSE '' END AS monto,td.Motivo_Arpay,
                td.Observaciones_Arpay,ar.otro_motivo,CASE WHEN ar.contacto=1 THEN 'Si' 
                WHEN ar.contacto=2 THEN 'No' WHEN ar.contacto=3 THEN 'Incomunicado' ELSE '' END AS contacto,
                DATE_FORMAT(ar.fecha_contacto,'%d-%m-%Y') AS fecha_contacto,
                DATE_FORMAT(ar.hora_contacto,'%H:%i:%s') AS hora_contacto,ar.resumen,ar.obs_retiro,
                CASE WHEN ar.p_reincorporacion=1 THEN 'Si' WHEN ar.p_reincorporacion=2 THEN 'No' ELSE '' 
                END AS reincorporacion
                FROM alumno_retirado ar
                LEFT JOIN motivo_retiro mr ON mr.id_motivo=ar.id_motivo
                LEFT JOIN todos_l20 td ON td.Id=ar.Id
                WHERE ar.id_empresa=6 AND ar.estado=2
                ORDER BY ar.Apellido_Paterno ASC,ar.Apellido_Materno ASC,ar.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_motivo_contactanos($id_tipo = null)
    {
        if (isset($id_tipo) && $id_tipo > 0) {
            $sql = "SELECT * FROM tipo_motivo_contactanos where id_tipo='$id_tipo'";
        } else {
            $sql = "SELECT * FROM tipo_motivo_contactanos where estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------TIPO VENTA-------------------------------------
    function get_list_tipo_venta($id_tipo = null)
    {
        if (isset($id_tipo) && $id_tipo > 0) {
            $sql = "SELECT * FROM tipo_venta 
                    WHERE id_tipo=$id_tipo";
        } else {
            $sql = "SELECT tp.id_tipo,tp.cod_tipo,tp.descripcion,tp.foto,
                    CASE WHEN tp.foto!='' THEN 'Si' ELSE 'No' END AS v_foto,
                    st.nom_status,st.color
                    FROM tipo_venta tp
                    LEFT JOIN status st ON st.id_status=tp.estado
                    WHERE tp.estado NOT IN(4)
                    ORDER BY tp.cod_tipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_venta_combo()
    {
        $sql = "SELECT id_tipo,cod_tipo 
                FROM tipo_venta 
                WHERE estado=2
                ORDER BY cod_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tipo_venta($dato)
    {
        $sql = "SELECT id_tipo FROM tipo_venta 
                WHERE cod_tipo='" . $dato['cod_tipo'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_tipo_venta()
    {
        $sql = "SELECT id_tipo FROM tipo_venta 
                ORDER BY id_tipo DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        //'".$dato['foto']."',
        $sql = "INSERT INTO tipo_venta (cod_tipo,descripcion,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['cod_tipo'] . "','" . $dato['descripcion'] . "',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_tipo_venta($dato)
    {
        $sql = "SELECT id_tipo FROM tipo_venta 
                WHERE cod_tipo='" . $dato['cod_tipo'] . "' AND estado=2 AND 
                id_tipo!='" . $dato['id_tipo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tipo_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        //foto='".$dato['foto']."',
        $sql = "UPDATE tipo_venta SET cod_tipo='" . $dato['cod_tipo'] . "',
                descripcion='" . $dato['descripcion'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_tipo='" . $dato['id_tipo'] . "'";
        $this->db->query($sql);
    }

    function delete_tipo_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_venta SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_tipo='" . $dato['id_tipo'] . "'";
        $this->db->query($sql);
    }
    //-----------------------------------PRODUCTO VENTA-------------------------------------
    function get_list_producto_venta($id_producto = null, $dato = null)
    {
        if (isset($id_producto) && $id_producto > 0) {
            $sql = "SELECT *  FROM producto_venta
                    WHERE id_producto=$id_producto";
        } else {
            $estado = " IN (2)";
            if ($dato['tipo'] == 2) {
                $estado = " NOT IN (4)";
            }
            $sql = "SELECT pv.id_producto,pv.cod_producto,tv.cod_tipo,an.nom_anio,pv.nom_sistema,
                    pv.nom_documento,DATE_FORMAT(pv.fec_inicio,'%d-%m-%Y') AS fec_ini,
                    DATE_FORMAT(pv.fec_fin,'%d-%m-%Y') AS fec_fin,pv.monto,pv.descuento,pv.validado,
                    CASE WHEN pv.codigo=1 THEN 'Si' ELSE 'No' END AS codigo,
                    (SELECT SUM(vd.cantidad) FROM venta_empresa_detalle vd
                    LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                    WHERE vd.cod_producto=pv.cod_producto AND ve.estado=2 AND vd.estado=2) AS ventas,
                    (SELECT SUM((vd.precio-vd.descuento)*vd.cantidad) FROM venta_empresa_detalle vd
                    LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                    WHERE vd.cod_producto=pv.cod_producto AND ve.estado=2 AND vd.estado=2) AS ventas_monto,
                    0 AS devoluciones,0 AS devoluciones_monto,st.nom_status,st.color,pv.estado,
                    CASE WHEN pv.pago_automatizado=1 THEN 'Si' ELSE 'No' END AS pago_automatizado
                    FROM producto_venta pv
                    LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                    LEFT JOIN anio an ON an.id_anio=pv.id_anio
                    LEFT JOIN status st ON st.id_status=pv.estado
                    WHERE pv.estado $estado
                    ORDER BY pv.cod_producto ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_producto_venta()
    {
        $sql = "SELECT pv.id_producto,pv.nom_sistema,tv.id_tipo,pv.cod_producto,tv.descripcion,
                (pv.monto-pv.descuento) AS monto
                FROM producto_venta pv
                LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                WHERE pv.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_producto_venta($dato)
    {
        $sql = "SELECT id_producto FROM producto_venta 
                WHERE cod_producto='" . $dato['cod_producto'] . "' AND 
                (fec_inicio BETWEEN '" . $dato['fec_inicio'] . "' AND '" . $dato['fec_fin'] . "' OR 
                fec_fin BETWEEN '" . $dato['fec_inicio'] . "' AND '" . $dato['fec_fin'] . "') AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_producto_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_venta (cod_producto,id_tipo,id_anio,nom_sistema,nom_documento,
                fec_inicio,fec_fin,monto,descuento,validado,codigo,pago_automatizado,estado,fec_reg,
                user_reg)
                VALUES ('" . $dato['cod_producto'] . "','" . $dato['id_tipo'] . "','" . $dato['id_anio'] . "',
                '" . $dato['nom_sistema'] . "','" . $dato['nom_documento'] . "','" . $dato['fec_inicio'] . "',
                '" . $dato['fec_fin'] . "','" . $dato['monto'] . "', '" . $dato['descuento'] . "',
                '" . $dato['validado'] . "','" . $dato['codigo'] . "','" . $dato['pago_automatizado'] . "',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_producto_venta($dato)
    {
        $sql = "SELECT id_producto FROM producto_venta 
                WHERE cod_producto='" . $dato['cod_producto'] . "' AND
                (fec_inicio BETWEEN '" . $dato['fec_inicio'] . "' AND '" . $dato['fec_fin'] . "' OR 
                fec_fin BETWEEN '" . $dato['fec_inicio'] . "' AND '" . $dato['fec_fin'] . "') AND estado=2 AND 
                id_producto!='" . $dato['id_producto'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_producto_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_venta SET cod_producto='" . $dato['cod_producto'] . "',
                id_tipo='" . $dato['id_tipo'] . "',id_anio='" . $dato['id_anio'] . "',
                nom_sistema='" . $dato['nom_sistema'] . "',nom_documento='" . $dato['nom_documento'] . "',
                fec_inicio='" . $dato['fec_inicio'] . "',fec_fin='" . $dato['fec_fin'] . "',
                monto='" . $dato['monto'] . "',descuento='" . $dato['descuento'] . "',
                validado='" . $dato['validado'] . "',codigo='" . $dato['codigo'] . "',
                pago_automatizado='" . $dato['pago_automatizado'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_producto='" . $dato['id_producto'] . "'";
        $this->db->query($sql);
    }

    function delete_producto_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_venta SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_producto='" . $dato['id_producto'] . "'";
        $this->db->query($sql);
    }

    function get_list_venta_producto_venta($cod_producto)
    {
        $sql = "SELECT ve.cod_venta,td.Codigo,td.Apellido_Paterno,td.Apellido_Materno,
                td.Nombre,vd.cantidad
                FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                LEFT JOIN todos_l20 td ON td.Id=ve.id_alumno
                WHERE vd.cod_producto='$cod_producto' AND vd.estado=2 AND ve.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------NUEVA VENTA-------------------------------------
    function valida_insert_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta_empresa 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO nueva_venta_empresa (id_empresa,id_usuario) 
                VALUES (6,$id_usuario)";
        $this->db->query($sql);
    }

    function resetear_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta_empresa SET id_alumno=0
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);
        $sql2 = "DELETE FROM nueva_venta_empresa_producto 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql2);
    }

    function get_list_alumno_nueva_venta($id_alumno = null)
    {
        if (isset($id_alumno) && $id_alumno > 0) {
            $sql = "SELECT Codigo,CONCAT(Apellido_Paterno,' ',Apellido_Materno) AS Apellidos,Nombre,Grupo,Especialidad 
                    FROM todos_l20
                    WHERE Id=$id_alumno";
        } else {
            $sql = "SELECT Id AS id_alumno,CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre,' - (FV1) ',Codigo) AS nom_alumno 
                    FROM todos_l20
                    WHERE Tipo IN (1,2)
                    ORDER BY nom_alumno ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT nv.id_nueva_venta_producto,nv.cod_producto,tv.cod_tipo,
                nv.cantidad,nv.precio,nv.descuento
                FROM nueva_venta_empresa_producto nv 
                LEFT JOIN producto_venta pv ON pv.cod_producto=nv.cod_producto AND pv.estado=2
                LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                WHERE nv.id_empresa=6 AND nv.id_usuario=$id_usuario AND nv.cantidad>0
                ORDER BY nv.cod_producto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta_empresa 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_alumno_nueva_venta($id_alumno)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta_empresa SET id_alumno=$id_alumno
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function delete_alumno_nueva_venta()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta_empresa SET id_alumno=0
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function get_cod_producto_nueva_venta($cod_producto)
    {
        $sql = "SELECT pv.cod_producto,pv.nom_sistema,tv.id_tipo,tv.cod_tipo,pv.monto,pv.descuento
                FROM producto_venta pv
                LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                WHERE pv.cod_producto='$cod_producto' AND pv.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_nueva_venta_id($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta_empresa_producto 
                WHERE id_empresa=6 AND id_usuario=$id_usuario AND 
                id_tipo='" . $dato['id_tipo'] . "' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_nueva_venta_producto($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT * FROM nueva_venta_empresa_producto 
                WHERE id_empresa=6 AND id_usuario=$id_usuario AND 
                cod_producto='" . $dato['cod_producto'] . "' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_nueva_venta_producto($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO nueva_venta_empresa_producto (id_empresa,id_usuario,id_tipo,cod_producto,
                nom_sistema,precio,descuento,cantidad) 
                VALUES (6,$id_usuario,'" . $dato['id_tipo'] . "','" . $dato['cod_producto'] . "','" . $dato['descuento'] . "',
                '" . $dato['precio'] . "','" . $dato['descuento'] . "',1)";
        $this->db->query($sql);
    }

    function update_nueva_venta_producto($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta_empresa_producto SET precio='" . $dato['precio'] . "',
                descuento='" . $dato['descuento'] . "',cantidad='" . $dato['cantidad'] . "'
                WHERE id_empresa=6 AND id_usuario=$id_usuario AND 
                cod_producto='" . $dato['cod_producto'] . "'";
        $this->db->query($sql);
    }

    function delete_nueva_venta_producto($dato)
    {
        $sql = "DELETE FROM nueva_venta_empresa_producto 
                WHERE id_nueva_venta_producto='" . $dato['id_nueva_venta_producto'] . "'";
        $this->db->query($sql);
    }

    function get_list_tipo_nueva_venta()
    {
        $sql = "SELECT id_tipo,cod_tipo,descripcion,foto
                FROM tipo_venta 
                WHERE estado=2 
                ORDER BY cod_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_tipo($id_tipo)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT pv.cod_producto,pv.id_tipo,tv.cod_tipo,pv.monto,
                (SELECT nv.cantidad FROM nueva_venta_empresa_producto nv
                WHERE nv.id_empresa=6 AND nv.cod_producto=pv.cod_producto AND 
                nv.id_usuario=$id_usuario) AS cantidad
                FROM producto_venta pv
                LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                WHERE pv.id_tipo=$id_tipo AND pv.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function reducir_modal_producto_nueva_venta($dato)
    {
        $sql = "UPDATE nueva_venta_empresa_producto SET cantidad='" . $dato['cantidad'] . "'
                WHERE id_nueva_venta_producto='" . $dato['id_nueva_venta_producto'] . "'";
        $this->db->query($sql);
    }

    function valida_cierre_caja()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa
                WHERE id_empresa=6 AND fecha=CURDATE() AND estado=2 and id_vendedor=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cantidad_recibo()
    {
        $sql = "SELECT * FROM venta_empresa 
                WHERE id_empresa=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta_empresa (cod_venta,codigo,id_empresa,id_alumno,id_tipo_pago,
                monto_entregado,cambio,estado_venta,estado_recibido,estado,fec_reg,user_reg) 
                SELECT '" . $dato['cod_venta'] . "','" . $dato['code'] . "',6,id_alumno,'" . $dato['id_tipo_pago'] . "',
                '" . $dato['monto_entregado'] . "','" . $dato['cambio'] . "',1,1,2,NOW(),$id_usuario 
                FROM nueva_venta_empresa
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function ultimo_id_venta()
    {
        $sql = "SELECT id_venta,id_alumno FROM venta_empresa
                WHERE id_empresa=6
                ORDER BY id_venta DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_venta_detalle_xproducto($dato)
    {
        $sql = "SELECT vd.*,ve.id_alumno,(vd.precio-vd.descuento) AS monto,ve.cod_venta
                FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE vd.id_venta=" . $dato['id_venta'] . " AND vd.cod_producto='FV10'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_venta_detalle($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta_empresa_detalle (id_venta,cod_producto,precio,descuento,
                cantidad,estado,fec_reg,user_reg) 
                SELECT '" . $dato['id_venta'] . "',cod_producto,precio,descuento,cantidad,2,
                NOW(),$id_usuario 
                FROM nueva_venta_empresa_producto 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function valida_venta_detalle()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_tipo FROM nueva_venta_empresa_producto 
        WHERE id_empresa=6 AND id_usuario=$id_usuario and 
        id_tipo = 1 ";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_fotocheck($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO fotocheck (Id,Fecha_Pago_Fotocheck,Monto_Pago_Fotocheck,Doc_Pago_Fotocheck,
                esta_fotocheck,fec_reg,user_reg)
                VALUES ('" . $dato['id_alumno'] . "',DATE(NOW()),'" . $dato['monto'] . "','" . $dato['cod_venta'] . "',0,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_nueva_venta($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "DELETE FROM nueva_venta_empresa 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql);

        $sql2 = "DELETE FROM nueva_venta_empresa_producto 
                WHERE id_empresa=6 AND id_usuario=$id_usuario";
        $this->db->query($sql2);
    }

    function get_list_venta($id_venta = null)
    {
        if (isset($id_venta) && $id_venta > 0) {
            $sql = "SELECT ve.id_venta,ve.codigo,ve.cod_venta,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha,
                    DATE_FORMAT(ve.fec_reg,'%H:%i') AS hora,us.usuario_codigo,mf.Codigo AS cod_alumno,
                    CONCAT(mf.Apellido_Paterno,' ',mf.Apellido_Materno,', ',mf.Nombre) AS nom_alumno,
                    mf.Especialidad,CASE WHEN ve.estado_venta=3 THEN 'Devolución' ELSE 'Recibo' 
                    END AS nro_documento,CASE WHEN ve.estado_venta=3 THEN 'blanco' ELSE 'negro' END AS color_logo 
                    FROM venta_empresa ve
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    LEFT JOIN todos_l20 mf ON mf.Id=ve.id_alumno
                    WHERE ve.id_venta=$id_venta";
        } else {
            $sql = "SELECT * FROM venta_empresa 
                    WHERE pendiente=0 AND estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_venta_detalle($id_venta)
    {
        $sql = "SELECT vd.cod_producto,pv.nom_sistema,tv.cod_tipo,vd.precio,vd.descuento,vd.cantidad
                FROM venta_empresa_detalle vd
                LEFT JOIN producto_venta pv ON pv.cod_producto=vd.cod_producto AND pv.estado=2
                LEFT JOIN tipo_venta tv ON tv.id_tipo=pv.id_tipo
                WHERE vd.id_venta=$id_venta";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_valida_detalle($id_venta)
    {
        $sql = "select id_venta from venta_empresa_detalle where cod_producto in (select cod_producto from producto_venta where id_tipo='1' and estado='2')
                and id_venta=$id_venta";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_archivo_adjunto_horario($id_grupo, $imagen)
    {
        if ($imagen == "1") {
            $sql = "UPDATE grupo_calendarizacion SET horario_grupo='' 
                    WHERE id_grupo='$id_grupo'";
        } else if ($imagen == "2") {
            $sql = "UPDATE grupo_calendarizacion SET horario_grupo_cel='' 
                    WHERE id_grupo='$id_grupo'";
        } else {
            $sql = "UPDATE grupo_calendarizacion SET horario_pdf='' 
                    WHERE id_grupo='$id_grupo'";
        }
        $this->db->query($sql);
    }
    //-----------------------------------CIERRES DE CAJA-------------------------------------
    function get_list_cierre_caja($tipo)
    {
        $parte = "";
        if ($tipo == 1) {
            $parte = "AND MONTH(ci.fecha)=MONTH(CURDATE()) AND YEAR(ci.fecha)=YEAR(CURDATE())";
        }

        $sql = "SELECT ci.id_cierre_caja,ci.fecha,um.usuario_codigo AS cod_vendedor,
                DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,ci.saldo_automatico,ci.monto_entregado,
                ci.productos,(ci.saldo_automatico-ci.monto_entregado) AS diferencia,
                un.usuario_codigo AS cod_entrega,DATE_FORMAT(ci.fec_reg,'%d-%m-%Y') AS fecha_registro,
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
                ELSE '' END AS nom_estado,ci.estado,
                /*CASE WHEN MONTH(ci.fecha)=1 THEN CONCAT('ene-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=2 THEN CONCAT('feb-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=3 THEN 
                CONCAT('mar-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=4 THEN CONCAT('abr-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=5 THEN CONCAT('may-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=6 THEN 
                CONCAT('jun-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=7 THEN CONCAT('jul-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=8 THEN CONCAT('ago-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=9 THEN 
                CONCAT('set-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=10 THEN CONCAT('oct-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=11 THEN CONCAT('nov-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=12 THEN 
                CONCAT('dic-',YEAR(ci.fecha)) ELSE '' END AS mes_anio*/ ci.fecha AS mes_anio
                FROM cierre_caja_empresa ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN users ur ON ur.id_usuario=ci.user_reg
                WHERE ci.id_empresa=6 AND ci.estado NOT IN (4) $parte
                ORDER BY ci.fecha ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_codigo()
    {
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE tipo=1 AND estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_saldo_automatico($id_vendedor, $fecha)
    {
        $sql = "SELECT (IFNULL((SELECT SUM((vd.precio-vd.descuento)*vd.cantidad) FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND 
                ve.estado_venta=1 AND ve.id_empresa=6),0)-
                IFNULL((SELECT SUM((vd.precio-vd.descuento)*vd.cantidad) FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta 
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND 
                ve.estado_venta=3 AND ve.id_empresa=6),0)) AS saldo_automatico";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_productos($id_vendedor, $fecha)
    {
        $sql = "SELECT IFNULL((SELECT SUM(vd.cantidad) FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND 
                ve.estado_venta=1 AND ve.id_empresa=6),0)-
                IFNULL((SELECT SUM(vd.cantidad) FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta 
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND 
                ve.estado_venta=3 AND ve.id_empresa=6),0) AS productos";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_cierre_caja($dato)
    {
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=6 AND id_vendedor='" . $dato['id_vendedor'] . "' AND 
                fecha='" . $dato['fecha'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_venta_cierre_caja($dato)
    {
        $sql = "SELECT COUNT(*) AS cantidad FROM venta_empresa
                WHERE estado=2 AND user_reg='" . $dato['id_vendedor'] . "' AND 
                DATE(fec_reg)='" . $dato['fecha_valida'] . "' AND id_empresa=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_ultimo_cierre_caja($dato)
    {
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=6 AND id_vendedor='" . $dato['id_vendedor'] . "' AND 
                fecha=DATE_SUB('" . $dato['fecha'] . "',INTERVAL 1 DAY) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cierre_caja($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cierre_caja_empresa (id_empresa,id_sede,id_vendedor,fecha,
                saldo_automatico,monto_entregado,id_entrega,cofre,productos,cerrada,
                estado,fec_reg,user_reg)  
                VALUES (6,9,'" . $dato['id_vendedor'] . "','" . $dato['fecha'] . "',
                '" . $dato['saldo_automatico'] . "','" . $dato['monto_entregado'] . "',
                '" . $dato['id_entrega'] . "','" . $dato['cofre'] . "','" . $dato['productos'] . "',
                1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_cierre_caja()
    {
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=6
                ORDER BY id_cierre_caja DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_cierre_caja($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja_empresa SET monto_entregado='" . $dato['monto_entregado'] . "',
                id_entrega='" . $dato['id_entrega'] . "',cofre='" . $dato['cofre'] . "',
                fec_reg=NOW(),user_reg=$id_usuario,fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='" . $dato['id_cierre_caja'] . "'";
        $this->db->query($sql);
    }

    function get_id_cierre_caja($id_cierre_caja)
    {
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
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_cierre_caja($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_cierre_caja='" . $dato['id_cierre_caja'] . "'";
        $this->db->query($sql);
    }

    function get_list_detalle_cierre_caja($fecha)
    {
        $sql = "SELECT td.Codigo,td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,vd.cod_producto,
                vd.precio*vd.cantidad-vd.descuento AS total,ve.cod_venta,
                DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo
                FROM venta_empresa_detalle vd
                LEFT JOIN venta_empresa ve ON ve.id_venta=vd.id_venta
                LEFT JOIN todos_l20 td ON td.Id=ve.id_alumno
                LEFT JOIN users us ON us.id_usuario=ve.user_reg
                WHERE DATE(ve.fec_reg)='$fecha' AND ve.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_cofre_cierre_caja($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja_empresa SET cofre='" . $dato['cofre'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='" . $dato['id_cierre_caja'] . "'";

        $this->db->query($sql);
    }
    //---- DOCUMENTO - IFV ONLINE 

    function get_list_documento_configuracion($id_documento = null)
    {
        if (isset($id_documento) && $id_documento > 0) {
            $sql = "SELECT dc.*,sg.nom_status
                    FROM documento_configuracion_ifv dc
                    left join status_general sg on sg.id_status_general= dc.tipo and sg.id_status_mae='10' 
                    where id_documento='$id_documento'";
        } else {
            $sql = "SELECT dc.*,sg.nom_status
                    FROM documento_configuracion_ifv dc
                    left join status_general sg on sg.id_status_general= dc.tipo and sg.id_status_mae='10'
                    where dc.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_documento_configuracion($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_documento!='" . $dato['id_documento'] . "'";
        }
        $sql = "SELECT * FROM documento_configuracion_ifv where codigo='" . $dato['codigo'] . "' and estado=2 $v";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_configuracion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_configuracion_ifv (codigo,nombre,asunto,tipo,texto,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['codigo'] . "','" . $dato['nombre'] . "','" . $dato['asunto'] . "','" . $dato['id_tipo'] . "','" . $dato['texto'] . "',2,NOW(),'$id_usuario')";
        echo ($sql);
        $this->db->query($sql);
    }

    function update_documento_configuracion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_configuracion_ifv 
                SET codigo='" . $dato['codigo'] . "',nombre='" . $dato['nombre'] . "',asunto='" . $dato['asunto'] . "',
                tipo='" . $dato['id_tipo'] . "',texto='" . $dato['texto'] . "',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }

    function delete_documento_configuracion($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_configuracion_ifv SET estado='1',fec_eli=NOW(),user_eli=$id_usuario WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
    }

    // TEXTO FUT - IFV ONLINE
    function get_list_texto_fut($id_texto = null)
    {
        if (isset($id_texto) && $id_texto > 0) {
            $sql = "SELECT * FROM texto_fut where id_texto='$id_texto'";
        } else {
            $sql = "SELECT tf.id_texto, tf.asunto, tf.id_producto, tf.texto, pv.nom_sistema
                    FROM texto_fut tf
                    INNER JOIN producto_venta pv ON pv.id_producto = tf.id_producto
                    INNER JOIN tipo_venta tp ON tp.id_tipo = pv.id_tipo
                    WHERE tp.id_tipo = 1 AND tf.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_venta_fut()
    {
        $sql = "SELECT pv.id_producto ,pv.nom_sistema
                FROM producto_venta pv
                INNER JOIN tipo_venta tv ON tv.id_tipo = pv.id_tipo 
                WHERE tv.id_tipo = 1 and pv.estado in (2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_texto_fut($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = "and asunto='" . $dato['asunto'] . "' and id_texto!='" . $dato['id_texto'] . "' ";
        }
        $sql = "SELECT * FROM texto_fut WHERE estado=2 and id_producto='" . $dato['id_producto'] . "' $v";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_texto_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO texto_fut(id_producto,asunto,texto,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_producto'] . "','" . $dato['asunto'] . "','" . $dato['texto'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_texto_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE texto_fut SET id_producto='" . $dato['id_producto'] . "', asunto='" . $dato['asunto'] . "', texto='" . $dato['texto'] . "',fec_act=NOW(),user_act=$id_usuario WHERE id_texto='" . $dato['id_texto'] . "'";
        $this->db->query($sql);
    }

    function delete_texto_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE texto_fut SET estado='1', fec_eli=NOW(), user_eli=$id_usuario WHERE id_texto='" . $dato['id_texto'] . "'";
        $this->db->query($sql);
    }

    function valida_cod_aleatorio_venta_ifv($dato)
    {
        $sql = "SELECT * FROM venta_empresa WHERE codigo='" . $dato['code'] . "' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    //------------------------------Lista venta ifv---------------------------
    function get_list_venta_ifv()
    {
        $sql = "SELECT ve.id_venta,ve.cod_venta,ve.codigo AS cod_aleatorio,t.Codigo,t.Apellido_Paterno,
                t.Apellido_Materno,t.Nombre,t.Especialidad,es.Abreviatura,t.Grupo,t.Seccion,
                (ve.monto_entregado - ve.cambio) as monto_entregado,
                DATE_FORMAT(ve.fec_reg ,'%d/%m/%Y') as fecha_pago,
                (SELECT GROUP_CONCAT(pv.nom_sistema SEPARATOR ', ') 
                FROM venta_empresa_detalle vd
                LEFT JOIN producto_venta pv ON pv.cod_producto=vd.cod_producto AND pv.estado=2
                WHERE vd.id_venta=ve.id_venta) AS productos,
                (SELECT GROUP_CONCAT(tv.descripcion SEPARATOR ', ') 
                FROM venta_empresa_detalle vd
                LEFT JOIN producto_venta pv ON pv.cod_producto=vd.cod_producto AND pv.estado=2
                left join tipo_venta tv on tv.id_tipo=pv.id_tipo AND pv.estado=2
                WHERE vd.id_venta=ve.id_venta) as tipos
                FROM venta_empresa ve
                LEFT JOIN todos_l20 t ON t.Id = ve.id_alumno
                left join especialidad es on es.nom_especialidad = t.especialidad and es.estado=2
                WHERE ve.estado = 2 AND ve.id_empresa = 6 AND ve.pendiente=0
                ORDER BY ve.cod_venta ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //------------------------------Lista Fut Recibidos---------------------------
    function get_fut_recibidos($dato = null)
    {
        $par = '';
        if ($dato['cod_val'] == "0") {
            $par = "and ef.u_estado in (69,65)";
        }
        $sql = "SELECT ef.*, sg.nom_status,substring(ef.fec_reg,1,10) as Fecha_envio,
                concat(SUBSTRING_INDEX(texto_fut,' ',length(left(texto_fut,16))-length(replace(left(texto_fut,16),' ',''))),' ...') as texto_fut_corto
                FROM envio_fut_ifv ef
                left join status_general sg on sg.id_status_general = ef.u_estado and sg.id_status_mae = 9
                WHERE ef.estado = 2 AND ef.id_empresa = 6 $par";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function get_fut_recibido_id($dato)
    {
        $sql = "SELECT e.*,es.abreviatura,td.Grupo,
                (SELECT ci.ciclo FROM ciclo ci 
                LEFT JOIN grupo_calendarizacion gc ON gc.id_ciclo=ci.id_ciclo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                WHERE gc.grupo=td.Grupo AND es.nom_especialidad=td.Especialidad AND 
                mo.modulo=td.Modulo AND gc.id_seccion=td.Seccion
                LIMIT 1) AS Ciclo,td.Seccion,cie.correo as Correo_Institucional
                FROM envio_fut_ifv e
                left join especialidad es on es.nom_especialidad=e.Especialidad and es.estado='2'
                LEFT JOIN todos_l20 td ON td.Id=e.Id
                LEFT JOIN correo_inst_empresa cie ON cie.id_alumno=td.Id AND cie.id_empresa=6
                WHERE e.estado = 2 AND e.id_empresa = 6 and e.id_envio='" . $dato['id_envio'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------CALENDARIO-------------------------------------
    function get_list_calendario($tipo)
    {
        if ($tipo == 1) {
            $parte = "AND ca.estado=2";
        } else {
            $parte = "AND ca.estado NOT IN (4)";
        }
        $sql = "SELECT ca.id_calendar_festivo,ca.inicio,ca.anio,
                DATE_FORMAT(ca.inicio,'%d-%m-%Y') AS fecha,ca.nom_dia,ca.descripcion,
                tf.nom_tipo_fecha,CASE WHEN ca.fijo_variable=1 THEN 'Fijo' 
                WHEN ca.fijo_variable=2 THEN 'Variable' ELSE '' END AS f_v,
                ca.observaciones,st.nom_status,st.color
                FROM calendar_festivo ca
                LEFT JOIN tipo_fecha tf ON tf.id_tipo_fecha=ca.id_tipo_fecha
                LEFT JOIN status st ON ca.estado=st.id_status
                WHERE ca.id_empresa=6 $parte
                ORDER BY ca.inicio ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cantidad_examen_efsrt_ifv()
    {
        $sql = "select * from examen_efsrt_ifv";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function valida_examen_efsrt_ifv($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_examen!='" . $dato['id_examen'] . "'";
        }
        $sql = "SELECT * from examen_efsrt_ifv where estado=2 and nom_examen='" . $dato['nom_examen'] . "' and fec_limite='" . $dato['fec_limite'] . "'
        and fec_resultados='" . $dato['fec_resultados'] . "' $v";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function insert_carrera_examen_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO examen_carrera_efsrt_ifv (id_examen,id_carrera,estado,fec_reg,user_reg) 
                VALUES ((select id_examen from examen_efsrt_ifv where cod_examen='" . $dato['cod_examen'] . "'),'" . $dato['id_carrera'] . "',2,NOW(),
                $id_usuario)";
        $this->db4->query($sql);
    }

    function delete_carrera_examen_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE examen_carrera_efsrt_ifv SET estado=1,fec_eli=NOW(),user_eli=$id_usuario WHERE id_examen='" . $dato['id_examen'] . "' and estado=2";
        $this->db4->query($sql);
    }

    function get_list_carrera_examen_efsrt($id_examen)
    {
        /*$sql ="SELECT p.id_examen, p.id_area,count(p.id_examen) AS cantidad 
                FROM pregunta_admision_efsrt p
                where p.estado='2' and p.id_examen='$id_examen'
                group by p.id_examen,p.id_area";*/
        $sql = "SELECT a.*, (select count(*) from pregunta_admision_efsrt p where p.id_carrera=a.id_carrera and p.id_examen='$id_examen' and p.estado=2) as cantidad
        FROM examen_carrera_efsrt_ifv a
        where a.estado='2' and a.id_examen='$id_examen'";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function delete_archivo_pregunta_efsrt($dato)
    {
        $sql = "UPDATE pregunta_admision_efsrt SET img='' WHERE id_pregunta='" . $dato['id_pregunta'] . "'";

        $this->db4->query($sql);
    }

    function consulta_preguntas_excluidas_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT group_concat(distinct r.id_respuesta) as respuestas from respuesta_admision_efsrt  r
        left join pregunta_admision_efsrt p on r.id_pregunta=p.id_pregunta and p.estado=2
         where p.id_examen='" . $dato['id_examen'] . "' and p.id_carrera not in (" . $dato['carrera_cadena'] . ") and p.estado=2 
         and r.estado=2";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function delete_preguntas_excluidas_efsrt_ifv($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE pregunta_admision_efsrt set estado='4', fec_eli= NOW(),user_eli=$id_usuario
                where id_examen='" . $dato['id_examen'] . "' and id_carrera not in (" . $dato['carrera_cadena'] . ") and estado=2";
        $this->db4->query($sql);

        $sql = " UPDATE respuesta_admision_efsrt set estado='4', fec_eli= NOW(),user_eli=$id_usuario
                where id_respuesta in (" . $dato['consulta'][0]['respuestas'] . ")";
        $this->db4->query($sql);
    }
    //-----------------------------------------------CONTRATO EFSRT------------------------------------------
    function get_list_contrato_efsrt($tipo)
    {
        $parte = "";
        if ($tipo == 1) {
            $parte = "AND df.estado_d=2";
        }
        $sql = "SELECT df.id_documento_firma,df.fecha_envio,df.fecha_firma,df.id_alumno,df.cod_alumno,
                df.apater_alumno,df.amater_alumno,df.nom_alumno,df.email_alumno,df.celular_alumno,
                DATE_FORMAT(df.fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(df.fecha_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                DATE_FORMAT(df.fecha_firma,'%H:%i') AS hora_firma,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' 
                WHEN df.estado_d=3 THEN 'Firmado'
                WHEN df.estado_d=4 THEN 'Validado' END AS nom_status,
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000'
                WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status,co.referencia,
                CASE WHEN df.arpay=1 THEN 'Si' ELSE 'No' END v_arpay,df.estado_d,df.arpay,
                df.especialidad_alumno,df.grupo_alumno,df.turno_alumno,df.modulo_alumno,
                df.seccion_fv_alumno
                FROM documento_firma df
                LEFT JOIN nuevos_fv nf ON nf.Id=df.id_alumno
                LEFT JOIN c_contrato co ON co.id_c_contrato=df.id_contrato
                WHERE df.efsrt=1 AND df.estado=2 $parte
                ORDER BY nf.Apellido_Paterno ASC,nf.Apellido_Materno ASC,nf.Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_contratos_activos_efsrt()
    {
        $sql = "SELECT cc.*,tc.fecha_envio AS v_fecha_envio 
                FROM c_contrato cc
                LEFT JOIN tipo_contrato tc ON tc.id_tipo=cc.tipo
                WHERE cc.id_empresa=6 AND tc.alumno=2 AND cc.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_todos_l20($id_alumno)
    {
        $sql = "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,
                Celular AS celular_alumno,Grupo AS grupo_alumno,
                Especialidad AS especialidad_alumno,Turno AS turno_alumno,
                Modulo AS modulo_alumno,Seccion AS seccion_alumno
                FROM todos_l20 
                WHERE Id=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_contrato_tipo_2($id_grupo, $id_especialidad, $id_turno, $id_modulo, $id_seccion)
    {
        $parte_grupo = "";
        $parte_especialidad = "";
        $parte_turno = "";
        $parte_modulo = "";
        $parte_seccion = "";
        if ($id_grupo != "0") {
            $parte_grupo = "AND Grupo='" . $id_grupo . "'";
        }
        if ($id_especialidad != "0") {
            $parte_especialidad = "AND Especialidad='" . $id_especialidad . "'";
        }
        if ($id_turno != "0") {
            $parte_turno = "AND Turno='" . $id_turno . "'";
        }
        if ($id_modulo != "0") {
            $parte_modulo = "AND Modulo='" . $id_modulo . "'";
        }
        if ($id_seccion != "0") {
            $parte_seccion = "AND Seccion='" . $id_seccion . "'";
        }

        $sql = "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,
                Celular AS celular_alumno,Grupo AS grupo_alumno,Especialidad AS especialidad_alumno,
                Turno AS turno_alumno,Modulo AS modulo_alumno,Seccion AS seccion_alumno
                FROM todos_l20
                WHERE Tipo=1 AND Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 $parte_grupo $parte_especialidad 
                $parte_turno $parte_modulo $parte_seccion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_firma_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_firma (efsrt,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,modulo_alumno,
                seccion_fv_alumno,id_empresa,enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg) 
                VALUES (1,'" . $dato['id_alumno'] . "','" . $dato['cod_alumno'] . "','" . $dato['apater_alumno'] . "',
                '" . $dato['amater_alumno'] . "','" . $dato['nom_alumno'] . "','" . $dato['email_alumno'] . "',
                '" . $dato['celular_alumno'] . "','" . $dato['grupo_alumno'] . "','" . $dato['especialidad_alumno'] . "',
                '" . $dato['turno_alumno'] . "','" . $dato['modulo_alumno'] . "','" . $dato['seccion_alumno'] . "',6,1,
                NOW(),'" . $dato['id_contrato'] . "',2,2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_list_grupo_c_activo($tipo, $dato)
    {
        $grupo = "";
        if ($tipo == 1) {
            $grupo = "group by gc.grupo";
        }
        if ($tipo == 2) {
            $grupo = "and gc.grupo='" . $dato['grupo'] . "' group by es.nom_especialidad";
        }
        if ($tipo == 3) {
            $grupo = "and gc.grupo='" . $dato['grupo'] . "' and gc.id_especialidad='" . $dato['especialidad'] . "' group by mo.modulo";
        }
        if ($tipo == 4) {
            $grupo = "and gc.id_modulo='" . $dato['modulo'] . "' and gc.grupo='" . $dato['grupo'] . "' and gc.id_especialidad='" . $dato['especialidad'] . "' group by ci.ciclo";
        }
        if ($tipo == 5) {
            $grupo = "and gc.id_ciclo='" . $dato['ciclo'] . "' and gc.id_modulo='" . $dato['modulo'] . "' and gc.grupo='" . $dato['grupo'] . "' and gc.id_especialidad='" . $dato['especialidad'] . "' group by h.nom_turno";
        }
        if ($tipo == 6) {
            $grupo = "and gc.id_turno='" . $dato['turno'] . "' and gc.id_ciclo='" . $dato['ciclo'] . "' and gc.id_modulo='" . $dato['modulo'] . "' and gc.grupo='" . $dato['grupo'] . "' and gc.id_especialidad='" . $dato['especialidad'] . "' group by gc.id_seccion";
        }
        $sql = "SELECT gc.*,DATE_FORMAT(gc.inicio_clase,'%d/%m/%Y') AS ini_clases,
                DATE_FORMAT(gc.fin_clase,'%d/%m/%Y') AS fin_clases,es.nom_especialidad, es.abreviatura,
                mo.modulo,ci.ciclo,CASE WHEN gc.estado_grupo=1 THEN 'Activo' WHEN gc.estado_grupo=2 THEN 'Inactivo' ELSE 'Terminado' 
                END AS nom_estado_grupo,
                CASE WHEN gc.estado_grupo=1 THEN '#92D050' WHEN gc.estado_grupo=2 THEN '#C00000' ELSE '#0070C0' 
                END AS color_estado_grupo,  
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND 
                ma.Matricula='Asistiendo' AND ma.Alumno='Matriculado') AS matriculados,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND
                ma.Matricula='Retirado' AND ma.Alumno='Retirado') AS retirados,
                (SELECT COUNT(*) FROM todos_l20 ma 
                WHERE ma.Tipo=1 AND ma.Grupo=gc.grupo AND ma.Especialidad=es.nom_especialidad AND ma.Seccion=gc.id_seccion AND 
                ma.Matricula='Promovido' AND ma.Alumno='Matriculado') AS promovidos,
                TIMESTAMPDIFF(MONTH,CURDATE(),gc.fin_clase) AS diferencia_meses,sa.descripcion AS nom_salon,
                CASE WHEN (gc.horario_grupo!='' AND gc.horario_grupo IS NOT NULL) AND 
                (gc.horario_grupo_cel!='' AND gc.horario_grupo_cel IS NOT NULL) THEN 'Si' ELSE 'No' END AS imagenes,
                CASE WHEN gc.salir_matriculados=1 THEN 'Si' ELSE 'No' END AS s_matriculados,sa.disponible,mo.modulo,ci.ciclo,h.nom_turno
                FROM grupo_calendarizacion gc 
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo 
                LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo
                LEFT JOIN salon sa ON sa.id_salon=gc.id_salon
                left join turno t on gc.id_turno=t.id_turno
                left join hora h on t.id_hora=h.id_hora
                WHERE gc.estado=2 
                AND gc.estado_grupo not in (4) AND (gc.estado_grupo=1 OR TIMESTAMPDIFF(DAY,gc.fin_clase,CURDATE())<=14 OR 
                    (CURDATE() BETWEEN gc.inicio_clase AND gc.fin_clase) OR 
                    (TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase)>=0 AND TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase)<=14))

                $grupo
                ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_grupo_c_invitar($dato)
    {
        if ($dato['alumno'] != "") {
            $sql = "SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Matricula,Alumno,Dni,Email,Especialidad,Grupo,Celular
            FROM todos_l20 WHERE Id in (" . $dato['alumno'] . ")";
        } else {
            $sql = "SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Matricula,Alumno,Dni,Email,Especialidad,Grupo,Celular
            FROM todos_l20 
            WHERE Tipo=1 AND Grupo='" . $dato['grupo'] . "' AND Especialidad='" . $dato['especialidad'] . "' AND Seccion='" . $dato['seccion'] . "'";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_especialidad_xnombre($dato)
    {
        $sql = "SELECT e.* from especialidad e where e.estado=2 and nom_especialidad='" . $dato['carrera'] . "' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------------TIPO CONTRATO-------------------------------------------
    function get_list_tipo_c_contrato($id_tipo = null)
    {
        if (isset($id_tipo) && $id_tipo > 0) {
            $sql = "SELECT * FROM tipo_contrato 
                    WHERE id_tipo=$id_tipo";
        } else {
            $sql = "SELECT tc.id_tipo,tc.nom_tipo,CASE WHEN tc.alumno=1 THEN 'Admisión' 
                    WHEN tc.alumno=2 THEN 'Matriculado' ELSE '' END AS alumno,
                    CASE WHEN tc.fecha_envio=1 THEN 'Si' ELSE 'No' END AS fecha_envio,
                    st.nom_status,st.color
                    FROM tipo_contrato tc
                    LEFT JOIN status st ON st.id_status=tc.estado
                    WHERE tc.estado NOT IN (4)
                    ORDER BY tc.nom_tipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_tipo_c_contrato()
    {
        $sql = "SELECT id_tipo,CASE WHEN alumno=1 THEN CONCAT(nom_tipo,' - Trámites') 
                WHEN alumno=2 THEN CONCAT(nom_tipo,' - EFSRT') ELSE nom_tipo END AS nom_tipo,alumno,
                fecha_envio
                FROM tipo_contrato
                WHERE estado=2
                ORDER BY nom_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tipo_c_contrato($dato)
    {
        $sql = "SELECT id_tipo FROM tipo_contrato 
                WHERE nom_tipo='" . $dato['nom_tipo'] . "' AND alumno='" . $dato['alumno'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tipo_contrato (id_empresa,nom_tipo,alumno,fecha_envio,estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['nom_tipo'] . "','" . $dato['alumno'] . "','" . $dato['fecha_envio'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_tipo_c_contrato($dato)
    {
        $sql = "SELECT id_tipo FROM tipo_contrato 
                WHERE nom_tipo='" . $dato['nom_tipo'] . "' AND alumno='" . $dato['alumno'] . "' AND estado=2 AND
                id_tipo!='" . $dato['id_tipo'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tipo_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_contrato SET nom_tipo='" . $dato['nom_tipo'] . "',alumno='" . $dato['alumno'] . "',
                fecha_envio='" . $dato['fecha_envio'] . "',estado='" . $dato['estado'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_tipo='" . $dato['id_tipo'] . "'";
        $this->db->query($sql);
    }

    function delete_tipo_c_contrato($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_contrato SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_tipo='" . $dato['id_tipo'] . "'";
        $this->db->query($sql);
    }
    //-------------------------------------------------ASISTENCIA COLABORADOR----------------------------------
    function get_list_registro_ingreso_c($anio, $mes)
    {
        /*$sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
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
                CASE WHEN SUBSTRING(ri.codigo,-1,1)='C' THEN td.Cargo 
                WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
                THEN 'Invitado' ELSE 'Alumno' END AS nom_tipo_acceso,
                CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
                ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
                (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
                ELSE ue.usuario_codigo END AS usuario_registro
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND DATE(ri.ingreso) BETWEEN '$fec_in' AND '$fec_fi' AND 
                ri.codigo LIKE '%C%'
                ORDER BY ri.ingreso DESC";*/

        $sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
				(CASE DATENAME(dw,ri.ingreso)
					 when 'Monday' then 'Lunes'
					 when 'Tuesday' then 'Martes'
					 when 'Wednesday' then 'Miércoles'
					 when 'Thursday' then 'Jueves'
					 when 'Friday' then 'Viernes'
					 when 'Saturday' then 'Sábado'
					 when 'Sunday' then 'Domingo'
				END) as dia,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN (ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) and
                RIGHT(ri.codigo,1)!='C')
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
                CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
                WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
                WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.salida=2 THEN 'No Registrado'
                WHEN ri.salida=1 THEN 'Salida'
                ELSE (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
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
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND year(CONVERT(varchar,ri.ingreso,23)) = '$anio' AND month(CONVERT(varchar,ri.ingreso,23))='$mes' AND 
                ri.codigo LIKE '%C%'
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }


    function get_list_registro_ingreso_c_v2($anio, $mes)
    {

        /*$sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN (ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) and
                RIGHT(ri.codigo,1)!='C')
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,es.abreviatura,
                ri.grupo,ri.modulo,CASE WHEN (SELECT COUNT(1) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0 THEN 'Si' ELSE 'No' END AS obs,
                CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
                WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
                WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.salida=2 THEN 'No Registrado'
                WHEN ri.salida=1 THEN 'Salida'
                ELSE (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
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
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND year(CONVERT(varchar,ri.ingreso,23)) = '$anio' AND month(CONVERT(varchar,ri.ingreso,23))='$mes' AND 
                ri.codigo LIKE '%C%'
                ORDER BY ri.ingreso DESC";*/

        $sql = "SELECT a.id_docente,a.ingreso,a.ingreso AS orden,CONVERT(varchar,a.ingreso,103) AS fecha_ingreso,
        CONVERT(char(5),a.ingreso,108) AS hora_ingreso,a.codigo,a.apater,a.amater,a.nombres AS nombre,
        a.estado_ingreso,a.desde,a.hasta,a.tolerancia,a.fecha as fecha_ingreso
        from registro_asistencia_docente a where a.estado=2 and year(a.fecha)='$anio' and month(a.fecha)='$mes' ORDER BY a.fecha DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function excel_registro_ingreso_c($anio, $mes)
    {
        /*$sql = "SELECT * FROM vista_registro_ingreso 
                WHERE DATE(ingreso) BETWEEN '$fec_in' AND '$fec_fi' AND 
                codigo LIKE '%C%'";
        $query = $this->db5->query($sql)->result_Array();*/
        $sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.hora_salida,108) AS hora_salida,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,ri.codigo,ri.apater,ri.amater,
                CASE WHEN (ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) and
                RIGHT(ri.codigo,1)!='C')
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,
				(CASE WHEN hr.observacion IS NULL  THEN 'No' ELSE 'Sí' END) AS obs,
				hr.observacion as obs_historial,
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
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON td.Id=ri.id_alumno AND td.Tipo=2
                LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                WHERE ri.estado=2 AND year(CONVERT(varchar,ri.ingreso,23)) = '$anio' AND month(CONVERT(varchar,ri.ingreso,23))='$mes' AND 
                ri.codigo LIKE '%C%'
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function delete_postulante_efsrt($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE postulantes_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_postulante='" . $dato['id_postulante'] . "'";
        $this->db->query($sql);
    }

    function get_list_detalle_fut($dato)
    {
        $sql = "SELECT ef.*, sg.nom_status
                FROM envio_fut_ifv_detalle ef
                left join status_general sg on sg.id_status_general = ef.estado_envio_det
                WHERE ef.estado = 2 AND id_envio='" . $dato['id_envio'] . "'";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_fut_id($dato)
    {
        $sql = "SELECT * FROM envio_fut_ifv_detalle WHERE estado = 2 AND id_envio_det='" . $dato['id_envio_det'] . "'";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function insert_detalle_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d');
        $path = $_FILES['img_comuimg']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img_comuimg';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './imgfut_snappy';
        $config['file_name'] = "fut" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }

        $ruta = 'imgfut_snappy/' . $config['file_name'];

        $config['allowed_types'] = "pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path != "") {
            $sql = "INSERT INTO envio_fut_ifv_detalle (id_envio, estado_envio_det, observ_envio_det, pdf_envio_det,estado, fec_reg, user_reg) 
            VALUES ('" . $dato['id_envio'] . "','" . $dato['id_estado_i'] . "','" . $dato['observacion_i'] . "','$ruta' ,2,NOW(),$id_usuario)";
        } else {
            $sql = "INSERT INTO envio_fut_ifv_detalle (id_envio, estado_envio_det, observ_envio_det, estado, fec_reg, user_reg) 
            VALUES ('" . $dato['id_envio'] . "','" . $dato['id_estado_i'] . "','" . $dato['observacion_i'] . "',2,NOW(),$id_usuario)";
        }
        //echo($sql);
        $this->db->query($sql);

        $sql2 = "UPDATE envio_fut_ifv SET  u_estado='" . $dato['id_estado_i'] . "', fec_act=NOW(), user_act=$id_usuario WHERE id_envio='" . $dato['id_envio'] . "'";
        $this->db->query($sql2);

        $sql3 = "UPDATE venta_empresa set estado_recibido='" . $dato['id_estado_i'] . "' WHERE codigo=(select id_venta_empresa from envio_fut_ifv where id_envio='" . $dato['id_envio'] . "')";
        $this->db->query($sql3);
    }

    function update_detalle_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $fecha = date('Y-m-d');
        $path = $_FILES['img_comuimge']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'img_comuimge';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './imgfut_snappy';
        $config['file_name'] = "fut" . $fecha . "_" . rand(1, 200) . "." . $ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }

        $ruta = 'imgfut_snappy/' . $config['file_name'];

        $config['allowed_types'] = "pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();
        //var_dump($_FILES['img_comuimge']['name']);
        if ($path != "") {
            $sql = "UPDATE envio_fut_ifv_detalle SET  estado_envio_det='" . $dato['id_estado_e'] . "' ,observ_envio_det='" . $dato['observacion_e'] . "', 
            pdf_envio_det='$ruta',fec_act=NOW(), user_act=$id_usuario WHERE id_envio_det='" . $dato['id_envio_det'] . "'";
        } else {
            $sql = "UPDATE envio_fut_ifv_detalle SET  estado_envio_det='" . $dato['id_estado_e'] . "' ,observ_envio_det='" . $dato['observacion_e'] . "', 
            fec_act=NOW(), user_act=$id_usuario WHERE id_envio_det='" . $dato['id_envio_det'] . "'";
        }
        $this->db->query($sql);

        $sql2 = "UPDATE envio_fut_ifv SET  u_estado='" . $dato['id_estado_e'] . "', fec_act=NOW(), user_act=$id_usuario WHERE id_envio='" . $dato['id_envio'] . "'";
        $this->db->query($sql2);

        $sql3 = "UPDATE venta_empresa set estado_recibido='" . $dato['id_estado_e'] . "' WHERE codigo=(select id_venta_empresa from envio_fut_ifv where id_envio='" . $dato['id_envio'] . "')";
        $this->db->query($sql3);
    }

    function delete_detalle_fut($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE envio_fut_ifv_detalle SET estado='1', fec_eli=NOW(), user_eli=$id_usuario WHERE id_envio_det='" . $dato['id_historial'] . "'";
        $this->db->query($sql);
    }

    function get_id_fut_recibido($id_envio_det)
    {
        $sql = "SELECT * FROM envio_fut_ifv_detalle WHERE id_envio_det=$id_envio_det";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function get_list_estados()
    {
        $sql = "SELECT * FROM status_general WHERE id_status_mae=9 and id_status_general in (66,67,69,70)";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function get_list_ultimo_estado_id($dato)
    {
        $sql = "SELECT estado_envio_det from envio_fut_ifv_detalle where id_envio='" . $dato['id_fut'] . "' and estado=2 order by id_envio_det desc limit 1";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function update_ultimo_estado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql2 = "UPDATE envio_fut_ifv SET u_estado='" . $dato['estado_ultimo'][0]['estado_envio_det'] . "', fec_act=NOW(), user_act=$id_usuario WHERE id_envio='" . $dato['id_fut'] . "'";
        //echo($sql2);
        $this->db->query($sql2);

        $sql3 = "UPDATE venta_empresa set estado_recibido='" . $dato['estado_ultimo'][0]['estado_envio_det'] . "' WHERE codigo=(select id_venta_empresa from envio_fut_ifv where id_envio='" . $dato['id_fut'] . "')";
        $this->db->query($sql3);
    }
    //-----------------------------------CORREO EFSRT-------------------------------------
    function get_list_correo_efsrt($id_correo = null)
    {
        if (isset($id_correo) && $id_correo > 0) {
            $sql = "SELECT ce.*,SUBSTRING_INDEX(ce.documento,'/',-1) AS nom_documento,
                    ti.nom_tipo
                    FROM correo_efsrt ce
                    LEFT JOIN tipo_correo_efsrt ti ON ti.id_tipo=ce.id_tipo
                    WHERE ce.id_correo=$id_correo";
        } else {
            $sql = "SELECT ce.id_correo,ti.nom_tipo,es.nom_especialidad,ce.asunto,ce.texto,
                    ce.documento
                    FROM correo_efsrt ce
                    LEFT JOIN tipo_correo_efsrt ti ON ti.id_tipo=ce.id_tipo
                    LEFT JOIN especialidad es ON es.id_especialidad=ce.id_especialidad
                    WHERE ce.estado=2
                    ORDER BY ti.nom_tipo ASC,es.nom_especialidad ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_correo_efsrt()
    {
        $sql = "SELECT * FROM tipo_correo_efsrt
                ORDER BY nom_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_tipo_correo_efsrt($id_tipo, $id_especialidad = null)
    {
        $parte = "";
        if (isset($id_especialidad) && $id_especialidad > 0) {
            $parte = "AND id_especialidad=$id_especialidad";
        }
        $sql = "SELECT asunto,texto FROM correo_efsrt
                WHERE id_tipo=$id_tipo $parte AND estado=2
                ORDER BY id_correo DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_correo_efsrt($dato)
    {
        $sql = "SELECT id_correo FROM correo_efsrt 
                WHERE id_tipo='" . $dato['id_tipo'] . "' AND 
                id_especialidad='" . $dato['id_especialidad'] . "' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_correo_efsrt()
    {
        $sql = "SELECT id_correo FROM correo_efsrt";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_correo_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO correo_efsrt (id_tipo,id_especialidad,asunto,texto,documento,estado,
                fec_reg,user_reg) 
                VALUES ('" . $dato['id_tipo'] . "','" . $dato['id_especialidad'] . "','" . $dato['asunto'] . "',
                '" . $dato['texto'] . "','" . $dato['documento'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_correo_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE correo_efsrt SET id_especialidad='" . $dato['id_especialidad'] . "',
                asunto='" . $dato['asunto'] . "',texto='" . $dato['texto'] . "',
                documento='" . $dato['documento'] . "',fec_act=NOW(),user_act=$id_usuario  
                WHERE id_correo='" . $dato['id_correo'] . "'";
        $this->db->query($sql);
    }

    function delete_correo_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE correo_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_correo='" . $dato['id_correo'] . "'";
        $this->db->query($sql);
    }
    //---------------------------------EFSRT----------------------------
    function get_list_efsrt($grupo = null, $id_especialidad = null, $id_modulo = null, $id_turno = null)
    {
        if (isset($grupo) && isset($id_especialidad) && isset($id_modulo) && isset($id_turno)) {
            $sql = "SELECT codigo_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS codigo,
                    es.abreviatura,gc.grupo,es.nom_especialidad,mo.modulo,
                    DATE_FORMAT(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),'%d-%m-%Y') AS inicio_efsrt,
                    DATE_FORMAT(termino_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),'%d-%m-%Y') AS termino_efsrt,
                    estado_efsrt (gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS estado,
                    seccion_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS seccion,
                    gc.id_especialidad,gc.id_modulo,gc.id_turno,ho.nom_turno,
                    case when ho.nom_turno='Mañana' then 'MN' when ho.nom_turno='Tarde' then 'TR' end as cod_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                    gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND gc.estado=2
                    LIMIT 1";
        } else {
            /*$sql = "SELECT gc.grupo,es.abreviatura,mo.modulo, 
                    DATE_FORMAT(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo)),'%d-%m-%Y') AS inicio_efsrt,
                    DATE_FORMAT(termino_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo)),'%d-%m-%Y') AS termino_efsrt,
                    matriculados_efsrt(gc.grupo,es.nom_especialidad,mo.modulo) AS matriculados,
                    gc.id_especialidad,gc.id_modulo
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    WHERE gc.estado=2 AND 
                    (gc.fin_clase>=CURDATE() OR (gc.fin_clase<=CURDATE() AND
                    TIMESTAMPDIFF(DAY,gc.fin_clase,CURDATE())<=42)) AND
                    (gc.inicio_clase<=CURDATE() OR (gc.inicio_clase>=CURDATE() AND
                    TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase)>=42)) AND 
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo)>0
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC";
            */

            $sql = "SELECT gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno,
                    DATE_FORMAT(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),'%d-%m-%Y') AS inicio_efsrt,
                    DATE_FORMAT(termino_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),'%d-%m-%Y') AS termino_efsrt,
                    matriculados_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS matriculados,
                    seccion_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS seccion,
                    induccion_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno) AS induccion,
                    CASE WHEN SUBSTRING_INDEX(induccion_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno),'/',1)=
                    SUBSTRING_INDEX(induccion_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno),'/',-1) THEN '#00C000'
                    ELSE '#C00000' END AS color_induccion,gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON gc.id_especialidad=es.id_especialidad
                    LEFT JOIN modulo mo ON gc.id_modulo=mo.id_modulo
                    LEFT JOIN turno tu ON gc.id_turno=tu.id_turno
                    LEFT JOIN hora ho ON tu.id_hora=ho.id_hora
                    WHERE gc.estado=2 AND gc.estado_grupo NOT IN (2,4,5,6) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 28 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 28 DAY) AND
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)>0
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        /*SELECT td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,td.Codigo,td.Matricula,
                td.Alumno,td.Dni,documentos_obligatorios_fv(td.Especialidad) AS documentos_obligatorios,
                documentos_subidos_fv(td.Especialidad,td.Id) AS documentos_subidos
                FROM todos_l20 td
                WHERE td.Tipo=1 AND td.Grupo='$grupo' AND Especialidad='$especialidad' AND td.Modulo='$modulo' AND 
                td.Alumno='Matriculado' AND td.Matricula='Asistiendo'
                ORDER BY td.Apellido_Paterno ASC,td.Apellido_Materno ASC,td.Nombre ASC*/

        $sql = "SELECT ag.apellido_paterno AS Apellido_Paterno,
                ag.apellido_materno AS Apellido_Materno,ag.nombres AS Nombre,
                ag.codigo AS Codigo,ag.matricula AS Matricula,ag.alumno AS Alumno,
                ag.dni AS Dni,documentos_obligatorios_fv(es.nom_especialidad) AS documentos_obligatorios,
                documentos_subidos_fv(es.nom_especialidad,ag.id_alumno) AS documentos_subidos
                FROM alumno_grupo ag
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND ag.alumno='Matriculado' AND 
                ag.matricula='Asistiendo'
                ORDER BY ag.apellido_paterno ASC,ag.apellido_materno ASC,ag.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_retirado_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        /*$sql = "SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Matricula,Alumno,Dni
                FROM todos_l20 
                WHERE Tipo=1 AND Grupo='$grupo' AND Especialidad='$especialidad' AND Modulo='$modulo' AND
                Alumno='Retirado'
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC";*/

        $sql = "SELECT ag.apellido_paterno AS Apellido_Paterno,
                ag.apellido_materno AS Apellido_Materno,ag.nombres AS Nombre,
                ag.codigo AS Codigo,ag.matricula AS Matricula,ag.alumno AS Alumno,
                ag.dni AS Dni
                FROM alumno_grupo ag
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
                WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND ag.alumno='Retirado' AND 
                ag.estado=2
                ORDER BY ag.apellido_paterno ASC,ag.apellido_materno ASC,ag.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_induccion_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT di.id_detalle,di.apater_alumno,di.amater_alumno,di.nom_alumno,
                di.cod_alumno,
                DATE_FORMAT(ie.fecha_charla,'%d-%m-%Y') AS fecha_charla,
                DATE_FORMAT(ie.hora_charla,'%H:%i') AS hora_charla,
                up.usuario_codigo AS ponente,ur.usuario_codigo AS usuario,
                DATE_FORMAT(di.fec_reg,'%d-%m-%Y') AS fecha,
                CASE WHEN ie.estado_i=1 THEN 'Asiste' ELSE 'No Asiste' END AS nom_estado,
                ie.grupo,es.nom_especialidad,mo.modulo,di.id_induccion
                FROM detalle_induccion_efsrt di
                LEFT JOIN induccion_efsrt ie ON ie.id_induccion=di.id_induccion
                LEFT JOIN users up ON up.id_usuario=ie.id_ponente
                LEFT JOIN users ur ON ur.id_usuario=di.user_reg
                LEFT JOIN especialidad es ON es.id_especialidad=ie.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=ie.id_modulo
                WHERE ie.grupo='$grupo' AND ie.id_especialidad=$id_especialidad AND 
                ie.id_modulo=$id_modulo AND ie.id_turno=$id_turno AND di.estado=2
                ORDER BY di.apater_alumno ASC,di.amater_alumno ASC,di.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function contar_matriculado_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT COUNT(*) AS cantidad FROM alumno_grupo ag
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN correo_inst_empresa ci ON ci.id_alumno=ag.id_alumno
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND ag.alumno='Matriculado' AND
                ag.matricula='Asistiendo' AND CHARACTER_LENGTH(ci.correo)>11 AND 
                ag.id_alumno NOT IN (SELECT di.id_alumno FROM detalle_induccion_efsrt di
                LEFT JOIN induccion_efsrt ie ON ie.id_induccion=di.id_induccion
                WHERE ie.grupo='$grupo' AND ie.id_especialidad=$id_especialidad AND 
                ie.id_modulo=$id_modulo AND ie.id_turno=$id_turno AND di.estado=2)
                ORDER BY ag.apellido_paterno ASC,ag.apellido_materno ASC,ag.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_matriculado_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        /*SELECT td.Id,td.Codigo,td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,td.Dni,
                CONCAT(td.Apellido_Paterno,' ',td.Apellido_Materno) AS apellidos
                FROM todos_l20 td
                LEFT JOIN correo_inst_empresa ci ON ci.id_alumno=td.Id
                WHERE td.Tipo=1 AND td.Grupo='$grupo' AND td.Especialidad='$especialidad' AND 
                td.Modulo='$modulo' AND td.Alumno='Matriculado' AND td.Matricula='Asistiendo' AND 
                CHARACTER_LENGTH(ci.correo)>11 AND td.Id NOT IN (SELECT di.id_alumno FROM detalle_induccion_efsrt di
                LEFT JOIN induccion_efsrt ie ON ie.id_induccion=di.id_induccion
                WHERE ie.grupo='$grupo' AND ie.id_especialidad=$id_especialidad AND 
                ie.id_modulo=$id_modulo AND di.estado=2)
                ORDER BY td.Apellido_Paterno ASC,td.Apellido_Materno ASC,td.Nombre*/

        $sql = "SELECT ag.id_alumno AS Id,ag.codigo AS Codigo,ag.apellido_paterno AS Apellido_Paterno,
                ag.apellido_materno AS Apellido_Materno,ag.nombres AS Nombre,ag.dni AS Dni,
                CONCAT(ag.apellido_paterno,' ',ag.apellido_materno) AS apellidos,ho.nom_turno AS Turno,
                gc.id_seccion AS Seccion
                FROM alumno_grupo ag
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN correo_inst_empresa ci ON ci.id_alumno=ag.id_alumno
                LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND ag.alumno='Matriculado' AND
                ag.matricula='Asistiendo' AND CHARACTER_LENGTH(ci.correo)>11 AND 
                ag.id_alumno NOT IN (SELECT di.id_alumno FROM detalle_induccion_efsrt di
                LEFT JOIN induccion_efsrt ie ON ie.id_induccion=di.id_induccion
                WHERE ie.grupo='$grupo' AND ie.id_especialidad=$id_especialidad AND 
                ie.id_modulo=$id_modulo AND ie.id_turno=$id_turno AND di.estado=2)
                ORDER BY ag.apellido_paterno ASC,ag.apellido_materno ASC,ag.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_induccion_efsrt()
    {
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE id_usuario IN (10,45,72,76)
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_induccion_efsrt()
    {
        $sql = "SELECT id_induccion FROM induccion_efsrt";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_induccion_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO induccion_efsrt (cod_induccion,grupo,id_especialidad,id_modulo,id_turno,
                fecha_charla,hora_charla,documento,id_ponente,estado_i,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['cod_induccion'] . "','" . $dato['grupo'] . "','" . $dato['id_especialidad'] . "',
                '" . $dato['id_modulo'] . "','" . $dato['id_turno'] . "','" . $dato['fecha_charla'] . "',
                '" . $dato['hora_charla'] . "','" . $dato['documento'] . "',
                '" . $dato['id_ponente'] . "',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_induccion_efsrt()
    {
        $sql = "SELECT id_induccion,cod_induccion FROM induccion_efsrt
                ORDER BY id_induccion DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_detalle_induccion_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_induccion_efsrt (id_induccion,id_alumno,cod_alumno,
                apater_alumno,amater_alumno,nom_alumno,dni_alumno,email_alumno,cumpleanos_alumno,
                estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_induccion'] . "','" . $dato['id_alumno'] . "','" . $dato['cod_alumno'] . "',
                '" . $dato['apater_alumno'] . "','" . $dato['amater_alumno'] . "','" . $dato['nom_alumno'] . "',
                '" . $dato['dni_alumno'] . "','" . $dato['email_alumno'] . "','" . $dato['cumpleanos_alumno'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_induccion_efsrt($id_induccion)
    {
        $sql = "SELECT * FROM induccion_efsrt
                WHERE id_induccion=$id_induccion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_induccion_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_induccion_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_detalle='" . $dato['id_detalle'] . "'";
        $this->db->query($sql);
    }

    function get_list_entrega_formato_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT ef.id_entrega,ef.apater_alumno,ef.amater_alumno,ef.nom_alumno,
                ef.cod_alumno,ef.email_alumno,DATE_FORMAT(ef.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(ef.fec_envio,'%H:%i') AS hora_envio,
                CASE WHEN ef.estado_e=1 THEN 'Enviado' ELSE 'Pendiente' END AS nom_estado,
                ef.estado_e,ef.grupo,es.nom_especialidad,mo.modulo
                FROM entrega_formato_efsrt ef
                LEFT JOIN especialidad es ON es.id_especialidad=ef.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=ef.id_modulo
                WHERE ef.grupo='$grupo' AND ef.id_especialidad=$id_especialidad AND 
                ef.id_modulo=$id_modulo AND ef.id_turno=$id_turno AND ef.estado=2
                ORDER BY ef.apater_alumno ASC,ef.amater_alumno ASC,ef.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_entrega_formato_efsrt($id_entrega)
    {
        $sql = "SELECT * FROM entrega_formato_efsrt
                WHERE id_entrega=$id_entrega";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_entrega_formato_efsrt($dato)
    {
        $sql = "UPDATE entrega_formato_efsrt SET fec_envio=NOW(),
                estado_e=1
                WHERE id_entrega='" . $dato['id_entrega'] . "'";
        $this->db->query($sql);
    }

    function delete_entrega_formato_efsrt($dato)
    {
        $sql = "UPDATE entrega_formato_efsrt SET estado_e=0
                WHERE id_entrega='" . $dato['id_entrega'] . "'";
        $this->db->query($sql);
    }

    function get_list_firma_contrato_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT fc.id_firma,CASE WHEN fc.tipo=1 THEN 'Mayor de Edad'
                WHEN fc.tipo=2 THEN 'Menor de Edad' ELSE '' END AS nom_tipo,
                fc.apater_alumno,fc.amater_alumno,fc.nom_alumno,
                fc.cod_alumno,fc.email_alumno,
                DATE_FORMAT(fc.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(fc.fec_envio,'%H:%i') AS hora_envio,
                CASE WHEN fc.estado_f=1 THEN 'Enviado' ELSE 'Firmado' END AS nom_estado,
                fc.estado_f,fc.documento,fc.grupo,es.nom_especialidad,mo.modulo
                FROM firma_contrato_efsrt fc
                LEFT JOIN especialidad es ON es.id_especialidad=fc.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=fc.id_modulo
                WHERE fc.grupo='$grupo' AND fc.id_especialidad=$id_especialidad AND 
                fc.id_modulo=$id_modulo AND fc.id_turno=$id_turno AND fc.estado=2
                ORDER BY fc.apater_alumno ASC,fc.amater_alumno ASC,fc.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_matriculado_menor_edad_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        /*SELECT Id,Codigo,Apellido_Paterno,Apellido_Materno,Nombre,Dni,
                CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre) AS Alumno
                FROM todos_l20 
                WHERE Tipo=1 AND Grupo='$grupo' AND Especialidad='$especialidad' AND Modulo='$modulo' AND
                Alumno='Matriculado' AND Matricula='Asistiendo' AND 
                TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())<18 AND 
                Id NOT IN (SELECT id_alumno FROM firma_contrato_efsrt 
                WHERE grupo='$grupo' AND id_especialidad=$id_especialidad AND id_modulo=$id_modulo AND 
                tipo=2 AND estado=2)
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC*/

        $sql = "SELECT ag.id_alumno AS Id,ag.codigo AS Codigo,ag.apellido_paterno AS Apellido_Paterno,
                ag.apellido_materno AS Apellido_Materno,ag.nombres AS Nombre,ag.dni AS Dni,
                CONCAT(ag.apellido_paterno,' ',ag.apellido_materno,' ',ag.nombres) AS Alumno
                FROM alumno_grupo ag
                LEFT JOIN grupo_calendarizacion gc ON gc.id_grupo=ag.id_grupo
                LEFT JOIN correo_inst_empresa ci ON ci.id_alumno=ag.id_alumno
                WHERE gc.grupo='$grupo' AND gc.id_especialidad=$id_especialidad AND 
                gc.id_modulo=$id_modulo AND gc.id_turno=$id_turno AND ag.alumno='Matriculado' AND
                ag.matricula='Asistiendo' AND TIMESTAMPDIFF(YEAR, ag.fecha_cumpleanos, CURDATE())<18 AND 
                CHARACTER_LENGTH(ci.correo)>11 AND 
                ag.id_alumno NOT IN (SELECT id_alumno FROM firma_contrato_efsrt 
                WHERE grupo='$grupo' AND id_especialidad=$id_especialidad AND id_modulo=$id_modulo AND 
                tipo=2 AND estado=2)
                ORDER BY ag.apellido_paterno ASC,ag.apellido_materno ASC,ag.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_firma_contrato_efsrt()
    {
        $sql = "SELECT id_firma FROM firma_contrato_efsrt";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_firma_contrato_efsrt($id_firma)
    {
        $sql = "SELECT * FROM firma_contrato_efsrt
                WHERE id_firma=$id_firma";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_firma_contrato_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO firma_contrato_efsrt (grupo,id_especialidad,id_modulo,id_turno,
                id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,dni_alumno,
                email_alumno,tipo,fecha_firma,estado_f,documento,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['grupo'] . "','" . $dato['id_especialidad'] . "',
                '" . $dato['id_modulo'] . "','" . $dato['id_turno'] . "','" . $dato['id_alumno'] . "',
                '" . $dato['cod_alumno'] . "','" . $dato['apater_alumno'] . "','" . $dato['amater_alumno'] . "',
                '" . $dato['nom_alumno'] . "','" . $dato['dni_alumno'] . "',
                '" . $dato['email_alumno'] . "',2,CURDATE(),2,'" . $dato['documento'] . "',2,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function update_firma_contrato_efsrt($dato)
    {
        $sql = "UPDATE firma_contrato_efsrt SET fec_envio=NOW()
                WHERE id_firma='" . $dato['id_firma'] . "'";
        $this->db->query($sql);
    }

    function delete_firma_contrato_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE firma_contrato_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_firma='" . $dato['id_firma'] . "'";
        $this->db->query($sql);
    }

    function get_list_entrega_temario_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT ef.id_entrega,ef.apater_alumno,ef.amater_alumno,ef.nom_alumno,
                ef.cod_alumno,ef.email_alumno,DATE_FORMAT(ef.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(ef.fec_envio,'%H:%i') AS hora_envio,
                CASE WHEN ef.estado_e=1 THEN 'Enviado' ELSE 'Pendiente' END AS nom_estado,
                ef.estado_e,ef.grupo,es.nom_especialidad,mo.modulo
                FROM entrega_temario_efsrt ef
                LEFT JOIN especialidad es ON es.id_especialidad=ef.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=ef.id_modulo
                WHERE ef.grupo='$grupo' AND ef.id_especialidad=$id_especialidad AND 
                ef.id_modulo=$id_modulo AND ef.id_turno=$id_turno AND ef.estado=2
                ORDER BY ef.apater_alumno ASC,ef.amater_alumno ASC,ef.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_entrega_temario_efsrt($id_entrega)
    {
        $sql = "SELECT * FROM entrega_temario_efsrt
                WHERE id_entrega=$id_entrega";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_entrega_temario_efsrt($dato)
    {
        $sql = "UPDATE entrega_temario_efsrt SET fec_envio=NOW(),
                estado_e=1
                WHERE id_entrega='" . $dato['id_entrega'] . "'";
        $this->db->query($sql);
    }

    function delete_entrega_temario_efsrt($dato)
    {
        $sql = "UPDATE entrega_temario_efsrt SET estado_e=0
                WHERE id_entrega='" . $dato['id_entrega'] . "'";
        $this->db->query($sql);
    }

    function get_list_examen_basico_efsrt_desglosable($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT eb.apater_alumno,eb.amater_alumno,eb.nom_alumno,
                eb.cod_alumno,eb.email_alumno,
                cantidad_examen_basico_efsrt(eb.id_alumno,eb.grupo,
                eb.id_especialidad,eb.id_modulo,eb.id_turno) AS cantidad,
                DATE_FORMAT(eb.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(eb.fec_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(eb.fec_termino,'%d-%m-%Y') AS fecha_termino,
                DATE_FORMAT(eb.fec_termino,'%H:%i') AS hora_termino,eb.nota,
                DATE_FORMAT(eb.fec_nota,'%d-%m-%Y') AS fecha_nota,
                DATE_FORMAT(eb.fec_nota,'%H:%i') AS hora_nota,
                CASE WHEN eb.estado_e=0 THEN 'Pendiente' WHEN eb.estado_e=1 THEN 'Enviado'
                WHEN eb.estado_e=2 THEN 'Rezagado' WHEN eb.estado_e=3 THEN 'Aprobado' 
                ELSE '' END AS nom_estado,eb.id_alumno
                FROM examen_basico_efsrt eb
                WHERE eb.id_examen IN (SELECT MAX(ee.id_examen) FROM examen_basico_efsrt ee
                WHERE ee.id_alumno=eb.id_alumno AND ee.grupo='$grupo' AND 
                ee.id_especialidad=$id_especialidad AND ee.id_modulo=$id_modulo AND 
                ee.id_turno=$id_turno AND ee.estado=2)
                GROUP BY eb.id_alumno
                ORDER BY eb.apater_alumno ASC,eb.amater_alumno ASC,eb.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumnos_grupo_efsrt($dato)
    {
        $sql = "SELECT a.Apellido_Paterno,a.Apellido_Materno,a.Nombre,a.Codigo,a.Grupo,a.Especialidad,a.Turno,
                a.Modulo,a.Seccion,a.Email
                FROM todos_l20 a
                WHERE a.Grupo='" . $dato['grupo'] . "' and a.Especialidad='" . $dato['especialidad'] . "' and a.Modulo='" . $dato['modulo'] . "' AND 
                a.Turno='" . $dato['turno'] . "' and a.Seccion='" . $dato['seccion'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cadena_alumnos_grupo_efsrt($dato)
    {
        $sql = "SELECT COALESCE(GROUP_CONCAT(a.Codigo SEPARATOR ','), '0') AS Cadena_Codigos
                FROM todos_l20 a
                WHERE a.Grupo='" . $dato['grupo'] . "' and a.Especialidad='" . $dato['especialidad'] . "' and a.Modulo='" . $dato['modulo'] . "' AND 
                a.Turno='" . $dato['turno'] . "' and a.Seccion='" . $dato['seccion'] . "'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_examen_basico_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT eb.id_examen,eb.apater_alumno,eb.amater_alumno,eb.nom_alumno,
                eb.cod_alumno,eb.email_alumno,
                DATE_FORMAT(eb.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(eb.fec_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(eb.fec_termino,'%d-%m-%Y') AS fecha_termino,
                DATE_FORMAT(eb.fec_termino,'%H:%i') AS hora_termino,eb.nota,
                DATE_FORMAT(eb.fec_nota,'%d-%m-%Y') AS fecha_nota,
                DATE_FORMAT(eb.fec_nota,'%H:%i') AS hora_nota,
                CASE WHEN eb.estado_e=0 THEN 'Pendiente' WHEN eb.estado_e=1 THEN 'Enviado'
                WHEN eb.estado_e=2 THEN 'Rezagado' WHEN eb.estado_e=3 THEN 'Aprobado' 
                ELSE '' END AS nom_estado,eb.estado_e,eb.grupo,es.nom_especialidad,mo.modulo,
                eb.id_alumno
                FROM examen_basico_efsrt eb
                LEFT JOIN especialidad es ON es.id_especialidad=eb.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=eb.id_modulo
                WHERE eb.grupo='$grupo' AND eb.id_especialidad=$id_especialidad AND 
                eb.id_modulo=$id_modulo AND eb.id_turno=$id_turno AND eb.estado=2
                ORDER BY eb.apater_alumno ASC,eb.amater_alumno ASC,eb.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_examen_basico_efsrt($id_examen)
    {
        $sql = "SELECT * FROM examen_basico_efsrt
                WHERE id_examen=$id_examen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_examen_basico_efsrt($dato)
    {
        $sql = "UPDATE examen_basico_efsrt SET fec_envio=NOW(),
                estado_e=1
                WHERE id_examen='" . $dato['id_examen'] . "'";
        $this->db->query($sql);
    }

    function delete_examen_basico_efsrt($dato)
    {
        $sql = "UPDATE examen_basico_efsrt SET estado_e=0
                WHERE id_examen='" . $dato['id_examen'] . "'";
        $this->db->query($sql);
    }

    function get_list_evaluacion_basica_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT ev.id_evaluacion,eb.apater_alumno,eb.amater_alumno,eb.nom_alumno,
                eb.cod_alumno,ev.puntaje_teorico,(ev.puntaje_teorico*0.3) AS teorico,
                DATE_FORMAT(ev.fec_evaluacion,'%d-%m-%Y') AS fecha,us.usuario_codigo,
                ev.puntaje_practico_1,ev.puntaje_practico_2,
                (((ev.puntaje_practico_1+ev.puntaje_practico_2)/2)*0.5) AS practico,
                ev.puntaje_presentacion_personal_1,ev.puntaje_presentacion_personal_2,
                ev.puntaje_presentacion_personal_3,ev.puntaje_presentacion_personal_4,
                (((ev.puntaje_presentacion_personal_1+ev.puntaje_presentacion_personal_2+
                puntaje_presentacion_personal_3+puntaje_presentacion_personal_4)/4)*0.2) 
                AS presentacion_personal,(ev.puntaje_teorico*0.3)+
                (((ev.puntaje_practico_1+ev.puntaje_practico_2)/2)*0.5)+
                (((ev.puntaje_presentacion_personal_1+ev.puntaje_presentacion_personal_2+
                puntaje_presentacion_personal_3+puntaje_presentacion_personal_4)/4)*0.2) 
                AS final,CASE WHEN ev.estado_e=1 THEN 'Pendiente' ELSE '' END AS nom_estado,
                ev.documento
                FROM evaluacion_basica_efsrt ev
                LEFT JOIN examen_basico_efsrt eb ON eb.id_examen=ev.id_examen_basico
                LEFT JOIN users us ON us.id_usuario=ev.id_evaluador
                WHERE ev.grupo='$grupo' AND ev.id_especialidad=$id_especialidad AND 
                ev.id_modulo=$id_modulo AND ev.id_turno=$id_turno AND ev.estado=2
                ORDER BY eb.apater_alumno ASC,eb.amater_alumno ASC,eb.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_evaluacion_basica_efsrt($id_evaluacion)
    {
        $sql = "SELECT * FROM evaluacion_basica_efsrt
                WHERE id_evaluacion=$id_evaluacion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_evaluacion_basica_efsrt()
    {
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE tipo=1 AND estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_evaluacion_basica_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE evaluacion_basica_efsrt SET fec_evaluacion='" . $dato['fec_evaluacion'] . "',
                id_evaluador='" . $dato['id_evaluador'] . "',puntaje_teorico='" . $dato['puntaje_teorico'] . "',
                puntaje_practico_1='" . $dato['puntaje_practico_1'] . "',
                puntaje_practico_2='" . $dato['puntaje_practico_2'] . "',
                puntaje_presentacion_personal_1='" . $dato['puntaje_presentacion_personal_1'] . "',
                puntaje_presentacion_personal_2='" . $dato['puntaje_presentacion_personal_2'] . "',
                puntaje_presentacion_personal_3='" . $dato['puntaje_presentacion_personal_3'] . "',
                puntaje_presentacion_personal_4='" . $dato['puntaje_presentacion_personal_4'] . "',
                documento='" . $dato['documento'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_evaluacion='" . $dato['id_evaluacion'] . "'";
        $this->db->query($sql);
    }

    function delete_evaluacion_basica_efsrt($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE evaluacion_basica_efsrt SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_evaluacion='" . $dato['id_evaluacion'] . "'";
        $this->db->query($sql);
    }

    function get_list_rezagado_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT re.id_rezagado,eb.apater_alumno,eb.amater_alumno,eb.nom_alumno,
                eb.cod_alumno,CASE WHEN ve.pendiente=1 THEN 'Pend. Pago' 
                ELSE ve.cod_venta END AS nom_pago,CASE WHEN ve.pendiente=1 THEN '' 
                ELSE (ve.monto_entregado - ve.cambio) END AS monto,
                CASE WHEN ve.pendiente=1 THEN ''
                ELSE DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') END AS fecha,
                eb.email_alumno,
                DATE_FORMAT(eb.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(eb.fec_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(eb.fec_termino,'%d-%m-%Y') AS fecha_termino,
                DATE_FORMAT(eb.fec_termino,'%H:%i') AS hora_termino,eb.nota,
                DATE_FORMAT(eb.fec_nota,'%d-%m-%Y') AS fecha_nota,
                DATE_FORMAT(eb.fec_nota,'%H:%i') AS hora_nota,
                CASE WHEN re.estado_r=0 THEN 'Pendiente' WHEN re.estado_r=1 THEN 'Enviado' 
                END AS nom_estado,re.grupo,es.nom_especialidad,mo.modulo
                FROM rezagado_efsrt re
                LEFT JOIN examen_basico_efsrt eb ON re.id_rezagado=eb.id_rezagado
                LEFT JOIN venta_empresa ve ON ve.id_venta=re.id_venta
                LEFT JOIN especialidad es ON es.id_especialidad=re.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=re.id_modulo
                WHERE re.grupo='$grupo' AND re.id_especialidad=$id_especialidad AND 
                re.id_modulo=$id_modulo AND re.id_turno=$id_turno AND re.estado=2
                ORDER BY eb.apater_alumno ASC,eb.amater_alumno ASC,eb.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_centro_efsrt($grupo, $id_especialidad, $id_modulo, $id_turno)
    {
        $sql = "SELECT eb.id_examen,eb.apater_alumno,eb.amater_alumno,eb.nom_alumno,
                eb.cod_alumno,eb.email_alumno,DATE_FORMAT(eb.fec_envio,'%d-%m-%Y') AS fecha_envio,
                DATE_FORMAT(eb.fec_envio,'%H:%i') AS hora_envio,
                CASE WHEN eb.estado_e=1 THEN 'Enviado' ELSE 'Pendiente' END AS nom_estado,
                eb.estado_e,eb.grupo,es.nom_especialidad,mo.modulo
                FROM examen_basico_efsrt eb
                LEFT JOIN especialidad es ON es.id_especialidad=eb.id_especialidad AND es.estado=2
                LEFT JOIN modulo mo ON mo.id_modulo=eb.id_modulo
                WHERE eb.id_examen=0 AND eb.grupo='$grupo' AND eb.id_especialidad=$id_especialidad AND 
                eb.id_modulo=$id_modulo AND eb.id_turno=$id_turno AND eb.estado=2
                ORDER BY eb.apater_alumno ASC,eb.amater_alumno ASC,eb.nom_alumno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //----------------------------------------------------------------------------------
    function get_ingresos_mesesxanio($dato)
    {
        /*if($dato['id_anio']!=''){
            $var1 =" and year(ri.ingreso)='".$dato['id_anio']."' ";
        }else{
            $var1 =" and year(ri.ingreso)=year(now())";
        }
        
        $sql = "SELECT month(ri.ingreso) numero,case when month(ri.ingreso) = '1'  then 'Enero' 
                when month(ri.ingreso) = '2'  then 'Febrero' when month(ri.ingreso) = '3'  then 'Marzo'
                when month(ri.ingreso) = '4'  then 'Abril' when month(ri.ingreso) = '5'  then 'Mayo'
                when month(ri.ingreso) = '6'  then 'Junio' when month(ri.ingreso) = '7'  then 'Julio'
                when month(ri.ingreso) = '8'  then 'Agosto' when month(ri.ingreso) = '9'  then 'Septiembre'
                when month(ri.ingreso) = '10'  then 'Ocubre' when month(ri.ingreso) = '11'  then 'Noviembre'
                when month(ri.ingreso) = '12'  then 'Diciembre' end 'mes'
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND SUBSTRING_INDEX(ri.codigo, '\'', 1)='".$dato['id_colaborador2']."' $var1
                group by month(ri.ingreso) ORDER BY ri.ingreso;";
               //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query; */
        if ($dato['id_anio'] != '') {
            $var1 = " and DATEPART(YEAR, ri.ingreso)='" . $dato['id_anio'] . "' ";
        } else {
            $var1 = " and DATEPART(YEAR, ri.ingreso)=DATEPART(YEAR, GETDATE())";
        }

        $sql = "SELECT MONTH(ri.ingreso) numero,case when MONTH(ri.ingreso) = '1'  then 'Enero' 
                when MONTH(ri.ingreso) = '2'  then 'Febrero' when MONTH(ri.ingreso) = '3'  then 'Marzo'
                when MONTH(ri.ingreso) = '4'  then 'Abril' when MONTH(ri.ingreso) = '5'  then 'Mayo'
                when MONTH(ri.ingreso) = '6'  then 'Junio' when MONTH(ri.ingreso) = '7'  then 'Julio'
                when MONTH(ri.ingreso) = '8'  then 'Agosto' when MONTH(ri.ingreso) = '9'  then 'Septiembre'
                when MONTH(ri.ingreso) = '10'  then 'Ocubre' when MONTH(ri.ingreso) = '11'  then 'Noviembre'
                when MONTH(ri.ingreso) = '12'  then 'Diciembre' end 'mes'
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND SUBSTRING(REPLACE(ri.codigo, '''C', ''), 1, LEN(ri.codigo) - 2)='" . $dato['id_colaborador2'] . "' and ri.codigo LIKE '%''C%' $var1
                group by MONTH(ri.ingreso) ORDER BY MONTH(ri.ingreso);";
        //echo($sql);
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso_matriculados2($dato)
    {
        if ($dato['id_anio'] != '') {
            $var1 = " and CONVERT(varchar,DATEPART(YEAR, ri.ingreso),103)='" . $dato['id_anio'] . "' and CONVERT(varchar,DATEPART(MONTH, ri.ingreso),103)='" . $dato['meses'] . "' ";
        } else {
            $var1 = " and CONVERT(varchar,DATEPART(YEAR, ri.ingreso),103)=DATEPART(YEAR, GETDATE())";
        }
        $sql = "SELECT ri.codigo,ri.ingreso AS orden,CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND SUBSTRING(REPLACE(ri.codigo, '''C', ''), 1, LEN(ri.codigo) - 2)='" . $dato['id_colaborador2'] . "' and ri.codigo LIKE '%''C%' $var1
                ORDER BY ri.ingreso ASC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_ingresos_años($id_colaborador)
    {
        $sql = "SELECT CONVERT(varchar,DATEPART(YEAR, ri.ingreso)) AS orden
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND SUBSTRING(REPLACE(ri.codigo, '''C', ''), 1, LEN(ri.codigo) - 2)=$id_colaborador and ri.codigo LIKE '%''C%'
                group by CONVERT(varchar,DATEPART(YEAR, ri.ingreso))
                ORDER BY CONVERT(varchar,DATEPART(YEAR, ri.ingreso)) desc";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_aplica_colaborador($id_colaborador)
    {
        $sql = "select max(no_aplica) from colaborador_horario where id_colaborador=$id_colaborador;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_ingresos_modulo($id_alumno)
    {
        $sql = "SELECT modulo
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_alumno
                group by ri.modulo ORDER BY modulo asc;";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_id_todos_l20_colaborador($dato)
    {

        $sql = "SELECT Id FROM todos_l20 WHERE SUBSTRING_INDEX(codigo, '\'', 1)='" . $dato['get_id'][0]['codigo_gll'] . "' and (cargo<>'' or cargo is not null) ";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function get_list_tipo_documento($id_motivo = null)
    {
        $parte = "";

        if ($id_motivo != null) {
            $parte = " and id_status_general=$id_motivo";
        }

        $sql = "SELECT sg.*,sg.estado as id_estado,s.nom_status as estado
                FROM status_general sg 
                left join status s on s.id_status = sg.estado
                WHERE sg.id_status_mae='10' and sg.estado in (2,3) $parte";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function valida_tipo_documento($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = "and id_status_general !='" . $dato['id_status_general'] . "'";
        }

        $sql = "SELECT * FROM status_general WHERE id_status_mae='10' and estado=2  and nom_status='" . $dato['tipo'] . "' $v ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function insert_tipo_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO status_general(nom_status,id_status_mae,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['tipo'] . "','" . $dato['estado'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function get_list_estados_documentos()
    {
        $sql = "SELECT * FROM status WHERE id_status in (2,3)";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function update_tipo_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE status_general SET nom_status='" . $dato['tipo'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW() ,user_act='$id_usuario'
                WHERE id_status_general='" . $dato['id_status_general'] . "'";
        $this->db->query($sql);
    }

    function delete_tipo_documento($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE status_general SET estado='4', fec_eli=NOW(), user_eli=$id_usuario WHERE id_status_general='" . $dato['id_status_general'] . "'";
        $this->db->query($sql);
    }


    function get_list_contactenos($tipo, $dato = null)
    {
        $vartipo = "where ci.estado=73";
        if ($tipo == 2) {
            $vartipo = "where ci.estado in (74,75,76)";
        } else if ($tipo == 3) {
            $vartipo = "where id_contacto='" . $dato['id'] . "'";
        }
        $sql = "SELECT case when ci.fec_act='0000-00-00 00:00:00' then '-' else DATE(ci.fec_act) end as fecha_usuario,
                case when ci.user_act='0' then '-' else s.usuario_codigo end as usuario,DATE(ci.fec_reg) as fecha, 
                TIME(ci.fec_reg)as hora,ci.*,sg.nom_status,mc.titulo,mc.usuarios
                FROM contacto_ifvonline ci
                left join status_general sg on ci.estado=sg.id_status_general and sg.id_status_mae=11 
                left join users s on ci.user_act=s.id_usuario 
                left join motivo_contactenos mc on ci.id_motivo=mc.id_motivo
                $vartipo ";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function get_list_estados_contactenos()
    {
        $sql = "SELECT * FROM status_general WHERE id_status_mae in (11)";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
        return $query;
    }

    function update_contactenos($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contacto_ifvonline SET estado='" . $dato['estado'] . "',fec_act=NOW() ,user_act='$id_usuario' WHERE id_contacto='" . $dato['id_contacto'] . "'";
        $this->db->query($sql);
    }

    // Ingreso Calendarizacion y pagos - IFV ONLINE
    function get_list_calendaypagos()
    {
        $sql = "select t.dni,t.Codigo,t.Apellido_Paterno,t.Apellido_Materno,t.Nombre,b.abreviatura,t.Grupo,t.turno,t.modulo,
        (SELECT ci.ciclo FROM ciclo ci 
        LEFT JOIN grupo_calendarizacion gc ON gc.id_ciclo=ci.id_ciclo
        LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad
        LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
        WHERE gc.grupo=t.Grupo AND es.nom_especialidad=t.Especialidad AND 
        mo.modulo=t.Modulo AND gc.id_seccion=t.Seccion
        LIMIT 1) as ciclo,
        DATE(tr.fec_reg_cyp) as dia,  time(tr.fec_reg_cyp) as hora
        from TBL_REG_CYP tr
        left join todos_l20 t on tr.dni_reg_cyp=t.dni
        left join especialidad b on t.Especialidad=b.nom_especialidad and b.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    // colegio proveniencia
    function get_list_colegio_prov($id = null, $estado = null)
    {
        if (isset($id) && $id > 0) {
            $sql = "SELECT * FROM colegio_prov where id='$id'";
        } else {
            $estadoCondition = ($estado === 'activo') ? "cp.estado = 2" : "cp.estado != 4";

            $sql = "SELECT
            cp.id,
            cp.institucion,
            cp.tipo_gestion,
            CASE cp.tipo_gestion
                WHEN 1 THEN 'Privada'
                WHEN 2 THEN 'Pública'
                WHEN 3 THEN 'Pública (Gestión Privada)'
                ELSE 'Desconocido'
            END AS nombre_tipo_gestion,
            d.nombre_departamento,
            p.nombre_provincia,
            di.nombre_distrito,
            e.nom_status,
            e.color
            FROM
                colegio_prov cp
                LEFT JOIN departamento d ON d.id_departamento = cp.departamento
                LEFT JOIN provincia p ON p.id_provincia = cp.provincia
                LEFT JOIN distrito di ON di.id_distrito = cp.distrito
                LEFT JOIN status e ON e.id_status = cp.estado
            WHERE
                $estadoCondition
            ORDER BY
            cp.institucion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_colegio_prov($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = "and id !='" . $dato['id_colegio_prov'] . "'";
        }
        $sql = "SELECT * FROM colegio_prov WHERE institucion='" . $dato['institucion'] . "' and departamento='" . $dato['departamento'] . "' and provincia='" . $dato['provincia'] . "' and distrito='" . $dato['distrito'] . "' and estado=" . $dato['estado'] . " and tipo_gestion=" . $dato['tipo_gestion'] . " $v ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_colegio_prov($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colegio_prov(institucion,departamento,provincia,distrito,estado, tipo_gestion,fec_reg,user_reg) 
                VALUES ('" . $dato['institucion'] . "','" . $dato['departamento'] . "','" . $dato['provincia'] . "','" . $dato['distrito'] . "','" . $dato['estado'] . "','" . $dato['tipo_gestion'] . "',NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_colegio_prov($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colegio_prov SET institucion='" . $dato['institucion'] . "',departamento='" . $dato['departamento'] . "',
                provincia='" . $dato['provincia'] . "',distrito='" . $dato['distrito'] . "',estado='" . $dato['estado'] . "',
                tipo_gestion='" . $dato['tipo_gestion'] . "',
                fec_act=NOW() ,user_act='$id_usuario'
                WHERE id='" . $dato['id_colegio_prov'] . "'";
        $this->db->query($sql);
    }

    function delete_colegio_prov($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colegio_prov SET estado='4', fec_eli=NOW(), user_eli=$id_usuario WHERE id='" . $dato['id_colegio_prov'] . "'";
        $this->db->query($sql);
    }

    function get_tipo_contrato_rrhh()
    {
        $sql = "SELECT * FROM tipo_contrato_rrhh WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado_contrato_ifv_rrhh()
    {
        $sql = "SELECT * FROM status WHERE estado=1 and id_status in (1,2,3) ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_semanas($semana = null)
    {
        $anio = date("Y");
        if (isset($semana) && $semana > 0) {
            $sql = "SELECT * FROM semanas where estado=1 and anio='$anio' and nom_semana='$semana' order by id_semanas asc";
        } else {
            $sql = "SELECT * FROM semanas WHERE estado=1 and anio='$anio' order by id_semanas asc";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //---------------------------------------------DATOS ALUMNOS-------------------------------------------
    function get_list_datos_alumno($tipo)
    {
        $where = "";
        if ($tipo == 1) {
            $where = " tl.Alumno='Matriculado' AND tl.Matricula='Asistiendo' and tl.TIPO=1";
        } elseif ($tipo == 2) {
            $where = " tl.Tipo=1";
        }
        $sql = "SELECT
            tl.id_matriculado,
            tl.Id,
            tl.Apellido_Paterno,
            tl.Apellido_Materno,
            tl.Nombre,
            tl.Codigo,
            tl.Grupo,
            tl.Turno,
            tl.Modulo,
            tl.Seccion,
            tl.Matricula,
            tl.Alumno,
            tl.Documento_Pendiente,
            tl.Especialidad,
            DATE_FORMAT(tl.Fecha_Cumpleanos, '%d/%m/%Y') AS Fecha_Nacimiento,
            TIMESTAMPDIFF(YEAR, tl.Fecha_Cumpleanos, CURDATE()) AS Edad,
            es.abreviatura as Especialidad_Abreviatura,
            CASE
                se.sexo
                WHEN 1 THEN 'Femenino'
                WHEN 2 THEN 'Masculino'
                ELSE 'Desconocido'
            END AS Sexo,
            tl.Celular,
            tl.Email,
            tl.Id,
            cpv.institucion as Colegio_Proveniencia,
            CASE cpv.tipo_gestion
                WHEN 1 THEN 'Privada'
                WHEN 2 THEN 'Pública'
                WHEN 3 THEN 'Pública (Gestión Privada)'
                ELSE ''
            END AS Tipo_Gestion,
            dp.nombre_departamento as Departamento_Colegio_Proveniencia,
            pp.nombre_provincia as Provincia_Colegio_Proveniencia,
            dv.nombre_distrito as Distrito_Colegio_Proveniencia, 
            ci.correo as Correo_Institucional
        FROM
            todos_l20 tl
            LEFT JOIN especialidad es ON tl.Especialidad = es.nom_especialidad
            AND es.estado = 2
            LEFT JOIN sexo_empresa se ON tl.Id = se.id_alumno
            LEFT JOIN colegio_prov_empresa cp ON tl.Id = cp.id_alumno
            LEFT JOIN colegio_prov cpv ON cp.id_colegio_prov = cpv.id
            LEFT JOIN departamento dp ON cpv.departamento = dp.id_departamento
            LEFT JOIN provincia pp ON cpv.provincia = pp.id_provincia
            LEFT JOIN distrito dv ON cpv.distrito = dv.id_distrito
            LEFT JOIN correo_inst_empresa ci ON tl.Id = ci.id_alumno
        WHERE
            $where
        ORDER BY
            tl.Grupo ASC,
            tl.Turno ASC,
            tl.Modulo ASC,
            tl.Seccion ASC,
            tl.Apellido_Paterno ASC,
            tl.Apellido_Materno ASC,
            tl.Nombre ASC
        ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_grupo_alumno($id)
    {
        $sql = "SELECT a.id_grupo,a.id_alumno,b.grupo
        FROM alumno_grupo a 
        left join grupo_calendarizacion b on a.id_grupo=b.id_grupo
        WHERE a.id='$id'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_dias_marcaciones_alumno_demas($dato)
    {
        $sql = "DELETE FROM registro_asistencia 
                WHERE id_alumno='" . $dato['id_alumno'] . "' AND fecha>='" . date('Y-m-d') . "' AND 
                id_grupo='" . $dato['id_grupo'] . "'";
        $this->db5->query($sql);
    }

    function valida_fecha_festivo_alumno_ifv($dato)
    {
        $anio = date('Y');
        $sql = "SELECT se.id_calendar_festivo,se.descripcion,se.inicio,se.fin,se.nom_dia,se.clases,se.laborable
        FROM
        calendar_festivo se 
        WHERE se.estado=2 and se.id_empresa=6
        and '" . $dato['fecha'] . "' between date_format(se.inicio,'%Y-%m-%d') and date_format(se.fin,'%Y-%m-%d')
        and clases='NO' limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_horario_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $v = "";
        if ($dato['id_horario'] != "") {
            $v = " and id_horario!='" . $dato['id_horario'] . "'";
        }
        $sql = "SELECT COUNT(*) AS cantidad FROM colaborador_horario_general 
                WHERE id_colaborador='" . $dato['id_colaborador'] . "' and estado=2 and estado_registro=1 $v";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_horario()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "SELECT COUNT(*) AS cantidad FROM colaborador_horario_general";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horario_colaborador_v2($dato)
    {
        /*$id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colaborador_horario_general (cod_horario,id_colaborador,de,a,ch_lun,ch_mar,ch_mier,ch_jue,ch_vie,ch_sab,ch_dom,
        estado_registro,estado,fec_reg,user_reg) 
                values ('".$dato['cod_horario']."','".$dato['id_colaborador']."','".$dato['de']."','".$dato['a']."','".$dato['ch_lun']."',
                '".$dato['ch_mar']."','".$dato['ch_mier']."','".$dato['ch_jue']."','".$dato['ch_vie']."','".$dato['ch_sab']."','".$dato['ch_dom']."',
                1,2,NOW(),'$id_usuario')";
        $this->db->query($sql);*/
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $data = array(
            'cod_horario' => $dato['cod_horario'],
            'id_colaborador' => $dato['id_colaborador'],
            'de' => $dato['de'],
            'a' => $dato['a'],
            'ch_lun' => $dato['ch_lun'],
            'ch_mar' => $dato['ch_mar'],
            'ch_mier' => $dato['ch_mier'],
            'ch_jue' => $dato['ch_jue'],
            'ch_vie' => $dato['ch_vie'],
            'ch_sab' => $dato['ch_sab'],
            'ch_dom' => $dato['ch_dom'],
            'estado_registro' => 1,
            'estado' => 2,
            'fec_reg' => date('Y-m-d H:i:s'),
            'user_reg' => $id_usuario
        );

        $this->db->insert('colaborador_horario_general', $data);

        // Obtener el ID del registro recién insertado
        $id_registro_insertado = $this->db->insert_id();

        return $id_registro_insertado;
    }

    function insert_horario_detalle_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $sql = "INSERT INTO colaborador_horario_general_detalle (id_horario,dia,ch_m,ch_alm,ch_t,ch_c,ch_n,
        ingreso_m,salida_m,ingreso_alm,salida_alm,ingreso_t,salida_t,ingreso_c,salida_c,ingreso_n,salida_n,
        estado,fec_reg,user_reg) 
                values ('" . $dato['id_horario'] . "',
                '" . $dato['dia'] . "','" . $dato['ch_m'] . "','" . $dato['ch_alm'] . "','" . $dato['ch_t'] . "','" . $dato['ch_c'] . "','" . $dato['ch_n'] . "',
                '" . $dato['ingreso_m'] . "','" . $dato['salida_m'] . "','" . $dato['ingreso_alm'] . "','" . $dato['salida_alm'] . "',
                '" . $dato['ingreso_t'] . "','" . $dato['salida_t'] . "','" . $dato['ingreso_c'] . "','" . $dato['salida_c'] . "',
                '" . $dato['ingreso_n'] . "','" . $dato['salida_n'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_horario_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general 
        SET de='" . $dato['de'] . "',a='" . $dato['a'] . "',ch_lun='" . $dato['ch_lun'] . "',ch_mar='" . $dato['ch_mar'] . "',
        ch_mier='" . $dato['ch_mier'] . "',ch_jue='" . $dato['ch_jue'] . "',ch_vie='" . $dato['ch_vie'] . "',ch_sab='" . $dato['ch_sab'] . "',
        ch_dom='" . $dato['ch_dom'] . "',
        estado_registro='" . $dato['estado_registro'] . "',fec_act=NOW(),user_act=$id_usuario
        WHERE id_horario='" . $dato['id_horario'] . "'";
        $this->db->query($sql);
    }

    function update_horario_detalle_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general_detalle 
        SET ch_m='" . $dato['ch_m'] . "',ch_alm='" . $dato['ch_alm'] . "',
        ch_t='" . $dato['ch_t'] . "',ch_c='" . $dato['ch_c'] . "',ch_n='" . $dato['ch_n'] . "',
        ingreso_m='" . $dato['ingreso_m'] . "',salida_m='" . $dato['salida_m'] . "',
        ingreso_alm='" . $dato['ingreso_alm'] . "',salida_alm='" . $dato['salida_alm'] . "',
        ingreso_t='" . $dato['ingreso_t'] . "',salida_t='" . $dato['salida_t'] . "',
        ingreso_c='" . $dato['ingreso_c'] . "',salida_c='" . $dato['salida_c'] . "',
        ingreso_n='" . $dato['ingreso_n'] . "',salida_n='" . $dato['salida_n'] . "',fec_act=NOW(),user_act=$id_usuario
        WHERE id_horario_detalle='" . $dato['id_horario_detalle'] . "'";
        $this->db->query($sql);
    }

    function delete_horario_detalle_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general_detalle SET estado=1,fec_eli=NOW(),user_eli=$id_usuario
        WHERE id_horario='" . $dato['id_horario'] . "' and dia='" . $dato['dia'] . "' and estado=2";
        $this->db->query($sql);
    }

    function list_horario_colaborador_v2($id_colaborador)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT a.id_horario,a.de,a.a,a.id_colaborador,
        a.ch_lun,a.ch_mar,a.ch_mier,a.ch_jue,a.ch_vie,a.ch_sab,a.ch_dom,a.estado_registro,
        /*case when a.ch_m=1 then date_format(a.ingreso_m,'%H:%i') else '-' end as*/'' as ingreso_m,
        /*case when a.ch_m=1 then date_format(a.salida_m,'%H:%i') else '-' end*/'' as salida_m,
        /*case when a.ch_alm=1 then date_format(a.ingreso_alm,'%H:%i') else '-' end*/'' as ingreso_alm,
        /*case when a.ch_alm=1 then date_format(a.salida_alm,'%H:%i') else '-' end*/'' as salida_alm,
        /*case when a.ch_t=1 then date_format(a.ingreso_t,'%H:%i') else '-' end*/'' as ingreso_t,
        /*case when a.ch_t=1 then date_format(a.salida_t,'%H:%i') else '-' end*/'' as salida_t,
        /*case when a.ch_c=1 then date_format(a.ingreso_c,'%H:%i') else '-' end*/'' as ingreso_c,
        /*case when a.ch_c=1 then date_format(a.salida_c,'%H:%i') else '-' end*/'' as salida_c,
        /*case when a.ch_n=1 then date_format(a.ingreso_n,'%H:%i') else '-' end*/'' as ingreso_n,
        /*case when a.ch_n=1 then date_format(a.salida_n,'%H:%i') else '-' end*/'' as salida_n,
        case when a.estado_registro=1 then 'Activo' when a.estado_registro=2 then 'Inactivo' else '' end as desc_estado_registro,
        GROUP_CONCAT(
            CASE WHEN a.ch_lun=1 THEN 'Lunes, ' ELSE '' END,
            CASE WHEN a.ch_mar=1 THEN 'Martes, ' ELSE '' END,
            CASE WHEN a.ch_mier=1 THEN 'Miércoles, ' ELSE '' END,
            CASE WHEN a.ch_jue=1 THEN 'Jueves, ' ELSE '' END,
            CASE WHEN a.ch_vie=1 THEN 'Viernes, ' ELSE '' END,
            CASE WHEN a.ch_sab=1 THEN 'Sábado, ' ELSE '' END,
            CASE WHEN a.ch_dom=1 THEN 'Domingo' ELSE '' END
        SEPARATOR ', ') AS dias

         FROM colaborador_horario_general a
                WHERE a.id_colaborador='$id_colaborador' and a.estado=2 group by a.id_horario";

        $sql = "SELECT b.id_horario,b.de,b.a,
    case when a.ch_m=1 then date_format(a.ingreso_m,'%H:%i') else '-' end as ingreso_m,
    case when a.ch_m=1 then date_format(a.salida_m,'%H:%i') else '-' end salida_m,
    case when a.ch_alm=1 then date_format(a.ingreso_alm,'%H:%i') else '-' end ingreso_alm,
    case when a.ch_alm=1 then date_format(a.salida_alm,'%H:%i') else '-' end salida_alm,
    case when a.ch_t=1 then date_format(a.ingreso_t,'%H:%i') else '-' end ingreso_t,
    case when a.ch_t=1 then date_format(a.salida_t,'%H:%i') else '-' end salida_t,
    case when a.ch_c=1 then date_format(a.ingreso_c,'%H:%i') else '-' end ingreso_c,
    case when a.ch_c=1 then date_format(a.salida_c,'%H:%i') else '-' end salida_c,
    case when a.ch_n=1 then date_format(a.ingreso_n,'%H:%i') else '-' end ingreso_n,
    case when a.ch_n=1 then date_format(a.salida_n,'%H:%i') else '-' end salida_n,
    case when b.estado_registro=1 then 'Activo' when b.estado_registro=2 then 'Inactivo' else '' end as desc_estado_registro,

    CASE WHEN a.dia=1 THEN 'Lunes'
    WHEN a.dia=2 THEN 'Martes' 
    WHEN a.dia=3 THEN 'Miércoles'
    WHEN a.dia=4 THEN 'Jueves'
    WHEN a.dia=5 THEN 'Viernes'
    WHEN a.dia=6 THEN 'Sábado'
    WHEN a.dia=7 THEN 'Domingo' END AS dias

 FROM colaborador_horario_general_detalle a
 left join colaborador_horario_general b on a.id_horario=b.id_horario
        WHERE b.id_colaborador='$id_colaborador' and a.estado=2 and b.estado=2";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_horario_colaborador_v2($id_horario)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT a.id_horario,a.de,a.a,a.id_colaborador,a.cod_horario,
        a.ch_lun,a.ch_mar,a.ch_mier,a.ch_jue,a.ch_vie,a.ch_sab,a.ch_dom,a.estado_registro,
        (a.ch_lun+a.ch_mar+a.ch_mier+a.ch_jue+a.ch_vie+a.ch_sab+a.ch_dom) as ndias
        FROM colaborador_horario_general a WHERE a.id_horario='$id_horario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_dia_horario_colaborador_v2($id_horario)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT a.id_horario_detalle,a.dia,
        a.ch_m,a.ch_alm,a.ch_t,a.ch_c,a.ch_n,
        a.ingreso_m,a.salida_m,a.ingreso_alm,a.salida_alm,a.ingreso_t,a.salida_t,
        a.ingreso_c,a.salida_c,a.ingreso_n,a.salida_n
        FROM colaborador_horario_general_detalle a WHERE a.id_horario='$id_horario' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_horario_colaborador_v2($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general SET estado=1,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_horario='" . $dato['id_horario'] . "'";
        $this->db->query($sql);

        $sql = "UPDATE colaborador_horario_general_detalle SET estado=1,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_horario='" . $dato['id_horario'] . "' and estado!=1";
        $this->db->query($sql);

        $sql = "UPDATE registro_asistencia_docente SET estado=1,fec_eli=GETDATE(),user_eli=$id_usuario 
                WHERE id_horario='" . $dato['id_horario'] . "' and estado!=1";
        $this->db5->query($sql);
    }

    //horario academico
    function get_list_horario_academico($id_horario = null)
    {
        if (isset($id_horario) && $id_horario > 0) {
            $sql = "SELECT * FROM horario_academico WHERE id_horario_acad=$id_horario";
        } else {
            $sql = "SELECT a.id_horario_acad,
            concat(DATE_FORMAT(a.desde,'%H:%i'),' - ',DATE_FORMAT(a.hasta,'%H:%i')) as horario,
            DATE_FORMAT(a.desde,'%H:%i') AS desde,
            DATE_FORMAT(a.hasta,'%H:%i') AS hasta,
            case when a.turno=1 then 'Mañana' when a.turno=2 then 'Tarde'
            when a.turno=3 then 'Noche' end as nom_turno
            from horario_academico a
            WHERE a.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_horario_academico($dato)
    {
        $v = "";
        if ($dato['id_horario_acad'] != "") {
            $v = " and id_horario_acad!='" . $dato['id_horario_acad'] . "'";
        }
        $sql = "SELECT count(1) as cantidad FROM horario_academico WHERE turno='" . $dato['turno'] . "' and
        desde='" . $dato['desde'] . "' and hasta='" . $dato['hasta'] . "' $v";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horario_academico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO horario_academico (turno,desde,hasta,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['turno'] . "','" . $dato['desde'] . "',
                '" . $dato['hasta'] . "',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function update_horario_academico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario_academico SET turno='" . $dato['turno'] . "',
                desde='" . $dato['desde'] . "',
                hasta='" . $dato['hasta'] . "',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_horario_acad='" . $dato['id_horario_acad'] . "'";
        $this->db->query($sql);
    }

    function delete_horario_academico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE horario_academico SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_horario_acad='" . $dato['id_horario_acad'] . "'";
        $this->db->query($sql);
    }

    function list_resultado_examen_grupo_efsrt($dato)
    {
        $sql = "SELECT a.resultado,a.id_postulante,a.cod_postulante,a.id_carrera,a.id_examen,a.fec_examen,a.puntaje,a.estado,
        a.tiempo_ini,a.fec_termino
        DATE_FORMAT(r.fec_termino,'%d/%m/%Y %H:%i:%s') as fecha_termino,r.fec_termino,r.tiempo_ini,
                r.puntaje,round((r.puntaje)) as puntaje_arpay,
                DATE_FORMAT(r.fec_termino,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%h:%i:%s'),
                DATE_FORMAT(r.tiempo_ini,'%d/%m/%Y %H:%i:%s') as tiempo_inicio,
                TIMEDIFF(r.fec_termino, r.tiempo_ini) as minutos_t,concat(r.id_postulante,'-',r.id_examen,'-',r.fec_examen) as cadena
                FROM resultado_examen_efsrt_ifv r where r.estado in (31,33)";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }

    function get_list_nota_grupo($dato)
    {
        $sql = "SELECT id_postulante,cod_postulante,id_examen,fec_examen,puntaje,tiempo_ini,fec_termino,estado 
        from resultado_examen_efsrt_ifv 
        where cod_postulante in (" . $dato['cadena'][0]['Cadena_Codigos'] . ") and estado in (31,33) group by id_postulante,cod_postulante,fec_examen,estado";
        $query = $this->db4->query($sql)->result_Array();
        return $query;
    }
    function get_list_usuario_evento()
    {
        $sql = "SELECT * FROM users WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------PÚBLICO-----------------------------------------
    function get_datos_publico()
    {
        $sql = "SELECT (SELECT COUNT(1) FROM publico pu 
                LEFT JOIN (SELECT id_publico,MAX(id_historial) AS id_historial
                FROM historial_publico
                GROUP BY id_publico) AS ul ON ul.id_publico=pu.id_publico
                LEFT JOIN historial_publico hp ON hp.id_historial=ul.id_historial
                WHERE hp.estado_h=14 AND pu.estado=2) AS status_sin_definir,
                (SELECT COUNT(1) FROM publico pu
                LEFT JOIN producto_interes pi ON pi.id_producto_interes=pu.id_producto_interes
                WHERE (pu.id_producto_interes=0 OR pi.nom_producto_interes='Sin Definir') AND 
                pu.estado=2) AS interese_sin_definir";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_publico($parametro, $anio)
    {
        if ($parametro == 0) {
            $parte = "AND hp.estado_h IN (11,13,14,16,58,59,60) AND YEAR(pu.fec_reg)=$anio";
        } elseif ($parametro == 2) {
            $parte = "AND pu.user_reg=" . $_SESSION['usuario'][0]['id_usuario'];
        } else {
            $parte = "AND YEAR(pu.fec_reg)=$anio";
        }
        $sql = "SELECT pu.id_publico,pu.cod_publico,pu.duplicado,us.usuario_codigo,tp.nom_tipo,
                pu.nombres_apellidos,pu.dni,pu.contacto1,CASE WHEN pu.id_producto_interes=0 
                THEN 'Sin Definir' ELSE pt.nom_producto_interes END AS nom_producto_interes,
                ac.nom_accion,DATE_FORMAT(hp.fecha_accion,'%d/%m/%Y') AS fecha_h,
                uh.usuario_codigo AS usuario_h,sg.nom_status,hp.comentario,
                de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,pu.contacto2,
                pu.correo,pu.facebook
                FROM publico pu
                LEFT JOIN users us ON us.id_usuario=pu.user_reg
                LEFT JOIN tipo_publico tp ON tp.id_tipo=pu.id_tipo
                LEFT JOIN producto_interes pt ON pt.id_producto_interes=pu.id_producto_interes
                LEFT JOIN (SELECT id_publico,MAX(id_historial) AS id_historial
                FROM historial_publico
                GROUP BY id_publico) AS ul ON ul.id_publico=pu.id_publico
                LEFT JOIN historial_publico hp ON hp.id_historial=ul.id_historial
                LEFT JOIN accion ac ON ac.id_accion=hp.id_accion
                LEFT JOIN users uh ON uh.id_usuario=hp.user_reg
                LEFT JOIN status_general sg ON sg.id_status_general=hp.estado_h
                LEFT JOIN departamento de ON de.id_departamento=pu.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=pu.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=pu.id_distrito
                WHERE pu.estado=2 $parte
                ORDER BY pu.cod_publico DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_publico()
    {
        $sql = "SELECT * FROM tipo_publico
                ORDER BY nom_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_interes()
    {
        $sql = "SELECT id_producto_interes,nom_producto_interes 
                FROM producto_interes
                WHERE id_empresa=6 AND estado=2
                ORDER BY nom_producto_interes ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_publico($dato)
    {
        if ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE contacto1='" . $dato['contacto1'] . "' AND estado=1";
        } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE correo='" . $dato['correo'] . "' AND estado=1";
        } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR contacto1='" . $dato['contacto1'] . "') AND estado=1";
        } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR correo='" . $dato['correo'] . "') AND estado=1";
        } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (contacto1='" . $dato['contacto1'] . "' OR correo='" . $dato['correo'] . "') AND estado=1";
        } else {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR contacto1='" . $dato['contacto1'] . "' OR correo='" . $dato['correo'] . "') AND estado=1";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cant_publico()
    {
        $anio = date('Y');
        $sql = "SELECT * FROM publico 
                WHERE YEAR(fec_reg)=$anio";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO publico (cod_publico,id_tipo,nombres_apellidos,dni,contacto1,contacto2,id_departamento,
                id_provincia,id_distrito,correo,facebook,duplicado,mailing,id_producto_interes,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['cod_publico'] . "','" . $dato['id_tipo'] . "','" . $dato['nombres_apellidos'] . "',
                '" . $dato['dni'] . "','" . $dato['contacto1'] . "','" . $dato['contacto2'] . "','" . $dato['id_departamento'] . "',
                '" . $dato['id_provincia'] . "','" . $dato['id_distrito'] . "','" . $dato['correo'] . "',
                '" . $dato['facebook'] . "',0,'" . $dato['mailing'] . "','" . $dato['id_producto_interes'] . "',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_publico()
    {
        $sql = "SELECT id_publico FROM publico 
                ORDER BY id_publico DESC 
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_historial_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        if ($dato['comentario'] != "" && $dato['observacion'] != "") {
            $sql = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_tipo,id_accion,fecha_accion,
                    estado_h,estado,fec_reg,user_reg)
                    VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario'] . "','" . $dato['comentario'] . "',
                    '" . $dato['id_tipo'] . "',1,NOW(),14,2,NOW(),$id_usuario)";
            $this->db->query($sql);
        }
        $sql2 = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_tipo,id_accion,fecha_accion,
                estado_h,estado,fec_reg,user_reg)
                VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario'] . "','" . $dato['observacion'] . "',
                '" . $dato['id_tipo'] . "',1,NOW(),14,2,NOW(),$id_usuario)";
        $this->db->query($sql2);
    }

    function get_id_publico($id_publico)
    {
        $sql = "SELECT pu.*,tp.nom_tipo,sg.nom_status,de.nombre_departamento,pr.nombre_provincia,
                di.nombre_distrito,CASE WHEN pu.id_producto_interes=0 
                THEN 'Sin Definir' ELSE pt.nom_producto_interes END AS nom_producto_interes,
                hp.comentario AS ultimo_comentario,us.usuario_codigo
                FROM publico pu
                LEFT JOIN tipo_publico tp ON tp.id_tipo=pu.id_tipo
                LEFT JOIN (SELECT id_publico,MAX(id_historial) AS id_historial
                FROM historial_publico
                GROUP BY id_publico) AS ul ON ul.id_publico=pu.id_publico
                LEFT JOIN historial_publico hp ON hp.id_historial=ul.id_historial
                LEFT JOIN status_general sg ON sg.id_status_general=hp.estado_h
                LEFT JOIN departamento de ON de.id_departamento=pu.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=pu.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=pu.id_distrito
                LEFT JOIN producto_interes pt ON pt.id_producto_interes=pu.id_producto_interes
                LEFT JOIN users us ON us.id_usuario=pu.user_reg
                WHERE pu.id_publico=$id_publico";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial_publico($id_publico)
    {
        $sql = "SELECT hp.id_historial,hp.fecha_accion AS orden_1,hp.fec_reg AS orden_2,
                DATE_FORMAT(hp.fecha_accion,'%d/%m/%Y') AS fecha,us.usuario_codigo,tp.nom_tipo,
                ac.nom_accion,hp.observacion,sg.nom_status
                FROM historial_publico hp
                LEFT JOIN users us ON us.id_usuario=hp.user_reg
                LEFT JOIN tipo_publico tp ON tp.id_tipo=hp.id_tipo
                LEFT JOIN accion ac ON ac.id_accion=hp.id_accion
                LEFT JOIN status_general sg ON sg.id_status_general=hp.estado_h
                WHERE hp.id_publico=$id_publico AND hp.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_publico($dato)
    {
        if ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE contacto1='" . $dato['contacto1'] . "' AND estado=1 AND id_publico!='" . $dato['id_publico'] . "'";
        } elseif ($dato['dni'] == "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE correo='" . $dato['correo'] . "' AND estado=1 AND id_publico!='" . $dato['id_publico'] . "'";
        } elseif ($dato['dni'] != "" && $dato['contacto1'] != "" && $dato['correo'] == "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR contacto1='" . $dato['contacto1'] . "') AND estado=1 AND 
                    id_publico!='" . $dato['id_publico'] . "'";
        } elseif ($dato['dni'] != "" && $dato['contacto1'] == "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR correo='" . $dato['correo'] . "') AND estado=1 AND 
                    id_publico!='" . $dato['id_publico'] . "'";
        } elseif ($dato['dni'] == "" && $dato['contacto1'] != "" && $dato['correo'] != "") {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (contacto1='" . $dato['contacto1'] . "' OR correo='" . $dato['correo'] . "') AND estado=1 AND 
                    id_publico!='" . $dato['id_publico'] . "'";
        } else {
            $sql = "SELECT id_publico FROM publico 
                    WHERE (dni='" . $dato['dni'] . "' OR contacto1='" . $dato['contacto1'] . "' OR correo='" . $dato['correo'] . "') AND 
                    estado=1 AND id_publico!='" . $dato['id_publico'] . "'";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE publico SET id_tipo='" . $dato['id_tipo'] . "',nombres_apellidos='" . $dato['nombres_apellidos'] . "',
                dni='" . $dato['dni'] . "',contacto1='" . $dato['contacto1'] . "',contacto2='" . $dato['contacto2'] . "',
                id_departamento='" . $dato['id_departamento'] . "',id_provincia='" . $dato['id_provincia'] . "',
                id_distrito='" . $dato['id_distrito'] . "',correo='" . $dato['correo'] . "',facebook='" . $dato['facebook'] . "',
                mailing='" . $dato['mailing'] . "',id_producto_interes='" . $dato['id_producto_interes'] . "',fec_act=NOW(),
                user_act=$id_usuario 
                WHERE id_publico='" . $dato['id_publico'] . "' ";
        $this->db->query($sql);
    }

    function get_list_accion_publico()
    {
        if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) {
            $parte = "(1,2,3,4,5,11,14,15)";
        } else {
            $parte = "(1,2,3,4,5,14,15)";
        }
        $sql = "SELECT id_accion,nom_accion FROM accion
                WHERE id_accion IN $parte
                ORDER BY nom_accion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_accion_estado($id_accion)
    {
        if ($id_accion == 1) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general IN (14) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 2) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general IN (62) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 3) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general IN (11,13,16) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 4) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general IN (11,14,13,16) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 5) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general IN (10,17,19,38) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 11) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general in (54,61) 
                    ORDER BY nom_status ASC";
        } elseif ($id_accion == 13 || $id_accion == 14 || $id_accion == 15) {
            $sql = "SELECT id_status_general,nom_status FROM status_general 
                    WHERE id_status_general in (15) 
                    ORDER BY nom_status ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_historial_registro_mail($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_tipo,id_accion,
                    fecha_accion,estado_h,estado,fec_reg,user_reg) 
                    VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario1'] . "','" . $dato['observacion'] . "',
                    '" . $dato['id_tipo'] . "','" . $dato['id_accion'] . "','" . $dato['fecha_accion'] . "',
                    '" . $dato['estado_h'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);

        if ($dato['ultimo_comentario'] != $dato['comentario1']) {
            $sql2 = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_tipo,id_accion,
                    fecha_accion,estado_h,estado,fec_reg,user_reg) 
                    VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario1'] . "','" . $dato['comentario1'] . "',
                    '" . $dato['id_tipo'] . "','" . $dato['id_accion'] . "','" . $dato['fecha_accion'] . "',
                    '" . $dato['estado_h'] . "',2,NOW(),$id_usuario)";
            $this->db->query($sql2);
        }
    }

    function get_id_historial_publico($id_historial)
    {
        $sql = "SELECT hp.*,(SELECT hu.comentario FROM historial_publico hu
                WHERE hu.id_historial=ul.id_historial) AS ultimo_comentario
                FROM historial_publico hp
                LEFT JOIN (SELECT id_publico,MAX(id_historial) AS id_historial
                FROM historial_publico
                GROUP BY id_publico) AS ul ON ul.id_publico=hp.id_publico
                WHERE hp.id_historial=$id_historial";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_historial_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE historial_publico SET comentario='" . $dato['comentario'] . "',
                observacion='" . $dato['observacion'] . "',id_tipo='" . $dato['id_tipo'] . "',
                id_accion='" . $dato['id_accion'] . "',fecha_accion='" . $dato['fecha_accion'] . "',
                estado_h='" . $dato['estado_h'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_historial='" . $dato['id_historial'] . "'";
        $this->db->query($sql);

        if ($dato['ultimo_comentario'] != $dato['comentario']) {
            $sql2 = "INSERT INTO historial_publico (id_publico,comentario,observacion,
                    id_tipo,id_accion,fecha_accion,estado_h,fec_reg,user_reg) 
                    VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario'] . "',
                    '" . $dato['comentario'] . "','" . $dato['id_tipo'] . "','" . $dato['id_accion'] . "',
                    '" . $dato['fecha_accion'] . "','" . $dato['estado_h'] . "',NOW(),$id_usuario)";
            $this->db->query($sql2);
        }
    }

    function delete_historial_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE historial_publico SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_historial='" . $dato['id_historial'] . "' ";
        $this->db->query($sql);
    }

    function insert_publico_duplicado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO publico (cod_publico,id_tipo,nombres_apellidos,dni,contacto1,contacto2,
                id_departamento,id_provincia,id_distrito,correo,facebook,duplicado,mailing,
                id_producto_interes,estado,fec_reg,user_reg) 
                SELECT cod_publico,id_tipo,nombres_apellidos,dni,contacto1,contacto2,id_departamento,
                id_provincia,id_distrito,correo,facebook,1,mailing,id_producto_interes,2,NOW(),
                $id_usuario FROM publico
                WHERE id_publico='" . $dato['id_publico'] . "'";
        $this->db->query($sql);
    }

    function insert_historial_publico_duplicado($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_tipo,id_accion,
                fecha_accion,estado_h,estado,fec_reg,user_reg)
                SELECT '" . $dato['ultimo_id_publico'] . "',comentario,observacion,id_tipo,id_accion,
                fecha_accion,estado_h,estado,NOW(),$id_usuario FROM historial_publico
                WHERE id_publico='" . $dato['id_publico'] . "'";
        $this->db->query($sql);
    }

    function get_list_correo_registro($correo)
    {
        $sql = "SELECT pu.id_publico,hp.comentario FROM publico pu
                LEFT JOIN (SELECT id_publico,MAX(id_historial) AS id_historial
                FROM historial_publico
                GROUP BY id_publico) AS ul ON ul.id_publico=pu.id_publico
                LEFT JOIN historial_publico hp ON hp.id_historial=ul.id_historial
                WHERE pu.correo='$correo'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_historial_publico_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_publico (id_publico,comentario,observacion,id_accion,
                fecha_accion,mailing,estado_h,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_publico'] . "','" . $dato['comentario'] . "','" . $dato['observacion'] . "',2,
                '" . $dato['fecha_accion'] . "',1,62,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function buscar_tipo_publico($nom_tipo)
    {
        $sql = "SELECT id_tipo FROM tipo_publico
                WHERE nom_tipo='$nom_tipo'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function buscar_departamento($nombre_departamento)
    {
        $sql = "SELECT id_departamento FROM departamento
                WHERE nombre_departamento='$nombre_departamento'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function buscar_provincia($nombre_departamento, $nombre_provincia)
    {
        $sql = "SELECT pr.id_provincia FROM provincia pr
                LEFT JOIN departamento de ON pr.id_departamento=de.id_departamento
                WHERE de.nombre_departamento='$nombre_departamento' AND 
                pr.nombre_provincia='$nombre_provincia'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function buscar_distrito($nombre_departamento, $nombre_provincia, $nombre_distrito)
    {
        $sql = "SELECT di.id_distrito FROM distrito di
                LEFT JOIN departamento de ON di.id_departamento=de.id_departamento
                LEFT JOIN provincia pr ON di.id_provincia=pr.id_provincia
                WHERE de.nombre_departamento='$nombre_departamento' AND 
                pr.nombre_provincia='$nombre_provincia' AND di.nombre_distrito='$nombre_distrito'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function buscar_producto_interes($nom_producto_interes)
    {
        $sql = "SELECT id_producto_interes FROM producto_interes
                WHERE id_empresa=6 AND nom_producto_interes='$nom_producto_interes'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_temporal_importacion_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_importacion_publico (id_usuario,v_tipo_publico,v_nombres_apellidos,
                v_nombres_apellidos_inv,v_numerico_dni,v_cantidad_dni,v_contacto1,v_numerico,v_cantidad,
                v_inicial,v_nombre_departamento,v_nombre_provincia,v_nombre_distrito,v_correo,v_correo_inv,
                v_producto_interes,v_comentario,v_publico) 
                VALUES ($id_usuario,'" . $dato['v_tipo_publico'] . "','" . $dato['v_nombres_apellidos'] . "',
                '" . $dato['v_nombres_apellidos_inv'] . "','" . $dato['v_numerico_dni'] . "',
                '" . $dato['v_cantidad_dni'] . "','" . $dato['v_contacto1'] . "','" . $dato['v_numerico'] . "',
                '" . $dato['v_cantidad'] . "','" . $dato['v_inicial'] . "','" . $dato['v_nombre_departamento'] . "',
                '" . $dato['v_nombre_provincia'] . "','" . $dato['v_nombre_distrito'] . "','" . $dato['v_correo'] . "',
                '" . $dato['v_correo_inv'] . "','" . $dato['v_producto_interes'] . "','" . $dato['v_comentario'] . "',
                '" . $dato['v_publico'] . "')";
        $this->db->query($sql);
    }

    function get_list_temporal_importacion_publico()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_importacion_publico 
                WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_temporal_importacion_publico_correcto()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_temporal FROM temporal_importacion_publico 
                WHERE id_usuario=$id_usuario AND v_tipo_publico=0 AND v_nombres_apellidos=0 AND 
                v_nombres_apellidos_inv=0 AND v_numerico_dni=0 AND v_cantidad_dni=0 AND v_contacto1=0 AND 
                v_numerico=0 AND v_cantidad=0 AND v_inicial=0 AND v_nombre_departamento=0 AND 
                v_nombre_provincia=0 AND v_nombre_distrito=0 AND v_correo=0 AND v_correo_inv=0 AND 
                v_producto_interes=0 AND v_comentario=0 AND v_publico=0";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function importar_publico($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO publico (cod_publico,id_tipo,nombres_apellidos,dni,contacto1,contacto2,id_departamento,
                id_provincia,id_distrito,correo,facebook,id_producto_interes,importacion,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['cod_publico'] . "','" . $dato['id_tipo'] . "','" . $dato['nombres_apellidos'] . "',
                '" . $dato['dni'] . "','" . $dato['contacto1'] . "','" . $dato['contacto2'] . "','" . $dato['id_departamento'] . "',
                '" . $dato['id_provincia'] . "','" . $dato['id_distrito'] . "','" . $dato['correo'] . "',
                '" . $dato['facebook'] . "','" . $dato['id_producto_interes'] . "',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_temporal_importacion_publico()
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_importacion_publico 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function get_cierres_caja_pendientes()
    {
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=6 and cerrada=0 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cierres_caja_sin_cofre()
    {
        $sql = "SELECT id_cierre_caja FROM cierre_caja_empresa 
                WHERE id_empresa=6 and (cofre='' OR cofre IS NULL) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso_p_ne($fec_in, $fec_fi, $tipo)
    {
        if ($tipo == 1) {
            $parte = "AND codigo NOT LIKE '%C%' 
                    AND codigo NOT IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        } else {
            $parte = "AND codigo IN ('01','02','03','04','05','06','07','08','09','10',
                    '11','12','13','14','15','16','17','18','19','20')";
        }

        $sql = "WITH AsistenciasConNumeroDeFila AS (
            SELECT codigo, ingreso,estado,apater,amater,id_alumno,nombres,especialidad,grupo,modulo,
                estado_reporte,estado_ingreso,reg_automatico,user_reg,user_autorizado,estado_asistencia,
                ROW_NUMBER() OVER (PARTITION BY Codigo ORDER BY Fecha DESC) AS NumeroDeFila
            FROM registro_ingreso
            where estado=2 AND CONVERT(varchar,ingreso,23) BETWEEN '$fec_in' AND '$fec_fi' $parte)
            SELECT ri.Codigo,  ri.id_alumno as codigo2, ingreso,ri.estado,ri.apater,ri.amater,ri.estado_asistencia,'' AS obs,'' AS tipo_desc,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN ri.id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)
                THEN CONCAT(ri.nombres,' ',ri.codigo) ELSE ri.nombres END AS nombre,
                es.abreviatura,ri.grupo,ri.modulo,
                CASE WHEN ri.estado_reporte=1 THEN 
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
                ELSE ue.usuario_codigo END AS usuario_registro,us.usuario_codigo
            FROM AsistenciasConNumeroDeFila ri 
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN todos_l20 td ON ri.id_alumno=td.Id AND td.Tipo=2
                LEFT JOIN especialidad es ON ri.especialidad=es.nom_especialidad AND es.estado=2
            WHERE NumeroDeFila = 1  
            ORDER BY ingreso DESC";

        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }
    //---------------------------------------------MAILING-------------------------------------------
    function get_list_mailing($id_mailing = null)
    {
        if (isset($id_mailing) && $id_mailing > 0) {
            $sql = "SELECT * FROM mailing_alumno 
                    WHERE id_mailing=$id_mailing";
        } else {
            $sql = "SELECT ma.id_mailing,ma.codigo,CASE WHEN ma.tipo_envio=1 THEN 'Matricula'
                    WHEN ma.tipo_envio=2 THEN 'Fecha' ELSE '' END AS nom_tipo_envio,ma.titulo,ma.texto,
                    ma.documento,st.nom_status,st.color,CASE WHEN SUBSTRING(ma.fecha_envio,1,1)='2' THEN
                    DATE_FORMAT(ma.fecha_envio,'%d-%m-%Y') ELSE '' END AS fecha_envio,
                    CASE WHEN ma.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                    FROM mailing_alumno ma
                    LEFT JOIN status st ON ma.estado_m=st.id_status
                    WHERE ma.id_empresa=6 AND ma.estado IN (2,3)
                    ORDER BY ma.codigo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_mailing()
    {
        $sql = "SELECT Id AS id_alumno,CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',
                Nombre) AS nom_alumno
                FROM todos_l20
                WHERE Alumno='Matriculado' AND Matricula='Asistiendo' AND Tipo=1
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grupo_mailing()
    {
        $sql = "SELECT Grupo FROM todos_l20 
                WHERE Alumno='Matriculado' AND Matricula='Asistiendo' AND Tipo=1 AND Grupo!=''
                GROUP BY Grupo 
                ORDER BY Grupo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_especialidad_mailing($grupo)
    {
        $sql = "SELECT Especialidad FROM todos_l20
                WHERE Alumno='Matriculado' AND Matricula='Asistiendo' AND Tipo=1 AND 
                Grupo='$grupo' AND Especialidad!=''
                GROUP BY Especialidad 
                ORDER BY Especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_turno_mailing($grupo, $especialidad)
    {
        $sql = "SELECT Turno FROM todos_l20 
                WHERE Alumno='Matriculado' AND Matricula='Asistiendo' AND Tipo=1 AND 
                Grupo='$grupo' AND Especialidad='$especialidad' AND Turno!=''
                GROUP BY Turno 
                ORDER BY Turno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_modulo_mailing($grupo, $especialidad, $turno)
    {
        $sql = "SELECT Modulo FROM todos_l20 
                WHERE Alumno='Matriculado' AND Matricula='Asistiendo' AND Tipo=1 AND 
                Grupo='$grupo' AND Especialidad='$especialidad' AND Turno='$turno' AND Modulo!=''
                GROUP BY Modulo 
                ORDER BY Modulo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_mailing()
    {
        $sql = "SELECT COUNT(1) AS cantidad FROM mailing_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO mailing_alumno (id_empresa,codigo,alumno,grupo,especialidad,turno,modulo,
                tipo_envio,fecha_envio,titulo,texto,documento,estado_m,estado,fec_reg,user_reg) 
                VALUES (6,'" . $dato['codigo'] . "','" . $dato['alumno'] . "','" . $dato['grupo'] . "',
                '" . $dato['especialidad'] . "','" . $dato['turno'] . "','" . $dato['modulo'] . "',
                '" . $dato['tipo_envio'] . "','" . $dato['fecha_envio'] . "','" . $dato['titulo'] . "',
                '" . $dato['texto'] . "','" . $dato['documento'] . "','" . $dato['estado_m'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_mailing()
    {
        $sql = "SELECT id_mailing FROM mailing_alumno
                ORDER BY id_mailing DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_envio_mailing($dato)
    {
        $sql = "INSERT INTO envio_mailing_alumno (id_mailing,id_alumno) 
                VALUES ('" . $dato['id_mailing'] . "','" . $dato['id_alumno'] . "')";
        $this->db->query($sql);
    }

    function get_list_envio_mailing($id_mailing)
    {
        $sql = "SELECT id_alumno FROM envio_mailing_alumno
                WHERE id_mailing=$id_mailing";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET codigo='" . $dato['codigo'] . "',alumno='" . $dato['alumno'] . "',
                grupo='" . $dato['grupo'] . "',especialidad='" . $dato['especialidad'] . "',
                turno='" . $dato['turno'] . "',modulo='" . $dato['modulo'] . "',
                tipo_envio='" . $dato['tipo_envio'] . "',fecha_envio='" . $dato['fecha_envio'] . "',
                titulo='" . $dato['titulo'] . "',texto='" . $dato['texto'] . "',documento='" . $dato['documento'] . "',
                estado_m='" . $dato['estado_m'] . "',fec_act=NOW(),user_act=$id_usuario
                WHERE id_mailing='" . $dato['id_mailing'] . "'";
        $this->db->query($sql);
    }

    function delete_envio_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM envio_mailing_alumno
                WHERE id_mailing='" . $dato['id_mailing'] . "'";
        $this->db->query($sql);
    }

    function get_mailing_activos()
    {
        $sql = "SELECT id_mailing,titulo,texto,documento
                FROM mailing_alumno 
                WHERE id_empresa=6 AND enviado=0 AND estado_m=2 AND 
                (tipo_envio=1 OR (tipo_envio=2 AND fecha_envio=CURDATE())) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_datos_alumno_mailing($id_mailing)
    {
        $sql = "CALL datos_alumno_mailing ($id_mailing)";
        $query = $this->db->query($sql)->result_Array();
        mysqli_next_result($this->db->conn_id);
        return $query;
    }

    function insert_detalle_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_mailing_alumno (id_mailing,id_alumno,cod_alumno,apater_alumno,
                amater_alumno,nom_alumno,email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,
                turno_alumno,modulo_alumno,id_apoderado,apater_apoderado,amater_apoderado,nom_apoderado,
                parentesco_apoderado,email_apoderado,celular_apoderado,fecha_envio,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_mailing'] . "','" . $dato['id_alumno'] . "','" . $dato['cod_alumno'] . "',
                '" . $dato['apater_alumno'] . "','" . $dato['amater_alumno'] . "','" . $dato['nom_alumno'] . "',
                '" . $dato['email_alumno'] . "','" . $dato['celular_alumno'] . "','" . $dato['grupo_alumno'] . "',
                '" . $dato['especialidad_alumno'] . "','" . $dato['turno_alumno'] . "','" . $dato['modulo_alumno'] . "',
                '" . $dato['id_apoderado'] . "','" . $dato['apater_apoderado'] . "','" . $dato['amater_apoderado'] . "',
                '" . $dato['nom_apoderado'] . "','" . $dato['parentesco_apoderado'] . "','" . $dato['email_apoderado'] . "',
                '" . $dato['celular_apoderado'] . "',NOW(),2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_enviado_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET enviado=1,estado_m=3
                WHERE id_mailing='" . $dato['id_mailing'] . "'";
        $this->db->query($sql);
    }

    function delete_mailing($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_mailing='" . $dato['id_mailing'] . "'";
        $this->db->query($sql);
    }

    function get_list_detalle_mailing($id_mailing)
    {
        $sql = "SELECT fecha_envio AS orden,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                CASE WHEN id_apoderado>0 THEN 
                CONCAT(apater_apoderado,' ',amater_apoderado,', ',nom_apoderado) ELSE '' END AS nom_apoderado,
                parentesco_apoderado,email_apoderado,celular_apoderado,
                DATE_FORMAT(fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(fecha_envio,'%H:%i') AS hora_envio
                FROM detalle_mailing_alumno
                WHERE id_mailing=$id_mailing AND estado=2
                ORDER BY fecha_envio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_contrato_alumno($alumno)
    {

        $sql = "SELECT co.referencia,co.descripcion,df.cod_alumno,df.email_alumno,
                DATE_FORMAT(df.fecha_envio,'%d-%m-%Y') AS fec_envio, DATE_FORMAT(df.fecha_envio,'%H:%i') AS hora_envio, 
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma, DATE_FORMAT(df.fecha_firma,'%H:%i') AS hora_firma, 
                CASE WHEN df.arpay=1 THEN 'Si' ELSE 'No' END v_arpay,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' WHEN df.estado_d=3 THEN 'Firmado' WHEN df.estado_d=4 THEN 'Validado' END AS nom_status, 
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' WHEN df.estado_d=3 THEN '#00C000' WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status
                FROM documento_firma df
                LEFT JOIN nuevos_fv nf ON nf.Id=df.id_alumno
                LEFT JOIN c_contrato co ON co.id_c_contrato=df.id_contrato
                WHERE df.id_empresa=6 and df.id_alumno=$alumno";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_postulantes_formulario($tipo)
    {
        $var = 'ORDER BY ad.codigo_admision';
        if ($tipo == 4) {
            $var = 'WHERE flag_btn_enviar=1';
        }
        //case when ad.user_reg = 99 then 'Web' else u.usuario_nombres end as 'creadopor',
        //left join users u on ad.user_reg = u.id_usuario
        $sql = "SELECT ad.id_admision as 'Id_Admision',
            ad.codigo_admision,
            es.abreviatura as 'especialidad',
            cgt.nom_confgen as 'turno',
            cont_dni_admision as 'dni',
            ad.alum_apepat_admision as 'Apellido_Paterno', 
            ad.alum_apemat_admision as 'Apellido_Materno',
            ad.alum_nombre_admision as 'Nombre', 
            CONVERT(VARCHAR, ad.fec_reg, 103) as 'fec_reg', 
            case when ad.user_reg = 99 then 'Web' else us.usuario_codigo  end as 'creadopor',
            cgm.nom_confgen as 'modalidad',
            ad.grupo as 'grupo',
            cge2.nom_confgen as 'Estado_Doc_Postulante'
            from admision ad
            left join especialidad es on ad.admi_programa_admision=es.id_especialidad and es.estado=2
            left join configuracion_general cgt on ad.admi_turno_admision=cgt.id_confgen and cgt.id_confgen_confmae=3
            left join configuracion_general cgm on ad.admi_modalidad_admision=cgm.id_confgen and cgm.id_confgen_confmae=8
            left join configuracion_general cge2 on ad.estado2=cge2.id_confgen and cge2.id_confgen_confmae=10
            left join users us on ad.user_reg=us.id_usuario and us.estado=2
            $var";
        //echo ($sql);
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function get_list_programa_interes($id_tipo){
        $sql = "select * from especialidad where id_tipo_especialidad='$id_tipo' and estado=2 order by nom_especialidad;";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_doc($id_confgen_confmae)
    {
        $var = 'order by nom_confgen';
        if ($id_confgen_confmae == 7) {
            $var = '';
        } else if ($id_confgen_confmae == 9) {
            $var = 'and id_confgen=42';
        }
        $sql = "select id_confgen,nom_confgen,color from configuracion_general where id_confgen_confmae=$id_confgen_confmae and estado=2 $var;";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    //---------------------------------------------PERFIL-------------------------------------------
    function get_list_perfil($id_perfil = null)
    {
        if (isset($id_perfil)) {
            $sql = "SELECT * FROM perfil
                    WHERE id_perfil=$id_perfil";
        } else {
            $sql = "SELECT pe.id_perfil,pe.nom_perfil,st.nom_status,st.color
                    FROM perfil pe
                    LEFT JOIN status st ON pe.estado=st.id_status
                    WHERE pe.id_empresa=6 AND pe.estado=2
                    ORDER BY pe.nom_perfil ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_perfil($id_perfil = null, $dato)
    {
        $parte = "";
        if (isset($id_perfil)) {
            $parte = "AND id_perfil!=$id_perfil";
        }
        $sql = "SELECT id_perfil FROM perfil
                WHERE id_empresa=6 AND nom_perfil='" . $dato['nom_perfil'] . "' AND estado=2 $parte";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_perfil($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO perfil (id_empresa,id_sede,nom_perfil,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES (6,9,'" . $dato['nom_perfil'] . "','" . $dato['estado'] . "',NOW(),$id_usuario,NOW(),
                $id_usuario)";
        $this->db->query($sql);
        $sql2 = "INSERT INTO perfil (id_empresa,id_sede,nom_perfil,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES (6,9,'" . $dato['nom_perfil'] . "','" . $dato['estado'] . "',getdate(),$id_usuario,getdate(),
                $id_usuario)";
        $this->db5->query($sql2);
    }

    function update_perfil($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE perfil SET nom_perfil='" . $dato['nom_perfil'] . "',estado='" . $dato['estado'] . "',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_perfil='" . $dato['id_perfil'] . "'";
        $this->db->query($sql);
        $sql2 = "UPDATE perfil SET nom_perfil='" . $dato['nom_perfil'] . "',estado='" . $dato['estado'] . "',
                fec_act=getdate(),user_act=$id_usuario
                WHERE id_perfil='" . $dato['id_perfil'] . "'";
        $this->db5->query($sql2);
    }

    function delete_perfil($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE perfil SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_perfil='" . $dato['id_perfil'] . "'";
        $this->db->query($sql);
        $sql2 = "UPDATE perfil SET estado=4,fec_eli=getdate(),user_eli=$id_usuario
                WHERE id_perfil='" . $dato['id_perfil'] . "'";
        $this->db5->query($sql2);
    }

    function update_comentario_colaborador($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET comentariog='" . $dato['comentariog'] . "'
                WHERE id_colaborador='" . $dato['id_colaborador'] . "'";
        $this->db->query($sql);
    }

    function update_comentario_alumno($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE todos_l20 SET comentariog='" . $dato['comentariog'] . "'
                WHERE Id='" . $dato['id_alumno'] . "'";
        $this->db->query($sql);
    }

    function get_list_grupo_manual()
    {
        $sql = "SELECT id_maestro_detalle, nom_maestro_detalle, color_maestro_detalle FROM maestro_detalle where id_maestro_detalle in (4,6)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //---------------------------------------------Colabordor--Observaciones-------------------------------------------
    function get_list_colaborador_obs()
    {
        $sql = "SELECT c.apellido_Paterno,c.apellido_Materno,c.nombres,c.codigo_gll,e.nom_empresa,
                DATE_FORMAT(oc.fec_reg, '%d-%m-%Y') AS fecha_registro,oc.observacion AS Comentario,
                u.usuario_codigo,c.id_empresa
                FROM observacion_colaborador oc
                LEFT JOIN colaborador c ON c.id_colaborador=oc.id_colaborador
                LEFT JOIN empresa e ON e.id_empresa=c.id_empresa
                LEFT JOIN users u ON u.id_usuario=c.user_reg
                WHERE oc.id_empresa = 6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    // ---------------------- lISTA DE FOTOCHECKS DE IFV--------------------------------------
    function get_list_fotocheck_colab($tipo)
    {
        $parte = " f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if ($tipo == 1) {
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
                FROM fotocheck_ifv f
                LEFT JOIN colaborador tl ON f.Id=tl.id_colaborador
                WHERE $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_fotocheck_colab($id_fotocheck)
    {
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
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3,
                tl.Especialidad,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,
                YEAR(fo.fecha_fotocheck) AS anio_fotocheck,MONTH(fo.fecha_fotocheck) AS mes_fotocheck,
                case when length(concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno)) > 18 then 
                concat(tl.Apellido_Paterno,' ',substring(tl.Apellido_Materno,1,1),'.')else concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno) end as apellidos,
                IF(LENGTH(tl.nombre) > 20, CONCAT(SUBSTRING(tl.nombre, 1, 20),'.'),tl.nombre) AS Nombre_corto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio
                FROM fotocheck_ifv fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN todos_l20 tl ON tl.Id=fo.Id
                WHERE fo.id_fotocheck=$id_fotocheck";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_foto_fotocheck_Colab($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $estado = "";
        if ($dato['n_foto'] == 1) {
            $foto_fotocheck = "foto_fotocheck";
            $usuario_foto = "usuario_foto";
            $fecha_recepcion = "fecha_recepcion";
        } else {
            if ($dato['n_foto'] == 2) {
                $estado = "esta_fotocheck=1,";
            }
            $foto_fotocheck = "foto_fotocheck_" . $dato['n_foto'];
            $usuario_foto = "usuario_foto_" . $dato['n_foto'];
            $fecha_recepcion = "fecha_recepcion_" . $dato['n_foto'];
        }
        $sql = "UPDATE fotocheck_ifv SET $foto_fotocheck='" . $dato[$foto_fotocheck] . "',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    function valida_fotocheck_completo_Colab($id_fotocheck)
    {
        $sql = "SELECT id_fotocheck FROM fotocheck_ifv 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_fotocheck_completo_Colab($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ifv SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    function impresion_fotocheck_colab($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ifv SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }
    function anular_envio_colab($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ifv SET esta_fotocheck=3,obs_anulado='" . $dato['obs_anulado'] . "',usuario_anulado=$id_usuario,fecha_anulado=NOW(),user_act=$id_usuario 
        WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";

        $this->db->query($sql);
    }
    function update_envio_fotocheck_colab($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ifv SET fecha_envio='" . $dato['fecha_envio'] . "',
                    usuario_encomienda='" . $dato['usuario_encomienda'] . "',
                    cargo_envio='" . $dato['cargo_envio'] . "',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='" . $dato['id_fotocheck'] . "'";
        $this->db->query($sql);
    }

    // Excel postulante 

    function get_list_postulantes_formulario_excel($tipo)
    {
        $var = 'ORDER BY ad.codigo_admision';
        if ($tipo == 4) {
            $var = 'WHERE flag_btn_enviar=1';
        }
        $sql = "SELECT 
        ad.codigo_admision,			 					
        es.abreviatura as 'Especialidad',	
        es.nom_especialidad as 'Nombre_Especialidad',
        cgm.nom_confgen as 'Modalidad',
        cgt.nom_confgen as 'Turno',
        ad.grupo as 'Grupo',
        cgdni.nom_confgen as 'Tipo_Doc_Ident',
        ad.cont_dni_admision as 'Nro_Doc_Alumno', 
        ad.alum_apepat_admision as 'Apellido_Paterno',  
        ad.alum_apemat_admision as 'Apellido_Materno', 
        ad.alum_nombre_admision as 'Nombre', 
        ad.alum_fecha_nac_admision as 'Fecha_Nacimiento', 
        sx.nom_confgen as 'Sexo',							
        ad.cont_celular_admision as 'Celular_Alumno', 
        ad.cont_email_admision as 'Email_Alumno', 
        ad.domi_nom_admision as 'Domicilio', 
        ds.nombre_distrito as 'Distrito', 
        pv.nombre_provincia as 'Provincia', 
        dp.nombre_departamento as 'Departamento', 
        ad.col_inti_nom AS 'Colegio_Procedencia',  
        dscp.nombre_distrito as 'Distrito_Colegio', 
        pvcp.nombre_provincia as 'Provincia_Colegio', 
        dpcp.nombre_departamento as 'Departamento_Colegio', 
        cgdnit.nom_confgen as 'Tipo_Doc_Ident_Tutor', 
        ad.tutor_num_doc_admision as 'Nro_Doc_Tutor', 
        par.nom_confgen as 'Parentesco_Tutor', 
        ad.tutor_nombre_admision as 'Nombre_Tutor',  
        ad.tutor_apepat_admision as 'Apellido_Paterno_Tutor',  
        ad.tutor_apemat_admision as 'Apellido_Materno_Tutor',  
        cen.nom_confgen as 'CEN',  
        CASE WHEN ad.doc_dni_alum_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_DNI_Alumno',    
        CASE WHEN ad.doc_dni_tuto_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_DNI_Tutor',   
        CASE WHEN ad.doc_certificado_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_Certificado', 
        CASE WHEN ad.doc_tramite_admision = 1 THEN 'Si' ELSE 'No' END AS 'Doc_Tramite',  
        CONVERT(VARCHAR, ad.fec_reg, 103) as 'Fec_reg',														
        case when ad.user_reg = 99 then 'Web' else CONVERT(VARCHAR(10), ad.user_reg) end as 'creadopor',
        cge2.nom_confgen as 'Estado_Doc_Postulante'
        from admision ad
        left join especialidad es on ad.admi_programa_admision=es.id_especialidad and es.estado=2
        left join configuracion_general cgt on ad.admi_turno_admision=cgt.id_confgen and cgt.id_confgen_confmae=3
        left join configuracion_general cgm on ad.admi_modalidad_admision=cgm.id_confgen and cgm.id_confgen_confmae=8
        left join configuracion_general cgdni on ad.cont_tipo_doc_admision=cgdni.id_confgen and cgdni.id_confgen_confmae=2 
        left join configuracion_general cgdnit on ad.tutor_tip_doc_admision=cgdnit.id_confgen and cgdnit.id_confgen_confmae=2 
        left join configuracion_general sx on ad.alum_sexo_admision=sx.id_confgen and sx.id_confgen_confmae=4 
        left join distrito ds on ad.domi_dist_admision=ds.id_distrito and ds.estado=2
        left join provincia pv on ad.domi_prov_admision=pv.codigo_provincia and pv.estado=2
        left join departamento dp on ad.domi_dep_admision=dp.codigo_departamento and pv.estado=2
        left join configuracion_general par on ad.tutor_parentesco_admision=par.id_confgen and par.id_confgen_confmae=5 
        left join configuracion_general cen on ad.admi_nosotros_admision=cen.id_confgen and cen.id_confgen_confmae=7
        left join distrito dscp on ad.col_dist_admision=dscp.id_distrito and dscp.estado=2
        left join provincia pvcp on ad.col_prov_admision=pvcp.codigo_provincia and pvcp.estado=2
        left join departamento dpcp on ad.col_dep_admision=dpcp.codigo_departamento and dpcp.estado=2
        left join configuracion_general cge2 on ad.estado2=cge2.id_confgen and cge2.id_confgen_confmae=10
        $var";
        //echo ($sql);
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_id_postulantes($id_alumno)
    {
        $sql = "SELECT
        ad.id_admision,
        ad.codigo_admision as 'Codigo',			 					
        es.abreviatura as 'Especialidad',	
        es.nom_especialidad as 'Nombre_Especialidad',
        cgm.nom_confgen as 'Modalidad',
        cgt.nom_confgen as 'Turno',
        ad.grupo as 'Grupo',
        cgdni.nom_confgen as 'Tipo_Doc_Ident',
        ad.cont_dni_admision as 'Nro_Doc_Alumno', 
        ad.alum_apepat_admision as 'Apellido_Paterno',  
        ad.alum_apemat_admision as 'Apellido_Materno', 
        ad.alum_nombre_admision as 'Nombre', 
        CASE WHEN ad.alum_apepat_admision IS NOT NULL AND ad.alum_apemat_admision IS NOT NULL AND ad.alum_nombre_admision IS NOT NULL THEN
                CONCAT(ad.alum_apepat_admision, ' ', ad.alum_apemat_admision, ', ', ad.alum_nombre_admision) ELSE '' END AS Nombre_Completo,
        ad.alum_fecha_nac_admision as 'Fecha_Nacimiento', 
        DATEDIFF(YEAR, ad.alum_fecha_nac_admision, GETDATE()) AS edad,
        sx.nom_confgen as 'Sexo',							
        ad.cont_celular_admision as 'Celular_Alumno', 
        ad.cont_email_admision as 'Email_Alumno', 
        ad.domi_nom_admision as 'Domicilio', 
        ds.nombre_distrito as 'Distrito', 
        pv.nombre_provincia as 'Provincia', 
        dp.nombre_departamento as 'Departamento', 
        ad.col_inti_nom AS 'Colegio_Procedencia',  
        dscp.nombre_distrito as 'Distrito_Colegio', 
        pvcp.nombre_provincia as 'Provincia_Colegio', 
        dpcp.nombre_departamento as 'Departamento_Colegio', 
        cgdnit.nom_confgen as 'Tipo_Doc_Ident_Tutor', 
        ad.tutor_num_doc_admision as 'Nro_Doc_Tutor', 
        par.nom_confgen as 'Parentesco_Tutor', 
        ad.tutor_nombre_admision as 'Nombre_Tutor',  
        ad.tutor_apepat_admision as 'Apellido_Paterno_Tutor',  
        ad.tutor_apemat_admision as 'Apellido_Materno_Tutor',  
        cen.nom_confgen as 'CEN',  
        CASE WHEN ad.doc_dni_alum_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_DNI_Alumno',    
        CASE WHEN ad.doc_dni_tuto_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_DNI_Tutor',   
        CASE WHEN ad.doc_certificado_admision IS NULL  THEN 'No' ELSE 'Si' END AS 'Doc_Certificado', 
        CASE WHEN ad.doc_tramite_admision = 1 THEN 'Si' ELSE 'No' END AS 'Doc_Tramite',  
        CONVERT(VARCHAR, ad.fec_reg, 103) as 'Fec_reg',														
        case when ad.user_reg = 99 then 'Web' else CONVERT(VARCHAR(10), ad.user_reg) end as 'creadopor',
        cge2.nom_confgen as 'Estado_Doc_Postulante'
        from admision ad
        left join especialidad es on ad.admi_programa_admision=es.id_especialidad and es.estado=2
        left join configuracion_general cgt on ad.admi_turno_admision=cgt.id_confgen and cgt.id_confgen_confmae=3
        left join configuracion_general cgm on ad.admi_modalidad_admision=cgm.id_confgen and cgm.id_confgen_confmae=8
        left join configuracion_general cgdni on ad.cont_tipo_doc_admision=cgdni.id_confgen and cgdni.id_confgen_confmae=2 
        left join configuracion_general cgdnit on ad.tutor_tip_doc_admision=cgdnit.id_confgen and cgdnit.id_confgen_confmae=2 
        left join configuracion_general sx on ad.alum_sexo_admision=sx.id_confgen and sx.id_confgen_confmae=4 
        left join distrito ds on ad.domi_dist_admision=ds.id_distrito and ds.estado=2
        left join provincia pv on ad.domi_prov_admision=pv.codigo_provincia and pv.estado=2
        left join departamento dp on ad.domi_dep_admision=dp.codigo_departamento and pv.estado=2
        left join configuracion_general par on ad.tutor_parentesco_admision=par.id_confgen and par.id_confgen_confmae=5 
        left join configuracion_general cen on ad.admi_nosotros_admision=cen.id_confgen and cen.id_confgen_confmae=7
        left join distrito dscp on ad.col_dist_admision=dscp.id_distrito and dscp.estado=2
        left join provincia pvcp on ad.col_prov_admision=pvcp.codigo_provincia and pvcp.estado=2
        left join departamento dpcp on ad.col_dep_admision=dpcp.codigo_departamento and dpcp.estado=2
        left join configuracion_general cge2 on ad.estado2=cge2.id_confgen and cge2.id_confgen_confmae=10
        WHERE ad.id_admision=$id_alumno";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_grupo_postulante($dni_alumno)
    {
        $sql = "SELECT 
                grupo
                FROM admision
                WHERE cont_dni_admision=$dni_alumno";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_id_postulantes_grupo($dni_alumno, $grupo)
    {
        if ($grupo == "") {
            $sql = "SELECT 
            '' as 'id_admision',
            '' as 'cont_dni_admision',
            '' as 'Codigo',			 					
            '' as 'Especialidad',	
            '' as 'Nombre_Especialidad',
            '' as 'Modalidad',
            '' as 'Turno',
            '' as 'Grupo',
            '' as 'edad',
            '' as 'Tipo_Doc_Ident',
            '' as 'Apellido_Paterno',  
            '' as 'Apellido_Materno', 
            '' as 'Nombre',  
            '' as 'CEN',  
            '' as 'Doc_DNI_Alumno',    
            '' as 'Doc_DNI_Tutor',   
            '' as 'Doc_Certificado', 
            '' as 'Doc_Tramite',
            '' as 'Fec_reg',													
            '' as 'Evaluacion',
            '' as 'Nota',
            '' as 'Est_Of',													
            '' as 'creadopor'
            from admision ad
            ";
            $query = $this->db6->query($sql)->result_Array();
            //$query = $this->db6->query($sql, array($dni_alumno, $grupo))->result_Array();
        } else {
            $sql = "SELECT 
        ad.id_admision,
        ad.cont_dni_admision,
        ad.codigo_admision as 'Codigo',			 					
        es.abreviatura as 'Especialidad',	
        es.nom_especialidad as 'Nombre_Especialidad',
        cgm.nom_confgen as 'Modalidad',
        cgt.nom_confgen as 'Turno',
        ad.grupo as 'Grupo',
        cgdni.nom_confgen as 'Tipo_Doc_Ident',
        ad.alum_apepat_admision as 'Apellido_Paterno',  
        ad.alum_apemat_admision as 'Apellido_Materno', 
        ad.alum_nombre_admision as 'Nombre',  
        DATEDIFF(YEAR, ad.alum_fecha_nac_admision, GETDATE()) AS edad,
        cen.nom_confgen as 'CEN',  
        CASE WHEN ad.doc_dni_alum_admision IS NULL  THEN 'No' ELSE 'No' END AS 'Doc_DNI_Alumno',    
        CASE WHEN ad.doc_dni_tuto_admision IS NULL  THEN 'No' ELSE 'No' END AS 'Doc_DNI_Tutor',   
        CASE WHEN ad.doc_certificado_admision IS NULL  THEN 'No' ELSE 'No' END AS 'Doc_Certificado', 
        CASE WHEN ad.doc_tramite_admision = 1 THEN 'Si' ELSE 'No' END AS 'Doc_Tramite',
        CONVERT(VARCHAR, ad.fec_reg, 103) as 'Fec_reg',	
        '' as 'Evaluacion',
        '' as 'Nota',
        '' as 'Est_Of',													
        case when ad.user_reg = 99 then 'Web' else us.usuario_codigo end as 'creadopor'
        from admision ad
        left join especialidad es on ad.admi_programa_admision=es.id_especialidad and es.estado=2
        left join configuracion_general cgt on ad.admi_turno_admision=cgt.id_confgen and cgt.id_confgen_confmae=3
        left join configuracion_general cgm on ad.admi_modalidad_admision=cgm.id_confgen and cgm.id_confgen_confmae=8
        left join configuracion_general cgdni on ad.cont_tipo_doc_admision=cgdni.id_confgen and cgdni.id_confgen_confmae=2 
        left join configuracion_general cen on ad.admi_nosotros_admision=cen.id_confgen and cen.id_confgen_confmae=7
        left join configuracion_general cge2 on ad.estado2=cge2.id_confgen and cge2.id_confgen_confmae=10
        left join users us on ad.user_reg=us.id_usuario and us.estado=2
        WHERE ad.cont_dni_admision = ? and ad.grupo = ?";
            //$query = $this->db6->query($sql)->result_Array();
            $query = $this->db6->query($sql, array($dni_alumno, $grupo))->result_Array();
        }
        return $query;
    }

    function get_list_documento_postulante($id_postulante)
    {
        $sql = "SELECT id_admision, ColumnaNombre, ColumnaValor, CONVERT(VARCHAR, Fec_reg, 103) as 'Fec_reg'
                FROM (
                    SELECT id_admision,doc_dni_alum_admision, doc_dni_tuto_admision, doc_certificado_admision, Fec_reg
                    FROM admision
                ) AS SourceTable
                UNPIVOT (
                    ColumnaValor FOR ColumnaNombre IN  
                    (doc_dni_alum_admision, doc_dni_tuto_admision, doc_certificado_admision)
                ) AS UnpivotedTable
                WHERE id_admision=$id_postulante";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    //---------------------------- Modulo Observaciones - Postulante 

    function get_list_observacion_postulante($id_alumno = null, $id_observacion = null)
    {
        if (isset($id_observacion) && $id_observacion > 0) {
            $sql = "SELECT * FROM postulante_observaciones_general 
                    WHERE id_observacion=$id_observacion";
        } else {
            $sql = "SELECT ao.id_observacion,
                    CONVERT(varchar,ao.fecha_obs,103) AS Fecha,
                    ti.nom_tipo,
                    us.usuario_codigo AS usuario,
                    ao.observacion,
                    ao.fecha_obs AS orden, 
                    ao.observacion_archivo
                    FROM postulante_observaciones_general ao
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=ao.id_tipo_observacion
                    LEFT JOIN users us ON us.id_usuario=ao.usuario_obs
                    WHERE ao.id_postulante=$id_alumno AND ao.estado=2
                    ORDER BY ao.fecha_obs DESC";
        }
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function get_list_tipo_obs_postulante($tipo_usuario = null)
    {
        if (isset($tipo_usuario) && $tipo_usuario > 0) { //consulta tipo usuario? 
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 and tipo_usuario=$tipo_usuario
                    ORDER BY nom_tipo";
        } else {
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 
                    ORDER BY nom_tipo";
        }
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function get_list_usuario_observacion_postulante()
    {
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE id_usuario IN (1,7,9,10) AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function valida_insert_observacion_postulante($dato)
    {
        $sql = "SELECT id_observacion FROM postulante_observaciones_general 
                WHERE id_empresa=6 AND 
                id_postulante='" . $dato['id_postulante'] . "' AND 
                id_tipo_observacion='" . $dato['id_tipo_observacion'] . "' AND observacion='" . $dato['observacion'] . "' AND 
                fecha_obs='" . $dato['fecha'] . "' AND estado=2";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function insert_observacion_postulante($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO postulante_observaciones_general (id_empresa,id_postulante,id_tipo_observacion,observacion,
                fecha_obs,usuario_obs,estado,fec_reg,user_reg, observacion_archivo) 
                VALUES (6,'" . $dato['id_postulante'] . "','" . $dato['id_tipo_observacion'] . "','" . $dato['observacion'] . "',
                '" . $dato['fecha'] . "','" . $dato['usuario'] . "',2,GETDATE(),$id_usuario,
                '" . $dato['observacion_archivo'] . "')";
        $this->db6->query($sql);
    }


    function valida_update_observacion_postulante($dato)
    {
        $sql = "SELECT id_observacion FROM postulante_observaciones_general 
                WHERE id_postulante='" . $dato['id_postulante'] . "' AND 
                id_tipo_observacion='" . $dato['id_tipo_observacion'] . "' AND observacion='" . $dato['observacion'] . "' AND 
                fecha_obs='" . $dato['fecha'] . "' AND estado=2 AND 
                id_observacion!='" . $dato['id_observacion'] . "'";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }



    function update_observacion_postulante($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE postulante_observaciones_general SET id_tipo_observacion='" . $dato['id_tipo_observacion'] . "',
                fecha_obs='" . $dato['fecha'] . "',usuario_obs='" . $dato['usuario'] . "',
                observacion='" . $dato['observacion'] . "',fec_act=GETDATE(),user_act=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db6->query($sql);
    }

    function delete_observacion_postulante($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE postulante_observaciones_general SET estado=1,fec_eli=GETDATE(),user_eli=$id_usuario 
                WHERE id_observacion='" . $dato['id_observacion'] . "'";
        $this->db6->query($sql);
    }

    function get_id_obsaimg_postulante($id_comuimg)
    {
        $sql = "SELECT observacion_archivo
                FROM postulante_observaciones_general
                WHERE id_observacion=$id_comuimg";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_id_doc_postulante($id_admision)
    {
        $sql = "SELECT doc_dni_alum_admision, doc_dni_tuto_admision, doc_certificado_admision 
                FROM admision 
                WHERE id_admision=$id_admision";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_doc_post($id_confgen_confmae, $dato)
    {
        $var = 'order by nom_confgen';
        $var2 = '';
        $var4 = '';
        if ($id_confgen_confmae == 7) {
            $var = '';
        }
        if ($id_confgen_confmae == 8 || $id_confgen_confmae == 3) {
            if ($id_confgen_confmae == 8) {
                $var3 = 'mod_grupo';
                $var4 = "and ga.esp_grupo='" . $dato['admi_programa_admision'] . "' ";
            } else {
                $var3 = 'tur_grupo';
                $var4 = "and ga.esp_grupo='" . $dato['admi_programa_admision'] . "' and ga.mod_grupo='" . $dato['admi_modalidad_admision'] . "' ";
            }

            $var = 'group by id_confgen, nom_confgen, color';
            $var2 = "inner join grupo_admision ga on c.id_confgen = ga." . $var3 . " and ga.estado=39";
        }
        $sql = "select id_confgen,nom_confgen,color 
                from configuracion_general c $var2 
                where id_confgen_confmae=$id_confgen_confmae $var4 and c.estado=2 $var;";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }


    function get_id_postulante_upd($id_alumno)
    {
        $sql = "SELECT 
    a.id_admision,
    a.codigo_admision,
    a.cont_tipo_doc_admision,
    a.cont_dni_admision,
    a.cont_celular_admision,
    a.cont_email_admision,
    a.admi_programa_admision,
    cg_mod.id_confgen as id_modalidad,
	cg_mod.nom_confgen as admi_modalidad_admision,
    a.admi_nosotros_admision,
	cg_tur.id_confgen as id_turno,
    cg_tur.nom_confgen as admi_turno_admision,
    a.alum_apepat_admision,
    a.alum_apemat_admision,
    a.alum_nombre_admision,
    a.alum_fecha_nac_admision,
    DATEDIFF(YEAR, a.alum_fecha_nac_admision, GETDATE()) AS edad,
    a.alum_sexo_admision,
    a.domi_nom_admision,
	dep_dep.id_departamento AS id_departamento_dom,
    prov_dep.codigo_provincia as id_provincia_dom,
    dis_dep.id_distrito AS id_distrito_dom,
    dep_dep.nombre_departamento AS domi_dep_admision,
    prov_dep.nombre_provincia domi_prov_admision,
    dis_dep.nombre_distrito AS domi_dist_admision,
    a.tutor_tip_doc_admision,
    a.tutor_num_doc_admision,
    a.tutor_parentesco_admision,
    a.tutor_apepat_admision,
    a.tutor_apemat_admision,
    a.tutor_nombre_admision,
    a.col_inti_nom,
	dep.id_departamento as id_departamento_col,
	prov.codigo_provincia as id_provincia_col,
	dis.id_distrito as id_distrito_col,
    dep.nombre_departamento as col_dep_admision,
    prov.nombre_provincia as col_prov_admision,
    dis.nombre_distrito as col_dist_admision,
    a.doc_dni_alum_admision,
    a.doc_nombre_dni_alum_admision,
    a.doc_dni_tuto_admision,
    a.doc_nombre_dni_tuto_admision,
    a.doc_certificado_admision,
    a.doc_nombre_certificado_admision,
    a.doc_tramite_admision,
    a.estado,
    a.fec_act,
    a.user_act,
    a.estado2
FROM 
    admision a
LEFT JOIN 
    departamento dep_dep ON a.domi_dep_admision = dep_dep.id_departamento
LEFT JOIN 
    provincia prov_dep ON a.domi_prov_admision = prov_dep.codigo_provincia
LEFT JOIN 
    distrito dis_dep ON a.domi_dist_admision = dis_dep.id_distrito
LEFT JOIN 
    departamento dep ON a.col_dep_admision = dep.id_departamento
LEFT JOIN 
    provincia prov ON a.col_prov_admision = prov.codigo_provincia
LEFT JOIN 
    distrito dis ON a.col_dist_admision = dis.id_distrito
LEFT JOIN
	configuracion_general  cg_mod ON a.admi_modalidad_admision = cg_mod.id_confgen
LEFT JOIN
	configuracion_general  cg_tur ON a.admi_turno_admision = cg_tur.id_confgen
    WHERE 
        a.id_admision = $id_alumno";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }
    function get_list_programa_interes_post($id_tipo){
        $sql = "select id_especialidad,nom_especialidad from especialidad e
                inner join grupo_admision ga on e.id_especialidad = ga.esp_grupo and ga.estado=39
                where id_tipo_especialidad=$id_tipo and e.estado=2 group by id_especialidad,nom_especialidad order by nom_especialidad;";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }
    function get_list_distrito_post($dato)
    {
        $sql = "SELECT * FROM distrito WHERE estado=2 AND id_dep='" . $dato['id_departamento'] . "'
              AND codigo_provincia='" . $dato['id_provincia'] . "'";
        echo $sql;
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    //-----------------------------------------------DOCUMENTO_POSTULANTES------------------------------------------
    function get_list_documento_post($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_postulante_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,
                    CASE 
                        WHEN do.obligatorio = 0 THEN 'No' 
                        WHEN do.obligatorio = 1 THEN 'Si'
                        WHEN do.obligatorio = 2 THEN 'Mayores de 4 (>4)' 
                        WHEN do.obligatorio = 3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    CASE 
                        WHEN do.nom_grado = 0 THEN 'Todos' 
                        ELSE es.nom_especialidad 
                    END AS nom_especialidad,
                    cg.nom_confgen,
                    CASE 
                        WHEN do.validacion = 1 THEN 'Si' 
                        ELSE 'No' 
                    END AS validacion
                    FROM documento_postulante_empresa do
                    LEFT JOIN especialidad es ON es.id_especialidad = do.nom_grado
                    LEFT JOIN configuracion_general cg ON cg.id_confgen = do.estado
                    WHERE do.id_empresa = 6 AND do.estado != 4
                    ORDER BY do.nom_documento ASC, do.descripcion_documento ASC";
        }
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_postulantes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_postulante_empresa (id_postulante, id_documento, id_empresa, anio, estado, fec_reg, user_reg)
                VALUES ('".$dato['id_postulante']."', '".$dato['id_documento']."', 6, '".$dato['anio']."', 2, GETDATE(), $id_usuario)";
        $this->db6->query($sql);
    }

    function get_list_especialidad_combo_postulante(){
        $sql = "SELECT id_especialidad, nom_especialidad, abreviatura 
                FROM especialidad
                WHERE estado = 2 
                ORDER BY nom_especialidad ASC";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_postulante($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_postulante_empresa (id_empresa, cod_documento, nom_grado, nom_documento,
                descripcion_documento, obligatorio, digital, aplicar_todos,
                departamento, aparece_doc, validacion, estado, fec_reg, user_reg) 
                VALUES (6, '".$dato['cod_documento']."', '".$dato['id_especialidad']."',
                '".$dato['nom_documento']."', '".$dato['descripcion_documento']."', '".$dato['obligatorio']."',
                '".$dato['digital']."', '".$dato['aplicar_todos']."', '".$dato['departamento']."',
                '".$dato['aparece_doc']."', '".$dato['validacion']."', 2, GETDATE(), $id_usuario)";
        $this->db6->query($sql);
    }

    function ultimo_id_documento_postulante(){
        $sql = "SELECT id_documento FROM documento_postulante_empresa 
                ORDER BY id_documento DESC"; 
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento_todos_postulante($dato){
        $sql = "SELECT * FROM detalle_postulante_empresa 
        WHERE id_alumno='".$dato['id_alumno']."' AND
        id_documento='".$dato['id_documento']."' AND id_empresa=6 AND estado=2";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_todos_postulante($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_postulante_empresa (id_postulante, id_documento, id_empresa, anio, estado, fec_reg, user_reg)
                VALUES ('".$dato['id_postulante']."', '".$dato['id_documento']."', 6, '".$dato['anio']."', 2, GETDATE(), $id_usuario)";
        $this->db6->query($sql);
    }

    function valida_update_documento_postulante($dato){
        $sql = "SELECT * FROM documento_postulante_empresa 
                WHERE id_empresa=6 AND cod_documento='".$dato['cod_documento']."' AND estado=2 AND 
                id_documento !='".$dato['id_documento']."'";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }
    
    function update_documento_postulante($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_postulante_empresa 
                SET cod_documento = '".$dato['cod_documento']."',
                    nom_grado = '".$dato['id_especialidad']."',
                    nom_documento = '".$dato['nom_documento']."',
                    descripcion_documento = '".$dato['descripcion_documento']."',
                    obligatorio = '".$dato['obligatorio']."',
                    digital = '".$dato['digital']."',
                    aplicar_todos = '".$dato['aplicar_todos']."',
                    departamento = '".$dato['departamento']."',
                    aparece_doc = '".$dato['aparece_doc']."',
                    validacion = '".$dato['validacion']."',
                    estado = '".$dato['estado']."',
                    fec_act = GETDATE(),
                    user_act = $id_usuario
                WHERE id_documento = '".$dato['id_documento']."'";
        $this->db6->query($sql);
    }

    function valida_insert_documento_postulante($dato){
        $sql = "SELECT * 
                FROM documento_postulante_empresa 
                WHERE id_empresa = 6 
                AND cod_documento = '".$dato['cod_documento']."' 
                AND estado = 2"; 
        $query = $this->db6->query($sql)->result_Array();
        return $query;  
    }

    function delete_documento_validar_postulante($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_postulante_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db6->query($sql); 
    }

    function get_list_postulante_documento_todos($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_admision FROM admision
                ORDER BY alum_apepat_admision ASC,alum_apemat_admision ASC,alum_nombre_admision ASC,Codigo ASC";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function get_list_documentos_postulante($id_postulante){ 
        $sql = "SELECT 
                dd.id_detalle,dd.flag_doc as flag_doc,
                CASE 
                    WHEN da.obligatorio = 0 THEN 'No' 
                    WHEN da.obligatorio = 1 THEN 'Si' 
                    WHEN da.obligatorio = 2 THEN 'Mayores de 4 (>4)' 
                    WHEN da.obligatorio = 3 THEN 'Menores de 18 (<18)' 
                    ELSE '' 
                END AS v_obligatorio,
                dd.anio,
                da.cod_documento,
                CONCAT(da.nom_documento, ' - ', da.descripcion_documento) AS nom_documento,
                dd.archivo,
                CASE 
                    WHEN da.cod_documento = 'D31' THEN 
                        CASE 
                            WHEN (SELECT COUNT(*) FROM admision a WHERE a.id_admision = dd.id_postulante AND dd.id_empresa = 6  AND a.estado = 2) > 0 THEN 'Firmado' 
                            ELSE 'Pendiente' 
                        END
                    ELSE SUBSTRING(dd.archivo, CHARINDEX('/', dd.archivo) + 1, LEN(dd.archivo) - CHARINDEX('/', REVERSE(dd.archivo)))
                END AS nom_archivo,
                us.usuario_codigo AS usuario_subido,
                FORMAT(dd.fec_subido, 'dd-MM-yyyy') AS fec_subido
            FROM 
                detalle_postulante_empresa dd
            LEFT JOIN 
                documento_postulante_empresa da ON da.id_documento = dd.id_documento
            LEFT JOIN 
                users us ON us.id_usuario = dd.user_subido
            WHERE 
                dd.id_postulante = $id_postulante AND dd.id_empresa = 6 AND dd.estado = 2
            ORDER BY 
                dd.anio DESC, da.obligatorio DESC, da.cod_documento ASC, da.nom_documento ASC, da.descripcion_documento ASC";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function get_id_detalle_postulante_empresa($id_detalle){
        $sql = "SELECT * FROM detalle_postulante_empresa 
                WHERE id_detalle=$id_detalle";
        $query = $this->db6->query($sql)->result_Array();
        return $query; 
    }

    function get_documento_postulante($id_detalle){ 
        $sql = "SELECT archivo
                FROM detalle_postulante_empresa
                WHERE id_detalle=$id_detalle";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }
    
    function update_datos_postulante($dato, $edad)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d H:i:s');
        $dep_dom = "NULL";
        $prov_dom = "NULL";
        $dist_dom = "NULL";
        $dep_col = "NULL";
        $dist_col = "NULL";
        $prov_col = "NULL";

        if ($dato['admi_departamento_admision'] != 0) {
            $dep_dom = $dato['admi_departamento_admision'];
        }
        if ($dato['cod_provincia'] != 0) {
            $prov_dom = $dato['cod_provincia'];
        }
        if ($dato['cod_distrito'] != 0) {
            $dist_dom = $dato['cod_distrito'];
        }
        if ($dato['col_departamento_admision'] != 0) {
            $dep_col = $dato['col_departamento_admision'];
        }
        if ($dato['cod_provincia_col'] != 0) {
            $prov_col = $dato['cod_provincia_col'];
        }
        if ($dato['cod_distrito_col'] != 0) {
            $dist_col = $dato['cod_distrito_col'];
        }

        $sql = "UPDATE admision SET 
                    alum_apepat_admision = '" . $dato['alum_apepat_admision'] . "',
                    alum_apemat_admision = '" . $dato['alum_apemat_admision'] . "',
                    alum_nombre_admision = '" . $dato['alum_nombre_admision'] . "',
                    cont_tipo_doc_admision = '" . $dato['tipo_doc_e'] . "',
                    cont_dni_admision = '" . $dato['dni_postulante'] . "',
                    alum_fecha_nac_admision = '" . $dato['fechaNacimiento'] . "',
                    alum_sexo_admision = '" . $dato['sexo_e'] . "',
                    cont_celular_admision = '" . $dato['cont_celular_admision'] . "',
                    cont_email_admision = '" . $dato['cont_email_admision'] . "',
                    admi_nosotros_admision = '" . $dato['cen_e'] . "',
                    domi_nom_admision = '" . $dato['domi_dir_admision'] . "',
                    domi_dep_admision = $dep_dom,
                    domi_prov_admision = $prov_dom,
                    domi_dist_admision = $dist_dom,
                    col_inti_nom = '" . $dato['colegio_post'] . "',
                    col_dep_admision = $dep_col,
                    col_prov_admision =$prov_col,
                    col_dist_admision = $dist_col,
                    admi_programa_admision = '" . $dato['admi_programa_admision'] . "',
                    admi_modalidad_admision = '" . $dato['admi_modalidad_admision'] . "',
                    admi_turno_admision = '" . $dato['admi_turno_admision'] . "',
                    doc_dni_alum_admision = '" . $dato['archivo_1'] . "',
                    doc_dni_tuto_admision = '" . $dato['archivo_2'] . "',
                    doc_certificado_admision = '" . $dato['archivo_3'] . "',
                    doc_nombre_dni_alum_admision = '" . $dato['archivo_1_nombre'] . "',
                    doc_nombre_dni_tuto_admision = '" . $dato['archivo_2_nombre'] . "',
                    doc_nombre_certificado_admision = '" . $dato['archivo_3_nombre'] . "',
                    flag_seccion_doc='".$dato['flag_seccion_doc']."',
                    flag_seccion_col='".$dato['flag_seccion_col']."',
                    flag_seccion_tutor='".$dato['flag_seccion_tutor']."',
                    flag_seccion_admi='".$dato['flag_seccion_admi']."',
                    flag_seccion_domi='".$dato['flag_seccion_domi']."',
                    doc_tramite_admision = '".$dato['doc_tramite_admision']."',
                    grupo='".$dato['nom_grupo'][0]['grupo']."',
                    fec_act='".$fecha."',
                    user_act='".$id_usuario."',
                    ";
        if ($edad >= 18) {
            // Si es mayor de edad, no incluir los campos del tutor en la actualización
            $sql .= "tutor_parentesco_admision = NULL,
                 tutor_tip_doc_admision = NULL,
                 tutor_num_doc_admision = NULL,
                 tutor_apepat_admision = NULL,
                 tutor_apemat_admision = NULL,
                 tutor_nombre_admision = NULL WHERE id_admision='" . $dato['id_admision'] . "' 
                 ";
        } else {
            // Si es menor de edad, incluir los campos del tutor en la actualización
            $sql .= "tutor_parentesco_admision = '" . $dato['parentesco_tut_e'] . "',
                 tutor_tip_doc_admision = '" . $dato['tipo_doc_tutor'] . "',
                 tutor_num_doc_admision = '" . $dato['num_doc_tutor'] . "',
                 tutor_apepat_admision = '" . $dato['apepat_admision_tutor'] . "',
                 tutor_apemat_admision = '" . $dato['apemat_admision_tutor'] . "',
                 tutor_nombre_admision = '" . $dato['nombres_admision_tutor'] . "' WHERE id_admision='" . $dato['id_admision'] . "' 
                 ";
        }
        $this->db6->query($sql);
    }
    function get_id_contacto($dato){
        $sql = "SELECT * from admision where cont_email_admision='".$dato['cont_email_admision']."' and cont_tipo_doc_admision='".$dato['tipo_doc_e']."' and cont_dni_admision='".$dato['dni_postulante']."' and estado=2";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }
    function delete_documento_postulante($dato)
    {
        $sql = "UPDATE admision SET " . $dato['campo'] . "=NULL," . $dato['archivo'] . "=NULL, flag_seccion_doc =0
                WHERE id_admision='" . $dato['id_admision'] . "'";
        $this->db6->query($sql);
    }
    function get_grupo($dato){
        $sql = "SELECT grupo FROM grupo_admision WHERE esp_grupo='" . $dato['admi_programa_admision'] . "' AND mod_grupo='" . $dato['admi_modalidad_admision'] . "'AND tur_grupo='" . $dato['admi_turno_admision'] . "'";
        $query = $this->db6->query($sql);
        return $query->result_array();
    }
    function ultimo_cod_admision($anio){
        $sql = "SELECT codigo_admision FROM admision where YEAR(fec_reg) = '".$anio."'";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function registrar_datos_postulante($dato,$edad){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $fecha = date('Y-m-d H:i:s');
        $tutor_parentesco_admision = 5;
        $tutor_tip_doc_admision = 5;
        $tutor_num_doc_admision = NULL;
        $tutor_apepat_admision = NULL;
        $tutor_apemat_admision = NULL;
        $tutor_nombre_admision = NULL;

        if ($edad < 18) {
            if($dato['parentesco_tut_e']!=''){$tutor_parentesco_admision = $dato['parentesco_tut_e'];}
            if($dato['tipo_doc_tutor']!=''){$tutor_tip_doc_admision = $dato['tipo_doc_tutor'];}
            if($dato['num_doc_tutor']!=''){$tutor_num_doc_admision = $dato['num_doc_tutor'];}
            if($dato['apepat_admision_tutor']!=''){$tutor_apepat_admision = $dato['apepat_admision_tutor'];}
            if($dato['apemat_admision_tutor']!=''){$tutor_apemat_admision = $dato['apemat_admision_tutor'];}
            if($dato['nombres_admision_tutor']!=''){$tutor_nombre_admision = $dato['nombres_admision_tutor'];}
        }
        $sql ="INSERT INTO admision (
                    alum_apepat_admision,
                    alum_apemat_admision,
                    alum_nombre_admision,
                    cont_tipo_doc_admision,
                    cont_dni_admision,
                    alum_fecha_nac_admision,
                    alum_sexo_admision,
                    cont_celular_admision,
                    cont_email_admision,
                    admi_nosotros_admision ,
                    domi_nom_admision,
                    domi_dep_admision,
                    domi_prov_admision,
                    domi_dist_admision,
                    col_inti_nom,
                    col_dep_admision,
                    col_prov_admision,
                    col_dist_admision,
                    admi_programa_admision,
                    admi_modalidad_admision,
                    admi_turno_admision,
                    doc_dni_alum_admision,
                    doc_dni_tuto_admision,
                    doc_certificado_admision,
                    doc_nombre_dni_alum_admision,
                    doc_nombre_dni_tuto_admision,
                    doc_nombre_certificado_admision,
                    flag_seccion_doc,
                    flag_seccion_col,
                    flag_seccion_tutor,
                    flag_seccion_admi,
                    flag_seccion_domi,
                    flag_seccion_alum,
                    flag_seccion_cont,
                    flag_btn_enviar,
                    doc_tramite_admision,
                    grupo,
                    codigo_admision,
                    tutor_parentesco_admision,
                    tutor_tip_doc_admision,
                    tutor_num_doc_admision,
                    tutor_apepat_admision,
                    tutor_apemat_admision,
                    tutor_nombre_admision,
                    fec_reg,
                    user_reg,
                    estado
) VALUES(
         '" . $dato['alum_apepat_admision'] . "',
                    '" . $dato['alum_apemat_admision'] . "',
                    '" . $dato['alum_nombre_admision'] . "',
                    '" . $dato['tipo_doc_e'] . "',
                    '" . $dato['dni_postulante'] . "',
                    '" . $dato['fechaNacimiento'] . "',
                    '" . $dato['sexo_e'] . "',
                    '" . $dato['cont_celular_admision'] . "',
                    '" . $dato['cont_email_admision'] . "',
                    '" . $dato['cen_e'] . "',
                    '" . $dato['domi_dir_admision'] . "',
                    '" . $dato['admi_departamento_admision'] . "',
                    '" . $dato['cod_provincia'] . "',
                    '" . $dato['cod_distrito'] . "',
                    '" . $dato['colegio_post'] . "',
                    '" . $dato['col_departamento_admision'] . "',
                    '" . $dato['cod_provincia_col'] . "',
                    '" . $dato['cod_distrito_col'] . "',
                    '" . $dato['admi_programa_admision'] . "',
                    '" . $dato['admi_modalidad_admision'] . "',
                    '" . $dato['admi_turno_admision'] . "',
                    '" . $dato['archivo_1'] . "',
                    '" . $dato['archivo_2'] . "',
                    '" . $dato['archivo_3'] . "',
                    '" . $dato['archivo_1_nombre'] . "',
                    '" . $dato['archivo_2_nombre'] . "',
                    '" . $dato['archivo_3_nombre'] . "',
                    '".$dato['flag_seccion_doc']."',
                    '".$dato['flag_seccion_col']."',
                    '".$dato['flag_seccion_tutor']."',
                    '".$dato['flag_seccion_admi']."',
                    '".$dato['flag_seccion_domi']."',
                    '".$dato['flag_seccion_alum']."',
                    '".$dato['flag_seccion_cont']."',
                    '".$dato['flag_btn_enviar']."',
                    '".$dato['doc_tramite_admision']."',
                    '".$dato['nom_grupo'][0]['grupo']."',
                    '".$dato['codigo_admision']."',
                    ".$tutor_parentesco_admision.",
                    ".$tutor_tip_doc_admision." ,
                    '".$tutor_num_doc_admision."' ,
                    '".$tutor_apepat_admision."' ,
                    '".$tutor_apemat_admision."' ,
                    '".$tutor_nombre_admision."' ,
                    '".$fecha."',
                    ".$id_usuario.",
                    2
                    )";

        $this->db6->query($sql);
    }

    function get_list_estado_post()
    {
        $sql = "SELECT * FROM [configuracion_general] WHERE estado=2 AND id_confgen_confmae = 10 ORDER BY nom_confgen ASC";
        $query = $this->db6->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_x_postulante($dato) {
        $sql = "SELECT
                    dpe.id_postulante, MAX(ad.cont_dni_admision) as cont_dni_admision, MAX(ad.cont_email_admision) as cont_email_admision, MAX(ad.cont_tipo_doc_admision) as cont_tipo_doc_admision,
	                CASE WHEN MAX(ad.doc_tramite_admision) IS NULL THEN '0' ELSE MAX(ad.doc_tramite_admision) END as doc_tramite_admision, MAX(ad.id_admision) as id_admision, ad.flag_seccion_doc,
                    MAX(CASE WHEN dpe.archivo LIKE '%/".$dato['cont_dni_admision']."%' THEN RIGHT(dpe.archivo, CHARINDEX('/', REVERSE(dpe.archivo)) - 1) ELSE NULL END) AS archivo_dni_alumno,
                    MAX(CASE WHEN dpe.archivo LIKE '%Tutor-".$dato['cont_dni_admision']."%' THEN RIGHT(dpe.archivo, CHARINDEX('/', REVERSE(dpe.archivo)) - 1) ELSE NULL END) AS archivo_dni_tutor,
                    MAX(CASE WHEN dpe.archivo LIKE '%Certificado-".$dato['cont_dni_admision']."%' THEN RIGHT(dpe.archivo, CHARINDEX('/', REVERSE(dpe.archivo)) - 1) ELSE NULL END) AS archivo_certificado
                FROM
                    detalle_postulante_empresa dpe
                INNER JOIN admision ad ON dpe.id_postulante = ad.id_admision
                WHERE
                    ad.cont_email_admision='".$dato['cont_email_admision']."' and ad.cont_tipo_doc_admision='".$dato['cont_tipo_doc_admision']."' and ad.cont_dni_admision='".$dato['cont_dni_admision']."' and dpe.estado=2
                GROUP BY
                    dpe.id_postulante , ad.flag_seccion_doc";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

}