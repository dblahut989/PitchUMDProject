<?php
/**
 * Created by PhpStorm.
 * User: goshu
 * Date: 12/2/2017
 * Time: 2:27 PM
 */
include_once('support.php');
require_once "dbLogin.php";

    session_start();

    $id=$_SESSION['editID'];

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }

    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = $db_connection->query($sql);
    $row = $result->fetch_assoc();

    //from the database with unique post id
    $title = $row["title"];
    $description= $row["description"];
    $category = $row["category"];

    if(isset($_POST['post'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        $sql = "UPDATE posts SET title=\"$title\", description=\"$description\", category=\"$category\" WHERE id=$id";
        $result = $db_connection->query($sql);
        if ($result) {
            header("Location: MainPage.php");
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
        <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
        <script src="createPostValidation.js"></script>
    </head>
    <body>
        <form action="editPost.php" method="post">
            <div class="well">
                <Strong>Titile: </Strong><input type="text" name="title" id="title" size="50" value=$title>
                <Strong>Category: </Strong>                    
                <select name="category">
                    if($category == Cate1) {
                        <option value=cate1 selected="selected">Cate1</option>
                    }else if($category == Cate2) {
                        <option value=cate2 selected="selected">Cate2</option>
                    }else {
                        <option value=cate3 selected="selected">Cate3</option>
                    }                           
                </select><br />                
            </div>
            <div class="well">
                <Strong>Description:</Strong><br /><br />
                <textarea class="form-control" name="description" rows="12" id ="content">$description</textarea><br /><br />
                <div class="text-right">
                    <input class="btn-info btn" type="submit" name="post" value="Posting">
                </div>               
            </div>
        </form>
    </body>
    </html>
EOBODY;
$page = generatePage($body, "edit post");
echo $page;

?>