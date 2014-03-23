<?php

require 'lib/main.php';

//define our controller/action based on mod_rewrite rules
define('controller', $_GET['controller']);
define('action', $_GET['action']);

run_page(controller .'/'. action);

?>