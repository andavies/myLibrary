<?php
    /** 
     * logout.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * logs user out
     */
     
    // configuration
    require("../includes/config.php"); 

    // log out current user, if any
    logout();

    // redirect user
    redirect("/public/");

?>
