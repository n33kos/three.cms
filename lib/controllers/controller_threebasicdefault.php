<?php

class Controller_threebasicdefault extends Controller
{
	function __construct()
	{
		$this->allowed_actions = array('index');
		$this->model_threebasicdefault = get_model('Model_threebasicdefault');
	}

	function index()
	{
    }

}

?>