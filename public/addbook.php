<?php
    /** 
     * addbook.php
     *
     * CS50
     * final project
     * Andrew Davies
     *
     * displays +Book page
     */
    
    // configuration
    require("../includes/config.php");
    
    // if 'get', display add book form
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("addbook_form.php", ["title" => "Add Books"]);
    }
    // if 'post', find book
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // sanitise book input
        $isbn = htmlspecialchars($_POST["isbn"], ENT_QUOTES);

        // validate isbn format: check either 10 or 13 digits long
        // https://en.wikipedia.org/wiki/International_Standard_Book_Number
        if (!(strlen($isbn) === 10 || strlen($isbn) === 13))
        {
            apologize("Invalid ISBN number: must be 10 or 13 digits long");
        }
        
        // check isbn contains only numbers
        if(!ctype_digit($isbn))
        {
            apologize('ISBN number must contain numbers only');
        }

        $book = lookup($isbn);
        if ($book === false)
        {
            apologize("Unable to identify book, please check isbn number (omit all dashes or spaces)");    
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

