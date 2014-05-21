<?php

// Hardcoded Configuration
define('mysql_server', 'localhost');
define('mysql_username', 'root');
define('mysql_password', 'root');
define('mysql_database', 'tafe');
define('mysql_table_prefix', '');

// This is the view template which is used to surround each page.
define('template_view', dirname(__FILE__) . '/views/template_view.php');

//Get site-wide settings
include_once 'static/functions/function_site_settings.php';
global $tpl_settings;
$tpl_settings = siteSettings();

//define site-wide settings
define('siteTitle', $tpl_settings['sitetitle']);
define('baseURL', $tpl_settings['siteurl']);
define('robotsBit', $tpl_settings['robotsbit']);
define('adminContact', $tpl_settings['admincontact']);
define('homeController', $tpl_settings['homecontroller']);
if($tpl_settings['timezone'] != ''){
	date_default_timezone_set($tpl_settings['timezone']);
}

// End Configuration

$mysql_link;

class Controller
{
	public $allowed_actions;
        public $view_array;
        public $params;

        function redirect_to_self()
        {
            header('Location: ' . $_SERVER['PHP_SELF']);
            global $mysql_link;
            mysql_close($mysql_link);
            exit;
        }
}

class Model
{
    protected $mysql_link;
 
    function __construct()
    {
        global $mysql_link;
        $this->mysql_link = &$mysql_link;
    }

    function select_default_db()
    {
        mysql_select_db(mysql_database, $this->mysql_link);
    }
}

function autoload($class)
{
	if ((strlen($class) > 11) && (substr($class, 0, 11) == 'Controller_')) // the class is a controller
	{
		$filename = dirname(__FILE__) . '/controllers/' . strtolower($class) . '.php';
		if (!file_exists($filename))
			die('File not found: ' . $filename);
		include $filename;
	}
	else
	{
		if ((strlen($class) > 6) && (substr($class, 0, 6) == 'Model_'))
		{
			$filename = dirname(__FILE__) . '/models/' . strtolower($class) . '.php';
			if (!file_exists($filename))
				die('File not found: ' . $filename);
			include $filename;
		}
	}
}

function get_view_filename($controller, $name)
{
	$controller = substr($controller, 11); // remove controller_ from filename
	$filename = dirname(__FILE__) . '/views/' . strtolower($controller) . '/' . strtolower($name) . '.php';
	define('view_path', 'lib/views/' . strtolower($controller) . '/');
	return $filename;
}

$_model_instances = array();
function &get_model($name)
{
	if ((strlen($name) > 6) && (substr($name, 0, 6) == 'Model_'))
	{
		if (class_exists($name))
		{
			if (!isset($_model_instances[$name]))
			{
				$_model_instances[$name] = new $name();
			}
			return $_model_instances[$name];
		}
	}
	$tempnull = null;
	return $tempnull;
}

function show_view($___filename, $data)
{
	if (file_exists($___filename))
	{
		extract($data, EXTR_SKIP);
		unset($data);
		include $___filename;
	}
	
}

function run_page($page_name)
{
	$page_name_split = explode('/', $page_name);
	//set the default controller if none selected
	if(strlen(controller) > 0){
		$controller_name = 'Controller_' . $page_name_split[0];
	}else{
		$controller_name = 'Controller_' . homeController;
	}
	$controller = new $controller_name();

	// if ajax we don't want to render outer template
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		$use_main_template = false;
	// otherwise render a page in the template
	else
		$use_main_template = true;

    if(strtolower($controller_name) == 'controller_admin'){
    	// If the controller is the admin page, we route all pages through the index action
		$action_name = 'index';
	}elseif((count($page_name_split) == 1) || ($page_name_split[1] == '')){
    	// if the page string given to us doesn't have a name, use default page
		$action_name = 'index';
	}else{
		$action_name = $page_name_split[1];
	}

    // make sure the action method exists
	if (!in_array($action_name, $controller->allowed_actions)) die('Action ' . $action_name . ' not found in controller ' . $controller_name . '.');

    // if parameters exist (eg controller/action/lol/lol/lol, get them
	if (count($page_name_split) > 2)
		$params = array_slice($page_name_split, 2);
	else
		$params = array();

	$view_array = array();
        $controller->view_array = &$view_array;
        $controller->params = &$params;
		$controller->$action_name();
        $controller->view_array['base_path'] = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;


	// If we haven't redirected away after the controller we may as well show the page!
	$view_filename = get_view_filename($controller_name, $action_name);
	if (!file_exists($view_filename))
		die ('View not found: ' . $view_filename);
	else
	{
		ob_start();
		{
			show_view($view_filename, $view_array);
		} $ob_contents = ob_get_clean();

		if ($use_main_template == false)
		{
                    echo $ob_contents;
		}
		else
		{
			show_view(template_view, array('body'=>$ob_contents));;
		}
	}
}

// Initialisation
spl_autoload_register('autoload');

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache");

$mysql_link = mysql_connect(mysql_server, mysql_username, mysql_password);
if (!$mysql_link) die (mysql_error());

?>