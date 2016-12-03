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
            $filtered_input['isbn'] = filter_isbn($_POST['isbn']);          
        }
        else if (!empty($_POST['title']) || !empty($_POST['author']))
        {
            $filtered_input['title'] = filter_searchstr($_POST['title']);

            $filtered_input['author'] = filter_searchstr($_POST['author']);
        }
        else 
        {
            apologize("please complete at least one field");
        }

        $rows;
        // TODO: come back to this shite below
        try 
        {
            $rows = book_search($filtered_input);
        }
        catch (Exception $e)
        {
            apologize("unable to find book");
        }

        if ($rows === false)
        {
            apologize("something went wrong searching database");
        }
        else
        {
            render("searchtable.php", ["rows" => $rows, "title" => "search"]);
        }    

    }    
    
?>
