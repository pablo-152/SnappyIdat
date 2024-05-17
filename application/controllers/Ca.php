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

class Ca extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Ca');
        $this->load->model('Admin_model');
        $this->load->model('Model_General');
        $this->load->model('N_model');
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
            $dato['fondo'] = $this->Model_Ca->fondo_index();
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa']=$this->Admin_model->get_id_empresa_usuario($id_usuario);
            $this->load->view('view_CA/administrador/index',$dato);
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

            $this->load->view('view_CA/aviso/detalle',$dato);
        }else{
            redirect('/login');
        }
    }
    //---------------------------------------------DESPESAS-------------------------------------------
    public function Despesa() {
        if ($this->session->userdata('usuario')) {
            $dato['saldo'] = $this->Model_Ca->get_saldo_despesa();

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

            $this->load->view('view_CA/despesa/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Despesa() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo");
            $dato['list_despesa'] = $this->Model_Ca->get_list_despesa($tipo);
            $this->load->view('view_CA/despesa/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Despesa(){
        if ($this->session->userdata('usuario')) {
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_combo();
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();
            $dato['list_mes'] = $this->Model_Ca->get_list_mes();
            $dato['list_colaborador'] = $this->Model_Ca->get_list_colaborador_despesa();

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

            $this->load->view('view_CA/despesa/registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Mes_Gasto() { 
        if ($this->session->userdata('usuario')) {
            $dato['fec_documento']= $this->input->post("fec_documento");
            $array = explode("-",$dato['fec_documento']);
            $dato['fecha'] = $array[1]."/".$array[0]; 
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();
            $dato['list_mes'] = $this->Model_Ca->get_list_mes();
            $this->load->view('view_CA/despesa/mes_gasto',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Subrubro_I() {
        if ($this->session->userdata('usuario')) {
            $dato['id_rubro']= $this->input->post("id_rubro");
            $dato['id_subrubro'] = "id_subrubro_i";
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_rubro_combo($dato['id_rubro']);
            $this->load->view('view_CA/despesa/subrubro',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Checkbox() {
        if ($this->session->userdata('usuario')) {
            $dato['id_subrubro']= $this->input->post("id_subrubro");
            $get_id = $this->Model_Ca->get_list_subrubro($dato['id_subrubro']);
            echo $get_id[0]['sin_contabilizar']."*".$get_id[0]['enviado_original']."*".$get_id[0]['sin_documento_fisico'];
        }else{
            redirect('/login');
        }
    } 

    public function Insert_Despesa(){
        $dato['tipo_despesa']= $this->input->post("tipo_despesa_i");
        $dato['id_tipo_pago']= $this->input->post("id_tipo_pago_i");
        $dato['id_rubro']= $this->input->post("id_rubro_i");
        $dato['descripcion']= $this->input->post("descripcion_i");
        $dato['documento']= $this->input->post("documento_i");
        $dato['fec_documento']= $this->input->post("fec_documento_i");  
        if($this->input->post("mes_gasto_i")==0){
            $dato['mes']="";
            $dato['anio']="";
        }else{
            $mes_gasto=explode("/",$this->input->post("mes_gasto_i"));
            $dato['mes']=$mes_gasto[0];
            $dato['anio']=$mes_gasto[1];
        }
        $dato['fec_pago']= $this->input->post("fec_pago_i");
        $dato['valor']= $this->input->post("valor_i"); 
        $dato['id_subrubro']= $this->input->post("id_subrubro_i"); 
        $dato['sin_contabilizar']= $this->input->post("sin_contabilizar_i"); 
        $dato['id_colaborador']= $this->input->post("id_colaborador"); 
        $dato['enviado_original']= $this->input->post("enviado_original_i"); 
        $dato['sin_documento_fisico']= $this->input->post("sin_documento_fisico_i"); 
        $dato['observaciones']= $this->input->post("observaciones_i"); 
        $dato['archivo']= ""; 
        $dato['pagamento']= "";
        $dato['doc_pagamento']= "";
        $dato['nom_archivo']= "";
        $dato['nom_pagamento']= "";

        if($dato['fec_pago']==""){
            $dato['orden'] = 1;
        }else{
            $dato['orden'] = 0;
        }

        if($dato['enviado_original']==1){
            $dato['estado_d'] = 2;
        }else{
            $dato['estado_d'] = 1;
        }

        $query_id = $this->Model_Ca->ultima_referencia_despesa();
        $totalRows_t = count($query_id);
        $aniof = substr(date('Y'),2,2);

        if($totalRows_t<9){
            $codigo=$aniof."/00".($totalRows_t+1);
        }
        if($totalRows_t>8 && $totalRows_t<99){
            $codigo=$aniof."/0".($totalRows_t+1);
        }
        if($totalRows_t>98 && $totalRows_t<999){
            $codigo=$aniof."/".($totalRows_t+1);
        }

        $dato['referencia'] = $codigo;

        if($_FILES["archivo_i"]["name"] != ""){
            $dato['nom_archivo'] = str_replace(' ','_',$_FILES["archivo_i"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["archivo_i"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_archivo'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["archivo_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["archivo_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["archivo_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["archivo_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['archivo'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }

        if($_FILES["pagamento_i"]["name"] != ""){
            $dato['nom_pagamento'] = str_replace(' ','_',$_FILES["pagamento_i"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["pagamento_i"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_pagamento'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["pagamento_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["pagamento_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["pagamento_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["pagamento_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['pagamento'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }

        if($_FILES["doc_pagamento_i"]["name"] != ""){
            $dato['nom_doc_pagamento'] = str_replace(' ','_',$_FILES["doc_pagamento_i"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["doc_pagamento_i"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_doc_pagamento'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["doc_pagamento_i"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["doc_pagamento_i"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["doc_pagamento_i"]["error"];
            $_FILES["file"]["size"] = $_FILES["doc_pagamento_i"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['doc_pagamento'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }

        $this->Model_Ca->insert_despesa($dato);

        $ultimo = $this->Model_Ca->ultimo_despesa();
        echo "Se creó el código ".$ultimo[0]['referencia'];
    }

    public function Validar_Archivo_Roto(){ 
        if ($this->session->userdata('usuario')) {
            $archivo = $this->input->post("archivo");

            if($_FILES[$archivo]["name"] != ""){
                $dato['nom_archivo'] = str_replace(' ','_',$_FILES[$archivo]["name"]);
                $config['upload_path'] = './prueba_archivo/'.$_SESSION['usuario'][0]['id_usuario'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./prueba_archivo/', 0777);
                    chmod('./prueba_archivo/'.$_SESSION['usuario'][0]['id_usuario'], 0777);
                }
                $config["allowed_types"] = 'jpeg|JPEG|png|PNG|jpg|JPG|pdf|PDF';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $_FILES["file"]["name"] =  $dato['nom_archivo'];
                $_FILES["file"]["type"] = $_FILES[$archivo]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES[$archivo]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES[$archivo]["error"];
                $_FILES["file"]["size"] = $_FILES[$archivo]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['archivo'] = "prueba_archivo/".$_SESSION['usuario'][0]['id_usuario']."/".$dato['nom_archivo'];
                    unlink($dato['archivo']);
                }else{
                    echo "error";
                }     
            }

            /*if (is_readable($dato['archivo'])) {
                echo 'El fichero es legible';
            } else {
                echo 'error';
            }*/
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Despesa($id_despesa){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_id_despesa($id_despesa);
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_combo();
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_rubro_combo($dato['get_id'][0]['id_rubro']);
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();  
            $dato['list_colaborador'] = $this->Model_Ca->get_list_colaborador_despesa();

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

            $this->load->view('view_CA/despesa/editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Div_Editar_Despesa(){
        if ($this->session->userdata('usuario')) {
            $id_despesa = $this->input->post("id_despesa");
            $dato['get_id'] = $this->Model_Ca->get_id_despesa($id_despesa);
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_combo();
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_rubro_combo($dato['get_id'][0]['id_rubro']);
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();
            $dato['list_mes'] = $this->Model_Ca->get_list_mes();
            $dato['list_colaborador'] = $this->Model_Ca->get_list_colaborador_despesa();
            $this->load->view('view_CA/despesa/div_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Traer_Subrubro_U() {
        if ($this->session->userdata('usuario')) {
            $dato['id_rubro']= $this->input->post("id_rubro");
            $dato['id_subrubro'] = "id_subrubro_u";
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_rubro_combo($dato['id_rubro']);
            $this->load->view('view_CA/despesa/subrubro',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Despesa(){
        $dato['id_despesa']= $this->input->post("id_despesa");
        $dato['referencia']= $this->input->post("referencia");
        $dato['tipo_despesa']= $this->input->post("tipo_despesa_u");
        $dato['id_tipo_pago']= $this->input->post("id_tipo_pago_u");
        $dato['id_rubro']= $this->input->post("id_rubro_u");
        $dato['descripcion']= $this->input->post("descripcion_u");
        $dato['documento']= $this->input->post("documento_u");
        $dato['fec_documento']= $this->input->post("fec_documento_u"); 
        if($this->input->post("mes_gasto_u")==0){
            $dato['mes']="";
            $dato['anio']="";
        }else{
            $mes_gasto=explode("/",$this->input->post("mes_gasto_u"));
            $dato['mes']=$mes_gasto[0];
            $dato['anio']=$mes_gasto[1];
        } 
        $dato['fec_pago']= $this->input->post("fec_pago_u");
        $dato['valor']= $this->input->post("valor_u"); 
        $dato['id_subrubro']= $this->input->post("id_subrubro_u"); 
        $dato['sin_contabilizar']= $this->input->post("sin_contabilizar_u"); 
        $dato['id_colaborador']= $this->input->post("id_colaborador"); 
        $dato['enviado_original']= $this->input->post("enviado_original_u"); 
        $dato['sin_documento_fisico']= $this->input->post("sin_documento_fisico_u"); 
        $dato['observaciones']= $this->input->post("observaciones_u"); 
        $dato['archivo']= $this->input->post("archivo_actual"); 
        $dato['pagamento']= $this->input->post("pagamento_actual"); 
        $dato['doc_pagamento']= $this->input->post("doc_pagamento_actual"); 
        $dato['nom_archivo']= $this->input->post("nom_archivo_actual"); 
        $dato['nom_pagamento']= $this->input->post("nom_pagamento_actual"); 

        if($dato['fec_pago']==""){
            $dato['orden'] = 1;
        }else{
            $dato['orden'] = 0;
        }

        if($dato['enviado_original']==1){
            $dato['estado_d'] = 2;
        }else{
            $dato['estado_d'] = 1;
        }

        if($_FILES["archivo_u"]["name"] != ""){
            if (file_exists($dato['archivo'])) { 
                unlink($dato['archivo']);
            }
            $dato['nom_archivo'] = str_replace(' ','_',$_FILES["archivo_u"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["archivo_u"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_archivo'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['archivo'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }
        
        if($_FILES["pagamento_u"]["name"] != ""){
            if (file_exists($dato['pagamento'])) { 
                unlink($dato['pagamento']);
            }
            $dato['nom_pagamento'] = str_replace(' ','_',$_FILES["pagamento_u"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["pagamento_u"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_pagamento'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["pagamento_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["pagamento_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["pagamento_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["pagamento_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['pagamento'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }

        if($_FILES["doc_pagamento_u"]["name"] != ""){
            if (file_exists($dato['pagamento'])) { 
                unlink($dato['pagamento']);
            }
            $dato['nom_doc_pagamento'] = str_replace(' ','_',$_FILES["doc_pagamento_u"]["name"]);
            $config['upload_path'] = './documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3);
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_despesa/', 0777);
                chmod('./documento_despesa/'.substr($dato['referencia'],0,2).substr($dato['referencia'],-3), 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["doc_pagamento_u"]["name"];
            $fecha=date('Y-m-d');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nombre = $dato['nom_doc_pagamento'];
            $_FILES["file"]["name"] =  $nombre;
            $_FILES["file"]["type"] = $_FILES["doc_pagamento_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["doc_pagamento_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["doc_pagamento_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["doc_pagamento_u"]["size"];
            if($this->upload->do_upload('file')){
                $data = $this->upload->data();
                $dato['doc_pagamento'] = "documento_despesa/".substr($dato['referencia'],0,2).substr($dato['referencia'],-3)."/".$nombre;
            }     
        }

        $this->Model_Ca->update_despesa($dato);
    }

    public function Delete_Despesa(){
        $dato['id_despesa']= $this->input->post("id_despesa");
        $this->Model_Ca->delete_despesa($dato);
    }

    public function Descargar_Archivo_Despesa($id_despesa,$orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ca->get_id_despesa($id_despesa);
            if($orden==1){
                $image = $dato['get_file'][0]['archivo'];
            }elseif($orden==2){
                $image = $dato['get_file'][0]['pagamento'];
            }else{
                $image = $dato['get_file'][0]['doc_pagamento'];
            }
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            if($orden==1){
                force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
            }elseif($orden==2){
                force_download($name , file_get_contents($dato['get_file'][0]['pagamento']));
            }else{
                force_download($name , file_get_contents($dato['get_file'][0]['doc_pagamento']));
            }
        }else{
            redirect('');
        }
    }

    public function Delete_Archivo_Despesa() {
        $id_despesa = $this->input->post('image_id');
        $orden = $this->input->post('orden');
        $dato['get_file'] = $this->Model_Ca->get_id_despesa($id_despesa);

        if($orden==1){
            $image = $dato['get_file'][0]['archivo'];
        }elseif($orden==2){
            $image = $dato['get_file'][0]['pagamento'];
        }else{
            $image = $dato['get_file'][0]['doc_pagamento'];
        }

        if (file_exists($image)) {
            unlink($image);
        }

        $this->Model_Ca->delete_archivo_despesa($id_despesa,$orden);
    }

    public function Excel_Despesa($tipo_excel){
        $list_anio = $this->Model_Ca->get_list_anio_despesa();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setPassword('Snappy24');

        $spreadsheet->getActiveSheet()->setTitle('Totales');

        $sheet->setShowGridLines(false);

        $sheet->getColumnDimension('A')->setWidth(1);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(11);
        $sheet->getColumnDimension('E')->setWidth(11);
        $sheet->getColumnDimension('F')->setWidth(11);
        $sheet->getColumnDimension('G')->setWidth(11);
        $sheet->getColumnDimension('H')->setWidth(11);
        $sheet->getColumnDimension('I')->setWidth(11);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->getColumnDimension('L')->setWidth(11);
        $sheet->getColumnDimension('M')->setWidth(11);
        $sheet->getColumnDimension('N')->setWidth(11);
        $sheet->getColumnDimension('O')->setWidth(11);
        $sheet->getColumnDimension('P')->setWidth(11);
        
        $contador = 2;

        foreach($list_anio as $anio){
            $list_subrubro = $this->Model_Ca->get_list_subrubro_despesa($anio['anio']);

            $sheet->getStyle("B{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle("B{$contador}:O{$contador}")->getFont()->setBold(true);

            $spreadsheet->getActiveSheet()->getStyle("B{$contador}:O{$contador}")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

            $sheet->setCellValue("B{$contador}", 'Rubro');        
            $sheet->setCellValue("C{$contador}", 'Sub-Rubro');             
            $sheet->setCellValue("D{$contador}", 'Ene-'.$anio['anio']);
            $sheet->setCellValue("E{$contador}", 'Feb-'.$anio['anio']);
            $sheet->setCellValue("F{$contador}", 'Mar-'.$anio['anio']);
            $sheet->setCellValue("G{$contador}", 'Abr-'.$anio['anio']);
            $sheet->setCellValue("H{$contador}", 'May-'.$anio['anio']);
            $sheet->setCellValue("I{$contador}", 'Jun-'.$anio['anio']);
            $sheet->setCellValue("J{$contador}", 'Jul-'.$anio['anio']);
            $sheet->setCellValue("K{$contador}", 'Ago-'.$anio['anio']);
            $sheet->setCellValue("L{$contador}", 'Set-'.$anio['anio']);
            $sheet->setCellValue("M{$contador}", 'Oct-'.$anio['anio']);
            $sheet->setCellValue("N{$contador}", 'Nov-'.$anio['anio']);
            $sheet->setCellValue("O{$contador}", 'Dic-'.$anio['anio']);

            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("B{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $contador_inicial = $contador+1;
            
            foreach($list_subrubro as $list){
                $contador++;

                $sheet->getStyle("B{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("B{$contador}:P{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("B{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("D{$contador}:P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

                $sheet->setCellValue("B{$contador}", $list['nom_rubro']);
                $sheet->setCellValue("C{$contador}", $list['nom_subrubro']);
                $sheet->setCellValue("D{$contador}", $list['enero']);
                $sheet->setCellValue("E{$contador}", $list['febrero']);
                $sheet->setCellValue("F{$contador}", $list['marzo']);
                $sheet->setCellValue("G{$contador}", $list['abril']);
                $sheet->setCellValue("H{$contador}", $list['mayo']);
                $sheet->setCellValue("I{$contador}", $list['junio']);
                $sheet->setCellValue("J{$contador}", $list['julio']);
                $sheet->setCellValue("K{$contador}", $list['agosto']);
                $sheet->setCellValue("L{$contador}", $list['septiembre']);
                $sheet->setCellValue("M{$contador}", $list['octubre']);
                $sheet->setCellValue("N{$contador}", $list['noviembre']);
                $sheet->setCellValue("O{$contador}", $list['diciembre']);
                $sheet->setCellValue("P{$contador}", "=SUM(D{$contador}:O{$contador})");
            }

            $contador_final = $contador;
            $contador = $contador+1;

            $sheet->getStyle("D{$contador}:P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("D{$contador}:P{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("D{$contador}:P{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("D{$contador}:P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

            $sheet->setCellValue("D{$contador}", "=SUM(D{$contador_inicial}:D{$contador_final})");
            $sheet->setCellValue("E{$contador}", "=SUM(E{$contador_inicial}:E{$contador_final})");
            $sheet->setCellValue("F{$contador}", "=SUM(F{$contador_inicial}:F{$contador_final})");
            $sheet->setCellValue("G{$contador}", "=SUM(G{$contador_inicial}:G{$contador_final})");
            $sheet->setCellValue("H{$contador}", "=SUM(H{$contador_inicial}:H{$contador_final})");
            $sheet->setCellValue("I{$contador}", "=SUM(I{$contador_inicial}:I{$contador_final})");
            $sheet->setCellValue("J{$contador}", "=SUM(J{$contador_inicial}:J{$contador_final})");
            $sheet->setCellValue("K{$contador}", "=SUM(K{$contador_inicial}:K{$contador_final})");
            $sheet->setCellValue("L{$contador}", "=SUM(L{$contador_inicial}:L{$contador_final})");
            $sheet->setCellValue("M{$contador}", "=SUM(M{$contador_inicial}:M{$contador_final})");
            $sheet->setCellValue("N{$contador}", "=SUM(N{$contador_inicial}:N{$contador_final})");
            $sheet->setCellValue("O{$contador}", "=SUM(O{$contador_inicial}:O{$contador_final})");
            $sheet->setCellValue("P{$contador}", "=SUM(P{$contador_inicial}:P{$contador_final})");

            $contador = $contador+2;
        }

        $sheet->getStyle("A1:P{$contador}")->getFont()->setSize(9);
        $sheet->getStyle("A1:P{$contador}")->getFont()->setName('Arial');

        //Segunda hoja
        $spreadsheet->createSheet();

        // Obtener la segunda hoja (el índice comienza en 0)
        $sheet2 = $spreadsheet->getSheet(1);

        $list_despesa = $this->Model_Ca->get_list_despesa($tipo_excel);

        $sheet2->getStyle("B2:Y2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle("B2:Y2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Movimientos');

        $sheet2->setAutoFilter('B2:Y2');
        $sheet2->freezePane('A3');

        $sheet2->getColumnDimension('A')->setWidth(3);
        $sheet2->getColumnDimension('B')->setWidth(15);
        $sheet2->getColumnDimension('C')->setWidth(15);
        $sheet2->getColumnDimension('D')->setWidth(15);
        $sheet2->getColumnDimension('E')->setWidth(22);
        $sheet2->getColumnDimension('F')->setWidth(30);
        $sheet2->getColumnDimension('G')->setWidth(30);
        $sheet2->getColumnDimension('H')->setWidth(40);
        $sheet2->getColumnDimension('I')->setWidth(22);
        $sheet2->getColumnDimension('J')->setWidth(22);
        $sheet2->getColumnDimension('K')->setWidth(18);
        $sheet2->getColumnDimension('L')->setWidth(16);
        $sheet2->getColumnDimension('M')->setWidth(16);
        $sheet2->getColumnDimension('N')->setWidth(15);
        $sheet2->getColumnDimension('O')->setWidth(18);
        $sheet2->getColumnDimension('P')->setWidth(18);
        $sheet2->getColumnDimension('Q')->setWidth(15);
        $sheet2->getColumnDimension('R')->setWidth(12);
        $sheet2->getColumnDimension('S')->setWidth(12);
        $sheet2->getColumnDimension('T')->setWidth(16);
        $sheet2->getColumnDimension('U')->setWidth(60);
        $sheet2->getColumnDimension('V')->setWidth(60);
        $sheet2->getColumnDimension('W')->setWidth(60);
        $sheet2->getColumnDimension('X')->setWidth(16);
        $sheet2->getColumnDimension('Y')->setWidth(100);

        $sheet2->getStyle('B2:Y2')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("B2:Y2")->getFill()
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

        $sheet2->getStyle("B2:Y2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet2->setCellValue("B2", 'Referencia');        
        $sheet2->setCellValue("C2", 'Tipo');             
        $sheet2->setCellValue("D2", 'Mes/Año');
        $sheet2->setCellValue("E2", 'Tipo Pago');
        $sheet2->setCellValue("F2", 'Rubro'); 
        $sheet2->setCellValue("G2", 'Sub-Rubro'); 
        $sheet2->setCellValue("H2", 'Descripción'); 
        $sheet2->setCellValue("I2", 'Documento');
        $sheet2->setCellValue("J2", 'Fecha Doc.');
        $sheet2->setCellValue("K2", 'Fecha Pago');
        $sheet2->setCellValue("L2", 'Valor');
        $sheet2->setCellValue("M2", 'Saldo'); 
        $sheet2->setCellValue("N2", 'Sin Cont.'); 
        $sheet2->setCellValue("O2", 'Colaborador'); 
        $sheet2->setCellValue("P2", 'Env. Original'); 
        $sheet2->setCellValue("Q2", 'Sin Doc. F.'); 
        $sheet2->setCellValue("R2", 'Doc.');
        $sheet2->setCellValue("S2", 'Pago');
        $sheet2->setCellValue("T2", 'Doc & Pago');
        $sheet2->setCellValue("U2", 'Nombre');
        $sheet2->setCellValue("V2", 'Nombre');
        $sheet2->setCellValue("W2", 'Nombre');
        $sheet2->setCellValue("X2", 'Estado');
        $sheet2->setCellValue("Y2", 'Observaciones');

        $contador = 2;
        $saldo =0 ;
        
        foreach($list_despesa as $list){
            $contador++;

            if($list['tipo_despesa']!=4){ 
                $saldo = $saldo+$list['valor'];
            }

            $sheet2->getStyle("B{$contador}:Y{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle("E{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet2->getStyle("O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle("U{$contador}:W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle("Y{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet2->getStyle("B{$contador}:Y{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet2->getStyle("B{$contador}:Y{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet2->getStyle("L{$contador}:M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            $sheet2->getStyle("U{$contador}:W{$contador}")->getFont()->getColor()->setRGB('1E88E5'); 
            $sheet2->getStyle("U{$contador}:W{$contador}")->getFont()->setUnderline(true);

            $sheet2->setCellValue("B{$contador}", $list['referencia']);
            $sheet2->setCellValue("C{$contador}", $list['nom_tipo']);
            if($list['mes']!=""){
                $sheet2->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha_mes_anio']));
                $sheet2->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX17);
            }
            $sheet2->setCellValue("E{$contador}", $list['nom_tipo_pago']);
            $sheet2->setCellValue("F{$contador}", $list['nom_rubro']); 
            $sheet2->setCellValue("G{$contador}", $list['nom_subrubro']);
            $sheet2->setCellValue("H{$contador}", $list['descripcion']);
            $texto = new RichText();
            $texto->createText($list['documento']);
            $sheet2->getCell("I{$contador}")->setValue($texto);
            if($list['fec_documento']!="0000-00-00"){
                $sheet2->setCellValue("J{$contador}", Date::PHPToExcel($list['fec_documento']));
                $sheet2->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if($list['fec_pago']!="0000-00-00"){
                $sheet2->setCellValue("K{$contador}", Date::PHPToExcel($list['fec_pago']));
                $sheet2->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet2->setCellValue("L{$contador}", $list['valor']);
            if($list['tipo_despesa']!=4){
                $sheet2->setCellValue("M{$contador}", $saldo);
            }
            $sheet2->setCellValue("N{$contador}", $list['sin_contabilizar']);
            $sheet2->setCellValue("O{$contador}", $list['colaborador']);
            $sheet2->setCellValue("P{$contador}", $list['enviado_original']);
            $sheet2->setCellValue("Q{$contador}", $list['v_sin_documento_fisico']);
            $sheet2->setCellValue("R{$contador}", $list['v_archivo']);
            $sheet2->setCellValue("S{$contador}", $list['v_pagamento']);
            $sheet2->setCellValue("T{$contador}", $list['v_doc_pagamento']);
            if($list['archivo']!=""){
                $sheet2->setCellValue("U{$contador}", base_url().$list['nom_archivo']);
                $sheet2->getCell("U{$contador}")->getHyperlink()->setURL(base_url()."documento_despesa/".substr($list['referencia'],0,2).substr($list['referencia'],-3)."/".$list['nom_archivo']);
            }
            if($list['pagamento']!=""){
                $sheet2->setCellValue("V{$contador}", base_url().$list['nom_pagamento']);
                $sheet2->getCell("V{$contador}")->getHyperlink()->setURL(base_url()."documento_despesa/".substr($list['referencia'],0,2).substr($list['referencia'],-3)."/".$list['nom_pagamento']);
            }
            if($list['doc_pagamento']!=""){
                $sheet2->setCellValue("W{$contador}", base_url().$list['nom_doc_pagamento']);
                $sheet2->getCell("W{$contador}")->getHyperlink()->setURL(base_url()."documento_despesa/".substr($list['referencia'],0,2).substr($list['referencia'],-3)."/".$list['nom_doc_pagamento']);
            }
            if($list['estado']==4){
                $sheet2->setCellValue("X{$contador}", "Anulado");
            }else{
                $sheet2->setCellValue("X{$contador}", $list['nom_estado']);
            }
            $sheet2->setCellValue("Y{$contador}", $list['observaciones']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Movimientos CA (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------RUBRO-------------------------------------------
    public function Rubro() {
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

            $this->load->view('view_CA/rubro/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Rubro() {
        if ($this->session->userdata('usuario')) {
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro();
            $this->load->view('view_CA/rubro/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Rubro(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_CA/rubro/modal_registrar');   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Rubro(){
        $dato['nom_rubro']= $this->input->post("nom_rubro_i"); 
        $dato['informe']= $this->input->post("informe_i"); 

        $total=count($this->Model_Ca->valida_insert_rubro($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ca->insert_rubro($dato);
        }
    }

    public function Modal_Update_Rubro($id_rubro){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_list_rubro($id_rubro);
            $dato['list_estado'] = $this->Model_Ca->get_list_estado();
            $this->load->view('view_CA/rubro/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Rubro(){
        $dato['id_rubro']= $this->input->post("id_rubro");
        $dato['estado']= $this->input->post("estado_u"); 
        $dato['nom_rubro']= $this->input->post("nom_rubro_u"); 
        $dato['informe']= $this->input->post("informe_u"); 

        $total=count($this->Model_Ca->valida_update_rubro($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ca->update_rubro($dato);
        }
    }

    public function Delete_Rubro(){ 
        $dato['id_rubro']= $this->input->post("id_rubro");
        $this->Model_Ca->delete_rubro($dato);
    }

    public function Excel_Rubro(){
        $list_rubro = $this->Model_Ca->get_list_rubro();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Rubro');

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

        $sheet->setCellValue("A1", 'Nombre');   
        $sheet->setCellValue("B1", 'Informe');           
        $sheet->setCellValue("C1", 'Estado');

        $contador=1;
        
        foreach($list_rubro as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_rubro']);
            $sheet->setCellValue("B{$contador}", $list['v_informe']);
            $sheet->setCellValue("C{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rubro (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------SUB-RUBRO-------------------------------------------
    public function Subrubro() {
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

            $this->load->view('view_CA/subrubro/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Subrubro() {
        if ($this->session->userdata('usuario')) {
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro();
            $this->load->view('view_CA/subrubro/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Subrubro(){
        if ($this->session->userdata('usuario')) {
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_combo();
            $this->load->view('view_CA/subrubro/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Subrubro(){
        $dato['id_rubro']= $this->input->post("id_rubro_i"); 
        $dato['nom_subrubro']= $this->input->post("nom_subrubro_i"); 
        $dato['sin_contabilizar']= $this->input->post("sin_contabilizar_i"); 
        $dato['enviado_original']= $this->input->post("enviado_original_i"); 
        $dato['sin_documento_fisico']= $this->input->post("sin_documento_fisico_i"); 

        $total=count($this->Model_Ca->valida_insert_subrubro($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ca->insert_subrubro($dato);
        }
    }

    public function Modal_Update_Subrubro($id_subrubro){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_list_subrubro($id_subrubro);
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_combo();
            $dato['list_estado'] = $this->Model_Ca->get_list_estado();
            $this->load->view('view_CA/subrubro/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Subrubro(){
        $dato['id_subrubro']= $this->input->post("id_subrubro");
        $dato['id_rubro']= $this->input->post("id_rubro_u"); 
        $dato['nom_subrubro']= $this->input->post("nom_subrubro_u"); 
        $dato['sin_contabilizar']= $this->input->post("sin_contabilizar_u"); 
        $dato['enviado_original']= $this->input->post("enviado_original_u"); 
        $dato['sin_documento_fisico']= $this->input->post("sin_documento_fisico_u"); 
        $dato['estado']= $this->input->post("estado_u"); 

        $total=count($this->Model_Ca->valida_update_subrubro($dato));

        if($total>0){
            echo "error";
        }else{
            $this->Model_Ca->update_subrubro($dato);
        }
    }

    public function Delete_Subrubro(){
        $dato['id_subrubro']= $this->input->post("id_subrubro");
        $this->Model_Ca->delete_subrubro($dato);
    }

    public function Excel_Subrubro(){
        $list_subrubro = $this->Model_Ca->get_list_subrubro();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Sub-Rubro');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
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

        $sheet->setCellValue("A1", 'Rubro');          
        $sheet->setCellValue("B1", 'Nombre');     
        $sheet->setCellValue("C1", 'Sin Contabilizar'); 
        $sheet->setCellValue("D1", 'Enviado Original'); 
        $sheet->setCellValue("E1", 'Sin Doc. F.');                 
        $sheet->setCellValue("F1", 'Estado');

        $contador=1;
        
        foreach($list_subrubro as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_rubro']);
            $sheet->setCellValue("B{$contador}", $list['nom_subrubro']);
            $sheet->setCellValue("C{$contador}", $list['sin_contabilizar']);
            $sheet->setCellValue("D{$contador}", $list['enviado_original']);
            $sheet->setCellValue("E{$contador}", $list['sin_documento_fisico']);
            $sheet->setCellValue("F{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Sub-Rubro (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------SALDO BANCO-------------------------------------------
    public function Saldo_Banco() {
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

            $this->load->view('view_CA/saldo_banco/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Saldo_Banco() {
        if ($this->session->userdata('usuario')) {
            $dato['list_saldo_banco'] = $this->Model_Ca->get_list_banco();
            $this->load->view('view_CA/saldo_banco/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Saldo_Banco($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Ca->get_list_saldo_banco($id_estado_bancario);
            $dato['list_empresa'] = $this->Model_Ca->get_list_empresa();
            $dato['list_estado'] = $this->Model_Ca->get_list_estado();
            $dato['list_mes'] = $this->Model_Ca->get_list_mes();
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();
            $this->load->view('view_CA/saldo_banco/modal_editar',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Saldo_Banco(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 
            $dato['cuenta_bancaria']= $this->input->post("cuenta_bancaria"); 
            $dato['mes']= substr($this->input->post("inicio"),0,2);   
            $dato['anio']= substr($this->input->post("inicio"),-4);   
            $dato['estado']= $this->input->post("estado");   
            $dato['observaciones']= $this->input->post("observaciones"); 
            $this->Model_Ca->update_saldo_banco($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Saldo_Banco(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario"); 
            $this->Model_Ca->delete_saldo_banco($dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Saldo_Banco(){
        $list_saldo_banco =$this->Model_Ca->get_list_saldo_banco();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Saldo Banco');

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
        
        foreach($list_saldo_banco as $list){
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
        $filename = 'Saldo Banco (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Detalle_Saldo_Banco($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] =$this->Model_Ca->get_list_saldo_banco($id_estado_bancario);
            
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

            $this->load->view('view_CA/saldo_banco/detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Detalle_Saldo_Banco() {
        if ($this->session->userdata('usuario')) {
            $id_estado_bancario = $this->input->post("id_estado_bancario"); 
            $dato['list_detalle'] =$this->Model_Ca->get_list_detalle_saldo_banco($id_estado_bancario);
            $this->load->view('view_CA/saldo_banco/lista_detalle',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Mes_Detalle_Saldo_Banco($id_estado_bancario){
        if ($this->session->userdata('usuario')) { 
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();
            $dato['list_mes'] = $this->Model_Ca->get_list_mes();
            $dato['id_estado_bancario'] = $id_estado_bancario;
            $this->load->view('view_CA/saldo_banco/modal_registrar_detalle',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Mes_Detalle_Saldo_Banco(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario_i"); 
            $dato['mes']= $this->input->post("mes_i");   
            $dato['anio']= $this->input->post("anio_i"); 
            $valida = $this->Model_Ca->valida_mes_detalle_saldo_banco($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Ca->insert_mes_detalle_saldo_banco($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Update_Detalle_Saldo_Banco($id_detalle){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Ca->get_id_detalle_saldo_banco($id_detalle);
            $this->load->view('view_CA/saldo_banco/modal_editar_detalle',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Update_Detalle_Saldo_Banco(){
        if ($this->session->userdata('usuario')) { 
            $dato['id_detalle']= $this->input->post("id_detalle"); 
            $dato['id_estado_bancario']= $this->input->post("id_estado_bancario_u"); 
            $dato['anio']= $this->input->post("anio_u"); 
            $dato['mes']= $this->input->post("mes_u"); 
            $dato['saldo_bbva']= $this->input->post("saldo_bbva_u");  
            $dato['saldo_real']= $this->input->post("saldo_real_u");  
            $dato['movimiento_pdf']= $this->input->post("antiguo_pdf_u"); 
            $dato['movimiento_excel']= $this->input->post("antiguo_excel_u"); 
            $dato['nom_pdf']= $this->input->post("antiguo_nom_pdf_u"); 
            $dato['nom_excel']= $this->input->post("antiguo_nom_excel_u"); 

            if($_FILES["movimiento_pdf_u"]["name"] != ""){
                if (file_exists($dato['movimiento_pdf'])) { 
                    unlink($dato['movimiento_pdf']);
                }

                $dato['nom_pdf'] = str_replace(' ','_',$_FILES["movimiento_pdf_u"]["name"]);

                $config['upload_path'] = './movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'], 0777);
                }
                $config["allowed_types"] = 'pdf';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["movimiento_pdf_u"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $dato['nom_pdf'];
                $_FILES["file"]["name"] =  $nombre;
                $_FILES["file"]["type"] = $_FILES["movimiento_pdf_u"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["movimiento_pdf_u"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["movimiento_pdf_u"]["error"];
                $_FILES["file"]["size"] = $_FILES["movimiento_pdf_u"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['movimiento_pdf'] = "movimientos/".$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes']."/".$nombre;
                }     
            }
            
            if($_FILES["movimiento_excel_u"]["name"] != ""){
                if (file_exists($dato['movimiento_excel'])) { 
                    unlink($dato['movimiento_excel']);
                }
                
                $dato['nom_excel'] = str_replace(' ','_',$_FILES["movimiento_excel_u"]["name"]);

                $config['upload_path'] = './movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'];
                if (!file_exists($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                    chmod($config['upload_path'], 0777);
                    chmod('./movimientos/'.$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes'], 0777);
                }
                $config["allowed_types"] = 'xls|xlsx';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $path = $_FILES["movimiento_excel_u"]["name"];
                $fecha=date('Y-m-d');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $dato['nom_excel'];
                $_FILES["file"]["name"] =  $nombre;
                $_FILES["file"]["type"] = $_FILES["movimiento_excel_u"]["type"];
                $_FILES["file"]["tmp_name"] = $_FILES["movimiento_excel_u"]["tmp_name"];
                $_FILES["file"]["error"] = $_FILES["movimiento_excel_u"]["error"];
                $_FILES["file"]["size"] = $_FILES["movimiento_excel_u"]["size"];
                if($this->upload->do_upload('file')){
                    $data = $this->upload->data();
                    $dato['movimiento_excel'] = "movimientos/".$dato['id_estado_bancario']."_".$dato['anio'].$dato['mes']."/".$nombre;
                }     
            }

            $this->Model_Ca->update_detalle_saldo_banco($dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo($id_detalle,$orden) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ca->get_id_detalle_saldo_banco($id_detalle);
            if($orden==1){
                $image = $dato['get_file'][0]['movimiento_pdf'];
            }else{
                $image = $dato['get_file'][0]['movimiento_excel'];
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
        $dato['get_file'] = $this->Model_Ca->get_id_detalle_saldo_banco($id_detalle);

        if($orden==1){
            $image = $dato['get_file'][0]['movimiento_pdf'];
        }else{
            $image = $dato['get_file'][0]['movimiento_excel'];
        }

        if (file_exists($image)) {
            unlink($image);
        }

        $this->Model_Ca->delete_archivo_saldo_banco($id_detalle,$orden);
    }

    public function Modal_Ver_Detalle_Saldo_Banco($id_detalle){
        if ($this->session->userdata('usuario')) { 
            $dato['get_id'] = $this->Model_Ca->get_id_detalle_saldo_banco($id_detalle);
            $this->load->view('view_CA/saldo_banco/modal_ver_detalle',$dato);
        }
        else{
            redirect('/login');
        }
    }

    public function Excel_Detalle_Saldo_Banco($id_estado_bancario){
        $list_detalle =$this->Model_Ca->get_list_detalle_saldo_banco($id_estado_bancario);
        $get_id =$this->Model_Ca->get_list_saldo_banco($id_estado_bancario);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Detalle Cuentas Bancarias');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(50);
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

        $sheet->setCellValue("A1", 'Mes'); 
        $sheet->setCellValue("B1", 'Movimientos (PDF)');
        $sheet->setCellValue("C1", 'Link (PDF)');
        $sheet->setCellValue("D1", 'Movimientos (XLS)');
        $sheet->setCellValue("E1", 'Link (XLS)');
        $sheet->setCellValue("F1", 'Saldo (BBVA)'); 
        $sheet->setCellValue("G1", 'Saldo (REAL)'); 

        $contador=1;
        
        foreach($list_detalle as $list){
            $contador++;

            $inicio="";
            $pdf="Pendiente";
            $excel="Pendiente";

            if($list['mes']!="" && $list['anio']!=""){
                $inicio=$list['anio']."-".$list['mes']."-01";
            }

            if ($list['movimiento_pdf']!=""){
                $pdf="Cargado";
            }

            if($list['movimiento_excel']!=""){
                $excel="Cargado";
            }

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}:G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
            $sheet->getStyle("J{$contador}:K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
            $sheet->getStyle("C{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("C{$contador}")->getFont()->setUnderline(true);  
            $sheet->getStyle("E{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("E{$contador}")->getFont()->setUnderline(true);  

            if($list['mes']!="" && $list['anio']!=""){
                $sheet->setCellValue("A{$contador}", Date::PHPToExcel($inicio));
                $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }else{
                $sheet->setCellValue("A{$contador}", "");  
            }
            
            $sheet->setCellValue("B{$contador}", $pdf);   

            if($list['movimiento_pdf']!=""){
                $sheet->setCellValue("C{$contador}", $list['link_pdf']);
                $sheet->getCell("C{$contador}")->getHyperlink()->setURL($list['href_pdf']);
            }else{
                $sheet->setCellValue("C{$contador}", "");
            }
 
            $sheet->setCellValue("D{$contador}", $excel);  
           
            if($list['movimiento_excel']!=""){
                $sheet->setCellValue("E{$contador}", $list['link_excel']);
                $sheet->getCell("E{$contador}")->getHyperlink()->setURL($list['href_excel']);
            }else{
                $sheet->setCellValue("E{$contador}", "");
            }

            if($list['saldo_bbva']!=0){
                $sheet->setCellValue("F{$contador}", $list['saldo_bbva']);  
            }else{
                $sheet->setCellValue("F{$contador}", "");
            }

            if($list['saldo_real']!=0){
                $sheet->setCellValue("G{$contador}", $list['saldo_real']);  
            }else{
                $sheet->setCellValue("G{$contador}", "");
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
    //---------------------------------------------DOCUMENTOS-------------------------------------------
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

            $this->load->view('view_CA/documento/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Documento() {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_Ca->get_list_documento();
            $this->load->view('view_CA/documento/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Documento(){
        if ($this->session->userdata('usuario')) {
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_combo();
            $this->load->view('view_CA/documento/modal_registrar',$dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Documento(){
        $dato['id_subrubro']= $this->input->post("id_subrubro_i"); 
        $dato['descripcion']= $this->input->post("descripcion_i"); 
        $dato['visible']= $this->input->post("visible_i"); 

        $cantidad = (count($this->Model_Ca->get_cantidad_documento()))+1;

        if($_FILES["documento_i"]["name"] != ""){
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_i"]["name"]);
            $config['upload_path'] = './documento_ca/'.$cantidad;
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_ca/', 0777);
                chmod('./documento_ca/'.$cantidad, 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
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
                $dato['documento'] = "documento_ca/".$dato['nom_documento'];
            }     
        }
        $this->Model_Ca->insert_documento($dato);
    }

    public function Modal_Update_Documento($id_documento){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_list_documento($id_documento);
            $dato['list_subrubro'] = $this->Model_Ca->get_list_subrubro_combo();
            $dato['list_estado'] = $this->Model_Ca->get_list_estado();
            $this->load->view('view_CA/documento/modal_editar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $dato['id_subrubro']= $this->input->post("id_subrubro_u"); 
        $dato['descripcion']= $this->input->post("descripcion_u"); 
        $dato['estado']= $this->input->post("estado_u"); 
        $dato['visible']= $this->input->post("visible_u"); 
        $dato['nom_documento']= $this->input->post("nom_documento_actual"); 
        $dato['documento']= $this->input->post("documento_actual"); 

        $get_id= $this->Model_Ca->get_list_documento($dato['id_documento']);

        if($_FILES["documento_u"]["name"] != ""){
            if (file_exists($dato['documento'])) { 
                unlink($dato['documento']);
            }
            $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento_u"]["name"]);
            $config['upload_path'] = './documento_ca/'.$get_id[0]['id_documento'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_ca/', 0777);
                chmod('./documento_ca/'.$get_id[0]['id_documento'], 0777);
            }
            $config["allowed_types"] = 'jpeg|png|jpg|pdf';
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
                $dato['documento'] = "documento_ca/".$dato['nom_documento'];
            }     
        }

        $this->Model_Ca->update_documento($dato);
    }

    public function Delete_Documento(){
        $dato['id_documento']= $this->input->post("id_documento");
        $this->Model_Ca->delete_documento($dato);
    }

    public function Descargar_Documento_Ca($id_documento) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ca->get_list_documento($id_documento);
            $image = 'documento_ca/'.$dato['get_file'][0]['id_documento'].'/'.$dato['get_file'][0]['nom_documento'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents('documento_ca/'.$dato['get_file'][0]['id_documento'].'/'.$dato['get_file'][0]['nom_documento']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Documento_Ca() {
        $id_documento = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_Ca->get_list_documento($id_documento);

        $image = $dato['get_file'][0]['documento'];

        if (file_exists($image)) {
            unlink($image);
        }

        $this->Model_Ca->delete_documento_ca($id_documento);
    }

    public function Excel_Documento(){
        $list_documento = $this->Model_Ca->get_list_documento();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documento');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(50);
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
        $sheet->setCellValue("B1", 'Sub-Rubro');
        $sheet->setCellValue("C1", 'Descripción');  
        $sheet->setCellValue("D1", 'Nombre (Documento)');
        $sheet->setCellValue("E1", 'Link');             
        $sheet->setCellValue("F1", 'Archivo');
        $sheet->setCellValue("G1", 'Visible');
        $sheet->setCellValue("H1", 'Estado');             

        $contador=1;
        
        foreach($list_documento as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("E{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("E{$contador}")->getFont()->setUnderline(true);  

            $sheet->setCellValue("A{$contador}", "CA");
            $sheet->setCellValue("B{$contador}", $list['nom_subrubro']);
            $sheet->setCellValue("C{$contador}", $list['descripcion']);
            $sheet->setCellValue("D{$contador}", $list['nom_documento']);
            $sheet->setCellValue("E{$contador}", $list['link']);
            if($list['documento']!=""){
                $sheet->setCellValue("E{$contador}", $list['link']);
                $sheet->getCell("E{$contador}")->getHyperlink()->setURL($list['href']);
            }else{
                $sheet->setCellValue("E{$contador}", "");
            }
            $sheet->setCellValue("F{$contador}", $list['v_documento']);
            $sheet->setCellValue("G{$contador}", $list['visible']);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documento (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
    //---------------------------------------------INFORME DESPESA-------------------------------------------
    public function Informe_Despesa() {
        if ($this->session->userdata('usuario')) {
            $dato['list_anio'] = $this->Model_Ca->get_list_anio();

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

            $this->load->view('view_CA/informe_despesa/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Informe_Despesa() {
        if ($this->session->userdata('usuario')) {
            $dato['nom_anio']= $this->input->post("nom_anio");
            $dato['list_informe_despesa'] = $this->Model_Ca->get_list_informe_despesa();
            $this->load->view('view_CA/informe_despesa/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Excel_Informe_Despesa($nom_anio){
        $list_informe_despesa = $this->Model_Ca->get_list_informe_despesa();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Informe Despesa');

        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(22);
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
        $sheet->getColumnDimension('O')->setWidth(15);

        $sheet->getStyle('A1:O1')->getFont()->getColor()->setRGB('FFFFFF');

        $spreadsheet->getActiveSheet()->getStyle("A1:O1")->getFill()
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

        $sheet->getStyle("A1:O1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Año');      
        $sheet->setCellValue("B1", 'Rubro');         
        $sheet->setCellValue("C1", 'Enero');
        $sheet->setCellValue("D1", 'Febrero');
        $sheet->setCellValue("E1", 'Marzo');           
        $sheet->setCellValue("F1", 'Abril');
        $sheet->setCellValue("G1", 'Mayo');
        $sheet->setCellValue("H1", 'Junio');           
        $sheet->setCellValue("I1", 'Julio');
        $sheet->setCellValue("J1", 'Agosto');           
        $sheet->setCellValue("K1", 'Septiembre');
        $sheet->setCellValue("L1", 'Octubre');
        $sheet->setCellValue("M1", 'Noviembre');           
        $sheet->setCellValue("N1", 'Diciembre');
        $sheet->setCellValue("O1", 'Total');

        $contador=1;
        
        foreach($list_informe_despesa as $list){
            $contador++;
            
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}:O{$contador}")->getNumberFormat()->setFormatCode('0.00');

            if($list['Enero']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("C{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Febrero']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("D{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Marzo']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("E{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Abril']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("F{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Mayo']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("G{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Junio']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("H{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Julio']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("I{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Agosto']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("J{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Septiembre']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("K{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Octubre']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("L{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Noviembre']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("M{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
            if($list['Diciembre']==0){ 
                $spreadsheet->getActiveSheet()->getStyle("N{$contador}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE1E2');
            }
                    
            $sheet->setCellValue("A{$contador}", $nom_anio);
            $sheet->setCellValue("B{$contador}", $list['Rubro']);    
            $sheet->setCellValue("C{$contador}", "S/ ".$list['Enero']);
            $sheet->setCellValue("D{$contador}", "S/ ".$list['Febrero']);
            $sheet->setCellValue("E{$contador}", "S/ ".$list['Marzo']);           
            $sheet->setCellValue("F{$contador}", "S/ ".$list['Abril']);
            $sheet->setCellValue("G{$contador}", "S/ ".$list['Mayo']);
            $sheet->setCellValue("H{$contador}", "S/ ".$list['Junio']);           
            $sheet->setCellValue("I{$contador}", "S/ ".$list['Julio']);
            $sheet->setCellValue("J{$contador}", "S/ ".$list['Agosto']);           
            $sheet->setCellValue("K{$contador}", "S/ ".$list['Septiembre']);
            $sheet->setCellValue("L{$contador}", "S/ ".$list['Octubre']);
            $sheet->setCellValue("M{$contador}", "S/ ".$list['Noviembre']);           
            $sheet->setCellValue("N{$contador}", "S/ ".$list['Diciembre']);
            $sheet->setCellValue("O{$contador}", "S/ ".$list['Total']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Despesas - Informes (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
        
    }
    //---------------------------------------------CARGO-------------------------------------------
    public function Cargo() {
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

            $this->load->view('view_CA/cargo/index',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Cargo() {
        if ($this->session->userdata('usuario')) {
            $tipo = $this->input->post("tipo"); 
            $dato['list_cargo'] = $this->Model_Ca->get_list_cargo(null,$tipo);
            $this->load->view('view_CA/cargo/lista',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Registrar_Cargo(){
        if ($this->session->userdata('usuario')) {
            $this->Model_Ca->limpiar_temporal_cargo_archivos();
            $dato['list_usuario'] = $this->Model_Ca->get_list_usuario_cargo();
            $dato['list_empresam'] = $this->Model_Ca->get_list_empresa_cargo();
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_cargo();

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
            
            $this->load->view('view_CA/cargo/registrar', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Sede_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_empresa'] = $this->input->post("id_empresa"); 
            $dato['list_sede'] = $this->Model_Ca->get_list_sede_cargo($dato['id_empresa']);
            $this->load->view('view_CA/cargo/sede', $dato); 
        }else{
            redirect('/login');
        }
    }

    public function Buscar_Datos_Usuario_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario'] =  $this->input->post("id_usuario"); 
            $get_id = $this->Model_Ca->get_list_usuario_cargo($dato['id_usuario']);
            echo $get_id[0]['usuario_email']."/".$get_id[0]['num_celp'];
        }else{
            redirect('/login');
        }
    }

    public function Modal_Archivo_Cargo_Temporal(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_CA/cargo/modal_archivo_temporal');
        }else{
            redirect('/login');
        }
    }

    public function Insert_Archivo_Cargo_Temporal(){
        if ($this->session->userdata('usuario')) {
            $dato['nombre'] = $this->input->post("nom_documento");

            $valida_1 = $this->Model_Ca->valida_insert_cargo_archivo_temporal($dato['nombre']);
            $valida_2 = $this->Model_Ca->valida_insert_cargo_archivo_temporal();

            if(count($valida_1)>0){
                echo "error";
            }elseif(count($valida_2)>4){
                echo "cantidad";
            }else{
                if($_FILES["documento"]["name"] != ""){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento"]["name"]);
                    $config['upload_path'] = './cargo_ca_documento_temporal/'.$_SESSION['usuario'][0]['id_usuario'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./cargo_ca_documento_temporal/', 0777);
                        chmod('./cargo_ca_documento_temporal/'.$_SESSION['usuario'][0]['id_usuario'], 0777);
                    }
                    $config["allowed_types"] = 'jpg|JPG|png|PNG|jpeg|JPEG|xls|xlsx|pdf|PDF';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "cargo_ca_documento_temporal/".$_SESSION['usuario'][0]['id_usuario']."/".$dato['nom_documento'];
                        $this->Model_Ca->insert_cargo_archivo_temporal($dato);
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_Archivo_Cargo_Temporal(){
        if ($this->session->userdata('usuario')) {
            $dato['list_temporal']=$this->Model_Ca->get_list_cargo_archivo_temporal();
            $this->load->view('view_CA/cargo/div_temporal',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo_Cargo_Temporal($id) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ca->get_list_cargo_archivo_temporal($id);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }else{
            redirect('');
        }
    }

    public function Delete_Archivo_Cargo_Temporal() {
        if ($this->session->userdata('usuario')) {
            $id = $this->input->post('id');
            $dato['get_file'] = $this->Model_Ca->get_list_cargo_archivo_temporal($id);

            if (file_exists($dato['get_file'][0]['archivo'])) {
                unlink($dato['get_file'][0]['archivo']);
            }
            $this->Model_Ca->delete_cargo_archivo_temporal($id);
        }else{
            redirect('');
        }
    }

    public function Insert_Cargo(){
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
            $valida = $this->Model_Ca->valida_usuario_para($dato['id_usuario_1']);

            if(count($valida)>=2){
                echo "cantidad";
            }else{       
                $dato['id_usuario_de']=  $this->input->post("id_usuario_de"); 
                $dato['descripcion']= $this->input->post("descripcion"); 
                $dato['id_empresa_1']=  $this->input->post("id_empresa_1"); 
                $dato['id_sede_1']= $this->input->post("id_sede_1"); 
                $dato['id_usuario_1']= $this->input->post("id_usuario_1");
                $dato['otro_1']= $this->input->post("otro_1"); 
                $dato['id_empresa_2']= $this->input->post("id_empresa_2"); 
                $dato['id_sede_2']= $this->input->post("id_sede_2"); 
                $dato['id_usuario_2']= $this->input->post("id_usuario_2"); 
                $dato['otro_2']= $this->input->post("otro_2");
                $dato['empresa_transporte']= $this->input->post("empresa_transporte"); 
                $dato['referencia']= $this->input->post("referencia"); 
                $dato['id_rubro']= $this->input->post("id_rubro");
                $dato['observacion']= $this->input->post("observacion");
    
                $get_codigo = $this->Model_Ca->get_nuevo_codigo_cargo();
                $dato['codigo']=  $get_codigo[0]['codigo'];

                $dato['id_cargo'] = $this->Model_Ca->insert_cargo($dato);

                if (!file_exists('./cargo_ca_documento/'.$dato['id_cargo'])) {
                    mkdir('./cargo_ca_documento/'.$dato['id_cargo'], 0777, true);
                    chmod('./cargo_ca_documento/', 0777);
                    chmod('./cargo_ca_documento/'.$dato['id_cargo'], 0777);
                }

                $list_temporal=$this->Model_Ca->get_list_cargo_archivo_temporal();

                foreach($list_temporal as $list){
                    if (copy($list['archivo'], "cargo_ca_documento/".$dato['id_cargo']."/".$list['nom_archivo'])) {
                        $dato['id'] = $list['id'];
                        $dato['nombre'] = $list['nombre'];
                        $dato['archivo'] = "cargo_ca_documento/".$dato['id_cargo']."/".$list['nom_archivo'];
                        $this->Model_Ca->insert_delete_cargo_archivo($dato);
                        unlink($list['archivo']);
                    }
                }

                $get_id = $this->Model_Ca->get_list_cargo($dato['id_cargo']);

                $dato['estado_c'] = 43;
                $dato['aprobado'] = 1;
                $this->Model_Ca->insert_historial_cargo($dato);
                $dato['estado_c'] = 44;
                $dato['aprobado'] = 0;
                $this->Model_Ca->insert_historial_cargo($dato);
                $dato['estado_c'] = 45;
                $dato['aprobado'] = 0;
                $this->Model_Ca->insert_historial_cargo($dato);

                $get_config = $this->Model_Ca->get_config(3);
                $url_base = $get_config[0]['url_config'];

                $id_cargo_encriptado = $encriptar($get_id[0]['id']);
            
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

                    $mail->addAddress($get_id[0]['correo_1']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$get_id[0]['codigo'].'<br>
                                    <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                    <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                    <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span><br><br>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }

                if($dato['id_usuario_2']!=0){
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

                        $mail->addAddress($get_id[0]['correo_2']);

                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = "ENVÍO DE CARGO";

                        $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$get_id[0]['codigo'].'<br>
                                        <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                        <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                        <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span><br><br>';  
                                        
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                }

                echo $dato['codigo'];
            }
        }else{
            redirect('/login');
        }
    }

    public function Editar_Cargo($id){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_list_cargo($id);
            $dato['list_usuario'] = $this->Model_Ca->get_list_usuario_cargo();
            $dato['list_empresam'] = $this->Model_Ca->get_list_empresa_cargo();
            $dato['list_sede_1'] = $this->Model_Ca->get_list_sede_cargo($dato['get_id'][0]['id_empresa_1']);
            $dato['list_sede_2'] = $this->Model_Ca->get_list_sede_cargo($dato['get_id'][0]['id_empresa_2']);
            $dato['list_rubro'] = $this->Model_Ca->get_list_rubro_cargo();
            $dato['list_historial'] = $this->Model_Ca->get_list_cargo_historial(null,$id);
            $dato['list_archivo'] = $this->Model_Ca->get_list_cargo_archivo(null,$id);

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
            
            $this->load->view('view_CA/cargo/editar', $dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Observacion_Cargo_Historial($id){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Ca->get_list_cargo_historial($id);
            $this->load->view('view_CA/cargo/modal_observacion', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Observacion_Cargo_Historial(){
        if ($this->session->userdata('usuario')) {
            $dato['id']=  $this->input->post("id"); 
            $dato['observacion']=  $this->input->post("observacion_h"); 
            $this->Model_Ca->update_observacion_cargo_historial($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Archivo_Cargo(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('view_CA/cargo/modal_archivo');
        }else{
            redirect('/login');
        }
    }

    public function Insert_Archivo_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cargo'] = $this->input->post("id_cargo");
            $dato['nombre'] = $this->input->post("nom_documento");

            $valida_1 = $this->Model_Ca->valida_insert_cargo_archivo($dato['nombre'],$dato['id_cargo']);
            $valida_2 = $this->Model_Ca->valida_insert_cargo_archivo(null,$dato['id_cargo']);

            if(count($valida_1)>0){
                echo "error";
            }elseif(count($valida_2)>4){
                echo "cantidad";
            }else{
                if($_FILES["documento"]["name"] != ""){
                    $dato['nom_documento'] = str_replace(' ','_',$_FILES["documento"]["name"]);
                    $config['upload_path'] = './cargo_ca_documento/'.$dato['id_cargo'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                        chmod($config['upload_path'], 0777);
                        chmod('./cargo_ca_documento/', 0777);
                        chmod('./cargo_ca_documento/'.$dato['id_cargo'], 0777);
                    }
                    $config["allowed_types"] = 'jpg|JPG|png|PNG|jpeg|JPEG|xls|xlsx|pdf|PDF';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $_FILES["file"]["name"] =  $dato['nom_documento'];
                    $_FILES["file"]["type"] = $_FILES["documento"]["type"];
                    $_FILES["file"]["tmp_name"] = $_FILES["documento"]["tmp_name"];
                    $_FILES["file"]["error"] = $_FILES["documento"]["error"];
                    $_FILES["file"]["size"] = $_FILES["documento"]["size"];
                    if($this->upload->do_upload('file')){
                        $data = $this->upload->data();
                        $dato['archivo'] = "cargo_ca_documento/".$dato['id_cargo']."/".$dato['nom_documento'];
                        $this->Model_Ca->insert_cargo_archivo($dato);
                    }
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function Lista_Archivo_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id_cargo'] = $this->input->post("id_cargo");
            $dato['list_temporal']=$this->Model_Ca->get_list_cargo_archivo(null,$dato['id_cargo']);
            $this->load->view('view_CA/cargo/div_temporal',$dato);
        }else{
            redirect('/login');
        }
    }

    public function Descargar_Archivo_Cargo($id) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Ca->get_list_cargo_archivo($id);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }else{
            redirect('');
        }
    }

    public function Delete_Archivo_Cargo() {
        if ($this->session->userdata('usuario')) {
            $id = $this->input->post('id');
            $dato['get_file'] = $this->Model_Ca->get_list_cargo_archivo($id);

            if (file_exists($dato['get_file'][0]['archivo'])) {
                unlink($dato['get_file'][0]['archivo']);
            }
            $this->Model_Ca->delete_cargo_archivo($id);
        }else{
            redirect('');
        }
    }

    public function Reenviar_Email(){
        if ($this->session->userdata('usuario')) {
            include "mcript.php";

            $id=  $this->input->post("id");

            $get_id = $this->Model_Ca->get_list_cargo_historial($id);

            if($get_id[0]['estado_c']==44){

                $get_config = $this->Model_Ca->get_config(3);
                $url_base = $get_config[0]['url_config'];

                $id_cargo_encriptado = $encriptar($get_id[0]['id_cargo']);

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

                    $mail->addAddress($get_id[0]['correo_1']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "APROBACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$get_id[0]['codigo'].'<br>
                                    <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                    <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                    <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span><br><br>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }

            }elseif($get_id[0]['estado_c']==45 && $get_id[0]['id_usuario_2']>0){

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

                    $mail->addAddress($get_id[0]['correo_2']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "ENVÍO DE CARGO";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$get_id[0]['codigo'].'<br>
                                    <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                    <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                    <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span><br><br>';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
                
            }elseif($get_id[0]['estado_c']==46){

                $get_config = $this->Model_Ca->get_config(3);
                $url_base = $get_config[0]['url_config'];

                $id_cargo_encriptado = $encriptar($get_id[0]['id_cargo']);

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

                    $mail->addAddress($get_id[0]['correo_1']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "RECORDATORIO APROBACIÓN/CONFIRMACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['codigo'].'<br>
                                    <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                    <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                    <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span>
                                    <b>Recordatorio que está pendiente confirmar recepción de Cargo.<b><br><br>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>';  
                                    
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

    public function Update_Cargo(){
        if ($this->session->userdata('usuario')) {
            $dato['id']=  $this->input->post("id"); 
            $dato['id_usuario_de']=  $this->input->post("id_usuario_de"); 
            $dato['descripcion']= $this->input->post("descripcion"); 
            $dato['id_empresa_1']=  $this->input->post("id_empresa_1"); 
            $dato['id_sede_1']= $this->input->post("id_sede_1"); 
            $dato['id_usuario_1']= $this->input->post("id_usuario_1"); 
            $dato['otro_1']= $this->input->post("otro_1"); 
            $dato['id_empresa_2']= $this->input->post("id_empresa_2"); 
            $dato['id_sede_2']= $this->input->post("id_sede_2"); 
            $dato['id_usuario_2']= $this->input->post("id_usuario_2"); 
            $dato['otro_2']= $this->input->post("otro_2");
            $dato['empresa_transporte']= $this->input->post("empresa_transporte"); 
            $dato['referencia']= $this->input->post("referencia"); 
            $dato['id_rubro']= $this->input->post("id_rubro");
            $dato['observacion']= $this->input->post("observacion");

            $this->Model_Ca->update_cargo($dato);
        }else{
            redirect('/login');
        }
    }

    public function Delete_Cargo(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id']= $this->input->post("id");
            $this->Model_Ca->delete_cargo($dato['id']);            
        }else{
            redirect('/login');
        }
    }

    public function Excel_Cargo($tipo){
        $list_cargo = $this->Model_Ca->get_list_cargo(null,$tipo); 

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cargos');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(18);
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

        $sheet->setCellValue("A1", 'Referencia');	   
        $sheet->setCellValue("B1", 'Fecha');	        
        $sheet->setCellValue("C1", 'De');
        $sheet->setCellValue("D1", 'Empresa Para');
        $sheet->setCellValue("E1", 'Sede Para');	        
        $sheet->setCellValue("F1", 'Usuario Para');
        $sheet->setCellValue("G1", 'Descripción');
        $sheet->setCellValue("H1", 'Estado');

        $contador=1;
        
        foreach($list_cargo as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list['usuario_de']);
            $sheet->setCellValue("D{$contador}", $list['empresa_1']);
            $sheet->setCellValue("E{$contador}", $list['sede_1']);
            $sheet->setCellValue("F{$contador}", $list['usuario_1']);
            $sheet->setCellValue("G{$contador}", $list['descripcion']);
            $sheet->setCellValue("H{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cargos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }

    public function Aprobar_Cargo_Para($id_cargo,$usuario,$ap){
        if (!$this->session->userdata('usuario')) {
            $_SESSION['usuario'] = $this->N_model->login_con_id($usuario);
        }

        include "mcript.php";

        $dato['id_cargo'] = $desencriptar($id_cargo);
        $get_id = $this->Model_Ca->get_list_cargo($dato['id_cargo']);

        $dato['estado_c'] = 46;
        $valida = $this->Model_Ca->valida_estado_cargo_historial($dato);

        if($ap==1){
            if(count($valida)>0){
                $dato['mensaje'] = "El Cargo ya estaba con recepción confirmada.";
                $dato['titulo'] = "Recepción confirmada existente!";
                $dato['tipo'] = "warning";
            }else{
                $dato['aprobado'] = 1;
                $this->Model_Ca->insert_historial_cargo($dato);

                $dato['mensaje'] = "Cargo solo recepcionado exitosamente.";
                $dato['titulo'] = "Recepción de cargo exitosa!";
                $dato['tipo'] = "success";
                
                $get_config = $this->Model_Ca->get_config(3);
                $url_base = $get_config[0]['url_config'];

                $id_cargo_encriptado = $encriptar($get_id[0]['id_cargo']);

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

                    $mail->addAddress($get_id[0]['correo_1']);

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "RECORDATORIO APROBACIÓN/CONFIRMACIÓN RECEPCIÓN";

                    $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$dato['codigo'].'<br>
                                    <b>Empresa:</b> '.$get_id[0]['cod_empresa_1'].'<br>
                                    <b>Descripción:</b> '.$get_id[0]['descripcion'].'<br>
                                    <b>Observación:</b> '.$get_id[0]['observacion'].'<br></span>
                                    <b>Recordatorio que está pendiente confirmar recepción de Cargo.<b><br><br>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                                    <a href="'.$url_base.'index.php?/Ca/Aprobar_Cargo_Para/'.$id_cargo_encriptado.'/'.$_SESSION['usuario'][0]['id_usuario'].'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>';  
                                    
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }else{
            if(count($valida)>0){
                $dato['estado_c'] = 47;
                $valida = $this->Model_Ca->valida_estado_cargo_historial($dato);

                if(count($valida)>0){
                    $dato['mensaje'] = "El Cargo ya fue recibido y confirmado.";
                    $dato['titulo'] = "Recepción y confirmación existente!";
                    $dato['tipo'] = "warning";
                }else{
                    $dato['aprobado'] = 1;
                    $this->Model_Ca->insert_historial_cargo($dato);

                    $dato['mensaje'] = "Cargo recibido y confirmado";
                    $dato['titulo'] = "Recepción y confirmación exitosa!";
                    $dato['tipo'] = "success";
                }
            }else{
                $dato['aprobado'] = 1;
                $this->Model_Ca->insert_historial_cargo($dato);

                $dato['estado_c'] = 47;
                $this->Model_Ca->insert_historial_cargo($dato);

                $dato['mensaje'] = "Cargo recibido y confirmado";
                $dato['titulo'] = "Recepción y confirmación exitosa!";
                $dato['tipo'] = "success";
            }
        }
    
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
        
        $this->load->view('view_CA/cargo/aprobacion_post', $dato);
    }
}