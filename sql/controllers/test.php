<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {	 
	
	public function _remap()
	{
		$page = func_get_arg(0);
		$this->load->model('ke');
		$this->ke->set_stream($this->ke->prepare(APPPATH."..".DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR.$page));
		$data[] = array("hola" => "Hola Maikel","type" => "doc");
		//$data[] = array("hola" => "Hola Mundo","type" => "video");
		$source = "<h1>{hola}</h1><br><p>{type}</p>";
		//var_dump($this->ke->link_loop($data,$source));
		$this->ke->start();
	}
}
