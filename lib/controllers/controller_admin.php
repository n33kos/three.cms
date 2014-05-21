<?php

class Controller_admin extends Controller
{
	function __construct()
	{
		$this->allowed_actions = array(
            'index',
            'process_login',
            'logout',
            'page_manager',
            'page_editor',
            'page_creator',
            'page_deleter',
            'site_settings',
            'resource_manager',
            'component_manager',
            'component_editor',
            'component_creator',
            'component_deleter'
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
    
    function page_manager()
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

    function component_manager()
    {
    }

    function component_editor()
    {
    }

    function component_creator()
    {
    }
    
    function component_deleter()
    {
    }
    


}

?>