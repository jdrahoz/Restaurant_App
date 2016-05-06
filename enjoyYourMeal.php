<?php
    $page = $_SERVER['PHP_SELF'];
    $sec = "60";

    session_start ();
    if (!isset ($_SESSION['login'])) {
    	echo "\nMust Log in First.<br>";
    	echo "<a href=\"login.html\"><button>LOG IN</button></a>";
    	exit ();
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Enjoy!</title>

        <!-- bootstrap css -->
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="navbar.css" rel="stylesheet">

    </head>

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

                            echo "<a class='navbar-brand'>$rest</a>";

							// close mysql
							$connection -> close ();
                        ?>

                    </div>

                    <!-- where you are -->
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a>Welcome</a></li>
                            <li><a>Order</a></li>
                            <li><a>Confirm</a></li>
                            <li class=active><a>Enjoy</a></li>
                            <li><a>Pay</a></li>
                            <li><a>Thanks</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <br>
        <div class="container">
            <div class="jumbotron">

    		<?php

                // get restaurant
                $user_name = $_SESSION['login'];
                // get table number
                $table_num = $_SESSION["table_num"];

                // open mysql
                $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                // check connection
                if ($connection === false) {
                    echo "connect failed";
                    exit ();
                }

                $done = false;
                $ordersToCook_table_name = $user_name . "_OrdersToCook";

                // get kitchen table
                $select = "SELECT * FROM $ordersToCook_table_name WHERE TableNum = $table_num";
                $result = $connection -> query ($select);
                $num = $result -> num_rows;

                // check if there are items still cooking
                if ($num == 0) {
                    $done = true;
                }


                if ($done) {

                    // redirect links
                    echo "<h1>Enjoy Your Meal!</h1>";
                    echo "<br>";
                    echo "<p><a class='btn btn-lg btn-primary' href='menu.php' role='button'>Reorder</a></p>";
                    echo "<p><a class='btn btn-lg btn-primary' href='yourBill.php' role='button'>Pay Now</a></p>";


                } else {

                    echo "<h1>Waiting...</h1>";

                }

            ?>
            </div>
        </div>

        <!-- bootstrap core js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    </body>

</html>
