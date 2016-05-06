<html>
 <head>
  <title>Create User</title>
  <script type="text/javascript" src="functions.js"></script>
  <?php
  session_start();
  ?>

 </head>
 <body>

   <form onsubmit="return checkForm(this)" action="createRestaurantLogin.php" id="add" method = "post">
        Restaurant: <input type="text" name="restaurant" required><br>
        Username:   <input type="text" name="username" required><br>
        Password:   <input type="text" name="password" required><br>
        <button type="submit"><b>SUBMIT</b></button>
   </form>

   Or Log In Here <a href="login.php"><button>Log In</button></a>

 </body>
</html>

<?php

if(isset($_POST["restaurant"]) && isset($_POST["username"]) && isset($_POST["password"])){

  //need to 'salt' the hash. The higher the cost, the stronger it is encrypted but more computationally
  //    expensive to encrypt/decrypt
  $options = [
    'cost' => 11,
  ];

  //Grab info from MenuAlteration.html
  $username = $_POST["username"];
  $password = $_POST["password"];
  $restaurantName = $_POST["restaurant"];

  function force_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $username = force_input($username);
  $password = force_input($password);
  $restaurantName = force_input($restaurantName);
  $accepted = false;

  //built in functions to hash the password to store into database
  $hashed = password_hash($password, PASSWORD_BCRYPT, $options);

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

  }
  //if OK to add
  else
  {
  	//add to table
  	$mysqli -> query ("INSERT INTO Restaurants (RestaurantName,Username,Password) VALUES ('$restaurantName','$username','$hashed')");


    /****CREATE RESTAURANTNAME_MAINTENANCE TABLE******/
    //creates table name
    $table_name = $username."_Maintenance";
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
    $table_name = $username."_Menu";
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
    $table_name = $username."_OrdersToCook";
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
    $table_name = $username."_Accounting";
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


    echo '<p>"Login created!"</p>';
    $_SESSION['login'] = $username;
    header("Location:adminFrontPage.php");
    }

  //close sql connection
   $mysqli->close();
}
?>
