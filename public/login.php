<?php
    
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
        $encrypted_password = password_hash($filtered_input['password'], PASSWORD_DEFAULT);

        // sanitise output to db
        $sanitised_sql = array();
        $sanitised_sql['username'] = mysqli_real_escape_string($filtered_input['username']);
        $sanitised_sql['encrypted_password'] = mysqli_real_escape_string($encrypted_password);

     

        // query database for user
        $rows = query("SELECT * FROM users WHERE username = ?", $sanitised_sql['username']);

        // if user found, check password
        if (count($rows) === 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash in database
            if ($encrypted_password === $row["hash"])
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
