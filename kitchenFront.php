<?php

    $page = $_SERVER['PHP_SELF'];
    $sec = "10";

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- auto refresh -->

        <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">

        <!-- title -->

        <title>Kitchen</title>

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
                            <li><a href="maintenanceFront.php">Maintenance</a></li>
                            <li><a href="menuAlteration.php">Menu</a></li>
                            <li class="active"><a href="kitchenFront.php">Kitchen</a></li>
                            <li><a href="accountingFront.php">Accounting</a></li>
                            <li><a href="logout.php">Exit</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <div class="container">

            <div class="page-header">
                <h1>Kitchen</h1>
            </div>

            <!-- orders to cook -->

            <form action = "kitchen.php" id="done" method = "post">

            <div class="row">
            <div class="col-md-1"><h3>Done?</h3></div>
            <div class="col-md-2"><h3>Item</h3></div>
            <div class="col-md-3"><h3>Alterations</h3></div>
            <div class="col-md-1"><h3>Table</h3></div>
            </div>

            <?php

                // get username
                $username = $_SESSION['login'];

                // get table name
                $tableName = $username."_OrdersToCook";

                // open mysql
                $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                // check connection
                if ($mysqli->connect_errno)
                {
                    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
                    exit();
                }

                // get table of orders to cook
                $select = "SELECT Item,TableNum,Alterations,Price,IDNum FROM $tableName";
                $result = $mysqli -> query($select);
                $num = $result -> num_rows;

                // echo orders
                for($i=0; $i<$num; $i++)
                {
                    $row = $result -> fetch_assoc();
                    $Item = $row["Item"];
                    $TableNum = $row["TableNum"];
                    $Alterations = $row ["Alterations"];
                    $Price = $row["Price"];
                    $IDNum = $row["IDNum"];
                    echo "<div class='row'>";
                    echo "<div class='col-md-1'><input type='checkbox' name='kitchen[]' value=".$IDNum."></div>";
                    echo "<div class='col-md-2'>$Item</div>";
                    echo "<div class='col-md-3'>$Alterations</div>";
                    echo "<div class='col-md-1'>$TableNum</div>";
                    echo "</div>";

                }

                $mysqli->close();

            ?>

            <hr>

            <!-- submit button -->

            <input class='btn btn-lg btn-primary' type='submit' value='Done'>

            </form>

        </div>

    </body>

</html>
