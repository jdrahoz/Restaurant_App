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

   $username= $_SESSION['login'];
   //opens connection to sql
    $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

       //if connection to sql fails
       if ($mysqli->connect_errno)
       {
           echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
           exit();
       }

       $tableName=$username."_Menu";
       $pop="Popular Item";

    $select="SELECT Name FROM $tableName WHERE Subcategory='Popular Item'";
    $result = $mysqli -> query($select);

    //Insert
    if($result->num_rows==0)
    {
      $tableName=$username."_Accounting";
      $accountingQuery="SELECT Item FROM $tableName GROUP BY Item ORDER BY COUNT(*) DESC LIMIT 1";
      $result = $mysqli -> query($accountingQuery);
      $row = $result -> fetch_assoc();
      $popularItem = $row["Item"];

      $tableName=$username."_Menu";

      $select="SELECT * FROM $tableName WHERE Name='$popularItem'";
      $result = $mysqli -> query($select);

          $row = $result -> fetch_assoc();
         $Name=$row['Name'];
          $Ingredients=$row['Ingredients'];
          $Price=$row['Price'];
          $Image=$row['Image'];
          $Subcategory=$pop;

      $insert="INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$Image')";
      $mysqli -> query($insert);

    }
    //Update
    else
    {
      $tableName=$username."_Accounting";
      $accountingQuery="SELECT Item FROM $tableName GROUP BY Item ORDER BY COUNT(*) DESC LIMIT 1";
      $result = $mysqli -> query($accountingQuery);
      $row = $result -> fetch_assoc();
      $popularItem = $row["Item"];

      $tableName=$username."_Menu";

      $select="SELECT * FROM $tableName WHERE Name='$popularItem'";
      $result = $mysqli -> query($select);

          $row = $result -> fetch_assoc();
         $Name=$row['Name'];
          $Ingredients=$row['Ingredients'];
          $Price=$row['Price'];
          $Image=$row['Image'];
          $Subcategory=$pop;

      $delete="DELETE FROM $tableName WHERE Subcategory='$Subcategory'";
      $mysqli -> query($delete);

      $insert="INSERT INTO $tableName (Name,Ingredients,Price,Subcategory,Image) VALUES ('$Name','$Ingredients','$Price','$Subcategory','$Image')";
      $mysqli -> query($insert);
    }

       //close sql connection
        $mysqli->close();

        //refresh html page
      header('Location: menuAlteration.php');

 ?>
