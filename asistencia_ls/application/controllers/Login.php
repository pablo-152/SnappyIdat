<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
	    $this->load->helper(array('url'));
		$this->load->model('N_model');
	}

	public function index(){
		$this->load->view('login/login'); 
	}

	public function ingresar(){
		$usuario = $_POST['Usuario'];
		$password = $_POST['Password'];

		$sesion = $this->N_model->login($usuario);

		if (count($sesion) > 0) {
			$_SESSION['usuario'] = $sesion;
			
			$fecha_fin = $_SESSION['usuario'][0]['fin_funcion'];
			$fechaActual = date('Y-m-d');

			if($fecha_fin=="0000-00-00" || isnull($fecha_fin)){
				if (password_verify($password, $_SESSION['usuario'][0]['usuario_password'])) {
					echo $_SESSION['usuario'][0]['id_nivel'];
				}else{
					echo "error";
				}
			}elseif($fechaActual <= $fecha_fin){
				echo "error";
			}else{
				echo "error";
			}
		}else {
			echo "error";
		}
	}

	public function logout(){
     	$this->session->sess_destroy();
     	redirect('/login');
    }
}
