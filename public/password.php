<?php
    /** 
     * password.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * allows user to change password
     */
     
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("changepassword_form.php", ["title" => "Change password"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["current"]))
        {
            apologize("You must enter your current password");
        }
        else if (empty($_POST["new"]))
        {
            apologize("You must enter a new password");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your new password");
        }
        else if ($_POST["new"] !== $_POST["confirmation"])
        {
            apologize("Your password confirmation did not match.");
        }
        
        // check that correct (current) password entered
        $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
        
        if (crypt($_POST["current"], $rows[0]["hash"]) == $rows[0]["hash"])
        {
            // change password
            $change = query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["new"]), $_SESSION["id"]);
            
            // error check
            if ($change === false)
            {
                apologize("something went wrong whilst updating password");
            }
            else
            {
                render("passchangeconfirm.php");
            }
        }
        else
        {
            apologize("you entered an incorrect current password");
        }
    }
?>
