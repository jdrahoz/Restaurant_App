<html>
    <head>
        <title>Admin-Menu Alteration</title>
    </head>


 <h1>
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
   ?>

 </h1>

 <?php
   $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

  if ($mysqli->connect_errno)
  {
   echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
   exit();
  }

  $tableName=$username."_Maintenance";

  $select = "SELECT Subcategory1,Subcategory2,Subcategory3,Subcategory4,Subcategory5,Subcategory6,Subcategory7,Subcategory8,Subcategory9,Subcategory10 FROM $tableName";
  $result = $mysqli -> query($select);
  $num = $result -> num_rows;

      $row = $result -> fetch_assoc();
      $Subcategory1 = $row["Subcategory1"];
      $Subcategory2 = $row["Subcategory2"];
      $Subcategory3 = $row["Subcategory3"];
      $Subcategory4 = $row["Subcategory4"];
      $Subcategory5 = $row["Subcategory5"];
      $Subcategory6 = $row["Subcategory6"];
      $Subcategory7 = $row["Subcategory7"];
      $Subcategory8 = $row["Subcategory8"];
      $Subcategory9 = $row["Subcategory9"];
      $Subcategory10 = $row["Subcategory10"];

      $sub = array($Subcategory1,$Subcategory2,$Subcategory3,$Subcategory4,$Subcategory5,$Subcategory6,$Subcategory7,$Subcategory8,$Subcategory9,$Subcategory10);
?>


 <body>
   <h2>Add items to your menu</h2>
  <form action="menuAlterationAdd.php" id="add" method = "post" enctype="multipart/form-data">
      Name<br>
      <input type="text" name="name" required><br>
      Ingredients<br>
      <input type="text" name="ingredients" required><br>
      Price<br>
      <input type="number" name="price" required><br>
	     Subcategory<br>
      <select name="subcategory">
        <?php
          $subLength=count($sub);
          for($i=0;$i<$subLength;$i++)
          {
            if($sub[$i]!="")
            {
              echo "<option value='$sub[$i]'>$sub[$i]</option>";
            }
          }
        ?>
      </select>
	     Image<br>
      <input type="file" name="image" ><br>
      <input type="submit" value="Add Menu Item">
  </form>

  <h2>Add/Update popular item to menu</h2>
  <form action="menuAlterationPopular.php" id="popular" method = "post">
    <input type="submit" value="Add/Update popular item">
  </form>

  <h2>Delete items from your menu</h2>
  <form action = "menuAlterationDelete.php" id="delete" method = "post">

  <table name="Menu">
      <tr>
      <td>Delete?</td>
      <td>Name</td>
      <td>Ingredients</td>
      <td>Price</td>
	<td>Subcategory</td>
	<td>Image</td>
      </tr>

     <?php
      $tableName=$username."_Menu";

      $select = "SELECT IDNum,Name, Ingredients, Price,Subcategory,Image FROM $tableName";
      $result = $mysqli -> query($select);
      $num = $result -> num_rows;

      for($i=0; $i<$num; $i++)
      {
          $row = $result -> fetch_assoc();
          $IDNum = $row["IDNum"];
          $Name = $row ["Name"];
          $Ingredients = $row["Ingredients"];
          $Price = $row["Price"];
  		$Subcategory = $row["Subcategory"];

          echo "<tr>";
          echo "<td><input type='checkbox' name='menu[]' value=".$IDNum."></td>";
          echo "<td>$Name</td>";
          echo "<td>$Ingredients</td>";
          echo "<td>$Price</td>";
  		    echo "<td>$Subcategory</td>";
          echo "<td><img src='getImage.php?id=$IDNum'></td>";//this is where to retrieve link
          echo "</tr>";
      }

     $mysqli->close();

     ?>
  </table>

  <input type="submit" value="Delete" >
  </form>

  <br>
  <br>
  <a href="adminFrontPage.php">Admin Homepage</a><br>

 </body>
</html>
