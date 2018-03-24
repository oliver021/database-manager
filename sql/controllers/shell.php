<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shell extends CI_Controller {	 
	
	public function index()
	{
	require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
				$this->load->library('session');
				if (!$this->session->userdata("logged")) {
					app_exit("error","require_session");
				}
                    $this->load->database($this->session->userdata('db'));//
                    $load = $this->db->query($this->input->post("q"));
                    if ( !stristr($this->input->post("q"), "SELECT") && !stristr($this->input->post("q"), "show") && !stristr($this->input->post("q"), "describe") ) {
                    	echo "<h3>Este tipo de Consulta no devuelve Datos</h3>";
                    	exit;
                    } else {
                    	$r = explode(" ", $this->input->post("q"));
                    	$r = preg_replace("/^".app_prefix("")."/", "", @$r[3]);
                    }
                    
                    $data_user = $load->result("array");
                    if (is_null($data_user)) {
                        $data_use[0]=array();
                    }
                    _w_("result");
                    $msg_ = _w_("La consultada realizada no delvolvió resultado");
                    echo admin_mk_table($r,_w_("manager_system_data"),$data_user,@array_keys(@$data_user[0]),$msg_) ;
                    $this->db->close(); 
	}
}
