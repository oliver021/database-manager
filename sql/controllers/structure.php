<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shell extends CI_Controller {	 

	var $string = "CREATE TABLE user
	(
	id int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	username varchar(25),
	fullname varchar(45),
	password varchar(45),
	avatar_source varchar(156),
	email varchar(25),
	role varchar(20),
	phone varchar(20),
	status int(1),
	gene varchar(10),
	date_m varchar(15),
	date_user varchar(45),
	country varchar(45),
	language varchar(10)
	)"

	public function index()
	{
		return false;
	}

	public function create_table(){
		for ($i=0; $i < count($_POST); $i++) { 
			if (preg_match("/^idField~/", key($_POST))) {
				$a1 = explode("~", current($_POST));
				$turns[] = array("key" => $a1[1],"dataType" => $_POST['td'.$a1[1]],"length"=> $_POST['length'.$a1[1]]); 
			}
			next($_POST);
		}
		var_dump($turns); $fields = "";
		for ($i=0; $i < count($turns); $i++) { 
			$fields .= $turns[$i]["key"]." ".$turns[$i]["key"]." (".$turns[$i]["length"]."),\n";
		}
	}

}