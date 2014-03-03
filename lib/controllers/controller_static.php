<?php

class Controller_Static extends Controller
{
	function __construct()
	{
		//$this->allowed_actions[] = 'default_action';
                $this->allowed_actions[] = 'home';
	}

	function home()
	{
	}
}

?>
