<?php
session_start();

require_once __DIR__."/../config.php";

session_destroy();
unset($_SESSION);
    
setcookie("login_info", "", time() - 1, "/"); 
unset($_COOKIE["login_info"]); 

header("location: {$baseUrl}");
exit();