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

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Thank you!</title>

        <!-- bootstrap css -->
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="navbar.css" rel="stylesheet">

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
                            <li><a>Pay</a></li>
                            <li class=active><a>Thanks</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <br>
        <div class="container">
            <div class="jumbotron">
				<h1>Thank you!</h1>
				<br>
				<h3>Have a great day.</h3>
				<br>
				<p><a class='btn btn-lg btn-primary' href='customerFrontPage.html' role='button'>Return</a></p>

			</div>
        </div>

        <!-- bootstrap core js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    </body>

</html>
