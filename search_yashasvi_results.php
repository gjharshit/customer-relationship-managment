<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Yashasvi Search Results</title>
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

    if (isset($_POST['submit'])) {
	    // Process the form

		// Collect all the values coming from the form
		$dist_name = $_POST["dist_name"];
		$oem_name = $_POST["oem_name"];
		$disti_inv_number = $_POST["disti_inv_number"];

		$subquery = "";
		if(!empty($dist_name)) {
			$subquery .= "dist_name LIKE '$dist_name'";
		}
		if (!empty($oem_name)) {
            if ($oem_name == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND oem_name LIKE '$oem_name'";
			} else {
				$subquery .= "oem_name LIKE '$oem_name'";
			}
		}
		if (!empty($disti_inv_number)) {
            if ($disti_inv_number == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND disti_inv_number LIKE '$disti_inv_number'";
			} else {
				$subquery .= "disti_inv_number LIKE '$disti_inv_number'";
			}
		}

		$query  = "SELECT * ";
		$query .= "FROM yashasvi_po WHERE ";
		$query .= "$subquery";
		$result = mysqli_query($connection, $query);

		// Create the table headers
        echo "<table width='100%'>";
        echo "<tr><th>Disti Name</th><th>OEM Name</th><th>Company Address";
        echo "<th>Order Value</th><th>Purchase Value</th><th>Margin</th>";
        echo "<th>Billing Type</th><th>Customer -> Yash Date</th><th>Payment Mode</th>";
        echo "<th>Yash Invoice Number</th><th>Yash Invoice Value</th><th>Yash Invoice Date</th>";
        echo "<th>Remarks</th></tr>";

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
		echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
		echo "td { text-align: center; }";
		echo "</style>";
	} // end of the if condition checking if form has been properly submitted

    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>
