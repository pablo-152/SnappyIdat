<?php
class Llamada_model extends CI_Model {
    public function __construct()  {
        parent::__construct();
    }
    
    public function listarPorCliente($id_cliente)  {
        return $this->db
        ->select('c.nombre, c.apellido, l.telefono, l.mensaje, l.fecha')
        ->from('llamadas l')
        ->join('clientes c', 'c.id_cliente = l.id_cliente')
        ->where('c.id_cliente', $id_cliente)
        ->get()
        ->result();
    }
}