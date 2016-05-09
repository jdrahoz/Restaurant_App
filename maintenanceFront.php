<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Maintenance</title>

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
                            <li><a href="adminFrontPage.php">Home</a></li>
                            <li class="active"><a href="maintenanceFront.php">Maintenance</a></li>
                            <li><a href="menuAlteration.php">Menu</a></li>
                            <li><a href="kitchenFront.php">Kitchen</a></li>
                            <li><a href="accountingFront.php">Accounting</a></li>
                            <li><a href="logout.php">Exit</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

    <body>

        <?php

            // get username
            $username = $_SESSION['login'];

            // open mysql
            $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

            // check connection
            if ($mysqli->connect_errno)
            {
                echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
                exit();
            }

            // get table name
            $tableName = $username . "_Maintenance";

            // get maintenance table
            $select = "SELECT * FROM $tableName";
            $result = $mysqli -> query($select);
            $row = $result -> fetch_assoc();

            // get info from table
            $Description = $row["Description"];
            $NumberOfTables = $row ["NumberOfTables"];
            $Sub1 = $row ["Subcategory1"];
            $Sub2 = $row ["Subcategory2"];
            $Sub3 = $row ["Subcategory3"];
            $Sub4 = $row ["Subcategory4"];
            $Sub5 = $row ["Subcategory5"];
            $Sub6 = $row ["Subcategory6"];
            $Sub7 = $row ["Subcategory7"];
            $Sub8 = $row ["Subcategory8"];
            $Sub9 = $row ["Subcategory9"];
            $Sub10 = $row ["Subcategory10"];

            // close mysql
            $mysqli->close();

        ?>

        <!-- main maintenance information -->

        <div class="container">

            <div class="page-header">
                <h1>Maintenance</h1>
            </div>

            <form action = "maintenance.php" id="maintain" method = "post">

            <!-- description -->

            <div class="row">
                <div class="col-md-2">
                    <h3>Description</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="description" value="<?= $Description ?>">
                </div>
            </div>

            <hr>

            <!-- number of tables -->

            <div class="row">
                <div class="col-md-2">
                    <h3>Tables</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="number" name="numtables" min="1" max="50" value="<?= $NumberOfTables ?>">
                </div>
            </div>

            <hr>

            <!-- subcategories -->

            <div class="row">
                <div class="col-md-2">
                    <h3>Subcategories</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub1" value="<?= $Sub1 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub2" value="<?= $Sub2 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub3" value="<?= $Sub3 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub4" value="<?= $Sub4 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub5" value="<?= $Sub5 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub6" value="<?= $Sub6 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub7" value="<?= $Sub7 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub8" value="<?= $Sub8 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub9" value="<?= $Sub9 ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-md-push-1">
                    <input type="text" name="Sub10" value="<?= $Sub10 ?>">
                </div>
            </div>

            <hr>

            <!-- submit button -->

            <input class='btn btn-lg btn-primary' type='submit' value='Save Changes'>

            </form>

        </div>

    </body>

</html>
