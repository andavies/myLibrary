<?php
    /** 
     * register.php
     *
     * CS50
     * Final Project
     * Andrew Davies
     *
     * registers a new user account
     */
     
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your email address.");
        }
        else if (filter_var($_POST["username"], FILTER_VALIDATE_EMAIL) === false)
        {
            apologize("you entered an invalid email address");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your password.");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your password confirmation did not match.");
        }

        // sanitise inputs
        $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

        // encrypt password
        $password = crypt(password);
        
        // add user to database
        $result = query("INSERT INTO users (username, hash) VALUES(?, ?)", $username, $password);
        if ($result === false)
        {
            apologize("The username you entered already exists");
        }
        else
        {
            // log user in
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"]; 
            
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            
            // redirect to home page
            redirect("index.php");
        }
    }
?>
