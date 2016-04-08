<?php

//Grab info from MenuAlteration.html
$Name = $_POST["name"];
$Ingredients = $_POST["ingredients"];
$Price = $_POST["price"];

    //opens connection to sql
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        //if connection to sql fails
        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        //check table for name
      	$select = "SELECT * FROM Menu WHERE Name = '$Name'";
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
      		$mysqli -> query ("INSERT INTO Menu (Name,Ingredients,Price) VALUES ('$Name','$Ingredients','$Price')");
      	}

      //close sql connection
       $mysqli->close();

      //refresh html page
       header('Location: http://people.eecs.ku.edu/~jdrahoza/subdir/eecs448/proj03/MenuAlteration.html');
?>
