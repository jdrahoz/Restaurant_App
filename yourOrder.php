<?php

// get submitted table number
$table_num = $_POST ["table_num"];
$table_num = intval ($table_num);

// set up name for table
$table_name = "Table_$table_num";

// open mysql
$connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

// check connection
if ($connection === false) {
	echo "connect failed";
	exit ();
}

// create new table for table
if ($table_num == 0) {
	exit ();
}
$show = "SHOW TABLES LIKE $table_name";
$result = $connection -> query ($show);
if ($result -> num_rows == 0) {
	$create = "CREATE TABLE $table_name (Name varchar (50), Ingredients varchar (250), Price double, IDNum int (11))";
	$result = $connection -> query ($create);
}

// get table of menu items
$select = "SELECT * FROM Menu";
$result = $connection -> query ($select);
$num = $result -> num_rows;

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$name = $row ["Name"];
	$ingredients = $row ["Ingredients"];
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];

	// set quantity
	$quantity = $_POST [$idNum];
	$quantity = intval ($quantity);

	// insert into table by quantity
	for ($j = 0; $j < $quantity; $j++) {
		$insert = "INSERT INTO $table_name (Name, Ingredients, Price, IDNum) VALUES ('$name', '$ingredients', '$price', '$idNum')";
		$result_2 = $connection -> query ($insert);
	}

}

// close mysql
$connection -> close ();


// redirect to html file
header ("Location: /~jdrahoza/subdir/eecs448/proj03/yourOrder.html");

?>
