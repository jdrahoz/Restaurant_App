<html>
<head>
</head>
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
  <option>Item Counts</option>
  <option>By Price</option>
  </select>
  <button type="submit">SUBMIT</button>
</form>

<?php
  if(isset($_POST["option"])){
    $option = $_POST["option"];
    if($option == "Time"){
      echo "Result will be given Between and not Including the start and end date.";
      // add form to narrow down dates
      echo "<form id='form' method='post' action='?'>";
      echo "<p>start date</p><input type='date' name='start'>";
      echo "<p>end date</p><input type='date' name='end'>";
      echo "<input type=submit>";
      echo "<br>";
      echo "</form>";
    }
    elseif($option == "Item Counts")
    {
      echo "you selected Item Counts";
      sortByCounts();
    }elseif($option == "By Price"){
      echo "you selected By Price";
      sortByPrice();
    }
  }



  //if certain post conditions are met call various functions defined below
if(isset($_POST['start']) && isset($_POST['end']))
{
  $option = "Time";
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
  echo "<table cellpadding=\"12px\">";
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


function sortByCounts(){
  $username=$_SESSION['login'];
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

  //select count of each individual item and sort result in descending order by the count
  $query = "SELECT count(*) AS total,Item,Price FROM $tableName GROUP BY Item ORDER BY total DESC";
  $result = $connection->query($query);
  $num = $result -> num_rows;

  // print in between dates
  echo "<table cellpadding=\"12px\">";
  echo "<tr>";
  echo "<th>Count</th>";
  echo "<th>%</th>";
  echo "<th>Item</th>";
  echo "<th>Total Price</th>";
  echo "</tr>";
  $sumOfPrice = 0;
  for ($i = 0; $i < $num; $i++) {
    $row = $result -> fetch_assoc();
    $item = $row["Item"];
    $count = $row["total"];
    $price = $row["Price"];
    $percentage = $count * 100/$totalItems;
    $totalPrice = $price * $count;
    $sumOfPrice += $totalPrice;

    echo "<tr>";
    echo "<td>$count</td>";
    echo "<td>" . round($percentage,2) . "</td>";
    echo "<td>$item</td>";
    echo "<td>$totalPrice</td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td><b>total count</b></td>";
  echo "<td>$totalItems</td>";
  echo "<td><b>total price</b></td>";
  echo "<td>$sumOfPrice</td>";
  echo "</tr>";
  echo "</table>";
  $connection -> close();
}//End sortByCounts

function sortByPrice(){
  $username=$_SESSION['login'];
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
  // print in between dates
  echo "<table cellpadding=\"12px\">";
  echo "<tr>";
  echo "<th>Item</th>";
  echo "<th>totalPrice</th>";
  echo "<th>price</th>";
  echo "<th>count</th>";
  echo "</tr>";
  $sumOfPrice = 0;
  $sumOfCount = 0;
  for ($i = 0; $i < $num; $i++) {
    $row = $result -> fetch_assoc();
    $item = $row["Item"];
    $count = $row["total"];
    $totalPrice = $row ["totalPrice"];
    $price = $row["Price"];
    $sumOfPrice += $totalPrice;
    $sumOfCount += $count;

    echo "<tr>";
    echo "<td>$item</td>";
    echo "<td>$totalPrice</td>";
    echo "<td>$price</td>";
    echo "<td>$count</td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td><b>total:</b></td>";
  echo "<td>$sumOfPrice</td>";
  echo "<td><b>total:</b></td>";
  echo "<td>$sumOfCount</td>";
  echo "</tr>";
  echo "</table>";
  $connection -> close();
}//End sortByPrice

?>

<br>
<br>
<a href="adminFrontPage.php">Admin Homepage</a><br>
</body>
</html>
