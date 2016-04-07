<?php

$menuArray = $_POST["menu"];

     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }

        for($i=0; $i<count($menuArray);$i++)
        {
            $delete = "DELETE FROM Menu WHERE IDNum = '$menuArray[$i]'";
            $mysqli->query($delete);
        }

       $mysqli->close();

       header('Location: http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/MenuAlteration.html');
?>
