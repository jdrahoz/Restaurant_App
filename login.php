<?php
session_start();
//Grab info from MenuAlteration.html
$username = $_POST["username"];
$password = $_POST["password"];
$accepted = false;

function force_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$username = force_input($username);
$password = force_input($password);

//opens connection to sql
 $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

//if connection to sql fails
if ($mysqli == false)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}
//check table for name
$select = "SELECT Password FROM Restaurants WHERE Username = '$username' LIMIT 1";
$result = $mysqli -> query($select);
//if name is in table
if($result -> num_rows == 0)
{
  echo "User Does Not Exist";
}
else{
  $row = $result -> fetch_assoc();
  $passFromData = $row["Password"];
  if(password_verify($password,$passFromData) == true)
  {
    $accepted = true;
  }
  else{
    echo "Invalid username/password.";
    echo "<a href='login.html'>Try Again</a>";
    exit();
  }
}
/*
echo "<br><br><br>Starting Second Query<br>";
$select = "SELECT RestaurantName FROM Restaurants WHERE Username = '$username'";
$result = $mysql -> query($select);

echo "Query complete<br>";
echo $resultRestaurant->num_rows . "<br>";

$rowName = $resultRestaurant -> fetch_assoc();
$name = $rowName["RestuarantName"];

$conn -> close();
*/
if($accepted)
{
  $_SESSION['login'] = $username;
  header("Location:adminFrontPage.php");
}



?>