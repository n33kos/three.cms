<?php 

//pass the page ID to initSettings
initData(param);
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
            <hr>
            <h1>Page Editor</h1>
            <?php
                if(count($_POST) > 0 && $_GET['success'] != 1 && $_GET['error'] != 1){
                    updatePage($mysqli,param);
                }
            ?>
            <hr>
            <form name="pageData" action="" method="POST">
                <?php
                    foreach ($tpl_args as $key => $value){
                        
                        if($key == 'id'){
                            $isDisabled = ' disabled ';
                        }else{
                            $isDisabled = '';
                        }

                        if(is_object($value) || is_array($value)){
                            echo '<div>';
                            echo '<label>' . $key . ':</label><br>';
                            echo '<fieldset>';
                            $subIteration = 0;
                            foreach ($value as $key1 => $value1){

                                    if($key == 'shaderIncludes' || $key == 'scriptIncludes'){
                                        //CHECKBOXES
                                        if($value1 != '' && $value1 != null){
                                            $YesOrNo='yes';
                                            $isChecked='checked';
                                        }else{
                                            $YesOrNo='';
                                            $isChecked='';
                                        }
                                        echo '<input type="checkbox" title= "' . $key1 . '" name="' . $key1 . '" value= "' . $YesOrNo . '" ' . $isChecked . ' >';
                                        echo '<label>' . $key1 . '</label><br>';
                                    }elseif(sizeof($value1) > 1 || is_object($value1)){
                                        echo '<fieldset>';
                                        foreach ($value1 as $key2 => $value2){
                                            echo '<input type="text" title= "' . $key2 . '" name="' . $key2 . $subIteration . '" placeholder= "' . $key2 . '" value="' . htmlentities($value2) . '" >';
                                        }
                                        $subIteration++;
                                        echo '</fieldset>';
                                    }else{
                                        echo '<input type="text" title= "' . $key1 . '" name="' . $key1 . '" placeholder= "' . $key1 . '" value="' . htmlentities($value1) . '" ' . $isDisabled . ' >';
                                    }

                            }
                            echo '</fieldset>';
                            echo '</div>';
                        }else{
                            if($key == 'customInits' || $key == 'customBody' || $key == 'customRender' || $key == 'pageContent'){
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
                    } 
                ?>
                <input type="submit" value="Submit">
            </form>
        <?php else: ?>
            <?php 
                header("Location: ../");
                exit;
            ?>
        <?php endif; ?>
    </body>

</html>