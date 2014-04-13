<?php

include_once 'static/functions/function_users.php';
$mysqli = new mysqli(mysql_server, mysql_username, mysql_password, mysql_database);

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
    $loggedIn = true;
} else {
    $logged = 'out';
    $loggedIn = false;
}

?>
<?php if($loggedIn): ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Admin Panel</title>
            <link rel="stylesheet" href="/style.css" />
        </head>
        <body>
            <h1 style="margin-bottom:0;">Admin Panel</h1> 
            (<a href="admin/logout" style="font-size:10px;">log out</a>)
            <hr>
                <h3>Pages</h3>
                <ul>
                    <li><a href="admin/page_editor/1">Page Editor</a></li>
                    <li><a href="admin/page_creator/1">Page Creator</a></li>
                    <li><a href="admin/page_deleter/0">Page Deleter</a></li>
                </ul>
                <h3>Users</h3>
                <ul>
                    <li><a href="register">Create New User</a></li>
                </ul>
                <h3>Configuration</h3>
                <ul>
                    <li><a href="admin/site_settings">Site Settings</a></li>
                    <li><a href="admin/resource_manager">Resource Manager</a></li>
                </ul>
        </body>
    </html>
<?php else: ?>  
    <!DOCTYPE html>
    <html>
        <head>
            <title>Secure Login: Log In</title>
            <link rel="stylesheet" href="style.css" />
            <script type="text/JavaScript" src="<?php echo baseURL; ?>/static/js/sha512.js"></script> 
            <script type="text/JavaScript" src="<?php echo baseURL; ?>/static/js/forms.js"></script> 
        </head>
        <body>
            <?php
            if (isset($_GET['error'])) {
                echo '<p class="error">Error Logging In!</p>';
            }
            ?> 
            <form action="admin/process_login" method="post" name="login_form">                      
                Email: <input type="text" name="email" />
                Password: <input type="password" 
                                 name="password" 
                                 id="password"/>
                <input type="button" 
                       value="Login" 
                       onclick="formhash(this.form, this.form.password);" /> 
            </form>
            <p>If you are done, please <a href="admin/logout">log out</a>.</p>
            <p>You are currently logged <?php echo $logged ?>.</p>
        </body>
    </html>
<?php endif; ?>