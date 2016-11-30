<?php

    /**
     * config.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * Configures pages.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", "off");
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");

    // enable sessions
    session_start();

    // TEST
    // dump($_SERVER);

    // require authentication for all pages except /login.php, /logout.php, and /register.php
    if (!in_array($_SERVER["PHP_SELF"], ["/myLibrary/public/login.php", "/myLibrary/public/logout.php", "/myLibrary/public/register.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
