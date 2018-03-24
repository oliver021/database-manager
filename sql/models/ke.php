<?php

/**
*@author Oliver Valiente
*@package WT
*@subpackage Upload File
*@version 1.0
*/

class Ke extends CI_Model 
{
	/**
	 * File post array
	 *
	 * @var array
	 */

	protected $file = array();

	/**
	 * File post array
	 *
	 * @var array
	 */

	protected $_VARS = array();

	/**
	 * Data about file
	 *
	 * @var array
	 */

	protected $data = array();

	/**
	 * Max. file size
	 *
	 * @var int
	 */

	protected $allow_mimes = array();

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
	 * Default directory allowed optional
	 */

	protected $default_permissions = 0750;

	/**
	*  @access private
	*  @predeterminate name and main vars
	*/

	private $static,$taget,$stream,$work;

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

	public function prepare($file,$type=null){
		if($type == "data"){

            $stream = fopen('php://temp', 'r+');
            if ($file !== '') {
                fwrite($stream, $file);
                fseek($stream, 0);
            }
            return $stream;
		}
		$this->target = $file;
		if (file_exists($file) AND is_readable($file)) {
			return fopen($file, "r");
		} else {
			return false;
		}
	}

	public function start()
	{
		$this->compile();
		var_dump($this->work);
		
	}

	/**
	*  Handle attr methods
	*-----------------------------------------------------------------+++
	*
	*@param data
	*@internal false
	*@throws Execption Engine
	*@return var
	*
	*/

	public function set_stream($data){
		$this->stream = $data;
	}

	public function get_stream(){
		return $this->stream;
	}

	/**
	* ---------------Tool file Process
	*
	* @param none
	* @return void
	* Later of validated accorde the established config, the class begins
	* the process to save the file
	*/

	private function compile(){
		while($line = fgets($this->stream)): 
		if(strstr($line, "<compile")):
			//if(preg_match("/^<compile/", $line)): echo "string";
				$serial = str_replace("<compile", null, $line);
			    $serial = explode(">", $serial);
			    $serial = $this->queryStringFormat($serial[0]);

				$source = $this->get_source("</compile>");
				$this->work[] = array('property'=>$serial,'source'=>$source);
			//endif;
		endif;
		endwhile;

	}

	private function get_source($tag){
		$line="";
		while(!strstr($line, $tag)){
			$line .= fgets($this->stream);
		}
		$line =  str_replace($tag, "", $line);
		return $line;
	}

	private function queryStringFormat($str)
	{
		$str = trim($str);
		if(!strstr($str, ";")){
			$d=explode(":", $str);
			$r[@$d[0]]=@$d[1];
		}else{
			$ds = explode(";",$str);
   		 while ($a12 = array_shift($ds))
     		{
      			$a22 = explode(":", $a12);
      			$r[@$a22[0]] =  @$a22[1];
     		}
		}
		return $r;
	} 

	/**
	*  Handle Work Process
	*--------------------------------------------------------------------------------//?
	*
	*@param reserved
	*@internal true
	*@throws Execption Fatal
	*@return diferent
	*
	*/

	//parser var to work

	static function parser_var($index)
	{ 
     if(strstr($index, '@++'))
         {
       		 $index = str_replace('@++'.$key, $value, $index);
         }
     
     //is_array(parent::$_VARS) or parent::$_VARS = array();

         if(strstr($index, '@'))
         {
         foreach (self::$_VARS as $key => $value)
         {
            $index = str_replace('@'.$key, $value, $index);
         }}

       echo $index;
	}

	/*static*/ function render_var($data,$source,$options=array())
	{
		for ($i=0; $i < count($data); $i++) {
			$source = str_replace("{".key($data)."}", current($data), $source);
			next($data);
		}
		return $source;
	}

	/*static*/ function link_loop($data,$source,$options=array(),$result=""){
		if(!is_string($result)):
			$result="";
		endif;
		while($current = array_shift($data)):
			$result .= "\n".$this->render_var($current,$source,$options);
		endwhile;
		return $result;
	}

	final private function query_data($type,$params){
		switch ($type) {
			case 'directory':
				$item = scandir($params['path']);
				unset($item[0],$item[1]);

				if(isset($params['not']) and is_array($params['not'])){
				  for($i=0;$i < count($item);$i++):
					foreach ($params['not'] as  $v):
						if (preg_match("/\.".$v."$/", current($item))) {
							# code...
						}
					endforeach;
					  next($item);
					    endfor;
				}
				break;

			case 'db':
				if (isset($params['query'])) {
					if(is_array($params['query'])){
						for($i=0;$i < count($params['query']);$i++):
							$q = $this->db->query(current($params['query']));
							next($params['query']);
						endfor;
					}else{
					$item = $this->db->query($params['query']);
					$item = $item->result("array");
					}
					
				} else {
					# code...
				}
				
				break;

			case 'manual':
				//$item
				break;
			
			default:
				# code...
				break;
		}
		return $item;
	}

}  //end class

	