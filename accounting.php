 <?php

    // open mysql
    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

    // check connection
    if ($connection === false) {
    	echo "connect failed";
    	exit ();
    }
    //print out the accounting table
    $query = "SELECT * FROM Accounting";
    $result = $connection->query($query);
    $num = $result -> num_rows;




    $connection -> close();

?>
