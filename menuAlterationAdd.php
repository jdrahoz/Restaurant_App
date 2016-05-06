<?php
session_start();
if(!isset($_SESSION['login'])){
    echo "\nMust Log in First.<br>";
    echo "<a href=\"login.php\"><button>LOG IN</button></a>";
    exit();
  }else{
    echo "Welcome, ";
    echo $_SESSION['login'];
  }

  $username=$_SESSION['login'];
?>


<?php

//Grab info from MenuAlteration.html
$Name = $_POST["name"];
$Ingredients = $_POST["ingredients"];
$Price = $_POST["price"];
$Subcategory = $_POST["subcategory"];
$file = $_FILES['image']['tmp_name'];

//gets the contents of the file
//addslashes prevents sql injection
  $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  //File name
  $image_name=addslashes($_FILES['image']['name']);
  //image size of temporary file information (returns false if not an image)
  $image_size=getimagesize($_FILES['image']['tmp_name']);


    //opens connection to sql
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        //if connection to sql fails
        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        $tableName=$username."_Menu";

        //check table for name
      	$select = "SELECT * FROM $tableName WHERE Name = '$Name'";
      	$result = $mysqli -> query($select);
      	//if name is in table
      	if($result -> num_rows != 0)
      	{
      		echo "<p>Name already exists</p>";
      	}
      	//if OK to add
      	else
      	{
      		//add to table
      		$mysqli -> query ("INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$image_name')");
      	}

      //close sql connection
       $mysqli->close();

      //refresh html page
       header('Location: menuAlteration.php');
?>
