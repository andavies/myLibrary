<!DOCTYPE html>

<html>

    <head>
        <meta charset="UTF-8">

        <link href="/public/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/public/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/public/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>myLibrary: <?= $title ?></title>
        <?php else: ?>
            <title>myLibrary</title>
        <?php endif ?>

        <script src="/public/js/jquery-1.11.1.min.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>
        <script src="/public/js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div id="title">
                    <a href="/public">myLibrary</a>
                </div>
                <div id="menu">
                    <a href="mybooks.php">myBooks</a>
                    <a href="addbook.php">+Book</a>
                    <a href="search.php">Search</a>
                    <a href="logout.php">Logout</a>
                </div> 
            </div>

            <div id="middle">
