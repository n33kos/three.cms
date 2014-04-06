<?php

require 'lib/main.php';

//define our controller/action based on mod_rewrite rules
define('controller', (isset($_GET['controller']) ? $_GET['controller'] : 'threebasicdefault'));
define('action', (isset($_GET['action']) ? $_GET['action'] : 'index'));
define('param', (isset($_GET['param']) ? $_GET['param'] : 1));

//This is going to need to change based on site wide settings to support subdirectory sites
define('baseURL',"http://" . $_SERVER['HTTP_HOST'] . '/three');


run_page(controller .'/'. action .'/'. param);


?>