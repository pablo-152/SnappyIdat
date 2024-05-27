<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
use SebastianBergmann\Environment\Console;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class AppIFV extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Model_IFV');
        $this->load->model('Admin_model');
        $this->load->model('Model_General');
        $this->load->helper('download');
        $this->load->helper(array('text'));
        $this->load->library("parser");
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper('form');
    }

    protected function jsonResponse($respuesta = array())
    {
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

    public function index()
    {
        if ($this->session->userdata('usuario')) {
            $data['fondo_ifv'] = $this->Model_IFV->Model_IFV();
            
            //NO BORRAR AVISO
            $data['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $data['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $data['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $data['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $data['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $data['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $data['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $data['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

            $this->load->view('view_IFV/administrador/index', $data);
        } else {
            redirect('/login');
        }
    }

    public function Detalle_Aviso()
    {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

            $this->load->view('view_IFV/aviso/detalle', $dato);
        } else {
            redirect('/login');
        }
    }

    //-------------------Alumnos-------------------
    public function Matriculados_C()
    {
        if ($this->session->userdata('usuario')) {
           //NO BORRAR AVISO
           $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
           $dato['list_aviso'] = $this->Model_General->get_list_aviso();

           $nivel = $_SESSION['usuario'][0]['id_nivel'];
           $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
           $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
           $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
           $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
           $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
           $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
           $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/matriculados_c/index', $dato);
        } else {
            redirect('');
        }
    }

    public function Lista_Matriculados_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            //echo $dato['tipo'];
            $dato['list_matriculado'] = $this->Model_IFV->get_list_matriculados($dato['tipo']);
            $dato['list_recomendado'] = $this->Model_IFV->get_dni_alumno_recomendados();

            if ($dato['tipo'] == 3) {
                $this->load->view('view_IFV/matriculados_c/lista_retirados', $dato);
            } else {
                $this->load->view('view_IFV/matriculados_c/lista', $dato);
            }
        } else {
            redirect('');
        }
    }

    public function Excel_Matriculados_C($tipo)
    {
        $list_matriculado = $this->Model_IFV->get_list_matriculados_excel($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("B2:AE1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:AE2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Matriculados L20');

        $sheet->setAutoFilter('B2:AE2');

        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(18);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(18);
        $sheet->getColumnDimension('W')->setWidth(15);
        $sheet->getColumnDimension('X')->setWidth(15);
        $sheet->getColumnDimension('Y')->setWidth(15);
        $sheet->getColumnDimension('Z')->setWidth(15);
        $sheet->getColumnDimension('AA')->setWidth(15);
        $sheet->getColumnDimension('AB')->setWidth(15);
        $sheet->getColumnDimension('AC')->setWidth(50);
        $sheet->getColumnDimension('AD')->setWidth(50);
        $sheet->getColumnDimension('AE')->setWidth(50);


        $sheet->getStyle('B2:AE2')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("B2:AE2")->getFill()
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

        $sheet->getStyle("B2:AE2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("B2", 'Apellido Paterno');
        $sheet->setCellValue("C2", 'Apellido Materno');
        $sheet->setCellValue("D2", 'Nombre(s)');
        $sheet->setCellValue("E2", 'DNI');
        $sheet->setCellValue("F2", 'Celular');
        $sheet->setCellValue("G2", 'Correo');
        $sheet->setCellValue("H2", 'Correo Inst.');
        $sheet->setCellValue("I2", 'Código');
        $sheet->setCellValue("J2", 'Grupo');
        $sheet->setCellValue("K2", 'Especialidad');
        $sheet->setCellValue("L2", 'Turno');
        $sheet->setCellValue("M2", 'Módulo');
        $sheet->setCellValue("N2", 'Ciclo');
        $sheet->setCellValue("O2", 'Sección');
        $sheet->setCellValue("P2", 'Matrícula');
        $sheet->setCellValue("Q2", 'Alumno');
        $sheet->setCellValue("R2", 'Foto');
        $sheet->setCellValue("S2", 'Doc');
        $sheet->setCellValue("T2", 'Fcheck');
        $sheet->setCellValue("U2", 'Matricula 1');
        $sheet->setCellValue("V2", 'Fecha');
        $sheet->setCellValue("W2", 'Cuota 1');
        $sheet->setCellValue("X2", 'Fecha');
        $sheet->setCellValue("Y2", 'Matricula 2');
        $sheet->setCellValue("Z2", 'Fecha');
        $sheet->setCellValue("AA2", 'Cuota 6');
        $sheet->setCellValue("AB2", 'Fecha');
        $sheet->setCellValue("AC2", 'Pagos');
        $sheet->setCellValue("AD2", 'Link Foto');
        $sheet->setCellValue("AE2", 'Observación');

        $sheet->freezePane('A3');

        $contador = 2;

        foreach ($list_matriculado as $list) {
            $contador++;

            $sheet->getStyle("B{$contador}:AB{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("W{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("Y{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("AC{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B{$contador}:AE{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$contador}:AE{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("AE{$contador}")->getFont()->getColor()->setRGB('1E88E5');
            $sheet->getStyle("AE{$contador}")->getFont()->setUnderline(true);
            $sheet->getStyle("S{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("U{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("W{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("Y{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("B{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("C{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("D{$contador}", $list['Nombre']);
            $sheet->setCellValue("E{$contador}", $list['Dni']);
            $sheet->setCellValue("F{$contador}", $list['Celular']);
            $sheet->setCellValue("G{$contador}", $list['Email']);
            $sheet->setCellValue("H{$contador}", $list['Correo_Institucional']);
            $sheet->setCellValue("I{$contador}", $list['Codigo']);
            $sheet->setCellValue("J{$contador}", $list['Grupo']);
            $sheet->setCellValue("K{$contador}", $list['Especialidad']);
            $sheet->setCellValue("L{$contador}", $list['Turno']);
            $sheet->setCellValue("M{$contador}", $list['Modulo']);
            $sheet->setCellValue("N{$contador}", $list['Ciclo']);
            $sheet->setCellValue("O{$contador}", $list['Seccion']);
            $sheet->setCellValue("P{$contador}", $list['Matricula']);
            $sheet->setCellValue("Q{$contador}", $list['Alumno']);
            $sheet->setCellValue("S{$contador}", "");
            $sheet->setCellValue("T{$contador}", $list['v_fotocheck']);
            $sheet->setCellValue("AC{$contador}", $list['nom_pago_pendiente']);
            $sheet->setCellValue("ACD{$contador}", "");
            $sheet->setCellValue("AE{$contador}", $list['comentariog']);//
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Matriculados L20';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Detalle_Matriculados_C($id_alumno)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_id_matriculados($id_alumno);
            $dato['get_foto'] = $this->Model_IFV->get_list_foto_matriculados($id_alumno);
            $dato['id_empresa'] = 6;

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/matriculados_c/detalle', $dato);
        } else {
            redirect('/login');
        }
    }


    //---------------------------------GRUPO----------------------------
    public function Grupo_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_grupo'] = $this->Model_IFV->get_list_grupo_c_total();
            $dato['list_matriculados'] = $this->Model_IFV->get_list_matriculados_c_total();

           //NO BORRAR AVISO
           $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
           $dato['list_aviso'] = $this->Model_General->get_list_aviso();

           $nivel = $_SESSION['usuario'][0]['id_nivel'];
           $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
           $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
           $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
           $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
           $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
           $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
           $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);



            $this->load->view('view_IFV/grupo_c/index', $dato);
        } else {
            redirect('');
        }
    }

    public function Lista_Grupo_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_grupo'] = $this->Model_IFV->get_list_grupo_c($dato['tipo']);
            $dato['estados'] = [
                'Sin Iniciar' => '#0070c0',
                'Suspendido' => 'red',
                'Finalizado' => 'orange',
                'Sigue Activo' => '#92d050'
            ];
            $this->load->view('view_IFV/grupo_c/lista', $dato);
        } else {
            redirect('');
        }
    }

    public function Detalle_Grupo_C($id_grupo)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_id_grupo_c($id_grupo);
            $dato['list_usuario'] = $this->Model_IFV->get_list_usuario_observacion();

           //NO BORRAR AVISO
           $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
           $dato['list_aviso'] = $this->Model_General->get_list_aviso();

           $nivel = $_SESSION['usuario'][0]['id_nivel'];
           $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
           $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
           $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
           $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
           $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
           $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
           $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/grupo_c/detalle', $dato);
        } else {
            redirect('');
        }
    }

    public function Lista_Alumno_Grupo_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_grupo'] = $this->input->post("id_grupo");
            $get_id = $this->Model_IFV->get_id_grupo_c($dato['id_grupo']);
            //$dato['list_alumno'] = $this->Model_IFV->get_list_alumno_grupo_c($get_id[0]['grupo'],$get_id[0]['nom_especialidad'],$get_id[0]['id_seccion']);
            $dato['list_alumno'] = $this->Model_IFV->get_list_alumno_grupo_c($dato['id_grupo'], $get_id[0]['nom_especialidad']);
            $this->load->view('view_IFV/grupo_c/lista_alumno', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Lista_Documento_Grupo_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_grupo'] = $this->input->post("id_grupo");
            $dato['list_documento'] = $this->Model_IFV->get_list_documento_grupo_c($dato['id_grupo']);
            $this->load->view('view_IFV/grupo_c/lista_documento', $dato);
        } else {
            redirect('/login');
        }
    }
    
    public function Descargar_Documento_Grupo_C($id_documento)
    {
        if ($this->session->userdata('usuario')) {
            $dato['doc'] = $this->Model_IFV->get_id_documento_grupo($id_documento);
            $imagen = $dato['doc'][0]['archivo'];
            force_download($imagen, NULL);
        } else {
            redirect('');
        }
    }

    public function Delete_Documento_Grupo_C()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_documento'] = $this->input->post("id_documento");
            $dato['doc'] = $this->Model_IFV->get_id_documento_grupo($dato['id_documento']);
            unlink($dato['doc'][0]['archivo']);
            $this->Model_IFV->delete_documento_grupo_c($dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Update_Documento_Grupo_C($id_documento)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_id_documento_grupo($id_documento);
            $this->load->view('view_IFV/grupo_c/modal_editar_documento', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Documento_Grupo_C()
    {
        $dato['id_documento'] = $this->input->post("id_documento");
        $dato['archivo'] = $this->input->post("archivo_actual");

        if ($_FILES["archivo_u"]["name"] != "") {
            if (file_exists($dato['archivo'])) {
                unlink($dato['archivo']);
            }
            $dato['nom_documento'] = str_replace(' ', '_', $_FILES["archivo_u"]["name"]);
            //$dato['nom_documento'] = str_replace(':','_',$dato['nom_documento']);
            $config['upload_path'] = './documento_grupo/' . $dato['id_documento'];
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
                chmod('./documento_grupo/' . $dato['id_documento'], 0777);
                chmod('./documento_grupo/' . $dato['id_documento'], 0777);
            }
            $config["allowed_types"] = 'png|pdf';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $path = $_FILES["archivo_u"]["name"];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $_FILES["file"]["name"] = $dato['nom_documento'];
            $_FILES["file"]["type"] = $_FILES["archivo_u"]["type"];
            $_FILES["file"]["tmp_name"] = $_FILES["archivo_u"]["tmp_name"];
            $_FILES["file"]["error"] = $_FILES["archivo_u"]["error"];
            $_FILES["file"]["size"] = $_FILES["archivo_u"]["size"];
            if ($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $dato['archivo'] = "documento_grupo/" . $dato['id_documento'] . "/" . $dato['nom_documento'];
            }
        }
        $this->Model_IFV->update_documento_grupo_c($dato);
    }

    //---------documentos cargados
    public function Documento_Recibido()
    {
        if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/documento_recibido/index', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Lista_Documento_Recibido($t)
    {
        if ($this->session->userdata('usuario')) {
            //$dato['list_alumno'] = $this->Model_IFV->get_list_todos_alumno('2');
            $dato['list_documento_recibido'] = $this->Model_IFV->get_list_documento_recibido($t);
            $dato['t'] = $t;
            $this->load->view('view_IFV/documento_recibido/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Update_Documento_Recibido($id_doc_cargado)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_id_documento_recibido($id_doc_cargado);
            $this->load->view('view_IFV/documento_recibido/modal_editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Documento_Recibido()
    {
        $dato['id_doc_cargado'] = $this->input->post("id_doc_cargado");
        $dato['get_id'] = $this->Model_IFV->get_id_documento_recibido($dato['id_doc_cargado']);
        $dato['estado'] = $this->input->post("estado_u");
        $dato['id_motivo'] = $this->input->post("id_motivo_u");

        $this->Model_IFV->update_documento_cargado($dato);
        if ($dato['estado'] == 4) {
            $mail = new PHPMailer(true);
            try {


                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                $mail->Password = 'ifvc2022';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreplay@ifv.edu.pe', "Admisión Instituto");

                //$mail->addAddress($dato['get_id'][0]['email']);
                $mail->addAddress('ruizandiap.idat@gmail.com');

                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = "Documentos Validados";


                $mail->Body = '<FONT SIZE=4>Estimado Alumno:<br>
                Su documento ya se encuentra validado y su pago del derecho de examen se encuentra activo.</FONT SIZE>';
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }

    public function Modal_Anular_Documento_Recibido($id_doc_cargado)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_id_documento_recibido($id_doc_cargado);
            $this->load->view('view_IFV/documento_recibido/modal_anular', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Documento_Recibido_Anular()
    {
        $dato['id_doc_cargado'] = $this->input->post("id_doc_cargado");
        $dato['id_motivo'] = $this->input->post("id_motivo");
        $this->Model_IFV->update_documento_cargado_anular($dato);
    }

    public function Descargar_Documento_Recibido($id_doc_cargado)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_IFV->get_id_documento_recibido($id_doc_cargado);
            $dato['get_config'] = $this->Model_IFV->get_config('horario_cargado_ifv');
            $image = $dato['get_config'][0]['url_config'] . $dato['get_file'][0]['documento'];
            $name = basename($image);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            //$data=$this->Model_IFV->get_config('documento_ifv');
            //force_download($name , file_get_contents("fvdoc/".$dato['get_file'][0]['documento']));
            force_download($name, file_get_contents($image));
        } else {
            redirect('');
        }
    }

    public function Excel_Documento_Recibido($tipo)
    {
        $list_documento_recibido = $this->Model_IFV->get_list_documento_recibido($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos Recibidos');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(40);

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

        $sheet->setCellValue("A1", 'Ap. Paterno');
        $sheet->setCellValue("B1", 'Ap. Materno');
        $sheet->setCellValue("C1", 'Nombre(s)');
        $sheet->setCellValue("D1", 'Código');
        $sheet->setCellValue("E1", 'Especialidad');
        $sheet->setCellValue("F1", 'Documento');
        $sheet->setCellValue("G1", 'Estado');
        $sheet->setCellValue("H1", 'Usuario');
        $sheet->setCellValue("I1", 'Fecha');
        $sheet->setCellValue("J1", 'Motivo');

        $contador = 1;

        foreach ($list_documento_recibido as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("B{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("C{$contador}", $list['nom_alumno']);
            $sheet->setCellValue("D{$contador}", $list['Codigo']);
            $sheet->setCellValue("E{$contador}", $list['Especialidad']);
            $sheet->setCellValue("F{$contador}", $list['nom_documento']);
            $sheet->setCellValue("G{$contador}", $list['desc_estado']);
            if ($list['estado'] != 2) {
                $sheet->setCellValue("H{$contador}", $list['usuario_codigo']);
            }
            if ($list['estado'] == 2) {
                if ($list['fecha_registro'] != "") {
                    $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_registro']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("I{$contador}", "");
                }
            } else {
                if ($list['fecha_actualizacion'] != "") {
                    $sheet->setCellValue("I{$contador}", Date::PHPToExcel($list['fecha_actualizacion']));
                    $sheet->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("I{$contador}", "");
                }
            }
            $sheet->setCellValue("J{$contador}", $list['desc_motivo']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documentos Recibidos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //-------------------------------------------Lista Fut Recibido------------------------------------------//
    public function Fut_Recibido()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

       //NO BORRAR AVISO
       $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
       $dato['list_aviso'] = $this->Model_General->get_list_aviso();

       $nivel = $_SESSION['usuario'][0]['id_nivel'];
       $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
       $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
       $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
       $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
       $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
       $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
       $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


        $this->load->view('view_IFV/fut_recibido/index', $dato);
    }

    public function Listar_Fut_Recibidos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['cod_val'] = $this->input->post("id");
            $dato['list'] = $this->Model_IFV->get_fut_recibidos($dato);
            $this->load->view('view_IFV/fut_recibido/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Fut_Recibido($dat)
    {
        $dato['cod_val'] = $dat;
        $data = $this->Model_IFV->get_fut_recibidos($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->setTitle('FUT Recibidos (Lista)');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(35);
        $sheet->getColumnDimension('M')->setWidth(30);


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

        $sheet->getStyle("A1:J1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Código FUT');
        $sheet->setCellValue("B1", 'Producto');
        $sheet->setCellValue("C1", 'Asunto');
        $sheet->setCellValue("D1", 'Fecha Envio');
        $sheet->setCellValue("E1", 'Texto');
        $sheet->setCellValue("F1", 'Código');
        $sheet->setCellValue("G1", 'DNI');
        $sheet->setCellValue("H1", 'Nombre del Alumno');
        $sheet->setCellValue("I1", 'Apellido Paterno');
        $sheet->setCellValue("J1", 'Apellido Materno');
        $sheet->setCellValue("K1", 'Especialidad');
        $sheet->setCellValue("L1", 'Correo');
        $sheet->setCellValue("M1", 'Estado');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_fut']);
            $sheet->setCellValue("B{$contador}", $list['nom_producto']);
            $sheet->setCellValue("C{$contador}", $list['asunto']);
            $sheet->setCellValue("D{$contador}", $list['Fecha_envio']);
            $sheet->setCellValue("E{$contador}", $list['texto_fut']);
            $sheet->setCellValue("F{$contador}", $list['Codigo']);
            $sheet->setCellValue("G{$contador}", $list['Dni']);
            $sheet->setCellValue("H{$contador}", $list['nom_alumno']);
            $sheet->setCellValue("I{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("J{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("K{$contador}", $list['Especialidad']);
            $sheet->setCellValue("L{$contador}", $list['email']);
            $sheet->setCellValue("M{$contador}", $list['nom_status']);
        }


        $writer = new Xlsx($spreadsheet);
        $filename = 'FUT Recibidos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Historial_Fut_Recibido($id_envio)
    {
        $dato['id_envio'] = $id_envio;

        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['get_id'] = $this->Model_IFV->get_fut_recibido_id($dato);
        $dato['list_detalle_fut'] = $this->Model_IFV->get_list_detalle_fut($dato);

       //NO BORRAR AVISO
       $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
       $dato['list_aviso'] = $this->Model_General->get_list_aviso();

       $nivel = $_SESSION['usuario'][0]['id_nivel'];
       $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
       $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
       $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
       $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
       $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
       $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
       $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


        $this->load->view('view_IFV/fut_recibido/detalle', $dato);
    }

    public function Modal_Detalle_Fut($id_envio)
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_envio'] = $id_envio;
            $dato['get_id'] = $this->Model_IFV->get_fut_recibido_id($dato);
            $dato['list_estados'] = $this->Model_IFV->get_list_estados();
            $this->load->view('view_IFV/fut_recibido/modal_historial', $dato);
        } else {
            redirect('/login');
        }
    }


    public function Insert_Detalle_Fut()
    {
        $dato['id_estado_i'] = $this->input->post("id_estado_i");
        $dato['observacion_i'] = $this->input->post("observacion_i");
        $dato['id_envio'] = $this->input->post("id_envio");
        $dato['list'] = $this->Model_IFV->get_fut_recibido_id($dato);
        $dato['Email'] = $dato['list'][0]['email'];
        if ($dato['list'][0]['Grupo'] == '23/3') {
            $dato['Email'] = $dato['list'][0]['Correo_Institucional'];
        }

        $dato['img_comuimg'] = $this->input->post("img_comuimg");
        //var_dump($dato['observacion_i']);
        /*$valida = $this->Model_IFV->valida_insert_tipo_c_contrato($dato);

        if(count($valida)>0){
            echo "error";
        }else{*/


        $this->Model_IFV->insert_detalle_fut($dato);
        //}

        if ($dato['Email'] != "") {
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                $mail->Password = 'ifvc2022';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 587;     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto'); //desde donde se envia


                //$mail->addAddress($dato['Email']);
                $mail->addAddress('ruizandiap.idat@gmail.com');
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Documentos Recibidos";

                if ($dato['id_estado_i'] == "66") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra APROBADO , por lo que se procederá a notificar  a las áreas<br>
                    correspondientes para su conocimiento y atención respectiva.</FONT SIZE>';
                } elseif ($dato['id_estado_i'] == "69") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra OBSERVADO , por lo que deberás comunicarte con<br>
                    secretaría académica al 942301990.</FONT SIZE>';
                } elseif ($dato['id_estado_i'] == "67") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra RECHAZADO , la documentación adjunta no CALIFICA como<br>
                    evidencia por lo que se procederá a notificar  a las áreas correspondientes.<br>
                    Se recomienda presentar nuevo FUT con una explicación más detallada y evidencias más específicas.<br>
                    Mayor información al 942301990.</FONT SIZE>';
                }
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
            echo "1enviado";
        }
    }


    public function Modal_Update_Detalle_Fut($id_envio_det)
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_envio_det'] = $id_envio_det;
            //echo($dato['id_envio']);
            $dato['get_id'] = $this->Model_IFV->get_list_detalle_fut_id($dato);
            $dato['list_estados'] = $this->Model_IFV->get_list_estados();
            $this->load->view('view_IFV/fut_recibido/modal_historial_upd', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Detalle_Fut()
    {
        $dato['id_estado_e'] = $this->input->post("id_estado_e");
        $dato['observacion_e'] = $this->input->post("observacion_e");
        $dato['id_envio_det'] = $this->input->post("id_envio_det");
        $dato['id_envio'] = $this->input->post("id_envio");
        $dato['list'] = $this->Model_IFV->get_fut_recibido_id($dato);
        $dato['Email'] = $dato['list'][0]['email'];
        $dato['img_comuimge'] = $this->input->post("img_comuimge");

        if ($dato['list'][0]['Grupo'] == '23/3') {
            $dato['Email'] = $dato['list'][0]['Correo_Institucional'];
        }
        //var_dump($dato['img_comuimge']);
        /*$valida = $this->Model_IFV->valida_insert_tipo_c_contrato($dato);

        if(count($valida)>0){
            echo "error";
        }else{*/
        $this->Model_IFV->update_detalle_fut($dato);
        //}

        if ($dato['Email'] != "") {
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                $mail->Password = 'ifvc2022';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 587;     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto'); //desde donde se envia


                //$mail->addAddress($dato['Email']);
                $mail->addAddress('ruizandiap.idat@gmail.com');
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Documentos Recibidos";

                if ($dato['id_estado_e'] == "66") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra APROBADO , por lo que se procederá a notificar  a las áreas.<br>
                    correspondientes para su conocimiento y atención respectiva.</FONT SIZE>';
                } elseif ($dato['id_estado_e'] == "69") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra OBSERVADO , por lo que deberás adjuntar nuevas evidencias<br>
                    correspondientes para su conocimiento y atención respectiva.<br>
                    contactarse al 942301990.</FONT SIZE>';
                } elseif ($dato['id_estado_e'] == "67") {
                    $mail->Body = '<FONT SIZE=4>Hola<br>
                    Te informamos que el FUT que haz presentado se encuentra RECHAZADO , la documentación adjunta no CALIFICA como<br>
                    evidencia por lo que se procederá a notificar  a las áreas correspondientes.<br>
                    Se recomienda presentar nuevo FUT con una explicación más detallada y evidencias más específicas.<br>
                    Mayor información al 942301990.</FONT SIZE>';
                }
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
            echo "1enviado";
        }
    }

    public function Delete_Detalle_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_historial'] = $this->input->post("id_historial");
            $dato['id_fut'] = $this->input->post("id_fut");
            $this->Model_IFV->delete_detalle_fut($dato);

            $ultimo_estado = $this->Model_IFV->get_list_ultimo_estado_id($dato);
            $dato['estado_ultimo'] = $ultimo_estado;
            $this->Model_IFV->update_ultimo_estado($dato);
            //var_dump($dato['id_historial']);
            var_dump($dato['estado_ultimo']);

        } else {
            redirect('/login');
        }
    }

    public function Descargar_Fut_Recibido($id_envio_det)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_IFV->get_id_fut_recibido($id_envio_det);
            //var_dump($dato['get_file'][0]['pdf_envio_det']);
            $ruta1 = "comunicado_ifv";
            if ($dato['get_file'][0]['estado_envio_det'] == 65) {
                $ruta1 = "horario_cargado_ifv";
            }
            $dato['get_config'] = $this->Model_IFV->get_config($ruta1);
            $image = $dato['get_config'][0]['url_config'] . $dato['get_file'][0]['pdf_envio_det'];
            $name = basename($image);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            //$data=$this->Model_IFV->get_config('documento_ifv');
            //force_download($name , file_get_contents("fvdoc/".$dato['get_file'][0]['documento']));
            force_download($name, file_get_contents($image));
        } else {
            redirect('');
        }
    }


    //Contactenos
    public function Contactenos()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

       //NO BORRAR AVISO
       $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
       $dato['list_aviso'] = $this->Model_General->get_list_aviso();

       $nivel = $_SESSION['usuario'][0]['id_nivel'];
       $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
       $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
       $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
       $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
       $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
       $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
       $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

        $this->load->view('view_IFV/contactenos/index', $dato);
    }

    public function Listar_Contactenos($tipo)
    {
        if ($this->session->userdata('usuario')) {
            //$tipo = $this->input->post("tipo");
            $dato['id_usuario'] = $_SESSION['usuario'][0]['id_usuario'];
            $dato['list'] = $this->Model_IFV->get_list_contactenos($tipo);
            $this->load->view('view_IFV/contactenos/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Actualizar_Contactenos($id_contactenos)
    {
        if ($this->session->userdata('usuario')) {
            $dato['id'] = $id_contactenos;
            $dato['get_id'] = $this->Model_IFV->get_list_contactenos(3, $dato);
            $dato['list'] = $this->Model_IFV->get_list_estados_contactenos();
            $this->load->view('view_IFV/contactenos/modal_editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Actualizar_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['estado'] = $this->input->post("estado_e");
            $dato['id_contacto'] = $this->input->post("id_contactoe");
            //$dato['mod'] = 2;
            /*$total = count($this->Model_IFV->valida_tipo_documento($dato));*/
            /*if ($total > 0) {
				echo "error";
			} else {*/
            $this->Model_IFV->update_contactenos($dato);
            //}
        } else {
            redirect('/login');
        }
    }

     //-----------------------------------NUEVA VENTA-------------------------------------
     public function Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $valida = $this->Model_IFV->valida_insert_nueva_venta();
 
             if (count($valida) == 0) {
                 $this->Model_IFV->insert_nueva_venta();
             } else {
                 $this->Model_IFV->resetear_nueva_venta();
             }
 
             //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

             $this->load->view('view_IFV/ventas/nueva/index', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Alumno_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['list_alumno'] = $this->Model_IFV->get_list_alumno_nueva_venta();
             $dato['get_id'] = $this->Model_IFV->get_list_nueva_venta();
 
             $get_id = $this->Model_IFV->valida_insert_nueva_venta();
 
             if ($get_id[0]['id_alumno'] > 0) {
                 $dato['valida_alumno'] = 1;
                 $dato['get_alumno'] = $this->Model_IFV->get_list_alumno_nueva_venta($get_id[0]['id_alumno']);
             } else {
                 $dato['valida_alumno'] = 0;
             }
 
             $this->load->view('view_IFV/ventas/nueva/alumno', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Lista_Producto_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['list_nueva_venta'] = $this->Model_IFV->get_list_producto_nueva_venta();
             $this->load->view('view_IFV/ventas/nueva/lista', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Botones_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $list_nueva_venta = $this->Model_IFV->get_list_producto_nueva_venta();
             $subtotal = 0;
             foreach ($list_nueva_venta as $list) {
                 $subtotal = $subtotal + ($list['cantidad'] * ($list['precio'] - $list['descuento']));
             }
             $dato['subtotal'] = $subtotal;
             $this->load->view('view_IFV/ventas/nueva/botones', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Detalle_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['get_id'] = $this->Model_IFV->get_list_nueva_venta();
             $this->load->view('view_IFV/ventas/nueva/detalle', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Update_Alumno_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['id_alumno'] = $this->input->post("id_alumno");
             $this->Model_IFV->update_alumno_nueva_venta($dato['id_alumno']);
         } else {
             redirect('/login');
         }
     }
 
     public function Delete_Alumno_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $this->Model_IFV->delete_alumno_nueva_venta();
         } else {
             redirect('/login');
         }
     }
 
     public function Insert_Producto_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $cod_producto = $this->input->post("cod_producto");
             $get_id = $this->Model_IFV->get_cod_producto_nueva_venta($cod_producto);
 
             if (count($get_id) > 0) {
                 $dato['cod_producto'] = $get_id[0]['cod_producto'];
                 $dato['precio'] = $get_id[0]['monto'];
                 $dato['descuento'] = $get_id[0]['descuento'];
 
                 $valida = $this->Model_IFV->valida_insert_nueva_venta_producto($dato);
 
                 if (count($valida) > 0) {
                     echo "cantidad";
                 } else {
                     $this->Model_IFV->insert_nueva_venta_producto($dato);
                 }
                 /*if(count($valida)>0){
                     $dato['cantidad'] = $valida[0]['cantidad']+1;
                     $this->Model_IFV->update_nueva_venta_producto($dato);
                 }else{
                     $this->Model_IFV->insert_nueva_venta_producto($dato);
                 }*/
             } else {
                 echo "error";
             }
         } else {
             redirect('/login');
         }
     }
 
     public function Delete_Producto_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['id_nueva_venta_producto'] = $this->input->post("id_nueva_venta_producto");
             $this->Model_IFV->delete_nueva_venta_producto($dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Modal_Producto_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['list_producto'] = $this->Model_IFV->get_list_combo_producto_venta();
             $dato['list_nueva_venta'] = $this->Model_IFV->get_list_producto_nueva_venta();
             $this->load->view('view_IFV/ventas/nueva/modal_producto', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Modal_Botones_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $list_nueva_venta = $this->Model_IFV->get_list_producto_nueva_venta();
             $subtotal = 0;
             $cantidad = 0;
             foreach ($list_nueva_venta as $list) {
                 $subtotal = $subtotal + ($list['cantidad'] * ($list['precio'] - $list['descuento']));
                 $cantidad = $cantidad + $list['cantidad'];
             }
             $dato['subtotal'] = $subtotal;
             $dato['cantidad'] = $cantidad;
             $this->load->view('view_IFV/ventas/nueva/modal_botones', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Insert_Modal_Producto_Nueva_Venta()
     {
         if ($this->session->userdata('usuario')) {
 
             $dato['cod_producto'] = $this->input->post("cod_producto");
             $get_id = $this->Model_IFV->get_cod_producto_nueva_venta($dato['cod_producto']);
             $dato['nom_sistema'] = $get_id[0]['nom_sistema'];
             $dato['id_tipo'] = $get_id[0]['id_tipo'];
             $dato['cod_producto'] = $get_id[0]['cod_producto'];
             $dato['precio'] = $get_id[0]['monto'];
             $dato['descuento'] = $get_id[0]['descuento'];
 
             if ($dato['id_tipo'] == 1) {
                 $validar1 = $this->Model_IFV->valida_insert_nueva_venta_id($dato);
                 if (count($validar1) > 0) {
                     echo "error2";
                 } else {
                     $this->Model_IFV->insert_nueva_venta_producto($dato);
                 }
             } else {
                 $this->Model_IFV->insert_nueva_venta_producto($dato);
             }
 
             /*$validar2 = $this->Model_IFV->valida_insert_nueva_venta_producto($dato);*/
             /*if(count($validar2)>0){
                 echo "error";
             }
             else*/
             /*if(count($validar)>0){
                 $dato['cantidad'] = $validar[0]['cantidad']+1;
                 $this->Model_IFV->update_nueva_venta_producto($dato);
             }else{
                 $this->Model_IFV->insert_nueva_venta_producto($dato);
             }*/
         } else {
             redirect('/login');
         }
     }
 
     public function Modal_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $list_nueva_venta = $this->Model_IFV->get_list_producto_nueva_venta();
 
             $subtotal = 0;
             if (count($list_nueva_venta) > 0) {
                 foreach ($list_nueva_venta as $list) {
                     $subtotal = $subtotal + ($list['cantidad'] * ($list['precio'] - $list['descuento']));
                 }
             }
 
             $dato['subtotal'] = $subtotal;
 
             $this->load->view('view_IFV/ventas/nueva/modal_detalle', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Insert_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['id_tipo_pago'] = $this->input->post("id_tipo_pago");
             $dato['monto_entregado'] = $this->input->post("monto_entregado");
 
             if ($dato['monto_entregado'] == "") {
                 $dato['monto_entregado'] = 0;
             }
 
             $list_nueva_venta = $this->Model_IFV->get_list_producto_nueva_venta();
 
             if (count($list_nueva_venta) > 0) {
                 $subtotal = 0;
                 foreach ($list_nueva_venta as $list) {
                     $subtotal = $subtotal + ($list['cantidad'] * ($list['precio'] - $list['descuento']));
                 }
 
                 $dato['cambio'] = $dato['monto_entregado'] - $subtotal;
 
                 $get_id = $this->Model_IFV->get_list_nueva_venta();
 
                 if ($get_id[0]['id_alumno'] > 0) {
                     $valida_cierre_caja = $this->Model_IFV->valida_cierre_caja();
 
                     if (count($valida_cierre_caja) == 0) {
                         $cantidad_recibo = $this->Model_IFV->cantidad_recibo();
                         $totalRows_t = count($cantidad_recibo);
                         $aniof = substr(date('Y'), 2, 2);
 
                         if ($totalRows_t < 9) {
                             $codigo = $aniof . "R-FV10000" . ($totalRows_t + 1);
                         }
                         if ($totalRows_t > 8 && $totalRows_t < 99) {
                             $codigo = $aniof . "R-FV1000" . ($totalRows_t + 1);
                         }
                         if ($totalRows_t > 98 && $totalRows_t < 999) {
                             $codigo = $aniof . "R-FV100" . ($totalRows_t + 1);
                         }
                         if ($totalRows_t > 998 && $totalRows_t < 9999) {
                             $codigo = $aniof . "R-FV10" . ($totalRows_t + 1);
                         }
                         if ($totalRows_t > 9998 && $totalRows_t < 99999) {
                             $codigo = $aniof . "R-FV1" . ($totalRows_t + 1);
                         }
 
                         $dato['cod_venta'] = $codigo;
 
                         //---
                         $dato['code'] = "";
                         $get_tipo_prod = $this->Model_IFV->valida_venta_detalle();
                         /*echo($get_tipo_prod[0]['cod_producto']);*/
 
                         if (count($get_tipo_prod) > 0 && $get_tipo_prod[0]['id_tipo'] == "1") {
                             //if($get_tipo_prod[0]['id_tipo']=="1"){19490
                             $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                             $longitud = strlen($caracteres);
                             while (true) {
                                 for ($i = 0; $i < 6; $i++) {
                                     $dato['code'] .= $caracteres[mt_rand(0, $longitud - 1)];
                                 }
                                 // Verificar si el código ya existe en la base de datos
                                 $data = $this->Model_IFV->valida_cod_aleatorio_venta_ifv($dato);
                                 if (count($data) == 0) {
                                     break;
                                 }
                             }
                             $dato['code'] = $aniof . strtolower($dato['code']);
                             //}
                         }
 
                         $this->Model_IFV->insert_venta($dato);
                         $get_id = $this->Model_IFV->ultimo_id_venta();
                         $dato['id_venta'] = $get_id[0]['id_venta'];
                         $this->Model_IFV->insert_venta_detalle($dato);
                         $get_id_detalle = $this->Model_IFV->get_venta_detalle_xproducto($dato);
                         if (count($get_id_detalle) > 0) {
                             $dato['id_alumno'] = $get_id_detalle[0]['id_alumno'];
                             $dato['monto'] = $get_id_detalle[0]['monto'];
                             $dato['cod_venta'] = $get_id_detalle[0]['cod_venta'];
                             $this->Model_IFV->insert_fotocheck($dato);
 
                             $get_alumno = $this->Model_IFV->get_id_matriculados($get_id[0]['id_alumno']);
 
                             $mail = new PHPMailer(true);
 
                             try {
                                 $mail->SMTPDebug = 0;                      // Enable verbose debug output
                                 $mail->isSMTP();                                            // Send using SMTP
                                 $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                 $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                                 $mail->Username = 'dcomunicacion@ifv.edu.pe';                     // usuario de acceso
                                 $mail->Password = 'graficoifv00';                                // SMTP password
                                 $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                 $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                 $mail->setFrom('dcomunicacion@ifv.edu.pe', "Instituto"); //desde donde se envia
 
                                 //$mail->addAddress($get_alumno[0]['Email']);
                                 $mail->addAddress('ruizandiap.idat@gmail.com');
                                 $mail->isHTML(true);                                  // Set email format to HTML
 
                                 $mail->Subject = "Pago de Fotocheck";
 
                                 $mail->Body = '<FONT SIZE=3>
                                                     ¡Hola!<br><br>
                                                     Recibimos el pago de tu fotocheck.<br><br>
                                                     Por favor contacta lo antes posible al departamento de Comunicación <br>
                                                     IFV para que puedas sacar tu foto. Sin ella no podemos avanzar. <br>
                                                     Acuerdate que el fotocheck es obligatorio para que puedas ingresar <br>
                                                     en nuestras instalaciones y hacer tus prácticas. <br><br>
                                                     Que tengas un excelente dia.<br>
                                                     Instituto<br>
                                                 </FONT SIZE>';
 
                                 $mail->CharSet = 'UTF-8';
                                 $mail->send();
 
                             } catch (Exception $e) {
                                 echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                             }
 
                             if ($get_alumno[0]['Celular'] != '' && $get_alumno[0]['Celular'] !== NULL) {
                                 $curl = curl_init();
 
                                 curl_setopt_array($curl, array(
                                     CURLOPT_URL => 'https://www.altiria.net:8443/api/http',
                                     CURLOPT_RETURNTRANSFER => true,
                                     CURLOPT_ENCODING => '',
                                     CURLOPT_MAXREDIRS => 10,
                                     CURLOPT_TIMEOUT => 0,
                                     CURLOPT_FOLLOWLOCATION => true,
                                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                     CURLOPT_CUSTOMREQUEST => 'POST',
                                     CURLOPT_POSTFIELDS => 'cmd=sendsms&login=vanessa.hilario%40gllg.edu.pe&passwd=gllg2021&dest=51' . $get_alumno[0]['Celular'] . '&msg=¡Hola!%0ARecibimos%20el%20pago%20de%20tu%20fotocheck.%0APor%20favor%20contacta%20lo%20antes%20posible%20al%20departamento%20de%20Comunicaci%C3%B3n%20IFV%20para%20que%20puedas%20sacar%20tu%20foto.%0AInstituto%20Federico%20Villarreal&concat=true',
                                     CURLOPT_HTTPHEADER => array(
                                         'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                                     ),
                                 ));
 
                                 $response = curl_exec($curl);
 
                                 curl_close($curl);
                             }
                         }
                         $this->Model_IFV->delete_nueva_venta($dato);
 
                         echo "correcto*" . $dato['id_venta'];
                     } else {
                         echo "cierre_caja*0";
                     }
                 } else {
                     echo "alumno*0";
                 }
             } else {
                 echo "producto*0";
             }
         } else {
             redirect('/login');
         }
     }
 
     public function Recibo_Venta($id_venta)
     {
         if ($this->session->userdata('usuario')) {
             $dato['get_id'] = $this->Model_IFV->get_list_venta($id_venta);
             $dato['list_detalle'] = $this->Model_IFV->get_list_venta_detalle($id_venta);
             $dato['validacion'] = count($this->Model_IFV->get_valida_detalle($id_venta));
             $dato['fut'] = "";
             if ($dato['validacion'] > 0) {
                 $dato['fut'] = "Código FUT:   " . $dato['get_id'][0]['codigo'];
             }
             $cantidad_filas = 30 * count($dato['list_detalle']);
             $dato['altura'] = 500 + $cantidad_filas;
 
             $mpdf = new \Mpdf\Mpdf([
                 "format" => "A4",
                 'default_font' => 'gothic',
             ]);
             $html = $this->load->view('view_IFV/ventas/nueva/recibo', $dato, true);
             $mpdf->WriteHTML($html);
             $mpdf->Output();
         } else {
             redirect('');
         }
     }
 
     public function Descargar_Adjunto_Horario($id_grupo)
     {
         if ($this->session->userdata('usuario')) {
             $data = explode("_", $id_grupo);
             $id_grupo = $data[0];
             $dato['get_id'] = $this->Model_IFV->get_id_grupo_c($id_grupo);
             if ($data[1] == "1") {
                 $name = basename($dato['get_id'][0]['horario_grupo']);
                 $ext = pathinfo($dato['get_id'][0]['horario_grupo'], PATHINFO_EXTENSION);
                 force_download($name, file_get_contents($dato['get_id'][0]['horario_grupo']));
             } else if ($data[1] == "2") {
                 $name = basename($dato['get_id'][0]['horario_grupo_cel']);
                 $ext = pathinfo($dato['get_id'][0]['horario_grupo_cel'], PATHINFO_EXTENSION);
                 force_download($name, file_get_contents($dato['get_id'][0]['horario_grupo_cel']));
             } else {
                 $name = basename($dato['get_id'][0]['horario_pdf']);
                 $ext = pathinfo($dato['get_id'][0]['horario_pdf'], PATHINFO_EXTENSION);
                 force_download($name, file_get_contents($dato['get_id'][0]['horario_pdf']));
             }
         } else {
             redirect('');
         }
     }
 
     //-------------------------------------------Lista Ventas Ifv------------------------------------------//
    public function Lista_Venta()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        //NO BORRAR AVISO
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
        $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


        $this->load->view('view_IFV/ventas/lista/index', $dato);
    }

    public function Listar_Ventas()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_venta'] = $this->Model_IFV->get_list_venta_ifv();
            $this->load->view('view_IFV/ventas/lista/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Lista_Ventas()
    {
        $list_venta = $this->Model_IFV->get_list_venta_ifv();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Venta');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(22);
        $sheet->getColumnDimension('M')->setWidth(18);

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

        $sheet->setCellValue("A1", 'Codigo');
        $sheet->setCellValue("B1", 'Tipo(s) Producto(s)');
        $sheet->setCellValue("C1", 'Producto(s)');
        $sheet->setCellValue("D1", 'Codigo Aleatorio');
        $sheet->setCellValue("E1", 'Codigo');
        $sheet->setCellValue("F1", 'Ap. Paterno');
        $sheet->setCellValue("G1", 'Ap. Materno');
        $sheet->setCellValue("H1", 'Nombre(s)');
        $sheet->setCellValue("I1", 'Especialidad');
        $sheet->setCellValue("J1", 'Grupo');
        $sheet->setCellValue("K1", 'Sección');
        $sheet->setCellValue("L1", 'Monto Entregado');
        $sheet->setCellValue("M1", 'Fecha de Pago');

        $contador = 1;

        foreach ($list_venta as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_venta']);
            $sheet->setCellValue("B{$contador}", $list['tipos']);
            $sheet->setCellValue("C{$contador}", $list['productos']);
            $sheet->setCellValue("D{$contador}", $list['cod_aleatorio']);
            $sheet->setCellValue("E{$contador}", $list['Codigo']);
            $sheet->setCellValue("F{$contador}", $list['Apellido_Paterno']);
            $sheet->setCellValue("G{$contador}", $list['Apellido_Materno']);
            $sheet->setCellValue("H{$contador}", $list['Nombre']);
            $sheet->setCellValue("I{$contador}", $list['Especialidad']);
            $sheet->setCellValue("J{$contador}", $list['Grupo']);
            $sheet->setCellValue("K{$contador}", $list['Seccion']);
            $sheet->setCellValue("L{$contador}", $list['monto_entregado']);
            $sheet->setCellValue("M{$contador}", Date::PHPToExcel($list['fecha_pago']));
            $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Venta (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //------motivo contactenos
    public function C_Motivo_Contactenos()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
//NO BORRAR AVISO
$dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
$dato['list_aviso'] = $this->Model_General->get_list_aviso();

$nivel = $_SESSION['usuario'][0]['id_nivel'];
$id_usuario = $_SESSION['usuario'][0]['id_usuario'];
$dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
$dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
$dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
$dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
$dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
$dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


        $this->load->view('view_IFV/motivo_contactenos/index', $dato);
    }

    //esto es dee contactenos ifv
    public function Modal_C_Motivo_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_IFV->get_list_tipo_motivo_contactanos();
            $dato['list_usuario'] = $this->Model_IFV->get_list_usuario_evento();
            $this->load->view('view_IFV/motivo_contactenos/modal_registrar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function List_C_Motivo_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_motivo'] = $this->Model_IFV->get_list_motivo_contactenos();
            $dato['list_usuario'] = $this->Model_IFV->get_list_usuario_evento();
            $this->load->view('view_IFV/motivo_contactenos/list_motivo', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Insert_C_Motivo_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['titulo'] = $this->input->post("titulo");
            //$dato['de'] = $this->input->post("de");
            $dato['para'] = $this->input->post("para");
            $dato['mod'] = 1;

            if ($this->input->post("usuarios") != "") {
                $dato['usuarios'] = implode(",", $this->input->post("usuarios"));
            } else {
                $dato['usuarios'] = "";
            }

            $total = count($this->Model_IFV->valida_motivo_contactenos($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->insert_motivo_contactenos($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Modal_Update_C_Motivo_Contactenos($id_motivo)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_list_motivo_contactenos($id_motivo);
            $dato['list_tipo'] = $this->Model_IFV->get_list_tipo_motivo_contactanos();
            $dato['list_usuario'] = $this->Model_IFV->get_list_usuario_evento();
            $this->load->view('view_IFV/motivo_contactenos/modal_editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_C_Motivo_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_motivo'] = $this->input->post("id_motivo");
            $dato['tipo'] = $this->input->post("tipoe");
            $dato['titulo'] = $this->input->post("tituloe");
            //$dato['de'] = $this->input->post("dee");
            $dato['para'] = $this->input->post("parae");
            $dato['mod'] = 2;

            if ($this->input->post("usuarios") != "") {
                $dato['usuarios'] = implode(",", $this->input->post("usuarios"));
            } else {
                $dato['usuarios'] = "";
            }

            $total = count($this->Model_IFV->valida_motivo_contactenos($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->update_motivo_contactenos($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Delete_C_Motivo_Contactenos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_motivo'] = $this->input->post("id_motivo");
            $this->Model_IFV->delete_motivo_contactenos($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_C_Motivo_Contactenos()
    {
        $data = $this->Model_IFV->get_list_motivo_contactenos();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //$sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Motivo Contactenos');

        $sheet->setAutoFilter('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(40);
        //$sheet->getColumnDimension('D')->setWidth(25);

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

        $sheet->setCellValue("A1", 'Tipo');
        $sheet->setCellValue("B1", 'Titulo');
        //$sheet->setCellValue("C1", 'De');
        $sheet->setCellValue("C1", 'Para');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_tipo']);
            $sheet->setCellValue("B{$contador}", $list['titulo']);
            $sheet->setCellValue("C{$contador}", $list['para']);
            //$sheet->setCellValue("D{$contador}", $list['para']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Motivo Contactenos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //----ifv documentos configuracion
    public function Documento_Configuracion_Ifv()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

      //NO BORRAR AVISO
      $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
      $dato['list_aviso'] = $this->Model_General->get_list_aviso();

      $nivel = $_SESSION['usuario'][0]['id_nivel'];
      $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
      $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
      $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
      $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
      $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
      $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
      $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

        $this->load->view('view_IFV/documento_configuracion/index', $dato);
    }

    public function Listar_Documento_Configuracion()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_documento'] = $this->Model_IFV->get_list_documento_configuracion();
            $this->load->view('view_IFV/documento_configuracion/list_documento', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Registrar_Documento_Configuracion()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list'] = $this->Model_IFV->get_list_tipo_documento($id_motivo = null);
            $this->load->view('view_IFV/documento_configuracion/modal_registrar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Registrar_Documento_Configuracion()
    {
        if ($this->session->userdata('usuario')) {
            $dato['codigo'] = $this->input->post("codigo");
            $dato['nombre'] = $this->input->post("nombre");
            $dato['asunto'] = $this->input->post("asunto");
            $dato['id_tipo'] = $this->input->post("tipo");
            $dato['texto'] = $this->input->post("texto");
            $dato['mod'] = 1;
            $total = count($this->Model_IFV->valida_documento_configuracion($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->insert_documento_configuracion($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Modal_Actualizar_Documento_Configuracion($id_motivo)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_list_documento_configuracion($id_motivo);
            $dato['list'] = $this->Model_IFV->get_list_tipo_documento($id_motivo = null);
            $this->load->view('view_IFV/documento_configuracion/modal_editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Actualizar_Documento_Configuracion()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_documento'] = $this->input->post("id_documento");
            $dato['codigo'] = $this->input->post("codigo_e");
            $dato['nombre'] = $this->input->post("nombre_e");
            $dato['asunto'] = $this->input->post("asunto_e");
            $dato['id_tipo'] = $this->input->post("tipo_e");
            $dato['texto'] = $this->input->post("texto_e");
            $dato['mod'] = 2;
            $total = count($this->Model_IFV->valida_documento_configuracion($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->update_documento_configuracion($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Eliminar_Documento_Configuracion()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_documento'] = $this->input->post("id_documento");
            $this->Model_IFV->delete_documento_configuracion($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Documento_Configuracion()
    {
        $data = $this->Model_IFV->get_list_documento_configuracion();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //$sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Documentos IGB Online');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);

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

        $sheet->setCellValue("A1", 'Codigo');
        $sheet->setCellValue("B1", 'Nombre');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['codigo']);
            $sheet->setCellValue("B{$contador}", $list['nombre']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Documentos IGB Online';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //----------------Ingreso Calendarizacion y pagos -----------------//
    public function Ingreso_CalendayPagos()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

   //NO BORRAR AVISO
   $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
   $dato['list_aviso'] = $this->Model_General->get_list_aviso();

   $nivel = $_SESSION['usuario'][0]['id_nivel'];
   $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
   $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
   $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
   $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
   $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
   $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
   $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


        $this->load->view('view_IFV/ingreso_calendaypagos/index', $dato);
    }

    public function Listar_CalendayPagos()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list'] = $this->Model_IFV->get_list_calendaypagos();
            $this->load->view('view_IFV/ingreso_calendaypagos/list', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_CalendayPagos()
    {
        $data = $this->Model_IFV->get_list_texto_fut();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->setTitle('Texto FUT (Lista)');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(90);

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

        $sheet->setCellValue("A1", 'Producto');
        $sheet->setCellValue("B1", 'Texto');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            //$sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_sistema']);
            $sheet->setCellValue("B{$contador}", $list['texto']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Texto FUT (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //texto fut
    public function Documento_Configuracion_Texto()
    {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }

        //NO BORRAR AVISO
        $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
        $dato['list_aviso'] = $this->Model_General->get_list_aviso();

        $nivel = $_SESSION['usuario'][0]['id_nivel'];
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
        $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
        $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
        $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
        $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
        $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
        $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

        $this->load->view('view_IFV/texto_fut_configuracion/index', $dato);
    }

    public function Listar_Texto_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list'] = $this->Model_IFV->get_list_texto_fut();
            $this->load->view('view_IFV/texto_fut_configuracion/list_texto_fut', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Modal_Registrar_Texto_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list'] = $this->Model_IFV->get_list_producto_venta_fut();
            $this->load->view('view_IFV/texto_fut_configuracion/modal_registrar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Registrar_Texto_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['producto'] = $this->input->post("producto");
            $dato['asunto'] = $this->input->post("asunto");
            $dato['texto'] = $this->input->post("texto");
            $dato['id_producto'] = $this->input->post("id_producto");
            $dato['mod'] = 1;
            $total = count($this->Model_IFV->valida_texto_fut($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->insert_texto_fut($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Modal_Actualizar_Texto_Fut($id_motivo)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_list_texto_fut($id_motivo);
            $dato['productos'] = $this->Model_IFV->get_list_producto_venta_fut();
            $this->load->view('view_IFV/texto_fut_configuracion/modal_editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Actualizar_Texto_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_texto'] = $this->input->post("id_texto_e");
            $dato['asunto'] = $this->input->post("asunto_e");
            $dato['id_producto'] = $this->input->post("id_producto_e");
            $dato['producto'] = $this->input->post("producto_e");
            $dato['texto'] = $this->input->post("texto_e");
            $dato['mod'] = 2;
            $total = count($this->Model_IFV->valida_texto_fut($dato));
            if ($total > 0) {
                echo "error";
            } else {
                $this->Model_IFV->update_texto_fut($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Eliminar_Texto_Fut()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_texto'] = $this->input->post("id_texto");
            $this->Model_IFV->delete_texto_fut($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Texto_Fut()
    {
        $data = $this->Model_IFV->get_list_texto_fut();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->setTitle('Texto FUT (Lista)');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(90);

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

        $sheet->setCellValue("A1", 'Producto');
        $sheet->setCellValue("B1", 'Texto');

        $contador = 1;

        foreach ($data as $list) {
            $contador++;

            //$sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['nom_sistema']);
            $sheet->setCellValue("B{$contador}", $list['texto']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Texto FUT (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //-----------------------------------PRODUCTO VENTA-------------------------------------
    public function Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
           //NO BORRAR AVISO
           $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
           $dato['list_aviso'] = $this->Model_General->get_list_aviso();

           $nivel = $_SESSION['usuario'][0]['id_nivel'];
           $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
           $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
           $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
           $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
           $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
           $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
           $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

            $this->load->view('view_IFV/ventas/producto/index', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Lista_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['tipo'] = $this->input->post("tipo");
            $dato['list_producto_venta'] = $this->Model_IFV->get_list_producto_venta($id_producto = null, $dato);
            $this->load->view('view_IFV/ventas/producto/lista', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Registrar_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['list_tipo'] = $this->Model_IFV->get_list_tipo_venta_combo();
            $dato['list_anio'] = $this->Model_IFV->get_list_anio();

           //NO BORRAR AVISO
           $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
           $dato['list_aviso'] = $this->Model_General->get_list_aviso();

           $nivel = $_SESSION['usuario'][0]['id_nivel'];
           $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
           $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
           $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
           $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
           $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
           $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
           $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/ventas/producto/registrar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Insert_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['cod_producto'] = $this->input->post("cod_producto");
            $dato['id_tipo'] = $this->input->post("id_tipo");
            $dato['id_anio'] = $this->input->post("id_anio");
            $dato['nom_sistema'] = $this->input->post("nom_sistema");
            $dato['nom_documento'] = $this->input->post("nom_documento");
            $dato['fec_inicio'] = $this->input->post("fec_inicio");
            $dato['fec_fin'] = $this->input->post("fec_fin");
            $dato['monto'] = $this->input->post("monto");
            $dato['descuento'] = $this->input->post("descuento");
            $dato['validado'] = $this->input->post("validado");
            $dato['codigo'] = $this->input->post("codigo");
            $dato['pago_automatizado'] = $this->input->post("pago_automatizado");

            $valida = $this->Model_IFV->valida_insert_producto_venta($dato);

            if (count($valida) > 0) {
                echo "error";
            } else {
                $this->Model_IFV->insert_producto_venta($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Editar_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $id_producto = $this->input->post("id_producto");
            $dato['get_id'] = $this->Model_IFV->get_list_producto_venta($id_producto, $dato = null);
            $dato['list_tipo'] = $this->Model_IFV->get_list_tipo_venta_combo();
            $dato['list_anio'] = $this->Model_IFV->get_list_anio();
            $dato['list_estado'] = $this->Model_IFV->get_list_estado();

            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/ventas/producto/editar', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Update_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_producto'] = $this->input->post("id_producto");
            $dato['cod_producto'] = $this->input->post("cod_producto");
            $dato['id_tipo'] = $this->input->post("id_tipo");
            $dato['id_anio'] = $this->input->post("id_anio");
            $dato['nom_sistema'] = $this->input->post("nom_sistema");
            $dato['nom_documento'] = $this->input->post("nom_documento");
            $dato['fec_inicio'] = $this->input->post("fec_inicio");
            $dato['fec_fin'] = $this->input->post("fec_fin");
            $dato['monto'] = $this->input->post("monto");
            $dato['descuento'] = $this->input->post("descuento");
            $dato['validado'] = $this->input->post("validado");
            $dato['codigo'] = $this->input->post("codigo");
            $dato['pago_automatizado'] = $this->input->post("pago_automatizado");
            $dato['estado'] = $this->input->post("estado");

            $valida = $this->Model_IFV->valida_update_producto_venta($dato);

            if (count($valida) > 0) {
                echo "error";
            } else {
                $this->Model_IFV->update_producto_venta($dato);
            }
        } else {
            redirect('/login');
        }
    }

    public function Delete_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $dato['id_producto'] = $this->input->post("id_producto");
            $this->Model_IFV->delete_producto_venta($dato);
        } else {
            redirect('/login');
        }
    }

    public function Excel_Producto_Venta($tipo)
    {
        $dato['tipo'] = $tipo;
        $list_producto_venta = $this->Model_IFV->get_list_producto_venta($id_prod = null, $dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:U1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:U1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Producto');

        $sheet->setAutoFilter('A1:U1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(24);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(26);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(20);
        $sheet->getColumnDimension('U')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", 'Año');
        $sheet->setCellValue("C1", 'Tipo');
        $sheet->setCellValue("D1", 'Nombre Sistema');
        $sheet->setCellValue("E1", 'Nombre Documento');
        $sheet->setCellValue("F1", 'Fecha Inicio Pago');
        $sheet->setCellValue("G1", 'Fecha Fin Pago');
        $sheet->setCellValue("H1", 'Monto');
        $sheet->setCellValue("I1", 'Descuento');
        $sheet->setCellValue("J1", 'Total');
        $sheet->setCellValue("K1", 'Validado');
        $sheet->setCellValue("L1", 'Código');
        $sheet->setCellValue("M1", 'Pago Automatizado');
        $sheet->setCellValue("N1", 'Asignado');
        $sheet->setCellValue("O1", 'Ventas');
        $sheet->setCellValue("P1", 'Ventas (Monto)');
        $sheet->setCellValue("Q1", 'Devoluciones');
        $sheet->setCellValue("R1", 'Devoluciones (Monto)');
        $sheet->setCellValue("S1", 'Total');
        $sheet->setCellValue("T1", 'Total (Monto)');
        $sheet->setCellValue("U1", 'Estado');

        $contador = 1;

        foreach ($list_producto_venta as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("P{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("T{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$contador}:U{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:U{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("H{$contador}:J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("R{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list['cod_producto']);
            $sheet->setCellValue("B{$contador}", $list['nom_anio']);
            $sheet->setCellValue("C{$contador}", $list['cod_tipo']);
            $sheet->setCellValue("D{$contador}", $list['nom_sistema']);
            $sheet->setCellValue("E{$contador}", $list['nom_documento']);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list['fec_ini']));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['fec_fin']));
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("H{$contador}", $list['monto']);
            $sheet->setCellValue("I{$contador}", $list['descuento']);
            $sheet->setCellValue("J{$contador}", ($list['monto'] - $list['descuento']));
            $sheet->setCellValue("K{$contador}", $list['validado']);
            $sheet->setCellValue("L{$contador}", $list['codigo']);
            $sheet->setCellValue("M{$contador}", $list['pago_automatizado']);
            $sheet->setCellValue("N{$contador}", $list['ventas']);
            $sheet->setCellValue("O{$contador}", $list['ventas']);
            $sheet->setCellValue("P{$contador}", $list['ventas_monto']);
            $sheet->setCellValue("Q{$contador}", $list['devoluciones']);
            $sheet->setCellValue("R{$contador}", $list['devoluciones_monto']);
            $sheet->setCellValue("S{$contador}", ($list['ventas'] - $list['devoluciones']));
            $sheet->setCellValue("T{$contador}", ($list['ventas_monto'] - $list['devoluciones_monto']));
            $sheet->setCellValue("U{$contador}", $list['nom_status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Producto (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Detalle_Producto_Venta($id_producto)
    {
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_IFV->get_list_producto_venta($id_producto);
            $dato['list_tipo'] = $this->Model_IFV->get_list_tipo_venta_combo();
            $dato['list_anio'] = $this->Model_IFV->get_list_anio();
            $dato['list_estado'] = $this->Model_IFV->get_list_estado();

       //NO BORRAR AVISO
       $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
       $dato['list_aviso'] = $this->Model_General->get_list_aviso();

       $nivel = $_SESSION['usuario'][0]['id_nivel'];
       $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
       $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
       $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
       $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
       $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
       $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
       $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);


            $this->load->view('view_IFV/ventas/producto/detalle', $dato);
        } else {
            redirect('/login');
        }
    }

    public function Lista_Venta_Producto_Venta()
    {
        if ($this->session->userdata('usuario')) {
            $cod_producto = $this->input->post("cod_producto");
            $dato['list_venta'] = $this->Model_IFV->get_list_venta_producto_venta($cod_producto);
            $this->load->view('view_IFV/ventas/producto/lista_venta', $dato);
        } else {
            redirect('/login');
        }
    }

     //-----------------------------------TIPO VENTA-------------------------------------
     public function Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
            //NO BORRAR AVISO
            $dato['cant_avisos'] = count($this->Model_General->get_list_aviso());
            $dato['list_aviso'] = $this->Model_General->get_list_aviso();

            $nivel = $_SESSION['usuario'][0]['id_nivel'];
            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
            $dato['menu'] = $this->Admin_model->get_list_menus_usuario($id_usuario);
            $dato['modulo'] = $this->Admin_model->get_list_modulo($id_usuario);
            $dato['submodulo'] = $this->Admin_model->get_list_submodulo($id_usuario);
            $dato['list_empresa'] = $this->Admin_model->get_id_empresa_usuario($id_usuario);
            $dato['list_nav_sede'] = $this->Model_IFV->get_list_nav_sede();
            $dato['contador_contactenos'] = $this->Model_IFV->get_list_contactenos(1);

 
             $this->load->view('view_IFV/ventas/tipo/index', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Lista_Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['list_tipo_venta'] = $this->Model_IFV->get_list_tipo_venta();
             $this->load->view('view_IFV/ventas/tipo/lista', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Modal_Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $this->load->view('view_IFV/ventas/tipo/modal_registrar');
         } else {
             redirect('/login');
         }
     }
 
     public function Insert_Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['cod_tipo'] = $this->input->post("cod_tipo_i");
             $dato['descripcion'] = $this->input->post("descripcion_i");
             $dato['foto'] = "";
 
             $validar = $this->Model_IFV->valida_insert_tipo_venta($dato);
 
             if (count($validar) > 0) {
                 echo "error";
             } else {
                
                 $this->Model_IFV->insert_tipo_venta($dato);
             }
         } else {
             redirect('/login');
         }
     }
 
     public function Modal_Update_Tipo_Venta($id_tipo)
     {
         if ($this->session->userdata('usuario')) {
             $dato['get_id'] = $this->Model_IFV->get_list_tipo_venta($id_tipo);
             $dato['list_estado'] = $this->Model_IFV->get_list_estado();
             $this->load->view('view_IFV/ventas/tipo/modal_editar', $dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Update_Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['id_tipo'] = $this->input->post("id_tipo");
             $dato['cod_tipo'] = $this->input->post("cod_tipo_u");
             $dato['descripcion'] = $this->input->post("descripcion_u");
             //$dato['foto']= $this->input->post("foto_actual");
             $dato['estado'] = $this->input->post("estado_u");
 
             $validar = $this->Model_IFV->valida_update_tipo_venta($dato);
 
             if (count($validar) > 0) {
                 echo "error";
             } else {
                 
 
                 $this->Model_IFV->update_tipo_venta($dato);
             }
         } else {
             redirect('/login');
         }
     }
 
     public function Delete_Tipo_Venta()
     {
         if ($this->session->userdata('usuario')) {
             $dato['id_tipo'] = $this->input->post("id_tipo");
             $this->Model_IFV->delete_tipo_venta($dato);
         } else {
             redirect('/login');
         }
     }
 
     public function Descargar_Foto_Tipo_Venta($id_tipo)
     {
         if ($this->session->userdata('usuario')) {
             $dato['get_file'] = $this->Model_IFV->get_list_tipo_venta($id_tipo);
             $image = $dato['get_file'][0]['foto'];
             $name = basename($image);
             $ext = pathinfo($image, PATHINFO_EXTENSION);
             force_download($name, file_get_contents($dato['get_file'][0]['foto']));
         } else {
             redirect('');
         }
     }
 
     public function Excel_Tipo_Venta()
     {
         $list_tipo_venta = $this->Model_IFV->get_list_tipo_venta();
 
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
         $sheet->getStyle("A1:C1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
 
         $spreadsheet->getActiveSheet()->setTitle('Tipo');
 
         $sheet->setAutoFilter('A1:C1');
 
         $sheet->getColumnDimension('A')->setWidth(40);
         $sheet->getColumnDimension('B')->setWidth(60);
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
 
         $sheet->setCellValue("A1", 'Código');
         $sheet->setCellValue("B1", 'Descripción');
         $sheet->setCellValue("C1", 'Estado');
 
         $contador = 1;
 
         foreach ($list_tipo_venta as $list) {
             $contador++;
 
             $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
             $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
             $sheet->getStyle("A{$contador}:C{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
             $sheet->getStyle("A{$contador}:C{$contador}")->applyFromArray($styleThinBlackBorderOutline);
 
             $sheet->setCellValue("A{$contador}", $list['cod_tipo']);
             $sheet->setCellValue("B{$contador}", $list['descripcion']);
             $sheet->setCellValue("C{$contador}", $list['nom_status']);
         }
 
         $writer = new Xlsx($spreadsheet);
         $filename = 'Tipo (Lista)';
         if (ob_get_contents()) ob_end_clean();
         header('Content-Type: application/vnd.ms-excel');
         header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
         header('Cache-Control: max-age=0');
 
         $writer->save('php://output');
     }

     public function Excel_Grupo_C($tipo)
    {
        $list_grupo = $this->Model_IFV->get_list_grupo_c($tipo);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:AF1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:AF1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Grupos (Lista)');

        $sheet->setAutoFilter('A1:AF1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(18);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(22);
        $sheet->getColumnDimension('U')->setWidth(20);
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->getColumnDimension('X')->setWidth(28);
        $sheet->getColumnDimension('Y')->setWidth(25);
        $sheet->getColumnDimension('Z')->setWidth(34);
        $sheet->getColumnDimension('AA')->setWidth(32);
        $sheet->getColumnDimension('AB')->setWidth(18);
        $sheet->getColumnDimension('AC')->setWidth(15);
        $sheet->getColumnDimension('AD')->setWidth(18);
        $sheet->getColumnDimension('AE')->setWidth(15);
        $sheet->getColumnDimension('AF')->setWidth(15);

        $sheet->getStyle('A1:AF1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:AF1")->getFill()
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

        $sheet->getStyle("A1:AF1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", 'Grupo');
        $sheet->setCellValue("C1", 'Cod. Esp.');
        $sheet->setCellValue("D1", 'Especialidad');
        $sheet->setCellValue("E1", 'Modulo');
        $sheet->setCellValue("F1", 'Turno');
        $sheet->setCellValue("G1", 'Ciclo');
        $sheet->setCellValue("H1", 'Sección');
        $sheet->setCellValue("I1", 'Salón');
        $sheet->setCellValue("J1", 'Cantidad de alumnos');
        $sheet->setCellValue("K1", 'Semana');
        $sheet->setCellValue("L1", 'Inicio Clases');
        $sheet->setCellValue("M1", 'Fin Clases');
        $sheet->setCellValue("N1", 'Matriculados');
        $sheet->setCellValue("O1", 'Disponible');
        $sheet->setCellValue("P1", 'Promovidos');
        $sheet->setCellValue("Q1", 'Retirados');
        $sheet->setCellValue("R1", 'Inicio Campaña');
        $sheet->setCellValue("S1", 'Primer Examen');
        $sheet->setCellValue("T1", 'Segundo Examen');
        $sheet->setCellValue("U1", 'Tercer Examen');
        $sheet->setCellValue("V1", 'Cuarto Examen');
        $sheet->setCellValue("W1", 'Quinto Examen');
        $sheet->setCellValue("X1", 'Matricula Regular Inicio');
        $sheet->setCellValue("Y1", 'Matricula Regular Fin');
        $sheet->setCellValue("Z1", 'Matricula Extemporanea Inicio');
        $sheet->setCellValue("AA1", 'Matricula Extemporanea Fin');
        $sheet->setCellValue("AB1", 'Documentos');
        $sheet->setCellValue("AC1", 'Matricula');
        $sheet->setCellValue("AD1", '% Matricula');
        $sheet->setCellValue("AE1", '% Cuota');
        $sheet->setCellValue("AF1", 'Estado');

        $contador = 1;

        foreach ($list_grupo as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:AE{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:AE{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:AE{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_grupo']);
            $sheet->setCellValue("B{$contador}", $list['grupo']);
            $sheet->setCellValue("C{$contador}", $list['abreviatura']);
            $sheet->setCellValue("D{$contador}", $list['nom_especialidad']);
            $sheet->setCellValue("E{$contador}", $list['modulo']);
            $sheet->setCellValue("F{$contador}", $list['nom_turno']);
            $sheet->setCellValue("G{$contador}", $list['ciclo']);
            $sheet->setCellValue("H{$contador}", $list['id_seccion']);
            $sheet->setCellValue("I{$contador}", $list['nom_salon']);
            $sheet->setCellValue("J{$contador}", ($list['matriculados'] + $list['promovidos']));
            $sheet->setCellValue("K{$contador}", ("Sem " . $list['semana']));

            if ($list['inicio_clase'] != "" && $list['inicio_clase'] != "0000-00-00") {
                $sheet->setCellValue("L{$contador}", Date::PHPToExcel($list['inicio_clase']));
                $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("L{$contador}", "");
            }

            if ($list['fin_clase'] != "" && $list['fin_clase'] != "0000-00-00") {
                $sheet->setCellValue("M{$contador}", Date::PHPToExcel($list['fin_clase']));
                $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("M{$contador}", "");
            }

            $sheet->setCellValue("N{$contador}", $list['matriculados']);
            $sheet->setCellValue("O{$contador}", $list['disponible']);
            $sheet->setCellValue("P{$contador}", $list['promovidos']);
            $sheet->setCellValue("Q{$contador}", $list['retirados']);

            if ($list['inicio_campania'] != "" && $list['inicio_campania'] != "0000-00-00") {
                $sheet->setCellValue("R{$contador}", Date::PHPToExcel($list['inicio_campania']));
                $sheet->getStyle("R{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("R{$contador}", "");
            }

            if ($list['primer_examen'] != "" && $list['primer_examen'] != "0000-00-00") {
                $sheet->setCellValue("S{$contador}", Date::PHPToExcel($list['primer_examen']));
                $sheet->getStyle("S{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("S{$contador}", "");
            }

            if ($list['segundo_examen'] != "" && $list['segundo_examen'] != "0000-00-00") {
                $sheet->setCellValue("T{$contador}", Date::PHPToExcel($list['segundo_examen']));
                $sheet->getStyle("T{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("T{$contador}", "");
            }

            if ($list['tercer_examen'] != "" && $list['tercer_examen'] != "0000-00-00") {
                $sheet->setCellValue("U{$contador}", Date::PHPToExcel($list['tercer_examen']));
                $sheet->getStyle("U{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("U{$contador}", "");
            }

            if ($list['cuarto_examen'] != "" && $list['cuarto_examen'] != "0000-00-00") {
                $sheet->setCellValue("V{$contador}", Date::PHPToExcel($list['cuarto_examen']));
                $sheet->getStyle("V{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("V{$contador}", "");
            }

            if ($list['quinto_examen'] != "" && $list['quinto_examen'] != "0000-00-00") {
                $sheet->setCellValue("W{$contador}", Date::PHPToExcel($list['quinto_examen']));
                $sheet->getStyle("W{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("W{$contador}", "");
            }

            if ($list['matricula_regular_ini'] != "" && $list['matricula_regular_ini'] != "0000-00-00") {
                $sheet->setCellValue("X{$contador}", Date::PHPToExcel($list['matricula_regular_ini']));
                $sheet->getStyle("X{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("X{$contador}", "");
            }

            if ($list['matricula_regular_fin'] != "" && $list['matricula_regular_fin'] != "0000-00-00") {
                $sheet->setCellValue("Y{$contador}", Date::PHPToExcel($list['matricula_regular_fin']));
                $sheet->getStyle("Y{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("Y{$contador}", "");
            }

            if ($list['matricula_extemporanea_ini'] != "" && $list['matricula_extemporanea_ini'] != "0000-00-00") {
                $sheet->setCellValue("Z{$contador}", Date::PHPToExcel($list['matricula_extemporanea_ini']));
                $sheet->getStyle("Z{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("Z{$contador}", "");
            }

            if ($list['matricula_extemporanea_fin'] != "" && $list['matricula_extemporanea_fin'] != "0000-00-00") {
                $sheet->setCellValue("AA{$contador}", Date::PHPToExcel($list['matricula_extemporanea_fin']));
                $sheet->getStyle("AA{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            } else {
                $sheet->setCellValue("AA{$contador}", "");
            }
            $sheet->setCellValue("AB{$contador}", $list['docs']);
            $sheet->setCellValue("AC{$contador}", $list['s_matriculados']);
            if ($list['matriculados'] == 0) {
                $sheet->setCellValue("AD{$contador}", "0.00");
            } else {
                $sheet->setCellValue("AD{$contador}", number_format((($list['pago_matricula'] * 100) / $list['matriculados']), 2));
            }
            if ($list['matriculados'] == 0) {
                $sheet->setCellValue("AE{$contador}", "0.00");
            } else {
                $sheet->setCellValue("AE{$contador}", number_format((($list['pago_cuota'] * 100) / $list['matriculados']), 2));
            }
            $sheet->setCellValue("AF{$contador}", $list['nom_estado_grupo']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Grupos (Lista)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
   
}