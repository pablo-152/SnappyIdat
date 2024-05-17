<?php
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Database\Query;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;
use PhpOffice\PhpSpreadsheet\Worksheet;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class Colaborador extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_General');
        $this->load->model('Admin_model');
        $this->load->model('Model_IFV');
        $this->load->model('Model_Colaborador');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
    }

    public function Colaborador($id_sede){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($id_sede);

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/colaborador/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['tipo'] = $this->input->post("tipo");
            $dato['id_sede'] = $this->input->post("id_sede");
            $dato['list_colaborador'] = $this->Model_Colaborador->get_list_colaborador($dato['tipo'],$dato['id_sede']);
            $this->load->view('view_colaborador/colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Colaborador($id_sede){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($id_sede);
            $dato['list_perfil'] = $this->Model_Colaborador->get_list_combo_perfil($id_sede);
            $dato['list_cargo'] = $this->Model_Colaborador->get_list_combo_cargo($id_sede);
            $dato['list_departamento'] = $this->Model_Colaborador->get_list_combo_departamento();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/colaborador/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_Colaborador->get_list_combo_provincia($id_departamento);
            $this->load->view('view_colaborador/colaborador/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_Colaborador->get_list_combo_distrito($id_provincia);
            $this->load->view('view_colaborador/colaborador/distrito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Colaborador(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $get_id = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['id_empresa'] = $get_id[0]['id_empresa'];
            $dato['id_perfil'] = $this->input->post("id_perfil");
            $dato['id_cargo'] = $this->input->post("id_cargo");
            $dato['nombres'] = $this->input->post("nombres");
            $dato['apellido_paterno'] = $this->input->post("apellido_paterno");
            $dato['apellido_materno'] = $this->input->post("apellido_materno");
            $dato['dni'] = $this->input->post("dni");
            $dato['correo_personal'] = $this->input->post("correo_personal");
            $dato['fec_nacimiento'] = $this->input->post("fec_nacimiento");
            $dato['correo_corporativo'] = $this->input->post("correo_corporativo");
            $dato['celular'] = $this->input->post("celular");
            $dato['direccion'] = $this->input->post("direccion");
            $dato['id_departamento'] = $this->input->post("id_departamento");
            $dato['id_provincia'] = $this->input->post("id_provincia");
            $dato['id_distrito'] = $this->input->post("id_distrito");
            $dato['codigo_gll'] = $this->input->post("codigo_gll");
            $dato['nickname'] = $this->input->post("nickname");
            $dato['usuario'] = $this->input->post("usuario");
            $dato['password']= password_hash($this->input->post("password"), PASSWORD_DEFAULT);
            $dato['password_desencriptado']= $this->input->post("password");
            $dato['banco'] = $this->input->post("banco");
            $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria");
            $dato['foto']= ""; 

            if($dato['usuario']==""){
                if($_FILES["foto"]["name"] != ""){
                    $cantidad = (count($this->Model_Colaborador->get_cantidad_colaborador()))+1;
        
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                    $config['upload_path'] = './foto_colaborador/'.$cantidad;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./foto_colaborador/', 0777);
                        chmod('./foto_colaborador/'.$cantidad, 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                    $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['foto'] = "foto_colaborador/".$cantidad."/".$dato['nom_documento'];
                    }    
                }
                $dato['id_externo'] = $this->Model_Colaborador->insert_colaborador($dato);
            }else{
                $valida = $this->Model_Colaborador->valida_insert_usuario_colaborador($dato);

                if(count($valida)>0){
                    echo "error";
                }else{
                    if($_FILES["foto"]["name"] != ""){
                        $cantidad = (count($this->Model_Colaborador->get_cantidad_colaborador()))+1;
            
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                        $config['upload_path'] = './foto_colaborador/'.$cantidad;
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./foto_colaborador/', 0777);
                            chmod('./foto_colaborador/'.$cantidad, 0777);
                        }
                        $config["allowed_types"] = 'jpeg|png|jpg';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES["file"]["name"] =  $dato['nom_documento']; 
                        $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                        $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['foto'] = "foto_colaborador/".$cantidad."/".$dato['nom_documento'];
                        }    
                    }
                    $dato['id_externo'] = $this->Model_Colaborador->insert_colaborador($dato);
                    $this->Model_Colaborador->insert_usuario_colaborador($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_Colaborador($id_colaborador,$id_sede){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);
            $dato['get_sede'] = $this->Model_Colaborador->get_id_sede($id_sede);
            $dato['list_perfil'] = $this->Model_Colaborador->get_list_combo_perfil($id_sede);
            $dato['list_cargo'] = $this->Model_Colaborador->get_list_combo_cargo($id_sede);
            $dato['list_departamento'] = $this->Model_Colaborador->get_list_combo_departamento();
            $dato['list_provincia'] = $this->Model_Colaborador->get_list_combo_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_Colaborador->get_list_combo_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_estado'] = $this->Model_Colaborador->get_list_estado();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/colaborador/editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_perfil'] = $this->input->post("id_perfil"); 
            $dato['id_cargo'] = $this->input->post("id_cargo");
            $dato['nombres'] = $this->input->post("nombres");
            $dato['apellido_paterno'] = $this->input->post("apellido_paterno");
            $dato['apellido_materno'] = $this->input->post("apellido_materno");
            $dato['dni'] = $this->input->post("dni");
            $dato['fec_nacimiento'] = $this->input->post("fec_nacimiento");
            $dato['correo_personal'] = $this->input->post("correo_personal");
            $dato['correo_corporativo'] = $this->input->post("correo_corporativo");
            $dato['celular'] = $this->input->post("celular");
            $dato['direccion'] = $this->input->post("direccion");
            $dato['id_departamento'] = $this->input->post("id_departamento");
            $dato['id_provincia'] = $this->input->post("id_provincia");
            $dato['id_distrito'] = $this->input->post("id_distrito");
            $dato['codigo_gll'] = $this->input->post("codigo_gll");
            $dato['nickname'] = $this->input->post("nickname");
            $dato['usuario'] = $this->input->post("usuario");
            if($this->input->post("password")!=""){
                $dato['password']= password_hash($this->input->post("password"), PASSWORD_DEFAULT);
                $dato['password_desencriptado']= $this->input->post("password");
            }else{
                $dato['password'] = "";
            }
            $dato['banco'] = $this->input->post("banco");
            $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria");
            $dato['foto']= $this->input->post("foto_actual"); 

            if($dato['usuario']==""){ 
                if($_FILES["foto"]["name"] != ""){
                    if (file_exists($dato['foto'])) { 
                        unlink($dato['foto']);
                    }
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                    $config['upload_path'] = './foto_colaborador/'.$dato['id_colaborador'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./foto_colaborador/', 0777);
                        chmod('./foto_colaborador/'.$dato['id_colaborador'], 0777);
                    }
                    $config["allowed_types"] = 'jpeg|JPEG|png|PNG|jpg|JPG';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                    $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['foto'] = "foto_colaborador/".$dato['id_colaborador']."/".$dato['nom_documento'];
                    }    
                }

                $this->Model_Colaborador->update_colaborador($dato);
            }else{
                $valida = $this->Model_Colaborador->valida_update_usuario_colaborador($dato);

                if(count($valida)>0){
                    echo "error";
                }else{
                    if($_FILES["foto"]["name"] != ""){
                        if (file_exists($dato['foto'])) { 
                            unlink($dato['foto']);
                        }
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                        $config['upload_path'] = './foto_colaborador/'.$dato['id_colaborador'];
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./foto_colaborador/', 0777);
                            chmod('./foto_colaborador/'.$dato['id_colaborador'], 0777);
                        }
                        $config["allowed_types"] = 'jpeg|JPEG|png|PNG|jpg|JPG';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                        $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['foto'] = "foto_colaborador/".$dato['id_colaborador']."/".$dato['nom_documento'];
                        }    
                    }
        
                    $this->Model_Colaborador->update_colaborador($dato);
                    $dato['id_externo'] = $dato['id_colaborador']; 

                    $valida = $this->Model_Colaborador->valida_insert_users_colaborador($dato);

                    if(count($valida)>0){
                        $this->Model_Colaborador->update_usuario_colaborador($dato);
                    }else{
                        $this->Model_Colaborador->insert_usuario_colaborador($dato);
                    }
                }
            }

            $dato['correo_personal_actual']= $this->input->post("correo_personal_actual"); 
            if($dato['correo_personal']!="" && $dato['correo_personal']!=$dato['correo_personal_actual']){
                $this->Model_Colaborador->validacion_negativa_correo_personal_colaborador($dato['id_colaborador']);
            }
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Foto_Colaborador($id_colaborador) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);
            $image = $dato['get_file'][0]['foto'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['foto']));
        }else{
            redirect('');
        }
    }

    public function Reenviar_Validacion_Correo(){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $get_id = $this->Model_Colaborador->get_id_colaborador($dato['id_colaborador']);

            if($get_id[0]['correo_personal']==""){
                echo "error";        
            }else{
                include "mcript.php";

                $id_colaborador = $encriptar($get_id[0]['id_colaborador']);

                $get_config = $this->Model_Colaborador->get_config(3);
                $url_base = $get_config[0]['url_config'];

                $mail = new PHPMailer(true);
                
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'ifvc2022';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('noreplay@ifv.edu.pe', "Snappy"); //desde donde se envia

                    $mail->addAddress($get_id[0]['correo_personal']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "Validar correo personal";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;">
                                        Estimado(a) Colaborador(a),<br>
                                        Necesitamos que valide su correo electrónico personal, de acuerdo al 
                                        documento firmado, para la autorización del uso del correo electrónico 
                                        personal para envío de información y firmas electrónicas.<br>
                                        Por favor haga click en “Validar”, Gracias.<br><br>
                                        <a href="'.$url_base.'index.php?/Colaborador/Validar_Correo_Personal/'.$id_colaborador.'" target="_blank" 
                                        style="background-color: red;
                                        color: white;
                                        border: 1px solid transparent;
                                        padding: 7px 12px;
                                        font-size: 13px;
                                        text-decoration: none;
                                        border-radius: 10px;">
                                            Validar email
                                        </a>
                                    </span><br><br>';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }    
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $this->Model_Colaborador->delete_colaborador($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Colaborador($tipo,$id_sede){ 
        $list_colaborador = $this->Model_Colaborador->get_list_colaborador($tipo,$id_sede);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:AD2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:AD2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Colaboradores');

        $sheet->setAutoFilter('B2:AD2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(15); 
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(22);
        $sheet->getColumnDimension('M')->setWidth(40);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(20);
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->getColumnDimension('W')->setWidth(15);
        $sheet->getColumnDimension('X')->setWidth(12);
        $sheet->getColumnDimension('Y')->setWidth(12);
        $sheet->getColumnDimension('Z')->setWidth(30);
        $sheet->getColumnDimension('AA')->setWidth(30);
        $sheet->getColumnDimension('AB')->setWidth(12);
        $sheet->getColumnDimension('AC')->setWidth(18);
        $sheet->getColumnDimension('AD')->setWidth(60);

        $sheet->getStyle('B2:AD2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:AD2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:AD2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("B2", 'Código'); 
        $sheet->setCellValue("C2", 'Foto');        
        $sheet->setCellValue("D2", 'Perfil');             
        $sheet->setCellValue("E2", 'Apellido Paterno');
        $sheet->setCellValue("F2", 'Apellido Materno');
        $sheet->setCellValue("G2", 'Nombre(s)');
        $sheet->setCellValue("H2", 'DNI');
        $sheet->setCellValue("I2", 'Correo Personal');
        $sheet->setCellValue("J2", 'Correo Corporativo');
        $sheet->setCellValue("K2", 'Celular');
        $sheet->setCellValue("L2", 'Fecha Nacimiento');
        $sheet->setCellValue("M2", 'Dirección');
        $sheet->setCellValue("N2", 'Departamento');
        $sheet->setCellValue("O2", 'Provincia');
        $sheet->setCellValue("P2", 'Distrito');
        $sheet->setCellValue("Q2", 'Inicio Funciones');           
        $sheet->setCellValue("R2", 'Fin Funciones');    
        $sheet->setCellValue("S2", 'Inicio Contrato');           
        $sheet->setCellValue("T2", 'Fin Contrato');   
        $sheet->setCellValue("U2", 'Nickname');
        $sheet->setCellValue("V2", 'Usuario');
        $sheet->setCellValue("W2", 'Estado'); 
        $sheet->setCellValue("X2", 'CV'); 
        $sheet->setCellValue("Y2", 'CT'); 
        $sheet->setCellValue("Z2", 'Validación Correo (Fecha)');
        $sheet->setCellValue("AA2", 'Validación Correo (Hora)');
        $sheet->setCellValue("AB2", 'FT');
        $sheet->setCellValue("AC2", 'Documentos'); 
        $sheet->setCellValue("AD2", 'Observaciones');             

        $contador=2;
        
        foreach($list_colaborador as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:AD{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("U{$contador}:V{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AD{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:AD{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:AD{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['codigo_gll']);
            $sheet->setCellValue("C{$contador}", $list['ft']);
            $sheet->setCellValue("D{$contador}", $list['perfil']);
            $sheet->setCellValue("E{$contador}", $list['apellido_paterno']);
            $sheet->setCellValue("F{$contador}", $list['apellido_materno']);
            $sheet->setCellValue("G{$contador}", $list['nombres']);
            $sheet->setCellValue("H{$contador}", $list['dni']);
            $sheet->setCellValue("I{$contador}", $list['correo_personal']);
            $sheet->setCellValue("J{$contador}", $list['correo_corporativo']);
            $sheet->setCellValue("K{$contador}", $list['celular']);
            if($list['fec_nacimiento']!=""){
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fec_nacimiento']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("M{$contador}", $list['direccion']);
            $sheet->setCellValue("N{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("O{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("P{$contador}", $list['nombre_distrito']);
            if($list['inicio_funciones']!=""){
                $sheet->setCellValue("Q{$contador}", Date::PHPToExcel($list['inicio_funciones']));
                $sheet->getStyle("Q{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin_funciones']!=""){
                $sheet->setCellValue("R{$contador}", Date::PHPToExcel($list['fin_funciones']));
                $sheet->getStyle("R{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['inicio_contrato']!=""){
                $sheet->setCellValue("S{$contador}", Date::PHPToExcel($list['inicio_contrato']));
                $sheet->getStyle("S{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin_contrato']!=""){
                $sheet->setCellValue("T{$contador}", Date::PHPToExcel($list['fin_contrato']));
                $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("U{$contador}", $list['nickname']);
            $sheet->setCellValue("V{$contador}", $list['usuario']);
            $sheet->setCellValue("W{$contador}", $list['nom_status']);
            $sheet->setCellValue("X{$contador}", $list['cv']);
            $sheet->setCellValue("Y{$contador}", $list['ct']);
            $sheet->setCellValue("Z{$contador}", $list['validacion_fecha']);
            $sheet->setCellValue("AA{$contador}", $list['validacion_hora']);
            $sheet->setCellValue("AB{$contador}", $list['ft']);
            $sheet->setCellValue("AC{$contador}", $list['doc']);
            $sheet->setCellValue("AD{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Colaboradores (Lista)';
        if (ob_get_contents()) ob_end_clean(); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Colaborador($id_colaborador,$id_sede){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);
            $dato['get_sede'] = $this->Model_Colaborador->get_id_sede($id_sede);
            //$dato['list_anios_ingreso'] = $this->Model_Colaborador->get_list_combo_anio_asistencia($dato['get_id'][0]['codigo_gll']);
            $dato['list_tipo_obs'] = $this->Model_IFV->get_list_tipo_obs(2);
            $dato['list_usuario'] = $this->Model_IFV->get_list_usuario_observacion();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/colaborador/detalle', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo_Colaborador($id_colaborador,$orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);
            if($orden==1){
                $image = $dato['get_file'][0]['archivo_dni'];
            }else{
                $image = $dato['get_file'][0]['cv'];
            }
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            if($orden==1){
                force_download($name , file_get_contents($dato['get_file'][0]['archivo_dni']));
            }else{
                force_download($name , file_get_contents($dato['get_file'][0]['cv']));
            }
        }else{
            redirect('');
        }
    }

    public function Lista_Documento_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post('id_colaborador');
            $dato['list_documento'] = $this->Model_Colaborador->get_list_documento_colaborador($dato['id_colaborador']);
            $this->load->view('view_colaborador/colaborador/lista_documento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Documento_Colaborador($id_colaborador){
        $list_documento = $this->Model_Colaborador->get_list_documento_colaborador($id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:H2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:H2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos');

        $sheet->setAutoFilter('B2:H2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);

        $sheet->getStyle('B2:H2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:H2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:H2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Año');
        $sheet->setCellValue("C2", 'Obligatorio');
        $sheet->setCellValue("D2", 'Código');
        $sheet->setCellValue("E2", 'Nombre');
        $sheet->setCellValue("F2", 'Nombre Documento');
        $sheet->setCellValue("G2", 'Subido Por');
        $sheet->setCellValue("H2", 'Fecha de Carga');

        $contador=2;
        
        foreach($list_documento as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['nom_anio']);
            $sheet->setCellValue("C{$contador}", $list['v_obligatorio']);
            $sheet->setCellValue("D{$contador}", $list['cod_documento']);
            $sheet->setCellValue("E{$contador}", $list['nom_documento']);
            $sheet->setCellValue("F{$contador}", $list['nom_archivo']);
            $sheet->setCellValue("G{$contador}", $list['usuario_subido']);
            if($list['fec_subido']!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_subido']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documentos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Contrato_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_sede'] = $this->input->post("id_sede");
            $dato['list_contrato'] = $this->Model_Colaborador->get_list_contrato_colaborador(null,$dato['id_colaborador']);
            $this->load->view('view_colaborador/colaborador/lista_contrato', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Contrato_Colaborador($id_colaborador,$id_sede){
        if ($this->session->userdata('usuario')){
            $dato['get_colab'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);
            $dato['get_cant'] = $this->Model_Colaborador->get_list_cant_contrato_colaborador($id_colaborador);
            $dato['list_perfil'] = $this->Model_Colaborador->get_list_combo_perfil($id_sede);
            $dato['list_tipo_contrato'] = $this->Model_Colaborador->get_tipo_contrato_rrhh($id_sede);
            $dato['list_estado'] = $this->Model_Colaborador->get_list_estado();
            $this->load->view('view_colaborador/colaborador/modal_registrar_contrato',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Contrato_Colaborador(){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['referencia'] = $this->input->post("referencia_i");
            $dato['id_perfil'] = $this->input->post("id_perfil_i");
            $dato['inicio_funciones'] = $this->input->post("inicio_funciones_i");
            $dato['fin_funciones'] = $this->input->post("fin_funciones_i");
            $dato['inicio_contrato'] = $this->input->post("inicio_contrato_i");
            $dato['fin_contrato'] = $this->input->post("fin_contrato_i");
            $dato['id_tipo_contrato1'] = $this->input->post("id_tipo_contrato1_i");
            $dato['sueldo1'] = $this->input->post("sueldo1_i");
            $dato['id_tipo_contrato2'] = $this->input->post("id_tipo_contrato2_i");
            $dato['sueldo2'] = $this->input->post("sueldo2_i");
            $dato['estado_contrato'] = $this->input->post("estado_contrato_i");
            if($dato['fin_contrato']!=""){
                if(strtotime($dato['fin_contrato'])<strtotime(date('Y-m-d'))){
                    $dato['estado_contrato'] = 3;
                } 
            }
            $dato['archivo'] = "";

            if($dato['estado_contrato']==3){
                if($_FILES["archivo_i"]["name"] != ""){
                    $cantidad = (count($this->Model_Colaborador->get_cantidad_contrato_colaborador()))+1;
        
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
                    $config['upload_path'] = './contrato_colaborador/'.$cantidad;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./contrato_colaborador/', 0777);
                        chmod('./contrato_colaborador/'.$cantidad, 0777);
                    }
                    $config["allowed_types"] = 'pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
                    $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "contrato_colaborador/".$cantidad."/".$dato['nom_documento'];
                    }    
                }

                $dato['id_contrato'] = $this->Model_Colaborador->insert_contrato_colaborador($dato);
            }else{
                $valida = $this->Model_Colaborador->valida_contrato_colaborador($dato);

                if (count($valida)>0) {
                    echo "error";
                }else{
                    if($_FILES["archivo_i"]["name"] != ""){
                        $cantidad = (count($this->Model_Colaborador->get_cantidad_contrato_colaborador()))+1;
            
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
                        $config['upload_path'] = './contrato_colaborador/'.$cantidad;
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./contrato_colaborador/', 0777);
                            chmod('./contrato_colaborador/'.$cantidad, 0777);
                        }
                        $config["allowed_types"] = 'pdf';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
                        $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['archivo'] = "contrato_colaborador/".$cantidad."/".$dato['nom_documento'];
                        }    
                    }

                    $dato['id_contrato'] = $this->Model_Colaborador->insert_contrato_colaborador($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }
 
    public function Validar_Correo_Personal($id_colaborador){
        include "mcript.php";

        $id_colaborador = $desencriptar($id_colaborador);
        $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($id_colaborador);

        if($dato['get_id'][0]['estado']==4){
            $dato['mensaje'] = "Ya no es un colaborador de la empresa.";
            $dato['titulo'] = "¡Validación Denegada!";
            $dato['tipo'] = "error";
        }else{
            if($dato['get_id'][0]['fecha_validacion']==null){
                $this->Model_Colaborador->validacion_positiva_correo_personal_colaborador($id_colaborador);

                $dato['mensaje'] = "Su correo ha sido validado con éxito. A partir de este momento recibirá en su correo los documentos y contratos GLLG.";
                $dato['titulo'] = "¡Validación Exitosa!";
                $dato['tipo'] = "success";
            }else{
                $dato['mensaje'] = "Ya valido su correo personal.";
                $dato['titulo'] = "¡Validación Denegada!";
                $dato['tipo'] = "error";
            }
        }
        
        $this->load->view('view_colaborador/colaborador/validacion_correo', $dato);
    }

    public function Modal_Update_Contrato_Colaborador($id_contrato,$id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_list_contrato_colaborador($id_contrato);
            $dato['list_perfil'] = $this->Model_Colaborador->get_list_combo_perfil($id_sede);
            $dato['list_tipo_contrato'] = $this->Model_Colaborador->get_tipo_contrato_rrhh($id_sede);
            $dato['list_estado'] = $this->Model_Colaborador->get_list_estado();
            $this->load->view('view_colaborador/colaborador/modal_editar_contrato', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Contrato_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_contrato'] = $this->input->post("id_contrato");
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_perfil'] = $this->input->post("id_perfil_u");
            $dato['inicio_funciones'] = $this->input->post("inicio_funciones_u");
            $dato['fin_funciones'] = $this->input->post("fin_funciones_u");
            $dato['inicio_contrato'] = $this->input->post("inicio_contrato_u");
            $dato['fin_contrato'] = $this->input->post("fin_contrato_u");
            $dato['id_tipo_contrato1'] = $this->input->post("id_tipo_contrato1_u");
            $dato['sueldo1'] = $this->input->post("sueldo1_u");
            $dato['id_tipo_contrato2'] = $this->input->post("id_tipo_contrato2_u");
            $dato['sueldo2'] = $this->input->post("sueldo2_u");
            $dato['estado_contrato'] = $this->input->post("estado_contrato_u");
            if($dato['fin_contrato']!=""){
                if(strtotime($dato['fin_contrato'])<strtotime(date('Y-m-d'))){
                    $dato['estado_contrato'] = 3;
                } 
            }
            $dato['observaciones'] = $this->input->post("observaciones_u");
            $dato['archivo'] = $this->input->post("archivo_actual");

            if($dato['estado_contrato']==3){
                if($_FILES["archivo_u"]["name"] != ""){ 
                    if (file_exists($dato['archivo'])) { 
                        unlink($dato['archivo']);
                    }
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
                    $config['upload_path'] = './contrato_colaborador/'.$dato['id_contrato'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./contrato_colaborador/', 0777);
                        chmod('./contrato_colaborador/'.$dato['id_contrato'], 0777);
                    }
                    $config["allowed_types"] = 'pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
                    $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "contrato_colaborador/".$dato['id_contrato']."/".$dato['nom_documento'];
                    }    
                }

                $this->Model_Colaborador->update_contrato_colaborador($dato);
            }else{
                $valida = $this->Model_Colaborador->valida_contrato_colaborador($dato);

                if (count($valida)>0) {
                    echo "error";
                }else{
                    if($_FILES["archivo_u"]["name"] != ""){ 
                        if (file_exists($dato['archivo'])) { 
                            unlink($dato['archivo']);
                        }
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
                        $config['upload_path'] = './contrato_colaborador/'.$dato['id_contrato'];
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./contrato_colaborador/', 0777);
                            chmod('./contrato_colaborador/'.$dato['id_contrato'], 0777);
                        }
                        $config["allowed_types"] = 'pdf';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
                        $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['archivo'] = "contrato_colaborador/".$dato['id_contrato']."/".$dato['nom_documento'];
                        }    
                    }

                    $this->Model_Colaborador->update_contrato_colaborador($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Contrato_Colaborador($id_contrato) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Colaborador->get_list_contrato_colaborador($id_contrato);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }else{
            redirect('');
        }
    }

    public function Delete_Contrato_Colaborador(){
        $dato['id_contrato'] = $this->input->post("id_contrato");
        $this->Model_Colaborador->delete_contrato_colaborador($dato);
    }

    public function Excel_Contrato_Colaborador($id_colaborador){
        $list_contrato = $this->Model_Colaborador->get_list_contrato_colaborador(null,$id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:K2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:K2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Contrato');

        $sheet->setAutoFilter('B2:K2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

        $sheet->getStyle('B2:K2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:K2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:K2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Referencia');
        $sheet->setCellValue("C2", 'Cargo');
        $sheet->setCellValue("D2", 'Inicio Funciones');
        $sheet->setCellValue("E2", 'Fin Funciones');
        $sheet->setCellValue("F2", 'Inicio Contrato');
        $sheet->setCellValue("G2", 'Fin Contrato');
        $sheet->setCellValue("H2", 'Contrato');
        $sheet->setCellValue("I2", 'Usuario');
        $sheet->setCellValue("J2", 'Fecha');
        $sheet->setCellValue("K2", 'Estado');

        $contador=2;
        
        foreach($list_contrato as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['referencia']);
            $sheet->setCellValue("C{$contador}", $list['nom_perfil']);
            if($list['inicio_funciones']!=""){
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['inicio_funciones']));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin_funciones']!=""){
                $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fin_funciones']));
                $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['inicio_contrato']!=""){
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['inicio_contrato']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin_contrato']!=""){
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fin_contrato']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("H{$contador}", $list['v_archivo']);
            $sheet->setCellValue("I{$contador}", $list['user_registro']);
            $sheet->setCellValue("J{$contador}", $list['fec_registro']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Contrato (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Pago_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_pago'] = $this->Model_Colaborador->get_list_pago_colaborador($id_colaborador);
            $this->load->view('view_colaborador/colaborador/lista_pago', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Pago_Colaborador($id_colaborador){
        $list_pago = $this->Model_Colaborador->get_list_pago_colaborador($id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:K2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:K2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Pagos');

        $sheet->setAutoFilter('B2:K2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(24);
        $sheet->getColumnDimension('K')->setWidth(25);

        $sheet->getStyle('B2:K2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:K2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:K2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Pedido');
        $sheet->setCellValue("C2", 'Tipo');
        $sheet->setCellValue("D2", 'Sub-rubro');
        $sheet->setCellValue("E2", 'Descripción');
        $sheet->setCellValue("F2", 'Monto');
        $sheet->setCellValue("G2", 'Estado');
        $sheet->setCellValue("H2", 'Aprobado por usuario');
        $sheet->setCellValue("I2", 'Fecha Aprobación');
        $sheet->setCellValue("J2", 'Fecha Entrega Monto');
        $sheet->setCellValue("K2", 'Tipo Documento');

        $contador=2;
        
        foreach($list_pago as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("B{$contador}", $list['pedido']);
            $sheet->setCellValue("C{$contador}", $list['tipo']);
            $sheet->setCellValue("D{$contador}", $list['subrubro']);
            $sheet->setCellValue("E{$contador}", $list['descripcion']);
            $sheet->setCellValue("F{$contador}", $list['monto']);
            $sheet->setCellValue("G{$contador}", $list['estado']);
            $sheet->setCellValue("H{$contador}", $list['aprobado_por']);
            if($list['fecha_aprobacion']!=""){
                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_aprobacion']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fecha_entrega']!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_entrega']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("K{$contador}", $list['tipo_documento']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pagos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Horario_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_colaborador'] = $this->input->post('id_colaborador');
            $dato['lista_horario'] = $this->Model_Colaborador->get_list_horario_colaborador(null,$dato['id_colaborador']);
            $dato['lista_horario_detalle'] = $this->Model_Colaborador->get_list_horario_detalle_colaborador($dato['id_colaborador']);
            $this->load->view('view_colaborador/colaborador/lista_horario', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Horario_Colaborador($id_colaborador){ 
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_colaborador/colaborador/modal_registrar_horario',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Insert_Horario_Colaborador(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_horario'] = "";
            $dato['id_colaborador']= $this->input->post("id_colaborador");

            $cant = $this->Model_Colaborador->valida_horario_colaborador($dato);

            if($cant[0]['cantidad']>0){
                echo "error";
            }else{
                $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($dato['id_colaborador']);
                $dato['codigo'] = $dato['get_id'][0]['codigo_gll'];
                $dato['apellido_paterno'] = $dato['get_id'][0]['apellido_paterno'];
                $dato['apellido_materno'] = $dato['get_id'][0]['apellido_materno'];
                $dato['nombres'] = $dato['get_id'][0]['nombres'];
                $dato['de'] = $this->input->post("desde_horario");
                $dato['a'] = $this->input->post("hasta_horario");
                $dato['ch_lun'] = $this->input->post("ch_lun");
                $dato['ch_mar'] = $this->input->post("ch_mar");
                $dato['ch_mier'] = $this->input->post("ch_mier");
                $dato['ch_jue'] = $this->input->post("ch_jue");
                $dato['ch_vie'] = $this->input->post("ch_vie");
                $dato['ch_sab'] = $this->input->post("ch_sab");
                $dato['ch_dom'] = $this->input->post("ch_dom");

                $anio=date('Y');
                $cod = $this->Model_Colaborador->ultimo_cod_horario();
                $totalRows_t = $cod[0]['cantidad'];
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal=$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal=$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal=$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal=$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998)
                {
                    $codigofinal=$aniof.($totalRows_t+1);
                }
                $dato['cod_horario'] = $codigofinal;
                $dato['id_horario'] = $this->Model_Colaborador->insert_horario_colaborador($dato);
                
                if($dato['ch_lun']==1){
                    $dato['ch_m']= $this->input->post("ch_m_lun");
                    $dato['ch_alm']= $this->input->post("ch_alm_lun");
                    $dato['ch_t']= $this->input->post("ch_t_lun");
                    $dato['ch_c']= $this->input->post("ch_c_lun");
                    $dato['ch_n']= $this->input->post("ch_n_lun");
                    $dato['dia']=1;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_lun");
                    $dato['salida_m']= $this->input->post("salida_m_lun");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_lun");
                    $dato['salida_alm']= $this->input->post("salida_alm_lun");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_lun");
                    $dato['salida_t']= $this->input->post("salida_t_lun");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_lun");
                    $dato['salida_c']= $this->input->post("salida_c_lun");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_lun");
                    $dato['salida_n']= $this->input->post("salida_n_lun"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_mar']==1){
                    $dato['ch_m']= $this->input->post("ch_m_mar");
                    $dato['ch_alm']= $this->input->post("ch_alm_mar");
                    $dato['ch_t']= $this->input->post("ch_t_mar");
                    $dato['ch_c']= $this->input->post("ch_c_mar");
                    $dato['ch_n']= $this->input->post("ch_n_mar");
                    $dato['dia']=2;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_mar");
                    $dato['salida_m']= $this->input->post("salida_m_mar");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_mar");
                    $dato['salida_alm']= $this->input->post("salida_alm_mar");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_mar");
                    $dato['salida_t']= $this->input->post("salida_t_mar");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_mar");
                    $dato['salida_c']= $this->input->post("salida_c_mar");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_mar");
                    $dato['salida_n']= $this->input->post("salida_n_mar"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_mier']==1){
                    $dato['ch_m']= $this->input->post("ch_m_mier");
                    $dato['ch_alm']= $this->input->post("ch_alm_mier");
                    $dato['ch_t']= $this->input->post("ch_t_mier");
                    $dato['ch_c']= $this->input->post("ch_c_mier");
                    $dato['ch_n']= $this->input->post("ch_n_mier");
                    $dato['dia']=3;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_mier");
                    $dato['salida_m']= $this->input->post("salida_m_mier");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_mier");
                    $dato['salida_alm']= $this->input->post("salida_alm_mier");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_mier");
                    $dato['salida_t']= $this->input->post("salida_t_mier");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_mier");
                    $dato['salida_c']= $this->input->post("salida_c_mier");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_mier");
                    $dato['salida_n']= $this->input->post("salida_n_mier"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_jue']==1){
                    $dato['ch_m']= $this->input->post("ch_m_jue");
                    $dato['ch_alm']= $this->input->post("ch_alm_jue");
                    $dato['ch_t']= $this->input->post("ch_t_jue");
                    $dato['ch_c']= $this->input->post("ch_c_jue");
                    $dato['ch_n']= $this->input->post("ch_n_jue");
                    $dato['dia']=4;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_jue");
                    $dato['salida_m']= $this->input->post("salida_m_jue");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_jue");
                    $dato['salida_alm']= $this->input->post("salida_alm_jue");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_jue");
                    $dato['salida_t']= $this->input->post("salida_t_jue");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_jue");
                    $dato['salida_c']= $this->input->post("salida_c_jue");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_jue");
                    $dato['salida_n']= $this->input->post("salida_n_jue"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_vie']==1){
                    $dato['ch_m']= $this->input->post("ch_m_vie");
                    $dato['ch_alm']= $this->input->post("ch_alm_vie");
                    $dato['ch_t']= $this->input->post("ch_t_vie");
                    $dato['ch_c']= $this->input->post("ch_c_vie");
                    $dato['ch_n']= $this->input->post("ch_n_vie");
                    $dato['dia']=5;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_vie");
                    $dato['salida_m']= $this->input->post("salida_m_vie");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_vie");
                    $dato['salida_alm']= $this->input->post("salida_alm_vie");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_vie");
                    $dato['salida_t']= $this->input->post("salida_t_vie");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_vie");
                    $dato['salida_c']= $this->input->post("salida_c_vie");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_vie");
                    $dato['salida_n']= $this->input->post("salida_n_vie"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_sab']==1){
                    $dato['ch_m']= $this->input->post("ch_m_sab");
                    $dato['ch_alm']= $this->input->post("ch_alm_sab");
                    $dato['ch_t']= $this->input->post("ch_t_sab");
                    $dato['ch_c']= $this->input->post("ch_c_sab");
                    $dato['ch_n']= $this->input->post("ch_n_sab");
                    $dato['dia']=6;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_sab");
                    $dato['salida_m']= $this->input->post("salida_m_sab");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_sab");
                    $dato['salida_alm']= $this->input->post("salida_alm_sab");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_sab");
                    $dato['salida_t']= $this->input->post("salida_t_sab");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_sab");
                    $dato['salida_c']= $this->input->post("salida_c_sab");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_sab");
                    $dato['salida_n']= $this->input->post("salida_n_sab"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                if($dato['ch_dom']==1){
                    $dato['ch_m']= $this->input->post("ch_m_dom");
                    $dato['ch_alm']= $this->input->post("ch_alm_dom");
                    $dato['ch_t']= $this->input->post("ch_t_dom");
                    $dato['ch_c']= $this->input->post("ch_c_dom");
                    $dato['ch_n']= $this->input->post("ch_n_dom");
                    $dato['dia']=7;
                    $dato['ingreso_m']= $this->input->post("ingreso_m_dom");
                    $dato['salida_m']= $this->input->post("salida_m_dom");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_dom");
                    $dato['salida_alm']= $this->input->post("salida_alm_dom");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_dom");
                    $dato['salida_t']= $this->input->post("salida_t_dom");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_dom");
                    $dato['salida_c']= $this->input->post("salida_c_dom");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_dom");
                    $dato['salida_n']= $this->input->post("salida_n_dom"); 
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Horario_Colaborador($id_horario){ 
        if ($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_list_horario_colaborador($id_horario);
            $dato['get_dia'] = $this->Model_Colaborador->get_dia_horario_colaborador($id_horario);
            $this->load->view('view_colaborador/colaborador/modal_editar_horario',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Horario_Colaborador(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_horario']=$this->input->post("id_horario");
            $dato['id_colaborador']= $this->input->post("id_colaborador");
            $dato['de']= $this->input->post("desde_horarioe");
            $dato['a']= $this->input->post("hasta_horarioe");
            $dato['ch_lun']= $this->input->post("ch_lune");
            $dato['ch_mar']= $this->input->post("ch_mare");
            $dato['ch_mier']= $this->input->post("ch_miere");
            $dato['ch_jue']= $this->input->post("ch_juee");
            $dato['ch_vie']= $this->input->post("ch_viee");
            $dato['ch_sab']= $this->input->post("ch_sabe");
            $dato['ch_dom']= $this->input->post("ch_dome");
            $dato['estado_registro']= $this->input->post("estado_registro_horarioe");

            $cant = $this->Model_Colaborador->valida_horario_colaborador($dato);

            if($cant[0]['cantidad']>0){
                echo "error";
            }else{
                $this->Model_Colaborador->update_horario_colaborador($dato);
                $this->Model_Colaborador->delete_horario_detalle_colaborador($dato);

                $dato['dia']=1;
                if($dato['ch_lun']==1){
                    $dato['ch_m']= $this->input->post("ch_m_lune");
                    $dato['ch_alm']= $this->input->post("ch_alm_lune");
                    $dato['ch_t']= $this->input->post("ch_t_lune");
                    $dato['ch_c']= $this->input->post("ch_c_lune");
                    $dato['ch_n']= $this->input->post("ch_n_lune");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_lune");
                    $dato['salida_m']= $this->input->post("salida_m_lune");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_lune");
                    $dato['salida_alm']= $this->input->post("salida_alm_lune");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_lune");
                    $dato['salida_t']= $this->input->post("salida_t_lune");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_lune");
                    $dato['salida_c']= $this->input->post("salida_c_lune");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_lune");
                    $dato['salida_n']= $this->input->post("salida_n_lune");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=2;
                if($dato['ch_mar']==1){
                    $dato['ch_m']= $this->input->post("ch_m_mare");
                    $dato['ch_alm']= $this->input->post("ch_alm_mare");
                    $dato['ch_t']= $this->input->post("ch_t_mare");
                    $dato['ch_c']= $this->input->post("ch_c_mare");
                    $dato['ch_n']= $this->input->post("ch_n_mare");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_mare");
                    $dato['salida_m']= $this->input->post("salida_m_mare");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_mare");
                    $dato['salida_alm']= $this->input->post("salida_alm_mare");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_mare");
                    $dato['salida_t']= $this->input->post("salida_t_mare");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_mare");
                    $dato['salida_c']= $this->input->post("salida_c_mare");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_mare");
                    $dato['salida_n']= $this->input->post("salida_n_mare");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=3;
                if($dato['ch_mier']==1){
                    $dato['ch_m']= $this->input->post("ch_m_miere");
                    $dato['ch_alm']= $this->input->post("ch_alm_miere");
                    $dato['ch_t']= $this->input->post("ch_t_miere");
                    $dato['ch_c']= $this->input->post("ch_c_miere");
                    $dato['ch_n']= $this->input->post("ch_n_miere");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_miere");
                    $dato['salida_m']= $this->input->post("salida_m_miere");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_miere");
                    $dato['salida_alm']= $this->input->post("salida_alm_miere");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_miere");
                    $dato['salida_t']= $this->input->post("salida_t_miere");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_miere");
                    $dato['salida_c']= $this->input->post("salida_c_miere");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_miere");
                    $dato['salida_n']= $this->input->post("salida_n_miere");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=4;
                if($dato['ch_jue']==1){
                    $dato['ch_m']= $this->input->post("ch_m_juee");
                    $dato['ch_alm']= $this->input->post("ch_alm_juee");
                    $dato['ch_t']= $this->input->post("ch_t_juee");
                    $dato['ch_c']= $this->input->post("ch_c_juee");
                    $dato['ch_n']= $this->input->post("ch_n_juee");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_juee");
                    $dato['salida_m']= $this->input->post("salida_m_juee");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_juee");
                    $dato['salida_alm']= $this->input->post("salida_alm_juee");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_juee");
                    $dato['salida_t']= $this->input->post("salida_t_juee");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_juee");
                    $dato['salida_c']= $this->input->post("salida_c_juee");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_juee");
                    $dato['salida_n']= $this->input->post("salida_n_juee");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=5;
                if($dato['ch_vie']==1){
                    $dato['ch_m']= $this->input->post("ch_m_viee");
                    $dato['ch_alm']= $this->input->post("ch_alm_viee");
                    $dato['ch_t']= $this->input->post("ch_t_viee");
                    $dato['ch_c']= $this->input->post("ch_c_viee");
                    $dato['ch_n']= $this->input->post("ch_n_viee");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_viee");
                    $dato['salida_m']= $this->input->post("salida_m_viee");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_viee");
                    $dato['salida_alm']= $this->input->post("salida_alm_viee");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_viee");
                    $dato['salida_t']= $this->input->post("salida_t_viee");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_viee");
                    $dato['salida_c']= $this->input->post("salida_c_viee");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_viee");
                    $dato['salida_n']= $this->input->post("salida_n_viee");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=6;
                if($dato['ch_sab']==1){
                    $dato['ch_m']= $this->input->post("ch_m_sabe");
                    $dato['ch_alm']= $this->input->post("ch_alm_sabe");
                    $dato['ch_t']= $this->input->post("ch_t_sabe");
                    $dato['ch_c']= $this->input->post("ch_c_sabe");
                    $dato['ch_n']= $this->input->post("ch_n_sabe");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_sabe");
                    $dato['salida_m']= $this->input->post("salida_m_sabe");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_sabe");
                    $dato['salida_alm']= $this->input->post("salida_alm_sabe");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_sabe");
                    $dato['salida_t']= $this->input->post("salida_t_sabe");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_sabe");
                    $dato['salida_c']= $this->input->post("salida_c_sabe");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_sabe");
                    $dato['salida_n']= $this->input->post("salida_n_sabe");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }

                $dato['dia']=7;
                if($dato['ch_dom']==1){
                    $dato['ch_m']= $this->input->post("ch_m_dome");
                    $dato['ch_alm']= $this->input->post("ch_alm_dome");
                    $dato['ch_t']= $this->input->post("ch_t_dome");
                    $dato['ch_c']= $this->input->post("ch_c_dome");
                    $dato['ch_n']= $this->input->post("ch_n_dome");    
                    $dato['ingreso_m']= $this->input->post("ingreso_m_dome");
                    $dato['salida_m']= $this->input->post("salida_m_dome");
                    $dato['ingreso_alm']= $this->input->post("ingreso_alm_dome");
                    $dato['salida_alm']= $this->input->post("salida_alm_dome");
                    $dato['ingreso_t']= $this->input->post("ingreso_t_dome");
                    $dato['salida_t']= $this->input->post("salida_t_dome");
                    $dato['ingreso_c']= $this->input->post("ingreso_c_dome");
                    $dato['salida_c']= $this->input->post("salida_c_dome");
                    $dato['ingreso_n']= $this->input->post("ingreso_n_dome");
                    $dato['salida_n']= $this->input->post("salida_n_dome");
                    $this->Model_Colaborador->insert_horario_detalle_colaborador($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Horario_Colaborador() {
        if ($this->session->userdata('usuario')){
            $dato['id_horario'] = $this->input->post("id_horario");
            $this->Model_Colaborador->delete_horario_colaborador($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Horario_Colaborador($id_colaborador){
        $list_horario = $this->Model_Colaborador->get_list_horario_detalle_colaborador($id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:O2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:O2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Horario');

        $sheet->setAutoFilter('B2:O2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(18);

        $sheet->getStyle('B2:O2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:O2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:O2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'De');
        $sheet->setCellValue("C2", 'A');
        $sheet->setCellValue("D2", 'Estado');
        $sheet->setCellValue("E2", 'Día');
        $sheet->setCellValue("F2", 'Ingreso Mañana');
        $sheet->setCellValue("G2", 'Salida Mañana');
        $sheet->setCellValue("H2", 'Ingreso Almuerzo');
        $sheet->setCellValue("I2", 'Salida Almuerzo');
        $sheet->setCellValue("J2", 'Ingreso Tarde');
        $sheet->setCellValue("K2", 'Salida Tarde');
        $sheet->setCellValue("L2", 'Ingreso Cena');
        $sheet->setCellValue("M2", 'Salida Cena');
        $sheet->setCellValue("N2", 'Ingreso Noche');
        $sheet->setCellValue("O2", 'Salida Noche');

        $contador=2;
        
        foreach($list_horario as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            if($list['de']!=""){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['de']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['a']!=""){
                $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['a']));
                $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("D{$contador}", $list['estado']);
            $sheet->setCellValue("E{$contador}", $list['dia']);
            $sheet->setCellValue("F{$contador}", $list['ingreso_m']);
            $sheet->setCellValue("G{$contador}", $list['salida_m']);
            $sheet->setCellValue("H{$contador}", $list['ingreso_alm']);
            $sheet->setCellValue("I{$contador}", $list['salida_alm']);
            $sheet->setCellValue("J{$contador}", $list['ingreso_t']);
            $sheet->setCellValue("K{$contador}", $list['salida_t']);
            $sheet->setCellValue("L{$contador}", $list['ingreso_c']);
            $sheet->setCellValue("M{$contador}", $list['salida_c']);
            $sheet->setCellValue("N{$contador}", $list['ingreso_n']);
            $sheet->setCellValue("O{$contador}", $list['salida_n']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Horario (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Traer_Mes_Asistencia_Colaborador() { 
        if ($this->session->userdata('usuario')) { 
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_anio'] = $this->input->post("id_anio");
            $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($dato['id_colaborador']);
            $dato['codigo'] = $dato['get_id'][0]['codigo_gll'];
            $dato['list_meses']=$this->Model_Colaborador->get_list_combo_mes_asistencia($dato);
            $this->load->view('view_colaborador/colaborador/mes',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Asistencia_Colaborador() { 
        if ($this->session->userdata('usuario')) { 
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_anio'] = $this->input->post("id_anio");
            $dato['id_mes'] = $this->input->post("id_mes");
            $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($dato['id_colaborador']);
            $dato['codigo'] = $dato['get_id'][0]['codigo_gll'];
            $dato['list_registro_ingreso'] = $this->Model_Colaborador->get_list_asistencia_colaborador($dato);
            $this->load->view('view_colaborador/colaborador/lista_asistencia',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Observacion_Asistencia_Colaborador($id_registro_ingreso){
        if ($this->session->userdata('usuario')) {
            $dato['list_historico_ingreso'] = $this->Model_Colaborador->get_list_asistencia_observacion_colaborador($id_registro_ingreso); 
            $this->load->view('view_colaborador/colaborador/modal_obs_asistencia', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Asistencia_Colaborador($id_colaborador,$id_anio,$id_mes){  
        $dato['id_colaborador'] = $id_colaborador;
        $dato['id_anio'] = $id_anio;
        $dato['id_mes'] = $id_mes;
        $dato['get_id'] = $this->Model_Colaborador->get_id_colaborador($dato['id_colaborador']);
        $dato['codigo'] = $dato['get_id'][0]['codigo_gll'];   
        $list_registro_ingreso = $this->Model_Colaborador->get_list_asistencia_colaborador($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(15);

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:G1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:G1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha');             
        $sheet->setCellValue("B1", 'Hora');
        $sheet->setCellValue("C1", 'Obs');
        $sheet->setCellValue("D1", 'Tipo'); 
        $sheet->setCellValue("E1", 'Estado'); 
        $sheet->setCellValue("F1", 'Autorización');
        $sheet->setCellValue("G1", 'Registro'); 

        $contador=1;
        
        foreach($list_registro_ingreso as $list){  
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha_ingreso']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['hora_ingreso']);
            $sheet->setCellValue("C{$contador}", $list['obs']);
            $sheet->setCellValue("D{$contador}", $list['tipo_desc']);
            $sheet->setCellValue("E{$contador}", $list['nom_estado_reporte']);
            $sheet->setCellValue("F{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("G{$contador}", $list['estado_ing']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Lista_Compra_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_compra'] = $this->Model_Colaborador->get_list_compra_colaborador($id_colaborador);
            $this->load->view('view_colaborador/colaborador/lista_compra', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Compra_Colaborador($id_colaborador){
        $list_compra = $this->Model_Colaborador->get_list_compra_colaborador($id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:H2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:H2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Compras');

        $sheet->setAutoFilter('B2:H2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);

        $sheet->getStyle('B2:H2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:H2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:H2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Producto');
        $sheet->setCellValue("C2", 'Precio');
        $sheet->setCellValue("D2", 'Cantidad');
        $sheet->setCellValue("E2", 'Total');
        $sheet->setCellValue("F2", 'Recibo Electrónico');
        $sheet->setCellValue("G2", 'Fecha de Pago');
        $sheet->setCellValue("H2", 'Efectuado Por');

        $contador=2;
        
        foreach($list_compra as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("B{$contador}", $list['cod_producto']);
            $sheet->setCellValue("C{$contador}", $list['precio']);
            $sheet->setCellValue("D{$contador}", $list['cantidad']);
            $sheet->setCellValue("E{$contador}", $list['total']);
            $sheet->setCellValue("F{$contador}", $list['cod_venta']);
            if($list['fecha_pago']!=""){
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fecha_pago']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("H{$contador}", $list['usuario_codigo']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Compras (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Observacion_Colaborador() {
        if ($this->session->userdata('usuario')) { 
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_observacion']=$this->Model_Colaborador->get_list_observacion_colaborador(null,$id_colaborador);
            $this->load->view('view_colaborador/colaborador/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Colaborador() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['id_tipo'] = $this->input->post("id_tipo_o");
            $dato['fecha'] = $this->input->post("fecha_o");
            $dato['observacion'] = $this->input->post("observacion_o");

            if($dato['id_tipo']!="0"){
                $valida = $this->Model_Colaborador->valida_insert_observacion_colaborador($dato);

                if(count($valida)>0){
                    echo "error";
                }else{
                    $dato['usuario'] = $this->input->post("usuario_o");
                    $dato['comentariog'] = $this->input->post("comentariog_o");
                    $dato['observacion_archivo'] = "";

                    if($_FILES["observacion_archivo"]["name"] != ""){
                        $dato['path'] = $_FILES['observacion_archivo']['name'];
                        $fecha=date('Y-m-d');
                        $path = $_FILES['observacion_archivo']['name'];

                        $ext = pathinfo($path, PATHINFO_EXTENSION);

                        $mi_archivo = 'observacion_archivo';

                        $dato['nom_documento'] = "obs_historial".$dato['id_colaborador'].$fecha."_".rand(1,200).".".$ext;
                        $config['upload_path'] = './colaborador/observacion/'.$dato['id_colaborador'];
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./colaborador/observacion/', 0777);
                            chmod('./colaborador/observacion/'.$dato['id_colaborador'], 0777);
                        }
                        $config["allowed_types"] = 'pdf|pdf|jpg|JPG|jpeg|JPEG|mp4|png|PNG';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["observacion_archivo"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["observacion_archivo"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["observacion_archivo"]["error"];
                        $_FILES["file"]["size"] = $_FILES["observacion_archivo"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['observacion_archivo'] = "colaborador/observacion/".$dato['id_colaborador']."/".$dato['nom_documento'];
                        }    
                    }

                    $this->Model_Colaborador->insert_observacion_colaborador($dato);
                }
            }

            $this->Model_Colaborador->update_comentario_colaborador($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Observacion_Colaborador() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['get_id'] = $this->Model_Colaborador->get_list_observacion_colaborador($dato['id_observacion']);

            if (file_exists($dato['get_id'][0]['observacion_archivo'])) {
                unlink($dato['get_id'][0]['observacion_archivo']);
            }
            $this->Model_Colaborador->delete_observacion_colaborador($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Observacion_Colaborador($id_colaborador){
        $list_observacion = $this->Model_Colaborador->get_list_observacion_colaborador(null,$id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:F2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:F2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Observaciones');

        $sheet->setAutoFilter('B2:F2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(16);

        $sheet->getStyle('B2:F2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:F2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:F2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Fecha'); 
        $sheet->setCellValue("C2", 'Tipo');
        $sheet->setCellValue("D2", 'Usuario');
        $sheet->setCellValue("E2", 'Comentario');
        $sheet->setCellValue("F2", 'Documento');

        $contador=2;
        
        foreach($list_observacion as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            if($list['fecha']!=""){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("C{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("D{$contador}", $list['usuario']);
            $sheet->setCellValue("E{$contador}", $list['observacion']);
            $sheet->setCellValue("F{$contador}", $list['v_documento']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Observaciones (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /* ------------------Documento------------------*/
    public function Documento_Colaborador($id_sede) {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($id_sede);

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }/*elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }*/

            $this->load->view('view_colaborador/documento_colaborador/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento_Colaborador_Modulo() {
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $get_id = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['id_empresa'] = $get_id[0]['id_empresa'];
            $dato['list_documento'] = $this->Model_Colaborador->get_list_documento_colab($dato,null);
            $this->load->view('view_colaborador/documento_colaborador/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento_Colab($id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $id_sede;
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['list_empresa']=$this->Model_Colaborador->get_list_empresa();
            $dato['list_anio'] = $this->Model_Colaborador->get_list_anio();
            //var_dump( $dato['get_id']);
            $this->load->view('view_colaborador/documento_colaborador/modal_registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento_Colab(){
        $dato['id_anio'] =  $this->input->post("id_anio_i");
        $dato['id_empresa'] =  $this->input->post("id_empresa_i");
        $dato['id_sede']= $this->input->post("id_sede_i");

        $dato['cod_documento']= $this->input->post("cod_documento_i");
        $dato['nom_documento']= $this->input->post("nom_documento_i");

        $dato['descripcion_documento']= $this->input->post("descripcion_documento_i");
        $dato['obligatorio']= $this->input->post("obligatorio_i");
        $dato['digital']= $this->input->post("digital_i");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_i");
        $dato['validacion']= $this->input->post("validacion_i");

        $total=count($this->Model_Colaborador->valida_insert_documento_colab($dato));

        if($total>0){
            echo "error";
        }else{
            if($dato['id_sede']==0){
                $id_empresa=$dato['id_empresa'];
                $list_sede = $this->Model_Colaborador->get_list_sede($id_empresa);
                foreach($list_sede as $list){
                    $dato['id_sede'] = $list['id_sede'];
                    $this->Model_Colaborador->insert_documento_colab($dato);

                    if($dato['aplicar_todos']==1){
                        $get_id = $this->Model_Colaborador->ultimo_id_documento_colab($dato);
                        $dato['id_documento'] = $get_id[0]['id_documento'];
        
                        $list_colaborador = $this->Model_Colaborador->get_list_colaborador_combo($dato);
        
                        foreach($list_colaborador as $list){
                            $dato['id_colaborador'] = $list['id_colaborador'];
                            $valida = $this->Model_Colaborador->valida_insert_documento_todos_colab($dato);
                            if(count($valida)==0){
                                $this->Model_Colaborador->insert_documento_todos_colab($dato);
                            }
                        }
                    }
                }
            }else{
                $this->Model_Colaborador->insert_documento_colab($dato);
                if($dato['aplicar_todos']==1){
                    $get_id = $this->Model_Colaborador->ultimo_id_documento_colab($dato);
                    $dato['id_documento'] = $get_id[0]['id_documento'];
    
                    $list_colaborador = $this->Model_Colaborador->get_list_colaborador_combo($dato);
    
                    foreach($list_colaborador as $list){
                        $dato['id_colaborador'] = $list['id_colaborador'];
                        $valida = $this->Model_Colaborador->valida_insert_documento_todos_colab($dato);
                        if(count($valida)==0){
                            $this->Model_Colaborador->insert_documento_todos_colab($dato);
                        }
                    }
                }
            }
        }
    }
    
    public function Modal_Update_Documento_Colab($id_documento,$id_empresa,$id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=$id_empresa;
            $dato['id_sede']=$id_sede;
            $dato['get_id'] = $this->Model_Colaborador->get_list_documento_colab($dato,$id_documento);
            
            $dato['list_empresa']=$this->Model_Colaborador->get_list_empresa();
            $id_empresa=$dato['get_id'][0]['id_empresa'];
            //var_dump($id_empresa);
            $dato['lista_sede'] = $this->Model_Colaborador->get_list_sede($id_empresa);
            $dato['list_status'] = $this->Model_Colaborador->get_list_estado();
            $dato['list_anio'] = $this->Model_Colaborador->get_list_anio();
            $this->load->view('view_colaborador/documento_colaborador/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Update_Documento_Colab(){
        $dato['id_anio'] =  $this->input->post("id_anio_u");
        $dato['id_sede'] =  $this->input->post("id_sede_u");
        $dato['id_empresa'] =  $this->input->post("id_empresa_u");
        $dato['id_documento']= $this->input->post("id_documento");
        $dato['cod_documento']= $this->input->post("cod_documento_u");
        //$dato['id_grado']= $this->input->post("id_grado_u");
        $dato['nom_documento']= $this->input->post("nom_documento_u");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_u");
        $dato['obligatorio']= $this->input->post("obligatorio_u");
        $dato['estado']= $this->input->post("estado_u");
        $dato['digital']= $this->input->post("digital_u");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_u");
        $dato['validacion']= $this->input->post("validacion_u");

        $total=count($this->Model_Colaborador->valida_update_documento_colab($dato));

        if($total>0){
            echo "error";
        }else{
            if($dato['id_sede']==0){
                $id_empresa=$dato['id_empresa'];
                $list_sede = $this->Model_Colaborador->get_list_sede($id_empresa);
                foreach($list_sede as $list){
                    $dato['id_sede'] = $list['id_sede'];
                    $this->Model_Colaborador->update_documento_colab($dato);

                    if($dato['aplicar_todos']==1){
                        $get_id = $this->Model_Colaborador->ultimo_id_documento_colab($dato);
                        $dato['id_documento'] = $get_id[0]['id_documento'];
        
                        $list_colaborador = $this->Model_Colaborador->get_list_colaborador_combo($dato);
        
                        foreach($list_colaborador as $list){
                            $dato['id_colaborador'] = $list['id_colaborador'];
                            $valida = $this->Model_Colaborador->valida_insert_documento_todos_colab($dato);
                            if(count($valida)==0){
                                $this->Model_Colaborador->insert_documento_todos_colab($dato);
                            }
                        }
                    }
                }
            }else{
                $this->Model_Colaborador->update_documento_colab($dato);
                if($dato['aplicar_todos']==1){
                    $get_id = $this->Model_Colaborador->ultimo_id_documento_colab($dato);
                    $dato['id_documento'] = $get_id[0]['id_documento'];
    
                    $list_colaborador = $this->Model_Colaborador->get_list_colaborador_combo($dato);
    
                    foreach($list_colaborador as $list){
                        $dato['id_colaborador'] = $list['id_colaborador'];
                        $valida = $this->Model_Colaborador->valida_insert_documento_todos_colab($dato);
                        if(count($valida)==0){
                            $this->Model_Colaborador->insert_documento_todos_colab($dato);
                        }
                    }
                }
            }
        }
    }

    public function Delete_Documento_Colab(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_Colaborador->delete_documento_colab($dato);
    }

    public function Excel_Documento_Colaborador_Modulo(){
       
        $list_documentos = $this->Model_Colaborador->get_list_documento_colab($dato,null);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:F2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:F2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos Colaboradores');

        $sheet->setAutoFilter('B2:F2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->getStyle('B2:I2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:I2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:I2")->applyFromArray($styleThinBlackBorderOutline);
          
        $sheet->setCellValue("B2", 'Año'); 
        $sheet->setCellValue("C2", 'Empresa');
        $sheet->setCellValue("D2", 'Sede');
        $sheet->setCellValue("E2", 'Código');
        $sheet->setCellValue("F2", 'Nombre');
        $sheet->setCellValue("G2", 'Descripción');
        $sheet->setCellValue("H2", 'Obligatorio');
        $sheet->setCellValue("I2", 'Estado');

        $contador=2;
        
        foreach($list_documentos as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['nom_anio']);
            $sheet->setCellValue("C{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("D{$contador}", $list['cod_sede']);
            $sheet->setCellValue("E{$contador}", $list['cod_documento']);
            $sheet->setCellValue("F{$contador}", $list['nom_documento']);
            $sheet->setCellValue("G{$contador}", $list['descripcion_documento']);
            $sheet->setCellValue("H{$contador}", $list['obligatorio']);
            $sheet->setCellValue("I{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documento Colaboradores (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //---------------------------------------------FOTOCHECK COLABORADOR-------------------------------------------
    public function Fotocheck_Colaborador($id_sede){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($id_sede);
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/fotocheck_colaborador/index',$dato);
        }
    }

    public function Lista_Fotocheck_Colaborador() {
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $get_id = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['id_empresa'] = $get_id[0]['id_empresa'];
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_fotocheck'] = $this->Model_Colaborador->get_list_fotocheck($dato);
            $this->load->view('view_colaborador/fotocheck_colaborador/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Detalle($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_colaborador/fotocheck_colaborador/modal_detalle', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Foto($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_colaborador/fotocheck_colaborador/modal_foto', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Guardar_Foto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['id_colaborador'] = $this->input->post("Id");
            $dato['foto_fotocheck'] = $this->input->post("actual_foto_fotocheck");
            $dato['foto_fotocheck_2'] = $this->input->post("actual_foto_fotocheck_2");
            $dato['foto_fotocheck_3'] = $this->input->post("actual_foto_fotocheck_3");
            $dato['id_empresa'] = $this->input->post("id_empresa");
            $dato['id_sede'] = $this->input->post("id_sede");
            

            if($_FILES["foto_fotocheck_2"]["name"] != ""){
                $get_doc = $this->Model_Colaborador->get_cod_documento_colaborador($dato,'D01');
                if (file_exists($dato['foto_fotocheck_2'])) {
                    unlink($dato['foto_fotocheck_2']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_2"]["name"]);
                $config['upload_path'] = './documento_colaborador/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador/', 0777);
                    chmod('./documento_colaborador/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf|JPEG|JPG|PNG|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["foto_fotocheck_2"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["foto_fotocheck_2"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["foto_fotocheck_2"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["foto_fotocheck_2"]["error"];
                $_FILES["file"]["size"] = $_FILES["foto_fotocheck_2"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['foto_fotocheck_2'] = "documento_colaborador/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 2;
                $this->Model_Colaborador->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_Colaborador->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck_2'];
                $this->Model_Colaborador->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck"]["name"] != ""){
                $get_doc = $this->Model_Colaborador->get_cod_documento_colaborador($dato,'D00');
                if (file_exists($dato['foto_fotocheck'])) {
                    unlink($dato['foto_fotocheck']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck"]["name"]);
                $config['upload_path'] = './documento_colaborador/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador/', 0777);
                    chmod('./documento_colaborador/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf|JPEG|JPG|PNG|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["foto_fotocheck"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["foto_fotocheck"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["foto_fotocheck"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["foto_fotocheck"]["error"];
                $_FILES["file"]["size"] = $_FILES["foto_fotocheck"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['foto_fotocheck'] = "documento_colaborador/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 1;
                $this->Model_Colaborador->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_Colaborador->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck'];
                $this->Model_Colaborador->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck_3"]["name"] != ""){
                if (file_exists($dato['foto_fotocheck_3'])) {
                    unlink($dato['foto_fotocheck_3']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_3"]["name"]);
                $config['upload_path'] = './documento_colaborador/0/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador/', 0777);
                    chmod('./documento_colaborador/0', 0777);
                    chmod('./documento_colaborador/0/'.$dato['id_colaborador'], 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf|JPEG|JPG|PNG|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["foto_fotocheck_3"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["foto_fotocheck_3"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["foto_fotocheck_3"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["foto_fotocheck_3"]["error"];
                $_FILES["file"]["size"] = $_FILES["foto_fotocheck_3"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['foto_fotocheck_3'] = "documento_colaborador/0/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 3;
                $this->Model_Colaborador->update_foto_fotocheck($dato);
            }

            $valida = $this->Model_Colaborador->valida_fotocheck_completo($dato['id_fotocheck']);

            if(count($valida)==0){
                $this->Model_Colaborador->update_fotocheck_completo($dato);
            }

            /*$foto=  $_FILES["foto_fotocheck"]["type"];
            $foto2= $_FILES["foto_fotocheck_2"]["type"];
            $foto3= $_FILES["foto_fotocheck_3"]["type"];

            $alumno=$this->Model_IFV->get_id_fotocheck($id_matriculado);
            $cantidad=$alumno[0]['total_subidos'];
            if($alumno[0]['foto_fotocheck']!='' && $foto!=''){
                $cantidad--;
            }
            if($alumno[0]['foto_fotocheck_2']!='' && $foto2!=''){
                $cantidad--;
            }
            if($alumno[0]['foto_fotocheck_3']!='' && $foto3!=''){
                $cantidad--;
            }
            $this->Model_IFV->insert_foto_fotocheck($id_matriculado,$cantidad);*/
        } else {
            redirect('/login');
        }
    }

    public function Carne_Colaborador($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_fotocheck($id_fotocheck);
            $dato['altura'] = 560;//+$cantidad_filas;
            
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' =>0,
                'mode' => 'utf-8',
                'format' => array(55,85),'portrait',
                'margin_bottom' => 0,
                'margin_right' => -15.2,
                'bleedMargin' => 0,
                'crossMarkMargin' => 0,
                'cropMarkMargin' => 0,
                'nonPrintMargin' => 0,
                'margBuffer' => 0,
                'collapseBlockMargins' => false,
            ]);
            $html = $this->load->view('view_colaborador/fotocheck_colaborador/carnet',$dato,true);
            //$mpdf->SetHTMLHeader("Content-Disposition: inline");
            $mpdf->WriteHTML($html);
            $mpdf->Output($dato['get_id'][0]['Id'].".pdf","I");
        }else{
            redirect('/login');
        }
    }

    public function Modal_Anular_Colab($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_colaborador/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Impresion_Fotocheck(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck']= $this->input->post("id_fotocheck");
            $this->Model_Colaborador->impresion_fotocheck($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Anular($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Colaborador->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_colaborador/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Anular_Envio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['obs_anulado'] = $this->input->post("obs_anulado");
            $this->Model_Colaborador->anular_envio($dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Envio(){
        if ($this->session->userdata('usuario')) {
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

            $dato['get_id_user'] = $this->Model_Colaborador->get_id_user();
            $dato['list_cargo_sesion'] = $this->Model_Colaborador->get_cargo_x_id($id_usuario);
            $this->load->view('view_colaborador/fotocheck_colaborador/modal_envio', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Cargo(){
        if ($this->session->userdata('usuario')) {
            $id_usuario_de = $this->input->post("usuario_encomienda");
            $dato['list_cargo'] = $this->Model_Colaborador->get_cargo_x_id($id_usuario_de);
            $dato['id_cargo'] = "cargo_envio_f";
            $this->load->view('view_colaborador/fotocheck_colaborador/cargo',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Guardar_Envio(){
        if ($this->session->userdata('usuario')) {
            $cadena = substr($this->input->post("cadena"),0,-1);
            $cantidad = $this->input->post("cantidad");

            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $id_nivel = $_SESSION['usuario'][0]['id_nivel'];

            if ($id_usuario==1 || $id_nivel==6 || $id_usuario==7){
                $dato['usuario_encomienda'] = $this->input->post("id_usuario_u");
            }else{
                $dato['usuario_encomienda'] = $_SESSION['usuario'][0]['id_usuario'];
            }

            $dato['fecha_envio']= $this->input->post("fecha_u");
            $dato['cargo_envio']= $this->input->post("id_cargo_u");

            if($cantidad>0){
                $array = explode(",",$cadena);
                $i = 0;

                while($i<count($array)){
                    $dato['id_fotocheck'] = $array[$i];

                    $alumno = $this->Model_Colaborador->get_id_fotocheck($dato['id_fotocheck']);

                    if(count($alumno)>0){
                        if ($alumno[0]['esta_fotocheck']=='Foto Rec'){
                            $this->Model_Colaborador->update_envio_fotocheck($dato);
                        }
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_Sede(){
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $var='i';
            if($tipo==2){
                $var='u';
            }
            $id_empresa = $this->input->post("id_empresa_".$var);
            $dato['tipo']=$var;
            if($id_empresa > 0){
                $dato['lista_sede'] = $this->Model_Colaborador->get_list_sede($id_empresa);
                $this->load->view('view_colaborador/documento_colaborador/sede',$dato);
            }else{
                $this->load->view('view_colaborador/documento_colaborador/sede_vacio');
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Documento_Colaborador($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['get_detalle'] = $this->Model_Colaborador->get_id_detalle_colaborador_empresa($id_detalle);
            $dato['get_documento'] = $this->Model_Colaborador->get_list_documento( $dato['get_detalle'][0]['id_documento']);
            $this->load->view('view_colaborador/colaborador/modal_editar_documento', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Colaborador(){
        $dato['id_detalle']= $this->input->post("id_detalle");
        $get_id = $this->Model_Colaborador->get_id_detalle_colaborador_empresa($dato['id_detalle']);
        $dato['id_colaborador'] = $get_id[0]['id_colaborador'];
        $dato['cod_empresa'] = $get_id[0]['cod_empresa'];
        $dato['archivo'] = $this->input->post("archivo_actual");

        if($_FILES["archivo_u"]["name"] != ""){
            if (file_exists($dato['archivo'])) { 
                unlink($dato['archivo']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
            $config['upload_path'] = './documento_colaborador/'.$dato['cod_empresa'].'/'.$dato['id_colaborador'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_colaborador/', 0777);
                chmod('./documento_colaborador/'.$dato['cod_empresa'].'/', 0777);
                chmod('./documento_colaborador/'.$dato['cod_empresa'].'/'.$dato['id_colaborador'], 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["archivo_u"]["name"];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['archivo'] = "documento_colaborador/".$dato['cod_empresa']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_Colaborador->update_documento_colaborador($dato);
    }

    public function Descartar_Documento_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post("id_detalle");
            $dato['doc'] = $this->Model_Colaborador->get_id_detalle_colaborador_empresa($dato['id_detalle']);
            if($dato['doc'][0]['archivo']!=""){
                unlink($dato['doc'][0]['archivo']);
            }
            $this->Model_Colaborador->descartar_documento_colaborador($dato);
        } else {
            redirect('/login');
        }
    }

    public function Delete_Documento_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post("id_detalle");
            $dato['doc'] = $this->Model_Colaborador->get_id_detalle_colaborador_empresa($dato['id_detalle']);
            if($dato['doc'][0]['archivo']!=""){
                unlink($dato['doc'][0]['archivo']);
            }
            $this->Model_Colaborador->delete_documento_colaborador($dato);
        } else {
            redirect('/login');
        }
    }

    public function Descargar_Documento_Colaborador($id_detalle)
    {
        if ($this->session->userdata('usuario')) {
            $dato['doc'] = $this->Model_Colaborador->get_id_detalle_colaborador_empresa($id_detalle);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen, NULL);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Asignar_Documento_Colaborador($id_colaborador,$id_sede){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador']=$id_colaborador;
            $dato['id_sede']=$id_sede;
            $dato['get_list_anio'] = $this->Model_Colaborador->get_id_documento_x_sede($id_colaborador,$id_sede);
        $this->load->view('view_colaborador/colaborador/modal_asignar_documento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Nombre_Documento_x_Anio(){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador']=$this->input->post("id_colaborador");
            $dato['id_sede']=$this->input->post("id_sede");
            $dato['id_anio']=$this->input->post("id_anio_i");
            $dato['list_nombre'] = $this->Model_Colaborador->get_id_documento_x_sede_anio($dato);
        $this->load->view('view_colaborador/colaborador/cmb_nombre',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Datos_Documento_x_Anio_Nombre(){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador']=$this->input->post("id_colaborador");
            $dato['id_sede']=$this->input->post("id_sede");
            $dato['id_anio']=$this->input->post("id_anio_i");
            $dato['nombre']=$this->input->post("nombre");
            $dato['get_doc'] = $this->Model_Colaborador->get_id_documento_x_sede_anio_nombre($dato);
        $this->load->view('view_colaborador/colaborador/cmb_datos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Asignar_Documento_Colaborador(){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador']=$this->input->post("id_colaborador");
            $dato['id_documento']=$this->input->post("id_documento");
            $dato['id_empresa']=$this->input->post("id_empresa");
            $dato['id_sede']=$this->input->post("id_sede");
            $dato['id_anio']=$this->input->post("id_anio_i");
            $this->Model_Colaborador->insert_documento_todos_colab($dato);
        }else{
            redirect('/login');
        } 
    }

    /*---------Cargo-Fotocheck----------*/

    public function Cargo_Fotocheck($id_sede){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_Colaborador->get_id_sede($id_sede);
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_nav_sede'] = $this->Model_Colaborador->get_list_nav_sede($dato['get_id'][0]['id_empresa']);

            if($dato['get_id'][0]['id_empresa']=='1'){
                $dato['contador_renovar'] = $this->Admin_model->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Admin_model->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'Admin';
            }elseif($dato['get_id'][0]['id_empresa']=='2'){
                $dato['vista'] = 'view_LL';
            }elseif($dato['get_id'][0]['id_empresa']=='3'){
                $dato['vista'] = 'view_BL';
            }elseif($dato['get_id'][0]['id_empresa']=='4'){
                $dato['vista'] = 'view_LS';
            }else if($dato['get_id'][0]['id_empresa']=='6'){
                $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);
                $dato['cierres_caja_pendientes'] = count($this->Model_IFV->get_cierres_caja_pendientes());
                $dato['cierres_caja_sin_cofre'] = count($this->Model_IFV->get_cierres_caja_sin_cofre());
                $dato['contador_renovar'] = $this->Model_IFV->get_busqueda_centro_contadores(1);
                $dato['contador_caducado'] = $this->Model_IFV->get_busqueda_centro_contadores(2);
                $dato['vista'] = 'view_IFV';
            }else if($dato['get_id'][0]['id_empresa']=='11'){
                $dato['vista'] = 'view_CC';
            }

            $this->load->view('view_colaborador/cargo_fotocheck_colaborador/index',$dato);
        }
    }

    public function Lista_Cargo_Fotocheck_Colaborador() {
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $dato['list_cargo_fotocheck'] = $this->Model_Colaborador->get_list_cargo_fotocheck($dato,1);
            $this->load->view('view_colaborador/cargo_fotocheck_colaborador/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Insert_Cargo_Fotocheck_Colaborador($id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $id_sede;
            $dato['list_estado'] = $this->Model_Colaborador->get_list_estado();
            $this->load->view('view_colaborador/cargo_fotocheck_colaborador/modal_registrar', $dato);
        }else{
            redirect('/login');
        }
    }


    public function Insert_Cargo_Fotocheck_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_sede']= $this->input->post("id_sede_i");
            $get_id = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['id_empresa'] = $get_id[0]['id_empresa'];
            $dato['estado']= $this->input->post("estado_i");
            $dato['nom_cf']= $this->input->post("nom_cf_i");

            $total=count($this->Model_Colaborador->valida_cargo_fotocheck_colaborador($dato,1));

            if($total>0){
                echo "error";
            }else{
                $this->Model_Colaborador->insert_cargo_fotocheck_colaborador($dato);
            }
        }else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Cargo_Fotocheck_Colaborador($id_cf){
        if ($this->session->userdata('usuario')) {
            $dato['id_cf']=$id_cf;
            $dato['list_estado'] = $this->Model_Colaborador->get_list_estado();
            $dato['get_id'] = $this->Model_Colaborador->get_list_cargo_fotocheck($dato,2);
            $this->load->view('view_colaborador/cargo_fotocheck_colaborador/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Cargo_Fotocheck_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cf']= $this->input->post("id_cf");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $get_id = $this->Model_Colaborador->get_id_sede($dato['id_sede']);
            $dato['id_empresa'] = $get_id[0]['id_empresa'];
            $dato['estado']= $this->input->post("estado_u");
            $dato['nom_cf']= $this->input->post("nom_cf_u");

            $total=count($this->Model_Colaborador->valida_cargo_fotocheck_colaborador($dato,2));

            if($total>0){
                echo "error";
            }else{
                $this->Model_Colaborador->update_cargo_fotocheck_colaborador($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Cargo_Fotocheck_Colaborador()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_cf'] = $this->input->post("id_cf");
            $this->Model_Colaborador->delete_cargo_fotocheck_colaborador($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Cargos_Fotocheck_Colaborador($id_sede){
        $dato['id_sede']=$id_sede;
        $list_cargos_fotocheck = $this->Model_Colaborador->get_list_cargo_fotocheck($dato,1);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:C2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:C2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cargo Fotocheck');

        $sheet->setAutoFilter('B2:C2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);

        $sheet->getStyle('B2:C2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:C2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("B2:C2")->applyFromArray($styleThinBlackBorderOutline);
          

        $sheet->setCellValue("B2", 'Nombre');;
        $sheet->setCellValue("C2", 'Estado');

        $contador=2;
        
        foreach($list_cargos_fotocheck as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            /*$sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);*/
            $sheet->getStyle("B{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['nom_cf']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cargo Fotocheck (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
    
}