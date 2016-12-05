<!DOCTYPE html>

<html>

    <head>

        <link href="/myLibrary/public/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/myLibrary/public/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/myLibrary/public/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>myLibrary: <?= $title ?></title>
        <?php else: ?>
            <title>myLibrary</title>
        <?php endif ?>

        <script src="/myLibrary/public/js/jquery-1.11.1.min.js"></script>
        <script src="/myLibrary/public/js/bootstrap.min.js"></script>
        <script src="/myLibrary/public/js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div id="title">
                    <a href="/myLibrary/public">myLibrary</a>
                </div>
                <div id="menu">
                    <a href="mybooks.php">myBooks</a>
                    <a href="addbook.php">+Book</a>
                    <a href="search.php">Search</a>
                    <a href="logout.php">Logout</a>
                </div> 
            </div>

            <div id="middle">
