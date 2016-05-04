<?php

session_start ();
if (!isset ($_SESSION['login'])) {
	echo "\nMust Log in First.<br>";
	echo "<a href=\"login.html\"><button>LOG IN</button></a>";
	exit ();
}

// get restaurant
$user_name = $_SESSION['login'];

// get table number
$table_num = $_SESSION["table_num"];

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
	$insert = "INSERT INTO $user_name_Accounting (Item, TableNum, Alterations, Price, Tax) VALUES ('$item', '$table_num', '$alterations', '$price', '$tax')";
	$result_2 = $connection -> query ($insert);

	// update orders in bill table
	$delete = "DELETE FROM $user_name_Bill_Table_$table_num WHERE IDNum='$idNum'";
	$result_2 = $connection -> query ($delete);

}

// close mysql
$connection -> close ();

// redirect to html file
header ("Location: thankYouFront.php");
