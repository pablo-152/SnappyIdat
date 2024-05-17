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

class LeadershipSchool extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_LeadershipSchool');
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
            $dato['fondo'] = $this->Model_LeadershipSchool->fondo_index();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/administrador/index',$dato);
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //---------------------------------------------INFORME-------------------------------------------
    public function Informe_Lista() {
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/informe/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Informe_Lista(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Informe (Lista)');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(40);
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

        $sheet->getStyle("A1:B2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Nombre');             
        $sheet->setCellValue("B1", 'Descripción');

        $sheet->setCellValue("A2", "Pensiones Canceladas / Por Cancelar");
        $sheet->setCellValue("B2", "Lista de pensiones canceladas y por cancelar con estado de matricula del alumno");
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
    public function Informe(){
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/informe/informe',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Lista_Informe(){
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_informe'] = $this->Model_LeadershipSchool->get_list_informe();
            $this->load->view('view_LS/informe/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Lista_Informe($tipo){
        $list_informe = $this->Model_LeadershipSchool->get_list_informe();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Pens. Canc. y Por Canc. (Lista)');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(28);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(28);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(22);
        $sheet->getColumnDimension('K')->setWidth(24);
        $sheet->getColumnDimension('L')->setWidth(20);
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

        $sheet->setCellValue("A1", 'Estado');             
        $sheet->setCellValue("B1", 'Grado');
        $sheet->setCellValue("C1", 'Pendientes');
        $sheet->setCellValue("D1", 'Pendientes Matriculados');             
        $sheet->setCellValue("E1", 'Pendientes Retirados');
        $sheet->setCellValue("F1", 'Total Pendientes');
        $sheet->setCellValue("G1", 'Cancelados');             
        $sheet->setCellValue("H1", 'Cancelados Matriculados');
        $sheet->setCellValue("I1", 'Cancelados Retirados');
        $sheet->setCellValue("J1", 'Total Cancelados');             
        $sheet->setCellValue("K1", 'Total Devoluciones');
        $sheet->setCellValue("L1", 'Total Alumnos');
        $sheet->setCellValue("M1", 'Total');

        $contador=1;

        if($tipo==1){
            foreach($list_informe as $list){
                if($list['CourseStatus']=="Activo"){
                    $contador++;
    
                    $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
    
                    $sheet->setCellValue("A{$contador}", $list['CourseStatus']);
                    $sheet->setCellValue("B{$contador}", $list['CourseName']);
                    $sheet->setCellValue("C{$contador}", $list['TotalPending']);
                    $sheet->setCellValue("D{$contador}", $list['TotalPendingMatriculated']);
                    $sheet->setCellValue("E{$contador}", $list['TotalPendingOthers']);
                    $sheet->setCellValue("F{$contador}", "s./ ".number_format($list['TotalAmountPending'],2));
                    $sheet->setCellValue("G{$contador}", $list['TotalPaid']);
                    $sheet->setCellValue("H{$contador}", $list['TotalPaidMatriculated']);
                    $sheet->setCellValue("I{$contador}", $list['TotalPaidOthers']);
                    $sheet->setCellValue("J{$contador}", "s./ ".number_format($list['TotalAmountPaid'],2));
                    $sheet->setCellValue("K{$contador}", "s./ ".number_format($list['TotalRefund'],2));
                    $sheet->setCellValue("L{$contador}", $list['TotalStudents']);
                    $sheet->setCellValue("M{$contador}", "s./ ".number_format($list['TotalAmount'],2));
                }
            }
        }else{
            foreach($list_informe as $list){
                $contador++;

                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", $list['CourseStatus']);
                $sheet->setCellValue("B{$contador}", $list['CourseName']);
                $sheet->setCellValue("C{$contador}", $list['TotalPending']);
                $sheet->setCellValue("D{$contador}", $list['TotalPendingMatriculated']);
                $sheet->setCellValue("E{$contador}", $list['TotalPendingOthers']);
                $sheet->setCellValue("F{$contador}", "s./ ".number_format($list['TotalAmountPending'],2));
                $sheet->setCellValue("G{$contador}", $list['TotalPaid']);
                $sheet->setCellValue("H{$contador}", $list['TotalPaidMatriculated']);
                $sheet->setCellValue("I{$contador}", $list['TotalPaidOthers']);
                $sheet->setCellValue("J{$contador}", "s./ ".number_format($list['TotalAmountPaid'],2));
                $sheet->setCellValue("K{$contador}", "s./ ".number_format($list['TotalRefund'],2));
                $sheet->setCellValue("L{$contador}", $list['TotalStudents']);
                $sheet->setCellValue("M{$contador}", "s./ ".number_format($list['TotalAmount'],2));
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pensiones Canceladas y Por Cancelar (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Informe($CourseId=null){
        if ($this->session->userdata('usuario')) {
            $dato['CourseId'] = $CourseId;
            $dato['list_detalle'] = $this->Model_LeadershipSchool->get_list_detalle_informe($CourseId);

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/informe/detalle',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Informe($CourseId){
        $list_detalle = $this->Model_LeadershipSchool->get_list_detalle_informe($CourseId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle (Lista)');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(22);

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

        $sheet->setCellValue("A1", 'Descripción');             
        $sheet->setCellValue("B1", 'Pendientes');
        $sheet->setCellValue("C1", 'Total Pendientes');

        $contador=1;

        foreach($list_detalle as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['ItemDescription']);
            $sheet->setCellValue("B{$contador}", $list['TotalPending']);
            $sheet->setCellValue("C{$contador}", "s./ ".number_format($list['TotalAmountPending'],2));
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle Pensiones Canceladas y Por Cancelar (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Alumno($CourseId=null, $PaymentDueDate=null){
        if ($this->session->userdata('usuario')) {
            $dato['CourseId']=$CourseId;
            $dato['PaymentDueDate']=$PaymentDueDate;
            $PaymentDueDate = substr($PaymentDueDate,0,4)."-".substr($PaymentDueDate,4,2)."-".substr($PaymentDueDate,6,2);
            $dato['list_alumno'] = $this->Model_LeadershipSchool->get_list_alumno_informe($CourseId,$PaymentDueDate);

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/informe/detalle_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Alumno($CourseId,$PaymentDueDate){
        $PaymentDueDate = substr($PaymentDueDate,0,4)."-".substr($PaymentDueDate,4,2)."-".substr($PaymentDueDate,6,2);
        $list_alumno = $this->Model_LeadershipSchool->get_list_alumno_informe($CourseId,$PaymentDueDate);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Alumnos (Lista)');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getColumnDimension('P')->setWidth(18);
        $sheet->getColumnDimension('Q')->setWidth(25);
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

        $sheet->setCellValue("A1", 'Estado');             
        $sheet->setCellValue("B1", 'Recibo');
        $sheet->setCellValue("C1", 'Fecha VP');
        $sheet->setCellValue("D1", 'Fecha Pago');             
        $sheet->setCellValue("E1", 'Grado');
        $sheet->setCellValue("F1", 'Descripción');
        $sheet->setCellValue("G1", 'Código');             
        $sheet->setCellValue("H1", 'DNI');
        $sheet->setCellValue("I1", 'Apellido Paterno');
        $sheet->setCellValue("J1", 'Apellido Materno');             
        $sheet->setCellValue("K1", 'Nombre(s)');
        $sheet->setCellValue("L1", 'Matrícula');
        $sheet->setCellValue("M1", 'Monto');
        $sheet->setCellValue("N1", 'Descuento');
        $sheet->setCellValue("O1", 'Penalidad');             
        $sheet->setCellValue("P1", 'SubTotal');
        $sheet->setCellValue("Q1", 'Curso');
        $sheet->setCellValue("R1", 'Estado');

        $contador=1;

        foreach($list_alumno as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['PaymentStatus']);
            $sheet->setCellValue("B{$contador}", $list['ReceiptNumber']);
            $sheet->setCellValue("C{$contador}", $list['PaymentDueDate']);
            $sheet->setCellValue("D{$contador}", $list['PaymentDate']);
            $sheet->setCellValue("E{$contador}", $list['CourseGrade']);
            $sheet->setCellValue("F{$contador}", $list['Description']);
            $sheet->setCellValue("G{$contador}", $list['InternalStudentId']);
            $sheet->setCellValue("H{$contador}", $list['IdentityCardNumber']);
            $sheet->setCellValue("I{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("J{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("K{$contador}", $list['FirstName']);
            $sheet->setCellValue("L{$contador}", $list['MatriculationStatus']);
            $sheet->setCellValue("M{$contador}", "s./ ".number_format($list['Cost'],2));
            $sheet->setCellValue("N{$contador}", "s./ ".number_format($list['TotalDiscount'],2));
            $sheet->setCellValue("O{$contador}", "s./ ".number_format($list['PenaltyAmountToBePaid'],2));
            $sheet->setCellValue("P{$contador}", "s./ ".number_format($list['SubTotal'],2));
            $sheet->setCellValue("Q{$contador}", $list['CourseName']);
            $sheet->setCellValue("R{$contador}", $list['CourseStatus']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle Alumnos Pensiones Canceladas / Por Cancelar (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/profesor/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Profesor() {
        if ($this->session->userdata('usuario')) {
            $dato['list_profesor'] = $this->Model_LeadershipSchool->get_list_profesor();
            $this->load->view('view_LS/profesor/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Profesor(){
        $list_profesor = $this->Model_LeadershipSchool->get_list_profesor();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/documento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_LeadershipSchool->get_list_documento();
            $this->load->view('view_LS/documento/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_LS/documento/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento(){
        $dato['cod_documento']= $this->input->post("cod_documento_i");
        $dato['nom_grado']= $this->input->post("nom_grado_i");
        $dato['nom_documento']= $this->input->post("nom_documento_i");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_i");  
        $dato['obligatorio']= $this->input->post("obligatorio_i");
        $dato['digital']= $this->input->post("digital_i");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_i");
        $dato['validacion']= $this->input->post("validacion_i");

        $total=count($this->Model_LeadershipSchool->valida_insert_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_LeadershipSchool->insert_documento($dato);
            if($dato['aplicar_todos']==1){
                $get_id = $this->Model_LeadershipSchool->ultimo_id_documento();
                $dato['id_documento'] = $get_id[0]['id_documento'];
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_LeadershipSchool->get_list_alumno_documento_todos();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['Id'];
                    $valida = $this->Model_LeadershipSchool->valida_insert_documento_todos($dato);
                    if(count($valida)==0){
                        $this->Model_LeadershipSchool->insert_documento_todos($dato);
                    }
                }
            }
        }
    }

    public function Modal_Update_Documento($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_documento($id_documento);
            $dato['list_status'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/documento/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $dato['cod_documento']= $this->input->post("cod_documento_u");
        $dato['nom_grado']= $this->input->post("nom_grado_u");
        $dato['nom_documento']= $this->input->post("nom_documento_u");
        $dato['descripcion_documento']= $this->input->post("descripcion_documento_u");  
        $dato['obligatorio']= $this->input->post("obligatorio_u");
        $dato['digital']= $this->input->post("digital_u");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_u");
        $dato['validacion']= $this->input->post("validacion_u");
        $dato['estado']= $this->input->post("estado_u");
 
        $total=count($this->Model_LeadershipSchool->valida_update_documento($dato));
        if($total>0){
            echo "error";
        }else{
            $this->Model_LeadershipSchool->update_documento($dato);
            if($dato['aplicar_todos']==1){
                $dato['anio'] = date('Y');

                $list_alumno = $this->Model_LeadershipSchool->get_list_alumno_documento_todos();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['Id'];
                    $valida = $this->Model_LeadershipSchool->valida_insert_documento_todos($dato);
                    if(count($valida)==0){
                        $this->Model_LeadershipSchool->insert_documento_todos($dato);
                    }
                }
            }
        }
    }

    public function Delete_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_LeadershipSchool->delete_documento($dato);
    }

    public function Excel_Documento(){
        $list_documento = $this->Model_LeadershipSchool->get_list_documento();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documento');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
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
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
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
    //------------------------------------------------------MATRICULADOS------------------------------------------
    public function Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['informe'] = $this->Model_LeadershipSchool->get_informe_matriculados(); 

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/matriculados/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Model_LeadershipSchool->get_list_matriculados($dato['tipo']);
            $this->load->view('view_LS/matriculados/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Retiro_Alumno($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_matriculados($id_alumno);
            $dato['get_retirado'] = $this->Model_LeadershipSchool->valida_alumno_retirado($id_alumno);
            $dato['list_motivo'] = $this->Model_LeadershipSchool->get_list_motivo();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/matriculados/retirar_alumno',$dato);
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

            $cant = count($this->Model_LeadershipSchool->valida_alumno_retirado($dato['id_alumno']));

            if($cant>0){
                $this->Model_LeadershipSchool->update_retiro_alumno($dato);
            }else{
                $this->Model_LeadershipSchool->insert_retiro_alumno($dato);

                $get_id = $this->Model_LeadershipSchool->get_id_matriculados($dato['id_alumno']);

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
                $altiriaSMS->sendSMS($sDestination, $sMessage);
            } 
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Obs_Retiro($id_alumno_retirado){
        if ($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_alumno_retirado($id_alumno_retirado);
            $this->load->view('view_LS/matriculados/modal_obs_retiro', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Obs_Motivo_Retiro(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno_retirado']= $this->input->post("id_alumno_retirado");
            $dato['obs_retiro']= $this->input->post("obs_retiro");
            $this->Model_LeadershipSchool->update_obs_motivo_retiro($dato);
        }else{
            redirect('/login');
        }
    }

    public function Actualizar_Lista_Matriculados() {   
        $this->Model_LeadershipSchool->truncate_matriculados();

        $list_matriculados = $this->Model_LeadershipSchool->get_list_matriculados_arpay(); 

        foreach($list_nuevos_ll as $list){
            $dato['Id'] = $list['Id'];
            $dato['Apellido_Paterno'] = $list['Apellido_Paterno'];
            $dato['Apellido_Materno'] = $list['Apellido_Materno'];
            $dato['Nombre'] = $list['Nombre'];
            $dato['Codigo'] = $list['Codigo'];
            $dato['Dni'] = $list['Dni'];
            $dato['Email'] = $list['Email'];
            $dato['MobilePhone'] = $list['MobilePhone'];
            $dato['Fecha_Cumpleanos'] = $list['Fecha_Cumpleanos'];
            $dato['Grado'] = $list['Grado'];
            $dato['Seccion'] = $list['Seccion'];
            $dato['Course'] = $list['Course'];
            $dato['Class'] = $list['Class'];
            $dato['Anio'] = $list['Anio'];
            $dato['Fecha_Matricula'] = $list['Fecha_Matricula'];
            $dato['Usuario'] = $list['Usuario'];
            $dato['MatriculationStatusName'] = $list['MatriculationStatusName'];
            $dato['Alumno'] = $list['Alumno'];
            $dato['Pago_Pendiente'] = $list['Pago_Pendiente'];
            $dato['Fecha_Pago_Matricula'] = $list['Fecha_Pago_Matricula'];
            $dato['Monto_Matricula'] = $list['Monto_Matricula'];
            $dato['Fecha_Pago_Cuota_Ingreso'] = $list['Fecha_Pago_Cuota_Ingreso'];
            $dato['Monto_Cuota_Ingreso'] = $list['Monto_Cuota_Ingreso'];

            $this->Model_LeadershipSchool->insert_todos_LS($dato);
        }
    }

    public function Excel_Matriculados($tipo){
        $list_alumno = $this->Model_LeadershipSchool->get_list_matriculados($tipo);
        $sede = 'LS1';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:AA1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:AA1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Alumnos '.$sede.' (Lista)');
        $sheet->setAutoFilter('A1:AA1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(16);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(22);
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);
        $sheet->getColumnDimension('S')->setWidth(10);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(13);
        $sheet->getColumnDimension('V')->setWidth(20); 
        $sheet->getColumnDimension('W')->setWidth(18); 
        $sheet->getColumnDimension('X')->setWidth(30);
        $sheet->getColumnDimension('Y')->setWidth(18); 
        $sheet->getColumnDimension('Z')->setWidth(30);
        $sheet->getColumnDimension('AA')->setWidth(30);

        $sheet->getStyle('A1:AA1')->getFont()->setBold(true);    

        $spreadsheet->getActiveSheet()->getStyle("A1:AA1")->getFill()
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

        $sheet->getStyle("A1:AA1")->applyFromArray($styleThinBlackBorderOutline);
      
        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", 'Grado');
        $sheet->setCellValue("C1", 'Apellido Paterno');	        
        $sheet->setCellValue("D1", 'Apellido Materno');
        $sheet->setCellValue("E1", 'Nombre(s)');
        $sheet->setCellValue("F1", 'DNI');
        $sheet->setCellValue("G1", 'Fecha Nacimiento');
        $sheet->setCellValue("H1", 'Edad (Años)');	
        $sheet->setCellValue("I1", 'Edad (Meses)');	  
        $sheet->setCellValue("J1", 'Sección');
        $sheet->setCellValue("K1", 'Status');	         
        $sheet->setCellValue("L1", 'Matricula');
        $sheet->setCellValue("M1", 'Usuario');
        $sheet->setCellValue("N1", 'Cuota (Fecha Pago)');
        $sheet->setCellValue("O1", 'Cuota (Monto)');
        $sheet->setCellValue("P1", 'Matricula');
        $sheet->setCellValue("Q1", 'Monto');
        $sheet->setCellValue("R1", 'Alumno');	        
        $sheet->setCellValue("S1", 'Año');
        $sheet->setCellValue("T1", 'Contrato');
        $sheet->setCellValue("U1", 'Pagos');
        $sheet->setCellValue("V1", 'Documentos');	    	 
        $sheet->setCellValue("W1", 'Celular Tutor 1');	    
        $sheet->setCellValue("X1", 'Email Tutor 1');	 
        $sheet->setCellValue("Y1", 'Celular Tutor 2');	    
        $sheet->setCellValue("Z1", 'Email Tutor 2');
        $sheet->setCellValue("AA1", 'Observación');

        $contador=1;

        foreach($list_alumno as $list){
            $contador++;

            $fec_de = new DateTime($list['Fecha_Cumpleanos']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); 

            $list_tutor = $this->Model_LeadershipSchool->get_list_tutores_alumno($list['Id']);

            $sheet->getStyle("A{$contador}:AA{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:AA{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("X{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AA{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:AA{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("O{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("Q{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            
            $sheet->setCellValue("A{$contador}", $list['Codigo']);
            $sheet->setCellValue("B{$contador}", $list['Grado']);
            $sheet->setCellValue("C{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("D{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("E{$contador}", $list['Nombre']);
            $sheet->setCellValue("F{$contador}", $list['Dni']); 
            if($list['Cumpleanos']=="" || $list['Cumpleanos']=="00/00/0000"){
                $sheet->setCellValue("G{$contador}", "");
            }else{
                $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['Cumpleanos']));
                $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("H{$contador}", $diff->y);
            $sheet->setCellValue("I{$contador}", $diff->m); 
            $sheet->setCellValue("J{$contador}", $list['Seccion']);
            $sheet->setCellValue("K{$contador}", $list['Matricula']);
            if($list['Fec_Matricula']=="" || $list['Fec_Matricula']=="00/00/0000"){
                $sheet->setCellValue("L{$contador}", "");
            }else{
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['Fec_Matricula']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("M{$contador}", $list['Usuario']);
            if($list['Fec_Pago_Cuota_Ingreso']=="" || $list['Fec_Pago_Cuota_Ingreso']=="00/00/0000"){
                $sheet->setCellValue("N{$contador}", "");
            }else{
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list['Fec_Pago_Cuota_Ingreso']));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("O{$contador}", $list['Monto_Cuota_Ingreso']);
            if($list['Fec_Pago_Matricula']=="" || $list['Fec_Pago_Matricula']=="00/00/0000"){
                $sheet->setCellValue("P{$contador}", "");
            }else{
                $sheet->setCellValue("P{$contador}", Date::PHPToExcel($list['Fec_Pago_Matricula']));
                $sheet->getStyle("P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("Q{$contador}", $list['Monto_Matricula']);
            $sheet->setCellValue("R{$contador}", $list['Alumno']);
            $sheet->setCellValue("S{$contador}", $list['Anio']);
            if($list['v_contrato']!=""){
                $sheet->setCellValue("T{$contador}", Date::PHPToExcel($list['v_contrato']));
                $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("U{$contador}", $list['nom_pago_pendiente']);
            $sheet->setCellValue("V{$contador}", $list['documentos_subidos']."/".$list['documentos_obligatorios']);
            if(count($list_tutor)>0){
                $sheet->setCellValue("W{$contador}", $list_tutor[0]['celular']);
                $sheet->setCellValue("X{$contador}", $list_tutor[0]['email']);
            }
            if(count($list_tutor)>1){
                $sheet->setCellValue("Y{$contador}", $list_tutor[1]['celular']);
                $sheet->setCellValue("Z{$contador}", $list_tutor[1]['email']);
            }

            $sheet->setCellValue("AA{$contador}", $list['comentariog']);
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'Alumnos '.$sede.' (Lista)';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0'); 

		$writer->save('php://output'); 
    }

    public function Detalle_Matriculados($id_alumno) {
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_matriculados($id_alumno);
            $dato['get_foto'] = $this->Model_LeadershipSchool->get_list_foto_matriculados($id_alumno);
            $dato['list_tutor'] = $this->Model_LeadershipSchool->get_list_tutor(null,$id_alumno);
            $dato['list_modulo']=$this->Model_LeadershipSchool->get_ingresos_modulo($id_alumno);
            $dato['id_empresa']=4;
            
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/matriculados/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Sexo($id_alumno){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno'] = $id_alumno;

            $valida = $this->Model_LeadershipSchool->valida_sexo($dato['id_alumno']);

            if(count($valida)>0){
                $dato['update'] = 1;
                $dato['get_id'] = $this->Model_LeadershipSchool->valida_sexo($dato['id_alumno']);
            }else{
                $dato['update'] = 0;
            }

            $this->load->view('view_LS/matriculados/modal_sexo', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Sexo(){
        $dato['id_sexo']= $this->input->post("id_sexo"); 
        $dato['id_alumno']= $this->input->post("id_alumno"); 
        $dato['sexo']= $this->input->post("sexo_u"); 

        if($dato['id_sexo']>0){
            $this->Model_LeadershipSchool->update_sexo($dato);
        }else{
            $this->Model_LeadershipSchool->insert_sexo($dato);
        }
    }

    public function Modal_Tutor(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_parentesco'] = $this->Model_LeadershipSchool->get_list_parentesco();
            $this->load->view('view_LS/matriculados/modal_tutor', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']= $this->input->post("id_alumno"); 
            $dato['id_parentesco']= $this->input->post("id_parentesco_i"); 
            $dato['apellido_paterno']= $this->input->post("apellido_paterno_i"); 
            $dato['apellido_materno']= $this->input->post("apellido_materno_i"); 
            $dato['nombre']= $this->input->post("nombre_i"); 
            $dato['celular']= $this->input->post("celular_i"); 
            $dato['email']= $this->input->post("email_i"); 
            $dato['no_mailing']= $this->input->post("no_mailing_i"); 

            $this->Model_LeadershipSchool->insert_tutor($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Tutor($id_tutor){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_tutor($id_tutor);
            $dato['list_parentesco'] = $this->Model_LeadershipSchool->get_list_parentesco();
            $this->load->view('view_LS/matriculados/modal_update_tutor', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tutor']= $this->input->post("id_tutor"); 
            $dato['id_parentesco']= $this->input->post("id_parentesco_u"); 
            $dato['apellido_paterno']= $this->input->post("apellido_paterno_u"); 
            $dato['apellido_materno']= $this->input->post("apellido_materno_u"); 
            $dato['nombre']= $this->input->post("nombre_u"); 
            $dato['celular']= $this->input->post("celular_u"); 
            $dato['email']= $this->input->post("email_u"); 
            $dato['no_mailing']= $this->input->post("no_mailing_u"); 

            $this->Model_LeadershipSchool->update_tutor($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tutor']= $this->input->post("id_tutor");
            $this->Model_LeadershipSchool->delete_tutor($dato);
        }else{
            redirect('/login');
        } 
    }    

    public function Lista_Documento_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_documento'] = $this->Model_LeadershipSchool->get_list_documento_matriculados($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_documentos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento_Alumno($id_documento,$id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_documento'] = $this->Model_LeadershipSchool->get_list_documento($id_documento);
            $dato['id_documento'] = $id_documento;
            $dato['id_alumno'] = $id_alumno;
            $this->load->view('view_LS/matriculados/modal_registrar_documento', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento_Alumno(){
        $dato['id_documento']= $this->input->post("id_documento");
        $dato['id_alumno'] = $this->input->post("id_alumno");
        $dato['archivo'] = "";

        if($_FILES["archivo_i"]["name"] != ""){
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
            $config['upload_path'] = './documento_alumno_matriculado/LS/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_matriculado/', 0777);
                chmod('./documento_alumno_matriculado/LS/', 0777);
                chmod('./documento_alumno_matriculado/LS/'.$dato['id_alumno'], 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["archivo_i"]["name"];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['archivo'] = "documento_alumno_matriculado/LS/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_LeadershipSchool->insert_documento_matriculados($dato);
    }

    public function Modal_Update_Documento_Alumno($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['get_detalle'] = $this->Model_LeadershipSchool->get_id_detalle_alumno_empresa($id_detalle);
            $dato['get_documento'] = $this->Model_LeadershipSchool->get_list_documento( $dato['get_detalle'][0]['id_documento']);
            $this->load->view('view_LS/matriculados/modal_editar_documento', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Alumno(){
        $dato['id_detalle']= $this->input->post("id_detalle");
        $get_id = $this->Model_LeadershipSchool->get_id_detalle_alumno_empresa($dato['id_detalle']);
        $dato['id_alumno'] = $get_id[0]['id_alumno'];
        $dato['archivo'] = $this->input->post("archivo_actual");

        if($_FILES["archivo_u"]["name"] != ""){
            if (file_exists($dato['archivo'])) { 
                unlink($dato['archivo']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
            $config['upload_path'] = './documento_alumno_matriculado/LS/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_matriculado/', 0777);
                chmod('./documento_alumno_matriculado/LS/', 0777);
                chmod('./documento_alumno_matriculado/LS/'.$dato['id_alumno'], 0777);
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
                $dato['archivo'] = "documento_alumno_matriculado/LS/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_LeadershipSchool->update_documento_matriculados($dato);
    }

    public function Descargar_Imagen($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['doc']=$this->Model_LeadershipSchool->get_id_detalle_alumno_empresa($id_detalle);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen,NULL);
        }else{
            redirect('');
        }
    }

    public function Delete_Documento_Alumno(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_detalle']= $this->input->post("id_detalle");
            $dato['doc']=$this->Model_LeadershipSchool->get_documento_alumno($dato);
            unlink($dato['doc'][0]['archivo']);
            $this->Model_LeadershipSchool->delete_documento_alumno($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Documento_Alumno($id_alumno){
        $list_documento = $this->Model_LeadershipSchool->get_list_documento_matriculados($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);

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
          
        $sheet->setCellValue("A1", 'Obligatorio');
        $sheet->setCellValue("B1", 'Año');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Nombre');
        $sheet->setCellValue("E1", 'Nombre Documento');
        $sheet->setCellValue("F1", 'Subido Por');
        $sheet->setCellValue("G1", 'Fecha Carga');

        $contador=1;
        
        foreach($list_documento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['v_obligatorio']);
            $sheet->setCellValue("B{$contador}", $list['anio']);
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

    public function Lista_Pago_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['estado'] = $this->input->post("estado");
            $dato['list_pago'] = $this->Model_LeadershipSchool->get_list_pago_matriculados($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_pagos',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Pago_Matriculados($id_alumno,$estado){
        $list_pago = $this->Model_LeadershipSchool->get_list_pago_matriculados($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Pago Alumno');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);

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
        
        foreach($list_pago as $list){
            if($estado==1){
                $contador++;

                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("E{$contador}:H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
    
                $sheet->setCellValue("A{$contador}", $list['Producto']);
                $sheet->setCellValue("B{$contador}", $list['Estado']);
                $sheet->setCellValue("C{$contador}", $list['Descripcion']);
                if($list['Fecha_VP']!=""){
                    $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['Fecha_VP']));
                    $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }else{
                    $sheet->setCellValue("D{$contador}", "");  
                }
                $sheet->setCellValue("E{$contador}", $list['Monto']);
                $sheet->setCellValue("F{$contador}", $list['Descuento']);
                $sheet->setCellValue("G{$contador}", $list['Penalidad']);
                $sheet->setCellValue("H{$contador}", $list['SubTotal']);  
            }else{
                if($list['Estado']=="Pendiente"){
                    $contador++;

                    $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("E{$contador}:H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        
                    $sheet->setCellValue("A{$contador}", $list['Producto']);
                    $sheet->setCellValue("B{$contador}", $list['Estado']);
                    $sheet->setCellValue("C{$contador}", $list['Descripcion']);
                    if($list['Fecha_VP']!=""){
                        $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['Fecha_VP']));
                        $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    }else{
                        $sheet->setCellValue("D{$contador}", "");  
                    }
                    $sheet->setCellValue("E{$contador}", $list['Monto']);
                    $sheet->setCellValue("F{$contador}", $list['Descuento']);
                    $sheet->setCellValue("G{$contador}", $list['Penalidad']);
                    $sheet->setCellValue("H{$contador}", $list['SubTotal']);  
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pago Alumno (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /*public function Lista_Foto() {
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']= $this->input->post("id_alumno"); 
            $dato['list_foto'] = $this->Model_LeadershipSchool->get_list_foto_matriculados($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_foto',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Foto_Matriculados($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno'] = $id_alumno;
            $this->load->view('view_LS/matriculados/modal_foto', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Valida_Update_Foto_Matriculados(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']= $this->input->post("id_alumno"); 
            $cantidad_foto = $this->Model_LeadershipSchool->get_list_foto_matriculados($dato['id_alumno']); 
            if(count($cantidad_foto)>0){
                echo "mensaje";
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Foto_Matriculados(){
        $dato['id_alumno']= $this->input->post("id_alumno");  
        $dato['foto']= ""; 

        $cantidad_foto = $this->Model_LeadershipSchool->get_todo_foto_matriculados($dato['id_alumno']);
        $numero = count($cantidad_foto)+1;

        if($_FILES["foto"]["name"] != ""){
            $config['upload_path'] = './foto_matriculado/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./foto_matriculado/', 0777);
                chmod('./foto_matriculado/'.$dato['id_alumno'], 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["foto"]["name"];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $dato['nom_documento'] = "Foto_Matriculado_".$dato['id_alumno']."_".$numero.".".$ext;
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["foto"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["foto"]["error"];
            $_FILES["file"]["size"] = $_FILES["foto"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['foto'] = "foto_matriculado/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        
        $this->Model_LeadershipSchool->insert_foto_matriculados($dato);
    }

    public function Delete_Foto_Matriculados(){
        if ($this->session->userdata('usuario')) {
            $dato['id_foto'] = $this->input->post("id_foto");
            $this->Model_LeadershipSchool->delete_foto_matriculados($dato);
        }else{
            redirect('/login');
        } 
    }*/

    public function Descargar_Foto_Matriculados($id_detalle) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_id_detalle_alumno_empresa($id_detalle);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Lista_Contrato_Matriculados() { 
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_contrato'] = $this->Model_LeadershipSchool->get_list_contrato_matriculados($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_contratos',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Modal_Update_Contrato_Matriculados($id_documento_firma){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_contrato($id_documento_firma);
            $this->load->view('view_LS/matriculados/modal_editar_contrato', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Contrato_Matriculados(){ 
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $dato['vencido']= $this->input->post("vencido_cu");
        $this->Model_LeadershipSchool->update_contrato_matriculados($dato);
    }

    public function Lista_Mensaje_Matriculados() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_mensaje'] = $this->Model_LeadershipSchool->get_list_mensaje_matriculados($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_mensajes',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Sms_Matriculados() {  
        if ($this->session->userdata('usuario')) { 
            $id_alumno = $this->input->post("id_alumno");
            $get_id = $this->Model_LeadershipSchool->get_id_matriculados($id_alumno); 
            $dato['list_sms'] = $this->Model_LeadershipSchool->get_list_sms_matriculados($get_id[0]['Celular']);
            $this->load->view('view_LS/matriculados/lista_sms',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Sms_Alumno($id_alumno){
        $get_id = $this->Model_LeadershipSchool->get_id_matriculados($id_alumno);
        $list_sms = $this->Model_LeadershipSchool->get_list_sms_matriculados($get_id[0]['Celular']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('SMS Alumno');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(200);

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
          
        $sheet->setCellValue("A1", 'Fecha');
        $sheet->setCellValue("B1", 'Usuario');
        $sheet->setCellValue("C1", 'Mensaje');

        $contador=1;
        
        foreach($list_sms as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['fecha']);
            $sheet->setCellValue("B{$contador}", $list['usuario']);
            $sheet->setCellValue("C{$contador}", $list['mensaje']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'SMS Alumno (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
    public function Lista_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_observacion']=$this->Model_LeadershipSchool->get_list_observacion_alumno($dato['id_alumno']);
            $this->load->view('view_LS/matriculados/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_matriculados($dato['id_alumno']);
            $dato['list_tipo_obs'] = $this->Model_LeadershipSchool->get_list_tipo_obs(1);
            $dato['list_usuario'] = $this->Model_LeadershipSchool->get_list_usuario_observacion();
            $this->load->view('view_LS/matriculados/registrar_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['id_tipo'] = $this->input->post("id_tipo_o");
            $id_tipo = $this->input->post("id_tipo_o");
            $dato['fecha'] = $this->input->post("fecha_o");
            $dato['usuario'] = $this->input->post("usuario_o");
            $dato['observacion'] = $this->input->post("observacion_o");
            $dato['comentariog'] = $this->input->post("comentariog_o");
    
            if($_FILES["observacion_archivo"]["name"] != ""){

                $dato['path'] = $_FILES['observacion_archivo']['name'];
                $fecha=date('Y-m-d');
                $path = $_FILES['observacion_archivo']['name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);

                $mi_archivo = 'observacion_archivo';

                $dato['nom_documento'] = "obs_historial".$dato['id_alumno'].$fecha."_".rand(1,200).".".$ext;
                $config['upload_path'] = './alumno/ls/observacion/'.$dato['id_alumno'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./alumno/ls/observacion/', 0777);
                    chmod('./alumno/ls/observacion/'.$dato['id_alumno'], 0777);
                }
                $config["allowed_types"] = 'pdf|PDF|jpg|JPG|jpeg|JPEG|mp4|png|PNG';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["observacion_archivo"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["observacion_archivo"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["observacion_archivo"]["error"];
                $_FILES["file"]["size"] = $_FILES["observacion_archivo"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['observacion_archivo'] = "alumno/ls/observacion/".$dato['id_alumno']."/".$dato['nom_documento'];
                }    
            }else{
                $dato['observacion_archivo'] = "";
            }

            if($id_tipo!=0){
                $valida = $this->Model_LeadershipSchool->valida_insert_observacion_alumno($dato);
        
                if(count($valida)>0){
                    echo "error";
                }else{
                    $this->Model_LeadershipSchool->insert_observacion_alumno($dato);
                }
            }

            $this->Model_LeadershipSchool->update_comentario_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Editar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['get_id']=$this->Model_LeadershipSchool->get_list_observacion_alumno(null,$dato['id_observacion']);
            $dato['list_tipo_obs'] = $this->Model_LeadershipSchool->get_list_tipo_obs(1);
            $dato['list_usuario'] = $this->Model_LeadershipSchool->get_list_usuario_observacion();
            $this->load->view('view_LS/matriculados/editar_observacion',$dato);
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

            $valida = $this->Model_LeadershipSchool->valida_update_observacion_alumno($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_LeadershipSchool->update_observacion_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_obsaimg($dato['id_observacion']);

            if (file_exists($dato['get_id'][0]['observacion_archivo'])) {
                unlink($dato['get_id'][0]['observacion_archivo']);
            }
            $this->Model_LeadershipSchool->delete_observacion_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Observacion_Alumno($id_alumno){
        $list_observacion = $this->Model_LeadershipSchool->get_list_observacion_alumno($id_alumno);

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/doc_alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Doc_Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_LeadershipSchool->get_list_todos_alumno();
            $this->load->view('view_LS/doc_alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Doc_Alumno(){
        $list_alumno = $this->Model_LeadershipSchool->get_list_todos_alumno();
        $list_documento = $this->Model_LeadershipSchool->get_list_doc_alumnos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

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
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(10);
        $sheet->getColumnDimension('Q')->setWidth(20);
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
        $sheet->setCellValue("L1", 'Status');	         
        $sheet->setCellValue("M1", 'Matricula');
        $sheet->setCellValue("N1", 'Usuario');
        $sheet->setCellValue("O1", 'Alumno');	        
        $sheet->setCellValue("P1", 'Año');
        $sheet->setCellValue("Q1", 'Documentos');	    
        $sheet->setCellValue("R1", 'Link Foto');	
        
        /*$primera_letra = "S";
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
        }*/

        $contador=2;

        foreach($list_alumno as $list){
            $contador++;

            $fec_de = new DateTime($list['Fecha_Cumpleanos']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); 

            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("R{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("R{$contador}")->getFont()->setUnderline(true);  
            
            $sheet->setCellValue("A{$contador}", $list['foto']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("C{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("D{$contador}", $list['Nombre']);
            $sheet->setCellValue("E{$contador}", $list['Dni']); 
            if($list['Cumpleanos']=="" || $list['Cumpleanos']=="00/00/0000"){
                $sheet->setCellValue("F{$contador}", "");
            }else{
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['Cumpleanos']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("G{$contador}", $diff->y);
            $sheet->setCellValue("H{$contador}", $diff->m); 
            $sheet->setCellValue("I{$contador}", $list['Codigo']);
            $sheet->setCellValue("J{$contador}", $list['Grado']);
            $sheet->setCellValue("K{$contador}", $list['Seccion']);
            $sheet->setCellValue("L{$contador}", $list['Matricula']);
            if($list['Fec_Matricula']=="" || $list['Fec_Matricula']=="00/00/0000"){
                $sheet->setCellValue("M{$contador}", "");
            }else{
                $sheet->setCellValue("M{$contador}", Date::PHPToExcel($list['Fec_Matricula']));
                $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("N{$contador}", $list['Usuario']);
            $sheet->setCellValue("O{$contador}", $list['Alumno']);
            $sheet->setCellValue("P{$contador}", $list['Anio']);
            $sheet->setCellValue("Q{$contador}", $list['documentos_subidos']."/".$list['documentos_obligatorios']);
            if($list['link_foto']!=""){
                $sheet->setCellValue("R{$contador}", base_url().$list['link_foto']);
                $sheet->getCell("R{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
            }else{
                $sheet->setCellValue("R{$contador}", "");
            }

            /*$primera_letra = "S";
            $segunda_letra = "T";
            $tercera_letra = "U";

            foreach($list_documento as $documento){
                $sheet->getStyle("$primera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$segunda_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$tercera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $list_detalle = $this->Model_LeadershipSchool->get_list_detalle_doc_alumnos($list['Id'],$documento['cod_documento']);

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/alumno_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno_Obs() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno_obs'] = $this->Model_LeadershipSchool->get_list_alumno_obs();
            $this->load->view('view_LS/alumno_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Alumno_Obs(){
        $list_alumno_obs = $this->Model_LeadershipSchool->get_list_alumno_obs();

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
        $sheet->getColumnDimension('F')->setWidth(15);
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
            $sheet->setCellValue("D{$contador}", $list['Codigo']);
            $sheet->setCellValue("E{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("F{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("G{$contador}", $list['Nombre']);
            $sheet->setCellValue("H{$contador}", $list['Grado']); 
            $sheet->setCellValue("I{$contador}", $list['Seccion']);
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/soporte_doc/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Soporte_Doc() {
        if ($this->session->userdata('usuario')) {
            $dato['list_soporte_doc'] = $this->Model_LeadershipSchool->get_list_soporte_doc();
            $this->load->view('view_LS/soporte_doc/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Soporte_Doc(){
        $list_soporte_doc = $this->Model_LeadershipSchool->get_list_soporte_doc();

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
        $filename ='Soporte Docs (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------DOCUMENTO-------------------------------------------
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/c_contrato/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_C_Contrato() {
        if ($this->session->userdata('usuario')) {
            $dato['list_c_contrato'] = $this->Model_LeadershipSchool->get_list_c_contrato();
            $this->load->view('view_LS/c_contrato/lista',$dato);
        }else{
            redirect('/login');
        }
    }


    public function Modal_C_Contrato(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_LeadershipSchool->get_list_anio();
            $dato['list_mes'] = $this->Model_LeadershipSchool->get_list_mes();
            $dato['list_grado'] = $this->Model_LeadershipSchool->get_list_grado_contrato();
            $this->load->view('view_LS/c_contrato/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Contrato_I() {
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_seccion']= "id_seccion_i";
            $dato['list_seccion'] = $this->Model_LeadershipSchool->get_list_seccion_contrato($dato['id_grado']);
            $this->load->view('view_LS/c_contrato/seccion',$dato);
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

        $cantidad = $this->Model_LeadershipSchool->ultimo_id_c_contrato();
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

        $this->Model_LeadershipSchool->insert_c_contrato($dato);
    }

    public function Modal_Update_C_Contrato($id_c_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_c_contrato($id_c_contrato);
            $dato['list_anio'] = $this->Model_LeadershipSchool->get_list_anio();
            $dato['list_mes'] = $this->Model_LeadershipSchool->get_list_mes();
            $dato['list_grado'] = $this->Model_LeadershipSchool->get_list_grado_contrato();
            $dato['list_seccion'] = $this->Model_LeadershipSchool->get_list_seccion_contrato($dato['get_id'][0]['id_grado']);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/c_contrato/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Contrato_U() {
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_seccion']= "id_seccion_u";
            $dato['list_seccion'] = $this->Model_LeadershipSchool->get_list_seccion_contrato($dato['id_grado']);
            $this->load->view('view_LS/c_contrato/seccion',$dato);
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

        $this->Model_LeadershipSchool->update_c_contrato($dato); 
    }

    public function Delete_C_Contrato(){
        $dato['id_c_contrato']= $this->input->post("id_c_contrato");
        $this->Model_LeadershipSchool->delete_c_contrato($dato); 
    }

    public function Excel_C_Contrato(){
        $list_c_contrato = $this->Model_LeadershipSchool->get_list_c_contrato();

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
            $dato['get_file'] = $this->Model_LeadershipSchool->get_list_c_contrato($id_c_contrato);
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/contrato/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Contrato() { 
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_nuevos'] = $this->Model_LeadershipSchool->get_list_contrato($dato['tipo']);
            $this->load->view('view_LS/contrato/lista',$dato); 
        }else{
            redirect('/login');
        }
    }

    public function Actualizar_Lista_Contrato() { 
        if ($this->session->userdata('usuario')) {
            $this->Model_LeadershipSchool->truncate_tables_contrato();

            $list_nuevos_ls = $this->Model_LeadershipSchool->get_list_nuevos_ls_arpay(); 

            foreach($list_nuevos_ls as $list){
                $dato['Id'] = $list['Id'];
                $dato['Codigo'] = $list['Codigo'];
                $dato['Apellido_Paterno'] = $list['Apellido_Paterno'];
                $dato['Apellido_Materno'] = $list['Apellido_Materno'];
                $dato['Nombre'] = $list['Nombre'];
                $dato['Dni'] = $list['Dni'];
                $dato['Fecha_Cumpleanos'] = $list['Fecha_Cumpleanos'];
                $dato['Grado'] = $list['Grado']; 
                $dato['Seccion'] = $list['Seccion'];
                $dato['Fecha_Matricula'] = $list['Fecha_Pago_Matricula'];
                $dato['Fecha_Cuota'] = $list['Fecha_Pago_Cuota_Ingreso'];
                $dato['Anio'] = $list['Anio'];

                $this->Model_LeadershipSchool->insert_nuevos_ls($dato);
            }

            $get_id = $this->Model_LeadershipSchool->get_Ids_nuevos_ls();

            $list_apoderados_ls = $this->Model_LeadershipSchool->get_list_apoderados_ls_arpay($get_id[0]['ids']); 

            foreach($list_apoderados_ls as $list){
                $dato['Id'] = $list['Id'];
                $dato['Id_Alumno'] = $list['Id_Alumno'];
                $dato['Apellido_Paterno'] = $list['Apellido_Paterno'];
                $dato['Apellido_Materno'] = $list['Apellido_Materno'];
                $dato['Nombre'] = $list['Nombre'];
                $dato['Dni'] = $list['Dni'];
                $dato['Email'] = $list['Email'];
                $dato['Celular'] = $list['Celular'];
                $dato['Fecha_Cumpleanos'] = $list['Fecha_Cumpleanos'];
                $dato['Parentesco'] = $list['Parentesco'];

                $this->Model_LeadershipSchool->insert_apoderados_ls($dato);
            }

            //ENVIO DE CORREOS Y SMS

            include "mcript.php";
            include('application/views/administrador/mensaje/httpPHPAltiria.php');

            $list_contrato = $this->Model_LeadershipSchool->get_contratos_activos();

            foreach($list_contrato as $get_contrato){
                $list_apoderados = $this->Model_LeadershipSchool->get_datos_alumno_contrato($get_contrato['id_c_contrato']);

                foreach($list_apoderados as $list){
                    $valida = $this->Model_LeadershipSchool->valida_envio_correo_contrato($list['Id_Alumno'],$list['Id'],$get_contrato['id_c_contrato']);

                    if(count($valida)==0){
                        $dato['id_alumno'] = $list['Id_Alumno'];
                        $dato['cod_alumno'] = $list['cod_alumno'];
                        $dato['apater_alumno'] = $list['apater_alumno'];
                        $dato['amater_alumno'] = $list['amater_alumno'];
                        $dato['nom_alumno'] = $list['nom_alumno'];
                        $dato['cumpleanos_alumno'] = $list['cumpleanos_alumno'];
                        $dato['dni_alumno'] = $list['dni_alumno'];
                        $dato['grado_alumno'] = $list['grado_alumno'];
                        $dato['seccion_alumno'] = $list['seccion_alumno'];
                        $dato['id_apoderado']= $list['Id'];
                        $dato['apater_apoderado'] = $list['Apellido_Paterno'];
                        $dato['amater_apoderado'] = $list['Apellido_Materno'];
                        $dato['nom_apoderado'] = $list['Nombre'];
                        $dato['parentesco_apoderado'] = $list['Parentesco'];
                        $dato['email_apoderado'] = $list['Email'];
                        $dato['celular_apoderado'] = $list['Celular'];
                        $dato['cumpleanos_apoderado'] = $list['cumpleanos_apoderado'];
                        $dato['dni_apoderado'] = $list['dni_apoderado'];
                        $dato['id_contrato'] = $get_contrato['id_c_contrato'];
                
                        $this->Model_LeadershipSchool->insert_documento_firma($dato);
                        $ultimo = $this->Model_LeadershipSchool->ultimo_id_documento_firma();

                        $encryption_id = $encriptar($ultimo[0]['id_documento_firma']);

                        $mail = new PHPMailer(true);
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_ls/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@leadershipschool.edu.pe';                     // usuario de acceso
                            $mail->Password   = $this->config->item('adm_ls');                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Leadership School'); //desde donde se envia 
                            
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
            redirect('/login');
        }
    }

    public function Modal_Update_Email_Contrato($id_documento_firma) { 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_contrato($id_documento_firma);
            $this->load->view('view_LS/contrato/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Email_Contrato(){
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $dato['email_apoderado']= $this->input->post("email_apoderado_u");
        $this->Model_LeadershipSchool->update_email_contrato($dato); 
    }

    public function Reenviar_Email(){ 
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $dato['id_documento_firma'] = $this->input->post("id_documento_firma");
            $get_id = $this->Model_LeadershipSchool->get_id_contrato($dato['id_documento_firma']);
            $get_alumno = $this->Model_LeadershipSchool->get_datos_alumno_arpay($get_id[0]['id_alumno']);
            $get_apoderado = $this->Model_LeadershipSchool->get_datos_apoderados_arpay($get_id[0]['id_apoderado']);
            $dato['grado_alumno'] = $get_alumno[0]['Grado']; 
            $dato['seccion_alumno'] = $get_alumno[0]['Seccion'];
            $dato['cumpleanos_apoderado'] = $get_apoderado[0]['Fecha_Cumpleanos'];
            $dato['dni_apoderado'] = $get_apoderado[0]['Dni'];
            $this->Model_LeadershipSchool->update_documento_firma($dato);

            $get_correo = $this->Model_LeadershipSchool->get_list_c_contrato($get_id[0]['id_contrato']);

            $encryption_id = $encriptar($get_id[0]['id_documento_firma']);

            $mail = new PHPMailer(true);
            $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_ls/".$encryption_id;
            
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'admision@leadershipschool.edu.pe';                     // usuario de acceso
                $mail->Password   = $this->config->item('adm_ls');                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreply@snappy.org.pe', 'Leadership School'); //desde donde se envia 
                
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
        }else{
            redirect('/login');
        }
    }

    public function Delete_Contrato(){
        $dato['id_documento_firma']= $this->input->post("id_documento_firma");
        $this->Model_LeadershipSchool->delete_documento_firma($dato);  
    }

    public function Excel_Contrato($tipo){
        $list_nuevos = $this->Model_LeadershipSchool->get_list_contrato($tipo);

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
    //------------------------------------------------------MATRICULA PENDIENTE------------------------------------------
    public function Matricula_Pendiente() { 
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/matricula_pendiente/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula_Pendiente() {
        if ($this->session->userdata('usuario')) { 
            $tipo = $this->input->post("tipo");
            $data['list_alumnom'] = $this->Model_LeadershipSchool->get_list_matriculados(3);
            $data['list_alumno'] = $this->Model_LeadershipSchool->get_list_matricula_pendiente($tipo);
            $this->load->view('view_LS/matricula_pendiente/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matricula_Pendiente($tipo){
        $list_alumno = $this->Model_LeadershipSchool->get_list_matricula_pendiente($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Matriculas Pendientes (Lista)');
        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
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
      
        $sheet->setCellValue("A1", 'Apellido Paterno');	        
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Grado '.(date('Y')-1));
        $sheet->setCellValue("F1", 'Grado '.date('Y'));
        $sheet->setCellValue("G1", 'Matricula');
        $sheet->setCellValue("H1", 'Alumno');	        
        $sheet->setCellValue("I1", 'Año');  

        $contador=1;

        foreach($list_alumno as $list){ 
            $contador++;
            $seccion="";
            if($list['CourseGradeId']==0){$seccion="2 Primaria";}
            elseif($list['CourseGradeId']==1){$seccion="3 Primaria";}
            elseif($list['CourseGradeId']==2){$seccion="4 Primaria";}
            elseif($list['CourseGradeId']==3){$seccion="5 Primaria";}
            elseif($list['CourseGradeId']==4){$seccion="6 Primaria";}
            elseif($list['CourseGradeId']==5){$seccion="1 Secundaria";}
            elseif($list['CourseGradeId']==6){$seccion="2 Secundaria";}
            elseif($list['CourseGradeId']==7){$seccion="3 Secundaria";}
            elseif($list['CourseGradeId']==8){$seccion="4 Secundaria";}
            elseif($list['CourseGradeId']==9){$seccion="5 Secundaria";}
            elseif($list['CourseGradeId']==11){$seccion="3 Años";}
            elseif($list['CourseGradeId']==12){$seccion="4 Años";}
            elseif($list['CourseGradeId']==13){$seccion="5 Años";}
            elseif($list['CourseGradeId']==14){$seccion="1 Primaria";}
            elseif($list['CourseGradeId']==15){$seccion="1 Año";}
            elseif($list['CourseGradeId']==16){$seccion="2 Años";}

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            
            $sheet->setCellValue("A{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("C{$contador}", $list['Nombre']);
            $sheet->setCellValue("D{$contador}", $list['Codigo']);
            $sheet->setCellValue("E{$contador}", $list['Grado']);
            $sheet->setCellValue("F{$contador}", $seccion);
            $sheet->setCellValue("G{$contador}", $list['Seccion']);
            $sheet->setCellValue("H{$contador}", $list['Alumno']);
            $sheet->setCellValue("I{$contador}", $list['Anio']);
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'Matriculas Pendientes (Lista)';
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();
    
            $this->load->view('view_LS/retirados/index', $dato);
        }else{
            redirect('');
        }
    }

    public function Lista_Retirados(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_retirados'] = $this->Model_LeadershipSchool->get_list_retirados();
            $this->load->view('view_LS/retirados/lista', $dato);
        }else{
            redirect('');
        }
    }

    public function Excel_Retirados(){
        $list_retirados = $this->Model_LeadershipSchool->get_list_retirados($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:T1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:T1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Retirados');

        $sheet->setAutoFilter('A1:T1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(60);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(60);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(22);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(40);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(60);
        $sheet->getColumnDimension('S')->setWidth(60);
        $sheet->getColumnDimension('T')->setWidth(34);

        $sheet->getStyle('A1:T1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:T1")->getFill()
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

        $sheet->getStyle("A1:T1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Apellido Paterno');             
        $sheet->setCellValue("B1", 'Apellido Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Codigo');
        $sheet->setCellValue("E1", '¿Desde cuando no asiste?');
        $sheet->setCellValue("F1", 'Motivo Arpay');
        $sheet->setCellValue("G1", 'Observaciones Arpay');
        $sheet->setCellValue("H1", 'Motivo Snappy'); 
        $sheet->setCellValue("I1", '¿Cual sería?'); 
        $sheet->setCellValue("J1", '¿FUT de retiro?');
        $sheet->setCellValue("K1", 'Recibo');
        $sheet->setCellValue("L1", 'Fecha');
        $sheet->setCellValue("M1", '¿Pago Pendientes?');
        $sheet->setCellValue("N1", 'Valor');
        $sheet->setCellValue("O1", '¿Alumno contactado telefonicamente?');
        $sheet->setCellValue("P1", 'Fecha');
        $sheet->setCellValue("Q1", 'Hora');
        $sheet->setCellValue("R1", 'Resumen de contacto');
        $sheet->setCellValue("S1", 'Observación de Retiro');
        $sheet->setCellValue("T1", 'Posibilidad de reincorporación'); 

        $contador=1;

        foreach($list_retirados as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("R{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:T{$contador}")->applyFromArray($styleThinBlackBorderOutline); 
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

            $sheet->setCellValue("F{$contador}", $list['Motivo_Arpay']);
            $sheet->setCellValue("G{$contador}", $list['Observaciones_Arpay']);
            $sheet->setCellValue("H{$contador}", $list['nom_motivo']);
            $sheet->setCellValue("I{$contador}", $list['otro_motivo']);
            $sheet->setCellValue("J{$contador}", $list['fut']);
            $sheet->setCellValue("K{$contador}", $list['tkt_boleta']);

            if($list['fecha_fut']!=""){
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fecha_fut']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("L{$contador}", "");  
            }

            $sheet->setCellValue("M{$contador}", $list['pago_pendiente']);    
            $sheet->setCellValue("N{$contador}", $list['monto']);
            $sheet->setCellValue("O{$contador}", $list['contacto']);    
            $sheet->setCellValue("P{$contador}", $list['fecha_contacto']);
            $sheet->setCellValue("Q{$contador}", $list['hora_contacto']);    
            $sheet->setCellValue("R{$contador}", $list['resumen']);
            $sheet->setCellValue("S{$contador}", $list['obs_retiro']);    
            $sheet->setCellValue("T{$contador}", $list['reincorporacion']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Retirados (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');  
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/colaborador/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador(){
        if($this->session->userdata('usuario')){
            $tipo = $this->input->post("tipo");
            $dato['list_colaborador'] = $this->Model_LeadershipSchool->get_list_colaborador($tipo);
            $this->load->view('view_LS/colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Colaborador(){
        if($this->session->userdata('usuario')){
            $dato['list_departamento'] = $this->Model_LeadershipSchool->get_list_departamento();
            $dato['list_perfil'] = $this->Model_LeadershipSchool->get_list_perfil();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/colaborador/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Provincia_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['list_provincia'] = $this->Model_LeadershipSchool->get_list_provincia($id_departamento);
            $this->load->view('view_LS/colaborador/provincia',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Distrito_Colaborador(){
        if ($this->session->userdata('usuario')) {
            $id_provincia = $this->input->post("id_provincia");
            $dato['list_distrito'] = $this->Model_LeadershipSchool->get_list_distrito($id_provincia);
            $this->load->view('view_LS/colaborador/distrito',$dato);   
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
                $cantidad = (count($this->Model_LeadershipSchool->get_cantidad_colaborador()))+1;
    
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
    
            $this->Model_LeadershipSchool->insert_colaborador($dato);
        }else{
            $valida = $this->Model_LeadershipSchool->valida_insert_usuario_colaborador($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                if($_FILES["foto"]["name"] != ""){
                    $cantidad = (count($this->Model_LeadershipSchool->get_cantidad_colaborador()))+1;
        
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
        
                $this->Model_LeadershipSchool->insert_colaborador($dato);
                $ultimo = $this->Model_LeadershipSchool->ultimo_id_colaborador();
                $dato['id_externo'] = $ultimo[0]['id_colaborador'];
                $this->Model_LeadershipSchool->insert_usuario_colaborador($dato);
            }
        }
    }

    public function Editar_Colaborador($id_colaborador){
        if($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_colaborador($id_colaborador);
            $dato['list_perfil'] = $this->Model_LeadershipSchool->get_list_perfil();
            $dato['list_departamento'] = $this->Model_LeadershipSchool->get_list_departamento();
            $dato['list_provincia'] = $this->Model_LeadershipSchool->get_list_provincia($dato['get_id'][0]['id_departamento']);
            $dato['list_distrito'] = $this->Model_LeadershipSchool->get_list_distrito($dato['get_id'][0]['id_provincia']);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/colaborador/editar', $dato);
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

            $this->Model_LeadershipSchool->update_colaborador($dato);
        }else{
            $valida = $this->Model_LeadershipSchool->valida_update_usuario_colaborador($dato);

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
 
                $this->Model_LeadershipSchool->update_colaborador($dato);
                $dato['id_externo'] = $dato['id_colaborador'];

                $valida = $this->Model_LeadershipSchool->valida_insert_users_colaborador($dato);

                if(count($valida)>0){
                    $this->Model_LeadershipSchool->update_usuario_colaborador($dato);
                }else{
                    $this->Model_LeadershipSchool->insert_usuario_colaborador($dato);
                }
            }
        }
    }

    public function Descargar_Foto_Colaborador($id_colaborador) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_id_colaborador($id_colaborador);
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
        $this->Model_LeadershipSchool->delete_colaborador($dato);
    }

    public function Excel_Colaborador($tipo){ 
        $list_colaborador = $this->Model_LeadershipSchool->get_list_colaborador($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:AA1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:AA1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Colaboradores');

        $sheet->setAutoFilter('A1:AA1');

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
        $sheet->getColumnDimension('AA')->setWidth(30);

        $sheet->getStyle('A1:AA1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:AA1")->getFill()
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

        $sheet->getStyle("A1:AA1")->applyFromArray($styleThinBlackBorderOutline);

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
        $sheet->setCellValue("AA1", 'Comentario');

        $contador=1;
        
        foreach($list_colaborador as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:AA{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AA{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:AA{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:AA{$contador}")->applyFromArray($styleThinBlackBorderOutline);

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
            $sheet->setCellValue("AA{$contador}", $list['comentariog']);
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
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_colaborador($id_colaborador);
            $dato['list_tipo_obs'] = $this->Model_LeadershipSchool->get_list_tipo_obs(2);
            $dato['list_usuario'] = $this->Model_LeadershipSchool->get_list_usuario_obs();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/colaborador/detalle', $dato);
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

        $this->Model_LeadershipSchool->update_cv_colaborador($dato);
    }

    public function Lista_Contrato_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_contrato'] = $this->Model_LeadershipSchool->get_list_contrato_colaborador($id_colaborador);
            $this->load->view('view_LS/colaborador/lista_contrato', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Contrato_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_LS/colaborador/modal_registrar_contrato',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Contrato_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['nom_contrato'] = $this->input->post("nom_contrato_i");
        $dato['fecha'] = $this->input->post("fecha_i");
        $dato['archivo'] = "";

        $valida = $this->Model_LeadershipSchool->valida_insert_contrato_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            if($_FILES["archivo_i"]["name"] != ""){
                $cantidad = (count($this->Model_LeadershipSchool->get_cantidad_contrato_colaborador()))+1;
    
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

            $this->Model_LeadershipSchool->insert_contrato_colaborador($dato);
        }
    }

    public function Modal_Update_Contrato_Colaborador($id_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_contrato_colaborador($id_contrato);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/colaborador/modal_editar_contrato', $dato);
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

        $valida = $this->Model_LeadershipSchool->valida_update_contrato_colaborador($dato);

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

            $this->Model_LeadershipSchool->update_contrato_colaborador($dato);
        }
    }

    public function Descargar_Contrato_Colaborador($id_contrato) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_id_contrato_colaborador($id_contrato);
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
        $this->Model_LeadershipSchool->delete_contrato_colaborador($dato);
    }

    public function Lista_Pago_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_pago'] = $this->Model_LeadershipSchool->get_list_pago_colaborador($id_colaborador);
            $this->load->view('view_LS/colaborador/lista_pago', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Pago_Colaborador($id_colaborador){
        if ($this->session->userdata('usuario')){
            $dato['id_colaborador'] = $id_colaborador;
            $this->load->view('view_LS/colaborador/modal_registrar_pago',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Pago_Colaborador(){
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_banco'] = $this->input->post("id_banco_i");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_i");

        $valida = $this->Model_LeadershipSchool->valida_insert_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_LeadershipSchool->insert_pago_colaborador($dato);
        }
    }

    public function Modal_Update_Pago_Colaborador($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_pago_colaborador($id_pago);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/colaborador/modal_editar_pago', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $dato['id_banco'] = $this->input->post("id_banco_u");
        $dato['cuenta_bancaria'] = $this->input->post("cuenta_bancaria_u");
        $dato['estado'] = $this->input->post("estado_u"); 

        $valida = $this->Model_LeadershipSchool->valida_update_pago_colaborador($dato);

        if (count($valida)>0) {
            echo "error";
        }else{
            $this->Model_LeadershipSchool->update_pago_colaborador($dato);
        }
    }

    public function Delete_Pago_Colaborador(){
        $dato['id_pago'] = $this->input->post("id_pago");
        $this->Model_LeadershipSchool->delete_pago_colaborador($dato);
    }

    public function Lista_Asistencia_Colaborador(){
        if($this->session->userdata('usuario')){
            $id_colaborador = $this->input->post("id_colaborador");
            $dato['list_asistencia'] = $this->Model_LeadershipSchool->get_list_asistencia_colaborador($id_colaborador);
            $this->load->view('view_LS/colaborador/lista_asistencia', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Ingresos_Colaborador($id_colaborador){
        $list_asistencia = $this->Model_LeadershipSchool->get_list_asistencia_colaborador($id_colaborador);

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
            $dato['list_observacion']=$this->Model_LeadershipSchool->get_list_observacion_colaborador($id_colaborador);
            $this->load->view('view_LS/colaborador/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion_Colaborador() {
        $dato['id_colaborador'] = $this->input->post("id_colaborador");
        $dato['id_tipo'] = $this->input->post("id_tipo_o");
        $id_tipo = $this->input->post("id_tipo_o");
        $dato['fecha'] = $this->input->post("fecha_o");
        $dato['usuario'] = $this->input->post("usuario_o");
        $dato['observacion'] = $this->input->post("observacion_o");
        $dato['comentariog'] = $this->input->post("comentariog_o");
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
        else{
            $dato['observacion_archivo'] = "";
        }

        if($id_tipo!=0){
            $valida = $this->Model_LeadershipSchool->valida_insert_observacion_colaborador($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_LeadershipSchool->insert_observacion_colaborador($dato);
            }
        }

        $this->Model_LeadershipSchool->update_comentario_colaborador($dato);
    }

    public function Delete_Observacion_Colaborador() {
        $dato['id_observacion'] = $this->input->post("id_observacion");
        $dato['get_id'] = $this->Model_LeadershipSchool->get_id_obscimg($dato['id_observacion']);

        if (file_exists($dato['get_id'][0]['observacion_archivo'])) {
            unlink($dato['get_id'][0]['observacion_archivo']);
        }
        $this->Model_LeadershipSchool->delete_observacion_colaborador($dato);
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/colaborador_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Colaborador_Obs() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_colaborador_obs'] = $this->Model_LeadershipSchool->get_list_colaborador_obs();
            $this->load->view('view_LS/colaborador_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Colaborador_Obs(){
        $list_colaborador_obs = $this->Model_LeadershipSchool->get_list_colaborador_obs();

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
    //-----------------------------------CALENDARIO-------------------------------------
    public function Calendario() {  
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/calendario/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Calendario() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_festivo'] = $this->Model_LeadershipSchool->get_list_calendario($dato['tipo']);
            $this->load->view('view_LS/calendario/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Calendario(){
        if ($this->session->userdata('usuario')) { 
            $this->load->view('view_LS/calendario/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Calendario(){
        $dato['fecha']= $this->input->post("fecha_i");
        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['dias'] = $this->input->post("dias_i"); 
        $dato['motivo'] = $this->input->post("motivo_i");
        $this->Model_LeadershipSchool->insert_calendario($dato);
    }

    public function Modal_Update_Calendario($id_calendario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_calendario($id_calendario);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/calendario/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Calendario(){
        $dato['id_calendario']= $this->input->post("id_calendario");
        $dato['fecha']= $this->input->post("fecha_u");
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['dias'] = $this->input->post("dias_u"); 
        $dato['motivo'] = $this->input->post("motivo_u");
        $dato['estado'] = $this->input->post("estado_u");
        $this->Model_LeadershipSchool->update_calendario($dato);
    }

    public function Delete_Calendario(){
        $dato['id_calendario']= $this->input->post("id_calendario"); 
        $this->Model_LeadershipSchool->delete_calendario($dato);
    }

    public function Excel_Calendario($tipo){
        $list_calendario = $this->Model_LeadershipSchool->get_list_calendario($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Calendario');

        $sheet->setAutoFilter('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(60);
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
        
        $sheet->setCellValue("A1", 'Fecha');
        $sheet->setCellValue("B1", 'Descripción');	        
        $sheet->setCellValue("C1", 'Días Feriado');
        $sheet->setCellValue("D1", 'Motivo');
        $sheet->setCellValue("E1", 'Estado');   

        $contador=1;
        
        foreach($list_calendario as $list){ 
            $contador++;
            
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['descripcion']);
            $sheet->setCellValue("C{$contador}", $list['dias']);
            $sheet->setCellValue("D{$contador}", $list['motivo']);
            $sheet->setCellValue("E{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Calendario (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------------------------REGISTRO INGRESO----------------------------------
    public function Registro_Ingreso(){
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/registro_ingreso/index', $dato); 
        }else{
            redirect('/login');
        }
    }
    
    public function Lista_Asistencia_Registro_Ingreso(){
        if ($this->session->userdata('usuario')) {
            $fec_in = $this->input->post("fec_in");
            $fec_fi = $this->input->post("fec_fi");

            $dato['list_registro_ingreso'] = $this->Model_LeadershipSchool->get_list_registro_ingreso_p($fec_in,$fec_fi);
                        
            $this->load->view('view_LS/registro_ingreso/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Historial_Registro_Ingreso($id_registro_ingreso){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_historico_ingreso'] = $this->Model_LeadershipSchool->get_list_historial_registro_ingreso($id_registro_ingreso); 
            $this->load->view('view_LS/registro_ingreso/modal_historial', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Registro_Ingreso_Lista(){
        $dato['id_registro_ingreso']= $this->input->post("id_registro_ingreso");
        $this->Model_LeadershipSchool->delete_registro_ingreso_lista($dato);
    }

    public function Excel_Registro_Ingreso($fec_in,$fec_fi){     
        $fec_in = substr($fec_in,0,4)."-".substr($fec_in,4,2)."-".substr($fec_in,-2);
        $fec_fi = substr($fec_fi,0,4)."-".substr($fec_fi,4,2)."-".substr($fec_fi,-2);

        //$list_registro_ingreso = $this->Model_LeadershipSchool->excel_registro_ingreso($fec_in,$fec_fi);
        $list_registro_ingreso = $this->Model_LeadershipSchool->get_list_registro_ingreso_p($fec_in,$fec_fi);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Registro Ingreso');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Fecha');             
        $sheet->setCellValue("B1", 'Hora');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Apellido Paterno'); 
        $sheet->setCellValue("E1", 'Apellido Materno'); 
        $sheet->setCellValue("F1", 'Nombre(s)'); 
        $sheet->setCellValue("G1", 'Observaciones'); 
        $sheet->setCellValue("H1", 'Tipo'); 
        $sheet->setCellValue("I1", 'Estado');
        $sheet->setCellValue("J1", 'Autorización');
        $sheet->setCellValue("K1", 'Registro');
        $sheet->setCellValue("L1", 'Usuario');
        $sheet->setCellValue("M1", 'Registro');
        $sheet->setCellValue("N1", 'Usuario');
        $sheet->setCellValue("O1", 'Hora Salida');

        $contador=1;
        
        foreach($list_registro_ingreso as $list){  
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha_ingreso']));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list['hora_ingreso']);
            $sheet->setCellValue("C{$contador}", $list['codigo']);
            $sheet->setCellValue("D{$contador}", $list['apater']);
            $sheet->setCellValue("E{$contador}", $list['amater']);
            $sheet->setCellValue("F{$contador}", $list['nombre']);
            $sheet->setCellValue("G{$contador}", $list['obs']);
            $sheet->setCellValue("H{$contador}", $list['tipo_desc']);
            $sheet->setCellValue("I{$contador}", $list['nom_estado_reporte']);
            $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("K{$contador}", $list['estado_ing']);
            $sheet->setCellValue("L{$contador}", $list['nom_tipo_acceso']);
            $sheet->setCellValue("M{$contador}", $list['reg_automatico']);
            $sheet->setCellValue("N{$contador}", $list['usuario_registro']);
            $sheet->setCellValue("O{$contador}", $list['hora_salida']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Registro Ingreso (Lista)';
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/asistencia_colaborador/index', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Asistencia_Colaborador_Lista(){
        if ($this->session->userdata('usuario')) {
            $fec_in = $this->input->post("fec_in");
            $fec_fi = $this->input->post("fec_fi");
            $dato['list_registro_ingreso'] = $this->Model_LeadershipSchool->get_list_registro_ingreso_c($fec_in,$fec_fi);           
            $this->load->view('view_LS/asistencia_colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Asistencia_Colaborador($fec_in,$fec_fi){     
        $fec_in = substr($fec_in,0,4)."-".substr($fec_in,4,2)."-".substr($fec_in,-2);
        $fec_fi = substr($fec_fi,0,4)."-".substr($fec_fi,4,2)."-".substr($fec_fi,-2);

        $list_registro_ingreso = $this->Model_LeadershipSchool->get_list_registro_ingreso_c($fec_in,$fec_fi);

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

    
    //---------------------------------------SALÓN-----------------------------------------
    public function Salon() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_salon'] = $this->Model_LeadershipSchool->get_list_salon();

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
       $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

        $this->load->view('view_LS/salon/index',$dato);
    }

    public function Registrar_Salon(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_salon'] = $this->Model_LeadershipSchool->get_list_tipo_salon();
            $dato['list_especialidad'] = $this->Model_LeadershipSchool->get_list_especialidad_combo();

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/salon/registrar', $dato);   
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

        $total=count($this->Model_LeadershipSchool->valida_insert_salon($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_LeadershipSchool->insert_salon($dato);
        }
    }

    public function Editar_Salon($id_salon){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_salon($id_salon);
            $dato['list_tipo_salon'] = $this->Model_LeadershipSchool->get_list_tipo_salon();
            $dato['list_especialidad'] = $this->Model_LeadershipSchool->get_list_especialidad_combo();

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
           $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/salon/editar', $dato);   
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

        $total=count($this->Model_LeadershipSchool->valida_update_salon($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_LeadershipSchool->update_salon($dato);
        }
    }

    public function Delete_Salon(){
        $dato['id_salon']= $this->input->post("id_salon");
        $this->Model_LeadershipSchool->delete_salon($dato);
    }

    public function Excel_Salon(){
        $list_salon = $this->Model_LeadershipSchool->get_list_salon();

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
        $filename = 'Salones LS (Lista)';
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/mailing/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['list_mailing'] = $this->Model_LeadershipSchool->get_list_mailing();
            $this->load->view('view_LS/mailing/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mailing(){
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_LeadershipSchool->get_list_alumno_mailing();
            $dato['list_grado'] = $this->Model_LeadershipSchool->get_list_grado_mailing();
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $this->load->view('view_LS/mailing/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Seccion_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['nom_grado'] = $this->input->post("grado");
            $dato['list_seccion'] = $this->Model_LeadershipSchool->get_list_seccion_mailing($dato['nom_grado']);
            $this->load->view('view_LS/mailing/seccion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Mailing(){
        if ($this->session->userdata('usuario')) {
            $dato['codigo']= $this->input->post("codigo_i");
            $dato['grado']= $this->input->post("grado_i");
            $dato['seccion']= $this->input->post("seccion_i");
            $dato['dia_envio']= implode(",",$this->input->post("dia_envio_i"));
            $dato['titulo']= $this->input->post("titulo_i");
            $dato['texto']= $this->input->post("texto_i");
            $dato['documento']= ""; 
            $dato['estado_m']= $this->input->post("estado_m_i");

            $cantidad = $this->Model_LeadershipSchool->get_cantidad_mailing();
            $cantidad = $cantidad[0]['cantidad']+1; 

            /*if($_FILES["documento_i"]["name"] != ""){
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
            }*/

            $this->Model_LeadershipSchool->insert_mailing($dato);
            $ultimo = $this->Model_LeadershipSchool->ultimo_id_mailing();
            $dato['id_mailing'] = $ultimo[0]['id_mailing'];

            if($_FILES["documento_i"]["name"] != ''){
                $config['upload_path'] = './documento_mailing/'.$cantidad;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_mailing/', 0777);
                    chmod('./documento_mailing/'.$cantidad, 0777);
                }
                $config["allowed_types"] = 'pdf|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                for($count = 0; $count<count($_FILES["documento_i"]["name"]); $count++){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_i"]["name"][$count]);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_i"]["type"][$count];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_i"]["tmp_name"][$count];
                    $_FILES["file"]["error"] = $_FILES["documento_i"]["error"][$count];
                    $_FILES["file"]["size"] = $_FILES["documento_i"]["size"][$count];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = "documento_mailing/".$cantidad."/".$dato['nom_documento'];
                        $this->Model_LeadershipSchool->insert_documento_mailing($dato);
                    }
                }
            }

            if(!is_null($this->input->post("id_alumno_i"))){
                foreach($this->input->post("id_alumno_i") as $id_alumno){
                    $dato['id_alumno'] = $id_alumno;
                    $this->Model_LeadershipSchool->insert_envio_mailing($dato);
                }
            }
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Mailing($id_mailing){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_mailing($id_mailing);
            $dato['list_alumno'] = $this->Model_LeadershipSchool->get_list_alumno_mailing();
            $dato['list_envio'] = $this->Model_LeadershipSchool->get_list_envio_mailing($id_mailing);
            $dato['list_grado'] = $this->Model_LeadershipSchool->get_list_grado_mailing();
            $dato['list_seccion'] = $this->Model_LeadershipSchool->get_list_seccion_mailing($dato['get_id'][0]['grado']);
            $dato['list_estado'] = $this->Model_LeadershipSchool->get_list_status();
            $dato['list_documento'] = $this->Model_LeadershipSchool->get_list_documento_mailing(null,$id_mailing);
            $this->load->view('view_LS/mailing/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Mailing(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $dato['codigo']= $this->input->post("codigo_u");
            $dato['grado']= $this->input->post("grado_u");
            $dato['seccion']= $this->input->post("seccion_u");
            $dato['dia_envio']= implode(",",$this->input->post("dia_envio_u"));
            $dato['titulo']= $this->input->post("titulo_u");
            $dato['texto']= $this->input->post("texto_u");
            $dato['documento']= $this->input->post("documento_actual");
            $dato['estado_m']= $this->input->post("estado_m_u");

            /*if($_FILES["documento_u"]["name"] != ""){
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
            }*/
            if($_FILES["documento_u"]["name"] != ''){
                $config['upload_path'] = './documento_mailing/'.$dato['id_mailing'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_mailing/', 0777);
                    chmod('./documento_mailing/'.$dato['id_mailing'], 0777);
                }
                $config["allowed_types"] = 'pdf|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                for($count = 0; $count<count($_FILES["documento_u"]["name"]); $count++){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_u"]["name"][$count]);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_u"]["type"][$count];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_u"]["tmp_name"][$count];
                    $_FILES["file"]["error"] = $_FILES["documento_u"]["error"][$count];
                    $_FILES["file"]["size"] = $_FILES["documento_u"]["size"][$count];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = "documento_mailing/".$dato['id_mailing']."/".$dato['nom_documento'];
                        $this->Model_LeadershipSchool->insert_documento_mailing($dato);
                    }
                }
            }

            $this->Model_LeadershipSchool->update_mailing($dato);

            $this->Model_LeadershipSchool->delete_envio_mailing($dato);
            if(!is_null($this->input->post("id_alumno_u"))){
                foreach($this->input->post("id_alumno_u") as $id_alumno){
                    $dato['id_alumno'] = $id_alumno;
                    $this->Model_LeadershipSchool->insert_envio_mailing($dato);
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Actualizar_Lista_Mailing() {  
        if ($this->session->userdata('usuario')) {
            $list_mailing = $this->Model_LeadershipSchool->get_mailing_activos();

            foreach($list_mailing as $list){
                $dato['id_mailing'] = $list['id_mailing'];

                $list_alumno = $this->Model_LeadershipSchool->get_datos_alumno_mailing($dato['id_mailing']);

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
                        $mail->Username   = 'admision@leadershipschool.edu.pe';                     // usuario de acceso
                        $mail->Password   = $this->config->item('adm_ls');                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('noreply@snappy.org.pe', 'Leadership School'); //desde donde se envia
                        
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

                        $this->Model_LeadershipSchool->insert_detalle_mailing($dato);
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    } 
                }

                $this->Model_LeadershipSchool->update_enviado_mailing($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Descargar_Documento_Mailing($id) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_list_documento_mailing($id,null);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }else{
            redirect('');
        }
    }

    public function Delete_Documento_Mailing() {
        if ($this->session->userdata('usuario')) {
            $id = $this->input->post('image_id');
            $dato['get_file'] = $this->Model_LeadershipSchool->get_list_documento_mailing($id,null);

            if (file_exists($dato['get_file'][0]['documento'])) {
                unlink($dato['get_file'][0]['documento']);
            }
            $this->Model_LeadershipSchool->delete_documento_mailing($id);
        }else{
            redirect('');
        }
    }

    public function Delete_Mailing(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $this->Model_LeadershipSchool->delete_mailing($dato); 
        }else{
            redirect('');
        }
    }

    public function Excel_Mailing(){
        $list_mailing = $this->Model_LeadershipSchool->get_list_mailing();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mailing');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(80);
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
        $sheet->setCellValue("B1", 'Día Envío'); 
        $sheet->setCellValue("C1", 'Título');        
        $sheet->setCellValue("D1", 'Texto');                    
        $sheet->setCellValue("E1", 'Documento');          
        $sheet->setCellValue("F1", 'Estado');

        $contador=1;
        
        foreach($list_mailing as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo']); 
            $sheet->setCellValue("B{$contador}", $list['dia_envio']);
            $sheet->setCellValue("C{$contador}", $list['titulo']);
            $sheet->setCellValue("D{$contador}", $list['texto']);
            $sheet->setCellValue("E{$contador}", $list['v_documento']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
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
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_mailing($id_mailing);

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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/mailing/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Mailing() {
        if ($this->session->userdata('usuario')) {
            $dato['id_mailing']= $this->input->post("id_mailing");
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_detalle'] = $this->Model_LeadershipSchool->get_list_detalle_mailing($dato['id_mailing'],$dato['tipo']);
            $this->load->view('view_LS/mailing/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Mailing($id_mailing,$tipo){
        $list_detalle = $this->Model_LeadershipSchool->get_list_detalle_mailing($id_mailing,$tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $spreadsheet->getActiveSheet()->setTitle('Detalle Mailing');

        if($tipo==1){
            $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $sheet->setAutoFilter('A1:D1');
    
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(30); 
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
              
            $sheet->setCellValue("A1", 'Apellido Paterno');
            $sheet->setCellValue("B1", 'Apellido Materno');     
            $sheet->setCellValue("C1", 'Nombre(s)');    
            $sheet->setCellValue("D1", 'Código');                 
    
            $contador=1;
            
            foreach($list_detalle as $list){
                $contador++;
    
                $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);
    
                $sheet->setCellValue("A{$contador}", $list['Apellido_Paterno']);
                $sheet->setCellValue("B{$contador}", $list['Apellido_Materno']);
                $sheet->setCellValue("C{$contador}", $list['Nombre']);
                $sheet->setCellValue("D{$contador}", $list['Codigo']);
            }
        }else{
            $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
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
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Detalle Mailing (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Descargar_ArchivoOA($id_comuimg) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_id_obsaimg($id_comuimg);
            $image = $dato['get_file'][0]['observacion_archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['observacion_archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Descargar_ArchivoOC($id_comuimg) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_LeadershipSchool->get_id_obscimg($id_comuimg);
            $image = $dato['get_file'][0]['observacion_archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['observacion_archivo']));
        }
        else{
            redirect('');
        }
    }

    //---------------------------------------------INGRESOS ALUMNO-------------------------------------------

    public function Lista_Ingreso_Matriculados() { 
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['modulo'] = $this->input->post("modulo");
            $dato['list_registro_ingreso'] = $this->Model_LeadershipSchool->get_list_registro_ingreso_matriculados_modulo($dato);
           // $dato['list_registro_ingreso'] = $this->Model_LeadershipSchool->get_list_registro_ingreso_matriculados($dato['id_alumno']);

            $this->load->view('view_LS/matriculados/lista_ingreso',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Modulo($id_alumno,$modulo){
        setlocale(LC_TIME, 'spanish');
        $dato['id_alumno'] = $id_alumno;
        $dato['modulo'] = $modulo;
        var_dump($dato['modulo']);
        $list_registro_ingreso = $this->Model_LeadershipSchool->get_list_registro_ingreso_matriculados_modulo($dato);
        $list_modulo=$this->Model_LeadershipSchool->get_ingresos_modulo($id_alumno);
        $spreadsheet = new Spreadsheet();
        //$sheet = $spreadsheet->getActiveSheet();

        

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $i = 0;
        foreach ($list_modulo as $m) {
            $dato['modulo']=$m['modulo'];
            // Crear una nueva hoja para cada elemento en $list_modulo
            if ($i > 0) {
                $spreadsheet->createSheet();
            }
            $sheet = $spreadsheet->setActiveSheetIndex($i);
            //$sheet->setTitle('M' . ($i + 1));
            $sheet->setTitle($dato['modulo']);
            $list_registro_ingreso = $this->Model_LeadershipSchool->get_list_registro_ingreso_matriculados_modulo($dato);
            $sheet->getStyle('A1:H1')->getFont()->setBold(true);
            $sheet->setAutoFilter('A1:H1');

            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(40);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);

            $sheet->setCellValue("A1", 'Dia');
            $sheet->setCellValue("B1", 'Fecha');
            $sheet->setCellValue("C1", 'Hora');
            $sheet->setCellValue("D1", 'Obs');
            $sheet->setCellValue("E1", 'Tipo');
            $sheet->setCellValue("F1", 'Estado');
            $sheet->setCellValue("G1", 'Autorización');
            $sheet->setCellValue("H1", 'Registro');
            $sheet->getStyle("A1:H1")->applyFromArray($styleThinBlackBorderOutline);
            $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C8C8C8');
            $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $contador=1;
            
            foreach($list_registro_ingreso as $list){
                $contador++;

                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $list['fecha_ingreso'])));
                $nombreDia = utf8_encode(strftime('%A', strtotime($fecha)));
                $sheet->setCellValue("A{$contador}", $nombreDia);
                $sheet->setCellValue("B{$contador}", $list['fecha_ingreso']);
                $sheet->setCellValue("C{$contador}", $list['hora_ingreso']);
                $sheet->setCellValue("D{$contador}", $list['obs']);
                $sheet->setCellValue("E{$contador}", $list['tipo_desc']);
                $sheet->setCellValue("F{$contador}", $list['nom_estado_reporte']);
                $sheet->setCellValue("G{$contador}", $list['usuario_codigo']);
                $sheet->setCellValue("H{$contador}", $list['estado_ing']);
            }

            $i++;
        }
        

     

        /*$sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Módulos');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
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

        $sheet->getStyle("A1:B1")->applyFromArray($styleThinBlackBorderOutline);
           
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
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['orden']);
            $sheet->setCellValue("B{$contador}", $list['fecha_ingreso']);
            $sheet->setCellValue("C{$contador}", $list['hora_ingreso']);
            $sheet->setCellValue("D{$contador}", $list['obs']);
            $sheet->setCellValue("E{$contador}", $list['tipo_desc']);
            $sheet->setCellValue("F{$contador}", $list['nom_estado_reporte']);
            $sheet->setCellValue("G{$contador}", $list['usuario_codigo']);
        }*/

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //---------------------------------------------C_BIMESTRES-------------------------------------------
    public function C_Bimestres() {
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
            $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();
            $this->load->view('view_LS/c_bimestres/index',$dato);
        }else{
            redirect('/login');
        }
    }
            
    //---------------------------------------------FOTOCHECK COLABORADOR-------------------------------------------
    public function Fotocheck_Colaborador(){
        if($this->session->userdata('usuario')){
            //$dato['contador_contactenos'] = $this->Model_BabyLeaders->get_list_contactenos(1);
            //$dato['cierres_caja_pendientes'] = count($this->Model_BabyLeaders->get_cierres_caja_pendientes());
            //$dato['cierres_caja_sin_cofre'] = count($this->Model_BabyLeaders->get_cierres_caja_sin_cofre());
            //$dato['cantidadnulos'] = $this->Model_IFV->get_list_matriculadosnulosst(1);
            //$dato['contador_renovar'] = $this->Model_BabyLeaders->get_busqueda_centro_contadores(1);
            //$dato['contador_caducado'] = $this->Model_BabyLeaders->get_busqueda_centro_contadores(2);
            //$dato['cantidad_fotochecks'] = count($this->Model_BabyLeaders->get_list_fotocheck(1));
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
             $dato['list_nav_sede'] = $this->Model_LeadershipSchool->get_list_nav_sede();

            $this->load->view('view_LS/fotocheck_colaborador/index',$dato);
        }
    }

    public function Lista_Fotocheck_Alumnos_Ls() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_fotocheck'] = $this->Model_LeadershipSchool->get_list_fotocheck($dato['tipo']);
            $this->load->view('view_LS/fotocheck_colaborador/lista',$dato);
        }else{
            redirect('');
        }
    }
    public function Modal_Foto($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_LS/fotocheck_colaborador/modal_foto', $dato);
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
                $get_doc = $this->Model_LeadershipSchool->get_cod_documento_colaborador('D01');
                if (file_exists($dato['foto_fotocheck_2'])) {
                    unlink($dato['foto_fotocheck_2']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_2"]["name"]);
                $config['upload_path'] = './documento_colaborador_ls/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_ls/', 0777);
                    chmod('./documento_colaborador_ls/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_ls/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_2'] = "documento_colaborador_ls/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 2;
                $this->Model_LeadershipSchool->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_LeadershipSchool->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck_2'];
                $this->Model_LeadershipSchool->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck"]["name"] != ""){
                $get_doc = $this->Model_LeadershipSchool->get_cod_documento_colaborador('D00');
                if (file_exists($dato['foto_fotocheck'])) {
                    unlink($dato['foto_fotocheck']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck"]["name"]);
                $config['upload_path'] = './documento_colaborador_ls/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_ls/', 0777);
                    chmod('./documento_colaborador_ls/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_ls/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck'] = "documento_colaborador_ls/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 1;
                $this->Model_LeadershipSchool->update_foto_fotocheck($dato);
                $get_detalle = $this->Model_LeadershipSchool->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck'];
                $this->Model_LeadershipSchool->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck_3"]["name"] != ""){
                if (file_exists($dato['foto_fotocheck_3'])) {
                    unlink($dato['foto_fotocheck_3']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_3"]["name"]);
                $config['upload_path'] = './documento_colaborador_ls/0/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_ls/', 0777);
                    chmod('./documento_colaborador_ls/0', 0777);
                    chmod('./documento_colaborador_ls/0/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_3'] = "documento_colaborador_ls/0/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 3;
                $this->Model_LeadershipSchool->update_foto_fotocheck($dato);
            }

            $valida = $this->Model_LeadershipSchool->valida_fotocheck_completo($dato['id_fotocheck']);

            if(count($valida)==0){
                $this->Model_LeadershipSchool->update_fotocheck_completo($dato);
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
    public function Modal_Detalle($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_LS/fotocheck_colaborador/modal_detalle', $dato);
        }else{
            redirect('');
        }
    }
    public function Carne_Colaborador($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_fotocheck($id_fotocheck);
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
            $html = $this->load->view('view_LS/fotocheck_colaborador/carnet',$dato,true);
            //$mpdf->SetHTMLHeader("Content-Disposition: inline");
            $mpdf->WriteHTML($html);
            $mpdf->Output($dato['get_id'][0]['Id'].".pdf","I");
        }else{
            redirect('');
        }
    }
    public function Impresion_Fotocheck(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck']= $this->input->post("id_fotocheck");
            $this->Model_LeadershipSchool->impresion_fotocheck($dato);
        }else{
            redirect('');
        }
    }
            
    public function Modal_Anular($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_id_fotocheck($id_fotocheck);
            $this->load->view('view_LS/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('');
        }
    }
    public function Anular_Envio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['obs_anulado'] = $this->input->post("obs_anulado");
            $this->Model_LeadershipSchool->anular_envio($dato);
        } else {
            redirect('/login');
        }
    }
    public function Modal_Envio(){
        if ($this->session->userdata('usuario')) {
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

            $dato['get_id_user'] = $this->Model_LeadershipSchool->get_id_user();
            $dato['list_cargo_sesion'] = $this->Model_LeadershipSchool->get_cargo_x_id($id_usuario);
            $this->load->view('view_LS/fotocheck_colaborador/modal_envio', $dato);
        }else{
            redirect('');
        }
    }
    public function Traer_Cargo(){
        if ($this->session->userdata('usuario')) {
            $id_usuario_de = $this->input->post("usuario_encomienda");
            $dato['list_cargo'] = $this->Model_LeadershipSchool->get_cargo_x_id($id_usuario_de);
            $dato['id_cargo'] = "cargo_envio_f";
            $this->load->view('view_LS/fotocheck_colaborador/cargo',$dato);
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

                    $alumno = $this->Model_LeadershipSchool->get_id_fotocheck($dato['id_fotocheck']);

                    if(count($alumno)>0){
                        if ($alumno[0]['esta_fotocheck']=='Foto Rec'){
                            $this->Model_LeadershipSchool->update_envio_fotocheck($dato);
                        }
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_C_Bimestres() {
        if ($this->session->userdata('usuario')) {
            $dato['list_c_bimestre'] = $this->Model_LeadershipSchool->get_list_c_bimestres();
            $this->load->view('view_LS/c_bimestres/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_C_Bimestres(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_LS/c_bimestres/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_C_Bimestres(){
        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['fecha_inicio']= $this->input->post("fecha_inicio_i");
        $dato['fecha_fin']= $this->input->post("fecha_fin_i");

        $this->Model_LeadershipSchool->insert_c_bimestres($dato);
    }

    public function Modal_Update_C_Bimestres($id_bimestre){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_LeadershipSchool->get_list_c_bimestres($id_bimestre);
            $this->load->view('view_LS/c_bimestres/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_C_Bimestres(){ 
        $dato['id_bimestre']= $this->input->post("id_bimestre"); 
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['fecha_inicio']= $this->input->post("fecha_inicio_u");
        $dato['fecha_fin']= $this->input->post("fecha_fin_u");


        $this->Model_LeadershipSchool->update_c_bimestres($dato); 
    }

    public function Delete_C_Bimestres(){ 
        $dato['id_bimestre']= $this->input->post("id_bimestre");
        $this->Model_LeadershipSchool->delete_c_bimestres($dato); 
    }
}