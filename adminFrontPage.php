<html>
<header>
  <title>Page</title>

</header>
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

  <div id="logout">
  	logout here:<br>
    <a href="logout.php"><button type="button">LOG OUT</button></a>
  </div>

  <br><br><br>
  <a href="menuAlteration.php">menu alteration</a>
  <a href="kitchen.html">kitchen</a>
  <a href="accountingFront.php">accounting</a>
  <a href="Maintenance.html">maintenance</a>
  <a href="menu.php">Customer interation</a>

</body>
</html>
