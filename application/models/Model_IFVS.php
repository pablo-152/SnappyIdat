<?php
class Model_IFVS extends CI_Model {
    public function __construct() {  
        parent::__construct();  
        $this->load->database();
        date_default_timezone_set("America/Lima");         
    } 
    
     public function filter($table, $field = null, $filter = null, $as_array = false, $order_by=null) {   
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

    function actu_estado_examen_ifv(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE examen_ifv SET estado ='3',fec_act=NOW(),user_act='$id_usuario' WHERE fec_limite <= CURDATE() and estado=2 and estado_contenido=1";
        $this->db->query($sql);
    }
}