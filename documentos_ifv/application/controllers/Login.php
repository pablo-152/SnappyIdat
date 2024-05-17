<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use SebastianBergmann\Environment\Console;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_Login');
		$this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper('form');
	}

    protected function jsonResponse($respuesta = array()){
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

	public function index(){
		$this->load->view('web/index'); 
	}

    public function Validar_Documentos(){
        $dni_alumno = $this->input->post("dni_alumno");

        $dato['get_id'] = $this->Model_Login->get_dni_matriculado($dni_alumno);

        if(count($dato['get_id'])>0){
            $this->load->view('web/datos', $dato);
        }else{
            echo "error";
        }
    }

    public function Recuerda(){
        $dni_alumno = $this->input->post("dni_alumno");
        $get_id = $this->Model_Login->get_dni_matriculado($dni_alumno);
        if(count($get_id)>0){
            $dato['m']=1;
            $dato['list_documento'] = $this->Model_Login->get_list_documentos_pendientes($get_id[0]['Fecha_Cumpleanos']);
            $this->load->view('web/cmb_documento', $dato);
        }else{
            $dato['m']=0;
            //$dato['list_documento'] = $this->Model_Login->get_list_documentos_pendientes($get_id[0]['Fecha_Cumpleanos']);
            $this->load->view('web/cmb_documento', $dato);
        }
        
    }

    public function Enviar_Documento(){
        $dato['cod_documento'] = $this->input->post("cod_documento");
        $dato['Email'] = $this->input->post("Email");
        $separada = explode('-', $dato['cod_documento']);
        $dato['cod_documento']=$separada[0];
        $dato['nom_documento']=$separada[1];
        $dato['id_empresa'] = 6;
        $dato['Codigo'] = $this->input->post("Codigo");
        $dato['nom_alumno'] = $this->input->post("nom_alumno");
        $dato['Apellido_Paterno'] = $this->input->post("Apellido_Paterno");
        $dato['Apellido_Materno'] = $this->input->post("Apellido_Materno");
        $dato['Especialidad'] = $this->input->post("Especialidad"); 
        $dato['Dni'] = $this->input->post("Dni"); 
        $path1 = $_FILES['documento']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        $dato['get_documento'] = $this->Model_Login->valida_documentos_cargados($dato);

        if(count($dato['get_documento'])>0){
            $this->Model_Login->update_documentos_cargados($dato);
        }else{
            $this->Model_Login->insert_documentos_cargados($dato);
        }
        $mail = new PHPMailer(true);
        try {
            /*$mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'plesk3002.my-hosting-panel.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'noreply@snappy.org.pe';                     // usuario de acceso
            $mail->Password   = '*lP06s1l1';                                // SMTP password
            $mail->SMTPSecure = 'SSL';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('noreply@snappy.org.pe', "Documentales IFV"); //desde donde se envia*/
            
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
            $mail->Password   = 'ifvc2022';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('noreplay@ifv.edu.pe', "Admisión IFV");

            $mail->addAddress($dato['Email']);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = "Documentos Recibidos - IFV ";



            $mail->Body = '<FONT SIZE=4>Hola<br>
            Tu inscripción ha sido registrada y tus documentos recepcionados.<br>
            En breve recibirás la validación a través de notificaciones o correo electrónico.<br>
            Manténgase atento(a).<br>
            Gracias</FONT SIZE>';
            $mail->CharSet = 'UTF-8';
            $mail->send();
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}
