<html>
<body>
<?php

   session_start();
 if(!isset($_SESSION['login'])){
     echo "\nMust Log in First.<br>";
     echo "<a href=\"login.php\"><button>LOG IN</button></a>";
     exit();
   }else{
     echo "Welcome, ";
     echo $_SESSION['login'];
   }
?>

<form method="post" action="?">
<select name="option">
  <option>No Sort</option>
  <option>Time</option>
  <option>Popular</option>
  <option>albert</option>
  </select>
  <button type="submit">SUBMIT</button>
</form>

<?php
  if(isset($_POST["option"])){
    $option = $_POST["option"];
    if($option == "Time"){
      echo "you selected time";
      // add form to narrow down dates
      echo "<form id='form' method='post' action='?'>";
      echo "<p>start date</p><input type='date' name='start'>";
      echo "<p>end date</p><input type='date' name='end'>";
      echo "<input type=submit>";
      echo "<br>";
      echo "</form>";
    }
    elseif($option == "Popular")
    {
      echo "you selected 123123";
    }elseif($option == "something"){

    }
  }



  //if certain post conditions are met call various functions defined below
if(isset($_POST['start']) && isset($_POST['end']))
{
  sortByTime();
}

?>


<?php
if(!isset($option) || $option == "No Sort")
{
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
   echo "<table cellspacing=\"10px\">";
   echo "<caption><b>Table of Every Item Bought In Your Restaurant</b></caption>";
   echo "<tr>";
   echo "<th>Item</th>";
   echo "<th>Alterations</th>";
   echo "<th>TableNum</th>";
   echo "<th>Price</th>";
   echo "<th>Tax</th>";
   echo "<th>Time</th>";
   echo "</tr>";
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
}

function sortByTime(){
  $username=$_SESSION['login'];
  $tableName=$username."_Accounting";
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
  // print in between dates
  echo "<table cellspacing=\"10px\">";
  echo "<tr>";
  echo "<th>Item</th>";
  echo "<th>alterations</th>";
  echo "<th>tableNum</th>";
  echo "<th>price</th>";
  echo "<th>tax</th>";
  echo "<th>time</th>";
  echo "</tr>";
  for ($i = 0; $i < $num; $i++) {
    $row = $result -> fetch_assoc();
    $item = $row["Item"];
    $time = $row["theTime"];
    $alterations = $row ["Alterations"];
    $price = $row["Price"];
    $tax = $row["Tax"];
    $tableNum = $row["TableNum"];

    echo "<tr>";
    echo "<td>$item</td>";
    echo "<td>$alterations</td>";
    echo "<td>$tableNum</td>";
    echo "<td>$price</td>";
    echo "<td>$tax</td>";
    echo "<td>$time</td>";
    echo "</tr>";
  }
  echo "</table>";
  $connection -> close();
}//End sortByTime




?>

<br>
<br>
<a href="adminFrontPage.php">Admin Homepage</a><br>
</body>
</html>
