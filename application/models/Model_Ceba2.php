<?php
class Model_Ceba2 extends CI_Model {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }
    //--------------------------------------------GENERAL-------------------------------
    function get_confg_fondo(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=5";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estado(){
        $sql = "SELECT * FROM status WHERE estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_tipo_festivo(){
        $sql = "select * from tipo_fecha where estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_list_nivel($id_nivel=null){
        if(isset($id_nivel) && $id_nivel > 0){
            $sql = "select * from nivel where estado=1 and id_nivel =".$id_nivel;
        }
        else
        {
            $sql = "select * from nivel where estado=1";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede(){
        $sql = "SELECT * FROM sede WHERE id_empresa=5 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

  //  ---------------------------------------------------

    function get_color_tipo_festivo($id_tipo_fecha){
        $sql = "select * from tipo_fecha where id_tipo_fecha=$id_tipo_fecha and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-------------------------------------------------------------------------------------------------------
    function get_list_anio(){
        $sql = "SELECT id_anio,nom_anio FROM anio ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_unidad(){
        $sql = "select nom_unidad, id_unidad 
        from unidad where estado='2'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_tema_asociar_collapse($id_tema_asociar_collapse){
        if(isset($id_tema_asociar_collapse) && $id_tema_asociar_collapse > 0){
            $sql = "select t.*,g.referencia,g.desc_tema from tema_asociar_collapse t
            left join tema  g on t.id_tema=g.id_tema  

            where id_tema_asociar_collapse =".$id_tema_asociar_collapse;

            $query = $this->db->query($sql)->result_Array();
        return $query;
        }
    }
    //---------------------------------------------------------------------------------------
    function get_list_temas(){
        $sql = "select g.descripcion_grado,t.id_tema,t.referencia, a.descripcion_area,t.desc_tema,s.nom_status,u.nom_unidad,asi.descripcion_asignatura,t.id_unidad
        from tema t
        left join grado       g on t.id_grado=g.id_grado
        left join area        a on t.id_area=a.id_area
        left join status      s on t.estado=s.id_status
        left join unidad      u on t.id_unidad=u.id_unidad
        left join asignatura  asi on t.id_asignatura=asi.id_asignatura";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_slide(){
        $sql = "select sl.*, s.nom_status from tipo_slide sl
                LEFT JOIN status s on sl.estado=s.id_status
                ORDER BY nom_tipo_slide ASC";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_list_area(){
        $sql = "select * from area";
          $query = $this->db->query($sql)->result_Array();
          return $query;
    }

    function get_list_requisito_curso_edson($id_curso){
        $sql="select r.*, tr.nom_tipo_requisito, s.nom_status 
        from requisito r
        left join tipo_requisito tr on r.id_tipo_requisito=tr.id_tipo_requisito
        left join status s on r.estado=s.id_status
        where id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_read_collapse($id_curso){
        $sql="select r.*, tr.nom_tipo_requisito, s.nom_status 
        from tema_asociar_collapse r
        left join tipo_requisito tr on r.id_tipo_requisito=tr.id_tipo_requisito
        left join status s on r.estado=s.id_status
        where id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function get_list_alumno_asociar_curso_excel($id_curso){
        $sql="select al.*, u.nom_unidad,a.descripcion_area,ea.*,ea.nom_estadoa 
        from alumno_asociar r
        left join alumnos al on r.id_alumno=al.id_alumno
        left join unidad u on r.id_unidad=u.id_unidad
        left join area a on r.id_area=a.id_area
        left join estadoa ea on ea.id_estadoa=al.estado_alum
        where id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------------------------------------------------------------------
    function get_list_referencia($id_tema=null){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "select * from tema where t.estado IN (2) and id_tema=$id_tema ORDER BY referencia ASC";
        }
        else
        {
            $sql = "select * from tema where estado IN (2) ORDER BY referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo(){
        $sql = "select * from tipo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //-------------------------------------------------------------------------//
    //---------busqueda de datos de 1 a 4 de secundaria e inactivos------------//
    function list_sub_1_secundaria(){
        $sql = "select tt.*,t.*,
        i.id_intro,i.orden,i.user_subido, 
        sl.id_slide,sl.orden,sl.tiempo,sl.user_subido, 
        r.id_repaso,r.orden,r.tiempo,r.user_subido, 
        e.id_examen,e.tiempo,e.user_subido, 
        s.*, 
        g.id_grado 
        from tipo_tema tt 
        left join tema t on tt.id_tema=t.id_tema 
        left join grado g on tt.id_grado=g.id_grado 
        left join intro i on tt.id_intro=i.id_intro 
        left join slide sl on tt.id_slide=sl.id_slide 
        left join repaso r on tt.id_repaso=r.id_repaso 
        left join examen e on tt.id_examen=e.id_examen 
        left join status s on tt.estado_tipo_tema=s.id_status 
        
        where tt.estado_tipo_tema IN (1,2,3) and t.id_grado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
       
    }
    //-------------------------------------------------------------------------
    function list_sub_2_secundaria(){
        $sql = "SELECT tt.*,t.*,
        i.id_intro,i.orden,i.user_subido, 
        sl.id_slide,sl.orden,sl.tiempo,sl.user_subido, 
        r.id_repaso,r.orden,r.tiempo,r.user_subido, 
        e.id_examen,e.tiempo,e.user_subido, 
        s.*, 
        g.id_grado 
        from tipo_tema tt 
        left join tema t on tt.id_tema=t.id_tema 
        left join grado g on tt.id_grado=g.id_grado 
        left join intro i on tt.id_intro=i.id_intro 
        left join slide sl on tt.id_slide=sl.id_slide 
        left join repaso r on tt.id_repaso=r.id_repaso 
        left join examen e on tt.id_examen=e.id_examen 
        left join status s on tt.estado_tipo_tema=s.id_status 
        
        where tt.estado_tipo_tema IN (2) and t.id_grado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //----------------------------------------------------------------------
    function list_sub_3_secundaria(){
        $sql = "select tt.*,t.*,
        i.id_intro,i.orden,i.user_subido, 
        sl.id_slide,sl.orden,sl.tiempo,sl.user_subido, 
        r.id_repaso,r.orden,r.tiempo,r.user_subido, 
        e.id_examen,e.tiempo,e.user_subido, 
        s.*, 
        g.id_grado 
        from tipo_tema tt 
        left join tema t on tt.id_tema=t.id_tema 
        left join grado g on tt.id_grado=g.id_grado 
        left join intro i on tt.id_intro=i.id_intro 
        left join slide sl on tt.id_slide=sl.id_slide 
        left join repaso r on tt.id_repaso=r.id_repaso 
        left join examen e on tt.id_examen=e.id_examen 
        left join status s on tt.estado_tipo_tema=s.id_status 
        
        where tt.estado_tipo_tema IN (1,2,3) and t.id_grado=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
       
    }
    //-----------------------------------------------------------------------
    function list_sub_4_secundaria(){
        $sql = "select tt.*,t.*,
        i.id_intro,i.orden,i.user_subido, 
        sl.id_slide,sl.orden,sl.tiempo,sl.user_subido, 
        r.id_repaso,r.orden,r.tiempo,r.user_subido, 
        e.id_examen,e.tiempo,e.user_subido, 
        s.*, 
        g.id_grado 
        from tipo_tema tt 
        left join tema t on tt.id_tema=t.id_tema 
        left join grado g on tt.id_grado=g.id_grado 
        left join intro i on tt.id_intro=i.id_intro 
        left join slide sl on tt.id_slide=sl.id_slide 
        left join repaso r on tt.id_repaso=r.id_repaso 
        left join examen e on tt.id_examen=e.id_examen 
        left join status s on tt.estado_tipo_tema=s.id_status 
        
        where tt.estado_tipo_tema IN (1,2,3) and t.id_grado=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
       
    }
    //-----------------------------------------------------------------------
    function list_sub_5_secundaria(){
        $sql = "select tt.*,t.*,
        i.id_intro,i.orden,i.user_subido, 
        sl.id_slide,sl.orden,sl.tiempo,sl.user_subido, 
        r.id_repaso,r.orden,r.tiempo,r.user_subido, 
        e.id_examen,e.tiempo,e.user_subido, 
        s.*, 
        g.id_grado 
        from tipo_tema tt 
        left join tema t on tt.id_tema=t.id_tema 
        left join grado g on tt.id_grado=g.id_grado 
        left join intro i on tt.id_intro=i.id_intro 
        left join slide sl on tt.id_slide=sl.id_slide 
        left join repaso r on tt.id_repaso=r.id_repaso 
        left join examen e on tt.id_examen=e.id_examen 
        left join status s on tt.estado_tipo_tema=s.id_status 
        
        where tt.estado_tipo_tema =3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
       
    }
    //-----------------------------------------------------------------------------//
    //---------Fin busqueda de datos de 1 a 4 de secundaria e inactivos------------//
    function get_list_intro(){
            $sql = "SELECT * from intro  where estado='2'";

            $query = $this->db->query($sql)->result_Array();
            return $query;
    }
    function get_list_slide(){
        $sql = "SELECT * from slide  where estado ='2'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_repaso(){
        $sql = "SELECT * from repaso  where estado ='2'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_examen(){
        $sql = "SELECT * from examen  where estado ='2'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function v_peso_repaso($id_tema){
        $sql = "SELECT * from suma_peso_repaso where id_tema=$id_tema";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function peso_intro($id_tema){
        $sql = "SELECT sum(peso1+peso2+peso3) AS total_intro from intro where id_tema=$id_tema and estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_examen($dato){
    
        $sql="SELECT * from examen where id_grado='".$dato['id_grado']."' and estado=2 and id_tema='".$dato['referencia']."' ";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_examen(){
        $sql = "SELECT * from tipo_examen where estado=1";
          $query = $this->db->query($sql)->result_Array();
          return $query;
    }
    //-----------------------------------------------------------------------
        /*alumno*/
    //----------------------------------------------------------------------------------
    function get_list_todo_alumno_excel(){
        $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro 
        from alumnos ap 
        left join departamento d on ap.id_departamentoa =d.id_departamento 
        left join provincia p on ap.id_provinciaa=p.id_provincia 
        left join distrito i on ap.id_distritoa=i.id_distrito 
        left join estadoa s on ap.estado_alum=s.id_estadoa
        left join unidad u on ap.id_unidad=u.id_unidad
        left join users usu on ap.user_reg=usu.id_usuario
        left join matricula ma on ap.id_matricula=ma.id_matricula
        left join grado gr on ap.id_grados_activos=gr.id_grado
        left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8
        GROUP BY ap.id_alumno ORDER BY ap.fec_reg DESC";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    Public function getprovincia($id_departamento){
        $query = $this->db->query("SELECT * from provincia  WHERE id_departamento='$id_departamento' and estado=2 order by 	nombre_provincia");
        return $query->result_array();
      }

    Public function get_sub_provincia($id_departamento, $id_provincia){
        $query = $this->db->query("SELECT * from distrito  WHERE id_departamento='$id_departamento' and id_provincia='$id_provincia' and estado=2 order by nombre_distrito");
           return $query->result_array();
         }

    function get_id_moneda($id_alumno){
        $sql = "SELECT * from moneda where estado=2 and id_alumno=".$id_alumno ;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observaciones($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE alumnos SET observaciones='".$dato['observaciones']."',fec_act= NOW(),
        user_act=$id_usuario WHERE id_alumno='". $dato['id_alumno']."'";
        
        $this->db->query($sql);
    }

    function get_pago($id_alumno){
        $sql = "SELECT es.nom_status,p.*,r.usuario_codigo as user_actualizado, g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%d/%m/%Y') as fecha_pago,u.usuario_codigo, e.nom_estadop
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        left join users r on r.id_usuario=p.user_act
        left join estadop e on e.id_estadop=p.estadop
        left join status es on es.id_status=p.estado
        where p.estado=2 and p.id_alumno=".$id_alumno;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_pago($id_pago){
        $sql = "SELECT pa.*,DATE_FORMAT(pa.fec_pago,'%Y/%m/%d') AS fecha_pago,ma.id_alumno 
                FROM pago_matricula_alumno pa
                LEFT JOIN matricula_alumno ma ON ma.id_matricula=pa.id_matricula
                WHERE pa.id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_matricula_alumno SET monto='".$dato['monto']."',estado_pago='".$dato['estado_pago']."',
                fec_pago='".$dato['fec_pago']."',user_pago=$id_usuario,fec_act=NOW(),user_act=$id_usuario
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function get_id_pago1($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop1 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_pago2($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop2 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_pago3($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop3 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_pago4($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop4 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_pago5($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop5 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_pago6($id_pago){
        $sql = "SELECT p.id_producto,p.id_producto1,p.id_producto2,p.id_producto2,p.id_producto3,p.id_producto4,p.id_producto5,p.id_producto6,p.monto,p.id_grado,p.estadop6 as estadop,p.id_pago,p.creado_x,g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%Y-%m-%d') as fecha_pago,u.usuario_nombres,u.usuario_codigo
        from pago p 
        left join grado g on g.id_grado=p.id_grado
        left join users u on u.id_usuario=p.creado_x
        where p.id_pago=".$id_pago;
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_tp($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="update pago set fec_pago='".$dato['fec_pago']."',monto='". $dato['monto']."', estado_pago_final='".$dato['estadop']."',estado_alumno=0, fec_act= NOW(), user_act=".$id_usuario." where id_pago='". $dato['id_pago']."'";

        $sql2="update alumnos set estado_alum='2' where id_alumno='".$dato['id_alumno']."'";
        //echo $sql;
        $this->db->query($sql);
        $this->db->query($sql2);
    }

    function update_moneda($dato){

        $sql="UPDATE moneda set cantidad='".$dato['nueva_cantidad']."' where id_alumno='". $dato['id_alumno']."'";

        $this->db->query($sql);
    }

    function insert_moneda($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT into moneda (cantidad,id_alumno,id_grado, estado, fec_reg, user_reg) 
            values ('". $dato['nueva_cantidad']."','". $dato['id_alumno']."','". $dato['id_grado']."','2',NOW(),".$id_usuario.")";

        $this->db->query($sql);
    }

    function update_pago1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if($dato['estadop']==1){
            $sql="update pago set fec_pago='".$dato['fec_pago']."',monto='".$dato['monto']."',
                estado_alumno=14,estado_pago_final='".$dato['estadop']."',
                fec_act= NOW(), user_act=".$id_usuario." where id_pago='".$dato['id_pago']."'";
            
        }else{
            $sql="update pago set fec_pago='". $dato['fec_pago']."',monto='". $dato['monto']."',
            estado_alumno=14,estado_pago_final='".$dato['estadop']."', fec_act= NOW(), user_act=".$id_usuario." where id_pago='". $dato['id_pago']."'";
            
        }
        $this->db->query($sql);
    }
    function delete_pago($id_pago){
        $fecha=date('Y-m-d H:i:s');
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql1=" update pago set estado='1', fec_eli= NOW(),user_eli=".$id_user." where id_pago='".$id_pago."'";
        
        
        $this->db->query($sql1);
    }
    function get_list_estadop(){
        $sql = "SELECT * from estadop ORDER BY nom_estadop ASC";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function get_list_departamento($id_departamento=null){
        if(isset($id_departamento) && $id_departamento > 0){
            $sql = "select * from departamento where id_departamento =".$id_departamento;
        }
        else
        {
            $sql = "select * from departamento";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_provincia($id_provincia=null){
        if(isset($id_provincia) && $id_provincia > 0){
            $sql = "select * from provincia where id_provincia =".$id_provincia;
        }
        else
        {
            $sql = "select * from provincia";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_provinciaa($id_departamentoa){
        //$sql = "select * from provincia where id_departamento =".$id_departamentoa;
        if(isset($id_departamentoa) && $id_departamentoa > 0){
            $sql = "select * from provincia where id_departamento =".$id_departamentoa;
        }
        else
        {
            $sql = "select * from provincia";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distritoa($id_departamentoa=null,$id_provinciaa=null){
        //$sql = "SELECT * from distrito where id_departamento ='$id_departamentoa' and id_provincia='$id_provinciaa'";
        if(isset($id_departamentoa) && $id_departamentoa > 0){
            $sql = "SELECT * from distrito where id_departamento ='$id_departamentoa' and id_provincia='$id_provinciaa'";
        }
        else
        {
            $sql = "select * from distrito";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_provinciap($id_departamentop=null){
        //$sql = "select * from provincia where id_departamento =".$id_departamentop;
        if(isset($id_departamentop) && $id_departamentop > 0){
            $sql = "select * from provincia where id_departamento =".$id_departamentop;
        }
        else
        {
            $sql = "select * from provincia";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distritop($id_departamentop=null,$id_provinciap=null){
        //$sql = "SELECT * from distrito where id_departamento ='$id_departamentop' and id_provincia='$id_provinciap'";
        if(isset($id_departamentop) && $id_departamentop > 0){
            $sql = "SELECT * from distrito where id_departamento ='$id_departamentop' and id_provincia='$id_provinciap'";
        }
        else
        {
            $sql = "select * from distrito";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distrito($id_distrito=null){
        if(isset($id_distrito) && $id_distrito > 0){
            $sql = "select * from distrito where id_distrito =".$id_distrito;
        }
        else
        {
            $sql = "select * from distrito";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }


    function get_list_grado_escuela($id_grado_escuela=null){
        if(isset($id_grado_escuela) && $id_grado_escuela > 0){
            $sql = "select * from grados_escuela where id_grado_escuela =".$id_grado_escuela;
        }
        else
        {
            $sql = "select * from grados_escuela";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_parentesco($id_parentesco=null){
        if(isset($id_parentesco) && $id_parentesco > 0){
            $sql = "select * from parentesco where id_parentesco =$id_parentesco ORDER BY nom_parentesco ASC";
        }
        else
        {
            $sql = "select * from parentesco ORDER BY nom_parentesco ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_medios($id_medios=null){
        if(isset($id_medios) && $id_medios > 0){
            $sql = "select * from medios_sociales where id_medios =$id_medios ORDER BY nom_medio ASC";
        }
        else
        {
            $sql = "select * from medios_sociales ORDER BY nom_medio ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //estado_alum,

    function delete_alumno($id_alumno){
        $fecha=date('Y-m-d H:i:s');
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql1=" update alumnos set estado_alum='4', fec_eli= NOW(),user_eli=".$id_user." where id_alumno='".$id_alumno."'";
        $sql2=" update alumno_asociar set id_estadoa='4', fec_eli= NOW(),user_eli=".$id_user." where id_alumno='".$id_alumno."'";
        //echo($sql1);
        //echo($sql2);
        $this->db->query($sql1);
        $this->db->query($sql2);
        /*, fec_act= NOW(), user_act=".$id_user." */
    }

    function delete_alumno_admision($_id_alumno){
        $fecha=date('Y-m-d H:i:s');
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" update alumnos set estado_alum='3', fec_eli= NOW(),user_eli=".$id_user." where id_alumno='".$_id_alumno."'";
        //echo($sql);
        $this->db->query($sql);
        /*, fec_act= NOW(), user_act=".$id_user." */
    }
    function get_list_seguimiento1(){
        $sql = "SELECT COUNT(*) as total FROM `alumnos` WHERE estado_alum=9";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_seguimiento2(){
        $sql = "SELECT COUNT(*) as total FROM `alumnos` WHERE estado_alum=10";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_seguimiento3(){
        $sql = "SELECT COUNT(*) as total FROM `alumnos` WHERE estado_alum=11";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_estadoa($id_estadoa=null){
        if(isset($id_estadoa) && $id_estadoa > 0){
            $sql = "SELECT * from estadoa where id_estadoa =$id_estadoa ORDER BY nom_estadoa ASC";
        }
        else
        {
            $sql = "SELECT * from estadoa where  id_estadoa<>'2' and id_estadoa<>'5' ORDER BY nom_estadoa ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_estadoa_matirculado(){
        
        $sql = "SELECT * from estadoa where  id_estadoa<>'5' ORDER BY nom_estadoa ASC";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_config(){
        $sql = "SELECT * from config where descrip_config='slide'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_file_intro($dato){
        $sql = "SELECT * from intro  where estado='2' and id_tema='".$dato['id_tema']."'";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*------------------------------------------------------ */
    function list_distint_grado(){
        $sql = "SELECT DISTINCT(t.id_grado),g.descripcion_grado FROM tema t
        left join grado g on g.id_grado=t.id_grado
        where t.estado=2 and t.estado_contenido=1";

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pago($id_alumno){ 
        $sql = "SELECT s.nom_status,e.nom_estadoa,g.descripcion_grado,pd1.nom_producto as nom_modulo,
        n.id_nota,p.id_prod_final as id_unidad,n.total_nota,n.cant_nota,n.nota_total_errados,n.nota_total_correctos,format((n.total_nota/n.cant_nota),1) as promedio,n.puntaje,p.fec_inicio as fec_inicio_unidad,n.ultimo_examen,
        p.*,e1.nom_estadop as nomestado1,e2.nom_estadop as nomestado2,e3.nom_estadop as nomestado3,e4.nom_estadop as nomestado4,
        e5.nom_estadop as nomestado5,e6.nom_estadop as nomestado6,e8.nom_estadop as nomestado8,v.pago_prod_final
        
                FROM pago p 
                
                LEFT JOIN grado g on g.id_grado=p.id_grado
                LEFT join status s on s.id_status=p.estado
                left join producto pd1 on pd1.id_producto=p.id_prod_final
                left join estadoa e on e.id_estadoa=p.estado_alumno
                left JOIN (SELECT *,SUM(puntaje_e) as nota_total_errados,SUM(puntaje) as nota_total_correctos,MAX(fec_reg) as ultimo_examen,
                    SUM(CASE WHEN id_alumno='$id_alumno' and estado='2' THEN nota ELSE 0 END) as total_nota,
                    SUM(CASE WHEN id_alumno= '$id_alumno' and estado='2' THEN 1 ELSE 0 END) as cant_nota
                    from nota WHERE id_alumno='$id_alumno' and estado=2 GROUP by id_grado,id_unidad) n on n.id_grado=p.id_grado and n.estado=2 and n.id_unidad=p.id_prod_final

                left join estadop e1 on e1.id_estadop=p.estadop1
                left join estadop e2 on e2.id_estadop=p.estadop2
                left join estadop e3 on e3.id_estadop=p.estadop3
                left join estadop e4 on e4.id_estadop=p.estadop4
                left join estadop e5 on e5.id_estadop=p.estadop5
                left join estadop e6 on e6.id_estadop=p.estadop6
                left join estadop e8 on e8.id_estadop=p.estadop
                left JOIN view_pago_final v on v.id_pago=p.id_pago
                WHERE p.id_alumno='$id_alumno' AND p.estado in (1,2,3) and p.id_prod_final<>8";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_unidad($id_alumno,$id_unidad,$id_grado){
        /*$sql = "SELECT t.referencia,a.descripcion_area,asi.descripcion_asignatura,t.desc_tema,n.puntaje as evaluacion,c.fec_reg as fecha_ini,n.fec_reg as fec_fin,n.* 
		FROM nota n
        left JOIN tema t on t.id_tema=n.id_tema and t.estado=2
        LEFT JOIN area a on a.id_area=t.id_area AND a.estado=2
        LEFT JOIN asignatura asi on asi.id_asignatura=t.id_asignatura and asi.estado=2
        LEFT JOIN (SELECT id_alumno,id_grado,id_tema,id_unidad,id_area,fec_reg from ctrl_tiempo_alumno WHERE id_alumno='$id_alumno' and estado=2) c on c.id_grado=n.id_grado and c.id_tema=n.id_tema and c.id_unidad=n.id_unidad and c.id_alumno='$id_alumno'
        WHERE n.id_alumno='$id_alumno' and n.id_unidad='$id_unidad' and n.id_grado='$id_grado' and n.estado=2";*/
        $sql="SELECT t.id_tema,t.referencia,a.descripcion_area,ag.descripcion_asignatura,t.desc_tema,t.id_grado,t.id_unidad,n.id_nota,n.id_alumno,n.nota,c.fec_reg as fecha_ini,n.fec_reg as fec_fin,n.moneda,n.n_intento,date_format(n.fec_reg, '%d/%m/%Y %H:%i:%s') as fecha_registro
        FROM tema t
        LEFT JOIN nota n on n.id_grado=t.id_grado AND n.id_unidad=t.id_unidad AND n.id_tema=t.id_tema AND n.id_alumno='$id_alumno' and n.estado=2
        LEFT JOIN area a on a.id_area=t.id_area AND a.estado=2
        LEFT JOIN asignatura ag on ag.id_asignatura=t.id_asignatura AND ag.estado=2
        LEFT JOIN (SELECT id_alumno,id_grado,id_tema,id_unidad,id_area,fec_reg from ctrl_tiempo_alumno WHERE id_alumno='$id_alumno' and estado=2) c on c.id_grado=n.id_grado and c.id_tema=n.id_tema and c.id_unidad=n.id_unidad and c.id_alumno='$id_alumno' 
        WHERE  t.id_unidad='$id_unidad' and t.id_grado='$id_grado' and t.estado=2 and t.prueba<>1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    /*---------prueba pagos*/
    function get_list_examenes_prueba($id_alumno){
        $sql = "SELECT p.id_pago,case 
        when p.id_producto= 1 then 'matricula' 
        when p.id_producto1 = 2 then 'unidad1'
        when p.id_producto2 = 3 then 'unidad2'
        when p.id_producto3 = 4 then 'unidad3'
        when p.id_producto4 = 5 then 'unidad4'
        when p.id_producto5 = 6 then 'unidad5'
        when p.id_producto6 = 7 then 'unidad6'
        END AS unidad, p.* from pago p WHERE p.id_alumno='$id_alumno' GROUP by p.id_pago";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    //------------------------REQUISITO MATRICULA-------------------//
    function get_list_requisito_matricula($id_requisito_m=null){
        if(isset($id_requisito_m) && $id_requisito_m > 0){
            $sql = "SELECT r.*,s.nom_status FROM requisito_matricula r 
            LEFT JOIN status s ON s.id_status=r.estado 
            WHERE r.id_requisito_m='$id_requisito_m'";
        }else{
            $sql = "SELECT r.*,s.nom_status FROM requisito_matricula r 
            LEFT JOIN status s ON s.id_status=r.estado ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function insert_requisito_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO requisito_matricula (codigo, nombre, estado, fec_reg, user_reg) 
                values ('".$dato['codigo']."','".$dato['nombre']."','2',NOW(),".$id_usuario.")";
        $this->db->query($sql);
    }

    function update_requisito_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE requisito_matricula set codigo='". $dato['codigo']."',
        nombre='". $dato['nombre']."',
        estado='". $dato['estado']."',
        fec_act= NOW(),
        user_act=".$id_usuario."  where id_requisito_m='". $dato['id_requisito_m']."'";
        $this->db->query($sql);
    }

    function delete_requisito_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE requisito_matricula set 
        estado=4,
        fec_eli= NOW(),
        user_eli=".$id_usuario."  where id_requisito_m='".$dato['id_requisito_m']."'";
        
        $this->db->query($sql);
    }

    function get_list_estado_unidad(){
        $sql = "SELECT * FROM estadoa WHERE estado=1 and id_estadoa in (4,13,14) ORDER BY id_estadoa DESC";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_unidad($id_pago){
        $sql = "SELECT * FROM pago WHERE id_pago='$id_pago'";
        
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_estado_unidad($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d H:i:s');

        if($dato['estado']=="4"){
            $sql1 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop1='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=1 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql1);

            $sql2 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop2='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=2 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql2);

            $sql3 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop3='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=3 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql3);

            $sql4 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop4='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=4 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql4);

            $sql5 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop5='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=5 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql5);

            $sql6 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop6='3', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_prod_final=6 and id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql6);
    
            $sql7 = "UPDATE alumnos SET estado_alum='".$dato['estado']."', user_act='$id_usuario', fec_act='$fecha' 
            where id_alumno='".$dato['id_alumno']."'";
            
            $this->db->query($sql7);
        }else{
            if($dato['id_prod_final']=="1"){
                $sql1 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop1='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql1);

            }elseif($dato['id_prod_final']=="2"){
                $sql2 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop2='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql2);

            }elseif($dato['id_prod_final']=="3"){
                $sql3 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop3='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql3);
            }elseif($dato['id_prod_final']=="4"){
                $sql4 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop4='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql4);
            }elseif($dato['id_prod_final']=="5"){
                $sql5 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop5='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql5);
            }elseif($dato['id_prod_final']=="6"){
                $sql6 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estadop6='1', user_act_estauni='$id_usuario', fec_act_estauni='$fecha' 
                where id_pago='".$dato['id_pago']."' ";
                
                $this->db->query($sql6);
            }

            $sql7 = "UPDATE alumnos SET estado_alum='".$dato['estado']."', user_act='$id_usuario', fec_act='$fecha' 
            where id_alumno='".$dato['id_alumno']."'";
            $this->db->query($sql7);
            
        }
        
        
        
    }

    function realizar_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="update alumnos set id_grados_activos='". $dato['id_grados_activos']."',
        estado_alum='2',
        tmatricula='0',
        fec_act= NOW(), user_act=".$id_usuario." where id_alumno='". $dato['id_alumno']."'";

        $sql2 = "insert into pago (id_alumno,id_prod_final,id_producto,id_producto1,id_producto2,id_producto3,id_producto4,id_producto5,id_producto6,estadop,estadop1,estadop2,estadop3,estadop4,estadop5,estadop6,id_grado, fec_matri,creado_x,monto,estado,estado_alumno, fec_reg, user_reg) 
        values ('".$dato['id_alumno']."','8','1','0','0','0','0','0','0', '1','0','0','0','0','0','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','50','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','1','0','2','0','0','0','0','0', '0','1','0','0','0','0','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','2','0','0','3','0','0','0','0', '0','0','1','0','0','0','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','3','0','0','0','4','0','0','0', '0','0','0','1','0','0','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','4','0','0','0','0','5','0','0', '0','0','0','0','1','0','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','5','0','0','0','0','0','6','0', '0','0','0','0','0','1','0','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','6','0','0','0','0','0','0','7', '0','0','0','0','0','0','1','". $dato['id_grados_activos']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario.")";
        
        $this->db->query($sql);
        $this->db->query($sql2);
    }

    function get_list_estadoa_retiro(){
        $sql = "SELECT * from estadoa where id_estadoa in (1,2,4,13,15,16) ORDER BY nom_estadoa ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------ALUMNO-------------------------------------
    function get_list_total_alumnos(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_enadmision(){
        $sql = "SELECT g.descripcion_grado,(SELECT COUNT(*) FROM alumnos a 
                WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=1) AS total 
                FROM grado g 
                WHERE g.tipo_ceba=2 AND g.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_enadmision(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_sinefecto(){
        $sql = "SELECT g.descripcion_grado, (SELECT COUNT(*) FROM alumnos a 
                WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=8) AS total 
                FROM grado g 
                WHERE g.tipo_ceba=2 AND g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_sinefecto(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=8";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_graduado(){
        $sql = "SELECT g.descripcion_grado, (SELECT COUNT(*) FROM alumnos a 
                WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=17) AS total 
                FROM grado g 
                WHERE g.tipo_ceba=2 AND g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_graduado(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=17";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_registrado(){
        $sql = "SELECT g.descripcion_grado, (SELECT count(*) FROM alumnos a 
                WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=6) AS total 
                FROM grado g 
                WHERE g.tipo_ceba=2 AND g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 
    
    function get_list_total_registrado(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=6";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_anulado(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_seguimiento(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum IN (9,10,11)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_seguimiento(){
        $sql = "SELECT g.descripcion_grado, 
                (SELECT COUNT(*) FROM alumnos a WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=9) AS total_s1,
                (SELECT COUNT(*) FROM alumnos a WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=10) AS total_s2,
                (SELECT COUNT(*) FROM alumnos a WHERE a.id_grados_activos=g.id_grado AND a.estado_alum=11) AS total_s3
                FROM grado g WHERE g.tipo_ceba=2 AND g.estado=2;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_total_matriculado(){
        $sql = "SELECT COUNT(*) AS total FROM alumnos WHERE tipo_ceba=2 AND estado_alum=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    //ANTES
    /*function get_list_act_1(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND 
                al.id_grados_activos=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_act_2(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND 
                al.id_grados_activos=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_act_3(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND 
                al.id_grados_activos=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_act_4(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND 
                al.id_grados_activos=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_asi_1(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND 
                DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND al.id_grados_activos=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_asi_2(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND 
                DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND al.id_grados_activos=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_asi_3(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND 
                DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND al.id_grados_activos=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_asi_4(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND 
                DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND al.id_grados_activos=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_inc_1(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND 
                al.id_grados_activos=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_inc_2(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND 
                al.id_grados_activos=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_inc_3(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND 
                al.id_grados_activos=3";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_inc_4(){
        $sql = "SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND 
                al.id_grados_activos=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_pro_1(){
        $sql = "SELECT p.id_alumno,p.id_grado
                FROM pago p
                LEFT JOIN alumnos al ON al.id_alumno=p.id_alumno
                WHERE al.tipo_ceba=2 AND p.id_grado=1 and p.estado=2 and p.id_prod_final<>8 AND 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6
                GROUP BY p.id_alumno,p.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pro_2(){
        $sql = "SELECT p.id_alumno,p.id_grado
                FROM pago p
                LEFT JOIN alumnos al ON al.id_alumno=p.id_alumno
                WHERE al.tipo_ceba=2 AND p.id_grado=2 and p.estado=2 and p.id_prod_final<>8 and 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6
                GROUP BY p.id_alumno,p.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_pro_3(){
        $sql = "SELECT p.id_alumno,p.id_grado
                FROM pago p
                LEFT JOIN alumnos al ON al.id_alumno=p.id_alumno
                WHERE al.tipo_ceba=2 AND p.id_grado=3 and p.estado=2 and p.id_prod_final<>8 and 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6
                GROUP BY p.id_alumno,p.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    } 

    function get_list_pro_4(){
        $sql="SELECT p.id_alumno,p.id_grado
                FROM pago p
                LEFT JOIN alumnos al ON al.id_alumno=p.id_alumno
                WHERE al.tipo_ceba=2 AND p.id_grado=4 and p.estado=2 and p.id_prod_final<>8 and 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6
                GROUP BY p.id_alumno,p.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }*/
    //AHORA
    function get_list_matriculado(){
        $sql = "SELECT gr.descripcion_grado,
                (SELECT COUNT(*) FROM alumnos al
                LEFT JOIN hingresoceba hi ON hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=5 AND al.id_grados_activos=gr.id_grado) AS activos,
                (SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND 
                al.id_grados_activos=gr.id_grado) AS asistiendo,
                (SELECT COUNT(*) as total FROM alumnos al
                LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno
                WHERE al.tipo_ceba=2 AND al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND al.id_grados_activos=gr.id_grado) AS inactivos,
                (SELECT COUNT(DISTINCT p.id_alumno) FROM pago p
                LEFT JOIN alumnos al ON al.id_alumno=p.id_alumno
                WHERE al.tipo_ceba=2 AND p.id_grado=gr.id_grado and p.estado=2 and p.id_prod_final<>8 AND 
                (SELECT COUNT(*) FROM pago pp WHERE pp.terminado=1 and pp.id_alumno=p.id_alumno and pp.id_grado=p.id_grado)=6) AS promovidos
                FROM grado gr
                WHERE gr.tipo_ceba=2 AND gr.estado=2 ORDER BY gr.descripcion_grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_admision($parametro){
        /*(SELECT fm.id_foto FROM foto_matriculados fm 
        WHERE fm.id_empresa=5 AND fm.id_sede=7 AND fm.id_alumno=ap.id_alumno AND fm.estado=2 ORDER BY fm.id_foto DESC LIMIT 1) AS id_foto,
        (SELECT fm.foto FROM foto_matriculados fm 
        WHERE fm.id_empresa=5 AND fm.id_sede=7 AND fm.id_alumno=ap.id_alumno AND fm.estado=2 ORDER BY fm.id_foto DESC LIMIT 1) AS link_foto*/
        if($parametro==1){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum in (1,3,5,6,7,9,10,11) and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }
        if($parametro==4){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=6 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }
        if($parametro==5){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (9,10,11) and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }
        if($parametro==6){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=1 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }
        if($parametro==7){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=8 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }
        if($parametro==8){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8 and ap.id_grados_activos=pg.id_grado
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=2 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno(){
        $sql = "SELECT  ap.id_alumno,ap.id_alumno as id_alumnop,ap.cod_arpay,gr.descripcion_grado,ap.dni_alumno,ap.alum_apater,ap.alum_amater,
                ap.alum_nom,p.nombre_provincia,DATE_FORMAT(pg.fec_pago,'%d/%m/%Y') as fecha_matricula,pg.fec_pago,s.nom_estadoa,ap.estado_alum,u.id_unidad,
                dc.cant_documento,DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i') as ultimo_ingreso,
                DATE_FORMAT(h.fec_ingreso,'%Y-%m-%d') as ultimo_ingreso_calc,v.id_prod_final as modulo_sterminar, (SELECT v2.id_prod_final 
                FROM modulo_alumno v2
                WHERE v2.id_alumno = ap.id_alumno and v2.id_grado=ap.id_grados_activos and v2.estado_unidad=1  
                ORDER BY v2.fec_fin_modulo DESC limit 1) as modulo_terminado,
                (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,ap.alum_edad,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                from alumnos ap 
                left join departamento d on ap.id_departamentoa =d.id_departamento 
                left join provincia p on ap.id_provinciaa=p.id_provincia 
                left join distrito i on ap.id_distritoa=i.id_distrito 
                left join estadoa s on ap.estado_alum=s.id_estadoa
                left join unidad u on ap.id_unidad=u.id_unidad
                left join users usu on ap.user_reg=usu.id_usuario
                left join matricula ma on ap.id_matricula=ma.id_matricula
                left join grados_escuela g on ap.id_gradop=g.id_grado_escuela
                left join grado gr on ap.id_grados_activos=gr.id_grado
                left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                left JOIN modulo_alumno v on v.id_alumno=ap.id_alumno and v.id_grado=ap.id_grados_activos and v.estado_unidad=3
                left join hingresoceba h on h.id_alumno=ap.id_alumno
                LEFT JOIN (SELECT id_alumno,SUM(CASE WHEN estado='2' THEN 1 ELSE 0 END) as cant_documento
                FROM documento_alumno GROUP by id_alumno) dc on dc.id_alumno=ap.id_alumno
                where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (2) GROUP BY ap.id_alumno  
                ORDER BY pg.fec_pago DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_todo_alumno(){
        $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                from alumnos ap 
                left join departamento d on ap.id_departamentoa =d.id_departamento 
                left join provincia p on ap.id_provinciaa=p.id_provincia 
                left join distrito i on ap.id_distritoa=i.id_distrito 
                left join estadoa s on ap.estado_alum=s.id_estadoa
                left join unidad u on ap.id_unidad=u.id_unidad
                left join users usu on ap.user_reg=usu.id_usuario
                left join matricula ma on ap.id_matricula=ma.id_matricula
                left join grado gr on ap.id_grados_activos=gr.id_grado
                left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                WHERE ap.tipo_ceba=2 AND ap.estado=2
                GROUP BY ap.id_alumno ORDER BY ap.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_graduado_alumno(){
        $sql = "SELECT pg.estadop,ap.*,ap.id_alumno AS id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') AS fecha_registro,ap.user_reg AS usuario_registro,
                (SELECT COUNT(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) AS cant_matricula,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                FROM alumnos ap 
                LEFT JOIN departamento d ON ap.id_departamentoa =d.id_departamento 
                LEFT JOIN provincia p ON ap.id_provinciaa=p.id_provincia 
                LEFT JOIN distrito i ON ap.id_distritoa=i.id_distrito 
                LEFT JOIN estadoa s ON ap.estado_alum=s.id_estadoa
                LEFT JOIN unidad u ON ap.id_unidad=u.id_unidad
                LEFT JOIN users usu ON ap.user_reg=usu.id_usuario
                LEFT JOIN matricula ma ON ap.id_matricula=ma.id_matricula
                LEFT JOIN grado gr ON ap.id_grados_activos=gr.id_grado
                LEFT JOIN pago pg ON pg.id_alumno=ap.id_alumno AND pg.id_prod_final=8
                WHERE ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (17) GROUP BY ap.id_alumno ORDER BY ap.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function ultimo_cod_alumno($anio){
        $sql = "SELECT * FROM alumnos WHERE tipo_ceba=2 AND YEAR( fec_reg ) = '".$anio."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_alumno($dato){
        $sql = "SELECT * FROM alumnos WHERE tipo_ceba=2 AND dni_alumno = '".$dato['dni_alumno']."' and estado_alum<>4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "insert into alumnos (tipo_ceba,dni_alumno,
        alum_nom,
        alum_apater,
        alum_amater,
        alum_nacimiento,
        cod_alum,
        alum_edad,
        alum_direc,
        id_departamentoa,
        id_provinciaa,
        id_distritoa,
        alum_celular,
        alum_cellcontac,
        correo,
        alumno_institucionp,
        id_departamentop,
        id_provinciap,
        id_distritop,
        id_gradop,
        titular1_dni,
        titular1_parentesco,
        titular1_apater,
        titular1_amater,
        titular1_nom,
        titular1_celular,
        titular2_dni,
        titular2_parentesco,
        titular2_apater,
        titular2_amater,
        titular2_nom,
        titular2_celular,
        id_grados_activos,
        tipo,
        id_medios,
        estado_alum,
        alumno_password,
        estado,
        fec_reg,
        user_reg) 
                values (2,'".$dato['dni_alumno']."',
                '".$dato['alum_nom']."',
                '".$dato['alum_apater']."',
                '".$dato['alum_amater']."',
                '".$dato['alum_nacimiento']."',
                '".$dato['cod_alum']."',
                '".$dato['alum_edad']."',
                '".$dato['alum_direc']."',
                '".$dato['id_departamentoa']."',
                '".$dato['id_provinciaa']."',
                '".$dato['id_distritoa']."',
                '".$dato['alum_celular']."',
                '".$dato['alum_cellcontac']."',
                '".$dato['correo']."',
                '".$dato['alumno_institucionp']."',
                '".$dato['id_departamentop']."',
                '".$dato['id_provinciap']."',
                '".$dato['id_distritop']."',
                '".$dato['id_gradop']."',
                '".$dato['titular1_dni']."',
                '".$dato['titular1_parentesco']."',
                '".$dato['titular1_apater']."',
                '".$dato['titular1_amater']."',
                '".$dato['titular1_nom']."',
                '".$dato['titular1_celular']."',
                '".$dato['titular2_dni']."',
                '".$dato['titular2_parentesco']."',
                '".$dato['titular2_apater']."',
                '".$dato['titular2_amater']."',
                '".$dato['titular2_nom']."',
                '".$dato['titular2_celular']."',
                '".$dato['id_grados_activos']."',
                '".$dato['tipo']."',
                '".$dato['id_medios']."',
                '6',
                '".$dato['alumno_password']."',
                2,              
                NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function get_documentos_asignados($id_grado){  
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                WHERE id_empresa=5 AND id_sede=7 AND nom_grado IN (0,$id_grado) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documentos_alumno($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,id_sede,anio,
                estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."',5,7,'".$dato['anio']."',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function excel_alumno($parametro){
        /* CASE WHEN (SELECT COUNT(*) FROM foto_matriculados fm WHERE fm.id_sede=7 AND fm.id_alumno=ap.id_alumno AND fm.estado=2)>0 THEN 'Si' ELSE 'No' END AS foto,
        (SELECT fm.id_foto FROM foto_matriculados fm 
        WHERE fm.id_empresa=5 AND fm.id_sede=7 AND fm.id_alumno=ap.id_alumno AND fm.estado=2 ORDER BY fm.id_foto DESC LIMIT 1) AS id_foto,
        (SELECT fm.foto FROM foto_matriculados fm 
        WHERE fm.id_empresa=5 AND fm.id_sede=7 AND fm.id_alumno=ap.id_alumno AND fm.estado=2 ORDER BY fm.id_foto DESC LIMIT 1) AS link_foto*/
        if($parametro==1){
            $sql = "SELECT pg.estadop,ap.*,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,
                    gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum in (1,3,5,6,7,9,10,11) ORDER BY ap.fec_reg DESC";
        }elseif($parametro==2){
            $sql = "SELECT  ap.id_alumno,ap.observaciones,ap.id_alumno as id_alumnop,ap.cod_arpay,gr.descripcion_grado,ap.dni_alumno,ap.alum_apater,ap.alum_amater,ap.alum_nom,p.nombre_provincia,DATE_FORMAT(pg.fec_pago,'%d/%m/%Y') as fecha_matricula,pg.fec_pago,s.nom_estadoa,ap.estado_alum,u.id_unidad,dc.cant_documento,
                    DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i:%s') as ultimo_ingreso,v.id_prod_final as modulo_sterminar, (SELECT v2.id_prod_final 
                    FROM modulo_alumno v2
                    WHERE v2.id_alumno = ap.id_alumno and v2.id_grado=ap.id_grados_activos and v2.estado_unidad=1  
                    ORDER BY v2.fec_fin_modulo DESC limit 1) as modulo_terminado,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,ap.alum_edad,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grados_escuela g on ap.id_gradop=g.id_grado_escuela
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                    left JOIN modulo_alumno v on v.id_alumno=ap.id_alumno and v.id_grado=ap.id_grados_activos and v.estado_unidad=3
                    left join hingresoceba h on h.id_alumno=ap.id_alumno
                    LEFT JOIN (SELECT id_alumno,SUM(CASE WHEN estado='2' THEN 1 ELSE 0 END) as cant_documento
                    FROM documento_alumno GROUP by id_alumno) dc on dc.id_alumno=ap.id_alumno
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (2) GROUP BY ap.id_alumno  
            ORDER BY `pg`.`fec_pago` DESC";
        }elseif($parametro==3){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2
                    GROUP BY ap.id_alumno ORDER BY ap.fec_reg DESC";
        }elseif($parametro==4){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=6 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }elseif($parametro==5){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (9,10,11) and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }elseif($parametro==6){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=1 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }elseif($parametro==7){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito  
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and  pg.id_prod_final=8
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=8 and ap.dni_alumno<>'' ORDER BY ap.fec_reg DESC";
        }elseif($parametro==8){
            $sql = "SELECT  ap.id_alumno,ap.observaciones,ap.id_alumno as id_alumnop,ap.cod_arpay,gr.descripcion_grado,ap.dni_alumno,ap.alum_apater,ap.alum_amater,ap.alum_nom,p.nombre_provincia,DATE_FORMAT(pg.fec_pago,'%d/%m/%Y') as fecha_matricula,pg.fec_pago,s.nom_estadoa,ap.estado_alum,u.id_unidad,dc.cant_documento,
                    DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i:%s') as ultimo_ingreso,v.id_prod_final as modulo_sterminar, (SELECT v2.id_prod_final 
                    FROM modulo_alumno v2
                    WHERE v2.id_alumno = ap.id_alumno and v2.id_grado=ap.id_grados_activos and v2.estado_unidad=1  
                    ORDER BY v2.fec_fin_modulo DESC limit 1) as modulo_terminado,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grados_escuela g on ap.id_gradop=g.id_grado_escuela
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                    left JOIN modulo_alumno v on v.id_alumno=ap.id_alumno and v.id_grado=ap.id_grados_activos and v.estado_unidad=3
                    left join hingresoceba h on h.id_alumno=ap.id_alumno
                    LEFT JOIN (SELECT id_alumno,SUM(CASE WHEN estado='2' THEN 1 ELSE 0 END) as cant_documento
                    FROM documento_alumno GROUP by id_alumno) dc on dc.id_alumno=ap.id_alumno
                    where ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (2) GROUP BY ap.id_alumno  
                    ORDER BY pg.fec_pago DESC";
        }elseif($parametro==9){
            $sql = "SELECT pg.estadop,ap.*,ap.id_alumno as id_alumnop,d.*,p.nombre_provincia,i.*,s.nom_estadoa,u.*,usu.usuario_codigo,
                    ma.*,gr.descripcion_grado,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') as fecha_registro,ap.user_reg as usuario_registro,
                    (SELECT count(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                    ELSE 'No' END AS foto,
                    (SELECT de.id_detalle FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                    (SELECT de.archivo FROM detalle_alumno_empresa de
                    LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                    WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join distrito i on ap.id_distritoa=i.id_distrito 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join unidad u on ap.id_unidad=u.id_unidad
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join matricula ma on ap.id_matricula=ma.id_matricula
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    left join pago pg on pg.id_alumno=ap.id_alumno and pg.id_prod_final=8
                    WHERE ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum IN (17) GROUP BY ap.id_alumno ORDER BY ap.fec_reg DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_detalle_alumno($id_alumno){
        $sql = "SELECT ap.*, dp.nombre_departamento, pv.nombre_provincia, dt.nombre_distrito,de.nombre_departamento as departamentoe, pe.nombre_provincia as provinciae, die.nombre_distrito as distritoe,
                DATE_FORMAT(ap.alum_nacimiento,'%d/%m/%Y') as fecha_nacimiento, es.nom_estadoa, aso.id_unidad, 
                un.nom_unidad, ms.nom_medio, gc.nom_grado_escuela,gr.descripcion_grado,DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i:%s') as ultimo_ingreso
                from alumnos ap 
                left join departamento dp on dp.id_departamento=ap.id_departamentoa
                left join provincia pv on pv.id_provincia=ap.id_provinciaa
                left join distrito dt on dt.id_distrito=ap.id_distritoa

                left join departamento de on de.id_departamento=ap.id_departamentop
                left join provincia pe on pe.id_provincia=ap.id_provinciap
                left join distrito die on die.id_distrito=ap.id_distritop

                left join estadoa es on es.id_estadoa=ap.estado_alum
                left join alumno_asociar aso on aso.id_alumno=ap.id_alumno
                left join unidad un on un.id_unidad=aso.id_unidad
                left join medios_sociales ms on ms.id_medios=ap.id_medios
                left join grados_escuela gc on gc.id_grado_escuela=ap.id_gradop
                left join grado gr on ap.id_grados_activos=gr.id_grado
                left join hingresoceba h on h.id_alumno=ap.id_alumno
                where ap.id_alumno=".$id_alumno;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_alumno($id_alumno){
        $sql = "SELECT * FROM alumnos WHERE id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_matricula_alumno($id_matricula){
        $sql = "SELECT al.cod_alum,gr.descripcion_grado,al.alum_nom,al.alum_apater,al.alum_amater,
                DATE_FORMAT(al.alum_nacimiento,'%d/%m/%Y') AS fecha_nacimiento,al.alum_edad,
                CASE WHEN al.alum_sexo=1 THEN 'Femenino' WHEN al.alum_sexo=2 THEN 'Masculino' ELSE ''
                END AS nom_sexo,al.dni_alumno,da.nombre_distrito AS dis_alum,al.alum_telf_casa,al.correo,
                al.alumno_institucionp,pa.nom_parentesco,
                CONCAT(al.titular1_nom,' ',al.titular1_apater,' ',al.titular1_amater) AS nom_principal,
                al.titular1_direccion,dp.nombre_distrito AS dis_prin,al.titular1_celular,al.titular1_telf_casa,
                al.titular1_centro_labor,al.titular1_ocupacion,al.titular1_correo
                FROM matricula_alumno ma 
                LEFT JOIN grado gr ON gr.id_grado=ma.id_grado
                LEFT JOIN alumnos al ON al.id_alumno=ma.id_alumno
                LEFT JOIN distrito da ON da.id_distrito=al.id_distritoa
                LEFT JOIN parentesco pa ON pa.id_parentesco=al.titular1_parentesco
                LEFT JOIN distrito dp ON dp.id_distrito=al.titular1_distrito
                WHERE ma.id_matricula=$id_matricula";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_pago_grado($id_alumno,$id_grado){
        $sql = "SELECT es.nom_status,p.*,r.usuario_codigo as user_actualizado, g.descripcion_grado,DATE_FORMAT(p.fec_matri,'%d/%m/%Y %H:%i:%s') as fecha_matricula,DATE_FORMAT(p.fec_pago,'%d/%m/%Y') as fecha_pago,u.usuario_codigo, e.nom_estadop
                from pago p 
                left join grado g on g.id_grado=p.id_grado
                left join users u on u.id_usuario=p.creado_x
                left join users r on r.id_usuario=p.user_act
                left join estadop e on e.id_estadop=p.estadop
                left join status es on es.id_status=p.estado
                where p.estado=2 and p.id_alumno='$id_alumno' and p.id_grado='$id_grado'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_producto(){
        $sql = "SELECT * from producto where estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_documentos($dato){
        $sql = "SELECT do.*,co.nom_documento,ti.nom_tipo_requisito,us.usuario_codigo,DATE_FORMAT(do.fec_subido,'%d/%m/%Y') AS fecha_subido
                FROM documento_alumno_ep1 do
                LEFT JOIN config_documento co ON co.id_config=do.id_documento
                LEFT JOIN tipo_requisito ti ON ti.id_tipo_requisito=co.id_tipo_requisito
                LEFT JOIN users us ON us.id_usuario=do.user_subido
                WHERE do.id_alumno='".$dato['id_alumno']."' AND do.estado=2
                ORDER BY ti.nom_tipo_requisito ASC,co.nom_documento ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_examenes($id_alumno){
        $sql = "SELECT s.nom_status,g.descripcion_grado,date_format(a.fec_crea_clave, '%d/%m/%Y') as fec_inicio_clave,p.*,
                (CASE WHEN p.id_prod_final= '8' and p.estadop='2' and p.estado='2' THEN u.usuario_codigo ELSE '' END) AS user_reg_matricula,
                (CASE WHEN p.id_prod_final= '8' and p.estadop='2' and p.estado='2' THEN 1 ELSE 0 END) as pago_matricula,
                (CASE WHEN p.id_prod_final= '8' and p.estadop='2' and p.estado='2' THEN p.fec_pago ELSE 0 END) as fecha_matricula,
                SUM(CASE WHEN p.id_prod_final<>'8' and p.estado='2' THEN p.terminado ELSE 0 END) as total_terminados,
                SUM(CASE WHEN p.id_prod_final<>'8' AND p.estado_alumno='13' THEN 1 ELSE 0 END) as sum_retirados
                FROM pago p 
                LEFT JOIN grado g on g.id_grado=p.id_grado
                LEFT join status s on s.id_status=p.estado
                LEFT JOIN alumnos a on a.id_alumno=p.id_alumno
                left JOIN users u on u.id_usuario=p.user_reg
                WHERE p.id_alumno='$id_alumno' AND p.estado=2 
                GROUP BY p.id_grado,p.estado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pago_xalumno($id_alumno){
        $sql = "SELECT p.*,pd.nom_producto,date_format(p.fec_pago, '%d/%m/%Y') as fecha_pago,u.usuario_codigo,
                e1.nom_estadop as nomestado1,e2.nom_estadop as nomestado2,e3.nom_estadop as nomestado3,e4.nom_estadop as nomestado4,
                e5.nom_estadop as nomestado5,e6.nom_estadop as nomestado6,e8.nom_estadop as nomestado8
                from pago p
                LEFT JOIN producto pd on pd.id_producto=p.id_prod_final
                left JOIN users u on u.id_usuario=p.user_act
                left join estadop e1 on e1.id_estadop=p.estadop1
                left join estadop e2 on e2.id_estadop=p.estadop2
                left join estadop e3 on e3.id_estadop=p.estadop3
                left join estadop e4 on e4.id_estadop=p.estadop4
                left join estadop e5 on e5.id_estadop=p.estadop5
                left join estadop e6 on e6.id_estadop=p.estadop6
                left join estadop e8 on e8.id_estadop=p.estadop
                WHERE p.id_alumno='$id_alumno' AND p.estado in (1,2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pago_xalumno_nuevo($id_alumno){
        $sql = "SELECT p.id_pago,p.id_alumno,p.id_grado,p.fec_matri,p.creado_x,p.id_prod_final,pd.nom_producto, p.monto,p.fec_pago,p.estado_pago_final,p.estado,p.estado_alumno,p.terminado,p.fec_reg,p.user_reg,p.fec_act,p.user_act,p.fec_eli,p.user_eli,
        date_format(p.fec_pago, '%d/%m/%Y') as fecha_pago,u.usuario_codigo as usuario_reg,
        CASE WHEN p.estado_pago_final=1 THEN 'Pendiente' 
        when p.estado_pago_final=2 THEN 'Cancelado'
        when p.estado_pago_final=3 THEN 'Anulado' end AS estado_pago
        from pago p
        LEFT JOIN producto pd on pd.id_producto=p.id_prod_final
        left JOIN users u on u.id_usuario=p.user_act
        WHERE p.id_alumno='$id_alumno' AND p.estado in (1,2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_lista_nota($id_alumno){
        $sql = "SELECT SUM(n.puntaje) as nota_total,SUM(n.puntaje_e) as nota_total_errados,s.nom_status,
                SUM(CASE WHEN n.id_alumno= '$id_alumno' and n.estado='2' THEN 1 ELSE 0 END) as cant_nota,date_format(MAX(n.fec_reg), '%d/%m/%Y') as ultimo_examen,
                n.* FROM nota n
                LEFT join status s on s.id_status=n.estado
                WHERE n.id_alumno='$id_alumno' and n.estado=2
                GROUP by n.id_unidad,n.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_lista_tiempoxunidad($id_alumno){
        $sql = "SELECT t.referencia,a.descripcion_area,asi.descripcion_asignatura,t.desc_tema,n.puntaje as evaluacion,c.fec_reg as fecha_ini,n.fec_reg as fec_fin,
                SEC_TO_TIME(
                    SUM(TIME_TO_SEC(TIMEDIFF(n.fec_reg,c.fec_reg)))
                ) total,n.* 
                FROM nota n
                left JOIN tema t on t.id_tema=n.id_tema and t.estado=2
                LEFT JOIN area a on a.id_area=t.id_area AND a.estado=2
                LEFT JOIN asignatura asi on asi.id_asignatura=t.id_asignatura and asi.estado=2
                LEFT JOIN (SELECT id_alumno,id_grado,id_tema,id_unidad,id_area,fec_reg from ctrl_tiempo_alumno WHERE id_alumno='$id_alumno' and estado=2) c on c.id_grado=n.id_grado and c.id_tema=n.id_tema and c.id_unidad=n.id_unidad and c.id_alumno='$id_alumno'
                WHERE n.id_alumno='$id_alumno' and n.estado=2
                GROUP by n.id_unidad,n.id_alumno,n.id_grado";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_alumno_admision_pago($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="update alumnos set id_alumno='". $dato['id_alumno']."',
        alum_nom='".$dato['alum_nom']."',
        alum_apater='".$dato['alum_apater']."',
        alum_amater='".$dato['alum_amater']."',
        estado_alum='".$dato['id_estadoa']."',
        cod_arpay='".$dato['cod_arpay']."',
        observaciones='".$dato['observaciones']."',
        fec_act= NOW(), user_act=".$id_usuario." where id_alumno='". $dato['id_alumno']."'";

        $sql2 = "insert into pago (id_alumno,id_prod_final,id_producto,id_producto1,id_producto2,id_producto3,id_producto4,id_producto5,id_producto6,estadop,estadop1,estadop2,estadop3,estadop4,estadop5,estadop6,id_grado, fec_matri,creado_x,monto,estado,estado_alumno, fec_reg, user_reg) 
        values ('".$dato['id_alumno']."','8','1','0','0','0','0','0','0', '1','0','0','0','0','0','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','50','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','1','0','2','0','0','0','0','0', '0','1','0','0','0','0','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','2','0','0','3','0','0','0','0', '0','0','1','0','0','0','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','3','0','0','0','4','0','0','0', '0','0','0','1','0','0','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','4','0','0','0','0','5','0','0', '0','0','0','0','1','0','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','5','0','0','0','0','0','6','0', '0','0','0','0','0','1','0','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','6','0','0','0','0','0','0','7', '0','0','0','0','0','0','1','". $dato['id_grado']."', NOW(),'".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario.")";
        
        $this->db->query($sql);
        $this->db->query($sql2);
    }

    function update_alumno_admision($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="update alumnos set id_alumno='". $dato['id_alumno']."',
            cod_arpay='".$dato['cod_arpay']."',
            alum_nom='".$dato['alum_nom']."',
            alum_apater='".$dato['alum_apater']."',
            alum_amater='".$dato['alum_amater']."',
            estado_alum='".$dato['id_estadoa']."',
            observaciones='".$dato['observaciones']."',
            fec_act= NOW(), user_act=".$id_usuario." where id_alumno='". $dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function valida_cod_arpay($dato){
        $sql = "SELECT * FROM alumnos WHERE tipo_ceba=2 AND cod_arpay='".$dato['cod_arpay']."' AND id_alumno<>'".$dato['id_alumno']."' AND estado_alum<>4";
        $query = $this->db->query($sql)->result_Array();
        return $query;  
    }

    function update_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumnos SET id_alumno='". $dato['id_alumno']."',
                dni_alumno='".$dato['dni_alumno']."',
                cod_arpay='".$dato['cod_arpay']."',
                alum_nom='".$dato['alum_nom']."',
                alum_apater='".$dato['alum_apater']."',
                alum_amater='".$dato['alum_amater']."',
                alum_nacimiento='".$dato['alum_nacimiento']."',
                alum_edad='".$dato['alum_edad']."',
                alum_sexo='".$dato['alum_sexo']."',
                alum_direc='".$dato['alum_direc']."',
                id_departamentoa='".$dato['id_departamentoa']."',
                id_provinciaa='".$dato['id_provinciaa']."',
                id_distritoa='".$dato['id_distritoa']."',
                alum_celular='".$dato['alum_celular']."',
                alum_cellcontac='".$dato['alum_cellcontac']."',
                alum_telf_casa='".$dato['alum_telf_casa']."',
                correo='".$dato['correo']."',
                alumno_institucionp='".$dato['alumno_institucionp']."',
                id_departamentop='".$dato['id_departamentop']."',
                id_provinciap='".$dato['id_provinciap']."',
                id_distritop= '".$dato['id_distritop']."',
                id_gradop='".$dato['id_gradop']."',
                titular1_dni='".$dato['titular1_dni']."',
                titular1_parentesco='".$dato['titular1_parentesco']."',
                titular1_apater='".$dato['titular1_apater']."',
                titular1_amater='".$dato['titular1_amater']."',
                titular1_nom='".$dato['titular1_nom']."',
                titular1_celular='".$dato['titular1_celular']."',
                titular1_telf_casa='".$dato['titular1_telf_casa']."',
                titular2_dni='".$dato['titular2_dni']."',
                titular2_parentesco='".$dato['titular2_parentesco']."',
                titular2_apater='".$dato['titular2_apater']."',
                titular2_amater='".$dato['titular2_amater']."',
                titular2_nom='".$dato['titular2_nom']."',
                titular2_celular='".$dato['titular2_celular']."',
                titular2_telf_casa='".$dato['titular2_telf_casa']."',
                id_grados_activos='".$dato['id_grados_activos']."',
                tipo='".$dato['tipo']."',
                id_medios='".$dato['id_medios']."',
                estado_alum='".$dato['estado']."',
                motivo_estado='".$dato['motivo_estado']."',
                fec_act= NOW(), user_act=".$id_usuario." where id_alumno='". $dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function update_estado_unidad_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d H:i:s');

        if($dato['estado']==4 || $dato['estado']==13 || $dato['estado']==15){
            $sql1 = "UPDATE pago SET estado_alumno='".$dato['estado']."', estado_pago_final='3',fec_act=NOW(),user_act =$id_usuario
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_alumno='".$dato['id_alumno']."'";
            $this->db->query($sql1);

        }elseif($dato['estado']==2){
            $sql = "UPDATE pago SET estado_alumno='".$dato['estado']."', estado_pago_final='1',fec_act=NOW(),user_act =$id_usuario
            where id_grado='".$dato['id_grado']."' and terminado <>1 and id_alumno='".$dato['id_alumno']."'";

            $this->db->query($sql);
        }elseif($dato['estado']==7){
            if($dato['get_id']==0){
                $sql2 = "insert into pago (id_alumno,id_prod_final,estado_pago_final,id_grado,creado_x,monto,estado,estado_alumno, fec_reg, user_reg)  
                values (
                '".$dato['id_alumno']."','8',1,'".$dato['id_grado']."','".$dato['user_reg']."','50','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','1',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','2',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','3',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','4',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','5',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario."),
               ('".$dato['id_alumno']."','6',1,'".$dato['id_grado']."','".$dato['user_reg']."','150','2','14',NOW(),".$id_usuario.")";

               $this->db->query($sql2);
            }
        }
    }

    function get_list_documento_alumno($id_alumno){
        $sql = "SELECT dd.id_detalle,dd.anio,CASE WHEN da.obligatorio>0 THEN 'Si' 
                ELSE 'No' END AS v_obligatorio,da.cod_documento,
                CONCAT(da.nom_documento,' - ',da.descripcion_documento) AS nom_documento,
                us.usuario_codigo AS usuario_subido,DATE_FORMAT(dd.fec_subido,'%d-%m-%Y') AS fec_subido,
                SUBSTRING_INDEX(dd.archivo,'/',-1) AS nom_archivo,dd.archivo
                FROM detalle_alumno_empresa dd
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=dd.id_documento
                LEFT JOIN users us ON us.id_usuario=dd.user_subido
                WHERE dd.id_alumno=$id_alumno AND dd.id_empresa=5 AND dd.id_sede=7 AND dd.estado=2
                ORDER BY dd.anio DESC,da.obligatorio DESC,da.cod_documento ASC,
                da.nom_documento ASC,da.descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_alumno_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,archivo,user_subido,fec_subido,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."','".$dato['archivo']."',$id_usuario,NOW(),2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_detalle_alumno_empresa($id_detalle){
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function delete_documento_alumno($dato){
        $sql = "UPDATE detalle_alumno_empresa SET archivo='',fec_subido=NULL,user_subido=0
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }
 
    function get_list_foto_matriculados($id_alumno){ 
        $sql = "SELECT de.* FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_observacion_alumno($id_alumno=null,$id_observacion=null){
        if(isset($id_observacion) && $id_observacion>0){
            $sql = "SELECT * FROM alumno_observaciones_general 
                    WHERE id_observacion=$id_observacion"; 
        }else{
            $sql = "SELECT ao.id_observacion,DATE_FORMAT(ao.fecha_obs,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                    us.usuario_codigo AS usuario,ao.observacion,ao.fecha_obs AS orden
                    FROM alumno_observaciones_general ao
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=ao.id_tipo
                    LEFT JOIN users us ON us.id_usuario=ao.usuario_obs
                    WHERE ao.id_alumno=$id_alumno AND ao.id_empresa=5 AND ao.id_sede=7 AND ao.estado=2
                    ORDER BY ao.fecha_obs DESC"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_tipo_obs(){
        $sql = "SELECT * FROM tipo_observacion
                WHERE estado=2 
                ORDER BY nom_tipo";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_observacion(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE tipo=1 AND id_nivel NOT IN (6,9) AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=5 AND id_sede=7 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_sede,id_alumno,id_tipo,observacion,
                fecha_obs,usuario_obs,estado,fec_reg,user_reg) 
                VALUES (5,7,'".$dato['id_alumno']."','".$dato['id_tipo']."','".$dato['observacion']."',
                '".$dato['fecha']."','".$dato['usuario']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=5 AND id_sede=7 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2 AND 
                id_observacion!='".$dato['id_observacion']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET id_tipo='".$dato['id_tipo']."',
                fecha_obs='".$dato['fecha']."',usuario_obs='".$dato['usuario']."',
                observacion='".$dato['observacion']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }

    function delete_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }
    //-----------------------------------CURSO-------------------------------------
    function get_list_curso(){
        $sql = "SELECT g.descripcion_grado,c.id_curso,a.nom_anio,DATE_FORMAT(c.fec_inicio, '%d/%m/%Y') AS fec_inicio,
                DATE_FORMAT(c.fec_fin, '%d/%m/%Y') AS fec_fin,c.obs_curso,s.nom_status,(SELECT COUNT(*) FROM alumnos al 
                WHERE al.id_grados_activos=c.id_grado AND al.estado_alum IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15)) AS cant_registrado,
                (SELECT COUNT(*) FROM alumnos al WHERE al.id_grados_activos=c.id_grado and al.estado_alum=2) AS cant_matriculado,
                (SELECT COUNT(*) FROM alumnos al LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno 
                WHERE al.estado_alum=2 AND DATEDIFF(CURDATE(),hi.fec_ingreso)<=5 AND al.id_grados_activos=c.id_grado) AS cant_activo,
                (SELECT COUNT(*) FROM alumnos al  LEFT JOIN hingresoceba hi on hi.id_alumno=al.id_alumno 
                WHERE al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>5 AND DATEDIFF(CURDATE(), hi.fec_ingreso)<=10 AND 
                al.id_grados_activos=c.id_grado) as cant_asistiendo,
                (SELECT COUNT(*) FROM view_contador_pago v WHERE v.id_grado=c.id_grado AND v.estado_alum=2) AS cant_ppendiente,
                (SELECT COUNT(*) FROM alumnos al LEFT JOIN hingresoceba hi ON hi.id_alumno=al.id_alumno 
                WHERE al.estado_alum=2 AND DATEDIFF(CURDATE(), hi.fec_ingreso)>10 AND al.id_grados_activos=c.id_grado) AS cant_sinasistir,
                (SELECT COUNT(*) FROM view_pago_final vp WHERE vp.id_grado=c.id_grado AND vp.id_prod_final=8 AND vp.pago_prod_final=1) AS cant_pmatricula,
                (SELECT COUNT(*) FROM view_finalizado vf WHERE vf.id_grado=c.id_grado AND vf.cantidad=6) AS cant_finalizados,
                (SELECT COUNT(*) FROM alumnos al WHERE al.id_grados_activos=c.id_grado AND al.estado_alum=13) AS cant_retirado,
                (SELECT COUNT(*) FROM alumnos al WHERE al.id_grados_activos=c.id_grado AND al.estado_alum=4) AS cant_anulado,
                DATE_FORMAT(c.inicio_curso,'%d/%m/%Y') AS inicio_curso,DATE_FORMAT(c.fin_curso,'%d/%m/%Y') AS fin_curso,c.grupo,c.unidad,
                CASE WHEN c.turno=1 THEN 'L-M-V' ELSE '' END AS nom_turno,s.color
                FROM curso c
                LEFT JOIN grado g ON c.id_grado=g.id_grado
                LEFT JOIN anio a ON c.id_anio=a.id_anio
                LEFT JOIN status s ON c.estado=s.id_status
                WHERE c.tipo_ceba=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_combo_curso(){
        $sql = "SELECT c.id_curso,CONCAT(g.descripcion_grado,' - ',a.nom_anio) AS nom_curso 
                FROM curso c
                LEFT JOIN grado g ON g.id_grado=c.id_grado
                LEFT JOIN anio a ON a.id_anio=c.id_anio
                WHERE c.estado=2 AND c.tipo_ceba=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_curso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO curso (tipo_ceba,grupo,unidad,turno,id_grado,id_anio,id_copiar,fec_inicio,fec_fin,inicio_curso,fin_curso,
                estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['grupo']."','".$dato['unidad']."','".$dato['turno']."','".$dato['id_grado']."',
                '".$dato['id_anio']."','".$dato['id_copiar']."','".$dato['fec_inicio']."','".$dato['fec_fin']."','".$dato['inicio_curso']."',
                '".$dato['fin_curso']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_curso($id_curso){
        if(isset($id_curso) && $id_curso > 0){
            $sql = "SELECT * FROM curso WHERE id_curso=$id_curso";
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function update_curso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE curso SET grupo='".$dato['grupo']."',unidad='".$dato['unidad']."',turno='".$dato['turno']."',
                id_anio='".$dato['id_anio']."',id_grado='".$dato['id_grado']."',fec_inicio='".$dato['fec_inicio']."',
                fec_fin='".$dato['fec_fin']."',inicio_curso='".$dato['inicio_curso']."',fin_curso='".$dato['fin_curso']."',
                estado='".$dato['id_status']."',fec_act=NOW(),user_act=$id_usuario
                where id_curso='". $dato['id_curso']."'";
        $this->db->query($sql);
    }

    function get_list_requisito_curso($id_curso){
        $sql = "SELECT r.*, tr.nom_tipo_requisito, s.nom_status 
                FROM requisito r
                LEFT JOIN tipo_requisito tr on r.id_tipo_requisito=tr.id_tipo_requisito
                LEFT JOIN status s on r.estado=s.id_status
                WHERE id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tema_asociar_curso($id_curso){
        $sql = "SELECT r.*,tr.*,u.*,asi.*,a.*,CASE WHEN r.id_profesor>0 THEN 
                CONCAT(usuario_apater,' ',usuario_amater,' ',usuario_nombres) 
                ELSE '' END AS nom_profesor 
                FROM tema_asociar r
                LEFT JOIN tema tr ON r.id_tema=tr.id_tema
                LEFT JOIN unidad u ON r.id_unidad=u.id_unidad
                LEFT JOIN asignatura asi ON r.id_asignatura=asi.id_asignatura
                LEFT JOIN area a ON r.id_area=a.id_area
                LEFT JOIN status s ON r.estado=s.id_status
                LEFT JOIN users us ON us.id_usuario=r.id_profesor
                where id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_asociar_curso($id_curso){
        $sql = "SELECT al.*, u.nom_unidad,a.descripcion_area,ea.*,ea.nom_estadoa 
                FROM alumno_asociar r
                LEFT JOIN alumnos al on r.id_alumno=al.id_alumno
                LEFT JOIN unidad u on r.id_unidad=u.id_unidad
                LEFT JOIN area a on r.id_area=a.id_area
                LEFT JOIN estadoa ea on ea.id_estadoa=al.estado_alum
                WHERE id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tipo_requisito(){
        $sql = "SELECT * FROM tipo_requisito";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_requisito($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO requisito (id_curso,id_grado,id_tipo_requisito,desc_requisito,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_curso']."','".$dato['id_grado']."','".$dato['id_tipo_requisito']."','".$dato['desc_requisito']."',
                '".$dato['id_status']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_requisito($id_requisito){
        if(isset($id_requisito) && $id_requisito > 0){
            $sql = "SELECT * FROM requisito WHERE id_requisito=$id_requisito";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_requisito($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE requisito SET id_tipo_requisito='".$dato['id_tipo_requisito']."',desc_requisito='".$dato['desc_requisito']."',
                estado='".$dato['id_status']."',fec_act=NOW(),user_act=$id_usuario  
                WHERE id_requisito='". $dato['id_requisito']."'";
        $this->db->query($sql);
    }

    function get_list_profesor_combo(){
        $sql = "SELECT id_usuario AS id_profesor,CONCAT(usuario_apater,' ',usuario_amater,' ',usuario_nombres) AS nom_profesor
                FROM users 
                WHERE id_nivel=14 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function varios_tema($id_unidad,$id_area,$id_asignatura,$id_grado){
        $sql = "SELECT * FROM tema WHERE tipo_ceba=2 AND id_unidad=$id_unidad AND id_area=$id_area AND 
                id_asignatura=$id_asignatura AND id_grado=$id_grado AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tema_asociar($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tema_asociar (id_curso, id_unidad,id_area,id_asignatura,id_tema,id_profesor,estado,fec_reg,user_reg) 
                values ('".$dato['id_curso']."','".$dato['id_unidad']."','".$dato['id_area']."','".$dato['id_asignatura']."',
                '".$dato['id_tema']."','".$dato['id_profesor']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_tema_asociar($id_tema_asociar){
        if(isset($id_tema_asociar) && $id_tema_asociar > 0){
            $sql = "SELECT t.*,g.referencia,g.desc_tema FROM tema_asociar t
                    LEFT JOIN tema  g on t.id_tema=g.id_tema            
                    WHERE id_tema_asociar=$id_tema_asociar";
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function update_tema_asociar($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tema_asociar SET id_unidad='". $dato['id_unidad']."',id_area='". $dato['id_area']."',
                id_asignatura='". $dato['id_asignatura']."',id_tema='". $dato['id_tema']."',
                id_profesor='". $dato['id_profesor']."',fec_act= NOW(),user_act=$id_usuario 
                WHERE id_tema_asociar='". $dato['id_tema_asociar']."'";
        $this->db->query($sql);
    }

    function valida_insert_alumno_curso($dato){
        $sql = "SELECT * from alumno_asociar 
                WHERE id_curso='".$dato['id_curso']."' AND id_alumno='".$dato['id_alumno']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_alumno_curso($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_asociar (id_alumno,id_curso,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_curso']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_cerrar_curso($id_curso){
        $sql = "SELECT c.* FROM alumno_asociar c 
                LEFT JOIN alumnos al ON al.id_alumno=c.id_alumno
                WHERE c.id_curso=$id_curso AND al.estado_alum=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cerrar_curso($id_curso){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE curso SET estado_cierre=1,fec_cierre=NOW(),user_cierre=$id_usuario 
                WHERE id_curso=$id_curso";
        $this->db->query($sql);
    }
    //-----------------------------------TEMA-------------------------------------
    function v_suma_tiempo_slide(){
        $sql = "SELECT * from suma_tiempo_slide";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function v_suma_tiempo_repaso(){
        $sql = "SELECT * from suma_tiempo_repaso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function v_suma_tiempo_slide_repaso(){
        $sql = "SELECT * from suma_slide_repaso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function v_suma_total_final(){
        $sql = "SELECT * from tiempo_total_final";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_tema_grado($id_grado){
        if($id_grado==5){
            $parte = "AND t.estado=3";
        }else{
            $parte = "AND t.estado IN (2) AND t.id_grado=$id_grado";
        }
        $sql = "SELECT t.id_grado,t.fec_revisado,t.user_revisado,g.descripcion_grado,t.tiempo_archivos,
                t.estado_contenido,t.id_tema,t.referencia, a.descripcion_area,t.desc_tema,s.nom_status,
                u.nom_unidad,asi.descripcion_asignatura,i.foto,ts.t_img,ts.t_video,ci.total as total_intros,
                ce.cant_examenes,r.cant_repaso,e.usuario_nombres as nom_revisado,e.usuario_apater as apater_revisado,
                e.usuario_amater as amater_revisado,DATE_FORMAT(t.fec_revisado, '%d/%m/%Y') as fecha_revisado
                from tema t
                left join grado       g on t.id_grado=g.id_grado
                left join area        a on t.id_area=a.id_area
                left join status      s on t.estado=s.id_status
                left join unidad      u on t.id_unidad=u.id_unidad
                left join asignatura  asi on t.id_asignatura=asi.id_asignatura
                left join intro       i on i.id_tema=t.id_tema and i.estado=2
                left join contador_tipo_slide ts on ts.id_tema=t.id_tema
                left join cont_intro ci on ci.id_tema=t.id_tema
                left join cont_examen ce on ce.id_tema=t.id_tema
                left join cont_repaso r on r.id_tema=t.id_tema
                left join users e on e.id_usuario=t.user_revisado
                where t.tipo_ceba=2 $parte order by t.id_unidad,t.id_area ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_tema_revisado($id_tema){
        $sql = "SELECT * from tema where id_tema=$id_tema";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function cambiar_revisado_tema($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE tema SET fec_revisado=NOW(),user_revisado=$id_usuario WHERE id_tema='".$dato['id']."'";

        $this->db->query($sql);
    }

    function borrar_revisado_tema($dato){
        $sql="UPDATE tema SET fec_revisado='',user_revisado='' WHERE id_tema='".$dato['id']."'";
        $this->db->query($sql);
    }

    function get_list_dependencia_asignatura($id_area){
        $sql = "SELECT * FROM asignatura WHERE tipo_ceba=2 AND id_area =$id_area and estado=2
                ORDER BY nom_asignatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tema($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tema (tipo_ceba,id_grado,id_area,id_asignatura,id_unidad,referencia,desc_tema,estado,
                estado_contenido,fec_reg,user_reg) 
                VALUES (2,'".$dato['id_grado']."','".$dato['id_area']."','".$dato['id_asignatura']."',
                '".$dato['id_unidad']."','".$dato['referencia']."','".$dato['desc_tema']."','".$dato['id_status']."',
                2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_temas($id_tema){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT t.*, g.descripcion_grado,t.id_tema,t.referencia,a.id_area, a.descripcion_area,t.desc_tema,s.nom_status,
                    u.nom_unidad,asi.descripcion_asignatura,t.estado,t.id_unidad
                    FROM tema t
                    LEFT JOIN grado       g on t.id_grado=g.id_grado
                    LEFT JOIN area        a on t.id_area=a.id_area
                    LEFT JOIN status      s on t.estado=s.id_status
                    LEFT JOIN unidad      u on t.id_unidad=u.id_unidad
                    LEFT JOIN asignatura  asi on t.id_asignatura=asi.id_asignatura 
                    WHERE t.id_tema =".$id_tema ;
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function update_tema($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="update tema set id_grado='". $dato['id_grado']."', id_area='". $dato['id_area']."',id_asignatura='". $dato['id_asignatura']."',estado='". $dato['id_status']."',id_unidad='". $dato['id_unidad']."',referencia='". $dato['referencia']."',desc_tema='". $dato['desc_tema']."',
        fec_act= NOW(),
        user_act=".$id_usuario."  where id_tema='". $dato['id_tema']."'";
        $this->db->query($sql);

        $sql2="update intro set id_unidad='". $dato['id_unidad']."' where id_tema='". $dato['id_tema']."' and estado=2";
        $this->db->query($sql2);

        $sql3="update slide set id_unidad='". $dato['id_unidad']."' where id_tema='". $dato['id_tema']."' and estado=2";
        $this->db->query($sql3);

        $sql4="update examen set id_unidad='". $dato['id_unidad']."' where id_tema='". $dato['id_tema']."' and estado=2";
        $this->db->query($sql4);

        $sql5="update repaso set id_unidad='". $dato['id_unidad']."' where id_tema='". $dato['id_tema']."' and estado=2";
        $this->db->query($sql5);

        $sql6="update respuesta set id_unidad='". $dato['id_unidad']."' where id_tema='". $dato['id_tema']."' and estado=2";
        $this->db->query($sql6);
    }

    function delete_tema($id_tema){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE tema SET estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_tema=$id_tema AND estado=2";
        $sql2="UPDATE intro SET estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_tema=$id_tema AND estado=2";
        $sql3="UPDATE slide SET estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_tema=$id_tema AND estado=2";
        $sql4="UPDATE repaso SET estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_tema=$id_tema AND estado=2";
        $sql5="UPDATE examen SET estado=4,fec_eli=NOW(),user_eli=$id_usuario WHERE id_tema=$id_tema AND estado=2";
        $this->db->query($sql);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->query($sql5);
    }

    function grado_tema($id_grado){
        $sql="SELECT * FROM tema WHERE tipo_ceba=2 AND id_grado=$id_grado AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_dependencia_area($id_tema=null){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT t.*,a.descripcion_area,u.nom_unidad,asi.descripcion_asignatura FROM tema t
            left join area a on t.id_area=a.id_area
            left join unidad u on t.id_unidad=u.id_unidad
            left join asignatura  asi on t.id_asignatura=asi.id_asignatura 
            where t.id_tema ='".$id_tema."'";
        }else{
           /* $sql = "select * from asignatura";*/
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_reg_intro($dato){ 
        $sql="SELECT * from intro where id_grado='".$dato['id_grado']."' and estado=2 and id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_tema($dato){
        $sql = "SELECT id_area,id_unidad,peso_archivos,tiempo_archivos 
                from tema where id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_intro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];
        $path = $_FILES['fotoimg']['name'];
        $path2 = $_FILES['foto2']['name'];
        $path3 = $_FILES['foto3']['name'];

        $size1 = $_FILES['fotoimg']['size'];
        $size2 = $_FILES['foto2']['size'];
        $size3 = $_FILES['foto3']['size'];

        $peso1=$size1;
        $peso2=$size2;
        $peso3=$size3;

        $suma=$peso1+$peso2+$peso3+$dato['peso_actual'];
        
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
        $ext3 = pathinfo($path3, PATHINFO_EXTENSION);

        //var_dump($peso1);

        $mi_archivo = 'fotoimg';
        //$config['upload_path'] = './intro/';/// ruta del fileserver para almacenar el documento
        
        $config['upload_path'] = './temas/'.$id_tema.'/intro';
        $nombre="intro".$fecha."_".rand(1,200);
        $config['file_name'] = $nombre.".".strtolower($ext);

        $mi_archivo2 = 'foto2';
        $config['file_name2'] = $nombre.".".strtolower($ext2);

        $mi_archivo3 = 'foto3';
        $config['file_name3'] = $nombre.".".strtolower($ext3);

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
        $ruta2= 'temas/'.$id_tema.'/intro'.'/'.$nombre."1.".strtolower($ext2);
        $ruta3= 'temas/'.$id_tema.'/intro'.'/'.$nombre."2.".strtolower($ext3);

        $config['allowed_types'] = "png|PNG";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if (!$this->upload->do_upload($mi_archivo2)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if (!$this->upload->do_upload($mi_archivo3)) {
            $data['uploadError'] = $this->upload->display_errors();
        }
        $data['uploadSuccess'] = $this->upload->data();

        if ($path!="")
        {
            $sql = "insert into intro (id_grado,
            id_tema,
            referencia,
            id_unidad,
            id_area,
            id_tipo,
            orden,
            estado, 
            fec_reg, user_reg, foto,foto2,foto3,peso1,peso2,peso3,fec_subido,user_subido)

            values ('".$dato['id_grado']."',
            '".$dato['referencia']."',
            '".$dato['referencia']."',
            '".$dato['id_unidad']."',
            '".$dato['id_area']."',
            '".$dato['id_tipo']."',
            '".$dato['orden']."',
            '".$dato['id_status']."',
            NOW(),".$id_usuario.",'".$ruta."','".$ruta2."','".$ruta3."','".$peso1."','".$peso2."','".$peso3."', NOW(),".$id_usuario.")";
        }
        else{
            $sql = "insert into intro (id_grado,
             id_tema,
             referencia,
             id_tipo,
             orden,
             estado, 
             fec_reg, user_reg, fec_subido,user_subido)

            values ('".$dato['id_grado']."',
            '".$dato['referencia']."',
            '".$dato['referencia']."',
            '".$dato['id_tipo']."',
            '".$dato['orden']."',
            '".$dato['id_status']."',
                NOW(),".$id_usuario.",NOW(),".$id_usuario.")";
        }
        //echo $sql;
        $this->db->query($sql);

        $sql2="UPDATE tema set peso_archivos='".$suma."' where id_tema='". $dato['referencia']."' and estado=2";
        $this->db->query($sql2);
    }

    function valida_cant_intro($dato){ 
        $sql="SELECT * from intro where estado=2 and id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_slide($dato){ 
        $sql="SELECT * from slide where estado=2 and id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_repaso($dato){ 
        $sql="SELECT * from repaso where estado=2 and id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_cant_preguntas($dato){ 
        $sql="SELECT * from examen where estado=2 and id_tema='".$dato['referencia']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function actu_estado_contenido($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE tema set estado_contenido='".$dato['estado_contenido']."' where id_tema='".$dato['referencia']."'";
        $this->db->query($sql);
    }

    function valida_reg_slide($dato){
        $sql="SELECT * from slide where id_grado='".$dato['id_grado']."' and estado=2 and id_tema='".$dato['referencia']."' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_slide($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];
        $path = $_FILES['imagen_sl']['name'];
        $size1 = $_FILES['imagen_sl']['size'];

        $peso=$size1;
        $suma=$peso+$dato['peso_actual'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'imagen_sl';
        //$config['upload_path'] = './slide/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './temas/'.$id_tema.'/slides';
        $config['file_name'] = "slide".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'temas/'.$id_tema.'/slides'.'/'.$config['file_name'];

        $config['allowed_types'] = "png|mp4|flv";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if ($path!=""){
            $sql = "insert into slide (id_grado,id_tema,id_unidad,referencia,id_tipo_slide,orden,tiempo,estado,
            fec_reg, user_reg, imagen,peso)

            values ('".$dato['id_grado']."',
            '".$dato['referencia']."',
            '".$dato['id_unidad']."',
            '".$dato['referencia']."',
            '".$dato['id_tipo_slide']."',
            '".$dato['orden']."',
            '".$dato['tiempo']."',
            '".$dato['id_status']."',
            NOW(),".$id_usuario.",'".$ruta."','".$peso."')";
        }else{
             $sql = "insert into slide (id_grado,id_tema,id_unidad,referencia,id_tipo_slide,orden,tiempo,estado,
             fec_reg, user_reg)

                values ('".$dato['id_grado']."',
                '".$dato['referencia']."',
                '".$dato['id_unidad']."',
                '".$dato['referencia']."',
                '".$dato['id_tipo_slide']."',
                '".$dato['orden']."',
                '".$dato['tiempo']."',
                '".$dato['id_status']."',
                 NOW(),".$id_usuario.")";
        }
        
        $this->db->query($sql);
    }

    function valida_reg_repaso($dato){
        $sql="SELECT * from repaso where id_grado='".$dato['id_grado']."' and estado=2 and id_tema='".$dato['referencia']."' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_repaso($dato){
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['imagen']['name'];

        $size1 = $_FILES['imagen']['size'];

        $peso=$size1;
        $suma=$peso+$dato['peso_actual'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './temas/'.$id_tema.'/repaso';
        $config['file_name'] = "repaso".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'temas/'.$id_tema.'/repaso'.'/'.$config['file_name'];

        $config['allowed_types'] = "png|mp4";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if ($path!=""){
            $sql = "insert into repaso (
            id_grado,
            id_tema,
            id_unidad,
            referencia,
            id_tipo_repaso,
            orden,
            tiempo,
            estado,
            fec_reg, user_reg, imagen,peso, fec_subido, user_subido) 
            values ('". $dato['id_grado']."',
                '". $dato['referencia']."',
                '". $dato['id_unidad']."',
                '". $dato['referencia']."',
                '". $dato['id_tipo']."',
                '". $dato['orden']."',
                '". $dato['tiempo']."',
                '". $dato['id_status']."',
                 NOW(),".$id_usuario.",'".$ruta."','".$peso."',NOW(),".$id_usuario.")";
        }else{
            $sql = "insert into repaso (
                id_grado,
                id_tema,
                id_unidad,
                referencia,
                id_tipo_repaso,
                orden,
                tiempo,
                estado,
                fec_reg, user_reg, fec_subido, user_subido) 
                values ('". $dato['id_grado']."',
                    '". $dato['referencia']."',
                    '". $dato['id_unidad']."',
                    '". $dato['referencia']."',
                    '". $dato['id_tipo']."',
                    '". $dato['orden']."',
                    '". $dato['tiempo']."',
                    '". $dato['id_status']."',
                     NOW(),".$id_usuario.",NOW(),".$id_usuario.")";
        }

        $this->db->query($sql);
    }

    function valida_reg_examen_v2($dato){
        $sql = "SELECT * from examen where id_grado='".$dato['id_grado']."' and estado=2 and id_tema='".$dato['id_tema']."' and 
                id_unidad='".$dato['id_unidad']."' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_examen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema=$dato['referencia'];
        $path = $_FILES['foto1']['name'];
        $size1 = $_FILES['foto1']['size'];

        $peso=$size1;
        $suma=$peso+$dato['peso_actual'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);


        $mi_archivo = 'foto1';
        //$config['upload_path'] = './examen/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './temas/'.$id_tema.'/examen';
        $nombre="ex".$fecha."_".rand(1,200);
        $config['file_name'] = $nombre.".".$ext;


        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'temas/'.$id_tema.'/examen'.'/'.$config['file_name'];

        $config['allowed_types'] = "png|jpg|gif|mp4";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
            }
            $data['uploadSuccess'] = $this->upload->data();


                if ($path!=""){
                    $sql = "insert into examen (
                    id_grado,
                    id_tema,
                    id_unidad,
                    referencia,
                    orden,
                    id_tipo_examen,
                    estado,
                    fec_reg, user_reg,
                    foto1,peso,fec_subido,user_subido,
                    pregunta
                    
                    ) 
                    values (
                    '". $dato['id_grado']."',
                    '". $dato['referencia']."',
                    '". $dato['id_unidad']."',
                    '". $dato['referencia']."',
                    '". $dato['orden']."',
                    '". $dato['id_tipo_examen']."',
                    '". $dato['id_status']."',
                    NOW(),".$id_usuario.",
                    '".$ruta."','".$peso."',
                    NOW(),".$id_usuario.",
                    '". $dato['pregunta']."'
                    
                )";
                }else{
                    $sql = "insert into examen (
                        id_grado,
                        id_tema,
                        id_unidad,
                        referencia,
                        orden,
                        id_tipo_examen,
                        estado,
                        fec_reg, user_reg,
                        fec_subido,user_subido,
                        pregunta
                        
                        ) 
                        values (
                        '".$dato['id_grado']."',
                        '".$dato['referencia']."',
                        '".$dato['id_unidad']."',
                        '".$dato['referencia']."',
                        '".$dato['orden']."',
                        '".$dato['id_tipo_examen']."',
                        '".$dato['id_status']."',
                        NOW(),".$id_usuario.",
                        NOW(),".$id_usuario.",
                        '". $dato['pregunta']."'
                        
                        
                    )";
                }
            $this->db->query($sql);

            $sql2 = "INSERT into respuesta (id_examen, id_grado,id_tema,id_unidad,referencia,id_tipo_examen,alternativa, estado, fec_reg, user_reg) 
            values ((select id_examen from examen where id_grado='".$dato['id_grado']."' and id_tema='".$dato['referencia']."' and id_unidad='".$dato['id_unidad']."' and referencia='".$dato['referencia']."' and estado=2 order by id_examen desc limit 1),
            '".$dato['id_grado']."','".$dato['referencia']."','".$dato['id_unidad']."','".$dato['referencia']."','".$dato['id_tipo_examen']."','".$dato['alternativa1']."','2', NOW(),".$id_usuario.")";
            $this->db->query($sql2);

            $sql3 = "INSERT into respuesta (id_examen, id_grado,id_tema,id_unidad,referencia,id_tipo_examen,alternativa, estado, fec_reg, user_reg) 
            values ((select id_examen from examen where id_grado='".$dato['id_grado']."' and id_tema='".$dato['referencia']."' and id_unidad='".$dato['id_unidad']."' and referencia='".$dato['referencia']."' and estado=2 order by id_examen desc limit 1),
            '".$dato['id_grado']."','".$dato['referencia']."','".$dato['id_unidad']."','".$dato['referencia']."','".$dato['id_tipo_examen']."','".$dato['alternativa2']."','2', NOW(),".$id_usuario.")";
            $this->db->query($sql3);

            $sql4 = "INSERT into respuesta (id_examen, id_grado,id_tema,id_unidad,referencia,id_tipo_examen,alternativa,correcto, estado, fec_reg, user_reg) 
            values ((select id_examen from examen where id_grado='".$dato['id_grado']."' and id_tema='".$dato['referencia']."' and id_unidad='".$dato['id_unidad']."' and referencia='".$dato['referencia']."' and estado=2 order by id_examen desc limit 1),
            '".$dato['id_grado']."','".$dato['referencia']."','".$dato['id_unidad']."','".$dato['referencia']."','".$dato['id_tipo_examen']."','".$dato['alternativa3']."','1','2', NOW(),".$id_usuario.")";
            $this->db->query($sql4);

    }

    function excel_temas_parametro($parametro){ 
        if($parametro==5){
            $parte="AND t.estado=3";
        }else{
            $parte="AND t.estado IN (2) AND t.id_grado=$parametro";
        }

        $sql = "SELECT g.descripcion_grado,t.tiempo_archivos,t.estado_contenido,t.id_tema,t.referencia, a.descripcion_area,t.desc_tema,
                s.nom_status,u.nom_unidad,asi.descripcion_asignatura,i.foto,
                ts.t_img,ts.t_video,ci.total as total_intros,ce.cant_examenes,r.cant_repaso
                from tema t
                left join grado       g on t.id_grado=g.id_grado
                left join area        a on t.id_area=a.id_area
                left join status      s on t.estado=s.id_status
                left join unidad      u on t.id_unidad=u.id_unidad
                left join asignatura  asi on t.id_asignatura=asi.id_asignatura
                left join intro       i on i.id_tema=t.id_tema and i.estado=2
                left join contador_tipo_slide ts on ts.id_tema=t.id_tema
                left join cont_intro ci on ci.id_tema=t.id_tema
                left join cont_examen ce on ce.id_tema=t.id_tema
                left join cont_repaso r on r.id_tema=t.id_tema
                WHERE t.tipo_ceba=2 $parte order by t.referencia asc";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function v_suma_total_slide_repaso(){
        $sql = "SELECT * from total_sr";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_intro_tema($id_tema){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT i.*, t.referencia as referencia_tema, t.desc_tema, u.usuario_codigo,DATE_FORMAT(i.fec_reg, '%d/%m/%Y %H:%i:%s') as fecha_registro,
            u.usuario_apater,u.usuario_amater, p.nom_tipo
            from intro i
            left join tema t on t.id_tema=i.id_tema
            left join tipo p on p.id_tipo=i.id_tipo
            left join users u on u.id_usuario=t.user_reg
            where i.estado ='2' and i.id_tema =".$id_tema ;
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function get_slide_tema($id_tema){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT i.*, t.nom_tipo_slide,u.usuario_codigo,DATE_FORMAT(i.fec_reg, '%d/%m/%Y %H:%i:%s') as fecha_registro,
            u.usuario_apater,u.usuario_amater
            from slide i
            left join tipo_slide t on t.id_tipo_slide=i.id_tipo_slide
            left join users u on u.id_usuario=i.user_reg
            where i.estado ='2' and i.id_tema =$id_tema order by i.orden asc";
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function get_repaso_tema($id_tema){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT i.*, u.usuario_nombres, u.usuario_apater, t.nom_tipo,u.usuario_codigo,
            DATE_FORMAT(i.fec_reg, '%d/%m/%Y %H:%i:%s') as fecha_registro
            from repaso i
            left join users u on u.id_usuario=i.user_reg
            left join tipo t on t.id_tipo=i.id_tipo_repaso
            where i.estado ='2' and i.id_tema =".$id_tema ;
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function get_examen_tema($id_tema){
        if(isset($id_tema) && $id_tema > 0){
            $sql = "SELECT i.*, te.nom_tipo_examen
            from examen i
            left join tipo_examen te on te.id_tipo_examen=i.id_tipo_examen and te.estado=1
            where i.estado ='2' and i.id_tema =".$id_tema ;
            $query = $this->db->query($sql)->result_Array();
            return $query;
        }
    }

    function v_peso_slide($id_tema){
        $sql = "SELECT * from suma_peso_slide where id_tema=$id_tema";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function peso_examen($id_tema){
        $sql = "SELECT * from suma_peso_examen where id_tema=$id_tema";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_intro($id_intro){
        if(isset($id_intro) && $id_intro > 0){
            $sql = "select * from intro where id_intro=".$id_intro;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_intro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];

        $path = $_FILES['fotoimg']['name'];
        $path2 = $_FILES['foto2']['name'];
        $path3 = $_FILES['foto3']['name'];

        $size1 = $_FILES['fotoimg']['size'];
        $size2 = $_FILES['foto2']['size'];
        $size3 = $_FILES['foto3']['size'];

        $peso1=$size1;
        $peso2=$size2;
        $peso3=$size3;

        /*if($path!='' && $path2!='' && $path3!=''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1']-$dato['peso_antiguo2']-$dato['peso_antiguo3'];
            $peso_nuevo=$peso_actualizado+$peso1+$peso2+$peso3;
        }else if($path!='' && $path2!='' && $path3==''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1']-$dato['peso_antiguo2'];
            $peso_nuevo=$peso_actualizado+$peso1+$peso2;
        }else if($path!='' && $path2=='' && $path3==''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1'];
            $peso_nuevo=$peso_actualizado+$peso1;
        }else if($path=='' && $path2!='' && $path3!=''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo2']-$dato['peso_antiguo3'];
            $peso_nuevo=$peso_actualizado+$peso2+$peso3;
        }else if($path!='' && $path2=='' && $path3!=''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1']-$dato['peso_antiguo3'];
            $peso_nuevo=$peso_actualizado+$peso1+$peso3;
        }else if($path=='' && $path2=='' && $path3!=''){
            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo3'];
            $peso_nuevo=$peso_actualizado+$peso3;
        }*/

        $ext =  pathinfo($path,  PATHINFO_EXTENSION);
        $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
        $ext3 = pathinfo($path3, PATHINFO_EXTENSION);

        $mi_archivo = 'fotoimg';
        $mi_archivo2 = 'foto2';
        $mi_archivo3 = 'foto3';
        
        $config['upload_path'] = './temas/'.$id_tema.'/intro';// ruta del fileserver para almacenar el documento
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre="intro".$fecha."_".rand(1,200);

        if($dato['img1']!=""){
            $config['file_name'] = $nombre.".".strtolower($ext);
            
        }
        if($dato['img2']!=""){
            
            $config['file_name'] = $nombre.".".strtolower($ext2);
            
        }
        if($dato['img3']!=""){
            $config['file_name'] = $nombre.".".strtolower($ext3);
            
        }

        $config['allowed_types'] = "png|PNG";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);

        if ($dato['img1']!="" && $dato['img2']!="" && $dato['img3']!=""){
            $ruta = 'temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
            $ruta2= 'temas/'.$id_tema.'/intro'.'/'.$nombre."1.".strtolower($ext2);
            $ruta3= 'temas/'.$id_tema.'/intro'.'/'.$nombre."2.".strtolower($ext3);

            if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
            if (!$this->upload->do_upload($mi_archivo2)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
            if (!$this->upload->do_upload($mi_archivo3)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }

        }else if($dato['img1']!="" && $dato['img2']!="" && $dato['img3']==""){
            $ruta = 'temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
            $ruta2='temas/'.$id_tema.'/intro'.'/'.$nombre."1.".strtolower($ext2);
           
            $dato['peso_actualizado']=$dato['peso_actual']-$dato['peso_antiguo1']-$dato['peso_antiguo2'];
            $peso_nuevo=$peso1+$peso2+$dato['peso_actualizado'];

            if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
            if (!$this->upload->do_upload($mi_archivo2)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }

        }else if($dato['img1']!="" && $dato['img2']=="" && $dato['img3']==""){
            $ruta = 'temas/'.$id_tema.'/intro'.'/'.$config['file_name'];

            if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
        }else if($dato['img1']=="" && $dato['img2']!="" && $dato['img3']==""){
            $ruta2='temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
            
            if (!$this->upload->do_upload($mi_archivo2)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }

        }else if($dato['img1']=="" && $dato['img2']!="" && $dato['img3']!=""){
            $ruta2='temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
            $ruta3='temas/'.$id_tema.'/intro'.'/'.$nombre."1.".strtolower($ext3);

            if (!$this->upload->do_upload($mi_archivo2)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
            if (!$this->upload->do_upload($mi_archivo3)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
           
        }else if($dato['img1']=="" && $dato['img2']=="" && $dato['img3']!=""){
            $ruta3='temas/'.$id_tema.'/intro'.'/'.$config['file_name'];

            if (!$this->upload->do_upload($mi_archivo3)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
        }
        else if($dato['img1']!="" && $dato['img2']=="" && $dato['img3']!=""){
            $ruta='temas/'.$id_tema.'/intro'.'/'.$config['file_name'];
            $ruta3='temas/'.$id_tema.'/intro'.'/'.$nombre."1.".strtolower($ext3);

            if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
            if (!$this->upload->do_upload($mi_archivo3)) {
                $data['uploadError'] = $this->upload->display_errors();
                
            }
        }

        if ($dato['img1']!="" && $dato['img2']!="" && $dato['img3']!=""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.", foto='".$ruta."',foto2='".$ruta2."',foto3='".$ruta3."',peso1='".$peso1."',peso2='".$peso2."',peso3='".$peso3."'  
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']!="" && $dato['img2']!="" && $dato['img3']==""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',peso1='".$peso1."',peso2='".$peso2."'
            fec_act=NOW(), user_act=".$id_usuario.", foto='".$ruta."',foto2='".$ruta2."'  
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']!="" && $dato['img2']=="" && $dato['img3']==""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.", foto='".$ruta."',peso1='".$peso1."'
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']=="" && $dato['img2']!="" && $dato['img3']==""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.", foto2='".$ruta2."',peso2='".$peso2."'
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']=="" && $dato['img2']!="" && $dato['img3']!=""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.", foto2='".$ruta2."',foto3='".$ruta3."',peso2='".$peso2."',peso3='".$peso3."' 
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']=="" && $dato['img2']=="" && $dato['img3']!=""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.",foto3='".$ruta3."',peso3='".$peso3."'
            where id_intro='".$dato['id_intro']."'  ";
        }else if($dato['img1']!="" && $dato['img2']=="" && $dato['img3']!=""){
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario.",foto='".$ruta."',foto3='".$ruta3."',peso1='".$peso1."',peso3='".$peso3."'
            where id_intro='".$dato['id_intro']."'  ";
        }
        else{
            $sql="update intro set orden='".$dato['orden']."', estado='".$dato['id_status']."',
            fec_act=NOW(), user_act=".$id_usuario." 
            where id_intro='".$dato['id_intro']."'  ";
        }
        $this->db->query($sql);
    }

    function delete_intro($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" update intro set estado='4', fec_eli= NOW(),user_eli=".$id_user." where id_intro='".$dato['id_intro']."'";
        $this->db->query($sql);
    }

    function get_nom_img_intro($id_intro){
        if(isset($id_intro) && $id_intro > 0){
            $sql = "SELECT foto,foto2,foto3,peso1,peso2,peso3 from intro where id_intro=".$id_intro;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_img1_intro($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE intro set foto='',peso1=0, fec_act= NOW(),user_act=".$id_user." where id_intro='".$dato['id_intro']."'";
        $this->db->query($sql);
    }

    function delete_img2_intro($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE intro set foto2='',peso2=0, fec_act= NOW(),user_act=".$id_user." where id_intro='".$dato['id_intro2']."'";
        $this->db->query($sql);
    }

    function delete_img3_intro($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE intro set foto3='',peso3=0, fec_act= NOW(),user_act=".$id_user." where id_intro='".$dato['id_intro3']."'";
        $this->db->query($sql);
    }

    function get_id_slide($id_slide){
        if(isset($id_slide) && $id_slide > 0){
            $sql = "select * from slide where id_slide=".$id_slide;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function update_slide($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];
        $path = $_FILES['imagen_sl']['name'];
        $size1 = $_FILES['imagen_sl']['size'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $mi_archivo = 'imagen_sl';
        //$config['upload_path'] = './slide/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './temas/'.$id_tema.'/slides';
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $config['file_name'] = "slide".$fecha."_".rand(1,200).".".$ext;

        $ruta = 'temas/'.$id_tema.'/slides'.'/'.$config['file_name'];

        $config['allowed_types'] = "png|jpg|gif|mp4|flv";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            $sql="update slide set orden='".$dato['orden']."', tiempo='".$dato['tiempo']."', 
            id_tipo_slide='".$dato['id_tipo_slide']."', estado='".$dato['id_status']."', peso=".$size1.",
            fec_act=NOW(), user_act=".$id_usuario.", imagen='".$ruta."'  
            where id_slide='".$dato['id_slide']."' ";
        }
        else{
            $sql="update slide set orden='".$dato['orden']."', tiempo='".$dato['tiempo']."', 
            id_tipo_slide='".$dato['id_tipo_slide']."', estado='".$dato['id_status']."', 
            fec_act=NOW(), user_act=".$id_usuario."  
            where id_slide='".$dato['id_slide']."'  ";
        }
        $this->db->query($sql);
    }

    function delete_slide($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" update slide set estado='4', fec_eli= NOW(),user_eli=".$id_user." where id_slide='".$dato['id_slide']."'";
        $this->db->query($sql);
    }

    function get_nom_img_slide($id_slide){
        if(isset($id_slide) && $id_slide > 0){
            $sql = "SELECT imagen,peso from slide where id_slide=".$id_slide;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_img_slide($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE slide set imagen='',peso=0, fec_act= NOW(),user_act=".$id_user." where id_slide='".$dato['id_slide']."'";
        $this->db->query($sql);
    }

    function get_id_repaso($id_repaso){
        if(isset($id_repaso) && $id_repaso > 0){
            $sql = "select * from repaso where id_repaso=".$id_repaso;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_repaso($dato){
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['imagen']['name'];
        $size1 = $_FILES['imagen']['size'];

        if($path!=''){
            $peso=$size1;

            $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1'];
            $peso_nuevo=$peso_actualizado+$peso;
        }

        
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        //$config['upload_path'] = './repaso/';/// ruta del fileserver para almacenar el documento
        $config['upload_path'] = './temas/'.$id_tema.'/repaso';
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $config['file_name'] = "repaso".$fecha."_".rand(1,200).".".$ext;

        $ruta = 'temas/'.$id_tema.'/repaso'.'/'.$config['file_name'];

        $config['allowed_types'] = "png|jpg|gif|mp4|flv";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            $sql="update repaso set orden='".$dato['orden']."', tiempo='".$dato['tiempo']."', 
            estado='".$dato['id_status']."', 
            fec_act=NOW(), user_act=".$id_usuario.", imagen='".$ruta."' ,peso='".$peso."'  
            where id_repaso='".$dato['id_repaso']."'  ";
        }else{
            $sql="update repaso set orden='".$dato['orden']."', tiempo='".$dato['tiempo']."', 
            estado='".$dato['id_status']."', 
            fec_act=NOW(), user_act=".$id_usuario."  
            where id_repaso='".$dato['id_repaso']."'  ";
        }
        $this->db->query($sql);
    }

    function delete_repaso($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" update repaso set estado='4', fec_eli= NOW(),user_eli=".$id_user." where id_repaso='".$dato['id_repaso']."'";
        $this->db->query($sql);
    }

    function get_nom_img_repaso($id_repaso){
        if(isset($id_repaso) && $id_repaso > 0){
            $sql = "SELECT imagen,peso from repaso where id_repaso=".$id_repaso;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_img_repaso($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE repaso set imagen='',peso=0, fec_act= NOW(),user_act=".$id_user." where id_repaso='".$dato['id_repaso']."'";
        $this->db->query($sql);
    }

    function get_id_examen($id_examen){
        if(isset($id_examen) && $id_examen > 0){
            $sql = "SELECT * from examen where id_examen=".$id_examen;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_respuesta($id_examen){
        if(isset($id_examen) && $id_examen > 0){
            $sql = "SELECT * from respuesta where estado=2 and id_examen=".$id_examen;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_examen($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $fecha=date('Y-m-d');
        $id_tema= $dato['referencia'];

        $path = $_FILES['foto1']['name'];
        $size1 = $_FILES['foto1']['size'];

        $peso=$size1;
        $peso_actualizado=$dato['peso_actual']-$dato['peso_antiguo1'];
        $peso_nuevo=$peso_actualizado+$peso;

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'foto1';
        //$config['upload_path'] = './intro/';/// ruta del fileserver para almacenar el documento
        
        $config['upload_path'] = './temas/'.$id_tema.'/examen';
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $nombre="ex".$fecha."_".rand(1,200);
        $config['file_name'] = $nombre.".".$ext;

        $ruta = 'temas/'.$id_tema.'/examen'.'/'.$config['file_name'];

        $config['allowed_types'] = "png";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }  

        $data['uploadSuccess'] = $this->upload->data();

        if ($path!=""){
            $sql="UPDATE examen set pregunta='".$dato['pregunta']."',
            orden='".$dato['orden']."',
            fec_act=NOW(), user_act=".$id_usuario.", foto1='".$ruta."',peso='".$peso."'
            where id_examen='".$dato['id_examen']."'  ";
        }else{
            $sql="update examen set pregunta='".$dato['pregunta']."',
            orden='".$dato['orden']."',
            fec_act=NOW(), user_act=".$id_usuario." 
            where id_examen='".$dato['id_examen']."'  ";
        }
        
        $this->db->query($sql);

        $sql2="UPDATE respuesta set alternativa='".$dato['alternativa1']."',
            fec_act=NOW(), user_act=".$id_usuario." 
            where id_respuesta='".$dato['id_respuesta1']."'  ";
        $this->db->query($sql2);

        $sql3="UPDATE respuesta set alternativa='".$dato['alternativa2']."',
            fec_act=NOW(), user_act=".$id_usuario." 
            where id_respuesta='".$dato['id_respuesta2']."'  ";
        $this->db->query($sql3);

        $sql4="UPDATE respuesta set alternativa='".$dato['alternativa3']."',
            fec_act=NOW(), user_act=".$id_usuario." 
            where id_respuesta='".$dato['id_respuesta3']."'  ";
        $this->db->query($sql4);
    }

    function delete_examen($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" update examen set estado='4', fec_eli= NOW(),user_eli=".$id_user." where id_examen='".$dato['id_examen']."'";
        $this->db->query($sql);
    }

    function get_nom_img_examen($id_examen){
        if(isset($id_examen) && $id_examen > 0){
            $sql = "SELECT foto1 from examen where id_examen=".$id_examen;
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function delete_img_examen($dato){
        $id_user= $_SESSION['usuario'][0]['id_usuario'];
        $sql=" UPDATE examen set foto1='',peso=0, fec_act= NOW(),user_act=".$id_user." where id_examen='".$dato['id_examen']."'";
        $this->db->query($sql);
    }
    //-----------------------------------GRADO-------------------------------------
    function get_list_grado($id_grado=null){
        if(isset($id_grado) && $id_grado>0){
            $sql = "SELECT * FROM grado WHERE id_grado=$id_grado";
        }else{
            $sql = "SELECT g.*,s.nom_status FROM grado g
                    LEFT JOIN status s ON g.estado=s.id_status
                    WHERE g.tipo_ceba=2 AND g.estado IN (1,2,3)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grado_combo(){
        $sql = "SELECT id_grado,descripcion_grado FROM grado
                WHERE tipo_ceba=2 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grado_x_curso($id_curso){
        $sql = "SELECT g.*, s.descripcion_grado,s.id_grado
                FROM curso g
                LEFT JOIN grado s on s.id_grado=g.id_grado
                WHERE g.id_curso=$id_curso";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_grado($dato){
        $sql = "SELECT id_grado FROM grado WHERE tipo_ceba=2 AND descripcion_grado='".$dato['descripcion_grado']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO grado (tipo_ceba,descripcion_grado,estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['descripcion_grado']."','".$dato['id_status']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_grado($dato){
        $sql = "SELECT id_grado FROM grado WHERE id_grado!='".$dato['id_grado']."' AND tipo_ceba=2 AND 
                descripcion_grado='".$dato['descripcion_grado']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grado SET descripcion_grado='".$dato['descripcion_grado']."',estado='".$dato['id_status']."',
                fec_act=NOW(),user_act=$id_usuario  
                WHERE id_grado='". $dato['id_grado']."'";
        $this->db->query($sql);
    }

    function delete_grado($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE grado SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_grado='".$dato['id_grado']."'";
        $this->db->query($sql);
    }
    //-----------------------------------AREA-------------------------------------
    function get_list_area($id_area=null){
        if(isset($id_area) && $id_area>0){
            $sql = "SELECT * FROM area WHERE id_area=$id_area";
        }else{
            $sql = "SELECT a.*,s.nom_status FROM area a
                    LEFT JOIN status s ON a.estado=s.id_status
                    WHERE a.tipo_ceba=2 AND a.estado IN (1,2,3) ORDER BY descripcion_area ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_area_combo(){
        $sql = "SELECT id_area,descripcion_area FROM area
                WHERE tipo_ceba=2 AND estado=2 ORDER BY descripcion_area ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_area($dato){
        $sql = "SELECT id_area FROM area WHERE tipo_ceba=2 AND descripcion_area='".$dato['descripcion_area']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_area($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO area (tipo_ceba,descripcion_area,estado, fec_reg, user_reg) 
                VALUES (2,'".$dato['descripcion_area']."','".$dato['id_status']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_area($dato){
        $sql = "SELECT id_area FROM area WHERE id_area!='".$dato['id_area']."' AND tipo_ceba=2 AND 
                descripcion_area='".$dato['descripcion_area']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_area($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE area SET descripcion_area='".$dato['descripcion_area']."',estado='".$dato['id_status']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_area='".$dato['id_area']."'";
        $this->db->query($sql);
    }

    function delete_area($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE area SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_area='".$dato['id_area']."'";
        $this->db->query($sql);
    } 
    //-----------------------------------ASIGNATURA-------------------------------------
    function get_list_asignatura($id_asignatura=null){
        if(isset($id_asignatura) && $id_asignatura>0){
            $sql = "SELECT * FROM asignatura WHERE id_asignatura=$id_asignatura";
        }else{
            $sql = "SELECT a.*, ar.descripcion_area, s.nom_status FROM asignatura a
                    LEFT JOIN area ar ON a.id_area=ar.id_area
                    LEFT JOIN status s ON a.estado=s.id_status
                    WHERE a.tipo_ceba=2 AND a.estado IN (1,2,3) ORDER BY descripcion_asignatura ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_asignatura_combo(){
        $sql = "SELECT a.*, ar.descripcion_area, s.nom_status FROM asignatura a
                LEFT JOIN area ar ON a.id_area=ar.id_area
                LEFT JOIN status s ON a.estado=s.id_status
                WHERE a.tipo_ceba=2 AND a.estado='2' ORDER BY descripcion_asignatura ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_asignatura($dato){
        $sql = "SELECT id_asignatura FROM asignatura WHERE tipo_ceba=2 AND id_area='".$dato['id_area']."' AND 
                referencia='".$dato['referencia']."' AND descripcion_asignatura='".$dato['descripcion_asignatura']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function insert_asignatura($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO asignatura (tipo_ceba,id_area,referencia,descripcion_asignatura,estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['id_area']."','".$dato['referencia']."','".$dato['descripcion_asignatura']."',
                '".$dato['id_status']."',NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_asignatura($dato){
        $sql = "SELECT id_asignatura FROM asignatura WHERE id_asignatura!='".$dato['id_asignatura']."' AND tipo_ceba=2 AND 
                id_area='".$dato['id_area']."' AND referencia='".$dato['referencia']."' AND 
                descripcion_asignatura='".$dato['descripcion_asignatura']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_asignatura($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE asignatura SET id_area='".$dato['id_area']."',referencia='".$dato['referencia']."',
                descripcion_asignatura='".$dato['descripcion_asignatura']."',estado='".$dato['id_status']."',
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_asignatura='".$dato['id_asignatura']."'";
        $this->db->query($sql);
    }

    function delete_asignatura($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE asignatura SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_asignatura='".$dato['id_asignatura']."'";
        $this->db->query($sql);
    }
    //-----------------------------------MATRÍCULA-------------------------------------
    function get_list_matricula($parametro){
        if($parametro==1){
            $sql = "SELECT ap.id_alumno,ap.cod_alum,ap.cod_arpay,gr.descripcion_grado,ap.alum_celular,ap.alum_apater,ap.alum_amater,
                    ap.alum_nom,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') AS fecha_registro,d.nombre_departamento,p.nombre_provincia,
                    ap.alum_edad,(SELECT COUNT(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    s.nom_estadoa,ap.tmatricula
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    WHERE ap.tipo_ceba=2 AND ap.estado=2 AND ap.estado_alum=2 ORDER BY ap.cod_alum DESC";
        }else{
            $sql = "SELECT ap.id_alumno,ap.cod_alum,ap.cod_arpay,gr.descripcion_grado,ap.alum_celular,ap.alum_apater,ap.alum_amater,
                    ap.alum_nom,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') AS fecha_registro,d.nombre_departamento,p.nombre_provincia,
                    ap.alum_edad,(SELECT COUNT(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) as cant_matricula,
                    s.nom_estadoa,ap.tmatricula
                    from alumnos ap 
                    left join departamento d on ap.id_departamentoa =d.id_departamento 
                    left join provincia p on ap.id_provinciaa=p.id_provincia 
                    left join estadoa s on ap.estado_alum=s.id_estadoa
                    left join users usu on ap.user_reg=usu.id_usuario
                    left join grado gr on ap.id_grados_activos=gr.id_grado
                    WHERE ap.tipo_ceba=2 AND ap.estado=2 ORDER BY ap.cod_alum DESC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_provincia($id_departamento){ 
        $sql = "SELECT * FROM provincia WHERE estado=2 AND id_departamento='$id_departamento' ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function busca_distrito($id_departamento,$id_provincia){ 
        $sql = "SELECT * FROM distrito WHERE estado=2 AND id_departamento='$id_departamento' AND id_provincia='$id_provincia'
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function validar_temporal_datos_alumno(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT id_temporal FROM temporal_datos_alumno WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_datos_alumno(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT ta.*,de.nombre_departamento AS dep_alum,pr.nombre_provincia AS pro_alum,di.nombre_distrito AS dis_alum,
                dp.nombre_departamento AS dep_inst_alum,po.nombre_provincia AS pro_inst_alum,ds.nombre_distrito AS dis_inst_alum,
                DATE_FORMAT(ta.fec_nac_alum,'%d/%m/%Y') AS fecha_nacimiento,pa.nom_parentesco,
                CONCAT(ta.nombres_prin,' ',ta.apater_prin,' ',ta.amater_prin) AS nom_principal,dip.nombre_distrito AS dis_prin,
                CASE WHEN ta.id_sexo_alum=1 THEN 'Femenino' WHEN ta.id_sexo_alum=2 THEN 'Masculino' ELSE '' END AS nom_sexo
                FROM temporal_datos_alumno ta
                LEFT JOIN departamento de ON de.id_departamento=ta.id_departamento_alum
                LEFT JOIN provincia pr ON pr.id_provincia=ta.id_provincia_alum
                LEFT JOIN distrito di ON di.id_distrito=ta.id_distrito_alum
                LEFT JOIN departamento dp ON dp.id_departamento=ta.id_departamento_inst_alum
                LEFT JOIN provincia po ON po.id_provincia=ta.id_provincia_inst_alum
                LEFT JOIN distrito ds ON ds.id_distrito=ta.id_distrito_inst_alum
                LEFT JOIN parentesco pa ON pa.id_parentesco=ta.parentesco_prin
                LEFT JOIN distrito dip ON dip.id_distrito=ta.id_distrito_prin
                WHERE ta.id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno (id_usuario,id_tipo_documento_alum,n_doc_alum,fec_nac_alum,edad_alum,
                id_sexo_alum,apater_alum,amater_alum,nombres_alum,direccion_alum,id_departamento_alum,id_provincia_alum,
                id_distrito_alum,celular_alum,telf_casa_alum,correo_personal_alum,correo_corporativo_alum,
                inst_procedencia,id_departamento_inst_alum,id_provincia_inst_alum,id_distrito_inst_alum) 
                VALUES ($id_usuario,'".$dato['id_tipo_documento_alum']."','".$dato['n_doc_alum']."',
                '".$dato['fec_nac_alum']."','".$dato['edad_alum']."','".$dato['id_sexo_alum']."',
                '".$dato['apater_alum']."','".$dato['amater_alum']."','".$dato['nombres_alum']."',
                '".$dato['direccion_alum']."','".$dato['id_departamento_alum']."',
                '".$dato['id_provincia_alum']."','".$dato['id_distrito_alum']."','".$dato['celular_alum']."',
                '".$dato['telf_casa_alum']."','".$dato['correo_personal_alum']."',
                '".$dato['correo_corporativo_alum']."','".$dato['inst_procedencia']."',
                '".$dato['id_departamento_inst_alum']."','".$dato['id_provincia_inst_alum']."',
                '".$dato['id_distrito_inst_alum']."')"; 
        $this->db->query($sql);
    }

    function update_datos_alumno($dato){
        $sql = "UPDATE temporal_datos_alumno SET id_tipo_documento_alum='".$dato['id_tipo_documento_alum']."',
                n_doc_alum='".$dato['n_doc_alum']."',fec_nac_alum='".$dato['fec_nac_alum']."',edad_alum='".$dato['edad_alum']."',
                id_sexo_alum='".$dato['id_sexo_alum']."',apater_alum='".$dato['apater_alum']."',
                amater_alum='".$dato['amater_alum']."',nombres_alum='".$dato['nombres_alum']."',
                direccion_alum='".$dato['direccion_alum']."',id_departamento_alum='".$dato['id_departamento_alum']."',
                id_provincia_alum='".$dato['id_provincia_alum']."',id_distrito_alum='".$dato['id_distrito_alum']."',
                celular_alum='".$dato['celular_alum']."',telf_casa_alum='".$dato['telf_casa_alum']."',
                correo_personal_alum='".$dato['correo_personal_alum']."',
                correo_corporativo_alum='".$dato['correo_corporativo_alum']."',inst_procedencia='".$dato['inst_procedencia']."',
                id_departamento_inst_alum='".$dato['id_departamento_inst_alum']."',
                id_provincia_inst_alum='".$dato['id_provincia_inst_alum']."',
                id_distrito_inst_alum='".$dato['id_distrito_inst_alum']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_datos_tutor($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno (id_usuario,id_tipo_documento_prin,n_doc_prin,fec_nac_prin,parentesco_prin,
                apater_prin,amater_prin,nombres_prin,vive_alumno_prin,direccion_prin,id_departamento_prin,id_provincia_prin,
                id_distrito_prin,celular_prin,telf_casa_prin,correo_personal_prin,ocupacion_prin,centro_empleo_prin,
                id_tipo_documento_secu,n_doc_secu,fec_nac_secu,parentesco_secu,apater_secu,amater_secu,nombres_secu,
                vive_alumno_secu,direccion_secu,id_departamento_secu,id_provincia_secu,id_distrito_secu,celular_secu,
                telf_casa_secu,correo_personal_secu,ocupacion_secu,centro_empleo_secu) 
                VALUES ($id_usuario,'".$dato['id_tipo_documento_prin']."','".$dato['n_doc_prin']."','".$dato['fec_nac_prin']."',
                '".$dato['parentesco_prin']."','".$dato['apater_prin']."','".$dato['amater_prin']."','".$dato['nombres_prin']."',
                '".$dato['vive_alumno_prin']."','".$dato['direccion_prin']."','".$dato['id_departamento_prin']."',
                '".$dato['id_provincia_prin']."','".$dato['id_distrito_prin']."','".$dato['celular_prin']."',
                '".$dato['telf_casa_prin']."','".$dato['correo_personal_prin']."','".$dato['ocupacion_prin']."',
                '".$dato['centro_empleo_prin']."','".$dato['id_tipo_documento_secu']."',
                '".$dato['n_doc_secu']."','".$dato['fec_nac_secu']."','".$dato['parentesco_secu']."','".$dato['apater_secu']."',
                '".$dato['amater_secu']."','".$dato['nombres_secu']."','".$dato['vive_alumno_secu']."','".$dato['direccion_secu']."',
                '".$dato['id_departamento_secu']."','".$dato['id_provincia_secu']."','".$dato['id_distrito_secu']."',
                '".$dato['celular_secu']."','".$dato['telf_casa_secu']."','".$dato['correo_personal_secu']."',
                '".$dato['ocupacion_secu']."','".$dato['centro_empleo_secu']."')"; 
        $this->db->query($sql);
    }

    function update_datos_tutor($dato){
        $sql = "UPDATE temporal_datos_alumno SET id_tipo_documento_prin='".$dato['id_tipo_documento_prin']."',
                n_doc_prin='".$dato['n_doc_prin']."',fec_nac_prin='".$dato['fec_nac_prin']."',
                parentesco_prin='".$dato['parentesco_prin']."',apater_prin='".$dato['apater_prin']."',
                amater_prin='".$dato['amater_prin']."',nombres_prin='".$dato['nombres_prin']."',
                vive_alumno_prin='".$dato['vive_alumno_prin']."',direccion_prin='".$dato['direccion_prin']."',
                id_departamento_prin='".$dato['id_departamento_prin']."',id_provincia_prin='".$dato['id_provincia_prin']."',
                id_distrito_prin='".$dato['id_distrito_prin']."',celular_prin='".$dato['celular_prin']."',
                telf_casa_prin='".$dato['telf_casa_prin']."',correo_personal_prin='".$dato['correo_personal_prin']."',
                ocupacion_prin='".$dato['ocupacion_prin']."',centro_empleo_prin='".$dato['centro_empleo_prin']."',
                id_tipo_documento_secu='".$dato['id_tipo_documento_secu']."',
                n_doc_secu='".$dato['n_doc_secu']."',fec_nac_secu='".$dato['fec_nac_secu']."',
                parentesco_secu='".$dato['parentesco_secu']."',apater_secu='".$dato['apater_secu']."',
                amater_secu='".$dato['amater_secu']."',nombres_secu='".$dato['nombres_secu']."',
                vive_alumno_secu='".$dato['vive_alumno_secu']."',direccion_secu='".$dato['direccion_secu']."',
                id_departamento_secu='".$dato['id_departamento_secu']."',id_provincia_secu='".$dato['id_provincia_secu']."',
                id_distrito_secu='".$dato['id_distrito_secu']."',celular_secu='".$dato['celular_secu']."',
                telf_casa_secu='".$dato['telf_casa_secu']."',correo_personal_secu='".$dato['correo_personal_secu']."',
                ocupacion_secu='".$dato['ocupacion_secu']."',centro_empleo_secu='".$dato['centro_empleo_secu']."'
                WHERE id_temporal='".$dato['id_temporal']."'"; 
        $this->db->query($sql);
    }

    function insert_datos_informacion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_alumno (id_usuario,donde_conocio) 
                VALUES ($id_usuario,'".$dato['donde_conocio']."')"; 
        $this->db->query($sql);
    }

    function update_datos_informacion($dato){
        $sql = "UPDATE temporal_datos_alumno SET donde_conocio='".$dato['donde_conocio']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function get_id_datos_documento(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM temporal_datos_documento WHERE id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_documento (id_usuario,doc_iden_alumno,certificado_estudio,foto,
                doc_iden_apoderado) 
                VALUES ($id_usuario,'".$dato['doc_iden_alumno']."','".$dato['certificado_estudio']."',
                '".$dato['foto']."','".$dato['doc_iden_apoderado']."')"; 
        $this->db->query($sql);
    }

    function update_datos_documento($dato){
        $sql = "UPDATE temporal_datos_documento SET doc_iden_alumno='".$dato['doc_iden_alumno']."',
                certificado_estudio='".$dato['certificado_estudio']."',foto='".$dato['foto']."',
                doc_iden_apoderado='".$dato['doc_iden_apoderado']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function get_id_datos_matricula(){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT tm.*,gr.descripcion_grado FROM temporal_datos_matricula tm
                LEFT JOIN grado gr ON gr.id_grado=tm.id_grado
                WHERE tm.id_usuario=$id_usuario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_datos_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_matricula (id_usuario,id_grado,fec_matricula,observaciones) 
                VALUES ($id_usuario,'".$dato['id_grado']."','".$dato['fec_matricula']."','".$dato['observaciones']."')"; 
        $this->db->query($sql);
    }

    function update_datos_matricula($dato){
        $sql = "UPDATE temporal_datos_matricula SET id_grado='".$dato['id_grado']."',fec_matricula='".$dato['fec_matricula']."',
                observaciones='".$dato['observaciones']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_datos_confirmacion($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO temporal_datos_matricula (id_usuario,codigo_confirmacion,hoja_matricula,contrato,reglamento_interno,forma_pago,cero_efectivo,contacto) 
                VALUES ($id_usuario,'".$dato['codigo_confirmacion']."','".$dato['hoja_matricula']."','".$dato['contrato']."',
                '".$dato['reglamento_interno']."','".$dato['forma_pago']."','".$dato['cero_efectivo']."','".$dato['contacto']."')"; 
        $this->db->query($sql);
    }

    function update_datos_confirmacion($dato){
        $sql = "UPDATE temporal_datos_matricula SET codigo_confirmacion='".$dato['codigo_confirmacion']."',hoja_matricula='".$dato['hoja_matricula']."',
                contrato='".$dato['contrato']."',reglamento_interno='".$dato['reglamento_interno']."',
                forma_pago='".$dato['forma_pago']."',cero_efectivo='".$dato['forma_pago']."',contacto='".$dato['contacto']."'
                WHERE id_temporal='".$dato['id_temporal']."'";
        $this->db->query($sql);
    }

    function insert_alumno_matricula($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumnos (tipo_ceba,cod_alum,tipo_documento,dni_alumno,alum_nacimiento,
                alum_edad,alum_sexo,alum_apater,alum_amater,alum_nom,alum_direc,id_departamentoa,id_provinciaa,
                id_distritoa,alum_celular,alum_telf_casa,correo,correo_corporativo,alumno_institucionp,
                id_departamentop,id_provinciap,id_distritop,titular1_tipo_documento,titular1_dni,titular1_fec_nac,
                titular1_parentesco,titular1_apater,titular1_amater,titular1_nom,titular1_vive,titular1_direccion,
                titular1_departamento,titular1_provincia,titular1_distrito,titular1_celular,titular1_telf_casa,
                titular1_correo,titular1_ocupacion,titular1_centro_labor,titular2_tipo_documento,
                titular2_dni,titular2_fec_nac,titular2_parentesco,titular2_apater,titular2_amater,titular2_nom,
                titular2_vive,titular2_direccion,titular2_departamento,titular2_provincia,titular2_distrito,
                titular2_celular,titular2_telf_casa,titular2_correo,titular2_ocupacion,titular2_centro_labor,
                id_medios,estado_alum,id_grados_activos,estado,fec_reg,user_reg) 
                SELECT 2,'".$dato['cod_alum']."',id_tipo_documento_alum,n_doc_alum,fec_nac_alum,edad_alum,
                id_sexo_alum,apater_alum,amater_alum,nombres_alum,direccion_alum,id_departamento_alum,
                id_provincia_alum,id_distrito_alum,celular_alum,telf_casa_alum,correo_personal_alum,
                correo_corporativo_alum,inst_procedencia,id_departamento_inst_alum,id_provincia_inst_alum,
                id_distrito_inst_alum,id_tipo_documento_prin,n_doc_prin,fec_nac_prin,parentesco_prin,apater_prin,
                amater_prin,nombres_prin,vive_alumno_prin,direccion_prin,id_departamento_prin,id_provincia_prin,
                id_distrito_prin,celular_prin,telf_casa_prin,correo_personal_prin,ocupacion_prin,centro_empleo_prin,
                id_tipo_documento_secu,n_doc_secu,fec_nac_secu,parentesco_secu,apater_secu,amater_secu,
                nombres_secu,vive_alumno_secu,direccion_secu,id_departamento_secu,id_provincia_secu,id_distrito_secu,
                celular_secu,telf_casa_secu,correo_personal_secu,ocupacion_secu,centro_empleo_secu,
                donde_conocio,1,(SELECT id_grado FROM temporal_datos_matricula WHERE id_usuario=$id_usuario),2,NOW(),
                $id_usuario 
                FROM temporal_datos_alumno 
                WHERE id_usuario=$id_usuario"; 
        $this->db->query($sql);
    }

    function ultimo_id_alumno(){
        $sql = "SELECT id_alumno FROM alumnos WHERE tipo_ceba=2 ORDER BY id_alumno DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_config_documento(){
        $sql = "SELECT * FROM config_documento";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_documento_alumno_ep1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_alumno_ep1 (id_alumno,id_documento,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_documento_alumno_ep1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        if($dato['id_documento']==1){
            $sql = "UPDATE documento_alumno_ep1 SET documento='".$dato['doc_iden_alumno']."',fec_subido=NOW(),user_subido=$id_usuario
                    WHERE id_alumno='".$dato['id_alumno']."' AND id_documento='".$dato['id_documento']."'";
        }elseif($dato['id_documento']==2){
            $sql = "UPDATE documento_alumno_ep1 SET documento='".$dato['certificado_estudio']."',fec_subido=NOW(),user_subido=$id_usuario
                    WHERE id_alumno='".$dato['id_alumno']."' AND id_documento='".$dato['id_documento']."'";
        }elseif($dato['id_documento']==3){
            $sql = "UPDATE documento_alumno_ep1 SET documento='".$dato['foto']."',fec_subido=NOW(),user_subido=$id_usuario
                    WHERE id_alumno='".$dato['id_alumno']."' AND id_documento='".$dato['id_documento']."'";
        }elseif($dato['id_documento']==4){
            $sql = "UPDATE documento_alumno_ep1 SET documento='".$dato['doc_iden_apoderado']."',fec_subido=NOW(),user_subido=$id_usuario
                    WHERE id_alumno='".$dato['id_alumno']."' AND id_documento='".$dato['id_documento']."'";
        }
        $this->db->query($sql);
    }

    function ultimo_id_matricula(){
        $sql = "SELECT id_matricula FROM matricula_alumno ORDER BY id_matricula DESC LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO matricula_alumno (id_alumno,id_grado,fec_matricula,observaciones,
                codigo_confirmacion,hoja_matricula,contrato,reglamento_interno,forma_pago,cero_efectivo,
                contacto,estado,fec_reg,user_reg) 
                SELECT '".$dato['id_alumno']."',id_grado,fec_matricula,observaciones,
                codigo_confirmacion,'".$dato['hoja_matricula']."','".$dato['contrato']."',reglamento_interno,
                forma_pago,cero_efectivo,contacto,2,NOW(),$id_usuario
                FROM temporal_datos_matricula 
                WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
    }

    function delete_temporales(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM temporal_datos_alumno WHERE id_usuario=$id_usuario";
        $this->db->query($sql);
        $sql2 = "DELETE FROM temporal_datos_documento WHERE id_usuario=$id_usuario";
        $this->db->query($sql2);
        $sql3 = "DELETE FROM temporal_datos_matricula WHERE id_usuario=$id_usuario";
        $this->db->query($sql3);
    }

    function insert_detalle_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_matricula_alumno (id_matricula,id_unidad,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_matricula']."','".$dato['id_unidad']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function insert_pago_matricula_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO pago_matricula_alumno (id_matricula,nom_pago,monto,estado_pago,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_matricula']."','".$dato['nom_pago']."','".$dato['monto']."',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_matricula_alumno($id_alumno){
        $sql = "SELECT ma.*,DATE_FORMAT(ma.fec_matricula,'%d/%m/%Y') AS fecha_matricula,gr.descripcion_grado AS nom_grado,
                us.usuario_codigo AS creado_por,CASE WHEN (SELECT COUNT(*) FROM pago_matricula_alumno pm 
                WHERE pm.id_matricula=ma.id_matricula AND pm.nom_pago='Matrícula' AND pm.estado_pago=2)=1 THEN 'Cancelado' 
                ELSE 'Pendiente' END AS estado_matricula,CASE WHEN (SELECT COUNT(*) FROM pago_matricula_alumno pa 
                WHERE pa.id_matricula=ma.id_matricula AND pa.estado_pago=2)=7 THEN 'Completado' ELSE 'Por Completar' END 
                AS estado_pago_matricula
                FROM matricula_alumno ma
                LEFT JOIN grado gr ON gr.id_grado=ma.id_grado
                LEFT JOIN users us ON us.id_usuario=ma.user_reg
                WHERE ma.id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_detalle_matricula_alumno($id_alumno){
        $sql = "SELECT de.id_matricula,un.nom_unidad,DATE_FORMAT(un.inicio_clase,'%d/%m/%Y') AS inicio_clase,
                DATE_FORMAT(un.fin_clase,'%d/%m/%Y') AS fin_clase,st.nom_status 
                FROM detalle_matricula_alumno de
                LEFT JOIN matricula_alumno ma ON ma.id_matricula=de.id_matricula
                LEFT JOIN unidad_ep1 un ON un.id_unidad=de.id_unidad
                LEFT JOIN status st ON st.id_status=un.estado
                WHERE ma.id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_pago_matricula_alumno($id_alumno){
        $sql = "SELECT pa.id_pago,pa.id_matricula,pa.nom_pago,pa.monto,DATE_FORMAT(pa.fec_pago,'%d/%m/%Y') AS fec_pago,
                es.nom_estadop,us.usuario_codigo AS creado_por 
                FROM pago_matricula_alumno pa
                LEFT JOIN matricula_alumno ma ON ma.id_matricula=pa.id_matricula
                LEFT JOIN estadop es ON es.id_estadop=pa.estado_pago
                LEFT JOIN users us ON us.id_usuario=pa.user_pago
                WHERE ma.id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------CLIENTE-------------------------------------
    function get_list_cliente(){
        $sql = "SELECT * FROM alumnos WHERE tipo_ceba=2 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------ARTÍCULOS------------------------------------------
    function get_list_unidad_ep1($id_unidad=null){
        if(isset($id_unidad) && $id_unidad>0){
            $sql = "SELECT * FROM unidad_ep1 WHERE id_unidad=$id_unidad";
        }else{
            $sql = "SELECT u.*,DATE_FORMAT(u.inicio_clase,'%d/%m/%Y') AS inicio_clase,
                    DATE_FORMAT(u.fin_clase,'%d/%m/%Y') AS fin_clase,
                    DATE_FORMAT(u.inicio_matricula,'%d/%m/%Y') AS inicio_matricula,
                    DATE_FORMAT(u.fin_matricula,'%d/%m/%Y') AS fin_matricula,s.nom_status 
                    FROM unidad_ep1 u
                    LEFT JOIN status s ON s.id_status=u.estado
                    WHERE u.estado NOT IN (4)";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_unidad_activo(){
        $sql = "SELECT id_unidad FROM unidad_ep1 WHERE estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_unidad_ep1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO unidad_ep1 (nom_unidad,inicio_clase,fin_clase,inicio_matricula,fin_matricula,estado,fec_reg,user_reg) 
                VALUES('".$dato['nom_unidad']."','".$dato['inicio_clase']."','".$dato['fin_clase']."',
                '".$dato['inicio_matricula']."','".$dato['fin_matricula']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_unidad_ep1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE unidad_ep1 SET nom_unidad='".$dato['nom_unidad']."',inicio_clase='".$dato['inicio_clase']."',
                fin_clase='".$dato['fin_clase']."',inicio_matricula='".$dato['inicio_matricula']."',
                fin_matricula='".$dato['fin_matricula']."',estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_unidad='".$dato['id_unidad']."'";
        $this->db->query($sql);
    }

    function delete_unidad_ep1($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE unidad_ep1 SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_unidad='".$dato['id_unidad']."'";
        $this->db->query($sql);
    }
    //-----------------------------------------------DOCUMENTO------------------------------------------
    function get_list_documento($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_alumno_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,
                    CASE WHEN do.nom_grado=0 THEN 'Todos' ELSE gr.descripcion_grado END AS nom_grado,
                    st.nom_status,CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_alumno_empresa do
                    LEFT JOIN grado gr ON gr.id_grado=do.nom_grado
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=5 AND do.id_sede=7 AND do.estado!=4
                    ORDER BY do.nom_documento ASC,do.descripcion_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_documento_combo(){
        $sql = "SELECT id_documento,nom_documento FROM documento_alumno_empresa
                WHERE id_empresa=5 AND id_sede=7 AND estado!=4
                ORDER BY nom_documento ASC,descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=5 AND id_sede=7 AND cod_documento='".$dato['cod_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_alumno_empresa (id_empresa,id_sede,cod_documento,nom_grado,
                nom_documento,descripcion_documento,obligatorio,digital,aplicar_todos,validacion,estado,
                fec_reg,user_reg) 
                VALUES (5,7,'".$dato['cod_documento']."','".$dato['id_grado']."','".$dato['nom_documento']."',
                '".$dato['descripcion_documento']."','".$dato['obligatorio']."','".$dato['digital']."',
                '".$dato['aplicar_todos']."','".$dato['validacion']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_documento='".$dato['id_documento']."' AND id_alumno='".$dato['id_alumno']."' AND estado=2" ;
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function ultimo_id_documento(){
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                ORDER BY id_documento DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_empresa,id_sede,cod_documento,nom_grado,nom_documento,descripcion_documento,
        id_alumno,id_documento,digital,obligatorio,aplicar_todos,estado,fec_reg,user_reg)
                VALUES (5,7,'".$dato['cod_documento']."','".$dato['id_grado']."','".$dato['nom_documento']."','".$dato['descripcion_documento']."',
                '".$dato['id_alumno']."','".$dato['id_documento']."','".$dato['digital']."','".$dato['v_obligatorio']."','".$dato['aplicar_todos']."',2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    
    function update_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET cod_documento='".$dato['cod_documento']."',nom_grado='".$dato['id_grado']."',nom_documento='".$dato['nom_documento']."',
        descripcion_documento='".$dato['descripcion_documento']."',digital='".$dato['digital']."',obligatorio='".$dato['v_obligatorio']."',aplicar_todos='".$dato['aplicar_todos']."',
        estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario 
        WHERE id_documento='".$dato['id_documento']."' and id_empresa=5 and id_sede=7 and id_alumno='".$dato['id_alumno']."' AND estado=2";        
        $this->db->query($sql);
    }

    function valida_update_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=5 AND id_sede=7 AND cod_documento='".$dato['cod_documento']."' AND estado=2 AND 
                id_documento!='".$dato['id_documento']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET cod_documento='".$dato['cod_documento']."',
                nom_grado='".$dato['id_grado']."',nom_documento='".$dato['nom_documento']."',
                descripcion_documento='".$dato['descripcion_documento']."',
                obligatorio='".$dato['obligatorio']."',digital='".$dato['digital']."',
                aplicar_todos='".$dato['aplicar_todos']."',validacion='".$dato['validacion']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
 
    function delete_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    //---------------------------------------------DOC ALUMNOS-------------------------------------------
    function get_list_todos_alumno(){
        $sql = "SELECT ap.fec_reg,ap.cod_alum,ap.cod_arpay,gr.descripcion_grado,ap.alum_celular,ap.alum_apater,
                ap.alum_amater,ap.alum_nom,DATE_FORMAT(ap.fec_reg,'%d/%m/%Y') AS fecha_registro,
                us.usuario_codigo,de.nombre_departamento,pr.nombre_provincia,ap.alum_edad,
                (SELECT COUNT(*) FROM contador_matricula cm WHERE cm.id_alumno=ap.id_alumno) AS cant_matricula,
                es.nom_estadoa,ap.observaciones,ap.id_alumno,
                CASE WHEN (SELECT COUNT(*) FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2)>0 THEN 'Si'
                ELSE 'No' END AS foto,
                (SELECT de.id_detalle FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS id_foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=5 AND da.id_sede=7 AND da.cod_documento='D00' AND de.id_alumno=ap.id_alumno AND de.archivo!='' AND de.estado=2) AS link_foto
                from alumnos ap 
                LEFT JOIN grado gr ON gr.id_grado=ap.id_grados_activos
                LEFT JOIN users us ON us.id_usuario=ap.user_reg
                LEFT JOIN departamento de ON de.id_departamento=ap.id_departamentoa
                LEFT JOIN provincia pr ON pr.id_provincia=ap.id_provinciaa
                LEFT JOIN estadoa es ON es.id_estadoa=ap.estado_alum
                WHERE ap.tipo_ceba=2 AND ap.estado=2
                ORDER BY ap.fec_reg DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_doc_alumnos(){
        $sql = "SELECT id_documento,cod_documento FROM documento_alumno_empresa
                WHERE id_empresa=5 AND id_sede=7 AND estado!=4
                ORDER BY cod_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_detalle_doc_alumnos($id_alumno,$cod_documento){
        $sql = "SELECT us.usuario_codigo,de.fec_subido 
                FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                LEFT JOIN users us ON us.id_usuario=de.user_subido
                WHERE da.cod_documento='$cod_documento' AND da.id_empresa=5 AND da.id_sede=7 AND da.estado=2 AND 
                de.id_alumno=$id_alumno AND de.estado=2
                ORDER BY de.id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    //---------------------------------------------ALUMNOS OBS-------------------------------------------
    function get_list_alumno_obs(){ 
        $sql = "SELECT a.alum_apater,a.alum_amater,a.alum_nom,a.cod_alum,e.nom_empresa,
                DATE_FORMAT(aog.fec_reg, '%d-%m-%Y') AS fecha_registro,aog.observacion AS Comentario,
                u.usuario_codigo,aog.id_empresa,gr.descripcion_grado
                FROM alumno_observaciones_general aog
                LEFT JOIN alumnos a ON a.id_alumno=aog.id_alumno
                LEFT JOIN grado gr ON gr.id_grado=a.id_grados_activos
                LEFT JOIN empresa e ON e.id_empresa=aog.id_empresa
                LEFT JOIN users u ON u.id_usuario=aog.user_reg
                WHERE aog.id_empresa = 5 AND aog.id_sede = 7 AND aog.estado = 2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------SOPORTE DOCS------------------------------------------
    function get_list_soporte_doc($id_soporte_doc=null){
        if(isset($id_soporte_doc) && $id_soporte_doc>0){
            $sql = "SELECT * FROM soporte_doc WHERE id_soporte_doc=$id_soporte_doc";
        }else{
            $sql = "SELECT so.id_soporte_doc,em.cod_empresa,so.descripcion,SUBSTRING_INDEX(so.documento,'/',-1) AS nom_documento,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(so.documento,'/',-1)) ELSE '' END AS link,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',so.documento) ELSE '' END AS href,us.usuario_codigo,
                    DATE_FORMAT(so.fec_act,'%d-%m-%Y') AS fecha,CASE WHEN so.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    CASE WHEN so.visible=1 THEN 'Si' ELSE 'No' END AS visible,st.nom_status,so.documento
                    FROM soporte_doc so
                    LEFT JOIN empresa em ON em.id_empresa=so.id_empresa
                    LEFT JOIN users us ON us.id_usuario=so.user_act
                    LEFT JOIN status st ON st.id_status=so.estado
                    WHERE so.id_empresa=5 AND so.estado!=4
                    ORDER BY em.cod_empresa ASC,so.descripcion ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

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
        where u.id_nivel!=6 and u.id_nivel in (12)   and u.estado=2 or u.id_usuario in (1,7)
        group by u.id_usuario  
        ORDER BY u.usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
}
