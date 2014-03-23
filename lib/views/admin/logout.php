<?php

include_once 'static/functions/function_users.php';

sec_session_start();
 
// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();
header('Location: ');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Log Out</title>
        <link rel="stylesheet" href="/style.css" />
    </head>
    <body>
        <p>You are now logged out.</a></p>
    </body>
</html>
