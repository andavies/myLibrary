<?php
    
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render('search_form.php');
    }


    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $filtered_input = [
            'isbn' => null,
            'title' => null,
            'author' => null
        ];

        if (!empty($_POST['isbn']))
        {
            $filtered_input['isbn'] = filter_isbn($isbn);
             

            // TODO implement book_search() (rename?)
            $rows = book_search($filtered_input);
        }

        else if (!empty($_POST['title']) || !empty($_POST['author']))
        {
            // TODO implement filter_title()
            $filtered_input['title'] = filter_title($_POST['title']);

            // TODO implement filter_author (can these be the same??)
            $filtered_input['author'] = filter_author($_POST['author']);

            $rows = book_search($filtered_input);
        }

        else 
        {
            apologize("please complete at least one field");
        }


        /****************************************/
        /*
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
        */

        render("searchtable.php", ["rows" => $rows, "title" => "search"]);
    }    
    
    
?>
