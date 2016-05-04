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
    <title>Menu</title>

    <!-- bootstrap core css -->
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom css for template -->
    <link href="navbar.css" rel="stylesheet">
    <link href="grid.css" rel="stylesheet">

</head>

<h1>
  <?php
  session_start();
  if(!isset($_SESSION['login'])){
      echo "\nMust Log in First.<br>";
      echo "<a href=\"login.html\"><button>LOG IN</button></a>";
      exit();
    }
  ?>

</h1>

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

    <!-- menu -->
    <div class="container">

        <!-- form -->
        <form action="yourOrder.php" method="post" id="form">

        <!-- heading -->
        <div class="page-header">
            <h1>the Menu</h1>
            <p class="lead">Table Number : <input type='number' name='table_num' value=1 min=1 max=10></p>
        </div>
        <h3>Menu items here</h3>

        <!-- rows-->
        <?php

        // open mysql
        $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        // check connection
        if ($connection === false) {
        	echo "connect failed";
        	exit ();
        }

        $user_name = $_SESSION['login'];

		// get table of menu items
		$select = "SELECT * FROM $user_name_Menu";
		$result = $connection -> query ($select);
		$num = $result -> num_rows;

		// print table
		for ($i = 0; $i < $num; $i++) {
			$row = $result -> fetch_assoc ();
			$item = $row ["Name"];
			$ingredients = $row ["Ingredients"];
			$price = $row ["Price"];
            $idNum = $row ["IDNum"];

            // print row
            echo "<br>";
			echo "<div class='row'>";
            echo "<div class='col-md-12'>".$item."</div>";
            echo "<div class='row'>";
			echo "<div class='col-md-3'><input type='number' name=$idNum value=0 min=0 max=10></div>";
			echo "<div class='col-md-6'>".$ingredients."</div>";
			echo "<div class='col-md-3'>$".$price."</div>";
            echo "</div>";
			echo "</div>";
            echo "<br>";
		}

		// close mysql
		$connection -> close ();

        ?>

        <!--  submit button -->
        <br>
        <p class="lead">
            <input type="submit" class="btn btn-lg btn-default" value="Send to Cart">
        </p>

        </form>

        </div>

    </div>

    <!-- bootstrap core js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>

</html>
