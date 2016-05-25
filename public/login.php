<?php
    /** 
     * login.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * displays login page
     */
     
    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("login_form.php", ["title" => "Log In"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username (email address).");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }

        // sanitise inputs
        $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES);        

        // query database for user
        $rows = query("SELECT * FROM users WHERE username = ?", $username);

        // if user found, check password
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash in database
            if (crypt($password, $row["hash"]) == $row["hash"])
            {
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $row["id"];

                // redirect to portfolio
                redirect("/myLibrary/public/");
            }
        }

        // else apologize
        apologize("Invalid username and/or password.");
    }
?>
