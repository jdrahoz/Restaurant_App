<?php

// get table number
$table_num = $_GET["table_num"];
$table_name = "Table_$table_num";

// open mysql
$connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($connection === false) {
	echo "<p>connect failed</p>";
	exit ();
}

// get table of ordered items
$select = "SELECT * FROM $table_name";
$result = $connection -> query ($select);
$num = $result -> num_rows;

echo "<table>";

$total = 0;

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$name = $row ["Name"];
	$ingredients = $row ["Ingredients"];
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];

	echo "<tr>";
	echo "<td>".$name."</td>";
	echo "<td>".$price."</td>";
	echo "</tr>";

	$total = $total + $price;

}

echo "<tr><td>";
echo $total;
echo "</tr></td>";

echo "</table>";


// close mysql
$connection -> close ();

?>
