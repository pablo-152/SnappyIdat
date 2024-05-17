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
require 'application/libraries/numeroaletras.php';

class Laleli extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Laleli');
        $this->load->model('Admin_model');
        $this->load->model('Model_General');
        $this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper('form');
    }

    protected function jsonResponse($respuesta = array()) {
        $status = 200;
        if (empty($respuesta)) {
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
            $dato['fondo'] = $this->Model_Laleli->fondo_index();

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes()); 
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/administrador/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Detalle_Aviso() {
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes()); 
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------TIPO-------------------------------------
    public function Tipo(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/tipo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Tipo() {
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_Laleli->get_list_tipo();
            $this->load->view('view_LA/tipo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/tipo/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['nom_tipo']= $this->input->post("nom_tipo_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_Laleli->valida_insert_tipo($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->insert_tipo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Tipo($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_tipo($id_tipo);
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/tipo/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo']= $this->input->post("id_tipo"); 
            $dato['nom_tipo']= $this->input->post("nom_tipo_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Model_Laleli->valida_update_tipo($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->update_tipo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo']= $this->input->post("id_tipo");
            $this->Model_Laleli->delete_tipo($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Tipo(){
        $list_tipo = $this->Model_Laleli->get_list_tipo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tipo');

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
        
        foreach($list_tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tipo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------SUBTIPO-------------------------------------
    public function Subtipo(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/subtipo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Subtipo() {
        if ($this->session->userdata('usuario')) {
            $dato['list_subtipo'] = $this->Model_Laleli->get_list_subtipo();
            $this->load->view('view_LA/subtipo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_Laleli->get_list_tipo_combo();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/subtipo/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo']= $this->input->post("id_tipo_i");
            $dato['nom_subtipo']= $this->input->post("nom_subtipo_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_Laleli->valida_insert_subtipo($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->insert_subtipo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Subtipo($id_subtipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_subtipo($id_subtipo);
            $dato['list_tipo'] = $this->Model_Laleli->get_list_tipo_combo();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/subtipo/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_subtipo']= $this->input->post("id_subtipo"); 
            $dato['id_tipo']= $this->input->post("id_tipo_u");
            $dato['nom_subtipo']= $this->input->post("nom_subtipo_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Model_Laleli->valida_update_subtipo($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->update_subtipo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_subtipo']= $this->input->post("id_subtipo");
            $this->Model_Laleli->delete_subtipo($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Subtipo(){
        $list_subtipo = $this->Model_Laleli->get_list_subtipo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Tipo');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(30);
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

        $sheet->setCellValue("A1", 'Tipo');	
        $sheet->setCellValue("B1", 'Nombre');	              
        $sheet->setCellValue("C1", 'Estado');

        $contador=1;
        
        foreach($list_subtipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("B{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sub-Tipo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------TIPO PRODUCTO-------------------------------------
    public function Tipo_Producto(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/tipo_producto/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Tipo_Producto() {
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_producto'] = $this->Model_Laleli->get_list_tipo_producto();
            $this->load->view('view_LA/tipo_producto/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Tipo_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] = $this->Model_Laleli->get_list_empresa();
            $dato['list_tipo'] = $this->Model_Laleli->get_list_tipo_combo();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/tipo_producto/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Subtipo_I(){
        if ($this->session->userdata('usuario')) {
            $id_tipo = $this->input->post("id_tipo");
            $dato['id_subtipo'] = "id_subtipo_i";
            $dato['list_subtipo'] = $this->Model_Laleli->get_list_subtipo_combo_tipo($id_tipo);
            $this->load->view('view_LA/tipo_producto/subtipo',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Tipo_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['cod_tipo_producto']= $this->input->post("cod_tipo_producto_i");
            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_tipo']= $this->input->post("id_tipo_i"); 
            $dato['id_subtipo']= $this->input->post("id_subtipo_i");
            $dato['descripcion']= $this->input->post("descripcion_i");
            $dato['foto']= ""; 
            $dato['estado']= $this->input->post("estado_i");

            $validar = $this->Model_Laleli->valida_insert_tipo_producto($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $cantidad = $this->Model_Laleli->ultimo_id_tipo_producto();
                $cantidad = count($cantidad)+1; 

                if($_FILES["foto_i"]["name"] != ""){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_i"]["name"]);
                    $config['upload_path'] = './foto_tipo_producto_LA/'.$cantidad;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./foto_tipo_producto_LA/', 0777);
                        chmod('./foto_tipo_producto_LA/'.$cantidad, 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["foto_i"]["name"];
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["foto_i"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["foto_i"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["foto_i"]["error"];
                    $_FILES["file"]["size"] = $_FILES["foto_i"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['foto'] = "foto_tipo_producto_LA/".$cantidad."/".$dato['nom_documento'];
                    }     
                }

                $this->Model_Laleli->insert_tipo_producto($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Tipo_Producto($id_tipo_producto){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_tipo_producto($id_tipo_producto);
            $dato['list_empresa'] = $this->Model_Laleli->get_list_empresa();
            $dato['list_tipo'] = $this->Model_Laleli->get_list_tipo_combo();
            $dato['list_subtipo'] = $this->Model_Laleli->get_list_subtipo_combo_tipo($dato['get_id'][0]['id_tipo']);
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/tipo_producto/modal_editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Traer_Subtipo_U(){
        if ($this->session->userdata('usuario')) {
            $id_tipo = $this->input->post("id_tipo");
            $dato['id_subtipo'] = "id_subtipo_u";
            $dato['list_subtipo'] = $this->Model_Laleli->get_list_subtipo_combo_tipo($id_tipo);
            $this->load->view('view_LA/tipo_producto/subtipo',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Tipo_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_producto']= $this->input->post("id_tipo_producto"); 
            $dato['cod_tipo_producto']= $this->input->post("cod_tipo_producto_u");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_tipo']= $this->input->post("id_tipo_u"); 
            $dato['id_subtipo']= $this->input->post("id_subtipo_u");
            $dato['descripcion']= $this->input->post("descripcion_u");
            $dato['foto']= $this->input->post("foto_actual");
            $dato['estado']= $this->input->post("estado_u");

            $validar = $this->Model_Laleli->valida_update_tipo_producto($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                if($_FILES["foto_u"]["name"] != ""){
                    if (file_exists($dato['foto'])) { 
                        unlink($dato['foto']);
                    }

                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_u"]["name"]);
                    $config['upload_path'] = './foto_tipo_producto_LA/'.$dato['id_tipo_producto'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./foto_tipo_producto_LA/', 0777);
                        chmod('./foto_tipo_producto_LA/'.$dato['id_tipo_producto'], 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["foto_u"]["name"];
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["foto_u"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["foto_u"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["foto_u"]["error"];
                    $_FILES["file"]["size"] = $_FILES["foto_u"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['foto'] = "foto_tipo_producto_LA/".$dato['id_tipo_producto']."/".$dato['nom_documento'];
                    }     
                }

                $this->Model_Laleli->update_tipo_producto($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Tipo_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_producto']= $this->input->post("id_tipo_producto");
            $this->Model_Laleli->delete_tipo_producto($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Foto_Tipo_Producto($id_tipo_producto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Laleli->get_list_tipo_producto($id_tipo_producto);
            $image = $dato['get_file'][0]['foto'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['foto']));
        }else{
            redirect('');
        }
    }

    public function Excel_Tipo_Producto(){
        $list_tipo_producto = $this->Model_Laleli->get_list_tipo_producto();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tipo Producto');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Empresa');	        
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Sub-Tipo');	
        $sheet->setCellValue("E1", 'Descripción');	         
        $sheet->setCellValue("F1", 'Foto');	               
        $sheet->setCellValue("G1", 'Estado');	        

        $contador=1;
        
        foreach($list_tipo_producto as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_tipo_producto']);
            $sheet->setCellValue("B{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("D{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("E{$contador}", $list['descripcion']);
            $sheet->setCellValue("F{$contador}", $list['v_foto']);
            $sheet->setCellValue("G{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tipo Producto (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------TALLA-------------------------------------
    public function Talla(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/talla/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Talla() {
        if ($this->session->userdata('usuario')) {
            $dato['list_talla'] = $this->Model_Laleli->get_list_talla();
            $this->load->view('view_LA/talla/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Talla(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/talla/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Talla(){
        if ($this->session->userdata('usuario')) {
            $dato['cod_talla']= $this->input->post("cod_talla_i");
            $dato['talla']= $this->input->post("talla_i"); 
            $dato['estado']= $this->input->post("estado_i");

            $validar = $this->Model_Laleli->valida_insert_talla($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->insert_talla($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Talla($id_talla){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Laleli->get_list_talla($id_talla);
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/talla/modal_editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Update_Talla(){
        if ($this->session->userdata('usuario')) {
            $dato['id_talla']= $this->input->post("id_talla"); 
            $dato['cod_talla']= $this->input->post("cod_talla_u");
            $dato['talla']= $this->input->post("talla_u"); 
            $dato['estado']= $this->input->post("estado_u");

            $validar = $this->Model_Laleli->valida_update_talla($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->update_talla($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Talla(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_talla']= $this->input->post("id_talla");
            $this->Model_Laleli->delete_talla($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Talla(){
        $list_talla = $this->Model_Laleli->get_list_talla();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Talla_Ref');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Código');	                
        $sheet->setCellValue("B1", 'Talla/Ref.'); 
        $sheet->setCellValue("C1", 'Estado');	        

        $contador=1;
        
        foreach($list_talla as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_talla']);
            $sheet->setCellValue("B{$contador}", $list['talla']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Talla/Ref (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------PRODUCTO-------------------------------------
    public function Producto(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/producto/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Producto() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_producto'] = $this->Model_Laleli->get_list_producto($dato['tipo']);
            $this->load->view('view_LA/producto/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_producto'] = $this->Model_Laleli->get_list_tipo_producto_combo();
            $dato['list_talla'] = $this->Model_Laleli->get_list_talla_combo();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/producto/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_producto']= $this->input->post("id_tipo_producto_i");
            $dato['id_talla']= $this->input->post("id_talla_i"); 
            $dato['disponible_encomendar']= $this->input->post("disponible_encomendar_i");
            $dato['aviso']= $this->input->post("aviso_i"); 
            $dato['desde']= $this->input->post("desde_i");
            $dato['hasta']= $this->input->post("hasta_i"); 
            $dato['precio_venta']= $this->input->post("precio_venta_i");
            $dato['estado']= $this->input->post("estado_i");

            $get_tipo_producto = $this->Model_Laleli->get_list_tipo_producto($dato['id_tipo_producto']);
            $get_talla = $this->Model_Laleli->get_list_talla($dato['id_talla']);
            $dato['cod_producto'] = $get_tipo_producto[0]['cod_tipo_producto']."-".$get_talla[0]['cod_talla'];

            $validar = $this->Model_Laleli->valida_insert_producto($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->insert_producto($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Producto($id_producto){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Laleli->get_id_producto($id_producto);
            $dato['list_tipo_producto'] = $this->Model_Laleli->get_list_tipo_producto_combo();
            $dato['list_talla'] = $this->Model_Laleli->get_list_talla_combo();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $this->load->view('view_LA/producto/modal_editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Update_Producto(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_producto']= $this->input->post("id_producto"); 
            //$dato['id_tipo_producto']= $this->input->post("id_tipo_producto_u");
            //$dato['id_talla']= $this->input->post("id_talla_u"); 
            $dato['disponible_encomendar']= $this->input->post("disponible_encomendar_u");
            $dato['aviso']= $this->input->post("aviso_u"); 
            $dato['desde']= $this->input->post("desde_u");
            $dato['hasta']= $this->input->post("hasta_u"); 
            $dato['precio_venta']= $this->input->post("precio_venta_u");
            $dato['estado']= $this->input->post("estado_u");

            $validar = $this->Model_Laleli->valida_update_producto($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Laleli->update_producto($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Producto(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_producto']= $this->input->post("id_producto");
            $this->Model_Laleli->delete_producto($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Producto($tipo){ 
        $list_producto = $this->Model_Laleli->get_list_producto($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Producto');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(28);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Código');	   
        $sheet->setCellValue("B1", 'Tipo'); 
        $sheet->setCellValue("C1", 'Sub-Tipo');	        
        $sheet->setCellValue("D1", 'Tipo Producto');        
        $sheet->setCellValue("E1", 'Talla/Ref.'); 
        $sheet->setCellValue("F1", 'Disponible Encomendar');	                     
        $sheet->setCellValue("G1", 'Aviso (con stock Total)'); 
        $sheet->setCellValue("H1", 'Activo de'); 
        $sheet->setCellValue("I1", 'A');	                     
        $sheet->setCellValue("J1", 'Precio Venta'); 
        $sheet->setCellValue("K1", 'Estado');	        

        $contador=1;
        
        foreach($list_producto as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['codigo']);
            $sheet->setCellValue("B{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("C{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['talla']);
            $sheet->setCellValue("F{$contador}", $list['v_disponible_encomendar']);
            $sheet->setCellValue("G{$contador}", $list['aviso']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['activo_de']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['a']));
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("J{$contador}", $list['precio_venta']);
            $sheet->setCellValue("K{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Producto (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------ALMACÉN-------------------------------------
    public function Almacen(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Almacen() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_almacen'] = $this->Model_Laleli->get_list_almacen($tipo);
            $this->load->view('view_LA/almacen/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Almacen(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $dato['list_combo_empresa'] = $this->Model_Laleli->get_list_empresa(); 
            $dato['list_sede'] = $this->Model_Laleli->get_list_sede();
            $dato['list_usuario'] = $this->Model_Laleli->get_list_usuario();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            $dato['almacen_principal'] = count($this->Model_Laleli->get_almacen_principal());

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Almacen(){
        if ($this->session->userdata('usuario')) {
            $dato['id_anio']= $this->input->post("id_anio_i");
            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");
            $dato['descripcion']= $this->input->post("descripcion_i");
            $dato['id_responsable']= $this->input->post("id_responsable_i"); 
            $dato['id_supervisor']= $this->input->post("id_supervisor_i");
            $dato['id_entrega']= $this->input->post("id_entrega_i");
            $dato['id_administrador']= $this->input->post("id_administrador_i"); 
            $dato['id_vendedor']= $this->input->post("id_vendedor_i");
            $dato['observaciones']= $this->input->post("observaciones_i");
            $dato['principal']= $this->input->post("principal_i"); 
            $dato['doc_sunat']= $this->input->post("doc_sunat_i"); 
            $dato['trash']= $this->input->post("trash_i");

            if($dato['id_vendedor']!=""){
                $dato['id_vendedor']= implode(",",$this->input->post("id_vendedor_i"));

                $valida_punto_venta = $this->Model_Laleli->valida_insert_punto_venta_sede($dato);

                if(count($valida_punto_venta)>0){
                    echo "punto_venta";
                }else{
                    if($dato['principal']==1){
                        $this->Model_Laleli->update_principal();
                    }
    
                    $this->Model_Laleli->insert_almacen($dato);
                }
            }else{
                if($dato['principal']==1){
                    $this->Model_Laleli->update_principal();
                }

                $this->Model_Laleli->insert_almacen($dato);
            }
        }else{
            redirect('/login');
        }
    } 

    public function Editar_Almacen($id_almacen){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $dato['list_combo_empresa'] = $this->Model_Laleli->get_list_empresa();
            $dato['list_sede'] = $this->Model_Laleli->get_list_sede();
            $dato['list_usuario'] = $this->Model_Laleli->get_list_usuario();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Update_Almacen(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen']= $this->input->post("id_almacen"); 
            $dato['id_anio']= $this->input->post("id_anio_u");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['descripcion']= $this->input->post("descripcion_u");
            $dato['id_responsable']= $this->input->post("id_responsable_u"); 
            $dato['id_supervisor']= $this->input->post("id_supervisor_u");
            $dato['id_entrega']= $this->input->post("id_entrega_u");
            $dato['id_administrador']= $this->input->post("id_administrador_u"); 
            $dato['id_vendedor']= $this->input->post("id_vendedor_u");
            $dato['observaciones']= $this->input->post("observaciones_u");
            $dato['principal']= $this->input->post("principal_u");
            $dato['doc_sunat']= $this->input->post("doc_sunat_u");
            $dato['trash']= $this->input->post("trash_u");
            $dato['estado']= $this->input->post("estado_u");

            if($dato['id_vendedor']!=""){
                $dato['id_vendedor']= implode(",",$this->input->post("id_vendedor_u"));

                $valida_punto_venta = $this->Model_Laleli->valida_update_punto_venta_sede($dato);

                if(count($valida_punto_venta)>0){
                    echo "punto_venta";
                }else{
                    if($dato['principal']==1){
                        $this->Model_Laleli->update_principal(); 
                    }
        
                    $this->Model_Laleli->update_almacen($dato);
                }
            }else{
                if($dato['principal']==1){
                    $this->Model_Laleli->update_principal();
                }
    
                $this->Model_Laleli->update_almacen($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Almacen(){
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen']= $this->input->post("id_almacen");
            $this->Model_Laleli->delete_almacen($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Almacen($tipo){
        $list_almacen = $this->Model_Laleli->get_list_almacen($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); 

        $spreadsheet->getActiveSheet()->setTitle('Almacén');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);

        $sheet->getStyle('A1:R1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:R1")->getFill()
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

        $sheet->getStyle("A1:R1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Año');	
        $sheet->setCellValue("B1", 'Empresa');	   
        $sheet->setCellValue("C1", 'Sede');	        
        $sheet->setCellValue("D1", 'Descripción');
        $sheet->setCellValue("E1", 'Stock');	
        $sheet->setCellValue("F1", 'Valor');	
        $sheet->setCellValue("G1", 'Ventas');	 
        $sheet->setCellValue("H1", 'Valor');	       
        $sheet->setCellValue("I1", 'Solicitados');
        $sheet->setCellValue("J1", 'Responsable');	
        $sheet->setCellValue("K1", 'Supervisor');	 
        $sheet->setCellValue("L1", 'Entrega');	                
        $sheet->setCellValue("M1", 'Administrador');
        $sheet->setCellValue("N1", 'Vendedor(es)');
        $sheet->setCellValue("O1", 'Principal');	  
        $sheet->setCellValue("P1", 'Doc Sunat');	  
        $sheet->setCellValue("Q1", 'Trash');	       
        $sheet->setCellValue("R1", 'Estado');	        

        $contador=1;
        
        foreach($list_almacen as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("J{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['nom_anio']);
            $sheet->setCellValue("B{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("C{$contador}", $list['cod_sede']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['stock']);
            $sheet->setCellValue("F{$contador}", $list['v_compra']);
            $sheet->setCellValue("G{$contador}", $list['ventas']);
            $sheet->setCellValue("H{$contador}", $list['v_venta']);
            $sheet->setCellValue("I{$contador}", "");
            $sheet->setCellValue("J{$contador}", $list['nom_responsable']);
            $sheet->setCellValue("K{$contador}", $list['nom_supervisor']);
            $sheet->setCellValue("L{$contador}", $list['nom_entrega']);
            $sheet->setCellValue("M{$contador}", $list['nom_administrador']);
            $sheet->setCellValue("N{$contador}", $list['v_vendedor']);
            $sheet->setCellValue("O{$contador}", $list['v_principal']);
            $sheet->setCellValue("P{$contador}", $list['v_doc_sunat']);
            $sheet->setCellValue("Q{$contador}", $list['v_trash']);
            $sheet->setCellValue("R{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Almacén (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Almacen($id_almacen){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $dato['list_combo_empresa'] = $this->Model_Laleli->get_list_empresa();
            $dato['list_sede'] = $this->Model_Laleli->get_list_sede();
            $dato['list_usuario'] = $this->Model_Laleli->get_list_usuario();
            $dato['list_estado'] = $this->Model_Laleli->get_list_estado();
            
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Almacen(){
        if ($this->session->userdata('usuario')) {
            $id_almacen = $this->input->post("id_almacen");
            $dato['list_detalle_almacen'] = $this->Model_Laleli->get_list_detalle_almacen($id_almacen);
            $this->load->view('view_LA/almacen/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Compra_Almacen($id_almacen){
        if ($this->session->userdata('usuario')) { 
            $dato['id_almacen'] = $id_almacen;
            $dato['list_producto'] = $this->Model_Laleli->get_list_producto_combo();
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $this->load->view('view_LA/almacen/modal_compra',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Producto_C(){
        if ($this->session->userdata('usuario')) {
            $dato['id_producto'] = $this->input->post("id_producto");
            $dato['get_id'] = $this->Model_Laleli->get_id_producto($dato['id_producto']);
            $this->load->view('view_LA/almacen/datos_producto_c',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Anio_Defecto_Compra_C(){
        if ($this->session->userdata('usuario')) {
            $fecha_compra = $this->input->post("fecha_compra");
            $dato['nom_anio'] = substr($fecha_compra,0,4); 
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $this->load->view('view_LA/almacen/anio',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Compra_Almacen(){
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen']= $this->input->post("id_almacen_c");
            $dato['id_producto']= $this->input->post("id_producto_c");
            $dato['fecha_compra']= $this->input->post("fecha_compra_c");
            $dato['id_anio']= $this->input->post("id_anio_c");
            $dato['precio_compra']= $this->input->post("precio_compra_c"); 
            $dato['gasto_arpay']= $this->input->post("gasto_arpay_c");
            $dato['cantidad']= $this->input->post("cantidad_c");
            $get_id = $this->Model_Laleli->get_id_producto($dato['id_producto']);
            $dato['cod_producto'] = $get_id[0]['codigo'];

            $this->Model_Laleli->insert_compra_almacen($dato);

            $ultimo = $this->Model_Laleli->ultimo_id_compra();
            $dato['id_compra'] = $ultimo[0]['id_compra'];
            $dato['tipo'] = 1;

            $this->Model_Laleli->insert_movimiento_almacen($dato);
        }else{
            redirect('/login');
        }
    }

    public function Detalle_Transferir_Producto($id_almacen){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['list_almacen'] = $this->Model_Laleli->get_list_almacen_combo_transferencia($id_almacen,$dato['get_id'][0]['principal'],$dato['get_id'][0]['id_empresa'],$dato['get_id'][0]['id_vendedor']);

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/transferir_producto',$dato);   
        }else{
            redirect('/login');
        }
    }
    
    public function Buscar_Producto_Transferir(){
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen'] = $this->input->post("id_almacen");
            $dato['almacen_actual'] = $this->input->post("almacen_actual");
            $dato['list_producto'] = $this->Model_Laleli->get_list_producto_transferir($dato['almacen_actual']);
            $this->load->view('view_LA/almacen/lista_temporal_t',$dato);
        }else{
            redirect('/login'); 
        }
    }

    public function Detalle_Transferencia(){ 
        if ($this->session->userdata('usuario')) {
            $dato['almacen_actual']= $this->input->post("almacen_actual");
            $dato['id_almacen']= $this->input->post("id_almacen"); 

            $dato['list_detalle'] = array();

            foreach($_POST['productos'] as $list){
                $dato['cod_producto'] = $list;
                $dato['transferido'] = $this->input->post("transferido_".$list);

                $get_id = $this->Model_Laleli->get_cod_producto_transferir($dato['almacen_actual'],$list);

                if($dato['transferido']>0){
                    $dato['list_detalle'][] = array('codigo'=>$get_id[0]['codigo'],'nom_tipo'=>$get_id[0]['nom_tipo'],'descripcion'=>$get_id[0]['descripcion'],'talla'=>$get_id[0]['talla'],'stock'=>$get_id[0]['stock'],'transferido'=>$dato['transferido']);
                }
            }

            $this->load->view('view_LA/almacen/lista_detalle_t',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Valida_Transferir_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['almacen_actual']= $this->input->post("almacen_actual");
            $dato['id_almacen']= $this->input->post("id_almacen");  
            $c_producto = 0;
            $c_error = 0;

            foreach($_POST['productos'] as $list){
                $dato['cod_producto'] = $list;
                $dato['transferido'] = $this->input->post("transferido_".$list);

                $valida = $this->Model_Laleli->valida_stock_transferir_producto($dato);

                if(count($valida)==0){
                    echo "<p style='text-align: justify; font-size:90%; color:black'> Producto ".$dato['cod_producto']." insuficiente!</p>";
                    $c_error++;
                }
                $c_producto++;
            }

            if($c_error>0){
                if($c_error==$c_producto){ 
                    echo "*INCORRECTO";
                }else{
                    echo "*CORRECTO";
                }
            }else{
                foreach($_POST['productos'] as $list){
                    $dato['cod_producto'] = $list;
                    $dato['transferido'] = $this->input->post("transferido_".$list);

                    if($dato['transferido']>0){
                        $get_id = $this->Model_Laleli->get_id_almacen($dato['id_almacen']);
                        $list_producto = $this->Model_Laleli->get_list_producto_disponible_transferir($get_id[0]['principal'],$get_id[0]['id_empresa']);
                        $busqueda = in_array($dato['cod_producto'],array_column($list_producto,'cod_producto'));
    
                        if($busqueda!=false){
                            $valida = $this->Model_Laleli->valida_stock_transferir_producto($dato);
    
                            if(count($valida)>0){
                                $get_producto = $this->Model_Laleli->ultimo_producto_activo($dato['cod_producto']);
                                $dato['id_producto'] = $get_producto[0]['id_producto'];
                                $this->Model_Laleli->insert_transferir_producto_de($dato);
                                $this->Model_Laleli->insert_transferir_producto_para($dato);
                            }
                        }
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Transferir_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['almacen_actual']= $this->input->post("almacen_actual");
            $dato['id_almacen']= $this->input->post("id_almacen"); 

            foreach($_POST['productos'] as $list){
                $dato['cod_producto'] = $list;
                $dato['transferido'] = $this->input->post("transferido_".$list);
                
                if($dato['transferido']>0){
                    $get_id = $this->Model_Laleli->get_id_almacen($dato['id_almacen']);
                    $list_producto = $this->Model_Laleli->get_list_producto_disponible_transferir($get_id[0]['principal'],$get_id[0]['id_empresa']);
                    $busqueda = in_array($dato['cod_producto'],array_column($list_producto,'cod_producto'));

                    if($busqueda!=false){
                        $valida = $this->Model_Laleli->valida_stock_transferir_producto($dato);

                        if(count($valida)>0){
                            $get_producto = $this->Model_Laleli->ultimo_producto_activo($dato['cod_producto']);
                            $dato['id_producto'] = $get_producto[0]['id_producto'];
                            $this->Model_Laleli->insert_transferir_producto_de($dato);
                            $this->Model_Laleli->insert_transferir_producto_para($dato);
                        }
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Detalle_Retirar_Producto($id_almacen){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['id_almacen'] = $id_almacen;
            $this->Model_Laleli->delete_todo_temporal_retirar_producto($dato); 

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/retirar_producto',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Lista_Temporal_Retirar_Producto(){
        if ($this->session->userdata('usuario')) {
            $id_almacen = $this->input->post("id_almacen");
            $dato['list_temporal'] = $this->Model_Laleli->get_list_temporal_retirar_producto($id_almacen);
            $this->load->view('view_LA/almacen/lista_temporal_r',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Retirar_Producto_Almacen($id_almacen){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['list_tipo_producto'] = $this->Model_Laleli->get_list_tipo_producto_almacen($get_id[0]['principal'],$get_id[0]['id_empresa']);
            $this->load->view('view_LA/almacen/modal_retirar_producto',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Producto_Retirar(){
        if ($this->session->userdata('usuario')) {
            $id_tipo_producto = $this->input->post("id_tipo_producto");
            $id_almacen = $this->input->post("id_almacen");
            $dato['list_producto'] = $this->Model_Laleli->get_list_producto_tipo($id_tipo_producto,$id_almacen);
            $this->load->view('view_LA/almacen/traer_retirar_producto',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Modal_Retirar_Producto_Almacen(){
        if ($this->session->userdata('usuario')) {
            $dato['cod_producto']= $this->input->post("cod_producto");
            $dato['id_almacen']= $this->input->post("id_almacen");
            $dato['ingresado']= 1;

            $validar = $this->Model_Laleli->valida_insert_temporal_retirar_producto($dato);

            if(count($validar)>0){
                $dato['ingresado']= $validar[0]['ingresado']+1;
                $this->Model_Laleli->update_temporal_retirar_producto($dato);
            }else{
                $get_producto = $this->Model_Laleli->ultimo_producto_activo($dato['cod_producto']);
                $dato['id_producto'] = $get_producto[0]['id_producto'];
                $this->Model_Laleli->insert_temporal_retirar_producto($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Producto_Retirar(){
        if ($this->session->userdata('usuario')) {
            $cod_producto = $this->input->post("cod_producto");
            $dato['id_almacen'] = $this->input->post("id_almacen");

            $get_almacen = $this->Model_Laleli->get_id_almacen($dato['id_almacen']);
            $principal = $get_almacen[0]['principal'];
            $id_empresa = $get_almacen[0]['id_empresa'];

            $dato['get_id'] = $this->Model_Laleli->get_cod_producto($cod_producto,$principal,$id_empresa);

            if(count($dato['get_id'])==0){
                echo "error";
            }else{
                $dato['cod_producto'] = $cod_producto;
                $dato['stock'] = $this->Model_Laleli->get_stock_producto($dato);
                $this->load->view('view_LA/almacen/datos_producto_r',$dato);
            }
        }else{
            redirect('/login');
        }
    }
 
    public function Insert_Temporal_Retirar_Producto(){ 
        if ($this->session->userdata('usuario')) {
            $dato['cod_producto']= $this->input->post("cod_producto");
            $dato['id_almacen']= $this->input->post("id_almacen");
            $dato['ingresado']= $this->input->post("ingresado");

            $stock = $this->Model_Laleli->get_stock_producto($dato); 

            if($dato['ingresado']>$stock[0]['stock']){
                echo "error";
            }else{
                $validar = $this->Model_Laleli->valida_insert_temporal_retirar_producto($dato);

                if(count($validar)>0){
                    $this->Model_Laleli->update_temporal_retirar_producto($dato);
                }else{
                    $get_producto = $this->Model_Laleli->ultimo_producto_activo($dato['cod_producto']);
                    $dato['id_producto'] = $get_producto[0]['id_producto'];
                    $this->Model_Laleli->insert_temporal_retirar_producto($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Temporal_Retirar_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal");
            $this->Model_Laleli->delete_temporal_retirar_producto($dato);            
        }else{
            redirect('/login');
        }
    } 

    public function Valida_Retirar_Producto(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen']= $this->input->post("id_almacen");
            $list_temporal = $this->Model_Laleli->get_list_temporal_retirar_producto($dato['id_almacen']);

            if(count($list_temporal)==0){
                echo "error*error";
            }else{
                $c_error = 0;

                foreach($list_temporal as $list){
                    $dato['id_producto'] = $list['id_producto'];
                    $dato['cod_producto'] = $list['codigo'];
                    $dato['ingresado'] = $list['ingresado'];

                    $validar = $this->Model_Laleli->valida_stock_retirar_producto($dato); 

                    if(count($validar)==0){
                        echo "<p style='text-align: justify; font-size:90%; color:black'> Producto ".$dato['cod_producto']." insuficiente!</p>";
                        $c_error++;
                    }
                }

                if($c_error>0){
                    if($c_error==count($list_temporal)){
                        echo "*INCORRECTO";
                    }else{
                        echo "*CORRECTO";
                    }
                }else{
                    foreach($list_temporal as $list){
                        $dato['id_producto'] = $list['id_producto'];
                        $dato['cod_producto'] = $list['codigo'];
                        $dato['ingresado'] = $list['ingresado'];
    
                        $validar = $this->Model_Laleli->valida_stock_retirar_producto($dato);
    
                        if(count($validar)>0){
                            $this->Model_Laleli->insert_retirar_producto($dato);
                        }
                    }

                    $this->Model_Laleli->delete_todo_temporal_retirar_producto($dato);        
                }    
            }
        }else{
            redirect('/login'); 
        }
    }

    public function Retirar_Producto(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_almacen']= $this->input->post("id_almacen");
            $list_temporal = $this->Model_Laleli->get_list_temporal_retirar_producto($dato['id_almacen']);

            if(count($list_temporal)==0){ 
                echo "error";
            }else{
                foreach($list_temporal as $list){
                    $dato['id_producto'] = $list['id_producto'];
                    $dato['cod_producto'] = $list['codigo'];
                    $dato['ingresado'] = $list['ingresado'];

                    $validar = $this->Model_Laleli->valida_stock_retirar_producto($dato);

                    if(count($validar)>0){
                        $this->Model_Laleli->insert_retirar_producto($dato);
                    }
                }

                $this->Model_Laleli->delete_todo_temporal_retirar_producto($dato);            
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Almacen($id_almacen){
        $list_detalle = $this->Model_Laleli->get_list_detalle_almacen($id_almacen);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Almacén');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);

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

        $sheet->setCellValue("A1", 'Almacén');	
        $sheet->setCellValue("B1", 'Código');	
        $sheet->setCellValue("C1", 'Tipo');	   
        $sheet->setCellValue("D1", 'Descripción');	        
        $sheet->setCellValue("E1", 'Talla/Ref');
        $sheet->setCellValue("F1", 'Añadidos');	
        $sheet->setCellValue("G1", 'Transferidos');	  
        $sheet->setCellValue("H1", 'Retirados');      
        $sheet->setCellValue("I1", 'Devoluciones');
        $sheet->setCellValue("J1", 'Ventas');	
        $sheet->setCellValue("K1", 'Stock');	 
        $sheet->setCellValue("L1", 'Stock Total');	                       

        $contador=1;
        
        foreach($list_detalle as $list){ 
            //if($list['stock_total']>0){
                $contador++;
                
                $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", $list['nom_almacen']); 
                $sheet->setCellValue("B{$contador}", $list['codigo']); 
                $sheet->setCellValue("C{$contador}", $list['nom_tipo']);
                $sheet->setCellValue("D{$contador}", $list['descripcion']);
                $sheet->setCellValue("E{$contador}", $list['talla']);
                $sheet->setCellValue("F{$contador}", $list['ingresado']);
                $sheet->setCellValue("G{$contador}", $list['transferido']);
                $sheet->setCellValue("H{$contador}", $list['retirado']);
                $sheet->setCellValue("I{$contador}", $list['devolucion']);
                $sheet->setCellValue("J{$contador}", $list['venta']);
                $sheet->setCellValue("K{$contador}", $list['stock']);
                $sheet->setCellValue("L{$contador}", $list['stock_total']);  
            //}
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle Almacén (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Movimiento_Almacen($id_almacen,$cod_producto){
        if ($this->session->userdata('usuario')) {
            $cod_producto = str_replace('_','-',$cod_producto);

            $dato['get_id'] = $this->Model_Laleli->get_id_almacen($id_almacen);
            $dato['get_producto'] = $this->Model_Laleli->get_cod_producto_movimiento($cod_producto);
            
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/almacen/movimiento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Movimiento_Almacen(){
        if ($this->session->userdata('usuario')) {
            $id_almacen = $this->input->post("id_almacen");
            $cod_producto = $this->input->post("cod_producto");
            $dato['list_movimiento_almacen'] = $this->Model_Laleli->get_list_movimiento_almacen($id_almacen,$cod_producto);
            $this->load->view('view_LA/almacen/lista_movimiento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Movimiento_Almacen($id_almacen,$cod_producto){
        $cod_producto = str_replace('_','-',$cod_producto);
        $list_movimiento_almacen = $this->Model_Laleli->get_list_movimiento_almacen($id_almacen,$cod_producto);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Movimiento Almacén');

        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(18);

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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Usuario');	
        $sheet->setCellValue("C1", 'Fecha');	   
        $sheet->setCellValue("D1", 'Tipo');	        
        $sheet->setCellValue("E1", 'De/Para');
        $sheet->setCellValue("F1", 'Código');	
        $sheet->setCellValue("G1", 'Apellido Paterno');	        
        $sheet->setCellValue("H1", 'Apellido Materno'); 
        $sheet->setCellValue("I1", 'Nombre');	
        $sheet->setCellValue("J1", 'Tipo Recibo');	 
        $sheet->setCellValue("K1", 'Recibo');	
        $sheet->setCellValue("L1", 'Cantidad');	 
        $sheet->setCellValue("M1", 'Saldo');
        $sheet->setCellValue("N1", 'Fecha Compra');	
        $sheet->setCellValue("O1", 'Año');	
        $sheet->setCellValue("P1", 'Precio Compra');	 
        $sheet->setCellValue("Q1", 'Gasto Arpay');

        $contador=1;
        
        foreach($list_movimiento_almacen as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_producto']);
            $sheet->setCellValue("B{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['tipo_movimiento']);
            $sheet->setCellValue("E{$contador}", $list['de_para']);
            $sheet->setCellValue("F{$contador}", $list['Codigo']);
            $sheet->setCellValue("G{$contador}", $list['Ap_Paterno']);
            $sheet->setCellValue("H{$contador}", $list['Ap_Materno']);
            $sheet->setCellValue("I{$contador}", $list['Nombre']);
            $sheet->setCellValue("J{$contador}", $list['nom_tipo_documento']);
            $sheet->setCellValue("K{$contador}", $list['cod_venta']);
            $sheet->setCellValue("L{$contador}", $list['cantidad']);
            $sheet->setCellValue("M{$contador}", $list['saldo']);

            if($list['fec_compra']!=""){
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list['fec_compra']));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("N{$contador}", "");
            }

            $sheet->setCellValue("O{$contador}", $list['nom_anio']);
            $sheet->setCellValue("P{$contador}", $list['precio_compra']);
            $sheet->setCellValue("Q{$contador}", $list['gasto_arpay']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Movimiento Almacén (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------ENTREGA VENTA-------------------------------------
    public function Entrega_Venta(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/entrega_venta/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Entrega_Venta() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_entrega_venta'] = $this->Model_Laleli->get_list_entrega_venta($dato['tipo']);
            $this->load->view('view_LA/entrega_venta/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Venta_Lista(){
        if ($this->session->userdata('usuario')) {
            $dato['id_venta'] = $this->input->post("id_venta");
            $this->Model_Laleli->update_venta_lista($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Venta_Entregada($id_venta){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_venta($id_venta);
            $this->load->view('view_LA/entrega_venta/modal_entrega',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Tipo_Envio(){
        if ($this->session->userdata('usuario')) {
            $dato['tipo_envio'] = $this->input->post("tipo_envio");
            $this->load->view('view_LA/entrega_venta/tipo_envio',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Enviar_Codigo_Verificacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_venta'] = $this->input->post("id_venta");
            $dato['tipo_envio'] = $this->input->post("tipo_envio");
            $dato['correo_sms'] = $this->input->post("correo_sms");

            $dato['codigo_verificacion'] = rand(1000,9999);

            if($dato['tipo_envio']==1){
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'eventos@gllg.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'GLLG2022';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('no-reply@gllg.edu.pe', 'Código Verificación'); //desde donde se envia
    
                    $mail->addAddress($dato['correo_sms']);
    
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = "Código Verificación";
                    $mail->Body = "El código de verificación es el: ".$dato['codigo_verificacion'];
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }else{
                include('application/views/administrador/mensaje/httpPHPAltiria.php');

                $altiriaSMS = new AltiriaSMS();
        
                $altiriaSMS->setDebug(true);
                $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                $altiriaSMS->setPassword('gllg2021');
            
                $sDestination = '51'.$dato['correo_sms'];
                $sMessage = "El código de verificación es el: ".$dato['codigo_verificacion'];
                $altiriaSMS->sendSMS($sDestination, $sMessage);
            }

            $this->Model_Laleli->update_venta_codigo_verificacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Venta_Entregada(){
        if ($this->session->userdata('usuario')) {
            $dato['id_venta'] = $this->input->post("id_venta");
            $dato['codigo_verificacion'] = $this->input->post("codigo_verificacion");

            $valida = $this->Model_Laleli->get_list_venta($dato['id_venta']);

            if($valida[0]['codigo_verificacion']==$dato['codigo_verificacion']){
                $this->Model_Laleli->update_venta_entregada($dato);
            }else{
                echo "error";
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Entrega_Venta($tipo){
        $list_entrega_venta = $this->Model_Laleli->get_list_entrega_venta($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Entregas');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
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

        $sheet->setCellValue("A1", 'P. Venta');	
        $sheet->setCellValue("B1", 'Fecha');	        
        $sheet->setCellValue("C1", 'Alumno');
        $sheet->setCellValue("D1", 'Documento');	
        $sheet->setCellValue("E1", 'Número');	        
        $sheet->setCellValue("F1", 'Cantidad');
        $sheet->setCellValue("G1", 'Total');	
        $sheet->setCellValue("H1", 'Tipo Pago');	 
        $sheet->setCellValue("I1", 'Usuario');	               
        $sheet->setCellValue("J1", 'Estado');       

        $contador=1;
        
        foreach($list_entrega_venta as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", "");
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list['nom_alumno']);
            $sheet->setCellValue("D{$contador}", $list['nom_tipo_documento']);
            $sheet->setCellValue("E{$contador}", "");
            $sheet->setCellValue("F{$contador}", $list['cantidad']);
            $sheet->setCellValue("G{$contador}", $list['total']);
            $sheet->setCellValue("H{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("I{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("J{$contador}", "");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Entregas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------ENCOMIENDAS-------------------------------------
    public function Encomienda(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/encomienda/index',$dato); 
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Encomienda() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_encomienda'] = $this->Model_Laleli->get_list_encomienda($tipo);
            $this->load->view('view_LA/encomienda/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Entrega_Encomienda($id_encomienda){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_encomienda'] = $id_encomienda;
            $this->load->view('view_LA/encomienda/modal_entrega',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Entrega_Encomienda() {
        if ($this->session->userdata('usuario')) {
            $dato['id_encomienda'] = $this->input->post("id_encomienda");
            $get_id = $this->Model_Laleli->get_id_encomienda($dato['id_encomienda']);
            $dato['id_almacen'] = $get_id[0]['id_almacen'];
            $dato['id_producto'] = $get_id[0]['id_producto'];
            $dato['cod_producto'] = $get_id[0]['cod_producto'];

            $valida = $this->Model_Laleli->get_stock_producto($dato); 

            if($valida[0]['stock']>0){
                $dato['id_venta'] = $get_id[0]['id_venta'];

                $this->Model_Laleli->entrega_encomienda($dato);

                $valida = $this->Model_Laleli->valida_encomienda_terminada($dato['id_venta']);
                if(count($valida)==0){
                    $this->Model_Laleli->update_encomienda_terminada($dato['id_venta']);
                }
            }else{
                echo "error";
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Encomienda($tipo){ 
        $list_encomienda = $this->Model_Laleli->get_list_encomienda($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Encomiendas');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Documento');
        $sheet->setCellValue("B1", 'Compra');	
        $sheet->setCellValue("C1", 'Usuario');	
        $sheet->setCellValue("D1", 'Codigo');	    
        $sheet->setCellValue("E1", 'Tipo');
        $sheet->setCellValue("F1", 'Descripción');  
        $sheet->setCellValue("G1", 'Talla');
        $sheet->setCellValue("H1", 'Stock');	 
        $sheet->setCellValue("I1", 'Estado');	
        $sheet->setCellValue("J1", 'Fecha Entrega');	    
        $sheet->setCellValue("K1", 'Usuario');

        $contador=1;
        
        foreach($list_encomienda as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_venta']); 
            if($list['fecha_venta']!=""){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha_venta']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['usuario_venta']);
            $sheet->setCellValue("D{$contador}", $list['cod_producto']);
            $sheet->setCellValue("E{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("F{$contador}", $list['descripcion']);
            $sheet->setCellValue("G{$contador}", $list['talla']);
            $sheet->setCellValue("H{$contador}", $list['stock']);
            $sheet->setCellValue("I{$contador}", $list['nom_estado']);
            if($list['fecha_entrega']!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_entrega']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("J{$contador}", "");
            }
            $sheet->setCellValue("K{$contador}", $list['usuario_entrega']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Encomiendas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------VENTA-------------------------------------
    public function Venta(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/venta/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Venta() {
        if ($this->session->userdata('usuario')) {
            $dato['list_venta'] = $this->Model_Laleli->get_list_venta();
            $this->load->view('view_LA/venta/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Anular_Venta($id_venta){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_venta($id_venta);
            $this->load->view('view_LA/venta/modal_anular', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Anular_Venta(){
        if ($this->session->userdata('usuario')) {
            $dato['id_venta']= $this->input->post("id_venta");
            $dato['motivo']= $this->input->post("motivo_a");

            $get_id = $this->Model_Laleli->get_list_venta($dato['id_venta']);

            $valida_cierre_caja = $this->Model_Laleli->valida_cierre_caja($get_id[0]['id_sede']);

            if(count($valida_cierre_caja)==0){ 
                $dato['id_vendedor'] = $get_id[0]['user_reg'];
    
                $valida = $this->Model_Laleli->valida_aprobar_devolucion($get_id[0]['user_reg'],$get_id[0]['id_sede']);
    
                if($valida[0]['total']<$get_id[0]['total']){
                    echo "error";
                }else{
                    $this->Model_Laleli->insert_aprobar_devolucion($dato); 

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
                        $mail->setFrom('webcontactos@gllg.edu.pe', 'Solicitud de Devolución'); //desde donde se envia 
                        
                        $mail->addAddress('pedro.vieira@gllg.edu.pe');
                        $mail->addAddress('vanessa.hilario@gllg.edu.pe');
                        
                        $mail->isHTML(true);                                  // Set email format to HTML
                
                        $mail->Subject = 'Solicitud de Devolución'; 
                
                        $mail->Body =  '<FONT SIZE=3>
                                            ¡Hola!<br>
                                            Hay una nueva solicitud pendiente de aprobación en '.$get_id[0]['cod_sede'].' referente a una prenda.<br>
                                            Por favor confirma si es aprobada.<br><br>
                                            Puedes revisar directamente en este link:<br><br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://snappy.org.pe/index.php?/Laleli/Devolucion <br><br>
                                            Que tengas un excelente día.<br>
                                            Sistema Snappy<br>
                                        </FONT SIZE>';
                
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                }
            }else{
                echo "cierre_caja";
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Venta(){ 
        $list_venta = $this->Model_Laleli->get_list_venta();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Venta');

        $sheet->setAutoFilter('A1:Q1'); 

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(30);

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

        $sheet->setCellValue("A1", 'Número');	
        $sheet->setCellValue("B1", 'P. Venta');	
        $sheet->setCellValue("C1", 'Fecha');	
        $sheet->setCellValue("D1", 'Usuario');	    
        $sheet->setCellValue("E1", 'Código');
        $sheet->setCellValue("F1", 'Apellido Paterno');
        $sheet->setCellValue("G1", 'Apellido Materno');
        $sheet->setCellValue("H1", 'Nombre');
        $sheet->setCellValue("I1", 'Documento');	        
        $sheet->setCellValue("J1", 'Cantidad');
        $sheet->setCellValue("K1", 'Total');	
        $sheet->setCellValue("L1", 'Tipo Pago');	 
        $sheet->setCellValue("M1", 'Estado');    
        $sheet->setCellValue("N1", 'Fecha');	 
        $sheet->setCellValue("O1", 'Usuario');	                
        $sheet->setCellValue("P1", 'Tipo');    
        $sheet->setCellValue("Q1", 'Motivo');    

        $contador=1;
        
        foreach($list_venta as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_venta']); 
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("E{$contador}", $list['Codigo']);
            $sheet->setCellValue("F{$contador}", $list['Ap_Paterno']);
            $sheet->setCellValue("G{$contador}", $list['Ap_Materno']);
            $sheet->setCellValue("H{$contador}", $list['Nombre']);
            $sheet->setCellValue("I{$contador}", $list['nom_tipo_documento']);
            $sheet->setCellValue("J{$contador}", $list['cantidad']);
            $sheet->setCellValue("K{$contador}", $list['total']);
            $sheet->setCellValue("L{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("M{$contador}", $list['nom_estado_venta']);
            if($list['fecha_anulado']!=""){
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list['fecha_anulado']));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("N{$contador}", "");
            }
            $sheet->setCellValue("O{$contador}", $list['usuario_anulado']);
            $sheet->setCellValue("P{$contador}", $list['nom_tipo_envio']);
            $sheet->setCellValue("Q{$contador}", $list['motivo']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Venta (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Pdf_Venta($id_venta){
        $get_id = $this->Model_Laleli->get_list_venta($id_venta);
        $list_detalle = $this->Model_Laleli->get_list_venta_detalle($id_venta);

        if($get_id[0]['id_tipo_documento']==1){

            $this->load->library('Pdf');

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Erick Daniel Palomino Mamani');
            $pdf->SetTitle('Recibo');
            $pdf->SetSubject('Recibo');
            $pdf->SetKeywords('Recibo');
    
            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
    
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
    
            // ---------------------------------------------------------
    
            // set font
            $pdf->SetFont('helvetica','B',11);
    
            // add a page
            $pdf->AddPage();
    
            $y2=25;
    
            $pdf->SetFillColor(255,255,255);
    
            $pdf->SetXY (12,$y2-16);
            $pdf->MultiCell (75,6,'I.E.P Laleli EIRL',0,'C',1,0,'','',true,0,false,true,6,'M');

            $pdf->SetXY (12,$y2-10);
            $pdf->MultiCell (75,6,'RUC: 20602823891',0,'C',1,0,'','',true,0,false,true,6,'M');

            $pdf->SetXY (12,$y2-4);
            $pdf->MultiCell (75,6,'Luis Massaro, 104',0,'C',1,0,'','',true,0,false,true,6,'M');

            $pdf->Line(12,$y2+4,87,$y2+4,'');

            $pdf->SetXY (12,$y2+7);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (17,5,'Ticket:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (20,5,'FV33351',0,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','B',10); 
            $pdf->MultiCell (18,5,'Usuario:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (20,5,'BBVA',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (12,$y2+12);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (17,5,'Fecha:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (20,5,$get_id[0]['fecha'],0,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (18,5,'Hora:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (20,5,'00:00',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->Line(12,$y2+20,87,$y2+20,'');

            $pdf->SetXY (12,$y2+23);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (17,5,'Codigo:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (58,5,'22375',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (12,$y2+28);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (17,9,'Alumno:',0,'R',1,0,'','',true,0,false,true,9,'T');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (58,9,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,9,'T');

            $pdf->SetFont('helvetica','',10);

            $posicion = 35;
            $total = 0;

            foreach($list_detalle as $list){
                $posicion = $posicion+5;

                $pdf->SetXY (12,$y2+$posicion);
                $pdf->MultiCell (58,5,$list['descripcion'],0,'L',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (17,5,"S/".number_format(($list['precio']*$list['cantidad']),2),0,'R',1,0,'','',true,0,false,true,5,'M');
                $total = $total+($list['precio']*$list['cantidad']);
            }

            $posicion = $y2+$posicion+8;

            $pdf->Line(12,$posicion,87,$posicion,'');

            $pdf->SetXY (12,$posicion+3);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (58,5,'TOTAL:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',10);
            $pdf->MultiCell (17,5,"S/".number_format(($total),2),0,'R',1,0,'','',true,0,false,true,5,'M');

            $pdf->Line(12,($posicion+11),87,($posicion+11),'');

            $pdf->SetXY (12,$posicion+14);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (75,5,'www.ifv.edu.pe',0,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (12,$posicion+19);
            $pdf->SetFont('helvetica','B',10);
            $pdf->MultiCell (42,5,'chincha@gllg.edu.pe',0,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (3,5,'|',0,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (30,5,'Tlf:3309950',0,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->Output('Recibo.pdf', 'I');

        }elseif($get_id[0]['id_tipo_documento']==2){

            $this->load->library('Pdf');

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Erick Daniel Palomino Mamani');
            $pdf->SetTitle('Boleta de Venta');
            $pdf->SetSubject('Boleta');
            $pdf->SetKeywords('Boleta, Venta');
    
            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
    
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
    
            // ---------------------------------------------------------
    
            // set font
            $pdf->SetFont('helvetica','B',12);
    
            // add a page
            $pdf->AddPage();
    
            $y2=25;
    
            $pdf->SetFillColor(255,255,255);
    
            $pdf->SetXY (17,$y2-16);
            $pdf->MultiCell (60,6,'I.E.P Laleli EIRL',0,'L',1,0,'','',true,0,false,true,6,'M');
    
            $pdf->SetFont('helvetica','',9);
    
            $pdf->SetXY (17,$y2-10);
            $pdf->MultiCell (60,5,'LL Jesus Maria SAC',0,'L',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (17,$y2-5);
            $pdf->MultiCell (60,5,'Av. General Garzón, 1045',0,'L',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (17,$y2);
            $pdf->MultiCell (60,5,'Jesus Maria - Lima - Lima',0,'L',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetFont('helvetica','B',14);
    
            $pdf->SetXY (126.8,$y2-20);
            $pdf->MultiCell (75.3,25.3,'',1,'C',1,0,'','',true,0,false,true,24,'M');
    
            $pdf->SetFillColor(214,216,70);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetXY (127,$y2-20);
            $pdf->MultiCell (75,9,'BOLETA DE VENTA',0,'C',1,0,'','',true,0,false,true,9,'M');
    
            $pdf->SetFont('helvetica','',12);
            $pdf->SetTextColor(0,0,0);
    
            $pdf->SetFillColor(236,237,179);
            $pdf->SetXY (127,$y2-11);
            $pdf->MultiCell (75,8,'RUC: 20602823891',0,'C',1,0,'','',true,0,false,true,8,'M');
    
            $pdf->SetFont('helvetica','B',12);
    
            $pdf->SetFillColor(255,255,255);
            $pdf->SetXY (127,$y2-3);
            $pdf->MultiCell (75,8,$get_id[0]['cod_venta'],0,'C',1,0,'','',true,0,false,true,8,'M');
    
            $pdf->SetXY (17,$y2+25);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (165,6,$get_id[0]['fecha'],0,'L',1,0,'','',true,0,false,true,6,'M');
            
            $pdf->SetXY (17,$y2+31);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Alumno(a):',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (126,6,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (21,6,'Documento:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (18,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
    
            $pdf->SetXY (17,$y2+37);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Sede:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (14,6,'Grado:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (32,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (18,6,'Sección:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (32,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (26,6,'Codigo interno:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (13,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
    
            $altura = (count($list_detalle)*5)+48;
    
            $pdf->SetXY (22,$y2+50);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (172,$altura,'',1,'L',1,0,'','',true,0,false,true,$altura,'M');
    
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(217,217,217);
    
            $pdf->SetXY (32,$y2+55);
            $pdf->MultiCell (82,5,'PRODUCTO',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'MONTO',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'CANTIDAD',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'SUB-TOTAL',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetFont('helvetica','',9);
    
            $posicion = 55;
            $i = 0;
    
            foreach($list_detalle as $list){
                $posicion = $posicion+5;
                $i++;
    
                $pdf->SetXY (27,$y2+$posicion);
                $pdf->SetFillColor(217,217,217);
                $pdf->MultiCell (5,5,$i,1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->SetFillColor(255,255,255);
                $pdf->MultiCell (82,5,$list['descripcion'],1,'L',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,"S/".number_format($list['precio'],2),1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,$list['cantidad'],1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,"S/".number_format(($list['precio']*$list['cantidad']),2),1,'C',1,0,'','',true,0,false,true,5,'M');
            }
    
            $posicion = $y2+$posicion+5;
    
            $pdf->SetXY (27,$posicion);
            $pdf->SetFillColor(217,217,217);
            $pdf->MultiCell (5,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (82,5,'',1,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (134,$posicion+8);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Gravada:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (134,$posicion+13);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Exonerada:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (134,$posicion+18);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Inafecta:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/550,00',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (134,$posicion+23);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'IGV (0%)',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (32,$posicion+28);
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(242,242,242); 
            $pdf->MultiCell (102,5,'Son: quinientos cincuenta y 00/100 Soles',0,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','B',8);
            $pdf->MultiCell (30,5,'IMPORTE TOTAL: ',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(217,217,217);
            $pdf->MultiCell (25,5,'S/550,00',1,'C',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetFillColor(255,255,255);
    
            $pdf->SetXY (17,$posicion+43);
            $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');
    
            $pdf->SetXY (158,$posicion+43);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Operacion:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (10,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (138,$posicion+48);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Pagamento:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->SetXY (150,$posicion+53);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (18,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');
    
            $pdf->Output('Boleta_Venta.pdf', 'I');

        }elseif($get_id[0]['id_tipo_documento']==3){

            $this->load->library('Pdf');

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Erick Daniel Palomino Mamani');
            $pdf->SetTitle('Factura Electronica');
            $pdf->SetSubject('Factura Electronica');
            $pdf->SetKeywords('Factura, Electronica');

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $pdf->SetFont('helvetica','B',12);

            // add a page
            $pdf->AddPage();

            $y2=25;

            $pdf->SetFillColor(255,255,255);

            $pdf->SetXY (17,$y2-16);
            $pdf->MultiCell (60,6,'I.E.P Laleli EIRL',0,'L',1,0,'','',true,0,false,true,6,'M');

            $pdf->SetFont('helvetica','',9);

            $pdf->SetXY (17,$y2-10);
            $pdf->MultiCell (60,5,'LL Jesus Maria SAC',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (17,$y2-5);
            $pdf->MultiCell (60,5,'Av. General Garzón, 1045',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (17,$y2);
            $pdf->MultiCell (60,5,'Jesus Maria - Lima - Lima',0,'L',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetFont('helvetica','B',14);

            $pdf->SetXY (126.8,$y2-20);
            $pdf->MultiCell (75.3,25.3,'',1,'C',1,0,'','',true,0,false,true,24,'M');

            $pdf->SetFillColor(0,112,192);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetXY (127,$y2-20);
            $pdf->MultiCell (75,9,'FACTURA ELECTRONICA',0,'C',1,0,'','',true,0,false,true,9,'M');

            $pdf->SetFont('helvetica','',12);
            $pdf->SetTextColor(0,0,0);

            $pdf->SetFillColor(221,235,247);
            $pdf->SetXY (127,$y2-11);
            $pdf->MultiCell (75,8,'RUC: 20602823891',0,'C',1,0,'','',true,0,false,true,8,'M');

            $pdf->SetFont('helvetica','B',12);

            $pdf->SetFillColor(255,255,255);
            $pdf->SetXY (127,$y2-3);
            $pdf->MultiCell (75,8,$get_id[0]['cod_venta'],0,'C',1,0,'','',true,0,false,true,8,'M');

            $pdf->SetXY (9.8,$y2+10);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (192.2,14.2,'',1,'L',1,0,'','',true,0,false,true,14.2,'M');

            $pdf->SetXY (10,$y2+10);
            $pdf->MultiCell (7,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Señor(es):',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (60,6,$get_id[0]['nom_empresa'],0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'RUC:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,6,$get_id[0]['ruc'],0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (30,6,'Tipo de Moneda:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (25,6,'Soles',0,'L',1,0,'','',true,0,false,true,6,'M');

            $pdf->SetXY (10,$y2+16);
            $pdf->MultiCell (7,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,8,'Dirección:',0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (60,8,$get_id[0]['direccion'],0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,8,'Provincia:',0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,8,$get_id[0]['provincia'],0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (18,8,'Distrito:',0,'L',1,0,'','',true,0,false,true,8,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (37,8,$get_id[0]['distrito'],0,'L',1,0,'','',true,0,false,true,8,'M');

            $pdf->SetFillColor(255,255,255);

            $pdf->SetXY (17,$y2+25);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (165,6,$get_id[0]['fecha'],0,'L',1,0,'','',true,0,false,true,6,'M');
            
            $pdf->SetXY (17,$y2+31);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Alumno(a):',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (126,6,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (21,6,'Documento:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (18,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');

            $pdf->SetXY (17,$y2+37);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (20,6,'Sede:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (14,6,'Grado:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (32,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (18,6,'Sección:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (32,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (26,6,'Codigo interno:',0,'L',1,0,'','',true,0,false,true,6,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (13,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');

            $altura = (count($list_detalle)*5)+48;

            $pdf->SetXY (22,$y2+50);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (172,$altura,'',1,'L',1,0,'','',true,0,false,true,$altura,'M');

            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(217,217,217);

            $pdf->SetXY (32,$y2+55);
            $pdf->MultiCell (82,5,'PRODUCTO',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'MONTO',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'CANTIDAD',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'SUB-TOTAL',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetFont('helvetica','',9);

            $posicion = 55;
            $i = 0;

            foreach($list_detalle as $list){
                $posicion = $posicion+5;
                $i++;

                $pdf->SetXY (27,$y2+$posicion);
                $pdf->SetFillColor(217,217,217);
                $pdf->MultiCell (5,5,$i,1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->SetFillColor(255,255,255);
                $pdf->MultiCell (82,5,$list['descripcion'],1,'L',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,"S/".number_format($list['precio'],2),1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,$list['cantidad'],1,'C',1,0,'','',true,0,false,true,5,'M');
                $pdf->MultiCell (25,5,"S/".number_format(($list['precio']*$list['cantidad']),2),1,'C',1,0,'','',true,0,false,true,5,'M');
            }

            $posicion = $y2+$posicion+5;

            $pdf->SetXY (27,$posicion);
            $pdf->SetFillColor(217,217,217);
            $pdf->MultiCell (5,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (82,5,'',1,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
            $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (134,$posicion+8);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Gravada:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (134,$posicion+13);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Exonerada:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (134,$posicion+18);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'OP. Inafecta:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/550,00',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (134,$posicion+23);
            $pdf->SetFont('helvetica','',8);
            $pdf->SetFillColor(242,242,242);
            $pdf->MultiCell (30,5,'IGV (0%)',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(255,255,255);
            $pdf->MultiCell (25,5,'S/0,00',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (32,$posicion+28);
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(242,242,242); 
            $pdf->MultiCell (102,5,'Son: quinientos cincuenta y 00/100 Soles',0,'L',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','B',8);
            $pdf->MultiCell (30,5,'IMPORTE TOTAL: ',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->SetFillColor(217,217,217);
            $pdf->MultiCell (25,5,'S/550,00',1,'C',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetFillColor(255,255,255);

            $pdf->SetXY (17,$posicion+43);
            $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');

            $pdf->SetXY (158,$posicion+43);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Operacion:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (10,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (138,$posicion+48);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Pagamento:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (30,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');

            $pdf->SetXY (150,$posicion+53);
            $pdf->SetFont('helvetica','B',9);
            $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'R',1,0,'','',true,0,false,true,5,'M');
            $pdf->SetFont('helvetica','',9);
            $pdf->MultiCell (18,5,'',0,'R',1,0,'','',true,0,false,true,5,'M');

            $pdf->Output('Boleta_Venta.pdf', 'I');

        } 
    }

    public function Documento_Venta($id_venta){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_venta($id_venta);
            $dato['list_detalle'] = $this->Model_Laleli->get_list_venta_detalle($id_venta);
            $this->load->view('view_LA/venta/impresion',$dato);
        }else{
            redirect('');
        }
    }

    public function Recibo_Venta($id_venta){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_list_venta($id_venta);
            $dato['list_detalle'] = $this->Model_Laleli->get_list_venta_detalle($id_venta);
            $cantidad_filas = 30*count($dato['list_detalle']);
            //$dato['altura'] = 560+$cantidad_filas;  
            $dato['altura'] = 500+$cantidad_filas;

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);

            /*$mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 
                'format' => [45, 350], 
                'default_font' => 'gothic' 
            ]);*/

            $html = $this->load->view('view_LA/venta/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }
    //-----------------------------------CIERRES DE CAJA-------------------------------------
    public function Cierre_Caja(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre()); 

            $this->load->view('view_LA/cierre_caja/index',$dato);  
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Cierre_Caja() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_cierre_caja'] = $this->Model_Laleli->get_list_cierre_caja($tipo);
            $this->load->view('view_LA/cierre_caja/lista',$dato);
        }else{ 
            redirect('/login');
        }
    }

    public function Modal_Update_Cierre_Caja($id_cierre_caja){
        if ($this->session->userdata('usuario')) {  
            $dato['get_id'] = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
            $this->load->view('view_LA/cierre_caja/modal_editar',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Update_Cierre_Caja(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $dato['cofre']= $this->input->post("cofre_u");
            $this->Model_Laleli->update_cofre_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Delete_Cierre_Caja(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $this->Model_Laleli->delete_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cierre_Caja($tipo){ 
        $list_cierre_caja = $this->Model_Laleli->get_list_cierre_caja($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cierre de Caja'); 

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(40);
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

        $sheet->setCellValue("A1", 'Sede');	
        $sheet->setCellValue("B1", 'Mes');	
        $sheet->setCellValue("C1", 'Vendedor');	
        $sheet->setCellValue("D1", 'Caja');	
        $sheet->setCellValue("E1", 'Saldo Automático');	    
        $sheet->setCellValue("F1", 'Monto Entregado');
        $sheet->setCellValue("G1", 'Productos'); 
        $sheet->setCellValue("H1", 'Diferencia');
        $sheet->setCellValue("I1", 'Recibe');
        $sheet->setCellValue("J1", 'Fecha');	
        $sheet->setCellValue("K1", 'Usuario');	         
        $sheet->setCellValue("L1", 'Cofre');  
        $sheet->setCellValue("M1", 'Estado');  

        $contador=1;
        
        foreach($list_cierre_caja as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("E{$contador}:F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_sede']);
            $sheet->setCellValue("B{$contador}", $list['mes_anio']);
            $sheet->setCellValue("C{$contador}", $list['cod_vendedor']);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['caja']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("E{$contador}", $list['saldo_automatico']); 
            $sheet->setCellValue("F{$contador}", $list['monto_entregado']);
            $sheet->setCellValue("G{$contador}", $list['productos']);
            $sheet->setCellValue("H{$contador}", $list['diferencia']);
            $sheet->setCellValue("I{$contador}", $list['cod_entrega']);
            $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("K{$contador}", $list['cod_registro']); 
            $sheet->setCellValue("L{$contador}", $list['cofre']);
            $sheet->setCellValue("M{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cierre de Caja (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Pdf_Cierre_Caja($id_cierre_caja){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
            
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_LA/cierre_caja/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Detalle_Cierre_Caja($id_cierre_caja){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);

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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/cierre_caja/detalle',$dato); 
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Ingreso_Cierre_Caja() { 
        if ($this->session->userdata('usuario')) {
            $id_cierre_caja = $this->input->post("id_cierre_caja");
            $get_id = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
            $dato['list_ingreso'] = $this->Model_Laleli->get_list_ingreso_cierre_caja($get_id[0]['id_sede'],$get_id[0]['fecha'],$get_id[0]['id_vendedor']);
            $this->load->view('view_LA/cierre_caja/lista_ingreso',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Ingreso_Cierre_Caja($id_cierre_caja){ 
        $get_id = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
        $list_ingreso = $this->Model_Laleli->get_list_ingreso_cierre_caja($get_id[0]['id_sede'],$get_id[0]['fecha'],$get_id[0]['id_vendedor']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Ingresos'); 

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18);

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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Apellido Paterno');	
        $sheet->setCellValue("C1", 'Apellido Materno');	
        $sheet->setCellValue("D1", 'Nombre(s)');	    
        $sheet->setCellValue("E1", 'Producto');
        $sheet->setCellValue("F1", 'Precio'); 
        $sheet->setCellValue("G1", 'Cantidad'); 
        $sheet->setCellValue("H1", 'Total');
        $sheet->setCellValue("I1", 'Recibo Electrónico');
        $sheet->setCellValue("J1", 'Fecha Pago');	
        $sheet->setCellValue("K1", 'Efectuado Por');	         

        $contador=1;
        
        foreach($list_ingreso as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['Codigo']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("C{$contador}", $list['Apellido_Materno']); 
            $sheet->setCellValue("D{$contador}", $list['Nombre']); 
            $sheet->setCellValue("E{$contador}", $list['cod_producto']);
            $sheet->setCellValue("F{$contador}", $list['precio']);
            $sheet->setCellValue("G{$contador}", $list['cantidad']);
            $sheet->setCellValue("H{$contador}", $list['total']);
            $sheet->setCellValue("I{$contador}", $list['cod_venta']);
            $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_pago']));
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("K{$contador}", $list['usuario_codigo']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Ingresos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Egreso_Cierre_Caja() {
        if ($this->session->userdata('usuario')) {
            $id_cierre_caja = $this->input->post("id_cierre_caja");
            $get_id = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
            $dato['list_egreso'] = $this->Model_Laleli->get_list_egreso_cierre_caja($get_id[0]['id_sede'],$get_id[0]['fecha'],$get_id[0]['id_vendedor']);
            $this->load->view('view_LA/cierre_caja/lista_egreso',$dato);
        }else{
            redirect('/login');
        }
    } 

    public function Excel_Egreso_Cierre_Caja($id_cierre_caja){ 
        $get_id = $this->Model_Laleli->get_id_cierre_caja($id_cierre_caja);
        $list_egreso = $this->Model_Laleli->get_list_egreso_cierre_caja($get_id[0]['id_sede'],$get_id[0]['fecha'],$get_id[0]['id_vendedor']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Egresos'); 

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18);

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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Apellido Paterno');	
        $sheet->setCellValue("C1", 'Apellido Materno');	
        $sheet->setCellValue("D1", 'Nombre(s)');	    
        $sheet->setCellValue("E1", 'Producto');
        $sheet->setCellValue("F1", 'Precio'); 
        $sheet->setCellValue("G1", 'Cantidad'); 
        $sheet->setCellValue("H1", 'Total');
        $sheet->setCellValue("I1", 'Recibo Electrónico');
        $sheet->setCellValue("J1", 'Fecha Pago');	
        $sheet->setCellValue("K1", 'Efectuado Por');	         

        $contador=1;
        
        foreach($list_egreso as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['Codigo']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("C{$contador}", $list['Apellido_Materno']); 
            $sheet->setCellValue("D{$contador}", $list['Nombre']); 
            $sheet->setCellValue("E{$contador}", $list['cod_producto']);
            $sheet->setCellValue("F{$contador}", $list['precio']);
            $sheet->setCellValue("G{$contador}", $list['cantidad']);
            $sheet->setCellValue("H{$contador}", $list['total']);
            $sheet->setCellValue("I{$contador}", $list['cod_venta']);
            $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_pago']));
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("K{$contador}", $list['usuario_codigo']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Egresos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------COMPRA-------------------------------------
    public function Compra(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/compra/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Compra() {
        if ($this->session->userdata('usuario')) {
            $dato['list_compra'] = $this->Model_Laleli->get_list_compra();
            $this->load->view('view_LA/compra/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Compra($id_compra){ 
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Laleli->get_list_compra($id_compra);
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $this->load->view('view_LA/compra/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Anio_Defecto_Compra_U(){
        if ($this->session->userdata('usuario')) {
            $fecha_compra = $this->input->post("fecha_compra");
            $dato['nom_anio'] = substr($fecha_compra,0,4); 
            $dato['list_anio'] = $this->Model_Laleli->get_list_anio();
            $dato['id_anio'] = 'id_anio_u';
            $this->load->view('view_LA/compra/anio',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Compra(){
        if ($this->session->userdata('usuario')) {
            $dato['id_compra']= $this->input->post("id_compra");
            $dato['fecha_compra']= $this->input->post("fecha_compra_u");
            $dato['id_anio']= $this->input->post("id_anio_u");
            $dato['precio_compra']= $this->input->post("precio_compra_u"); 
            $dato['gasto_arpay']= $this->input->post("gasto_arpay_u");
            $this->Model_Laleli->update_compra($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Compra(){
        $list_compra = $this->Model_Laleli->get_list_compra();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Compra'); 

        $sheet->setAutoFilter('A1:J1'); 

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Tipo');	
        $sheet->setCellValue("C1", 'Sub-Tipo');	
        $sheet->setCellValue("D1", 'Tipo Producto');	    
        $sheet->setCellValue("E1", 'Talla/Ref');
        $sheet->setCellValue("F1", 'Fecha Compra');
        $sheet->setCellValue("G1", 'Año');
        $sheet->setCellValue("H1", 'Precio Compra');
        $sheet->setCellValue("I1", 'Gasto Arpay');	        
        $sheet->setCellValue("J1", 'Cantidad');  

        $contador=1;
        
        foreach($list_compra as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['codigo']); 
            $sheet->setCellValue("B{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("C{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['talla']);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fec_compra']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", $list['nom_anio']);
            $sheet->setCellValue("H{$contador}", $list['precio_compra']);
            $sheet->setCellValue("I{$contador}", $list['gasto_arpay']);
            $sheet->setCellValue("J{$contador}", $list['cantidad']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Compra (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------STOCK-------------------------------------
    public function Stock(){ 
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/stock/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Stock() {
        if ($this->session->userdata('usuario')) {
            $dato['list_stock'] = $this->Model_Laleli->get_list_stock();
            $this->load->view('view_LA/stock/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Stock(){
        $list_stock = $this->Model_Laleli->get_list_stock();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Compra'); 

        $sheet->setAutoFilter('A1:E1'); 

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Código');	
        $sheet->setCellValue("B1", 'Tipo');	
        $sheet->setCellValue("C1", 'Descripción');	
        $sheet->setCellValue("D1", 'Talla/Ref');	    
        $sheet->setCellValue("E1", 'Stock');

        $contador=1;
        
        foreach($list_stock as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo']); 
            $sheet->setCellValue("B{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("C{$contador}", $list['descripcion']);
            $sheet->setCellValue("D{$contador}", $list['talla']);
            $sheet->setCellValue("E{$contador}", $list['stock_total']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Compra (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------TRANSFERENCIAS-------------------------------------
    public function Informe_Transferencia(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/informe_t/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Informe_Transferencia() {
        if ($this->session->userdata('usuario')) {
            $dato['list_informe_transferencia'] = $this->Model_Laleli->get_list_informe_transferencia();
            $this->load->view('view_LA/informe_t/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Pdf_Informe_Transferencia(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_informe_transferencia'] = $this->Model_Laleli->get_list_informe_transferencia();

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_LA/informe_t/pdf',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Excel_Informe_Transferencia(){
        $list_informe_transferencia = $this->Model_Laleli->get_list_informe_transferencia();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Transferencia'); 

        $sheet->setAutoFilter('A1:F1'); 

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

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

        $sheet->setCellValue("A1", 'De');	
        $sheet->setCellValue("B1", 'Para');	
        $sheet->setCellValue("C1", 'Producto');	
        $sheet->setCellValue("D1", 'Cantidad');	    
        $sheet->setCellValue("E1", 'Fecha');
        $sheet->setCellValue("F1", 'Usuario');

        $contador=1;
        
        foreach($list_informe_transferencia as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['de']); 
            $sheet->setCellValue("B{$contador}", $list['para']);
            $sheet->setCellValue("C{$contador}", $list['cod_producto']);
            $sheet->setCellValue("D{$contador}", $list['cantidad']);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list['usuario']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Transferencia (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------DEVOLUCIÓN-------------------------------------
    public function Devolucion(){
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
            $dato['list_nav_sede'] = $this->Model_Laleli->get_list_nav_sede();
            $dato['encomiendas_pendientes'] = count($this->Model_Laleli->get_encomiendas_pendientes());
            $dato['cierres_caja_pendientes'] = count($this->Model_Laleli->get_cierres_caja_pendientes());
            $dato['cierres_caja_sin_cofre'] = count($this->Model_Laleli->get_cierres_caja_sin_cofre());

            $this->load->view('view_LA/devolucion/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Devolucion() {
        if ($this->session->userdata('usuario')) {
            $dato['list_devolucion'] = $this->Model_Laleli->get_list_devolucion();
            $this->load->view('view_LA/devolucion/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Devolucion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_devolucion']= $this->input->post("id_devolucion");
            $dato['estado']= $this->input->post("estado");
            $this->Model_Laleli->update_devolucion($dato);

            if($dato['estado']==1){
                $get_id = $this->Model_Laleli->get_list_devolucion($dato['id_devolucion']);
                $get_venta = $this->Model_Laleli->get_list_venta($get_id[0]['id_venta']);
                $dato['id_vendedor'] = $get_venta[0]['user_reg'];

                $valida = $this->Model_Laleli->valida_aprobar_devolucion($get_venta[0]['user_reg'],$get_venta[0]['id_sede']);
    
                if($valida[0]['total']<$get_venta[0]['total']){
                    echo "error";
                }else{
                    $dato['id_venta'] = $get_venta[0]['id_venta'];
                    $dato['id_almacen'] = $get_venta[0]['id_almacen'];
                    
                    $list_detalle = $this->Model_Laleli->get_list_venta_detalle($get_venta[0]['id_venta']);
        
                    foreach($list_detalle as $list){
                        $dato['id_producto'] = $list['id_producto'];
                        $dato['cod_producto'] = $list['codigo'];
                        $dato['cantidad'] = $list['cantidad'];
                        $this->Model_Laleli->insert_devolucion_producto($dato);
                    }
        
                    $this->Model_Laleli->anular_venta($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Devolucion(){ 
        $list_devolucion = $this->Model_Laleli->get_list_devolucion();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Devolución'); 

        $sheet->setAutoFilter('A1:E1'); 

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(80);
        $sheet->getColumnDimension('E')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Venta');	
        $sheet->setCellValue("B1", 'Fecha');	
        $sheet->setCellValue("C1", 'Usuario');	
        $sheet->setCellValue("D1", 'Motivo');	    
        $sheet->setCellValue("E1", 'Estado');	    

        $contador=1;
        
        foreach($list_devolucion as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_venta']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list['usuario']);
            $sheet->setCellValue("D{$contador}", $list['motivo']);
            $sheet->setCellValue("E{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Devolución (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}