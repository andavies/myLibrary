<?php
    /** 
     * index.php
     *
     * CS50
     * final project
     * Andrew Davies
     *
     * displays home page
     */
     
    // configuration
    require("../includes/config.php"); 
    
    // render instructions
    render("instructions.php", ["title" => "Instructions"]);
?>
