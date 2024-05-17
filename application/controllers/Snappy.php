<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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

class Snappy extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_snappy');
        $this->load->model('Model_General');
        $this->load->model('Model_IFVS');
        $this->load->model('Admin_model');
        $this->load->library(array('session'));
        $this->load->helper('download');
        $this->load->helper(array('url'));
        $this->load->helper('form');
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
            //$data['fondo'] = $this->Model_snappy->get_confg_fondo();
            $dato['fondo'] = $this->Model_snappy->get_fondo_snappy();
            $this->Model_IFVS->actu_estado_examen_ifv();
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            //$dato['anio'] = $this->Papeletas_Detalle->get_anio();
            /*$dato['anios'] = $this->Papeletas_Detalle->get_anio();
            $dato['dependecia'] = $this->Papeletas_Detalle->get_dependencia();
            $dato['firmadigital'] = $this->Papeletas_Detalle->firma_digital();
            $dato['origen_horas'] = $this->Papeletas_Detalle->origen_horas();

            $coddep= $_SESSION['usuario'][0]['CODI_DEPE_TDE'];
            $dato['caso'] = $this->Papeletas_Detalle->get_caso($coddep);
            $des_caso=$this->Papeletas_Detalle->get_caso($coddep);
            $dato['nivel'] = $this->Papeletas_Detalle->get_nivel($des_caso);
            */
            //$this->load->view('Reportes/Papeletas_Detalle_Per',$dato);
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $dato['get_pendiente'] = $this->Model_snappy->consulta_confirmacion_pendiente();
            $dato['alerta_cargo'] = $this->Model_snappy->get_alerta_cargo();
            $dato['alerta_cierre_caja'] = $this->Model_snappy->get_alerta_cierre_caja();
            $_SESSION['foto']=$dato['get_id'][0]['foto'];

            $this->load->view('Admin/administrador/index',$dato);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Alerta(){ 
        if ($this->session->userdata('usuario')) {

            $dato['fondo'] = $this->Model_snappy->get_fondo_snappy();
            $this->Model_IFVS->actu_estado_examen_ifv();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $dato['get_pendiente'] = $this->Model_snappy->consulta_confirmacion_pendiente();
            $dato['alerta_cargo'] = $this->Model_snappy->get_alerta_cargo();
            $dato['alerta_cierre_caja'] = $this->Model_snappy->get_alerta_cierre_caja();
            $_SESSION['foto']=$dato['get_id'][0]['foto'];

            $this->load->view('Admin/administrador/index_alerta',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Detalle_Aviso() {
        if ($this->session->userdata('usuario')) { 
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('Admin/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Cambiar_clave() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $id_user=  $_SESSION['usuario'][0]['id_usuario'];  
        $dato['camb_clave'] = $this->Model_snappy->get_camb_clave($id_user);
        $this->load->view('Admin/clave/index',$dato);
    }

    function Update_clave(){
        $dato['usuario_password']=$this->input->post("usuario_password");
        $password=$this->input->post("usuario_password");
        $dato['user_password_hash']= password_hash($password, PASSWORD_DEFAULT);

        $dato['id_usuario']= $this->input->post("id_usuario");  
        $this->Model_snappy->update_clave($dato);

        //redirect('Snappy/index');
    }

    public function configuracion() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['confg_foto'] = $this->Model_snappy->get_confg_foto();

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $this->load->view('configuracion/index',$dato);
    }

    public function Agenda() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_agenda'] = $this->Model_snappy->get_list_agenda(); 
        $dato['list_empresa_proyecto'] = $this->Model_snappy->get_list_empresa_agenda();

        //AVISO NO BORRAR
        $dato['valida_estilo']=1;
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/agenda/index',$dato);
    }
    
    public function Redes() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_duplicado'] = $this->Model_snappy->get_redes_duplicados();
        //$dato['list_redes'] = $this->Model_snappy->get_list_redes();
        $dato['list_empresa_proyecto'] = $this->Model_General->list_empresa_proyecto();

        //$dato['combo_empresa'] = $this->Model_General->list_empresa();

        $dato['anio'] = $this->Model_snappy->anios_calendar_redes();

        if($_SESSION['usuario'][0]['id_nivel']!="1" && $_SESSION['usuario'][0]['id_nivel']!="6" && $_SESSION['usuario'][0]['id_nivel']!="7"){
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

            $result="";

            foreach($dato['list_empresa'] as $char){
                $result.= $char['id_empresa'].",";
            }
            $cadena = substr($result, 0, -1);
            
            $dato['cadena'] = "(".$cadena.")";

            $dato['combo_empresa'] = $this->Model_snappy->list_empresa_in($dato);

            $dato['list_redes'] = $this->Model_snappy->get_list_redes_in($dato); 
            
        }else{
            $dato['combo_empresa'] = $this->Model_snappy->get_list_iempresa();

            $dato['list_redes'] = $this->Model_snappy->get_list_redes();  
            
        }
        //AVISO NO BORRAR
        $dato['valida_estilo']=1;
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/redes/index',$dato);
    }

    public function Descargar_Imagen($id_proyecto){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_snappy->get_id_proyecto($id_proyecto);

            $imagen = $get_id[0]['imagen'];

            $this->load->helper('download');

            force_download($imagen,NULL);
        }else{
            redirect('');
        }
    }

    public function Excel_Vacio_Redes(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel Vacío Redes');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(80);

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:B1")->getFill()
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

        $sheet->getStyle("A1:B1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle("A2:B3")->getFont()->getColor()->setRGB('FF0000');

        $sheet->setCellValue("A1", 'Código');           
        $sheet->setCellValue("B1", 'Copy');

        $sheet->setCellValue("A2", '123456');           
        $sheet->setCellValue("B2", 'Copy 123456');

        $sheet->setCellValue("A3", '654321');           
        $sheet->setCellValue("B3", 'Copy 654321');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel Vacío Redes';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Validar_Importar_Redes() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   

            $path = $_FILES["archivo_excel"]["tmp_name"]; 
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['cod_proyecto'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['copy'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    if($dato['cod_proyecto']=="" && $dato['copy']==""){
                        break;
                    }

                    $valida = $this->Model_snappy->buscar_proyecto($dato['cod_proyecto']);

                    $dato['v_cod_proyecto']=0;
                    $dato['v_copy']=0;

                    if(count($valida)==0){
                        $dato['v_cod_proyecto']=1;
                    }
                    if($dato['copy']==""){
                        $dato['v_copy']=1;
                    }

                    $this->Model_snappy->insert_temporal_redes($dato); 
                }
            //}

            $correctos=count($this->Model_snappy->get_list_temporal_redes_correcto());
            $errores=$this->Model_snappy->get_list_temporal_redes($dato); 

            if($correctos==count($errores)){
                $dato['archivo_excel']= $this->input->post("archivo_excel");   

                $path = $_FILES["archivo_excel"]["tmp_name"];
                $object = IOFactory::load($path);
                $worksheet = $object->getSheet(0);
                //foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['cod_proyecto'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $dato['copy'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                        if($dato['cod_proyecto']=="" && $dato['copy']==""){
                            break;
                        }
    
                        $valida = $this->Model_snappy->buscar_proyecto($dato['cod_proyecto']);
                        $dato['id_proyecto'] = $valida[0]['id_proyecto'];
    
                        $this->Model_snappy->update_proyecto_copy($dato); 
                    }
                //}
                
            }else{
                $fila=2;

                foreach($errores as $list){
                    if($list['cod_proyecto']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Código válido!</p>";
                    }
                    if($list['copy']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Copy válido!</p>";
                    }
    
                    $fila++;
                }
    
                if($correctos>0){
                    echo "*CORRECTO";
                }else{
                    echo "*INCORRECTO";
                }
            }

            $this->Model_snappy->delete_temporal_proyecto();

        }else{
            redirect('/login');
        }
    }
 
    public function Importar_Redes() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   
            
            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['cod_proyecto'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['copy'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    if($dato['cod_proyecto']=="" && $dato['copy']==""){
                        break;
                    }

                    $valida = $this->Model_snappy->buscar_proyecto($dato['cod_proyecto']);
                    $dato['id_proyecto'] = $valida[0]['id_proyecto'];

                    if(count($valida)>0 && $dato['copy']!=""){
                        $this->Model_snappy->update_proyecto_copy($dato); 
                    }
                }
            //}
        }else{
            redirect('/login');
        }
    }
    //----------------------------------------------------------------------
    public function Empresa_config() {
        /**/if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_empresa_config'] = $this->Model_snappy->get_list_empresa_config();
        $this->load->view('Admin/configuracion/empresa/index',$dato);
    }

    public function Modal_Empresa_config(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/configuracion/empresa/modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }



    public function Insert_Empresa_config(){
        $dato['nom_empresa']= $this->input->post("nom_empresa"); 
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['logo_color']= $this->input->post("logo_color");
        $dato['logo_bn']= $this->input->post("logo_bn");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->insert_empresa_config($dato);

        //redirect('Snappy/Empresa_config');  
    }

    public function Update_Empresa_config(){
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['nom_empresa']= $this->input->post("nom_empresa");
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['logo_color']= $this->input->post("logo_color");
        $dato['logo_bn']= $this->input->post("logo_bn");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->update_empresa_config($dato);

        //redirect('Snappy/Empresa');  
    }


    public function Modal_Update_Empresa_config($id_empresa){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_empresa_config($id_empresa);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/configuracion/empresa/upd_modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Usuario_config() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_usuario'] = $this->Model_snappy->get_list_usuario_config();
    
        $this->load->view('Admin/configuracion/usuarios/index',$dato);
    }
    
    
    public function Modal_Usuario_config(){
        if ($this->session->userdata('usuario')) {
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/configuracion/usuarios/modal_usuario', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    
    public function Modal_Update_Usuario_config($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/configuracion/usuarios/upd_modal_usuario', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_Usuario_config(){
        $dato['id_nivel']= $this->input->post("id_nivel");
        $dato['SP']= $this->input->post("SP");
        $dato['GL']= $this->input->post("GL");
        $dato['EP']= $this->input->post("EP");
        $dato['usuario_apater']= $this->input->post("usuario_apater"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres");
        $dato['emailp']= $this->input->post("emailp");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones"); 
        $dato['fin_funciones']= $this->input->post("fin_funciones"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['usuario_codigo']= $this->input->post("usuario_codigo");
        $dato['usuario_password']= $this->input->post("usuario_password");
        $dato['artes']= $this->input->post("artes");
        $dato['redes']= $this->input->post("redes"); 
        $dato['observaciones']= $this->input->post("observaciones"); 

        $this->Model_snappy->insert_usuario_config($dato);
    
        redirect('Snappy/Usuario_config');  
    }


    public function Update_Usuario_config(){
        $dato['id_usuario']= $this->input->post("id_usuario");
        $dato['SP']= $this->input->post("SP");
        $dato['GL']= $this->input->post("GL");
        $dato['EP']= $this->input->post("EP");
        $dato['id_nivel']= $this->input->post("id_nivel");
        $dato['usuario_apater']= $this->input->post("usuario_apater"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres");
        $dato['emailp']= $this->input->post("emailp");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones"); 
        $dato['fin_funciones']= $this->input->post("fin_funciones"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['usuario_codigo']= $this->input->post("usuario_codigo");
        $dato['usuario_password']= $this->input->post("usuario_password");
        $dato['artes']= $this->input->post("artes");
        $dato['redes']= $this->input->post("redes"); 
        $dato['observaciones']= $this->input->post("observaciones"); 

        $this->Model_snappy->update_usuario_config($dato);
    
        redirect('Snappy/Usuario_config');  
    }


    //----------------------------------------------------------------------

    public function Empresa() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_empresa'] = $this->Model_snappy->get_list_empresa();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $this->load->view('Admin/empresa/index',$dato);
        /*
        //header('Content-Type: application/json');
        $data = $this->Model_snappy->get_list_empresa();
        //var_dump($data);
        //echo json_encode($data);
        $this->load->view('Admin/empresa/index', $data);*/
    }

    public function EmpresaJ() {
        header("Content-Type: application/json; charset=UTF-8");
        $dato= $this->input->get("callback"); 
        
        //$obj = json_decode($_GET["callback"], true);
        //$obj= json_decode($this->input->get("callback"), true);
        $data = $this->Model_snappy->get_list_empresa();
        //var_dump($data);
        echo $dato."(".json_encode($data).")";
    }

    public function Modal_Empresa(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/empresa/modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Modal_Update_Empresa($id_empresa){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_empresa($id_empresa);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/empresa/upd_modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_Empresa(){
        $dato['nom_empresa']= $this->input->post("nom_empresa"); 
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['color1_empresa']= $this->input->post("color1_empresa");
        $dato['color2_empresa']= $this->input->post("color2_empresa");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->insert_empresa($dato);

        redirect('Snappy/Empresa');  
    }

    public function Update_Empresa(){
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['nom_empresa']= $this->input->post("nom_empresa");
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['color1_empresa']= $this->input->post("color1_empresa");
        $dato['color2_empresa']= $this->input->post("color2_empresa");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->update_empresa($dato);

        redirect('Snappy/Empresa');  
    }

    public function Excel_Empresa(){
        $empresas = $this->Model_snappy->get_list_empresa();
        if(count($empresas) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Empresas');
            
	        //Contador de filas
            $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:F1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:F1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Empresa');	        
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Código');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Orden');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Observaciones');	        
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Rep. Redes');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Status');
	        //Definimos la data del cuerpo.
	        foreach($empresas as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
	        	$contador++;
	        	//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_empresa']);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['cod_empresa']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['orden_empresa']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['observaciones_empresa']);
		        $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['reporte']);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['nom_status']);
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Empresas.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
        }else{
        	echo 'No se han encontrado llamadas';
        	exit;
        }
	}

    public function Festivo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_festivo'] = $this->Model_snappy->get_list_festivo();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $this->load->view('Admin/festivo/index',$dato);
    }

    public function Modal_Festivo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] = $this->Model_snappy->get_list_empresa();
            $dato['list_tipo_festivo'] = $this->Model_snappy->get_list_tipo_festivo();
            $this->load->view('Admin/festivo/modal_festivo', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Festivo($id_calendar_festivo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_festivo($id_calendar_festivo);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_tipo_festivo'] = $this->Model_snappy->get_list_tipo_festivo();
            $this->load->view('Admin/festivo/upd_modal_festivo', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Festivo(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['inicio']= $this->input->post("inicio_i");
        $dato['fin']=$dato['inicio'];
        $dato['anio']= $this->input->post("anio_i");        
        $dato['mes']=substr($this->input->post("inicio_i"),5,2);
        $dato['dia']=substr($this->input->post("inicio_i"),8,2);
        $dato['iniciosf'] = strtotime($dato['inicio']);
        
        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $dato['id_tipo_fecha'] = $this->input->post("id_tipo_fecha_i"); 
        $dato['fijo_variable'] = $this->input->post("fijo_variable_i");
        $dato['observaciones'] = $this->input->post("observaciones_i");
        $dato['clases'] = $this->input->post("clases_i");
        $dato['laborable'] = $this->input->post("laborable_i");

        $dato['id_status'] = 2;
        $get_color = $this->Model_snappy->get_color_tipo_festivo($dato['id_tipo_fecha']);
        $dato['color'] = $get_color[0]['color'];

        $dato['ultimo'] = $this->Model_snappy->ultimoreg();
        $dato['id_ultimo'] = $dato['ultimo'][0]['id_calendar_festivo'] + 1;
        $empresas = $this->input->post("id_empresa_i");

        foreach ($empresas as $key => $value) {
            $dato['id_empresa'] = $value;

            if($dato['id_empresa']==1){
                $this->Model_snappy->insert_festivo($dato,1);
            }
            $this->Model_snappy->insert_festivo($dato,2);
        }

        if($dato['fijo_variable']==1){
            $i = 1;
            while($i<=2){
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

                $dato['anio'] = $dato['anio']+1;
                $array = explode("-",$dato['inicio']);
                $dato['inicio'] = $dato['anio']."-".$array['1']."-".$array[2];
                $dato['fin']=$dato['inicio'];
                $dato['mes']=substr($dato['inicio'],5,2);
                $dato['dia']=substr($dato['inicio'],8,2);
                $dato['iniciosf'] = strtotime($dato['inicio']);

                $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
                $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

                $dato['ultimo'] = $this->Model_snappy->ultimoreg();
                $dato['id_ultimo'] = $dato['ultimo'][0]['id_calendar_festivo'] + 1;

                foreach ($empresas as $key => $value) {
                    $dato['id_empresa'] = $value;
        
                    if($dato['id_empresa']==1){
                        $this->Model_snappy->insert_festivo($dato,1);
                    }
                    $this->Model_snappy->insert_festivo($dato,2);
                }

                $i++;
            }
        }
    }

    public function Update_Festivo(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $dato['id_calendar_festivo']= $this->input->post("id_calendar_festivo");
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['inicio']= $this->input->post("inicio_u");
        $dato['fin']=$dato['inicio'];
        $dato['anio']= $this->input->post("anio_u");        
        $dato['mes']=substr($this->input->post("inicio_u"),5,2);
        $dato['dia']=substr($this->input->post("inicio_u"),8,2);
        $dato['iniciosf'] = strtotime($dato['inicio']);
        
        
        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $dato['id_tipo_fecha'] = $this->input->post("id_tipo_fecha_u"); 
        $dato['fijo_variable'] = $this->input->post("fijo_variable_u");
        $dato['observaciones'] = $this->input->post("observaciones_u");
        $dato['clases'] = $this->input->post("clases_u");
        $dato['laborable'] = $this->input->post("laborable_u");
        $dato['id_status'] = $this->input->post("id_status_u");
        $get_color = $this->Model_snappy->get_color_tipo_festivo($dato['id_tipo_fecha']);
        $dato['color'] = $get_color[0]['color'];

        $this->Model_snappy->update_festivo($dato);
    }

    public function Tipo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/tipo/index',$dato);
    }

    public function Modal_tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/tipo/modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Tipo($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_tipo($id_tipo);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/tipo/upd_modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Tipo(){
        $dato['nom_tipo']= $this->input->post("nom_tipo");
        $dato['abr_tipo']= $this->input->post("abr_tipo");
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Model_snappy->insert_tipo($dato);
    }
    
    public function Update_Tipo(){
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_tipo']= $this->input->post("nom_tipo");
        $dato['abr_tipo']= $this->input->post("abr_tipo");
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Model_snappy->update_tipo($dato);
    }

    public function Excel_Tipo(){
        $tipo = $this->Model_snappy->get_list_tipos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tipo');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(15);

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:C1")->getFill()
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

        $sheet->getStyle("A1:C1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Abreviatura');	        
        $sheet->setCellValue("B1", 'Tipo');
        $sheet->setCellValue("C1", 'Status');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['abr_tipo']);
            $sheet->setCellValue("B{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tipo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Subtipo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_subtipo'] = $this->Model_snappy->get_list_subtipo();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
    
        $this->load->view('Admin/subtipo/index',$dato);
    }

    public function Modal_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
            $dato['combo_empresa'] = $this->Model_General->list_empresa();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/subtipo/modal_subtipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Subtipo($id_subtipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_subtipo($id_subtipo);
            $dato['combo_empresa'] = $this->Model_General->list_empresa();
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/subtipo/upd_modal_subtipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo']= $this->input->post("id_tipo");
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['nom_subtipo']= $this->input->post("nom_subtipo"); 
            $dato['tipo_subtipo_arte']= $this->input->post("tipo_subtipo_arte");
            $dato['tipo_subtipo_redes']= $this->input->post("tipo_subtipo_redes"); 
            $dato['id_status']= $this->input->post("id_status"); 
            $dato['rep_redes']= $this->input->post("rep_redes"); 
            $this->Model_snappy->insert_subtipo($dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_subtipo']= $this->input->post("id_subtipo"); 
            $dato['id_tipo']= $this->input->post("id_tipo");
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['nom_subtipo']= $this->input->post("nom_subtipo"); 
            $dato['tipo_subtipo_arte']= $this->input->post("tipo_subtipo_arte");
            $dato['tipo_subtipo_redes']= $this->input->post("tipo_subtipo_redes"); 
            $dato['id_status']= $this->input->post("id_status"); 
            $dato['rep_redes']= $this->input->post("rep_redes"); 
            $this->Model_snappy->update_subtipo($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Subtipo(){
        $subtipo = $this->Model_snappy->get_list_subtipo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Tipos');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

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

        $sheet->setCellValue("A1", 'Tipo');	        
        $sheet->setCellValue("B1", 'Sub-Tipo');
        $sheet->setCellValue("C1", 'Empresa');
        $sheet->setCellValue("D1", "Snappy's");
        $sheet->setCellValue("E1", 'Redes');	        
        $sheet->setCellValue("F1", 'Rep. Redes');
        $sheet->setCellValue("G1", 'Estado');

        $contador=1;
        
        foreach($subtipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("B{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("C{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("D{$contador}", $list['tipo_subtipo_arte']);
            $sheet->setCellValue("E{$contador}", $list['tipo_subtipo_redes']);
            $sheet->setCellValue("F{$contador}", $list['reporte']);
            $sheet->setCellValue("G{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Subtipo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
    public function Usuario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_usuario'] = $this->Model_snappy->get_list_usuario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
    
        $this->load->view('Admin/usuarios/index',$dato);
    }
    
    
    public function Modal_Usuario(){
        if ($this->session->userdata('usuario')) {
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/usuarios/modal_usuario', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    
    public function Modal_Update_Usuario($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_usuario($id_usuario);
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/usuarios/upd_modal_usuario', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

        
    public function Insert_Usuario(){
        $dato['id_nivel']= $this->input->post("id_nivel"); 
        $dato['usuario_apater']= $this->input->post("usuario_apater"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres");
        $dato['emailp']= $this->input->post("emailp");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones"); 
        $dato['fin_funciones']= $this->input->post("fin_funciones"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['usuario_codigo']= $this->input->post("usuario_codigo");

        $password=$this->input->post("usuario_password");
        $dato['usuario_password']= password_hash($password, PASSWORD_DEFAULT);

        $dato['artes']= $this->input->post("artes");
        $dato['redes']= $this->input->post("redes"); 
        $dato['observaciones']= $this->input->post("observaciones"); 

        $this->Model_snappy->insert_usuario($dato);
    
        redirect('Snappy/Usuario');  
    }


    public function Update_Usuario(){
        $dato['id_usuario']= $this->input->post("id_usuario");
        $dato['id_nivel']= $this->input->post("id_nivel");
        $dato['usuario_apater']= $this->input->post("usuario_apater"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres");
        $dato['emailp']= $this->input->post("emailp");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones"); 
        $dato['fin_funciones']= $this->input->post("fin_funciones"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['usuario_codigo']= $this->input->post("usuario_codigo");
        /*$dato['usuario_password']= $this->input->post("usuario_password");*/

        $password=$this->input->post("usuario_password");
        $dato['usuario_password']= password_hash($password, PASSWORD_DEFAULT);

        $dato['artes']= $this->input->post("artes");
        $dato['redes']= $this->input->post("redes"); 
        $dato['observaciones']= $this->input->post("observaciones"); 

        $this->Model_snappy->update_usuario($dato);
    
        redirect('Snappy/Usuario');  
    }
    public function Excel_Usuario(){
        $festivo = $this->Model_snappy->get_list_usuario();
        if(count($festivo) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Usuarios');
            
	        //Contador de filas
            $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:K1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:K1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Usuario');	        
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Código');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Apellido(s) Materno');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Apellido(s) Paterno');	        
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Nombres');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Perfil');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Codigo GL');
            $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Inicio de Funciones');
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Termino de Funciones');
            $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Ultimo Ingreso');
            $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Estado');

	        //Definimos la data del cuerpo.
	        foreach($festivo as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
	        	$contador++;
	        	//Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['usuario_codigo']);	        
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['codigo']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['usuario_amater']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['usuario_apater']);	        
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['usuario_nombres']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['nom_nivel']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['codigo_gllg']);
                $this->excel->getActiveSheet()->setCellValue("H{$contador}", $list['ini_funciones']);
                $this->excel->getActiveSheet()->setCellValue("I{$contador}", $list['fin_funciones']);
                $this->excel->getActiveSheet()->setCellValue("J{$contador}", $list['fec_ingreso']);
                $this->excel->getActiveSheet()->setCellValue("K{$contador}", $list['nom_status']);
            }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Usuarios.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
        }else{
        	echo 'No se han encontrado llamadas';
        	exit;
        }
    }
    public function modal_img(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('configuracion/modal_img');   
        }
        else{
            redirect('/login');
        }
    }

    public function update_img($id_intranet){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_intranet($id_intranet);
            $this->load->view('configuracion/upd_modal_img',$dato);   
        }
        else{
            redirect('/login');
        }
    
    }
    
    public function Insert_fondo(){
        $dato['foto']= $this->input->post("productImage"); 
        $dato['nom_fintranet']= $this->input->post("nom_fintranet");  

        $this->Model_snappy->insert_fondo($dato);

        redirect('Snappy/configuracion');  
    }

    public function Excel_Fondo(){
        $fondo = $this->Model_snappy->get_confg_foto();
        if(count($fondo) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Fondos Snappy');
            
	        //Contador de filas
            $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:A1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'TITULO FONDO');
	        //Definimos la data del cuerpo.
	        foreach($fondo as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
	        	$contador++;
	        	//Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_fintranet']);
            }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Fondos.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
        }else{
        	echo 'No se han encontrado llamadas';
        	exit;
        }
    }

    function eliminarfoto() {
        $data['user_act'] =$_SESSION['usuario'][0]['id_usuario'];
        
        $data['id_fintranet'] = $this->input->post("id");
        $data['estado'] = $this->input->post("estado");

        $dato['id_empresa'] = $this->input->post("id_empresa");

        if($data['estado']==1){
            $this->Model_General->update_fondo_usado($dato);
            $this->Model_snappy->eliminar_foto($data);
        }else{
            $this->Model_snappy->eliminar_foto($data);
        }
    }

    public function update_foto(){
        $dato['nom_fintranet']= $this->input->post("nom_fintranet"); 
        $dato['foto']= $this->input->post("actuimagen"); 
        $dato['id_fintranet']= $this->input->post("id_fintranet"); 
        $this->Model_snappy->update_foto($dato);
        redirect('Snappy/configuracion');  
    }

    public function Busqueda() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['anio']=date('Y');
        $dato['list_anio'] =$this->Model_snappy->get_list_anio();
        $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
    
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/informe/busqueda/index',$dato);
    }

    public function delete_file_cache(){
        $this->output->delete_cache('cachecontroller');
    }

    public function Buscador_Anio() {
        if ($this->session->userdata('usuario')) { 
            $dato['anio'] = $this->input->post("anio");
            $dato['id_empresa'] = $this->input->post("id_empresa");
            $dato['list_proyecto'] = $this->Model_snappy->get_list_proyecto_busqueda($dato);
            $this->load->view('Admin/informe/busqueda/busqueda',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Editar_proyect($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['row_t'] =$this->Model_snappy->get_row_ts();
            $dato['get_id'] = $this->Model_snappy->get_id_proyecto($id_proyecto);
            $dato['list_duplicado'] = $this->Admin_model->get_list_duplicados($dato['get_id'][0]['id_proyecto']);
            $dato['row_s'] = $this->Model_snappy->get_row_s();
            $dato['usuario_subtipo'] = $this->Model_snappy->get_usuario_subtipo();
            $dato['usuario_subtipo1'] = $this->Model_snappy->get_usuario_subtipo1();
            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
            $dato['id_tipo']=$dato['get_id'][0]['id_tipo'];
            $dato['empresas']=$dato['get_id'][0]['id_empresa'];

            $id_subtipo=$dato['get_id'][0]['id_subtipo'];
            if($id_subtipo!=0){
                $dato['get_subtipo'] = $this->Model_snappy->get_id_subtipo($id_subtipo);
                if($dato['get_subtipo'][0]['estado']!=2){
                    $dato['subtipo']="and (estado=2 || id_subtipo=".$dato['get_subtipo'][0]['id_subtipo'].")";
                }else{
                    $dato['subtipo']="and estado=2";
                }
            }else{
                $dato['subtipo']="and estado=2"; 
            }
            
            $id_usuario=$dato['get_id'][0]['id_solicitante'];
            if($id_usuario!=0){
                $dato['get_id_u'] = $this->Model_snappy->get_id_usuario($id_usuario);
                if($dato['get_id_u'][0]['estado']!=2){
                    $dato['soli']="and (estado=2 || id_usuario=".$dato['get_id_u'][0]['id_usuario'].")";
                }else{
                    $dato['soli']="and estado=2";
                }
            }else{
                $dato['soli']="and estado=2";
            }
            
            $dato['solicitado'] =$this->Model_snappy->get_solicitante_c_historico($dato);
            $dato['sub_tipo'] = $this->Model_snappy->list_subtipo_fbweb_activos($dato);
            $dato['list_sede'] = $this->Model_snappy->get_list_empresa_sede_uno($dato);
            $dato['get_sede'] = $this->Model_snappy->get_id_sede_proyecto($id_proyecto);

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
        
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('Admin/informe/busqueda/editar_proyect',$dato);
        }
        else{
            redirect('/login');
        }

    }

    public function Excel_Lista_Proyecto($anio, $id_empresa){ 
        $dato['anio']=$anio;
        $dato['id_empresa']=$id_empresa;
        $dato['mes']="00";

        $busqueda = $this->Model_snappy->get_list_proyecto_busqueda($dato);
        //$busqueda = $this->Model_snappy->excel_list_proyecto_busqueda();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('DComunicacion (lista)');
        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);

        $sheet->getStyle('A1:Q1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:Q1")->getFill()
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

        $sheet->getStyle("A1:Q1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Prioridad');	        
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'M/D');
        $sheet->setCellValue("D1", 'Status');
        $sheet->setCellValue("E1", 'Empresa(s)');
        $sheet->setCellValue("F1", 'Sede(s)');	        
        $sheet->setCellValue("G1", 'Tipo');
        $sheet->setCellValue("H1", 'SubTipo');	        
        $sheet->setCellValue("I1", 'Descripción');
        $sheet->setCellValue("J1", 'Snappys');
        $sheet->setCellValue("K1", 'Agenda');	        
        $sheet->setCellValue("L1", 'Usuario');
        $sheet->setCellValue("M1", 'Fecha');
        $sheet->setCellValue("N1", 'Usuario');
        $sheet->setCellValue("O1", 'Fecha');
        $sheet->setCellValue("P1", 'Subido');
        $sheet->setCellValue("Q1", 'Imagen');
        $contador=1;

        foreach($busqueda as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['prioridad']);            
            $sheet->setCellValue("B{$contador}", $list['cod_proyecto']);
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);

            if($list['duplicado']==1){
                $sheet->setCellValue("C{$contador}", "D");
            }else{
                $sheet->setCellValue("C{$contador}", "M");
            }
            $sheet->setCellValue("D{$contador}", $list['nom_statusp']);
            $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("F{$contador}", $list['cod_sede']);
            $sheet->setCellValue("G{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("H{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("I{$contador}", $list['descripcion']);
            $sheet->setCellValue("J{$contador}", ($list['s_artes']+$list['s_redes']));

            if($list['duplicado']>0){
                $sheet->setCellValue("K{$contador}",  Date::PHPToExcel($list['fec_agenda']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            }else{
                if($list['fec_agenda']!="00/00/0000"){
                    $sheet->setCellValue("K{$contador}",  Date::PHPToExcel($list['fec_agenda']));
                    $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("L{$contador}", "");
                }
            }

            $sheet->setCellValue("L{$contador}", $list['ucodigo_solicitado']);

            if($list['fec_solicitante']!="00/00/0000"){
                $sheet->setCellValue("M{$contador}",  Date::PHPToExcel($list['fec_solicitante']));
                $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            }else{
                $sheet->setCellValue("M{$contador}", "");
            } 

            $sheet->setCellValue("N{$contador}", $list['ucodigo_asignado']);

            if($list['fec_termino']!="00/00/0000 00:00:00"){
                $sheet->setCellValue("O{$contador}",  Date::PHPToExcel($list['fec_termino']) );
                $sheet->getStyle("O{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            }else{
                $sheet->setCellValue("O{$contador}", "");
            }

            $subido = 'No';
            if($list['subido'] == 1){$subido = 'Si';}
            $sheet->setCellValue("P{$contador}", $subido);
            
            $sheet->setCellValue("Q{$contador}", $list['s_imagen']);
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'DComunicacion (lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); 
    }

    public function Redes_Mensual() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
        if($id_nivel==1 || $id_nivel==2 || $id_nivel==3 || $id_nivel==4 || $id_nivel==6 || $id_nivel==12){
            $dato['list_empresam'] = $this->Model_snappy->get_list_iempresa();
        }elseif($id_nivel==7){
            $dato['list_empresam'] = $this->Model_snappy->get_list_iempresa($id_nivel);
        }

        $dato['list_meses'] = $this->Model_snappy->get_list_meses();
        $dato['list_anios'] = $this->Model_snappy->get_list_anio();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/informe/redes/index',$dato);
    }

    public function Estado_Snappy() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_proyecto'] = $this->Model_snappy->get_list_proyecto();
        $dato['list_empresam'] = $this->Model_General->list_empresa_proyecto();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
    
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/informe/estado_snappy/index',$dato);
    }

    public function Mostrar_Todo_Estado_Snappy() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['condicion']= $this->input->post("condicion"); 

        if($dato['condicion']=="todo"){
            $dato['cant_tabla'] = count($this->Model_snappy->get_list_proyecto());
        }else{
            $dato['cant_tabla'] = 21;
        }

        $dato['list_proyecto'] = $this->Model_snappy->get_list_proyecto();
        $dato['list_empresam'] =$this->Model_General->list_empresa_proyecto();
        
        $this->load->view('Admin/informe/estado_snappy/mostrar_todo',$dato);
    }

    public function archivar(){
        $cadena = $this->input->post("cadena"); 
        $prueba = $this->input->post("prueba"); 

        if($prueba!=""){
            foreach($_POST['proyecto'] as $proyecto){
                $data['id_proyecto']=$proyecto;
                $this->Model_snappy->archivar_proyect($data);
            }
        }else{
            $codigo_proyectos = substr($cadena, 0, -1);
            $proyectos = explode(",", $codigo_proyectos);
            foreach($proyectos as $list){
                $get_id=$this->Model_snappy->get_id_cod_proyecto($list);
                $data['id_proyecto'] = $get_id[0]['id_proyecto'];
                $this->Model_snappy->archivar_proyect($data);
            }

        }
        

        redirect('Snappy/Estado_Snappy');
    } 

     public function Buscar_snappy(){
        $busqueda= $this->input->post('busqueda');
        $dato['list_proyecto'] = $this->Model_snappy->get_busqueda_proyecto($busqueda);
        $this->load->view('Admin/informe/estado_snappy/Busqueda', $dato);
    }

    public function Excel_snappy(){
        $subtipo = $this->Model_snappy->get_list_proyecto();
        $list_empresam =$this->Model_General->list_empresa_proyecto();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Estado Snappy');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:L1")->getFill()
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

        $sheet->getStyle("A1:L1")->applyFromArray($styleThinBlackBorderOutline);

        $contador=1;

        $sheet->setCellValue("A{$contador}", 'Código');           
        $sheet->setCellValue("B{$contador}", 'Status');
        $sheet->setCellValue("C{$contador}", 'Empresa');
        $sheet->setCellValue("D{$contador}", 'Tipo');
        $sheet->setCellValue("E{$contador}", 'Subtipo');          
        $sheet->setCellValue("F{$contador}", 'Descripción');
        $sheet->setCellValue("G{$contador}", 'Snappys');
        $sheet->setCellValue("H{$contador}", 'Agenda');
        $sheet->setCellValue("I{$contador}", 'Usuario');
        $sheet->setCellValue("J{$contador}", 'Fecha');
        $sheet->setCellValue("K{$contador}", 'Usuario');
        $sheet->setCellValue("L{$contador}", 'Fecha');

        foreach($subtipo as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_proyecto']);
            $sheet->setCellValue("B{$contador}", $list['nom_statusp']);
            
            $empresa="";
            foreach($list_empresam as $emp){
                if($emp['id_proyecto']==$list['id_proyecto']){
                    $empresa=$empresa.$emp['cod_empresa'].",";
                }
            }

            $sheet->setCellValue("C{$contador}", substr($empresa,0,-1));
            $sheet->setCellValue("D{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("E{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("F{$contador}", $list['descripcion']);
            $sheet->setCellValue("G{$contador}", $list['s_artes']+$list['s_redes']);

            if($list['fec_agenda']=="0000-00-00"){
                $sheet->setCellValue("H{$contador}", "");
            }else{
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_agenda']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            $sheet->setCellValue("I{$contador}", $list['ucodigo_solicitado']);

            if($list['fec_solicitante']=="0000-00-00"){
                $sheet->setCellValue("J{$contador}", "");
            }else{
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fec_solicitante']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            $sheet->setCellValue("K{$contador}", $list['ucodigo_asignado']);

            if($list['fec_termino']=="0000-00-00 00:00:00"){
                $sheet->setCellValue("L{$contador}", "");
            }else{
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fec_termino']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Estado Snappy (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }


    public function imagen(){
        if ($this->session->userdata('usuario')) {
            $data['row_p'] =$this->Model_snappy->get_row_p();

            
            //AVISO NO BORRAR
            $data['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $data['list_aviso'] = $this->Model_General->get_list_aviso();

            /*$nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $data['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $data['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $data['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $data['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);*/

            //$data['row_t'] =$this->Admin_model->get_row_t();
            $this->load->view('Admin/administrador/cimagen/modal_img',$data);
        }
        else{
            redirect('/login');
        }
    }

    public function actualizar(){
        foreach($_POST['proyecto'] as $proyecto){
          //echo $grado."<br>";
          $data['id_proyecto'] = $proyecto;
           $this->Model_snappy->archivar_proyect($data);
         }
          redirect('Snappy/Estado_Snappy');

     } 

     public function actualizar_img(){
        $dato['foto']= $this->input->post("foto"); 
        $dato['id_usuario']= $this->input->post("id_usuario");  
        $this->Model_snappy->actualizar_img($dato);
        $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($dato['id_usuario']);
        $_SESSION['foto']=$dato['get_id'][0]['foto'];
    }

    public function Reporte_mensual(){
        $dato['id_empresa']= $this->input->post('id_empresa');
        $dato['nom_anio']= $this->input->post('nom_anio');
        $dato['id_mes']= $this->input->post('id_mes');

        $this->load->view('Admin/informe/redes/lista',$dato);
    }

    public function Excel_Reporte_Mensual($id_empresa,$nom_anio,$id_mes){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anio= $nom_anio;
        $dato['id_empresa'] = $id_empresa;
        $row_t = $this->Model_snappy->get_row_t($dato);
        $totalRows_t = count($row_t);

        $dia1 = strtotime($anio.'-'.$id_mes.'-01');
        $nom_mes=substr($meses[date('n', $dia1)-1],0,3);

        if($totalRows_t<1){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->setTitle('Reporte Mensual Redes');
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->setCellValue("A1", "No existen registros para mostrar");  
        }else{
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:AG2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:AG2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Reporte Mensual Redes');

            //$sheet->setAutoFilter('A1:AG1');
    
            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(8);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(8);
            $sheet->getColumnDimension('H')->setWidth(8);
            $sheet->getColumnDimension('I')->setWidth(8);
            $sheet->getColumnDimension('J')->setWidth(8);
            $sheet->getColumnDimension('K')->setWidth(8);
            $sheet->getColumnDimension('L')->setWidth(8);
            $sheet->getColumnDimension('M')->setWidth(8);
            $sheet->getColumnDimension('N')->setWidth(8);
            $sheet->getColumnDimension('O')->setWidth(8);
            $sheet->getColumnDimension('P')->setWidth(8);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(8);
            $sheet->getColumnDimension('S')->setWidth(8);
            $sheet->getColumnDimension('T')->setWidth(8);
            $sheet->getColumnDimension('U')->setWidth(8);
            $sheet->getColumnDimension('V')->setWidth(8);
            $sheet->getColumnDimension('W')->setWidth(8);
            $sheet->getColumnDimension('X')->setWidth(8);
            $sheet->getColumnDimension('Y')->setWidth(8);
            $sheet->getColumnDimension('Z')->setWidth(8);
            $sheet->getColumnDimension('AA')->setWidth(8);
            $sheet->getColumnDimension('AB')->setWidth(8);
            $sheet->getColumnDimension('AC')->setWidth(8);
            $sheet->getColumnDimension('AD')->setWidth(8);
            $sheet->getColumnDimension('AE')->setWidth(8);
            $sheet->getColumnDimension('AF')->setWidth(8);
            $sheet->getColumnDimension('AG')->setWidth(8);

            $sheet->getStyle('A1:AG1')->getFont()->setBold(true);  
    
            /*$spreadsheet->getActiveSheet()->getStyle("A1:AG1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');*/
    
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("C1:AG2")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("C1", "1-".$nom_mes);  
            $sheet->setCellValue("D1", "2-".$nom_mes);  
            $sheet->setCellValue("E1", "3-".$nom_mes);  
            $sheet->setCellValue("F1", "4-".$nom_mes);  
            $sheet->setCellValue("G1", "5-".$nom_mes);  
            $sheet->setCellValue("H1", "6-".$nom_mes);  
            $sheet->setCellValue("I1", "7-".$nom_mes);  
            $sheet->setCellValue("J1", "8-".$nom_mes);  
            $sheet->setCellValue("K1", "9-".$nom_mes);  
            $sheet->setCellValue("L1", "10-".$nom_mes);  
            $sheet->setCellValue("M1", "11-".$nom_mes);  
            $sheet->setCellValue("N1", "12-".$nom_mes);  
            $sheet->setCellValue("O1", "13-".$nom_mes);  
            $sheet->setCellValue("P1", "14-".$nom_mes);  
            $sheet->setCellValue("Q1", "15-".$nom_mes);  
            $sheet->setCellValue("R1", "16-".$nom_mes);  
            $sheet->setCellValue("S1", "17-".$nom_mes);  
            $sheet->setCellValue("T1", "18-".$nom_mes);  
            $sheet->setCellValue("U1", "19-".$nom_mes);  
            $sheet->setCellValue("V1", "20-".$nom_mes);  
            $sheet->setCellValue("W1", "21-".$nom_mes);  
            $sheet->setCellValue("X1", "22-".$nom_mes);  
            $sheet->setCellValue("Y1", "23-".$nom_mes);  
            $sheet->setCellValue("Z1", "24-".$nom_mes);  
            $sheet->setCellValue("AA1", "25-".$nom_mes);  
            $sheet->setCellValue("AB1", "26-".$nom_mes);  
            $sheet->setCellValue("AC1", "27-".$nom_mes);  
            $sheet->setCellValue("AD1", "28-".$nom_mes);  
            $sheet->setCellValue("AE1", "29-".$nom_mes);  
            $sheet->setCellValue("AF1", "30-".$nom_mes);  
            $sheet->setCellValue("AG1", "31-".$nom_mes);  

            $sheet->setCellValue("C2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-01'))], 0, 1)); 
            $sheet->setCellValue("D2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-02'))], 0, 1)); 
            $sheet->setCellValue("E2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-03'))], 0, 1));
            $sheet->setCellValue("F2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-04'))], 0, 1));  
            $sheet->setCellValue("G2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-05'))], 0, 1));  
            $sheet->setCellValue("H2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-06'))], 0, 1));  
            $sheet->setCellValue("I2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-07'))], 0, 1));  
            $sheet->setCellValue("J2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-08'))], 0, 1));  
            $sheet->setCellValue("K2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-09'))], 0, 1));  
            $sheet->setCellValue("L2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-10'))], 0, 1));  
            $sheet->setCellValue("M2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-11'))], 0, 1));  
            $sheet->setCellValue("N2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-12'))], 0, 1));  
            $sheet->setCellValue("O2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-13'))], 0, 1));  
            $sheet->setCellValue("P2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-14'))], 0, 1));  
            $sheet->setCellValue("Q2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-15'))], 0, 1));  
            $sheet->setCellValue("R2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-16'))], 0, 1));  
            $sheet->setCellValue("S2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-17'))], 0, 1));  
            $sheet->setCellValue("T2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-18'))], 0, 1));  
            $sheet->setCellValue("U2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-19'))], 0, 1));  
            $sheet->setCellValue("V2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-20'))], 0, 1));  
            $sheet->setCellValue("W2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-21'))], 0, 1));  
            $sheet->setCellValue("X2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-22'))], 0, 1));  
            $sheet->setCellValue("Y2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-23'))], 0, 1));  
            $sheet->setCellValue("Z2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-24'))], 0, 1));  
            $sheet->setCellValue("AA2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-25'))], 0, 1));  
            $sheet->setCellValue("AB2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-26'))], 0, 1));  
            $sheet->setCellValue("AC2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-27'))], 0, 1));  
            $sheet->setCellValue("AD2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-28'))], 0, 1));  
            $sheet->setCellValue("AE2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-29'))], 0, 1));  
            $sheet->setCellValue("AF2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-30'))], 0, 1));  
            $sheet->setCellValue("AG2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-31'))], 0, 1)); 

            $i=3;

            foreach($row_t as $list){
                $fila=($i-1)+$list['total'];

                $sheet->mergeCells("A{$i}:A{$fila}");
                $sheet->getStyle("A{$i}:A{$fila}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$i}:A{$fila}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("B{$i}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("C{$i}:AG{$i}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$i}:AG{$i}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("C{$i}:AG{$i}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$i}", $list['nom_tipo']);
                $sheet->setCellValue("B{$i}", $list['nom_subtipo']);

                $dia1 = strtotime($anio.'-'.$id_mes.'-01');
                $dia=$anio.'-'.$id_mes.'-01';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("C{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("C{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-02');
                $dia=$anio.'-'.$id_mes.'-02';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("D{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("D{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-03');
                $dia=$anio.'-'.$id_mes.'-03';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("E{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("E{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-04');
                $dia=$anio.'-'.$id_mes.'-04';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("F{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("F{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-05');
                $dia=$anio.'-'.$id_mes.'-05';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("G{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("G{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-06');
                $dia=$anio.'-'.$id_mes.'-06';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("H{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("H{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-07');
                $dia=$anio.'-'.$id_mes.'-07';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("I{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("I{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-08');
                $dia=$anio.'-'.$id_mes.'-08';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("J{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("J{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-09');
                $dia=$anio.'-'.$id_mes.'-09';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("K{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("K{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-10');
                $dia=$anio.'-'.$id_mes.'-10';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("L{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("L{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-11');
                $dia=$anio.'-'.$id_mes.'-11';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("M{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("M{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-12');
                $dia=$anio.'-'.$id_mes.'-12';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("N{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("N{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-13');
                $dia=$anio.'-'.$id_mes.'-13';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("O{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("O{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-14');
                $dia=$anio.'-'.$id_mes.'-14';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("P{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("P{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-15');
                $dia=$anio.'-'.$id_mes.'-15';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Q{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Q{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-16');
                $dia=$anio.'-'.$id_mes.'-16';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("R{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("R{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-17');
                $dia=$anio.'-'.$id_mes.'-17';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("S{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("S{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-18');
                $dia=$anio.'-'.$id_mes.'-18';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("T{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("T{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-19');
                $dia=$anio.'-'.$id_mes.'-19';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("U{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("U{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-20');
                $dia=$anio.'-'.$id_mes.'-20';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("V{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("V{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-21');
                $dia=$anio.'-'.$id_mes.'-21';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("W{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("W{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-22');
                $dia=$anio.'-'.$id_mes.'-22';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("X{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("X{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-23');
                $dia=$anio.'-'.$id_mes.'-23';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Y{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Y{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-24');
                $dia=$anio.'-'.$id_mes.'-24';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Z{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Z{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-25');
                $dia=$anio.'-'.$id_mes.'-25';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AA{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AA{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-26');
                $dia=$anio.'-'.$id_mes.'-26';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AB{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AB{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-27');
                $dia=$anio.'-'.$id_mes.'-27';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AC{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AC{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-28');
                $dia=$anio.'-'.$id_mes.'-28';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AD{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AD{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-29');
                $dia=$anio.'-'.$id_mes.'-29';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AE{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AE{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-30');
                $dia=$anio.'-'.$id_mes.'-30';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AF{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AF{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-31');
                $dia=$anio.'-'.$id_mes.'-31';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AG{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AG{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                //--------------------SUBTIPOS-----------------------
                $dato['id_tipo']=$list['id_tipo'];
                $dato['id_subtipo']=$list['id_subtipo'];

                $list_subtipo = $this->Model_snappy->get_list_subtipos_redes($dato);

                $j=$i+1;

                foreach($list_subtipo as $sub){
                    $sheet->getStyle("B{$j}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("C{$j}:AG{$j}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C{$j}:AG{$j}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("C{$j}:AG{$j}")->applyFromArray($styleThinBlackBorderOutline);

                    $sheet->setCellValue("B{$j}", $sub['nom_subtipo']);

                    $dia1 = strtotime($anio.'-'.$id_mes.'-01');
                    $dia=$anio.'-'.$id_mes.'-01';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("C{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("C{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-02');
                    $dia=$anio.'-'.$id_mes.'-02';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("D{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("D{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-03');
                    $dia=$anio.'-'.$id_mes.'-03';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("E{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("E{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-04');
                    $dia=$anio.'-'.$id_mes.'-04';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("F{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("F{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-05');
                    $dia=$anio.'-'.$id_mes.'-05';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("G{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("G{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-06');
                    $dia=$anio.'-'.$id_mes.'-06';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("H{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("H{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-07');
                    $dia=$anio.'-'.$id_mes.'-07';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("I{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("I{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-08');
                    $dia=$anio.'-'.$id_mes.'-08';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("J{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("J{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-09');
                    $dia=$anio.'-'.$id_mes.'-09';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("K{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("K{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-10');
                    $dia=$anio.'-'.$id_mes.'-10';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("L{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("L{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-11');
                    $dia=$anio.'-'.$id_mes.'-11';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("M{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("M{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-12');
                    $dia=$anio.'-'.$id_mes.'-12';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("N{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("N{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-13');
                    $dia=$anio.'-'.$id_mes.'-13';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("O{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("O{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-14');
                    $dia=$anio.'-'.$id_mes.'-14';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("P{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("P{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-15');
                    $dia=$anio.'-'.$id_mes.'-15';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Q{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Q{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-16');
                    $dia=$anio.'-'.$id_mes.'-16';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("R{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("R{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-17');
                    $dia=$anio.'-'.$id_mes.'-17';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("S{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("S{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-18');
                    $dia=$anio.'-'.$id_mes.'-18';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("T{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("T{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-19');
                    $dia=$anio.'-'.$id_mes.'-19';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("U{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("U{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-20');
                    $dia=$anio.'-'.$id_mes.'-20';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("V{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("V{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-21');
                    $dia=$anio.'-'.$id_mes.'-21';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("W{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("W{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-22');
                    $dia=$anio.'-'.$id_mes.'-22';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("X{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("X{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-23');
                    $dia=$anio.'-'.$id_mes.'-23';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Y{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Y{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-24');
                    $dia=$anio.'-'.$id_mes.'-24';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Z{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Z{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-25');
                    $dia=$anio.'-'.$id_mes.'-25';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AA{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AA{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-26');
                    $dia=$anio.'-'.$id_mes.'-26';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AB{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AB{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-27');
                    $dia=$anio.'-'.$id_mes.'-27';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AC{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AC{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-28');
                    $dia=$anio.'-'.$id_mes.'-28';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AD{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AD{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-29');
                    $dia=$anio.'-'.$id_mes.'-29';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AE{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AE{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-30');
                    $dia=$anio.'-'.$id_mes.'-30';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AF{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AF{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }

                    $dia1 = strtotime($anio.'-'.$id_mes.'-31');
                    $dia=$anio.'-'.$id_mes.'-31';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AG{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AG{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }

                    $j++;
                }
                //---------------------------------------------------

                $i=$fila;
                $i++;
            }

        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Reporte Redes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Subtipo_mensual(){
         $id_subtipo= $this->input->get('id_subtipo');
         var_dump($id_subtipo);
    }

    public function Update_Redes(){
        $dato['cod_proyecto']= $this->input->post('cod_proyecto');
        
        $dato['subido']= $this->input->post('subido');
        $dato['inicio']= $this->input->post('inicio');
        $dato['snappy_redes']= $this->input->post('snappy_redes');
        $this->Model_snappy->update_redes($dato);

    }

    public function Edit_Calendar_Redes(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $dato['id_calendar']= $this->input->post('Event[0]');
        $dato['inicio']= $this->input->post('Event[1]');
        $dato['cod_proyecto']= $this->input->post('Event[3]');

        
        $dato['fec_agenda']= $this->input->post("Event[1]");
        $dato['mes']=substr($this->input->post("Event[1]"),5,2);
        $dato['dia']=substr($this->input->post("Event[1]"),8,2);
        $dato['anio']=substr($this->input->post("Event[1]"),0,4);
        $dato['iniciosf'] = strtotime($dato['fec_agenda']);

        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $this->Model_snappy->update_calendar_redes($dato);

        //redirect('Snappy/Redes');
    }

    public function Agenda_Empresa(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['anio'] = $this->Model_snappy->anios_calendar_redes();
        if($_SESSION['usuario'][0]['id_nivel']!="1" && $_SESSION['usuario'][0]['id_nivel']!="6" && $_SESSION['usuario'][0]['id_nivel']!="7"){
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

            $result="";

            foreach($dato['list_empresa'] as $char){
                $result.= $char['id_empresa'].",";
            }
            $cadena = substr($result, 0, -1);
            
            $dato['cadena'] = " and p.id_empresa in (".$cadena.")";
            
        }else{
            $dato['cadena']="";
        }
        $dato['id_empresa']= $this->input->post("val_empresa");
        $dato['id_redes']= $this->input->post("val_redes");
        $dato['list_duplicado'] = $this->Model_snappy->get_redes_duplicados();
        $dato['list_redes'] = $this->Model_snappy->get_list_redes_empresa($dato);
        $dato['list_empresa'] = $this->Model_General->list_empresa_proyecto();

        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $this->load->view('Admin/redes/list_calendar_empresa',$dato);
    }

    /*----------------INVENTARIO---------------- */

    public function Codigo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_codigo'] = $this->Model_snappy->get_list_codigo_inventario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/inventario/codigo/index',$dato);
    }

    public function Modal_Codigo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_snappy->get_list_anio();
            $this->load->view('Admin/inventario/codigo/modal_codigo',$dato);   
        }
        else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Codigo($id_codigo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_codigo_inventario($id_codigo);
            $dato['list_anio'] = $this->Model_snappy->get_list_anio();
            $this->load->view('Admin/inventario/codigo/upd_modal', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Codigo(){
        if ($this->session->userdata('usuario')) {
            $dato['letra']=  strtoupper($this->input->post("letra")); 
            $dato['num_inicio']= $this->input->post("num_inicio"); 
            $dato['num_fin']= $this->input->post("num_fin"); 
            $dato['id_anio']= $this->input->post("id_anio"); 
        
            $activo=count($this->Model_snappy->valida_codigo_inventario_activos($dato));
            $cant=count($this->Model_snappy->valida_codigo_inventario($dato));
            
            if($activo>0){
                echo "activo";
            }elseif($cant){
                echo "error";
            }else{
                $this->Model_snappy->insert_codigo_inventario($dato);
                $numero=$dato['num_inicio'];
                while($numero<=$dato['num_fin']){
                    $dato['inventario_codigo']=$dato['letra']."/".$numero;
                    
                    if($numero<=9){
                        $code=$dato['letra']."/"."0000".($numero);
                    }
                    if($numero>9 && $numero<=99){
                        $code=$dato['letra']."/"."000".($numero);
                    }
                    if($numero>99 && $numero<=999){
                        $code=$dato['letra']."/"."00".($numero);
                    }
                    if($numero>999 && $numero<=9999){
                        $code=$dato['letra']."/"."0".($numero);
                    }
                    if($numero>9999){
                        $code=$dato['letra']."/".($numero);
                    }
        
                    /** */
                    $dato['codigo_barra']=$code;
                    $cant_i=count($this->Model_snappy->valida_inventario($dato));
                    if($cant_i>0){
                    }else{
                        //$dato['numero']=$numero;
                        $this->Model_snappy->insert_inventario($dato);
                    }
                    $numero=$numero+1;
                }
            }
        }else{
            redirect('/login');
        }
    
    }
    
    public function Update_Codigo(){
        if ($this->session->userdata('usuario')) {
            $dato['letra']=  strtoupper($this->input->post("letra")); 
            $dato['letra_anterior']=  strtoupper($this->input->post("letra_anterior")); 
            $dato['num_inicio']= $this->input->post("num_inicio"); 
            $dato['num_fin']= $this->input->post("num_fin"); 
            $dato['num_fin_anterior']= $this->input->post("num_fin_anterior"); 
            $dato['id_anio']= $this->input->post("id_anio"); 
            $dato['id_codigo_inventario']= $this->input->post("id_codigo_inventario"); 
            $cant=count($this->Model_snappy->valida_codigo_inventario_edit($dato));
            if($cant>0){
                echo "error";
            }else{
                $this->Model_snappy->update_codigo_inventario($dato);
                
                if($dato['letra']!=$dato['letra_anterior']){
                    $list_registrados=$this->Model_snappy->valida_siyaexiste_codigo_inventario($dato);

                    foreach($list_registrados as $list){
                        $dato['id_inventario']=$list['id_inventario'];
                        //$codigo=$list['codigo_barra'];

                        //$cadena = explode("/", $codigo);
                        //$dato['inventario_codigo']=$dato['letra']."/".$cadena[1];
                        $this->Model_snappy->update_inventario_siyaexiste($dato);
                    }
                }
                
                if($dato['num_fin']<$dato['num_fin_anterior']){

                    $numero=$dato['num_inicio'];
                    while($numero<=$dato['num_fin']){
                        /*------------*/
                        if($numero<=9){
                            $code=$dato['letra']."/"."0000".($numero);
                        }
                        if($numero>9 && $numero<=99){
                            $code=$dato['letra']."/"."000".($numero);
                        }
                        if($numero>99 && $numero<=999){
                            $code=$dato['letra']."/"."00".($numero);
                        }
                        if($numero>999 && $numero<=9999){
                            $code=$dato['letra']."/"."0".($numero);
                        }
                        if($numero>9999){
                            $code=$dato['letra']."/".($numero);
                        }
                        $dato['codigo_barra']=$code;
                        /*------------*/
                        /*$cant_i=count($this->Model_snappy->valida_inventario($dato));
                        if($cant_i>0){
                        }*/
                        $numero=$numero+1;
                    }

                    $y=$numero;
                    while($y>$dato['num_fin'] && $y<=$dato['num_fin_anterior']){
                        //$dato['inventario_codigo']=$dato['letra']."/".$y;

                        /*--------------------*/
                        if($y<=9){
                            $code=$dato['letra']."/"."0000".($y);
                        }
                        if($y>9 && $y<=99){
                            $code=$dato['letra']."/"."000".($y);
                        }
                        if($y>99 && $y<=999){
                            $code=$dato['letra']."/"."00".($y);
                        }
                        if($y>999 && $y<=9999){
                            $code=$dato['letra']."/"."0".($y);
                        }
                        if($y>9999){
                            $code=$dato['letra']."/".($y);
                        }
                        $dato['codigo_barra']=$code;
                        /*--------------------*/
                        
                        $this->Model_snappy->delete_inventario_xcodigomenor($dato);
                        
                        $y=$y+1;
                    }
                }
                if($dato['num_fin']>$dato['num_fin_anterior']){

                    $numero=$dato['num_inicio'];
                    while($numero<=$dato['num_fin']){
                        //$dato['inventario_codigo']=$dato['letra']."/".$numero;
                        /*------------*/
                        if($numero<=9){
                            $code=$dato['letra']."/"."0000".($numero);
                        }
                        if($numero>9 && $numero<=99){
                            $code=$dato['letra']."/"."000".($numero);
                        }
                        if($numero>99 && $numero<=999){
                            $code=$dato['letra']."/"."00".($numero);
                        }
                        if($numero>999 && $numero<=9999){
                            $code=$dato['letra']."/"."0".($numero);
                        }
                        if($numero>9999){
                            $code=$dato['letra']."/".($numero);
                        }
                        $dato['codigo_barra']=$code;
                        /*------------*/
                        $cant_i=count($this->Model_snappy->valida_inventario($dato));
                        if($cant_i>0){
                        }else{
                            $this->Model_snappy->insert_inventario($dato);
                        }
                        $numero=$numero+1;
                    }
                }
                
                /***/
                if($dato['num_inicio']<=9){
                    $code=$dato['letra']."/"."0000".($dato['num_inicio']);
                }
                if($dato['num_inicio']>9 && $dato['num_inicio']<=99){
                    $code=$dato['letra']."/"."000".($dato['num_inicio']);
                }
                if($dato['num_inicio']>99 && $dato['num_inicio']<=999){
                    $code=$dato['letra']."/"."00".($dato['num_inicio']);
                }
                if($dato['num_inicio']>999 && $dato['num_inicio']<=9999){
                    $code=$dato['letra']."/"."0".($dato['num_inicio']);
                }
                if($dato['num_inicio']>9999){
                    $code=$dato['letra']."/".($dato['num_inicio']);
                }
                $dato['codigo_barra_i']=$code;

                if($dato['num_fin']<=9){
                    $code=$dato['letra']."/"."0000".($dato['num_fin']);
                }
                if($dato['num_fin']>9 && $dato['num_fin']<=99){
                    $code=$dato['letra']."/"."000".($dato['num_fin']);
                }
                if($dato['num_fin']>99 && $dato['num_fin']<=999){
                    $code=$dato['letra']."/"."00".($dato['num_fin']);
                }
                if($dato['num_fin']>999 && $dato['num_fin']<=9999){
                    $code=$dato['letra']."/"."0".($dato['num_fin']);
                }
                if($dato['num_fin']>9999){
                    $code=$dato['letra']."/".($dato['num_fin']);
                }
                $dato['codigo_barra_f']=$code;
                $this->Model_snappy->delete_inventario_xbarra($dato);
                /*else{
                    $numero=$dato['num_inicio'];
                    while($numero<=$dato['num_fin']){
                        if($numero<=9){
                            $code=$dato['letra']."/"."0000".($numero);
                        }
                        if($numero>9 && $numero<=99){
                            $code=$dato['letra']."/"."000".($numero);
                        }
                        if($numero>99 && $numero<=999){
                            $code=$dato['letra']."/"."00".($numero);
                        }
                        if($numero>999 && $numero<=9999){
                            $code=$dato['letra']."/"."0".($numero);
                        }
                        if($numero>9999){
                            $code=$dato['letra']."/".($numero);
                        }
                        $dato['codigo_barra']=$code;
                        $cant_i=count($this->Model_snappy->valida_inventario($dato));
                        if($cant_i>0){
                        }else{
                            $this->Model_snappy->insert_inventario($dato);
                        }
                        $numero=$numero+1;
                    }
                }*/
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Codigo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_codigo_inventario']= $this->input->post("id_codigo_inventario"); 
            
            $this->Model_snappy->delete_codigo_inventario($dato);
            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Codigo(){
        $tipo = $this->Model_snappy->get_list_codigo_inventario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Codigos Invetario');

        $sheet->setAutoFilter('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:E1")->getFill()
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

        $sheet->getStyle("A1:E1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Letra');	        
        $sheet->setCellValue("B1", 'Inicio');
        $sheet->setCellValue("C1", 'Fin');
        $sheet->setCellValue("D1", 'Año');
        $sheet->setCellValue("E1", 'Estado');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['letra']);
            $sheet->setCellValue("B{$contador}", $list['num_inicio']);
            $sheet->setCellValue("C{$contador}", $list['num_fin']);
            $sheet->setCellValue("D{$contador}", $list['nom_anio']);
            $sheet->setCellValue("E{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Códigos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /*------- */

    public function Local() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_local'] = $this->Model_snappy->get_list_local_inventario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/inventario/local/index',$dato);
    }

    public function Modal_Local(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] = $this->Model_snappy->get_list_empresa();
            $dato['list_usuario'] = $this->Model_snappy->get_list_usuario_local();
            $this->load->view('Admin/inventario/local/modal_reg',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Buscar_Sede(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  strtoupper($this->input->post("id_empresa")); 
        
            $dato['list_sede']=$this->Model_snappy->get_list_sede_xempresa($dato);
            
            $this->load->view('Admin/inventario/local/cmb_sede', $dato); 
            
        }else{
            redirect('/login');
        }
    
    }
    
    public function Modal_Update_Local($id_local){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_local_inventario($id_local);
            $dato['list_empresa'] = $this->Model_snappy->get_list_empresa();
            $dato['id_empresa']=$dato['get_id'][0]['id_empresa'];
            $dato['list_sede']=$this->Model_snappy->get_list_sede_xempresa($dato);
            $dato['list_usuario'] = $this->Model_snappy->get_list_usuario_local();   
            $this->load->view('Admin/inventario/local/upd_modal', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Local(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  strtoupper($this->input->post("id_empresa")); 
            $dato['id_sede']= $this->input->post("id_sede"); 
            $dato['nom_local']= $this->input->post("nom_local"); 
            $dato['id_responsable']= $this->input->post("id_responsable"); 
        
            $cant=count($this->Model_snappy->valida_local_inventario($dato));
            if($cant>0){
                echo "error";
            }else{
                $this->Model_snappy->insert_local_inventario($dato);
            }
        }else{
            redirect('/login');
        }
    
    }
    
    public function Update_Local(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  strtoupper($this->input->post("id_empresa")); 
            $dato['id_sede']= $this->input->post("id_sede"); 
            $dato['nom_local']= $this->input->post("nom_local"); 
            $dato['id_inventario_local']= $this->input->post("id_inventario_local"); 
            $dato['id_responsable']= $this->input->post("id_responsable");
            $cant=count($this->Model_snappy->valida_local_inventario_edit($dato));
            if($cant>0){
                echo "error";
            }else{
                $this->Model_snappy->update_local_inventario($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Local(){
        if ($this->session->userdata('usuario')) {
            $dato['id_inventario_local']= $this->input->post("id_inventario_local"); 
            
            $this->Model_snappy->delete_local_inventario($dato);
            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Local(){
        $tipo = $this->Model_snappy->get_list_local_inventario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Invetario - Local');

        $sheet->setAutoFilter('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:E1")->getFill()
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

        $sheet->getStyle("A1:C1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Empresa');	        
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Nombre');
        $sheet->setCellValue("D1", 'Responsable');
        $sheet->setCellValue("E1", 'Estado');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_local']);
            $sheet->setCellValue("D{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("E{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Locales (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /*-------------------TIPO PRODUCTO---------------- */

    public function Tipo_Inventario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_tipo'] = $this->Model_snappy->get_list_tipo_inventario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/inventario/tipo/index',$dato);
    }

    public function Modal_tipo_Inventario(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/inventario/tipo/modal_reg', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Tipo_Inventario($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_tipo_inventario($id_tipo);
            $this->load->view('Admin/inventario/tipo/upd_modal', $dato);   
        }
        else{
            redirect('/login');
        }
    }
    
    public function Insert_Tipo_Inventario(){

        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $dato['nom_tipo_inventario']= strtoupper($this->input->post("nom_tipo_inventario")); 
         
        $cant=count($this->Model_snappy->valida_tipo_inventario($dato));
        if($cant>0){
            echo "error";
        }else{
            $this->Model_snappy->insert_tipo_inventario($dato);
        } 
    }
    
    public function Update_Tipo_Inventario(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['nom_tipo_inventario']= strtoupper($this->input->post("nom_tipo_inventario")); 
        $dato['id_tipo_inventario']= $this->input->post("id_tipo_inventario"); 

        $cant=count($this->Model_snappy->valida_tipo_inventarioe($dato));
        if($cant>0){
            echo "error";
        }else{
            $this->Model_snappy->update_tipo_inventario($dato);
        } 
    }

    public function Delete_Tipo_Inventario(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['id_tipo_inventario']= $this->input->post("id_tipo_inventario"); 

        $this->Model_snappy->delete_tipo_inventario($dato);
        
    }

    public function Excel_Tipo_Inventario(){
        $tipo = $this->Model_snappy->get_list_tipo_inventario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tipo Inventario');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:B1")->getFill()
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

        $sheet->getStyle("A1:B1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Tipo');	        
        $sheet->setCellValue("B1", 'Estado');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo_inventario']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Conf. Tipos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Subtipo_Inventario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_subtipo'] = $this->Model_snappy->get_list_subtipo_inventario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
    
        $this->load->view('Admin/inventario/subtipo/index',$dato);
    }

    public function Modal_Subtipo_Inventario(){
        if ($this->session->userdata('usuario')) {
            
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipo_inventario();
            $this->load->view('Admin/inventario/subtipo/modal_reg', $dato);   
        }
        else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Subtipo_Inventario($id_subtipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_subtipo_inventario($id_subtipo);
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipo_inventario();
            $this->load->view('Admin/inventario/subtipo/upd_modal', $dato);   
        }
        else{
            redirect('/login');
        }
    }
    
    public function Insert_Subtipo_Inventario(){
        $dato['id_tipo_inventario']= $this->input->post("id_tipo_inventario");
        $dato['nom_subtipo_inventario']= strtoupper($this->input->post("nom_subtipo_inventario"));
        $dato['intervalo_rev']= $this->input->post("intervalo_rev");
    
        $cant=count($this->Model_snappy->valida_subtipo_inventario($dato));
        if($cant>0){
            echo "error";
        }else{
            $this->Model_snappy->insert_subtipo_inventario($dato);
        } 
    
    }

    public function Update_Subtipo_Inventario(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['id_tipo_inventario']= $this->input->post("id_tipo_inventario");
        $dato['nom_subtipo_inventario']= strtoupper($this->input->post("nom_subtipo_inventario")); 
        $dato['id_subtipo_inventario']= $this->input->post("id_subtipo_inventario"); 
        $dato['intervalo_rev']= $this->input->post("intervalo_rev");
        $cant=count($this->Model_snappy->valida_subtipo_inventarioe($dato));
        if($cant>0){
            echo "error";
        }else{
            $this->Model_snappy->update_subtipo_inventario($dato);
        }
    
    }

    public function Delete_Subtipo_Inventario(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['id_subtipo_inventario']= $this->input->post("id_subtipo_inventario"); 
 
        $this->Model_snappy->delete_subtipo_inventario($dato);
        
    
    }

    public function Excel_Subtipo_Inventario(){
        $subtipo = $this->Model_snappy->get_list_subtipo_inventario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Tipo');

        $sheet->setAutoFilter('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:D1")->getFill()
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

        $sheet->getStyle("A1:D1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Tipo');	        
        $sheet->setCellValue("B1", 'Sub-Tipo');
        $sheet->setCellValue("C1", 'Intervalo de Revisión (meses)');
        $sheet->setCellValue("D1", 'Status');

        $contador=1;
        
        foreach($subtipo as $list){
            $contador++;
            
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo_inventario']);
            $sheet->setCellValue("B{$contador}", $list['nom_subtipo_inventario']);
            $sheet->setCellValue("C{$contador}", $list['intervalo_rev']);
            $sheet->setCellValue("D{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Conf. Subtipos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    /*-------------------PRODUCTO--------------------- */

    public function Producto() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_producto'] = $this->Model_snappy->get_list_producto_inventario();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/inventario/producto/index',$dato);
    }

    public function Excel_Producto(){
        $dato = $this->Model_snappy->get_list_producto_inventario();

        $contador = 1;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Productos');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(20);
        /*$sheet->getColumnDimension('K')->setWidth(14);*/

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:J1")->getFill()
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

        $sheet->getStyle("A1:J1")->applyFromArray($styleThinBlackBorderOutline);


        $sheet->setCellValue("A{$contador}", 'Referencia');	        
        $sheet->setCellValue("B{$contador}", 'Tipo');
        $sheet->setCellValue("C{$contador}", 'SubTipo');
        $sheet->setCellValue("D{$contador}", 'Compra');	        
        $sheet->setCellValue("E{$contador}", 'Proveedor');
        $sheet->setCellValue("F{$contador}", 'Garantía Hasta');
        $sheet->setCellValue("G{$contador}", 'Precio U.');
        $sheet->setCellValue("H{$contador}", 'Cantidad');
        $sheet->setCellValue("I{$contador}", 'Total');
        $sheet->setCellValue("J{$contador}", 'Estado');

        $contador=1;
        
        foreach($dato as $c){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $c['referencia']);
            $sheet->setCellValue("B{$contador}", $c['nom_tipo_inventario']);
            $sheet->setCellValue("C{$contador}", $c['nom_subtipo_inventario']);
            //$sheet->setCellValue("D{$contador}", $c['fecha_compra']);

            $sheet->setCellValue("D{$contador}",  Date::PHPToExcel($c['fecha_compra']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);

            $sheet->setCellValue("E{$contador}", $c['proveedor']);
            //$sheet->setCellValue("F{$contador}", $c['garantia_h']);

            $sheet->setCellValue("F{$contador}",  Date::PHPToExcel($c['fecha_garantia']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);

            $sheet->setCellValue("G{$contador}", "S/. ".$c['precio_u']);
            $sheet->setCellValue("H{$contador}", $c['cantidad']);
            $sheet->setCellValue("I{$contador}", "S/. ".$c['total']);
            
            $sheet->setCellValue("J{$contador}", $c['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Productos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Buscar_Subtipo_Inventario(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_inventario']=  strtoupper($this->input->post("id_tipo_inventario")); 
        
            $dato['list_subtipo']=$this->Model_snappy->get_list_subtipo_xtipo($dato);
            
            $this->load->view('Admin/inventario/producto/cmb_subtipo', $dato); 
            
        }else{
            redirect('/login');
        }
    
    }

    public function Cargar_Codigos(){
        if ($this->session->userdata('usuario')) {
            
            $dato['cantidad']=  $this->input->post("cantidad"); 
            $dato['get_referencia'] = $this->Model_snappy->get_ultimo_codigo_inventario();
            $dato['letra']=$dato['get_referencia'][0]['letra'];

            $dato['list_productos'] = $this->Model_snappy->get_inventario_xletra($dato);
            
            $dato['activo']=0;
            $dato['sinrevisar']=0;
            $dato['revision']=0;
            $dato['disponible']=0;
            $dato['total']=count($dato['list_productos']);
            foreach($dato['list_productos'] as $list){
                if($list['estado']==39){
                    $dato['activo']=$dato['activo']+1;
                }
                if($list['estado']==40){
                    $dato['sinrevisar']=$dato['sinrevisar']+1;
                }
                if($list['estado']==41){
                    $dato['revision']=$dato['revision']+1;
                }if($list['estado']==42){
                    $dato['disponible']=$dato['disponible']+1;
                }
            }
            
            $this->load->view('Admin/inventario/producto/div_codigo', $dato); 
            
        }else{
            redirect('/login');
        }
    
    }

    public function Modal_Producto(){
        if ($this->session->userdata('usuario')) {
            //$dato['get_referencia'] = $this->Model_snappy->get_ultimo_codigo_inventario();
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipo_inventario();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('Admin/inventario/producto/vista_reg',$dato);   
        }
        else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Producto($id_producto){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_list_producto_inventario($id_producto);
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipo_inventario();
            $dato['id_tipo_inventario']= $dato['get_id'][0]['id_tipo_inventario'];
        
            $dato['list_subtipo']=$this->Model_snappy->get_list_subtipo_xtipo($dato);
            $dato['list_historial'] = $this->Model_snappy->get_list_archivos_adicionales_producto($id_producto);
            $dato['id_inventario_producto']=$dato['get_id'][0]['id_inventario_producto'];

            $dato['cantidad']=  $dato['get_id'][0]['cantidad'] ;
            $dato['get_referencia'] = $this->Model_snappy->get_ultimo_codigo_inventario();
            $dato['letra']=$dato['get_referencia'][0]['letra'];
            $dato['list_productos'] = $this->Model_snappy->get_inventario_xletra($dato);

            $dato['list_estado'] = $this->Model_snappy->list_estado_inventario();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('Admin/inventario/producto/vista_upd', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Producto_Inventario(){
        if ($this->session->userdata('usuario')) {
            
            //$dato['referencia']=  $this->input->post("referencia"); 
            $dato['id_tipo_inventario']=  $this->input->post("id_tipo_inventario"); 
            $dato['id_subtipo_inventario']=  $this->input->post("id_subtipo_inventario"); 
            $dato['producto_descripcion']= $this->input->post("producto_descripcion"); 
            $dato['fec_compra']= $this->input->post("fec_compra"); 
            $dato['proveedor']= $this->input->post("proveedor"); 
            $dato['garantia_h']= $this->input->post("garantia_h"); 
            $dato['precio_u']= $this->input->post("precio_u"); 
            $dato['cantidad']= $this->input->post("cantidad"); 
            $dato['total']= $dato['precio_u']*$dato['cantidad'];
            $dato['desvalorizacion']= $this->input->post("desvalorizacion"); 
            $dato['id_estado']= $this->input->post("id_estado"); 
            $dato['gastos']= $this->input->post("gastos");
            $dato['valor_actual']= $this->input->post("valor_actual"); 
            $dato['producto_obs']= $this->input->post("producto_obs"); 

            $cant=count($this->Model_snappy->valida_producto_inventario($dato));
            if($cant>0){
                echo "error";
            }else{
                $anio=date('Y');
                $contador = count($this->Model_snappy->ultimo_cod_producto());
                
                $aniof=substr($anio, 2,2);
                if($contador<9){
                    $codigo="P".$aniof."0000".($contador+1);
                }
                if($contador>=9 && $contador<99){
                    $codigo="P".$aniof."000".($contador+1);
                }
                if($contador>=99 && $contador<999){
                    $codigo="P".$aniof."00".($contador+1);
                }
                if($contador>=999 && $contador<9999){
                    $codigo="P".$aniof."0".($contador+1);
                }
                if($contador>9999){
                    $codigo="P".$aniof.($contador+1);
                }

                $dato['referencia']=$codigo;
                
                $this->Model_snappy->insert_producto_inventario($dato);
                
                if($_FILES["archivos"]["name"] != ''){
                    $config['upload_path'] = './inventario_producto/'.$dato['referencia'].'/';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                    }
                    $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                        for($count = 0; $count<count($_FILES["archivos"]["name"]); $count++){
                            $path = $_FILES["archivos"]["name"][$count];
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="archivo_adicional_".$fecha.rand(10,200);
                            $nombre = $nombre_soli.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["archivos"]["type"][$count];
                            $_FILES["file"]["tmp_name"] = $_FILES["archivos"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["archivos"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["archivos"]["size"][$count];
                            if($this->upload->do_upload('file')){
                                $data = $this->upload->data();
                                $dato['ruta'] = 'inventario_producto/'.$dato['referencia'].'/'.$nombre;
        
                                $this->Model_snappy->insert_archivo_adicional_producto_inventario($dato);
                            }
                        }
                }
                echo $codigo;
                
            }
        }else{
            redirect('/login');
        }
    
    }
    
    public function Update_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_inventario']=  $this->input->post("id_tipo_inventario"); 
            $dato['id_subtipo_inventario']=  $this->input->post("id_subtipo_inventario"); 
            $dato['producto_descripcion']= $this->input->post("producto_descripcion"); 
            $dato['fec_compra']= $this->input->post("fec_compra"); 
            $dato['proveedor']= $this->input->post("proveedor"); 
            $dato['garantia_h']= $this->input->post("garantia_h");
            $dato['precio_u']= $this->input->post("precio_u");
            $dato['cantidad']= $this->input->post("cantidad");
            $dato['total']= $dato['precio_u']*$dato['cantidad'];
            $dato['desvalorizacion']= $this->input->post("desvalorizacion");
            $dato['anio']= $this->input->post("anio");
            $dato['gastos']= $this->input->post("gastos");
            $dato['valor_actual']= $this->input->post("valor_actual");
            $dato['producto_obs']= $this->input->post("producto_obs");
            $dato['referencia']= $this->input->post("referencia");
            $dato['estado']= $this->input->post("id_estado");
            $dato['id_inventario_producto']= $this->input->post("id_inventario_producto"); 
            $cant=count($this->Model_snappy->valida_producto_inventario_edit($dato));
            if($cant>0){
                echo "error";
            }else{
                $this->Model_snappy->update_producto_inventario($dato);

                if($_FILES["archivose"]["name"] != ''){
                    $config['upload_path'] = './inventario_producto/'.$dato['referencia'].'/';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                    }
                    $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                        for($count = 0; $count<count($_FILES["archivose"]["name"]); $count++){
                            $path = $_FILES["archivose"]["name"][$count];
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="archivo_adicional_".$fecha.rand(10,200);
                            $nombre = $nombre_soli.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["archivose"]["type"][$count];
                            $_FILES["file"]["tmp_name"] = $_FILES["archivose"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["archivose"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["archivose"]["size"][$count];
                            if($this->upload->do_upload('file')){
                                $data = $this->upload->data();
                                $dato['ruta'] = 'inventario_producto/'.$dato['referencia'].'/'.$nombre;
        
                                $this->Model_snappy->insert_archivo_adicional_producto_inventario($dato);
                            }
                        }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_inventario_local']= $this->input->post("id_inventario_local"); 
            
            $this->Model_snappy->delete_local_inventario($dato);
            
        }else{
            redirect('/login');
        }
    }


    public function Descargar_Imagen_ProductoI($id_producto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_snappy->get_list_producto_inventario($id_producto);
            $image = $dato['get_file'][0]['imagen'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['imagen']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Imagen_ProductoI() {
        $id_producto = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_snappy->get_list_producto_inventario($id_producto);

        if (file_exists($dato['get_file'][0]['imagen'])) {
            unlink($dato['get_file'][0]['imagen']);
        }
        $this->Model_snappy->delete_imagen_productoi($id_producto);
    }

    public function Descargar_Imagen_ProductoI_Historial($id_historial_producto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_snappy->get_id_archivos_adicionales_producto($id_historial_producto);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Imagen_ProductoI_Historial() {
        $id_historial_producto = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_snappy->get_id_archivos_adicionales_producto($id_historial_producto);

        if (file_exists($dato['get_file'][0]['archivo'])) {
            unlink($dato['get_file'][0]['archivo']);
        }
        $this->Model_snappy->delete_imagen_productoi_historial($id_historial_producto);
    }

    public function Inventario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        //$dato['list_inventario'] = $this->Model_snappy->get_list_inventario();
        $parametro=1;
        $dato['parametro']=1;
        $dato['list_inventario'] = $this->Model_snappy->busqueda_list_inventario($parametro);
        $dato['list_producto'] = $this->Model_snappy->get_list_producto_inventario();
        $dato['list_empresam'] = $this->Model_snappy->get_list_empresa_local_inventario();
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //$code = str_replace("-", "0", $code);
        //echo "<br>".$sum;

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/inventario/inventario/index',$dato);
    }

    public function Busca_Inventario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $parametro= $this->input->post("parametro"); 
        $dato['parametro']= $this->input->post("parametro"); 

        $dato['list_inventario'] = $this->Model_snappy->busqueda_list_inventario($parametro);
        
        $this->load->view('Admin/inventario/inventario/busqueda',$dato);
    }

    public function Excel_Inventario($parametro){
        $dato = $this->Model_snappy->busqueda_list_inventario($parametro);

        $contador = 1;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Inventario');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(17);

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:K1")->getFill()
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

        $sheet->getStyle("A1:K1")->applyFromArray($styleThinBlackBorderOutline);


        $sheet->setCellValue("A{$contador}", 'Código');	        
        /*$sheet->setCellValue("B{$contador}", 'Referencia');*/
        $sheet->setCellValue("B{$contador}", 'Tipo');
        $sheet->setCellValue("C{$contador}", 'SubTipo');	        
        $sheet->setCellValue("D{$contador}", 'Empresa');
        $sheet->setCellValue("E{$contador}", 'Sede');
        $sheet->setCellValue("F{$contador}", 'Local');
        $sheet->setCellValue("G{$contador}", 'Validación');
        $sheet->setCellValue("H{$contador}", 'Usuario Validación');
        $sheet->setCellValue("I{$contador}", 'Fecha Validación');
        $sheet->setCellValue("J{$contador}", 'Ultimo Check');
        $sheet->setCellValue("K{$contador}", 'Estado');

        $contador=1;
        

        foreach($dato as $c){
            $contador++;

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $c['codigo_barra']);
            /*$sheet->setCellValue("B{$contador}", $c['numero']);*/
            $sheet->setCellValue("B{$contador}", $c['nom_tipo_inventario']);
            $sheet->setCellValue("C{$contador}", $c['nom_subtipo_inventario']);
            $sheet->setCellValue("D{$contador}", $c['cod_empresa']);
            $sheet->setCellValue("E{$contador}", $c['cod_sede']);
            $sheet->setCellValue("F{$contador}", $c['nom_local']);
            $sheet->setCellValue("G{$contador}", $c['validacion_msg']);
            $sheet->setCellValue("H{$contador}", $c['usuario_codigo']);
            if($c['validacion']!=0){
            $sheet->setCellValue("I{$contador}", $c['fecha_validacion']);
            }
            if($c['fecha_validacion']!="00/00/0000 00:00:00"){
                $sheet->setCellValue("J{$contador}", $c['lcheck']);
            }
            $sheet->setCellValue("K{$contador}", $c['nom_status']);
            
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Inventario (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_AsignacionImg_Inventario(){
        if ($this->session->userdata('usuario')) {
            $dato['list_inventario'] = $this->Model_snappy->get_list_inventario();
            
            $this->load->view('Admin/inventario/inventario/modal_reg',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Busca_Sede_Local_Inventario(){
        if ($this->session->userdata('usuario')) {
            $id_empresa= $this->input->post("id_empresa"); 
            $dato['list_sede'] = $this->Model_snappy->get_list_sede_local_inventario($id_empresa);
            $this->load->view('Admin/inventario/inventario/cmb_sede',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Busca_Local_Inventario(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']= $this->input->post("id_empresa"); 
            $dato['id_sede']= $this->input->post("id_sede"); 
            $dato['list_local'] = $this->Model_snappy->get_list_local_inventario_xempresa_sede($dato);
            $this->load->view('Admin/inventario/inventario/cmb_local',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Valida_cantidad_producto() {
        if ($this->session->userdata('usuario')) {
            $id_producto = $this->input->post('id_producto');
            $dato['get'] = $this->Model_snappy->get_list_producto_inventario($id_producto);
            $cadena = $this->input->post("cadena"); 

            $codigos = substr($cadena, 0, -1);
            $inventario_codigo = explode(",", $codigos);
            if(count($inventario_codigo)>$dato['get'][0]['cantidad']){
                echo "El producto seleccionado solo puede ser asignado a ".$dato['get'][0]['cantidad']." código(s)<br> Vuelva a seleccionar códigos!";
            }
        }
        else{
            redirect('/login');
        }
    }
    public function Insert_Asignacion_Producto_Inventario() {
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa'] = $this->input->post('id_empresa');
            $dato['id_sede'] = $this->input->post('id_sede');
            $dato['id_local'] = $this->input->post('id_local');
            $dato['id_producto'] = $this->input->post('id_producto');
            $id_producto = $this->input->post('id_producto');
            $dato['get'] = $this->Model_snappy->get_list_producto_inventario($id_producto);
            $cant2=count($this->Model_snappy->valida_asignacion_codigo2($dato));
            $cantidad=$dato['get'][0]['cantidad'];
            $cantidad_disponible=$cantidad-$cant2;

            $cadena = $this->input->post("cadena"); 
            $codigos = substr($cadena, 0, -1);
            $inventario_codigo = explode(",", $codigos);

            $mensaje="";
            $nodisponible="";
            $m=0;
            $d=0;
            foreach ($inventario_codigo as $list) {
                $dato['inventario_codigo'] = $list;
                
                $cant=count($this->Model_snappy->valida_asignacion_codigo($dato));
                
                if($cant>0){
                    $mensaje=$mensaje.$dato['inventario_codigo'].",";
                    $m=$m+1;
                }else{

                    if($cantidad_disponible>0){
                        $this->Model_snappy->update_asignacion_producto($dato);
                        $cantidad_disponible=$cantidad_disponible-1;
                    }else{
                        
                        $nodisponible=$nodisponible.$dato['inventario_codigo'].",";
                        $d=$d+1;
                    }
                    
                }
            }

            if($m>0){
                echo "<p style='text-align: justify; font-size:95%; color:black' >Los siguientes códigos ya estaban asignados: <b>".substr($mensaje, 0, -1)."</b></p></br>";
            }if($d>0){
                echo "<p style='text-align: justify; font-size:95%; color:black' >Los siguientes códigos <b>no fueron</b> asignados porque la cantidad de productos asignados llegó al límite: <b>".substr($nodisponible, 0, -1)."</b></p></br>";
            }

        }
        else{
            redirect('/login');
        }
        
    }

    public function Validar_InventarioImg() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $dato['id_inventario']= $this->input->post("id_inventario"); 
        $id_inventario= $this->input->post("id_inventario");
        $dato['get_id'] = $this->Model_snappy->get_list_inventario($id_inventario);

        $cant=count($this->Model_snappy->valida_codigo_img($dato));

        if($cant>0){
            echo "error";
        }else{
            $this->Model_snappy->update_validacion_inventario_img($dato);
        }
    }

    public function Validar_Inventario(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $cadena = $this->input->post("cadena"); 

        $codigos = substr($cadena, 0, -1);
        $inventario_codigo = explode(",", $codigos);

        $mensaje="";
        foreach ($inventario_codigo as $list) {
            $dato['inventario_codigo'] = $list;
            
            $cant=count($this->Model_snappy->valida_validacion_codigo($dato));
            if($cant>0){
                $mensaje=$mensaje.$dato['inventario_codigo'].",";
            }else{
                $this->Model_snappy->update_validacion_inventario($dato);
            }
        }

        if($mensaje!=""){
            $mensaje=substr($mensaje,0,-1);
            echo "Los siguientes códigos ya estaban validados: <b>".$mensaje."</b>";
        }
        
    }

    public function Modal_Update_Inventario($id_inventario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_list_inventario($id_inventario);

            $dato['list_empresa'] = $this->Model_snappy->get_list_empresa_local_inventario();
            $id_empresa= $dato['get_id'][0]['id_empresa']; 
            $dato['list_sede'] = $this->Model_snappy->get_list_sede_local_inventario($id_empresa);
            $dato['id_empresa']= $dato['get_id'][0]['id_empresa']; 
            $dato['id_sede']= $dato['get_id'][0]['id_sede']; 
            $dato['list_local'] = $this->Model_snappy->get_list_local_inventario_xempresa_sede($dato);
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
            $dato['list_estado'] = $this->Model_snappy->list_estado_inventario();

            $this->load->view('Admin/inventario/inventario/upd_modal',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Inventario() {
        $dato['id_inventario'] = $this->input->post('id_inventario');
        $dato['id_local'] = $this->input->post('id_local');
        $dato['id_estado'] = $this->input->post('id_estado');
        
        $this->Model_snappy->update_inventario($dato);
    }

    public function Sede(){
        if ($this->session->userdata('usuario')) {
            $dato['list_inventario_sede'] = $this->Model_snappy->get_list_inventario_xsede();
            $dato['list_sede'] = $this->Model_snappy->get_list_sede_inventario();
           
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('Admin/inventario/sede/index',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Buscar_Inventario_xSede(){
        if ($this->session->userdata('usuario')) {
            $id_sede = $this->input->post('id_sede');
            $dato['id_sede'] = $this->input->post('id_sede');
            $dato['list_inventario_sede'] = $this->Model_snappy->get_list_inventario_xsede($id_sede);
           

            $this->load->view('Admin/inventario/sede/busqueda',$dato);   
        }
        else{
            redirect('/login');
        }
    }


    public function Excel_Iventario_xSede(){
        $id_sede = $this->input->post('id_sede');
        
        $dato['list_inventario_sede'] = $this->Model_snappy->get_list_inventario_xsede($id_sede);

        $contador = 1;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Inventario Sede');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(17);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(14);
        $sheet->getColumnDimension('L')->setWidth(13);

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:L1")->getFill()
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

        $sheet->getStyle("A1:L1")->applyFromArray($styleThinBlackBorderOutline);


        $sheet->setCellValue("A{$contador}", 'Referencia');	        
        $sheet->setCellValue("B{$contador}", 'Código');
        $sheet->setCellValue("C{$contador}", 'Tipo');
        $sheet->setCellValue("D{$contador}", 'Sub-Tipo');	        
        $sheet->setCellValue("E{$contador}", 'Empresa');
        $sheet->setCellValue("F{$contador}", 'Sede');
        $sheet->setCellValue("G{$contador}", 'Local');
        $sheet->setCellValue("H{$contador}", 'Validación');
        $sheet->setCellValue("I{$contador}", 'Usuario Validación');
        $sheet->setCellValue("J{$contador}", 'Fecha Validación');
        $sheet->setCellValue("K{$contador}", 'Último Check');
        $sheet->setCellValue("L{$contador}", 'Estado');

        $contador=1;
        

        foreach($dato['list_inventario_sede'] as $list){

            $contador++;
            //Informacion de las filas de la consulta.
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue("A{$contador}", $list['numero']);
            $sheet->setCellValue("B{$contador}", $list['letra']."/".$list['codigo_barra']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_inventario']);
            $sheet->setCellValue("D{$contador}", $list['nom_subtipo_inventario']);
            $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("F{$contador}", $list['cod_sede']);
            $sheet->setCellValue("G{$contador}", $list['nom_local']);
            $sheet->setCellValue("H{$contador}", $list['validacion_msg']);
            $sheet->setCellValue("I{$contador}", $list['usuario_codigo']);
            if($list['validacion']!=0){
            $sheet->setCellValue("J{$contador}", $list['fecha_validacion']);
            }
            if($list['fecha_validacion']!="00/00/0000 00:00:00"){
            $sheet->setCellValue("K{$contador}", $list['lcheck']);    
            }
            $sheet->setCellValue("L{$contador}", $list['nom_status']);
            
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sedes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Cargo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/cargo/lista/index',$dato);
    }

    public function Lista_Cargo() {
        $tipo = $this->input->post("tipo"); 
        $dato['list_cargo'] = $this->Model_snappy->get_list_cargo($tipo);
        $this->load->view('Admin/cargo/lista/lista',$dato);
    }

    public function Excel_Cargo($tipo){
        $dato = $this->Model_snappy->get_list_cargo($tipo); 

        $contador = 1;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cargos');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15); 

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()
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

        $sheet->getStyle("A1:H1")->applyFromArray($styleThinBlackBorderOutline);


        $sheet->setCellValue("A{$contador}", 'Referencia');	   
        $sheet->setCellValue("B{$contador}", 'Fecha');	        
        $sheet->setCellValue("C{$contador}", 'De');
        $sheet->setCellValue("D{$contador}", 'Empresa Para');
        $sheet->setCellValue("E{$contador}", 'Sede Para');	        
        $sheet->setCellValue("F{$contador}", 'Usuario Para');
        $sheet->setCellValue("G{$contador}", 'Descripción');
        $sheet->setCellValue("H{$contador}", 'Estado');

        $contador=1;
        
        foreach($dato as $c){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $c['cod_cargo']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($c['fecha']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $c['usuario_de']);
            $sheet->setCellValue("D{$contador}", $c['empresa_1']);
            $sheet->setCellValue("E{$contador}", $c['sede_1']);
            $sheet->setCellValue("F{$contador}", $c['usuario_1']);
            $sheet->setCellValue("G{$contador}", $c['desc_cargo']);
            $sheet->setCellValue("H{$contador}", $c['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cargos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Agregar_Cargo()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_base_datos'] = $this->Model_snappy->get_list_base_datoss();
        $dato['list_base_datos_num'] = $this->Model_snappy->get_list_base_datos_num_todo();
        $dato['list_usuario'] = $this->Model_General->get_list_usuario();
        $dato['list_estado_cargo'] = $this->Model_General->get_list_estado_cargo();
        $dato['list_rubro'] = $this->Model_snappy->get_list_rubro();
        $dato['list_empresam'] = $this->Model_General->list_empresa();
        $this->Model_snappy->limpiar_temporal_cargo_archivos();

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
        
        $this->load->view('Admin/cargo/lista/vista_reg', $dato);
           
    }

    public function Buscar_Sede_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  strtoupper($this->input->post("id_empresa")); 
        
            $dato['list_sede']=$this->Model_snappy->get_list_sede_xempresa($dato);
            
            $this->load->view('Admin/cargo/lista/cmb_sede', $dato); 
            
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Sede_Cargo2(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  strtoupper($this->input->post("id_empresa2")); 
        
            $dato['list_sede']=$this->Model_snappy->get_list_sede_xempresa($dato);
            
            $this->load->view('Admin/cargo/lista/cmb_sede2', $dato); 
            
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Correo_Usuario_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario_1']=  $this->input->post("id_usuario_1"); 
        
            $dato['list_usuario1']=$this->Model_snappy->get_list_usuario1($dato);
            
            $this->load->view('Admin/cargo/lista/correo_usuario1', $dato); 
            
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Celular_Usuario_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario_1']=  $this->input->post("id_usuario_1"); 
        
            $dato['list_usuario1']=$this->Model_snappy->get_list_usuario1($dato);
            
            $this->load->view('Admin/cargo/lista/celular_usuario1', $dato); 
            
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Correo_Usuario2_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario_1']=  $this->input->post("id_usuario_2"); 
        
            $dato['list_usuario1']=$this->Model_snappy->get_list_usuario1($dato);
            
            $this->load->view('Admin/cargo/lista/correo_usuario2', $dato); 
            
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Celular_Usuario2_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario_1']=  $this->input->post("id_usuario_2"); 
        
            $dato['list_usuario1']=$this->Model_snappy->get_list_usuario1($dato);
            
            $this->load->view('Admin/cargo/lista/celular_usuario2', $dato); 
            
        }else{
            redirect('/login');
        }
    }


    public function Insert_Solo_Crear_Cargo(){ 
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
            $valida = $this->Model_snappy->valida_usuario_para($dato['id_usuario_1']);

            if(count($valida)>=10){
                echo "cantidad";
            }else{
                $dato['id_usuario_de']=  $this->input->post("id_usuario_de"); 
                $dato['id_empresa_1']=  $this->input->post("id_empresa"); 
                $dato['id_sede_1']= $this->input->post("id_sede"); 
                $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
                $dato['otro_1']= $this->input->post("otro_1"); 
                $dato['correo_1']= $this->input->post("correo_1"); 
                $dato['celular_1']= $this->input->post("celular_1"); 
                $dato['id_empresa_2']= $this->input->post("id_empresa2"); 
                $dato['id_sede_2']= $this->input->post("id_sede2"); 
                $dato['id_usuario_2']= $this->input->post("id_usuario_2"); 
                $dato['otro_2']= $this->input->post("otro_2");
                $dato['correo_2']= $this->input->post("correo_2"); 
                $dato['celular_2']= $this->input->post("celular_2"); 
                $dato['empresa_transporte']= $this->input->post("empresa_transporte"); 
                $dato['referencia']= $this->input->post("referencia"); 
                $dato['desc_cargo']= $this->input->post("desc_cargo"); 
                $dato['id_rubro']= $this->input->post("id_rubro"); 
                $descripcion= $this->input->post("desc_cargo"); 
                $dato['obs_cargo']= $this->input->post("obs_cargo");
                $observacion= $this->input->post("obs_cargo");
                $dato['estado']= 43;
    
                $dato['siguiente_cargo_ref'] = $this->Model_snappy->get_next_cargo();
                $dato['cod_cargo']=  $dato['siguiente_cargo_ref'][0]['next_cargo'];
                $cant=count($this->Model_snappy->valida_cargo($dato));
                if($cant>0){
                    echo "error";
                }else{
    
                    $this->Model_snappy->insert_cargo($dato);
                    
                    $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                    $id_cargo=$dato['get_codigo'][0]['id_cargo'];
                    
                    $dato['id_cargo']=$dato['get_codigo'][0]['id_cargo'];
                    $dato['id_estado']=43;
                    $dato['aprobado']=0;
                    $this->Model_snappy->insert_historial_cargo($dato);
                    
    
                    /*if($_FILES["archivos"]["name"] != ''){
                        $config['upload_path'] = './cargo/'.$dato['cod_cargo'].'/';
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                        }
                        $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                            for($count = 0; $count<count($_FILES["archivos"]["name"]); $count++){
                                $path = $_FILES["archivos"]["name"][$count];
                                $fecha=date('Y-m-d');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_archivo="archivo_cargo".$fecha.rand(10,200);
                                $nombre = $nombre_archivo.".".$ext;
                                $_FILES["file"]["name"] =  $nombre;
                                $_FILES["file"]["type"] = $_FILES["archivos"]["type"][$count];
                                $_FILES["file"]["tmp_name"] = $_FILES["archivos"]["tmp_name"][$count];
                                $_FILES["file"]["error"] = $_FILES["archivos"]["error"][$count];
                                $_FILES["file"]["size"] = $_FILES["archivos"]["size"][$count];
                                if($this->upload->do_upload('file')){
                                    $data = $this->upload->data();
                                    $dato['ruta'] = 'cargo/'.$dato['cod_cargo'].'/'.$nombre;
                                    $this->Model_snappy->insert_archivo_cargo($dato);
                                }
                            }
                    }*/
                    
                    $id_usuario=$dato['id_usuario_de'];
    
                    $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                    $correo=$dato['get_usuario'][0]['usuario_email'];
                    $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];
    
                    $id_usuario=$dato['id_usuario_1'];
                    $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                    $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
    
                    $id_empresa=$dato['id_empresa_1'];
                    $dato['get_id_empresa1'] = $this->Model_snappy->get_id_empresa($id_empresa);
                    $cod_empresa_1=$dato['get_id_empresa1'][0]['cod_empresa'];
    
                    $id_sede=$dato['id_sede_1'];
    
                    $dato['get_id_sede'] = $this->Model_snappy->get_id_sede_xid($id_sede);
                    $sede_1=$dato['get_id_sede'][0]['cod_sede'];
    
                    $dato['id_config']=3;
                    $dato['get_config'] = $this->Model_snappy->get_config($dato);
                    $url_base=$dato['get_config'][0]['url_config'];
    
                    $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                    $id_cargo= $encriptar($dato['get_codigo'][0]['id_cargo']);
                    
                    $mail = new PHPMailer(true);
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'Contactos2021@';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de registro de Cargos"); //desde donde se envia
                        //$mail->addAddress('Valerosa0409@gmail.com');
    
                        $mail->addAddress($correo);
    
                        $mail->isHTML(true);                                  // Set email format to HTML
    
                        $mail->Subject = "APROBACIÓN REGISTRO CARGO";
    
                        $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
            
                        
                        <b>Empresa:</b> '.$cod_empresa_1.'<br>
                        <b>Descripción:</b> '.$descripcion.'<br>
                        <b>Observación:</b> '.$observacion.'<br></span><br><br>
                                        
                                        <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo/'.$id_cargo.'/1"><button type="button" target="_blank" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Aprobar</button></a>
                                        <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo/'.$id_cargo.'/0"><button type="button" class="btn" style="background-color:red;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer"> Rechazar</button></a>
                                        <a href="'.$url_base.'index.php?/Snappy/Mensaje_Cargo/'.$id_cargo.'"><button type="button" class="btn" style="background-color:skyblue;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Mensaje</button></a>
                                        ';  
                                        
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                    echo $dato['cod_cargo'];
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Insert_Crear_yEnviar_Cargo(){
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $id_usuario_session=$_SESSION['usuario'][0]['id_usuario'];
            $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
            $valida = $this->Model_snappy->valida_usuario_para($dato['id_usuario_1']);

            if(count($valida)>=2){
                echo "cantidad";
            }else{       
                $dato['id_usuario_de']=  $this->input->post("id_usuario_de"); 
                $dato['id_empresa_1']=  $this->input->post("id_empresa"); 
                $dato['id_sede_1']= $this->input->post("id_sede"); 
                $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
                $dato['otro_1']= $this->input->post("otro_1"); 
                $dato['correo_1']= $this->input->post("correo_1"); 
                $dato['celular_1']= $this->input->post("celular_1"); 
                $dato['id_empresa_2']= $this->input->post("id_empresa2"); 
                $dato['id_sede_2']= $this->input->post("id_sede2"); 
                $dato['id_usuario_2']= $this->input->post("id_usuario_2"); 
                $dato['otro_2']= $this->input->post("otro_2");
                $dato['correo_2']= $this->input->post("correo_2"); 
                $dato['celular_2']= $this->input->post("celular_2"); 
                $dato['empresa_transporte']= $this->input->post("empresa_transporte"); 
                $dato['referencia']= $this->input->post("referencia"); 
                $dato['desc_cargo']= $this->input->post("desc_cargo"); 
                $dato['obs_cargo']= $this->input->post("obs_cargo");
                $dato['id_rubro']= $this->input->post("id_rubro");
                $descripcion= $this->input->post("desc_cargo"); 
                $observacion= $this->input->post("obs_cargo");
                $dato['estado']= 43;
    
                $dato['siguiente_cargo_ref'] = $this->Model_snappy->get_next_cargo();
                $dato['cod_cargo']=  $dato['siguiente_cargo_ref'][0]['next_cargo'];
    
                $cant=count($this->Model_snappy->valida_cargo($dato));
                if($cant>0){
                    echo "error";
                }else{
                    $this->Model_snappy->insert_cargo($dato);
    
                    $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                    $id_cargo=$dato['get_codigo'][0]['id_cargo'];
    
                    $dato['id_cargo']=$dato['get_codigo'][0]['id_cargo'];
                    $dato['id_estado']=43;
                    $dato['aprobado']=1;
                    $this->Model_snappy->insert_historial_cargo($dato);
                    $dato['id_estado']=44;
                    $dato['aprobado']=0;
                    $this->Model_snappy->insert_historial_cargo($dato);
                    $dato['id_estado']=45;
                    $dato['aprobado']=0;
                    $this->Model_snappy->insert_historial_cargo($dato);
                    
                    /*if($_FILES["archivos"]["name"] != ''){
                        $config['upload_path'] = './cargo/'.$dato['cod_cargo'].'/';
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                        }
                        $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                            for($count = 0; $count<count($_FILES["archivos"]["name"]); $count++){
                                $path = $_FILES["archivos"]["name"][$count];
                                $fecha=date('Y-m-d');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_archivo="archivo_cargo".$fecha.rand(10,200);
                                $nombre = $nombre_archivo.".".$ext;
                                $_FILES["file"]["name"] =  $nombre;
                                $_FILES["file"]["type"] = $_FILES["archivos"]["type"][$count];
                                $_FILES["file"]["tmp_name"] = $_FILES["archivos"]["tmp_name"][$count];
                                $_FILES["file"]["error"] = $_FILES["archivos"]["error"][$count];
                                $_FILES["file"]["size"] = $_FILES["archivos"]["size"][$count];
                                if($this->upload->do_upload('file')){
                                    $data = $this->upload->data();
                                    $dato['ruta'] = 'cargo/'.$dato['cod_cargo'].'/'.$nombre;
            
                                    $this->Model_snappy->insert_archivo_cargo($dato);
                                }
                            }
                    }*/
    
                    $id_usuario=$dato['id_usuario_de'];
                    $dato['cod_cargo']=$dato['cod_cargo'];
                    $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                    $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];
    
                    /* Usuario Para */
                    $id_usuario=$dato['id_usuario_1'];
                    $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                    $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
                    $correo1=$dato['get_usuario_1'][0]['usuario_email'];
    
                    $id_empresa=$dato['id_empresa_1'];
                    $dato['get_id_empresa1'] = $this->Model_snappy->get_id_empresa($id_empresa);
                    $cod_empresa_1=$dato['get_id_empresa1'][0]['cod_empresa'];
    
                    $id_sede=$dato['id_sede_1'];
    
                    $dato['get_id_sede'] = $this->Model_snappy->get_id_sede_xid($id_sede);
                    $sede_1=$dato['get_id_sede'][0]['cod_sede'];
    
                    /* General */
    
                    $dato['id_config']=3;
                    $dato['get_config'] = $this->Model_snappy->get_config($dato);
                    $url_base=$dato['get_config'][0]['url_config'];
    
    
                    $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                    $id_cargo= $encriptar($dato['get_codigo'][0]['id_cargo']);
                
                    $mail = new PHPMailer(true);
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'Contactos2021@';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                        //$mail->addAddress('Valerosa0409@gmail.com');
    
                        $mail->addAddress($correo1);
                        //$mail->addAddress('ruizandiap.idat@gmail.com');
    
                        $mail->isHTML(true);                                  // Set email format to HTML
    
                        $mail->Subject = "APROBACIÓN RECEPCIÓN";
    
                        $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
            
                        
                        <b>Empresa:</b> '.$cod_empresa_1.'<br>
                        <b>Descripción:</b> '.$descripcion.'<br>
                        <b>Observación:</b> '.$observacion.'<br></span><br><br>
                        <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                        <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                        
                        ';  
                                        
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
    
                    /* Usuario Transportista */
    
                    if($dato['id_usuario_2']!=0){
    
                        $id_usuario=$dato['id_usuario_2'];
                        $dato['get_usuario_2'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                        $usuario_codigo_2=$dato['get_usuario_2'][0]['usuario_codigo'];
                        $correo2=$dato['get_usuario_2'][0]['usuario_email'];
    
                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'Contactos2021@';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('webcontactos@gllg.edu.pe', "Envío de Cargo (Transportista)"); //desde donde se envia
                            //$mail->addAddress('Valerosa0409@gmail.com');
    
                            $mail->addAddress($correo2);
    
                            $mail->isHTML(true);                                  // Set email format to HTML
    
                            $mail->Subject = "ENVÍO DE CARGO";
    
                            $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
            
                            
                            <b>Empresa:</b> '.$cod_empresa_1.'<br>
                            <b>Descripción:</b> '.$descripcion.'<br>
                            <b>Observación:</b> '.$observacion.'<br></span><br><br>
                                            
                                            ';  
                                            
                            $mail->CharSet = 'UTF-8';
                            $mail->send();
                        } catch (Exception $e) {
                            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                        }
                    }
                    echo $dato['cod_cargo'];
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Vista_Upd_Cargo($id_cargo)
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);

        $dato['list_usuario'] = $this->Model_General->get_list_usuario();
        $dato['list_estado_cargo'] = $this->Model_General->get_list_estado_cargo();
        $dato['list_empresam'] = $this->Model_General->list_empresa();

        $dato['id_empresa']=  $dato['get_id'][0]['id_empresa_1'];
        
        $dato['list_sede1']=$this->Model_snappy->get_list_sede_xempresa($dato);

        $dato['id_empresa']=  $dato['get_id'][0]['id_empresa_2'];
        
        $dato['list_sede2']=$this->Model_snappy->get_list_sede_xempresa($dato);
        $dato['list_archivo'] = $this->Model_snappy->get_list_archivos_cargo($id_cargo);

        $dato['list_historial'] = $this->Model_snappy->get_list_cargo_historial($id_cargo);
        $dato['ultimo_historial'] = $this->Model_snappy->get_list_cargo_historial($id_cargo, 1);

        $dato['list_rubro'] = $this->Model_snappy->get_list_rubro();

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes(); 
        
        $this->load->view('Admin/cargo/lista/vista_upd', $dato);
            
        
    }

    public function Descargar_Imagen_Cargo($id_cargo_archivo) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_snappy->get_id_cargo_archivo($id_cargo_archivo);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Imagen_Cargo() {
        $id_cargo_archivo = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_snappy->get_id_cargo_archivo($id_cargo_archivo);

        if (file_exists($dato['get_file'][0]['archivo'])) {
            unlink($dato['get_file'][0]['archivo']);
        }
        $this->Model_snappy->delete_imagen_cargo($id_cargo_archivo);
    }

    public function Update_Cargo(){
        if ($this->session->userdata('usuario')) {
            
            $dato['id_cargo']=  $this->input->post("id_cargo"); 
            $dato['id_usuario_de']=  $this->input->post("id_usuario_de"); 
            $dato['cod_cargo']=  $this->input->post("cod_cargo"); 
            $dato['id_empresa_1']=  $this->input->post("id_empresa"); 
            $dato['id_sede_1']= $this->input->post("id_sede"); 
            $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
            $dato['otro_1']= $this->input->post("otro_1"); 
            $dato['correo_1']= $this->input->post("correo_1"); 
            $dato['celular_1']= $this->input->post("celular_1"); 
            $dato['id_empresa_2']= $this->input->post("id_empresa2"); 
            $dato['id_sede_2']= $this->input->post("id_sede2"); 
            $dato['id_usuario_2']= $this->input->post("id_usuario_2"); 
            $dato['otro_2']= $this->input->post("otro_2");
            $dato['correo_2']= $this->input->post("correo_2"); 
            $dato['celular_2']= $this->input->post("celular_2"); 
            $dato['empresa_transporte']= $this->input->post("empresa_transporte"); 
            $dato['referencia']= $this->input->post("referencia"); 
            $dato['desc_cargo']= $this->input->post("desc_cargo"); 
            $dato['obs_cargo']= $this->input->post("obs_cargo");
            $dato['id_rubro']= $this->input->post("id_rubro");
            $dato['estado']= 43;

            $cant=count($this->Model_snappy->valida_cargo_edit($dato));
            if($cant>0){
                echo "error";
            }else{
                $this->Model_snappy->update_cargo($dato);
                
                if($_FILES["archivos"]["name"] != ''){
                    $config['upload_path'] = './cargo/'.$dato['cod_cargo'].'/';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                    }
                    $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                        for($count = 0; $count<count($_FILES["archivos"]["name"]); $count++){
                            $path = $_FILES["archivos"]["name"][$count];
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_archivo="archivo_cargo".$fecha.rand(10,200);
                            $nombre = $nombre_archivo.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["archivos"]["type"][$count];
                            $_FILES["file"]["tmp_name"] = $_FILES["archivos"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["archivos"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["archivos"]["size"][$count];
                            if($this->upload->do_upload('file')){
                                $data = $this->upload->data();
                                $dato['ruta'] = 'cargo/'.$dato['cod_cargo'].'/'.$nombre;
        
                                $this->Model_snappy->insert_archivo_cargo($dato);
                            }
                        }
                }
                
            }
        }else{
            redirect('/login');
        }
    
    }

    public function Aprobar_Cargo($id_cargo,$ap){
        include "mcript.php";

        $id_usuario_session=$_SESSION['usuario'][0]['id_usuario'];
        $dato['id_cargo'] = $desencriptar($id_cargo);

        if($dato['id_cargo']!=""){
            $id_cargo = $dato['id_cargo'];
            $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);
            $dato['id_usuario'] = $dato['get_id'][0]['id_usuario_de'];

            $dato['id_estado']=43;
            $dato['get_historial'] = $this->Model_snappy->get_list_historial($dato);
            
            if($ap==1){
                if(count($dato['get_historial'])>0){
                    if($dato['get_historial'][0]['aprobado']==1 ){
                        $dato['mensaje']="El Cargo ya se encuentra aprobado.";
                        $dato['titulo']="Aprobación existente!";
                        $dato['tipo']="warning";
                    }else{
                        $dato['aprobado']=1;
                        $this->Model_snappy->update_historial_cargo($dato);
                        $dato['id_estado']=44;
                        $dato['aprobado']=1;
                        $this->Model_snappy->insert_historial_cargo($dato);
                        
                        
                        $id_usuario=$dato['get_id'][0]['id_usuario_de'];
                        $descripcion=$dato['get_id'][0]['desc_cargo'];
                        $observacion=$dato['get_id'][0]['obs_cargo'];
                        $dato['cod_cargo']=$dato['get_id'][0]['cod_cargo'];
                        $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                        //$correo=$dato['get_usuario'][0]['usuario_email'];
                        $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];

                        /* Usuario Para */
                        $id_usuario=$dato['get_id'][0]['id_usuario_1'];
                        $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                        $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
                        $correo1=$dato['get_usuario_1'][0]['usuario_email'];

                        $id_empresa=$dato['get_id'][0]['id_empresa_1'];
                        $dato['get_id_empresa1'] = $this->Model_snappy->get_id_empresa($id_empresa);
                        $cod_empresa_1=$dato['get_id_empresa1'][0]['cod_empresa'];

                        $id_sede=$dato['get_id'][0]['id_sede_1'];

                        $dato['get_id_sede'] = $this->Model_snappy->get_id_sede_xid($id_sede);
                        $sede_1=$dato['get_id_sede'][0]['cod_sede'];
                        
                        /* General */

                        $dato['id_config']=3;
                        $dato['get_config'] = $this->Model_snappy->get_config($dato);
                        $url_base=$dato['get_config'][0]['url_config'];

                        $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                        $id_cargo = $encriptar($dato['get_codigo'][0]['id_cargo']);

                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'Contactos2021@';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                            //$mail->addAddress('Valerosa0409@gmail.com');

                            $mail->addAddress($correo1);

                            $mail->isHTML(true);                                  // Set email format to HTML

                            $mail->Subject = "APROBACIÓN RECEPCIÓN";

                            $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                            
                            <b>Empresa:</b> '.$cod_empresa_1.'<br>
                            <b>Descripción:</b> '.$descripcion.'<br>
                            <b>Observación:</b> '.$observacion.'<br></span><br><br>
                                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                            
                                            ';  
                                            
                            $mail->CharSet = 'UTF-8';
                            $mail->send();
                        } catch (Exception $e) {
                            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                        }

                        /* Usuario Transportista */

                        if($dato['get_id'][0]['id_usuario_2']!=0){

                            $dato['id_estado']=45;
                            $dato['aprobado']=1;
                            $this->Model_snappy->insert_historial_cargo($dato);

                            $id_usuario=$dato['get_id'][0]['id_usuario_2'];
                            $dato['get_usuario_2'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                            $usuario_codigo_2=$dato['get_usuario_2'][0]['usuario_codigo'];
                            $correo2=$dato['get_usuario_2'][0]['usuario_email'];

                            $mail = new PHPMailer(true);
                            try {
                                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                                $mail->isSMTP();                                            // Send using SMTP
                                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                                $mail->Password   = 'Contactos2021@';                                // SMTP password
                                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                $mail->setFrom('webcontactos@gllg.edu.pe', "Envío de Cargo (Transportista)"); //desde donde se envia
                                //$mail->addAddress('Valerosa0409@gmail.com');

                                $mail->addAddress($correo2);

                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = "ENVÍO DE CARGO";

                                $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                                
                                <b>Empresa:</b> '.$cod_empresa_1.'<br>
                                <b>Descripción:</b> '.$descripcion.'<br>
                                <b>Observación:</b> '.$observacion.'<br></span><br><br>
                                                
                                                ';  
                                                
                                $mail->CharSet = 'UTF-8';
                                $mail->send();
                            } catch (Exception $e) {
                                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                            }
                        }

                        $dato['titulo']="Aprobación exitosa!";
                        $dato['tipo']="success";
                        $dato['mensaje']="Aprobación exitosa.";

                    }

                }
            }else{
                if($dato['get_historial'][0]['aprobado']!=2){
                    $dato['aprobado']= 2;
                    $dato['editado']= 1;
                    $this->Model_snappy->update_historial_cargo_rechazado($dato);
                    $dato['titulo']="Rechazado con éxito!";
                    $dato['tipo']="success";
                    $dato['mensaje']="El registro fue rechazado con éxito";
                }elseif($dato['get_historial'][0]['aprobado']==2){
                    $dato['titulo']="Desaprobación existente!";
                    $dato['tipo']="warning";
                    $dato['mensaje']="El Cargo ya estaba desaprobado anteriormente.";
                    
                }
            }

            $dato['list_cargo'] = $this->Model_snappy->get_list_cargo(2);

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('Admin/cargo/lista/aprobacion_post', $dato);
        }else{
            redirect('/login');
        } 
    }

    public function Aprobar_Cargo_Para($id_cargo,$usuario,$ap){
        include "mcript.php";

        $id_usuario_session=$usuario;
        $id_usuario= $usuario;
        $dato['id_usuario'] = $usuario;
        if($id_usuario>0){
            $dato['id_cargo'] = $desencriptar($id_cargo);
            //$dato['id_cargo'] = $id_cargo;
            if($dato['id_cargo']!=""){
                $id_cargo = $dato['id_cargo'];
                $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);
                
                $dato['id_estado']=46;
                $dato['get_historial'] = $this->Model_snappy->get_list_historial($dato);
    
                $id_empresa=$dato['get_id'][0]['id_empresa_1'];
                $dato['get_id_empresa1'] = $this->Model_snappy->get_id_empresa($id_empresa);
                $cod_empresa_1=$dato['get_id_empresa1'][0]['cod_empresa'];
    
                $descripcion=$dato['get_id'][0]['desc_cargo'];
                $observacion=$dato['get_id'][0]['obs_cargo'];
                if($ap==1){
                    if(count($dato['get_historial'])>0){
                        
                        if($dato['get_historial'][0]['aprobado']==1 ){
                            $dato['mensaje']="El Cargo ya estaba con recepción confirmada.";
                            $dato['titulo']="Recepción confirmada existente!";
                            $dato['tipo']="warning";
                        }else{
                            $dato['aprobado']=1;
                            $this->Model_snappy->update_historial_cargo($dato);
    
                            $id_usuario=$dato['get_id'][0]['id_usuario_de'];
                            $dato['cod_cargo']=$dato['get_id'][0]['cod_cargo'];
                            $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                            //$correo=$dato['get_usuario'][0]['usuario_email'];
                            $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];
    
                            
    
    
                            $id_usuario=$dato['get_id'][0]['id_usuario_1'];
                            $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                            $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
                            $correo1=$dato['get_usuario_1'][0]['usuario_email'];
    
                            $dato['id_config']=3;
                            $dato['get_config'] = $this->Model_snappy->get_config($dato);
                            $url_base=$dato['get_config'][0]['url_config'];
    
    
                            $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                            $id_cargo = $encriptar($dato['get_codigo'][0]['id_cargo']);
    
                            $mail = new PHPMailer(true);
                            try {
                                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                                $mail->isSMTP();                                            // Send using SMTP
                                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                                $mail->Password   = 'Contactos2021@';                                // SMTP password
                                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                                //$mail->addAddress('Valerosa0409@gmail.com');
    
                                $mail->addAddress($correo1);
    
                                $mail->isHTML(true);                                  // Set email format to HTML
    
                                $mail->Subject = "RECORDATORIO APROBACIÓN/CONFIRMACIÓN RECEPCIÓN";
    
                                $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
            
                                
                                <b>Empresa:</b> '.$cod_empresa_1.'<br>
                                <b>Descripción:</b> '.$descripcion.'<br>
                                <b>Observación:</b> '.$observacion.'<br></span>
                    
                                                <b>Recordatorio que está pendiente confirmar recepción de Cargo.<b><br>
                                                <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                                <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                                
                                                ';  
                                                
                                $mail->CharSet = 'UTF-8';
                                $mail->send();
                            } catch (Exception $e) {
                                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                            }
    
                            $dato['mensaje']="Cargo recepcionado";
                            $dato['titulo']="Recepción exitosa!";
                            $dato['tipo']="success";
                        }
                        
                    }else{
                        $dato['id_estado']=46;
                        $dato['aprobado']=1;
                        $this->Model_snappy->insert_historial_cargo_correo($dato);
    
                        $dato['mensaje']="Cargo solo recepcionado exitosamente.";
                        $dato['titulo']="Recepción de cargo exitosa!";
                        $dato['tipo']="success";
    
                        $id_usuario=$dato['get_id'][0]['id_usuario_de'];
                        $dato['cod_cargo']=$dato['get_id'][0]['cod_cargo'];
                        $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                        //$correo=$dato['get_usuario'][0]['usuario_email'];
                        $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];
    
                        $id_usuario=$dato['get_id'][0]['id_usuario_1'];
                        $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
                        $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
                        $correo1=$dato['get_usuario_1'][0]['usuario_email'];
    
                        $dato['id_config']=3;
                        $dato['get_config'] = $this->Model_snappy->get_config($dato);
                        $url_base=$dato['get_config'][0]['url_config'];
    
    
                        $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
                        $id_cargo= $encriptar($dato['get_codigo'][0]['id_cargo']);
    
                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'Contactos2021@';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                            //$mail->addAddress('Valerosa0409@gmail.com');
    
                            $mail->addAddress($correo1);
    
                            $mail->isHTML(true);                                  // Set email format to HTML
    
                            $mail->Subject = "RECORDATORIO APROBACIÓN/CONFIRMACIÓN RECEPCIÓN";
    
                            $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
            
                                
                                <b>Empresa:</b> '.$cod_empresa_1.'<br>
                                <b>Descripción:</b> '.$descripcion.'<br>
                                <b>Observación:</b> '.$observacion.'<br></span>
                
                                <b>Recordatorio que está pendiente confirmar recepción de Cargo.<b><br>
                                            
                                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                            
                                            ';  
                                            
                            $mail->CharSet = 'UTF-8';
                            $mail->send();
                        } catch (Exception $e) {
                            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                        }
                    }
    
                
                }else{
                    if(count($dato['get_historial'])>0){
    
                        $dato['id_estado']=47;
                        $dato['get_historial'] = $this->Model_snappy->get_list_historial($dato);
                        if(count($dato['get_historial'])>0){
                            $dato['mensaje']="El Cargo ya fue recibido y confirmado.";
                            $dato['titulo']="Recepción y confirmación existente!";
                        $dato['tipo']="warning";
                        }else{
                            $dato['id_estado']=47;
                            $dato['aprobado']=1;
                            $this->Model_snappy->insert_historial_cargo_correo($dato);
                            $dato['mensaje']="Cargo recibido y confirmado exitosamente.";
                            $dato['titulo']="Recepción y confirmación exitosa!";
                            $dato['tipo']="success";
                        }
                        
                    }else{
                        
                        $dato['id_estado']=47;
                        $dato['get_historial_47'] = $this->Model_snappy->get_list_historial($dato);
                        if(count($dato['get_historial'])>0 && count($dato['get_historial_47'])>0){
                            $dato['mensaje']="El Cargo ya fue recibido y confirmado.";
                            $dato['titulo']="Recepción y confirmación existente!";
                            $dato['tipo']="warning";
                        }else{
                            $dato['id_estado']=46;
                            $dato['aprobado']=1;
                            $this->Model_snappy->insert_historial_cargo_correo($dato);
        
                            $dato['id_estado']=47;
                            $dato['aprobado']=1;
                            $this->Model_snappy->insert_historial_cargo_correo($dato);
        
                            $dato['mensaje']="Cargo recibido y confirmado";
                            $dato['titulo']="Recepción y confirmación exitosa!";
                            $dato['tipo']="success";
                        }
                        
                    }
                }
    
                //$dato['list_cargo'] = $this->Model_snappy->get_list_cargo(2);
    
                //AVISO NO BORRAR
                /*$dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
                $dato['list_aviso'] = $this->Model_General->get_list_aviso();*/
    
                //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
                /*$nivel = $_SESSION['usuario'][0]['id_nivel'];
                $id_usuario = $_SESSION['usuario'][0]['id_usuario'];*/
                /*$dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
                $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
                $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
                $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
                $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();*/
                //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
                
                $this->load->view('Admin/cargo/lista/aprobacion_post', $dato);
            }else{
                redirect('/login');
            }
        }else{
            //redirect('/login');
        }
    }

    public function Mensaje_Cargo($id_cargo){
        include "mcript.php";
        
        $dato['id_cargo'] = $desencriptar($id_cargo);

        if($dato['id_cargo']!=""){
            $id_cargo = $dato['id_cargo'];
            $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);
            
            $dato['id_estado']=43;
            $dato['get_historial'] = $this->Model_snappy->get_list_historial($dato);

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('Admin/cargo/lista/popup_mensaje',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_mensaje_Cargo(){
        if ($this->session->userdata('usuario')) {
            
            $dato['id_cargo']=  $this->input->post("id");
            $dato['id_cargo_historial']=  $this->input->post("id_cargo_historial"); 
            $dato['mensaje']=  $this->input->post("obs"); 

            $this->Model_snappy->insert_mensaje_cargo($dato);
                
        }else{
            redirect('/login');
        }
    
    }

    public function Modal_Observacion_Cargo_Historial($id_cargo_h){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_cargo_historial($id_cargo_h);
            $this->load->view('Admin/cargo/lista/modal_obs', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Update_Obs_Cargo_Historial(){
        if ($this->session->userdata('usuario')) {
            
            $dato['id_cargo_historial']=  $this->input->post("id_cargo_historial"); 
            $dato['observacion']=  $this->input->post("obs"); 

            $this->Model_snappy->update_observacion_cargo_historial($dato);
                
        }else{
            redirect('/login');
        }
    
    }

    public function Reenviar_Email(){
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $id_cargo_h=  $this->input->post("id_cargo_historial"); 
            
            $dato['get_historial'] = $this->Model_snappy->get_id_cargo_historial($id_cargo_h);

            $id_cargo=$dato['get_historial'][0]['id_cargo'];

            $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);
            $id_usuario=$dato['get_id'][0]['id_usuario_de'];
            $descripcion=$dato['get_id'][0]['desc_cargo'];
            $observacion=$dato['get_id'][0]['obs_cargo'];

            $dato['get_usuario'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $correo=$dato['get_usuario'][0]['usuario_email'];
            $usuario_codigo_de=$dato['get_usuario'][0]['usuario_codigo'];

            $id_usuario=$dato['get_id'][0]['id_usuario_1'];
            $dato['get_usuario_1'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $usuario_codigo_1=$dato['get_usuario_1'][0]['usuario_codigo'];
            $correo_usuario_1=$dato['get_usuario_1'][0]['usuario_email'];

            $id_usuario=$dato['get_id'][0]['id_usuario_2'];
            $dato['get_usuario_2'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $usuario_codigo_2=$dato['get_usuario_2'][0]['usuario_codigo'];
            $correo_usuario_2=$dato['get_usuario_2'][0]['usuario_email'];

            $id_empresa=$dato['get_id'][0]['id_empresa_1'];
            $dato['get_id_empresa1'] = $this->Model_snappy->get_id_empresa($id_empresa);
            $cod_empresa_1=$dato['get_id_empresa1'][0]['cod_empresa'];

            $id_sede=$dato['get_id'][0]['id_sede_1'];

            $dato['get_id_sede'] = $this->Model_snappy->get_id_sede_xid($id_sede);
            $sede_1=$dato['get_id_sede'][0]['cod_sede'];

            $dato['id_config']=3;
            $dato['get_config'] = $this->Model_snappy->get_config($dato);
            $url_base=$dato['get_config'][0]['url_config'];

            $dato['cod_cargo']=$dato['get_id'][0]['cod_cargo'];
            $dato['get_codigo'] = $this->Model_snappy->get_cargo_xcodigo($dato);
            $id_cargo= $encriptar($dato['get_codigo'][0]['id_cargo']);

            if($dato['get_historial'][0]['id_estado']==43){
            
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'Contactos2021@';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de registro de Cargos"); //desde donde se envia
                    //$mail->addAddress('Valerosa0409@gmail.com');

                    $mail->addAddress($correo);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN REGISTRO CARGO";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                    
                    <b>Empresa:</b> '.$cod_empresa_1.'<br>
                    <b>Descripción:</b> '.$descripcion.'<br>
                    <b>Observación:</b> '.$observacion.'<br></span>

                                    <br><br>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo/'.$id_cargo.'/1"><button type="button" target="_blank" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Aprobar</button></a>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo/'.$id_cargo.'/0"><button type="button" class="btn" style="background-color:red;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer"> Rechazar</button></a>
                                    <a href="'.$url_base.'index.php?/Snappy/Mensaje_Cargo/'.$id_cargo.'"><button type="button" class="btn" style="background-color:skyblue;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Mensaje</button></a>
                                    ';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }elseif($dato['get_historial'][0]['id_estado']==44){

                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'Contactos2021@';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                    //$mail->addAddress('Valerosa0409@gmail.com');

                    $mail->addAddress($correo_usuario_1);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                    
                    <b>Empresa:</b> '.$cod_empresa_1.'<br>
                    <b>Descripción:</b> '.$descripcion.'<br>
                    <b>Observación:</b> '.$observacion.'<br></span>

                                    <br><br>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                    
                                    ';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }

            }elseif($dato['get_historial'][0]['id_estado']==45){
                if($dato['get_id'][0]['id_usuario_2']!=0){

               
                    $mail = new PHPMailer(true);
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'Contactos2021@';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('webcontactos@gllg.edu.pe', "Envío de Cargo (Transportista)"); //desde donde se envia
                        //$mail->addAddress('Valerosa0409@gmail.com');

                        $mail->addAddress($correo_usuario_2);

                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = "ENVÍO DE CARGO";

                        $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                        
                        <b>Empresa:</b> '.$cod_empresa_1.'<br>
                        <b>Descripción:</b> '.$descripcion.'<br>
                        <b>Observación:</b> '.$observacion.'<br></span>
    
                                        <br><br>
                                        
                                        ';  
                                        
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                }
            }elseif($dato['get_historial'][0]['id_estado']==46){

                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'Contactos2021@';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                    //$mail->addAddress('Valerosa0409@gmail.com');

                    $mail->addAddress($correo_usuario_1);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                    
                    <b>Empresa:</b> '.$cod_empresa_1.'<br>
                    <b>Descripción:</b> '.$descripcion.'<br>
                    <b>Observación:</b> '.$observacion.'<br></span>

                                    <br><br>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                    
                                    ';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }elseif($dato['get_historial'][0]['id_estado']==47){
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'Contactos2021@';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia
                    //$mail->addAddress('Valerosa0409@gmail.com');

                    $mail->addAddress($correo_usuario_1);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['cod_cargo'].'<br>
        
                    
                    <b>Empresa:</b> '.$cod_empresa_1.'<br>
                    <b>Descripción:</b> '.$descripcion.'<br>
                    <b>Observación:</b> '.$observacion.'<br></span>

                                    <br><br>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$id_usuario_session.'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>
                                    
                                    ';  
                                    
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

    function escaner_articulo(){
        $this->load->model('articulo_model');
        
        $codigo = $_POST['codigoEscaneado'];
        
        $data = "prueba";//$this->articulo_model->obtener_articulo_codigo($codigo);
        echo json_encode($data);
    }

    public function Scanner(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('Admin/inventario/scanner/index2');   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    public function Leer(){
            $this->load->view('Admin/inventario/scanner/leer');   
        
    }

    public function Validar_Codigo_Scanner() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['get_referencia'] = $this->Model_snappy->get_ultimo_codigo_inventario();
        $dato['letra']=$dato['get_referencia'][0]['letra'];

        $dato['codigo_barra']= $this->input->post("codigo");
        $dato['get_id'] = $this->Model_snappy->get_list_inventario_xcodigo($dato);
        $dato['get_ac'] = $this->Model_snappy->get_list_inventario_xcodigo_activo($dato);

        if(count($dato['get_id'])<1){
            echo "1";
        }else{
            if(count($dato['get_ac'])>0){
                echo "2";
            }else{
                $this->Model_snappy->update_validacion_inventario_scanner($dato);
            }
        }
    }

    public function Modal_archivo_cargo($id_cargo){
        if ($this->session->userdata('usuario')) {
            $dato['id_cargo']=$id_cargo;
            $this->load->view('Admin/cargo/lista/modal_archivo',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_archivo_cargo(){
        $dato['id_cargo']= $this->input->post("id_cargo"); 
        $id_cargo= $this->input->post("id_cargo"); 
        $dato['archivo']= $this->input->post("archivo"); 
        $dato['nom_archivo']= $this->input->post("nom_archivo");
        $dato['get_id'] = $this->Model_snappy->get_id_cargo($id_cargo);
        $dato['cod_cargo']=$dato['get_id'][0]['cod_cargo'];
        $contar=count($this->Model_snappy->valida_cargo_archivo($dato));
        $contar2=count($this->Model_snappy->valida_cargo_archivo2($dato));

        if($contar>0){
            echo "error";
        }elseif($contar2>4){
            echo "1";
        }else{
            $this->Model_snappy->insert_archivo_cargo2($dato);
        }
    }

    public function Preguardar_Documento_Cargo()
    {
        if ($this->session->userdata('usuario')) {
            
            $dato['nombre'] = $this->input->post("nom_documento");
            $cant=count($this->Model_snappy->valida_preinsert_documento_cargo($dato));
            $cant2=count($this->Model_snappy->valida_preinsert_documento_cargo2($dato));
            if($cant>0){
                echo "error";
            }elseif($cant2>4){
                echo "1";
            }else{
                $this->Model_snappy->preinsert_archivo_cargo($dato);
            }
            
        } else {
            redirect('/login');
        }
    }

    public function List_Preguardado_Documento_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_temporal']=$this->Model_snappy->List_preinsert_documento_cargo();
            $this->load->view('Admin/cargo/lista/div_temporal',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Imagen_Cargo_Temporal($id_temporal_c) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_snappy->get_id_cargo_archivo_temporal($id_temporal_c);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Imagen_Cargo_Temporal() {
        $id_temporal_c = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_snappy->get_id_cargo_archivo_temporal($id_temporal_c);

        if (file_exists($dato['get_file'][0]['archivo'])) {
            unlink($dato['get_file'][0]['archivo']);
        }
        $this->Model_snappy->delete_imagen_cargo_temporal($id_temporal_c);
    }

    public function Modal_archivo_cargo_reg(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('Admin/cargo/lista/modal_archivo_reg');
        }else{
            redirect('/login');
        }
    }

    public function Delete_Cargo(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_cargo']= $this->input->post("id_cargo");
            $this->Model_snappy->delete_cargo($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Reporte_mensual_Instagram(){
        $dato['id_empresa']= $this->input->post('id_empresa');
        $dato['nom_anio']= $this->input->post('nom_anio');
        $dato['id_mes']= $this->input->post('id_mes');

        $this->load->view('Admin/informe/redes_instagram/lista',$dato);
    }

    public function Redes_Mensual_Instagram() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
        if($id_nivel==1 || $id_nivel==2 || $id_nivel==3 || $id_nivel==4 || $id_nivel==6 || $id_nivel==12){
            $dato['list_empresam'] = $this->Model_snappy->get_list_iempresa();
        }elseif($id_nivel==7){
            $dato['list_empresam'] = $this->Model_snappy->get_list_iempresa($id_nivel);
        }

        $dato['list_meses'] = $this->Model_snappy->get_list_meses();
        $dato['list_anios'] = $this->Model_snappy->get_list_anio();
        
        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/informe/redes_instagram/index',$dato);
    }

    public function Excel_Reporte_Mensual_Instagram($id_empresa,$nom_anio,$id_mes){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anio= $nom_anio;
        $dato['id_empresa'] = $id_empresa;
        $row_t = $this->Model_snappy->get_row_t($dato);
        $totalRows_t = count($row_t);

        $dia1 = strtotime($anio.'-'.$id_mes.'-01');
        $nom_mes=substr($meses[date('n', $dia1)-1],0,3);

        if($totalRows_t<1){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->setTitle('Reporte Mensual Instagram');
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->setCellValue("A1", "No existen registros para mostrar");  
        }else{
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:AG2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:AG2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Reporte Mensual Instagram');

            //$sheet->setAutoFilter('A1:AG1');
    
            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(8);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(8);
            $sheet->getColumnDimension('H')->setWidth(8);
            $sheet->getColumnDimension('I')->setWidth(8);
            $sheet->getColumnDimension('J')->setWidth(8);
            $sheet->getColumnDimension('K')->setWidth(8);
            $sheet->getColumnDimension('L')->setWidth(8);
            $sheet->getColumnDimension('M')->setWidth(8);
            $sheet->getColumnDimension('N')->setWidth(8);
            $sheet->getColumnDimension('O')->setWidth(8);
            $sheet->getColumnDimension('P')->setWidth(8);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(8);
            $sheet->getColumnDimension('S')->setWidth(8);
            $sheet->getColumnDimension('T')->setWidth(8);
            $sheet->getColumnDimension('U')->setWidth(8);
            $sheet->getColumnDimension('V')->setWidth(8);
            $sheet->getColumnDimension('W')->setWidth(8);
            $sheet->getColumnDimension('X')->setWidth(8);
            $sheet->getColumnDimension('Y')->setWidth(8);
            $sheet->getColumnDimension('Z')->setWidth(8);
            $sheet->getColumnDimension('AA')->setWidth(8);
            $sheet->getColumnDimension('AB')->setWidth(8);
            $sheet->getColumnDimension('AC')->setWidth(8);
            $sheet->getColumnDimension('AD')->setWidth(8);
            $sheet->getColumnDimension('AE')->setWidth(8);
            $sheet->getColumnDimension('AF')->setWidth(8);
            $sheet->getColumnDimension('AG')->setWidth(8);

            $sheet->getStyle('A1:AG1')->getFont()->setBold(true);  
    
            /*$spreadsheet->getActiveSheet()->getStyle("A1:AG1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');*/
    
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("C1:AG2")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("C1", "1-".$nom_mes);  
            $sheet->setCellValue("D1", "2-".$nom_mes);  
            $sheet->setCellValue("E1", "3-".$nom_mes);  
            $sheet->setCellValue("F1", "4-".$nom_mes);  
            $sheet->setCellValue("G1", "5-".$nom_mes);  
            $sheet->setCellValue("H1", "6-".$nom_mes);  
            $sheet->setCellValue("I1", "7-".$nom_mes);  
            $sheet->setCellValue("J1", "8-".$nom_mes);  
            $sheet->setCellValue("K1", "9-".$nom_mes);  
            $sheet->setCellValue("L1", "10-".$nom_mes);  
            $sheet->setCellValue("M1", "11-".$nom_mes);  
            $sheet->setCellValue("N1", "12-".$nom_mes);  
            $sheet->setCellValue("O1", "13-".$nom_mes);  
            $sheet->setCellValue("P1", "14-".$nom_mes);  
            $sheet->setCellValue("Q1", "15-".$nom_mes);  
            $sheet->setCellValue("R1", "16-".$nom_mes);  
            $sheet->setCellValue("S1", "17-".$nom_mes);  
            $sheet->setCellValue("T1", "18-".$nom_mes);  
            $sheet->setCellValue("U1", "19-".$nom_mes);  
            $sheet->setCellValue("V1", "20-".$nom_mes);  
            $sheet->setCellValue("W1", "21-".$nom_mes);  
            $sheet->setCellValue("X1", "22-".$nom_mes);  
            $sheet->setCellValue("Y1", "23-".$nom_mes);  
            $sheet->setCellValue("Z1", "24-".$nom_mes);  
            $sheet->setCellValue("AA1", "25-".$nom_mes);  
            $sheet->setCellValue("AB1", "26-".$nom_mes);  
            $sheet->setCellValue("AC1", "27-".$nom_mes);  
            $sheet->setCellValue("AD1", "28-".$nom_mes);  
            $sheet->setCellValue("AE1", "29-".$nom_mes);  
            $sheet->setCellValue("AF1", "30-".$nom_mes);  
            $sheet->setCellValue("AG1", "31-".$nom_mes);  

            $sheet->setCellValue("C2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-01'))], 0, 1)); 
            $sheet->setCellValue("D2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-02'))], 0, 1)); 
            $sheet->setCellValue("E2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-03'))], 0, 1));
            $sheet->setCellValue("F2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-04'))], 0, 1));  
            $sheet->setCellValue("G2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-05'))], 0, 1));  
            $sheet->setCellValue("H2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-06'))], 0, 1));  
            $sheet->setCellValue("I2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-07'))], 0, 1));  
            $sheet->setCellValue("J2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-08'))], 0, 1));  
            $sheet->setCellValue("K2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-09'))], 0, 1));  
            $sheet->setCellValue("L2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-10'))], 0, 1));  
            $sheet->setCellValue("M2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-11'))], 0, 1));  
            $sheet->setCellValue("N2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-12'))], 0, 1));  
            $sheet->setCellValue("O2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-13'))], 0, 1));  
            $sheet->setCellValue("P2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-14'))], 0, 1));  
            $sheet->setCellValue("Q2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-15'))], 0, 1));  
            $sheet->setCellValue("R2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-16'))], 0, 1));  
            $sheet->setCellValue("S2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-17'))], 0, 1));  
            $sheet->setCellValue("T2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-18'))], 0, 1));  
            $sheet->setCellValue("U2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-19'))], 0, 1));  
            $sheet->setCellValue("V2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-20'))], 0, 1));  
            $sheet->setCellValue("W2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-21'))], 0, 1));  
            $sheet->setCellValue("X2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-22'))], 0, 1));  
            $sheet->setCellValue("Y2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-23'))], 0, 1));  
            $sheet->setCellValue("Z2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-24'))], 0, 1));  
            $sheet->setCellValue("AA2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-25'))], 0, 1));  
            $sheet->setCellValue("AB2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-26'))], 0, 1));  
            $sheet->setCellValue("AC2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-27'))], 0, 1));  
            $sheet->setCellValue("AD2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-28'))], 0, 1));  
            $sheet->setCellValue("AE2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-29'))], 0, 1));  
            $sheet->setCellValue("AF2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-30'))], 0, 1));  
            $sheet->setCellValue("AG2", substr($dias[date('w', strtotime($anio.'-'.$id_mes.'-31'))], 0, 1)); 

            $i=3;

            foreach($row_t as $list){
                $fila=($i-1)+$list['total'];

                $sheet->mergeCells("A{$i}:A{$fila}");
                $sheet->getStyle("A{$i}:A{$fila}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$i}:A{$fila}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("B{$i}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("C{$i}:AG{$i}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$i}:AG{$i}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("C{$i}:AG{$i}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$i}", $list['nom_tipo']);
                $sheet->setCellValue("B{$i}", $list['nom_subtipo']);

                $dia1 = strtotime($anio.'-'.$id_mes.'-01');
                $dia=$anio.'-'.$id_mes.'-01';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("C{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("C{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-02');
                $dia=$anio.'-'.$id_mes.'-02';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("D{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("D{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-03');
                $dia=$anio.'-'.$id_mes.'-03';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("E{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("E{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-04');
                $dia=$anio.'-'.$id_mes.'-04';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("F{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("F{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-05');
                $dia=$anio.'-'.$id_mes.'-05';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("G{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("G{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-06');
                $dia=$anio.'-'.$id_mes.'-06';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("H{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("H{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-07');
                $dia=$anio.'-'.$id_mes.'-07';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("I{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("I{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-08');
                $dia=$anio.'-'.$id_mes.'-08';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("J{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("J{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-09');
                $dia=$anio.'-'.$id_mes.'-09';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("K{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("K{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-10');
                $dia=$anio.'-'.$id_mes.'-10';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("L{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("L{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-11');
                $dia=$anio.'-'.$id_mes.'-11';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("M{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("M{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-12');
                $dia=$anio.'-'.$id_mes.'-12';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("N{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("N{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-13');
                $dia=$anio.'-'.$id_mes.'-13';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("O{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("O{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-14');
                $dia=$anio.'-'.$id_mes.'-14';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("P{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("P{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-15');
                $dia=$anio.'-'.$id_mes.'-15';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Q{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Q{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-16');
                $dia=$anio.'-'.$id_mes.'-16';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("R{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("R{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-17');
                $dia=$anio.'-'.$id_mes.'-17';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("S{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("S{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-18');
                $dia=$anio.'-'.$id_mes.'-18';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("T{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("T{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-19');
                $dia=$anio.'-'.$id_mes.'-19';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("U{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("U{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-20');
                $dia=$anio.'-'.$id_mes.'-20';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("V{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("V{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-21');
                $dia=$anio.'-'.$id_mes.'-21';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("W{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("W{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-22');
                $dia=$anio.'-'.$id_mes.'-22';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("X{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("X{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-23');
                $dia=$anio.'-'.$id_mes.'-23';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Y{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Y{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-24');
                $dia=$anio.'-'.$id_mes.'-24';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("Z{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("Z{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-25');
                $dia=$anio.'-'.$id_mes.'-25';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AA{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AA{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-26');
                $dia=$anio.'-'.$id_mes.'-26';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AB{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AB{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-27');
                $dia=$anio.'-'.$id_mes.'-27';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AC{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AC{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-28');
                $dia=$anio.'-'.$id_mes.'-28';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AD{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AD{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-29');
                $dia=$anio.'-'.$id_mes.'-29';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AE{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AE{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-30');
                $dia=$anio.'-'.$id_mes.'-30';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AF{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AF{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                $dia1 = strtotime($anio.'-'.$id_mes.'-31');
                $dia=$anio.'-'.$id_mes.'-31';
                $nom_dia1=$dias[date('w', $dia1)];
                if(substr($nom_dia1, 0, 1)=="D"){ 
                    $spreadsheet->getActiveSheet()->getStyle("AG{$i}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                }
                $id_subtipop=$list['id_subtipo'];
                $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp = count($row_tp);
                $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                $totalRows_tp1 = count($row_tp1);
                if($totalRows_tp>0){
                    $sheet->setCellValue("AG{$i}", $totalRows_tp1." | ".$totalRows_tp);
                }

                //--------------------SUBTIPOS-----------------------
                $dato['id_tipo']=$list['id_tipo'];
                $dato['id_subtipo']=$list['id_subtipo'];

                $list_subtipo = $this->Model_snappy->get_list_subtipos_redes($dato);

                $j=$i+1;

                foreach($list_subtipo as $sub){
                    $sheet->getStyle("B{$j}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("C{$j}:AG{$j}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C{$j}:AG{$j}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("C{$j}:AG{$j}")->applyFromArray($styleThinBlackBorderOutline);

                    $sheet->setCellValue("B{$j}", $sub['nom_subtipo']);

                    $dia1 = strtotime($anio.'-'.$id_mes.'-01');
                    $dia=$anio.'-'.$id_mes.'-01';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("C{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("C{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-02');
                    $dia=$anio.'-'.$id_mes.'-02';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("D{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("D{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-03');
                    $dia=$anio.'-'.$id_mes.'-03';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("E{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("E{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-04');
                    $dia=$anio.'-'.$id_mes.'-04';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("F{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("F{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-05');
                    $dia=$anio.'-'.$id_mes.'-05';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("G{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("G{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-06');
                    $dia=$anio.'-'.$id_mes.'-06';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("H{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("H{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-07');
                    $dia=$anio.'-'.$id_mes.'-07';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("I{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("I{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-08');
                    $dia=$anio.'-'.$id_mes.'-08';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("J{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("J{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-09');
                    $dia=$anio.'-'.$id_mes.'-09';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("K{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("K{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-10');
                    $dia=$anio.'-'.$id_mes.'-10';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("L{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("L{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-11');
                    $dia=$anio.'-'.$id_mes.'-11';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("M{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("M{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-12');
                    $dia=$anio.'-'.$id_mes.'-12';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("N{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("N{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-13');
                    $dia=$anio.'-'.$id_mes.'-13';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("O{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("O{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-14');
                    $dia=$anio.'-'.$id_mes.'-14';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("P{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("P{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-15');
                    $dia=$anio.'-'.$id_mes.'-15';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Q{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Q{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-16');
                    $dia=$anio.'-'.$id_mes.'-16';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("R{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("R{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-17');
                    $dia=$anio.'-'.$id_mes.'-17';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("S{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("S{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-18');
                    $dia=$anio.'-'.$id_mes.'-18';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("T{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("T{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-19');
                    $dia=$anio.'-'.$id_mes.'-19';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("U{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("U{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-20');
                    $dia=$anio.'-'.$id_mes.'-20';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("V{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("V{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-21');
                    $dia=$anio.'-'.$id_mes.'-21';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("W{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("W{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-22');
                    $dia=$anio.'-'.$id_mes.'-22';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("X{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("X{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-23');
                    $dia=$anio.'-'.$id_mes.'-23';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Y{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Y{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-24');
                    $dia=$anio.'-'.$id_mes.'-24';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("Z{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("Z{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-25');
                    $dia=$anio.'-'.$id_mes.'-25';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AA{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AA{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-26');
                    $dia=$anio.'-'.$id_mes.'-26';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AB{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AB{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-27');
                    $dia=$anio.'-'.$id_mes.'-27';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AC{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AC{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-28');
                    $dia=$anio.'-'.$id_mes.'-28';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AD{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AD{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-29');
                    $dia=$anio.'-'.$id_mes.'-29';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AE{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AE{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }
    
                    $dia1 = strtotime($anio.'-'.$id_mes.'-30');
                    $dia=$anio.'-'.$id_mes.'-30';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AF{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AF{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }

                    $dia1 = strtotime($anio.'-'.$id_mes.'-31');
                    $dia=$anio.'-'.$id_mes.'-31';
                    $nom_dia1=$dias[date('w', $dia1)];
                    if(substr($nom_dia1, 0, 1)=="D"){ 
                        $spreadsheet->getActiveSheet()->getStyle("AG{$j}")->getFill() ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
                    }
                    $id_subtipop=$sub['id_subtipo'];
                    $row_tp = $this->Model_snappy->primera_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp = count($row_tp);
                    $row_tp1 = $this->Model_snappy->segunda_sentencia($id_empresa,$dia,$id_subtipop);
                    $totalRows_tp1 = count($row_tp1);
                    if($totalRows_tp>0){
                        $sheet->setCellValue("AG{$j}", $totalRows_tp1." | ".$totalRows_tp);
                    }

                    $j++;
                }
                //---------------------------------------------------

                $i=$fila;
                $i++;
            }

        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Reporte Redes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Carpeta() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_agenda'] = $this->Model_snappy->get_list_agenda(); 
        $dato['list_empresa_proyecto'] = $this->Model_snappy->get_list_empresa_agenda();

        //AVISO NO BORRAR

        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Model_General->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Model_General->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Model_General->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_General->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

        $this->load->view('Admin/carpeta/index',$dato);
    }

    public function Lista_Carpetas() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_carpetas'] = $this->Model_snappy->get_list_carpetas(null,1); 
        $this->load->view('Admin/carpeta/lista',$dato);
    }

    public function Modal_Insert_Carpeta(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado_archivos();
            $this->load->view('Admin/carpeta/modal_registrar', $dato);
        }else{
            redirect('/login');
        }
    }


    public function Insert_Carpeta(){
        if ($this->session->userdata('usuario')) {

            $dato['nom_carpeta']= $this->input->post("nom_carpeta_i");
            $dato['inicio_carpeta']= $this->input->post("inicio_carpeta_i");
            $dato['fin_carpeta']= $this->input->post("fin_carpeta_i");
            $dato['bloqueo_carpeta']= $this->input->post("bloqueo_carpeta_i");
            $dato['estado']= $this->input->post("estado_i");

            $total=count($this->Model_snappy->valida_carpeta($dato,1));

            if($total>0){
                echo "error";
            }else{
                $this->Model_snappy->insert_carpeta($dato);
            }
        }else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Carpeta($id_carpeta){
        if ($this->session->userdata('usuario')) {
            $dato['id_carpeta']=$id_carpeta;
            $dato['list_estado'] = $this->Model_snappy->get_list_estado_archivos();
            $dato['get_id'] = $this->Model_snappy->get_list_carpetas($dato,2); 
            $this->load->view('Admin/carpeta/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Carpeta(){
        if ($this->session->userdata('usuario')) {
            $dato['id_carpeta']= $this->input->post("id_carpeta");
            $dato['nom_carpeta']= $this->input->post("nom_carpeta_u");
            $dato['inicio_carpeta']= $this->input->post("inicio_carpeta_u");
            $dato['fin_carpeta']= $this->input->post("fin_carpeta_u");
            $dato['bloqueo_carpeta']= $this->input->post("bloqueo_carpeta_u");
            $dato['estado']= $this->input->post("estado_u");

            $total=count($this->Model_snappy->valida_carpeta($dato,2));

            if($total>0){
                echo "error";
            }else{
                $this->Model_snappy->update_carpeta($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Carpeta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_carpeta'] = $this->input->post("id_carpeta");
            $this->Model_snappy->delete_carpeta($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Carpeta(){

        $list_carpetas = $this->Model_snappy->get_list_carpetas(null,1); 

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:F2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:F2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Carpetas');

        $sheet->setAutoFilter('B2:F2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

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
          

        $sheet->setCellValue("B2", 'Nombre');;
        $sheet->setCellValue("C2", 'Inicio');
        $sheet->setCellValue("D2", 'Fin');;
        $sheet->setCellValue("E2", 'Bloqueado');
        $sheet->setCellValue("F2", 'Estado');

        $contador=2;
        
        foreach($list_carpetas as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['nom_carpeta']);
            $sheet->setCellValue("C{$contador}", $list['inicio_carpeta']);
            $sheet->setCellValue("D{$contador}", $list['fin_carpeta']);
            $sheet->setCellValue("E{$contador}", $list['bloqueo_carpeta_nombre']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Carpetas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
}