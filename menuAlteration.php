<html>
    <head>
        <title>Admin-Menu Alteration</title>
    </head>


 <h1>
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
   ?>

 </h1>


 <body>

  <form action="menuAlterationAdd.php" id="add" method = "post" enctype="multipart/form-data">
      Name<br>
      <input type="text" name="name" ><br>
      Ingredients<br>
      <input type="text" name="ingredients" ><br>
      Price<br>
      <input type="number" name="price" ><br>
	Subcategory<br>
      <input type="text" name="subcategory" ><br>
	Image<br>
      <input type="file" name="image" ><br>
      <input type="submit" value="Add Menu Item">
  </form>

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
          $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

      if ($mysqli->connect_errno)
      {
          echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
          exit();
      }

      $select = "SELECT IDNum,Name, Ingredients, Price,Subcategory,Image FROM Menu";
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
  		echo "<td><img src='getImage.php?id=$IDNum'></td>";
          echo "</tr>";
      }

     $mysqli->close();

     ?>
  </table>

  <input type="submit" value="Delete" >
  </form>

  <br>
  <br>
  <a href="adminFrontPage.html">Admin Homepage</a><br>

 </body>
</html>