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
$username= $_SESSION['login'];

//open connection to sql
$mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($mysqli->connect_errno)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}

// get table name
$tableName=$username."_Menu";
$pop="Popular Item";

// get menu table
$select="SELECT Name FROM $tableName WHERE Subcategory='Popular Item'";
$result = $mysqli -> query($select);

// no popular item set
if($result->num_rows==0)
{
    // get new popular item from accounting table
    $tableName=$username."_Accounting";
    $accountingQuery="SELECT Item FROM $tableName GROUP BY Item ORDER BY COUNT(*) DESC LIMIT 1";
    $result = $mysqli -> query($accountingQuery);
    $row = $result -> fetch_assoc();
    $popularItem = $row["Item"];

    // get info on popular item from menu table
    $tableName=$username."_Menu";
    $select="SELECT * FROM $tableName WHERE Name='$popularItem'";
    $result = $mysqli -> query($select);
    $row = $result -> fetch_assoc();
    $Name=$row['Name'];
    $Ingredients=$row['Ingredients'];
    $Price=$row['Price'];
    $Image=$row['Image'];
    $Subcategory=$pop;

    // insert into menu table
    $insert="INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$Image')";
    $mysqli -> query($insert);

}

// popular item already set
else
{
    // get new popular item from accounting
    $tableName=$username."_Accounting";
    $accountingQuery="SELECT Item FROM $tableName GROUP BY Item ORDER BY COUNT(*) DESC LIMIT 1";
    $result = $mysqli -> query($accountingQuery);
    $row = $result -> fetch_assoc();
    $popularItem = $row["Item"];

    // get info on popular item from menu table
    $tableName=$username."_Menu";
    $select="SELECT * FROM $tableName WHERE Name='$popularItem'";
    $result = $mysqli -> query($select);
    $row = $result -> fetch_assoc();
    $Name = $row['Name'];
    $Ingredients = $row['Ingredients'];
    $Price = $row['Price'];
    $Image = $row['Image'];
    $Subcategory = $pop;

    // delete old popular item
    $delete = "DELETE FROM $tableName WHERE Subcategory='$Subcategory'";
    $mysqli -> query($delete);

    // insert new popular item
    $insert="INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$Image')";
    $mysqli -> query($insert);
}

//close sql connection
$mysqli->close();

// redirect to front page
header('Location: menuAlteration.php');

 ?>
