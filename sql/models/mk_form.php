<?php 

/**
* @author Oliver Valiente
*/
class  Mk_form extends CI_Model
{
	//Attr   ....
	private $ref = array(
		3 => "int",
		253 => "varchar",
		252 => "text"
		);

	private $hidden = array(
	"users","api_secret","token","user_id","meta","subscriber","time","password","config","status",'comunity_id'
		);

	private $work=array();
	private $output="";
	private $act;
	private $params;
	private $res=array();

	private $reserved=array(
		"lang"
		);
	private $required = array(
		"title","password","username","content","email"
		);
	private $data_resource;

	//Method   ...

	function __construct()
	{
		parent::__construct();
	}

	/**
	* ------------------------------------------+++
	*	this function working get html source form field
	*
	*@internal
	*@param string table
	*@return string output form
	*
	*/

	public function get($table,$attr,$query="",$load=false,$extra=array())
	{
		//do_action("app_form_page");
		$this->attr = $attr;
		if($query !== ""):
			$query = "/".$query;
		endif;
		$this->act = $query;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM $table");
		$this->work = $query->field_data();
		if($load):
			$s__ = explode(">>", $load);
			$a = $s__[0]; $b = $s__[1];
			$data_edit = $this->db->query("SELECT * FROM $table WHERE $a='$b' ");
			$this->data_resource = $data_edit->result('array');
		endif;
		if(!$load):
			$this->hidden[] = "id";
		endif;
		$this->params = $extra;
		$this->start((bool)$load);
		return "<div class='row'>".$this->output."</div>";
	}

	private function is_required($d)
	{
		if (in_array($d, $this->required)) {
			return "required";
		} else {
			return "";
		}
	}

	//Comment key

	private function get_resource_data($key)
	{
		return $this->data_resource[0][$key]; 
	}

	private function start($flag){
		foreach ($this->work as  $value)
		 {
		 	if($flag AND $value->name == "id"){
		 		$string = "<input ";
			$string .= "name='".$value->name."' ";
			$string .= "type='hidden' ";
			if($flag):
				$string .= "value='".$this->get_resource_data($value->name)."' ";
			endif;
			$string .= " ".">\n";
			$res[] = $string;
		 		continue;
		 	}
		 	
		 	if(in_array($value->name, $this->reserved))
		 	{
		 		$res[] = $this->special_input($value->name);
		 		continue;
		 	}

		 	if(in_array($value->name, $this->hidden))
		 	{
		 		continue;
		 	}

		 	if($value->type === 252){
		 		$string = "\n<div style='margin:3%;width:56%' class='input-group'>\n<label for='id".$value->name."'>"._w_($value->name)."</label>\n
		 		<textarea style='height:205px' class='form-control rounded-none margin-bottom editor_html_post' id='id".$value->name."' "; $textLastContent = "";
				$string .= "name='".$value->name."' ";
				if($flag):
					$textLastContent = $this->get_resource_data($value->name);
			    endif;
				$string .= ">$textLastContent</textarea>\n</div>"; $res[] = $string;
		 		continue;
		 	}

		 	$string = "<div style='margin:3%;width:56%' class='input-group'>\n<label for='id".$value->name."'>"._w_($value->name)."</label>\n<input id='id".$value->name."' ".$this->attr." ";
			$string .= "name='".$value->name."' ";
			$string .= "type='".$this->get_type($value->type,$value->name)."' ";
			if($flag):
				$string .= "value='".$this->get_resource_data($value->name)."' ";
			endif;
			$string .= "placeholder='"._w_('enter_your_value').": "._w_($value->name)."' ".$this->is_required($value->name).">\n</div>";
			$res[] = $string;
		 }

		 $this->output = implode("\n\r", $res);
		 ob_start(); ?>
		 <button onclick="ajaxSysForm($('#form-app').attr('action'),$('#form-app').serialize())" style="margin-left:60%" type="button" id="btn-loading" class="btn btn-primary" data-loading-text="Sending ..."><?php __('send') ?></button>;
		  <?php
		 $d_buttton = ob_get_clean();
		 $this->output = '<form id="form-app" action="'.app_weburl("action").$this->act.'" method="POST">'."\n".$this->output."\n"."$d_buttton\n</form>";
	} 

	private function get_type($type,$name="")
	{
			if($name==="email")
			{
				return "email";
			}

			if ($name==="url") 
			{
				return "url";
			}

			if($name==="color")
			{
				return "color";
			}

			if(array_key_exists($name, $this->hidden))
			{
				return 0;
			}

			if (array_key_exists($type, $this->ref)) 
			{
				 $type = $this->ref[$type];
			}

			switch ($type) {
				case 'varchar':
					return "text";
					break;

				case 'text':
					return @$D;
					break;

				case 'int':
					return "number";
					break;
				
				default:
					# code...
					break;
			}
			
	}  //end function ----////++++++++++++

	/**
	*
	*@special system @internal
	*@return void
	*/

	private function special_input($int)
	{
		//require_once APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."flatplus".DIRECTORY_SEPARATOR."input.php";
		return $inputs[$int];
	}

	//end class ---------------------------++++

}