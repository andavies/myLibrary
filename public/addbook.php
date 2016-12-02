<?php
    
    require("../includes/config.php");

    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("addbook_form.php", ["title" => "Add Books"]);
    }


    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        // filter input
        $isbn = $_POST['isbn'];
        $filtered_input = array();
        if(!ctype_digit($isbn))
        {
            apologize('ISBN number must contain numbers only');
        }
        // https://en.wikipedia.org/wiki/International_Standard_Book_Number
        else if (!(strlen($isbn) === 10 || strlen($isbn) === 13))
        {
            apologize("Invalid ISBN number: must be 10 or 13 digits long");
        }
        else
        {
            $filtered_input['isbn'] = $isbn;
        }     
        
        
        $book = lookup($filtered_input['isbn']);
        if ($book === false)
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
                              $_POST["isbn"], $book -> title, $book -> authors[0], $username, $_SESSION["id"], 
                              $book -> imageLinks -> smallThumbnail, $book -> description);
            
            // error check
            if ($addbook === false)
            {
                apologize("something went wrong, unable to add book");
            }
                                
            // render confirmation screen
            render("confirm.php", ["book" => $book, "title" => "confirm"]);
        }
    }
?>

