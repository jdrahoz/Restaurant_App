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

  $page = $_SERVER['PHP_SELF'];
  $sec = "30";

?>

<html>
 <head>
  <title>Admin-Menu Alteration</title>
  <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
 </head>
 <body>


    <form action = "kitchen.php" id="done" method = "post">

    <table name="Kitchen">
        <tr>
        <td>Done?</td>
        <td>Item</td>
        <td>Alterations</td>
        <td>TableNum</td>
        </tr>

       <?php
            $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        $select = "SELECT Item,TableNum,Alterations,Price,IDNum FROM $tableName";
        $result = $mysqli -> query($select);
        $num = $result -> num_rows;

        for($i=0; $i<$num; $i++)
        {
            $row = $result -> fetch_assoc();
            $Item = $row["Item"];
            $TableNum = $row["TableNum"];
            $Alterations = $row ["Alterations"];
            $Price = $row["Price"];
            $IDNum = $row["IDNum"];



            echo "<tr>";
            echo "<td><input type='checkbox' name='kitchen[]' value=".$IDNum."></td>";
            echo "<td>$Item</td>";
            echo "<td>$Alterations</td>";
            echo "<td>$TableNum</td>";
            echo "</tr>";
        }

       $mysqli->close();

       ?>
    </table>

    <input type="submit" value="Done" >
    </form>

    <br>
    <br>
    <a href="adminFrontPage.php">Admin Homepage</a><br>

 </body>
</html>
