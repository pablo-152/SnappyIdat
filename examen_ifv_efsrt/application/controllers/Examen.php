<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Examen extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
        $this->load->model('Model_Examen');
        $this->load->database();

    }

    //--------------------------------------------------------------------------------------------------

    public function Salir()
    {
        $this->session->sess_destroy();
        $this->load->view('sinportulante');
    }

    public function Tiempo_Agotado()
    {
        $this->session->sess_destroy();
        $this->load->view('sintiempo');
    }

    public function index($cod)
    {
        $dato['codigo']=$cod;
        $dato['get_id'] = $this->Model_Examen->get_postulante($dato);
        $dato['get_examen'] = $this->Model_Examen->examen_activo();
        if(count($dato['get_id'])>0 && count($dato['get_examen'])>0){
            if($dato['get_id'][0]['fec_examen']==$dato['get_examen'][0]['fec_examen']){
                $dato['fec_examen']=$dato['get_id'][0]['fec_examen'];
                $array_carreras=explode(",", $dato['get_examen'][0]['examen_carrera']);
                $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];
                if (in_array($dato['id_carrera'], $array_carreras)) {
                    $_SESSION['usuario'] = $dato['get_id'];
                    $dato['id_examen']=$dato['get_examen'][0]['id_examen'];
                    $dato['id_postulante']=$dato['get_id'][0]['id_postulante'];
                    $dato['list_pregunta'] = $this->Model_Examen->get_list_carrera_examen_efsrt($dato);
                    $dato['historial'] = $this->Model_Examen->lista_pregunta_exonerada($dato);
                    
                    $dato['id_examen']=$dato['get_examen'][0]['id_examen']; 
                    $dato['fec_examen']=$dato['get_examen'][0]['fec_examen']; 
                    $dato['get_tiempo'] = $this->Model_Examen->consulta_tiempo_examen($dato);
                    $dato['ahora']=date('H:i:s', time());
                    if(count($dato['historial'])>0){
                        $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);
                        //$dato['ahora']=date('Y-m-d H:i:s', time()); 
                         
                        $dato['inicio']=$dato['get_resultado'][0]['limite'];
                        $tiempo_limite=$dato['get_resultado'][0]['limite'];

                        //if($dato['ahora']>=$dato['inicio']){
                        if($dato['ahora']>=$dato['get_tiempo'][0]['hora_final']){
                            $this->Model_Examen->bloqueo_tiempo_limite($dato);
                            redirect('Examen/Tiempo_Agotado');
                        }else{
                            redirect('Examen/index1/'.$dato['id_postulante']."/".$dato['id_examen']);
                        }
                    }else{
                        if($dato['ahora']>=$dato['get_tiempo'][0]['hora_final']){
                            $this->Model_Examen->bloqueo_tiempo_limite_2($dato);
                            //redirect('Examen/Examen_No_Disponible');
                        }else{
                            $this->load->view('index',$dato);
                        }
                    }
                } else {
                    echo "El número 3 no existe en el array";
                }
            }else{
                $this->session->sess_destroy();
                $this->load->view('sinportulante');  
            }
        }else{
            $this->session->sess_destroy();
            $this->load->view('sinportulante');
        }
    }

    function Examen_No_Disponible(){
        $this->load->view('sinportulante');
    }

    public function index1($id_postulante=null,$id_examen=null)
    {
        if ($this->session->userdata('usuario')) {
            if(isset($id_postulante) && $id_postulante!="" && isset($id_examen) && $id_examen!=""){
                $dato['id_postulante']=$id_postulante;
                $dato['id_examen']=$id_examen;
            }else{
                $dato['id_postulante']=$this->input->post("id_postulante");
                $dato['id_examen']=$this->input->post("id_examen");  
            }
            $dato['get_id'] = $this->Model_Examen->get_id_postulante($dato);
            $dato['get_examen'] = $this->Model_Examen->get_id_examen($dato);
            if(count($dato['get_id'])>0 && count($dato['get_examen'])>0){
                
                $dato['codigo']=$dato['get_id'][0]['codigo'];
                
                if($dato['get_id'][0]['fec_examen']==$dato['get_examen'][0]['fec_examen']){
                    $dato['fec_examen']=$dato['get_id'][0]['fec_examen'];
                    $dato['get_tiempo'] = $this->Model_Examen->consulta_tiempo_examen($dato);
                    $array_carreras=explode(",", $dato['get_examen'][0]['examen_carrera']);
                    $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];
                    if (in_array($dato['id_carrera'], $array_carreras)) {
                        $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);
                        if(count($dato['get_resultado'])>0){
                            if($dato['get_resultado'][0]['estado']!=56){
                                redirect('Examen/Salir');
                            }
                        }else{
                            $this->Model_Examen->insert_tiempo_ini_examen($dato);
                        }

                        $dato['historial'] = $this->Model_Examen->lista_pregunta_exonerada($dato);
                        if(count($dato['historial'])==0){
                            $dato['lista_pregunta'] = $this->Model_Examen->get_list_carrera_examen_efsrt($dato);

                            $i=0;
                            foreach($dato['lista_pregunta'] as $preg){
                                $dato['id_pregunta']=$preg['id_pregunta'];
                                $dato['pregunta']=$preg['pregunta'];
                                $dato['img']=$preg['img'];
                                $i=$i+1;
                                $this->Model_Examen->insert_pregunta_exonerada($dato);
                            }
                        }

                        $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                        //$dato['ahora']=date('Y-m-d H:i:s', time()); 
                        $dato['ahora']=date('H:i:s', time()); 
                        $dato['inicio']=$dato['get_resultado'][0]['limite'];

                        $tiempo_limite=$dato['get_resultado'][0]['limite'];

                        //if($dato['ahora']>=$dato['inicio']){
                        if($dato['ahora']>=$dato['get_tiempo'][0]['hora_final']){
                            $this->Model_Examen->bloqueo_tiempo_limite($dato);
                            redirect('Examen/Tiempo_Agotado'); 
                        }
                        $dato['get_id_pregunta'] = $this->Model_Examen->get_id_preguntas_exonerada($dato);
                        $dato['list_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                        shuffle($dato['list_pregunta']);
                        $dato['list_respuesta'] = $this->Model_Examen->get_list_respuesta($dato);
                        $dato['get_link'] = $this->Model_Examen->get_config();
                        shuffle($dato['list_respuesta']);

                        //----
                        /*$tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $horaInicio = new DateTime($tiempo_final);
                        $horaTermino = new DateTime($dato['ahora']);

                        $interval = $horaInicio->diff($horaTermino);
                        $hora=$interval->format('%h');
                        $minuto=$interval->format('%i');
                        $segundos=$interval->format('%s');
                        $h=$hora*3600;
                        $h_s=$h*1000;
                        $ss = $segundos*1000;
                        $ms = $minuto*60;
                        $mss= $ms*1000;
                        $dato['timer']=$ss+$mss+$h_s;

                        $horaInicio1 = new DateTime($tiempo_limite);
                        $horaTermino1 = new DateTime($dato['ahora']);

                        $interval1 = $horaInicio1->diff($horaTermino1);
                        $hora1=$interval1->format('%h');
                        $minuto1=$interval1->format('%i');
                        $segundos1=$interval1->format('%s');

                        $h1=$hora1*3600;
                        $h_s1=$h1*1000;
                        $ss1 = $segundos1*1000;
                        $ms1 = $minuto1*60;
                        $mss1= $ms1*1000;
                        $dato['timer120']=$ss1+$mss1+$h_s1;*/
                        $this->load->view('index1',$dato);
                    }else{
                        $this->session->sess_destroy();
                        $this->load->view('sinportulante');
                    }
                }
            }else{
                $this->session->sess_destroy();
                $this->load->view('sinportulante');
            }

        }else{
            $this->session->sess_destroy();
            $this->load->view('sinportulante');

        }
    }

    public function Resultado()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_postulante']=$this->input->post("id_postulante");
            $dato['id_examen']=$this->input->post("id_examen");
            $dato['get_id'] = $this->Model_Examen->get_id_postulante($dato);
            $dato['get_examen'] = $this->Model_Examen->examen_activo();
            $dato['get_config_examen'] = $this->Model_Examen->get_config_examen();
            $nota=$dato['get_config_examen'][0]['nota']/10;
            if(count($dato['get_id'])>0 && count($dato['get_examen'])>0){
                if($dato['get_id'][0]['fec_examen']==$dato['get_examen'][0]['fec_examen']){
                    $dato['codigo']=$dato['get_id'][0]['codigo'];
                    $dato['fec_examen']=$dato['get_id'][0]['fec_examen'];
                    $array_carreras=explode(",", $dato['get_examen'][0]['examen_carrera']);
                    $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];
                    if (in_array($dato['id_carrera'], $array_carreras)) {
                        $dato['resultado'] = $this->Model_Examen->resultado_examen_ifv($dato);
                        if(count($dato['resultado'])==1 && $dato['resultado'][0]['estado']==56)
                        {
                            $respuesta1=explode("-",$this->input->post("id_respuesta1"));
                            $respuesta2=explode("-",$this->input->post("id_respuesta2"));
                            $respuesta3=explode("-",$this->input->post("id_respuesta3"));
                            $respuesta4=explode("-",$this->input->post("id_respuesta4"));
                            $respuesta5=explode("-",$this->input->post("id_respuesta5"));
                            $respuesta6=explode("-",$this->input->post("id_respuesta6"));
                            $respuesta7=explode("-",$this->input->post("id_respuesta7"));
                            $respuesta8=explode("-",$this->input->post("id_respuesta8"));
                            $respuesta9=explode("-",$this->input->post("id_respuesta9"));
                            $respuesta10=explode("-",$this->input->post("id_respuesta10"));

                            $score=0;
                            if($respuesta1[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta2[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta3[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta4[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta5[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta6[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta7[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta8[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta9[1]==1){
                                $score=$score+$nota;
                            }
                            if($respuesta10[1]==1){
                                $score=$score+$nota;
                            }
                            $dato['puntaje']=$score;
                            $dato['resultado'] = $this->Model_Examen->resultado_examen_ifv($dato);
                            $dato['hora_fin']=$dato['resultado'][0]['tiempo_ini'];
                            $this->Model_Examen->insert_resultado_examen($dato);
                        }else{
                            redirect('Examen/Salir');   
                        }   
                        $this->session->sess_destroy();
                        $this->load->view('index9',$dato);
                    }else{
                        $this->session->sess_destroy();
                        $this->load->view('sinportulante');
                    }
                }
            }else{
                $this->session->sess_destroy();
                $this->load->view('sinportulante');
            }
        }
        else{
            redirect('Examen/Salir');  
        }
    }

    public function Tiempo_limite()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_postulante']=$this->input->post("id_postulante");
            $dato['id_examen']=$this->input->post("id_examen");
            $dato['get_id'] = $this->Model_Examen->get_id_postulante($dato);
            $dato['get_examen'] = $this->Model_Examen->get_id_examen($dato);
            $dato['codigo']=$dato['get_id'][0]['codigo'];               
            $dato['id_carrera']=$dato['get_id'][0]['id_carrera']; 
            $dato['fec_examen']=$dato['get_examen'][0]['fec_examen'];               
            $this->Model_Examen->bloqueo_tiempo_limite($dato);
            redirect('Examen/Tiempo_Agotado');
        }else{
            $this->load->view('sinportulante');
        }
    }
    public function Tiempo_limite_2()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_postulante']=$this->input->post("id_postulante");
            $dato['id_examen']=$this->input->post("id_examen");
            $dato['get_id'] = $this->Model_Examen->get_id_postulante($dato);
            $dato['get_examen'] = $this->Model_Examen->get_id_examen($dato);
            $dato['get_config_examen'] = $this->Model_Examen->get_config_examen();
            $nota=$dato['get_config_examen'][0]['nota']/10;
            $dato['codigo']=$dato['get_id'][0]['codigo'];               
            $dato['id_carrera']=$dato['get_id'][0]['id_carrera']; 
            $dato['fec_examen']=$dato['get_examen'][0]['fec_examen'];
            
            //----
            if(count($dato['get_id'])>0 && count($dato['get_examen'])>0){
                if($dato['get_id'][0]['fec_examen']==$dato['get_examen'][0]['fec_examen']){
                    $array_carreras=explode(",", $dato['get_examen'][0]['examen_carrera']);
                    $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];
                    if (in_array($dato['id_carrera'], $array_carreras)) {
                        $dato['resultado'] = $this->Model_Examen->resultado_examen_ifv($dato);
                        if(count($dato['resultado'])==1 && $dato['resultado'][0]['estado']==56)
                        {
                            $respuesta1=explode("-",$this->input->post("id_respuesta1"));
                            $respuesta2=explode("-",$this->input->post("id_respuesta2"));
                            $respuesta3=explode("-",$this->input->post("id_respuesta3"));
                            $respuesta4=explode("-",$this->input->post("id_respuesta4"));
                            $respuesta5=explode("-",$this->input->post("id_respuesta5"));
                            $respuesta6=explode("-",$this->input->post("id_respuesta6"));
                            $respuesta7=explode("-",$this->input->post("id_respuesta7"));
                            $respuesta8=explode("-",$this->input->post("id_respuesta8"));
                            $respuesta9=explode("-",$this->input->post("id_respuesta9"));
                            $respuesta10=explode("-",$this->input->post("id_respuesta10"));
                            //var_dump($this->input->post("id_respuesta10"));
                            //var_dump($this->input->post("id_respuesta5"));
                            $score=0;
                            if($this->input->post("id_respuesta1")!=null){
                                if($respuesta1[1]==1){
                                    $score=$score+$nota;
                                }
                            }
                            if($this->input->post("id_respuesta2")!=null){
                                if($respuesta2[1]==1){
                                    $score=$score+$nota;
                                }    
                            }
                            if($this->input->post("id_respuesta3")!=null){
                                if($respuesta3[1]==1){
                                    $score=$score+$nota;
                                }
                            }
                            if($this->input->post("id_respuesta4")!=null){
                                if($respuesta4[1]==1){
                                    $score=$score+$nota;
                                }
                            }
                            if($this->input->post("id_respuesta5")!=null){
                                if($respuesta5[1]==1){
                                    $score=$score+$nota;
                                }    
                            }
                            if($this->input->post("id_respuesta6")!=null){
                                if($respuesta6[1]==1){
                                    $score=$score+$nota;
                                }    
                            }
                            if($this->input->post("id_respuesta7")!=null){
                                if($respuesta7[1]==1){
                                    $score=$score+$nota;
                                }
                            }
                            if($this->input->post("id_respuesta8")!=null){
                                if($respuesta8[1]==1){
                                    $score=$score+$nota;
                                }
                            }
                            if($this->input->post("id_respuesta9")!=null){
                                if($respuesta9[1]==1){
                                    $score=$score+$nota;
                                }    
                            }
                            if($this->input->post("id_respuesta10")!=null){
                                if($respuesta10[1]==1){
                                    $score=$score+$nota;
                                }    
                            }
                            
                            $dato['puntaje']=$score;
                            $dato['resultado'] = $this->Model_Examen->resultado_examen_ifv($dato);
                            $dato['hora_fin']=$dato['resultado'][0]['tiempo_ini'];
                            $this->Model_Examen->insert_resultado_examen($dato);
                        }
                    }
                }
            }
            $this->Model_Examen->bloqueo_tiempo_limite($dato);
            //redirect('Examen/Tiempo_Agotado');
        }else{
            $this->load->view('sinportulante');
        }
    }

}