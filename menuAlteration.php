<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta  -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Menu</title>

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
                            <li class="active"><a href="menuAlteration.php">Menu</a></li>
                            <li><a href="kitchenFront.php">Kitchen</a></li>
                            <li><a href="accountingFront.php">Accounting</a></li>
                            <li><a href="customerFrontPage.php">Customers</a></li>
                            <li><a href="logout.php">Exit</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <?php

            // get username
            $username=$_SESSION['login'];

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

            // get table of subcategories
            $select = "SELECT Subcategory1,Subcategory2,Subcategory3,Subcategory4,Subcategory5,Subcategory6,Subcategory7,Subcategory8,Subcategory9,Subcategory10 FROM $tableName";
            $result = $mysqli -> query($select);
            $num = $result -> num_rows;
            $row = $result -> fetch_assoc();

            // get subcategories from table
            $Subcategory1 = $row["Subcategory1"];
            $Subcategory2 = $row["Subcategory2"];
            $Subcategory3 = $row["Subcategory3"];
            $Subcategory4 = $row["Subcategory4"];
            $Subcategory5 = $row["Subcategory5"];
            $Subcategory6 = $row["Subcategory6"];
            $Subcategory7 = $row["Subcategory7"];
            $Subcategory8 = $row["Subcategory8"];
            $Subcategory9 = $row["Subcategory9"];
            $Subcategory10 = $row["Subcategory10"];

            // create array of subcategories
            $sub = array($Subcategory1,$Subcategory2,$Subcategory3,$Subcategory4,$Subcategory5,$Subcategory6,$Subcategory7,$Subcategory8,$Subcategory9,$Subcategory10);

        ?>

        <div class="container">

            <!-- header -->

            <div class="page-header">
                <h1>Menu Alteration</h1>
            </div>

            <!-- add to menu -->

            <form action="menuAlterationAdd.php" id="add" method = "post" enctype="multipart/form-data">

            <h3>Add Items to Menu</h3>

            <p>Name</p>
            <p><input type="text" name="name" required></p>

            <p>Ingredients</p>
            <p><input type="text" name="ingredients" required></p>

            <p>Price</p>
            <p><input type="number" name="price" step="any" min="0" max="200"></p>

            <p>Subcategory</p>
            <p><select name="subcategory">
            <?php
                $subLength=count($sub);
                for($i=0;$i<$subLength;$i++)
                {
                    if($sub[$i]!="")
                    {
                        echo "<option value='$sub[$i]'>$sub[$i]</option>";
                    }
                }
            ?>
            </select></p>

            <p>Image</p>
            <p><input type="file" name="fileToUpload"></p>

            <!-- submit button -->

            <br>
            <input class='btn btn-lg btn-primary' type='submit' value='Add Item'>
            </form>

            <hr>

            <!-- update popular item -->

            <form action="menuAlterationPopular.php" id="popular" method = "post">

            <h3>Add/Update Popular Item</h3>

            <!-- submit button -->

            <br>
            <input class='btn btn-lg btn-primary' type='submit' value='Add/Update'>
            </form>

            <hr>

            <!-- delete from menu -->

            <form action = "menuAlterationDelete.php" id="delete" method = "post">

            <h3>Delete Items from Menu</h3>

            <div class="row">
            <div class="col-md-1"><p>Delete?</p></div>
            <div class="col-md-2"><p>Item</p></div>
            <div class="col-md-2"><p>Subcategory</p></div>
            <div class="col-md-2"><p>Ingredients</p></div>
            <div class="col-md-1"><p>Price</p></div>
            <div class="col-md-2"><p>Image</p></div>

            </div>

            <?php

                // get table name
                $tableName = $username . "_Menu";

                // get table of menu items
                $select = "SELECT IDNum,Name, Ingredients, Price,Subcategory,Image FROM $tableName";
                $result = $mysqli -> query($select);
                $num = $result -> num_rows;

                // echo table of menu items
                for($i=0; $i<$num; $i++)
                {
                    $row = $result -> fetch_assoc();
                    $IDNum = $row["IDNum"];
                    $Name = $row ["Name"];
                    $Ingredients = $row["Ingredients"];
                    $Price = $row["Price"];
		            $Subcategory = $row["Subcategory"];
                    $Image = $row["Image"];
                    echo "<div class='row'>";
                    echo "<div class='col-md-1'><input type='checkbox' name='menu[]' value=".$IDNum."></div>";
                    echo "<div class='col-md-2'>$Name</div>";
                    echo "<div class='col-md-2'>$Subcategory</div>";
                    echo "<div class='col-md-2'>$Ingredients</div>";
                    echo "<div class='col-md-1'>$Price</div>";
                    echo "<div class='col-md-2'><img src='$Image' height='100' width='100'></div>";
                    echo "</div>";
                }

                // close mysql
                $mysqli->close();

            ?>

            <!-- submit button -->

            <br>
            <input class='btn btn-lg btn-primary' type='submit' value='Delete Items'>
            </form>

        </div>

    </body>

</html>
