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
$tableName = $username . "_OrdersToCook";

// get kitchen array from kitchen.html
$kitchen = $_POST["kitchen"];

//opens sql connection
$mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($mysqli->connect_errno)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}

// loop through kitchen array
for ($i=0; $i < count ($kitchen); $i++)
{
    // select from Orders to Cook using kitchen array
    $checkTableNum = "SELECT TableNum From $tableName WHERE IDNum = '$kitchen[$i]'";
    $result = $mysqli -> query($checkTableNum);
    $row = $result -> fetch_assoc ();
    $table_num = $row ["TableNum"];

    // get table name
    $table_name = $username."_Bill_Table_$table_num";

    // check to see if a table exists already
    $show = "SHOW TABLES LIKE '$table_name'";
    $result = $mysqli -> query ($show);
    if ($result -> num_rows == 0)
    {
        // create new table based on table number
        $create = "CREATE TABLE $table_name (Item varchar(50), TableNum int(11), Alterations varchar(250), Price double, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
        $result = $mysqli -> query ($create);
    }

    //select information from OrdersToCook table
    $select ="SELECT Item,TableNum,Alterations,Price FROM $tableName WHERE IDNum='$kitchen[$i]'";
    $result = $mysqli ->  query($select);
    $row = $result -> fetch_assoc();
    $Item = $row["Item"];
    $TableNum = $row["TableNum"];
    $Alterations = $row["Alterations"];
    $Price = $row["Price"];

    // insert information selected into the bill table
    $insert = "INSERT INTO $table_name (Item,TableNum,Alterations,Price) VALUES ('$Item', '$TableNum','$Alterations','$Price')";
    $mysqli -> query($insert);

    // delete information from OrdersToCookTable
    $delete = "DELETE FROM $tableName WHERE IDNum = '$kitchen[$i]'";
    $mysqli->query($delete);
}

//close connection
$mysqli->close();

// redirect to front page
header('Location: kitchenFront.php');
?>
