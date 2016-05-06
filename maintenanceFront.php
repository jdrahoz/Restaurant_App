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
       echo "<a href=\"login.php\"><button>LOG IN</button></a>";
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

        $select = "SELECT * FROM $tableName";
        $result = $mysqli -> query($select);
        $row = $result -> fetch_assoc();
        $Description = $row["Description"];
        $NumberOfTables = $row ["NumberOfTables"];
        $Sub1 = $row ["Subcategory1"];
        $Sub2 = $row ["Subcategory2"];
        $Sub3 = $row ["Subcategory3"];
        $Sub4 = $row ["Subcategory4"];
        $Sub5 = $row ["Subcategory5"];
        $Sub6 = $row ["Subcategory6"];
        $Sub7 = $row ["Subcategory7"];
        $Sub8 = $row ["Subcategory8"];
        $Sub9 = $row ["Subcategory9"];
        $Sub10 = $row ["Subcategory10"];


         $mysqli->close();

    ?>

    <form action = "maintenance.php" id="maintain" method = "post">
      Description <input type="text" name="description" value="<?= $Description ?>"><br>
      Number of Tables <input type="number" name="numtables" min="1" max="50" value="<?= $NumberOfTables ?>"><br>
      Sub1 <input type="text" name="Sub1" value="<?= $Sub1 ?>"><br>
      Sub2 <input type="text" name="Sub2" value="<?= $Sub2 ?>"><br>
      Sub3 <input type="text" name="Sub3" value="<?= $Sub3 ?>"><br>
      Sub4 <input type="text" name="Sub4" value="<?= $Sub4 ?>"><br>
      Sub5 <input type="text" name="Sub5" value="<?= $Sub5 ?>"><br>
      Sub6 <input type="text" name="Sub6" value="<?= $Sub6 ?>"><br>
      Sub7 <input type="text" name="Sub7" value="<?= $Sub7 ?>"><br>
      Sub8 <input type="text" name="Sub8" value="<?= $Sub8 ?>"><br>
      Sub9 <input type="text" name="Sub9" value="<?= $Sub9 ?>"><br>
      Sub10 <input type="text" name="Sub10" value="<?= $Sub10 ?>"><br>

      <input type="submit" value="Save Changes">
    </form>

    <a href="adminFrontPage.php">Admin Homepage</a>

  </body>
</html>
