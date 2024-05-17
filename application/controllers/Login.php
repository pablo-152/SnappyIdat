<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		//$this->load->library('Password');
	    $this->load->helper(array('url'));
		$this->load->model('N_model');
		$this->load->model('Admin_model');
		$this->load->model('Model_General');
	}

	public function index(){
		$this->load->view('login/login'); 
	}

	public function ingresar() 
	{
		$usuario = $_POST['Usuario'];
		$password = $_POST['Password'];
		$sesion = $this->N_model->login($usuario);
		if (count($sesion) > 0) {
			$_SESSION['usuario'] = $sesion;
			//var_dump($_SESSION['usuario'][0]['id_usuario']);
			$dato['ip']=$_SERVER['REMOTE_ADDR'];
			$dato['count'] = $this->Model_General->consulta_usuario();
			
			$this->Model_General->insert_historial_ingreso_sistema($dato);
			if(count($dato['count'])>0){
				$dato['var']="1";
			}else{
				$dato['var']="0";
			}
			$this->Model_General->update_ultimo_ingreso_sistema($dato);
			
			
			$fecha_fin = $_SESSION['usuario'][0]['fin_funcion'];
			
			$fechaActual = date('Y-m-d');
			if($fecha_fin=="0000-00-00" || $fecha_fin==null){
				if (password_verify($password, $_SESSION['usuario'][0]['usuario_password'])) {
					echo $_SESSION['usuario'][0]['id_nivel'];
				}
				else{
					echo "error";
				}
			}elseif($fechaActual <= $fecha_fin){
					echo "error";
			}else{
				echo "error";
			}
		}
		// } 
		else {
			//$this->load->view('login/login');
			echo "error";
		}
	}


	public function logout(){
     	$this->session->sess_destroy();
     	redirect('/login');
     	//$this->load->view('login/login');
     }

     public function tippoacceso($usuario){
   
		 header('Content-Type: application/json');
        $data = $this->n_model->gettipoacceso($usuario);
        echo json_encode($data);

		//echo $data;
     }



		
	/*public function logout(){
     	$this->session->sess_destroy();
     	$this->load->view('login/login');
     }*/

}
