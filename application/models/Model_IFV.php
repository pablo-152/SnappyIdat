<?php
class Model_IFV extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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

    function Model_IFV()
    {
        $sql = "select * from fintranet where estado=1 and id_empresa=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
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

    
    function get_dni_alumno_recomendados()
    {
        $sql = "SELECT dni_alumno FROM recomendados";
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

     //---------------------------------------GRUPO C---------------------------------------------------------
     function get_list_grupo_c($tipo)
     {
         $parte = "";
         if ($tipo == 1) {
             $parte = "AND gc.estado_grupo NOT IN (2,4,5,6) AND
                     NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 28 DAY) AND
                     NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 28 DAY)";
         }
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

    

    function delete_documento_grupo_c($dato)
    {
        $sql = "UPDATE documento_grupo SET archivo='',estado_d=1,fecha=NULL,usuario=0
                WHERE id_documento='" . $dato['id_documento'] . "'";
        $this->db->query($sql);
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


    function get_id_documento_recibido($id_doc_cargado)
    {
        $sql = "SELECT * FROM todos_l20_doc_cargado WHERE id_doc_cargado=$id_doc_cargado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_config($descrip_config)
    {
        $sql = "SELECT * from config where descrip_config='$descrip_config'";
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

    function get_list_estados()
    {
        $sql = "SELECT * FROM status_general WHERE id_status_mae=9 and id_status_general in (66,67,69,70)";
        $query = $this->db->query($sql)->result_Array();
        //echo($sql);
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

    function get_list_detalle_fut_id($dato)
    {
        $sql = "SELECT * FROM envio_fut_ifv_detalle WHERE estado = 2 AND id_envio_det='" . $dato['id_envio_det'] . "'";
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
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

    function get_id_fut_recibido($id_envio_det)
    {
        $sql = "SELECT * FROM envio_fut_ifv_detalle WHERE id_envio_det=$id_envio_det";
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

    function get_list_usuario_evento()
    {
        $sql = "SELECT * FROM users WHERE estado=2";
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

    function get_list_tipo_venta_combo()
    {
        $sql = "SELECT id_tipo,cod_tipo 
                FROM tipo_venta 
                WHERE estado=2
                ORDER BY cod_tipo ASC";
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

    function get_list_estado()
    {
        $sql = "SELECT * FROM status WHERE estado=1 ORDER BY nom_status ASC";
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
}