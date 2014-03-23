<?php

class Controller_admin extends Controller
{
	function __construct()
	{
		$this->allowed_actions = array('index','process_login','logout');
		$this->model_admin = get_model('Model_admin');
	}

	function index()
	{
    }

    function process_login()
    {
    }

    function logout()
    {
    }

}

?>