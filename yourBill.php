<?php

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

        <!-- meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->
        <title>Your Bill</title>

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
                        <a class="navbar-brand">Restaurant Name</a>
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
                <h1>Your Bill</h1>
            </div>

            <!-- column titles -->

            <br>
            <div class='row'>
                <div class='col-md-6'><p>Item</p></div>
                <div class='col-md-6'><p>Price</p></div>
            </div>
            <br>



			<?php

			// get restaurant
			$user_name = $_SESSION['login'];

			// get table number
			$table_num = $_SESSION["table_num"];


			$table_name = "$user_name_Bill_Table_$table_num";

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
			$select = "SELECT * FROM $table_name";
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
				echo "<br>";
				echo "<div class='row'>";
				echo "<div class='col-md-6'><p>$item</p></div>";
				echo "<div class='col-md-6'><p>$price</p></div>";
				echo "</div>";
				echo "</br>";

				// update subtotal
				$subtotal = $subtotal + $price;

			}

			// calculate tax and total
			$tax = $subtotal * 0.09;
			$total = $subtotal + $tax;

			// echo table of totals

			echo "<br><br>";
			echo "<div class='row'>";
			echo "<div class='col-md-6'><p>Subtotal</p></div>";
			echo "<div class='col-md-6'><p>$$subtotal</p></div>";
			echo "</div>";
			echo "</br>";

			echo "<div class='row'>";
			echo "<div class='col-md-6'><p>Tax</p></div>";
			echo "<div class='col-md-6'><p>$$tax</p></div>";
			echo "</div>";
			echo "</br>";

			echo "<div class='row'>";
			echo "<div class='col-md-6'><p>Total</p></div>";
			echo "<div class='col-md-6'><p>$$total</p></div>";
			echo "</div>";
			echo "</br>";


			// echo submit button
			echo "<tr><th colspan=2>";
			echo "<input class='btn btn-lg btn-primary' type=submit value='Pay'>";
			echo "</th></tr>";

			echo "</table>";
			echo "</form>";

			// close mysql
			$connection -> close ();
			?>

		</div>


    <!-- bootstrap core js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

	</body>
</html>
