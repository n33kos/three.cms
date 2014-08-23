<?php
    function getSettings(){
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
        $tpl_settings['homepageid'] = $info['homepageid'];

        return $tpl_settings;
    }
    function setSettings($mysqli){
        /*-------------------------------------------------------------------------------*/
        /*---------------------------Get POST Variables----------------------------------*/
        /*-------------------------------------------------------------------------------*/
        $theID = 1;
        $sitetitle = filter_input(INPUT_POST, 'sitetitle', FILTER_SANITIZE_STRING);
        $siteurl = filter_input(INPUT_POST, 'siteurl', FILTER_SANITIZE_STRING);
        $admincontact = filter_input(INPUT_POST, 'admincontact', FILTER_SANITIZE_STRING);
        $timezone = filter_input(INPUT_POST, 'timezone', FILTER_SANITIZE_STRING);
        $robotsbit = filter_input(INPUT_POST, 'robotsbit', FILTER_SANITIZE_STRING);
        $homecontroller = filter_input(INPUT_POST, 'homecontroller', FILTER_SANITIZE_STRING);
        $homepageid = filter_input(INPUT_POST, 'homepageid', FILTER_SANITIZE_STRING);

        /*-------------------------------------------------------------------------------*/
        /*---------------------------Prep Then execute Statement-------------------------*/
        /*-------------------------------------------------------------------------------*/
        $prep_stmt = "UPDATE site_settings SET sitetitle=?, siteurl=?, admincontact=?, timezone=?, robotsbit=?, homecontroller=?, homepageid=? WHERE id=?";
        $update_stmt = $mysqli->prepare($prep_stmt);
        $update_stmt->bind_param( "ssssisii", $sitetitle, $siteurl, $admincontact, $timezone, $robotsbit, $homecontroller, $homepageid, $theID);
        
        // Execute the prepared query.
        if (!$update_stmt->execute()) {
            header('Location: ?error=1');
            echo "Execute failed: (" . $update_stmt->errno . ") " . $update_stmt->error;
            print('ERROR!');
        }else{
            $update_stmt->close();
            header('Location: ?success=1');
            print('SUCCESS!');
        }
        
    }
?>