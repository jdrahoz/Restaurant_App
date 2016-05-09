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

// error_reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// get username
$username = $_SESSION['login'];

// get info from MenuAlteration.html
$Name = $_POST["name"];
$Ingredients = $_POST["ingredients"];
$Price = $_POST["price"];
$Subcategory = $_POST["subcategory"];

// save the image to server
$target_dir = "uploads/".$username."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}
// check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}
// check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";

    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}

// open mysql
$mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

//check connection
if ($mysqli->connect_errno)
{
    echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
    exit();
}

// get table name
$tableName=$username."_Menu";

//check table for name
$select = "SELECT * FROM $tableName WHERE Name = '$Name'";
$result = $mysqli -> query($select);

// name is in table
if ($result -> num_rows != 0)
{
    echo "<p>Name already exists</p>";
}

// if ok to add
else
{
	//add to table
    $image_name = $target_file;
    $mysqli -> query ("INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$image_name')");
}

//close sql connection
$mysqli->close();

//return to the menu alteration page
//echo '<a class="btn btn-default" href="menuAlteration.php" role="button">back to menu alteration</a><br>';
header('Location: menuAlteration.php');

?>
