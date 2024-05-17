<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use SebastianBergmann\Environment\Console;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class Asistencia extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_Asistencia');
		$this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper('form');
	}

    protected function jsonResponse($respuesta = array()){
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
            $dato['list_alumno'] = $this->Model_Asistencia->get_total_matriculados();
		    $this->load->view('asistencia/index',$dato); 
        }else{
            redirect('/login');
        }
	}

    public function Limpiar_Select_Alumno(){ 
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_Asistencia->get_total_matriculados(); 
            $this->load->view('asistencia/alumnos', $dato);
        }else{
            redirect('/login');
        }
    }

	public function Lista_Registro_Ingreso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_registro_ingreso'] = $this->Model_Asistencia->get_list_registro_ingreso(); 
            $this->load->view('asistencia/lista', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Lista_Historico($codigo_alumno){
        if ($this->session->userdata('usuario')) {
            $dato['list_historico_ingreso'] = $this->Model_Asistencia->list_historial_registro_ingreso($codigo_alumno); 
            $this->load->view('asistencia/modal_listado', $dato);
        }else{
            redirect('/login');
        }
    }

	public function Botones_Bajos(){
        if ($this->session->userdata('usuario')) {
            $ingresados = count($this->Model_Asistencia->get_alumnos_ingresados());
            $total = count($this->Model_Asistencia->get_total_matriculados());
            $sin_salida = count($this->Model_Asistencia->get_alumnos_sin_salida());
            $dato['ingresados'] = $ingresados;
            $dato['pendientes'] = $total-$ingresados;
            $dato['sin_salida'] = $sin_salida;
            $this->load->view('asistencia/botones', $dato); 
        }else{
            redirect('/login');
        }
    }

	public function Insert_Alumno_FV(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("codigo_alumno");
            $dato['reg_automatico'] = 1;

            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);

            if(count($dato['get_id'])>0){
                if($dato['get_id'][0]['Grupo']=='22/3'){
                    if($dato['get_id'][0]['Pago_Matricula_1']==1 && $dato['get_id'][0]['Pago_Cuota_1']==1){
                        $dato['id_alumno'] = $dato['get_id'][0]['Id'];
                        $validar = $this->Model_Asistencia->valida_registro_ingreso($dato);
            
                        if(count($validar)>0){
                            echo "repetido";
                        }else{
                            if($dato['get_id'][0]['Pago_Pendiente']>=2){
                                echo "cuotas";
                            }else{
                                $dato['grado'] = '';
                                $dato['seccion'] = '';
                                $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
                                $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
                                $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
                                $dato['nombres'] = $dato['get_id'][0]['Nombre'];
                                $dato['especialidad'] = $dato['get_id'][0]['Especialidad']; 
                                $dato['grupo'] = $dato['get_id'][0]['Grupo'];
                                $dato['modulo'] = $dato['get_id'][0]['Modulo'];
                
                                $hora = getdate()['hours'];
                                $minuto = getdate()['minutes'];
                
                                if($hora>=7){
                                    if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                                    $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                                    $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                                    $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                                    $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                                        $dato['estado_ingreso'] = 1; 
                                    }else{
                                        $dato['estado_ingreso'] = 2;
                                    }
                                }else{
                                    $dato['estado_ingreso'] = 1;
                                }
                
                                $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);
                
                                if($dato['get_id'][0]['Tipo']==1){
                                    if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                                        $dato['estado_reporte'] = 1;
                                        $dato['user_autorizado'] = 0;
                                        $dato['duplicidad'] = 0;
                                        $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                        $this->Model_Asistencia->insert_registro_ingreso($dato);
                                        $dato['simbolo'] = 1;
                                    }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                                        $dato['simbolo'] = 3;
                                    }else{
                                        $dato['simbolo'] = 2;
                                    }
                                }elseif($dato['get_id'][0]['Tipo']==2){
                                    if(count($valida_foto)>0){
                                        $dato['estado_reporte'] = 1;
                                        $dato['user_autorizado'] = 0;
                                        $dato['duplicidad'] = 0;
                                        $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                        $this->Model_Asistencia->insert_registro_ingreso($dato);
                                        $dato['simbolo'] = 1;
                                    }else{
                                        $dato['simbolo'] = 2; 
                                    }
                                }else{
                                    $dato['estado_reporte'] = 1;
                                    $dato['user_autorizado'] = 0;
                                    $dato['duplicidad'] = 0;
                                    $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                                    $dato['simbolo'] = 1;
                                }
                
                                $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                $this->load->view('asistencia/registro', $dato);
                            }
                        }
                    }else{
                        echo "pagos";
                    }
                }else{
                    $dato['id_alumno'] = $dato['get_id'][0]['Id'];
                    $validar = $this->Model_Asistencia->valida_registro_ingreso($dato);
        
                    if(count($validar)>0){
                        if($dato['get_id'][0]['Tipo']==1){
                            echo "repetido";
                        }else{
                            $valida_hora = $this->Model_Asistencia->valida_update_registro_ingreso($dato['get_id'][0]['Id']);

                            if(count($valida_hora)>0){
                                if($valida_hora[0]['minutos']>180){
                                    $dato['id_registro_ingreso'] = $valida_hora[0]['id_registro_ingreso'];
                                    $this->Model_Asistencia->update_registro_ingreso($dato);
                                }else{
                                    echo "reingreso";
                                }
                            }else{
                                echo "repetido";
                            }
                        } 
                    }else{
                        if($dato['get_id'][0]['Pago_Pendiente']>=2){
                            echo "cuotas";
                        }else{
                            $dato['grado'] = '';
                            $dato['seccion'] = '';
                            $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
                            $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
                            $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
                            $dato['nombres'] = $dato['get_id'][0]['Nombre'];
                            $dato['especialidad'] = $dato['get_id'][0]['Especialidad']; 
                            $dato['grupo'] = $dato['get_id'][0]['Grupo'];
                            $dato['modulo'] = $dato['get_id'][0]['Modulo'];
            
                            $hora = getdate()['hours'];
                            $minuto = getdate()['minutes'];
            
                            if($hora>=7){
                                if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                                $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                                $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                                $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                                $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                                    $dato['estado_ingreso'] = 1; 
                                }else{
                                    $dato['estado_ingreso'] = 2;
                                }
                            }else{
                                $dato['estado_ingreso'] = 1;
                            }
            
                            $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                            $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);
            
                            if($dato['get_id'][0]['Tipo']==1){
                                if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                                    $dato['estado_reporte'] = 1;
                                    $dato['user_autorizado'] = 0;
                                    $dato['duplicidad'] = 0;
                                    $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                                    $dato['simbolo'] = 1;
                                }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                                    $dato['simbolo'] = 3;
                                }else{
                                    $dato['simbolo'] = 2;
                                }
                            }elseif($dato['get_id'][0]['Tipo']==2){
                                if(count($valida_foto)>0){
                                    $dato['estado_reporte'] = 1;
                                    $dato['user_autorizado'] = 0;
                                    $dato['duplicidad'] = 0;
                                    $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                                    $dato['simbolo'] = 1;
                                }else{
                                    $dato['simbolo'] = 2; 
                                }
                            }else{
                                $dato['estado_reporte'] = 1;
                                $dato['user_autorizado'] = 0;
                                $dato['duplicidad'] = 0;
                                $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                                $this->Model_Asistencia->insert_registro_ingreso($dato);
                                $dato['simbolo'] = 1;
                            }
            
                            $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                            $this->load->view('asistencia/registro', $dato);
                        }
                    }
                }
            }else{
                $validar = $this->Model_Asistencia->get_cod_matriculado_promovido($codigo_alumno);

                if(count($validar)>0){
                    echo "promovido";
                }else{
                    echo "error";
                }
            }
        }else{
            redirect('/login');
        }
    }

    public function ReInsert_Alumno_FV(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("codigo_alumno");
            $dato['reg_automatico'] = 1;

            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $dato['id_alumno'] = $dato['get_id'][0]['Id'];

            $dato['grado'] = '';
            $dato['seccion'] = '';
            $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
            $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
            $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
            $dato['nombres'] = $dato['get_id'][0]['Nombre'];
            $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
            $dato['grupo'] = $dato['get_id'][0]['Grupo'];
            $dato['modulo'] = $dato['get_id'][0]['Modulo'];

            $hora = getdate()['hours'];
            $minuto = getdate()['minutes'];

            if($hora>=7){
                if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                    $dato['estado_ingreso'] = 1; 
                }else{
                    $dato['estado_ingreso'] = 2;
                }
            }else{
                $dato['estado_ingreso'] = 1;
            }

            $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
            $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);

            if($dato['get_id'][0]['Tipo']==1){
                if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                    $dato['estado_reporte'] = 1;
                    $dato['user_autorizado'] = 0;
                    $dato['duplicidad'] = 0;
                    $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                    $dato['simbolo'] = 1;
                }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                    $dato['simbolo'] = 3;
                }else{
                    $dato['simbolo'] = 2;
                }
            }elseif($dato['get_id'][0]['Tipo']==2){
                if(count($valida_foto)>0){
                    $dato['estado_reporte'] = 1;
                    $dato['user_autorizado'] = 0;
                    $dato['duplicidad'] = 0;
                    $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                    $dato['simbolo'] = 1;
                }else{
                    $dato['simbolo'] = 2; 
                }
            }else{
                $dato['estado_reporte'] = 1;
                $dato['user_autorizado'] = 0;
                $dato['duplicidad'] = 0;
                $this->Model_Asistencia->update_duplicidad_registro_ingreso($dato);
                $this->Model_Asistencia->insert_registro_ingreso($dato);
                $dato['simbolo'] = 1;
            }

            //$dato['list_pago_pendiente'] = $this->Model_Asistencia->get_list_pagos_registro_ingreso($dato['id_alumno']); 
            $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
            $this->load->view('asistencia/registro', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumno_FV(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("codigo_alumno");
            $get_id = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $ultimo = $this->Model_Asistencia->valida_update_registro_ingreso($get_id[0]['Id']);
            $dato['id_registro_ingreso'] = $ultimo[0]['id_registro_ingreso'];
            $this->Model_Asistencia->update_registro_ingreso($dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Valida_Registro_Manual(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('asistencia/modal_valida');   
        }else{
            redirect('/login');
        }
    }

    public function Abrir_Registro_Manual(){
        if ($this->session->userdata('usuario')) {
            $dato['clave_valida'] = $this->input->post("clave_valida");

            $get_clave = $this->Model_Asistencia->get_clave_asistencia($dato['clave_valida']);

            if(count($get_clave)==0){
                echo "error";
            } 
        }else{
            redirect('/login');
        }
    }

    public function Modal_Registro_Ingreso(){
        if ($this->session->userdata('usuario')) {
            $dato['list_alumno'] = $this->Model_Asistencia->get_total_matriculados();
            $this->load->view('asistencia/modal_buscar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Insert_Alumno_FV_Modal(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("alumno");
            $dato['reg_automatico'] = 2;

            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);

            if(count($dato['get_id'])>0){ 
                $dato['id_alumno'] = $dato['get_id'][0]['Id'];
                $valida_duplicidad = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);

                if(count($valida_duplicidad)>=10){
                    echo "duplicidad";
                }else{
                    if($dato['get_id'][0]['Grupo']=='22/3'){
                        if($dato['get_id'][0]['Pago_Matricula_1']==1 && $dato['get_id'][0]['Pago_Cuota_1']==1){
                            $dato['id_alumno'] = $dato['get_id'][0]['Id'];
                            $validar = $this->Model_Asistencia->valida_registro_ingreso($dato);
                
                            if(count($validar)>0){
                                echo "repetido";
                            }else{
                                if($dato['get_id'][0]['Pago_Pendiente']>=2){
                                    echo "cuotas";
                                }else{
                                    $dato['grado'] = '';
                                    $dato['seccion'] = '';
                                    $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
                                    $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
                                    $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
                                    $dato['nombres'] = $dato['get_id'][0]['Nombre'];
                                    $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
                                    $dato['grupo'] = $dato['get_id'][0]['Grupo'];
                                    $dato['modulo'] = $dato['get_id'][0]['Modulo'];
                                    $hora = getdate()['hours'];
                                    $minuto = getdate()['minutes'];
                    
                                    if($hora>=7){
                                        if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                                        $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                                        $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                                        $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                                        $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                                            $dato['estado_ingreso'] = 1;
                                        }else{
                                            $dato['estado_ingreso'] = 2;
                                        }
                                    }else{
                                        $dato['estado_ingreso'] = 1;
                                    }
                    
                                    $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                    $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);
                    
                                    if($dato['get_id'][0]['Tipo']==1){
                                        if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                                            $dato['estado_reporte'] = 1;
                                            $dato['user_autorizado'] = 0;
                                            $dato['duplicidad'] = 1;
                                            $this->Model_Asistencia->insert_registro_ingreso($dato);
                                            $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                            $dato['simbolo'] = 1;
                                        }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                                            $dato['simbolo'] = 3;
                                        }else{
                                            $dato['simbolo'] = 2;
                                        }
                                    }elseif($dato['get_id'][0]['Tipo']==2){
                                        if(count($valida_foto)>0){
                                            $dato['estado_reporte'] = 1;
                                            $dato['user_autorizado'] = 0;
                                            $dato['duplicidad'] = 1;
                                            $this->Model_Asistencia->insert_registro_ingreso($dato);
                                            $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                            $dato['simbolo'] = 1;
                                        }else{
                                            $dato['simbolo'] = 2; 
                                        }
                                    }else{
                                        $dato['estado_reporte'] = 1;
                                        $dato['user_autorizado'] = 0;
                                        $dato['duplicidad'] = 1;
                                        $this->Model_Asistencia->insert_registro_ingreso($dato);
                                        $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                        $dato['simbolo'] = 1;
                                    }
                    
                                    //$dato['list_pago_pendiente'] = $this->Model_Asistencia->get_list_pagos_registro_ingreso($dato['id_alumno']);
                                    $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                    $this->load->view('asistencia/registro', $dato);
                                }
                            }
                        }else{
                            echo "pagos";
                        }
                    }else{
                        $dato['id_alumno'] = $dato['get_id'][0]['Id'];
                        $validar = $this->Model_Asistencia->valida_registro_ingreso($dato);
                        if(count($validar)>0){
                            if($dato['get_id'][0]['Tipo']==1){
                                echo "repetido";
                            }else{
                                $valida_hora = $this->Model_Asistencia->valida_update_registro_ingreso($dato['get_id'][0]['Id']);

                                if(count($valida_hora)>0){
                                    if($valida_hora[0]['minutos']>180){
                                        $dato['id_registro_ingreso'] = $valida_hora[0]['id_registro_ingreso'];
                                        $this->Model_Asistencia->update_registro_ingreso($dato);
                                    }else{
                                        echo "reingreso";
                                    }
                                }else{
                                    echo "repetido";
                                }
                            }
                        }else{
                            if($dato['get_id'][0]['Pago_Pendiente']>=2){
                                echo "cuotas";
                            }else{
                                $dato['grado'] = '';
                                $dato['seccion'] = '';
                                $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
                                $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
                                $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
                                $dato['nombres'] = $dato['get_id'][0]['Nombre'];
                                $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
                                $dato['grupo'] = $dato['get_id'][0]['Grupo'];
                                $dato['modulo'] = $dato['get_id'][0]['Modulo'];
                                $hora = getdate()['hours'];
                                $minuto = getdate()['minutes'];
                
                                if($hora>=7){
                                    if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                                    $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                                    $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                                    $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                                    $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                                        $dato['estado_ingreso'] = 1;
                                    }else{
                                        $dato['estado_ingreso'] = 2;
                                    }
                                }else{
                                    $dato['estado_ingreso'] = 1;
                                }
                
                                $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);
                
                                if($dato['get_id'][0]['Tipo']==1){
                                    if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                                        $dato['estado_reporte'] = 1;
                                        $dato['user_autorizado'] = 0;
                                        $dato['duplicidad'] = 1;
                                        $this->Model_Asistencia->insert_registro_ingreso($dato);
                                        $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                        $dato['simbolo'] = 1;
                                    }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                                        $dato['simbolo'] = 3;
                                    }else{
                                        $dato['simbolo'] = 2;
                                    }
                                }elseif($dato['get_id'][0]['Tipo']==2){
                                    if(count($valida_foto)>0){
                                        $dato['estado_reporte'] = 1;
                                        $dato['user_autorizado'] = 0;
                                        $dato['duplicidad'] = 1;
                                        $this->Model_Asistencia->insert_registro_ingreso($dato);
                                        $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                        $dato['simbolo'] = 1;
                                    }else{
                                        $dato['simbolo'] = 2; 
                                    }
                                }else{
                                    $dato['estado_reporte'] = 1;
                                    $dato['user_autorizado'] = 0;
                                    $dato['duplicidad'] = 1;
                                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                                    $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                                    $dato['simbolo'] = 1;
                                }
                
                                //$dato['list_pago_pendiente'] = $this->Model_Asistencia->get_list_pagos_registro_ingreso($dato['id_alumno']);
                                $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                                $this->load->view('asistencia/registro', $dato);
                            }
                        }
                    }
                }
            }else{
                echo "error";
            }
        }else{
            redirect('/login');
        }
    }

    public function ReInsert_Alumno_FV_Modal(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("alumno");
            $dato['reg_automatico'] = 2;

            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $dato['id_alumno'] = $dato['get_id'][0]['Id'];

            $dato['grado'] = '';
            $dato['seccion'] = '';
            $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
            $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
            $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
            $dato['nombres'] = $dato['get_id'][0]['Nombre'];
            $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
            $dato['grupo'] = $dato['get_id'][0]['Grupo'];
            $dato['modulo'] = $dato['get_id'][0]['Modulo'];

            $hora = getdate()['hours'];
            $minuto = getdate()['minutes'];

            if($hora>=7){
                if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                    $dato['estado_ingreso'] = 1;
                }else{
                    $dato['estado_ingreso'] = 2;
                }
            }else{
                $dato['estado_ingreso'] = 1;
            }

            $valida_foto = $this->Model_Asistencia->valida_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
            $Documento_Pendiente = $dato['get_id'][0]['documentos_obligatorios']-($dato['get_id'][0]['documentos_subidos']+$dato['get_id'][0]['Primer_Documento']+$dato['get_id'][0]['Segundo_Documento']);

            if($dato['get_id'][0]['Tipo']==1){
                if((count($valida_foto)>0 && $dato['get_id'][0]['Pago_Pendiente']==0 && $Documento_Pendiente==0) || $dato['get_id'][0]['Pago_Pendiente']<2){
                    $dato['estado_reporte'] = 1;
                    $dato['user_autorizado'] = 0;
                    $dato['duplicidad'] = 1;
                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                    $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                    $dato['simbolo'] = 1;
                }elseif(count($valida_foto)==0 && $dato['get_id'][0]['Pago_Pendiente']>=2 && $Documento_Pendiente>0){
                    $dato['simbolo'] = 3;
                }else{
                    $dato['simbolo'] = 2;
                }
            }elseif($dato['get_id'][0]['Tipo']==2){
                if(count($valida_foto)>0){
                    $dato['estado_reporte'] = 1;
                    $dato['user_autorizado'] = 0;
                    $dato['duplicidad'] = 1;
                    $this->Model_Asistencia->insert_registro_ingreso($dato);
                    $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                    $dato['simbolo'] = 1;
                }else{
                    $dato['simbolo'] = 2; 
                }
            }else{
                $dato['estado_reporte'] = 1;
                $dato['user_autorizado'] = 0;
                $dato['duplicidad'] = 1;
                $this->Model_Asistencia->insert_registro_ingreso($dato);
                $dato['get_duplicidad'] = $this->Model_Asistencia->traer_duplicidad_registro_ingreso($dato);
                $dato['simbolo'] = 1;
            }

            //$dato['list_pago_pendiente'] = $this->Model_Asistencia->get_list_pagos_registro_ingreso($dato['id_alumno']); 
            $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
            $this->load->view('asistencia/registro', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Alumno_FV_Modal(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("alumno");
            $get_id = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $ultimo = $this->Model_Asistencia->valida_update_registro_ingreso($get_id[0]['Id']);
            $dato['id_registro_ingreso'] = $ultimo[0]['id_registro_ingreso'];
            $this->Model_Asistencia->update_registro_ingreso($dato);
        }else{
            redirect('/login');
        }
    }

    public function Traer_Pendientes(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("alumno");
            $get_id = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            echo $get_id[0]['Pago_Pendiente']."-".$get_id[0]['Documento_Pendiente'];
        }else{
            redirect('/login');
        }
    }

    public function Insert_Observacion(){
        if ($this->session->userdata('usuario')) {
            $dato['reg_automatico'] = 1;
            $codigo_alumno = $this->input->post("codigo_alumno");
            $dato['observacion'] = $this->input->post("observacion");
            $dato['tipo']= $this->input->post("tipo");
            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $dato['id_alumno'] = $dato['get_id'][0]['Id'];

            $dato['grado'] = '';
            $dato['seccion'] = '';
            $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
            $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
            $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
            $dato['nombres'] = $dato['get_id'][0]['Nombre'];
            $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
            $dato['grupo'] = $dato['get_id'][0]['Grupo'];
            $dato['modulo'] = $dato['get_id'][0]['Modulo'];

            $hora = getdate()['hours'];
            $minuto = getdate()['minutes'];

            if($hora>=7){
                if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                    $dato['estado_ingreso'] = 1;
                }else{
                    $dato['estado_ingreso'] = 2;
                }
            }else{
                $dato['estado_ingreso'] = 1;
            }

            $dato['estado_reporte'] = 1;
            $dato['user_autorizado'] = 0;

            $this->Model_Asistencia->insert_registro_ingreso($dato);

            if($dato['observacion']!=""){
                $ultimo = $this->Model_Asistencia->ultimo_id_registro_ingreso();
                $dato['id_registro_ingreso'] = $ultimo[0]['id_registro_ingreso'];
        
                $this->Model_Asistencia->insert_historial_registro_ingreso($dato);
            }

            $dato['simbolo'] = 1;

            $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
            $this->load->view('asistencia/registro', $dato);
        }else{
            redirect('/login');
        }
    }

    public function Modal_Delete_Registro_Ingreso($id_registro_ingreso){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Asistencia->get_list_registro_ingreso($id_registro_ingreso);
            $this->load->view('asistencia/modal_eliminar', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Delete_Registro_Ingreso(){
        if ($this->session->userdata('usuario')) {
            $dato['id_registro_ingreso'] = $this->input->post("id_registro_ingreso");
            $dato['clave_admin'] = $this->input->post("clave_admin");

            $get_clave = $this->Model_Asistencia->get_clave_asistencia($dato['clave_admin']);

            if(count($get_clave)>0){
                $this->Model_Asistencia->delete_registro_ingreso($dato);
            }else{
                echo "error";
            } 
        }else{
            redirect('/login');
        }
    }

    public function Autorizacion_Condicionado(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("codigo_alumno");
            $dato['observacion'] = $this->input->post("observacion");
            $dato['clave_admin'] = $this->input->post("clave_admin");
            $dato['tipo']= $this->input->post("tipo");

            $get_clave = $this->Model_Asistencia->get_clave_asistencia($dato['clave_admin']);

            if(count($get_clave)>0){
                $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
                $dato['id_alumno'] = $dato['get_id'][0]['Id'];

                $dato['grado'] = '';
                $dato['seccion'] = '';
                $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
                $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
                $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
                $dato['nombres'] = $dato['get_id'][0]['Nombre'];
                $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
                $dato['grupo'] = $dato['get_id'][0]['Grupo'];
                $dato['modulo'] = $dato['get_id'][0]['Modulo'];

                $hora = getdate()['hours'];
                $minuto = getdate()['minutes'];

                if($hora>=7){
                    if($hora==7 && ($minuto==0 || $minuto==1 || $minuto==2 || $minuto==3 || $minuto==4 || $minuto==5 || 
                    $minuto==6 || $minuto==7 || $minuto==8 || $minuto==9 || $minuto==10 || $minuto==11 || $minuto==12 || 
                    $minuto==13 || $minuto==14 || $minuto==15 || $minuto==16 || $minuto==17 || $minuto==18 || $minuto==19 || 
                    $minuto==20 || $minuto==21 || $minuto==22 || $minuto==23 || $minuto==24 || $minuto==25 || $minuto==26 || 
                    $minuto==27 || $minuto==28 || $minuto==29 || $minuto==30)){
                        $dato['estado_ingreso'] = 1;
                    }else{
                        $dato['estado_ingreso'] = 2;
                    }
                }else{
                    $dato['estado_ingreso'] = 1;
                }

                $dato['estado_reporte'] = 2;
                $dato['user_autorizado'] = $get_clave[0]['id_usuario'];
                
                $this->Model_Asistencia->insert_registro_ingreso($dato);

                if($dato['observacion']!=""){
                    $ultimo = $this->Model_Asistencia->ultimo_id_registro_ingreso();
                    $dato['id_registro_ingreso'] = $ultimo[0]['id_registro_ingreso'];
            
                    $this->Model_Asistencia->insert_historial_registro_ingreso($dato);
                }

                $dato['simbolo'] = 1;

                $dato['get_foto'] = $this->Model_Asistencia->get_foto_matriculado($dato['get_id'][0]['Id'],$dato['get_id'][0]['Tipo']);
                $this->load->view('asistencia/registro', $dato);
            }else{
                echo "error";
            } 
        }else{
            redirect('/login');
        }
    }

    public function No_Ingresa_Condicionado(){
        if ($this->session->userdata('usuario')) {
            $codigo_alumno = $this->input->post("codigo_alumno");
            $dato['observacion'] = $this->input->post("observacion");
            $dato['tipo']= $this->input->post("tipo");
            $dato['get_id'] = $this->Model_Asistencia->get_cod_matriculado($codigo_alumno);
            $dato['id_alumno'] = $dato['get_id'][0]['Id'];

            $dato['grado'] = '';
            $dato['seccion'] = '';
            $dato['codigo'] = $dato['get_id'][0]['Codigoa'];
            $dato['apater'] = $dato['get_id'][0]['Apellido_Paterno'];
            $dato['amater'] = $dato['get_id'][0]['Apellido_Materno'];
            $dato['nombres'] = $dato['get_id'][0]['Nombre'];
            $dato['especialidad'] = $dato['get_id'][0]['Especialidad'];
            $dato['grupo'] = $dato['get_id'][0]['Grupo'];
            $dato['modulo'] = $dato['get_id'][0]['Modulo'];
            $dato['estado_ingreso'] = 3;
            
            $dato['estado_reporte'] = 3;
            $dato['user_autorizado'] = 0;

            $this->Model_Asistencia->insert_registro_ingreso($dato);

            if($dato['observacion']!=""){
                $ultimo = $this->Model_Asistencia->ultimo_id_registro_ingreso();
                $dato['id_registro_ingreso'] = $ultimo[0]['id_registro_ingreso'];
        
                $this->Model_Asistencia->insert_historial_registro_ingreso($dato);
            }
        }else{
            redirect('/login');
        }
    }

    public function Modal_Registro_Salida(){
        if ($this->session->userdata('usuario')) {
            $dato['list_salida'] = $this->Model_Asistencia->get_list_registro_salida();
            $this->load->view('asistencia/modal_salida', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Lista_Registro_Salida(){
        if ($this->session->userdata('usuario')) {
            $dato['list_salida'] = $this->Model_Asistencia->get_list_registro_salida();
            $this->load->view('asistencia/lista_salida', $dato);   
        }else{
            redirect('/login');
        }
    }

    public function Update_Registro_Salida(){
        if ($this->session->userdata('usuario')) {
            $dato['id_registro_ingreso'] = $this->input->post("id_registro_ingreso");
            $this->Model_Asistencia->update_registro_salida($dato);
        }else{
            redirect('/login');
        }
    }

    public function Update_Registro_Salida_No_Registrada(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_registro_ingreso'] = $this->input->post("id_registro_ingreso");
            $this->Model_Asistencia->update_registro_salida_no_registrada($dato);

            $get_id = $this->Model_Asistencia->get_list_registro_ingreso($dato['id_registro_ingreso']);

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
                $mail->setFrom('noreplay@ifv.edu.pe', 'Sin Salida'); //desde donde se envia 
                
                $mail->addAddress($get_id[0]['email']);
                $mail->addAddress('rosanna.apolaya@gllg.edu.pe'); 
                $mail->addAddress('nestor.felix@ifv.edu.pe');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = "¡SIN REGISTRO DE SALIDA - ".$get_id[0]['codigo']."!";  
        
                $mail->Body =  "<FONT SIZE=3>
                                    ¡Hola!<br><br>
                                    Informamos que el siguiente colaborador no ha registrado su salida.<br>
                                    <b>Código:</b> ".$get_id[0]['codigo']."<br>
                                    <b>Colaborador:</b> ".$get_id[0]['nombre_completo']."<br>
                                    <b>Cargo:</b> ".$get_id[0]['nom_cargo']."<br>
                                    <b>Fecha:</b> ".$get_id[0]['fecha']."<br><br>
                                    Recordamos que el registro del ingreso y salida es obligatorio para todos los colaboradores sin cualquier excepción. Incluyendo hora de refrigerio.
                                </FONT SIZE>";
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }else{
            redirect('/login');
        }
    }
}
