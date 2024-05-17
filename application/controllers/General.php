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

class General extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_General');
        $this->load->model('Model_snappy');
        $this->load->model('Admin_model');
        $this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
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

    public function index(){
        if ($this->session->userdata('usuario')) {
            $dato['fondo'] = $this->Model_snappy->get_confg_fondo();
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $this->load->view('general/administrador/index',$dato);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    //---------------------------------------------EMPRESAS-------------------------------------------
    public function Empresas() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_empresai'] = $this->Model_General->list_empresa();

        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $this->load->view('general/empresas/index',$dato);
    }

    public function Modal_Empresas(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_mes'] = $this->Model_General->get_list_mes();
            $dato['list_anio'] = $this->Model_General->get_list_anio();
            $this->load->view('general/empresas/modal_empresas', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_Empresa(){
        $dato['cd_empresa']= $this->input->post("cd_empresa");
        $dato['empresa']= $this->input->post("nombre");
        $dato['nom_empresa']= $this->input->post("nom_empresa");
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['ruc']= $this->input->post("ruc");  
        $dato['web']= $this->input->post("web");
        $dato['rep_redes']= $this->input->post("rep_redes");
        $dato['rep_sunat']= $this->input->post("rep_sunat");
        $dato['balance']= $this->input->post("balance");
        $dato['orden_menu']= $this->input->post("orden_menu"); 
        $dato['estado']= $this->input->post("estado");
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['cuenta_bancaria']= $this->input->post("cuenta_bancaria");
        $dato['color']= $this->input->post("color");
        $dato['fecha_inicio']= $this->input->post("fecha_inicio");

        if($this->input->post("inicio")==0){
            $dato['mes']="";
            $dato['anio']="";
        }else{
            $inicio=explode("/",$this->input->post("inicio"));
            $dato['mes']=$inicio[0];
            $dato['anio']=$inicio[1];
        }

        $total=count($this->Model_General->valida_reg_codempre($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_empresa($dato);
            if($dato['cuenta_bancaria']!="" && $this->input->post("inicio")!=0){
                $ultimo=$this->Model_General->ultimo_id_empresa();
                $dato['id_empresa']=$ultimo[0]['id_empresa'];
                $this->Admin_model->insert_estado_bancario($dato);

                //---------------INSERT DETALLE ESTADO BANCARIO-------------------

                $fecha_inicio=explode("/",$this->input->post("inicio"));
                $mes_inicio=$fecha_inicio[0];
                $anio_inicio=$fecha_inicio[1];
                $fecha_ini=$anio_inicio."-".$mes_inicio."-01";
                $fecha_fin=date('Y')."-".date('m')."-01";

                $diferencia = date_diff(date_create($fecha_ini),date_create($fecha_fin));
                $cantidad_meses= $diferencia->m;
                $cantidad_anios= $diferencia->y;
                $cantidad_real=$cantidad_meses+($cantidad_anios*12);

                $ultimo=$this->Admin_model->ultimo_id_estado_bancario();
                $dato['id_estado_bancario']=$ultimo[0]['id_estado_bancario'];

                $repetidor=0;

                while($repetidor<$cantidad_real){
                    $fecha = new DateTime($fecha_ini);
                    $fecha->add(new DateInterval('P'.$repetidor.'M'));
                    $dato['anio_detalle']=substr($fecha->format('Y-m-d'),0,4);
                    $dato['mes_detalle']=substr($fecha->format('Y-m-d'),5,2);

                    $this->Admin_model->insert_detalle_estado_bancario($dato);
                    $repetidor++;
                }
                
            }
        }
    }

    public function Modal_Update_Empresa($id_empresa){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['get_id'] = $this->Model_General->get_id_empresa($id_empresa);
            $dato['list_mes'] = $this->Model_General->get_list_mes();
            $dato['list_anio'] = $this->Model_General->get_list_anio();
            $this->load->view('general/empresas/upd_modal_empresas', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Update_Empresa(){
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['cd_empresa']= $this->input->post("cd_empresa");
        $dato['empresa']= $this->input->post("nombre");
        $dato['nom_empresa']= $this->input->post("nom_empresa");
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['ruc']= $this->input->post("ruc");  
        $dato['web']= $this->input->post("web");
        $dato['rep_redes']= $this->input->post("rep_redes");
        $dato['rep_sunat']= $this->input->post("rep_sunat");
        $dato['balance']= $this->input->post("balance");
        $dato['orden_menu']= $this->input->post("orden_menu"); 
        $dato['estado']= $this->input->post("estado");
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['imagen_actual']= $this->input->post("imagen_actual");
        $dato['cuenta_bancaria']= $this->input->post("cuenta_bancaria");
        $dato['color']= $this->input->post("color");
        $dato['fecha_inicio']= $this->input->post("fecha_inicio");

        if($this->input->post("inicio")==0){
            $dato['mes']="";
            $dato['anio']="";
        }else{
            $inicio=explode("/",$this->input->post("inicio"));
            $dato['mes']=$inicio[0];
            $dato['anio']=$inicio[1];
        }

        $this->Model_General->update_empresa($dato);  

        $dato['actual_cb']= $this->input->post("actual_cb");

        if($dato['cuenta_bancaria']!=$dato['actual_cb'] && $this->input->post("inicio")!=0){

            $this->Admin_model->insert_estado_bancario($dato);

            $fecha_inicio=explode("/",$this->input->post("inicio"));
            $mes_inicio=$fecha_inicio[0];
            $anio_inicio=$fecha_inicio[1];
            $fecha_ini=$anio_inicio."-".$mes_inicio."-01";
            $fecha_fin=date('Y')."-".date('m')."-01";

            $diferencia = date_diff(date_create($fecha_ini),date_create($fecha_fin));
            $cantidad_meses= $diferencia->m;
            $cantidad_anios= $diferencia->y;
            $cantidad_real=$cantidad_meses+($cantidad_anios*12);

            $ultimo=$this->Admin_model->ultimo_id_estado_bancario();
            $dato['id_estado_bancario']=$ultimo[0]['id_estado_bancario'];

            $repetidor=0;

            while($repetidor<$cantidad_real){
                $fecha = new DateTime($fecha_ini);
                $fecha->add(new DateInterval('P'.$repetidor.'M'));
                $dato['anio_detalle']=substr($fecha->format('Y-m-d'),0,4);
                $dato['mes_detalle']=substr($fecha->format('Y-m-d'),5,2);

                $this->Admin_model->insert_detalle_estado_bancario($dato);
                $repetidor++;
            }
            
        }
    }

    public function Descargar_Imagen_Empresa($id_empresa) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_General->get_id_empresa($id_empresa);
            $image = $dato['get_file'][0]['imagen'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['imagen']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Imagen_Empresa() {
        $id_empresa = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_General->get_id_empresa($id_empresa);

        if (file_exists($dato['get_file'][0]['imagen'])) {
            unlink($dato['get_file'][0]['imagen']);
        }
        $this->Model_General->delete_imagen_empresa($id_empresa);
    }

    public function Excel_Empresa(){
        $empresas = $this->Model_General->list_empresa();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Empresas');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(18);

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
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

        $sheet->getStyle("A1:M1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Orden');             
        $sheet->setCellValue("B1", 'Código Marca');
        $sheet->setCellValue("C1", 'Marca');
        $sheet->setCellValue("D1", 'Código Empresa');
        $sheet->setCellValue("E1", 'Empresa'); 
        $sheet->setCellValue("F1", 'RUC'); 
        $sheet->setCellValue("G1", 'Cuenta Bancaria');
        $sheet->setCellValue("H1", 'Inicio');
        $sheet->setCellValue("I1", 'Web');
        $sheet->setCellValue("J1", 'Status'); 
        $sheet->setCellValue("K1", 'Redes'); 
        $sheet->setCellValue("L1", 'SUNAT');
        $sheet->setCellValue("M1", 'Fecha Inicio');

        $contador=1;
        
        foreach($empresas as $list){
            $contador++;

            $inicio="";

            if($list['mes']!="" && $list['anio']!=""){
                $inicio=$list['anio']."-".$list['mes']."-01";
            }

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['orden_menu']);
            $sheet->setCellValue("B{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("C{$contador}", $list['nom_empresa']);
            $sheet->setCellValue("D{$contador}", $list['cd_empresa']);
            $sheet->setCellValue("E{$contador}", $list['empresa']);
            $sheet->setCellValue("F{$contador}", $list['ruc']);

            $texto = new RichText();
            $texto->createText($list['cuenta_bancaria']);
            $sheet->getCell("G{$contador}")->setValue($texto);

            if($list['mes']!="" && $list['anio']!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($inicio));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("H{$contador}", "");  
            }

            $sheet->setCellValue("I{$contador}", $list['web']);
            $sheet->setCellValue("J{$contador}", $list['nom_status']);
            $sheet->setCellValue("K{$contador}", $list['reporte']);
            $sheet->setCellValue("L{$contador}", $list['reporte_sunat']);

            if($list['fecha_inicio']!=""){
                $sheet->setCellValue("M{$contador}", Date::PHPToExcel($list['fecha_inicio']));
                $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("M{$contador}", "");  
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Empresas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------------------------SEDES---------------------------------------------
    public function Sedes() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['listar_sede'] = $this->Model_General->get_list_sede();
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $dato['list_empresai'] = $this->Model_General->list_empresa();

        $this->load->view('general/sede/index',$dato);
    }

    public function Modal_sedes(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato["list_empresa"]   = $this->Model_General->raw("select id_empresa,cod_empresa from empresa where estado=2 ORDER BY cod_empresa ASC", false);
            $this->load->view('general/sede/modal_sede', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_sede(){
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['cod_sede']= $this->input->post("cod_sede");
        $cod_sede = $this->input->post("cod_sede");
        $dato['id_local'] = $this->input->post("id_local");
        $id_emp=$this->Model_General->get_empresa($dato['id_empresa']);
        $dato['codigo_sede']= $this->input->post("cod_sede");   
        $dato['b_datos']= $this->input->post("b_datos");   
        $dato['aparece_menu']= $this->input->post("aparece_menu");  
        $dato['orden_menu']= $this->input->post("orden_menu");  

        $codigo_sede= $id_emp.$cod_sede;
        $dato['cod_sede']=$codigo_sede;
        $dato['orden_sede']= $this->input->post("orden");
        $dato['estado']= $this->input->post("estado"); 
        $dato['rep_redes']= $this->input->post("rep_redes");
        $dato['observaciones_sede']= $this->input->post("observaciones_sede");
        
        $total=count($this->Model_General->valida_reg_codsede($dato));
        $c_bd=count($this->Model_General->valida_reg_codsede_bd($dato));
        $c_bd_t=count($this->Model_General->valida_reg_codsede_bd_total($dato));
        $c_bd_emp=count($this->Model_General->valida_reg_codsede_bd_empresa($dato));

        if($total>0){
            echo "error";
        }elseif($c_bd_emp>9){
            echo "limiteemp";
        }elseif($c_bd>2){
            echo "xempresa";
        }elseif($c_bd_t>17){
            echo "bd";
        }else{
            $this->Model_General->Insert_sede($dato);
        }
    }

    public function Modal_Update_sede($id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato["list_empresa"]   = $this->Model_General->list_cod_empresa();
            $dato['get_id'] = $this->Model_General->get_idsede($id_sede);
            $this->load->view('general/sede/upd_modal_sede', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function update_sede(){
        $dato['id_sede']= $this->input->post("id_sede");
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['cod_sede']= $this->input->post("cod_sede");
        $cod_sede = $this->input->post("cod_sede");
        $dato['id_local'] = $this->input->post("id_local");
        $id_emp=$this->Model_General->get_empresa($dato['id_empresa']);
        $dato['codigo_sede']= $this->input->post("cod_sede");   
        $codigo_sede= $id_emp.$cod_sede;
        $dato['cod_sede']=$codigo_sede;
        $dato['orden_sede']= $this->input->post("orden");
        $dato['estado']= $this->input->post("estado"); 
        $dato['rep_redes']= $this->input->post("rep_redes");
        $dato['observaciones_sede']= $this->input->post("observaciones_sede"); 
        $dato['b_datos']= $this->input->post("b_datos"); 
        $dato['aparece_menu']= $this->input->post("aparece_menu");  
        $dato['orden_menu']= $this->input->post("orden_menu"); 

        $c_bd=count($this->Model_General->valida_reg_codsede_bd_upd($dato));
        $c_bd_t=count($this->Model_General->valida_reg_codsede_bd_upd_total($dato));
        $c_bd_emp=count($this->Model_General->valida_reg_codsede_bd_empresa_upd($dato));

        if($c_bd_emp>9){
            echo "limiteemp";
        }elseif($c_bd>2){
            echo "xempresa";
        }elseif($c_bd_t>17){
            echo "bd";
        }
        else{
            $this->Model_General->update_sede($dato);
        }
    }

    public function Excel_Sede(){
        $sede = $this->Model_General->get_list_sede();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:G2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:G2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sedes');

        $sheet->setAutoFilter('B2:G2');

        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $sheet->getStyle('B2:G2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:G2")->getFill()
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

        $sheet->getStyle("B2:G2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("B2", 'Código');            
        $sheet->setCellValue("C2", 'Empresa'); 
        $sheet->setCellValue("D2", 'Local');  
        $sheet->setCellValue("E2", 'Observaciones');
        $sheet->setCellValue("F2", 'Base de Datos');   
        $sheet->setCellValue("G2", 'Status');   

        $contador=2;
        $sheet->freezePane('A3');
        foreach($sede as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("BV{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("D{$contador}", $list['nom_local']);
            $sheet->setCellValue("E{$contador}", $list['observaciones_sede']);
            $sheet->setCellValue("F{$contador}", $list['bd']);
            $sheet->setCellValue("G{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sedes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------------------USUARIOS--------------------------------------------
    public function Usuario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['ip']=$_SERVER['REMOTE_ADDR'];
        $dato['list_usuario'] = $this->Model_General->get_list_usuario();
        $dato['list_usuario_inactivos'] = $this->Model_General->get_list_usuario_inactivos();
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
        $dato['list_empresam'] = $this->Model_General->list_empresa_usuario();
        //$dato['list_sede'] = $this->Model_General->list_sede_usuario();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $this->load->view('general/usuarios/index',$dato);
    }

    public function Modal_Usuario(){
        if ($this->session->userdata('usuario')) {
            $dato["list_empresa"]   = $this->Model_General->list_cod_empresa();
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $this->load->view('general/usuarios/modal_usuario', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Traer_Usuario_Sede_I(){
        if ($this->session->userdata('usuario')) {
            $cantidad_empresa = $this->input->post("id_empresa_i");
            $dato['funciona_array'] = 0;

            $empresas="";
            $i=0;

            if($cantidad_empresa!=""){
                foreach($_POST['id_empresa_i'] as $id_empresa){
                    $empresas=$empresas.$id_empresa.",";
                    $i++;
                }
    
                $dato['empresas']=substr($empresas,0,-1);

                if($i==1){
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
                }else{
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_varios($dato);
                }
            }else{
                $dato['funciona_array']=1;
            }

            $dato['id_sede'] = "id_sede_i";
            
            $this->load->view('general/usuarios/sede',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Usuario(){
        $num = count($this->Model_General->count_usuario());

        if(($num+1)<=9){
            $codigo="00".($num+1);
        }
        if(($num+1)>9 && ($num+1)<=99){
            $codigo="0".($num+1);
        }
        if(($num+1)>99 && ($num+1)<=999){
            $codigo=($num+1);
        }

        $dato['codigo']=$codigo;
        $dato['id_nivel']= $this->input->post("id_nivel_i"); 
        $dato['usuario_apater']= $this->input->post("usuario_apater_i"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater_i"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres_i");
        $dato['emailp']= $this->input->post("emailp_i");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp_i"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg_i"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones_i"); 
        $dato['usuario_codigo']= $this->input->post("usuario_codigo_i");
        $dato['redes']= $this->input->post("redes_i"); 
        $dato['artes']= $this->input->post("artes_i");
        $dato['clave_asistencia']= $this->input->post("clave_asistencia_i");

        $password=$this->input->post("usuario_password_i");
        $dato['usuario_password']= password_hash($password, PASSWORD_DEFAULT);
        $dato['password_desencriptado']= $this->input->post("usuario_password_i");
        $dato['observaciones']= $this->input->post("observaciones_i"); 
        
        $cant=count($this->Model_General->valida_insert_usuario($dato));

        if($cant>0){
            echo "error";
        }else{
            $this->Model_General->insert_usuario($dato);

            $get_id = $this->Model_General->ultimo_id_usuario();
            $dato['id_usuario'] = $get_id[0]['id_usuario'];

            $empresas= $this->input->post("id_empresa_i"); 
            $sedes= $this->input->post("id_sede_i");
    
            if($empresas!=""){
                foreach($_POST['id_empresa_i'] as $id_empresa){
                    $dato['id_empresa']=$id_empresa;
        
                    $this->Model_General->insert_usuario_empresa($dato);
                }
            }
    
            if($sedes!=""){
                foreach($_POST['id_sede_i'] as $id_sede){
                    $dato['id_sede']=$id_sede;
        
                    $this->Model_General->insert_usuario_sede($dato);
                }
            }
        }
    }

    public function Modal_Update_Usuario($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_usuario($id_usuario);
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['get_empresa'] = $this->Model_General->get_id_empresa_usuario($id_usuario);
            $dato['get_sede'] = $this->Model_General->get_id_sede_usuario($id_usuario);

            $get_empresa = $this->Model_General->get_id_empresa_usuario($id_usuario);

            $dato['cantidad_empresa']=count($get_empresa);

            $i=0;
            $empresas="";

            while($i<count($get_empresa)){
                $empresas=$empresas.$get_empresa[$i]['id_empresa'].",";
                $i=$i+1;
            }

            $dato['empresas']=substr($empresas,0,-1);

            if(count($get_empresa)!=0){
                if(count($get_empresa)==1){
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
                }else{
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_varios($dato);
                }
            }

            $this->load->view('general/usuarios/upd_modal_usuario', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Traer_Usuario_Sede_U(){
        if ($this->session->userdata('usuario')) {
            $cantidad_empresa = $this->input->post("id_empresa_u");
            $dato['funciona_array'] = 0;

            $empresas="";
            $i=0;

            if($cantidad_empresa!=""){
                foreach($_POST['id_empresa_u'] as $id_empresa){
                    $empresas=$empresas.$id_empresa.",";
                    $i++;
                }
    
                $dato['empresas']=substr($empresas,0,-1);

                if($i==1){
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
                }else{
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_varios($dato); 
                }
            }else{
                $dato['funciona_array']=1;
            }

            $dato['id_sede'] = "id_sede_u";
            
            $this->load->view('general/usuarios/sede',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Usuario(){
        $dato['id_usuario']= $this->input->post("id_usuario");
        $dato['id_nivel']= $this->input->post("id_nivel_u");
        $dato['usuario_apater']= $this->input->post("usuario_apater_u"); 
        $dato['usuario_amater']= $this->input->post("usuario_amater_u"); 
        $dato['usuario_nombres']= $this->input->post("usuario_nombres_u");
        $dato['emailp']= $this->input->post("emailp_u");
        $dato['usuario_email']= $dato['emailp'];         
        $dato['num_celp']= $this->input->post("num_celp_u"); 
        $dato['codigo_gllg']= $this->input->post("codigo_gllg_u"); 
        $dato['ini_funciones']= $this->input->post("ini_funciones_u"); 
        $dato['fin_funciones']= $this->input->post("fin_funciones_u"); 
        $dato['id_status']= $this->input->post("id_status_u");
        $dato['usuario_codigo']= $this->input->post("usuario_codigo_u");
        
        $password=$this->input->post("usuario_password_u");
        $dato['contraseña']=$this->input->post("usuario_password_u");
        $dato['usuario_password']= password_hash($password, PASSWORD_DEFAULT);
        $dato['password_desencriptado']= $this->input->post("usuario_password_u");
        $dato['artes']= $this->input->post("artes_u");
        $dato['redes']= $this->input->post("redes_u"); 
        $dato['clave_asistencia']= $this->input->post("clave_asistencia_u");
        $dato['observaciones']= $this->input->post("observaciones_u"); 

        $this->Model_General->update_usuario($dato);

        //EMPRESAS Y SEDES

        $empresas= $this->input->post("id_empresa_u"); 
        $sedes= $this->input->post("id_sede_u");

        if($empresas!=""){
            $this->Model_General->delete_usuario_empresa($dato);

            foreach($_POST['id_empresa_u'] as $id_empresa){
                $dato['id_empresa']=$id_empresa;
    
                $this->Model_General->update_usuario_empresa($dato);
            }
        }

        if($sedes!=""){
            $this->Model_General->delete_usuario_sede($dato);

            foreach($_POST['id_sede_u'] as $id_sede){
                $dato['id_sede']=$id_sede;
    
                $this->Model_General->update_usuario_sede($dato);
            }
        }
    }

    public function Excel_Usuario(){
        $festivo = $this->Model_General->get_list_usuario();
        $list_inactivos = $this->Model_General->get_list_usuario_inactivos();
        $list_empresa = $this->Model_General->list_empresa_usuario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Usuarios');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(24);
        $sheet->getColumnDimension('J')->setWidth(24);
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

        $sheet->setCellValue("A1", 'Usuario');            
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'Apellido(s) Materno');
        $sheet->setCellValue("D1", 'Apellido(s) Paterno');            
        $sheet->setCellValue("E1", 'Nombres');
        $sheet->setCellValue("F1", 'Perfil');
        $sheet->setCellValue("G1", 'Empresa');
        $sheet->setCellValue("H1", 'Codigo GL');
        $sheet->setCellValue("I1", 'Inicio de Funciones');
        $sheet->setCellValue("J1", 'Termino de Funciones');
        $sheet->setCellValue("K1", 'Ultimo');
        $sheet->setCellValue("L1", 'Estado');

        $contador=1;
        
        foreach($festivo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $cadena="";
            foreach($list_empresa as $empresa){
                if($empresa['id_usuario']==$list['id_usuario']){
                    $cadena=$cadena.$empresa['cod_empresa'].",";
                }
            }
            $empresa=substr($cadena,0,-1);

            
            $sheet->setCellValue("A{$contador}", $list['usuario_codigo']);          
            $sheet->setCellValue("B{$contador}", $list['codigo']);
            $sheet->setCellValue("C{$contador}", $list['usuario_amater']);
            $sheet->setCellValue("D{$contador}", $list['usuario_apater']);          
            $sheet->setCellValue("E{$contador}", $list['usuario_nombres']);
            $sheet->setCellValue("F{$contador}", $list['nom_nivel']);
            $sheet->setCellValue("G{$contador}", "".$empresa."");
            $sheet->setCellValue("H{$contador}", $list['codigo_gllg']);

            if($list['ini_funciones']=="0000-00-00"){
                $sheet->setCellValue("I{$contador}", "");
            }else{
                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['ini_funciones']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            if($list['fin_funciones']=="0000-00-00"){
                $sheet->setCellValue("J{$contador}", "");
            }else{
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fin_funciones']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            if($list['ultimo_ingreso_excel']=="0000-00-00 00:00:00" || $list['ultimo_ingreso_excel']==""){
                $sheet->setCellValue("K{$contador}", "");
            }else{
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['ultimo_ingreso_excel']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            $sheet->setCellValue("L{$contador}", $list['nom_status']);
        }
        
        if(count($list_inactivos)>0){
            foreach($list_inactivos as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("C{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $cadena="";
                foreach($list_empresa as $empresa){
                    if($empresa['id_usuario']==$list['id_usuario']){
                        $cadena=$cadena.$empresa['cod_empresa'].",";
                    }
                }
                $empresa=substr($cadena,0,-1);

                
                $sheet->setCellValue("A{$contador}", $list['usuario_codigo']);          
                $sheet->setCellValue("B{$contador}", $list['codigo']);
                $sheet->setCellValue("C{$contador}", $list['usuario_amater']);
                $sheet->setCellValue("D{$contador}", $list['usuario_apater']);          
                $sheet->setCellValue("E{$contador}", $list['usuario_nombres']);
                $sheet->setCellValue("F{$contador}", $list['nom_nivel']);
                $sheet->setCellValue("G{$contador}", "".$empresa."");
                $sheet->setCellValue("H{$contador}", $list['codigo_gllg']);

                if($list['ini_funciones']=="0000-00-00"){
                    $sheet->setCellValue("I{$contador}", "");
                }else{
                    $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['ini_funciones']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                if($list['fin_funciones']=="0000-00-00"){
                    $sheet->setCellValue("J{$contador}", "");
                }else{
                    $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fin_funciones']));
                    $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                if($list['ultimo_ingreso_excel']=="0000-00-00 00:00:00" || $list['ultimo_ingreso_excel']==""){
                    $sheet->setCellValue("K{$contador}", "");
                }else{
                    $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['ultimo_ingreso_excel']));
                    $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                $sheet->setCellValue("L{$contador}", $list['nom_status']);
            }
        }
        
        $writer = new Xlsx($spreadsheet); 
        $filename = 'Usuarios (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------------------RRHH--------------------------------------------
    public function RRHH() {
        if ($this->session->userdata('usuario')) {
            $dato['list_usuario'] = $this->Model_General->get_list_combo_usuario();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            
            $this->load->view('general/rrhh/index',$dato);
        }else{
            redirect('/login'); 
        }
    }

    public function Traer_Sede_Rrhh(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['id_empresa'] = $this->input->post('id_empresa');
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['id_empresa']);
        $this->load->view('general/rrhh/sede',$dato);
    }

    public function Traer_Tipo_Contrato_Rrhh(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['id_sede'] = $this->input->post('id_sede');
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['id_sede']);
        $this->load->view('general/rrhh/tipo_contrato',$dato);
    }

    // tipo contrato
    public function List_Tipo_Contrato_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list_tipo_contrato'] = $this->Model_General->get_list_tipo_contrato_rrhh();
        $this->load->view('general/rrhh/tipo_contrato/list',$dato);
    }

    public function Modal_Insertar_Tipo_Contrato_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/tipo_contrato/ins_modal', $dato);
    }

    public function Insert_Tipo_Contrato_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_empresa'] = $this->input->post("id_empresa");
        $dato['id_sede'] = $this->input->post("id_sede");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['nombre'] = $this->input->post("nombre");
        $dato['id_estado'] = $this->input->post("id_estado");
        $dato['id_tipo'] = $this->input->post("id_tipo");

        $total=count($this->Model_General->valida_insert_tipo_contrato_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_tipo_contrato_rrhh($dato);
        }
    }

    public function Modal_Update_Tipo_Contrato_RRHH($id_tipo_contrato){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['tipo_contrato'] = $this->Model_General->get_tipo_contrato_rrhh($id_tipo_contrato);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['tipo_contrato'][0]['id_empresa']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/tipo_contrato/upd_modal', $dato);   
    }

    public function Update_Tipo_Contrato_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato_e");
        $dato['id_empresa'] = $this->input->post("id_empresae");
        $dato['id_sede'] = $this->input->post("id_sedee");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['nombre'] = $this->input->post("nombre_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");

        $total=count($this->Model_General->valida_update_tipo_contrato_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_tipo_contrato_rrhh($dato);
        }
    }

	public function Excel_Tipo_Contrato_RRHH()
	{
		$data = $this->Model_General->get_list_tipo_contrato_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Tipo Contrato (Lista)');

		$sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(60);
		$sheet->getColumnDimension('F')->setWidth(60);
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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Tipo');
        $sheet->setCellValue("E1", 'Sub-Tipo');
		$sheet->setCellValue("F1", 'Nombre');
		$sheet->setCellValue("G1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['codigo']);
            $sheet->setCellValue("D{$contador}", $list['tipo']);
            $sheet->setCellValue("E{$contador}", $list['subtipo']);
			$sheet->setCellValue("F{$contador}", $list['nombre']);
			$sheet->setCellValue("G{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Tipo Contrato (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

    // contribuciones
    public function List_Contribucion_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_contribucion_rrhh();
        $this->load->view('general/rrhh/contribucion/list',$dato);
    }

    public function Modal_Insertar_Contribucion_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/contribucion/ins_modal', $dato);
    }

    public function Insert_Contribucion_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['nombre'] = $this->input->post("nombre");
        $dato['id_estado'] = $this->input->post("id_estado");
        $dato['tipo_contribucion'] = $this->input->post("tipo_contribucion");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento");
        $dato['monto'] = $this->input->post("monto"); 

        $total=count($this->Model_General->valida_contribucion_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_contribucion_rrhh($dato);
        }
    }

    public function Modal_Update_Contribucion_RRHH($id_contribucion){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['contribucion'] = $this->Model_General->get_contribucion_rrhh($id_contribucion);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['contribucion'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['contribucion'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/contribucion/upd_modal', $dato);   
    }

    public function Update_Contribucion_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_contribucion'] = $this->input->post("id_contribucion_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['nombre'] = $this->input->post("nombre_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");
        $dato['tipo_contribucion'] = $this->input->post("tipo_contribucion_e");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento_e");
        $dato['monto'] = $this->input->post("monto_e"); 

        $total=count($this->Model_General->valida_contribucion_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_contribucion_rrhh($dato);
        }
    }

    public function Excel_Contribucion_RRHH(){
        $data = $this->Model_General->get_list_contribucion_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Contribución (Lista)');

		$sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
		$sheet->getColumnDimension('G')->setWidth(25);
		$sheet->getColumnDimension('H')->setWidth(60);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
		$sheet->setCellValue("G1", 'Tipo de Contribucion');
		$sheet->setCellValue("H1", 'Nombre');
        $sheet->setCellValue("I1", 'Tipo de Descuento');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
			$sheet->setCellValue("G{$contador}", $list['tipo_contribucion_texto']);
			$sheet->setCellValue("H{$contador}", $list['nombre']);
            $sheet->setCellValue("I{$contador}", $list['tipo_descuento_texto']);
            $sheet->setCellValue("J{$contador}", $list['monto']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Contribución (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    // impuesto
    public function List_Impuesto_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_impuesto_rrhh();
        $this->load->view('general/rrhh/impuesto/list',$dato);
    }

    public function Modal_Insertar_Impuesto_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/impuesto/ins_modal', $dato);
    }

    public function Insert_Impuesto_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['de'] = $this->input->post("de");
        $dato['a'] = $this->input->post("a");
        $dato['porcentaje_impuesto'] = $this->input->post("porcentaje_impuesto");
        $dato['id_estado'] = $this->input->post("id_estado");

        $total=count($this->Model_General->valida_insert_impuesto_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_impuesto_rrhh($dato);
        }
    }

    public function Modal_Update_Impuesto_RRHH($id_impuesto){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['impuesto'] = $this->Model_General->get_impuesto_rrhh($id_impuesto);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['impuesto'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['impuesto'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/impuesto/upd_modal', $dato);   
    }

    public function Update_Impuesto_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_impuesto'] = $this->input->post("id_impuesto_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['de'] = $this->input->post("de_e");
        $dato['a'] = $this->input->post("a_e");
        $dato['porcentaje_impuesto'] = $this->input->post("porcentaje_impuesto_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");

        $total=count($this->Model_General->valida_update_impuesto_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_impuesto_rrhh($dato);
        }
    }

    public function Excel_Impuesto_RRHH(){
        $data = $this->Model_General->get_list_impuesto_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Impuesto (Lista)');

		$sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
		$sheet->setCellValue("G1", 'De');
		$sheet->setCellValue("H1", 'A');
        $sheet->setCellValue("I1", 'Porcentaje de impuesto');
        $sheet->setCellValue("J1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}:H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
			$sheet->setCellValue("G{$contador}", $list['de']);
			$sheet->setCellValue("H{$contador}", $list['a']);
            $sheet->setCellValue("I{$contador}", $list['porcentaje_impuesto']);
            $sheet->setCellValue("J{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Impuesto (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    // as familiar
    public function List_AsFamiliar_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_as_familiar_rrhh();
        $this->load->view('general/rrhh/as_familiar/list',$dato);
    }

    public function Modal_Insertar_AsFamiliar_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/as_familiar/ins_modal', $dato);
    }

    public function Insert_AsFamiliar_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['nombre'] = $this->input->post("nombre");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento");
        $dato['monto'] = $this->input->post("monto");
        $dato['id_estado'] = $this->input->post("id_estado");

        $total=count($this->Model_General->valida_insert_as_familiar_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_as_familiar_rrhh($dato);
        }
    }

    public function Modal_Update_AsFamiliar_RRHH($id_as_familiar){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['as_familiar'] = $this->Model_General->get_as_familiar_rrhh($id_as_familiar);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['as_familiar'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['as_familiar'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/as_familiar/upd_modal', $dato);   
    }

    public function Update_AsFamiliar_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_as_familiar'] = $this->input->post("id_as_familiar_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['nombre'] = $this->input->post("nombre_e");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento_e");
        $dato['monto'] = $this->input->post("monto_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");

        $total=count($this->Model_General->valida_update_as_familiar_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_as_familiar_rrhh($dato);
        }
    }

    public function Excel_AsFamiliar_RRHH(){
        $data = $this->Model_General->get_list_as_familiar_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Asignación Familiar (Lista)');

		$sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
		$sheet->getColumnDimension('G')->setWidth(60);
		$sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
		$sheet->setCellValue("G1", 'Nombre');
		$sheet->setCellValue("H1", 'Tipo de Descuento');
        $sheet->setCellValue("I1", 'Monto');
        $sheet->setCellValue("J1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
			$sheet->setCellValue("G{$contador}", $list['nombre']);
			$sheet->setCellValue("H{$contador}", $list['tipo_descuento_texto']);
            $sheet->setCellValue("I{$contador}", $list['monto']);
            $sheet->setCellValue("J{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Asignación Familiar (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    // bono
    public function List_Bono_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_bono_rrhh();
        $this->load->view('general/rrhh/bono/list',$dato);
    }

    public function Modal_Insertar_Bono_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/bono/ins_modal', $dato);
    }

    public function Insert_Bono_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['nombre'] = $this->input->post("nombre");
        $dato['tipo_bono'] = $this->input->post("tipo_bono");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento");
        $dato['monto'] = $this->input->post("monto");
        $dato['id_estado'] = $this->input->post("id_estado");

        $total=count($this->Model_General->valida_insert_bono_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_bono_rrhh($dato);
        }
    }

    public function Modal_Update_Bono_RRHH($id_bono){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['bono'] = $this->Model_General->get_bono_rrhh($id_bono);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['bono'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['bono'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/bono/upd_modal', $dato);   
    }

    public function Update_Bono_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_bono'] = $this->input->post("id_bono_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['nombre'] = $this->input->post("nombre_e");
        $dato['tipo_bono'] = $this->input->post("tipo_bono_e");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento_e");
        $dato['monto'] = $this->input->post("monto_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");

        $total=count($this->Model_General->valida_update_bono_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_bono_rrhh($dato);
        }
    }

    public function Excel_Bono_RRHH(){
        $data = $this->Model_General->get_list_bono_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Bono (Lista)');

		$sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
		$sheet->getColumnDimension('G')->setWidth(30);
		$sheet->getColumnDimension('H')->setWidth(60);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
		$sheet->setCellValue("G1", 'Tipo de Bono');
		$sheet->setCellValue("H1", 'Nombre');
        $sheet->setCellValue("I1", 'Monto');
        $sheet->setCellValue("J1", 'Tipo de Descuento');
        $sheet->setCellValue("K1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
			$sheet->setCellValue("G{$contador}", $list['tipo_bono_texto']);
			$sheet->setCellValue("H{$contador}", $list['nombre']);
            $sheet->setCellValue("I{$contador}", $list['monto']);
            $sheet->setCellValue("J{$contador}", $list['tipo_descuento_texto']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Bono (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    // tardanza
    public function List_Tardanza_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_tardanza_rrhh();
        $this->load->view('general/rrhh/tardanza/list',$dato);
    }

    public function Modal_Insertar_Tardanza_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/tardanza/ins_modal', $dato);
    }

    public function Insert_Tardanza_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['tipo_tardanza'] = $this->input->post("tipo_tardanza");
        $dato['monto'] = $this->input->post("monto");
        $dato['id_estado'] = $this->input->post("id_estado");

        $total=count($this->Model_General->valida_insert_tardanza_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_tardanza_rrhh($dato);
        }
    }

    public function Modal_Update_Tardanza_RRHH($id_tardanza){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['tardanza'] = $this->Model_General->get_tardanza_rrhh($id_tardanza);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['tardanza'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['tardanza'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/tardanza/upd_modal', $dato);   
    }

    public function Update_Tardanza_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tardanza'] = $this->input->post("id_tardanza_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['tipo_tardanza'] = $this->input->post("tipo_tardanza_e");
        $dato['monto'] = $this->input->post("monto_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");

        $total=count($this->Model_General->valida_update_tardanza_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_tardanza_rrhh($dato);
        }
    }

    public function Excel_Tardanza_RRHH(){
        $data = $this->Model_General->get_list_tardanza_rrhh();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$spreadsheet->getActiveSheet()->setTitle('Tardanza (Lista)');

		$sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

		$sheet->getStyle('A1:I1')->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
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

		$sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
		$sheet->setCellValue("G1", 'Tipo de tardanza');
		$sheet->setCellValue("H1", 'Monto');
        $sheet->setCellValue("I1", 'Estado');

		$contador = 1;

		foreach ($data as $list) {
			$contador++;

			$sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
			$sheet->setCellValue("G{$contador}", $list['tipo_tardanza_texto']);
			$sheet->setCellValue("H{$contador}", $list['monto']);
            $sheet->setCellValue("I{$contador}", $list['nom_status']);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'Tardanza (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    // faltas
    public function List_Falta_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['list'] = $this->Model_General->get_list_falta_rrhh();
        $this->load->view('general/rrhh/falta/list',$dato);
    }

    public function Modal_Insertar_Falta_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/falta/ins_modal', $dato);
    }

    public function Insert_Falta_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contrato");
        $dato['codigo'] = $this->input->post("codigo");
        $dato['tipo'] = $this->input->post("tipo");
        $dato['subtipo'] = $this->input->post("subtipo");
        $dato['nombre'] = $this->input->post("nombre");
        $dato['id_estado'] = $this->input->post("id_estado");
        $dato['tipo_falta'] = $this->input->post("tipo_falta");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento");
        $dato['monto'] = $this->input->post("monto"); 

        $total=count($this->Model_General->valida_insert_falta_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_falta_rrhh($dato);
        }
    }

    public function Modal_Update_Falta_RRHH($id_falta){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['falta'] = $this->Model_General->get_falta_rrhh($id_falta);
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_rrhh();
        $dato['list_sede'] = $this->Model_General->get_list_sede_rrhh($dato['falta'][0]['id_empresa']);
        $dato['list_tipo_contrato'] = $this->Model_General->get_combo_tipo_contrato_rrhh($dato['falta'][0]['id_sede']);
        $dato['list_estado'] = $this->Model_General->get_list_estado();
        $this->load->view('general/rrhh/falta/upd_modal', $dato);   
    }

    public function Update_Falta_RRHH(){
        if (!$this->session->userdata('usuario')) redirect('/login');

        $dato['id_falta'] = $this->input->post("id_falta_e");
        $dato['id_tipo_contrato'] = $this->input->post("id_tipo_contratoe");
        $dato['codigo'] = $this->input->post("codigoe");
        $dato['tipo'] = $this->input->post("tipoe");
        $dato['subtipo'] = $this->input->post("subtipoe");
        $dato['nombre'] = $this->input->post("nombre_e");
        $dato['id_estado'] = $this->input->post("id_estado_e");
        $dato['tipo_falta'] = $this->input->post("tipo_falta_e");
        $dato['tipo_descuento'] = $this->input->post("tipo_descuento_e");
        $dato['monto'] = $this->input->post("monto_e"); 

        $total=count($this->Model_General->valida_update_falta_rrhh($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->update_falta_rrhh($dato);
        }
    }

    public function Excel_Falta_RRHH(){
        $data = $this->Model_General->get_list_falta_rrhh();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Falta (Lista)');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(60);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo Contrato');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Sub-Tipo');
        $sheet->setCellValue("G1", 'Tipo de Falta');
        $sheet->setCellValue("H1", 'Nombre');
        $sheet->setCellValue("I1", 'Tipo de Descuento');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Estado');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_contrato']);
            $sheet->setCellValue("D{$contador}", $list['codigo']);
            $sheet->setCellValue("E{$contador}", $list['tipo']);
            $sheet->setCellValue("F{$contador}", $list['subtipo']);
            $sheet->setCellValue("G{$contador}", $list['tipo_falta_texto']);
            $sheet->setCellValue("H{$contador}", $list['nombre']);
            $sheet->setCellValue("I{$contador}", $list['tipo_descuento_texto']);
            $sheet->setCellValue("J{$contador}", $list['monto']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Falta (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    //--------------------------------------------USUARIOS ACCESO----------------------------------------
    public function Usuario_Configuracion() {
        if ($this->session->userdata('usuario')) {
            $dato['list_usuario'] = $this->Model_General->get_list_combo_usuario();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            
            $this->load->view('general/usuarios_configuracion/index',$dato);
        }else{
            redirect('/login'); 
        }
    }

    public function Busca_Menu_Nav(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $this->input->post("id_usuario"); 
            $dato['list_submodulo']=$this->Model_General->get_modulo_subgrupo_xnivel($id_usuario);
            $dato['list_sub_submodulo']=$this->Model_General->get_modulo_sub_subgrupo_xnivel($id_usuario); 
            $dato['list_empresam']=$this->Model_General->get_modulo_mae(); 
            $dato['list_modulo']=$this->Model_General->get_modulo_grupo_xnivel(); 
            $this->load->view('general/usuarios_configuracion/list_menu',$dato);
        }else{
            redirect('/login'); 
        }
    }

    public function Insert_Nivel_Acceso(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario'] = $this->input->post("id_usuario");

            $this->Model_General->limpiar_nivel_acceso($dato['id_usuario']); 

            foreach($_POST['id_modulo_subgrupo'] as $id_modulo_subgrupo){
                $dato['id_modulo_subgrupo'] = $id_modulo_subgrupo;
                $get_id = $this->Model_General->get_id_modulo_subgrupo($dato); 
                $dato['id_modulo_grupo']= $get_id[0]['id_modulo_grupo'];
                $this->Model_General->insert_nivel_accesos($dato);
            }

            foreach($_POST['id_modulo_sub_subgrupo'] as $id_modulo_sub_subgrupo){
                $dato['id_modulo_sub_subgrupo'] = $id_modulo_sub_subgrupo;
                $get_id = $this->Model_General->get_id_sub_subsubgrupo($dato); 
                $dato['id_modulo_grupo'] = $get_id[0]['id_modulo_grupo'];
                $dato['id_modulo_subgrupo'] = $get_id[0]['id_modulo_subgrupo'];
                $this->Model_General->insert_nivel_accesos_subsubgrupo($dato);
            }

            /*$id_usuario= $this->input->post("id_usuario");
            $dato['id_usuario'] = $id_usuario;
            $dato['list_modulo']=$this->Model_General->get_modulo_grupo_xnivel();
            $dato['list_subsubmodulo']=$this->Model_General->get_modulo_sub_subgrupo_registrar();
            $dato['list_submodulo']=$this->Model_General->get_modulo_subgrupo_xnivel_registrar($id_usuario);
            $this->Model_General->limpiar_nivel_acceso($id_usuario); 

            $cant_subsub=count($dato['list_subsubmodulo'])+1;
            $cant_subm=count($dato['list_submodulo']);
            $x=1;
            $z=1;
            while($z<$cant_subsub){
                if(isset($_POST['id_modulo_sub_subgrupo'.$x.'-'.$z])){
                    foreach ($_POST['id_modulo_sub_subgrupo'.$x.'-'.$z] as $id) {
                        $dato['id_modulo_sub_subgrupo'] = $id;
                        $dato['get_id']=$this->Model_General->get_id_sub_subsubgrupo($dato);
                        $dato['id_modulo_grupo']=$dato['get_id'][0]['id_modulo_grupo'];
                        $dato['id_modulo_subgrupo']=$dato['get_id'][0]['id_modulo_subgrupo'];
                        $this->Model_General->insert_nivel_accesos_subsubgrupo($dato);
                    }
                }
                $z=$z+1;
                if($z==$cant_subsub && $x<$cant_subm){
                    $x=$x+1;
                    $z=1;
                }

                if($x>$cant_subm){
                    break;
                }
            }

            $i=1;
            $y=1;
            $cant_submodulo=count($dato['list_submodulo'])+1;
            $cant_modulo=count($dato['list_modulo'])+1;
            
            while($i<$cant_submodulo){
                if(isset($_POST['id_modulo_subgrupo'.$y.'-'.$i])){
                    foreach ($_POST['id_modulo_subgrupo'.$y.'-'.$i] as $idsub) {
                        $dato['id_modulo_subgrupo'] = $idsub;
                        $dato['list_subsub']=$this->Model_General->get_modulo_subsubgrupo_xsubmodulo($dato);
                        if(count($dato['list_subsub'])>0){
                            $dato['list_sub']=$this->Model_General->get_cant_subsubgrupo_xsubmodulo_nivel($dato);
                            if(count($dato['list_sub'])==count($dato['list_subsub'])){
                                $dato['get_id']=$this->Model_General->get_id_modulo_subgrupo($dato); 
                                $dato['id_modulo_grupo']=$dato['get_id'][0]['id_modulo_grupo'];
                                $this->Model_General->insert_nivel_accesos($dato);
                            }
                        }else{
                            $dato['get_id']=$this->Model_General->get_id_modulo_subgrupo($dato); 
                            $dato['id_modulo_grupo']=$dato['get_id'][0]['id_modulo_grupo'];
                            $this->Model_General->insert_nivel_accesos($dato);
                        }
                    }
                }

                $i=$i+1;
                if($i==$cant_submodulo && $y<$cant_modulo){
                    $y=$y+1;
                    $i=1;
                }
            }*/
        }else{
            redirect('/login'); 
        }
    }
    //-----------------------------------------------AVISOS----------------------------------------------
    public function Aviso() {
        if ($this->session->userdata('usuario')) { 
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/aviso/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Aviso(){
        if ($this->session->userdata('usuario')) { 
            $dato['list_aviso'] = $this->Model_General->get_list_aviso_modulo();
            $this->load->view('general/aviso/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Leido_Aviso(){
        $dato['id_aviso']= $this->input->post("id_aviso"); 
        $dato['leido']= $this->input->post("leido"); 

        if($dato['leido']==1){
            $dato['leido'] = 0;
        }else{
            $dato['leido'] = 1;
        }

        $this->Model_General->update_leido_aviso($dato);
    }

    public function Modal_Aviso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_perfil'] = $this->Model_General->get_list_nivel();
            $this->load->view('general/aviso/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Aviso(){
        $dato['id_perfil']= $this->input->post("id_perfil_i"); 
        $dato['id_fecha']= $this->input->post("id_fecha_i"); 
        $dato['tipo']= $this->input->post("tipo_i");
        $dato['id_accion']= $this->input->post("id_accion_i"); 
        $dato['mensaje']= $this->input->post("mensaje_i");
        $dato['link']= $this->input->post("link_i");
        $this->Model_General->insert_aviso($dato);
    }

    public function Modal_Update_Aviso($id_aviso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_list_aviso_modulo($id_aviso);
            $dato['list_perfil'] = $this->Model_General->get_list_nivel();
            $this->load->view('general/aviso/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Aviso(){
        $dato['id_aviso']= $this->input->post("id_aviso");
        $dato['id_perfil']= $this->input->post("id_perfil_u"); 
        $dato['id_fecha']= $this->input->post("id_fecha_u"); 
        $dato['tipo']= $this->input->post("tipo_u");
        $dato['id_accion']= $this->input->post("id_accion_u"); 
        $dato['mensaje']= $this->input->post("mensaje_u");
        $dato['link']= $this->input->post("link_u");
        $this->Model_General->update_aviso($dato);
    }

    public function Excel_Aviso(){
        $list_aviso = $this->Model_General->get_list_aviso_modulo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Notificaciones');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(60);

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

        $sheet->setCellValue("A1", 'Perfil');            
        $sheet->setCellValue("B1", 'Fecha');  
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Acción');  
        $sheet->setCellValue("E1", 'Mensaje');
        $sheet->setCellValue("F1", 'Leido');    
        $sheet->setCellValue("G1", 'Link');    

        $contador=1;
        
        foreach($list_aviso as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); 
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_perfil']);
            $sheet->setCellValue("B{$contador}", $list['nom_fecha']);
            $sheet->setCellValue("C{$contador}", $list['tipo']);
            $sheet->setCellValue("D{$contador}", $list['nom_accion']);
            $sheet->setCellValue("E{$contador}", $list['mensaje']);
            $sheet->setCellValue("F{$contador}", $list['v_leido']);
            $sheet->setCellValue("G{$contador}", $list['link']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Notificaciones (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Aviso() {
        if ($this->session->userdata('usuario')) { 
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Aviso(){
        if ($this->session->userdata('usuario')) { 
            $dato['lista_aviso'] = $this->Model_General->get_list_aviso_todo();
            $this->load->view('general/aviso/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Cargar_Nav(){
        if ($this->session->userdata('usuario')) { 
            $dato['controlador']= $this->input->post("controlador");
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            $this->load->view('cargar_nav',$dato);
        }else{
            redirect('/login');
        }
    }
    //------------------------------------------FESTIVOS & FECHAS IMPORANTES-----------------------------------
    public function Festivo() { 
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/festivo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Festivo() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_festivo'] = $this->Model_snappy->get_list_festivo($dato['tipo']);
            $this->load->view('general/festivo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Festivo(){
        $dato['id_calendar_festivo']= $this->input->post("id_calendar_festivo"); 
        $this->Model_General->delete_festivo($dato);
    }

    public function Excel_Festivo($tipo){
        $list_festivo = $this->Model_snappy->get_list_festivo($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Festivos');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(60);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Año');	        
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Día de la Semana');
        $sheet->setCellValue("D1", 'Descripción');	        
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'F/V');
        $sheet->setCellValue("G1", 'Clases');
        $sheet->setCellValue("H1", 'Laborable');
        $sheet->setCellValue("I1", 'Observaciones');
        $sheet->setCellValue("J1", 'Empresa');
        $sheet->setCellValue("K1", 'Estado');   

        $contador=1;
        
        foreach($list_festivo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['anio']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['inicio']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list['nom_dia']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['nom_tipo_fecha']);
            $sheet->setCellValue("F{$contador}", $list['f_v']);
            $sheet->setCellValue("G{$contador}", $list['clases']);
            $sheet->setCellValue("H{$contador}", $list['laborable']);
            $sheet->setCellValue("I{$contador}", $list['observaciones']);
            $sheet->setCellValue("J{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Festivos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //----------------------------------------------FONDOS DE INTRANET-----------------------------------------
    public function Fondo_snappy() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['confg_foto'] = $this->Model_General->get_confg_foto();
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $this->load->view('general/fondo_snapy/index',$dato);
    }

    public function modal_img(){
        if ($this->session->userdata('usuario')) {
           $dato["list_empresa"]   = $this->Model_General->raw("select id_empresa,cod_empresa,nom_empresa from empresa  where estado=2", false);

            $this->load->view('general/fondo_snapy/modal_img',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_fondo(){
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['foto']= $this->input->post("productImage"); 
        $dato['nom_fintranet']= $this->input->post("nom_fintranet");

        $contar_fondo=count($this->Model_General->contar_fondo_empresa($dato));

        if($contar_fondo==0){
            $this->Model_General->insert_fondo($dato);
        }else{
            $this->Model_General->update_fondo_usado($dato);
            $this->Model_General->insert_fondo($dato);
        }
    }

    public function update_img($id_intranet){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_intranet($id_intranet);
            $dato["list_empresa"]   = $this->Model_General->list_cod_empresa();
            $this->load->view('general/fondo_snapy/upd_modal_img',$dato);   
        }
        else{
            redirect('/login');
        }
    
    }
    
    public function update_foto(){
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['nom_fintranet']= $this->input->post("nom_fintranet"); 
        $dato['foto']= $this->input->post("actuimagen"); 
        $dato['id_fintranet']= $this->input->post("id_fintranet"); 

        $contar_fondo=count($this->Model_General->contar_fondo_empresa($dato));

        if($contar_fondo==0){
            $this->Model_General->update_foto($dato);
        }else{
            $this->Model_General->update_fondo_usado($dato);
            $this->Model_General->update_foto($dato);
        }

        redirect('general/Fondo_snappy'); 
    }    

    public function Excel_Fondo(){
        $fondo = $this->Model_General->get_confg_foto();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Fondos Snappy');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(50);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);  

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

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", 'Título Fondo');  

        $contador=1;
        
        foreach($fondo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_empresa']);
            $sheet->setCellValue("B{$contador}", $list['nom_fintranet']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Fondos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------TICKETS--------------------------------------------
    public function Ticket(){
        if ($this->session->userdata('usuario')) { 
            $dato['todo'] =$this->Model_General->ticket_todo();
            $dato['solicitado'] =$this->Model_General->ticket_solicitado();
            $dato['presupuesto'] =$this->Model_General->ticket_presupuesto();
            $dato['tramite'] =$this->Model_General->ticket_tramite();
            $dato['pendiente'] =$this->Model_General->ticket_pendiente();

            $dato['mes_actual']=date('m');
            $dato['anio_actual']=date('Y');
            $dato['terminado'] =$this->Model_General->ticket_terminado($dato);
            $dato['tiempo_total'] =$this->Model_General->tiempo_total($dato);
            $dato['terminado_new'] =$this->Model_General->terminado_new($dato);
            $dato['terminado_bug'] =$this->Model_General->terminado_bug($dato);
            $dato['terminado_improve'] =$this->Model_General->terminado_improve($dato);

            //-----------------REPORTE DE PAGOS LYF-----------------------------
            $dato['list_mes'] = $this->Model_General->get_list_mes();
            $dato['list_anio'] = $this->Model_General->get_list_anio();
            $dato['mes_reporte']=date('m');
            $dato['anio_reporte']=date('Y');
            $dato['pago'] = $this->Model_General->ticket_pago($dato);

            //----------------NO BORRAR QUE ES PARA LOS AVISOS------------------
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            
            $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $_SESSION['foto']=$dato['get_id'][0]['foto'];
            $this->load->view('general/soporte_ti/ticket/index_ticket', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Ticket(){
        if ($this->session->userdata('usuario')) {
            $id_estatus= $this->input->post('status');
            $dato['status']=  $id_estatus;
            $dato['list_busqueda'] =$this->Model_General->busca_ticket($id_estatus);
            $dato['list_historial'] = $this->Model_General->list_historial_ticket();
            $dato['list_horas'] =$this->Model_General->list_horas_x_ticket();
            $this->load->view('general/soporte_ti/ticket/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Ticket(){
        if ($this->session->userdata('usuario')) {
            $dato['list_solicitante'] = $this->Model_General->get_list_solicitante_ticket();
            $dato['list_tipo_ticket'] =$this->Model_General->get_list_tipo_ticket();
            $dato['list_follow_up'] = $this->Model_General->get_list_follow_up_ticket($_SESSION['usuario'][0]['id_usuario']);
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            $dato['list_status'] = $this->Model_General->get_list_status_ticket();
            $this->load->view('general/soporte_ti/ticket/modal_ticket',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Ticket(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_ticket']=  $this->input->post("id_tipo_ticket"); 
            $dato['id_solicitante']= $this->input->post("id_solicitante"); 
            $dato['id_empresa']= $this->input->post("id_empresa"); 
            $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
            $dato['id_subproyecto_soporte']= $this->input->post("id_subproyecto_soporte");
            $dato['ticket_desc']= ucfirst($this->input->post("ticket_desc"));
            $dato['prioridad']= $this->input->post("prioridad");
            $dato['ticket_obs'] = ucfirst($this->input->post("ticket_obs"));

            $anio=date('Y');
            $query_id = $this->Model_General->ultimo_cod_ticket($anio);
            $totalRows_t = count($query_id);

            $aniof=substr($anio, 2,2);
            if($totalRows_t<9)
            {
                $codigo=$aniof."000".($totalRows_t+1);
            }

            if($totalRows_t>8 && $totalRows_t<99)
            {
                $codigo=$aniof."00".($totalRows_t+1);
            }

            if($totalRows_t>98 && $totalRows_t<999)
            {
                $codigo=$aniof."0".($totalRows_t+1);
            }

            if($totalRows_t>998 )
            {
                $codigo=$aniof.($totalRows_t+1);
            }
            $dato['cod_ticket']=$codigo;

            $this->Model_General->insert_ticket($dato);
            
            $ultimo=$this->Model_General->ultimo_id_ticket();
            $dato['id_ticket']=$ultimo[0]['id_ticket'];

            $ultimo2=$this->Model_General->ultimo_id_historial_ticket($dato);
            $dato['ultimo_id_historial']=$ultimo2[0]['id_historial'];

            if($this->input->post("follow_up")!=""){
                foreach($this->input->post("follow_up") as $id_usuario){
                    $dato['id_usuario'] = $id_usuario;
                    $this->Model_General->insert_ticket_follow_up($dato);
                }
            }


            if($_FILES["files"]["name"] != ''){
                $config['upload_path'] = './ticket/';
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                }
                $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf|docx|ppt|pptx|doc';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                for($count = 0; $count<count($_FILES["files"]["name"]); $count++){
                    $path = $_FILES["files"]["name"][$count];
                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli="ticket_".$dato['cod_ticket']."_".$fecha."_".rand(10,99);
                    $nombre = $nombre_soli.".".$ext;
                    $_FILES["file"]["name"] =  $nombre;
                    $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
                    $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
                    $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
                    $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['ruta'] = "ticket/".$nombre;
                        $this->Model_General->insert_historial_archivo($dato);
                    }
                }
            }

            echo $codigo;
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Ticket($id_ticket){
        if ($this->session->userdata('usuario')) {
            $dato['id_ticket']=$id_ticket;
            $ultimo_historial=$this->Model_General->ultimo_id_historial_ticket($dato);

            $dato['ultimo2']=$ultimo_historial[0]['id_status_ticket'];
            $dato['get_id'] = $this->Model_General->get_id_ticket($id_ticket);
            $dato['list_tipo_ticket'] =$this->Model_General->get_list_tipo_ticket();
            $dato['list_solicitante'] = $this->Model_General->get_list_solicitante_ticket();
            $dato['list_follow_up'] = $this->Model_General->get_list_follow_up_ticket($dato['get_id'][0]['id_solicitante']);
            $dato['list_status'] = $this->Model_General->get_list_status_ticket();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            $dato['id_empresa']=$dato['get_id'][0]['id_empresa'];
            $dato['id_proyecto_soporte']=$dato['get_id'][0]['id_proyecto_soporte'];
            $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_x_empresa($dato['id_empresa']);
            $dato['list_subproyecto'] = $this->Model_General->get_list_subproyecto_x_empresa($dato);
            $this->load->view('general/soporte_ti/ticket/upd_modal_ticket', $dato);   
        }else{
            redirect('/login');
        }
    }
    
    public function Update_Ticket(){
        if ($this->session->userdata('usuario')) {
            $dato['id_ticket']= $this->input->post("id_ticket");
            $dato['id_tipo_ticket']= $this->input->post("id_tipo_ticket"); 
            $dato['id_solicitante']= $this->input->post("id_solicitante"); 
            $dato['id_empresa']= $this->input->post("id_empresa"); 
            $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
            $dato['id_subproyecto_soporte']= $this->input->post("id_subproyecto_soporte");
            $desc = mb_strtolower($this->input->post("ticket_desc"));
            $dato['ticket_desc']= ucfirst($desc);
            $obs = mb_strtolower($this->input->post("ticket_obs"));
            $dato['ticket_obs']= ucfirst($obs);
            $dato['id_status_ticket']= $this->input->post("id_status_ticket_i");
            $dato['prioridad']= $this->input->post("prioridad");
            
            $this->Model_General->update_ticket($dato);

            $ultimo2=$this->Model_General->ultimo_id_historial_ticket($dato);
            $dato['ultimo_id_historial']=$ultimo2[0]['id_historial'];

            if($this->input->post("follow_up")!=""){
                $this->Model_General->delete_ticket_follow_up($dato);
                foreach($this->input->post("follow_up") as $id_usuario){
                    $dato['id_usuario'] = $id_usuario;
                    $this->Model_General->insert_ticket_follow_up($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Historial_Ticket($id_ticket,$tipo){
        if ($this->session->userdata('usuario')) { 
            $dato['hora_total'] = $this->Model_General->horas_terminado_historial($id_ticket);
            $dato['get_id'] = $this->Model_General->get_id_ticket($id_ticket);
            $id_empresa=$dato['get_id'][0]['id_empresa'];
            $dato['id_empresa']=$dato['get_id'][0]['id_empresa'];
            $dato['id_status_general']=$dato['get_id'][0]['id_status_ticket'];
            $dato['id_proyecto_soporte']=$dato['get_id'][0]['id_proyecto_soporte'];
            $dato['solicitado'] =$this->Model_General->get_solicitado();
            $dato['list_tipo_ticket'] =$this->Model_General->get_list_tipo_ticket();
            $dato['list_empresa_ticket'] = $this->Model_General->get_list_empresa();
            $dato['list_usuario'] = $this->Model_General->get_list_usuario_cmb_histo_ticket();
            $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_x_empresa($id_empresa);
            $dato['list_subproyecto'] = $this->Model_General->get_list_subproyecto_x_empresa($dato);
            $dato['tipo'] = $tipo;
            
            //----------------NO BORRAR QUE ES PARA LOS AVISOS------------------
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/soporte_ti/ticket/historial', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Historial_Ticket(){
        if ($this->session->userdata('usuario')) {
            $id_ticket= $this->input->post('id_ticket');
            $dato['list_historial_ticket'] = $this->Model_General->get_list_historial_ticket($id_ticket);
            $dato['get_id'] = $this->Model_General->get_id_ticket($id_ticket);
            $this->load->view('general/soporte_ti/ticket/lista_historial', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Nuevo_Historial_Ticket($id_ticket){
        if ($this->session->userdata('usuario')) {
            $dato['id_ticket']=$id_ticket;
            $ultimo_historial=$this->Model_General->ultimo_id_historial_ticket($dato);

            $dato['ultimo']=$ultimo_historial[0]['id_status_ticket'];
            $dato['get_id'] = $this->Model_General->get_id_ticket($id_ticket);
            $dato['solicitado'] =$this->Model_General->get_solicitado();
            $dato['list_tipo_ticket'] =$this->Model_General->get_list_tipo_ticket();
            $dato['list_mantenimiento'] = $this->Model_General->get_list_mantenimiento();
            $dato['list_status'] = $this->Model_General->get_list_status_ticket();
            
            $dato['id_nivel']= $_SESSION['usuario'][0]['id_nivel'];
            $dato['id_ticket'] = $id_ticket;

            $this->load->view('general/soporte_ti/ticket/modal_historial_ticket', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Historial_Ticket(){
        if ($this->session->userdata('usuario')) {
            $dato['id_ticket']= $this->input->post("id_ticket"); 
            $dato['cod_ticket']= $this->input->post("cod_ticket"); 
            $dato['id_status_ticket']= $this->input->post("id_status_ticket_i");
            $dato['horas']= $this->input->post("horas_i");
            $dato['minutos']= $this->input->post("minutos_i");
            $dato['id_mantenimiento']= $this->input->post("id_mantenimiento_i");
            $dato['ticket_obs']=$this->input->post("ticket_obs");
            if($dato['id_mantenimiento']==0){
                $programador=$this->Model_General->traer_programador($dato);

                if(count($programador)>=1){
                    $dato['id_mantenimiento']=$programador[0]['id_mantenimiento'];
                }
            }

            $this->Model_General->insert_historial_ticket($dato);

            $ultimo=$this->Model_General->ultimo_id_historial_ticket($dato);
            $dato['ultimo_id_historial']=$ultimo[0]['id_historial'];

            if($_FILES["files_i"]["name"] != ''){
                $config['upload_path'] = './ticket/';
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                }
                $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf|docx|ppt|pptx|doc';
                $this->load->library('upload', $config); 
                $this->upload->initialize($config);
                    for($count = 0; $count<count($_FILES["files_i"]["name"]); $count++){
                        $path = $_FILES["files_i"]["name"][$count];
                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="ticket_".$dato['cod_ticket']."_".$fecha."_".rand(10,99);
                        $nombre = $nombre_soli.".".$ext;
                        $_FILES["file"]["name"] =  $nombre;
                        $_FILES["file"]["type"] = $_FILES["files_i"]["type"][$count];
                        $_FILES["file"]["tmp_name"] = $_FILES["files_i"]["tmp_name"][$count];
                        $_FILES["file"]["error"] = $_FILES["files_i"]["error"][$count];
                        $_FILES["file"]["size"] = $_FILES["files_i"]["size"][$count];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['ruta'] = "ticket/".$nombre;

                            $this->Model_General->insert_historial_archivo($dato);
                        }
                    }
            }

            if($dato['id_status_ticket']==2 || $dato['id_status_ticket']==22 || 
            $dato['id_status_ticket']==23 || $dato['id_status_ticket']==27){
                $get_id = $this->Model_General->get_id_ticket($dato['id_ticket']);

                if($dato['id_status_ticket']==2){
                    $minuscula = "Presupuesto";
                }
                if($dato['id_status_ticket']==22){
                    $minuscula = "Pendiente de respuesta";
                }
                if($dato['id_status_ticket']==23){
                    $minuscula = "Terminado";
                }
                if($dato['id_status_ticket']==27){
                    $minuscula = "Contestado";
                }

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
                    $mail->setFrom('webcontactos@gllg.edu.pe', "SNAPPY"); //desde donde se envia

                    if($dato['id_status_ticket']==2){
                        $list_presupuesto = $this->Model_General->traer_correo_presupuesto();
                        foreach($list_presupuesto as $list){
                            $mail->addAddress($list['emailp']);
                        }
                    }
                    if($dato['id_status_ticket']==22 || $dato['id_status_ticket']==23){
                        $mail->addAddress($get_id[0]['correo_solicitante']);
                        $list_follow_up = $this->Model_General->traer_correo_follow_up($dato['id_ticket']);
                        foreach($list_follow_up as $list){
                            $mail->addAddress($list['emailp']);
                        }
                    }
                    if($dato['id_status_ticket']==27){
                        $mail->addAddress($get_id[0]['correo_mantenimiento']);
                        $list_contestado = $this->Model_General->traer_correo_contestado($get_id[0]['id_mantenimiento']);
                        foreach($list_contestado as $list){
                            $mail->addAddress($list['emailp']);
                        }
                    }

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "Ticket ".$get_id[0]['cod_ticket']." ".$minuscula;
                
                    $mail->Body = '<FONT SIZE=3>
                                        ¡Hola!<br><br>
                                        El siguiente ticket '.$get_id[0]['cod_ticket'].' se encuentra con el estado '.$minuscula.'.<br><br>
                                        <div style="border: 1px solid black;margin-left: 30px;padding: 5px 0 0 25px;background-color:#E0D9DF;">
                                            <table width="100%">
                                                <tr>
                                                    <td>Empresa: '.$get_id[0]['cod_empresa'].'</td>
                                                    <td>Tipo: '.$get_id[0]['nom_tipo_ticket'].'</td>
                                                    <td>Solicitado por: '.$get_id[0]['solicitante'].'</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Follow Up: '.$get_id[0]['follow_up'].'</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Proyecto: '.$get_id[0]['proyecto'].'</td>
                                                    <td>Sub-Proyecto: '.$get_id[0]['subproyecto'].'</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Descripción: '.$get_id[0]['ticket_desc'].'</td>
                                                </tr>
                                            </table>
                                        </div><br>
                                        Puedes usar el link abajo para aceder directamente:<br>
                                        https://www.snappy.org.pe/index.php?/General/Historial_Ticket/'.$get_id[0]['id_ticket'].'/1<br><br>
                                        Agradecemos tu pronta respuesta.<br>
                                        Que tengas un excelente dia.<br>
                                        Snappy
                                    </FONT SIZE>';
                
                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Historial_Ticket($id_historial){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_id_historial_ticket($id_historial);
            $dato['list_mantenimiento'] = $this->Model_General->get_list_mantenimiento();
            $dato['list_status'] = $this->Model_General->get_list_status_ticket();
            $dato['list_archivo'] = $this->Model_General->get_list_historial_archivo($id_historial);

            $this->load->view('general/soporte_ti/ticket/upd_historial_ticket', $dato);  
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Historial_Ticket(){
        $dato['id_ticket']= $this->input->post("id_ticket"); 
        $dato['cod_ticket']= $this->input->post("cod_ticket"); 
        $dato['id_historial']= $this->input->post("id_historial"); 
        $dato['id_status_ticket']= $this->input->post("id_status_ticket_u");
        $dato['horas']= $this->input->post("horas_u");
        $dato['minutos']= $this->input->post("minutos_u");
        $dato['id_mantenimiento']= $this->input->post("id_mantenimiento_u");
        //$desc = mb_strtolower($this->input->post("ticket_obs"));
        $dato['ticket_obs']= $this->input->post("ticket_obs_u");//ucfirst($desc);
        
        $validador=$this->Model_General->ultimo_historial_ticket($dato);

        if($validador[0]['id_historial']==$dato['id_historial']){
            $dato['actualiza']=1;
        }else{
            $dato['actualiza']=0;
        }

        if($dato['id_status_ticket']==20){
            $programador=$this->Model_General->traer_programador($dato);

            if($programador[0]['id_mantenimiento']==$dato['id_mantenimiento']){
                $dato['cambia_mant']=0;
            }else{
                $dato['cambia_mant']=1;
            }
        }

        $this->Model_General->update_historial_ticket($dato); 

        $dato['ultimo_id_historial']= $this->input->post("id_historial"); 

        if($_FILES["files_u"]["name"] != ''){
            $config['upload_path'] = './ticket/';
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
            }
            $config["allowed_types"] = 'png|jpeg|jpg|xls|xlsx|pdf|docx|ppt|pptx|doc';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
                for($count = 0; $count<count($_FILES["files_u"]["name"]); $count++){
                    $path = $_FILES["files_u"]["name"][$count];
                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli="ticket_".$dato['cod_ticket']."_".$fecha."_".rand(10,99);
                    $nombre = $nombre_soli.".".$ext;
                    $_FILES["file"]["name"] =  $nombre;
                    $_FILES["file"]["type"] = $_FILES["files_u"]["type"][$count];
                    $_FILES["file"]["tmp_name"] = $_FILES["files_u"]["tmp_name"][$count];
                    $_FILES["file"]["error"] = $_FILES["files_u"]["error"][$count];
                    $_FILES["file"]["size"] = $_FILES["files_u"]["size"][$count];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['ruta'] = "ticket/".$nombre;

                        $this->Model_General->insert_historial_archivo($dato);
                    }
                }
        }
    }

    public function Delete_Historial_Ticket(){
        if ($this->session->userdata('usuario')) {
            $dato['id_historial']= $this->input->post("id_historial"); 
            $dato['id_ticket']= $this->input->post("id_ticket"); 

            $get_id=$this->Model_General->ultimo_id_historial_ticket($dato);

            $dato['validador']=0;

            if($get_id[0]['id_historial']==$dato['id_historial']){
                $dato['validador']=1;
                $dato['anterior_id_status_ticket']=$get_id[1]['id_status_ticket'];
            }
            
            $this->Model_General->delete_historial_ticket($dato);

        }else{
            redirect('');
        }
    }

    public function Descargar_Archivo($id_historial_archivo) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_General->get_id_historial_archivo($id_historial_archivo);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo() {
        $id_historial_archivo = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_General->get_id_historial_archivo($id_historial_archivo);

        if (file_exists($dato['get_file'][0]['archivo'])) {
            unlink($dato['get_file'][0]['archivo']);
        }
        $this->Model_General->delete_archivo_ticket($id_historial_archivo);
    }

    public function Excel_Ticket(){
        $id_estatus= $this->input->post("id_status");
        $dato['list_busqueda'] =$this->Model_General->busca_ticket($id_estatus);
        $dato['list_horas'] =$this->Model_General->list_horas_x_ticket();
        
        if($id_estatus==5){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $spreadsheet->getActiveSheet()->setTitle('Tickets');

            $sheet->setAutoFilter('A1:M1');

            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(14);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(40);
            $sheet->getColumnDimension('H')->setWidth(40);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(18);
            $sheet->getColumnDimension('L')->setWidth(18);
            $sheet->getColumnDimension('M')->setWidth(15);

            $sheet->getStyle('A1:M1')->getFont()->setBold(true);  

            $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
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
    

            $sheet->getStyle("A1:M1")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A1", 'Mes');
            $sheet->setCellValue("B1", 'Código');   
            $sheet->setCellValue("C1", 'Tipo'); 
            $sheet->setCellValue("D1", 'Prioridad');      
            $sheet->setCellValue("E1", 'Empresa');
            $sheet->setCellValue("F1", 'Proyecto');
            $sheet->setCellValue("G1", 'Sub-Proyecto');
            $sheet->setCellValue("H1", 'Descripción');
            $sheet->setCellValue("I1", 'Fecha');
            $sheet->setCellValue("J1", 'Solicitante');
            $sheet->setCellValue("K1", 'Terminado Por');
            $sheet->setCellValue("L1", 'Horas');
            $sheet->setCellValue("M1", 'Estado'); 

            $contador=1;

            foreach($dato['list_busqueda'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                //$sheet->setCellValue("A{$contador}", substr($list['nom_mes'], 0,3)."-".substr($list['anio'], 2,2));
                $sheet->setCellValue("B{$contador}", $list['cod_ticket']);
                $sheet->setCellValue("C{$contador}", $list['nom_tipo_ticket']);
                $sheet->setCellValue("D{$contador}", $list['v_prioridad']);
                $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
                $sheet->setCellValue("F{$contador}", $list['proyecto']);
                $sheet->setCellValue("G{$contador}", $list['subproyecto']);
                $sheet->setCellValue("H{$contador}", $list['ticket_desc']);

                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

                $sheet->setCellValue("J{$contador}", $list['cod_soli']);
                $sheet->setCellValue("K{$contador}", $list['cod_terminado_por']);

                $hym=intdiv($list['minutos'],60); 
                $min_conv=$list['minutos']%60; 

                if($list['horas']==0 && $list['minutos']!=0){
                    $tiempo=$list['minutos']."min";
                }elseif($list['horas']!=0 && $list['minutos']!=0){
                    $tiempo=($list['horas']+$hym)."h"." ".$min_conv."min";
                }elseif($list['horas']!=0 && $list['minutos']==0){
                    $tiempo=$list['horas']."h";
                }else{
                    $tiempo="";
                }

                $sheet->setCellValue("L{$contador}", $tiempo);
                $sheet->setCellValue("M{$contador}", $list['nom_status']);
            }
        
        }else if($id_estatus==7){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $spreadsheet->getActiveSheet()->setTitle('Tickets');

            $sheet->setAutoFilter('A1:O1');

            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(14);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(40);
            $sheet->getColumnDimension('H')->setWidth(40);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(18);
            $sheet->getColumnDimension('L')->setWidth(18);
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(10);

            $sheet->getStyle('A1:O1')->getFont()->setBold(true);  

            $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
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
    
            $sheet->getStyle("A1:O1")->applyFromArray($styleThinBlackBorderOutline);
           
            $sheet->setCellValue("A1", 'Mes');
            $sheet->setCellValue("B1", 'Código');   
            $sheet->setCellValue("C1", 'Tipo'); 
            $sheet->setCellValue("D1", 'Prioridad');      
            $sheet->setCellValue("E1", 'Empresa');
            $sheet->setCellValue("F1", 'Proyecto');
            $sheet->setCellValue("G1", 'Sub-Proyecto');
            $sheet->setCellValue("H1", 'Descripción');
            $sheet->setCellValue("I1", 'Fecha');
            $sheet->setCellValue("J1", 'Solicitante');
            $sheet->setCellValue("K1", 'Terminado Por');
            $sheet->setCellValue("L1", 'Horas');
            $sheet->setCellValue("M1", 'Estado'); 
            $sheet->setCellValue("N1", 'Estado'); 
            $sheet->setCellValue("O1", 'S/ 10'); 

            $contador=1;
               
            foreach($dato['list_busqueda'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                if($id_estatus==7 || $list['id_status_ticket']==34){
                    $sheet->setCellValue("A{$contador}", $list['nom_mes_revisado']);  
                }
                
                $sheet->setCellValue("B{$contador}", $list['cod_ticket']);
                $sheet->setCellValue("C{$contador}", $list['nom_tipo_ticket']); 
                $sheet->setCellValue("D{$contador}", $list['v_prioridad']);
                $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
                $sheet->setCellValue("F{$contador}", $list['proyecto']);
                $sheet->setCellValue("G{$contador}", $list['subproyecto']);
                $sheet->setCellValue("H{$contador}", $list['ticket_desc']);

                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

                $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
                $sheet->setCellValue("K{$contador}", $list['cod_terminado_por']);

                $hym=intdiv($list['minutos'],60); 
                $min_conv=$list['minutos']%60; 

                if($list['horas']==0 && $list['minutos']!=0){
                    $tiempo=$list['minutos']."min";
                }elseif($list['horas']!=0 && $list['minutos']!=0){
                    $tiempo=($list['horas']+$hym)."h"." ".$min_conv."min";
                }elseif($list['horas']!=0 && $list['minutos']==0){
                    $tiempo=$list['horas']."h";
                }else{
                    $tiempo="";
                }
                
                $sheet->setCellValue("L{$contador}", $tiempo);
                $sheet->setCellValue("M{$contador}", $list['nom_status']);

                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list['fecha_registro_th']));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                

                if($list['id_tipo_ticket']!=2 && ($id_estatus==7 || $list['id_status_ticket']==34)){
                    $sheet->setCellValue("O{$contador}", $list['tiempo']);
                }
            }
        }else{
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $spreadsheet->getActiveSheet()->setTitle('Tickets');

            $sheet->setAutoFilter('A1:N1');

            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(14);
            $sheet->getColumnDimension('D')->setWidth(14);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(40);
            $sheet->getColumnDimension('H')->setWidth(40);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(18);
            $sheet->getColumnDimension('L')->setWidth(18);
            $sheet->getColumnDimension('M')->setWidth(15);

            $sheet->getStyle('A1:N1')->getFont()->setBold(true);  

            $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
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
    
            $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);
           
            $sheet->setCellValue("A1", 'Mes');
            $sheet->setCellValue("B1", 'Código');   
            $sheet->setCellValue("C1", 'Tipo'); 
            $sheet->setCellValue("D1", 'Prioridad');      
            $sheet->setCellValue("E1", 'Empresa');
            $sheet->setCellValue("F1", 'Proyecto');
            $sheet->setCellValue("G1", 'Sub-Proyecto');
            $sheet->setCellValue("H1", 'Descripción');
            $sheet->setCellValue("I1", 'Fecha');
            $sheet->setCellValue("J1", 'Solicitante');
            $sheet->setCellValue("K1", 'Terminado Por');
            $sheet->setCellValue("L1", 'Horas');
            $sheet->setCellValue("M1", 'Estado'); 
            $sheet->setCellValue("N1", 'S/ 10'); 

            $contador=1;
               
            foreach($dato['list_busqueda'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                if($id_estatus==7 || $list['id_status_ticket']==34){
                    $sheet->setCellValue("A{$contador}", $list['nom_mes_revisado']);  
                }
                
                $sheet->setCellValue("B{$contador}", $list['cod_ticket']);
                $sheet->setCellValue("C{$contador}", $list['nom_tipo_ticket']); 
                $sheet->setCellValue("D{$contador}", $list['v_prioridad']);
                $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
                $sheet->setCellValue("F{$contador}", $list['proyecto']);
                $sheet->setCellValue("G{$contador}", $list['subproyecto']);
                $sheet->setCellValue("H{$contador}", $list['ticket_desc']);

                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

                $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
                $sheet->setCellValue("K{$contador}", $list['cod_terminado_por']);

                $hym=intdiv($list['minutos'],60); 
                $min_conv=$list['minutos']%60; 

                if($list['horas']==0 && $list['minutos']!=0){
                    $tiempo=$list['minutos']."min";
                }elseif($list['horas']!=0 && $list['minutos']!=0){
                    $tiempo=($list['horas']+$hym)."h"." ".$min_conv."min";
                }elseif($list['horas']!=0 && $list['minutos']==0){
                    $tiempo=$list['horas']."h";
                }else{
                    $tiempo="";
                }

                $sheet->setCellValue("L{$contador}", $tiempo);
                $sheet->setCellValue("M{$contador}", $list['nom_status']);
                if($list['id_tipo_ticket']!=2 && ($id_estatus==7 || $list['id_status_ticket']==34)){
                    $sheet->setCellValue("N{$contador}", $list['tiempo']);
                }
            }
            
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tickets (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Historial_Ticket($id_ticket){
        $list_ticket = $this->Model_General->get_list_historial_ticket($id_ticket);
        $get_id = $this->Model_General->get_id_ticket($id_ticket);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Historial Ticket');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(30);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
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

        $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Horas');            
        $sheet->setCellValue("B1", 'Solicitante');
        $sheet->setCellValue("C1", 'Usuario'); 
        $sheet->setCellValue("D1", 'Fecha');            
        $sheet->setCellValue("E1", 'Observaciones');
        $sheet->setCellValue("F1", 'Estado'); 

        $contador=1;
        
        foreach($list_ticket as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            if($list['horas']!="00:00:00"){
                $sheet->setCellValue("A{$contador}", $list['horas']);
            }else{
                $sheet->setCellValue("A{$contador}", "");
            }
            $sheet->setCellValue("B{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("C{$contador}", $list['colaborador_codigo']);

            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            
            $sheet->setCellValue("E{$contador}", $list['ticket_obs']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Historial Ticket '.$get_id[0]['cod_ticket'].' (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------INFORME------------------------------------
    public function Informe(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']=date('Y');
            $dato['list_anio'] = $this->Model_General->get_list_anio();
            $dato['list_informe'] =$this->Model_General->list_informe($dato);

            //----------------NO BORRAR QUE ES PARA LOS AVISOS------------------
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/soporte_ti/informe/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Informe(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anio");
            $dato['list_informe'] =$this->Model_General->list_informe($dato);

            $this->load->view('general/soporte_ti/informe/list_informe', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Bloquear_Ticket(){
        if ($this->session->userdata('usuario')) {
            foreach($_POST['id_informe'] as $list){
                $dato['id_informe'] = $list;
                $id=explode("-", $dato['id_informe']);
                $dato['semana'] = $id[0];
                $dato['anio'] = $id[1];

                $dato['get_ticket'] = $this->Model_General->ticket_revisados($dato);
                
                if(count($dato['get_ticket'])>0){
                    $result="";

                    foreach($dato['get_ticket'] as $char){

                        $result.= $char['id_ticket'].",";

                    }

                    $cadena = substr($result, 0, -1);

                    $dato['cadena'] = "(".$cadena.")";

                    $this->Model_General->bloqueo_ticket($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Informe_Periodo($semana,$anio){
        $dato['semana']=$semana;
        $dato['anio']=$anio;

        $dato['list_revisado'] =$this->Model_General->list_informe_ticket_revisado($semana,$anio);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Informe Soporte TI');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->getColumnDimension('L')->setWidth(11);

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

        $sheet->setCellValue("A1", 'Semana');            
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Prioridad');
        $sheet->setCellValue("E1", 'Empresa');
        $sheet->setCellValue("F1", 'Proyecto');
        $sheet->setCellValue("G1", 'Sub-Proyecto');
        $sheet->setCellValue("H1", 'Descripción'); 
        $sheet->setCellValue("I1", 'Fecha Registro'); 
        $sheet->setCellValue("J1", 'Solicitante');
        $sheet->setCellValue("K1", 'Horas');  
        $sheet->setCellValue("L1", 'Estado');

        $contador=1;
        
        foreach($dato['list_revisado'] as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("I{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            //$spreadsheet->getActiveSheet()->getStyle("L{$contador}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('34a69d');

            $sheet->setCellValue("A{$contador}", $list['semana']." (".$list['primer']." - ".$list['ultimo'].")"); 
            $sheet->setCellValue("B{$contador}", $list['cod_ticket']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_ticket']);
            $sheet->setCellValue("D{$contador}", $list['prioridad']);
            $sheet->setCellValue("E{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("F{$contador}", $list['proyecto']);
            $sheet->setCellValue("G{$contador}", $list['subproyecto']);
            $sheet->setCellValue("H{$contador}", $list['ticket_desc']);
            $sheet->setCellValue("I{$contador}", $list['fecha_registro']);
            $sheet->setCellValue("J{$contador}", $list['cod_soli']);
            if ($list['horas'] != 0 || $list['minutos'] != 0) {
                if ($list['minutos'] == "0") {
                    $minuto = "00";
                } else {
                    $minuto = $list['minutos'];
                }
                $sheet->setCellValue("K{$contador}", $list['horas'] . ":" . $minuto);
            }
            $sheet->setCellValue("L{$contador}", $list['nom_status']);

        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Soporte TI - Informe (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Informe($anio){
        $dato['anio']=$anio;
        $dato['list_informe'] =$this->Model_General->list_informe($dato);
        //$dato['list_hrs']=$this->Model_General->list_informe_hrs();

        $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:U2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:U2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Informe Soporte TI');

            //$sheet->setAutoFilter('A1');
    
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(5);
            $sheet->getColumnDimension('C')->setWidth(5);
            $sheet->getColumnDimension('D')->setWidth(5);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(5);
            $sheet->getColumnDimension('G')->setWidth(5);
            $sheet->getColumnDimension('H')->setWidth(5);
            $sheet->getColumnDimension('I')->setWidth(8);
            $sheet->getColumnDimension('J')->setWidth(5);
            $sheet->getColumnDimension('K')->setWidth(5);
            $sheet->getColumnDimension('L')->setWidth(5);
            $sheet->getColumnDimension('M')->setWidth(8);
            $sheet->getColumnDimension('N')->setWidth(5);
            $sheet->getColumnDimension('O')->setWidth(5);
            $sheet->getColumnDimension('P')->setWidth(5);
            $sheet->getColumnDimension('Q')->setWidth(8);
            $sheet->getColumnDimension('R')->setWidth(10);
            $sheet->getColumnDimension('S')->setWidth(5);
            $sheet->getColumnDimension('T')->setWidth(5);
            $sheet->getColumnDimension('U')->setWidth(5);
            $sheet->getColumnDimension('V')->setWidth(12);

            $sheet->getStyle('A1:V2')->getFont()->setBold(true);  
    
            $spreadsheet->getActiveSheet()->getStyle("A1:V2")->getFill()
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
    
            $sheet->getStyle("A1:V2")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:E1');
            $sheet->mergeCells('F1:I1');
            $sheet->mergeCells('J1:M1');
            $sheet->mergeCells('N1:Q1');
            $sheet->mergeCells('R1:V1');

            $sheet->setCellValue("A1", 'Semana');            
            $sheet->setCellValue("B1", 'Bug');
            $sheet->setCellValue("F1", 'Improve');
            $sheet->setCellValue("J1", 'News'); 
            $sheet->setCellValue("N1", 'TOTALES'); 
            $sheet->setCellValue("R1", 'Estado');  

            $sheet->setCellValue("B2", 'SOL');            
            $sheet->setCellValue("C2", 'TER');
            $sheet->setCellValue("D2", 'RVS');
            $sheet->setCellValue("E2", 'Horas'); 
            $sheet->setCellValue("F2", 'SOL'); 
            $sheet->setCellValue("G2", 'TER');  
            $sheet->setCellValue("H2", 'RVS');  
            $sheet->setCellValue("I2", 'Horas');  
            $sheet->setCellValue("J2", 'SOL'); 
            $sheet->setCellValue("K2", 'TER');  
            $sheet->setCellValue("L2", 'RVS');  
            $sheet->setCellValue("M2", 'Horas'); 
            $sheet->setCellValue("N2", 'SOL');  
            $sheet->setCellValue("O2", 'TER');  
            $sheet->setCellValue("P2", 'RVS');  
            $sheet->setCellValue("Q2", 'Horas');  
            $sheet->setCellValue("R2", 'ESTADO'); 
            $sheet->setCellValue("s2", 'SOL');  
            $sheet->setCellValue("t2", 'TER');  
            $sheet->setCellValue("u2", 'RVS');  
            $sheet->setCellValue("v2", 'P Respuesta'); 

        if(count($dato['list_informe']) > 0){
             
            $contador=2;
            
	        foreach($dato['list_informe'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:V{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:V{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:V{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", $list['semana']." (".$list['primer']." - ".$list['ultimo'].")");
                $sheet->setCellValue("B{$contador}", $list['bug_solici']);
                $sheet->setCellValue("C{$contador}", $list['bug_termi']);
                $sheet->setCellValue("D{$contador}", $list['bug_revi']);

                $h=$list['hr_bug_ter_rev'];
                $minutes = $list['min_bug_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora=$diff->format('%h');
                $minuto=$diff->format('%i');
                //if($h!=0){ $m=" hr"; }else{$m=" min";};
                $sheet->setCellValue("E{$contador}", str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT));


                $sheet->setCellValue("F{$contador}", $list['improve_solici']);
                $sheet->setCellValue("G{$contador}", $list['improve_termi']);
                $sheet->setCellValue("H{$contador}", $list['improve_revi']);

                $h=$list['hr_improve_ter_rev'];
                $minutes = $list['min_improve_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora=$diff->format('%h');
                $minuto=$diff->format('%i'); 
                //if($h!=0){ $m=" hr"; }else{$m=" min";};
                $sheet->setCellValue("I{$contador}", str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT));


                $sheet->setCellValue("J{$contador}", $list['new_solici']);
                $sheet->setCellValue("K{$contador}", $list['new_termi']);
                $sheet->setCellValue("L{$contador}", $list['new_revi']);

                $h=$list['hr_new_ter_rev'];
                $minutes = $list['min_new_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora=$diff->format('%h');
                $minuto=$diff->format('%i'); 
                //if($h!=0){ $m=" hr"; }else{$m=" min";};
                $sheet->setCellValue("M{$contador}", str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT));

                $sheet->setCellValue("N{$contador}", $list['total_solicitado']);
                $sheet->setCellValue("O{$contador}", $list['total_terminado']);
                $sheet->setCellValue("P{$contador}", $list['total_revisado']);

                

                $h=$list['hr_total_ter'];
                $minutes = $list['min_total_ter'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora=$diff->format('%h');
                $minuto=$diff->format('%i'); 
                //if($h!=0){ $m=" hr"; }else{$m=" min";};
                $sheet->setCellValue("Q{$contador}", str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT));
                //echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT); 


                $sheet->setCellValue("R{$contador}", $list['estado_semana']);
                $sheet->setCellValue("S{$contador}", $list['t_estado_soli']);
                $sheet->setCellValue("T{$contador}", $list['t_estado_asig']);
                $sheet->setCellValue("U{$contador}", $list['t_estado_trami']);
                $sheet->setCellValue("V{$contador}", $list['t_estado_pendresp']);

            }
    
            $writer = new Xlsx($spreadsheet);
            $filename = 'Soporte TI - Informe (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }else{
           

            $writer = new Xlsx($spreadsheet);
            $filename = 'Soporte TI - Informe (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }
    }
    //-------------------------------------PROYECTOS-------------------------------------
    public function Soporte_Proyecto() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_soporte();
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $this->load->view('general/soporte_ti/proyecto/index',$dato);
    }

    public function Modal_Soporte_Proyecto(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            
            $this->load->view('general/soporte_ti/proyecto/modal_proyecto',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Soporte_Proyecto(){
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['proyecto']= $this->input->post("proyecto");

        $total=count($this->Model_General->valida_reg_proyecto_soporte($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_proyecto_soporte($dato);
        }
    }

    public function Modal_Update_Soporte_Proyecto($id_proyecto_soporte){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_id_proyecto_soporte($id_proyecto_soporte);
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            $this->load->view('general/soporte_ti/proyecto/upd_modal_proyecto', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Soporte_Proyecto(){
        $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['proyecto']= $this->input->post("proyecto");
        $dato['id_status']= $this->input->post("id_status");

        $this->Model_General->update_proyecto_soporte($dato);
    }

    public function Excel_Soporte_Proyecto(){
        $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_soporte();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Proyectos_TI');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
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

        $sheet->setCellValue("A1", 'Empresa');            
        $sheet->setCellValue("B1", 'Proyecto');
        $sheet->setCellValue("C1", 'Estado'); 

        $contador=1;
        
        foreach($dato['list_proyecto'] as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['proyecto']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Proyectos TI (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------SUBPROYECTOS-----------------------------------
    public function Soporte_Subproyecto() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_subproyecto'] = $this->Model_General->get_list_subproyecto_soporte();
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
        
        $this->load->view('general/soporte_ti/subproyecto/index',$dato);
    }

    public function Modal_Soporte_Subproyecto(){
        if ($this->session->userdata('usuario')) {
            //$dato['list_empresa'] = $this->Model_General->get_list_empresa_disctinc();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            
            $this->load->view('general/soporte_ti/subproyecto/modal_subproyecto',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Busca_Proyecto() {
        if ($this->session->userdata('usuario')) {
            $id_empresa= $this->input->post("id_empresa");
            $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_x_empresa($id_empresa);
            $this->load->view('general/soporte_ti/subproyecto/list_proyecto', $dato);
        }
        else{
            redirect('');
        }
    }

    public function Insert_Soporte_Subproyecto(){
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
        $dato['subproyecto']= $this->input->post("subproyecto");

        $total=count($this->Model_General->valida_reg_subproyecto_soporte($dato));
        
        if($total>0){
            echo "error";
        }else{
            $this->Model_General->insert_subproyecto_soporte($dato);
        }
    }

    public function Modal_Update_Soporte_Subproyecto($id_subproyecto_soporte){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_id_subproyecto_soporte($id_subproyecto_soporte);
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa();
            
            $id_empresa=$dato['get_id'][0]['id_empresa'];
            $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_x_empresa($id_empresa);
            $this->load->view('general/soporte_ti/subproyecto/upd_modal_subproyecto', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Soporte_Subproyecto(){
        $dato['id_subproyecto_soporte']= $this->input->post("id_subproyecto_soporte");
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte"); 
        $dato['subproyecto']= $this->input->post("subproyecto");
        $dato['id_status']= $this->input->post("id_status");

        $this->Model_General->update_subproyecto_soporte($dato);
    }

    public function Excel_Soporte_Subproyecto(){
        $dato['list_subproyecto'] = $this->Model_General->get_list_subproyecto_soporte();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Subproyectos_TI');

        $sheet->setAutoFilter('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');            
        $sheet->setCellValue("B1", 'Proyecto');
        $sheet->setCellValue("C1", 'Subproyecto');  
        $sheet->setCellValue("D1", 'Estado');  

        $contador=1;
        
        foreach($dato['list_subproyecto'] as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['proyecto']);
            $sheet->setCellValue("C{$contador}", $list['subproyecto']);
            $sheet->setCellValue("D{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sub-Proyectos TI (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------OTROS------------------------------------
    public function Busca_Menu() {
        if ($this->session->userdata('usuario')) {
            $id_empresa= $this->input->post("id_empresa");
            $dato['list_proyecto'] = $this->Model_General->get_list_menu_empresa($id_empresa);
            $this->load->view('general/soporte_ti/subproyecto/list_proyecto', $dato);
        }
        else{
            redirect('');
        }
    }

    public function Reporte_Pagos(){
        if ($this->session->userdata('usuario')) { 
            $dato['mes_reporte']=$this->input->post("mes_reporte");
            $dato['anio_reporte']=$this->input->post("anio_reporte");
            $dato['pago'] = $this->Model_General->ticket_pago($dato);

            $this->load->view('general/soporte_ti/ticket/reporte_pago', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Busca_Follow_Up_Ticket() {
        if ($this->session->userdata('usuario')) {
            $id_solicitante= $this->input->post("id_solicitante");
            $dato['list_follow_up'] = $this->Model_General->get_list_follow_up_ticket($id_solicitante);
            $this->load->view('general/soporte_ti/ticket/list_follow_up', $dato);
        }else{
            redirect('');
        }
    }

    public function Busca_Proyecto_Ticket() {
        if ($this->session->userdata('usuario')) {
            $id_empresa= $this->input->post("id_empresa");
            $dato['list_proyecto'] = $this->Model_General->get_list_proyecto_x_empresa($id_empresa);
            $this->load->view('general/soporte_ti/ticket/list_proyecto', $dato);
        }else{
            redirect('');
        }
    }

    public function Busca_Subproyecto_Ticket() {
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
            $dato['list_proyecto'] = $this->Model_General->get_list_subproyecto_x_empresa($dato);
            $this->load->view('general/soporte_ti/ticket/list_subproyecto', $dato);
        }else{
            redirect('');
        }
    }

    public function Cambia_Status() {
        if ($this->session->userdata('usuario')) {
            $dato['horas']= $this->input->post("horas");
            $dato['minutos']= $this->input->post("minutos");
            
            if($dato['horas']>="2"){
                $dato['id_status_general']=2;
            }else{
                $dato['id_status_general']=20;
            }

            $dato['list_status'] = $this->Model_General->get_id_status_ticket($dato);

            $this->load->view('general/soporte_ti/ticket/list_status', $dato);
        }
        else{
            redirect('');
        }
    }

    public function Insert_Completados(){
        if ($this->session->userdata('usuario')) { 
            foreach($_POST['id_ticket'] as $ticket){
                $dato['id_ticket'] = $ticket;
                $ultimo=$this->Model_General->ultimo_id_historial_ticket($dato);
                $dato['id_mantenimiento']=$ultimo[0]['id_mantenimiento'];
                $this->Model_General->insert_completado($dato); 
            }
        }else{
            redirect('/login');
        }
    }

    public function Insert_Cancelados(){
        if ($this->session->userdata('usuario')) { 
            foreach($_POST['id_ticket'] as $ticket){
                $dato['id_ticket'] = $ticket;
                $ultimo=$this->Model_General->ultimo_id_historial_ticket($dato);
                $dato['id_mantenimiento']=$ultimo[0]['id_mantenimiento'];
                $this->Model_General->insert_cancelado($dato); 
            }
        }else{
            redirect('/login');
        }
    }

    public function Proyectos(){
        if ($this->session->userdata('usuario')) {
            $data['row_st'] = $this->Admin_model->get_row_solicitadot();
            $data['row_s'] =$this->Admin_model->get_row_solicitado();
            $data['row_at'] = $this->Admin_model->get_row_asignadot();
            $data['row_a'] = $this->Admin_model->get_row_asignado();
            $data['row_ett'] = $this->Admin_model->get_row_entramitet();
            $data['row_et'] = $this->Admin_model->get_row_entramite();
            $data['row_prt'] =$this->Admin_model->get_row_pendientet();
            $data['row_pr'] =$this->Admin_model->get_row_pendiente();
            $data['row_tp2'] =$this->Admin_model->get_row_tp2();
            $data['row_tp'] = $this->Admin_model->get_row_tp();
            //$data['row_p'] =$this->Admin_model->get_row_p();
            $this->load->view('general/proyecto/index_proyect', $data);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Valida_Duplicado_Ticket(){
        $dato['id_tipo_ticket']= $this->input->post("id_tipo_ticket"); 
        $dato['id_empresa']= $this->input->post("id_empresa"); 
        $dato['id_proyecto_soporte']= $this->input->post("id_proyecto_soporte");
        $dato['id_subproyecto_soporte']= $this->input->post("id_subproyecto_soporte");
        
        $total=count($this->Model_General->valida_reg_ticket($dato));
        
        if($total>0){
            echo "error";
        }
    }
    //----------------------------------------------FONDOS DE INTRANET-----------------------------------------
    public function Fondo_Extranet() {
        if ($this->session->userdata('usuario')) {
            $dato['confg_foto'] = $this->Model_General->get_confg_foto();
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/fondo_extranet/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Fondo_Extranet() {
        if ($this->session->userdata('usuario')) {
            $dato['list_fondo_extranet'] = $this->Model_General->get_list_fondo_extranet();
            $this->load->view('general/fondo_extranet/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Fondo_Extranet(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('general/fondo_extranet/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Fondo_Extranet(){
        $get_id = $this->Model_General->valida_insert_fondo_extranet();

        if(count($get_id)>0){
            rename ($get_id[0]['imagen'], "extranet/historico_".$get_id[0]['id_fondo'].substr($get_id[0]['imagen'],-4));
            $dato['id_fondo_antiguo'] = $get_id[0]['id_fondo'];
            $dato['imagen_antigua'] = "extranet/historico_".$get_id[0]['id_fondo'].substr($get_id[0]['imagen'],-4);
            $this->Model_General->desactivar_fondo_extranet($dato);
        }

        $dato['titulo']= $this->input->post("titulo_i");

        if($_FILES["imagen_i"]["name"] != ""){
            $config['upload_path'] = './extranet/';
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./extranet/', 0777);
            }
            $config["allowed_types"] = 'jpg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["imagen_i"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = "fondo.jpg";
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["imagen_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["imagen_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["imagen_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["imagen_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['imagen'] = "extranet/".$nombre;
            }     
        }

        $this->Model_General->insert_fondo_extranet($dato);
    }
    
    public function Modal_Update_Fondo_Extranet($id_fondo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_list_fondo_extranet($id_fondo);
            $this->load->view('general/fondo_extranet/modal_editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Fondo_Extranet(){
        $dato['id_fondo']= $this->input->post("id_fondo");
        $dato['titulo']= $this->input->post("titulo_u");
        $estado = $this->input->post("estado");
        $dato['imagen']= $this->input->post("imagen_actual");

        $get_id = $this->Model_General->get_list_fondo_extranet($dato['id_fondo']);

        if($_FILES["imagen_u"]["name"] != ""){
            if (file_exists($dato['imagen'])) { 
                unlink($dato['imagen']);
            }
            $config['upload_path'] = './extranet/';
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./extranet/', 0777);
            }
            $config["allowed_types"] = 'jpg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["imagen_u"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if($estado==2){
                $nombre = "fondo.jpg";
            }else{
                $nombre = "historico_".$get_id[0]['id_fondo'].substr($get_id[0]['imagen'],-4);
            }
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["imagen_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["imagen_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["imagen_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["imagen_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['imagen'] = "extranet/".$nombre;
            }     
        }

        $this->Model_General->update_fondo_extranet($dato);
    }

    public function Cambiar_Estado_Fondo_Extranet(){
        $dato['id_fondo']= $this->input->post("id_fondo");
        $dato['estado']= $this->input->post("estado");

        $get_id = $this->Model_General->get_list_fondo_extranet($dato['id_fondo']);

        if($dato['estado']==3){
            rename ($get_id[0]['imagen'], "extranet/historico_".$get_id[0]['id_fondo'].substr($get_id[0]['imagen'],-4));
            $dato['id_fondo_antiguo'] = $get_id[0]['id_fondo'];
            $dato['imagen_antigua'] = "extranet/historico_".$get_id[0]['id_fondo'].substr($get_id[0]['imagen'],-4);
            $this->Model_General->desactivar_fondo_extranet($dato);
        }else{
            $get_ultimo = $this->Model_General->valida_insert_fondo_extranet();

            if(count($get_ultimo)>0){
                rename ($get_ultimo[0]['imagen'], "extranet/historico_".$get_ultimo[0]['id_fondo'].substr($get_ultimo[0]['imagen'],-4));
                $dato['id_fondo_antiguo'] = $get_ultimo[0]['id_fondo'];
                $dato['imagen_antigua'] = "extranet/historico_".$get_ultimo[0]['id_fondo'].substr($get_ultimo[0]['imagen'],-4);
                $this->Model_General->desactivar_fondo_extranet($dato);
            }

            $this->Model_General->reiniciar_estado_fondo_extranet();
            rename ($get_id[0]['imagen'], "extranet/fondo.jpg");
            $dato['id_fondo_antiguo'] = $get_id[0]['id_fondo'];
            $dato['imagen_antigua'] = "extranet/fondo.jpg";
            $this->Model_General->activar_fondo_extranet($dato);
        }
    }

    public function Excel_Fondo_Extranet(){
        $list_fondo_extranet = $this->Model_General->get_list_fondo_extranet();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Fondos Extranet');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Título');             
        $sheet->setCellValue("B1", 'Estado');
        $sheet->setCellValue("C1", 'Imagen');

        $contador=1;
        
        foreach($list_fondo_extranet as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['titulo']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
            $sheet->setCellValue("C{$contador}", $list['v_imagen']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Fondos Extranet (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //---------------------------------------------SEMANAS-------------------------------------------
    public function Semanas() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/semanas/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Semanas($t) {
        if ($this->session->userdata('usuario')) {
            $dato['t']=$t;
            $dato['list_semanas'] = $this->Model_General->get_list_semanas_modulo(0,$t);
            $this->load->view('general/semanas/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    //---------------------------------------------SOPORTE DOCS-------------------------------------------
    public function Soporte_Doc() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/soporte_doc/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Soporte_Doc() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo"); 
            $dato['list_soporte_doc'] = $this->Model_General->get_list_soporte_doc(null,$dato['tipo']);
            $this->load->view('general/soporte_doc/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Soporte_Doc(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_combo();
            $this->load->view('general/soporte_doc/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Soporte_Doc(){
        $dato['id_empresa']= $this->input->post("id_empresa_i"); 
        $dato['descripcion']= $this->input->post("descripcion_i"); 
        $dato['visible']= $this->input->post("visible_i"); 
        $dato['documento_i']= ""; 

        $get_id = $this->Model_General->ultimo_id_soporte_doc();
        $cantidad = $get_id[0]['id_soporte_doc']+1;

        if($_FILES["documento_i"]["name"] != ""){
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_i"]["name"]);
            $config['upload_path'] = './documento_soporte/'.$cantidad;
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_soporte/', 0777);
                chmod('./documento_soporte/'.$cantidad, 0777);
            }
            $config["allowed_types"] = 'png|pdf|mp4';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["documento_i"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["documento_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["documento_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["documento_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["documento_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['documento'] = "documento_soporte/".$cantidad."/".$dato['nom_documento'];
            }     
        }
        $this->Model_General->insert_soporte_doc($dato);
    }

    public function Modal_Update_Soporte_Doc($id_soporte_doc){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_list_soporte_doc($id_soporte_doc);
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_combo();
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $this->load->view('general/soporte_doc/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Soporte_Doc(){
        $dato['id_soporte_doc']= $this->input->post("id_soporte_doc");
        $dato['id_empresa']= $this->input->post("id_empresa_u"); 
        $dato['descripcion']= $this->input->post("descripcion_u"); 
        $dato['estado']= $this->input->post("estado_u"); 
        $dato['visible']= $this->input->post("visible_u"); 
        $dato['documento']= $this->input->post("documento_actual"); 

        if($_FILES["documento_u"]["name"] != ""){
            if (file_exists($dato['documento'])) { 
                unlink($dato['documento']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_u"]["name"]);
            $config['upload_path'] = './documento_soporte/'.$dato['id_soporte_doc'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_soporte/', 0777);
                chmod('./documento_soporte/'.$dato['id_soporte_doc'], 0777);
            }
            $config["allowed_types"] = 'png|pdf|mp4';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["documento_u"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["documento_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["documento_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["documento_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["documento_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['documento'] = "documento_soporte/".$dato['id_soporte_doc']."/".$dato['nom_documento'];
            }     
        }

        $this->Model_General->update_soporte_doc($dato);
    }

    public function Descargar_Archivo_Soporte_Doc($id_soporte_doc) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_General->get_list_soporte_doc($id_soporte_doc);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo_Soporte_Doc() {
        $id_soporte_doc = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_General->get_list_soporte_doc($id_soporte_doc);

        $image = $dato['get_file'][0]['documento'];

        if (file_exists($image)) {
            unlink($image);
        }

        $this->Model_General->delete_archivo_soporte_doc($id_soporte_doc);
    }

    public function Delete_Soporte_Doc(){
        $dato['id_soporte_doc']= $this->input->post("id_soporte_doc");
        $this->Model_General->delete_soporte_doc($dato);
    }

    public function Excel_Soporte_Doc($tipo){
        $list_soporte_doc = $this->Model_General->get_list_soporte_doc(null,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Soporte Docs');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
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

        $sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Empresa');             
        $sheet->setCellValue("B1", 'Descripción');  
        $sheet->setCellValue("C1", 'Nombre (Documento)');
        $sheet->setCellValue("D1", 'Link');     
        $sheet->setCellValue("E1", 'Usuario');
        $sheet->setCellValue("F1", 'Fecha');        
        $sheet->setCellValue("G1", 'Archivo');
        $sheet->setCellValue("H1", 'Visible');
        $sheet->setCellValue("I1", 'Estado');              

        $contador=1;
        
        foreach($list_soporte_doc as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("D{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("D{$contador}")->getFont()->setUnderline(true);  

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['descripcion']);
            $sheet->setCellValue("C{$contador}", $list['nom_documento']);
            if($list['documento']!=""){
                $sheet->setCellValue("D{$contador}", $list['link']);
                $sheet->getCell("D{$contador}")->getHyperlink()->setURL($list['href']);
            }else{
                $sheet->setCellValue("D{$contador}", "");
            }
            $sheet->setCellValue("E{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", $list['v_documento']);
            $sheet->setCellValue("H{$contador}", $list['visible']);
            $sheet->setCellValue("I{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Soporte Docs (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Semanas(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio']   = $this->Model_General->raw("select nom_anio from anio where estado=1 ORDER BY nom_anio desc", false);
            $this->load->view('general/semanas/modal_registrar', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_Semana(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anio");
            $dato['nom_semana']= $this->input->post("nom_semana");
            $dato['fec_inicio']= $this->input->post("fec_inicio");  
            $dato['fec_fin']= $this->input->post("fec_fin");  
            $dato['id_semanas']="";
            $cont=count($this->Model_General->valida_semana($dato));

            if($cont>0){
                echo "error";
            }else{
                $this->Model_General->insert_semana($dato);
            }
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Semana($id_semanas){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_General->get_list_semanas_modulo($id_semanas,0);
            $dato['list_anio']   = $this->Model_General->raw("select nom_anio from anio where estado=1 ORDER BY nom_anio desc", false);
            $this->load->view('general/semanas/modal_editar', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Update_Semana(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anioe");
            $dato['nom_semana']= $this->input->post("nom_semanae");
            $dato['fec_inicio']= $this->input->post("fec_inicioe");  
            $dato['fec_fin']= $this->input->post("fec_fine");  
            $dato['id_semanas']=$this->input->post("id_semanas");
            $cont=count($this->Model_General->valida_semana($dato));

            if($cont>0){
                echo "error";
            }else{
                $this->Model_General->update_semana($dato);
            }
        }
        else{
            redirect('/login');
        }
    }

    public function Delete_Semana(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_semanas']=$this->input->post("id_semanas");
            $this->Model_General->delete_semana($dato);
            
        }
        else{
            redirect('/login');
        }
    }

    public function Excel_Semana($t){
        if ($this->session->userdata('usuario')) {
            $list_semana = $this->Model_General->get_list_semanas_modulo(0,$t);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Semanas');

            $sheet->setAutoFilter('A1:D1');

            $sheet->getColumnDimension('A')->setWidth(9);
            $sheet->getColumnDimension('B')->setWidth(11);
            $sheet->getColumnDimension('C')->setWidth(11);
            $sheet->getColumnDimension('D')->setWidth(11);

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

            $sheet->setCellValue("A1", 'Año');             
            $sheet->setCellValue("B1", 'Semana');  
            $sheet->setCellValue("C1", 'De');
            $sheet->setCellValue("D1", 'Hasta');              

            $contador=1;
            
            foreach($list_semana as $list){
                $contador++;

                /*$sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);*/
                $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                //$sheet->getStyle("D{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                //$sheet->getStyle("D{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['anio']);
                $sheet->setCellValue("B{$contador}", $list['nom_semana']);
                if($list['fec_inicio']!="" && $list['fec_inicio']!="0000-00-00"){
                    $sheet->setCellValue("C{$contador}", date('d/m/Y',strtotime($list['fec_inicio'])));   
                }
                if($list['fec_fin']!="" && $list['fec_fin']!="0000-00-00"){
                    $sheet->setCellValue("D{$contador}", date('d/m/Y',strtotime($list['fec_fin'])));   
                }
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Semanas (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); 
        }else{
            redirect('/login');
        }
    }
    //-------------------------------------TIPO COMERCIAL--------------------------------------------------
    public function Tipo_Comercial(){
        if ($this->session->userdata('usuario')) { 
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/tipo_comercial/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Tipo_Comercial() {
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_comercial'] =$this->Model_General->get_list_tipo_comercial();
            $this->load->view('general/tipo_comercial/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Tipo_Comercial(){
        if ($this->session->userdata('usuario')) { 
            $this->load->view('general/tipo_comercial/modal_registrar');
        }else{
            redirect('/login');
        }
    }

    public function Insert_Tipo_Comercial(){
        if ($this->session->userdata('usuario')) { 
            $dato['nom_informe']= $this->input->post("nom_informe_i");

            $valida = $this->Model_General->valida_tipo_comercial($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_General->insert_tipo_comercial($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Tipo_Comercial($id_informe){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_General->get_list_tipo_comercial($id_informe);
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $this->load->view('general/tipo_comercial/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Tipo_Comercial(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_informe']= $this->input->post("id_informe");
            $dato['nom_informe']= $this->input->post("nom_informe_u");
            $dato['estado']= $this->input->post("estado_u");   
            
            $valida = $this->Model_General->valida_tipo_comercial($dato);
            
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_General->update_tipo_comercial($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Tipo_Comercial(){
        if ($this->session->userdata('usuario')) {
            $dato['id_informe']= $this->input->post("id_informe");
            $this->Model_General->delete_tipo_comercial($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Tipo_Comercial(){
        $list_tipo_comercial = $this->Model_General->get_list_tipo_comercial();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tipos');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Nombre');	                
        $sheet->setCellValue("B1", 'Estado');	        

        $contador=1;
        
        foreach($list_tipo_comercial as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_informe']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tipos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //------------------------------------------PRODUCTO INTERESE-----------------------------------
    public function Producto_Interes(){
        if ($this->session->userdata('usuario')) { 
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/producto_interes/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Producto_Interes() {
        if ($this->session->userdata('usuario')) {
            $dato['list_producto_interes'] =$this->Model_General->get_list_producto_interes();
            $this->load->view('general/producto_interes/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Producto_Interes(){
        if ($this->session->userdata('usuario')) { 
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_producto_interes();
            $this->load->view('general/producto_interes/modal_registrar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Sede_Producto_Interes() {
        if ($this->session->userdata('usuario')) { 
            $id_empresa = $this->input->post("id_empresa");
            $dato['list_sede'] = $this->Model_General->get_list_sede_producto_interes($id_empresa);
            $this->load->view('general/producto_interes/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Producto_Interes(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");
            $dato['nom_producto_interes']= $this->input->post("nom_producto_interes_i");
            $dato['orden_producto_interes']= $this->input->post("orden_producto_interes_i");
            $dato['fecha_inicio']= $this->input->post("fecha_inicio_i");
            $dato['fecha_fin']= $this->input->post("fecha_fin_i");  
            $dato['total']= $this->input->post("total_i");  
            $dato['formulario']= $this->input->post("formulario_i");  

            if($dato['total']==1){
                $valida = $this->Model_General->valida_producto_interes($dato);
                if(count($valida)==11){
                    echo "total";
                }else{
                    $this->Model_General->insert_producto_interes($dato);
                }
            }else{
                $this->Model_General->insert_producto_interes($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Producto_Interes($id_producto_interes){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_General->get_list_producto_interes($id_producto_interes);
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_producto_interes();
            $dato['list_sede'] = $this->Model_General->get_list_sede_producto_interes($dato['get_id'][0]['id_empresa']);
            $this->load->view('general/producto_interes/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Producto_Interes(){
        if ($this->session->userdata('usuario')) {
            $dato['id_producto_interes']= $this->input->post("id_producto_interes");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['nom_producto_interes']= $this->input->post("nom_producto_interes_u");
            $dato['orden_producto_interes']= $this->input->post("orden_producto_interes_u");
            $dato['fecha_inicio']= $this->input->post("fecha_inicio_u");
            $dato['fecha_fin']= $this->input->post("fecha_fin_u");  
            $dato['estado']= $this->input->post("estado_u"); 
            $dato['total']= $this->input->post("total_u");  
            $dato['formulario']= $this->input->post("formulario_u");      
            
            if($dato['total']==1){
                $valida = $this->Model_General->valida_producto_interes($dato);
                if(count($valida)==11){
                    echo "total";
                }else{
                    $this->Model_General->update_producto_interes($dato);
                }
            }else{
                $this->Model_General->update_producto_interes($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Producto_Interes(){
        if ($this->session->userdata('usuario')) {
            $dato['id_producto_interes']= $this->input->post("id_producto_interes");
            $this->Model_General->delete_producto_interes($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Producto_Interes(){
        $list_producto_interes =$this->Model_General->get_list_producto_interes();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Productos Interese');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Empresa');           
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Interese');
        $sheet->setCellValue("D1", 'Totales');
        $sheet->setCellValue("E1", 'Formulario');
        $sheet->setCellValue("F1", 'Fecha Inicio');
        $sheet->setCellValue("G1", 'Fecha Fin');
        $sheet->setCellValue("H1", 'Estado');

        $contador=1;
        
        foreach($list_producto_interes as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_producto_interes']);
            $sheet->setCellValue("D{$contador}", $list['totales']);
            $sheet->setCellValue("E{$contador}", $list['formularios']);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fec_inicio']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fec_fin']));
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Productos Interese (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //------------------------------------------SMS AUTOMATIZADO-----------------------------------
    public function Sms_Automatizado(){
        if ($this->session->userdata('usuario')) { 
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('general/sms_automatizado/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Sms_Automatizado() {
        if ($this->session->userdata('usuario')) {
            $dato['list_sms_automatizado'] =$this->Model_General->get_list_sms_automatizado();
            $this->load->view('general/sms_automatizado/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Sms_Automatizado(){
        if ($this->session->userdata('usuario')) { 
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_sms_automatizado();
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $this->load->view('general/sms_automatizado/modal_registrar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Sede_Sms_Automatizado() {
        if ($this->session->userdata('usuario')) { 
            $id_empresa = $this->input->post("id_empresa");
            $dato['list_sede'] = $this->Model_General->get_list_sede_sms_automatizado($id_empresa);
            $this->load->view('general/sms_automatizado/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Sms_Automatizado(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");
            $dato['tipo']= $this->input->post("tipo_i");
            $dato['unitario']= $this->input->post("unitario_i");
            $dato['motivo']= $this->input->post("motivo_i");
            $dato['descripcion']= $this->input->post("descripcion_i");  
            $dato['regularidad']= $this->input->post("regularidad_i");  
            $dato['estado']= $this->input->post("estado_i"); 

            $valida = $this->Model_General->valida_insert_sms_automatizado($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_General->insert_sms_automatizado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Sms_Automatizado($id_sms){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_General->get_list_sms_automatizado($id_sms);
            $dato['list_estado'] = $this->Model_General->get_list_estado();
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_sms_automatizado();
            $dato['list_sede'] = $this->Model_General->get_list_sede_sms_automatizado($dato['get_id'][0]['id_empresa']);
            $this->load->view('general/sms_automatizado/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Sms_Automatizado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_sms']= $this->input->post("id_sms");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['tipo']= $this->input->post("tipo_u");
            $dato['unitario']= $this->input->post("unitario_u");
            $dato['motivo']= $this->input->post("motivo_u");
            $dato['descripcion']= $this->input->post("descripcion_u");  
            $dato['regularidad']= $this->input->post("regularidad_u");  
            $dato['estado']= $this->input->post("estado_u");  

            $valida = $this->Model_General->valida_update_sms_automatizado($dato);
            
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_General->update_sms_automatizado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Sms_Automatizado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_sms']= $this->input->post("id_sms");
            $this->Model_General->delete_sms_automatizado($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Sms_Automatizado(){
        $list_sms_automatizado =$this->Model_General->get_list_sms_automatizado();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('SMS Automatizado');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(60);
        $sheet->getColumnDimension('G')->setWidth(60);
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

        $sheet->setCellValue("A1", 'Empresa');           
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Unitario');
        $sheet->setCellValue("E1", 'Motivo');
        $sheet->setCellValue("F1", 'Descripción');
        $sheet->setCellValue("G1", 'Regularidad');
        $sheet->setCellValue("H1", 'Estado');

        $contador=1;
        
        foreach($list_sms_automatizado as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("D{$contador}", $list['unitario']);
            $sheet->setCellValue("E{$contador}", $list['motivo']);
            $sheet->setCellValue("F{$contador}", $list['descripcion']);
            $sheet->setCellValue("G{$contador}", $list['regularidad']);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet); 
        $filename = 'SMS Automatizado (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Busqueda(){
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['anio']=date('Y');
        $dato['list_anio'] = $this->Model_snappy->get_list_anio();
        $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();

        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
        $this->load->view('general/soporte_ti/busqueda/index',$dato);
    }

    public function Buscador_Anio() {
        if ($this->session->userdata('usuario')) { 
            $dato['anio'] = $this->input->post("anio");
            $dato['id_empresa'] = $this->input->post("id_empresa");
            $dato['list_busqueda'] =$this->Model_General->list_tkt_all($dato);
            $this->load->view('general/soporte_ti/busqueda/busqueda',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Lista_Tickets_All($anio,$id_empresa){
        $dato['anio'] = $anio;
        $dato['id_empresa'] = $id_empresa;
        $list_tkt_all =$this->Model_General->list_tkt_all($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Todos los Tickets del '.$anio);

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(20);

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
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

        $sheet->setCellValue("A1", 'Cod.');           
        $sheet->setCellValue("B1", 'Pri.');
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Empresa');
        $sheet->setCellValue("E1", 'Proyecto');
        $sheet->setCellValue("F1", 'Sub-Proyecto');
        $sheet->setCellValue("G1", 'Descripción');
        $sheet->setCellValue("H1", 'Fecha');
        $sheet->setCellValue("I1", 'Soli');
        $sheet->setCellValue("J1", 'Ult. Acción');
        $sheet->setCellValue("K1", 'Desarrollador');
        $sheet->setCellValue("L1", 'Horas');
        $sheet->setCellValue("M1", 'Estado');

        $contador=1;
        
        foreach($list_tkt_all as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            if ($list['horas'] != 0 || $list['minutos'] != 0) {
                if ($list['minutos'] == "0") {
                  $minuto = "00";
                }else{
                  $minuto = $list['minutos'];
                }
                
            }
            $sheet->setCellValue("A{$contador}", $list['cod_ticket']);
            $sheet->setCellValue("B{$contador}", $list['v_prioridad']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_ticket']);
            $sheet->setCellValue("D{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("E{$contador}", $list['proyecto']);
            $sheet->setCellValue("F{$contador}", $list['subproyecto']);
            $sheet->setCellValue("G{$contador}", $list['ticket_desc']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['cod_soli']);
            $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_registro_th']));
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("K{$contador}", $list['cod_terminado_por']);
            $sheet->setCellValue("L{$contador}", $list['horas'] . ":" . $minuto);
            $sheet->setCellValue("M{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet); 
        $filename = 'Lista de Todos los Tickets del '.$anio;
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}