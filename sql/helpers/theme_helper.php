<?php //Theme Api tool in function's

/**
*@internal util to developer in theme
*@param string $key
*@return $data
*
*/

//Theme vars is util for use in front-end interface

function theme_var($name,$data=null)
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
*@internal system set var to theme use
*@param $key string
*@param @value $data
*@return void
*/

function theme_set($key,$value){
	$t123[$key] = $value;
}

function if_default($d1,$d2){
	if ($d1) {
		return $d1;
	}else{
		return $d2;
	}
}

function theme_path()
{
	return BASE_URL."web/themes/".config_item("theme")."/";
}

function theme_file_exist($file,$ext=".php"){
	return file_exists(WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$file.$ext);
}

function theme_include($file,$ext=".php"){
	include_once WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$file.$ext;
}

/**
*  -----------------------------------------------------------------------------------//?
 * extract element data function
 * Helper functions system 
 *
 * @return data
 * @author Oliver Valiente 
 **/


/**
*  ---------------Extract Data Item
*@param $string name
*@return data array
*
*/

function extract_item()
{
  static $i,$d;
  if ($i !== 1) {
   $i=1;
   $d = sys_var("data_item");
  }
  return array_shift($d);
}
function extract_category()
{
  static $i,$d;
  if ($i !== 1) {
   $i=1;
   $d = sys_var("category_group");
  }
  return array_shift($d);
}

/**
*
*@param $string name
*@return data variant
*
*/
function current_item($key)
{
   static $i,$d;
  if ($i !== 1) {
   $i=1;
   $d = sys_var("data_item");
  }
  if (!array_key_exists($key, $d)) {
   return false;
  }
  return $d[$key];
}

function item_date()
{
  $d = date("h-d-m-Y",(int)current_item("time"));
  $d = explode("-", $d);
  $d[2] = wt_months((int)$d[2]);
  return $d[1]." "._w_("of")." ".$d[2]." ".$d[3]." "._w_("at")." ".$d[0];
}

/**
*
*@param $string name
*@return data variant
*
*/
function author_item($key)
{
   static $i,$d;
  if ($i !== 1) {
   $i=1;
   $d = sys_var("data_author");
  }
  return $d[$key];
}

/**
*  helper api ----- menu standard
*@param none
*@internal system theme
*@return array data
*/

function standard_menu()
{
  static $i,$d;
  $hidden = func_get_args();
  if (strstr($hidden[0], ",")) {
     $hidden = explode(",", $hidden[0]);
  }
  if ($i !== 1) {
   $i=1;
   $d = array(
    ".." => null,
    "home" => array("link" => wt_weburl()."home", "name" => alias_theme("home")),
    "item" => array("link" => wt_weburl()."blog", "name" => alias_theme("item")),
    "category" => array("link" => wt_weburl().'category', "name" => alias_theme("category")),
    "login" => array("link" => wt_weburl()."login", "name" => alias_theme("login")),
    "about_me" => array("link" => wt_weburl()."page/about_me", "name" => alias_theme("about_me")),
    "contact" => array("link" => wt_weburl()."page/contact", "name" => alias_theme("contact"))
    );
  }
  return next($d);
}

/**
*@param none
*@theme herlper basic
*@return boolean $if have category description
*/

function category_description_exist()
{
  return (bool)sys_var("about_category");
}

/**
*@param none
*@theme herlper basic
*@return boolean $if have category description
*/

function get_category_description()
{
  $d=sys_var("about_category"); return $d['about'];
}

function get_category_name()
{
  return sys_var("name_category");
}

/**
*
*@param string $name
*@param config $array
*@internal
*@return string alias name
*/

function alias_theme($name){
  return $name;
}

/**
*@include page theme
*@internal
*/

function theme_load($page)
{
  include_once  WEBPATH."themes".DIRECTORY_SEPARATOR.config_item("theme").DIRECTORY_SEPARATOR.$page.".php";;
}