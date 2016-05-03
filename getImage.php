<?php

   //connect to database
   $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

 if ($mysqli->connect_errno)
 {
   echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
   exit();
 }

$id = addslashes($_REQUEST['id']);

$select = "SELECT * FROM Menu WHERE ID=$id";
$result = $mysqli -> query($select);
$row = $result -> fetch_assoc();
$image = $row["Image"];

header("Content-type: image/jpeg");

echo $image;

$mysqli->close();

?>
