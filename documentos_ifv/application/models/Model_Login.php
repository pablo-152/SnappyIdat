<?php
class Model_Login extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("America/Lima");
    }

    function get_dni_matriculado($dni_alumno){ 
        $sql = "SELECT Codigo,CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre) AS nom_alumno,Dni,
                Especialidad,Fecha_Cumpleanos,Email,Nombre,Apellido_Paterno,Apellido_Materno
                FROM todos_l20 
                WHERE Tipo=1 AND Dni='$dni_alumno'"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_documentos_pendientes($fecha_cumpleanos){ 
        $sql = "SELECT nom_documento,cod_documento FROM documento_alumno_empresa da 
                WHERE id_empresa=6 AND estado=2 AND /*(obligatorio=1 || (obligatorio=2 && 
                TIMESTAMPDIFF(YEAR, '$fecha_cumpleanos', CURDATE())>4) || (obligatorio=3 && 
                TIMESTAMPDIFF(YEAR, '$fecha_cumpleanos', CURDATE())<18)) and */ da.aparece_doc=1"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registro_ingreso($id_registro_ingreso=null){
        if(isset($id_registro_ingreso) && $id_registro_ingreso>0){
            $sql = "SELECT * FROM registro_ingreso WHERE id_registro_ingreso=$id_registro_ingreso";
        }else{
            $sql = "SELECT ri.*,DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,CASE WHEN ri.estado_ingreso=1 THEN 'Puntual'
                    WHEN ri.estado_ingreso=2 THEN 'Retrasado' WHEN ri.estado_ingreso=3 THEN 'Denegado' ELSE '' END AS estado_ing,
                    es.abreviatura
                    FROM registro_ingreso ri
                    LEFT JOIN especialidad es ON es.nom_especialidad=ri.especialidad AND es.estado=2
                    WHERE ri.estado=2 AND DATE(ri.ingreso)=CURDATE() ORDER BY ri.ingreso DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_historial_registro_ingreso($codigo_alumno){
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE(fec_reg)  as Fecha
                FROM historial_registro_ingreso 
                WHERE estado=2 AND codigo=$codigo_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_alumnos_ingresados(){
        $sql = "SELECT id_alumno FROM registro_ingreso 
                WHERE estado=2 AND DATE(ingreso)=CURDATE() AND estado_ingreso NOT IN (3)
                GROUP BY id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_total_matriculados(){
        $sql = "SELECT * FROM matriculados_l20";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }


    function valida_foto_matriculado($id_alumno){ 
        $sql = "SELECT * FROM foto_matriculados WHERE id_alumno='$id_alumno' AND foto!=''"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_registro_ingreso($dato){
        $sql = "SELECT * FROM registro_ingreso WHERE id_alumno='".$dato['id_alumno']."' AND estado=2 AND DATE(ingreso)=CURDATE()";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_registro_ingreso($dato){
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,estado_reporte,user_autorizado,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_alumno']."',DATE_ADD(NOW(),INTERVAL 2 HOUR),'".$dato['especialidad']."','".$dato['grupo']."',
                '".$dato['modulo']."','".$dato['grado']."','".$dato['seccion']."','".$dato['codigo']."','".$dato['apater']."',
                '".$dato['amater']."','".$dato['nombres']."',1,'".$dato['estado_reporte']."',
                '".$dato['user_autorizado']."',2,NOW(),0)";
        $this->db->query($sql);
    }

    function get_foto_matriculado($id_alumno){ 
        $sql = "SELECT * FROM foto_matriculados WHERE id_alumno='$id_alumno'"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro_ingreso_modal($dato){
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,no_tarjeta,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_alumno']."',DATE_ADD(NOW(),INTERVAL 2 HOUR),'".$dato['especialidad']."','".$dato['grupo']."',
                '".$dato['modulo']."','".$dato['grado']."','".$dato['seccion']."','".$dato['codigo']."','".$dato['apater']."',
                '".$dato['amater']."','".$dato['nombres']."',1,1,2,NOW(),0)";
        $this->db->query($sql);
    }

    function ultimo_id_registro_ingreso(){
        $sql = "SELECT id_registro_ingreso FROM registro_ingreso ORDER BY id_registro_ingreso DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_historial_registro_ingreso($dato){
        $sql = "INSERT INTO historial_registro_ingreso (id_registro_ingreso,tipo,codigo,observacion,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_registro_ingreso']."','".$dato['tipo']."','".$dato['codigo']."','".$dato['observacion']."',2,NOW(),0)";
        $this->db->query($sql);
    }

    function delete_registro_ingreso($dato){
        $sql = "UPDATE registro_ingreso SET estado=4,fec_eli=NOW(),user_eli=0
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db->query($sql);
    }

    function get_clave_asistencia($clave_admin){
        $sql = "SELECT id_usuario FROM users WHERE clave_asistencia='$clave_admin'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_documentos_cargados($dato){
        $sql = "SELECT * FROM todos_l20_doc_cargado WHERE estado=2 AND cod_documento='".$dato['cod_documento']."' and id_empresa='".$dato['id_empresa']."'
        and Codigo='".$dato['Codigo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documentos_cargados($dato){
        $path1 = $_FILES['documento']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);

        $config['upload_path'] = './Documentos_Alum_Ifv/';
        
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre='Cod_doc_'.$dato['cod_documento']."_Cod_alumn_".$dato['Codigo'].rand(10,199);
        $nombre1=$dato['get_documento'][0]['documento'];
        if($path1!=""){
            $nombre1="Documentos_Alum_Ifv/".$nombre.".".$ext1;
            if (!empty($_FILES['documento']['name'])){
                $config['upload_path'] = './Documentos_Alum_Ifv/';
                $config['allowed_types'] = 'png|jpg|jpeg|pdf';
                $config['file_name'] = $nombre.".".$ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('documento')){
                    $documento = $this->upload->data();
                }else{
                    echo $this->upload->display_errors();
                }
            }
            if(isset($dato['get_documento'][0]['documento']) && $dato['get_documento'][0]['documento']!=""){
                if (file_exists($dato['get_documento'][0]['documento'])) {
                    unlink($dato['get_documento'][0]['documento']);
                }
            }
        }
        $sql = "UPDATE todos_l20_doc_cargado SET documento='$nombre1',email='".$dato['Email']."',fec_reg=NOW()
                WHERE estado=2 AND cod_documento='".$dato['cod_documento']."' and id_empresa='".$dato['id_empresa']."' and Codigo='".$dato['Codigo']."'";
        $this->db->query($sql);
    }

    function insert_documentos_cargados($dato){
        $path1 = $_FILES['documento']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);

        $config['upload_path'] = './Documentos_Alum_Ifv/';
        
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre='Cod_doc_'.$dato['cod_documento']."_Cod_alumn_".$dato['Codigo'].rand(10,199);
        $nombre1="";
        if($path1!=""){
            $nombre1="Documentos_Alum_Ifv/".$nombre.".".$ext1;
            if (!empty($_FILES['documento']['name'])){
                $config['upload_path'] = './Documentos_Alum_Ifv/';
                $config['allowed_types'] = 'png|jpg|jpeg|pdf';
                $config['file_name'] = $nombre.".".$ext1;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('documento')){
                    $documento = $this->upload->data();
                }else{
                    echo $this->upload->display_errors();
                }
            }
        }
        $sql = "INSERT INTO todos_l20_doc_cargado (cod_documento,nom_documento,Apellido_Paterno,Apellido_Materno,Dni,id_empresa,Codigo,nom_alumno,Especialidad,email,documento,estado,fec_reg,user_reg) 
            VALUES('".$dato['cod_documento']."','".$dato['nom_documento']."','".$dato['Apellido_Paterno']."','".$dato['Apellido_Materno']."','".$dato['Dni']."','".$dato['id_empresa']."','".$dato['Codigo']."','".$dato['nom_alumno']."','".$dato['Especialidad']."','".$dato['Email']."','$nombre1',2,NOW(),0)";
        $this->db->query($sql);
    }
}
?>