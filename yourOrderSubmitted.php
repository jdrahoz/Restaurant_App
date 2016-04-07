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

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$name = $row ["Name"];
	$ingredients = $row ["Ingredients"];
	$alterations = "";
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];
	$ordered = $row ["Ordered"];

	// insert into orders to cook table
	$insert = "INSERT INTO OrdersToCook (Item, TableNum, Alterations, Price, IDNum) VALUES ('$name', '$table_num', '$alterations', '$price', '$idNum')";
	$result_2 = $connection -> query ($insert);

}

echo "your order has been submitted";

echo "<br>";
echo "<a href=/~jdrahoza/subdir/eecs448/proj03/enjoyYourMeal.html?table_num=$table_num>food is here</a>";

// close mysql
$connection -> close ();

?>
