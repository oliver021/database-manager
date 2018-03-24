<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		$this->load->library('session');
		$config = include(APPPATH."config/session.php"); 
			if($config['mode'] === 'basic'){ 
				$session = array('logged' => true);
				$this->session->set_userdata($session);
				header("Location: ".app_weburl('app'));
			}
		$this->_check_session();
		$data_login_page = [];
		if($this->input->get("msg")):
		$data_login_page['message'] = $this->_message($this->input->get("msg"));
		endif;
		
		$this->load->view('login',$data_login_page);
	}

	public function _register()
	{
		$this->load->database(); $table_assets = app_prefix("app_login_option");
		$data=$this->db->query("SELECT * FROM $table_assets WHERE id='0'");
		$data_login_page = $data->row();

		if (!$data_login_page->allow_register) {
			echo "not_possible";
		} else {
			if($this->input->get("msg")):
				$data_login_page->message = _w_($this->input->get("msg"));
			endif;
			$this->load->view('register',$data_login_page);
		}
	}

	public function logout(){
		$this->load->library('session');
		$this->session->sess_destroy();
		header("Location: ".app_weburl()."login");
	}

	//Private Method of the login --------------------------------------------------?////|
	private static function _message($key){
		$data['user_baner'] = _w_("this_user_is_baner");
		$data['user_unknow'] = _w_("this_user_is_unknow");
		$data['password_wrong'] = _w_("password_wrong");
		$data['session_end'] = _w_('session_end');

		//Check
		if (!array_key_exists($key, $data)) {
			return _w_("code_bad_set");
		}

		//Data output in function
		return $data[$key];
	}

	private function _check_session()
	{
		$this->load->library('session');
		if($this->session->userdata("logged")){
			header("Location: ".app_weburl()."admin");
			app_exit("error","not_autorize//action_required_permision");
		}
	}
}
