<?php
class Model_Laleli4 extends CI_Model {
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
                WHERE estado=2 ORDER BY cod_empresa ASC";
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
        $sql = "SELECT * FROM anio WHERE estado=1 ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario(){
        $sql = "SELECT id_usuario,CONCAT(usuario_apater,' ',usuario_amater,' ',usuario_nombres) AS nom_usuario,
                usuario_codigo 
                FROM users 
                WHERE estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_codigo(){ 
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users 
                WHERE estado=2 
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_supervisor_administrador(){   
        $sql = "SELECT id_supervisor AS id_usuario FROM almacen 
                WHERE id_sede=21 
                UNION 
                SELECT id_administrador AS id_usuario FROM almacen 
                WHERE id_sede=21 GROUP BY id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_administrador_responsable(){   
        $sql = "SELECT aa.id_administrador AS id_usuario,ua.usuario_codigo AS usuario_codigo 
                FROM almacen aa
                LEFT JOIN users ua ON ua.id_usuario=aa.id_administrador
                WHERE aa.id_sede=21 
                UNION 
                SELECT ar.id_responsable AS id_usuario,ur.usuario_codigo AS usuario_codigo
                FROM almacen ar
                LEFT JOIN users ur ON ur.id_usuario=ar.id_responsable
                WHERE ar.id_sede=21 
                GROUP BY id_usuario,usuario_codigo
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_contabilidad($id_contabilidad=null){
        if(isset($id_contabilidad) && $id_contabilidad > 0){
            $sql = "SELECT * FROM contabilidad WHERE id_contabilidad=$id_contabilidad";
        }else{
            $sql = "SELECT * FROM contabilidad WHERE estado=1";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_api_maestra($dato){
        $documento="";
        if($dato['tipo_api']==1){
            $documento=",case when ".$dato['tipo_doc']."=1 then 'dni/'
            when ".$dato['tipo_doc']."=2 then 'ruc/'
            end as documento ";
        }
        if($dato['tipo_api']==2 || $dato['tipo_api']==3){
            $documento=",case 
            when ".$dato['tipo_doc']."=1 then 'send'
            when ".$dato['tipo_doc']."=2 then 'xml'
            when ".$dato['tipo_doc']."=3 then 'pdf'
            end as documento ";
        }
        $sql = "SELECT a.* $documento FROM api_maestra a 
                WHERE a.estado=1 AND a.tipo_api=".$dato['tipo_api'];
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto($id_producto){ 
        $sql = "SELECT pr.*,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,tp.descripcion,ta.talla 
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE pr.id_producto=$id_producto";
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
    //-----------------------------------ALMACÉN-------------------------------------
    function get_list_almacen($tipo){
        $parte = "";
        if($tipo==1){
            $parte = "AND al.estado=2";
        }

        $sql = "SELECT al.id_almacen,an.nom_anio,em.cod_empresa,se.cod_sede,al.descripcion,re.usuario_codigo AS nom_responsable,
                su.usuario_codigo AS nom_supervisor,en.usuario_codigo AS nom_entrega,ad.usuario_codigo AS nom_administrador,
                al.observaciones,CASE WHEN al.principal=1 THEN 'Si' ELSE 'No' END AS v_principal,st.nom_status,st.color,al.principal,
                al.id_vendedor,al.id_empresa,(SELECT SUM(vm.stock) FROM vista_movimiento_almacen vm 
                WHERE vm.id_almacen=al.id_almacen) AS stock,
                (SELECT COUNT(*) FROM venta ve 
                WHERE ve.id_almacen=al.id_almacen AND ve.estado=2) AS ventas,
                CASE WHEN al.id_vendedor!='' THEN 'Si' ELSE 'No' END AS v_vendedor,
                CASE WHEN al.doc_sunat=1 THEN 'Si' ELSE 'No' END AS v_doc_sunat,
                CASE WHEN al.trash=1 THEN 'Si' ELSE 'No' END AS v_trash
                FROM almacen al 
                LEFT JOIN anio an ON an.id_anio=al.id_anio
                LEFT JOIN empresa em ON em.id_empresa=al.id_empresa
                LEFT JOIN sede se ON se.id_sede=al.id_sede
                LEFT JOIN users re ON re.id_usuario=al.id_responsable
                LEFT JOIN users su ON su.id_usuario=al.id_supervisor
                LEFT JOIN users en ON en.id_usuario=al.id_entrega
                LEFT JOIN users ad ON ad.id_usuario=al.id_administrador
                LEFT JOIN status st ON st.id_status=al.estado
                WHERE al.id_sede=21 AND al.estado NOT IN (4) $parte
                ORDER BY al.principal DESC,an.nom_anio ASC,em.cod_empresa ASC,al.descripcion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_almacen($id_almacen){
        $sql = "SELECT * FROM almacen WHERE id_almacen=$id_almacen";
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
        $sql = "SELECT al.id_almacen,se.cod_sede,al.descripcion 
                FROM almacen al
                LEFT JOIN sede se ON se.id_sede=al.id_sede
                WHERE al.estado=2 AND al.id_almacen NOT IN ($id_almacen) $parte
                ORDER BY se.cod_sede ASC,al.descripcion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_almacen($id_almacen){
        $sql = "SELECT * FROM vista_movimiento_almacen
                WHERE id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
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

    function get_list_tipo_producto_almacen($id_empresa){
        $sql = "SELECT id_tipo_producto,cod_tipo_producto,descripcion,foto
                FROM tipo_producto_la 
                WHERE estado=2 AND id_empresa=$id_empresa 
                ORDER BY descripcion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto_tipo($id_tipo_producto,$id_almacen){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT pr.id_producto,pr.cod_producto AS codigo,pr.id_tipo_producto,
                tp.descripcion,ta.talla,pr.precio_venta,IFNULL((SELECT vm.stock FROM vista_movimiento_almacen vm
                WHERE vm.id_almacen=$id_almacen AND vm.codigo=pr.cod_producto),0) AS stock,
                (SELECT nv.cantidad FROM nueva_venta_producto nv
                WHERE nv.cod_producto=pr.cod_producto AND nv.id_almacen=$id_almacen AND 
                nv.id_usuario=$id_usuario) AS cantidad
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
                WHERE id_almacen='".$dato['id_almacen']."' AND cod_producto='".$dato['cod_producto']."' AND id_usuario=$id_usuario";
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
        $sql = "INSERT INTO movimiento_almacen (tipo,id_almacen,id_producto,cod_producto,cantidad,fec_movimiento,
                user_movimiento,estado,fec_reg,user_reg)
                VALUES (3,'".$dato['id_almacen']."','".$dato['id_producto']."','".$dato['cod_producto']."',
                '".$dato['ingresado']."',CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
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
    //-----------------------------------NUEVA VENTA-------------------------------------
    function get_punto_venta(){
        $sql = "SELECT id_almacen,id_empresa,id_vendedor,doc_sunat
                FROM almacen
                WHERE id_sede=21 AND estado=2 AND id_vendedor!=''";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_nueva_venta($id_almacen){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta 
                WHERE id_usuario=$id_usuario AND id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_nueva_venta($id_almacen){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO nueva_venta (id_usuario,id_almacen,id_tipo_documento) 
                VALUES ($id_usuario,$id_almacen,1)";
        $this->db->query($sql);
    }

    function resetear_nueva_venta($id_almacen){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta SET id_almacen=$id_almacen,id_alumno=0,tipo_alumno=0,id_tipo_documento=1,
                dni='',nombre='',ruc='',nom_empresa='',direccion='',ubigeo='',distrito='',provincia='',
                departamento='',fec_emision=NULL,fec_vencimiento=NULL
                WHERE id_usuario=$id_usuario AND id_almacen=$id_almacen";
        $this->db->query($sql);
        $sql2 = "DELETE FROM nueva_venta_producto 
                WHERE id_usuario=$id_usuario AND id_almacen=$id_almacen";
        $this->db->query($sql2);
    }

    function get_list_alumno_nueva_venta($id_empresa,$id_alumno,$tipo_alumno){
        $sql = "CALL datos_venta_la ($id_empresa,$id_alumno,$tipo_alumno)";
        $query = $this->db->query($sql)->result_Array();
        mysqli_next_result($this->db->conn_id);
        return $query;
    }

    function get_list_producto_nueva_venta($id_almacen){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT nv.id_nueva_venta_producto,nv.cod_producto AS codigo,tp.descripcion,
                ta.talla,nv.cantidad,nv.precio,CASE WHEN SUBSTRING(nv.precio,1,1)='-' THEN SUBSTRING(nv.precio,2) ELSE '' END AS descuento
                FROM nueva_venta_producto nv 
                LEFT JOIN producto_la pr ON pr.id_producto=nv.id_producto
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                WHERE nv.id_usuario=$id_usuario AND nv.id_almacen=$id_almacen AND nv.cantidad>0
                ORDER BY codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nueva_venta($id_almacen){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta 
                WHERE id_usuario=$id_usuario AND id_almacen=$id_almacen";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_alumno_nueva_venta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta SET id_alumno='".$dato['id_alumno']."',
                tipo_alumno='".$dato['tipo_alumno']."'
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
    }

    function delete_alumno_nueva_venta($id_almacen){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta SET id_alumno=0
                WHERE id_usuario=$id_usuario AND id_almacen=$id_almacen";
        $this->db->query($sql);
    } 
    
    function get_cod_producto_nueva_venta($id_almacen,$cod_producto,$tipo_alumno){ 
        $parte = "";
        /*if($tipo_alumno==2){
            $parte = "AND vm.nom_subtipo='Colaborador'";
        }*/
        $sql = "SELECT vm.codigo,vm.nom_tipo,vm.descripcion,vm.talla,pr.id_producto,pr.precio_venta,
                pr.disponible_encomendar
                FROM vista_movimiento_almacen vm
                LEFT JOIN producto_la pr ON pr.cod_producto=vm.codigo AND pr.estado=2
                WHERE vm.id_almacen=$id_almacen AND vm.codigo='$cod_producto' $parte AND pr.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_modal_producto_nueva_venta($dato){
        $sql = "UPDATE nueva_venta_producto SET cantidad='".$dato['cantidad']."'
                WHERE id_nueva_venta_producto='".$dato['id_nueva_venta_producto']."'";
        $this->db->query($sql);
    }

    function valida_insert_nueva_venta_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."' AND 
                cod_producto='".$dato['cod_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_nueva_venta_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO nueva_venta_producto (id_usuario,id_almacen,id_producto,cod_producto,
                precio,cantidad) 
                VALUES ($id_usuario,'".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['precio']."',1)";
        $this->db->query($sql);
    }

    function update_nueva_venta_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta_producto SET precio='".$dato['precio']."',cantidad='".$dato['cantidad']."'
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."' AND cod_producto='".$dato['cod_producto']."'";
        $this->db->query($sql);
    }

    function delete_nueva_venta_producto($dato){ 
        $sql = "DELETE FROM nueva_venta_producto WHERE id_nueva_venta_producto='".$dato['id_nueva_venta_producto']."'";
        $this->db->query($sql);
    }

    function update_facturacion_nueva_venta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE nueva_venta SET id_tipo_documento='".$dato['id_tipo_documento']."',dni='".$dato['dni']."',
                nombre='".$dato['nombre']."',ruc='".$dato['ruc']."',nom_empresa='".$dato['nom_empresa']."',
                direccion='".$dato['direccion']."',ubigeo='".$dato['ubigeo']."',distrito='".$dato['distrito']."',
                provincia='".$dato['provincia']."',departamento='".$dato['departamento']."',
                fec_emision='".$dato['fec_emision']."',fec_vencimiento='".$dato['fec_vencimiento']."'
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql); 
    }

    function cantidad_recibo(){
        $sql = "SELECT * FROM venta 
                WHERE id_tipo_documento=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cantidad_boleta(){
        $sql = "SELECT * FROM venta  
                WHERE id_tipo_documento=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cantidad_factura(){
        $sql = "SELECT * FROM venta 
                WHERE id_tipo_documento=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_venta($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta (cod_venta,id_almacen,id_alumno,tipo_alumno,id_tipo_documento,dni,nombre,
                ruc,nom_empresa,direccion,ubigeo,distrito,provincia,departamento,fec_emision,fec_vencimiento,
                id_tipo_pago,monto_entregado,cambio,xml,cdrZip,id,code,description,notes,estado_venta,estado,
                fec_reg,user_reg) 
                SELECT '".$dato['cod_venta']."',id_almacen,id_alumno,tipo_alumno,id_tipo_documento,dni,nombre,
                ruc,nom_empresa,direccion,ubigeo,distrito,provincia,departamento,fec_emision,fec_vencimiento,
                '".$dato['id_tipo_pago']."','".$dato['monto_entregado']."','".$dato['cambio']."',
                '".$dato['xml']."','".$dato['cdrZip']."','".$dato['id']."','".$dato['code']."',
                '".$dato['description']."','".$dato['notes']."',1,2,NOW(),
                $id_usuario 
                FROM nueva_venta 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
    }

    function ultimo_id_venta(){
        $sql = "SELECT id_venta FROM venta ORDER BY id_venta DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function insert_venta_detalle($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO venta_detalle (id_venta,id_producto,cod_producto,precio,cantidad,estado,fec_reg,user_reg) 
                SELECT '".$dato['id_venta']."',id_producto,cod_producto,precio,cantidad,2,NOW(),$id_usuario 
                FROM nueva_venta_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
    }

    function get_list_nueva_venta_producto($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM nueva_venta_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_stock_producto($dato){
        $sql = "SELECT stock FROM vista_movimiento_almacen 
                WHERE id_almacen='".$dato['id_almacen']."' AND codigo='".$dato['cod_producto']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_encomienda($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO encomienda (id_venta,id_producto,cod_producto,encomienda,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_venta']."','".$dato['id_producto']."','".$dato['cod_producto']."',1,2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_venta_encomienda($dato){
        $sql = "UPDATE venta SET encomienda=1 
                WHERE id_venta='".$dato['id_venta']."'";
        $this->db->query($sql); 
    }

    function insert_venta_almacen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO movimiento_almacen (tipo,id_venta,id_almacen,id_producto,cod_producto,cantidad,fec_movimiento,
                user_movimiento,estado,fec_reg,user_reg)
                VALUES (4,'".$dato['id_venta']."','".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."','".$dato['cantidad']."',CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function delete_nueva_venta($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "DELETE FROM nueva_venta 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql);
        
        $sql2 = "DELETE FROM nueva_venta_producto 
                WHERE id_usuario=$id_usuario AND id_almacen='".$dato['id_almacen']."'";
        $this->db->query($sql2);
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
        $sql = "UPDATE venta SET entregado=1,fec_entregado=NOW(),user_entregado=$id_usuario
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
                en.estado_e,ve.id_tipo_documento,ti.nom_tipo,tp.descripcion,ta.talla,(SELECT vm.stock FROM vista_movimiento_almacen vm
                LEFT JOIN almacen al ON al.id_almacen=vm.id_almacen
                WHERE al.id_vendedor!='' AND al.id_sede=21 AND en.cod_producto=vm.codigo) AS stock,
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
                WHERE al.id_sede=21 AND en.estado=2 $parte
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
        $sql = "UPDATE encomienda SET estado_e=1,fec_entrega=NOW(),user_entrega=$id_usuario
                WHERE id_encomienda='".$dato['id_encomienda']."'";
        $this->db->query($sql); 

        $sql2 = "INSERT INTO movimiento_almacen (tipo,id_venta,id_almacen,id_producto,cod_producto,
                cantidad,fec_movimiento,user_movimiento,estado,fec_reg,user_reg)
                VALUES (4,'".$dato['id_venta']."','".$dato['id_almacen']."','".$dato['id_producto']."',
                '".$dato['cod_producto']."',1,CURDATE(),$id_usuario,2,NOW(),$id_usuario)";
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
    function get_list_venta($id_almacen){  
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
                WHERE ve.id_almacen=$id_almacen AND ve.estado=2
                ORDER BY ve.cod_venta DESC,ve.estado_venta ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_id_venta($id_venta){
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
                WHERE ci.id_sede=21 AND ci.estado NOT IN (4) $parte
                ORDER BY ci.fecha ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function get_saldo_automatico($id_vendedor,$fecha){ 
        $sql = "SELECT IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=1 AND al.id_sede=21),0) AS venta_diaria,
                IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=3 AND al.id_sede=21),0) AS devolucion_diaria,
                (IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=1 AND al.id_sede=21),0)-
                IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=3 AND al.id_sede=21),0)) AS saldo_automatico";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_productos($id_vendedor,$fecha){  
        $sql = "SELECT IFNULL((SELECT SUM(vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=1 AND al.id_sede=21),0)-
                IFNULL((SELECT SUM(vd.cantidad) FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.user_reg=$id_vendedor AND DATE(ve.fec_reg)='$fecha' AND ve.estado=2 AND ve.estado_venta=3 AND al.id_sede=21),0) AS productos";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_cierre_caja($dato){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE id_sede=21 AND id_vendedor='".$dato['id_vendedor']."' AND 
                fecha='".$dato['fecha']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_venta_cierre_caja($dato){ 
        $sql = "SELECT COUNT(1) AS cantidad FROM venta ve
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.user_reg='".$dato['id_vendedor']."' AND 
                DATE(ve.fec_reg)='".$dato['fecha_valida']."' AND al.id_sede=21";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_devoluciones_cierre_caja($dato){ 
        $sql = "SELECT COUNT(1) AS cantidad FROM devolucion de
                LEFT JOIN venta ve ON ve.id_venta=de.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE de.estado=2 AND de.id_usuario='".$dato['id_vendedor']."' AND 
                de.estado_d=0 AND al.id_sede=21";
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }

    function valida_ultimo_cierre_caja($dato){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE id_sede=21 AND id_vendedor='".$dato['id_vendedor']."' AND 
                fecha=DATE_SUB('".$dato['fecha']."',INTERVAL 1 DAY) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_cierre_caja($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO cierre_caja (id_sede,id_vendedor,fecha,saldo_automatico,monto_entregado,id_entrega,cofre,
                productos,cerrada,estado,fec_reg,user_reg)  
                VALUES (21,'".$dato['id_vendedor']."','".$dato['fecha']."','".$dato['saldo_automatico']."',
                '".$dato['monto_entregado']."','".$dato['id_entrega']."','".$dato['cofre']."','".$dato['productos']."',
                1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_cierre_caja(){ 
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE id_sede=21
                ORDER BY id_cierre_caja DESC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function update_cierre_caja($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "UPDATE cierre_caja SET monto_entregado='".$dato['monto_entregado']."',id_entrega='".$dato['id_entrega']."',
                cofre='".$dato['cofre']."',cerrada=1,fec_reg=NOW(),user_reg=$id_usuario,fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function update_cofre_cierre_caja($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE cierre_caja SET cofre='".$dato['cofre']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function delete_cierre_caja($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = "UPDATE cierre_caja SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_cierre_caja='".$dato['id_cierre_caja']."'";
        $this->db->query($sql);
    }

    function valida_cierre_caja($id_vendedor){
        $sql = "SELECT id_cierre_caja FROM cierre_caja 
                WHERE id_sede=21 AND id_vendedor=$id_vendedor AND fecha=CURDATE() AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_cierre_caja($id_cierre_caja){  
        $sql = "SELECT ci.*,DATE_FORMAT(ci.fecha,'%d-%m-%Y') AS caja,DATE_FORMAT(ci.fec_reg,'%d-%m-%Y %H:%i') AS fecha_cierre,
                DATE_FORMAT(ci.fec_reg,'%H:%i') AS hora,um.usuario_codigo AS cod_vendedor,un.usuario_codigo AS cod_entrega,
                se.cod_sede,se.observaciones_sede AS nom_sede,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=21),0) AS ingresos,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=21),0) AS egresos,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS recibos,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=1 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS total_recibos,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=2 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS boletas,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=2 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS total_boletas,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=3 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS facturas,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=1 AND ve.id_tipo_documento=3 AND DATE(ve.fec_reg)=ci.fecha AND 
                ve.user_reg=ci.id_vendedor AND al.id_sede=21),0) AS total_facturas,
                IFNULL((SELECT COUNT(1) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=21),0) AS devoluciones,
                IFNULL((SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd 
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                WHERE ve.estado=2 AND ve.estado_venta=3 AND DATE(ve.fec_reg)=ci.fecha AND ve.user_reg=ci.id_vendedor AND 
                al.id_sede=21),0) AS total_devoluciones,
                (ci.saldo_automatico-ci.monto_entregado) AS diferencia
                FROM cierre_caja ci
                LEFT JOIN users um ON um.id_usuario=ci.id_vendedor
                LEFT JOIN users un ON un.id_usuario=ci.id_entrega
                LEFT JOIN sede se ON se.id_sede=ci.id_sede 
                WHERE ci.id_cierre_caja=$id_cierre_caja";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
 
    function get_list_ingreso_cierre_caja($fecha,$id_vendedor){ 
        /*
            $sql = "SELECT CASE WHEN ve.estado_venta=1 THEN 'Venta' ELSE 'Devolución' END AS nom_tipo,ve.cod_venta,
                    (SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS total,
                    DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo 
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    WHERE al.id_sede=21 AND DATE(ve.fec_reg)='$fecha' AND ve.user_reg=$id_vendedor AND 
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
                WHERE al.id_sede=21 AND DATE(ve.fec_reg)='$fecha' AND 
                ve.user_reg=$id_vendedor AND ve.estado=2 AND ve.estado_venta=1
                ORDER BY Codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_egreso_cierre_caja($fecha,$id_vendedor){  
        /*
            $sql = "SELECT CASE WHEN ve.estado_venta=1 THEN 'Venta' ELSE 'Devolución' END AS nom_tipo,ve.cod_venta,
                    (SELECT SUM(vd.cantidad*vd.precio) FROM venta_detalle vd WHERE vd.id_venta=ve.id_venta) AS total,
                    DATE_FORMAT(ve.fec_reg,'%d-%m-%Y') AS fecha_pago,us.usuario_codigo 
                    FROM venta ve
                    LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                    LEFT JOIN users us ON us.id_usuario=ve.user_reg
                    WHERE al.id_sede=21 AND DATE(ve.fec_reg)='$fecha' AND ve.user_reg=$id_vendedor AND 
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
                WHERE al.id_sede=21 AND DATE(ve.fec_reg)='$fecha' AND 
                ve.user_reg=$id_vendedor AND ve.estado=2 AND ve.estado_venta=3
                ORDER BY Codigo ASC";
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
                WHERE se.cod_sede='LA4' AND al.estado=2) AND ma.tipo=2 AND ma.estado=2
                ORDER BY ma.fec_movimiento DESC"; 
        $query = $this->db->query($sql)->result_Array(); 
        return $query;
    }
    function insert_fotocheck_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO fotocheck_colaborador (Id,Fecha_Pago_Fotocheck,Monto_Pago_Fotocheck,Doc_Pago_Fotocheck,
                esta_fotocheck,fec_reg,user_reg)
                VALUES ('".$dato['id_alumno']."',DATE(NOW()),'".$dato['monto']."','".$dato['cod_venta']."',0,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    // ---------------------------------- VALIDAR COMPRA DE FOTOCHECK -----------------------------

    function  get_venta_detalle_xproducto($dato){
        $sql = "SELECT vd.*,ve.id_alumno,(vd.precio) AS monto,ve.cod_venta
                FROM venta_detalle vd
                LEFT JOIN venta ve ON ve.id_venta=vd.id_venta
                WHERE vd.id_venta=".$dato['id_venta']." AND (vd.cod_producto='BL08-00000' or vd.cod_producto='BL09-00000')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
}