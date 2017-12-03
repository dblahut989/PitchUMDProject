<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 12/2/17
 * Time: 1:35 PM
 * Largely based on the ldapConnection example presented in class by Professor Nelson Padua-Perez
 */

/* You need to update http.conf file so the ldap module is loaded */
/* Entry in http.conf: LoadModule ldap_module modules/mod_ldap.so */

$login_nm = $_POST["directoryid"];
$login_passwd = $_POST["password"];

/* Establish a connection to the LDAP server */
$ldapconn=ldap_connect("ldap://ldap.umd.edu/",389) or die('Could not connect<br>');
// $ldapconn=ldap_connect("ldaps://ldap.umd.edu/",389) or die('Could not connect<br>');

/* Set the protocol version to 3 (unless set to 3 by default) */
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

/* Bind user to LDAP with password */
$verify_user=ldap_bind($ldapconn,"uid=$login_nm,ou=people,dc=umd,dc=edu",$login_passwd);

/* Returns 1 on Success */
if ($verify_user != 1) {
    /* Failed */
    echo "<h1>Invalid directoryId/password.</h1><br><h2>You will be redirect to the login page momentarily.</h2>";
    echo "<script>setTimeout(\"location.href = 'login.html';\",2500);</script>";
} else {
    /* Success */
    //Check if user has an entry in the database or not
    $host = "localhost";
    $user = "pitchdbuser";
    $password = "goodbyeWorld";
    $database = "pitchumddb";
    $table = "accounts";
    $query = "SELECT 'directoryid' FROM ".$table." WHERE directoryid = '$login_nm'";

    $db = connectToDB($host, $user, $password, $database);
    $result = mysqli_query($db, $query);

    if(mysqli_num_rows($result) == 0){
        //account does not yet exist, bring user to set up account page
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['name'] = $login_nm;
        header('Location: createAccount.html');
    } else {
        //account already exists, set session up and bring to home page
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['name'] = $login_nm;
        header('Location: homepage.html');
    }

    mysqli_close($db);
}


function connectToDB($host, $user, $password, $database) {
    $db = new mysqli($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
    }
    return $db;
}

// Release connection
ldap_unbind($ldapconn);
?>
