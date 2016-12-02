<?php
    
    require("../includes/config.php"); 

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("login_form.php", ["title" => "Log In"]);
    }


    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        // filter input
        $filtered_input = array();
        if (empty($_POST['username']) || empty($_POST['password']))
        {
            apologize("Please complete both fields");
        }
        else if (filter_var($_POST["username"], FILTER_VALIDATE_EMAIL) === false)
        {
            apologize("You entered an invalid email address");
        }
        else
        {
            $filtered_input['username'] = $_POST['username'];
            $filtered_input['password'] = $_POST['password'];
        }

        // encrypt password
        $filtered_input['encrypted_password'] = password_hash($filtered_input['password'],                                                  PASSWORD_DEFAULT);

        // (escaping output is handled by PDO in the query function)
           

        // query database for user
        $rows = query("SELECT * FROM users WHERE username = ?", $filtered_input['username']);

        // if user found, check password
        if (count($rows) === 1)
        {
            // first (and only) row
            $row = $rows[0];

            if ($filtered_input['encrypted_password'] === $row["hash"])
            {
                $_SESSION["id"] = $row["id"];

                redirect("/myLibrary/public/");
            }
        }

        apologize("Invalid username and/or password.");
    }
?>
