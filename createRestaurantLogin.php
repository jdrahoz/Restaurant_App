<?php
    session_start ();
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Log In</title>

        <!-- bootstrap css -->

        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.6-dist/navbar.css" rel="stylesheet">

        <script type="text/javascript" src="functions.js"></script>

    </head>

    <body>

        <!-- navbar -->

        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <!-- title -->

                    <div class="navbar-header">
                        <a class='navbar-brand' href="restaurantApp.html">RestaurantApp</a>
                    </div>

                    <!-- links -->

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="login.php">Log In</a></li>
                            <li class="active"><a href="createRestaurantLogin.php">Join</a></li>
                            <li><a href="https://github.com/jdrahoz/Restaurant_App">About</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <!-- text fields -->

        <div class="container">

            <div class="jumbotron">

                <!-- header-->

                <div class="page-header">
                    <h2>Add your restaurant!</h2>
                    <p>Enter your restaurant name, username, and a password.</p>
                </div>

                <form onsubmit="return checkForm(this)" action="createRestaurantLogin.php" id="add" method = "post">

                <div class="row">
                    <div class="col-md-2">Restaurant Name</div>
                    <div class="col-md-2"><input type="text" name="restaurant" required></div>
                </div>

                <div class="row">
                    <div class="col-md-2">Username</div>
                    <div class="col-md-2"><input type="text" name="username" required></div>
                </div>

                <div class="row">
                    <div class="col-md-2">Password</div>
                    <div class="col-md-2"><input type="text" name="password" required></div>
                </div>

                <br>

                <!-- submit button -->

                <div class="row">
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-lg btn-primary btn" value="Join">
                    </div>
                </div>

                </form>

                <hr>

                <!-- redirect link -->

                <div class="row">
                    <div class="col-md-2 pull-right"><a href="login.php" class="btn btn-lg btn-primary">Log In</a></div>
                    <div class="col-md-2 pull-right"><p>Already joined?</p></div>
                </div>

                <?php

                    if(isset($_POST["restaurant"]) && isset($_POST["username"]) && isset($_POST["password"])){

                        // need to 'salt' hash
                        $options = ['cost' => 11,];

                        // get info from MenuAlteration.html
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

                        // hash the password to store into database
                        $hashed = password_hash($password, PASSWORD_BCRYPT, $options);

                        // open connection to sql
                        $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                        // check connection
                        if ($mysqli->connect_errno)
                        {
                            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
                            exit();
                        }

                        // check table for name
                        $select = "SELECT * FROM Restaurants WHERE Username = '$username'";
                        $result = $mysqli -> query($select);

                        // name is in table
                        if($result -> num_rows != 0)
                        {
                            echo "<hr><p>Username already in use.</p>";
                        }

                        // ok to add
                        else
                        {
                    	    //add to table
                    	    $mysqli -> query ("INSERT INTO Restaurants (RestaurantName,Username,Password) VALUES ('$restaurantName','$username','$hashed')");


                        // create username_maintenance table

                        //get table name
                        $table_name = $username."_Maintenance";
                        // check to see if a table exists already
                        $show = "SHOW TABLES LIKE '$table_name'";
                        $result = $mysqli -> query ($show);

                        // if table doesn't exist create new
                        if ($result -> num_rows == 0)
                        {
                          $create = "CREATE TABLE $table_name (Description varchar(500), NumberOfTables int(11), Subcategory1 varchar(100), Subcategory2 varchar(100), Subcategory3 varchar(100), Subcategory4 varchar(100), Subcategory5 varchar(100),Subcategory6 varchar(100),Subcategory7 varchar(100),Subcategory8 varchar(100),Subcategory9 varchar(100),Subcategory10 varchar(100),IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
                          $result = $mysqli -> query ($create);
                        }

                        // create username_menu table

                        // get table name
                        $table_name = $username."_Menu";

                        //check to see if a table exists already
                        $show = "SHOW TABLES LIKE '$table_name'";
                        $result = $mysqli -> query ($show);

                        // make image directory
                        mkdir ("uploads/$username", 0777, true);

                        // if table doesn't exist create new
                        if ($result -> num_rows == 0)
                        {
                          $create = "CREATE TABLE $table_name (Name varchar(250), Ingredients varchar(250), Price double, Subcategory varchar(100) NULL, Image varchar(100) NULL, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
                          $result = $mysqli -> query ($create);
                        }

                        // create username_orderstocook table

                        // get table name
                        $table_name = $username."_OrdersToCook";

                        // check to see if a table exists already
                        $show = "SHOW TABLES LIKE '$table_name'";
                        $result = $mysqli -> query ($show);

                        // if table doesn't exist create new
                        if ($result -> num_rows == 0)
                        {
                          $create = "CREATE TABLE $table_name (Item varchar(250), TableNum int(11), Alterations varchar(250) NULL, Price double, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
                          $result = $mysqli -> query ($create);
                        }

                        // create username_accounting table

                        // get table name
                        $table_name = $username."_Accounting";

                        // check to see if a table exists already
                        $show = "SHOW TABLES LIKE '$table_name'";
                        $result = $mysqli -> query ($show);

                        // if table doesn't exist create new
                        if ($result -> num_rows == 0)
                        {
                          $create = "CREATE TABLE $table_name (Item varchar(50), TableNum int(11), Alterations varchar(250) NULL, Price double, Tax double,theTime TIMESTAMP DEFAULT NOW(), IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
                          $result = $mysqli -> query ($create);
                        }

                        echo "<hr><p>Login created!</p>";
                        $_SESSION['login'] = $username;
                        header("Location:adminFrontPage.php");
                        }

                      //close sql connection
                       $mysqli->close();
                    }
                ?>

            </div>
        </div>

    </body>

</html>
