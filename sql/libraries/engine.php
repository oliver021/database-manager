<?php 

/**
* Engine Support for Compilation Controller
* --------------------------------------------/+
*@author Oliver Valiente Oliva
*@package Builder Back-end
*@subpackage Engine Compiler
*@see  www.builderbackend.com/engine-compilation-docs
*@link www.builderbackend.com/engine-compilation
*@internal true
*@throws Engine Exeption's
*------------------------------------------------>
*
*/

final class 
{
	/**
	 * the variant class variable
	 *
	 * @access private
	 * @internal
	 * @var to use class internal
	 **/

	private $data,$db,$session,$property,$asset,$input;

	/**
	 * system dispacther
	 *
	 * @var boolean
	 **/
	private $flag;

	/**
	 * system exepction
	 *
	 * @var object
	 **/
	private $exeption;

	/**
	 * system object
	 *
	 * @var object
	 **/
	private $system;
	
	function __construct($data,$property)
	{
		//$this->execption = new Exeption_Engine();
		//$this->system = new System();
		if (!is_array($data)) {
			$data = unserialize($data);
		}

		if (!is_array($property)) {
			$property = unserialize($property);
		}

		if (!is_array($data) or !is_array($property)) {
			$this->execption("bad_input",1);
		}

		$this->data = $data;
		$this->property = $property;
	}

	//sets -------------------------------------------------------------|

	function set_db($db){
		if (is_object($db)) {
			$this->db = $db;
		} else {
			return false;
		}
	}

	function set_session($s){
		if (is_object($s)) {
			$this->session = $s;
		} else {
			return false;
		}
	}

	function set_input($d){
		if (is_object($d)) {
			$this->input = $d;
		} else {
			return false;
		}
	}

	/**
	 *
	 * ---------------------------------------------------// System Start to Compilation ...
	 * method to start
	 *
	 * @internal none
	 * @param none
	 * @return bool
	 * @access public 
	 **/
	public final function start()
	{
		$l = count($this->data);
		for ($i=0; $i < $l; $i++) { 
			$current_action = explode("/", current($this->data));
				$action_token = array_shift($current_action);
				$this->action_execute($action_token,$current_action);
			next($this->data);
		}
	}

	/**
	 *
	 * ---------------------------------------------------// System Engine
	 * method to execute action
	 *
	 * @internal none
	 * @param none
	 * @return bool
	 * @access private 
	 **/

	private function action_execute($action_token,$params){
		switch ($action_token) {
			case 'sql_query':
				# code...
				break;

			case 'sql_string':
				# code...
				break;

			case 'create_var':
				# code...
				break;

			case 'create_const':
				# code...
				break;

			case 'call_service':
				# code...
				break;

			case 'call_function':
				# code...
				break;

			case 'load_data':
				# code...
				break;

			case 'save_data':
				# code...
				break;

			case 'create_hook':
				# code...
				break;

			case 'create_network':
				# code...
				break;

			case 'storage':
				# code...
				break;

			case 'create_loop':
				# code...
				break;

			case 'factorize':
				# code...
				break;

			case 'create_handle':
				# code...
				break;
			
			default:
				$this->execption("action_unregister",2);
				break;
		}
	} 

	//-------------------------------------------------------------------------------------********+++++?|\
}