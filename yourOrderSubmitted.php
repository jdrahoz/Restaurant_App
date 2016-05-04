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
$table_name = "$user_name_Cart_Table_$table_num";

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

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$item = $row ["Item"];
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];
	$alterations = $_POST [$idNum];

	// insert into orders to cook table
	$insert = "INSERT INTO OrdersToCook (Item, TableNum, Alterations, Price) VALUES ('$item', '$table_num', '$alterations', '$price')";
	$result_2 = $connection -> query ($insert);

	// update orders in table table
	$delete = "DELETE FROM $table_name WHERE IDNum='$idNum'";
	$result_2 = $connection -> query ($delete);

}

// redirect to html file
header ("Location: enjoyYourMeal.php");

// close mysql
$connection -> close ();

?>
