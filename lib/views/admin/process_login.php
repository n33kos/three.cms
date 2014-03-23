<?php

include_once 'lib/main.php';
include_once 'static/functions/function_users.php';
$mysqli = new mysqli(mysql_server, mysql_username, mysql_password, mysql_database);

sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 
    $url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url .= $_SERVER['SERVER_NAME'];
    $url .= htmlspecialchars($_SERVER['REQUEST_URI']);
    $themeurl = dirname(dirname($url));

    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ' . $themeurl . '/admin?success=1');
    } else {
        // Login failed 
        header('Location: ' . $themeurl . '/admin?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}

?>