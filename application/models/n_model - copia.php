<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class n_model extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->library('session');	
		}

		 public function login($usuario,$pass){
			$sql = "select us.CODUSER, rtrim(ltrim(vlpt.dni)) as DNI, 
					vlpt.NOMB_CORT_PER as DES_USUARIO,
					u.clave AS CLAVE,
					vlpt.HR_INGRESO AS INGRESO,
					vlpt.HR_SALIDA AS SALIDA,
					vlpt.UBIC_FISI_TDE,
					vlpt.ESTA_TRAB_PER,
					vlpt.TIPO_PLAN_TPL,
					vlpt.NRO_CONTRATO,
					vlpt.DEPE_REMU_PER,
					ISNULL(vlpt.CARGO,'NO DEFINIDO') AS CARGO,
					u.FECHAINGRESO,
					u.CORREO,
					t.codi_sistema,
					u.FECHAACTUALIZADO,
					ps.DESC_SUBDEPEN as UNIDAD,
					ps.CODI_SUBDEPEN,
					ps.CODI_DEPE_TDE,
					u.IPACTUALIZADO,
					us.Tipo_Acceso as ROLASISTENCIA,
					t.FIRMA_DIGITAL as FIRMA,
					case when t.APRUEBA=1 then 'FIRMA' else 'NO FIRMA' end as DESCRIPCION,
					t.DescAcceso as ROL,
					u.CODI_EMPL_PER,
					TP.DESC_DEPE_TDE AS DEPENDENCIA,T.APRUEBA
					from Usuario_Sistema us
					inner join tipoacceso t on t.codi_sistema=us.Codi_Sistema and t.Tipo_acceso=us.Tipo_Acceso
					inner join USUARIOS u on u.CODUSER=us.coduser
					INNER JOIN v_lista_personal_total vlpt on u.CODI_EMPL_PER = vlpt.CODI_EMPL_PER
					inner join TDEPENDENCIAS tp on tp.CODI_DEPE_TDE=us.AreaAcceso
					inner join PAPELETA_SUBDEPEN ps on ps.CODI_DEPE_TDE=us.AreaAcceso and ps.CODI_SUBDEPEN=us.codi_subdepen
					where t.codi_sistema='0030' and us.CODUSER='".$usuario."' and u.clave='".$pass."' and vlpt.UBIC_FISI_TDE is not null and vlpt.ESTA_TRAB_PER = 1 ";
			$query = $this->db->query($sql)->result_array();
			if(count($query) > 0){
			}
			return $query;
			
		}

			
	}
?>
