<?php

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

// get table number and name
$table_num = $_SESSION["table_num"];
$cart_table_name = $user_name . "_Cart_Table_" . $table_num;

// open mysql
$connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($connection === false) {
	echo "<p>connect failed</p>";
	exit ();
}

// get table of ordered items
$select = "SELECT * FROM $cart_table_name";
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

	// get table name
	$ordersToCook_table_name = $user_name . "_OrdersToCook";

	// insert into orders to cook table
	$insert = "INSERT INTO $ordersToCook_table_name (Item, TableNum, Alterations, Price) VALUES ('$item', '$table_num', '$alterations', '$price')";
	$result_2 = $connection -> query ($insert);

	// update orders in table table
	$delete = "DELETE FROM $cart_table_name WHERE IDNum='$idNum'";
	$result_2 = $connection -> query ($delete);

}

// redirect to next file
header ("Location: enjoyYourMeal.php");

// close mysql
$connection -> close ();

?>
