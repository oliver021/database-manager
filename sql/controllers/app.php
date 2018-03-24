<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	
	public function index()
	{
		$this->_initialize();
		$data['menu'] = $this->_menu();
		$this->_layout_default($data);
	}

	public function dashboard(){
		$this->load->dbutil();
		$data['numberDB'] = count($this->dbutil->list_databases());
		$this->load->view("admin/".config_item('tpl_name')."/dashboard",$data);
	}

	private function _initialize()
	{
		$this->load->library("session");
		if(!$this->session->userdata("logged")){
			header("Location: ".app_weburl()."login");
		}
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."function.php";
	}

	private function _layout_default($data)
	{
		$this->load->dbutil();
		$data['dbs'] = $this->dbutil->list_databases();
		$this->load->view("admin/".config_item('tpl_name')."/head");
		$dashboard['numberDB'] = count($data['dbs']);
		$data['content'] = $this->_page("dashboard",$dashboard);
		$this->load->view("admin/".config_item('tpl_name')."/main",$data);
		$this->load->view("admin/".config_item('tpl_name')."/footer");
	}

	public function daleteDatabase(){
		$this->load->library("session");
		if(!$this->session->userdata("logged")){
			header("Location: ".app_weburl()."login");
		}

		$this->load->database($this->session->userdata('db'));
		$this->db->query('DROP DATABASE `'.$this->input->get('item').'`'); echo $this->input->get('item');
		echo "you has delete database".$this->input->get('item');
	}

	public function daleteTable(){
		$this->load->library("session");
		if(!$this->session->userdata("logged")){
			header("Location: ".app_weburl()."login");
		}

		$this->load->database($this->session->userdata('db'));
		$this->db->query('DROP TABLE `'.$this->input->get('item').'`'); echo $this->input->get('item');
		echo "you has delete database".$this->input->get('item');
	}

	/**
	 * system ajax request function to admin work
	 *
	 * @return void
	 * @see ajax network 
	 **/

	public function ajaxApi()
	{
		$this->_initialize();
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
		if($this->input->get('init') == "1"):
			switch ($this->input->get("page")) {
				case 'update':
					$this->load->database($this->session->userdata('db'));
					$param = explode("-", $this->input->get("item"));
					$this->load->model("mk_form");
					echo $this->mk_form->get(app_prefix($param[0]),"class='form-control'","edit/".$param[0],"id>>".$param[1]);
					echo "<br>";
					break;

				case 'create':
					$this->load->database($this->session->userdata('db'));
					$param = explode("-", $this->input->get("item"));
					//$data_object = $this->db->query("SELECT * FROM ".app_prefix($param[0])." WHERE id='".$param[1]."'");
					//$data=$data_object->result("array");
					$this->load->model("mk_form");
					echo $this->mk_form->get(app_prefix($param[0]),"class='form-control'","new_/".$param[0],false);
					echo "<br>";
					break;

				case 'delete':
					$this->load->database($this->session->userdata('db'));
					$param = explode("-", $this->input->get("item"));
					$this->db->query("DELETE FROM ".app_prefix($param[0])." WHERE id='".$param[1]."'");
		 			 echo "You has delete a ".$param[0];
					break;
				
				default:
					# code...
					break;
			}
			return 1;
		endif;
		$target = @func_get_arg(0);
		if (!$target) {
			echo "not page";
		}
		$param['app'] = $this;
		$this->load->view("admin/".config_item('tpl_name')."/$target",$param);
	}

	public function database(){
		$this->_initialize();
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
		$data['name_table'] = @func_get_arg(0); $data['app'] = $this;
		if ($data['name_table']) {
			$output['content']=$this->load->view("admin/".config_item('tpl_name')."/database",$data,true);
		} else {
			$output['content']=$this->load->view("admin/".config_item('tpl_name')."/databases",$data,true);
		}
		$this->_initialize();
		$data['content'] = $this->_page("dashboard");
		$this->load->view("admin/".config_item('tpl_name')."/head");
		
		$output['menu'] = $this->_menu();
		$this->load->view("admin/".config_item('tpl_name')."/main",$output);
		$this->load->view("admin/".config_item('tpl_name')."/footer");
	}

	public function databaseAjax(){
		$this->_initialize();
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
		$data['name_table'] = @func_get_arg(0); $data['app'] = $this;
		$this->load->view("admin/".config_item('tpl_name')."/database",$data);
		
	}

	public function sql_shell(){
		$this->_initialize();
		//var_dump($this->session->userdata('db'));
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
		$data['name_table'] = @func_get_arg(0); $data['app'] = $this;
		$this->load->view("admin/".config_item('tpl_name')."/shell",$data);
		
	}

	public function databaseAjaxAll(){
		$this->_initialize();
		$this->load->database($this->session->userdata('db'));
		//$this->db->call_function('select_db',$this->db->conn_id, "wb");
		require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item('tpl_name').DIRECTORY_SEPARATOR."layout.php";
		 $data['app'] = $this;
		 echo $this->load->view("admin/".config_item('tpl_name')."/databases",$data,true);
		
	}

	private function _page($target,$data=null)
	{
		$this->_initialize();
		return $this->load->view("admin/".config_item('tpl_name')."/$target",$data,true);
	}

	private function _menu(){

      $data_menu[] =  "dashboard>>dashboard>>app/dashboard";
      //if($this->session->userdata('status') == "3"):
      $data_menu[] =  "database>>server>>app/databaseAjaxAll";
  	  $data_menu[] =  "sql_shell>>server>>app/sql_shell";
     // endif;
    ?>
    <?php ob_start();
    while($d = array_shift($data_menu)): 
    $d = explode(">>", $d);
    $icon = $d[1]; $dl = $d[0];
    	if(isset($d[2])){
    ?>
             <li onclick="ajaxSysRequest('<?php echo app_weburl().$d[2]; ?>')" class="">
             <?php   }else{ ?>
             <li onclick="ajaxSysRequest('<?php echo app_weburl()."admin/".config_item('tpl_name')."/ajaxApi/".$dl; ?>')" class="">
             <?php } ?>
                    <a onclick="return false">
                        <i class="ti-<?php echo $icon ?>"></i>
                        <p><?php __($dl) ?></p>
                    </a>
                </li>
    <?php endwhile; return ob_get_clean();

	}
}
