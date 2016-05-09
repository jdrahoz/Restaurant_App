<?php

// start session
session_start ();
if (!isset ($_SESSION['login'])) {
    echo "<div class='container'><div class='jumbotron'>";
    echo "<h1>Oops!</h1><h2>You're not logged in.</h2>";
    echo "<hr>";
    echo "<a class='btn btn-lg btn-primary' href='login.php' role='button'>Log In</a>";
    echo "</div></div>";
    exit ();
}

// get username
$username = $_SESSION['login'];

// get info from maintenanceFront.php
$Description = $_POST['description'];
$NumberOfTables = $_POST ["numtables"];
$Sub1 = $_POST["Sub1"];
$Sub2 = $_POST ["Sub2"];
$Sub3 = $_POST ["Sub3"];
$Sub4 = $_POST ["Sub4"];
$Sub5 = $_POST ["Sub5"];
$Sub6 = $_POST ["Sub6"];
$Sub7 = $_POST ["Sub7"];
$Sub8 = $_POST ["Sub8"];
$Sub9 = $_POST ["Sub9"];
$Sub10 = $_POST ["Sub10"];

// open mysql
$mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($mysqli -> connect_errno)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}

// get table name
$tableName = $username . "_Maintenance";

// delete all rows
$truncate = "TRUNCATE $tableName";
$mysqli -> query ($truncate);

// add updated information
$insert="INSERT $tableName (Description, NumberOfTables, Subcategory1, Subcategory2, Subcategory3, Subcategory4, Subcategory5, Subcategory6, Subcategory7, Subcategory8, Subcategory9, Subcategory10) VALUES ('$Description', '$NumberOfTables', '$Sub1', '$Sub2', '$Sub3', '$Sub4', '$Sub5', '$Sub6', '$Sub7', '$Sub8', '$Sub9', '$Sub10')";
$mysqli -> query ($insert);

// close sql connection
$mysqli->close();

// redirect to maintenance front
 header('Location: maintenanceFront.php');

?>
