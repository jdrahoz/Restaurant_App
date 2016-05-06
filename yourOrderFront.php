<?php
session_start ();
if (!isset ($_SESSION['login'])) {
	echo "\nMust Log in First.<br>";
	echo "<a href=\"login.php\"><button>LOG IN</button></a>";
	exit ();
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->
        <title>Your Order</title>

        <!-- bootstrap core css -->
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- custom css for template -->
        <link href="navbar.css" rel="stylesheet">
        <link href="grid.css" rel="stylesheet">

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
                            <li class="active"><a>Confirm</a></li>
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

            <!-- heading -->
            <div class="page-header">
                <h1>Your Order</h1>
            </div>
            <h3>Add any requests / comments?</h3>

            <!-- column titles -->

            <br>
            <div class='row'>
                <div class='col-md-3'><p>Item</p></div>
                <div class='col-md-3'><p>Ingredients</p></div>
                <div class='col-md-3'><p>Price</p></div>
                <div class='col-md-3'><p>Requests</p></div>
            </div>
            <br>

            <!-- ordered items -->

            <form id="form" method="post" action="yourOrderSubmitted.php">

            <?php

				// get restaurant name
				$user_name = $_SESSION['login'];

                // get table number
                $table_num = $_SESSION['table_num'];
                $cart_table_name = $user_name . "_Cart_Table_" .$table_num;

                // open mysql
                $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                // check connection
                if ($connection === false) {
                    echo "connect failed";
                    exit ();
                }

                // get table of menu items
                $select = "SELECT * FROM $cart_table_name";
                $result = $connection -> query ($select);
                $num = $result -> num_rows;

                // print table of menu items
                for ($i = 0; $i < $num; $i++) {
                    $row = $result -> fetch_assoc ();
                    $item = $row ["Item"];
                    $ingredients = $row ["Ingredients"];
                    $price = $row ["Price"];
                    $idNum = $row ["IDNum"];
                    echo "<br>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-3'>".$item."</div>";
                    echo "<div class='col-md-3'>".$ingredients."</div>";
                    echo "<div class='col-md-3'>$".$price."</div>";
                    echo "<div class='col-md-3'><input type=text name=$idNum></div>";
                    echo "</div>";
                    echo "<br>";
                }

                // close mysql
                $connection -> close ();

    			// echo submit button
                echo "<br>";
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<input class='btn btn-lg btn-primary' type=submit value='Confirm'>";
                echo "</div></div></tr>";

            ?>

        </form>

    </body>

</html>
