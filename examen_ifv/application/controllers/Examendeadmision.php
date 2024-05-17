<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Examendeadmision extends CI_Controller {

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

        $this->load->view('sinportulante');

    }



    public function Tiempo_Agotado()

    {

        $this->load->view('sintiempo');

    }



    public function index($cod)

    {

        //$_GET['cod'];

        //$dato['codigo']='2100002';

        $dato['codigo']=$cod;

        $sesion = $this->Model_Examen->get_id_postulante($dato);

        $dato['get_id'] = $this->Model_Examen->get_id_postulante($dato);

        $dato['get_examen'] = $this->Model_Examen->examen_activo();

        if(count($sesion)>0){

            $_SESSION['usuario'] = $sesion;



            $dato['id_postulante']=$dato['get_id'][0]['id_postulante'];

            $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];

            $dato['nombres']=$dato['get_id'][0]['nombres'];

            $dato['apellido_pat']=$dato['get_id'][0]['apellido_pat'];

            $dato['apellido_mat']=$dato['get_id'][0]['apellido_mat'];

            $dato['nom_carrera']=$dato['get_id'][0]['nom_carrera'];

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];

            $dato['fecha_resultados']=$dato['get_examen'][0]['fecha_resultados'];

            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            

            $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

            $dato['id_area']=$dato['areas'][0]['id_area'];

            $dato['nombre_area']=$dato['areas'][0]['nombre_area'];

            

            $dato['historial'] = $this->Model_Examen->listhistorial_examenifv($dato);

            

            if(count($dato['historial'])>0){

                

                if($dato['historial'][0]['pagina']==1){

                    $dato['id_area']=$dato['areas'][0]['id_area'];

                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

        

                    if($dato['ahora']>=$dato['inicio']){
                        
                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

        

                        $dato['get_id'] = $this->Model_Examen->get_id_postulante_2($dato);

                        $dato['get_examen'] = $this->Model_Examen->examen_activo();

                        $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];

                        $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

                        $dato['fec_limite']=$dato['get_examen'][0]['fec_limite'];

        

                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 

                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);

        

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

        

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);

        

                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');

        

                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/

                                

                            $dato['id_postulante']=$dato['get_id'][0]['id_postulante'];

                            $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];

        

                            $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                            

                            $dato['id_area']=$dato['areas'][0]['id_area'];

                            $dato['nombre_area']=$dato['areas'][0]['nombre_area'];

                            $dato['lista_pregunta_temp'] = $this->Model_Examen->lista_pregunta_carrera($dato);

        

                            if($dato['get_resultado'][0]['pg1']==0){

                                $dato['pg']="1";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){

        

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

        

                                }else{

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="1";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }

        

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else{

                                $dato['pg']="1";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

        

                            /**----------------- */

                            

                        }

        

                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='1';

                            $this->Model_Examen->update_historial($dato);

                        }else{

                            $dato['pagina']='1';

                            $this->Model_Examen->insert_historial($dato);

                        }

                        

                    }

                    

        

                    $this->load->view('index1',$dato);

                }elseif($dato['historial'][0]['pagina']==2){
                    $dato['id_area']=$dato['areas'][0]['id_area'];
                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    

                    if($dato['ahora']>=$dato['inicio']){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 
                    
                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 

                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/

                            if($dato['get_resultado'][0]['pg2']==0)

                            {

                                $dato['pg']="2";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['pg']="1";

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    $result="";

                                    foreach($dato['lista_pregunta'] as $char){

                                        

                                        $result.= $char['id_pregunta'].",";

                                    }

                                    $cadena = substr($result, 0, -1);

                                    $dato['cadena'] = "(".$cadena.")";



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="2";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                            

                            }else

                            {

                                //si sirve

                                $dato['pg']="2";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                                

                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='2';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        /*------------------------------------------*/

                        

                    $this->load->view('index2',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==3){
                    $dato['id_area']=$dato['areas'][1]['id_area'];
                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 
                  
                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 

                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/



                            if($dato['get_resultado'][0]['pg3']==0)

                            {

                                $dato['pg']="3";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="3";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="3";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='3';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        $this->load->view('index3',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==4){
                    $dato['id_area']=$dato['areas'][1]['id_area'];


                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){
                    echo "4";
                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                    

                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 
                        
                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/



                            if($dato['get_resultado'][0]['pg4']==0)

                            {

                                $dato['pg']="4";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['pg']="3";

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    $result="";

                                    foreach($dato['lista_pregunta'] as $char){

                                        

                                        $result.= $char['id_pregunta'].",";

                                    }

                                    $cadena = substr($result, 0, -1);

                                    $dato['cadena'] = "(".$cadena.")";



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="4";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="4";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                                

                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='4';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        $this->load->view('index4',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==5){
                    $dato['id_area']=$dato['areas'][2]['id_area'];


                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 
                        
                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 
                           
                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/

                            if($dato['get_resultado'][0]['pg5']==0)

                            {

                                $dato['pg']="5";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="5";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="5";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='5';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        $this->load->view('index5',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==6){
                    $dato['id_area']=$dato['areas'][2]['id_area'];


                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 
                       
                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){

                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 
                            
                            
                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/

                            if($dato['get_resultado'][0]['pg6']==0)

                            {

                                $dato['pg']="6";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['pg']="5";

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    $result="";

                                    foreach($dato['lista_pregunta'] as $char){

                                        

                                        $result.= $char['id_pregunta'].",";

                                    }

                                    $cadena = substr($result, 0, -1);

                                    $dato['cadena'] = "(".$cadena.")";



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="6";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="6";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='6';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        $this->load->view('index6',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==7){

                    $dato['id_area']=$dato['areas'][3]['id_area'];

                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 
                        
                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){
                           
                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 

                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/



                            if($dato['get_resultado'][0]['pg7']==0)

                            {

                                $dato['pg']="7";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="7";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                                

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="7";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='7';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }

                        $this->load->view('index7',$dato);

                    }

                }elseif($dato['historial'][0]['pagina']==8){

                    $dato['id_area']=$dato['areas'][3]['id_area'];

                    $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                    $dato['ahora']=date('Y-m-d H:i:s', time()); 

                    $dato['inicio']=$dato['get_resultado'][0]['limite'];

                    $tiempo_limite=$dato['get_resultado'][0]['limite'];

                    if($dato['ahora']>=$dato['inicio']){
                        
                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{



                        $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        

                        if($ahora>=$tiempo_final){
                            
                            $this->Model_Examen->bloqueo_tiempo_limite($dato);

                            redirect('Examendeadmision/Tiempo_Agotado'); 

                        }else{

                            $horaInicio = new DateTime($tiempo_final);

                            $horaTermino = new DateTime($ahora);



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

                            /*------120 MINUTOS-----------*/

                            $horaInicio1 = new DateTime($tiempo_limite);

                            $horaTermino1 = new DateTime($ahora);



                            $interval1 = $horaInicio1->diff($horaTermino1);

                            $hora1=$interval1->format('%h');

                            $minuto1=$interval1->format('%i');

                            $segundos1=$interval1->format('%s');



                            $h1=$hora1*3600;

                            $h_s1=$h1*1000;

                            $ss1 = $segundos1*1000;

                            $ms1 = $minuto1*60;

                            $mss1= $ms1*1000;

                            $dato['timer120']=$ss1+$mss1+$h_s1;

                            /*-----------------------------*/



                            if($dato['get_resultado'][0]['pg8']==0)

                            {

                                $dato['pg']="8";

                                $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                if(count($dato['lista_pregunta_ex'])>0){



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);



                                }else{

                                    $dato['pg']="7";

                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                    $result="";

                                    foreach($dato['lista_pregunta'] as $char){

                                        

                                        $result.= $char['id_pregunta'].",";

                                    }

                                    $cadena = substr($result, 0, -1);

                                    $dato['cadena'] = "(".$cadena.")";



                                    $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                    shuffle($dato['lista_pregunta']);

                                    $i=0;

                                    foreach($dato['lista_pregunta'] as $preg){

                                        $dato['id_pregunta']=$preg['id_pregunta'];

                                        $dato['pregunta']=$preg['pregunta'];

                                        $dato['img']=$preg['img'];

                                        $dato['pg']="8";

                                        

                                        $i=$i+1;

                                        $this->Model_Examen->insert_pregunta_exonerada($dato);

                                        if($i==10){

                                            break;

                                        }

                                    }



                                    $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                    $dato['get_link'] = $this->Model_Examen->get_config();

                                    shuffle($dato['lista_respuesta']);

                                }

                                

                            }else

                            {

                                //si sirve

                                $dato['pg']="8";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }



                            $dato['historial']=$this->Model_Examen->lista_historial($dato);

                            if(count($dato['historial'])>0){

                                $dato['pagina']='8';

                                $this->Model_Examen->update_historial($dato);

                            }

                        }



                        $this->load->view('index8',$dato);

                    }

                }else{

                    $this->load->view('sinportulante');

                }

            }else{

                $this->load->view('index',$dato);

            }

            

        }else{

            $this->load->view('sinportulante');

        }

        

    }



    public function index1()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['id_examen']=$this->input->post("id_examen");

            $dato['get_resultado1'] = $this->Model_Examen->get_resultado_examen1($dato);
 
            if(count($dato['get_resultado1'])>0){

            }else{

                $this->Model_Examen->insert_tiempo_ini_examen($dato);

            }

            

            $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

            $dato['ahora']=date('Y-m-d H:i:s', time()); 

            $dato['inicio']=$dato['get_resultado'][0]['limite'];

            $tiempo_limite=$dato['get_resultado'][0]['limite'];


            if($dato['ahora']>=$dato['inicio']){
                
                $this->Model_Examen->bloqueo_tiempo_limite($dato);

                redirect('Examendeadmision/Tiempo_Agotado'); 

            }else{



                $dato['get_id'] = $this->Model_Examen->get_id_postulante_2($dato);

                $dato['get_examen'] = $this->Model_Examen->examen_activo();

                $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];

                //$dato['id_examen']=$dato['get_examen'][0]['id_examen'];

                $dato['fec_limite']=$dato['get_examen'][0]['fec_limite'];



                $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                $ahora=date('Y-m-d H:i:s', time()); 

                

                if($ahora>=$tiempo_final){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                    
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{

                    $horaInicio = new DateTime($tiempo_final);

                    $horaTermino = new DateTime($ahora);



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



                    /*------120 MINUTOS-----------*/

                    $horaInicio1 = new DateTime($tiempo_limite);

                    $horaTermino1 = new DateTime($ahora);



                    $interval1 = $horaInicio1->diff($horaTermino1);

                    $hora1=$interval1->format('%h');

                    $minuto1=$interval1->format('%i');

                    $segundos1=$interval1->format('%s');



                    $h1=$hora1*3600;

                    $h_s1=$h1*1000;

                    $ss1 = $segundos1*1000;

                    $ms1 = $minuto1*60;

                    $mss1= $ms1*1000;

                    $dato['timer120']=$ss1+$mss1+$h_s1;

                    /*-----------------------------*/

                        

                    $dato['id_postulante']=$dato['get_id'][0]['id_postulante'];

                    $dato['id_carrera']=$dato['get_id'][0]['id_carrera'];



                    $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                    

                    $dato['id_area']=$dato['areas'][0]['id_area'];

                    $dato['nombre_area']=$dato['areas'][0]['nombre_area'];

                    $dato['lista_pregunta_temp'] = $this->Model_Examen->lista_pregunta_carrera($dato);



                    if($dato['get_resultado'][0]['pg1']==0){

                        $dato['pg']="1";

                        $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                        if(count($dato['lista_pregunta_ex'])>0){



                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }else{

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                            shuffle($dato['lista_pregunta']);

                            $i=0;

                            foreach($dato['lista_pregunta'] as $preg){

                                $dato['id_pregunta']=$preg['id_pregunta'];

                                $dato['pregunta']=$preg['pregunta'];

                                $dato['img']=$preg['img'];

                                $dato['pg']="1";

                                

                                $i=$i+1;

                                $this->Model_Examen->insert_pregunta_exonerada($dato);

                                if($i==10){

                                    break;

                                }

                            }



                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);

                        }

                    }else{

                        $dato['pg']="1";

                        $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                        shuffle($dato['lista_pregunta']);

                        $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                        $dato['get_link'] = $this->Model_Examen->get_config();

                        shuffle($dato['lista_respuesta']);

                    }



                    /**----------------- */

                    

                }



                $dato['historial']=$this->Model_Examen->lista_historial($dato);

                if(count($dato['historial'])>0){

                    $dato['pagina']='1';

                    $this->Model_Examen->update_historial($dato);

                }else{

                    $dato['pagina']='1';

                    $this->Model_Examen->insert_historial($dato);

                }

                

            }

            



            $this->load->view('index1',$dato);

            

        }else{

            $this->load->view('sinportulante');

        }

        

    }



    public function Pg2()

    {

        if ($this->session->userdata('usuario')) {



            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];

            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                $dato['id_area']=$dato['areas'][0]['id_area'];

                /*-------------------------------------------------*/

                $id_respuesta1=$this->input->post("id_respuesta1");

                $id_respuesta2=$this->input->post("id_respuesta2");

                $id_respuesta3=$this->input->post("id_respuesta3");

                $id_respuesta4=$this->input->post("id_respuesta4");

                $id_respuesta5=$this->input->post("id_respuesta5");

                $id_respuesta6=$this->input->post("id_respuesta6");

                $id_respuesta7=$this->input->post("id_respuesta7");

                $id_respuesta8=$this->input->post("id_respuesta8");

                $id_respuesta9=$this->input->post("id_respuesta9");

                $id_respuesta10=$this->input->post("id_respuesta10");

                

                $respuesta1 = explode("-", $id_respuesta1);

                $respuesta2 = explode("-", $id_respuesta2);

                $respuesta3 = explode("-", $id_respuesta3);

                $respuesta4 = explode("-", $id_respuesta4);

                $respuesta5 = explode("-", $id_respuesta5);

                $respuesta6 = explode("-", $id_respuesta6);

                $respuesta7 = explode("-", $id_respuesta7);

                $respuesta8 = explode("-", $id_respuesta8);

                $respuesta9 = explode("-", $id_respuesta9);

                $respuesta10 = explode("-", $id_respuesta10);

                

                $score=0;

                if($respuesta1[1]==1){

                    $score=$score+4;

                }

                if($respuesta2[1]==1){

                    $score=$score+4;

                }

                if($respuesta3[1]==1){

                    $score=$score+4;

                }

                if($respuesta4[1]==1){

                    $score=$score+4;

                }

                if($respuesta5[1]==1){

                    $score=$score+4;

                }

                if($respuesta6[1]==1){

                    $score=$score+4;

                }

                if($respuesta7[1]==1){

                    $score=$score+4;

                }

                if($respuesta8[1]==1){

                    $score=$score+4;

                }

                if($respuesta9[1]==1){

                    $score=$score+4;

                }

                if($respuesta10[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='1';

                

                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                if(count($dato['count'])>0)

                {

                    if( $dato['count'][0]['pg1']!="0" || $dato['count'][0]['pg2']!="0" || $dato['count'][0]['pg3']!="0" || 

                        $dato['count'][0]['pg4']!="0" || $dato['count'][0]['pg5']!="0" || $dato['count'][0]['pg6']!="0" ||

                        $dato['count'][0]['pg7']!="0" || $dato['count'][0]['pg8']!="0" )

                        {



                        }else{

                            $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                            $ahora=date('Y-m-d H:i:s', time()); 

                            if($ahora>=$tiempo_final){



                            }else{

                                $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                            $this->Model_Examen->update_resultado_examen($dato);

                            }

                            

                        }

                }else

                {

                    $this->Model_Examen->insert_resultado_examen($dato);

                }



                /**-------------------------------------------------- */

                //consulta preguntas pg2

                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                    
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);
                        
                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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



                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/

                        if($dato['get_resultado'][0]['pg2']==0)

                        {

                            $dato['pg']="2";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['pg']="1";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                $result="";

                                foreach($dato['lista_pregunta'] as $char){

                                    

                                    $result.= $char['id_pregunta'].",";

                                }

                                $cadena = substr($result, 0, -1);

                                $dato['cadena'] = "(".$cadena.")";



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="2";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                        

                        }else

                        {

                            //si sirve

                            $dato['pg']="2";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                            

                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='2';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }

                    /*------------------------------------------*/

                    

                $this->load->view('index2',$dato);

                }



                

            }else{

                redirect('Examendeadmision/Salir');  

            }



        }

        else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg3()

    {

        if ($this->session->userdata('usuario')) {



            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                

                $dato['id_area']=$dato['areas'][1]['id_area'];

                $dato['nombre_area']=$dato['areas'][1]['nombre_area'];

                /*------------------------------------------------*/

                $id_respuesta11=$this->input->post("id_respuesta11");

                $id_respuesta12=$this->input->post("id_respuesta12");

                $id_respuesta13=$this->input->post("id_respuesta13");

                $id_respuesta14=$this->input->post("id_respuesta14");

                $id_respuesta15=$this->input->post("id_respuesta15");

                $id_respuesta16=$this->input->post("id_respuesta16");

                $id_respuesta17=$this->input->post("id_respuesta17");

                $id_respuesta18=$this->input->post("id_respuesta18");

                $id_respuesta19=$this->input->post("id_respuesta19");

                $id_respuesta20=$this->input->post("id_respuesta20");

                

                $respuesta11 = explode("-", $id_respuesta11);

                $respuesta12 = explode("-", $id_respuesta12);

                $respuesta13 = explode("-", $id_respuesta13);

                $respuesta14 = explode("-", $id_respuesta14);

                $respuesta15 = explode("-", $id_respuesta15);

                $respuesta16 = explode("-", $id_respuesta16);

                $respuesta17 = explode("-", $id_respuesta17);

                $respuesta18 = explode("-", $id_respuesta18);

                $respuesta19 = explode("-", $id_respuesta19);

                $respuesta20 = explode("-", $id_respuesta20);

                

                $score=0;



                if($respuesta11[1]==1){

                    $score=$score+4;

                }

                if($respuesta12[1]==1){

                    $score=$score+4;

                }

                if($respuesta13[1]==1){

                    $score=$score+4;

                }

                if($respuesta14[1]==1){

                    $score=$score+4;

                }

                if($respuesta15[1]==1){

                    $score=$score+4;

                }

                if($respuesta16[1]==1){

                    $score=$score+4;

                }

                if($respuesta17[1]==1){

                    $score=$score+4;

                }

                if($respuesta18[1]==1){

                    $score=$score+4;

                }

                if($respuesta19[1]==1){

                    $score=$score+4;

                }

                if($respuesta20[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='2';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg2'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                        $this->Model_Examen->update_resultado2_examen($dato);

                        }

                        

                    }

                    

                }

                /**--------------------------------------------------------- */



                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                   
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);
                        
                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/



                        if($dato['get_resultado'][0]['pg3']==0)

                        {

                            $dato['pg']="3";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="3";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                            

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="3";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='3';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }

                    $this->load->view('index3',$dato);

                }



                

            }else{

                redirect('Examendeadmision/Salir');   

            }

        }

        else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg4()

    {

        if ($this->session->userdata('usuario')) {



            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                $dato['id_area']=$dato['areas'][1]['id_area'];

                $dato['nombre_area']=$dato['areas'][1]['nombre_area'];

                /**----------------------------------------- */



                $id_respuesta21=$this->input->post("id_respuesta21");

                $id_respuesta22=$this->input->post("id_respuesta22");

                $id_respuesta23=$this->input->post("id_respuesta23");

                $id_respuesta24=$this->input->post("id_respuesta24");

                $id_respuesta25=$this->input->post("id_respuesta25");

                $id_respuesta26=$this->input->post("id_respuesta26");

                $id_respuesta27=$this->input->post("id_respuesta27");

                $id_respuesta28=$this->input->post("id_respuesta28");

                $id_respuesta29=$this->input->post("id_respuesta29");

                $id_respuesta30=$this->input->post("id_respuesta30");

                

                $respuesta21 = explode("-", $id_respuesta21);

                $respuesta22 = explode("-", $id_respuesta22);

                $respuesta23 = explode("-", $id_respuesta23);

                $respuesta24 = explode("-", $id_respuesta24);

                $respuesta25 = explode("-", $id_respuesta25);

                $respuesta26 = explode("-", $id_respuesta26);

                $respuesta27 = explode("-", $id_respuesta27);

                $respuesta28 = explode("-", $id_respuesta28);

                $respuesta29 = explode("-", $id_respuesta29);

                $respuesta30 = explode("-", $id_respuesta30);

                

                $score=0;



                if($respuesta21[1]==1){

                    $score=$score+4;

                }

                if($respuesta22[1]==1){

                    $score=$score+4;

                }

                if($respuesta23[1]==1){

                    $score=$score+4;

                }

                if($respuesta24[1]==1){

                    $score=$score+4;

                }

                if($respuesta25[1]==1){

                    $score=$score+4;

                }

                if($respuesta26[1]==1){

                    $score=$score+4;

                }

                if($respuesta27[1]==1){

                    $score=$score+4;

                }

                if($respuesta28[1]==1){

                    $score=$score+4;

                }

                if($respuesta29[1]==1){

                    $score=$score+4;

                }

                if($respuesta30[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='3';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg3'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                        $this->Model_Examen->update_resultado3_examen($dato);

                        }

                        

                    }

                    

                }

                /**---------------------------------------- */

                

                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                    
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{

                

                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);
                       
                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/



                        if($dato['get_resultado'][0]['pg4']==0)

                        {

                            $dato['pg']="4";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['pg']="3";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                $result="";

                                foreach($dato['lista_pregunta'] as $char){

                                    

                                    $result.= $char['id_pregunta'].",";

                                }

                                $cadena = substr($result, 0, -1);

                                $dato['cadena'] = "(".$cadena.")";



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="4";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                            

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="4";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                            

                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='4';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }

                    $this->load->view('index4',$dato);

                }

                



            }else{

                redirect('Examendeadmision/Salir'); 

            }

        }

        else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg5()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                

                $dato['id_area']=$dato['areas'][2]['id_area'];

                $dato['nombre_area']=$dato['areas'][2]['nombre_area'];

                /**------------------------------------------ */



                $id_respuesta31=$this->input->post("id_respuesta31");

                $id_respuesta32=$this->input->post("id_respuesta32");

                $id_respuesta33=$this->input->post("id_respuesta33");

                $id_respuesta34=$this->input->post("id_respuesta34");

                $id_respuesta35=$this->input->post("id_respuesta35");

                $id_respuesta36=$this->input->post("id_respuesta36");

                $id_respuesta37=$this->input->post("id_respuesta37");

                $id_respuesta38=$this->input->post("id_respuesta38");

                $id_respuesta39=$this->input->post("id_respuesta39");

                $id_respuesta40=$this->input->post("id_respuesta40");

                

                $respuesta31 = explode("-", $id_respuesta31);

                $respuesta32 = explode("-", $id_respuesta32);

                $respuesta33 = explode("-", $id_respuesta33);

                $respuesta34 = explode("-", $id_respuesta34);

                $respuesta35 = explode("-", $id_respuesta35);

                $respuesta36 = explode("-", $id_respuesta36);

                $respuesta37 = explode("-", $id_respuesta37);

                $respuesta38 = explode("-", $id_respuesta38);

                $respuesta39 = explode("-", $id_respuesta39);

                $respuesta40 = explode("-", $id_respuesta40);

                

                $score=0;



                if($respuesta31[1]==1){

                    $score=$score+4;

                }

                if($respuesta32[1]==1){

                    $score=$score+4;

                }

                if($respuesta33[1]==1){

                    $score=$score+4;

                }

                if($respuesta34[1]==1){

                    $score=$score+4;

                }

                if($respuesta35[1]==1){

                    $score=$score+4;

                }

                if($respuesta36[1]==1){

                    $score=$score+4;

                }

                if($respuesta37[1]==1){

                    $score=$score+4;

                }

                if($respuesta38[1]==1){

                    $score=$score+4;

                }

                if($respuesta39[1]==1){

                    $score=$score+4;

                }

                if($respuesta40[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='4';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg4'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                        $this->Model_Examen->update_resultado4_examen($dato);

                        }

                        

                    }

                    

                }

                /**----------------------------------------------------- */



                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                   
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);
                       
                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/

                        if($dato['get_resultado'][0]['pg5']==0)

                        {

                            $dato['pg']="5";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="5";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                            

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="5";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='5';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }

                

                $this->load->view('index5',$dato);

            }

                

            }else{

                redirect('Examendeadmision/Salir'); 

            }

        }else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg6()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                

                $dato['id_area']=$dato['areas'][2]['id_area'];

                $dato['nombre_area']=$dato['areas'][2]['nombre_area'];

                /**------------------------------------------- */

                $id_respuesta41=$this->input->post("id_respuesta41");

                $id_respuesta42=$this->input->post("id_respuesta42");

                $id_respuesta43=$this->input->post("id_respuesta43");

                $id_respuesta44=$this->input->post("id_respuesta44");

                $id_respuesta45=$this->input->post("id_respuesta45");

                $id_respuesta46=$this->input->post("id_respuesta46");

                $id_respuesta47=$this->input->post("id_respuesta47");

                $id_respuesta48=$this->input->post("id_respuesta48");

                $id_respuesta49=$this->input->post("id_respuesta49");

                $id_respuesta50=$this->input->post("id_respuesta50");

                

                $respuesta41 = explode("-", $id_respuesta41);

                $respuesta42 = explode("-", $id_respuesta42);

                $respuesta43 = explode("-", $id_respuesta43);

                $respuesta44 = explode("-", $id_respuesta44);

                $respuesta45 = explode("-", $id_respuesta45);

                $respuesta46 = explode("-", $id_respuesta46);

                $respuesta47 = explode("-", $id_respuesta47);

                $respuesta48 = explode("-", $id_respuesta48);

                $respuesta49 = explode("-", $id_respuesta49);

                $respuesta50 = explode("-", $id_respuesta50);

                

                $score=0;



                if($respuesta41[1]==1){

                    $score=$score+4;

                }

                if($respuesta42[1]==1){

                    $score=$score+4;

                }

                if($respuesta43[1]==1){

                    $score=$score+4;

                }

                if($respuesta44[1]==1){

                    $score=$score+4;

                }

                if($respuesta45[1]==1){

                    $score=$score+4;

                }

                if($respuesta46[1]==1){

                    $score=$score+4;

                }

                if($respuesta47[1]==1){

                    $score=$score+4;

                }

                if($respuesta48[1]==1){

                    $score=$score+4;

                }

                if($respuesta49[1]==1){

                    $score=$score+4;

                }

                if($respuesta50[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='5';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg5'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                        $this->Model_Examen->update_resultado5_examen($dato);

                        }

                        

                    }

                    

                }

                /**--------------------------------------------------- */

                

                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);
                   
                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/

                        if($dato['get_resultado'][0]['pg6']==0)

                        {

                            $dato['pg']="6";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['pg']="5";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                $result="";

                                foreach($dato['lista_pregunta'] as $char){

                                    

                                    $result.= $char['id_pregunta'].",";

                                }

                                $cadena = substr($result, 0, -1);

                                $dato['cadena'] = "(".$cadena.")";



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="6";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                            

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="6";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='6';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }

                    $this->load->view('index6',$dato);

                }

                

            }else{

                redirect('Examendeadmision/Salir'); 

            }



        }else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg7()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                

                $dato['id_area']=$dato['areas'][3]['id_area'];

                $dato['nombre_area']=$dato['areas'][3]['nombre_area'];

                /**--------------------------------------------- */

                $id_respuesta51=$this->input->post("id_respuesta51");

                $id_respuesta52=$this->input->post("id_respuesta52");

                $id_respuesta53=$this->input->post("id_respuesta53");

                $id_respuesta54=$this->input->post("id_respuesta54");

                $id_respuesta55=$this->input->post("id_respuesta55");

                $id_respuesta56=$this->input->post("id_respuesta56");

                $id_respuesta57=$this->input->post("id_respuesta57");

                $id_respuesta58=$this->input->post("id_respuesta58");

                $id_respuesta59=$this->input->post("id_respuesta59");

                $id_respuesta60=$this->input->post("id_respuesta60");

                

                $respuesta51 = explode("-", $id_respuesta51);

                $respuesta52 = explode("-", $id_respuesta52);

                $respuesta53 = explode("-", $id_respuesta53);

                $respuesta54 = explode("-", $id_respuesta54);

                $respuesta55 = explode("-", $id_respuesta55);

                $respuesta56 = explode("-", $id_respuesta56);

                $respuesta57 = explode("-", $id_respuesta57);

                $respuesta58 = explode("-", $id_respuesta58);

                $respuesta59 = explode("-", $id_respuesta59);

                $respuesta60 = explode("-", $id_respuesta60);

                

                $score=0;



                if($respuesta51[1]==1){

                    $score=$score+4;

                }

                if($respuesta52[1]==1){

                    $score=$score+4;

                }

                if($respuesta53[1]==1){

                    $score=$score+4;

                }

                if($respuesta54[1]==1){

                    $score=$score+4;

                }

                if($respuesta55[1]==1){

                    $score=$score+4;

                }

                if($respuesta56[1]==1){

                    $score=$score+4;

                }

                if($respuesta57[1]==1){

                    $score=$score+4;

                }

                if($respuesta58[1]==1){

                    $score=$score+4;

                }

                if($respuesta59[1]==1){

                    $score=$score+4;

                }

                if($respuesta60[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;



                $dato['score']=$score;

                $dato['pagina']='6';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg6'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                            $this->Model_Examen->update_resultado6_examen($dato);

                        }

                        

                    }

                    

                }

                /**---------------------------------------------------------- */



                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);

                    redirect('Examendeadmision/Tiempo_Agotado'); 
                    

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/



                        if($dato['get_resultado'][0]['pg7']==0)

                        {

                            $dato['pg']="7";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="7";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                            

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="7";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='7';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }



                    $this->load->view('index7',$dato);

                }

                

            }else{

                redirect('Examendeadmision/Salir');

            }



        }else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Pg8()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);

            if(count($cont)>0){



                $dato['areas'] = $this->Model_Examen->lista_area_carrera($dato);

                

                

                $dato['id_area']=$dato['areas'][3]['id_area'];

                $dato['nombre_area']=$dato['areas'][3]['nombre_area'];

                /**----------------------------------------------- */

                $id_respuesta61=$this->input->post("id_respuesta61");

                $id_respuesta62=$this->input->post("id_respuesta62");

                $id_respuesta63=$this->input->post("id_respuesta63");

                $id_respuesta64=$this->input->post("id_respuesta64");

                $id_respuesta65=$this->input->post("id_respuesta65");

                $id_respuesta66=$this->input->post("id_respuesta66");

                $id_respuesta67=$this->input->post("id_respuesta67");

                $id_respuesta68=$this->input->post("id_respuesta68");

                $id_respuesta69=$this->input->post("id_respuesta69");

                $id_respuesta70=$this->input->post("id_respuesta70");

                

                $respuesta61 = explode("-", $id_respuesta61);

                $respuesta62 = explode("-", $id_respuesta62);

                $respuesta63 = explode("-", $id_respuesta63);

                $respuesta64 = explode("-", $id_respuesta64);

                $respuesta65 = explode("-", $id_respuesta65);

                $respuesta66 = explode("-", $id_respuesta66);

                $respuesta67 = explode("-", $id_respuesta67);

                $respuesta68 = explode("-", $id_respuesta68);

                $respuesta69 = explode("-", $id_respuesta69);

                $respuesta70 = explode("-", $id_respuesta70);

                

                $score=0;



                if($respuesta61[1]==1){

                    $score=$score+4;

                }

                if($respuesta62[1]==1){

                    $score=$score+4;

                }

                if($respuesta63[1]==1){

                    $score=$score+4;

                }

                if($respuesta64[1]==1){

                    $score=$score+4;

                }

                if($respuesta65[1]==1){

                    $score=$score+4;

                }

                if($respuesta66[1]==1){

                    $score=$score+4;

                }

                if($respuesta67[1]==1){

                    $score=$score+4;

                }

                if($respuesta68[1]==1){

                    $score=$score+4;

                }

                if($respuesta69[1]==1){

                    $score=$score+4;

                }

                if($respuesta70[1]==1){

                    $score=$score+4;

                }

                $dato['score']=$score;

                $dato['pagina']='7';



                $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                

                if(count($dato['count'])>0){

                    if( $dato['count'][0]['pg7'] !="0" ){



                    }else{

                        $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                        $ahora=date('Y-m-d H:i:s', time()); 

                        if($ahora>=$tiempo_final){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                            $this->Model_Examen->update_resultado7_examen($dato);

                        }

                        

                    }

                    

                }

                /**---------------------------------------------------- */

                

                $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

                $dato['ahora']=date('Y-m-d H:i:s', time()); 

                $dato['inicio']=$dato['get_resultado'][0]['limite'];

                $tiempo_limite=$dato['get_resultado'][0]['limite'];

                if($dato['ahora']>=$dato['inicio']){

                    $this->Model_Examen->bloqueo_tiempo_limite($dato);

                    redirect('Examendeadmision/Tiempo_Agotado'); 

                }else{



                    $dato['tiempo_final']=$dato['get_examen'][0]['fec_limite'];

                    $tiempo_final=$dato['get_examen'][0]['fec_limite'];

                    $ahora=date('Y-m-d H:i:s', time()); 

                    

                    if($ahora>=$tiempo_final){

                        $this->Model_Examen->bloqueo_tiempo_limite($dato);

                        redirect('Examendeadmision/Tiempo_Agotado'); 

                    }else{

                        $horaInicio = new DateTime($tiempo_final);

                        $horaTermino = new DateTime($ahora);



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

                        /*------120 MINUTOS-----------*/

                        $horaInicio1 = new DateTime($tiempo_limite);

                        $horaTermino1 = new DateTime($ahora);



                        $interval1 = $horaInicio1->diff($horaTermino1);

                        $hora1=$interval1->format('%h');

                        $minuto1=$interval1->format('%i');

                        $segundos1=$interval1->format('%s');



                        $h1=$hora1*3600;

                        $h_s1=$h1*1000;

                        $ss1 = $segundos1*1000;

                        $ms1 = $minuto1*60;

                        $mss1= $ms1*1000;

                        $dato['timer120']=$ss1+$mss1+$h_s1;

                        /*-----------------------------*/



                        if($dato['get_resultado'][0]['pg8']==0)

                        {

                            $dato['pg']="8";

                            $dato['lista_pregunta_ex'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            if(count($dato['lista_pregunta_ex'])>0){



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                shuffle($dato['lista_pregunta']);

                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);



                            }else{

                                $dato['pg']="7";

                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                                $result="";

                                foreach($dato['lista_pregunta'] as $char){

                                    

                                    $result.= $char['id_pregunta'].",";

                                }

                                $cadena = substr($result, 0, -1);

                                $dato['cadena'] = "(".$cadena.")";



                                $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_carrera_cadena($dato);

                                shuffle($dato['lista_pregunta']);

                                $i=0;

                                foreach($dato['lista_pregunta'] as $preg){

                                    $dato['id_pregunta']=$preg['id_pregunta'];

                                    $dato['pregunta']=$preg['pregunta'];

                                    $dato['img']=$preg['img'];

                                    $dato['pg']="8";

                                    

                                    $i=$i+1;

                                    $this->Model_Examen->insert_pregunta_exonerada($dato);

                                    if($i==10){

                                        break;

                                    }

                                }



                                $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                                $dato['get_link'] = $this->Model_Examen->get_config();

                                shuffle($dato['lista_respuesta']);

                            }

                            

                        }else

                        {

                            //si sirve

                            $dato['pg']="8";

                            $dato['lista_pregunta'] = $this->Model_Examen->lista_pregunta_exonerada($dato);

                            shuffle($dato['lista_pregunta']);

                            $dato['lista_respuesta'] = $this->Model_Examen->lista_respuesta($dato);

                            $dato['get_link'] = $this->Model_Examen->get_config();

                            shuffle($dato['lista_respuesta']);



                        }



                        $dato['historial']=$this->Model_Examen->lista_historial($dato);

                        if(count($dato['historial'])>0){

                            $dato['pagina']='8';

                            $this->Model_Examen->update_historial($dato);

                        }

                    }



                    $this->load->view('index8',$dato);

                }

                

            }else{

                redirect('Examendeadmision/Salir');  

            }



        }else{

            redirect('Examendeadmision/Salir');  

        }

    }



    public function Final()

    {

        if ($this->session->userdata('usuario')) {

            $dato['id_carrera']=$this->input->post("id_carrera");

            $dato['id_postulante']=$this->input->post("id_postulante");

            $dato['get_examen'] = $this->Model_Examen->examen_activo();

            $dato['nom_examen']=$dato['get_examen'][0]['nom_examen'];
            $dato['id_examen']=$dato['get_examen'][0]['id_examen'];

            $cont = $this->Model_Examen->get_id_postulante_2($dato);



            $dato['get_resultado'] = $this->Model_Examen->get_resultado_examen($dato);

            $dato['ahora']=date('Y-m-d H:i:s', time()); 

            $dato['inicio']=$dato['get_resultado'][0]['limite'];

            if($dato['ahora']>=$dato['inicio']){

                $this->Model_Examen->bloqueo_tiempo_limite($dato);

                redirect('Examendeadmision/Tiempo_Agotado'); 

            }else{



                if(count($cont)>0){

                

                    $id_respuesta71=$this->input->post("id_respuesta71");

                    $id_respuesta72=$this->input->post("id_respuesta72");

                    $id_respuesta73=$this->input->post("id_respuesta73");

                    $id_respuesta74=$this->input->post("id_respuesta74");

                    $id_respuesta75=$this->input->post("id_respuesta75");

                    $id_respuesta76=$this->input->post("id_respuesta76");

                    $id_respuesta77=$this->input->post("id_respuesta77");

                    $id_respuesta78=$this->input->post("id_respuesta78");

                    $id_respuesta79=$this->input->post("id_respuesta79");

                    $id_respuesta80=$this->input->post("id_respuesta80");

                    

                    $respuesta71 = explode("-", $id_respuesta71);

                    $respuesta72 = explode("-", $id_respuesta72);

                    $respuesta73 = explode("-", $id_respuesta73);

                    $respuesta74 = explode("-", $id_respuesta74);

                    $respuesta75 = explode("-", $id_respuesta75);

                    $respuesta76 = explode("-", $id_respuesta76);

                    $respuesta77 = explode("-", $id_respuesta77);

                    $respuesta78 = explode("-", $id_respuesta78);

                    $respuesta79 = explode("-", $id_respuesta79);

                    $respuesta80 = explode("-", $id_respuesta80);

                    

                    $score=0;



                    if($respuesta71[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta72[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta73[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta74[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta75[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta76[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta77[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta78[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta79[1]==1){

                        $score=$score+4;

                    }

                    if($respuesta80[1]==1){

                        $score=$score+4;

                    }

                    $dato['score']=$score;

                    $dato['pagina']='8';



                    $dato['count'] = $this->Model_Examen->resultado_examen_ifv($dato);

                    

                    if(count($dato['count'])>0){

                        if( $dato['count'][0]['pg8'] !="0" ){



                        }else{

                            $dato['puntaje']=$dato['count'][0]['puntaje']+$dato['score'];

                            //$dato['list']=$this->Model_Examen->ultimo_pos_exam($dato);
                            //$dato['id_pe']=$dato['list'][0]['id_pe'];
                            $this->Model_Examen->update_resultado8_examen($dato);

                        }

                        

                    }

                    $this->load->view('index9',$dato);

                }else{

                    redirect('Examendeadmision/Salir');  

                }

            }

            

            

            

            



        }else{

            redirect('Examendeadmision/Salir');  

        }

        

    }



    public function Tiempo_limite()

    {

        $dato['id_postulante']=$this->input->post("id_postulante");
        $dato['id_examen']=$this->input->post("id_examen");

        //$dato['list']=$this->Model_Examen->ultimo_pos_exam($dato);
        //$dato['id_pe']=$dato['list'][0]['id_pe'];
                            
        $this->Model_Examen->bloqueo_tiempo_limite($dato);

        redirect('Examendeadmision/Tiempo_Agotado');

    }





    

}