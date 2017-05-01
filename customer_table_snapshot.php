<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Customer Table Snapshot</title>
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
    $query = "SELECT * FROM customer_po";

    // Execute the query
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Create the table headers
        echo "<h1 style=\"text-align: center;\">Given below are all the records that can be found in the Customer Database!</h1>";
        echo "<table width='100%'>";
        echo "<tr><th>Company Name</th><th>Company Address</th><th>City</th><th>Pincode</th>";
        echo "<th>Financial Contact Person</th><th>Phone</th><th>Email</th>";
        echo "<th>Other</th><th>Order Value</th><th>Purchase Value</th><th>Margin</th>";
        echo "<th>Billing Type</th><th>Cutomer_Yash Date</th><th>Payment Mode</th>";
        echo "<th>Yash Invoice Number</th><th>Yash Invoice Value</th><th>Yash Invoice Date</th><th>Remarks</th></tr>";

		// Output the values from the table onto the screen
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            echo '<tr><td align="center">' . $row['comp_name'] . '</td><td align="left">' . $row['comp_address'] . '</td>';
            echo '<td align="center">' . $row['city'] . '</td><td align="left">' . $row['pincode'] . '</td>';
            echo '<td align="center">' . $row['fin_contact_person'] . '</td><td align="left">' . $row['phone'] . '</td>';
            echo '<td align="center">' . $row['email'] . '</td><td align="left">' . $row['other'] . '</td>';
            echo '<td align="center">' . $row['order_value'] . '</td><td align="left">' . $row['purchase_value'] . '</td>';
            echo '<td align="center">' . $row['margin'] . '</td><td align="left">' . $row['billing_type'] . '</td>';
            echo '<td align="center">' . $row['cust_yash_date'] . '</td><td align="left">' . $row['payment_mode'] . '</td>';
            echo '<td align="center">' . $row['yash_inv_number'] . '</td><td align="left">' . $row['yash_inv_value'] . '</td>';
            echo '<td align="center">' . $row['yash_inv_date'] . '</td><td align="left">' . $row['remarks'] . '</td></tr>';

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
