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
                        <a class='navbar-brand'>RestaurantApp</a>
                    </div>

                    <!-- where you are -->

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class=active href="adminFronPage"><a>Home</a></li>
                            <li><a href="maintenanceFront.php">Maintenance</a></li>
                            <li><a href="menuAlteration.php">Menu</a></li>
                            <li><a href="kitchenFront.php">Kitchen</a></li>
                            <li><a href="accountingFront.php">Accounting</a></li>
                            <li><a href="customerFrontPage.php">Customers</a></li>
                            <li><a href="logout.php">Exit</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>


        <!-- main text -->

        <div class="container">
            <div class="jumbotron">

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
                    echo "<h1>$rest</h1>";
                    echo "<h2>Hi, $user_name!</h2>";

                    // close mysql
                    $connection -> close ();
                ?>

            </div>
        </div>

        <!-- links -->

        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <h2>Maintenance</h2>
                    <p>Click here to edit some basic characteristics of your restaurant! Write a description, set a maximum number of tables, and add subcategories for your menu items.</p>
                    <p><a class="btn btn-default" href="maintenanceFront.php" role="button">Go</a></p>
                </div>

                <div class="col-md-6">
                    <h2>Menu</h2>
                    <p>Click here to edit your menu! Add and delete items, and update your most popular item.</p>
                    <p><a class="btn btn-default" href="menuAlteration.php" role="button">Go</a></p>
                </div>

            </div>
            <div class="row">

                <div class="col-md-6">
                    <h2>Kitchen</h2>
                    <p>Click here to view items that have been ordered! See what to cook, including special requests, and let customers know when their food is ready.</p>
                    <p><a class="btn btn-default" href="kitchenFront.php" role="button">Go</a></p>
                </div>

                <div class="col-md-6">
                    <h2>Accounting</h2>
                    <p>Click here to view the books! View all items, or sort by time, item, or quantity ordered.</p>
                    <p><a class="btn btn-default" href="accountingFront.php" role="button">Go</a></p>
                </div>

            </div>
            <div class="row">

                <div class="col-md-12">
                    <h2>Customers</h2>
                    <p>Click here to switch to the customer view! Here, your customers will be able to set their table number, order food, and pay for their meal.</p>
                    <p><a class="btn btn-default" href="customerFrontPage.php" role="button">Go</a></p>
                </div>

            </div>
        </div>

    </body>

</html>
