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

class CursosCortos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_CursosCortos');
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
            $dato['fondo'] = $this->Model_CursosCortos->fondo_index();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/administrador/index',$dato);
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------CLIENTE-------------------------------------
    public function Cliente() {
        if ($this->session->userdata('usuario')) {
            $dato['list_cliente'] = $this->Model_CursosCortos->get_list_cliente();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/cliente/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cliente(){
        $list_cliente = $this->Model_CursosCortos->get_list_cliente();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/articulo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Articulo() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo($dato['tipo']);
            $this->load->view('view_CC/articulo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Articulo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $this->load->view('view_CC/articulo/modal_registrar',$dato);   
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

        $total=count($this->Model_CursosCortos->valida_insert_articulo($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_articulo($dato);
        }
    }

    public function Modal_Update_Articulo($id_articulo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_articulo($id_articulo);
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/articulo/modal_editar', $dato);   
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

        $total=count($this->Model_CursosCortos->valida_update_articulo($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->update_articulo($dato);
        }
    }

    public function Delete_Articulo(){
        $dato['id_articulo']= $this->input->post("id_articulo");
        $this->Model_CursosCortos->delete_articulo($dato);
    }

    public function Excel_Articulo($tipo){
        $list_articulo = $this->Model_CursosCortos->get_list_articulo($tipo);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/producto/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Producto() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto($dato['tipo']);
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo_todo();
            $this->load->view('view_CC/producto/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Producto(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo_combo();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $this->load->view('view_CC/producto/modal_registrar',$dato);   
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

        $total=count($this->Model_CursosCortos->valida_insert_producto($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_producto($dato);
        }
    }

    public function Modal_Update_Producto($id_producto){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_producto($id_producto);
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo_combo();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/producto/modal_editar', $dato);   
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

        $total=count($this->Model_CursosCortos->valida_update_producto($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->update_producto($dato);
        }
    }

    public function Delete_Producto(){
        $dato['id_producto']= $this->input->post("id_producto");
        $this->Model_CursosCortos->delete_producto($dato);
    }

    public function Excel_Producto($tipo){
        $list_producto = $this->Model_CursosCortos->get_list_producto($tipo);
        $list_articulo = $this->Model_CursosCortos->get_list_articulo_todo();

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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_producto($id_producto);
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo_todo();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/producto/detalle',$dato);
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/profesor/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Profesor() {
        if ($this->session->userdata('usuario')) {
            $dato['list_profesor'] = $this->Model_CursosCortos->get_list_profesor();
            $this->load->view('view_CC/profesor/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Profesor(){
        $list_profesor = $this->Model_CursosCortos->get_list_profesor();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/matriculados/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $tipo = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Model_CursosCortos->get_list_matriculados($tipo);
            $this->load->view('view_CC/matriculados/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matriculados($tipo){
        $list_alumno = $this->Model_CursosCortos->get_list_matriculados($tipo);
        $sede = 'CC1';

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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_matriculados($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/matriculados/pagos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Pago_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['estado'] = $this->input->post("estado");
            $dato['list_pago'] = $this->Model_CursosCortos->get_list_pago_matriculados($dato['id_alumno']);
            $this->load->view('view_CC/matriculados/lista_pagos',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Pago_Matriculados($id_alumno,$estado){
        $list_pago = $this->Model_CursosCortos->get_list_pago_matriculados($id_alumno);

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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_matriculados($id_alumno);
            $dato['list_documento'] = $this->Model_CursosCortos->get_list_documento_matriculados($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/matriculados/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //---------------------------------------------ALUMNOS-------------------------------------------
    public function Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['informe'] = $this->Model_CursosCortos->get_informe_matriculados(); 

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno() { 
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Model_CursosCortos->get_list_alumno($id_alumno=null,$dato['tipo']);
            $this->load->view('view_CC/alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Alumno() { 
        if ($this->session->userdata('usuario')) {
            $dato['dni'] = $this->input->post("dni");
            $dato['alumno'] = $this->Model_CursosCortos->get_alumno_xdocumento($dato['dni']);
            echo json_encode($dato['alumno']);
        }else{
            redirect('/login');
        }
    }

    public function Retiro_Alumno($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_CursosCortos->get_list_alumno($id_alumno,null);
            $dato['get_retirado'] = $this->Model_CursosCortos->valida_alumno_retirado($id_alumno);
            $dato['list_motivo'] = $this->Model_CursosCortos->get_list_motivo();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno/retirar_alumno',$dato);
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

            $cant = count($this->Model_CursosCortos->valida_alumno_retirado($dato['id_alumno']));

            if($cant>0){
                $this->Model_CursosCortos->update_retiro_alumno($dato);
            }else{
                $this->Model_CursosCortos->insert_retiro_alumno($dato);

                /*$get_id = $this->Model_CursosCortos->get_list_alumno($id_alumno,null);

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
            $dato['get_id'] = $this->Model_CursosCortos->get_list_alumno_retirado($id_alumno_retirado);
            $this->load->view('view_CC/alumno/modal_obs_retiro', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Obs_Motivo_Retiro(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno_retirado']= $this->input->post("id_alumno_retirado");
            $dato['obs_retiro']= $this->input->post("obs_retiro");
            $this->Model_CursosCortos->update_obs_motivo_retiro($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Lista_Alumno($tipo){
        $list_alumno = $this->Model_CursosCortos->get_list_alumno(null,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:U1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:U1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos (Lista)');
        $sheet->setAutoFilter('A1:U1');

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
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(35);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(25);
        $sheet->getColumnDimension('R')->setWidth(25);
        $sheet->getColumnDimension('S')->setWidth(25);
        $sheet->getColumnDimension('T')->setWidth(35);
        $sheet->getColumnDimension('U')->setWidth(20);
        
        $sheet->getStyle('A1:U1')->getFont()->setBold(true);    

        $spreadsheet->getActiveSheet()->getStyle("A1:U1")->getFill()
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

        $sheet->getStyle("A1:U1")->applyFromArray($styleThinBlackBorderOutline); 
  
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
        $sheet->setCellValue("L1", 'Ap. Paterno Tutor 1');	  
        $sheet->setCellValue("M1", 'Ap. Materno Tutor 1');
        $sheet->setCellValue("N1", 'Nombre Tutor 1');
        $sheet->setCellValue("O1", 'Correo Tutor 1');
        $sheet->setCellValue("P1", 'Celular Tutor 1');
        $sheet->setCellValue("Q1", 'Ap. Paterno Tutor 2');	  
        $sheet->setCellValue("R1", 'Ap. Materno Tutor 2');
        $sheet->setCellValue("S1", 'Nombre Tutor 2');
        $sheet->setCellValue("T1", 'Correo Tutor 2');
        $sheet->setCellValue("U1", 'Celular Tutor 2');

        $contador=1;

        foreach($list_alumno as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}:T{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:U{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            
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
            $sheet->setCellValue("L{$contador}", $list['titular1_apater']);
            $sheet->setCellValue("M{$contador}", $list['titular1_amater']);
            $sheet->setCellValue("N{$contador}", $list['titular1_nom']); 
            $sheet->setCellValue("O{$contador}", $list['titular1_correo']);
            $sheet->setCellValue("P{$contador}", $list['titular1_celular']);
            $sheet->setCellValue("Q{$contador}", $list['titular2_apater']);
            $sheet->setCellValue("R{$contador}", $list['titular2_amater']);
            $sheet->setCellValue("S{$contador}", $list['titular2_nom']); 
            $sheet->setCellValue("T{$contador}", $list['titular2_correo']);
            $sheet->setCellValue("U{$contador}", $list['titular2_celular']);
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
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_parentesco'] = $this->Model_CursosCortos->get_list_parentesco();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_medios'] = $this->Model_CursosCortos->get_list_medios();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($id_departamento);
            $this->load->view('view_CC/alumno/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($id_provincia);
            $this->load->view('view_CC/alumno/distrito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Prin(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = "titular1_provincia";
            $dato['onchange'] = "Traer_Distrito_Prin();";
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($id_departamento);
            $this->load->view('view_CC/alumno/provincia_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Prin(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['id_distrito'] = "titular1_distrito";
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($id_provincia);
            $this->load->view('view_CC/alumno/distrito_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Secu(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = "titular2_provincia";
            $dato['onchange'] = "Traer_Distrito_Secu();";
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($id_departamento);
            $this->load->view('view_CC/alumno/provincia_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Secu(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['id_distrito'] = "titular2_distrito";
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($id_provincia);
            $this->load->view('view_CC/alumno/distrito_tutor',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['list_seccion'] = $this->Model_CursosCortos->get_list_seccion_combo($id_grado);
            $this->load->view('view_CC/alumno/seccion',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno(){
        $dato['n_documento']= $this->input->post("n_documento");
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nom']= $this->input->post("alum_nom");  
        $dato['fecha_nacimiento']= $this->input->post("fecha_nacimiento");
        $dato['direccion']= $this->input->post("direccion");
        $dato['id_departamento']= $this->input->post("id_departamento");
        $dato['id_provincia']= $this->input->post("id_provincia");
        $dato['id_distrito']= $this->input->post("id_distrito");
        $dato['telefono']= $this->input->post("telefono");
        $dato['correo']= $this->input->post("correo");
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

        $total=count($this->Model_CursosCortos->valida_insert_alumno($dato));

        if($total>0){
            echo "error";
        }else{
            $anio=date('Y');
            $query_id = $this->Model_CursosCortos->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
            $totalRows_t = count($query_id);
    
            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigo="CC1-".$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo="CC1-".$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>98){
                $codigo="CC1-".$aniof.($totalRows_t+1);
            }
            $dato['cod_alum']= $codigo;

            $this->Model_CursosCortos->insert_alumno($dato);

            //INSERTAR DOCUMENTOS AL ALUMNO
            $get_id = $this->Model_CursosCortos->ultimo_id_alumno();
            $dato['id_alumno'] = $get_id[0]['id_alumno'];
            $dato['anio'] = date('Y');
            $list_documento = $this->Model_CursosCortos->get_documentos_asignados($dato['id_grado']);

            if(count($list_documento)>0){
                foreach($list_documento as $list){
                    $dato['id_documento'] = $list['id_documento'];
                    $this->Model_CursosCortos->insert_documentos_alumno($dato);
                }
            }
        }
    }

    public function Modal_Update_Alumno($id_alumno){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_alumno($id_alumno,$tipo=null);
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_parentesco'] = $this->Model_CursosCortos->get_list_parentesco();
            $dato['list_provincia_prin'] = $this->Model_CursosCortos->get_list_provincia($dato['get_id'][0]['titular1_departamento']);
            $dato['list_distrito_prin'] = $this->Model_CursosCortos->get_list_distrito($dato['get_id'][0]['titular1_provincia']);
            $dato['list_provincia_secu'] = $this->Model_CursosCortos->get_list_provincia($dato['get_id'][0]['titular2_departamento']);
            $dato['list_distrito_secu'] = $this->Model_CursosCortos->get_list_distrito($dato['get_id'][0]['titular2_provincia']);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_seccion'] = $this->Model_CursosCortos->get_list_seccion_combo($dato['get_id'][0]['id_grado']);
            $dato['list_medios'] = $this->Model_CursosCortos->get_list_medios();
            //$dato['list_estado'] = $this->Model_CursosCortos->get_list_estadoa();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno/editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumno(){
        $dato['id_alumno']= $this->input->post("id_alumno");
        $dato['n_documento']= $this->input->post("n_documento");
        $dato['cod_arpay']= $this->input->post("cod_arpay");
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nom']= $this->input->post("alum_nom");  
        $dato['fecha_nacimiento']= $this->input->post("fecha_nacimiento");
        $dato['sexo']= $this->input->post("sexo");
        $dato['correo_corporativo']= $this->input->post("correo_corporativo");
        $dato['direccion']= $this->input->post("direccion");
        $dato['id_departamento']= $this->input->post("id_departamento");
        $dato['id_provincia']= $this->input->post("id_provincia");
        $dato['id_distrito']= $this->input->post("id_distrito");
        $dato['telefono']= $this->input->post("telefono");
        $dato['correo']= $this->input->post("correo");
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
        $dato['titular1_ocupacion']= $this->input->post("titular1_ocupacion"); 
        $dato['titular1_centro_labor']= $this->input->post("titular1_centro_labor"); 
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
        $dato['titular2_ocupacion']= $this->input->post("titular2_ocupacion"); 
        $dato['titular2_centro_labor']= $this->input->post("titular2_centro_labor"); 
        $dato['id_grado']= $this->input->post("id_grado"); 
        $dato['id_seccion']= $this->input->post("id_seccion");
        $dato['tipo']= $this->input->post("tipo");
        $dato['id_medio']= $this->input->post("id_medio"); 
        //$dato['estado_alumno']= $this->input->post("estado_alumno");

        $total=count($this->Model_CursosCortos->valida_update_alumno($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->update_alumno($dato);
            /*$total=count($this->Model_CursosCortos->valida_cod_arpay($dato));

            if($total>0){
                echo "arpay";
            }else{
                $this->Model_CursosCortos->update_alumno($dato);
            }*/
        }
    }

    public function Delete_Alumno(){
        $dato['id_alumno']= $this->input->post("id_alumno");
        $this->Model_CursosCortos->delete_alumno($dato);
    }

    public function Excel_Alumno(){
        $tipo=1;
        $list_alumno = $this->Model_CursosCortos->get_list_alumno($id_alumno=null,$tipo);

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
            $dato['get_id'] = $this->Model_CursosCortos->get_list_alumno($id_alumno,$tipo=null);
            $dato['list_tipo_obs'] = $this->Model_CursosCortos->get_list_tipo_obs();
            $dato['get_foto'] = $this->Model_CursosCortos->get_list_foto_matriculados($id_alumno);
            $dato['list_usuario'] = $this->Model_CursosCortos->get_list_usuario();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Datos_Cambiantes_Alumno() { 
        if ($this->session->userdata('usuario')) { 
            $id_alumno = $this->input->post("id_alumno");
            $dato['get_id'] = $this->Model_CursosCortos->get_list_alumno($id_alumno,$tipo=null);
            $this->load->view('view_CC/alumno/datos_cambiantes',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_matricula'] = $this->Model_CursosCortos->get_list_matricula_alumno($dato['id_alumno']);
            $dato['list_articulo'] = $this->Model_CursosCortos->get_list_articulo_combo();
            $this->load->view('view_CC/alumno/lista_matricula',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Matricula_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno'] = $id_alumno;
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $this->load->view('view_CC/alumno/modal_registrar_matricula', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Producto_Alumno_i(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['id_producto'] = "id_producto_i";
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto_combo($id_grado);
            $this->load->view('view_CC/alumno/producto', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Matricula_Alumno(){
        $dato['id_alumno']= $this->input->post("id_alumno");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['id_producto'] = $this->input->post("id_producto_i");
        $dato['fec_matricula']= $this->input->post("fec_matricula_i");
        $dato['observaciones'] = $this->input->post("observaciones_i");

        $validar = $this->Model_CursosCortos->valida_insert_matricula_alumno($dato);

        if(count($validar)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_matricula_alumno_detalle($dato);

            $get_matricula = $this->Model_CursosCortos->ultimo_id_matricula(); 
            $dato['id_matricula'] = $get_matricula[0]['id_matricula']; 

            $articulo = explode(",",$get_matricula[0]['id_articulo']);

            $i = 0;
            while($i<count($articulo)){
                $get_articulo = $this->Model_CursosCortos->get_id_articulo($articulo[$i]);

                if($get_articulo[0]['id_tipo']==2){
                    $list_mes = $this->Model_CursosCortos->get_list_mes_matricula($get_matricula[0]['fec_matricula']);

                    foreach($list_mes as $list){
                        $dato['orden'] = $list['id_mes'];
                        $dato['nom_pago'] = "Pensión ".$list['nom_mes']." ".$get_articulo[0]['anio'];
                        $dato['monto'] = $get_articulo[0]['monto'];
                        $dato['fec_vencimiento'] = substr($get_matricula[0]['fec_matricula'],0,4)."-".$list['cod_mes']."-05";
                        $this->Model_CursosCortos->insert_pago_matricula_alumno($dato);
                    }
                }else{
                    $dato['orden'] = 0;
                    $dato['nom_pago'] = $get_articulo[0]['nombre'];
                    $dato['monto'] = $get_articulo[0]['monto'];
                    $dato['fec_vencimiento'] = "";
                    $this->Model_CursosCortos->insert_pago_matricula_alumno($dato);
                }

                $i++;
            }
        }
    }

    public function Modal_Update_Matricula_Alumno($id_matricula){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_matricula_alumno($id_matricula);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto_combo($dato['get_id'][0]['id_grado']);
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado_matricula();
            $this->load->view('view_CC/alumno/modal_editar_matricula', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Producto_Alumno_U(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['id_producto'] = "id_producto_u";
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto_combo($id_grado);
            $this->load->view('view_CC/alumno/producto', $dato);
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

        $validar = $this->Model_CursosCortos->valida_update_matricula_alumno($dato);

        if(count($validar)>0){
            echo "error";
        }else{
            if($dato['estado_matricula']==9){
                $this->Model_CursosCortos->update_pago_alumno_retirado($dato);
            }

            $this->Model_CursosCortos->update_matricula_alumno_detalle($dato);
        }
    }

    public function Delete_Matricula_Alumno(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_matricula'] = $this->input->post("id_matricula");
            $this->Model_CursosCortos->delete_matricula_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Lista_Pago_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $id_alumno = $this->input->post("id_alumno");
            $dato['list_matricula'] = $this->Model_CursosCortos->get_list_matricula_alumno($id_alumno);
            $dato['list_pago_matricula'] = $this->Model_CursosCortos->get_list_pago_matricula_alumno($id_alumno);
            $this->load->view('view_CC/alumno/lista_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Pago($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_pago($id_pago);
            $dato['list_estadop'] = $this->Model_CursosCortos->get_list_estadop();
            $this->load->view('view_CC/alumno/modal_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Pago(){
        $dato['id_pago']=$this->input->post("id_pago");
        $dato['monto']=$this->input->post("monto");
        $dato['descuento']=$this->input->post("descuento");
        $dato['fec_vencimiento']=$this->input->post("fec_vencimiento");
        $dato['fec_pago']=$this->input->post("fec_pago");
        $dato['estado_pago']=$this->input->post("estado_pago");
        $dato['id_tipo_pago']=$this->input->post("id_tipo_pago");
        $dato['operacion']=$this->input->post("operacion");
        if($dato['fec_pago']!=""){
            $dato['fec_pago'] = $dato['fec_pago']." ".date('H:i:s');
        }

        $valida_cierre_caja = $this->Model_CursosCortos->valida_cierre_caja();

        if(count($valida_cierre_caja)>0 && $dato['id_tipo_pago']==1 && $dato['estado_pago']==2){
            echo "cierre_caja";
        }else{
            $this->Model_CursosCortos->update_pago($dato);

            $dato['hacer_operaciones'] = $this->input->post("hacer_operaciones");
            $dato['generar_boleta'] = $this->input->post("generar_boleta");

            if($dato['hacer_operaciones']==1 && $dato['estado_pago']==2){
                $dato['tipo'] = 1;

                $cantidad = count($this->Model_CursosCortos->contar_recibos_cancelados());

                if($cantidad<9){
                    $codigo = "FV000".($cantidad+1);
                }
                if($cantidad>8 && $cantidad<99){
                    $codigo = "FV00".($cantidad+1);
                }
                if($cantidad>98 && $cantidad<999){
                    $codigo = "FV0".($cantidad+1);
                }
                if($cantidad>998 && $cantidad<9999){
                    $codigo = "FV".($cantidad+1);
                }
                $dato['cod_documento']= $codigo;
                $dato['xml'] = "";
                $dato['cdrZip'] = "";
                $dato['id'] = "";
                $dato['code'] = "";
                $dato['description'] = "";

                $this->Model_CursosCortos->insert_documento_pago($dato);

                //GENERAR BOLETA
                if($dato['generar_boleta']==1){
                    $dato['tipo'] = 2;

                    $get_id = $this->Model_CursosCortos->get_id_pago($dato['id_pago']);

                    $dato['fec_emision'] = $this->input->post("fec_pago");
            
                    $modelonumero = new modelonumero();
                    $numeroaletras = new numeroaletras();
        
                    $cantidad = count($this->Model_CursosCortos->contar_boletas_canceladas());
                    $serie='CC02';
            
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
        
                    $dato['get_contabilidad'] = $this->Model_CursosCortos->get_list_contabilidad(1);
                    $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;
        
                    $dato['tipo_api'] = 2;
                    $dato['tipo_doc'] = 1;
                    $api = $this->Model_CursosCortos->get_list_api_maestra($dato);
        
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
                                "numDoc": "'.$get_id[0]['n_documento'].'",
                                "rznSocial": "'.$get_id[0]['nom_alumno'].'",
                                "address": {
                                "direccion": "",
                                "provincia": "",
                                "departamento": "",
                                "distrito": "",
                                "ubigueo": ""
                                }
                            },
                            "company": {
                                "ruc": 20602759939,
                                "razonSocial": "FV Chincha S.A.C",
                                "nombreComercial": "FV Chincha S.A.C",
                                "address": {
                                "direccion": "Luis Massaro, 104",
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
        
                                //echo "5".$dato['description'];
                                $this->Model_CursosCortos->insert_documento_pago($dato);
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

                    //GENERAR NOTA DE DÉBITO
                    $dato['fecha_vencimiento']=$this->input->post("fec_vencimiento");
                    $dato['fecha_pago']=$this->input->post("fec_pago");
                    $validacion = $this->Model_CursosCortos->valida_nota_debito($dato);

                    if($validacion[0]['dias']>0){
                        $dato['tipo'] = 3;

                        $dato['numDocfectado'] = $dato['cod_documento'];
            
                        $modelonumero = new modelonumero();
                        $numeroaletras = new numeroaletras();
            
                        $cantidad = count($this->Model_CursosCortos->contar_notas_debito_canceladas());
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

                        $dato['get_contabilidad'] = $this->Model_CursosCortos->get_list_contabilidad(1);
                        $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;

                        $dato['tipo_api'] = 3;
                        $dato['tipo_doc'] = 1;
                        $api = $this->Model_CursosCortos->get_list_api_maestra($dato);

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
                                    "numDoc": "'.$get_id[0]['n_documento'].'",
                                    "rznSocial": "'.$get_id[0]['nom_alumno'].'",
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
                                    "razonSocial": "FV Chincha S.A.C",
                                    "nombreComercial": "FV Chincha S.A.C",
                                    "address": {
                                    "direccion": "Luis Massaro, 104",
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
            
                                    //echo "5".$dato['description'];
                                    $this->Model_CursosCortos->insert_documento_pago($dato);
                                    $dato['penalidad'] = $validacion[0]['dias'];
                                    $this->Model_CursosCortos->update_pago_penalidad($dato);
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
                    }
                }
            }
        }
    }

    public function Duplicar_Pago(){ 
        $id_pago = $this->input->post("id_pago");
        $get_id = $this->Model_CursosCortos->get_id_pago($id_pago);

        $dato['id_matricula'] = $get_id[0]['id_matricula'];
        $dato['orden'] = $get_id[0]['orden'];
        $dato['nom_pago'] =  $get_id[0]['nom_pago'];
        $dato['monto'] = $get_id[0]['monto'];
        $dato['fec_vencimiento'] = $get_id[0]['fec_vencimiento'];

        $this->Model_CursosCortos->insert_pago_matricula_alumno($dato);
    }

    public function Delete_Pago_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_pago'] = $this->input->post("id_pago");
            $this->Model_CursosCortos->delete_pago_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Lista_Documento_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_documento']=$this->Model_CursosCortos->get_list_documento_alumno($dato['id_alumno']);
            $this->load->view('view_CC/alumno/lista_documentos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_CursosCortos->get_list_alumno($id_alumno);
            $dato['list_documento']=$this->Model_CursosCortos->get_list_documento_combo($get_id[0]['id_grado']);
            $dato['list_anio']=$this->Model_CursosCortos->get_list_anio();
            $dato['id_alumno'] = $id_alumno;
            $this->load->view('view_CC/alumno/modal_registrar_documento', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento_Alumno(){
        $dato['id_alumno'] = $this->input->post("id_alumno");
        $dato['id_documento']= $this->input->post("id_documento_i");
        $dato['anio']= $this->input->post("id_anio_i");

        $valida = $this->Model_CursosCortos->valida_insert_documento_alumno($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_documento_alumno($dato);
        }
    }

    public function Modal_Update_Documento_Alumno($id_detalle){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_detalle'] = $this->Model_CursosCortos->get_id_detalle_documento_alumno($id_detalle);
            $dato['get_documento'] = $this->Model_CursosCortos->get_list_documento( $dato['get_detalle'][0]['id_documento']);
            $this->load->view('view_CC/alumno/modal_editar_documento', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Alumno(){
        $dato['id_detalle']= $this->input->post("id_detalle");
        $get_id = $this->Model_CursosCortos->get_id_detalle_documento_alumno($dato['id_detalle']);
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
        $this->Model_CursosCortos->update_documento_alumno($dato);
    }

    public function Descargar_Documento_Alumno($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['doc']=$this->Model_CursosCortos->get_id_detalle_documento_alumno($id_detalle);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen,NULL);
        }else{
            redirect('');
        }
    }

    public function Delete_Documento_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post("id_detalle");
            $dato['doc']=$this->Model_CursosCortos->get_id_detalle_documento_alumno($dato['id_detalle']);
            unlink($dato['doc'][0]['archivo']);
            $this->Model_CursosCortos->delete_documento_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Documento_Alumno($id_alumno){
        $list_documento = $this->Model_CursosCortos->get_list_documento_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documento Alumno');

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
        $filename = 'Documento Alumno (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Documentos($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_pago($id_pago);
            $dato['list_documento'] = $this->Model_CursosCortos->get_list_documento_pago_alumno($id_pago);
            $this->load->view('view_CC/alumno/modal_documentos', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Generar_Boleta(){
        $dato['id_pago']=$this->input->post("id_pago");
        $get_id = $this->Model_CursosCortos->get_id_pago($dato['id_pago']);

        //GENERAR BOLETA
        $dato['tipo'] = 2;

        $dato['fec_emision'] = $get_id[0]['fec_pago_u'];

        $modelonumero = new modelonumero();
        $numeroaletras = new numeroaletras();

        $cantidad = count($this->Model_CursosCortos->contar_boletas_canceladas());
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

        $dato['get_contabilidad'] = $this->Model_CursosCortos->get_list_contabilidad(1);
        $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;

        $dato['tipo_api'] = 2;
        $dato['tipo_doc'] = 1;
        $api = $this->Model_CursosCortos->get_list_api_maestra($dato);

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
                    "numDoc": "'.$get_id[0]['n_documento'].'",
                    "rznSocial": "'.$get_id[0]['nom_alumno'].'",
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

                    //echo "5".$dato['description'];
                    $this->Model_CursosCortos->insert_documento_pago($dato);
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

        //GENERAR NOTA DE DÉBITO
        $dato['fecha_vencimiento']=$get_id[0]['fec_vencimiento'];
        $dato['fecha_pago']=$get_id[0]['fec_pago_u'];
        $validacion = $this->Model_CursosCortos->valida_nota_debito($dato);

        if($validacion[0]['dias']>0){
            $dato['tipo'] = 3;

            $dato['numDocfectado'] = $dato['cod_documento'];

            $modelonumero = new modelonumero();
            $numeroaletras = new numeroaletras();

            $cantidad = count($this->Model_CursosCortos->contar_notas_debito_canceladas());
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

            $dato['get_contabilidad'] = $this->Model_CursosCortos->get_list_contabilidad(1);
            $dato['porcentajeIgv'] = $dato['get_contabilidad'][0]['valor']*100;

            $dato['tipo_api'] = 3;
            $dato['tipo_doc'] = 1;
            $api = $this->Model_CursosCortos->get_list_api_maestra($dato);

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
                        "numDoc": "'.$get_id[0]['n_documento'].'",
                        "rznSocial": "'.$get_id[0]['nom_alumno'].'",
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

                        //echo "5".$dato['description'];
                        $this->Model_CursosCortos->insert_documento_pago($dato);
                        $dato['penalidad'] = $validacion[0]['dias'];
                        $this->Model_CursosCortos->update_pago_penalidad($dato);
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
        }
    }

    public function Lista_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_observacion']=$this->Model_CursosCortos->get_list_observaciones_alumno($dato['id_alumno']);
            $this->load->view('view_CC/alumno/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Alumno() {
        $dato['id_alumno'] = $this->input->post("id_alumno");
        $dato['id_tipo'] = $this->input->post("id_tipo_o");
        $dato['fecha'] = $this->input->post("fecha_o");
        $dato['usuario'] = $this->input->post("usuario_o");
        $dato['observacion'] = $this->input->post("observacion_o");

        $valida = $this->Model_CursosCortos->valida_observacion_alumno($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_observacion_alumno($dato);
        }
    }

    public function Delete_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $this->Model_CursosCortos->delete_observacion_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Pdf_Hoja_Matricula_Completo($id_matricula){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_matricula_alumno($id_matricula);
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_CC/alumno/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Pdf_Nota_Credito($id_pago){
        $get_id= $this->Model_CursosCortos->get_id_pago($id_pago);

        $modelonumero = new modelonumero();
        $total_texto = $modelonumero->numtoletras(abs($get_id[0]['monto']),'Soles','centimos');
        
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
        $pdf->MultiCell (75,8,'FV01 - 00001210',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (17,$y2+25);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Emision:',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (165,6,$get_id[0]['fecha_emision'],0,'L',1,0,'','',true,0,false,true,6,'M');
        
        $pdf->SetXY (17,$y2+31);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Alumno(a):',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,6,'M');
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
        $pdf->MultiCell (13,6,$get_id[0]['cod_arpay'],0,'L',1,0,'','',true,0,false,true,6,'M');

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
        $pdf->MultiCell (25,5,'S/0',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

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
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

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
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (17,$y2+108);
        $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');

        $pdf->SetXY (158,$y2+108);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Operacion:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (10,5,'9313',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (138,$y2+113);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Pagamento:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,5,'Recaudación BBVA',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+118);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,'31/05/2022',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->Output('Nota_Credito.pdf', 'I');
    }

    public function Pdf_Nota_Debito($id_pago){
        $get_id= $this->Model_CursosCortos->get_id_pago($id_pago);

        $modelonumero = new modelonumero();
        $total_texto = $modelonumero->numtoletras(abs($get_id[0]['monto']),'Soles','centimos');

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
        $pdf->MultiCell (75,9,'NOTA DE DEBITO',0,'C',1,0,'','',true,0,false,true,9,'M');

        $pdf->SetFont('helvetica','',12);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFillColor(233,170,205);
        $pdf->SetXY (127,$y2-11);
        $pdf->MultiCell (75,8,'RUC: 20600585313',0,'C',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetFont('helvetica','B',12);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY (127,$y2-3);
        $pdf->MultiCell (75,8,'FV01 - 00001251',0,'C',1,0,'','',true,0,false,true,8,'M');

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
        $pdf->MultiCell (165,6,$get_id[0]['fecha_emision'],0,'L',1,0,'','',true,0,false,true,6,'M');
        
        $pdf->SetXY (17,$y2+31);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (20,6,'Alumno(a):',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,6,'M');
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
        $pdf->MultiCell (13,6,$get_id[0]['cod_arpay'],0,'L',1,0,'','',true,0,false,true,6,'M');

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
        $pdf->MultiCell (25,5,'S/0',1,'C',1,0,'','',true,0,false,true,5,'M');
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

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
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

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
        $pdf->MultiCell (25,5,'S/'.$get_id[0]['monto'],1,'C',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (17,$y2+108);
        $pdf->MultiCell (32,15,'Este documento puede ser validado en www.gllg.edu.pe',0,'L',1,0,'','',true,0,false,true,15,'M');

        $pdf->SetXY (158,$y2+108);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Operacion:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (10,5,'9313',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (138,$y2+113);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Pagamento:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (30,5,'Recaudación BBVA',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->SetXY (150,$y2+118);
        $pdf->SetFont('helvetica','B',9);
        $pdf->MultiCell (32,5,'Fecha Vencimiento:',0,'R',1,0,'','',true,0,false,true,5,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (18,5,'31/05/2022',0,'R',1,0,'','',true,0,false,true,5,'M');

        $pdf->Output('Nota_Debito.pdf', 'I');
    }

    public function Boleta($id_documento){
        $get_id= $this->Model_CursosCortos->get_id_documento_pago_alumno($id_documento);

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
        $pdf->MultiCell (20,6,'Alumno(a):',0,'L',1,0,'','',true,0,false,true,6,'M');
        $pdf->SetFont('helvetica','',9);
        $pdf->MultiCell (126,6,$get_id[0]['nom_alumno'],0,'L',1,0,'','',true,0,false,true,6,'M');
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
        $pdf->MultiCell (13,6,$get_id[0]['cod_arpay'],0,'L',1,0,'','',true,0,false,true,6,'M');

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
        $pdf->MultiCell (25,5,'S/'.number_format(($get_id[0]['monto']-$get_id[0]['descuento']),2),1,'C',1,0,'','',true,0,false,true,5,'M');

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

    public function Recibo_Electronico($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_documento_pago_alumno($id_documento);
            //$dato['list_detalle'] = $this->model_CursosCortos->get_list_venta_detalle($id_venta);
            $cantidad_filas = 30;//*count($dato['list_detalle']); 
            $dato['altura'] = 500+$cantidad_filas; 

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_CC/alumno/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output(); 
        }else{
            redirect('');
        }
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/grado/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Grado() {
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado();
            $this->load->view('view_CC/grado/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/grado/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['nom_grado']= $this->input->post("nom_grado_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_CursosCortos->valida_insert_grado($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_CursosCortos->insert_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Grado($id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_grado($id_grado);
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/grado/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado"); 
            $dato['nom_grado']= $this->input->post("nom_grado_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Model_CursosCortos->valida_update_grado($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_CursosCortos->update_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $this->Model_CursosCortos->delete_grado($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Grado(){
        $list_grado = $this->Model_CursosCortos->get_list_grado();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/seccion/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Seccion() {
        if ($this->session->userdata('usuario')) {
            $dato['list_seccion'] = $this->Model_CursosCortos->get_list_seccion();
            $this->load->view('view_CC/seccion/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/seccion/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado_i");
            $dato['nom_seccion']= $this->input->post("nom_seccion_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Model_CursosCortos->valida_insert_seccion($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_CursosCortos->insert_seccion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Seccion($id_seccion){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_seccion($id_seccion);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/seccion/modal_editar', $dato);   
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

            $validar = $this->Model_CursosCortos->valida_update_seccion($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_CursosCortos->update_seccion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Seccion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_seccion']= $this->input->post("id_seccion");
            $this->Model_CursosCortos->delete_seccion($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Seccion(){
        $list_seccion = $this->Model_CursosCortos->get_list_seccion();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/documento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_CursosCortos->get_list_documento();
            $this->load->view('view_CC/documento/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $this->load->view('view_CC/documento/modal_registrar',$dato);   
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

        $total=count($this->Model_CursosCortos->valida_insert_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_documento($dato);

            //INSERTAR DOCUMENTOS A TODOS LOS ALUMNOS PASADOS Y FUTUROS
            if($dato['aplicar_todos']==1){
                $get_id = $this->Model_CursosCortos->ultimo_id_documento();
                $dato['id_documento'] = $get_id[0]['id_documento'];
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_CursosCortos->get_list_alumno_combo();

                foreach($list_alumno as $list){
                    if($list['id_grado']==$dato['id_grado'] || $dato['id_grado']=="0"){
                        $dato['id_alumno'] = $list['id_alumno'];
                        $this->Model_CursosCortos->insert_documento_todos($dato);
                    }
                }
            }
        }
    }

    public function Modal_Update_Documento($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_documento($id_documento);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_status'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/documento/modal_editar', $dato);   
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

        $total=count($this->Model_CursosCortos->valida_update_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->update_documento($dato);

            //INSERTAR DOCUMENTOS A TODOS LOS ALUMNOS PASADOS Y FUTUROS
            if($dato['aplicar_todos']==1){
                $dato['anio'] = date('Y');
                $list_alumno = $this->Model_CursosCortos->get_list_alumno_combo();

                foreach($list_alumno as $list){
                    if($list['id_grado']==$dato['id_grado'] || $dato['id_grado']=="0"){
                        $dato['id_alumno'] = $list['id_alumno'];
                        $valida = $this->Model_CursosCortos->valida_insert_documento_todos($dato);
    
                        if(count($valida)==0){
                            $this->Model_CursosCortos->insert_documento_todos($dato);
                        }
                    }
                }
            }
        }
    }

    public function Delete_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_CursosCortos->delete_documento($dato);
    }

    public function Excel_Documento(){
        $list_documento = $this->Model_CursosCortos->get_list_documento();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/matricula/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula() {
        if ($this->session->userdata('usuario')) {
            $parametro = $this->input->post("parametro");
            $dato['list_matricula'] = $this->Model_CursosCortos->get_list_matricula($parametro);
            $this->load->view('view_CC/matricula/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Matricula() {
        if ($this->session->userdata('usuario')) {
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_parentesco'] = $this->Model_CursosCortos->get_list_parentesco();
            $dato['list_medio'] = $this->Model_CursosCortos->get_list_medios();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_documento'] = $this->Model_CursosCortos->get_list_documento_combo();
            $dato['datos_alumno'] = $this->Model_CursosCortos->get_id_datos_alumno();
            $dato['datos_documento'] = $this->Model_CursosCortos->get_id_datos_documento();
            $dato['datos_matricula'] = $this->Model_CursosCortos->get_id_datos_matricula();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/matricula/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Busca_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_CursosCortos->busca_provincia($id_departamento);
            $this->load->view('view_CC/matricula/provincia', $dato);
        } else {
            redirect('');
        }
    }

    public function Busca_Distrito(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $id_provincia = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_distrito'] = $this->Model_CursosCortos->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('view_CC/matricula/distrito', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_CursosCortos->busca_provincia($id_departamento);
            $this->load->view('view_CC/matricula/provincia_alumno', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Producto(){
        if ($this->session->userdata('usuario')) {
            $id_grado = $this->input->post("id_grado");
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto_combo($id_grado);
            $this->load->view('view_CC/matricula/producto', $dato);
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
            $dato['list_distrito'] = $this->Model_CursosCortos->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('view_CC/matricula/distrito_alumno', $dato);
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

            $validar = $this->Model_CursosCortos->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_CursosCortos->update_datos_alumno($dato);
            }else{
                $this->Model_CursosCortos->insert_datos_alumno($dato);
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
            $this->Model_CursosCortos->update_datos_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_alumno();
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_provincia_alum'] = $this->Model_CursosCortos->busca_provincia($dato['get_id'][0]['id_departamento_alum']);
            $dato['list_distrito_alum'] = $this->Model_CursosCortos->busca_distrito($dato['get_id'][0]['id_departamento_alum'],$dato['get_id'][0]['id_provincia_alum']);
            $this->load->view('view_CC/matricula/datos_alumno', $dato);
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

            $validar = $this->Model_CursosCortos->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_CursosCortos->update_datos_tutor($dato);
            }else{
                $this->Model_CursosCortos->insert_datos_tutor($dato);
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
            $this->Model_CursosCortos->update_datos_tutor($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_alumno();
            $dato['list_parentesco'] = $this->Model_CursosCortos->get_list_parentesco();
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_provincia_prin'] = $this->Model_CursosCortos->busca_provincia($dato['get_id'][0]['id_departamento_prin']);
            $dato['list_distrito_prin'] = $this->Model_CursosCortos->busca_distrito($dato['get_id'][0]['id_departamento_prin'],$dato['get_id'][0]['id_provincia_prin']);
            $dato['list_provincia_secu'] = $this->Model_CursosCortos->busca_provincia($dato['get_id'][0]['id_departamento_secu']);
            $dato['list_distrito_secu'] = $this->Model_CursosCortos->busca_distrito($dato['get_id'][0]['id_departamento_secu'],$dato['get_id'][0]['id_provincia_secu']);
            $this->load->view('view_CC/matricula/datos_tutor', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['donde_conocio']= $this->input->post("donde_conocio");

            $validar = $this->Model_CursosCortos->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_CursosCortos->update_datos_informacion($dato);
            }else{
                $this->Model_CursosCortos->insert_datos_informacion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_alumno");
            $dato['donde_conocio']= $this->input->post("donde_conocio");
            $this->Model_CursosCortos->update_datos_informacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_alumno();
            $dato['list_medio'] = $this->Model_CursosCortos->get_list_medios();
            $this->load->view('view_CC/matricula/datos_informacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

            $list_documento = $this->Model_CursosCortos->get_list_documento_combo();

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

                    $this->Model_CursosCortos->insert_datos_documento($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

            $list_documento = $this->Model_CursosCortos->get_list_documento_combo();

            foreach($list_documento as $list){
                if($_FILES["documento_".$list['id_documento']]["name"] != ""){
                    $valida = $this->Model_CursosCortos->valida_insert_datos_documento($list['id_documento']);
                    if(count($valida)>0){
                        unlink($valida[0]['archivo']);
                        $this->Model_CursosCortos->delete_datos_documento($list['id_documento']);
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
                    
                    $this->Model_CursosCortos->insert_datos_documento($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_documento();
            $dato['list_documento'] = $this->Model_CursosCortos->get_list_documento_combo();
            $this->load->view('view_CC/matricula/datos_documento', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Documento($id_documento) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_CursosCortos->valida_insert_datos_documento($id_documento);
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

            $validar = $this->Model_CursosCortos->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_CursosCortos->update_datos_matricula($dato);
            }else{
                $this->Model_CursosCortos->insert_datos_matricula($dato);
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
            $this->Model_CursosCortos->update_datos_matricula($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_matricula();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_producto'] = $this->Model_CursosCortos->get_list_producto_combo($dato['get_id'][0]['id_grado']);
            $this->load->view('view_CC/matricula/datos_matricula', $dato);
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

            $validar = $this->Model_CursosCortos->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_CursosCortos->update_datos_confirmacion($dato);
            }else{
                $this->Model_CursosCortos->insert_datos_confirmacion($dato);
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

            $this->Model_CursosCortos->update_datos_confirmacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Confirmacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_matricula();
            $this->load->view('view_CC/matricula/datos_confirmacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Matricula($orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_CursosCortos->get_id_datos_matricula();
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
            $get_id = $this->Model_CursosCortos->get_id_datos_alumno();

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
            $validar_alumno = $this->Model_CursosCortos->validar_temporal_datos_alumno();
            $validar_matricula = $this->Model_CursosCortos->validar_temporal_datos_matricula();
            if(count($validar_alumno)==0 || count($validar_matricula)==0){
                echo "error";
            }
        }else{
            redirect('');
        }
    }

    public function Pdf_Hoja_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_datos_alumno();
            $dato['get_matricula'] = $this->Model_CursosCortos->get_id_datos_matricula();
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_CC/matricula/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Insert_Matricula(){
        if ($this->session->userdata('usuario')) {
            $datos_alumno = $this->Model_CursosCortos->get_id_datos_alumno();
            $datos_documento = $this->Model_CursosCortos->get_id_datos_documento();
            $datos_matricula = $this->Model_CursosCortos->get_id_datos_matricula();

            if(count($datos_alumno)>0 && count($datos_matricula)==0){
                echo "alumno";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)>0){
                echo "matricula";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)==0){
                echo "error";
            }else{
                $anio=date('Y');
                $query_id = $this->Model_CursosCortos->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
                $totalRows_t = count($query_id);
        
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigo="CC1-".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                    $codigo="CC1-".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>98){
                    $codigo="CC1-".$aniof.($totalRows_t+1);
                }
    
                $dato['cod_alum'] = $codigo;
    
                $this->Model_CursosCortos->insert_alumno_matricula($dato);
    
                $get_id = $this->Model_CursosCortos->ultimo_id_alumno();
                $dato['id_alumno'] = $get_id[0]['id_alumno'];

                //INSERTAR DOCUMENTOS AL ALUMNO
                $this->Model_CursosCortos->insert_documentos_alumno($dato);

                //DATOS DE DOCUMENTOS

                /*$list_documento = $this->Model_CursosCortos->get_list_documento_combo();

                foreach($list_documento as $list){
                    $valida = $this->Model_CursosCortos->valida_insert_datos_documento($list['id_documento']);
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
                        $this->Model_CursosCortos->insert_documento_alumno($dato);
                    }
                }*/

                //DATOS DE MATRÍCULA

                $get_matricula = $this->Model_CursosCortos->ultimo_id_matricula();
                $id_matricula = $get_matricula[0]['id_matricula']+1;
                
                $dato['hoja_matricula'] = "";
                $dato['contrato'] = "";

                if($datos_matricula[0]['hoja_matricula']!=""){
                    $config['upload_path'] = './documento_matricula_cc/hoja_matricula/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula_cc/', 0777);
                        chmod('./documento_matricula_cc/hoja_matricula/', 0777);
                        chmod('./documento_matricula_cc/hoja_matricula/'.$id_matricula, 0777);
                    }
                    $desde_hoja_matricula = 45+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['hoja_matricula'],'documento_matricula_cc/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula));
                    unlink($datos_matricula[0]['hoja_matricula']);
                    $dato['hoja_matricula'] = 'documento_matricula_cc/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula);
                }

                if($datos_matricula[0]['contrato']!=""){
                    $config['upload_path'] = './documento_matricula_cc/contrato/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula_cc/', 0777);
                        chmod('./documento_matricula_cc/contrato/', 0777);
                        chmod('./documento_matricula_cc/contrato/'.$id_matricula, 0777);
                    }
                    $desde_contrato = 39+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['contrato'],'documento_matricula_cc/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato));
                    unlink($datos_matricula[0]['contrato']);
                    $dato['contrato'] = 'documento_matricula_cc/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato);
                }
                
                $this->Model_CursosCortos->insert_matricula_alumno($dato);
                $this->Model_CursosCortos->delete_temporales();

                //ALUMNO - COMPRAS

                $get_matricula = $this->Model_CursosCortos->ultimo_id_matricula();
                $dato['id_matricula'] = $get_matricula[0]['id_matricula'];

                $articulo = explode(",",$get_matricula[0]['id_articulo']);

                $i = 0;
                while($i<count($articulo)){
                    $get_articulo = $this->Model_CursosCortos->get_id_articulo($articulo[$i]);

                    if($get_articulo[0]['id_tipo']==2){
                        $list_mes = $this->Model_CursosCortos->get_list_mes_matricula($get_matricula[0]['fec_matricula']);

                        foreach($list_mes as $list){
                            $dato['nom_pago'] = "Pensión ".$list['nom_mes']." ".$get_articulo[0]['anio'];
                            $dato['monto'] = $get_articulo[0]['monto'];
                            $dato['fec_vencimiento'] = substr($get_matricula[0]['fec_matricula'],0,4)."-".$list['cod_mes']."-05";
                            $this->Model_CursosCortos->insert_pago_matricula_alumno($dato);
                        }
                    }else{
                        $dato['nom_pago'] = $get_articulo[0]['nombre'];
                        $dato['monto'] = $get_articulo[0]['monto'];
                        $dato['fec_vencimiento'] = "";
                        $this->Model_CursosCortos->insert_pago_matricula_alumno($dato);
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matricula($parametro){
        $list_matricula = $this->Model_CursosCortos->get_list_matricula($parametro);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/curso/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Curso() {
        if ($this->session->userdata('usuario')) {
            $dato['list_curso'] = $this->Model_CursosCortos->get_list_curso();
            $this->load->view('view_CC/curso/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Curso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_curso_copiar'] = $this->Model_CursosCortos->get_list_curso_combo();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/curso/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Curso_Copiar(){
        if ($this->session->userdata('usuario')) {
            $dato['id_copiar']= $this->input->post("id_copiar"); 
            $dato['get_id'] = $this->Model_CursosCortos->get_list_curso($dato['id_copiar']);
            $dato['list_curso_copiar'] = $this->Model_CursosCortos->get_list_curso_combo();
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $this->load->view('view_CC/curso/curso_copiar',$dato);   
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

        $valida = $this->Model_CursosCortos->valida_insert_curso($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_curso($dato);
        }
    }

    public function Modal_Update_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/curso/editar',$dato);   
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

        $valida = $this->Model_CursosCortos->valida_update_curso($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->update_curso($dato);
        }
    }

    public function Excel_Curso(){
        $list_curso = $this->Model_CursosCortos->get_list_curso();

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
            $dato['get_id'] = $this->Model_CursosCortos->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_anio'] = $this->Model_CursosCortos->get_list_anio();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/curso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Seccion_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_seccion'] = $this->Model_CursosCortos->get_list_seccion_curso($id_curso);
            $this->load->view('view_CC/curso/lista_seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Vista_Asignar_Seccion($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_curso($id_curso);
            $dato['list_seccion'] = $this->Model_CursosCortos->get_list_seccion_combo($dato['get_id'][0]['id_grado']);
            $dato['list_alumno'] = $this->Model_CursosCortos->get_list_alumno_asignar_seccion($dato['get_id'][0]['id_grado']);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/curso/asignar_seccion',$dato);
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
                    $this->Model_CursosCortos->update_curso_matricula_alumno($dato);
                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_Requisito_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_requisito_curso'] = $this->Model_CursosCortos->get_list_requisito_curso($id_curso);
            $this->load->view('view_CC/curso/lista_requisito',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Requisito($id_curso){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_list_curso($id_curso);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_tipo_requisito'] = $this->Model_CursosCortos->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/curso/modal_registrar_requisito',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Requisito(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_grado']= $this->input->post("id_grado_i");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito_i"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito_i");
        $this->Model_CursosCortos->insert_requisito($dato);  
    }

    public function Modal_Update_Requisito($id_requisito){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_requisito($id_requisito);
            $dato['list_grado'] = $this->Model_CursosCortos->get_list_grado_combo();
            $dato['list_tipo_requisito'] = $this->Model_CursosCortos->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/curso/modal_editar_requisito',$dato);   
        }else{
            redirect('/login');
        }
    }  

    public function Update_Requisito(){
        $dato['id_requisito']= $this->input->post("id_requisito");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito_u"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito_u");
        $dato['estado']= $this->input->post("estado_u"); 
        $this->Model_CursosCortos->update_requisito($dato);  
    }

    public function Lista_Alumno_Curso() {
        if ($this->session->userdata('usuario')) { 
            $id_curso = $this->input->post("id_curso");
            $dato['list_alumno_curso'] = $this->Model_CursosCortos->get_list_alumno_curso($id_curso);
            $this->load->view('view_CC/curso/lista_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Alumno_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_CursosCortos->get_list_curso($id_curso);
            $dato['list_alumno'] = $this->Model_CursosCortos->get_list_alumno_grado_combo($get_id[0]['id_grado']);
            $dato['id_curso'] = $id_curso;
            $this->load->view('view_CC/curso/modal_registrar_alumno_curso',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno_Curso(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_alumno']= $this->input->post("id_alumno_c");

        $validar = $this->Model_CursosCortos->valida_insert_alumno_curso($dato); 

        if(count($validar)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_alumno_curso($dato); 
        }
    }

    public function Cerrar_Curso(){
        if ($this->session->userdata('usuario')) {
            $id_curso =$this->input->post("id_curso");

            /*$total=count($this->Model_CursosCortos->valida_cerrar_curso($id_curso));

            if($total>0){
                echo "error";
            }else{*/
                $this->Model_CursosCortos->cerrar_curso($id_curso);
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/exportacion_bbva/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Exportacion_Bbva() {
        if ($this->session->userdata('usuario')) {
            $dato['list_exportacion_bbva'] = $this->Model_CursosCortos->get_list_exportacion_bbva();
            $this->load->view('view_CC/exportacion_bbva/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Exportacion_Bbva(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_CC/exportacion_bbva/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Exportacion_Bbva(){
        if ($this->session->userdata('usuario')) {
            $dato['tipo_operacion']= $this->input->post("tipo_operacion_i");
            $dato['fec_inicio']= $this->input->post("fec_inicio_i");
            $dato['fec_fin']= $this->input->post("fec_fin_i"); 
            $this->Model_CursosCortos->insert_exportacion_bbva($dato);
        }else{
            redirect('/login');
        }
    }

    public function Generar_Txt($id_exportacion){
        $get_id = $this->Model_CursosCortos->get_list_exportacion_bbva($id_exportacion);
        $list_archivo = $this->Model_CursosCortos->get_list_archivo_txt($get_id[0]['fec_inicio'],$get_id[0]['fec_fin']);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/doc_alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Doc_Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_CursosCortos->get_list_todos_alumno();
            $this->load->view('view_CC/doc_alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Doc_Alumno(){
        $list_alumno = $this->Model_CursosCortos->get_list_todos_alumno();
        $list_documento = $this->Model_CursosCortos->get_list_doc_alumnos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Doc. Alumnos');

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

        $sheet->getStyle('A1:R2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:R2")->getFill()
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

        $sheet->getStyle("A1:R2")->applyFromArray($styleThinBlackBorderOutline);

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
        $sheet->mergeCells("Q1:Q2");
        $sheet->mergeCells("R1:R2");

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
        
        $primera_letra = "S";
        $segunda_letra = "T";
        $tercera_letra = "U";

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
        }

        $contador=2;
        
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

            $primera_letra = "S";
            $segunda_letra = "T";
            $tercera_letra = "U";

            foreach($list_documento as $documento){
                $sheet->getStyle("$primera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$segunda_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$tercera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $list_detalle = $this->Model_CursosCortos->get_list_detalle_doc_alumnos($list['id_alumno'],$documento['cod_documento']);

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
            }
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/alumno_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno_Obs() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_alumno_obs'] = $this->Model_CursosCortos->get_list_alumno_obs();
            $this->load->view('view_CC/alumno_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Alumno_Obs(){
        $list_alumno_obs = $this->Model_CursosCortos->get_list_alumno_obs();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos Obs.');

        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(24);
        $sheet->getColumnDimension('I')->setWidth(100);
        

        $sheet->getStyle('A1:I2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:I2")->getFill()
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

        $sheet->getStyle("A1:I2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->mergeCells("A1:A2");
        $sheet->mergeCells("B1:B2");
        $sheet->mergeCells("C1:C2");
        $sheet->mergeCells("D1:D2");
        $sheet->mergeCells("E1:E2");
        $sheet->mergeCells("F1:F2");
        $sheet->mergeCells("G1:G2");
        $sheet->mergeCells("H1:H2");
        $sheet->mergeCells("I1:I2");

        $sheet->setCellValue("A1", 'Empresa');	        
        $sheet->setCellValue("B1", 'Fecha');	        
        $sheet->setCellValue("C1", 'Usuario');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Apellido Pat.');
        $sheet->setCellValue("F1", 'Apellido Mat.');
        $sheet->setCellValue("G1", 'Nombre(s)');	
        $sheet->setCellValue("H1", 'Sección');	  
        $sheet->setCellValue("I1", 'Comentario');

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

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $comentario = $list['Comentario'];
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
            $sheet->setCellValue("H{$contador}", $list['nom_seccion']); 
            $sheet->setCellValue("I{$contador}", $comentario);
            
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/soporte_doc/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Soporte_Doc() { 
        if ($this->session->userdata('usuario')) {
            $dato['list_soporte_doc'] = $this->Model_CursosCortos->get_list_soporte_doc();
            $this->load->view('view_CC/soporte_doc/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Soporte_Doc(){
        $list_soporte_doc = $this->Model_CursosCortos->get_list_soporte_doc();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/mailing/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mail() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['list_status'] = $this->Model_CursosCortos->get_list_status_combo();


            $dato['list_alumnos'] = $this->Model_CursosCortos->get_list_alumnos_ll();
            $dato['get_list_grado_ll'] = $this->Model_CursosCortos->get_list_grado_ll();
            $dato['get_list_seccion_ll'] = $this->Model_CursosCortos->get_list_seccion_ll();


            $this->load->view('view_CC/mailing/modal_registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function List_seccion() {
        if ($this->session->userdata('usuario')) {
          
            $grado = $this->input->post("grado");

            $datos = $this->Model_CursosCortos->get_list_seccion_id($grado);
            

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
          
            $tipo= 'cc';
            $datos = $this->Model_CursosCortos->listar_mail_emprea($tipo);

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
            $datos = $this->Model_CursosCortos->listar_mail_alumnos($id_correo_empre);

            if($datos[0]["id_alumno"]=== ''){
                $todos = $this->Model_CursosCortos->get_list_alumnos_id($datos[0]["id_seccion"],$datos[0]["id_grado"]);
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
                    $listado = $this->Model_CursosCortos->listar_mail_alumnos_nombres($listado);
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

   

            $this->Model_CursosCortos->delete_email_empresa($dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Mailing() {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $tipo= 'bl';

            $num_datos = count($this->Model_CursosCortos->listar_mail_emprea($tipo));
            $anio=date('Y');
            $dato['anio']= $this->input->post("anio");
            
            $totalRows_rm = count($this->Model_CursosCortos->listar_mail_emprea($tipo));

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
            
            $id_data=$this->Model_CursosCortos->insert_correos_empresas($dato);

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
                    $this->Model_CursosCortos->insert_correos_empresas_arch($nombre_arch_final,$id,$nombre_arch);
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

                    $correos =$this->Model_CursosCortos->listado_correos_alumno(
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
    }
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/colaborador/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador(){
        if($this->session->userdata('usuario')){
            $tipo = $this->input->post("tipo");
            $dato['list_colaborador'] = $this->Model_CursosCortos->get_list_colaborador($tipo);
            $this->load->view('view_CC/colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_perfil'] = $this->Model_CursosCortos->get_list_perfil();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/colaborador/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($id_departamento);
            $this->load->view('view_CC/colaborador/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($id_provincia);
            $this->load->view('view_CC/colaborador/distrito',$dato);   
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
        $dato['correo_personal'] = $this->input->post("correo_personal");
        $dato['correo_corporativo'] = $this->input->post("correo_corporativo");
        $dato['celular'] = $this->input->post("celular");
        $dato['direccion'] = $this->input->post("direccion");
        $dato['id_departamento'] = $this->input->post("id_departamento");
        $dato['id_provincia'] = $this->input->post("id_distrito");
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
                $cantidad = (count($this->Model_CursosCortos->get_cantidad_colaborador()))+1;
    
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
    
            $this->Model_CursosCortos->insert_colaborador($dato);
        }else{

            $valida = $this->Model_CursosCortos->valida_insert_usuario_colaborador($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                if($_FILES["foto"]["name"] != ""){
                    $cantidad = (count($this->Model_CursosCortos->get_cantidad_colaborador()))+1;
        
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
        
                $this->Model_CursosCortos->insert_colaborador($dato);
                $ultimo = $this->Model_CursosCortos->ultimo_id_colaborador();
                $dato['id_externo'] = $ultimo[0]['id_colaborador'];
                $this->Model_CursosCortos->insert_usuario_colaborador($dato);
            }
        }
    }

    public function Editar_Colaborador($id_colaborador){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_CursosCortos->get_id_colaborador($id_colaborador);
            $dato['list_perfil'] = $this->Model_CursosCortos->get_list_perfil();
            $dato['list_departamento'] = $this->Model_CursosCortos->get_list_departamento();
            $dato['list_provincia'] = $this->Model_CursosCortos->get_list_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_CursosCortos->get_list_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/colaborador/editar', $dato);
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

            $this->Model_CursosCortos->update_colaborador($dato);
        }else{
            $valida = $this->Model_CursosCortos->valida_update_usuario_colaborador($dato);

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
                
                $this->Model_CursosCortos->update_colaborador($dato);
                $dato['id_externo'] = $dato['id_colaborador']; 

                $valida = $this->Model_CursosCortos->valida_insert_users_colaborador($dato);

                if(count($valida)>0){
                    $this->Model_CursosCortos->update_usuario_colaborador($dato);
                }else{
                    $this->Model_CursosCortos->insert_usuario_colaborador($dato);
                }
            } 
        }
    }

    public function Descargar_Foto_Colaborador($id_colaborador) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_CursosCortos->get_id_colaborador($id_colaborador);
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
        $this->Model_CursosCortos->delete_colaborador($dato);
    }

    public function Excel_Colaborador($tipo){ 
        $list_colaborador = $this->Model_CursosCortos->get_list_colaborador($tipo);

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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_colaborador($id_colaborador);
            $dato['list_tipo_obs'] = $this->Model_CursosCortos->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_CursosCortos->get_list_usuario_obs();

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/colaborador/detalle', $dato);
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

        $this->Model_CursosCortos->update_cv_colaborador($dato);
    }

    public function Lista_Contrato_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_contrato'] = $this->Model_CursosCortos->get_list_contrato_colaborador($id_colaborador);
            $this->load->view('view_CC/colaborador/lista_contrato', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Contrato_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_CC/colaborador/modal_registrar_contrato',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Contrato_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['nom_contrato'] = $this->input->post("nom_contrato_i");
        $dato['fecha'] = $this->input->post("fecha_i");
        $dato['archivo'] = "";

        $valida = $this->Model_CursosCortos->valida_insert_contrato_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            if($_FILES["archivo_i"]["name"] != ""){
                $cantidad = (count($this->Model_CursosCortos->get_cantidad_contrato_colaborador()))+1;
    
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

            $this->Model_CursosCortos->insert_contrato_colaborador($dato);
        }
    }

    public function Modal_Update_Contrato_Colaborador($id_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_contrato_colaborador($id_contrato);
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/colaborador/modal_editar_contrato', $dato);
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

        $valida = $this->Model_CursosCortos->valida_update_contrato_colaborador($dato);

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

            $this->Model_CursosCortos->update_contrato_colaborador($dato);
        }
    }

    public function Descargar_Contrato_Colaborador($id_contrato) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_CursosCortos->get_id_contrato_colaborador($id_contrato);
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
        $this->Model_CursosCortos->delete_contrato_colaborador($dato);
    }

    public function Lista_Pago_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_pago'] = $this->Model_CursosCortos->get_list_pago_colaborador($id_colaborador);
            $this->load->view('view_CC/colaborador/lista_pago', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Pago_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_CC/colaborador/modal_registrar_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Pago_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_banco'] = $this->input->post("id_banco_i");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_i");

        $valida = $this->Model_CursosCortos->valida_insert_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_pago_colaborador($dato);
        }
    }

    public function Modal_Update_Pago_Colaborador($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_CursosCortos->get_id_pago_colaborador($id_pago);
            $dato['list_estado'] = $this->Model_CursosCortos->get_list_estado();
            $this->load->view('view_CC/colaborador/modal_editar_pago', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $dato['id_banco'] = $this->input->post("id_banco_u");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_u");
        $dato['estado'] = $this->input->post("estado_u"); 

        $valida = $this->Model_CursosCortos->valida_update_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_CursosCortos->update_pago_colaborador($dato);
        }
    }

    public function Delete_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $this->Model_CursosCortos->delete_pago_colaborador($dato);
    }

    public function Lista_Asistencia_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_asistencia'] = $this->Model_CursosCortos->get_list_asistencia_colaborador($id_colaborador);
            $this->load->view('view_CC/colaborador/lista_asistencia', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Ingresos_Colaborador($id_colaborador){
        $list_asistencia = $this->Model_CursosCortos->get_list_asistencia_colaborador($id_colaborador);

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
            $dato['list_observacion']=$this->Model_CursosCortos->get_list_observacion_colaborador($id_colaborador);
            $this->load->view('view_CC/colaborador/lista_observacion',$dato);
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

        $valida = $this->Model_CursosCortos->valida_insert_observacion_colaborador($dato);

        if(count($valida)>0){
            echo "error";
        }else{
            $this->Model_CursosCortos->insert_observacion_colaborador($dato);
        }
    }

    public function Delete_Observacion_Colaborador() {
        $dato['id_observacion'] = $this->input->post("id_observacion");
        $this->Model_CursosCortos->delete_observacion_colaborador($dato);
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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();
    
            $this->load->view('view_CC/retirados/index', $dato);

        }else{
            redirect('');
        }
    }

    public function Lista_Retirados(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_retirados'] = $this->Model_CursosCortos->get_list_retirados();
            $this->load->view('view_CC/retirados/lista', $dato);
        }else{
            redirect('');
        }
    }

    public function Excel_Retirados(){
        $list_retirados = $this->Model_CursosCortos->get_list_retirados($tipo);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/cierre_caja/index',$dato);  
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Cierre_Caja() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_cierre_caja'] = $this->Model_CursosCortos->get_list_cierre_caja($tipo);
            $this->load->view('view_CC/cierre_caja/lista',$dato);
        }else{ 
            redirect('/login');
        }
    }

    public function Modal_Cierre_Caja(){
        if ($this->session->userdata('usuario')) { 
            $fecha = date('Y-m-d');
            $dato['list_usuario'] = $this->Model_CursosCortos->get_list_usuario_codigo();
            $dato['get_saldo'] = $this->Model_CursosCortos->get_saldo_automatico($_SESSION['usuario'][0]['id_usuario'],$fecha);
            $dato['get_producto'] = $this->Model_CursosCortos->get_productos($_SESSION['usuario'][0]['id_usuario'],$fecha);
            $this->load->view('view_CC/cierre_caja/modal_registrar',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Saldo_Fecha(){ 
        if ($this->session->userdata('usuario')) {
            $id_vendedor = $this->input->post("id_vendedor"); 
            $fecha = $this->input->post("fecha"); 
            $dato['get_saldo'] = $this->Model_CursosCortos->get_saldo_automatico($id_vendedor,$fecha);
            $this->load->view('view_CC/cierre_caja/saldo',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Productos_Fecha(){ 
        if ($this->session->userdata('usuario')) {
            $id_vendedor = $this->input->post("id_vendedor"); 
            $fecha = $this->input->post("fecha"); 
            $get_producto = $this->Model_CursosCortos->get_productos($id_vendedor,$fecha);
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

            $validar = $this->Model_CursosCortos->valida_insert_cierre_caja($dato);

            if(count($validar)>0){
                $dato['id_cierre_caja'] = $validar[0]['id_cierre_caja'];
                $this->Model_CursosCortos->update_cierre_caja($dato);
                echo $dato['id_cierre_caja'];
            }else{
                $dato['fecha_valida']= $this->input->post("fecha_i"); 
                $valida_movimiento = $this->Model_CursosCortos->valida_venta_cierre_caja($dato);

                if($valida_movimiento[0]['cantidad']>0){
                    $dato['fecha_valida'] = date("Y-m-d",strtotime($dato['fecha']."- 1 day"));
                    $cantidad = $this->Model_CursosCortos->valida_venta_cierre_caja($dato);

                    if($cantidad[0]['cantidad']>0){
                        $validar = $this->Model_CursosCortos->valida_ultimo_cierre_caja($dato);

                        if(count($validar)>0){ 
                            $this->Model_CursosCortos->insert_cierre_caja($dato);
                            $get_id = $this->Model_CursosCortos->ultimo_id_cierre_caja(); 
                            echo $get_id[0]['id_cierre_caja'];
                        }else{
                            $fecha_anterior = date("d-m-Y",strtotime($dato['fecha']."- 1 day"));
                            echo "no_cierre*".$fecha_anterior;
                        }
                    }else{
                        $this->Model_CursosCortos->insert_cierre_caja($dato);
                        $get_id = $this->Model_CursosCortos->ultimo_id_cierre_caja();
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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_cierre_caja($id_cierre_caja);

            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('view_CC/cierre_caja/recibo',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Delete_Cierre_Caja(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $this->Model_CursosCortos->delete_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cierre_Caja($tipo){
        $list_cierre_caja = $this->Model_CursosCortos->get_list_cierre_caja($tipo);

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
            $dato['get_id'] = $this->Model_CursosCortos->get_id_cierre_caja($id_cierre_caja);

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
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();

            $this->load->view('view_CC/cierre_caja/detalle',$dato); 
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Detalle_Cierre_Caja() { 
        if ($this->session->userdata('usuario')) {
            $fecha = $this->input->post("fecha");
            $dato['list_detalle_cierre_caja'] = $this->Model_CursosCortos->get_list_detalle_cierre_caja($fecha);
            $this->load->view('view_CC/cierre_caja/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Cierre_Caja($id_cierre_caja){ 
        if ($this->session->userdata('usuario')) {  
            $dato['get_id'] = $this->Model_CursosCortos->get_id_cierre_caja($id_cierre_caja);
            $this->load->view('view_CC/cierre_caja/modal_editar',$dato);    
        }else{
            redirect('/login');
        }
    }

    public function Update_Cierre_Caja(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cierre_caja']= $this->input->post("id_cierre_caja");
            $dato['cofre']= $this->input->post("cofre_u");
            $this->Model_CursosCortos->update_cofre_cierre_caja($dato);            
        }else{
            redirect('/login');
        }
    }
/*----------------------Registro Comercial------------------------------- */
public function Registro(){
    if ($this->session->userdata('usuario')) { 
        if($_SESSION['usuario'][0]['id_nivel']!=15){ 
            $dato['get_datos_comercial'] = $this->Model_CursosCortos->get_datos_ccortos();
        }

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();
        //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
        
        $this->load->view('view_CC/comercial/registro/index_registro',$dato);
    }
    else{
        redirect('/login');
    }
}

public function Actualizar_Datos_Comercial(){ 
    if($this->session->userdata('usuario')){
        $this->Model_CursosCortos->update_datos_cursos_cortos();
        $dato['get_datos_comercial'] = $this->Model_CursosCortos->get_datos_cursos_cortos();
        $this->load->view('view_CC/comercial/registro/datos_comercial', $dato);
    }else{
        redirect('/login');
    }
}

public function Busqueda_Registro(){ 
    $dato['parametro']= $this->input->post('parametro');
    $dato['anio']= $this->input->post('anio');

    $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
    //$list_empresa = $this->Model_General->get_id_empresa_usuario($id_usuario);
    $dato['list_anio'] = $this->Model_General->get_list_anio();

    $result="";

    /*foreach($list_empresa as $char){
        $result.= $char['id_empresa'].",";
    }
    $cadena = substr($result, 0, -1);

    $dato['cadena'] = "(".$cadena.")";*/
    

    if($dato['parametro']==0){
        $dato['list_registro'] =$this->Model_CursosCortos->get_list_registro_activo($dato);
    }elseif($dato['parametro']==1){
        $dato['list_registro'] =$this->Model_CursosCortos->get_list_registro_todo($dato);
    }else{
        $dato['list_registro_secretaria'] =$this->Model_CursosCortos->get_list_registro_secretaria($dato);
    }

    $this->load->view('view_CC/comercial/registro/busqueda', $dato);
}

    //-------------------------------------PRODUCTO INTERESE--------------------------------------------------
    public function Producto_Interes(){// RRHH {
        if ($this->session->userdata('usuario')) { 
            $dato['list_producto_interes'] =$this->Model_CursosCortos->get_list_producto_interes_index();
            //$dato['list_empresa'] = $this->Admin_model->get_list_empresa_producto_interes();
            //$dato['list_sede'] = $this->Admin_model->get_list_sede_producto_interes();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('view_CC/comercial/producto_interes/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Producto_Interes(){
        $dato['list_empresa'] =$this->Admin_model->get_list_empresa();
        //$dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
        $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();

        $this->load->view('view_CC/comercial/producto_interes/modal_registrar', $dato);
    }

    public function Valida_Producto_Interes(){
        $dato['nom_producto_interes']= $this->input->post("nom_producto_interes");
        $dato['id_empresa']= $this->input->post("empresa");
        $dato['id_sede']= $this->input->post("sede");
        $dato['total']= $this->input->post("total");
        if($dato['total']==1){
            $total2=count($this->Admin_model->valida_producto_interes_total($dato));
        }

        $total=count($this->Admin_model->valida_producto_interes($dato));
        

        if($total>0){
            echo "error";
        }elseif($dato['total']==1){
            if($total2>5){
                echo "total";
            }
        }
    }

    public function Valida_Total_editar(){
        $dato['id_empresa']= $this->input->post("empresa");
        $dato['id_producto_interes']= $this->input->post("id_producto_interes");
        $id_producto_interes= $this->input->post("id_producto_interes");
        $dato['total']= $this->input->post("total");
       // $dato['get_id'] = $this->Admin_model->get_id_producto_interes($id_producto_interes);
        if($dato['total']==1 ){
            //if($dato['get_id'][0]['total']==1){
                $total2=count($this->Admin_model->valida_producto_interes_total_editar1($dato));
                if($total2>5){
                    echo "total";
                }
            /*}else{
                $total2=count($this->Admin_model->valida_producto_interes_total_editar2($dato));
                if($total2>5){
                    echo "total";
                }
            }*/
            
        }

    }

    public function Buscar_Sede_Producto_Interes() {
        if ($this->session->userdata('usuario')) { 
            $id_empresa = $this->input->post("id_empresa");
            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede($id_empresa);
            $this->load->view('view_CC/comercial/producto_interes/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Producto_Interes(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_empresa']= $this->input->post("empresa");
            $dato['id_sede']= $this->input->post("sede");
            $dato['nom_producto_interes']= $this->input->post("nom_producto_interes");
            $dato['orden_producto_interes']= $this->input->post("orden_producto_interes");
            $dato['fecha_inicio']= $this->input->post("fecha_inicio");
            $dato['fecha_fin']= $this->input->post("fecha_fin");  
            $dato['total']= $this->input->post("total");  
            $dato['formulario']= $this->input->post("formulario");  

            /*$total=count($this->Admin_model->valida_producto_interes($dato));

            if($total>0){
                echo "error";
            }else{*/
                if($dato['total']==1){
                    $total2=count($this->Admin_model->valida_producto_interes_total($dato));
                    if($total2==11){
                        echo "total";
                    }else{
                        $this->Admin_model->insert_producto_interes($dato);
                    }
                }else{
                    $this->Admin_model->insert_producto_interes($dato);
                }
            //}
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Producto_Interes($id_producto_interes){
        if ($this->session->userdata('usuario')) { 
            $dato['list_status'] = $this->Admin_model->get_list_estado();
            $dato['list_empresa'] =$this->Admin_model->get_list_empresa();
            //$dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['get_id'] = $this->Admin_model->get_id_producto_interes($id_producto_interes);

            /*$dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['get_empresa'] = $this->Admin_model->get_id_empresa_producto_interes($id_producto_interes);

            $get_empresa = $this->Admin_model->get_id_empresa_producto_interes($id_producto_interes);

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

            $dato['get_sede'] = $this->Admin_model->get_id_sede_producto_interes($id_producto_interes);*/

            $this->load->view('view_CC/comercial/producto_interes/modal_editar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Producto_Interes(){
        $dato['id_producto_interes']= $this->input->post("id_producto_interes");
        $dato['id_empresa']= $this->input->post("empresa");
        $dato['id_sede']= $this->input->post("sede");
        $dato['nom_producto_interes']= $this->input->post("nom_producto_interes");
        $dato['orden_producto_interes']= $this->input->post("orden_producto_interes");
        $dato['fecha_inicio']= $this->input->post("fecha_inicio");
        $dato['fecha_fin']= $this->input->post("fecha_fin");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['total']= $this->input->post("total");   
        $dato['formulario']= $this->input->post("formulario");      
        
        if($dato['total']==1){
            $total2=count($this->Admin_model->valida_producto_interes_total_editar1($dato));
            if($total2==11){
                echo "total";
            }else{
                $this->Admin_model->update_producto_interes($dato);
            }
        }else{
            $this->Admin_model->update_producto_interes($dato);
        }
    }

    public function Excel_Producto_Interes(){
        $list_producto_interes =$this->Model_CursosCortos->get_list_producto_interes_index();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Productos de Interese');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(50);
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

        $sheet->setCellValue("A1", 'Empresa');           
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Interese');
        $sheet->setCellValue("D1", 'Totales');
        $sheet->setCellValue("E1", 'Formulario');
        $sheet->setCellValue("F1", 'Fecha Inicio');
        $sheet->setCellValue("G1", 'Fecha Fin');
        $sheet->setCellValue("H1", 'Status');

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
        $filename = 'Productos Interese Cursos Cortos(Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Duplicar($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            $dato['list_tipo'] =$this->Admin_model->get_row_t();
            $dato['list_subtipo'] = $this->Admin_model->getsubtipo($dato['get_id'][0]['id_tipo'],$dato['get_id'][0]['id_empresa']);
            $this->load->view('view_CC/proyecto/modal_duplicado',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Agregar_Duplicado(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_proyecto']= $this->input->post("id_proyecto");
            $dato['s_redes']= $this->input->post("s_redesd");
            $dato['id_tipo']= $this->input->post("id_tipo_d");
            $dato['id_subtipo']= $this->input->post("id_subtipo_d");
            $dato['fec_agenda']= $this->input->post("fec_agendad");
        
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            
            $dato['mes']=substr($this->input->post("fec_agendad"),5,2);
            $dato['dia']=substr($this->input->post("fec_agendad"),8,2);
            $dato['iniciosf'] = strtotime($dato['fec_agenda']);
            $id_color = $this->Admin_model->get_colorestatus();
            $dato['color']=$id_color;

            $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
            $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

            $this->Admin_model->agregar_duplicado_proyecto($dato);
        }else{
            redirect('/login');
        }
        
    }

    public function Delete_Duplicado(){
        if ($this->session->userdata('usuario')) {
            $dato['fec_inicio']= $this->input->post("fec_inicio");
            $dato['snappy_redes']= $this->input->post("snappy_redes");
            $dato['cod_proyecto']= $this->input->post("cod_proyecto");
            $this->Admin_model->delete_duplicado($dato);
            
        }else{
            redirect('/login');
        }
    }
    //--------------------------------------------//
    public function Modal_Registro_Mail_Mailing(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_CC/comercial/registro/modal_mailing');
        }else{
            redirect('/login');
        }
    }

    public function Plantilla_Mailing(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Plantilla Mailing');

        $sheet->getColumnDimension('A')->setWidth(15);

        $sheet->getStyle('A1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1")->getFill()
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

        $sheet->getStyle("A1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Correos');           

        $writer = new Xlsx($spreadsheet);
        $filename = 'Plantilla Mailing';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Insert_Registro_Mail_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['fecha_accion']= $this->input->post("fecha_envio_m");
            $dato['observacion']= $this->input->post("observacion_m");

            $path = $_FILES["archivo_m"]["tmp_name"];
            $object = IOFactory::load($path);

            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['correo'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                    if($dato['correo']==""){
                        break;
                    }
                }
            }

            if($row==2){
                echo "error";
            }else{
                foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['correo'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    
                        if($dato['correo']==""){
                            break;
                        }

                        $validar = $this->Admin_model->get_list_correo_registro($dato['correo']); 

                        if(count($validar)>0){
                            foreach($validar as $list){
                                $dato['id_registro'] = $list['id_registro'];
                                $dato['comentario'] = $list['comentario'];
                                $this->Admin_model->insert_registro_mail_mailing($dato); 
                            }
                        }
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Empresa_Sede_Mail(){
        if ($this->session->userdata('usuario')) {
            $dato['empresas'] = $this->input->post("id_empresa");
            $dato['id_tipo'] = $this->input->post("id_tipo");
            
            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);

            $this->load->view('view_CC/comercial/registro/sedes',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Registro_Mail(){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['list_empresa'] =$this->Admin_model->get_list_empresa();
            $dato['list_sede'] = $this->Admin_model->get_list_sede();
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion();
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            $dato['list_producto_interes'] =$this->Model_CursosCortos->get_list_producto_interes();
            $dato['usuario_codigo']=$usuario_codigo;
            $dato['hoy']=date('Y-m-d');

            $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
            $anio=date('Y');
            $aniof=substr($anio, 2,2);

            if($totalRows_t<9){
                $codigo=$aniof."R000".($totalRows_t+1);
            }

            if($totalRows_t>8 && $totalRows_t<99){
                $codigo=$aniof."R00".($totalRows_t+1);
            }

            if($totalRows_t>98 && $totalRows_t<999){
                $codigo=$aniof."R0".($totalRows_t+1);
            }

            if($totalRows_t>998 ){
                $codigo=$totalRows_t+1;
            }

            $dato['codigo']=$codigo;
            
            $this->load->view('view_CC/comercial/registro/nuevo_registro',$dato);
        }
        else{
            redirect('/login');
        }
    }
    public function Vista_Registro_Mail(){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['list_empresas'] =$this->Admin_model->get_list_empresa();
            $dato['list_sede'] = $this->Admin_model->get_list_sede();
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            $dato['list_producto_interes'] =$this->Model_CursosCortos->get_list_producto_interes();
            $dato['usuario_codigo']=$usuario_codigo;
            $dato['hoy']=date('Y-m-d');

            $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
            $anio=date('Y');
            $aniof=substr($anio, 2,2);

            if($totalRows_t<9){
                $codigo=$aniof."000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo=$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigo=$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>998 ){
                $codigo=$aniof.($totalRows_t+1);
            }

            $dato['codigo']=$codigo;

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('view_CC/comercial/registro/registrar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Historial_Registro_Mail($id_registro){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);

            $dato['list_sede'] = $this->Admin_model->get_list_registro_mail_sede($id_registro);
            $dato['list_producto'] = $this->Admin_model->get_list_registro_mail_producto($id_registro);

            $id_empresa=$dato['get_id'][0]['id_empresa'];
            $id_departamento=$dato['get_id'][0]['id_departamento'];
            $id_provincia=$dato['get_id'][0]['id_provincia'];
            $id_registro=$dato['get_id'][0]['id_registro'];
            //$dato['list_empresam'] =$this->Admin_model->get_list_empresa();
            //$dato['list_sede'] = $this->Admin_model->get_list_sede_empresa($id_empresa);    
            $dato['list_producto_registro'] = $this->Admin_model->get_id_registro_producto($id_registro);
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion();
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia_editar($id_departamento);
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito_editar($id_departamento,$id_provincia);
            $dato['list_producto_interes'] =$this->Model_CursosCortos->get_list_producto_interes();
            $dato['usuario_codigo']=$usuario_codigo;

            $dato['id_registro'] =$id_registro;
            $dato['list_historial_registro'] =$this->Admin_model->get_list_historial_registro($id_registro);
            
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('view_CC/comercial/registro/historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Historial_Registro_Mail($id_registro){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $this->load->view('view_CC/comercial/registro/modal_historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Cambia_Status() {
        if ($this->session->userdata('usuario')) {
            $dato['id_historial']= $this->input->post("id_historial");
            $dato['id_accion']= $this->input->post("id_accion");
            $dato['list_status'] = $this->Admin_model->get_list_accion_status($dato);
            $this->load->view('view_CC/comercial/registro/estados', $dato);
        }
        else{
            redirect('');
        }
    }

    public function Insert_Historial_Registro_Mail(){
        if ($this->session->userdata('usuario')) {
            $dato['id_registro']= $this->input->post("id_registro");
            $dato['fecha_accion']= $this->input->post("fecha_accion_i");
            $dato['comentario1']= $this->input->post("comentario1_i");
            $dato['observacion']= $this->input->post("observacion_i");
            $dato['id_tipo']= $this->input->post("id_tipo_i");
            $dato['id_accion']= $this->input->post("id_accion_i");
            $dato['id_status']= $this->input->post("id_status_i");
            $dato['ultimo_comentario']= $this->input->post("ultimo_comentario");

            $this->Admin_model->insert_historial_registro_mail($dato);

            //-------------------------REGISTRO DE AGENDA-------------------------
            $fecha_accion= $this->input->post("fecha_accion_i");
    
            if($fecha_accion!=""){
                $codigo= $this->input->post("cod_registro");
                $id_informe= $this->input->post("id_informe");
                $informe = $this->Admin_model->get_id_informe($id_informe);
    
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
                $dato['iniciosf'] = strtotime($fecha_accion);
    
                $dato['cod_proyecto']=$codigo;
                $dato['descripcion']= $informe[0]['nom_informe'];
                $dato['inicio']=$fecha_accion;
                $dato['fin']=$fecha_accion;
                $dato['anio']=substr($fecha_accion,0,4);
                $dato['mes']=substr($fecha_accion,5,2);
                $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
                $dato['dia']=substr($fecha_accion,8,2);
                $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
                $dato['color']="#CB3234";
    
                $this->Admin_model->insert_registro_mail_agenda($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Historial_Registro_Mail($id_historial,$id_registro){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] =$this->Admin_model->get_id_historial_mail($id_historial);
            $dato['get_registro'] = $this->Admin_model->get_id_registro($id_registro);
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $dato['id_accion']=$dato['get_id'][0]['id_accion'];
            $dato['list_status'] = $this->Admin_model->get_list_accion_status($dato);
            $this->load->view('view_CC/comercial/registro/modal_update_historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Historial_Registro_Mail(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_historial']= $this->input->post("id_historial");
            $dato['id_registro']= $this->input->post("id_registro");
            $dato['fecha_accion']= $this->input->post("fecha_accion_u");
            $dato['comentario']= $this->input->post("comentario1_u");
            $dato['observacion']= $this->input->post("observacion_u");
            $dato['id_tipo']= $this->input->post("id_tipo_u");
            $dato['id_accion']= $this->input->post("id_accion_u");
            $dato['id_status']= $this->input->post("id_status_u");
            $dato['ultimo_comentario']= $this->input->post("ultimo_comentario");
            $this->Admin_model->update_historial_registro_mail($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Historial_Mail(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_historial']= $this->input->post("id_historial");
            $this->Admin_model->delete_historial_registro_mail($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Historial_Registro_Mail_Evento($id_historial){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] =$this->Admin_model->get_id_historial_mail($id_historial);
            $dato['list_status'] = $this->Admin_model->get_list_status_evento($dato);
            $this->load->view('view_CC/comercial/registro/modal_update_historial_evento',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Historial_Registro_Mail_Evento(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_historial']= $this->input->post("id_historial");
            $dato['id_status']= $this->input->post("id_status_e");
            $this->Admin_model->update_historial_registro_mail_evento($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Registro_Mail(){
        $parametro= $this->input->post('parametro');

        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

        $result="";

        foreach($dato['list_empresa'] as $char){
            $result.= $char['id_empresa'].",";
        }
        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";

        if($parametro==0){
            $dato['list_registro'] =$this->Admin_model->get_list_registro_activo($dato);
        }else{
            $dato['list_registro'] =$this->Admin_model->get_list_registro_todo($dato);
        }
        $list_registro_sede = $this->Model_snappy->list_registro_sede();
        $list_registro_interes = $this->Model_snappy->list_registro_interes();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Lista de Registro Mails');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(43);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getColumnDimension('H')->setWidth(26);
        $sheet->getColumnDimension('I')->setWidth(26);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(68);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(40);
        $sheet->getColumnDimension('P')->setWidth(18);
        $sheet->getColumnDimension('Q')->setWidth(13);
        $sheet->getColumnDimension('R')->setWidth(14);

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

        $sheet->setCellValue("A1", 'Referencia');           
        $sheet->setCellValue("B1", 'Fecha (Contacto)'); 
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Nombres y Apellidos');
        $sheet->setCellValue("E1", 'Distrito');
        $sheet->setCellValue("F1", 'Contacto 1');
        $sheet->setCellValue("G1", 'Contacto 2');
        $sheet->setCellValue("H1", 'Correo');
        $sheet->setCellValue("I1", 'Facebook');
        $sheet->setCellValue("J1", 'Empresa');
        $sheet->setCellValue("K1", 'Sede');
        $sheet->setCellValue("L1", 'No Mailing');
        $sheet->setCellValue("M1", 'Mensaje');
        $sheet->setCellValue("N1", 'Intereses');
        $sheet->setCellValue("O1", 'Observaciones');
        $sheet->setCellValue("P1", 'Acción');
        $sheet->setCellValue("Q1", 'Fecha');
        $sheet->setCellValue("R1", 'Status');
        
        $contador=1;
        
        foreach($dato['list_registro'] as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("I{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("I{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("P{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("P{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_registro']);

            $sheet->setCellValue("B{$contador}", $list['fec_inicial']);
            //$sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            //$sheet->setCellValue("B{$contador}", $list['fec_inicial']);
            $sheet->setCellValue("C{$contador}", $list['nom_informe']);
            $sheet->setCellValue("D{$contador}", trim($list['nombres_apellidos']));
            $sheet->setCellValue("E{$contador}", $list['nombre_distrito']);
            $sheet->setCellValue("F{$contador}", $list['contacto1']);
            $sheet->setCellValue("G{$contador}", $list['contacto2']);
            $sheet->setCellValue("H{$contador}", trim($list['correo']));
            $sheet->setCellValue("I{$contador}", $list['facebook']);
            $sheet->setCellValue("J{$contador}", $list['cod_empresa']);
            /*
            if(count($list_registro_sede)>0){
                $cadena0="";
                foreach($list_registro_sede as $sede){
                    if($sede['id_registro']==$list['id_registro']){
                        //echo $sede['cod_empresa'].",";
                        $cadena0=$cadena0.$sede['cod_sede'].",";
                    }else{
                        $cadena0="";
                    }
                }
                $sheet->setCellValue("K{$contador}", $cadena0);
            }else{
                $sheet->setCellValue("K{$contador}", " ");
            }*/
            $sheet->setCellValue("K{$contador}", $list['cod_sede']);

            if($list['mailing']==1){
                $sheet->setCellValue("L{$contador}", "X");
            }else{
                $sheet->setCellValue("L{$contador}", "");
            }
            
            $sheet->setCellValue("M{$contador}", $list['mensaje']);
            $sheet->setCellValue("N{$contador}", $list['nom_producto_interes']);
            
            if(count($list_registro_interes)>0){
                $cadena="";
                foreach($list_registro_interes as $int){
                    if($int['id_registro']==$list['id_registro']){
                        $cadena=$cadena.$int['nom_producto_interes'].",";
                    }else{
                        $cadena="";
                    }
                }
                $sheet->setCellValue("N{$contador}", $cadena);
            }else{
                $sheet->setCellValue("N{$contador}", " ");
            }
            
            $sheet->setCellValue("O{$contador}", $list['observacion_h']);

            if(strlen($list['nom_accion_h'])>0){
                $sheet->setCellValue("P{$contador}", $list['nom_accion_h']);
            }else{ $sheet->setCellValue("P{$contador}", "Comentario");}
            

            $sheet->setCellValue("Q{$contador}", $list['fecha_status_h'] );
            //$sheet->getStyle("Q{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("R{$contador}", $list['nom_status_h']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Registro Comercial (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Vista_Editar_Registro($id_registro){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);

            $dato['id_empresa']=$dato['get_id'][0]['id_empresa'];
            $dato['id_sede']=$dato['get_id'][0]['id_sede'];

            $dato['list_producto_interes'] = $this->Admin_model->get_list_empresa_sede_producto($dato);
            $dato['list_producto_interes0'] = $this->Admin_model->get_list_empresa_sede_producto0($dato);
            $dato['list_producto_interes10'] = $this->Admin_model->get_list_empresa_sede_producto10($dato);
            $dato['list_producto_interes20'] = $this->Admin_model->get_list_empresa_sede_producto20($dato);
            $dato['list_producto_interes30'] = $this->Admin_model->get_list_empresa_sede_producto30($dato);

            /*$dato['list_empresa'] =$this->Admin_model->get_list_empresa();
            $dato['list_sede'] = $this->Admin_model->get_id_sede($id_empresa);

            $dato['get_sede'] = $this->Admin_model->get_list_registro_mail_sede($id_registro);*/

            $dato['get_producto'] = $this->Admin_model->get_list_registro_mail_producto($id_registro);

            $dato['list_empresas'] = $this->Model_CursosCortos->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['id_departamento']=$dato['get_id'][0]['id_departamento'];
            $dato['id_provincia']=$dato['get_id'][0]['id_provincia'];
            if($dato['id_departamento']!=0){
                $dato['list_provincia'] = $this->Admin_model->get_list_provincia_editar($dato['id_departamento']);
            }else{
                $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            }

            if($dato['id_provincia']!=0 && $dato['list_provincia']!=0){
                $dato['list_distrito'] = $this->Admin_model->get_list_distrito_editar($dato['id_departamento'],$dato['id_provincia']);
            }else{
                $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            }
            
            $dato['usuario_codigo']=$usuario_codigo;

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('view_CC/comercial/registro/editar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Muestra_Provincia() {
        $id_departamento= $this->input->post("id_departamento");
        $dato['list_provincia'] = $this->Admin_model->departamento_provincia($id_departamento);
        $this->load->view('view_CC/comercial/registro/mprovincia',$dato);
    }

    public function Muestra_Distrito() {
        $id_departamento= $this->input->post("id_departamento");
        $id_provincia= $this->input->post("id_provincia");
        $dato['list_distrito'] = $this->Admin_model->provincia_distrito($id_provincia);
        $this->load->view('view_CC/comercial/registro/mdistrito',$dato);
    }

    public function Empresa_Sede_Producto_Interese(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa'] = $this->input->post("id_empresa");
            $dato['id_sede'] = $this->input->post("id_sede");
            
            $dato['list_producto_interes'] = $this->Admin_model->get_list_empresa_sede_producto($dato);
            $dato['list_producto_interes0'] = $this->Admin_model->get_list_empresa_sede_producto0($dato);
            $dato['list_producto_interes10'] = $this->Admin_model->get_list_empresa_sede_producto10($dato);
            $dato['list_producto_interes20'] = $this->Admin_model->get_list_empresa_sede_producto20($dato);
            $dato['list_producto_interes30'] = $this->Admin_model->get_list_empresa_sede_producto30($dato);

            $this->load->view('view_CC/comercial/registro/producto_interes',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Registro_Mail(){
        $dato['dni']= $this->input->post("dni");
        $dato['contacto1']= $this->input->post("contacto1");
        $dato['correo']= trim($this->input->post("correo"));
        $dato['id_empresa']= $this->input->post("id_empresa");

        $validar = count($this->Admin_model->valida_insert_registro_mail($dato));

        if($validar>0){
            echo "error";
        }else{
            $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
            $anio=date('Y');
            $aniof=substr($anio, 2,2);
    
            if($totalRows_t<9){
                $codigo=$aniof."000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo=$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigo=$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>998 ){
                $codigo=$aniof.($totalRows_t+1);
            }
    
            $cod_registro=$codigo;
    
            $dato['cod_registro']= $cod_registro;
            $dato['id_informe']= $this->input->post("id_informe");
            $dato['nombres_apellidos']= trim($this->input->post("nombres_apellidos"));
            $dato['dni']= $this->input->post("dni");
            $dato['id_departamento']= $this->input->post("id_departamento");
            $dato['id_provincia']= $this->input->post("id_provincia");
            $dato['id_distrito']= $this->input->post("id_distrito");
            $dato['contacto2']= $this->input->post("contacto2");
            $dato['facebook']= $this->input->post("facebook");
            $dato['mailing']= $this->input->post("mailing");
            $dato['mensaje']= $this->input->post("mensaje");
            $dato['producto']= $this->input->post("producto");
            $dato['observacion']= $this->input->post("observacion");
            $dato['id_accion']= $this->input->post("id_accion");
            $dato['id_sede']= $this->input->post("id_sede");
            $dato['duplicado']= $this->input->post("duplicado");
            $dato['id_status']= $this->input->post("id_status");
    
            $this->Model_CursosCortos->insert_registro_mail($dato);
    
            $ultimo_registro=$this->Admin_model->ultimo_registro_mail();
            $dato['id_registro']=$ultimo_registro[0]['id_registro'];
    
            $this->Admin_model->primer_insert_historial_registro_mail($dato);
    
            $producto_interes= $this->input->post("id_producto");
    
            if($producto_interes!=""){
                foreach($_POST['id_producto'] as $id_producto_interes){
                    $dato['id_producto_interes']=$id_producto_interes;
                    $this->Admin_model->insert_registro_mail_producto($dato);
                }
            }else{
                $dato['id_producto_interes']=62;
                $this->Admin_model->insert_registro_mail_producto($dato);           
            }
            
            //-------------------------REGISTRO DE AGENDA-------------------------
            /*$fecha_accion= $this->input->post("fecha_accion");
    
            if($fecha_accion!=""){
                $id_informe= $this->input->post("id_informe");
                $informe = $this->Admin_model->get_id_informe($id_informe);
    
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
                $dato['iniciosf'] = strtotime($fecha_accion);
    
                $dato['cod_proyecto']=$codigo;
                $dato['descripcion']= $informe[0]['nom_informe'];
                $dato['inicio']=$fecha_accion;
                $dato['fin']=$fecha_accion;
                $dato['anio']=substr($fecha_accion,0,4);
                $dato['mes']=substr($fecha_accion,5,2);
                $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
                $dato['dia']=substr($fecha_accion,8,2);
                $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
                $dato['color']="#CB3234";
    
                $this->Admin_model->insert_registro_mail_agenda($dato);
            }*/
        }
    }

    public function Insert_Registro_Mail_Secretaria(){
        $dato['dni']= $this->input->post("dni");
        $dato['contacto1']= $this->input->post("contacto1");
        $dato['correo']= trim($this->input->post("correo"));
        $dato['id_empresa']= $this->input->post("id_empresa");

        $validar = count($this->Admin_model->valida_insert_registro_mail($dato));

        if($validar>0){
            echo "error";
        }else{
            $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
            $anio=date('Y');
            $aniof=substr($anio, 2,2);
    
            if($totalRows_t<9){
                $codigo=$aniof."000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo=$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigo=$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>998 ){
                $codigo=$aniof.($totalRows_t+1);
            }
    
            $cod_registro=$codigo;
    
            $dato['cod_registro']= $cod_registro;
            $dato['id_informe']= $this->input->post("id_informe");
            $dato['nombres_apellidos']= trim($this->input->post("nombres_apellidos"));
            $dato['dni']= $this->input->post("dni");
            $dato['id_departamento']= $this->input->post("id_departamento");
            $dato['id_provincia']= $this->input->post("id_provincia");
            $dato['id_distrito']= $this->input->post("id_distrito");
            $dato['contacto2']= $this->input->post("contacto2");
            $dato['facebook']= $this->input->post("facebook");
            $dato['mailing']= 0;
            $dato['mensaje']= $this->input->post("mensaje");
            $dato['observacion']= $this->input->post("observacion");
            $dato['id_sede']= $this->input->post("id_sede");
    
            $this->Admin_model->insert_registro_mail($dato);
    
            $ultimo_registro=$this->Admin_model->ultimo_registro_mail();
            $dato['id_registro']=$ultimo_registro[0]['id_registro'];
    
            $this->Admin_model->primer_insert_historial_registro_mail($dato);
    
            $producto_interes= $this->input->post("id_producto");
    
            if($producto_interes!=""){
                foreach($_POST['id_producto'] as $id_producto_interes){
                    $dato['id_producto_interes']=$id_producto_interes;
                    $this->Admin_model->insert_registro_mail_producto($dato);
                }
            }else{
                $dato['id_producto_interes']=62;
                $this->Admin_model->insert_registro_mail_producto($dato);           
            }
        }
    }

    public function Editar_Registro($id_registro){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);

            $dato['id_empresa']=$dato['get_id'][0]['id_empresa'];
            $dato['id_sede']=$dato['get_id'][0]['id_sede'];

            $dato['list_producto_interes'] = $this->Admin_model->get_list_empresa_sede_producto($dato);
            $dato['list_producto_interes0'] = $this->Admin_model->get_list_empresa_sede_producto0($dato);
            $dato['list_producto_interes10'] = $this->Admin_model->get_list_empresa_sede_producto10($dato);
            $dato['list_producto_interes20'] = $this->Admin_model->get_list_empresa_sede_producto20($dato);
            $dato['list_producto_interes30'] = $this->Admin_model->get_list_empresa_sede_producto30($dato);

            /*$dato['list_empresa'] =$this->Admin_model->get_list_empresa();
            $dato['list_sede'] = $this->Admin_model->get_id_sede($id_empresa);

            $dato['get_sede'] = $this->Admin_model->get_list_registro_mail_sede($id_registro);*/

            $dato['get_producto'] = $this->Admin_model->get_list_registro_mail_producto($id_registro);

            $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion();
            $dato['list_informe'] = $this->Model_CursosCortos->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['id_departamento']=$dato['get_id'][0]['id_departamento'];
            $dato['id_provincia']=$dato['get_id'][0]['id_provincia'];
            if($dato['id_departamento']!=0){
                $dato['list_provincia'] = $this->Admin_model->get_list_provincia_editar($dato['id_departamento']);
            }else{
                $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            }

            if($dato['id_provincia']!=0 && $dato['list_provincia']!=0){
                $dato['list_distrito'] = $this->Admin_model->get_list_distrito_editar($dato['id_departamento'],$dato['id_provincia']);
            }else{
                $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            }
            
            
            $dato['usuario_codigo']=$usuario_codigo;
           

            $this->load->view('view_CC/comercial/registro/editar_registro',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Empresa_Sede_Registro(){
        if ($this->session->userdata('usuario')) {
            $dato['empresas'] = $this->input->post("id_empresa");
            $dato['id_registro'] = $this->input->post("id_registro");
            $dato['get_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
            $this->load->view('administrador/comercial/registro/list_sede',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Registro_Mail(){
        $dato['id_registro']= $this->input->post("id_registro");
        $dato['dni']= $this->input->post("dni");
        $dato['contacto1']= $this->input->post("contacto1");
        $dato['correo']= trim($this->input->post("correo"));
        $dato['id_empresa']= $this->input->post("id_empresa");

        $validar = count($this->Admin_model->valida_update_registro_mail($dato));

        if($validar>0){
            echo "error";
        }else{
            $dato['id_informe']= $this->input->post("id_informe");
            $dato['nombres_apellidos']= trim($this->input->post("nombres_apellidos"));
            $dato['dni']= $this->input->post("dni");
            $dato['id_departamento']= $this->input->post("id_departamento");
            $dato['id_provincia']= $this->input->post("id_provincia");
            $dato['id_distrito']= $this->input->post("id_distrito");
            $dato['contacto2']= $this->input->post("contacto2");
            $dato['facebook']= $this->input->post("facebook");
            $dato['id_sede']= $this->input->post("id_sede");
            $dato['mailing']= $this->input->post("mailing");
            $dato['importacion_evento']= $this->input->post("importacion_evento");

            if($dato['id_informe']==0 && $dato['importacion_evento']==1){
                $dato['id_informe'] = 14;
            }

            $this->Admin_model->update_registro_mail($dato);

            //PRODUCTOS
            $envio_producto= $this->input->post("id_producto");

            if($envio_producto!=""){
                $this->Admin_model->limpiar_registro_producto($dato);

                foreach($_POST['id_producto'] as $id_producto){
                    $dato['id_producto']=$id_producto;
                    $this->Admin_model->update_registro_producto($dato);
                }
            }
        }
    }

    public function Delete_Registro_Mail(){
        if ($this->session->userdata('usuario')) {
            $dato['id_registro'] = $this->input->post("id_registro");
            $this->Admin_model->delete_registro_mail($dato);
        }else{
            redirect('/login');
        }
    }


    public function Excel_Dep_Comercial($parametro,$anio){ 
        $dato['anio'] = $anio; 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        /*$dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

        $result="";

        foreach($dato['list_empresa'] as $char){
            $result.= $char['id_empresa'].",";
        }
        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";*/

        if($parametro==0){
            $dato['list_registro'] =$this->Model_CursosCortos->excel_registro_activo($dato);
        }else{
            $dato['list_registro'] =$this->Model_CursosCortos->excel_registro_todo($dato);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:W1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:W1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Registro Comercial');

        $sheet->setAutoFilter('A1:W1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->getColumnDimension('W')->setWidth(60);

        $sheet->getStyle('A1:W1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:W1")->getFill()
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

        $sheet->getStyle("A1:W1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Referencia');        
        $sheet->setCellValue("B1", 'Dp');              
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Contacto');
        $sheet->setCellValue("E1", 'Usuario');
        $sheet->setCellValue("F1", 'Mes/Año');
        $sheet->setCellValue("G1", 'Nombres y Apellidos');
        $sheet->setCellValue("H1", 'DNI');
        $sheet->setCellValue("I1", 'Contacto 1');
        $sheet->setCellValue("J1", 'Departamento');
        $sheet->setCellValue("K1", 'Provincia');
        $sheet->setCellValue("L1", 'Distrito');
        $sheet->setCellValue("M1", 'Contacto 2');
        $sheet->setCellValue("N1", 'Correo');
        $sheet->setCellValue("O1", 'Facebook');
        $sheet->setCellValue("P1", 'Empresa');
        $sheet->setCellValue("Q1", 'Sede');
        $sheet->setCellValue("R1", 'Interés');
        $sheet->setCellValue("S1", 'Acción');
        $sheet->setCellValue("T1", 'Fecha');
        $sheet->setCellValue("U1", 'Usuario');
        $sheet->setCellValue("V1", 'Status');
        $sheet->setCellValue("W1", 'Comentario');
        
        $contador=1;
        
        foreach($dato['list_registro'] as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:W{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("U{$contador}:W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:W{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_registro']);
            $sheet->setCellValue("B{$contador}", $list['dp']);
            $sheet->setCellValue("C{$contador}", $list['nom_informe']);

            if($list['fec_inicial']=="00/00/0000"){
                $sheet->setCellValue("D{$contador}", "");
            }else{
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fec_inicial']));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            $sheet->setCellValue("E{$contador}", $list['usuario_codigo']);
      
            
            if($list['fecha_mes_anio']=="0000-00-00" || $list['fecha_mes_anio']==""){
                $sheet->setCellValue("F{$contador}", "");
            }else{
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fecha_mes_anio']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            
            $sheet->setCellValue("G{$contador}", $list['nombres_apellidos']);
            $sheet->setCellValue("H{$contador}", $list['dni']);
            $sheet->setCellValue("I{$contador}", $list['contacto1']);
            $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("L{$contador}", $list['nombre_distrito']);
            $sheet->setCellValue("M{$contador}", $list['contacto2']);
            $sheet->setCellValue("N{$contador}", $list['correo']);
            $sheet->setCellValue("O{$contador}", $list['facebook']);
            $sheet->setCellValue("P{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("Q{$contador}", $list['cod_sede']);
            $sheet->setCellValue("R{$contador}", $list['productosf']);
        
            if(strlen($list['nom_accion_h'])>0){
                $sheet->setCellValue("S{$contador}", $list['nom_accion_h']);
            }else{
                $sheet->setCellValue("S{$contador}", "Comentario" );
            }

            $sheet->setCellValue("T{$contador}", Date::PHPToExcel($list['fecha_status_h']));
            $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("U{$contador}", $list['usuario_historico']);
            $sheet->setCellValue("V{$contador}", $list['nom_status_h']);
            $sheet->setCellValue("W{$contador}", $list['comentario_h']);

            if($list['duplicado']==1){
                $spreadsheet->getActiveSheet()->getStyle("A{$contador}:W{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F8FF91');
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Registro Comercial (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Dep_Comercial_Secretaria(){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

        $result="";

        foreach($dato['list_empresa'] as $char){
            $result.= $char['id_empresa'].",";
        }
        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";

        $list_registro =$this->Admin_model->excel_registro_secretaria($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:W1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:W1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Registro Comercial');

        $sheet->setAutoFilter('A1:W1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15); 
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->getColumnDimension('W')->setWidth(60);

        $sheet->getStyle('A1:W1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:W1")->getFill()
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

        $sheet->getStyle("A1:W1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Referencia');        
        $sheet->setCellValue("B1", 'Dp');              
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Contacto');
        $sheet->setCellValue("E1", 'Usuario');
        $sheet->setCellValue("F1", 'Mes/Año');
        $sheet->setCellValue("G1", 'Nombres y Apellidos');
        $sheet->setCellValue("H1", 'DNI');
        $sheet->setCellValue("I1", 'Contacto 1');
        $sheet->setCellValue("J1", 'Departamento');
        $sheet->setCellValue("K1", 'Provincia');
        $sheet->setCellValue("L1", 'Distrito');
        $sheet->setCellValue("M1", 'Contacto 2');
        $sheet->setCellValue("N1", 'Correo');
        $sheet->setCellValue("O1", 'Facebook');
        $sheet->setCellValue("P1", 'Empresa');
        $sheet->setCellValue("Q1", 'Sede');
        $sheet->setCellValue("R1", 'Interés');
        $sheet->setCellValue("S1", 'Acción');
        $sheet->setCellValue("T1", 'Fecha');
        $sheet->setCellValue("U1", 'Usuario');
        $sheet->setCellValue("V1", 'Status');
        $sheet->setCellValue("W1", 'Comentario');
        
        $contador=1;
        
        foreach($list_registro as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:W{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("U{$contador}:W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:W{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_registro']);
            $sheet->setCellValue("B{$contador}", $list['dp']);
            $sheet->setCellValue("C{$contador}", $list['nom_informe']);

            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fec_inicial']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("E{$contador}", $list['usuario_codigo']);

            $sheet->setCellValue("F{$contador}", $list['mes_anio']);
            $sheet->setCellValue("G{$contador}", $list['nombres_apellidos']);
            $sheet->setCellValue("H{$contador}", $list['dni']);
            $sheet->setCellValue("I{$contador}", $list['contacto1']);
            $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("L{$contador}", $list['nombre_distrito']);
            $sheet->setCellValue("M{$contador}", $list['contacto2']);
            $sheet->setCellValue("N{$contador}", $list['correo']);
            $sheet->setCellValue("O{$contador}", $list['facebook']);
            $sheet->setCellValue("P{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("Q{$contador}", $list['cod_sede']);
            $sheet->setCellValue("R{$contador}", $list['productosf']);
        
            if(strlen($list['nom_accion_h'])>0){
                $sheet->setCellValue("S{$contador}", $list['nom_accion_h']);
            }else{
                $sheet->setCellValue("S{$contador}", "Comentario" );
            }

            $sheet->setCellValue("T{$contador}", Date::PHPToExcel($list['fecha_status_h']));
            $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("U{$contador}", $list['usuario_historico']);
            $sheet->setCellValue("V{$contador}", $list['nom_status_h']);
            $sheet->setCellValue("W{$contador}", $list['comentario_h']);

            if($list['duplicado']==1){
                $spreadsheet->getActiveSheet()->getStyle("A{$contador}:W{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F8FF91');
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Registro Comercial (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Vacio_Comercial(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel Vacío Comercial');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);

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

        $sheet->getStyle("A2:N3")->getFont()->getColor()->setRGB('FF0000');

        $sheet->setCellValue("A1", 'Informe');           
        $sheet->setCellValue("B1", 'Fecha Contacto');
        $sheet->setCellValue("C1", 'Nombres y Apellidos');
        $sheet->setCellValue("D1", 'DNI');
        $sheet->setCellValue("E1", 'Intereses');
        $sheet->setCellValue("F1", 'Contacto Principal');
        $sheet->setCellValue("G1", 'Departamento');
        $sheet->setCellValue("H1", 'Provincia');
        $sheet->setCellValue("I1", 'Distrito');
        $sheet->setCellValue("J1", 'Contacto 2');
        $sheet->setCellValue("K1", 'Correo');   
        $sheet->setCellValue("L1", 'Facebook');   
        $sheet->setCellValue("M1", 'Comentario');
        $sheet->setCellValue("N1", 'Observaciones');     

        $sheet->setCellValue("A2", 'Correo');   
        $sheet->setCellValue("B2", Date::PHPToExcel('22/11/2021'));
        $sheet->getStyle("B2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);        
        $sheet->setCellValue("C2", 'Juan Perez Velazquez');
        $sheet->setCellValue("D2", '12345678');
        $sheet->setCellValue("E2", '3 Años');
        $sheet->setCellValue("F2", '987654321');
        $sheet->setCellValue("G2", 'Lima');
        $sheet->setCellValue("H2", 'Lima');
        $sheet->setCellValue("I2", 'San Juan de Miraflores');
        $sheet->setCellValue("J2", '918299804');
        $sheet->setCellValue("K2", 'juanperezv@gmail.com');
        $sheet->setCellValue("L2", 'Juan Perez Velazquez');   
        $sheet->setCellValue("M2", 'Aquí va el comentario');
        $sheet->setCellValue("N2", 'Aquí van las observaciones');

        $sheet->setCellValue("A3", 'Messenger');   
        $sheet->setCellValue("B3", Date::PHPToExcel('23/11/2021'));
        $sheet->getStyle("B3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);        
        $sheet->setCellValue("C3", 'Daniel Ruiz Huerta');
        $sheet->setCellValue("D3", '87654321');
        $sheet->setCellValue("E3", '2 Secundaria');
        $sheet->setCellValue("F3", '963258741');
        $sheet->setCellValue("G3", 'Lima');
        $sheet->setCellValue("H3", 'Lima');
        $sheet->setCellValue("I3", 'San Juan de Miraflores');
        $sheet->setCellValue("J3", '951741289');
        $sheet->setCellValue("K3", 'Danielhrh@gmail.com');
        $sheet->setCellValue("L3", 'Daniel Ruiz Huerta');   
        $sheet->setCellValue("M3", 'Aquí va el comentario');
        $sheet->setCellValue("N3", 'Aquí van las observaciones');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel_Vacío_Cursos_Cortos';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Validar_Importar_Comercial() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   

            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['nom_informe'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['fecha_inicial'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                    $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['dni'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $dato['contacto1'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $dato['nombre_departamento'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['nombre_provincia'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $dato['nombre_distrito'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $dato['contacto2'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $dato['correo'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $dato['facebook'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['cod_empresa'] = 11;
                    $dato['cod_sede'] = 27;
                    $dato['comentario'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['observacion'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                    $dato['hay_fecha_inicial'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    if($dato['nom_informe']=="" && $dato['hay_fecha_inicial']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && 
                    $dato['nom_producto_interes']=="" && $dato['contacto1']=="" && $dato['nombre_departamento']=="" && $dato['nombre_provincia']=="" && 
                    $dato['nombre_distrito']=="" && $dato['contacto2']=="" && $dato['correo']=="" && $dato['facebook']=="" && $dato['cod_empresa']=="" && 
                    $dato['cod_sede']=="" && $dato['comentario']=="" && $dato['observacion']==""){
                        break;
                    }

                    $informe=$this->Admin_model->buscar_informe();
                    $posicion_informe=array_search($dato['nom_informe'],array_column($informe,'nom_informe'));

                    $departamento=$this->Admin_model->buscar_departamento();
                    $posicion_departamento=array_search($dato['nombre_departamento'],array_column($departamento,'nombre_departamento'));

                    if(is_numeric($posicion_departamento)){
                        $provincia=$this->Admin_model->buscar_provincia($departamento[$posicion_departamento]['id_departamento']);
                        $posicion_provincia=array_search($dato['nombre_provincia'],array_column($provincia,'nombre_provincia'));    
                    }else{
                        $posicion_provincia="";
                    }

                    if(is_numeric($posicion_provincia)){
                        $distrito=$this->Admin_model->buscar_distrito($provincia[$posicion_provincia]['id_provincia']);
                        $posicion_distrito=array_search($dato['nombre_distrito'],array_column($distrito,'nombre_distrito'));
                    }else{
                        $posicion_distrito="";
                    }
                    
                    /*$empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if(is_numeric($posicion_empresa)){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }*/

                    /*if(is_numeric($posicion_empresa) && is_numeric($posicion_sede)){*/
                        $dato['id_empresa'] = $dato['cod_empresa'];
                        $dato['id_sede'] = $dato['cod_sede'];
                        $producto = $this->Admin_model->buscar_producto_interes($dato);
                        $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                    /*}else{
                        $posicion_producto="";
                    }*/

                    /*$dato['id_empresa']=0;
                    if(is_numeric($posicion_empresa)){
                        $dato['id_empresa']=$empresa[$posicion_empresa]['id_empresa'];
                    }*/

                    $validar = count($this->Admin_model->valida_importar_registro_mail($dato));

                    $dato['v_informe']=0;
                    $dato['v_fecha_inicial']=0;
                    $dato['v_nombres_apellidos']=0;
                    $dato['v_nombres_apellidos_inv']=0;
                    $dato['v_numerico_dni']=0;
                    $dato['v_cantidad_dni']=0;
                    $dato['v_nom_producto_interes']=0;
                    $dato['v_contacto1']=0;
                    $dato['v_numerico']=0;
                    $dato['v_cantidad']=0;
                    $dato['v_inicial']=0;
                    $dato['v_nombre_departamento']=0;
                    $dato['v_nombre_provincia']=0;
                    $dato['v_nombre_distrito']=0;
                    $dato['v_correo']=0;
                    $dato['v_correo_inv']=0;
                    $dato['v_cod_empresa']=0;
                    $dato['v_cod_sede']=0;
                    $dato['v_registro']=0;
                    $dato['v_comentario']=0;
                    
                    if($validar>0){
                        $dato['v_registro']=1;
                    }else{
                        if(!is_numeric($posicion_informe)){
                            $dato['v_informe']=1;
                        }
                        if($dato['fecha_inicial']==""){
                            $dato['v_fecha_inicial']=1;
                        }
                        if($dato['nombres_apellidos']==""){
                            $dato['v_nombres_apellidos']=1;
                        }else{
                            if((substr_count($dato['nombres_apellidos'],1)+substr_count($dato['nombres_apellidos'],2)+substr_count($dato['nombres_apellidos'],3)+
                            substr_count($dato['nombres_apellidos'],4)+substr_count($dato['nombres_apellidos'],5)+substr_count($dato['nombres_apellidos'],6)+
                            substr_count($dato['nombres_apellidos'],7)+substr_count($dato['nombres_apellidos'],8)+substr_count($dato['nombres_apellidos'],9)+
                            substr_count($dato['nombres_apellidos'],0))>0){
                                $dato['v_nombres_apellidos_inv']=1;
                            }
                        }
                        if($dato['dni']!=""){
                            if(!is_numeric($dato['dni'])){    
                                $dato['v_numerico_dni']=1;
                            }else{
                                if(strlen($dato['dni'])!=8){
                                    $dato['v_cantidad_dni']=1;
                                }
                            }
                        }
                        if(!is_numeric($posicion_producto)){
                            $dato['v_nom_producto_interes']=1;
                        }
                        /*if($dato['contacto1']==""){
                            $dato['v_contacto1']=1;
                        }*/if($dato['contacto1']!=""){
                            if(!is_numeric($dato['contacto1'])){    
                                $dato['v_numerico']=1;
                            }else{
                                if(strlen($dato['contacto1'])!=9){
                                    $dato['v_cantidad']=1;
                                }else{
                                    if(substr($dato['contacto1'],0,1)!=9){
                                        $dato['v_inicial']=1;
                                    }
                                }
                            }
                        }
                        if($dato['nombre_departamento']!=""){
                            if(!is_numeric($posicion_departamento)){
                                $dato['v_nombre_departamento']=1;
                            }
                        }
                        if($dato['nombre_provincia']!=""){
                            if(!is_numeric($posicion_provincia)){
                                $dato['v_nombre_provincia']=1;
                            }
                        }
                        if($dato['nombre_distrito']!=""){
                            if(!is_numeric($posicion_distrito)){
                                $dato['v_nombre_distrito']=1;
                            }
                        }
                        /*if($dato['correo']==""){
                            $dato['v_correo']=1;
                        }*/if($dato['correo']!=""){
                            if(!filter_var($dato['correo'],FILTER_VALIDATE_EMAIL)) {
                                //$dato['v_correo_inv']=1;
                                $dato['v_correo']=1;
                            }
                        }
                        /*if(!is_numeric($posicion_empresa)){
                            $dato['v_cod_empresa']=1;
                        }
                        if(!is_numeric($posicion_sede)){
                            $dato['v_cod_sede']=1;
                        }*/
                        if(strlen($dato['comentario'])>35){
                            $dato['v_comentario']=1;
                        }
                    }

                    $this->Admin_model->insert_temporal_registro_mail($dato); 
                }
            //}

            $correctos=count($this->Admin_model->get_list_temporal_registro_mail_correcto());
            $errores=$this->Admin_model->get_list_temporal_registro_mail($dato);

            if($correctos==count($errores)){
                $dato['archivo_excel']= $this->input->post("archivo_excel");   

                $path = $_FILES["archivo_excel"]["tmp_name"];
                $object = IOFactory::load($path);
                $worksheet = $object->getSheet(0);
                //foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['nom_informe'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $excelDate = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $dato['fecha_inicial'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                        $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $dato['dni'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $dato['contacto1'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $dato['nombre_departamento'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $dato['nombre_provincia'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $dato['nombre_distrito'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $dato['contacto2'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $dato['correo'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $dato['facebook'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $dato['cod_empresa'] = 11;
                        $dato['cod_sede'] = 27;
                        $dato['comentario'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $dato['observacion'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
    
                        $dato['hay_fecha_inicial'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    
                        if($dato['nom_informe']=="" && $dato['hay_fecha_inicial']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && 
                        $dato['nom_producto_interes']=="" && $dato['contacto1']=="" && $dato['nombre_departamento']=="" && $dato['nombre_provincia']=="" && 
                        $dato['nombre_distrito']=="" && $dato['contacto2']=="" && $dato['correo']=="" && $dato['facebook']=="" && $dato['cod_empresa']=="" && 
                        $dato['cod_sede']=="" &&  $dato['comentario']=="" && $dato['observacion']==""){
                            break;
                        }    
    
                        $informe=$this->Admin_model->buscar_informe();
                        $posicion_informe=array_search($dato['nom_informe'],array_column($informe,'nom_informe'));

                        $departamento=$this->Admin_model->buscar_departamento();
                        $posicion_departamento=array_search($dato['nombre_departamento'],array_column($departamento,'nombre_departamento'));

                        if(is_numeric($posicion_departamento) ){
                            $provincia=$this->Admin_model->buscar_provincia($departamento[$posicion_departamento]['id_departamento']);
                            $posicion_provincia=array_search($dato['nombre_provincia'],array_column($provincia,'nombre_provincia'));    
                        }else{
                            $posicion_provincia="";
                        }

                        if(is_numeric($posicion_provincia) ){
                            $distrito=$this->Admin_model->buscar_distrito($provincia[$posicion_provincia]['id_provincia']);
                            $posicion_distrito=array_search($dato['nombre_distrito'],array_column($distrito,'nombre_distrito'));
                        }else{
                            $posicion_distrito="";
                        }
                        
                        /*$empresa=$this->Admin_model->buscar_empresa();
                        $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                        if(is_numeric($posicion_empresa)){
                            $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                            $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                        }else{
                            $posicion_sede="";
                        }*/

                        if(is_numeric($dato['cod_empresa']) && is_numeric($dato['cod_sede'])){
                            $dato['id_empresa'] = $dato['cod_empresa'];
                            $dato['id_sede'] = $dato['cod_sede'];
                            $producto = $this->Admin_model->buscar_producto_interes($dato);
                            $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                            //echo($producto);
                        }else{
                            $posicion_producto="";
                        }
            
                        $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
                        $anio=date('Y');
                        $aniof=substr($anio, 2,2);

                        if($totalRows_t<9){
                            $codigo=$aniof."000".($totalRows_t+1);
                        }
                        if($totalRows_t>8 && $totalRows_t<99){
                            $codigo=$aniof."00".($totalRows_t+1);
                        }
                        if($totalRows_t>98 && $totalRows_t<999){
                            $codigo=$aniof."0".($totalRows_t+1);
                        }
                        if($totalRows_t>998 ){
                            $codigo=$aniof.($totalRows_t+1);
                        }
                        $cod_registro=$codigo;
    
                        $dato['cod_registro']= $cod_registro;
                        $dato['id_informe'] = $informe[$posicion_informe]['id_informe'];
                        if($dato['nombre_departamento']!=""){
                            $dato['id_departamento'] = $departamento[$posicion_departamento]['id_departamento'];
                        }else{
                            $dato['id_departamento'] = "";
                        }
                        if($dato['nombre_provincia']!=""){
                            $dato['id_provincia'] = $provincia[$posicion_provincia]['id_provincia'];
                        }else{
                            $dato['id_provincia'] = "";
                        }
                        if($dato['nombre_distrito']!=""){
                            $dato['id_distrito'] = $distrito[$posicion_distrito]['id_distrito'];
                        }else{
                            $dato['id_distrito'] = "";
                        }
                        $dato['id_empresa'] = $dato['cod_empresa'];
                        $dato['id_sede'] = $dato['cod_sede'];
                        $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];
    
                        $this->Model_CursosCortos->importar_registro_mail($dato);

                        $ultimo_registro=$this->Admin_model->ultimo_registro_mail();
                        $dato['id_registro']=$ultimo_registro[0]['id_registro'];

                        $this->Admin_model->primer_importar_registro_mail($dato);

                        if($dato['nom_producto_interes']!=""){
                            $validar_producto = $this->Admin_model->valida_imp_registro_mail_producto($dato);
                            if(count($validar_producto)==0){
                                $this->Admin_model->imp_registro_mail_producto($dato);
                            }
                        }
                    }
                //}
            }else{
                $fila=2;

                foreach($errores as $list){
                    if($list['v_informe']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Informe válido!</p>";
                    }
                    if($list['v_fecha_inicial']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Fecha Inicial!</p>";
                    }
                    if($list['v_nombres_apellidos']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Nombres y Apellidos!</p>";
                    }
                    if($list['v_nombres_apellidos_inv']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Nombres y Apellidos válidos!</p>";
                    }
                    if($list['v_numerico_dni']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar solo números para DNI!</p>";
                    }
                    if($list['v_cantidad_dni']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar 8 dígitos para DNI!</p>";
                    }
                    if($list['v_nom_producto_interes']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Producto Interes válido!</p>";
                    }
                    if($list['v_contacto1']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Contacto Principal!</p>";
                    }
                    if($list['v_numerico']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar solo números para Contacto Principal!</p>";
                    }
                    if($list['v_cantidad']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar 9 dígitos para Contacto Principal!</p>";
                    }
                    if($list['v_inicial']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar número inicial 9 para Contacto Principal!</p>";
                    }
                    if($list['v_nombre_departamento']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Departamento válido!</p>";
                    }
                    if($list['v_nombre_provincia']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Provincia válida!</p>";
                    }
                    if($list['v_nombre_distrito']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Distrito válido!</p>";
                    }
                    if($list['v_correo']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Correo!</p>";
                    }
                    if($list['v_correo_inv']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Correo válido!</p>";
                    }
                    if($list['v_cod_empresa']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Empresa válida!</p>";
                    }
                    if($list['v_cod_sede']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Sede válida!</p>";
                    }
                    if($list['v_registro']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Registro válido - OBLIGATORIO Cargar Manualmente!</p>";
                    }
                    if($list['v_comentario']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Comentario máximo de 35 caracteres!</p>";
                    }
                    $fila++;
                }
    
                if($correctos>0){
                    echo "*CORRECTO";
                }else{
                    echo "*INCORRECTO";
                }
            }

            $this->Admin_model->delete_temporal_registro_mail();

        }
        else{
            redirect('/login');
        }
    }

    public function Importar_Comercial() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   
            
            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['nom_informe'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['fecha_inicial'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                    $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['dni'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $dato['contacto1'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $dato['nombre_departamento'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['nombre_provincia'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $dato['nombre_distrito'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $dato['contacto2'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $dato['correo'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $dato['facebook'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['cod_sede'] = 11;
                    $dato['comentario'] = 27;
                    $dato['observacion'] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();

                    $dato['hay_fecha_inicial'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    if($dato['nom_informe']=="" && $dato['hay_fecha_inicial']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && 
                    $dato['nom_producto_interes']=="" && $dato['contacto1']=="" && $dato['nombre_departamento']=="" && $dato['nombre_provincia']=="" && 
                    $dato['nombre_distrito']=="" && $dato['contacto2']=="" && $dato['correo']=="" && $dato['facebook']=="" && $dato['cod_empresa']=="" && 
                    $dato['cod_sede']=="" && $dato['comentario']=="" && $dato['observacion']==""){
                        break;
                    }

                    $informe=$this->Admin_model->buscar_informe();
                    $posicion_informe=array_search($dato['nom_informe'],array_column($informe,'nom_informe'));

                    $departamento=$this->Admin_model->buscar_departamento();
                    $posicion_departamento=array_search($dato['nombre_departamento'],array_column($departamento,'nombre_departamento'));

                    if($departamento[$posicion_departamento]['id_departamento']!=""){
                        $provincia=$this->Admin_model->buscar_provincia($departamento[$posicion_departamento]['id_departamento']);
                        $posicion_provincia=array_search($dato['nombre_provincia'],array_column($provincia,'nombre_provincia'));    
                    }else{
                        $posicion_provincia="";
                    }

                    if($provincia[$posicion_provincia]['id_provincia']!=""){
                        $distrito=$this->Admin_model->buscar_distrito($provincia[$posicion_provincia]['id_provincia']);
                        $posicion_distrito=array_search($dato['nombre_distrito'],array_column($distrito,'nombre_distrito'));
                    }else{
                        $posicion_distrito="";
                    }
                    
                    /*$empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if($empresa[$posicion_empresa]['id_empresa']!=""){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }*/

                    if(is_numeric($dato['cod_empresa']) && is_numeric($dato['cod_sede'])){
                        $dato['id_empresa'] = $dato['cod_empresa'];
                        $dato['id_sede'] = $dato['cod_sede'];
                        $producto = $this->Model_CursosCortos->buscar_producto_interes($dato);
                        $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                    }else{
                        $posicion_producto="";
                    }

                    $v_dni = 0;
                    if($dato['dni']!=""){
                        if(is_numeric($dato['dni']) && strlen($dato['dni'])==8){
                            $v_dni = 0;
                        }else{
                            $v_dni = 1;
                        }
                    }

                    $v_distrito = 0;
                    if($dato['nombre_distrito']!=""){
                        if(is_numeric($posicion_distrito)){
                            $v_distrito = 0;
                        }else{
                            $v_distrito = 1;
                        }
                    }

                    $dato['id_empresa']=0;
                    if(is_numeric($posicion_empresa)){
                        $dato['id_empresa']=$empresa[$posicion_empresa]['id_empresa'];
                    }

                    $validar = count($this->Admin_model->valida_importar_registro_mail($dato));

                    if($validar==0 && is_numeric($posicion_informe) && $dato['fecha_inicial']!="" && $dato['nombres_apellidos']!="" && 
                    (substr_count($dato['nombres_apellidos'],1)+substr_count($dato['nombres_apellidos'],2)+substr_count($dato['nombres_apellidos'],3)+
                    substr_count($dato['nombres_apellidos'],4)+substr_count($dato['nombres_apellidos'],5)+substr_count($dato['nombres_apellidos'],6)+
                    substr_count($dato['nombres_apellidos'],7)+substr_count($dato['nombres_apellidos'],8)+substr_count($dato['nombres_apellidos'],9)+
                    substr_count($dato['nombres_apellidos'],0))>0 && $v_dni==0 && is_numeric($posicion_producto) &&  is_numeric($posicion_departamento) && 
                    $provincia[$posicion_provincia]['id_provincia']!="" && $v_distrito==0 && $dato['correo']!="" && filter_var($dato['correo'],FILTER_VALIDATE_EMAIL) && 
                    /*is_numeric($posicion_empresa) && is_numeric($posicion_sede) &&*/ strlen($dato['comentario'])<=35){

                        $totalRows_t=count($this->Admin_model->get_cant_registro_mail());
                        $anio=date('Y');
                        $aniof=substr($anio, 2,2);

                        if($totalRows_t<9){
                            $codigo=$aniof."000".($totalRows_t+1);
                        }
                        if($totalRows_t>8 && $totalRows_t<99){
                            $codigo=$aniof."00".($totalRows_t+1);
                        }
                        if($totalRows_t>98 && $totalRows_t<999){
                            $codigo=$aniof."0".($totalRows_t+1);
                        }
                        if($totalRows_t>998 ){
                            $codigo=$aniof.($totalRows_t+1);
                        }
                        $cod_registro=$codigo;
    
                        $dato['cod_registro']= $cod_registro;
                        $dato['id_informe'] = $informe[$posicion_informe]['id_informe'];
                        if($dato['nombre_departamento']!=""){
                            $dato['id_departamento'] = $departamento[$posicion_departamento]['id_departamento'];
                        }else{
                            $dato['id_departamento'] = "";
                        }
                        if($dato['nombre_provincia']!=""){
                            $dato['id_provincia'] = $provincia[$posicion_provincia]['id_provincia'];
                        }else{
                            $dato['id_provincia'] = "";
                        }
                        if($dato['nombre_distrito']!=""){
                            $dato['id_distrito'] = $distrito[$posicion_distrito]['id_distrito'];
                        }else{
                            $dato['id_distrito'] = "";
                        }
                        $dato['id_empresa'] = $dato['cod_empresa'];
                        $dato['id_sede'] = $dato['cod_sede'];
                        $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];
    
                        $this->Admin_model->importar_registro_mail($dato);

                        $ultimo_registro=$this->Admin_model->ultimo_registro_mail();
                        $dato['id_registro']=$ultimo_registro[0]['id_registro'];

                        $this->Admin_model->primer_importar_registro_mail($dato);

                        if($dato['nom_producto_interes']!=""){
                            $validar_producto = $this->Admin_model->valida_imp_registro_mail_producto($dato);
                            if(count($validar_producto)==0){
                                $this->Admin_model->imp_registro_mail_producto($dato);
                            }
                        }
                    }
                }
            //}
        }
        else{
            redirect('/login');
        }
    }

    //---------------------------------------------FOTOCHECK COLABORADORES-------------------------------------------
    public function Fotocheck_Colaborador(){
        if($this->session->userdata('usuario')){

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();


            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_CursosCortos->get_list_nav_sede();


            $this->load->view('view_CC/fotocheck_colaborador/index',$dato);
        }
    }
}