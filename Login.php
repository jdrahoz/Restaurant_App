<?php

//Grab info from MenuAlteration.html
$username = $_POST["username"];
$password = $_POST["password"];

    //opens connection to sql
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        //if connection to sql fails
        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        //check table for name
      	$select = "SELECT * FROM Restaurants WHERE Username = '$username' AND Password='$password'";
      	$result = $mysqli -> query($select);
      	//if name is in table
      	if($result -> num_rows != 0)
      	{
          header('Location: http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/Homepage.html');

      	}
      	//if OK to add
      	else
      	{
          echo "<p>Login incorrect</p>";
          echo "<a href='http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/Login.html'>Login correctly</a>";
        }

      //close sql connection
       $mysqli->close();

?>
