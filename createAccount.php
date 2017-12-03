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

    $query = "insert into $table (directoryid, profilepicname, profilepic, accounttype) values ";
    $query .= "('{$dirid}', '{$imagename}', '{$imagedata}', '{$accounttype}')";

    //profilepic,
    //{$imagedata},
    //echo $query;

    $result = mysqli_query($db,$query) or trigger_error(mysqli_error($db)." ".$query);
    if($result){
        echo "<h1>Thank you! Account creation successful. </h1> <br> <h1> You will be redirected to the homepage momentarily.</h1>";
        echo "<script>setTimeout(\"location.href = 'MainPage.php';\",1500);</script>";
    } else{
        echo "Failed to add ".$imagename." please try again.";
        echo "<script>setTimeout(\"location.href = 'createAccount.html';\",1500);</script>";
    }
} else {
    header("Location:login.html");
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
