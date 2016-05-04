<?php
session_start();
if(!isset($_SESSION['login'])){
    echo "\nMust Log in First.<br>";
    echo "<a href=\"login.html\"><button>LOG IN</button></a>";
    exit();
  }else{
    echo "Welcome, ";
    echo $_SESSION['login'];
  }

  $username=$_SESSION['login'];
  $tableName=$username."_Menu";
//Grab checked items from MenuAlteration.html
 $menuArray = $_POST["menu"];

//opens sql connection
 $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");
     //if sql connection fails
    if ($mysqli->connect_errno)
    {
        echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
        exit();
    }

    //deletes the rows from Menu table that match in the menuArray
    for($i=0; $i<count($menuArray);$i++)
    {
        $delete = "DELETE FROM $tableName WHERE IDNum = '$menuArray[$i]'";
        $mysqli->query($delete);
    }

    //close sql connection
     $mysqli->close();

     //refresh html page
      header('Location: menuAlteration.php');
 ?>
