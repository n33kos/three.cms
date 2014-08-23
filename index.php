<?php

require 'lib/main.php';

//define our controller/action based on mod_rewrite rules
define('controller', (isset($_GET['controller']) ? $_GET['controller'] : ''));
define('action', (isset($_GET['action']) ? $_GET['action'] : ''));
define('param', (is_numeric($_GET['param']) ? $_GET['param'] : null));

run_page(controller .'/'. action .'/'. param);

?>