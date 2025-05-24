<?php

include("config.php");

session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['username']);
unset($_SESSION['userid']);
unset($_SESSION['login_name']);
unset($_SESSION['login_caller_id']);


$_SESSION['loggedin'] = false;

session_destroy();
header('Location: '.$root_url.'index.php');

?>