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

class Administrador extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Ceba');
        $this->load->model('Admin_model');
        $this->load->model('Model_General');
        $this->load->model('Model_snappy');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper('download');
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

    public function proyectos(){
        if ($this->session->userdata('usuario')) { 
            $data['list_disenador'] = $this->Admin_model->get_usuario_subtipo1();
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

            $data['tipo_proyecto']=$this->Admin_model->buscar_tipo();

            //AVISO NO BORRAR
            $data['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $data['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $data['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $data['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $data['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $data['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $data['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();

            $id_estatus=0;
            $data['status']=  $id_estatus;
            $data['row_p'] =$this->Admin_model->get_row_p($id_estatus);
            $data['cant']=count($data['row_p']);

            $data['list_empresab'] =$this->Admin_model->list_empresa_proyecto();
            $data['list_sedeb'] =$this->Admin_model->list_sede_proyecto();

            $this->load->view('administrador/proyecto/index_proyect', $data);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
 
    public function Busqueda(){
        $id_estatus= $this->input->post('status');
        
        $data['status']=  $id_estatus;
        $data['row_p'] =$this->Admin_model->get_row_p($id_estatus);
        $data['cant']=count($data['row_p']);

        $data['list_empresa'] =$this->Admin_model->list_empresa_proyecto();
        $data['list_sede'] =$this->Admin_model->list_sede_proyecto();

        /*$nivel = $_SESSION['usuario'][0]['id_nivel'];
        if($nivel==2){
            $this->load->view('teamleader/proyecto/busqueda', $data);
        }else{*/
            $this->load->view('administrador/proyecto/busqueda', $data);
        /*}*/
        
    }

    public function Asignar_Disenador(){
        if ($this->session->userdata('usuario')) {
            $cadena = substr($this->input->post("cadena"),0,-1); 
            $cantidad = $this->input->post("cantidad"); 
            $dato['id_disenador'] = $this->input->post("id_disenador"); 

            if($cantidad>0){
                $array = explode(",",$cadena);
                $i = 0;

                while($i<count($array)){
                    $dato['id_proyecto'] = $array[$i];
                    $this->Admin_model->update_disenador_proyecto($dato);
                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_proyect($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['row_t'] =$this->Admin_model->get_row_t();
            $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            
            $dato['id_tipo']=$dato['get_id'][0]['id_tipo'];
            
            
            $dato['row_s'] = $this->Admin_model->get_row_s();
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/proyecto/editar_proyect_v',$dato);
        }
        else{
            redirect('/login');
        }

    }

    public function Empresa_Sede(){
        if ($this->session->userdata('usuario')) {
            //ANTES
            /*$cantidad_empresa = $this->input->post("id_empresa");
            $dato['funciona_array'] = 0;

            $empresas="";
            $i=0;

            if($cantidad_empresa!=""){
                foreach($_POST['id_empresa'] as $id_empresa){
                    $empresas=$empresas.$id_empresa.",";
                    $i++;
                }
    
                $dato['empresas']=substr($empresas,0,-1);
                $dato['id_sede'] = $this->input->post("id_sede");
                if($i==1){
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
                }else{
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_varios($dato);
                }
            }else{
                $dato['funciona_array']=1;
            }
            
            $this->load->view('administrador/proyecto/sedes',$dato);*/

            //AHORA
            $dato['empresas'] = $this->input->post("id_empresa");
            $dato['funciona_array'] = 0;

            if($dato['empresas']==0){
                $dato['funciona_array']=1;
            }else{
                $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
            }

            $this->load->view('administrador/proyecto/sedes',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Desaparecer_Sede(){
        if ($this->session->userdata('usuario')) {
        
            $dato['id_tipo']= $this->input->post("id_tipo");
            

            $this->load->view('administrador/proyecto/blanco',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function nuevo_proyect(){
        if ($this->session->userdata('usuario')) {
            $data['solicitado'] =$this->Admin_model->get_solicitado();
            $data['row_t'] =$this->Admin_model->get_row_t();
            $data['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $data['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $this->load->view('administrador/proyecto/nuevo_proyect',$data);
        }
        else{
            redirect('/login');
        }
    }

    public function subtipo() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $id_tipo= $this->input->post("id_tipo");
        $dato['id_tipo']= $this->input->post("id_tipo");
        
        
        $cadena="";
        foreach($_POST['id_empresa'] as $id_empresa){
            $id_empresa=$id_empresa;
            $cadena.=$id_empresa.",";
        }
        $empresas = substr($cadena, 0, -1);

        $dato['empresas'] = "(".$empresas.")";

        if($id_tipo==15 || $id_tipo==34){
            $dato['list_subtipo'] = $this->Admin_model->getsubtipo($id_tipo);
        
        }else{
            $dato['list_subtipo'] = $this->Admin_model->getsubtipo_xempresa($dato);
        }
        $this->load->view('administrador/proyecto/cmb_subtipo',$dato);
        
    }

    public function subtipo_xtipo() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $id_tipo= $this->input->post("id_tipo");
        $id_empresa= $this->input->post("id_empresa");
        
        $dato['list_subtipo'] = $this->Admin_model->getsubtipo($id_tipo,$id_empresa);
        
        $this->load->view('administrador/proyecto/cmb_subtipo',$dato);
        
    }

    public function subtipo_vacio() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $this->load->view('administrador/proyecto/cmb_subtipo_vc');
    }

    public function Cambio_Week_Arte() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $id_tipo= $this->input->post("id_tipo");
        $id_subtipo= $this->input->post("id_subtipo");
        
        $dato['get_sub'] = $this->Admin_model->sub_redes($id_tipo,$id_subtipo);
        
        $this->load->view('administrador/proyecto/msartes',$dato);
        
    }

    public function Cambio_Week_Red() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $id_tipo= $this->input->post("id_tipo");
        $id_subtipo= $this->input->post("id_subtipo");
        
        $dato['get_sub'] = $this->Admin_model->sub_redes($id_tipo,$id_subtipo);
        
        $this->load->view('administrador/proyecto/msredes',$dato);
        
    }

    public function Refresca_Empresa() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
        $this->load->view('administrador/proyecto/mempresa',$dato);
    }

    public function sub_tipo($id_tipo="00", $id_subtipo="00") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->get_sub_tipo($id_tipo,$id_subtipo);
        echo json_encode($data);
    }

    public function insert_proyecto() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $fechaComoEntero = strtotime($dato['fec_agenda']);
        $dato['mes']=date("m", $fechaComoEntero);
        $dato['dia']=date("d", $fechaComoEntero);
        //$dato['mes']=substr($this->input->post("fec_agenda"),5,2);
        //$dato['dia']=substr($this->input->post("fec_agenda"),8,2);
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
        $dato['anio']= $anio;
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['id_subtipo']= $this->input->post("id_subtipo");
        $dato['s_artes']= $this->input->post("s_artes");
        $dato['s_redes']= $this->input->post("s_redes");
        $dato['prioridad']= $this->input->post("prioridad");
        $dato['descripcion']= $this->input->post("descripcion");
        $dato['proy_obs']= $this->input->post("proy_obs");
        $dato['color']=$id_color;
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['copy']= $this->input->post("copy");
        $this->Admin_model->insert_proyecto($dato);

        if($dato['id_tipo']!=15 && $dato['id_tipo']!=20 && $dato['id_tipo']!=34 &&  $dato['id_tipo']!=22 ){
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

    public function update_proyecto(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $dato['fec_agenda']= $this->input->post("fec_agenda");
        $dato['mes']=substr($this->input->post("fec_agenda"),5,2);
        $dato['dia']=substr($this->input->post("fec_agenda"),8,2);
        $dato['iniciosf'] = strtotime($dato['fec_agenda']);

        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $dato['id_proyecto']= $this->input->post("id_proyecto");

        $cod_proyecto = $this->Admin_model->proyecto_cod($dato['id_proyecto']);
        $dato['cod_proyecto'] =$cod_proyecto;
        $dato['id_solicitante']= $this->input->post("id_solicitante");
        $dato['id_tipo']= $this->input->post("id_tipo");
        $dato['subtipobd']= $this->input->post("subtipobd");
        $dato['id_subtipo']=$this->input->post("id_subtipo");

        $id_subtipo=$this->input->post("subtipobd");
        if($id_subtipo!=0){
            $dato['get_subtipo'] = $this->Model_snappy->get_id_subtipo($id_subtipo);
            if($dato['get_subtipo'][0]['estado']!=2 && $dato['id_subtipo']!=$id_subtipo){
                $dato['id_subtipo']=$this->input->post("id_subtipo");
            }elseif($dato['get_subtipo'][0]['estado']==2 && $dato['id_subtipo']!=$id_subtipo){
                $dato['id_subtipo']= $this->input->post("id_subtipo");
            }else{
                $dato['id_subtipo']= $this->input->post("subtipobd");
            }
        }else{
            $dato['id_subtipo']=$this->input->post("id_subtipo");
        }

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
        $dato['proy_obs']= $this->input->post("proy_obs");
        $dato['copy']= $this->input->post("copy");
        $dato['hora']= $this->input->post("hora");
        $dato['publicidad_pagada']= $this->input->post("publicidad_pagada");
        //$totalRows_c = count($query_c);
        if(count($query_c)>0){
            $dato['color']=$query_c[0]['color'];
        }else{
            $dato['color']="";
        }
        
        $query_ca = $this->Admin_model->query_calendar($dato);
        $dato['totalRows_ca']=count($query_ca);

        $query_cr = $this->Admin_model->query_redes($dato);
        $dato['totalRows_cr']=count($query_cr);
        $dato['id_empresa']= $this->input->post("id_empresa");
        $this->Admin_model->update_proyecto($dato);

        
        $this->Admin_model->reiniciar_proyecto_sede($dato);
        $sedes = $this->input->post("id_sede");
        if($sedes!=""){
            foreach($_POST['id_sede'] as $id_sede){
                $dato['id_sede']=$id_sede;
    
                $this->Admin_model->update_proyecto_sede($dato); 
            }
        }
    }

    public function Registrar_Proyecto(){
        if ($this->session->userdata('usuario')) { 
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['list_tipo'] =$this->Admin_model->get_row_t();
            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();

            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('administrador/proyecto/registrar',$dato);
        }
        else{
            redirect('/login');
        }

    }

    public function Detalle_Proyecto($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
            //$dato['get_empresa'] = $this->Admin_model->get_id_empresa_proyecto($id_proyecto);
            $dato['list_tipo'] =$this->Admin_model->get_row_t();
            $dato['list_subtipo'] =$this->Admin_model->edit_sub_tipo();

            //$get_empresa = $this->Admin_model->get_id_empresa_proyecto($id_proyecto);

            /*$dato['cantidad_empresa']=count($get_empresa);

            $i=0;
            $empresas="";

            while($i<count($get_empresa)){
                $empresas=$empresas.$get_empresa[$i]['id_empresa'].",";
                $i=$i+1;
            }*/

            $dato['empresas']=$dato['get_id'][0]['id_empresa'];

            if($dato['get_id'][0]['id_empresa']!=0){
                $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);
                /*if(count($get_empresa)==1){
                    
                }else{
                    $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_varios($dato);
                }*/
            }else{
                $dato['list_sede'] = $this->Admin_model->get_list_sede();
            }

            $dato['get_sede'] = $this->Admin_model->get_id_sede_proyecto($id_proyecto);

            $dato['row_s'] = $this->Admin_model->get_row_s();
            $dato['usuario_subtipo'] = $this->Admin_model->get_usuario_subtipo();
            $dato['usuario_subtipo1'] = $this->Admin_model->get_usuario_subtipo1();
            
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

            $this->load->view('administrador/proyecto/detalle',$dato);
        }
        else{
            redirect('/login');
        }

    }

    public function Descargar_Imagen_Proyecto($id_proyecto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Admin_model->get_id_proyecto($id_proyecto);
            $image = $dato['get_file'][0]['imagen'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['imagen']));
        }
        else{
            redirect('');
        }
    }

    public function Excel_proyec2($id_status){
        $proyectos = $this->Admin_model->get_row_p($id_status);
        //$list_empresa =$this->Admin_model->list_empresa_proyecto();
        //$list_sede =$this->Admin_model->list_sede_proyecto();

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
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            /*$cod_sede="";
            foreach($list_sede as $sede){
                if($sede['id_proyecto']==$list['id_proyecto']){
                    $cod_sede=$cod_sede.$sede['cod_sede'].",";
                }
            }
            if($cod_sede==""){
                $cod_sede="";
            }else{
                $cod_sede=substr($cod_sede,0,-1);
            }*/
            
            /*$cod_empresa="";
            foreach($list_empresa as $empresa){
                if($empresa['id_proyecto']==$list['id_proyecto']){
                    $cod_empresa=$cod_empresa.$empresa['cod_empresa'].",";
                }
            }
            if($cod_empresa==""){
                $cod_empresa="";
            }else{
                $cod_empresa=substr($cod_empresa,0,-1);
            }*/

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['prioridad']);
            $sheet->setCellValue("B{$contador}", $list['cod_proyecto']);
            $sheet->setCellValue("C{$contador}", $list['nom_statusp']);
            $sheet->setCellValue("D{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("E{$contador}", $list['cod_sede']);
            $sheet->setCellValue("F{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("G{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("H{$contador}", $list['descripcion']);
            $sheet->setCellValue("I{$contador}", ($list['s_artes']+$list['s_redes']));
            if ($list['fecha_agenda']!='00/00/0000'){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['fecha_agenda']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("K{$contador}", $list['ucodigo_solicitado']);
            if ($list['fecha_solicitante']!='00/00/0000'){ 
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fecha_solicitante']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            
            $sheet->setCellValue("M{$contador}", $list['ucodigo_asignado']);
            if ($list['fecha_termino']!='00/00/0000'){ 
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

    public function Excel_proyec($status){
        $proyectos = $this->Admin_model->get_row_p($status);
         //$data['diseniador_det'] = $this->N_diseniador->get_detalle($id_usuario);
        if(count($proyectos) > 0){
            //Cargamos la librería de excel.
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Lista_Proyectos');
            
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
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
            $this->excel->getActiveSheet()->getStyle("V{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("W{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("X{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Y{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("Z{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:Z1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));
            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:Z1');
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Pri.');           
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Código');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Status');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'GL0');
            $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'GL1');
            $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'GL2');
            $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'BL1');
            $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'LL1');
            $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'LL2');
            $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'LS1');
            $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'LS2');
            $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'EP1');
            $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'EP2');
            $this->excel->getActiveSheet()->setCellValue("N{$contador}", 'FV1');
            $this->excel->getActiveSheet()->setCellValue("O{$contador}", 'FV2');
            $this->excel->getActiveSheet()->setCellValue("P{$contador}", 'LA0');
            $this->excel->getActiveSheet()->setCellValue("Q{$contador}", 'VJ1');
            $this->excel->getActiveSheet()->setCellValue("R{$contador}", 'Tipo');
            $this->excel->getActiveSheet()->setCellValue("S{$contador}", 'SubTipo');
            $this->excel->getActiveSheet()->setCellValue("T{$contador}", 'Descripción');
            $this->excel->getActiveSheet()->setCellValue("U{$contador}", 'Snappys');
            $this->excel->getActiveSheet()->setCellValue("V{$contador}", 'Agenda');
            $this->excel->getActiveSheet()->setCellValue("W{$contador}", 'Usuario');
            $this->excel->getActiveSheet()->setCellValue("X{$contador}", 'Fecha');
            $this->excel->getActiveSheet()->setCellValue("Y{$contador}", 'Usuario');
            $this->excel->getActiveSheet()->setCellValue("Z{$contador}", 'Fecha');

            //Definimos la data del cuerpo.
            foreach($proyectos as $list){
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['prioridad']);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['cod_proyecto']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['nom_statusp']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['GL0']);
                $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['GL1']);
                $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['GL2']);
                $this->excel->getActiveSheet()->setCellValue("G{$contador}", $list['BL1']);
                $this->excel->getActiveSheet()->setCellValue("H{$contador}", $list['LL1']);
                $this->excel->getActiveSheet()->setCellValue("I{$contador}", $list['LL2']);
                $this->excel->getActiveSheet()->setCellValue("J{$contador}", $list['LS1']);
                $this->excel->getActiveSheet()->setCellValue("K{$contador}", $list['LS2']);
                $this->excel->getActiveSheet()->setCellValue("L{$contador}", $list['EP1']);
                $this->excel->getActiveSheet()->setCellValue("M{$contador}", $list['EP2']);
                $this->excel->getActiveSheet()->setCellValue("N{$contador}", $list['FV1']);
                $this->excel->getActiveSheet()->setCellValue("O{$contador}", $list['FV2']);
                $this->excel->getActiveSheet()->setCellValue("P{$contador}", $list['LA0']);
                $this->excel->getActiveSheet()->setCellValue("Q{$contador}", $list['VJ1']);
                $this->excel->getActiveSheet()->setCellValue("R{$contador}", $list['nom_tipo']);
                $this->excel->getActiveSheet()->setCellValue("S{$contador}", $list['nom_subtipo']);
                $this->excel->getActiveSheet()->setCellValue("T{$contador}", $list['descripcion']);
                $this->excel->getActiveSheet()->setCellValue("U{$contador}", $list['s_artes']+$list['s_redes']);
                $this->excel->getActiveSheet()->setCellValue("V{$contador}", $list['fec_agenda']);
                $this->excel->getActiveSheet()->setCellValue("W{$contador}", $list['ucodigo_solicitado']);
                $this->excel->getActiveSheet()->setCellValue("X{$contador}", $list['fec_solicitante']);
                $this->excel->getActiveSheet()->setCellValue("Y{$contador}", $list['ucodigo_asignado']);
                $this->excel->getActiveSheet()->setCellValue("Z{$contador}", $list['fec_termino']);
            }
            //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Proyectos.xls";
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

    public function Validar_Importar_Proyectos() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   

            $path = $_FILES["archivo_excel"]["tmp_name"]; 
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['prioridad'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['nom_tipo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['nom_subtipo'] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $dato['snappys'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $dato['descripcion'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['proy_obs'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $dato['id_asignado'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $dato['fec_agenda'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                    $dato['nom_statusp'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $excelDate1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['duplicado1'] = NumberFormat::toFormattedString($excelDate1, 'YYYY-MM-DD');
                    $excelDate2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['duplicado2'] = NumberFormat::toFormattedString($excelDate2, 'YYYY-MM-DD');
                    $excelDate3 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['duplicado3'] = NumberFormat::toFormattedString($excelDate3, 'YYYY-MM-DD');
                    $excelDate4 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $dato['duplicado4'] = NumberFormat::toFormattedString($excelDate4, 'YYYY-MM-DD');
                    $excelDate5 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $dato['duplicado5'] = NumberFormat::toFormattedString($excelDate5, 'YYYY-MM-DD');

                    $dato['hay_fecha'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $dato['d1'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['d2'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['d3'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['d4'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $dato['d5'] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();

                    if($dato['prioridad']=="" && $dato['cod_empresa']=="" && $dato['cod_sede']=="" && $dato['nom_tipo']=="" && $dato['nom_subtipo']=="" &&
                    $dato['descripcion']=="" && $dato['proy_obs']=="" && $dato['id_asignado']=="" && $dato['hay_fecha']=="" && $dato['nom_statusp']=="" &&
                    $dato['d1']=="" && $dato['d2']=="" && $dato['d3']=="" && $dato['d4']=="" && $dato['d5']==""){
                        break;
                    }

                    $empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if($empresa[$posicion_empresa]['id_empresa']!=""){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }

                    $tipo=$this->Admin_model->buscar_tipo();
                    $posicion_tipo=array_search($dato['nom_tipo'],array_column($tipo,'nom_tipo'));

                    if($tipo[$posicion_tipo]['id_tipo']!="" && $empresa[$posicion_empresa]['id_empresa']!=""){
                        $subtipo=$this->Admin_model->buscar_subtipo($tipo[$posicion_tipo]['id_tipo'],$empresa[$posicion_empresa]['id_empresa']);
                        $posicion_subtipo=array_search($dato['nom_subtipo'],array_column($subtipo,'nom_subtipo'));
                    }else{
                        $posicion_subtipo="";
                    }

                    $asignado=$this->Admin_model->buscar_usuario();
                    $posicion_asignado=array_search($dato['id_asignado'],array_column($asignado,'usuario_codigo'));

                    $estado=$this->Admin_model->buscar_estado_proyecto();
                    $posicion_estado=array_search($dato['nom_statusp'],array_column($estado,'nom_statusp'));

                    $dato['v_prioridad']=0;
                    $dato['v_empresa']=0;
                    $dato['v_sede']=0;
                    $dato['v_tipo']=0;
                    $dato['v_subtipo']=0;
                    $dato['v_descripcion']=0;
                    $dato['v_asignado']=0;
                    $dato['v_agenda']=0;
                    $dato['v_estado']=0;

                    if($dato['prioridad']==0 || !is_numeric($dato['prioridad']) || $dato['prioridad']==""){
                        $dato['v_prioridad']=1;
                    }
                    if(!is_numeric($posicion_empresa)){
                        $dato['v_empresa']=1;
                    }
                    if($tipo[$posicion_tipo]['id_tipo']!=15 && $tipo[$posicion_tipo]['id_tipo']!=20 && $tipo[$posicion_tipo]['id_tipo']!=34){
                        if(!is_numeric($posicion_sede)){
                            $dato['v_sede']=1;
                        }
                    }
                    if(!is_numeric($posicion_tipo)){
                        $dato['v_tipo']=1;
                    }
                    if(!is_numeric($posicion_subtipo)){
                        $dato['v_subtipo']=1;
                    }
                    if($dato['descripcion']==""){
                        $dato['v_descripcion']=1;
                    }
                    if(!is_numeric($posicion_asignado)){
                        $dato['v_asignado']=1;
                    }
                    if($dato['fec_agenda']=="" && ($tipo[$posicion_tipo]['id_tipo']==15 || $tipo[$posicion_tipo]['id_tipo']==20 || $tipo[$posicion_tipo]['id_tipo']==34)){
                        $dato['v_agenda']=1;
                    }
                    if(!is_numeric($posicion_estado)){
                        $dato['v_estado']=1;
                    }

                    $this->Admin_model->insert_temporal_proyecto($dato); 
                }
            //}

            $correctos=count($this->Admin_model->get_list_temporal_proyecto_correcto());
            $errores=$this->Admin_model->get_list_temporal_proyecto($dato); 

            if($correctos==count($errores)){
                $dato['archivo_excel']= $this->input->post("archivo_excel");   

                $path = $_FILES["archivo_excel"]["tmp_name"];
                $object = IOFactory::load($path);
                $worksheet = $object->getSheet(0);
                //foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['prioridad'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $dato['nom_tipo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $dato['nom_subtipo'] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                        $dato['snappys'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $dato['descripcion'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $dato['proy_obs'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $dato['id_asignado'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $excelDate = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $dato['fec_agenda'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                        $dato['nom_statusp'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $excelDate1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $dato['duplicado1'] = NumberFormat::toFormattedString($excelDate1, 'YYYY-MM-DD');
                        $excelDate2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $dato['duplicado2'] = NumberFormat::toFormattedString($excelDate2, 'YYYY-MM-DD');
                        $excelDate3 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $dato['duplicado3'] = NumberFormat::toFormattedString($excelDate3, 'YYYY-MM-DD');
                        $excelDate4 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $dato['duplicado4'] = NumberFormat::toFormattedString($excelDate4, 'YYYY-MM-DD');
                        $excelDate5 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $dato['duplicado5'] = NumberFormat::toFormattedString($excelDate5, 'YYYY-MM-DD');

                        $dato['hay_fecha'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue(); 
                        $dato['d1'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $dato['d2'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $dato['d3'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $dato['d4'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $dato['d5'] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();

                        if($dato['prioridad']=="" && $dato['cod_empresa']=="" && $dato['cod_sede']=="" && $dato['nom_tipo']=="" && $dato['nom_subtipo']=="" &&
                        $dato['descripcion']=="" && $dato['proy_obs']=="" && $dato['id_asignado']=="" && $dato['hay_fecha']=="" && $dato['nom_statusp']=="" &&
                        $dato['d1']=="" && $dato['d2']=="" && $dato['d3']=="" && $dato['d4']=="" && $dato['d5']==""){
                            break;
                        }
    
                        $empresa=$this->Admin_model->buscar_empresa();
                        $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                        if($empresa[$posicion_empresa]['id_empresa']!=""){
                            $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                            $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                        }else{
                            $posicion_sede="";
                        }
    
                        $tipo=$this->Admin_model->buscar_tipo();
                        $posicion_tipo=array_search($dato['nom_tipo'],array_column($tipo,'nom_tipo'));
    
                        if($tipo[$posicion_tipo]['id_tipo']!="" && $empresa[$posicion_empresa]['id_empresa']!=""){
                            $subtipo=$this->Admin_model->buscar_subtipo($tipo[$posicion_tipo]['id_tipo'],$empresa[$posicion_empresa]['id_empresa']);
                            $posicion_subtipo=array_search($dato['nom_subtipo'],array_column($subtipo,'nom_subtipo'));
                        }else{
                            $posicion_subtipo="";
                        }    

                        $asignado=$this->Admin_model->buscar_usuario();
                        $posicion_asignado=array_search($dato['id_asignado'],array_column($asignado,'usuario_codigo'));

                        $estado=$this->Admin_model->buscar_estado_proyecto();
                        $posicion_estado=array_search($dato['nom_statusp'],array_column($estado,'nom_statusp'));

                        $anio=date('Y');
                        $query_id = $this->Admin_model->ultimo_cod_proyecto($anio);
                        $totalRows_t = count($query_id);
    
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
    
                        $dato['cod_proyecto']=$codigo;
                        $dato['id_tipo'] = $tipo[$posicion_tipo]['id_tipo'];
                        $dato['id_subtipo'] = $subtipo[$posicion_subtipo]['id_subtipo'];
                        $dato['s_artes'] = $subtipo[$posicion_subtipo]['tipo_subtipo_arte'];
                        $dato['s_redes'] = $subtipo[$posicion_subtipo]['tipo_subtipo_redes'];
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                        $dato['id_asignado'] = $asignado[$posicion_asignado]['id_usuario'];
                        $dato['status'] = $estado[$posicion_estado]['id_statusp'];
                        $dato['anio'] = $anio;
                        $dato['color'] = $this->Admin_model->get_colorestatus();

                        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $dato['iniciosf'] = strtotime($dato['fec_agenda']);
                        $fechaComoEntero = strtotime($dato['fec_agenda']);
                        $dato['mes']=date("m", $fechaComoEntero);
                        $dato['dia']=date("d", $fechaComoEntero);

                        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
                        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
    
                        $this->Admin_model->importar_proyectos($dato);
                        
                        $ultimo = $this->Admin_model->ultimo_id_proyecto();
                        $dato['id_proyecto'] = $ultimo[0]['id_proyecto'];

                        $this->Admin_model->importar_proyectos_sede($dato); 

                        if($dato['duplicado1']!=""){
                            $dato['duplicado'] = $dato['duplicado1'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado2']!=""){
                            $dato['duplicado'] = $dato['duplicado2'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado3']!=""){
                            $dato['duplicado'] = $dato['duplicado3'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado4']!=""){
                            $dato['duplicado'] = $dato['duplicado4'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado5']!=""){
                            $dato['duplicado'] = $dato['duplicado5'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }
                        
                    }
                //}
                
            }else{
                $fila=2;

                foreach($errores as $list){
                    if($list['prioridad']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar prioridad válida!</p>";
                    }
                    if($list['empresa']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar empresa válida!</p>";
                    }
                    if($list['sede']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar sede válida!</p>";
                    }
                    if($list['tipo']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar tipo válido!</p>";
                    }
                    if($list['subtipo']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar subtipo válido!</p>";
                    }
                    if($list['descripcion']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar descripción!</p>";
                    }
                    if($list['asignado']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar usuario válido!</p>";
                    }
                    if($list['agenda']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar fecha de agenda!</p>";
                    }
                    if($list['estado']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar estado válido!</p>";
                    }
    
                    $fila++;
                }
    
                if($correctos>0){
                    echo "*CORRECTO";
                }else{
                    echo "*INCORRECTO";
                }
            }

            $this->Admin_model->delete_temporal_proyecto();

        }
        else{
            redirect('/login');
        }
    }

    public function Importar_Proyectos() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   
            
            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['prioridad'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['nom_tipo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['nom_subtipo'] = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $dato['snappys'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $dato['descripcion'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['proy_obs'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $dato['id_asignado'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(10, $row)->getValue(); // gives you a number like 44444, which is days since 1900
                    $dato['fec_agenda'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
                    $dato['nom_statusp'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                    $excelDate1 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['duplicado1'] = NumberFormat::toFormattedString($excelDate1, 'YYYY-MM-DD');
                    $excelDate2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['duplicado2'] = NumberFormat::toFormattedString($excelDate2, 'YYYY-MM-DD');
                    $excelDate3 = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['duplicado3'] = NumberFormat::toFormattedString($excelDate3, 'YYYY-MM-DD');
                    $excelDate4 = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $dato['duplicado4'] = NumberFormat::toFormattedString($excelDate4, 'YYYY-MM-DD');
                    $excelDate5 = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $dato['duplicado5'] = NumberFormat::toFormattedString($excelDate5, 'YYYY-MM-DD');

                    $dato['hay_fecha'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue(); 
                    $dato['d1'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dato['d2'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['d3'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['d4'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $dato['d5'] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();

                    if($dato['prioridad']=="" && $dato['cod_empresa']=="" && $dato['cod_sede']=="" && $dato['nom_tipo']=="" && $dato['nom_subtipo']=="" &&
                    $dato['descripcion']=="" && $dato['proy_obs']=="" && $dato['id_asignado']=="" && $dato['hay_fecha']=="" && $dato['nom_statusp']=="" &&
                    $dato['d1']=="" && $dato['d2']=="" && $dato['d3']=="" && $dato['d4']=="" && $dato['d5']==""){
                        break;
                    }

                    $empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if($empresa[$posicion_empresa]['id_empresa']!=""){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }

                    $tipo=$this->Admin_model->buscar_tipo();
                    $posicion_tipo=array_search($dato['nom_tipo'],array_column($tipo,'nom_tipo'));

                    if($tipo[$posicion_tipo]['id_tipo']!="" && $empresa[$posicion_empresa]['id_empresa']!=""){
                        $subtipo=$this->Admin_model->buscar_subtipo($tipo[$posicion_tipo]['id_tipo'],$empresa[$posicion_empresa]['id_empresa']);
                        $posicion_subtipo=array_search($dato['nom_subtipo'],array_column($subtipo,'nom_subtipo'));
                    }else{
                        $posicion_subtipo="";
                    }   

                    $asignado=$this->Admin_model->buscar_usuario();
                    $posicion_asignado=array_search($dato['id_asignado'],array_column($asignado,'usuario_codigo'));

                    $estado=$this->Admin_model->buscar_estado_proyecto();
                    $posicion_estado=array_search($dato['nom_statusp'],array_column($estado,'nom_statusp'));

                    if($dato['prioridad']!=0 && is_numeric($dato['prioridad']) && is_numeric($posicion_empresa) && is_numeric($posicion_sede) && 
                    is_numeric($posicion_tipo) && is_numeric($posicion_subtipo) && $dato['descripcion']!="" && is_numeric($posicion_asignado) && 
                    $dato['fec_agenda']!="" && is_numeric($posicion_estado)){

                        $anio=date('Y');
                        $query_id = $this->Admin_model->ultimo_cod_proyecto($anio);
                        $totalRows_t = count($query_id);
    
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
    
                        $dato['cod_proyecto']=$codigo;
                        $dato['id_tipo'] = $tipo[$posicion_tipo]['id_tipo'];
                        $dato['id_subtipo'] = $subtipo[$posicion_subtipo]['id_subtipo'];
                        $dato['s_artes'] = $subtipo[$posicion_subtipo]['tipo_subtipo_arte'];
                        $dato['s_redes'] = $subtipo[$posicion_subtipo]['tipo_subtipo_redes'];
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                        $dato['id_asignado'] = $asignado[$posicion_asignado]['id_usuario'];
                        $dato['status'] = $estado[$posicion_estado]['id_statusp'];
                        $dato['anio'] = $anio;
                        $dato['color'] = $this->Admin_model->get_colorestatus();

                        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $dato['iniciosf'] = strtotime($dato['fec_agenda']);
                        $fechaComoEntero = strtotime($dato['fec_agenda']);
                        $dato['mes']=date("m", $fechaComoEntero);
                        $dato['dia']=date("d", $fechaComoEntero);
                        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
                        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];
    
                        $this->Admin_model->importar_proyectos($dato); 

                        $ultimo = $this->Admin_model->ultimo_id_proyecto();
                        $dato['id_proyecto'] = $ultimo[0]['id_proyecto'];

                        $this->Admin_model->importar_proyectos_sede($dato); 

                        if($dato['duplicado1']!=""){
                            $dato['duplicado'] = $dato['duplicado1'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado2']!=""){
                            $dato['duplicado'] = $dato['duplicado2'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado3']!=""){
                            $dato['duplicado'] = $dato['duplicado3'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado4']!=""){
                            $dato['duplicado'] = $dato['duplicado4'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }

                        if($dato['duplicado5']!=""){
                            $dato['duplicado'] = $dato['duplicado5'];
                            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
                            $dato['n_duplicado'] = count($get_duplicado)+1;
                            $this->Admin_model->importar_proyectos_duplicado($dato);
                        }
                    }
                }
            //}
        }
        else{
            redirect('/login');
        }
    }

    public function Excel_Vacio_Proyecto2(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel Vacío Proyecto');

        $sheet->setAutoFilter('A1:P1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(14);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(16);
        $sheet->getColumnDimension('M')->setWidth(16);
        $sheet->getColumnDimension('N')->setWidth(16);
        $sheet->getColumnDimension('O')->setWidth(16);
        $sheet->getColumnDimension('P')->setWidth(16);

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

        $sheet->getStyle("A2:P3")->getFont()->getColor()->setRGB('FF0000');

        $sheet->setCellValue("A1", 'Prioridad');           
        $sheet->setCellValue("B1", 'Empresa');
        $sheet->setCellValue("C1", 'Sede');
        $sheet->setCellValue("D1", 'Tipo');
        $sheet->setCellValue("E1", 'Subtipo');
        $sheet->setCellValue("F1", 'Snappys');
        $sheet->setCellValue("G1", 'Descripción');
        $sheet->setCellValue("H1", 'Observaciones');
        $sheet->setCellValue("I1", 'Asignado a');
        $sheet->setCellValue("J1", 'Agenda');   
        $sheet->setCellValue("K1", 'Estado');
        $sheet->setCellValue("L1", 'Duplicado 1');   
        $sheet->setCellValue("M1", 'Duplicado 2');
        $sheet->setCellValue("N1", 'Duplicado 3');
        $sheet->setCellValue("O1", 'Duplicado 4');
        $sheet->setCellValue("P1", 'Duplicado 5');

        $sheet->setCellValue("A2", '1');           
        $sheet->setCellValue("B2", 'GL');
        $sheet->setCellValue("C2", 'GL1');
        $sheet->setCellValue("D2", 'Facebook');
        $sheet->setCellValue("E2", 'AEV (Post)');
        $sheet->setCellValue("F2", '25');
        $sheet->setCellValue("G2", 'Descripción de Facebook');
        $sheet->setCellValue("H2", 'Observaciones de Facebook');
        $sheet->setCellValue("I2", 'l.gonzalez');
        $sheet->setCellValue("J2", Date::PHPToExcel('28/05/2021'));
        $sheet->getStyle("J2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("K2", 'Solicitado');   
        $sheet->setCellValue("L2", Date::PHPToExcel('10/02/2022'));
        $sheet->getStyle("L2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("M2", Date::PHPToExcel('12/04/2022'));
        $sheet->getStyle("M2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("N2", Date::PHPToExcel('14/04/2022'));
        $sheet->getStyle("N2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("O2", Date::PHPToExcel('16/04/2022'));
        $sheet->getStyle("O2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("P2", Date::PHPToExcel('18/04/2022'));
        $sheet->getStyle("P2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        $sheet->setCellValue("A3", '5');           
        $sheet->setCellValue("B3", 'BL');
        $sheet->setCellValue("C3", 'BL1');
        $sheet->setCellValue("D3", 'Web');
        $sheet->setCellValue("E3", 'BN1 (Banner 1)');
        $sheet->setCellValue("F3", '25');
        $sheet->setCellValue("G3", 'Descripción de Web');
        $sheet->setCellValue("H3", 'Observaciones de Web');
        $sheet->setCellValue("I3", 'n.manrique');
        $sheet->setCellValue("J3", Date::PHPToExcel('29/05/2021'));
        $sheet->getStyle("J3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("K3", 'Solicitado');   
        $sheet->setCellValue("L3", Date::PHPToExcel('05/02/2022'));
        $sheet->getStyle("L3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("M3", Date::PHPToExcel('07/04/2022'));
        $sheet->getStyle("M3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("N3", Date::PHPToExcel('09/04/2022'));
        $sheet->getStyle("N3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("O3", Date::PHPToExcel('11/04/2022'));
        $sheet->getStyle("O3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("P3", Date::PHPToExcel('13/04/2022'));
        $sheet->getStyle("P3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);


        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel_Vacío_Proyecto';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //------------------------------------------------------EVENTOS-----------------------------------------
    public function Eventos(){// RRHH {
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('administrador/evento/index_evento',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Busqueda_Evento(){
        $id_estatus= $this->input->post('status');
        $data['status']=  $id_estatus;
        $data['list_evento'] =$this->Admin_model->get_list_evento($id_estatus);
        $this->load->view('administrador/evento/busqueda', $data);
    }

    public function Detalle_Evento($id_evento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_evento($id_evento);
            $dato['list_detalle'] = $this->Admin_model->get_list_detalle_evento($id_evento);

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

            $this->load->view('administrador/evento/detalle',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Sede_Evento(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['list_sede'] =$this->Admin_model->get_id_sede_evento($dato['id_empresa']); 
            $this->load->view('administrador/evento/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Link_Evento(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['get_id'] =$this->Admin_model->get_id_empresa($dato['id_empresa']); 
            $this->load->view('administrador/evento/link',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Nuevo_Evento(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresa'] =$this->Admin_model->get_list_empresa_evento();
            $dato['list_usuario'] =$this->Admin_model->get_list_usuario_evento();
            $dato['list_estado'] =$this->Admin_model->get_list_estadoe();
            $dato['list_objetivo'] =$this->Admin_model->get_list_objetivo_combo();
            $this->load->view('administrador/evento/nuevo_evento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Evento() {
        if ($this->session->userdata('usuario')) {
            $dato['nom_evento']= $this->input->post("nom_evento");
            $dato['fec_agenda']= $this->input->post("fec_agenda");
            $dato['hora_evento']= $this->input->post("hora_evento");
            $dato['fec_ini']= $this->input->post("fec_ini");
            $dato['fec_fin']= $this->input->post("fec_fin");
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['id_sede']= $this->input->post("id_sede");
            $dato['tipo_link']= $this->input->post("tipo_link");
            $dato['informe']= $this->input->post("informe");

            if($this->input->post("autorizaciones")!=""){
                $dato['autorizaciones']= implode(",",$this->input->post("autorizaciones"));
            }else{
                $dato['autorizaciones']= "";
            }

            $dato['id_objetivo']= $this->input->post("id_objetivo");
            $dato['id_estadoe']= $this->input->post("id_estadoe");
            $dato['obs_evento']= $this->input->post("obs_evento");
            
            $anio=date('Y');
            $query_id = $this->Admin_model->ultimo_cod_evento($anio);
            $totalRows_t = count($query_id);

            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigo=$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                $codigo=$aniof.($totalRows_t+1);
            }

            $dato['cod_evento']=$codigo;

            if($dato['id_estadoe']==1){
                /*$validar = $this->Admin_model->valida_insert_evento($dato);

                if(count($validar)>0){
                    echo "error";
                }else{*/
                    $this->Admin_model->insert_evento($dato);
                //}
            }else{
                $this->Admin_model->insert_evento($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_Evento($id_evento){
        if ($this->session->userdata('usuario')) { 
            $dato['solicitado'] =$this->Admin_model->get_solicitado();
            $dato['list_estado'] =$this->Admin_model->get_list_estadoe();
            $dato['list_empresa'] =$this->Admin_model->get_list_empresa_evento();
            $dato['list_sede'] =$this->Admin_model->get_list_sede_evento();
            $dato['list_usuario'] =$this->Admin_model->get_list_usuario_evento();
            $dato['list_objetivo'] =$this->Admin_model->get_list_objetivo_combo();
            $dato['get_id'] = $this->Admin_model->get_id_evento($id_evento);
            $this->load->view('administrador/evento/editar_evento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Evento(){
        if ($this->session->userdata('usuario')) {  
            $dato['id_evento']= $this->input->post("id_evento");
            $dato['nom_evento']= $this->input->post("nom_evento");
            $dato['fec_agenda']= $this->input->post("fec_agenda");
            $dato['hora_evento']= $this->input->post("hora_evento");
            $dato['fec_ini']= $this->input->post("fec_ini");
            $dato['fec_fin']= $this->input->post("fec_fin");
            $dato['id_empresa']= $this->input->post("id_empresa");
            $dato['id_sede']= $this->input->post("id_sede");
            $dato['tipo_link']= $this->input->post("tipo_link");
            $dato['informe']= $this->input->post("informe");

            if($this->input->post("autorizaciones")!=""){
                $dato['autorizaciones']= implode(",",$this->input->post("autorizaciones"));
            }else{
                $dato['autorizaciones']= "";
            }

            $dato['id_objetivo']= $this->input->post("id_objetivo");
            $dato['id_estadoe']= $this->input->post("id_estadoe");
            $dato['obs_evento']= $this->input->post("obs_evento");
        
            if($dato['id_estadoe']==1){
                $validar = $this->Admin_model->valida_update_evento($dato);

                if(count($validar)>0){
                    echo "error";
                }else{
                    $this->Admin_model->update_evento($dato);
                }
            }else{
                $this->Admin_model->update_evento($dato);
            }

            /*if($dato['id_estadoe']==1 && $dato['informe']==1 && $dato['autorizaciones']!=""){
                $get_id = $this->Admin_model->get_id_evento($dato['id_evento']);
                $list_usuario =$this->Admin_model->get_list_usuario_evento();

                $usuario_informe="";
                $array=explode(",",$get_id[0]['autorizaciones']);
                $contador=0;
                $cadena="";
                while($contador<count($array)){
                    $posicion_autorizacion=array_search($array[$contador],array_column($list_usuario,'id_usuario'));
                    $cadena=$cadena.$list_usuario[$posicion_autorizacion]['usuario_codigo'].",";
                    $contador++;
                }
                $usuario_informe=substr($cadena,0,-1);
                
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
                    $mail->setFrom('no-reply@gllg.edu.pe', 'Eventos'); //desde donde se envia
            
                    $array=explode(",",$get_id[0]['autorizaciones']);
                    $contador=0;
                    while($contador<count($array)){
                        $posicion_autorizacion=array_search($array[$contador],array_column($list_usuario,'id_usuario'));
                        $mail->addAddress($list_usuario[$posicion_autorizacion]['usuario_email']);
                        $contador++;
                    }
            
                    $mail->isHTML(true);                                  // Set email format to HTML
            
                    $mail->Subject = 'EVENTO: '.$get_id[0]['cod_empresa'].'-'.$get_id[0]['nom_evento'];
            
                    $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                                    <p style="font-size:14px;">El siguiente evento a sido creado:</p>
                                    <table style="border:hidden;font-size:14px;" width="100%">
                                        <tr>
                                            <td colspan="4"><b>Ref: </b>'.$get_id[0]['cod_evento'].'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Evento: </b>'.$get_id[0]['nom_evento'].'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Fecha: </b>'.$get_id[0]['fecha_agenda'].'</td>
                                        </tr>
                                        <tr>
                                            <td width="25%"><b>Empresa: </b>'.$get_id[0]['cod_empresa'].'</td>
                                            <td width="25%"><b>Sede: </b>'.$get_id[0]['cod_sede'].'</td>
                                            <td width="25%"><b>Activo de: </b>'.$get_id[0]['fecha_ini'].'</td>
                                            <td width="25%"><b>Hasta: </b>'.$get_id[0]['fecha_fin'].'</td>
                                        </tr>
                                        <tr>
                                            <td width="50%" colspan="2"><b>Creado Por: </b>'.$get_id[0]['cod_empresa'].'</td>
                                            <td width="50%" colspan="2"><b>Link Registro: </b>'.$get_id[0]['link'].'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Usuarios: </b>'.$usuario_informe.'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Observaciones: </b>'.$get_id[0]['obs_evento'].'</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p>Puedes siempre revisar:</p>
                                    <p>Base de datos del evento: https://snappy.org.pe//index.php?/Administrador/Eventos/</p>
                                    <p>Informe del Evento: https://snappy.org.pe//index.php?/Administrador/Pdf_Evento/'.$get_id[0]['id_evento'].'</p>
                                    <br>
                                    <p>Igualmente recibirás automáticamente este mismo informe 14, 7 y 1 día antes del evento.</p>
                                    <p>(este correo ha sido enviado de forma automática)</p>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();
            
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }*/
        }else{
            redirect('/login');
        }
    } 

    public function Excel_Evento($id_estatus){
        $list_evento =$this->Admin_model->get_list_evento($id_estatus);
        $list_usuario =$this->Admin_model->get_list_usuario_evento();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:S1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:S1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Eventos (Lista)');

        $sheet->setAutoFilter('A1:S1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(16);
        $sheet->getColumnDimension('K')->setWidth(16);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(60);
        $sheet->getColumnDimension('Q')->setWidth(30);
        $sheet->getColumnDimension('R')->setWidth(60);
        $sheet->getColumnDimension('S')->setWidth(15);

        $sheet->getStyle('A1:S1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:S1")->getFill()
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

        $sheet->getStyle("A1:S1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Referencia'); 
        $sheet->setCellValue("B1", 'Evento');           
        $sheet->setCellValue("C1", 'Fecha');
        $sheet->setCellValue("D1", 'Hora');
        $sheet->setCellValue("E1", 'Activo de');
        $sheet->setCellValue("F1", 'Hasta');
        $sheet->setCellValue("G1", 'Empresa');
        $sheet->setCellValue("H1", 'Sede');
        $sheet->setCellValue("I1", 'Link');
        $sheet->setCellValue("J1", 'Registrado');
        $sheet->setCellValue("K1", 'Contactado');
        $sheet->setCellValue("L1", 'Asiste');
        $sheet->setCellValue("M1", 'No Asiste');
        $sheet->setCellValue("N1", 'Matriculado');
        $sheet->setCellValue("O1", 'Informe');
        $sheet->setCellValue("P1", 'Autorizaciones');
        $sheet->setCellValue("Q1", 'Objetivo');
        $sheet->setCellValue("R1", 'Observaciones');
        $sheet->setCellValue("S1", 'Estado');

        $contador=1;
        
        foreach($list_evento as $list){
            $contador++;

            $autorizaciones="";

            if($list['autorizaciones']!=""){
                $array=explode(",",$list['autorizaciones']);
                $i=0;
                $incremento="";

                while($i<count($array)){
                    $posicion=array_search($array[$i],array_column($list_usuario,'id_usuario'));
                    $incremento=$incremento.$list_usuario[$posicion]['usuario_codigo'].",";
                    $i++;
                }

                $autorizaciones=substr($incremento,0,-1);
            }
            
            $sheet->getStyle("A{$contador}:S{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:S{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_evento']);
            $sheet->setCellValue("B{$contador}", $list['nom_evento']);

            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fec_agenda']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("D{$contador}", $list['h_evento']);

            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fec_ini']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fec_fin']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue("G{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("H{$contador}", $list['cod_sede']);
            $sheet->setCellValue("I{$contador}", $list['link']);
            $sheet->setCellValue("J{$contador}", $list['registrados']);
            $sheet->setCellValue("K{$contador}", $list['contactados']);
            $sheet->setCellValue("L{$contador}", $list['asistes']);
            $sheet->setCellValue("M{$contador}",  $list['no_asistes']);
            $sheet->setCellValue("N{$contador}",  $list['matriculados']);
            $sheet->setCellValue("O{$contador}",  $list['c_informe']);
            $sheet->setCellValue("P{$contador}",  $autorizaciones);
            $sheet->setCellValue("Q{$contador}", $list['nom_objetivo']);
            $sheet->setCellValue("R{$contador}", $list['obs_evento']);
            $sheet->setCellValue("S{$contador}", $list['nom_estadoe']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Eventos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Excel_Detalle_Evento($id_evento){ 
        $list_registro = $this->Admin_model->excel_list_detalle_evento($id_evento);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:U1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:U1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Evento');

        $sheet->setAutoFilter('A1:U1');

        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(16);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(16);
        $sheet->getColumnDimension('O')->setWidth(16);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(14);
        $sheet->getColumnDimension('S')->setWidth(14);
        $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(60);

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

        $sheet->setCellValue("A1", 'Referencia');           
        $sheet->setCellValue("B1", 'Tipo');
        $sheet->setCellValue("C1", 'Fecha (Con.)');
        $sheet->setCellValue("D1", 'Mes/Año');
        $sheet->setCellValue("E1", 'Nombres y Apellidos');
        $sheet->setCellValue("F1", 'DNI');
        $sheet->setCellValue("G1", 'Contacto Pri.');
        $sheet->setCellValue("H1", 'Departamento');
        $sheet->setCellValue("I1", 'Provincia');
        $sheet->setCellValue("J1", 'Distrito');
        $sheet->setCellValue("K1", 'Contacto 2');
        $sheet->setCellValue("L1", 'Correo');
        $sheet->setCellValue("M1", 'Facebook');
        $sheet->setCellValue("N1", 'Empresa');
        $sheet->setCellValue("O1", 'Sede');
        $sheet->setCellValue("P1", 'Interés');
        $sheet->setCellValue("Q1", 'Acción');
        $sheet->setCellValue("R1", 'Fecha');
        $sheet->setCellValue("S1", 'Usuario');
        $sheet->setCellValue("T1", 'Status');
        $sheet->setCellValue("U1", 'Comentario');

        $contador=1;

        foreach($list_registro as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("O{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("S{$contador}:U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:U{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_registro']);
            $sheet->setCellValue("B{$contador}", $list['nom_informe']);

            if($list['fec_inicial']==""){
                $sheet->setCellValue("C{$contador}", "");
            }else{
                $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fec_inicial']));
                $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            
            $sheet->setCellValue("D{$contador}", $list['mes_anio']);
            $sheet->setCellValue("E{$contador}", $list['nombres_apellidos']);
            $sheet->setCellValue("F{$contador}", $list['dni']);
            $sheet->setCellValue("G{$contador}", $list['contacto1']);
            $sheet->setCellValue("H{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("I{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("J{$contador}", $list['nombre_distrito']);
            $sheet->setCellValue("K{$contador}", $list['contacto2']);
            $sheet->setCellValue("L{$contador}", $list['correo']);
            $sheet->setCellValue("M{$contador}", $list['facebook']);
            $sheet->setCellValue("N{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("O{$contador}", $list['cod_sede']);
            $sheet->setCellValue("P{$contador}", $list['productosf']);
            if(strlen($list['nom_accion_h'])>0){
                $sheet->setCellValue("Q{$contador}", $list['nom_accion_h']);
            }else{
                $sheet->setCellValue("Q{$contador}", "Comentario" );
            }

            if($list['fecha_status_h']==""){
                $sheet->setCellValue("R{$contador}", "");
            }else{
                $sheet->setCellValue("R{$contador}", Date::PHPToExcel($list['fecha_status_h']));
            $sheet->getStyle("R{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }

            $sheet->setCellValue("S{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("T{$contador}", $list['nom_status_h']);
            $sheet->setCellValue("U{$contador}", $list['comentario_h']);

            if($list['duplicado']==1){
                $spreadsheet->getActiveSheet()->getStyle("A{$contador}:U{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F8FF91');
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Detalle Evento (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Pdf_Evento($id_evento){
        $this->load->library('Pdf');

        $get_id= $this->Admin_model->get_id_evento($id_evento);
        $list_usuario =$this->Admin_model->get_list_usuario_evento();

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Informe Evento');
        $pdf->SetSubject('Informe Evento');
        $pdf->SetKeywords('Informe, Evento, Registrados, Contactados, Asisten');

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
        $pdf->SetFont('helvetica','',18);

        // add a page
        $pdf->AddPage();

        $y2=25;

        $pdf->SetFillColor(255,255,255);

        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2);
        $pdf->MultiCell (210,20,'',0,'L',1,0,'','',true,0,false,true,10,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (20,$y2+3);
        $pdf->MultiCell (60,14,'Informe de Eventos',0,'L',1,0,'','',true,0,false,true,14,'M');
        $pdf->Image($get_id[0]['imagen'],176,28,14,14,'', '', '', true, 150, '', false, false, 0);

        $pdf->SetLineStyle(array('width'=>0.6,'cap'=>'butt','join'=>'miter','dash'=> 0,'color'=>array(0, 0, 0)));
        $pdf->Line(15,$y2+35,195,$y2+35,'');

        $pdf->SetFont('helvetica','B',10);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY (15,$y2+40);
        $pdf->MultiCell (14,8,'Ref.:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id[0]['cod_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Evento:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (85,8,$get_id[0]['nom_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Estado:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['nom_estadoe'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+50);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (14,8,'Fecha:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id[0]['fecha_agenda'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (19,8,'Empresa:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id[0]['cod_empresa'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (12,8,'Sede:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id[0]['cod_sede'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (20,8,'Activo de:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['fecha_ini'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Hasta:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['fecha_fin'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+60);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (23,8,'Creado Por:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['usuario_codigo'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (11,8,'Link:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (125,8,$get_id[0]['link'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $usuario_informe="";
        if($get_id[0]['autorizaciones']!=""){
            $array=explode(",",$get_id[0]['autorizaciones']);
            $contador=0;
            $cadena="";
            while($contador<count($array)){
                $posicion_autorizacion=array_search($array[$contador],array_column($list_usuario,'id_usuario'));
                $cadena=$cadena.$list_usuario[$posicion_autorizacion]['usuario_codigo'].",";
                $contador++;
            }
            $usuario_informe=substr($cadena,0,-1);
        }

        $pdf->SetXY (15,$y2+70);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Usuario Informe:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (149,8,$usuario_informe,0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->Line(15,$y2+83,195,$y2+83,'');

        $pdf->SetXY (15,$y2+88);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Observaciones:',0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+96);
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (180,50,$get_id[0]['obs_evento'],0,'L',1,0,'','',true,0,false,true,50,'T');

        //TABLA

        $fecha = $get_id[0]['fecha_agenda_operativa'];
        $fecha_evento = $get_id[0]['fecha_agenda'];
        $fecha_7_despues = date('d/m/Y',strtotime('+7 day', strtotime($fecha)));
        $fecha_1_antes = date('d/m/Y',strtotime('-1 day', strtotime($fecha)));
        $fecha_7_antes = date('d/m/Y',strtotime('-7 day', strtotime($fecha)));
        $fecha_14_antes = date('d/m/Y',strtotime('-14 day', strtotime($fecha)));

        $datos_7_despues = $this->Admin_model->get_list_evento_7_despues($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_hoy = $this->Admin_model->get_list_evento_hoy($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_1_antes = $this->Admin_model->get_list_evento_1_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_7_antes = $this->Admin_model->get_list_evento_7_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_14_antes = $this->Admin_model->get_list_evento_14_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);

        $total_registrados = $datos_7_despues[0]['registrados']+$datos_hoy[0]['registrados']+$datos_1_antes[0]['registrados']+$datos_7_antes[0]['registrados']+$datos_14_antes[0]['registrados'];
        $total_contactados = $datos_7_despues[0]['contactados']+$datos_hoy[0]['contactados']+$datos_1_antes[0]['contactados']+$datos_7_antes[0]['contactados']+$datos_14_antes[0]['contactados'];
        $total_sin_revisar = $datos_7_despues[0]['sin_revisar']+$datos_hoy[0]['sin_revisar']+$datos_1_antes[0]['sin_revisar']+$datos_7_antes[0]['sin_revisar']+$datos_14_antes[0]['sin_revisar'];

        $pdf->SetXY (15,$y2+154);
        $pdf->MultiCell (180,62,'',1,'L',1,0,'','',true,0,false,true,62,'M');

        $pdf->SetXY (18,$y2+157);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,'Registrados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,'Contactados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,'Han Asistido',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,'No Asisten',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,'Sin Revisar',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+165);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días después',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_despues,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(226,239,218);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(252,228,214);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+173);
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (27,8,'Día Evento',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_evento,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_hoy[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_hoy[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_hoy[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+181);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'1 día antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_1_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+189);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+197);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'14 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_14_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_14_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_14_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_14_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+205);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,$total_registrados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,$total_contactados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,$total_sin_revisar,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        //FOOTER
        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2+235);
        $pdf->MultiCell (210,12,'',0,'L',1,0,'','',true,0,false,true,12,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (10,$y2+236);
        $pdf->MultiCell (45,10,'Global Leadership Group',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (100,10,'',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (45,10,date('d/m/Y')." - ".date('H:i:s'),0,'R',1,0,'','',true,0,false,true,10,'M');

        $pdf->Output('Informe_Evento.pdf', 'I');
    }

    public function Excel_Vacio_Evento(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel Vacío Evento');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(25);
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

        $sheet->getStyle("A2:G3")->getFont()->getColor()->setRGB('FF0000');

        $sheet->setCellValue("A1", 'Evento');           
        $sheet->setCellValue("B1", 'Nombre');
        $sheet->setCellValue("C1", 'DNI');
        $sheet->setCellValue("D1", 'Correo');
        $sheet->setCellValue("E1", 'Celular');
        $sheet->setCellValue("F1", 'Grado de Interese');
        $sheet->setCellValue("G1", 'Fecha Registro');  

        $sheet->setCellValue("A2", 'Charla Informativa LL - 21 Enero');   
        $sheet->setCellValue("B2", 'Richard Garate Robles');   
        $sheet->setCellValue("C2", '12345678');   
        $sheet->setCellValue("D2", 'Richard.garate.1@gmail.com');   
        $sheet->setCellValue("E2", '945126645');   
        $sheet->setCellValue("F2", '4 Años');   
        $sheet->setCellValue("G2", Date::PHPToExcel(date('d/m/Y')));
        $sheet->getStyle("G2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);        

        $sheet->setCellValue("A3", 'Charla Informativa LS - 21 Enero');   
        $sheet->setCellValue("B3", 'Giovanna Pastor molina');  
        $sheet->setCellValue("C3", '87654321');    
        $sheet->setCellValue("D3", 'Giovanna_1207@hotmail.com');   
        $sheet->setCellValue("E3", '996433433');   
        $sheet->setCellValue("F3", '1 Primaria');   
        $sheet->setCellValue("G3", Date::PHPToExcel(date('d/m/Y')));
        $sheet->getStyle("G3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);        

        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel_Vacío_Evento';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Validar_Importar_Evento() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   

            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['nom_evento'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['dni'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['correo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['contacto1'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['fec_reg'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');

                    $dato['hay_fec_reg'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                    if($dato['nom_evento']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && $dato['correo']=="" && $dato['contacto1']=="" && 
                    $dato['nom_producto_interes']=="" && $dato['hay_fec_reg']==""){
                        break;
                    }

                    $evento=$this->Admin_model->buscar_evento($dato);
                    $posicion_evento=array_search($dato['nom_evento'],array_column($evento,'nom_evento'));

                    if(is_numeric($posicion_evento)){
                        $dato['id_empresa'] = $evento[$posicion_evento]['id_empresa'];
                        $dato['id_sede'] = $evento[$posicion_evento]['id_sede'];
                        $producto = $this->Admin_model->buscar_producto_interes($dato);
                        $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                    }else{
                        $posicion_producto="";
                    }

                    $dato['v_evento']=0;
                    $dato['v_registro']=0;
                    $dato['v_nombres']=0;
                    $dato['v_nombres_inv']=0;
                    $dato['v_numerico_dni']=0;
                    $dato['v_cantidad_dni']=0;
                    $dato['v_correo_contacto1']=0;
                    $dato['v_correo_inv']=0;
                    $dato['v_numerico']=0;
                    $dato['v_cantidad']=0;
                    $dato['v_inicial']=0;
                    $dato['v_producto']=0;
                    $dato['v_fec_reg']=0;

                    if(!is_numeric($posicion_evento)){
                        $dato['v_evento']=1;
                    }else{
                        $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                        $validar = count($this->Admin_model->valida_importar_evento($dato));

                        if($validar>0){
                            $dato['v_registro']=1;
                        }else{
                            if($dato['nombres_apellidos']==""){
                                $dato['v_nombres']=1;
                            }
                            if((substr_count($dato['nombres_apellidos'],1)+substr_count($dato['nombres_apellidos'],2)+substr_count($dato['nombres_apellidos'],3)+
                            substr_count($dato['nombres_apellidos'],4)+substr_count($dato['nombres_apellidos'],5)+substr_count($dato['nombres_apellidos'],6)+
                            substr_count($dato['nombres_apellidos'],7)+substr_count($dato['nombres_apellidos'],8)+substr_count($dato['nombres_apellidos'],9)+
                            substr_count($dato['nombres_apellidos'],0))>0){
                                $dato['v_nombres_inv']=1;
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
                            if($dato['correo']=="" && $dato['contacto1']==""){
                                $dato['v_correo_contacto1']=1;
                            }
                            if($dato['correo']!=""){
                                if(!filter_var($dato['correo'],FILTER_VALIDATE_EMAIL)) {
                                    $dato['v_correo_inv']=1;
                                }
                            }
                            if($dato['contacto1']!=""){
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
                            if(!is_numeric($posicion_producto)){
                                $dato['v_producto']=1;
                            }
                            if($dato['fec_reg']==""){
                                $dato['v_fec_reg']=1;
                            }
                        }
                    }

                    $this->Admin_model->insert_temporal_evento($dato); 
                }
            //}

            $correctos=count($this->Admin_model->get_list_temporal_evento_correcto());
            $errores=$this->Admin_model->get_list_temporal_evento($dato);

            if($correctos==count($errores)){
                $dato['archivo_excel']= $this->input->post("archivo_excel");   

                $path = $_FILES["archivo_excel"]["tmp_name"];
                $object = IOFactory::load($path);
                $worksheet = $object->getSheet(0);
                //foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['nom_evento'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $dato['dni'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $dato['correo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $dato['contacto1'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $excelDate = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $dato['fec_reg'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
    
                        $dato['hay_fec_reg'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
    
                        if($dato['nom_evento']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && $dato['correo']=="" && $dato['contacto1']=="" && 
                        $dato['nom_producto_interes']=="" && $dato['hay_fec_reg']==""){
                            break;
                        }
    
                        $evento=$this->Admin_model->buscar_evento($dato);
                        $posicion_evento=array_search($dato['nom_evento'],array_column($evento,'nom_evento'));

                        if(is_numeric($posicion_evento)){
                            $dato['id_empresa'] = $evento[$posicion_evento]['id_empresa'];
                            $dato['id_sede'] = $evento[$posicion_evento]['id_sede'];
                            $producto = $this->Admin_model->buscar_producto_interes($dato);
                            $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                        }else{
                            $posicion_producto="";
                        }

                        $buscar = $this->Admin_model->valida_historial_registro_mail_evento($dato);
                        $get_id = $this->Admin_model->get_id_evento($dato['id_evento']); 

                        if(count($buscar)>0){
                            $dato['id_registro'] = $buscar[0]['id_registro'];
                            $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                            $dato['nom_evento'] = $get_id[0]['nom_evento'];
                            $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];

                            $this->Admin_model->importar_detalle_evento($dato);

                            $validar_producto = $this->Admin_model->valida_importar_detalle_evento_grado($dato);

                            if(count($validar_producto)==0){
                                $this->Admin_model->importar_detalle_evento_grado($dato);
                            }
                        }else{
                            $anio=date('Y');
                            $query_id = $this->Admin_model->ultimo_cod_registro_mail($anio);
                            $totalRows_i = count($query_id);
    
                            $aniof=substr($anio,2,2);
    
                            if($totalRows_i<9){
                                $codigo=$aniof."000".($totalRows_i+1);
                            }
                            if($totalRows_i>8 && $totalRows_i<99){
                                $codigo=$aniof."00".($totalRows_i+1);
                            }
                            if($totalRows_i>98 && $totalRows_i<999){
                                $codigo=$aniof."0".($totalRows_i+1);
                            }
                            if($totalRows_i>998 ){
                                $codigo=$aniof.($totalRows_i+1);
                            }
                
                            $dato['cod_registro']=$codigo;
                            $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                            $dato['nom_evento'] = $get_id[0]['nom_evento'];
                            $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];
        
                            $this->Admin_model->importar_evento($dato); 
    
                            $ultimo = $this->Admin_model->ultimo_id_registro_mail();
                            $dato['id_registro'] = $ultimo[0]['id_registro'];
    
                            $this->Admin_model->importar_detalle_evento($dato);

                            $validar_producto = $this->Admin_model->valida_importar_detalle_evento_grado($dato);

                            if(count($validar_producto)==0){
                                $this->Admin_model->importar_detalle_evento_grado($dato);
                            }
                        }
                    }
                //}
            }else{
                $fila=2;

                foreach($errores as $list){
                    if($list['v_evento']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Evento válido!</p>";
                    }
                    if($list['v_registro']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", Registro repetido, inscrito en el evento!</p>";
                    }
                    if($list['v_nombres']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Nombre!</p>";
                    }
                    if($list['v_nombres_inv']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Nombre válido!</p>";
                    }
                    if($list['v_numerico_dni']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar solo números para DNI!</p>";
                    }
                    if($list['v_cantidad_dni']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar 8 dígitos para DNI!</p>";
                    }
                    if($list['v_correo_contacto1']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Correo o Celular!</p>";
                    }
                    if($list['v_correo_inv']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Correo válido!</p>";
                    }
                    if($list['v_numerico']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar solo números para Celular!</p>";
                    }
                    if($list['v_cantidad']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar 9 dígitos para Celular!</p>";
                    }
                    if($list['v_inicial']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar número inicial 9 para Celular!</p>";
                    }
                    if($list['v_producto']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Grado válido!</p>";
                    }
                    if($list['v_fec_reg']==1){
                        echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", ingresar Fecha Registro!</p>";
                    }
                    $fila++;
                }
    
                if($correctos>0){
                    echo "*CORRECTO";
                }else{
                    echo "*INCORRECTO";
                }
            }

            $this->Admin_model->delete_temporal_evento();
        }else{
            redirect('/login');
        }
    }

    public function Importar_Evento() {
        if ($this->session->userdata('usuario')) {
            $dato['archivo_excel']= $this->input->post("archivo_excel");   
            
            $path = $_FILES["archivo_excel"]["tmp_name"];
            $object = IOFactory::load($path);
            $worksheet = $object->getSheet(0);
            //foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['nom_evento'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $dato['nombres_apellidos'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $dato['dni'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $dato['correo'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $dato['contacto1'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $dato['nom_producto_interes'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $excelDate = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $dato['fec_reg'] = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');

                    $dato['hay_fec_reg'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                    if($dato['nom_evento']=="" && $dato['nombres_apellidos']=="" && $dato['dni']=="" && $dato['correo']=="" && $dato['contacto1']=="" && 
                    $dato['nom_producto_interes']=="" && $dato['hay_fec_reg']==""){
                        break;
                    }

                    $evento=$this->Admin_model->buscar_evento($dato);
                    $posicion_evento=array_search($dato['nom_evento'],array_column($evento,'nom_evento'));

                    $v_registro = 0;
                    if(is_numeric($posicion_evento)){
                        $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                        $validar = count($this->Admin_model->valida_importar_evento($dato));

                        if($validar>0){
                            $v_registro = 1;
                        }else{
                            $v_registro = 0;
                        }
                    }

                    if(is_numeric($posicion_evento)){
                        $dato['id_empresa'] = $evento[$posicion_evento]['id_empresa'];
                        $dato['id_sede'] = $evento[$posicion_evento]['id_sede'];
                        $producto = $this->Admin_model->buscar_producto_interes($dato);
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

                    $v_correo_contacto1 = 0;
                    if($dato['correo']=="" && $dato['contacto1']==""){
                        $v_correo_contacto1 = 1;
                    }

                    $v_correo = 0;
                    if($dato['correo']!=""){
                        if(filter_var($dato['correo'],FILTER_VALIDATE_EMAIL)){
                            $v_correo = 0;
                        }else{
                            $v_correo = 1;
                        }
                    }

                    $v_contacto1 = 0;
                    if($dato['contacto1']!=""){
                        if(is_numeric($dato['contacto1']) && strlen($dato['contacto1'])==9 && substr($dato['contacto1'],0,1)==9){
                            $v_contacto1 = 0;
                        }else{
                            $v_contacto1 = 1;
                        }
                    }

                    if(is_numeric($posicion_evento) && $v_registro==0 && $dato['nombres_apellidos']=="" && (substr_count($dato['nombres_apellidos'],1)+
                    substr_count($dato['nombres_apellidos'],2)+substr_count($dato['nombres_apellidos'],3)+substr_count($dato['nombres_apellidos'],4)+
                    substr_count($dato['nombres_apellidos'],5)+substr_count($dato['nombres_apellidos'],6)+substr_count($dato['nombres_apellidos'],7)+
                    substr_count($dato['nombres_apellidos'],8)+substr_count($dato['nombres_apellidos'],9)+substr_count($dato['nombres_apellidos'],0))>0 && 
                    $v_dni==0 && $v_correo_contacto1==0 && $v_correo==0 && $v_contacto1==0 && is_numeric($posicion_producto) && 
                    $dato['hay_fec_reg']==""){
                        $buscar = $this->Admin_model->valida_historial_registro_mail_evento($dato);
                        $get_id = $this->Admin_model->get_id_evento($dato['id_evento']); 

                        if(count($buscar)>0){
                            $dato['id_registro'] = $buscar[0]['id_registro'];
                            $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                            $dato['nom_evento'] = $get_id[0]['nom_evento'];
                            $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];

                            $this->Admin_model->importar_detalle_evento($dato);

                            $validar_producto = $this->Admin_model->valida_importar_detalle_evento_grado($dato);

                            if(count($validar_producto)==0){
                                $this->Admin_model->importar_detalle_evento_grado($dato);
                            }
                        }else{
                            $anio=date('Y');
                            $query_id = $this->Admin_model->ultimo_cod_registro_mail($anio);
                            $totalRows_i = count($query_id);
    
                            $aniof=substr($anio,2,2);
    
                            if($totalRows_i<9){
                                $codigo=$aniof."000".($totalRows_i+1);
                            }
                            if($totalRows_i>8 && $totalRows_i<99){
                                $codigo=$aniof."00".($totalRows_i+1);
                            }
                            if($totalRows_i>98 && $totalRows_i<999){
                                $codigo=$aniof."0".($totalRows_i+1);
                            }
                            if($totalRows_i>998 ){
                                $codigo=$aniof.($totalRows_i+1);
                            }
                
                            $dato['cod_registro']=$codigo;
                            $dato['id_evento'] = $evento[$posicion_evento]['id_evento'];
                            $dato['nom_evento'] = $get_id[0]['nom_evento'];
                            $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];
        
                            $this->Admin_model->importar_evento($dato); 
    
                            $ultimo = $this->Admin_model->ultimo_id_registro_mail();
                            $dato['id_registro'] = $ultimo[0]['id_registro'];
    
                            $this->Admin_model->importar_detalle_evento($dato);

                            $validar_producto = $this->Admin_model->valida_importar_detalle_evento_grado($dato);

                            if(count($validar_producto)==0){
                                $this->Admin_model->importar_detalle_evento_grado($dato);
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

    public function Historial_Evento($id_registro,$id_evento){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_evento'] = $id_evento;
            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);
            $dato['list_producto'] = $this->Admin_model->get_list_registro_mail_producto($id_registro);
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

            $this->load->view('administrador/evento/historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Historial_Evento($id_historial){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] =$this->Admin_model->get_id_historial_mail($id_historial);
            $dato['list_status'] = $this->Admin_model->get_list_status_evento($dato);
            $this->load->view('administrador/evento/modal_historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Historial_Evento(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_historial']= $this->input->post("id_historial");
            $dato['id_status']= $this->input->post("id_status_e");
            $this->Admin_model->update_historial_registro_mail_evento($dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------------INCRIPCIONES-----------------------------------
    public function Inscripcion(){// RRHH {
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('administrador/evento/inscripcion/index_inscripcion',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Busqueda_Inscripcion(){
        $id_estatus= $this->input->post('status');
        $data['status']=  $id_estatus;
        $data['row_p'] =$this->Admin_model->get_list_inscripcion($id_estatus);
        $this->load->view('administrador/evento/inscripcion/busqueda', $data);
    }

    public function Editar_Inscripcion($id_inscripcion,$id_evento=null){
        if ($this->session->userdata('usuario')) { 
            $data['list_estado'] =$this->Admin_model->get_list_estadoi();
            $data['list_conversatorio'] =$this->Admin_model->get_list_conversatorio();
            $data['list_grado'] =$this->Admin_model->get_list_grado_escuela();
            
            $data['get_id'] = $this->Admin_model->get_id_inscripcion($id_inscripcion);
            $data['id_evento'] = $id_evento;

            $this->load->view('administrador/evento/inscripcion/editar_inscripcion',$data);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Inscripcion(){
        $dato['id_inscripcion']= $this->input->post("id_inscripcion");
        $dato['nombres']= $this->input->post("nombres");
        $dato['alumno']= $this->input->post("alumno");
        $dato['correo']= $this->input->post("correo");
        $dato['celular']= $this->input->post("celular");
        $dato['dni']= $this->input->post("dni");
        $dato['id_grado_escuela']= $this->input->post("id_anio_escuela");
        $dato['id_conversatorio']= $this->input->post("id_conversatorio");
        $dato['id_estadoi']= $this->input->post("id_estadoi");
        $dato['observaciones']= $this->input->post("observaciones");
        $this->Admin_model->update_inscripcion($dato);
    }

    public function Excel_Inscripcion(){
        $id_estatus= $this->input->post("id_status");
        $inscripcion =$this->Admin_model->get_list_inscripcion($id_estatus);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Lista de Inscripciones');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(50);

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

        $sheet->setCellValue("A1", 'Código');  
        $sheet->setCellValue("B1", 'Evento');         
        $sheet->setCellValue("C1", 'Empresa');
        $sheet->setCellValue("D1", 'Nombre');
        $sheet->setCellValue("E1", 'Alumno');
        $sheet->setCellValue("F1", 'Correo');
        $sheet->setCellValue("G1", 'Celular');
        $sheet->setCellValue("H1", 'DNI');
        $sheet->setCellValue("I1", 'Grado');
        $sheet->setCellValue("J1", 'Departamento');
        $sheet->setCellValue("K1", 'Provincia');
        $sheet->setCellValue("L1", 'Fecha Registro');
        $sheet->setCellValue("M1", 'Estado');
        $sheet->setCellValue("N1", 'Observaciones');

        $contador=1;
        
        foreach($inscripcion as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_inscripcion']);
            $sheet->setCellValue("B{$contador}", $list['nom_evento']);
            $sheet->setCellValue("C{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("D{$contador}", $list['nombres']);
            $sheet->setCellValue("E{$contador}", $list['alumno']);
            $sheet->setCellValue("F{$contador}", $list['correo']);
            $sheet->setCellValue("G{$contador}", $list['celular']);
            $sheet->setCellValue("H{$contador}", $list['dni']);
            if($list['id_conversatorio']!=0){ 
                $sheet->setCellValue("I{$contador}", $list['nom_conversatorio']);
            }else{ 
                $sheet->setCellValue("I{$contador}", $list['nom_producto_interes']);
            }
            $sheet->setCellValue("J{$contador}", $list['nombre_departamento']);
            $sheet->setCellValue("K{$contador}", $list['nombre_provincia']);
            $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['fec_reg']));
            $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("M{$contador}", $list['nom_estadoi']);
            $sheet->setCellValue("N{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Eventos Inscritos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /*------------------------------------------------------------ */
    public function Registro(){
        if ($this->session->userdata('usuario')) { 
            if($_SESSION['usuario'][0]['id_nivel']!=15){ 
                $dato['get_datos_comercial'] = $this->Admin_model->get_datos_comercial();
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('administrador/comercial/registro/index_registro',$dato);
        }
        else{
            redirect('/login');
        }
    }

    /*public function Cargar_Cabecera(){
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['list_empresa_cabecera']=$this->Admin_model->get_empresa_usuario($id_usuario);
        
        $id_sede = 6;
        $dato['list_bl'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_bl'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);

        $id_sede = 2;
        $dato['list_ll'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_ll'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);

        $id_sede = 5;
        $nombre = "Primaria";
        $dato['list_ls_pri'] =$this->Admin_model->get_list_cabecera_comercial_ls($id_sede,$nombre);
        $dato['total_ls_pri'] =$this->Admin_model->get_total_cabecera_comercial_ls($id_sede,$nombre);

        $id_sede = 5;
        $nombre = "Secundaria";
        $dato['list_ls_secu'] =$this->Admin_model->get_list_cabecera_comercial_ls($id_sede,$nombre);
        $dato['total_ls_secu'] =$this->Admin_model->get_total_cabecera_comercial_ls($id_sede,$nombre);

        $id_sede = 7;
        $dato['list_ep1'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_ep1'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);

        $id_sede = 8;
        $dato['list_ep2'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_ep2'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);

        $id_sede = 9;
        $dato['list_fv'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_fv'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);

        $id_sede = 11;
        $dato['list_ld'] =$this->Admin_model->get_list_cabecera_comercial($id_sede);
        $dato['total_ld'] =$this->Admin_model->get_total_cabecera_comercial($id_sede);
        
        $this->load->view('administrador/comercial/registro/inicio', $dato);
    }*/

    public function Actualizar_Datos_Comercial(){ 
        if($this->session->userdata('usuario')){
            $this->Admin_model->update_datos_comercial();
            $dato['get_datos_comercial'] = $this->Admin_model->get_datos_comercial();
            $this->load->view('administrador/comercial/registro/datos_comercial', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Busqueda_Registro(){ 
        $dato['parametro']= $this->input->post('parametro');
        $dato['anio']= $this->input->post('anio');

        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $list_empresa = $this->Model_General->get_id_empresa_usuario($id_usuario);
        $dato['list_anio'] = $this->Model_General->get_list_anio();

        $result="";

        foreach($list_empresa as $char){
            $result.= $char['id_empresa'].",";
        }
        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";

        if($dato['parametro']==0){
            $dato['list_registro'] =$this->Admin_model->get_list_registro_activo($dato);
        }elseif($dato['parametro']==1){
            $dato['list_registro'] =$this->Admin_model->get_list_registro_todo($dato);
        }else{
            $dato['list_registro_secretaria'] =$this->Admin_model->get_list_registro_secretaria($dato);
        }

        $this->load->view('administrador/comercial/registro/busqueda', $dato);
    }

    public function Modal_Registro_Mail_Mailing(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('administrador/comercial/registro/modal_mailing');
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

            $this->load->view('administrador/comercial/registro/sedes',$dato);
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
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            $dato['list_producto_interes'] =$this->Admin_model->get_list_producto_interes();
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
            
            $this->load->view('administrador/comercial/registro/nuevo_registro',$dato);
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
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia();
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito();
            $dato['list_producto_interes'] =$this->Admin_model->get_list_producto_interes();
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('administrador/comercial/registro/registrar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Vista_Registro_Mail_Secretaria(){
        if ($this->session->userdata('usuario')) {
            $usuario_codigo= $_SESSION['usuario'][0]['usuario_codigo'];

            $dato['list_empresas'] =$this->Admin_model->get_list_empresa_secretaria();
            $dato['list_informe'] = $this->Admin_model->get_list_informe_secretaria();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();
            
            $this->load->view('administrador/comercial/registro/registrar_secretaria',$dato);
        }
        else{
            redirect('/login');
        }
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

            $this->load->view('administrador/comercial/registro/producto_interes',$dato);
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
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
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
           

            $this->load->view('administrador/comercial/registro/editar_registro',$dato);
        }
        else{
            redirect('/login');
        }
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

            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['list_status'] = $this->Admin_model->get_list_estado_mail();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
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

            $this->load->view('administrador/comercial/registro/editar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Departamento_Provincia($id_departamento="0") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->departamento_provincia($id_departamento);
        echo json_encode($data); 
    }

    public function Muestra_Provincia() {
        $id_departamento= $this->input->post("id_departamento");
        $dato['list_provincia'] = $this->Admin_model->departamento_provincia($id_departamento);
        $this->load->view('administrador/comercial/registro/mprovincia',$dato);
    }

    public function Muestra_Distrito() {
        $id_departamento= $this->input->post("id_departamento");
        $id_provincia= $this->input->post("id_provincia");
        $dato['list_distrito'] = $this->Admin_model->provincia_distrito($id_provincia);
        $this->load->view('administrador/comercial/registro/mdistrito',$dato);
    }

    public function Provincia_Distrito($id_provincia="0") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->provincia_distrito($id_provincia);
        echo json_encode($data); 
    }

    public function Empresa_Sede_Combo($id_empresa="0") {
        header('Content-Type: application/json');
        $data = $this->Admin_model->empresa_sede_combo($id_empresa);
        echo json_encode($data); 
    }

    public function Empresa_Sede_Uno(){
        if ($this->session->userdata('usuario')) {
            $dato['empresas'] = $this->input->post("id_empresa");

            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede_uno($dato);

            $this->load->view('administrador/proyecto/sedes',$dato);
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
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
            $dato['list_departamento'] = $this->Admin_model->get_list_departamento();
            $dato['list_provincia'] = $this->Admin_model->get_list_provincia_editar($id_departamento);
            $dato['list_distrito'] = $this->Admin_model->get_list_distrito_editar($id_departamento,$id_provincia);
            $dato['list_producto_interes'] =$this->Admin_model->get_list_producto_interes();
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

            $this->load->view('administrador/comercial/registro/historial',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Historial_Registro_Mail($id_registro){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_registro($id_registro);
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $this->load->view('administrador/comercial/registro/modal_historial',$dato);
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
            $this->load->view('administrador/comercial/registro/estados', $dato);
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
            $dato['list_informe'] = $this->Admin_model->get_list_informe();
            $dato['list_accion'] = $this->Admin_model->get_list_accion_registro_mail();
            $dato['id_accion']=$dato['get_id'][0]['id_accion'];
            $dato['list_status'] = $this->Admin_model->get_list_accion_status($dato);
            $this->load->view('administrador/comercial/registro/modal_update_historial',$dato);
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
            $this->load->view('administrador/comercial/registro/modal_update_historial_evento',$dato);
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

    public function Excel_Dep_Comercial($parametro,$anio){ 
        $dato['anio'] = $anio; 
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['list_empresa']=$this->Model_General->get_id_empresa_usuario($id_usuario);

        $result="";

        foreach($dato['list_empresa'] as $char){
            $result.= $char['id_empresa'].",";
        }
        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";

        if($parametro==0){
            $dato['list_registro'] =$this->Admin_model->excel_registro_activo($dato);
        }else{
            $dato['list_registro'] =$this->Admin_model->excel_registro_todo($dato);
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
        $dato['anio'] = date('Y');
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

        $sheet->getStyle("A1:P1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:P1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel Vacío Comercial');

        $sheet->setAutoFilter('A1:P1');

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
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);

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

        $sheet->getStyle("A2:P3")->getFont()->getColor()->setRGB('FF0000');

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
        $sheet->setCellValue("M1", 'Empresa');
        $sheet->setCellValue("N1", 'Sede');
        $sheet->setCellValue("O1", 'Comentario');
        $sheet->setCellValue("P1", 'Observaciones');     

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
        $sheet->setCellValue("M2", 'LL');
        $sheet->setCellValue("N2", 'LL1');
        $sheet->setCellValue("O2", 'Aquí va el comentario');
        $sheet->setCellValue("P2", 'Aquí van las observaciones');

        $sheet->setCellValue("A3", 'Messenger');   
        $sheet->setCellValue("B3", Date::PHPToExcel('23/11/2021'));
        $sheet->getStyle("B3")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);        
        $sheet->setCellValue("C3", 'Pablo Ruiz Huerta');
        $sheet->setCellValue("D3", '87654321');
        $sheet->setCellValue("E3", '2 Secundaria');
        $sheet->setCellValue("F3", '963258741');
        $sheet->setCellValue("G3", 'Lima');
        $sheet->setCellValue("H3", 'Lima');
        $sheet->setCellValue("I3", 'Lurin');
        $sheet->setCellValue("J3", '951741289');
        $sheet->setCellValue("K3", 'pablohrh@gmail.com');
        $sheet->setCellValue("L3", 'Pablo Ruiz Huerta');   
        $sheet->setCellValue("M3", 'LS');
        $sheet->setCellValue("N3", 'LS1');
        $sheet->setCellValue("O3", 'Aquí va el comentario');
        $sheet->setCellValue("P3", 'Aquí van las observaciones');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel_Vacío_Comercial';
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
                    $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['comentario'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
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
                    
                    $empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if(is_numeric($posicion_empresa)){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }

                    if(is_numeric($posicion_empresa) && is_numeric($posicion_sede)){
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                        $producto = $this->Admin_model->buscar_producto_interes($dato);
                        $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
                    }else{
                        $posicion_producto="";
                    }

                    $dato['id_empresa']=0;
                    if(is_numeric($posicion_empresa)){
                        $dato['id_empresa']=$empresa[$posicion_empresa]['id_empresa'];
                    }

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
                        if(!is_numeric($posicion_empresa)){
                            $dato['v_cod_empresa']=1;
                        }
                        if(!is_numeric($posicion_sede)){
                            $dato['v_cod_sede']=1;
                        }
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
                        $dato['cod_empresa'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $dato['comentario'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
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
                        
                        $empresa=$this->Admin_model->buscar_empresa();
                        $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                        if(is_numeric($posicion_empresa)){
                            $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                            $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                        }else{
                            $posicion_sede="";
                        }

                        if(is_numeric($posicion_empresa) && is_numeric($posicion_sede)){
                            $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                            $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                            $producto = $this->Admin_model->buscar_producto_interes($dato);
                            $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));
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
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
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
                    $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['comentario'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
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
                    
                    $empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if($empresa[$posicion_empresa]['id_empresa']!=""){
                        $sede=$this->Admin_model->buscar_sede($empresa[$posicion_empresa]['id_empresa']);
                        $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));
                    }else{
                        $posicion_sede="";
                    }

                    if(is_numeric($posicion_empresa) && is_numeric($posicion_sede)){
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                        $producto = $this->Admin_model->buscar_producto_interes($dato);
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
                    is_numeric($posicion_empresa) && is_numeric($posicion_sede) && strlen($dato['comentario'])<=35){

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
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
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

    public function Importar_Comercial_Sin_Validaciones() {
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
                    $dato['cod_sede'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $dato['comentario'] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
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

                    if(is_numeric($posicion_informe)){
                        $dato['id_informe'] = $informe[$posicion_informe]['id_informe'];
                    }else{
                        $dato['id_informe'] = 0;
                    }

                    $departamento=$this->Admin_model->buscar_departamento();
                    $posicion_departamento=array_search($dato['nombre_departamento'],array_column($departamento,'nombre_departamento'));

                    if(is_numeric($posicion_departamento)){
                        $dato['id_departamento'] = $departamento[$posicion_departamento]['id_departamento'];
                    }else{
                        $dato['id_departamento'] = 0;
                    }

                    $provincia=$this->Admin_model->buscar_solo_provincia();
                    $posicion_provincia=array_search($dato['nombre_provincia'],array_column($provincia,'nombre_provincia'));    

                    if(is_numeric($posicion_provincia)){
                        $dato['id_provincia'] = $provincia[$posicion_provincia]['id_provincia'];
                    }else{
                        $dato['id_provincia'] = 0;
                    }

                    $distrito=$this->Admin_model->buscar_solo_distrito();
                    $posicion_distrito=array_search($dato['nombre_distrito'],array_column($distrito,'nombre_distrito'));

                    if(is_numeric($posicion_distrito)){
                        $dato['id_distrito'] = $distrito[$posicion_distrito]['id_distrito'];
                    }else{
                        $dato['id_distrito'] = 0;
                    }

                    $empresa=$this->Admin_model->buscar_empresa();
                    $posicion_empresa=array_search($dato['cod_empresa'],array_column($empresa,'cod_empresa'));

                    if(is_numeric($posicion_empresa)){
                        $dato['id_empresa'] = $empresa[$posicion_empresa]['id_empresa'];
                    }else{
                        $dato['id_empresa'] = 0;
                    }

                    $sede=$this->Admin_model->buscar_solo_sede();
                    $posicion_sede=array_search($dato['cod_sede'],array_column($sede,'cod_sede'));

                    if(is_numeric($posicion_sede)){
                        $dato['id_sede'] = $sede[$posicion_sede]['id_sede'];
                    }else{
                        $dato['id_sede'] = 0;
                    }

                    $producto = $this->Admin_model->buscar_solo_producto_interes($dato);
                    $posicion_producto=array_search($dato['nom_producto_interes'],array_column($producto,'nom_producto_interes'));

                    if(is_numeric($posicion_producto)){
                        $dato['id_producto_interes'] = $producto[$posicion_producto]['id_producto_interes'];
                    }else{
                        $dato['id_producto_interes'] = 0;
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
            //}
        }
        else{
            redirect('/login');
        }
    }
    //--------------------------------------------------MAILING---------------------------------------------
    public function Mailing(){
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('administrador/comercial/mailing/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Mailing(){
        $tipo= $this->input->post('tipo');

        if($tipo==0){
            $dato['list_registro'] =$this->Admin_model->get_list_mailing_activo();
        }else{
            $dato['list_registro'] =$this->Admin_model->get_list_mailing_inactivo();
        }
        
        $this->load->view('administrador/comercial/mailing/lista', $dato);
    }

    public function Modal_Enviar_Mailing(){
        $this->load->view('administrador/comercial/mailing/modal_enviar');
    }

    public function Insert_Mailing(){
        if ($this->session->userdata('usuario')) { 
            $cadena = substr($this->input->post("cadena"),0,-1); 
            $cantidad = $this->input->post("cantidad"); 

            $dato['fecha_envio']= $this->input->post("fecha_envio");
            $dato['observaciones']= $this->input->post("observaciones");

            if($cantidad>0){
                $this->Admin_model->insert_mailing($dato);
                $ultimo = $this->Admin_model->ultimo_id_mailing();
                $dato['id_mailing'] = $ultimo[0]['id_mailing'];

                $array = explode(",",$cadena);
                $i = 0;

                while($i<count($array)){
                    $dato['id_registro'] = $array[$i];
                    $this->Admin_model->insert_mailing_detalle($dato); 
                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Mailing($tipo){ 
        if($tipo==0){
            $dato['list_registro'] =$this->Admin_model->get_list_mailing_activo(); 
        }else{
            $dato['list_registro'] =$this->Admin_model->get_list_mailing_inactivo();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mailing');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(45);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(80);
        $sheet->getColumnDimension('I')->setWidth(20);
    
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

        $sheet->setCellValue("A1", 'Referencia');           
        $sheet->setCellValue("B1", 'Tipo');
        $sheet->setCellValue("C1", 'Fecha Contacto');
        $sheet->setCellValue("D1", 'Nombres y Apellidos');
        $sheet->setCellValue("E1", 'Correo');
        $sheet->setCellValue("F1", 'Acción');
        $sheet->setCellValue("G1", 'Empresa');
        $sheet->setCellValue("H1", 'Mensaje');
        $sheet->setCellValue("I1", 'Status');

        $contador=1;
        
        foreach($dato['list_registro'] as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_registro']);           
            $sheet->setCellValue("B{$contador}", $list['nom_informe']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel( $list['fec_inicial']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['nombres_apellidos']);
            $sheet->setCellValue("E{$contador}", $list['correo']);
            $sheet->setCellValue("F{$contador}", $list['nom_accion']);
            $sheet->setCellValue("G{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("H{$contador}", $list['mensaje'],0,80);
            $sheet->setCellValue("I{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Mailing (Lista)';
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
            $this->load->view('administrador/proyecto/modal_duplicado',$dato);
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

            $get_duplicado = $this->Admin_model->get_duplicado_proyecto($dato['id_proyecto']);
            $dato['duplicado'] = count($get_duplicado)+1;

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
            $dato['id_calendar_agenda']= $this->input->post("id_calendar_agenda");
            $dato['id_calendar_redes']= $this->input->post("id_calendar_redes");
            $this->Admin_model->delete_duplicado($dato);
        }else{
            redirect('/login');
        }
    }
    //-------------------------------------------ESTADO BANCARIO-------------------------------------
    public function Estado_Bancario(){// RRHH {
        if ($this->session->userdata('usuario')) { 
            $dato['list_estado_bancario'] =$this->Admin_model->get_list_estado_bancario();

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


            $this->load->view('administrador/estado_bancario/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Estado_Bancario($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
            $dato['list_empresa'] = $this->Model_General->list_empresa();
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $dato['list_anio'] = $this->Model_snappy->get_list_anio();
            $dato['list_mes'] = $this->Model_snappy->get_list_meses();
            $this->load->view('administrador/estado_bancario/modal_estado',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Estado_Bancario(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 
            $dato['estado']= $this->input->post("estado");   
            $dato['observaciones']= $this->input->post("observaciones"); 
            $dato['mes']= $this->input->post("mes");
            $dato['anio']= $this->input->post("anio");
            $this->Admin_model->update_estado_bancario($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Estado_Bancario(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 

            $this->Admin_model->delete_estado_bancario($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Estado_Bancario(){
        $estado_bancario =$this->Admin_model->get_list_estado_bancario();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Estados Bancarios');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(60);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(60);

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

        $sheet->setCellValue("A1", 'Empresa'); 
        $sheet->setCellValue("B1", 'Cuenta Bancaria');
        $sheet->setCellValue("C1", 'Inicio');
        $sheet->setCellValue("D1", 'Status'); 
        $sheet->setCellValue("E1", 'Estado'); 
        $sheet->setCellValue("F1", 'Observaciones'); 

        $contador=1;
        
        foreach($estado_bancario as $list){
            $contador++;

            $inicio="";
            $estado="";

            if($list['mes']!="" && $list['anio']!=""){
                $inicio=$list['anio']."-".$list['mes']."-01";
            }

            if ($list['movimiento_pdf']!="" && $list['movimiento_excel']!="" && $list['saldo']!=0){
                $estado="Cargado";
            }else{
                $estado="Pendiente";
            }  

            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_empresa']);

            $texto = new RichText();
            $texto->createText($list['cuenta_bancaria']);
            $sheet->getCell("B{$contador}")->setValue($texto);

            if($list['mes']!="" && $list['anio']!=""){
                $sheet->setCellValue("C{$contador}", Date::PHPToExcel($inicio));
                $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("C{$contador}", "");  
            }
            
            $sheet->setCellValue("D{$contador}", $estado);  
            $sheet->setCellValue("E{$contador}", $list['nom_status']);
            $sheet->setCellValue("F{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Estados Bancarios (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Estado_Bancario($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] =$this->Admin_model->get_list_estado_bancario($id_estado_bancario);
            $dato['list_detalle'] =$this->Admin_model->get_list_detalle_estado_bancario($id_estado_bancario);

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
            
            $this->load->view('administrador/estado_bancario/detalle',$dato);
        }else{
            redirect('/login');
        }
    }


    public function Lista_Detalle_Estado_Bancario(){
        if ($this->session->userdata('usuario')) { 
            $tipo= $this->input->post("tipo");   
            $id_estado_bancario= $this->input->post("id_estado_bancario");
            $dato['id_estado_bancario'] = $this->input->post("id_estado_bancario");

            if($tipo==1){
                $dato['list_detalle'] =$this->Admin_model->get_list_detalle_estado_bancario($id_estado_bancario);
                $y=0;
                $dato['meses']="";
                $dato['saldo_bbva']="0";
                foreach($dato['list_detalle'] as $d){$y++;
                    //echo $d['mes'].$d['anio']."_".$d['mes_anio'];
                    //--------test
                    $dato['saldo_bbva']=$d['saldo_bbva'];
                    $dato['fecha_busqueda'] = $d['mes'].$d['anio']."_".$d['mes_anio']; 
                    $array = explode("_",$d['mes'].$d['anio']."_".$d['mes_anio']);  
                    
                    $dato['mes_anio'] = $array[1];
                    
                    $mes_anio = $array[0];
                    $anio=substr($dato['fecha_busqueda'],2,4);
                    $mes=substr($dato['fecha_busqueda'],0,2);
                    $dato['mes_actual']=$mes;
                    $dato['mes']='12';
                    $dato['anio']=$anio;
                    if($mes=="01"){
                        $anio=$anio-1;
                        
                    }
                    //$dato['desde']=$anio."-01-01";
                    $dato['desde']=date('Y')."-01-01";
                    //$anio_b=substr($anio,2,2);
                    $anio_b=substr(date('Y'),2,2);
                    $cadena="";
                    if($mes>1){
                        $cadena=$cadena."'Ene/$anio_b'";
                    }if($mes>2){
                        $cadena=$cadena.",'Feb/$anio_b'";
                    }if($mes>3){
                        $cadena=$cadena.",'Mar/$anio_b'";
                    }if($mes>4){
                        $cadena=$cadena.",'Abr/$anio_b'";
                    }if($mes>5){
                        $cadena=$cadena.",'May/$anio_b'";
                    }if($mes>6){
                        $cadena=$cadena.",'Jun/$anio_b'";
                    }if($mes>7){
                        $cadena=$cadena.",'Jul/$anio_b'";
                    }if($mes>8){
                        $cadena=$cadena.",'Ago/$anio_b'";
                    }if($mes>9){
                        $cadena=$cadena.",'Sep/$anio_b'";
                    }if($mes>10){
                        $cadena=$cadena.",'Oct/$anio_b'";
                    }if($mes>11){
                        $cadena=$cadena.",'Nov/$anio_b'";
                    }
                    if($cadena!=""){
                        $dato['cadena']=$cadena;
                    }else{
                        $dato['cadena']="''";
                    }
                    
                    $mes=substr($mes_anio,0,2);
                    if(substr($mes_anio,0,2)>1){
                        $mes=substr($mes_anio,0,2)-1;
                        if($mes<10){
                            $mes="0".$mes;
                        }
                    }
                    //$dato['hasta']=substr($mes_anio,2,4)."-".$mes."-31";
                    $year=date('Y');
                    $dato['hasta']=$year."-".$mes."-31";
                    //echo substr($mes_anio,2,4);
                    $get_id = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
                    $nom_estado_bancario = $get_id[0]['nom_empresa'];

                    $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);
                    $dato['Id']=$get_banco[0]['Id'];
                    $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
                    $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
                    $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
            
                    $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio($get_banco[0]['Id'],$fec_inicio,$fec_fin);

                    $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01";

                    $dato['get_saldo_arpay'] =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
                    //$dato['get_saldo'] =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);
                    $dato['get_saldo'] =$this->Admin_model->get_saldo_snappy2($id_estado_bancario,$dato);
                    $dato['get_saldo_restante1'] =$this->Admin_model->get_saldo_snappy_restante_1($id_estado_bancario,$get_banco[0]['Id'],$dato);
                    $dato['get_saldo_restante2'] =$this->Admin_model->get_saldo_snappy_restante_2($id_estado_bancario,$dato);
                    //var_dump($dato['get_saldo'][0]['saldo_real']);
                    $saldo1=0;
                    if(count($dato['get_saldo_restante1'])>0 && substr($dato['fecha_busqueda'],0,2)!="01"){
                        $saldo1=$dato['get_saldo_restante1'][0]['saldo'];
                    }
                    $saldo2=0;
                    if(count($dato['get_saldo_restante2'])>0){
                        $saldo2=$dato['get_saldo_restante2'][0]['saldo'];
                    }
                    if(count($dato['get_saldo'])>0){
                        $dato['saldo']=$dato['get_saldo'][0]['saldo_real']+$saldo1+$saldo2;
                    }else{
                        $dato['saldo']=0+$saldo1+$saldo2;
                    }
                    $dato['get_fechas'] =$this->Admin_model->get_list_estado_bancario_fecha($id_estado_bancario);
                    
                    //view
                    $saldo=$dato['saldo'];
                    $saldo_a=$dato['get_saldo_arpay'][0][''];

                    foreach($dato['get_fechas'] as $f){
                        $busqueda = in_array($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                        $posicion = array_search($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                        if ($busqueda== false) {
                            if($f['mes_anio']==$dato['mes_anio']){
                                $saldo=$saldo+$f['RealAmount'];
                            }
                        }
                    }
                    foreach ($dato['list_movimiento'] as $list){
                        $busqueda = in_array($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                        $posicion = array_search($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                        if ($busqueda!= false) {
                        }else{
                            $saldo=$saldo+$list['RealAmount'];
                            $saldo_a=$saldo_a+$list['RealAmount'];
                        }
                    }
                    $dato['meses']=$dato['meses'].$d['mes_anio']."_".$saldo.",";
                }
                //--------test
                $this->load->view('administrador/estado_bancario/lista_detalle_resumen',$dato);
            }else{
                $dato['list_mes_anio'] =$this->Admin_model->get_list_mes_anio_combo($id_estado_bancario);
                $this->load->view('administrador/estado_bancario/lista_detalle_movimientos',$dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Estado_Bancario_Old(){
        if ($this->session->userdata('usuario')) { 
            $tipo= $this->input->post("tipo");   
            $id_estado_bancario= $this->input->post("id_estado_bancario");
            $dato['id_estado_bancario'] = $this->input->post("id_estado_bancario");

            if($tipo==1){
                $dato['list_detalle'] =$this->Admin_model->get_list_detalle_estado_bancario($id_estado_bancario);
                $y=0;
                $dato['meses']="";
                $dato['saldo_bbva']="0";
                foreach($dato['list_detalle'] as $d){$y++;
                    //echo $d['mes'].$d['anio']."_".$d['mes_anio'];
                    //--------test
                    $dato['saldo_bbva']=$d['saldo_bbva'];
                    $dato['fecha_busqueda'] = $d['mes'].$d['anio']."_".$d['mes_anio']; 
                    $array = explode("_",$d['mes'].$d['anio']."_".$d['mes_anio']);  
                    
                    $dato['mes_anio'] = $array[1];
                    
                    $mes_anio = $array[0];
                    $anio=substr($dato['fecha_busqueda'],2,4);
                    $mes=substr($dato['fecha_busqueda'],0,2);
                    $dato['mes_actual']=$mes;
                    $dato['mes']='12';
                    $dato['anio']=$anio;
                    if($mes=="01"){
                        $anio=$anio-1;
                        
                    }
                    $dato['desde']=$anio."-01-01";
                    $anio_b=substr($anio,2,2);
                    $cadena="";
                    if($mes>1){
                        $cadena=$cadena."'Ene/$anio_b'";
                    }if($mes>2){
                        $cadena=$cadena.",'Feb/$anio_b'";
                    }if($mes>3){
                        $cadena=$cadena.",'Mar/$anio_b'";
                    }if($mes>4){
                        $cadena=$cadena.",'Abr/$anio_b'";
                    }if($mes>5){
                        $cadena=$cadena.",'May/$anio_b'";
                    }if($mes>6){
                        $cadena=$cadena.",'Jun/$anio_b'";
                    }if($mes>7){
                        $cadena=$cadena.",'Jul/$anio_b'";
                    }if($mes>8){
                        $cadena=$cadena.",'Ago/$anio_b'";
                    }if($mes>9){
                        $cadena=$cadena.",'Sep/$anio_b'";
                    }if($mes>10){
                        $cadena=$cadena.",'Oct/$anio_b'";
                    }if($mes>11){
                        $cadena=$cadena.",'Nov/$anio_b'";
                    }
                    if($cadena!=""){
                        $dato['cadena']=$cadena;
                    }else{
                        $dato['cadena']="''";
                    }
                    
                    $mes=substr($mes_anio,0,2);
                    if(substr($mes_anio,0,2)>1){
                        $mes=substr($mes_anio,0,2)-1;
                        if($mes<10){
                            $mes="0".$mes;
                        }
                    }
                    $dato['hasta']=substr($mes_anio,2,4)."-".$mes."-31";

                    $get_id = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
                    $nom_estado_bancario = $get_id[0]['nom_empresa'];

                    $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);
                    $dato['Id']=$get_banco[0]['Id'];
                    $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
                    $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
                    $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
            
                    $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio($get_banco[0]['Id'],$fec_inicio,$fec_fin);

                    $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01";

                    $dato['get_saldo_arpay'] =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
                    //$dato['get_saldo'] =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);
                    $dato['get_saldo'] =$this->Admin_model->get_saldo_snappy2($id_estado_bancario,$dato);
                    $dato['get_saldo_restante1'] =$this->Admin_model->get_saldo_snappy_restante_1($id_estado_bancario,$get_banco[0]['Id'],$dato);
                    $dato['get_saldo_restante2'] =$this->Admin_model->get_saldo_snappy_restante_2($id_estado_bancario,$dato);
                    //var_dump($dato['get_saldo'][0]['saldo_real']);
                    $saldo1=0;
                    if(count($dato['get_saldo_restante1'])>0 && substr($dato['fecha_busqueda'],0,2)!="01"){
                        $saldo1=$dato['get_saldo_restante1'][0]['saldo'];
                    }
                    $saldo2=0;
                    if(count($dato['get_saldo_restante2'])>0){
                        $saldo2=$dato['get_saldo_restante2'][0]['saldo'];
                    }
                    if(count($dato['get_saldo'])>0){
                        $dato['saldo']=$dato['get_saldo'][0]['saldo_real']+$saldo1+$saldo2;
                    }else{
                        $dato['saldo']=0+$saldo1+$saldo2;
                    }
                    $dato['get_fechas'] =$this->Admin_model->get_list_estado_bancario_fecha($id_estado_bancario);/**/
                    
                    //view
                    $saldo=$dato['saldo'];
                    $saldo_a=$dato['get_saldo_arpay'][0][''];

                    foreach($dato['get_fechas'] as $f){
                        $busqueda = in_array($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                        $posicion = array_search($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                        if ($busqueda== false) {
                            if($f['mes_anio']==$dato['mes_anio']){
                                $saldo=$saldo+$f['RealAmount'];
                            }
                        }
                    }
                    foreach ($dato['list_movimiento'] as $list){
                        $busqueda = in_array($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                        $posicion = array_search($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                        if ($busqueda!= false) {
                        }else{
                            $saldo=$saldo+$list['RealAmount'];
                            $saldo_a=$saldo_a+$list['RealAmount'];
                        }
                    }
                    $dato['meses']=$dato['meses'].$d['mes_anio']."_".$saldo.",";
                }
                //--------test
                $this->load->view('administrador/estado_bancario/lista_detalle_resumen',$dato);
            }else{
                $dato['list_mes_anio'] =$this->Admin_model->get_list_mes_anio_combo($id_estado_bancario);
                $this->load->view('administrador/estado_bancario/lista_detalle_movimientos',$dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Estado_Bancario_Mes_Anio($id_estado_bancario,$mes_anio,$MovementType,$Reference,$OperationNumber){
        if ($this->session->userdata('usuario')) {
            $dato['id_estado_bancario'] = $id_estado_bancario;
            $dato['MovementType']=$MovementType;
            $dato['Reference']=$Reference;
            $dato['OperationNumber']=$OperationNumber;
            $dato['mes_anio']=str_replace('__','/',$mes_anio);
            $dato['get_id'] =$this->Admin_model->get_list_fecha_estado_bancario($dato);
            $dato['list_mes_anio'] =$this->Admin_model->get_list_mes_anio_combo($id_estado_bancario);
            $this->load->view('administrador/estado_bancario/mes_estado',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Estado_Bancario_Mes_Anio_Varios($id_estado_bancario){
        if ($this->session->userdata('usuario')) {
            $dato['id_estado_bancario'] = $id_estado_bancario;
            $dato['list_mes_anio'] =$this->Admin_model->get_list_mes_anio_combo($id_estado_bancario);
            $this->load->view('administrador/estado_bancario/mes_estado_varios',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Estado_Bancario_Fecha(){
        if ($this->session->userdata('usuario')) { 
            $dato['MovementType']= $this->input->post("MovementType"); 
            $dato['Reference']= $this->input->post("Reference");   
            $dato['OperationNumber']= $this->input->post("OperationNumber"); 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancarioe");
            $dato['ClientProductPurchaseRegistryId']=$this->input->post("ClientProductPurchaseRegistryId");
            

            $array = explode("_",$this->input->post("mes_anio_busqueda"));  
            $dato['mes_anio'] = $array[1];
            $mes_anio = $array[0];

            $get_id = $this->Admin_model->get_list_estado_bancario($dato['id_estado_bancario']);
            $nom_estado_bancario = $get_id[0]['nom_empresa'];

            $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);

            $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
            $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
            $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
    
            $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio_snappy($get_banco[0]['Id'],$fec_inicio,$fec_fin);

            $valida = $this->Admin_model->get_list_fecha_estado_bancario($dato);
            $dato['MovementDate']="";
            $dato['AmountValue']="";
            $dato['RealAmount']="";
            $dato['Description']="";
            if(count($valida)>0){
                $dato['MovementDate']=$valida[0]['MovementDate'];
                $dato['AmountValue']=$valida[0]['AmountValue'];
                $dato['RealAmount']=$valida[0]['RealAmount'];
                $dato['Description']=$valida[0]['Description'];
            }else{
                $busqueda = in_array($dato['MovementType']."-".$dato['Reference']."-".$dato['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                $posicion = array_search($dato['MovementType']."-".$dato['Reference']."-".$dato['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar')); 
                //var_dump($busqueda);
                if ($busqueda!= false) {
                    $dato['MovementDate']=$dato['list_movimiento'][$posicion]['MovementDate'];
                    $dato['AmountValue']=$dato['list_movimiento'][$posicion]['AmountValue'];
                    $dato['RealAmount']=$dato['list_movimiento'][$posicion]['RealAmount'];
                    $dato['Description']=$dato['list_movimiento'][$posicion]['Description'];
                }
            }
            
            $dato['mes_anio']= $this->input->post("mes_anioe"); 
            
            if(count($valida)>0){
                $this->Admin_model->update_estado_bancario_fecha($dato);
            }else{
                $this->Admin_model->insert_estado_bancario_fecha($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Update_Estado_Bancario_Fecha_Varios(){
        if ($this->session->userdata('usuario')) {
            $dato['mes_anio']= $this->input->post("mes_anioe_f");
            $total=0;
            $error=0;
            $insertado=0;
            foreach($_POST['id_registro'] as $registro){
                $total++;
                //echo $registro."<br>";
                $cadena = explode("/", $registro);
                $dato['MovementType']= $cadena[2];//$this->input->post("MovementType"); 
                $dato['Reference']= $cadena[3];//$this->input->post("Reference");   
                $dato['OperationNumber']= $cadena[4];//$this->input->post("OperationNumber"); 
                $dato['id_estado_bancario']= $cadena[0];//$this->input->post("id_estado_bancarioe");
                //$dato['ClientProductPurchaseRegistryId']=$this->input->post("ClientProductPurchaseRegistryId");
                if($dato['MovementType']!="" && $dato['Reference']!="" && $dato['OperationNumber']!="" && $dato['id_estado_bancario']!=""){
                    $insertado++;
                    $mes_anio_busqueda=str_replace('__','/',$cadena[1]);
                    $array = explode("_",$mes_anio_busqueda);  
                    //$dato['mes_anio'] = $array[1];
                    
                    $mes_anio = $array[0];

                    $get_id = $this->Admin_model->get_list_estado_bancario($dato['id_estado_bancario']);
                    $nom_estado_bancario = $get_id[0]['nom_empresa'];

                    $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);

                    $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
                    $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
                    $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
            
                    $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio_snappy($get_banco[0]['Id'],$fec_inicio,$fec_fin);

                    $valida = $this->Admin_model->get_list_fecha_estado_bancario($dato);
                    $dato['MovementDate']="";
                    $dato['AmountValue']="";
                    $dato['RealAmount']="";
                    $dato['Description']="";
                    //echo $dato['MovementType']."-".$dato['Reference']."-".$dato['OperationNumber']."<br>";
                    if(count($valida)>0){
                        $dato['MovementDate']=$valida[0]['MovementDate'];
                        $dato['AmountValue']=$valida[0]['AmountValue'];
                        $dato['RealAmount']=$valida[0]['RealAmount'];
                        $dato['Description']=$valida[0]['Description'];
                    }else{
                        $busqueda = in_array($dato['MovementType']."-".$dato['Reference']."-".$dato['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                        $posicion = array_search($dato['MovementType']."-".$dato['Reference']."-".$dato['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar')); 
                        //var_dump($busqueda);
                        if ($busqueda!= false) {
                            $dato['MovementDate']=$dato['list_movimiento'][$posicion]['MovementDate'];
                            $dato['AmountValue']=$dato['list_movimiento'][$posicion]['AmountValue'];
                            $dato['RealAmount']=$dato['list_movimiento'][$posicion]['RealAmount'];
                            $dato['Description']=$dato['list_movimiento'][$posicion]['Description'];
                        }
                    }
                    if(count($valida)>0){
                        $this->Admin_model->update_estado_bancario_fecha($dato);
                    }else{
                        $this->Admin_model->insert_estado_bancario_fecha($dato);
                    }    
                }else{
                    $error++;
                }
            }

            if ($error>0){
                echo "1ERRORES: $error<br>Motivo: Datos faltantes<br>TOTAL REGISTRADOS:".$insertado."<br>TOTAL: $total";
            } else {
                echo "2TOTAL REGISTRADOS:".$insertado."<br>TOTAL: $total";
            };
            
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mes_Detalle_Estado_Bancario($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['list_anio'] = $this->Model_snappy->get_list_anio();
            $dato['list_mes'] = $this->Model_snappy->get_list_meses();
            $dato['id_estado_bancario'] = $id_estado_bancario;
            $this->load->view('administrador/estado_bancario/modal_mes',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Mes_Detalle_Estado_Bancario(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 
            $dato['mes']= $this->input->post("mes");   
            $dato['anio']= $this->input->post("anio"); 
            $valida = $this->Admin_model->valida_mes_detalle_estado_bancario($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Admin_model->insert_mes_detalle_estado_bancario($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Detalle_Estado_Bancario($id_detalle){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_detalle_estado_bancario($id_detalle);

            $this->load->view('administrador/estado_bancario/modal_update_detalle',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Detalle_Estado_Bancario(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_detalle']= $this->input->post("id_detalle"); 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 
            $dato['anio']= $this->input->post("anio"); 
            $dato['mes']= $this->input->post("mes"); 
            $dato['saldo_bbva']= $this->input->post("saldo_bbva");  
            $dato['saldo_real']= $this->input->post("saldo_real");  
            $dato['revisado']= $this->input->post("revisado");  
            $dato['movimiento_pdf']= $this->input->post("antiguo_pdf"); 
            $dato['movimiento_excel']= $this->input->post("antiguo_excel"); 
            $dato['nom_pdf']= $this->input->post("antiguo_nom_pdf"); 
            $dato['nom_excel']= $this->input->post("antiguo_nom_excel"); 
            $dato['resumen_anual']= $this->input->post("antiguo_resumen_anual"); 
            $dato['nom_resumen_anual']= $this->input->post("antiguo_nom_resumen_anual"); 

            if($_FILES["movimiento_pdf"]["name"] != ""){
                if (file_exists($dato['movimiento_pdf'])) { 
                    unlink($dato['movimiento_pdf']);
                }

                $dato['nom_pdf']= str_replace(' ','_',$_FILES["movimiento_pdf"]["name"]); 

                $config['upload_path'] = './movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'], 0777);
                }
                $config["allowed_types"] = 'pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["movimiento_pdf"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                //$nombre_soli="movimiento_".$dato['id_estado_bancario']."_".$fecha."_".rand(10,99);
                //$nombre = $nombre_soli.".".$ext;
                $nombre = $dato['nom_pdf'];
                $_FILES["file"]["name"] =  $nombre;
                $_FILES["file"]["type"] = $_FILES["movimiento_pdf"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["movimiento_pdf"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["movimiento_pdf"]["error"];
                $_FILES["file"]["size"] = $_FILES["movimiento_pdf"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['movimiento_pdf'] = "movimientos/".$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes']."/".$nombre;
                }     
            }
            
            if($_FILES["movimiento_excel"]["name"] != ""){
                if (file_exists($dato['movimiento_excel'])) { 
                    unlink($dato['movimiento_excel']);
                }

                $dato['nom_excel']= str_replace(' ','_',$_FILES["movimiento_excel"]["name"]); 

                $config['upload_path'] = './movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'], 0777);
                }
                $config["allowed_types"] = 'xls|xlsx';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["movimiento_excel"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                //$nombre_soli="movimiento_".$dato['id_estado_bancario']."_".$fecha."_".rand(10,99);
                //$nombre = $nombre_soli.".".$ext;
                $nombre = $dato['nom_excel'];
                $_FILES["file"]["name"] =  $nombre;
                $_FILES["file"]["type"] = $_FILES["movimiento_excel"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["movimiento_excel"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["movimiento_excel"]["error"];
                $_FILES["file"]["size"] = $_FILES["movimiento_excel"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['movimiento_excel'] = "movimientos/".$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes']."/".$nombre;
                }     
            }

            if($_FILES["resumen_anual"]["name"] != ""){
                if (file_exists($dato['resumen_anual'])) { 
                    unlink($dato['resumen_anual']);
                }

                $dato['nom_resumen_anual']= str_replace(' ','_',$_FILES["resumen_anual"]["name"]); 

                $config['upload_path'] = './movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'], 0777);
                }
                $config["allowed_types"] = 'xls|xlsx';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["resumen_anual"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                //$nombre_soli="movimiento_".$dato['id_estado_bancario']."_".$fecha."_".rand(10,99);
                //$nombre = $nombre_soli.".".$ext;
                $nombre = $dato['nom_resumen_anual'];
                $_FILES["file"]["name"] =  $nombre;
                $_FILES["file"]["type"] = $_FILES["resumen_anual"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["resumen_anual"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["resumen_anual"]["error"];
                $_FILES["file"]["size"] = $_FILES["resumen_anual"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['resumen_anual'] = "movimientos/".$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes']."/".$nombre;
                }     
            }

            $this->Admin_model->update_detalle_estado_bancario($dato);

            $list_detalle = $this->Admin_model->valida_update_resumen_anual($dato);

            foreach($list_detalle as $list){
                if($list['movimiento_pdf']!="" && $list['movimiento_excel']!="" && $list['saldo_bbva']!="" && $list['saldo_real']!=""){
                    $this->Admin_model->update_resumen_anual($dato);
                }
            }

        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo($id_detalle,$orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Admin_model->get_id_detalle_estado_bancario($id_detalle);
            if($orden==1){
                $image = $dato['get_file'][0]['movimiento_pdf'];
            }elseif($orden==2){
                $image = $dato['get_file'][0]['movimiento_excel'];
            }else{
                $image = $dato['get_file'][0]['resumen_anual'];
            }
            
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($image));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo() {
        $id_detalle = $this->input->post('image_id');
        $orden = $this->input->post('orden');
        $dato['get_file'] = $this->Admin_model->get_id_detalle_estado_bancario($id_detalle);

        if($orden==1){
            $image = $dato['get_file'][0]['movimiento_pdf'];
        }elseif($orden==2){
            $image = $dato['get_file'][0]['movimiento_excel'];
        }else{
            $image = $dato['get_file'][0]['resumen_anual'];
        }

        if (file_exists($image)) {
            unlink($image);
        }

        $this->Admin_model->delete_archivo_estado_bancario($id_detalle,$orden);
    }

    public function Excel_Detalle_Estado_Bancario($id_estado_bancario){
        $estado_bancario =$this->Admin_model->get_list_detalle_estado_bancario($id_estado_bancario);
        $get_id =$this->Admin_model->get_list_estado_bancario($id_estado_bancario);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Cuentas Bancarias');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Mes'); 
        $sheet->setCellValue("B1", 'Movimientos (PDF)');
        $sheet->setCellValue("C1", 'Movimientos (XLS)');
        $sheet->setCellValue("D1", 'Resumen Anual (XLS)');
        $sheet->setCellValue("E1", 'Saldo (BBVA)'); 
        $sheet->setCellValue("F1", 'Saldo (REAL)'); 
        $sheet->setCellValue("G1", 'Saldo Automático'); 
        $sheet->setCellValue("H1", 'Diferencia'); 
        $sheet->setCellValue("I1", 'Revisado'); 
        $sheet->setCellValue("J1", 'Usuario'); 
        $sheet->setCellValue("K1", 'Fecha'); 

        //--saldos
        $dato['list_detalle'] =$this->Admin_model->get_list_detalle_estado_bancario($id_estado_bancario);
        $y=0;
        $dato['meses']="";
        foreach($dato['list_detalle'] as $d){$y++;
            //echo $d['mes'].$d['anio']."_".$d['mes_anio'];
            //--------test
            $dato['fecha_busqueda'] = $d['mes'].$d['anio']."_".$d['mes_anio']; 
            $array = explode("_",$d['mes'].$d['anio']."_".$d['mes_anio']);  
            
            $dato['mes_anio'] = $array[1];
            
            $mes_anio = $array[0];
            $anio=substr($dato['fecha_busqueda'],2,4);
            $mes=substr($dato['fecha_busqueda'],0,2);
            $dato['mes_actual']=$mes;
            $dato['mes']='12';
            $dato['anio']=$anio;
            if($mes=="01"){
                $anio=$anio-1;
                
            }
            $anio=date('Y');
            $dato['desde']=$anio."-01-01";
            $anio_b=substr($anio,2,2);
            $cadena="";
            if($mes>1){
                $cadena=$cadena."'Ene/$anio_b'";
            }if($mes>2){
                $cadena=$cadena.",'Feb/$anio_b'";
            }if($mes>3){
                $cadena=$cadena.",'Mar/$anio_b'";
            }if($mes>4){
                $cadena=$cadena.",'Abr/$anio_b'";
            }if($mes>5){
                $cadena=$cadena.",'May/$anio_b'";
            }if($mes>6){
                $cadena=$cadena.",'Jun/$anio_b'";
            }if($mes>7){
                $cadena=$cadena.",'Jul/$anio_b'";
            }if($mes>8){
                $cadena=$cadena.",'Ago/$anio_b'";
            }if($mes>9){
                $cadena=$cadena.",'Sep/$anio_b'";
            }if($mes>10){
                $cadena=$cadena.",'Oct/$anio_b'";
            }if($mes>11){
                $cadena=$cadena.",'Nov/$anio_b'";
            }
            if($cadena!=""){
                $dato['cadena']=$cadena;
            }else{
                $dato['cadena']="''";
            }
            
            $mes=substr($mes_anio,0,2);
            if(substr($mes_anio,0,2)>1){
                $mes=substr($mes_anio,0,2)-1;
                if($mes<10){
                    $mes="0".$mes;
                }
            }
            //$dato['hasta']=substr($mes_anio,2,4)."-".$mes."-31";
            $dato['hasta']=$anio."-".$mes."-31";

            $get_id = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
            $nom_estado_bancario = $get_id[0]['nom_empresa'];

            $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);
            $dato['Id']=$get_banco[0]['Id'];
            $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
            $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
            $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
    
            $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio($get_banco[0]['Id'],$fec_inicio,$fec_fin);

            $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01";

            $dato['get_saldo_arpay'] =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
            //$dato['get_saldo'] =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);
            $dato['get_saldo'] =$this->Admin_model->get_saldo_snappy2($id_estado_bancario,$dato);
            $dato['get_saldo_restante1'] =$this->Admin_model->get_saldo_snappy_restante_1($id_estado_bancario,$get_banco[0]['Id'],$dato);
            $dato['get_saldo_restante2'] =$this->Admin_model->get_saldo_snappy_restante_2($id_estado_bancario,$dato);
            //var_dump($dato['get_saldo'][0]['saldo_real']);
            $saldo1=0;
            if(count($dato['get_saldo_restante1'])>0 && substr($dato['fecha_busqueda'],0,2)!="01"){
                $saldo1=$dato['get_saldo_restante1'][0]['saldo'];
            }
            $saldo2=0;
            if(count($dato['get_saldo_restante2'])>0){
                $saldo2=$dato['get_saldo_restante2'][0]['saldo'];
            }
            if(count($dato['get_saldo'])>0){
                $dato['saldo']=$dato['get_saldo'][0]['saldo_real']+$saldo1+$saldo2;
            }else{
                $dato['saldo']=0+$saldo1+$saldo2;
            }
            $dato['get_fechas'] =$this->Admin_model->get_list_estado_bancario_fecha($id_estado_bancario);
            
            //view
            $saldo=$dato['saldo'];
            $saldo_a=$dato['get_saldo_arpay'][0][''];

            foreach($dato['get_fechas'] as $f){
                $busqueda = in_array($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                $posicion = array_search($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($dato['list_movimiento'], 'Verificar'));
                if ($busqueda== false) {
                    if($f['mes_anio']==$dato['mes_anio']){
                        $saldo=$saldo+$f['RealAmount'];
                    }
                }
            }
            foreach ($dato['list_movimiento'] as $list){
                $busqueda = in_array($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                $posicion = array_search($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($dato['get_fechas'], 'verificar'));
                if ($busqueda!= false) {
                }else{
                    $saldo=$saldo+$list['RealAmount'];
                    $saldo_a=$saldo_a+$list['RealAmount'];
                }
            }
            $dato['meses']=$dato['meses'].$d['mes_anio']."_".$saldo.",";
        }
        //--saldos
        $contador=1;
        
        foreach($estado_bancario as $list){
            $contador++;

            $inicio="";
            $pdf="Pendiente";
            $excel="Pendiente";
            $saldo_bbva="";
            $saldo_real="";

            if($list['mes']!="" && $list['anio']!=""){
                $inicio=$list['anio']."-".$list['mes']."-01";
            }

            if($list['saldo_bbva']!=0){
                $saldo_bbva=$list['saldo_bbva'];
            }

            if($list['saldo_real']!=0){
                $saldo_real=$list['saldo_real'];
            }

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            if($list['mes']!="" && $list['anio']!=""){
                $sheet->setCellValue("A{$contador}", Date::PHPToExcel($inicio));
                $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("A{$contador}", "");  
            }
            $sheet->setCellValue("B{$contador}", $list['v_pdf']);  
            $sheet->setCellValue("C{$contador}", $list['v_excel']);  
            $sheet->setCellValue("D{$contador}", $list['v_anual']);  
            if($list['saldo_bbva']!=0){
                $sheet->setCellValue("E{$contador}", $saldo_bbva);
                $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            }else{
                $sheet->setCellValue("E{$contador}", $saldo_bbva);
            }
            if($list['saldo_real']!=0){
                $sheet->setCellValue("F{$contador}", $saldo_real);
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            }else{
                $sheet->setCellValue("F{$contador}", $saldo_real);
            }

            $saldos = substr($dato['meses'], 0, -1);
            $saldos = explode(",", $saldos);
            $automatico=0;
            if(count($saldos)>0){
                foreach($saldos as $s){
                    $array=explode("_",$s);
                    if($array[0]==$list['mes_anio']){
                        $automatico=$array[1];
                        $sheet->setCellValue("G{$contador}", $array[1]); 
                    }
                }
            }
            if($automatico>0 && $list['saldo_real']!=0){
                $sheet->setCellValue("H{$contador}", ($automatico-$list['saldo_real'])); 
            }
            
            $sheet->setCellValue("I{$contador}", $list['revisado']);  
            $sheet->setCellValue("J{$contador}", $list['user_rev']);  
            if($list['fec_rev']!=""){
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['fec_rev']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("K{$contador}", "");  
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $get_id[0]['nom_empresa'].' ('.$get_id[0]['cuenta_bancaria'].')';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Estado_Bancario_Mes_Anio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_estado_bancario'] = $this->input->post("id_estado_bancario");
            $id_estado_bancario = $this->input->post("id_estado_bancario");  
            $dato['fecha_busqueda'] = $this->input->post("mes_anio"); 
            $array = explode("_",$this->input->post("mes_anio"));  
            
            $dato['mes_anio'] = $array[1];
            
            $mes_anio = $array[0];
            $anio=substr($dato['fecha_busqueda'],2,4);
            $mes=substr($dato['fecha_busqueda'],0,2);
            $dato['mes_actual']=$mes;
            $dato['mes']='12';
            $dato['anio']=$anio;
            if($mes=="01"){
                $anio=$anio-1;
                
            }
            $dato['desde']=$anio."-01-01";
            $anio_b=substr($anio,2,2);
            $cadena="";
            if($mes>1){
                $cadena=$cadena."'Ene/$anio_b'";
            }if($mes>2){
                $cadena=$cadena.",'Feb/$anio_b'";
            }if($mes>3){
                $cadena=$cadena.",'Mar/$anio_b'";
            }if($mes>4){
                $cadena=$cadena.",'Abr/$anio_b'";
            }if($mes>5){
                $cadena=$cadena.",'May/$anio_b'";
            }if($mes>6){
                $cadena=$cadena.",'Jun/$anio_b'";
            }if($mes>7){
                $cadena=$cadena.",'Jul/$anio_b'";
            }if($mes>8){
                $cadena=$cadena.",'Ago/$anio_b'";
            }if($mes>9){
                $cadena=$cadena.",'Sep/$anio_b'";
            }if($mes>10){
                $cadena=$cadena.",'Oct/$anio_b'";
            }if($mes>11){
                $cadena=$cadena.",'Nov/$anio_b'";
            }
            if($cadena!=""){
                $dato['cadena']=$cadena;
            }else{
                $dato['cadena']="''";
            }
            
            $mes=substr($mes_anio,0,2);
            if(substr($mes_anio,0,2)>1){
                $mes=substr($mes_anio,0,2)-1;
                if($mes<10){
                    $mes="0".$mes;
                }
            }
            $dato['hasta']=substr($mes_anio,2,4)."-".$mes."-31";

            $get_id = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
            $nom_estado_bancario = $get_id[0]['nom_empresa'];

            $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);
            $dato['Id']=$get_banco[0]['Id'];
            $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
            $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
            $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";
    
            $dato['list_movimiento'] =$this->Admin_model->get_list_estado_bancario_mes_anio($get_banco[0]['Id'],$fec_inicio,$fec_fin);

            $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01";

            $dato['get_saldo_arpay'] =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
            //$dato['get_saldo'] =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);
            $dato['get_saldo'] =$this->Admin_model->get_saldo_snappy2($id_estado_bancario,$dato);
            $dato['get_saldo_restante1'] =$this->Admin_model->get_saldo_snappy_restante_1($id_estado_bancario,$get_banco[0]['Id'],$dato);
            $dato['get_saldo_restante2'] =$this->Admin_model->get_saldo_snappy_restante_2($id_estado_bancario,$dato);
            //var_dump($dato['get_saldo'][0]['saldo_real']);
            $saldo1=0;
            if(count($dato['get_saldo_restante1'])>0 && substr($dato['fecha_busqueda'],0,2)!="01"){
                $saldo1=$dato['get_saldo_restante1'][0]['saldo'];
            }
            //echo $saldo1." - ";
            //" - ".var_dump($saldo1);
            $saldo2=0;
            if(count($dato['get_saldo_restante2'])>0){
                $saldo2=$dato['get_saldo_restante2'][0]['saldo'];
            }
            
            //" - ".var_dump($saldo2);
            if(count($dato['get_saldo'])>0){
                $dato['saldo']=$dato['get_saldo'][0]['saldo_real']+$saldo1+$saldo2;
            }else{
                $dato['saldo']=0+$saldo1+$saldo2;
            }
            //echo $dato['get_saldo'][0]['saldo_real']." - ";
            //echo $saldo1." - ".$saldo2;
            //echo $dato['saldo'];
            $dato['get_fechas'] =$this->Admin_model->get_list_estado_bancario_fecha($id_estado_bancario);
            $this->load->view('administrador/estado_bancario/lista_movimiento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Estado_Bancario_Mes_Anio($id_estado_bancario,$mes_anio){
        $cadena = explode("_",$mes_anio);
        $cadena_mes = explode("&",$cadena[1]); 
        $mes_anio=str_replace('&','/',$mes_anio);
        $array = explode("_",$mes_anio); 
        
        $dato['mes_anio'] = $array[1];
        $mes_anio = $array[0];

        $anio=substr($mes_anio,2,4);
        $mes=substr($mes_anio,0,2);
        $dato['mes_actual']=$mes;
        $mes_1=$mes;
        $dato['mes']='12';
        $dato['anio']=$anio;
        if($mes=="01"){
            $anio=$anio-1;
        }
        $dato['desde']=$anio."-01-01";
        $anio_b=substr($anio,2,2);
        $cadena="";
        if($mes>1){
            $cadena=$cadena."'Ene/$anio_b'";
        }if($mes>2){
            $cadena=$cadena.",'Feb/$anio_b'";
        }if($mes>3){
            $cadena=$cadena.",'Mar/$anio_b'";
        }if($mes>4){
            $cadena=$cadena.",'Abr/$anio_b'";
        }if($mes>5){
            $cadena=$cadena.",'May/$anio_b'";
        }if($mes>6){
            $cadena=$cadena.",'Jun/$anio_b'";
        }if($mes>7){
            $cadena=$cadena.",'Jul/$anio_b'";
        }if($mes>8){
            $cadena=$cadena.",'Ago/$anio_b'";
        }if($mes>9){
            $cadena=$cadena.",'Sep/$anio_b'";
        }if($mes>10){
            $cadena=$cadena.",'Oct/$anio_b'";
        }if($mes>11){
            $cadena=$cadena.",'Nov/$anio_b'";
        }
        if($cadena!=""){
            $dato['cadena']=$cadena;
        }else{
            $dato['cadena']="''";
        }
        
        $mes=substr($mes_anio,0,2);
        if(substr($mes_anio,0,2)>1){
            $mes=substr($mes_anio,0,2)-1;
            if($mes<10){
                $mes="0".$mes;
            }
        }
        $dato['hasta']=substr($mes_anio,2,4)."-".$mes."-31";

        $get_id = $this->Admin_model->get_list_estado_bancario($id_estado_bancario);
        $nom_estado_bancario = $get_id[0]['nom_empresa'];

        $get_banco = $this->Admin_model->get_id_BankAccount($nom_estado_bancario);

        $cantidad_dias = date('t',strtotime(substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01")); 
        $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01 00:00:00";
        $fec_fin = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-".$cantidad_dias." 23:59:59";

        $list_movimiento =$this->Admin_model->get_list_estado_bancario_mes_anio($get_banco[0]['Id'],$fec_inicio,$fec_fin);

        $fec_inicio = substr($mes_anio,2,4)."-".substr($mes_anio,0,2)."-01";

        //$get_saldo =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);

        /*$get_saldo_arpay =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
        $get_saldo =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);*/
        $get_fechas =$this->Admin_model->get_list_estado_bancario_fecha($id_estado_bancario);

        $get_saldo_arpay =$this->Admin_model->get_saldo_arpay($get_banco[0]['Id'],$fec_inicio);
        //$dato['get_saldo'] =$this->Admin_model->get_saldo_snappy($id_estado_bancario,$get_banco[0]['Id'],$fec_inicio);
        $get_saldo =$this->Admin_model->get_saldo_snappy2($id_estado_bancario,$dato);
        $get_saldo_restante1 =$this->Admin_model->get_saldo_snappy_restante_1($id_estado_bancario,$get_banco[0]['Id'],$dato);
        $get_saldo_restante2 =$this->Admin_model->get_saldo_snappy_restante_2($id_estado_bancario,$dato);
            
        $saldo1=0;
        if(count($get_saldo_restante1)>0 && $mes_1!="01"){
            $saldo1=$get_saldo_restante1[0]['saldo'];
        }
        //" - ".var_dump($saldo1);
        $saldo2=0;
        if(count($get_saldo_restante2)>0){
            $saldo2=$get_saldo_restante2[0]['saldo'];
        }
        //" - ".var_dump($saldo2);
        if(count($get_saldo)>0){
            $dato['saldo']=$get_saldo[0]['saldo_real']+$saldo1+$saldo2;
        }else{
            $dato['saldo']=0+$saldo1+$saldo2;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); 

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Cuentas Bancarias');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Mes/Año Snp'); 
        $sheet->setCellValue("B1", 'Mes/Año'); 
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Fecha');
        $sheet->setCellValue("E1", 'Monto');
        $sheet->setCellValue("F1", 'Saldo Snp'); 
        $sheet->setCellValue("G1", 'Saldo'); 
        $sheet->setCellValue("H1", 'Monto Real'); 
        $sheet->setCellValue("I1", 'Descripción'); 
        $sheet->setCellValue("J1", 'Ref'); 
        $sheet->setCellValue("K1", 'Operación'); 

        $contador = 1;
        //$saldo = $get_saldo[0]['']; 
        //$saldo=$get_saldo[0]['saldo'];
        $saldo=$dato['saldo'];
        $saldo_a=$get_saldo_arpay[0][''];
        foreach($get_fechas as $f){
            $busqueda = in_array($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($list_movimiento, 'Verificar'));
            $posicion = array_search($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($list_movimiento, 'Verificar'));
            
            if ($busqueda== false) {
                if($f['mes_anio']==$dato['mes_anio']){
                    $contador++;
                    $saldo=$saldo+$f['RealAmount'];
                    $fecha = date("d-m-Y", strtotime($f['MovementDate']));
                    $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("D{$contador}:F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
                    
                    $sheet->setCellValue("B{$contador}", $cadena_mes[0]."/".$cadena_mes[1]); 
                    $sheet->setCellValue("A{$contador}", $f['desc_mes']."/".$f['anio']);   
                    $sheet->setCellValue("C{$contador}", $f['MovementType']); 
                    if($f['MovementDate']!=""){
                        $sheet->setCellValue("D{$contador}", Date::PHPToExcel($fecha));
                        $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    }else{
                        $sheet->setCellValue("D{$contador}", "");  
                    }
                    $sheet->setCellValue("E{$contador}", $f['AmountValue']);  
                    $sheet->setCellValue("F{$contador}", $saldo);  
                    $sheet->setCellValue("H{$contador}", $f['RealAmount']);  
                    $sheet->setCellValue("I{$contador}", $f['Description']);  
                    $sheet->setCellValue("J{$contador}", $f['Reference']);  
                    $sheet->setCellValue("K{$contador}", $f['OperationNumber']); 
                }
            }
        }
        foreach($list_movimiento as $list){
            
            $fecha = date("d-m-Y", strtotime($list['MovementDate']));

            $busqueda = in_array($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($get_fechas, 'verificar'));
            $posicion = array_search($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($get_fechas, 'verificar'));

            if ($busqueda!= false) {
            }else{
                $contador++;
                $saldo = $saldo+$list['RealAmount'];
                $saldo_a=$saldo_a+$list['RealAmount'];
                $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("D{$contador}:F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

                $sheet->setCellValue("A{$contador}", $cadena_mes[0]."/".$cadena_mes[1]);  
                $sheet->setCellValue("B{$contador}", $cadena_mes[0]."/".$cadena_mes[1]);  
                $sheet->setCellValue("C{$contador}", $list['MovementType']); 
                if($list['MovementDate']!=""){
                    $sheet->setCellValue("D{$contador}", Date::PHPToExcel($fecha));
                    $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }else{
                    $sheet->setCellValue("D{$contador}", "");  
                }
                $sheet->setCellValue("E{$contador}", $list['AmountValue']);  
                $sheet->setCellValue("F{$contador}", "S/ ".$saldo);
                $sheet->setCellValue("G{$contador}", "S/ ".$saldo_a);
                $sheet->setCellValue("H{$contador}", $list['RealAmount']);  
                $sheet->setCellValue("I{$contador}", $list['Description']);  
                $sheet->setCellValue("J{$contador}", $list['Reference']);  
                $sheet->setCellValue("K{$contador}", $list['OperationNumber']);  
            }
              
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $get_id[0]['nom_empresa'].' ('.$get_id[0]['cuenta_bancaria'].')';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    //------------------------------------------------------BASE DE DATOS------------------------------------------
    public function Base_Datos() {
        if ($this->session->userdata('usuario')){
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

            $this->load->view('administrador/base_datos/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Base_Datos(){
        if ($this->session->userdata('usuario')){
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_base_datos'] = $this->Admin_model->get_list_base_datos($dato['tipo']);
            $this->load->view('administrador/base_datos/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Base_Datos() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();

        $this->load->view('administrador/base_datos/modal_registrar',$dato);
    }

    public function Modal_Ver_Numeros($id_base_datos) {
        if ($this->session->userdata('usuario')) {
            $dato['list_numeros'] = $this->Admin_model->get_list_base_datos_num($id_base_datos);
            $this->load->view('administrador/base_datos/modal_numeros',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Sede_I() {
        if ($this->session->userdata('usuario')){
            $id_empresa = $this->input->post("id_empresa");
            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede($id_empresa);
            $dato['id_sede'] = "id_sede_i";
            $this->load->view('administrador/base_datos/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Plantilla_Base_Datos(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Plantilla Base de Datos SMS');

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

        $sheet->setCellValue("A1", 'Números');           

        $writer = new Xlsx($spreadsheet);
        $filename = 'Plantilla Base de Datos SMS';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Insert_Base_Datos() {
        if ($this->session->userdata('usuario')) {

            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");

            /*$buscar_repetido=$this->Admin_model->valida_base_datos($dato);

            if(count($buscar_repetido)>0){
                echo "error";
            }else{*/

                $dato['archivo']= $this->input->post("archivo_i");   

                $path = $_FILES["archivo_i"]["tmp_name"];
                $object = IOFactory::load($path);

                foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                        if($dato['numero']==""){
                          break;
                        }

                        $dato['numerico']=0;
                        $dato['cantidad']=0;
                        $dato['inicial']=0;

                        if(!is_numeric($dato['numero'])){    
                            $dato['numerico']=1;
                        }else{
                            if(strlen($dato['numero'])!=9){
                                $dato['cantidad']=1;
                            }else{
                                if(substr($dato['numero'],0,1)!=9){
                                    $dato['inicial']=1;
                                }
                            }
                        }

                        $this->Admin_model->insert_temporal_bd_num($dato); 
                    }
                }

                $correctos=count($this->Admin_model->get_list_temporal_bd_num_correcto());
                $errores=$this->Admin_model->get_list_temporal_bd_num();

                if($correctos==count($errores)){
                    $dato['id_empresa']= $this->input->post("id_empresa_i");
                    $dato['id_sede']= $this->input->post("id_sede_i");
                    $dato['nom_base_datos']= $this->input->post("nom_base_datos_i");
                    $dato['num_subido']= $correctos;
                    $dato['archivo']= $this->input->post("archivo_i");   

                    $cantidad = (count($this->Admin_model->get_cantidad_base_datos()))+1;

                    if($_FILES["archivo_i"]["name"] != ""){
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
                        $config['upload_path'] = './archivo_bd/'.$cantidad;
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./archivo_bd/', 0777);
                            chmod('./archivo_bd/'.$cantidad, 0777);
                        }
                        $config["allowed_types"] = 'xls|xlsx';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $path = $_FILES["archivo_i"]["name"];
                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
                        $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['archivo'] = "archivo_bd/".$cantidad."/".$dato['nom_documento'];
                        }     
                    }

                    $this->Admin_model->insert_base_datos($dato);

                    $ultimo_bd = $this->Admin_model->ultimo_id_base_datos();
                    $dato['id_base_datos'] = $ultimo_bd[0]['id_base_datos']; 

                    $path = $_FILES["archivo_i"]["tmp_name"];
                    $object = IOFactory::load($path);

                    foreach($object->getWorksheetIterator() as $worksheet){
                        $highestRow = $worksheet->getHighestRow();
                        $highestColumn = $worksheet->getHighestColumn();
                        for($row=2; $row<=$highestRow; $row++){
                            $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                            if($dato['numero']==""){
                                break;
                            }
        
                            $this->Admin_model->insert_bd_num($dato); 
                        }
                    }
                    
                }else{
                    $fila=2;

                    foreach($errores as $list){
                        if($list['numerico']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", número inválido!</p>";
                        }
                        if($list['cantidad']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", cantidad inválida!</p>";
                        }
                        if($list['inicial']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", número inicial inválido!</p>";
                        }
        
                        $fila++;
                    }
        
                    if($correctos>0){
                        echo "*CORRECTO";
                    }else{
                        echo "*INCORRECTO";
                    }
                }

                $this->Admin_model->delete_temporal_bd_num(); 
            //}
        }else{
            redirect('/login');
        }
    }

    public function Insert_Base_Datos_Con_Error() {
        if ($this->session->userdata('usuario')) {
            $path = $_FILES["archivo_i"]["tmp_name"];
            $object = IOFactory::load($path);
            $contador = 0;
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                    if($dato['numero']==""){
                        break;
                    }

                    if(is_numeric($dato['numero']) && strlen($dato['numero'])==9 && substr($dato['numero'],0,1)==9){
                        $contador++;
                    }
                }
            }

            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");
            $dato['nom_base_datos']= $this->input->post("nom_base_datos_i");
            $dato['num_subido']=$contador;
            $dato['archivo']= $this->input->post("archivo_i"); 

            $cantidad = (count($this->Admin_model->get_cantidad_base_datos()))+1;

            if($_FILES["archivo_i"]["name"] != ""){
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
                $config['upload_path'] = './archivo_bd/'.$cantidad;
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./archivo_bd/', 0777);
                    chmod('./archivo_bd/'.$cantidad, 0777);
                }
                $config["allowed_types"] = 'xls|xlsx';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["archivo_i"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
                $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['archivo'] = "archivo_bd/".$cantidad."/".$dato['nom_documento'];
                }     
            }
            
            $this->Admin_model->insert_base_datos($dato);

            $ultimo_bd = $this->Admin_model->ultimo_id_base_datos();
            $dato['id_base_datos'] = $ultimo_bd[0]['id_base_datos'];
            
            $path = $_FILES["archivo_i"]["tmp_name"];
            $object = IOFactory::load($path);

            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                    if($dato['numero']==""){
                        break;
                    }

                    if(is_numeric($dato['numero']) && strlen($dato['numero'])==9 && substr($dato['numero'],0,1)==9){

                        $this->Admin_model->insert_bd_num($dato); 

                    }
                }
            }
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Base_Datos($id_base_datos) {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_base_datos($id_base_datos);
            $dato['list_empresa'] = $this->Model_General->get_list_empresa_usuario();
            $dato['list_sede'] = $this->Model_General->get_list_sede_usuario();
            $dato['list_status'] = $this->Admin_model->get_list_estado();
            $dato['list_numero'] = $this->Admin_model->get_list_base_datos_num($id_base_datos);

            $this->load->view('administrador/base_datos/modal_editar',$dato);
        }else{
            redirect('');
        }
    }

    public function Buscar_Sede_U() {
        if ($this->session->userdata('usuario')){
            $id_empresa = $this->input->post("id_empresa");
            $dato['list_sede'] = $this->Admin_model->get_list_empresa_sede($id_empresa);
            $dato['id_sede'] = "id_sede_u";
            $this->load->view('administrador/base_datos/sede',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo_Bd($id_base_datos) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Admin_model->get_id_base_datos($id_base_datos);

            $image = $dato['get_file'][0]['archivo'];
            
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($image));
        }else{
            redirect('');
        }
    }

    public function Delete_Archivo_Bd() {
        $id_base_datos = $this->input->post('image_id');
        $dato['get_file'] = $this->Admin_model->get_id_base_datos($id_base_datos);

        $image = $dato['get_file'][0]['archivo'];

        if (file_exists($image)) {
            unlink($image); 
        }

        $this->Admin_model->delete_archivo_base_datos($id_base_datos);
    }

    public function Update_Base_Datos(){
        if ($this->session->userdata('usuario')) {
            $dato['id_base_datos']= $this->input->post("id_base_datos");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['nom_base_datos']= $this->input->post("nom_base_datos_u");
            $dato['estado']= $this->input->post("estado_u");

            $nuevo_archivo = $_FILES['archivo_u']['name'];

            $buscar_archivo = $this->Admin_model->get_id_base_datos($dato['id_base_datos']);

            if($nuevo_archivo!="" && $buscar_archivo[0]['archivo']==""){

                $dato['archivo']= $this->input->post("archivo_u");   

                $path = $_FILES["archivo_u"]["tmp_name"];
                $object = IOFactory::load($path);

                foreach($object->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++){
                        $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                        if($dato['numero']==""){
                            break;
                        }

                        $dato['numerico']=0;
                        $dato['cantidad']=0;
                        $dato['inicial']=0;

                        if(!is_numeric($dato['numero'])){    
                            $dato['numerico']=1;
                        }else{
                            if(strlen($dato['numero'])!=9){
                                $dato['cantidad']=1;
                            }else{
                                if(substr($dato['numero'],0,1)!=9){
                                    $dato['inicial']=1;
                                }
                            }
                        }

                        $this->Admin_model->insert_temporal_bd_num($dato); 
                    }
                }

                $correctos=count($this->Admin_model->get_list_temporal_bd_num_correcto());
                $errores=$this->Admin_model->get_list_temporal_bd_num();

                if($correctos==count($errores)){
                    $dato['id_base_datos']= $this->input->post("id_base_datos");
                    $dato['id_empresa']= $this->input->post("id_empresa_u");
                    $dato['id_sede']= $this->input->post("id_sede_u");
                    $dato['nom_base_datos']= $this->input->post("nom_base_datos_u");
                    $dato['num_subido']= $correctos;
                    $dato['estado']= $this->input->post("estado_u");
                    $dato['archivo']= $this->input->post("archivo_actual");   

                    if($_FILES["archivo_u"]["name"] != ""){
                        if (file_exists($dato['archivo'])) { 
                            unlink($dato['archivo']);
                        }
                        $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
                        $config['upload_path'] = './archivo_bd/'.$dato['id_base_datos'];
                        if (!file_exists($config['upload_path'])) {
                            mkdir($config['upload_path'], 0777, true);
                            chmod($config['upload_path'], 0777);
                            chmod('./archivo_bd/', 0777);
                            chmod('./archivo_bd/'.$dato['id_base_datos'], 0777);
                        }
                        $config["allowed_types"] = 'xls|xlsx';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $path = $_FILES["archivo_u"]["name"];
                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $_FILES["file"]["name"] =  $dato['nom_documento'];
                        $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
                        $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
                        $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
                        $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
                        if($this->upload->do_upload('file')){
                            $data = $this->upload->data();
                            $dato['archivo'] = "archivo_bd/".$dato['id_base_datos']."/".$dato['nom_documento'];
                        }     
                    }

                    $this->Admin_model->update_base_datos($dato);

                    $path = $_FILES["archivo_u"]["tmp_name"];
                    $object = IOFactory::load($path);

                    foreach($object->getWorksheetIterator() as $worksheet){
                        $highestRow = $worksheet->getHighestRow();
                        $highestColumn = $worksheet->getHighestColumn();
                        for($row=2; $row<=$highestRow; $row++){
                            $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                            if($dato['numero']==""){
                                break;
                            }
        
                            $this->Admin_model->insert_bd_num($dato); 
                        }
                    }
                    
                }else{
                    $fila=2;

                    foreach($errores as $list){
                        if($list['numerico']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", número inválido!</p>";
                        }
                        if($list['cantidad']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", cantidad inválida!</p>";
                        }
                        if($list['inicial']==1){
                            echo "<p style='text-align: justify; font-size:90%; color:black' >Fila ".$fila.", número inicial inválido!</p>";
                        }
        
                        $fila++;
                    }
        
                    if($correctos>0){
                        echo "*CORRECTO";
                    }else{
                        echo "*INCORRECTO";
                    }
                }

                $this->Admin_model->delete_temporal_bd_num(); 

            }elseif($nuevo_archivo!="" && $buscar_archivo[0]['archivo']!=""){
                echo "cargado";
            }elseif(($nuevo_archivo=="" && $buscar_archivo[0]['archivo']!="") || ($nuevo_archivo=="" && $buscar_archivo[0]['archivo']=="" && $dato['estado']!=2)){
                $this->Admin_model->update_base_datos_sin_archivo($dato); 
            }else{
                echo "falta";
            }

        }else{
            redirect('/login');
        }
    }

    public function Update_Base_Datos_Con_Error() {
        if ($this->session->userdata('usuario')) {
            $path = $_FILES["archivo_u"]["tmp_name"];
            $object = IOFactory::load($path);
            $contador = 0;
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                    if($dato['numero']==""){
                        break;
                    }

                    if(is_numeric($dato['numero']) && strlen($dato['numero'])==9 && substr($dato['numero'],0,1)==9){
                        $contador++;
                    }
                }
            }

            $dato['id_base_datos']= $this->input->post("id_base_datos");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['nom_base_datos']= $this->input->post("nom_base_datos_u");
            $dato['num_subido']= $contador;
            $dato['estado']= $this->input->post("estado_u");
            $dato['archivo_actual']= $this->input->post("archivo_actual");   
            $dato['archivo']= $this->input->post("archivo_actual");   

            if($_FILES["archivo_u"]["name"] != ""){
                if (file_exists($dato['archivo'])) { 
                    unlink($dato['archivo']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
                $config['upload_path'] = './archivo_bd/'.$dato['id_base_datos'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./archivo_bd/', 0777);
                    chmod('./archivo_bd/'.$dato['id_base_datos'], 0777);
                }
                $config["allowed_types"] = 'xls|xlsx';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["archivo_u"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $_FILES["file"]["name"] =  $dato['nom_documento'];
                $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
                $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['archivo'] = "archivo_bd/".$dato['id_base_datos']."/".$dato['nom_documento'];
                }     
            }   
            
            $this->Admin_model->update_base_datos($dato);
            
            $path = $_FILES["archivo_u"]["tmp_name"];
            $object = IOFactory::load($path);

            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $dato['numero'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                    if($dato['numero']==""){
                        break;
                    }

                    if(is_numeric($dato['numero']) && strlen($dato['numero'])==9 && substr($dato['numero'],0,1)==9){

                        $this->Admin_model->insert_bd_num($dato); 

                    }
                }
            }
        }
        else{
            redirect('/login');
        }
    }

    public function Excel_Base_Datos($tipo){
        $list_base_datos = $this->Admin_model->get_list_base_datos($tipo);
        $list_base_datos_num = $this->Admin_model->get_list_base_datos_num_todo();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Base de Datos');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(100);
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
        $sheet->setCellValue("C1", 'Base de Datos');
        $sheet->setCellValue("D1", 'Cantidad Subida');
        $sheet->setCellValue("E1", 'Números');
        $sheet->setCellValue("F1", 'Fecha');
        $sheet->setCellValue("G1", 'Usuario');
        $sheet->setCellValue("H1", 'Estado');

        $contador=1;
        
        foreach($list_base_datos as $list){
            $contador++;

            $bd_numeros="";
            foreach($list_base_datos_num as $num){
                if($num['id_base_datos']==$list['id_base_datos']){
                    $bd_numeros=$bd_numeros.$num['numero'].",";
                }
            }

            if($bd_numeros==""){
                $bd_numeros="";
            }else{
                $bd_numeros=substr($bd_numeros,0,-1);
            }
            
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['nom_base_datos']);
            $sheet->setCellValue("D{$contador}", $list['num_subido']);
            $sheet->setCellValue("E{$contador}", $bd_numeros);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Base de Datos - Informe (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
        
    }
    //------------------------------------------------------MENSAJE------------------------------------------
    public function Mensaje() { 
        if ($this->session->userdata('usuario')) {
            //$dato['total_comprado'] = $this->Admin_model->mensajes_comprados();
            $dato['total_enviado'] = $this->Admin_model->mensajes_enviados();
            $dato['list_mes_anio'] = $this->Admin_model->get_list_mes_anio();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
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

            $this->load->view('administrador/mensaje/index',$dato);
        }else{
            redirect('/login');
        }
    }

    
    public function Lista_Mensaje(){
        if ($this->session->userdata('usuario')) {
            $dato['mes_anio']= $this->input->post("mes_anio");
            $dato['list_mensaje'] =$this->Admin_model->get_list_mensaje($dato['mes_anio']);
            $this->load->view('administrador/mensaje/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Detalle_Mensaje($id_mensaje) {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_mensaje'] = $this->Admin_model->get_list_mensaje_detalle($id_mensaje);
        $dato['id_mensaje'] = $id_mensaje;

        //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
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

        $this->load->view('administrador/mensaje/detalle',$dato);
    }

    public function Modal_Mensaje() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        $dato['list_base_datos'] = $this->Admin_model->get_list_bd_mensaje();

        $this->load->view('administrador/mensaje/modal_registrar',$dato);
    }

    public function Contar_Numeros_Base_Datos() {
        if ($this->session->userdata('usuario')) {
            $dato['id_base_datos']= $this->input->post("id_base_datos");
            $get_id = $this->Admin_model->get_list_bd_mensaje($dato['id_base_datos']);
            $dato['cantidad'] = $get_id[0]['cantidad_numeros'];
            echo $dato['cantidad'];
        }else{
            redirect('/login');
        }
    }

    public function Traer_Numeros_Base_Datos() {
        if ($this->session->userdata('usuario')) {
            $dato['id_base_datos']= $this->input->post("id_base_datos");
            $dato['list_numeros'] = $this->Admin_model->get_list_bd_num_mensaje($dato['id_base_datos']);
            $this->load->view('administrador/mensaje/numeros',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Mensaje(){
        $dato['numero']= $this->input->post("numero");
        $dato['id_base_datos']= $this->input->post("id_base_datos");
        $dato['motivo']= $this->input->post("motivo");
        $dato['mensaje']= $this->input->post("mensaje");

        include('application/views/administrador/mensaje/httpPHPAltiria.php');

        $contador=0;

        if(strlen($dato['numero'])==9 && substr($dato['numero'],0,1)==9){
            $altiriaSMS = new AltiriaSMS();
    
            $altiriaSMS->setDebug(true);
            $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
            $altiriaSMS->setPassword('gllg2021');
        
            $sDestination = '51'.$dato['numero'];
            $sMessage = $dato['mensaje'];
            $altiriaSMS->sendSMS($sDestination, $sMessage);

            $contador++;
        }

        if($dato['id_base_datos']!=0){

            $base_datos = $this->Admin_model->get_list_base_datos_num($dato['id_base_datos']);

            foreach($base_datos as $list){
                $altiriaSMS = new AltiriaSMS();
    
                $altiriaSMS->setDebug(true);
                $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                $altiriaSMS->setPassword('gllg2021');
            
                $sDestination = '51'.$list['numero'];
                $sMessage = $dato['mensaje'];
                $altiriaSMS->sendSMS($sDestination, $sMessage);

                $contador++;
            }
        }

        $dato['envios']=$contador;

        $this->Admin_model->insert_mensaje($dato);

        $ultimo = $this->Admin_model->ultimo_mensaje();
        $dato['id_mensaje'] = $ultimo[0]['id_mensaje'];

        if($dato['id_base_datos']!=0){

            $base_datos = $this->Admin_model->get_list_base_datos_num($dato['id_base_datos']);

            foreach($base_datos as $list){
                $dato['numero'] = $list['numero'];
                $this->Admin_model->insert_mensaje_detalle($dato);
            }
        }
    }

    public function Excel_Mensaje(){
        $list_mensaje = $this->Admin_model->get_list_mensaje();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mensajes');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(100);

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
        $sheet->setCellValue("C1", 'Motivo');
        $sheet->setCellValue("D1", 'Base de Datos');
        $sheet->setCellValue("E1", 'Celular');           
        $sheet->setCellValue("F1", 'Nr. enviados');
        $sheet->setCellValue("G1", 'Usuario');           
        $sheet->setCellValue("H1", 'Fecha');
        $sheet->setCellValue("I1", 'Mensaje');

        $contador=1;
        
        foreach($list_mensaje as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['motivo']);
            $sheet->setCellValue("D{$contador}", $list['nom_base_datos']);
            $sheet->setCellValue("E{$contador}", $list['numero']);
            $sheet->setCellValue("F{$contador}", $list['envios']);
            $sheet->setCellValue("G{$contador}", $list['usuario_codigo']);
            $sheet->setCellValue("H{$contador}", Date::PHPToExcel( $list['fecha'] ));
            $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("I{$contador}", $list['mensaje']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Mensajes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
        
    }

    public function Duplicar_Registro()
    {
        if ($this->session->userdata('usuario')) {

            foreach ($_POST['id_registro'] as $list) {
                $dato['id_registro'] = $list;

                $this->Admin_model->duplicar_registro_mail($dato);

                $ultimo_registro=$this->Admin_model->ultimo_registro_mail();
                $dato['id_registro_d']=$ultimo_registro[0]['id_registro'];
                $this->Admin_model->duplicar_mail_producto($dato);
            }
        } else {
            redirect('/login');
        }
    }
    //------------------------------ARPAY ONLINE--------------------------
    public function Arpay_Online(){
        if ($this->session->userdata('usuario')) { 
            $dato['list_arpay'] = $this->Admin_model->get_list_arpay_online();

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

            $this->load->view('administrador/arpay_online/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Arpay_Online($id_arpay){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_list_arpay_online($id_arpay);
            $this->load->view('administrador/arpay_online/modal_update', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Arpay_Online(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_arpay']= $this->input->post("id_arpay");
            $dato['nom_arpay']= $this->input->post("nom_arpay");
            $dato['descripcion_arpay']= $this->input->post("descripcion_arpay");
            $this->Admin_model->update_arpay_online($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Arpay_Online(){
        $list_arpay = $this->Admin_model->get_list_arpay_online();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Arpay Online');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(60);

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
        $sheet->setCellValue("B1", 'Descripción');           

        $contador=1;
        
        foreach($list_arpay as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_arpay']);
            $sheet->setCellValue("B{$contador}", $list['descripcion_arpay']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Arpay Online (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------BALANCE REAL-------------------------------------
    public function Balance_Real(){
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('administrador/balance_real/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Cambiar_Superior_Balance_Real(){
        if ($this->session->userdata('usuario')) { 
            $dato['anio'] = $this->input->post("anio");
            $dato['empresa'] = $this->input->post("empresa");
            $dato['anio_antiguo'] = $dato['anio']-1;

            $get_id = $this->Admin_model->get_id_cod_empresa($dato['empresa']);
            $array = explode("-",$get_id[0]['fecha_inicio']);

            $dato['list_empresas'] = $this->Admin_model->get_list_empresa_balance();
            $dato['list_anio'] = $this->Admin_model->get_list_anio_balance($array[0]);

            $array_ingreso="";
            $array_gasto="";
            $array_utilidad="";
            $array_diferencia="";

            foreach($dato['list_empresas'] as $list){
                $get_cierre_caja_ant = $this->Admin_model->total_cierre_caja($list['cod_empresa'],$dato['anio_antiguo']);
                $get_doc_sunat_ant = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($list['cod_empresa'],$dato['anio_antiguo']);
                $get_nota_credito_ant = $this->Admin_model->total_notas_credito_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);
                $get_cuentas_por_cobrar_ant = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($list['cod_empresa'],$dato['anio_antiguo']);
                $get_gasto_ant = $this->Admin_model->total_gastos_arpay_online($list['cod_empresa'],$dato['anio_antiguo']);

                $ingreso_antiguo = $get_cierre_caja_ant[0]['Total']+$get_doc_sunat_ant[0]['Total']-$get_nota_credito_ant[0]['Total']-$get_cuentas_por_cobrar_ant[0]['Total'];
                $gasto_antiguo = $get_gasto_ant[0]['Total'];
                $utilidad_antiguo = $ingreso_antiguo-$gasto_antiguo;

                $get_cierre_caja = $this->Admin_model->total_cierre_caja($list['cod_empresa'],$dato['anio']);
                $get_doc_sunat = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($list['cod_empresa'],$dato['anio']);
                $get_nota_credito = $this->Admin_model->total_notas_credito_balance_oficial($list['cod_empresa'],$dato['anio']);
                $get_cuentas_por_cobrar = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($list['cod_empresa'],$dato['anio']);
                $get_gasto = $this->Admin_model->total_gastos_arpay_online($list['cod_empresa'],$dato['anio']);

                $ingreso = $get_cierre_caja[0]['Total']+$get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total']-$get_cuentas_por_cobrar[0]['Total'];
                $gasto = $get_gasto[0]['Total'];
                $utilidad = $ingreso-$gasto;
                
                if($utilidad_antiguo==0){
                    $diferencia = 0;
                }else{
                    $diferencia = (($utilidad-$utilidad_antiguo)/$utilidad_antiguo)*100;
                }

                $array_ingreso=$array_ingreso.$ingreso."_";
                $array_gasto=$array_gasto.$gasto."_";
                $array_utilidad=$array_utilidad.$utilidad."_";
                $array_diferencia=$array_diferencia.$diferencia."_";
            }

            $dato['ingreso']=substr($array_ingreso,0,-1);
            $dato['gasto']=substr($array_gasto,0,-1);
            $dato['utilidad']=substr($array_utilidad,0,-1);
            $dato['diferencia']=substr($array_diferencia,0,-1);

            $this->load->view('administrador/balance_real/superior',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Cambiar_Balance_Real(){ 
        if ($this->session->userdata('usuario')) { 
            $dato['empresa'] = $this->input->post("empresa");
            $dato['anio'] = $this->input->post("anio");

            $dato['get_cierre_caja'] = $this->Admin_model->total_cierre_caja($dato['empresa'],$dato['anio']);
            $dato['get_caja_devolucion'] = $this->Admin_model->total_cierre_caja_devolucion($dato['empresa'],$dato['anio']);

            $dato['get_doc_sunat'] = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($dato['empresa'],$dato['anio']);
			$dato['get_nota_credito'] = $this->Admin_model->total_notas_credito_balance_oficial($dato['empresa'],$dato['anio']);
		
			$dato['list_gastos'] = $this->Admin_model->get_list_gastos_arpay_online($dato['empresa'],$dato['anio']);
			$dato['get_gasto'] = $this->Admin_model->total_gastos_arpay_online($dato['empresa'],$dato['anio']);
			
			$dato['list_impuestos'] = $this->Admin_model->get_list_impuestos_arpay_online($dato['empresa'],$dato['anio']);
			$dato['get_impuesto'] = $this->Admin_model->total_impuestos_arpay_online($dato['empresa'],$dato['anio']);
			
			$dato['get_aumento'] = $this->Admin_model->total_aumentos_arpay_online($dato['empresa'],$dato['anio']);
			$dato['get_salida'] = $this->Admin_model->total_salidas_arpay_online($dato['empresa'],$dato['anio']);
			$dato['get_gasto_personal'] = $this->Admin_model->total_gastos_personales_arpay_online($dato['empresa'],$dato['anio']);
			
			$dato['get_cuentas_por_cobrar'] = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($dato['empresa'],$dato['anio']);
			
  			$dato['get_acumulado'] = $this->Admin_model->total_acumulado_arpay_online($dato['empresa']);

            //-----ANTIGUO-----
            $anio_antiguo=$dato['anio']-1;

            $dato['get_cierre_caja_ant'] = $this->Admin_model->total_cierre_caja($dato['empresa'],$anio_antiguo);
            $dato['get_doc_sunat_ant'] = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($dato['empresa'],$anio_antiguo);
			$dato['get_nota_credito_ant'] = $this->Admin_model->total_notas_credito_balance_oficial($dato['empresa'],$anio_antiguo);
			$dato['get_cuentas_por_cobrar_ant'] = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($dato['empresa'],$anio_antiguo);
			$dato['get_gasto_ant'] = $this->Admin_model->total_gastos_arpay_online($dato['empresa'],$anio_antiguo);
			$dato['get_impuesto_ant'] = $this->Admin_model->total_impuestos_arpay_online($dato['empresa'],$anio_antiguo);

            $this->load->view('administrador/balance_real/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Balance_Real($empresa,$anio){
        $get_cierre_caja = $this->Admin_model->total_cierre_caja($empresa,$anio);
        $get_caja_devolucion = $this->Admin_model->total_cierre_caja_devolucion($empresa,$anio);

        $get_doc_sunat = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($empresa,$anio);
        $get_nota_credito = $this->Admin_model->total_notas_credito_balance_oficial($empresa,$anio);
    
        $list_gastos = $this->Admin_model->get_list_gastos_arpay_online($empresa,$anio);
        $get_gasto = $this->Admin_model->total_gastos_arpay_online($empresa,$anio);
        
        $list_impuestos = $this->Admin_model->get_list_impuestos_arpay_online($empresa,$anio);
        $get_impuesto = $this->Admin_model->total_impuestos_arpay_online($empresa,$anio);
        
        $get_aumento = $this->Admin_model->total_aumentos_arpay_online($empresa,$anio);
        $get_salida = $this->Admin_model->total_salidas_arpay_online($empresa,$anio);
        $get_gasto_personal = $this->Admin_model->total_gastos_personales_arpay_online($empresa,$anio);
        
        $get_cuentas_por_cobrar = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($empresa,$anio);
        
        $get_acumulado = $this->Admin_model->total_acumulado_arpay_online($empresa);

        //-----ANTIGUO-----
        $anio_antiguo=$anio-1;

        $get_cierre_caja_ant = $this->Admin_model->total_cierre_caja($empresa,$anio_antiguo);
        $get_doc_sunat_ant = $this->Admin_model->total_cierre_caja_bbva_doc_sunat($empresa,$anio_antiguo);
        $get_nota_credito_ant = $this->Admin_model->total_notas_credito_balance_oficial($empresa,$anio_antiguo);
        $get_cuentas_por_cobrar_ant = $this->Admin_model->total_cuentas_por_cobrar_arpay_online($empresa,$anio_antiguo);
        $get_gasto_ant = $this->Admin_model->total_gastos_arpay_online($empresa,$anio_antiguo);
        $get_impuesto_ant = $this->Admin_model->total_impuestos_arpay_online($empresa,$anio_antiguo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance Real '.$empresa);

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
        $sheet->getColumnDimension('N')->setWidth(15);

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

        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

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

        //----------------------------------------CONTENIDO----------------------------------
        /*ANTIGUO*/
        /*INGRESOS*/
        $ingreso_enero_ant=$get_cierre_caja_ant[0]['Enero']+$get_doc_sunat_ant[0]['Enero']-$get_nota_credito_ant[0]['Enero']-$get_cuentas_por_cobrar_ant[0]['Enero'];
        $ingreso_febrero_ant=$get_cierre_caja_ant[0]['Febrero']+$get_doc_sunat_ant[0]['Febrero']-$get_nota_credito_ant[0]['Febrero']-$get_cuentas_por_cobrar_ant[0]['Febrero'];
        $ingreso_marzo_ant=$get_cierre_caja_ant[0]['Marzo']+$get_doc_sunat_ant[0]['Marzo']-$get_nota_credito_ant[0]['Marzo']-$get_cuentas_por_cobrar_ant[0]['Marzo'];
        $ingreso_abril_ant=$get_cierre_caja_ant[0]['Abril']+$get_doc_sunat_ant[0]['Abril']-$get_nota_credito_ant[0]['Abril']-$get_cuentas_por_cobrar_ant[0]['Abril'];
        $ingreso_mayo_ant=$get_cierre_caja_ant[0]['Mayo']+$get_doc_sunat_ant[0]['Mayo']-$get_nota_credito_ant[0]['Mayo']-$get_cuentas_por_cobrar_ant[0]['Mayo'];
        $ingreso_junio_ant=$get_cierre_caja_ant[0]['Junio']+$get_doc_sunat_ant[0]['Junio']-$get_nota_credito_ant[0]['Junio']-$get_cuentas_por_cobrar_ant[0]['Junio'];
        $ingreso_julio_ant=$get_cierre_caja_ant[0]['Julio']+$get_doc_sunat_ant[0]['Julio']-$get_nota_credito_ant[0]['Julio']-$get_cuentas_por_cobrar_ant[0]['Julio'];
        $ingreso_agosto_ant=$get_cierre_caja_ant[0]['Agosto']+$get_doc_sunat_ant[0]['Agosto']-$get_nota_credito_ant[0]['Agosto']-$get_cuentas_por_cobrar_ant[0]['Agosto'];
        $ingreso_septiembre_ant=$get_cierre_caja_ant[0]['Septiembre']+$get_doc_sunat_ant[0]['Septiembre']-$get_nota_credito_ant[0]['Septiembre']-$get_cuentas_por_cobrar_ant[0]['Septiembre'];
        $ingreso_octubre_ant=$get_cierre_caja_ant[0]['Octubre']+$get_doc_sunat_ant[0]['Octubre']-$get_nota_credito_ant[0]['Octubre']-$get_cuentas_por_cobrar_ant[0]['Octubre'];
        $ingreso_noviembre_ant=$get_cierre_caja_ant[0]['Noviembre']+$get_doc_sunat_ant[0]['Noviembre']-$get_nota_credito_ant[0]['Noviembre']-$get_cuentas_por_cobrar_ant[0]['Noviembre'];
        $ingreso_diciembre_ant=$get_cierre_caja_ant[0]['Diciembre']+$get_doc_sunat_ant[0]['Diciembre']-$get_nota_credito_ant[0]['Diciembre']-$get_cuentas_por_cobrar_ant[0]['Diciembre'];
        $ingreso_total_ant=$get_cierre_caja_ant[0]['Total']+$get_doc_sunat_ant[0]['Total']-$get_nota_credito_ant[0]['Total']-$get_cuentas_por_cobrar_ant[0]['Total'];

        /*UTILIDAD(BEFORE TAX)*/
        $before_enero_ant=$ingreso_enero_ant-$get_gasto_ant[0]['Enero']; 
        $before_febrero_ant=$ingreso_febrero_ant-$get_gasto_ant[0]['Febrero']; 
        $before_marzo_ant=$ingreso_marzo_ant-$get_gasto_ant[0]['Marzo']; 
        $before_abril_ant=$ingreso_abril_ant-$get_gasto_ant[0]['Abril']; 
        $before_mayo_ant=$ingreso_mayo_ant-$get_gasto_ant[0]['Mayo']; 
        $before_junio_ant=$ingreso_junio_ant-$get_gasto_ant[0]['Junio']; 
        $before_julio_ant=$ingreso_julio_ant-$get_gasto_ant[0]['Julio']; 
        $before_agosto_ant=$ingreso_agosto_ant-$get_gasto_ant[0]['Agosto']; 
        $before_septiembre_ant=$ingreso_septiembre_ant-$get_gasto_ant[0]['Septiembre']; 
        $before_octubre_ant=$ingreso_octubre_ant-$get_gasto_ant[0]['Octubre']; 
        $before_noviembre_ant=$ingreso_noviembre_ant-$get_gasto_ant[0]['Noviembre']; 
        $before_diciembre_ant=$ingreso_diciembre_ant-$get_gasto_ant[0]['Diciembre']; 
        $before_total_ant=$ingreso_total_ant-$get_gasto_ant[0]['Total']; 

        /*UTILIDAD(AFTER TAX)*/
        $after_enero_ant=$before_enero_ant-$get_impuesto_ant[0]['Enero']; 
        $after_febrero_ant=$before_febrero_ant-$get_impuesto_ant[0]['Febrero']; 
        $after_marzo_ant=$before_marzo_ant-$get_impuesto_ant[0]['Marzo']; 
        $after_abril_ant=$before_abril_ant-$get_impuesto_ant[0]['Abril']; 
        $after_mayo_ant=$before_mayo_ant-$get_impuesto_ant[0]['Mayo']; 
        $after_junio_ant=$before_junio_ant-$get_impuesto_ant[0]['Junio']; 
        $after_julio_ant=$before_julio_ant-$get_impuesto_ant[0]['Julio']; 
        $after_agosto_ant=$before_agosto_ant-$get_impuesto_ant[0]['Agosto']; 
        $after_septiembre_ant=$before_septiembre_ant-$get_impuesto_ant[0]['Septiembre']; 
        $after_octubre_ant=$before_octubre_ant-$get_impuesto_ant[0]['Octubre']; 
        $after_noviembre_ant=$before_noviembre_ant-$get_impuesto_ant[0]['Noviembre']; 
        $after_diciembre_ant=$before_diciembre_ant-$get_impuesto_ant[0]['Diciembre']; 
        $after_total_ant=$before_total_ant-$get_impuesto_ant[0]['Total']; 

        /*ACTUAL*/
        /*INGRESOS*/
        $ingreso_enero=$get_cierre_caja[0]['Enero']+$get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero']-$get_cuentas_por_cobrar[0]['Enero'];
        $ingreso_febrero=$get_cierre_caja[0]['Febrero']+$get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero']-$get_cuentas_por_cobrar[0]['Febrero'];
        $ingreso_marzo=$get_cierre_caja[0]['Marzo']+$get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo']-$get_cuentas_por_cobrar[0]['Marzo'];
        $ingreso_abril=$get_cierre_caja[0]['Abril']+$get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril']-$get_cuentas_por_cobrar[0]['Abril'];
        $ingreso_mayo=$get_cierre_caja[0]['Mayo']+$get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo']-$get_cuentas_por_cobrar[0]['Mayo'];
        $ingreso_junio=$get_cierre_caja[0]['Junio']+$get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio']-$get_cuentas_por_cobrar[0]['Junio'];
        $ingreso_julio=$get_cierre_caja[0]['Julio']+$get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio']-$get_cuentas_por_cobrar[0]['Julio'];
        $ingreso_agosto=$get_cierre_caja[0]['Agosto']+$get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto']-$get_cuentas_por_cobrar[0]['Agosto'];
        $ingreso_septiembre=$get_cierre_caja[0]['Septiembre']+$get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre']-$get_cuentas_por_cobrar[0]['Septiembre'];
        $ingreso_octubre=$get_cierre_caja[0]['Octubre']+$get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre']-$get_cuentas_por_cobrar[0]['Octubre'];
        $ingreso_noviembre=$get_cierre_caja[0]['Noviembre']+$get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre']-$get_cuentas_por_cobrar[0]['Noviembre'];
        $ingreso_diciembre=$get_cierre_caja[0]['Diciembre']+$get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre']-$get_cuentas_por_cobrar[0]['Diciembre'];
        $ingreso_total=$get_cierre_caja[0]['Total']+$get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total']-$get_cuentas_por_cobrar[0]['Total'];

        /*UTILIDAD(BEFORE TAX)*/
        $before_enero=$ingreso_enero-$get_gasto[0]['Enero']; 
        $before_febrero=$ingreso_febrero-$get_gasto[0]['Febrero']; 
        $before_marzo=$ingreso_marzo-$get_gasto[0]['Marzo']; 
        $before_abril=$ingreso_abril-$get_gasto[0]['Abril']; 
        $before_mayo=$ingreso_mayo-$get_gasto[0]['Mayo']; 
        $before_junio=$ingreso_junio-$get_gasto[0]['Junio']; 
        $before_julio=$ingreso_julio-$get_gasto[0]['Julio']; 
        $before_agosto=$ingreso_agosto-$get_gasto[0]['Agosto']; 
        $before_septiembre=$ingreso_septiembre-$get_gasto[0]['Septiembre']; 
        $before_octubre=$ingreso_octubre-$get_gasto[0]['Octubre']; 
        $before_noviembre=$ingreso_noviembre-$get_gasto[0]['Noviembre']; 
        $before_diciembre=$ingreso_diciembre-$get_gasto[0]['Diciembre']; 
        $before_total=$ingreso_total-$get_gasto[0]['Total']; 

        /*UTILIDAD(AFTER TAX)*/
        $after_enero=$before_enero-$get_impuesto[0]['Enero']; 
        $after_febrero=$before_febrero-$get_impuesto[0]['Febrero']; 
        $after_marzo=$before_marzo-$get_impuesto[0]['Marzo']; 
        $after_abril=$before_abril-$get_impuesto[0]['Abril']; 
        $after_mayo=$before_mayo-$get_impuesto[0]['Mayo']; 
        $after_junio=$before_junio-$get_impuesto[0]['Junio']; 
        $after_julio=$before_julio-$get_impuesto[0]['Julio']; 
        $after_agosto=$before_agosto-$get_impuesto[0]['Agosto']; 
        $after_septiembre=$before_septiembre-$get_impuesto[0]['Septiembre']; 
        $after_octubre=$before_octubre-$get_impuesto[0]['Octubre']; 
        $after_noviembre=$before_noviembre-$get_impuesto[0]['Noviembre']; 
        $after_diciembre=$before_diciembre-$get_impuesto[0]['Diciembre']; 
        $after_total=$before_total-$get_impuesto[0]['Total']; 

        /*CAPITAL-TOTAL*/
        $capital_enero=$get_aumento[0]['Enero']-$get_salida[0]['Enero']-$get_gasto_personal[0]['Enero'];
        $capital_febrero=$get_aumento[0]['Febrero']-$get_salida[0]['Febrero']-$get_gasto_personal[0]['Febrero'];
        $capital_marzo=$get_aumento[0]['Marzo']-$get_salida[0]['Marzo']-$get_gasto_personal[0]['Marzo'];
        $capital_abril=$get_aumento[0]['Abril']-$get_salida[0]['Abril']-$get_gasto_personal[0]['Abril'];
        $capital_mayo=$get_aumento[0]['Mayo']-$get_salida[0]['Mayo']-$get_gasto_personal[0]['Mayo'];
        $capital_junio=$get_aumento[0]['Junio']-$get_salida[0]['Junio']-$get_gasto_personal[0]['Junio'];
        $capital_julio=$get_aumento[0]['Julio']-$get_salida[0]['Julio']-$get_gasto_personal[0]['Julio'];
        $capital_agosto=$get_aumento[0]['Agosto']-$get_salida[0]['Agosto']-$get_gasto_personal[0]['Agosto'];
        $capital_septiembre=$get_aumento[0]['Septiembre']-$get_salida[0]['Septiembre']-$get_gasto_personal[0]['Septiembre'];
        $capital_octubre=$get_aumento[0]['Octubre']-$get_salida[0]['Octubre']-$get_gasto_personal[0]['Octubre'];
        $capital_noviembre=$get_aumento[0]['Noviembre']-$get_salida[0]['Noviembre']-$get_gasto_personal[0]['Noviembre'];
        $capital_diciembre=$get_aumento[0]['Diciembre']-$get_salida[0]['Diciembre']-$get_gasto_personal[0]['Diciembre'];
        $capital_total=$get_aumento[0]['Total']-$get_salida[0]['Total']-$get_gasto_personal[0]['Total'];

        /*PENDIENTES*/
        $pendiente_febrero=$get_cuentas_por_cobrar[0]['Enero']+$get_cuentas_por_cobrar[0]['Febrero'];
        $pendiente_marzo=$pendiente_febrero+$get_cuentas_por_cobrar[0]['Marzo'];
        $pendiente_abril=$pendiente_marzo+$get_cuentas_por_cobrar[0]['Abril'];
        $pendiente_mayo=$pendiente_abril+$get_cuentas_por_cobrar[0]['Mayo'];
        $pendiente_junio=$pendiente_mayo+$get_cuentas_por_cobrar[0]['Junio'];
        $pendiente_julio=$pendiente_junio+$get_cuentas_por_cobrar[0]['Julio'];
        $pendiente_agosto=$pendiente_julio+$get_cuentas_por_cobrar[0]['Agosto'];
        $pendiente_septiembre=$pendiente_agosto+$get_cuentas_por_cobrar[0]['Septiembre'];
        $pendiente_octubre=$pendiente_septiembre+$get_cuentas_por_cobrar[0]['Octubre'];
        $pendiente_noviembre=$pendiente_octubre+$get_cuentas_por_cobrar[0]['Noviembre'];
        $pendiente_diciembre=$pendiente_noviembre+$get_cuentas_por_cobrar[0]['Diciembre'];

        /*ACUMULADO*/
        $acumulado_febrero=$get_acumulado[0]['Enero']+$get_acumulado[0]['Febrero'];
        $acumulado_marzo=$acumulado_febrero+$get_acumulado[0]['Marzo'];
        $acumulado_abril=$acumulado_marzo+$get_acumulado[0]['Abril'];
        $acumulado_mayo=$acumulado_abril+$get_acumulado[0]['Mayo'];
        $acumulado_junio=$acumulado_mayo+$get_acumulado[0]['Junio'];
        $acumulado_julio=$acumulado_junio+$get_acumulado[0]['Julio'];
        $acumulado_agosto=$acumulado_julio+$get_acumulado[0]['Agosto'];
        $acumulado_septiembre=$acumulado_agosto+$get_acumulado[0]['Septiembre'];
        $acumulado_octubre=$acumulado_septiembre+$get_acumulado[0]['Octubre'];
        $acumulado_noviembre=$acumulado_octubre+$get_acumulado[0]['Noviembre'];
        $acumulado_diciembre=$acumulado_noviembre+$get_acumulado[0]['Diciembre'];

        /*DIFERENCIA*/
        if($ingreso_enero_ant==0){
            $diferencia_ingreso_enero = 0;
        }else{
            $diferencia_ingreso_enero = (($ingreso_enero-$ingreso_enero_ant)/$ingreso_enero_ant)*100;
        }
        if($ingreso_febrero_ant==0){
            $diferencia_ingreso_febrero = 0;
        }else{
            $diferencia_ingreso_febrero = (($ingreso_febrero-$ingreso_febrero_ant)/$ingreso_febrero_ant)*100;
        }
        if($ingreso_marzo_ant==0){
            $diferencia_ingreso_marzo = 0;
        }else{
            $diferencia_ingreso_marzo = (($ingreso_marzo-$ingreso_marzo_ant)/$ingreso_marzo_ant)*100;
        }
        if($ingreso_abril_ant==0){
            $diferencia_ingreso_abril = 0;
        }else{
            $diferencia_ingreso_abril = (($ingreso_abril-$ingreso_abril_ant)/$ingreso_abril_ant)*100;
        }
        if($ingreso_mayo_ant==0){
            $diferencia_ingreso_mayo = 0;
        }else{
            $diferencia_ingreso_mayo = (($ingreso_mayo-$ingreso_mayo_ant)/$ingreso_mayo_ant)*100;
        }
        if($ingreso_junio_ant==0){
            $diferencia_ingreso_junio = 0;
        }else{
            $diferencia_ingreso_junio = (($ingreso_junio-$ingreso_junio_ant)/$ingreso_junio_ant)*100;
        }
        if($ingreso_julio_ant==0){
            $diferencia_ingreso_julio = 0;
        }else{
            $diferencia_ingreso_julio = (($ingreso_julio-$ingreso_julio_ant)/$ingreso_julio_ant)*100;
        }
        if($ingreso_agosto_ant==0){
            $diferencia_ingreso_agosto = 0;
        }else{
            $diferencia_ingreso_agosto = (($ingreso_agosto-$ingreso_agosto_ant)/$ingreso_agosto_ant)*100;
        }
        if($ingreso_septiembre_ant==0){
            $diferencia_ingreso_septiembre = 0;
        }else{
            $diferencia_ingreso_septiembre = (($ingreso_septiembre-$ingreso_septiembre_ant)/$ingreso_septiembre_ant)*100;
        }
        if($ingreso_octubre_ant==0){
            $diferencia_ingreso_octubre = 0;
        }else{
            $diferencia_ingreso_octubre = (($ingreso_octubre-$ingreso_octubre_ant)/$ingreso_octubre_ant)*100;
        }
        if($ingreso_noviembre_ant==0){
            $diferencia_ingreso_noviembre = 0;
        }else{
            $diferencia_ingreso_noviembre = (($ingreso_noviembre-$ingreso_noviembre_ant)/$ingreso_noviembre_ant)*100;
        }
        if($ingreso_diciembre_ant==0){
            $diferencia_ingreso_diciembre = 0;
        }else{
            $diferencia_ingreso_diciembre = (($ingreso_diciembre-$ingreso_diciembre_ant)/$ingreso_diciembre_ant)*100;
        }
        if($ingreso_total_ant==0){
            $diferencia_ingreso_total = 0;
        }else{
            $diferencia_ingreso_total = (($ingreso_total-$ingreso_total_ant)/$ingreso_total_ant)*100;
        }


        if($get_gasto_ant[0]['Enero']==0){
            $diferencia_gasto_enero = 0;
        }else{
            $diferencia_gasto_enero = (($get_gasto[0]['Enero']-$get_gasto_ant[0]['Enero'])/$get_gasto_ant[0]['Enero'])*100;
        }
        if($get_gasto_ant[0]['Febrero']==0){
            $diferencia_gasto_febrero = 0;
        }else{
            $diferencia_gasto_febrero = (($get_gasto[0]['Febrero']-$get_gasto_ant[0]['Febrero'])/$get_gasto_ant[0]['Febrero'])*100;
        }
        if($get_gasto_ant[0]['Marzo']==0){
            $diferencia_gasto_marzo = 0;
        }else{
            $diferencia_gasto_marzo = (($get_gasto[0]['Marzo']-$get_gasto_ant[0]['Marzo'])/$get_gasto_ant[0]['Marzo'])*100;
        }
        if($get_gasto_ant[0]['Abril']==0){
            $diferencia_gasto_abril = 0;
        }else{
            $diferencia_gasto_abril = (($get_gasto[0]['Abril']-$get_gasto_ant[0]['Abril'])/$get_gasto_ant[0]['Abril'])*100;
        }
        if($get_gasto_ant[0]['Mayo']==0){
            $diferencia_gasto_mayo = 0;
        }else{
            $diferencia_gasto_mayo = (($get_gasto[0]['Mayo']-$get_gasto_ant[0]['Mayo'])/$get_gasto_ant[0]['Mayo'])*100;
        }
        if($get_gasto_ant[0]['Junio']==0){
            $diferencia_gasto_junio = 0;
        }else{
            $diferencia_gasto_junio = (($get_gasto[0]['Junio']-$get_gasto_ant[0]['Junio'])/$get_gasto_ant[0]['Junio'])*100;
        }
        if($get_gasto_ant[0]['Julio']==0){
            $diferencia_gasto_julio = 0;
        }else{
            $diferencia_gasto_julio = (($get_gasto[0]['Julio']-$get_gasto_ant[0]['Julio'])/$get_gasto_ant[0]['Julio'])*100;
        }
        if($get_gasto_ant[0]['Agosto']==0){
            $diferencia_gasto_agosto = 0;
        }else{
            $diferencia_gasto_agosto = (($get_gasto[0]['Agosto']-$get_gasto_ant[0]['Agosto'])/$get_gasto_ant[0]['Agosto'])*100;
        }
        if($get_gasto_ant[0]['Septiembre']==0){
            $diferencia_gasto_septiembre = 0;
        }else{
            $diferencia_gasto_septiembre = (($get_gasto[0]['Septiembre']-$get_gasto_ant[0]['Septiembre'])/$get_gasto_ant[0]['Septiembre'])*100;
        }
        if($get_gasto_ant[0]['Octubre']==0){
            $diferencia_gasto_octubre = 0;
        }else{
            $diferencia_gasto_octubre = (($get_gasto[0]['Octubre']-$get_gasto_ant[0]['Octubre'])/$get_gasto_ant[0]['Octubre'])*100;
        }
        if($get_gasto_ant[0]['Noviembre']==0){
            $diferencia_gasto_noviembre = 0;
        }else{
            $diferencia_gasto_noviembre = (($get_gasto[0]['Noviembre']-$get_gasto_ant[0]['Noviembre'])/$get_gasto_ant[0]['Noviembre'])*100;
        }
        if($get_gasto_ant[0]['Diciembre']==0){
            $diferencia_gasto_diciembre = 0;
        }else{
            $diferencia_gasto_diciembre = (($get_gasto[0]['Diciembre']-$get_gasto_ant[0]['Diciembre'])/$get_gasto_ant[0]['Diciembre'])*100;
        }
        if($get_gasto_ant[0]['Total']==0){
            $diferencia_gasto_total = 0;
        }else{
            $diferencia_gasto_total = (($get_gasto[0]['Total']-$get_gasto_ant[0]['Total'])/$get_gasto_ant[0]['Total'])*100;
        }

        
        if($before_enero_ant==0){
            $diferencia_before_enero = 0;
        }else{
            $diferencia_before_enero = (($before_enero-$before_enero_ant)/$before_enero_ant)*100;
        }
        if($before_febrero_ant==0){
            $diferencia_before_febrero = 0;
        }else{
            $diferencia_before_febrero = (($before_febrero-$before_febrero_ant)/$before_febrero_ant)*100;
        }
        if($before_marzo_ant==0){
            $diferencia_before_marzo = 0;
        }else{
            $diferencia_before_marzo = (($before_marzo-$before_marzo_ant)/$before_marzo_ant)*100;
        }
        if($before_abril_ant==0){
            $diferencia_before_abril = 0;
        }else{
            $diferencia_before_abril = (($before_abril-$before_abril_ant)/$before_abril_ant)*100;
        }
        if($before_mayo_ant==0){
            $diferencia_before_mayo = 0;
        }else{
            $diferencia_before_mayo = (($before_mayo-$before_mayo_ant)/$before_mayo_ant)*100;
        }
        if($before_junio_ant==0){
            $diferencia_before_junio = 0;
        }else{
            $diferencia_before_junio = (($before_junio-$before_junio_ant)/$before_junio_ant)*100;
        }
        if($before_julio_ant==0){
            $diferencia_before_julio = 0;
        }else{
            $diferencia_before_julio = (($before_julio-$before_julio_ant)/$before_julio_ant)*100;
        }
        if($before_agosto_ant==0){
            $diferencia_before_agosto = 0;
        }else{
            $diferencia_before_agosto = (($before_agosto-$before_agosto_ant)/$before_agosto_ant)*100;
        }
        if($before_septiembre_ant==0){
            $diferencia_before_septiembre = 0;
        }else{
            $diferencia_before_septiembre = (($before_septiembre-$before_septiembre_ant)/$before_septiembre_ant)*100;
        }
        if($before_octubre_ant==0){
            $diferencia_before_octubre = 0;
        }else{
            $diferencia_before_octubre = (($before_octubre-$before_octubre_ant)/$before_octubre_ant)*100;
        }
        if($before_noviembre_ant==0){
            $diferencia_before_noviembre = 0;
        }else{
            $diferencia_before_noviembre = (($before_noviembre-$before_noviembre_ant)/$before_noviembre_ant)*100;
        }
        if($before_diciembre_ant==0){
            $diferencia_before_diciembre = 0;
        }else{
            $diferencia_before_diciembre = (($before_diciembre-$before_diciembre_ant)/$before_diciembre_ant)*100;
        }
        if($before_total_ant==0){
            $diferencia_before_total = 0;
        }else{
            $diferencia_before_total = (($before_total-$before_total_ant)/$before_total_ant)*100;
        }


        if($get_impuesto_ant[0]['Enero']==0){
            $diferencia_impuesto_enero = 0;
        }else{
            $diferencia_impuesto_enero = (($get_impuesto[0]['Enero']-$get_impuesto_ant[0]['Enero'])/$get_impuesto_ant[0]['Enero'])*100;
        }
        if($get_impuesto_ant[0]['Febrero']==0){
            $diferencia_impuesto_febrero = 0;
        }else{
            $diferencia_impuesto_febrero = (($get_impuesto[0]['Febrero']-$get_impuesto_ant[0]['Febrero'])/$get_impuesto_ant[0]['Febrero'])*100;
        }
        if($get_impuesto_ant[0]['Marzo']==0){
            $diferencia_impuesto_marzo = 0;
        }else{
            $diferencia_impuesto_marzo = (($get_impuesto[0]['Marzo']-$get_impuesto_ant[0]['Marzo'])/$get_impuesto_ant[0]['Marzo'])*100;
        }
        if($get_impuesto_ant[0]['Abril']==0){
            $diferencia_impuesto_abril = 0;
        }else{
            $diferencia_impuesto_abril = (($get_impuesto[0]['Abril']-$get_impuesto_ant[0]['Abril'])/$get_impuesto_ant[0]['Abril'])*100;
        }
        if($get_impuesto_ant[0]['Mayo']==0){
            $diferencia_impuesto_mayo = 0;
        }else{
            $diferencia_impuesto_mayo = (($get_impuesto[0]['Mayo']-$get_impuesto_ant[0]['Mayo'])/$get_impuesto_ant[0]['Mayo'])*100;
        }
        if($get_impuesto_ant[0]['Junio']==0){
            $diferencia_impuesto_junio = 0;
        }else{
            $diferencia_impuesto_junio = (($get_impuesto[0]['Junio']-$get_impuesto_ant[0]['Junio'])/$get_impuesto_ant[0]['Junio'])*100;
        }
        if($get_impuesto_ant[0]['Julio']==0){
            $diferencia_impuesto_julio = 0;
        }else{
            $diferencia_impuesto_julio = (($get_impuesto[0]['Julio']-$get_impuesto_ant[0]['Julio'])/$get_impuesto_ant[0]['Julio'])*100;
        }
        if($get_impuesto_ant[0]['Agosto']==0){
            $diferencia_impuesto_agosto = 0;
        }else{
            $diferencia_impuesto_agosto = (($get_impuesto[0]['Agosto']-$get_impuesto_ant[0]['Agosto'])/$get_impuesto_ant[0]['Agosto'])*100;
        }
        if($get_impuesto_ant[0]['Septiembre']==0){
            $diferencia_impuesto_septiembre = 0;
        }else{
            $diferencia_impuesto_septiembre = (($get_impuesto[0]['Septiembre']-$get_impuesto_ant[0]['Septiembre'])/$get_impuesto_ant[0]['Septiembre'])*100;
        }
        if($get_impuesto_ant[0]['Octubre']==0){
            $diferencia_impuesto_octubre = 0;
        }else{
            $diferencia_impuesto_octubre = (($get_impuesto[0]['Octubre']-$get_impuesto_ant[0]['Octubre'])/$get_impuesto_ant[0]['Octubre'])*100;
        }
        if($get_impuesto_ant[0]['Noviembre']==0){
            $diferencia_impuesto_noviembre = 0;
        }else{
            $diferencia_impuesto_noviembre = (($get_impuesto[0]['Noviembre']-$get_impuesto_ant[0]['Noviembre'])/$get_impuesto_ant[0]['Noviembre'])*100;
        }
        if($get_impuesto_ant[0]['Diciembre']==0){
            $diferencia_impuesto_diciembre = 0;
        }else{
            $diferencia_impuesto_diciembre = (($get_impuesto[0]['Diciembre']-$get_impuesto_ant[0]['Diciembre'])/$get_impuesto_ant[0]['Diciembre'])*100;
        }
        if($get_impuesto_ant[0]['Total']==0){
            $diferencia_impuesto_total = 0;
        }else{
            $diferencia_impuesto_total = (($get_impuesto[0]['Total']-$get_impuesto_ant[0]['Total'])/$get_impuesto_ant[0]['Total'])*100;
        }


        if($after_enero_ant==0){
            $diferencia_after_enero = 0;
        }else{
            $diferencia_after_enero = (($after_enero-$after_enero_ant)/$after_enero_ant)*100;
        }
        if($after_febrero_ant==0){
            $diferencia_after_febrero = 0;
        }else{
            $diferencia_after_febrero = (($after_febrero-$after_febrero_ant)/$after_febrero_ant)*100;
        }
        if($after_marzo_ant==0){
            $diferencia_after_marzo = 0;
        }else{
            $diferencia_after_marzo = (($after_marzo-$after_marzo_ant)/$after_marzo_ant)*100;
        }
        if($after_abril_ant==0){
            $diferencia_after_abril = 0;
        }else{
            $diferencia_after_abril = (($after_abril-$after_abril_ant)/$after_abril_ant)*100;
        }
        if($after_mayo_ant==0){
            $diferencia_after_mayo = 0;
        }else{
            $diferencia_after_mayo = (($after_mayo-$after_mayo_ant)/$after_mayo_ant)*100;
        }
        if($after_junio_ant==0){
            $diferencia_after_junio = 0;
        }else{
            $diferencia_after_junio = (($after_junio-$after_junio_ant)/$after_junio_ant)*100;
        }
        if($after_julio_ant==0){
            $diferencia_after_julio = 0;
        }else{
            $diferencia_after_julio = (($after_julio-$after_julio_ant)/$after_julio_ant)*100;
        }
        if($after_agosto_ant==0){
            $diferencia_after_agosto = 0;
        }else{
            $diferencia_after_agosto = (($after_agosto-$after_agosto_ant)/$after_agosto_ant)*100;
        }
        if($after_septiembre_ant==0){
            $diferencia_after_septiembre = 0;
        }else{
            $diferencia_after_septiembre = (($after_septiembre-$after_septiembre_ant)/$after_septiembre_ant)*100;
        }
        if($after_octubre_ant==0){
            $diferencia_after_octubre = 0;
        }else{
            $diferencia_after_octubre = (($after_octubre-$after_octubre_ant)/$after_octubre_ant)*100;
        }
        if($after_noviembre_ant==0){
            $diferencia_after_noviembre = 0;
        }else{
            $diferencia_after_noviembre = (($after_noviembre-$after_noviembre_ant)/$after_noviembre_ant)*100;
        }
        if($after_diciembre_ant==0){
            $diferencia_after_diciembre = 0;
        }else{
            $diferencia_after_diciembre = (($after_diciembre-$after_diciembre_ant)/$after_diciembre_ant)*100;
        }
        if($after_total_ant==0){
            $diferencia_after_total = 0;
        }else{
            $diferencia_after_total = (($after_total-$after_total_ant)/$after_total_ant)*100;
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

        $spreadsheet->getActiveSheet()->getStyle("N2:N3")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('8DBF42');

        $sheet->getStyle('N2:N3')->getFont()->getColor()->setRGB('FFFFFF');
        
        $sheet->getStyle("B2:N2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->getStyle("A4:A10")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A4:A10")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A5')->getFont()->setBold(true);  
        $sheet->getStyle('A8')->getFont()->setBold(true);  

        $sheet->getStyle("A1:N10")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B2:N10")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B2:N10")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("B4:N10")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        
        $sheet->setCellValue("A2", 'INGRESOS');
        $sheet->setCellValue("B2", $ingreso_enero);
        $sheet->setCellValue("C2", $ingreso_febrero);
        $sheet->setCellValue("D2", $ingreso_marzo);
        $sheet->setCellValue("E2", $ingreso_abril);
        $sheet->setCellValue("F2", $ingreso_mayo);
        $sheet->setCellValue("G2", $ingreso_junio);
        $sheet->setCellValue("H2", $ingreso_julio);
        $sheet->setCellValue("I2", $ingreso_agosto);
        $sheet->setCellValue("J2", $ingreso_septiembre);
        $sheet->setCellValue("K2", $ingreso_octubre);
        $sheet->setCellValue("L2", $ingreso_noviembre);
        $sheet->setCellValue("M2", $ingreso_diciembre);
        $sheet->setCellValue("N2", $ingreso_total);

        $sheet->setCellValue("B3", number_format($diferencia_ingreso_enero,2)."%");
        $sheet->setCellValue("C3", number_format($diferencia_ingreso_febrero,2)."%");
        $sheet->setCellValue("D3", number_format($diferencia_ingreso_marzo,2)."%");
        $sheet->setCellValue("E3", number_format($diferencia_ingreso_abril,2)."%");
        $sheet->setCellValue("F3", number_format($diferencia_ingreso_mayo,2)."%");
        $sheet->setCellValue("G3", number_format($diferencia_ingreso_junio,2)."%");
        $sheet->setCellValue("H3", number_format($diferencia_ingreso_julio,2)."%");
        $sheet->setCellValue("I3", number_format($diferencia_ingreso_agosto,2)."%");
        $sheet->setCellValue("J3", number_format($diferencia_ingreso_septiembre,2)."%");
        $sheet->setCellValue("K3", number_format($diferencia_ingreso_octubre,2)."%");
        $sheet->setCellValue("L3", number_format($diferencia_ingreso_noviembre,2)."%");
        $sheet->setCellValue("M3", number_format($diferencia_ingreso_diciembre,2)."%");
        $sheet->setCellValue("N3", number_format($diferencia_ingreso_total,2)."%");

        $sheet->setCellValue("A4", 'Productos');
        $sheet->setCellValue("B4", $ingreso_enero);
        $sheet->setCellValue("C4", $ingreso_febrero);
        $sheet->setCellValue("D4", $ingreso_marzo);
        $sheet->setCellValue("E4", $ingreso_abril);
        $sheet->setCellValue("F4", $ingreso_mayo);
        $sheet->setCellValue("G4", $ingreso_junio);
        $sheet->setCellValue("H4", $ingreso_julio);
        $sheet->setCellValue("I4", $ingreso_agosto);
        $sheet->setCellValue("J4", $ingreso_septiembre);
        $sheet->setCellValue("K4", $ingreso_octubre);
        $sheet->setCellValue("L4", $ingreso_noviembre);
        $sheet->setCellValue("M4", $ingreso_diciembre);
        $sheet->setCellValue("N4", $ingreso_total);

        $sheet->setCellValue("A5", 'Cierre Caja (Cash)');
        $sheet->setCellValue("B5", $get_cierre_caja[0]['Enero']);
        $sheet->setCellValue("C5", $get_cierre_caja[0]['Febrero']);
        $sheet->setCellValue("D5", $get_cierre_caja[0]['Marzo']);
        $sheet->setCellValue("E5", $get_cierre_caja[0]['Abril']);
        $sheet->setCellValue("F5", $get_cierre_caja[0]['Mayo']);
        $sheet->setCellValue("G5", $get_cierre_caja[0]['Junio']);
        $sheet->setCellValue("H5", $get_cierre_caja[0]['Julio']);
        $sheet->setCellValue("I5", $get_cierre_caja[0]['Agosto']);
        $sheet->setCellValue("J5", $get_cierre_caja[0]['Septiembre']);
        $sheet->setCellValue("K5", $get_cierre_caja[0]['Octubre']);
        $sheet->setCellValue("L5", $get_cierre_caja[0]['Noviembre']);
        $sheet->setCellValue("M5", $get_cierre_caja[0]['Diciembre']);
        $sheet->setCellValue("N5", $get_cierre_caja[0]['Total']);

        $sheet->setCellValue("A6", 'Recibos');
        $sheet->setCellValue("B6", ($get_cierre_caja[0]['Enero']-$get_caja_devolucion[0]['Enero']));
        $sheet->setCellValue("C6", ($get_cierre_caja[0]['Febrero']-$get_caja_devolucion[0]['Febrero']));
        $sheet->setCellValue("D6", ($get_cierre_caja[0]['Marzo']-$get_caja_devolucion[0]['Marzo']));
        $sheet->setCellValue("E6", ($get_cierre_caja[0]['Abril']-$get_caja_devolucion[0]['Abril']));
        $sheet->setCellValue("F6", ($get_cierre_caja[0]['Mayo']-$get_caja_devolucion[0]['Mayo']));
        $sheet->setCellValue("G6", ($get_cierre_caja[0]['Junio']-$get_caja_devolucion[0]['Junio']));
        $sheet->setCellValue("H6", ($get_cierre_caja[0]['Julio']-$get_caja_devolucion[0]['Julio']));
        $sheet->setCellValue("I6", ($get_cierre_caja[0]['Agosto']-$get_caja_devolucion[0]['Agosto']));
        $sheet->setCellValue("J6", ($get_cierre_caja[0]['Septiembre']-$get_caja_devolucion[0]['Septiembre']));
        $sheet->setCellValue("K6", ($get_cierre_caja[0]['Octubre']-$get_caja_devolucion[0]['Octubre']));
        $sheet->setCellValue("L6", ($get_cierre_caja[0]['Noviembre']-$get_caja_devolucion[0]['Noviembre']));
        $sheet->setCellValue("M6", ($get_cierre_caja[0]['Diciembre']-$get_caja_devolucion[0]['Diciembre']));
        $sheet->setCellValue("N6", ($get_cierre_caja[0]['Total']-$get_caja_devolucion[0]['Total']));

        $sheet->setCellValue("A7", 'Devoluciones');
        $sheet->setCellValue("B7", $get_caja_devolucion[0]['Enero']);
        $sheet->setCellValue("C7", $get_caja_devolucion[0]['Febrero']);
        $sheet->setCellValue("D7", $get_caja_devolucion[0]['Marzo']);
        $sheet->setCellValue("E7", $get_caja_devolucion[0]['Abril']);
        $sheet->setCellValue("F7", $get_caja_devolucion[0]['Mayo']);
        $sheet->setCellValue("G7", $get_caja_devolucion[0]['Junio']);
        $sheet->setCellValue("H7", $get_caja_devolucion[0]['Julio']);
        $sheet->setCellValue("I7", $get_caja_devolucion[0]['Agosto']);
        $sheet->setCellValue("J7", $get_caja_devolucion[0]['Septiembre']);
        $sheet->setCellValue("K7", $get_caja_devolucion[0]['Octubre']);
        $sheet->setCellValue("L7", $get_caja_devolucion[0]['Noviembre']);
        $sheet->setCellValue("M7", $get_caja_devolucion[0]['Diciembre']);
        $sheet->setCellValue("N7", $get_caja_devolucion[0]['Total']);

        $sheet->setCellValue("A8", 'Cierre Caja (BBVA)');
        $sheet->setCellValue("B8", ($get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero']));
        $sheet->setCellValue("C8", ($get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero']));
        $sheet->setCellValue("D8", ($get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo']));
        $sheet->setCellValue("E8", ($get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril']));
        $sheet->setCellValue("F8", ($get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo']));
        $sheet->setCellValue("G8", ($get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio']));
        $sheet->setCellValue("H8", ($get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio']));
        $sheet->setCellValue("I8", ($get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto']));
        $sheet->setCellValue("J8", ($get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre']));
        $sheet->setCellValue("K8", ($get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre']));
        $sheet->setCellValue("L8", ($get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre']));
        $sheet->setCellValue("M8", ($get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre']));
        $sheet->setCellValue("N8", ($get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total']));

        $sheet->setCellValue("A9", 'Doc Sunat');
        $sheet->setCellValue("B9", $get_doc_sunat[0]['Enero']);
        $sheet->setCellValue("C9", $get_doc_sunat[0]['Febrero']);
        $sheet->setCellValue("D9", $get_doc_sunat[0]['Marzo']);
        $sheet->setCellValue("E9", $get_doc_sunat[0]['Abril']);
        $sheet->setCellValue("F9", $get_doc_sunat[0]['Mayo']);
        $sheet->setCellValue("G9", $get_doc_sunat[0]['Junio']);
        $sheet->setCellValue("H9", $get_doc_sunat[0]['Julio']);
        $sheet->setCellValue("I9", $get_doc_sunat[0]['Agosto']);
        $sheet->setCellValue("J9", $get_doc_sunat[0]['Septiembre']);
        $sheet->setCellValue("K9", $get_doc_sunat[0]['Octubre']);
        $sheet->setCellValue("L9", $get_doc_sunat[0]['Noviembre']);
        $sheet->setCellValue("M9", $get_doc_sunat[0]['Diciembre']);
        $sheet->setCellValue("N9", $get_doc_sunat[0]['Total']);

        $sheet->setCellValue("A10", 'Notas Credito');
        $sheet->setCellValue("B10", $get_nota_credito[0]['Enero']);
        $sheet->setCellValue("C10", $get_nota_credito[0]['Febrero']);
        $sheet->setCellValue("D10", $get_nota_credito[0]['Marzo']);
        $sheet->setCellValue("E10", $get_nota_credito[0]['Abril']);
        $sheet->setCellValue("F10", $get_nota_credito[0]['Mayo']);
        $sheet->setCellValue("G10", $get_nota_credito[0]['Junio']);
        $sheet->setCellValue("H10", $get_nota_credito[0]['Julio']);
        $sheet->setCellValue("I10", $get_nota_credito[0]['Agosto']);
        $sheet->setCellValue("J10", $get_nota_credito[0]['Septiembre']);
        $sheet->setCellValue("K10", $get_nota_credito[0]['Octubre']);
        $sheet->setCellValue("L10", $get_nota_credito[0]['Noviembre']);
        $sheet->setCellValue("M10", $get_nota_credito[0]['Diciembre']);
        $sheet->setCellValue("N10", $get_nota_credito[0]['Total']);

        $sheet->mergeCells('A11:A12');
        $sheet->getStyle('A11')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A11")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A11")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A11")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FF0000');

        $spreadsheet->getActiveSheet()->getStyle("B11:M12")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFE1E2');

        $spreadsheet->getActiveSheet()->getStyle("N11:N12")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF0000');

        $sheet->getStyle("A11:N12")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B11:N12")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B11:N12")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('N11:N12')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("B11:N11")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A11", 'GASTOS');
        $sheet->setCellValue("B11", $get_gasto[0]['Enero']);
        $sheet->setCellValue("C11", $get_gasto[0]['Febrero']);
        $sheet->setCellValue("D11", $get_gasto[0]['Marzo']);
        $sheet->setCellValue("E11", $get_gasto[0]['Abril']);
        $sheet->setCellValue("F11", $get_gasto[0]['Mayo']);
        $sheet->setCellValue("G11", $get_gasto[0]['Junio']);
        $sheet->setCellValue("H11", $get_gasto[0]['Julio']);
        $sheet->setCellValue("I11", $get_gasto[0]['Agosto']);
        $sheet->setCellValue("J11", $get_gasto[0]['Septiembre']);
        $sheet->setCellValue("K11", $get_gasto[0]['Octubre']);
        $sheet->setCellValue("L11", $get_gasto[0]['Noviembre']);
        $sheet->setCellValue("M11", $get_gasto[0]['Diciembre']);
        $sheet->setCellValue("N11", $get_gasto[0]['Total']);

        $sheet->setCellValue("B12", number_format($diferencia_gasto_enero,2)."%");
        $sheet->setCellValue("C12", number_format($diferencia_gasto_febrero,2)."%");
        $sheet->setCellValue("D12", number_format($diferencia_gasto_marzo,2)."%");
        $sheet->setCellValue("E12", number_format($diferencia_gasto_abril,2)."%");
        $sheet->setCellValue("F12", number_format($diferencia_gasto_mayo,2)."%");
        $sheet->setCellValue("G12", number_format($diferencia_gasto_junio,2)."%");
        $sheet->setCellValue("H12", number_format($diferencia_gasto_julio,2)."%");
        $sheet->setCellValue("I12", number_format($diferencia_gasto_agosto,2)."%");
        $sheet->setCellValue("J12", number_format($diferencia_gasto_septiembre,2)."%");
        $sheet->setCellValue("K12", number_format($diferencia_gasto_octubre,2)."%");
        $sheet->setCellValue("L12", number_format($diferencia_gasto_noviembre,2)."%");
        $sheet->setCellValue("M12", number_format($diferencia_gasto_diciembre,2)."%");
        $sheet->setCellValue("N12", number_format($diferencia_gasto_total,2)."%");

        $contador=12;

        foreach($list_gastos as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("B{$contador}:N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['Name']);
            $sheet->setCellValue("B{$contador}", $list['Enero']);
            $sheet->setCellValue("C{$contador}", $list['Febrero']);
            $sheet->setCellValue("D{$contador}", $list['Marzo']);
            $sheet->setCellValue("E{$contador}", $list['Abril']);
            $sheet->setCellValue("F{$contador}", $list['Mayo']);
            $sheet->setCellValue("G{$contador}", $list['Junio']);
            $sheet->setCellValue("H{$contador}", $list['Julio']);
            $sheet->setCellValue("I{$contador}", $list['Agosto']);
            $sheet->setCellValue("J{$contador}", $list['Septiembre']);
            $sheet->setCellValue("K{$contador}", $list['Octubre']);
            $sheet->setCellValue("L{$contador}", $list['Noviembre']);
            $sheet->setCellValue("M{$contador}", $list['Diciembre']);
            $sheet->setCellValue("N{$contador}", $list['Total']);
        }

        $contador1=$contador+1;
        $contador2=$contador+2;

        $sheet->mergeCells("A{$contador1}:A{$contador2}");
        $sheet->getStyle("A{$contador1}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador1}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador1}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador1}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('779ECB');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador1}:M{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('E3F2FD');

        $spreadsheet->getActiveSheet()->getStyle("N{$contador1}:N{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('779ECB');

        $sheet->getStyle("A{$contador1}:N{$contador2}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador1}:N{$contador2}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador1}:N{$contador2}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("N{$contador1}:N{$contador2}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("B{$contador1}:N{$contador1}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A{$contador1}", 'UTILIDAD (Before Tax)');
        $sheet->setCellValue("B{$contador1}", $before_enero);
        $sheet->setCellValue("C{$contador1}", $before_febrero);
        $sheet->setCellValue("D{$contador1}", $before_marzo);
        $sheet->setCellValue("E{$contador1}", $before_abril);
        $sheet->setCellValue("F{$contador1}", $before_mayo);
        $sheet->setCellValue("G{$contador1}", $before_junio);
        $sheet->setCellValue("H{$contador1}", $before_julio);
        $sheet->setCellValue("I{$contador1}", $before_agosto);
        $sheet->setCellValue("J{$contador1}", $before_septiembre);
        $sheet->setCellValue("K{$contador1}", $before_octubre);
        $sheet->setCellValue("L{$contador1}", $before_noviembre);
        $sheet->setCellValue("M{$contador1}", $before_diciembre);
        $sheet->setCellValue("N{$contador1}", $before_total);

        $sheet->setCellValue("B{$contador2}", number_format($diferencia_before_enero)."%");
        $sheet->setCellValue("C{$contador2}", number_format($diferencia_before_febrero)."%");
        $sheet->setCellValue("D{$contador2}", number_format($diferencia_before_marzo)."%");
        $sheet->setCellValue("E{$contador2}", number_format($diferencia_before_abril)."%");
        $sheet->setCellValue("F{$contador2}", number_format($diferencia_before_mayo)."%");
        $sheet->setCellValue("G{$contador2}", number_format($diferencia_before_junio)."%");
        $sheet->setCellValue("H{$contador2}", number_format($diferencia_before_julio)."%");
        $sheet->setCellValue("I{$contador2}", number_format($diferencia_before_agosto)."%");
        $sheet->setCellValue("J{$contador2}", number_format($diferencia_before_septiembre)."%");
        $sheet->setCellValue("K{$contador2}", number_format($diferencia_before_octubre)."%");
        $sheet->setCellValue("L{$contador2}", number_format($diferencia_before_noviembre)."%");
        $sheet->setCellValue("M{$contador2}", number_format($diferencia_before_diciembre)."%");
        $sheet->setCellValue("N{$contador2}", number_format($diferencia_before_total)."%");

        $contador3=$contador+3;
        $contador4=$contador+4;

        $sheet->mergeCells("A{$contador3}:A{$contador4}");
        $sheet->getStyle("A{$contador3}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador3}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador3}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador3}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('9B9B9B');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador3}:M{$contador4}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('CDCDCD');

        $spreadsheet->getActiveSheet()->getStyle("N{$contador3}:N{$contador4}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('9B9B9B');

        $sheet->getStyle("A{$contador3}:N{$contador4}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador3}:N{$contador4}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador3}:N{$contador4}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("N{$contador3}:N{$contador4}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("B{$contador3}:N{$contador3}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A{$contador3}", 'IMPUESTOS');
        $sheet->setCellValue("B{$contador3}", $get_impuesto[0]['Enero']);
        $sheet->setCellValue("C{$contador3}", $get_impuesto[0]['Febrero']);
        $sheet->setCellValue("D{$contador3}", $get_impuesto[0]['Marzo']);
        $sheet->setCellValue("E{$contador3}", $get_impuesto[0]['Abril']);
        $sheet->setCellValue("F{$contador3}", $get_impuesto[0]['Mayo']);
        $sheet->setCellValue("G{$contador3}", $get_impuesto[0]['Junio']);
        $sheet->setCellValue("H{$contador3}", $get_impuesto[0]['Julio']);
        $sheet->setCellValue("I{$contador3}", $get_impuesto[0]['Agosto']);
        $sheet->setCellValue("J{$contador3}", $get_impuesto[0]['Septiembre']);
        $sheet->setCellValue("K{$contador3}", $get_impuesto[0]['Octubre']);
        $sheet->setCellValue("L{$contador3}", $get_impuesto[0]['Noviembre']);
        $sheet->setCellValue("M{$contador3}", $get_impuesto[0]['Diciembre']);
        $sheet->setCellValue("N{$contador3}", $get_impuesto[0]['Total']);

        $sheet->setCellValue("B{$contador4}", number_format($diferencia_impuesto_enero,2)."%");
        $sheet->setCellValue("C{$contador4}", number_format($diferencia_impuesto_febrero,2)."%");
        $sheet->setCellValue("D{$contador4}", number_format($diferencia_impuesto_marzo,2)."%");
        $sheet->setCellValue("E{$contador4}", number_format($diferencia_impuesto_abril,2)."%");
        $sheet->setCellValue("F{$contador4}", number_format($diferencia_impuesto_mayo,2)."%");
        $sheet->setCellValue("G{$contador4}", number_format($diferencia_impuesto_junio,2)."%");
        $sheet->setCellValue("H{$contador4}", number_format($diferencia_impuesto_julio,2)."%");
        $sheet->setCellValue("I{$contador4}", number_format($diferencia_impuesto_agosto,2)."%");
        $sheet->setCellValue("J{$contador4}", number_format($diferencia_impuesto_septiembre,2)."%");
        $sheet->setCellValue("K{$contador4}", number_format($diferencia_impuesto_octubre,2)."%");
        $sheet->setCellValue("L{$contador4}", number_format($diferencia_impuesto_noviembre,2)."%");
        $sheet->setCellValue("M{$contador4}", number_format($diferencia_impuesto_diciembre,2)."%");
        $sheet->setCellValue("N{$contador4}", number_format($diferencia_impuesto_total,2)."%");

        $contador=$contador4;

        foreach($list_impuestos as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("B{$contador}:N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['Name']);
            $sheet->setCellValue("B{$contador}", $list['Enero']);
            $sheet->setCellValue("C{$contador}", $list['Febrero']);
            $sheet->setCellValue("D{$contador}", $list['Marzo']);
            $sheet->setCellValue("E{$contador}", $list['Abril']);
            $sheet->setCellValue("F{$contador}", $list['Mayo']);
            $sheet->setCellValue("G{$contador}", $list['Junio']);
            $sheet->setCellValue("H{$contador}", $list['Julio']);
            $sheet->setCellValue("I{$contador}", $list['Agosto']);
            $sheet->setCellValue("J{$contador}", $list['Septiembre']);
            $sheet->setCellValue("K{$contador}", $list['Octubre']);
            $sheet->setCellValue("L{$contador}", $list['Noviembre']);
            $sheet->setCellValue("M{$contador}", $list['Diciembre']);
            $sheet->setCellValue("N{$contador}", $list['Total']);
        }

        $contador1=$contador+1;
        $contador2=$contador+2;

        $sheet->mergeCells("A{$contador1}:A{$contador2}");
        $sheet->getStyle("A{$contador1}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador1}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador1}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador1}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('1976D2');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador1}:M{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('E1F5FE');

        $spreadsheet->getActiveSheet()->getStyle("N{$contador1}:N{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('1976D2');

        $sheet->getStyle("A{$contador1}:N{$contador2}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador1}:N{$contador2}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador1}:N{$contador2}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("N{$contador1}:N{$contador2}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("B{$contador1}:N{$contador1}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A{$contador1}", 'UTILIDAD (After Tax)');
        $sheet->setCellValue("B{$contador1}", $after_enero);
        $sheet->setCellValue("C{$contador1}", $after_febrero);
        $sheet->setCellValue("D{$contador1}", $after_marzo);
        $sheet->setCellValue("E{$contador1}", $after_abril);
        $sheet->setCellValue("F{$contador1}", $after_mayo);
        $sheet->setCellValue("G{$contador1}", $after_junio);
        $sheet->setCellValue("H{$contador1}", $after_julio);
        $sheet->setCellValue("I{$contador1}", $after_agosto);
        $sheet->setCellValue("J{$contador1}", $after_septiembre);
        $sheet->setCellValue("K{$contador1}", $after_octubre);
        $sheet->setCellValue("L{$contador1}", $after_noviembre);
        $sheet->setCellValue("M{$contador1}", $after_diciembre);
        $sheet->setCellValue("N{$contador1}", $after_total);

        $sheet->setCellValue("B{$contador2}", number_format($diferencia_after_enero,2)."%");
        $sheet->setCellValue("C{$contador2}", number_format($diferencia_after_febrero,2)."%");
        $sheet->setCellValue("D{$contador2}", number_format($diferencia_after_marzo,2)."%");
        $sheet->setCellValue("E{$contador2}", number_format($diferencia_after_abril,2)."%");
        $sheet->setCellValue("F{$contador2}", number_format($diferencia_after_mayo,2)."%");
        $sheet->setCellValue("G{$contador2}", number_format($diferencia_after_junio,2)."%");
        $sheet->setCellValue("H{$contador2}", number_format($diferencia_after_julio,2)."%");
        $sheet->setCellValue("I{$contador2}", number_format($diferencia_after_agosto,2)."%");
        $sheet->setCellValue("J{$contador2}", number_format($diferencia_after_septiembre,2)."%");
        $sheet->setCellValue("K{$contador2}", number_format($diferencia_after_octubre,2)."%");
        $sheet->setCellValue("L{$contador2}", number_format($diferencia_after_noviembre,2)."%");
        $sheet->setCellValue("M{$contador2}", number_format($diferencia_after_diciembre,2)."%");
        $sheet->setCellValue("N{$contador2}", number_format($diferencia_after_total,2)."%");

        $contador3=$contador+3;
        $contador4=$contador+4;
        $contador5=$contador+5;
        $contador6=$contador+6;

        $sheet->getStyle("A{$contador3}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador3}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador3}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador3}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FF8000');

        $sheet->getStyle("B{$contador3}:N{$contador3}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador3}:N{$contador3}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $spreadsheet->getActiveSheet()->getStyle("B{$contador3}:N{$contador3}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFE0B2');

        $spreadsheet->getActiveSheet()->getStyle("N{$contador3}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF8000');

        $sheet->getStyle("N{$contador3}:N{$contador3}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("A{$contador3}:N{$contador6}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("A{$contador4}:N{$contador6}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$contador4}:N{$contador6}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("B{$contador3}:N{$contador6}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A{$contador3}", 'CAPITAL');
        $sheet->setCellValue("B{$contador3}", $capital_enero);
        $sheet->setCellValue("C{$contador3}", $capital_febrero);
        $sheet->setCellValue("D{$contador3}", $capital_marzo);
        $sheet->setCellValue("E{$contador3}", $capital_abril);
        $sheet->setCellValue("F{$contador3}", $capital_mayo);
        $sheet->setCellValue("G{$contador3}", $capital_junio);
        $sheet->setCellValue("H{$contador3}", $capital_julio);
        $sheet->setCellValue("I{$contador3}", $capital_agosto);
        $sheet->setCellValue("J{$contador3}", $capital_septiembre);
        $sheet->setCellValue("K{$contador3}", $capital_octubre);
        $sheet->setCellValue("L{$contador3}", $capital_noviembre);
        $sheet->setCellValue("M{$contador3}", $capital_diciembre);
        $sheet->setCellValue("N{$contador3}", $capital_total);

        $sheet->setCellValue("A{$contador4}", 'Aumento');
        $sheet->setCellValue("B{$contador4}", "S/".number_format($get_aumento[0]['Enero'],2));
        $sheet->setCellValue("C{$contador4}", "S/".number_format($get_aumento[0]['Febrero'],2));
        $sheet->setCellValue("D{$contador4}", "S/".number_format($get_aumento[0]['Marzo'],2));
        $sheet->setCellValue("E{$contador4}", "S/".number_format($get_aumento[0]['Abril'],2));
        $sheet->setCellValue("F{$contador4}", "S/".number_format($get_aumento[0]['Mayo'],2));
        $sheet->setCellValue("G{$contador4}", "S/".number_format($get_aumento[0]['Junio'],2));
        $sheet->setCellValue("H{$contador4}", "S/".number_format($get_aumento[0]['Julio'],2));
        $sheet->setCellValue("I{$contador4}", "S/".number_format($get_aumento[0]['Agosto'],2));
        $sheet->setCellValue("J{$contador4}", "S/".number_format($get_aumento[0]['Septiembre'],2));
        $sheet->setCellValue("K{$contador4}", "S/".number_format($get_aumento[0]['Octubre'],2));
        $sheet->setCellValue("L{$contador4}", "S/".number_format($get_aumento[0]['Noviembre'],2));
        $sheet->setCellValue("M{$contador4}", "S/".number_format($get_aumento[0]['Diciembre'],2));
        $sheet->setCellValue("N{$contador4}", "S/".number_format($get_aumento[0]['Total'],2));

        $sheet->setCellValue("A{$contador5}", 'Salida');
        $sheet->setCellValue("B{$contador5}", "S/".number_format($get_salida[0]['Enero'],2));
        $sheet->setCellValue("C{$contador5}", "S/".number_format($get_salida[0]['Febrero'],2));
        $sheet->setCellValue("D{$contador5}", "S/".number_format($get_salida[0]['Marzo'],2));
        $sheet->setCellValue("E{$contador5}", "S/".number_format($get_salida[0]['Abril'],2));
        $sheet->setCellValue("F{$contador5}", "S/".number_format($get_salida[0]['Mayo'],2));
        $sheet->setCellValue("G{$contador5}", "S/".number_format($get_salida[0]['Junio'],2));
        $sheet->setCellValue("H{$contador5}", "S/".number_format($get_salida[0]['Julio'],2));
        $sheet->setCellValue("I{$contador5}", "S/".number_format($get_salida[0]['Agosto'],2));
        $sheet->setCellValue("J{$contador5}", "S/".number_format($get_salida[0]['Septiembre'],2));
        $sheet->setCellValue("K{$contador5}", "S/".number_format($get_salida[0]['Octubre'],2));
        $sheet->setCellValue("L{$contador5}", "S/".number_format($get_salida[0]['Noviembre'],2));
        $sheet->setCellValue("M{$contador5}", "S/".number_format($get_salida[0]['Diciembre'],2));
        $sheet->setCellValue("N{$contador5}", "S/".number_format($get_salida[0]['Total'],2));

        $sheet->setCellValue("A{$contador6}", 'Gastos Personales');
        $sheet->setCellValue("B{$contador6}", "S/".number_format($get_gasto_personal[0]['Enero'],2));
        $sheet->setCellValue("C{$contador6}", "S/".number_format($get_gasto_personal[0]['Febrero'],2));
        $sheet->setCellValue("D{$contador6}", "S/".number_format($get_gasto_personal[0]['Marzo'],2));
        $sheet->setCellValue("E{$contador6}", "S/".number_format($get_gasto_personal[0]['Abril'],2));
        $sheet->setCellValue("F{$contador6}", "S/".number_format($get_gasto_personal[0]['Mayo'],2));
        $sheet->setCellValue("G{$contador6}", "S/".number_format($get_gasto_personal[0]['Junio'],2));
        $sheet->setCellValue("H{$contador6}", "S/".number_format($get_gasto_personal[0]['Julio'],2));
        $sheet->setCellValue("I{$contador6}", "S/".number_format($get_gasto_personal[0]['Agosto'],2));
        $sheet->setCellValue("J{$contador6}", "S/".number_format($get_gasto_personal[0]['Septiembre'],2));
        $sheet->setCellValue("K{$contador6}", "S/".number_format($get_gasto_personal[0]['Octubre'],2));
        $sheet->setCellValue("L{$contador6}", "S/".number_format($get_gasto_personal[0]['Noviembre'],2));
        $sheet->setCellValue("M{$contador6}", "S/".number_format($get_gasto_personal[0]['Diciembre'],2));
        $sheet->setCellValue("N{$contador6}", "S/".number_format($get_gasto_personal[0]['Total'],2));

        $contador7=$contador+7;
        $contador8=$contador+8;
        $contador9=$contador+9;
        $contador10=$contador+10;

        $sheet->getStyle("A{$contador7}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador7}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador7}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador7}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('4A148C');

        $sheet->getStyle("B{$contador7}:N{$contador7}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador7}:N{$contador7}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $spreadsheet->getActiveSheet()->getStyle("B{$contador7}:N{$contador7}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('F3E5F5');

        $spreadsheet->getActiveSheet()->getStyle("N{$contador7}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('4A148C');

        $sheet->getStyle("N{$contador7}:N{$contador7}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getStyle("A{$contador7}:N{$contador10}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("A{$contador8}:N{$contador10}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$contador8}:N{$contador10}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("B{$contador7}:N{$contador8}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        $sheet->getStyle("C{$contador9}:N{$contador10}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $sheet->setCellValue("A{$contador7}", 'Cuentas por Cobrar');
        $sheet->setCellValue("B{$contador7}", $get_cuentas_por_cobrar[0]['Enero']);
        $sheet->setCellValue("C{$contador7}", $get_cuentas_por_cobrar[0]['Febrero']);
        $sheet->setCellValue("D{$contador7}", $get_cuentas_por_cobrar[0]['Marzo']);
        $sheet->setCellValue("E{$contador7}", $get_cuentas_por_cobrar[0]['Abril']);
        $sheet->setCellValue("F{$contador7}", $get_cuentas_por_cobrar[0]['Mayo']);
        $sheet->setCellValue("G{$contador7}", $get_cuentas_por_cobrar[0]['Junio']);
        $sheet->setCellValue("H{$contador7}", $get_cuentas_por_cobrar[0]['Julio']);
        $sheet->setCellValue("I{$contador7}", $get_cuentas_por_cobrar[0]['Agosto']);
        $sheet->setCellValue("J{$contador7}", $get_cuentas_por_cobrar[0]['Septiembre']);
        $sheet->setCellValue("K{$contador7}", $get_cuentas_por_cobrar[0]['Octubre']);
        $sheet->setCellValue("L{$contador7}", $get_cuentas_por_cobrar[0]['Noviembre']);
        $sheet->setCellValue("M{$contador7}", $get_cuentas_por_cobrar[0]['Diciembre']);
        $sheet->setCellValue("N{$contador7}", $get_cuentas_por_cobrar[0]['Total']);

        $sheet->setCellValue("A{$contador8}", 'Mes');
        $sheet->setCellValue("B{$contador8}", $get_cuentas_por_cobrar[0]['Enero']);
        $sheet->setCellValue("C{$contador8}", $get_cuentas_por_cobrar[0]['Febrero']);
        $sheet->setCellValue("D{$contador8}", $get_cuentas_por_cobrar[0]['Marzo']);
        $sheet->setCellValue("E{$contador8}", $get_cuentas_por_cobrar[0]['Abril']);
        $sheet->setCellValue("F{$contador8}", $get_cuentas_por_cobrar[0]['Mayo']);
        $sheet->setCellValue("G{$contador8}", $get_cuentas_por_cobrar[0]['Junio']);
        $sheet->setCellValue("H{$contador8}", $get_cuentas_por_cobrar[0]['Julio']);
        $sheet->setCellValue("I{$contador8}", $get_cuentas_por_cobrar[0]['Agosto']);
        $sheet->setCellValue("J{$contador8}", $get_cuentas_por_cobrar[0]['Septiembre']);
        $sheet->setCellValue("K{$contador8}", $get_cuentas_por_cobrar[0]['Octubre']);
        $sheet->setCellValue("L{$contador8}", $get_cuentas_por_cobrar[0]['Noviembre']);
        $sheet->setCellValue("M{$contador8}", $get_cuentas_por_cobrar[0]['Diciembre']);
        $sheet->setCellValue("N{$contador8}", $get_cuentas_por_cobrar[0]['Total']);

        $sheet->setCellValue("A{$contador9}", 'Pendientes');
        $sheet->setCellValue("C{$contador9}", $pendiente_febrero);
        $sheet->setCellValue("D{$contador9}", $pendiente_marzo);
        $sheet->setCellValue("E{$contador9}", $pendiente_abril);
        $sheet->setCellValue("F{$contador9}", $pendiente_mayo);
        $sheet->setCellValue("G{$contador9}", $pendiente_junio);
        $sheet->setCellValue("H{$contador9}", $pendiente_julio);
        $sheet->setCellValue("I{$contador9}", $pendiente_agosto);
        $sheet->setCellValue("J{$contador9}", $pendiente_septiembre);
        $sheet->setCellValue("K{$contador9}", $pendiente_octubre);
        $sheet->setCellValue("L{$contador9}", $pendiente_noviembre);
        $sheet->setCellValue("M{$contador9}", $pendiente_diciembre);
        $sheet->setCellValue("N{$contador9}", $get_cuentas_por_cobrar[0]['Total']);

        $sheet->setCellValue("A{$contador10}", 'Acumulado');
        $sheet->setCellValue("C{$contador10}", $acumulado_febrero);
        $sheet->setCellValue("D{$contador10}", $acumulado_marzo);
        $sheet->setCellValue("E{$contador10}", $acumulado_abril);
        $sheet->setCellValue("F{$contador10}", $acumulado_mayo);
        $sheet->setCellValue("G{$contador10}", $acumulado_junio);
        $sheet->setCellValue("H{$contador10}", $acumulado_julio);
        $sheet->setCellValue("I{$contador10}", $acumulado_agosto);
        $sheet->setCellValue("J{$contador10}", $acumulado_septiembre);
        $sheet->setCellValue("K{$contador10}", $acumulado_octubre);
        $sheet->setCellValue("L{$contador10}", $acumulado_noviembre);
        $sheet->setCellValue("M{$contador10}", $acumulado_diciembre);
        $sheet->setCellValue("N{$contador10}", $get_acumulado[0]['Total']);

        //Poner letra a tamaño 9
        $spreadsheet->getActiveSheet()->getStyle("A1:N{$contador10}")->getFont()->setSize(9);
        //Ajustar ancho de columna
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        //Dar ancho específico
        //$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(120, 'px');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Real '.$empresa.' (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------BALANCE OFICIAL------------------------------------------
    public function Balance_Oficial(){
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('administrador/balance_oficial/index', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Cambiar_Superior_Balance_Oficial(){
        if ($this->session->userdata('usuario')) { 
            $dato['empresa'] = $this->input->post("empresa");
            $dato['anio'] = $this->input->post("anio");
            $dato['anio_antiguo'] = $dato['anio']-1;

            $get_id = $this->Admin_model->get_id_cod_empresa($dato['empresa']);
            $array = explode("-",$get_id[0]['fecha_inicio']);

            $dato['list_empresas'] = $this->Admin_model->get_list_empresa_balance();
            $dato['list_anio'] = $this->Admin_model->get_list_anio_balance($array[0]);

            $array_ingreso="";
            $array_gasto="";
            $array_utilidad="";
            $array_diferencia="";

            foreach($dato['list_empresas'] as $list){
                $get_boleta = $this->Admin_model->total_boletas_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);
                $get_cuentas_por_cobrar = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);
                $get_factura = $this->Admin_model->total_facturas_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);
                $get_nota_debito = $this->Admin_model->total_notas_debito_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);
                $get_nota_credito = $this->Admin_model->total_notas_credito_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']);

                $get_gasto = $this->Admin_model->total_gastos_balance_oficial($list['cod_empresa'],$dato['anio_antiguo']); 

                $ingreso_antiguo = $get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total'];
                $gasto_antiguo = $get_gasto[0]['Total'];
                $utilidad_antiguo = $ingreso_antiguo-$gasto_antiguo;

                $get_boleta = $this->Admin_model->total_boletas_balance_oficial($list['cod_empresa'],$dato['anio']);
                $get_cuentas_por_cobrar = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($list['cod_empresa'],$dato['anio']);
                $get_factura = $this->Admin_model->total_facturas_balance_oficial($list['cod_empresa'],$dato['anio']);
                $get_nota_debito = $this->Admin_model->total_notas_debito_balance_oficial($list['cod_empresa'],$dato['anio']);
                $get_nota_credito = $this->Admin_model->total_notas_credito_balance_oficial($list['cod_empresa'],$dato['anio']);

                $get_gasto = $this->Admin_model->total_gastos_balance_oficial($list['cod_empresa'],$dato['anio']); 

                $ingreso = $get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total'];
                $gasto = $get_gasto[0]['Total'];
                $utilidad = $ingreso-$gasto;

                if($utilidad_antiguo==0){
                    $diferencia = 0;
                }else{
                    $diferencia = (($utilidad-$utilidad_antiguo)/$utilidad_antiguo)*100;
                }
                
                $array_ingreso=$array_ingreso.$ingreso."_";
                $array_gasto=$array_gasto.$gasto."_";
                $array_utilidad=$array_utilidad.$utilidad."_";
                $array_diferencia=$array_diferencia.$diferencia."_";
            }

            $dato['ingreso']=substr($array_ingreso,0,-1);
            $dato['gasto']=substr($array_gasto,0,-1);
            $dato['utilidad']=substr($array_utilidad,0,-1);
            $dato['diferencia']=substr($array_diferencia,0,-1);

            $this->load->view('administrador/balance_oficial/superior',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Cambiar_Balance_Oficial(){
        if ($this->session->userdata('usuario')) { 
            $dato['empresa'] = $this->input->post("empresa");
            $dato['anio'] = $this->input->post("anio");
            $dato['get_boleta'] = $this->Admin_model->total_boletas_balance_oficial($dato['empresa'],$dato['anio']);
			$dato['get_cuentas_por_cobrar'] = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($dato['empresa'],$dato['anio']);
			$dato['get_factura'] = $this->Admin_model->total_facturas_balance_oficial($dato['empresa'],$dato['anio']);
			$dato['get_nota_debito'] = $this->Admin_model->total_notas_debito_balance_oficial($dato['empresa'],$dato['anio']);
			$dato['get_nota_credito'] = $this->Admin_model->total_notas_credito_balance_oficial($dato['empresa'],$dato['anio']);
			
			$dato['list_gastos'] = $this->Admin_model->get_list_gastos_balance_oficial($dato['empresa'],$dato['anio']);
			$dato['get_gasto'] = $this->Admin_model->total_gastos_balance_oficial($dato['empresa'],$dato['anio']);
			
			$dato['get_impuesto'] = $this->Admin_model->total_impuestos_balance_oficial($dato['empresa'],$dato['anio']);

            //-----ANTIGUO-----
            $dato['anio_antiguo']=$dato['anio']-1;

            $dato['get_boleta_ant'] = $this->Admin_model->total_boletas_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			$dato['get_cuentas_por_cobrar_ant'] = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			$dato['get_factura_ant'] = $this->Admin_model->total_facturas_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			$dato['get_nota_debito_ant'] = $this->Admin_model->total_notas_debito_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			$dato['get_nota_credito_ant'] = $this->Admin_model->total_notas_credito_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			
			$dato['get_gasto_ant'] = $this->Admin_model->total_gastos_balance_oficial($dato['empresa'],$dato['anio_antiguo']);
			
			$dato['get_impuesto_ant'] = $this->Admin_model->total_impuestos_balance_oficial($dato['empresa'],$dato['anio_antiguo']);

            $this->load->view('administrador/balance_oficial/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Balance_Oficial($empresa,$anio){
        $get_boleta = $this->Admin_model->total_boletas_balance_oficial($empresa,$anio);
        $get_cuentas_por_cobrar = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($empresa,$anio);
        $get_factura = $this->Admin_model->total_facturas_balance_oficial($empresa,$anio);
        $get_nota_debito = $this->Admin_model->total_notas_debito_balance_oficial($empresa,$anio);
        $get_nota_credito = $this->Admin_model->total_notas_credito_balance_oficial($empresa,$anio);
        
        $list_gastos = $this->Admin_model->get_list_gastos_balance_oficial($empresa,$anio);
        $get_gasto = $this->Admin_model->total_gastos_balance_oficial($empresa,$anio);
        
        $get_impuesto = $this->Admin_model->total_impuestos_balance_oficial($empresa,$anio);

        $anio_antiguo=$anio-1;

        $get_boleta_ant = $this->Admin_model->total_boletas_balance_oficial($empresa,$anio_antiguo);
        $get_cuentas_por_cobrar_ant = $this->Admin_model->total_cuentas_por_cobrar_balance_oficial($empresa,$anio_antiguo);
        $get_factura_ant = $this->Admin_model->total_facturas_balance_oficial($empresa,$anio_antiguo);
        $get_nota_debito_ant = $this->Admin_model->total_notas_debito_balance_oficial($empresa,$anio_antiguo);
        $get_nota_credito_ant = $this->Admin_model->total_notas_credito_balance_oficial($empresa,$anio_antiguo);
        
        $get_gasto_ant = $this->Admin_model->total_gastos_balance_oficial($empresa,$anio_antiguo);
        
        $get_impuesto_ant = $this->Admin_model->total_impuestos_balance_oficial($empresa,$anio_antiguo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Balance Oficial');

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
        $sheet->getColumnDimension('N')->setWidth(15);

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

        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

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

        //---------------------------------------------------------------CONTENIDO--------------------------------------------------------
        /*ANTIGUO*/
        $ingreso_enero_ant=$get_boleta_ant[0]['Enero']+$get_cuentas_por_cobrar_ant[0]['Enero']+$get_factura_ant[0]['Enero']+$get_nota_debito_ant[0]['Enero']-$get_nota_credito_ant[0]['Enero'];
        $ingreso_febrero_ant=$get_boleta_ant[0]['Febrero']+$get_cuentas_por_cobrar_ant[0]['Febrero']+$get_factura_ant[0]['Febrero']+$get_nota_debito_ant[0]['Febrero']-$get_nota_credito_ant[0]['Febrero'];
        $ingreso_marzo_ant=$get_boleta_ant[0]['Marzo']+$get_cuentas_por_cobrar_ant[0]['Marzo']+$get_factura_ant[0]['Marzo']+$get_nota_debito_ant[0]['Marzo']-$get_nota_credito_ant[0]['Marzo'];
        $ingreso_abril_ant=$get_boleta_ant[0]['Abril']+$get_cuentas_por_cobrar_ant[0]['Abril']+$get_factura_ant[0]['Abril']+$get_nota_debito_ant[0]['Abril']-$get_nota_credito_ant[0]['Abril'];
        $ingreso_mayo_ant=$get_boleta_ant[0]['Mayo']+$get_cuentas_por_cobrar_ant[0]['Mayo']+$get_factura_ant[0]['Mayo']+$get_nota_debito_ant[0]['Mayo']-$get_nota_credito_ant[0]['Mayo'];
        $ingreso_junio_ant=$get_boleta_ant[0]['Junio']+$get_cuentas_por_cobrar_ant[0]['Junio']+$get_factura_ant[0]['Junio']+$get_nota_debito_ant[0]['Junio']-$get_nota_credito_ant[0]['Junio'];
        $ingreso_julio_ant=$get_boleta_ant[0]['Julio']+$get_cuentas_por_cobrar_ant[0]['Julio']+$get_factura_ant[0]['Julio']+$get_nota_debito_ant[0]['Julio']-$get_nota_credito_ant[0]['Julio'];
        $ingreso_agosto_ant=$get_boleta_ant[0]['Agosto']+$get_cuentas_por_cobrar_ant[0]['Agosto']+$get_factura_ant[0]['Agosto']+$get_nota_debito_ant[0]['Agosto']-$get_nota_credito_ant[0]['Agosto'];
        $ingreso_septiembre_ant=$get_boleta_ant[0]['Septiembre']+$get_cuentas_por_cobrar_ant[0]['Septiembre']+$get_factura_ant[0]['Septiembre']+$get_nota_debito_ant[0]['Septiembre']-$get_nota_credito_ant[0]['Septiembre'];
        $ingreso_octubre_ant=$get_boleta_ant[0]['Octubre']+$get_cuentas_por_cobrar_ant[0]['Octubre']+$get_factura_ant[0]['Octubre']+$get_nota_debito_ant[0]['Octubre']-$get_nota_credito_ant[0]['Octubre'];
        $ingreso_noviembre_ant=$get_boleta_ant[0]['Noviembre']+$get_cuentas_por_cobrar_ant[0]['Noviembre']+$get_factura_ant[0]['Noviembre']+$get_nota_debito_ant[0]['Noviembre']-$get_nota_credito_ant[0]['Noviembre'];
        $ingreso_diciembre_ant=$get_boleta_ant[0]['Diciembre']+$get_cuentas_por_cobrar_ant[0]['Diciembre']+$get_factura_ant[0]['Diciembre']+$get_nota_debito_ant[0]['Diciembre']-$get_nota_credito_ant[0]['Diciembre'];
        $ingreso_total_ant=$get_boleta_ant[0]['Total']+$get_cuentas_por_cobrar_ant[0]['Total']+$get_factura_ant[0]['Total']+$get_nota_debito_ant[0]['Total']-$get_nota_credito_ant[0]['Total'];

        $before_enero_ant=$ingreso_enero_ant-$get_gasto_ant[0]['Enero'];
        $before_febrero_ant=$ingreso_febrero_ant-$get_gasto_ant[0]['Febrero'];
        $before_marzo_ant=$ingreso_marzo_ant-$get_gasto_ant[0]['Marzo'];
        $before_abril_ant=$ingreso_abril_ant-$get_gasto_ant[0]['Abril'];
        $before_mayo_ant=$ingreso_mayo_ant-$get_gasto_ant[0]['Mayo'];
        $before_junio_ant=$ingreso_junio_ant-$get_gasto_ant[0]['Junio'];
        $before_julio_ant=$ingreso_julio_ant-$get_gasto_ant[0]['Julio'];
        $before_agosto_ant=$ingreso_agosto_ant-$get_gasto_ant[0]['Agosto'];
        $before_septiembre_ant=$ingreso_septiembre_ant-$get_gasto_ant[0]['Septiembre'];
        $before_octubre_ant=$ingreso_octubre_ant-$get_gasto_ant[0]['Octubre'];
        $before_noviembre_ant=$ingreso_noviembre_ant-$get_gasto_ant[0]['Noviembre'];
        $before_diciembre_ant=$ingreso_diciembre_ant-$get_gasto_ant[0]['Diciembre'];
        $before_total_ant=$ingreso_total_ant-$get_gasto_ant[0]['Total'];

        $after_enero_ant=$before_enero_ant-$get_impuesto_ant[0]['Enero'];
        $after_febrero_ant=$before_febrero_ant-$get_impuesto_ant[0]['Febrero'];
        $after_marzo_ant=$before_marzo_ant-$get_impuesto_ant[0]['Marzo'];
        $after_abril_ant=$before_abril_ant-$get_impuesto_ant[0]['Abril'];
        $after_mayo_ant=$before_mayo_ant-$get_impuesto_ant[0]['Mayo'];
        $after_junio_ant=$before_junio_ant-$get_impuesto_ant[0]['Junio'];
        $after_julio_ant=$before_julio_ant-$get_impuesto_ant[0]['Julio'];
        $after_agosto_ant=$before_agosto_ant-$get_impuesto_ant[0]['Agosto'];
        $after_septiembre_ant=$before_septiembre_ant-$get_impuesto_ant[0]['Septiembre'];
        $after_octubre_ant=$before_octubre_ant-$get_impuesto_ant[0]['Octubre'];
        $after_noviembre_ant=$before_noviembre_ant-$get_impuesto_ant[0]['Noviembre'];
        $after_diciembre_ant=$before_diciembre_ant-$get_impuesto_ant[0]['Diciembre'];
        $after_total_ant=$before_total_ant-$get_impuesto_ant[0]['Total'];

        /*ACTUAL*/
        /*INGRESOS*/
        $ingreso_enero=$get_boleta[0]['Enero']+$get_cuentas_por_cobrar[0]['Enero']+$get_factura[0]['Enero']+$get_nota_debito[0]['Enero']-$get_nota_credito[0]['Enero'];
        $ingreso_febrero=$get_boleta[0]['Febrero']+$get_cuentas_por_cobrar[0]['Febrero']+$get_factura[0]['Febrero']+$get_nota_debito[0]['Febrero']-$get_nota_credito[0]['Febrero'];
        $ingreso_marzo=$get_boleta[0]['Marzo']+$get_cuentas_por_cobrar[0]['Marzo']+$get_factura[0]['Marzo']+$get_nota_debito[0]['Marzo']-$get_nota_credito[0]['Marzo'];
        $ingreso_abril=$get_boleta[0]['Abril']+$get_cuentas_por_cobrar[0]['Abril']+$get_factura[0]['Abril']+$get_nota_debito[0]['Abril']-$get_nota_credito[0]['Abril'];
        $ingreso_mayo=$get_boleta[0]['Mayo']+$get_cuentas_por_cobrar[0]['Mayo']+$get_factura[0]['Mayo']+$get_nota_debito[0]['Mayo']-$get_nota_credito[0]['Mayo'];
        $ingreso_junio=$get_boleta[0]['Junio']+$get_cuentas_por_cobrar[0]['Junio']+$get_factura[0]['Junio']+$get_nota_debito[0]['Junio']-$get_nota_credito[0]['Junio'];
        $ingreso_julio=$get_boleta[0]['Julio']+$get_cuentas_por_cobrar[0]['Julio']+$get_factura[0]['Julio']+$get_nota_debito[0]['Julio']-$get_nota_credito[0]['Julio'];
        $ingreso_agosto=$get_boleta[0]['Agosto']+$get_cuentas_por_cobrar[0]['Agosto']+$get_factura[0]['Agosto']+$get_nota_debito[0]['Agosto']-$get_nota_credito[0]['Agosto'];
        $ingreso_septiembre=$get_boleta[0]['Septiembre']+$get_cuentas_por_cobrar[0]['Septiembre']+$get_factura[0]['Septiembre']+$get_nota_debito[0]['Septiembre']-$get_nota_credito[0]['Septiembre'];
        $ingreso_octubre=$get_boleta[0]['Octubre']+$get_cuentas_por_cobrar[0]['Octubre']+$get_factura[0]['Octubre']+$get_nota_debito[0]['Octubre']-$get_nota_credito[0]['Octubre'];
        $ingreso_noviembre=$get_boleta[0]['Noviembre']+$get_cuentas_por_cobrar[0]['Noviembre']+$get_factura[0]['Noviembre']+$get_nota_debito[0]['Noviembre']-$get_nota_credito[0]['Noviembre'];
        $ingreso_diciembre=$get_boleta[0]['Diciembre']+$get_cuentas_por_cobrar[0]['Diciembre']+$get_factura[0]['Diciembre']+$get_nota_debito[0]['Diciembre']-$get_nota_credito[0]['Diciembre'];
        $ingreso_total=$get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total'];

        /*UTILIDAD(BEFORE TAX)*/
        $before_enero=$get_boleta[0]['Enero']+$get_cuentas_por_cobrar[0]['Enero']+$get_factura[0]['Enero']+$get_nota_debito[0]['Enero']-$get_nota_credito[0]['Enero']-$get_gasto[0]['Enero'];
        $before_febrero=$get_boleta[0]['Febrero']+$get_cuentas_por_cobrar[0]['Febrero']+$get_factura[0]['Febrero']+$get_nota_debito[0]['Febrero']-$get_nota_credito[0]['Febrero']-$get_gasto[0]['Febrero'];
        $before_marzo=$get_boleta[0]['Marzo']+$get_cuentas_por_cobrar[0]['Marzo']+$get_factura[0]['Marzo']+$get_nota_debito[0]['Marzo']-$get_nota_credito[0]['Marzo']-$get_gasto[0]['Marzo'];
        $before_abril=$get_boleta[0]['Abril']+$get_cuentas_por_cobrar[0]['Abril']+$get_factura[0]['Abril']+$get_nota_debito[0]['Abril']-$get_nota_credito[0]['Abril']-$get_gasto[0]['Abril'];
        $before_mayo=$get_boleta[0]['Mayo']+$get_cuentas_por_cobrar[0]['Mayo']+$get_factura[0]['Mayo']+$get_nota_debito[0]['Mayo']-$get_nota_credito[0]['Mayo']-$get_gasto[0]['Mayo'];
        $before_junio=$get_boleta[0]['Junio']+$get_cuentas_por_cobrar[0]['Junio']+$get_factura[0]['Junio']+$get_nota_debito[0]['Junio']-$get_nota_credito[0]['Junio']-$get_gasto[0]['Junio'];
        $before_julio=$get_boleta[0]['Julio']+$get_cuentas_por_cobrar[0]['Julio']+$get_factura[0]['Julio']+$get_nota_debito[0]['Julio']-$get_nota_credito[0]['Julio']-$get_gasto[0]['Julio'];
        $before_agosto=$get_boleta[0]['Agosto']+$get_cuentas_por_cobrar[0]['Agosto']+$get_factura[0]['Agosto']+$get_nota_debito[0]['Agosto']-$get_nota_credito[0]['Agosto']-$get_gasto[0]['Agosto'];
        $before_septiembre=$get_boleta[0]['Septiembre']+$get_cuentas_por_cobrar[0]['Septiembre']+$get_factura[0]['Septiembre']+$get_nota_debito[0]['Septiembre']-$get_nota_credito[0]['Septiembre']-$get_gasto[0]['Septiembre'];
        $before_octubre=$get_boleta[0]['Octubre']+$get_cuentas_por_cobrar[0]['Octubre']+$get_factura[0]['Octubre']+$get_nota_debito[0]['Octubre']-$get_nota_credito[0]['Octubre']-$get_gasto[0]['Octubre'];
        $before_noviembre=$get_boleta[0]['Noviembre']+$get_cuentas_por_cobrar[0]['Noviembre']+$get_factura[0]['Noviembre']+$get_nota_debito[0]['Noviembre']-$get_nota_credito[0]['Noviembre']-$get_gasto[0]['Noviembre'];
        $before_diciembre=$get_boleta[0]['Diciembre']+$get_cuentas_por_cobrar[0]['Diciembre']+$get_factura[0]['Diciembre']+$get_nota_debito[0]['Diciembre']-$get_nota_credito[0]['Diciembre']-$get_gasto[0]['Diciembre'];
        $before_total=$get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total']-$get_gasto[0]['Total'];

        /*UTILIDAD(AFTER TAX)*/
        $after_enero=$get_boleta[0]['Enero']+$get_cuentas_por_cobrar[0]['Enero']+$get_factura[0]['Enero']+$get_nota_debito[0]['Enero']-$get_nota_credito[0]['Enero']-$get_gasto[0]['Enero']-$get_impuesto[0]['Enero'];
        $after_febrero=$get_boleta[0]['Febrero']+$get_cuentas_por_cobrar[0]['Febrero']+$get_factura[0]['Febrero']+$get_nota_debito[0]['Febrero']-$get_nota_credito[0]['Febrero']-$get_gasto[0]['Febrero']-$get_impuesto[0]['Febrero'];
        $after_marzo=$get_boleta[0]['Marzo']+$get_cuentas_por_cobrar[0]['Marzo']+$get_factura[0]['Marzo']+$get_nota_debito[0]['Marzo']-$get_nota_credito[0]['Marzo']-$get_gasto[0]['Marzo']-$get_impuesto[0]['Marzo'];
        $after_abril=$get_boleta[0]['Abril']+$get_cuentas_por_cobrar[0]['Abril']+$get_factura[0]['Abril']+$get_nota_debito[0]['Abril']-$get_nota_credito[0]['Abril']-$get_gasto[0]['Abril']-$get_impuesto[0]['Abril'];
        $after_mayo=$get_boleta[0]['Mayo']+$get_cuentas_por_cobrar[0]['Mayo']+$get_factura[0]['Mayo']+$get_nota_debito[0]['Mayo']-$get_nota_credito[0]['Mayo']-$get_gasto[0]['Mayo']-$get_impuesto[0]['Mayo'];
        $after_junio=$get_boleta[0]['Junio']+$get_cuentas_por_cobrar[0]['Junio']+$get_factura[0]['Junio']+$get_nota_debito[0]['Junio']-$get_nota_credito[0]['Junio']-$get_gasto[0]['Junio']-$get_impuesto[0]['Junio'];
        $after_julio=$get_boleta[0]['Julio']+$get_cuentas_por_cobrar[0]['Julio']+$get_factura[0]['Julio']+$get_nota_debito[0]['Julio']-$get_nota_credito[0]['Julio']-$get_gasto[0]['Julio']-$get_impuesto[0]['Julio'];
        $after_agosto=$get_boleta[0]['Agosto']+$get_cuentas_por_cobrar[0]['Agosto']+$get_factura[0]['Agosto']+$get_nota_debito[0]['Agosto']-$get_nota_credito[0]['Agosto']-$get_gasto[0]['Agosto']-$get_impuesto[0]['Agosto'];
        $after_septiembre=$get_boleta[0]['Septiembre']+$get_cuentas_por_cobrar[0]['Septiembre']+$get_factura[0]['Septiembre']+$get_nota_debito[0]['Septiembre']-$get_nota_credito[0]['Septiembre']-$get_gasto[0]['Septiembre']-$get_impuesto[0]['Septiembre'];
        $after_octubre=$get_boleta[0]['Octubre']+$get_cuentas_por_cobrar[0]['Octubre']+$get_factura[0]['Octubre']+$get_nota_debito[0]['Octubre']-$get_nota_credito[0]['Octubre']-$get_gasto[0]['Octubre']-$get_impuesto[0]['Octubre'];
        $after_noviembre=$get_boleta[0]['Noviembre']+$get_cuentas_por_cobrar[0]['Noviembre']+$get_factura[0]['Noviembre']+$get_nota_debito[0]['Noviembre']-$get_nota_credito[0]['Noviembre']-$get_gasto[0]['Noviembre']-$get_impuesto[0]['Noviembre'];
        $after_diciembre=$get_boleta[0]['Diciembre']+$get_cuentas_por_cobrar[0]['Diciembre']+$get_factura[0]['Diciembre']+$get_nota_debito[0]['Diciembre']-$get_nota_credito[0]['Diciembre']-$get_gasto[0]['Diciembre']-$get_impuesto[0]['Diciembre'];
        $after_total=$get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total']-$get_gasto[0]['Total']-$get_impuesto[0]['Total'];

        /*DIFERENCIA*/
        if($ingreso_enero_ant==0){
            $diferencia_ingreso_enero = 0;
        }else{
            $diferencia_ingreso_enero = (($ingreso_enero-$ingreso_enero_ant)/$ingreso_enero_ant)*100;
        }
        if($ingreso_febrero_ant==0){
            $diferencia_ingreso_febrero = 0;
        }else{
            $diferencia_ingreso_febrero = (($ingreso_febrero-$ingreso_febrero_ant)/$ingreso_febrero_ant)*100;
        }
        if($ingreso_marzo_ant==0){
            $diferencia_ingreso_marzo = 0;
        }else{
            $diferencia_ingreso_marzo = (($ingreso_marzo-$ingreso_marzo_ant)/$ingreso_marzo_ant)*100;
        }
        if($ingreso_abril_ant==0){
            $diferencia_ingreso_abril = 0;
        }else{
            $diferencia_ingreso_abril = (($ingreso_abril-$ingreso_abril_ant)/$ingreso_abril_ant)*100;
        }
        if($ingreso_mayo_ant==0){
            $diferencia_ingreso_mayo = 0;
        }else{
            $diferencia_ingreso_mayo = (($ingreso_mayo-$ingreso_mayo_ant)/$ingreso_mayo_ant)*100;
        }
        if($ingreso_junio_ant==0){
            $diferencia_ingreso_junio = 0;
        }else{
            $diferencia_ingreso_junio = (($ingreso_junio-$ingreso_junio_ant)/$ingreso_junio_ant)*100;
        }
        if($ingreso_julio_ant==0){
            $diferencia_ingreso_julio = 0;
        }else{
            $diferencia_ingreso_julio = (($ingreso_julio-$ingreso_julio_ant)/$ingreso_julio_ant)*100;
        }
        if($ingreso_agosto_ant==0){
            $diferencia_ingreso_agosto = 0;
        }else{
            $diferencia_ingreso_agosto = (($ingreso_agosto-$ingreso_agosto_ant)/$ingreso_agosto_ant)*100;
        }
        if($ingreso_septiembre_ant==0){
            $diferencia_ingreso_septiembre = 0;
        }else{
            $diferencia_ingreso_septiembre = (($ingreso_septiembre-$ingreso_septiembre_ant)/$ingreso_septiembre_ant)*100;
        }
        if($ingreso_octubre_ant==0){
            $diferencia_ingreso_octubre = 0;
        }else{
            $diferencia_ingreso_octubre = (($ingreso_octubre-$ingreso_octubre_ant)/$ingreso_octubre_ant)*100;
        }
        if($ingreso_noviembre_ant==0){
            $diferencia_ingreso_noviembre = 0;
        }else{
            $diferencia_ingreso_noviembre = (($ingreso_noviembre-$ingreso_noviembre_ant)/$ingreso_noviembre_ant)*100;
        }
        if($ingreso_diciembre_ant==0){
            $diferencia_ingreso_diciembre = 0;
        }else{
            $diferencia_ingreso_diciembre = (($ingreso_diciembre-$ingreso_diciembre_ant)/$ingreso_diciembre_ant)*100;
        }
        if($ingreso_total_ant==0){
            $diferencia_ingreso_total = 0;
        }else{
            $diferencia_ingreso_total = (($ingreso_total-$ingreso_total_ant)/$ingreso_total_ant)*100;
        }

        
        if($get_gasto_ant[0]['Enero']==0){
            $diferencia_gasto_enero = 0;
        }else{
            $diferencia_gasto_enero = (($get_gasto[0]['Enero']-$get_gasto_ant[0]['Enero'])/$get_gasto_ant[0]['Enero'])*100;
        }
        if($get_gasto_ant[0]['Febrero']==0){
            $diferencia_gasto_febrero = 0;
        }else{
            $diferencia_gasto_febrero = (($get_gasto[0]['Febrero']-$get_gasto_ant[0]['Febrero'])/$get_gasto_ant[0]['Febrero'])*100;
        }
        if($get_gasto_ant[0]['Marzo']==0){
            $diferencia_gasto_marzo = 0;
        }else{
            $diferencia_gasto_marzo = (($get_gasto[0]['Marzo']-$get_gasto_ant[0]['Marzo'])/$get_gasto_ant[0]['Marzo'])*100;
        }
        if($get_gasto_ant[0]['Abril']==0){
            $diferencia_gasto_abril = 0;
        }else{
            $diferencia_gasto_abril = (($get_gasto[0]['Abril']-$get_gasto_ant[0]['Abril'])/$get_gasto_ant[0]['Abril'])*100;
        }
        if($get_gasto_ant[0]['Mayo']==0){
            $diferencia_gasto_mayo = 0;
        }else{
            $diferencia_gasto_mayo = (($get_gasto[0]['Mayo']-$get_gasto_ant[0]['Mayo'])/$get_gasto_ant[0]['Mayo'])*100;
        }
        if($get_gasto_ant[0]['Junio']==0){
            $diferencia_gasto_junio = 0;
        }else{
            $diferencia_gasto_junio = (($get_gasto[0]['Junio']-$get_gasto_ant[0]['Junio'])/$get_gasto_ant[0]['Junio'])*100;
        }
        if($get_gasto_ant[0]['Julio']==0){
            $diferencia_gasto_julio = 0;
        }else{
            $diferencia_gasto_julio = (($get_gasto[0]['Julio']-$get_gasto_ant[0]['Julio'])/$get_gasto_ant[0]['Julio'])*100;
        }
        if($get_gasto_ant[0]['Agosto']==0){
            $diferencia_gasto_agosto = 0;
        }else{
            $diferencia_gasto_agosto = (($get_gasto[0]['Agosto']-$get_gasto_ant[0]['Agosto'])/$get_gasto_ant[0]['Agosto'])*100;
        }
        if($get_gasto_ant[0]['Septiembre']==0){
            $diferencia_gasto_septiembre = 0;
        }else{
            $diferencia_gasto_septiembre = (($get_gasto[0]['Septiembre']-$get_gasto_ant[0]['Septiembre'])/$get_gasto_ant[0]['Septiembre'])*100;
        }
        if($get_gasto_ant[0]['Octubre']==0){
            $diferencia_gasto_octubre = 0;
        }else{
            $diferencia_gasto_octubre = (($get_gasto[0]['Octubre']-$get_gasto_ant[0]['Octubre'])/$get_gasto_ant[0]['Octubre'])*100;
        }
        if($get_gasto_ant[0]['Noviembre']==0){
            $diferencia_gasto_noviembre = 0;
        }else{
            $diferencia_gasto_noviembre = (($get_gasto[0]['Noviembre']-$get_gasto_ant[0]['Noviembre'])/$get_gasto_ant[0]['Noviembre'])*100;
        }
        if($get_gasto_ant[0]['Diciembre']==0){
            $diferencia_gasto_diciembre = 0;
        }else{
            $diferencia_gasto_diciembre = (($get_gasto[0]['Diciembre']-$get_gasto_ant[0]['Diciembre'])/$get_gasto_ant[0]['Diciembre'])*100;
        }
        if($get_gasto_ant[0]['Total']==0){
            $diferencia_gasto_total = 0;
        }else{
            $diferencia_gasto_total = (($get_gasto[0]['Total']-$get_gasto_ant[0]['Total'])/$get_gasto_ant[0]['Total'])*100;
        }

        
        if($before_enero_ant==0){
            $diferencia_before_enero = 0;
        }else{
            $diferencia_before_enero = (($before_enero-$before_enero_ant)/$before_enero_ant)*100;
        }
        if($before_febrero_ant==0){
            $diferencia_before_febrero = 0;
        }else{
            $diferencia_before_febrero = (($before_febrero-$before_febrero_ant)/$before_febrero_ant)*100;
        }
        if($before_marzo_ant==0){
            $diferencia_before_marzo = 0;
        }else{
            $diferencia_before_marzo = (($before_marzo-$before_marzo_ant)/$before_marzo_ant)*100;
        }
        if($before_abril_ant==0){
            $diferencia_before_abril = 0;
        }else{
            $diferencia_before_abril = (($before_abril-$before_abril_ant)/$before_abril_ant)*100;
        }
        if($before_mayo_ant==0){
            $diferencia_before_mayo = 0;
        }else{
            $diferencia_before_mayo = (($before_mayo-$before_mayo_ant)/$before_mayo_ant)*100;
        }
        if($before_junio_ant==0){
            $diferencia_before_junio = 0;
        }else{
            $diferencia_before_junio = (($before_junio-$before_junio_ant)/$before_junio_ant)*100;
        }
        if($before_julio_ant==0){
            $diferencia_before_julio = 0;
        }else{
            $diferencia_before_julio = (($before_julio-$before_julio_ant)/$before_julio_ant)*100;
        }
        if($before_agosto_ant==0){
            $diferencia_before_agosto = 0;
        }else{
            $diferencia_before_agosto = (($before_agosto-$before_agosto_ant)/$before_agosto_ant)*100;
        }
        if($before_septiembre_ant==0){
            $diferencia_before_septiembre = 0;
        }else{
            $diferencia_before_septiembre = (($before_septiembre-$before_septiembre_ant)/$before_septiembre_ant)*100;
        }
        if($before_octubre_ant==0){
            $diferencia_before_octubre = 0;
        }else{
            $diferencia_before_octubre = (($before_octubre-$before_octubre_ant)/$before_octubre_ant)*100;
        }
        if($before_noviembre_ant==0){
            $diferencia_before_noviembre = 0;
        }else{
            $diferencia_before_noviembre = (($before_noviembre-$before_noviembre_ant)/$before_noviembre_ant)*100;
        }
        if($before_diciembre_ant==0){
            $diferencia_before_diciembre = 0;
        }else{
            $diferencia_before_diciembre = (($before_diciembre-$before_diciembre_ant)/$before_diciembre_ant)*100;
        }
        if($before_total_ant==0){
            $diferencia_before_total = 0;
        }else{
            $diferencia_before_total = (($before_total-$before_total_ant)/$before_total_ant)*100;
        }


        if($get_impuesto_ant[0]['Enero']==0){
            $diferencia_impuesto_enero = 0;
        }else{
            $diferencia_impuesto_enero = (($get_impuesto[0]['Enero']-$get_impuesto_ant[0]['Enero'])/$get_impuesto_ant[0]['Enero'])*100;
        }
        if($get_impuesto_ant[0]['Febrero']==0){
            $diferencia_impuesto_febrero = 0;
        }else{
            $diferencia_impuesto_febrero = (($get_impuesto[0]['Febrero']-$get_impuesto_ant[0]['Febrero'])/$get_impuesto_ant[0]['Febrero'])*100;
        }
        if($get_impuesto_ant[0]['Marzo']==0){
            $diferencia_impuesto_marzo = 0;
        }else{
            $diferencia_impuesto_marzo = (($get_impuesto[0]['Marzo']-$get_impuesto_ant[0]['Marzo'])/$get_impuesto_ant[0]['Marzo'])*100;
        }
        if($get_impuesto_ant[0]['Abril']==0){
            $diferencia_impuesto_abril = 0;
        }else{
            $diferencia_impuesto_abril = (($get_impuesto[0]['Abril']-$get_impuesto_ant[0]['Abril'])/$get_impuesto_ant[0]['Abril'])*100;
        }
        if($get_impuesto_ant[0]['Mayo']==0){
            $diferencia_impuesto_mayo = 0;
        }else{
            $diferencia_impuesto_mayo = (($get_impuesto[0]['Mayo']-$get_impuesto_ant[0]['Mayo'])/$get_impuesto_ant[0]['Mayo'])*100;
        }
        if($get_impuesto_ant[0]['Junio']==0){
            $diferencia_impuesto_junio = 0;
        }else{
            $diferencia_impuesto_junio = (($get_impuesto[0]['Junio']-$get_impuesto_ant[0]['Junio'])/$get_impuesto_ant[0]['Junio'])*100;
        }
        if($get_impuesto_ant[0]['Julio']==0){
            $diferencia_impuesto_julio = 0;
        }else{
            $diferencia_impuesto_julio = (($get_impuesto[0]['Julio']-$get_impuesto_ant[0]['Julio'])/$get_impuesto_ant[0]['Julio'])*100;
        }
        if($get_impuesto_ant[0]['Agosto']==0){
            $diferencia_impuesto_agosto = 0;
        }else{
            $diferencia_impuesto_agosto = (($get_impuesto[0]['Agosto']-$get_impuesto_ant[0]['Agosto'])/$get_impuesto_ant[0]['Agosto'])*100;
        }
        if($get_impuesto_ant[0]['Septiembre']==0){
            $diferencia_impuesto_septiembre = 0;
        }else{
            $diferencia_impuesto_septiembre = (($get_impuesto[0]['Septiembre']-$get_impuesto_ant[0]['Septiembre'])/$get_impuesto_ant[0]['Septiembre'])*100;
        }
        if($get_impuesto_ant[0]['Octubre']==0){
            $diferencia_impuesto_octubre = 0;
        }else{
            $diferencia_impuesto_octubre = (($get_impuesto[0]['Octubre']-$get_impuesto_ant[0]['Octubre'])/$get_impuesto_ant[0]['Octubre'])*100;
        }
        if($get_impuesto_ant[0]['Noviembre']==0){
            $diferencia_impuesto_noviembre = 0;
        }else{
            $diferencia_impuesto_noviembre = (($get_impuesto[0]['Noviembre']-$get_impuesto_ant[0]['Noviembre'])/$get_impuesto_ant[0]['Noviembre'])*100;
        }
        if($get_impuesto_ant[0]['Diciembre']==0){
            $diferencia_impuesto_diciembre = 0;
        }else{
            $diferencia_impuesto_diciembre = (($get_impuesto[0]['Diciembre']-$get_impuesto_ant[0]['Diciembre'])/$get_impuesto_ant[0]['Diciembre'])*100;
        }
        if($get_impuesto_ant[0]['Total']==0){
            $diferencia_impuesto_total = 0;
        }else{
            $diferencia_impuesto_total = (($get_impuesto[0]['Total']-$get_impuesto_ant[0]['Total'])/$get_impuesto_ant[0]['Total'])*100;
        }


        if($after_enero_ant==0){
            $diferencia_after_enero = 0;
        }else{
            $diferencia_after_enero = (($after_enero-$after_enero_ant)/$after_enero_ant)*100;
        }
        if($after_febrero_ant==0){
            $diferencia_after_febrero = 0;
        }else{
            $diferencia_after_febrero = (($after_febrero-$after_febrero_ant)/$after_febrero_ant)*100;
        }
        if($after_marzo_ant==0){
            $diferencia_after_marzo = 0;
        }else{
            $diferencia_after_marzo = (($after_marzo-$after_marzo_ant)/$after_marzo_ant)*100;
        }
        if($after_abril_ant==0){
            $diferencia_after_abril = 0;
        }else{
            $diferencia_after_abril = (($after_abril-$after_abril_ant)/$after_abril_ant)*100;
        }
        if($after_mayo_ant==0){
            $diferencia_after_mayo = 0;
        }else{
            $diferencia_after_mayo = (($after_mayo-$after_mayo_ant)/$after_mayo_ant)*100;
        }
        if($after_junio_ant==0){
            $diferencia_after_junio = 0;
        }else{
            $diferencia_after_junio = (($after_junio-$after_junio_ant)/$after_junio_ant)*100;
        }
        if($after_julio_ant==0){
            $diferencia_after_julio = 0;
        }else{
            $diferencia_after_julio = (($after_julio-$after_julio_ant)/$after_julio_ant)*100;
        }
        if($after_agosto_ant==0){
            $diferencia_after_agosto = 0;
        }else{
            $diferencia_after_agosto = (($after_agosto-$after_agosto_ant)/$after_agosto_ant)*100;
        }
        if($after_septiembre_ant==0){
            $diferencia_after_septiembre = 0;
        }else{
            $diferencia_after_septiembre = (($after_septiembre-$after_septiembre_ant)/$after_septiembre_ant)*100;
        }
        if($after_octubre_ant==0){
            $diferencia_after_octubre = 0;
        }else{
            $diferencia_after_octubre = (($after_octubre-$after_octubre_ant)/$after_octubre_ant)*100;
        }
        if($after_noviembre_ant==0){
            $diferencia_after_noviembre = 0;
        }else{
            $diferencia_after_noviembre = (($after_noviembre-$after_noviembre_ant)/$after_noviembre_ant)*100;
        }
        if($after_diciembre_ant==0){
            $diferencia_after_diciembre = 0;
        }else{
            $diferencia_after_diciembre = (($after_diciembre-$after_diciembre_ant)/$after_diciembre_ant)*100;
        }
        if($after_total_ant==0){
            $diferencia_after_total = 0;
        }else{
            $diferencia_after_total = (($after_total-$after_total_ant)/$after_total_ant)*100;
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
        
        $sheet->setCellValue("A2", 'INGRESOS');
        $sheet->setCellValue("B2", "S/".number_format($ingreso_enero,2));
        $sheet->setCellValue("C2", "S/".number_format($ingreso_febrero,2));
        $sheet->setCellValue("D2", "S/".number_format($ingreso_marzo,2));
        $sheet->setCellValue("E2", "S/".number_format($ingreso_abril,2));
        $sheet->setCellValue("F2", "S/".number_format($ingreso_mayo,2));
        $sheet->setCellValue("G2", "S/".number_format($ingreso_junio,2));
        $sheet->setCellValue("H2", "S/".number_format($ingreso_julio,2));
        $sheet->setCellValue("I2", "S/".number_format($ingreso_agosto,2));
        $sheet->setCellValue("J2", "S/".number_format($ingreso_septiembre,2));
        $sheet->setCellValue("K2", "S/".number_format($ingreso_octubre,2));
        $sheet->setCellValue("L2", "S/".number_format($ingreso_noviembre,2));
        $sheet->setCellValue("M2", "S/".number_format($ingreso_diciembre,2));
        $sheet->setCellValue("O2", "S/".number_format($ingreso_total,2));

        $sheet->setCellValue("B3", number_format($diferencia_ingreso_enero,2)."%");
        $sheet->setCellValue("C3", number_format($diferencia_ingreso_febrero,2)."%");
        $sheet->setCellValue("D3", number_format($diferencia_ingreso_marzo,2)."%");
        $sheet->setCellValue("E3", number_format($diferencia_ingreso_abril,2)."%");
        $sheet->setCellValue("F3", number_format($diferencia_ingreso_mayo,2)."%");
        $sheet->setCellValue("G3", number_format($diferencia_ingreso_junio,2)."%");
        $sheet->setCellValue("H3", number_format($diferencia_ingreso_julio,2)."%");
        $sheet->setCellValue("I3", number_format($diferencia_ingreso_agosto,2)."%");
        $sheet->setCellValue("J3", number_format($diferencia_ingreso_septiembre,2)."%");
        $sheet->setCellValue("K3", number_format($diferencia_ingreso_octubre,2)."%");
        $sheet->setCellValue("L3", number_format($diferencia_ingreso_noviembre,2)."%");
        $sheet->setCellValue("M3", number_format($diferencia_ingreso_diciembre,2)."%");
        $sheet->setCellValue("O3", number_format($diferencia_ingreso_total,2)."%");

        $sheet->setCellValue("A4", 'Boletas');
        $sheet->setCellValue("B4", "S/".number_format($get_boleta[0]['Enero'],2));
        $sheet->setCellValue("C4", "S/".number_format($get_boleta[0]['Febrero'],2));
        $sheet->setCellValue("D4", "S/".number_format($get_boleta[0]['Marzo'],2));
        $sheet->setCellValue("E4", "S/".number_format($get_boleta[0]['Abril'],2));
        $sheet->setCellValue("F4", "S/".number_format($get_boleta[0]['Mayo'],2));
        $sheet->setCellValue("G4", "S/".number_format($get_boleta[0]['Junio'],2));
        $sheet->setCellValue("H4", "S/".number_format($get_boleta[0]['Julio'],2));
        $sheet->setCellValue("I4", "S/".number_format($get_boleta[0]['Agosto'],2));
        $sheet->setCellValue("J4", "S/".number_format($get_boleta[0]['Septiembre'],2));
        $sheet->setCellValue("K4", "S/".number_format($get_boleta[0]['Octubre'],2));
        $sheet->setCellValue("L4", "S/".number_format($get_boleta[0]['Noviembre'],2));
        $sheet->setCellValue("M4", "S/".number_format($get_boleta[0]['Diciembre'],2));
        $sheet->setCellValue("O4", "S/".number_format($get_boleta[0]['Total'],2));

        $sheet->setCellValue("A5", 'Cuentas Por Cobrar');
        $sheet->setCellValue("B5", "S/".number_format($get_cuentas_por_cobrar[0]['Enero'],2));
        $sheet->setCellValue("C5", "S/".number_format($get_cuentas_por_cobrar[0]['Febrero'],2));
        $sheet->setCellValue("D5", "S/".number_format($get_cuentas_por_cobrar[0]['Marzo'],2));
        $sheet->setCellValue("E5", "S/".number_format($get_cuentas_por_cobrar[0]['Abril'],2));
        $sheet->setCellValue("F5", "S/".number_format($get_cuentas_por_cobrar[0]['Mayo'],2));
        $sheet->setCellValue("G5", "S/".number_format($get_cuentas_por_cobrar[0]['Junio'],2));
        $sheet->setCellValue("H5", "S/".number_format($get_cuentas_por_cobrar[0]['Julio'],2));
        $sheet->setCellValue("I5", "S/".number_format($get_cuentas_por_cobrar[0]['Agosto'],2));
        $sheet->setCellValue("J5", "S/".number_format($get_cuentas_por_cobrar[0]['Septiembre'],2));
        $sheet->setCellValue("K5", "S/".number_format($get_cuentas_por_cobrar[0]['Octubre'],2));
        $sheet->setCellValue("L5", "S/".number_format($get_cuentas_por_cobrar[0]['Noviembre'],2));
        $sheet->setCellValue("M5", "S/".number_format($get_cuentas_por_cobrar[0]['Diciembre'],2));
        $sheet->setCellValue("O5", "S/".number_format($get_cuentas_por_cobrar[0]['Total'],2));

        $sheet->setCellValue("A6", 'Facturas');
        $sheet->setCellValue("B6", "S/".number_format($get_factura[0]['Enero'],2));
        $sheet->setCellValue("C6", "S/".number_format($get_factura[0]['Febrero'],2));
        $sheet->setCellValue("D6", "S/".number_format($get_factura[0]['Marzo'],2));
        $sheet->setCellValue("E6", "S/".number_format($get_factura[0]['Abril'],2));
        $sheet->setCellValue("F6", "S/".number_format($get_factura[0]['Mayo'],2));
        $sheet->setCellValue("G6", "S/".number_format($get_factura[0]['Junio'],2));
        $sheet->setCellValue("H6", "S/".number_format($get_factura[0]['Julio'],2));
        $sheet->setCellValue("I6", "S/".number_format($get_factura[0]['Agosto'],2));
        $sheet->setCellValue("J6", "S/".number_format($get_factura[0]['Septiembre'],2));
        $sheet->setCellValue("K6", "S/".number_format($get_factura[0]['Octubre'],2));
        $sheet->setCellValue("L6", "S/".number_format($get_factura[0]['Noviembre'],2));
        $sheet->setCellValue("M6", "S/".number_format($get_factura[0]['Diciembre'],2));
        $sheet->setCellValue("O6", "S/".number_format($get_factura[0]['Total'],2));

        $sheet->setCellValue("A7", 'Notas de Debito');
        $sheet->setCellValue("B7", "S/".number_format($get_nota_debito[0]['Enero'],2));
        $sheet->setCellValue("C7", "S/".number_format($get_nota_debito[0]['Febrero'],2));
        $sheet->setCellValue("D7", "S/".number_format($get_nota_debito[0]['Marzo'],2));
        $sheet->setCellValue("E7", "S/".number_format($get_nota_debito[0]['Abril'],2));
        $sheet->setCellValue("F7", "S/".number_format($get_nota_debito[0]['Mayo'],2));
        $sheet->setCellValue("G7", "S/".number_format($get_nota_debito[0]['Junio'],2));
        $sheet->setCellValue("H7", "S/".number_format($get_nota_debito[0]['Julio'],2));
        $sheet->setCellValue("I7", "S/".number_format($get_nota_debito[0]['Agosto'],2));
        $sheet->setCellValue("J7", "S/".number_format($get_nota_debito[0]['Septiembre'],2));
        $sheet->setCellValue("K7", "S/".number_format($get_nota_debito[0]['Octubre'],2));
        $sheet->setCellValue("L7", "S/".number_format($get_nota_debito[0]['Noviembre'],2));
        $sheet->setCellValue("M7", "S/".number_format($get_nota_debito[0]['Diciembre'],2));
        $sheet->setCellValue("O7", "S/".number_format($get_nota_debito[0]['Total'],2));

        $sheet->setCellValue("A8", 'Notas de Credito');
        $sheet->setCellValue("B8", "S/".number_format($get_nota_credito[0]['Enero'],2));
        $sheet->setCellValue("C8", "S/".number_format($get_nota_credito[0]['Febrero'],2));
        $sheet->setCellValue("D8", "S/".number_format($get_nota_credito[0]['Marzo'],2));
        $sheet->setCellValue("E8", "S/".number_format($get_nota_credito[0]['Abril'],2));
        $sheet->setCellValue("F8", "S/".number_format($get_nota_credito[0]['Mayo'],2));
        $sheet->setCellValue("G8", "S/".number_format($get_nota_credito[0]['Junio'],2));
        $sheet->setCellValue("H8", "S/".number_format($get_nota_credito[0]['Julio'],2));
        $sheet->setCellValue("I8", "S/".number_format($get_nota_credito[0]['Agosto'],2));
        $sheet->setCellValue("J8", "S/".number_format($get_nota_credito[0]['Septiembre'],2));
        $sheet->setCellValue("K8", "S/".number_format($get_nota_credito[0]['Octubre'],2));
        $sheet->setCellValue("L8", "S/".number_format($get_nota_credito[0]['Noviembre'],2));
        $sheet->setCellValue("M8", "S/".number_format($get_nota_credito[0]['Diciembre'],2));
        $sheet->setCellValue("O8", "S/".number_format($get_nota_credito[0]['Total'],2));

        $sheet->mergeCells('A9:A10');
        $sheet->getStyle('A9')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A9")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A9")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A9")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FF0000');

        $spreadsheet->getActiveSheet()->getStyle("B9:M10")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFE1E2');

        $spreadsheet->getActiveSheet()->getStyle("O9:O10")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF0000');

        $sheet->getStyle("A9:O10")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B9:O10")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B9:O10")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('O9:O10')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->setCellValue("A9", 'GASTOS');
        $sheet->setCellValue("B9", "S/".number_format($get_gasto[0]['Enero'],2));
        $sheet->setCellValue("C9", "S/".number_format($get_gasto[0]['Febrero'],2));
        $sheet->setCellValue("D9", "S/".number_format($get_gasto[0]['Marzo'],2));
        $sheet->setCellValue("E9", "S/".number_format($get_gasto[0]['Abril'],2));
        $sheet->setCellValue("F9", "S/".number_format($get_gasto[0]['Mayo'],2));
        $sheet->setCellValue("G9", "S/".number_format($get_gasto[0]['Junio'],2));
        $sheet->setCellValue("H9", "S/".number_format($get_gasto[0]['Julio'],2));
        $sheet->setCellValue("I9", "S/".number_format($get_gasto[0]['Agosto'],2));
        $sheet->setCellValue("J9", "S/".number_format($get_gasto[0]['Septiembre'],2));
        $sheet->setCellValue("K9", "S/".number_format($get_gasto[0]['Octubre'],2));
        $sheet->setCellValue("L9", "S/".number_format($get_gasto[0]['Noviembre'],2));
        $sheet->setCellValue("M9", "S/".number_format($get_gasto[0]['Diciembre'],2));
        $sheet->setCellValue("O9", "S/".number_format($get_gasto[0]['Total'],2));

        $sheet->setCellValue("B10", number_format($diferencia_gasto_enero,2)."%");
        $sheet->setCellValue("C10", number_format($diferencia_gasto_febrero,2)."%");
        $sheet->setCellValue("D10", number_format($diferencia_gasto_marzo,2)."%");
        $sheet->setCellValue("E10", number_format($diferencia_gasto_abril,2)."%");
        $sheet->setCellValue("F10", number_format($diferencia_gasto_mayo,2)."%");
        $sheet->setCellValue("G10", number_format($diferencia_gasto_junio,2)."%");
        $sheet->setCellValue("H10", number_format($diferencia_gasto_julio,2)."%");
        $sheet->setCellValue("I10", number_format($diferencia_gasto_agosto,2)."%");
        $sheet->setCellValue("J10", number_format($diferencia_gasto_septiembre,2)."%");
        $sheet->setCellValue("K10", number_format($diferencia_gasto_octubre,2)."%");
        $sheet->setCellValue("L10", number_format($diferencia_gasto_noviembre,2)."%");
        $sheet->setCellValue("M10", number_format($diferencia_gasto_diciembre,2)."%");
        $sheet->setCellValue("O10", number_format($diferencia_gasto_total,2)."%");

        $contador=10;

        foreach($list_gastos as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $sheet->setCellValue("A{$contador}", substr($list['Description'],5));
            $sheet->setCellValue("B{$contador}", "S/".number_format($list['Enero'],2));
            $sheet->setCellValue("C{$contador}", "S/".number_format($list['Febrero'],2));
            $sheet->setCellValue("D{$contador}", "S/".number_format($list['Marzo'],2));
            $sheet->setCellValue("E{$contador}", "S/".number_format($list['Abril'],2));
            $sheet->setCellValue("F{$contador}", "S/".number_format($list['Mayo'],2));
            $sheet->setCellValue("G{$contador}", "S/".number_format($list['Junio'],2));
            $sheet->setCellValue("H{$contador}", "S/".number_format($list['Julio'],2));
            $sheet->setCellValue("I{$contador}", "S/".number_format($list['Agosto'],2));
            $sheet->setCellValue("J{$contador}", "S/".number_format($list['Septiembre'],2));
            $sheet->setCellValue("K{$contador}", "S/".number_format($list['Octubre'],2));
            $sheet->setCellValue("L{$contador}", "S/".number_format($list['Noviembre'],2));
            $sheet->setCellValue("M{$contador}", "S/".number_format($list['Diciembre'],2));
            $sheet->setCellValue("O{$contador}", "S/".number_format($list['Total'],2));
        }

        $contador1=$contador+1;
        $contador2=$contador+2;

        $sheet->mergeCells("A{$contador1}:A{$contador2}");
        $sheet->getStyle("A{$contador1}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador1}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador1}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador1}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('779ECB');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador1}:M{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('E3F2FD');

        $spreadsheet->getActiveSheet()->getStyle("O{$contador1}:O{$contador2}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('779ECB');

        $sheet->getStyle("A{$contador1}:O{$contador2}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador1}:O{$contador2}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador1}:O{$contador2}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("O{$contador1}:O{$contador2}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->setCellValue("A{$contador1}", 'UTILIDAD (Before Tax)');
        $sheet->setCellValue("B{$contador1}", "S/".number_format($before_enero,2));
        $sheet->setCellValue("C{$contador1}", "S/".number_format($before_febrero,2));
        $sheet->setCellValue("D{$contador1}", "S/".number_format($before_marzo,2));
        $sheet->setCellValue("E{$contador1}", "S/".number_format($before_abril,2));
        $sheet->setCellValue("F{$contador1}", "S/".number_format($before_mayo,2));
        $sheet->setCellValue("G{$contador1}", "S/".number_format($before_junio,2));
        $sheet->setCellValue("H{$contador1}", "S/".number_format($before_julio,2));
        $sheet->setCellValue("I{$contador1}", "S/".number_format($before_agosto,2));
        $sheet->setCellValue("J{$contador1}", "S/".number_format($before_septiembre,2));
        $sheet->setCellValue("K{$contador1}", "S/".number_format($before_octubre,2));
        $sheet->setCellValue("L{$contador1}", "S/".number_format($before_noviembre,2));
        $sheet->setCellValue("M{$contador1}", "S/".number_format($before_diciembre,2));
        $sheet->setCellValue("O{$contador1}", "S/".number_format($before_total,2));

        $sheet->setCellValue("B{$contador2}", number_format($diferencia_before_enero,2)."%");
        $sheet->setCellValue("C{$contador2}", number_format($diferencia_before_febrero,2)."%");
        $sheet->setCellValue("D{$contador2}", number_format($diferencia_before_marzo,2)."%");
        $sheet->setCellValue("E{$contador2}", number_format($diferencia_before_abril,2)."%");
        $sheet->setCellValue("F{$contador2}", number_format($diferencia_before_mayo,2)."%");
        $sheet->setCellValue("G{$contador2}", number_format($diferencia_before_junio,2)."%");
        $sheet->setCellValue("H{$contador2}", number_format($diferencia_before_julio,2)."%");
        $sheet->setCellValue("I{$contador2}", number_format($diferencia_before_agosto,2)."%");
        $sheet->setCellValue("J{$contador2}", number_format($diferencia_before_septiembre,2)."%");
        $sheet->setCellValue("K{$contador2}", number_format($diferencia_before_octubre,2)."%");
        $sheet->setCellValue("L{$contador2}", number_format($diferencia_before_noviembre,2)."%");
        $sheet->setCellValue("M{$contador2}", number_format($diferencia_before_diciembre,2)."%");
        $sheet->setCellValue("O{$contador2}", number_format($diferencia_before_total,2)."%");

        $contador3=$contador+3;
        $contador4=$contador+4;
        $contador5=$contador+5;

        $sheet->mergeCells("A{$contador3}:A{$contador4}");
        $sheet->getStyle("A{$contador3}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador3}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador3}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador3}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('9B9B9B');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador3}:M{$contador4}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('CDCDCD');

        $spreadsheet->getActiveSheet()->getStyle("O{$contador3}:O{$contador4}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('9B9B9B');

        $sheet->getStyle("A{$contador3}:O{$contador5}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador3}:O{$contador5}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador3}:O{$contador5}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("A{$contador5}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$contador5}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A{$contador5}")->getFont()->setBold(true);  

        $sheet->getStyle("O{$contador3}:O{$contador4}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->setCellValue("A{$contador3}", 'IMPUESTOS');
        $sheet->setCellValue("B{$contador3}", "S/".number_format($get_impuesto[0]['Enero'],2));
        $sheet->setCellValue("C{$contador3}", "S/".number_format($get_impuesto[0]['Febrero'],2));
        $sheet->setCellValue("D{$contador3}", "S/".number_format($get_impuesto[0]['Marzo'],2));
        $sheet->setCellValue("E{$contador3}", "S/".number_format($get_impuesto[0]['Abril'],2));
        $sheet->setCellValue("F{$contador3}", "S/".number_format($get_impuesto[0]['Mayo'],2));
        $sheet->setCellValue("G{$contador3}", "S/".number_format($get_impuesto[0]['Junio'],2));
        $sheet->setCellValue("H{$contador3}", "S/".number_format($get_impuesto[0]['Julio'],2));
        $sheet->setCellValue("I{$contador3}", "S/".number_format($get_impuesto[0]['Agosto'],2));
        $sheet->setCellValue("J{$contador3}", "S/".number_format($get_impuesto[0]['Septiembre'],2));
        $sheet->setCellValue("K{$contador3}", "S/".number_format($get_impuesto[0]['Octubre'],2));
        $sheet->setCellValue("L{$contador3}", "S/".number_format($get_impuesto[0]['Noviembre'],2));
        $sheet->setCellValue("M{$contador3}", "S/".number_format($get_impuesto[0]['Diciembre'],2));
        $sheet->setCellValue("O{$contador3}", "S/".number_format($get_impuesto[0]['Total'],2));

        $sheet->setCellValue("B{$contador4}", number_format($diferencia_impuesto_enero,2)."%");
        $sheet->setCellValue("C{$contador4}", number_format($diferencia_impuesto_febrero,2)."%");
        $sheet->setCellValue("D{$contador4}", number_format($diferencia_impuesto_marzo,2)."%");
        $sheet->setCellValue("E{$contador4}", number_format($diferencia_impuesto_abril,2)."%");
        $sheet->setCellValue("F{$contador4}", number_format($diferencia_impuesto_mayo,2)."%");
        $sheet->setCellValue("G{$contador4}", number_format($diferencia_impuesto_junio,2)."%");
        $sheet->setCellValue("H{$contador4}", number_format($diferencia_impuesto_julio,2)."%");
        $sheet->setCellValue("I{$contador4}", number_format($diferencia_impuesto_agosto,2)."%");
        $sheet->setCellValue("J{$contador4}", number_format($diferencia_impuesto_septiembre,2)."%");
        $sheet->setCellValue("K{$contador4}", number_format($diferencia_impuesto_octubre,2)."%");
        $sheet->setCellValue("L{$contador4}", number_format($diferencia_impuesto_noviembre,2)."%");
        $sheet->setCellValue("M{$contador4}", number_format($diferencia_impuesto_diciembre,2)."%");
        $sheet->setCellValue("O{$contador4}", number_format($diferencia_impuesto_total,2)."%");

        $sheet->setCellValue("A{$contador5}", 'Renta');
        $sheet->setCellValue("B{$contador5}", "S/".number_format($get_impuesto[0]['Enero'],2));
        $sheet->setCellValue("C{$contador5}", "S/".number_format($get_impuesto[0]['Febrero'],2));
        $sheet->setCellValue("D{$contador5}", "S/".number_format($get_impuesto[0]['Marzo'],2));
        $sheet->setCellValue("E{$contador5}", "S/".number_format($get_impuesto[0]['Abril'],2));
        $sheet->setCellValue("F{$contador5}", "S/".number_format($get_impuesto[0]['Mayo'],2));
        $sheet->setCellValue("G{$contador5}", "S/".number_format($get_impuesto[0]['Junio'],2));
        $sheet->setCellValue("H{$contador5}", "S/".number_format($get_impuesto[0]['Julio'],2));
        $sheet->setCellValue("I{$contador5}", "S/".number_format($get_impuesto[0]['Agosto'],2));
        $sheet->setCellValue("J{$contador5}", "S/".number_format($get_impuesto[0]['Septiembre'],2));
        $sheet->setCellValue("K{$contador5}", "S/".number_format($get_impuesto[0]['Octubre'],2));
        $sheet->setCellValue("L{$contador5}", "S/".number_format($get_impuesto[0]['Noviembre'],2));
        $sheet->setCellValue("M{$contador5}", "S/".number_format($get_impuesto[0]['Diciembre'],2));
        $sheet->setCellValue("O{$contador5}", "S/".number_format($get_impuesto[0]['Total'],2));

        $contador6=$contador+6;
        $contador7=$contador+7;

        $sheet->mergeCells("A{$contador6}:A{$contador7}");
        $sheet->getStyle("A{$contador6}")->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle("A{$contador6}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$contador6}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle("A{$contador6}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('1976D2');

        $spreadsheet->getActiveSheet()->getStyle("B{$contador6}:M{$contador7}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('E1F5FE');

        $spreadsheet->getActiveSheet()->getStyle("O{$contador6}:O{$contador7}")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('1976D2');

        $sheet->getStyle("A{$contador6}:O{$contador7}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("B{$contador6}:O{$contador7}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B{$contador6}:O{$contador7}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("O{$contador6}:O{$contador7}")->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->setCellValue("A{$contador6}", 'UTILIDAD (Before Tax)');
        $sheet->setCellValue("B{$contador6}", "S/".number_format($after_enero,2));
        $sheet->setCellValue("C{$contador6}", "S/".number_format($after_febrero,2));
        $sheet->setCellValue("D{$contador6}", "S/".number_format($after_marzo,2));
        $sheet->setCellValue("E{$contador6}", "S/".number_format($after_abril,2));
        $sheet->setCellValue("F{$contador6}", "S/".number_format($after_mayo,2));
        $sheet->setCellValue("G{$contador6}", "S/".number_format($after_junio,2));
        $sheet->setCellValue("H{$contador6}", "S/".number_format($after_julio,2));
        $sheet->setCellValue("I{$contador6}", "S/".number_format($after_agosto,2));
        $sheet->setCellValue("J{$contador6}", "S/".number_format($after_septiembre,2));
        $sheet->setCellValue("K{$contador6}", "S/".number_format($after_octubre,2));
        $sheet->setCellValue("L{$contador6}", "S/".number_format($after_noviembre,2));
        $sheet->setCellValue("M{$contador6}", "S/".number_format($after_diciembre,2));
        $sheet->setCellValue("O{$contador6}", "S/".number_format($after_total,2));

        $sheet->setCellValue("B{$contador7}", number_format($diferencia_after_enero,2)."%");
        $sheet->setCellValue("C{$contador7}", number_format($diferencia_after_febrero,2)."%");
        $sheet->setCellValue("D{$contador7}", number_format($diferencia_after_marzo,2)."%");
        $sheet->setCellValue("E{$contador7}", number_format($diferencia_after_abril,2)."%");
        $sheet->setCellValue("F{$contador7}", number_format($diferencia_after_mayo,2)."%");
        $sheet->setCellValue("G{$contador7}", number_format($diferencia_after_junio,2)."%");
        $sheet->setCellValue("H{$contador7}", number_format($diferencia_after_julio,2)."%");
        $sheet->setCellValue("I{$contador7}", number_format($diferencia_after_agosto,2)."%");
        $sheet->setCellValue("J{$contador7}", number_format($diferencia_after_septiembre,2)."%");
        $sheet->setCellValue("K{$contador7}", number_format($diferencia_after_octubre,2)."%");
        $sheet->setCellValue("L{$contador7}", number_format($diferencia_after_noviembre,2)."%");
        $sheet->setCellValue("M{$contador7}", number_format($diferencia_after_diciembre,2)."%");
        $sheet->setCellValue("O{$contador7}", number_format($diferencia_after_total,2)."%");

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //-------------------------------EXCEL BOLETAS---------------------------------------------
    public function Excel_Resumen_Oficial($empresa,$anio, $mes){
        $get_boleta = $this->Admin_model->resumen_boletas_balance_oficial($empresa,$anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Boletas');
        
        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(28);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Fecha Documento');
        $sheet->setCellValue("C1", 'Estado');           
        $sheet->setCellValue("D1", 'Tipo de Pago');
        $sheet->setCellValue("E1", 'Numero de Documento');
        $sheet->setCellValue("F1", 'Apellido Paterno');           
        $sheet->setCellValue("G1", 'Apellido Materno');
        $sheet->setCellValue("H1", 'Nombre');           
        $sheet->setCellValue("I1", 'Código');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Articulo');           
        $sheet->setCellValue("L1", 'Descripción');
        $sheet->setCellValue("M1", 'Estado');
        $sheet->setCellValue("N1", 'Comunicado SUNAT');

        $contador=1;

        foreach($get_boleta as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['Tipo_Comprobante']);
            if ($list['Fecha_Doc']!='00/00/0000'){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['Fecha_Doc']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['Estado_Pago']);
            $sheet->setCellValue("D{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("E{$contador}", $list['Nro_Doc']);
            $sheet->setCellValue("F{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("G{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("H{$contador}", $list['FirstName']);
            $sheet->setCellValue("I{$contador}", $list['InternalStudentId']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Name']);
            $sheet->setCellValue("L{$contador}", $list['Description']);
            
            $sheet->setCellValue("M{$contador}", $list['Estado']);
            $sheet->setCellValue("N{$contador}", "VERDADERO");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Boletas)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------EXCEL CUENTAS POR COBRAR---------------------------------------------
    public function Excel_Resumen_Oficial_CC($empresa,$anio, $mes){ 
        $get_boleta = $this->Admin_model->resumen_cuentas_por_cobrar_balance_oficial($empresa,$anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cuentas por Cobrar');
        
        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Fecha Documento');
        $sheet->setCellValue("C1", 'Estado');           
        $sheet->setCellValue("D1", 'Tipo de Pago');
        $sheet->setCellValue("E1", 'Numero de Documento');
        $sheet->setCellValue("F1", 'Apellido Paterno');           
        $sheet->setCellValue("G1", 'Apellido Materno');
        $sheet->setCellValue("H1", 'Nombre');           
        $sheet->setCellValue("I1", 'Código');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Articulo');           
        $sheet->setCellValue("L1", 'Descripción');
        $sheet->setCellValue("M1", 'Estado');
        $sheet->setCellValue("N1", 'Comunicado SUNAT');

        $contador=1;

        foreach($get_boleta as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['Tipo_Comprobante']);
            if ($list['Fecha_Doc']!='00/00/0000'){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['Fecha_Doc']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['Estado_Pago']);
            $sheet->setCellValue("D{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("E{$contador}", $list['Nro_Doc']);
            $sheet->setCellValue("F{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("G{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("H{$contador}", $list['FirstName']);
            $sheet->setCellValue("I{$contador}", $list['InternalStudentId']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Name']);
            $sheet->setCellValue("L{$contador}", $list['Description']);
            
            $sheet->setCellValue("M{$contador}", $list['Estado']);
            $sheet->setCellValue("N{$contador}", "VERDADERO");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Cuentas por Cobrar)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------EXCEL NOTA DE DÉBITO---------------------------------------------
    public function Excel_Resumen_Oficial_ND($empresa,$anio, $mes){
        $get_boleta = $this->Admin_model->resumen_notas_debito_balance_oficial($empresa,$anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Notas de Débito');
        
        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(28);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Tipo de Pago');           
        $sheet->setCellValue("D1", 'Apellido Paterno');
        $sheet->setCellValue("E1", 'Apellido Materno');
        $sheet->setCellValue("F1", 'Nombre');           
        $sheet->setCellValue("G1", 'Código');
        $sheet->setCellValue("H1", 'Tipo');           
        $sheet->setCellValue("I1", 'Descripción');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Número de Nota Débito');           
        $sheet->setCellValue("L1", 'Estado');
        $sheet->setCellValue("M1", 'Empresa');
        $sheet->setCellValue("N1", 'Documento');
        $sheet->setCellValue("O1", 'Comunicado SUNAT');

        $contador=1;

        foreach($get_boleta as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['Tipo_Comprobante']);
            if ($list['Fecha_Doc']!='00/00/0000'){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['Fecha_Doc']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("D{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("E{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("F{$contador}", $list['FirstName']);
            $sheet->setCellValue("G{$contador}", $list['Codigo']);
            $sheet->setCellValue("H{$contador}", $list['Tipo']);
            $sheet->setCellValue("I{$contador}", $list['Description']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Nro_Doc']);
            $sheet->setCellValue("L{$contador}", $list['Estado']);
            $sheet->setCellValue("M{$contador}", $list['Empresa']);
            $sheet->setCellValue("N{$contador}", $list['Doc_Afect']);
            $sheet->setCellValue("O{$contador}", "VERDADERO");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Notas de Débito)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //-------------------------------EXCEL NOTA DE CRÉDITO---------------------------------------------
    public function Excel_Resumen_Oficial_NC($empresa,$anio, $mes){
        $get_boleta = $this->Admin_model->resumen_notas_credito_balance_oficial($empresa,$anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Notas de Crédito');
        
        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(28);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Tipo de Pago');           
        $sheet->setCellValue("D1", 'Apellido Paterno');
        $sheet->setCellValue("E1", 'Apellido Materno');
        $sheet->setCellValue("F1", 'Nombre');           
        $sheet->setCellValue("G1", 'Código');
        $sheet->setCellValue("H1", 'Tipo');           
        $sheet->setCellValue("I1", 'Descripción');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Número de Nota Crédito');           
        $sheet->setCellValue("L1", 'Estado');
        $sheet->setCellValue("M1", 'Empresa');
        $sheet->setCellValue("N1", 'Documento');
        $sheet->setCellValue("O1", 'Comunicado SUNAT');

        $contador=1;

        foreach($get_boleta as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['Tipo_Comprobante']);
            if ($list['Fecha_Doc']!='00/00/0000'){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['Fecha_Doc']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("D{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("E{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("F{$contador}", $list['FirstName']);
            $sheet->setCellValue("G{$contador}", $list['Codigo']);
            $sheet->setCellValue("H{$contador}", $list['Tipo']);
            $sheet->setCellValue("I{$contador}", $list['Description']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Nro_Doc']);
            $sheet->setCellValue("L{$contador}", $list['Estado']);
            $sheet->setCellValue("M{$contador}", $list['Empresa']);
            $sheet->setCellValue("N{$contador}", $list['Doc_Afect']);
            $sheet->setCellValue("O{$contador}", "VERDADERO");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Notas de Crédito)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------EXCEL BOLETAS---------------------------------------------
    public function Excel_Resumen_Oficial_FT($empresa,$anio, $mes){
        $get_boleta = $this->Admin_model->resumen_facturas_balance_oficial($empresa,$anio,$mes);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Facturas Balance Oficial');
        
        $sheet->setAutoFilter('A1:Q1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(28);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Fecha Documento');
        $sheet->setCellValue("C1", 'Estado');           
        $sheet->setCellValue("D1", 'Tipo de Pago');
        $sheet->setCellValue("E1", 'Numero de Documento');
        $sheet->setCellValue("F1", 'Apellido Paterno');           
        $sheet->setCellValue("G1", 'Apellido Materno');
        $sheet->setCellValue("H1", 'Nombre');           
        $sheet->setCellValue("I1", 'Código');
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Articulo');           
        $sheet->setCellValue("L1", 'Descripción');
        $sheet->setCellValue("M1", 'Estado');
        $sheet->setCellValue("N1", 'Razón Social');           
        $sheet->setCellValue("O1", 'RUC');
        $sheet->setCellValue("P1", 'Dirección');
        $sheet->setCellValue("Q1", 'Comunicado SUNAT');

        $contador=1;

        foreach($get_boleta as $list){
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;

            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A{$contador}", $list['Tipo_Comprobante']);
            if ($list['Fecha_Doc']!='00/00/0000'){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['Fecha_Doc']));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("B{$contador}", "");
            }
            $sheet->setCellValue("C{$contador}", $list['Estado_Pago']);
            $sheet->setCellValue("D{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("E{$contador}", $list['Nro_Doc']);
            $sheet->setCellValue("F{$contador}", $list['FatherSurname']);
            $sheet->setCellValue("G{$contador}", $list['MotherSurname']);
            $sheet->setCellValue("H{$contador}", $list['FirstName']);
            $sheet->setCellValue("I{$contador}", $list['InternalStudentId']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Name']);
            $sheet->setCellValue("L{$contador}", $list['Description']);
            $sheet->setCellValue("M{$contador}", $list['Estado']);
            $sheet->setCellValue("N{$contador}", $list['Razon_Social']);
            $sheet->setCellValue("O{$contador}", $list['RUC']);
            $sheet->setCellValue("P{$contador}", $list['Direccion']);
            $sheet->setCellValue("Q{$contador}", "VERDADERO");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Balance Oficial (Facturas)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //-------------------------------INFORME SUNAT---------------------------------------------
    public function Informe_Sunat() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_empresam'] = $this->Admin_model->get_list_empresa_sunat();
            $dato['list_anios'] = $this->Model_snappy->get_list_anio();

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

            $this->load->view('administrador/informe_sunat/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Informe_Sunat() {
        if ($this->session->userdata('usuario')) { 
            $array= explode("_",$this->input->post("cod_empresa"));
            $id_empresa=$array[0];
            $dato['cod_empresa']= $array[1];
            $dato['nom_anio']= $this->input->post("nom_anio");
            $subrubro= $this->Admin_model->get_list_subrubro_informe_sunat($id_empresa);
            if(count($subrubro)>0){
                $i= 0;
                $consulta_subrubro= "";
                while($i<count($subrubro)){
                    $consulta_subrubro=$consulta_subrubro.$subrubro[$i]['id_subrubro'].",";
                    $i++;
                }
                $dato['consulta_subrubro']=substr($consulta_subrubro,0,-1);
                $dato['list_informe'] = $this->Admin_model->get_list_informe_gastos_sunat($dato);
                $this->load->view('administrador/informe_sunat/lista',$dato);
            }else{
                echo "error";
            }
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Reenviar_Informe_Sunat(){
        if ($this->session->userdata('usuario')) {
            $dato['list_c_empresa'] = $this->Admin_model->get_list_empresa_sunat();
            $dato['list_mes'] = $this->Admin_model->get_list_mes_general();
            $dato['list_anio'] = $this->Admin_model->get_list_anio_general();
            $this->load->view('administrador/informe_sunat/modal_reenvio',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Reenviar_Informe_Sunat(){  
        if ($this->session->userdata('usuario')) {
            $id_empresa= $this->input->post("id_empresa_r");
            $id_mes= $this->input->post("id_mes_r");
            $anio= $this->input->post("id_anio_r");

            $get_mes = $this->Admin_model->get_list_mes_general($id_mes);
            $get_empresa = $this->Admin_model->get_id_empresa($id_empresa);
            $cod_empresa = $get_empresa[0]['cod_empresa'];
            $get_boletas_cobradas = $this->Admin_model->get_informe_sunat_boletas_cobradas($cod_empresa,$id_mes,$anio);
            $get_boletas_por_cobrar = $this->Admin_model->get_informe_sunat_boletas_por_cobrar($cod_empresa,$id_mes,$anio);
            $get_facturas = $this->Admin_model->get_informe_sunat_facturas($cod_empresa,$id_mes,$anio);
            $get_notas_debito = $this->Admin_model->get_informe_sunat_notas_debito($cod_empresa,$id_mes,$anio);
            $get_notas_credito = $this->Admin_model->get_informe_sunat_notas_credito($cod_empresa,$id_mes,$anio);
            $list_gastos = $this->Admin_model->get_informe_sunat_list_gastos($cod_empresa,$id_mes,$anio);

            $cadena = '<table width="20%">';
            foreach($list_gastos as $list){
                $cadena = $cadena.'<tr><td>'.$list['Description'].':</td><td style="text-align:center;">'.$list['cantidad'].'</td><td style="text-align:right;">s/ '.number_format($list['monto'],2).'</td></tr>';
            }
            $cadena = $cadena.'</table>';

            $mail = new PHPMailer(true);
            
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'noreply@gllg.edu.pe';                     // usuario de acceso
                $mail->Password   = 'tqaifaesxsuvpnwt';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreply@snappy.org.pe', 'GLLG'); //desde donde se envia
                
                //$mail->addAddress('dcontabilidad@gllg.edu.pe');
                $mail->addAddress('daniel11143118@gmail.com');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = 'Reporte Mensual - '.$get_empresa[0]['cod_empresa'];

                $mail->Body =  '<FONT SIZE=2>
                                    ¡Hola!<br><br>
                                    Adjunto resumen a la fecha.<br><br>
                                    <b>'.$get_mes[0]['nom_mes'].' '.$anio.'</b><br>
                                    <table width="15%">
                                        <tr>
                                            <td>Empresa:</td>
                                            <td>'.$get_empresa[0]['nom_empresa'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Ruc:</td>
                                            <td>'.$get_empresa[0]['ruc_empresa'].'</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <b>Documentos Sunat</b><br>
                                    <table width="20%">
                                        <tr>
                                            <td>Boletas (cobradas):</td>
                                            <td style="text-align:center;">'.$get_boletas_cobradas[0]['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_boletas_cobradas[0]['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Boletas (por cobrar):</td>
                                            <td style="text-align:center;">'.$get_boletas_por_cobrar[0]['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_boletas_por_cobrar[0]['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Facturas:</td>
                                            <td style="text-align:center;">'.$get_facturas[0]['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_facturas[0]['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Notas de Débito:</td>
                                            <td style="text-align:center;">'.$get_notas_debito[0]['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_notas_debito[0]['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Notas de Crédito:</td>
                                            <td style="text-align:center;">'.$get_notas_credito[0]['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_notas_credito[0]['total'],2).'</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <b>Gastos Sunat</b><br>
                                    '.$cadena.'
                                    <br>
                                    Revisar montos antes de reenvíar a estudio contable.<br>
                                    Gracias.
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

    public function Excel_Informe_Sunat($cod_empresa,$nom_anio){
        $array= explode("_",$cod_empresa);
        $id_empresa=$array[0];
        $dato['cod_empresa']= $array[1];
        $dato['nom_anio']= $nom_anio;
        $subrubro= $this->Admin_model->get_list_subrubro_informe_sunat($id_empresa);

        $empresa = $this->Admin_model->get_id_empresa($id_empresa);
        $cod_empresa = $empresa[0]['cd_empresa'];

        if(count($subrubro)>0){
            $i= 0;
            $consulta_subrubro= "";
            while($i<count($subrubro)){
                $consulta_subrubro=$consulta_subrubro.$subrubro[$i]['id_subrubro'].",";
                $i++;
            }
            $dato['consulta_subrubro']=substr($consulta_subrubro,0,-1);
            $dato['list_informe'] = $this->Admin_model->get_list_informe_gastos_sunat($dato);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->getStyle("A1:Q1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:Q1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Informe Sunat');
    
            $sheet->setAutoFilter('A1:Q1');
    
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(10);
            $sheet->getColumnDimension('C')->setWidth(22);
            $sheet->getColumnDimension('D')->setWidth(28);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(15);
            $sheet->getColumnDimension('Q')->setWidth(15);
    
            $sheet->getStyle('A1:Q1')->getFont()->getColor()->setRGB('FFFFFF');
    
            $spreadsheet->getActiveSheet()->getStyle("A1:Q1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('7A7A7A');
    
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
    
            $sheet->getStyle("A1:Q1")->applyFromArray($styleThinBlackBorderOutline);
    
            $sheet->setCellValue("A1", 'Empresa');
            $sheet->setCellValue("B1", 'Año');      
            $sheet->setCellValue("C1", 'Rubro');
            $sheet->setCellValue("D1", 'Subrubro');           
            $sheet->setCellValue("E1", 'Enero');
            $sheet->setCellValue("F1", 'Febrero');
            $sheet->setCellValue("G1", 'Marzo');           
            $sheet->setCellValue("H1", 'Abril');
            $sheet->setCellValue("I1", 'Mayo');
            $sheet->setCellValue("J1", 'Junio');           
            $sheet->setCellValue("K1", 'Julio');
            $sheet->setCellValue("L1", 'Agosto');           
            $sheet->setCellValue("M1", 'Septiembre');
            $sheet->setCellValue("N1", 'Octubre');
            $sheet->setCellValue("O1", 'Noviembre');           
            $sheet->setCellValue("P1", 'Diciembre');
            $sheet->setCellValue("Q1", 'Total');
    
            $contador=1;
            
            foreach($dato['list_informe'] as $list){
                $contador++;
                
                $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("C{$contador}:Q{$contador}")->getNumberFormat()->setFormatCode('0.00');
    
                if($list['Enero']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("E{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Febrero']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("F{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Marzo']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("G{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Abril']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("H{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Mayo']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("I{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Junio']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("J{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Julio']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("K{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Agosto']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("L{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Septiembre']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("M{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Octubre']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("N{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Noviembre']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("O{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                if($list['Diciembre']==0){ 
                    $spreadsheet->getActiveSheet()->getStyle("P{$contador}")->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE1E2');
                }
                        
                $sheet->setCellValue("A{$contador}", $cod_empresa);
                $sheet->setCellValue("B{$contador}", $nom_anio);
                $sheet->setCellValue("C{$contador}", $list['Rubro']);   
                $sheet->setCellValue("D{$contador}", $list['Subrubro']);   
                $sheet->setCellValue("E{$contador}", "S/ ".$list['Enero']);
                $sheet->setCellValue("F{$contador}", "S/ ".$list['Febrero']);
                $sheet->setCellValue("G{$contador}", "S/ ".$list['Marzo']);           
                $sheet->setCellValue("H{$contador}", "S/ ".$list['Abril']);
                $sheet->setCellValue("I{$contador}", "S/ ".$list['Mayo']);
                $sheet->setCellValue("J{$contador}", "S/ ".$list['Junio']);           
                $sheet->setCellValue("K{$contador}", "S/ ".$list['Julio']);
                $sheet->setCellValue("L{$contador}", "S/ ".$list['Agosto']);           
                $sheet->setCellValue("M{$contador}", "S/ ".$list['Septiembre']);
                $sheet->setCellValue("N{$contador}", "S/ ".$list['Octubre']);
                $sheet->setCellValue("O{$contador}", "S/ ".$list['Noviembre']);           
                $sheet->setCellValue("P{$contador}", "S/ ".$list['Diciembre']);
                $sheet->setCellValue("Q{$contador}", "S/ ".$list['Total']);
            }
    
            $writer = new Xlsx($spreadsheet);
            $filename = 'Gastos SUNAT - Informes (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }else{
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->setTitle('Informe Sunat');

            $writer = new Xlsx($spreadsheet);
            $filename = 'Gastos SUNAT - Informes (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output'); 
        }
    }
    //-------------------------------GASTOS SUNAT---------------------------------------------
    public function Gastos_Sunat() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_anio'] =$this->Admin_model->get_list_anio();

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

            $this->load->view('administrador/gastos_sunat/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Lista_Gastos_Sunat() {
        if ($this->session->userdata('usuario')) { 
            $dato['anio']= $this->input->post("anio");
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_gasto'] = $this->Admin_model->get_list_gastos_sunat(null,$dato['tipo'],$dato['anio']);
            $this->load->view('administrador/gastos_sunat/lista',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Gastos_Sunat($Id){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_gastos_sunat($Id);
            if(count($dato['get_id'])>0){ 
                $dato['validar']=1;
            }else{
                $dato['validar']=0;
            }
            $dato['get_gasto'] = $this->Admin_model->get_list_gastos_sunat($Id,null,null);
            $dato['get_ruc'] = $this->Admin_model->get_ruc_beneficiario();
            //DATOS DE SUBRUBRO
            $obliga=$this->Admin_model->valida_subrubro($dato['get_gasto'][0]['CostTypeId']);
            $dato['obliga_documento'] = $obliga[0]['obliga_documento'];
            $dato['ruc_subrubro'] = $obliga[0]['ruc'];
            $this->load->view('administrador/gastos_sunat/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Gastos_Sunat(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_gasto']= $this->input->post("id_gasto");
            $dato['id']= $this->input->post("id");
            $dato['fecha_pago']= $this->input->post("fecha_pago");
            $dato['ruc_beneficiario']= $this->input->post("ruc_beneficiario");
            $dato['validar_documento']= $this->input->post("validar_documento");
            $dato['no_declarado']= $this->input->post("no_declarado");

            if($dato['id_gasto']==NULL){
                $dato['documento'] = "";

                if($_FILES["documento"]["name"] != ""){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento"]["name"]);
                    $config['upload_path'] = './documento_gastos_sunat/'.$dato['id'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_gastos_sunat/', 0777);
                        chmod('./documento_gastos_sunat/'.$dato['id'], 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento"]["name"];
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = "documento_gastos_sunat/".$dato['id']."/".$dato['nom_documento'];
                    }     
                }

                $this->Admin_model->insert_gastos_sunat($dato);
            }else{
                $dato['documento']= $this->input->post("documento_actual"); 

                if($_FILES["documento"]["name"] != ""){
                    if (file_exists($dato['documento'])) { 
                        unlink($dato['documento']);
                    }
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento"]["name"]);
                    $config['upload_path'] = './documento_gastos_sunat/'.$dato['id'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./documento_gastos_sunat/', 0777);
                        chmod('./documento_gastos_sunat/'.$dato['id'], 0777);
                    }
                    $config["allowed_types"] = 'jpeg|png|jpg|pdf';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento"]["name"];
                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = "documento_gastos_sunat/".$dato['id']."/".$dato['nom_documento'];
                    }     
                }

                $this->Admin_model->update_gastos_sunat($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Documento_Gastos_Sunat($id_gasto) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Admin_model->get_id_gastos_sunat($id_gasto);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }
        else{
            redirect('');
        }
    }

    public function Excel_Gastos_Sunat($tipo,$anio){
        $list_gasto = $this->Admin_model->excel_gastos_sunat($tipo,$anio); 
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:AE1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A1:AE1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Gastos Sunat');

        $sheet->setAutoFilter('A1:AE1');

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(35);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(60);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(22);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(18);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(15);
        $sheet->getColumnDimension('W')->setWidth(15);
        $sheet->getColumnDimension('X')->setWidth(18);
        $sheet->getColumnDimension('Y')->setWidth(15);
        $sheet->getColumnDimension('Z')->setWidth(15);
        $sheet->getColumnDimension('AA')->setWidth(15);
        $sheet->getColumnDimension('AB')->setWidth(12);
        $sheet->getColumnDimension('AC')->setWidth(15);
        $sheet->getColumnDimension('AD')->setWidth(12);
        $sheet->getColumnDimension('AE')->setWidth(15);

        $sheet->getStyle('A1:AE1')->getFont()->getColor()->setRGB('FFFFFF');

        $spreadsheet->getActiveSheet()->getStyle("A1:AE1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('7A7A7A');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:AE1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Id');           
        $sheet->setCellValue("B1", 'Gasto (Mes/Año)');
        $sheet->setCellValue("C1", 'Pedido');
        $sheet->setCellValue("D1", 'Tipo');           
        $sheet->setCellValue("E1", 'Empresa que Factura');
        $sheet->setCellValue("F1", 'Gasto Empresa');
        $sheet->setCellValue("G1", 'Rubro');           
        $sheet->setCellValue("H1", 'Subrubro');
        $sheet->setCellValue("I1", 'Descripción');           
        $sheet->setCellValue("J1", 'Monto');
        $sheet->setCellValue("K1", 'Tipo Solicitante');
        $sheet->setCellValue("L1", 'Solicitante');           
        $sheet->setCellValue("M1", 'Estado');
        $sheet->setCellValue("N1", 'Aprobado Por Usuario');
        $sheet->setCellValue("O1", 'Fecha Entrega Monto');           
        $sheet->setCellValue("P1", 'Tipo Documento');
        $sheet->setCellValue("Q1", 'Fecha Documento');
        $sheet->setCellValue("R1", 'Numero Recibo');           
        $sheet->setCellValue("S1", 'Tipo de Pago');
        $sheet->setCellValue("T1", 'Cuenta Bancaria');
        $sheet->setCellValue("U1", 'Fecha Pago Banco');           
        $sheet->setCellValue("V1", 'RUC Beneficiario');
        $sheet->setCellValue("W1", 'Documento');           
        $sheet->setCellValue("X1", 'Caja');
        $sheet->setCellValue("Y1", 'Sin Contabilizar');
        $sheet->setCellValue("Z1", 'Total Asignado Centro Costo');           
        $sheet->setCellValue("AA1", 'Centro Costo Asignado');
        $sheet->setCellValue("AB1", 'Revisado');
        $sheet->setCellValue("AC1", 'Gasto Deducible');
        $sheet->setCellValue("AD1", 'Empresa');
        $sheet->setCellValue("AE1", 'Declarado');

        $contador=1;

        foreach($list_gasto as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:AE{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:AE{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:AE{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("K{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("S{$contador}:Y{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AB{$contador}:AE{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AE{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); 

            $sheet->setCellValue("A{$contador}", $list['Id']);
            $sheet->setCellValue("B{$contador}", $list['Mes_Anio']);
            $sheet->setCellValue("C{$contador}", $list['Pedido']);
            $sheet->setCellValue("D{$contador}", $list['Tipo']);
            $sheet->setCellValue("E{$contador}", $list['Empresa_Factura']);
            $sheet->setCellValue("F{$contador}", $list['Gasto_Empresa']);
            $sheet->setCellValue("G{$contador}", $list['Rubro']);
            $sheet->setCellValue("H{$contador}", $list['Subrubro']);
            $sheet->setCellValue("I{$contador}", $list['Descripcion']);
            $sheet->setCellValue("J{$contador}", $list['Monto']);
            $sheet->setCellValue("K{$contador}", $list['Tipo_Solicitante']);
            $sheet->setCellValue("L{$contador}", $list['Solicitante']);
            $sheet->setCellValue("M{$contador}", $list['Estado']);
            $sheet->setCellValue("N{$contador}", $list['Aprobado_Por']);
            $sheet->setCellValue("O{$contador}", Date::PHPToExcel($list['Fecha_Entrega']));
            $sheet->getStyle("O{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("P{$contador}", $list['Tipo_Documento']);
            $sheet->setCellValue("Q{$contador}", Date::PHPToExcel($list['Fecha_Documento']));
            $sheet->getStyle("Q{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("R{$contador}", $list['Numero_Recibo']);
            $sheet->setCellValue("S{$contador}", $list['Tipo_Pago']);
            $sheet->setCellValue("T{$contador}", $list['Cuenta_Bancaria']);
            if($list['Fecha_Pago']==""){
                $sheet->setCellValue("U{$contador}", "");
            }else{
                $sheet->setCellValue("U{$contador}", Date::PHPToExcel($list['Fecha_Pago']));
                $sheet->getStyle("U{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("V{$contador}", $list['Ruc_Beneficiario']);
            $sheet->setCellValue("W{$contador}", $list['Documento']);
            $sheet->setCellValue("X{$contador}", $list['Caja']);
            $sheet->setCellValue("Y{$contador}", $list['Sin_Contabilizar']);
            $sheet->setCellValue("Z{$contador}", $list['Total_Asignado']);
            $sheet->setCellValue("AA{$contador}", $list['Centro_Costo']);
            $sheet->setCellValue("AB{$contador}", $list['Revisado']);
            $sheet->setCellValue("AC{$contador}", $list['Gasto_Deducible']);
            $sheet->setCellValue("AD{$contador}", $list['Empresa']);
            $sheet->setCellValue("AE{$contador}", $list['v_no_declarado']);
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'Gastos Totales (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-------------------------------RUBROS---------------------------------------------
    public function Rubro() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_rubro'] = $this->Admin_model->get_list_rubro();

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

            $this->load->view('administrador/rubro/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Excel_Rubro(){
        $list_rubro = $this->Admin_model->get_list_rubro();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Rubros');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);

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
        $sheet->setCellValue("B1", 'Status'); 

        $contador=1;
        
        foreach($list_rubro as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['Name']);
            $sheet->setCellValue("B{$contador}", $list['Description']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rubro (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------SUBRUBROS-------------------------------------
    public function Subrubro() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_subrubro'] = $this->Admin_model->get_list_subrubro();
            $dato['subrubro'] = $this->Admin_model->get_id_subrubro();
            $dato['tipo_documento'] = $this->Admin_model->get_list_tipo_documento();
            $dato['combo_empresa'] = $this->Admin_model->get_list_empresa_subrubro();
            
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

            $this->load->view('administrador/subrubro/index',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Subrubro($id_subrubro){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_id_subrubro($id_subrubro);
            if(count($dato['get_id'])>0){
                $dato['validar']=1;
            }else{
                $dato['validar']=0;
            }
            $dato['get_subrubro'] = $this->Admin_model->get_list_subrubro($id_subrubro);
            $dato['list_rubro'] = $this->Admin_model->get_list_rubro();
            $dato['combo_empresa'] = $this->Admin_model->get_list_empresa_subrubro();
            $dato['list_estado'] = $this->Admin_model->get_list_estado_sql();
            $dato['list_tipo_documento'] = $this->Admin_model->get_list_tipo_documento();
            $this->load->view('administrador/subrubro/modal_editar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Subrubro(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_subrubro']= $this->input->post("id_subrubro");
            $dato['id']= $this->input->post("id");
            $dato['obliga_documento']= $this->input->post("obliga_documento");
            $dato['informe']= $this->input->post("informe");
            $dato['obliga_datos']= $this->input->post("obliga_datos");
            $dato['ruc']= $this->input->post("ruc");
            if($this->input->post("id_empresa")==""){
                $dato['id_empresa']= 99;
            }else{
                $dato['id_empresa']= implode(",",$this->input->post("id_empresa"));
            }
            if($this->input->post("id_tipo_documento")==""){
                $dato['id_tipo_documento']= 99;
            }else{
                $dato['id_tipo_documento']= implode(",",$this->input->post("id_tipo_documento"));
            }

            if($dato['id_subrubro']==NULL){
                $this->Admin_model->insert_subrubro($dato);
            }else{
                $this->Admin_model->update_subrubro($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Subrubro(){
        $list_subrubro = $this->Admin_model->get_list_subrubro();
        $subrubro = $this->Admin_model->get_id_subrubro();
        $tipo_documento = $this->Admin_model->get_list_tipo_documento();
        $combo_empresa = $this->Admin_model->get_list_empresa_subrubro();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Rubros');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Rubro');             
        $sheet->setCellValue("B1", 'Sub-Rubro');
        $sheet->setCellValue("C1", 'Empresa(s)');
        $sheet->setCellValue("D1", 'Tipo Documento(s)');
        $sheet->setCellValue("E1", 'Obliga Doc.'); 
        $sheet->setCellValue("F1", 'Informe'); 
        $sheet->setCellValue("G1", 'Obliga Datos');
        $sheet->setCellValue("H1", 'RUC');
        $sheet->setCellValue("I1", 'Status'); 

        $contador=1;
        
        foreach($list_subrubro as $list){
            $contador++;

            $empresa="";
            $obliga_documento="";
            $informe="";
            $nom_tipo_documento="";
            $obliga_datos="";
            $ruc="";
            $busqueda_subrubro=in_array($list['Id'],array_column($subrubro,'id_subrubro'));
            if($busqueda_subrubro!=false){
                $posicion=array_search($list['Id'],array_column($subrubro,'id_subrubro'));

                if($subrubro[$posicion]['id_empresa']!=99){
                    $cantidad_empresa=explode(",",$subrubro[$posicion]['id_empresa']);
                    $i=0;
                    $parte_empresa="";
                    while($i<count($cantidad_empresa)){
                        $posicion_empresa=array_search($cantidad_empresa[$i],array_column($combo_empresa,'id_empresa'));
                        $parte_empresa=$parte_empresa.$combo_empresa[$posicion_empresa]['cd_empresa'].",";
                        $i++;
                    }
                    $empresa=substr($parte_empresa,0,-1);
                }

                if($subrubro[$posicion]['obliga_documento']==1){
                    $obliga_documento="SI";
                }else{
                    $obliga_documento="NO";
                }

                if($subrubro[$posicion]['informe']==1){
                    $informe="SI";
                }else{
                    $informe="NO";
                }

                if($subrubro[$posicion]['obliga_datos']==1){
                    $obliga_datos="SI";
                }else{
                    $obliga_datos="NO";
                }

                if($subrubro[$posicion]['ruc']!=""){
                    $ruc=$subrubro[$posicion]['ruc'];
                }

                if($subrubro[$posicion]['id_tipo_documento']!=99){
                    $cantidad_tipo_documento=explode(",",$subrubro[$posicion]['id_tipo_documento']);
                    $i=0;
                    $parte_tipo_documento="";
                    while($i<count($cantidad_tipo_documento)){
                        $posicion_tipo_documento=array_search($cantidad_tipo_documento[$i],array_column($tipo_documento,'ReceiptTypeId'));
                        $parte_tipo_documento=$parte_tipo_documento.$tipo_documento[$posicion_tipo_documento]['Description'].",";
                        $i++;
                    }
                    $nom_tipo_documento=substr($parte_tipo_documento,0,-1);

                }
            }

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['Rubro']);
            $sheet->setCellValue("B{$contador}", $list['Name']);
            $sheet->setCellValue("C{$contador}", $empresa);
            $sheet->setCellValue("D{$contador}", $nom_tipo_documento);
            $sheet->setCellValue("E{$contador}", $obliga_documento);
            $sheet->setCellValue("F{$contador}", $informe);
            $sheet->setCellValue("G{$contador}", $obliga_datos);
            $sheet->setCellValue("H{$contador}", $ruc);
            $sheet->setCellValue("I{$contador}", $list['Description']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Subrubro (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function BD_Alumnos(){
        if ($this->session->userdata('usuario')) {
            $parametro=0;
            $dato['parametro']=0;

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

            $this->load->view('administrador/alumno_bd/index', $dato);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Busqueda_SAsignar(){
        if ($this->session->userdata('usuario')) {
            
            $dato['list_empresam']=$this->Admin_model->list_empresa_informebd();
            $dato['list_sedem']=$this->Admin_model->list_sede_informebd();
            $data=$this->Admin_model->list_sede_activos();
            $dato['sedes']=$data[0]['cadena'];

            $parametro= $this->input->post("parametro");
            $dato['parametro']= $this->input->post("parametro");
            if($parametro==1){
                $dato['list_alumno']=$this->Admin_model->list_alumno_asignados_general();
                $this->load->view('administrador/alumno_bd/busqueda_asignados', $dato);
            }else{
                $dato['list_alumno']=$this->Admin_model->list_alumno_temporal($dato);
                
                $this->load->view('administrador/alumno_bd/busqueda', $dato);
            }
            
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Asignar_Folder(){
        if ($this->session->userdata('usuario')) {
            /*$dato['get'] =$this->Admin_model->list_letras_alumno_bd();*/
            $dato['cant'] =$this->Admin_model->cantidad_asignacion_alumnobd();
            $dato['last'] =$this->Admin_model->ultima_cantidad_alumnos_asignados();
            if(count($dato['cant'])>0){
                $dato['tipo']="";
                foreach($dato['cant'] as $c){
                    if($c['cantidad']==25){
                        $dato['tipo']=$dato['tipo'].$c['folder'].",";
                    }
                }
                $dato['nueva_cant']=count($dato['cant'])+1;
                $dato['tipo']=$dato['tipo'].$dato['nueva_cant'].",";
                $dato['nueva_cant']=count($dato['cant'])+2;
                $dato['tipo']=$dato['tipo'].$dato['nueva_cant'].",";
                $dato['nueva_cant']=count($dato['cant'])+3;
                $dato['tipo']=$dato['tipo'].$dato['nueva_cant'].",";
                $dato['nueva_cant']=count($dato['cant'])+4;
                $dato['tipo']=$dato['tipo'].$dato['nueva_cant'].",";
                $dato['nueva_cant']=count($dato['cant'])+5;
                $dato['tipo']=$dato['tipo'].$dato['nueva_cant'];

                $dato['tipo'] = explode(",", $dato['tipo']);

                
            }else{
                $dato['tipo']="1,2,3,4,5";
                $dato['tipo'] = explode(",", $dato['tipo']);
            }
            //$dato['list_tipo'] =$this->Admin_model->get_list_letra_alumnobd($dato);
            $dato['list_sede'] =$this->Admin_model->get_list_sede_alumnobd($dato);
            $this->load->view('administrador/alumno_bd/modal_asignacion',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Asignar_Folder(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anio_f");
            $dato['folder']= $this->input->post("folder_f");
            $dato['tipo_folder']= $this->input->post("tipo_folder_f");
            $dato['id_sede']= $this->input->post("sede_folder_f");
            $id_sede= $this->input->post("sede_folder_f");
            $dato['get_id']=$this->Admin_model->get_id_sede_xid($id_sede);
            $cod_sede=$dato['get_id'][0]['cod_sede'];
            $anio=date('Y');
            $aniof=substr($anio, 2,2);
            
            $count=count($this->Admin_model->valida_asignar_folder($dato));
            if($count>0){
                echo "error";
            }else{
                
                $i=1;
                $b=26;
                foreach ($_POST['id_alumno'] as $list) {
                    if($dato['tipo_folder']=="A"){
                        if($i<10)
                        {
                            $codigo="0000".$i;
                        }if($i>9)
                        {
                            $codigo="000".$i;
                        }
                        $dato['cod_folder']=$cod_sede."-".$anio."-".$i.$dato['tipo_folder'];
                    }else{
                        $codigo="000".$b; 
                        $dato['cod_folder']=$cod_sede."-".$anio."-".$b.$dato['tipo_folder'];
                    }

                    if($i<10){
                        $i="0".$i;
                    }
                    $dato['correlativo']=$codigo;
                    
                    
                    $dato['id_alumno_arpay_temporal'] = $list;
                    /*$id_alumno_arpay_temporal = $list;
                    $separada = explode($separador, $list);
                    $dato['id_alumno'] = $separada[0];
                    $dato['empresa_arpay'] = $separada[1];
                    $dato['alum_apater'] = $separada[2];
                    $dato['alum_amater'] = $separada[3];
                    $dato['alum_nom'] = $separada[4];
                    $dato['dni_alumno'] = $separada[5];
                    $dato['grado'] = $separada[6];
                    $dato['seccion'] = $separada[7];
                    $dato['estado_arpay'] = $separada[8];
                    $dato['codigo'] = $separada[0];*/
                    $this->Admin_model->asignar_folder_bd($dato);
                    $i=$i+1;
                    $b=$b+1;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_VDocumento_Alumno($id_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']=$id_alumno;
            $dato['get_id'] =$this->Admin_model->get_id_alumno_BD($id_alumno);
            
            $this->load->view('administrador/alumno_bd/modal_vdocumento',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Validar_Documentacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_alumno']= $this->input->post("id_alumno");
            $dato['dni']= $this->input->post("dni");
            $dato['certificadoe']= $this->input->post("certificadoe");
            $dato['foto']= $this->input->post("foto");
            $dato['doc']= $this->input->post("doc");
            $this->Admin_model->validar_documentacion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Informe(){
        if ($this->session->userdata('usuario')) {

            $dato['list_informe']=$this->Admin_model->list_informe_alumnos_bd();
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

            $this->load->view('administrador/informe_alumno_bd/index', $dato);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Detalle_Folder($lado,$folder){
        if ($this->session->userdata('usuario')) {

            $dato['folder']=$folder;
            $dato['lado']=$lado;
            $dato['list_detalle']=$this->Admin_model->list_detalle_folder($lado,$folder);
            //AVISO NO BORRAR
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);

            $this->load->view('administrador/informe_alumno_bd/detalle_folder', $dato);
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Excel_Alumno_BD($parametro){
        if ($this->session->userdata('usuario')) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Base de Datos - Alumnos');

            $sheet->setAutoFilter('A1:N1');

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(27);
            $sheet->getColumnDimension('G')->setWidth(16);
            $sheet->getColumnDimension('H')->setWidth(16);
            $sheet->getColumnDimension('I')->setWidth(32);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(6);
            $sheet->getColumnDimension('L')->setWidth(6);
            $sheet->getColumnDimension('M')->setWidth(6);
            $sheet->getColumnDimension('N')->setWidth(6);

            $sheet->getStyle('A1:N1')->getFont()->getColor()->setRGB('FFFFFF');

            $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('7A7A7A');

            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A1", 'Folder');           
            $sheet->setCellValue("B1", 'Sede');
            $sheet->setCellValue("C1", 'Código');
            $sheet->setCellValue("D1", 'A. Paterno');           
            $sheet->setCellValue("E1", 'A. Materno');
            $sheet->setCellValue("F1", 'Nombre');
            $sheet->setCellValue("G1", 'DNI');           
            $sheet->setCellValue("H1", 'Grado/Especialidad');
            $sheet->setCellValue("I1", 'Sección/Grupo');           
            $sheet->setCellValue("J1", 'Estado');
            $sheet->setCellValue("K1", '1');
            $sheet->setCellValue("L1", '2');           
            $sheet->setCellValue("M1", '3');
            $sheet->setCellValue("N1", '4');

            
            $contador=2;
            if($parametro==1){
                $dato['list_alumno']=$this->Admin_model->list_alumno_asignados_general();
                foreach($dato['list_alumno'] as $list){
                    $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    
                    
                    $sheet->setCellValue("A{$contador}", $list['folder']);
                    $sheet->setCellValue("B{$contador}", $list['cod_sede']);
                    
                    
                    $sheet->setCellValue("C{$contador}", $list['codigo']);
                    $sheet->setCellValue("D{$contador}", $list['alum_apater']);
                    $sheet->setCellValue("E{$contador}", $list['alum_amater']);
                    $sheet->setCellValue("F{$contador}", $list['alum_nom']);
                    $sheet->setCellValue("G{$contador}", $list['dni_alumno']);
                    $sheet->setCellValue("H{$contador}", $list['grado']);
                    $sheet->setCellValue("I{$contador}", $list['seccion']);
                    $sheet->setCellValue("J{$contador}", $list['estado_arpay']);
                    
                    $sheet->setCellValue("K{$contador}", $list['v_doc']);
                    $sheet->setCellValue("L{$contador}", $list['v_dni']);
                    $sheet->setCellValue("M{$contador}", $list['v_certificadoe']);
                    $sheet->setCellValue("N{$contador}", $list['v_foto']);
                    
                    
                    $contador++;
                }
            }else{
                $data=$this->Admin_model->list_sede_activos();
                $dato['sedes']=$data[0]['cadena'];
                $dato['list_alumno']=$this->Admin_model->list_alumno_temporal($dato);
                foreach($dato['list_alumno'] as $list){
                    
                    $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                    $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    
                    $sheet->setCellValue("A{$contador}", "");
                    $sheet->setCellValue("B{$contador}", $list['cod_sede']);
                    $sheet->setCellValue("C{$contador}", $list['InternalStudentId']);
                    $sheet->setCellValue("D{$contador}", $list['FatherSurname']);
                    $sheet->setCellValue("E{$contador}", $list['MotherSurname']);
                    $sheet->setCellValue("F{$contador}", $list['FirstName']);
                    $sheet->setCellValue("G{$contador}", $list['IdentityCardNumber']);
                    $sheet->setCellValue("H{$contador}", $list['Grade']);
                    $sheet->setCellValue("I{$contador}", $list['Class']);
                    $sheet->setCellValue("J{$contador}", $list['StudentStatus']);
                    $contador++;
                    
                }
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Alumnos Base Datos (Lista)';
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); 

        }
        else{
            redirect('/login');
        }
    }

    public function Excel_informe_Alumno_BD(){
        if ($this->session->userdata('usuario')) {
            $dato['list_informe']=$this->Admin_model->list_informe_alumnos_bd();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            

            $titulo="Base de Datos - Informe (Lista)";
            $spreadsheet->getActiveSheet()->setTitle($titulo);

            $sheet->setAutoFilter('A1:K1');

            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(8);
            $sheet->getColumnDimension('C')->setWidth(8);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(16);
            $sheet->getColumnDimension('H')->setWidth(7);
            $sheet->getColumnDimension('I')->setWidth(7);
            $sheet->getColumnDimension('J')->setWidth(7);
            $sheet->getColumnDimension('K')->setWidth(7);

            $sheet->getStyle('A1:K1')->getFont()->getColor()->setRGB('FFFFFF');

            $spreadsheet->getActiveSheet()->getStyle("A1:K1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('7A7A7A');

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
            $sheet->setCellValue("C1", 'Año');
            $sheet->setCellValue("D1", 'Folder');           
            $sheet->setCellValue("E1", 'Del');
            $sheet->setCellValue("F1", 'Al');
            $sheet->setCellValue("G1", 'Estado'); 
            $sheet->setCellValue("H1", 'Doc'); 
            $sheet->setCellValue("I1", 'DNI'); 
            $sheet->setCellValue("J1", 'Ces'); 
            $sheet->setCellValue("K1", 'Fto'); 

            
            $contador=2;
            foreach($dato['list_informe'] as $list){
                $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("C{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
                $sheet->setCellValue("B{$contador}", $list['cod_sede']);
                $sheet->setCellValue("C{$contador}", $list['anio']);
                $sheet->setCellValue("D{$contador}", $list['folder']);
                $sheet->setCellValue("E{$contador}", $list['del']);
                $sheet->setCellValue("F{$contador}", $list['al']);
                $sheet->setCellValue("G{$contador}", $list['estado_g']);
                $sheet->setCellValue("H{$contador}", $list['doc']);
                $sheet->setCellValue("I{$contador}", $list['dni']);
                $sheet->setCellValue("J{$contador}", $list['ces']);
                $sheet->setCellValue("K{$contador}", $list['foto']);
                
                $contador++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = $titulo;
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"'); 
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); 

        }
        else{
            redirect('/login');
        }
    }

    public function Pdf_Resumen_Venta($folder,$lado){
        $this->load->library('Pdf');

        $dato['list_detalle']=$this->Admin_model->list_detalle_folder($lado,$folder);
        $dato['get']=$this->Admin_model->list_detalle_folder_primer_ultimo($lado,$folder);
        //$get_id = $this->Model_Mimarli->get_id_venta($id_venta);
        //$list_detalle = $this->Model_Mimarli->get_detalle_venta($id_venta);

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        

        $titulo="Folder ".$folder." - Lado ".$lado;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SNAPPY');
        $pdf->SetTitle($titulo);
        $pdf->SetSubject($titulo);
        $pdf->SetKeywords('SNAPPY, BASE DE DATOS ALUMNO');

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

        // set font
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->SetFillColor(255, 255, 255);

        // add a page
        $pdf->AddPage();

        $y2=25;

        $pdf->SetFont('helvetica','', 14);

        $pdf->SetXY (219, $y2-20);
        $pdf->SetFillColor(252, 228, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(24,2,$dato['get'][0]['primer'],1,0,'C',1);
        $pdf->SetFont('helvetica','B', 25);
        $pdf->SetFillColor(243, 138, 11);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(18,12.3,$folder,1,0,'C',1);
        $pdf->Cell(5,12.3,'',1,0,'C',1);

        $pdf->SetFont('helvetica','', 14);
        $pdf->SetFillColor(242, 242, 242);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(10,12.3,$lado,1,1,'C',1);

        $pdf->SetXY (260, $y2-7.7);
        
        $pdf->StartTransform();
        $pdf->SetFont('helvetica','B', 10);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Rotate(90);
        $pdf->Cell(12.3,7,$dato['get'][0]['cod_sede'],1,0,'C',1);
        $pdf->StopTransform();

        $pdf->SetXY (219, $y2-14);
        $pdf->SetFont('helvetica','', 14);
        $pdf->SetFillColor(252, 228, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(24,4,$dato['get'][0]['ultimo'],1,0,'C',1);
        /* */

        $y3=80;
        $pdf->SetXY (25, $y3);
        $pdf->SetFillColor(243, 138, 11);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('helvetica','B', 25);
        $pdf->Cell(20,12.3,$folder,1,1,'C',1);

        
        $pdf->SetFillColor(242, 242, 242);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY (25, $y3+12.3);
        $pdf->SetFont('helvetica','B', 14);
        $pdf->Cell(20,8,$lado,1,1,'C',1);
        
        $pdf->SetXY (25, $y3+44.3);
        $pdf->SetFillColor(252, 228, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->StartTransform();
        $pdf->SetFont('helvetica','', 14);
        $pdf->Rotate(90);
        $pdf->Cell(24,10,$dato['get'][0]['primer'],1,1,'C',1);
        $pdf->SetXY (25, $y3+54.3);
        $pdf->Cell(24,10,$dato['get'][0]['ultimo'],1,0,'C',1);
        $pdf->StopTransform();

        $pdf->SetXY (25, $y3+44);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('helvetica','B', 10);
        $pdf->Cell(20,8.3,$dato['get'][0]['cod_sede'],1,1,'C',1);

        $pdf->SetFillColor(190,190,190);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetXY (55, $y2+4);
        $pdf->SetFont('helvetica', 'B', 9);

        $pdf->Cell(13,6,'Código',1,0,'C',1);
        $pdf->Cell(30,6,'Apellido Paterno',1,0,'C',1);
        $pdf->Cell(30,6,'Apellido Materno',1,0,'C',1);
        $pdf->Cell(35,6,'Nombres',1,0,'C',1);
        $pdf->Cell(30,6,'Carrera',1,0,'C',1);
        $pdf->Cell(25,6,'Grupo',1,0,'C',1);
        $pdf->Cell(25,6,'Estado',1,0,'C',1);
        $pdf->Cell(8,6,'Doc',1,0,'C',1);
        $pdf->Cell(8,6,'DNI',1,0,'C',1);
        $pdf->Cell(8,6,'Cert',1,0,'C',1);
        $pdf->Cell(8,6,'Foto',1,0,'C',1);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('helvetica', '', 9);

        $linea=$y2+10;
        $total=0;
        //$contador=1;

        foreach($dato['list_detalle'] as $list){
            
            $pdf->SetXY (55, $linea);
            $pdf->Cell (13,6,$list['correlativo'],1,0,'C',1);
            $pdf->Cell (30,6,$list['alum_apater'],1,0,'L',1);
            $pdf->Cell (30,6,$list['alum_amater'],1,0,'L',1);
            $pdf->Cell (35,6,$list['alum_nom'],1,0,'L',1);
            $pdf->Cell (30,6,$list['grado'],1,0,'L',1);
            $pdf->Cell (25,6,$list['seccion'],1,0,'L',1);
            $pdf->Cell (25,6,$list['estado_arpay'],1,0,'L',1);
            //$pdf->Cell (8,6,$list['estado_arpay'],1,0,'L',1);
            $pdf->Cell (8,6,$list['doc'],1,0,'L',1);
            $pdf->Cell (8,6,$list['dni'],1,0,'L',1);
            $pdf->Cell (8,6,$list['certificado'],1,0,'L',1);
            $pdf->Cell (8,6,$list['cfoto'],1,0,'L',1);
            //$pdf->MultiCell (35,8,$list['cantidad'],0, 'C', 1, 0,'','', true, 0, false, true,8, 'M');
            //$pdf->MultiCell (35,8,"S/. ".$list['total_prod'],0, 'R', 1, 0,'','', true, 0, false, true,8, 'M');

            //$total=$total+$list['total_prod'];
            $linea=$linea+6;
            //$contador=$contador+1;
        }

        $pdf->Output('Detalle de Folder.pdf', 'I');
    }
    //------------------------------------------------------ALUMNOS COMERCIAL------------------------------------------
    public function Alumno_BL() {
        if ($this->session->userdata('usuario')) { 
            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['cant_avisos'] = count($this->Model_Ceba->get_list_aviso());
            $dato['list_aviso'] = $this->Model_Ceba->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/comercial/alumno/index_bl',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Alumno_LL() {
        if ($this->session->userdata('usuario')) { 
            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['cant_avisos'] = count($this->Model_Ceba->get_list_aviso());
            $dato['list_aviso'] = $this->Model_Ceba->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/comercial/alumno/index_ll',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Alumno_LS() {
        if ($this->session->userdata('usuario')) { 
            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['cant_avisos'] = count($this->Model_Ceba->get_list_aviso());
            $dato['list_aviso'] = $this->Model_Ceba->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/comercial/alumno/index_ls',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Alumno_Comercial() {
        if ($this->session->userdata('usuario')) { 
            $dato['cod_sede'] = $this->input->post("cod_sede");
            $tipo = $this->input->post("tipo");
            $dato['list_alumno'] = $this->Admin_model->get_list_alumno_comercial($dato['cod_sede'],$tipo);
            $this->load->view('administrador/comercial/alumno/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Alumno_Comercial($sede,$tipo){
        $list_alumno = $this->Admin_model->get_list_alumno_comercial($sede,$tipo);

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

    public function Pdf_Alumno_Comercial($evento){
        $this->load->library('Pdf');

        $get_id= $this->Admin_model->get_cod_sede($evento);
        $list_usuario =$this->Admin_model->get_list_usuario_evento();

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Informe Evento');
        $pdf->SetSubject('Informe Evento');
        $pdf->SetKeywords('Informe, Evento, Registrados, Contactados, Asisten');

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
        $pdf->SetFont('helvetica','',18);

        // add a page
        $pdf->AddPage();

        $y2=25;

        $pdf->SetFillColor(255,255,255);

        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2);
        $pdf->MultiCell (210,20,'',0,'L',1,0,'','',true,0,false,true,10,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (20,$y2+3);
        $pdf->MultiCell (82,14,'Alumnos Matriculados '.date('Y'),0,'L',1,0,'','',true,0,false,true,14,'M');
        $pdf->Image($get_id[0]['imagen'],176,28,14,14,'', '', '', true, 150, '', false, false, 0);

        $pdf->SetLineStyle(array('width'=>0.6,'cap'=>'butt','join'=>'miter','dash'=> 0,'color'=>array(0, 0, 0)));
        $pdf->Line(15,$y2+35,195,$y2+35,'');

        /*$pdf->SetFont('helvetica','B',10);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY (15,$y2+40);
        $pdf->MultiCell (14,8,'Ref.:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id[0]['cod_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Evento:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (85,8,$get_id[0]['nom_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Estado:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['nom_estadoe'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+50);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (14,8,'Fecha:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id[0]['fecha_agenda'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (19,8,'Empresa:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id[0]['cod_empresa'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (12,8,'Sede:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id[0]['cod_sede'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (20,8,'Activo de:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['fecha_ini'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Hasta:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['fecha_fin'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+60);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (23,8,'Creado Por:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id[0]['usuario_codigo'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (11,8,'Link:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (125,8,$get_id[0]['link'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $usuario_informe="";
        if($get_id[0]['autorizaciones']!=""){
            $array=explode(",",$get_id[0]['autorizaciones']);
            $contador=0;
            $cadena="";
            while($contador<count($array)){
                $posicion_autorizacion=array_search($array[$contador],array_column($list_usuario,'id_usuario'));
                $cadena=$cadena.$list_usuario[$posicion_autorizacion]['usuario_codigo'].",";
                $contador++;
            }
            $usuario_informe=substr($cadena,0,-1);
        }

        $pdf->SetXY (15,$y2+70);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Usuario Informe:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (149,8,$usuario_informe,0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->Line(15,$y2+83,195,$y2+83,'');

        $pdf->SetXY (15,$y2+88);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Observaciones:',0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+96);
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (180,50,$get_id[0]['obs_evento'],0,'L',1,0,'','',true,0,false,true,50,'T');

        //TABLA

        $fecha = $get_id[0]['fecha_agenda_operativa'];
        $fecha_evento = $get_id[0]['fecha_agenda'];
        $fecha_7_despues = date('d/m/Y',strtotime('+7 day', strtotime($fecha)));
        $fecha_1_antes = date('d/m/Y',strtotime('-1 day', strtotime($fecha)));
        $fecha_7_antes = date('d/m/Y',strtotime('-7 day', strtotime($fecha)));
        $fecha_14_antes = date('d/m/Y',strtotime('-14 day', strtotime($fecha)));

        $datos_7_despues = $this->Admin_model->get_list_evento_7_despues($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_hoy = $this->Admin_model->get_list_evento_hoy($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_1_antes = $this->Admin_model->get_list_evento_1_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_7_antes = $this->Admin_model->get_list_evento_7_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);
        $datos_14_antes = $this->Admin_model->get_list_evento_14_antes($get_id[0]['id_evento'],$get_id[0]['fec_agenda']);

        $total_registrados = $datos_7_despues[0]['registrados']+$datos_hoy[0]['registrados']+$datos_1_antes[0]['registrados']+$datos_7_antes[0]['registrados']+$datos_14_antes[0]['registrados'];
        $total_contactados = $datos_7_despues[0]['contactados']+$datos_hoy[0]['contactados']+$datos_1_antes[0]['contactados']+$datos_7_antes[0]['contactados']+$datos_14_antes[0]['contactados'];
        $total_sin_revisar = $datos_7_despues[0]['sin_revisar']+$datos_hoy[0]['sin_revisar']+$datos_1_antes[0]['sin_revisar']+$datos_7_antes[0]['sin_revisar']+$datos_14_antes[0]['sin_revisar'];

        $pdf->SetXY (15,$y2+154);
        $pdf->MultiCell (180,62,'',1,'L',1,0,'','',true,0,false,true,62,'M');

        $pdf->SetXY (18,$y2+157);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,'Registrados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,'Contactados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,'Han Asistido',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,'No Asisten',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,'Sin Revisar',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+165);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días después',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_despues,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(226,239,218);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(252,228,214);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+173);
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (27,8,'Día Evento',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_evento,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_hoy[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_hoy[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_hoy[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+181);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'1 día antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_1_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_1_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+189);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+197);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'14 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_14_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_14_antes[0]['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_14_antes[0]['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_antes[0]['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+205);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,$total_registrados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,$total_contactados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,$datos_7_despues[0]['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,$total_sin_revisar,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        //FOOTER
        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2+235);
        $pdf->MultiCell (210,12,'',0,'L',1,0,'','',true,0,false,true,12,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (10,$y2+236);
        $pdf->MultiCell (45,10,'Global Leadership Group',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (100,10,'',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (45,10,date('d/m/Y')." - ".date('H:i:s'),0,'R',1,0,'','',true,0,false,true,10,'M');*/

        $pdf->Output('Informe_Alumnos_Matriculados.pdf', 'I');
    }

    public function Pago_Alumno_Comercial($id_alumno,$cod_sede) {
        if ($this->session->userdata('usuario')) { 
            $dato['cod_sede'] = $cod_sede;
            $dato['id_alumno'] = $id_alumno;
            $dato['get_id'] = $this->Admin_model->get_id_alumno_comercial($id_alumno);

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['cant_avisos'] = count($this->Model_Ceba->get_list_aviso());
            $dato['list_aviso'] = $this->Model_Ceba->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/comercial/alumno/pagos',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Pago_Alumno_Comercial() {
        if ($this->session->userdata('usuario')) { 
            $dato['id_alumno'] = $this->input->post("id_alumno");
            $dato['estado'] = $this->input->post("estado");
            $dato['list_pago'] = $this->Admin_model->get_list_pago_alumno_comercial($dato['id_alumno']);
            $this->load->view('administrador/comercial/alumno/lista_pagos',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Excel_Pago_Alumno_Comercial($id_alumno,$estado){
        $list_pago = $this->Admin_model->get_list_pago_alumno_comercial($id_alumno);

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

    public function Detalle_Alumno_Comercial($id_alumno,$cod_sede) {
        if ($this->session->userdata('usuario')) { 
            $dato['cod_sede'] = $cod_sede;
            $dato['get_id'] = $this->Admin_model->get_id_alumno_comercial($id_alumno);
            $dato['list_documento'] = $this->Admin_model->get_list_documento_alumno_comercial($id_alumno);

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $dato['cant_avisos'] = count($this->Model_Ceba->get_list_aviso());
            $dato['list_aviso'] = $this->Model_Ceba->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/comercial/alumno/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //------------------------------------------------------CENTRO COSTO------------------------------------------
    public function Centro_Custo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_tipo'] = $this->Admin_model->get_list_centro_custo();
        
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

        $this->load->view('administrador/centro_custo/index',$dato);
    }

    public function Modal_Centro_Custo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/centro_custo/modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Centro_Custo($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_centro_custo($id_tipo);
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/centro_custo/upd_modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Centro_Custo(){
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Admin_model->insert_centro_custo($dato);
    }
    
    public function Update_Centro_Custo(){
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Admin_model->update_centro_custo($dato);
    }

    public function Excel_Centro_Custo(){
        $tipo = $this->Admin_model->get_list_centro_custo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Centro Custo');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(40);
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

        $sheet->setCellValue("A1", 'Centro Custo');	        
        $sheet->setCellValue("B1", 'Status');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_ccr']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Centro Custo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    /*---------------------------*/

    public function Rubro_Contabilidade() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_tipo'] = $this->Admin_model->get_list_rubro_contabilidade();
        
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

        $this->load->view('administrador/rubros_contabilidade/index',$dato);
    }

    public function Modal_Rubro_Contabilidade(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/rubros_contabilidade/modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Rubro_Contabilidade($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_centro_custo($id_tipo);
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/rubros_contabilidade/upd_modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Rubro_Contabilidade(){
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Admin_model->insert_rubro_contabilidade($dato);
    }
    
    public function Update_Rubro_Contabilidade(){
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Admin_model->update_rubro_contabilidade($dato);
    }

    public function Excel_Rubro_Contabilidade(){
        $tipo = $this->Admin_model->get_list_rubro_contabilidade();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Rubro');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(40);
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

        $sheet->setCellValue("A1", 'Rubro');	        
        $sheet->setCellValue("B1", 'Status');

        $contador=1;
        
        foreach($tipo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_ccr']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rubro (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Documentos_PDF(){
        if ($this->session->userdata('usuario')) { 
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

            $this->load->view('gllg/dcomercial/documentos_pdf/index', $dato);    
        }
        else{
            //$this->load->view('login/login');

            redirect('/login');
        }
    }

    public function Lista_Documentos_PDF() {
        if ($this->session->userdata('usuario')) { 
            $dato['list_documento_pdf'] = $this->Admin_model->get_list_documento_pdf();
            $this->load->view('gllg/dcomercial/documentos_pdf/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Insert_Documentos_PDF(){
        if ($this->session->userdata('usuario')) {
            $dato['list_empresas'] =$this->Admin_model->get_list_empresa();
            $this->load->view('gllg/dcomercial/documentos_pdf/modal_registrar', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Buscar_Sede_Insert_Documentos_PDF(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  $this->input->post("id_empresa"); 
            $dato['list_sede']=$this->Admin_model->get_list_sede_xempresa($dato);
            $this->load->view('gllg/dcomercial/documentos_pdf/sede_insert', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documentos_PDF(){
        if ($this->session->userdata('usuario')) { 
            $dato['referencia']= $this->input->post("referencia_i");
            $dato['nombre_documento_pdf']= $this->input->post("nombre_documento_pdf_i");
            $dato['link_documento_pdf']= $this->input->post("link_documento_pdf_i");
            $dato['id_empresa']= $this->input->post("id_empresa_i");
            $dato['id_sede']= $this->input->post("id_sede_i");

            $valida = $this->Admin_model->valida_insert_documentos_pdf($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                if($_FILES["documento_pdf_i"]["name"] != ""){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_pdf_i"]["name"]);
                    $config['upload_path'] = './';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                    }
                    $config["allowed_types"] = 'pdf|PDF';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento_pdf_i"]["name"];
                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_pdf_i"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_pdf_i"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento_pdf_i"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento_pdf_i"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = $dato['nom_documento'];
                    }     
                }
    
                $this->Admin_model->insert_documentos_pdf($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Sede_Update_Documentos_PDF(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa']=  $this->input->post("id_empresa"); 
            $dato['list_sede']=$this->Admin_model->get_list_sede_xempresa($dato);
            $this->load->view('gllg/dcomercial/documentos_pdf/sede_update', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Documentos_PDF($id_documento_pdf){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] =$this->Admin_model->get_id_documento_pdf($id_documento_pdf);
            $dato['list_empresas'] =$this->Admin_model->get_list_empresa();
            $dato['id_empresa']=  $dato['get_id'][0]['id_empresa'];
            $dato['list_sede1'] = $this->Admin_model->get_list_sede_xempresa($dato);
            $dato['list_status'] = $this->Admin_model->get_list_estado();
            $this->load->view('gllg/dcomercial/documentos_pdf/modal_editar', $dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Documentos_PDF(){ 
        if ($this->session->userdata('usuario')) { 
            $dato['id_documento_pdf']= $this->input->post("id_documento_pdf");
            $dato['referencia']= $this->input->post("referencia_u");
            $dato['nombre_documento_pdf']= $this->input->post("nombre_documento_pdf_u");
            $dato['link_documento_pdf']= $this->input->post("link_documento_pdf_u");
            $dato['id_empresa']= $this->input->post("id_empresa_u");
            $dato['id_sede']= $this->input->post("id_sede_u");
            $dato['estado']= $this->input->post("estado_u");
            $dato['documento']= $this->input->post("documento_actual");

            $valida = $this->Admin_model->valida_update_documentos_pdf($dato);

            if(count($valida)>0){
                echo "error";
            }else{
                if($_FILES["documento_pdf_u"]["name"] != ""){
                    if (file_exists($dato['documento'])) { 
                        unlink($dato['documento']);
                    }
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_pdf_u"]["name"]); 
                    $config['upload_path'] = './';
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                    }
                    $config["allowed_types"] = 'pdf|PDF';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $path = $_FILES["documento_pdf_u"]["name"];
                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento_pdf_u"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento_pdf_u"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento_pdf_u"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento_pdf_u"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['documento'] = $dato['nom_documento'];
                    }     
                }
    
                $this->Admin_model->update_documentos_pdf($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo_Documento_PDF($id_comuimg) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Admin_model->get_id_comuimg($id_comuimg);
            $image = $dato['get_file'][0]['documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['documento']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo_Documento_PDF() {
        $id_comuimg = $this->input->post('image_id');
        $dato['get_file'] = $this->Admin_model->get_id_comuimg($id_comuimg);

        if (file_exists('./'.$dato['get_file'][0]['documento'])) {
            unlink('./'.$dato['get_file'][0]['documento']);
        }
        $this->Admin_model->delete_archivo_documento_pdf($id_comuimg);
    }

    public function Excel_Documento_PDF(){
        $list_documento_pdf = $this->Admin_model->get_list_documento_pdf();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos PDF'); 

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(17);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);

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

        $sheet->setCellValue("A1", 'Referencia');             
        $sheet->setCellValue("B1", 'Empresa');             
        $sheet->setCellValue("C1", 'Sede');
        $sheet->setCellValue("D1", 'Nombre');     
        $sheet->setCellValue("E1", 'Nombre (Documento)');             
        $sheet->setCellValue("F1", 'Link');
        $sheet->setCellValue("G1", 'Archivo');
        $sheet->setCellValue("H1", 'Estado');

        $contador=1;
        
        foreach($list_documento_pdf as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['referencia']);
            $sheet->setCellValue("B{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("C{$contador}", $list['cod_sede']);
            $sheet->setCellValue("D{$contador}", $list['nombre_documento_pdf']);
            $sheet->setCellValue("E{$contador}", $list['documento']);
            $sheet->setCellValue("F{$contador}", $list['link_documento_pdf']);
            $sheet->setCellValue("G{$contador}", $list['archivo']);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documentos PDF (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    
    public function Delete_Codigo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_documento_pdf']= $this->input->post("id_documento_pdf"); 
            $dato['documento']= $this->input->post("documento");
            //echo $dato['id_documento_pdf'];
            //echo $dato['documento'];
            
            $this->Admin_model->delete_codigo_inventario($dato);
            
        }else{
            redirect('/login');
        }
    }
    //---------------------------------RECOMENDADOS----------------------------
    public function Recomendados(){
        if ($this->session->userdata('usuario')) {
            $dato['list_recomendado'] = $this->Admin_model->get_list_recomendados();

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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes(); 

            $this->load->view('administrador/comercial/recomendados/index', $dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Recomendados($id_recomendado){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_list_recomendados($id_recomendado);
            $this->load->view('administrador/comercial/recomendados/modal_editar', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Recomendados(){
        $dato['id_recomendado']= $this->input->post("id_recomendado");
        $dato['validado1']= $this->input->post("validado1");
        $dato['estado_r']= $this->input->post("estado_r");  
        $dato['validado2']= $this->input->post("validado2");

        $this->Admin_model->update_recomendados($dato);

        if($dato['validado1']!="" && $dato['estado_r']!=""){
            $get_id = $this->Admin_model->get_list_recomendados($dato['id_recomendado']);
            $tipo = $get_id[0]['tipo'];
            $dni_alumno = $get_id[0]['dni_alumno'];

            $correo = $this->Admin_model->get_correo_matriculados($tipo,$dni_alumno);

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
                $mail->setFrom('no-reply@gllg.edu.pe', 'Recomendación'); //desde donde se envia

                //$mail->addAddress('daniel11143118@gmail.com');
                $mail->addAddress($correo[0]['Email']);

                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Validación de Descuento por Recomendación";
                $mail->Body = 'Se ha validado el descuento: '.$dato['validado1'];
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }

    public function Excel_Recomendados(){
        $list_recomendado = $this->Admin_model->get_list_recomendados();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Recomendados');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(24);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);

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

        $sheet->setCellValue("A1", 'DNI Alumno');             
        $sheet->setCellValue("B1", 'Código');
        $sheet->setCellValue("C1", 'Especialidad');             
        $sheet->setCellValue("D1", 'Validado');
        $sheet->setCellValue("E1", 'Registro');             
        $sheet->setCellValue("F1", 'DNI Recomendado');
        $sheet->setCellValue("G1", 'Celular');             
        $sheet->setCellValue("H1", 'Correo Electrónico');
        $sheet->setCellValue("I1", 'Estado');             
        $sheet->setCellValue("J1", 'Validado');

        $contador=1;
        
        foreach($list_recomendado as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['dni_alumno']);
            $sheet->setCellValue("B{$contador}", $list['codigo']);
            $sheet->setCellValue("C{$contador}", $list['especialidad']);
            $sheet->setCellValue("D{$contador}", $list['validado1']);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['registro']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list['dni_recomendado']);
            $sheet->setCellValue("G{$contador}", $list['celular']);
            $sheet->setCellValue("H{$contador}", $list['correo']);
            $sheet->setCellValue("I{$contador}", $list['estado_r']);
            $sheet->setCellValue("J{$contador}", $list['validado2']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Recomendados (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Configurar_Sms(){ 
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] =$this->Admin_model->get_texto_sms();
            $this->load->view('administrador/comercial/recomendados/modal_sms', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Configurar_Sms(){
        $dato['texto_sms']= $this->input->post("texto_sms");
        $this->Admin_model->update_configurar_sms($dato);
    }

    public function subtipo_xtipo2() {
        if (!$this->session->userdata('usuario')) {
            return false;
        }
        $id_tipo= $this->input->post("id_tipo");
        $id_empresa= $this->input->post("id_empresa");
        
        $dato['list_subtipo'] = $this->Admin_model->getsubtipo($id_tipo,$id_empresa);
        $this->load->view('Admin/informe/busqueda/subtipo',$dato);
    }
    //------------------------------------------------------COMPRA SMS------------------------------------------
    public function Compra_Mensaje() {
        if ($this->session->userdata('usuario')){
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            //----------------NO BORRAR ES PARA EL MENU DINAMICO----------------
            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/compra_mensaje/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Compra_Mensaje(){
        if ($this->session->userdata('usuario')){
            $dato['list_compra_mensaje'] = $this->Admin_model->get_list_compra_mensaje();
            $this->load->view('administrador/compra_mensaje/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Compra_Mensaje(){
        if ($this->session->userdata('usuario')){
            $this->load->view('administrador/compra_mensaje/modal_registrar');
        }else{
            redirect('/login');
        }
    }

    public function Insert_Compra_Mensaje(){
        $dato['fecha']= $this->input->post("fecha_i");
        $dato['monto']= $this->input->post("monto_i"); 
        $dato['cantidad']= $this->input->post("cantidad_i");
        $this->Admin_model->insert_compra_mensaje($dato);
    }

    public function Modal_Update_Compra_Mensaje($id_compra){
        if ($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Admin_model->get_list_compra_mensaje($id_compra);
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/compra_mensaje/modal_editar',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Compra_Mensaje(){
        $dato['id_compra']= $this->input->post("id_compra");
        $dato['fecha']= $this->input->post("fecha_u");
        $dato['monto']= $this->input->post("monto_u"); 
        $dato['cantidad']= $this->input->post("cantidad_u");
        $dato['estado']= $this->input->post("estado_u");
        $this->Admin_model->update_compra_mensaje($dato);
    }

    public function Delete_Compra_Mensaje(){ 
        $dato['id_compra']= $this->input->post("id_compra");
        $this->Admin_model->delete_compra_mensaje($dato);            
    }

    public function Excel_Compra_Mensaje(){ 
        $list_compra_mensaje = $this->Admin_model->get_list_compra_mensaje();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Compra Mensaje');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Fecha Compra');	   
        $sheet->setCellValue("B1", 'Monto'); 
        $sheet->setCellValue("C1", 'Cantidad');	        
        $sheet->setCellValue("D1", 'Fecha');        
        $sheet->setCellValue("E1", 'Usuario'); 
        $sheet->setCellValue("F1", 'Estado');	                           

        $contador=1;
        
        foreach($list_compra_mensaje as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            if($list['fecha_compra']!=""){
                $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fecha_compra']));
                $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("A{$contador}", "");
            }
            $sheet->setCellValue("B{$contador}", $list['monto']);
            $sheet->setCellValue("C{$contador}", $list['cantidad']);
            if($list['fecha_registro']!=""){
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("D{$contador}", "");
            }
            $sheet->setCellValue("E{$contador}", $list['usuario_registro']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Compra Mensaje (Lista)';
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/cierre_caja/index',$dato);  
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Cierre_Caja() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_cierre_caja'] = $this->Admin_model->get_list_cierre_caja($tipo);
            $this->load->view('administrador/cierre_caja/lista',$dato);
        }else{ 
            redirect('/login');
        }
    }

    public function Modal_Asignar_Cofre_Cierre_Caja(){ 
        if ($this->session->userdata('usuario')) { 
            $this->load->view('administrador/cierre_caja/modal_asignar_cofre');    
        }else{
            redirect('/login');
        }
    }

    public function Asignar_Cofre_Cierre_Caja(){
        if ($this->session->userdata('usuario')) {
            $cadena = substr($this->input->post("cadena"),0,-1); 
            $cantidad = $this->input->post("cantidad"); 
            $dato['cofre'] = $this->input->post("cofre"); 

            if($cantidad>0){
                $array = explode(",",$cadena);
                $i = 0;

                while($i<count($array)){
                    $array_cc = explode("_",$array[$i]);
                    $dato['id_cierre_caja'] = $array_cc[0];
                    $dato['id_empresa'] = $array_cc[1];
                    $this->Admin_model->update_cofre_cierre_caja($dato);
                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cierre_Caja($tipo){ 
        $list_cierre_caja = $this->Admin_model->get_list_cierre_caja($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:N2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:N2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cierre de Caja'); 

        $sheet->setAutoFilter('B2:N2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15); 
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(40);
        $sheet->getColumnDimension('N')->setWidth(15);

        $sheet->getStyle('B2:N2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:N2")->getFill()
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

        $sheet->getStyle("B2:N2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("B2", 'Sede');	
        $sheet->setCellValue("C2", 'Mes');	
        $sheet->setCellValue("D2", 'Vendedor');	
        $sheet->setCellValue("E2", 'Caja');	
        $sheet->setCellValue("F2", 'Saldo Automático');	    
        $sheet->setCellValue("G2", 'Monto Entregado');
        $sheet->setCellValue("H2", 'Productos'); 
        $sheet->setCellValue("I2", 'Diferencia');
        $sheet->setCellValue("J2", 'Recibe');
        $sheet->setCellValue("K2", 'Fecha');	
        $sheet->setCellValue("L2", 'Usuario');	         
        $sheet->setCellValue("M2", 'Cofre');  
        $sheet->setCellValue("N2", 'Estado');  

        $contador=2;
        
        foreach($list_cierre_caja as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}:G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['mes_anio']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['cod_vendedor']);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['caja']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list['saldo_automatico']); 
            $sheet->setCellValue("G{$contador}", $list['monto_entregado']);
            $sheet->setCellValue("H{$contador}", $list['productos']);
            $sheet->setCellValue("I{$contador}", $list['diferencia']);
            $sheet->setCellValue("J{$contador}", $list['cod_entrega']);
            if($list['fecha_registro']!=""){
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list['fecha_registro']));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("L{$contador}", $list['cod_registro']); 
            $sheet->setCellValue("M{$contador}", $list['cofre']);
            $sheet->setCellValue("N{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cierre de Caja (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Cierre_Caja($id_cierre_caja,$id_empresa){
        if ($this->session->userdata('usuario')){
            $dato['get_id'] = $this->Admin_model->get_id_cierre_caja($id_cierre_caja,$id_empresa);

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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();
            //$dato['gastos_sunat_pendientes'] = $this->Admin_model->get_cantidad_gastos_sunat_pendientes();

            $this->load->view('administrador/cierre_caja/detalle',$dato); 
        }else{
            redirect('/login'); 
        }
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();

            $this->load->view('Admin/asistencia_colaborador/index', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Asistencia_Colaborador_Lista(){
        if ($this->session->userdata('usuario')) {
            $fec_in = $this->input->post("fec_in");
            $fec_fi = $this->input->post("fec_fi");
            $tipo = $this->input->post("tipo");

            $dato['list_registro_ingreso'] = $this->Admin_model->get_list_registro_ingreso_c($fec_in,$fec_fi,$tipo);
                        
            $this->load->view('Admin/asistencia_colaborador/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Asistencia_Colaborador($fec_in,$fec_fi){     
        $fec_in = substr($fec_in,0,4)."-".substr($fec_in,4,2)."-".substr($fec_in,-2);
        $fec_fi = substr($fec_fi,0,4)."-".substr($fec_fi,4,2)."-".substr($fec_fi,-2);

        $list_registro_ingreso = $this->Admin_model->excel_registro_ingreso_c($fec_in,$fec_fi);

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
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->getColumnDimension('N')->setWidth(15);
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
            $sheet->setCellValue("E{$contador}", $list['nombre']);
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
    //-----------------------------------OBJETIVO-------------------------------------
    public function Objetivo(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/evento/objetivo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Objetivo() {
        if ($this->session->userdata('usuario')) {
            $dato['list_objetivo'] = $this->Admin_model->get_list_objetivo();
            $this->load->view('administrador/evento/objetivo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Objetivo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/evento/objetivo/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Objetivo(){
        if ($this->session->userdata('usuario')) {
            $dato['nom_objetivo']= $this->input->post("nom_objetivo_i");
            $dato['estado']= $this->input->post("estado_i"); 

            $validar = $this->Admin_model->valida_insert_objetivo($dato);

            if(count($validar)>0){
                echo "error";
            }else{
                $this->Admin_model->insert_objetivo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Objetivo($id_objetivo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_list_objetivo($id_objetivo);
            $dato['list_estado'] = $this->Admin_model->get_list_estado();
            $this->load->view('administrador/evento/objetivo/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Objetivo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_objetivo']= $this->input->post("id_objetivo"); 
            $dato['nom_objetivo']= $this->input->post("nom_objetivo_u");
            $dato['estado']= $this->input->post("estado_u"); 

            $validar = $this->Admin_model->valida_update_objetivo($dato);
            
            if(count($validar)>0){
                echo "error";
            }else{
                $this->Admin_model->update_objetivo($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Objetivo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_objetivo']= $this->input->post("id_objetivo");
            $this->Admin_model->delete_objetivo($dato);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Objetivo(){
        $list_objetivo = $this->Admin_model->get_list_objetivo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Objetivo');

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
        
        foreach($list_objetivo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_objetivo']);
            $sheet->setCellValue("B{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Objetivo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Delete_Registro_Ingreso_Lista(){
        $dato['id_registro_ingreso']= $this->input->post("id_registro_ingreso");
        $this->Admin_model->delete_registro_ingreso_lista($dato);
    }
    //-----------------------------------PUBLICIDAD-------------------------------------
    public function Publicidad(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/publicidad/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Publicidad() {
        if ($this->session->userdata('usuario')) {
            $dato['list_publicidad'] = $this->Admin_model->get_list_publicidad();
            $this->load->view('administrador/publicidad/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Publicidad($id_proyecto){
        if ($this->session->userdata('usuario')) { 
            $dato['id_proyecto'] = $id_proyecto;
            $dato['get_id'] = $this->Admin_model->get_list_publicidad($id_proyecto);
            $this->load->view('administrador/publicidad/modal_editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Update_Publicidad(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_proyecto']= $this->input->post("id_proyecto"); 
            $dato['campania']= $this->input->post("campania");
            $dato['tipo']= $this->input->post("tipo");
            $dato['del_dia']= $this->input->post("del_dia"); 
            $dato['hasta']= $this->input->post("hasta");
            $dato['alcance']= $this->input->post("alcance"); 
            $dato['interacciones']= $this->input->post("interacciones");
            $dato['monto']= $this->input->post("monto"); 

            $valida = $this->Admin_model->valida_publicidad($dato);

            if(count($valida)>0){
                $this->Admin_model->update_publicidad($dato);
            }else{
                $this->Admin_model->insert_publicidad($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Excel_Publicidad(){ 
        $list_publicidad = $this->Admin_model->get_list_publicidad();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Publicidad');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Empresa');	   
        $sheet->setCellValue("B1", 'Código'); 
        $sheet->setCellValue("C1", 'Tipo');	        
        $sheet->setCellValue("D1", 'Sub-Tipo');        
        $sheet->setCellValue("E1", 'Descripción'); 
        $sheet->setCellValue("F1", 'Agenda');	                     
        $sheet->setCellValue("G1", 'Campaña'); 
        $sheet->setCellValue("H1", 'Tipo'); 
        $sheet->setCellValue("I1", 'Del día');	                     
        $sheet->setCellValue("J1", 'Hasta'); 
        $sheet->setCellValue("K1", 'Días');	 
        $sheet->setCellValue("L1", 'Alcance');	                     
        $sheet->setCellValue("M1", 'Interacciones'); 
        $sheet->setCellValue("N1", 'Monto');	        

        $contador=1;
        
        foreach($list_publicidad as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_proyecto']);
            $sheet->setCellValue("C{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("D{$contador}", $list['nom_subtipo']);
            $sheet->setCellValue("E{$contador}", $list['descripcion']);
            if($list['agenda']!=""){
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['agenda']));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("G{$contador}", $list['campania']);
            $sheet->setCellValue("H{$contador}", $list['tipo']);
            if($list['del_dia']!=""){
                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['del_dia']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['hasta']!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list['hasta']));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("K{$contador}", $list['dias']);
            $sheet->setCellValue("L{$contador}", $list['alcance']);
            $sheet->setCellValue("M{$contador}", $list['interacciones']);
            $sheet->setCellValue("N{$contador}", $list['monto_excel']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Publicidad (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------POR TIPO-------------------------------------
    public function Por_Tipo(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/por_tipo/index',$dato);
        }else{
            redirect('/login');
        }
    }
    //-----------------------------------RRHH CONFIGURACIÓN-------------------------------------
    public function Rrhh_Configuracion(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/rrhh_configuracion/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Rrhh_Configuracion() {
        if ($this->session->userdata('usuario')) {
            $dato['list_rrhh_configuracion'] = $this->Admin_model->get_list_rrhh_configuracion();
            $this->load->view('administrador/rrhh_configuracion/lista',$dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Modal_Rrhh_Configuracion(){
        if ($this->session->userdata('usuario')) { 
            $this->load->view('administrador/rrhh_configuracion/modal_registrar');   
        }else{
            redirect('/login'); 
        }
    }

    public function Insert_Rrhh_Configuracion(){
        if ($this->session->userdata('usuario')) { 
            $dato['nombre']= $this->input->post("nombre"); 
            $dato['tipo_descuento']= $this->input->post("tipo_descuento");
            $dato['monto']= $this->input->post("monto");

            $valida = $this->Admin_model->valida_rrhh_configuracion(null,$dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Admin_model->insert_rrhh_configuracion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Rrhh_Configuracion($id){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_list_rrhh_configuracion($id);
            $this->load->view('administrador/rrhh_configuracion/modal_editar', $dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Update_Rrhh_Configuracion(){
        if ($this->session->userdata('usuario')) { 
            $dato['id']= $this->input->post("id"); 
            $dato['nombre']= $this->input->post("nombree"); 
            $dato['tipo_descuento']= $this->input->post("tipo_descuentoe");
            $dato['monto']= $this->input->post("montoe");

            $valida = $this->Admin_model->valida_rrhh_configuracion($dato['id'],$dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Admin_model->update_rrhh_configuracion($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Delete_Rrhh_Configuracion(){
        if ($this->session->userdata('usuario')) { 
            $dato['id']= $this->input->post("id");
            $this->Admin_model->delete_rrhh_configuracion($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Rrhh_Configuracion(){ 
        $list_configuracion = $this->Admin_model->get_list_rrhh_configuracion();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Configuración');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(60);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Nombre');	   
        $sheet->setCellValue("B1", 'Monto'); 
        $sheet->setCellValue("C1", 'Tipo de Descuento');	                

        $contador=1;
        
        foreach($list_configuracion as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nombre']);
            $sheet->setCellValue("B{$contador}", $list['monto']);
            $sheet->setCellValue("C{$contador}", $list['tipo_descuento']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Configuración (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //-----------------------------------PLANILLA GL0-------------------------------------
    public function Planilla($id_sede){
        if ($this->session->userdata('usuario')) {
            $dato['get_sede'] = $this->Admin_model->get_datos_sede($id_sede);

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

            $this->load->view('administrador/planilla/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Planilla() {
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $dato['list_planilla'] = $this->Admin_model->get_list_planilla(null,$dato['id_sede']);
            $this->load->view('administrador/planilla/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Planilla($id_sede){
        if ($this->session->userdata('usuario')) { 
            $dato['get_sede'] = $this->Admin_model->get_datos_sede($id_sede);
            $dato['list_mes'] = $this->Admin_model->get_list_mes_general();
            $dato['list_anio'] = $this->Admin_model->get_list_anio_general();
            $this->Admin_model->delete_temporal_planilla();

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
            
            $this->load->view('administrador/planilla/registrar',$dato);   
        }else{
            redirect('/login'); 
        }
    }

    public function Lista_Colaborador_Planilla() {
        if ($this->session->userdata('usuario')) {
            $dato['id_sede'] = $this->input->post("id_sede");
            $dato['mes'] = $this->input->post("mes");
            $dato['anio'] = $this->input->post("anio");
            $dato['list_colaborador'] = $this->Admin_model->get_list_colaborador_planilla($dato);
            $this->load->view('administrador/planilla/lista_colaborador',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Colaborador_Planilla($id_contrato){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_contrato_colaborador($id_contrato);
            $this->Admin_model->delete_modal_temporal_planilla(null,$dato['get_id'][0]['id_colaborador']);
            $this->load->view('administrador/planilla/modal_registrar', $dato);
        }else{
            redirect('');
        }
    }

    public function Lista_Temporal_Modal_Planilla() {
        if ($this->session->userdata('usuario')) {
            $dato['id_colaborador'] = $this->input->post("id_colaborador");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_temporal'] = $this->Admin_model->get_list_temporal_modal_planilla(null,$dato);
            $this->load->view('administrador/planilla/lista_temporal',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Temporal_Modal_Planilla(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_colaborador']= $this->input->post("id_colaborador"); 
            $dato['tipo']= $this->input->post("tipo"); 
            $dato['descripcion']= $this->input->post("descripcion_".$dato['tipo']); 
            $dato['monto']= $this->input->post("monto_".$dato['tipo']);
            $this->Admin_model->insert_temporal_modal_planilla($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Temporal_Modal_Planilla(){
        if ($this->session->userdata('usuario')) { 
            $dato['id']= $this->input->post("id"); 
            $this->Admin_model->delete_modal_temporal_planilla($dato['id']);
        }else{
            redirect('/login');
        }
    }

    public function Insert_Temporal_Planilla(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_colaborador']= $this->input->post("id_colaborador");
            $dato['horas_presencial']= $this->input->post("horas_presencial");
            $dato['horas_online']= $this->input->post("horas_online");
            $dato['faltas']= $this->input->post("faltas");
            $this->Admin_model->insert_select_temporal_planilla($dato);
            if($dato['faltas']!=""){
                $dato['tipo'] = 3;
                $dato['monto'] = $dato['faltas']*50;
                $this->Admin_model->insert_temporal_planilla($dato);
            }
            if($dato['horas_presencial']!=""){
                $dato['tipo'] = 4;
                $dato['monto'] = $dato['horas_presencial'];
                $this->Admin_model->insert_temporal_planilla($dato);
            }
            if($dato['horas_online']!=""){
                $dato['tipo'] = 5;
                $dato['monto'] = $dato['horas_online'];
                $this->Admin_model->insert_temporal_planilla($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Insert_Planilla(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_sede']= $this->input->post("id_sede"); 
            $dato['mes']= $this->input->post("mes"); 
            $dato['anio']= $this->input->post("anio");

            $valida = $this->Admin_model->valida_planilla(null,$dato);

            if(count($valida)>0){
                echo "error";
            }else{
                $this->Admin_model->insert_planilla($dato);
            }
        }else{
            redirect('/login');
        }
    }
    
    public function Delete_Planilla(){
        if ($this->session->userdata('usuario')) { 
            $dato['id']= $this->input->post("id");
            $this->Admin_model->delete_planilla($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Planilla($id_sede){ 
        $get_sede = $this->Admin_model->get_datos_sede($id_sede);
        $list_planilla = $this->Admin_model->get_list_planilla(null,$id_sede);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Planilla '.$get_sede[0]['cod_sede']);

        $sheet->setAutoFilter('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Año');	   
        $sheet->setCellValue("B1", 'Mes'); 
        $sheet->setCellValue("C1", 'Fecha');	 
        $sheet->setCellValue("D1", 'Usuario');	                

        $contador=1;
        
        foreach($list_planilla as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['anio']);
            $sheet->setCellValue("B{$contador}", $list['mes']);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list['usuario']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Planilla '.$get_sede[0]['cod_sede'].' (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Planilla($id){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Admin_model->get_list_planilla($id);

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
            
            $this->load->view('administrador/planilla/detalle',$dato);   
        }else{
            redirect('/login'); 
        }
    }
    //-----------------------------------ARCHIVO-------------------------------------
    public function Archivo(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/archivo_gl/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Archivo() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_archivo'] = $this->Admin_model->get_list_archivo($tipo);
            $dato['tipo'] = $tipo;
            $this->load->view('administrador/archivo_gl/lista', $dato);
        }else{
            redirect('/login');
        }
    }
    
    public function Validar_Archivo() {
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post('id_detalle');
            $dato['archivo'] = $this->input->post('archivo');

            $anio=date('Y');
            $query_id = $this->Admin_model->ultimo_cod_archivo($anio);
            $totalRows_t = count($query_id);

            $aniof = substr($anio, 2, 2);

            $codigo = $aniof . 'D' . str_pad(($totalRows_t + 1), 4, '0', STR_PAD_LEFT);

            $dato['codigo_documento']=$codigo;

            $this->Admin_model->validar_archivo($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Archivo($tipo){
        $list_archivo = $this->Admin_model->get_list_archivo($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Archivo');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(24);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
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

        $sheet->setCellValue("A1", 'Empresa');	   
        $sheet->setCellValue("B1", 'Sede'); 
        $sheet->setCellValue("C1", 'Código Documento');	 
        $sheet->setCellValue("D1", 'Nombre Documento');	     
        $sheet->setCellValue("E1", 'Nombre(s)'); 
        $sheet->setCellValue("F1", 'Apellido Paterno');
        $sheet->setCellValue("G1", 'Apellido Materno');           
        $sheet->setCellValue("H1", 'Fecha'); 
        $sheet->setCellValue("I1", 'Usuario');
        $sheet->setCellValue("J1", 'Estado');        

        $contador=1;
        
        foreach($list_archivo as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("B{$contador}", $list['cod_sede']);
            $sheet->setCellValue("C{$contador}", $list['cod_documento']);
            $sheet->setCellValue("D{$contador}", $list['nom_documento']);
            $sheet->setCellValue("E{$contador}", $list['nombre']);
            $sheet->setCellValue("F{$contador}", $list['apellido_paterno']);
            $sheet->setCellValue("G{$contador}", $list['apellido_materno']);
            if($list['fecha']!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list['fecha']));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("I{$contador}", $list['usuario']);
            $sheet->setCellValue("J{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Archivo (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    //---------------------------------------------FOTOCHECK COLABORADORES-------------------------------------------
    public function Fotocheck_Colaborador(){
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
            $dato['list_nav_sede'] = $this->Admin_model->get_list_nav_sede();

            $this->load->view('Admin/fotocheck_colaborador/index',$dato);
        }
    }

    public function Lista_Fotocheck_Colaboradores() {
        if ($this->session->userdata('usuario')) {
            $dato['tipo']= $this->input->post("tipo");
            $dato['list_fotocheck'] = $this->Admin_model->get_list_fotocheck($dato['tipo']);
            $this->load->view('Admin/fotocheck_colaborador/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Foto($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_fotocheck($id_fotocheck);
            $this->load->view('Admin/fotocheck_colaborador/modal_foto', $dato);
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
                $get_doc = $this->Admin_model->get_cod_documento_colaborador('D01');
                if (file_exists($dato['foto_fotocheck_2'])) {
                    unlink($dato['foto_fotocheck_2']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_2"]["name"]);
                $config['upload_path'] = './documento_colaborador_gl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_gl/', 0777);
                    chmod('./documento_colaborador_gl/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_gl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_2'] = "documento_colaborador_gl/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 2;
                $this->Admin_model->update_foto_fotocheck($dato);
                $get_detalle = $this->Admin_model->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck_2'];
                $this->Admin_model->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck"]["name"] != ""){
                $get_doc = $this->Admin_model->get_cod_documento_colaborador('D00');
                if (file_exists($dato['foto_fotocheck'])) {
                    unlink($dato['foto_fotocheck']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck"]["name"]);
                $config['upload_path'] = './documento_colaborador_gl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_gl/', 0777);
                    chmod('./documento_colaborador_gl/'.$get_doc[0]['id_documento'], 0777);
                    chmod('./documento_colaborador_gl/'.$get_doc[0]['id_documento'].'/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck'] = "documento_colaborador_gl/".$get_doc[0]['id_documento']."/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 1;
                $this->Admin_model->update_foto_fotocheck($dato);
                $get_detalle = $this->Admin_model->get_detalle_colaborador_empresa($dato['id_colaborador'],$get_doc[0]['id_documento']);
                $dato['id_detalle'] = $get_detalle[0]['id_detalle'];
                $dato['archivo'] = $dato['foto_fotocheck'];
                $this->Admin_model->update_documento_colaborador($dato);
            }

            if($_FILES["foto_fotocheck_3"]["name"] != ""){
                if (file_exists($dato['foto_fotocheck_3'])) {
                    unlink($dato['foto_fotocheck_3']);
                }
                $dato['nom_documento'] = str_replace(' ','_',$_FILES["foto_fotocheck_3"]["name"]);
                $config['upload_path'] = './documento_colaborador_gl/0/'.$dato['id_colaborador'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./documento_colaborador_gl/', 0777);
                    chmod('./documento_colaborador_gl/0', 0777);
                    chmod('./documento_colaborador_gl/0/'.$dato['id_colaborador'], 0777);
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
                    $dato['foto_fotocheck_3'] = "documento_colaborador_gl/0/".$dato['id_colaborador']."/".$dato['nom_documento'];
                }

                $dato['n_foto'] = 3;
                $this->Admin_model->update_foto_fotocheck($dato);
            }

            $valida = $this->Admin_model->valida_fotocheck_completo($dato['id_fotocheck']);

            if(count($valida)==0){
                $this->Admin_model->update_fotocheck_completo($dato);
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
            $dato['get_id'] = $this->Admin_model->get_id_fotocheck($id_fotocheck);
            $this->load->view('Admin/fotocheck_colaborador/modal_detalle', $dato);
        }else{
            redirect('');
        }
    }

    public function Carne_Colaborador($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_fotocheck($id_fotocheck);
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
            $html = $this->load->view('Admin/fotocheck_colaborador/carnet',$dato,true);
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
            $this->Admin_model->impresion_fotocheck($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Anular($id_fotocheck){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Admin_model->get_id_fotocheck($id_fotocheck);
            $this->load->view('Admin/fotocheck_colaborador/modal_anular', $dato);
        }else{
            redirect('');
        }
    }

    public function Anular_Envio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_fotocheck'] = $this->input->post("id_fotocheck");
            $dato['obs_anulado'] = $this->input->post("obs_anulado");
            $this->Admin_model->anular_envio($dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Envio(){
        if ($this->session->userdata('usuario')) {
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

            $dato['get_id_user'] = $this->Admin_model->get_id_user();
            $dato['list_cargo_sesion'] = $this->Admin_model->get_cargo_x_id($id_usuario);
            $this->load->view('Admin/fotocheck_colaborador/modal_envio', $dato);
        }else{
            redirect('');
        }
    }

    public function Traer_Cargo(){
        if ($this->session->userdata('usuario')) {
            $id_usuario_de = $this->input->post("usuario_encomienda");
            $dato['list_cargo'] = $this->Admin_model->get_cargo_x_id($id_usuario_de);
            $dato['id_cargo'] = "cargo_envio_f";
            $this->load->view('Admin/fotocheck_colaborador/cargo',$dato);
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

                    $alumno = $this->Admin_model->get_id_fotocheck($dato['id_fotocheck']);

                    if(count($alumno)>0){
                        if ($alumno[0]['esta_fotocheck']=='Foto Rec'){
                            $this->Admin_model->update_envio_fotocheck($dato);
                        }
                    }

                    $i++;
                }
            }
        }else{
            redirect('/login');
        }
    }

    //-----------------------------------ARCHIVO_BUSQUEDA-------------------------------------
    public function Archivo_Busqueda(){
        if ($this->session->userdata('usuario')) {

            $dato['anio']=date('Y');
            $dato['list_anio'] =$this->Admin_model->get_list_anio();
            $dato['list_empresas'] = $this->Model_General->get_list_empresa_usuario();
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

            $this->load->view('administrador/archivo_gl_busqueda/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Buscador_Archivo() {
        if ($this->session->userdata('usuario')) { 
            $anio = $this->input->post("anio");
            $id_empresa = $this->input->post("id_empresa");
            $tipo = $this->input->post('tipo');
            $dato['list_archivo'] = $this->Admin_model->get_list_archivo_busqueda($anio, $id_empresa, $tipo);
            $this->load->view('administrador/archivo_gl_busqueda/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Archivo_Busqueda($anio, $id_empresa, $tipo){ 
        $list_archivo = $this->Admin_model->get_list_archivo_busqueda($anio, $id_empresa, $tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:K2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:K2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Archivo');

        $sheet->setAutoFilter('B2:K2');
        $sheet->freezePane('A3');

        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(24);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
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

        $sheet->setCellValue("B2", 'Empresa');	   
        $sheet->setCellValue("C2", 'Sede'); 
        $sheet->setCellValue("D2", 'Código Documento');	 
        $sheet->setCellValue("E2", 'Nombre Documento');	     
        $sheet->setCellValue("F2", 'Nombre(s)'); 
        $sheet->setCellValue("G2", 'Apellido Paterno');
        $sheet->setCellValue("H2", 'Apellido Materno');           
        $sheet->setCellValue("I2", 'Fecha'); 
        $sheet->setCellValue("J2", 'Usuario');
        $sheet->setCellValue("K2", 'Estado');        

        $contador=2;
        
        foreach($list_archivo as $list){
            $contador++;
            
            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("B{$contador}", $list['cod_empresa']);
            $sheet->setCellValue("C{$contador}", $list['cod_sede']);
            $sheet->setCellValue("D{$contador}", $list['cod_documento']);
            $sheet->setCellValue("E{$contador}", $list['nom_documento']);
            $sheet->setCellValue("F{$contador}", $list['nombre']);
            $sheet->setCellValue("G{$contador}", $list['apellido_paterno']);
            $sheet->setCellValue("H{$contador}", $list['apellido_materno']);
            if($list['fecha']!=""){
                $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha']));
                $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("J{$contador}", $list['usuario']);
            $sheet->setCellValue("K{$contador}", $list['nom_estado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Busqueda (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Modal_Rechazar_Archivo($id_detalle,$id_alumno) {
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $id_detalle;
            $dato['id_alumno'] = $id_alumno;
    
            $archivo = $this->Admin_model->get_archivo_detalle($id_detalle);
            $dato['archivo'] = $archivo['archivo'];
    
            $dato['list_tipo_obs'] = $this->Admin_model->get_list_tipo_obs();
            $this->load->view('administrador/archivo_gl/modal_rechazar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Insert_Observacion_Rechazada() {
        if ($this->session->userdata('usuario')) {
            $dato['id_detalle'] = $this->input->post('id_detalle');
            $dato['id_alumno'] = $this->input->post('id_alumno');
            $dato['observacion'] = $this->input->post('observacion');
            $dato['id_tipo'] = $this->input->post('id_tipo');
            $dato['archivo'] = $this->input->post('archivo');

            $dato['get_alumno'] = $this->Admin_model->get_alumno($dato);
            $dato['id_empresa'] = $dato['get_alumno'][0]['id_empresa'];

            if( $dato['id_empresa'] == 5){
            $dato['id_sede'] = $dato['get_alumno'][0]['id_sede'];
            }

            $this->Admin_model->insert_rechazar_archivo($dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Archivo_Postulante() {
        if ($this->session->userdata('usuario')) {
            $dato['list_archivo_postulante'] = $this->Admin_model->get_list_archivo_postulante();
            $tipo = $this->input->post("tipo");
            $dato['tipo'] = $tipo;
            $this->load->view('administrador/archivo_gl/lista_postulante', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Validar_Archivo_Postulante() {
        if ($this->session->userdata('usuario')) {
            $dato['id_postulante'] = $this->input->post('id_postulante');
            $dato['id_detalle'] = $this->input->post('id_detalle');
            $dato['archivo'] = $this->input->post('archivo');

            $anio=date('Y');
            $query_id = $this->Admin_model->ultimo_cod_archivo($anio);
            $totalRows_t = count($query_id);

            $aniof = substr($anio, 2, 2);

            $codigo = $aniof . 'D' . str_pad(($totalRows_t + 1), 4, '0', STR_PAD_LEFT);

            $dato['codigo_documento']=$codigo;
            
            $this->Admin_model->validar_archivo_postulante($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Rechazar_Archivo_Postulante($id_postulante,$id_detalle,$id_documento) {
        if ($this->session->userdata('usuario')) {
            $dato['id_postulante'] = $id_postulante;
            $dato['id_documento'] = $id_documento;
            $dato['id_detalle'] = $id_detalle;

            $archivo = $this->Admin_model->get_archivo_postulante($id_postulante,$id_detalle,$id_documento);
            $dato['archivo'] = $archivo['archivo'];
    
            $dato['list_tipo_obs'] = $this->Admin_model->get_list_tipo_obs();
            $this->load->view('administrador/archivo_gl/modal_rechazar_postulante', $dato);
        } else {
            redirect('/login'); 
        }
    }

    public function Insert_Observacion_Rechazar_Postulante() {
        if ($this->session->userdata('usuario')) {
            $dato['id_admision'] = $this->input->post('id_postulante');
            $dato['id_detalle'] = $this->input->post('id_detalle');
            $dato['observacion'] = $this->input->post('observacion');
            $dato['id_tipo'] = $this->input->post('id_tipo_observacion');
            $dato['observacion_archivo'] = $this->input->post('observacion_archivo');

            $this->Admin_model->insert_rechazar_archivo_postulante($dato);
        }else{
            redirect('/login');
        }
    }
    //--------------------------------------RRHH BOLETAS------------------------------------------
    public function Rrhh_Boleta(){
        if ($this->session->userdata('usuario')) {
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

            $this->load->view('administrador/rrhh_boleta/index',$dato);
        }else{
            redirect('/login');
        }
    }
}
