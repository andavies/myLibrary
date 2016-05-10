<?php
    /** 
     * mybooks.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * displays myBooks page
     */
    
    /* TODO the logic linking the post request from mybooktable.php isn't great here
       moving fast to meet deadline, needs tidying */
    
    // configuration
    require("../includes/config.php");
    
    // if POST ie. user modifying his/her books
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if query string empty (user changing book availability)
        if (!empty($_SERVER["QUERY_STRING"]) && !empty($_POST["availability"]))
        {
            // modify book values in db
            $modify = query("UPDATE books SET availability=? WHERE id=?", $_POST["availability"], $_SERVER["QUERY_STRING"]);   
        }
        // else if query string exists (user deleting book)
        else if (empty($_SERVER["QUERY_STRING"]) && !empty($_POST["delete"]))
        {
            // delete row
            $modify = query("DELETE FROM books WHERE id=?", $_POST["delete"]);
        }
        else
        {   
            // TODO if gets to here something not right
            dump($_POST);
            apologize("something not working");
        }
        
        // check modification success
        if ($modify === false)
        {
            apologize("something went wrong, unable to modify database");
        }
    }
    
    // select user's books
    $rows = query("SELECT * FROM books WHERE ownerid=?", $_SESSION["id"]);
    
    // show user's books
    render("mybooktable.php", ["rows" => $rows, "title" => "My Books"]);
?>
