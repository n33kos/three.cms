<?php

class Controller_admin extends Controller
{
	function __construct()
	{
		$this->allowed_actions = array(
            'index',
            'process_login',
            'logout',
            'page_editor',
            'page_creator',
            'page_deleter',
            'site_settings',
            'resource_manager'
            );
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

	function page_editor()
    {
    }

    function page_creator()
    {
    }

    function page_deleter()
    {
    }

    function site_settings()
    {
    }

    function resource_manager()
    {
    }

}

?>