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

class Teamleader extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('N_teamleader');
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

            $this->load->view('administrador/index');
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }


     public function proyectos(){// RRHH {
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
            $data['row_p'] =$this->Admin_model->get_row_p();

            //AVISO NO BORRAR
            $data['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $data['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $data['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $data['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $data['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $data['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('teamleader/proyecto/index_proyecto', $data);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
     public function subtipo($id_tipo="00") {
            header('Content-Type: application/json');
            $data = $this->N_teamleader->getsubtipo($id_tipo);
            echo json_encode($data); 
    }

    public function sub_tipo($id_tipo="00", $id_subtipo="00") {
        header('Content-Type: application/json');
        $data = $this->N_teamleader->get_sub_tipo($id_tipo,$id_subtipo);
        echo json_encode($data);
    }


     public function nuevo_proyTeam(){
        if ($this->session->userdata('usuario')) {
            $data['solicitado'] =$this->Admin_model->get_solicitado();
            $data['row_t'] =$this->Admin_model->get_row_t();
            $data['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $data['list_sede'] = $this->Model_General->get_list_sede_usuario();

            $this->load->view('teamleader/proyecto/nuevo_proyecto',$data);
        }
        else{
            redirect('/login');
        }
    }

    public function insert_proyecto() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $dato['mes']=substr($this->input->post("fec_agenda"),5,2);
        $dato['dia']=substr($this->input->post("fec_agenda"),8,2);
        $dato['iniciosf'] = strtotime($dato['fec_agenda']);

        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
    
        $anio=date('Y');
        $semana=date('W');
        $query_id = $this->Admin_model->ultimo_cod_proyecto($anio);
        $totalRows_t = count($query_id);

        $id_color = $this->Admin_model->get_colorestatus();
        // var_dump($id_color);
         //var_dump($totalRows_t);
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
        $dato['cod_proyecto']=$codigo;

        $dato['semana']=$semana;
        $dato['user_reg']=  $_SESSION['usuario'][0]['id_usuario']; 
       
        $dato['id_solicitante']= $this->input->post("id_solicitante");
        $dato['fec_solicitante']= $this->input->post("fec_solicitante");
        $dato['anio']= $anio;

        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['id_subtipo']= $this->input->post("id_subtipo");
        $dato['s_artes']= $this->input->post("s_artes");
        $dato['s_redes']= $this->input->post("s_redes");
        $dato['prioridad']= $this->input->post("prioridad");
        $dato['descripcion']= $this->input->post("descripcion");
        $dato['proy_obs']= $this->input->post("proy_obs");
        $dato['id_empresa']= $this->input->post("id_empresa");
        //color
        $dato['color']=$id_color;
        //$español=$this->Admin_model->fecha_español($dato['fec_agenda']);
        $this->Admin_model->insert_proyecto($dato);

        if($dato['id_tipo']!=15 && $dato['id_tipo']!=20 && $dato['id_tipo']!=34){ 
            $valida = $this->Admin_model->valida_una_sede($dato['id_empresa']);

            if(count($valida)==1){
                $dato['id_sede'] = $valida[0]['id_sede'];
                $this->Admin_model->insert_proyecto_sede($dato);
            }else{
                $sedes = $this->input->post("id_sede");
    
                if($sedes!=""){ 
                    foreach($_POST['id_sede'] as $id_sede){
                        $dato['id_sede']=$id_sede;
                        $this->Admin_model->insert_proyecto_sede($dato);
                    }
                }
            }
        }

        echo $codigo;
    }

    public function Editar_proyect($id_proyecto){ 
        if ($this->session->userdata('usuario')) { 
            // $id_proyecto= $this->input->post('id_proyecto');
            /*$dato['pagina'] = $pagina; 
                $dato['solicitado'] =$this->Admin_model->get_solicitado();
                $dato['row_t'] =$this->Admin_model->get_row_t();
                $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
                //$dato['sub_tipo'] = $this->Admin_model->edit_sub_tipo();
                $id_tipo=$dato['get_id'][0]['id_tipo'];
                if($id_tipo==15 || $id_tipo==34){
                    $dato['get_empresa'] = $this->Admin_model->get_id_empresa_proyecto($id_proyecto);
                    $id_empresa=$dato['get_empresa'][0]['id_empresa'];
                    $dato['sub_tipo'] = $this->Admin_model->getsubtipo_xempresa($id_tipo,$id_empresa);
                }else{
                    $dato['sub_tipo'] = $this->Admin_model->edit_sub_tipo();
                }
                $dato['row_s'] = $this->Admin_model->get_row_s();
                $dato['usuario_subtipo'] = $this->Admin_model->get_usuario_subtipo();
                $dato['usuario_subtipo1'] = $this->Admin_model->get_usuario_subtipo1();

                $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
                $dato['get_empresa'] = $this->Admin_model->get_id_empresa_proyecto($id_proyecto);

                $get_empresa = $this->Admin_model->get_id_empresa_proyecto($id_proyecto);

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

                $dato['get_sede'] = $this->Admin_model->get_id_sede_proyecto($id_proyecto);
                //$this->load->view('teamleader/informe/busqueda/editar_proyect',$dato);
                $this->load->view('teamleader/proyecto/editar_proyecto',$dato);
            */
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['row_t'] =$this->Admin_model->get_row_t();
            $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            
            $dato['id_tipo']=$dato['get_id'][0]['id_tipo'];
            
            

            $dato['row_s'] = $this->N_teamleader->get_row_s();
            $dato['usuario_subtipo'] = $this->Admin_model->get_usuario_subtipo();
            $dato['usuario_subtipo1'] = $this->Admin_model->get_usuario_subtipo1();

            $dato['list_empresab'] = $this->Model_General->get_list_empresa_usuario();
            

            $dato['empresas']=$dato['get_id'][0]['id_empresa'];
            $dato['sub_tipo'] = $this->Admin_model->list_subtipo_fbweb($dato);
            
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
            $this->load->view('teamleader/proyecto/editar_proyect_v',$dato);
        }else{
           redirect('/login');
        }
    }

    public function Update_Proyecto(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $dato['mes']=substr($this->input->post("fec_agenda"),5,2);
        $dato['dia']=substr($this->input->post("fec_agenda"),8,2);
        $dato['iniciosf'] = strtotime($dato['fec_agenda']);

        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
    
        $dato['id_proyecto']= $this->input->post("id_proyecto");

        $cod_proyecto = $this->N_teamleader->proyecto_cod($dato['id_proyecto']);
       // $totalRows_pr = count($cod_proyecto);
        //var_dump($cod_proyecto);
        $dato['cod_proyecto'] =$cod_proyecto;
        //$dato['cod_proyecto']= $query_pr;
        $dato['id_solicitante']= $this->input->post("id_solicitante");
        //$dato['fec_solicitante']= $this->input->post("fec_solicitante");
        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['id_subtipo']= $this->input->post("id_subtipo");
        $dato['s_artes']= $this->input->post("s_artes");
        $dato['s_redes']= $this->input->post("s_redes");
        $dato['prioridad']= $this->input->post("prioridad");
        $dato['status']= $this->input->post("status");
        $dato['descripcion']= $this->input->post("descripcion");
        $dato['id_asignado']= $this->input->post("id_asignado");
        $dato['id_userpr']= $this->input->post("id_userpr");
        $dato['imagen']= $this->input->post("foto");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $query_c = $this->Admin_model->get_color($dato['status']);
        $dato['proy_obs']= strtoupper($this->input->post("proy_obs"));
        $totalRows_c = count($query_c);
        $dato['color']=$query_c;
        // calendar ajendas  arter
        $query_ca = $this->N_teamleader->query_calendar($cod_proyecto);
        $dato['totalRows_ca']=count($query_ca);
        //var_dump($totalRows_ca);
        // calendar calendar_redes
        $query_cr = $this->N_teamleader->query_redes($cod_proyecto);
        $dato['totalRows_cr']=count($query_cr);

        $this->N_teamleader->update_proyecto($dato);

        $this->Admin_model->reiniciar_proyecto_empresa($dato);
        $this->Admin_model->reiniciar_proyecto_sede($dato);

        foreach($_POST['id_empresa'] as $id_empresa){
            $dato['id_empresa']=$id_empresa;

            $this->Admin_model->update_proyecto_empresa($dato);
        }
        
        $sedes = $this->input->post("id_sede");

        if($sedes!=""){
            foreach($_POST['id_sede'] as $id_sede){
                $dato['id_sede']=$id_sede;
    
                $this->Admin_model->update_proyecto_sede($dato);
            }
        }
    }

    public function Busqueda(){
        /*$id_estatus= $this->input->post('status');
        
        $data['row_p'] =$this->Admin_model->get_row_p($id_estatus);
        $data['list_empresa'] =$this->Admin_model->list_empresa_proyecto();
        $data['list_sede'] =$this->Admin_model->list_sede_proyecto();
        $this->load->view('administrador/proyecto/busqueda', $data);*/
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        //$id_estatus= $this->input->post('status');
        
        //$data['row_p'] =$this->Admin_model->get_row_p($id_estatus);
        $dato['anio']=date('Y');
        $dato['list_proyecto'] = $this->Model_snappy->get_list_proyecto_busqueda($dato);
        $dato['list_empresa'] =$this->Admin_model->list_empresa_proyecto();
        $dato['list_sede'] =$this->Admin_model->list_sede_proyecto();
        $dato['list_anio'] =$this->Admin_model->get_list_anio_proyecto();
        //$dato['list_empresa'] = $this->Model_snappy->get_list_empresa();

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
    
        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

        $this->load->view('teamleader/informe/busqueda/index',$dato);
    }

    public function Buscador_Anio() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $dato['anio']= $this->input->post("anio");
        $dato['list_proyecto'] = $this->N_teamleader->get_list_proyecto_busqueda($dato);
        $dato['list_empresa'] =$this->Admin_model->list_empresa_proyecto();
        $dato['list_sede'] =$this->Admin_model->list_sede_proyecto();
    
        $this->load->view('teamleader/informe/busqueda/busqueda',$dato);
    }

    public function Excel_Lista_Proyecto($anio){
        $dato['anio']=$anio;
        $busqueda = $this->N_teamleader->get_list_proyecto_busqueda($dato);
        $list_empresa =$this->Admin_model->list_empresa_proyecto();
        $list_sede =$this->Admin_model->list_sede_proyecto();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Lista de Proyectos Total');
        $sheet->setAutoFilter('A1:N1');

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

        foreach($busqueda as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $cod_sede="";
            foreach($list_sede as $sede){
                if($sede['id_proyecto']==$list['id_proyecto']){
                    $cod_sede=$cod_sede.$sede['cod_sede'].",";
                }
            }
            if($cod_sede==""){
                $cod_sede="";
            }else{
                $cod_sede=substr($cod_sede,0,-1);
            }
            
            $cod_empresa="";
            foreach($list_empresa as $empresa){
                if($empresa['id_proyecto']==$list['id_proyecto']){
                    $cod_empresa=$cod_empresa.$empresa['cod_empresa'].",";
                }
            }
            if($cod_empresa==""){
                $cod_empresa="";
            }else{
                $cod_empresa=substr($cod_empresa,0,-1);
            }

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['prioridad']);
            $sheet->setCellValue("B{$contador}", $list['cod_proyecto']);
            $sheet->setCellValue("C{$contador}", $list['nom_statusp']);
            $sheet->setCellValue("D{$contador}", $cod_empresa);
            $sheet->setCellValue("E{$contador}", $cod_sede);
            $sheet->setCellValue("F{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("G{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("H{$contador}", $list['descripcion']);
            $sheet->setCellValue("I{$contador}", ($list['s_artes']+$list['s_redes']));

            if($list['fec_agenda']!="00/00/0000"){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel( $list['fec_agenda'] ));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("J{$contador}", "");
            } 

            $sheet->setCellValue("K{$contador}", $list['ucodigo_solicitado']);

            if($list['fec_solicitante']!="00/00/0000"){
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel( $list['fec_solicitante'] ));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("L{$contador}", "");
            } 

            $sheet->setCellValue("M{$contador}", $list['ucodigo_asignado']);

            if($list['fec_termino']!="00/00/0000 00:00:00"){
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel( $list['fec_termino'] ));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("N{$contador}", "");
            } 

        }

        $curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Lista de Proyectos Total';
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); 

        
        /*if(count($busqueda) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Lista de Proyectos Total');
            
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
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

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
            $this->excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("N{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:N1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:N1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Prioridad');	        
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Código');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Status');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Sede(s)');	        
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Empresa(s)');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tipo');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'SubTipo');	        
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Descripción');
            $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Snappys');
            $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Agenda');	        
	        $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Usuario');
            $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Fecha');
            $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Usuario');
            $this->excel->getActiveSheet()->setCellValue("N{$contador}", 'Fecha');
	        //Definimos la data del cuerpo.
	        foreach($busqueda as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
                $contador++;

                $cod_sede="";
                foreach($list_sede as $sede){
                    if($sede['id_proyecto']==$list['id_proyecto']){
                        $cod_sede=$cod_sede.$sede['cod_sede'].",";
                    }
                }
                $cod_sede=substr($cod_sede,0,-1);
                
                $cod_empresa="";
                foreach($list_empresa as $empresa){
                    if($empresa['id_proyecto']==$list['id_proyecto']){
                        $cod_empresa=$cod_empresa.$empresa['cod_empresa'].",";
                    }
                }
                $cod_empresa=substr($cod_empresa,0,-1);

	        	//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['prioridad']);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['cod_proyecto']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['nom_statusp']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $cod_sede);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $cod_empresa);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['nom_tipo']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_subtipo']);
                $this->excel->getActiveSheet()->setCellValue("H{$contador}", $list['descripcion']);
		        $this->excel->getActiveSheet()->setCellValue("I{$contador}", ($list['s_artes']+$list['s_redes']));
                $this->excel->getActiveSheet()->setCellValue("J{$contador}", $list['fec_agenda']);
                $this->excel->getActiveSheet()->setCellValue("K{$contador}", $list['ucodigo_solicitado']);
		        $this->excel->getActiveSheet()->setCellValue("L{$contador}", $list['fec_solicitante']);
                $this->excel->getActiveSheet()->setCellValue("M{$contador}", $list['ucodigo_asignado']);
                $this->excel->getActiveSheet()->setCellValue("N{$contador}", $list['fec_termino']);
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista de Proyectos (Total).xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
        }else{
        	echo 'No se han encontrado llamadas';
        	exit;
        }*/
    }

    public function Agregar_Duplicado(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_proyecto']= $this->input->post("id_proyecto");
            $dato['id_tipo']= $this->input->post("id_tipo");
            //var_dump($dato['id_tipo']);
            $id_proyecto= $this->input->post("id_proyecto");
            $dato['s_redes']= $this->input->post("s_redesd");
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

            //$dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            $this->Admin_model->agregar_duplicado_proyecto($dato);
        }else{
            redirect('/login');
        }
        
    }

    public function List_Duplicados(){
        if ($this->session->userdata('usuario')) {
            $id_proyecto= $this->input->post("id_proyecto");
            $dato['list_duplicado'] = $this->Admin_model->get_list_duplicados($id_proyecto);
            $this->load->view('administrador/proyecto/list_duplicado',$dato);
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

    

}


