<?php
$Description = $_POST["description"];
$NumberOfTables = $_POST ["numtables"];
$Subcategory1 = $_POST ["subcategory1"];
 $Subcategory2 = $_POST ["subcategory2"];
  $Subcategory3 = $_POST ["subcategory3"];
   $Subcategory4 = $_POST ["subcategory4"];
    $Subcategory5 = $_POST ["subcategory5"];
     $Subcategory6 = $_POST ["subcategory6"];
      $Subcategory7 = $_POST ["subcategory7"];
       $Subcategory8 = $_POST ["subcategory8"];
        $Subcategory9 = $_POST ["subcategory9"];
         $Subcategory10 = $_POST ["subcategory10"];

    $restaurantName="123";
    $tableName=$restaurantName."_Maintenance";

    $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

    if ($mysqli->connect_errno)
    {
        echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
        exit();
    }

    $mysqli -> query ("UPDATE  $tableName SET Description='$Description',NumberOfTables='$NumberOfTables',Subcategory1='$Subcategory1',Subcategory2='$Subcategory2',Subcategory3='$Subcategory3',Subcategory4='$Subcategory4',Subcategory5='$Subcategory5',Subcategory6='$Subcategory6',Subcategory7='$Subcategory7',Subcategory8='$Subcategory8',Subcategory9='$Subcategory9',Subcategory10='$Subcategory10'");

    $mysqli->close();

    //header('Location: http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/Maintenance.html');

 ?>
