<?php

//Grab info from MenuAlteration.html
$username = $_POST["username"];
$password = $_POST["password"];
$restaurantName = $_POST["restaurant"];

    //opens connection to sql
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        //if connection to sql fails
        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        //check table for name
      	$select = "SELECT * FROM Restaurants WHERE Username = '$username'";
      	$result = $mysqli -> query($select);
      	//if name is in table
      	if($result -> num_rows != 0)
      	{
          echo '<p>Username duplicate, your login was not created</p><br>';
          echo "<a href='http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/CreateRestaurantLogin.html'>Click here to create login</a>";

      	}
      	//if OK to add
      	else
      	{
      		//add to table
      		$mysqli -> query ("INSERT INTO Restaurants (RestaurantName,Username,Password) VALUES ('$restaurantName','$username','$password')");
          echo '<p>"Login created!"</p>';
          echo '<a href="http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/Login.html"> Click here to login</a>';
        }

      //close sql connection
       $mysqli->close();

?>
