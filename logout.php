<?php

session_start();

$_SESSION = array();


session_destroy();

// Redirect the user to the login page
header("Location: login.php");
exit();
?>