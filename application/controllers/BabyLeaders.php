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

class BabyLeaders extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_BabyLeaders');
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
            $dato['fondo'] = $this->Model_BabyLeaders->fondo_index();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/administrador/index',$dato);
        }
        else{
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------CLIENTE-------------------------------------
    public function Cliente() {
        if ($this->session->userdata('usuario')) {
            $dato['list_cliente'] = $this->Model_BabyLeaders->get_list_cliente();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/cliente/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cliente(){
        $list_cliente = $this->Model_BabyLeaders->get_list_cliente();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cliente');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(18); 
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(25);

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

        $sheet->setCellValue("A1", 'DNI');             
        $sheet->setCellValue("B1", 'Apellido Paterno');
        $sheet->setCellValue("C1", 'Apellido Materno');
        $sheet->setCellValue("D1", 'Nombre(s)');
        $sheet->setCellValue("E1", 'Teléfono Casa'); 
        $sheet->setCellValue("F1", 'Distrito'); 

        $contador=1;
        
        foreach($list_cliente as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['n_documento']);
            $sheet->setCellValue("B{$contador}", $list['alum_apater']);
            $sheet->setCellValue("C{$contador}", $list['alum_amater']);
            $sheet->setCellValue("D{$contador}", $list['alum_nom']);
            $sheet->setCellValue("E{$contador}", ""); 
            $sheet->setCellValue("F{$contador}", $list['nombre_distrito']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cliente (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------ARTÍCULOS-------------------------------------------
    public function Articulo() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/articulo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Articulo() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo($dato['tipo']);
            $this->load->view('view_BL/articulo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Articulo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $this->load->view('view_BL/articulo/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Articulo(){
        $dato['anio']= $this->input->post("anio_i");
        $dato['nombre']= $this->input->post("nombre_i");
        $dato['referencia']= $this->input->post("referencia_i");
        $dato['id_tipo']= $this->input->post("id_tipo_i");
        $dato['id_publico']= $this->input->post("id_publico_i");  
        $dato['monto']= $this->input->post("monto_i");
        $dato['obligatorio_dia']= $this->input->post("obligatorio_dia_i");
        $dato['desc_referencia']= $this->input->post("desc_referencia_i"); 
        $dato['desc_porcentaje']= $this->input->post("desc_porcentaje_i");
        $dato['desc_monto']= $this->input->post("desc_monto_i");
        $dato['desc_resultado']= $this->input->post("desc_resultado_i");

        $total=count($this->Model_BabyLeaders->valida_insert_articulo($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_articulo($dato);
        }
    }

    public function Modal_Update_Articulo($id_articulo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_articulo($id_articulo);
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/articulo/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Articulo(){
        $dato['id_articulo']= $this->input->post("id_articulo");
        $dato['anio']= $this->input->post("anio_u");
        $dato['nombre']= $this->input->post("nombre_u");
        $dato['referencia']= $this->input->post("referencia_u");
        $dato['id_tipo']= $this->input->post("id_tipo_u");
        $dato['id_publico']= $this->input->post("id_publico_u");  
        $dato['monto']= $this->input->post("monto_u");
        $dato['obligatorio_dia']= $this->input->post("obligatorio_dia_u");
        $dato['desc_referencia']= $this->input->post("desc_referencia_u"); 
        $dato['desc_porcentaje']= $this->input->post("desc_porcentaje_u");
        $dato['desc_monto']= $this->input->post("desc_monto_u");
        $dato['desc_resultado']= $this->input->post("desc_resultado_u");
        $dato['estado']= $this->input->post("estado_u");

        $total=count($this->Model_BabyLeaders->valida_update_articulo($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_articulo($dato);
        }
    }

    public function Delete_Articulo(){
        $dato['id_articulo']= $this->input->post("id_articulo");
        $this->Model_BabyLeaders->delete_articulo($dato);
    }

    public function Excel_Articulo($tipo){
        $list_articulo = $this->Model_BabyLeaders->get_list_articulo($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Artículo');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(26);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Año');             
        $sheet->setCellValue("B1", 'Nombre');
        $sheet->setCellValue("C1", 'Referencia');
        $sheet->setCellValue("D1", 'Tipo');
        $sheet->setCellValue("E1", 'Público'); 
        $sheet->setCellValue("F1", 'Monto'); 
        $sheet->setCellValue("G1", 'Obligatorio estar al día');
        $sheet->setCellValue("H1", 'Referencia');
        $sheet->setCellValue("I1", 'Porcentaje');
        $sheet->setCellValue("J1", 'Monto'); 
        $sheet->setCellValue("K1", 'Descuento'); 
        $sheet->setCellValue("L1", 'Estado');

        $contador=1;
        
        foreach($list_articulo as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("J{$contador}:K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['anio']);
            $sheet->setCellValue("B{$contador}", $list['nombre']);
            $sheet->setCellValue("C{$contador}", $list['referencia']);
            $sheet->setCellValue("D{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("E{$contador}", $list['nom_publico']); 
            $sheet->setCellValue("F{$contador}", $list['monto']);
            $sheet->setCellValue("G{$contador}", $list['obligatorio_dia']);
            $sheet->setCellValue("H{$contador}", $list['desc_referencia']);
            $sheet->setCellValue("I{$contador}", $list['desc_porcentaje']);
            $sheet->setCellValue("J{$contador}", $list['desc_monto']);
            $sheet->setCellValue("K{$contador}", $list['desc_resultado']);
            $sheet->setCellValue("L{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Artículo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------PRODUCTO-------------------------------------------
    public function Producto() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/producto/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Producto() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto($dato['tipo']);
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo_todo();
            $this->load->view('view_BL/producto/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo_combo();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $this->load->view('view_BL/producto/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Producto(){
        $dato['anio']= $this->input->post("anio_i");
        $dato['nombre']= $this->input->post("nombre_i");
        $dato['referencia']= $this->input->post("referencia_i");
        $dato['id_articulo']= implode(",",$this->input->post("id_articulo_i"));
        $dato['id_publico']= $this->input->post("id_publico_i");
        $dato['inicio_pag']= $this->input->post("inicio_pag_i");
        $dato['fin_pag']= $this->input->post("fin_pag_i");
        $dato['id_grado']= $this->input->post("id_grado_i");

        $total=count($this->Model_BabyLeaders->valida_insert_producto($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_producto($dato);
        }
    }

    public function Modal_Update_Producto($id_producto){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_producto($id_producto);
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo_combo();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/producto/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Producto(){
        $dato['id_producto']= $this->input->post("id_producto");
        $dato['anio']= $this->input->post("anio_u");
        $dato['nombre']= $this->input->post("nombre_u");
        $dato['referencia']= $this->input->post("referencia_u");
        $dato['id_articulo']= implode(",",$this->input->post("id_articulo_u"));
        $dato['id_publico']= $this->input->post("id_publico_u");  
        $dato['inicio_pag']= $this->input->post("inicio_pag_u");
        $dato['fin_pag']= $this->input->post("fin_pag_u");
        $dato['id_grado']= $this->input->post("id_grado_u");
        $dato['estado']= $this->input->post("estado_u");

        $total=count($this->Model_BabyLeaders->valida_update_producto($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_producto($dato);
        }
    }

    public function Delete_Producto(){
        $dato['id_producto']= $this->input->post("id_producto");
        $this->Model_BabyLeaders->delete_producto($dato);
    }

    public function Excel_Producto($tipo){
        $list_producto = $this->Model_BabyLeaders->get_list_producto($tipo);
        $list_articulo = $this->Model_BabyLeaders->get_list_articulo_todo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Producto');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(22);
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

        $sheet->setCellValue("A1", 'Grado');  
        $sheet->setCellValue("B1", 'Año');             
        $sheet->setCellValue("C1", 'Nombre');
        $sheet->setCellValue("D1", 'Referencia');
        $sheet->setCellValue("E1", 'Artículo');
        $sheet->setCellValue("F1", 'Público'); 
        $sheet->setCellValue("G1", 'Inicio Pagamento'); 
        $sheet->setCellValue("H1", 'Fin Pagamento');
        $sheet->setCellValue("I1", 'Estado');

        $contador=1;
        
        foreach($list_producto as $list){
            $contador++;

            $array = explode(",",$list['id_articulo']);
            $i = 0;
            $nom_articulo = "";
            while($i<count($array)){
                $busqueda = in_array($array[$i], array_column($list_articulo, 'id_articulo')); 
                if($busqueda!=false){
                    $posicion = array_search($array[$i], array_column($list_articulo, 'id_articulo'));
                    $nom_articulo = $nom_articulo.$list_articulo[$posicion]['nombre'].", ";
                }
                $i++;
            }
            $nom_articulo = substr($nom_articulo,0,-2);

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_grado']);
            $sheet->setCellValue("B{$contador}", $list['anio']);
            $sheet->setCellValue("C{$contador}", $list['nombre']);
            $sheet->setCellValue("D{$contador}", $list['referencia']);
            $sheet->setCellValue("E{$contador}", $nom_articulo);
            $sheet->setCellValue("F{$contador}", $list['nom_publico']); 
            if($list['inicio']==""){
                $sheet->setCellValue("G{$contador}", "");
            }else{
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['inicio']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin']==""){
                $sheet->setCellValue("H{$contador}", "");
            }else{
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fin']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("I{$contador}", $list['nom_status']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Producto (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Producto($id_producto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_producto($id_producto);
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo_todo();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/producto/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //---------------------------------------------PROFESOR-------------------------------------------
    public function Profesor() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/profesor/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Profesor() {
        if ($this->session->userdata('usuario')) {
            $dato['list_profesor'] = $this->Model_BabyLeaders->get_list_profesor();
            $this->load->view('view_BL/profesor/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Profesor(){
        $list_profesor = $this->Model_BabyLeaders->get_list_profesor();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Profesor');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Apellido Paterno');             
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Número de Empleado');
        $sheet->setCellValue("E1", 'DNI'); 
        $sheet->setCellValue("F1", 'Tipo Contrato'); 
        $sheet->setCellValue("G1", 'Fecha Inicio');
        $sheet->setCellValue("H1", 'Fecha Fin');
        $sheet->setCellValue("I1", 'Estado'); 

        $contador=1;
        
        foreach($list_profesor as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("B{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("C{$contador}", $list['FirstName']);
            $sheet->setCellValue("D{$contador}", $list['InternalEmployeeId']);
            $sheet->setCellValue("E{$contador}", $list['IdentityCardNumber']); 
            $sheet->setCellValue("F{$contador}", $list['Description']);
            if($list['StartDate']!=""){
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['StartDate']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("G{$contador}", "");  
            }
            if($list['EndDate']!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['EndDate']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("H{$contador}", "");  
            }
            $sheet->setCellValue("I{$contador}", $list['Estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Profesor (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //------------------------------------------------------MATRICULADOS------------------------------------------
    public function Matriculados() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/matriculados/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $tipo = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_matriculados($tipo);
            $this->load->view('view_BL/matriculados/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matriculados($tipo){
        $list_alumno = $this->Model_BabyLeaders->get_list_matriculados($tipo);
        $sede = 'BL1';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos '.$sede.' (Lista)');
        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);

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

        $sheet->setCellValue("A1", 'Apellido Paterno');	        
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombres');
        $sheet->setCellValue("D1", 'Doc. Ide.');
        $sheet->setCellValue("E1", 'Cumpleaños');
        $sheet->setCellValue("F1", 'Edad (Años)');	
        $sheet->setCellValue("G1", 'Edad (Meses)');	  
        $sheet->setCellValue("H1", 'Código');
        $sheet->setCellValue("I1", 'Grado');
        $sheet->setCellValue("J1", 'Sección');
        $sheet->setCellValue("K1", 'Status');	         
        $sheet->setCellValue("L1", 'Matricula');
        $sheet->setCellValue("M1", 'Usuario');
        $sheet->setCellValue("N1", 'Alumno');	        
        $sheet->setCellValue("O1", 'Año');
        $sheet->setCellValue("P1", 'Documentos');	        
        $sheet->setCellValue("Q1", 'Pagos');

        $contador=1;

        foreach($list_alumno as $list){
            $contador++;

            $fec_de = new DateTime($list['Fecha_Cumpleanos']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); 

            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            
            $sheet->setCellValue("A{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("C{$contador}", $list['Nombres']);
            $sheet->setCellValue("D{$contador}", $list['Documento']);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['Cumpleanos']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $diff->y);
            $sheet->setCellValue("G{$contador}", $diff->m);
            $sheet->setCellValue("H{$contador}", $list['Codigo']);
            $sheet->setCellValue("I{$contador}", $list['Grado']);
            $sheet->setCellValue("J{$contador}", "");
            $sheet->setCellValue("K{$contador}", "");
            $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['Matricula']));
            $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("M{$contador}", $list['Usuario']);
            $sheet->setCellValue("N{$contador}", $list['Alumno']);
            $sheet->setCellValue("O{$contador}", $list['Anio']);
            $sheet->setCellValue("P{$contador}", "");
            $sheet->setCellValue("Q{$contador}", "");
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'Alumnos '.$sede.' (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); 
    }

    public function Pago_Matriculados($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $id_alumno;
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_matriculados($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/matriculados/pagos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Pago_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['estado'] = $this->input->post("estado");
            $dato['list_pago'] = $this->Model_BabyLeaders->get_list_pago_matriculados($dato['id_alumno']);
            $this->load->view('view_BL/matriculados/lista_pagos',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Pago_Matriculados($id_alumno,$estado){
        $list_pago = $this->Model_BabyLeaders->get_list_pago_matriculados($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Pago Alumnos');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Producto');	        
        $sheet->setCellValue("B1", 'Estado');
        $sheet->setCellValue("C1", 'Descripción');	        
        $sheet->setCellValue("D1", 'Fecha VP');
        $sheet->setCellValue("E1", 'Monto');	        
        $sheet->setCellValue("F1", 'Descuento');
        $sheet->setCellValue("G1", 'Penalidad');	        
        $sheet->setCellValue("H1", 'SubTotal');

        $contador=1;

        if($estado==1){
            foreach($list_pago as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
    
                $sheet->setCellValue("A{$contador}", $list['Producto']);
                $sheet->setCellValue("B{$contador}", $list['Estado']);
                $sheet->setCellValue("C{$contador}", $list['Descripcion']);
                if($list['Fecha_VP']!=""){
                    $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['Fecha_VP']));
                    $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }else{
                    $sheet->setCellValue("D{$contador}", "");  
                }
                $sheet->setCellValue("E{$contador}", "s./".number_format($list['Monto'],2));
                $sheet->setCellValue("F{$contador}", "s./".number_format($list['Descuento'],2));
                $sheet->setCellValue("G{$contador}", "s./".number_format($list['Penalidad'],2));
                $sheet->setCellValue("H{$contador}", "s./".number_format($list['SubTotal'],2));
            }
        }else{
            foreach($list_pago as $list){
                if($list['Estado']=="Pendiente"){
                    $contador++;
                    
                    $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        
                    $sheet->setCellValue("A{$contador}", $list['Producto']);
                    $sheet->setCellValue("B{$contador}", $list['Estado']);
                    $sheet->setCellValue("C{$contador}", $list['Descripcion']);
                    if($list['Fecha_VP']!=""){
                        $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['Fecha_VP']));
                        $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    }else{
                        $sheet->setCellValue("D{$contador}", "");  
                    }
                    $sheet->setCellValue("E{$contador}", "s./".number_format($list['Monto'],2));
                    $sheet->setCellValue("F{$contador}", "s./".number_format($list['Descuento'],2));
                    $sheet->setCellValue("G{$contador}", "s./".number_format($list['Penalidad'],2));
                    $sheet->setCellValue("H{$contador}", "s./".number_format($list['SubTotal'],2));
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pago Alumnos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Matriculados($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_matriculados($id_alumno);
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento_matriculados($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/matriculados/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //---------------------------------------------ALUMNOS-------------------------------------------
    public function Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['informe'] = $this->Model_BabyLeaders->get_informe_matriculados(); 

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno() { 
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_alumno($id_alumno=null,$dato['tipo']);
            $this->load->view('view_BL/alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Retiro_Alumno($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_alumno($id_alumno,null);
            $dato['get_retirado'] = $this->Model_BabyLeaders->valida_alumno_retirado($id_alumno);
            $dato['list_motivo'] = $this->Model_BabyLeaders->get_list_motivo();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno/retirar_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Retiro_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']= $this->input->post("id_alumno");
            $dato['fecha_nasiste']= $this->input->post("fecha_nasiste");
            $dato['id_motivo']= $this->input->post("id_motivo");  
            $dato['otro_motivo']= $this->input->post("otro_motivo");
            $dato['fut']= $this->input->post("fut");
            $dato['tkt_boleta']= $this->input->post("tkt_boleta");
            $dato['fecha_fut']= $this->input->post("fecha_fut");
            $dato['pago_pendiente']= $this->input->post("pago_pendiente");
            $dato['monto']= $this->input->post("monto");
            $dato['contacto']= $this->input->post("contacto");
            $dato['fecha_contacto']= $this->input->post("fecha_contacto");
            $dato['hora_contacto']= $this->input->post("hora_contacto");
            $dato['resumen']= $this->input->post("resumen");
            $dato['p_reincorporacion']= $this->input->post("p_reincorporacion");
            $dato['obs_retiro']= $this->input->post("obs_retiro");

            $cant = count($this->Model_BabyLeaders->valida_alumno_retirado($dato['id_alumno']));

            if($cant>0){
                $this->Model_BabyLeaders->update_retiro_alumno($dato);
            }else{
                $this->Model_BabyLeaders->insert_retiro_alumno($dato);

                /*$get_id = $this->Model_BabyLeaders->get_list_alumno($id_alumno,null);

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
                    $mail->setFrom('noreplay@ifv.edu.pe', 'Correo de Retiro'); //desde donde se envia

                    $mail->addAddress($get_id[0]['Email']);
                    
                    $mail->isHTML(true);                                  // Set email format to HTML
            
                    $mail->Subject = 'Correo de Retiro'; 
            
                    $mail->Body = '<FONT SIZE=4>
                                    ¡Hola!<br>
                                    Hemos revisado que tu matricula se encuentra en estado “Retirado”.<br>
                                    Para nosotros todos nuestros alumnos son importantes y deseamos conocer el motivo por la cual te retiras.<br>
                                    Alguien de nuestro equipo se comunicara contigo lo antes posible.<br><br>
                                    Mientras tanto tiene en atención que si tienes alguna deuda con nosotros esta deuda aumentara con las moras correspondientes.<br>
                                    De acuerdo con nuestro reglamento interno tienes que presentar un FUT de retiro. Solo así tu cuenta queda suspensa y no origina mas moras diarias.<br><br>
                                    Por favor agiliza este proceso. Acuérdate que en un futuro si deseas volver o algún documento de nuestra parte tiene 
                                    que cancelar toda tu deuda.
                                    </FONT SIZE>';
            
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
            
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }

                include('application/views/administrador/mensaje/httpPHPAltiria.php');

                $altiriaSMS = new AltiriaSMS();
            
                $altiriaSMS->setDebug(true);
                $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                $altiriaSMS->setPassword('gllg2021');
            
                $sDestination = '51'.$get_id[0]['Celular'];
                $sMessage = '¡Hola! Revisamos que el estado de tu matricula es “Retirado” Por favor revisa el correo enviado y presenta tu FUT. No sigas creando moras.';
                $altiriaSMS->sendSMS($sDestination, $sMessage);*/
            } 
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Obs_Retiro($id_alumno_retirado){ 
        if ($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_alumno_retirado($id_alumno_retirado);
            $this->load->view('view_BL/alumno/modal_obs_retiro', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Obs_Motivo_Retiro(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno_retirado']= $this->input->post("id_alumno_retirado");
            $dato['obs_retiro']= $this->input->post("obs_retiro");
            $this->Model_BabyLeaders->update_obs_motivo_retiro($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Lista_Alumno($tipo){
        $list_alumno = $this->Model_BabyLeaders->get_list_alumno(null,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:V1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:V1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos (Lista)');
        $sheet->setAutoFilter('A1:V1');

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(25); 
        $sheet->getColumnDimension('P')->setWidth(35);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(25);
        $sheet->getColumnDimension('S')->setWidth(25);
        $sheet->getColumnDimension('T')->setWidth(25);
        $sheet->getColumnDimension('U')->setWidth(35);
        $sheet->getColumnDimension('V')->setWidth(20);
        
        $sheet->getStyle('A1:V1')->getFont()->setBold(true);    

        $spreadsheet->getActiveSheet()->getStyle("A1:V1")->getFill()
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

        $sheet->getStyle("A1:V1")->applyFromArray($styleThinBlackBorderOutline); 
  
        $sheet->setCellValue("A1", 'Apellido Paterno');	        
        $sheet->setCellValue("B1", 'Apellido Materno'); 
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Grado');
        $sheet->setCellValue("F1", 'Curso');	
        $sheet->setCellValue("G1", 'Sección');	  
        $sheet->setCellValue("H1", 'Matricula');
        $sheet->setCellValue("I1", 'Alumno');
        $sheet->setCellValue("J1", 'Año');
        $sheet->setCellValue("K1", 'Pagos');
        $sheet->setCellValue("L1", 'Documentos');
        $sheet->setCellValue("M1", 'Ap. Paterno Tutor 1');	  
        $sheet->setCellValue("N1", 'Ap. Materno Tutor 1');
        $sheet->setCellValue("O1", 'Nombre Tutor 1');
        $sheet->setCellValue("P1", 'Correo Tutor 1');
        $sheet->setCellValue("Q1", 'Celular Tutor 1');
        $sheet->setCellValue("R1", 'Ap. Paterno Tutor 2');	  
        $sheet->setCellValue("S1", 'Ap. Materno Tutor 2');
        $sheet->setCellValue("T1", 'Nombre Tutor 2');
        $sheet->setCellValue("U1", 'Correo Tutor 2');
        $sheet->setCellValue("V1", 'Celular Tutor 2');

        $contador=1;

        foreach($list_alumno as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:V{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}:U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:V{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:V{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            
            $sheet->setCellValue("A{$contador}", $list['alum_apater']);
            $sheet->setCellValue("B{$contador}", $list['alum_amater']);
            $sheet->setCellValue("C{$contador}", $list['alum_nom']);
            $sheet->setCellValue("D{$contador}", $list['cod_alum']);
            $sheet->setCellValue("E{$contador}", $list['nom_grado']); 
            $sheet->setCellValue("F{$contador}", $list['nom_curso']); 
            $sheet->setCellValue("G{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("H{$contador}", $list['estado_matricula']);
            $sheet->setCellValue("I{$contador}", $list['estado_alumno']); 
            $sheet->setCellValue("J{$contador}", $list['anio']);
            $sheet->setCellValue("K{$contador}", $list['nom_pago_pendiente']);
            $sheet->setCellValue("L{$contador}", $list['documentos_subidos']."/".$list['documentos_obligatorios']);
            $sheet->setCellValue("M{$contador}", $list['titular1_apater']);
            $sheet->setCellValue("N{$contador}", $list['titular1_amater']);
            $sheet->setCellValue("O{$contador}", $list['titular1_nom']); 
            $sheet->setCellValue("P{$contador}", $list['titular1_correo']);
            $sheet->setCellValue("Q{$contador}", $list['titular1_celular']);
            $sheet->setCellValue("R{$contador}", $list['titular2_apater']);
            $sheet->setCellValue("S{$contador}", $list['titular2_amater']);
            $sheet->setCellValue("T{$contador}", $list['titular2_nom']); 
            $sheet->setCellValue("U{$contador}", $list['titular2_correo']);
            $sheet->setCellValue("V{$contador}", $list['titular2_celular']);
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'Alumnos (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0'); 

		$writer->save('php://output'); 
    }

    public function Modal_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_parentesco'] = $this->Model_BabyLeaders->get_list_parentesco();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_medios'] = $this->Model_BabyLeaders->get_list_medios();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($id_departamento);
            $this->load->view('view_BL/alumno/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($id_provincia);
            $this->load->view('view_BL/alumno/distrito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Prin(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = "titular1_provincia";
            $dato['onchange'] = "Traer_Distrito_Prin();";
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($id_departamento);
            $this->load->view('view_BL/alumno/provincia_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Prin(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['id_distrito'] = "titular1_distrito";
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($id_provincia);
            $this->load->view('view_BL/alumno/distrito_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Secu(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = "titular2_provincia";
            $dato['onchange'] = "Traer_Distrito_Secu();";
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($id_departamento);
            $this->load->view('view_BL/alumno/provincia_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Secu(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['id_distrito'] = "titular2_distrito";
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($id_provincia);
            $this->load->view('view_BL/alumno/distrito_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_combo($id_grado);
            $this->load->view('view_BL/alumno/seccion',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno(){
        $dato['n_documento']= $this->input->post("n_documento");
        $dato['alum_apater']= trim($this->input->post("alum_apater"));
        $dato['alum_amater']= trim($this->input->post("alum_amater"));
        $dato['alum_nom']= trim($this->input->post("alum_nom"));  
        $dato['fecha_nacimiento']= $this->input->post("fecha_nacimiento");
        $dato['direccion']= $this->input->post("direccion");
        $dato['id_departamento']= $this->input->post("id_departamento");
        $dato['id_provincia']= $this->input->post("id_provincia");
        $dato['id_distrito']= $this->input->post("id_distrito");
        $dato['titular1_dni']= $this->input->post("titular1_dni");
        $dato['titular1_parentesco']= $this->input->post("titular1_parentesco");
        $dato['titular1_apater']= $this->input->post("titular1_apater"); 
        $dato['titular1_amater']= $this->input->post("titular1_amater");
        $dato['titular1_nom']= $this->input->post("titular1_nom");
        $dato['titular1_celular']= $this->input->post("titular1_celular"); 
        $dato['titular2_dni']= $this->input->post("titular2_dni");
        $dato['titular2_parentesco']= $this->input->post("titular2_parentesco");
        $dato['titular2_apater']= $this->input->post("titular2_apater"); 
        $dato['titular2_amater']= $this->input->post("titular2_amater");
        $dato['titular2_nom']= $this->input->post("titular2_nom");
        $dato['titular2_celular']= $this->input->post("titular2_celular"); 
        $dato['id_grado']= $this->input->post("id_grado"); 
        $dato['id_seccion']= $this->input->post("id_seccion");
        $dato['tipo']= $this->input->post("tipo");
        $dato['id_medio']= $this->input->post("id_medio"); 

        $total=count($this->Model_BabyLeaders->valida_insert_alumno($dato));

        if($total>0){
            echo "error";
        }else{
            $anio=date('Y'); 
            $query_id = $this->Model_BabyLeaders->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
            $totalRows_t = count($query_id);
    
            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigo="BL1-".$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo="BL1-".$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>98){
                $codigo="BL1-".$aniof.($totalRows_t+1);
            }
            $dato['cod_alum']= $codigo;

            $this->Model_BabyLeaders->insert_alumno($dato);

            //INSERTAR DOCUMENTOS AL ALUMNO
            $get_id = $this->Model_BabyLeaders->ultimo_id_alumno();
            $dato['id_alumno'] = $get_id[0]['id_alumno'];
            $dato['anio'] = date('Y');
            $list_documento = $this->Model_BabyLeaders->get_documentos_asignados($dato['id_grado']);

            if(count($list_documento)>0){
                foreach($list_documento as $list){
                    $dato['id_documento'] = $list['id_documento'];
                    $this->Model_BabyLeaders->insert_documentos_alumno($dato);
                }
            }
        }
    }

    public function Modal_Update_Alumno($id_alumno){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_alumno($id_alumno,$tipo=null);
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_parentesco'] = $this->Model_BabyLeaders->get_list_parentesco();
            $dato['list_provincia_prin'] = $this->Model_BabyLeaders->get_list_provincia($dato['get_id'][0]['titular1_departamento']);
            $dato['list_distrito_prin'] = $this->Model_BabyLeaders->get_list_distrito($dato['get_id'][0]['titular1_provincia']);
            $dato['list_provincia_secu'] = $this->Model_BabyLeaders->get_list_provincia($dato['get_id'][0]['titular2_departamento']);
            $dato['list_distrito_secu'] = $this->Model_BabyLeaders->get_list_distrito($dato['get_id'][0]['titular2_provincia']);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_combo($dato['get_id'][0]['id_grado']);
            $dato['list_medios'] = $this->Model_BabyLeaders->get_list_medios();
            //$dato['list_estado'] = $this->Model_BabyLeaders->get_list_estadoa();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno/editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumno(){ 
        $dato['id_alumno']= $this->input->post("id_alumno");
        $dato['n_documento']= $this->input->post("n_documento");
        $dato['cod_arpay']= $this->input->post("cod_arpay");
        $dato['alum_apater']= trim($this->input->post("alum_apater"));
        $dato['alum_amater']= trim($this->input->post("alum_amater"));
        $dato['alum_nom']= trim($this->input->post("alum_nom"));  
        $dato['fecha_nacimiento']= $this->input->post("fecha_nacimiento");
        $dato['sexo']= $this->input->post("sexo");
        $dato['correo_corporativo']= $this->input->post("correo_corporativo");
        $dato['direccion']= $this->input->post("direccion");
        $dato['id_departamento']= $this->input->post("id_departamento");
        $dato['id_provincia']= $this->input->post("id_provincia");
        $dato['id_distrito']= $this->input->post("id_distrito");
        $dato['titular1_dni']= $this->input->post("titular1_dni");
        $dato['titular1_parentesco']= $this->input->post("titular1_parentesco");
        $dato['titular1_apater']= $this->input->post("titular1_apater"); 
        $dato['titular1_amater']= $this->input->post("titular1_amater");
        $dato['titular1_nom']= $this->input->post("titular1_nom");
        $dato['titular1_direccion']= $this->input->post("titular1_direccion");
        $dato['titular1_departamento']= $this->input->post("titular1_departamento");
        $dato['titular1_provincia']= $this->input->post("titular1_provincia");
        $dato['titular1_distrito']= $this->input->post("titular1_distrito");
        $dato['titular1_celular']= $this->input->post("titular1_celular"); 
        $dato['titular1_telf_casa']= $this->input->post("titular1_telf_casa"); 
        $dato['titular1_correo']= $this->input->post("titular1_correo");  
        $dato['titular1_fecha_nacimiento']= $this->input->post("titular1_fecha_nacimiento"); 
        $dato['titular1_ocupacion']= $this->input->post("titular1_ocupacion"); 
        $dato['titular1_centro_labor']= $this->input->post("titular1_centro_labor"); 
        $dato['titular1_nombre_sunat']= $this->input->post("titular1_nombre_sunat"); 
        $dato['titular1_correo_boleta']= $this->input->post("titular1_correo_boleta"); 
        $dato['titular1_no_mailing']= $this->input->post("titular1_no_mailing"); 
        $dato['titular2_dni']= $this->input->post("titular2_dni");
        $dato['titular2_parentesco']= $this->input->post("titular2_parentesco");
        $dato['titular2_apater']= $this->input->post("titular2_apater"); 
        $dato['titular2_amater']= $this->input->post("titular2_amater");
        $dato['titular2_nom']= $this->input->post("titular2_nom");
        $dato['titular2_direccion']= $this->input->post("titular2_direccion");
        $dato['titular2_departamento']= $this->input->post("titular2_departamento");
        $dato['titular2_provincia']= $this->input->post("titular2_provincia");
        $dato['titular2_distrito']= $this->input->post("titular2_distrito");
        $dato['titular2_celular']= $this->input->post("titular2_celular"); 
        $dato['titular2_telf_casa']= $this->input->post("titular2_telf_casa");
        $dato['titular2_correo']= $this->input->post("titular2_correo"); 
        $dato['titular2_fecha_nacimiento']= $this->input->post("titular2_fecha_nacimiento"); 
        $dato['titular2_ocupacion']= $this->input->post("titular2_ocupacion"); 
        $dato['titular2_centro_labor']= $this->input->post("titular2_centro_labor"); 
        $dato['titular2_nombre_sunat']= $this->input->post("titular2_nombre_sunat"); 
        $dato['titular2_correo_boleta']= $this->input->post("titular2_correo_boleta"); 
        $dato['titular2_no_mailing']= $this->input->post("titular2_no_mailing"); 
        $dato['id_grado']= $this->input->post("id_grado"); 
        $dato['id_seccion']= $this->input->post("id_seccion");
        $dato['tipo']= $this->input->post("tipo");
        $dato['id_medio']= $this->input->post("id_medio"); 
        //$dato['estado_alumno']= $this->input->post("estado_alumno");

        $total=count($this->Model_BabyLeaders->valida_update_alumno($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_alumno($dato);
            /*$total=count($this->Model_BabyLeaders->valida_cod_arpay($dato));

            if($total>0){
                echo "arpay";
            }else{
                $this->Model_BabyLeaders->update_alumno($dato);
            }*/
        }
    }

    public function Delete_Alumno(){
        $dato['id_alumno']= $this->input->post("id_alumno");
        $this->Model_BabyLeaders->delete_alumno($dato);
    }

    public function Excel_Alumno(){
        $tipo=1;
        $list_alumno = $this->Model_BabyLeaders->get_list_alumno($id_alumno=null,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumno');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(25);
        $sheet->getColumnDimension('Q')->setWidth(25);
        $sheet->getColumnDimension('R')->setWidth(50);

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

        $sheet->setCellValue("A1", 'Foto');
        $sheet->setCellValue("B1", 'Código Snappy');
        $sheet->setCellValue("C1", 'Código Arpay');
        $sheet->setCellValue("D1", 'DNI'); 
        $sheet->setCellValue("E1", 'Apellido Paterno');
        $sheet->setCellValue("F1", 'Apellido Materno');
        $sheet->setCellValue("G1", 'Nombre(s)'); 
        $sheet->setCellValue("H1", 'Fecha Nacimiento');
        $sheet->setCellValue("I1", 'Edad');
        $sheet->setCellValue("J1", 'Sexo'); 
        $sheet->setCellValue("K1", 'Dirección');
        $sheet->setCellValue("L1", 'Departamento'); 
        $sheet->setCellValue("M1", 'Provincia'); 
        $sheet->setCellValue("N1", 'Distrito');
        $sheet->setCellValue("O1", 'Grado'); 
        $sheet->setCellValue("P1", 'Sección'); 
        $sheet->setCellValue("Q1", 'Estado');
        $sheet->setCellValue("R1", 'Link Foto');	            

        $contador=1;
        
        foreach($list_alumno as $list){ 
            $contador++;

            $fec_de = new DateTime($list['fecha_nacimiento']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta);

            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("R{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("R{$contador}")->getFont()->setUnderline(true);  

            $sheet->setCellValue("A{$contador}", $list['foto']);
            $sheet->setCellValue("B{$contador}", $list['cod_alum']);
            $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
            $sheet->setCellValue("D{$contador}", $list['n_documento']);
            $sheet->setCellValue("E{$contador}", $list['alum_apater']);
            $sheet->setCellValue("F{$contador}", $list['alum_amater']);
            $sheet->setCellValue("G{$contador}", $list['alum_nom']); 
            if($list['fecha_nacimiento']!="0000-00-00"){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fecha_nacimiento']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("H{$contador}", "");  
            }
            $sheet->setCellValue("I{$contador}", $diff->y);
            $sheet->setCellValue("J{$contador}", $list['nom_sexo']);
            $sheet->setCellValue("K{$contador}", $list['direccion']);
            $sheet->setCellValue("L{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("M{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("N{$contador}", $list['nombre_distrito']);
            $sheet->setCellValue("O{$contador}", $list['nom_grado']);
            $sheet->setCellValue("P{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("Q{$contador}", $list['nom_estadoa']);
            if($list['link_foto']!=""){
                $sheet->setCellValue("R{$contador}", base_url().$list['link_foto']);
                $sheet->getCell("R{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
            }else{
                $sheet->setCellValue("R{$contador}", "");
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Alumno (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_alumno($id_alumno,$tipo=null);
            $dato['get_foto'] = $this->Model_BabyLeaders->get_list_foto_matriculados($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Datos_Cambiantes_Alumno() { 
        if ($this->session->userdata('usuario')) { 
            $id_alumno = $this->input->post("id_alumno");
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_alumno($id_alumno,$tipo=null);
            $this->load->view('view_BL/alumno/datos_cambiantes',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_matricula'] = $this->Model_BabyLeaders->get_list_matricula_alumno($dato['id_alumno']);
            $dato['list_articulo'] = $this->Model_BabyLeaders->get_list_articulo_combo();
            $this->load->view('view_BL/alumno/lista_matricula',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Matricula_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno'] = $id_alumno;
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $this->load->view('view_BL/alumno/modal_registrar_matricula', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Producto_Alumno_i(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['id_producto'] = "id_producto_i";
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto_combo($id_grado);
            $this->load->view('view_BL/alumno/producto', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Matricula_Alumno(){
        $dato['id_alumno']= $this->input->post("id_alumno");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['id_producto'] = $this->input->post("id_producto_i");
        $dato['fec_matricula']= $this->input->post("fec_matricula_i");
        $dato['compra']= $this->input->post("compra_i");
        $dato['observaciones'] = $this->input->post("observaciones_i");

        if($dato['compra']==1){
            $this->Model_BabyLeaders->insert_matricula_alumno_detalle($dato);

            $get_matricula = $this->Model_BabyLeaders->ultimo_id_matricula(); 
            $dato['id_matricula'] = $get_matricula[0]['id_matricula']; 

            $articulo = explode(",",$get_matricula[0]['id_articulo']);

            $i = 0;
            while($i<count($articulo)){
                $get_articulo = $this->Model_BabyLeaders->get_id_articulo($articulo[$i]);

                $dato['orden'] = 13;
                $dato['nom_pago'] = $get_articulo[0]['nombre'];
                $dato['monto'] = $get_articulo[0]['monto'];
                $dato['fec_vencimiento'] = "";
                $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
                
                $i++;
            }
        }else{
            $validar = $this->Model_BabyLeaders->valida_insert_matricula_alumno($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->insert_matricula_alumno_detalle($dato);
    
                $get_matricula = $this->Model_BabyLeaders->ultimo_id_matricula(); 
                $dato['id_matricula'] = $get_matricula[0]['id_matricula']; 
    
                $articulo = explode(",",$get_matricula[0]['id_articulo']);
    
                $i = 0;
                while($i<count($articulo)){
                    $get_articulo = $this->Model_BabyLeaders->get_id_articulo($articulo[$i]);
    
                    if($get_articulo[0]['id_tipo']==2){
                        $list_mes = $this->Model_BabyLeaders->get_list_mes_matricula($get_matricula[0]['fec_matricula']);
    
                        foreach($list_mes as $list){
                            $dato['orden'] = $list['id_mes'];
                            $dato['nom_pago'] = "Pensión ".$list['nom_mes']." ".$get_articulo[0]['anio'];
                            $dato['monto'] = $get_articulo[0]['monto'];
                            $dato['fec_vencimiento'] = substr($get_matricula[0]['fec_matricula'],0,4)."-".$list['cod_mes']."-05";
                            $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
                        }
                    }else{
                        $dato['orden'] = 0;
                        $dato['nom_pago'] = $get_articulo[0]['nombre'];
                        $dato['monto'] = $get_articulo[0]['monto'];
                        $dato['fec_vencimiento'] = "";
                        $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
                    }
    
                    $i++;
                }
            }
        }
    }

    public function Modal_Update_Matricula_Alumno($id_matricula){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_matricula_alumno($id_matricula);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto_combo($dato['get_id'][0]['id_grado']);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado_matricula();
            $this->load->view('view_BL/alumno/modal_editar_matricula', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Producto_Alumno_U(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['id_producto'] = "id_producto_u";
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto_combo($id_grado);
            $this->load->view('view_BL/alumno/producto', $dato); 
        } else {
            redirect('');
        }
    }

    public function Update_Matricula_Alumno(){   
        $dato['id_matricula']= $this->input->post("id_matricula");
        $dato['id_alumno']= $this->input->post("id_alumno");
        $dato['id_grado']= $this->input->post("id_grado_u");
        $dato['id_producto'] = $this->input->post("id_producto_u"); 
        $dato['fec_matricula']= $this->input->post("fec_matricula_u");
        $dato['fin_matricula']= $this->input->post("fin_matricula_u");
        $dato['estado_matricula']= $this->input->post("estado_matricula_u");
        $dato['observaciones'] = $this->input->post("observaciones_u");
        $dato['compra'] = $this->input->post("compra_u");

        if($dato['compra']==1){
            $this->Model_BabyLeaders->update_matricula_alumno_detalle($dato);
        }else{
            $validar = $this->Model_BabyLeaders->valida_update_matricula_alumno($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                if($dato['estado_matricula']==9){
                    $this->Model_BabyLeaders->update_pago_alumno_retirado($dato);
                }
    
                $this->Model_BabyLeaders->update_matricula_alumno_detalle($dato);
            }
        }
    }

    public function Delete_Matricula_Alumno(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_matricula'] = $this->input->post("id_matricula");
            $this->Model_BabyLeaders->delete_matricula_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Matricula_Alumno($id_alumno){
        $list_matricula = $this->Model_BabyLeaders->get_list_matricula_alumno($id_alumno);
        $list_articulo = $this->Model_BabyLeaders->get_list_articulo_combo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Matrículas');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(80);

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
          
        $sheet->setCellValue("A1", 'Producto');
        $sheet->setCellValue("B1", 'Artículo');
        $sheet->setCellValue("C1", 'Año');
        $sheet->setCellValue("D1", 'Curso');
        $sheet->setCellValue("E1", 'Estado');
        $sheet->setCellValue("F1", 'Inicio Clases');
        $sheet->setCellValue("G1", 'Fin Clases');
        $sheet->setCellValue("H1", 'Usuario');
        $sheet->setCellValue("I1", 'Fecha');
        $sheet->setCellValue("J1", 'Observaciones');

        $contador=1;
        
        foreach($list_matricula as $list){
            $contador++;

            $array = explode(",",$list['id_articulo']);
            $i = 0;
            $nom_articulo = "";
            while($i<count($array)){
                $busqueda = in_array($array[$i], array_column($list_articulo, 'id_articulo')); 
                if($busqueda!=false){
                    $posicion = array_search($array[$i], array_column($list_articulo, 'id_articulo'));
                    $nom_articulo = $nom_articulo.$list_articulo[$posicion]['nombre'].",";
                }
                $i++;
            }
            $nom_articulo = substr($nom_articulo,0,-1);

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_producto']);
            $sheet->setCellValue("B{$contador}", $nom_articulo);
            $sheet->setCellValue("C{$contador}", $list['anio']);
            $sheet->setCellValue("D{$contador}", $list['nom_curso']);
            $sheet->setCellValue("E{$contador}", $list['nom_estado']);
            if($list['fecha_matricula']!=""){
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fecha_matricula']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("F{$contador}", "");  
            }
            if($list['fin_matricula']!=""){
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fin_matricula']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("G{$contador}", "");  
            }
            $sheet->setCellValue("H{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("J{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Matrículas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Pago_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $id_alumno = $this->input->post("id_alumno");
            $dato['list_matricula'] = $this->Model_BabyLeaders->get_list_matricula_alumno($id_alumno);
            $dato['list_pago_matricula'] = $this->Model_BabyLeaders->get_list_pago_matricula_alumno($id_alumno);
            $this->load->view('view_BL/alumno/lista_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Pago($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_pago($id_pago);
            $dato['list_estadop'] = $this->Model_BabyLeaders->get_list_estadop();
            $this->load->view('view_BL/alumno/modal_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Pago(){  
        if ($this->session->userdata('usuario')) {
            $dato['id_pago']=$this->input->post("id_pago");
            $dato['monto']=$this->input->post("monto");
            $dato['descuento']=$this->input->post("descuento");
            $dato['fec_vencimiento']=$this->input->post("fec_vencimiento");
            $dato['fec_pago']=$this->input->post("fec_pago");
            $dato['estado_pago']=$this->input->post("estado_pago");
            $dato['id_tipo_pago']=$this->input->post("id_tipo_pago");
            $dato['operacion']=$this->input->post("operacion");
            $dato['tipo_boleta']=$this->input->post("tipo_boleta");
            if($dato['fec_pago']!=""){
                $dato['fec_pago'] = $dato['fec_pago']." ".date('H:i:s');
            }

            $valida_cierre_caja = $this->Model_BabyLeaders->valida_cierre_caja();

            if(count($valida_cierre_caja)>0 && $dato['id_tipo_pago']==1 && $dato['estado_pago']==2){
                echo "cierre_caja";
                exit();
            }else{
                $dato['hacer_operaciones'] = $this->input->post("hacer_operaciones");

                if($dato['hacer_operaciones']==1 && $dato['estado_pago']==2){ 
                    if($dato['tipo_boleta']==0){
                        //RECIBO ELECTRÓNICO
                        $dato['tipo'] = 1;

                        $cantidad = count($this->Model_BabyLeaders->contar_recibos_cancelados());

                        if($cantidad<9){
                            $codigo = "BL000".($cantidad+1);
                        }
                        if($cantidad>8 && $cantidad<99){
                            $codigo = "BL00".($cantidad+1);
                        }
                        if($cantidad>98 && $cantidad<999){
                            $codigo = "BL0".($cantidad+1);
                        }
                        if($cantidad>998 && $cantidad<9999){
                            $codigo = "BL".($cantidad+1);
                        }
                        $dato['cod_documento']= $codigo; 
                        $dato['xml'] = "";
                        $dato['cdrZip'] = "";
                        $dato['id'] = "";
                        $dato['code'] = "";
                        $dato['description'] = "";
                        $dato['documento'] = "";
                        $dato['web'] = 0;

                        $this->Model_BabyLeaders->insert_documento_pago($dato);
                    }

                    if($dato['tipo_boleta']==1){
                        $get_apoderado = $this->Model_BabyLeaders->valida_apoderado($dato['id_pago']);

                        if($get_apoderado[0]['titular1_nombre_sunat']==1 || $get_apoderado[0]['titular2_nombre_sunat']==1){
                            //BOLETA CON SUNAT
                            $dato['tipo'] = 2;

                            $get_id = $this->Model_BabyLeaders->get_id_pago($dato['id_pago']);
        
                            //$dato['fec_emision'] = $this->input->post("fec_pago");
                            $dato['fec_emision'] = date('Y-m-d');
                    
                            $modelonumero = new modelonumero();
                            $numeroaletras = new numeroaletras();
                
                            $cantidad = count($this->Model_BabyLeaders->contar_boletas_canceladas());
                            $serie = 'BA02';
                    
                            if($cantidad<9){
                                $codigo=$serie.'-'."0000000".($cantidad+1);
                                $correlativo="0000000".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>8 && $cantidad<99){
                                $codigo=$serie.'-'."000000".($cantidad+1);
                                $correlativo="000000".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>98 && $cantidad<999){
                                $codigo=$serie.'-'."00000".($cantidad+1);
                                $correlativo="00000".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>998 && $cantidad<9999){
                                $codigo=$serie.'-'."0000".($cantidad+1);
                                $correlativo="0000".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>9998 && $cantidad<99999){
                                $codigo=$serie.'-'."000".($cantidad+1);
                                $correlativo="000".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>99998 && $cantidad<999999){
                                $codigo=$serie.'-'."00".($cantidad+1);
                                $correlativo="00".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>999998 && $cantidad<9999999){
                                $codigo=$serie.'-'."0".($cantidad+1);
                                $correlativo="0".($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            if($cantidad>9999998 && $cantidad<99999999){
                                $codigo=$serie.'-'($cantidad+1);
                                $correlativo=($cantidad+1);
                                $dato['numero']=$cantidad+1;
                            }
                            $dato['cod_documento']= $codigo;
                
                            $fecha=$dato['fec_emision']."T"."00:00:00-05:00";
                            $dato['fechaEmision']=$fecha;
                
                            $dato['get_contabilidad'] = $this->Model_BabyLeaders->get_list_contabilidad(1);
                            $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;
                
                            $dato['tipo_api'] = 2;
                            $dato['tipo_doc'] = 1;
                            $api = $this->Model_BabyLeaders->get_list_api_maestra($dato);
                
                            if(count($api)>0){
                                $mtoOperGravadas = $dato['monto']-$dato['descuento'];
                                $mtoIGV=round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2);
                                $subTotal=$mtoIGV+$mtoOperGravadas;
                                $total_texto=$modelonumero->numtoletras(abs($subTotal),'Soles','centimos');
                
                                $curl = curl_init();
        
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => $api[0]['url'].$api[0]['documento'],
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS =>'{
                                    "ublVersion": "2.1",
                                    "tipoOperacion": "0101",
                                    "tipoDoc": "03",
                                    "serie": "'.$serie.'",
                                    "correlativo": "'.$correlativo.'",
                                    "fechaEmision": "'.$dato['fechaEmision'].'",
                                    "formaPago": {
                                        "moneda": "PEN",
                                        "tipo": "Contado"
                                    },
                                    "tipoMoneda": "PEN",
                                    "client": {
                                        "tipoDoc": "1",
                                        "numDoc": "'.$get_id[0]['dni_apoderado'].'",
                                        "rznSocial": "'.$get_id[0]['nom_apoderado'].'",
                                        "address": {
                                        "direccion": "",
                                        "provincia": "",
                                        "departamento": "",
                                        "distrito": "",
                                        "ubigueo": ""
                                        }
                                    },
                                    "company": {
                                        "ruc": 20600585313,
                                        "razonSocial": "BL JESUS MARIA S.A.C.",
                                        "nombreComercial": "BL JESUS MARIA S.A.C.",
                                        "address": {
                                        "direccion": "CAL.GRAL JOSE CANTERAC NRO. 266 URB. FUNDO OYAGUE LIMA - LIMA - JESUS MARIA",
                                        "provincia": "",
                                        "departamento": "",
                                        "distrito": "",
                                        "ubigueo": ""
                                        }
                                    },
                                    "mtoOperGravadas": '.$mtoOperGravadas.',
                                    "mtoIGV": '.$mtoIGV.',
                                    "valorVenta": '.$mtoOperGravadas.',
                                    "totalImpuestos": '.$mtoIGV.',
                                    "subTotal": '.$subTotal.',
                                    "mtoImpVenta": '.$subTotal.',
                                    "details": [
                                        {
                                            "codProducto"'.':"P001",
                                            "unidad"'.': "NIU",
                                            "descripcion"'.':"'.$get_id[0]['nom_pago'].'",
                                            "cantidad"'.': 1,
                                            "mtoValorUnitario"'.': '.$mtoOperGravadas.',
                                            "mtoValorVenta"'.': '.round($mtoOperGravadas,2).',
                                            "mtoBaseIgv"'.': '.round($mtoOperGravadas,2).',
                                            "porcentajeIgv"'.': '.$dato['porcentajeIgv'].',
                                            "igv"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                                            "tipAfeIgv"'.': 10,
                                            "totalImpuestos"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                                            "mtoPrecioUnitario"'.': '.round((round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2)+$mtoOperGravadas),2).'
                                        }
                                    ],
                                    "legends": [
                                        {
                                        "code": "1000",
                                        "value": "'.$total_texto.'"
                                        }
                                    ]
                                    }',
                                    CURLOPT_HTTPHEADER => array(
                                        'Authorization: Bearer '.$api[0]['token'],
                                        'Content-Type: application/json'
                                    ),
                                ));
                
                                $response = curl_exec($curl);
                                curl_close($curl);
                                $valida = json_decode($response,true);
                
                                if(!empty($valida['error'])==true){
                                    echo "1".$valida['error'];
                                    exit();
                                }else{ 
                                    $decodedData = json_decode($response, true);
                                    if($decodedData['sunatResponse']['success']==true){
                                        $dato['xml'] = $response;
                                        $dato['cdrZip'] = $decodedData['sunatResponse']['cdrZip'];
                                        $dato['id'] = $decodedData['sunatResponse']['cdrResponse']['id'];
                                        $dato['code'] = $decodedData['sunatResponse']['cdrResponse']['code'];
                                        $dato['description'] = $decodedData['sunatResponse']['cdrResponse']['description'];
                                        $dato['documento'] = "";
                                        $dato['web'] = 0;
                
                                        $this->Model_BabyLeaders->insert_documento_pago($dato);

                                        //RECIBO ELECTRÓNICO
                                        $dato['tipo'] = 1;
            
                                        $cantidad = count($this->Model_BabyLeaders->contar_recibos_cancelados());
                    
                                        if($cantidad<9){
                                            $codigo = "BL000".($cantidad+1);
                                        }
                                        if($cantidad>8 && $cantidad<99){
                                            $codigo = "BL00".($cantidad+1);
                                        }
                                        if($cantidad>98 && $cantidad<999){
                                            $codigo = "BL0".($cantidad+1);
                                        }
                                        if($cantidad>998 && $cantidad<9999){
                                            $codigo = "BL".($cantidad+1);
                                        }
                                        $dato['cod_documento']= $codigo;
                                        $dato['xml'] = "";
                                        $dato['cdrZip'] = "";
                                        $dato['id'] = "";
                                        $dato['code'] = "";
                                        $dato['description'] = "";
                                        $dato['documento'] = "";
                                        $dato['web'] = 0;
                    
                                        $this->Model_BabyLeaders->insert_documento_pago($dato);
                                    }else{
                                        $separada = explode("|", $decodedData['sunatResponse']['error']['message']);
                                        if(isset($separada[1])){
                                            $separada2 = explode("-", substr($separada[1], 13));
                                            echo "1".$separada2[0]; 
                                            exit();
                                        }else{
                                            echo "1".$decodedData['sunatResponse']['error']['message'];  
                                            exit();
                                        }
                                    }
                                }
                            }else{
                                echo "1No se encontró API disponible";
                                exit();
                            }

                            //NOTA DE DÉBITO CON SUNAT
                            /*$dato['fecha_vencimiento']=$this->input->post("fec_vencimiento");
                            $dato['fecha_pago']=$this->input->post("fec_pago");
                            $validacion = $this->Model_BabyLeaders->valida_nota_debito($dato);
        
                            if($validacion[0]['dias']>0){
                                $dato['tipo'] = 3;
        
                                $dato['numDocfectado'] = $dato['cod_documento'];
                    
                                $modelonumero = new modelonumero();
                                $numeroaletras = new numeroaletras();
                    
                                $cantidad = count($this->Model_BabyLeaders->contar_notas_debito_canceladas());
                                $serie='BA02';
                        
                                if($cantidad<9){
                                    $codigo=$serie.'-'."0000000".($cantidad+1);
                                    $correlativo="0000000".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>8 && $cantidad<99){
                                    $codigo=$serie.'-'."000000".($cantidad+1);
                                    $correlativo="000000".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>98 && $cantidad<999){
                                    $codigo=$serie.'-'."00000".($cantidad+1);
                                    $correlativo="00000".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>998 && $cantidad<9999){
                                    $codigo=$serie.'-'."0000".($cantidad+1);
                                    $correlativo="0000".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>9998 && $cantidad<99999){
                                    $codigo=$serie.'-'."000".($cantidad+1);
                                    $correlativo="000".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>99998 && $cantidad<999999){
                                    $codigo=$serie.'-'."00".($cantidad+1);
                                    $correlativo="00".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>999998 && $cantidad<9999999){
                                    $codigo=$serie.'-'."0".($cantidad+1);
                                    $correlativo="0".($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                if($cantidad>9999998 && $cantidad<99999999){
                                    $codigo=$serie.'-'($cantidad+1);
                                    $correlativo=($cantidad+1);
                                    $dato['numero']=$cantidad+1;
                                }
                                $dato['cod_documento']= $codigo;
        
                                $dato['get_contabilidad'] = $this->Model_BabyLeaders->get_list_contabilidad(1);
                                $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;
        
                                $dato['tipo_api'] = 3;
                                $dato['tipo_doc'] = 1;
                                $api = $this->Model_BabyLeaders->get_list_api_maestra($dato);
        
                                if(count($api)>0){
                                    $mtoOperGravadas = $validacion[0]['dias'];
                                    $mtoIGV=round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2);
                                    $subTotal=$mtoIGV+$mtoOperGravadas;
                                    $total_texto=$modelonumero->numtoletras(abs($subTotal),'Soles','centimos');
        
                                    $curl = curl_init();
        
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => $api[0]['url'].$api[0]['documento'],
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS =>'{
                                        "ublVersion": "2.1",
                                        "tipDocAfectado": "03",
                                        "numDocfectado": "'.$dato['numDocfectado'].'",
                                        "codMotivo": "02",
                                        "desMotivo": "AUMENTO EN EL VALOR",
                                        "tipoDoc": "08",
                                        "serie": "'.$serie.'",
                                        "fechaEmision": "'.$dato['fechaEmision'].'",
                                        "correlativo": "'.$correlativo.'",
                                        "tipoMoneda": "PEN",
                                        "client": {
                                            "tipoDoc": "1",
                                            "numDoc": "'.$get_id[0]['dni_apoderado'].'",
                                            "rznSocial": "'.$get_id[0]['nom_apoderado'].'",
                                            "address": {
                                            "direccion": "",
                                            "provincia": "",
                                            "departamento": "",
                                            "distrito": "",
                                            "ubigueo": ""
                                            }
                                        },
                                        "company": {
                                            "ruc": 20600585313,
                                            "razonSocial": "BL JESUS MARIA S.A.C.",
                                            "nombreComercial": "BL JESUS MARIA S.A.C.",
                                            "address": {
                                            "direccion": "CAL.GRAL JOSE CANTERAC NRO. 266 URB. FUNDO OYAGUE LIMA - LIMA - JESUS MARIA",
                                            "provincia": "",
                                            "departamento": "",
                                            "distrito": "",
                                            "ubigueo": ""
                                            }
                                        },
                                        "mtoOperGravadas": '.$mtoOperGravadas.',
                                        "mtoIGV": '.$mtoIGV.',
                                        "totalImpuestos": '.$mtoIGV.',
                                        "mtoImpVenta": '.$subTotal.',
                                        "details": [
                                            {
                                            "codProducto": "C023",
                                            "unidad": "NIU",
                                            "cantidad": 1,
                                            "descripcion"'.':"'.$get_id[0]['nom_pago'].'",
                                            "mtoBaseIgv"'.': '.round($mtoOperGravadas,2).',
                                            "porcentajeIgv"'.': '.$dato['porcentajeIgv'].',
                                            "igv"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                                            "tipAfeIgv": 10,
                                            "totalImpuestos"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                                            "mtoValorVenta": '.round($mtoOperGravadas,2).',
                                            "mtoValorUnitario": '.round($mtoOperGravadas,2).',
                                            "mtoPrecioUnitario"'.': '.round((round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2)+$mtoOperGravadas),2).'
                                            }
                                        ],
                                        "legends": [
                                            {
                                            "code": "1000",
                                            "value": "'.$total_texto.'"
                                            }
                                        ]
                                        }',
                                        CURLOPT_HTTPHEADER => array(
                                            'Authorization: Bearer '.$api[0]['token'],
                                            'Content-Type: application/json'
                                        ),
                                    ));
        
                                    $response = curl_exec($curl);
                                    curl_close($curl);
                                    $valida = json_decode($response,true);
                    
                                    if(!empty($valida['error'])==true){
                                        echo "1".$valida['error'];
                                        exit();
                                    }else{ 
                                        $decodedData = json_decode($response, true);
                                        if($decodedData['sunatResponse']['success']==true){
                                            $dato['xml'] = $response;
                                            $dato['cdrZip'] = $decodedData['sunatResponse']['cdrZip'];
                                            $dato['id'] = $decodedData['sunatResponse']['cdrResponse']['id'];
                                            $dato['code'] = $decodedData['sunatResponse']['cdrResponse']['code'];
                                            $dato['description'] = $decodedData['sunatResponse']['cdrResponse']['description'];
                                            $dato['documento'] = "";
                                            $dato['web'] = 0;
                    
                                            $this->Model_BabyLeaders->insert_documento_pago($dato);
                                            $dato['penalidad'] = $validacion[0]['dias'];
                                            $this->Model_BabyLeaders->update_pago_penalidad($dato);
                                        }else{
                                            $separada = explode("|", $decodedData['sunatResponse']['error']['message']);
                                            if(isset($separada[1])){
                                                $separada2 = explode("-", substr($separada[1], 13));
                                                echo "1".$separada2[0]; 
                                                exit();
                                            }else{
                                                echo "1".$decodedData['sunatResponse']['error']['message'];  
                                                exit();
                                            }
                                        }
                                    }
                                }else{
                                    echo "1No se encontró API disponible";
                                    exit();
                                }
                            }*/
                        }else{
                            echo "apoderado";
                            exit();
                        }
                    }

                    if($dato['tipo_boleta']==2){
                        //RECIBO ELECTRÓNICO
                        $dato['tipo'] = 1;

                        $cantidad = count($this->Model_BabyLeaders->contar_recibos_cancelados());

                        if($cantidad<9){
                            $codigo = "BL000".($cantidad+1);
                        }
                        if($cantidad>8 && $cantidad<99){
                            $codigo = "BL00".($cantidad+1);
                        }
                        if($cantidad>98 && $cantidad<999){
                            $codigo = "BL0".($cantidad+1);
                        }
                        if($cantidad>998 && $cantidad<9999){
                            $codigo = "BL".($cantidad+1);
                        }
                        $dato['cod_documento']= $codigo;
                        $dato['xml'] = "";
                        $dato['cdrZip'] = "";
                        $dato['id'] = "";
                        $dato['code'] = "";
                        $dato['description'] = "";
                        $dato['documento'] = "";
                        $dato['web'] = 0;

                        $this->Model_BabyLeaders->insert_documento_pago($dato);

                        //BOLETA SIN SUNAT
                        $dato['tipo'] = 2;
                        $dato['cod_documento'] = "";
                        $dato['xml'] = "";
                        $dato['cdrZip'] = "";
                        $dato['id'] = "";
                        $dato['code'] = "";
                        $dato['description'] = "";
                        $dato['documento'] = "";
                        $dato['web'] = 1;

                        if($_FILES["documento_boleta"]["name"] != ""){
                            if (file_exists($dato['documento'])) { 
                                unlink($dato['documento']);
                            }
                            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_boleta"]["name"]);
                            $config['upload_path'] = './documento_boleta_bl/'.$dato['id_pago'];
                            if (!file_exists($config['upload_path'])) {
                                mkdir($config['upload_path'], 0777, true);
                                chmod($config['upload_path'], 0777);
                                chmod('./documento_boleta_bl/', 0777);
                                chmod('./documento_boleta_bl/'.$dato['id_pago'], 0777);
                            }
                            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            $_FILES["file"]["name"] =  $dato['nom_documento'];
                            $_FILES["file"]["type"] = $_FILES["documento_boleta"]["type"];
                            $_FILES["file"]["tmp_name"] = $_FILES["documento_boleta"]["tmp_name"];
                            $_FILES["file"]["error"] = $_FILES["documento_boleta"]["error"];
                            $_FILES["file"]["size"] = $_FILES["documento_boleta"]["size"];
                            if($this->upload->do_upload('file')){
                                $data = $this->upload->data();
                                $dato['documento'] = "documento_boleta_bl/".$dato['id_pago']."/".$dato['nom_documento'];
                            }     
                        }

                        $this->Model_BabyLeaders->insert_documento_pago($dato);
                    } 
                }

                $this->Model_BabyLeaders->update_pago($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Boleta_Web($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_boleta_web($id_pago);
            $this->load->view('view_BL/alumno/modal_boleta',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Boleta_Web(){  
        $dato['id_documento']=$this->input->post("id_documento");
        $dato['id_pago']=$this->input->post("id_pago");
        $dato['documento'] = $this->input->post("documento_actual");

        if($_FILES["documento_boleta_u"]["name"] != ""){
            if (file_exists($dato['documento'])) { 
                unlink($dato['documento']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_boleta_u"]["name"]);
            $config['upload_path'] = './documento_boleta_bl/'.$dato['id_pago'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_boleta_bl/', 0777);
                chmod('./documento_boleta_bl/'.$dato['id_pago'], 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["documento_boleta_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["documento_boleta_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["documento_boleta_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["documento_boleta_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['documento'] = "documento_boleta_bl/".$dato['id_pago']."/".$dato['nom_documento'];
            }     
        } 
        $this->Model_BabyLeaders->update_documento_pago($dato);
    }

    public function Descargar_Boleta_Web($id_documento) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_id_documento_pago_alumno($id_documento);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }else{
            redirect('');
        }
    }

    public function Devolucion_Pago_Alumno(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $get_apoderado = $this->Model_BabyLeaders->valida_apoderado($dato['id_pago']);

        if($get_apoderado[0]['titular1_nombre_sunat']==1 || $get_apoderado[0]['titular2_nombre_sunat']==1){
            $get_id = $this->Model_BabyLeaders->get_id_pago($dato['id_pago']);

            $dato['fechaEmision'] = date('Y-m-d')."T"."00:00:00-05:00";

            $dato['tipo'] = 4;
    
            $dato['numDocfectado'] = $get_id[0]['cod_boleta'];
    
            $modelonumero = new modelonumero();
            $numeroaletras = new numeroaletras();
    
            $cantidad = count($this->Model_BabyLeaders->contar_notas_credito_canceladas());
            $serie='BA02';
    
            if($cantidad<9){
                $codigo=$serie.'-'."0000000".($cantidad+1);
                $correlativo="0000000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>8 && $cantidad<99){
                $codigo=$serie.'-'."000000".($cantidad+1);
                $correlativo="000000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>98 && $cantidad<999){
                $codigo=$serie.'-'."00000".($cantidad+1);
                $correlativo="00000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>998 && $cantidad<9999){
                $codigo=$serie.'-'."0000".($cantidad+1);
                $correlativo="0000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>9998 && $cantidad<99999){
                $codigo=$serie.'-'."000".($cantidad+1);
                $correlativo="000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>99998 && $cantidad<999999){
                $codigo=$serie.'-'."00".($cantidad+1);
                $correlativo="00".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>999998 && $cantidad<9999999){
                $codigo=$serie.'-'."0".($cantidad+1);
                $correlativo="0".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>9999998 && $cantidad<99999999){
                $codigo=$serie.'-'($cantidad+1);
                $correlativo=($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            $dato['cod_documento']= $codigo;
    
            $dato['get_contabilidad'] = $this->Model_BabyLeaders->get_list_contabilidad(1);
            $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;
    
            $dato['tipo_api'] = 3;
            $dato['tipo_doc'] = 1;
            $api = $this->Model_BabyLeaders->get_list_api_maestra($dato);
    
            if(count($api)>0){
                $mtoOperGravadas = $get_id[0]['monto']-$get_id[0]['descuento'];
                $mtoIGV=round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2);
                $subTotal=$mtoIGV+$mtoOperGravadas;
                $total_texto=$modelonumero->numtoletras(abs($subTotal),'Soles','centimos');
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $api[0]['url'].$api[0]['documento'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "ublVersion": "2.1",
                    "tipoDoc": "07",
                    "serie": "'.$serie.'",
                    "correlativo": "'.$correlativo.'",
                    "fechaEmision": "'.$dato['fechaEmision'].'",
                    "tipDocAfectado": "03",
                    "numDocfectado": "'.$dato['numDocfectado'].'",
                    "codMotivo": "01",
                    "desMotivo": "ANULACION DE LA OPERACION",
                    "tipoMoneda": "PEN",
                    "client": {
                        "tipoDoc": "1",
                        "numDoc": "'.$get_id[0]['dni_apoderado'].'",
                        "rznSocial": "'.$get_id[0]['nom_apoderado'].'",
                        "address": {
                        "direccion": "",
                        "provincia": "",
                        "departamento": "",
                        "distrito": "",
                        "ubigueo": ""
                        }
                    },
                    "company": {
                        "ruc": 20600585313,
                        "razonSocial": "BL JESUS MARIA S.A.C.",
                        "nombreComercial": "BL JESUS MARIA S.A.C.",
                        "address": {
                        "direccion": "CAL.GRAL JOSE CANTERAC NRO. 266 URB. FUNDO OYAGUE LIMA - LIMA - JESUS MARIA",
                        "provincia": "",
                        "departamento": "",
                        "distrito": "",
                        "ubigueo": ""
                        }
                    },
                    "mtoOperGravadas": '.$mtoOperGravadas.',
                    "mtoIGV": '.$mtoIGV.',
                    "totalImpuestos": '.$mtoIGV.',
                    "mtoImpVenta": '.$subTotal.',
                    "details": [
                        {
                            "codProducto": "C023",
                            "unidad": "NIU",
                            "cantidad": 1,
                            "descripcion"'.':"'.$get_id[0]['nom_pago'].'",
                            "mtoBaseIgv"'.': '.round($mtoOperGravadas,2).',
                            "porcentajeIgv"'.': '.$dato['porcentajeIgv'].',
                            "igv"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "tipAfeIgv": 10,
                            "totalImpuestos"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "mtoValorVenta"'.': '.round($mtoOperGravadas,2).',
                            "mtoValorUnitario"'.': '.$mtoOperGravadas.',
                            "mtoPrecioUnitario"'.': '.round((round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2)+$mtoOperGravadas),2).'
                        }
                    ],
                    "legends": [
                        {
                        "code": "1000",
                        "value": "'.$total_texto.'"
                        }
                    ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer '.$api[0]['token'],
                        'Content-Type: application/json'
                    ),
                ));
     
                $response = curl_exec($curl);
                curl_close($curl);
                $valida = json_decode($response,true);
    
                if(!empty($valida['error'])==true){
                    echo "1".$valida['error'];
                }else{ 
                    $decodedData = json_decode($response, true);
                    if($decodedData['sunatResponse']['success']==true){
                        $dato['xml'] = $response;
                        $dato['cdrZip'] = $decodedData['sunatResponse']['cdrZip'];
                        $dato['id'] = $decodedData['sunatResponse']['cdrResponse']['id'];
                        $dato['code'] = $decodedData['sunatResponse']['cdrResponse']['code'];
                        $dato['description'] = $decodedData['sunatResponse']['cdrResponse']['description'];
                        $dato['documento'] = "";
                        $dato['web'] = 0;
    
                        //echo "5".$dato['description'];
                        $this->Model_BabyLeaders->insert_documento_pago($dato);
                        $this->Model_BabyLeaders->update_pago_devolucion($dato);
                    }else{
                        $separada = explode("|", $decodedData['sunatResponse']['error']['message']);
                        if(isset($separada[1])){
                            $separada2 = explode("-", substr($separada[1], 13));
                            echo "1".$separada2[0]; 
                        }else{
                            echo "1".$decodedData['sunatResponse']['error']['message'];  
                        }
                    }
                }
            }else{
                echo "1No se encontró API disponible";
            }
        }else{
            echo "apoderado";
        }
    }

    public function Duplicar_Pago(){ 
        $id_pago = $this->input->post("id_pago");
        $get_id = $this->Model_BabyLeaders->get_id_pago($id_pago);

        $dato['id_matricula'] = $get_id[0]['id_matricula'];
        $dato['orden'] = $get_id[0]['orden'];
        $dato['nom_pago'] =  $get_id[0]['nom_pago'];
        $dato['monto'] = $get_id[0]['monto'];
        $dato['fec_vencimiento'] = $get_id[0]['fec_vencimiento'];

        $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
    }

    public function Delete_Pago_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_pago'] = $this->input->post("id_pago");
            $this->Model_BabyLeaders->delete_pago_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Pago_Alumno($id_alumno){
        $list_pago = $this->Model_BabyLeaders->get_list_pago_matricula_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Compras');

        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(18);
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
          
        $sheet->setCellValue("A1", 'Producto');
        $sheet->setCellValue("B1", 'Descripción');
        $sheet->setCellValue("C1", 'Estado');
        $sheet->setCellValue("D1", 'Fecha Vencimiento');
        $sheet->setCellValue("E1", 'Monto');
        $sheet->setCellValue("F1", 'Descuento');
        $sheet->setCellValue("G1", 'Sub-Total');
        $sheet->setCellValue("H1", 'Fecha Pago');
        $sheet->setCellValue("I1", 'Boleta');
        $sheet->setCellValue("J1", 'Penalidad');
        $sheet->setCellValue("K1", 'Nota Débito');
        $sheet->setCellValue("L1", 'Nota Crédito');
        $sheet->setCellValue("M1", 'Total');
        $sheet->setCellValue("N1", 'Recibo');
        $sheet->setCellValue("O1", 'Efectuado Por');
        $sheet->setCellValue("P1", 'Tipo Pago');
        $sheet->setCellValue("Q1", 'Operación');

        $contador=1;
        
        foreach($list_pago as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("E{$contador}:G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['nom_producto']);
            $sheet->setCellValue("B{$contador}", $list['nom_pago']);
            $sheet->setCellValue("C{$contador}", $list['nom_estadop']);
            if($list['fec_vencimiento']!=""){
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fec_vencimiento']));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("D{$contador}", "");  
            }
            $sheet->setCellValue("E{$contador}", $list['monto']);
            $sheet->setCellValue("F{$contador}", $list['descuento']);
            $sheet->setCellValue("G{$contador}", $list['sub_total']);
            if($list['fec_pago']!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_pago']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("H{$contador}", "");  
            }
            $sheet->setCellValue("I{$contador}", $list['boleta']);
            $sheet->setCellValue("J{$contador}", $list['penalidad']);
            $sheet->setCellValue("K{$contador}", $list['nota_debito']);
            $sheet->setCellValue("L{$contador}", $list['nota_credito']);
            $sheet->setCellValue("M{$contador}", $list['total']);
            $sheet->setCellValue("N{$contador}", $list['recibo']);
            $sheet->setCellValue("O{$contador}", $list['creado_por']);
            $sheet->setCellValue("P{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("Q{$contador}", $list['operacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Compras (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Lista_Documento_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_documento']=$this->Model_BabyLeaders->get_list_documento_alumno($dato['id_alumno']);
            $this->load->view('view_BL/alumno/lista_documentos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_BabyLeaders->get_list_alumno($id_alumno);
            $dato['list_documento']=$this->Model_BabyLeaders->get_list_documento_combo($get_id[0]['id_grado']);
            $dato['list_anio']=$this->Model_BabyLeaders->get_list_anio();
            $dato['id_alumno'] = $id_alumno;
            $this->load->view('view_BL/alumno/modal_registrar_documento', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento_Alumno(){
        $dato['id_alumno'] = $this->input->post("id_alumno");
        $dato['id_documento']= $this->input->post("id_documento_i");
        $dato['anio']= $this->input->post("id_anio_i");

        $valida = $this->Model_BabyLeaders->valida_insert_documento_alumno($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_documento_alumno($dato);
        }
    }

    public function Modal_Update_Documento_Alumno($id_detalle){  
        if ($this->session->userdata('usuario')) {
            $dato['get_detalle'] = $this->Model_BabyLeaders->get_id_detalle_alumno_empresa($id_detalle);
            $dato['get_documento'] = $this->Model_BabyLeaders->get_list_documento( $dato['get_detalle'][0]['id_documento']);
            $this->load->view('view_BL/alumno/modal_editar_documento', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Alumno(){
        $dato['id_detalle']= $this->input->post("id_detalle");
        $get_id = $this->Model_BabyLeaders->get_id_detalle_alumno_empresa($dato['id_detalle']);
        $dato['id_alumno'] = $get_id[0]['id_alumno'];
        $dato['archivo'] = $this->input->post("archivo_actual");

        $id_documento = $get_id[0]['id_documento'];

        if($_FILES["archivo_u"]["name"] != ""){
            if (file_exists($dato['archivo'])) { 
                unlink($dato['archivo']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
            $config['upload_path'] = './documento_alumno_bl1/'.$id_documento.'/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_bl1/'.$id_documento, 0777);
                chmod('./documento_alumno_bl1/'.$id_documento.'/', 0777);
                chmod('./documento_alumno_bl1/'.$id_documento.'/'.$dato['id_alumno'], 0777);
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
                $dato['archivo'] = "documento_alumno_bl1/".$id_documento."/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_BabyLeaders->update_documento_alumno($dato);
    }

    public function Descargar_Documento_Alumno($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['doc']=$this->Model_BabyLeaders->get_id_detalle_alumno_empresa($id_detalle);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen,NULL);
        }else{
            redirect('');
        }
    }

    public function Delete_Documento_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post("id_detalle");
            $dato['doc']=$this->Model_BabyLeaders->get_id_detalle_alumno_empresa($dato['id_detalle']);
            unlink($dato['doc'][0]['archivo']);
            $this->Model_BabyLeaders->delete_documento_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Documento_Alumno($id_alumno){
        $list_documento = $this->Model_BabyLeaders->get_list_documento_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(60);
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
          
        $sheet->setCellValue("A1", 'Año');
        $sheet->setCellValue("B1", 'Obligatorio');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Nombre');
        $sheet->setCellValue("E1", 'Nombre Documento');
        $sheet->setCellValue("F1", 'Subido Por');
        $sheet->setCellValue("G1", 'Fecha de Carga');

        $contador=1;
        
        foreach($list_documento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['anio']);
            $sheet->setCellValue("B{$contador}", $list['v_obligatorio']);
            $sheet->setCellValue("C{$contador}", $list['cod_documento']);
            $sheet->setCellValue("D{$contador}", $list['nom_documento']);
            $sheet->setCellValue("E{$contador}", $list['nom_archivo']);
            $sheet->setCellValue("F{$contador}", $list['usuario_subido']);
            if($list['fec_subido']!=""){
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fec_subido']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("G{$contador}", "");  
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
    
    public function Lista_Contrato_Alumno() {  
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_contrato'] = $this->Model_BabyLeaders->get_list_contrato_alumno($dato['id_alumno']);
            $this->load->view('view_BL/alumno/lista_contrato',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Contrato_Matriculados($id_documento_firma){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_contrato($id_documento_firma);
            $this->load->view('view_BL/alumno/modal_editar_contrato', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Contrato_Matriculados(){ 
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $dato['vencido']= $this->input->post("vencido_cu");
        $this->Model_BabyLeaders->update_contrato_matriculados($dato);
    }

    public function Excel_Contrato_Alumno($id_alumno){ 
        $list_contrato = $this->Model_BabyLeaders->get_list_contrato_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Contratos');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
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
          
        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", 'Documento / Contrato');
        $sheet->setCellValue("C1", 'Subido / Firmado Por');
        $sheet->setCellValue("D1", 'Fecha Carga / Firma');
        $sheet->setCellValue("E1", 'Vencido');
        $sheet->setCellValue("F1", 'Estado');

        $contador=1;
        
        foreach($list_contrato as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['referencia']);
            $sheet->setCellValue("B{$contador}", $list['descripcion']);
            $sheet->setCellValue("C{$contador}", $list['Parentesco']);
            if($list['fec_firma']!=""){
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fec_firma']));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("E{$contador}", $list['vencido']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Contratos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Documentos($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_pago($id_pago);
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento_pago_alumno($id_pago);
            $this->load->view('view_BL/alumno/modal_documentos', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Generar_Boleta(){ 
        $dato['id_pago']=$this->input->post("id_pago");
        $get_apoderado = $this->Model_BabyLeaders->valida_apoderado($dato['id_pago']);

        if($get_apoderado[0]['titular1_nombre_sunat']==1 || $get_apoderado[0]['titular2_nombre_sunat']==1){
            $get_id = $this->Model_BabyLeaders->get_id_pago($dato['id_pago']);

            //BOLETA CON SUNAT
            $dato['tipo'] = 2;

            //$dato['fec_emision'] = $get_id[0]['fec_pago_u'];
            $dato['fec_emision'] = date('Y-m-d');

            $modelonumero = new modelonumero();
            $numeroaletras = new numeroaletras();

            $cantidad = count($this->Model_BabyLeaders->contar_boletas_canceladas());
            $serie='BA02';

            if($cantidad<9){
                $codigo=$serie.'-'."0000000".($cantidad+1);
                $correlativo="0000000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>8 && $cantidad<99){
                $codigo=$serie.'-'."000000".($cantidad+1);
                $correlativo="000000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>98 && $cantidad<999){
                $codigo=$serie.'-'."00000".($cantidad+1);
                $correlativo="00000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>998 && $cantidad<9999){
                $codigo=$serie.'-'."0000".($cantidad+1);
                $correlativo="0000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>9998 && $cantidad<99999){
                $codigo=$serie.'-'."000".($cantidad+1);
                $correlativo="000".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>99998 && $cantidad<999999){
                $codigo=$serie.'-'."00".($cantidad+1);
                $correlativo="00".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>999998 && $cantidad<9999999){
                $codigo=$serie.'-'."0".($cantidad+1);
                $correlativo="0".($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            if($cantidad>9999998 && $cantidad<99999999){
                $codigo=$serie.'-'($cantidad+1);
                $correlativo=($cantidad+1);
                $dato['numero']=$cantidad+1;
            }
            $dato['cod_documento']= $codigo;

            $fecha=$dato['fec_emision']."T"."00:00:00-05:00";
            $dato['fechaEmision']=$fecha;

            $dato['get_contabilidad'] = $this->Model_BabyLeaders->get_list_contabilidad(1);
            $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;

            $dato['tipo_api'] = 2;
            $dato['tipo_doc'] = 1;
            $api = $this->Model_BabyLeaders->get_list_api_maestra($dato);

            if(count($api)>0){
                $mtoOperGravadas = $get_id[0]['monto']-$get_id[0]['descuento'];
                $mtoIGV=round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2);
                $subTotal=$mtoIGV+$mtoOperGravadas;
                $total_texto=$modelonumero->numtoletras(abs($subTotal),'Soles','centimos');

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $api[0]['url'].$api[0]['documento'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "ublVersion": "2.1",
                    "tipoOperacion": "0101",
                    "tipoDoc": "03",
                    "serie": "'.$serie.'",
                    "correlativo": "'.$correlativo.'",
                    "fechaEmision": "'.$dato['fechaEmision'].'",
                    "formaPago": {
                        "moneda": "PEN",
                        "tipo": "Contado"
                    },
                    "tipoMoneda": "PEN",
                    "client": {
                        "tipoDoc": "1",
                        "numDoc": "'.$get_id[0]['dni_apoderado'].'",
                        "rznSocial": "'.$get_id[0]['nom_apoderado'].'",
                        "address": {
                        "direccion": "",
                        "provincia": "",
                        "departamento": "",
                        "distrito": "",
                        "ubigueo": ""
                        }
                    },
                    "company": {
                        "ruc": 20600585313,
                        "razonSocial": "BL JESUS MARIA S.A.C.",
                        "nombreComercial": "BL JESUS MARIA S.A.C.",
                        "address": {
                        "direccion": "CAL.GRAL JOSE CANTERAC NRO. 266 URB. FUNDO OYAGUE LIMA - LIMA - JESUS MARIA",
                        "provincia": "",
                        "departamento": "",
                        "distrito": "",
                        "ubigueo": ""
                        }
                    },
                    "mtoOperGravadas": '.$mtoOperGravadas.',
                    "mtoIGV": '.$mtoIGV.',
                    "valorVenta": '.$mtoOperGravadas.',
                    "totalImpuestos": '.$mtoIGV.',
                    "subTotal": '.$subTotal.',
                    "mtoImpVenta": '.$subTotal.',
                    "details": [
                        {
                            "codProducto"'.':"P001",
                            "unidad"'.': "NIU",
                            "descripcion"'.':"'.$get_id[0]['nom_pago'].'",
                            "cantidad"'.': 1,
                            "mtoValorUnitario"'.': '.$mtoOperGravadas.',
                            "mtoValorVenta"'.': '.round($mtoOperGravadas,2).',
                            "mtoBaseIgv"'.': '.round($mtoOperGravadas,2).',
                            "porcentajeIgv"'.': '.$dato['porcentajeIgv'].',
                            "igv"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "tipAfeIgv"'.': 10,
                            "totalImpuestos"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "mtoPrecioUnitario"'.': '.round((round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2)+$mtoOperGravadas),2).'
                        }
                    ],
                    "legends": [
                        {
                        "code": "1000",
                        "value": "'.$total_texto.'"
                        }
                    ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer '.$api[0]['token'],
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $valida = json_decode($response,true);

                if(!empty($valida['error'])==true){
                    echo "1".$valida['error'];
                }else{ 
                    $decodedData = json_decode($response, true);
                    if($decodedData['sunatResponse']['success']==true){
                        $dato['xml'] = $response;
                        $dato['cdrZip'] = $decodedData['sunatResponse']['cdrZip'];
                        $dato['id'] = $decodedData['sunatResponse']['cdrResponse']['id'];
                        $dato['code'] = $decodedData['sunatResponse']['cdrResponse']['code'];
                        $dato['description'] = $decodedData['sunatResponse']['cdrResponse']['description'];
                        $dato['documento'] = "";
                        $dato['web'] = 0;

                        //echo "5".$dato['description'];
                        $this->Model_BabyLeaders->insert_documento_pago($dato);
                    }else{
                        $separada = explode("|", $decodedData['sunatResponse']['error']['message']);
                        if(isset($separada[1])){
                            $separada2 = explode("-", substr($separada[1], 13));
                            echo "1".$separada2[0]; 
                        }else{
                            echo "1".$decodedData['sunatResponse']['error']['message'];  
                        }
                    }
                }
            }else{
                echo "1No se encontró API disponible";
            }

            //NOTA DE DÉBITO CON SUNAT
            /*$dato['fecha_vencimiento']=$get_id[0]['fec_vencimiento'];
            $dato['fecha_pago']=$get_id[0]['fec_pago_u'];
            $validacion = $this->Model_BabyLeaders->valida_nota_debito($dato);

            if($validacion[0]['dias']>0){
                $dato['tipo'] = 3;

                $dato['numDocfectado'] = $dato['cod_documento'];

                $modelonumero = new modelonumero();
                $numeroaletras = new numeroaletras();

                $cantidad = count($this->Model_BabyLeaders->contar_notas_debito_canceladas());
                $serie='BA02';
        
                if($cantidad<9){
                    $codigo=$serie.'-'."0000000".($cantidad+1);
                    $correlativo="0000000".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>8 && $cantidad<99){
                    $codigo=$serie.'-'."000000".($cantidad+1);
                    $correlativo="000000".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>98 && $cantidad<999){
                    $codigo=$serie.'-'."00000".($cantidad+1);
                    $correlativo="00000".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>998 && $cantidad<9999){
                    $codigo=$serie.'-'."0000".($cantidad+1);
                    $correlativo="0000".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>9998 && $cantidad<99999){
                    $codigo=$serie.'-'."000".($cantidad+1);
                    $correlativo="000".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>99998 && $cantidad<999999){
                    $codigo=$serie.'-'."00".($cantidad+1);
                    $correlativo="00".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>999998 && $cantidad<9999999){
                    $codigo=$serie.'-'."0".($cantidad+1);
                    $correlativo="0".($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                if($cantidad>9999998 && $cantidad<99999999){
                    $codigo=$serie.'-'($cantidad+1);
                    $correlativo=($cantidad+1);
                    $dato['numero']=$cantidad+1;
                }
                $dato['cod_documento']= $codigo;

                $dato['get_contabilidad'] = $this->Model_BabyLeaders->get_list_contabilidad(1);
                $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;

                $dato['tipo_api'] = 3;
                $dato['tipo_doc'] = 1;
                $api = $this->Model_BabyLeaders->get_list_api_maestra($dato);

                if(count($api)>0){
                    $mtoOperGravadas = $validacion[0]['dias'];
                    $mtoIGV=round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2);
                    $subTotal=$mtoIGV+$mtoOperGravadas;
                    $total_texto=$modelonumero->numtoletras(abs($subTotal),'Soles','centimos');

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $api[0]['url'].$api[0]['documento'],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "ublVersion": "2.1",
                        "tipDocAfectado": "03",
                        "numDocfectado": "'.$dato['numDocfectado'].'",
                        "codMotivo": "02",
                        "desMotivo": "AUMENTO EN EL VALOR",
                        "tipoDoc": "08",
                        "serie": "'.$serie.'",
                        "fechaEmision": "'.$dato['fechaEmision'].'",
                        "correlativo": "'.$correlativo.'",
                        "tipoMoneda": "PEN",
                        "client": {
                            "tipoDoc": "1",
                            "numDoc": "'.$get_id[0]['dni_apoderado'].'",
                            "rznSocial": "'.$get_id[0]['nom_apoderado'].'",
                            "address": {
                            "direccion": "",
                            "provincia": "",
                            "departamento": "",
                            "distrito": "",
                            "ubigueo": ""
                            }
                        },
                        "company": {
                            "ruc": 20600585313,
                            "razonSocial": "BL JESUS MARIA S.A.C.",
                            "nombreComercial": "BL JESUS MARIA S.A.C.",
                            "address": {
                            "direccion": "CAL.GRAL JOSE CANTERAC NRO. 266 URB. FUNDO OYAGUE LIMA - LIMA - JESUS MARIA",
                            "provincia": "",
                            "departamento": "",
                            "distrito": "",
                            "ubigueo": ""
                            }
                        },
                        "mtoOperGravadas": '.$mtoOperGravadas.',
                        "mtoIGV": '.$mtoIGV.',
                        "totalImpuestos": '.$mtoIGV.',
                        "mtoImpVenta": '.$subTotal.',
                        "details": [
                            {
                            "codProducto": "C023",
                            "unidad": "NIU",
                            "cantidad": 1,
                            "descripcion"'.':"'.$get_id[0]['nom_pago'].'",
                            "mtoBaseIgv"'.': '.round($mtoOperGravadas,2).',
                            "porcentajeIgv"'.': '.$dato['porcentajeIgv'].',
                            "igv"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "tipAfeIgv": 10,
                            "totalImpuestos"'.': '.round(($dato['get_contabilidad'][0]['valor']*round($mtoOperGravadas,2)),2).',
                            "mtoValorVenta": '.round($mtoOperGravadas,2).',
                            "mtoValorUnitario": '.round($mtoOperGravadas,2).',
                            "mtoPrecioUnitario"'.': '.round((round($mtoOperGravadas*$dato['get_contabilidad'][0]['valor'],2)+$mtoOperGravadas),2).'
                            }
                        ],
                        "legends": [
                            {
                            "code": "1000",
                            "value": "'.$total_texto.'"
                            }
                        ]
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$api[0]['token'],
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $valida = json_decode($response,true);

                    if(!empty($valida['error'])==true){
                        echo "1".$valida['error'];
                    }else{ 
                        $decodedData = json_decode($response, true);
                        if($decodedData['sunatResponse']['success']==true){
                            $dato['xml'] = $response;
                            $dato['cdrZip'] = $decodedData['sunatResponse']['cdrZip'];
                            $dato['id'] = $decodedData['sunatResponse']['cdrResponse']['id'];
                            $dato['code'] = $decodedData['sunatResponse']['cdrResponse']['code'];
                            $dato['description'] = $decodedData['sunatResponse']['cdrResponse']['description'];
                            $dato['documento'] = "";
                            $dato['web'] = 0;

                            //echo "5".$dato['description'];
                            $this->Model_BabyLeaders->insert_documento_pago($dato);
                            $dato['penalidad'] = $validacion[0]['dias'];
                            $this->Model_BabyLeaders->update_pago_penalidad($dato);
                        }else{
                            $separada = explode("|", $decodedData['sunatResponse']['error']['message']);
                            if(isset($separada[1])){
                                $separada2 = explode("-", substr($separada[1], 13));
                                echo "1".$separada2[0]; 
                            }else{
                                echo "1".$decodedData['sunatResponse']['error']['message'];  
                            }
                        }
                    }
                }else{
                    echo "1No se encontró API disponible";
                }
            }*/
        }else{
            echo "apoderado";
        }
    }

    public function Lista_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_observacion']=$this->Model_BabyLeaders->get_list_observacion_alumno($dato['id_alumno']);
            $this->load->view('view_BL/alumno/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_tipo_obs'] = $this->Model_BabyLeaders->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_BabyLeaders->get_list_usuario_observacion();
            $this->load->view('view_BL/alumno/registrar_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['id_tipo'] = $this->input->post("id_tipo_o");
            $dato['fecha'] = $this->input->post("fecha_o");
            $dato['usuario'] = $this->input->post("usuario_o");
            $dato['observacion'] = $this->input->post("observacion_o");

            $valida = $this->Model_BabyLeaders->valida_insert_observacion_alumno($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->insert_observacion_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['get_id']=$this->Model_BabyLeaders->get_list_observacion_alumno(null,$dato['id_observacion']);
            $dato['list_tipo_obs'] = $this->Model_BabyLeaders->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_BabyLeaders->get_list_usuario_observacion();
            $this->load->view('view_BL/alumno/editar_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['id_tipo'] = $this->input->post("id_tipo_o");
            $dato['fecha'] = $this->input->post("fecha_o");
            $dato['usuario'] = $this->input->post("usuario_o");
            $dato['observacion'] = $this->input->post("observacion_o");

            $valida = $this->Model_BabyLeaders->valida_update_observacion_alumno($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->update_observacion_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $this->Model_BabyLeaders->delete_observacion_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Observacion_Alumno($id_alumno){
        $list_observacion = $this->Model_BabyLeaders->get_list_observacion_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Observaciones');

        $sheet->setAutoFilter('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(80);

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
          
        $sheet->setCellValue("A1", 'Fecha');
        $sheet->setCellValue("B1", 'Tipo');
        $sheet->setCellValue("C1", 'Usuario');
        $sheet->setCellValue("D1", 'Comentario');

        $contador=1;
        
        foreach($list_observacion as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("C{$contador}", $list['usuario']);
            $sheet->setCellValue("D{$contador}", $list['observacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Observaciones (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Pdf_Hoja_Matricula_Completo($id_matricula){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_matricula_alumno($id_matricula);
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_BL/alumno/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Recibo_Electronico($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_documento_pago_alumno($id_documento);
            //$dato['list_detalle'] = $this->Model_BabyLeaders->get_list_venta_detalle($id_venta);
            $cantidad_filas = 30;//*count($dato['list_detalle']); 
            $dato['altura'] = 500+$cantidad_filas; 

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_BL/alumno/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output(); 
        }else{
            redirect('');
        }
    }

    public function Boleta($id_documento){
        $get_id= $this->Model_BabyLeaders->get_id_documento_pago_alumno($id_documento);

        $modelonumero = new modelonumero();
        $total_texto = $modelonumero->numtoletras(abs($get_id[0]['monto']-$get_id[0]['descuento']),'Soles','centimos');
        
        $this->load->library('Pdf');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Boleta');
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
        $pdf->MultiCell (60,6,'Baby Leaders',0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetFont('helvetica','',9);

        $pdf->SetXY (17,$y2-10);
        $pdf->MultiCell (60,5,'BL Jesus Maria SAC',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2-5);
        $pdf->MultiCell (60,5,'Gral. Canterac, 266',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2);
        $pdf->MultiCell (60,5,'Jesus Maria - Lima - Lima',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','B',14);

        $pdf->SetXY (126.8,$y2-20);
        $pdf->MultiCell (75.3,25,'',1,'C',1,0,'','',true,0,false,true,24,'M');

        $pdf->SetFillColor(214,216,70);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (127,$y2-20);
        $pdf->MultiCell (75,8,'BOLETA DE VENTA',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','',12);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFillColor(236,237,179);
        $pdf->SetXY (127,$y2-12);
        $pdf->MultiCell (75,8,'RUC: 20600585313',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','B',12);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY (127,$y2-4);
        $pdf->MultiCell (75,8,$get_id[0]['cod_documento'],0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (17,$y2+25);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (165,6,$get_id[0]['fecha_emision'],0,'L',1,0,'','',true,0,false,true,6,'M');
        
        $pdf->SetXY (17,$y2+31);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Apoderado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_apoderado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (21,6,'Documento:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,6,$get_id[0]['n_documento'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (17,$y2+37);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Sede:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,6,'Jesus Maria',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (14,6,'Grado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_grado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (18,6,'Sección:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_seccion'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (26,6,'Codigo interno:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (13,6,$get_id[0]['cod_interno'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (22,$y2+50);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (172,53,'',1,'L',1,0,'','',true,0,false,true,53,'M');

        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(217,217,217);

        $pdf->SetXY (32,$y2+55);
        $pdf->MultiCell (82,5,'PRODUCTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'MONTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'DESCUENTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'SUB-TOTAL',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','',9);

        $pdf->SetXY (27,$y2+60);
        $pdf->MultiCell (5,5,'1',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,$get_id[0]['nom_pago'],1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['descuento'],1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.number_format(($get_id[0]['monto']-$get_id[0]['descuento']),2),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (27,$y2+65);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (5,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,'',1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+73);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Gravada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/'.number_format($get_id[0]['gravada'],2),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+78);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Exonerada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+83);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Inafecta:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+88);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'IGV (18%)',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/'.number_format($get_id[0]['igv'],2),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (32,$y2+93);
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (102,5,'Son: '.$total_texto,0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (30,5,'IMPORTE TOTAL: ',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (25,5,'S/'.number_format(($get_id[0]['monto']-$get_id[0]['descuento']),2),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFillColor(255,255,255);

        /*$pdf->SetXY (17,$y2+108);
        $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');*/

        $pdf->SetXY (150,$y2+108);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Operacion:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['operacion'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+113);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (25,5,'Pagamento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (25,5,$get_id[0]['nom_tipo_pago'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+118);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['fecha_vencimiento'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->Output('Boleta_Venta.pdf', 'I');
    }

    public function Nota_Debito($id_documento){  
        $get_id= $this->Model_BabyLeaders->get_id_documento_pago_alumno($id_documento);

        $modelonumero = new modelonumero();
        $total_texto = $modelonumero->numtoletras(abs($get_id[0]['penalidad']),'Soles','centimos');

        $this->load->library('Pdf');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Nota de Debito');
        $pdf->SetSubject('Nota de Debito');
        $pdf->SetKeywords('Nota, Debito');

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
        $pdf->MultiCell (60,6,'I.E.P BabyLeaders',0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetFont('helvetica','',9); 

        $pdf->SetXY (17,$y2-10);
        $pdf->MultiCell (60,5,'BL Jesus Maria SAC',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2-5);
        $pdf->MultiCell (60,5,'Av. General Garzón, 1045',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2);
        $pdf->MultiCell (60,5,'Jesus Maria - Lima - Lima',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','B',14);

        $pdf->SetXY (126.8,$y2-20);
        $pdf->MultiCell (75.3,25.3,'',1,'C',1,0,'','',true,0,false,true,24,'M');

        $pdf->SetFillColor(193,37,130);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (127,$y2-20);
        $pdf->MultiCell (75,8,'NOTA DE DEBITO',0,'C',1,0,'','',true,0,false,true,9,'M');

        $pdf->SetFont('helvetica','',12);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFillColor(233,170,205);
        $pdf->SetXY (127,$y2-12);
        $pdf->MultiCell (75,8,'RUC: 20600585313',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','B',12);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY (127,$y2-4);
        $pdf->MultiCell (75,8,$get_id[0]['cod_documento'],0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (9.8,$y2+10);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (192.2,14.2,'',1,'L',1,0,'','',true,0,false,true,14.2,'M');

        $pdf->SetXY (10,$y2+10);
        $pdf->MultiCell (7,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Señor(es):',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (60,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'RUC:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,6,'',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (30,6,'Tipo de Moneda:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (25,6,'Soles',0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (10,$y2+16);
        $pdf->MultiCell (7,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,8,'Dirección:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (60,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,8,'Provincia:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (18,8,'Distrito:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (37,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (17,$y2+25);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (35,6,$get_id[0]['fecha_emision'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (42,6,'Documento que modifica:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (88,6,'Boleta '.$get_id[0]['documento_modificado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        
        $pdf->SetXY (17,$y2+31);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Apoderado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_apoderado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (21,6,'Documento:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,6,$get_id[0]['n_documento'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (17,$y2+37);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Sede:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,6,'Jesus Maria',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (14,6,'Grado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_grado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (18,6,'Sección:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_seccion'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (26,6,'Codigo interno:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (13,6,$get_id[0]['cod_interno'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (22,$y2+50);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (172,53,'',1,'L',1,0,'','',true,0,false,true,53,'M');

        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(217,217,217);

        $pdf->SetXY (32,$y2+55);
        $pdf->MultiCell (82,5,'PRODUCTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'MONTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'DESCUENTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'SUB-TOTAL',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','',9);

        $pdf->SetXY (27,$y2+60);
        $pdf->MultiCell (5,5,'1',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,$get_id[0]['nom_pago'],1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['penalidad'],1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/0',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['penalidad'],1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (27,$y2+65);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (5,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,'',1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+73);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Gravada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+78);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Exonerada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+83);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Inafecta:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['penalidad'],1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+88);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'IGV (0%)',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (32,$y2+93);
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (102,5,'Son: '.$total_texto,0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (30,5,'IMPORTE TOTAL: ',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['penalidad'],1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFillColor(255,255,255);

        /*$pdf->SetXY (17,$y2+108);
        $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');*/

        $pdf->SetXY (150,$y2+108);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Operacion:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['operacion'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+113);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (25,5,'Pagamento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (25,5,$get_id[0]['nom_tipo_pago'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+118);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['fecha_vencimiento'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->Output('Nota_Debito.pdf', 'I');
    }

    public function Nota_Credito($id_documento){
        $get_id= $this->Model_BabyLeaders->get_id_documento_pago_alumno($id_documento);

        $modelonumero = new modelonumero();
        $total_texto = $modelonumero->numtoletras(abs(($get_id[0]['monto']-$get_id[0]['descuento'])),'Soles','centimos');
        
        $this->load->library('Pdf');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Nota de Credito');
        $pdf->SetSubject('Nota de Credito');
        $pdf->SetKeywords('Nota, Credito');

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
        $pdf->MultiCell (60,6,'I.E.P BabyLeaders',0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetFont('helvetica','',9);

        $pdf->SetXY (17,$y2-10);
        $pdf->MultiCell (60,5,'BL Jesus Maria SAC',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2-5);
        $pdf->MultiCell (60,5,'Av. General Garzón, 1045',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (17,$y2);
        $pdf->MultiCell (60,5,'Jesus Maria - Lima - Lima',0,'L',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','B',14);

        $pdf->SetXY (126.8,$y2-20);
        $pdf->MultiCell (75.3,25,'',1,'C',1,0,'','',true,0,false,true,24,'M');

        $pdf->SetFillColor(216,136,55);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (127,$y2-20);
        $pdf->MultiCell (75,8,'NOTA DE CREDITO',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','',12);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFillColor(244,219,194);
        $pdf->SetXY (127,$y2-12);
        $pdf->MultiCell (75,8,'RUC: 20600585313',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','B',12);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY (127,$y2-4);
        $pdf->MultiCell (75,8,$get_id[0]['cod_documento'],0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (17,$y2+25);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (165,6,$get_id[0]['fecha_emision'],0,'L',1,0,'','',true,0,false,true,6,'M');
        
        $pdf->SetXY (17,$y2+31);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Apoderado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_apoderado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (21,6,'Documento:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,6,$get_id[0]['n_documento'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (17,$y2+37);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Sede:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,6,'Jesus Maria',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (14,6,'Grado:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_grado'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (18,6,'Sección:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (32,6,$get_id[0]['nom_seccion'],0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (26,6,'Codigo interno:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (13,6,$get_id[0]['cod_interno'],0,'L',1,0,'','',true,0,false,true,6,'M');

        $pdf->SetXY (22,$y2+50);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (172,53,'',1,'L',1,0,'','',true,0,false,true,53,'M');

        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(217,217,217);

        $pdf->SetXY (32,$y2+55);
        $pdf->MultiCell (82,5,'PRODUCTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'MONTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'DESCUENTO',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'SUB-TOTAL',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFont('helvetica','',9);

        $pdf->SetXY (27,$y2+60);
        $pdf->MultiCell (5,5,'1',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,$get_id[0]['nom_pago'],1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.($get_id[0]['monto']-$get_id[0]['descuento']),1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/0',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.($get_id[0]['monto']-$get_id[0]['descuento']),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (27,$y2+65);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (5,5,'',1,'C',1,0,'','',true,0,false,true,5,'M'); 
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (82,5,'',1,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+73);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Gravada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+78);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Exonerada:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+83);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'OP. Inafecta:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/'.($get_id[0]['monto']-$get_id[0]['descuento']),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (134,$y2+88);
        $pdf->SetFont('helvetica','',8);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (30,5,'IGV (0%)',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (25,5,'S/0.00',1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (32,$y2+93);
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (102,5,'Son: '.$total_texto,0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (30,5,'IMPORTE TOTAL: ',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (25,5,'S/'.($get_id[0]['monto']-$get_id[0]['descuento']),1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFillColor(255,255,255);

        /*$pdf->SetXY (17,$y2+108);
        $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');*/

        $pdf->SetXY (150,$y2+108);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Operacion:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['operacion'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+113);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (25,5,'Pagamento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (25,5,$get_id[0]['nom_tipo_pago'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+118);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'L',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,$get_id[0]['fecha_vencimiento'],0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->Output('Nota_Credito.pdf', 'I');
    }
    //-----------------------------------GRADO-------------------------------------
    public function Grado(){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/grado/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Grado() {
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado();
            $this->load->view('view_BL/grado/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/grado/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['nom_grado']= $this->input->post("nom_grado_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_BabyLeaders->valida_insert_grado($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->insert_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Grado($id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_grado($id_grado);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/grado/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado"); 
            $dato['nom_grado']= $this->input->post("nom_grado_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Model_BabyLeaders->valida_update_grado($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->update_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $this->Model_BabyLeaders->delete_grado($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Grado(){
        $list_grado = $this->Model_BabyLeaders->get_list_grado();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Grados');

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
        
        foreach($list_grado as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_grado']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Grados (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------SECCIÓN-------------------------------------
    public function Seccion(){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/seccion/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Seccion() {
        if ($this->session->userdata('usuario')) {
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion();
            $this->load->view('view_BL/seccion/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/seccion/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado_i");
            $dato['nom_seccion']= $this->input->post("nom_seccion_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_BabyLeaders->valida_insert_seccion($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->insert_seccion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Seccion($id_seccion){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_seccion($id_seccion);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/seccion/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_seccion']= $this->input->post("id_seccion"); 
            $dato['id_grado']= $this->input->post("id_grado_u");
            $dato['nom_seccion']= $this->input->post("nom_seccion_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Model_BabyLeaders->valida_update_seccion($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_BabyLeaders->update_seccion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_seccion']= $this->input->post("id_seccion");
            $this->Model_BabyLeaders->delete_seccion($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Seccion(){
        $list_seccion = $this->Model_BabyLeaders->get_list_seccion();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sección');

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

        $sheet->setCellValue("A1", 'Grado');	
        $sheet->setCellValue("B1", 'Nombre');	        
        $sheet->setCellValue("C1", 'Estado');

        $contador=1;
        
        foreach($list_seccion as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_grado']);
            $sheet->setCellValue("B{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sección (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------DOCUMENTO-------------------------------------------
    public function Documento() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/documento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento();
            $this->load->view('view_BL/documento/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $this->load->view('view_BL/documento/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento(){
        $dato['cod_documento']= $this->input->post("cod_documento_i");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['nom_documento']= $this->input->post("nom_documento_i");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_i");  
        $dato['obligatorio']= $this->input->post("obligatorio_i");
        $dato['digital']= $this->input->post("digital_i");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_i");
        $dato['validacion']= $this->input->post("validacion_i");

        $total=count($this->Model_BabyLeaders->valida_insert_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_documento($dato);
            if($dato['aplicar_todos']==1){
                $get_id = $this->Model_BabyLeaders->ultimo_id_documento();
                $dato['id_documento'] = $get_id[0]['id_documento'];
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_BabyLeaders->get_list_alumno_combo();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['id_alumno'];
                    $valida = $this->Model_BabyLeaders->valida_insert_documento_todos($dato);
                    if(count($valida)==0){
                        $this->Model_BabyLeaders->insert_documento_todos($dato);
                    }
                }
            }
        }
    }

    public function Modal_Update_Documento($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_documento($id_documento);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_status'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/documento/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $dato['cod_documento']= $this->input->post("cod_documento_u");
        $dato['id_grado']= $this->input->post("id_grado_u");
        $dato['nom_documento']= $this->input->post("nom_documento_u");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_u");  
        $dato['obligatorio']= $this->input->post("obligatorio_u");
        $dato['estado']= $this->input->post("estado_u");
        $dato['digital']= $this->input->post("digital_u");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_u"); 
        $dato['validacion']= $this->input->post("validacion_u");

        $total=count($this->Model_BabyLeaders->valida_update_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_documento($dato);
            if($dato['aplicar_todos']==1){
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_BabyLeaders->get_list_alumno_combo();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['Id'];
                    $valida = $this->Model_BabyLeaders->valida_insert_documento_todos($dato);
                    if(count($valida)==0){
                        $this->Model_BabyLeaders->insert_documento_todos($dato);
                    }
                }
            }
        }
    }

    public function Delete_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_BabyLeaders->delete_documento($dato);
    }

    public function Excel_Documento(){
        $list_documento = $this->Model_BabyLeaders->get_list_documento();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documento');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(20);
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
        $sheet->setCellValue("B1", 'Grado');
        $sheet->setCellValue("C1", 'Nombre');
        $sheet->setCellValue("D1", 'Descripción');
        $sheet->setCellValue("E1", 'Obligatorio');
        $sheet->setCellValue("F1", 'Estado');
        $sheet->setCellValue("G1", 'Validación');

        $contador=1;
        
        foreach($list_documento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_documento']);
            $sheet->setCellValue("B{$contador}", $list['nom_grado']);
            $sheet->setCellValue("C{$contador}", $list['nom_documento']);
            $sheet->setCellValue("D{$contador}", $list['descripcion_documento']);
            $sheet->setCellValue("E{$contador}", $list['obligatorio']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
            $sheet->setCellValue("G{$contador}", $list['validacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documento (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------MATRÍCULA-------------------------------------
    public function Matricula() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/matricula/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula() {
        if ($this->session->userdata('usuario')) {
            $parametro = $this->input->post("parametro");
            $dato['list_matricula'] = $this->Model_BabyLeaders->get_list_matricula($parametro);
            $this->load->view('view_BL/matricula/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Matricula() {
        if ($this->session->userdata('usuario')) {
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_parentesco'] = $this->Model_BabyLeaders->get_list_parentesco();
            $dato['list_medio'] = $this->Model_BabyLeaders->get_list_medios();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento_combo();
            $dato['datos_alumno'] = $this->Model_BabyLeaders->get_id_datos_alumno();
            $dato['datos_documento'] = $this->Model_BabyLeaders->get_id_datos_documento();
            $dato['datos_matricula'] = $this->Model_BabyLeaders->get_id_datos_matricula();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/matricula/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Busca_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_BabyLeaders->busca_provincia($id_departamento);
            $this->load->view('view_BL/matricula/provincia', $dato);
        } else {
            redirect('');
        }
    }

    public function Busca_Distrito(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $id_provincia = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_distrito'] = $this->Model_BabyLeaders->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('view_BL/matricula/distrito', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_BabyLeaders->busca_provincia($id_departamento);
            $this->load->view('view_BL/matricula/provincia_alumno', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Producto(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto_combo($id_grado);
            $this->load->view('view_BL/matricula/producto', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Distrito(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $id_provincia = $this->input->post("id_provincia");
            $dato['id_distrito'] = $this->input->post("id_distrito");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_distrito'] = $this->Model_BabyLeaders->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('view_BL/matricula/distrito_alumno', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_documento_alum']= $this->input->post("id_tipo_documento_alum");
            $dato['n_doc_alum']= $this->input->post("n_doc_alum");
            $dato['fec_nac_alum']= $this->input->post("fec_nac_alum");
            $dato['id_sexo_alum']= $this->input->post("id_sexo_alum"); 
            $dato['apater_alum']= $this->input->post("apater_alum");
            $dato['amater_alum']= $this->input->post("amater_alum");
            $dato['nombres_alum']= $this->input->post("nombres_alum");
            $dato['direccion_alum']= $this->input->post("direccion_alum"); 
            $dato['id_departamento_alum']= $this->input->post("id_departamento_alum");
            $dato['id_provincia_alum']= $this->input->post("id_provincia_alum");
            $dato['id_distrito_alum']= $this->input->post("id_distrito_alum");
            $dato['correo_corporativo_alum']= $this->input->post("correo_corporativo_alum");

            $validar = $this->Model_BabyLeaders->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_BabyLeaders->update_datos_alumno($dato);
            }else{
                $this->Model_BabyLeaders->insert_datos_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_alumno");
            $dato['id_tipo_documento_alum']= $this->input->post("id_tipo_documento_alum");
            $dato['n_doc_alum']= $this->input->post("n_doc_alum");
            $dato['fec_nac_alum']= $this->input->post("fec_nac_alum");
            $dato['id_sexo_alum']= $this->input->post("id_sexo_alum"); 
            $dato['apater_alum']= $this->input->post("apater_alum");
            $dato['amater_alum']= $this->input->post("amater_alum");
            $dato['nombres_alum']= $this->input->post("nombres_alum");
            $dato['direccion_alum']= $this->input->post("direccion_alum"); 
            $dato['id_departamento_alum']= $this->input->post("id_departamento_alum");
            $dato['id_provincia_alum']= $this->input->post("id_provincia_alum");
            $dato['id_distrito_alum']= $this->input->post("id_distrito_alum");
            $dato['correo_corporativo_alum']= $this->input->post("correo_corporativo_alum");
            $this->Model_BabyLeaders->update_datos_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_alumno();
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_provincia_alum'] = $this->Model_BabyLeaders->busca_provincia($dato['get_id'][0]['id_departamento_alum']);
            $dato['list_distrito_alum'] = $this->Model_BabyLeaders->busca_distrito($dato['get_id'][0]['id_departamento_alum'],$dato['get_id'][0]['id_provincia_alum']);
            $this->load->view('view_BL/matricula/datos_alumno', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_documento_prin']= $this->input->post("id_tipo_documento_prin");
            $dato['n_doc_prin']= $this->input->post("n_doc_prin");
            $dato['fec_nac_prin']= $this->input->post("fec_nac_prin");
            $dato['parentesco_prin']= $this->input->post("parentesco_prin"); 
            $dato['apater_prin']= $this->input->post("apater_prin");
            $dato['amater_prin']= $this->input->post("amater_prin");
            $dato['nombres_prin']= $this->input->post("nombres_prin");
            $dato['vive_alumno_prin']= $this->input->post("vive_alumno_prin"); 
            $dato['direccion_prin']= $this->input->post("direccion_prin");
            $dato['id_departamento_prin']= $this->input->post("id_departamento_prin");
            $dato['id_provincia_prin']= $this->input->post("id_provincia_prin");
            $dato['id_distrito_prin']= $this->input->post("id_distrito_prin"); 
            $dato['celular_prin']= $this->input->post("celular_prin");
            $dato['telf_casa_prin']= $this->input->post("telf_casa_prin");
            $dato['correo_personal_prin']= $this->input->post("correo_personal_prin");
            $dato['ocupacion_prin']= $this->input->post("ocupacion_prin");
            $dato['centro_empleo_prin']= $this->input->post("centro_empleo_prin"); 
            $dato['id_tipo_documento_secu']= $this->input->post("id_tipo_documento_secu");
            $dato['n_doc_secu']= $this->input->post("n_doc_secu");
            $dato['fec_nac_secu']= $this->input->post("fec_nac_secu");
            $dato['parentesco_secu']= $this->input->post("parentesco_secu"); 
            $dato['apater_secu']= $this->input->post("apater_secu");
            $dato['amater_secu']= $this->input->post("amater_secu");
            $dato['nombres_secu']= $this->input->post("nombres_secu");
            $dato['vive_alumno_secu']= $this->input->post("vive_alumno_secu"); 
            $dato['direccion_secu']= $this->input->post("direccion_secu");
            $dato['id_departamento_secu']= $this->input->post("id_departamento_secu");
            $dato['id_provincia_secu']= $this->input->post("id_provincia_secu");
            $dato['id_distrito_secu']= $this->input->post("id_distrito_secu"); 
            $dato['celular_secu']= $this->input->post("celular_secu");
            $dato['telf_casa_secu']= $this->input->post("telf_casa_secu");
            $dato['correo_personal_secu']= $this->input->post("correo_personal_secu");
            $dato['ocupacion_secu']= $this->input->post("ocupacion_secu");
            $dato['centro_empleo_secu']= $this->input->post("centro_empleo_secu"); 

            $validar = $this->Model_BabyLeaders->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_BabyLeaders->update_datos_tutor($dato);
            }else{
                $this->Model_BabyLeaders->insert_datos_tutor($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_alumno");
            $dato['id_tipo_documento_prin']= $this->input->post("id_tipo_documento_prin");
            $dato['n_doc_prin']= $this->input->post("n_doc_prin");
            $dato['fec_nac_prin']= $this->input->post("fec_nac_prin");
            $dato['parentesco_prin']= $this->input->post("parentesco_prin"); 
            $dato['apater_prin']= $this->input->post("apater_prin");
            $dato['amater_prin']= $this->input->post("amater_prin");
            $dato['nombres_prin']= $this->input->post("nombres_prin");
            $dato['vive_alumno_prin']= $this->input->post("vive_alumno_prin"); 
            $dato['direccion_prin']= $this->input->post("direccion_prin");
            $dato['id_departamento_prin']= $this->input->post("id_departamento_prin");
            $dato['id_provincia_prin']= $this->input->post("id_provincia_prin");
            $dato['id_distrito_prin']= $this->input->post("id_distrito_prin"); 
            $dato['celular_prin']= $this->input->post("celular_prin");
            $dato['telf_casa_prin']= $this->input->post("telf_casa_prin");
            $dato['correo_personal_prin']= $this->input->post("correo_personal_prin");
            $dato['ocupacion_prin']= $this->input->post("ocupacion_prin");
            $dato['centro_empleo_prin']= $this->input->post("centro_empleo_prin"); 
            $dato['id_tipo_documento_secu']= $this->input->post("id_tipo_documento_secu");
            $dato['n_doc_secu']= $this->input->post("n_doc_secu");
            $dato['fec_nac_secu']= $this->input->post("fec_nac_secu");
            $dato['parentesco_secu']= $this->input->post("parentesco_secu"); 
            $dato['apater_secu']= $this->input->post("apater_secu");
            $dato['amater_secu']= $this->input->post("amater_secu");
            $dato['nombres_secu']= $this->input->post("nombres_secu");
            $dato['vive_alumno_secu']= $this->input->post("vive_alumno_secu"); 
            $dato['direccion_secu']= $this->input->post("direccion_secu");
            $dato['id_departamento_secu']= $this->input->post("id_departamento_secu");
            $dato['id_provincia_secu']= $this->input->post("id_provincia_secu");
            $dato['id_distrito_secu']= $this->input->post("id_distrito_secu"); 
            $dato['celular_secu']= $this->input->post("celular_secu");
            $dato['telf_casa_secu']= $this->input->post("telf_casa_secu");
            $dato['correo_personal_secu']= $this->input->post("correo_personal_secu");
            $dato['ocupacion_secu']= $this->input->post("ocupacion_secu");
            $dato['centro_empleo_secu']= $this->input->post("centro_empleo_secu"); 
            $this->Model_BabyLeaders->update_datos_tutor($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_alumno();
            $dato['list_parentesco'] = $this->Model_BabyLeaders->get_list_parentesco();
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_provincia_prin'] = $this->Model_BabyLeaders->busca_provincia($dato['get_id'][0]['id_departamento_prin']);
            $dato['list_distrito_prin'] = $this->Model_BabyLeaders->busca_distrito($dato['get_id'][0]['id_departamento_prin'],$dato['get_id'][0]['id_provincia_prin']);
            $dato['list_provincia_secu'] = $this->Model_BabyLeaders->busca_provincia($dato['get_id'][0]['id_departamento_secu']);
            $dato['list_distrito_secu'] = $this->Model_BabyLeaders->busca_distrito($dato['get_id'][0]['id_departamento_secu'],$dato['get_id'][0]['id_provincia_secu']);
            $this->load->view('view_BL/matricula/datos_tutor', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['donde_conocio']= $this->input->post("donde_conocio");

            $validar = $this->Model_BabyLeaders->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_BabyLeaders->update_datos_informacion($dato);
            }else{
                $this->Model_BabyLeaders->insert_datos_informacion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_alumno");
            $dato['donde_conocio']= $this->input->post("donde_conocio");
            $this->Model_BabyLeaders->update_datos_informacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_alumno();
            $dato['list_medio'] = $this->Model_BabyLeaders->get_list_medios();
            $this->load->view('view_BL/matricula/datos_informacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

            $list_documento = $this->Model_BabyLeaders->get_list_documento_combo();

            foreach($list_documento as $list){
                if($_FILES["documento_".$list['id_documento']]["name"] != ""){
                    $dato['id_documento'] = $list['id_documento'];
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_".$list['id_documento']]["name"]);
                    $config['upload_path'] = './documento_temporal_documento/documento_'.$list['id_documento'].'/'.$id_usuario;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_temporal_documento/', 0777);
                        chmod('./documento_temporal_documento/documento_'.$list['id_documento'].'/', 0777);
                        chmod('./documento_temporal_documento/documento_'.$list['id_documento'].'/'.$id_usuario, 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento_".$list['id_documento']]["name"];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_".$list['id_documento']]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_".$list['id_documento']]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento_".$list['id_documento']]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento_".$list['id_documento']]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "documento_temporal_documento/documento_".$list['id_documento']."/".$id_usuario."/".$dato['nom_documento'];
                    }     

                    $this->Model_BabyLeaders->insert_datos_documento($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

            $list_documento = $this->Model_BabyLeaders->get_list_documento_combo();

            foreach($list_documento as $list){
                if($_FILES["documento_".$list['id_documento']]["name"] != ""){
                    $valida = $this->Model_BabyLeaders->valida_insert_datos_documento($list['id_documento']);
                    if(count($valida)>0){
                        unlink($valida[0]['archivo']);
                        $this->Model_BabyLeaders->delete_datos_documento($list['id_documento']);
                    }

                    $dato['id_documento'] = $list['id_documento'];
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_".$list['id_documento']]["name"]);
                    $config['upload_path'] = './documento_temporal_documento/documento_'.$list['id_documento'].'/'.$id_usuario;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_temporal_documento/', 0777);
                        chmod('./documento_temporal_documento/documento_'.$list['id_documento'].'/', 0777);
                        chmod('./documento_temporal_documento/documento_'.$list['id_documento'].'/'.$id_usuario, 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento_".$list['id_documento']]["name"];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_".$list['id_documento']]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_".$list['id_documento']]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento_".$list['id_documento']]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento_".$list['id_documento']]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "documento_temporal_documento/documento_".$list['id_documento']."/".$id_usuario."/".$dato['nom_documento'];
                    }    
                    
                    $this->Model_BabyLeaders->insert_datos_documento($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_documento();
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento_combo();
            $this->load->view('view_BL/matricula/datos_documento', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Documento($id_documento) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->valida_insert_datos_documento($id_documento);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }else{
            redirect('');
        }
    }

    public function Insert_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_producto']= $this->input->post("id_producto");
            $dato['fec_matricula']= $this->input->post("fec_matricula");
            $dato['observaciones']= $this->input->post("observaciones");

            $validar = $this->Model_BabyLeaders->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_BabyLeaders->update_datos_matricula($dato);
            }else{
                $this->Model_BabyLeaders->insert_datos_matricula($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_matricula");
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_producto']= $this->input->post("id_producto");
            $dato['fec_matricula']= $this->input->post("fec_matricula");
            $dato['observaciones']= $this->input->post("observaciones");
            $this->Model_BabyLeaders->update_datos_matricula($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_matricula();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_producto'] = $this->Model_BabyLeaders->get_list_producto_combo($dato['get_id'][0]['id_grado']);
            $this->load->view('view_BL/matricula/datos_matricula', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Confirmacion(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
            $dato['codigo_confirmacion']= $this->input->post("codigo_confirmacion");
            $dato['hoja_matricula']= "";
            $dato['contrato']= "";
            $dato['reglamento_interno']= $this->input->post("reglamento_interno");
            $dato['forma_pago']= $this->input->post("forma_pago");
            $dato['cero_efectivo']= $this->input->post("cero_efectivo");
            $dato['contacto']= $this->input->post("contacto");

            if($_FILES["hoja_matricula"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["hoja_matricula"]["name"]);
                $config['upload_path'] = './documento_temporal_matricula/hoja_matricula/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_matricula/', 0777);
                    chmod('./documento_temporal_matricula/hoja_matricula/', 0777);
                    chmod('./documento_temporal_matricula/hoja_matricula/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["hoja_matricula"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["hoja_matricula"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["hoja_matricula"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["hoja_matricula"]["error"];
                $_FILES["file"]["size"] = $_FILES["hoja_matricula"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['hoja_matricula'] = "documento_temporal_matricula/hoja_matricula/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["contrato"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["contrato"]["name"]);
                $config['upload_path'] = './documento_temporal_matricula/contrato/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_matricula/', 0777);
                    chmod('./documento_temporal_matricula/contrato/', 0777);
                    chmod('./documento_temporal_matricula/contrato/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["contrato"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["contrato"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["contrato"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["contrato"]["error"];
                $_FILES["file"]["size"] = $_FILES["contrato"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['contrato'] = "documento_temporal_matricula/contrato/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            $validar = $this->Model_BabyLeaders->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_BabyLeaders->update_datos_confirmacion($dato);
            }else{
                $this->Model_BabyLeaders->insert_datos_confirmacion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Confirmacion(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
            $dato['id_temporal']= $this->input->post("id_temporal_datos_matricula");
            $dato['codigo_confirmacion']= $this->input->post("codigo_confirmacion");
            $dato['hoja_matricula']= $this->input->post("hoja_matricula_actual");
            $dato['contrato']= $this->input->post("contrato_actual");
            $dato['reglamento_interno']= $this->input->post("reglamento_interno");
            $dato['forma_pago']= $this->input->post("forma_pago");
            $dato['cero_efectivo']= $this->input->post("cero_efectivo");
            $dato['contacto']= $this->input->post("contacto");

            if($_FILES["hoja_matricula"]["name"] != ""){
                if (file_exists($dato['hoja_matricula'])) { 
                    unlink($dato['hoja_matricula']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["hoja_matricula"]["name"]);
                $config['upload_path'] = './documento_temporal_matricula/hoja_matricula/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_matricula/', 0777);
                    chmod('./documento_temporal_matricula/hoja_matricula/', 0777);
                    chmod('./documento_temporal_matricula/hoja_matricula/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["hoja_matricula"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["hoja_matricula"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["hoja_matricula"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["hoja_matricula"]["error"];
                $_FILES["file"]["size"] = $_FILES["hoja_matricula"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['hoja_matricula'] = "documento_temporal_matricula/hoja_matricula/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["contrato"]["name"] != ""){
                if (file_exists($dato['contrato'])) { 
                    unlink($dato['contrato']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["contrato"]["name"]);
                $config['upload_path'] = './documento_temporal_matricula/contrato/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_matricula/', 0777);
                    chmod('./documento_temporal_matricula/contrato/', 0777);
                    chmod('./documento_temporal_matricula/contrato/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["contrato"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["contrato"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["contrato"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["contrato"]["error"];
                $_FILES["file"]["size"] = $_FILES["contrato"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['contrato'] = "documento_temporal_matricula/contrato/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            $this->Model_BabyLeaders->update_datos_confirmacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Confirmacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_matricula();
            $this->load->view('view_BL/matricula/datos_confirmacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Matricula($orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_id_datos_matricula();
            if($orden==1){
                $image = $dato['get_file'][0]['hoja_matricula'];
            }else{
                $image = $dato['get_file'][0]['contrato'];
            }
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            if($orden==1){
                force_download($name , file_get_contents($dato['get_file'][0]['hoja_matricula']));
            }else{
                force_download($name , file_get_contents($dato['get_file'][0]['contrato']));
            }
        }
        else{
            redirect('');
        }
    }

    public function Enviar_Sms(){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_BabyLeaders->get_id_datos_alumno();

            if(count($get_id)==0){
                echo "error";
            }else{
                if($get_id[0]['celular_prin']==""){
                    echo "numero";
                }else{
                    include('application/views/administrador/mensaje/httpPHPAltiria.php');

                    $altiriaSMS = new AltiriaSMS();
            
                    $altiriaSMS->setDebug(true);
                    $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                    $altiriaSMS->setPassword('gllg2021');
                
                    $sDestination = '51'.$get_id[0]['celular_prin'];
                    $sMessage = "El código de verificación es el: ".str_pad(rand(0,9999), 4, "0", STR_PAD_RIGHT);
                    $altiriaSMS->sendSMS($sDestination, $sMessage);
                }
            }
        }else{
            redirect('');
        }
    }

    public function Valida_Pdf_Hoja_Matricula(){
        if ($this->session->userdata('usuario')) {
            $validar_alumno = $this->Model_BabyLeaders->validar_temporal_datos_alumno();
            $validar_matricula = $this->Model_BabyLeaders->validar_temporal_datos_matricula();
            if(count($validar_alumno)==0 || count($validar_matricula)==0){
                echo "error";
            }
        }else{
            redirect('');
        }
    }

    public function Pdf_Hoja_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_datos_alumno();
            $dato['get_matricula'] = $this->Model_BabyLeaders->get_id_datos_matricula();
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_BL/matricula/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Insert_Matricula(){
        if ($this->session->userdata('usuario')) {
            $datos_alumno = $this->Model_BabyLeaders->get_id_datos_alumno();
            $datos_documento = $this->Model_BabyLeaders->get_id_datos_documento();
            $datos_matricula = $this->Model_BabyLeaders->get_id_datos_matricula();

            if(count($datos_alumno)>0 && count($datos_matricula)==0){
                echo "alumno";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)>0){
                echo "matricula";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)==0){
                echo "error";
            }else{
                $anio=date('Y');
                $query_id = $this->Model_BabyLeaders->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
                $totalRows_t = count($query_id);
        
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigo="BL1-".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                    $codigo="BL1-".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>98){
                    $codigo="BL1-".$aniof.($totalRows_t+1);
                }
    
                $dato['cod_alum'] = $codigo;
    
                $this->Model_BabyLeaders->insert_alumno_matricula($dato);
    
                $get_id = $this->Model_BabyLeaders->ultimo_id_alumno();
                $dato['id_alumno'] = $get_id[0]['id_alumno'];

                //INSERTAR DOCUMENTOS AL ALUMNO
                $this->Model_BabyLeaders->insert_documentos_alumno($dato);

                //DATOS DE DOCUMENTOS

                /*$list_documento = $this->Model_BabyLeaders->get_list_documento_combo();

                foreach($list_documento as $list){
                    $valida = $this->Model_BabyLeaders->valida_insert_datos_documento($list['id_documento']);
                    if(count($valida)>0){
                        $config['upload_path'] = './documento_alumno_bl1/'.$list['id_documento'].'/'.$dato['id_alumno'];
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./documento_alumno_bl1/', 0777);
                            chmod('./documento_alumno_bl1/'.$list['id_documento'].'/', 0777);
                            chmod('./documento_alumno_bl1/'.$list['id_documento'].'/'.$dato['id_alumno'], 0777);
                        }
                        $desde_archivo = 41+strlen($list['id_documento'])+strlen($_SESSION['usuario'][0]['id_usuario']);
                        copy($valida[0]['archivo'],'documento_alumno_bl1/'.$list['id_documento'].'/'.$dato['id_alumno'].'/'.substr($valida[0]['archivo'],$desde_archivo));
                        unlink($valida[0]['archivo']);
                        $dato['archivo'] = 'documento_alumno_bl1/'.$list['id_documento'].'/'.$dato['id_alumno'].'/'.substr($valida[0]['archivo'],$desde_archivo);
                        $dato['id_documento'] = $list['id_documento'];
                        $this->Model_BabyLeaders->insert_documento_alumno($dato);
                    }
                }*/

                //DATOS DE MATRÍCULA

                $get_matricula = $this->Model_BabyLeaders->ultimo_id_matricula();
                $id_matricula = $get_matricula[0]['id_matricula']+1;
                
                $dato['hoja_matricula'] = "";
                $dato['contrato'] = "";

                if($datos_matricula[0]['hoja_matricula']!=""){
                    $config['upload_path'] = './documento_matricula_bl/hoja_matricula/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula_bl/', 0777);
                        chmod('./documento_matricula_bl/hoja_matricula/', 0777);
                        chmod('./documento_matricula_bl/hoja_matricula/'.$id_matricula, 0777);
                    }
                    $desde_hoja_matricula = 45+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['hoja_matricula'],'documento_matricula_bl/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula));
                    unlink($datos_matricula[0]['hoja_matricula']);
                    $dato['hoja_matricula'] = 'documento_matricula_bl/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula);
                }

                if($datos_matricula[0]['contrato']!=""){
                    $config['upload_path'] = './documento_matricula_bl/contrato/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula_bl/', 0777);
                        chmod('./documento_matricula_bl/contrato/', 0777);
                        chmod('./documento_matricula_bl/contrato/'.$id_matricula, 0777);
                    }
                    $desde_contrato = 39+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['contrato'],'documento_matricula_bl/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato));
                    unlink($datos_matricula[0]['contrato']);
                    $dato['contrato'] = 'documento_matricula_bl/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato);
                }
                
                $this->Model_BabyLeaders->insert_matricula_alumno($dato);
                $this->Model_BabyLeaders->delete_temporales();

                //ALUMNO - COMPRAS

                $get_matricula = $this->Model_BabyLeaders->ultimo_id_matricula();
                $dato['id_matricula'] = $get_matricula[0]['id_matricula'];

                $articulo = explode(",",$get_matricula[0]['id_articulo']);

                $i = 0;
                while($i<count($articulo)){
                    $get_articulo = $this->Model_BabyLeaders->get_id_articulo($articulo[$i]);

                    if($get_articulo[0]['id_tipo']==2){
                        $list_mes = $this->Model_BabyLeaders->get_list_mes_matricula($get_matricula[0]['fec_matricula']);

                        foreach($list_mes as $list){
                            $dato['nom_pago'] = "Pensión ".$list['nom_mes']." ".$get_articulo[0]['anio'];
                            $dato['monto'] = $get_articulo[0]['monto'];
                            $dato['fec_vencimiento'] = substr($get_matricula[0]['fec_matricula'],0,4)."-".$list['cod_mes']."-05";
                            $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
                        }
                    }else{
                        $dato['nom_pago'] = $get_articulo[0]['nombre'];
                        $dato['monto'] = $get_articulo[0]['monto'];
                        $dato['fec_vencimiento'] = "";
                        $this->Model_BabyLeaders->insert_pago_matricula_alumno($dato);
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matricula($parametro){
        $list_matricula = $this->Model_BabyLeaders->get_list_matricula($parametro);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Matrícula');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(14);
        $sheet->getColumnDimension('K')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Código Snappy');             
        $sheet->setCellValue("B1", 'Código Arpay');
        $sheet->setCellValue("C1", 'Grado');
        $sheet->setCellValue("D1", 'Apellido Paterno'); 
        $sheet->setCellValue("E1", 'Apellido Materno'); 
        $sheet->setCellValue("F1", 'Nombre(s)');
        $sheet->setCellValue("G1", 'Fecha Registro');
        $sheet->setCellValue("H1", 'Departamento');
        $sheet->setCellValue("I1", 'Provincia'); 
        $sheet->setCellValue("J1", 'Edad'); 
        $sheet->setCellValue("K1", 'Matriculado');
        $sheet->setCellValue("L1", 'Estado');

        $contador=1;
        
        foreach($list_matricula as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_alum']);
            $sheet->setCellValue("B{$contador}", $list['cod_arpay']);
            $sheet->setCellValue("C{$contador}", $list['nom_grado']);
            $sheet->setCellValue("D{$contador}", $list['alum_apater']); 
            $sheet->setCellValue("E{$contador}", $list['alum_amater']);
            $sheet->setCellValue("F{$contador}", $list['alum_nom']);
            $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("H{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("I{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("J{$contador}", $list['alum_edad']);
            $sheet->setCellValue("K{$contador}", $list['cant_matricula']);
            $sheet->setCellValue("L{$contador}", $list['nom_estadoa']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Matrícula (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------CURSO-------------------------------------
    public function Curso(){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/curso/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Curso() {
        if ($this->session->userdata('usuario')) {
            $dato['list_curso'] = $this->Model_BabyLeaders->get_list_curso();
            $this->load->view('view_BL/curso/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Curso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_curso_copiar'] = $this->Model_BabyLeaders->get_list_curso_combo();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/curso/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Curso_Copiar(){
        if ($this->session->userdata('usuario')) {
            $dato['id_copiar']= $this->input->post("id_copiar"); 
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_curso($dato['id_copiar']);
            $dato['list_curso_copiar'] = $this->Model_BabyLeaders->get_list_curso_combo();
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $this->load->view('view_BL/curso/curso_copiar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Curso(){
        $dato['id_copiar']= $this->input->post("id_copiar"); 
        $dato['nom_curso']= $this->input->post("nom_curso"); 
        //$dato['grupo']= $this->input->post("grupo"); 
        //$dato['unidad']= $this->input->post("unidad");  
        //$dato['turno']= $this->input->post("turno"); 
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_anio']= $this->input->post("id_anio"); 
        $dato['fec_inicio']= $this->input->post("fec_inicio");
        $dato['fec_fin']= $this->input->post("fec_fin");
        $dato['inicio_curso']= $this->input->post("inicio_curso");
        $dato['fin_curso']= $this->input->post("fin_curso");

        $valida = $this->Model_BabyLeaders->valida_insert_curso($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_curso($dato);
        }
    }

    public function Modal_Update_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/curso/editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Curso(){
        $dato['id_curso']= $this->input->post("id_curso"); 
        $dato['nom_curso']= $this->input->post("nom_curso"); 
        $dato['grupo']= $this->input->post("grupo"); 
        $dato['unidad']= $this->input->post("unidad"); 
        $dato['turno']= $this->input->post("turno");
        $dato['id_anio']= $this->input->post("id_anio"); 
        $dato['id_grado']= $this->input->post("id_grado"); 
        $dato['fec_inicio']= $this->input->post("fec_inicio");
        $dato['fec_fin']= $this->input->post("fec_fin");
        $dato['inicio_curso']= $this->input->post("inicio_curso");
        $dato['fin_curso']= $this->input->post("fin_curso");
        $dato['estado']= $this->input->post("estado");   

        $valida = $this->Model_BabyLeaders->valida_update_curso($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_curso($dato);
        }
    }

    public function Excel_Curso(){
        $list_curso = $this->Model_BabyLeaders->get_list_curso();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cursos');

        $sheet->setAutoFilter('A1:P1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(25);
        $sheet->getColumnDimension('P')->setWidth(15);

        $sheet->getStyle('A1:P1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:P1")->getFill()
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

        $sheet->getStyle("A1:P1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Grado');
        $sheet->setCellValue("B1", 'Año');
        $sheet->setCellValue("C1", 'Fecha Inicio');
        $sheet->setCellValue("D1", 'Fecha Fin');
        $sheet->setCellValue("E1", 'Registrados');
        $sheet->setCellValue("F1", 'Matriculados');
        $sheet->setCellValue("G1", 'Activos');
        $sheet->setCellValue("H1", 'Asistiendo');
        $sheet->setCellValue("I1", 'Pendiente de Pago');
        $sheet->setCellValue("J1", 'Sin Asistir');
        $sheet->setCellValue("K1", 'Pendiente de Matricula');
        $sheet->setCellValue("L1", 'Finalizados');
        $sheet->setCellValue("M1", 'Retirado');
        $sheet->setCellValue("N1", 'Anulados');
        $sheet->setCellValue("O1", 'Observaciones'); 
        $sheet->setCellValue("P1", 'Estado');

        $contador=1;
        
        foreach($list_curso as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_grado']);
            $sheet->setCellValue("B{$contador}", $list['nom_anio']);
            $sheet->setCellValue("C{$contador}",  Date::PHPToExcel($list['fec_inicio']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}",  Date::PHPToExcel($list['fec_fin']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("E{$contador}", "");
            $sheet->setCellValue("F{$contador}", "");
            $sheet->setCellValue("G{$contador}", "");
            $sheet->setCellValue("H{$contador}", "");
            $sheet->setCellValue("I{$contador}", "");
            $sheet->setCellValue("J{$contador}", "");
            $sheet->setCellValue("K{$contador}", "");
            $sheet->setCellValue("L{$contador}", "");
            $sheet->setCellValue("M{$contador}", "");
            $sheet->setCellValue("N{$contador}", "");
            $sheet->setCellValue("O{$contador}", "");
            $sheet->setCellValue("P{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cursos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/curso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Seccion_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_curso($id_curso);
            $this->load->view('view_BL/curso/lista_seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Vista_Asignar_Seccion($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_curso($id_curso);
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_combo($dato['get_id'][0]['id_grado']);
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_alumno_asignar_seccion($dato['get_id'][0]['id_grado']);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/curso/asignar_seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Asignar_Seccion(){
        if ($this->session->userdata('usuario')) {
            $cadena = substr($this->input->post("cadena"),0,-1); 
            $cantidad = $this->input->post("cantidad"); 
            $dato['id_seccion'] = $this->input->post("id_seccion"); 
            $dato['id_curso'] = $this->input->post("id_curso"); 

            if($cantidad>0){
                $array = explode(",",$cadena);
                $i = 0;

                while($i<count($array)){
                    $dato['id_matricula'] = $array[$i];
                    $this->Model_BabyLeaders->update_curso_matricula_alumno($dato);
                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Asignar_Seccion(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_matricula'] = $this->input->post("id_matricula"); 
            $this->Model_BabyLeaders->delete_asignar_seccion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Requisito_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_requisito_curso'] = $this->Model_BabyLeaders->get_list_requisito_curso($id_curso);
            $this->load->view('view_BL/curso/lista_requisito',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Requisito($id_curso){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_tipo_requisito'] = $this->Model_BabyLeaders->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/curso/modal_registrar_requisito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Requisito(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito_i"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito_i");
        $this->Model_BabyLeaders->insert_requisito($dato);  
    }

    public function Modal_Update_Requisito($id_requisito){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_requisito($id_requisito);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_tipo_requisito'] = $this->Model_BabyLeaders->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/curso/modal_editar_requisito',$dato);   
        }else{
            redirect('/login');
        }
    }  

    public function Update_Requisito(){
        $dato['id_requisito']= $this->input->post("id_requisito");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito_u"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito_u");
        $dato['estado']= $this->input->post("estado_u"); 
        $this->Model_BabyLeaders->update_requisito($dato);  
    }

    public function Lista_Alumno_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_alumno_curso'] = $this->Model_BabyLeaders->get_list_alumno_curso($id_curso);
            $this->load->view('view_BL/curso/lista_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Alumno_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_BabyLeaders->get_list_curso($id_curso);
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_alumno_grado_combo($get_id[0]['id_grado']);
            $dato['id_curso'] = $id_curso;
            $this->load->view('view_BL/curso/modal_registrar_alumno_curso',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno_Curso(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_alumno']= $this->input->post("id_alumno_c");

        $validar = $this->Model_BabyLeaders->valida_insert_alumno_curso($dato); 

        if(count($validar)>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_alumno_curso($dato); 
        }
    }

    public function Cerrar_Curso(){
        if ($this->session->userdata('usuario')) {
            $id_curso =$this->input->post("id_curso");

            /*$total=count($this->Model_BabyLeaders->valida_cerrar_curso($id_curso));

            if($total>0){
                echo "error";
            }else{*/
                $this->Model_BabyLeaders->cerrar_curso($id_curso);
            //}  
        }else{
            redirect('/login');
        } 
    }
    //-----------------------------------EXPORTACIÓN BBVA-------------------------------------
    public function Exportacion_Bbva(){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/exportacion_bbva/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Exportacion_Bbva() {
        if ($this->session->userdata('usuario')) {
            $dato['list_exportacion_bbva'] = $this->Model_BabyLeaders->get_list_exportacion_bbva();
            $this->load->view('view_BL/exportacion_bbva/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Exportacion_Bbva(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_BL/exportacion_bbva/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Exportacion_Bbva(){
        if ($this->session->userdata('usuario')) {
            $dato['tipo_operacion']= $this->input->post("tipo_operacion_i");
            $dato['fec_inicio']= $this->input->post("fec_inicio_i");
            $dato['fec_fin']= $this->input->post("fec_fin_i"); 
            $this->Model_BabyLeaders->insert_exportacion_bbva($dato);
        }else{
            redirect('/login');
        }
    }

    public function Generar_Txt($id_exportacion){
        $get_id = $this->Model_BabyLeaders->get_list_exportacion_bbva($id_exportacion);
        $list_archivo = $this->Model_BabyLeaders->get_list_archivo_txt($get_id[0]['fec_inicio'],$get_id[0]['fec_fin']);

        $i=0;

        foreach($list_archivo as $list){
            if($i==0){
                $cadena[$i]="0120600585313000PEN".$get_id[0]['fecha_creacion']."000       T";
                $i=$i+1;
            }

            $primera_columna = str_replace('Ñ','N',$list['primera_columna']);
            $primera_columna = str_replace('ñ','n',$primera_columna);
            $primera_columna = str_replace('Á','A',$primera_columna);
            $primera_columna = str_replace('á','a',$primera_columna);
            $primera_columna = str_replace('É','E',$primera_columna);
            $primera_columna = str_replace('é','e',$primera_columna);
            $primera_columna = str_replace('Í','I',$primera_columna);
            $primera_columna = str_replace('í','i',$primera_columna);
            $primera_columna = str_replace('Ó','O',$primera_columna);
            $primera_columna = str_replace('ó','o',$primera_columna);
            $primera_columna = str_replace('Ú','U',$primera_columna);
            $primera_columna = str_replace('ú','u',$primera_columna);
            $primera_columna = str_pad($primera_columna,32," ",STR_PAD_RIGHT);

            $segunda_columna = str_replace('Ñ','N',$list['segunda_columna']);
            $segunda_columna = str_replace('ñ','n',$segunda_columna);
            $segunda_columna = str_replace('Á','A',$segunda_columna);
            $segunda_columna = str_replace('á','a',$segunda_columna);
            $segunda_columna = str_replace('É','E',$segunda_columna);
            $segunda_columna = str_replace('é','e',$segunda_columna);
            $segunda_columna = str_replace('Í','I',$segunda_columna);
            $segunda_columna = str_replace('í','i',$segunda_columna);
            $segunda_columna = str_replace('Ó','O',$segunda_columna);
            $segunda_columna = str_replace('ó','o',$segunda_columna);
            $segunda_columna = str_replace('Ú','U',$segunda_columna);
            $segunda_columna = str_replace('ú','u',$segunda_columna);
            $segunda_columna = str_pad($segunda_columna,48," ",STR_PAD_RIGHT);

            $tercera_columna = $list['tercera_columna'];

            $fila = $primera_columna.$segunda_columna.$tercera_columna;

            $cadena[$i]=$fila;
            $i=$i+1; 
        }

        $filecontent=implode("\r\n",$cadena);

        header('Content-type: application/txt');
        header('Content-Disposition: attachment; filename="DATAG000_'.$get_id[0]['fecha_creacion'].'.TXT"');
        echo $filecontent;
    }
    //---------------------------------------------DOC ALUMNOS-------------------------------------------
    public function Doc_Alumno() { 
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/doc_alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Doc_Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_todos_alumno();
            $this->load->view('view_BL/doc_alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Doc_Alumno(){
        $list_alumno = $this->Model_BabyLeaders->get_list_todos_alumno();
        $list_documento = $this->Model_BabyLeaders->get_list_doc_alumnos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:P2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:P2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Doc. Alumnos');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(50);

        $sheet->getStyle('A1:P2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:P2")->getFill()
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

        $sheet->getStyle("A1:P2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->mergeCells("A1:A2");
        $sheet->mergeCells("B1:B2");
        $sheet->mergeCells("C1:C2");
        $sheet->mergeCells("D1:D2");
        $sheet->mergeCells("E1:E2");
        $sheet->mergeCells("F1:F2");
        $sheet->mergeCells("G1:G2");
        $sheet->mergeCells("H1:H2");
        $sheet->mergeCells("I1:I2");
        $sheet->mergeCells("J1:J2");
        $sheet->mergeCells("K1:K2");
        $sheet->mergeCells("L1:L2");
        $sheet->mergeCells("M1:M2");
        $sheet->mergeCells("N1:N2");
        $sheet->mergeCells("O1:O2");
        $sheet->mergeCells("P1:P2");

        $sheet->setCellValue("A1", 'Foto');	        
        $sheet->setCellValue("B1", 'Apellido Paterno');	        
        $sheet->setCellValue("C1", 'Apellido Materno');
        $sheet->setCellValue("D1", 'Nombre(s)');
        $sheet->setCellValue("E1", 'DNI');
        $sheet->setCellValue("F1", 'Fecha Nacimiento');
        $sheet->setCellValue("G1", 'Edad (Años)');	
        $sheet->setCellValue("H1", 'Edad (Meses)');	  
        $sheet->setCellValue("I1", 'Código');
        $sheet->setCellValue("J1", 'Grado');
        $sheet->setCellValue("K1", 'Sección');
        $sheet->setCellValue("L1", 'Matricula');
        $sheet->setCellValue("M1", 'Alumno');	        
        $sheet->setCellValue("N1", 'Año'); 
        $sheet->setCellValue("O1", 'Documentos');	    
        $sheet->setCellValue("P1", 'Link Foto');	

        /*$primera_letra = "Q";
        $segunda_letra = "R";
        $tercera_letra = "S";

        foreach($list_documento as $list){
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension($primera_letra)->setWidth(15);
            $sheet->getColumnDimension($segunda_letra)->setWidth(15);
            $sheet->getColumnDimension($tercera_letra)->setWidth(15);
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getFont()->setBold(true);  
            $spreadsheet->getActiveSheet()->getStyle($primera_letra."1:".$tercera_letra."2")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->mergeCells($primera_letra."1:".$tercera_letra."1");
            $sheet->setCellValue($primera_letra."1", $list['cod_documento']);
            $sheet->setCellValue($primera_letra."2", 'Cantidad');
            $sheet->setCellValue($segunda_letra."2", 'Fecha');
            $sheet->setCellValue($tercera_letra."2", 'Usuario');

            $sheet->setAutoFilter("A2:".$tercera_letra."2");

            $primera_letra++;
            $primera_letra++;
            $primera_letra++;
            $segunda_letra++;
            $segunda_letra++;
            $segunda_letra++;
            $tercera_letra++;
            $tercera_letra++;
            $tercera_letra++;
        }*/

        $contador=2;
        
        foreach($list_alumno as $list){
            $contador++;

            $fec_de = new DateTime($list['fecha_nacimiento']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); 

            $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("P{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("P{$contador}")->getFont()->setUnderline(true);  
            
            $sheet->setCellValue("A{$contador}", $list['foto']);
            $sheet->setCellValue("B{$contador}", $list['alum_apater']);
            $sheet->setCellValue("C{$contador}", $list['alum_amater']);
            $sheet->setCellValue("D{$contador}", $list['alum_nom']);
            $sheet->setCellValue("E{$contador}", $list['n_documento']); 
            if($list['fecha_nacimiento']!="0000-00-00"){
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fecha_nacimiento']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("F{$contador}", "");  
            }
            $sheet->setCellValue("G{$contador}", $diff->y);
            $sheet->setCellValue("H{$contador}", $diff->m); 
            $sheet->setCellValue("I{$contador}", $list['cod_alum']);
            $sheet->setCellValue("J{$contador}", $list['nom_grado']);
            $sheet->setCellValue("K{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("L{$contador}", $list['estado_matricula']);
            $sheet->setCellValue("M{$contador}", $list['estado_alumno']);
            $sheet->setCellValue("N{$contador}", $list['anio']);
            $sheet->setCellValue("O{$contador}", $list['documentos_subidos']."/".$list['documentos_obligatorios']);
            if($list['link_foto']!=""){
                $sheet->setCellValue("P{$contador}", base_url().$list['link_foto']);
                $sheet->getCell("P{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
            }else{
                $sheet->setCellValue("P{$contador}", "");
            }

            /*$primera_letra = "Q";
            $segunda_letra = "R";
            $tercera_letra = "S";

            foreach($list_documento as $documento){
                $sheet->getStyle("$primera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$segunda_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$tercera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $list_detalle = $this->Model_BabyLeaders->get_list_detalle_doc_alumnos($list['id_alumno'],$documento['cod_documento']);

                if(count($list_detalle)>0){
                    $sheet->setCellValue("$primera_letra{$contador}", count($list_detalle));
                    if($list_detalle[0]['fec_subido']!=""){
                        $sheet->setCellValue("$segunda_letra{$contador}", Date::PHPToExcel($list_detalle[0]['fec_subido']));
                        $sheet->getStyle("$segunda_letra{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    }else{
                        $sheet->setCellValue("$segunda_letra{$contador}", "");  
                    }
                    $sheet->setCellValue("$tercera_letra{$contador}", $list_detalle[0]['usuario_codigo']);
                }else{
                    $sheet->setCellValue("$primera_letra{$contador}", "");
                    $sheet->setCellValue("$segunda_letra{$contador}", "");
                    $sheet->setCellValue("$tercera_letra{$contador}", "");
                }

                $primera_letra++;
                $primera_letra++;
                $primera_letra++;
                $segunda_letra++;
                $segunda_letra++;
                $segunda_letra++;
                $tercera_letra++;
                $tercera_letra++;
                $tercera_letra++;
            }*/
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Doc. Alumnos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------ALUMNOS OBS-------------------------------------------
    public function Alumno_Obs() { 
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/alumno_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno_Obs() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno_obs'] = $this->Model_BabyLeaders->get_list_alumno_obs();
            $this->load->view('view_BL/alumno_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Alumno_Obs(){
        $list_alumno_obs = $this->Model_BabyLeaders->get_list_alumno_obs();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos Obs.');

        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(100);
        

        $sheet->getStyle('A1:J2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:J2")->getFill()
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

        $sheet->getStyle("A1:J2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->mergeCells("A1:A2");
        $sheet->mergeCells("B1:B2");
        $sheet->mergeCells("C1:C2");
        $sheet->mergeCells("D1:D2");
        $sheet->mergeCells("E1:E2");
        $sheet->mergeCells("F1:F2");
        $sheet->mergeCells("G1:G2");
        $sheet->mergeCells("H1:H2");
        $sheet->mergeCells("I1:I2");
        $sheet->mergeCells("J1:J2");

        $sheet->setCellValue("A1", 'Empresa');	        
        $sheet->setCellValue("B1", 'Fecha');	        
        $sheet->setCellValue("C1", 'Usuario');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Apellido Pat.');
        $sheet->setCellValue("F1", 'Apellido Mat.');
        $sheet->setCellValue("G1", 'Nombre(s)');	
        $sheet->setCellValue("H1", 'Grado');	  
        $sheet->setCellValue("I1", 'Sección');
        $sheet->setCellValue("J1", 'Comentario');

        /*$primera_letra = "Q";
        $segunda_letra = "R";
        $tercera_letra = "S";

        foreach($list_documento as $list){
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getColumnDimension($primera_letra)->setWidth(15);
            $sheet->getColumnDimension($segunda_letra)->setWidth(15);
            $sheet->getColumnDimension($tercera_letra)->setWidth(15);
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->getFont()->setBold(true);  
            $spreadsheet->getActiveSheet()->getStyle($primera_letra."1:".$tercera_letra."2")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');
            $sheet->getStyle($primera_letra."1:".$tercera_letra."2")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->mergeCells($primera_letra."1:".$tercera_letra."1");
            $sheet->setCellValue($primera_letra."1", $list['cod_documento']);
            $sheet->setCellValue($primera_letra."2", 'Cantidad');
            $sheet->setCellValue($segunda_letra."2", 'Fecha');
            $sheet->setCellValue($tercera_letra."2", 'Usuario');

            $sheet->setAutoFilter("A2:".$tercera_letra."2");

            $primera_letra++;
            $primera_letra++;
            $primera_letra++;
            $segunda_letra++;
            $segunda_letra++;
            $segunda_letra++;
            $tercera_letra++;
            $tercera_letra++;
            $tercera_letra++;
        }*/

        $contador=2;
        
        foreach($list_alumno_obs as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $comentario = $list['observacion'];
            if(strlen($comentario) > 150){
                $comentario = substr($comentario, 0, 150) . '(...)';
            }
            
            $sheet->setCellValue("A{$contador}", $list['nom_empresa']);
            $sheet->setCellValue("B{$contador}", $list['fecha_registro']);
            $sheet->setCellValue("C{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("D{$contador}", $list['cod_alum']);
            $sheet->setCellValue("E{$contador}", $list['alum_apater']);
            $sheet->setCellValue("F{$contador}", $list['alum_amater']);
            $sheet->setCellValue("G{$contador}", $list['alum_nom']);
            $sheet->setCellValue("H{$contador}", $list['nom_grado']); 
            $sheet->setCellValue("I{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("J{$contador}", $comentario);
            
            /*$primera_letra = "Q";
            $segunda_letra = "R";
            $tercera_letra = "S";

            foreach($list_documento as $documento){
                $sheet->getStyle("$primera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$segunda_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$tercera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $list_detalle = $this->Model_BabyLeaders->get_list_detalle_doc_alumnos($list['id_alumno'],$documento['cod_documento']);

                if(count($list_detalle)>0){
                    $sheet->setCellValue("$primera_letra{$contador}", count($list_detalle));
                    if($list_detalle[0]['fec_subido']!=""){
                        $sheet->setCellValue("$segunda_letra{$contador}", Date::PHPToExcel($list_detalle[0]['fec_subido']));
                        $sheet->getStyle("$segunda_letra{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    }else{
                        $sheet->setCellValue("$segunda_letra{$contador}", "");  
                    }
                    $sheet->setCellValue("$tercera_letra{$contador}", $list_detalle[0]['usuario_codigo']);
                }else{
                    $sheet->setCellValue("$primera_letra{$contador}", "");
                    $sheet->setCellValue("$segunda_letra{$contador}", "");
                    $sheet->setCellValue("$tercera_letra{$contador}", "");
                }

                $primera_letra++;
                $primera_letra++;
                $primera_letra++;
                $segunda_letra++;
                $segunda_letra++;
                $segunda_letra++;
                $tercera_letra++;
                $tercera_letra++;
                $tercera_letra++;
            }*/
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Alumnos Obs. (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/soporte_doc/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Soporte_Doc() { 
        if ($this->session->userdata('usuario')) {
            $dato['list_soporte_doc'] = $this->Model_BabyLeaders->get_list_soporte_doc();
            $this->load->view('view_BL/soporte_doc/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Soporte_Doc(){
        $list_soporte_doc = $this->Model_BabyLeaders->get_list_soporte_doc();

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

    /*public function Mailing() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/mailing/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mail() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['list_status'] = $this->Model_BabyLeaders->get_list_status_combo();


            $dato['list_alumnos'] = $this->Model_BabyLeaders->get_list_alumnos_ll();
            $dato['get_list_grado_ll'] = $this->Model_BabyLeaders->get_list_grado_ll();
            $dato['get_list_seccion_ll'] = $this->Model_BabyLeaders->get_list_seccion_ll();


            $this->load->view('view_BL/mailing/modal_registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function List_seccion() {
        if ($this->session->userdata('usuario')) {
          
            $grado = $this->input->post("grado");

            $datos = $this->Model_BabyLeaders->get_list_seccion_id($grado);
            

            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                
                    $sub_array[] = $row["id_seccion"];

                    $sub_array[] = $row["nom_seccion"];
                
                $data[] = $sub_array;
            }

            echo json_encode($data);


        }else{
            redirect('/login');
        }
    }

    public function Mailing_list() {
        if ($this->session->userdata('usuario')) {
          
            $tipo= 'bl';
            $datos = $this->Model_BabyLeaders->listar_mail_emprea($tipo);

            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                
                    $sub_array[] = $row["codigo"];

                    $sub_array[] = $row["titulo_mail"];

                    $sub_array[] = '<a onclick="Ver_alumno('.$row["id_correo_empre"].')" >ver alumnos</a> ';
                    
                    
                    
                    $sub_array[] = $row["id_grado"];
                    $sub_array[] = $row["id_seccion"];

                    $sub_array[] = '<span class="label label-success">'.$row["nom_status"].'</span>';

                    $sub_array[] = '
                  
                    <img title="Eliminar"  onclick="Delete_Email('. $row['id_correo_empre'].')" title="Eliminar" src="' .base_url() .'template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />';
                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);


        }else{
            redirect('/login');
        }
    }

    public function Ver_Alumnos_mail() {
        if ($this->session->userdata('usuario')) {
          
            $id_correo_empre =$this->input->post("id_correo_empre");
            $datos = $this->Model_BabyLeaders->listar_mail_alumnos($id_correo_empre);

            if($datos[0]["id_alumno"]=== ''){
                $todos = $this->Model_BabyLeaders->get_list_alumnos_id($datos[0]["id_seccion"],$datos[0]["id_grado"]);
                $data = array();

                foreach ($todos as $listado) {
                    $sub_array = array();
                 
                        $sub_array[] = $listado["Nombre"].' '.$listado["Apellido_Paterno"].' '.$listado["Apellido_Materno"];
                        
                    $data[] = $sub_array;
                }
    
            }else{
                $array_id_alum = explode(",", $datos[0]["id_alumno"]);
                $data = array();

                foreach ($array_id_alum as $listado) {
                    $sub_array = array();
                    $listado = $this->Model_BabyLeaders->listar_mail_alumnos_nombres($listado);
                                foreach ($listado as $filas) {
                                    $sub_array[] = $filas["Nombre"].' '.$filas["Apellido_Paterno"].' '.$filas["Apellido_Materno"];
                                }
                    $data[] = $sub_array;
                }
    
            }
        
            echo json_encode($data);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Email() {
        if ($this->session->userdata('usuario')) {

            
            $dato['id_correo_empre']= $this->input->post("id_correo_empre");

   

            $this->Model_BabyLeaders->delete_email_empresa($dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Mailing() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $tipo= 'bl';

            $num_datos = count($this->Model_BabyLeaders->listar_mail_emprea($tipo));
            $anio=date('Y');
            $dato['anio']= $this->input->post("anio");
            
            $totalRows_rm = count($this->Model_BabyLeaders->listar_mail_emprea($tipo));

            $aniof=substr($dato['anio'],2,2);
    
            if($totalRows_rm<9){
                $codigo=$aniof."000".($totalRows_rm+1);
            }
            if($totalRows_rm>8 && $totalRows_rm<99){
                $codigo=$aniof."00".($totalRows_rm+1);
            }
            if($totalRows_rm>98 && $totalRows_rm<999){
                $codigo=$aniof."0".($totalRows_rm+1);
            }
            if($totalRows_rm>998 ){
                $codigo=$aniof.($totalRows_rm+1);
            }

            $dato['codigo']= 'M'.$codigo;
            $dato['alumno_col'] =$this->input->post("alumno_col");

            if (is_null($dato['alumno_col'])) {
                $dato['alumno_col']= null;
            }else{
                $dato['alumno_col']= implode(",", $this->input->post("alumno_col")) ;
            }

            $dato['grado_col']= $this->input->post("grado_col");
            $dato['seccion_col']= $this->input->post("seccion_col");
            $dato['envio_por']= $this->input->post("envio_por");
            $dato['fecha']= $this->input->post("fecha");
            $titulo_mailing = $this->input->post("titulo_mailing");
            $dato['titulo_mailing']= $titulo_mailing ;

            $text_mailing = $this->input->post("text_mailing");
            $dato['text_mailing']= $text_mailing ;

            $dato['estado']= $this->input->post("estado");

            $dir = dirname(__DIR__, 2);

            // echo '<pre>';
            // print_r($correos);
            // echo ' </pre>';

            // exit();
            
            $id_data=$this->Model_BabyLeaders->insert_correos_empresas($dato);

            $id=$id_data[0]['id'];

            foreach ($_FILES["archivos"]["name"] as $k => $v) {

                $nombre_arch =  str_replace(' ','_', $_FILES["archivos"]["name"][$k] ); 

                $config['upload_path'] = './archivos_correos/bl/'.$id;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./archivos_correos/', 0777);
                    chmod('./archivos_correos/bl/', 0777);
                    chmod('./archivos_correos/bl/'.$id, 0777);
                }
                 $config["allowed_types"] = 'gif|jpg|png|pdf';

                 $config["allowed_types"] = '*';
                 $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // $path = $_FILES["documento"]["name"];
                $_FILES["file"]["name"] = $nombre_arch;
                $_FILES["file"]["type"] = $_FILES["archivos"]["type"][$k]; 
                $_FILES["file"]["tmp_name"] = $_FILES["archivos"]["tmp_name"][$k];  
                $_FILES["file"]["error"] =  $_FILES["archivos"]["error"][$k]; 
                $_FILES["file"]["size"] =  $_FILES["archivos"]["size"][$k]; 
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $nombre_arch_final = "archivos_correos/bl/". $id ."/".$nombre_arch;
                    $this->Model_BabyLeaders->insert_correos_empresas_arch($nombre_arch_final,$id,$nombre_arch);
                }                
            }

            if( $dato['envio_por'] == 1){
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
                   
                    $mail->setFrom('admision@babyleaders.edu.pe', $titulo_mailing ); //desde donde se envia
                    //  $mail->AddReplyTo('pupixoxd@gmail.com', 'pupixo988');
                    //  $mail->addAddress('vanessa.hilario@gllg.edu.pe');
                    //  $mail->addAddress('pupixoxd@gmail.com');

                    // $mail->addAddress('rosanna.apolaya@gllg.edu.pe');
                    // $mail->addAddress('pupixoxd@gmail.com');

                    $correos =$this->Model_BabyLeaders->listado_correos_alumno(
                        $dato['alumno_col'],
                        $dato['anio'],
                        $dato['grado_col'],
                        $dato['seccion_col']);



                    foreach ($correos as  $key => $value) {
                        // Validate email
                        if (filter_var($fila['Email'], FILTER_VALIDATE_EMAIL)) {
                            // $mail->addAddress('pupixoxd@gmail.com');
                            //  $mail->addAddress('pupixoxd@gmail.com');
                            //  $mail->addAddress('vanessa.hilario@gllg.edu.pe');                            
                            $mail->addAddress($fila['Email']);
                            // echo '<pre>';
                            // print_r( $key );
                            // echo ' </pre>';

                        }

                    }

                    // $mail->addAddress('fisanteb@gmail.com');
                    // $mail->addAddress('vanessa.hilario@gllg.edu.pe');                        

                    foreach ($_FILES["archivos"]["name"] as $k => $v) {
                        $mail->AddAttachment( $_FILES["archivos"]["tmp_name"][$k], $_FILES["archivos"]["name"][$k] );
                    }

                    $mail->AddEmbeddedImage($dir.'\correo_img\bl\img1.jpg', 'logo_1');                  
                    
                    $mail->AddEmbeddedImage($dir.'\correo_img\bl\img2.jpg', 'logo_2');                  
                    // $mail->AddEmbeddedImage($dir.'\correo_img\facebook.png', 'logo_3');                  
                    // $mail->AddEmbeddedImage($dir.'\correo_img\logo_0.png', 'logo_4');                  

                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $titulo_mailing;
                    $html = $this->load->view('view_LS/mailing/email',$dato,true);
                    $mail->Body = $html;
                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                    echo 'exito';
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }

                
            }else{

            }
        }else{
            redirect('/login');
        }
    }*/
    //----------------------------------------COLABORADORES------------------------------------------
    public function Colaborador(){
        if($this->session->userdata('usuario')){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/colaborador/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador(){
        if($this->session->userdata('usuario')){
            $tipo = $this->input->post("tipo");
            $dato['list_colaborador'] = $this->Model_BabyLeaders->get_list_colaborador($tipo);
            $this->load->view('view_BL/colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_perfil'] = $this->Model_BabyLeaders->get_list_perfil();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/colaborador/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($id_departamento);
            $this->load->view('view_BL/colaborador/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($id_provincia);
            $this->load->view('view_BL/colaborador/distrito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Colaborador(){ 
        $dato['id_perfil'] = $this->input->post("id_perfil");
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
        $dato['inicio_funciones'] = $this->input->post("inicio_funciones");
        $dato['fin_funciones'] = $this->input->post("fin_funciones");
        $dato['nickname'] = $this->input->post("nickname");
        $dato['usuario'] = $this->input->post("usuario");
        $dato['password']= password_hash($this->input->post("password"), PASSWORD_DEFAULT);
        $dato['password_desencriptado']= $this->input->post("password");
        $dato['foto']= ""; 
        $dato['observaciones']= $this->input->post("observaciones"); 

        if($dato['usuario']==""){
            if($_FILES["foto"]["name"] != ""){
                $cantidad = (count($this->Model_BabyLeaders->get_cantidad_colaborador()))+1;
    
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
    
            $this->Model_BabyLeaders->insert_colaborador($dato);
        }else{
            $valida = $this->Model_BabyLeaders->valida_insert_usuario_colaborador($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                if($_FILES["foto"]["name"] != ""){
                    $cantidad = (count($this->Model_BabyLeaders->get_cantidad_colaborador()))+1;
        
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
        
                $this->Model_BabyLeaders->insert_colaborador($dato);
                $ultimo = $this->Model_BabyLeaders->ultimo_id_colaborador();
                $dato['id_externo'] = $ultimo[0]['id_colaborador'];
                $this->Model_BabyLeaders->insert_usuario_colaborador($dato);
            }
        }
    }

    public function Editar_Colaborador($id_colaborador){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_colaborador($id_colaborador);
            $dato['list_perfil'] = $this->Model_BabyLeaders->get_list_perfil();
            $dato['list_departamento'] = $this->Model_BabyLeaders->get_list_departamento();
            $dato['list_provincia'] = $this->Model_BabyLeaders->get_list_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_BabyLeaders->get_list_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/colaborador/editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_perfil'] = $this->input->post("id_perfil"); 
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
        $dato['inicio_funciones'] = $this->input->post("inicio_funciones");
        $dato['fin_funciones'] = $this->input->post("fin_funciones");
        $dato['nickname'] = $this->input->post("nickname");
        $dato['usuario'] = $this->input->post("usuario");
        if($this->input->post("password")!=""){
            $dato['password']= password_hash($this->input->post("password"), PASSWORD_DEFAULT);
            $dato['password_desencriptado']= $this->input->post("password");
        }else{
            $dato['password'] = "";
        }
        $dato['foto']= $this->input->post("foto_actual"); 
        $dato['estado']= $this->input->post("estado"); 
        $dato['observaciones']= $this->input->post("observaciones"); 

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
                    $dato['foto'] = "foto_colaborador/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }    
            }

            $this->Model_BabyLeaders->update_colaborador($dato);
        }else{
            $valida = $this->Model_BabyLeaders->valida_update_usuario_colaborador($dato);

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
                        $dato['foto'] = "foto_colaborador/".$dato['id_colaborador']."/".$dato['nom_documento'];
                    }    
                }
    
                $this->Model_BabyLeaders->update_colaborador($dato);
                $dato['id_externo'] = $dato['id_colaborador'];

                $valida = $this->Model_BabyLeaders->valida_insert_users_colaborador($dato);

                if(count($valida)>0){
                    $this->Model_BabyLeaders->update_usuario_colaborador($dato);
                }else{
                    $this->Model_BabyLeaders->insert_usuario_colaborador($dato);
                }
            }
        }
    }

    public function Descargar_Foto_Colaborador($id_colaborador) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_id_colaborador($id_colaborador);
            $image = $dato['get_file'][0]['foto'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['foto']));
        }else{
            redirect('');
        }
    }

    public function Delete_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $this->Model_BabyLeaders->delete_colaborador($dato);
    }

    public function Excel_Colaborador($tipo){ 
        $list_colaborador = $this->Model_BabyLeaders->get_list_colaborador($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Z1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Z1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Colaboradores');

        $sheet->setAutoFilter('A1:Z1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15); 
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(35);
        $sheet->getColumnDimension('I')->setWidth(35);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(22);
        $sheet->getColumnDimension('L')->setWidth(60);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(15);
        $sheet->getColumnDimension('W')->setWidth(18);
        $sheet->getColumnDimension('X')->setWidth(15);
        $sheet->getColumnDimension('Y')->setWidth(18);
        $sheet->getColumnDimension('Z')->setWidth(100);

        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:Z1")->getFill()
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

        $sheet->getStyle("A1:Z1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Código GLL'); 
        $sheet->setCellValue("B1", 'Foto');        
        $sheet->setCellValue("C1", 'Perfil');             
        $sheet->setCellValue("D1", 'Apellido Paterno');
        $sheet->setCellValue("E1", 'Apellido Materno');
        $sheet->setCellValue("F1", 'Nombre(s)');
        $sheet->setCellValue("G1", 'DNI');
        $sheet->setCellValue("H1", 'Correo Personal');
        $sheet->setCellValue("I1", 'Correo Corporativo');
        $sheet->setCellValue("J1", 'Celular');
        $sheet->setCellValue("K1", 'Fecha Nacimiento');
        $sheet->setCellValue("L1", 'Dirección');
        $sheet->setCellValue("M1", 'Departamento');
        $sheet->setCellValue("N1", 'Provincia');
        $sheet->setCellValue("O1", 'Distrito');
        $sheet->setCellValue("P1", 'Inicio Funciones');           
        $sheet->setCellValue("Q1", 'Fin Funciones');    
        $sheet->setCellValue("R1", 'Nickname');
        $sheet->setCellValue("S1", 'Usuario');
        $sheet->setCellValue("T1", 'Estado'); 
        $sheet->setCellValue("U1", 'CV'); 
        $sheet->setCellValue("V1", 'CT'); 
        $sheet->setCellValue("W1", 'CT Firmado'); 
        $sheet->setCellValue("X1", 'FT'); 
        $sheet->setCellValue("Y1", 'Documentos'); 
        $sheet->setCellValue("Z1", 'Observaciones');             

        $contador=1;
        
        foreach($list_colaborador as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:Z{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Z{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Z{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Z{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo_gll']);
            $sheet->setCellValue("B{$contador}", $list['ft']);
            $sheet->setCellValue("C{$contador}", $list['perfil']);
            $sheet->setCellValue("D{$contador}", $list['apellido_paterno']);
            $sheet->setCellValue("E{$contador}", $list['apellido_materno']);
            $sheet->setCellValue("F{$contador}", $list['nombres']);
            $sheet->setCellValue("G{$contador}", $list['dni']);
            $sheet->setCellValue("H{$contador}", $list['correo_personal']);
            $sheet->setCellValue("I{$contador}", $list['correo_corporativo']);
            $sheet->setCellValue("J{$contador}", $list['celular']);
            if($list['fec_nacimiento']!=""){
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['fec_nacimiento']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("L{$contador}", $list['direccion']);
            $sheet->setCellValue("M{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("N{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("O{$contador}", $list['nombre_distrito']);
            if($list['inicio_funciones']!=""){
                $sheet->setCellValue("P{$contador}", Date::PHPToExcel($list['inicio_funciones']));
                $sheet->getStyle("P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fin_funciones']!=""){
                $sheet->setCellValue("Q{$contador}", Date::PHPToExcel($list['fin_funciones']));
                $sheet->getStyle("Q{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("R{$contador}", $list['nickname']);
            $sheet->setCellValue("S{$contador}", $list['usuario']);
            $sheet->setCellValue("T{$contador}", $list['nom_status']);
            $sheet->setCellValue("U{$contador}", $list['cv']);
            $sheet->setCellValue("V{$contador}", $list['ct']);
            $sheet->setCellValue("W{$contador}", $list['ct_firmado']);
            $sheet->setCellValue("X{$contador}", $list['ft']);
            $sheet->setCellValue("Y{$contador}", $list['doc']);
            $sheet->setCellValue("Z{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Colaboradores (Lista)';
        if (ob_get_contents()) ob_end_clean(); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Colaborador($id_colaborador){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_colaborador($id_colaborador);
            $dato['list_tipo_obs'] = $this->Model_BabyLeaders->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_BabyLeaders->get_list_usuario_obs();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/colaborador/detalle', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Cv_Colaborador(){ 
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['cv'] = $this->input->post("cv_actual");

        if($_FILES["cv"]["name"] != ""){ 
            if (file_exists($dato['cv'])) { 
                unlink($dato['cv']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["cv"]["name"]);
            $config['upload_path'] = './cv_colaborador/'.$dato['id_colaborador'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./cv_colaborador/', 0777);
                chmod('./cv_colaborador/'.$dato['id_colaborador'], 0777);
            }
            $config["allowed_types"] = 'pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["cv"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["cv"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["cv"]["error"];
            $_FILES["file"]["size"] = $_FILES["cv"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['cv'] = "cv_colaborador/".$dato['id_colaborador']."/".$dato['nom_documento'];
            }    
        }

        $this->Model_BabyLeaders->update_cv_colaborador($dato);
    }

    public function Lista_Contrato_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_contrato'] = $this->Model_BabyLeaders->get_list_contrato_colaborador($id_colaborador);
            $this->load->view('view_BL/colaborador/lista_contrato', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Contrato_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_BL/colaborador/modal_registrar_contrato',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Contrato_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['nom_contrato'] = $this->input->post("nom_contrato_i");
        $dato['fecha'] = $this->input->post("fecha_i");
        $dato['archivo'] = "";

        $valida = $this->Model_BabyLeaders->valida_insert_contrato_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            if($_FILES["archivo_i"]["name"] != ""){
                $cantidad = (count($this->Model_BabyLeaders->get_cantidad_contrato_colaborador()))+1;
    
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

            $this->Model_BabyLeaders->insert_contrato_colaborador($dato);
        }
    }

    public function Modal_Update_Contrato_Colaborador($id_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_contrato_colaborador($id_contrato);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/colaborador/modal_editar_contrato', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Contrato_Colaborador(){
        $dato['id_contrato'] = $this->input->post("id_contrato");
        $dato['nom_contrato'] = $this->input->post("nom_contrato_u");
        $dato['fecha'] = $this->input->post("fecha_u");
        $dato['estado'] = $this->input->post("estado_u");
        $dato['archivo'] = $this->input->post("archivo_actual");

        $valida = $this->Model_BabyLeaders->valida_update_contrato_colaborador($dato);

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

            $this->Model_BabyLeaders->update_contrato_colaborador($dato);
        }
    }

    public function Descargar_Contrato_Colaborador($id_contrato) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_id_contrato_colaborador($id_contrato);
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
        $this->Model_BabyLeaders->delete_contrato_colaborador($dato);
    }

    public function Lista_Pago_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_pago'] = $this->Model_BabyLeaders->get_list_pago_colaborador($id_colaborador);
            $this->load->view('view_BL/colaborador/lista_pago', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Pago_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_BL/colaborador/modal_registrar_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Pago_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_banco'] = $this->input->post("id_banco_i");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_i");

        $valida = $this->Model_BabyLeaders->valida_insert_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_pago_colaborador($dato);
        }
    }

    public function Modal_Update_Pago_Colaborador($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_pago_colaborador($id_pago);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/colaborador/modal_editar_pago', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $dato['id_banco'] = $this->input->post("id_banco_u");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_u");
        $dato['estado'] = $this->input->post("estado_u"); 

        $valida = $this->Model_BabyLeaders->valida_update_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_pago_colaborador($dato);
        }
    }

    public function Delete_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $this->Model_BabyLeaders->delete_pago_colaborador($dato);
    }

    public function Lista_Asistencia_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_asistencia'] = $this->Model_BabyLeaders->get_list_asistencia_colaborador($id_colaborador);
            $this->load->view('view_BL/colaborador/lista_asistencia', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Ingresos_Colaborador($id_colaborador){
        $list_asistencia = $this->Model_BabyLeaders->get_list_asistencia_colaborador($id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Fecha');
        $sheet->setCellValue("B1", 'Hora'); 
        $sheet->setCellValue("C1", 'Obs'); 
        $sheet->setCellValue("D1", 'Tipo');        
        $sheet->setCellValue("E1", 'Estado');                    
        $sheet->setCellValue("F1", 'Autorización');          
        $sheet->setCellValue("G1", 'Registro');

        $contador=1;
        
        foreach($list_asistencia as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
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

    public function Lista_Observacion_Colaborador() {
        if ($this->session->userdata('usuario')) { 
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_observacion']=$this->Model_BabyLeaders->get_list_observacion_colaborador($id_colaborador);
            $this->load->view('view_BL/colaborador/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Colaborador() {
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_tipo'] = $this->input->post("id_tipo_o");
        $dato['fecha'] = $this->input->post("fecha_o");
        $dato['usuario'] = $this->input->post("usuario_o");
        $dato['observacion'] = $this->input->post("observacion_o");

        $valida = $this->Model_BabyLeaders->valida_insert_observacion_colaborador($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_observacion_colaborador($dato);
        }
    }

    public function Delete_Observacion_Colaborador() {
        $dato['id_observacion'] = $this->input->post("id_observacion");
        $this->Model_BabyLeaders->delete_observacion_colaborador($dato);
    }
    //---------------------------------------------Colaboradores-Observaciones-------------------------------------------
    public function Colaborador_Obs() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/colaborador_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador_Obs() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_colaborador_obs'] = $this->Model_BabyLeaders->get_list_colaborador_obs();
            $this->load->view('view_BL/colaborador_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Colaborador_Obs(){
        $list_colaborador_obs = $this->Model_BabyLeaders->get_list_colaborador_obs();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B1:H2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B1:H2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Colaboradores Obs.');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(130);
        

        $sheet->getStyle('B2:H3')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:H3")->getFill()
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

        $sheet->getStyle("B2:H3")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->mergeCells("B2:B3");
        $sheet->mergeCells("C2:C3");
        $sheet->mergeCells("D2:D3");
        $sheet->mergeCells("E2:E3");
        $sheet->mergeCells("F2:F3");
        $sheet->mergeCells("G2:G3");
        $sheet->mergeCells("H2:H3");

        
        $sheet->setCellValue("B2", 'Fecha');	        
        $sheet->setCellValue("C2", 'Usuario');
        $sheet->setCellValue("D2", 'Código');
        $sheet->setCellValue("E2", 'Apellido Pat.');
        $sheet->setCellValue("F2", 'Apellido Mat.');
        $sheet->setCellValue("G2", 'Nombre(s)');	
        $sheet->setCellValue("H2", 'Comentario');


        $contador=3;
        
        foreach($list_colaborador_obs as $list){
            $contador++;

            $sheet->getStyle("B{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            //$sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $comentario = $list['Comentario'];
            if(strlen($comentario) > 150){
                $comentario = substr($comentario, 0, 150) . '(...)';
            }
            
            $sheet->setCellValue("B{$contador}", $list['fecha_registro']);
            $sheet->setCellValue("C{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("D{$contador}", $list['codigo_gll']);
            $sheet->setCellValue("E{$contador}", $list['apellido_Paterno']);
            $sheet->setCellValue("F{$contador}", $list['apellido_Materno']);
            $sheet->setCellValue("G{$contador}", $list['nombres']);
            $sheet->setCellValue("H{$contador}", $comentario);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Colaboradores Obs. (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------RETIRADOS----------------------------
    public function Retirados(){ 
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();
    
            $this->load->view('view_BL/retirados/index', $dato);

        }else{
            redirect('');
        }
    }

    public function Lista_Retirados(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_retirados'] = $this->Model_BabyLeaders->get_list_retirados();
            $this->load->view('view_BL/retirados/lista', $dato);
        }else{
            redirect('');
        }
    }

    public function Excel_Retirados(){
        $list_retirados = $this->Model_BabyLeaders->get_list_retirados($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Retirados');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(22); 
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(60);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(22);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(40);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(60);
        $sheet->getColumnDimension('Q')->setWidth(60);
        $sheet->getColumnDimension('R')->setWidth(34);

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

        $sheet->setCellValue("A1", 'Apellido Paterno');             
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Codigo');
        $sheet->setCellValue("E1", '¿Desde cuando no asiste?');
        $sheet->setCellValue("F1", 'Motivo Snappy'); 
        $sheet->setCellValue("G1", '¿Cual sería?'); 
        $sheet->setCellValue("H1", '¿FUT de retiro?');
        $sheet->setCellValue("I1", 'Recibo');
        $sheet->setCellValue("J1", 'Fecha');
        $sheet->setCellValue("K1", '¿Pago Pendientes?');
        $sheet->setCellValue("L1", 'Valor');
        $sheet->setCellValue("M1", '¿Alumno contactado telefonicamente?');
        $sheet->setCellValue("N1", 'Fecha');
        $sheet->setCellValue("O1", 'Hora');
        $sheet->setCellValue("P1", 'Resumen de contacto');
        $sheet->setCellValue("Q1", 'Observación de Retiro');
        $sheet->setCellValue("R1", 'Posibilidad de reincorporación'); 

        $contador=1;

        foreach($list_retirados as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("P{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline); 
            $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
 
            $sheet->setCellValue("A{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("C{$contador}", $list['Nombre']);
            $sheet->setCellValue("D{$contador}", $list['Codigo']);

            if($list['fecha_no_asiste']!=""){
                $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fecha_no_asiste']));
                $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("E{$contador}", "");  
            }

            $sheet->setCellValue("F{$contador}", $list['nom_motivo']);
            $sheet->setCellValue("G{$contador}", $list['otro_motivo']);
            $sheet->setCellValue("H{$contador}", $list['fut']);
            $sheet->setCellValue("I{$contador}", $list['tkt_boleta']);

            if($list['fecha_fut']!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_fut']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("J{$contador}", "");  
            }

            $sheet->setCellValue("K{$contador}", $list['pago_pendiente']);    
            $sheet->setCellValue("L{$contador}", $list['monto']);
            $sheet->setCellValue("M{$contador}", $list['contacto']);    
            $sheet->setCellValue("N{$contador}", $list['fecha_contacto']);
            $sheet->setCellValue("O{$contador}", $list['hora_contacto']);    
            $sheet->setCellValue("P{$contador}", $list['resumen']);
            $sheet->setCellValue("Q{$contador}", $list['obs_retiro']);    
            $sheet->setCellValue("R{$contador}", $list['reincorporacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Retirados (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/cierre_caja/index',$dato);  
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Cierre_Caja() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_cierre_caja'] = $this->Model_BabyLeaders->get_list_cierre_caja($tipo);
            $this->load->view('view_BL/cierre_caja/lista',$dato);
        }else{ 
            redirect('/login');
        }
    }

    public function Modal_Cierre_Caja(){
        if ($this->session->userdata('usuario')) { 
            $fecha = date('Y-m-d');
            $dato['list_usuario'] = $this->Model_BabyLeaders->get_list_usuario_codigo();
            $dato['get_saldo'] = $this->Model_BabyLeaders->get_saldo_automatico($_SESSION['usuario'][0]['id_usuario'],$fecha);
            $dato['get_producto'] = $this->Model_BabyLeaders->get_productos($_SESSION['usuario'][0]['id_usuario'],$fecha);
            $this->load->view('view_BL/cierre_caja/modal_registrar',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Saldo_Fecha(){ 
        if ($this->session->userdata('usuario')) {
            $id_vendedor = $this->input->post("id_vendedor"); 
            $fecha = $this->input->post("fecha"); 
            $dato['get_saldo'] = $this->Model_BabyLeaders->get_saldo_automatico($id_vendedor,$fecha);
            $this->load->view('view_BL/cierre_caja/saldo',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Productos_Fecha(){ 
        if ($this->session->userdata('usuario')) {
            $id_vendedor = $this->input->post("id_vendedor"); 
            $fecha = $this->input->post("fecha"); 
            $get_producto = $this->Model_BabyLeaders->get_productos($id_vendedor,$fecha);
            echo $get_producto[0]['productos']; 
        }else{
            redirect('/login');
        }
    }

    public function Insert_Cierre_Caja(){   
        if ($this->session->userdata('usuario')) {
            $dato['id_vendedor']= $this->input->post("id_vendedor_i"); 
            $dato['fecha']= $this->input->post("fecha_i"); 
            $dato['saldo_automatico']= $this->input->post("saldo_automatico_i");
            $dato['monto_entregado']= $this->input->post("monto_entregado_i"); 
            $dato['id_entrega']= $this->input->post("id_entrega_i");
            $dato['cofre']= $this->input->post("cofre_i");  
            $dato['productos']= $this->input->post("productos_i");  

            $validar = $this->Model_BabyLeaders->valida_insert_cierre_caja($dato);

            if(count($validar)>0){
                $dato['id_cierre_caja'] = $validar[0]['id_cierre_caja'];
                $this->Model_BabyLeaders->update_cierre_caja($dato);
                echo $dato['id_cierre_caja'];
            }else{
                $dato['fecha_valida']= $this->input->post("fecha_i"); 
                $valida_movimiento = $this->Model_BabyLeaders->valida_venta_cierre_caja($dato);

                if($valida_movimiento[0]['cantidad']>0){
                    $dato['fecha_valida'] = date("Y-m-d",strtotime($dato['fecha']."- 1 day"));
                    $cantidad = $this->Model_BabyLeaders->valida_venta_cierre_caja($dato);
    
                    if($cantidad[0]['cantidad']>0){
                        $validar = $this->Model_BabyLeaders->valida_ultimo_cierre_caja($dato);
    
                        if(count($validar)>0){ 
                            $this->Model_BabyLeaders->insert_cierre_caja($dato);
                            $get_id = $this->Model_BabyLeaders->ultimo_id_cierre_caja(); 
                            echo $get_id[0]['id_cierre_caja'];
                        }else{
                            $fecha_anterior = date("d-m-Y",strtotime($dato['fecha']."- 1 day"));
                            echo "no_cierre*".$fecha_anterior;
                        }
                    }else{
                        $this->Model_BabyLeaders->insert_cierre_caja($dato);
                        $get_id = $this->Model_BabyLeaders->ultimo_id_cierre_caja();
                        echo $get_id[0]['id_cierre_caja'];
                    }
                }else{
                    echo "movimiento";
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Pdf_Cierre_Caja($id_cierre_caja){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_cierre_caja($id_cierre_caja);

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_BL/cierre_caja/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Delete_Cierre_Caja(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $this->Model_BabyLeaders->delete_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cierre_Caja($tipo){
        $list_cierre_caja = $this->Model_BabyLeaders->get_list_cierre_caja($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cierre de Caja'); 

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(40);
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

        $sheet->setCellValue("A1", 'Mes');	
        $sheet->setCellValue("B1", 'Vendedor');	
        $sheet->setCellValue("C1", 'Caja');	
        $sheet->setCellValue("D1", 'Saldo Automático');	    
        $sheet->setCellValue("E1", 'Monto Entregado');
        $sheet->setCellValue("F1", 'Productos'); 
        $sheet->setCellValue("G1", 'Diferencia');
        $sheet->setCellValue("H1", 'Recibe');
        $sheet->setCellValue("I1", 'Fecha');	
        $sheet->setCellValue("J1", 'Usuario');	         
        $sheet->setCellValue("K1", 'Cofre');  
        $sheet->setCellValue("L1", 'Estado');  

        $contador=1;
        
        foreach($list_cierre_caja as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("D{$contador}:E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['mes_anio']);
            $sheet->setCellValue("B{$contador}", $list['cod_vendedor']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['caja']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['saldo_automatico']); 
            $sheet->setCellValue("E{$contador}", $list['monto_entregado']);
            $sheet->setCellValue("F{$contador}", $list['productos']);
            $sheet->setCellValue("G{$contador}", $list['diferencia']);
            $sheet->setCellValue("H{$contador}", $list['cod_entrega']);
            $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("J{$contador}", $list['cod_registro']); 
            $sheet->setCellValue("K{$contador}", $list['cofre']);
            $sheet->setCellValue("L{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cierre de Caja (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Cierre_Caja($id_cierre_caja){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_cierre_caja($id_cierre_caja);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/cierre_caja/detalle',$dato); 
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Detalle_Cierre_Caja() { 
        if ($this->session->userdata('usuario')) {
            $fecha = $this->input->post("fecha");
            $dato['list_detalle_cierre_caja'] = $this->Model_BabyLeaders->get_list_detalle_cierre_caja($fecha);
            $this->load->view('view_BL/cierre_caja/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Cierre_Caja($id_cierre_caja){ 
        if ($this->session->userdata('usuario')) {  
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_cierre_caja($id_cierre_caja);
            $this->load->view('view_BL/cierre_caja/modal_editar',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Update_Cierre_Caja(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $dato['cofre']= $this->input->post("cofre_u");
            $this->Model_BabyLeaders->update_cofre_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Cierre_Caja($fecha){ 
        $fecha = substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,-2);
        $list_detalle_cierre_caja = $this->Model_BabyLeaders->get_list_detalle_cierre_caja($fecha);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Ingreso - Ventas Directas'); 

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(18);

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
        $sheet->setCellValue("B1", 'Apellido Paterno');	
        $sheet->setCellValue("C1", 'Apellido Materno');	
        $sheet->setCellValue("D1", 'Nombre(s)');	    
        $sheet->setCellValue("E1", 'Descripción');
        $sheet->setCellValue("F1", 'Estado'); 
        $sheet->setCellValue("G1", 'Total');
        $sheet->setCellValue("H1", 'Recibo Electrónico');
        $sheet->setCellValue("I1", 'Fecha Pago');	
        $sheet->setCellValue("J1", 'Efectuado Por');	         

        $contador=1;
        
        foreach($list_detalle_cierre_caja as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_alum']);
            $sheet->setCellValue("B{$contador}", $list['alum_apater']);
            $sheet->setCellValue("C{$contador}", $list['alum_amater']); 
            $sheet->setCellValue("D{$contador}", $list['alum_nom']); 
            $sheet->setCellValue("E{$contador}", $list['nom_pago']);
            $sheet->setCellValue("F{$contador}", $list['nom_estadop']);
            $sheet->setCellValue("G{$contador}", $list['total']);
            $sheet->setCellValue("H{$contador}", $list['cod_documento']);
            $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_pago']));
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("J{$contador}", $list['usuario_codigo']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Ingreso - Ventas Directas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------BALANCE------------------------------------------
    public function Balance(){
        if ($this->session->userdata('usuario')) { 
            $get_id = $this->Admin_model->get_id_cod_empresa('BL');
            $array = explode("-",$get_id[0]['fecha_inicio']);
            $dato['list_anio'] = $this->Admin_model->get_list_anio_balance($array[0]);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/balance/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Balance(){
        if ($this->session->userdata('usuario')) { 
            $dato['anio'] = $this->input->post("anio");
            $dato['get_balance'] = $this->Model_BabyLeaders->get_list_balance($dato['anio']);
            $dato['anio_antiguo'] = $dato['anio']-1;
            $dato['get_balance_ant'] = $this->Model_BabyLeaders->get_list_balance($dato['anio_antiguo']);
            $this->load->view('view_BL/balance/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Balance($anio){
        $get_balance = $this->Model_BabyLeaders->get_list_balance($anio);
        $anio_antiguo = $anio-1;
        $get_balance_ant = $this->Model_BabyLeaders->get_list_balance($anio_antiguo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(3);
        $sheet->getColumnDimension('O')->setWidth(15);

        $spreadsheet->getActiveSheet()->getStyle("B1:M1")->getFill()
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

        $sheet->setCellValue("B1", 'Ene-'.substr($anio,-2));
        $sheet->setCellValue("C1", 'Feb-'.substr($anio,-2));           
        $sheet->setCellValue("D1", 'Mar-'.substr($anio,-2));
        $sheet->setCellValue("E1", 'Abr-'.substr($anio,-2));
        $sheet->setCellValue("F1", 'May-'.substr($anio,-2));           
        $sheet->setCellValue("G1", 'Jun-'.substr($anio,-2));
        $sheet->setCellValue("H1", 'Jul-'.substr($anio,-2));           
        $sheet->setCellValue("I1", 'Ago-'.substr($anio,-2));
        $sheet->setCellValue("J1", 'Set-'.substr($anio,-2));
        $sheet->setCellValue("K1", 'Oct-'.substr($anio,-2));           
        $sheet->setCellValue("L1", 'Nov-'.substr($anio,-2));
        $sheet->setCellValue("M1", 'Dic-'.substr($anio,-2));

        //---------------------------CONTENIDO------------------------------------------
        $total_ingreso_ene = $get_balance[0]['total_boleta_ene']+$get_balance[0]['total_factura_ene']+$get_balance[0]['total_nota_debito_ene']-$get_balance[0]['total_nota_credito_ene'];
        $total_ingreso_feb = $get_balance[0]['total_boleta_feb']+$get_balance[0]['total_factura_feb']+$get_balance[0]['total_nota_debito_feb']-$get_balance[0]['total_nota_credito_feb'];
        $total_ingreso_mar = $get_balance[0]['total_boleta_mar']+$get_balance[0]['total_factura_mar']+$get_balance[0]['total_nota_debito_mar']-$get_balance[0]['total_nota_credito_mar'];
        $total_ingreso_abr = $get_balance[0]['total_boleta_abr']+$get_balance[0]['total_factura_abr']+$get_balance[0]['total_nota_debito_abr']-$get_balance[0]['total_nota_credito_abr'];
        $total_ingreso_may = $get_balance[0]['total_boleta_may']+$get_balance[0]['total_factura_may']+$get_balance[0]['total_nota_debito_may']-$get_balance[0]['total_nota_credito_may'];
        $total_ingreso_jun = $get_balance[0]['total_boleta_jun']+$get_balance[0]['total_factura_jun']+$get_balance[0]['total_nota_debito_jun']-$get_balance[0]['total_nota_credito_jun'];
        $total_ingreso_jul = $get_balance[0]['total_boleta_jul']+$get_balance[0]['total_factura_jul']+$get_balance[0]['total_nota_debito_jul']-$get_balance[0]['total_nota_credito_jul'];
        $total_ingreso_ago = $get_balance[0]['total_boleta_ago']+$get_balance[0]['total_factura_ago']+$get_balance[0]['total_nota_debito_ago']-$get_balance[0]['total_nota_credito_ago'];
        $total_ingreso_sep = $get_balance[0]['total_boleta_sep']+$get_balance[0]['total_factura_sep']+$get_balance[0]['total_nota_debito_sep']-$get_balance[0]['total_nota_credito_sep'];
        $total_ingreso_oct = $get_balance[0]['total_boleta_oct']+$get_balance[0]['total_factura_oct']+$get_balance[0]['total_nota_debito_oct']-$get_balance[0]['total_nota_credito_oct'];
        $total_ingreso_nov = $get_balance[0]['total_boleta_nov']+$get_balance[0]['total_factura_nov']+$get_balance[0]['total_nota_debito_nov']-$get_balance[0]['total_nota_credito_nov'];
        $total_ingreso_dic = $get_balance[0]['total_boleta_dic']+$get_balance[0]['total_factura_dic']+$get_balance[0]['total_nota_debito_dic']-$get_balance[0]['total_nota_credito_dic'];
        $total_ingreso = $get_balance[0]['total_boleta']+$get_balance[0]['total_factura']+$get_balance[0]['total_nota_debito']-$get_balance[0]['total_nota_credito'];
    
        $total_ingreso_ene_ant = $get_balance_ant[0]['total_boleta_ene']+$get_balance_ant[0]['total_factura_ene']+$get_balance_ant[0]['total_nota_debito_ene']-$get_balance_ant[0]['total_nota_credito_ene'];
        $total_ingreso_feb_ant = $get_balance_ant[0]['total_boleta_feb']+$get_balance_ant[0]['total_factura_feb']+$get_balance_ant[0]['total_nota_debito_feb']-$get_balance_ant[0]['total_nota_credito_feb'];
        $total_ingreso_mar_ant = $get_balance_ant[0]['total_boleta_mar']+$get_balance_ant[0]['total_factura_mar']+$get_balance_ant[0]['total_nota_debito_mar']-$get_balance_ant[0]['total_nota_credito_mar'];
        $total_ingreso_abr_ant = $get_balance_ant[0]['total_boleta_abr']+$get_balance_ant[0]['total_factura_abr']+$get_balance_ant[0]['total_nota_debito_abr']-$get_balance_ant[0]['total_nota_credito_abr'];
        $total_ingreso_may_ant = $get_balance_ant[0]['total_boleta_may']+$get_balance_ant[0]['total_factura_may']+$get_balance_ant[0]['total_nota_debito_may']-$get_balance_ant[0]['total_nota_credito_may'];
        $total_ingreso_jun_ant = $get_balance_ant[0]['total_boleta_jun']+$get_balance_ant[0]['total_factura_jun']+$get_balance_ant[0]['total_nota_debito_jun']-$get_balance_ant[0]['total_nota_credito_jun'];
        $total_ingreso_jul_ant = $get_balance_ant[0]['total_boleta_jul']+$get_balance_ant[0]['total_factura_jul']+$get_balance_ant[0]['total_nota_debito_jul']-$get_balance_ant[0]['total_nota_credito_jul'];
        $total_ingreso_ago_ant = $get_balance_ant[0]['total_boleta_ago']+$get_balance_ant[0]['total_factura_ago']+$get_balance_ant[0]['total_nota_debito_ago']-$get_balance_ant[0]['total_nota_credito_ago'];
        $total_ingreso_sep_ant = $get_balance_ant[0]['total_boleta_sep']+$get_balance_ant[0]['total_factura_sep']+$get_balance_ant[0]['total_nota_debito_sep']-$get_balance_ant[0]['total_nota_credito_sep'];
        $total_ingreso_oct_ant = $get_balance_ant[0]['total_boleta_oct']+$get_balance_ant[0]['total_factura_oct']+$get_balance_ant[0]['total_nota_debito_oct']-$get_balance_ant[0]['total_nota_credito_oct'];
        $total_ingreso_nov_ant = $get_balance_ant[0]['total_boleta_nov']+$get_balance_ant[0]['total_factura_nov']+$get_balance_ant[0]['total_nota_debito_nov']-$get_balance_ant[0]['total_nota_credito_nov'];
        $total_ingreso_dic_ant = $get_balance_ant[0]['total_boleta_dic']+$get_balance_ant[0]['total_factura_dic']+$get_balance_ant[0]['total_nota_debito_dic']-$get_balance_ant[0]['total_nota_credito_dic'];
        $total_ingreso_ant = $get_balance_ant[0]['total_boleta']+$get_balance_ant[0]['total_factura']+$get_balance_ant[0]['total_nota_debito']-$get_balance_ant[0]['total_nota_credito'];
    
        if($total_ingreso_ene_ant==0){
            $dif_total_ingreso_ene = 0;
        }else{
            $dif_total_ingreso_ene = (($total_ingreso_ene-$total_ingreso_ene_ant)/$total_ingreso_ene_ant)*100;
        }
        if($total_ingreso_feb_ant==0){
            $dif_total_ingreso_feb = 0;
        }else{
            $dif_total_ingreso_feb = (($total_ingreso_feb-$total_ingreso_feb_ant)/$total_ingreso_feb_ant)*100;
        }
        if($total_ingreso_mar_ant==0){
            $dif_total_ingreso_mar = 0;
        }else{
            $dif_total_ingreso_mar = (($total_ingreso_mar-$total_ingreso_mar_ant)/$total_ingreso_mar_ant)*100;
        }
        if($total_ingreso_abr_ant==0){
            $dif_total_ingreso_abr = 0;
        }else{
            $dif_total_ingreso_abr = (($total_ingreso_abr-$total_ingreso_abr_ant)/$total_ingreso_abr_ant)*100;
        }
        if($total_ingreso_may_ant==0){
            $dif_total_ingreso_may = 0;
        }else{
            $dif_total_ingreso_may = (($total_ingreso_may-$total_ingreso_may_ant)/$total_ingreso_may_ant)*100;
        }
        if($total_ingreso_jun_ant==0){
            $dif_total_ingreso_jun = 0;
        }else{
            $dif_total_ingreso_jun = (($total_ingreso_jun-$total_ingreso_jun_ant)/$total_ingreso_jun_ant)*100;
        }
        if($total_ingreso_jul_ant==0){
            $dif_total_ingreso_jul = 0;
        }else{
            $dif_total_ingreso_jul = (($total_ingreso_jul-$total_ingreso_jul_ant)/$total_ingreso_jul_ant)*100;
        }
        if($total_ingreso_ago_ant==0){
            $dif_total_ingreso_ago = 0;
        }else{
            $dif_total_ingreso_ago = (($total_ingreso_ago-$total_ingreso_ago_ant)/$total_ingreso_ago_ant)*100;
        }
        if($total_ingreso_sep_ant==0){
            $dif_total_ingreso_sep = 0;
        }else{
            $dif_total_ingreso_sep = (($total_ingreso_sep-$total_ingreso_sep_ant)/$total_ingreso_sep_ant)*100;
        }
        if($total_ingreso_oct_ant==0){
            $dif_total_ingreso_oct = 0;
        }else{
            $dif_total_ingreso_oct = (($total_ingreso_oct-$total_ingreso_oct_ant)/$total_ingreso_oct_ant)*100;
        }
        if($total_ingreso_nov_ant==0){
            $dif_total_ingreso_nov = 0;
        }else{
            $dif_total_ingreso_nov = (($total_ingreso_nov-$total_ingreso_nov_ant)/$total_ingreso_nov_ant)*100;
        }
        if($total_ingreso_dic_ant==0){
            $dif_total_ingreso_dic = 0;
        }else{
            $dif_total_ingreso_dic = (($total_ingreso_dic-$total_ingreso_dic_ant)/$total_ingreso_dic_ant)*100;
        }
        if($total_ingreso_ant==0){
            $dif_total_ingreso = 0;
        }else{
            $dif_total_ingreso = (($total_ingreso-$total_ingreso_ant)/$total_ingreso_ant)*100;
        }

        $sheet->mergeCells('A2:A3');
        $sheet->getStyle('A2')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A2")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('8DBF42');

        $spreadsheet->getActiveSheet()->getStyle("B2:M3")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('E6FFBF');

        $spreadsheet->getActiveSheet()->getStyle("O2:O3")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('8DBF42');

        $sheet->getStyle("A4:A8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A4:A8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("A1:O8")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B2:O8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B2:O8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('O2:O3')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("B2:O2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        $sheet->getStyle("B4:O8")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        
        $sheet->setCellValue("A2", 'INGRESOS');
        $sheet->setCellValue("B2", "S/".number_format($total_ingreso_ene,2));
        $sheet->setCellValue("C2", "S/".number_format($total_ingreso_feb,2));
        $sheet->setCellValue("D2", "S/".number_format($total_ingreso_mar,2));
        $sheet->setCellValue("E2", "S/".number_format($total_ingreso_abr,2));
        $sheet->setCellValue("F2", "S/".number_format($total_ingreso_may,2));
        $sheet->setCellValue("G2", "S/".number_format($total_ingreso_jun,2));
        $sheet->setCellValue("H2", "S/".number_format($total_ingreso_jul,2));
        $sheet->setCellValue("I2", "S/".number_format($total_ingreso_ago,2));
        $sheet->setCellValue("J2", "S/".number_format($total_ingreso_sep,2));
        $sheet->setCellValue("K2", "S/".number_format($total_ingreso_oct,2));
        $sheet->setCellValue("L2", "S/".number_format($total_ingreso_nov,2));
        $sheet->setCellValue("M2", "S/".number_format($total_ingreso_dic,2));
        $sheet->setCellValue("O2", "S/".number_format($total_ingreso,2));

        $sheet->setCellValue("B3", number_format($dif_total_ingreso_ene,2)."%");
        $sheet->setCellValue("C3", number_format($dif_total_ingreso_feb,2)."%");
        $sheet->setCellValue("D3", number_format($dif_total_ingreso_mar,2)."%");
        $sheet->setCellValue("E3", number_format($dif_total_ingreso_abr,2)."%");
        $sheet->setCellValue("F3", number_format($dif_total_ingreso_may,2)."%");
        $sheet->setCellValue("G3", number_format($dif_total_ingreso_jun,2)."%");
        $sheet->setCellValue("H3", number_format($dif_total_ingreso_jul,2)."%");
        $sheet->setCellValue("I3", number_format($dif_total_ingreso_ago,2)."%");
        $sheet->setCellValue("J3", number_format($dif_total_ingreso_sep,2)."%");
        $sheet->setCellValue("K3", number_format($dif_total_ingreso_oct,2)."%");
        $sheet->setCellValue("L3", number_format($dif_total_ingreso_nov,2)."%");
        $sheet->setCellValue("M3", number_format($dif_total_ingreso_dic,2)."%");
        $sheet->setCellValue("O3", number_format($dif_total_ingreso,2)."%");

        $sheet->setCellValue("A4", 'Boletas');
        $sheet->setCellValue("B4", "S/".number_format($get_balance[0]['total_boleta_ene'],2));
        $sheet->setCellValue("C4", "S/".number_format($get_balance[0]['total_boleta_feb'],2));
        $sheet->setCellValue("D4", "S/".number_format($get_balance[0]['total_boleta_mar'],2));
        $sheet->setCellValue("E4", "S/".number_format($get_balance[0]['total_boleta_abr'],2));
        $sheet->setCellValue("F4", "S/".number_format($get_balance[0]['total_boleta_may'],2));
        $sheet->setCellValue("G4", "S/".number_format($get_balance[0]['total_boleta_jun'],2));
        $sheet->setCellValue("H4", "S/".number_format($get_balance[0]['total_boleta_jul'],2));
        $sheet->setCellValue("I4", "S/".number_format($get_balance[0]['total_boleta_ago'],2));
        $sheet->setCellValue("J4", "S/".number_format($get_balance[0]['total_boleta_sep'],2));
        $sheet->setCellValue("K4", "S/".number_format($get_balance[0]['total_boleta_oct'],2));
        $sheet->setCellValue("L4", "S/".number_format($get_balance[0]['total_boleta_nov'],2));
        $sheet->setCellValue("M4", "S/".number_format($get_balance[0]['total_boleta_dic'],2));
        $sheet->setCellValue("O4", "S/".number_format($get_balance[0]['total_boleta'],2));

        $sheet->setCellValue("A5", 'Cuentas Por Cobrar');
        $sheet->setCellValue("B5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_ene'],2));
        $sheet->setCellValue("C5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_feb'],2));
        $sheet->setCellValue("D5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_mar'],2));
        $sheet->setCellValue("E5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_abr'],2));
        $sheet->setCellValue("F5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_may'],2));
        $sheet->setCellValue("G5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_jun'],2));
        $sheet->setCellValue("H5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_jul'],2));
        $sheet->setCellValue("I5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_ago'],2));
        $sheet->setCellValue("J5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_sep'],2));
        $sheet->setCellValue("K5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_oct'],2));
        $sheet->setCellValue("L5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_nov'],2));
        $sheet->setCellValue("M5", "S/".number_format($get_balance[0]['total_cuentas_cobrar_dic'],2));
        $sheet->setCellValue("O5", "S/".number_format($get_balance[0]['total_cuentas_cobrar'],2));

        $sheet->setCellValue("A6", 'Facturas');
        $sheet->setCellValue("B6", "S/".number_format($get_balance[0]['total_factura_ene'],2));
        $sheet->setCellValue("C6", "S/".number_format($get_balance[0]['total_factura_feb'],2));
        $sheet->setCellValue("D6", "S/".number_format($get_balance[0]['total_factura_mar'],2));
        $sheet->setCellValue("E6", "S/".number_format($get_balance[0]['total_factura_abr'],2));
        $sheet->setCellValue("F6", "S/".number_format($get_balance[0]['total_factura_may'],2));
        $sheet->setCellValue("G6", "S/".number_format($get_balance[0]['total_factura_jun'],2));
        $sheet->setCellValue("H6", "S/".number_format($get_balance[0]['total_factura_jul'],2));
        $sheet->setCellValue("I6", "S/".number_format($get_balance[0]['total_factura_ago'],2));
        $sheet->setCellValue("J6", "S/".number_format($get_balance[0]['total_factura_sep'],2));
        $sheet->setCellValue("K6", "S/".number_format($get_balance[0]['total_factura_oct'],2));
        $sheet->setCellValue("L6", "S/".number_format($get_balance[0]['total_factura_nov'],2));
        $sheet->setCellValue("M6", "S/".number_format($get_balance[0]['total_factura_dic'],2));
        $sheet->setCellValue("O6", "S/".number_format($get_balance[0]['total_factura'],2));

        $sheet->setCellValue("A7", 'Notas de Débito');
        $sheet->setCellValue("B7", "S/".number_format($get_balance[0]['total_nota_debito_ene'],2));
        $sheet->setCellValue("C7", "S/".number_format($get_balance[0]['total_nota_debito_feb'],2));
        $sheet->setCellValue("D7", "S/".number_format($get_balance[0]['total_nota_debito_mar'],2));
        $sheet->setCellValue("E7", "S/".number_format($get_balance[0]['total_nota_debito_abr'],2));
        $sheet->setCellValue("F7", "S/".number_format($get_balance[0]['total_nota_debito_may'],2));
        $sheet->setCellValue("G7", "S/".number_format($get_balance[0]['total_nota_debito_jun'],2));
        $sheet->setCellValue("H7", "S/".number_format($get_balance[0]['total_nota_debito_jul'],2));
        $sheet->setCellValue("I7", "S/".number_format($get_balance[0]['total_nota_debito_ago'],2));
        $sheet->setCellValue("J7", "S/".number_format($get_balance[0]['total_nota_debito_sep'],2));
        $sheet->setCellValue("K7", "S/".number_format($get_balance[0]['total_nota_debito_oct'],2));
        $sheet->setCellValue("L7", "S/".number_format($get_balance[0]['total_nota_debito_nov'],2));
        $sheet->setCellValue("M7", "S/".number_format($get_balance[0]['total_nota_debito_dic'],2));
        $sheet->setCellValue("O7", "S/".number_format($get_balance[0]['total_nota_debito'],2));

        $sheet->setCellValue("A8", 'Notas de Crédito');
        $sheet->setCellValue("B8", "S/".number_format($get_balance[0]['total_nota_credito_ene'],2));
        $sheet->setCellValue("C8", "S/".number_format($get_balance[0]['total_nota_credito_feb'],2));
        $sheet->setCellValue("D8", "S/".number_format($get_balance[0]['total_nota_credito_mar'],2));
        $sheet->setCellValue("E8", "S/".number_format($get_balance[0]['total_nota_credito_abr'],2));
        $sheet->setCellValue("F8", "S/".number_format($get_balance[0]['total_nota_credito_may'],2));
        $sheet->setCellValue("G8", "S/".number_format($get_balance[0]['total_nota_credito_jun'],2));
        $sheet->setCellValue("H8", "S/".number_format($get_balance[0]['total_nota_credito_jul'],2));
        $sheet->setCellValue("I8", "S/".number_format($get_balance[0]['total_nota_credito_ago'],2));
        $sheet->setCellValue("J8", "S/".number_format($get_balance[0]['total_nota_credito_sep'],2));
        $sheet->setCellValue("K8", "S/".number_format($get_balance[0]['total_nota_credito_oct'],2));
        $sheet->setCellValue("L8", "S/".number_format($get_balance[0]['total_nota_credito_nov'],2));
        $sheet->setCellValue("M8", "S/".number_format($get_balance[0]['total_nota_credito_dic'],2));
        $sheet->setCellValue("O8", "S/".number_format($get_balance[0]['total_nota_credito'],2)); 

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    } 

    public function Excel_Balance_Boleta($anio,$mes){
        $list_boleta = $this->Model_BabyLeaders->get_list_balance_boleta($anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance (Boletas)');
        
        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Fecha Documento');    
        $sheet->setCellValue("B1", 'Número de Documento');    
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno');
        $sheet->setCellValue("E1", 'Nombre(s)');           
        $sheet->setCellValue("F1", 'Pago');
        $sheet->setCellValue("G1", 'Monto');
        $sheet->setCellValue("H1", 'Fecha Pago');    
        $sheet->setCellValue("I1", 'Tipo Pago');   
        $sheet->setCellValue("J1", 'Operación');          

        $contador=1;

        foreach($list_boleta as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            
            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_documento']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['num_documento']);
            $sheet->setCellValue("C{$contador}", $list['alum_apater']);
            $sheet->setCellValue("D{$contador}", $list['alum_amater']);
            $sheet->setCellValue("E{$contador}", $list['alum_nom']);
            $sheet->setCellValue("F{$contador}", $list['nom_pago']);
            $sheet->setCellValue("G{$contador}", $list['monto']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_pago']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("J{$contador}", $list['operacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance (Boletas)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Balance_Nota_Debito($anio,$mes){
        $list_nota_debito = $this->Model_BabyLeaders->get_list_balance_nota_debito($anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance (Notas de Débito)');
        
        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Fecha Documento');    
        $sheet->setCellValue("B1", 'Número de Documento');    
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno');
        $sheet->setCellValue("E1", 'Nombre(s)');           
        $sheet->setCellValue("F1", 'Pago');
        $sheet->setCellValue("G1", 'Monto');
        $sheet->setCellValue("H1", 'Fecha Pago');    
        $sheet->setCellValue("I1", 'Tipo Pago');   
        $sheet->setCellValue("J1", 'Operación');          

        $contador=1;

        foreach($list_nota_debito as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            
            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_documento']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['num_documento']);
            $sheet->setCellValue("C{$contador}", $list['alum_apater']);
            $sheet->setCellValue("D{$contador}", $list['alum_amater']);
            $sheet->setCellValue("E{$contador}", $list['alum_nom']);
            $sheet->setCellValue("F{$contador}", $list['nom_pago']);
            $sheet->setCellValue("G{$contador}", $list['monto']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_pago']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("J{$contador}", $list['operacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance (Notas de Débito)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Balance_Nota_Credito($anio,$mes){
        $list_nota_credito = $this->Model_BabyLeaders->get_list_balance_nota_credito($anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance (Notas de Crédito)');
        
        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Fecha Documento');    
        $sheet->setCellValue("B1", 'Número de Documento');    
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno');
        $sheet->setCellValue("E1", 'Nombre(s)');           
        $sheet->setCellValue("F1", 'Pago');
        $sheet->setCellValue("G1", 'Monto');
        $sheet->setCellValue("H1", 'Fecha Pago');    
        $sheet->setCellValue("I1", 'Tipo Pago');   
        $sheet->setCellValue("J1", 'Operación');          

        $contador=1;

        foreach($list_nota_credito as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            
            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_documento']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['num_documento']);
            $sheet->setCellValue("C{$contador}", $list['alum_apater']);
            $sheet->setCellValue("D{$contador}", $list['alum_amater']);
            $sheet->setCellValue("E{$contador}", $list['alum_nom']);
            $sheet->setCellValue("F{$contador}", $list['nom_pago']);
            $sheet->setCellValue("G{$contador}", $list['monto']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_pago']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("J{$contador}", $list['operacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance (Notas de Crédito)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Balance_Factura($anio,$mes){
        $list_factura = $this->Model_BabyLeaders->get_list_balance_factura($anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance (Facturas)');
        
        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Fecha Documento');    
        $sheet->setCellValue("B1", 'Número de Documento');    
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno');
        $sheet->setCellValue("E1", 'Nombre(s)');           
        $sheet->setCellValue("F1", 'Pago');
        $sheet->setCellValue("G1", 'Monto');
        $sheet->setCellValue("H1", 'Fecha Pago');    
        $sheet->setCellValue("I1", 'Tipo Pago');   
        $sheet->setCellValue("J1", 'Operación');          

        $contador=1;

        foreach($list_factura as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            
            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_documento']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['num_documento']);
            $sheet->setCellValue("C{$contador}", $list['alum_apater']);
            $sheet->setCellValue("D{$contador}", $list['alum_amater']);
            $sheet->setCellValue("E{$contador}", $list['alum_nom']);
            $sheet->setCellValue("F{$contador}", $list['nom_pago']);
            $sheet->setCellValue("G{$contador}", $list['monto']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fec_pago']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['nom_tipo_pago']);
            $sheet->setCellValue("J{$contador}", $list['operacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance (Facturas)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------C CONTRATO-------------------------------------------
    public function C_Contrato() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/c_contrato/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_C_Contrato() {
        if ($this->session->userdata('usuario')) {
            $dato['list_c_contrato'] = $this->Model_BabyLeaders->get_list_c_contrato();
            $this->load->view('view_BL/c_contrato/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_C_Contrato(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_mes'] = $this->Model_BabyLeaders->get_list_mes();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_contrato();
            $this->load->view('view_BL/c_contrato/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Contrato_I() {
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_seccion']= "id_seccion_i";
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_contrato($dato['id_grado']);
            $this->load->view('view_BL/c_contrato/seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_C_Contrato(){
        $dato['tipo']= $this->input->post("tipo_i");
        $dato['referencia']= $this->input->post("referencia_i");
        $dato['mes_anio']= $this->input->post("mes_anio_i");
        $dato['fecha_envio']= $this->input->post("fecha_envio_i");
        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['asunto']= $this->input->post("asunto_i");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['id_seccion']= $this->input->post("id_seccion_i");
        $dato['texto_correo']= $this->input->post("texto_correo_i");
        $dato['sms']= $this->input->post("sms_i");
        $dato['texto_sms']= $this->input->post("texto_sms_i");
        $dato['documento']= ""; 

        $cantidad = $this->Model_BabyLeaders->ultimo_id_c_contrato();
        $cantidad = count($cantidad)+1; 

        if($_FILES["documento_i"]["name"] != ""){
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_i"]["name"]);
            $config['upload_path'] = './documento_contrato/'.$cantidad;
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_contrato/', 0777);
                chmod('./documento_contrato/'.$cantidad, 0777);
            }
            $config["allowed_types"] = 'pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["documento_i"]["name"];
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["documento_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["documento_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["documento_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["documento_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['documento'] = "documento_contrato/".$cantidad."/".$dato['nom_documento'];
            }     
        }

        $this->Model_BabyLeaders->insert_c_contrato($dato);
    }

    public function Modal_Update_C_Contrato($id_c_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_c_contrato($id_c_contrato);
            $dato['list_anio'] = $this->Model_BabyLeaders->get_list_anio();
            $dato['list_mes'] = $this->Model_BabyLeaders->get_list_mes();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_contrato();
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_contrato($dato['get_id'][0]['id_grado']);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/c_contrato/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Contrato_U() {
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_seccion']= "id_seccion_u";
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_contrato($dato['id_grado']);
            $this->load->view('view_BL/c_contrato/seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_C_Contrato(){ 
        $dato['id_c_contrato']= $this->input->post("id_c_contrato"); 
        $dato['tipo']= $this->input->post("tipo_u");
        $dato['referencia']= $this->input->post("referencia_u");
        $dato['mes_anio']= $this->input->post("mes_anio_u");
        $dato['fecha_envio']= $this->input->post("fecha_envio_u");
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['asunto']= $this->input->post("asunto_u");
        $dato['id_grado']= $this->input->post("id_grado_u");
        $dato['id_seccion']= $this->input->post("id_seccion_u");
        $dato['texto_correo']= $this->input->post("texto_correo_u");
        $dato['sms']= $this->input->post("sms_u");
        $dato['texto_sms']= $this->input->post("texto_sms_u");
        $dato['documento']= $this->input->post("documento_actual");
        $dato['estado']= $this->input->post("estado_u");

        if($_FILES["documento_u"]["name"] != ""){
            if (file_exists($dato['documento'])) { 
                unlink($dato['documento']);
            }

            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_u"]["name"]);
            $config['upload_path'] = './documento_contrato/'.$dato['id_c_contrato'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_contrato/', 0777);
                chmod('./documento_contrato/'.$dato['id_c_contrato'], 0777);
            }
            $config["allowed_types"] = 'pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["documento_u"]["name"];
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["documento_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["documento_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["documento_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["documento_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['documento'] = "documento_contrato/".$dato['id_c_contrato']."/".$dato['nom_documento'];
            }     
        }

        $this->Model_BabyLeaders->update_c_contrato($dato); 
    }

    public function Delete_C_Contrato(){ 
        $dato['id_c_contrato']= $this->input->post("id_c_contrato");
        $this->Model_BabyLeaders->delete_c_contrato($dato); 
    }

    public function Excel_C_Contrato(){ 
        $list_c_contrato = $this->Model_BabyLeaders->get_list_c_contrato();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Contrato');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
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
          
        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Ref');
        $sheet->setCellValue("C1", 'Mes/Año');
        $sheet->setCellValue("D1", 'Descripción');
        $sheet->setCellValue("E1", 'Asunto');
        $sheet->setCellValue("F1", 'Texto Correo');
        $sheet->setCellValue("G1", 'Documento');
        $sheet->setCellValue("H1", 'Enviados');
        $sheet->setCellValue("I1", 'Firmados');
        $sheet->setCellValue("J1", 'Por Firmar');
        $sheet->setCellValue("K1", 'Estado'); 

        $contador=1;
        
        foreach($list_c_contrato as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['tipo']);
            $sheet->setCellValue("B{$contador}", $list['referencia']);
            $sheet->setCellValue("C{$contador}", $list['mes_anio']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['asunto']);
            $sheet->setCellValue("F{$contador}", $list['texto_correo']);
            $sheet->setCellValue("G{$contador}", $list['documento']);
            $sheet->setCellValue("H{$contador}", $list['enviados']);
            $sheet->setCellValue("I{$contador}", $list['firmados']);
            $sheet->setCellValue("J{$contador}", $list['por_firmar']);
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

    public function Descargar_C_Contrato($id_c_contrato) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_list_c_contrato($id_c_contrato);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }
        else{
            redirect('');
        }
    }
    //---------------------------------------CONTRATO-----------------------------------------
    public function Contrato() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/contrato/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Contrato() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_nuevos'] = $this->Model_BabyLeaders->get_list_contrato($dato['tipo']);
            $this->load->view('view_BL/contrato/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Actualizar_Lista_Contrato() {  
        //ENVIO DE CORREOS Y SMS
 
        include "mcript.php";
        include('application/views/administrador/mensaje/httpPHPAltiria.php');

        $list_contrato = $this->Model_BabyLeaders->get_contratos_activos();

        foreach($list_contrato as $get_contrato){
            $list_apoderados = $this->Model_BabyLeaders->get_contrato_apoderados($get_contrato['id_grado'],$get_contrato['id_seccion']);

            if($get_contrato['tipo']==5){
                if($get_contrato['fecha_envio']==date('Y-m-d')){
                    foreach($list_apoderados as $list){
                        $valida = $this->Model_BabyLeaders->valida_envio_correo_contrato($list['Id_Alumno'],$list['Id'],$get_contrato['id_c_contrato']);
        
                        if(count($valida)==0){
                            $dato['id_alumno'] = $list['Id_Alumno'];
                            $dato['cod_alumno'] = $list['cod_alumno'];
                            $dato['apater_alumno'] = $list['apater_alumno'];
                            $dato['amater_alumno'] = $list['amater_alumno'];
                            $dato['nom_alumno'] = $list['nom_alumno'];
                            $dato['grado_alumno'] = $list['grado_alumno'];
                            $dato['seccion_alumno'] = $list['seccion_alumno'];
                            $dato['id_apoderado']= $list['Id'];
                            $dato['apater_apoderado'] = $list['Apellido_Paterno'];
                            $dato['amater_apoderado'] = $list['Apellido_Materno'];
                            $dato['nom_apoderado'] = $list['Nombre'];
                            $dato['parentesco_apoderado'] = $list['Parentesco'];
                            $dato['email_apoderado'] = $list['Email'];
                            $dato['celular_apoderado'] = $list['Celular'];
                            $dato['id_contrato'] = $get_contrato['id_c_contrato'];
                    
                            $this->Model_BabyLeaders->insert_documento_firma($dato);
                            $ultimo = $this->Model_BabyLeaders->ultimo_id_documento_firma();

                            $encryption_id = $encriptar($ultimo[0]['id_documento_firma']);
        
                            $mail = new PHPMailer(true);
                            $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_bl/".$encryption_id;
                            
                            try {
                                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                                $mail->isSMTP();                                            // Send using SMTP
                                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
                                $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
                                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia
                                
                                $mail->addAddress($list['Email']);
                                
                                $mail->isHTML(true);                                  // Set email format to HTML
                        
                                $mail->Subject = $get_contrato['asunto'];
                        
                                $mail->Body =  '<FONT SIZE=3>'.nl2br($get_contrato['texto_correo']).'<br><br>
                                                            Ingrese al link:'.$link.'
                                                </FONT SIZE>';
                        
                                $mail->CharSet = 'UTF-8';
                                $mail->send();
                        
                            } catch (Exception $e) {
                                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                            }
        
                            if($get_contrato['sms']==1){
                                $altiriaSMS = new AltiriaSMS();
            
                                $altiriaSMS->setDebug(true);
                                $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                                $altiriaSMS->setPassword('gllg2021');
                            
                                $sDestination = '51'.$list['Celular'];
                                $sMessage = $get_contrato['texto_sms'];
                                $altiriaSMS->sendSMS($sDestination, $sMessage);
                            }
                        }
                    }
                }
            }else{
                foreach($list_apoderados as $list){
                    $valida = $this->Model_BabyLeaders->valida_envio_correo_contrato($list['Id_Alumno'],$list['Id'],$get_contrato['id_c_contrato']);
    
                    if(count($valida)==0){
                        $dato['id_alumno'] = $list['Id_Alumno'];
                        $dato['cod_alumno'] = $list['cod_alumno'];
                        $dato['apater_alumno'] = $list['apater_alumno'];
                        $dato['amater_alumno'] = $list['amater_alumno'];
                        $dato['nom_alumno'] = $list['nom_alumno'];
                        $dato['grado_alumno'] = $list['grado_alumno'];
                        $dato['seccion_alumno'] = $list['seccion_alumno'];
                        $dato['id_apoderado']= $list['Id'];
                        $dato['apater_apoderado'] = $list['Apellido_Paterno'];
                        $dato['amater_apoderado'] = $list['Apellido_Materno'];
                        $dato['nom_apoderado'] = $list['Nombre'];
                        $dato['parentesco_apoderado'] = $list['Parentesco'];
                        $dato['email_apoderado'] = $list['Email'];
                        $dato['celular_apoderado'] = $list['Celular'];
                        $dato['id_contrato'] = $get_contrato['id_c_contrato'];
                
                        $this->Model_BabyLeaders->insert_documento_firma($dato);
                        $ultimo = $this->Model_BabyLeaders->ultimo_id_documento_firma();

                        $encryption_id = $encriptar($ultimo[0]['id_documento_firma']);
    
                        $mail = new PHPMailer(true);
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_bl/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia
                            
                            $mail->addAddress($list['Email']);
                            
                            $mail->isHTML(true);                                  // Set email format to HTML
                    
                            $mail->Subject = $get_contrato['asunto'];
                    
                            $mail->Body =  '<FONT SIZE=3>'.nl2br($get_contrato['texto_correo']).'<br><br>
                                                        Ingrese al link:'.$link.'
                                            </FONT SIZE>';
                    
                            $mail->CharSet = 'UTF-8';
                            $mail->send();
                    
                        } catch (Exception $e) {
                            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                        }
    
                        if($get_contrato['sms']==1){
                            $altiriaSMS = new AltiriaSMS();
        
                            $altiriaSMS->setDebug(true);
                            $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                            $altiriaSMS->setPassword('gllg2021');
                        
                            $sDestination = '51'.$list['Celular'];
                            $sMessage = $get_contrato['texto_sms'];
                            $altiriaSMS->sendSMS($sDestination, $sMessage);
                        }
                    }
                }
            }
        }
    }

    public function Modal_Update_Email_Contrato($id_documento_firma) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_contrato($id_documento_firma);
            $this->load->view('view_BL/contrato/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Email_Contrato(){
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $dato['email_apoderado']= $this->input->post("email_apoderado_u");
        $this->Model_BabyLeaders->update_email_contrato($dato); 
    }

    public function Reenviar_Email(){  
        include "mcript.php";

        $dato['id_documento_firma'] = $this->input->post("id_documento_firma");
        $get_id = $this->Model_BabyLeaders->get_id_contrato($dato['id_documento_firma']);
        $get_correo = $this->Model_BabyLeaders->get_list_c_contrato($get_id[0]['id_contrato']);

        $this->Model_BabyLeaders->update_documento_firma($dato);
        
        $encryption_id = $encriptar($get_id[0]['id_documento_firma']);

        $mail = new PHPMailer(true);
        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_bl/".$encryption_id;
        
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
            $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia 
            
            $mail->addAddress($get_id[0]['email_apoderado']);
            
            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = $get_correo[0]['asunto'];
    
            $mail->Body =  '<FONT SIZE=3>'.nl2br($get_correo[0]['texto_correo']).'<br><br>
                                        Ingrese al link:'.$link.'
                            </FONT SIZE>';
    
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function Delete_Contrato(){ 
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $this->Model_BabyLeaders->delete_documento_firma($dato); 
    }

    public function Excel_Contrato($tipo){
        $list_nuevos = $this->Model_BabyLeaders->get_list_contrato($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Contrato');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30); 
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(35);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(18); 
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

        $sheet->setCellValue("A1", 'Contrato');             
        $sheet->setCellValue("B1", 'Código');  
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno');     
        $sheet->setCellValue("E1", 'Nombre(s)');        
        $sheet->setCellValue("F1", 'Apoderado');             
        $sheet->setCellValue("G1", 'Parentesco');  
        $sheet->setCellValue("H1", 'Email'); 
        $sheet->setCellValue("I1", 'Celular'); 
        $sheet->setCellValue("J1", 'Fecha Envío');
        $sheet->setCellValue("K1", 'Fecha Firma');     
        $sheet->setCellValue("L1", 'Status');           

        $contador=1;
        
        foreach($list_nuevos as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['referencia']);
            $sheet->setCellValue("B{$contador}", $list['cod_alumno']);
            $sheet->setCellValue("C{$contador}", $list['apater_alumno']);
            $sheet->setCellValue("D{$contador}", $list['amater_alumno']);
            $sheet->setCellValue("E{$contador}", $list['nom_alumno']);
            $sheet->setCellValue("F{$contador}", $list['nom_apoderado']);
            $sheet->setCellValue("G{$contador}", $list['parentesco_apoderado']);
            $sheet->setCellValue("H{$contador}", $list['email_apoderado']);
            $sheet->setCellValue("I{$contador}", $list['celular_apoderado']);
            if($list['fec_envio']!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fec_envio']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("J{$contador}", "");  
            }
            if($list['fec_firma']!=""){
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['fec_firma']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("K{$contador}", "");  
            }
            $sheet->setCellValue("L{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Contrato (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------PAGAMENTO-------------------------------------------
    public function Pagamento() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/pagamento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Pagamento() { 
        if ($this->session->userdata('usuario')) {
            $dato['list_pagamento'] = $this->Model_BabyLeaders->get_list_pagamento();
            $this->load->view('view_BL/pagamento/lista',$dato);
        }else{
            redirect('/login');
        }
    } 

    public function Excel_Pagamento(){ 
        $list_pagamento = $this->Model_BabyLeaders->get_list_pagamento();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); 

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Pagos');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(18);

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
          
        $sheet->setCellValue("A1", 'Año');
        $sheet->setCellValue("B1", 'Producto');
        $sheet->setCellValue("C1", 'Pendientes');
        $sheet->setCellValue("D1", 'Total por Cancelar');
        $sheet->setCellValue("E1", 'Pagos');
        $sheet->setCellValue("F1", 'Total Cancelado');
        $sheet->setCellValue("G1", 'Total Descuentos');
        $sheet->setCellValue("H1", 'Total Penalización');
        $sheet->setCellValue("I1", 'SUB-TOTAL');

        $contador=1;
        
        foreach($list_pagamento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("F{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("F{$contador}:I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['anio']);
            $sheet->setCellValue("B{$contador}", $list['nom_producto']);
            $sheet->setCellValue("C{$contador}", $list['pendientes']);
            $sheet->setCellValue("D{$contador}", $list['total_pendientes']);
            $sheet->setCellValue("E{$contador}", $list['pagos']);
            $sheet->setCellValue("F{$contador}", $list['total_pagos_monto']);
            $sheet->setCellValue("G{$contador}", $list['total_pagos_descuento']);
            $sheet->setCellValue("H{$contador}", $list['total_pagos_penalidad']);
            $sheet->setCellValue("I{$contador}", $list['total_pagos']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pagos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Pagamento($id_producto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_producto($id_producto);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/pagamento/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Pagamento() {
        if ($this->session->userdata('usuario')) {
            $dato['id_producto']= $this->input->post("id_producto");
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_detalle_pagamento'] = $this->Model_BabyLeaders->get_list_detalle_pagamento($dato['id_producto'],$dato['tipo']);
            $this->load->view('view_BL/pagamento/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Pagamento($id_producto,$tipo){ 
        $list_detalle_pagamento = $this->Model_BabyLeaders->get_list_detalle_pagamento($id_producto,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); 

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Pagos');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
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
          
        $sheet->setCellValue("A1", 'Apellido Paterno');
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Grado');
        $sheet->setCellValue("F1", 'Sección');
        $sheet->setCellValue("G1", 'Descripción');
        $sheet->setCellValue("H1", 'Monto'); 
        $sheet->setCellValue("I1", 'Descuento');
        $sheet->setCellValue("J1", 'Penalidad');
        $sheet->setCellValue("K1", 'Total');
        $sheet->setCellValue("L1", 'Fecha Pago');
        $sheet->setCellValue("M1", 'Recibo');

        $contador=1;
        
        foreach($list_detalle_pagamento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("H{$contador}:K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['alum_apater']);
            $sheet->setCellValue("B{$contador}", $list['alum_amater']);
            $sheet->setCellValue("C{$contador}", $list['alum_nom']);
            $sheet->setCellValue("D{$contador}", $list['cod_alum']);
            $sheet->setCellValue("E{$contador}", $list['nom_grado']);
            $sheet->setCellValue("F{$contador}", $list['nom_seccion']);
            $sheet->setCellValue("G{$contador}", $list['nom_pago']);
            $sheet->setCellValue("H{$contador}", $list['monto']);
            $sheet->setCellValue("I{$contador}", $list['descuento']);
            $sheet->setCellValue("J{$contador}", $list['penalidad']);
            $sheet->setCellValue("K{$contador}", $list['total']);
            if($list['fec_pago']!=""){
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fec_pago']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("L{$contador}", "");  
            }
            $sheet->setCellValue("M{$contador}", $list['recibo']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle Pagos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //-------------------------------------------------ASISTENCIA COLABORADOR----------------------------------
    public function Asistencia_Colaborador(){
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/asistencia_colaborador/index', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Asistencia_Colaborador_Lista(){
        if ($this->session->userdata('usuario')) {
            $fec_in = $this->input->post("fec_in");
            $fec_fi = $this->input->post("fec_fi");
            $tipo = $this->input->post("tipo");

            $dato['list_registro_ingreso'] = $this->Model_BabyLeaders->get_list_registro_ingreso_c($fec_in,$fec_fi,$tipo);
                        
            $this->load->view('view_BL/asistencia_colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Historial_Registro_Ingreso($id_registro_ingreso){
        if ($this->session->userdata('usuario')) {
            $dato['list_historico_ingreso'] = $this->Model_BabyLeaders->get_list_historial_registro_ingreso($id_registro_ingreso); 
            $this->load->view('view_BL/asistencia_colaborador/modal_historial', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Asistencia_Colaborador($fec_in,$fec_fi){     
        $fec_in = substr($fec_in,0,4)."-".substr($fec_in,4,2)."-".substr($fec_in,-2);
        $fec_fi = substr($fec_fi,0,4)."-".substr($fec_fi,4,2)."-".substr($fec_fi,-2);

        $list_registro_ingreso = $this->Model_BabyLeaders->get_list_registro_ingreso_c($fec_in,$fec_fi);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia');

        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(60);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(18);

        $sheet->getStyle('A1:O1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:O1")->getFill()
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

        $sheet->setCellValue("A1", 'Fecha');             
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'Apellido Paterno');
        $sheet->setCellValue("D1", 'Apellido Materno'); 
        $sheet->setCellValue("E1", 'Nombre(s)'); 
        $sheet->setCellValue("F1", 'Usuario');
        $sheet->setCellValue("G1", 'Estado'); 
        $sheet->setCellValue("H1", 'Registro'); 
        $sheet->setCellValue("I1", 'Usuario');
        $sheet->setCellValue("J1", 'Hora');
        $sheet->setCellValue("K1", 'Registro');
        $sheet->setCellValue("L1", 'Observaciones');
        $sheet->setCellValue("M1", 'Observación');
        $sheet->setCellValue("N1", 'Autorización');
        $sheet->setCellValue("O1", 'Hora Salida');

        $contador=1;
        
        foreach($list_registro_ingreso as $list){  
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha_ingreso']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['codigo']);
            $sheet->setCellValue("C{$contador}", $list['apater']);
            $sheet->setCellValue("D{$contador}", $list['amater']);
            $sheet->setCellValue("E{$contador}", $list['nombres']);
            $sheet->setCellValue("F{$contador}", $list['nom_tipo_acceso']);
            $sheet->setCellValue("G{$contador}", $list['nom_estado_reporte']);
            $sheet->setCellValue("H{$contador}", $list['reg_automatico']);
            $sheet->setCellValue("I{$contador}", $list['usuario_registro']);
            $sheet->setCellValue("J{$contador}", $list['hora_ingreso']);
            $sheet->setCellValue("K{$contador}", $list['estado_ing']);
            $sheet->setCellValue("L{$contador}", $list['obs']);
            $sheet->setCellValue("M{$contador}", $list['obs_historial']);
            $sheet->setCellValue("N{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("O{$contador}", $list['hora_salida']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Delete_Registro_Ingreso_Lista(){
        $dato['id_registro_ingreso']= $this->input->post("id_registro_ingreso");
        $this->Model_BabyLeaders->delete_registro_ingreso_lista($dato);
    }

    //---------------------------------------SALÓN-----------------------------------------
    public function Salon() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_salon'] = $this->Model_BabyLeaders->get_list_salon();

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
        $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

        $this->load->view('view_BL/salon/index',$dato);
    }

    public function Registrar_Salon(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_salon'] = $this->Model_BabyLeaders->get_list_tipo_salon();
            $dato['list_especialidad'] = $this->Model_BabyLeaders->get_list_especialidad_combo();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();
            $this->load->view('view_BL/salon/registrar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Salon(){
        $dato['id_tipo_salon']= $this->input->post("id_tipo_salon_i");
        $dato['planta']= $this->input->post("planta_i");  
        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['referencia']= $this->input->post("referencia_i");
        $dato['ae']= $this->input->post("AE_i");
        $dato['cf']= $this->input->post("CF_i");
        $dato['ds']= $this->input->post("DS_i");
        $dato['et']= $this->input->post("ET_i");
        $dato['ft']= $this->input->post("FT_i");
        $dato['capacidad']= $this->input->post("capacidad_i");  
        $dato['disponible']= $this->input->post("disponible_i");
        $dato['pintura']= $this->input->post("pintura_i");  
        $dato['chapa']= $this->input->post("chapa_i");
        $dato['pizarra']= $this->input->post("pizarra_i");  
        $dato['proyector']= $this->input->post("proyector_i");
        $dato['puerta']= $this->input->post("puerta_i");  
        $dato['tacho']= $this->input->post("tacho_i");
        $dato['cortina']= $this->input->post("cortina_i");  
        $dato['iluminacion']= $this->input->post("iluminacion_i");
        $dato['mueble']= $this->input->post("mueble_i");  
        $dato['mesa_profesor']= $this->input->post("mesa_profesor_i");
        $dato['enchufe']= $this->input->post("enchufe_i");  
        $dato['computadora']= $this->input->post("computadora_i");
        $dato['silla_profesor']= $this->input->post("silla_profesor_i");  
        $dato['observaciones']= $this->input->post("observaciones_i");

        $total=count($this->Model_BabyLeaders->valida_insert_salon($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_salon($dato);
        }
    }

    public function Editar_Salon($id_salon){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_salon($id_salon);
            $dato['list_tipo_salon'] = $this->Model_BabyLeaders->get_list_tipo_salon();
            $dato['list_especialidad'] = $this->Model_BabyLeaders->get_list_especialidad_combo();

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/salon/editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Salon(){
        $dato['id_salon']= $this->input->post("id_salon");
        $dato['id_tipo_salon']= $this->input->post("id_tipo_salon_u");
        $dato['planta']= $this->input->post("planta_u");  
        $dato['referencia']= $this->input->post("referencia_u");
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['ae']= $this->input->post("AE_u");
        $dato['cf']= $this->input->post("CF_u");
        $dato['ds']= $this->input->post("DS_u");
        $dato['et']= $this->input->post("ET_u");
        $dato['ft']= $this->input->post("FT_u");
        $dato['capacidad']= $this->input->post("capacidad_u");  
        $dato['disponible']= $this->input->post("disponible_u");
        $dato['pintura']= $this->input->post("pintura_u");  
        $dato['chapa']= $this->input->post("chapa_u");
        $dato['pizarra']= $this->input->post("pizarra_u");  
        $dato['proyector']= $this->input->post("proyector_u");
        $dato['puerta']= $this->input->post("puerta_u");  
        $dato['tacho']= $this->input->post("tacho_u");
        $dato['cortina']= $this->input->post("cortina_u");  
        $dato['iluminacion']= $this->input->post("iluminacion_u");
        $dato['mueble']= $this->input->post("mueble_u");  
        $dato['mesa_profesor']= $this->input->post("mesa_profesor_u");
        $dato['enchufe']= $this->input->post("enchufe_u");  
        $dato['computadora']= $this->input->post("computadora_u");
        $dato['silla_profesor']= $this->input->post("silla_profesor_u");  
        $dato['observaciones']= $this->input->post("observaciones_u");
        $dato['estado_salon']= $this->input->post("estado_salon_u");  

        $total=count($this->Model_BabyLeaders->valida_update_salon($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_salon($dato);
        }
    }

    public function Delete_Salon(){
        $dato['id_salon']= $this->input->post("id_salon");
        $this->Model_BabyLeaders->delete_salon($dato);
    }

    public function Excel_Salon(){
        $list_salon = $this->Model_BabyLeaders->get_list_salon();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Z1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Z1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Salones');

        $sheet->setAutoFilter('A1:Z1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(30);
        $sheet->getColumnDimension('R')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(30);
        $sheet->getColumnDimension('T')->setWidth(30);
        $sheet->getColumnDimension('U')->setWidth(30);
        $sheet->getColumnDimension('V')->setWidth(30);
        $sheet->getColumnDimension('W')->setWidth(30);
        $sheet->getColumnDimension('X')->setWidth(30);
        $sheet->getColumnDimension('Y')->setWidth(15);
        $sheet->getColumnDimension('Z')->setWidth(50);

        $sheet->getStyle('A1:Z1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:Z1")->getFill()
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

        $sheet->getStyle("A1:Z1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Planta');
        $sheet->setCellValue("B1", 'Referencia'); 
        $sheet->setCellValue("C1", 'Tipo');        
        $sheet->setCellValue("D1", 'Descripción');                    
        $sheet->setCellValue("E1", 'AE');
        $sheet->setCellValue("F1", 'CF');             
        $sheet->setCellValue("G1", 'DS');
        $sheet->setCellValue("H1", 'ET');             
        $sheet->setCellValue("I1", 'FT');
        $sheet->setCellValue("J1", 'Capacidad');             
        $sheet->setCellValue("K1", 'Disponible');
        $sheet->setCellValue("L1", 'Pintura');             
        $sheet->setCellValue("M1", 'Chapa');
        $sheet->setCellValue("N1", 'Pizarra');             
        $sheet->setCellValue("O1", 'Proyector');
        $sheet->setCellValue("P1", 'Puerta');             
        $sheet->setCellValue("Q1", 'Tacho');
        $sheet->setCellValue("R1", 'Cortinas');             
        $sheet->setCellValue("S1", 'Iluminación');
        $sheet->setCellValue("T1", 'Mueble');             
        $sheet->setCellValue("U1", 'Mesa Profesor');
        $sheet->setCellValue("V1", 'Enchufes');             
        $sheet->setCellValue("W1", 'Computadora');
        $sheet->setCellValue("X1", 'Silla Profesor');             
        $sheet->setCellValue("Y1", 'Estado');
        $sheet->setCellValue("Z1", 'Observaciones');

        $contador=1;
        
        foreach($list_salon as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:Z{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:X{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Z{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Z{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Z{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['planta']); 
            $sheet->setCellValue("B{$contador}", $list['referencia']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo_salon']);
            $sheet->setCellValue("D{$contador}", $list['descripcion']);
            $sheet->setCellValue("E{$contador}", $list['ae']);
            $sheet->setCellValue("F{$contador}", $list['cf']);
            $sheet->setCellValue("G{$contador}", $list['ds']);
            $sheet->setCellValue("H{$contador}", $list['et']);
            $sheet->setCellValue("I{$contador}", $list['ft']);
            $sheet->setCellValue("J{$contador}", $list['capacidad']);
            $sheet->setCellValue("K{$contador}", $list['disponible']);
            $sheet->setCellValue("L{$contador}", $list['pintura']);
            $sheet->setCellValue("M{$contador}", $list['chapa']);
            $sheet->setCellValue("N{$contador}", $list['pizarra']);
            $sheet->setCellValue("O{$contador}", $list['proyector']);
            $sheet->setCellValue("P{$contador}", $list['puerta']);
            $sheet->setCellValue("Q{$contador}", $list['tacho']);
            $sheet->setCellValue("R{$contador}", $list['cortina']);
            $sheet->setCellValue("S{$contador}", $list['iluminacion']);
            $sheet->setCellValue("T{$contador}", $list['mueble']);
            $sheet->setCellValue("U{$contador}", $list['mesa_profesor']);
            $sheet->setCellValue("V{$contador}", $list['enchufe']);
            $sheet->setCellValue("W{$contador}", $list['computadora']);
            $sheet->setCellValue("X{$contador}", $list['silla_profesor']);
            $sheet->setCellValue("Y{$contador}", $list['estado_salon']);
            $sheet->setCellValue("Z{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Salones BL (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------MAILING-------------------------------------------
    public function Mailing() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/mailing/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['list_mailing'] = $this->Model_BabyLeaders->get_list_mailing();
            $this->load->view('view_BL/mailing/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mailing(){
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_alumno_mailing();
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_mailing();
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/mailing/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['nom_grado'] = $this->input->post("grado");
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_mailing($dato['nom_grado']);
            $this->load->view('view_BL/mailing/seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Mailing(){
        if ($this->session->userdata('usuario')) {
            $dato['codigo']= $this->input->post("codigo_i");
            $dato['alumno']= $this->input->post("alumno_i");
            $dato['grado']= $this->input->post("grado_i");
            $dato['seccion']= $this->input->post("seccion_i");
            $dato['tipo_envio']= $this->input->post("tipo_envio_i");
            $dato['fecha_envio']= $this->input->post("fecha_envio_i");
            $dato['titulo']= $this->input->post("titulo_i");
            $dato['texto']= $this->input->post("texto_i");
            $dato['documento']= ""; 
            $dato['estado_m']= $this->input->post("estado_m_i");

            $cantidad = $this->Model_BabyLeaders->get_cantidad_mailing();
            $cantidad = $cantidad[0]['cantidad']+1; 

            if($_FILES["documento_i"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_i"]["name"]);
                $config['upload_path'] = './documento_mailing/'.$cantidad;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_mailing/', 0777);
                    chmod('./documento_mailing/'.$cantidad, 0777);
                }
                $config["allowed_types"] = 'pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["documento_i"]["name"];
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["documento_i"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["documento_i"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["documento_i"]["error"];
                $_FILES["file"]["size"] = $_FILES["documento_i"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['documento'] = "documento_mailing/".$cantidad."/".$dato['nom_documento'];
                }     
            }

            $this->Model_BabyLeaders->insert_mailing($dato);
            $ultimo = $this->Model_BabyLeaders->ultimo_id_mailing();
            $dato['id_mailing'] = $ultimo[0]['id_mailing'];

            if($dato['alumno']!=1){
                if(!is_null($this->input->post("id_alumno_i"))){
                    foreach($this->input->post("id_alumno_i") as $id_alumno){
                        $dato['id_alumno'] = $id_alumno;
                        $this->Model_BabyLeaders->insert_envio_mailing($dato);
                    }
                }
            }
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Mailing($id_mailing){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_mailing($id_mailing);
            $dato['list_alumno'] = $this->Model_BabyLeaders->get_list_alumno_mailing();
            $dato['list_envio'] = $this->Model_BabyLeaders->get_list_envio_mailing($id_mailing);
            $dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_mailing();
            $dato['list_seccion'] = $this->Model_BabyLeaders->get_list_seccion_mailing($dato['get_id'][0]['grado']);
            $dato['list_estado'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/mailing/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Mailing(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $dato['codigo']= $this->input->post("codigo_u");
            $dato['alumno']= $this->input->post("alumno_u");
            $dato['grado']= $this->input->post("grado_u");
            $dato['seccion']= $this->input->post("seccion_u");
            $dato['tipo_envio']= $this->input->post("tipo_envio_u");
            $dato['fecha_envio']= $this->input->post("fecha_envio_u");
            $dato['titulo']= $this->input->post("titulo_u");
            $dato['texto']= $this->input->post("texto_u");
            $dato['documento']= $this->input->post("documento_actual");
            $dato['estado_m']= $this->input->post("estado_m_u");

            if($_FILES["documento_u"]["name"] != ""){
                if (file_exists($dato['documento'])) { 
                    unlink($dato['documento']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_u"]["name"]);
                $config['upload_path'] = './documento_mailing/'.$dato['id_mailing'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_mailing/', 0777);
                    chmod('./documento_mailing/'.$dato['id_mailing'], 0777);
                }
                $config["allowed_types"] = 'pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["documento_u"]["name"];
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["documento_u"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["documento_u"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["documento_u"]["error"];
                $_FILES["file"]["size"] = $_FILES["documento_u"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['documento'] = "documento_mailing/".$dato['id_mailing']."/".$dato['nom_documento'];
                }     
            }

            $this->Model_BabyLeaders->update_mailing($dato);

            if($dato['alumno']!=1){
                if(!is_null($this->input->post("id_alumno_u"))){
                    $this->Model_BabyLeaders->delete_envio_mailing($dato);

                    foreach($this->input->post("id_alumno_u") as $id_alumno){
                        $dato['id_alumno'] = $id_alumno;
                        $this->Model_BabyLeaders->insert_envio_mailing($dato);
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Actualizar_Lista_Mailing() {  
        if ($this->session->userdata('usuario')) {
            $list_mailing = $this->Model_BabyLeaders->get_mailing_activos();

            foreach($list_mailing as $list){
                $dato['id_mailing'] = $list['id_mailing'];

                $list_alumno = $this->Model_BabyLeaders->get_datos_alumno_mailing($dato['id_mailing']);

                foreach($list_alumno as $get_alumno){
                    $dato['id_alumno'] = $get_alumno['id_alumno'];
                    $dato['cod_alumno'] = $get_alumno['cod_alumno'];
                    $dato['apater_alumno'] = $get_alumno['apater_alumno'];
                    $dato['amater_alumno'] = $get_alumno['amater_alumno'];
                    $dato['nom_alumno'] = $get_alumno['nom_alumno'];
                    $dato['email_alumno'] = $get_alumno['email_alumno'];
                    $dato['celular_alumno'] = $get_alumno['celular_alumno'];
                    $dato['grado_alumno'] = $get_alumno['grado_alumno'];
                    $dato['seccion_alumno'] = $get_alumno['seccion_alumno'];
                    $dato['id_apoderado'] = $get_alumno['id_apoderado'];
                    $dato['apater_apoderado'] = $get_alumno['apater_apoderado'];
                    $dato['amater_apoderado'] = $get_alumno['amater_apoderado'];
                    $dato['nom_apoderado'] = $get_alumno['nom_apoderado'];
                    $dato['parentesco_apoderado'] = $get_alumno['parentesco_apoderado'];
                    $dato['email_apoderado'] = $get_alumno['email_apoderado'];
                    $dato['celular_apoderado'] = $get_alumno['celular_apoderado'];

                    $mail = new PHPMailer(true);
                    
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia
                        
                        $mail->addAddress($get_alumno['email_apoderado']);
                        
                        $mail->isHTML(true);                                  // Set email format to HTML
                
                        $mail->Subject = $list['titulo'];
                
                        $mail->Body =  '<FONT SIZE=3>'.nl2br($list['texto']).'
                                        </FONT SIZE>';
                
                        $mail->CharSet = 'UTF-8';
                        if($list['documento']!=""){
                            $mail->addAttachment($list['documento']);
                        }
                        $mail->send();

                        $this->Model_BabyLeaders->insert_detalle_mailing($dato);
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    } 
                }

                $this->Model_BabyLeaders->update_enviado_mailing($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Descargar_Mailing($id_mailing) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_BabyLeaders->get_list_mailing($id_mailing);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }else{
            redirect('');
        }
    }

    public function Delete_Mailing(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $this->Model_BabyLeaders->delete_mailing($dato); 
        }else{
            redirect('');
        }
    }

    public function Excel_Mailing(){
        $list_mailing = $this->Model_BabyLeaders->get_list_mailing();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mailing');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(80);
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
        $sheet->setCellValue("B1", 'Tipo Envío'); 
        $sheet->setCellValue("C1", 'Fecha Envío'); 
        $sheet->setCellValue("D1", 'Título');        
        $sheet->setCellValue("E1", 'Texto');                    
        $sheet->setCellValue("F1", 'Documento');          
        $sheet->setCellValue("G1", 'Estado');

        $contador=1;
        
        foreach($list_mailing as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo']); 
            $sheet->setCellValue("B{$contador}", $list['nom_tipo_envio']);
            if($list['fecha_envio']!=""){
                $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fecha_envio']));
                $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("D{$contador}", $list['titulo']);
            $sheet->setCellValue("E{$contador}", $list['texto']);
            $sheet->setCellValue("F{$contador}", $list['v_documento']);
            $sheet->setCellValue("G{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Mailing (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Mailing($id_mailing) {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_mailing($id_mailing);

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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/mailing/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $dato['list_detalle'] = $this->Model_BabyLeaders->get_list_detalle_mailing($dato['id_mailing']);
            $this->load->view('view_BL/mailing/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Mailing($tipo){
        $list_detalle = $this->Model_BabyLeaders->get_list_detalle_mailing($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Mailing');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30); 
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(35);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(18); 

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
        $sheet->setCellValue("B1", 'Apellido Paterno');
        $sheet->setCellValue("C1", 'Apellido Materno');     
        $sheet->setCellValue("D1", 'Nombre(s)');        
        $sheet->setCellValue("E1", 'Apoderado');             
        $sheet->setCellValue("F1", 'Parentesco');  
        $sheet->setCellValue("G1", 'Email'); 
        $sheet->setCellValue("H1", 'Celular'); 
        $sheet->setCellValue("I1", 'Fecha Envío');
        $sheet->setCellValue("J1", 'Hora Envío');           

        $contador=1;
        
        foreach($list_detalle as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_alumno']);
            $sheet->setCellValue("B{$contador}", $list['apater_alumno']);
            $sheet->setCellValue("C{$contador}", $list['amater_alumno']);
            $sheet->setCellValue("D{$contador}", $list['nom_alumno']);
            $sheet->setCellValue("E{$contador}", $list['nom_apoderado']);
            $sheet->setCellValue("F{$contador}", $list['parentesco_apoderado']);
            $sheet->setCellValue("G{$contador}", $list['email_apoderado']);
            $sheet->setCellValue("H{$contador}", $list['celular_apoderado']);
            $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fec_envio']));
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("J{$contador}", $list['hora_envio']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Detalle Mailing (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    /*
    public function Documento_Colaborador() {
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
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();

            $this->load->view('view_BL/documento_colaborador/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento_Colaborador() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_BabyLeaders->get_list_documento_colab();
            $this->load->view('view_BL/documento_colaborador/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Documento_Colab($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_list_documento_colab($id_documento);
            //$dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $dato['list_status'] = $this->Model_BabyLeaders->get_list_estado();
            $this->load->view('view_BL/documento_colaborador/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento_Colab(){
        $dato['cod_documento']= $this->input->post("cod_documento_i");
        //$dato['id_grado']= $this->input->post("id_grado_i");
        $dato['nom_documento']= $this->input->post("nom_documento_i");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_i");
        $dato['obligatorio']= $this->input->post("obligatorio_i");
        $dato['digital']= $this->input->post("digital_i");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_i");
        $dato['validacion']= $this->input->post("validacion_i");

        $total=count($this->Model_BabyLeaders->valida_insert_documento_colab($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->insert_documento_colab($dato);
            if($dato['aplicar_todos']==1){
                $get_id = $this->Model_BabyLeaders->ultimo_id_documento_colab();
                $dato['id_documento'] = $get_id[0]['id_documento'];
                $dato['anio'] = date('Y');

                $list_colaborador = $this->Model_BabyLeaders->get_list_colaborador_combo();

                foreach($list_colaborador as $list){
                    $dato['id_colaborador'] = $list['id_colaborador'];
                    $valida = $this->Model_BabyLeaders->valida_insert_documento_todos_colab($dato);
                    if(count($valida)==0){
                        $this->Model_BabyLeaders->insert_documento_todos_colab($dato);
                    }
                }
            }
        }
    }

    public function Modal_Documento_Colab(){
        if ($this->session->userdata('usuario')) {
            //$dato['list_grado'] = $this->Model_BabyLeaders->get_list_grado_combo();
            $this->load->view('view_BL/documento_colaborador/modal_registrar');
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Colab(){
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

        $total=count($this->Model_BabyLeaders->valida_update_documento_colab($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_BabyLeaders->update_documento_colab($dato);
            if($dato['aplicar_todos']==1){
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_BabyLeaders->get_list_colaborador_combo();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['Id'];
                    $valida = $this->Model_BabyLeaders->valida_insert_documento_todos_colab($dato);
                    if(count($valida)==0){
                        $this->Model_BabyLeaders->insert_documento_todos_colab($dato);
                    }
                }
            }
        }
    }

    public function Delete_Documento_Colab(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_BabyLeaders->delete_documento_colab($dato);
    }

    //---------------------------------------------FOTOCHECK COLABORADOR-------------------------------------------
    public function Fotocheck_Colaborador(){
        if($this->session->userdata('usuario')){

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            //$dato['contador_contactenos'] = $this->Model_BabyLeaders->get_list_contactenos(1);
            //$dato['cierres_caja_pendientes'] = count($this->Model_BabyLeaders->get_cierres_caja_pendientes());
            //$dato['cierres_caja_sin_cofre'] = count($this->Model_BabyLeaders->get_cierres_caja_sin_cofre());
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_BabyLeaders->get_list_nav_sede();
            //$dato['cantidadnulos'] = $this->Model_IFV->get_list_matriculadosnulosst(1);
            //$dato['contador_renovar'] = $this->Model_BabyLeaders->get_busqueda_centro_contadores(1);
            //$dato['contador_caducado'] = $this->Model_BabyLeaders->get_busqueda_centro_contadores(2);
            //$dato['cantidad_fotochecks'] = count($this->Model_BabyLeaders->get_list_fotocheck(1));

            $this->load->view('view_BL/fotocheck_colaborador/index',$dato);
        }
    }

    public function Lista_Fotocheck_Alumnos_Bl() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_fotocheck'] = $this->Model_BabyLeaders->get_list_fotocheck($dato['tipo']);
            $this->load->view('view_BL/fotocheck_colaborador/lista',$dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Detalle($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_BL/fotocheck_colaborador/modal_detalle', $dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Foto($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_BL/fotocheck_colaborador/modal_foto', $dato);
        }else{
            redirect('');
        }
    }

    public function Guardar_Foto(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['id_colaborador'] = $this->input->post("Id");
            $dato['foto_fotocheck'] = $this->input->post("actual_foto_fotocheck");
            $dato['foto_fotocheck_2'] = $this->input->post("actual_foto_fotocheck_2");
            $dato['foto_fotocheck_3'] = $this->input->post("actual_foto_fotocheck_3");

            if($_FILES["foto_fotocheck_2"]["name"] != ""){
                $get_doc = $this->Model_BabyLeaders->get_cod_documento_colaborador('D01');
                if (file_exists($dato['foto_fotocheck_2'])) {
                    unlink($dato['foto_fotocheck_2']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_2"]["name"]);
                $config['upload_path'] = './documento_colaborador_bl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_bl/', 0777);
                    chmod('./documento_colaborador_bl/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_bl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_2'] = "documento_colaborador_bl/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 2;
                $this->Model_BabyLeaders->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_BabyLeaders->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck_2'];
                $this->Model_BabyLeaders->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck"]["name"] != ""){
                $get_doc = $this->Model_BabyLeaders->get_cod_documento_colaborador('D00');
                if (file_exists($dato['foto_fotocheck'])) {
                    unlink($dato['foto_fotocheck']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck"]["name"]);
                $config['upload_path'] = './documento_colaborador_bl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_bl/', 0777);
                    chmod('./documento_colaborador_bl/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_bl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck'] = "documento_colaborador_bl/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 1;
                $this->Model_BabyLeaders->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_BabyLeaders->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck'];
                $this->Model_BabyLeaders->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck_3"]["name"] != ""){
                if (file_exists($dato['foto_fotocheck_3'])) {
                    unlink($dato['foto_fotocheck_3']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_3"]["name"]);
                $config['upload_path'] = './documento_colaborador_bl/0/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_bl/', 0777);
                    chmod('./documento_colaborador_bl/0', 0777);
                    chmod('./documento_colaborador_bl/0/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_3'] = "documento_colaborador_bl/0/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 3;
                $this->Model_BabyLeaders->update_foto_fotocheck($dato);
            }

            $valida = $this->Model_BabyLeaders->valida_fotocheck_completo($dato['id_fotocheck']);

            if(count($valida)==0){
                $this->Model_BabyLeaders->update_fotocheck_completo($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Carne_Colaborador($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_fotocheck($id_fotocheck);
            $dato['altura'] = 560;//+$cantidad_filas;

            $mpdf = new \Mpdf\Mpdf([
                'margin_top' =>0,
                'mode' => 'utf-8',
                'format' => array(55,85),'portrait',
                'margin_bottom' => 0,
                'margin_right' => -14,
                'bleedMargin' => 0,
                'crossMarkMargin' => 0,
                'cropMarkMargin' => 0,
                'nonPrintMargin' => 0,
                'margBuffer' => 0,
                'collapseBlockMargins' => false,
                'default_font' => 'Gotham',
            ]);
            $html = $this->load->view('view_BL/fotocheck_colaborador/carnet',$dato,true);
            //$mpdf->SetHTMLHeader("Content-Disposition: inline");
            $mpdf->WriteHTML($html);
            $mpdf->Output($dato['get_id'][0]['Id'].".pdf","I");
        }else{
            redirect('');
        }
    }

    public function Modal_Anular_Colab($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_BL/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('');
        }
    }

    public function Impresion_Fotocheck(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck']= $this->input->post("id_fotocheck");
            $this->Model_BabyLeaders->impresion_fotocheck($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Anular($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_BabyLeaders->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_BL/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('');
        }
    }

    public function Anular_Envio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['obs_anulado'] = $this->input->post("obs_anulado");
            $this->Model_BabyLeaders->anular_envio($dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Envio(){
        if ($this->session->userdata('usuario')) {
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

            $dato['get_id_user'] = $this->Model_BabyLeaders->get_id_user();
            $dato['list_cargo_sesion'] = $this->Model_BabyLeaders->get_cargo_x_id($id_usuario);
            $this->load->view('view_BL/fotocheck_colaborador/modal_envio', $dato);
        }else{
            redirect('');
        }
    }

    public function Traer_Cargo(){
        if ($this->session->userdata('usuario')) {
            $id_usuario_de = $this->input->post("usuario_encomienda");
            $dato['list_cargo'] = $this->Model_BabyLeaders->get_cargo_x_id($id_usuario_de);
            $dato['id_cargo'] = "cargo_envio_f";
            $this->load->view('view_BL/fotocheck_colaborador/cargo',$dato);
        }else{
            redirect('');
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

                    $alumno = $this->Model_BabyLeaders->get_id_fotocheck($dato['id_fotocheck']);

                    if(count($alumno)>0){
                        if ($alumno[0]['esta_fotocheck']=='Foto Rec'){
                            $this->Model_BabyLeaders->update_envio_fotocheck($dato);
                        }
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }*/
}