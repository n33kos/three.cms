<?php
    function siteSettings(){
        // Connects to your Database 
        mysql_connect(mysql_server, mysql_username, mysql_password) or die(mysql_error()); 
        mysql_select_db(mysql_database) or die(mysql_error()); 
        $data = mysql_query("SELECT * FROM site_settings WHERE id = 1") 
        or die(mysql_error());
        //grab those vars
        $info = mysql_fetch_array($data);

        $tpl_settings['sitetitle'] = $info['sitetitle'];
        $tpl_settings['siteurl'] = $info['siteurl'];
        $tpl_settings['admincontact'] = $info['admincontact'];
        $tpl_settings['timezone'] = $info['timezone'];
        $tpl_settings['robotsbit'] = $info['robotsbit'];
        $tpl_settings['homecontroller'] = $info['homecontroller'];

        return $tpl_settings;
    }
?>