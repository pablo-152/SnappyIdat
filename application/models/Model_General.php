<?php
class Model_General extends CI_Model {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }

    public function raw($raw_query, $as_array = false) {
        $query = $this->db->query($raw_query);
        if (is_bool($query)) {
            return true;
        } else {
            if ($as_array) {
                return $query->result_array(); 
            }
            return $query->result();
        }
    }

    function get_list_aviso(){
        $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT id_aviso,CASE WHEN id_accion=1 THEN 'Alerta'
                WHEN id_accion=2 THEN 'Aviso' WHEN id_accion=3 THEN 'Recordatorio' 
                ELSE '' END AS nom_accion,mensaje,link
                FROM aviso
                WHERE id_perfil=$id_nivel AND estado=2 AND leido=0";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_aviso_todo(){
        $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT av.id_aviso,ni.nom_nivel AS nom_perfil,CASE WHEN av.id_fecha=1 THEN 'Diario' 
                    WHEN av.id_fecha=2 THEN 'Semanal' WHEN av.id_fecha=3 THEN 'Quincenal' 
                    WHEN av.id_fecha=4 THEN 'Mensual' ELSE '' END AS nom_fecha,av.tipo,
                    CASE WHEN av.id_accion=1 THEN 'Alerta' WHEN av.id_accion=2 THEN 'Aviso' 
                    WHEN av.id_accion=3 THEN 'Recordatorio' ELSE '' END AS nom_accion,av.mensaje,
                    av.leido,av.link,CASE WHEN av.leido=1 THEN 'Si' ELSE 'No' END v_leido
                    FROM aviso av 
                    LEFT JOIN nivel ni ON ni.id_nivel=av.id_perfil
                    WHERE av.id_perfil=$id_nivel AND av.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nivel(){
        $sql = "SELECT * FROM nivel 
                WHERE estado=1 
                ORDER BY nom_nivel ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_confg_fondo(){
        $sql = "select * from fintranet where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_id_empresa($id_empresa){
        if(isset($id_empresa) && $id_empresa > 0){
            $sql = "select * from empresa where id_empresa =".$id_empresa;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_idsede($id_sede){
        if(isset($id_sede) && $id_sede > 0){
            $sql = "select *, case when id_local=0 then 'Ninguno'
                    when id_local=1 then 'Jesús María'
                    when id_local=2 then 'Chincha' else '' end as nom_local
                    from sede where id_sede =".$id_sede;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;

    }
    function valida_reg_codempre($dato){ 
      $sql="SELECT * from empresa where cod_empresa='".$dato['cod_empresa']."' and estado=2";
      $query = $this->db->query($sql)->result_Array();
      return $query;
    }

    function valida_reg_codsede($dato){
     $sql="SELECT * from sede where cod_sede='".$dato['cod_sede']."' and estado=2";
      $query = $this->db->query($sql)->result_Array();
      return $query;   
    }

    function valida_reg_codsede_bd($dato){
        $sql="SELECT * from sede where b_datos=1 and id_empresa='".$dato['id_empresa']."' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;   
    }

    function valida_reg_codsede_bd_total(){
        $sql="SELECT * from sede where b_datos=1 and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;   
    }
    
    function valida_reg_codsede_bd_empresa($dato){
        $sql="SELECT * from sede where b_datos=1 and estado=2 and id_empresa<>".$dato['id_empresa']." GROUP by id_empresa ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_codsede_bd_empresa_upd($dato){
        $sql="SELECT * from sede where b_datos=1 and estado=2 and id_empresa<>".$dato['id_empresa']." and id_sede<>".$dato['id_sede']." GROUP by id_empresa ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_codsede_bd_upd($dato){
        $sql="SELECT * from sede where b_datos=1 and estado=2 and id_empresa='".$dato['id_empresa']."' and id_sede<>'".$dato['id_sede']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;   
    }

    function valida_reg_codsede_bd_upd_total($dato){
        $sql="SELECT * from sede where b_datos=1 and estado=2 and id_sede<>'".$dato['id_sede']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;   
    }

     function list_cod_empresa(){
        $sql = "select id_empresa,cod_empresa,nom_empresa from empresa where estado=2 ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_empresa($id_empresa){
        $sql = "select cod_empresa from empresa WHERE id_empresa='".$id_empresa."' ";
            $query = $this->db->query($sql);
            if($query->num_rows()==0){ return false; }
            return $query->row()->cod_empresa;
    }

    function get_list_sede(){
        $sql = "SELECT se.*, s.nom_status,em.empresa,em.nom_empresa,em.cod_empresa, 
                CASE WHEN se.rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte,
                CASE WHEN se.b_datos =1 THEN 'Si' ELSE 'No' END AS bd,
                CASE WHEN se.aparece_menu=1 THEN 'Si' ELSE 'No' END AS aparece_menu,
                case when id_local=0 then 'Ninguno'
                when id_local=1 then 'Jesús María'
                when id_local=2 then 'Chincha' else '' end as nom_local
                FROM sede se
                LEFT JOIN status s on se.estado=s.id_status
                LEFT JOIN empresa em on se.id_empresa=em.id_empresa
                ORDER BY se.cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function count_usuario(){
        $sql="SELECT * from users";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    /*function get_list_usuario(){
        $sql = "SELECT u.id_usuario,n.nom_nivel, s.nom_status, h.fec_ingreso,u.usuario_codigo,u.codigo,u.usuario_apater,u.usuario_amater,
                u.usuario_nombres,u.codigo_gllg,u.ini_funciones,u.fin_funciones from users u 
                left join nivel n on u.id_nivel=n.id_nivel
                left join status s on u.estado=s.id_status
                left join (select * from hingreso order by fec_ingreso desc) h on h.id_usuario=u.id_usuario
                where u.id_nivel!=6 and u.estado in (2)
                group by u.id_usuario ORDER BY u.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function get_list_usuario(){
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
        where u.id_nivel!=6 and u.estado=2
        group by u.id_usuario  
        ORDER BY u.usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_inactivos(){
        $sql = "SELECT u.id_usuario,n.nom_nivel,u.estado, s.nom_status,DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i') AS ultimo_ingreso,
        u.usuario_codigo,u.codigo,u.usuario_apater,u.usuario_amater,u.usuario_nombres,u.codigo_gllg,u.ini_funciones,u.fin_funciones,
        h.fec_ingreso AS ultimo_ingreso_excel
        FROM users u 
        left join nivel n on u.id_nivel=n.id_nivel
        left join status s on u.estado=s.id_status
        left join hingreso_ultimo h on h.id_usuario=u.id_usuario
        where u.id_nivel!=6 and u.estado=3
        group by u.id_usuario  
        ORDER BY u.usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_confg_foto(){
        $sql = "SELECT f.id_fintranet,f.nom_fintranet,f.foto,f.estado,f.id_empresa,
                CASE WHEN f.id_empresa=100 THEN 'General' ELSE em.nom_empresa END AS nom_empresa  
                FROM fintranet f
                LEFT JOIN empresa em on f.id_empresa = em.id_empresa
                ORDER BY nom_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_mes(){
        $sql = "SELECT * FROM mes";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_empresa(){
        $sql = "SELECT id_empresa FROM empresa ORDER BY id_empresa DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');

        $path = $_FILES['imagen']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        $config['upload_path'] = './imagen_empresa/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "imagen_".$fecha."_".rand(1,999).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }

        $ruta = "imagen_empresa/".$config['file_name'];

        $config['allowed_types'] = "jpg|png|jpeg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            $sql = "INSERT INTO empresa (cd_empresa,empresa,nom_empresa,cod_empresa,ruc,web,rep_redes,rep_sunat,balance,orden_menu, 
                    cuenta_bancaria,mes,anio,color,estado,observaciones_empresa,fecha_inicio,imagen,fec_reg,user_reg) 
                    VALUES ('".$dato['cd_empresa']."','".$dato['empresa']."','".$dato['nom_empresa']."','".$dato['cod_empresa']."',
                    '".$dato['ruc']."','".$dato['web']."','".$dato['rep_redes']."','".$dato['rep_sunat']."','".$dato['balance']."','".$dato['orden_menu']."',
                    '".$dato['cuenta_bancaria']."','". $dato['mes']."','".$dato['anio']."','".$dato['color']."',
                    '".$dato['estado']."','".$dato['observaciones_empresa']."','".$dato['fecha_inicio']."','".$ruta."',NOW(),$id_usuario)";
        }else{
            $sql = "INSERT INTO empresa (cd_empresa,empresa,nom_empresa,cod_empresa,ruc,web,rep_redes,rep_sunat,balance,orden_menu, 
                    cuenta_bancaria,mes,anio,color,estado,observaciones_empresa,fecha_inicio,fec_reg,user_reg) 
                    VALUES ('".$dato['cd_empresa']."','".$dato['empresa']."','".$dato['nom_empresa']."','".$dato['cod_empresa']."',
                    '".$dato['ruc']."','".$dato['web']."','".$dato['rep_redes']."','".$dato['rep_sunat']."','".$dato['balance']."','".$dato['orden_menu']."',
                    '".$dato['cuenta_bancaria']."','". $dato['mes']."','".$dato['anio']."','".$dato['color']."',
                    '".$dato['estado']."','".$dato['observaciones_empresa']."','".$dato['fecha_inicio']."',NOW(),$id_usuario)";
        }

        $this->db->query($sql);
    }

    function update_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');

        $path = $_FILES['imagen']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        $config['upload_path'] = './imagen_empresa/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "imagen_".$fecha."_".rand(1,999).".".$ext;
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = "imagen_empresa/".$config['file_name'];

        $config['allowed_types'] = "jpg|png|jpeg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            unlink($dato['imagen_actual']);

            $sql = "UPDATE empresa SET cd_empresa='".$dato['cd_empresa']."',empresa ='". $dato['empresa']."',
                    nom_empresa='". $dato['nom_empresa']."',cod_empresa='". $dato['cod_empresa']."',
                    ruc='". $dato['ruc']."',web='". $dato['web']."',orden_menu='". $dato['orden_menu']."',
                    cuenta_bancaria='". $dato['cuenta_bancaria']."',mes='". $dato['mes']."',
                    anio='".$dato['anio']."',color='". $dato['color']."',estado='". $dato['estado']."',
                    rep_redes='". $dato['rep_redes']."',rep_sunat='". $dato['rep_sunat']."',
                    balance='". $dato['balance']."',observaciones_empresa='".$dato['observaciones_empresa']."',
                    fecha_inicio='". $dato['fecha_inicio']."',imagen='".$ruta."',fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_empresa='".$dato['id_empresa']."'";
        }else{
            $sql = "UPDATE empresa SET cd_empresa='".$dato['cd_empresa']."',empresa ='". $dato['empresa']."',
                    nom_empresa='". $dato['nom_empresa']."',cod_empresa='". $dato['cod_empresa']."',
                    ruc='". $dato['ruc']."',web='". $dato['web']."',orden_menu='". $dato['orden_menu']."',
                    cuenta_bancaria='". $dato['cuenta_bancaria']."',mes='". $dato['mes']."',
                    anio='". $dato['anio']."',color='". $dato['color']."',estado='". $dato['estado']."',
                    rep_redes='". $dato['rep_redes']."',rep_sunat='". $dato['rep_sunat']."',balance='". $dato['balance']."',
                    observaciones_empresa='".$dato['observaciones_empresa']."',fecha_inicio='". $dato['fecha_inicio']."',
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_empresa='".$dato['id_empresa']."'";
        }

        $this->db->query($sql);
    }

    function delete_imagen_empresa($id_empresa){
        $sql = "UPDATE empresa SET imagen='' WHERE id_empresa=$id_empresa";
        $this->db->query($sql);
    }

    function Insert_sede($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO sede (id_empresa,cod_sede,orden_sede,rep_redes,observaciones_sede,
                codigo_sede,b_datos,aparece_menu,orden_menu,id_local,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_empresa']."','".$dato['cod_sede']."','".$dato['orden_sede']."',
                '".$dato['rep_redes']."','".$dato['observaciones_sede']."',
                '".$dato['codigo_sede']."','".$dato['b_datos']."','".$dato['aparece_menu']."',
                '".$dato['orden_menu']."','".$dato['id_local']."','".$dato['estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);

    }

    function update_sede($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE sede SET id_empresa ='". $dato['id_empresa']."',cod_sede ='". $dato['cod_sede']."',
                orden_sede='". $dato['orden_sede']."',estado='". $dato['estado']."',rep_redes='". $dato['rep_redes']."',
                observaciones_sede='". $dato['observaciones_sede']."',b_datos='". $dato['b_datos']."',
                aparece_menu='". $dato['aparece_menu']."',orden_menu='". $dato['orden_menu']."',id_local='".$dato['id_local']."',
                codigo_sede='". $dato['codigo_sede']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_sede='".$dato['id_sede']."'";
        $this->db->query($sql);
    }

    function contar_fondo_empresa($dato){
        $sql = "SELECT * FROM fintranet WHERE id_empresa='".$dato['id_empresa']."' AND estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function update_fondo_usado($dato){
        $sql = "UPDATE fintranet SET estado=2 WHERE id_empresa=".$dato['id_empresa'];
        echo $sql;
        $this->db->query($sql);
    }

    function insert_fondo($dato){
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['productImage']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'productImage';
        $config['upload_path'] = './fondos/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "fs".$fecha."_".rand(1,200).".".$ext;

        $ruta = "fondos/".$config['file_name'];

        $config['allowed_types'] = "png|jpg|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $sql1 = "update fintranet set estado=2 where id_empresa='". $dato['id_empresa']."'";
        $this->db->query($sql1);

        $sql = "insert into fintranet (nom_fintranet,id_empresa,foto, estado, fec_reg, user_reg) 
                values ('". $dato['nom_fintranet']."','". $dato['id_empresa']."','".$ruta."', '1', NOW(),".$id_usuario.")";
        $this->db->query($sql);
    }

    function update_foto($dato){

        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['actuimagen']['name'];

        //echo($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'actuimagen';
        $config['upload_path'] = './fondos/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "fs".$fecha."_".rand(1,200).".".$ext;

        $ruta = "fondos/".$config['file_name'];

        $config['allowed_types'] = "png|jpg|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();


        if (strlen($path)>0){
            
         $sql= "UPDATE fintranet SET nom_fintranet ='".$dato['nom_fintranet']."',id_empresa='".$dato['id_empresa']."', foto='".$ruta."', fec_act=NOW(), user_act='".$id_usuario."' WHERE id_fintranet = '".$dato['id_fintranet']."'"; 
        }
        else{
             $sql= "UPDATE fintranet SET nom_fintranet ='".$dato['nom_fintranet']."',id_empresa='".$dato['id_empresa']."', fec_act=NOW(), user_act='".$id_usuario."' WHERE id_fintranet = '".$dato['id_fintranet']."'"; 
        }
        //echo($sql);     
        
        $this->db->query($sql);

    }

    function get_list_empresa_usuario(){
        $sql = "SELECT * FROM empresa WHERE estado=2 ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_empresa_usuario(){
        $sql = "SELECT ue.*,em.cod_empresa FROM usuario_empresa ue
                LEFT JOIN empresa em on em.id_empresa=ue.id_empresa
                WHERE ue.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_empresa_usuario($id_usuario){
        $sql = "SELECT * FROM usuario_empresa WHERE id_usuario=$id_usuario AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede_usuario(){ 
        $sql = "SELECT * FROM sede WHERE estado=2 ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function list_sede_usuario(){ 
        $sql = "SELECT us.*,se.cod_sede FROM usuario_sede us
                LEFT JOIN sede se on se.id_sede=us.id_sede
                WHERE us.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_sede_usuario($id_usuario){
        $sql = "SELECT * FROM usuario_sede WHERE id_usuario=$id_usuario AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_usuario($dato){
        $sql = "SELECT * FROM users 
                WHERE tipo=1 AND usuario_codigo='".$dato['usuario_codigo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_usuario($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql = "INSERT INTO users (tipo,id_nivel,usuario_apater,usuario_amater,usuario_nombres,emailp,
                usuario_email,num_celp,codigo_gllg,codigo,ini_funciones,estado,usuario_codigo,
                usuario_password,password_desencriptado,observaciones,artes,redes,clave_asistencia,fec_reg,user_reg) 
                VALUES (1,'".$dato['id_nivel']."','".$dato['usuario_apater']."','".$dato['usuario_amater']."',
                '".$dato['usuario_nombres']."','".$dato['emailp']."','".$dato['emailp']."', 
                '".$dato['num_celp']."','".$dato['codigo_gllg']."','".$dato['codigo']."', 
                '".$dato['ini_funciones']."',2,'".$dato['usuario_codigo']."','".$dato['usuario_password']."',
                '".$dato['password_desencriptado']."','".$dato['observaciones']."','".$dato['artes']."',  
                '".$dato['redes']."','".$dato['clave_asistencia']."',NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function ultimo_id_usuario(){
        $sql = "SELECT id_usuario FROM users ORDER BY id_usuario DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_usuario_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO usuario_empresa (id_usuario,id_empresa,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_usuario']."','".$dato['id_empresa']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_usuario_sede($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO usuario_sede (id_usuario,id_sede,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_usuario']."','".$dato['id_sede']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_usuario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        if($dato['contraseña']!=""){
        $sql="update users set id_nivel='". $dato['id_nivel']."',
            id_usuario='". $dato['id_usuario']."',
            usuario_apater='". $dato['usuario_apater']."',
            usuario_amater='". $dato['usuario_amater']."',
            usuario_nombres='". $dato['usuario_nombres']."',
            emailp='". $dato['emailp']."',
            usuario_email='". $dato['emailp']."',
            num_celp='". $dato['num_celp']."',
            codigo_gllg='". $dato['codigo_gllg']."',
            ini_funciones='". $dato['ini_funciones']."',
            fin_funciones='". $dato['fin_funciones']."',
            usuario_codigo='". $dato['usuario_codigo']."',
            artes='". $dato['artes']."',
            redes='". $dato['redes']."',
            usuario_password='". $dato['usuario_password']."',
            password_desencriptado='". $dato['password_desencriptado']."',
            clave_asistencia='". $dato['clave_asistencia']."',
            observaciones='". $dato['observaciones']."',
            estado='". $dato['id_status']."', 
            fec_act='".$fecha."',
            user_act=".$id_usuario."  where id_usuario='". $dato['id_usuario']."'";
        }else{
            $sql="update users set id_nivel='". $dato['id_nivel']."',
            id_usuario='". $dato['id_usuario']."',
            usuario_apater='". $dato['usuario_apater']."',
            usuario_amater='". $dato['usuario_amater']."',
            usuario_nombres='". $dato['usuario_nombres']."',
            emailp='". $dato['emailp']."',
            usuario_email='". $dato['emailp']."',
            num_celp='". $dato['num_celp']."',
            codigo_gllg='". $dato['codigo_gllg']."',
            ini_funciones='". $dato['ini_funciones']."',
            fin_funciones='". $dato['fin_funciones']."',
            usuario_codigo='". $dato['usuario_codigo']."',
            artes='". $dato['artes']."',
            redes='". $dato['redes']."',
            clave_asistencia='". $dato['clave_asistencia']."',
            observaciones='". $dato['observaciones']."',
            estado='". $dato['id_status']."', 
            fec_act='".$fecha."',
            user_act=".$id_usuario."  where id_usuario='". $dato['id_usuario']."'";
        }
    
        $this->db->query($sql);
    }

    function delete_usuario_empresa($dato){
        $sql="DELETE FROM usuario_empresa WHERE id_usuario='".$dato['id_usuario']."'";
        $this->db->query($sql);
    }

    function update_usuario_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="INSERT INTO usuario_empresa (id_usuario,id_empresa,estado,fec_reg,user_reg) 
            VALUES ('".$dato['id_usuario']."','".$dato['id_empresa']."',2,NOW(),$id_usuario)";

        $this->db->query($sql);
    }

    function delete_usuario_sede($dato){
        $sql="DELETE FROM usuario_sede WHERE id_usuario='".$dato['id_usuario']."'";
        $this->db->query($sql);
    }

    function update_usuario_sede($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="INSERT INTO usuario_sede (id_usuario,id_sede,estado,fec_reg,user_reg) 
            VALUES ('".$dato['id_usuario']."','".$dato['id_sede']."',2,NOW(),$id_usuario)";

        $this->db->query($sql);
    }
    //-----------------------------------------------AVISOS----------------------------------------------
    function get_list_aviso_modulo($id_aviso=null){
        if(isset($id_aviso) && $id_aviso>0){
            $sql = "SELECT * FROM aviso 
                    WHERE id_aviso=$id_aviso";
        }else{
            $sql = "SELECT av.id_aviso,ni.nom_nivel AS nom_perfil,CASE WHEN av.id_fecha=1 THEN 'Diario' 
                    WHEN av.id_fecha=2 THEN 'Semanal' WHEN av.id_fecha=3 THEN 'Quincenal' 
                    WHEN av.id_fecha=4 THEN 'Mensual' ELSE '' END AS nom_fecha,av.tipo,
                    CASE WHEN av.id_accion=1 THEN 'Alerta' WHEN av.id_accion=2 THEN 'Aviso' 
                    WHEN av.id_accion=3 THEN 'Recordatorio' ELSE '' END AS nom_accion,av.mensaje,
                    av.leido,av.link,CASE WHEN av.leido=1 THEN 'Si' ELSE 'No' END v_leido
                    FROM aviso av 
                    LEFT JOIN nivel ni ON ni.id_nivel=av.id_perfil
                    WHERE av.estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_leido_aviso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE aviso SET leido='".$dato['leido']."'
                WHERE id_aviso='".$dato['id_aviso']."'";
        $this->db->query($sql);
    }
      
    function insert_aviso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO aviso (id_perfil,id_fecha,tipo,id_accion,mensaje,link,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_perfil']."','".$dato['id_fecha']."','".$dato['tipo']."',
                '".$dato['id_accion']."','".$dato['mensaje']."','".$dato['link']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_aviso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE aviso SET id_perfil='".$dato['id_perfil']."',
                id_fecha='".$dato['id_fecha']."',tipo='".$dato['tipo']."',
                id_accion='".$dato['id_accion']."',mensaje='".$dato['mensaje']."',
                link='".$dato['link']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_aviso='". $dato['id_aviso']."'";
        $this->db->query($sql);
    }
      /*------------------------------*/
      function get_list_proyecto_soporte(){
        $sql = "SELECT p.*,e.cod_empresa,s.nom_status FROM proyecto_soporte p
                LEFT JOIN empresa e on e.id_empresa=p.id_empresa
                LEFT JOIN status s on s.id_status=p.estado
                WHERE p.estado NOT IN (4) 
                ORDER BY e.cod_empresa ASC,p.proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }
  
      function valida_reg_proyecto_soporte($dato){ 
        $sql="SELECT * from proyecto_soporte where id_empresa='".$dato['id_empresa']."' and proyecto='".$dato['proyecto']."' and estado=2";
  
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }
      function insert_proyecto_soporte($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
  
        $sql = "insert into proyecto_soporte (id_empresa, 
        proyecto,
        estado, 
        fec_reg, 
        user_reg) 
                values ('". $dato['id_empresa']."',
                '". $dato['proyecto']."',
                '2',
                 '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
      }
  
      function get_id_proyecto_soporte($id_proyecto_soporte){
        if(isset($id_proyecto_soporte) && $id_proyecto_soporte > 0){
          $sql = "SELECT * from proyecto_soporte where id_proyecto_soporte =".$id_proyecto_soporte;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }
  
      function update_proyecto_soporte($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
  
        $sql = "update proyecto_soporte set 
                id_empresa='". $dato['id_empresa']."',
                proyecto='". $dato['proyecto']."',
                estado='". $dato['id_status']."',
                fec_act='".$fecha."', 
                user_act=".$id_usuario." where id_proyecto_soporte='". $dato['id_proyecto_soporte']."'";
                //echo $sql;
        $this->db->query($sql);
  
      }
      /*---------------------------*/
  
      function get_list_subproyecto_soporte(){
        $sql = "SELECT p.*,e.cod_empresa,s.nom_status,ps.proyecto 
                FROM subproyecto_soporte p
                LEFT JOIN proyecto_soporte ps ON ps.id_proyecto_soporte=p.id_proyecto_soporte
                LEFT JOIN empresa e ON e.id_empresa=ps.id_empresa
                LEFT JOIN status s ON s.id_status=p.estado
                WHERE p.estado NOT IN (4)
                ORDER BY e.cod_empresa ASC, ps.proyecto ASC, p.subproyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }
  
      function get_list_empresa_disctinc(){
        $sql = "SELECT DISTINCT p.id_empresa, e.cod_empresa from proyecto_soporte p
                left join empresa e on e.id_empresa=p.id_empresa
                WHERE p.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }

      function get_list_proyecto_x_empresa($id_empresa){
        $sql = "SELECT * FROM proyecto_soporte 
                WHERE id_empresa=$id_empresa AND estado=2 
                ORDER BY proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }

      function valida_reg_subproyecto_soporte($dato){ 
        $sql="SELECT * from subproyecto_soporte where id_empresa='".$dato['id_empresa']."' and id_proyecto_soporte='".$dato['id_proyecto_soporte']."' and subproyecto='".$dato['subproyecto']."' and estado=2";
  
        $query = $this->db->query($sql)->result_Array();
        return $query;
      }
      
      function insert_subproyecto_soporte($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
  
        $sql = "insert into subproyecto_soporte (id_empresa, 
        id_proyecto_soporte,
        subproyecto,
        estado, 
        fec_reg, 
        user_reg) 
        
        values ('". $dato['id_empresa']."',
        '". $dato['id_proyecto_soporte']."',
        '". $dato['subproyecto']."',
        '2',
          '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }
  
    function get_id_subproyecto_soporte($id_subproyecto_soporte){
        if(isset($id_subproyecto_soporte) && $id_subproyecto_soporte > 0){
            $sql = "SELECT * from subproyecto_soporte where id_subproyecto_soporte =".$id_subproyecto_soporte;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
  
    function update_subproyecto_soporte($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
  
        $sql = "update subproyecto_soporte set 
                id_empresa='". $dato['id_empresa']."',
                id_proyecto_soporte='". $dato['id_proyecto_soporte']."',
                subproyecto='". $dato['subproyecto']."',
                estado='". $dato['id_status']."',
                fec_act='".$fecha."', 
                user_act=".$id_usuario." where id_subproyecto_soporte='". $dato['id_subproyecto_soporte']."'";
                //echo $sql;
        $this->db->query($sql);
    }

    function get_list_usuario_activos(){
        $sql = "SELECT * FROM users WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
  
    function get_list_tipo_ticket(){
        $sql = "SELECT * from tipo_ticket ORDER BY nom_tipo_ticket ASC";
        $query = $this->db->query($sql)->result_Array();
         return $query; 
    }

    function get_id_tipo_ticket($id_tipo_ticket){
        if(isset($id_tipo_ticket) && $id_tipo_ticket > 0){
            $sql = "SELECT * FROM tipo_ticket WHERE id_tipo_ticket=".$id_tipo_ticket;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_subproyecto_x_empresa($dato){
        $sql = "SELECT * from subproyecto_soporte where id_empresa='".$dato['id_empresa']."' and 
                id_proyecto_soporte='".$dato['id_proyecto_soporte']."' and estado=2 ORDER BY subproyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_row_solicitadot (){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_row_solicitado(){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=1) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_row_asignadot(){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_row_asignado(){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=2) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    function get_row_entramitet(){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=3";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
  
    function get_row_entramite(){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=3) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function get_row_pendientet(){
        $sql = "SELECT SUM(s_artes) as artes, SUM(s_redes) as redes, COUNT(1) as total FROM proyecto WHERE STATUS=4";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_row_pendiente(){
        $sql = "SELECT SUM( s_artes ) AS artes, SUM( s_redes ) AS redes, COUNT(0) AS total , u.usuario_codigo 
                FROM users u
                left join (select * from proyecto where status=4) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_row_tp2(){
        $anio=date('Y');
        $semana=date('W');
      
        $sql = "SELECT SUM( s_artes ) as artest, SUM( s_redes ) AS redest, COUNT(0) AS total , u.usuario_codigo, u.artes, 
                u.redes from users u
                left join (select * from proyecto where semanat=$semana and anio=$anio and status in (5, 6, 7)) p on 
                p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
 
    function get_row_tp(){
        $anio=date('Y');
        $semana=date('W');
        $sql = "SELECT SUM( s_artes ) AS artest, SUM( s_redes ) AS redest, COUNT(0) AS total , u.usuario_codigo, u.artes, 
                u.redes from users u
                left join (select * from proyecto where semanat=$semana and anio=$anio and status in (5, 6, 7)) p on p.id_asignado=u.id_usuario 
                where u.id_nivel in (2,3,4) and u.estado=2
                GROUP BY u.id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*-------------------------------------------*/
    function get_solicitado(){
        $sql = "select * from users where id_nivel in (1,2,5) and estado=2 order by usuario_codigo";
        $query = $this->db->query($sql)->result_Array();
         return $query; 
    }

    function get_list_empresa(){
        $sql = "SELECT se.*, s.nom_status from empresa se
                LEFT JOIN status s on se.estado=s.id_status
                WHERE se.estado=2
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_empresa(){
        $sql = "SELECT se.*, s.nom_status, CASE WHEN rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte,
                CASE WHEN rep_sunat=1 THEN 'Si' ELSE 'No' END AS reporte_sunat
                from empresa se
                left join status s on se.estado=s.id_status
                where se.estado=2
                ORDER BY id_empresa";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------------TICKET----------------------------------------- 
    function get_list_solicitante_ticket(){
        $sql = "SELECT id_usuario,usuario_codigo FROM users 
                WHERE id_usuario IN (1,7,81,82,85)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_follow_up_ticket($id_usuario){
        $sql = "SELECT id_usuario,usuario_codigo FROM users 
                WHERE id_usuario IN (1,7,81,82,85) AND id_usuario NOT IN ($id_usuario)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO ticket (id_empresa,cod_ticket,id_tipo_ticket,id_solicitante,
                id_proyecto_soporte,id_subproyecto_soporte,ticket_desc,prioridad,ticket_obs,id_status_ticket,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_empresa']."','".$dato['cod_ticket']."','".$dato['id_tipo_ticket']."',
                '".$dato['id_solicitante']."','".$dato['id_proyecto_soporte']."',
                '".$dato['id_subproyecto_soporte']."','".addslashes($dato['ticket_desc'])."',
                '".$dato['prioridad']."','".addslashes($dato['ticket_obs'])."',1,NOW(),$id_usuario)";
        $this->db->query($sql);
        $sql2 = "INSERT INTO historial_ticket(id_ticket,user_asignado,ticket_obs,id_status_ticket,
                fec_reg,user_reg,estado) 
                VALUES ((SELECT id_ticket FROM ticket WHERE cod_ticket='".$dato['cod_ticket']."'),
                $id_usuario,'".addslashes($dato['ticket_obs'])."',1,NOW(),$id_usuario,1)";
        $this->db->query($sql2);
    }

    function ultimo_id_ticket(){
        $sql = "SELECT * FROM ticket WHERE id_status_ticket=1 ORDER BY id_ticket DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_ticket_follow_up($dato){
        $sql = "DELETE FROM ticket_follow_up WHERE id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql);
    }

    function insert_ticket_follow_up($dato){
        $sql = "INSERT INTO ticket_follow_up (id_ticket,id_usuario) 
                VALUES ('".$dato['id_ticket']."','".$dato['id_usuario']."')";
        $this->db->query($sql);
    }

    function ultimo_id_historial_ticket($dato){
        $sql = "SELECT * FROM historial_ticket 
        WHERE id_ticket='".$dato['id_ticket']."' AND estado=1 ORDER BY id_historial DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_historial_archivo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_archivo (id_historial,archivo,estado,fec_reg, user_reg) 
                VALUES ('".$dato['ultimo_id_historial']."','".$dato['ruta']."',1,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function traer_programador($dato){
        $sql = "SELECT id_mantenimiento FROM historial_ticket WHERE id_ticket='".$dato['id_ticket']."' 
                AND id_status_ticket=20";

        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_historial_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql2 = "INSERT INTO historial_ticket(id_ticket,user_asignado,ticket_obs,id_mantenimiento,
                    horas,minutos,id_status_ticket,fec_reg,user_reg,estado) 
                    VALUES ('".$dato['id_ticket']."',$id_usuario,'".addslashes($dato['ticket_obs'])."',
                    '".$dato['id_mantenimiento']."','".$dato['horas']."','".$dato['minutos']."',
                    '".$dato['id_status_ticket']."',
                    NOW(),$id_usuario,1)";

        $this->db->query($sql2);

        //------------------------------ACTUALIZAR TICKET------------------------------
        $sql = "UPDATE ticket SET id_status_ticket='".$dato['id_status_ticket']."'
                WHERE id_ticket='".$dato['id_ticket']."'";

        $this->db->query($sql);

        if($dato['id_status_ticket']==20){
            $sql3 = "UPDATE ticket SET id_mantenimiento='".$dato['id_mantenimiento']."'
                WHERE id_ticket='".$dato['id_ticket']."'";

            $this->db->query($sql3);
        }

        if(($dato['id_status_ticket']==2 || $dato['id_status_ticket']==20 || $dato['id_status_ticket']==23) && ($dato['horas']!="" || $dato['minutos']!="")){
            $sql4 = "UPDATE ticket SET horas='".$dato['horas']."',minutos='".$dato['minutos']."'
                    WHERE id_ticket='".$dato['id_ticket']."'";

            $this->db->query($sql4);
        }
    }

    function update_prioridad_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE ticket SET prioridad=100 
                WHERE id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql);
    }

    function traer_correo_presupuesto(){
        $sql = "SELECT emailp FROM users
                WHERE id_usuario IN (1,7)";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function traer_correo_follow_up($id_ticket){
        $sql = "SELECT us.emailp FROM ticket_follow_up tf
                LEFT JOIN users us ON tf.id_usuario=us.id_usuario
                WHERE tf.id_ticket=$id_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function traer_correo_contestado($id_mantenimiento){
        $sql = "SELECT emailp FROM users
                WHERE id_usuario IN (5,33) AND id_usuario NOT IN ($id_mantenimiento)";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function list_historial_ticket(){
        $sql = "SELECT ht.*,sg.nom_status as ultimo_status FROM historial_ticket ht
                LEFT JOIN status_general sg on sg.id_status_general=ht.id_status_ticket
                ORDER BY ht.id_historial DESC";

        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function busca_ticket($id_estatus=null){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        if($id_estatus==0){
            $estado = "IN (1,2,12,20,21,22,27,36)";
        }elseif($id_estatus==1){
            $estado = "IN (1)";
        }elseif($id_estatus==2){
            $estado = "IN (2)";
        }elseif($id_estatus==3){
            $estado = "IN (21)";
        }elseif($id_estatus==4){
            $estado = "IN (22)";
        }elseif($id_estatus==5){
            $estado = "IN (23)";
        }elseif($id_estatus==7){
            $parte = "";
            if($id_usuario <> 5){
                $parte="AND t.completado=0";
            }
            $estado = "IN (34,77) $parte";
        }elseif($id_estatus==8){
            $estado = "NOT IN (37) AND t.completado=1";
        }else{
            $estado = "NOT IN (99)";
        }

        $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                st.nom_status,DATE_FORMAT(t.fec_reg,'%d/%m/%Y') AS fecha_registro,m.nom_mes,
                YEAR(t.fec_reg) AS anio,ROUND(t.horas+(ROUND(t.minutos/60,2)),1) AS tiempo,
                (SELECT COUNT(*) FROM historial_ticket 
                WHERE id_ticket=t.id_ticket) AS historial,ue.usuario_nombres AS colaborador_nombres,
                ue.usuario_apater AS colaborador_apater,uo.usuario_codigo AS cod_soli,             
                (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket 
                WHERE id_ticket=t.id_ticket 
                ORDER BY id_historial DESC 
                limit 1) AS fecha_registro_th,
                (SELECT ue.usuario_codigo FROM historial_ticket 
                WHERE id_mantenimiento=ue.id_usuario 
                ORDER BY id_mantenimiento DESC 
                limit 1) AS colaborador_codigo,
                (SELECT ss.nom_status FROM historial_ticket htt 
                LEFT JOIN status_general ss ON ss.id_status_general=htt.id_status_ticket 
                WHERE htt.id_ticket=t.id_ticket AND htt.estado=1 
                ORDER BY htt.fec_reg DESC 
                LIMIT 1) AS nom_status,
                (SELECT ss.color FROM historial_ticket htt 
                LEFT JOIN status_general ss ON ss.id_status_general=htt.id_status_ticket 
                WHERE htt.id_ticket=t.id_ticket AND htt.estado=1 
                ORDER BY htt.fec_reg DESC 
                LIMIT 1) AS col_status,
                (SELECT CONCAT(SUBSTRING(mh.nom_mes,1,3),'-',SUBSTRING(YEAR(htt.fec_reg), -2)) 
                FROM historial_ticket htt 
                LEFT JOIN mes mh ON MONTH(htt.fec_reg)=mh.cod_mes
                WHERE htt.id_ticket=t.id_ticket AND htt.estado=1 
                ORDER BY htt.fec_reg DESC 
                LIMIT 1) AS nom_mes_revisado,
                CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                (SELECT uc.usuario_codigo FROM historial_ticket it
                LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                WHERE it.id_ticket=t.id_ticket AND it.estado=1 
                ORDER BY it.fec_reg DESC
                LIMIT 1) AS cod_terminado_por
                from ticket t         
                LEFT JOIN tipo_ticket tt ON tt.id_tipo_ticket=t.id_tipo_ticket
                LEFT JOIN users u ON u.id_usuario=t.user_reg
                LEFT JOIN empresa e ON e.id_empresa=t.id_empresa
                LEFT JOIN proyecto_soporte ps ON ps.id_proyecto_soporte=t.id_proyecto_soporte
                LEFT JOIN subproyecto_soporte sps ON sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                LEFT JOIN status_general st ON st.id_status_general=t.id_status_ticket
                LEFT JOIN users ue ON ue.id_usuario=t.id_mantenimiento
                LEFT JOIN users uo ON uo.id_usuario=t.id_solicitante
                LEFT JOIN mes m ON MONTH(t.fec_reg)=m.cod_mes
                WHERE t.id_status_ticket $estado
                ORDER BY t.prioridad ASC"; 

        /*if($id_estatus==0){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    st.nom_status,DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial, 
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,             
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    from ticket t         
                    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    left join users u on u.id_usuario=t.user_reg
                    left join empresa e on e.id_empresa=t.id_empresa
                    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    left join status_general st on st.id_status_general=t.id_status_ticket
                    left join users ue on ue.id_usuario=t.id_mantenimiento
                    left join users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    where t.id_status_ticket IN (1,2,12,20,21,22,27,36)
                    order by t.prioridad ASC";
        }elseif($id_estatus==1){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    from ticket t
                    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    left join users u on u.id_usuario=t.user_reg
                    left join empresa e on e.id_empresa=t.id_empresa
                    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    left join status_general st on st.id_status_general=t.id_status_ticket
                    left join users ue on ue.id_usuario=t.id_mantenimiento
                    left join users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    where t.id_status_ticket=1
                    order by t.prioridad"; 
        }elseif($id_estatus==2){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    from ticket t
                    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    left join users u on u.id_usuario=t.user_reg
                    left join empresa e on e.id_empresa=t.id_empresa
                    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    left join status_general st on st.id_status_general=t.id_status_ticket
                    left join users ue on ue.id_usuario=t.id_mantenimiento
                    left join users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    where t.id_status_ticket=2
                    order by t.prioridad"; 
        }elseif($id_estatus==3){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    from ticket t
                    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    left join users u on u.id_usuario=t.user_reg
                    left join empresa e on e.id_empresa=t.id_empresa
                    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    left join status_general st on st.id_status_general=t.id_status_ticket
                    left join users ue on ue.id_usuario=t.id_mantenimiento
                    left join users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    where t.id_status_ticket=21
                    order by t.prioridad"; 
        }elseif($id_estatus==4){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    from ticket t
                    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    left join users u on u.id_usuario=t.user_reg
                    left join empresa e on e.id_empresa=t.id_empresa
                    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    left join status_general st on st.id_status_general=t.id_status_ticket
                    left join users ue on ue.id_usuario=t.id_mantenimiento
                    left join users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    where t.id_status_ticket=22
                    order by t.prioridad"; 
        }elseif($id_estatus==5){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) AS historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,st.color AS col_status,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt 
                    LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket 
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) AS nom_status,
                    (SELECT ss.color FROM historial_ticket htt 
                    LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket 
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad
                    FROM ticket t
                    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    LEFT JOIN users u on u.id_usuario=t.user_reg
                    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
                    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
                    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
                    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    WHERE t.id_status_ticket=23
                    order by t.prioridad"; 
        }elseif($id_estatus==7){
            $parte="";
            if($id_usuario==5){
                $parte="AND t.completado=0";
            }
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,round(t.horas+(round(t.minutos/60,2)),1) as tiempo,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1 ) as col_status,
                    (SELECT concat(SUBSTRING(mh.nom_mes,1,3),'-',SUBSTRING(year(htt.fec_reg), -2)) FROM historial_ticket htt 
                    left join mes mh on month(htt.fec_reg)=mh.cod_mes
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) as nom_mes_revisado,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad
                    from ticket t
                    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    LEFT JOIN users u on u.id_usuario=t.user_reg
                    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
                    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
                    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
                    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    WHERE t.id_status_ticket=34 $parte
                    ORDER BY t.prioridad"; 
        }elseif($id_estatus==8){
            $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,m.nom_mes,year(t.fec_reg) as anio,
                    round(t.horas+(round(t.minutos/60,2)),1) as tiempo,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT ue.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=ue.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT COUNT(*) FROM historial_ticket WHERE id_ticket=t.id_ticket) as historial,
                    ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                    uo.usuario_codigo as cod_soli,'Completado' AS nom_status,st.color AS col_status,
                    (SELECT concat(SUBSTRING(mh.nom_mes,1,3),'-',SUBSTRING(year(htt.fec_reg), -2)) FROM historial_ticket htt 
                    left join mes mh on month(htt.fec_reg)=mh.cod_mes
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) as nom_mes_revisado,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    FROM ticket t 
                    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    LEFT JOIN users u on u.id_usuario=t.user_reg
                    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
                    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
                    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
                    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
                    left join mes m on month(t.fec_reg)=m.cod_mes
                    WHERE t.completado=1 AND t.id_status_ticket!=37
                    ORDER BY t.prioridad"; 
        }else{
            $sql = "SELECT t.id_ticket,t.cod_ticket,t.prioridad,tt.nom_tipo_ticket,e.cod_empresa,ps.proyecto,sps.subproyecto,
                    t.ticket_desc,DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,uo.usuario_codigo,t.horas,t.minutos,
                    (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') FROM historial_ticket WHERE id_ticket=t.id_ticket order by id_historial desc limit 1) as fecha_registro_th,
                    (SELECT uo.usuario_codigo FROM historial_ticket WHERE id_mantenimiento=uo.id_usuario order by id_mantenimiento desc limit 1) as colaborador_codigo,
                    (SELECT ss.nom_status FROM historial_ticket htt 
                    LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket 
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) as nom_status,
                    (SELECT ss.color FROM historial_ticket htt 
                    LEFT JOIN status_general ss on ss.id_status_general=htt.id_status_ticket 
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) as col_status,
                    t.id_status_ticket,t.id_mantenimiento,uo.usuario_codigo AS cod_soli,
                    round(t.horas+(round(t.minutos/60,2)),1) as tiempo,
                    (SELECT concat(SUBSTRING(mh.nom_mes,1,3),'-',SUBSTRING(year(htt.fec_reg), -2)) FROM historial_ticket htt 
                    LEFT JOIN mes mh ON MONTH(htt.fec_reg)=mh.cod_mes
                    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) as nom_mes_revisado,
                    CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,
                    (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket and it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por
                    FROM ticket t
                    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
                    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
                    WHERE id_status_ticket NOT IN (99)
                    ORDER BY t.cod_ticket ASC"; 
        }*/
        //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_ticket($id_ticket){
        if(isset($id_ticket) && $id_ticket > 0){
            $sql = "SELECT t.*,u.usuario_codigo,DATE_FORMAT(t.fec_reg,'%d-%m-%Y') as fecha_registro,
                    e.cod_empresa,p.proyecto,s.subproyecto,i.nom_tipo_ticket,
                    r.usuario_codigo as solicitante,r.emailp as correo_solicitante,
                    u.usuario_codigo as creadopor,(SELECT GROUP_CONCAT(DISTINCT us.usuario_codigo)
                    FROM ticket_follow_up tf
                    LEFT JOIN users us ON tf.id_usuario=us.id_usuario
                    WHERE tf.id_ticket=t.id_ticket) AS follow_up,ma.emailp AS correo_mantenimiento
                    from ticket t
                    LEFT JOIN users u on t.user_reg=u.id_usuario
                    LEFT JOIN empresa e on t.id_empresa=e.id_empresa
                    LEFT JOIN proyecto_soporte p on t.id_proyecto_soporte=p.id_proyecto_soporte
                    LEFT JOIN subproyecto_soporte s on t.id_subproyecto_soporte=s.id_subproyecto_soporte
                    LEFT JOIN tipo_ticket i on t.id_tipo_ticket=i.id_tipo_ticket
                    LEFT JOIN users r on t.id_solicitante=r.id_usuario
                    LEFT JOIN users ma ON t.id_mantenimiento=ma.id_usuario
                    where t.id_ticket =".$id_ticket;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_ticket($dato){ 
        $sql="SELECT * from ticket where id_tipo_ticket='".$dato['id_tipo_ticket']."' and id_empresa='".$dato['id_empresa']."' and id_proyecto_soporte='".$dato['id_proyecto_soporte']."' and id_subproyecto_soporte='".$dato['id_subproyecto_soporte']."' and id_status_ticket in (1,2)";
  
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_status_ticket(){
        $sql = "SELECT * from status_general WHERE id_status_mae=1 AND estado=2 AND id_status_general NOT IN (37,53) 
                ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_status_ticket($dato){
        $sql = "SELECT * from status_general where id_status_general='".$dato['id_status_general']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_ticket(){
        $sql = "SELECT * FROM ticket ORDER BY id_ticket DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_historial_ticket($dato){
        $sql = "SELECT * FROM historial_ticket WHERE id_ticket='".$dato['id_ticket']."' 
                ORDER BY id_historial DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_usuario($id_usuario){
        $sql = "SELECT * from users where id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_status_aprob_ticket(){
        $sql = "SELECT * from status_general where  id_status_mae=1 ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_ticket($anio){
        $sql = "SELECT cod_ticket FROM ticket where YEAR(fec_reg) = '".$anio."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE ticket SET id_tipo_ticket='".$dato['id_tipo_ticket']."',
                id_solicitante='".$dato['id_solicitante']."',id_empresa='".$dato['id_empresa']."',
                id_proyecto_soporte='".$dato['id_proyecto_soporte']."',
                id_subproyecto_soporte='".$dato['id_subproyecto_soporte']."',
                ticket_desc='".addslashes($dato['ticket_desc'])."',ticket_obs='".addslashes($dato['ticket_obs'])."',prioridad='".$dato['prioridad']."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql);
    }

    function get_list_historial_ticket($id_ticket){
        $sql = "SELECT ht.*,sg.nom_status,us.usuario_nombres,us.usuario_apater,us.usuario_codigo,
                ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
                ue.usuario_codigo as colaborador_codigo,sg.color AS col_status,
                DATE_FORMAT(ht.fec_reg,'%d/%m/%Y') as fecha_registro,
                (SELECT ha.id_historial_archivo FROM historial_archivo ha WHERE ha.id_historial=ht.id_historial limit 1) as img1,
                (SELECT ha.id_historial_archivo FROM historial_archivo ha WHERE ha.id_historial=ht.id_historial limit 1,1) as img2,
                (SELECT ha.id_historial_archivo FROM historial_archivo ha WHERE ha.id_historial=ht.id_historial limit 2,1) as img3,
                (SELECT ha.id_historial_archivo FROM historial_archivo ha WHERE ha.id_historial=ht.id_historial limit 3,1) as img4
                FROM historial_ticket ht
                LEFT JOIN ticket ti on ti.id_ticket=ht.id_ticket
                LEFT JOIN status_general sg on sg.id_status_general=ht.id_status_ticket
                LEFT JOIN users us on us.id_usuario=ht.user_asignado
                LEFT JOIN users ue on ue.id_usuario=ht.id_mantenimiento
                WHERE ht.id_ticket=$id_ticket AND ht.estado=1 ORDER BY id_historial DESC";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function horas_terminado_historial($id_ticket){
        $sql = "SELECT horas AS hora_total,minutos as minuto_total,COUNT(0) as cantidad 
                FROM historial_ticket 
                WHERE id_status_ticket=23 AND id_ticket=$id_ticket";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_horas_historial_ticket($id_ticket){
        $sql = "SELECT ht.*,SEC_TO_TIME( SUM( TIME_TO_SEC( ht.horas) ) ) as total_horas,sg.nom_status,us.usuario_nombres,us.usuario_apater,us.usuario_codigo,
        ue.usuario_nombres as colaborador_nombres,ue.usuario_apater as colaborador_apater,
        ue.usuario_codigo as colaborador_codigo,
        DATE_FORMAT(ht.fec_reg,'%d-%m-%Y') as fecha_registro
        FROM historial_ticket ht
        LEFT JOIN ticket ti on ti.id_ticket=ht.id_ticket
        LEFT JOIN status_general sg on sg.id_status_general=ht.id_status_ticket
        LEFT JOIN users us on us.id_usuario=ht.user_asignado
        LEFT JOIN users ue on ue.id_usuario=ht.id_mantenimiento
        WHERE ht.id_ticket=$id_ticket AND ht.estado=1";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_historial_ticket($id_historial){
        $sql = "SELECT ht.*,ti.cod_ticket,DATE_FORMAT(ht.fec_reg,'%d-%m-%Y') as fecha_registro,year(ht.fec_reg) as anio,m.nom_mes
                FROM historial_ticket ht
                LEFT JOIN ticket ti on ti.id_ticket=ht.id_ticket
                left join mes m on month(ht.fec_reg)=m.cod_mes
                WHERE ht.id_historial=$id_historial";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial_archivo($id_historial){ 
        $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo
                FROM historial_archivo 
                WHERE id_historial=$id_historial";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_historial_archivo($id_historial_archivo){
        $sql = "SELECT * FROM historial_archivo WHERE id_historial_archivo=$id_historial_archivo";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_archivo_ticket($id_historial_archivo){
        $sql = "DELETE FROM historial_archivo WHERE id_historial_archivo=$id_historial_archivo";
        $this->db->query($sql);
    }

    function update_historial_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE historial_ticket SET id_status_ticket='".$dato['id_status_ticket']."',
                horas='".$dato['horas']."',minutos='".$dato['minutos']."',
                id_mantenimiento='".$dato['id_mantenimiento']."',ticket_obs='".addslashes($dato['ticket_obs'])."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_historial='".$dato['id_historial']."'";

        $this->db->query($sql);

        if($dato['actualiza']==1){
            $sql2 = "UPDATE ticket SET id_status_ticket='".$dato['id_status_ticket']."'
                    WHERE id_ticket='".$dato['id_ticket']."'";

            $this->db->query($sql2);

            if(($dato['id_status_ticket']==2 || $dato['id_status_ticket']==20 || $dato['id_status_ticket']==23) && ($dato['horas']!="" || $dato['minutos']!="")){
                $sql3 = "UPDATE ticket SET horas='".$dato['horas']."',minutos='".$dato['minutos']."'
                        WHERE id_ticket='".$dato['id_ticket']."'";
    
                $this->db->query($sql3);
            }
        }

        if($dato['cambia_mant']==1){
            $sql4 = "UPDATE ticket SET id_mantenimiento='".$dato['id_mantenimiento']."'
                    WHERE id_ticket='".$dato['id_ticket']."'";

            $this->db->query($sql4);

            $sql5 = "UPDATE historial_ticket SET id_mantenimiento='".$dato['id_mantenimiento']."'
                    WHERE id_ticket='".$dato['id_ticket']."' AND id_mantenimiento!=0";

            $this->db->query($sql5);
        }

        if($dato['horas']>0 || $dato['minutos']>0){
            $sql6 = "UPDATE ticket SET horas='".$dato['horas']."', minutos='".$dato['minutos']."'
                    WHERE id_ticket='".$dato['id_ticket']."'";
            $this->db->query($sql6);
        }
    }

    function delete_historial_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE historial_ticket SET estado=2,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_historial='".$dato['id_historial']."'";

        $this->db->query($sql);

        if($dato['validador']==1){
            $sql = "UPDATE ticket SET id_status_ticket='".$dato['anterior_id_status_ticket']."'
                    WHERE id_ticket='".$dato['id_ticket']."'";

            $this->db->query($sql);
        }
    }

    function insert_completado($dato){
        /*$id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_ticket (id_ticket,user_asignado,id_mantenimiento,
                id_status_ticket,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_ticket']."',$id_usuario,'".$dato['id_mantenimiento']."',53,1,
                NOW(),$id_usuario)";
        $this->db->query($sql);*/
        $sql = "UPDATE ticket SET completado=1 WHERE id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql);
    }

    function insert_cancelado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO historial_ticket (id_ticket,user_asignado,id_mantenimiento,
                id_status_ticket,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_ticket']."',$id_usuario,'".$dato['id_mantenimiento']."',37,1,
                NOW(),$id_usuario)";
        $this->db->query($sql);
        $sql2 = "UPDATE ticket SET id_status_ticket=37 WHERE id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql2);
    }

    function presupuesto_ticket(){
        $sql = "SELECT t.*,tt.nom_tipo_ticket,u.usuario_codigo,e.cod_empresa,ps.proyecto,sps.subproyecto,
                st.nom_status,DATE_FORMAT(t.fec_reg,'%d-%m-%Y') as fecha_registro
                from ticket t
                left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
                left join users u on u.id_usuario=t.user_reg
                left join empresa e on e.id_empresa=t.id_empresa
                left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
                left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                left join status_general st on st.id_status_general=t.id_status_ticket
                where t.id_status_ticket in (2,3,12)
                order by t.id_ticket";

        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_presupuesto_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql ="UPDATE ticket SET id_status_ticket='".$dato['id_status_general']."', 
        user_aprob=".$id_usuario.", fec_aprob=NOW() 
        WHERE  id_ticket='".$dato['id_ticket']."'";
        $this->db->query($sql);
    }

    function get_list_menu_empresa($id_empresa)
    {
        $sql = "SELECT * from menu where id_empresa=$id_empresa and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_busqueda_ticket($dato){
        $sql = "SELECT * from ticket where cod_ticket='".$dato['cod_ticket']."' AND 
        id_tipo_ticket='".$dato['id_tipo_ticket']."' AND id_empresa='".$dato['id_empresa']."' AND
        id_proyecto_soporte='".$dato['id_proyecto_soporte']."' AND 
        id_subproyecto_soporte='".$dato['id_subproyecto_soporte']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_solicitado(){
        $sql = "SELECT COUNT(*) AS total FROM ticket 
                WHERE id_status_ticket=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_presupuesto(){
        $sql = "SELECT COUNT(*) AS total FROM ticket 
                WHERE id_status_ticket=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_tramite(){
        $sql = "SELECT COUNT(0) AS total FROM ticket 
                WHERE id_status_ticket=21";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_pendiente(){
        $sql = "SELECT COUNT(0) AS total FROM ticket 
                WHERE id_status_ticket=22";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_terminado($dato){
        $sql = "SELECT COUNT(0) AS total FROM ticket 
                WHERE id_status_ticket IN (23,34) AND
                MONTH(fec_reg)='".$dato['mes_actual']."' AND YEAR(fec_reg)='".$dato['anio_actual']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function ticket_todo(){
        $sql = "SELECT COUNT(*) AS total FROM ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_horas_x_ticket(){
        $sql = "SELECT ht.*,SEC_TO_TIME( SUM( TIME_TO_SEC( ht.horas) ) ) as total_horas
        FROM historial_ticket ht
        LEFT JOIN ticket ti on ti.id_ticket=ht.id_ticket
        LEFT JOIN status_general sg on sg.id_status_general=ht.id_status_ticket
        WHERE ht.estado=1
        GROUP by ht.id_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function tiempo_total($dato){
        $sql = "SELECT SUM(horas) AS hora_total,SUM(minutos) as minuto_total FROM ticket 
                WHERE id_status_ticket IN (23,34) AND id_tipo_ticket IN (1,3) AND 
                MONTH(fec_reg)='".$dato['mes_actual']."' AND 
                YEAR(fec_reg)='".$dato['anio_actual']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function terminado_new($dato){
        $sql = "SELECT SUM(horas) AS hora_total,SUM(minutos) as minuto_total,COUNT(0) as cantidad 
                FROM ticket 
                WHERE id_status_ticket IN (23,34) AND id_tipo_ticket=1 AND 
                MONTH(fec_reg)='".$dato['mes_actual']."' AND YEAR(fec_reg)='".$dato['anio_actual']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function terminado_bug($dato){
        $sql = "SELECT SUM(horas) AS hora_total,SUM(minutos) as minuto_total,COUNT(0) as cantidad 
                FROM ticket 
                WHERE id_status_ticket IN (23,34) AND id_tipo_ticket=2 AND 
                MONTH(fec_reg)='".$dato['mes_actual']."' AND YEAR(fec_reg)='".$dato['anio_actual']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function terminado_improve($dato){
        $sql = "SELECT SUM(horas) AS hora_total,SUM(minutos) as minuto_total,COUNT(0) as cantidad 
                FROM ticket 
                WHERE id_status_ticket IN (23,34) AND id_tipo_ticket=3 AND 
                MONTH(fec_reg)='".$dato['mes_actual']."' AND YEAR(fec_reg)='".$dato['anio_actual']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_pago($dato){
        $sql = "SELECT COUNT(0) AS total,SUM(ti.horas) AS horas,SUM(ti.minutos) AS minutos FROM ticket ti 
                LEFT JOIN (SELECT MAX(id_historial) AS id_ultimo_historial,id_ticket FROM historial_ticket WHERE estado=1 GROUP BY id_ticket) h ON h.id_ticket=ti.id_ticket 
                LEFT JOIN historial_ticket ht ON ht.id_historial=h.id_ultimo_historial 
                WHERE ti.id_status_ticket=34 AND ti.id_tipo_ticket IN (1,3) AND MONTH(ht.fec_reg)='".$dato['mes_reporte']."' AND YEAR(ht.fec_reg)='".$dato['anio_reporte']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_admin(){
        $sql = "SELECT * FROM users WHERE id_nivel=1 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_mes($id_mes){
        $sql = "SELECT * FROM mes WHERE id_mes=$id_mes";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------------MANTENIMIENTO---------------------------------------
    function get_list_mantenimiento(){
        $sql = "SELECT * FROM users WHERE (id_nivel=9 AND estado=2) OR (id_usuario IN (5,7,35,33)) 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function consulta_usuario(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM hingreso_ultimo WHERE id_usuario='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function insert_historial_ingreso_sistema($dato){ 
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO hingreso (ip, fec_ingreso, id_usuario) 
                values ('".$dato['ip']."','$fecha','$id_usuario')";
        $this->db->query($sql);
    }

    function update_ultimo_ingreso_sistema($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if($dato['var']==1){
            $sql = "UPDATE hingreso_ultimo SET ip ='".$dato['ip']."',
            fec_ingreso='$fecha' where id_usuario='$id_usuario'";
            $this->db->query($sql);
        }else{
            $sql = "INSERT INTO hingreso_ultimo (ip, fec_ingreso, id_usuario) 
            values ('".$dato['ip']."','$fecha','$id_usuario')";
            $this->db->query($sql);
        }
    }

    function delete_festivo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE calendar_festivo SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_calendar_festivo='".$dato['id_calendar_festivo']."'";
         $this->db->query($sql);
         $sql6 = "DELETE FROM calendar_redes where id_secundario='".$dato['id_calendar_festivo']."'
         and tipo_calendar='Festivo'";
         $this->db->query($sql6);

        $sql5 = "DELETE FROM calendar_agenda where id_secundario='".$dato['id_calendar_festivo']."'
                    and tipo_calendar='Festivo'";
        $this->db->query($sql5);
                                   
    }

    function list_informe($dato){
        $sql = "SELECT WEEK(ht.fec_reg),YEAR(ht.fec_reg),WEEK(ht.fec_reg) AS semana,
                YEAR(ht.fec_reg) AS anio,DATE_FORMAT((DATE_ADD(ht.fec_reg, 
                INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') AS primer,
                DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo,
                SUM(CASE WHEN t.id_tipo_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=1 AND ht.estado=1 THEN 1 ELSE 0 END) AS new_solici,
                SUM(CASE WHEN t.id_tipo_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket='23' AND ht.estado=1 THEN 1 ELSE 0 END) AS new_termi,
                SUM(CASE WHEN t.id_tipo_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                t.id_status_ticket='34' AND ht.id_status_ticket='34' AND ht.estado=1 THEN 1 
                ELSE 0 END) AS new_revi,        
                
                SUM(CASE WHEN t.id_tipo_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.horas 
                ELSE 0 END) AS hr_new_ter_rev,         
                SUM(CASE WHEN t.id_tipo_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.minutos 
                ELSE 0 END) AS min_new_ter_rev,
                
                SUM(CASE WHEN t.id_tipo_ticket=2 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=1 AND ht.estado=1 THEN 1 ELSE 0 END) AS bug_solici,
                SUM(CASE WHEN t.id_tipo_ticket=2 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=23 AND ht.estado=1 THEN 1 ELSE 0 END) AS bug_termi,
                SUM(CASE WHEN t.id_tipo_ticket=2 AND t.id_status_ticket=34 AND 
                ht.id_status_ticket=34 AND ht.estado=1 THEN 1 ELSE 0 END) AS bug_revi,        
                SUM(CASE WHEN t.id_tipo_ticket=2 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.horas 
                ELSE 0 END) AS hr_bug_ter_rev,        
                SUM(CASE WHEN t.id_tipo_ticket=2 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.minutos 
                ELSE 0 END) AS min_bug_ter_rev,
                
                SUM(CASE WHEN t.id_tipo_ticket=3 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=1 AND ht.estado=1 THEN 1 ELSE 0 END) AS improve_solici,
                SUM(CASE WHEN t.id_tipo_ticket=3 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=23 AND ht.estado=1 THEN 1 ELSE 0 END) AS improve_termi,
                SUM(CASE WHEN t.id_tipo_ticket=3 AND t.id_status_ticket=34 AND 
                ht.id_status_ticket=34 AND ht.estado=1 THEN 1 ELSE 0 END) AS improve_revi,        
                SUM(CASE WHEN t.id_tipo_ticket=3 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.horas 
                ELSE 0 END) AS hr_improve_ter_rev,        
                SUM(CASE WHEN t.id_tipo_ticket=3 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket in (23,34) AND ht.estado=1 THEN ht.minutos 
                ELSE 0 END) AS min_improve_ter_rev,
                
                SUM(CASE WHEN ht.id_ticket=t.id_ticket AND ht.id_status_ticket=1 AND 
                ht.estado=1 THEN 1 ELSE 0 END) AS total_solicitado,
                SUM(CASE WHEN ht.id_ticket=t.id_ticket AND ht.id_status_ticket=23 AND 
                ht.estado=1 THEN 1 ELSE 0 END) AS total_terminado,
                SUM(CASE WHEN ht.id_ticket=t.id_ticket AND ht.id_status_ticket=34 AND 
                ht.estado=1 THEN 1 ELSE 0 END) AS total_revisado,        
        
                SUM(CASE WHEN ht.id_ticket=t.id_ticket AND ht.id_status_ticket in (23,34) AND 
                ht.estado=1 THEN ht.horas ELSE 0 END) AS hr_total_ter,
                SUM(CASE WHEN ht.id_ticket=t.id_ticket AND ht.id_status_ticket in (23,34) AND 
                ht.estado=1 THEN ht.minutos ELSE 0 END) AS min_total_ter,
                        
                SUM(CASE WHEN t.id_status_ticket=1 AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket=1 AND ht.estado='1' THEN 1 ELSE 0 END) AS t_estado_soli,
                SUM(CASE WHEN t.id_status_ticket='20' AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket='20' AND ht.estado='1' THEN 1 ELSE 0 END) AS t_estado_asig,
                SUM(CASE WHEN t.id_status_ticket='21' AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket='21' AND ht.estado='1' THEN 1 ELSE 0 END) AS t_estado_trami,
                SUM(CASE WHEN t.id_status_ticket='22' AND ht.id_ticket=t.id_ticket AND 
                ht.id_status_ticket='22' AND ht.estado='1' THEN 1 ELSE 0 END) AS t_estado_pendresp,
                CASE WHEN
                (SELECT group_concat(distinct t2.bloqueado)
              	FROM ticket t2
              	WHERE t2.id_status_ticket <> 99 AND YEAR(t2.fec_reg)='".$dato['anio']."' AND 
                week(t2.fec_reg)= week(ht.fec_reg)) THEN 'Bloqueado' ELSE 'Pendiente' END AS estado_semana
                FROM ticket t
                LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket
                WHERE t.id_status_ticket <> 99 AND YEAR(ht.fec_reg)='".$dato['anio']."'
                GROUP BY week(ht.fec_reg),YEAR(ht.fec_reg)
                ORDER BY week(ht.fec_reg) DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function list_informe_hrs(){
        $sql="SELECT MONTH(ht.fec_reg) as mes,YEAR(ht.fec_reg) as anio,
		
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_new_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_new_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_new_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_new_rev,
        
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_bug_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_bug_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_bug_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_bug_rev,
        
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_improve_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_improve_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_improve_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (34) and ht.id_status_ticket in (34) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_improve_rev,
        
        SUM(CASE WHEN t.id_status_ticket=1 and ht.id_status_ticket=1 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_sol,
        SUM(CASE WHEN t.id_status_ticket=1 and ht.id_status_ticket=1 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_sol,
        
        SUM(CASE WHEN t.id_status_ticket=23 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_ter,
        SUM(CASE WHEN t.id_status_ticket=23 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_ter,
        
        SUM(CASE WHEN t.id_status_ticket=34 and ht.id_status_ticket=34 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_rev,
        SUM(CASE WHEN t.id_status_ticket=34 and ht.id_status_ticket=34 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_rev
        
        
        FROM ticket t
        left join historial_ticket ht on ht.id_ticket=t.id_ticket
        WHERE t.id_status_ticket <> 99
        GROUP BY MONTH(ht.fec_reg),YEAR(ht.fec_reg)";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function list_informe_hrs(){
        $sql="SELECT MONTH(ht.fec_reg) as mes,YEAR(ht.fec_reg) as anio,
		
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_new_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_new_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_new_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '1' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_new_rev,
        
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_bug_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_bug_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_bug_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '2' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_bug_rev,
        
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_improve_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (23) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_improve_ter,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_improve_rev,
        SUM(CASE WHEN t.id_tipo_ticket = '3' and t.id_status_ticket in (34) and ht.id_status_ticket in (23) and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_improve_rev,
        
        SUM(CASE WHEN t.id_status_ticket=1 and ht.id_status_ticket=1 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_sol,
        SUM(CASE WHEN t.id_status_ticket=1 and ht.id_status_ticket=1 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_sol,
        
        SUM(CASE WHEN t.id_status_ticket=23 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_ter,
        SUM(CASE WHEN t.id_status_ticket=23 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_ter,
        
        SUM(CASE WHEN t.id_status_ticket=34 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.horas ELSE 0 END) as hr_total_rev,
        SUM(CASE WHEN t.id_status_ticket=34 and ht.id_status_ticket=23 and ht.estado='1' THEN ht.minutos ELSE 0 END) as min_total_rev
        
        
        FROM ticket t
        left join historial_ticket ht on ht.id_ticket=t.id_ticket
        WHERE t.id_status_ticket <> 99
        GROUP BY MONTH(ht.fec_reg),YEAR(ht.fec_reg)";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ticket_revisados($dato){
        $sql = "SELECT t.id_ticket FROM ticket t
                LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket AND ht.estado=1
                WHERE WEEK(ht.fec_reg)='".$dato['semana']."' AND YEAR(ht.fec_reg)='".$dato['anio']."' AND 
                ht.id_status_ticket IN (34) AND t.id_status_ticket <> 99 AND t.bloqueado <> 1
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function bloqueo_ticket($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE ticket SET bloqueado=1,fec_bloqueo=NOW(),user_bloqueo=$id_usuario
                WHERE id_ticket IN ".$dato['cadena']."";
        $this->db->query($sql);
    }

    function list_informe_excel($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, 
        INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and t.id_status_ticket=ht.id_status_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=t.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and t.id_status_ticket IN (1,20,21,22,23,34) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket  
        ORDER BY s.nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_terminados($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (23) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_solicitado($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, 
        INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (1) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_revisado($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.prioridad,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg,  INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo,
        e.cod_empresa,ps.proyecto,sps.subproyecto,DATE_FORMAT(t.fec_reg,'%d/%m/%Y') as fecha_registro,
        uo.usuario_codigo as cod_soli,t.horas,t.minutos
        
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        left join empresa e on t.id_empresa=e.id_empresa
        left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
        left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
        left join users uo on t.id_solicitante=uo.id_usuario
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (34) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_estado_solicitado($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg,  INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and t.id_status_ticket=ht.id_status_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (1) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_estado_asignado($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg,  INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and t.id_status_ticket=ht.id_status_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (20) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_estado_tramite($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg,  INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and t.id_status_ticket=ht.id_status_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (21) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_informe_ticket_estado_prespuesta($semana,$anio){
        
        $sql="SELECT t.id_ticket,t.cod_ticket,tt.nom_tipo_ticket,s.nom_status,week(ht.fec_reg) as semana,YEAR(ht.fec_reg) as anio,t.ticket_desc,ht.horas,DATE_FORMAT(ht.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha_registro,
        DATE_FORMAT((DATE_ADD(ht.fec_reg,  INTERVAL (-WEEKDAY  (ht.fec_reg)) DAY)), '%d/ %b') as primer,
        DATE_FORMAT((DATE_ADD(ht.fec_reg, INTERVAL (6 -WEEKDAY(ht.fec_reg)) DAY)),'%d/ %b') AS ultimo
        FROM ticket t
        LEFT JOIN historial_ticket ht on ht.id_ticket=t.id_ticket and t.id_status_ticket=ht.id_status_ticket and ht.estado='1'
        left JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
        left join status_general s on s.id_status_general=ht.id_status_ticket
        WHERE week(ht.fec_reg)='$semana' and YEAR(ht.fec_reg)='$anio' and ht.id_status_ticket IN (22) AND t.id_status_ticket <> 99
                GROUP BY t.cod_ticket";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_combo_usuario(){
        $sql = "SELECT id_usuario,usuario_codigo FROM users
                WHERE tipo=1 AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_grupo(){
        $sql = "SELECT m.id_modulo_grupo,m.id_menu_mae,m.nom_modulo_grupo,mm.nom_modulo_mae FROM modulo_grupo m 
        left JOIN modulo_mae mm on mm.id_modulo_mae=m.id_menu_mae
        WHERE m.estado=2 and mm.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_subgrupo_xnivel_registrar($id_usuario){
        /*$sql = "SELECT mm.id_modulo_mae,mm.nom_modulo_mae,mg.id_modulo_grupo,mg.nom_modulo_grupo,
                msg.id_modulo_subgrupo,msg.nom_subgrupo,msgn.id_modulo_subgrupo_n 
                FROM modulo_subgrupo msg
                LEFT JOIN modulo_grupo mg on mg.id_modulo_grupo=msg.id_modulo_grupo and mg.estado=2
                LEFT JOIN modulo_mae mm on mm.id_modulo_mae=mg.id_menu_mae and mm.estado=2
                LEFT JOIN modulo_subgrupo_xnivel msgn on msgn.id_modulo_subgrupo=msg.id_modulo_subgrupo and msgn.id_usuario='$id_usuario'";*/
        $sql = "SELECT * FROM modulo_subgrupo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_subgrupo_xnivel($id_usuario){
        $sql = "SELECT mm.id_modulo_mae,mm.nom_modulo_mae,mg.id_modulo_grupo,mg.nom_modulo_grupo,
                msg.id_modulo_subgrupo,msg.nom_subgrupo,msgn.id_modulo_subgrupo_n 
                FROM modulo_subgrupo msg
                LEFT JOIN modulo_grupo mg ON mg.id_modulo_grupo=msg.id_modulo_grupo AND mg.estado=2
                LEFT JOIN modulo_mae mm ON mm.id_modulo_mae=mg.id_menu_mae AND mm.estado=2
                LEFT JOIN modulo_subgrupo_xnivel msgn ON msgn.id_modulo_subgrupo=msg.id_modulo_subgrupo AND msgn.id_usuario='$id_usuario'
                WHERE msg.estado=2 ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_sub_subgrupo_xnivel($id_usuario){
        $sql = "SELECT ms.*,msn.id_modulo_sub_subgrupo_n FROM modulo_sub_subgrupo ms
                LEFT JOIN modulo_sub_subgrupo_xnivel msn ON msn.id_modulo_sub_subgrupo=ms.id_modulo_sub_subgrupo AND msn.id_usuario='$id_usuario' AND msn.estado=2
                WHERE ms.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_nivel($id_nivel){
        $sql = "SELECT * from nivel where estado=1 and id_nivel='$id_nivel'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_mae(){
        $sql = "SELECT * FROM modulo_mae 
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_grupo_xnivel(){
        $sql = "SELECT * FROM modulo_grupo 
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_sub_subgrupo(){
        //$sql = "SELECT * from modulo_sub_subgrupo where estado=2";
        $sql = "SELECT * from modulo_sub_subgrupo where estado=2";
        //$sql = "SELECT id_modulo_sub_subgrupo from modulo_sub_subgrupo ORDER BY id_modulo_sub_subgrupo DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_modulo_sub_subgrupo_registrar(){ 
        $sql = "SELECT * FROM modulo_sub_subgrupo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_nivel_accesos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO modulo_subgrupo_xnivel (id_modulo_subgrupo,id_modulo_grupo,id_usuario,
                estado,fec_reg, user_reg) 
                VALUES ('".$dato['id_modulo_subgrupo']."','".$dato['id_modulo_grupo']."',
                '".$dato['id_usuario']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_nivel_accesos_subsubgrupo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO modulo_sub_subgrupo_xnivel (id_modulo_sub_subgrupo,id_modulo_grupo,id_modulo_subgrupo,
                id_usuario,estado, fec_reg, user_reg) 
                VALUES ('".$dato['id_modulo_sub_subgrupo']."','".$dato['id_modulo_grupo']."',
                '".$dato['id_modulo_subgrupo']."','".$dato['id_usuario']."',2,NOW(),'$id_usuario')";
        $this->db->query($sql);
    }

    function limpiar_nivel_acceso($id_usuario){
        $sql = "DELETE FROM modulo_subgrupo_xnivel 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
        $sql2 = "DELETE FROM modulo_sub_subgrupo_xnivel 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql2);
    }

    function get_id_modulo_subgrupo($dato){
        $sql = "SELECT * from modulo_subgrupo 
                WHERE id_modulo_subgrupo='".$dato['id_modulo_subgrupo']."' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_modulo_subsubgrupo_xsubmodulo($dato){
        $sql = "SELECT * from modulo_sub_subgrupo 
                WHERE id_modulo_subgrupo='".$dato['id_modulo_subgrupo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_sub_subsubgrupo_xsubmodulo($dato){
        $sql = "SELECT * from modulo_sub_subgrupo_xnivel where id_modulo_sub_subgrupo='".$dato['id_modulo_sub_subgrupo']."' and estado=2 and id_nivel='".$dato['id_nivel']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_sub_subsubgrupo($dato){
        $sql = "SELECT * from modulo_sub_subgrupo 
                WHERE id_modulo_sub_subgrupo='".$dato['id_modulo_sub_subgrupo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cant_subsubgrupo_xsubmodulo_nivel($dato){
        $sql = "SELECT * from modulo_sub_subgrupo_xnivel 
                WHERE id_modulo_subgrupo='".$dato['id_modulo_subgrupo']."' AND estado=2 AND id_usuario='".$dato['id_usuario']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado_cargo(){
        $sql = "SELECT * FROM status_general where id_status_mae='7';";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //----------------------------------------------FONDOS DE INTRANET-----------------------------------------
    function get_list_fondo_extranet($id_fondo=null){
        if(isset($id_fondo) && $id_fondo>0){
            $sql = "SELECT * FROM fondo_extranet WHERE id_fondo=$id_fondo";
        }else{
            $sql = "SELECT fo.*,st.nom_status,CASE WHEN fo.imagen='' THEN 'No' ELSE 'Si' END AS v_imagen 
                    FROM fondo_extranet fo
                    LEFT JOIN status st ON st.id_status=fo.estado";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_fondo_extranet(){
        $sql = "SELECT * FROM fondo_extranet WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_fondo_extranet($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO fondo_extranet (titulo,imagen,estado,fec_reg,user_reg) 
                VALUES ('".$dato['titulo']."','".$dato['imagen']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function desactivar_fondo_extranet($dato){
        $sql = "UPDATE fondo_extranet SET imagen='".$dato['imagen_antigua']."',estado=3
                WHERE id_fondo='".$dato['id_fondo_antiguo']."'";
        $this->db->query($sql);
    }

    function update_fondo_extranet($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fondo_extranet SET titulo='".$dato['titulo']."',imagen='".$dato['imagen']."',fec_act=NOW(),
                user_act=$id_usuario 
                WHERE id_fondo='".$dato['id_fondo']."'";
        $this->db->query($sql);
    }

    function reiniciar_estado_fondo_extranet(){
        $sql = "UPDATE fondo_extranet SET estado=3";
        $this->db->query($sql);
    }

    function activar_fondo_extranet($dato){
        $sql = "UPDATE fondo_extranet SET imagen='".$dato['imagen_antigua']."',estado=2
                WHERE id_fondo='".$dato['id_fondo_antiguo']."'";
        $this->db->query($sql); 
    }
    //-----------------------------------------------SOPORTE DOCS------------------------------------------
    function get_list_soporte_doc($id_soporte_doc=null,$tipo=null){
        if(isset($id_soporte_doc) && $id_soporte_doc>0){
            $sql = "SELECT * FROM soporte_doc 
                    WHERE id_soporte_doc=$id_soporte_doc";
        }else{
            if($tipo=="1"){
                $parte = "so.estado=2";
            }else{
                $parte = "so.estado NOT IN (4)";
            }
            $sql = "SELECT so.id_soporte_doc,em.cod_empresa,so.descripcion,SUBSTRING_INDEX(so.documento,'/',-1) AS nom_documento,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(so.documento,'/',-1)) ELSE '' END AS link,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',so.documento) ELSE '' END AS href,us.usuario_codigo,
                    DATE_FORMAT(so.fec_act,'%d-%m-%Y') AS fecha,CASE WHEN so.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    CASE WHEN so.visible=1 THEN 'Si' ELSE 'No' END AS visible,st.nom_status,so.documento
                    FROM soporte_doc so
                    LEFT JOIN empresa em ON em.id_empresa=so.id_empresa
                    LEFT JOIN users us ON us.id_usuario=so.user_act
                    LEFT JOIN status st ON st.id_status=so.estado
                    WHERE $parte
                    ORDER BY em.cod_empresa ASC,so.descripcion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_empresa_combo(){
        $sql = "SELECT id_empresa,cod_empresa FROM empresa 
                WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_id_soporte_doc(){
        $sql = "SELECT id_soporte_doc FROM soporte_doc ORDER BY id_soporte_doc DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_soporte_doc($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO soporte_doc (id_empresa,descripcion,documento,visible,estado,fec_reg,user_reg,fec_act,user_act) 
                VALUES('".$dato['id_empresa']."','".$dato['descripcion']."','".$dato['documento']."',
                '".$dato['visible']."',2,NOW(),$id_usuario,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_soporte_doc($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE soporte_doc SET id_empresa='".$dato['id_empresa']."',descripcion='".$dato['descripcion']."',
                documento='".$dato['documento']."',visible='".$dato['visible']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_soporte_doc='".$dato['id_soporte_doc']."'";
        $this->db->query($sql);
    }

    function delete_soporte_doc($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE soporte_doc SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_soporte_doc='".$dato['id_soporte_doc']."'";
        $this->db->query($sql);
    }

    function delete_archivo_soporte_doc($id_soporte_doc){
        $sql = "UPDATE soporte_doc SET documento='' WHERE id_soporte_doc=$id_soporte_doc";
        $this->db->query($sql);
    }

    function get_list_usuario_cmb_histo_ticket(){
        $sql = "SELECT * FROM users";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_menus_usuario($id_usuario){ 
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

    function get_list_modulo($id_usuario){
        $sql = "SELECT ms.id_modulo_subgrupo,ms.id_modulo_grupo,ms.nom_subgrupo,ms.nom_menu
                FROM modulo_subgrupo ms
                LEFT JOIN modulo_subgrupo_xnivel msgn ON msgn.id_modulo_subgrupo=ms.id_modulo_subgrupo AND ms.estado=2
                WHERE msgn.id_usuario=$id_usuario OR (SELECT COUNT(*) FROM modulo_sub_subgrupo_xnivel mssgn 
                WHERE mssgn.id_usuario=$id_usuario AND mssgn.id_modulo_subgrupo=ms.id_modulo_subgrupo)>0";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_submodulo($id_usuario){
        $sql = "SELECT s.id_modulo_sub_subgrupo_n,ms.nom_subgrupo,m.nom_submenu,m.nom_sub_subgrupo 
                FROM modulo_sub_subgrupo_xnivel s 
                LEFT JOIN modulo_sub_subgrupo m on m.id_modulo_sub_subgrupo=s.id_modulo_sub_subgrupo
                LEFT JOIN modulo_subgrupo ms on ms.id_modulo_subgrupo=s.id_modulo_subgrupo
                WHERE s.id_usuario=$id_usuario";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_submenus_usuario($nivel){
        $sql = "SELECT msg.*,ms.nom_subgrupo,ms.nom_menu,m.nom_sub_subgrupo,m.nom_submenu FROM modulo_sub_subgrupo_xnivel msg 
        LEFT JOIN modulo_sub_subgrupo m on m.id_modulo_sub_subgrupo=msg.id_modulo_sub_subgrupo
        left JOIN modulo_subgrupo ms on ms.id_modulo_subgrupo=msg.id_modulo_subgrupo
        WHERE msg.id_nivel='".$nivel."'";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede(){
        $sql = "SELECT * FROM sede WHERE id_empresa=1 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC";
        $query = $this->db->query($sql)->result_Array();  
        return $query;
    }

    function list_empresa_proyecto(){
        $sql = "SELECT ue.*,em.cod_empresa FROM proyecto_empresa ue
                LEFT JOIN empresa em on em.id_empresa=ue.id_empresa
                WHERE ue.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //RRHH
    //FUNCIONES GENERAL
    function get_list_empresa_rrhh(){
        $sql = "SELECT id_empresa,cod_empresa 
                FROM empresa 
                WHERE estado=2
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede_rrhh($id_empresa){
        $sql = "SELECT id_sede,cod_sede 
                FROM sede 
                WHERE id_empresa=$id_empresa AND estado=2
                ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_combo_tipo_contrato_rrhh($id_sede){
        $sql = "SELECT id,nombre FROM tipo_contrato_rrhh 
                WHERE id_sede=$id_sede AND estado=2
                ORDER BY nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    // contrato
    function get_list_tipo_contrato_rrhh(){
        $sql = "SELECT tc.* ,em.cod_empresa,se.cod_sede,st.nom_status, st.color 
                FROM tipo_contrato_rrhh tc 
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = tc.estado
                WHERE tc.estado NOT IN (4)
                ORDER BY tc.nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tipo_contrato_rrhh($dato){
        $sql = "SELECT * FROM tipo_contrato_rrhh 
                WHERE id_empresa='".$dato['id_empresa']."' AND id_sede='".$dato['id_sede']."' AND 
                codigo='".$dato['codigo']."' AND nombre='".$dato['nombre']."' AND 
                estado='".$dato['id_estado']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo_contrato_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tipo_contrato_rrhh (id_empresa,id_sede,codigo,tipo,subtipo,nombre,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_empresa']."','".$dato['id_sede']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['nombre']."','".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_tipo_contrato_rrhh($id_tipo_contrato_rrhh){
        $sql = "SELECT * FROM tipo_contrato_rrhh WHERE id=$id_tipo_contrato_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_tipo_contrato_rrhh($dato){
        $sql = "SELECT * FROM tipo_contrato_rrhh 
                WHERE id_empresa='".$dato['id_empresa']."' AND id_sede='".$dato['id_sede']."' AND 
                codigo='".$dato['codigo']."' AND nombre='".$dato['nombre']."' AND 
                estado='".$dato['id_estado']."' AND id!='".$dato['id_tipo_contrato']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tipo_contrato_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_contrato_rrhh SET id_empresa='".$dato['id_empresa']."',id_sede='".$dato['id_sede']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                nombre='".$dato['nombre']."',estado='".$dato['id_estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_tipo_contrato']."'";
        $this->db->query($sql);
    }

    // contribuciones
    function get_list_contribucion_rrhh(){
        $sql = "SELECT 
                cn.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede, 
                st.nom_status, 
                st.color, 
                CASE 
                    WHEN cn.tipo_descuento = 1 THEN '%'
                    WHEN cn.tipo_descuento = 2 THEN 'Fijo'
                    ELSE ''
                END AS tipo_descuento_texto,
                CASE 
                    WHEN cn.tipo_contribucion = 1 THEN 'AFP Aporte'
                    WHEN cn.tipo_contribucion = 2 THEN 'Prima de Seguro'
                    WHEN cn.tipo_contribucion = 3 THEN 'AFP Comisión'
                    WHEN cn.tipo_contribucion = 4 THEN 'ESSALUD'
                    ELSE ''
                END AS tipo_contribucion_texto
                FROM 
                    contribucion_rrhh cn
                LEFT JOIN tipo_contrato_rrhh tc ON cn.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = cn.estado
                WHERE cn.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_contribucion_rrhh($dato){
        $parte = "";
        if(isset($dato['id_contribucion']) && $dato['id_contribucion']>0){
            $parte = "AND id!=".$dato['id_contribucion'];
        }
        $sql = "SELECT * FROM contribucion_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND 
                tipo_contribucion='".$dato['tipo_contribucion']."' AND ".$dato['id_estado']."=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_contribucion_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO contribucion_rrhh (id_tipo_contrato,codigo,tipo,subtipo,
                nombre,tipo_contribucion,tipo_descuento,monto,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['nombre']."','".$dato['tipo_contribucion']."',
                '".$dato['tipo_descuento']."','".$dato['monto']."','".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_contribucion_rrhh($id_contribucion_rrhh){
        $sql = "SELECT co.*,tc.id_empresa,tc.id_sede 
                FROM contribucion_rrhh co
                LEFT JOIN tipo_contrato_rrhh tc ON co.id_tipo_contrato=tc.id
                WHERE co.id=$id_contribucion_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_contribucion_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contribucion_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                nombre='".$dato['nombre']."',tipo_contribucion='".$dato['tipo_contribucion']."',
                tipo_descuento='".$dato['tipo_descuento']."',monto='".$dato['monto']."',
                estado='".$dato['id_estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_contribucion']."'";
        $this->db->query($sql);
    }

    // impuesto
    function get_list_impuesto_rrhh(){
        $sql = "SELECT 
                im.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede,
                st.nom_status, 
                st.color
                FROM 
                    impuesto_rrhh im
                LEFT JOIN tipo_contrato_rrhh tc ON im.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = im.estado
                WHERE 
                im.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_impuesto_rrhh($dato){
        $sql = "SELECT * FROM impuesto_rrhh
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                de='".$dato['de']."' AND a='".$dato['a']."' AND 
                porcentaje_impuesto='".$dato['porcentaje_impuesto']."' AND estado='".$dato['id_estado']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_impuesto_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO impuesto_rrhh (id_tipo_contrato,codigo,tipo,subtipo,de,a,porcentaje_impuesto,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['de']."','".$dato['a']."','".$dato['porcentaje_impuesto']."',
                '".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_impuesto_rrhh($id_impuesto_rrhh){
        $sql = "SELECT im.*,tc.id_empresa,tc.id_sede 
                FROM impuesto_rrhh im
                LEFT JOIN tipo_contrato_rrhh tc ON im.id_tipo_contrato=tc.id
                WHERE im.id=$id_impuesto_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function valida_update_impuesto_rrhh($dato){
        $sql = "SELECT * FROM impuesto_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                de='".$dato['de']."' AND a='".$dato['a']."' AND 
                porcentaje_impuesto='".$dato['porcentaje_impuesto']."' AND estado='".$dato['id_estado']."' AND 
                id!='".$dato['id_impuesto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_impuesto_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE impuesto_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',codigo='".$dato['codigo']."',
                tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',de='".$dato['de']."',a='".$dato['a']."',
                porcentaje_impuesto='".$dato['porcentaje_impuesto']."',estado='".$dato['id_estado']."',fec_act=NOW(),
                user_act=$id_usuario 
                WHERE id='".$dato['id_impuesto']."'";
        $this->db->query($sql);
    }

    // asFamiliar
    function get_list_as_familiar_rrhh(){
        $sql = "SELECT 
                af.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede,
                st.nom_status, 
                st.color,
                CASE
                    WHEN af.tipo_descuento = 1 THEN '%'
                    WHEN af.tipo_descuento = 2 THEN 'Fijo'
                END AS tipo_descuento_texto
                FROM 
                    as_familiar_rrhh af
                LEFT JOIN tipo_contrato_rrhh tc ON af.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = af.estado
                WHERE af.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_as_familiar_rrhh($dato){
        $sql = "SELECT * FROM as_familiar_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_descuento='".$dato['tipo_descuento']."' AND monto='".$dato['monto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_as_familiar_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO as_familiar_rrhh (id_tipo_contrato,codigo,tipo,subtipo,nombre,tipo_descuento,monto,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['nombre']."','".$dato['tipo_descuento']."','".$dato['monto']."',
                '".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_as_familiar_rrhh($id_as_familiar_rrhh){
        $sql = "SELECT af.*,tc.id_empresa,tc.id_sede 
                FROM as_familiar_rrhh af
                LEFT JOIN tipo_contrato_rrhh tc ON af.id_tipo_contrato=tc.id
                WHERE af.id=$id_as_familiar_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_as_familiar_rrhh($dato){
        $sql = "SELECT * FROM as_familiar_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_descuento='".$dato['tipo_descuento']."' AND monto='".$dato['monto']."' AND 
                id!='".$dato['id_as_familiar']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_as_familiar_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE as_familiar_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                nombre='".$dato['nombre']."',tipo_descuento='".$dato['tipo_descuento']."',monto='".$dato['monto']."',
                estado='".$dato['id_estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_as_familiar']."'";
        $this->db->query($sql);
    }

    // bono
    function get_list_bono_rrhh(){
        $sql = "SELECT 
                bn.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede,
                st.nom_status, 
                st.color,
                CASE
                    WHEN bn.tipo_bono = 1 THEN 'Alimentar'
                    WHEN bn.tipo_bono = 2 THEN 'Movilidad'
                END AS tipo_bono_texto,
                CASE
                    WHEN bn.tipo_descuento = 1 THEN '%'
                    WHEN bn.tipo_descuento = 2 THEN 'Fijo'
                END AS tipo_descuento_texto
                FROM 
                    bono_rrhh bn
                LEFT JOIN tipo_contrato_rrhh tc ON bn.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = bn.estado
                WHERE 
                bn.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_bono_rrhh($dato){
        $sql = "SELECT * FROM bono_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_descuento='".$dato['tipo_descuento']."' AND tipo_bono='".$dato['tipo_bono']."' AND 
                monto='".$dato['monto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_bono_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO bono_rrhh (id_tipo_contrato,codigo,tipo,subtipo,nombre,tipo_bono,tipo_descuento,
                monto,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['nombre']."','".$dato['tipo_bono']."','".$dato['tipo_descuento']."',
                '".$dato['monto']."','".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_bono_rrhh($id_bono_rrhh){
        $sql = "SELECT bo.*,tc.id_empresa,tc.id_sede FROM bono_rrhh bo
                LEFT JOIN tipo_contrato_rrhh tc ON bo.id_tipo_contrato=tc.id        
                WHERE bo.id=$id_bono_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_bono_rrhh($dato){
        $sql = "SELECT * FROM bono_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_descuento='".$dato['tipo_descuento']."' AND 
                tipo_bono='".$dato['tipo_bono']."' AND monto='".$dato['monto']."' AND 
                id!='".$dato['id_bono']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_bono_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE bono_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                nombre='".$dato['nombre']."',tipo_bono='".$dato['tipo_bono']."',
                tipo_descuento='".$dato['tipo_descuento']."',monto='".$dato['monto']."',
                estado='".$dato['id_estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_bono']."'";
        $this->db->query($sql);
    }

    // tardanza
    function get_list_tardanza_rrhh(){
        $sql = "SELECT 
                ta.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede,
                st.nom_status, 
                st.color,
                CASE
                    WHEN ta.tipo_tardanza = 1 THEN 'Retraso'
                    WHEN ta.tipo_tardanza = 2 THEN 'Tardanza'
                END AS tipo_tardanza_texto
                FROM 
                    tardanza_rrhh ta
                LEFT JOIN tipo_contrato_rrhh tc ON ta.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = ta.estado
                WHERE 
                ta.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tardanza_rrhh($dato){
        $sql = "SELECT * FROM tardanza_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                tipo_tardanza='".$dato['tipo_tardanza']."' AND monto='".$dato['monto']."' AND 
                estado='".$dato['id_estado']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tardanza_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tardanza_rrhh (id_tipo_contrato,codigo,tipo,subtipo,tipo_tardanza,monto,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['tipo_tardanza']."','".$dato['monto']."','".$dato['id_estado']."',
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_tardanza_rrhh($id_tardanza_rrhh){
        $sql = "SELECT ta.*,tc.id_empresa,tc.id_sede 
                FROM tardanza_rrhh ta
                LEFT JOIN tipo_contrato_rrhh tc ON ta.id_tipo_contrato=tc.id        
                WHERE ta.id=$id_tardanza_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_tardanza_rrhh($dato){
        $sql = "SELECT * FROM tardanza_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                tipo_tardanza='".$dato['tipo_tardanza']."' AND monto='".$dato['monto']."' AND 
                estado='".$dato['id_estado']."' AND id!='".$dato['id_tardanza']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tardanza_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tardanza_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                tipo_tardanza='".$dato['tipo_tardanza']."',monto='".$dato['monto']."',estado='".$dato['id_estado']."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_tardanza']."'";
        $this->db->query($sql);
    }

    // faltas
    function get_list_falta_rrhh(){
        $sql = "SELECT 
                cn.*,tc.nombre AS nom_tipo_contrato,em.cod_empresa,se.cod_sede, 
                st.nom_status, 
                st.color, 
                CASE 
                    WHEN cn.tipo_descuento = 1 THEN '%'
                    WHEN cn.tipo_descuento = 2 THEN 'Fijo'
                END AS tipo_descuento_texto,
                CASE 
                    WHEN cn.tipo_falta = 1 THEN 'Onp'
                    WHEN cn.tipo_falta = 2 THEN 'Afp'
                    WHEN cn.tipo_falta = 3 THEN 'Essalud'
                END AS tipo_falta_texto
                FROM 
                    falta_rrhh cn
                LEFT JOIN tipo_contrato_rrhh tc ON cn.id_tipo_contrato=tc.id
                LEFT JOIN empresa em ON tc.id_empresa=em.id_empresa
                LEFT JOIN sede se ON tc.id_sede=se.id_sede
                LEFT JOIN status st ON st.id_status = cn.estado
                WHERE cn.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_falta_rrhh($dato){
        $sql = "SELECT * FROM falta_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_falta='".$dato['tipo_falta']."' AND tipo_descuento='".$dato['tipo_descuento']."' AND 
                monto='".$dato['monto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_falta_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO falta_rrhh (id_tipo_contrato,codigo,tipo,subtipo,nombre,tipo_falta,tipo_descuento,
                monto,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo_contrato']."','".$dato['codigo']."','".$dato['tipo']."',
                '".$dato['subtipo']."','".$dato['nombre']."','".$dato['tipo_falta']."','".$dato['tipo_descuento']."',
                '".$dato['monto']."','".$dato['id_estado']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_falta_rrhh($id_falta_rrhh){
        $sql = "SELECT fa.*,tc.id_empresa,tc.id_sede 
                FROM falta_rrhh fa
                LEFT JOIN tipo_contrato_rrhh tc ON fa.id_tipo_contrato=tc.id                
                WHERE fa.id=$id_falta_rrhh";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_falta_rrhh($dato){
        $sql = "SELECT * FROM falta_rrhh 
                WHERE id_tipo_contrato='".$dato['id_tipo_contrato']."' AND codigo='".$dato['codigo']."' AND 
                nombre='".$dato['nombre']."' AND estado='".$dato['id_estado']."' AND 
                tipo_falta='".$dato['tipo_falta']."' AND tipo_descuento='".$dato['tipo_descuento']."' AND 
                monto='".$dato['monto']."' AND id!='".$dato['id_falta']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_falta_rrhh($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE falta_rrhh SET id_tipo_contrato='".$dato['id_tipo_contrato']."',
                codigo='".$dato['codigo']."',tipo='".$dato['tipo']."',subtipo='".$dato['subtipo']."',
                nombre='".$dato['nombre']."',tipo_falta='".$dato['tipo_falta']."',
                tipo_descuento='".$dato['tipo_descuento']."',monto='".$dato['monto']."',
                estado='".$dato['id_estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id='".$dato['id_falta']."'";
        $this->db->query($sql);
    }

    //-----------------------------------------------SEMANAS------------------------------------------
    function get_list_semanas($id_semanas=null){
        if(isset($id_semanas) && $id_semanas>0){
            $sql = "SELECT * FROM semanas WHERE id_semanas=$id_semanas";
        }else{
            $sql = "SELECT *
                    FROM semanas
                    WHERE estado!=4";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_semana($dato){
        $v="";
        if($dato['id_semanas']!=""){
            $v=" and id_semanas!='".$dato['id_semanas']."'";
        }
        $sql = "SELECT * FROM semanas WHERE anio='".$dato['anio']."' and nom_semana='".$dato['nom_semana']."'
        and estado=1 $v";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_semana($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO semanas (anio,nom_semana,fec_inicio,fec_fin,estado,fec_reg,user_reg) 
                VALUES ('".$dato['anio']."','".$dato['nom_semana']."','".$dato['fec_inicio']."',
                '".$dato['fec_fin']."',1,NOW(),$id_usuario)";
        $this->db->query($sql);

    }

    function update_semana($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE semanas set anio='".$dato['anio']."',nom_semana='".$dato['nom_semana']."',
        fec_inicio='".$dato['fec_inicio']."',fec_fin='".$dato['fec_fin']."',fec_act=NOW(),user_actu=$id_usuario
        where id_semanas='".$dato['id_semanas']."'";
        $this->db->query($sql);
    }

    function delete_semana($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE semanas set estado='4',fec_eli=NOW(),user_eli=$id_usuario where id_semanas='".$dato['id_semanas']."'";
        $this->db->query($sql);
    }

    function get_list_semanas_modulo($id_semanas=null,$t){
        $anio=date('Y');
        if(isset($id_semanas) && $id_semanas>0){
            $sql = "SELECT * FROM semanas WHERE id_semanas=$id_semanas";
        }else{
            if($t==1){
                $sql = "SELECT * FROM semanas WHERE estado!=4 and anio=YEAR(NOW())";
            }else{
                $sql = "SELECT * FROM semanas WHERE estado!=4";
            }
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-------------------------------------TIPO COMERCIAL--------------------------------------------------
    function get_list_tipo_comercial($id_informe=null){
        if(isset($id_informe) && $id_informe>0){
            $sql = "SELECT * FROM informe 
                    WHERE id_informe=$id_informe";
        }else{
            $sql = "SELECT i.*,st.nom_status 
                    FROM informe i
                    LEFT JOIN status st ON st.id_status=i.estado
                    WHERE i.estado NOT IN (4,5)
                    ORDER BY i.nom_informe ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function valida_tipo_comercial($dato){
        $condicion = "";
        if($dato['id_informe']!=""){
            $condicion = "AND id_informe!='".$dato['id_informe']."'";
        }
        $sql = "SELECT id_informe FROM informe 
                WHERE nom_informe='".$dato['nom_informe']."' AND estado=2 $condicion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo_comercial($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO informe (nom_informe,estado,fec_reg,user_reg) 
                VALUES ('".$dato['nom_informe']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_tipo_comercial($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE informe SET nom_informe='".$dato['nom_informe']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_informe='".$dato['id_informe']."'";
        $this->db->query($sql);
    }

    function delete_tipo_comercial($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE informe SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_informe='".$dato['id_informe']."'";
        $this->db->query($sql);
    }
    //------------------------------------------PRODUCTO INTERESE-----------------------------------
    function get_list_producto_interes($id_producto_interes=null){
        if(isset($id_producto_interes) && $id_producto_interes>0){
            $sql = "SELECT * FROM producto_interes
                    WHERE id_producto_interes=$id_producto_interes";
        }else{
            $sql = "SELECT pn.*,em.cod_empresa,se.cod_sede,
                    DATE_FORMAT(pn.fecha_inicio,'%d/%m/%Y') as fec_inicio,
                    DATE_FORMAT(pn.fecha_fin,'%d/%m/%Y') as fec_fin,
                    CASE WHEN pn.total=1 THEN 'Si' ELSE 'No' END AS totales,
                    CASE WHEN pn.formulario=1 THEN 'Si' ELSE 'No' END AS formularios,
                    es.nom_status,es.orden
                    FROM producto_interes pn
                    LEFT JOIN empresa em on em.id_empresa=pn.id_empresa
                    LEFT JOIN sede se on se.id_sede=pn.id_sede
                    LEFT JOIN status es on es.id_status=pn.estado
                    where pn.id_producto_interes NOT IN (62,63) AND pn.estado NOT IN (4)
                    ORDER BY em.cod_empresa ASC,se.cod_sede ASC,pn.nom_producto_interes ASC,es.orden ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_producto_interes(){
        $sql = "SELECT id_empresa,cod_empresa 
                FROM empresa
                WHERE estado=2
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_sede_producto_interes($id_empresa){
        $sql = "SELECT id_sede,cod_sede 
                FROM sede
                WHERE id_empresa=$id_empresa AND estado=2
                ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_producto_interes($dato){
        $condicion = "";
        if($dato['id_producto_interes']!=""){
            $condicion = "AND id_producto_interes!='".$dato['id_producto_interes']."'";
        }
        $sql = "SELECT id_producto_interes FROM producto_interes 
                WHERE id_empresa='".$dato['id_empresa']."' AND total='".$dato['total']."' AND estado=2 
                $condicion";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_producto_interes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_interes (id_empresa,id_sede,nom_producto_interes,orden_producto_interes,
                fecha_inicio,fecha_fin,total,formulario,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_empresa']."','".$dato['id_sede']."','".$dato['nom_producto_interes']."',
                '".$dato['orden_producto_interes']."','".$dato['fecha_inicio']."','".$dato['fecha_fin']."',
                '".$dato['total']."','".$dato['formulario']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    
    function update_producto_interes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_interes SET id_empresa='".$dato['id_empresa']."',id_sede='".$dato['id_sede']."',
                nom_producto_interes='".$dato['nom_producto_interes']."',
                orden_producto_interes='".$dato['orden_producto_interes']."',
                fecha_inicio='".$dato['fecha_inicio']."',fecha_fin='".$dato['fecha_fin']."',
                total='".$dato['total']."',formulario='".$dato['formulario']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_producto_interes='".$dato['id_producto_interes']."'";
        $this->db->query($sql);
    }
    
    function delete_producto_interes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_interes SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_producto_interes='".$dato['id_producto_interes']."'";
        $this->db->query($sql);
    }
    //------------------------------------------SMS Automatizado-----------------------------------
    function get_list_sms_automatizado($id_sms=null){
        if(isset($id_sms) && $id_sms>0){
            $sql = "SELECT * FROM sms_automatizado
                    WHERE id_sms=$id_sms";
        }else{
            $sql = "SELECT sa.id_sms,em.cod_empresa,se.cod_sede,CASE WHEN sa.tipo=1 THEN 'Aniversario'
                    WHEN sa.tipo=2 THEN 'EFSRT' ELSE '' END AS nom_tipo,CASE WHEN sa.unitario=1 THEN 'Si'
                    ELSE 'No' END AS unitario,sa.motivo,sa.descripcion,sa.regularidad,st.nom_status
                    FROM sms_automatizado sa
                    LEFT JOIN empresa em on em.id_empresa=sa.id_empresa
                    LEFT JOIN sede se on se.id_sede=sa.id_sede
                    LEFT JOIN status st on st.id_status=sa.estado
                    WHERE sa.estado NOT IN (4)
                    ORDER BY em.cod_empresa ASC,se.cod_sede ASC,sa.tipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_sms_automatizado(){
        $sql = "SELECT id_empresa,cod_empresa 
                FROM empresa
                WHERE estado=2
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_sede_sms_automatizado($id_empresa){
        $sql = "SELECT id_sede,cod_sede 
                FROM sede
                WHERE id_empresa=$id_empresa AND estado=2
                ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_sms_automatizado($dato){
        $sql = "SELECT id_sms FROM sms_automatizado
                WHERE id_empresa='".$dato['id_empresa']."' AND tipo=1 AND ".$dato['estado']."=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_sms_automatizado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO sms_automatizado (id_empresa,id_sede,tipo,unitario,
                motivo,descripcion,regularidad,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_empresa']."','".$dato['id_sede']."','".$dato['tipo']."',
                '".$dato['unitario']."','".$dato['motivo']."','".$dato['descripcion']."',
                '".$dato['regularidad']."','".$dato['estado']."',NOW(),$id_usuario)";
        $this->db->query($sql); 
    }

    function valida_update_sms_automatizado($dato){
        $sql = "SELECT id_sms FROM sms_automatizado
                WHERE id_empresa='".$dato['id_empresa']."' AND tipo=1 AND ".$dato['estado']."=2 AND
                id_sms!='".$dato['id_sms']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function update_sms_automatizado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE sms_automatizado SET id_empresa='".$dato['id_empresa']."',
                id_sede='".$dato['id_sede']."',tipo='".$dato['tipo']."',unitario='".$dato['unitario']."',
                motivo='".$dato['motivo']."',descripcion='".$dato['descripcion']."',
                regularidad='".$dato['regularidad']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_sms='".$dato['id_sms']."'";
        $this->db->query($sql);
    }
    
    function delete_sms_automatizado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE sms_automatizado SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_sms='".$dato['id_sms']."'";
        $this->db->query($sql);
    }

    function list_tkt_all($dato){
        /*$var ='';
        if($dato['anio']=){

        }*/
        $sql = "SELECT t.id_ticket,t.cod_ticket,
                CASE WHEN t.prioridad=100 THEN '' ELSE t.prioridad END AS v_prioridad,tt.nom_tipo_ticket,e.cod_empresa,ps.proyecto,sps.subproyecto,t.ticket_desc,
                DATE_FORMAT(t.fec_reg,'%d/%m/%Y') AS fecha_registro,uo.usuario_codigo AS cod_soli,
                (SELECT DATE_FORMAT(fec_reg,'%d/%m/%Y') 
                    FROM historial_ticket 
                    WHERE id_ticket=t.id_ticket ORDER BY id_historial DESC limit 1) AS fecha_registro_th,
                (SELECT uc.usuario_codigo FROM historial_ticket it
                    LEFT JOIN users uc ON uc.id_usuario=it.id_mantenimiento 
                    WHERE it.id_ticket=t.id_ticket AND it.estado=1 ORDER BY it.fec_reg DESC LIMIT 1) AS cod_terminado_por,
                t.horas,t.minutos,st.nom_status,
                (SELECT ss.color 
                    FROM historial_ticket htt 
                    LEFT JOIN status_general ss ON ss.id_status_general=htt.id_status_ticket 
                    WHERE htt.id_ticket=t.id_ticket AND htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) AS col_status,
                (SELECT CONCAT(SUBSTRING(mh.nom_mes,1,3),'-',SUBSTRING(YEAR(htt.fec_reg), -2)) 
                    FROM historial_ticket htt 
                    LEFT JOIN mes mh ON MONTH(htt.fec_reg)=mh.cod_mes
                    WHERE htt.id_ticket=t.id_ticket AND htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) AS nom_mes_revisado
                from ticket t         
                LEFT JOIN tipo_ticket tt ON tt.id_tipo_ticket=t.id_tipo_ticket
                LEFT JOIN users u ON u.id_usuario=t.user_reg
                LEFT JOIN empresa e ON e.id_empresa=t.id_empresa
                LEFT JOIN proyecto_soporte ps ON ps.id_proyecto_soporte=t.id_proyecto_soporte
                LEFT JOIN subproyecto_soporte sps ON sps.id_subproyecto_soporte=t.id_subproyecto_soporte
                LEFT JOIN status_general st ON st.id_status_general=t.id_status_ticket
                LEFT JOIN users ue ON ue.id_usuario=t.id_mantenimiento
                LEFT JOIN users uo ON uo.id_usuario=t.id_solicitante
                LEFT JOIN mes m ON MONTH(t.fec_reg)=m.cod_mes
                WHERE year(t.fec_reg)='".$dato['anio']."'
                ORDER BY t.prioridad ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
}
}

