<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Confirm</title>

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

            <!-- header -->

            <div class="page-header">
                <h1>Your Order</h1>
				<h3>Any requests / comments?</h3>
            </div>

            <!-- column titles -->

            <div class='row'>
                <h3 class='col-md-3'>Item</h3>
                <h3 class='col-md-3'>Ingredients</h3>
                <h3 class='col-md-3'>Price</h3>
                <h3 class='col-md-3'>Requests</h3>
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

					// variables
                    $row = $result -> fetch_assoc ();
                    $item = $row ["Item"];
                    $ingredients = $row ["Ingredients"];
                    $price = $row ["Price"];
                    $idNum = $row ["IDNum"];

					// echo row
                    echo "<div class='row'>";
                    echo "<div class='col-md-3'>".$item."</div>";
                    echo "<div class='col-md-3'>".$ingredients."</div>";
                    echo "<div class='col-md-3'>$".$price."</div>";
                    echo "<div class='col-md-3'><input type=text name=alter" . $idNum . "></div>";
                    echo "</div>";
                }

                // close mysql
                $connection -> close ();

            ?>


			<!--  submit button -->

			<hr>
    		<input class='btn btn-lg btn-primary' type=submit value='Confirm'>

        </form>

    </body>

</html>
