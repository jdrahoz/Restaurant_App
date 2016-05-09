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

// get table name
$tableName = $username . "_Menu";

// get checked items from MenuAlteration.html
$menuArray = $_POST["menu"];

// open sql connection
$mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($mysqli->connect_errno)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}

// delete the rows from Menu table that match in the menuArray
for ($i=0; $i<count($menuArray);$i++)
{
    $delete = "DELETE FROM $tableName WHERE IDNum = '$menuArray[$i]'";
    $mysqli->query($delete);
}

// close sql connection
$mysqli->close();

// redirect to front page
header('Location: menuAlteration.php');

?>
