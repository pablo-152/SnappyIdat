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
class Ceba2 extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Ceba2');
        $this->load->model('Model_snappy');
        $this->load->model('Admin_model');
        $this->load->model('Model_General');
        $this->load->model('Model_IFV');
        $this->load->model('Model_IFVS');
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
            $data['fondo'] = $this->Model_Ceba2->get_confg_fondo();
            $data['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $data['list_aviso'] = $this->Model_General->get_list_aviso();
            $this->Model_IFVS->actu_estado_examen_ifv();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $data['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $data['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $data['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $data['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['get_id'] = $this->Model_snappy->get_id_usuario_config($id_usuario);
            $_SESSION['foto']=$dato['get_id'][0]['foto'];
            $data['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede(); 
            $this->load->view('ceba2/administrador/index',$data);
        }
        else{
            //$this->load->view('login/login');
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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/aviso/detalle',$dato);
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

        redirect('Snappy/index');
    }

    public function configuracion() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['confg_foto'] = $this->Model_snappy->get_confg_foto();
        $this->load->view('configuracion/index',$dato);
    }
    //----------------------------------------------------------
    //BOTON DE PRUEBA COLOCADO POR EDSON -- ACA EDITA
    public function Modal_Curso_Alumno_Regis(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_asignatura_combo();


            $this->load->view('ceba2/academico/curso/modal_registrar',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    //---------------------------------------------------------------------
    public function Modal_Read_Collapse($id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema']=$id_tema;
            /*
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema_asociar_collapse($id_tema_asociar_collapse);
            $dato['list_read_collapse'] = $this->Model_Ceba2->get_list_read_collapse();
           

           /* $dato['list_curso'] = $this->Model_Ceba2->get_list_curso();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();
            $dato['id_curso']= $id_curso; //viene  como parameter*/
            
            $this->load->view('ceba2/academico/curso/modal_read_collapse', $dato);  //xq no jala
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    //-------------------------------------------------------------------------------------------------------
    public function Excel_Requisito($id_curso){
        $grado = $this->Model_Ceba2->get_list_requisito_curso_edson($id_curso);
        if(count($grado) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Requisitos');
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:C1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:C1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Tipo de Requisito');            
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Descripción');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($grado as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_tipo_requisito']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['desc_requisito']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Requisitos.xls";
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
    //---------------------------------------------------------------------------------------------------------------------------------------
    public function Excel_Tema_Curso($id_curso){
        $grado = $this->Model_Ceba2->get_list_tema_asociar_curso($id_curso);
        if(count($grado) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Temas_X_Curso');
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:D1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:D1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Unidad');            
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Area');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Nombre Asignatura');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Nombre de Tema');

            //Definimos la data del cuerpo.
            foreach($grado as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['desc_tema']);

            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Temas_X_Curso.xls";
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
    //---------------------------------------------------------------------------------------------------------------------------------------
    public function Excel_Asignaturas_curso($id_curso){
        $grado = $this->Model_Ceba2->get_list_tema_asociar_curso($id_curso);
        if(count($grado) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Asignaturas_X_Curso');
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:C1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:C1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Unidad');            
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Area');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Nombre Asignatura');

            //Definimos la data del cuerpo.
            foreach($grado as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['descripcion_asignatura']);

            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Asignaturas_X_Curso.xls";
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
    //---------------------------------------------------------------------------------------------------------------------------------------
    public function Excel_Areas_Curso($id_curso){
        $grado = $this->Model_Ceba2->get_list_tema_asociar_curso($id_curso);
        if(count($grado) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Areas_X_Curso');
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);


            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);


            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:B1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:B1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Unidad');            
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Area');

            //Definimos la data del cuerpo.
            foreach($grado as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['descripcion_area']);

            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Areas_X_Curso.xls";
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
    //-------------------------------------------------------------------------------------------------------------
    public function Revisado() {
        if ($this->session->userdata('usuario')) { 
            $dato['id']=$this->input->post("id");
            $id_tema=$this->input->post("id_tema");
            $tipo=$this->input->post("tipo");

            if($tipo==1){
                $id_intro=$this->input->post("id");
                $intro=$this->Model_Ceba2->get_id_intro($id_intro);

                if($intro[0]['fec_revisado']=="0000-00-00" && $intro[0]['user_revisado']==0){
                    $this->Model_Ceba2->cambiar_revisado_intro($dato);
                }else{
                    $this->Model_Ceba2->borrar_revisado_intro($dato);
                }
            }
            if($tipo==2){
                $id_slide=$this->input->post("id");
                $slide=$this->Model_Ceba2->get_id_slide($id_slide);

                if($slide[0]['fec_revisado']=="0000-00-00" && $slide[0]['user_revisado']==0){
                    $this->Model_Ceba2->cambiar_revisado_slide($dato);
                }else{
                    $this->Model_Ceba2->borrar_revisado_slide($dato);
                }
            }
            if($tipo==3){
                $id_repaso=$this->input->post("id");
                $repaso=$this->Model_Ceba2->get_id_repaso($id_repaso);

                if($repaso[0]['fec_revisado']=="0000-00-00" && $repaso[0]['user_revisado']==0){
                    $this->Model_Ceba2->cambiar_revisado_repaso($dato);
                }else{
                    $this->Model_Ceba2->borrar_revisado_repaso($dato);
                }
            }

            $dato['get_id'] = $this->Model_Ceba2->get_id_temas($id_tema);
            $dato['get_intro'] = $this->Model_Ceba2->get_intro_tema($id_tema);
            $dato['get_slide'] = $this->Model_Ceba2->get_slide_tema($id_tema);
            $dato['get_repaso'] = $this->Model_Ceba2->get_repaso_tema($id_tema);
            $dato['get_examen'] = $this->Model_Ceba2->get_examen_tema($id_tema);
            $dato['suma_slide'] = $this->Model_Ceba2->v_suma_tiempo_slide();
            $dato['suma_repaso'] = $this->Model_Ceba2->v_suma_tiempo_repaso();
            $dato['suma_slide_repaso'] = $this->Model_Ceba2->v_suma_tiempo_slide_repaso();
            $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_slide_repaso();
            $dato['peso_slide'] = $this->Model_Ceba2->v_peso_slide($id_tema);
            $dato['peso_repaso'] = $this->Model_Ceba2->v_peso_repaso($id_tema);
            $dato['peso_intro'] = $this->Model_Ceba2->peso_intro($id_tema);
            $dato['peso_examen'] = $this->Model_Ceba2->peso_examen($id_tema);
            if(count($dato['peso_slide'])>0){
                $dato['sum_slide']=$dato['peso_slide'][0]['total_slide'];
            }else{
                $dato['sum_slide']='0';
            }
            if(count($dato['peso_repaso'])>0){
                $dato['sum_repaso']=$dato['peso_repaso'][0]['total_repaso'];
            }else{
                $dato['sum_repaso']='0';
            }
            if(count($dato['peso_examen'])>0){
                $dato['sum_examen']=$dato['peso_examen'][0]['total_examen'];
            }else{
                $dato['sum_examen']='0';
            }
            if(count($dato['peso_intro'])>0){
                $dato['sum_intro']=$dato['peso_intro'][0]['total_intro'];
            }else{
                $dato['sum_intro']='0';
            }
            $dato['peso_total']=$dato['sum_slide']+$dato['sum_repaso']+$dato['sum_intro'];

            $dato['get_link'] = $this->Model_Ceba2->get_config();

            $this->load->view('ceba2/academico/temas/detalle_tema/tabla_grande',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Revisado_Examen() {
        if ($this->session->userdata('usuario')) { 
            $dato['id']=$this->input->post("id");
            $id_tema=$this->input->post("id_tema");

            $id_examen=$this->input->post("id");
            $examen=$this->Model_Ceba2->get_id_examen($id_examen);

            if($examen[0]['fec_revisado']=="0000-00-00" && $examen[0]['user_revisado']==0){
                $this->Model_Ceba2->cambiar_revisado_examen($dato);
            }else{
                $this->Model_Ceba2->borrar_revisado_examen($dato);
            }

            $dato['get_id'] = $this->Model_Ceba2->get_id_temas($id_tema);
            $dato['get_intro'] = $this->Model_Ceba2->get_intro_tema($id_tema);
            $dato['get_slide'] = $this->Model_Ceba2->get_slide_tema($id_tema);
            $dato['get_repaso'] = $this->Model_Ceba2->get_repaso_tema($id_tema);
            $dato['get_examen'] = $this->Model_Ceba2->get_examen_tema($id_tema);
            $dato['suma_slide'] = $this->Model_Ceba2->v_suma_tiempo_slide();
            $dato['suma_repaso'] = $this->Model_Ceba2->v_suma_tiempo_repaso();
            $dato['suma_slide_repaso'] = $this->Model_Ceba2->v_suma_tiempo_slide_repaso();
            $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_slide_repaso();
            $dato['peso_slide'] = $this->Model_Ceba2->v_peso_slide($id_tema);
            $dato['peso_repaso'] = $this->Model_Ceba2->v_peso_repaso($id_tema);
            $dato['peso_intro'] = $this->Model_Ceba2->peso_intro($id_tema);
            $dato['peso_examen'] = $this->Model_Ceba2->peso_examen($id_tema);
            if(count($dato['peso_slide'])>0){
                $dato['sum_slide']=$dato['peso_slide'][0]['total_slide'];
            }else{
                $dato['sum_slide']='0';
            }
            if(count($dato['peso_repaso'])>0){
                $dato['sum_repaso']=$dato['peso_repaso'][0]['total_repaso'];
            }else{
                $dato['sum_repaso']='0';
            }
            if(count($dato['peso_examen'])>0){
                $dato['sum_examen']=$dato['peso_examen'][0]['total_examen'];
            }else{
                $dato['sum_examen']='0';
            }
            if(count($dato['peso_intro'])>0){
                $dato['sum_intro']=$dato['peso_intro'][0]['total_intro'];
            }else{
                $dato['sum_intro']='0';
            }
            $dato['peso_total']=$dato['sum_slide']+$dato['sum_repaso']+$dato['sum_intro'];

            $dato['get_link'] = $this->Model_Ceba2->get_config();

            $this->load->view('ceba2/academico/temas/detalle_tema/tabla_pequena',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Valida_Examen(){
        $dato['id_grado']= $this->input->post("id_grado");
        //$dato['id_tema']= $this->input->post("id_tema");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_examen']= $this->input->post("id_tipo_examen");
        $dato['tiempo']= $this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['foto1']= $this->input->post("foto1");
        $dato['foto2']= $this->input->post("foto2");
        $dato['pregunta']= $this->input->post("pregunta");
        $dato['alternativa1']= $this->input->post("alternativa1"); 
        $dato['alternativa2']= $this->input->post("alternativa2");
        $dato['alternativa3']= $this->input->post("alternativa3");
        $dato['respuesta']= $this->input->post("respuesta");


        $total=count($this->Model_Ceba2->valida_reg_examen($dato));
        //var_dump($total);
        if($total>0){
            echo "error";
        }
    }
    //--------------------------------------------------------------------------------------------------------------------
    public function Excel_Tema_Primero_Secundaria(){
        $tipo = $this->Model_Ceba2->list_1_secundaria();
        if(count($tipo) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('1_secundaria');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(46.5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(8.5);
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
            $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:G1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Grado');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Unidad');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Referencia');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Área');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Asignatura');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tema');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($tipo as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['descripcion_grado']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['referencia']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['desc_tema']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            if (ob_get_contents()) ob_end_clean();
            $archivo = "Lista_Primero_Secundaria.xls";

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

    public function Excel_Tema_Segundo_Secundaria(){
        $tipo = $this->Model_Ceba2->list_2_secundaria();
        if(count($tipo) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('2_secundaria');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(46.5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(8.5);
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
            $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:G1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Grado');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Unidad');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Referencia');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Área');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Asignatura');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tema');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($tipo as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['descripcion_grado']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['referencia']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['desc_tema']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Segundo_Secundaria.xls";
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

    public function Excel_Tema_Tercero_Secundaria(){
        $tipo = $this->Model_Ceba2->list_3_secundaria();
        if(count($tipo) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('3_secundaria');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(46.5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(8.5);
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
            $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:G1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Grado');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Unidad');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Referencia');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Área');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Asignatura');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tema');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($tipo as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['descripcion_grado']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['referencia']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['desc_tema']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Tercero_Secundaria.xls";
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

    public function Excel_Tema_Cuarto_Secundaria(){
        $tipo = $this->Model_Ceba2->list_4_secundaria();
        if(count($tipo) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('4_secundaria');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(46.5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(8.5);
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
            $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:G1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Grado');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Unidad');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Referencia');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Área');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Asignatura');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tema');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($tipo as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['descripcion_grado']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['referencia']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['desc_tema']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Cuarto_Secundaria.xls";
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

    public function Excel_Tema_Inactivo_Secundaria(){
        $tipo = $this->Model_Ceba2->list_5_secundaria();
        if(count($tipo) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Inactivos');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6.5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(46.5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(8.5);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(8.5);
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
            $this->excel->getActiveSheet()->getStyle("O{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("P{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Q{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("S{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("T{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("U{$contador}")->getFont()->setBold(true);

            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:G1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Grado');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Unidad');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Referencia');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Área');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Asignatura');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tema');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Estado');
            //Definimos la data del cuerpo.
            foreach($tipo as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['descripcion_grado']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_unidad']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['referencia']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['descripcion_area']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['descripcion_asignatura']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['desc_tema']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['nom_status']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Inactivos_Secundaria.xls";
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

    public function Insert_Listado_Curso(){
        $dato['grupo']= $this->input->post("grupo"); 
        $dato['unidad']= $this->input->post("unidad"); 
        $dato['turno']= $this->input->post("turno"); 
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_anio']= $this->input->post("id_anio"); 
        $dato['fec_inicio']= $this->input->post("fec_inicio");
        $dato['fec_fin']= $this->input->post("fec_fin");
        $dato['inicio_curso']= $this->input->post("inicio_curso");
        $dato['fin_curso']= $this->input->post("fin_curso");
        $this->Model_Ceba2->insert_listado_curso($dato);
    }
    //------------------------------------------------------------------------------------------------------------
    public function Excel_Alumno_Curso($id_curso){
        $grado = $this->Model_Ceba2->get_list_alumno_asociar_curso_excel($id_curso);//----
        if(count($grado) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Alumnos_X_Curso');
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:E1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:E1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo');            
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre del Alumno');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Apellido Paterno');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Apellido Materno');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Estado');

            //Definimos la data del cuerpo.
            foreach($grado as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['cod_alum']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['alum_nom']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['alum_apater']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['alum_amater']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['nom_estadoa']);

            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Alumnos_X_Curso.xls";
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


//-------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
        /*Alumnos*/ 
//--------------------------------------------------------------------------------------------------------
    public function subprovincia($id_departamento="00") {
        header('Content-Type: application/json');
        $data = $this->Model_Ceba2->getprovincia($id_departamento);
        echo json_encode($data); 
    }

    public function sub_provincia($id_departamento="00", $id_provincia="0000") {
        header('Content-Type: application/json');
        $data = $this->Model_Ceba2->get_sub_provincia($id_departamento,$id_provincia);
        echo json_encode($data);
    }

    public function Modal_Update_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $dato['list_departamentoa'] = $this->Model_Ceba2->get_list_departamento();
           // $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provincia();

            $id_departamentoa=$dato['get_id'][0]['id_departamentoa'];
            $id_provinciaa=$dato['get_id'][0]['id_provinciaa'];
            $id_departamentop=$dato['get_id'][0]['id_departamentop'];
            $id_provinciap=$dato['get_id'][0]['id_provinciap'];
            $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provinciaa($id_departamentoa);
            $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distritoa($id_departamentoa,$id_provinciaa);

            $dato['list_provinciap'] = $this->Model_Ceba2->get_list_provinciap($id_departamentop);
            $dato['list_distritop'] = $this->Model_Ceba2->get_list_distritop($id_departamentop,$id_provinciap);
           // $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distrito();
            $dato['list_grado_escuela'] = $this->Model_Ceba2->get_list_grado_escuela();//
            $dato['list_grado_activo'] = $this->Model_Ceba2->get_list_grado();//
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();//
            $dato['list_medios'] = $this->Model_Ceba2->get_list_medios();//
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            $this->load->view('ceba2/alumno/modal_upd',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Modal_Update_Alumno_Detalle($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
    
            $dato['list_departamentoa'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provincia();
            $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distrito();
            $dato['list_grado_escuela'] = $this->Model_Ceba2->get_list_grado_escuela();//
            $dato['list_grado_activo'] = $this->Model_Ceba2->get_list_grado();//
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();//
            $dato['list_medios'] = $this->Model_Ceba2->get_list_medios();//
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            $this->load->view('ceba2/alumno/modal_upd_detalle',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Update_Alumnos_Detalle(){
        $dato['id_alumno']= $this->input->post("id_alumno"); 
        $dato['dni_alumno']= $this->input->post("dni_alumno");
        //$dato['cod_alum']= $this->input->post("cod_alum");
        $dato['alum_nom']= $this->input->post("alum_nom");
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nacimiento']= $this->input->post("alum_nacimiento");
        $dato['alum_edad']= $this->input->post("alum_edad");
        $dato['alum_direc']= $this->input->post("alum_direc");
        $dato['id_departamentoa']= $this->input->post("id_departamentoa");
        $dato['id_provinciaa']= $this->input->post("id_provinciaa");
        $dato['id_distritoa']= $this->input->post("id_distritoa");
        $dato['alum_celular']= $this->input->post("alum_celular");
        $dato['alum_cellcontac']= $this->input->post("alum_cellcontac");
        $dato['correo']= $this->input->post("correo");
        $dato['alumno_institucionp']= $this->input->post("alumno_institucionp");
        $dato['id_departamentop']= $this->input->post("id_departamentop");
        $dato['id_provinciap']= $this->input->post("id_provinciap");
        $dato['id_distritop']= $this->input->post("id_distritop");
        $dato['id_gradop']= $this->input->post("id_gradop");
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
        $dato['id_grados_activos']= $this->input->post("id_grados_activos");
        $dato['tipo']= $this->input->post("tipo");
        $dato['id_medios']= $this->input->post("id_medios");


        $dato['get_id_alumno'] = $this->Model_Ceba2->get_id_alumno($dato['id_alumno']);
        $dato['estado']=$dato['get_id_alumno'][0]['estado_alum'];
        $dato['motivo_estado']=$dato['get_id_alumno'][0]['motivo_estado'];
        $this->Model_Ceba2->update_alumno($dato);

        redirect('Ceba/Detalles_Alumno/'.$dato['id_alumno']);  
    }

    
    /*public function Delete_Alumno(){
        $_id_alumno = $this->input->post('id_alumno',true);
        if(empty($_id_alumno)){
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(array('msg'=>'El id no puede ser vacio')));
        }else{
            $this->Model_Ceba2->delete_alumno($_id_alumno);
            
            $this->output
                ->set_status_header(200);
        }
    }*/

    public function Delete_Alumno(){
        if ($this->session->userdata('usuario')) {
            $id_alumno =$this->input->post("id_alumno");
            $this->Model_Ceba2->delete_alumno($id_alumno);
            } 
        
        else{
            //$this->load->view('login/login');
            redirect('/login');
        } 
    }

    public function Actualizar_Observaciones(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']=$this->input->post("id_alumno");
            $dato['observaciones']=$this->input->post("observaciones");

            $this->Model_Ceba2->update_observaciones($dato);
        }else{
            redirect('/login');
        }
    }

    
    public function Modal_Pago($id_pago){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_pago($id_pago);
            $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop();
            $this->load->view('ceba2/alumno/modal_pago',$dato);
        }else{
            redirect('/login');
        }
    }


    public function Modal_Detalle_Pago($id_pago,$tipopago){
        if ($this->session->userdata('usuario')) {
            $dato['tipopago']=$tipopago;
            //$dato['get_id'] = $this->Model_Ceba2->get_id_pago($id_pago);
            $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
            
            if($dato['tipopago']==1){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==2){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago1($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==3){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago2($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==4){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago3($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==5){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago4($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==6){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago5($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }if($dato['tipopago']==7){
                $dato['get_id'] = $this->Model_Ceba2->get_id_pago6($id_pago);
                $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop($id_pago);
                $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();

                $this->load->view('ceba2/alumno/modal_detalle_pago',$dato);
            }   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Pago(){
        $dato['id_pago']=$this->input->post("id_pago");
        $dato['monto']=$this->input->post("monto");
        $dato['fec_pago']=$this->input->post("fec_pago");
        $dato['estado_pago']=$this->input->post("estado_pago");
        $this->Model_Ceba2->update_pago($dato);
    }

    public function Delete_Pago(){
        if ($this->session->userdata('usuario')) {
            $id_pago =$this->input->post("id_pago");
            $id_alumno =$this->input->post("id_alumno");
            $this->Model_Ceba2->delete_pago($id_pago);
            } 
        
        else{
            //$this->load->view('login/login');
            redirect('/login');
        } 
    }

    ////----------------

    public function Modal_Update_Admision($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_nivel'] = $_SESSION['usuario'][0]['id_nivel'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estadoa();
            $this->load->view('ceba2/alumno/modal_upd_adm',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function delete_admsion(){
        $_id_alumno = $this->input->post('id_alumno',true);
        if(empty($_id_alumno)){
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode(array('msg'=>'El id no puede ser vacio')));
        }else{
            $this->Model_Ceba2->delete_alumno_admision($_id_alumno);
            $this->output
                ->set_status_header(200);
        }
    }

    public function Multimedia($id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['get_intro'] = $this->Model_Ceba2->get_intro_tema($id_tema);
            $dato['get_slide'] = $this->Model_Ceba2->get_slide_tema($id_tema);
            $dato['get_repaso'] = $this->Model_Ceba2->get_repaso_tema($id_tema);
            $dato['get_examen'] = $this->Model_Ceba2->get_examen_tema($id_tema);
            $this->load->view('ceba2/academico/temas/slideshow',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    /**------------INSTRUCCION MATRICULA */
    public function Requisito() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_requisito'] = $this->Model_Ceba2->get_list_requisito_matricula();

        //AVISO NO BORRAR
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();
        
        $this->load->view('ceba2/academico/configuracion/requisito_matricula/index',$dato);
    }

    public function Modal_Requisito_Matricula(){
        if ($this->session->userdata('usuario')) {
            //$dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $this->load->view('ceba2/academico/configuracion/requisito_matricula/modal_registrar');   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Requisito_Matricula(){
        $dato['codigo']= $this->input->post("codigo");//from input
        $dato['nombre']= $this->input->post("nombre");
        
        $this->Model_Ceba2->insert_requisito_matricula($dato);
    }

    public function Modal_Update_Requisito_Matricula($id_requisito_m){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_requisito_matricula($id_requisito_m);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/configuracion/requisito_matricula/modal_editar',$dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Requisito_Matricula(){
        $dato['id_requisito_m']= $this->input->post("id_requisito_m");
        $dato['codigo']= $this->input->post("codigo");
        $dato['nombre']= $this->input->post("nombre");
        $dato['estado']= $this->input->post("id_status");
        
        $this->Model_Ceba2->update_requisito_matricula($dato);
    }

    public function Delete_Requisito_Matricula(){
        $dato['id_requisito_m']= $this->input->post("id_requisito_m");
        
        $this->Model_Ceba2->delete_requisito_matricula($dato);
    }

    public function Excel_Requisito_Matricula(){
        $dato['list_requisito'] = $this->Model_Ceba2->get_list_requisito_matricula();

        if(count($dato['list_requisito']) > 0){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Requisitos de Matrícula');

            $sheet->setAutoFilter('A1:C1');
    
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(50);
            $sheet->getColumnDimension('C')->setWidth(20);

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
            $sheet->setCellValue("B1", 'Nombre');           
            $sheet->setCellValue("C1", 'Estado');

            $contador=1;
            
	        foreach($dato['list_requisito'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", $list['codigo']);
                $sheet->setCellValue("B{$contador}", $list['nombre']);
                $sheet->setCellValue("C{$contador}", $list['nom_status']);
            }
    
            $curdate = date('d-m-Y');
            $writer = new Xlsx($spreadsheet);

            $filename = 'Requisitos de Matricula';

            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }else{
            echo 'No se han encontrado llamadas';
        	exit; 
        }

    }

    public function Consulta_Documentos(){
        if ($this->session->userdata('usuario')) {
            //$dato['id_requisito']= $this->input->post("id_requisito");
            $dato['anio']=date("Y");
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($dato['id_alumno']);
            $dato['id_grado']=$dato['get_id'][0]['id_grados_activos'];
            $dato['edad']=$dato['get_id'][0]['alum_edad'];
            $dato['list_documentos']=$this->Model_Ceba2->list_documentos($dato);
            
            $this->load->view('ceba2/alumno/list_documentos',$dato);
        }else{
            redirect('/login');
        } 
    }

    public function Modal_Detalle_Unidad($id_alumno,$id_unidad,$id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']=$id_alumno;
            $dato['id_nivel'] = $_SESSION['usuario'][0]['id_nivel'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_detalle_unidad($id_alumno,$id_unidad,$id_grado);
            //$this->load->view('ceba2/alumno/modal_detalle_unidad',$dato);  
            
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            $dato['list_tipo_obs'] = $this->Model_Ceba2->get_list_tipo_obs();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('ceba2/alumno/vista_detalle_unidad',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Modal_Edit_Detalle_Unidad($id_pago,$id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_pago']=$id_pago;
            $dato['id_alumno']=$id_alumno;
            $dato['get_id'] = $this->Model_Ceba2->get_id_unidad($id_pago);
            $dato['list_estado_unidad'] = $this->Model_Ceba2->get_list_estado_unidad();
            $this->load->view('ceba2/alumno/upd_modal_unidad',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Update_Estado_Unidad(){
        if ($this->session->userdata('usuario')) {
            $dato['id_pago']= $this->input->post("id_pago");
            $dato['estado']= $this->input->post("estado");
            $dato['id_alumno']= $this->input->post("id_alumno");
            $dato['get_id_alumno'] = $this->Model_Ceba2->get_id_alumno($dato['id_alumno']);
            $dato['id_grado']=$dato['get_id_alumno'][0]['id_grados_activos'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_unidad($dato['id_pago']);
            $dato['id_prod_final']=$dato['get_id'][0]['id_prod_final'];
            $this->Model_Ceba2->update_estado_unidad($dato);

        }else{
            redirect('/login');
        } 
    }

    public function Modal_Update_Matricula_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
    
            $dato['list_grado_activo'] = $this->Model_Ceba2->get_list_grado();
            $this->load->view('ceba2/alumno/modal_upd_matricula_alumno',$dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Registrar_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']=$this->input->post("id_alumno");
            $dato['id_grados_activos']=$this->input->post("id_grados_activos");

            $this->Model_Ceba2->realizar_matricula($dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------ALUMNO-------------------------------------
    public function Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['total_alumnos'] = $this->Model_Ceba2->get_list_total_alumnos();
            $dato['admision'] = $this->Model_Ceba2->get_list_enadmision();
            $dato['total_admision'] = $this->Model_Ceba2->get_list_total_enadmision();
            $dato['sinefecto'] = $this->Model_Ceba2->get_list_sinefecto();
            $dato['total_sinefecto'] = $this->Model_Ceba2->get_list_total_sinefecto();
            $dato['registrado'] = $this->Model_Ceba2->get_list_registrado();
            $dato['total_registrado'] = $this->Model_Ceba2->get_list_total_registrado();
            $dato['total_anulado'] = $this->Model_Ceba2->get_list_total_anulado();
            $dato['total_seguimiento'] = $this->Model_Ceba2->get_list_total_seguimiento();
            $dato['seguimiento'] = $this->Model_Ceba2->get_list_seguimiento();
            $dato['total_matriculado'] = $this->Model_Ceba2->get_list_total_matriculado();
            $dato['matriculado'] = $this->Model_Ceba2->get_list_matriculado();
            $dato['graduado'] = $this->Model_Ceba2->get_list_graduado();
            $dato['total_graduado'] = $this->Model_Ceba2->get_list_total_graduado();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/alumno/index',$dato);
        }else{
            redirect('');
        }
    }

    public function Admision_Alumno() {
        if ($this->session->userdata('usuario')) {
            $parametro=$this->input->post("parametro");
            $dato['parametro']=$this->input->post("parametro");
            
            if($parametro==1 || $parametro==4 || $parametro==5 || $parametro==6 || $parametro==7 || $parametro==8){
                $dato['list_admision'] = $this->Model_Ceba2->get_list_admision($parametro);
                $this->load->view('ceba2/alumno/Admision', $dato);
            }elseif($parametro==2){
                $dato['list_alumno'] = $this->Model_Ceba2->get_list_alumno();
                $this->load->view('ceba2/alumno/Alumnos', $dato);
            }elseif($parametro==3){
                $dato['list_todo'] = $this->Model_Ceba2->get_list_todo_alumno();
                $this->load->view('ceba2/alumno/Todos', $dato);
            }elseif($parametro==9){
                $dato['list_graduado'] = $this->Model_Ceba2->get_list_graduado_alumno();
                $this->load->view('ceba2/alumno/Graduado', $dato);
            }
        }
        else{
            redirect('');
        }
    }

    public function Modal_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['list_departamentoa'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provincia();
            $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distrito();
            $dato['list_grado_escuela'] = $this->Model_Ceba2->get_list_grado_escuela();
            $dato['list_grado_activo'] = $this->Model_Ceba2->get_list_grado();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_medios'] = $this->Model_Ceba2->get_list_medios();
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/alumno/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno(){
        $dato['dni_alumno']= $this->input->post("dni_alumno");
        //$dato['cod_alum']= $this->input->post("cod_alum");
        $dato['alum_nom']= $this->input->post("alum_nom");
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nacimiento']= $this->input->post("alum_nacimiento");
        $dato['alumno_password']=$this->input->post("dni_alumno");
        /*$password= $this->input->post("dni_alumno");
        $dato['alumno_password']= password_hash($password, PASSWORD_DEFAULT);*/
        
        $anio=date('Y');
        $query_id = $this->Model_Ceba2->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
        $totalRows_t = count($query_id);

        $aniof=substr($anio, 2,2);
        if($totalRows_t<9){
            $codigo="EP1-".$aniof."00".($totalRows_t+1);
        }
        if($totalRows_t>8 && $totalRows_t<99){
            $codigo="EP1-".$aniof."0".($totalRows_t+1);
        }
        if($totalRows_t>98){
            $codigo="EP1-".$aniof.($totalRows_t+1);
        }

        $dato['cod_alum']=$codigo;
        $dato['alum_edad']= $this->input->post("alum_edad");
        $dato['alum_direc']= $this->input->post("alum_direc");
        $dato['id_departamentoa']= $this->input->post("id_departamentoa");
        $dato['id_provinciaa']= $this->input->post("id_provinciaa");
        $dato['id_distritoa']= $this->input->post("id_distritoa");
        $dato['alum_celular']= $this->input->post("alum_celular");
        $dato['alum_cellcontac']= $this->input->post("alum_cellcontac");
        $dato['correo']= $this->input->post("correo");
        $dato['alumno_institucionp']= $this->input->post("alumno_institucionp");
        $dato['id_departamentop']= $this->input->post("id_departamentop");
        $dato['id_provinciap']= $this->input->post("id_provinciap");
        $dato['id_distritop']= $this->input->post("id_distritop");
        $dato['id_gradop']= $this->input->post("id_gradop");
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
        $dato['id_grados_activos']= $this->input->post("id_grados_activos");
        $dato['tipo']= $this->input->post("tipo");
        $dato['id_medios']= $this->input->post("id_medios");

        
        $cantidad=count($this->Model_Ceba2->valida_reg_alumno($dato));
        if($cantidad>0){
            echo "error";
        }else{
            $this->Model_Ceba2->insert_alumno($dato);

            $get_id = $this->Model_Ceba2->ultimo_id_alumno();
            $dato['id_alumno'] = $get_id[0]['id_alumno'];

            $list_documento = $this->Model_Ceba2->get_list_config_documento();

            foreach($list_documento as $list){
                $dato['id_documento'] = $list['id_config'];
                $this->Model_Ceba2->insert_documento_alumno_ep1($dato);
            }

            //INSERTAR DOCUMENTOS AL ALUMNO
            $get_id = $this->Model_Ceba2->ultimo_id_alumno();
            $dato['id_alumno'] = $get_id[0]['id_alumno'];
            $dato['anio'] = date('Y');
            $list_documento = $this->Model_Ceba2->get_documentos_asignados($dato['id_grados_activos']);

            if(count($list_documento)>0){
                foreach($list_documento as $list){
                    $dato['id_documento'] = $list['id_documento'];
                    $this->Model_Ceba2->insert_documentos_alumno($dato);
                }
            }
        }
    }

    public function Excel_Alumno(){
        $parametro= $this->input->post("parametro");

        $tipo = $this->Model_Ceba2->excel_alumno($parametro);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if($parametro==1){
            $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos Admision (EP)');
            $sheet->setAutoFilter('A1:Q1');

            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(18);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(18);
            $sheet->getColumnDimension('J')->setWidth(18);
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(50);
            $sheet->getColumnDimension('Q')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Creado Por');
            $sheet->setCellValue("K{$contador}", 'Departamento');
            $sheet->setCellValue("L{$contador}", 'Provincia');
            $sheet->setCellValue("M{$contador}", 'Edad');
            $sheet->setCellValue("N{$contador}", 'Matricula');
            $sheet->setCellValue("O{$contador}", 'Estado');
            $sheet->setCellValue("P{$contador}", 'Observaciones');
            $sheet->setCellValue("Q{$contador}", 'Link Foto');	          

            foreach($tipo as $list){
                $contador++;
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("O{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("Q{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                } 
                if($list['usuario_registro'] !='0' ) {
                    $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
                }else{ 
                    $sheet->setCellValue("J{$contador}", "Web");
                }
                $sheet->setCellValue("K{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("L{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("M{$contador}", $list['alum_edad']);
                $sheet->setCellValue("N{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("O{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("P{$contador}", $list['observaciones']);
                if($list['link_foto']!=""){
                    $sheet->setCellValue("Q{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("Q{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("Q{$contador}", "");
                }
            }
        }elseif($parametro==2){
            $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos Matriculados (EP)');
            $sheet->setAutoFilter('A1:Q1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(50);
            $sheet->getColumnDimension('Q')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Arpay');            
            $sheet->setCellValue("C{$contador}", 'Grado');
            $sheet->setCellValue("D{$contador}", 'DNI');
            $sheet->setCellValue("E{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("F{$contador}", 'Ap. Materno');
            $sheet->setCellValue("G{$contador}", 'Nombre(s)');
            $sheet->setCellValue("H{$contador}", 'Provincia');
            $sheet->setCellValue("I{$contador}", 'Fec. Matricula');
            $sheet->setCellValue("J{$contador}", 'Último Ingreso');
            $sheet->setCellValue("K{$contador}", 'Unidad');
            $sheet->setCellValue("L{$contador}", 'Matricula');
            $sheet->setCellValue("M{$contador}", 'Estado');
            $sheet->setCellValue("N{$contador}", 'Edad');
            $sheet->setCellValue("O{$contador}", 'N° Docs. Cargados');
            $sheet->setCellValue("P{$contador}", 'Observaciones');
            $sheet->setCellValue("Q{$contador}", 'Link Foto');	        
            
            foreach($tipo as $list){
                $contador++;

                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("P{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("Q{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("C{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("D{$contador}", $list['dni_alumno']);
                $sheet->setCellValue("E{$contador}", $list['alum_apater']);
                $sheet->setCellValue("F{$contador}", $list['alum_amater']);
                $sheet->setCellValue("G{$contador}", $list['alum_nom']);
                $sheet->setCellValue("H{$contador}", $list['nombre_provincia']);
                if($list['fecha_matricula']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_matricula']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                $sheet->setCellValue("J{$contador}", $list['ultimo_ingreso']);

                if($list['modulo_sterminar']!="" && $list['modulo_terminado']!=""){
                    if($list['modulo_sterminar']>$list['modulo_terminado']){
                        $sheet->setCellValue("K{$contador}", $list['modulo_sterminar']);
                    }else{
                        $sheet->setCellValue("K{$contador}", $list['modulo_terminado']);
                    }
                }elseif($list['modulo_sterminar']=="" && $list['modulo_terminado']!=""){
                    $sheet->setCellValue("K{$contador}", $list['modulo_terminado']);
                }elseif($list['modulo_sterminar']!="" && $list['modulo_terminado']==""){
                    $sheet->setCellValue("K{$contador}", $list['modulo_sterminar']);
                }

                $sheet->setCellValue("L{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("M{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("N{$contador}", $list['alum_edad']);
                $sheet->setCellValue("O{$contador}", $list['cant_documento']);
                $sheet->setCellValue("P{$contador}", $list['observaciones']);
                if($list['link_foto']!=""){
                    $sheet->setCellValue("Q{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("Q{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("Q{$contador}", "");
                }
            }
        }elseif($parametro==3){
            $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos Todos (EP)');
            $sheet->setAutoFilter('A1:Q1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(50);
            $sheet->getColumnDimension('Q')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Creado Por');
            $sheet->setCellValue("K{$contador}", 'Departamento');
            $sheet->setCellValue("L{$contador}", 'Provincia');
            $sheet->setCellValue("M{$contador}", 'Edad');
            $sheet->setCellValue("N{$contador}", 'Matricula');
            $sheet->setCellValue("O{$contador}", 'Estado');
            $sheet->setCellValue("P{$contador}", 'Observaciones');
            $sheet->setCellValue("Q{$contador}", 'Link Foto');	   

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("O{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("Q{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                if($list['usuario_registro'] !='0' ) {
                    $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
                }else{ 
                    $sheet->setCellValue("J{$contador}", "Web");
                }
                $sheet->setCellValue("K{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("L{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("M{$contador}", $list['alum_edad']);
                $sheet->setCellValue("N{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("O{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("P{$contador}", $list['observaciones']);  
                if($list['link_foto']!=""){
                    $sheet->setCellValue("Q{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("Q{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("Q{$contador}", "");
                }  
            }
        }elseif($parametro==5){
            $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos en Seguimiento (EP)');
            $sheet->setAutoFilter('A1:P1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(50);
            $sheet->getColumnDimension('P')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Departamento');
            $sheet->setCellValue("K{$contador}", 'Provincia');
            $sheet->setCellValue("L{$contador}", 'Edad');
            $sheet->setCellValue("M{$contador}", 'Matricula');
            $sheet->setCellValue("N{$contador}", 'Estado');
            $sheet->setCellValue("O{$contador}", 'Observaciones');
            $sheet->setCellValue("P{$contador}", 'Link Foto');	   

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("N{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("P{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("P{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("L{$contador}", $list['alum_edad']);
                $sheet->setCellValue("M{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("N{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("O{$contador}", $list['observaciones']);    
                if($list['link_foto']!=""){
                    $sheet->setCellValue("P{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("P{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("P{$contador}", "");
                }  
            }
        }elseif($parametro==6){
            $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos en Admision (EP)');
            $sheet->setAutoFilter('A1:P1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(50);
            $sheet->getColumnDimension('P')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Departamento');
            $sheet->setCellValue("K{$contador}", 'Provincia');
            $sheet->setCellValue("L{$contador}", 'Edad');
            $sheet->setCellValue("M{$contador}", 'Matricula');
            $sheet->setCellValue("N{$contador}", 'Estado');
            $sheet->setCellValue("O{$contador}", 'Observaciones');
            $sheet->setCellValue("P{$contador}", 'Link Foto');	   

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("N{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("P{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("P{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("L{$contador}", $list['alum_edad']);
                $sheet->setCellValue("M{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("N{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("O{$contador}", $list['observaciones']); 
                if($list['link_foto']!=""){
                    $sheet->setCellValue("P{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("P{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("P{$contador}", "");
                }     
            }
        }elseif($parametro==7){
            $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $spreadsheet->getActiveSheet()->setTitle('Alumnos Sin Efecto (EP)');
            $sheet->setAutoFilter('A1:P1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(50);
            $sheet->getColumnDimension('P')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Departamento');
            $sheet->setCellValue("K{$contador}", 'Provincia');
            $sheet->setCellValue("L{$contador}", 'Edad');
            $sheet->setCellValue("M{$contador}", 'Matricula');
            $sheet->setCellValue("N{$contador}", 'Estado');
            $sheet->setCellValue("O{$contador}", 'Observaciones');
            $sheet->setCellValue("P{$contador}", 'Link Foto');	   

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("N{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("P{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("P{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("L{$contador}", $list['alum_edad']);
                $sheet->setCellValue("M{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("N{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("O{$contador}", $list['observaciones']);    
                if($list['link_foto']!=""){
                    $sheet->setCellValue("P{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("P{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("P{$contador}", "");
                }   
            }
        }elseif($parametro==8){
            $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $spreadsheet->getActiveSheet()->setTitle('Alumnos Matriculados (EP)');
            $sheet->setAutoFilter('A1:P1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(50);
            $sheet->getColumnDimension('P')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');       
            $sheet->setCellValue("B{$contador}", 'Código Arpay');           
            $sheet->setCellValue("C{$contador}", 'Grado');
            $sheet->setCellValue("D{$contador}", 'DNI');
            $sheet->setCellValue("E{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("F{$contador}", 'Ap. Materno');
            $sheet->setCellValue("G{$contador}", 'Nombre(s)');
            $sheet->setCellValue("H{$contador}", 'Provincia');
            $sheet->setCellValue("I{$contador}", 'Fecha Matricula');
            $sheet->setCellValue("J{$contador}", 'Ultimo Ingreso');
            $sheet->setCellValue("K{$contador}", 'Módulo');
            $sheet->setCellValue("L{$contador}", 'Matricula');
            $sheet->setCellValue("M{$contador}", 'Estado');
            $sheet->setCellValue("N{$contador}", 'N° Documentos');
            $sheet->setCellValue("O{$contador}", 'Observaciones');
            $sheet->setCellValue("P{$contador}", 'Link Foto');	   

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("O{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("P{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("P{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("C{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("D{$contador}", $list['dni_alumno']);
                $sheet->setCellValue("E{$contador}", $list['alum_apater']);
                $sheet->setCellValue("F{$contador}", $list['alum_amater']);
                $sheet->setCellValue("G{$contador}", $list['alum_nom']);
                $sheet->setCellValue("H{$contador}", $list['nombre_provincia']);
                if($list['fecha_matricula']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_matricula']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                $sheet->setCellValue("J{$contador}", $list['ultimo_ingreso']);
                
                if($list['modulo_sterminar']!="" && $list['modulo_terminado']!=""){
                    if($list['modulo_sterminar']>$list['modulo_terminado']){
                        $sheet->setCellValue("K{$contador}", $list['modulo_sterminar']);
                    }else{
                        $sheet->setCellValue("K{$contador}", $list['modulo_terminado']);
                    }
                }elseif($list['modulo_sterminar']=="" && $list['modulo_terminado']!=""){
                    $sheet->setCellValue("K{$contador}", $list['modulo_terminado']);
                }elseif($list['modulo_sterminar']!="" && $list['modulo_terminado']==""){
                    $sheet->setCellValue("K{$contador}", $list['modulo_sterminar']);
                }

                $sheet->setCellValue("L{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("M{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("N{$contador}", $list['cant_documento']);
                $sheet->setCellValue("O{$contador}", $list['observaciones']);   
                if($list['link_foto']!=""){
                    $sheet->setCellValue("P{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("P{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("P{$contador}", "");
                }
            }
        }elseif($parametro==9){
            $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Alumnos Graduados (EP)');
            $sheet->setAutoFilter('A1:Q1');

            $sheet->getColumnDimension('A')->setWidth(15);
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
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(50);
            $sheet->getColumnDimension('P')->setWidth(50);
            $sheet->getColumnDimension('Q')->setWidth(50);

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

            $contador=1;

            $sheet->setCellValue("A{$contador}", 'Foto');
            $sheet->setCellValue("B{$contador}", 'Código Snappy');
            $sheet->setCellValue("C{$contador}", 'Código Arpay');           
            $sheet->setCellValue("D{$contador}", 'Grado');
            $sheet->setCellValue("E{$contador}", 'Celular');
            $sheet->setCellValue("F{$contador}", 'Ap. Paterno');
            $sheet->setCellValue("G{$contador}", 'Ap. Materno');
            $sheet->setCellValue("H{$contador}", 'Nombre(s)');
            $sheet->setCellValue("I{$contador}", 'Fec. Registro');
            $sheet->setCellValue("J{$contador}", 'Creado Por');
            $sheet->setCellValue("K{$contador}", 'Departamento'); 
            $sheet->setCellValue("L{$contador}", 'Provincia');
            $sheet->setCellValue("M{$contador}", 'Edad');
            $sheet->setCellValue("N{$contador}", 'Matricula');
            $sheet->setCellValue("O{$contador}", 'Estado');
            $sheet->setCellValue("P{$contador}", 'Observaciones');
            $sheet->setCellValue("Q{$contador}", 'Link Foto');	    

            foreach($tipo as $list){
                $contador++;
            
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("P{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('1E88E5');
                $sheet->getStyle("Q{$contador}")->getFont()->setUnderline(true);  

                $sheet->setCellValue("A{$contador}", $list['foto']);
                $sheet->setCellValue("B{$contador}", $list['cod_alum']);
                $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
                $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
                $sheet->setCellValue("E{$contador}", $list['alum_celular']);
                $sheet->setCellValue("F{$contador}", $list['alum_apater']);
                $sheet->setCellValue("G{$contador}", $list['alum_amater']);
                $sheet->setCellValue("H{$contador}", $list['alum_nom']);
                if($list['fecha_registro']!="00/00/0000"){
                    $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
                }else{
                    $sheet->setCellValue("I{$contador}", "");
                }
                if($list['usuario_registro'] !='0' ) {
                    $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
                }else{ 
                    $sheet->setCellValue("J{$contador}", "Web");
                }
                $sheet->setCellValue("K{$contador}", $list['nombre_departamento']);
                $sheet->setCellValue("L{$contador}", $list['nombre_provincia']);
                $sheet->setCellValue("M{$contador}", $list['alum_edad']);
                $sheet->setCellValue("N{$contador}", $list['cant_matricula']);
                $sheet->setCellValue("O{$contador}", $list['nom_estadoa']);
                $sheet->setCellValue("P{$contador}", $list['observaciones']);    
                if($list['link_foto']!=""){
                    $sheet->setCellValue("Q{$contador}", base_url().$list['link_foto']);
                    $sheet->getCell("Q{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
                }else{
                    $sheet->setCellValue("Q{$contador}", "");
                }  
            }
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'Alumnos (Lista)';

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalles_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']=$id_alumno;
            $dato['get_id'] = $this->Model_Ceba2->get_detalle_alumno($id_alumno);
            $dato['get_id_alumno'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $id_grado=$dato['get_id_alumno'][0]['id_grados_activos'];
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            $dato['list_pago'] = $this->Model_Ceba2->get_pago_grado($id_alumno,$id_grado);
            $dato['list_producto'] = $this->Model_Ceba2->get_list_producto();
            $dato['list_estadop'] = $this->Model_Ceba2->get_list_estadop();
            
            $dato['anio']= date("Y");
            $dato['id_grado']=$dato['get_id_alumno'][0]['id_grados_activos'];
            $dato['edad']=$dato['get_id_alumno'][0]['alum_edad'];
            $dato['list_documentos']=$this->Model_Ceba2->list_documentos($dato);

            $dato['list_matricula'] = $this->Model_Ceba2->get_list_matricula_alumno($id_alumno);
            $dato['list_detalle_matricula'] = $this->Model_Ceba2->get_list_detalle_matricula_alumno($id_alumno);
            $dato['list_pago_matricula']=$this->Model_Ceba2->get_list_pago_matricula_alumno($id_alumno);

            $dato['get_foto'] = $this->Model_Ceba2->get_list_foto_matriculados($id_alumno);

            //$dato['list_notas'] = $this->Model_Ceba2->get_lista_nota($id_alumno);
            //$dato['list_tiempoxunidad'] = $this->Model_Ceba2->get_lista_tiempoxunidad($id_alumno);
            
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/alumno/detalles_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Vista_Update_Admision($id_alumno,$pg){
        if ($this->session->userdata('usuario')) {
            $dato['id_nivel'] = $_SESSION['usuario'][0]['id_nivel'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estadoa();
            $dato['pg']=$pg;    
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            $dato['list_tipo_obs'] = $this->Model_Ceba2->get_list_tipo_obs();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('ceba2/alumno/vista_editar_alumno',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumnos_Admision(){
        $dato['cod_arpay']=$this->input->post("cod_arpay"); 
        $dato['id_alumno']= $this->input->post("id_alumno"); 
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nom']= $this->input->post("alum_nom");
        $dato['id_estadoa']= $this->input->post("id_estadoa");
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['user_reg']= $this->input->post("user_reg");
        $dato['observaciones']= $this->input->post("observaciones");

        $dato['get_id'] =count($this->Model_Ceba2->get_pago_grado($dato['id_alumno'],$dato['id_grado']));
        
        if($dato['cod_arpay']!=""){
            $cant=count($this->Model_Ceba2->valida_cod_arpay($dato));
            if($cant>0){
                echo "error";
            }else{
                if($dato['id_estadoa']==7 && $dato['get_id']==0){
                    $this->Model_Ceba2->update_alumno_admision_pago($dato);
                }else{
                    $this->Model_Ceba2->update_alumno_admision($dato);
                }
            }
        }else{
            if($dato['id_estadoa']==7 && $dato['get_id']==0){
                $this->Model_Ceba2->update_alumno_admision_pago($dato);
            }else{
                $this->Model_Ceba2->update_alumno_admision($dato);
            }
        }
    }

    public function Vista_Update_Alumno($id_alumno,$pg){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_alumno($id_alumno);
            $dato['list_departamentoa'] = $this->Model_Ceba2->get_list_departamento();
           // $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provincia();
            $dato['pg']=$pg;
            $id_departamentoa=$dato['get_id'][0]['id_departamentoa'];
            $id_provinciaa=$dato['get_id'][0]['id_provinciaa'];
            $id_departamentop=$dato['get_id'][0]['id_departamentop'];
            $id_provinciap=$dato['get_id'][0]['id_provinciap'];
            $dato['list_provinciaa'] = $this->Model_Ceba2->get_list_provinciaa($id_departamentoa);
            $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distritoa($id_departamentoa,$id_provinciaa);

            $dato['list_provinciap'] = $this->Model_Ceba2->get_list_provinciap($id_departamentop);
            $dato['list_distritop'] = $this->Model_Ceba2->get_list_distritop($id_departamentop,$id_provinciap);
           // $dato['list_distritoa'] = $this->Model_Ceba2->get_list_distrito();
            $dato['list_grado_escuela'] = $this->Model_Ceba2->get_list_grado_escuela();//
            $dato['list_grado_activo'] = $this->Model_Ceba2->get_list_grado();//
            //$dato['list_estado'] = $this->Model_Ceba2->get_list_estadoa_retiro();
            $estado=$dato['get_id'][0]['estado_alum'];
            if($estado==2){
                $dato['list_estado'] = $this->Model_Ceba2->get_list_estadoa_matirculado();
            }else{
                $dato['list_estado'] = $this->Model_Ceba2->get_list_estadoa();
            }
            
            $dato['list_medios'] = $this->Model_Ceba2->get_list_medios();//
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            $dato['list_tipo_obs'] = $this->Model_Ceba2->get_list_tipo_obs();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/alumno/vista_editar_alumno_matriculado',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumnos(){
        $dato['id_alumno']= $this->input->post("id_alumno"); 
        $dato['dni_alumno']= $this->input->post("dni_alumno");
        $dato['cod_arpay']= $this->input->post("cod_arpay");
        $dato['alum_nom']= $this->input->post("alum_nom");
        $dato['alum_apater']= $this->input->post("alum_apater");
        $dato['alum_amater']= $this->input->post("alum_amater");
        $dato['alum_nacimiento']= $this->input->post("alum_nacimiento");
        $dato['alum_edad']= $this->input->post("alum_edad");
        $dato['alum_sexo']= $this->input->post("alum_sexo");
        $dato['alum_direc']= $this->input->post("alum_direc");
        $dato['id_departamentoa']= $this->input->post("id_departamentoa");
        $dato['id_provinciaa']= $this->input->post("id_provinciaa");
        $dato['id_distritoa']= $this->input->post("id_distritoa");
        $dato['alum_celular']= $this->input->post("alum_celular");
        $dato['alum_telf_casa']= $this->input->post("alum_telf_casa");
        $dato['correo']= $this->input->post("correo");
        $dato['alumno_institucionp']= $this->input->post("alumno_institucionp");
        $dato['id_departamentop']= $this->input->post("id_departamentop");
        $dato['id_provinciap']= $this->input->post("id_provinciap");
        $dato['id_distritop']= $this->input->post("id_distritop");
        $dato['id_gradop']= $this->input->post("id_gradop");
        $dato['titular1_dni']= $this->input->post("titular1_dni");
        $dato['titular1_parentesco']= $this->input->post("titular1_parentesco");
        $dato['titular1_apater']= $this->input->post("titular1_apater");
        $dato['titular1_amater']= $this->input->post("titular1_amater");
        $dato['titular1_nom']= $this->input->post("titular1_nom");
        $dato['titular1_celular']= $this->input->post("titular1_celular");
        $dato['titular1_telf_casa']= $this->input->post("titular1_telf_casa");
        $dato['titular2_dni']= $this->input->post("titular2_dni");
        $dato['titular2_parentesco']= $this->input->post("titular2_parentesco");
        $dato['titular2_apater']= $this->input->post("titular2_apater");
        $dato['titular2_amater']= $this->input->post("titular2_amater");
        $dato['titular2_nom']= $this->input->post("titular2_nom");
        $dato['titular2_celular']= $this->input->post("titular2_celular");
        $dato['titular2_telf_casa']= $this->input->post("titular2_telf_casa");
        $dato['id_grados_activos']= $this->input->post("id_grados_activos");
        $dato['tipo']= $this->input->post("tipo");
        $dato['estado']= $this->input->post("id_estadoa");
        $dato['motivo_estado']= $this->input->post("motivo_estado");
        $dato['id_medios']= $this->input->post("id_medios");
        $dato['id_grado']= $this->input->post("id_grados_activos");
        
        $cant=count($this->Model_Ceba2->valida_cod_arpay($dato));

        if($cant>0 && $dato['cod_arpay']!=""){
            echo "error";
        }else{
            $dato['get_id'] =count($this->Model_Ceba2->get_pago_grado($dato['id_alumno'],$dato['id_grado']));
            $this->Model_Ceba2->update_alumno($dato);
            
            $this->Model_Ceba2->update_estado_unidad_alumno($dato);
        }
    }

    public function Lista_Documento_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_documento']=$this->Model_Ceba2->get_list_documento_alumno($dato['id_alumno']);
            $this->load->view('ceba2/alumno/lista_documentos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento_Alumno($id_documento,$id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['get_documento'] = $this->Model_Ceba2->get_list_documento($id_documento);
            $dato['id_documento'] = $id_documento;
            $dato['id_alumno'] = $id_alumno;
            $this->load->view('ceba2/alumno/modal_registrar_documento', $dato);   
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
            $config['upload_path'] = './documento_alumno_ep1/'.$dato['id_documento'].'/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_ep1/', 0777);
                chmod('./documento_alumno_ep1/'.$dato['id_documento'].'/', 0777);
                chmod('./documento_alumno_ep1/'.$dato['id_documento'].'/'.$dato['id_alumno'], 0777);
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
                $dato['archivo'] = "documento_alumno_ep1/".$dato['id_documento']."/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_Ceba2->insert_documento_alumno_empresa($dato);
    }

    public function Modal_Update_Documento_Alumno($id_detalle){
        if ($this->session->userdata('usuario')) {
            $dato['get_detalle'] = $this->Model_Ceba2->get_id_detalle_alumno_empresa($id_detalle);
            $dato['get_documento'] = $this->Model_Ceba2->get_list_documento( $dato['get_detalle'][0]['id_documento']);
            $this->load->view('ceba2/alumno/modal_editar_documento', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento_Alumno(){
        $dato['id_detalle']= $this->input->post("id_detalle");
        $get_id = $this->Model_Ceba2->get_id_detalle_alumno_empresa($dato['id_detalle']);
        $dato['id_alumno'] = $get_id[0]['id_alumno'];
        $dato['archivo'] = $this->input->post("archivo_actual");

        $id_documento = $get_id[0]['id_documento'];

        if($_FILES["archivo_u"]["name"] != ""){
            if (file_exists($dato['archivo'])) { 
                unlink($dato['archivo']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
            $config['upload_path'] = './documento_alumno_ep1/'.$id_documento.'/'.$dato['id_alumno'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_alumno_ep1/'.$id_documento, 0777);
                chmod('./documento_alumno_ep1/'.$id_documento.'/', 0777);
                chmod('./documento_alumno_ep1/'.$id_documento.'/'.$dato['id_alumno'], 0777);
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
                $dato['archivo'] = "documento_alumno_ep1/".$id_documento."/".$dato['id_alumno']."/".$dato['nom_documento'];
            }     
        }
        $this->Model_Ceba2->update_documento_alumno($dato);
    }

    public function Descargar_Imagen($id_detalle){ 
        if ($this->session->userdata('usuario')) {
            $dato['doc']=$this->Model_Ceba2->get_id_detalle_alumno_empresa($id_detalle);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen,NULL);
        }else{
            redirect('');
        }
    }

    public function Delete_Documento_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post("id_detalle");
            $dato['doc']=$this->Model_Ceba2->get_id_detalle_alumno_empresa($dato['id_detalle']);
            unlink($dato['doc'][0]['archivo']);
            $this->Model_Ceba2->delete_documento_alumno($dato); 
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Documento_Alumno($id_alumno){
        $list_documento = $this->Model_Ceba2->get_list_documento_alumno($id_alumno);

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

    public function Excel_Detalle_Alumno($id_alumno){
        $tipo = $this->Model_Ceba2->get_detalle_alumno($id_alumno);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:E10")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:E10")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle de Alumno');

        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(19);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->getColumnDimension('L')->setWidth(8.5);

        $sheet->getStyle("A2:A10")->getFont()->setBold(true);
        $sheet->getStyle("D3:D10")->getFont()->setBold(true);

        $sheet->setCellValue("A2", 'Código Snappy'); 
        $sheet->setCellValue("A3", 'Código Arpay');           
        $sheet->setCellValue("D3", 'DNI');
        $sheet->setCellValue("A4", 'Apellido Paterno');
        $sheet->setCellValue("D4", 'Apellido Materno');
        $sheet->setCellValue("A5", 'Nombres');
        $sheet->setCellValue("D5", 'Fecha de Nacimiento');
        $sheet->setCellValue("A6", 'Edad');
        $sheet->setCellValue("D6", 'Celular');
        $sheet->setCellValue("A7", 'Contacto');
        $sheet->setCellValue("D7", 'Departamento');
        $sheet->setCellValue("A8", 'Provincia');
        $sheet->setCellValue("D8", 'Distrito');
        $sheet->setCellValue("A9", 'Estado');
        $sheet->setCellValue("D9", 'Último Ingreso');
        $sheet->setCellValue("A10", 'Unidad');
        $sheet->setCellValue("D10", 'Salón');

        $sheet->setCellValue("B2", $tipo[0]['cod_alum']);
        $sheet->setCellValue("B3", $tipo[0]['cod_arpay']);
        $sheet->setCellValue("E3", $tipo[0]['dni_alumno']);
        $sheet->setCellValue("B4", $tipo[0]['alum_apater']);
        $sheet->setCellValue("E4", $tipo[0]['alum_amater']);
        $sheet->setCellValue("B5", $tipo[0]['alum_nom']);
        $sheet->setCellValue("E5", $tipo[0]['alum_nacimiento']);
        $sheet->setCellValue("B6", $tipo[0]['alum_edad']);
        $sheet->setCellValue("E6", $tipo[0]['alum_celular']);
        $sheet->setCellValue("B7", $tipo[0]['alum_cellcontac']);
        $sheet->setCellValue("E7", $tipo[0]['nombre_departamento']);
        $sheet->setCellValue("B8", $tipo[0]['nombre_provincia']);
        $sheet->setCellValue("E8", $tipo[0]['nombre_distrito']);
        $sheet->setCellValue("B9", $tipo[0]['nom_estadoa']);
        $sheet->setCellValue("E9", 'Pendiente');
        $sheet->setCellValue("B10", $tipo[0]['nom_unidad']);
        $sheet->setCellValue("E10", 'Pendiente');

        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle_Alumno';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Pdf_Hoja_Matricula_Completo($id_matricula){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_matricula_alumno($id_matricula);
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('ceba2/alumno/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Descargar_Foto_Matriculados($id_detalle) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ceba2->get_id_detalle_alumno_empresa($id_detalle);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }
    
    public function Lista_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['list_observacion']=$this->Model_Ceba2->get_list_observacion_alumno($dato['id_alumno']);
            $this->load->view('ceba2/alumno/lista_observacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_tipo_obs'] = $this->Model_Ceba2->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_Ceba2->get_list_usuario_observacion();
            $this->load->view('ceba2/alumno/registrar_observacion',$dato);
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
    
            $valida = $this->Model_Ceba2->valida_insert_observacion_alumno($dato);
    
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->insert_observacion_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $dato['get_id']=$this->Model_Ceba2->get_list_observacion_alumno(null,$dato['id_observacion']);
            $dato['list_tipo_obs'] = $this->Model_Ceba2->get_list_tipo_obs();
            $dato['list_usuario'] = $this->Model_Ceba2->get_list_usuario_observacion();
            $this->load->view('ceba2/alumno/editar_observacion',$dato);
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

            $valida = $this->Model_Ceba2->valida_update_observacion_alumno($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->update_observacion_alumno($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Observacion_Alumno() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_observacion'] = $this->input->post("id_observacion");
            $this->Model_Ceba2->delete_observacion_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Observacion_Alumno($id_alumno){
        $list_observacion = $this->Model_Ceba2->get_list_observacion_alumno($id_alumno);

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
    //-----------------------------------CURSO-------------------------------------
    public function Curso() {
        if ($this->session->userdata('usuario')) {
            $dato['list_curso'] = $this->Model_Ceba2->get_list_curso();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/curso/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Curso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_curso_copiar'] = $this->Model_Ceba2->get_combo_curso();
            
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/curso/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Curso_Copiar(){
        if ($this->session->userdata('usuario')) {
            $dato['id_copiar']= $this->input->post("id_copiar"); 
            $dato['get_id'] = $this->Model_Ceba2->get_id_curso($dato['id_copiar']);
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_curso_copiar'] = $this->Model_Ceba2->get_combo_curso();

            $this->load->view('ceba2/academico/curso/curso_copiar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Curso(){
        $dato['id_copiar']= $this->input->post("id_copiar"); 
        $dato['grupo']= $this->input->post("grupo"); 
        $dato['unidad']= $this->input->post("unidad");  
        $dato['turno']= $this->input->post("turno"); 
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_anio']= $this->input->post("id_anio"); 
        $dato['fec_inicio']= $this->input->post("fec_inicio");
        $dato['fec_fin']= $this->input->post("fec_fin");
        $dato['inicio_curso']= $this->input->post("inicio_curso");
        $dato['fin_curso']= $this->input->post("fin_curso");
        $this->Model_Ceba2->insert_curso($dato);
    }

    public function Excel_Curso(){
        $tipo = $this->Model_Ceba2->get_list_curso();

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
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(25);

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
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:P{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['descripcion_grado']);
            $sheet->setCellValue("B{$contador}", $list['nom_anio']);
            //$sheet->setCellValue("C{$contador}", $list['fec_inicio']);
            $sheet->setCellValue("C{$contador}",  Date::PHPToExcel($list['fec_inicio']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            //$sheet->setCellValue("D{$contador}", $list['fec_fin']);
            $sheet->setCellValue("D{$contador}",  Date::PHPToExcel($list['fec_fin']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            $sheet->setCellValue("E{$contador}", $list['cant_registrado']);
            $sheet->setCellValue("F{$contador}", $list['cant_matriculado']);
            $sheet->setCellValue("G{$contador}", $list['cant_activo']);
            $sheet->setCellValue("H{$contador}", $list['cant_asistiendo']);
            $sheet->setCellValue("I{$contador}", $list['cant_ppendiente']);
            $sheet->setCellValue("J{$contador}", $list['cant_sinasistir']);
            $sheet->setCellValue("K{$contador}", $list['cant_pmatricula']);
            $sheet->setCellValue("L{$contador}", $list['cant_finalizados']);
            $sheet->setCellValue("M{$contador}", $list['cant_retirado']);
            $sheet->setCellValue("N{$contador}", $list['cant_anulado']);
            $sheet->setCellValue("O{$contador}", $list['obs_curso']);
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

    public function Detalles_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_curso($id_curso);
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();
            $dato['list_requisito_curso'] = $this->Model_Ceba2->get_list_requisito_curso($id_curso);
            $dato['list_tema_asociar_curso'] = $this->Model_Ceba2->get_list_tema_asociar_curso($id_curso);
            $dato['list_alumno_asociar_curso'] = $this->Model_Ceba2->get_list_alumno_asociar_curso($id_curso);

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/curso/detalles_curso',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_curso($id_curso);
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_anio'] = $this->Model_Ceba2->get_list_anio();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();
            
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/curso/editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Curso(){
        $dato['id_curso']= $this->input->post("id_curso"); 
        $dato['grupo']= $this->input->post("grupo"); 
        $dato['unidad']= $this->input->post("unidad"); 
        $dato['turno']= $this->input->post("turno");
        $dato['id_anio']= $this->input->post("id_anio"); 
        $dato['id_grado']= $this->input->post("id_grado"); 
        $dato['fec_inicio']= $this->input->post("fec_inicio");
        $dato['fec_fin']= $this->input->post("fec_fin");
        $dato['inicio_curso']= $this->input->post("inicio_curso");
        $dato['fin_curso']= $this->input->post("fin_curso");
        $dato['id_status']= $this->input->post("id_status");   
        $this->Model_Ceba2->update_curso($dato); 
    }

    public function Modal_Requisito($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['id_curso']= $id_curso;
            $dato['grado'] = $this->Model_Ceba2->get_list_grado_x_curso($id_curso);
            $dato['list_tipo_requisito'] = $this->Model_Ceba2->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/curso/requisito_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Requisito(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito");
        $dato['id_status']= $this->input->post("id_status");
        $this->Model_Ceba2->insert_requisito($dato);  
    }

    public function Modal_Update_Requisito($id_requisito){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_requisito($id_requisito);
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['id_tipo_requisito'] = $this->Model_Ceba2->get_list_tipo_requisito();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/curso/requisito_editar',$dato);   
        }else{
            redirect('/login');
        }
    }  

    public function Update_Requisito(){
        $dato['id_requisito']= $this->input->post("id_requisito");
        $dato['id_tipo_requisito']= $this->input->post("id_tipo_requisito"); 
        $dato['desc_requisito']= $this->input->post("desc_requisito");
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Model_Ceba2->update_requisito($dato);  
    }

    public function Modal_Tema_Asociar($id_curso){
        if ($this->session->userdata('usuario')) {
            $get_id = $this->Model_Ceba2->get_id_curso($id_curso);
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_unidad();
            $dato['list_area'] = $this->Model_Ceba2->get_list_area_combo();
            $dato['list_profesor'] = $this->Model_Ceba2->get_list_profesor_combo();
            $dato['id_curso']= $id_curso;
            $dato['id_grado'] = $get_id[0]['id_grado'];
            $this->load->view('ceba2/academico/curso/modal_tema_asociar_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Area_Asignatura() {
        if ($this->session->userdata('usuario')) {
            $id_area= $this->input->post("id_area");
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_dependencia_asignatura($id_area);
            $this->load->view('ceba2/academico/curso/asignaturas', $dato);
        }else{
            redirect('');
        }
    }

    public function Varios_Tema() {
        if ($this->session->userdata('usuario')) {
            $id_unidad = $this->input->post("id_unidad");
            $id_area = $this->input->post("id_area");
            $id_asignatura = $this->input->post("id_asignatura");
            $id_grado = $this->input->post("id_grado");
            $dato['list_tema'] = $this->Model_Ceba2->varios_tema($id_unidad,$id_area,$id_asignatura,$id_grado);
            $this->load->view('ceba2/academico/curso/temas',$dato);
        }else{
            redirect('');
        }
    }
    
    public function Insert_Tema_Asociar(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['id_tema']= $this->input->post("id_tema");
        $dato['id_area']= $this->input->post("id_area");
        $dato['id_asignatura']= $this->input->post("id_asignatura"); 
        $dato['id_profesor']= $this->input->post("id_profesor"); 
        $this->Model_Ceba2->insert_tema_asociar($dato);
    }

    public function Modal_Tema_Asociar_Editar($id_tema_asociar){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema_asociar($id_tema_asociar);
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_unidad();
            $get_curso = $this->Model_Ceba2->get_id_curso($dato['get_id'][0]['id_curso']);
            $dato['list_tema'] = $this->Model_Ceba2->varios_tema($dato['get_id'][0]['id_unidad'],$dato['get_id'][0]['id_area'],$dato['get_id'][0]['id_asignatura'],$get_curso[0]['id_grado']);
            $dato['list_area'] = $this->Model_Ceba2->get_list_area_combo();
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_dependencia_asignatura($dato['get_id'][0]['id_area']);
            $dato['list_profesor'] = $this->Model_Ceba2->get_list_profesor_combo();
            $dato['id_grado'] = $get_curso[0]['id_grado'];
            $this->load->view('ceba2/academico/curso/modal_tema_asociar_actualizar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Tema_Asociar(){
        $dato['id_tema_asociar']= $this->input->post("id_tema_asociar");
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_area']= $this->input->post("id_area");
        $dato['id_asignatura']= $this->input->post("id_asignatura"); 
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['id_tema']= $this->input->post("id_tema");
        $dato['id_profesor']= $this->input->post("id_profesor"); 
        $this->Model_Ceba2->update_tema_asociar($dato);
    }

    public function Modal_Alumno_Curso($id_curso){
        if ($this->session->userdata('usuario')) {
            $dato['id_curso'] = $id_curso;
            $dato['list_alumno'] = $this->Model_Ceba2->get_list_alumno();
            $this->load->view('ceba2/academico/curso/modal_registrar_alumno_curso',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno_Curso(){
        $dato['id_curso']= $this->input->post("id_curso");
        $dato['id_alumno']= $this->input->post("id_alumno");

        $validar = $this->Model_Ceba2->valida_insert_alumno_curso($dato); 

        if(count($validar)>0){
            echo "error";
        }else{
            $this->Model_Ceba2->insert_alumno_curso($dato); 
        }
    }

    public function Cerrar_Curso(){
        if ($this->session->userdata('usuario')) {
            $id_curso =$this->input->post("id_curso");

            $total=count($this->Model_Ceba2->valida_cerrar_curso($id_curso));

            if($total>0){
                echo "error";
            }
            else{
                $this->Model_Ceba2->cerrar_curso($id_curso);
            }  
        }else{
            redirect('/login');
        } 
    }
    //-----------------------------------TEMA-------------------------------------
    public function Temas(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/temas/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function BuscadorC(){
        if ($this->session->userdata('usuario')) {
            $dato['parametro']=$this->input->post("parametro");
            $dato['suma_slide'] = $this->Model_Ceba2->v_suma_tiempo_slide();
            $dato['suma_repaso'] = $this->Model_Ceba2->v_suma_tiempo_repaso();
            $dato['suma_slide_repaso'] = $this->Model_Ceba2->v_suma_tiempo_slide_repaso();
            $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_final();
            
            $dato['list_secundaria'] = $this->Model_Ceba2->get_list_tema_grado($dato['parametro']);
            
            $this->load->view('ceba2/academico/temas/lista_temas', $dato);
        }
        else{
            redirect('');
        }
    }

    public function Revisado_Tema() {
        if ($this->session->userdata('usuario')) { 
            $dato['id']=$this->input->post("id");
            $id_grado=$this->input->post("id_grado");

            $id_tema=$this->input->post("id");
            $tema=$this->Model_Ceba2->get_id_tema_revisado($id_tema);

            if($tema[0]['fec_revisado']=="0000-00-00" && $tema[0]['user_revisado']==0){
                $this->Model_Ceba2->cambiar_revisado_tema($dato);
            }else{
                $this->Model_Ceba2->borrar_revisado_tema($dato);
            }

            $dato['list_secundaria'] = $this->Model_Ceba2->get_list_tema_grado($id_grado);

            $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_final();

            $dato['parametro']=$this->input->post("id_grado");

            $this->load->view('ceba2/academico/temas/cambiar_revisado', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Tema(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_area'] = $this->Model_Ceba2->get_list_area_combo();
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_unidad();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/temas/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Dependencia_Asignatura() {
        if ($this->session->userdata('usuario')) {
            $id_area= $this->input->post("id_area");
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_dependencia_asignatura($id_area);
            $this->load->view('dependencias/asignatura', $dato);
        }else{
            redirect('');
        }
    }

    public function Insert_Tema(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_area']= $this->input->post("id_area");
            $dato['id_asignatura']= $this->input->post("id_asignatura");
            $dato['id_unidad']= $this->input->post("id_unidad"); 
            $dato['referencia']= $this->input->post("referencia"); 
            $dato['id_status']= $this->input->post("id_status");
            $dato['desc_tema']= $this->input->post("desc_tema");
            $this->Model_Ceba2->insert_tema($dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Tema($id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_temas($id_tema);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_area'] = $this->Model_Ceba2->get_list_area();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado();
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_dependencia_asignatura($dato['get_id'][0]['id_area']);
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_unidad();

            $this->load->view('ceba2/academico/temas/upd_modal_tema', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Tema(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema']= $this->input->post("id_tema");
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['id_area']= $this->input->post("id_area");
            $dato['id_asignatura']= $this->input->post("id_asignatura"); 
            $dato['id_unidad']= $this->input->post("id_unidad");
            $dato['referencia']= $this->input->post("referencia");
            $dato['desc_tema']= $this->input->post("desc_tema");
            $dato['id_status']= $this->input->post("id_status");
            $this->Model_Ceba2->update_tema($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Delete_Tema(){
        if ($this->session->userdata('usuario')) {
            $id_tema =$this->input->post("id_tema");
            $this->Model_Ceba2->delete_tema($id_tema);
        }else{
            redirect('/login');
        } 
    }

    public function Modal_Intro(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/temas/modal_intro_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Grado_Tema($id_grado="0") {
        if ($this->session->userdata('usuario')) {
            $id_grado= $this->input->post("id_grado");
            $dato['list_tema'] = $this->Model_Ceba2->grado_tema($id_grado);
            $this->load->view('ceba2/academico/temas/temas',$dato);
        }else{
            redirect('');
        }
    }

    public function Dependencia_Area() {
        if ($this->session->userdata('usuario')) {
            $tema= $this->input->post("referencia");
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($tema);
            $this->load->view('dependencias/area',$dato);
        }else{
            redirect('');
        }
    }

    public function Valida_Insert_Intro(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['orden']= $this->input->post("orden"); 
        $dato['id_status']= $this->input->post("id_status");
        
        $total=count($this->Model_Ceba2->valida_reg_intro($dato));
        
        if($total>0){
            echo "error";
        }
    }
    
    public function Insert_Intro_Index(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['get_area'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['id_area']=$dato['get_area'][0]['id_area'];
        $dato['id_unidad']=$dato['get_area'][0]['id_unidad'];
        
        $dato['id_asignatura']= $this->input->post("id_asignatura");
        $dato['id_tipo']=1;
        $dato['orden']= $this->input->post("orden"); 
        $dato['estado']= $this->input->post("estado"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['foto']= $this->input->post("fotoimg");
        $dato['foto2']= $this->input->post("foto2");
        $dato['foto3']= $this->input->post("foto3");

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
        
        $this->Model_Ceba2->insert_intro($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Slide(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo_slide'] = $this->Model_Ceba2->get_list_tipo_slide();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();
            $this->load->view('ceba2/academico/temas/modal_slide_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Valida_Insert_Slide(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_slide']= $this->input->post("id_tipo_slide");
        $dato['orden']= $this->input->post("orden");
        $dato['tiempo']= $this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['imagen_sl']= $this->input->post("imagen_sl");

        $total=count($this->Model_Ceba2->valida_reg_slide($dato));

        if($total>13){
            echo "error";
        }
    }

    public function Insert_Slide(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_slide']= $this->input->post("id_tipo_slide");
        $dato['orden']= $this->input->post("orden");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['tiempo']= "00:".$this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['imagen_sl']= $this->input->post("imagen_sl");
        
        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['id_unidad'] = $dato['get_tema'][0]['id_unidad'];
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_tema'][0]['tiempo_archivos'];
        $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];

        $this->Model_Ceba2->insert_slide($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Repaso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/temas/modal_repaso_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Valida_Insert_Repaso(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['orden']= $this->input->post("orden");
        $dato['tiempo']= $this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['imagen']= $this->input->post("imagen");

        $total=count($this->Model_Ceba2->valida_reg_repaso($dato));

        if($total>0){
            echo "error";
        }
    }

    public function Insert_Repaso(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['orden']= $this->input->post("orden");
        $dato['tiempo']= "00:".$this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['imagen']= $this->input->post("imagen");
        $dato['id_tipo']= 1;
        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['id_unidad'] = $dato['get_tema'][0]['id_unidad'];
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_tema'][0]['tiempo_archivos'];
        $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];

        $this->Model_Ceba2->insert_repaso($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Examen(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['tipo_examen'] = $this->Model_Ceba2->get_list_tipo_examen();
            $this->load->view('ceba2/academico/temas/modal_examen_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Valida_Insert_Examen_Index(){
        $dato['id_grado']= $this->input->post("grado");
        $dato['id_tema']= $this->input->post("referencia");
        $dato['id_unidad']= $this->input->post("id_unidad");

        $total=count($this->Model_Ceba2->valida_reg_examen_v2($dato));

        if($total>14){
            echo "error";
        }
    }

    public function Insert_Examen(){
        $dato['id_grado']= $this->input->post("grado");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_examen']= $this->input->post("id_tipo_examen");
        $dato['orden']= $this->input->post("orden"); 
        $dato['tiempo']= $this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['foto1']= $this->input->post("foto1");
        $dato['pregunta']= $this->input->post("pregunta");
        $dato['alternativa1']= $this->input->post("alternativa1"); 
        $dato['alternativa2']= $this->input->post("alternativa2");
        $dato['alternativa3']= $this->input->post("alternativa3");
        $dato['respuesta']= $this->input->post("respuesta");

        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];

        $this->Model_Ceba2->insert_examen($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Excel_Tema_Parametro(){
        $parametro= $this->input->post("parametro");
        $tipo = $this->Model_Ceba2->excel_temas_parametro($parametro);
        $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_slide_repaso();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        if($parametro ==1 || $parametro==0){
            $spreadsheet->getActiveSheet()->setTitle('Primero_secundaria');
        }if($parametro ==2 ){
            $spreadsheet->getActiveSheet()->setTitle('Segundo_secundaria');
        }if($parametro ==3){
            $spreadsheet->getActiveSheet()->setTitle('Tercero_secundaria');
        }if($parametro ==4){
            $spreadsheet->getActiveSheet()->setTitle('Cuarto_secundaria');
        }if($parametro ==5){
            $spreadsheet->getActiveSheet()->setTitle('Temas_Inactivos');
        }

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setWidth(5);
        $sheet->getColumnDimension('H')->setWidth(5);
        $sheet->getColumnDimension('I')->setWidth(5);
        $sheet->getColumnDimension('J')->setWidth(5);
        $sheet->getColumnDimension('K')->setWidth(5);
        $sheet->getColumnDimension('L')->setWidth(20);
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

        $sheet->getStyle("A1:M1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Grado');           
        $sheet->setCellValue("B1", 'Unidad');
        $sheet->setCellValue("C1", 'Referencia');
        $sheet->setCellValue("D1", 'Área');
        $sheet->setCellValue("E1", 'Asignatura');
        $sheet->setCellValue("F1", 'Tema');
        $sheet->setCellValue("G1", 'IT');
        $sheet->setCellValue("H1", 'IM');
        $sheet->setCellValue("I1", 'VD');
        $sheet->setCellValue("J1", 'RP');
        $sheet->setCellValue("K1", 'EX');
        $sheet->setCellValue("L1", 'Tiempo');
        $sheet->setCellValue("M1", 'Estado');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $it=0;
            $im=0;
            $vd=0;
            $rp=0;
            $ex=0;

            if($list['total_intros']!=0){
                $it=$list['total_intros'];
            }
            if($list['t_img']!=0){
                $im=$list['t_img'];
            }
            if($list['t_video']!=0){
                $vd=$list['t_video'];
            }
            if($list['cant_repaso']!=0){
                $rp=$list['cant_repaso'];
            }
            if($list['cant_examenes']!=0){
                $ex=$list['cant_examenes'];
            }
            
            $sheet->setCellValue("A{$contador}", $list['descripcion_grado']);
            $sheet->setCellValue("B{$contador}", $list['nom_unidad']);
            $sheet->setCellValue("C{$contador}", $list['referencia']);
            $sheet->setCellValue("D{$contador}", $list['descripcion_area']);
            $sheet->setCellValue("E{$contador}", $list['descripcion_asignatura']);
            $sheet->setCellValue("F{$contador}", $list['desc_tema']);
            $sheet->setCellValue("G{$contador}", $it);
            $sheet->setCellValue("H{$contador}", $im);
            $sheet->setCellValue("I{$contador}", $vd);
            $sheet->setCellValue("J{$contador}", $rp);
            $sheet->setCellValue("K{$contador}", $ex);
            foreach($dato['suma_total'] as $total) {
                if($list['id_tema']==$total['id_tema']){
                    $sheet->setCellValue("L{$contador}", substr($total['total'],0,8)." + 30 min");
                }  }
            if($list['estado_contenido']==1){
                $sheet->setCellValue("M{$contador}", "Activo");
            }if($list['estado_contenido']==2){
                $sheet->setCellValue("M{$contador}", "Pendiente");
            }if($list['estado_contenido']==0){
                $sheet->setCellValue("M{$contador}", "Pendiente");
            }
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'Temas (Lista)';

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 

    }

    public function Modal_Tema_View1($id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_temas($id_tema);
            $dato['get_intro'] = $this->Model_Ceba2->get_intro_tema($id_tema);
            $dato['get_slide'] = $this->Model_Ceba2->get_slide_tema($id_tema);
            $dato['get_repaso'] = $this->Model_Ceba2->get_repaso_tema($id_tema);
            $dato['get_examen'] = $this->Model_Ceba2->get_examen_tema($id_tema);
            $dato['suma_slide'] = $this->Model_Ceba2->v_suma_tiempo_slide();
            $dato['suma_repaso'] = $this->Model_Ceba2->v_suma_tiempo_repaso();
            $dato['suma_slide_repaso'] = $this->Model_Ceba2->v_suma_tiempo_slide_repaso();
            $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_slide_repaso();
            $dato['peso_slide'] = $this->Model_Ceba2->v_peso_slide($id_tema);
            $dato['peso_repaso'] = $this->Model_Ceba2->v_peso_repaso($id_tema);
            $dato['peso_intro'] = $this->Model_Ceba2->peso_intro($id_tema);
            $dato['peso_examen'] = $this->Model_Ceba2->peso_examen($id_tema);

            if(count($dato['peso_slide'])>0){
                $dato['sum_slide']=$dato['peso_slide'][0]['total_slide'];
            }else{
                $dato['sum_slide']='0';
            }
            if(count($dato['peso_repaso'])>0){
                $dato['sum_repaso']=$dato['peso_repaso'][0]['total_repaso'];
            }else{
                $dato['sum_repaso']='0';
            }
            if(count($dato['peso_examen'])>0){
                $dato['sum_examen']=$dato['peso_examen'][0]['total_examen'];
            }else{
                $dato['sum_examen']='0';
            }
            if(count($dato['peso_intro'])>0){
                $dato['sum_intro']=$dato['peso_intro'][0]['total_intro'];
            }else{
                $dato['sum_intro']='0';
            }
            $dato['peso_total']=$dato['sum_slide']+$dato['sum_repaso']+$dato['sum_intro'];

            $dato['get_link'] = $this->Model_Ceba2->get_config();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/temas/detalle_tema/index', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Modal_Detalle_Intro($id_tema,$id_grado,$id_area){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema'] = $id_tema;
            $dato['id_grado'] = $id_grado;
            $dato['id_area'] = $id_area;
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();
            $this->load->view('ceba2/academico/temas/detalle_tema/modal_intro_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Intro_Detalle(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_area']= $this->input->post("id_area");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_asignatura']= $this->input->post("id_asignatura");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['orden']= $this->input->post("orden"); 
        $dato['id_status']= $this->input->post("id_status");
        $dato['foto']= $this->input->post("fotoimg");
        $dato['foto2']= $this->input->post("foto2");
        $dato['foto3']= $this->input->post("foto3");

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
        $this->Model_Ceba2->insert_intro($dato);

        //$i=0;
        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }

        redirect('Ceba/Modal_Tema_View1/'.$dato['referencia']);
    }

    public function Modal_Update_Intro($id_intro,$id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema']=$id_tema;
            $dato['get_id'] = $this->Model_Ceba2->get_id_intro($id_intro);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();

            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);

            $this->load->view('ceba2/academico/temas/detalle_tema/upd_modal_intro', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Intro(){
        $dato['id_intro']= $this->input->post("id_intro");
        $dato['referencia']= $this->input->post("id_tema");
        $dato['id_status']= $this->input->post("id_status");
        $dato['orden']= $this->input->post("orden");
        $dato['foto']= $this->input->post("fotoimg");
        $dato['foto2']= $this->input->post("foto2");
        $foto3= $this->input->post("foto3");
        $dato['peso_antiguo1']= $this->input->post("peso_antiguo1");
        $dato['peso_antiguo2']= $this->input->post("peso_antiguo2");
        $dato['peso_antiguo3']= $this->input->post("peso_antiguo3");
        $dato['img1'] = $_FILES['fotoimg']['name'];
        $dato['img2'] = $_FILES['foto2']['name'];
        $dato['img3'] = $_FILES['foto3']['name'];

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
        
        $this->Model_Ceba2->update_intro($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Delete_Intro(){
        if ($this->session->userdata('usuario')) {
            $dato['id_intro']= $this->input->post("id_intro");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['get_intro'] = $this->Model_Ceba2->get_id_intro($dato['id_intro']);
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $archivo['archivo1']=$dato['get_intro'][0]['foto'];
            $archivo['archivo2']=$dato['get_intro'][0]['foto2'];
            $archivo['archivo3']=$dato['get_intro'][0]['foto3'];
            array_map('unlink', glob($archivo['archivo1']));
            array_map('unlink', glob($archivo['archivo2']));
            array_map('unlink', glob($archivo['archivo3']));

            $this->Model_Ceba2->delete_intro($dato);

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }           
        }else{
            redirect('/login');
        }
    }

    public function Delete_Img_Intro(){
        if ($this->session->userdata('usuario')) {
            $dato['id_intro']= $this->input->post("id_intro");
            $dato['id_intro2']= $this->input->post("id_intro2");
            $dato['id_intro3']= $this->input->post("id_intro3");
            
            $dato['foto']= $this->input->post("foto");

            if($dato['foto']==1){
                $dato['referencia']= $this->input->post("id_tema");
                $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
                $dato['img']=$this->Model_Ceba2->get_nom_img_intro($dato['id_intro']);
                $archivo['archivo1']=$dato['img'][0]['foto'];

                array_map('unlink', glob($archivo['archivo1']));
                
                $this->Model_Ceba2->delete_img1_intro($dato);
                $total_intro['total_intro']=$this->Model_Ceba2->valida_cant_intro($dato);
            }
            if($dato['foto']==2){
                $dato['referencia']= $this->input->post("id_tema2");
                $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
                $dato['img']=$this->Model_Ceba2->get_nom_img_intro($dato['id_intro2']);
                $archivo['archivo2']=$dato['img'][0]['foto2'];

                array_map('unlink', glob($archivo['archivo2']));
                $this->Model_Ceba2->delete_img2_intro($dato);
                $total_intro['total_intro']=$this->Model_Ceba2->valida_cant_intro($dato);
            }
            if($dato['foto']==3){
                $dato['referencia']= $this->input->post("id_tema3");
                $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
                $dato['img']=$this->Model_Ceba2->get_nom_img_intro($dato['id_intro3']);
                $archivo['archivo3']=$dato['img'][0]['foto3'];

                array_map('unlink', glob($archivo['archivo3']));
                $this->Model_Ceba2->delete_img3_intro($dato);
                $total_intro['total_intro']=$this->Model_Ceba2->valida_cant_intro($dato);
            }

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }
            redirect('Ceba/Modal_Tema_View1/'.$dato['referencia']);            
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Img_Intro($id_intro,$foto){
        if ($this->session->userdata('usuario')) {
            if($foto==1){
                $dato['get_file'] = $this->Model_Ceba2->get_id_intro($id_intro);
                $image = $dato['get_file'][0]['foto'];
                $name     = basename($image);
                $ext      = pathinfo($image, PATHINFO_EXTENSION);
                force_download($name , file_get_contents($dato['get_file'][0]['foto']));
            }
            if($foto==2){
                $dato['get_file'] = $this->Model_Ceba2->get_id_intro($id_intro);
                $image = $dato['get_file'][0]['foto2'];
                $name     = basename($image);
                $ext      = pathinfo($image, PATHINFO_EXTENSION);
                force_download($name , file_get_contents($dato['get_file'][0]['foto2']));
            }
            if($foto==3){
                $dato['get_file'] = $this->Model_Ceba2->get_id_intro($id_intro);
                $image = $dato['get_file'][0]['foto3'];
                $name     = basename($image);
                $ext      = pathinfo($image, PATHINFO_EXTENSION);
                force_download($name , file_get_contents($dato['get_file'][0]['foto3']));
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Detalle_Slide($id_tema,$id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema'] = $id_tema;
            $dato['id_grado'] = $id_grado;
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_tipo_slide'] = $this->Model_Ceba2->get_list_tipo_slide();
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();
            $this->load->view('ceba2/academico/temas/detalle_tema/modal_slide_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Slide_Detalle(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_slide']= $this->input->post("id_tipo_slide");
        $dato['orden']= $this->input->post("orden");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['tiempo']= "00:".$this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['imagen_sl']= $this->input->post("imagen_sl");

        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];

        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_tema'][0]['tiempo_archivos'];
        $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];

        $this->Model_Ceba2->insert_slide($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Update_Slide($id_slide,$id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema']=$id_tema;
            $dato['get_link'] = $this->Model_Ceba2->get_config();
            $dato['get_id'] = $this->Model_Ceba2->get_id_slide($id_slide);
            $dato['formato']=pathinfo($dato['get_id'][0]['imagen'], PATHINFO_EXTENSION);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_tipo_slide'] = $this->Model_Ceba2->get_list_tipo_slide();

            $this->load->view('ceba2/academico/temas/detalle_tema/upd_modal_slide', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Slide(){
        $dato['id_slide']= $this->input->post("id_slide");
        $dato['referencia']= $this->input->post("id_tema");
        $dato['orden']= $this->input->post("orden");
        $dato['id_tipo_slide']= $this->input->post("id_tipo_slide");
        $dato['id_status']= $this->input->post("id_status");
        $dato['tiempo']= $this->input->post("tiempo");
        $dato['imagen_sl']= $this->input->post("imagen_sl");
        $dato['peso_antiguo1']= $this->input->post("peso_antiguo1");
        
        $dato['get_slide'] = $this->Model_Ceba2->get_id_slide($dato['id_slide']);
        $dato['tiempo_antiguo']=$dato['get_slide'][0]['tiempo'];

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_id'][0]['tiempo_archivos'];

        if($dato['tiempo_actual']==0 && $dato['tiempo_antiguo']==0){
            $dato['tiempo_nuevo']=$dato['tiempo'];
            
        }else if($dato['tiempo_actual']!=0 && $dato['tiempo_antiguo']==0){
            $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];
        }else if($dato['tiempo_actual']==0 && $dato['tiempo_antiguo']!=0){
            $dato['tiempo_nuevo']=$dato['tiempo'];
        }else{
            $dato['tiempo_actualizado']=$dato['tiempo_actual']-$dato['tiempo_antiguo'];
            $dato['tiempo_nuevo']=$dato['tiempo_actualizado']+$dato['tiempo'];
        }

        $this->Model_Ceba2->update_slide($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Delete_Slide(){
        if ($this->session->userdata('usuario')) {
            $dato['id_slide']= $this->input->post("id_slide");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['get_slide'] = $this->Model_Ceba2->get_id_slide($dato['id_slide']);
            $dato['peso_slide']= $dato['get_slide'][0]['peso'];
            $dato['tiempo_slide']= $dato['get_slide'][0]['tiempo'];

            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
            $dato['tiempo_actual']=$dato['get_id'][0]['tiempo_archivos'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_slide'];
            $dato['tiempo_nuevo']=$dato['tiempo_actual']-$dato['tiempo_slide'];

            $this->Model_Ceba2->delete_slide($dato); 
            
            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }
        }else{
            redirect('/login');
        }
    }
    
    public function Delete_Img_Slide(){
        if ($this->session->userdata('usuario')) {
            $dato['id_slide']= $this->input->post("id_slide");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];

            $dato['img']=$this->Model_Ceba2->get_nom_img_slide($dato['id_slide']);
            $archivo['archivo']=$dato['img'][0]['imagen'];
            $dato['peso_slide']= $dato['img'][0]['peso'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_slide'];

            array_map('unlink', glob($archivo['archivo']));

            $this->Model_Ceba2->delete_img_slide($dato);     

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Detalle_Repaso($id_tema,$id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema'] = $id_tema;
            $dato['id_grado'] = $id_grado;
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();
            $this->load->view('ceba2/academico/temas/detalle_tema/modal_repaso_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Repaso_Detalle(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['referencia']= $this->input->post("referencia");
        $dato['orden']= $this->input->post("orden");
        $dato['tiempo']= "00:".$this->input->post("tiempo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['imagen']= $this->input->post("imagen");
        $dato['id_unidad']= $this->input->post("id_unidad");

        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_tema'][0]['tiempo_archivos'];
        $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];
        
        $this->Model_Ceba2->insert_repaso($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Update_Repaso($id_repaso,$id_tema){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema']=$id_tema;
            $dato['get_link'] = $this->Model_Ceba2->get_config();
            $dato['get_id'] = $this->Model_Ceba2->get_id_repaso($id_repaso);
            $dato['formato']=pathinfo($dato['get_id'][0]['imagen'], PATHINFO_EXTENSION);
            
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_tipo'] = $this->Model_Ceba2->get_list_tipo();

            $this->load->view('ceba2/academico/temas/detalle_tema/upd_modal_repaso', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Repaso(){
        $dato['id_repaso']= $this->input->post("id_repaso");
        $dato['referencia']= $this->input->post("id_tema");
        $dato['orden']= $this->input->post("orden");
        $dato['id_status']= $this->input->post("id_status");
        $dato['tiempo']= $this->input->post("tiempo");
        $dato['imagen']= $this->input->post("imagen");
        $dato['peso_antiguo1']= $this->input->post("peso_antiguo1");

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
        $dato['tiempo_actual']=$dato['get_id'][0]['tiempo_archivos'];

        $dato['get_repaso'] = $this->Model_Ceba2->get_id_repaso($dato['id_repaso']);
        $dato['tiempo_antiguo']=$dato['get_repaso'][0]['tiempo'];


        if($dato['tiempo_actual']==0 && $dato['tiempo_antiguo']==0){
            $dato['tiempo_nuevo']=$dato['tiempo'];
            
        }else if($dato['tiempo_actual']!=0 && $dato['tiempo_antiguo']==0){
            $dato['tiempo_nuevo']=$dato['tiempo_actual']+$dato['tiempo'];

        }else if($dato['tiempo_actual']==0 && $dato['tiempo_antiguo']!=0){
            $dato['tiempo_nuevo']=$dato['tiempo'];
        }else{
            $dato['tiempo_actualizado']=$dato['tiempo_actual']-$dato['tiempo_antiguo'];
            $dato['tiempo_nuevo']=$dato['tiempo_actualizado']+$dato['tiempo'];
        }

        $this->Model_Ceba2->update_repaso($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Delete_Repaso(){
        if ($this->session->userdata('usuario')) {
            $dato['id_repaso']= $this->input->post("id_repaso");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['get_repaso'] = $this->Model_Ceba2->get_id_repaso($dato['id_repaso']);
            $dato['peso_repaso']= $dato['get_repaso'][0]['peso'];
            $dato['tiempo_repaso']= $dato['get_slide'][0]['tiempo'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_repaso'];

            $dato['tiempo_actual']=$dato['get_id'][0]['tiempo_archivos'];
            $dato['tiempo_nuevo']=$dato['tiempo_actual']-$dato['tiempo_repaso'];

            $this->Model_Ceba2->delete_repaso($dato);  

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }   
        }else{
            redirect('/login');
        }
    }

    public function Delete_Img_Repaso(){
        if ($this->session->userdata('usuario')) {
            $dato['id_repaso']= $this->input->post("id_repaso");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['img']=$this->Model_Ceba2->get_nom_img_repaso($dato['id_repaso']);
            $archivo['archivo']=$dato['img'][0]['imagen'];
            $dato['peso_repaso']= $dato['img'][0]['peso'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_repaso'];
            array_map('unlink', glob($archivo['archivo']));

            $this->Model_Ceba2->delete_img_repaso($dato);
            
            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }      
        }else{
            redirect('/login');
        }
    }

    public function Modal_Detalle_Examen($id_tema,$id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['id_tema'] = $id_tema;
            $dato['id_grado'] = $id_grado;
            $dato['list_area'] = $this->Model_Ceba2->get_list_dependencia_area($id_tema);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['tipo_examen'] = $this->Model_Ceba2->get_list_tipo_examen();
            $this->load->view('ceba2/academico/temas/detalle_tema/modal_examen_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }  

    public function Valida_Insert_Examen_D(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_tema']= $this->input->post("referencia");
        $dato['id_unidad']= $this->input->post("id_unidad");

        $total=count($this->Model_Ceba2->valida_reg_examen_v2($dato));

        if($total>14){
            echo "error";
        }
    }

    public function Insert_Examen_Detalle(){
        $dato['id_grado']= $this->input->post("id_grado");
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['referencia']= $this->input->post("referencia");
        $dato['id_tipo_examen']= $this->input->post("id_tipo_examen");
        
        $dato['orden']= $this->input->post("orden"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['foto1']= $this->input->post("foto1");
        $dato['pregunta']= $this->input->post("pregunta");
        $dato['alternativa1']= $this->input->post("alternativa1"); 
        $dato['alternativa2']= $this->input->post("alternativa2");
        $dato['alternativa3']= $this->input->post("alternativa3");

        $dato['get_tema'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_tema'][0]['peso_archivos'];

        $this->Model_Ceba2->insert_examen($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Modal_Update_Examen($id_examen){
        if ($this->session->userdata('usuario')) {
            $dato['id_examen']=$id_examen;
            $dato['get_link'] = $this->Model_Ceba2->get_config();
            $dato['get_id'] = $this->Model_Ceba2->get_id_examen($id_examen);
            $dato['get_id_respuesta'] = $this->Model_Ceba2->get_id_respuesta($id_examen);
            $dato['formato']=pathinfo($dato['get_id'][0]['foto1'], PATHINFO_EXTENSION);

            $this->load->view('ceba2/academico/temas/detalle_tema/upd_modal_examen', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Examen(){
        $dato['id_examen']= $this->input->post("id_examen");
        $dato['referencia']= $this->input->post("id_tema");
        $dato['pregunta']= $this->input->post("pregunta");
        $dato['orden']= $this->input->post("orden");

        $dato['alternativa1']= $this->input->post("alternativa1");
        $dato['alternativa2']= $this->input->post("alternativa2");
        $dato['alternativa3']= $this->input->post("alternativa3");

        $dato['id_respuesta1']= $this->input->post("id_respuesta1");
        $dato['id_respuesta2']= $this->input->post("id_respuesta2");
        $dato['id_respuesta3']= $this->input->post("id_respuesta3");
        $dato['foto1']= $this->input->post("foto1");

        $dato['peso_antiguo1']= $this->input->post("peso_antiguo1");

        $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
        $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];

        $this->Model_Ceba2->update_examen($dato);

        $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

        if(count($total_intro)!=0){
            if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                $total_intro=3;
            }else{
                $total_intro=0;
            }
        }else{
            $total_intro=0;
        }

        $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
        $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
        $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));

        if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
            $dato['estado_contenido']=1;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }else{
            $dato['estado_contenido']=2;
            $this->Model_Ceba2->actu_estado_contenido($dato);
        }
    }

    public function Delete_Examen(){
        if ($this->session->userdata('usuario')) {
            $dato['id_examen']= $this->input->post("id_examen");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['get_examen'] = $this->Model_Ceba2->get_id_examen($dato['id_examen']);
            $dato['peso_examen']= $dato['get_examen'][0]['peso'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_examen'];

            $this->Model_Ceba2->delete_examen($dato); 

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }    
        }else{
            redirect('/login');
        }
    }

    public function Delete_Img_Examen(){
        if ($this->session->userdata('usuario')) {
            $dato['id_examen']= $this->input->post("id_examen");
            $dato['referencia']= $this->input->post("id_tema");

            $dato['img']=$this->Model_Ceba2->get_nom_img_examen($dato['id_examen']);
            $archivo['archivo']=$dato['img'][0]['foto1'];
            $dato['peso_examen']= $dato['img'][0]['peso'];
            $dato['get_id'] = $this->Model_Ceba2->get_id_tema($dato);
            $dato['peso_actual']=$dato['get_id'][0]['peso_archivos'];
            $dato['peso_nuevo']=$dato['peso_actual']-$dato['peso_examen'];
            array_map('unlink', glob($archivo['archivo']));

            $this->Model_Ceba2->delete_img_examen($dato);

            $total_intro=$this->Model_Ceba2->valida_cant_intro($dato);

            if(count($total_intro)!=0){
                if($total_intro[0]['foto']!="" && $total_intro[0]['foto2']!="" && $total_intro[0]['foto3']!=""){
                    $total_intro=3;
                }else{
                    $total_intro=0;
                }
            }else{
                $total_intro=0;
            }
    
            $total_slide=count($this->Model_Ceba2->valida_cant_slide($dato));
            $total_repaso=count($this->Model_Ceba2->valida_cant_repaso($dato));
            $total_preguntas=count($this->Model_Ceba2->valida_cant_preguntas($dato));
    
            if($total_intro==3 && $total_slide==14 && $total_repaso==1 && $total_preguntas>=10){
                $dato['estado_contenido']=1;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }else{
                $dato['estado_contenido']=2;
                $this->Model_Ceba2->actu_estado_contenido($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Tema($id_tema){
        $dato['get_id'] = $this->Model_Ceba2->get_id_temas($id_tema);
        $dato['get_intro'] = $this->Model_Ceba2->get_intro_tema($id_tema);
        $dato['get_slide'] = $this->Model_Ceba2->get_slide_tema($id_tema);
        $dato['get_repaso'] = $this->Model_Ceba2->get_repaso_tema($id_tema);
        $dato['get_examen'] = $this->Model_Ceba2->get_examen_tema($id_tema);

        $dato['suma_slide'] = $this->Model_Ceba2->v_suma_tiempo_slide();
        $dato['suma_repaso'] = $this->Model_Ceba2->v_suma_tiempo_repaso();
        $dato['suma_slide_repaso'] = $this->Model_Ceba2->v_suma_tiempo_slide_repaso();
        $dato['suma_total'] = $this->Model_Ceba2->v_suma_total_slide_repaso();
        $dato['peso_slide'] = $this->Model_Ceba2->v_peso_slide($id_tema);
        $dato['peso_repaso'] = $this->Model_Ceba2->v_peso_repaso($id_tema);
        $dato['peso_intro'] = $this->Model_Ceba2->peso_intro($id_tema);
        $dato['peso_examen'] = $this->Model_Ceba2->peso_examen($id_tema);

        if(count($dato['peso_slide'])>0){
            $dato['sum_slide']=$dato['peso_slide'][0]['total_slide'];
        }else{
            $dato['sum_slide']='0';
        }
        if(count($dato['peso_repaso'])>0){
            $dato['sum_repaso']=$dato['peso_repaso'][0]['total_repaso'];
        }else{
            $dato['sum_repaso']='0';
        }
        if(count($dato['peso_examen'])>0){
            $dato['sum_examen']=$dato['peso_examen'][0]['total_examen'];
        }else{
            $dato['sum_examen']='0';
        }
        if(count($dato['peso_intro'])>0){
            $dato['sum_intro']=$dato['peso_intro'][0]['total_intro'];
        }else{
            $dato['sum_intro']='0';
        }
        $dato['peso_total']=$dato['sum_slide']+$dato['sum_repaso']+$dato['sum_intro'];

        if(count($dato['get_id']) > 0){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Detalle de Tema');

            //$sheet->setAutoFilter('A1:L1');
    
            $contador=1;

            $sheet->getColumnDimension('A')->setWidth(15);
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

            $sheet->getStyle("A1:A4")->getFont()->setBold(true);
            $sheet->getStyle("E1:E4")->getFont()->setBold(true);

            $sheet->mergeCells('B1:D1');
            $sheet->mergeCells('B2:D2');
            $sheet->mergeCells('B3:D3');
            $sheet->mergeCells('B4:D4');
    
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

            $sheet->setCellValue("A1", 'Tema');           
            $sheet->setCellValue("A2", 'Grado');
            $sheet->setCellValue("A3", 'Unidad');
            $sheet->setCellValue("A4", 'Referencia');
            $sheet->setCellValue("E1", 'Área');
            $sheet->setCellValue("E2", 'Asignatura');
            $sheet->setCellValue("E3", 'Tiempo');
            $sheet->setCellValue("E4", 'Estado');

            $sheet->setCellValue("B1", $dato['get_id'][0]['desc_tema']);
            $sheet->setCellValue("B2", $dato['get_id'][0]['descripcion_grado']);
            $sheet->setCellValue("B3", $dato['get_id'][0]['nom_unidad']);
            $sheet->setCellValue("B4", $dato['get_id'][0]['referencia']);
            $sheet->setCellValue("F1", $dato['get_id'][0]['descripcion_area']);
            $sheet->setCellValue("F2", $dato['get_id'][0]['descripcion_asignatura']);
            foreach($dato['suma_total'] as $sum){
                if($sum['id_tema']==$dato['get_id'][0]['id_tema']){
                    $sheet->setCellValue("F3", substr($sum['total'],0,8)." + 30 min");
                }
            }

            if($dato['get_id'][0]['estado_contenido']==1){
            $sheet->setCellValue("F4", "Pendiente");
            }else{
            $sheet->setCellValue("F4", "Pendiente");
            }
            $sheet->getStyle("A6:G6")->getFont()->setBold(true);
            $sheet->setCellValue("A6", 'Tema');
            $sheet->setCellValue("B6", 'Tipo');
            $sheet->setCellValue("C6", 'Orden');
            $sheet->setCellValue("D6", 'Tiempo');
            $sheet->setCellValue("E6", 'Peso');
            $sheet->setCellValue("F6", 'Usuario');
            $sheet->setCellValue("G6", 'Fecha de Creación');

            $contador_intro=7;
            foreach($dato['get_intro'] as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                
                //Informacion de las filas de la consulta.
                $sheet->setCellValue("A{$contador_intro}", "Intro");
                if($list['id_tipo']==1){
                    $sheet->setCellValue("B{$contador_intro}", "Intro");
                }
                $sheet->setCellValue("C{$contador_intro}", $list['orden']);
                $sheet->setCellValue("D{$contador_intro}", "");

                if(($list['peso1']+$list['peso2']+$list['peso3'])>= 1048576){
                $sheet->setCellValue("E{$contador_intro}", bcdiv(number_format(($list['peso1']+$list['peso2']+$list['peso3']) / 1048576, 2),'1',1) . " MB");
                }else if(($list['peso1']+$list['peso2']+$list['peso3'])>= 1024){
                $sheet->setCellValue("E{$contador_intro}", bcdiv(number_format(($list['peso1']+$list['peso2']+$list['peso3']) / 1024, 2),'1',1) . " KB");
                }else if(($list['peso1']+$list['peso2']+$list['peso3'])>1){
                $sheet->setCellValue("E{$contador_intro}", bcdiv(($list['peso1']+$list['peso2']+$list['peso3']),'1',1) . " bytes");
                }else if(($list['peso1']+$list['peso2']+$list['peso3'])==1){
                $sheet->setCellValue("E{$contador_intro}", bcdiv(($list['peso1']+$list['peso2']+$list['peso3']),'1',1) . " byte");
                }else{
                $sheet->setCellValue("E{$contador_intro}", "0 byte");
                }
                
                $sheet->setCellValue("F{$contador_intro}", $list['usuario_codigo']);
                $sheet->setCellValue("G{$contador_intro}", $list['fecha_registro']);
                
                $contador_intro++;
            }

            $contador_slide=8;
            $ts=0;
            foreach($dato['get_slide'] as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                
                //Informacion de las filas de la consulta.
                $sheet->setCellValue("A{$contador_slide}", "Slide");
                $sheet->setCellValue("B{$contador_slide}", $list['nom_tipo_slide']);
                $sheet->setCellValue("C{$contador_slide}", $list['orden']);
                $sheet->setCellValue("D{$contador_slide}", $list['tiempo']);
                
                if(($list['peso'])>= 1048576){
                $sheet->setCellValue("E{$contador_slide}", bcdiv(number_format(($list['peso']) / 1048576, 2),'1',1) . " MB");
                }else if(($list['peso'])>= 1024){
                $sheet->setCellValue("E{$contador_slide}", bcdiv(number_format(($list['peso']) / 1024, 2),'1',1) . " KB");
                }else if(($list['peso'])>1){
                $sheet->setCellValue("E{$contador_slide}", bcdiv(($list['peso']),'1',1) . " bytes");
                }else if(($list['peso'])==1){
                $sheet->setCellValue("E{$contador_slide}", bcdiv(($list['peso']),'1',1) . " byte");
                }else{
                $sheet->setCellValue("E{$contador_slide}", "0 byte");
                }

                $sheet->setCellValue("F{$contador_slide}", $list['usuario_codigo']);
                $sheet->setCellValue("G{$contador_slide}", $list['fecha_registro']);

                $ts=$ts+$list['tiempo'];
                
                $contador_slide++;
            }

            $contador_repaso=$contador_slide;
            $tr=0;
            foreach($dato['get_repaso'] as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                
                //Informacion de las filas de la consulta.
                $sheet->setCellValue("A{$contador_repaso}", "Repaso");
                if($list['id_tipo_repaso']==1){
                    $sheet->setCellValue("B{$contador_repaso}", "Repaso");
                }
                $sheet->setCellValue("C{$contador_repaso}", $list['orden']);
                $sheet->setCellValue("D{$contador_repaso}", $list['tiempo']);
                
                if(($list['peso'])>= 1048576){
                $sheet->setCellValue("E{$contador_repaso}", bcdiv(number_format(($list['peso']) / 1048576, 2),'1',1) . " MB");
                }else if(($list['peso'])>= 1024){
                $sheet->setCellValue("E{$contador_repaso}", bcdiv(number_format(($list['peso']) / 1024, 2),'1',1) . " KB");
                }else if(($list['peso'])>1){
                $sheet->setCellValue("E{$contador_repaso}", bcdiv(($list['peso']),'1',1) . " bytes");
                }else if(($list['peso'])==1){
                $sheet->setCellValue("E{$contador_repaso}", bcdiv(($list['peso']),'1',1) . " byte");
                }else{
                $sheet->setCellValue("E{$contador_repaso}", "0 byte");
                }
                
                $sheet->setCellValue("F{$contador_repaso}", $list['usuario_codigo']);
                $sheet->setCellValue("G{$contador_repaso}", $list['fecha_registro']);
                $ts=$ts+$list['tiempo'];
                
                $contador_repaso++;
            }

            $cont_total=$contador_repaso;
            $sheet->mergeCells("A{$cont_total}:C{$cont_total}");
            $sheet->setCellValue("A{$cont_total}", "TOTAL");

            foreach($dato['suma_total'] as $sum){
                if($sum['id_tema']==$dato['get_id'][0]['id_tema']){
                    $sheet->setCellValue("D{$cont_total}", substr($sum['total'],0,8));
                }
            }
            
            if($dato['peso_total']>= 1048576){
                $sheet->setCellValue("E{$cont_total}", bcdiv(number_format($dato['peso_total'] / 1048576, 2),'1',1) . " MB");
                }else if($dato['peso_total']>= 1024){
                $sheet->setCellValue("E{$cont_total}", bcdiv(number_format($dato['peso_total'] / 1024, 2),'1',1) . " KB");
                }else if($dato['peso_total']>1){
                $sheet->setCellValue("E{$cont_total}", bcdiv($dato['peso_total'],'1',1) . " bytes");
                }else if($dato['peso_total']==1){
                $sheet->setCellValue("E{$cont_total}", bcdiv($dato['peso_total'],'1',1) . " byte");
                }else{
                $sheet->setCellValue("E{$cont_total}", "0 byte");
            }

            $cont_cabecera=$cont_total+2;
            $sheet->getStyle("A{$cont_cabecera}:H{$cont_cabecera}")->getFont()->setBold(true);

            $spreadsheet->getActiveSheet()->getStyle("A{$cont_cabecera}:H{$cont_cabecera}")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

            $sheet->mergeCells("C{$cont_cabecera}:F{$cont_cabecera}");
            $sheet->setCellValue("A{$cont_cabecera}", 'Tipo');
            $sheet->setCellValue("B{$cont_cabecera}", 'Número');
            $sheet->setCellValue("C{$cont_cabecera}", 'Pregunta');
            $sheet->setCellValue("G{$cont_cabecera}", 'Peso');
            $sheet->setCellValue("H{$cont_cabecera}", 'Tiempo');

            $cont_examen=$cont_total+3;
            $peso_examen=0;
            foreach($dato['get_examen'] as $list){
                $sheet->mergeCells("C{$cont_examen}:F{$cont_examen}");
                $sheet->setCellValue("A{$cont_examen}", $list['nom_tipo_examen']);
                $sheet->setCellValue("B{$cont_examen}", $list['orden']);
                $sheet->setCellValue("C{$cont_examen}", $list['pregunta']);

                if($list['peso']>= 1048576){
                    $sheet->setCellValue("G{$cont_examen}", bcdiv(number_format($list['peso'] / 1048576, 2),'1',1) . " MB");
                    }else if($list['peso']>= 1024){
                    $sheet->setCellValue("G{$cont_examen}", bcdiv(number_format($list['peso'] / 1024, 2),'1',1) . " KB");
                    }else if($list['peso']>1){
                    $sheet->setCellValue("G{$cont_examen}", bcdiv($list['peso'],'1',1) . " bytes");
                    }else if($list['peso']==1){
                    $sheet->setCellValue("G{$cont_examen}", bcdiv($list['peso'],'1',1) . " byte");
                    }else{
                    $sheet->setCellValue("G{$cont_examen}", "0 byte");
                }
                $sheet->setCellValue("H{$cont_examen}", "-");
                
                
                $cont_examen++;
            }

            $cont_total_examen=$cont_examen;
            // $sheet->getStyle("A{$cont_total_examen}:H{$cont_total_examen}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // $sheet->getStyle("A{$cont_total_examen}:H{$cont_total_examen}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$cont_total_examen}:H{$cont_total_examen}")->getFont()->setBold(true);

            $sheet->mergeCells("A{$cont_total_examen}:F{$cont_total_examen}");
            $sheet->setCellValue("A{$cont_total_examen}", "TOTAL EXAMEN");
            
            if($dato['sum_examen']>= 1048576){
                $sheet->setCellValue("G{$cont_total_examen}", bcdiv(number_format($dato['sum_examen'] / 1048576, 2),'1',1) . " MB");
                }else if($dato['sum_examen']>= 1024){
                $sheet->setCellValue("G{$cont_total_examen}", bcdiv(number_format($dato['sum_examen'] / 1024, 2),'1',1) . " KB");
                }else if($dato['sum_examen']>1){
                $sheet->setCellValue("G{$cont_total_examen}", bcdiv($dato['sum_examen'],'1',1) . " bytes");
                }else if($dato['sum_examen']==1){
                $sheet->setCellValue("G{$cont_total_examen}", bcdiv($dato['sum_examen'],'1',1) . " byte");
                }else{
                $sheet->setCellValue("G{$cont_total_examen}", "0 byte");
            }
            $sheet->setCellValue("H{$cont_total_examen}", "30 Min");

            $curdate = date('d-m-Y');
            $writer = new Xlsx($spreadsheet);
            $filename = 'Detalle_Tema';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }else{
            echo 'No se han encontrado llamadas';
        	exit; 
        }
    }
    //-----------------------------------GRADO-------------------------------------
    public function Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/configuracion/grado/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/configuracion/grado/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['descripcion_grado']= $this->input->post("descripcion_grado_i");
            $dato['id_status']= $this->input->post("id_status_i"); 

            $validar = $this->Model_Ceba2->valida_insert_grado($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->insert_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Grado($id_grado){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_grado($id_grado);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/configuracion/grado/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado"); 
            $dato['descripcion_grado']= $this->input->post("descripcion_grado_u");
            $dato['id_status']= $this->input->post("id_status_u"); 

            $validar = $this->Model_Ceba2->valida_update_grado($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->update_grado($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Grado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $this->Model_Ceba2->delete_grado($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Grado(){
        $grado = $this->Model_Ceba2->get_list_grado();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Grados');

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

        $sheet->setCellValue("A1", 'Descripción');	        
        $sheet->setCellValue("B1", 'Estado');

        $contador=1;
        
        foreach($grado as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['descripcion_grado']);
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
    //-----------------------------------AREA-------------------------------------
    public function Area() {
        if ($this->session->userdata('usuario')) {
            $dato['list_area'] = $this->Model_Ceba2->get_list_area();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/configuracion/area/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Area(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/configuracion/area/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Area(){
        if ($this->session->userdata('usuario')) {
            $dato['descripcion_area']= $this->input->post("descripcion_area_i");
            $dato['id_status']= $this->input->post("id_status_i"); 

            $validar = $this->Model_Ceba2->valida_insert_area($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->insert_area($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Area($id_area){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_area($id_area);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/academico/configuracion/area/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Area(){
        if ($this->session->userdata('usuario')) {
            $dato['id_area']= $this->input->post("id_area"); 
            $dato['descripcion_area']= $this->input->post("descripcion_area_u");
            $dato['id_status']= $this->input->post("id_status_u"); 

            $validar = $this->Model_Ceba2->valida_update_area($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->update_area($dato);
            }
        }else{
            redirect('/login');
        } 
    }

    public function Delete_Area(){
        if ($this->session->userdata('usuario')) {
            $dato['id_area']= $this->input->post("id_area"); 
            $this->Model_Ceba2->delete_area($dato);
        }else{
            redirect('/login');
        } 
    }

    public function Excel_Area(){
        $area = $this->Model_Ceba2->get_list_area();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Areas');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(30);
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

        $sheet->setCellValue("A1", 'Descripción');	        
        $sheet->setCellValue("B1", 'Estado');

        $contador=1;
        
        foreach($area as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['descripcion_area']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Áreas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------ASIGNATURA-------------------------------------
    public function Asignatura() {
        if ($this->session->userdata('usuario')) {
            $dato['list_asignatura'] = $this->Model_Ceba2->get_list_asignatura();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/academico/configuracion/asignatura/index',$dato);
        }else{
            redirect('/login');
        } 
    }

    public function Modal_Asignatura(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_area'] = $this->Model_Ceba2->get_list_area_combo();
            $this->load->view('ceba2/academico/configuracion/asignatura/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Asignatura(){
        if ($this->session->userdata('usuario')) {
            $dato['id_area']= $this->input->post("id_area_i");
            $dato['referencia']= $this->input->post("referencia_i");
            $dato['descripcion_asignatura']= $this->input->post("descripcion_asignatura_i");
            $dato['id_status']= $this->input->post("id_status_i"); 

            $validar = $this->Model_Ceba2->valida_insert_asignatura($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->insert_asignatura($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Asignatura($id_asignatura){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_asignatura($id_asignatura);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $dato['list_area'] = $this->Model_Ceba2->get_list_area_combo();
            $this->load->view('ceba2/academico/configuracion/asignatura/modal_editar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Asignatura(){        
        if ($this->session->userdata('usuario')) {
            $dato['id_asignatura']= $this->input->post("id_asignatura");
            $dato['id_area']= $this->input->post("id_area_u");
            $dato['referencia']= $this->input->post("referencia_u");
            $dato['descripcion_asignatura']= $this->input->post("descripcion_asignatura_u");
            $dato['id_status']= $this->input->post("id_status_u"); 

            $validar = $this->Model_Ceba2->valida_update_asignatura($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Model_Ceba2->update_asignatura($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Asignatura(){
        if ($this->session->userdata('usuario')) {
            $dato['id_asignatura']= $this->input->post("id_asignatura"); 
            $this->Model_Ceba2->delete_asignatura($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Asignatura(){
        $area = $this->Model_Ceba2->get_list_asignatura();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asignaturas');

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

        $sheet->setCellValue("A1", 'Área');	
        $sheet->setCellValue("B1", 'Referencia');
        $sheet->setCellValue("C1", 'Descripción');
        $sheet->setCellValue("D1", 'Estado');

        $contador=1;
        
        foreach($area as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['descripcion_area']);
            $sheet->setCellValue("B{$contador}", $list['referencia']);
            $sheet->setCellValue("C{$contador}", $list['descripcion_asignatura']);
            $sheet->setCellValue("D{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asignaturas (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    } 
    //-----------------------------------CLIENTE-------------------------------------
    public function Cliente() {
        if ($this->session->userdata('usuario')) {
            $dato['list_cliente'] = $this->Model_Ceba2->get_list_cliente();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/cliente/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cliente(){
        $list_cliente = $this->Model_Ceba2->get_list_cliente();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cliente');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(18);

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

        $sheet->setCellValue("A1", 'Tipo');             
        $sheet->setCellValue("B1", 'Apellido Paterno');
        $sheet->setCellValue("C1", 'Apellido Materno');
        $sheet->setCellValue("D1", 'Nombre(s)');
        $sheet->setCellValue("E1", 'Sede'); 
        $sheet->setCellValue("F1", 'Documento'); 

        $contador=1;
        
        foreach($list_cliente as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", "Alumno");
            $sheet->setCellValue("B{$contador}", $list['alum_apater']);
            $sheet->setCellValue("C{$contador}", $list['alum_amater']);
            $sheet->setCellValue("D{$contador}", $list['alum_nom']);
            $sheet->setCellValue("E{$contador}", "EP1"); 
            $sheet->setCellValue("F{$contador}", $list['dni_alumno']); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cliente (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------MATRÍCULA-------------------------------------
    public function Matricula() {
        if ($this->session->userdata('usuario')) {
            $dato['list_departamento'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provincia'] = $this->Model_Ceba2->busca_provincia(11);

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/matricula/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Matricula() {
        if ($this->session->userdata('usuario')) {
            $parametro = $this->input->post("parametro");
            $dato['list_matricula'] = $this->Model_Ceba2->get_list_matricula($parametro);
            $this->load->view('ceba2/matricula/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Matricula() {
        if ($this->session->userdata('usuario')) {
            $dato['list_departamento'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provincia'] = $this->Model_Ceba2->busca_provincia(11);
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            $dato['list_medio'] = $this->Model_Ceba2->get_list_medios();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['datos_alumno'] = $this->Model_Ceba2->get_id_datos_alumno();
            $dato['datos_documento'] = $this->Model_Ceba2->get_id_datos_documento();
            $dato['datos_matricula'] = $this->Model_Ceba2->get_id_datos_matricula();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/matricula/registrar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Busca_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_Ceba2->busca_provincia($id_departamento);
            $this->load->view('ceba2/matricula/provincia', $dato);
        } else {
            redirect('');
        }
    }

    public function Busca_Distrito(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $id_provincia = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_distrito'] = $this->Model_Ceba2->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('ceba2/matricula/distrito', $dato);
        } else {
            redirect('');
        }
    }

    public function Traer_Provincia(){
        if ($this->session->userdata('usuario')) {
            $id_departamento = $this->input->post("id_departamento");
            $dato['id_provincia'] = $this->input->post("id_provincia");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_provincia'] = $this->Model_Ceba2->busca_provincia($id_departamento);
            $this->load->view('ceba2/matricula/provincia_alumno', $dato);
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
            $dato['list_distrito'] = $this->Model_Ceba2->busca_distrito($id_departamento,$id_provincia);
            $this->load->view('ceba2/matricula/distrito_alumno', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo_documento_alum']= $this->input->post("id_tipo_documento_alum");
            $dato['n_doc_alum']= $this->input->post("n_doc_alum");
            $dato['fec_nac_alum']= $this->input->post("fec_nac_alum");
            $dato['edad_alum']= $this->input->post("edad_alum"); 
            $dato['id_sexo_alum']= $this->input->post("id_sexo_alum"); 
            $dato['apater_alum']= $this->input->post("apater_alum");
            $dato['amater_alum']= $this->input->post("amater_alum");
            $dato['nombres_alum']= $this->input->post("nombres_alum");
            $dato['direccion_alum']= $this->input->post("direccion_alum"); 
            $dato['id_departamento_alum']= $this->input->post("id_departamento_alum");
            $dato['id_provincia_alum']= $this->input->post("id_provincia_alum");
            $dato['id_distrito_alum']= $this->input->post("id_distrito_alum");
            $dato['celular_alum']= $this->input->post("celular_alum"); 
            $dato['telf_casa_alum']= $this->input->post("telf_casa_alum"); 
            $dato['correo_personal_alum']= $this->input->post("correo_personal_alum");
            $dato['correo_corporativo_alum']= $this->input->post("correo_corporativo_alum");
            $dato['inst_procedencia']= $this->input->post("inst_procedencia");
            $dato['id_departamento_inst_alum']= $this->input->post("id_departamento_inst_alum"); 
            $dato['id_provincia_inst_alum']= $this->input->post("id_provincia_inst_alum");
            $dato['id_distrito_inst_alum']= $this->input->post("id_distrito_inst_alum"); 

            $validar = $this->Model_Ceba2->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_Ceba2->update_datos_alumno($dato);
            }else{
                $this->Model_Ceba2->insert_datos_alumno($dato);
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
            $dato['edad_alum']= $this->input->post("edad_alum"); 
            $dato['id_sexo_alum']= $this->input->post("id_sexo_alum"); 
            $dato['apater_alum']= $this->input->post("apater_alum");
            $dato['amater_alum']= $this->input->post("amater_alum");
            $dato['nombres_alum']= $this->input->post("nombres_alum");
            $dato['direccion_alum']= $this->input->post("direccion_alum"); 
            $dato['id_departamento_alum']= $this->input->post("id_departamento_alum");
            $dato['id_provincia_alum']= $this->input->post("id_provincia_alum");
            $dato['id_distrito_alum']= $this->input->post("id_distrito_alum");
            $dato['celular_alum']= $this->input->post("celular_alum"); 
            $dato['telf_casa_alum']= $this->input->post("telf_casa_alum"); 
            $dato['correo_personal_alum']= $this->input->post("correo_personal_alum");
            $dato['correo_corporativo_alum']= $this->input->post("correo_corporativo_alum");
            $dato['inst_procedencia']= $this->input->post("inst_procedencia");
            $dato['id_departamento_inst_alum']= $this->input->post("id_departamento_inst_alum"); 
            $dato['id_provincia_inst_alum']= $this->input->post("id_provincia_inst_alum");
            $dato['id_distrito_inst_alum']= $this->input->post("id_distrito_inst_alum"); 
            $this->Model_Ceba2->update_datos_alumno($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Alumno(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_alumno();
            $dato['list_departamento'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provincia_alum'] = $this->Model_Ceba2->busca_provincia($dato['get_id'][0]['id_departamento_alum']);
            $dato['list_distrito_alum'] = $this->Model_Ceba2->busca_distrito($dato['get_id'][0]['id_departamento_alum'],$dato['get_id'][0]['id_provincia_alum']);
            $dato['list_provincia_inst_alum'] = $this->Model_Ceba2->busca_provincia($dato['get_id'][0]['id_departamento_inst_alum']);
            $dato['list_distrito_inst_alum'] = $this->Model_Ceba2->busca_distrito($dato['get_id'][0]['id_departamento_inst_alum'],$dato['get_id'][0]['id_provincia_inst_alum']);
            $this->load->view('ceba2/matricula/datos_alumno', $dato);
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

            $validar = $this->Model_Ceba2->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_Ceba2->update_datos_tutor($dato);
            }else{
                $this->Model_Ceba2->insert_datos_tutor($dato);
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
            $this->Model_Ceba2->update_datos_tutor($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Tutor(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_alumno();
            $dato['list_parentesco'] = $this->Model_Ceba2->get_list_parentesco();
            $dato['list_departamento'] = $this->Model_Ceba2->get_list_departamento();
            $dato['list_provincia_prin'] = $this->Model_Ceba2->busca_provincia($dato['get_id'][0]['id_departamento_prin']);
            $dato['list_distrito_prin'] = $this->Model_Ceba2->busca_distrito($dato['get_id'][0]['id_departamento_prin'],$dato['get_id'][0]['id_provincia_prin']);
            $dato['list_provincia_secu'] = $this->Model_Ceba2->busca_provincia($dato['get_id'][0]['id_departamento_secu']);
            $dato['list_distrito_secu'] = $this->Model_Ceba2->busca_distrito($dato['get_id'][0]['id_departamento_secu'],$dato['get_id'][0]['id_provincia_secu']);
            $this->load->view('ceba2/matricula/datos_tutor', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['donde_conocio']= $this->input->post("donde_conocio");

            $validar = $this->Model_Ceba2->validar_temporal_datos_alumno();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_Ceba2->update_datos_informacion($dato);
            }else{
                $this->Model_Ceba2->insert_datos_informacion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_alumno");
            $dato['donde_conocio']= $this->input->post("donde_conocio");
            $this->Model_Ceba2->update_datos_informacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Informacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_alumno();
            $dato['list_medio'] = $this->Model_Ceba2->get_list_medios();
            $this->load->view('ceba2/matricula/datos_informacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Insert_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

            $dato['doc_iden_alumno']= "";
            $dato['certificado_estudio']= "";
            $dato['foto']= "";
            $dato['doc_iden_apoderado']= "";

            if($_FILES["doc_iden_alumno"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["doc_iden_alumno"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/doc_iden_alumno/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_alumno/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_alumno/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["doc_iden_alumno"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["doc_iden_alumno"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["doc_iden_alumno"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["doc_iden_alumno"]["error"];
                $_FILES["file"]["size"] = $_FILES["doc_iden_alumno"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['doc_iden_alumno'] = "documento_temporal_documento/doc_iden_alumno/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["certificado_estudio"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["certificado_estudio"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/certificado_estudio/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/certificado_estudio/', 0777);
                    chmod('./documento_temporal_documento/certificado_estudio/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["certificado_estudio"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["certificado_estudio"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["certificado_estudio"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["certificado_estudio"]["error"];
                $_FILES["file"]["size"] = $_FILES["certificado_estudio"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['certificado_estudio'] = "documento_temporal_documento/certificado_estudio/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["foto"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/foto/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/foto/', 0777);
                    chmod('./documento_temporal_documento/foto/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["foto"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['foto'] = "documento_temporal_documento/foto/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["doc_iden_apoderado"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["doc_iden_apoderado"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/doc_iden_apoderado/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_apoderado/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_apoderado/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["doc_iden_apoderado"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["doc_iden_apoderado"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["doc_iden_apoderado"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["doc_iden_apoderado"]["error"];
                $_FILES["file"]["size"] = $_FILES["doc_iden_apoderado"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['doc_iden_apoderado'] = "documento_temporal_documento/doc_iden_apoderado/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            $this->Model_Ceba2->insert_datos_documento($dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
            $dato['id_temporal']= $this->input->post("id_temporal_datos_documento");
            $dato['doc_iden_alumno']= $this->input->post("doc_iden_alumno_actual");
            $dato['certificado_estudio']= $this->input->post("certificado_estudio_actual");
            $dato['foto']= $this->input->post("foto_actual");
            $dato['doc_iden_apoderado']= $this->input->post("doc_iden_apoderado_actual");

            if($_FILES["doc_iden_alumno"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["doc_iden_alumno"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/doc_iden_alumno/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_alumno/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_alumno/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["doc_iden_alumno"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["doc_iden_alumno"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["doc_iden_alumno"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["doc_iden_alumno"]["error"];
                $_FILES["file"]["size"] = $_FILES["doc_iden_alumno"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['doc_iden_alumno'] = "documento_temporal_documento/doc_iden_alumno/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["certificado_estudio"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["certificado_estudio"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/certificado_estudio/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/certificado_estudio/', 0777);
                    chmod('./documento_temporal_documento/certificado_estudio/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["certificado_estudio"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["certificado_estudio"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["certificado_estudio"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["certificado_estudio"]["error"];
                $_FILES["file"]["size"] = $_FILES["certificado_estudio"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['certificado_estudio'] = "documento_temporal_documento/certificado_estudio/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["foto"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/foto/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/foto/', 0777);
                    chmod('./documento_temporal_documento/foto/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["foto"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["foto"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["foto"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["foto"]["error"];
                $_FILES["file"]["size"] = $_FILES["foto"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['foto'] = "documento_temporal_documento/foto/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            if($_FILES["doc_iden_apoderado"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["doc_iden_apoderado"]["name"]);
                $config['upload_path'] = './documento_temporal_documento/doc_iden_apoderado/'.$id_usuario;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_temporal_documento/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_apoderado/', 0777);
                    chmod('./documento_temporal_documento/doc_iden_apoderado/'.$id_usuario, 0777);
                }
                $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["doc_iden_apoderado"]["name"];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["doc_iden_apoderado"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["doc_iden_apoderado"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["doc_iden_apoderado"]["error"];
                $_FILES["file"]["size"] = $_FILES["doc_iden_apoderado"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['doc_iden_apoderado'] = "documento_temporal_documento/doc_iden_apoderado/".$id_usuario."/".$dato['nom_documento'];
                }     
            }

            $this->Model_Ceba2->update_datos_documento($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_documento();
            $this->load->view('ceba2/matricula/datos_documento', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Documento($orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ceba2->get_id_datos_documento();
            if($orden==1){
                $image = $dato['get_file'][0]['doc_iden_alumno'];
            }elseif($orden==2){
                $image = $dato['get_file'][0]['certificado_estudio'];
            }elseif($orden==3){
                $image = $dato['get_file'][0]['foto'];
            }elseif($orden==4){
                $image = $dato['get_file'][0]['doc_iden_apoderado'];
            }else{
                $image = $dato['get_file'][0]['hoja_matricula_documento'];
            }
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            if($orden==1){
                force_download($name , file_get_contents($dato['get_file'][0]['doc_iden_alumno']));
            }elseif($orden==2){
                force_download($name , file_get_contents($dato['get_file'][0]['certificado_estudio']));
            }elseif($orden==3){
                force_download($name , file_get_contents($dato['get_file'][0]['foto']));
            }elseif($orden==4){
                force_download($name , file_get_contents($dato['get_file'][0]['doc_iden_apoderado']));
            }else{
                force_download($name , file_get_contents($dato['get_file'][0]['hoja_matricula_documento']));
            }
        }
        else{
            redirect('');
        }
    }

    public function Insert_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['fec_matricula']= $this->input->post("fec_matricula");
            $dato['observaciones']= $this->input->post("observaciones");

            $validar = $this->Model_Ceba2->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_Ceba2->update_datos_matricula($dato);
            }else{
                $this->Model_Ceba2->insert_datos_matricula($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['id_temporal']= $this->input->post("id_temporal_datos_matricula");
            $dato['id_grado']= $this->input->post("id_grado");
            $dato['fec_matricula']= $this->input->post("fec_matricula");
            $dato['observaciones']= $this->input->post("observaciones");
            $this->Model_Ceba2->update_datos_matricula($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_matricula();
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $this->load->view('ceba2/matricula/datos_matricula', $dato);
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

            $validar = $this->Model_Ceba2->validar_temporal_datos_matricula();

            if(count($validar)>0){
                $dato['id_temporal']= $validar[0]['id_temporal'];
                $this->Model_Ceba2->update_datos_confirmacion($dato);
            }else{
                $this->Model_Ceba2->insert_datos_confirmacion($dato);
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

            $this->Model_Ceba2->update_datos_confirmacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Datos_Confirmacion(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_matricula();
            $this->load->view('ceba2/matricula/datos_confirmacion', $dato);
        } else {
            redirect('');
        }
    }

    public function Descargar_Archivo_Matricula($orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ceba2->get_id_datos_matricula();
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
            $get_id = $this->Model_Ceba2->get_id_datos_alumno();

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
            $validar_alumno = $this->Model_Ceba2->validar_temporal_datos_alumno();
            $validar_matricula = $this->Model_Ceba2->validar_temporal_datos_matricula();
            if(count($validar_alumno)==0 || count($validar_matricula)==0){
                echo "error";
            }
        }else{
            redirect('');
        }
    }

    public function Pdf_Hoja_Matricula(){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_id_datos_alumno();
            $dato['get_matricula'] = $this->Model_Ceba2->get_id_datos_matricula();
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('ceba2/matricula/hoja_matricula',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            redirect('');
        }
    }

    public function Insert_Matricula(){
        if ($this->session->userdata('usuario')) {
            $datos_alumno = $this->Model_Ceba2->get_id_datos_alumno();
            $datos_documento = $this->Model_Ceba2->get_id_datos_documento();
            $datos_matricula = $this->Model_Ceba2->get_id_datos_matricula();

            if(count($datos_alumno)>0 && count($datos_matricula)==0){
                echo "alumno";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)>0){
                echo "matricula";
            }elseif(count($datos_alumno)==0 && count($datos_matricula)==0){
                echo "error";
            }else{
                $anio=date('Y');
                $query_id = $this->Model_Ceba2->ultimo_cod_alumno($anio);//codigo del alumno select simplewhere por año
                $totalRows_t = count($query_id);
        
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigo="EP1-".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                    $codigo="EP1-".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>98){
                    $codigo="EP1-".$aniof.($totalRows_t+1);
                }
    
                $dato['cod_alum'] = $codigo;
    
                $this->Model_Ceba2->insert_alumno_matricula($dato);
    
                $get_id = $this->Model_Ceba2->ultimo_id_alumno();
                $dato['id_alumno'] = $get_id[0]['id_alumno'];

                //DATOS DE DOCUMENTOS

                $list_documento = $this->Model_Ceba2->get_list_config_documento();

                foreach($list_documento as $list){
                    $dato['id_documento'] = $list['id_config'];
                    $this->Model_Ceba2->insert_documento_alumno_ep1($dato);
                }

                $dato['doc_iden_alumno'] = "";
                $dato['certificado_estudio'] = "";
                $dato['foto'] = "";
                $dato['doc_iden_apoderado'] = "";
                $dato['hoja_matricula_documento'] = "";

                if($datos_documento[0]['doc_iden_alumno']!=""){
                    $config['upload_path'] = './documento_alumno_ep1/doc_iden_alumno/'.$dato['id_alumno'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_alumno_ep1/', 0777);
                        chmod('./documento_alumno_ep1/doc_iden_alumno/', 0777);
                        chmod('./documento_alumno_ep1/doc_iden_alumno/'.$dato['id_alumno'], 0777);
                    }
                    $desde_doc_iden_alumno = 46+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_documento[0]['doc_iden_alumno'],'documento_alumno_ep1/doc_iden_alumno/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['doc_iden_alumno'],$desde_doc_iden_alumno));
                    unlink($datos_documento[0]['doc_iden_alumno']);
                    $dato['doc_iden_alumno'] = 'documento_alumno_ep1/doc_iden_alumno/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['doc_iden_alumno'],$desde_doc_iden_alumno);
                    $dato['id_documento'] = 1;
                    $this->Model_Ceba2->update_documento_alumno_ep1($dato);
                }

                if($datos_documento[0]['certificado_estudio']!=""){
                    $config['upload_path'] = './documento_alumno_ep1/certificado_estudio/'.$dato['id_alumno'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_alumno_ep1/', 0777);
                        chmod('./documento_alumno_ep1/certificado_estudio/', 0777);
                        chmod('./documento_alumno_ep1/certificado_estudio/'.$dato['id_alumno'], 0777);
                    }
                    $desde_certificado_estudio = 50+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_documento[0]['certificado_estudio'],'documento_alumno_ep1/certificado_estudio/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['certificado_estudio'],$desde_certificado_estudio));
                    unlink($datos_documento[0]['certificado_estudio']);
                    $dato['certificado_estudio'] = 'documento_alumno_ep1/certificado_estudio/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['certificado_estudio'],$desde_certificado_estudio);
                    $dato['id_documento'] = 2;
                    $this->Model_Ceba2->update_documento_alumno_ep1($dato);
                }

                if($datos_documento[0]['foto']!=""){
                    $config['upload_path'] = './documento_alumno_ep1/foto/'.$dato['id_alumno'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_alumno_ep1/', 0777);
                        chmod('./documento_alumno_ep1/foto/', 0777);
                        chmod('./documento_alumno_ep1/foto/'.$dato['id_alumno'], 0777);
                    }
                    $desde_foto = 35+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_documento[0]['foto'],'documento_alumno_ep1/foto/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['foto'],$desde_foto));
                    unlink($datos_documento[0]['foto']);
                    $dato['foto'] = 'documento_alumno_ep1/foto/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['foto'],$desde_foto);
                    $dato['id_documento'] = 3;
                    $this->Model_Ceba2->update_documento_alumno_ep1($dato);
                }

                if($datos_documento[0]['doc_iden_apoderado']!=""){
                    $config['upload_path'] = './documento_alumno_ep1/doc_iden_apoderado/'.$dato['id_alumno'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_alumno_ep1/', 0777);
                        chmod('./documento_alumno_ep1/doc_iden_apoderado/', 0777);
                        chmod('./documento_alumno_ep1/doc_iden_apoderado/'.$dato['id_alumno'], 0777);
                    }
                    $desde_doc_iden_apoderado = 49+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_documento[0]['doc_iden_apoderado'],'documento_alumno_ep1/doc_iden_apoderado/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['doc_iden_apoderado'],$desde_doc_iden_apoderado));
                    unlink($datos_documento[0]['doc_iden_apoderado']);
                    $dato['doc_iden_apoderado'] = 'documento_alumno_ep1/doc_iden_apoderado/'.$dato['id_alumno'].'/'.substr($datos_documento[0]['doc_iden_apoderado'],$desde_doc_iden_apoderado);
                    $dato['id_documento'] = 4;
                    $this->Model_Ceba2->update_documento_alumno_ep1($dato);
                }

                //DATOS DE MATRÍCULA

                $get_matricula = $this->Model_Ceba2->ultimo_id_matricula();
                $id_matricula = $get_matricula[0]['id_matricula']+1;
                
                $dato['hoja_matricula'] = "";
                $dato['contrato'] = "";

                if($datos_matricula[0]['hoja_matricula']!=""){
                    $config['upload_path'] = './documento_matricula/hoja_matricula/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula/', 0777);
                        chmod('./documento_matricula/hoja_matricula/', 0777);
                        chmod('./documento_matricula/hoja_matricula/'.$id_matricula, 0777);
                    }
                    $desde_hoja_matricula = 45+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['hoja_matricula'],'documento_matricula/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula));
                    unlink($datos_matricula[0]['hoja_matricula']);
                    $dato['hoja_matricula'] = 'documento_matricula/hoja_matricula/'.$id_matricula.'/'.substr($datos_matricula[0]['hoja_matricula'],$desde_hoja_matricula);
                }

                if($datos_matricula[0]['contrato']!=""){
                    $config['upload_path'] = './documento_matricula/contrato/'.$id_matricula;
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_matricula/', 0777);
                        chmod('./documento_matricula/contrato/', 0777);
                        chmod('./documento_matricula/contrato/'.$id_matricula, 0777);
                    }
                    $desde_contrato = 39+strlen($_SESSION['usuario'][0]['id_usuario']);
                    copy($datos_matricula[0]['contrato'],'documento_matricula/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato));
                    unlink($datos_matricula[0]['contrato']);
                    $dato['contrato'] = 'documento_matricula/contrato/'.$id_matricula.'/'.substr($datos_matricula[0]['contrato'],$desde_contrato);
                }
                
                $this->Model_Ceba2->insert_matricula_alumno($dato);
                $this->Model_Ceba2->delete_temporales();

                //ALUMNO - MATRÍCULA

                $get_matricula = $this->Model_Ceba2->ultimo_id_matricula();
                $dato['id_matricula'] = $get_matricula[0]['id_matricula'];

                $list_unidad = $this->Model_Ceba2->get_list_unidad_activo();

                foreach($list_unidad as $list){
                    $dato['id_unidad'] = $list['id_unidad'];
                    $this->Model_Ceba2->insert_detalle_matricula_alumno($dato);
                }

                //ALUMNO - COMPRAS

                $dato['nom_pago'] = "Matrícula";
                $dato['monto'] = 100;
                $this->Model_Ceba2->insert_pago_matricula_alumno($dato);

                $i = 1;
                
                while($i<=6){
                    $dato['nom_pago'] = "Cuota ".$i;
                    $dato['monto'] = 150;
                    $this->Model_Ceba2->insert_pago_matricula_alumno($dato);
                    $i++;
                }

                //INSERTAR DOCUMENTOS AL ALUMNO
                $get_id = $this->Model_Ceba2->ultimo_id_alumno();
                $dato['id_alumno'] = $get_id[0]['id_alumno']; 
                $dato['anio'] = date('Y');
                $list_documento = $this->Model_Ceba2->get_documentos_asignados($dato['id_grados_activos']);

                if(count($list_documento)>0){
                    foreach($list_documento as $list){
                        $dato['id_documento'] = $list['id_documento'];
                        $this->Model_Ceba2->insert_documentos_alumno($dato);
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Matricula($parametro){
        $list_matricula = $this->Model_Ceba2->get_list_matricula($parametro);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Matrícula');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(14);
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

        $sheet->setCellValue("A1", 'Código Snappy');             
        $sheet->setCellValue("B1", 'Código Arpay');
        $sheet->setCellValue("C1", 'Grado');
        $sheet->setCellValue("D1", 'Celular');
        $sheet->setCellValue("E1", 'Apellido Paterno'); 
        $sheet->setCellValue("F1", 'Apellido Materno'); 
        $sheet->setCellValue("G1", 'Nombre(s)');
        $sheet->setCellValue("H1", 'Fecha Registro');
        $sheet->setCellValue("I1", 'Departamento');
        $sheet->setCellValue("J1", 'Provincia'); 
        $sheet->setCellValue("K1", 'Edad'); 
        $sheet->setCellValue("L1", 'Matriculado');
        $sheet->setCellValue("M1", 'Estado');

        $contador=1;
        
        foreach($list_matricula as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_alum']);
            $sheet->setCellValue("B{$contador}", $list['cod_arpay']);
            $sheet->setCellValue("C{$contador}", $list['descripcion_grado']);
            $sheet->setCellValue("D{$contador}", $list['alum_celular']);
            $sheet->setCellValue("E{$contador}", $list['alum_apater']); 
            $sheet->setCellValue("F{$contador}", $list['alum_amater']);
            $sheet->setCellValue("G{$contador}", $list['alum_nom']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fecha_registro']));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("J{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("K{$contador}", $list['alum_edad']);
            $sheet->setCellValue("L{$contador}", $list['cant_matricula']);
            $sheet->setCellValue("M{$contador}", $list['nom_estadoa']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Matrícula (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------ARTÍCULOS-------------------------------------------
    public function Unidad() {
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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/unidad/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Unidad() {
        if ($this->session->userdata('usuario')) {
            $dato['list_unidad'] = $this->Model_Ceba2->get_list_unidad_ep1();
            $this->load->view('ceba2/unidad/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Unidad(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('ceba2/unidad/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Unidad(){
        $dato['nom_unidad']= $this->input->post("nom_unidad_i");
        $dato['inicio_clase']= $this->input->post("inicio_clase_i");
        $dato['fin_clase']= $this->input->post("fin_clase_i");
        $dato['inicio_matricula']= $this->input->post("inicio_matricula_i");
        $dato['fin_matricula']= $this->input->post("fin_matricula_i");  
        $this->Model_Ceba2->insert_unidad_ep1($dato);
    }

    public function Modal_Update_Unidad($id_unidad){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_unidad_ep1($id_unidad);
            $dato['list_estado'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/unidad/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Unidad(){
        $dato['id_unidad']= $this->input->post("id_unidad");
        $dato['nom_unidad']= $this->input->post("nom_unidad_u");
        $dato['inicio_clase']= $this->input->post("inicio_clase_u");
        $dato['fin_clase']= $this->input->post("fin_clase_u");
        $dato['inicio_matricula']= $this->input->post("inicio_matricula_u");
        $dato['fin_matricula']= $this->input->post("fin_matricula_u");  
        $dato['estado']= $this->input->post("estado_u"); 
        $this->Model_Ceba2->update_unidad_ep1($dato);
    }

    public function Delete_Unidad(){
        $dato['id_unidad']= $this->input->post("id_unidad");
        $this->Model_Ceba2->delete_unidad_ep1($dato);
    }

    public function Excel_Unidad(){
        $list_unidad = $this->Model_Ceba2->get_list_unidad_ep1();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Unidad');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
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

        $sheet->setCellValue("A1", 'Nombre');             
        $sheet->setCellValue("B1", 'Inicio Clases');
        $sheet->setCellValue("C1", 'Fin Clases');
        $sheet->setCellValue("D1", 'Inicio Matrícula');
        $sheet->setCellValue("E1", 'Fin Matrícula'); 
        $sheet->setCellValue("F1", 'Estado');

        $contador=1;
        
        foreach($list_unidad as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_unidad']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['inicio_clase']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fin_clase']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['inicio_matricula']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fin_matricula']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Unidad (Lista)';
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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/documento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_Ceba2->get_list_documento();
            $this->load->view('ceba2/documento/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $this->load->view('ceba2/documento/modal_registrar',$dato);   
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

        $total=count($this->Model_Ceba2->valida_insert_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ceba2->insert_documento($dato);
            if($dato['aplicar_todos']==1){
                $get_id = $this->Model_Ceba2->ultimo_id_documento();
                $dato['id_documento'] = $get_id[0]['id_documento'];

                $list_alumno = $this->Model_Ceba2->get_list_todos_alumno();

                foreach($list_alumno as $list){
                    $dato['id_alumno'] = $list['id_alumno'];

                    if($dato['obligatorio']>0){
                        $dato['v_obligatorio'] = 1;
                    }else{
                        $dato['v_obligatorio'] = 0;
                    }
                    $this->Model_Ceba2->insert_documento_todos($dato);
                }
            }
        }
    }

    public function Modal_Update_Documento($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ceba2->get_list_documento($id_documento);
            $dato['list_grado'] = $this->Model_Ceba2->get_list_grado_combo();
            $dato['list_status'] = $this->Model_Ceba2->get_list_estado();
            $this->load->view('ceba2/documento/modal_editar', $dato);   
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
        $dato['digital']= $this->input->post("digital_u");
        $dato['aplicar_todos']= $this->input->post("aplicar_todos_u");
        $dato['estado']= $this->input->post("estado_u");
        $dato['validacion']= $this->input->post("validacion_u");

        $total=count($this->Model_Ceba2->valida_update_documento($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ceba2->update_documento($dato);
            $list_alumno = $this->Model_Ceba2->get_list_todos_alumno();                
            foreach($list_alumno as $list){                   
                $dato['id_alumno'] = $list['id_alumno'];
                if($dato['obligatorio']>0){
                    $dato['v_obligatorio'] = 1;
                }else{
                    $dato['v_obligatorio'] = 0;
                }
                $this->Model_Ceba2->update_documento_todos($dato);
                
            }            
        }
    }

    public function Delete_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_Ceba2->delete_documento($dato);
    }

    public function Excel_Documento(){
        $list_documento = $this->Model_Ceba2->get_list_documento();

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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/doc_alumno/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Doc_Alumno() {
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_Ceba2->get_list_todos_alumno();
            $this->load->view('ceba2/doc_alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Doc_Alumno(){
        $list_alumno = $this->Model_Ceba2->get_list_todos_alumno();
        $list_documento = $this->Model_Ceba2->get_list_doc_alumnos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:Q2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Doc. Alumnos');

        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(15);
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
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(50);
        $sheet->getColumnDimension('Q')->setWidth(50);

        $sheet->getStyle('A1:Q2')->getFont()->setBold(true);    

        $spreadsheet->getActiveSheet()->getStyle("A1:Q2")->getFill()
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

        $sheet->getStyle("A1:Q2")->applyFromArray($styleThinBlackBorderOutline);

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

        $sheet->setCellValue("A1", 'Foto');
        $sheet->setCellValue("B1", 'Código Snappy');
        $sheet->setCellValue("C1", 'Código Arpay');           
        $sheet->setCellValue("D1", 'Grado');
        $sheet->setCellValue("E1", 'Celular');
        $sheet->setCellValue("F1", 'Ap. Paterno');
        $sheet->setCellValue("G1", 'Ap. Materno');
        $sheet->setCellValue("H1", 'Nombre(s)');
        $sheet->setCellValue("I1", 'Fec. Registro');
        $sheet->setCellValue("J1", 'Creado Por');
        $sheet->setCellValue("K1", 'Departamento');
        $sheet->setCellValue("L1", 'Provincia');
        $sheet->setCellValue("M1", 'Edad');
        $sheet->setCellValue("N1", 'Matricula');
        $sheet->setCellValue("O1", 'Estado');
        $sheet->setCellValue("P1", 'Observaciones');
        $sheet->setCellValue("Q1", 'Link Foto');
        
        $primera_letra = "R";
        $segunda_letra = "S";
        $tercera_letra = "T";

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
        
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("O{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("Q{$contador}")->getFont()->setUnderline(true);  

            $sheet->setCellValue("A{$contador}", $list['foto']);
            $sheet->setCellValue("B{$contador}", $list['cod_alum']);
            $sheet->setCellValue("C{$contador}", $list['cod_arpay']);
            $sheet->setCellValue("D{$contador}", $list['descripcion_grado']);
            $sheet->setCellValue("E{$contador}", $list['alum_celular']);
            $sheet->setCellValue("F{$contador}", $list['alum_apater']);
            $sheet->setCellValue("G{$contador}", $list['alum_amater']);
            $sheet->setCellValue("H{$contador}", $list['alum_nom']);
            if($list['fecha_registro']!="00/00/0000"){
                $sheet->setCellValue("I{$contador}",  Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH);
            }else{
                $sheet->setCellValue("I{$contador}", "");
            }
            if($list['usuario_codigo'] !='0' ) {
                $sheet->setCellValue("J{$contador}", $list['usuario_codigo']);
            }else{ 
                $sheet->setCellValue("J{$contador}", "Web");
            }
            $sheet->setCellValue("K{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("L{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("M{$contador}", $list['alum_edad']);
            $sheet->setCellValue("N{$contador}", $list['cant_matricula']);
            $sheet->setCellValue("O{$contador}", $list['nom_estadoa']);
            $sheet->setCellValue("P{$contador}", $list['observaciones']);  
            if($list['link_foto']!=""){
                $sheet->setCellValue("Q{$contador}", base_url().$list['link_foto']);
                $sheet->getCell("Q{$contador}")->getHyperlink()->setURL(base_url().$list['link_foto']);
            }else{
                $sheet->setCellValue("Q{$contador}", "");
            }  

            $primera_letra = "R";
            $segunda_letra = "S";
            $tercera_letra = "T";

            foreach($list_documento as $documento){
                $sheet->getStyle("$primera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$segunda_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("$tercera_letra{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("$primera_letra{$contador}:$tercera_letra{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $list_detalle = $this->Model_Ceba2->get_list_detalle_doc_alumnos($list['id_alumno'],$documento['cod_documento']);

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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/alumno_obs/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno_Obs() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_alumno_obs'] = $this->Model_Ceba2->get_list_alumno_obs();
            $this->load->view('ceba2/alumno_obs/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    public function Excel_Alumno_Obs(){
        $list_alumno_obs = $this->Model_Ceba2->get_list_alumno_obs();

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
        $sheet->getColumnDimension('H')->setWidth(13);
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

        $sheet->setCellValue("A1", 'Empresa');	        
        $sheet->setCellValue("B1", 'Fecha');	        
        $sheet->setCellValue("C1", 'Usuario');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Apellido Pat.');
        $sheet->setCellValue("F1", 'Apellido Mat.');
        $sheet->setCellValue("G1", 'Nombre(s)');	
        $sheet->setCellValue("H1", 'Grado');	  
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
            $sheet->setCellValue("H{$contador}", $list['descripcion_grado']); 
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
            $dato['list_nav_sede'] = $this->Model_Ceba2->get_list_nav_sede();

            $this->load->view('ceba2/soporte_doc/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Soporte_Doc() {
        if ($this->session->userdata('usuario')) {
            $dato['list_soporte_doc'] = $this->Model_Ceba2->get_list_soporte_doc();
            $this->load->view('ceba2/soporte_doc/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Soporte_Doc(){
        $list_soporte_doc = $this->Model_Ceba2->get_list_soporte_doc();

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
}
