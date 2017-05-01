<?php
	// Start the session
	session_start();
	ob_start();
?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Download Customer Files</title>
	  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i" rel="stylesheet">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/datepicker.css">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
      </script>
  </head>

	<style type="text/css">
		ul, li {
			display: inline;
			cursor: pointer;
			position: relative;
			top: 8%;
		}
		div.common_header {
			margin-top: 10px;
			margin-bottom: 20px;
			position: relative;
			background-color: #660066;
			color: white;
			width: 65.5%;
			left: 20%;
			height: 35px;
			border-radius: 25px;
		}
        #admin_panel,
        #customer_po,
        #yashasvi_po,
        #search_customer,
        #search_yashasvi,
        #download_customer,
        #download_yashasvi,
        #logout {
            color: white;
            text-decoration: none;
        }
        #admin_panel,
        #customer_po,
        #yashasvi_po,
        #search_customer,
        #search_yashasvi,
        #download_customer,
        #download_yashasvi,
        #logout {
			color: #ffe6ff;
		}
	</style>

  <body>
	<div class="common_header">
		<ul>
            <li><a id="admin_panel" href="admin_panel.php">Admin Panel | </a></li>
			<li><a id="customer_po" href="customer_po.php">Customer PO Details | </a></li>
			<li><a id="yashasvi_po" href="yashasvi_po.php">Yashasvi PO Details | </a></li>
			<li><a id="search_customer" href="search_customer.php">Search Customer DB | </a></li>
			<li><a id="search_yashasvi" href="search_yashasvi.php">Search Yashasvi DB | </a></li>
            <li><a id="download_customer" href="download_list_customer.php">Download Customer Files | </a></li>
            <li><a id="download_yashasvi" href="download_list_yashasvi.php">Download Yashasvi Files | </a></li>
			<li><a id="logout" href="logout.php?logout">Sign Out</a></li>
		</ul>
	</div>
</html>

<?php
    $po_files = [];    // An array that contains all the files in the po_uploads directory
    if ($handle = opendir('customer_uploads/po_uploads')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $po_files[] = $entry;
            }
        }
    closedir($handle);
}
?>

<?php
    $quote_files = [];    // An array that contains all the files in the quote_uploads directory
    if ($handle = opendir('customer_uploads/quote_uploads')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $quote_files[] = $entry;
            }
        }
    closedir($handle);
}
?>
<?php
	// Fetch that yash_inv_number and comp_name associated with cust_attach_po filename
	define("DB_SERVER_DLOAD", "localhost");
	define("DB_USER_DLOAD", "root");
	define("DB_PASS_DLOAD", "");
	define("DB_NAME_DLOAD", "yashasvi_orders");

	// 1. Create a database connection
	$connection = mysqli_connect(DB_SERVER_DLOAD, DB_USER_DLOAD, DB_PASS_DLOAD, DB_NAME_DLOAD);
	// Test if connection succeeded
	if(mysqli_connect_errno()) {
		die("Database connection failed: " .
		mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
		);
	}

	// 2. Write query
	// Fetch cust_inv_number associated with the filename
	echo "<h1>The list of all the files in the Customer Downloads Directory:</h1>";
	echo "<h2>Click on the links below to download the files!</h2>";

	// Output the files in the Cusotmer PO Uploads folder
	echo "<h3>Click on the links below to download the Customer PO Documents!</h3>";
	echo "<table width='75%'>";
	echo "<th width=\"30%\" style=\"color: red;\">Yashasvi Invoice Number:</th><th style=\"color: red;\">Name of the file:</th><th width=\"30%\" style=\"color: red;\">Company Name:</th>";

	foreach ($po_files as $value) {
		$yash_inv_db = "SELECT yash_inv_number FROM customer_attachments WHERE ";
		$yash_inv_db .= "customer_po LIKE '$value'";

		$comp_name_db = "SELECT comp_name FROM customer_attachments WHERE ";
		$comp_name_db .= "customer_po LIKE '$value'";

		$result1 = mysqli_query($connection, $yash_inv_db);
		$result2 = mysqli_query($connection, $comp_name_db);

		$yash_invoice = mysqli_fetch_array($result1, MYSQLI_ASSOC);
		$company_name = mysqli_fetch_array($result2, MYSQLI_ASSOC);

		echo "<tr><td>";
		echo $yash_invoice['yash_inv_number'];
		echo "</td>";
		echo "<td>";
		echo "<a href=\"download_po_customer.php?link=$value\">$value</a>";
		echo "</td>";
		echo "<td>";
		echo $company_name['comp_name'];
		echo "</td>";
		echo "<tr>";
		    echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
		    echo "<style type=\"text/css\">";
		    echo "tr { position: relative; left: 20%; }";
		    echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
		    echo "td { text-align: center; }";
		    echo "</style>";
	}
	echo "</table>";
	echo "<br>";

	// Output the files in the Cusotmer Quote Uploads folder
	echo "<h3>Click on the links below to download the Customer Quote Documents!</h3>";
	echo "<table width='75%'>";
	echo "<th width=\"30%\" style=\"color: red;\">Yashasvi Invoice Number:</th><th style=\"color: red;\">Name of the file:</th><th width=\"30%\" style=\"color: red;\">Company Name:</th>";

	foreach ($quote_files as $value) {
		$yash_inv_db_quote = "SELECT yash_inv_number FROM customer_attachments WHERE ";
		$yash_inv_db_quote .= "customer_quote LIKE '$value'";

		$comp_name_db_quote = "SELECT comp_name FROM customer_attachments WHERE ";
		$comp_name_db_quote .= "customer_quote LIKE '$value'";

		$result1 = mysqli_query($connection, $yash_inv_db_quote);
		$result2 = mysqli_query($connection, $comp_name_db_quote);

		$yash_invoice = mysqli_fetch_array($result1, MYSQLI_ASSOC);
		$company_name = mysqli_fetch_array($result2, MYSQLI_ASSOC);

		echo "<tr><td>";
		echo $yash_invoice['yash_inv_number'];
		echo "</td>";
		echo "<td>";
		echo "<a href=\"download_quote_customer.php?link=$value\">$value</a>";
		echo "</td>";
		echo "<td>";
		echo $company_name['comp_name'];
		echo "</td>";
		echo "<tr>";
		    echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
		    echo "<style type=\"text/css\">";
		    echo "tr { position: relative; left: 20%; }";
		    echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
		    echo "td { text-align: center; }";
		    echo "</style>";
	}
	echo "</table>";
	echo "<br>";


	// 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>
<?php
    $quote_files = [];    // An array that contains all the files in the quote_uploads directory
    if ($handle = opendir('customer_uploads/quote_uploads')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $quote_files[] = $entry;
            }
        }
    closedir($handle);
}
?>
<!-- <!DOCTYPE html>
<html>
<body>
	<h3>Click on the links below to download the Customer PO Documents!</h3>
    <?php
        // echo "<table width='75%'>";
        // echo "<th>Name of the file:</th>";
	    //     foreach ($po_files as $value) {
	    //         echo "<tr><td>";
	    //         echo "<a href=\"download_po.php?link=$value\">$value</a>";
	    //         echo "<br>";
	    //         echo "</td></tr>";
	    //     }
		// 	echo "</table>";
		// 	echo "<br>";
		// 	echo "<h3>Click on the links below to download the Customer Quote Documents!</h3>";
	    //     echo "<table width='75%'>";
	    //     echo "<th>Name of the file:</th>";
	    //     foreach ($quote_files as $value) {
	    //         echo "<tr><td>";
	    //         echo "<a href=\"download_quote.php?link=$value\">$value</a>";
	    //         echo "<br>";
	    //         echo "</td></tr>";
	    //     }
		// 	echo "</table>";
		//
        ?>
</body>
</html> -->

<!-- <html>
<body>
    <br><br>
    <h3>A reference of the files present in the Customer Downloads!</h3>

<?php
    // define("DB_SERVER", "localhost");
    // define("DB_USER", "root");
    // define("DB_PASS", "");
    // define("DB_NAME", "yashasvi_orders");
	//
    // // 1. Create a database connection
    // $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    // // Test if connection succeeded
    // if(mysqli_connect_errno()) {
    //     die("Database connection failed: " .
    //     mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
    // );
    // }
	//
    // $query = "SELECT * FROM customer_attachments";
	//
    // // 2. Process the querys written
    // $result = mysqli_query($connection, $query);
	//
    // if ($result) {
    //     echo "<table width='75%'>";
    //     echo "<th>Customer PO File Name:</th><th>Customer Quote File Name:</th><th style=\"color: red;\">";
    //     echo "Yashasvi Invoice Number:</th><th style=\"color: red;\">Company Name:</th>";
	//
    //     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	//
    //         // Start oputputting the table here
    //         echo '<tr><td align="center">' . $row['customer_po'] . '</td><td align="left">' . $row['customer_quote'] . '</td>';
    //         echo '<td align="center" style="color: #ff3333;">' . $row['yash_inv_number'] . '</td><td align="left" style="color: #ff3333;">' . $row['comp_name'] . '</td></tr>';
    //     }
    // } else {
    //     echo "Failed to obtain data from the DB.";
    // }
    //     echo "</table>";
	//
    //     echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
    //     echo "<style type=\"text/css\">";
    //     echo "tr { position: relative; left: 20%; }";
    //     echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
    //     echo "td { text-align: center; }";
    //     echo "</style>";
	//
    // // 3. Close connection to the database
    // if (isset($connection)) { mysqli_close($connection); }
?>
</body>
</html> -->
