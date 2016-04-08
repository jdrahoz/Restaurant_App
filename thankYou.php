<?php

echo "<title>**BILL**</title>";
echo "<link href='customer.css' rel='stylesheet' type='text/css'/>";
echo "<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>";
echo "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>";

// get table number
$table_num = $_POST["table_num"];
$table_name = "Bill_Table_$table_num";

// echo header
echo "<h class=main>Thank You!</h>";
echo "<br><br><br>";
echo "<a>Have a great day.</a>";

// send rows from bill table to accounting table

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
	$item = $row ["Item"];
	$alterations = $row ["Alterations"];
	$price = $row ["Price"];
	$tax = $price * 0.09;
	$idNum = $row ["IDNum"];

	// insert into accounting table
	$insert = "INSERT INTO Accounting (Item, TableNum, Alterations, Price, Tax) VALUES ('$item', '$table_num', '$alterations', '$price', '$tax')";
	$result_2 = $connection -> query ($insert);

	// update orders in bill table
	$delete = "DELETE FROM $table_name WHERE IDNum='$idNum'";
	$result_2 = $connection -> query ($delete);

}

// close mysql
$connection -> close ();
