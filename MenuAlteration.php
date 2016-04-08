<?php

$menuArray = $_POST["menu"];
$Name = $_POST["name"];
$Ingredients = $_POST["ingredients"];
$Price = $_POST["price"];


     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        #check table for username
      	$select = "SELECT * FROM Menu WHERE Name = '$Name'";
      	$result = $mysqli -> query($select);
      	#if username is not in table
      	if($result -> num_rows != 0)
      	{
      		echo "<p>Name already exists</p>";
      	}
      	#if OK to add
      	else
      	{
      		#add to table
      		$mysqli -> query ("INSERT INTO Menu (Name,Ingredients,Price) VALUES ('$Name','$Ingredients','$Price')");
      	}


        for($i=0; $i<count($menuArray);$i++)
        {
            $delete = "DELETE FROM Menu WHERE IDNum = '$menuArray[$i]'";
            $mysqli->query($delete);
        }

       $mysqli->close();

       header('Location: http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/MenuAlteration.html');
?>
