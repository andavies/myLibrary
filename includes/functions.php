<?php

    require_once("constants.php");
    require_once("credentials.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
        exit;
    }

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Lookup function to return book data from googlebooks api
       TODO The layout of the stdclass object that is returned by the googlebooks api
       is different for *some books, so more rigourous error checking is needed for next version
     */
    function lookup($isbn)
    {
        // isbn parameter passed has already been filtered by addbook.php
        $filtered_input = array();
        $filtered_input['isbn'] = $isbn;

        $escaped_output = array();
        $escaped_output['isbn'] = urlencode($filtered_input['isbn']);

        $return_string = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:'
                                  .$escaped_output['isbn']);
        $json = json_decode($return_string);
        $book = $json -> items[0] -> volumeInfo;

        // json decode returns null if invalid json string passed
        // count() returns 0 is passed null
        if (count($json) == 0 || $json->totalItems == 0)
        {
            return false;
        }
        else if (!isset($book -> title) || !isset($book -> description)
                 || !isset($book -> imageLinks -> smallThumbnail))
        {
            return false;
        }
        else if (!isset($book -> authors[0]))
        {
            $book -> authors[0] = "not listed";           
        }
        
        $filtered_input['book_data'] = $book; 

        return $filtered_input['book_data'];     
        
    }
    

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters (if any)
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }


        // prepare SQL statement
        // PDO:prepare() and PDOStatement::execute() handles escaping for us
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    /**
     * Filters isbn value submitted by the user
     */
    function filter_isbn($isbn)
    {
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
            return $isbn;
        }
    }


    /**
     * Filters a simple search string entered by the user
     */
    function filter_searchstr($title)
    {
        if (strlen($title) > SEARCHSTR_MAXLEN)
        {
            $title = substr($title, 0, SEARCHSTR_MAXLEN - 1);
        }

        return $title;
    }


    /**
     * Takes an array in form:
       [
            'isbn' => 'value',
            'title' => 'value,
            'author' => 'value'
       ]
     * returns array of rows from the DB
     */
    function book_search($search_array)
    {
        // note: escaping is handled by query()

        $rows;

        if ($search_array['isbn'] !== null)
        {
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND isbn=?",
                           $_SESSION["id"], $search_array['isbn']);
        }
        else if ($search_array['title'] !== null)
        {
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND title LIKE ? ",
                           $_SESSION["id"], '%'. $search_array['title'] .'%');
        }
        else if ($search_array['author'] !== null)
        {
            $rows = query("SELECT * FROM books WHERE ownerid!=? AND author LIKE ? ",
                           $_SESSION["id"], '%'. $search_array['author'] .'%');
        }
        else
        {
            throw new Exception("all input fields are null");
        }

        return $rows;

    }

?>
