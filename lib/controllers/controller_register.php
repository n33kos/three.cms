<?php

class Controller_register extends Controller
{
	function __construct()
	{
		$this->allowed_actions = array('index','register_success');
		$this->model_register = get_model('Model_register');
	}

	function index()
	{
    }

    function register_success()
    {
    }

}

?>