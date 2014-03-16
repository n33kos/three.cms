<?php

require 'lib/main.php';

//define our controller/action/id based on mod_rewrite rules
define('controller', $_GET['controller']);
define('action', $_GET['action']);
define('id', $_GET['id']);

if(controller == 'editor'){
	//controller/view
	run_page('editor/index');
}else{
	//controller/view
	run_page('threebasicdefault/index');
}


?>