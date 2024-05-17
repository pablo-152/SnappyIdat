<?php
class Model_Laleli extends CI_Model {
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

    function fondo_index(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=7";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede(){ 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT se.id_sede,se.cod_sede FROM usuario_sede ue
                LEFT JOIN sede se ON se.id_sede=ue.id_sede
                LEFT JOIN empresa em ON em.id_empresa=se.id_empresa
                WHERE ue.id_usuario=$id_usuario AND em.id_empresa=7 AND se.aparece_menu=1 AND 
                se.estado=2 AND ue.estado=2
                ORDER BY se.cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_empresa(){
        $sql = "SELECT id_empresa,cod_empresa FROM empresa 
                WHERE estado=2 
                ORDER BY cod_empresa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_sede(){
        $sql = "SELECT id_sede,cod_sede FROM sede 
                WHERE id_empresa=7 AND estado=2 
                ORDER BY cod_sede ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio 
                WHERE estado=1 
                ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario(){
        $sql = "SELECT id_usuario,usuario_codigo FROM users 
                WHERE estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_contabilidad($id_contabilidad=null){
        if(isset($id_contabilidad) && $id_contabilidad > 0){
            $sql = "SELECT * FROM contabilidad 
                    WHERE id_contabilidad=$id_contabilidad";
        }else{
            $sql = "SELECT * FROM contabilidad
                    WHERE estado=1";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_api_maestra($dato){
        $documento="";
        if($dato['tipo_api']==1){
            $documento=",CASE WHEN ".$dato['tipo_doc']."=1 THEN 'dni/'
            WHEN ".$dato['tipo_doc']."=2 THEN 'ruc/'
            END AS documento ";
        }
        if($dato['tipo_api']==2 || $dato['tipo_api']==3){
            $documento=",CASE 
            WHEN ".$dato['tipo_doc']."=1 THEN 'send'
            WHEN ".$dato['tipo_doc']."=2 THEN 'xml'
            WHEN ".$dato['tipo_doc']."=3 THEN 'pdf'
            END AS documento ";
        }
        $sql = "SELECT a.* $documento FROM api_maestra a 
                WHERE a.estado=1 AND a.tipo_api=".$dato['tipo_api'];
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_stock_producto($dato){ 
        $sql = "SELECT stock FROM vista_movimiento_almacen 
                WHERE id_almacen='".$dato['id_almacen']."' AND codigo='".$dato['cod_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_encomiendas_pendientes(){ 
        $sql = "SELECT id_encomienda FROM encomienda 
                WHERE estado_e=0 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cierres_caja_pendientes(){  
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE cerrada=0 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cierres_caja_sin_cofre(){  
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE (cofre='' OR cofre IS NULL) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------TIPO-------------------------------------
    function get_list_tipo($id_tipo=null){
        if(isset($id_tipo) && $id_tipo>0){
            $sql = "SELECT * FROM tipo_la 
                    WHERE id_tipo=$id_tipo";
        }else{
            $sql = "SELECT ti.id_tipo,ti.nom_tipo,st.nom_status,st.color
                    FROM tipo_la ti
                    LEFT JOIN status st ON st.id_status=ti.estado
                    WHERE ti.estado NOT IN (4)
                    ORDER BY ti.nom_tipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_combo(){
        $sql = "SELECT id_tipo,nom_tipo FROM tipo_la
                WHERE estado=2
                ORDER BY nom_tipo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tipo($dato){
        $sql = "SELECT id_tipo FROM tipo_la 
                WHERE nom_tipo='".$dato['nom_tipo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tipo_la (nom_tipo,estado,fec_reg,user_reg) 
                VALUES ('".$dato['nom_tipo']."','".$dato['estado']."',
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_tipo($dato){
        $sql = "SELECT id_tipo FROM tipo_la 
                WHERE nom_tipo='".$dato['nom_tipo']."' AND estado=2 AND 
                id_tipo!='".$dato['id_tipo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_la SET nom_tipo='".$dato['nom_tipo']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_tipo='". $dato['id_tipo']."'";
        $this->db->query($sql);
    }

    function delete_tipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_la SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_tipo='".$dato['id_tipo']."'";
        $this->db->query($sql);
    }
    //-----------------------------------SUBTIPO-------------------------------------
    function get_list_subtipo($id_subtipo=null){
        if(isset($id_subtipo) && $id_subtipo>0){
            $sql = "SELECT * FROM subtipo_la 
                    WHERE id_subtipo=$id_subtipo";
        }else{
            $sql = "SELECT su.id_subtipo,tp.nom_tipo,su.nom_subtipo,st.nom_status,st.color
                    FROM subtipo_la su
                    LEFT JOIN tipo_la tp ON tp.id_tipo=su.id_tipo
                    LEFT JOIN status st ON st.id_status=su.estado
                    WHERE su.estado NOT IN (4)
                    ORDER BY tp.nom_tipo ASC,su.nom_subtipo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_subtipo_combo_tipo($id_tipo){
        $sql = "SELECT id_subtipo,nom_subtipo FROM subtipo_la 
                WHERE id_tipo=$id_tipo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function valida_insert_subtipo($dato){
        $sql = "SELECT id_subtipo FROM subtipo_la 
                WHERE id_tipo='".$dato['id_tipo']."' AND nom_subtipo='".$dato['nom_subtipo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_subtipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO subtipo_la (id_tipo,nom_subtipo,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_tipo']."','".$dato['nom_subtipo']."','".$dato['estado']."',
                NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_subtipo($dato){
        $sql = "SELECT id_subtipo FROM subtipo_la 
                WHERE id_tipo='".$dato['id_tipo']."' AND nom_subtipo='".$dato['nom_subtipo']."' AND estado=2 AND 
                id_subtipo!='".$dato['id_subtipo']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_subtipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE subtipo_la SET id_tipo='".$dato['id_tipo']."',
                nom_subtipo='".$dato['nom_subtipo']."',
                estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario  
                WHERE id_subtipo='". $dato['id_subtipo']."'";
        $this->db->query($sql);
    }

    function delete_subtipo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE subtipo_la SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_subtipo='".$dato['id_subtipo']."'";
        $this->db->query($sql);
    }
    //-----------------------------------TIPO PRODUCTO-------------------------------------
    function get_list_tipo_producto($id_tipo_producto=null){
        if(isset($id_tipo_producto) && $id_tipo_producto>0){
            $sql = "SELECT * FROM tipo_producto_la 
                    WHERE id_tipo_producto=$id_tipo_producto";
        }else{
            $sql = "SELECT tp.id_tipo_producto,tp.cod_tipo_producto,em.cod_empresa,ti.nom_tipo,
                    su.nom_subtipo,tp.descripcion,tp.foto,CASE WHEN tp.foto!='' THEN 'Si' ELSE 'No' END AS v_foto,
                    st.nom_status,st.color
                    FROM tipo_producto_la tp
                    LEFT JOIN empresa em ON em.id_empresa=tp.id_empresa
                    LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                    LEFT JOIN subtipo_la su ON su.id_subtipo=tp.id_subtipo
                    LEFT JOIN status st ON st.id_status=tp.estado
                    WHERE tp.estado NOT IN(4)
                    ORDER BY tp.cod_tipo_producto ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_producto_combo(){
        $sql = "SELECT id_tipo_producto,CONCAT(cod_tipo_producto,'-',descripcion) AS tipo_producto 
                FROM tipo_producto_la 
                WHERE estado=2
                ORDER BY tipo_producto ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_tipo_producto($dato){
        $sql = "SELECT id_tipo_producto FROM tipo_producto_la 
                WHERE cod_tipo_producto='".$dato['cod_tipo_producto']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
 
    function ultimo_id_tipo_producto(){
        $sql = "SELECT id_tipo_producto FROM tipo_producto_la 
                ORDER BY id_tipo_producto DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tipo_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tipo_producto_la (cod_tipo_producto,id_empresa,id_tipo,
                id_subtipo,descripcion,foto,estado,fec_reg,user_reg) 
                VALUES ('".$dato['cod_tipo_producto']."','".$dato['id_empresa']."',
                '".$dato['id_tipo']."','".$dato['id_subtipo']."','".$dato['descripcion']."',
                '".$dato['foto']."','".$dato['estado']."',
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_tipo_producto($dato){
        $sql = "SELECT id_tipo_producto FROM tipo_producto_la 
                WHERE cod_tipo_producto='".$dato['cod_tipo_producto']."' AND estado=2 AND 
                id_tipo_producto!='".$dato['id_tipo_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tipo_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_producto_la SET cod_tipo_producto='".$dato['cod_tipo_producto']."',
                id_empresa='".$dato['id_empresa']."',id_tipo='".$dato['id_tipo']."',
                id_subtipo='".$dato['id_subtipo']."',descripcion='".$dato['descripcion']."',
                foto='".$dato['foto']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_tipo_producto='". $dato['id_tipo_producto']."'";
        $this->db->query($sql);
    }

    function delete_tipo_producto($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tipo_producto_la SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_tipo_producto='".$dato['id_tipo_producto']."'";
        $this->db->query($sql);
    }
    //-----------------------------------TALLA-------------------------------------
    function get_list_talla($id_talla=null){ 
        if(isset($id_talla) && $id_talla>0){
            $sql = "SELECT * FROM talla_la 
                    WHERE id_talla=$id_talla";
        }else{
            $sql = "SELECT ta.id_talla,ta.cod_talla,ta.talla,st.nom_status,st.color
                    FROM talla_la ta
                    LEFT JOIN status st ON st.id_status=ta.estado
                    WHERE ta.estado NOT IN(4)
                    ORDER BY ta.cod_talla ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_talla_combo(){
        $sql = "SELECT id_talla,cod_talla FROM talla_la 
                WHERE estado=2
                ORDER BY cod_talla ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_talla($dato){
        $sql = "SELECT id_talla FROM talla_la 
                WHERE cod_talla='".$dato['cod_talla']."' AND talla='".$dato['talla']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
 
    function insert_talla($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO talla_la (cod_talla,talla,estado,fec_reg,user_reg) 
                VALUES ('".$dato['cod_talla']."','".$dato['talla']."','".$dato['estado']."',
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_talla($dato){
        $sql = "SELECT id_talla FROM talla_la 
                WHERE cod_talla='".$dato['cod_talla']."' AND talla='".$dato['talla']."' AND estado=2 AND 
                id_talla!='".$dato['id_talla']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_talla($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE talla_la SET cod_talla='".$dato['cod_talla']."',talla='".$dato['talla']."',
                estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario  
                WHERE id_talla='". $dato['id_talla']."'";
        $this->db->query($sql);
    }

    function delete_talla($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE talla_la SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_talla='".$dato['id_talla']."'";
        $this->db->query($sql);
    }
    //-----------------------------------PRODUCTO-------------------------------------
    function get_list_producto($tipo){  
        if($tipo==1){
            $parte = "pr.estado=2";
        }elseif($tipo==2){
            $parte = "pr.estado=3";
        }else{
            $parte = "pr.estado NOT IN (4)";
        }
        $sql = "SELECT pr.id_producto,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,
                ti.nom_tipo,su.nom_subtipo,tp.descripcion,ta.talla,CASE WHEN pr.disponible_encomendar=1 
                THEN 'Si' ELSE 'No' END AS v_disponible_encomendar,pr.aviso,
                DATE_FORMAT(pr.desde,'%d-%m-%Y') AS activo_de,DATE_FORMAT(pr.hasta,'%d-%m-%Y') AS a,
                pr.precio_venta,st.nom_status,st.color
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                LEFT JOIN subtipo_la su ON su.id_subtipo=tp.id_subtipo
                LEFT JOIN status st ON st.id_status=pr.estado
                WHERE $parte
                ORDER BY st.nom_status ASC,codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_combo(){
        $sql = "SELECT pr.id_producto,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo 
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.estado=2
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_producto_activo($cod_producto){ 
        $sql = "SELECT pr.id_producto,pr.cod_producto AS codigo,tp.descripcion,ta.talla 
                FROM producto_la pr 
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.cod_producto='$cod_producto' AND pr.estado=2
                ORDER BY pr.id_producto DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_producto($dato){
        $sql = "SELECT id_producto FROM producto_la 
                WHERE id_tipo_producto='".$dato['id_tipo_producto']."' AND id_talla='".$dato['id_talla']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
 
    function insert_producto($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO producto_la (id_tipo_producto,id_talla,cod_producto,
                disponible_encomendar,aviso,desde,hasta,precio_venta,estado,fec_reg,
                user_reg) 
                VALUES ('".$dato['id_tipo_producto']."','".$dato['id_talla']."',
                '".$dato['cod_producto']."','".$dato['disponible_encomendar']."',
                '".$dato['aviso']."','".$dato['desde']."','".$dato['hasta']."',
                '".$dato['precio_venta']."','".$dato['estado']."',
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_producto($id_producto){ 
        $sql = "SELECT pr.*,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,ti.nom_tipo,
                su.nom_subtipo,tp.descripcion,ta.talla,tp.cod_tipo_producto,ta.cod_talla
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                LEFT JOIN subtipo_la su ON su.id_subtipo=tp.id_subtipo
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.id_producto=$id_producto";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_producto($dato){
        $sql = "SELECT id_producto FROM producto_la 
                WHERE id_tipo_producto='".$dato['id_tipo_producto']."' AND id_talla='".$dato['id_talla']."' AND 
                estado=2 AND id_producto!='".$dato['id_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_producto($dato){ 
        //id_tipo_producto='".$dato['id_tipo_producto']."',id_talla='".$dato['id_talla']."',
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_la SET disponible_encomendar='".$dato['disponible_encomendar']."',
                aviso='".$dato['aviso']."',desde='".$dato['desde']."',hasta='".$dato['hasta']."',
                precio_venta='".$dato['precio_venta']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_producto='". $dato['id_producto']."'";
        $this->db->query($sql);
    }

    function delete_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE producto_la SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_producto='".$dato['id_producto']."'";
        $this->db->query($sql);
    }
    //-----------------------------------ALMACÉN-------------------------------------
    function get_list_almacen($tipo){  
        $parte = "";
        if($tipo==1){
            $parte = "AND al.estado=2";
        }

        $sql = "SELECT al.id_almacen,an.nom_anio,em.cod_empresa,se.cod_sede,al.descripcion,re.usuario_codigo AS nom_responsable,
                su.usuario_codigo AS nom_supervisor,en.usuario_codigo AS nom_entrega,ad.usuario_codigo AS nom_administrador,
                al.observaciones,CASE WHEN al.principal=1 THEN 'Si' ELSE 'No' END AS v_principal,st.nom_status,st.color,al.principal,
                al.id_vendedor,(SELECT SUM(vm.stock) FROM vista_movimiento_almacen vm 
                WHERE vm.id_almacen=al.id_almacen) AS stock,
                (SELECT COUNT(*) FROM venta ve 
                WHERE ve.id_almacen=al.id_almacen AND ve.estado=2) AS ventas,
                CASE WHEN al.id_vendedor!='' THEN 'Si' ELSE 'No' END AS v_vendedor,
                CASE WHEN al.doc_sunat=1 THEN 'Si' ELSE 'No' END AS v_doc_sunat,
                CASE WHEN al.trash=1 THEN 'Si' ELSE 'No' END AS v_trash,
                CASE WHEN al.principal=1 THEN (SELECT SUM(cantidad*precio_compra) FROM compra WHERE estado=2) 
                ELSE 0.00 END AS v_compra,
                IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                WHERE ve.id_almacen=al.id_almacen AND ve.estado_venta=1 AND ve.estado=2),0)-
                IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                WHERE ve.id_almacen=al.id_almacen AND ve.estado_venta=3 AND ve.estado=2),0) AS v_venta
                FROM almacen al 
                LEFT JOIN anio an ON an.id_anio=al.id_anio
                LEFT JOIN empresa em ON em.id_empresa=al.id_empresa
                LEFT JOIN sede se ON se.id_sede=al.id_sede
                LEFT JOIN users re ON re.id_usuario=al.id_responsable
                LEFT JOIN users su ON su.id_usuario=al.id_supervisor
                LEFT JOIN users en ON en.id_usuario=al.id_entrega
                LEFT JOIN users ad ON ad.id_usuario=al.id_administrador
                LEFT JOIN status st ON st.id_status=al.estado
                WHERE al.estado NOT IN (4) $parte
                ORDER BY al.principal DESC,an.nom_anio ASC,em.cod_empresa ASC,al.descripcion ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_list_almacen_combo_transferencia($id_almacen,$principal,$id_empresa,$id_vendedor){
        $parte = "AND al.id_vendedor=''";
        if($principal==0){
            if($id_vendedor==''){
                $parte = "AND (al.id_empresa=$id_empresa OR al.id_almacen IN (SELECT id_almacen FROM almacen WHERE principal=1 AND estado=2))";
            }else{
                $parte = "AND al.id_empresa=$id_empresa"; 
            }
        }
        $sql = "SELECT al.id_almacen,al.descripcion,se.cod_sede 
                FROM almacen al
                LEFT JOIN sede se ON se.id_sede=al.id_sede 
                WHERE al.estado=2 AND al.id_almacen NOT IN ($id_almacen) $parte
                ORDER BY se.cod_sede ASC,al.descripcion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_almacen_principal(){
        $sql = "SELECT id_almacen FROM almacen WHERE principal=1 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function update_principal(){
        $sql = "UPDATE almacen SET principal=0";
        $this->db->query($sql);
    }

    function valida_insert_punto_venta_sede($dato){ 
        $sql = "SELECT id_almacen FROM almacen 
                WHERE id_sede='".$dato['id_sede']."' AND id_vendedor!='' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function insert_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO almacen (id_anio,id_empresa,id_sede,descripcion,id_responsable,
                id_supervisor,id_entrega,id_administrador,id_vendedor,observaciones,principal,
                doc_sunat,trash,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_anio']."','".$dato['id_empresa']."','".$dato['id_sede']."',
                '".$dato['descripcion']."','".$dato['id_responsable']."','".$dato['id_supervisor']."',
                '".$dato['id_entrega']."','".$dato['id_administrador']."','".$dato['id_vendedor']."',
                '".$dato['observaciones']."','".$dato['principal']."','".$dato['doc_sunat']."',
                '".$dato['trash']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_almacen($id_almacen){
        $sql = "SELECT * FROM almacen WHERE id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_punto_venta_sede($dato){
        $sql = "SELECT id_almacen FROM almacen 
                WHERE id_sede='".$dato['id_sede']."' AND id_vendedor!='' AND estado=2 AND id_almacen!='".$dato['id_almacen']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function update_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE almacen SET id_anio='".$dato['id_anio']."',id_empresa='".$dato['id_empresa']."',
                id_sede='".$dato['id_sede']."',descripcion='".$dato['descripcion']."',
                id_responsable='".$dato['id_responsable']."',id_supervisor='".$dato['id_supervisor']."',
                id_entrega='".$dato['id_entrega']."',id_administrador='".$dato['id_administrador']."',
                id_vendedor='".$dato['id_vendedor']."',observaciones='".$dato['observaciones']."',
                principal='".$dato['principal']."',doc_sunat='".$dato['doc_sunat']."',
                trash='".$dato['trash']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_almacen='". $dato['id_almacen']."'";
        $this->db->query($sql);
    }

    function delete_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "UPDATE almacen SET estado=4,fec_eli=NOW(),
                user_eli=$id_usuario 
                WHERE id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
    }
    //--------------------------DETALLE ALMACÉN------------------------------
    function get_list_detalle_almacen($id_almacen){
        $sql = "SELECT * FROM vista_movimiento_almacen
                WHERE id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_compra_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO compra (id_producto,cod_producto,fecha_compra,id_anio,
                precio_compra,gasto_arpay,
                cantidad,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_producto']."','".$dato['cod_producto']."',
                '".$dato['fecha_compra']."','".$dato['id_anio']."',
                '".$dato['precio_compra']."','".$dato['gasto_arpay']."',
                '".$dato['cantidad']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_compra(){
        $sql = "SELECT id_compra FROM compra 
                ORDER BY id_compra DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_movimiento_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO movimiento_almacen (tipo,id_compra,id_almacen,id_producto,
                cod_producto,cantidad,fec_movimiento,user_movimiento,estado,fec_reg,user_reg) 
                VALUES ('".$dato['tipo']."','".$dato['id_compra']."','".$dato['id_almacen']."',
                '".$dato['id_producto']."','".$dato['cod_producto']."','".$dato['cantidad']."',
                CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_producto_transferir($id_almacen){
        $sql = "SELECT codigo,nom_tipo,descripcion,talla,stock 
                FROM vista_movimiento_almacen 
                WHERE id_almacen=$id_almacen AND stock>0
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_producto_transferir($id_almacen,$cod_producto){ 
        $sql = "SELECT codigo,nom_tipo,descripcion,talla,stock 
                FROM vista_movimiento_almacen 
                WHERE id_almacen=$id_almacen AND codigo='$cod_producto'
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_stock_transferir_producto($dato){ 
        $sql = "SELECT * FROM vista_movimiento_almacen  
                WHERE id_almacen='".$dato['almacen_actual']."' AND codigo='".$dato['cod_producto']."' AND 
                stock>='".$dato['transferido']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_disponible_transferir($principal,$id_empresa){
        $parte = "";
        if($principal==0){
            $parte = "AND tp.id_empresa=$id_empresa";
        } 
        $sql = "SELECT pr.cod_producto FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                WHERE pr.estado=2 AND tp.estado=2 $parte";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_transferir_producto_de($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO movimiento_almacen (tipo,id_almacen,id_producto,cod_producto,cantidad,
                almacen_movimiento,fec_movimiento,user_movimiento,estado,fec_reg,user_reg)
                VALUES (2,'".$dato['almacen_actual']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['transferido']."','".$dato['id_almacen']."',
                CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_transferir_producto_para($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO movimiento_almacen (tipo,id_almacen,id_producto,cod_producto,cantidad,
                almacen_movimiento,fec_movimiento,user_movimiento,estado,fec_reg,user_reg)
                VALUES (1,'".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['transferido']."','".$dato['almacen_actual']."',
                CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_temporal_retirar_producto($id_almacen){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT td.id_temporal,td.id_producto,td.cod_producto AS codigo,tp.descripcion,
                td.ingresado
                FROM temporal_retirar_producto td
                LEFT JOIN producto_la pr ON pr.id_producto=td.id_producto
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                WHERE td.id_usuario=$id_usuario AND td.id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_producto_almacen($principal,$id_empresa){
        $parte = "";
        if($principal==0){
            $parte = "AND id_empresa=$id_empresa";
        }

        $sql = "SELECT id_tipo_producto,cod_tipo_producto,descripcion,foto
                FROM tipo_producto_la 
                WHERE estado=2 $parte
                ORDER BY descripcion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_tipo($id_tipo_producto,$id_almacen){
        $sql = "SELECT pr.id_producto,pr.cod_producto AS codigo,
                tp.descripcion,ta.talla,pr.precio_venta,IFNULL((SELECT vm.stock FROM vista_movimiento_almacen vm
                WHERE vm.id_almacen=$id_almacen AND vm.codigo=pr.cod_producto),0) AS stock
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.id_tipo_producto=$id_tipo_producto AND pr.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cod_producto($cod_producto,$principal,$id_empresa){
        $parte = "";
        if($principal==0){
            $parte = "AND tp.id_empresa=$id_empresa";
        }
        $sql = "SELECT pr.id_producto,pr.cod_producto AS codigo,tp.descripcion,ta.talla
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.cod_producto='$cod_producto' AND pr.estado=2 $parte
                ORDER BY pr.id_producto DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_temporal_retirar_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_retirar_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."' AND 
                cod_producto='".$dato['cod_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_temporal_retirar_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_retirar_producto (id_usuario,id_almacen,id_producto,
                cod_producto,ingresado) 
                VALUES ($id_usuario,'".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['ingresado']."')";
        $this->db->query($sql);
    }

    function update_temporal_retirar_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE temporal_retirar_producto SET ingresado='".$dato['ingresado']."'
                WHERE id_almacen='".$dato['id_almacen']."' AND cod_producto='".$dato['cod_producto']."' AND 
                id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function delete_temporal_retirar_producto($dato){ 
        $sql = "DELETE FROM temporal_retirar_producto 
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function valida_stock_retirar_producto($dato){
        $sql = "SELECT * FROM vista_movimiento_almacen  
                WHERE id_almacen='".$dato['id_almacen']."' AND codigo='".$dato['cod_producto']."' AND 
                stock>='".$dato['ingresado']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_retirar_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "INSERT INTO movimiento_almacen (tipo,id_almacen,id_producto,cod_producto,
                cantidad,fec_movimiento,user_movimiento,estado,fec_reg,user_reg)
                VALUES (3,'".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['ingresado']."',CURDATE(),$id_usuario,
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_todo_temporal_retirar_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_retirar_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
    }
    //--------------------------MOVIMIENTO ALMACÉN------------------------------
    function get_cod_producto_movimiento($cod_producto){
        $sql = "SELECT pr.id_producto,pr.cod_producto AS codigo,tp.descripcion,ta.talla 
                FROM producto_la pr 
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.cod_producto='$cod_producto'
                ORDER BY pr.id_producto DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_movimiento_almacen($id_almacen,$cod_producto){
        $sql = "SELECT ma.id_movimiento,us.usuario_codigo,DATE_FORMAT(ma.fec_movimiento,'%d-%m-%Y') AS fecha,
                CASE WHEN ma.tipo=1 THEN 'Añadido' WHEN ma.tipo=2 THEN 'Transferencia' 
                WHEN ma.tipo=3 THEN 'Retiro' WHEN ma.tipo=4 THEN 'Venta' WHEN ma.tipo=5 THEN 'Devolución' 
                ELSE '' END AS tipo_movimiento,CASE WHEN ma.tipo IN (1,2) THEN al.descripcion 
                WHEN ma.tipo=3 THEN av.descripcion WHEN ma.tipo IN (4,5) THEN se.cod_sede ELSE '' END AS de_para,
                CASE WHEN av.id_empresa=2 THEN ml.Codigo WHEN av.id_empresa=3 THEN mb.cod_alum 
                WHEN av.id_empresa=4 THEN ms.Codigo WHEN av.id_empresa=6 THEN mf.Codigo ELSE '' END AS Codigo,
                CASE WHEN av.id_empresa=2 THEN ml.Apellido_Paterno WHEN av.id_empresa=3 THEN mb.alum_apater 
                WHEN av.id_empresa=4 THEN ms.Apellido_Paterno WHEN av.id_empresa=6 THEN mf.Apellido_Paterno 
                ELSE '' END AS Ap_Paterno,
                CASE WHEN av.id_empresa=2 THEN ml.Apellido_Materno WHEN av.id_empresa=3 THEN mb.alum_amater 
                WHEN av.id_empresa=4 THEN ms.Apellido_Materno  WHEN av.id_empresa=6 THEN mf.Apellido_Materno 
                ELSE '' END AS Ap_Materno,
                CASE WHEN av.id_empresa=2 THEN ml.Nombre WHEN av.id_empresa=3 THEN mb.alum_nom 
                WHEN av.id_empresa=4 THEN ms.Nombre WHEN av.id_empresa=6 THEN mf.Nombre ELSE '' END AS Nombre,
                CASE WHEN ve.id_tipo_documento=1 THEN 'Recibo' 
                WHEN ve.id_tipo_documento=2 THEN 'Boleta' WHEN ve.id_tipo_documento=3 THEN 'Factura' 
                ELSE '' END AS nom_tipo_documento,ve.cod_venta,ma.cantidad,
                (IFNULL((SELECT SUM(ml.cantidad) FROM movimiento_almacen ml
                WHERE ml.id_almacen=$id_almacen AND ml.cod_producto='$cod_producto' AND ml.estado=2 AND 
                ml.tipo IN (1,5) AND ml.id_movimiento<=ma.id_movimiento),0)-
                IFNULL((SELECT SUM(ml.cantidad) FROM movimiento_almacen ml
                WHERE ml.id_almacen=$id_almacen AND ml.cod_producto='$cod_producto' AND ml.estado=2 AND 
                ml.tipo IN (2,3,4) AND ml.id_movimiento<=ma.id_movimiento),0)) AS saldo,
                ma.fec_reg,ma.cod_producto,DATE_FORMAT(co.fecha_compra,'%d-%m-%Y') AS fec_compra,
                an.nom_anio,co.precio_compra,co.gasto_arpay
                FROM movimiento_almacen ma 
                LEFT JOIN users us ON us.id_usuario=ma.user_movimiento
                LEFT JOIN almacen al ON al.id_almacen=ma.almacen_movimiento
                LEFT JOIN almacen av ON av.id_almacen=ma.id_almacen
                LEFT JOIN sede se ON se.id_sede=av.id_sede
                LEFT JOIN venta ve ON ve.id_venta=ma.id_venta
                LEFT JOIN todos_ll ml ON ml.Id=ve.id_alumno 
                LEFT JOIN todos_ls ms ON ms.Id=ve.id_alumno
                LEFT JOIN todos_l20 mf ON mf.Id=ve.id_alumno
                LEFT JOIN alumno mb ON mb.id_alumno=ve.id_alumno
                LEFT JOIN compra co ON co.id_compra=ma.id_compra
                LEFT JOIN anio an ON an.id_anio=co.id_anio
                WHERE ma.id_almacen=$id_almacen AND ma.cod_producto='$cod_producto' AND ma.estado=2 
                ORDER BY ma.fec_reg DESC"; 
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }
    //-----------------------------------ENTREGA VENTA-------------------------------------
    function get_list_entrega_venta($tipo){
        if($tipo==1){
            $parte = "AND ve.listo=0 AND ve.entregado=0";
        }elseif($tipo==2){
            $parte = "AND ve.listo=1 AND ve.entregado=0";
        }elseif($tipo==3){
            $parte = "AND ve.listo=1 AND ve.entregado=1";
        }

        $sql = "SELECT ve.id_venta,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha,
                CASE WHEN ve.id_empresa=2 THEN CONCAT(ml.Apellido_Paterno,' ',ml.Apellido_Materno,', ',ml.Nombre)
                WHEN ve.id_empresa=3 THEN CONCAT(mb.alum_apater,' ',mb.alum_amater,', ',mb.alum_nom) 
                WHEN ve.id_empresa=4 THEN CONCAT(ms.Apellido_Paterno,' ',ms.Apellido_Materno,', ',ms.Nombre) 
                WHEN ve.id_empresa=6 THEN CONCAT(mf.Apellido_Paterno,' ',mf.Apellido_Materno,', ',mf.Nombre) 
                ELSE '' END AS nom_alumno,CASE WHEN ve.id_tipo_documento=1 THEN 'Recibo' 
                WHEN ve.id_tipo_documento=2 THEN 'Boleta' WHEN ve.id_tipo_documento=3 THEN 'Factura'
                ELSE '' END AS nom_tipo_documento,
                (SELECT SUM(vd.cantidad) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS cantidad,
                (ve.monto_entregado-ve.cambio) AS total,CASE WHEN ve.id_tipo_pago=1 THEN 'Cheque' 
                WHEN ve.id_tipo_pago=2 THEN 'Efectivo' WHEN ve.id_tipo_pago=3 THEN 'Transferencia'
                ELSE '' END AS nom_tipo_pago,us.usuario_codigo
                FROM venta ve
                LEFT JOIN todos_ll ml ON ml.Id=ve.id_alumno
                LEFT JOIN todos_ls ms ON ms.Id=ve.id_alumno
                LEFT JOIN todos_l20 mf ON mf.Id=ve.id_alumno
                LEFT JOIN alumno mb ON mb.id_alumno=ve.id_alumno
                LEFT JOIN users us ON us.id_usuario=ve.user_reg
                WHERE ve.estado=2 $parte";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_venta_lista($dato){
        $sql = "UPDATE venta SET listo=1
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql);
    }

    function update_venta_codigo_verificacion($dato){
        $sql = "UPDATE venta SET tipo_envio='".$dato['tipo_envio']."',correo_sms='".$dato['correo_sms']."',
                codigo_verificacion='".$dato['codigo_verificacion']."'
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql);
    }

    function update_venta_entregada($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE venta SET entregado=1,fec_entregado=NOW(),
                user_entregado=$id_usuario
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql); 
    }
    //-----------------------------------ENCOMIENDAS-------------------------------------
    function get_list_encomienda($tipo){     
        $parte = "";
        if($tipo==1){
            $parte = "AND (en.estado_e=0 AND ve.anulado=0)";
        }
        $sql = "SELECT en.id_encomienda,ve.id_venta,ve.cod_venta,pr.cod_producto,
                CASE WHEN ve.anulado=1 THEN 'Anulado' ELSE (CASE WHEN en.estado_e=1 THEN 'Entregado' ELSE 'Pendiente' END) 
                END AS nom_estado,
                CASE WHEN ve.anulado=1 THEN '#C00000' ELSE (CASE WHEN en.estado_e=1 THEN '#92D050' ELSE '#FF8000' END) 
                END AS color,
                DATE_FORMAT(en.fec_entrega,'%d-%m-%Y') AS fecha_entrega,us.usuario_codigo AS usuario_entrega,
                en.estado_e,ve.id_tipo_documento,ti.nom_tipo,tp.descripcion,ta.talla,CASE WHEN al.id_sede=12 THEN 
                (SELECT vd.stock FROM vista_movimiento_almacen vd
                LEFT JOIN almacen ad ON ad.id_almacen=vd.id_almacen
                WHERE ad.id_vendedor!='' AND ad.id_sede=12 AND en.cod_producto=vd.codigo) WHEN al.id_sede=22 THEN 
                (SELECT vv.stock FROM vista_movimiento_almacen vv
                LEFT JOIN almacen av ON av.id_almacen=vv.id_almacen
                WHERE av.id_vendedor!='' AND av.id_sede=22 AND en.cod_producto=vv.codigo) ELSE '' END AS stock,
                DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_venta,uv.usuario_codigo AS usuario_venta,ve.anulado
                FROM encomienda en
                LEFT JOIN venta ve ON ve.id_venta=en.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                LEFT JOIN producto_la pr ON pr.id_producto=en.id_producto
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                LEFT JOIN users us ON us.id_usuario=en.user_entrega
                LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                LEFT JOIN users uv ON uv.id_usuario=ve.user_reg
                WHERE en.estado=2 $parte
                ORDER BY ve.cod_venta DESC"; 
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_id_encomienda($id_encomienda){  
        $sql = "SELECT en.*,ve.id_almacen FROM encomienda en
                LEFT JOIN venta ve ON ve.id_venta=en.id_venta
                WHERE en.id_encomienda=$id_encomienda";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function entrega_encomienda($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE encomienda SET estado_e=1,fec_entrega=NOW(),
                user_entrega=$id_usuario
                WHERE id_encomienda='".$dato['id_encomienda']."'";
        $this->db->query($sql); 

        $sql2 = "INSERT INTO movimiento_almacen (tipo,id_venta,id_almacen,id_producto,
                cod_producto,cantidad,fec_movimiento,user_movimiento,estado,fec_reg,
                user_reg)
                VALUES (4,'".$dato['id_venta']."','".$dato['id_almacen']."',
                '".$dato['id_producto']."','".$dato['cod_producto']."',1,CURDATE(),
                $id_usuario,2,NOW(),$id_usuario)";
        $this->db->query($sql2); 
    }

    function valida_encomienda_terminada($id_venta){ 
        $sql = "SELECT id_encomienda FROM encomienda 
                WHERE id_venta=$id_venta AND estado=2 AND estado_e=0";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_encomienda_terminada($id_venta){
        $sql = "UPDATE venta SET encomienda=0
                WHERE id_venta=$id_venta";
        $this->db->query($sql); 
    }
    //-----------------------------------VENTA-------------------------------------
    function get_list_venta($id_venta=null){ 
        if(isset($id_venta) && $id_venta>0){
            $sql = "SELECT ve.*,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha,DATE_FORMAT(ve.fec_reg,'%H:%i') AS hora,
                    us.usuario_codigo,CASE WHEN al.id_empresa=2 THEN ml.Codigo WHEN al.id_empresa=4 THEN ms.Codigo
                    WHEN al.id_empresa=6 THEN mf.Codigo ELSE '' END AS cod_alumno,
                    CASE WHEN al.id_empresa=2 THEN CONCAT(ml.Apellido_Paterno,' ',ml.Apellido_Materno,', ',ml.Nombre)
                    WHEN al.id_empresa=3 THEN CONCAT(mb.alum_apater,' ',mb.alum_amater,', ',mb.alum_nom) 
                    WHEN al.id_empresa=4 THEN CONCAT(ms.Apellido_Paterno,' ',ms.Apellido_Materno,', ',ms.Nombre) 
                    WHEN al.id_empresa=6 THEN CONCAT(mf.Apellido_Paterno,' ',mf.Apellido_Materno,', ',mf.Nombre) 
                    ELSE '' END AS nom_alumno,mf.Especialidad,CASE WHEN ve.estado_venta=3 THEN 'Devolución' ELSE 'Recibo' 
                    END AS nro_documento,CASE WHEN ve.estado_venta=3 THEN 'blanco' ELSE 'negro' END AS color_logo,
                    (SELECT IFNULL(SUM(vd.precio*vd.cantidad),0)
                    FROM venta_detalle vd
                    WHERE vd.id_venta=ve.id_venta) AS total,al.id_sede,se.cod_sede
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    LEFT JOIN todos_l20 mf ON mf.Id=ve.id_alumno
                    LEFT JOIN todos_ll ml ON ml.Id=ve.id_alumno
                    LEFT JOIN todos_ls ms ON ms.Id=ve.id_alumno
                    LEFT JOIN alumno mb ON mb.id_alumno=ve.id_alumno
                    LEFT JOIN sede se ON al.id_sede=se.id_sede
                    WHERE ve.id_venta=$id_venta";
        }else{
            $sql = "SELECT ve.id_venta,se.cod_sede,DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha,
                    CASE WHEN al.id_empresa=2 THEN ml.Codigo WHEN al.id_empresa=3 THEN mb.cod_alum 
                    WHEN al.id_empresa=4 THEN ms.Codigo WHEN al.id_empresa=6 THEN mf.Codigo ELSE '' END AS Codigo,
                    CASE WHEN al.id_empresa=2 THEN ml.Apellido_Paterno WHEN al.id_empresa=3 THEN mb.alum_apater 
                    WHEN al.id_empresa=4 THEN ms.Apellido_Paterno WHEN al.id_empresa=6 THEN mf.Apellido_Paterno 
                    ELSE '' END AS Ap_Paterno,
                    CASE WHEN al.id_empresa=2 THEN ml.Apellido_Materno WHEN al.id_empresa=3 THEN mb.alum_amater 
                    WHEN al.id_empresa=4 THEN ms.Apellido_Materno  WHEN al.id_empresa=6 THEN mf.Apellido_Materno 
                    ELSE '' END AS Ap_Materno,
                    CASE WHEN al.id_empresa=2 THEN ml.Nombre WHEN al.id_empresa=3 THEN mb.alum_nom 
                    WHEN al.id_empresa=4 THEN ms.Nombre WHEN al.id_empresa=6 THEN mf.Nombre ELSE '' END AS Nombre,
                    CASE WHEN ve.id_tipo_documento=1 THEN 'Recibo' WHEN ve.id_tipo_documento=2 THEN 'Boleta' 
                    WHEN ve.id_tipo_documento=3 THEN 'Factura' ELSE '' END AS nom_tipo_documento,ve.cod_venta,
                    (SELECT SUM(vd.cantidad) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS cantidad,
                    CASE WHEN ve.estado_venta=3 THEN (-(SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta))
                    ELSE (SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) END AS total,
                    CASE WHEN ve.id_tipo_pago=1 THEN 'Cheque' 
                    WHEN ve.id_tipo_pago=2 THEN 'Efectivo' WHEN ve.id_tipo_pago=3 THEN 'Transferencia'
                    ELSE '' END AS nom_tipo_pago,us.usuario_codigo,DATE_FORMAT(ve.fec_entregado,'%d-%m-%Y') AS fecha_entregado,
                    ue.usuario_codigo AS usuario_entregado,CASE WHEN ve.tipo_envio=1 THEN 'Correo' WHEN ve.tipo_envio=2 THEN 'SMS'
                    ELSE '' END AS nom_tipo_envio,CASE WHEN ve.estado_venta=1 THEN 'Cancelado' WHEN ve.estado_venta=3 THEN 'Anulado' 
                    ELSE '' END AS nom_estado_venta,ve.estado_venta,al.id_responsable,al.id_supervisor,ve.id_tipo_documento,ve.anulado,
                    CASE WHEN ve.estado_venta=1 THEN '#B7AFB8' WHEN ve.estado_venta=3 THEN '#C00000' ELSE '' END AS color,
                    DATE_FORMAT(ve.fec_anulado,'%d-%m-%Y') AS fecha_anulado,ua.usuario_codigo AS usuario_anulado,ve.motivo
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN sede se ON se.id_sede=al.id_sede
                    LEFT JOIN todos_ll ml ON ml.Id=ve.id_alumno 
                    LEFT JOIN todos_ls ms ON ms.Id=ve.id_alumno
                    LEFT JOIN todos_l20 mf ON mf.Id=ve.id_alumno
                    LEFT JOIN alumno mb ON mb.id_alumno=ve.id_alumno
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    LEFT JOIN users ue ON ue.id_usuario=ve.user_entregado
                    LEFT JOIN users ua ON ua.id_usuario=ve.user_anulado
                    WHERE ve.estado=2
                    ORDER BY ve.cod_venta DESC,ve.estado_venta ASC"; 
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_list_venta_detalle($id_venta){ 
        $sql = "SELECT vd.id_producto,vd.cod_producto AS codigo,tp.descripcion,vd.precio,vd.cantidad,
                ta.talla
                FROM venta_detalle vd
                LEFT JOIN producto_la pr ON pr.id_producto=vd.id_producto
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE vd.id_venta=$id_venta";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cierre_caja($id_sede){
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE id_sede=$id_sede AND fecha=CURDATE() AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_aprobar_devolucion($id_vendedor,$id_sede){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];       
        $sql = "SELECT IFNULL(SUM(vd.precio*vd.cantidad),0) AS total 
                FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado_venta=1 AND ve.anulado=0 AND DATE(vd.fec_reg)=CURDATE() AND 
                vd.user_reg=$id_vendedor AND al.id_sede=$id_sede";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_aprobar_devolucion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO devolucion (id_venta,id_usuario,fecha,motivo,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_venta']."','".$dato['id_vendedor']."',CURDATE(),
                '".$dato['motivo']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    //-----------------------------------CIERRES DE CAJA-------------------------------------
    function get_list_cierre_caja($tipo){    
        $parte = ""; 
        if($tipo==1){ 
            $parte = "AND MONTH(ci.fecha)=MONTH(CURDATE()) AND YEAR(ci.fecha)=YEAR(CURDATE())";
        }
 
        $sql = "SELECT ci.id_cierre_caja,ci.fecha,se.cod_sede,um.usuario_codigo AS cod_vendedor,
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
                CASE WHEN MONTH(ci.fecha)=1 THEN CONCAT('ene-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=2 THEN CONCAT('feb-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=3 THEN 
                CONCAT('mar-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=4 THEN CONCAT('abr-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=5 THEN CONCAT('may-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=6 THEN 
                CONCAT('jun-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=7 THEN CONCAT('jul-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=8 THEN CONCAT('ago-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=9 THEN 
                CONCAT('set-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=10 THEN CONCAT('oct-',YEAR(ci.fecha))
                WHEN MONTH(ci.fecha)=11 THEN CONCAT('nov-',YEAR(ci.fecha)) WHEN MONTH(ci.fecha)=12 THEN 
                CONCAT('dic-',YEAR(ci.fecha)) ELSE '' END AS mes_anio
                FROM cierre_caja ci
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN users ur ON ur.id_usuario=ci.user_reg
                WHERE ci.estado NOT IN (4) $parte
                ORDER BY ci.fecha ASC,se.cod_sede ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_cofre_cierre_caja($dato){  
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja SET cofre='".$dato['cofre']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function delete_cierre_caja($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "UPDATE cierre_caja SET estado=4,
                fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }
 
    function get_id_cierre_caja($id_cierre_caja){ 
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
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia
                FROM cierre_caja ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede
                WHERE ci.id_cierre_caja=$id_cierre_caja"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_ingreso_cierre_caja($id_sede,$fecha,$id_vendedor){  
        /*
            $sql = "SELECT CASE WHEN ve.estado_venta=1 THEN 'Venta' ELSE 'Devolución' END AS nom_tipo,ve.cod_venta,
                    (SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS total,
                    DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo 
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    WHERE al.id_sede=$id_sede AND DATE(ve.fec_reg)='$fecha' AND ve.user_reg=$id_vendedor AND 
                    ve.estado=2 AND ve.estado_venta=1";
        */
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

    function get_list_egreso_cierre_caja($id_sede,$fecha,$id_vendedor){   
        /*
            $sql = "SELECT CASE WHEN ve.estado_venta=1 THEN 'Venta' ELSE 'Devolución' END AS nom_tipo,ve.cod_venta,
                    (SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS total,
                    DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo 
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    WHERE al.id_sede=$id_sede AND DATE(ve.fec_reg)='$fecha' AND ve.user_reg=$id_vendedor AND 
                    ve.estado=2 AND ve.estado_venta=3";
        */
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
    //-----------------------------------COMPRA-------------------------------------
    function get_list_compra($id_compra=null){
        if(isset($id_compra) && $id_compra>0){
            $sql = "SELECT co.id_compra,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,ti.nom_tipo,
                    su.nom_subtipo,tp.descripcion,ta.talla,co.fecha_compra,co.id_anio,an.nom_anio,co.precio_compra,
                    co.gasto_arpay,co.cantidad
                    FROM compra co
                    LEFT JOIN producto_la pr ON pr.id_producto=co.id_producto
                    LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                    LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                    LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                    LEFT JOIN subtipo_la su ON su.id_subtipo=tp.id_subtipo
                    LEFT JOIN anio an ON an.id_anio=co.id_anio
                    WHERE co.id_compra=$id_compra"; 
        }else{
            $sql = "SELECT co.id_compra,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,ti.nom_tipo,
                    su.nom_subtipo,tp.descripcion,ta.talla,DATE_FORMAT(co.fecha_compra,'%d-%m-%Y') AS fec_compra,
                    an.nom_anio,co.precio_compra,co.gasto_arpay,co.cantidad,co.fecha_compra
                    FROM compra co
                    LEFT JOIN producto_la pr ON pr.id_producto=co.id_producto
                    LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                    LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                    LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                    LEFT JOIN subtipo_la su ON su.id_subtipo=tp.id_subtipo
                    LEFT JOIN anio an ON an.id_anio=co.id_anio
                    WHERE co.estado=2
                    ORDER BY co.fecha_compra DESC"; 
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function update_compra($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE compra SET fecha_compra='".$dato['fecha_compra']."',
                id_anio='".$dato['id_anio']."',precio_compra='".$dato['precio_compra']."',
                gasto_arpay='".$dato['gasto_arpay']."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_compra='".$dato['id_compra']."'";
        $this->db->query($sql);
    }
    //-----------------------------------STOCK-------------------------------------
    function get_list_stock($id_subtipo=null){ 
        $sql = "SELECT id_producto,codigo,nom_tipo,descripcion,talla,stock_total FROM `vista_movimiento_almacen` 
                GROUP BY id_producto,codigo,nom_tipo,descripcion,talla,stock_total
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 
    //-----------------------------------TRANSFERENCIAS-------------------------------------
    function get_list_informe_transferencia(){ 
        $sql = "SELECT ad.descripcion AS de,ap.descripcion AS para,ma.cod_producto,ma.cantidad, 
                DATE_FORMAT(ma.fec_movimiento,'%d-%m-%Y') AS fecha,us.usuario_codigo AS usuario,
                ma.fec_movimiento
                FROM movimiento_almacen ma
                LEFT JOIN almacen ad ON ad.id_almacen=ma.id_almacen
                LEFT JOIN almacen ap ON ap.id_almacen=ma.almacen_movimiento
                LEFT JOIN users us ON us.id_usuario=user_movimiento
                WHERE ma.id_almacen IN (SELECT al.id_almacen FROM almacen al 
                LEFT JOIN sede se ON se.id_sede=al.id_sede
                WHERE se.cod_sede='LA0' AND al.estado=2) AND ma.tipo=2 AND ma.estado=2
                ORDER BY ma.fec_movimiento DESC"; 
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }
    //-----------------------------------DEVOLUCIÓN-------------------------------------
    function get_list_devolucion($id_devolucion=null){
        if(isset($id_devolucion) && $id_devolucion>0){
            $sql = "SELECT * FROM devolucion 
                    WHERE id_devolucion=$id_devolucion"; 
        }else{ 
            $sql = "SELECT de.id_devolucion,de.fecha AS orden,ve.cod_venta,
                    DATE_FORMAT(de.fecha,'%d-%m-%Y') AS fecha,us.usuario_codigo AS usuario,de.motivo,
                    CASE WHEN de.estado_d=1 THEN '#92D050' WHEN de.estado_d=2 THEN '#C00000' 
                    ELSE '#FF8000' END AS color_estado,
                    CASE WHEN de.estado_d=1 THEN 'Aprobado' WHEN de.estado_d=2 THEN 'Denegado' 
                    ELSE 'Pendiente' END AS nom_estado,de.estado_d
                    FROM devolucion de
                    LEFT JOIN users us ON us.id_usuario=de.id_usuario
                    LEFT JOIN venta ve ON ve.id_venta=de.id_venta
                    WHERE de.estado=2
                    ORDER BY de.fecha DESC"; 
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function update_devolucion($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE devolucion SET estado_d='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_devolucion='".$dato['id_devolucion']."'";
        $this->db->query($sql);
    }

    function insert_devolucion_producto($dato){
        $sql = "INSERT INTO movimiento_almacen (tipo,id_venta,id_almacen,id_producto,cod_producto,
                cantidad,fec_movimiento,user_movimiento,estado,fec_reg,user_reg)
                VALUES (5,'".$dato['id_venta']."','".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['cantidad']."',CURDATE(),'".$dato['id_vendedor']."',
                2,NOW(),'".$dato['id_vendedor']."')";
        $this->db->query($sql);
    }

    function anular_venta($dato){
        $sql = "INSERT INTO venta (cod_venta,id_almacen,id_alumno,id_tipo_documento,dni,nombre,
                ruc,nom_empresa,direccion,ubigeo,distrito,provincia,departamento,fec_emision,
                fec_vencimiento,id_tipo_pago,monto_entregado,cambio,xml,cdrZip,id,code,
                description,notes,estado_venta,motivo,fec_anulado,user_anulado,estado,fec_reg,
                user_reg) 
                SELECT cod_venta,id_almacen,id_alumno,id_tipo_documento,dni,nombre,ruc,nom_empresa,
                direccion,ubigeo,distrito,provincia,departamento,fec_emision,fec_vencimiento,
                id_tipo_pago,monto_entregado,cambio,xml,cdrZip,id,code,description,notes,3,
                '".$dato['motivo']."',NOW(),'".$dato['id_vendedor']."',2,
                NOW(),
                '".$dato['id_vendedor']."' 
                FROM venta
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql);

        $sql2 = "INSERT INTO venta_detalle (id_venta,id_producto,cod_producto,precio,cantidad,
                estado,fec_reg,user_reg) 
                SELECT (SELECT id_venta FROM venta 
                WHERE estado_venta=3 ORDER BY id_venta DESC LIMIT 1),id_producto,
                cod_producto,precio,cantidad,2,NOW(),
                '".$dato['id_vendedor']."'
                FROM venta_detalle
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql2);

        $sql3 = "UPDATE venta SET anulado=1
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql3); 
    }
}