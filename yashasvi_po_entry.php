<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Yashasvi PO Entry Confirmation</title>
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

        // Data coming from basic information
        $dist_name = $_POST["dist_name"];
		// Set dist_name as a session variable
		$_SESSION["dist_name"] = $dist_name;
        $oem_name = $_POST["oem_name"];
        $comp_address = $_POST["comp_address"];

        // Data coming from product and billing details
        $order_value = $_POST["order_value"];
        $purchase_value = $_POST["purchase_value"];
        $margin = $_POST["margin"];
        $billing_type = $_POST["billing_type"];
        $payment_due = $_POST["payment_due"];
        $payment_mode = $_POST["payment_mode"];

        // Data coming from invoice details
        $disti_inv_number = $_POST["disti_inv_number"];
		// Set dist_inv_number as a session variable
		$_SESSION["disti_inv_number"] = $disti_inv_number;
        $disti_inv_value = $_POST["disti_inv_value"];
        $disti_inv_date = $_POST["disti_inv_date"];
        $remarks = $_POST["remarks"];

        // Query to insert records into the database
        $query  = "INSERT INTO yashasvi_po (";
        $query .= "dist_name, oem_name, comp_address, ";
        $query .= "order_value, purchase_value, margin, billing_type, payment_due, payment_mode, ";
        $query .= "disti_inv_number, disti_inv_value, disti_inv_date, remarks";
        $query .= ") VALUES (";
        $query .= "'$dist_name', '$oem_name', '$comp_address', ";
        $query .= "'$order_value', '$purchase_value', '$margin', '$billing_type', '$payment_due', '$payment_mode', ";
        $query .= "'$disti_inv_number', '$disti_inv_value', '$disti_inv_date', '$remarks'";
        $query .= ")";

        // 2. Query to the database
        $result = mysqli_query($connection, $query);
        print_r($result);

        if ($result) {
            // Success
            $retreive_yashasvi = "SELECT * FROM yashasvi_po ";
            $retreive_yashasvi .= "WHERE disti_inv_number LIKE $disti_inv_number";
            $yashasvi_ret_success = mysqli_query($connection, $retreive_yashasvi);

            if ($yashasvi_ret_success) {

                echo "<table width='100%'>";
                echo "<tr><th>Disti Name</th><th>OEM Name</th><th>Company Address";
                echo "<th>Order Value</th><th>Purchase Value</th><th>Margin</th>";
                echo "<th>Billing Type</th><th>Customer -> Yash Date</th><th>Payment Mode</th>";
                echo "<th>Yash Invoice Number</th><th>Yash Invoice Value</th><th>Yash Invoice Date</th>";
                echo "<th>Remarks</th></tr>";

                $row = mysqli_fetch_array($yashasvi_ret_success, MYSQLI_ASSOC);

                echo '<tr><td align="center">' . $row['dist_name'] . '</td><td align="left">' . $row['oem_name'] . '</td>';
                echo '<td align="center">' . $row['comp_address'] . '</td><td align="left">' . $row['order_value'] . '</td>';
                echo '<td align="center">' . $row['purchase_value'] . '</td><td align="left">' . $row['margin'] . '</td>';
                echo '<td align="center">' . $row['billing_type'] . '</td><td align="left">' . $row['payment_due'] . '</td>';
                echo '<td align="center">' . $row['payment_mode'] . '</td><td align="left">' . $row['disti_inv_number'] . '</td>';
                echo '<td align="center">' . $row['disti_inv_value'] . '</td><td align="left">' . $row['disti_inv_date'] . '</td>';
                echo '<td align="center">' . $row['remarks'] . '</td></tr>';

                echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
                echo "<style type=\"text/css\">";
                echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
                echo "td { text-align: center; }";
                echo "</style>";
                echo "</table>";

                mysqli_free_result($yashasvi_ret_success);
            } else {
        		// Failure
        		echo "Your query has failed.";
    			printf("Errors: %s\n", mysqli_error($connection));
    		}
        }
	}
    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>

<!-- PHP script that ensures the file is uploaded correctly -->
<?php
    echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
    echo "<style type=\"text/css\">";
    echo "html {font-family: Josefin Sans; text-align: center; }";
    echo "</style>";

    $target_dir = "yashasvi_uploads/po_uploads/";
    $target_file = $target_dir . basename($_FILES["attach_disti_po"]["name"]);
    $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Validation to check if the file is actaully a PDF
    if(isset($_POST["submit"])) {
        $check = strcmp($FileType, "pdf");
        if($check !== false) {
            echo "Validation:";
            echo "<b>The file uploaded is a PDF.</b>";
            echo "<br>";
        } else {
            echo "Validation:";
            echo "<b>The file uploaded is not a PDF.</b>";
            echo "<br>";
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Error:";
        echo "<b>Sorry, the file already exists.</b>";
        echo "<br>";
    }
    // Check file size
    if ($_FILES["attach_disti_po"]["size"] > 50000000) {
        echo "Error:";
        echo "<b>Sorry, your file is too large.</b>";
        echo "<br>";
    }
    // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["attach_disti_po"]["tmp_name"], $target_file)) {
        echo "Result:";
        echo "<b>The file ". basename( $_FILES["attach_disti_po"]["name"]). " has been uploaded.</b>";
        echo "<br>";
    } else {
        echo "<b>Sorry, there was an error uploading your file.</b>";
        echo "<br>";
    }
?>

<?php
	$target_dir = "yashasvi_uploads/quote_uploads/";
	$target_file = $target_dir . basename($_FILES["attach_disti_quote"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["attach_disti_quote"]["tmp_name"]);
	    if($check !== false) {
			echo "<br>";
	        echo "<b>File is an image - " . $check["mime"] . ".</b>";
	        $uploadOk = 1;
			echo "<br>";
	    } else {
			echo "<br>";
	        echo "File is not an image.";
	        $uploadOk = 0;
			echo "<br>";
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Check file size
	if ($_FILES["attach_disti_quote"]["size"] > 50000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
		echo "<br>";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["attach_disti_quote"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["attach_disti_quote"]["name"]). " has been uploaded.";
			echo "<br>";
			$disti_inv_number = $_SESSION["disti_inv_number"];
			$disti_po_name = basename($_FILES["attach_disti_po"]["name"]);
			$disti_quote_name = basename($_FILES["attach_disti_quote"]["name"]);
			$yashasvi_file_query = "INSERT INTO yashasvi_attachments (";
			$yashasvi_file_query .= "yashasvi_po, yashasvi_quote, disti_inv_number, dist_name) VALUES (";
			$yashasvi_file_query .= "'$disti_po_name', '$disti_quote_name', '$disti_inv_number', '$dist_name')";
			// echo $yashasvi_file_query;

			define("DB_SERVER2", "localhost");
			define("DB_USER2", "root");
			define("DB_PASS2", "");
			define("DB_NAME2", "yashasvi_orders");

		    // 1. Create a database connection
		    $connection = mysqli_connect(DB_SERVER2, DB_USER2, DB_PASS2, DB_NAME2);
		    // Test if connection succeeded
		    if(mysqli_connect_errno()) {
		        die("Database connection failed: " .
		        mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
		        );
		    }

			// 2. Process the query written above
			$result = mysqli_query($connection, $yashasvi_file_query);

			// if ($result) {
			// 	echo "Data successfully entered the database!";
			// } else {
			// 	echo "Data not entered the database. Please try again.";
			// }

			// 3. Close connection to the database
			if (isset($connection)) { mysqli_close($connection); }

	    } else {
	        echo "Sorry, there was an error uploading your file.";
			echo "<br>";
	    }
	}
?>
