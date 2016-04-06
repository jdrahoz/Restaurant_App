<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  $user = $_POST['ownerName'];
  $pass = $_POST['ownerPass'];

  $validUser = false;
  //check empty
  if(empty($user)){
    echo"No user specified";
    exit();
  }
  //check empty post
  else if(empty($pass)){
    echo"No password specified";
    exit();
  }
  else if($user === "owner" && $pass === "pass"){
    header('Location: admin.html');
    die();

  }

?>
