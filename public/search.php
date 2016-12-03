<?php
    
    require("../includes/config.php");
    
    // if GET select all books except user's
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // query function handles escaping
        //$rows = query("SELECT * FROM books WHERE ownerid!=?", $_SESSION["id"]);

        render('search_form.php');
    }


    // else if POST select books matching search
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (!empty($_POST["isbn"]))
        {
            // if isbn searched
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND isbn=?",
                           $_SESSION["id"], $_POST["isbn"]);
        }
        else if (!empty($_POST["title"]))
        {
            // if title searched
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND title LIKE ? ",
                           $_SESSION["id"], '%'.$_POST["title"].'%');
        }
        else if (!empty($_POST["author"]))
        {
            // if author searched
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND author LIKE ? ",
                           $_SESSION["id"], '%'.$_POST["author"].'%');
        }
        else
        {
            // empty search, select all (except user's)
            $rows = query("SELECT * FROM books WHERE ownerid!=?", $_SESSION["id"]);
        }

        // error check 
        if ($rows === false)
        {
            apologize("something went wrong searching database");
        }
        // if no matches
        else if (empty($rows))
        {
            apologize("no matches found");
        }
        // show results
        else if (!empty($rows))
        {
            render("searchtable.php", ["rows" => $rows, "title" => "search"]);
        }
    }    
    
    
?>
