<?php
    
    require("../includes/config.php");

    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("addbook_form.php", ["title" => "Add Books"]);
    }


    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $filtered_input = array();
        $filtered_input['isbn'] = filter_isbn($_POST['isbn']);            
        
        
        //$book = lookup($filtered_input['isbn']);
        $filtered_input['book'] = lookup($filtered_input['isbn']);
        if ($filtered_input['book'] === false)
        {
            apologize("Unable to identify book, please check isbn number");    
        }
        else
        {
            // retrieve username using session id
            $user_row = query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
            $username = $user_row[0]["username"];
            
            // add book to database
            $addbook = query("INSERT INTO books (isbn, title, author, ownername, ownerid, thumb, description) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)", 
                              $_POST["isbn"], 
                              $filtered_input['book'] -> title, 
                              $filtered_input['book'] -> authors[0], 
                              $username, 
                              $_SESSION["id"], 
                              $filtered_input['book'] -> imageLinks -> smallThumbnail, 
                              $filtered_input['book'] -> description);
            
            // error check
            if ($addbook === false)
            {
                apologize("something went wrong, unable to add book");
            }
                                
            // render confirmation screen
            render("confirm.php", ["book" => $filtered_input['book'], "title" => "confirm"]);
        }
    }
?>

