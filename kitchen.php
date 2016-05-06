<?php

session_start();
 if(!isset($_SESSION['login'])){
     echo "\nMust Log in First.<br>";
     echo "<a href=\"login.html\"><button>LOG IN</button></a>";
     exit();
   }else{
     echo "Welcome, ";
     echo $_SESSION['login'];
   }

   $username=$_SESSION['login'];
   $tableName=$username."_OrdersToCook";
//retrieves kitchen array from kitchen.html
$kitchen = $_POST["kitchen"];


    //opens sql connection
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");
    //if connection fails
    if ($mysqli->connect_errno)
    {
        echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
        exit();
    }

        //increments through kitchen array
        for($i=0; $i<count($kitchen);$i++)
        {
            //Select from Orders to Cook using kitchen array
            $checkTableNum = "SELECT TableNum From $tableName WHERE IDNum = '$kitchen[$i]'";
            $result = $mysqli -> query($checkTableNum);
            $row = $result -> fetch_assoc ();
            $table_num = $row ["TableNum"];
            //creates table name
            $table_name = $username."_Bill_Table_$table_num";
            //checks to see if a table exists already
            $show = "SHOW TABLES LIKE '$table_name'";
            $result = $mysqli -> query ($show);

            //if table doesn't exist create new
            if ($result -> num_rows == 0)
            {
              //Create new table based on table number
              $create = "CREATE TABLE $table_name (Item varchar(50), TableNum int(11), Alterations varchar(250), Price double, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
              $result = $mysqli -> query ($create);
            }

            //selects information from OrdersToCook table
            $select ="SELECT Item,TableNum,Alterations,Price FROM $tableName WHERE IDNum='$kitchen[$i]'";
            $result = $mysqli ->  query($select);
            $row = $result -> fetch_assoc();
            $Item = $row["Item"];
            $TableNum = $row["TableNum"];
            $Alterations = $row["Alterations"];
            $Price = $row["Price"];

            //inserts information selected into the bill table
            $insert = "INSERT INTO $table_name (Item,TableNum,Alterations,Price) VALUES ('$Item', '$TableNum','$Alterations','$Price')";
            $mysqli -> query($insert);

            //deletes information from OrdersToCookTable
            $delete = "DELETE FROM $tableName WHERE IDNum = '$kitchen[$i]'";
            $mysqli->query($delete);
        }

        //close connection
       $mysqli->close();

       //kitchen.html refreshed after php is done
       header('Location: kitchenFront.php');
?>
