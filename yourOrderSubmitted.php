<?php

echo "<title>**submitted**</title>";

// links for styling
echo "<link href='customer.css' rel='stylesheet' type='text/css'/>";
echo "<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>";
echo "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>";

// get table number
$table_num = $_POST["table_num"];
$table_name = "Cart_Table_$table_num";

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
header ("Location: enjoyYourMeal.html?table_num=$table_num");

// close mysql
$connection -> close ();

?>
