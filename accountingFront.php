<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Accounting</title>

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
                            <li><a href="kitchenFront.php">Kitchen</a></li>
                            <li class="active"><a href="accountingFront.php">Accounting</a></li>
                            <li><a href="logout.php">Exit</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <div class="container">

            <div class="page-header">
                <h1>Accounting</h1>
            </div>

            <!-- sort items -->

            <form method="post" action="?">

            <h3>Sorting Method</h3>

            <p><select name="option">
                <option>None</option>
                <option>Time</option>
                <option>Count</option>
                <option>Price</option>
            </select></p>

            <!-- submit button -->

            <br>
            <input class='btn btn-lg btn-primary' type='submit' value='Sort'>

            </form>

            <hr>

            <?php

                // get option and display accordingly
                if(isset($_POST["option"])){
                    $option = $_POST["option"];

                    // sort by time
                    if($option == "Time"){

                        // print out form to select dates to show data
                        echo "<h3>Sorting by Time</h3>";
                        echo "<p>Results given between and not including start and end date</p>";

                        // form to narrow down dates
                        echo "<form id='form' method='post' action='?'>";
                        echo "<p>start date</p>";
                        echo "<p><input type='date' name='start'>";
                        echo "<p>end date</p>";
                        echo "<p><input type='date' name='end'></p>";

                        // submit button
                        echo "<br>";
                        echo "<input class='btn btn-lg btn-primary' type='submit' value='Sort'>";
                        echo "</form>";

                    }

                    // sort by count
                    elseif ($option == "Count")
                    {
                        echo "<h3>Sorting by Item Counts</h3>";
                        sortByCounts();

                    // sort by price
                    } elseif($option == "Price"){
                        echo "<h3>Sorting by Price</h3>";
                        sortByPrice();
                    }
                }

                // sort by time if start and end variables set
                if(isset($_POST['start']) && isset($_POST['end']))
                {
                    // require start and end set before sorting
                    $option = "Time";
                    sortByTime();
                }

                // display unsorted table
                if(!isset($option) || $option == "None")
                {
                    // get username
                    $username=$_SESSION['login'];
                    $tableName=$username."_Accounting";

                    // open mysql
                    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($connection === false) {
                        echo "connect failed";
                        exit ();
                    }

                    // print out the accounting table
                    $query = "SELECT * FROM $tableName";
                    $result = $connection->query($query);
                    $num = $result -> num_rows;

                    // display table of all ordered items
                    $total = 0;
                    echo "<div class='row'>";
                    echo "<div class='col-md-3'><p>Item</p></div>";
                    echo "<div class='col-md-2'><p>Alterations</p></div>";
                    echo "<div class='col-md-1'><p>TableNum</p></div>";
                    echo "<div class='col-md-1'><p>Price</p></div>";
                    echo "<div class='col-md-1'><p>Tax</p></div>";
                    echo "<div class='col-md-2'><p>Time</p></div>";
                    echo "</div>";

                    // loop through each result row and print to table
                    for($i=0; $i<$num; $i++)
                    {
                        $row = $result -> fetch_assoc();
                        $Item = $row["Item"];
                        $Time = $row["theTime"];
                        $Alterations = $row ["Alterations"];
                        $Price = $row["Price"];
                        $Tax = $row["Tax"];
                        $TableNum = $row["TableNum"];
                        $total = $total + $Price + $Tax;
                        echo "<div class='row'>";
                        echo "<div class='col-md-3'>$Item</div>";
                        echo "<div class='col-md-2'>$Alterations</div>";
                        echo "<div class='col-md-1'>$TableNum</div>";
                        echo "<div class='col-md-1'>$Price</div>";
                        echo "<div class='col-md-1'>$Tax</div>";
                        echo "<div class='col-md-2'>$Time</div>";
                        echo "</div>";
                    }

                    // display totals
                    echo "<br>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-1 col-md-push-5'><p>Total:</p></div>";
                    echo "<div class='col-md-1 col-md-push-5'>" . round($total,2) . "</div>";
                    echo "</div>";

                   $connection -> close();

                }

                // return: void
                // parameters: none
                // print out table sorted by start time and end time

                function sortByTime(){

                    // get username
                    $username = $_SESSION['login'];

                    // get table name
                    $tableName = $username."_Accounting";

                    // get start and end from form
                    $start_date = $_POST["start"];
                    $end_date = $_POST["end"];

                    // open mysql
                    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($connection === false) {
                       exit ();
                    }

                    // select from accounting table
                    $query = "SELECT * FROM $tableName WHERE theTime BETWEEN '$start_date' AND '$end_date'";
                    $result = $connection->query($query);
                    $num = $result -> num_rows;

                    // echo table
                    echo "<div class='row'>";
                    echo "<div class='col-md-3'><p>Item</p></div>";
                    echo "<div class='col-md-2'><p>Alterations</p></div>";
                    echo "<div class='col-md-1'><p>TableNum</p></div>";
                    echo "<div class='col-md-1'><p>Price</p></div>";
                    echo "<div class='col-md-1'><p>Tax</p></div>";
                    echo "<div class='col-md-2'><p>Time</p></div>";
                    echo "</div>";

                    // loop through the rows and print out data from table
                    for ($i = 0; $i < $num; $i++) {
                        $row = $result -> fetch_assoc();
                        $item = $row["Item"];
                        $time = $row["theTime"];
                        $alterations = $row ["Alterations"];
                        $price = $row["Price"];
                        $tax = $row["Tax"];
                        $tableNum = $row["TableNum"];

                        echo "<div class='row'>";
                        echo "<div class='col-md-3'>$item</div>";
                        echo "<div class='col-md-2'>$alterations</div>";
                        echo "<div class='col-md-1'>$tableNum</div>";
                        echo "<div class='col-md-1'>$price</div>";
                        echo "<div class='col-md-1'>$tax</div>";
                        echo "<div class='col-md-2'>$time</div>";
                        echo "</div>";
                    }

                    // close mysql
                    $connection -> close();
                }

                // return: void
                // parameters: none
                // print out table sorted by count of times ordered

                function sortByCounts(){

                    // get username
                    $username=$_SESSION['login'];

                    // get table name
                    $tableName=$username."_Accounting";

                    // open mysql
                    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($connection === false) {
                       exit ();
                    }

                    // select total amount of items from accounting table
                    $select = "SELECT count(*) AS total FROM $tableName";
                    $result = $connection -> query($select);
                    $row = $result -> fetch_assoc();
                    $totalItems = $row["total"];

                    // select count of each individual item and sort result in descending order by the count
                    $query = "SELECT count(*) AS total,Item,Price FROM $tableName GROUP BY Item ORDER BY total DESC";
                    $result = $connection->query($query);
                    $num = $result -> num_rows;

                    // echo table
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'><p>Item</p></div>";
                    echo "<div class='col-md-2'><p>Count</p></div>";
                    echo "<div class='col-md-2'><p>%</p></div>";
                    echo "<div class='col-md-2'><p>Revenue</p></div>";
                    echo "</div>";
                    $sumOfPrice = 0;

                    // loop through each result row and print to table
                    for ($i = 0; $i < $num; $i++) {
                        $row = $result -> fetch_assoc();
                        $item = $row["Item"];
                        $count = $row["total"];
                        $price = $row["Price"];
                        $percentage = $count * 100/$totalItems;
                        $totalPrice = $price * $count;
                        $sumOfPrice += $totalPrice;
                        echo "<div class='row'>";
                        echo "<div class='col-md-2'>$item</div>";
                        echo "<div class='col-md-2'>$count</div>";
                        echo "<div class='col-md-2'>" . round($percentage,2) . "</div>";
                        echo "<div class='col-md-2'>$totalPrice</div>";
                        echo "</div>";

                    }

                    // display totals
                    echo "<br>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'><p>Total:</p></div>";
                    echo "<div class='col-md-2'><p>$totalItems</p></div>";
                    echo "<div class='col-md-2'><p>Total:</p></div>";
                    echo "<div class='col-md-2'><p>$sumOfPrice</p></div>";
                    echo "</div>";

                    // close mysql
                    $connection -> close();

                }

                // return: void
                // parameters: none
                // print out table sorted by count of times ordered

                function sortByPrice(){

                    // get username
                    $username=$_SESSION['login'];

                    // get table name
                    $tableName=$username."_Accounting";

                    // open mysql
                    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($connection === false) {
                       exit ();
                     }

                    // select from accounting table
                    $query = "SELECT count(*) AS total,Item,Price,Price * count(*) AS totalPrice FROM $tableName GROUP BY Item ORDER BY totalPrice DESC";
                    $result = $connection->query($query);
                    $num = $result -> num_rows;

                    // echo table
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'><p>Item</p></div>";
                    echo "<div class='col-md-2'><p>Revenue</p></div>";
                    echo "<div class='col-md-2'><p>Price</p></div>";
                    echo "<div class='col-md-2'><p>Count</p></div>";
                    echo "</div>";
                    $sumOfPrice = 0;
                    $sumOfCount = 0;

                    // loop through each result row and print to table
                    for ($i = 0; $i < $num; $i++) {
                        $row = $result -> fetch_assoc();
                        $item = $row["Item"];
                        $count = $row["total"];
                        $totalPrice = $row ["totalPrice"];
                        $price = $row["Price"];
                        $sumOfPrice += $totalPrice;
                        $sumOfCount += $count;
                        echo "<div class='row'>";
                        echo "<div class='col-md-2'>$item</div>";
                        echo "<div class='col-md-2'>$totalPrice</div>";
                        echo "<div class='col-md-2'>$price</div>";
                        echo "<div class='col-md-2'>$count</div>";
                        echo "</div>";
                    }

                    // display totals
                    echo "<br>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-2'><p>Total:</p></div>";
                    echo "<div class='col-md-2'><p>$sumOfPrice</p></div>";
                    echo "<div class='col-md-2'><p>Total:</p></div>";
                    echo "<div class='col-md-2'><p>$sumOfCount</p></div>";
                    echo "</div>";
                    echo "</table>";

                    // close mysql
                    $connection -> close();
                }

            ?>

        </div>

    </body>

</html>
