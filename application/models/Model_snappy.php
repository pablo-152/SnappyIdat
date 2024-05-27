<?php
class Model_snappy extends CI_Model { 
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Lima");
    }

    function get_confg_fondo(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=100";
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

    function get_list_estado(){
        $sql = "select * from status ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

}