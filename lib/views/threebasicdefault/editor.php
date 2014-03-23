<?php 

//pass the page ID to initSettings
initSettings(1);
global $tpl_args;


include_once 'static/functions/function_users.php';
$mysqli = new mysqli(mysql_server, mysql_username, mysql_password, mysql_database);

sec_session_start(); 
if(login_check($mysqli) == true) {
        $loggedIn = true;
} else { 
        $loggedIn = false;
}

?>
<html>
    <head>
    </head>
    <body>
        <?php if($loggedIn): ?>
            <p>You are logged in!</p>
            <form>
                <?php
                    foreach ($tpl_args as $key => $value){
                        
                        if($key == 'id'){
                            $isDisabled = ' disabled ';
                        }else{
                            $isDisabled = '';
                        }
                        echo '<div>';
                            echo '<label>' . $key . ':</label><br>';
                            echo '<input type="text" name="' . $key . '" value="' . $value . '" ' . $isDisabled . ' >';
                        echo '</div>';
                    }
                ?>
            </form>
        <?php else: ?>
            <P>You must be logged in to view this page</p>
        <?php endif; ?>
    </body>

</html>