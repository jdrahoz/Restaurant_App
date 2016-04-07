<?php

echo "<title>**BILL**</title>";
echo "<link href='customer.css' rel='stylesheet' type='text/css'/>";
echo "<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>";
echo "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>";

// get table number
$table_num = $_GET["table_num"];
$table_name = "Table_$table_num";

// echo header
echo "<h class=main>the Bill</h>";

// echo table
echo "<table>";
echo "<tr>";
echo "<th>item</th>";
echo "<th>price</th>";
echo "</tr>";

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
$subtotal = 0;


// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$name = $row ["Name"];
	$price = $row ["Price"];

	// echo table of ordered items
	echo "<tr>";
	echo "<td>".$name."</td>";
	echo "<td>$".$price."</td>";
	echo "</tr>";

	// update subtotal
	$subtotal = $subtotal + $price;

}

// calculate tax and total
$tax = $subtotal * 0.09;
$total = $subtotal + $tax;

// echo table
echo "<tr><td></td><td></td></tr>";
echo "<tr><th>subtotal</th>";
echo "<td>$$subtotal</td></tr>";
echo "<tr><th>tax</th>";
echo "<td>$$tax</td></tr>";
echo "<tr><th>total</th>";
echo "<td>$$total</td></tr>";
echo "</table>";

// close mysql
$connection -> close ();

?>
