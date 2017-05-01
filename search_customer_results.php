<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Customer Search Results</title>
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
		$comp_name = $_POST["comp_name"];
		$city = $_POST["city"];
		$fin_contact_person = $_POST["fin_contact_person"];
		$yash_inv_number = $_POST["yash_inv_number"];
		$yash_inv_value = $_POST["yash_inv_value"];

		$subquery = "";
		if(!empty($comp_name)) {
			$subquery .= "comp_name LIKE '$comp_name'";
		}
		if (!empty($city)) {
            if ($city == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND city LIKE '$city'";
			} else {
				$subquery .= "city LIKE '$city'";
			}
		}
		if (!empty($fin_contact_person)) {
            if ($fin_contact_person == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND fin_contact_person LIKE '$fin_contact_person'";
			} else {
				$subquery .= "fin_contact_person LIKE '$fin_contact_person'";
			}
		}
		if (!empty($yash_inv_number)) {
			if ($yash_inv_number == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND yash_inv_number LIKE '$yash_inv_number'";
			} else {
				$subquery .= "yash_inv_number LIKE '$yash_inv_number'";
			}
		}
		if (!empty($yash_inv_value)) {
			if ($yash_inv_value == "empty") {
				$subquery .= "";
			} else if ($subquery != "") {
				$subquery .= " AND yash_inv_value LIKE '$yash_inv_value'";
			} else {
				$subquery .= "yash_inv_value LIKE '$yash_inv_value'";
			}
		}

		$query  = "SELECT * ";
		$query .= "FROM customer_po WHERE ";
		$query .= "$subquery";
		$result = mysqli_query($connection, $query);

		// Create the table headers
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
		echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
		echo "td { text-align: center; }";
		echo "</style>";


	} // end of the if condition checking if form has been properly submitted

    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>
