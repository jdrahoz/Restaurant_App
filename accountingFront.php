<html>
<body>
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
   $tableName=$username."_Accounting";

   // open mysql
   $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

   // check connection
   if ($connection === false) {
      echo "connect failed";
      exit ();
   }
   //print out the accounting table
   $query = "SELECT * FROM $tableName";
   $result = $connection->query($query);
   $num = $result -> num_rows;

   // display table of all ordered items
   $total = 0;
   echo "<table>";
   for($i=0; $i<$num; $i++)
   {
       $row = $result -> fetch_assoc();
       $Item = $row["Item"];
       $Time = $row["Time"];
       $Alterations = $row ["Alterations"];
       $Price = $row["Price"];
       $Tax = $row["Tax"];
       $TableNum = $row["TableNum"];

       $total = $total + $Price + $Tax;

       echo "<tr>";
       echo "<td>$Item</td>";
       echo "<td>$Alterations</td>";
       echo "<td>$TableNum</td>";
       echo "<td>$Price</td>";
       echo "<td>$Tax</td>";
       echo "<td>$Time</td>";
       echo "</tr>";
   }
   // display total
   echo "<tr><td colspan=3>Total</td>";
   echo "<td colspan=3>$total</td>";
   echo "</table>";

   $connection -> close();

    // add form to narrow down dates
    echo "<form id=form method=post action='accounting.php'>";
    echo "<p>start date</p><input type=date name='start'>";
    echo "<p>end date</p><input type=date name='end'>";
    echo "<input type=submit>";
    echo "<br>";
    echo "</form>";

?>

<br>
<br>
<a href="adminFrontPage.php">Admin Homepage</a><br>
</body>
</html>
