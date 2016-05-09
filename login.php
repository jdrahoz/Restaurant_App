<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">

        <!-- title -->

        <title>Log In</title>

        <!-- bootstrap css -->

        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.6-dist/navbar.css" rel="stylesheet">

    </head>

    <body>

        <!-- navbar -->

        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <!-- title -->

                    <div class="navbar-header">
                        <a class='navbar-brand' href="restaurantApp.html">RestaurantApp</a>
                    </div>

                    <!-- links -->

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="login.php">Log In</a></li>
                            <li><a href="createRestaurantLogin.php">Join</a></li>
                            <li><a href="https://github.com/jdrahoz/Restaurant_App">About</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        <!-- text fields -->

        <div class="container">

            <div class="jumbotron">

                <!-- header-->

                <div class="page-header">
                    <h2>Log in now!</h2>
                    <p>Enter your username & password</p>
                </div>

                <form action="?" id="login" method="post">

                <div class="row">
                    <div class="col-md-2">Username</div>
                    <div class="col-md-2"><input type="text" name="username" ></div>
                </div>

                <div class="row">
                    <div class="col-md-2">Password</div>
                    <div class="col-md-2"><input type="password" name="password" ></div>
                </div>

                <br>

                <!-- submit button -->

                <div class="row">
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-lg btn-primary btn" value="Log In">
                    </div>
                </div>

                </form>

                <?php

                // both username and password entered
                if(isset($_POST["username"]) && isset($_POST["password"])) {

                    // start session
                    session_start();

                    // get info from form
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $accepted = false;

                    function force_input($data){
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

                    $username = force_input($username);
                    $password = force_input($password);

                    // open connection to sql
                    $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

                    // check connection
                    if ($mysqli == false)
                    {
                        echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
                        exit();
                    }

                    // check table for name
                    $select = "SELECT Password FROM Restaurants WHERE Username = '$username' LIMIT 1";
                    $result = $mysqli -> query($select);
                    //if name is in table
                    if($result -> num_rows == 0)
                    {
                        echo "<hr><p>Incorrect Username/Password</p>";
                    }
                    else{

                        $row = $result -> fetch_assoc();
                        $passFromData = $row["Password"];
                        if (password_verify($password,$passFromData) == true)
                        {
                          $accepted = true;
                        }
                        else
                        {
                            echo "<hr><p>Incorrect Username/Password</p>";
                          exit();
                        }
                    }

                    // valid username an passwod combo
                    if($accepted)
                    {
                        $_SESSION['login'] = $username;
                        header("Location:adminFrontPage.php");
                    }

                }

                ?>


            </div>
        </div>

    </body>

</html>
