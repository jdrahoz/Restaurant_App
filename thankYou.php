<?php

// start session

session_start ();
if (!isset ($_SESSION['login'])) {
	echo "<div class='container'><div class='jumbotron'>";
	echo "<h1>Oops!</h1><h2>You're not logged in.</h2>";
	echo "<hr>";
	echo "<a class='btn btn-lg btn-primary' href='login.php' role='button'>Log In</a>";
	echo "</div></div>";
	exit ();
}

// get restaurant
$user_name = $_SESSION['login'];

// get table number
$table_num = $_SESSION["table_num"];

// get table names
$bill_table_name = $user_name . "_Bill_Table_" . $table_num;
$accounting_table_name = $user_name . "_Accounting";

// open mysql
$connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($connection === false) {
	echo "<p>connect failed</p>";
	exit ();
}

// get table of ordered items
$select = "SELECT * FROM $bill_table_name";
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
	$insert = "INSERT INTO $accounting_table_name (Item, TableNum, Alterations, Price, Tax) VALUES ('$item', '$table_num', '$alterations', '$price', '$tax')";
	$result_2 = $connection -> query ($insert);

	// delete orders from bill table
	$delete = "DELETE FROM $bill_table_name WHERE IDNum='$idNum'";
	$result_2 = $connection -> query ($delete);

}

// close mysql
$connection -> close ();

// redirect to html file
header ("Location: thankYouFront.php");
