<?php
    include_once('support.php');
    require_once "dbLogin.php";

    session_start();

    if(isset($_POST['backToMain'])) {
        header('Location: MainPage.php');
    } else {
        $date = date_create();
        $date2 = date_timestamp_get($date);
        
        $date = $date->format('Y-m-d');

        $head = "Your idea is posted";

        $db_connection = new mysqli($host, $user, $password, $database);
    
     if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        }

        $user = $_SESSION['name'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['content'];
        $comments = "";
        $votes = 0;
        $id = 0; //number will be automatically increased in database unique post id

        $query = "insert into posts values ($id, \"$user\", \"$title\", \"$category\", \"$description\", \"$date2\", \"$comments\", $votes)";
        $result = $db_connection->query($query);
        if ($result) {
        } else {
            die("Insertion failed: " . $db_connection->error);
        }

        $db_connection->close();
    }

    $body = <<<EOBODY
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Create Post</title>
            <link rel="stylesheet" href="createPost.css">
            <script src="createPostValidation.js"></script>
        </head>
        <body>
        <form action="createPost.php" method="post">
            <h1><Strong>$head</Strong></h1>
            <fieldset>
                <Strong>Title: </Strong> {$_POST['title']}
                <p style="float: right;"><Strong>Date: </Strong> {$date}</p>
                <p style="float: right; margin-right:10px;"><Strong>Category: </Strong> {$_POST['category']}</p>        
            </fieldset><br />
            <fieldset>
                <Strong>Description:</Strong><br /><br />
                {$_POST['content']}
            </fieldset><br />
            <input type="submit" name="backToMain" value="Back to Main">
        </form>
        </body>
        
EOBODY;

# Generating final page
echo generatePage($body);






?>
