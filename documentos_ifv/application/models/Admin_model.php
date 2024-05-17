<?php
class Admin_model extends CI_Model {
        public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }

    function insert_registro_usuario($dato){
        $sql = "INSERT into users (usuario_nombres, usuario_apater,usuario_amater,id_tipodoc,num_doc,num_celp,usuario_password,fec_nacimiento,
                 estado, fec_reg, user_reg, password_desc, usuario_codigo, id_nivel, usuario_email,codigo_cliente) 
                values ('".$dato['usuario_nombres']."','".$dato['usuario_apater']."','".$dato['usuario_amater']."',
                '".$dato['id_tipodoc']."','".$dato['num_doc']."','".$dato['num_celp']."','".$dato['usuario_password']."','".$dato['fec_nacimiento']."',
                '1', NOW(),1, '".$dato['password_desc']."', '".$dato['num_doc']."', 4, '".$dato['usuario_email']."','".$dato['cod_cliente']."')";

        $this->db->query($sql);
    }

    function valida_reg_usuario($dato){
        $sql=" SELECT * FROM users where usuario_nombres='".$dato['usuario_nombres']."' and usuario_apater='".$dato['usuario_apater']."' and usuario_amater='".$dato['usuario_amater']."' and num_doc='".$dato['num_doc']."' and estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro_usuario_sadmin($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT into users (usuario_nombres, usuario_apater,usuario_amater,id_tipodoc,num_doc,usuario_password,fec_nacimiento,
                 estado, fec_reg, user_reg, password_desc,usuario_email, usuario_codigo, id_nivel)

                values ('".$dato['usuario_nombres']."','".$dato['usuario_apater']."','".$dato['usuario_amater']."',
                '".$dato['id_tipodoc']."','".$dato['num_doc']."','".$dato['usuario_password']."','".$dato['fec_nacimiento']."',
                '1', NOW(),".$id_usuario.", '".$dato['password_desc']."','".$dato['usuario_email']."', '".$dato['num_doc']."', '".$dato['id_nivel']."')";

        $this->db->query($sql);
    }

    function valida_correo($dato){
        $sql = "SELECT * FROM users where usuario_email='".$dato['correo']."' and estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_tipo_documento()
    {
        $sql=" SELECT * FROM tipodocumento where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nivel()
    {
        $sql=" SELECT * FROM nivel where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_tipo_cliente(){
        $sql=" SELECT * FROM tipo_cliente where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
        function get_list_estado()
    {
        $sql=" SELECT * FROM estado where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_count_usuario()
    {
        $sql="SELECT * FROM users where id_nivel=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function list_usuario()
    {
        $sql=" SELECT u.*,e.nom_estado,t.nom_tipodoc,DATE_FORMAT(u.fec_nacimiento,'%d-%m-%Y') as fecha_nacimiento,n.nom_nivel FROM users u
        left join estado e on e.id_estado=u.estado
        left join tipodocumento t on t.id_tipodoc=u.id_tipodoc
        left join nivel n on n.id_nivel=u.id_nivel 
        where u.id_nivel in (1,2,3)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_clienta_gmail($dato){
        $sql = "SELECT * FROM users where 
                usuario_email='".$dato['usuario_email']."' and estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_clienta($dato){
        $sql = "SELECT * FROM users where usuario_codigo='".$dato['num_doc']."' and estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_clienta_dni($dato){
        $sql = "SELECT * FROM users where num_doc='".$dato['num_doc']."' and estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_usuario($id_usuario)
    {
        $sql=" SELECT u.*,DATE_FORMAT(u.fec_nacimiento,'%Y-%m-%d') as fecha_nacimiento FROM users u where u.id_usuario='".$id_usuario."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_usuario($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE users SET usuario_nombres='".$dato['usuario_nombres']."', usuario_apater='".$dato['usuario_apater']."', 
        usuario_amater='".$dato['usuario_amater']."', id_tipodoc='".$dato['id_tipodoc']."', usuario_codigo='".$dato['num_doc']."',num_doc='".$dato['num_doc']."', 
        usuario_email='".$dato['usuario_email']."', fec_nacimiento='".$dato['fec_nacimiento']."',  
        id_nivel='".$dato['id_nivel']."', password_desc='".$dato['password_desc']."',usuario_password='".$dato['usuario_password']."',estado='".$dato['id_estado']."', fec_act= NOW(), user_act=".$id_usuario." 
        WHERE id_usuario='".$dato['id_usuario']."' ";
        
        $this->db->query($sql);
    }

    function delete_usuario($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE users SET estado='3',fec_eli=NOW(),user_eli='".$id_usuario."' WHERE id_usuario='".$dato['id_usuario']."' ";
        
        $this->db->query($sql);
    }

    /*---------------------------------CLIENTE-----------------*/
    function list_cliente()
    {
        $sql=" SELECT u.*,e.nom_estado,t.nom_tipodoc,DATE_FORMAT(u.fec_nacimiento,'%d-%m-%Y') as fecha_nacimiento,n.nom_nivel FROM users u
        left join estado e on e.id_estado=u.estado
        left join tipodocumento t on t.id_tipodoc=u.id_tipodoc
        left join nivel n on n.id_nivel=u.id_nivel
        where u.id_nivel=4";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_registro_cliente_sadmin($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT into users (usuario_nombres, usuario_apater,usuario_amater,id_tipodoc,num_doc,usuario_password,fec_nacimiento,
                 estado, fec_reg, user_reg, password_desc,usuario_email, usuario_codigo, id_nivel,id_tipo_cliente)

                values ('".$dato['usuario_nombres']."','".$dato['usuario_apater']."','".$dato['usuario_amater']."',
                '".$dato['id_tipodoc']."','".$dato['num_doc']."','".$dato['usuario_password']."','".$dato['fec_nacimiento']."',
                '1', NOW(),".$id_usuario.", '".$dato['password_desc']."','".$dato['usuario_email']."', '".$dato['num_doc']."', '4','".$dato['id_tipo_cliente']."')";

        $this->db->query($sql);
    }

    function update_cliente($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE users SET usuario_nombres='".$dato['usuario_nombres']."', usuario_apater='".$dato['usuario_apater']."', 
        usuario_amater='".$dato['usuario_amater']."', id_tipodoc='".$dato['id_tipodoc']."', num_doc='".$dato['num_doc']."', 
        usuario_email='".$dato['usuario_email']."', fec_nacimiento='".$dato['fec_nacimiento']."', password_desc='".$dato['password_desc']."',usuario_password='".$dato['usuario_password']."',estado='".$dato['id_estado']."', fec_act= NOW(), user_act=".$id_usuario." ,id_tipo_cliente= '".$dato['id_tipo_cliente']."'
        WHERE id_usuario='".$dato['id_usuario']."'";
        
        $this->db->query($sql);
    }

    function delete_cliente($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE users SET estado='3',fec_eli=NOW(),user_eli='".$id_usuario."' WHERE id_usuario='".$dato['id_usuario']."' ";
        
        $this->db->query($sql);
    }

    /*---------------------------------SLIDE-----------------*/
    function list_slide()
    {
        $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
        if($id_nivel==1){
            $sql=" SELECT s.*,e.nom_estado FROM slide s
            left join estado e on e.id_estado=s.estado ORDER BY s.orden ASC";
            $query = $this->db->query($sql)->result_Array();
        }if($id_nivel==2){
            $sql=" SELECT s.*,e.nom_estado FROM slide s
            left join estado e on e.id_estado=s.estado 
            where s.estado in (1,2)
            ORDER BY s.orden ASC";
            $query = $this->db->query($sql)->result_Array();
        }
        
        return $query;
    }

    function list_familia_producto()
    {
        $sql=" SELECT * FROM familia_producto where estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_slide($dato)
    {
        $sql=" SELECT * FROM slide where nombre='".$dato['nombre']."' and orden='".$dato['orden']."' and  estado=1";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    
    function insert_slide($dato)
    {
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['imagen']['name'];


        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        $config['upload_path'] = './slide/';
        $config['file_name'] = "sl_".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'slide/'.$config['file_name'];

        $config['allowed_types'] = "png|jpg|pdf";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            $sql = "INSERT into slide (nombre, imagen,orden,estado, fec_reg, user_reg) 
                values ('". $dato['nombre']."','".$ruta."','". $dato['orden']."','1', NOW(),".$id_usuario.")";
        }else{
            $sql = "INSERT into slide (nombre,orden,estado, fec_reg, user_reg) 
                values ('". $dato['nombre']."','". $dato['orden']."','1', NOW(),".$id_usuario.")";
        }
        $this->db->query($sql);
    }

    function get_id_slide($id_slide)
    {
        $sql=" SELECT * FROM slide u where id_slide='".$id_slide."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_slide($dato)
    {
        $fecha=date('Y-m-d');
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $path = $_FILES['imagen']['name'];


        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $mi_archivo = 'imagen';
        $config['upload_path'] = './slide/';
        $config['file_name'] = "sl_".$fecha."_".rand(1,200).".".$ext;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
            chmod($config['upload_path'], 0777);
        }
        $ruta = 'slide/'.$config['file_name'];

        $config['allowed_types'] = "png|jpg|jpeg";
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $data['uploadError'] = $this->upload->display_errors();
        }       
        $data['uploadSuccess'] = $this->upload->data();

        if($path!=""){
            $sql="UPDATE slide SET nombre='".$dato['nombre']."',orden='".$dato['orden']."',estado='".$dato['id_estado']."',imagen='".$ruta."' WHERE id_slide='".$dato['id_slide']."' ";
        }else{
            $sql="UPDATE slide SET nombre='".$dato['nombre']."',orden='".$dato['orden']."',estado='".$dato['id_estado']."' WHERE id_slide='".$dato['id_slide']."' ";
        }
        $this->db->query($sql);
    }

    function delete_slide($dato)
    {
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql="UPDATE slide SET estado='3',fec_eli=NOW(),user_eli='".$id_usuario."' WHERE id_slide='".$dato['id_slide']."' ";
        
        $this->db->query($sql);
    }

    
}