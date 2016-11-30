<?php
    
    // NOTE: ini_set only works if this code is executed. Set config in php.ini in production
    ini_set("display_errors", "off");
    ini_set("log_errors", "on");
    ini_set("error_log", "/tmp/error_log.txt");
    error_reporting(E_ALL);

    require("constants.php");
    require("functions.php");

    session_start();

    // require authentication for all pages except /login.php, /logout.php, and /register.php
    if (!in_array($_SERVER["PHP_SELF"], ["/myLibrary/public/login.php", "/myLibrary/public/logout.php", "/myLibrary/public/register.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
