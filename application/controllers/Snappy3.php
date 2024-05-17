<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Snappy extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Model_snappy');
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
            $data['fondo'] = $this->Model_snappy->get_confg_fondo();
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
            $this->load->view('administrador/index',$data);
        }
        else{
            //$this->load->view('login/login');
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

    public function Agenda() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_agenda'] = $this->Model_snappy->get_list_agenda();
        $this->load->view('Admin/agenda/index',$dato);
    }
    
    public function Redes() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_redes'] = $this->Model_snappy->get_list_redes();
        $this->load->view('Admin/redes/index',$dato);
    }

    public function Empresa() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_empresa'] = $this->Model_snappy->get_list_empresa();
        $this->load->view('Admin/empresa/index',$dato);
    }

    public function Modal_Empresa(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/empresa/modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Modal_Update_Empresa($id_empresa){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_empresa($id_empresa);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/empresa/upd_modal_empresa', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }

    public function Insert_Empresa(){
        $dato['nom_empresa']= $this->input->post("nom_empresa"); 
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['color1_empresa']= $this->input->post("color1_empresa");
        $dato['color2_empresa']= $this->input->post("color2_empresa");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->insert_empresa($dato);

        redirect('Snappy/Empresa');  
    }

    public function Update_Empresa(){
        $dato['id_empresa']= $this->input->post("id_empresa");
        $dato['nom_empresa']= $this->input->post("nom_empresa");
        $dato['cod_empresa']= $this->input->post("cod_empresa");
        $dato['orden_empresa']= $this->input->post("orden_empresa"); 
        $dato['color1_empresa']= $this->input->post("color1_empresa");
        $dato['color2_empresa']= $this->input->post("color2_empresa");
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['observaciones_empresa']= $this->input->post("observaciones_empresa");
        $dato['rep_redes']= $this->input->post("rep_redes"); 

        $this->Model_snappy->update_empresa($dato);

        redirect('Snappy/Empresa');  
    }

    public function Excel_Empresa(){
        $empresas = $this->Model_snappy->get_list_empresa();
        if(count($empresas) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Empresas');
            
	        //Contador de filas
            $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:F1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:F1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Empresa');	        
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Código');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Orden');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Observaciones');	        
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Rep. Redes');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Status');
	        //Definimos la data del cuerpo.
	        foreach($empresas as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
	        	$contador++;
	        	//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_empresa']);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['cod_empresa']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['orden_empresa']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['observaciones_empresa']);
		        $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['reporte']);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['nom_status']);
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Empresas.xls";
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

    public function Festivo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_festivo'] = $this->Model_snappy->get_list_festivo();
        $this->load->view('Admin/festivo/index',$dato);
    }

    public function Modal_Festivo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_tipo_festivo'] = $this->Model_snappy->get_list_tipo_festivo();
            $this->load->view('Admin/festivo/modal_festivo', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Modal_Update_Festivo($id_calendar_festivo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_festivo($id_calendar_festivo);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $dato['list_tipo_festivo'] = $this->Model_snappy->get_list_tipo_festivo();
            $this->load->view('Admin/festivo/upd_modal_festivo', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function Insert_Festivo(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $dato['descripcion']= $this->input->post("descripcion");
        $dato['inicio']= $this->input->post("inicio");
        $dato['fin']=$dato['inicio'];
        $dato['anio']= $this->input->post("anio");        
        $dato['mes']=substr($this->input->post("inicio"),5,2);
        $dato['dia']=substr($this->input->post("inicio"),8,2);
        $dato['iniciosf'] = strtotime($dato['inicio']);
        
        
        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $dato['id_tipo_fecha'] = $this->input->post("id_tipo_fecha"); 
        $dato['observaciones'] = $this->input->post("observaciones");
        $dato['id_status'] = $this->input->post("id_status");
        $get_color = $this->Model_snappy->get_color_tipo_festivo($dato['id_tipo_fecha']);
        $dato['color'] = $get_color[0]['color'];

        $this->Model_snappy->insert_festivo($dato);

        redirect('Snappy/Festivo');  
    }

    public function Update_Festivo(){
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $dato['id_calendar_festivo']= $this->input->post("id_calendar_festivo");
        $dato['descripcion']= $this->input->post("descripcion");
        $dato['inicio']= $this->input->post("inicio");
        $dato['fin']=$dato['inicio'];
        $dato['anio']= $this->input->post("anio");        
        $dato['mes']=substr($this->input->post("inicio"),5,2);
        $dato['dia']=substr($this->input->post("inicio"),8,2);
        $dato['iniciosf'] = strtotime($dato['inicio']);
        
        
        $dato['nom_dia']=$dias[date('w', $dato['iniciosf'])];
        $dato['nom_mes']=$meses[date('n', $dato['iniciosf'])-1];

        $dato['id_tipo_fecha'] = $this->input->post("id_tipo_fecha"); 
        $dato['observaciones'] = $this->input->post("observaciones");
        $dato['id_status'] = $this->input->post("id_status");
        $get_color = $this->Model_snappy->get_color_tipo_festivo($dato['id_tipo_fecha']);
        $dato['color'] = $get_color[0]['color'];

        $this->Model_snappy->update_festivo($dato);

        redirect('Snappy/Festivo');  
    }

    public function Tipo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        
        $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
        $this->load->view('Admin/tipo/index',$dato);
    }

    public function Modal_tipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/tipo/modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Tipo($id_tipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_tipo($id_tipo);
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/tipo/upd_modal_tipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Tipo(){
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
    
        $this->Model_snappy->insert_tipo($dato);
    
        redirect('Snappy/Tipo');  
    }
    
    public function Update_Tipo(){
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_tipo']= $this->input->post("nom_tipo"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $this->Model_snappy->update_tipo($dato);
    
        redirect('Snappy/Tipo');  
    }

    public function Subtipo() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_subtipo'] = $this->Model_snappy->get_list_subtipo();
    
        $this->load->view('Admin/subtipo/index',$dato);
    }

    public function Modal_Subtipo(){
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/subtipo/modal_subtipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Modal_Update_Subtipo($id_subtipo){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_subtipo($id_subtipo);
            $dato['list_tipo'] = $this->Model_snappy->get_list_tipos();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/subtipo/upd_modal_subtipo', $dato);   
        }
        else{
            //$this->load->view('login/login');
            redirect('/login');
        }
    }
    
    public function Insert_Subtipo(){
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_subtipo']= $this->input->post("nom_subtipo"); 
        $dato['tipo_subtipo_arte']= $this->input->post("tipo_subtipo_arte");
        $dato['tipo_subtipo_redes']= $this->input->post("tipo_subtipo_redes"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['rep_redes']= $this->input->post("rep_redes"); 
    
        $this->Model_snappy->insert_subtipo($dato);
    
        redirect('Snappy/Subtipo');  
    }

    public function Update_Subtipo(){
        
        $dato['id_subtipo']= $this->input->post("id_subtipo"); 
        $dato['id_tipo']= $this->input->post("id_tipo"); 
        $dato['nom_subtipo']= $this->input->post("nom_subtipo"); 
        $dato['tipo_subtipo_arte']= $this->input->post("tipo_subtipo_arte");
        $dato['tipo_subtipo_redes']= $this->input->post("tipo_subtipo_redes"); 
        $dato['id_status']= $this->input->post("id_status"); 
        $dato['rep_redes']= $this->input->post("rep_redes"); 
 
        $this->Model_snappy->update_subtipo($dato);
    
        redirect('Snappy/Subtipo');  
    }

    public function Excel_Subtipo(){
        $subtipo = $this->Model_snappy->get_list_subtipo();
        if(count($subtipo) > 0){
        	//Cargamos la librería de excel.
        	$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Sub-Tipo');
            
	        //Contador de filas
            $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            //Le aplicamos color a la cabecera
            $this->excel->getActiveSheet()->getStyle("A1:F1")->applyFromArray(array("fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "C8C8C8"))));

            //Le aplicamos Filtro a las columnas
            $this->excel->getActiveSheet()->setAutoFilter('A1:F1');
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Tipo');	        
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Sub-Tipo');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'SNAPPYS');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'REDES');	        
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Rep. Redes');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Status');
	        //Definimos la data del cuerpo.
	        foreach($subtipo as $list){
	        	//Incrementamos una fila más, para ir a la siguiente.
	        	$contador++;
	        	//Informacion de las filas de la consulta.
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $list['nom_tipo']);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}", $list['nom_subtipo']);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $list['tipo_subtipo_arte']);
                $this->excel->getActiveSheet()->setCellValue("D{$contador}", $list['tipo_subtipo_redes']);
		        $this->excel->getActiveSheet()->setCellValue("E{$contador}", $list['reporte']);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}", $list['nom_status']);
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
            //$archivo = "llamadas_cliente_{$id_cliente}.xls"; "Esto es un ejemplo"
            $archivo = "Lista_Sub_Tipo.xls";
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
    
    public function Usuario() {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['list_usuario'] = $this->Model_snappy->get_list_usuario();
    
        $this->load->view('Admin/usuarios/index',$dato);
    }
    
    
    public function Modal_Usuario(){
        if ($this->session->userdata('usuario')) {
            $dato['list_nivel'] = $this->Model_snappy->get_list_nivel();
            $dato['list_estado'] = $this->Model_snappy->get_list_estado();
            $this->load->view('Admin/usuarios/modal_usuario', $dato);   
        }
        else{
            redirect('/login');
        }
    }

    public function modal_img(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('configuracion/modal_img');   
        }
        else{
            redirect('/login');
        }
    }

    public function update_img($id_intranet){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_snappy->get_id_intranet($id_intranet);
            $this->load->view('configuracion/upd_modal_img',$dato);   
        }
        else{
            redirect('/login');
        }
    
    }
    
    public function Insert_fondo(){
        $dato['foto']= $this->input->post("productImage"); 
        $dato['nom_fintranet']= $this->input->post("nom_fintranet");  

        $this->Model_snappy->insert_fondo($dato);

        redirect('Snappy/configuracion');  
    }

    function eliminarfoto() {
        $data['id_fintranet'] = $this->input->post("id");
        $data['estado'] = $this->input->post("estado");
        $data['user_act'] =$_SESSION['usuario'][0]['id_usuario'];
        $this->Model_snappy->eliminar_foto($data);
    }

    public function update_foto(){
        $dato['nom_fintranet']= $this->input->post("nom_fintranet"); 
        $dato['foto']= $this->input->post("actuimagen"); 
        $dato['id_fintranet']= $this->input->post("id_fintranet"); 
        $this->Model_snappy->update_foto($dato);
        redirect('Snappy/configuracion');  
    }
}