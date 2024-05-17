<?php
class Model_Asistencia extends CI_Model {
    public function __construct() {
        parent::__construct();
        /*$this->db2 = $this->load->database('db2', true);
        $this->db3 = $this->load->database('db3', true);*/
        $this->load->database();
        date_default_timezone_set("America/Lima");
    }

    function get_list_registro_ingreso($id_registro_ingreso=null){  
        if(isset($id_registro_ingreso) && $id_registro_ingreso>0){ 
            $sql = "SELECT ri.*,CONCAT(ri.apater,' ',ri.amater,', ',ri.nombres) AS nombre_completo,
                    td.Cargo AS nom_cargo,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha,
                    td.Email AS email
                    FROM registro_ingreso ri
                    LEFT JOIN todos_l20 td ON td.Tipo=2 AND td.Codigo=ri.codigo
                    WHERE ri.id_registro_ingreso=$id_registro_ingreso";
        }else{
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

    function list_historial_registro_ingreso($codigo_alumno){
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE(fec_reg)  as Fecha
                FROM historial_registro_ingreso 
                WHERE estado=2 AND codigo='".addslashes($codigo_alumno)."'";
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

    function get_alumnos_sin_salida(){
        $sql = "SELECT ri.id_registro_ingreso FROM registro_ingreso ri
                LEFT JOIN matriculados_l20 ma ON ma.Id=ri.id_alumno
                WHERE ma.Tipo IN (2,3) AND ri.salida=0 AND DATE(ri.ingreso)=CURDATE() AND ri.estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_total_matriculados(){
        $sql = "SELECT *,CASE WHEN Tipo IN (1,2) THEN CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',Nombre,' - ',Codigoa) 
                ELSE CONCAT(Nombre,' - ',Codigoa) END AS nombres
                FROM matriculados_l20";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    } 

    function get_cod_matriculado($codigo_alumno){  
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
                WHERE ma.Codigoa='".addslashes($codigo_alumno)."'"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_matriculado_promovido($codigo_alumno){  
        $sql = "SELECT Id FROM todos_l20 
                WHERE Tipo=1 AND Codigo='".addslashes($codigo_alumno)."' AND Matricula='Promovido' AND 
                Alumno='Matriculado'"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_foto_matriculado($id_alumno,$tipo){ 
        if($tipo==1){
            $sql = "SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.archivo!='' AND de.estado=2"; 
        }else{
            $sql = "SELECT * FROM foto_docentes WHERE id_docente='$id_alumno' AND foto!=''"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_registro_ingreso($dato){
        $sql = "SELECT * FROM registro_ingreso 
                WHERE id_alumno='".$dato['id_alumno']."' AND estado=2 AND DATE(ingreso)=CURDATE()";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function traer_duplicidad_registro_ingreso($dato){
        $sql = "SELECT * FROM registro_ingreso 
                WHERE id_alumno='".$dato['id_alumno']."' AND estado=2 AND duplicidad=1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_duplicidad_registro_ingreso($dato){ 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso SET duplicidad=0 
                WHERE id_alumno='".$dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function insert_registro_ingreso($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,estado_reporte,user_autorizado,estado,fec_reg,user_reg,reg_automatico,duplicidad) 
                VALUES('".$dato['id_alumno']."',DATE_ADD(NOW(),INTERVAL 3 HOUR),'".$dato['especialidad']."','".$dato['grupo']."',
                '".$dato['modulo']."','".$dato['grado']."','".$dato['seccion']."','".addslashes($dato['codigo'])."','".$dato['apater']."',
                '".$dato['amater']."','".$dato['nombres']."',1,'".$dato['estado_reporte']."',
                '".$dato['user_autorizado']."',2,DATE_ADD(NOW(),INTERVAL 3 HOUR),$id_usuario,'".$dato['reg_automatico']."',
                '".$dato['duplicidad']."')";
        $this->db->query($sql);
    }

    function get_foto_matriculado($id_alumno,$tipo){ 
        if($tipo==1){
            $sql = "SELECT de.archivo AS foto FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=6 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.estado=2
                    ORDER BY de.id_detalle DESC"; 
        }else{
            $sql = "SELECT * FROM foto_docentes WHERE id_docente='$id_alumno' ORDER BY id_foto DESC"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro_ingreso_modal($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO registro_ingreso (id_alumno,ingreso,especialidad,grupo,modulo,grado,seccion,codigo,apater,
                amater,nombres,estado_ingreso,no_tarjeta,estado,fec_reg,user_reg,reg_automatico) 
                VALUES('".$dato['id_alumno']."',DATE_ADD(NOW(),INTERVAL 3 HOUR),'".$dato['especialidad']."','".$dato['grupo']."',
                '".$dato['modulo']."','".$dato['grado']."','".$dato['seccion']."','".addslashes($dato['codigo'])."','".$dato['apater']."',
                '".$dato['amater']."','".$dato['nombres']."',1,1,2,DATE_ADD(NOW(),INTERVAL 3 HOUR),$id_usuario,'".$dato['reg_automatico']."')"; 
        $this->db->query($sql);
    }

    function ultimo_id_registro_ingreso(){
        $sql = "SELECT id_registro_ingreso FROM registro_ingreso ORDER BY id_registro_ingreso DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_historial_registro_ingreso($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_registro_ingreso (id_registro_ingreso,tipo,codigo,observacion,estado,fec_reg,user_reg) 
                VALUES('".$dato['id_registro_ingreso']."','".$dato['tipo']."','".addslashes($dato['codigo'])."',
                '".$dato['observacion']."',2,DATE_ADD(NOW(),INTERVAL 3 HOUR),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_registro_ingreso($id_alumno){
        $sql = "SELECT id_registro_ingreso,TIMESTAMPDIFF(MINUTE,TIME(ingreso),DATE_ADD(TIME(NOW()),INTERVAL 3 HOUR)) AS minutos 
                FROM registro_ingreso
                WHERE id_alumno=$id_alumno AND DATE(ingreso)=CURDATE() AND salida=0
                ORDER BY id_registro_ingreso DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function update_registro_ingreso($dato){
        $sql = "UPDATE registro_ingreso SET salida=1,hora_salida=DATE_ADD(TIME(NOW()),INTERVAL 3 HOUR)
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db->query($sql);
    }

    function delete_registro_ingreso($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso SET estado=4,fec_eli=DATE_ADD(NOW(),INTERVAL 3 HOUR),user_eli=$id_usuario
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db->query($sql);
    }

    function get_clave_asistencia($clave_admin){
        $sql = "SELECT id_usuario FROM users WHERE clave_asistencia='$clave_admin'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_registro_salida(){
        $sql = "SELECT id_registro_ingreso,DATE_FORMAT(ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN id_alumno IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) 
                THEN CONCAT(nombres,' ',codigo) ELSE nombres END AS nombre,
                CONCAT(apater,' ',amater) AS apellidos 
                FROM registro_ingreso 
                WHERE (codigo IN ('01','02','03','04','05','06','07','08','09','10','11',
                '12','13','14','15','16','17','18','19','20') OR codigo LIKE '%C') AND 
                salida=0 AND DATE(ingreso)=CURDATE() AND estado=2
                ORDER BY ingreso DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_registro_salida($dato){
        $sql = "UPDATE registro_ingreso SET salida=1,hora_salida='23:59:00'
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db->query($sql);
    }

    function update_registro_salida_no_registrada($dato){
        $sql = "UPDATE registro_ingreso SET salida=2
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db->query($sql);
    }
}
?>