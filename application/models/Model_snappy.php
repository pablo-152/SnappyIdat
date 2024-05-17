<?php
class Model_snappy extends CI_Model { 
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }

    function get_alerta_cargo(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT COUNT(*) AS cantidad FROM cargo c
                WHERE c.id_usuario_1=$id_usuario AND (SELECT ch.id_estado FROM cargo_historial ch
                WHERE ch.id_cargo=c.id_cargo AND ch.estado=2 
                ORDER BY ch.id_cargo_historial DESC LIMIT 1) IN (43,45,46)"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_alerta_cierre_caja(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT COUNT(*) AS cantidad FROM cierre_caja 
                WHERE id_vendedor=$id_usuario AND cerrada=0 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "select * from status ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_festivo(){
        $sql = "select * from tipo_fecha where estado=2 ORDER BY nom_tipo_fecha ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nivel($id_nivel=null){
        if(isset($id_nivel) && $id_nivel > 0){
            $sql = "select * from nivel where estado=1 and id_nivel =".$id_nivel."
                    order by nom_nivel ASC";
        }
        else
        {
            $sql = "select * from nivel where estado=1 order by nom_nivel ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_color_tipo_festivo($id_tipo_fecha){
        $sql = "select * from tipo_fecha where id_tipo_fecha=$id_tipo_fecha and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function ultimoreg(){
        $sql = "select id_calendar_festivo from calendar_festivo order by(id_calendar_festivo) desc limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function ultimoregRedes(){
        $sql = "select id_calendar_redes from calendar_redes order by(id_calendar_redes) desc limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_camb_clave($id_user){
        if(isset($id_user) && $id_user > 0){
            $sql = "select u.*, n.nom_nivel from users u left join nivel n on n.id_nivel=u.id_nivel
            where id_usuario=".$id_user;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_clave($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE users SET usuario_password='".$dato['user_password_hash']."',
                password_desencriptado='" . $dato['usuario_password'] . "',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_usuario =".$dato['id_usuario']."";
        $this->db->query($sql);
    }

    function get_confg_foto(){
        $sql = "select * from fintranet";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_confg_fondo(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=100";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_fondo_snappy(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_agenda(){ 
        $anio=date('Y');
        $sql = "SELECT ca.id_calendar_agenda,ca.cod_proyecto,ca.descripcion,ca.inicio,ca.fin,ca.color,
                pr.id_proyecto
                FROM calendar_agenda ca
                LEFT JOIN proyecto pr ON pr.cod_proyecto=ca.cod_proyecto
                WHERE ca.anio=$anio and ca.estado=2 ORDER BY ca.cod_proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_agenda(){
        $sql = "SELECT ue.id_proyecto, case when id_tipo ='15' then concat('FB',' (',em.cod_empresa,') ') 
                when id_tipo ='20' then concat('IS',' (',em.cod_empresa,') ') else em.cod_empresa end as cod_empresa 
                FROM proyecto_empresa ue
                LEFT JOIN empresa em on em.id_empresa=ue.id_empresa
                left join proyecto pr on ue.id_proyecto=pr.id_proyecto
                WHERE ue.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function anios_calendar_redes(){
        $sql = "SELECT group_concat(distinct YEAR(inicio)) as anio FROM calendar_redes where length(YEAR(inicio))=4; ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_redes(){
        $anio_anterior = date('Y')-1;
        $anio_actual = date('Y');
        $sql = "SELECT c.id_calendar_redes, c.cod_proyecto, c.descripcion, c.inicio, c.fin, c.color,c.cod_proyecto,c.snappy_redes,c.inicio, 
                p.status,substring(s.nom_subtipo,1,3) as subtipo, s.nom_subtipo, t.nom_tipo, u.usuario_codigo,c.id_secundario,
                stp.nom_statusp, c.subido,p.id_proyecto,p.imagen,c.duplicado,em.cod_empresa,p.copy
                from calendar_redes c
                LEFT JOIN proyecto p on p.cod_proyecto=c.cod_proyecto
                LEFT JOIN tipo t on t.id_tipo=p.id_tipo
                LEFT JOIN subtipo s on s.id_subtipo=p.id_subtipo
                LEFT JOIN users u on u.id_usuario=p.id_asignado
                LEFT JOIN statusp stp on stp.id_statusp=p.status
                LEFT JOIN empresa em on em.id_empresa=p.id_empresa
                WHERE YEAR(c.inicio) IN ($anio_anterior,$anio_actual) AND c.estado <>1  and p.status<>8 and p.status<>9  
                ORDER BY c.cod_proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_redes_in($dato){
        $anio_anterior = date('Y')-1;
        $anio_actual = date('Y');
        $sql = "SELECT c.id_calendar_redes,c.cod_proyecto,c.descripcion,c.inicio,c.fin,c.color,
                    c.snappy_redes,
                    p.status,substring(s.nom_subtipo,1,3) as subtipo,s.nom_subtipo,t.nom_tipo, 
                    u.usuario_codigo,stp.nom_statusp, c.subido,p.id_proyecto,p.imagen,c.duplicado,em.cod_empresa,p.copy
                    FROM calendar_redes c
                    LEFT JOIN proyecto p on p.cod_proyecto=c.cod_proyecto
                    LEFT JOIN tipo t on t.id_tipo=p.id_tipo
                    LEFT JOIN subtipo s on s.id_subtipo=p.id_subtipo
                    LEFT JOIN users u on u.id_usuario=p.id_asignado
                    LEFT JOIN statusp stp on stp.id_statusp=p.status
                    left join empresa em on em.id_empresa=p.id_empresa
                    WHERE YEAR(c.inicio) IN ($anio_anterior,$anio_actual) AND p.id_empresa in ".$dato['cadena']." and c.estado <>1 and p.status<>8 and p.status<>9  
                    ORDER BY c.cod_proyecto";     
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_redes_duplicados(){
        $sql="SELECT cod_proyecto, COUNT(*) Contador FROM calendar_redes WHERE duplicado=1 and estado=2 GROUP BY cod_proyecto HAVING COUNT(*) > 0;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_redes_empresa($dato){
        //$anio=date('Y');
        if($dato['id_empresa'] != "" && $dato['id_empresa'] !=0){
            $var1="AND p.id_empresa='".$dato['id_empresa']."'";
        }else{
            $var1="";
        }
        if($dato['id_redes'] == "15"){
            $var2=" and p.id_tipo='".$dato['id_redes']."'";
        }
        elseif($dato['id_redes'] == "20"){
            $var2=" and p.id_tipo='".$dato['id_redes']."'";

        }elseif($dato['id_redes'] == "22"){
                $var2=" and p.id_tipo='".$dato['id_redes']."'";
        }else{
            $var2="";
        }
        if($dato['id_redes'] == "15"){
            $var3=" and c.id_tipo='".$dato['id_redes']."'";
        }
        elseif($dato['id_redes'] == "20"){
            $var3=" and c.id_tipo='".$dato['id_redes']."'";
        }
        elseif($dato['id_redes'] == "22"){
            $var3=" and c.id_tipo='".$dato['id_redes']."'";
        }else{
            $var3="";
        }
        if($dato['id_empresa']==0 and $dato['id_redes']==0){

            $sql = "SELECT c.id_calendar_redes, c.cod_proyecto, c.descripcion, c.inicio, c.fin, c.color,
                    c.snappy_redes,p.status,substring(s.nom_subtipo,1,3) as subtipo,CASE WHEN c.id_tipo>0 THEN tc.nom_tipo 
                    ELSE t.nom_tipo END AS nom_tipo,CASE WHEN c.id_subtipo>0 THEN sc.nom_subtipo ELSE s.nom_subtipo END AS nom_subtipo,
                    u.usuario_codigo, stp.nom_statusp, c.subido,p.id_proyecto,p.imagen,c.duplicado,p.copy,
                    case when p.id_tipo ='15'  or c.id_tipo ='15' then concat('FB',' (',em.cod_empresa,') ') 
                    when p.id_tipo ='20'  or c.id_tipo ='20' then concat('IS',' (',em.cod_empresa,') ') else concat('(',em.cod_empresa,') ') end as cod_empresa
                    from calendar_redes c
                    left join proyecto p on p.cod_proyecto=c.cod_proyecto
                    left join tipo t on t.id_tipo=p.id_tipo
                    left join subtipo s on s.id_subtipo=p.id_subtipo 
                    left join users u on u.id_usuario=p.id_asignado
                    left join statusp stp on stp.id_statusp=p.status
                    left join empresa em on em.id_empresa=p.id_empresa
                    LEFT JOIN tipo tc ON tc.id_tipo=c.id_tipo
                    LEFT JOIN subtipo sc ON sc.id_subtipo=c.id_subtipo
                    where YEAR(c.inicio) in ".'('.$dato['anio'][0]['anio'].')'." ".$dato['cadena']." and c.estado = 2 and p.status<>8 and p.status<>9 and 
                    p.id_tipo in ('15','20','22')
                    order by c.cod_proyecto";
        }else{
            $sql = "SELECT c.id_calendar_redes,c.cod_proyecto,c.descripcion,c.inicio,c.fin,c.color,
                    c.snappy_redes,p.status,substring(s.nom_subtipo,1,3) as subtipo,CASE WHEN c.id_tipo>0 THEN tc.nom_tipo 
                    ELSE t.nom_tipo END AS nom_tipo,CASE WHEN c.id_subtipo>0 THEN sc.nom_subtipo ELSE s.nom_subtipo END AS nom_subtipo,
                    u.usuario_codigo,stp.nom_statusp, c.subido,p.id_proyecto,p.imagen,c.duplicado,p.copy,
                    case when c.id_tipo ='15' or p.id_tipo ='15' then concat('FB',' (',em.cod_empresa,') ') 
                    when c.id_tipo ='20' or p.id_tipo ='20' then concat('IS',' (',em.cod_empresa,') ') else concat('(',em.cod_empresa,') ') end as cod_empresa
                    FROM calendar_redes c
                    LEFT JOIN proyecto p on p.cod_proyecto=c.cod_proyecto
                    LEFT JOIN tipo t on t.id_tipo=p.id_tipo
                    LEFT JOIN subtipo s on s.id_subtipo=p.id_subtipo
                    LEFT JOIN users u on u.id_usuario=p.id_asignado
                    LEFT JOIN statusp stp on stp.id_statusp=p.status
                    left join empresa em on em.id_empresa=p.id_empresa
                    LEFT JOIN tipo tc ON tc.id_tipo=c.id_tipo
                    LEFT JOIN subtipo sc ON sc.id_subtipo=c.id_subtipo
                    WHERE YEAR(c.inicio) in ".'('.$dato['anio'][0]['anio'].')'." $var1 $var2  and duplicado='0' and c.estado = 2 and p.status<>8 and p.status<>9  
                    UNION
                    (SELECT c.id_calendar_redes,c.cod_proyecto,c.descripcion,c.inicio,c.fin,c.color,
                    c.snappy_redes,p.status,substring(s.nom_subtipo,1,3) as subtipo,CASE WHEN c.id_tipo>0 THEN tc.nom_tipo 
                    ELSE t.nom_tipo END AS nom_tipo,CASE WHEN c.id_subtipo>0 THEN sc.nom_subtipo ELSE s.nom_subtipo END AS nom_subtipo,
                    u.usuario_codigo,stp.nom_statusp, c.subido,p.id_proyecto,p.imagen,c.duplicado,p.copy,
                    case when c.id_tipo ='15' then concat('FB',' (',em.cod_empresa,') ') 
                    when c.id_tipo ='20' then concat('IS',' (',em.cod_empresa,') ') else concat('(',em.cod_empresa,') ') end as cod_empresa
                    FROM calendar_redes c
                    LEFT JOIN proyecto p on p.cod_proyecto=c.cod_proyecto
                    LEFT JOIN tipo t on t.id_tipo=p.id_tipo
                    LEFT JOIN subtipo s on s.id_subtipo=p.id_subtipo
                    LEFT JOIN users u on u.id_usuario=p.id_asignado
                    LEFT JOIN statusp stp on stp.id_statusp=p.status
                    left join empresa em on em.id_empresa=p.id_empresa
                    LEFT JOIN tipo tc ON tc.id_tipo=c.id_tipo
                    LEFT JOIN subtipo sc ON sc.id_subtipo=c.id_subtipo
                    WHERE YEAR(c.inicio) in ".'('.$dato['anio'][0]['anio'].')'." $var1 $var3  and duplicado='1' and c.estado = 2 and p.status<>8 and p.status<>9  
                    ORDER BY c.cod_proyecto)";
        }

        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function buscar_proyecto($cod_proyecto){ 
        $sql = "SELECT id_proyecto FROM proyecto 
                WHERE cod_proyecto='$cod_proyecto'
                ORDER BY id_proyecto DESC 
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_temporal_redes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="INSERT INTO temporal_redes (id_usuario,cod_proyecto,copy) 
              VALUES ($id_usuario,'".$dato['v_cod_proyecto']."','".$dato['v_copy']."')";
        $this->db->query($sql);
    }

    function get_list_temporal_redes(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_redes 
                WHERE id_usuario=".$id_usuario;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_temporal_redes_correcto(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_redes 
                WHERE cod_proyecto=0 AND copy=0 AND id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_proyecto_copy($dato){
        $sql = "UPDATE proyecto SET copy='".$dato['copy']."'
                WHERE id_proyecto='".$dato['id_proyecto']."'";
        $this->db->query($sql);
    }

    function delete_temporal_proyecto(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_redes 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
    }
    //-----------------------------------------------------------------------------------------------------------
    function get_list_empresa_config(){
        $sql = "select se.*, s.nom_status, CASE WHEN rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte from empresa se
                left join status s on se.estado=s.id_status";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_empresa_config($id_empresa){
        if(isset($id_empresa) && $id_empresa > 0){
            $sql = "select * from empresa where id_empresa =".$id_empresa;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_empresa_config($dato){
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $path = $_FILES['logo_bn']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo1 = 'logo_bn';
        $config['upload_path'] = './template/img/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "blanco".$fecha."_".rand(1,200).".".$ext;

        $ruta = "template/img/".$config['file_name'];

        $config['allowed_types'] = "png|jpg|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo1)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data(); 
 
        ///////////////////////////////////////////////////////////////////////////
        $path2 = $_FILES['logo_color']['name'];
        $ext2 = pathinfo($path2, PATHINFO_EXTENSION);

        $mi_archivo2 = 'logo_color';
        $config2['upload_path'] = './template/img/';/// ruta del fileserver para almacenar el documento
        $config2['file_name'] = "color".$fecha."_".rand(1,200).".".$ext2;

        $ruta2 = "template/img/".$config2['file_name'];

        $config2['allowed_types'] = "png|jpg|pdf";
        $config2['max_size'] = "0";
        $config2['max_width'] = "0";
        $config2['max_height'] = "0";
        $this->load->library('upload', $config2);
        if (!$this->upload2->do_upload($mi_archivo2)) {
            $data2['uploadError'] = $this->upload2->display_errors();
        }       
        $data2['uploadSuccess'] = $this->upload2->data(); 

        $sql = "insert into empresa (
                rep_redes, 
                nom_empresa,
                cod_empresa,
                orden_empresa,
                observaciones_empresa,
                logo_color,  
                logo_bn, 
                estado, 
                fec_reg, 
                user_reg) 
                        values (
                        '". $dato['rep_redes']."',
                        '". $dato['nom_empresa']."',
                        '". $dato['cod_empresa']."',
                        '". $dato['orden_empresa']."',
                        '". $dato['observaciones_empresa']."',
                        '".$ruta2."', 
                        '".$ruta."',
                        '". $dato['id_status']."',
                        NOW(),".$id_usuario.")";
        //echo($sql);
        $this->db->query($sql);
       
    }

    function update_empresa_config($dato){

       $fecha=date('Y-m-d');
       $id_usuario= $_SESSION['usuario'][0]['id_usuario'];


       $path = $_FILES['logo_color']['name'];
       //echo($path);
       $ext = pathinfo($path, PATHINFO_EXTENSION);

       $mi_archivo = 'logo_color';
       $config['upload_path'] = './uploads/logo_color/';/// ruta del fileserver para almacenar el documento
       $config['file_name'] = "fs".$fecha."_".rand(1,200).".".$ext;

       $ruta = "uploads/logo_color/".$config['file_name'];

       $config['allowed_types'] = "png|jpg|pdf";
       $config['max_size'] = "0";
       $config['max_width'] = "0";
       $config['max_height'] = "0";
       $this->load->library('upload', $config);
       if (!$this->upload->do_upload($mi_archivo)) {
           $data['uploadError'] = $this->upload->display_errors();
       }       
       $data['uploadSuccess'] = $this->upload->data();

        //////////////////////////////////////////////////////////////////////////////////
    
       $path = $_FILES['logo_bn']['name'];
       $ext = pathinfo($path, PATHINFO_EXTENSION);

       $mi_archivo1 = 'logo_bn';
       $config['upload_path'] = './uploads/logo_blanco_negro/';/// ruta del fileserver para almacenar el documento
       $config['file_name'] = "blanco".$fecha."_".rand(1,200).".".$ext;

       $ruta = "uploads/logo_blanco_negro/".$config['file_name'];

       $config['allowed_types'] = "png|jpg|pdf";
       $config['max_size'] = "0";
       $config['max_width'] = "0";
       $config['max_height'] = "0";
       $this->load->library('upload', $config);
       if (!$this->upload->do_upload($mi_archivo1)) {
           $data['uploadError'] = $this->upload->display_errors();
       }       
       $data['uploadSuccess'] = $this->upload->data();

       if (strlen($path)>0){
      /* $sql1 = "update fintranet set estado=2";
       $this->db->query($sql1);*/
        $sql= "UPDATE empresa SET nom_empresa ='". $dato['nom_empresa']."',
                        '". $dato['rep_redes']."',
                        '". $dato['cod_empresa']."',
                        '". $dato['orden_empresa']."',
                        '". $dato['observaciones_empresa']."',
                        logo_color='".$ruta."',
                        logo_bn='".$ruta."',
                        '". $dato['id_status']."',
        fec_act=NOW(),
        user_act='".$id_usuario."' WHERE id_empresa = '".$dato['id_empresa']."'"; 
       }
       else{
            $sql= "UPDATE empresa SET nom_empresa ='".$dato['nom_empresa']."',
                        '". $dato['rep_redes']."',
                        '". $dato['cod_empresa']."',
                        '". $dato['orden_empresa']."',
                        '". $dato['observaciones_empresa']."',

                        '". $dato['id_status']."',


            fec_act=NOW(),
            user_act='".$id_usuario."' WHERE id_empresa = '".$dato['id_empresa']."'"; 
       }
       //echo($sql);     
       
       $this->db->query($sql);

    }

    function get_list_usuario_config(){
        $sql = "select u.*, n.nom_nivel, s.nom_status, h.fec_ingreso from users u 
        left join nivel n on u.id_nivel=n.id_nivel
        left join status s on u.estado=s.id_status
        left join (select * from hingreso order by fec_ingreso desc) h on h.id_usuario=u.id_usuario
        where u.id_nivel!=6
        group by u.id_usuario";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_usuario_config($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="insert into users (
            id_nivel,
            SP,
            GL,
            EP,
            usuario_apater,
            usuario_amater,
            usuario_nombres,
            emailp,
            usuario_email,
            num_celp,
            codigo_gllg,
            ini_funciones,
            fin_funciones,
            estado,
            usuario_codigo,
            usuario_password,
            artes,
            redes,
            observaciones,
            fec_reg, user_reg) 
        values (
        '". $dato['id_nivel']."',
        '". $dato['SP']."',
        '". $dato['GL']."',
        '". $dato['EP']."',
        '". $dato['usuario_apater']."',
        '". $dato['usuario_amater']."',
        '". $dato['usuario_nombres']."',
        '". $dato['emailp']."',
        '". $dato['emailp']."', 
        '". $dato['num_celp']."', 
        '". $dato['codigo_gllg']."', 
        '". $dato['ini_funciones']."',
        '". $dato['fin_funciones']."',
        '". $dato['id_status']."', 
        '". $dato['usuario_codigo']."', 
        '". $dato['usuario_password']."',
        '". $dato['artes']."', 
        '". $dato['redes']."', 
        '". $dato['observaciones']."',       
        '".$fecha."',".$id_usuario.")";

        $this->db->query($sql);
    }

    function update_usuario_config($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="update users set id_nivel='". $dato['id_nivel']."',
        SP='". $dato['SP']."',
        GL='". $dato['GL']."',
        EP='". $dato['EP']."',
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
        usuario_password='". $dato['usuario_password']."',
        artes='". $dato['artes']."',
        redes='". $dato['redes']."',
        observaciones='". $dato['observaciones']."',
        estado='". $dato['id_status']."', 
        fec_act='".$fecha."',
        user_act=".$id_usuario."  where id_usuario='". $dato['id_usuario']."'";

        $this->db->query($sql);
    }

    function get_id_usuario_config($id_usuario){
        
            $sql = "select * from users where id_usuario =".$id_usuario;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------------------------------------------------------------------
    function get_list_empresa(){
        $sql = "select se.*, s.nom_status, CASE WHEN rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte from empresa se
                left join status s on se.estado=s.id_status";
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

    function insert_empresa($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "insert into empresa (rep_redes, 
        nom_empresa,
        cod_empresa,
        orden_empresa,
        observaciones_empresa,
        color1_empresa,
        color2_empresa, 
        estado, 
        fec_reg, 
        user_reg) 
                values ('". $dato['rep_redes']."',
                '". $dato['nom_empresa']."',
                '". $dato['cod_empresa']."',
                '". $dato['orden_empresa']."',
                '". $dato['observaciones_empresa']."',
                '". $dato['color1_empresa']."',
                '". $dato['color2_empresa']."', 
                '". $dato['id_status']."',
                 '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }

    function update_empresa($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "update empresa set rep_redes='". $dato['rep_redes']."', nom_empresa='". $dato['nom_empresa']."', 
                cod_empresa='". $dato['cod_empresa']."', orden_empresa='". $dato['orden_empresa']."', 
                observaciones_empresa='". $dato['observaciones_empresa']."', color1_empresa='". $dato['color1_empresa']."', 
                color2_empresa='". $dato['color2_empresa']."', estado='". $dato['id_status']."', fec_act='".$fecha."', 
                user_act=".$id_usuario." where id_empresa='". $dato['id_empresa']."'";
        $this->db->query($sql);
    }

    function get_list_festivo($tipo){
        if($tipo==1){
            $parte = "WHERE se.estado=2";
        }else{
            $parte = "WHERE se.estado NOT IN (4)";
        }
        $sql = "SELECT se.*,s.nom_status,s.color,tf.nom_tipo_fecha,
        DATE_FORMAT(se.inicio, '%d-%m-%Y') AS fecha,
        CASE
            se.fijo_variable
            WHEN 1 THEN 'Fijo'
            WHEN 2 THEN 'Variable'
            ELSE ''
        END AS f_v,
        em.cod_empresa, se.clases, se.laborable
        FROM
        calendar_festivo se
        LEFT JOIN tipo_fecha tf on se.id_tipo_fecha = tf.id_tipo_fecha
        LEFT JOIN status s on se.estado = s.id_status
        LEFT JOIN empresa em on se.id_empresa = em.id_empresa $parte
        ORDER BY se.inicio ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_festivo($id_calendar_festivo){
        if(isset($id_calendar_festivo) && $id_calendar_festivo > 0){
            $sql = "SELECT id_calendar_festivo, id_empresa,descripcion, inicio, anio, id_tipo_fecha,
                    fijo_variable,observaciones, estado, DATE_FORMAT(inicio,'%Y-%m-%d') as fecha,
                    clases, laborable 
                    FROM calendar_festivo 
                    WHERE id_calendar_festivo = ".$id_calendar_festivo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_festivo($dato,$calendar){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $sql = "INSERT INTO calendar_festivo (id_empresa,descripcion,inicio,fin,anio,mes,nom_mes,dia,nom_dia,color,id_tipo_fecha, 
                observaciones,fijo_variable,estado,fec_reg,user_reg, clases, laborable)
                VALUES ('".$dato['id_empresa']."', '".$dato['descripcion']."','".$dato['inicio']."',
                '".$dato['fin']."', '".$dato['anio']."', '".$dato['mes']."', '".$dato['nom_mes']."',
                '".$dato['dia']."', '".$dato['nom_dia']."', '".$dato['color']."',
                '".$dato['id_tipo_fecha']."', '". $dato['observaciones']."',
                '".$dato['fijo_variable']."', '".$dato['id_status']."',NOW(),$id_usuario,'".$dato['clases']."','".$dato['laborable']."')";
        $sql1 = "INSERT INTO calendar_agenda (id_secundario,tipo_calendar,descripcion, inicio, fin, anio, mes, nom_mes, dia, nom_dia, color, id_tipo_fecha, 
                observaciones, estado, fec_reg, user_reg)
                values ('". $dato['id_ultimo']."','Festivo','". $dato['descripcion']."','". $dato['inicio']."','". $dato['fin']."','". $dato['anio']."', '". $dato['mes']."', 
                '". $dato['nom_mes']."','". $dato['dia']."','". $dato['nom_dia']."', '". $dato['color']."','". $dato['id_tipo_fecha']."',
                '". $dato['observaciones']."', '". $dato['id_status']."',NOW(),".$id_usuario.")";        

        $sql2 = "INSERT INTO calendar_redes (id_secundario,tipo_calendar,descripcion, inicio, fin, anio, mes, nom_mes, dia, nom_dia, color, id_tipo_fecha, 
                observaciones, estado, fec_reg, user_reg)
                values ('". $dato['id_ultimo']."','Festivo','". $dato['descripcion']."','". $dato['inicio']."','". $dato['fin']."','". $dato['anio']."', '". $dato['mes']."', 
                '". $dato['nom_mes']."','". $dato['dia']."','". $dato['nom_dia']."', '". $dato['color']."','". $dato['id_tipo_fecha']."',
                '". $dato['observaciones']."', '". $dato['id_status']."',NOW(),".$id_usuario.")";
        
        if($calendar==1){
            $this->db->query($sql1);
            $this->db->query($sql2);
        }else{
            $this->db->query($sql);
        }
    }

    function update_festivo($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $sql = "UPDATE calendar_festivo SET descripcion='". $dato['descripcion']."', 
                inicio='". $dato['inicio']."', fin='". $dato['fin']."', anio='". $dato['anio']."',
                mes='". $dato['mes']."', dia='". $dato['dia']."', nom_dia='". $dato['nom_dia']."', 
                nom_mes='". $dato['nom_mes']."', id_tipo_fecha='". $dato['id_tipo_fecha']."', 
                observaciones='". $dato['observaciones']."', clases='". $dato['clases']."',
                fijo_variable='". $dato['fijo_variable']."',estado='". $dato['id_status']."', 
                color='". $dato['color']."', laborable='". $dato['laborable']."', fec_act='".$fecha."',
                user_act=".$id_usuario."  
                WHERE id_calendar_festivo='". $dato['id_calendar_festivo']."'";
        $this->db->query($sql);

        $sql1="UPDATE calendar_agenda set descripcion='". $dato['descripcion']."', inicio='". $dato['inicio']."', fin='". $dato['fin']."',
        anio='". $dato['anio']."', mes='". $dato['mes']."', dia='". $dato['dia']."', nom_dia='". $dato['nom_dia']."', 
        nom_mes='". $dato['nom_mes']."', id_tipo_fecha='". $dato['id_tipo_fecha']."', observaciones='". $dato['observaciones']."',
        estado='". $dato['id_status']."', color='". $dato['color']."', fec_act='".$fecha."', user_act=".$id_usuario."  
        WHERE  id_secundario='". $dato['id_calendar_festivo']."' and tipo_calendar='Festivo' ";
        $this->db->query($sql1);

        $sql2="UPDATE calendar_redes set descripcion='". $dato['descripcion']."', inicio='". $dato['inicio']."', fin='". $dato['fin']."',
        anio='". $dato['anio']."', mes='". $dato['mes']."', dia='". $dato['dia']."', nom_dia='". $dato['nom_dia']."', 
        nom_mes='". $dato['nom_mes']."', id_tipo_fecha='". $dato['id_tipo_fecha']."', observaciones='". $dato['observaciones']."',
        estado='". $dato['id_status']."', color='". $dato['color']."', fec_act='".$fecha."', user_act=".$id_usuario."  
        WHERE id_secundario='". $dato['id_calendar_festivo']."' and tipo_calendar='Festivo' ";
        $this->db->query($sql2);
    }

    function get_list_tipos(){
        $sql = "SELECT se.*,s.nom_status FROM tipo se
                LEFT JOIN status s on se.estado=s.id_status";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_tipo($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into tipo (nom_tipo, abr_tipo, estado, fec_reg, user_reg) 
        values ('". $dato['nom_tipo']."', '". $dato['abr_tipo']."','". $dato['id_status']."', 
        '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }
    
    function update_tipo($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql = "update tipo set nom_tipo='". $dato['nom_tipo']."', estado='". $dato['id_status']."', 
                abr_tipo='". $dato['abr_tipo']."', fec_act='".$fecha."', user_act=".$id_usuario."
                where id_tipo='". $dato['id_tipo']."'";
        $this->db->query($sql);
    }
    
    function get_id_tipo($id_tipo){
        if(isset($id_tipo) && $id_tipo > 0){
            $sql = "select * from tipo where id_tipo =".$id_tipo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_subtipo(){
        $sql = "SELECT se.*, s.nom_status, t.nom_tipo, CASE WHEN se.rep_redes=1 THEN 'Si' ELSE 'No' END AS
                reporte, e.cod_empresa
                FROM subtipo se
                left join tipo t on se.id_tipo=t.id_tipo
                left join empresa e on e.id_empresa=se.id_empresa
                left join status s on se.estado=s.id_status
                ORDER BY t.nom_tipo ASC,se.nom_subtipo ASC,e.cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_subtipo($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql = "insert into subtipo (rep_redes, id_tipo, nom_subtipo, tipo_subtipo_arte, tipo_subtipo_redes,
                estado, fec_reg, user_reg, id_empresa) 
                values ('". $dato['rep_redes']."','". $dato['id_tipo']."','". $dato['nom_subtipo']."',
                '". $dato['tipo_subtipo_arte']."','". $dato['tipo_subtipo_redes']."', 
                '". $dato['id_status']."', '".$fecha."',".$id_usuario.", '". $dato['id_empresa']."')";
    
        $this->db->query($sql);
    }

    function update_subtipo($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update subtipo set rep_redes='". $dato['rep_redes']."',
        id_subtipo='". $dato['id_subtipo']."',
        id_tipo='". $dato['id_tipo']."',
        nom_subtipo='". $dato['nom_subtipo']."',
        tipo_subtipo_arte='". $dato['tipo_subtipo_arte']."',
        tipo_subtipo_redes='". $dato['tipo_subtipo_redes']."',
        estado='". $dato['id_status']."',
        id_empresa='". $dato['id_empresa']."',
        fec_act='".$fecha."',
        user_act=".$id_usuario."  where id_subtipo='". $dato['id_subtipo']."'";

        $this->db->query($sql);
    }

    function get_id_subtipo($id_subtipo){
        if(isset($id_subtipo) && $id_subtipo > 0){
            $sql = "select * from subtipo where id_subtipo =".$id_subtipo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario(){
        $sql = "select u.*, n.nom_nivel, s.nom_status, h.fec_ingreso from users u 
        left join nivel n on u.id_nivel=n.id_nivel
        left join status s on u.estado=s.id_status
        left join (select * from hingreso order by fec_ingreso desc) h on h.id_usuario=u.id_usuario
        where u.id_nivel!=6 and u.estado=2
        group by u.id_usuario";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_usuario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into users (
            id_nivel,
            usuario_apater,
            usuario_amater,
            usuario_nombres,
            emailp,
            usuario_email,
            num_celp,
            codigo_gllg,
            ini_funciones,
            fin_funciones,
            estado,
            usuario_codigo,
            usuario_password,
            artes,
            redes,
            observaciones,
            fec_reg, user_reg) 
        values (
        '". $dato['id_nivel']."',
        '". $dato['usuario_apater']."',
        '". $dato['usuario_amater']."',
        '". $dato['usuario_nombres']."',
        '". $dato['emailp']."',
        '". $dato['emailp']."', 
        '". $dato['num_celp']."', 
        '". $dato['codigo_gllg']."', 
        '". $dato['ini_funciones']."',
        '". $dato['fin_funciones']."',
        '". $dato['id_status']."', 
        '". $dato['usuario_codigo']."', 
        '". $dato['usuario_password']."',
        '". $dato['artes']."', 
        '". $dato['redes']."', 
        '". $dato['observaciones']."',       
        '".$fecha."',".$id_usuario.")";
    
        $this->db->query($sql);
    }

    function update_usuario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
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
        usuario_password='". $dato['usuario_password']."',
        artes='". $dato['artes']."',
        redes='". $dato['redes']."',
        observaciones='". $dato['observaciones']."',
        estado='". $dato['id_status']."', 
        fec_act='".$fecha."',
        user_act=".$id_usuario."  where id_usuario='". $dato['id_usuario']."'";

        $this->db->query($sql);
    }


    function get_id_usuario($id_usuario){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from users where id_usuario =".$id_usuario;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_intranet($id_intranet){
        if(isset($id_intranet) && $id_intranet > 0){
            $sql = "select * from fintranet where id_fintranet =".$id_intranet;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*function insert_foto($dato){
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['productImage']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'productImage';
        $config['upload_path'] = 'C:/xampp/htdocs/new_snappy/fotos/';/// ruta del fileserver para almacenar el documento
        $config['file_name'] = "fs".$fecha."_".rand(1,12).".".$ext;

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

        $sql = "insert into fintranet (nom_fintranet, foto, estado, fec_reg, user_reg) 
                values ('". $dato['nom_fintranet']."','".$ruta."', '1', NOW(),".$id_usuario.")";
        $this->db->query($sql);
    }*/

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

        $sql1 = "update fintranet set estado=2";
        $this->db->query($sql1);

        $sql = "insert into fintranet (nom_fintranet, foto, estado, fec_reg, user_reg) 
                values ('". $dato['nom_fintranet']."','".$ruta."', '1', NOW(),".$id_usuario.")";
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
       /* $sql1 = "update fintranet set estado=2";
        $this->db->query($sql1);*/
         $sql= "UPDATE fintranet SET nom_fintranet ='".$dato['nom_fintranet']."',foto='".$ruta."', fec_act=NOW(), user_act='".$id_usuario."' WHERE id_fintranet = '".$dato['id_fintranet']."'"; 
        }
        else{
             $sql= "UPDATE fintranet SET nom_fintranet ='".$dato['nom_fintranet']."', fec_act=NOW(), user_act='".$id_usuario."' WHERE id_fintranet = '".$dato['id_fintranet']."'"; 
        }
        //echo($sql);     
        
        $this->db->query($sql);

    }

     function eliminar_foto($data){
        if ($data['estado']==1){
            $sql = "update fintranet set estado ='".$data['estado']."',fec_act= NOW(),user_act='".$data['user_act']."'  where id_fintranet =".$data['id_fintranet'] ;
        }else{
            $sql = "update fintranet set estado ='".$data['estado']."',fec_eli=NOW(),user_eli='".$data['user_act']."'  where id_fintranet =".$data['id_fintranet'] ;
        }

        $this->db->query($sql); 
    }

    function get_list_proyecto(){
        //,6
        $sql = "SELECT p.*,sp.nom_statusp,sp.color,t.nom_tipo,st.nom_subtipo,u.usuario_nombres AS nombre_solicitado, 
                u.usuario_codigo AS ucodigo_solicitado,ua.usuario_nombres AS nombre_asignado,ua.usuario_codigo AS ucodigo_asignado,
                em.cod_empresa
                FROM proyecto p
                LEFT JOIN statusp sp ON p.status=sp.id_statusp
                LEFT JOIN tipo t ON p.id_tipo=t.id_tipo
                LEFT JOIN subtipo st ON p.id_subtipo=st.id_subtipo
                LEFT JOIN users u ON u.id_usuario=p.id_solicitante
                LEFT JOIN users ua ON ua.id_usuario=p.id_asignado
                LEFT JOIN empresa em ON em.id_empresa=p.id_empresa
                WHERE p.status IN (5) ORDER BY p.cod_proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_cod_proyecto($cod_proyecto){
        $sql = "SELECT * FROM proyecto WHERE cod_proyecto='$cod_proyecto'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio_busqueda($cod_proyecto){
        $sql = "SELECT * FROM anio WHERE cod_proyecto='$cod_proyecto'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_proyecto_busqueda($dato){
        $anio = substr($dato['anio'],-2);
        $sql = "CALL lista_proyecto ('$anio','".$dato['id_empresa']."')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function excel_list_proyecto_busqueda(){
        $sql = "SELECT * FROM list_proyectos
                ORDER BY anio DESC,prioridad ASC, cod_proyecto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_iempresa($id_nivel=NULL){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if(isset($id_nivel) && $id_nivel > 0){
            $sql = "SELECT e.* from usuario_empresa ue
                    LEFT JOIN empresa e on e.id_empresa=ue.id_empresa
                    where e.rep_redes=1 and ue.estado=2 and ue.id_usuario=$id_usuario
                    ORDER BY cod_empresa ASC";
        }
        else{
            $sql = "SELECT * from empresa where rep_redes=1 ORDER BY cod_empresa ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_meses(){
        $sql = "SELECT * from mes ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function archivar_proyect($data){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE proyecto set status='7', fec_act=NOW(), user_act='$id_usuario' where id_proyecto='".$data['id_proyecto']."'";
       //echo $sql;
        $this->db->query($sql);
    }

    function get_busqueda_proyecto($busqueda){
        $buscar="where p.cod_proyecto like '$busqueda%' and p.status in (5,6) order by p.cod_proyecto";

        $sql="select p.*, sp.nom_statusp, sp.color, t.nom_tipo, st.nom_subtipo, u.usuario_nombres as nombre_solicitado, 
u.usuario_codigo as ucodigo_solicitado, ua.usuario_nombres as nombre_asignado, ua.usuario_codigo as ucodigo_asignado from proyecto p
left join statusp sp on p.status=sp.id_statusp
left join tipo t on p.id_tipo=t.id_tipo
left join subtipo st on p.id_subtipo=st.id_subtipo
left join users u on u.id_usuario=p.id_solicitante
left join users ua on ua.id_usuario=p.id_asignado $buscar";
        $query = $this->db->query($sql)->result_Array();
        return $query;

    }

     function get_row_p(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "select u.*, n.nom_nivel from users u
left join nivel n on n.id_nivel=u.id_nivel where id_usuario ='$id_usuario'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function actualizar_img($dato){
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['foto']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'foto';
        $config['upload_path'] = './fotos/';/// ruta del fileserver para almacenar el documento
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $config['file_name'] = "fs".$fecha."_".rand(1,200).".".$ext;

        

        $ruta = "fotos/".$config['file_name'];

        $config['allowed_types'] = "png|jpg|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $sql= "update users set foto='".$ruta."', fec_act= NOW(), user_act='".$id_usuario."' where id_usuario =".$dato['id_usuario']."";

     //echo $sql;
        $this->db->query($sql);
    }

    function get_row_t($dato){
        $sql = "SELECT  COUNT( * ) as total, id_tipo, id_subtipo, nom_tipo , nom_subtipo FROM 
                (SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo, t.nom_tipo
                FROM subtipo s
                LEFT JOIN tipo t ON t.id_tipo = s.id_tipo
                where s.rep_redes=1 AND s.id_empresa=".$dato['id_empresa']."
                ORDER BY t.nom_tipo, s.nom_subtipo)
                AS tmp_table GROUP BY id_tipo ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_subtipos_redes($dato){
        $sql = "SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo
                FROM subtipo s WHERE s.id_tipo=".$dato['id_tipo']." AND 
                id_subtipo NOT IN (".$dato['id_subtipo'].") AND s.id_empresa=".$dato['id_empresa']." AND rep_redes=1
                ORDER BY s.nom_subtipo";

        $query = $this->db->query($sql)->result_Array();

        return $query; 
    }

    function primera_sentencia($id_empresa,$dia,$id_subtipop){
        $sql = "SELECT c.snappy_redes FROM 
        calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
        WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                pr.id_subtipo=$id_subtipop AND pr.status NOT IN (8,9) AND c.estado <>1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function segunda_sentencia($id_empresa,$dia,$id_subtipop){
        $sql = "SELECT c.snappy_redes FROM 
        calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
        WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                pr.id_subtipo=$id_subtipop  AND pr.status IN (5,6,7)AND c.estado <>1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_redes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        /*$sql= "update proyecto set subido='".$dato['subido']."', fec_subido= NOW(), user_subido='".$id_usuario."' where cod_proyecto =".$dato['cod_proyecto']."";*/
        $sql= "update calendar_redes set subido='".$dato['subido']."', fec_subido= NOW(), user_subido='".$id_usuario."' where cod_proyecto ='".$dato['cod_proyecto']."' and inicio='".$dato['inicio']."' and snappy_redes='".$dato['snappy_redes']."'";
        //echo $sql;
        $this->db->query($sql);
    }

    function update_calendar_redes($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "update calendar_redes set inicio='".$dato['inicio']."', fin='".$dato['inicio']."', anio='".$dato['anio']."',
                mes='".$dato['mes']."', dia='".$dato['dia']."', nom_mes='".$dato['nom_mes']."', nom_dia='".$dato['nom_dia']."',
                fec_act= NOW(), user_act='".$id_usuario."' 
                where id_calendar_redes =".$dato['id_calendar']."";
        $this->db->query($sql);

        $sql2 = "update proyecto set fec_agenda='".$dato['inicio']."',
                fec_act= NOW(), user_act='".$id_usuario."' 
                where cod_proyecto =".$dato['cod_proyecto']."";
        $this->db->query($sql2);
    }

    function ultimo_registro_mail($id_registro){
        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];

        $sql = "SELECT * from historial_registro_mail where id_registro ='$id_registro' and estado in (10,11,13,14,15,16,17,18,19) order by id_historial desc limit 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_registro_sede(){
        $sql = "SELECT rm.*,se.cod_sede FROM registro_mail_sede rm
                LEFT JOIN sede se on se.id_sede=rm.id_sede
                WHERE rm.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_registro_interes(){
        $sql = "SELECT it.*,se.id_empresa,se.id_sede,se.nom_producto_interes FROM registro_mail_producto it
                LEFT JOIN producto_interes se on se.id_producto_interes=it.id_producto_interes
                WHERE it.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function consulta_reporte_diario($id_empresa,$dia,$id_subtipo){
        $sql = "SELECT s_redes FROM proyecto where $id_empresa=1 and fec_agenda='$dia' and id_subtipo='$id_subtipo'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function consulta_subido_reporte_diario($id_empresa,$dia,$id_subtipo){
        $sql = "SELECT s_redes FROM proyecto where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo='$id_subtipo'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*----------------INVENTARIO-------------- */
    function get_list_codigo_inventario(){
        $sql = "SELECT c.*,s.nom_status,a.nom_anio from inventario_codigo c 
        left join status s on s.id_status=c.estado
        left join anio a on a.id_anio=c.id_anio
        where c.estado in (2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_codigo_inventario($dato){
        $sql = "SELECT * from inventario_codigo where (estado in (2,3) and letra='".$dato['letra']."') or ( estado in (2,3) and id_anio='".$dato['id_anio']."')";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_inventario($dato){
        $sql = "SELECT * from inventario where estado in (39,40,41,42) and codigo_barra='".$dato['codigo_barra']."'";
       
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_siyaexiste_codigo_inventario($dato){
        $sql = "SELECT * from inventario where estado in (39,40,41,42) and letra='".$dato['letra_anterior']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_inventario_siyaexiste($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        //$sql = "UPDATE inventario set letra='".$dato['letra']."' WHERE id_inventario='".$dato['id_inventario']."'";
        $sql="UPDATE inventario set letra='".$dato['letra']."',codigo_barra=(SELECT CONCAT('".$dato['letra']."', '/', SUBSTRING_INDEX(codigo_barra,'/',-1))  FROM inventario WHERE id_inventario='".$dato['id_inventario']."') WHERE id_inventario='".$dato['id_inventario']."'
        ;";
        $this->db->query($sql);
    }

    function valida_codigo_inventario_activos($dato){
        $sql = "SELECT * from inventario_codigo where estado=2 ";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_codigo_inventario_edit($dato){
        $sql = "SELECT * from inventario_codigo where (estado in (2,3) and letra='".$dato['letra']."' and id_codigo_inventario<>'".$dato['id_codigo_inventario']."') or (estado in (2,3) and id_anio='".$dato['id_anio']."' and id_codigo_inventario<>'".$dato['id_codigo_inventario']."')";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_codigo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $anio=date('Y');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into inventario_codigo (letra,num_inicio, num_fin,id_anio, estado, fec_reg, user_reg) 
        values ('". $dato['letra']."','". $dato['num_inicio']."','". $dato['num_fin']."','".$dato['id_anio']."','2', 
        '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }

    function get_id_codigo_inventario($id_codigo){
        if(isset($id_codigo) && $id_codigo > 0){
            $sql = "select * from inventario_codigo where id_codigo_inventario =".$id_codigo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_codigo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update inventario_codigo set letra='". $dato['letra']."',num_inicio='". $dato['num_inicio']."',num_fin='". $dato['num_fin']."',id_anio='". $dato['id_anio']."', 
        fec_act='".$fecha."', user_act=".$id_usuario."  where id_codigo_inventario='". $dato['id_codigo_inventario']."'";

        $this->db->query($sql);
    }

    function delete_codigo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update inventario_codigo set estado='4', 
        fec_eli='".$fecha."', user_eli=".$id_usuario."  where id_codigo_inventario='". $dato['id_codigo_inventario']."'";
        $this->db->query($sql);

        $sql="update inventario set estado='4', 
        fec_eli='".$fecha."', user_eli=".$id_usuario."  where id_codigo_inventario='". $dato['id_codigo_inventario']."'";
        $this->db->query($sql);
    }



    /*-----------------------------------------*/

    function get_list_local_inventario(){
        $sql = "SELECT c.*,s.nom_status,t.cod_empresa,st.cod_sede,u.usuario_codigo from inventario_local c 
        left join status s on s.id_status=c.estado
        left join empresa t on t.id_empresa=c.id_empresa
        left join sede st on st.id_sede=c.id_sede
        left join users u on u.id_usuario=c.id_responsable
        where c.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_producto_inventario($id_producto=null){
        if((isset($id_producto) && $id_producto > 0)){
            $sql = "SELECT c.*
                from inventario_producto c 
            where c.id_inventario_producto='".$id_producto."'";
        }else{
             $sql = "SELECT c.*,s.nom_status,DATE_FORMAT(c.fec_compra,'%d/%m/%Y') as fecha_compra,DATE_FORMAT(c.garantia_h,'%d/%m/%Y') as fecha_garantia,t.nom_tipo_inventario,st.nom_subtipo_inventario from inventario_producto c 
                left join status_general s on s.id_status_general=c.estado
                left join tipo_inventario t on t.id_tipo_inventario=c.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=c.id_subtipo_inventario
                where c.estado in (39,40,41)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_archivos_adicionales_producto($id_producto){
        
        $sql = "SELECT * from inventario_producto_historial where id_producto_inventario='".$id_producto."' and estado=2";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_archivos_adicionales_producto($id_historial_producto){
        
        $sql = "SELECT * from inventario_producto_historial where id_historial_producto='".$id_historial_producto."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_local_inventario($dato){
        $sql = "SELECT * from inventario_local where estado=2 and id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' and nom_local='".$dato['nom_local']."' and id_responsable='".$dato['id_responsable']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_local_inventario_edit($dato){
        $sql = "SELECT * from inventario_local where estado=2 and id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' and nom_local='".$dato['nom_local']."' and id_responsable='".$dato['id_responsable']."' and id_inventario_local<>'".$dato['id_inventario_local']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_local_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $anio=date('Y');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into inventario_local (id_empresa,id_sede, nom_local,id_responsable, estado, fec_reg, user_reg) 
        values ('". $dato['id_empresa']."','".$dato['id_sede']."','".$dato['nom_local']."','".$dato['id_responsable']."','2', 
        '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }

    function get_id_local_inventario($id_local){
        if(isset($id_local) && $id_local > 0){
            $sql = "select * from inventario_local where id_inventario_local =".$id_local;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_local_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update inventario_local set id_empresa='". $dato['id_empresa']."',id_sede='". $dato['id_sede']."',nom_local='". $dato['nom_local']."',id_responsable='". $dato['id_responsable']."', 
        fec_act='".$fecha."', user_act=".$id_usuario."  where id_inventario_local='". $dato['id_inventario_local']."'";
        $this->db->query($sql);
    }

    function delete_local_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update inventario_local set estado='1', fec_eli='".$fecha."', user_eli=".$id_usuario."  where id_inventario_local='". $dato['id_inventario_local']."'";
        $this->db->query($sql);
    }

    function get_list_sede_xempresa($dato){
        $sql = "SELECT * from sede where estado=2 and id_empresa='".$dato['id_empresa']."'";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario1($dato){
        $sql = "SELECT * from users where estado=2 and id_usuario='".$dato['id_usuario_1']."'";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    

    /*--------------TIPO INVENTARIO------------- */

    function get_list_tipo_inventario(){
        $sql = "SELECT se.*, s.nom_status from tipo_inventario se
                left join status s on se.estado=s.id_status
                WHERE se.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_tipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into tipo_inventario (nom_tipo_inventario, estado, fec_reg, user_reg) 
        values ('". $dato['nom_tipo_inventario']."','2', 
        '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }
    
    function update_tipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update tipo_inventario set nom_tipo_inventario='". $dato['nom_tipo_inventario']."', 
        fec_act='".$fecha."', user_act=".$id_usuario."  where id_tipo_inventario='". $dato['id_tipo_inventario']."'";
        $this->db->query($sql);
    }

    function delete_tipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update tipo_inventario set estado='1', fec_eli='".$fecha."', user_eli=".$id_usuario."  where id_tipo_inventario='". $dato['id_tipo_inventario']."'";
        $this->db->query($sql);
    }
    
    function get_id_tipo_inventario($id_tipo){
        if(isset($id_tipo) && $id_tipo > 0){
            $sql = "select * from tipo_inventario where id_tipo_inventario =".$id_tipo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_tipo_inventario($dato){
        $sql = "SELECT * from tipo_inventario where estado=2 and nom_tipo_inventario='".$dato['nom_tipo_inventario']."' ";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_tipo_inventarioe($dato){
        $sql = "SELECT * from tipo_inventario where estado=2 and nom_tipo_inventario='".$dato['nom_tipo_inventario']."' and id_tipo_inventario<>'".$dato['id_tipo_inventario']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*--------------------------------------*/
    function get_list_subtipo_inventario(){
        $sql = "SELECT si.*, s.nom_status,t.nom_tipo_inventario from subtipo_inventario si
                left join status s on si.estado=s.id_status
                left join tipo_inventario t on t.id_tipo_inventario=si.id_tipo_inventario
                WHERE si.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_subtipo_inventario($id_subtipo){
        if(isset($id_subtipo) && $id_subtipo > 0){
            $sql = "select * from subtipo_inventario where id_subtipo_inventario =".$id_subtipo;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_subtipo_inventario($dato){
        $sql = "SELECT * from subtipo_inventario where estado=2 and nom_subtipo_inventario='".$dato['nom_subtipo_inventario']."' and id_tipo_inventario='".$dato['id_tipo_inventario']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_subtipo_inventarioe($dato){
        $sql = "SELECT * from subtipo_inventario where estado=2 and nom_subtipo_inventario='".$dato['nom_subtipo_inventario']."' and id_tipo_inventario='".$dato['id_tipo_inventario']."' and id_subtipo_inventario<>'".$dato['id_subtipo_inventario']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_subtipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into subtipo_inventario (id_tipo_inventario,nom_subtipo_inventario,intervalo_rev, estado, fec_reg, user_reg) 
        values ('". $dato['id_tipo_inventario']."','". $dato['nom_subtipo_inventario']."','". $dato['intervalo_rev']."','2', '".$fecha."',".$id_usuario.")";
        $this->db->query($sql);
    }

    function update_subtipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update subtipo_inventario set id_tipo_inventario='". $dato['id_tipo_inventario']."', nom_subtipo_inventario='". $dato['nom_subtipo_inventario']."', intervalo_rev='".$dato['intervalo_rev']."',
        fec_act='".$fecha."', user_act=".$id_usuario."  where id_subtipo_inventario='". $dato['id_subtipo_inventario']."'";
        $this->db->query($sql);
    }

    function delete_subtipo_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="update subtipo_inventario set estado='1', 
        fec_eli='".$fecha."', user_eli=".$id_usuario."  where id_subtipo_inventario='". $dato['id_subtipo_inventario']."'";
        $this->db->query($sql);
    }

    /*--------------------PRODUCTO INVENTARIO-----------------*/

    function get_list_subtipo_xtipo($dato){
        $sql = "SELECT * from subtipo_inventario where estado=2 and id_tipo_inventario='".$dato['id_tipo_inventario']."'";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function get_list_anio(){
        $sql = "SELECT id_anio,nom_anio FROM anio WHERE nom_anio>=2019 AND estado=1 ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_ultimo_codigo_inventario(){
        
        $sql = "SELECT c.*,a.nom_anio from inventario_codigo c 
        left join anio a on a.id_anio=c.id_anio
        where c.estado=2 ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_producto(){
        $sql = "SELECT * FROM inventario_producto";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_producto_inventario($dato){
        $sql = "SELECT * from inventario_producto where estado=2 and id_tipo_inventario='".$dato['id_tipo_inventario']."' and id_subtipo_inventario='".$dato['id_subtipo_inventario']."' and fec_compra='".$dato['fec_compra']."' and garantia_h='".$dato['garantia_h']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_producto_inventario_edit($dato){
        $sql = "SELECT * from inventario_producto where estado in (39,40,41,42) and id_tipo_inventario='".$dato['id_tipo_inventario']."' and id_subtipo_inventario='".$dato['id_subtipo_inventario']."' and fec_compra='".$dato['fec_compra']."' and garantia_h='".$dato['garantia_h']."' and id_inventario_producto<>'".$dato['id_inventario_producto']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_producto_inventario($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        
        $path = $_FILES['imagenr']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagenr';
        $config['upload_path'] = './inventario_producto/'.$dato['referencia'].'/';
        $config['file_name'] = "prod".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'inventario_producto/'.$dato['referencia'].'/'.$config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $fecha=date('Y-m-d H:i:s');
        if($path!=""){
            $sql="insert into inventario_producto (
                referencia,
                id_tipo_inventario,
                id_subtipo_inventario,
                producto_descripcion,
                fec_compra,
                proveedor,
                garantia_h,
                precio_u,
                cantidad,
                total,
                desvalorizacion,
                gastos,
                valor_actual,
                producto_obs,
                imagen,
                estado, fec_reg, user_reg
            ) 
    
            values (
                '". $dato['referencia']."',
                '". $dato['id_tipo_inventario']."',
                '". $dato['id_subtipo_inventario']."',
                '". $dato['producto_descripcion']."',
                '". $dato['fec_compra']."',
                '". $dato['proveedor']."',
                '". $dato['garantia_h']."',
                '". $dato['precio_u']."',
                '". $dato['cantidad']."',
                '". $dato['total']."',
                '". $dato['desvalorizacion']."',
                '". $dato['gastos']."',
                '". $dato['valor_actual']."',
                '". $dato['producto_obs']."',
                '".$ruta."',
                '".$dato['id_estado']."', '".$fecha."','".$id_usuario."'
            )";
        }else{
            $sql="insert into inventario_producto (
                referencia,
                id_tipo_inventario,
                id_subtipo_inventario,
                producto_descripcion,
                fec_compra,
                proveedor,
                garantia_h,
                precio_u,
                cantidad,
                total,
                desvalorizacion,
                gastos,
                valor_actual,
                producto_obs,
                estado, fec_reg, user_reg
            ) 
    
            values (
                '". $dato['referencia']."',
                '". $dato['id_tipo_inventario']."',
                '". $dato['id_subtipo_inventario']."',
                '". $dato['producto_descripcion']."',
                '". $dato['fec_compra']."',
                '". $dato['proveedor']."',
                '". $dato['garantia_h']."',
                '". $dato['precio_u']."',
                '". $dato['cantidad']."',
                '". $dato['total']."',
                '". $dato['desvalorizacion']."',
                '". $dato['gastos']."',
                '". $dato['valor_actual']."',
                '". $dato['producto_obs']."',
                '".$dato['id_estado']."', '".$fecha."','".$id_usuario."'
            )";
        }
        $this->db->query($sql);
    }

    function insert_archivo_adicional_producto_inventario($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO inventario_producto_historial (id_producto_inventario,archivo,estado,fec_reg, user_reg) 
                VALUES ((SELECT id_inventario_producto from inventario_producto where referencia='".$dato['referencia']."'),'".$dato['ruta']."',2,NOW(),$id_usuario)";
        
        $this->db->query($sql);
    }

    function update_producto_inventario($dato){
        
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $path = $_FILES['imagene']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagene';
        $config['upload_path'] = './inventario_producto/'.$dato['referencia'].'/';
        $config['file_name'] = "prod".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'inventario_producto/'.$dato['referencia'].'/'.$config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();
        
        $fecha=date('Y-m-d H:i:s');
        if($path!=""){
            $sql="update inventario_producto set 
            id_tipo_inventario='". $dato['id_tipo_inventario']."',
            id_subtipo_inventario='". $dato['id_subtipo_inventario']."',
            producto_descripcion='". $dato['producto_descripcion']."',
            fec_compra='". $dato['fec_compra']."', 
            proveedor='". $dato['proveedor']."', 
            garantia_h='". $dato['garantia_h']."', 
            precio_u='". $dato['precio_u']."', 
            cantidad='". $dato['cantidad']."', 
            total='". $dato['total']."', 
            desvalorizacion='". $dato['desvalorizacion']."', 
            anio='". $dato['anio']."', 
            gastos='". $dato['gastos']."', 
            valor_actual='". $dato['valor_actual']."', 
            producto_obs='". $dato['producto_obs']."', 
            imagen='".$ruta."',
            estado='".$dato['estado']."',
            fec_act='".$fecha."', user_act=".$id_usuario."  where id_inventario_producto='". $dato['id_inventario_producto']."'";
        }else{
            $sql="update inventario_producto set 
            id_tipo_inventario='". $dato['id_tipo_inventario']."',
            id_subtipo_inventario='". $dato['id_subtipo_inventario']."',
            producto_descripcion='". $dato['producto_descripcion']."',
            fec_compra='". $dato['fec_compra']."', 
            proveedor='". $dato['proveedor']."', 
            garantia_h='". $dato['garantia_h']."', 
            precio_u='". $dato['precio_u']."', 
            cantidad='". $dato['cantidad']."', 
            total='". $dato['total']."', 
            desvalorizacion='". $dato['desvalorizacion']."', 
            anio='". $dato['anio']."', 
            gastos='". $dato['gastos']."', 
            valor_actual='". $dato['valor_actual']."', 
            producto_obs='". $dato['producto_obs']."',
            estado='".$dato['estado']."',
            fec_act='".$fecha."', user_act=".$id_usuario."  where id_inventario_producto='". $dato['id_inventario_producto']."'";
        }
        $this->db->query($sql);
    }

    /*function insert_inventario_xletra_temporal($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO inventario_temporal (inventario_codigo,estado,fec_reg, user_reg) 
        VALUES ('".$dato['cod_inventario']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function limpiar_tenmporal_inventario(){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM inventario_temporal WHERE user_reg='$id_usuario'";
        $this->db->query($sql);
    }*/

    function get_inventario_xid($dato){
        $anio=date('Y');
        $sql = "SELECT i.*,s.nom_status as estado_inventario  
        FROM inventario i
        left join status_general s on s.id_status_general=i.estado
        where i.id_inventario_producto='".$dato['id_inventario_producto']."'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_estado_inventario(){
        $anio=date('Y');
        $sql = "SELECT * from status_general where id_status_general in (39,40,41,42)";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $sql="insert into inventario (
            id_codigo_inventario,
            codigo_barra,
            letra,
            estado, 
            fec_reg,
            user_reg
        ) 

        values ((SELECT id_codigo_inventario FROM inventario_codigo WHERE letra='".$dato['letra']."' AND estado=2),
            '".$dato['codigo_barra']."','".$dato['letra']."',
            '42', '".$fecha."',".$id_usuario."
        )";
        
        $this->db->query($sql);

    }

    function delete_inventario_xcodigomenor($dato){
        $sql = "UPDATE inventario set estado='4' WHERE codigo_barra='".$dato['codigo_barra']."'";
        $this->db->query($sql);
    }

    function delete_inventario_xbarra($dato){
        $sql = "UPDATE inventario set estado='4' WHERE codigo_barra NOT BETWEEN '".$dato['codigo_barra_i']."' and '".$dato['codigo_barra_f']."';";
        $this->db->query($sql);
    }

    function get_list_inventario($id_inventario=null){
        if((isset($id_inventario) && $id_inventario > 0)){
            $sql = "SELECT i.*,t.nom_tipo_inventario,st.nom_subtipo_inventario,ip.producto_descripcion,ip.fec_compra,ip.proveedor,ip.garantia_h,
            ip.precio_u,ip.cantidad,ip.total,ip.desvalorizacion,ip.gastos,ip.valor_actual
                from inventario i
                left join inventario_producto ip on ip.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=ip.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=ip.id_subtipo_inventario
            where i.id_inventario='".$id_inventario."'";
        }else{
             $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion where i.estado<>4";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busqueda_list_inventario($parametro){
        if($parametro==1){
            $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg,YEAR(i.fec_validacion) as lcheck
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion where i.estado<>4 and i.id_empresa<>0 and i.id_sede<>0 and i.id_local<>0
                ORDER BY i.codigo_barra ASC";
        }elseif($parametro==2){
             $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg,YEAR(i.fec_validacion) as lcheck
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion where i.estado<>4 and i.id_empresa=0 and i.id_sede=0 and i.id_local=0
                ORDER BY i.codigo_barra ASC";
        }else{
            $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg,YEAR(i.fec_validacion) as lcheck
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion where i.estado<>4
                ORDER BY i.codigo_barra ASC
                ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_inventario_sasignacion(){
        
        $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario
        from inventario i 
        left join status_general s on s.id_status_general=i.estado
        left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
        left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
        left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
        where i.estado=39 and i.id_empresa=0";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_local(){
        $sql = "SELECT * FROM users WHERE estado=2 and id_nivel in (1,7)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_codigos_activos($dato){
        $sql = "SELECT COUNT(*) as cantidad_activos FROM inventario i2 WHERE SUBSTRING_INDEX(i2.inventario_codigo,'/',1)='".$dato['letra']."' and i2.estado=39;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_codigos_disponible($dato){
        $sql = "SELECT COUNT(*) as cantidad_disponibles FROM inventario i2 WHERE SUBSTRING_INDEX(i2.inventario_codigo,'/',1)='".$dato['letra']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_codigos_sinrevisar($dato){
        $sql = "SELECT COUNT(*) as cantidad_sinrevisar FROM inventario i2 WHERE SUBSTRING_INDEX(i2.inventario_codigo,'/',1)='".$dato['letra']."' and i2.estado=40;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_codigos_revision($dato){
        $sql = "SELECT COUNT(*) as cantidad_revision FROM inventario i2 WHERE SUBSTRING_INDEX(i2.inventario_codigo,'/',1)='".$dato['letra']."' and i2.estado=41;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_empresa_in($dato){
        $sql = "SELECT se.*, s.nom_status, CASE WHEN rep_redes =1 THEN 'Si' ELSE 'No' END AS reporte
                from empresa se
                left join status s on se.estado=s.id_status
                where se.estado=2 and se.id_empresa in ".$dato['cadena']."
                ORDER BY cod_empresa";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_inventario_xletra($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT i.*,se.cod_sede,em.cod_empresa,
                s.nom_status as estado_inventario,YEAR(i.fec_validacion) as lcheck
                FROM inventario i
                left join sede se on se.id_sede=i.id_sede
                left join empresa em on em.id_empresa=i.id_empresa
                left join status_general s on s.id_status_general=i.estado
                left join inventario_codigo ic on ic.letra='".$dato['letra']."' and ic.estado=2
                left join anio a on a.id_anio=ic.id_anio
                where i.letra='".$dato['letra']."' and i.estado in (39,40,41,42) ORDER BY i.codigo_barra ASC limit ".$dato['cantidad']."
                
                ";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_local_inventario(){
        $sql = "SELECT c.*,s.nom_status,t.cod_empresa, t.id_empresa from inventario_local c 
        left join status s on s.id_status=c.estado
        left join empresa t on t.id_empresa=c.id_empresa
        where c.estado=2 group by t.cod_empresa";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede_local_inventario($id_empresa=null){
        if(isset($id_empresa) && $id_empresa > 0){
            $sql = "SELECT c.*,s.nom_status,c.id_empresa,se.cod_sede,se.id_sede from inventario_local c 
            left join status s on s.id_status=c.estado
            left join sede se on se.id_sede=c.id_sede
            where c.estado=2 and c.id_empresa='$id_empresa' group by se.cod_sede";
        }else{
            $sql = "SELECT c.*,s.nom_status,se.cod_sede,se.id_sede from inventario_local c 
            left join status s on s.id_status=c.estado
            left join sede se on se.id_sede=c.id_sede
            where c.estado=2 group by se.cod_sede";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_local_inventario_xempresa_sede($dato){
            $sql = "SELECT * from inventario_local where id_empresa='".$dato['id_empresa']."' and id_sede='".$dato['id_sede']."' and estado=2";
       
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_imagen_productoi($id_producto){
        $sql = "UPDATE inventario_producto set imagen='' WHERE id_inventario_producto=$id_producto";
        $this->db->query($sql);
    }

    function delete_imagen_productoi_historial($id_historial_producto){
        $sql = "DELETE FROM inventario_producto_historial WHERE id_historial_producto=$id_historial_producto";
        $this->db->query($sql);
    }

    function valida_asignacion_codigo($dato){
        $sql = "SELECT * from inventario where id_inventario_producto<>0 and codigo_barra='".$dato['inventario_codigo']."' and id_sede<>0 and id_empresa<>0 and id_local<>0 and estado in (39,40,41,42)";
   
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_asignacion_codigo2($dato){
        $sql = "SELECT * from inventario where id_inventario_producto='".$dato['id_producto']."' and inventario_codigo<>'' and id_sede<>0 and id_empresa<>0 and id_local<>0 and estado in (39,40,41,42)";
   
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_codigo_img($dato){
        $sql = "SELECT * from inventario where archivo_validacion<>'' and id_inventario='".$dato['id_inventario']."'";
   
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_validacion_codigo($dato){
        $sql = "SELECT * from inventario where validacion<>0 and codigo_barra='".$dato['inventario_codigo']."' and estado in (39,40,41,42)";
   
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_asignacion_producto($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE inventario set estado=39, id_inventario_producto='".$dato['id_producto']."', id_empresa='".$dato['id_empresa']."', id_sede='".$dato['id_sede']."',id_local='".$dato['id_local']."',user_act='".$id_usuario."',fec_act='".$fecha."'  WHERE codigo_barra='".$dato['inventario_codigo']."' and estado<>4";
        $this->db->query($sql);
    }

    function update_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE inventario set id_local='".$dato['id_local']."', estado='".$dato['id_estado']."',user_act='".$id_usuario."',fec_act='".$fecha."'  WHERE id_inventario='".$dato['id_inventario']."'";
        $this->db->query($sql);
    }

    function update_validacion_inventario($dato){
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE inventario set estado=39,validacion='1', fec_validacion='".$fecha."',user_validacion='".$id_usuario."'  WHERE codigo_barra='".$dato['inventario_codigo']."'";
        $this->db->query($sql);
    }

    function get_list_inventario_xsede($id_sede=null){
        if((isset($id_sede) && $id_sede > 0)){
            $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN i.validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg,YEAR(i.fec_validacion) as lcheck
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion where i.id_sede='$id_sede' AND  i.estado in (39,40,41,42) ";
        }else{
             $sql = "SELECT i.*,s.nom_status,iv.referencia,t.nom_tipo_inventario,st.nom_subtipo_inventario,
             e.cod_empresa,se.cod_sede,l.nom_local,u.usuario_codigo,DATE_FORMAT(i.fec_validacion,'%d/%m/%Y %H:%i:%s') as fecha_validacion,
             CASE WHEN i.validacion =1 THEN 'Si' ELSE 'No' END AS validacion_msg,YEAR(i.fec_validacion) as lcheck
             from inventario i 
                left join status_general s on s.id_status_general=i.estado
                left join inventario_producto iv on iv.id_inventario_producto=i.id_inventario_producto
                left join tipo_inventario t on t.id_tipo_inventario=iv.id_tipo_inventario
                left join subtipo_inventario st on st.id_subtipo_inventario=iv.id_subtipo_inventario
                left join empresa e on e.id_empresa=i.id_empresa
                left join sede se on se.id_sede=i.id_sede
                left join inventario_local l on l.id_inventario_local=i.id_local
                left join users u on u.id_usuario=i.user_validacion
                WHERE i.estado in (39,40,41,42) ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede_inventario(){
        $sql = "SELECT * from sede where estado=2";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_base_datos($id_base_datos=null){
        if(isset($id_base_datos) && $id_base_datos>0){
          $sql = "SELECT * FROM base_datos WHERE id_base_datos=$id_base_datos";
        }else{
          $sql = "SELECT bd.*,em.cod_empresa,se.cod_sede,es.nom_status FROM base_datos bd
                  LEFT JOIN empresa em ON em.id_empresa=bd.id_empresa
                  LEFT JOIN sede se ON se.id_sede=bd.id_sede
                  LEFT JOIN status es ON es.id_status=bd.estado";
        }
  
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
  
    function get_list_base_datos_num_todo(){
        $sql = "SELECT * FROM base_datos_num WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_usuario_para($id_usuario){ 
        $sql = "SELECT c.id_cargo FROM cargo c
                WHERE c.id_usuario_1=$id_usuario AND (SELECT ch.id_estado FROM cargo_historial ch
                WHERE ch.id_cargo=c.id_cargo AND ch.estado=2 
                ORDER BY ch.id_cargo_historial DESC LIMIT 1) IN (43,45,46)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_next_cargo(){
        $sql = "SELECT concat('CAR',right(YEAR(NOW()),2),'-',LPAD((select count(id_cargo) from cargo)+1,5,'0')) as next_cargo";
        //echo ($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cargo($dato){
        $sql = "SELECT * from cargo where estado in (43,44,45,46,47) and cod_cargo='".$dato['cod_cargo']."' ";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cargo_edit($dato){
        $sql = "SELECT * from cargo where estado in (43,44,45,46,47) and cod_cargo='".$dato['cod_cargo']."' and id_cargo<>'".$dato['id_cargo']."' ";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_cargo($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $fecha=date('Y-m-d H:i:s');
        
            $sql="insert into cargo (
                cod_cargo,
                id_usuario_de,
                id_empresa_1,
                id_sede_1,
                id_usuario_1,
                otro_1,
                correo_1,
                celular_1,
                id_empresa_2,
                id_sede_2,
                id_usuario_2,
                otro_2,
                correo_2,
                celular_2,
                empresa_transporte,
                referencia,
                desc_cargo,
                obs_cargo,
                id_rubro,
                estado, fec_reg, user_reg
            ) 
    
            values (
                '". $dato['cod_cargo']."',
                '". $dato['id_usuario_de']."',
                '". $dato['id_empresa_1']."',
                '". $dato['id_sede_1']."',
                '". $dato['id_usuario_1']."',
                '". $dato['otro_1']."',
                '". $dato['correo_1']."',
                '". $dato['celular_1']."',
                '". $dato['id_empresa_2']."',
                '". $dato['id_sede_2']."',
                '". $dato['id_usuario_2']."',
                '". $dato['otro_2']."',
                '". $dato['correo_2']."',
                '". $dato['celular_2']."',
                '". $dato['empresa_transporte']."',
                '". $dato['referencia']."',
                '". $dato['desc_cargo']."',
                '". $dato['obs_cargo']."',
                '".$dato['id_rubro']."',
                '".$dato['estado']."', '".$fecha."','".$id_usuario."'
            )";
        
        $this->db->query($sql);

        $sql2 = "INSERT INTO cargo_archivo (id_cargo,nombre,archivo,estado,fec_reg, user_reg) 
        SELECT (SELECT id_cargo from cargo where cod_cargo='".$dato['cod_cargo']."'),nombre,archivo,2,NOW(),$id_usuario FROM cargo_archivo_temporal WHERE user_reg=$id_usuario";
        $this->db->query($sql2);

        $sql3 = "DELETE FROM cargo_archivo_temporal WHERE user_reg=$id_usuario";
        $this->db->query($sql3);
    }

    function update_historial_cargo($dato){
        
        //$id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $fecha=date('Y-m-d H:i:s');
        
            $sql="UPDATE cargo_historial SET
                aprobado='".$dato['aprobado']."',
                fec_act='".$fecha."',
                user_act='".$dato['id_usuario']."'
                WHERE id_cargo='".$dato['id_cargo']."' and id_estado='".$dato['id_estado']."' and estado=2";
        
        $this->db->query($sql);
    }

    function update_historial_cargo_rechazado($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $fecha=date('Y-m-d H:i:s');
        
            $sql="UPDATE cargo_historial SET
                aprobado='".$dato['aprobado']."',
                editado='".$dato['editado']."',
                fec_act='".$fecha."',
                user_act='".$id_usuario."'
                WHERE id_cargo='".$dato['id_cargo']."' and id_estado='".$dato['id_estado']."' and estado=2";
        
        $this->db->query($sql);
    }

    function insert_historial_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_historial (id_cargo,id_estado,aprobado,estado,fec_reg,user_reg) 
                VALUES ('". $dato['id_cargo']."','". $dato['id_estado']."','". $dato['aprobado']."','2',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_historial_cargo_correo($dato){
        /*$id_usuario= $_SESSION['usuario'][0]['id_usuario'];*/
        $sql = "INSERT INTO cargo_historial (id_cargo,id_estado,aprobado,estado,fec_reg,user_reg) 
                VALUES ('". $dato['id_cargo']."','". $dato['id_estado']."','". $dato['aprobado']."','2',NOW(),'". $dato['id_usuario']."')";
        $this->db->query($sql);
    }

    function update_cargo($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        
        $fecha=date('Y-m-d H:i:s');
        
            $sql="UPDATE cargo SET
                id_usuario_de='".$dato['id_usuario_de']."',
                id_empresa_1='".$dato['id_empresa_1']."',
                id_sede_1='". $dato['id_sede_1']."',
                id_usuario_1='". $dato['id_usuario_1']."',
                otro_1='". $dato['otro_1']."',
                correo_1='". $dato['correo_1']."',
                celular_1='". $dato['celular_1']."',
                id_empresa_2='". $dato['id_empresa_2']."',
                id_sede_2='". $dato['id_sede_2']."',
                id_usuario_2='". $dato['id_usuario_2']."',
                otro_2='". $dato['otro_2']."',
                correo_2='". $dato['correo_2']."',
                celular_2='". $dato['celular_2']."',
                empresa_transporte='". $dato['empresa_transporte']."',
                referencia='". $dato['referencia']."',
                desc_cargo='". $dato['desc_cargo']."',
                obs_cargo='". $dato['obs_cargo']."',
                id_rubro='". $dato['id_rubro']."',
                estado='".$dato['estado']."',
                fec_act='".$fecha."',
                user_act='".$id_usuario."'
                WHERE id_cargo='".$dato['id_cargo']."'
                 
            ";
        
        $this->db->query($sql);
    }

    function insert_archivo_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_archivo (id_cargo,nombre,archivo,estado,fec_reg, user_reg) 
                VALUES ((SELECT id_cargo from cargo where cod_cargo='".$dato['cod_cargo']."'),'Documento de registro','".$dato['ruta']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_cargo($tipo){
        $parte = "AND c.estado <> 1";
        $id_usuario=$_SESSION['usuario'][0]['id_usuario'];
        $parte2 = "";
        if($id_usuario!=1 && $id_usuario!=5 && $id_usuario!=33 && $id_usuario!=7 && $id_usuario!=82 && $id_usuario!=85){
            $parte2 ="and (c.id_usuario_de = $id_usuario or c.id_usuario_1 = $id_usuario)";
        }
        
        if($tipo==1){ 
            $parte = "AND (SELECT ch.id_estado FROM cargo_historial ch
                    WHERE ch.id_cargo=c.id_cargo AND ch.estado=2 
                    ORDER BY ch.id_cargo_historial DESC LIMIT 1) IN (43,45,46)";
        }

        if($_SESSION['usuario'][0]['id_usuario']==60){
            $sql = "SELECT c.*,es.nom_status,e.cod_empresa as empresa_1,u0.usuario_codigo as usuario_de,
                    s1.cod_sede as sede_1,u1.usuario_codigo as usuario_1,
                    (select ss.nom_status from cargo_historial l 
                    left JOIN status_general ss on ss.id_status_general=l.id_estado 
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as nom_estado,
                    (select ss.color from cargo_historial l 
                    left JOIN status_general ss on ss.id_status_general=l.id_estado 
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as color_estado,
                    (select l.id_estado from cargo_historial l  
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as ultimo_estado,
                    DATE_FORMAT(c.fec_reg,'%d-%m-%Y') AS fecha, ca.nombre as doc, rg.nom_rubro
                    FROM cargo c
                    left join empresa e on e.id_empresa=c.id_empresa_1
                    left join users u0 on u0.id_usuario=c.id_usuario_de
                    left join sede s1 on s1.id_sede=c.id_sede_1
                    left join users u1 on u1.id_usuario=c.id_usuario_1
                    LEFT JOIN status_general es ON es.id_status_general=c.estado 
                    left join cargo_archivo ca on c.id_cargo=ca.id_cargo
                    left join rubro_gl rg on rg.id_rubro=c.id_rubro
                    WHERE c.id_usuario_1=60 $parte $parte2
                    group by c.cod_cargo
                    ORDER BY c.cod_cargo DESC";
        }else{
            $sql = "SELECT c.*,es.nom_status,e.cod_empresa as empresa_1,u0.usuario_codigo as usuario_de,
                    s1.cod_sede as sede_1,u1.usuario_codigo as usuario_1,
                    (select ss.nom_status from cargo_historial l 
                    left JOIN status_general ss on ss.id_status_general=l.id_estado 
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as nom_estado,
                    (select ss.color from cargo_historial l 
                    left JOIN status_general ss on ss.id_status_general=l.id_estado 
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as color_estado,
                    (select l.id_estado from cargo_historial l  
                    where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as ultimo_estado,
                    DATE_FORMAT(c.fec_reg,'%d-%m-%Y') AS fecha,ca.nombre as doc,rg.nom_rubro
                    FROM cargo c
                    left join empresa e on e.id_empresa=c.id_empresa_1
                    left join users u0 on u0.id_usuario=c.id_usuario_de
                    left join sede s1 on s1.id_sede=c.id_sede_1
                    left join users u1 on u1.id_usuario=c.id_usuario_1
                    LEFT JOIN status_general es ON es.id_status_general=c.estado
                    left join cargo_archivo ca on c.id_cargo=ca.id_cargo 
                    left join rubro_gl rg on rg.id_rubro=c.id_rubro
                    WHERE c.id_cargo>0 $parte $parte2
                    group by c.cod_cargo
                    ORDER BY c.cod_cargo DESC ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_cargo($id_cargo){
        $sql = "SELECT c.*,
                (select ss.nom_status from cargo_historial l 
                left JOIN status_general ss on ss.id_status_general=l.id_estado 
                where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as nom_estado,
                (select l.id_estado from cargo_historial l  
                where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as ultimo_estado
                FROM cargo c WHERE c.id_cargo=$id_cargo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial($dato){
        $sql = "SELECT * FROM cargo_historial WHERE id_cargo='".$dato['id_cargo']."' and id_estado='".$dato['id_estado']."' and estado=2";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_archivos_cargo($id_cargo){
        
        $sql = "SELECT * from cargo_archivo where id_cargo='".$id_cargo."' and estado=2";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_cargo_historial($id_cargo, $ultimo=null){
        if(isset($ultimo) && $ultimo > 0){
            $sql = "SELECT id_estado FROM cargo_historial h where h.id_cargo='".$id_cargo."' and h.estado=2
            ORDER BY h.id_cargo_historial DESC LIMIT 1";            
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
        else{
            $sql = "SELECT h.*,s.nom_status,u.usuario_codigo as user1,
            DATE_FORMAT(h.fec_reg,'%d/%m/%Y %H:%i') as fecha_registro
            from cargo_historial h 
            left join status_general s on s.id_status_general=h.id_estado
            left join users u on u.id_usuario=h.user_reg
            where h.id_cargo='".$id_cargo."' and h.estado=2
            ORDER BY h.id_cargo_historial ASC";            
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function get_id_cargo_archivo($id_cargo_archivo){
        $sql = "SELECT * from cargo_archivo where id_cargo_archivo=".$id_cargo_archivo."";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_imagen_cargo($id_cargo_archivo){
        $sql = "DELETE FROM cargo_archivo WHERE id_cargo_archivo=$id_cargo_archivo";
        $this->db->query($sql);
    }

    function get_id_sede_xid($id_sede){
        $sql = "SELECT * from sede where id_sede =".$id_sede;
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function aprobar_cargo($dato){
        
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE cargo SET aprobacion='".$dato['aprobacion']."',fec_aprobacion='$fecha',user_aprobacion='$id_usuario' where id_cargo='".$dato['id_cargo']."'";
        
        $this->db->query($sql);
    }

    function aprobar_cargo_para($dato){
        
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE cargo SET aprobacion_para='".$dato['aprobacion']."',fec_aprobacion_para='$fecha',user_aprobacion_para='$id_usuario' where id_cargo='".$dato['id_cargo']."'";
        
        $this->db->query($sql);
    }

    function get_config($dato){
        $sql = "SELECT * from config where id_config =".$dato['id_config'];
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_cargo_xcodigo($dato){
        $sql = "SELECT * FROM cargo WHERE cod_cargo='".$dato['cod_cargo']."'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_mensaje_cargo($dato){
        
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE cargo_historial SET observacion='".$dato['mensaje']."' where id_cargo_historial='".$dato['id_cargo_historial']."'";
       
        $this->db->query($sql);
    }

    function get_id_cargo_historial($id_cargo_h){
        $sql = "SELECT * from cargo_historial where id_cargo_historial =".$id_cargo_h;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_cargo_historial($dato){
        
        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE cargo_historial SET observacion='".$dato['observacion']."' where id_cargo_historial='".$dato['id_cargo_historial']."'";
       
        $this->db->query($sql);
    }

    function consulta_confirmacion_pendiente(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="SELECT c.*,es.nom_status,e.cod_empresa as empresa_1,u0.usuario_codigo as usuario_de,
        s1.cod_sede as sede_1,u1.usuario_codigo as usuario_1,
        (select ss.nom_status from cargo_historial l left JOIN status_general ss on ss.id_status_general=l.id_estado where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as nom_estado,
        (select l.id_estado from cargo_historial l  where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as ultimo_estado,
        (select l.fec_reg from cargo_historial l where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1) as fecha_registro
        
        FROM cargo c
        left join empresa e on e.id_empresa=c.id_empresa_1
        left join users u0 on u0.id_usuario=c.id_usuario_de
        left join sede s1 on s1.id_sede=c.id_sede_1
        left join users u1 on u1.id_usuario=c.id_usuario_1
        LEFT JOIN status_general es ON es.id_status_general=c.estado
        
        
        WHERE c.id_usuario_1='$id_usuario' 
        and (select l.id_estado from cargo_historial l  where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1)=46 
        AND (select DATEDIFF( NOW(), l.fec_reg) from cargo_historial l  where l.id_cargo=c.id_cargo and l.estado=2 order by l.id_cargo_historial  desc limit 1)>=7;";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_validacion_inventario_img($dato){

        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    
        $path = $_FILES['imagenv']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagenv';
        $config['upload_path'] = './validacion_codproducto/'.$dato['get_id'][0]['inventario_codigo'].'/';
        $config['file_name'] = "validacion".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'validacion_codproducto/'.$dato['get_id'][0]['inventario_codigo'].'/'.$config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();
        

        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE inventario set estado=39, validacion='1',archivo_validacion='$ruta', fec_validacion='".$fecha."',user_validacion='".$id_usuario."'  WHERE id_inventario='".$dato['id_inventario']."'";
        $this->db->query($sql);
    }

    function get_list_inventario_xcodigo($dato){
            $sql = "SELECT i.* from inventario i where codigo_barra='".$dato['codigo_barra']."' and i.estado in (39,40,41,42)";
  
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_inventario_xcodigo_activo($dato){
        $sql = "SELECT i.* from inventario i where codigo_barra='".$dato['codigo_barra']."' and i.validacion=1 and i.estado in (39,40,41,42)";
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_validacion_inventario_scanner($dato){

        $fecha=date('Y-m-d H:i:s');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE inventario set validacion='1', fec_validacion='".$fecha."',user_validacion='".$id_usuario."'  WHERE codigo_barra='".$dato['codigo_barra']."' and estado in (39,40,41,42)";
        //echo $sql;
        $this->db->query($sql);
    }

    function valida_cargo_archivo($dato){
        $sql = "SELECT * FROM cargo_archivo WHERE id_cargo='".$dato['id_cargo']."' AND estado=2 and nombre='".$dato['nom_archivo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_cargo_archivo2($dato){
        $sql = "SELECT * FROM cargo_archivo WHERE id_cargo='".$dato['id_cargo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function insert_archivo_cargo2($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        
        $path = $_FILES['archivo']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'archivo';
        $config['upload_path'] = './cargo_documento/';
        $config['file_name'] = "archivo_cargo".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'cargo_documento/'.$config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|xls|xlsx|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $sql = "INSERT INTO cargo_archivo (id_cargo,nombre,archivo,estado,fec_reg, user_reg) 
                VALUES ('".$dato['id_cargo']."','".$dato['nom_archivo']."','".$ruta."',2,NOW(),$id_usuario)";
        
        $this->db->query($sql);
    }

    function valida_preinsert_documento_cargo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM cargo_archivo_temporal WHERE user_reg='$id_usuario' and nombre='".$dato['nombre']."' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function valida_preinsert_documento_cargo2($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM cargo_archivo_temporal WHERE user_reg='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function preinsert_archivo_cargo($dato){
        
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        
        $path = $_FILES['documento']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'documento';
        $config['upload_path'] = './cargo_documento/';
        $config['file_name'] = "archivo_cargo".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'cargo_documento/'.$config['file_name'];

        $config['allowed_types'] = "JPG|jpg|png|PNG|jpeg|JPEG|xls|xlsx|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        $sql = "INSERT INTO cargo_archivo_temporal (nombre,archivo,estado,fec_reg, user_reg) 
                VALUES ('".$dato['nombre']."','".$ruta."',2,NOW(),$id_usuario)";
        
        $this->db->query($sql);
    }

    function List_preinsert_documento_cargo(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM cargo_archivo_temporal WHERE user_reg='$id_usuario' and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_cargo_archivo_temporal($id_temporal_c){
        $sql = "SELECT * from cargo_archivo_temporal where id_temporal_c=".$id_temporal_c."";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_imagen_cargo_temporal($id_temporal_c){
        $sql = "DELETE FROM cargo_archivo_temporal WHERE id_temporal_c=$id_temporal_c";
        echo $sql;
        $this->db->query($sql);
    }
    function limpiar_temporal_cargo_archivos(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM cargo_archivo_temporal WHERE user_reg=$id_usuario";
        $this->db->query($sql);
    }

    function delete_cargo($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cargo_historial (id_cargo,id_estado,aprobado,editado,observacion,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_cargo']."',63,0,0,'',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_estado_mae($dato){
        $sql = "select * from status_general where id_status_mae='".$dato['id_status_mae']."' and estado=2 ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function consulta_dni($dato){
        $sql = "SELECT * FROM postulantes where nr_documento='".$dato['otro_1']."' and interese like '%L20%' or interese like '%L14%';";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    /*
    function get_row_t2($dato){
        $sql = "SELECT  COUNT( * ) as total, id_tipo, id_subtipo, nom_tipo , nom_subtipo FROM 
                (SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo, t.nom_tipo
                FROM subtipo s
                LEFT JOIN tipo t ON t.id_tipo = s.id_tipo
                where s.rep_redes=1 AND s.id_empresa=".$dato['id_empresa']." and t.id_tipo='20'
                ORDER BY t.nom_tipo, s.nom_subtipo)
                AS tmp_table GROUP BY id_tipo ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/

    function get_id_proyecto($id_proyecto){
        if(isset($id_proyecto) && $id_proyecto > 0){
            $sql = "SELECT *,fec_solicitante AS fecha,DATE_FORMAT(fec_solicitante,'%d/%m/%Y') as fec_solicitante
                    FROM proyecto 
                    WHERE id_proyecto=".$id_proyecto;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_row_ts(){
        $sql = "SELECT * FROM tipo where estado=2 order by nom_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_row_s(){
        $sql = "SELECT * from statusp where estado=1 ORDER BY nom_statusp ASC";
        $query = $this->db->query($sql)->result_Array();
        $numero_filas=$this->db->query($sql)->num_rows();
        return $query;
    }

    function get_usuario_subtipo(){
        $sql = "SELECT * FROM users WHERE id_nivel NOT IN (6) AND estado=2 ORDER BY usuario_codigo";
        $query = $this->db->query($sql)->result_Array();
        //$numero_filas=$this->db->query($sql)->num_rows();
        return $query;
    }

    function get_usuario_subtipo1(){
        $sql = "SELECT * FROM users WHERE id_nivel IN (2,3) AND estado=2 ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_solicitante_c_historico($dato){
        //$sql = "SELECT * FROM users";
        $sql = "SELECT * FROM users WHERE id_nivel IN (1,2,5) ".$dato['soli']." ORDER BY usuario_codigo ASC";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    public function list_subtipo_fbweb_activos($dato){
        $sql = "SELECT * from subtipo  WHERE  id_tipo='".$dato['id_tipo']."' and id_empresa='".$dato['empresas']."' ".$dato['subtipo']." order by nom_subtipo";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa_sede_uno($dato){
        $sql = "SELECT * FROM sede WHERE id_empresa='".$dato['empresas']."' AND estado=2 
                ORDER BY cod_sede ASC";    
        $query = $this->db->query($sql)->result_Array();    
        return $query; 
    }

    function get_id_sede_proyecto($id_proyecto){
        $sql = "SELECT * FROM proyecto_sede WHERE id_proyecto=$id_proyecto AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_base_datoss($tipo=null){
        $parte = "";
        if($tipo==1){
          $parte = "bd.estado=2";
        }else{
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

    function get_list_rubro(){
        $sql = "SELECT * FROM rubro_gl where estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_carpetas($dato=null,$tipo){
        if($tipo==2){
            $varid="where id_carpeta = '".$dato['id_carpeta']."'";
        }else{
            $varid="";
        }
        $sql = "SELECT id_carpeta,nom_carpeta,inicio_carpeta,fin_carpeta,
                case when bloqueo_carpeta = 1 then 'Sí' else 'No' end as bloqueo_carpeta_nombre,
                bloqueo_carpeta,st.nom_status,st.color,c.estado
                FROM carpeta c
                LEFT JOIN status st ON c.estado=st.id_status
                $varid
                ORDER BY nom_carpeta ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_carpeta($dato,$tipo){
        $varid='';
        if($tipo==2){
            $varid="and id_carpeta != '".$dato['id_carpeta']."'";
        }
        $sql = "SELECT id_carpeta from carpeta WHERE nom_carpeta='".$dato['nom_carpeta']."'  and estado=2 $varid";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_carpeta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT carpeta (nom_carpeta,inicio_carpeta,fin_carpeta,bloqueo_carpeta,estado,fec_reg,user_reg) values
        ('".$dato['nom_carpeta']."','".$dato['inicio_carpeta']."','".$dato['fin_carpeta']."','".$dato['bloqueo_carpeta']."','".$dato['estado']."',$id_usuario,NOW())";
        $this->db->query($sql);
    }

    function update_carpeta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE carpeta set nom_carpeta = '".$dato['nom_carpeta']."',inicio_carpeta='".$dato['inicio_carpeta']."',
                fin_carpeta='".$dato['fin_carpeta']."',bloqueo_carpeta='".$dato['bloqueo_carpeta']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario WHERE id_carpeta = '".$dato['id_carpeta']."'";
        echo $sql;
        $this->db->query($sql);
    }

    function delete_carpeta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE carpeta SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_carpeta='".$dato['id_carpeta']."'";
        $this->db->query($sql);
    }

    function get_list_estado_archivos(){
        $sql = "SELECT * FROM status 
                WHERE id_status IN (1,2,3)
                ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 
}