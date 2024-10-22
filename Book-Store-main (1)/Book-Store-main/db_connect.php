<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "library";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
