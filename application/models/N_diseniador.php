<?php
class N_diseniador extends CI_Model {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }

    function get_row_solicitado($id_usuario){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto
        WHERE STATUS=1 and id_asignado=".$id_usuario;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_row_asignadot($id_usuario){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto 
                WHERE STATUS=2 and id_asignado=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function get_row_asignado($id_usuario){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=2) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2 and u.id_usuario=$id_usuario
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_row_entramitet(){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=3";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_row_entramite($id_usuario){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=3) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2 and u.id_usuario=$id_usuario
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function get_row_pendientet(){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=4";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_row_pendiente($id_usuario){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=4) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2 and u.id_usuario=$id_usuario
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_row_tp($id_usuario){
        $anio=date('Y');
        $semana=date('W');

        $sql = "SELECT SUM( s_artes ) AS artest, SUM( s_redes ) AS redest, COUNT(0) AS total , u.usuario_codigo, u.artes, 
                u.redes from users u
                left join (select * from proyecto where semanat=$semana and anio=$anio and status in (5, 6, 7)) p on p.id_asignado=u.id_usuario
                where u.id_nivel in (2,3,4) and u.estado=2 and u.id_usuario=$id_usuario
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_detalle_busqueda($id_estatus,$id_usuario){
        if($id_estatus==0){
            $parte = "AND p.status IN (1,2,3,4,5)";
        }else{
            $parte = "AND p.status=$id_estatus";
        }
        $sql = "SELECT p.*,sp.nom_statusp,sp.color,t.nom_tipo,st.nom_subtipo,
                u.usuario_nombres AS nombre_solicitado,u.usuario_codigo AS ucodigo_solicitado,
                ua.usuario_nombres AS nombre_asignado,ua.usuario_codigo AS ucodigo_asignado,
                em.cod_empresa,CASE WHEN SUBSTRING(p.fec_agenda,1,1)='2' THEN 
                DATE_FORMAT(p.fec_agenda,'%d/%m/%Y') ELSE '' END AS fecha_agenda,
                CASE WHEN SUBSTRING(p.fec_solicitante,1,1)='2' THEN 
                DATE_FORMAT(p.fec_solicitante,'%d/%m/%Y') ELSE '' END AS fecha_solicitante,
                CASE WHEN SUBSTRING(p.fec_termino,1,1)='2' THEN 
                DATE_FORMAT(p.fec_termino,'%d/%m/%Y') ELSE '' END AS fecha_termino,
                (SELECT GROUP_CONCAT(DISTINCT se.cod_sede)
                FROM proyecto_sede ps
                LEFT JOIN sede se ON ps.id_sede=se.id_sede
                WHERE ps.id_proyecto=p.id_proyecto AND ps.estado=2) AS cod_sede
                FROM proyecto p
                LEFT JOIN statusp sp ON p.status=sp.id_statusp
                LEFT JOIN tipo t ON p.id_tipo=t.id_tipo
                LEFT JOIN subtipo st ON p.id_subtipo=st.id_subtipo
                LEFT JOIN users u ON u.id_usuario=p.id_solicitante
                LEFT JOIN users ua ON ua.id_usuario=p.id_asignado
                LEFT JOIN empresa em ON em.id_empresa=p.id_empresa
                WHERE p.id_asignado=$id_usuario $parte
                ORDER BY p.prioridad ASC,p.cod_proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    public function update_proyecto_ds($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        /*$path = $_FILES['foto']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'foto';
        // $config['file_name'] = "proyecto".$fecha."_".rand(1,200).".".$ext;
        $config['upload_path'] = './archivo/';/// ruta del fileserver para almacenar el documento  idusuario randun fecha
        $config['file_name'] = $dato['id_proyecto']."_".rand(1,50).".".$ext;
        $ruta = 'archivo/'.$config['file_name'];
        $config['allowed_types'] = "png|jpg|jpeg|gif|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
        $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();*/

        $semana = date('W');

        $sql = "UPDATE proyecto SET proy_obs='".$dato['proy_obs']."',status='".$dato['status']."',
                fec_act=NOW(),user_act=$id_usuario
                where id_proyecto=".$dato['id_proyecto']." ";
        $this->db->query($sql);

        if ($dato['imagen']!=""){
            $sql1 = "UPDATE proyecto SET imagen='".$dato['imagen']."', fec_subi=NOW(),id_useri=$id_usuario
                    WHERE id_proyecto=".$dato['id_proyecto']."  ";
            $this->db->query($sql1);
        }

        if ($dato['status']==4){
            $sql2= "UPDATE proyecto SET id_userpr='".$dato['id_userpr']."',fec_pendr=NOW() 
                    WHERE id_proyecto=".$dato['id_proyecto']." ";
            $this->db->query($sql2);
        }
        if ($dato['status']==5){
            $sql3= "UPDATE proyecto SET fec_termino=NOW(),user_termino=$id_usuario,semanat='".$semana."' 
                    WHERE id_proyecto=".$dato['id_proyecto']."";
            $this->db->query($sql3);
        }
    }

}