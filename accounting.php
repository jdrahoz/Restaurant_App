 <?php

    $start_date = $_POST["start"];
    $end_date = $_POST["end"];

    // open mysql
    $connection = new mysqli ("mysql.eecs.ku.edu", "jdrahoza", "Hello", "jdrahoza");

    // check connection
    if ($connection === false) {
    	echo "connect failed";
    	exit ();
    }

    // select from accounting table
    $query = "SELECT * FROM Accounting WHERE Time BETWEEN '$start_date' AND '$end_date'";
    $result = $connection->query($query);
    $num = $result -> num_rows;

    // print in between dates
    echo "<table>";
    for ($i = 0; $i < $num; $i++) {
        $row = $result -> fetch_assoc();
        $item = $row["Item"];
        $time = $row["Time"];
        $alterations = $row ["Alterations"];
        $price = $row["Price"];
        $tax = $row["Tax"];
        $tableNum = $row["TableNum"];

        echo "<tr>";
        echo "<td>$item</td>";
        echo "<td>$alterations</td>";
        echo "<td>$tableNum</td>";
        echo "<td>$price</td>";
        echo "<td>$tax</td>";
        echo "<td>$time</td>";
        echo "</tr>";

    }

    echo "</table>";

    $connection -> close();

?>
