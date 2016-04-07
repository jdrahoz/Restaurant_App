<?php

$menuArray = $_POST["menu"];

     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        echo "Deleted the following posts:<br>";

        for($i=0; $i<count($menuArray);$i++)
        {
            $delete = "DELETE FROM Menu WHERE IDNum = '$menuArray[$i]'";
            $mysqli->query($delete);
            echo $menuArray[$i];
        }

       $mysqli->close();


?>
