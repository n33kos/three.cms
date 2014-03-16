<?php

class editor extends Model
{
    function __construct()
    {
        parent::__construct(); // This line is very important
        //$this->comments_table_name = mysql_table_prefix . 'guestbook';
    }

    function initSettings(){
    	return;
	}

}

?>