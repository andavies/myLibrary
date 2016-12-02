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

        // filter input
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

        
        // encrypt password
        $encrypted_password = password_hash($filtered_input['password'], PASSWORD_DEFAULT); 

        // escape output before sending to db
        $sanitised_sql = array();
        $sanitised_sql['username'] = mysqli_real_escape_string($filtered_input['username']);
        $sanitised_sql['encrypted_password'] = mysqli_real_escape_string($encrypted_password);

        // add user to database
        $result = query("INSERT INTO users (username, hash) VALUES(?, ?)", 
                        $sanitised_sql['username'], 
                        $sanitised_sql['encrypted_password']);
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
