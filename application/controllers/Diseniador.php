<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
class Diseniador extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('N_diseniador');
        $this->load->model('Admin_model');
        $this->load->model('Model_snappy');
        $this->load->model('Model_General');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
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
            //$data['anio'] = $this->Papeletas_Detalle->get_anio();
            /*$data['anios'] = $this->Papeletas_Detalle->get_anio();
            $data['dependecia'] = $this->Papeletas_Detalle->get_dependencia();
            $data['firmadigital'] = $this->Papeletas_Detalle->firma_digital();
            $data['origen_horas'] = $this->Papeletas_Detalle->origen_horas();

            $coddep= $_SESSION['usuario'][0]['CODI_DEPE_TDE'];
            $data['caso'] = $this->Papeletas_Detalle->get_caso($coddep);
            $des_caso=$this->Papeletas_Detalle->get_caso($coddep);
            $data['nivel'] = $this->Papeletas_Detalle->get_nivel($des_caso);
*/
            //$this->load->view('Reportes/Papeletas_Detalle_Per',$data);
            $this->load->view('administrador/index');
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function proyectos(){// RRHH {
        if ($this->session->userdata('usuario')) { 
            $id_usuario=$_SESSION['usuario'][0]['id_usuario']; 
            //var_dump($id_usuario);
            //$dato['row_st'] =$this->N_diseniador->get_row_solicitadot($id_usuario);
            $dato['row_s'] =$this->N_diseniador->get_row_solicitado($id_usuario);
            //$dato['row_at'] = $this->N_diseniador->get_row_asignadot($id_usuario);
            $dato['row_a'] = $this->N_diseniador->get_row_asignado($id_usuario);
            //$dato['row_ett'] = $this->N_diseniador->get_row_entramitet($id_usuario);
            $dato['row_et'] = $this->N_diseniador->get_row_entramite($id_usuario);
            //$dato['row_prt'] =$this->N_diseniador->get_row_pendientet($id_usuario);
            $dato['row_pr'] =$this->N_diseniador->get_row_pendiente($id_usuario);
            $dato['row_tp2'] =$this->Admin_model->get_row_tp2();
            $dato['row_tp'] = $this->N_diseniador->get_row_tp($id_usuario);

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

            $this->load->view('diseniador/proyecto/index_proyecto',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Busqueda(){
        $id_estatus= $this->input->post('status');
        //  var_dump($id_estatus);
        $id_usuario=$_SESSION['usuario'][0]['id_usuario']; 
        
        $data['status']= $this->input->post('status');
        $data['list_empresa'] =$this->Admin_model->list_empresa_proyecto();
        $data['list_sede'] =$this->Admin_model->list_sede_proyecto();

        $data['diseniador_busq'] =$this->N_diseniador->get_detalle_busqueda($id_estatus,$id_usuario);

        $this->load->view('diseniador/proyecto/busqueda', $data);
    }
    

    public function Editar_proyecto($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['row_t'] =$this->Admin_model->get_row_t();
            $dato['sub_tipo'] = $this->Admin_model->edit_sub_tipo();
            $dato['row_s'] = $this->Admin_model->get_row_s();
            $dato['usuario_subtipo'] = $this->Admin_model->get_usuario_subtipo();
            $dato['usuario_subtipo1'] = $this->Admin_model->get_usuario_subtipo1();

            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
            
            $dato['empresas']=$dato['get_id'][0]['id_empresa'];

            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);

            $dato['get_sede'] = $this->Admin_model->get_id_sede_proyecto($id_proyecto);

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

            $this->load->view('diseniador/proyecto/editar_proyecto',$dato);
        }else{
            redirect('/login');
        }
    }

    public function subtipo($id_tipo="00") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->getsubtipo($id_tipo);
        echo json_encode($data); 
    }

    public function sub_tipo($id_tipo="00", $id_subtipo="00") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->get_sub_tipo($id_tipo,$id_subtipo);
        echo json_encode($data);
    }

    public function sub_redes($id_tipo="00", $id_subtipo="00"){
        header('Content-Type: application/json');
        $data = $this->Admin_model->get_sub_redes($id_tipo,$id_subtipo);
        echo json_encode($data);
    }
    
    public function update_proyecto_ds(){
        $dato['id_proyecto']= $this->input->post("id_proyecto");

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $dato['mes']=substr($this->input->post("fec_agenda"),5,2);
        $dato['dia']=substr($this->input->post("fec_agenda"),8,2);
        $dato['iniciosf'] = strtotime($dato['fec_agenda']);
        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
        //$dato['fec_termino']=$query_fechat;
        //$dato['cod_proyecto']= $query_pr;
        $dato['id_solicitante']= $this->input->post("id_solicitante");
        $dato['fec_solicitante']= $this->input->post("fec_solicitante");
        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['id_subtipo']= $this->input->post("id_subtipo");
        $dato['s_artes']= $this->input->post("s_artes");
        $dato['s_redes']= $this->input->post("s_redes");
        $dato['prioridad']= $this->input->post("prioridad");
        $dato['status']= $this->input->post("status");
        $dato['descripcion']= $this->input->post("descripcion");
        $dato['id_asignado']= $this->input->post("id_asignado");
        $dato['id_userpr']= $this->input->post("id_userpr");
        $dato['imagen']= "";
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $dato['proy_obs']= strtoupper($this->input->post("proy_obs"));

        if($_FILES["foto"]["name"] != ""){
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
            $config['upload_path'] = './archivo/'.$dato['id_proyecto'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./archivo/', 0777);
                chmod('./archivo/'.$dato['id_proyecto'], 0777);
            }
            $config["allowed_types"] = 'png|PNG|jpg|JPG|jpeg|JPEG|gif|GIF|pdf|PDF';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $_FILES["file"]["name"] =  $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["foto"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["foto"]["error"];
            $_FILES["file"]["size"] = $_FILES["foto"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['imagen'] = "archivo/".$dato['id_proyecto']."/".$dato['nom_documento'];
            }     
        }

        $this->N_diseniador->update_proyecto_ds($dato);
    }

    public function Excel_Proyectos($id_status){
        $id_usuario=$_SESSION['usuario'][0]['id_usuario'];
        $proyectos = $this->N_diseniador->get_detalle_busqueda($id_estatus,$id_usuario);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Lista de Proyectos');
        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(13);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(13);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(13);

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

        $sheet->setCellValue("A1", 'Prioridad');	        
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'Status');
        $sheet->setCellValue("D1", 'Empresa(s)');
        $sheet->setCellValue("E1", 'Sede(s)');	        
        $sheet->setCellValue("F1", 'Tipo');
        $sheet->setCellValue("G1", 'SubTipo');	        
        $sheet->setCellValue("H1", 'Descripción');
        $sheet->setCellValue("I1", 'Snappys');
        $sheet->setCellValue("J1", 'Agenda');	        
        $sheet->setCellValue("K1", 'Usuario');
        $sheet->setCellValue("L1", 'Fecha');
        $sheet->setCellValue("M1", 'Usuario');
        $sheet->setCellValue("N1", 'Fecha');

        $contador=1;

        foreach($proyectos as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['prioridad']);
            $sheet->setCellValue("B{$contador}", $list['cod_proyecto']);
            $sheet->setCellValue("C{$contador}", $list['nom_statusp']);
            $sheet->setCellValue("D{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("E{$contador}", $list['cod_sede']);
            $sheet->setCellValue("F{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("G{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("H{$contador}", $list['descripcion']);
            $sheet->setCellValue("I{$contador}", ($list['s_artes']+$list['s_redes']));
            if ($list['fecha_agenda']!=''){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_agenda']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("K{$contador}", $list['ucodigo_solicitado']);
            if ($list['fecha_solicitante']!=''){ 
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fecha_solicitante']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            
            $sheet->setCellValue("M{$contador}", $list['ucodigo_asignado']);
            if ($list['fecha_termino']!=''){ 
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list['fecha_termino']));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
        }

		$writer = new Xlsx($spreadsheet);
		$filename = 'Proyectos (Lista)';
        if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}