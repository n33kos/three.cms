<?php 


getPages();
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
<?php if($loggedIn): ?>
<html>
    <head>
    </head>
    <body>
        <hr>
        <h1>Page Manager</h1>
        <hr>
        <?php
            echo '<table>';
                echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Title</th>';
                    echo '<th>Publication Date</th>';
                    echo '<th>Summary</th>';
                    echo '<th>Actions</th>';
                echo '</tr>';
                foreach($tpl_args as $page){
                    echo '<tr>';
                        echo '<td>' . $page['id'] . '</td>';
                        echo '<td>' . $page['title'] . '</td>';
                        echo '<td>' . $page['publicationDate'] . '</td>';
                        echo '<td>' . $page['summary'] . '</td>';
                        echo '<td>';
                            echo '<a href="../page_editor/' . $page['id'] . '">Edit</a>&nbsp;';
                            echo '<a href="../page_creator/' . $page['id'] . '">Copy</a>&nbsp;';
                            echo '<a href="../page_deleter/' . $page['id'] . '">Delete</a>&nbsp;';
                        echo '</td>';
                    echo '</tr>';
                }
            echo '</table>';
        ?>
    </body>
</html>
<?php else: ?>
    <?php 
        header('Location: ../');
        exit;
    ?>
<?php endif; ?>