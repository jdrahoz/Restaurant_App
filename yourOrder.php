<?php

session_start ();
if (!isset ($_SESSION['login'])) {
	echo "\nMust Log in First.<br>";
	echo "<a href=\"login.php\"><button>LOG IN</button></a>";
	exit ();
}

// get restaurant
$user_name = $_SESSION['login'];

// get table number
if ($_SESSION['table_num'] == 0) {
	$table_num = $_POST ["table_num"];
	$table_num = intval ($table_num);
	$_SESSION['table_num'] = $table_num;
}
$table_num = $_SESSION['table_num'];

// set up name for table
$cart_table_name = $user_name . "_Cart_Table_" . $table_num;

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
$show = "SHOW TABLES LIKE $cart_table_name";
$result = $connection -> query ($show);
if ($result -> num_rows == 0) {
	$create = "CREATE TABLE $cart_table_name (Item varchar (50), Ingredients varchar (250), Price double, IDNum int (11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
	$result = $connection -> query ($create);
}

// get table of menu items
$select = "SELECT * FROM " . $user_name . "_Menu";
$result = $connection -> query ($select);
$num = $result -> num_rows;

// get menu items with submitted quantities
for ($i = 0; $i < $num; $i++) {

	// variables
	$row = $result -> fetch_assoc ();
	$item = $row ["Name"];
	$ingredients = $row ["Ingredients"];
	$price = $row ["Price"];
	$idNum = $row ["IDNum"];

	// set quantity
	$quantity = $_POST [$idNum];
	$quantity = intval ($quantity);

	// insert into table by quantity
	for ($j = 0; $j < $quantity; $j++) {
		$insert = "INSERT INTO $cart_table_name (Item, Ingredients, Price) VALUES ('$item', '$ingredients', '$price')";
		$result_2 = $connection -> query ($insert);
	}

}

// close mysql
$connection -> close ();

// redirect to html file
header ("Location: yourOrderFront.php");

?>
