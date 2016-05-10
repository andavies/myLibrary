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
        $book = lookup($_POST["isbn"]);
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

