<?php
    
    require("../includes/config.php");

    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("register_form.php", ["title" => "Register"]);
    }


    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // for now, username is email

        $filtered_input = array();

        if    (empty($_POST["username"]) 
            || empty($_POST["password"]) 
            || empty($_POST["confirmation"]))
        {
            apologize("You must complete all fields");
        }
        else if (filter_var($_POST["username"], FILTER_VALIDATE_EMAIL) === false)
        {
            apologize("you entered an invalid email address");
        }
        else if (strlen($_POST["password"]) < MIN_PASSWORD_LENGTH)
        {
            apologize("your password must be at least " 
                      . MIN_PASSWORD_LENGTH 
                      . " characters long");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your password confirmation did not match.");
        } 
        else 
        {
            $filtered_input['username'] = $_POST['username'];
            $filtered_input['password'] = $_POST['password'];
        }

        /* also, constants.php is on the gitignore because it has passwords. But I've now put MIN_PASSWORD.. constant in, which I'd like to be included. split into seperate files. CREATE AN ISSUE FOR THIS. START USING ISSUES. */


        

        // sanitise inputs
        $username = htmlspecialchars($filtered_input['username'], ENT_QUOTES);
        $password = htmlspecialchars($filtered_input['password'], ENT_QUOTES);

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
