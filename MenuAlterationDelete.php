 <?php

 //Grab checked items from MenuAlteration.html
  $menuArray = $_POST["menu"];

//opens sql connection
  $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");
      //if sql connection fails
     if ($mysqli->connect_errno)
     {
         echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
         exit();
     }

     //deletes the rows from Menu table that match in the menuArray
     for($i=0; $i<count($menuArray);$i++)
     {
         $delete = "DELETE FROM Menu WHERE IDNum = '$menuArray[$i]'";
         $mysqli->query($delete);
     }

     //close sql connection
      $mysqli->close();

      //refresh html page
       header('Location: http://people.eecs.ku.edu/~jdrahoza/subdir/eecs448/proj03/MenuAlteration.html');
  ?>
