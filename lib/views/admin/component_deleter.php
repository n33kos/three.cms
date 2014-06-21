<?php 

//pass the page ID to initSettings
initComponent(param);
global $comp_args;

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
	    	<hr>
	        <h1>Component Deleter</h1>
            <?php
                if(count($_POST) > 0 && $_GET['success'] != 1 && $_GET['error'] != 1 && $_POST['yesseriouslydelete'] != 1 && param != 0){
                    echo 'Are you seriously effing sure you want to delete this page?';
                    echo '<form name="pageKiller" action="" method="POST">';
                    echo '<input type="text" title= "yesseriouslydelete" name="yesseriouslydelete" value="1" hidden >';
                    echo '<input type="submit" value="YES DELETE!">';
                    echo '</form>';
                }elseif(count($_POST) > 0 && $_GET['success'] != 1 && $_GET['error'] != 1 && $_POST['yesseriouslydelete'] == 1 && param != 0){
                    deleteComponent($mysqli, param);
                }
            ?>
	        <hr>
           <form name="pageData" action="" method="POST">
                <input type="submit" value="DELETE!">
                <?php
                    foreach ($comp_args as $key => $value){
                        
                        if($key == 'id'){
                            $isDisabled = ' disabled ';
                        }else{
                            $isDisabled = '';
                        }

                        if($key == 'functions' || $key == 'init_script' || $key == 'main_script' || $key == 'render_script' || $key == 'animation_script'){
                            echo '<div>';
                                echo '<label>' . $key . ':</label><br>';
                                echo '<textarea rows="4" cols="50" title= "' . $key . '" name="' . $key . '" ' . $isDisabled . '>';
                                echo htmlentities($value);
                                echo '</textarea>';
                            echo '</div>';
                        }else{
                            echo '<div>';
                                echo '<label>' . $key . ':</label><br>';
                                echo '<input type="text" title= "' . $key . '" name="' . $key . '" placeholder= "' . $key . '" value="' . htmlentities($value) . '" ' . $isDisabled . ' >';
                            echo '</div>';
                        }
                    } 

                ?>
            </form>
        <?php else: ?>
            <?php 
                header("Location: ../");
                exit;
            ?>
        <?php endif; ?>
    </body>
</html>