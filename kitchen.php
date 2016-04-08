<?php
$kitchen = $_POST["kitchen"];
     $mysqli = new mysqli("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");
        if ($mysqli->connect_errno)
        {
            echo "printf('Connect failed: %s\n', $mysqli->connect_error)";
            exit();
        }
        for($i=0; $i<count($kitchen);$i++)
        {
            #Select from Orders to Cook using kitchen array
            $checkTableNum = "SELECT TableNum From OrdersToCook WHERE IDNum = '$kitchen[$i]'";
            $result = $mysqli -> query($checkTableNum);
           $row = $result -> fetch_assoc ();
            $table_num = $row ["TableNum"];
            $table_name = "Bill_Table_$table_num";
            $show = "SHOW TABLES LIKE '$table_name'";
            $result = $mysqli -> query ($show);
            if ($result -> num_rows == 0)
            {
              #Create new table based on table number
            $create = "CREATE TABLE $table_name (Item varchar(50), TableNum int(11), Alterations varchar(250), Price double, IDNum int(11) AUTO_INCREMENT, PRIMARY KEY (IDNum))";
            $result = $mysqli -> query ($create);
          }
            $select ="SELECT Item,TableNum,Alterations,Price FROM OrdersToCook WHERE IDNum='$kitchen[$i]'";
            $result = $mysqli ->  query($select);
            $row = $result -> fetch_assoc();
            $Item = $row["Item"];
            $TableNum = $row["TableNum"];
            $Alterations = $row["Alterations"];
            $Price = $row["Price"];
            $insert = "INSERT INTO $table_name (Item,TableNum,Alterations,Price) VALUES ('$Item', '$TableNum','$Alterations','$Price')";
            $mysqli -> query($insert);
            $delete = "DELETE FROM OrdersToCook WHERE IDNum = '$kitchen[$i]'";
            $mysqli->query($delete);
        }
       $mysqli->close();
       header('Location: http://people.eecs.ku.edu/~kstrombo/EECS_448_HTML/Restaurant_App/kitchen.html');
?>
