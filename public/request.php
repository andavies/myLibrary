<?php
    /** 
     * TODO not used in submitted project, implement in next version
     *
     * request.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * allows user to request a book to loan
     */
     
    // config
    require("../includes/config.php");
    
    // ensure user arrived here by POST
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        redirect('/');
    }
    
    // check that 'id' has been posted
    if (empty($_POST["id"]))
    {
        apologize("something went wrong, see request.php");
    }
    
    // get borrower's username
    $username = query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
    $username = $username[0]["username"];
    
    // change book in database: status->'requested', borrower->'username'
    $request = query("UPDATE books SET availability='requested', borrower=?, borrowerid=? WHERE id=?", 
                      $username, $_SESSION["id"], $_POST["id"]);
    
    // check success
    if ($request === false)
    {   
        apologize("something went wrong requesting book");
    }
    else
    {
        render("success_request.php");
    }
?>
