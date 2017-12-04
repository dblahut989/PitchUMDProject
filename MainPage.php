<?php

    include 'PostObject.php';
    require_once "LoginInfo.php";
    require_once "dbLogin.php";

    session_start();
    
    // get the username of the user that signed in
    if (isset($_SESSION['name'])){
        $current_user = $_SESSION['name'];
    }

    $sortBy = "";
    $searchFor = "";
    $filter = "";
    $noData = false;

    # call to function which creates the html header with whatever title is passed
    $page = post::getHeader("Main Page");

    // if the user wants to edit the post, we will send the post id to the edit post page
    if (isset($_POST['EditPost'])){
       $_SESSION['editID'] = $_POST['ID'];
       header('Location: editPost.php');
    }

    // connect to the database
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
          die($db_connection->connect_error);
    }

    // if the user has submitted a comment, then it should be added to the comments in the database
    if (isset($_POST['SubmitComment'])){

        // ok it doesn't like apostrophes for some reason
        // the comment to be added
        $newComment = $_POST['NewComment'];

        // the comments which currently exist for the post
        $oldComments = $_POST['Comments'];

     	//
        if ($oldComments !== ""){
            $oldComments .= "|";
        }

        $addComments = $oldComments .$current_user.": ".$newComment;
        // the id # of the post (its the only unique feature o the )
        $id = $_POST['ID'];
        $query = "update posts set comments=\"$addComments\" where id= '$id'";

        $result = $db_connection->query($query);
        if (!$result) {
            die("Update failed: " . $db_connection->error);
        } 
    }

    // if the user has submitted a comment, then it should be added to the comments in the database
    if (isset($_POST['Voting'])){

        // the comment to be added
        $num_votes = $_POST['NumVotes'];
        // the comments which currently exist for the post, in serialized form
        $num_votes++;
        
        // the id # of the post (its the only unique feature o the )
        $id = $_POST['ID'];
        $query = "update posts set votes=$num_votes where id= '$id'";

        $result = $db_connection->query($query);
        if (!$result) {
            die("Update failed: " . $db_connection->error);
        } 
    }

    // if the user wants to search for something 
    if (isset($_POST['SortData'])){

        $sortBy = $_POST['sortBy'];
        $searchFor = $_POST['searchFor'];
        $filter = $_POST['filter'];

        if ($searchFor == "None"){

            $query = "select * from posts order by $sortBy";

        } else{

            if ($filter){

                if (gettype($searchFor) === "string"){
                    $query = "select * from posts where $searchFor = '$filter' order by $sortBy";
                }else{
                    $query = "select * from posts where $searchFor = $filter order by $sortBy";
                }

            } else{
                $query = "select $searchFor from posts order by $sortBy";
            }

        }

    } else{
        // if the user does not specify what to sort by or search for
        $query = "select * from posts order by date desc";
    }


    $result = $db_connection->query($query);
    if (!$result) {
        die("Extraction failed: " . $db_connection->error);
    } 

    # Closing connection 
    $db_connection->close();

    $post_array = [];

    // extract all the rows in the DB and put them into an array
    $num_rows = $result->num_rows;
    for ($i = 0; $i < $num_rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if (is_null($row['comments'])){
        	$sendCom = "";
        }else{
        	$sendCom = $row['comments'];
        }

        // I think its here that it fucks up, somewhere around here
        $post_obj = new post($row['user'],$row['category'],$row['description'], $row['title'], $row['date'], $row['votes'], $sendCom, $row['id']);
       
        $post_array[] = $post_obj;
    }

    // if there is no data
    if ($num_rows == 0){
        $noData = true;
    }

    # setting the body of the html
    $page .= <<<BODY
            <body><br>
                <h1 class="display-3 text-center"> Pitch Your Ideas! </h1><br><br>
                <div class="container">
                    <div class = "row m-0">
                        <div class ="col-xs-4 col-md-3" id="left section">
	                        <form action="createPost.html"><br>
	                        <strong><em>Create a Post!</em></strong><br><br>
	                        <input type="submit" value="Create Post">
	                        </form><br><br>
                            <img src="images/FlowerM.jpg" alt="not found" width="250" height="300"><br><br>
                            <img src="images/melo.jpg" alt="not found" width="250" height="300"><br><br>
                            <img src="images/testFoot.jpg" alt="not found" width="250" height="300"><br><br>
                            <img src="images/jousting.jpg" alt="not found" width="250" height="300"><br><br>
                            <img src="images/mall.jpg" alt="not found" width="250" height="300"><br><br>
                        </div>
                        <div class ="col-xs-4 col-md-6" id="middle section">
BODY;

    if ($noData){
        $page .= "No posts found.";
    }

    // load the post objects in to the HTML
    foreach($post_array as $post_elem){
        $page .= $post_elem->getPostHTML($current_user);
        $page .= "<br>";
    } 

    $page .= <<<BOTTOM
            </div>
            <div class ="col-xs-4 col-md-3" id="right section">
                            <form action="MainPage.php" method="post">
                                            <br><strong><em>Search or Sort Posts</em></strong>
                                            <table>
                                            <tr><td><br><strong>Search By: </strong><br>
                                            <select name="searchFor">
                                              <option value="None"></option>
                                              <option value="User">User</option>
                                              <option value="Category">Category</option>
                                              <option value="Title">Title</option>
                                            </select></td></tr>
                                            <tr><td><br><strong>Search For: </strong><br><input type="text" name="filter" /><br><br></td></tr>
                                            <tr><td><strong>Sort By:</strong><br>
                                            <select name="sortBy">
                                              <option value="date">Date</option>
                                              <option value="user">User</option>
                                              <option value="category">Category</option>
                                              <option value="title">Title</option>
                                              <option value="votes">Votes</option>
                                            </select><br>
                                            <br><input type="submit" name="SortData" value="Submit Request"></td></tr></table>
                                        </form><br><br><br><br><br><br>
                                        <img src="images/football.jpg" alt="not found" width="250" height="300"><br><br>
                                        <img src="images/testudoBasketball.jpg" alt="not found" width="250" height="300"><br><br>
                                        <img src="images/wball.jpg" alt="not found" width="250" height="300"><br><br>
                                        <img src="images/walkers.jpg" alt="not found" width="250" height="300"><br><br>
                            </div>
                        </div>
                    </div>
            </body>
        </html>

BOTTOM;

    echo $page;

?>