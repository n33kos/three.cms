<?php

require 'lib/main.php';

//define our controller/action based on mod_rewrite rules
define('controller', (isset($_GET['controller']) ? $_GET['controller'] : 'threebasicdefault'));
define('action', (isset($_GET['action']) ? $_GET['action'] : 'index'));
define('param', (isset($_GET['param']) ? $_GET['param'] : 1));


run_page(controller .'/'. action .'/'. param);


?>