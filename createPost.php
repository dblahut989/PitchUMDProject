<?php
    include_once('support.php');
    require_once "dbLogin.php";

    if(isset($_POST['backToMain'])) {
        header("Location: http://127.0.0.1/GroupProj/MainPage.php");
    }else if(isset($_POST['submit'])){
        $date = date_create();
        $date = $date->format('Y-m-d');

        $head = "Your idea is posted";

        $db_connection = new mysqli($host, $user, $password, $database);
        if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        }

        session_start();
        $user = "tester";//$SESSION_['name'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['content'];
        $comments="";
        $votes = 0;
        $id = 0; //number will be automatically increased in database unique post id

        $query = "insert into posts values ($id, \"$user\", \"$title\", \"$category\", \"$description\", \"$date\", \"$comments\", $votes)";
        $result = $db_connection->query($query);
        if ($result) {
        } else {
            die("Insertion failed: " . $db_connection->error);
        }
        $db_connection->close();
    } else if(isset($_POST['returnHome'])) {
        header("Location: http://127.0.0.1/GroupProj/MainPage.php");
    }


    $body = <<<EOBODY
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Create Post</title>
            <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
            <script src="createPostValidation.js"></script>
        </head>
        <body>
        <form action="createPost.php" method="post">
            <h1><Strong>$head</Strong></h1>
            <div class="well">
                <Strong>Title: </Strong> {$_POST['title']}
                <div class="text-right">
                    <p><Strong>Date: </Strong> {$date}
                    <Strong>Category: </Strong> {$_POST['category']}</p>  
                </div>                    
            </div>
            <div class="well">
                <Strong>Description:</Strong><br /><br />
                {$_POST['content']}<br />               
            </div>
            <div class="text-right">
                <input type="submit" class="btn-info btn" name="backToMain" value="Back to Main">
            </div>
        </form>
        </body>
        
EOBODY;

# Generating final page
echo generatePage($body);

?>