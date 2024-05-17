<?php
class Model_Colaborador extends CI_Model { 
    public function __construct() {
        parent::__construct(); 
        $this->db5 = $this->load->database('db5', true); 
        $this->load->database();
        date_default_timezone_set("America/Lima");  
    }

    function get_id_sede($id_sede){
        $sql = "SELECT id_sede,id_empresa FROM sede 
                WHERE id_sede=$id_sede";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede($id_empresa){ 
        $sql = "SELECT * FROM sede 
                WHERE id_empresa=$id_empresa AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status 
                WHERE id_status IN (1,2,3)
                ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_config($id_config){
        $sql = "SELECT * FROM config 
                WHERE id_config=$id_config";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_colaborador($tipo,$id_sede){    
        $parte = "";
        if($tipo==1){
            //$parte = "AND co.estado=2";
            $parte = "AND (SELECT COUNT(1) FROM contrato_colaborador cc
            WHERE cc.id_colaborador=co.id_colaborador AND (cc.fin_funciones>=CURDATE() OR 
            cc.fin_funciones IS NULL OR SUBSTRING(cc.fin_funciones,1,1)='0') AND 
            cc.estado_contrato=2 AND cc.estado=2)>0";
        }else{
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
                THEN (SELECT CASE WHEN SUBSTRING(cc.inicio_contrato,1,1)='2' THEN 
                DATE_FORMAT(cc.inicio_contrato,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS inicio_contrato,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.fin_contrato,1,1)='2' THEN 
                DATE_FORMAT(cc.fin_contrato,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS fin_contrato,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.inicio_funciones,1,1)='2' THEN 
                DATE_FORMAT(cc.inicio_funciones,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS inicio_funciones,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.fin_funciones,1,1)='2' THEN 
                DATE_FORMAT(cc.fin_funciones,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS fin_funciones,
                co.nickname,co.usuario,/*st.nom_status,*/co.observaciones,
                CASE WHEN co.archivo_dni!='' THEN 'Si' ELSE 'No' END AS doc,pe.nom_perfil AS perfil,
                CASE WHEN SUBSTRING(co.fec_nacimiento,1,1)!='0' THEN 
                DATE_FORMAT(co.fec_nacimiento,'%d/%m/%Y') ELSE '' END AS fec_nacimiento,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2 AND 
                cc.archivo!='')>0 THEN 'Si' ELSE 'No' END AS ct_firmado,
                CASE WHEN co.fecha_validacion IS NULL THEN '' ELSE 
                DATE_FORMAT(co.fecha_validacion,'%d/%m/%Y %H:%i') END AS validacion_correo,
                CASE WHEN co.fecha_validacion IS NULL THEN '' ELSE 
                DATE_FORMAT(co.fecha_validacion,'%d/%m/%Y') END AS validacion_fecha,
                CASE WHEN co.fecha_validacion IS NULL THEN '' ELSE 
                DATE_FORMAT(co.fecha_validacion,'%H:%i') END AS validacion_hora,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND (cc.fin_funciones>=CURDATE() OR 
                cc.fin_funciones IS NULL OR SUBSTRING(cc.fin_funciones,1,1)='0') AND 
                cc.estado_contrato=2 AND cc.estado=2)>0 THEN 'Activo' ELSE 'Inactivo' END AS nom_status
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                /*LEFT JOIN status st ON st.id_status=co.estado*/
                LEFT JOIN perfil pe ON pe.id_perfil=co.id_perfil
                WHERE co.id_sede=$id_sede $parte
                ORDER BY co.apellido_paterno ASC,co.apellido_materno ASC,co.nombres ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }
    
    function get_list_combo_perfil($id_sede){
        $sql = "SELECT id_perfil,nom_perfil FROM perfil 
                WHERE id_sede=$id_sede AND estado=2
                ORDER BY nom_perfil ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_cargo($id_sede){
        $sql = "SELECT id_cf,nom_cf FROM cargo_fotocheck 
                WHERE idsede_cf=$id_sede AND estado=2
                ORDER BY nom_cf ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_departamento(){
        $sql = "SELECT * FROM departamento 
                ORDER BY nombre_departamento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_provincia($id_departamento){
        $sql = "SELECT * FROM provincia 
                WHERE id_departamento=$id_departamento 
                ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_distrito($id_provincia){
        $sql = "SELECT * FROM distrito 
                WHERE id_provincia=$id_provincia 
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_colaborador(){
        $sql = "SELECT id_colaborador FROM colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_usuario_colaborador($dato){
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla=$dato['codigo_gll']."'C";
        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }

        $sql = "INSERT INTO colaborador (id_empresa,id_sede,id_perfil,id_cargo_foto,apellido_paterno,apellido_materno,
                nombres,dni,correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll,codigo_glla,nickname,usuario,password,
                password_desencriptado,foto,fec_nacimiento,banco,cuenta_bancaria,estado,fec_reg,user_reg,
                fec_act,user_act)
                VALUES (".$dato['id_empresa'].",".$dato['id_sede'].",'".$dato['id_perfil']."','".$dato['id_cargo']."',
                '".$dato['apellido_paterno']."','".$dato['apellido_materno']."','".$dato['nombres']."',
                '".$dato['dni']."','".$dato['correo_personal']."', '".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."', '".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".addslashes($codigo_glla)."','".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."',".$dato['fec_nacimiento'].",'".$dato['banco']."',
                '".$dato['cuenta_bancaria']."',2,NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";
        $sql2 = "INSERT INTO colaborador (id_empresa,id_sede,id_perfil,id_cargo_foto,apellido_paterno,apellido_materno,
                nombres,dni,correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll,codigo_glla,nickname,usuario,password,
                password_desencriptado,foto,fec_nacimiento,banco,cuenta_bancaria,estado,fec_reg,user_reg,
                fec_act,user_act)
                VALUES (".$dato['id_empresa'].",".$dato['id_sede'].",'".$dato['id_perfil']."','".$dato['id_cargo']."',
                '".$dato['apellido_paterno']."','".$dato['apellido_materno']."', '".$dato['nombres']."',
                '".$dato['dni']."','".$dato['correo_personal']."', '".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."', '".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".$codigo_glla."','".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."',".$dato['fec_nacimiento'].",'".$dato['banco']."',
                '".$dato['cuenta_bancaria']."',2,getdate(),$id_usuario,getdate(),$id_usuario)";
        $this->db5->query($sql2);

        $id = $this->db->insert_id();
        return $id;
    }

    function insert_usuario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO users (tipo,id_externo,usuario_codigo,usuario_password,password_desencriptado,
                estado,fec_reg,user_reg,fec_act,user_act)
                VALUES (2,'".$dato['id_externo']."','".$dato['usuario']."','".$dato['password']."',
                '".$dato['password_desencriptado']."',2,NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_colaborador($id_colaborador){ 
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
                SUBSTRING_INDEX(co.cv, '/', -1) AS nom_cv,co.banco,co.cuenta_bancaria,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND (cc.fin_funciones>=CURDATE() OR 
                cc.fin_funciones IS NULL OR SUBSTRING(cc.fin_funciones,1,1)='0') AND 
                cc.estado_contrato=2 AND cc.estado=2)>0 THEN 'Activo' ELSE 'Inactivo' END AS nom_status
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento = co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia = co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito = co.id_distrito
                LEFT JOIN perfil pe ON co.id_perfil = pe.id_perfil
                WHERE co.id_colaborador = $id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_usuario_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2 AND
                id_externo!='".$dato['id_colaborador']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_colaborador($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla = $dato['codigo_gll']."'C";
        $parte = "";

        if($dato['password']!=""){
            $parte = "password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }

        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }

        $sql = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',id_cargo_foto='".$dato['id_cargo']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                fec_act=NOW(),user_act=$id_usuario,fec_nacimiento=".$dato['fec_nacimiento'].",
                banco='".$dato['banco']."',cuenta_bancaria='".$dato['cuenta_bancaria']."',
                codigo_glla='".addslashes($codigo_glla)."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";

        $sql2 = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',id_cargo_foto='".$dato['id_cargo']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                fec_act=getdate(),user_act=$id_usuario,
                fec_nacimiento=".$dato['fec_nacimiento'].",banco='".$dato['banco']."',
                cuenta_bancaria='".$dato['cuenta_bancaria']."',codigo_glla='".$codigo_glla."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function valida_insert_users_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_usuario_colaborador($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $parte = "";
        if($dato['password']!=""){
            $parte = "usuario_password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }
        $sql = "UPDATE users SET usuario_codigo='".$dato['usuario']."',$parte fec_act=NOW(),
                user_act=$id_usuario
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."'";
        $this->db->query($sql); 
    }

    function delete_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);
        $sql2 = "UPDATE colaborador SET estado=4,fec_eli=getdate(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function validacion_positiva_correo_personal_colaborador($id_colaborador){
        $sql = "UPDATE colaborador SET fecha_validacion=NOW()
                WHERE id_colaborador=$id_colaborador";
        $this->db->query($sql);
    }

    function validacion_negativa_correo_personal_colaborador($id_colaborador){
        $sql = "UPDATE colaborador SET fecha_validacion=NULL
                WHERE id_colaborador=$id_colaborador";
        $this->db->query($sql);
    }

    function get_list_documento_colaborador($id_colaborador){
        $sql = "SELECT dd.id_detalle,CASE WHEN da.obligatorio=0 THEN 'No' 
                WHEN da.obligatorio=1 THEN 'Si' WHEN da.obligatorio=2 
                THEN 'Mayores de 4 (>4)' WHEN da.obligatorio=3 
                THEN 'Menores de 18 (<18)' ELSE '' END AS v_obligatorio,
                dd.anio,da.cod_documento,
                CONCAT(da.nom_documento,' - ',da.descripcion_documento) AS 
                nom_documento,dd.archivo,
                CASE WHEN da.cod_documento='D54' THEN 
                (CASE WHEN (SELECT COUNT(*) FROM documento_firma df 
                WHERE df.id_alumno=dd.id_colaborador AND df.id_empresa=3 AND 
                df.estado_d=3 AND df.estado=2)>0 THEN 'Firmado' ELSE 'Pendiente' END)
                ELSE SUBSTRING_INDEX(dd.archivo,'/',-1) END AS nom_archivo,
                us.usuario_codigo AS usuario_subido,
                DATE_FORMAT(dd.fec_subido,'%d/%m/%Y') AS fec_subido,
                em.cod_empresa,da.id_anio,an.nom_anio
                FROM detalle_colaborador_empresa dd
                LEFT JOIN documento_colaborador_empresa da ON da.id_documento=dd.id_documento
                LEFT JOIN users us ON us.id_usuario=dd.user_subido
                LEFT JOIN empresa em ON em.id_empresa = dd.id_empresa
                LEFT JOIN anio an ON an.id_anio = da.id_anio
                WHERE dd.id_colaborador=$id_colaborador
                ORDER BY an.nom_anio ASC,da.cod_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_contrato_colaborador($id_contrato=null,$id_colaborador=null){
        if(isset($id_contrato) && $id_contrato>0){
            $sql = "SELECT cc.*,co.id_sede,co.id_empresa
                    FROM contrato_colaborador cc
                    LEFT JOIN colaborador co ON cc.id_colaborador=co.id_colaborador
                    WHERE cc.id_contrato=$id_contrato";
        }else{
            $sql = "SELECT cc.id_contrato,cc.nom_contrato,cc.referencia,
                    CASE WHEN SUBSTRING(cc.inicio_funciones,1,1)='2' THEN 
                    DATE_FORMAT(cc.inicio_funciones,'%d/%m/%Y') ELSE '' END AS inicio_funciones,
                    CASE WHEN SUBSTRING(cc.fin_funciones,1,1)='2' THEN 
                    DATE_FORMAT(cc.fin_funciones,'%d/%m/%Y') ELSE '' END AS fin_funciones,
                    CASE WHEN SUBSTRING(cc.inicio_contrato,1,1)='2' THEN 
                    DATE_FORMAT(cc.inicio_contrato,'%d/%m/%Y') ELSE '' END AS inicio_contrato,
                    CASE WHEN SUBSTRING(cc.fin_contrato,1,1)='2' THEN 
                    DATE_FORMAT(cc.fin_contrato,'%d/%m/%Y') ELSE '' END AS fin_contrato,
                    cc.sueldo1,cc.sueldo2,cc.estado_contrato,
                    DATE_FORMAT(cc.fecha,'%d/%m/%Y') AS fecha,
                    CASE WHEN cc.archivo!='' THEN 'Si' ELSE 'No' END AS v_archivo,
                    DATE_FORMAT(cc.fec_reg,'%d/%m/%Y') AS fec_registro,us.usuario_codigo AS user_registro,
                    st.nom_status,st.color,cc.archivo,a.nom_perfil
                    FROM contrato_colaborador cc
                    LEFT JOIN users us ON us.id_usuario=cc.user_reg
                    LEFT JOIN status st ON st.id_status=cc.estado_contrato
                    left join perfil a on cc.id_perfil=a.id_perfil
                    WHERE cc.id_colaborador=$id_colaborador AND cc.estado=2
                    ORDER BY cc.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_cant_contrato_colaborador($id_colaborador){  
        $sql = "SELECT COUNT(*)+1 AS cantidad
                FROM contrato_colaborador 
                WHERE id_colaborador=$id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_tipo_contrato_rrhh($id_sede){  
        $sql = "SELECT id,nombre FROM tipo_contrato_rrhh 
                WHERE id_sede=$id_sede AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_contrato_colaborador($dato){ 
        $parte = "";
        if(isset($dato['id_contrato'])){
            $parte = "AND id_contrato!='".$dato['id_contrato']."'";
        }
        $sql = "SELECT id_contrato FROM contrato_colaborador 
                WHERE id_colaborador='".$dato['id_colaborador']."' AND 
                estado_contrato=".$dato['estado_contrato']." AND estado=2 $parte";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_contrato_colaborador(){
        $sql = "SELECT id_contrato FROM contrato_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO contrato_colaborador (id_colaborador,referencia,id_perfil,inicio_funciones,
                fin_funciones,inicio_contrato,fin_contrato,id_tipo_contrato1,sueldo1,id_tipo_contrato2,
                sueldo2,estado_contrato,archivo,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES ('".$dato['id_colaborador']."','".$dato['referencia']."','".$dato['id_perfil']."',
                '".$dato['inicio_funciones']."','".$dato['fin_funciones']."','".$dato['inicio_contrato']."',
                '".$dato['fin_contrato']."','".$dato['id_tipo_contrato1']."','".$dato['sueldo1']."',
                '".$dato['id_tipo_contrato2']."','".$dato['sueldo2']."','".$dato['estado_contrato']."',
                '".$dato['archivo']."',2,NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
        $id = $this->db->insert_id();
        return $id;
    }

    function update_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contrato_colaborador SET id_perfil='".$dato['id_perfil']."',
                inicio_funciones='".$dato['inicio_funciones']."',fin_funciones='".$dato['fin_funciones']."',
                inicio_contrato='".$dato['inicio_contrato']."',fin_contrato='".$dato['fin_contrato']."',
                id_tipo_contrato1='".$dato['id_tipo_contrato1']."',sueldo1='".$dato['sueldo1']."',
                id_tipo_contrato2='".$dato['id_tipo_contrato2']."',sueldo2='".$dato['sueldo2']."',
                archivo='".$dato['archivo']."',estado_contrato='".$dato['estado_contrato']."',fec_act=NOW(),
                user_act=$id_usuario 
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function delete_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE contrato_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function get_list_pago_colaborador($id_colaborador){  
        $sql = "SELECT pedido,tipo,subrubro,descripcion,monto,estado,aprobado_por,
                CASE WHEN SUBSTRING(fecha_aprobacion,1,1)='2' THEN DATE_FORMAT(fecha_aprobacion,'%d/%m/%Y') 
                ELSE '' END AS fecha_aprobacion,
                CASE WHEN SUBSTRING(fecha_entrega,1,1)='2' THEN DATE_FORMAT(fecha_entrega,'%d/%m/%Y') 
                ELSE '' END AS fecha_entrega,tipo_documento
                FROM pago_colaborador
                WHERE id_colaborador=$id_colaborador
                ORDER BY pedido ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_horario_colaborador($id_horario=null,$id_colaborador=null){
        if(isset($id_horario) && $id_horario>0){
            $sql = "SELECT a.id_horario,a.de,a.a,a.id_colaborador,a.cod_horario,
                    a.ch_lun,a.ch_mar,a.ch_mier,a.ch_jue,a.ch_vie,a.ch_sab,a.ch_dom,a.estado_registro,
                    (a.ch_lun+a.ch_mar+a.ch_mier+a.ch_jue+a.ch_vie+a.ch_sab+a.ch_dom) as ndias
                    FROM colaborador_horario_general a 
                    WHERE a.id_horario='$id_horario'";
        }else{
            $sql = "SELECT ch.id_horario,DATE_FORMAT(ch.de,'%d/%m/%Y') AS de,DATE_FORMAT(ch.a,'%d/%m/%Y') AS a,
                    (SELECT COUNT(1) FROM colaborador_horario_general_detalle cd 
                    WHERE cd.id_horario=ch.id_horario) AS dias_laborables,
                    CASE WHEN ch.estado_registro=1 THEN 'Activo' WHEN ch.estado_registro=2 THEN 'Inactivo' 
                    ELSE '' END AS estado
                    FROM colaborador_horario_general ch
                    WHERE ch.id_colaborador=$id_colaborador AND ch.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_horario_detalle_colaborador($id_colaborador){
        $sql = "SELECT cd.id_horario,CASE WHEN cd.dia=1 THEN 'Lunes' WHEN cd.dia=2 THEN 'Martes' 
                WHEN cd.dia=3 THEN 'Miércoles' WHEN cd.dia=4 THEN 'Jueves' WHEN cd.dia=5 THEN 'Viernes' 
                WHEN cd.dia=6 THEN 'Sábado' WHEN cd.dia=7 THEN 'Domingo' END AS dia,
                CASE WHEN cd.ch_m=1 THEN DATE_FORMAT(cd.ingreso_m,'%H:%i') ELSE '-' END AS ingreso_m,
                CASE WHEN cd.ch_m=1 THEN DATE_FORMAT(cd.salida_m,'%H:%i') ELSE '-' END AS salida_m,
                CASE WHEN cd.ch_alm=1 THEN DATE_FORMAT(cd.ingreso_alm,'%H:%i') ELSE '-' END AS ingreso_alm,
                CASE WHEN cd.ch_alm=1 THEN DATE_FORMAT(cd.salida_alm,'%H:%i') ELSE '-' END AS salida_alm,
                CASE WHEN cd.ch_t=1 THEN DATE_FORMAT(cd.ingreso_t,'%H:%i') ELSE '-' END AS ingreso_t,
                CASE WHEN cd.ch_t=1 THEN DATE_FORMAT(cd.salida_t,'%H:%i') ELSE '-' END AS salida_t,
                CASE WHEN cd.ch_c=1 THEN DATE_FORMAT(cd.ingreso_c,'%H:%i') ELSE '-' END AS ingreso_c,
                CASE WHEN cd.ch_c=1 THEN DATE_FORMAT(cd.salida_c,'%H:%i') ELSE '-' END AS salida_c,
                CASE WHEN cd.ch_n=1 THEN DATE_FORMAT(cd.ingreso_n,'%H:%i') ELSE '-' END AS ingreso_n,
                CASE WHEN cd.ch_n=1 THEN DATE_FORMAT(cd.salida_n,'%H:%i') ELSE '-' END AS salida_n,
                CASE WHEN SUBSTRING(ch.de,1,1)='2' THEN DATE_FORMAT(ch.de,'%d/%m/%Y') ELSE '' END AS de,
                CASE WHEN SUBSTRING(ch.a,1,1)='2' THEN DATE_FORMAT(ch.a,'%d/%m/%Y') ELSE '' END AS a,
                CASE WHEN ch.estado_registro=1 THEN 'Activo' WHEN ch.estado_registro=2 THEN 'Inactivo' 
                ELSE '' END AS estado
                FROM colaborador_horario_general_detalle cd
                LEFT JOIN colaborador_horario_general ch ON cd.id_horario=ch.id_horario
                WHERE ch.id_colaborador=$id_colaborador AND ch.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_horario_colaborador($dato){
        $v="";
        if($dato['id_horario']!=""){
            $v=" and id_horario!='".$dato['id_horario']."'";
        }
        $sql = "SELECT COUNT(*) AS cantidad FROM colaborador_horario_general 
                WHERE id_colaborador='".$dato['id_colaborador']."' and estado=2 and estado_registro=1 $v";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_horario(){
        $sql = "SELECT COUNT(*) AS cantidad FROM colaborador_horario_general";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_horario_colaborador($dato){ 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colaborador_horario_general (id_colaborador,cod_horario,de,a,ch_lun,ch_mar,ch_mier,
                ch_jue,ch_vie,ch_sab,ch_dom,estado_registro,estado,fec_reg,user_reg,fec_act,user_act)
                VALUES ('".$dato['id_colaborador']."','".$dato['cod_horario']."','".$dato['de']."',
                '".$dato['a']."','".$dato['ch_lun']."','".$dato['ch_mar']."','".$dato['ch_mier']."',
                '".$dato['ch_jue']."','".$dato['ch_vie']."','".$dato['ch_sab']."','".$dato['ch_dom']."',1,2,
                NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
        $id = $this->db->insert_id();
        return $id;
    }

    function insert_horario_detalle_colaborador($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO colaborador_horario_general_detalle (id_horario,dia,ch_m,ch_alm,ch_t,ch_c,ch_n,
                ingreso_m,salida_m,ingreso_alm,salida_alm,ingreso_t,salida_t,ingreso_c,salida_c,ingreso_n,
                salida_n) 
                VALUES ('".$dato['id_horario']."','".$dato['dia']."','".$dato['ch_m']."','".$dato['ch_alm']."',
                '".$dato['ch_t']."','".$dato['ch_c']."','".$dato['ch_n']."','".$dato['ingreso_m']."',
                '".$dato['salida_m']."','".$dato['ingreso_alm']."','".$dato['salida_alm']."',
                '".$dato['ingreso_t']."','".$dato['salida_t']."','".$dato['ingreso_c']."',
                '".$dato['salida_c']."','".$dato['ingreso_n']."','".$dato['salida_n']."')";
        $this->db->query($sql);
    }

    function get_dia_horario_colaborador($id_horario){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT a.id_horario_detalle,a.dia,
                a.ch_m,a.ch_alm,a.ch_t,a.ch_c,a.ch_n,
                a.ingreso_m,a.salida_m,a.ingreso_alm,a.salida_alm,a.ingreso_t,a.salida_t,
                a.ingreso_c,a.salida_c,a.ingreso_n,a.salida_n
                FROM colaborador_horario_general_detalle a 
                WHERE a.id_horario=$id_horario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_horario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general SET de='".$dato['de']."',a='".$dato['a']."',
                ch_lun='".$dato['ch_lun']."',ch_mar='".$dato['ch_mar']."',ch_mier='".$dato['ch_mier']."',
                ch_jue='".$dato['ch_jue']."',ch_vie='".$dato['ch_vie']."',ch_sab='".$dato['ch_sab']."',
                ch_dom='".$dato['ch_dom']."',estado_registro='".$dato['estado_registro']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_horario='".$dato['id_horario']."'";
        $this->db->query($sql);
    }

    function delete_horario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador_horario_general SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_horario='".$dato['id_horario']."'";
        $this->db->query($sql);
        $sql = "UPDATE registro_asistencia_docente SET estado=4,fec_eli=GETDATE(),user_eli=$id_usuario 
                WHERE id_horario='".$dato['id_horario']."'";
        $this->db5->query($sql);
    }

    function delete_horario_detalle_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM colaborador_horario_general_detalle
                WHERE id_horario='".$dato['id_horario']."'";
        $this->db->query($sql);
    }

    function get_list_combo_anio_asistencia($id_colaborador){
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

    function get_list_combo_mes_asistencia($dato){
        if($dato['id_anio']!="0"){
            $var1 =" and DATEPART(YEAR, ri.ingreso)='".$dato['id_anio']."' ";
        }else{
            $var1 =" and DATEPART(YEAR, ri.ingreso)=DATEPART(YEAR, GETDATE())";
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
                WHERE ri.estado=2 AND SUBSTRING(REPLACE(ri.codigo, '''C', ''), 1, LEN(ri.codigo) - 2)='".$dato['codigo']."' and ri.codigo LIKE '%''C%' $var1
                group by MONTH(ri.ingreso) ORDER BY MONTH(ri.ingreso);";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_asistencia_colaborador($dato){
        if($dato['id_anio']!="0"){
            $var1 =" and CONVERT(varchar,DATEPART(YEAR, ri.ingreso),103)='".$dato['id_anio']."' and CONVERT(varchar,DATEPART(MONTH, ri.ingreso),103)='".$dato['id_mes']."' ";
        }else{
            $var1 =" and CONVERT(varchar,DATEPART(YEAR, ri.ingreso),103)=DATEPART(YEAR, GETDATE())";
        }
        $sql = "SELECT ri.id_registro_ingreso,ri.codigo,ri.ingreso AS orden,
                CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
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
                WHERE ri.estado=2 AND SUBSTRING(REPLACE(ri.codigo, '''C', ''), 1, LEN(ri.codigo) - 2)='".$dato['codigo']."' and ri.codigo LIKE '%''C%' $var1
                ORDER BY ri.ingreso ASC"; 
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_asistencia_observacion_colaborador($id_registro_ingreso){
        $sql = "SELECT FORMAT(fec_reg,'dd/MM/yyyy') AS fecha,
                CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' ELSE '' END AS tipo_desc,observacion
                FROM historial_registro_ingreso 
                WHERE id_registro_ingreso=$id_registro_ingreso AND estado=2";
        $query = $this->db5->query($sql)->result_Array(); 
        return $query;
    }

    function get_list_compra_colaborador($id_colaborador){  
        $sql = "SELECT ve.fec_reg AS orden,vd.cod_producto,vd.precio,vd.cantidad,(vd.precio*vd.cantidad) AS total,
                ve.cod_venta,DATE_FORMAT(ve.fec_reg,'%d/%m/%Y') AS fecha_pago,us.usuario_codigo
                FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                LEFT JOIN users us ON us.id_usuario=ve.user_reg
                WHERE al.id_sede IN (25,26) AND ve.id_alumno=$id_colaborador AND ve.estado=2 AND 
                ve.estado_venta=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_colaborador($id_observacion=null,$id_colaborador=null){  
        if(isset($id_observacion) && $id_observacion>0){
            $sql = "SELECT * FROM observacion_colaborador
                    WHERE id_observacion=$id_observacion"; 
        }else{
            $sql = "SELECT oc.id_observacion,DATE_FORMAT(oc.fecha,'%d/%m/%Y') AS fecha,ti.nom_tipo,
                    us.usuario_codigo AS usuario,oc.observacion,oc.fecha AS orden,oc.observacion_archivo,
                    CASE WHEN oc.observacion_archivo!='' THEN 'Si' ELSE 'No' END AS v_documento
                    FROM observacion_colaborador oc
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=oc.id_tipo
                    LEFT JOIN users us ON us.id_usuario=oc.usuario
                    WHERE oc.id_colaborador=$id_colaborador AND oc.estado=2
                    ORDER BY oc.fecha DESC"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_colaborador($dato){
        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT id_observacion FROM observacion_colaborador 
                WHERE id_tipo='".$dato['id_tipo']."' AND fecha='".$dato['fecha']."' AND 
                observacion='".$dato['observacion']."' AND id_colaborador='".$dato['id_colaborador']."' 
                AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO observacion_colaborador (id_colaborador,id_tipo,fecha,usuario,observacion,
                observacion_archivo,id_empresa,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES ('".$dato['id_colaborador']."','".$dato['id_tipo']."','".$dato['fecha']."',
                '".$dato['usuario']."','".$dato['observacion']."','".$dato['observacion_archivo']."',6,2,
                NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_comentario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET comentariog='".$dato['comentariog']."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);
    }

    function delete_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE observacion_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }

    /*---------Documento--Colaborador---------*/
    function get_list_colaborador_combo($dato){
        $sql = "SELECT id_colaborador,CONCAT(apellido_paterno,' ',apellido_materno,', ',nombres) AS nom_colaborador
                FROM colaborador WHERE id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' AND estado=2
                ORDER BY nombres ASC,apellido_paterno ASC,apellido_materno ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_insert_documento_colab($dato){
        $sql = "SELECT * FROM documento_colaborador_empresa 
                WHERE id_anio='".$dato['id_anio']."' AND id_empresa='".$dato['id_empresa']."' AND id_sede='".$dato['id_sede']."' AND cod_documento='".$dato['cod_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_documento_colab($dato,$id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_colaborador_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    st.nom_status,CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion,
                    em.cod_empresa, case when do.id_sede = 0 then 'Todos' else se.cod_sede end as 'cod_sede',
                    do.id_anio,an.nom_anio
                    FROM documento_colaborador_empresa do
                    LEFT JOIN status st ON st.id_status=do.estado
                    LEFT JOIN empresa em ON em.id_empresa = do.id_empresa
                    LEFT JOIN sede se ON se.id_sede = do.id_sede
                    LEFT JOIN anio an ON an.id_anio = do.id_anio
                    WHERE /*do.id_empresa='".$dato['id_empresa']."' and do.id_sede='".$dato['id_sede']."' AND*/ do.estado!=4
                    ORDER BY do.nom_documento ASC,do.descripcion_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function insert_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_colaborador_empresa (id_empresa, id_sede,cod_documento,nom_documento,
                descripcion_documento,obligatorio,digital,aplicar_todos,validacion,id_anio,estado,fec_reg,user_reg) 
                VALUES (".$dato['id_empresa'].",".$dato['id_sede'].",'".$dato['cod_documento']."','".$dato['nom_documento']."',
                '".$dato['descripcion_documento']."','".$dato['obligatorio']."','".$dato['digital']."',
                '".$dato['aplicar_todos']."','".$dato['validacion']."',".$dato['id_anio'].",2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    function ultimo_id_documento_colab($dato){
        $sql = "SELECT id_documento FROM documento_colaborador_empresa 
                WHERE id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' ORDER BY id_documento DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_update_documento_colab($dato){
        $sql = "SELECT * FROM documento_colaborador_empresa 
                WHERE id_anio='".$dato['id_anio']."' and id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' AND cod_documento='".$dato['cod_documento']."' 
                AND estado=2 AND id_documento!='".$dato['id_documento']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_colaborador_empresa SET cod_documento='".$dato['cod_documento']."',
                nom_documento='".$dato['nom_documento']."',
                descripcion_documento='".$dato['descripcion_documento']."',
                obligatorio='".$dato['obligatorio']."',digital='".$dato['digital']."',
                aplicar_todos='".$dato['aplicar_todos']."',validacion='".$dato['validacion']."',
                id_anio='".$dato['id_anio']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    function delete_documento_colab($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_colaborador_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    function valida_insert_documento_todos_colab($dato){
        $sql = "SELECT * FROM detalle_colaborador_empresa 
                WHERE id_colaborador='".$dato['id_colaborador']."' AND id_sede='".$dato['id_sede']."'
                and id_documento='".$dato['id_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function insert_documento_todos_colab($dato){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_colaborador_empresa (id_colaborador,id_documento,id_empresa, id_sede,anio,
                    estado,fec_reg,user_reg)
                    VALUES ('" . $dato['id_colaborador'] . "','" . $dato['id_documento'] . "',".$dato['id_empresa'].",
                    '".$dato['id_sede']."', '" . $dato['id_anio'] . "',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    // ---------------------- lISTA DE FOTOCHECK DE COLABORADORES --------------------------------------
    function get_list_fotocheck($dato){
        $parte = "and  f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if($dato['tipo']==1){
            $parte = "and f.esta_fotocheck NOT IN (2,3,99)";
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
                FROM fotocheck_colaborador f
                LEFT JOIN colaborador tl ON f.Id=tl.id_colaborador
                WHERE tl.id_sede='".$dato['id_sede']."' $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
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
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio, tl.id_empresa, c.nom_cf,tl.id_empresa,tl.id_sede
                FROM fotocheck_colaborador fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN colaborador tl ON tl.id_colaborador=fo.Id
                LEFT JOIN cargo_fotocheck c ON tl.id_cargo_foto=c.id_cf
                WHERE fo.id_fotocheck=$id_fotocheck";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_documento_colaborador($dato,$cod_documento){
        $sql = "SELECT id_documento FROM documento_colaborador_empresa 
                WHERE id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' AND 
                cod_documento='$cod_documento' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_detalle_colaborador_empresa($id_colaborador,$id_documento){
        $sql = "SELECT id_detalle FROM detalle_colaborador_empresa 
                WHERE id_colaborador=$id_colaborador AND id_documento=$id_documento AND estado=2
                ORDER BY id_detalle DESC";
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
        $sql = "UPDATE fotocheck_colaborador SET $foto_fotocheck='".$dato[$foto_fotocheck]."',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function update_documento_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_colaborador_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function valida_fotocheck_completo($id_fotocheck){
        $sql = "SELECT id_fotocheck FROM fotocheck_colaborador 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_fotocheck_completo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_colaborador SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function impresion_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_colaborador SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function anular_envio($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE fotocheck_colaborador SET esta_fotocheck=3,obs_anulado='".$dato['obs_anulado']."',usuario_anulado=$id_usuario,
                fecha_anulado=NOW(),user_act=$id_usuario WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function get_id_user(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM users where id_usuario='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cargo_x_id($id_usuario_de){
        $sql = "SELECT * FROM (SELECT * FROM cargo where id_usuario_de=$id_usuario_de ORDER BY cod_cargo DESC LIMIT 10) AS cargo 
            ORDER BY cod_cargo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_envio_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_colaborador SET fecha_envio='".$dato['fecha_envio']."',
                    usuario_encomienda='".$dato['usuario_encomienda']."',
                    cargo_envio='".$dato['cargo_envio']."',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }

    function get_list_empresa(){
        $sql = "SELECT * FROM empresa where estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede($id_empres){
        $sql = "SELECT * FROM sede s
                left join empresa e on e.id_empresa = s.id_empresa
                where e.id_empresa=$id_empres and s.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_detalle_colaborador_empresa($id_detalle){
        $sql = "SELECT *,e.cod_empresa FROM detalle_colaborador_empresa dce
                left join empresa e on dce.id_empresa = e.id_empresa 
                WHERE dce.id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_documento($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_colaborador_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,st.nom_status,
                    CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_colaborador_empresa do
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=2 AND do.estado!=4
                    ORDER BY do.obligatorio DESC,do.nom_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function descartar_documento_colaborador($dato){
        $sql = "UPDATE detalle_colaborador_empresa SET archivo='',fec_subido=NULL,user_subido=0
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function delete_documento_colaborador($dato){
        $sql = "DELETE FROM detalle_colaborador_empresa
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio where nom_anio >= 2021";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_x_sede($id_colaborador,$id_sede){
        $sql = "SELECT dce.id_anio,an.nom_anio
        FROM documento_colaborador_empresa dce
        left join anio an on dce.id_anio = an.id_anio 
        WHERE id_documento NOT IN (
            SELECT id_documento
            FROM detalle_colaborador_empresa where id_sede=$id_sede and id_colaborador=$id_colaborador
        ) and id_sede=$id_sede and dce.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_x_sede_anio($dato){
        $sql = "SELECT dce.nom_documento
        FROM documento_colaborador_empresa dce
        WHERE id_documento NOT IN (
            SELECT id_documento
            FROM detalle_colaborador_empresa where id_sede=".$dato['id_sede']." and 
            id_colaborador=".$dato['id_colaborador']." and id_anio=".$dato['id_anio']."
        ) and id_sede=".$dato['id_sede']." and id_anio=".$dato['id_anio']." and dce.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_documento_x_sede_anio_nombre($dato){
        $sql = "SELECT dce.id_empresa,dce.id_documento,dce.cod_documento, case when dce.obligatorio=1 then 'SI' else 'NO' end as obligatorio
        FROM documento_colaborador_empresa dce
        WHERE id_documento NOT IN (
            SELECT id_documento
            FROM detalle_colaborador_empresa where id_sede=".$dato['id_sede']." and 
            id_colaborador=".$dato['id_colaborador']." and id_anio=".$dato['id_anio']."
        ) and id_sede=".$dato['id_sede']." and id_anio=".$dato['id_anio']." and nom_documento='".$dato['nombre']."' and dce.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

 /*---------Cargo-Fotocheck----------*/
    function get_list_cargo_fotocheck($dato,$tipo){
        
        if($tipo==2){
            $varid="id_cf = '".$dato['id_cf']."'";
        }else{
            $varid="cf.idsede_cf='".$dato['id_sede']."'";
        }
        $sql = "SELECT id_cf,nom_cf,st.nom_status,st.color,cf.idsede_cf,cf.estado
                FROM cargo_fotocheck cf
                LEFT JOIN status st ON cf.estado=st.id_status
                WHERE $varid
                ORDER BY nom_cf ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cargo_fotocheck_colaborador($dato,$tipo){
        $varid='';
        if($tipo==2){
            $varid="and id_cf != '".$dato['id_cf']."'";
        }
        $sql = "SELECT id_cf from cargo_fotocheck WHERE idsede_cf='".$dato['id_sede']."' and nom_cf='".$dato['nom_cf']."' and estado=2 $varid";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cargo_fotocheck_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT cargo_fotocheck (nom_cf,idempresa_cf,idsede_cf,estado,fec_reg,user_reg) values
        ('".$dato['nom_cf']."','".$dato['id_empresa']."','".$dato['id_sede']."','".$dato['estado']."',$id_usuario,NOW())";
        $this->db->query($sql);
    }

    function update_cargo_fotocheck_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cargo_fotocheck set nom_cf = '".$dato['nom_cf']."',idempresa_cf='".$dato['id_empresa']."',idsede_cf='".$dato['id_sede']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario WHERE id_cf = '".$dato['id_cf']."'";
        $this->db->query($sql);
    }

    function delete_cargo_fotocheck_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cargo_fotocheck SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_cf='".$dato['id_cf']."'";
        $this->db->query($sql);
    }

}