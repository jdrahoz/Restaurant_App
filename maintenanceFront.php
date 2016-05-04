<html>
  <head>
    <title>Maintenance</title>
    <style></style>
  </head>
  <body>
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

         $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

         if ($mysqli->connect_errno)
         {
             echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
             exit();
         }

         $tableName=$username."_Maintenance";

         $select = "SELECT Description,NumberOfTables,Subcategory1,Subcategory2,Subcategory3,Subcategory4,Subcategory5,Subcategory6,Subcategory7,Subcategory8,Subcategory9,Subcategory10 FROM $tableName";
         $result = $mysqli -> query($select);
         $row = $result -> fetch_assoc();
         $Description = $row["Description"];
         $NumberOfTables = $row ["NumberOfTables"];
         $Subcategory1 = $row ["Subcategory1"];
          $Subcategory2 = $row ["Subcategory2"];
           $Subcategory3 = $row ["Subcategory3"];
            $Subcategory4 = $row ["Subcategory4"];
             $Subcategory5 = $row ["Subcategory5"];
              $Subcategory6 = $row ["Subcategory6"];
               $Subcategory7 = $row ["Subcategory7"];
                $Subcategory8 = $row ["Subcategory8"];
                 $Subcategory9 = $row ["Subcategory9"];
                  $Subcategory10 = $row ["Subcategory10"];


         $mysqli->close();

    ?>

    <form action = "maintenance.php" id="maintain" method = "post">
      Description <input type="text" name="description" value="<?= $Description ?>"><br>
      Number of Tables <input type="number" name="numtables" value="<?= $NumberOfTables ?>"><br>
      Subcategory1 <input type="text" name="subcategory1" value="<?= $Subcategory1 ?>"><br>
      Subcategory2 <input type="text" name="subcategory2" value="<?= $Subcategory2 ?>"><br>
      Subcategory3 <input type="text" name="subcategory3" value="<?= $Subcategory3 ?>"><br>
      Subcategory4 <input type="text" name="subcategory4" value="<?= $Subcategory4 ?>"><br>
      Subcategory5 <input type="text" name="subcategory5" value="<?= $Subcategory5 ?>"><br>
      Subcategory6 <input type="text" name="subcategory6" value="<?= $Subcategory6 ?>"><br>
      Subcategory7 <input type="text" name="subcategory7" value="<?= $Subcategory7 ?>"><br>
      Subcategory8 <input type="text" name="subcategory8" value="<?= $Subcategory8 ?>"><br>
      Subcategory9 <input type="text" name="subcategory9" value="<?= $Subcategory9 ?>"><br>
      Subcategory10 <input type="text" name="subcategory10" value="<?= $Subcategory10 ?>"><br>

      <input type="submit" value="Save Changes">
    </form>

  </body>
</html>
