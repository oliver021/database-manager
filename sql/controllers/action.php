<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends CI_Controller {
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	private function _initialize(){
		$this->load->library('session');
		if (!$this->session->userdata("logged")) {
			app_exit("error","require_session");
		}
		$this->load->database($this->session->userdata('db'));
	}

	public function setdb(){
		$d = func_get_arg(0);
		$this->_initialize();
		$this->session->set_userdata('db',$d);
		header("Location: ".app_weburl()."app");
	}

	//Avaliable Controller

	public function new_(){
		$this->_initialize();
		$fields = $this->input->post();
		$fields['time'] = date("U");
		$element = func_get_arg(0);
		if(@func_get_arg(1)):
			app_error();
		endif; 
		//Protocol Secure database
		$d=$this->db->query("SELECT * FROM ".app_prefix($element)); 
		$allows_field = $d->list_fields();
		$allow = array_values($allows_field);
			foreach ($fields as $name => $field) {
				if (!in_array($name, $allow)) {
					unset($fields[$name]);
				}	
			}
		 $this->db->insert(app_prefix($element),$fields); 
		 header("Content-type: application/json");
		 echo json_encode(array("type"=>"success","msg"=>"You has create a new ".$element));
	}

	public function edit(){
		$element = func_get_arg(0); 
		if(@func_get_arg(1)):
			app_error();
		endif;
		$this->load->library('session');
		$this->load->database($this->session->userdata('db')); 
		$string_of_query = $this->db->update_string(app_prefix($element),$this->input->post(),array("id" => $this->input->post("id"))); 
		$this->db->query($string_of_query);
		if ($element == "user") {
			//$this->_update_session();
			 //header("Content-type: application/json");
			// echo json_encode(array("type"=>"success","msg"=>"You has update ".$element));
		}
		    header("Content-type: application/json");
			echo json_encode(array("type"=>"success","msg"=>"You has update ".$element));   
	}

	public function delete(){
		
	}

	public function apiRequest(){

	}

	public function logged()
		{
			$this->load->library('session');
			$config = include(APPPATH."config/session.php");
			if($config['mode'] === 'basic'){
				$session = array('logged' => true);
				$this->session->set_userdata($session);
				header("Location: ".app_weburl('app'));
			}
			echo json_encode(array('code'=>"login_success"));
		}
	
}
