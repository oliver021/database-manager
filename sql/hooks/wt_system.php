<?php  //WT SYSTEM

//API HOOK ENABLE AND INCLUDE SOURCE

global $runs;
global $__filter;
$__filter = array();
$runs = array();  

function add_action($trigger, $v)
{ global $runs;
  if(!is_array(@$runs[$trigger]))
   {$runs[$trigger] = array();}
  array_push($runs[$trigger], $v);
}

function do_action($trigger){
global $runs;
   if(isset($runs[$trigger])){
    foreach($runs[$trigger] as $v)
   {
   if (is_callable($v))
    {
      call_user_func($v);
   }else{trigger_error("Not source of function in ".__FILE__); }
     }}
}

function apply_filter($event,$data)
{
  global $__filter; $arg = array();
  if (!isset($__filter[$event])) 
  {
    return $data;
  }

  //Process Filter
  foreach ($__filter[$event] as $v)
   {
    if (!isset($v['arg']))
     {
      $val = @call_user_func_array($v['func'], array($data));
     }else{
      array_unshift($arg, $data);
      array_push($arg, $v['arg']);
      $val = call_user_func_array($v['func'], $arg);
     }
   }
   return $val;
}

/**
*
* @function  --------- Add Filter ----------
* @return void
*
*/

  function add_filter($event,$callable,$data = false)
{
  global $__filter; 
  $i = count($__filter) + 1;
  $__filter[$event][$i]['func'] = $callable;
  if($data !== false){ $__filter[$event][$i]['arg'] = $data;}
}

  //Alias of the add_filter

  function create_filter($event, $data){add_filter($event, $data);}

  /**
  *  If is developer, this function is import @return void
  */

 function filter_status()
 {
  global $__filter; var_dump($__filter);
 }


//end API Hook            ------   -------------------------------------------------end|

//cmd hook and  default task to API native App -------------------------------------|||?

add_action("message_admin","wt_admin_message__flush");
add_action("wt_script_footer","wt_custom_js");


//end cmd hook -----------------------------  -------------------------------------------/>

global $wt_data_module;
$wt_data_module = array("forum","social","messager","post","portafolio","comunity");

function wt_check_module($name)
{
	global $wt_data_module;
	return in_array($name, $wt_data_module);
}

function wt_unset_module($name){
	global $wt_data_module;
	unset($wt_data_module[array_search($name, $wt_data_module)]);
}

function wt_register_module($name){
	global $wt_data_module;
	array_unshift($wt_data_module, $name);
}

/**
*   --Module Service Get Object--
*
*@param name module string
* -----------------------------/?
*@internal
*@throws Module Exeption
*@return obj module or false bool
*
*/

function wt_service_module($name,$module_parent=false,$app=null){
	global $wt_data_module;
  if($module_parent):
	require_once APPPATH."models".DIRECTORY_SEPARATOR."wt_module.php";
  endif;
  $name = "Module_".$name;
  //Dynamic and app module
  if (is_object($app)) {
    $app->load->model("module/".$name); 
    return $app->$name;
  }
  //Static Module
	if (file_exists($d=APPPATH."models".DIRECTORY_SEPARATOR."module".DIRECTORY_SEPARATOR.$name.".php")) {
		include_once $d;
	} else {
		if (file_exists($d = WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR."module".DIRECTORY_SEPARATOR.$name.".php")):
			include_once $d;
		endif;
	}
  //class execute ...
	if (class_exists($name)) {
		return new $name();
	} else {
		return false;
	}
	
}


//end module API system

function wt_init()
 {
  //Define var and util coonst   ////---------------------------/>
 	$path_var = DIRECTORY_SEPARATOR;
 	define('WEBPATH', APPPATH."..".$path_var."web".$path_var);
 	include_once APPPATH."..".$path_var."web".$path_var."themes".$path_var.config_item("theme").$path_var."system.php";
  if (file_exists($dpa = APPPATH."..".$path_var."web".$path_var."themes".$path_var.config_item("theme").$path_var."function.php")) {
   include_once $dpa;
  }
  if (file_exists($dp1 = APPPATH."models".$path_var."admin".$path_var.config_item("tpl_admin").$path_var."function.php")) {
   include_once $dp1;
  }

  if (file_exists($dp2 = APPPATH."models".$path_var."admin".$path_var.config_item("tpl_admin").$path_var."system.php")) {
   include_once $dp2;
  }
  //main Helpers Included
    require_once APPPATH."helpers".$path_var."webtool_helper.php";

  //Language set for default
  sys_var("language",config_item("lang"));

  //Plugins work
  $data_plugins = explode(",", file_get_contents(APPPATH."config".$path_var."plugins.txt"));
  while($p = array_shift($data_plugins)):
    include_once WEBPATH."plugins".$path_var.$p.$path_var."init.php";
  endwhile;

  //conditional system params
	if (is_admin())
	 {
		# code...
	 }

	if(is_blog())
	{

	}

  //Agent Process
  sys_var("is_mobile",false);
 }//end wt_init system 

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

/**
*
*@param string $launch
*@internal
*@return void
*/

function wt_launch_theme($launch){
 require_once APPPATH."helpers".DIRECTORY_SEPARATOR."theme_helper.php";
  switch ($launch) {
    case 'blog':
      sys_var("launch","feed");
      require_once APPPATH."models".DIRECTORY_SEPARATOR."wt_content.php";
      $query = new WT_Content(array());
      require_once WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$query->target.".php";
      break;

    case 'item':
      sys_var("launch","single");
      require_once APPPATH."models".DIRECTORY_SEPARATOR."wt_content.php";
      $query = new WT_Content(array());
      require_once WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$query->target.".php";
      break;

     case 'category':
      sys_var("launch","category");
      require_once APPPATH."models".DIRECTORY_SEPARATOR."wt_content.php";
      $query = new WT_Content(array());
      require_once WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$query->target.".php";
      break;
    
    default:
      do_action("launch_".$launch);
      break;
  }
  wt_exit("success","launch_theme");
}