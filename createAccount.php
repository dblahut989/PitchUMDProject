<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 12/2/17
 * Time: 2:29 PM
 */

session_start();
if($_SESSION["logged_in"] && isset($_POST['createAccountButton'])){
    $dirid = $_SESSION['name'];
    $accounttype = $_POST['accounttype'];

    $imagename = $_FILES["image"]["name"];
    $imagedata = addslashes(file_get_contents($_FILES['image']['tmp_name']));


    $host = "localhost";
    $user = "pitchdbuser";
    $password = "goodbyeWorld";
    $database = "pitchumddb";
    $table = "accounts";
    $db = connectToDB($host, $user, $password, $database);

    $query = "INSERT INTO ".$table." (directoryid, porfilepicname, accounttype) VALUES ";
    $query .= "('{$dirid}', '{$imagename}', '{$accounttype}')";
    /*profilepic,*/
    //'{$imagedata}',
    echo $query;
    //echo $query;

    $result = mysqli_query($db, $query);
    if($result){
        echo "Added ".$imagename;
    } else{
        echo "Failed to add ".$imagename;
    }
}

function connectToDB($host, $user, $password, $database) {
    $db = new mysqli($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
    }
    return $db;
}
?>