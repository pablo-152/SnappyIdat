<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sadministrador extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
    }

    protected function jsonResponse($respuesta = array()) {
        $status = 200; // SUCCESS
        if (empty($respuesta)) {
            //$status = 400; // FAILURE
            $respuesta = array(
            'success' => false,
            'mensaje' => 'No hay nada'
            );
        }
        return $this->output
        ->set_content_type('application/json;charset=utf-8')
        ->set_status_header($status)
        ->set_output(json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }

    public function index()// RRHH
    {
        if ($this->session->userdata('usuario')) { 
            //$data['anio'] = $this->Papeletas_Detalle->get_anio();
            /*$data['anios'] = $this->Papeletas_Detalle->get_anio();
            $data['dependecia'] = $this->Papeletas_Detalle->get_dependencia();
            $data['firmadigital'] = $this->Papeletas_Detalle->firma_digital();
            $data['origen_horas'] = $this->Papeletas_Detalle->origen_horas();

            $coddep= $_SESSION['usuario'][0]['CODI_DEPE_TDE'];
            $data['caso'] = $this->Papeletas_Detalle->get_caso($coddep);
            $des_caso=$this->Papeletas_Detalle->get_caso($coddep);
            $data['nivel'] = $this->Papeletas_Detalle->get_nivel($des_caso);
*/
            //$this->load->view('Reportes/Papeletas_Detalle_Per',$data);
            $this->load->view('administrador/index');
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

 

       public function Canbiar_clave() {
         if (!$this->session->userdata('usuario')) {
       redirect(base_url());
        }
         $id_user=  $_SESSION['usuario'][0]['id_usuario'];  
          $dato['camb_clave'] = $this->Admin_model->get_camb_clave($id_user);
        $this->load->view('Admin/clave/index',$dato);
        }


        function update_clave($id_user){

        //$usuario_password = $_POST['usuario_password'];

        $dato['usuario_password']=$this->input->post("usuario_password");
        $password=$this->input->post("usuario_password");
        echo $password;
        $dato['user_password_hash']= password_hash($password, PASSWORD_DEFAULT);

        $dato['id_usuario']= $this->input->post("id_usurio");  
         $this->Admin_model->update_clave($dato);

          redirect('Sadministrador/index');

        }


        public function configuracion() {
            if (!$this->session->userdata('usuario')) {
                redirect(base_url());
            }
         $dato['confg_foto'] = $this->Admin_model->get_confg_foto();
        $this->load->view('configuracion/index',$dato);
        }

        public function modal_img(){
         if ($this->session->userdata('usuario')) {
         $this->load->view('configuracion/modal_img');   
        }
         else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    
    }
     public function insert_fotos(){
          $dato['foto']= $this->input->post("productImage"); 
          $dato['nom_fintranet']= $this->input->post("nom_fintranet"); 
          $this->Admin_model->insert_foto($dato);

        redirect('Sadministrador/configuracion');  
        }




}


