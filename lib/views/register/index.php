<?php 
include_once 'register.inc.php';
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
        <meta charset="UTF-8">
        <title>Create New User</title>
        <script type="text/JavaScript" src="static/js/sha512.js"></script> 
        <script type="text/JavaScript" src="static/js/forms.js"></script>
        <link rel="stylesheet" href="static/css/register.css" />
    </head>
    <body>
        <h1>Create New User</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form action="register" 
                method="post" 
                name="registration_form">
            Username: <input type='text' 
                name='username' 
                id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Password: <input type="password"
                             name="password" 
                             id="password"/><br>
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p>Return to the <a href="admin">login page</a>.</p>
    </body>
</html>
<?php else: ?>
    <?php 
        header("Location: admin");
     exit;
    ?>
<?php endif; ?>