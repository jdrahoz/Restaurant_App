 <?php
 session_start();
 if(!isset($_SESSION['login'])){
     echo "\nMust Log in First.<br>";
     echo "<a href=\"login.html\"><button>LOG IN</button></a>";
     exit();
   }else{
     echo "Welcome, ";
     echo $_SESSION['login'];
   }

   $username=$_SESSION['login'];


   /opens connection to sql
    $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

       //if connection to sql fails
       if ($mysqli->connect_errno)
       {
           echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
           exit();
       }

       $tableName=$username."_Menu";

       //check table for name
       $select = "SELECT * FROM $tableName WHERE Subcategory = 'Popular Item'";
       $result = $mysqli -> query($select);
       //if name is in table
       //Update
       if($result -> num_rows != 0)
       {
         echo "<p>Name already exists</p>";
       }
       //Insert
       else
       {
         //add to table
         $mysqli -> query ("INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$image_name')");
       }

       //refresh html page
        header('Location: menuAlteration.php');
 ?>
