<?php

/**
*@author Oliver Valiente
*@package WT
*@subpackage Upload File
*@version 1.0
*/

class WT_upload 
{
	/**
	 * File post array
	 *
	 * @var array
	 */

	protected $file = array();

	/**
	 * Data about file
	 *
	 * @var array
	 */

	public $data = array();

	/**
	 * Max. file size
	 *
	 * @var int
	 */

	protected $max_file_size = false;

	/**
	 * Allowed mime types
	 *
	 * @var array
	 */

	protected $allow_mimes = array();

	/**
	 * Max number of the upload's
	 *
	 * @var int
	 */
	protected $number_file = 0;

	/**
	 * Max number of the upload's
	 *
	 * @var int
	 */
	protected $name_file = null;

	/**
	 * Smart callbacks 
	 *
	 * @var array
	 */

	private $callbacks = array();

	/**
	 * Root dir
	 *
	 * @var string
	 */
	protected $root = 'file_storage';

	/**
	 * Root dir
	 *
	 * @var string
	 */

	protected $relative_path;

	/**
	 * Default directory allowed optional
	 */

	protected $default_permissions = 0750;

	/**
	*  @access private
	*  @predeterminate name
	*/

	private $static;

	//This class not use construct
	function __construct(){//not work


	/**
	*
	*   ----------Start Method and Main Work
	*   @param FILE DATA Recived
	*   @return void
	*    
	* This main method carries out the bigger
	* task of the whole class, and your role hatches until
	* the end of the purpose this class
	*
	*/
	}

	public function start($file,$sets=false,$data = false,$stc=false,$app=null)
	{
		//Validate Data Recive
		$this->check_file_array(current($file)) OR $this->upload_die("file_var_is_bad");
		if ($stc) {
			$this->static = $stc;
		}
		if(!is_null($app) AND is_object($app)){
			$this->app = $app;
		}
		//Sets Property
		if($sets !== false):
			!isset($sets['callbacks']) OR $this->callbacks = $sets['callbacks'];
			!isset($sets['root']) OR $this->root = $sets['root'];
			!isset($sets['allow_mimes']) OR $this->allow_mimes = $sets['allow_mimes'];
			!isset($sets['max_file_size']) OR $this->max_file_size = $sets['max_file_size'];
			!isset($sets['default_permissions']) OR $this->default_permissions = $sets['default_permissions'];
			!isset($sets['number_file']) OR $this->number_file = $sets['number_file'];
			!isset($sets['name_file']) OR $this->name_file = $sets['name_file'];
		endif;

		if($data !== false):
			$this->data = $data;
		endif;

		/*if($this->number_file < count($file['name']) && $this->number_file !== 0):
			$this->upload_die("the_number_file_not_acept");
		endif;*/

		//Mode Simple File
		if($sets['mode'] == 'simple'):
			$this->file = current($file);
			$this->validator_task(); return true;
		endif;

		//Support Multi Upload Files
		for ($i=0; $i < count($file['name']); $i++) 
		{ 
			$this->file['name'] = $file['name'][$i];
			$this->file['type'] = $file['type'][$i];
			$this->file['tmp_name'] = $file['tmp_name'][$i];
			$this->file['error'] = $file['error'][$i];
			$this->file['size'] = $file['size'][$i];

			//Simple Debbug; for default is disable
			//var_dump($this->file); echo "<br><br><hr>";

			//Operations to validate and File Save
			$this->validator_task(); 
		}
	}

	/**
	* ---------------Validator Main Task
	*
	* @param none
	* @return void
	*/

	private function validator_task()
	{
		if($this->have_error()):  return false; endif;
		if($this->validate_mime()):  return false; endif;
		if(!$this->validate_size_file()):  return false; endif;
		$this->save_file();
	}

	/**
	* ---------------Save file Process
	*
	* @param none
	* @return void
	* Later of validated accorde the established config, the class begins
	* the process to save the file
	*/

	private function save_file(){
		$this->file['basic_name'] = $this->file['name'];
		$this->file['name'] = $this->encode_file_name($this->file['name']);
		if (!is_null($this->name_file)) {
			$this->relative_path = "";
		}else{
			$this->relative_path = $this->app->session->userdata("username").DIRECTORY_SEPARATOR;
		}
		
		if(!$this->path_valid()): $this->create_path(); endif;
		$this->data_task();
		$status = move_uploaded_file($this->file['tmp_name'], $this->file['full_path']);

		//checks whether upload successful
		if (!$status) {
			throw new Exception('Upload: Can\'t upload file.');
		}else
		    {
		    	if($this->have_action()): $this->do_action();  endif;
		}

	}

	/**
	*
	* ------- Data Task
	* import to save in register app
	* @param none
	* @return void
	*/

	private function data_task(){
		$this->file['app_path'] = $this->root.DIRECTORY_SEPARATOR.$this->relative_path.$this->file['name'];
		$this->file['full_path'] = WEBPATH.$this->file['app_path'];
	}

			/**
			*  //----------  Helper Method  ----------->> 
			*/

	/**
	*   ------Encode File Name
	*@param filename
	*@return string
	*
	*/

	protected function encode_file_name($filename){
		if (!is_null($this->name_file)) {
			return $this->name_file;
		}
		$d = explode('.', $filename);
		$name = $d[0];
		$ext = $d[1];
		if ($this->static) {
			return $this->static.'.'.$ext;
		} else {
			return date("U")."@".$name.'.'.$ext;
		}
	}

	/**
	 * -----Create path to destination
	 *
	 * @param string $dir
	 * @return bool
	 */

	protected function create_path() {
		return mkdir(BASEPATH.$this->root.'/'.$this->relative_path, $this->default_permissions, true);
	}

	/**
	 * ----Checks whether path folder exists
	 *
	 * @return bool
	 */

	protected function path_valid() {
		return is_writable($this->root.'/'.$this->relative_path);
	}

	/**
	 * ----File to get info
	 * @param string key data
	 */

	protected function info($key) {
		return $this->file[$key];
	}

	/**
	* ------- Get Contype Mime
	*@param string type;
	*@return string type
	*/

	protected function get_mime(){
		return $this->$file['type'];
	}

	/**
	 * -------Checks if Files post data is valid
	 *
	 * @return bool
	 */

	protected function check_file_array($file) {
		return isset($file['error']) && !empty($file['name'])
			&& !empty($file['type']) && !empty($file['tmp_name'])
			&& !empty($file['size']);
	}

	/**
	 *  -------Checks if have error
	 *
	 * @return bool
	 */

	protected function have_error() {
		return $this->file['error'] > 0 ;

	}

	/**
	 *  -------Checks if have error
	 *
	 * @return bool
	 */

	protected function validate_mime() {
		if(count($this->allow_mimes) == 0){return false;}
		return in_array($this->$file['type'], $this->allow_mimes);
	}

    /**
    *    ---------Get General Type
    *@example   ^general/mime-file
    *@return string
    */

    protected function general_type(){
    	return array_shift(explode('/', $this->file['type']));
    }

    /**
    *  --------Validate Size File
    *
    * @return bool
    */

    protected function validate_size_file(){
    	if($this->max_file_size == false){return true;}
    	return $this->max_file_size > $this->file['size'];
    }

    //Special Method to Work with callable and hook action with accorde file

    /**
    *   ----Have Action
    *
    *@return void
    */

    private function have_action(){
    	return count($this->callbacks) !== 0;
    }

    /**
    *   ----Do Action
    *
    *@return void
    */

    private function do_action(){
    	foreach ($this->callbacks as $key => $val) {
    		if($key == '*'):
    			$val($this->file,$this->data);
    			continue;
    		endif;

    		if(preg_match('/^type_group/', $key) & end(explode('/',$key )) == $this->general_type()):
    			$val($this->file,$this->data);
    			continue;
    		endif;

    		if(preg_match('/^type_mime/', $key) & end(explode('/',$key )) == end(explode('.', $this->file['basic_name']))):
    			$val($this->file,$this->data);
    		endif;
    	}
    }

    //Upload Die

    private function upload_die($die=""){
    echo "string end to die: ".$die;	exit;
    }

}

?>