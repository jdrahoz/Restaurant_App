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
        <title>Welcome</title>

        <!-- bootstrap core css -->
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- custom css for template -->
        <link href="navbar.css" rel="stylesheet">

    </head>

    <body>

        <!-- header -->
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <!-- title -->
                    <div class="navbar-header">
                        <a class="navbar-brand">Restaurant App</a>
                    </div>

                    <!-- group name -->
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a>Group 14</a></li>
                            <li><a href="https://github.com/jdrahoz/Restaurant_App">Project 4</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>


        <!-- main text -->
        <br>
        <div class="container">
            <div class="jumbotron">
                <?php

                    // start session
                    session_start();
                    if(!isset($_SESSION['login'])){
                        echo "\nMust Log in First.<br>";
                        echo "<a href=\"login.html\"><button>LOG IN</button></a>";
                        exit();
                    }

                    // get user
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
                    $rest_name = $row ["RestaurantName"];

                    // print restaurant name
                    echo "<h1>Welcome to $rest_name</h1>";

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
                
                <br>
                <a class="btn btn-lg btn-primary" href="menu.php" role="button">Order Now</a>

            </div>
        </div>

        <!-- bootstrap core js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    </body>

</html>
