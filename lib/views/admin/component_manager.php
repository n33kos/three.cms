<?php 

//pass the page ID to initSettings
getComponents();
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
	        <h1>Component Manager</h1>
	        <hr>
            <?php
                echo '<table>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Slug</th>';
                        echo '<th>Actions</th>';
                    echo '</tr>';
                    foreach($comp_args as $component){
                        echo '<tr>';
                            echo '<td>' . $component['id'] . '</td>';
                            echo '<td>' . $component['slug'] . '</td>';
                            echo '<td>';
                                echo '<a href="../component_editor/' . $component['id'] . '">Edit</a>&nbsp;';
                                echo '<a href="../component_creator/' . $component['id'] . '">Copy</a>&nbsp;';
                                echo '<a href="../component_deleter/' . $component['id'] . '">Delete</a>&nbsp;';
                            echo '</td>';
                        echo '</tr>';
                    }
                echo '</table>';
            ?>
        <?php else: ?>
            <?php 
                header("Location: ../");
                exit;
            ?>
        <?php endif; ?>
    </body>
</html>