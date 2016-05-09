<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Pay</title>

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
                            <li><a>Order</a></li>
                            <li><a>Confirm</a></li>
                            <li><a>Enjoy</a></li>
                            <li class="active"><a>Pay</a></li>
							<li><a>Thanks</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>


		<!-- bill -->

        <div class="container">

            <!-- heading -->

            <div class="page-header">
                <h1>the Bill</h1>
            </div>

            <!-- column titles -->

            <div class='row'>
                <h3 class='col-md-6'><p>Item</p></h3>
                <h3 class='col-md-6'><p>Price</p></h3>
            </div>

			<?php

				// get restaurant
				$user_name = $_SESSION['login'];
				// get table number
				$table_num = $_SESSION["table_num"];

				$bill_table_name = $user_name . "_Bill_Table_" . $table_num;

				// echo form
				echo "<form id='form' method='post' action='thankYou.php'>";

				// open mysql
				$connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

				// check connection
				if ($connection === false) {
					echo "<p>connect failed</p>";
					exit ();
				}

				// get bill
				$select = "SELECT * FROM $bill_table_name";
				$result = $connection -> query ($select);
				$num = $result -> num_rows;
				$subtotal = 0;


				// get menu items with submitted quantities
				for ($i = 0; $i < $num; $i++) {

					// variables
					$row = $result -> fetch_assoc ();
					$item = $row ["Item"];
					$price = $row ["Price"];

					// echo table of items
					echo "<div class='row'>";
					echo "<div class='col-md-6'><p>$item</p></div>";
					echo "<div class='col-md-6'><p>$price</p></div>";
					echo "</div>";

					// update subtotal
					$subtotal = $subtotal + $price;

				}

				// calculate tax and total
				$tax = $subtotal * 0.09;
				$total = $subtotal + $tax;

				echo "<hr>";

				// echo subtotal
				echo "<div class='row'>";
				echo "<p class='col-md-6'>Subtotal</p>";
				echo "<p class='col-md-6'>$$subtotal</p>";
				echo "</div>";

				// echo tax
				echo "<div class='row'>";
				echo "<p class='col-md-6'>Tax</p>";
				echo "<p class='col-md-6'>$$tax</p>";
				echo "</div>";

				echo "<hr>";

				// echo total
				echo "<div class='row'>";
				echo "<h3 class='col-md-6'>Total</h3>";
				echo "<h3 class='col-md-6'>$$total</h3>";
				echo "</div>";

				echo "<hr>";

				// echo submit button
				echo "<input class='btn btn-lg btn-primary' type=submit value='Pay Now'>";

				echo "</form>";

				// close mysql
				$connection -> close ();
			?>

		</div>

    <!-- bootstrap js -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

	</body>

</html>
