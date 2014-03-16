<?php

class Controller_editor extends Controller
{
	function __construct()
	{
		$this->allowed_actions[] = 'index';
		$this->model_editor = get_model('Model_editor');
	}

	function index()
	{
    }
}

?>