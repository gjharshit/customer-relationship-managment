<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Yashasvi Table Snapshot</title>
</head>

<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "yashasvi_orders");

    // 1. Create a database connection
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    // Test if connection succeeded
    if(mysqli_connect_errno()) {
        die("Database connection failed: " .
        mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
        );
    }

    // 2. Write down the query to execute
    $query = "SELECT * FROM yashasvi_po";

    // Execute the query
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Create the table headers
        echo "<h1 style=\"text-align: center;\">Given below are all the records that can be found in the Yashasvi Database!</h1>";
        echo "<table width='100%'>";
        echo "<tr><th>Dist Name</th><th>OEM Name</th><th>Comp Address</th>";
        echo "<th>Order Value</th><th>Purchase Value</th><th>Margin</th>";
        echo "<th>Billing Type</th><th>Payment Due</th><th>Payment Mode</th><th>Disti Inv Number</th>";
        echo "<th>Disti Inv Value</th><th>Disti Inv Date</th><th>Remarks</th></tr>";

		// Output the values from the table onto the screen
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            echo '<tr><td align="center">' . $row['dist_name'] . '</td><td align="left">' . $row['oem_name'] . '</td>';
            echo '<td align="center">' . $row['comp_address'] . '</td><td align="left">' . $row['order_value'] . '</td>';
            echo '<td align="center">' . $row['purchase_value'] . '</td><td align="left">' . $row['margin'] . '</td>';
            echo '<td align="center">' . $row['billing_type'] . '</td><td align="left">' . $row['payment_due'] . '</td>';
            echo '<td align="center">' . $row['payment_mode'] . '</td><td align="left">' . $row['disti_inv_number'] . '</td>';
            echo '<td align="center">' . $row['disti_inv_value'] . '</td><td align="left">' . $row['disti_inv_date'] . '</td>';
            echo '<td align="center">' . $row['remarks'] . '</td></tr>';

		}
		// Close the table
		echo "</table>";

		// Add custom styles to the table
		echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
		echo "<style type=\"text/css\">";
        echo "h1 { font-family: Josefin Sans; }";
		echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
		echo "td { text-align: center; }";
		echo "</style>";
    }


    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>
