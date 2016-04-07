<?php

echo "<title>**submitted**</title>";
echo "<link href='customer.css' rel='stylesheet' type='text/css'/>";
echo "<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>";
echo "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>";

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

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$name = $row ["Name"];
	$alterations = "";
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];

	// insert into orders to cook table
	$insert = "INSERT INTO OrdersToCook (Item, TableNum, Alterations, Price) VALUES ('$name', '$table_num', '$alterations', '$price')";
	$result_2 = $connection -> query ($insert);

}

echo "<h>Your order</h> <p>has been submitted!</p>";
echo "<br>";

// redirect link
echo "<a href=/~jdrahoza/subdir/eecs448/proj03/enjoyYourMeal.html?table_num=$table_num>food is here?</a>";


// close mysql
$connection -> close ();

?>
