<?php //My Helper to App

 //System vars is util

function sys_var($name,$data=null)
{
  static $vars;
  if (empty($vars)) {
    $vars=array();
  }
  if (is_null($data)) { 
    if (!array_key_exists($name, $vars)) {
    return false;
  }
    return $vars[$name];
  }else{
    $vars[$name] = $data;
  }
}

sys_var("language","es");

//-------------------++++++
//Check values

  function is_admin(){
    return app_is("admin");
  }

  function is_blog(){
    return app_is("blog");
  }

  function is_portal(){
    return app_is("portal");
  }

  //master site

  function app_is($type_check){
    switch ($type_check) {
      case 'admin':
        $d = $_SERVER["REQUEST_URI"];
        $s = explode("/", $d);
        return in_array("admin", $s) AND in_array("blog", $s) AND in_array("page", $s);
        break;

        case 'blog':
        $d = $_SERVER["REQUEST_URI"];
        $s = explode("/", $d);
        return in_array("blog", $s);
        break;
      
      default:
        # code...
        break;
    }
  }

//++++++++++++++++---------/

// this data is import to system

function app_exit($type,$msg="",$code=false){
switch ($type) {
  case 'error':
   echo $msg; 
    break;

  case 'success':
    
    break;

  case 'coming_soon':
    header("Location: ".app_weburl()."error/coming_soon?msg=".$msg);
    break;

  case 'dump':
    # code...
    break;

  case 'redirect':
    header("Location: ".$msg);
    break;

  case 'login':
    header("Location: ".app_weburl()."login?msg=".$msg);
    break;

  case 'register':
    header("Location: ".app_weburl()."login/register?msg=".$msg);
    break;
  
  default:
    break;  }

  exit;
} 

function app_script($a="",$b="")
{
  static $script;
  if ($a == "add") {
    $script[] = $b;
  } elseif($a == "run") {
    if(is_null($script)){
      return false;
    }
    echo implode("\n", $script);
  }
}

function app_custom_js($a="ready",$b="")
{
  static $js;
  if (empty($js)) {
    $js="";} 
  if ($a=="add") {
    $js .= $b;
  } elseif($a=="ready") 
  {
    echo '<script type="text/javascript">'."\n".$js."\n".'</script>';
  }
}

if(!function_exists("admin_model")):
function admin_model()
{
    return config_item("tpl_admin");
}
endif;

function app_plugin_config($plugin){
  return parse_ini_file(WEBPATH."plugins".DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR."config.ini");
}

function admin_load($path){
  ob_start();
  include APPPATH."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR.config_item("tpl_name").DIRECTORY_SEPARATOR.$path.".php";
  return ob_get_clean();
}

//Index directory array

function app_dir($selected)
{
  $pathdir = BASEPATH."../web/".$selected;
  $d = scandir($pathdir);
  unset($d[0],$d[1]);
  return $d;
}

function app_style($a="",$b="")
{
  static $style;
  if ($a == "add") {
    $style[] = $b;
  } elseif($a == "run") {
     if(is_null($style)){
      return false;
    }
    echo implode("\n", $style);
  }
  
}

function app_webpath($path="")
{
	
	return BASE_URL."web/sqlAssets/".$path;
}

function app_weburl($d=""){
	return BASE_URL."index.php/$d";
}

function app_prefix($input)
{
  return $input;
}

function app_error(){
  echo "Error!!";
}

//--------------------------------------------------------------->>>?/ database tool

function app_config_db($obj,$name,$query="")
{
   $obj->db->query("SELECT config FROM ".app_prefix($name)." WHERE ".$query);
   $data = $data->result("array");
   return $data[0];
}

function app_meta_db($obj,$name,$query="")
{
  $data=$obj->db->query("SELECT meta FROM ".app_prefix($name)." WHERE ".$query);
  $data = $data->result("array");
  return $data[0];
}

function app_get_members($query)
{
  $obj->db->query("SELECT member FROM ".app_prefix("comunity")." WHERE id='".$query."'");
   $data = $data->result("array");
  return $data[0];
}

function app_get_supcritors($query)
{
  $obj->db->query("SELECT subscriber FROM ".app_prefix("comunity")." WHERE id='".$query."'");
   $data = $data->result("array");
  return $data[0];
}

//-----------------------------------------------------------------------/|

/**
* WT MK HEADER ADMIN MENU TO UTIL TO DEVELOPER MENU
*@param array $params menu
*@replace if set in theme selected
*@internal
*@return void
*
*/

if( !function_exists("app_mkHeader") ):
function app_mkHeader($menu)
{
	ob_start(); $i = 0;
	while($data = array_shift($menu)):
    $i++;
		if (is_array($data)) {
							?>
					<li class="hasSubmenu">
					<a href="#" data-target="#menu-style<?php echo $i; ?>" data-toggle="collapse"><i class="icon-compose"></i><span>
						<?php echo __($data['title']); ?>	
					</span></a>

					<ul class="collapse" id="menu-style<?php echo $i; ?>">
						<?php while($a = array_shift($data["item"])): 
              if(strstr($a, ">>")){
              $d = explode(">>", $a);
                $a = $d[0];
                $link = $d[1];
                }else{
                  $link = $a;
                  }
            ?>
						<li><a href="<?php echo app_weburl()."admin/".$link ?>">
							<?php echo __($a); ?>
						</a></li>
						<?php endwhile; ?>
					</ul>
				</li>
							<?php
		} else {
			if(strstr($data, ">>")){
      $d = explode(">>", $data);
      $data = $d[0];
      $link = $d[1];
      }else{
        $link = $data;
        } ?>

					<li><a href="<?php echo app_weburl()."admin/".$link ?>"><i class=" icon-projector-screen-line"></i>
					<span>
					<?php echo __($data); ?></span></a></li>
			<?php
		}
				
	endwhile;
	return ob_get_clean();
}
endif;

//STRING HELPER SYSTEM ||||||***************************//>

	/**
 *@subpackage String
 *
 * <-----------  language Support ---------------->
 *<-----------  String API ---------------->
 * <-----------  Text Support ---------------->
 *
 */

 function app__lang($words)
{
  static $language;
  if (empty($language)) { 
    require_once APPPATH."language".DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR.sys_var("language").".php";
  }
  if (@array_key_exists($words, $language) ) { 
    return $language[$words];
  }else{ 
    return false;
  }
}

function app_words($str, $op = false)
{
  $w = app__lang($str);
  if ($w == false) {
    $w = $str;
  }else{
    if($op): return $w; endif;
  }
  $w = str_replace('_', ' ', $w);

    switch ($op) {
      case '-':
        return $w;
        break;

      case '+':
          return ucwords($w);
        break;
      
      default:
        return ucfirst($w);
        break;
    }
}

 /**
 *
 *function Alias of the words
 *@param self func
 *@alias humanize function
 *@return self data to words func
 *
 */

   function __($str, $op = false)
  {
    echo app_words($str, $op);
  }

   function _W_($str, $op = false)
  {
    return app_words($str, $op);
  }

  /**
  *@param  string  $str  Input string
  *@return string  
  */

  function str_machine($str)
  {
    return preg_replace('/[\s]+/', '_', trim(@MB_ENABLED ? mb_strtolower($str) : strtolower($str)));
  }

  /**
  *
  *   ----------  import func: --> Randow String  ---------------
  * @param int
  * @return string
  *
  */

  function str_rand($int)
  {
    return str_rot13(str_shuffle(md5(mcrypt_create_iv($int))));
  }

  //Add Output and More

  global $message__ad;
  $message__ad=array();

  function app_admin_message__flush(){
    global $message__ad;
    while ($selected = array_shift($message__ad)) {
      echo $selected;
    }

  }

  function add_admin_message($msg,$name="default",$word="notice"){
    global $message__ad;
    $data['type'] = _w_($name);
    $data['message'] = $msg;
    $data['word'] = $word;
    $message__ad[] = al_alert($data);
  }

//Special API to import 

    function app_create_alert($obj,$type,$name,$msg="")
    {
      $types = array("notice"=>1,"danger"=>2,'report'=>3,"secure"=>2,"sys"=>4);
      $input['type'] = $types[$type];
      $input['title'] = $name;
      if (preg_match('/_key$/', $msg)) {
       $input['content'] = _w_($msg);
      } else {
       $input["content"] = $msg;
      }
      $msg .= " ".$obj->session->userdata("username");
      $obj->db->insert(app_prefix("alert"),$input);
    }

    //database schema system

    function schema_action($app,$query){
      $app->db->query($query);
    }

//Output script 

    function app_ajax_sysRequest_js(){
      ?>
      function ajaxSysRequest(param){
            $.get(param,param,function(res){
              $('#app_main_content').html(res);
            });
          } //end function ajax request

       function ajaxSysDelete(param,elementSelected){
          control = confirm("<?php echo __('you_are_confirm_delete') ?>");
          if (control) {
            $.get("<?php echo app_weburl().'app/ajaxApi'; ?>?init=1&page=delete&item="+param,'app=1',function(res){
                 ajaxMessage(res,'danger');
                 $('#'+elementSelected).hide(); //alert('#'+elementSelected);
              });
          } else {}
           
          } //end function ajax delete

          function trashDatabase(elementSelected){
          control = confirm("<?php echo __('you_are_confirm_delete') ?>");
          if (control) {
            $.get("<?php echo app_weburl().'app/daleteTable'; ?>?init=1&page=delete&item="+elementSelected,'app=1',function(res){
                 ajaxMessage(res,'danger');
                 $('#dbb'+elementSelected).hide(); //alert('#'+elementSelected);
              });
          } else {}
           
          } //end function ajax delete

       function ajaxSysForm(action,requestData){
            $.post(action,requestData,function(res){ 
            ajaxMessage(res.msg,res.type);
            });
          } //end function ajax form

      function ajaxMessage(msg,dataTypem){
        $.notify({
                icon: 'ti-server',
                message: msg

            },{
                type: dataTypem,
                timer: 4000
            });
      }  //end function ajax message

    <?php
    }