<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Welcome</title>

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
                            <li class=active><a>Welcome</a></li>
                            <li><a>Order</a></li>
                            <li><a>Confirm</a></li>
                            <li><a>Enjoy</a></li>
                            <li><a>Pay</a></li>
                            <li><a>Thanks</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <!-- main text -->

        <div class="container">
            <div class="jumbotron">
                <?php

                    // get user
                    $user_name = $_SESSION['login'];

                    // set table num to 0
                    $_SESSION['table_num'] = 0;

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

                    // print restaurant name
                    echo "<h1>Welcome to $rest</h1>";

                    // get description
                    $select = "SELECT * FROM " . $user_name . "_Maintenance";
                    $result = $connection -> query ($select);
                    $row = $result -> fetch_assoc();
                    $desc = $row ["Description"];

                    // print description
                    echo "<p>$desc</p>";

                    // close mysql
                    $connection -> close ();
                ?>

                <!-- link -->

                <hr>
                <a class="btn btn-lg btn-primary" href="menu.php" role="button">Order Now</a>

            </div>
        </div>

        <!-- bootstrap js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    </body>

</html>
