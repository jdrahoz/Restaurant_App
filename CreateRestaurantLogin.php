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

          //make restaurantName have no spaces
          $restaurantName = preg_replace('/\s+/','',$restaurantName);

          /****CREATE RESTAURANTNAME_MAINTENANCE TABLE******/
          //creates table name
          $table_name = $restaurantName."_Maintenance";
          //checks to see if a table exists already
          $show = "SHOW TABLES LIKE '$table_name'";
          $result = $mysqli -> query ($show);

          //if table doesn't exist create new
          if ($result -> num_rows == 0)
          {
            //Create new table based on table number
            $create = "CREATE TABLE $table_name (Description varchar(500), NumberOfTables int(11), Subcategory1 varchar(100), Subcategory2 varchar(100), Subcategory3 varchar(100), Subcategory4 varchar(100), Subcategory5 varchar(100),Subcategory6 varchar(100),Subcategory7 varchar(100),Subcategory8 varchar(100),Subcategory9 varchar(100),Subcategory10 varchar(100),IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
            $result = $mysqli -> query ($create);
          }

          /****CREATE RESTAURANTNAME_MENU TABLE******/
          //creates table name
          $table_name = $restaurantName."_Menu";
          //checks to see if a table exists already
          $show = "SHOW TABLES LIKE '$table_name'";
          $result = $mysqli -> query ($show);

          //if table doesn't exist create new
          if ($result -> num_rows == 0)
          {
            //Create new table based on table number
            $create = "CREATE TABLE $table_name (Name varchar(250), Ingredients varchar(250), Price double, Subcategory varchar(100), Image blob NULL, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
            $result = $mysqli -> query ($create);
          }

          /****CREATE RESTAURANTNAME_ORDERSTOCOOK TABLE******/
          //creates table name
          $table_name = $restaurantName."_OrdersToCook";
          //checks to see if a table exists already
          $show = "SHOW TABLES LIKE '$table_name'";
          $result = $mysqli -> query ($show);

          //if table doesn't exist create new
          if ($result -> num_rows == 0)
          {
            //Create new table based on table number
            $create = "CREATE TABLE $table_name (Item varchar(250), TableNum int(11), Alterations varchar(250) NULL, Price double, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
            $result = $mysqli -> query ($create);
          }

          /****CREATE RESTAURANTNAME_ACCOUNTING TABLE******/
          //creates table name
          $table_name = $restaurantName."_Accounting";
          //checks to see if a table exists already
          $show = "SHOW TABLES LIKE '$table_name'";
          $result = $mysqli -> query ($show);

          //if table doesn't exist create new
          if ($result -> num_rows == 0)
          {
            //Create new table based on table number
            $create = "CREATE TABLE $table_name (Item varchar(50), TableNum int(11), Alterations varchar(250) NULL, Price double, Tax double,theTime TIMESTAMP DEFAULT NOW(), IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
            $result = $mysqli -> query ($create);
          }
          else {
            echo "Nope";
          }



        }

      //close sql connection
       $mysqli->close();

?>
