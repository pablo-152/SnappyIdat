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

}

