<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Order</title>

        <!-- bootstrap css -->

        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.6-dist/navbar.css" rel="stylesheet">

    </head>

    <!-- start session -->

    <?php
        session_start ();
        if (!isset ($_SESSION['login'])) {
            echo "<div class='container'><div class='jumbotron'>";
            echo "<h1>Oops!</h1><h2>You're not logged in.</h2>";
            echo "<hr>";
            echo "<a class='btn btn-lg btn-primary' href='login.php' role='button'>Log In</a>";
            echo "</div></div>";
            exit ();
    }
    ?>

    <body>

        <!-- header -->

        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <!-- title -->

                    <div class="navbar-header">

                        <?php
                            // get restaurant
                            $user_name = $_SESSION['login'];

                            // open mysql
                            $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                            // check connection
                            if ($connection === false) {
                                echo "connect failed";
                                exit ();
                            }

                            // get restaurant name
                            $select = "SELECT * FROM Restaurants WHERE Username = '$user_name'";
                            $result = $connection -> query ($select);
                            $row = $result -> fetch_assoc();
                            $rest = $row ["RestaurantName"];

                            // echo restaurant name
                            echo "<a class='navbar-brand'>$rest</a>";

                            // close mysql
                            $connection -> close ();
                        ?>

                    </div>

                    <!-- where you are -->

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a>Welcome</a></li>
                            <li class=active><a>Order</a></li>
                            <li><a>Confirm</a></li>
                            <li><a>Enjoy</a></li>
                            <li><a>Pay</a></li>
                            <li><a>Thanks</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <!-- menu -->

        <div class="container">

            <!-- form -->

            <form action="yourOrder.php" method="post" id="form">

            <!-- heading -->

            <div class="page-header">
                <h1>the Menu</h1>
            </div>

            <!-- table num -->

            <?php

                // session table number not set
                if ($_SESSION['table_num'] == 0) {

                    // open mysql
                    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($connection === false) {
                        echo "connect failed";
                        exit ();
                    }

                    // variables
                    $user_name = $_SESSION['login'];
                    $maint_table_name = $user_name . "_Maintenance";

            		// get table of menu items
            		$select = "SELECT * FROM $maint_table_name";
            		$result = $connection -> query ($select);

                    // get number of tables
                    $select = "SELECT * FROM $maint_table_name";
                    $result = $connection -> query ($select);
                    $row = $result -> fetch_assoc();
                    $num_tables = $row ["NumberOfTables"];

                    // input table number
                    if ($num_tables == 0) {
                        echo "<h3>Table: <input type='number' name='table_num' value=1 min=1 max=10></h3>";
                    } else {
                        echo "<h3>Table: <input type='number' name='table_num' value=1 min=1 max=$num_tables></h3>";
                    }

                    // close mysql
                    $connection -> close ();

                // session table number already set
                } else {
                    echo "<h3>Table: " . $_SESSION['table_num'] . "</h3>";
                }

            ?>

            <hr>

            <!-- menu items -->

            <?php

                // open mysql
                $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                // check connection
                if ($connection === false) {
                	echo "connect failed";
                	exit ();
                }

        		// variables
                $user_name = $_SESSION['login'];
                $menu_table_name = $user_name . "_Menu";

        		// get subcategories from menu
        		$select = "SELECT * FROM $menu_table_name";
        		$result = $connection -> query ($select);
        		$num = $result -> num_rows;
        		$subs = array ();

        		// get array of subcategories
        		for ($i = 0; $i < $num; $i++) {
        			$row = $result -> fetch_assoc ();
        			$sub = $row ["Subcategory"];
        			// check if subcategory already in array
        			$subs_length = count ($subs);
        			if (in_array ($sub, $subs) == false) {
        				$subs[] = $sub;
        			}
        		}

        		// display table of subcategories
        		$subs_length = count ($subs);
        		for ($i = 0; $i < $subs_length; $i++) {

                    // echo subcategory
        			$sub = $subs[$i];
        			echo "<h3>" . $sub . "</h3>";

        			// get table of menu items
        			$select = "SELECT * FROM $menu_table_name WHERE Subcategory = '$sub'";
        			$result = $connection -> query ($select);
        			$num = $result -> num_rows;

        			// print table
        			for ($j = 0; $j < $num; $j++) {

                        // variables
        				$row = $result -> fetch_assoc ();
        				$item = $row ["Name"];
        				$ingredients = $row ["Ingredients"];
        				$price = $row ["Price"];
        	      $idNum = $row ["IDNum"];
                $image = $row ["Image"];

        	            // echo row
        				echo "<div class='row'>";
        	            echo "<div class='col-md-3'>" . $item . "</div>";
        				echo "<div class='col-md-3'>" . $ingredients . "</div>";
        				echo "<div class='col-md-2'>$" . $price . "</div>";
        				echo "<div class='col-md-2'><input type='number' name=$idNum value=0 min=0 max=10></div>";
                        echo "<div class='col-md-2'><img src='$image' height='100' width='100'></div>";
        				echo "</div>";

        			}

                    echo "<hr>";

        		}

        		// close mysql
        		$connection -> close ();

            ?>

            <!--  submit button -->

            <input type="submit" class="btn btn-lg btn-primary" value="Send to Cart">

            </form>

        </div>

        <!-- bootstrap js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    </body>

</html>
